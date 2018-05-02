<?php
include "../includes/init.php";
include('session_check.php');
$objimage   =  new images();
//added for menu navigation
$gallery            =  $_SESSION['gallery_id'];
$currentpage	= 2; 
$menu_id 		= 1;
if(isset($gallery))
{
	$id_gallery	=	$gallery;
	switch($gallery) 
	{
		case 1: $menu_id = 1;
		break;
		case 2: $menu_id = 2;
		break;	
		case 3: $menu_id = 3;
		break;
		case 4: $menu_id = 4;
		break;
		case 5: $menu_id = 5;
		break;
		case 6: $menu_id = 6;
		break;		
		case 7: $menu_id = 7;
		break;
        case 8: $menu_id = 8;
        break;
	}
}
//added for menu navigation
$gallery_name	=	$objimage->getGallery($gallery);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Albero Genealogico</title>
<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="css/structure.css">
<link rel="stylesheet" href="css/menu.css">
<link rel="stylesheet" href="css/photo_detail.css">

<script src="js/jquery.js"></script>
<script src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/main.js"></script>
<script src="js/tagging.js"></script>
<script src="js/jquery.filedrop.js"></script>
<script src="js/script.js"></script>
<script src="js/ajaxupload.3.5.js"></script> 
<!-- <script src="js/jquery-1.8.2.js"></script> -->
</head>
<body>
<div id="wrapper">
    <!----Header---->
    <?php
	include('header_bar.php');
	?>
    
    <!----container---->
    <div id="container">    
        <!----left part----> 
        <?php
			include('menu.php');
			
            
		?>
		<?php $id_gallery = $_GET['gallery']; ?>
        <!----end left part---->
        <div id="tabella_cont" class="table_main">
            <div id="tabella_head" class="table_head_main">
                <div id="top_right">
                    <div id="head_right">
                        <div class="buttons">
                        	<button class="big" onclick="location.href='photo.php?id_gallery=<?php echo $id_gallery;?>'"><img src="img/buttons/back.gif"/></button>
                            <!--<input type="button" class="big" id="upl" value="Upload"/>-->
							<button class="big" id="upl">Upload</button>
                        </div>
                    </div>
                    <h1>Nuova foto nell'album "<?php echo $gallery_name; ?>"</h1>
                </div>
            </div>
			
            <!-------------------->
            <div id="tabella">
                <div id="upload">
                    <div id="dragarea">
					   <img height="121px" width="166px" id="im" style="display:none;"/>
                        <p class="message">Puoi trascinare qui la foto da caricare</p> 
						 <input type="hidden" name="galleryid"  id="galleryid"  value="<?php echo $id_gallery; ?>"/>
						<input type="hidden" name="type"  id="type"  value="<?php echo $type; ?>"/>
                    </div>
                    <div class="sfoglia_cont">
                    	<p>oppure</p>
						            
	
                        <input type="button" class="big" style="position:relative; margin: 10px auto; height:30px;" value="Sfoglia per selezionare file" id="imgbrowse"/>
						<span id="statuss"></span>  
                        <span id="filenames"></span>
                        <input id="addphoto" type="button" style="position:absolute; left:0; top:0; width: inherit; opacity:0;"/>
						<?php /* Hidden field added for image upload */ ?>
						<input type="hidden" name="image_name" id="image_name" value=""/> 
				       
                        </button>
                    </div>
            	</div>                
            </div>
        </div>
    </div>
</div>
</body>
</html>