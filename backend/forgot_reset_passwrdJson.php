<?php
include "../includes/init.php";
include "PHPMailer/class.phpmailer.php";
$objappuser		= 	new user();
//forgotpassword
$reFor			=	'Reqfor';
$username       =   'gijina';
$newpassword    =   'test1';
$oldpasswrd     =   'test123';
if($username !="" && $newpassword!="" && $oldpasswrd!="")
{
   $passwordetail	=  $objappuser->check_users($username,$oldpasswrd);
   //echo count($passwordetail);exit;
   $passwords		=  $passwordetail['sys_password'];
  
   $usernames		=  $passwordetail['sys_email'];
   
   $userid			=  $passwordetail['user_id'];
   
	   //echo "rrrr";exit;
	if($passwordetail)
	{
		//echo "eee";exit;
        
		$mail = new PHPMailer();
		$mail->IsMail();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host     = "Swmail.gruppozenit.com"; // SMTP server
		$mail->From     = "from@example.com";
		$mail->AddAddress($usernames);
		$mail->Subject  = "Password dimenticata";
		$mail->Body     = "La! \n\n tua password è\n\n$newpassword\n\n Thanks,\n\n GruppoZenit";
		$mail->WordWrap = 50;
		if(!$mail->Send()) {
			echo 'Message Not Sent';exit;
			echo 'Mailer error: '.$mail->ErrorInfo;
		} else {
			$passwordreset  = $objappuser->password_resets($newpassword,$userid);
			echo 'Message  Successfully sent your mail';exit;
		}
	 }
	 else
	{
		 echo "no data";exit;
	}
}
 
?>