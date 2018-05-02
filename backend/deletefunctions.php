<?php
include "../includes/init.php";
include "loggfile.php";
if(isset($_POST))
{
/*tab uesrid*/
$idTabUser	  		=  	$_POST['userid'];
/*gene tab user ids*/
$idGeneUser  		=  	$_POST['tree']; 
/*tabuser ids*/ 
$idTabUserArray   	=	$_POST['arr'];

$objUser =  new user();
$objuser =  new geneuser();
$trash   =  '0';
$enable		=  '0';
$deletetime = date('Y-m-d H:i:s');
$msg     = 0;
if(isset($idTabUser))
{
$tab_user	 =  $objUser->deleteUser($trash,$idTabUser);
$msg = 0;
}
if(isset($idGeneUser))
{
if(is_array($idGeneUser) && count($idGeneUser) > 0) {
		foreach($idGeneUser as $user) {
			$deleteFlag = 1;
			$deletechck = mysql_real_escape_string($user);	
			$objuser->deleteGeneUser($trash,$enable,$deletetime,$deletechck);
			$msg = 0; 
		}
	}
	else
	{
		$msg = 1;
	}
	
}
if(isset($idTabUserArray))
{
if(is_array($idTabUserArray) && count($idTabUserArray) > 0) {
		foreach($idTabUserArray as $user_ids) {
			$deleteFlag = 1;
			$deletechck = mysql_real_escape_string($user_ids);	
			$objUser->deleteUser($trash,$user_ids);
			$msg = 0; 
		}
	}
	else
	{
		$msg = 1;
	}
}
$logtext =	'Utente Famiglia Boroli cancellato con successo.';
logInsert(1, 7, $logtext);
echo $msg;
}
?>