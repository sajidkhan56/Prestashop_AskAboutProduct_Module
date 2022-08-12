<?php
 

if (!defined('_PS_VERSION_')) {
	exit;
}

include_once _PS_ROOT_DIR_ . '/modules/productquery/classes/MyModal.php';

class ProductQuery extends Module {

	public function __construct() {
		$this->name = 'productquery';
		$this->version = '1.0.0';
		$this->author = 'Sajid Khan';
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Ask About Product');
		$this->description = $this->l('This module is use for to ask questions about any product');
		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
		if (!Configuration::get('MYMODULE_NAME')) {
			$this->warning = $this->l('No name provided');
		}

	}

	public function install() {
		if (Shop::isFeatureActive()) {
			Shop::setContext(Shop::CONTEXT_ALL);
		}
		include_once $this->local_path . 'sql/Install.php';
		return (parent::install() && $this->registerHook('header') && $this->registerHook('displayReassurance') && $this->registerHook('extraleft') && $this->createTablink());
	}

	public function uninstall() {
		include_once $this->local_path . 'sql/Uninstall.php';
		return (parent::uninstall() && $this->uninstallTab());
	}
	//for uninstall tab in backoffice
	public function uninstallTab() {
		$id_tab = (int) Tab::getIdFromClassName('AdminReply');
		$id_tab_parent = (int) Tab::getIdFromClassName('AdminReplyParent');
		$tab = new Tab($id_tab);
		$tab_parent = new Tab($id_tab_parent);
		return $tab->delete() && $tab_parent->delete();
	}
	//displaying form in product page in prestashop 1.6
	public function hookExtraleft() {

		$selected_categories = explode(",", Configuration::get('SELECTED_CATEGORIES'));
		$id_product = (int) Tools::getValue('id_product');
		$product_categories = product::getProductCategories($id_product);

		$result = array_intersect($selected_categories, $product_categories);
		$result = array_values($result);

		if (_PS_VERSION_ >= '1.6') {

			$this->context->smarty->assign($version = _PS_VERSION_);
		}
		if ($result) {
			return $this->display(__FILE__, 'ProductQuery.tpl');
		}

	}

	//displaying form in product page in prestashop 1.7
	public function hookDisplayReassurance() {

		$selected_categories = explode(",", Configuration::get('SELECTED_CATEGORIES'));
		$id_product = (int) Tools::getValue('id_product');
		$product_categories = product::getProductCategories($id_product);

		$result = array_intersect($selected_categories, $product_categories);
		$result = array_values($result);

		if (Dispatcher::getInstance()->getController() == 'product') {
			if (_PS_VERSION_ >= '1.7') {
				$this->context->smarty->assign(['version' => $version = _PS_VERSION_]);
			}
			if ($result) {
				return $this->display(__FILE__, 'ProductQuery.tpl');
			}
		}

	}
	//including files in header
	public function hookHeader() {

		$this->context->controller->addJS($this->_path . 'views/js/File.js');
		$this->context->controller->addCSS($this->_path . 'views/css/File.css');
		Media::addJsDef(array('mylink' => Context::getContext()->link->getModuleLink('productquery', 'FormData', array('ajax' => true))));

	}

	public function getContent() {
		if (Tools::isSubmit('submit' . $this->name)) {

			$categories_values = Tools::getValue('categories');
			Configuration::updateValue('SELECTED_CATEGORIES', implode(",", $categories_values));

		}

		return $this->displayForm();

	}
	//helper form
	public function displayForm() {
		$already_selected_categories = explode(",", Configuration::get('SELECTED_CATEGORIES'));
		$form = [
			'form' => [
				'legend' => [
					'icon' => 'icon-cogs',
					'title' => $this->l('Settings'),
				],
				'input' => [
					[
						'type' => 'categories',
						'tab' => 'spain',
						'label' => $this->l('Categories'),
						'name' => 'categories',
						'tree' => array(
							'id' => 'spain-categories-tree',
							'selected_categories' => $already_selected_categories,
							'use_checkbox' => true,
							'use_search' => false,
						),
					],
				],
				'submit' => [
					'title' => $this->l('Save'),
					'class' => 'btn btn-default pull-right',
				],

			],
		];

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$helper->identifier = $this->identifier;
		$helper->name_controller = $this->name;
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) .
		'&configure=' . $this->name .
		'&tab_module=' . $this->tab .
		'&module_name=' . $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->submit_action = 'submit' . $this->name;
		$helper->show_cancel_button = true;
		return $helper->generateForm([$form]);

	}
	//for tab link
	public function createTablink() {
		$tab = new Tab();
		foreach (Language::getLanguages() as $lang) {
			$tab->name[$lang['id_lang']] = $this->l('Product Query');
		}
		$tab->class_name = 'AdminReply';
		$tab->module = $this->name;
		$tab->parent_class_name = 'AdminCatalog';
		$tab->id_parent = (int) Tab::getIdFromClassName('AdminCatalog');
		$tab->add();
		return true;
	}

	public function sendEmail($receiveremail, $question, $answer = '') {

		return (bool) Mail::Send(
			$this->context->language->id,
			'replymessage',
			$this->l('Your query answer'),
			array(
				'{question}' => $question,
				'{answer}' => $answer,
			),
			$receiveremail, // receiver email address
			'user', //receiver name
			Configuration::get('PS_SHOP_EMAIL'),
			Configuration::get('PS_SHOP_NAME'),
			NULL, //file attachment
			NULL, //mode smtp
			_PS_MODULE_DIR_ . 'productquery/mails' //custom template path
		);
	}
}
