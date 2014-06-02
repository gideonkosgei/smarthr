<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class DatabaseObject {
    
	protected static $table_name;
    protected static $db_fields;
	protected static $primary_key;
	
		// Common Database Methods to be inherited by classes that have use static data from database tables 
	public static function find_all() {
	$sql="SELECT * FROM `".static::$table_name."`";
 
		return static::find_by_sql($sql);
  }
  //4 PAGINATION
  	public static function find_limited($per_page=0, $offset=0) {
	$sql="SELECT * FROM ".static::$table_name;
	$sql .= " LIMIT {$per_page} ";
	$sql .= " OFFSET {$offset}";
	return static::find_by_sql($sql);
		
  }
  
  public static function find_all_except_hr($primary_key_value="") {
	 $sql="SELECT * FROM `".static::$table_name."` WHERE ".static::$primary_key." != '{$primary_key_value}'";
 
		return static::find_by_sql($sql);
  }
  public static function find_all_managers() {
	 $sql="SELECT * FROM `".static::$table_name."`WHERE manager= 'yes'";
 
		return static::find_by_sql($sql);
  }

  
  public static function find_by_primary_key($primary_key_value="") {
    $sql="SELECT * FROM `".static::$table_name."` WHERE ".static::$primary_key." = '{$primary_key_value}'  LIMIT 1";
	//echo "SELECT * FROM `".static::$table_name."` WHERE ".static::$primary_key." = '{$primary_key_value}'  LIMIT 1"; echo"<br>";
	//echo "SELECT * FROM `".static::$table_name."` WHERE ".static::$primary_key." = '{$primary_key_value}' LIMIT 1 "; echo"<br>";
    $result_array = static::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  public static function find_by_id($id=""){
   return static::find_by_primary_key($id);
  }
  
  public static function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = static::instantiate($row);
    }

    return $object_array;
  }

	public static function count_all() {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".static::$table_name;
    $result_set = $database->query($sql);
	  $rows = $database->fetch_array($result_set);
    return array_shift($rows);
	}

	private static function instantiate($record) {
		// Could check that $record exists and is an array
	 $class_name=get_called_class();
     $object = new $class_name;
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(static::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}
	
	public function save() {
	  // A new record is not in the database.
	  $record_in_db=static::find_by_id($this->{static::$primary_key});
	  //echo (empty($record_in_db))? 'create':'update' ;
	  return (empty($record_in_db))? $this->create():$this->update() ;
	}
	
	public function create() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
	    $sql = "INSERT INTO `".static::$table_name."` (";
		$sql .= join(", ", array_keys($attributes));
	    $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		//$sql;echo"<br>";
	  if($database->query($sql)) {
	  //echo $database->get_last_autoIncrement_inserted_id();
	   if($database->get_last_autoIncrement_inserted_id()){
	    $this->{static::$primary_key} = $database->get_last_autoIncrement_inserted_id();
	   }
	    return true;
	  } else {
	    return false;
	  }
	}

	public function update() {
	  global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE `".static::$table_name."` SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .=  " WHERE ".static::$primary_key." = '". $database->escape_value($this->{static::$primary_key})."'";
		//echo $sql;
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
	//echo "delete";
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
		
	  $sql = "DELETE FROM `".static::$table_name."`";
	  $sql .= " WHERE ".static::$primary_key." = '". $database->escape_value($this->{static::$primary_key})."'";
	  $sql .= " LIMIT 1";
	  
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}

	
}