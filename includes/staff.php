<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Staff extends DatabaseObject {
	
	protected static $table_name="staff";
	protected static $db_fields = array('staff_id','first_name','last_name','contract_type','department_id','balance','username','password','status','gender','type','locked','adm','manager');
	protected static $primary_key="staff_id";
		
	public $staff_id;
	public $first_name;
	public $last_name;
    public $contract_type;
	public $department_id;
	public $username;
	public $password;
	public $balance;
	public $status;
	public $gender;
	public $type;
	public $user_id;
	public $locked;
	public $adm;
	public $manager;
	
  	function __construct() {
	$this->user_id=&$this->staff_id;
	}
	
	  public static function authenticate($username="", $password="") {
    global $database;
    $username = $database->escape_value($username);
    $password = $database->escape_value($password);
    $sql  = "SELECT * FROM  ".self::$table_name." ";
    $sql .= "WHERE username = '{$username}' ";
    $sql .= "AND password = '{$password}' ";
    $sql .= "LIMIT 1";
    $result_array = self::find_by_sql($sql);
	

	
	return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_staff_id($id=""){
   return static::find_by_primary_key($id);
   }
	
public static function manager_department($department_id) {
    global $database;
$department_id= $database->escape_value($department_id);
   
    $sql  = "SELECT * FROM  ".self::$table_name." ";
    $sql .= "WHERE manager = 'yes' ";
    $sql .= "AND department_id = '{$department_id}' ";
    $sql .= "LIMIT 1";
    $result_array = self::find_by_sql($sql);
	

	
	return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	
	public static function find_hr() {
    global $database; 
    $sql  = "SELECT * FROM  ".self::$table_name." ";
    $sql .= "WHERE adm = 'hr' ";
    $sql .= "LIMIT 1";
    $result_array = self::find_by_sql($sql);
	
	return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_manager_hr($department_id) {
	 $sql="SELECT * FROM `".static::$table_name."`WHERE adm= 'hr' or staff_id=(select staff_id from `".static::$table_name."` where department_id='{$department_id}' AND manager='yes')";
	
 
		return static::find_by_sql($sql);
  }
  
  public static function find_staff_in_my_dept($staff_id) {
	 $sql="SELECT * FROM `".static::$table_name."`WHERE adm= 'hr' or department_id=(select department_id from `".static::$table_name."` where staff_id='{$staff_id}')";
	
 
		return static::find_by_sql($sql);
  }
  public static function find_staff_by_department($dept_id) {
	 $sql="SELECT * FROM `".static::$table_name."`WHERE department_id='{$dept_id}'";
	
 
		return static::find_by_sql($sql);
  }
  
  public static function find_department_manager($dept_id) {
	 $sql="SELECT * FROM `".static::$table_name."`WHERE department_id='{$dept_id}' AND manager='yes'";
	
 
		return static::find_by_sql($sql);
  }
   public static function find_staff_by_name($first_name,$last_name) {
	 $sql="SELECT * FROM `".static::$table_name."`WHERE first_name='{$first_name}' AND last_name='{$last_name}'";
	
 
		return static::find_by_sql($sql);
  }
	
}    


   
	 
	 //$stf->delete();
	 /*
	$stf->first_name="james";
	$stf->last_name="cherutich";
	$stf->contract_type="permanent";
	$stf->department_id=58;
	$stf->gender="male";
	$stf->status="on session";
	$stf->username=mt_rand(10000, 99999);
	$stf->password=uniqid();
	$stf->save();*/
	
	//echo $stf->staff_id;
	//echo $stf->first_name;
	//echo $stf->last_name;
	//echo $stf->contract_type;
	//echo $stf->department_id;
	//echo $stf->designation;
	
	
	

?>