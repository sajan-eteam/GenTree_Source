<?php
include "../includes/init.php";
include('session_check.php');
$currentpage	= 7; 
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
$condition	 = " log_id IS NOT NULL ";
$sort		 = "DESC";
$orderby	 = 'tab_log.log_time';
$objLog		 =  new userlog();
$objUser	 =	new user(); 
$deleteFlag	 =	0;

if(($_POST['mode']=="delete") && isset($_POST['log_id'])) {  
	
	$deleteFlag = 1;
	$log_id = mysql_real_escape_string($_POST['log_id']);		
	$usero=$objLog->deleteUser($log_id);
	$msg = "Deleted successfully"; 
}

if(($_POST['deleteSelected1']=="delete") && isset($_POST['deleteSelected1'])) {  
	
	$deletechcks = $_POST['deletechck'];	

	if(is_array($deletechcks) && count($deletechcks) > 0) {
		foreach($deletechcks as $deletechck) {
			$deleteFlag = 1;
			$deletechck = mysql_real_escape_string($deletechck);	
			$objLog->deleteUser($deletechck);
			$msg = "Deleted successfully"; 
		}
	}
}

if($_POST['mode']=="filter") {
	$flag_filter = '';

	if(isset($_POST['searchtitle'])) 
	{
		$searchtitle	= mysql_real_escape_string($_POST['searchtitle']);	
		if($searchtitle) {
			$condition .= " AND (tab_log.log_text like '%".$searchtitle."%')";
		}
	}
	if(isset($_POST['sortByType'])) {
		
		$basetype	= mysql_real_escape_string($_POST['sortByType']);	
		if($basetype) {
		
			$condition .= " AND tab_log.log_time = ".$basetype;
		}
	}
	if($_REQUEST['sort'] == 'ASC') {  $sort = "DESC";}
	if($_REQUEST['sort'] == 'DESC') { $sort = "ASC";}
	if($_REQUEST['orderby'] != '') {  $orderby = $_REQUEST['orderby'];}	
}
//new code
if(isset($_GET['orderby']) && isset($_GET['sort']))
{
	$orderby = $_GET['orderby'];
	if($_GET['sort'] == 'ASC') { $sort = "DESC";}
	if($_GET['sort'] == 'DESC') { $sort = "ASC";}

}
if(isset($_GET['search'])){
        $searchtitle	= mysql_real_escape_string($_GET['search']);
		$searchword     = strpos($searchtitle,' ');
		$i=0;

		if($searchtitle) {
			$condition .= "AND (tab_log.log_time like '%". $searchtitle."%' ";
			$condition .= "OR tab_log.user_id like '%". $searchtitle."%' ";
			$condition .= "OR tab_log.log_text like'%". $searchtitle."%')";
		}

	}
$usrr           = 	$objLog->get_tab_log_details($condition,"log_list.php", "20", $_REQUEST['page'], $orderby.' '.$sort);
?>
<div id="messages">
	<div id="error" style="display:none;"></div><!-- When there is an error use this div to show the message in this div -->
	<div id="msg" style="display:<?php if($deleteFlag == 1) echo "block"; else echo "none"; ?>;"><?php echo $msg; ?></div>  <!-- When there is notify message use this div to show it-->
</div>
        <div id="tabella_cont" class="table_main">
            <div id="tabella_head" class="table_head_main">
                <div id="top_right">
                    <div id="head_right">
                        <div class="buttons">
                            <div id="btn_notselect">
                                <button class="big" style="display:none;" onclick="location.href='users_detail.php'">+Nuovo</button>
                            </div>
                            <div id="btn_select">     
                                <button class="big" id="deleteSelected" name="deleteSelected" onclick="return confirmDelete();"><span class="delete"></span></button>
                            </div>
                        </div>
                    </div>
                    <h1>LOG</h1>
                    <form id="cont_search" method="get" onSubmit="javascript:doSearch();return false;">
                        <button type="submit" id="lens" class="icon_lens"></button>
                        <button type="reset" id="cancel" onclick="search_reset();" class="icon_cancel"></button>
                       <input id="search" class="search" type="text" value="<?php echo $_GET['search']; //$_POST['searchtitle']; ?>" onkeydown="search_check()" onblur="search_check()" placeholder="Cerca">
                    </form> 
                </div>
				<form id="frmList" name="frmList" action="log_list.php" method="post" style="position:relative;">
                <table id="table_head"  class="users" width="100%" border="0" cellspacing="0" cellpadding="0">
                	 <tr class="filter">
                     	<td colspan="9">
						<?php echo $usrr['paginationTable']; ?>
                        <div class="pagination" style="display:none;">
                        	<button class="square">&laquo;</button>
                            <button class="square">&lsaquo;</button>
                            <span>1-8 di 92</span>
                        	<button class="square">&rsaquo;</button>
                            <button class="square">&raquo;</button>
                        </div>          
                        </td>
                     </tr>
                     <tr class="labels">
                        <td class="check"><input id="checkAll" type="checkbox" onchange="toggleChecked(this.checked)"/> </td>
                        <!-- for sorting you have to add or remove the class asc or desc to the related p -->
                        <td class="col1">
							
						
						<p>Log Name</p></td>
                        <td class="col2">
                        
						<p>Logtext</p></td>
                        <td class="col3" onclick="javascript:orderBy('log_time')">
						<?php
							if($orderby == 'log_time' && $sort == 'DESC') 
							{
								$className	=	'desc';
							}
							else if($orderby == 'log_time' && $sort == 'ASC')
							{
								$className	=	'asc';
							}
							else
								$className	=	'';
						?>
						<p>LogTime</p></td>
                        <td class="col4 last">
						
						<p>LogType</p></td>
                      </tr>
                      <tr class="shadow"><td colspan="9"></td></tr>
                 </table>
            </div>
                    
            <!-------------------->
            
            <div id="tabella">
                <table id="table_body" class="users" width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php 
						for($i=0;$i<count($usrr['listing']);$i++){

						 	$name			=	$usrr['listing'][$i]['user_id'];
						 	$username       =   $objUser->appuserdetail($name);
						 	$logType 		=   $usrr['listing'][$i]['log_type'];
						 	$LogTypeName    =   $objLog->logTypeList($logType);
						 ?>
					    <tr class="table_link preview" id="tr_id<?php echo $usrr['listing'][$i]['log_id'];?>">
                        <td class="check"><input type="checkbox" class="checkbox" name="deletechck[]" id="deletechck<?php echo $i;?>" value="<?php echo $usrr['listing'][$i]['log_id']; ?>" onclick="selection_color(this)"/></td>
                        <td class="col1">
                        <p><a href=""><?php echo $username['sys_name'];?></a></p>
                        <td class="col2"><p><?php echo getCleanString($usrr['listing'][$i]['log_text']); ?></p></td>
                        <td class="col3"><p><?php echo date('d/m/Y h:i:s',strtotime($usrr['listing'][$i]['log_time']));?></p></td>
                        <td class="col4"><p><?php echo $LogTypeName;?></p></td>
                       						 
						</tr>
                   <?php } ?>
                </table>
			  
            </div>
        </div>
                <input type="hidden" id="mode" name="mode" value="<?php echo $_POST['mode']; ?>" />
				<input type="hidden" id="type" name="type" value="" />
				<input type="hidden" id="action" name="action" value="<?php echo $_POST['action']; ?>" />
				<input type="hidden" id="log_id" name="log_id" value="<?php echo $_POST['log_id']; ?>" />
				<input type="hidden" id="basic_priority" name="basic_priority" value="<?php echo $_POST['basic_priority']; ?>" />
				<input type="hidden" id="orderby" name="orderby" value="<?php echo $orderby; ?>" />
				<input type="hidden" id="sort" name="sort" value="<?php echo $sort; ?>" />
				<input type="hidden" id="sortByType" name="sortByType" value="<?php echo $basetype; ?>" />
				<input type="hidden" id="page" name="page" value="<?php echo $_REQUEST['page']; ?>" />
				<input type="hidden" id="searchtitle" name="searchtitle" value="<?php echo $_REQUEST['searchtitle']; ?>" />
				<input type="hidden" id="deleteSelected1" name="deleteSelected1" value="" />
				<input type="hidden" id="keyword" name="keyword" value="<?php echo $_GET['search'];?>"/>
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
			var message		=	'Utente eliminato correttamente';

		 $("#msg").html(message);
	     $("#msg").show();
        // window.clearTimeout(1000);
         
     	
		
	   //$("#msg").fadeOut(3000);
	   //window.location.href='users.php';
	}
	else if(error.length > 0)
	{
		var error_mesg = '';
		
		if(error == 'errors')
			error_mesg		=	'Impossibile aggiungere dati';
		else if(error == 'exist1')
			error_mesg		=	'User already exist';
		else if(error == 'exist2')
			error_mesg		=	'Username already exist';
		else if(error == 'exist3')
			error_mesg		=	'Email already exist';
		else if(error == 'exist4')
			error_mesg		=	'Email already exist';
		else if(error == '1' || error == '2' || error == '3')
			error_mesg		=	'Impossibile aggiungere dati';
			
		$("#error").html(error_mesg);
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
	window.location.href ="log_list.php?search="+keyword+"&orderby="+orderby+"&sort="+sort_type;
	//$('#frmList').submit();
}
function doSearch() {
	var searchVal	=	$('#search').val();
	$('#searchtitle').val(searchVal);
	document.frmList.mode.value = "filter";
	window.location.href ="log_list.php?search="+searchVal;
	if(searchVal=="")
	{
      window.location.href ="log_list.php";
	}
	//$('#frmList').submit();
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

</script>

</html>
