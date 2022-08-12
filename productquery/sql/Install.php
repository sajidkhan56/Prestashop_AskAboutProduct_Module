<?php
 

$sqls = array();
$sqls[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ask_about_product` (
    `id_ask_about_product` int(11) AUTO_INCREMENT,
    `name`   varchar(50),
    `email`  varchar(255),
    `phone`  varchar(20),
    `question`text,
    `answer`  text,
    `checkbox` smallint,
    `mail_counter` int,
    PRIMARY KEY (`id_ask_about_product`)
    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';
foreach ($sqls as $sql) {
	if (!Db::getInstance()->execute($sql)) {
		return false;
	}
}
