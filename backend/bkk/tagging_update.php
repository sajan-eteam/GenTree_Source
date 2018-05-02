<?php
include "../includes/init.php";
$imageid = $_POST['imageid']; 
$objimage			=   new images();
$tagobj             =   new geneuser();
$objtag             =   new tagging();
$imagetag			=   $objtag->taggingDetails($imageid);
$tagid              =   $imagetag['id_tag'];
$image_width		=	$_POST['imagewidth'];
$image_height       =	$_POST['imageheight'];
$ActualImage_width  =   $_POST['actualimagew'];
$ActualImage_height =   $_POST['actualimageh'];
$imagetagging       = count($imagetag);
$string_div		= '';
for($i=0;$i<$imagetagging;$i++)
{
	$taguserid			=	$imagetag[$i]['gene_user_id'];
	$tagxcord           =   $imagetag[$i]['tag_x_cord'];
	$x_cord				=   ($tagxcord*$image_width)/$ActualImage_width;
	$tagycord           =   $imagetag[$i]['tag_y_cord'];
	$y_cord				=   ($tagycord*$image_height)/$ActualImage_height;
	$tagwidth           =   $imagetag[$i]['tag_width']; 
	$Width              =   ($tagwidth*$image_width)/$ActualImage_width;
	$tagheight          =   $imagetag[$i]['tag_heigth'];
	$Height             =   ($tagheight*$image_height)/$ActualImage_height;
	$tagusername        =   $tagobj->tagImageUserID($taguserid);
	$genename			=   $tagusername[$i]['gene_name'];
	$genesurname        =   $tagusername[$i]['gene_surname'];
    $count				=	$i+1;	 
    $string_div .="<div class=\"tagbox ui-draggable ui-resizable\" id=\"box".$count."\" style=\"top: ".$y_cord."px; left:".$x_cord."px;width:".$Width."px; height:".$Height."px; \">".$count."<div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\"></div></div>";
}
echo $string_div;
exit;
?>