<?php
include "../includes/init.php";

//$tagData            =   json_decode($_POST['boxdetail'],true);
//echo $tagData;exit;
//$tag_count          =   count($tagData);

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


$objimage	 		= 	new images();
$objtagging         =   new tagging();
$gallery_id			=   mysql_real_escape_string($_POST['galleryid']);

$title 				=	mysql_real_escape_string($_POST['title']);
$image 				=	mysql_real_escape_string($_POST['image']);
$temp_image	        =	explode("/", $image);
$image_name			=	$temp_image[sizeof($temp_image)-1];
$time			    =   time();
$new_image			=   $image_name;
$descrption 		=	mysql_real_escape_string($_POST['desc']);
$status				=   mysql_real_escape_string($_POST['status']);

$image_date			=   mysql_real_escape_string($_POST['imagedat']);
//$new_imagedate		=	strtotime($image_date);
$newimage_date		=	$image_date; //date('Y-m-d',$new_imagedate);

if($title == '' ||  $status == '' ||  $image_date == '')
{
  echo"Unable to add Image details";
  exit;
}
else
{
$insertArray	=	array(
							 "id_gallery"           =>	$gallery_id,
							 "image_title"		    =>	$title,
							 "image_description"	=>	$descrption,
							 "image_src"            =>	$new_image,
							 "image_date"           =>	$newimage_date,
							 "image_publish"        =>	$status,
	                         "LastModifiedTime"     =>  date('Y-m-d H:i:s'),
							 "Trash"				=>  '1'
							 
						);					
$insert_image	=   $objimage->insertImagedetail($insertArray);
$image_id       =   mysql_insert_id();
for($i=0;$i<$tag_count;$i++)
{
$imageWidth		=	$tagData[$i]['image_width'];

$imageHeight	 =	$tagData[$i]['image_height'];
$x				 =	$tagData[$i]['x'];
$y				 =	$tagData[$i]['y'];
$TagBoxWidth     =   $tagData[$i]['boxw'];
$TagBoxHeight    =   $tagData[$i]['boxh'];
$ActualImgWidth  =   $tagData[$i]['actualimagewidth'];
$ActualImgHeight =   $tagData[$i]['actualimageheight'];
$actualTagWidth	 = ($TagBoxWidth*$ActualImgWidth)/$imageWidth;
$actualTagHeight = ($TagBoxHeight*$ActualImgHeight)/$imageHeight;
$actualTagOriginX = ($x*$ActualImgWidth)/$imageWidth;
$actualTagOriginY = ($y*$ActualImgHeight)/$imageHeight;
$xCord			=	($x*100)/($imageWidth);
//$x_cord			=	round($xCord,2);
$yCord			=	($y*100)/($imageHeight);
//$y_cord			=	round($yCord,2);
$insertarray	=	array(
							 "id_image"             =>	$image_id,
							 "tag_x_cord"		    =>	$actualTagOriginX,
							 "tag_width"	        =>	$actualTagWidth,
							 "tag_y_cord"           =>	$actualTagOriginY,
							 "tag_heigth"           =>	$actualTagHeight,
							 "gene_user_id"         =>	$tagData[$i]['user'],
	                         "LastModifiedTime"		=>  date('Y-m-d H:i:s'),
							 "Trash"				=>  '1'
							 
						);	

$tag_image	=   $objtagging->insertTagdetail($insertarray);
}
echo "success";
exit;
}

?>