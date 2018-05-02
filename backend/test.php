<?php
phpinfo();
/*
require 'Fastimage.php';
$uri  = "../upload/1385394665 Colorado State Capitol .jpg";
$time = microtime(true);
$image = new FastImage($uri);
list($width, $height) = $image->getSize();
echo "FastImage: \n";
echo "Width: ". $width . "px Height: ". $height . "px in " . (microtime(true)-$time) . " seconds \n";

$time = microtime(true);
list($width, $height) = getimagesize($uri);
echo "getimagesize: \n";
echo "Width: ". $width . "px Height: ". $height . "px in " . (microtime(true)-$time) . " seconds \n";
exit;
*/


/*
include "../includes/init.php";
$imageid = $_POST['imageid']; 
$objimage			=   new images();
$tagobj             =   new geneuser();
$objtag             =   new tagging();
$imagetag			=   $objtag->taggingDetails($imageid);
$tagid              =   $imagetag['id_tag'];
$imagetagging       = count($imagetag);
$string_li		    = '';
for($i=0;$i<$imagetagging;$i++)
{
	$taguserid			=	$imagetag[$i]['gene_user_id'];
	$tagxcord           =   $imagetag[$i]['tag_x_cord'];
	$tagycord           =   $imagetag[$i]['tag_y_cord'];
	$tagwidth           =   $imagetag[$i]['tag_width']; 
	$tagheight          =   $imagetag[$i]['tag_heigth'];
	$tagusername        =   $tagobj->tagImageUserID($taguserid);
	$genename			=   $tagusername[$i]['gene_name'];
	$genesurname        =   $tagusername[$i]['gene_surname'];

$string_li.="<div id=\"input".$i."\" class=\"tag_list\"><p class=\"number\">".$i."</p><div class=\"input\"><p id=\"user_id_selected\" class=\"id_val\" style=\"display:none;\">".$taguserid."</p><p id=\"username\">".$genename.''.$genesurname."</p><span></span></div><div class=\"remove\" onclick=\"removebox(".$i.")">"\x\"</div><div class=\"dropdown\" style=\"display: none;\"><input type=\"text\"><ul><li class=\"selected\" value=".$taguserid.">".$genename.''.$genesurname."</li><li value=".$family_members[$i]['gene_user_id'].">".$family_members[$i]['gene_name']." ".$family_members[$i]['gene_surname']."</li></ul></div></div>";
}
echo $string_li;
exit;
*/
?>