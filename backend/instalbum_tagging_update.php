<?php

include "../includes/init.php";
$imageid = $_POST['imageid']; 
$objInstaImage		=   new instaimages();
$objInstTag         =   new instatagging();
$imagetag			=   $objInstTag->taggingDetails($imageid);
$tagid              =   $imagetag['id_tag'];
$image_width		=	$_POST['imagewidth'];
$image_height       =	$_POST['imageheight'];
$ActualImage_width  =   $_POST['actualimagew'];
$ActualImage_height =   $_POST['actualimageh'];
$imagetagging       = 	count($imagetag);
$string_div			= 	'';
for($i=0;$i<$imagetagging;$i++)
{
	    $tagusername		=	$imagetag[$i]['tagged_name'];
		$tagxcord           =   $imagetag[$i]['tag_x_cord'];
		$tagycord           =   $imagetag[$i]['tag_y_cord'];
		$tagwidth           =   $imagetag[$i]['tag_width'];
		$tagheight          =   $imagetag[$i]['tag_heigth'];
		$imageiphonewidth   =   $imagetag[$i]['image_width'];
		$imageiphoneheight 	=	$imagetag[$i]['image_height'];

	if($imagetag[$i]['device_name'] == "iphone"){
		
    	$x_cord 			=	($image_width*$tagxcord)/$imageiphonewidth;
    	$y_cord 			=   ($image_height*$tagycord)/$imageiphoneheight;
    	$Height 			=	($y_cord*$tagheight)/$tagycord;
    	$Width 				=	($x_cord*$tagwidth)/$tagxcord;
    }else{
		$x_cord				=   ($tagxcord*$image_width)/$ActualImage_width;
		$y_cord				=   ($tagycord*$image_height)/$ActualImage_height;
		$Width              =   ($tagwidth*$image_width)/$ActualImage_width;
		$Height             =   ($tagheight*$image_height)/$ActualImage_height;
    }
    $count				=	$i+1;	
    $string_div .="<div id=\"box".$count."\" class=\"tagbox ui-draggable ui-resizable\" style=\"top: ".$y_cord."px; left:".$x_cord."px;width:".$Width."px; height:".$Height."px; \">".$count."</div>";
}
echo $string_div;
exit;
?>