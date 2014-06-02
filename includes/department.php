<?php

require_once(LIB_PATH.DS.'database.php');

class Department extends DatabaseObject {
	
	protected static $table_name="department";
	protected static $db_fields = array('department_id','department_name');
	protected static $primary_key="department_id";
		
	public $department_id;
	public $department_name; 
	
   public static function find_by_department_id($id=""){
   return static::find_by_primary_key($id);
   }
   
    public static function find_by_department_name($name=""){
   	$sql="SELECT * FROM `".static::$table_name."`WHERE department_name='{$name}'LIMIT 1";
		$result_array = static::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
   }
	
	
}    



?>