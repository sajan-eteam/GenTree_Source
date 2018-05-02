<?php 
	include "../includes/init.php";
	$image = "";
	$structure = '../upload/';
	if (file_exists($structure)) 
		{
		$err =  "Cartella di upload già esistente";
		} 
		
	if ($_FILES["uploadfile"]["error"] > 0)
	{
		echo "Return Code: " . $_FILES["uploadfile"]["error"] . "<br />";
	}
	else
	{
		$fileName	=	$structure.time().$_FILES["uploadfile"]["name"];
		$fileName 	= 	preg_replace('/\s+/', '', $fileName);
		if (file_exists($fileName))
		{
			$err =  $_FILES["uploadfile"]["name"] . " already exists. ";
		}
		else
		{
			move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $fileName);
		}
		echo $fileName;	
	}
?>