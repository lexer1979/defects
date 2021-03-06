<?php

require_once "config_class.php";
require_once "checkvalid_class.php";
require_once "database_class.php";

abstract class GlobalClass {

	private $db;
	private $table_name;
	protected $config;
	protected $valid;
	protected $insert_id;

	protected function __construct($table_name, $db) {
		$this->db = $db;
		$this->table_name = $table_name;
		$this->config = new Config();
		$this->valid = new CheckValid();

	}

	public function __destruct()
	{
	}

	public function getInsertID(){
		return $this->insert_id;
	}

	protected function add($new_values){
		return $this->db->insert($this->table_name, $new_values, $this->insert_id);
	}

	protected function edit($id, $upd_values){
		return $this->db->updateOnID($this->table_name, $id, $upd_values);
	}

	protected function delete($id){
		return $this->db->deleteOnID($this->table_name, $id);
	}

	protected function deleteAll(){
		return $this->db->deleteAll($this->table_name);
	}

	protected function getField($field_out, $field_in, $value_in, $to_lower = false){
		return $this->db->getField($this->table_name, $field_out, $field_in, $value_in, $to_lower);
	}

	protected function getFieldOnID($id, $field, $to_lower = false){
		return $this->db->getFieldOnID($this->table_name, $id, $field, $to_lower);
	}

	protected function setFieldOnID($id, $field, $value){
		return $this->db->setFieldOnID($this->table_name, $id, $field, $value);
	}

	protected function get($id){
		return $this->db->getElementOnID($this->table_name, $id);
	}

	public function getAll($order = "", $up = true){
		return $this->db->getAll($this->table_name, $order, $up);
	}

	protected function getAllOnField($field, $value, $order = "", $up = true){
		return $this->db->getAllOnField($this->table_name, $field, $value, $order, $up);
	}

	protected function getRandomElement($count){
		return $this->db->getRandomElements($this->table_name, $count);
	}

	public function getLastID(){
		return $this->db->getLastID($this->table_name);
	}

	public function getCount(){
		return $this->db->getCount($this->table_name);
	}

	protected function isExists($field, $value){
		return $this->db->isExists($this->table_name, $field, $value);
	}
}

?>
