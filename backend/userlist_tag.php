<?php 
include "../includes/init.php";

$tagobj             =   new geneuser();

$family_members	=	$tagobj->user_tag();
for($i=0;$i<count($family_members);$i++)
{
$option .='<li>'.$family_members[$i]['gene_name']." ".$family_members[$i]['gene_surname'].'</li>';
}
$dropdown = '<div class="dropdown"><input type="text"/><ul>'.$option.'</ul></div>';
echo $dropdown;exit;
?>