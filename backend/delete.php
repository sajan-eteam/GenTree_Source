<?php
include "../includes/init.php";
include "loggfile.php";
$userid	 =  $_POST['userid'];
$objUser =  new user();
$trash   =  '0';
$usero	 =  $objUser->deleteUser($trash, $userid);
$logtext =	'App utente cancellato Sviluppo aziendale';
logInsert(1, 7, $logtext);
$msg     =  "cancellato Sviluppo aziendale"; 
?>