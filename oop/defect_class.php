<?php

require_once "global_class.php";

class Defect extends GlobalClass {

	public function __construct($db)
	{
		parent::__construct("defects", $db);
	}

	public function addRecord($def_date, $department_id, $equip_name_id, $equip_type_id, $equip_object_id,
							  $def_count, $unit_id, $description, $correct_measures, $user_id) {
		//if(!$this->checkValid($login, $password, $group_id)) return false;

		return $this->add(array(
			"def_date" => $def_date,
			"department_id" => $department_id,
			"equip_name_id" => $equip_name_id,
			"equip_type_id" => $equip_type_id,
			"equip_object_id" => $equip_object_id,
			"def_count" => $def_count,
			"unit_id" => $unit_id,
			"description" => $description,
			"correct_measures" => $correct_measures,
			"ins_user_id" => $user_id,
			"ins_date" => time()
			//"del_user_id" => $equip_name_id,
			//"del_date" => $equip_name_id
			));
	}

	public function editRecord($id, $def_date, $department_id, $equip_name_id, $equip_type_id, $equip_object_id,
							   $def_count, $unit_id, $description, $correct_measures, $user_id){
		//if(!$this->checkValid($login, $password, $group_id)) return false;
		return $this->edit($id, array(
			"def_date" => $def_date,
			"department_id" => $department_id,
			"equip_name_id" => $equip_name_id,
			"equip_type_id" => $equip_type_id,
			"equip_object_id" => $equip_object_id,
			"def_count" => $def_count,
			"unit_id" => $unit_id,
			"description" => $description,
			"correct_measures" => $correct_measures,
			"user_id" => $user_id,
			"ins_date" => time()
			//"del_user_id" => $equip_name_id,
			//"del_date" => $equip_name_id
		));
	}

	public function getAllRecords(){
		return $this->getAll('def_date', false);
	}
}

?>
