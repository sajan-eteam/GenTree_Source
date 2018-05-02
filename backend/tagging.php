<?php 

$tagging            =   $_POST['tag'];
$x_cord             =   $_POST['x_cord'];

$y_cord             =   $_POST['y_cord'];

$bx_width           =   $_POST['boxwidth'];

$bx_height          =   $_POST['boxheight'];

$mychoice           =   $_POST['mychoice'];
//echo $mychoice;exit;
if($tagging == '1')
{	
$tagobj             =   new geneuser();
$family_members	=	$tagobj->user_tag();
for($i=0;$i<count($family_members);$i++)
{
$option .='<li value='.$family_members[$i]['gene_user_id'].'>'.$family_members[$i]['gene_name']." ".$family_members[$i]['gene_surname'].'</li>';
}
$dropdown = '<div class="dropdown"><input type="text"/><ul>'.$option.'</ul></div>';
echo $dropdown;exit;
}
$objtagging     =   new tab_tags();
$insertarray	=	array(
							 //"id_image"             =>	$image_id,
							 "tag_x_cord"		    =>	$x_cord,
							 "tag_width"	        =>	$bx_width,
							 "tag_y_cord"            =>	$y_cord,
							 "tag_heigth"            =>	$bx_height,
							 "gene_user_id"          =>	$mychoice
							 
						);
print_r($insertarray);exit;