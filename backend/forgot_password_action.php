<?php
include('../includes/init.php');
include('../includes/eteamUtil.php');
include "loggfile.php";
if(isset($_POST['e_mail'])){
   	$email				=	$_POST['e_mail'];
	$email_check		=	"SELECT * FROM tab_user WHERE sys_email = '".$email."'";
	$email_check_qury	=	mysql_query($email_check);
	$count				=	mysql_num_rows($email_check_qury);
	if($count > 0){
		$result			=	$db->readValue($email_check);
		$subject		=	'Albero genealogico Famiglia Boroli - Recupero password';
		$sys_password	=	$result['sys_password'];
		$fullName		=   $result['sys_name']." ".$result['sys_surname'];			
        $emailBody		= 	readTemplateFile('recupero_password.html');
        $emailBody_new	= 	str_replace("#email#", $email, $emailBody);
		$emailBody_new	= 	str_replace("#password#", $sys_password, $emailBody_new);	
		$emailBody_new	= 	str_replace("#name#", $fullName, $emailBody_new);
		//$mailContent	=	'La tua password per Dea-Albero è '.$sys_password.'. <br />Grazie.';		
		$send_mail		=	eteam_sendMail(FROM_MAILID, $email, $subject, $emailBody_new);
		if($send_mail	==	1){
			$logText = 'Invio email.';
			$msg = '1';
		}else{
			$logText = 'Invio email fallito.';
			$msg = '0';
		}	
	}
	else{
		$msg = '2';
	}
logInsert(1, 2, $logtext);
echo $msg;	
}
?>