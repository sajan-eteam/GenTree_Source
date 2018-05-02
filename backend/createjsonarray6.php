<?php
include "json_functions_test.php";
include('../includes/eteamUtil.php');
//$login		= 	"login";
//$username		= 	"sys";
//$password		= 	"admin";
//$sync			=	"sync";
//$date			=	"2013-09-25 09:19:25";
//$time       	= 	"0000-00-00 00:00:00";

$_POST['username']  = 	"sys";
$_POST['password']  = "admin";
$_POST['reqFor'] = 	"login";


$gentree		= 	array();
$album      	= 	array();
$objappuser		= 	new user();
$objimages  	= 	new images();
$info			= 	array();
$objtagging		=	new tagging();
$objuser		=	new geneuser();
$objtesti		=	new testi();

if($_POST['reqFor'] == 'forgotpassword')
{
	$flag = 0;
	$username		= 	$_POST['username'];
	if($username !="")
	{
	   $password		=  $objappuser->check_appuser_email($username);
	   $forgotpassword  =  $password['sys_password'];
	}
	if($forgotpassword)
	{		
		$fullName		=	$password['sys_name']." ".$password['sys_surname'];
		/*$mail = new PHPMailer();
		$mail->IsMail();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host     = "Swmail.gruppozenit.com"; // SMTP server
		$mail->From     = "admin@gentree.com";
		$mail->AddAddress($username);
		$mail->Subject  = "Password dimenticata";
		$mail->Body     = "La tua password è \n\n$forgotpassword\n\n Thanks,\n\n GruppoZenit";
		$mail->WordWrap = 50;*/
		$subject		=	'Albero genealogico Famiglia Boroli - Recupero password';
        $emailBody		= 	readTemplateFile('recupero_password.html');
        $emailBody_new	= 	str_replace("#email#",$username,$emailBody);
		$emailBody_new	= 	str_replace("#password#",$forgotpassword,$emailBody_new);
		$emailBody_new	= 	str_replace("#name#", $fullName, $emailBody_new);
		$send_mail		=	eteam_sendMail(FROM_MAILID, $username, $subject, $emailBody_new);

		if($send_mail	==	1)
		{
			$flag		=	1;
		}
		else
		{
			$flag = 0;
		}
	}
	else
	{	
		$flag = 2;
	}
	echo $flag;
}
else if($_POST['reqFor'] == 'resetpassword')
{
	$username       =   $_POST['username'];
	$newpassword    =   $_POST['newpassword'];
	$oldpasswrd     =   $_POST['oldpassword'];
	$flag = 0;
	if($username !="" && $newpassword!="" && $oldpasswrd!="")
	{
	   $passwordetail	=  $objappuser->check_users($username,$oldpasswrd);
	   $passwords		=  $passwordetail['sys_password'];
	   $user_email		=  $passwordetail['sys_email'];  
	   $userid			=  $passwordetail['user_id'];

	   $fullName		=   $passwordetail['sys_name']." ".$passwordetail['sys_surname'];	
		   
		if($passwordetail)
		{
			 $subject		=	'Reset Password';
			 $emailbody     =   "La password resettata è \n\n$newpassword\n\n Thanks,\n\n GruppoZenit";
             $emailBody		= 	readTemplateFile('recupero_password.html');
        	 $emailBody_new	= 	str_replace("#email#", $user_email, $emailBody);
			 $emailBody_new	= 	str_replace("#password#", $newpassword, $emailBody_new);
			 $emailBody_new	= 	str_replace("#name#", $fullName, $emailBody_new);
			 $send_mail		=	eteam_sendMail(FROM_MAILID, $user_email, $subject, $emailBody_new);
			if(!$send_mail) 
			{
				$flag = 0;
			} else 
			{				
				$passwordreset  = $objappuser->password_resets($newpassword,$userid);				
				$flag	=	1;				
			}
		 }
		 else
		{
			$flag = 3;
		}
	}
	echo $flag;
}

else
{

	//$reqfor		=   $_POST['reqFor'];    
	$username		= 	$_POST['username'];
	$password		= 	$_POST['password'];
	$date			=	$_POST['date'];

	$login_check	=	$objappuser->loginJsoncheck($username,$password);
	
	$user_name		=	$login_check['sys_user_name'];
	$pass_word		=	$login_check['sys_password'];
	if($login_check['sys_name'] == '')
		$login_check['sys_name']	=	0;	
	if($login_check['sys_surname'] == '')
		$login_check['sys_surname']	=	0;
	if($login_check['sys_email'] == '')
		$login_check['sys_email']	=	0;
		
	$logged_name	=	$login_check['sys_name'];
	$logged_surname	=	$login_check['sys_surname'];
	$logged_email	=	$login_check['sys_email'];

	$url			=	UPLOAD_PATH; //"http://".$_SERVER["SERVER_NAME"]."/dea_albero_2/upload";
	$dates 			= 	date('Y-m-d H:i:s');
	$tim 			= 	$dates; 
	
	if($_POST['reqFor']=='login')
	{  
 
	   $reqfor  = 'login';
	   $condition ="";
	}
	if($_POST['reqFor']=='sync')
	{	
	   $reqfor   = 'sync';
	   $condition = $date;
	}
   if($login_check != 0)
	{       

			$data			=	getAllUsers($objuser,$url,$condition,$reqfor);
			$pairs			=	getAllPairs($objuser,$condition,$reqfor);
			$testi          =   getTestiDetails($objtesti,$reqfor,$condition);
			$generation		=	getgeneration($objuser,$condition,$reqfor);

			$fata			=	getGalleryDetails($objimages, $objtagging, $objuser, $url, $condition, $reqfor);
			
			$loginarray 	= 	array("Reqfor"=>$reqfor,"Username"=>$username,"Password"=>$password,"time"=>$tim ,"name" => $logged_name, "surname" => $logged_surname, "email"=> $logged_email);
			$finalJson		=	$loginarray;
          
			$finalJson['Memberlist']['individual']=$data;
			$finalJson['couples'] = $pairs;
			$finalJson['ALBUMS']['gallery']=$fata;
			$finalJson['UptoSecondGenIds'] = $generation;
			//$finalJson['TextDetails'] = $testi;
			$finalJson['message_albero'] 		= $testi['message_albero'];
			$finalJson['message_introduzione'] 	= $testi['message_introduzione'];
			//$finalJson['requesteddate']=$condition;
			$gentree['Gentree'] = $finalJson;
			//echo"<PRE>";print_r($gentree);echo"</PRE>";
			/*$current 	 = file_get_contents($file);
			$current 	.= implode(",", $gentree); 
			$current 	.= PHP_EOL;
			file_put_contents($file, $current);*/
			echo json_encode($gentree);
			//echo $_POST['reqFor'];
	}
	else
	{
		echo "0";
	}

}

?>