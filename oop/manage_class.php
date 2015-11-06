<?php

require_once "config_class.php";
require_once "user_class.php";
require_once "dictionary_classes.php";

class Manage {

	private $config;
	private $data;
	private $user;
	public $users;
	public $user_info;
	public $department;
	public $departments;
	public $equipment_name;
	public $equipment_names;
	public $equipment_type;
	public $equipment_types;
	public $equipment_object;
	public $equipment_objects;
	public $unit;
	public $units;

	public function __construct($db)
	{
		session_start();
		$this->config = new Config();
		$this->data = $this->secureData(array_merge($_POST, $_GET));
		$this->user = new User($db);
		$this->users = $this->getAllUsers();
		$this->user_info = $this->getUser();

		$this->department = new Department($db);
		$this->departments = $this->getAllDepartments();
		$this->equipment_name = new EquipmentName($db);
		$this->equipment_names = $this->getAllEquipmentNames();
		$this->equipment_type = new EquipmentType($db);
		$this->equipment_types = $this->getAllEquipmentTypes();
		$this->equipment_object = new EquipmentObject($db);
		$this->equipment_objects = $this->getAllEquipmentObjects();
		$this->unit = new Unit($db);
		$this->units = $this->getAllUnits();
	}

	private function secureData($data){
		foreach($data as $key => $value){
			if (is_array($value)) $this->secureData($value);
			else $data[$key] = htmlspecialchars($value);
		}
		return $data;
	}

	private function getUser(){
		$login = $_SESSION["login"];
		$password = $_SESSION["password"];
		if ($this->user->checkUser($login, $password)) return $this->user->getUserOnLogin($login);
		else return false;
	}

	private function getAllUsers(){
		$users = $this->user->getAllUsers();
		if (!is_array($users) || count($users)==0) return false;
		return $users;
	}

	private function getAllDepartments(){
		$dict = $this->department->getAllRecords();
		if (!is_array($dict) || count($dict)==0) return false;
		return $dict;
	}
	private function getAllEquipmentNames(){
		$dict = $this->equipment_name->getAllRecords();
		if (!is_array($dict) || count($dict)==0) return false;
		return $dict;
	}
	private function getAllEquipmentTypes(){
		$dict = $this->equipment_type->getAllRecords();
		if (!is_array($dict) || count($dict)==0) return false;
		return $dict;
	}
	private function getAllEquipmentObjects(){
		$dict = $this->equipment_object->getAllRecords();
		if (!is_array($dict) || count($dict)==0) return false;
		return $dict;
	}
	private function getAllUnits(){
		$dict = $this->unit->getAllRecords();
		if (!is_array($dict) || count($dict)==0) return false;
		return $dict;
	}

	public function redirect($link){
		header("Location: $link");
		exit;
	}

	public function regUser() {
		$link_reg = $this->config->address."?view=reg";
		$captcha = $this->data["captcha"];

		if (($_SESSION["rand"] != $captcha) && ($_SESSION["rand"] != "")){
			return $this->returnMessage("ERROR_CAPTCHA", $link_reg);
		}
		$login = $this->data["login"];
		if ($this->user->isExistsUser($login))
			return $this->returnMessage("EXISTS_LOGIN", $link_reg);
		$password = $this->data["password"];
		if ($password == "")
			return $this->unknownError($link_reg);

		$password = $this->hashPassword($password);

		$result = $this->user->addUser($login, $password, time());

		if ($result) return $this->returnPageMessage("SUCCESS_REG", $this->config->address."?view=message");
		else return $this->unknownError($link_reg);
	}

	public function login(){
		$login=$this->data["login"];
		$password=$this->hashPassword($this->data["password"]);
		//setcookie("login", $login, time()+3600);
		$r = $_SERVER["HTTP_REFERER"];
		if ($this->user->checkUser($login, $password)){
			$_SESSION["login"] = $login;
			$_SESSION["password"] = $password;
			unset($_SESSION["error_auth"]);
			return $r;
		}
		else {
			unset($_SESSION["login"]);
			unset($_SESSION["password"]);
			$_SESSION["error_auth"] = 1;
			return $r;
		}
	}

	public function logout(){
		unset($_SESSION["login"]);
		unset($_SESSION["password"]);
		unset($_SESSION["error_auth"]);
		session_destroy();
		return $_SERVER["HTTP_REFERER"];
	}

	private function hashPassword($password){
		return md5($password.$this->config->secret);
	}

	private function unknownError($r){
		return $this->returnMessage("UNKNOWN_ERROR", $r);
	}
	private function returnMessage($message, $r){
		$_SESSION["message"] = $message;
		return $r;
	}

	private function returnPageMessage($message, $r){
		$_SESSION["page_message"] = $message;
		return $r;
	}
}

?>
