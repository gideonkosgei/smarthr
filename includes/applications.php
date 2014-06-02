<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

define ("OBJECT", "OBJECT", true);

class Applications extends DatabaseObject {
	
	protected static $table_name="applications";
	protected static $db_fields = array('application_id','staff_id','leave_id','date_from','date_to','status','manager_status','application_date','department_id');
	protected static $primary_key="application_id";
		
	public $application_id;
    public $staff_id;
    public $department_id;
	public $leave_id;
    public $date_from;
	public $date_to;
	public $status;
    public $manager_status;
    public $application_date;
	
	
	

	
	
	public static function find_by_application_id($id=""){
   return static::find_by_primary_key($id);
	
} 
   public static function find_my_applications($id="") {
	 $sql="SELECT * FROM `".static::$table_name."`WHERE staff_id=$id";
 
		return static::find_by_sql($sql);
  }
   public static function find_my_last_application($id="") {
	  $sql="SELECT * FROM `".static::$table_name."`WHERE staff_id=$id  AND status='granted' ORDER BY `application_id` DESC LIMIT 1";
		$result_array = static::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
  }
   public static function find_application_between_date_range($date1,$date2) {
   $sql="SELECT * FROM `".static::$table_name."` WHERE application_date BETWEEN '{$date1}' AND '{$date2}'";
        //print_r(static::find_by_sql($sql));
		return static::find_by_sql($sql);
  }
  
  public static function find_applicants_on_leave($today) {
  $sql="SELECT * FROM `".static::$table_name."` WHERE  status='granted' AND  date_from>='{$today}' AND date_to>='{$today}'";
        //print_r(static::find_by_sql($sql));
		return static::find_by_sql($sql);
  }
  public static function find_applicants_with_expired_leave($today) {
  $sql="SELECT * FROM `".static::$table_name."` WHERE  status='granted' AND date_to<'{$today}'";
        //print_r(static::find_by_sql($sql));
		return static::find_by_sql($sql);
  }
  
  public static function find_application_between_date_range_by_dept($date1,$date2,$dept) {
   $sql="SELECT * FROM `".static::$table_name."` WHERE department_id=$dept AND application_date BETWEEN '{$date1}' AND '{$date2}'";
    (static::find_by_sql($sql));
		return static::find_by_sql($sql);
  }

  
  
  
  
  
  function get_results($query=null, $output = OBJECT)
		{
			
			// Log how the function was called
			$this->func_call = "\$db->get_results(\"$query\", $output)";
			
			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}		
	
			// Send back array of objects. Each row is an object		
			if ( $output == OBJECT )
			{
				return $this->last_result; 
			}
			elseif ( $output == ARRAY_A || $output == ARRAY_N )
			{
				if ( $this->last_result )
				{
					$i=0;
					foreach( $this->last_result as $row )
					{
						
						$new_array[$i] = get_object_vars($row);
						
						if ( $output == ARRAY_N )
						{
							$new_array[$i] = array_values($new_array[$i]);
						}
	
						$i++;
					}
				
					return $new_array;
				}
				else
				{
					return null;	
				}
			}
		}





function get_row($query=null,$y=0,$output=OBJECT)
		{
			
			// Log how the function was called
			$this->func_call = "\$db->get_row(\"$query\",$y,$output)";
			
			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}
	
			// If the output is an object then return object using the row offset..
			if ( $output == OBJECT )
			{
				return $this->last_result[$y]?$this->last_result[$y]:null;
			}
			// If the output is an associative array then return row as such..
			elseif ( $output == ARRAY_A )
			{
				return $this->last_result[$y]?get_object_vars($this->last_result[$y]):null;	
			}
			// If the output is an numerical array then return row as such..
			elseif ( $output == ARRAY_N )
			{
				return $this->last_result[$y]?array_values(get_object_vars($this->last_result[$y])):null;
			}
			// If invalid output type was specified..
			else
			{
				$this->print_error(" \$db->get_row(string query,int offset,output type) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N ");	
			}
	
		}
		
		
		
		
		
		function query($query, $output = OBJECT) 
		{
			
			// Log how the function was called
			$this->func_call = "\$db->query(\"$query\", $output)";		
			
			// Kill this
			$this->last_result = null;
			$this->col_info = null;
	
			// Keep track of the last query for debug..
			$this->last_query = $query;
			
			// Perform the query via std mysql_query function..
			$this->result = mysql_query($query);
	
			if ( mysql_error() ) 
			{
				
				// If there is an error then take note of it..
				$this->print_error();
	
			}
			else
			{
	
				// In other words if this was a select statement..
				if ( $this->result )
				{
	
					// =======================================================
					// Take note of column info
					
					$i=0;
					while ($i < @mysql_num_fields($this->result))
					{
						$this->col_info[$i] = @mysql_fetch_field($this->result);
						$i++;
					}
	
					// =======================================================				
					// Store Query Results
					
					$i=0;
					while ( $row = @mysql_fetch_object($this->result) )
					{ 
	
						// Store relults as an objects within main array
						$this->last_result[$i] = $row;
						
						$i++;
					}
					
					@mysql_free_result($this->result);
	
					// If there were results then return true for $db->query
					if ( $i )
					{
						return true;
		
					}
					else
					{
						return false;
					}
	
				}
	
			}
		}
	
  
  
 
   
  /*
  $apps= new Applications();	
  $apps->staff_id=5;
  $apps->leave_id=13;
  $apps->date_from="12/2/2014";
  $apps->days=5;
    $apps->status="pending";
	$apps->save();
	*/
}	
$app=new Applications();
$today=date('Y-m-d');
$applicants_on_leave=Applications::find_applicants_on_leave($today);
if($applicants_on_leave){
 foreach( $applicants_on_leave as $apps):
 $staff_on_leave=Staff::find_by_staff_id($apps->staff_id);
 $staff_on_leave->status="leave";
 $staff_on_leave->save();
endforeach;
}else
{}

$applicants_expire=Applications::find_applicants_with_expired_leave($today);
if($applicants_expire){
foreach($applicants_expire as $apps):
 $staff_with_expired_leave=Staff::find_by_staff_id($apps->staff_id);
$staff_with_expired_leave->status="session";
$staff_with_expired_leave->save();
endforeach;
}
else{

}

	


?>