<?php
//error_reporting(E_ALL);
//ini_set('display_errors',1);
ini_set('max_input_time', 300);
set_time_limit(300);
include "textarray.php";
include('../includes/eteamUtil.php');

$gentree		= 	array();
$album      	= 	array();
$info			= 	array();
$objappuser		= 	new user();
$objimages  	= 	new images();
$objtagging		=	new tagging();
$objuser		=	new geneuser();
$objtesti		=	new testi();
$objInstaAlbum  =   new instaimages();
$objInstaTags	=   new instatagging();

if($_POST['reqFor'] == '' || $_POST['reqFor'] == NULL) {
	 //echo "hii";exit;
	$_POST['username']  = 	"sys";
	$_POST['password']  = 	"admin";
	$_POST['reqFor'] 	= 	"sync";
	$_POST['date']		=	"2014-07-14 17:20:52";
}

if($_POST['reqFor'] == 'forgotpassword') {

	$flag = 0;
	$username		= 	$_POST['username'];
	if($username !="") {

	   $password		=  $objappuser->check_appuser_email($username);
	   $forgotpassword  =  $password['sys_password'];
	}

	if($forgotpassword) {

		$fullName		=	$password['sys_name']." ".$password['sys_surname'];
		$subject		=	'Albero genealogico Famiglia Boroli - Recupero password';
        $emailBody		= 	readTemplateFile('recupero_password.html');
        $emailBody_new	= 	str_replace("#email#",$username,$emailBody);
		$emailBody_new	= 	str_replace("#password#",$forgotpassword,$emailBody_new);
		$emailBody_new	= 	str_replace("#name#", $fullName, $emailBody_new);
		$send_mail		=	eteam_sendMail(FROM_MAILID, $username, $subject, $emailBody_new);

		if($send_mail	==	1) {

			$flag		=	1;
		} 
		else {

			$flag = 0;
		}
	}
	else {

		$flag = 2;
	}
	echo $flag;
}
else if($_POST['reqFor'] == 'resetpassword') {

	$username       =   $_POST['username'];
	$newpassword    =   $_POST['newpassword'];
	$oldpasswrd     =   $_POST['oldpassword'];
	$flag = 0;
	if($username !="" && $newpassword!="" && $oldpasswrd!="") {

	   $passwordetail	=  	$objappuser->check_users($username,$oldpasswrd);
	   $passwords		=  	$passwordetail['sys_password'];
	   $user_email		=  	$passwordetail['sys_email'];  
	   $userid			=  	$passwordetail['user_id'];
	   $fullName		=   $passwordetail['sys_name']." ".$passwordetail['sys_surname'];	
		   
		if($passwordetail) {

			 $subject		=	'Reset Password';
			 $emailbody     =   "La password resettata è \n\n$newpassword\n\n Thanks,\n\n GruppoZenit";
             $emailBody		= 	readTemplateFile('recupero_password.html');
        	 $emailBody_new	= 	str_replace("#email#", $user_email, $emailBody);
			 $emailBody_new	= 	str_replace("#password#", $newpassword, $emailBody_new);
			 $emailBody_new	= 	str_replace("#name#", $fullName, $emailBody_new);
			 $send_mail		=	eteam_sendMail(FROM_MAILID, $user_email, $subject, $emailBody_new);
			
			if(!$send_mail) {

				$flag = 0;
			} else {	

				$passwordreset  = $objappuser->password_resets($newpassword,$userid);				
				$flag	=	1;				
			}
		 }
		 else {

			$flag = 3;
		 }
	}
	echo $flag;
}

else if($_POST['reqFor'] == 'authenticate') {

	$username		= 	$_POST['username'];
	$password		= 	$_POST['password'];
	$login_check	=	$objappuser->loginJsoncheck($username, $password);

	if($login_check != 0)
		echo "1";
	else
		echo "0";
}
/*insta album*/
else if($_POST['reqfor'] == 'uploadPhoto'){
		//echo "hii";exit;
		$photoLocalId 		= $_POST['photoLocalId'];
		
		$photoTitle 		= $_POST['photoTitle'];

		$photoName			= $_POST['photoName'];

		$photoDescription 	= $_POST['photoDescription'];

		$serverId			= $_POST['serverId'];

		$delStatus 			= $_POST['delStatus'];
		
		$photoObject 		= $_POST['photoObject'];

		$user_id 			= $_POST['userid'];

		$imageDate          = $_POST['localDate'];

		$getImage 			= getImageName($photoName, $photoObject, $user_id);
		
		if($delStatus == 1){
		 
		  if($photoTitle !='' || $imageDate !='' || $getImage!='error'){
			if($serverId == 0){
				
				$insertArray	=	array(
									 "user_id"           	=>	$user_id,
									 "image_title"		    =>	$photoTitle,
									 "image_description"	=>	$photoDescription,
									 "image_src"            =>	basename($getImage),
									 "image_date"           =>	$imageDate,
									 "image_publish"        =>	'1',
			                         "LastModifiedTime"     =>  date('Y-m-d H:i:s'),
									 "Trash"				=>  '1' 
								);	

				$insert_image	=   $objInstaAlbum->insertImagedetail($insertArray);
				$image_id       =   mysql_insert_id();
				$insta_image_array['instaImageArray'] = array("serverId" => $image_id, "imageName" => basename($getImage),"imageDate"=>$imageDate, "LastModifiedTime"=>date('Y-m-d H:i:s'));
				echo json_encode($insta_image_array);
				}
				if($serverId != 0)
				{
					$updateArray	=	array(
								 "user_id"              =>	$user_id,
								 "image_title"		    =>	$photoTitle,
								 "image_description"	=>	$photoDescription,
								 "image_src"            =>	basename($getImage),
								 "image_date"           =>	$imageDate,
								 "image_publish"        =>	'1',
								 "LastModifiedTime"     =>  date('Y-m-d H:i:s'),
			                     "Trash"				=>  '1'		                     					 
								);		
					$update_image	=   $objInstaAlbum->updateImagedetails($updateArray, $serverId);
					$insta_image_array['instaImageArray'] = array("serverId" => $image_id, "imageName" => basename($getImage),"imageDate"=>$imageDate, "LastModifiedTime"=>date('Y-m-d H:i:s'));
				    echo json_encode($insta_image_array);
				}
			}else{
				echo "error";
			}
		}
	}
	/*end for Insta ALbum*/
/* start for tag add*/
/*else if($_POST['reqFor'] == 'tagPhoto'){
//echo  $_POST['reqFor'];exit;
//$tagDetails[$tag_count]['id'] 
	$image_id		= $_POST['id_image'];//'328';
	$tag_x  		= $_POST['x'];//'619.497';
	$tag_y			= $_POST['y'];//'424.842';
	$tag_width 		= $_POST['width'];
	$tag_height 	= $_POST['height'];
	$tag_tagname 	= $_POST['tagname'];
	$delete_status 	= $_POST['delete_status'];
	$serverId 		= $_POST['serverId'];
	if($delete_status == 1){
		if($serverId  == 0){
			$insertArray	=	array(
									 "id_image"           	=>	$image_id,
									 "tag_x_cord"		    =>	$tag_x,
									 "tag_width"			=>	$tag_width,
									 "tag_y_cord"           =>	$tag_y,
									 "tag_heigth"           =>	$tag_height,
									 "tagged_name"        	=>	$tag_tagname,
			                         "LastModifiedTime"     =>  date('Y-m-d H:i:s'),
									 "Trash"				=>  '1' 
								);
			$insert_tag		=   $objInstaTags->insertTagdetail($insertArray);

		}
	}  
}*/
/* end for tag add*/
else {

	$username		= 	$_POST['username'];
	$password		= 	$_POST['password'];
	$date			=	$_POST['date'];
     //echo $password;exit;
	$login_check	=	$objappuser->loginJsoncheck($username, $password);
	//print_r($login_check);exit;
	$user_name		=	$login_check['sys_user_name'];
	$pass_word		=	$login_check['sys_password'];
	$user_id 		=   $login_check['user_id'];

	if($login_check['sys_name'] == '')
		$login_check['sys_name']	=	0;	
	if($login_check['sys_surname'] == '')
		$login_check['sys_surname']	=	0;
	if($login_check['sys_email'] == '')
		$login_check['sys_email']	=	0;
		
	$logged_name	=	$login_check['sys_name'];
	$logged_surname	=	$login_check['sys_surname'];
	$logged_email	=	$login_check['sys_email'];

	$uploadPath		=	UPLOAD_PATH; //"http://".$_SERVER["SERVER_NAME"]."/dea_albero_2/upload";
	$dates 			= 	date('Y-m-d H:i:s');
	$tim 			= 	$dates; 
	//echo $_POST['reqFor'];exit; 
	if($_POST['reqFor'] == 'login') {  
 		
	   $reqfor  = 'login';
	   $condition ="";
	   //echo $reqfor;
	}
	else if($_POST['reqFor']=='sync') {	

	   $reqfor   = 'sync';
	   $condition = $date;
	   $login_check = 1;
	   echo $reqfor;
	   echo $condition;
	}
	else if($_POST['reqFor']=='fullsync') {

		$reqfor  = 'fullsync';
	   	$condition ="";
	   	$login_check = 1;
	   	//echo $reqfor;
	}
	/*for Insta Album*/
	
	 if($login_check != 0) {
	       
			$memberList		=	getAllUsers($objuser, $uploadPath, $condition, $reqfor);
            
			$couples		=	getAllPairs($objuser, $condition, $reqfor);

			$galleryDetails	=	getGalleryDetails($objimages, $objtagging, $objuser, $uploadPath, $condition, $reqfor);
			
			$testi          =   getTestiDetails($objtesti, $reqfor, $condition);

			$generation		=	getgeneration($objuser, $condition, $reqfor);

			$rubrica_email  =	get_rubrica_email($objtesti);
		
		    $getInstaImages	=	getInstaImages($objInstaAlbum, $objappuser, $objInstaTags, $uploadPath, $condition, $reqfor);
			$loginarray 	= 	array("Reqfor"=>$reqfor,"Username"=>$username,"Password"=>$password,"time"=>$tim ,"name" => $logged_name, "surname" => $logged_surname, "email"=> $logged_email);
			$finalJson		=	$loginarray;
          
			$finalJson['Memberlist']['individual']	=	$memberList;
			$finalJson['couples'] 					= 	$couples;
			$finalJson['ALBUMS']['gallery']			=	$galleryDetails;
			$finalJson['UptoSecondGenIds'] 			= 	$generation;
			$finalJson['message_albero'] 			= 	$testi['message_albero'];
			$finalJson['message_introduzione'] 		= 	$testi['message_introduzione'];
			$finalJson['instaAlbums']['images']		=	$getInstaImages;
			$finalJson['AppResponsibleEmailID'] 	= 	'famigliaboroli@deagostini.it';	
			$finalJson['AppResponsibleEmailDI'] 	= 	$rubrica_email; 
			$gentree['Gentree'] = $finalJson;
			//echo json_encode($finalJson);
			echo"<pre>";print_r($gentree);echo"</pre>";
				
	}
	else {

		echo "0";
	}	
}
?>