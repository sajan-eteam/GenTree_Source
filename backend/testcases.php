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
if($_POST['reqFor'] == 'silentPushNotification') { 

	$testCases = new TestCases();
	$testCases->testSilentPushNotificationIOS();
		     //testSilentPushNotificationIOS() ;
} else {
	echo "0";
} 



class TestCases {

	public function testSilentPushNotificationIOS() {
		try {   
			$pushnotification = $objInstaAlbum->selectAllDevices();
			echo 'testSilentPushNotificationIOS 2';
			$msgArray  = array("s_id" => "ok","u_id" => "userId","status"=>"1");
            echo 'pushnotification msgArray: ' .$msgArray;
			foreach($pushnotification as $pushnotify) { 
		                          	//
				$puchIOSObj = new PushNotificationIOS();
				$puchIOSObj->setDeviceTocken($pushnotify['device_tocken']);
				$puchIOSObj->setPassphrase('123');
				$puchIOSObj->setMessage($msgArray);
				$res = $puchIOSObj->sendToFamiglia($msgArray);
								//
				echo 'pushnotification success: ' .$e->getMessage();
			}
		} catch(Exception $e) {
			echo 'pushnotification failed: ' .$e->getMessage(); 
		} 
	}  

} 

?>