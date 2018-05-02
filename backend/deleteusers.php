<?php 
include "../includes/init.php";
include "loggfile.php";
$userid=$_POST['tree'];  
$objUser = new geneuser();
$trash   =  '0';
$enable		=  '0';
$deletetime = date('Y-m-d H:i:s');
$msg     = 0;
if(is_array($userid) && count($userid) > 0) {
		foreach($userid as $userids) {
			$deleteFlag = 1;
			$deletechck = mysql_real_escape_string($userids);	
			$objUser->deleteGeneUser($trash,$enable,$deletetime,$deletechck);
			$msg = 0; 
		}
	}
	else{
		$msg = 1;
	}
$logtext =	'Utente Famiglia Boroli cancellato con successo.';
logInsert(1, 7, $logtext);
echo $msg;
	?>