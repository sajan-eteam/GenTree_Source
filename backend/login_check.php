<?php
include "../includes/init.php";
include "loggfile.php";
$objUser	= new user();
$user_name	= mysql_real_escape_string($_POST['user_name']);
$password	= mysql_real_escape_string($_POST['user_password']);
$user_name	= stripslashes($user_name);
$password	= stripslashes($password);
if($user_name != "" && $password != ""){ 
	$check_user	= $objUser->check_user($user_name,$password);
	if($user_name == "sys" && $password == "FamigliaBoroli2016!"){ 
		$_SESSION['admin_user_name'] 	= 	$user_name;
		$_SESSION['admin_user_id'] 		= 	'1';
		$_SESSION['user_id'] 			=	$check_user['user_id'];
		$logtext =	'Backend: login avvenuto con successo.';
		$msg = 1;		
	}
	else{
		$logtext =	'Accesso non riuscito';
		$msg = 0;
	}
logInsert($_SESSION['user_id'], 1, $logtext);
echo $msg;	
}
?>