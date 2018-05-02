<?php
include "../includes/init.php";
include('session_check.php');
ini_set('display_errors', 1);
$user_id 		   =   $_SESSION['user_id'];
function logCreation($logType,$logText){
	$objLog  		   =   new userlog();
	$insertLogArray    =  array( 'user_id' 			=> 1,
							     'log_type' 		=> $logType,
							     'log_text'     	=> $logText,
							     'log_user_version' => '',
							     'log_time'			=> date('Y-m-d H:i:s'),
							);
	$insertLog  	= $objLog->insertLogDetail($insertLogArray);
	if($insertLog){
		return TRUE;
	}else{
		return FALSE;
	}
	
}
?>