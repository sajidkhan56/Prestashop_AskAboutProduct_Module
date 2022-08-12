<?php
 
class MyModal extends ObjectModel {

//tables columns
	public $name;
	public $email;
	public $phone;
	public $question;
	public $answer;
	public $checkbox;
	public $mail_counter = 0;

	public static $definition = [
		'table' => 'ask_about_product',
		'primary' => 'id_ask_about_product',
		'multilang' => false,
		'fields' => [
			'name' => ['type' => self::TYPE_STRING, 'validate' => 'isName', 'size' => 255],
			'email' => ['type' => self::TYPE_STRING, 'validate' => 'isEmail'],
			'phone' => ['type' => self::TYPE_INT, 'validate' => 'isPhoneNumber'],
			'question' => ['type' => self::TYPE_STRING, 'validate' => 'isGenericName'],
			'answer' => ['type' => self::TYPE_STRING],
			'checkbox' => ['type' => self::TYPE_INT],
			'mail_counter' => ['type' => self::TYPE_INT],

		],

	];

	//sending all records renderlist in backoffice
	public static function allRecords() {
		$sql = new DbQuery();
		$sql->select('*');
		$sql->from('ask_about_product');
		return Db::getInstance()->executeS($sql);
	}

}
