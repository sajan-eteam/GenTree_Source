<?php
include "../includes/init.php";
$objUser	= new geneuser();
$root_exist			=	$objUser->familymember("gene_relation_type = 1");

if(sizeof($root_exist) > 0)
{ 
	$msg = 1;
	$root_id = $root_exist[0]['gene_user_id'];
	$msg	=	$root_id;
}
else
{
	$msg = 0;
}	
echo $msg;
?>