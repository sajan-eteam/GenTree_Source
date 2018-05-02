<?php
session_start();
ob_start();
//error_reporting(E_ALL ^ E_NOTICE);
include "functions.php";
error_reporting(0);
define("DB_USER", "gentreeUsr");
define("DB_PASSWORD", "gentreePwd");
define("DB_NAME", "gentree");
define("DB_HOST", "localhost");  //192.168.167.28 For  e-zenit
define('BASE_URL', '/dea_albero/');
define('ROOT_PATH', 'http://www.e-zenitsviluppo.it/dea_albero_2/');
define('UPLOAD_PATH', 'http://www.e-zenitsviluppo.it/dea_albero_2/upload/');
define('ADMIN_MAILID', 'saleem.vk@eteamindia.com');
define('FROM_MAILID', 'info@dea_albero.com');
function __autoload($class_name) {
	    require_once $_SERVER['DOCUMENT_ROOT'].'/dea_albero_2/includes/classes/class.'.$class_name.'.php';
}
$db = new database();  
?>