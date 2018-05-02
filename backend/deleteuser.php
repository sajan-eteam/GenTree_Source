<?php
include "../includes/init.php";
include "loggfile.php";
$userid=$_POST['arr'];  
$objUser = new user();
$trash      = '0';
$msg        = 0;
if(is_array($userid) && count($userid) > 0) {
		foreach($userid as $userids) {
			$deleteFlag = 1;
			$deletechck = mysql_real_escape_string($userids);	
			$objUser->deleteUser($trash, $userids);
			$msg = 0; 
		}
	}
	else{
		$msg = 1;
	}
$logtext =	'Utente cancellato con successo.';
logInsert(1, 7, $logtext);
echo $msg;
?>