<?php
 

if (!defined('_PS_VERSION_')) {
	exit;
}

class AdminReplyController extends ModuleAdminController {
	//to make renderlist and helper form
	public function __construct() {
		$this->table = 'ask_about_product';
		$this->className = 'MyModal';
		$this->identifier = 'id_ask_about_product';
		$this->bootstrap = true;

		parent::__construct();

		$this->fields_list = array(
			'name' => array(
				'title' => $this->l('Name'),
				'width' => 'auto',
				'type' => 'text',
				'search' => false,
			),
			'email' => array(
				'title' => $this->l('Email'),
				'width' => 'auto',
				'type' => 'text',
				'search' => false,
			),
			'phone' => array(
				'title' => $this->l('Phone'),
				'width' => 'auto',
				'type' => 'text',
				'search' => false,
			),
			'question' => array(
				'title' => $this->l('Question'),
				'width' => 'auto',
				'type' => 'text',
				'search' => false,
			),
			'mail_counter' => array(
				'title' => $this->l('Email Counter'),
				'width' => 'auto',
				'type' => 'text',
				'search' => false,
			),

		);
		$this->fields_form = [
			'legend' => [
				'title' => $this->l('Reply Form'),
			],

			'input' => [
				[
					'type' => 'hidden',
					'name' => 'email',
				],
				[
					'type' => 'hidden',
					'name' => 'question',
				],
				[
					'type' => 'text',
					'label' => $this->l('Email'),
					'name' => 'email',
					'disabled' => true,

				],
				[
					'type' => 'text',
					'label' => $this->l('Question'),
					'name' => 'question',
					'disabled' => true,

				],
				[
					'type' => 'textarea',
					'autoload_rte' => true,
					'label' => $this->l('Answer'),
					'name' => 'answer',
					'required' => true,

				],
				[
					'type' => 'checkbox',
					'label' => $this->l(''),
					'name' => 'send_email',
					'values' => [
						'query' => [
							[
								'check_id' => '1',
								'name' => $this->l('Send email to customer'),
								'val' => '1',

							],

						],
						'id' => 'check_id',
						'name' => 'name',

					],
				],

			],
			'submit' => [

				'title' => $this->l('Save'),

			],
		];

	}
	//making of buttons
	public function renderList() {
		$this->addRowAction('edit');
		$this->addRowAction('delete');
		return parent::renderList();
	}
	//getting values
	public function postProcess() {
		parent::postProcess();

		$object = $this->loadObject(true);

		if (Tools::isSubmit('submitAddask_about_product')) {
			$receiveremail = Tools::getValue('email');
			$question = Tools::getValue('question');
			$answer = Tools::getValue('answer');

			if (Tools::getIsset('send_email_1')) {

				if ($this->module->sendEmail($receiveremail, $question, $answer)) {
					$object->mail_counter = $object->mail_counter + 1;
					$object->update();

				}
			}

		}

	}

}
