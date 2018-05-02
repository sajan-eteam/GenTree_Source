<?php
include "../includes/init.php";
$objUser	= new user();
$user_name	= mysql_real_escape_string($_POST['user_name']);
$password	= mysql_real_escape_string($_POST['user_password']);
$user_email	= mysql_real_escape_string($_POST['user_email']);

$user_name	= stripslashes($user_name);
$password	= stripslashes($password);
$user_email	= stripslashes($user_email);

$user_id	=	$_SESSION['admin_user_id'];


if($user_name != "" && $password != "" && $user_email != "")
{ 	
	$check_user	= $objUser->getUser($user_id);	
	if($check_user[user_id] > 0)
	{
		$update_array 	= array(	"sys_user_name"		=> $user_name,
									"sys_password"		=> $password,
									"sys_email"			=> $user_email
								);
		$insert_user	= $objUser->updateUserdetails($update_array, $user_id);
		$msg = 1;		
	}
	else
	{
		$msg = 0;
	}
	echo $msg;	
}


?>