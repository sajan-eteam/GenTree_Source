<?php
session_start();
ob_start();
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
include "functions.php";
define("DB_USER", "gentreeUsr");
define("DB_PASSWORD", "42a74a92");
define("DB_NAME", "gentree_stg");
define("DB_HOST", "10.0.241.10:3306");  //192.168.167.28 For  e-zenit
define('BASE_URL', '/gentree/');
define('ROOT_PATH', 'http://test.gentree.deagostini.it/');
define('UPLOAD_PATH', 'http://test.gentree.deagostini.it/upload/');
define('ADMIN_MAILID', 'test@deagostini.com');
define('FROM_MAILID', 'test@deagostini.com');
function __autoload($class_name) {
	    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/classes/class.'.$class_name.'.php';
}
$db = new database();  
?>