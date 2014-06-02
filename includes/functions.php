<?php

function strip_zeros_from_date($marked_string="") {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function output_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}


 function convertMPesaDate_and_TimetoMySQLformat( $date="", $time=""){
 // 12-hour time to 24-hour time 
 $time_in_24_hour_format  = DATE("H:i", STRTOTIME($time));

 //MPesa date and time to MySQL_datetime
 $datetime = DateTime::createFromFormat('j/n/y H:i:s', $date." ".$time_in_24_hour_format.":00");
 $MySQLdatetimeFormat=$datetime->format('Y-m-d g:i:s');
 
 return $MySQLdatetimeFormat;
 }
  
  
  function convertTimestamptoMySQLformat( $timestamp=0){
  $MySQLdatetimeFormat = date('Y-m-d g:i:s', $timestamp);
  return $MySQLdatetimeFormat;
 } 
  
  

function __autoload($class_name) {
	$class_name = strtolower($class_name);
  $path = LIB_PATH.DS."{$class_name}.php";
  if(file_exists($path)) {
    require_once($path);
  } else {
		die("The file {$class_name}.php could not be found.");
	}
}

function include_layout_template($template="") {
	include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template.".php");
}

function log_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}

function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function datetime_to_unixtime($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}



function dayOfTheWeek($date){
  $timestamp = strtotime($date);
  $day_of_the_week = date("l", $timestamp);
  $day_of_the_week = strtolower($day_of_the_week);
  return $day_of_the_week ;
 }
 
function isweekend($date){
 	if(dayOfTheWeek($date)=="saturday" || dayOfTheWeek($date)=="sunday"){
		return true;
	}
	else{
	    return false;
	}
 
 }
 


function number_of_days_between_two_dates($date1="2014-02-21",$date2="2014-02-21"){
$timestamp1 = strtotime($date1);
$timestamp2 = strtotime($date2);

$diff = $timestamp2 - $timestamp1;
$one_day = 60 * 60 * 24; //number of seconds in the day
$days_between = (floor($diff / $one_day));
return $days_between;

}


 //function to calculate number of days without weekends 
function leave_days($datetime1,$datetime2)
{
$timestamp1 = strtotime($datetime1);
$timestamp2 = strtotime($datetime2);

$diff = $timestamp2 - $timestamp1;
$one_day = 60 * 60 * 24; //number of seconds in the day
$weekend = array(0, 6);

$days_between = (floor($diff / $one_day));
$remove_days =0;

for($i = 1; $i <= $days_between; $i++)
{
   $next_day= $timestamp1 + ($i * $one_day);
   $is_weekend=strtolower(date("l",$next_day));
   
   if($is_weekend=="saturday" || $is_weekend=="sunday")
   {
      $remove_days++; 
   }
  
  
}
 return $days_on_leave=($days_between+1)-$remove_days;
}

?>