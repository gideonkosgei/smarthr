<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Notifications extends DatabaseObject {
	
	protected static $table_name="notifications";
	protected static $db_fields = array('notification_id','sender','receiver','subject','message','date_time');
	protected static $primary_key="notification_id";
		
	public $notification_id;
    public $sender;
    public $receiver;
	public $subject;
	public $message;	
	public $date_time;
	
	  //4 PAGINATION
  	public static function find_limited($per_page=0, $offset=0, $user_id) {
	$sql="SELECT * FROM ".static::$table_name;
	$sql .= " WHERE sender = '{$user_id}' ";
    $sql .= " OR receiver = '{$user_id}' ";
	$sql .= " ORDER BY date_time DESC";
	$sql .= " LIMIT {$per_page} ";
	$sql .= " OFFSET {$offset}";	
	return static::find_by_sql($sql);
		
  }
	
	public static function all_my_notifications($user_id) {
    global $database;   
    $sql  = "SELECT * FROM  ".self::$table_name." ";
    $sql .= "WHERE sender = '{$user_id}' ";
    $sql .= "OR receiver = '{$user_id}' ";

	

	return static::find_by_sql($sql);
	//return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	
	
	
	
	
}   
   /*$not= new Notifications();
	
    $not->sender=7;
	$not->receiver=8;
	$not->subject="leave application";
	$not->message="leave ";
	$not->status="inbox";
	//$not->date_time="12/2/2014";
	$not->application_id=112;
	
	
	$not->save();
	*/
	//echo $man->manager_id;
	//echo $man->department_id;
	//echo $man->staff_id;*/

?>