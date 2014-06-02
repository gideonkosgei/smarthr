<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Holidays extends DatabaseObject {
	
	protected static $table_name="holidays";
	protected static $db_fields = array('holiday_id','holiday_name','holiday_date');
	protected static $primary_key="holiday_id";
		
	public $holiday_id;
	public $holiday_name;
    public $holiday_date;

	

	public function isholiday($day_month=""){
	$sql="SELECT * FROM `".static::$table_name."` WHERE `holiday_date` = '{$day_month}'  LIMIT 1"; 
	$result_array = static::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	 
	 public static function find_by_holiday_id($id=""){
   return static::find_by_primary_key($id);
	
	}
	
	public static function days_on_leave_Weekends_and_Holidays_removed($date_from="2014-02-21",$day_to="2014-02-21"){
	$startDate = strtotime($date_from);
	$endDate = strtotime($day_to);
     $days=number_of_days_between_two_dates($date_from,$day_to)+1;	
	while ($startDate <= $endDate) {
		$startDate=$startDate+(60*60*24);
		$date_month=date('d-F',$startDate);
		$date=date('Y-m-d',$startDate);
		if(static::isholiday($date_month)||isweekend($date)){
		$days=$days-1;
		}
	}
return $days;
	}
	
	
	public static function find_by_holiday_name($name) {
	 $sql="SELECT * FROM `".static::$table_name."`WHERE holiday_name='{$name}'";	
 
		$result_array = static::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
  }

}  
    /*
	
	$holz= new Holidays();
	
	$holz=Holidays::isholiday('2014-12-12');
	if(!(empty($holz))){
	echo $holz->holiday_name;
	echo $holz->holiday_date;
	}
   // $holz->holiday_name="christmass";
	//$holz->holiday_date='2014-12-25';
	//$holz->save();
	
	echo $man->manager_id;
	echo $man->department_id;
	echo $man->staff_id;*/

?>