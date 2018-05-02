<?php
include "../includes/init.php";
include('session_check.php');
$currentpage	= 5; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Albero Genealogico</title>
<link rel="stylesheet" href="css/structure.css">
<link rel="stylesheet" href="css/menu.css">
<link rel="stylesheet" href="css/list.css">
<script src="js/jquery.js"></script>
<script src="js/main.js"></script>

</head>

<body>
<div id="wrapper">
    <!----Header---->
    <?php
	include('header_bar.php');
	?>
	<!----container---->
    <div id="container">
        <?php
			include('menu.php');			
			?>
			<?php 
			$condition	= "tab_insta_images.Trash='1'";
			$sort		= "DESC";
            $orderby	= 'tab_insta_images.image_date';
			$trash		= '0';
			$deletetime = date('Y-m-d H:i:s');
			$objimage   = new instaimages();
			$objlike 	= new like();

	if(($_POST['mode']=="delete") && isset($_POST['id_image'])) {        
	$image_id = mysql_real_escape_string($_POST['id_image']);		
	$imgobj=$objimage->deleteTrashImage($trash,$deletetime,$image_id);
	$msg = "Deleted successfully"; 
}

if(($_POST['deleteSelected1']=="delete") && isset($_POST['deleteSelected1'])) {  
	$deletechcks = $_POST['deletechck'];	
	
	if(is_array($deletechcks) && count($deletechcks) > 0) {
		foreach($deletechcks as $deletechck) {
			$deletechck = mysql_real_escape_string($deletechck);
			$objimage->deleteTrashImage($trash,$deletetime,$deletechck);
			$msg = "Deleted successfully"; 
		}
	}
}

//new code
if(isset($_GET['orderby']) && isset($_GET['sort']))
{
	$orderby = $_GET['orderby'];
	
	if($_GET['sort'] == 'ASC') { $sort = "DESC";}
	if($_GET['sort'] == 'DESC') { $sort = "ASC";}

}
if(isset($_GET['search'])) 
	{
		$searchtitle	= mysql_real_escape_string($_GET['search']);	
		if($searchtitle) {
			$condition .= "AND (tab_insta_images.image_title like '%".$searchtitle."%' OR tab_insta_images.image_date like '%".$searchtitle."%')";
			
		}
	}
//
$image_listview	= $objimage->imagelist($condition,$orderby.' '.$sort);
 
			
			?>
        <div id="tabella_cont" class="table_main">
          	<div id="tabella_head" class="table_list_view">
                <div id="top_right">
                    <div id="head_right">
                          <div class="buttons">
                                <div id="btn_notselect"><button  class="big"  onclick="location.href='insta_album_upload.php'">+ Aggiungi foto</button></div>
                                <div id="btn_select"> <button class="big" id="deleteSelected" name="deleteSelected" onclick="return confirmDelete();"><span class="delete"></span></button></div>
                          </div>
                    </div>
                    <h1>Insta Album</h1>
                    <form id="cont_search" method="get" onSubmit="javascript:doSearch();return false;">
                        <button type="submit" id="lens" class="icon_lens"></button>
                        <button type="reset" id="cancel" onclick="search_reset();" class="icon_cancel"></button>
                        <label>
                            <input id="search" class="search" type="text" value="<?php echo $_GET['search']; //$_POST['searchtitle']; ?>" onkeydown="search_check()" onblur="search_check()" placeholder="Cerca"/>
                        </label>
						
                    </form>
                </div>
				
                <table id="table_head" class="photo" width="100%" border="0" cellspacing="0" cellpadding="0">
                	 <tr class="filter">
                     	<td colspan="5">
                        <button id="list_view" class="list_view"><span></span></button><button id="thumb_view" class="thumb_view"><span></span></button>
                        </td>
                     </tr>
					 <form id="frmList" name="frmList" action="insta_album.php" method="post">
                     <tr class="labels">
                        <td class="check"><input id="checkAll" type="checkbox" onchange="toggleChecked(this.checked)"/> </td>
                        <!-- for sorting you have to add or remove the class asc or desc to the related p -->
                        <td class="col1"></td>
						<?php
							if($orderby == 'image_title' && $sort == 'DESC') 
							{
								$className	=	'desc';
							}
							else if($orderby == 'image_title' && $sort == 'ASC')
							{
								$className	=	'asc';
							}
							else
								$className	=	'';
						?>
                        <td class="col2" onclick="javascript:orderBy('image_title')"><p class="<?php echo $className;?>">Titolo

						</p>
						</td>
						<?php
							if($orderby == 'image_date' && $sort == 'DESC') 
							{
								$className	=	'desc';
							}
							else if($orderby == 'image_date' && $sort == 'ASC')
							{
								$className	=	'asc';
							}
							else
								$className	=	'';
						?>
                        <td class="col3" onclick="javascript:orderBy('image_date')"><p class="<?php echo $className;?>">Data</p>
						</td>
						<?php
							if($orderby == 'image_publish' && $sort == 'DESC') 
							{
								$className	=	'desc';
							}
							else if($orderby == 'image_publish' && $sort == 'ASC')
							{
								$className	=	'asc';
							}
							else
								$className	=	'';
						?>
                        <td class="col4 last" onclick="javascript:orderBy('image_publish')"><p class="<?php echo $className; ?>">Pubblicata</p>
                       </td>
                      </tr>
                      <tr class="shadow"><td colspan="5"></td></tr>
                 </table>
        	</div><!--end tabella_head-->
            <div id="tabella" class="table_list_view">
			  <?php  
			         $image_count		= count($image_listview);
					 for($i=0;$i<$image_count;$i++){
					 $publish               = $image_listview[$i]['image_publish'];
					 $image                 = $image_listview[$i]['image_src'];
					 $cnt                   = $image_listview[$i]['id_image'];
					 $image_date            = $image_listview[$i]['image_date']; 
					 $date 					= strtotime($image_date);
    				 $img_dat				= explode(" ",$image_date);
    				 $new_image_dt	        = explode("-",$img_dat[0]);
    				 $yyyy					= $new_image_dt[0];
    				 $mm                    = $new_image_dt[1];
    				 $dd 					= $new_image_dt[2];
    				 $time 					= $img_dat[1];
    				 $dat 					= $dd.'/'.$mm.'/'.$yyyy.' '.$time;

					 $img					= "../upload/T_".$image;
						if(file_exists($img)) 
						{  
							$imgs			= $img;
						}
						else
						{    
							$imgs			= "../upload/".$image;
						}
					
					    if($publish=='1')
					    {
                           $publish_status="SI";
					    }
						else
						{
							$publish_status="NO";
						}
					?>
            	    <div class="preview">
                	<div class="selection"></div>
                    <div class="thumb">
               			<div class="check"><input type="checkbox" class="checkbox" onclick="selection_color(this)" name="deletechck[]" id="deletechck<?php echo $i;?>" value="<?php echo $image_listview[$i]['id_image']; ?>"/></div>
                     	<div class="img_bg"><img src="<?php  echo $imgs; ?>"/></div>
                    </div>
                   <div class="name"><p><a href="insta_album_update.php?image_id=<?php echo  $image_listview[$i]['id_image'];?>">
				   <?php echo stripslashes(html_entity_decode($image_listview[$i]['image_title'],ENT_COMPAT, "UTF-8")); ?></a></p></div>
                   <p class="date"><?php echo  $dat;?></p>
                   <p class="pubbl"><?php echo $publish_status;?></p>
                </div>            	                                                                        <?php } ?>        
        	</div><!--end tabella-->
			 <input type="hidden" id="mode" name="mode" value="<?php echo $_POST['mode']; ?>" />
				<input type="hidden" id="type" name="type" value="" />
				<input type="hidden" id="action" name="action" value="<?php echo $_POST['action']; ?>" />
				<input type="hidden" id="image_id" name="image_id" value="<?php echo $_POST['image_id']; ?>" />
				<input type="hidden" id="basic_priority" name="basic_priority" value="<?php echo $_POST['basic_priority']; ?>" />
				<input type="hidden" id="orderby" name="orderby" value="<?php echo $orderby; ?>" />
				<input type="hidden" id="sort" name="sort" value="<?php echo $sort; ?>" />
				<input type="hidden" id="sortByType" name="sortByType" value="<?php echo $basetype ?>" />
				<input type="hidden" id="searchtitle" name="searchtitle" value="<?php echo $_REQUEST['searchtitle']; ?>" />
				<input type="hidden" id="page" name="page" value="<?php echo $_REQUEST['page']; ?>" />
				<input type="hidden" id="deleteSelected1" name="deleteSelected1" value="" />
				
			    <input type="hidden" id="keyword" name="keyword" value="<?php echo $_GET['search'];?>"/>
        </div>
		</form>
    </div>
</div>
</body>
<script>
$(document).ready(function()
{
	var success	=	getQueryString('success');
	var error	=	getQueryString('error');

	if(success.length > 0)
	{
		if(success == 'success')
			var message		=	'Informazioni salvate correttamente';
		if(success == 'delete')
			var message		=	'Foto correttamente eliminata';
			
		$("#msg").html(message);
		$("#msg").show();
	}
	else if(error.length > 0 && error == 'error')
	{
		$("#error").html('Error');
		$("#error").show();
	}
	
});

if('<?php echo $searchtitle ?>')
{
	
	document.getElementById('search').focus();
}

function filterPage(basic_priority) {
		document.frmList.mode.value = "filter";
		document.frmList.basic_priority.value = basic_priority;
		$('#frmList').submit();
}
function removeFilter() {
	document.frmList.mode.value = "filter";
	document.frmList.basic_priority.value = '';
	document.frmList.type.value = '';
	$('#frmList').submit();
}
function orderBy(orderby) {
    var searchVal	=	$('#search').val();
	$('#searchtitle').val(searchVal);
	var keyword     =  $('#keyword').val();
	document.frmList.mode.value = "filter";
	document.frmList.orderby.value = orderby;
   
	var sort_type	=	document.frmList.sort.value;
    window.location.href ="insta_album.php?search="+keyword+"&orderby="+orderby+"&sort="+sort_type;
	
}
function doSearch() {
	
	var searchVal	=	$('#search').val();
	
	$('#searchtitle').val(searchVal);
	document.frmList.mode.value = "filter";
    window.location.href ="insta_album.php?search="+searchVal;
	if(searchVal=="")
	{
      window.location.href ="insta_album.php";
	}
	
}
function doFilter(type) {
	document.frmList.mode.value = "";
	document.frmList.basic_priority.value = '';
	document.frmList.type.value = type;
	$('#frmList').submit();
}

function pageSubmit(page) {
	document.getElementById('page').value=page;
	$('#frmList').submit(); 
	return false;
}
function filterType(type)
{
	document.frmList.mode.value = "filter";
	document.frmList.sortByType.value = type;
	$('#frmList').submit();
}
function checkAll(eventobj) {
	if(eventobj.checked == true) {
		obj = document.getElementsByName("deletechck[]");
	 $len = obj.length;
	
		if(obj.length > 0) {
			
			for(i=0; i<obj.length; i++) {
				obj[i].checked = true;
			}
		}
	}
	if(eventobj.checked == false) {
		obj = document.getElementsByName("deletechck[]");
		if(obj.length > 0) {
			for(i=0; i<obj.length; i++) {
				obj[i].checked = false;
			}
		}
	}
}
function confirmDelete() {
	
	$delte=$('#deleteSelected1').val('delete');
    
	obj = document.getElementsByName("deletechck[]");
	
	var cnt = 0;
	if(obj.length > 0) {
		
		for(i=0; i<obj.length; i++) {
			
			if(obj[i].checked == true) {
				cnt++;
				 
			}
		}
		if(confirm("Attenzione, cancellare i record selezionati?")) 
				{
					var formAction = $("#frmList").attr("action");	
					formAction	+='?success=delete';	
					$("#frmList").attr("action", formAction);			
					$('#frmList').submit(); 
				}
	}
	if(cnt == 0) {
		alert("Nessun record selezionato!");
	} 
	return false;
}

// this is to manag the tabs list/thumb

$('#thumb_view').click(function(){
	$('#tabella, #tabella_head').removeClass();
	$('#tabella, #tabella_head').addClass('table_thumb_view');
	$('.preview').removeAttr("style");
	$('#tabella').scrollTop(0);
	vscroll_contenuto();
});

$('#list_view').click(function(){
	$('#tabella, #tabella_head').removeClass();
	$('#tabella, #tabella_head').addClass('table_list_view');
	$(".preview").css("width", $("#tabella_head").width());
	$('#tabella').scrollTop(0);
	vscroll_contenuto();
});
</script>
</html>