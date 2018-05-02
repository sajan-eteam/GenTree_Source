<?php
include "json_functions.php";
include "PHPMailer/class.phpmailer.php";

//$login		= 	"login";
//$username		= 	"sys";
//$password		= 	"admin";
//$sync			=	"sync";
//$date			=	"2013-09-25 09:19:25";
//$time       	= 	"0000-00-00 00:00:00";

$_POST['reqFor']	=	'sync';
$date				=	"2013-10-28 22:10:00";
$username			= 	"sys";
$password			= 	"admin";

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
	   //echo $username;exit;
	}
	if($forgotpassword)
	{		
		$mail = new PHPMailer();
		$mail->IsMail();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host     = "Swmail.gruppozenit.com"; // SMTP server
		$mail->From     = "admin@gentree.com";
		$mail->AddAddress($username);
		$mail->Subject  = "Forgot Password";
		$mail->Body     = "Hi! \n\n Your Password is\n\n$forgotpassword\n\n Thanks,\n\n GruppoZenit";
		$mail->WordWrap = 50;
		if(!$mail->Send()) {
			$flag = 0;
		} else {
			$flag = 1;
		}
	}
	else
	{	
		$flag = 0;
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
		   
		if($passwordetail)
		{
			//echo "eee";exit;
			
			$mail = new PHPMailer();
			$mail->IsMail();
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->Host     = "Swmail.gruppozenit.com"; // SMTP server
			$mail->From     = "from@example.com";
			$mail->AddAddress($user_email);
			$mail->Subject  = "Reset Password";
			$mail->Body     = "Hi! \n\n Your Reset Password is\n\n$newpassword\n\n Thanks,\n\n GruppoZenit";
			$mail->WordWrap = 50;
			if(!$mail->Send()) 
			{
				$flag = 0;
			} else 
			{
				
				$passwordreset  = $objappuser->password_resets($newpassword,$userid);
				//echo '1';	
				$flag	=	1;				
			}
		 }
		 else
		{
			$flag = 0;
		}
	}
	echo $flag;
}

else
{
	//$reqfor		=   $_POST['reqFor'];
    
	/*
	$username		= 	$_POST['username'];
	$password		= 	$_POST['password'];
	$date			=	$_POST['date'];
	*/

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
			$fata			=	getGalleryDetails($objimages,$objtagging,$objuser,$url,$condition,$reqfor);
			$testi          =   getTestiDetails($objtesti,$reqfor,$condition);

			$loginarray = array("Reqfor"=>$reqfor,"Username"=>$username,"Password"=>$password,"time"=>$tim ,"name" => $logged_name, "surname" => $logged_surname, "email"=> $logged_email);
			$finalJson	=$loginarray;
          
			$finalJson['Memberlist']['individual']=$data;
			$finalJson['couples'] = $pairs;
			$finalJson['ALBUMS']['gallery']=$fata;
			//$finalJson['TextDetails'] = $testi;
			$finalJson['message_albero'] 		= $testi['message_albero'];
			$finalJson['message_introduzione'] 	= $testi['message_introduzione'];
			//$finalJson['requesteddate']=$condition;
			 $gentree['Gentree'] = $finalJson;
			echo"<PRE>";print_r($gentree);echo"</PRE>";
			//echo json_encode($gentree);
			//echo $_POST['reqFor'];
	}
	else
	{
		echo "0";
	}

}

?>