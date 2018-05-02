<?php
		include "../includes/init.php";
		$sync			=	"sync";
		$date			=	"2013-10-01 08:44:14";
		$condition		=	$date;
		$infos			=	array();
		$spousearray    =   array();
		$delchild		=   array();
		$delarrays      =   array();
		$file_names     =   array();
		$objimages		=	new images();
		$objtagging		=	new tagging();
		$objuser		=	new geneuser();

function zipFilesAndDownload($file_names,$archive_file_name,$file_path)
{
$zip = new ZipArchive();
//create the file and throw the error if unsuccessful
if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
exit("cannot open <$archive_file_name>\n");
}
//add each files of $file_name array to archive
foreach($file_names as $files)
{
$zip->addFile($file_path.$files,$files);
//echo $file_path.$files,$files."<br>";
}
$zip->close();
//then send the headers to foce download the zip file
header("Content-type: application/zip");
header("Content-Disposition: attachment; filename=$archive_file_name");
header("Pragma: no-cache");
header("Expires: 0");
readfile("$archive_file_name");
exit;
}

$fetchimage     =   $objimages->imageFetch($condition);
$url			=   UPLOAD_PATH;
for($i=0;$i<count($fetchimage);$i++)
{
	$image      =  $fetchimage[$i]['image_src'];
    $img        = "http://".$_SERVER["SERVER_NAME"]."/dea_albero_2/upload/T_".$image;
	$file_names[$i]['image_src'] =  $img;
}


//if you are getting the file name from database means use the following method
//Include DB connection
$name           =  $img;
//Archive name
$archive_file_name="text.zip";
//Download Files path
$file_path="http://".$_SERVER["SERVER_NAME"]."/dea_albero_2/upload/T_";
//cal the function
zipFilesAndDownload($file_names,$archive_file_name,$file_path); 
?>