<?php
include "../includes/init.php";
include('session_check.php');
$currentpage	= 4; 
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
$condition	= "tab_user.user_id !='' AND tab_user.Trash ='1'";
$sort		= "ASC";
$orderby	= 'tab_user.user_id';
$trash      = '0';
$objUser	= 	new	user();

$deleteFlag	=	0;
if(($_POST['mode']=="delete") && isset($_POST['user_id'])) {  
	
	$deleteFlag = 1;
	$user_id = mysql_real_escape_string($_POST['user_id']);		
	$usero=$objUser->deleteUser($trash,$user_id);
	$msg = "Deleted successfully"; 
}

if(($_POST['deleteSelected1']=="delete") && isset($_POST['deleteSelected1'])) {  
	
	$deletechcks = $_POST['deletechck'];	

	if(is_array($deletechcks) && count($deletechcks) > 0) {
		foreach($deletechcks as $deletechck) {
			$deleteFlag = 1;
			$deletechck = mysql_real_escape_string($deletechck);	
			$objUser->deleteUser($trash,$deletechck);
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
			$condition .= " AND (tab_user.sys_name like '%".$searchtitle."%' OR tab_user.sys_surname like '%".$searchtitle."%')";
		}
	}
	if(isset($_POST['sortByType'])) {
		
		$basetype	= mysql_real_escape_string($_POST['sortByType']);	
		if($basetype) {
		
			$condition .= " AND tab_user.sys_name = ".$basetype;
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
	//$sort    = $_GET['orderby'];
	if($_GET['sort'] == 'ASC') { $sort = "DESC";}
	if($_GET['sort'] == 'DESC') { $sort = "ASC";}

}
if(isset($_GET['search'])) 
	{
		/*$searchtitle	= mysql_real_escape_string($_GET['search']);	
		if($searchtitle) {
			$condition .= " AND (tab_user.sys_name like '%".$searchtitle."%' OR tab_user.sys_surname like '%".$searchtitle."%')";
		}*/

        $searchtitle	= mysql_real_escape_string($_GET['search']);
		$searchword     = strpos($searchtitle,' ');
		$i=0;

		if($searchtitle) {
			$condition .= " AND (tab_user.sys_name like '%". $searchtitle."%' ";
			$condition .= "OR tab_user.sys_surname like '%". $searchtitle."%' ";
			$condition .= "OR tab_user.sys_user_name like'%". $searchtitle."%' ";
			$condition .= "OR CONCAT(TRIM(tab_user.sys_name),' ',TRIM(tab_user.sys_surname)) LIKE '%". $searchtitle."%' )";
		}
		//if($searchtitle){
		/*
			if(!$searchword){
				$condition .= " AND (tab_user.sys_name like '%".$searchtitle."%' OR tab_user.sys_surname like '%".$searchtitle."%' OR tab_user.sys_user_name like '%".$searchtitle."%')";
	
			}
			else{
				$searchtitles    = explode(' ',$searchtitle);
				$condition .= " AND ( ";

				for($i=0;$i<count($searchtitles);$i++)
				{
				    $value= $searchtitles[$i];
					if($i!=0)
					$condition .= " OR ";
					$condition .= "tab_user.sys_name like '%".$value."%' OR tab_user.sys_surname like '%".$value."%'OR tab_user.sys_user_name like '%".$value."%' ";
					
					
				}
		    $condition .= ")";
				
			} */

	}
//

$usrr           = 	$objUser->get_tab_user_details($condition,"users.php", "20", $_REQUEST['page'], $orderby.' '.$sort);

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
                                <button class="big" onclick="location.href='users_detail.php'">+Nuovo</button>
                            </div>
                            <div id="btn_select">     
                                <button class="big" id="deleteSelected" name="deleteSelected" onclick="return confirmDelete();"><span class="delete"></span></button>
                            </div>
                        </div>
                    </div>
                    <h1>Gestione Utenti</h1>
                    <form id="cont_search" method="get" onSubmit="javascript:doSearch();return false;">
                        <button type="submit" id="lens" class="icon_lens"></button>
                        <button type="reset" id="cancel" onclick="search_reset();" class="icon_cancel"></button>
                       <input id="search" class="search" type="text" value="<?php echo $_GET['search']; //$_POST['searchtitle']; ?>" onkeydown="search_check()" onblur="search_check()" placeholder="Cerca">
                    </form> 
                </div>
				<form id="frmList" name="frmList" action="users.php" method="post" style="position:relative;">
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
                        <td class="col1" onclick="javascript:orderBy('sys_name')">
							<?php
							if($orderby == 'sys_name' && $sort == 'DESC') 
							{
								$className	=	'desc';
							}
							else if($orderby == 'sys_name' && $sort == 'ASC')
							{
								$className	=	'asc';
							}
							else
								$className	=	'';
						?>
						
						
						<p class="<?php echo $className; ?>">Nome</p></td>
                        <td class="col2" onclick="javascript:orderBy('sys_surname')">
                        <?php
							if($orderby == 'sys_surname' && $sort == 'DESC') 
							{
								$className	=	'desc';
							}
							else if($orderby == 'sys_surname' && $sort == 'ASC')
							{
								$className	=	'asc';
							}
							else
								$className	=	'';
						?>
						<p  class="<?php echo $className; ?>">Cognome</p></td>
                        <td class="col3" onclick="javascript:orderBy('sys_user_name')">
						<?php
							if($orderby == 'sys_user_name' && $sort == 'DESC') 
							{
								$className	=	'desc';
							}
							else if($orderby == 'sys_user_name' && $sort == 'ASC')
							{
								$className	=	'asc';
							}
							else
								$className	=	'';
						?>


						
						
						<p  class="<?php echo $className; ?>">Username</p></td>
                        <td class="col4 last" onclick="javascript:orderBy('sys_active')">
						<?php
							if($orderby == 'sys_active' && $sort == 'DESC') 
							{
								$className	=	'desc';
							}
							else if($orderby == 'sys_active' && $sort == 'ASC')
							{
								$className	=	'asc';
							}
							else
								$className	=	'';
						?>

						<p  class="<?php echo $className; ?>">Attivo</p></td>
                      </tr>
                      <tr class="shadow"><td colspan="9"></td></tr>
                 </table>
            </div>
                    
            <!-------------------->
            
            <div id="tabella">
                <table id="table_body" class="users" width="100%" border="0" cellspacing="0" cellpadding="0">
				
				<?php 
					 
					for($i=0;$i<count($usrr['listing']);$i++){
						
						 $active		= 	$usrr['listing'][$i]['sys_active'];
						 $name			=	$usrr['listing'][$i]['user_id'];
						 
						 if($active=='1')
						 {
                           $actv	=	"Yes";
						 }
						 else
						 {
							$actv	=	"No";
						 }
						 ?>
                         
					    <tr class="table_link preview" id="tr_id<?php echo $usrr['listing'][$i]['user_id'];?>">
                        <td class="check"><input type="checkbox" class="checkbox" name="deletechck[]" id="deletechck<?php echo $i;?>" value="<?php echo $usrr['listing'][$i]['user_id']; ?>" onclick="selection_color(this)"/></td>
                        <td class="col1">
                        	<p><a href="user_update_detail.php?user_id=<?php echo $name;?>"><?php echo $usrr['listing'][$i]['sys_name'];?></a></p>
                        </td>

                        <td class="col2"><p><?php echo getCleanString($usrr['listing'][$i]['sys_surname']); ?></p></td>
                        <td class="col3"><p><?php echo getCleanString($usrr['listing'][$i]['sys_user_name']);?></p></td>
                        <td class="col4"><p><?php echo $actv;?></p></td>						 
						</tr>
                   <?php } ?>
                </table>
			  
            </div>
        </div>
                <input type="hidden" id="mode" name="mode" value="<?php echo $_POST['mode']; ?>" />
				<input type="hidden" id="type" name="type" value="" />
				<input type="hidden" id="action" name="action" value="<?php echo $_POST['action']; ?>" />
				<input type="hidden" id="user_id" name="user_id" value="<?php echo $_POST['user_id']; ?>" />
				<input type="hidden" id="basic_priority" name="basic_priority" value="<?php echo $_POST['basic_priority']; ?>" />
				<input type="hidden" id="orderby" name="orderby" value="<?php echo $orderby; ?>" />
				<input type="hidden" id="sort" name="sort" value="<?php echo $sort; ?>" />
				<input type="hidden" id="sortByType" name="sortByType" value="<?php echo $basetype ?>" />
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
	window.location.href ="users.php?search="+keyword+"&orderby="+orderby+"&sort="+sort_type;
	//$('#frmList').submit();
}
function doSearch() {
	var searchVal	=	$('#search').val();
	$('#searchtitle').val(searchVal);
	document.frmList.mode.value = "filter";
	window.location.href ="users.php?search="+searchVal;
	if(searchVal=="")
	{
      window.location.href ="users.php";
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
	/*$('#deleteSelected1').val('delete');
	obj = document.getElementsByName("deletechck[]");
	
	var cnt = 0;
	if(obj.length > 0) {
		for(i=0; i<obj.length; i++) {
			if(obj[i].checked == true) {
				cnt++;
				if(confirm("Attenzione, cancellare i record selezionati?")) {
					$("#frmList").attr("action", "users.php?success=delete");					
					$('#frmList').submit(); 
					//window.location = "users.php?success=delete";
				} 
			}
		}
	}
	if(cnt == 0) {
		alert("Nessun record selezionato!");
	} 
	return false;
}*/
            var arr = new Array();
            $("input:checked").each(function () {
              //$id= $(this).attr("id").val();
              //alert($id);
                arr.push($(this).attr('value'));

            }); //each
          
          if (confirm("Attenzione, confermare la cancellazione dell'utente?")) {
            $.ajax({
             type: "POST",
             url: "deletefunctions.php",
       		 data: {arr:arr},//pass the array to the ajax call
           	 cache: false,
          
	       success: function(data)
	             {  
	             	if(data == 0)
	             	{
		             	
		                var message	='Utente eliminato correttamente';
			 			$("#msg").html(message);
		     			$("#msg").show();
		     			for($i=0;$i<arr.length;$i++)
		     			{
		     			$("#tr_id"+arr[$i]).remove();
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
