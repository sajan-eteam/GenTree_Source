<?php

include "json_functions.php";

$url			=	"http://".$_SERVER["SERVER_NAME"]."/dea_albero_2/upload";
//$login		= 	"login";
$username		= 	"sys";
$password		= 	"admin";
//$sync			=	"sync";
//$date			=	"2013-09-25 09:19:25";

//$time       	= 	"0000-00-00 00:00:00";
$gentree		= 	array();
$album      	= 	array();
$objappuser		= 	new user();
$objimages  	= 	new images();
$info			= 	array();
$objtagging		=	new tagging();
$objuser		=	new geneuser();

$reqFor			=	'';


//$login		=   $_POST['login'];
//$sync         =   $_POST['sync'];


//$username		= 	$_POST['username'];
//$password		= 	$_POST['password'];
//$sync_date		=	$_POST['date'];

$reqFor			=	'sync';
$sync_date		=	'2013-09-26 09:09:10';

if(isset($_POST['reqFor']))
	$reqFor			=	$_POST['reqFor'];

$login_check	=	$objappuser->loginJsoncheck($username,$password);
$user_name		=	$login_check['sys_user_name'];
$pass_word		=	$login_check['sys_password'];

$current_time	= 	date('Y-m-d H:i:s');
   
if($reqFor == 'login') 
{ 
   $condition = "";
}
else if($reqFor == 'sync')
{
   $condition = $sync_date;
}

if($login_check == 1)
{   	
	$data			=	getAllUsers($objuser,$url,$condition,$reqfor);
	$pairs			=	getAllPairs($objuser,$condition);
	$fata			=	getGalleryDetails($objimages, $objtagging, $objuser, $url, $condition, $reqFor);

	$loginarray = array("Reqfor"=>$reqFor, "Username"=>$username, "Password"=>$password, "time"=>$current_time);
	
	$finalJson								=	$loginarray;
	$finalJson['Memberlist']['individual']	=	$data;
	$finalJson['couples'] 					= 	$pairs;
	$finalJson['ALBUMS']['gallery']			=	$fata; 
	$gentree['Gentree'] 					= 	$finalJson;
	echo"<PRE>";print_r($gentree);echo"</PRE>";
	//echo json_encode($gentree);	
}
else
{
	echo "0";
}



?>