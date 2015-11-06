<?php

require_once "global_class.php";

class User extends GlobalClass {

	public function __construct($db)
	{
		parent::__construct("users", $db);
	}

	public function addUser($login, $password, $group_id){
		//$password = md5($password.$this->config->secret);
		if(!$this->checkValid($login, $password, $group_id)) return false;
		return $this->add(array(
			"login" => $login,
			"password" => $password,
			"group_id" => $group_id
			));
	}

	public function editUser($id, $login, $password, $group_id){
		//$password = md5($password.$this->config->secret);
		if(!$this->checkValid($login, $password, $group_id)) return false;
		return $this->edit($id, array(
			"login" => $login,
			"password" => $password,
			"group_id" => $group_id
		));
	}
/*
	public function isExists($login){
		return parent::isExists("login", $login);
	}
*/
	public function isExistsUser($login){
		return $this->isExists("login", $login);
	}

	public function checkUser($login, $password){
		$user = $this->getUserOnLogin($login);
		if (!$user) return false;
		return $user["password"] === $password;
	}

	public function getUserOnLogin($login){
		$id = $this->getField("id", "login", $login);
		return $this->get($id);
	}

	public function checkValid($login, $password, $group_id){
		if (!$this->valid->validLogin($login)) return false;
		if (!$this->valid->validHash($password)) return false;
		if (!$this->valid->validTimeStamp($group_id)) return false;
		return true;
	}

	public function getAllRecords(){
		return $this->getAll('login');
	}
}

?>
