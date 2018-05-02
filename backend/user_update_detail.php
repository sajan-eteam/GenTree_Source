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
<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="css/structure.css">
<link rel="stylesheet" href="css/menu.css">
<link rel="stylesheet" href="css/detail.css">

<script src="js/jquery.js"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/main.js"></script>
<script>
$(document).ready(function() {
	$members			=	$('input:radio[name=alive]:checked').val();
	if($members==1)
	{
		$('#e_mail').css('display','block');
	}
	if($members==0)
	{
		$('#emails').css('display','block');
	}
	//$("#user_opt1").hide();
	//$("#user_opt2").hide();
	family_user = function(){
		$("#user_opt1").show();
		$("#e_mail").show();
		$("#user_opt2").hide();
    } 
	external_user = function(){
		$("#user_opt1").hide();
		$("#emails").show();
		$("#user_opt2").show();
    }
});
</script>
<script>
$(document).on('keydown', '#pword', function(e) {
    if (e.keyCode == 32) return false;
});
</script>
<script>
	$(document).ready(function(){
       
		var requestUrl = window.location.search; 
	    if(requestUrl !='') {

		var success	=	getQueryString('success');
		var error	=	getQueryString('error');

		if(success.length > 0)
		{
			if(success == 'success')
				var message		=	'Informazioni salvate correttamente';
			
			
			$("#msg").html(message);
			$("#msg").show();
		}
		else if(error.length > 0)
		{
		
	        if(error == 'error')
				error     =   'Impossibile aggiornare I dettagli';
			else if(error == '4')
				error	  =  'Email già esistente';
			else if(error == '5') 
				error  =  'Email già esistente';  
			else if(error == '6')
				error = ' Utente già esistente';
			else if(error == '7')
				error = ' Utente già esistente';
			
			$("#error").html(error);
			$("#error").show();
		}
	}
		$("#uname").focus();
		$("#salva").click(function(){
			        
					$userid			=   $('#userid').val();
					$username		=	$('#uname').val();
					$password		=	$('#pword').val();
					$confirmpassword=   $('#confrmpword').val();
					$userpassword   =   $('#userpassword').val();
					$member			=	$('input:radio[name=alive]:checked').val();
					$name			=	$("#member option:selected").val();
					
					$appusernam		=	$('#name').val();
					$appsurname		=	$('#surname').val();
				
					$appphone		=	encodeURIComponent($('#phone').val());
					$status			=	$('input:radio[name=pubbl]:checked').val();
					//$mobRegex		=	new RegExp(/^[\+\0-9]{10,16}$/);
					//$validmobnum	=	$mobRegex.test($appphone);
					if($member == 0)
					{
					  $appemail		=	$('#email').val();
					}
					if($member == 1)
					{
					  $appemail		=	$('#email2').val();
					}
					var emailRegex 		=   new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
					var valid 		= 	emailRegex.test($appemail);
					var flag 		= 	0;
                    

					if($member == 0)
					{
						$name	=	'';
					}
					if($username=='')
					{
						flag = 1;
						$("#usr").addClass('error');
					}
					else
					{
						//flag = 0;
						$("#usr").removeClass('error');
					}

					if($password=='' || $password.length<6)
					{
						flag = 1;
						var message  = 'La lunghezza della password deve essere di 6 o più caratteri';
		                $("#error").html(message);
						$("#error").show();
						$("#pwd").addClass('error');
						$("#msg").hide();
					}
					else
					{
						//flag = 0;
						$("#error").hide();
						//$("#msg").hide();
						$("#pwd").removeClass('error');
						$("#cword").removeClass('error');
					}
					if($confirmpassword)
					{
						if($password!=$confirmpassword)
						{
						  flag = 1;
						  $("#cword").addClass('error');
						}
						else
						{
						  $("#cword").removeClass('error');	
						}
					}
                    if($password!=$userpassword)
                    {
                      
                      if($password!=$confirmpassword)
                      {
                      	flag = 1;
                      	$("#cword").addClass('error');
                      }
                      else
                      {
                      	$("#cword").removeClass('error');
                      }
							
                    }

					if($member=='null')
					{
						flag = 1;
						$("#mem").addClass('error');
					}
					else
					{
						//flag = 0;
						$("#mem").removeClass('error');
					}
				   if($member==1)
					{  					  
						  if($name=='null') 
						  {
							flag = 1;
							$("#opt").addClass('error');
						   }
						   else
						   {
							 $("#opt").removeClass('error');
						   }
				
						  if($appemail=='')
						  {   
							
							flag = 1;
							$('#e_mail').addClass('error');	
						  }
						  else
						  {
							$('#e_mail').removeClass('error');
						  }
						  if(!valid)
						  {
							flag = 1;
						    $('#e_mail').addClass('error');	
						  }
						 else
						 {
		
							$('#e_mail').removeClass('error');
						  }
					}

					if($member==0)
					{
						if($appusernam=='')
						{
							flag = 1;
							$("#nam").addClass('error');
						}
						else
						{
							//flag = 0;
							$("#nam").removeClass('error');
						}
						if($appsurname=='')
						{
							flag = 1;
							$("#cog").addClass('error');
						}
						else
						{
							//flag = 0;
							$("#cog").removeClass('error');
						}

						if($appemail=='')
						{   
							
							flag = 1;
							$('#emails').addClass('error');	
						}
						else
						{
							$('#emails').removeClass('error');
						}
						if(!valid)
						{
							flag = 1;
							$('#emails').addClass('error');	
						}
						else
						{
							//flag = 0;
							$('#emails').removeClass('error');
						}
						/*
						if($appphone)
						{
							if(!$validmobnum)
							{
								flag = 1;
								$('#tele').addClass('error');	
							}
							else
							{
								//flag = 0;
								$('#tele').removeClass('error');
							}
						}*/

					}
					if($status=='null')
					{
						flag = 1;
						$("#active").addClass('error');
					}
					else
					{
						//flag = 0;
						$("#active").removeClass('error');
					}

					if(flag  == 0)
					{

						$.ajax({
								type: 'POST',
								url: 'save_update_details.php', 
								data: 'useid='+$userid+'&uname='+$username+'&pword='+$password+'&confirmpassword='+$confirmpassword+'&member='+$member+
									 '&userid='+$name+'&appusr='+$appusernam+'&appsur='+$appsurname+
									 '&appemail='+$appemail+'&appphon='+$appphone+'&status='+$status,
									  success: function(data) 
										{
											
										   $("#msg").hide();
                                           $("#error").hide();
										   if(data==1)
											{
												
											 var message  = 'Impossibile aggiornare I dettagli';
											 $("#error").html(message);
											 $("#error").show();
											//window.location = "user_update_detail.php?user_id="+$userid+"&&error=error";
											}
											if(data==2)
											{
											  var message  = 'Email già esistente';
											  $("#error").html(message);
											  $("#error").show();
											  //window.location = "user_update_detail.php?user_id="+$userid+"&&error=4";
											}
											if(data==0)
											{
												var message		=	'Informazioni salvate correttamente';		
												$("#msg").html(message);
												$("#msg").show();
												setTimeout(function() { 
						   						location.reload();
												}, 1100);
												//window.location = "user_update_detail.php?user_id="+$userid+"&&success=success";
											}
											
										}
								});
					}
			});


$("#delete").click(function(){
$user_id     =   $('#userid').val();
if (confirm("Attenzione, confermare la cancellazione dell'utente?"+$user_id)) {
    $.ajax({
        url: 'deletefunctions.php',
        type: "POST",
        data: 'userid='+$user_id,
        success: function (data) {
           window.location='users.php';
        }
    });
}
});
});
function goBack()
  {
	window.history.back();
  }
</script>
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
			$user_id      = $_GET['user_id'];
		?>
        <!----end left part---->

        <div id="tabella_cont" class="table_main">
            <div id="tabella_head" class="table_head_main">
                <div id="top_right">
                    <div id="head_right">
                        <div class="buttons">
                        	<button class="big" onclick="javascript:goBack();"><img src="img/buttons/back.gif"/></button >
                            <button class="big" id="salva">salva</button >
                            <button class="big" id="delete">elimina</button >
                        </div>
                    </div>
                    <h1>Gestione Utenti</h1>
                </div>
            </div>
            <!-------------------->
            <div id="tabella">
                <div id="middle_colom">
				    <?php 
					
					$objtabuser = new user();
					$obj        = $objtabuser->appuserdetail($user_id);
					
					$uname      = $obj['sys_user_name'];
					$password   = $obj['sys_password'];
                    $seluseid   = $obj['gene_user_id'];
					$member     = $obj['sys_is_a_member'];
					$name       = $obj['sys_name'];
					$surname    = $obj['sys_surname'];
					$email      = $obj['sys_email'];
					$phone      = $obj['sys_phone'];
					$active     = $obj['sys_active'];
					?>
                    <div id="usr"><p>Username*</p><input type="text" id="uname" value="<?php echo getCleanString($uname);?>" readonly/></div>
                    <div id="pwd"><p>Password*</p><input type="password" id="pword" value="<?php echo $password; ?>"/></div>
                    <div id="cword"><p>Confirm Password</p><input type="password" id="confrmpword" value=""/></div>
                    <div id="mem"><p>Membro dell'albero*</p><input onclick="family_user()" name="alive" value="1" <?php echo ($member=='1')?'checked':'' ?> type="radio" class="radio"/>Si &nbsp;&nbsp;
                    	<input onclick="external_user()" name="alive" value="0"<?php echo ($member=='0')?'checked':'' ?> type="radio" class="radio"/>No</div>                    
                    <div id="user_opt1" style="display:<?php if($member=='1') echo "block"; else echo "none";?>">
                    	<div id="opt"><p>Seleziona membro</p>
						<?php 
							$member 		= 	new geneuser();
							$condition		=   "tab_gene_user.gene_in_life ='1' AND tab_gene_user.Trash='1'";
						    $mem 			= 	$member->familymember($condition); 
							$familynam 		= 	$member->family_name($seluseid);
							$family_nam		=	$familynam['gene_name'];
							$family_sur		=	$familynam['gene_surname'];
							//$email		=	$familynam['gene_email_personel_1'];
						?>
                        	<select id="member"readonly>
							<option value="null">Seleziona</option>
							<?php for($i=0;$i<count($mem);$i++)
							{
								$birthYear	=	$mem[$i]['gene_birthday'];
								$year       =   explode('-', $birthYear);
								$yyyy       =   $year[0];	

								?>
                                <option value="<?php echo $mem[$i]['gene_user_id'];?>" <?php if($mem[$i]['gene_user_id'] == $seluseid) echo "selected";?>><?php echo  getCleanString($mem[$i]['gene_name'].'  '.$mem[$i]['gene_surname'])." ".$yyyy;?></option>
                            <?php 
							} ?>
                            </select>
						</div>
						<div id="e_mail" style="display:none;"><p>email*</p><input type="text" id="email2" value="<?php echo $email;?>"/></div>
                    </div>
                    <div id="user_opt2">
                    	<div id="nam"><p>Nome*</p><input type="text" id="name" value="<?php echo getCleanString($name);?>"/></div>
                    	<div id="cog"><p>Cognome*</p><input type="text" id="surname" value="<?php echo getCleanString($surname);?>"/></div>
                    	<div id="emails"style="display:none;"><p>email*</p><input type="text" id="email" value="<?php echo $email;?>"/></div>
                    	<div id="tele"><p>Telefono</p><input type="text"id="phone" value="<?php echo $phone;?>"/></div>
                    </div>
                </div>
                <!-- Colonna di destra -->
                <div id="right_colom"> 
       
                    <div class="box" id="pubblicazione">
                        <div class="head"><span >Attivazione*</span></div>
                        <div class="center" id="active">
                            <p class="pub">Attivo: <span><input name="pubbl" type="radio" class="radio" value="1"<?php echo ($active=='1')?'checked':'' ?>/> Si <input name="pubbl" type="radio" class="radio" value="0"<?php echo ($active=='0')?'checked':'' ?>/> No </span></p>
                        </div>
						<input type="hidden" id="userid" value="<?php echo $user_id; ?>" />
						<input type="hidden" id="userpassword" value="<?php echo $password; ?>"/>
                   		<div class="foot"></div>
         			</div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
