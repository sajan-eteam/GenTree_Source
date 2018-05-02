<?php

include "../includes/init.php";

$info		=	array();

$objimages  =	new images();
$objtagging	=	new tagging();
$objuser	=	new geneuser();

$galleryList	= $objtagging->taggingDetails('76');
echo "<PRE>"; print_r($galleryList); echo "</PRE>";
echo sizeof($galleryList[0]);
//echo json_encode($finaljson);
?>