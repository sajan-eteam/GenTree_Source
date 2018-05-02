<?php
include "../includes/init.php";
include "loggfile.php";
$stringarray = array();

if(get_magic_quotes_gpc())
{
	$d = stripslashes($_POST['boxdetail']);
}
else
{
	$d = $_POST['boxdetail'];
}

$test_array			=	array();
$insert_newarray 	=	array();
$old_array			=	array();

$tagData            =   json_decode($d,true);
$tag_count          =   count($tagData);

$objimage	 		= 	new images();
$objtagging         =   new tagging();
$image_id			=	mysql_real_escape_string($_POST['imageid']);
$gallery_id			=   mysql_real_escape_string($_POST['galleryid']);

$title 				=	cleanString($_POST['title']);
$image 				=	mysql_real_escape_string($_POST['image']);
$temp_image	        =	explode("/", $image);
$image_name			=	$temp_image[sizeof($temp_image)-1];
$time			    =   time();
$new_image			=   $image_name;
$descrption 		=	cleanString($_POST['desc']);
$status				=   mysql_real_escape_string($_POST['status']);

$image_date			=   $_POST['imagedat'];
$delstatus          =   mysql_real_escape_string($_POST['delstatus']);
$deluserid          =   mysql_real_escape_string($_POST['deluserid']);
$deltime            =   date('Y-m-d H:i:s');
$newimage_date		=	$image_date; //date('Y-m-d', $image_date);
$imgatime 			=	$_POST['time'];
$t 					=  	date("H:i", strtotime($imgatime));
$newimage_date		=	$image_date.' '.$t; //date('Y-m-d', $image_date);
$lastModifiedTime 	=	$_POST['lastModifiedTime'];
$imagePublish 		=	$_POST['imagePublish'];
$galleryName        =   $objimage->getGallery($gallery_id);
$lastUpdatedTime 	=	date('Y-m-d H:i:s');
if($imagePublish == 0 || $imagePublish == '0') {
	$lastUpdatedTime 	=	$lastModifiedTime;
}

if($title == '' || $status == '' ||  $image_date == '')
{
  echo"Unable to add Image details2";
  exit;
}
else
{
	$updateArray	=	array(
							 "id_gallery"           =>	$gallery_id,
							 "image_title"		    =>	$title,
							 "image_description"	=>	$descrption,
							 "image_src"            =>	$new_image,
							 "image_date"           =>	$newimage_date,
							 "image_publish"        =>	$status,
							 "LastModifiedTime"     =>  date('Y-m-d H:i:s'),
		                      "Trash"				=>  '1'		                     					 
							);		
	$update_image	=   $objimage->updateImagedetails($updateArray, $image_id);
	
	$tagaddarray    =   $objtagging->taggaddarray($image_id);
    if($tagaddarray == "")
	{
      for($i=0;$i<$tag_count;$i++)
		{
			$imageWidth		 =		$tagData[$i]['image_width'];
			$imageHeight	 =		$tagData[$i]['image_height'];
			$x				 =		$tagData[$i]['x'];
			$y				 =		$tagData[$i]['y'];
			$TagBoxWidth     =   	$tagData[$i]['boxw'];
			$TagBoxHeight    =   	$tagData[$i]['boxh'];
			$ActualImgWidth  =   	$tagData[$i]['actualimagewidth'];
			$ActualImgHeight =   	$tagData[$i]['actualimageheight'];
			$actualTagWidth	 = 		($TagBoxWidth*$ActualImgWidth)/$imageWidth;
			$actualTagHeight = 		($TagBoxHeight*$ActualImgHeight)/$imageHeight;
			$actualTagOriginX = 	($x*$ActualImgWidth)/$imageWidth;
			$actualTagOriginY = 	($y*$ActualImgHeight)/$imageHeight;
			$xCord			=		($x*100)/($imageWidth);
			$x_cord			=		round($xCord,2);
			$yCord			=		($y*100)/($imageHeight);
			$y_cord			=		round($yCord,2);

			if($x == 0)
				$actualTagOriginX	=	'0';
			$actualTagOriginY = ($y*$ActualImgHeight)/$imageHeight;
			if($y == 0)
				$actualTagOriginY	=	'0';	
			
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
		$logtext 			=	$galleryName.'  Album Nuovo tag aggiunta con successo e il numero di tag è fatto'.$tag_count;
		logInsert(1, 8, $logtext);
		echo "success";
		exit;
	}
 else
	{
		for($i=0;$i<count($tagaddarray);$i++)
		{
		   $id_tag			=  	$tagaddarray[$i]['id_tag'];
		   $imagea			=  	$tagaddarray[$i]['id_image'];
		   $xcorda			=  	$tagaddarray[$i]['tag_x_cord'];
		   $ycorda			=  	$tagaddarray[$i]['tag_y_cord'];
		   $widtha			=  	$tagaddarray[$i]['tag_width'];
		   $heighta			=  	$tagaddarray[$i]['tag_heigth'];
		   $userida			=  	$tagaddarray[$i]['gene_user_id'];
		   $modifiedtime	=  	$tagaddarray[$i]['LastModifiedTime'];
		   $trash			=  	$tagaddarray[$i]['Trash'];
		   
		   $x_cord_array	=	explode('.', $xcorda);
		   $y_cord_array	=	explode('.', $ycorda);
		   $width_array		=	explode('.', $widtha);
		   $height_array	=	explode('.', $heighta);
		   
		   $tag_string		=	$userida."_".$x_cord_array[0]."_".$y_cord_array[0]."_".$width_array[0]."_".$height_array[0];
		   	   
		   $stringarray     =	   array(   'id_tag'		=>$id_tag,
											'id_image'		=>$imagea,
											'tag_x_cord'	=>$xcorda,
											'tag_y_cord'	=>$ycorda,
											'tag_width'		=>$widtha,
											'tag_heigth'	=>$heighta,
											'gene_user_id'	=>$userida,
											'LastModifiedTime'=>date('Y-m-d H:i:s'),
											'Trash'=>'0');					
		  
		  $old_userID_array[$i]	=	$userida;
		  $old_user_tag[$userida]['idTag']	=	$id_tag;
		  $old_user_tag[$userida]['time']	=	$modifiedtime;
		  $old_array[$i]		=	$tag_string;
		  $update_newarray[$tag_string]	=   $stringarray;
		  $final_array[$i]['Old']	=	$old_array;
		}	
     	
		for($i=0;$i<$tag_count;$i++)
		{
			$imageWidth		 =	 $tagData[$i]['image_width'];
			$imageHeight	 =	 $tagData[$i]['image_height'];
			$x				 =	 $tagData[$i]['x'];
			$y				 =	 $tagData[$i]['y'];
			$TagBoxWidth     =   $tagData[$i]['boxw'];
			$TagBoxHeight    =   $tagData[$i]['boxh'];
			$ActualImgWidth  =   $tagData[$i]['actualimagewidth'];
			$ActualImgHeight =   $tagData[$i]['actualimageheight'];
			$actualTagWidth	 = ($TagBoxWidth*$ActualImgWidth)/$imageWidth;
			$actualTagHeight = ($TagBoxHeight*$ActualImgHeight)/$imageHeight;
			$actualTagOriginX = ($x*$ActualImgWidth)/$imageWidth;
			//$actualTagOriginY = ($y*$ActualImgHeight)/$imageHeight;
			$xCord			=	($x*100)/($imageWidth);
			$x_cord			=	round($xCord,2);
			$yCord			=	($y*100)/($imageHeight);
			$y_cord			=	round($yCord,2);

			if($x == 0)
				$actualTagOriginX	=	'0';
			$actualTagOriginY = ($y*$ActualImgHeight)/$imageHeight;
			if($y == 0)
				$actualTagOriginY	=	'0';

		   $x_cords_array	=	explode('.', $actualTagOriginX);
		   $y_cords_array	=	explode('.', $actualTagOriginY);
		   $widths_array	=	explode('.', $actualTagWidth);
		   $heights_array	=	explode('.', $actualTagHeight);

			$insertarray	=	array(
								 "id_image"             =>	$image_id,
								 "tag_x_cord"			=>	$actualTagOriginX,
								 "tag_width"	        =>	$actualTagWidth,
								 "tag_y_cord"           =>	$actualTagOriginY,
								 "tag_heigth"           =>	$actualTagHeight,
								 "gene_user_id"         =>	$tagData[$i]['user'],
								"LastModifiedTime"		=>  date('Y-m-d H:i:s'),
								"Trash"					=>  '1'								 
							);
			$tag_strings		=	$tagData[$i]['user']."_".$x_cords_array[0]."_".$y_cords_array[0]."_".$widths_array[0]."_".$heights_array[0];
			
			$test_array[$i]		= 	$tag_strings;
			$insert_newarray[]	= 	array($tag_strings => $insertarray);
			
			$insert_New_Array	=	array(
								 "id_image"             =>	$insert_newarray[$tag_strings]['id_image'],
								 "tag_x_cord"			=>	$insert_newarray[$tag_strings]['tag_x_cord'],
								 "tag_width"	        =>	$insert_newarray[$tag_strings]['tag_width'],
								 "tag_y_cord"           =>	$insert_newarray[$tag_strings]['tag_y_cord'],
								 "tag_heigth"           =>	$insert_newarray[$tag_strings]['tag_heigth'],
								 "gene_user_id"         =>	$insert_newarray[$tag_strings]['gene_user_id'],
								"LastModifiedTime"		=>  date('Y-m-d H:i:s'),
								"Trash"					=>  '1'								 
							);
			$final_array[$i]['New']	=	$test_array;
		
		}

		foreach($insert_newarray as $key=> $value)
		{
			foreach($value as $key1=> $value1)
			{
				$newTagArray[$key1] = $value1;
			}
		}

		if(sizeof($old_array) == 0) 
			$result	=	$test_array;
		else
			$result				= array_diff($test_array,$old_array);

		if(sizeof($test_array) == 0)
			$results = $old_array;
		else
			$results			= array_diff($old_array,$test_array);

		if(sizeof($results) >0 )
		{ 
		  foreach($results as $key => $value)
			{
			   $tempupdatearray		=  $update_newarray[$value];			  
			   $id_tag	=	$tempupdatearray['id_tag'];
			   
			   $update_tag_array  =	   array('id_image'		=>	$tempupdatearray['id_image'],
											'tag_x_cord'	=>	$tempupdatearray['tag_x_cord'],
											'tag_y_cord'	=>	$tempupdatearray['tag_y_cord'],
											'tag_width'		=>	$tempupdatearray['tag_width'],
											'tag_heigth'	=>	$tempupdatearray['tag_heigth'],
											'gene_user_id'	=>	$tempupdatearray['gene_user_id'],
											'LastModifiedTime'=>date('Y-m-d H:i:s'),
											'Trash'=> 0);
			   $update_tag			=  $objtagging->updateTaggingdetails($update_tag_array, $id_tag);			   
			}
		}	

	   if(sizeof($result) > 0)
		{
			foreach($result as $key => $value)
			{
				$tempArray		= $newTagArray[$value];
				$genID          = $tempArray['gene_user_id'];
				
				if(in_array($genID, $old_userID_array)) 
				{
					$tempArray['LastModifiedTime']	=	date('Y-m-d H:i:s'); 
					$idTag 			=	$old_user_tag[$genID]['idTag'];
					$update_tag	 	=  	$objtagging->updateTaggingdetails($tempArray, $idTag);						
			    }
			    else {

			   		$time           =   date('Y-m-d H:i:s');
			    	$img_tag		=   $objtagging->insertTagdetail($tempArray,$time);	
			    }
			}		 
		}
	$logtext 			=	$galleryName.'  Album Nuovo tag Aggiornato con successo e il numero di tag è fatto  '.$tag_count;
	logInsert(1, 8, $logtext);
	echo "success";
	exit;
}
}

?>