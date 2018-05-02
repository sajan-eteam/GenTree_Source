<?php
include "../includes/init.php";
include "loggfile.php";
$objUser	 	= 	new user();
$objgeneuser 	= 	new geneuser();
$user_id        =   $_POST['useid'];
$username 		=	cleanString($_POST['uname']);
$password 		=	mysql_real_escape_string($_POST['pword']);
$pword          =   strlen($password);
$confirmpassword=   mysql_real_escape_string($_POST['confirmpassword']);
$cword          =   strlen($confirmpassword);
$member   		=	$_POST['member'];
$userid   		=	mysql_real_escape_string($_POST['userid']); 
$appusr   		=	cleanString($_POST['appusr']);
$appsur   		=	cleanString($_POST['appsur']);
$appemail 		=	mysql_real_escape_string($_POST['appemail']);
$appphon  	    =	stripslashes($_POST['appphon']);
//echo $appphon; exit;
//$appphon		=	urldecode($appphon);
//echo $appphon;exit;
$status   		=	$_POST['status'];
$regex 			= 	'/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

if($username==''||$pword<5||$member=='undefined')
{
	  //$msg = 1; 
	  echo "1";exit;
}
if($userid=='null')
{
	 if($appusr==''||$appsur=='')
	 {
	 	//$msg = 1;
		echo "1";exit;
	 }
}
if($appemail)
{
	if(!preg_match($regex, $appemail))
	{
		//$msg = 1;
		echo"1";exit;
	}
}
$personmailexist = $objUser->check_user_id($appemail,$user_id);


if($personmailexist>0)
{  
	echo "2"; exit;
	//echo "4";exit;
}
$usermailexist	=	$objUser->check_email_id($appemail,$userid);

if($member=='1' && $usermailexist>0)
{   
	echo "2";exit;
    //echo "5";exit;
}	
//$user_exist_id	=	$objUser->check_exist_id($user_id,$userid);
//if($user_exist_id>0)
//{
//	echo "6";exit;
//}

if($member == '1')
{
	$user   	= 	$objUser->getusers($userid);
	$appusr   	= 	$appusr;
	$appsur   	= 	$appsur;
	$appemail 	= 	$appemail;
	$appphon  	= 	$appphon ;
}
if($member == '0')
{
	$userid = NULL;
	$update_array	=	array(
							 "sys_user_name"        =>	$username,
							 "sys_password"		    =>	$password,
							 "sys_is_a_member"	    =>	$member,
							 "sys_active"           =>	$status,
							 "sys_name"             =>	$appusr,
							 "sys_surname"          =>	$appsur,
							 "sys_email"           	=>	$appemail,
							 "sys_phone"           	=>	$appphon,
							  "Trash"				=>  '1'
						);
	$update_user	= $objUser->updateUserdetails($update_array,$user_id);
	$query_to_set_null	=	"UPDATE  tab_user SET gene_user_id=NULL WHERE user_id=".$user_id;
	$query_res			=	mysql_query($query_to_set_null);
	$logtext 			=	$appusr.' '.$appsur." Utente aggiunto con successo.";
	logInsert(1, 6, $logtext);
    echo "0";exit;	
}
else
{
	$update_array	=	array(
							 "sys_user_name"        =>	$username,
							 "sys_password"		    =>	$password,
							 "sys_is_a_member"	    =>	$member,
							 "gene_user_id"         =>	$userid,
							 "sys_active"           =>	$status,
							 "sys_name"             =>	$appusr,
							 "sys_surname"          =>	$appsur,
							 "sys_email"           	=>	$appemail,
							 "sys_phone"           	=>	$appphon,
							  "Trash"				=>  '1'
						);
	$update_user	= $objUser->updateUserdetails($update_array,$user_id);
	$logtext 		= $appusr.' '.$appsur." Utenet aggiornato con successo.";
	logInsert(1, 6, $logtext);
	echo "0";exit;	
}
//print_r($update_array);exit;

?>