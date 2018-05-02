<?php
include "../includes/init.php";
include "loggfile.php";
$objUser	 	= 	new user();
$objgeneuser 	= 	new geneuser();
$username 		=	cleanString($_POST['user_name']);
$password 		=	mysql_real_escape_string($_POST['user_password']);
$pword          =   strlen($password);
$confirmpasswrd =   mysql_real_escape_string($_POST['confirmpassword']);
$confrmpword    =   strlen($confirmpasswrd);
$member   		=	$_POST['member'];
$member_name	=	$_POST['member_name']; 
$app_user_name	=	cleanString($_POST['app_user_name']);
$app_user_surname=	cleanString($_POST['app_user_surname']);
$user_email		=	mysql_real_escape_string($_POST['user_email']);
$person_email	=	$_POST['person_email'];
$phone_num  	=	stripslashes(urlencode($_POST['phone_num']));
$phone_num		=	urldecode($phone_num);
//echo $phone_num;exit;
$status   		=	$_POST['status'];

$regex 			= 	'/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
//echo $username." - "
if($username==''||$pword<6||$member=='undefined'||$confrmpword<6)
{
		echo "-1";exit;
}
if($member_name=='null')
{
	 if($app_user_name==''||$app_user_surname=='')
	 {
		echo "-1";exit;
	 }
}
if($user_email != '')
{
	if(!preg_match($regex,$user_email))
	{
		//echo strlen($user_email);
		echo "-1";exit;
	}
}

$userexist	=	$objUser->userexist($member_name, $username, $user_email);
$userss		=	count($userexist);

for($i=0;$i<$userss;$i++)
{	
	$userids	=	$userexist[$i]['gene_user_id'];
	$usrnam 	=	$userexist[$i]['sys_user_name'];
	$mails		=	$userexist[$i]['sys_email'];
	
	/*if($userids==$member_name)
	{
		echo "-2";exit;
	}*/
	if($usrnam==$username)
	{
		echo "-2";exit;
	}
	
	if($member==0 && $user_email != '')
	{
		if($mails	==	$user_email)
		{
			echo "-2";exit;
		}
	}
}
$personmailexist = $objUser->check_user_email($person_email);
if($member==1 && $personmailexist > 0)
{
	echo "-2";exit;
}

if($member == '1')
{
	$user   			= 	$objgeneuser->getuser($member_name);
	$app_user_name   	= 	$user['gene_name'];
	$app_user_surname   = 	$user['gene_surname'];
	$user_email 		= 	$person_email;
	$email_person1		=	$user['gene_email_personel_1'];
	$email_person2		=	$user['gene_email_personel_2'];
	$phone_num  		= 	$user['gene_mobile_no_1'];
}
if($member == '0')
{
	$member_name = '';
}
$insertArray	=	array(
							 "sys_user_name"        =>	$username,
							 "sys_password"		    =>	$password,
							 "sys_is_a_member"	    =>	$member,
							 "gene_user_id"         =>	$member_name,
							 "sys_active"           =>	$status,
							 "sys_name"             =>	$app_user_name,
							 "sys_surname"          =>	$app_user_surname,
							 "sys_email"           	=>	$user_email,
							 "sys_phone"           	=>	$phone_num,
							 "Trash"				=>  '1'
						);					
$insert_user	= $objUser->insertUserdetail($insertArray);
$logtext 			=	'Utente App aggiunto con successo';
logInsert(1, 5, $logtext);
echo $insert_user;
exit;
?>