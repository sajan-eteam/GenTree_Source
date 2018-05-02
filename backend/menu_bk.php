<?php
$currentmenu = "0";
switch($currentpage) {
	case 1: $currentmenu = 1; break;
	case 2: $currentmenu = 2; break;
	case 3: $currentmenu = 3; break;
	case 4: $currentmenu = 4; break;
	case 14:
	case 15:
	case 16:$currentmenu = 16; break;
	case 17:
	case 18:
	case 19:$currentmenu = 1;
	break;
	case 2 :
	case 3 :$currentmenu = 2;
	break;
	default : $currentmenu = 1;
}

$imageObj	=	new images();
?>
<div id="left_column">
	<ul id="menu">
		<li class="<?php echo $p = (($currentmenu==1) ? "attivo" : "")?>"><p><a href="tree.php">Albero genealogico</a></p></li>
		<li class="<?php echo $p = (($currentmenu==2) ? "attivo" : "")?>"><p><a href="photo.php?id_gallery=1">Album fotografici</a></p>
			<ul class="drop-down">
			<?php
				$galleryResult	=	$imageObj->getGalleryLists();
				for($i = 0; $i < sizeof($galleryResult); $i++)
				{
					$count = $i+1;
					//function
					$imagecount =  $imageObj->galleryImages($count);
                    $cnt		=  count($imagecount);
					?>
						<li class="<?php echo $q = (($menu_id==$count) ? "attivo" : "")?>"><p><a href="photo.php?id_gallery=<?php echo $count; ?>"><?php echo $galleryResult[$i]['gallery_title']; echo  "  "."("." ".$cnt." ".")";?></a></p></li>
					<?php
				}
			?>
			<?php /*
				<li class="<?php echo $q = (($menu_id==1) ? "attivo" : "")?>"><p><a href="photo.php?id_gallery=1">Anna Boroli</a></p></li>
				<li class="<?php echo $q = (($menu_id==2) ? "attivo" : "")?>"><p><a href="photo.php?id_gallery=2">Achille Boroli</a></p></li>
				<li class="<?php echo $q = (($menu_id==3) ? "attivo" : "")?>"><p><a href="photo.php?id_gallery=3">Giuliana Boroli</a></p></li>
				<li class="<?php echo $q = (($menu_id==4) ? "attivo" : "")?>"><p><a href="photo.php?id_gallery=4">Carlo Boroli</a></p></li>
				<li class="<?php echo $q = (($menu_id==5) ? "attivo" : "")?>"><p><a href="photo.php?id_gallery=5">Adolfo Boroli</a></p></li>
				<li class="<?php echo $q = (($menu_id==6) ? "attivo" : "")?>"><p><a href="photo.php?id_gallery=6">Carlo Boroli</a></p></li>
				<li class="<?php echo $q = (($menu_id==7) ? "attivo" : "")?>"><p><a href="photo.php?id_gallery=7">Adolfo Boroli</a></p></li>
				*/ ?>
			</ul>
		</li>
		<li class="<?php echo $p = (($currentmenu==3) ? "attivo" : "")?>"><p><a href="text_detail.php?text_id=2">Testi</a></p>
			<ul class="drop-down">
				<li class="<?php echo $t = (($menu_id==1) ? "attivo" : "")?>" style="display:none;"><p><a href="text_detail.php?text_id=2">Benvenuto</a></p></li>
				<li class="<?php echo $t = (($menu_id==2) ? "attivo" : "")?>"><p><a href="text_detail.php?text_id=2">Albero genealogico</a></p></li>
				<li class="<?php echo $t = (($menu_id==3) ? "attivo" : "")?>"><p><a href="text_detail.php?text_id=3">Introduzione foto</a></p></li>
			</ul>
		</li>
		<li class="space <?php echo $p = (($currentmenu==4) ? "attivo" : "")?>"><p><a href="users.php">Gestione utenti</a></p></li>
	</ul>
</div>