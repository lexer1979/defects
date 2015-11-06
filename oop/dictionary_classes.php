<?php

require_once "global_class.php";

abstract class DictionaryClass extends GlobalClass {

	public function __construct($table_name, $db)
	{
		parent::__construct($table_name, $db);
	}

	public function addRecord($name){
		if(!$this->checkValid($name)) return false;
		return $this->add(array(
			"name" => $name
			));
	}

	public function editRecord($id, $name){
		if(!$this->checkValid($name)) return false;
		return $this->edit($id, array(
			"name" => $name
		));
	}
	public function isExistsRecord($name){
		return $this->isExists("name", $name);
	}

	public function checkRecord($name){
		if(!$this->checkValid($name)) return false;
		$department = $this->getRecordOnName($name);
		if ($department) return $department;
		if (!$this->addRecord($name)) return false;
		return $this->get($this->getInsertID());
	}

	public function getRecordOnName($name){
		if(!$this->checkValid($name)) return false;
		$id = $this->getField("id", "name", $name, true);
		return $this->get($id);
	}

	public function checkValid($name){
		return $this->valid->validName($name);
	}

	public function getAllRecords(){
		return $this->getAll('name');
	}

	public function deleteAll(){
		return parent::deleteAll();
	}
}

class Department extends DictionaryClass {

	public function __construct($db)
	{
		parent::__construct("departments", $db);
	}
}

class EquipmentName extends DictionaryClass {

	public function __construct($db)
	{
		parent::__construct("equipment_names", $db);
	}
}

class EquipmentType extends DictionaryClass {

	public function __construct($db)
	{
		parent::__construct("equipment_types", $db);
	}
}

class EquipmentObject extends DictionaryClass {

	public function __construct($db)
	{
		parent::__construct("equipment_objects", $db);
	}
}

class Unit extends DictionaryClass {

	public function __construct($db)
	{
		parent::__construct("units", $db);
	}
}
?>
