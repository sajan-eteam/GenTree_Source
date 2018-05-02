<?php
include "../includes/init.php";
include "loggfile.php";
$objImage			=	new images();
$objtagging         =   new tagging();
$objInstaImages		=	new instaimages();
$objInstaTagging    =   new instatagging();
$objlike			=	new like();
$image_id			=	$_POST['imageid'];
$insta_album_imgid  =   $_POST['image_id'];
$trash		        =   '0';
$deletetime			=   date('Y-m-d H:i:s');
if(isset($image_id)){
$gallery_id 		=	$_POST['galleryid'];
$galleryName        =   $objImage->getGallery($gallery_id);
$images				=	$objImage->deleteTrashImage($trash, $deletetime, $image_id);
$delete_tagging		=   $objtagging->deletetagging($deletetime, $image_id);
$logtext 			=	"Foto eliminata correttamente dall ".$galleryName."album.";
$msg				=   "success";
}
if(isset($insta_album_imgid)){
$images				=	$objInstaImages->deleteTrashImage($trash, $deletetime, $insta_album_imgid);
$like				=	$objlike->deletelike($insta_album_imgid);
$delete_tagging		=   $objInstaTagging->deletetagging($deletetime, $insta_album_imgid);
$logtext 			=	"Instafamily: immagine eliminata con successo.";
$msg				=   "success";
}
$logArray = logInsert(1, 7, $logtext);
echo $msg;
exit;
?>