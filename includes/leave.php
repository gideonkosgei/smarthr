<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Leave extends DatabaseObject {
	
	protected static $table_name="leave";
	protected static $db_fields = array('leave_id','leave_name','leave_type','max_days','qualification','applicability');
	protected static $primary_key="leave_id";
		
	public $leave_id;
	public $leave_name;
	public $leave_type;
    public $max_days;
  	public $qualification;
	public $applicability;
	
	 public static function find_by_leave_id($id=""){
   return static::find_by_primary_key($id);
   }
 public static function find_by_leave_name($name=""){
   	$sql="SELECT * FROM `".static::$table_name."`WHERE leave_name='{$name}'LIMIT 1";
		$result_array = static::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
   }
	
}  


?>