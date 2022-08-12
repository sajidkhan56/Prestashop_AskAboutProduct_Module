<?php
 

include_once _PS_ROOT_DIR_ . '/modules/productquery/classes/MyModal.php';

class ProductQueryFormDataModuleFrontController extends ModuleFrontController {
	//sending data to the modal class for storing
	public function postProcess() {
		$object = new MyModal();
		$question = Tools::getvalue('textarea');
		$name = Tools::getvalue('text');
		$email = Tools::getvalue('email');
		$number = Tools::getvalue('number');
		$check = Tools::getvalue('checkbox');
		$receiveremail = Configuration::get('PS_SHOP_EMAIL');
		$this->module->sendEmail($receiveremail, $question);

		$object->name = $name;
		$object->email = $email;
		$object->phone = $number;
		$object->question = $question;
		$object->checkbox = $check;
		$object->save();

	}
}
