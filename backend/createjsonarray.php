<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
set_time_limit(300);
include"SimpleImage.php";
include "json_functions.php";

include "PushNotificationIOS.php";

include('../includes/eteamUtil.php');
include "loggfile.php";

$album      	= 	array();
$info			= 	array();
$objappuser		= 	new user();
$objimages  	= 	new images();
$objtagging		=	new tagging();
$objuser		=	new geneuser();
$objtesti		=	new testi();
$objInstaAlbum  =   new instaimages();
$objInstaTags	=   new instatagging();
$objLike		=   new like();
if($_POST['reqFor'] == '' || $_POST['reqFor'] == NULL) {
	$_POST['username']  = 	"lorenzo";
	$_POST['password']  = 	"pippo123";
	$_POST['reqFor'] 	= 	"login";
	//$_POST['serverId'] 	=    "414";
	//$_POST['device'] 	=   "iphone";
	//$_POST['date']		=	"2014-11-26 08:26:51";
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
		$use_name 		=	$password['sys_user_name'];
		$subject		=	'Albero genealogico Famiglia Boroli - Recupero password';
        $emailBody		= 	readTemplateFile('recupero_password.html');
        $emailBody_new	= 	str_replace("#email#",$use_name,$emailBody);
		$emailBody_new	= 	str_replace("#password#",$forgotpassword,$emailBody_new);
		$emailBody_new	= 	str_replace("#name#", $fullName, $emailBody_new);
		$send_mail		=	eteam_sendMail(FROM_MAILID, $username, $subject, $emailBody_new);
		if($send_mail	==	1) {
			$logtext =	'Recupero password: email inviata con successo.';
			$flag		=	1;
		} 
		else {
			$logtext =	'Recupero password: invio email fallito';
			$flag = 0;
		}
	}
	else {
		$logtext =	'Recupero password: email non valida.';
		$flag = 2;
	}
	logInsert($userID='', 2, $logtext);
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
				$logtext =	'Recupero password: email inviata con successo.';
				$flag = 0;
			} else {	
				$passwordreset  = $objappuser->password_resets($newpassword,$userid);
				$logtext =	'Recupero password: invio email fallito';				
				$flag	=	1;				
			}
		 }
		 else {
		 	$logtext =	'Reset password: email non valida.';
			$flag = 3;
		 }
	}
	logInsert($userID='', 3, $logtext);
	echo $flag;
}
else if($_POST['reqFor'] == 'authenticate') {
	$username		= 	$_POST['username'];
	$password		= 	$_POST['password'];
	$login_check	=	$objappuser->loginJsoncheck($username, $password);
	if($login_check != 0){
		$userID  = 	 $login_check['user_id'];
		$logtext =	'Autenticazione avvenuta con successo.';
		$msg = "1";
	}else{
		$logtext =	'Autenticazione fallita.';
		$msg = "0";
	}
logInsert($userID , 11, $logtext);	
echo $msg;
}
/*insta album*/
else if($_POST['reqfor'] == 'uploadPhoto'){
		
		$photoLocalId 		= $_POST['photoLocalId'];
		$photoTitle 		= $_POST['photoTitle'];
		$photoName			= $_POST['photoName'];
		$photoDescription 	= $_POST['photoDescription'];
		$serverId			= $_POST['serverId'];
		$delStatus 			= $_POST['delStatus'];
		$photoObject 		= $_POST['photoObject'];
		$user_id 			= $_POST['userid'];
		$imageDate          = $_POST['localDate'];
		$imglength			= $_POST['imglength'];
		$appversion 	    = $_POST['appversion'];
		$imageUploadStatus  = $_POST['uploadStatus'];
		$device_id          = $_POST['device_id'];
		$getImage 			= getImageName($photoName, $photoObject, $user_id);
		$uploderName        = $objappuser->getUser($user_id);
		$fullName			= $uploderName['sys_name'].' '.$uploderName['sys_surname'];
		if($delStatus == 1 && $serverId == 0 && $imageUploadStatus == 0){ 
			if(($photoTitle != "") && ($imageDate != "")  && ($getImage != "")){
				$insertArray	=	array(
									 "user_id"           	=>	$user_id,
									 "image_title"		    =>	$photoTitle,
									 "image_description"	=>	$photoDescription,
									 "image_src"            =>	basename($getImage),
									 "image_date"           =>	$imageDate,
									 "image_publish"        =>	'0',
			                         "LastModifiedTime"     =>  date('Y-m-d H:i:s'),
									 "Trash"				=>  '1' 
								);	
				
					$insert_image	=   $objInstaAlbum->insertImagedetail($insertArray);
					$image_id       =   mysql_insert_id();
					echo $image_id;	


		}else{
			$logtext = 'Instafamily: immagine non aggiunta.';
			logInsert($user_id, 5, $logtext);
			echo "0";
		}
	}
	if($imageUploadStatus != 0 && $delStatus == 1){

					$imageDetails      = $objInstaAlbum->getImageDetails($imageUploadStatus);
					$image_date        = $imageDetails['image_date'];
					$userId       	   = $imageDetails['user_id'];
					$im 		   	   = $imageDetails['image_src'];
					$uploderName       = $objappuser->getUser($userId);
					$fullName		   = $uploderName['sys_name'].' '.$uploderName['sys_surname'];
					$simpleImage 	= 	new SimpleImage();
					$width			=	'806';
					$simpleImage->load("../upload/".$im); 
					$simpleImage->resizeToWidth($width);
					$simpleImage->save("../upload/"."T_".$im);
					$tlWidth		=    '638';
					$simpleImage->resizeToWidth($tlWidth);
					$simpleImage->save("../upload/"."TL_".$im);
					$tsWidth		=	 '330';
					$simpleImage->resizeToWidth($tsWidth);
					$simpleImage->save("../upload/"."TS_".$im);
					$updateArray	=	array(
				                     "image_publish"        =>	'1',
				                     "LastModifiedTime"     =>  $LastModifiedTime,	                     					 
									);
					$update_image	=   $objInstaAlbum->updateImagedetails($updateArray, $imageUploadStatus);	
					$insta_image_array['instaImageArray'] = array(	"serverId" 		    => $imageUploadStatus,
																	"userId"			=> $userId,
																	"fullName" 			=> $fullName,
																	"imageName" 		=> $im,
																	"imageThumpName"	=> "T_".$im,
																	"imageThumpLarge"	=> "TL_".$im,
																	"imageThumpSmall"	=> "TS_".$im,
																	"imageDate"			=> $image_date,
																	"LastModifiedTime"	=> date('Y-m-d H:i:s')
						 );
					
				  $msgArray  = array("s_id" => $imageUploadStatus,"u_id" => $userId,"status"=>"1");
				  $pushnotification = $objInstaAlbum->selectAllDevice($device_id);
				  //echo "1 - ".$device_id;
				   foreach($pushnotification as $pushnotify){
				   	//echo "1 - iNN";
					$puchIOSObj = new PushNotificationIOS();
						$puchIOSObj->setDeviceTocken($pushnotify['device_tocken']);
						$puchIOSObj->setPassphrase('123');
						$puchIOSObj->setMessage($msgArray);
						$res = $puchIOSObj->sendToFamigliaSilent();
						$res = $puchIOSObj->sendToInstaFamilySilent();
					}
					$logtext = 'Instafamily: immagine aggiunta con successo.';
					logInsert($userId, 5, $logtext);	
					echo json_encode($insta_image_array);
	}
	if( $delStatus == 1 &&  $serverId != 0){
			 	
				$imageDetails      = $objInstaAlbum->getImageDetails($serverId);
				$LastModifiedTime  = date('Y-m-d H:i:s');
				if($photoDescription == '' || $imageDate == '' ){

					$photoDescription  =	$imageDetails['image_description'];
					$image_date        =    $imageDetails['image_date'];
					$LastModifiedTime  =    $imageDetails['LastModifiedTime'];
				}
				$updateArray	=	array(
							 "image_description"	=>	$photoDescription,
							 "image_date"			=>	$imageDate,
		                     "image_publish"        =>	'1',
		                     "LastModifiedTime"     =>  $LastModifiedTime,
							 "Trash"				=>  '1' 	                     					 
							);
				$update_image	=   $objInstaAlbum->updateImagedetails($updateArray, $serverId);
				$msgArray  = array("s_id" => $serverId,"u_id" => $user_id,"status"=>"2");
				  $pushnotification = $objInstaAlbum->selectAllDevice($device_id);
				   //echo "2 - ".$device_id;
				   foreach($pushnotification as $pushnotify){
				   	//echo "2 - iNN";
					$puchIOSObj = new PushNotificationIOS();
						$puchIOSObj->setDeviceTocken($pushnotify['device_tocken']);
						$puchIOSObj->setPassphrase('123');
						$puchIOSObj->setMessage($msgArray);
						$res = $puchIOSObj->send();
					}
				$logtext = 'Instafamily: immagine aggiornata.';
				logInsert($user_id, 6, $logtext);
				echo "1";
		}	
		if($delStatus == 0 ){
			$image_id 		= $_POST['serverId'];
			$trash 			= '0';
			$deletetime     = date('Y-m-d H:i:s');
			if($image_id  == ''){
				$logtext = 'Instfamily: immagine non eliminata.';
				logInsert($user_id, 7, $logtext);
				echo "Failed";
			}
			else{
				$delete_image	= $objInstaAlbum->deleteTrashImage($trash,$deletetime,$image_id);
				$del = $objLike->deletelike($image_id);
				$msgArray  = array("s_id" => $image_id,"u_id" => $user_id,"status"=>"0");
				$pushnotification = $objInstaAlbum->selectAllDevice($device_id);
				//echo "3 - ".$device_id;
				   foreach($pushnotification as $pushnotify){
				   	//echo "3 - iNN";
					$puchIOSObj = new PushNotificationIOS();
					$puchIOSObj->setDeviceTocken($pushnotify['device_tocken']);
					$puchIOSObj->setPassphrase('123');
					$puchIOSObj->setMessage($msgArray);
					$res = $puchIOSObj->send();
			  }
				$logtext = 'Instafamily: immagine eliminata.';
				logInsert($user_id, 7, $logtext);
				echo "success";
			}
		}
	}
/*end for Insta ALbum*/
/*start for like table*/
else if($_POST['reqFor'] == 'likeInfo'){

	$image_id 	 = $_POST['serverId'];
	$user_id	 = $_POST['userId'];
	if($image_id !='' && $user_id !='' ){
	$likeimage   = $objLike->getLikeImage($image_id, $user_id);
	if(count($likeimage) > 0){
	$like_id	 = $likeimage[0]['like_id'];
	$updatelikeArray = array(
						 "like_status"     => $_POST['likeStatus'],
						 "last_modified"    => date('Y-m-d H:i:s')
		);
	$insertLikeStatus = $objLike->updateLikedetail($updatelikeArray,$like_id);
	$updateArray	  = array('LastModifiedTime' => date('Y-m-d H:i:s'));
	$updateImageTime  = $objInstaAlbum->updateImagedetails($updateArray,$image_id);
	$logtext = 'Immagine Insta Album come aggiornato con successo';
	logInsert($user_id, 9, $logtext);
	echo "1";
	}else{
	$insertArray = array("image_id"        => $image_id,
						 "user_id"         => $user_id,
						 "like_status"     => $_POST['likeStatus'],
						 "last_modified"   => date('Y-m-d H:i:s')
		);
	$insertLikeStatus = $objLike->insertLikedetail($insertArray);
	$updateArray	  = array('LastModifiedTime' => date('Y-m-d H:i:s'));
	$updateImageTime  = $objInstaAlbum->updateImagedetails($updateArray,$image_id);
	$logtext = 'Immagine Insta Album come aggiunto con successo';
	logInsert($user_id, 9, $logtext);
	echo "1";
	}
  }else{
  	$logtext = 'Immagine Insta Album come fallito';
	logInsert($user_id, 9, $logtext);
  	echo "failed";
  }
}
/*end for like table*/	
else if($_POST['reqFor'] == 'tagPhoto'){

  $imageId 		  = $_POST['image_id'];
  $tagDetetion    = $_POST['tagDetetion'];
  $userId 		  = $_POST['userId'];
  $array  =  stripslashes($_POST['tagdata']);
  $data   =  json_decode($array,true);
  $cnt    =  count($data['tag']);
  $tagDetetionRes = $objInstaTags->getTagDetetion($imageId, $tagDet=1);
  $count = count($tagDetetionRes);
  if($tagDetetion == 1){
	for($i=0; $i<$cnt; $i++){
		
		$x  	 	 = $data['tag'][$i]['x'];
		$photoid 	 = $data['tag'][$i]['photoid'];
		$y  	 	 = $data['tag'][$i]['y'];
		$height  	 = $data['tag'][$i]['h'];  
		$width   	 = $data['tag'][$i]['w'];
		$image_width = $data['tag'][$i]['imgw'];
		$image_height= $data['tag'][$i]['imgh'];
		$image_x 	 = $data['tag'][$i]['imgx'];
		$image_y     = $data['tag'][$i]['imgy'];
		$delstatus   = $data['tag'][$i]['delete_status'];
		$tagname  	 = $data['tag'][$i]['tagname'];
		$tagcounter  = $data['tag'][$i]['tagcounter'];
		$device 	 = $data['tag'][$i]['device'];
		$tagDetetion = $data['tag'][$i]['tagDetetion'];
			
				$insertArray	=	array(
										 "id_image"           	=>	$photoid,
										 "tag_x_cord"		    =>	$x,
										 "tag_width"			=>	$width,
										 "tag_y_cord"           =>	$y,
										 "tag_heigth"           =>	$height,
										 "image_width"			=>  $image_width,
										 "image_height"			=>	$image_height,
										 "image_y"				=>	$image_y,
										 "image_x"              =>  $image_x,
										 "tagged_name"        	=>	$tagname,
										 "tag_counter"          =>  $tagcounter,
										 "tag_detetion"			=>	$tagDetetion,
										 "device_name"			=>  $device,
				                         "LastModifiedTime"     =>  date('Y-m-d H:i:s'),
										 "Trash"				=>  '1' 
									);
						
				$insert_tag		=   $objInstaTags->insertTagdetail($insertArray);
				$tag_id       	=   mysql_insert_id();
				$update    =   array(
					'LastModifiedTime' => date('Y-m-d H:i:s')
					);
				$update_image	=   $objInstaAlbum->updateImagedetails($update, $photoid);
				$tagarray[$i]['backendid']  	= $tag_id;
				$tagarray[$i]['tagcounter'] 	= $tagcounter;
				$tagarray[$i]['image_id']   	= $photoid;
				$tagarray[$i]['tag_x_cord']   	= $x;
				$tagarray[$i]['tag_width']   	= $width;
				$tagarray[$i]['tag_y_cord']   	= $y;
				$tagarray[$i]['tag_height']   	= $height;
				$tagarray[$i]['image_width']   	= $image_width;
				$tagarray[$i]['image_height']   = $image_height;
				$tagarray[$i]['image_y']   		= $image_y;
				$tagarray[$i]['image_x']   		= $image_x;
				$tagarray[$i]['tagged_name']   	= $tagname;
				$tagarray[$i]['tag_detetion']   = $tagDetetion;
				$tagarray[$i]['device_name']    = $device;
				$tagarray[$i]['LastModifiedTime']= date('Y-m-d H:i:s');
				$tagarray[$i]['Trash']			 = '1';

  }
}else{
 if($count>0){
	  	   for($j=0;$j<$count;$j++){
		  		$tagarray[$j]['backendid']  	= $tagDetetionRes[$j]['id_tag'];
				$tagarray[$j]['tagcounter'] 	= $tagDetetionRes[$j]['tag_counter'];
				$tagarray[$j]['image_id']   	= $tagDetetionRes[$j]['id_image'];
				$tagarray[$j]['tag_x_cord']  	= $tagDetetionRes[$j]['tag_x_cord'];
				$tagarray[$j]['tag_width'] 		= $tagDetetionRes[$j]['tag_width'];
				$tagarray[$j]['tag_y_cord']   	= $tagDetetionRes[$j]['tag_y_cord'];
				$tagarray[$j]['tag_height']  	= $tagDetetionRes[$j]['tag_heigth'];
				$tagarray[$j]['image_y'] 		= $tagDetetionRes[$j]['image_y'];
				$tagarray[$j]['image_x']   		= $tagDetetionRes[$j]['image_x'];
				$tagarray[$j]['tagged_name']  	= $tagDetetionRes[$j]['tagged_name'];
				$tagarray[$j]['tag_detetion'] 	= $tagDetetionRes[$j]['tag_detetion'];
				$tagarray[$j]['device_name']   		= $tagDetetionRes[$j]['device_name'];
				$tagarray[$j]['LastModifiedTime'] 	= $tagDetetionRes[$j]['LastModifiedTime'];
				$tagarray[$j]['Trash']   			= $tagDetetionRes[$j]['Trash'];
	  		}
}else {
	for($i=0; $i<$cnt; $i++){
		$x  	 	 = $data['tag'][$i]['x'];
		$photoid 	 = $data['tag'][$i]['photoid'];
		$y  	 	 = $data['tag'][$i]['y'];
		$height  	 = $data['tag'][$i]['h'];  
		$width   	 = $data['tag'][$i]['w'];
		$image_width = $data['tag'][$i]['imgw'];
		$image_height= $data['tag'][$i]['imgh'];
		$image_x 	 = $data['tag'][$i]['imgx'];
		$image_y     = $data['tag'][$i]['imgy'];
		$delstatus   = $data['tag'][$i]['delete_status'];
		$tagname  	 = $data['tag'][$i]['tagname'];
		$tagcounter  = $data['tag'][$i]['tagcounter'];
		$device 	 = $data['tag'][$i]['device'];
		$tagDetetion = $data['tag'][$i]['tagDetetion'];
				$insertArray	=	array(
										 "id_image"           	=>	$photoid,
										 "tag_x_cord"		    =>	$x,
										 "tag_width"			=>	$width,
										 "tag_y_cord"           =>	$y,
										 "tag_heigth"           =>	$height,
										 "image_width"			=>  $image_width,
										 "image_height"			=>	$image_height,
										 "image_y"				=>	$image_y,
										 "image_x"              =>  $image_x,
										 "tagged_name"        	=>	$tagname,
										 "tag_counter"          =>  $tagcounter,
										 "tag_detetion"			=>	$tagDetetion,
										 "device_name"			=>  $device,
				                         "LastModifiedTime"     =>  date('Y-m-d H:i:s'),
										 "Trash"				=>  '1' 
									);
						
				$insert_tag		=   $objInstaTags->insertTagdetail($insertArray);
				$tag_id       	=   mysql_insert_id();
				$update    =   array(
					'LastModifiedTime' => date('Y-m-d H:i:s')
					);
				$update_image	=   $objInstaAlbum->updateImagedetails($update, $photoid);
				$tagarray[$i]['backendid']  	= $tag_id;
				$tagarray[$i]['tagcounter'] 	= $tagcounter;
				$tagarray[$i]['image_id']   	= $photoid;
				$tagarray[$i]['tag_x_cord']   	= $x;
				$tagarray[$i]['tag_width']   	= $width;
				$tagarray[$i]['tag_y_cord']   	= $y;
				$tagarray[$i]['tag_height']   	= $height;
				$tagarray[$i]['image_width']   	= $image_width;
				$tagarray[$i]['image_height']   = $image_height;
				$tagarray[$i]['image_y']   		= $image_y;
				$tagarray[$i]['image_x']   		= $image_x;
				$tagarray[$i]['tagged_name']   	= $tagname;
				$tagarray[$i]['tag_detetion']   = $tagDetetion;
				$tagarray[$i]['device_name']    = $device;
				$tagarray[$i]['LastModifiedTime']= date('Y-m-d H:i:s');
				$tagarray[$i]['Trash']			 = '1';
		}
  	}
}	
$insta_image_array['tagDetails']  = $tagarray;
$insta_image_array['tagStatus']  = 'tagSuccess';
$logtext = 'Instafamily: tag aggiunto con successo.';
logInsert($userId, 8, $logtext);
echo json_encode($insta_image_array);
} 
else if($_POST['reqFor'] == 'tagUpdation'){
$userId = $_POST['userId'];
$array  =  stripslashes($_POST['tagdata']);
$data   =  json_decode($array,true);
$cnt    =  count($data['tag']);
if($cnt>0){
	for($i=0; $i<=$cnt; $i++){
		$x  	 	 = $data['tag'][$i]['x'];
		$photoid 	 = $data['tag'][$i]['photoid'];
		$tagId 		 = $data['tag'][$i]['backendid'];
		$y  	 	 = $data['tag'][$i]['y'];
		$height  	 = $data['tag'][$i]['h'];  
		$width   	 = $data['tag'][$i]['w'];
		$image_width = $data['tag'][$i]['imgw'];
		$image_height= $data['tag'][$i]['imgh'];
		$image_x 	 = $data['tag'][$i]['imgx'];
		$image_y 	 = $data['tag'][$i]['imgy'];
		$delstatus   = $data['tag'][$i]['delete_status'];
		$tagname  	 = $data['tag'][$i]['tagname'];
		$tagcounter  = $data['tag'][$i]['tagcounter'];
		$device 	 = $data['tag'][$i]['device'];
		if($delstatus == 1){
				$updateArray	=	array(
										 "id_image"           	=>	$photoid,
										 "tag_x_cord"		    =>	$x,
										 "tag_width"			=>	$width,
										 "tag_y_cord"           =>	$y,
										 "tag_heigth"           =>	$height,
										 "image_width"			=>  $image_width,
										 "image_height"			=>	$image_height,
										 "image_y"				=>	$image_y,
										 "image_x"				=>  $image_x,
										 "tagged_name"        	=>	$tagname,
										 "tag_counter"          =>  $tagcounter,
										 "device_name"			=>  $device,
				                         "LastModifiedTime"     =>  date('Y-m-d H:i:s'),
										 "Trash"				=>  '1' 
									);

			$objInstaTags->deviceTaggingUpdate($updateArray, $tagId, $photoid, $tagcounter);
			$update    =   array(
				'LastModifiedTime' => date('Y-m-d H:i:s')
				);
			$update_image	=   $objInstaAlbum->updateImagedetails($update, $photoid);
			$tagarray[$i]['backendid']  = $tagId;
			$tagarray[$i]['tagcounter'] = $tagcounter;
			$tagarray[$i]['image_id']   = $photoid;
			$tagarray[$i]['tag_x_cord'] = $x;
			$tagarray[$i]['tag_width'] = $width;
			$tagarray[$i]['tag_y_cord'] = $y;
			$tagarray[$i]['tag_height'] = $height;
			$tagarray[$i]['image_y'] = $image_y;
			$tagarray[$i]['image_x'] = $image_x;
			$tagarray[$i]['tagged_name'] = $tagname;
			$tagarray[$i]['device_name'] = $device;
			$tagarray[$i]['LastModifiedTime'] =  date('Y-m-d H:i:s');
			$tagarray[$i]['Trash'] =  '1';
		}
	}
$insta_image_array['tagDetails']  = $tagarray;
$insta_image_array['tagStatus']  = 'tagupdated';
$logtext = 'Instafamily: tag aggiornato con successo.';
logInsert($userId, 8, $logtext);
echo json_encode($insta_image_array);
}else{
$logtext = 'Instafamily: aggiornamento del tag non riuscito.';
logInsert($userId, 8, $logtext);	
echo '0';
}
}
else if($_POST['reqFor'] == 'tagDeletion'){

			$photoId 	 	= $_POST['photoid'];
			$tagId 			= $_POST['backendid'];
			$deleteStatus 	= $_POST['delete_status'];
			$userId 		= $_POST['userId'];
			$updateArray	= array(   "LastModifiedTime"     =>	date('Y-m-d H:i:s'),
										"Trash"		      	  =>	'0' 
								    );
			if($deleteStatus == 0){
			$objInstaTags->deviceTaggingDelete($updateArray, $tagId, $photoId);
			$update    =   array(
				'LastModifiedTime' => date('Y-m-d H:i:s')
				);
			$update_image	=   $objInstaAlbum->updateImagedetails($update, $photoId);
			$tagArray 		= array(
				'backendid' => $tagId,
				'photoid'   => $photoId
				);
			$insta_image_array['tagDetails'] = $tagArray;
			$insta_image_array['tagStatus']  = 'tagdeleted';
			$logtext = 'Instafamily: tag eliminato con successo.';
			logInsert($userId, 8, $logtext);
			echo json_encode($insta_image_array);
		   }else{
		   	$logtext = 'Instafamily: tag non eliminato.';
			logInsert($userId, 8, $logtext);
			echo '0';
			}
}
else if($_POST['reqFor'] == 'deviceRegister'){
		$device_id = $_POST['device_id'];
		$device_tocken = $_POST['device_tocken'];
        $deviceToken = isset($device_tocken)?$device_tocken:'';
		if($device_id == ''){
		$insertArray = array("device_tocken" => $deviceToken,
		"last_modified" => date('Y-m-d H:i:s'));
        $deviceInsert = $objInstaAlbum->insertDevice($insertArray);
        $deviceInsertId = mysql_insert_id();
        $resultData =   $deviceInsertId;
		}else{
		$updateArray	= array( 
								 "device_tocken" => $deviceToken,
								 "last_modified" => date('Y-m-d H:i:s')
							   );
		$deviceupdateId = $objInstaAlbum->updateDevice($updateArray,$device_id);
        $resultData = $device_id;
       
		}
		$result = array("device_id" => $resultData); 
         echo json_encode($result);       
 }
 else if($_POST['reqFor'] == 'fotoDetails'){
	$image_id = $_POST['image_id'];
	$user_id  = $_POST['user_id'];
	$detail = $objInstaAlbum->imageview($image_id);
	$usr_id = $detail['user_id'];
	$uploderName       = $objappuser->getUser($usr_id);
	$fullName		   = $uploderName['sys_name'].' '.$uploderName['sys_surname'];
	$im = $detail['image_src'];
	$image_date = $detail['image_date'];
	$image_desc = $detail['image_description'];
    $insta_image_array['instaFotoArray'] = array("serverId" 	=> $image_id,
								"userId"			=> $user_id,
								"fullName" 			=> $fullName,
								"imageName" 		=> $im,
								"imageThumpName"	=> "T_".$im,
								"imageThumpLarge"	=> "TL_".$im,
								"imageThumpSmall"	=> "TS_".$im,
								"imageDate"			=> $image_date,
								"image_description" => $image_desc, 
								"LastModifiedTime"	=> date('Y-m-d H:i:s')
);
echo json_encode($insta_image_array['instaFotoArray']); 
 }
else {
	//echo "iNN";
	$username		= 	$_POST['username'];
	$password		= 	$_POST['password'];
	$date			=	$_POST['date'];
	$login_check	=	$objappuser->loginJsoncheck($username, $password);
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
	if($_POST['reqFor'] == 'login') { 
	//echo "iNN - 1"; 	
	   $reqfor  = 'login';
	   $condition =""; 
	   $reqforType = 'login';
	   $logType = 1;
	}
	else if($_POST['reqFor']=='sync') {	
	   $reqfor   = 'sync';
	   $condition = date('Y-m-d H:i:s', strtotime($date) - 5);
	   $login_check = 1;
	   $reqforType = 'sync';
	   $logType = 13;
	}
	else if($_POST['reqFor']=='fullsync') {
		$reqfor  = 'fullsync';
	   	$condition ="";
	   	$login_check = 1;
	   	$reqforType = 'fullsync';
	    $logType = 12;
	}
	/*for Insta Album*/
	if($_POST['device'] == 'iphone' && $login_check != 0){
		//echo "iNN - 2";

		$getInstaImages	     			=	getInstaImages($objInstaAlbum, $objInstaTags, $objLike, $objappuser, $uploadPath, $condition, $reqfor, $user_id);
		$loginarray 		 			= 	array("Reqfor"=>$reqfor,"userId"=>$user_id,"Username"=>getCleanString($username),"Password"=>$password,"time"=>$tim ,"name" => getCleanString($logged_name), "surname" => getCleanString($logged_surname), "email"=> $logged_email);
		$getInstaAllusers    			=   getInstaAllusers($objLike, $objappuser, $condition, $reqfor);
		$getInstaImgAllUser 			=   getInstaImageAllusers($objInstaAlbum, $objappuser, $condition, $reqfor);
		$finalJson			 			=	$loginarray;
		$finalJson['allusers']			=	$getInstaImgAllUser;
		$finalJson['likeusers']	    	=   $getInstaAllusers;
		$finalJson['instaAlbums']		=	$getInstaImages;
		$gentree['Gentree'] 			=   $finalJson;
		$deviceName 					=	'iPhone';
		$logtext 						= 	'Login da '.$deviceName.' avvenuto con successo  '.$reqforType;
		logInsert($user_id, $logType, $logtext);
		echo json_encode($gentree);
	}  
	else if($login_check != 0) {
	        //echo "iNN - 3";
			$memberList			=	getAllUsers($objuser, $uploadPath, $condition, $reqfor);
            
			$couples			=	getAllPairs($objuser, $condition, $reqfor);

			$galleryDetails		=	getGalleryDetails($objimages, $objtagging, $objuser, $uploadPath, $condition, $reqfor);
			
			$testi          	=   getTestiDetails($objtesti, $reqfor, $condition);

			$generation			=	getgeneration($objuser, $condition, $reqfor);

			$rubrica_email  	=	get_rubrica_email($objtesti);
			
		    $getInstaImages		=	getInstaImages($objInstaAlbum, $objInstaTags, $objLike, $objappuser, $uploadPath, $condition, $reqfor, $user_id);
		   
		    $getInstaAllusers   =   getInstaAllusers($objLike, $objappuser, $condition, $reqfor);

		    $getInstaImgAllUser =   getInstaImageAllusers($objInstaAlbum, $objappuser, $condition, $reqfor);
		    
			$loginarray 							= 	array("Reqfor"=>$reqfor,"userId"=>$user_id,"Username"=>getCleanString($username),"Password"=>$password,"time"=>$tim ,"name" => getCleanString($logged_name), "surname" => getCleanString($logged_surname), "email"=> $logged_email);
			$finalJson								=	$loginarray;
			$finalJson['allusers']					=	$getInstaImgAllUser;
         	$finalJson['likeusers']	    			=   $getInstaAllusers;
			$finalJson['Memberlist']['individual']	=	$memberList;
			$finalJson['couples'] 					= 	$couples;
			$finalJson['ALBUMS']['gallery']			=	$galleryDetails;
			$finalJson['UptoSecondGenIds'] 			= 	$generation;
			$finalJson['message_albero'] 			= 	$testi['message_albero'];
			$finalJson['message_introduzione'] 		= 	$testi['message_introduzione'];
			$finalJson['instaAlbums']				=	$getInstaImages;
			$finalJson['AppResponsibleEmailID'] 	= 	'famigliaboroli@deagostini.it';	
			$finalJson['AppResponsibleEmailID'] 	= 	$rubrica_email; //'famigliaboroli@deagostini.it';
			$gentree['Gentree'] 					= 	$finalJson;
			$deviceName 							=	'iPad';
			$logtext = 'Login da '.$deviceName.'avvenuto con successo  '.$reqforType;
			logInsert($user_id, $logType, $logtext);
			echo json_encode($gentree);		
	}
	else {
		//echo "iNN - 4";
		$logtext = 'Login da '.$deviceName.' fallito  '.$reqforType;
		logInsert($user_id, $logType, $logtext);
		echo "0";
	}	
}
?>