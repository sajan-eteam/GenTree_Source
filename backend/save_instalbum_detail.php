<?php
include "../includes/init.php";
include "loggfile.php";
if(get_magic_quotes_gpc())
{
	$d = stripslashes($_POST['boxdetail']);
}
else
{
	$d = $_POST['boxdetail'];
}
$tagData            =   json_decode($d,true);
$tag_count          =   count($tagData);
$objInstaAlbum		=  new instaimages();
$objInstaTags		=  new instatagging();
$user_id			=   mysql_real_escape_string($_POST['user_id']);
$title 				=	cleanString($_POST['title']);
$image 				=	mysql_real_escape_string($_POST['image']);
$temp_image	        =	explode("/", $image);
$image_name			=	$temp_image[sizeof($temp_image)-1];
$time			    =   time();
$new_image			=   $image_name;
$descrption 		=	cleanString($_POST['desc']);
$status				=   mysql_real_escape_string($_POST['status']);
$image_date			=   mysql_real_escape_string($_POST['imagedat']);
$current_time       =   date('H:i:s');
$newimage_date		=	$image_date." ".$current_time; 

if($title == '' ||  $status == '' ||  $image_date == '') {
  	
  	echo"Unable to add Image details";
  	exit;
}
else {

	$insertArray	=	array(
							 "user_id"           	=>	$user_id,
							 "image_title"		    =>	$title,
							 "image_description"	=>	$descrption,
							 "image_src"            =>	$new_image,
							 "image_date"           =>	$newimage_date,
							 "image_publish"        =>	$status,
	                         "LastModifiedTime"     =>  date('Y-m-d H:i:s'),
							 "Trash"				=>  '1'
							 
						);	
					
	$insert_image	=   $objInstaAlbum->insertImagedetail($insertArray);
	$image_id       =   mysql_insert_id();
	
	for($i=0;$i<$tag_count;$i++)
	{
		$imageWidth			=	$tagData[$i]['image_width'];
		$imageHeight	 	=	$tagData[$i]['image_height'];
		$x				 	=	$tagData[$i]['x'];
		$y				 	=	$tagData[$i]['y'];
		$TagBoxWidth     	=   $tagData[$i]['boxw'];
		$TagBoxHeight   	=   $tagData[$i]['boxh'];
		$ActualImgWidth  	=   $tagData[$i]['actualimagewidth'];
		$ActualImgHeight 	=   $tagData[$i]['actualimageheight'];
		$actualTagWidth	 	= 	($TagBoxWidth*$ActualImgWidth)/$imageWidth;
		$actualTagHeight 	= 	($TagBoxHeight*$ActualImgHeight)/$imageHeight;
		$actualTagOriginX 	= 	($x*$ActualImgWidth)/$imageWidth;
		$actualTagOriginY 	= 	($y*$ActualImgHeight)/$imageHeight;
		$xCord				=	($x*100)/($imageWidth);
		$yCord				=	($y*100)/($imageHeight);
		if($x == 0)
			$actualTagOriginX	=	'0';
		$actualTagOriginY = ($y*$ActualImgHeight)/$imageHeight;
		if($y == 0)
			$actualTagOriginY	=	'0';

		$insertarray[$i]	=	array(
									 "id_image"             =>	$image_id,
									 "tag_x_cord"		    =>	$actualTagOriginX,
									 "tag_width"	        =>	$actualTagWidth,
									 "tag_y_cord"           =>	$actualTagOriginY,
									 "tag_heigth"           =>	$actualTagHeight,
									 "tagged_name"          =>	$tagData[$i]['user'],
									 "image_height"			=>	$imageHeight,
									 "image_width"			=>  $imageWidth,
									 "image_y"				=>	$y,
									 "image_x"				=>  $x,
									 "device_name"			=>	'web',
									 "tag_counter"			=>	'0',
			                         "LastModifiedTime"		=>  date('Y-m-d H:i:s'),
									 "Trash"				=>  '1'
									 
								);

		
	}
	for($i=0;$i<sizeof($insertarray);$i++) {

		$tag_image		=   $objInstaTags->insertTagdetail($insertarray[$i]);
	}
$logtext = 'Insta Album inserita correttamente e il conteggio dei tag è fatto'.$tag_count;
logInsert(1, 5, $logtext);
echo "success";
exit;
}

?>