<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)

//defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
//echo DIRECTORY_SEPARATOR;
$os = PHP_OS;
switch($os)
{
    case "Linux": define("DS", "/"); break;
    case "Windows": define("DS", "\\"); break;
	case "WINNT": define("DS", "/"); break;
    default: define("DS", "/"); break;
}

 
defined('SITE_ROOT') ? null : 
define('SITE_ROOT', 'C:'.DS.'xampp'.DS.'htdocs'.DS.'smartHR');



defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

// load config file first
require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');


// load core objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'database_object.php');
require_once(LIB_PATH.DS.'pagination.php');
require_once(LIB_PATH.DS.'fpdf.php');
require_once(LIB_PATH.DS.'PDF.php');
//require_once(LIB_PATH.DS."PHPMailer_5.2.4".DS."class.phpmailer.php");
//require_once(LIB_PATH.DS."PHPMailer_5.2.4".DS."class.smtp.php");
//require_once(LIB_PATH.DS."PHPMailer_5.2.4".DS."language".DS."phpmailer.lang-en.php");

// load database-related classes

require_once(LIB_PATH.DS.'department.php');
require_once(LIB_PATH.DS.'staff.php');
require_once(LIB_PATH.DS.'leave.php');
require_once(LIB_PATH.DS.'applications.php');
require_once(LIB_PATH.DS.'notifications.php');
require_once(LIB_PATH.DS.'holidays.php');

?>