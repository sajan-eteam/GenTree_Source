<?php
include('session_check.php');
include "../includes/init.php"; 
$currentpage	= 1;
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
        <!----left part---->
        <?php
			include('menu.php');
		?>       
        <!----end left part---->
<?php
$condition	= " tab_gene_user.gene_user_id !='' AND tab_gene_user.Trash ='1'";
$sort		= "ASC";
$orderby	= 'tab_gene_user.gene_user_id';
$trash      =  '0';
$enable		=  '0';
$deletetime = date('Y-m-d H:i:s');
$objUser		= 	new	geneuser();

if(($_POST['mode']=="delete") && isset($_POST['gene_user_id'])) {  
	$gene_user_id = mysql_real_escape_string($_POST['gene_user_id']);		
	$objUser->deleteGeneUser($trash,$enable,$deletetime,$gene_user_id);
	$msg = "Deleted successfully"; 
}

if(($_POST['deleteSelected1']=="delete") && isset($_POST['deleteSelected1'])) {  
	$deletechcks = $_POST['deletechck'];	
	if(is_array($deletechcks) && count($deletechcks) > 0) {
		foreach($deletechcks as $deletechck) {
			$deletechck = mysql_real_escape_string($deletechck);		
			$objUser->deleteGeneUser($trash,$enable,$deletetime,$deletechck);
			$msg = "Deleted successfully"; 
		}
	}
}

if($_POST['mode']=="filter") 
{
	$flag_filter = '';
	
	if(isset($_POST['searchtitle'])) 
	{
		$searchtitle	= mysql_real_escape_string($_POST['searchtitle']);	
		if($searchtitle) {
			$condition .= " AND (tab_gene_user.gene_name like '%".$searchtitle."%' OR tab_gene_user.gene_surname like '%".$searchtitle."%')";
		}
	}
	if(isset($_POST['sortByType'])) {
		$basetype	= mysql_real_escape_string($_POST['sortByType']);	
		if($basetype) {
			$condition .= " AND tab_gene_user.gene_name = ".$basetype;
		}
	}
	if($_REQUEST['sort'] == 'ASC') { $sort = "DESC";}
	if($_REQUEST['sort'] == 'DESC') { $sort = "ASC";}
	if($_REQUEST['orderby'] != '') { $orderby = $_REQUEST['orderby'];}	
}

//new code
if(isset($_GET['orderby']) && isset($_GET['sort']))
{
	$orderby = $_GET['orderby'];
	//$sort    = $_GET['orderby'];
	if($_GET['sort'] == 'ASC') { $sort = "DESC";}
	if($_GET['sort'] == 'DESC') { $sort = "ASC";}

}
if(isset($_GET['search'])) 
	{
		$searchtitle	= mysql_real_escape_string($_GET['search']);
		$searchword     = strpos($searchtitle,' ');
		$i=0;

		if($searchtitle) {
			$condition .= " AND (tab_gene_user.gene_name like '%". $searchtitle."%' ";
			$condition .= "OR tab_gene_user.gene_surname like '%". $searchtitle."%' ";
			$condition .= "OR tab_gene_user.gene_nickname like'%". $searchtitle."%' ";
			$condition .= "OR CONCAT(TRIM(tab_gene_user.gene_name),' ',TRIM(tab_gene_user.gene_surname)) LIKE '%". $searchtitle."%' )";
		}
		//if($searchtitle){
		
		/*	if(!$searchword){
				$condition .= " AND (tab_gene_user.gene_name like '%". $searchtitle."%' OR tab_gene_user.gene_surname like '%". $searchtitle."%' OR tab_gene_user.gene_nickname like'%". $searchtitle."%')";
	
			}
			else{
				$searchtitles    = explode(' ',$searchtitle);
				$condition .= " AND(";

				for($i=0;$i<count($searchtitles);$i++)
				{
				    $value= $searchtitles[$i];
					if($i!=0)
					$condition .= " OR ";
					$condition .= "tab_gene_user.gene_name like '%". $value."%' OR tab_gene_user.gene_surname like '%". $value."%' OR tab_gene_user.gene_nickname like'%". $value."%'";
					
					
				}
		    	$condition .= ")";
				
			} */
		//}
	}
//
$family_members = 	$objUser->get_gene_user_details($condition, "tree.php", $orderby.' '.$sort);
?>
        <div id="tabella_cont" class="table_main">
            <div id="tabella_head" class="table_head_main">
                <div id="top_right">
                    <div id="head_right">
                        <div class="buttons">
                            <div id="btn_notselect">
                                <button class="big" onclick="location.href='tree_detail.php'">+ Nuovo</button>
                            </div>
                            <div id="btn_select">     
                                <button class="big" id="deleteSelected" name="deleteSelected" onclick="return confirmDelete();"><span class="delete"></span></button>
                            </div>
                        </div>
                    </div>
                    <h1>Albero Genealogico</h1>
                    <form id="cont_search" method="get" onSubmit="javascript:doSearch();return false;">
                        <button type="submit" id="lens" class="icon_lens"></button>
                        <button type="reset" id="cancel" onclick="search_reset();" class="icon_cancel"></button>
                        <label>
                            <input id="search" class="search" type="text" value="<?php echo $_GET['search']; ?>" onkeydown="search_check()" onblur="search_check()" placeholder="Cerca">
                        </label>
                    </form>
                </div>
				<form id="frmList" name="frmList" action="tree.php" method="post">
                <table id="table_head" class="tree" width="100%" border="0" cellspacing="0" cellpadding="0">
                	 <tr class="filter">
                     	<td colspan="9">
                        <!-- Pagination is not needed in this page. We have to show the full list.
                        <div class="pagination">
                        	<button class="square">&laquo;</button>
                            <button class="square">&lsaquo;</button>
                            <span>1-8 di 92</span>
                        	<button class="square">&rsaquo;</button>
                            <button class="square">&raquo;</button>
                        </div> -->          
                        </td>
                     </tr>
                     <tr class="labels">
                        <td class="check"><input id="checkAll" type="checkbox" onchange="toggleChecked(this.checked)"/> </td>
                        <!-- for sorting you have to add or remove the class asc or desc to the related p -->
                        <td class="col1" onclick="javascript:orderBy('gene_name')">
						<?php
							if($orderby == 'gene_name' && $sort == 'DESC') 
							{
								$className	=	'desc';
							}
							else if($orderby == 'gene_name' && $sort == 'ASC')
							{
								$className	=	'asc';
							}
							else
								$className	=	'';
						?>
							<p id="title_name" class="<?php echo $className; ?>">Nome</p>
						</td>
                        <td class="col2" onclick="javascript:orderBy('gene_surname')">
						<?php
							if($orderby == 'gene_surname' && $sort == 'DESC') 
							{
								$className	=	'desc';
							}
							else if($orderby == 'gene_surname' && $sort == 'ASC')
							{
								$className	=	'asc';
							}
							else
								$className	=	'';
						?>
							<p id="title_cogname" class="<?php echo $className; ?>">Cognome</p>
						</td>
                        <td class="col3" onclick="javascript:orderBy('gene_birthday')">
						<?php
							if($orderby == 'gene_birthday' && $sort == 'DESC') 
							{
								$className	=	'desc';
							}
							else if($orderby == 'gene_birthday' && $sort == 'ASC')
							{
								$className	=	'asc';
							}
							else
								$className	=	'';
						?>
							<p id="title_date" class="<?php echo $className; ?>">Data di nascita</p>
						</td>
                        <td class="col4 last" onclick="javascript:orderBy('gene_generation')">
						<?php
							if($orderby == 'gene_generation' && $sort == 'DESC') 
							{
								$className	=	'desc';
							}
							else if($orderby == 'gene_generation' && $sort == 'ASC')
							{
								$className	=	'asc';
							}
							else
								$className	=	'';
						?>
							<p id="title_generation" class="<?php echo $className; ?>">Generazione</p>
						</td>
                      </tr>
                      <tr class="shadow"><td colspan="9"></td></tr>
                 </table>
            </div>                    
            <!-------------------->            
            <div id="tabella">
                <table id="table_body" class="tree" width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php				
					//$family_members	=	$objUser->familymember();
					for($i=0; $i<sizeof($family_members); $i++)					
					{
				?>
                    <tr class="table_link preview" id="tr_id<?php echo $family_members[$i]['gene_user_id'];?>">
                        <td class="check"><input type="checkbox" class="checkbox" name="deletechck[]" id="deletechck<?php echo $i;?>" onclick="selection_color(this)" value="<?php echo $family_members[$i]['gene_user_id']; ?>"/></td>
                        <td class="col1">
                        	<p><a href="tree_detail.php?gene_user_id=<?php echo $family_members[$i]['gene_user_id']; ?>"><?php echo   getCleanString($family_members[$i]['gene_name']);?></a></p>
                        </td>
                        <td class="col2"><p><?php echo getCleanString($family_members[$i]['gene_surname']);?></p></td>
                        <td class="col3"><p><?php echo dateFormat($family_members[$i]['gene_birthday']);?></p></td> 
                        <td class="col4"><p><?php echo $objUser->romanNumerals($family_members[$i]['gene_generation']); ?></p></td>
					</tr>
				<?php 
					}
				?>                
                </table>
            </div>
        </div>
				<input type="hidden" id="mode" name="mode" value="<?php echo $_POST['mode']; ?>" />
				<input type="hidden" id="type" name="type" value="" />
				<input type="hidden" id="action" name="action" value="<?php echo $_POST['action']; ?>" />
				<input type="hidden" id="gene_user_id" name="gene_user_id" value="<?php echo $_POST['gene_user_id']; ?>" />
				<input type="hidden" id="basic_priority" name="basic_priority" value="<?php echo $_POST['basic_priority']; ?>" />
				<input type="hidden" id="orderby" name="orderby" value="<?php echo $orderby; ?>" />
				<input type="hidden" id="sort" name="sort" value="<?php echo $sort; ?>" />
				<input type="hidden" id="sortByType" name="sortByType" value="<?php echo $basetype ?>" />
				<input type="hidden" id="page" name="page" value="<?php echo $_REQUEST['page']; ?>" />
				<input type="hidden" id="searchtitle" name="searchtitle" value="<?php echo $_REQUEST['searchtitle']; ?>" />
				<input type="hidden" id="deleteSelected1" name="deleteSelected1" value=""/>
				<input type="hidden" id="keyword" name="keyword" value="<?php echo $_GET['search'];?>"/>
				<input type="hidden" id="listing" name="listing" value="<?php echo count($listing);?>"/>
		</form>
    </div>
</div>
</body>
<script>
$(document).ready(function()
{
	/*alert($("#orderby").val());
	alert($("#sort").val());
	alert($("#sortByType").val());*/
	
	var success	=	getQueryString('success');
	var error	=	getQueryString('error');

	if(success.length > 0)
	{
		if(success == 'success')
			var message		=	'Informazioni salvate correttamente';
		if(success == 'delete')
			var message		=	'Utente cancellato con successo';
			
		$("#msg").html(message);
		$("#msg").show();
	}
	else if(error.length > 0)
	{
		$("#error").html('Error');
		$("#error").show();
	}
	else
	{
		$("#msg").hide();
		$("#error").hide();
	}

	
});
if('<?php echo $searchtitle ?>')
{
	document.getElementById('search').focus();
}
function deleteMagazinePermanently(gene_user_id) { 
	if(confirm("Do you want to delete selected record?")) {
		document.frmList.mode.value = "delete";
		document.frmList.gene_user_id.value = gene_user_id;
		document.frmList.submit();	
	}
	return false;
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
	window.location.href ="tree.php?search="+keyword+"&orderby="+orderby+"&sort="+sort_type;
	
}
function doSearch() {
	var searchVal	=	$('#search').val();
	$('#searchtitle').val(searchVal);
	var keyword     =  $('#keyword').val();
	//alert(keyword);
	document.frmList.mode.value = "filter";
	window.location.href ="tree.php?search="+searchVal;
	if(searchVal=="")
	{
      window.location.href ="tree.php";
	}
	
}
function doFilter(type) {
	document.frmList.mode.value = "";
	document.frmList.basic_priority.value = '';
	document.frmList.type.value = type;
	$('#frmList').submit();
}
function restoreBasic(emagazine_id) {
	xmlhttp=ajaxRequest();	
	xmlhttp.onreadystatechange = function()
	{			
		if(xmlhttp.readyState==4) { 
				document.frmList.mode.value = "filter";
				document.frmList.basic_priority.value = '';
				document.frmList.type.value = 'trash';
				$('#frmList').submit();
		}
	}
	url = "table=tab_basic&id="+emagazine_id+"&field=emagazine_id&mode=restore&"+Math.random();
	xmlhttp.open("POST", 'ajax_tableUpdates.php', true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(url);		
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
		var obj = document.getElementsByName("deletechck[]");
		if(obj.length > 0) {
			for(i=0; i<obj.length; i++) {
				obj[i].checked = true;
			}
		}
	}
	if(eventobj.checked == false) {
		var obj = document.getElementsByName("deletechck[]");
		if(obj.length > 0) {
			for(i=0; i<obj.length; i++) {
				obj[i].checked = false;
			}
		}
	}
	
  
	
}


function confirmDelete() { 		
	/*$('#deleteSelected1').val('delete');
	obj = document.getElementsByName("deletechck[]");
	var cnt = 0;
	if(obj.length > 0) {
		for(i=0; i<obj.length; i++) {
			if(obj[i].checked == true) {
				cnt++;
				if(confirm("Attenzione, cancellare i record selezionati?")) 
				{	
					$("#frmList").attr("action", "tree.php?success=delete");
					$('#frmList').submit();
					//window.location = "tree.php?success=delete";					
				} 
			}
		}
	}
	if(cnt == 0) {
		alert("Nessun record selezionato!");
	} 
	return false;*/
      var tree = new Array();
            $("input:checked").each(function () {
              
                tree.push($(this).attr('value'));

            }); 
          
          if (confirm("Attenzione, confermare la cancellazione dell'utente?")) {
            $.ajax({
             type: "POST",
             url: "deletefunctions.php",
       		 data: {tree:tree},//pass the array to the ajax call
           	 cache: false,
          
	       success: function(data)
	             {  
	             	if(data == 0)
	             	{
		             	
		                var message	='Utente eliminato correttamente';
			 			$("#msg").html(message);
		     			$("#msg").show();
		     			for($i=0;$i<tree.length;$i++)
		     			{
		     			$("#tr_id"+tree[$i]).remove();
		     		    }
		     			
	     		    }
	     		    else
	     		    {
	     		    var message	='Some error occured';
		 			$("#msg").html(message);
	     			$("#msg").show();
	     		    } 
	              }
      		 });//ajax
}
}
</script>
</html>
<?php
function dateFormat($dateVar)
{
	$dateArr		=	explode('-', $dateVar);
	$newDateFormat	=	$dateArr[2].'/'.$dateArr[1].'/'.$dateArr[0];
	return $newDateFormat;
}
?>