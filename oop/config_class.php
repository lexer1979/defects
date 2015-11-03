<?php

class Config {
	
	var $site_name = "Статистика неисправностей оборудования";
	var $address = "http://uk-tmp.kz/";
	var $secret = array(
		'0' => '',
		'1' => 'sa',
		'2' => 'usr'
	);
	var $host = "localhost";
	var $db = "tmp_defects";
	var $db_prefix = "def_";
	var $user = "tmp_admin";
	var $password = "831321";
	var $adm_name = "Алексей Худяков";
	var $adm_email = "khudyakovalp@mail.ru";

	var $min_login = 3;
	var $max_login = 255;

}

?>
