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
var requestUrl = window.location.search; 
	if(requestUrl !='') {

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
	}
	else if(error.length > 0)
	{
		var error_mesg = '';
		
		if(error == 'errors')
			error_mesg		=	'Impossibile aggiungere dati';
		else if(error =='4')
			error_mesg		=	'Utente già esistente';
		else if(error =='5')
			error_mesg		=	'Username già esistente';
		else if(error =='6')
			error_mesg		=	'Email già esistente';
		else if(error =='7')
			error_mesg		=	'Email già esistente';
		else if(error == '1' || error == '2' || error == '3')
			error_mesg		=	'Impossibile aggiungere dati';
			
		$("#error").html(error_mesg);
		$("#error").show();
	}	
}


	$("#user_opt1").hide();
	$("#user_opt2").hide();
	family_user = function(){
		$("#user_opt1").show();
		$("#user_opt2").hide();
		$('#member').prop('selectedIndex',0);		
    } 
	external_user = function(){
		$("#user_opt1").hide();
		$("#user_opt2").show();
		$('#user_opt2').find('input:text').val('');
    }
});
</script>

<script>
	$(document).ready(function(){
		$("#uname").focus();
		$("#salva").click(function(){
					$user_name			=	$('#uname').val();					
					$password			=	$('#pword').val();
					$confirmpassword    =	$('#cfrmpword').val();				
					$is_a_member		=	$('input:radio[name=alive]:checked').val();					
					$member_name		=	$("#member option:selected").val();	
					$app_user_name		=	$('#name').val();					
					$app_user_surname	=	$('#surname').val();					
					$user_email			=	$('#email').val();					
					$phone_num			=	$('#phone').val();
					$person_email		=	$('#useremail').val();
					var mobRegex        =  	new RegExp(/^[\+\0-9]{10,16}$/);
					$publish			=	$('input:radio[name=pubbl]:checked').val();
					var emailRegex 		=   new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
					var valid 			= 	emailRegex.test($user_email);
					var valids			=	emailRegex.test($person_email);
					var validnum        =   mobRegex.test($phone_num);
					var flag 			= 	0;
					if($user_name==''){
						flag = 1;
						$("#usr").addClass('error');
					}
					else{
						//flag = 0;
						$("#usr").removeClass('error');
					}
					if($password=='')
					{
						flag = 1;
						$("#pwd").addClass('error');
					}
					else if($password.length < 6){
						flag = 1;
						$("#pwd").addClass('error');
						var message  = 'La lunghezza della password deve essere di 6 o più caratteri';
		                $("#error").html(message);
						$("#error").show();
						//alert('La lunghezza della password deve essere di 6 o più caratteri');
					}
					if($password){
						if($password!=$confirmpassword){
						   flag = 1;
						   $("#conpwd").addClass('error');
						}
						else{
							//flag = 0;
						   $("#error").hide();
						   $("#pwd").removeClass('error');
						   $("#conpwd").removeClass('error');
						}
				    }
					if($is_a_member==null){
						flag = 1;
						$("#mem").addClass('error');
					}
					else{
						//flag = 0;
						$("#mem").removeClass('error');
					}
//member is si
					if($is_a_member==1){
						if($member_name=='null'){
							flag = 1;
							//alert("Please Select a value");
                            $("#sel").addClass('error');
						}
						else{
                           $("#sel").removeClass('error');
						}
						if($person_email==''){
							flag = 1;
							$("#mail").addClass('error');
						}
                        else{
						   $("#mail").removeClass('error');
						}
						if(!valids){
							flag = 1;
							$("#mail").addClass('error');
						}
						else{
							$("#mail").removeClass('error');
						}
					}
//member is no
				if($is_a_member==0) { 
					if($app_user_name==''){
						flag = 1;
						$("#nam").addClass('error');
					}
					else{
						//flag = 0;
						$("#nam").removeClass('error');
					}
					if($app_user_surname==''){
						flag = 1;
						$("#cog").addClass('error');
					}
					else{
						//flag = 0;
						$("#cog").removeClass('error');
					}
					if($user_email==''){
                        flag = 1;
						$('#emails').addClass('error');	
						
					}
					else{
                        $('#emails').removeClass('error');
					}
					if(!valid){
						flag = 1;
						$('#emails').addClass('error');	
				    }
					else{
					    $('#emails').removeClass('error');
					}
                    if($phone_num){
							if(!validnum){
								flag = 1;
								$('#tele').addClass('error');	
							}
							else{
								//flag = 0;
								$('#tele').removeClass('error');
							}
						}
					}
//end of member no
					if($publish==null){
						flag = 1;
						$("#active").addClass('error');
					}
					else{
						//flag = 0;
						$("#active").removeClass('error');
					}
					if(flag  == 0){
						$.ajax({
								type: 'POST',
								url: 'save_user_details.php', 
								data:'user_name='+$user_name+'&user_password='+$password+'&confirmpassword='+$confirmpassword+'&member='+$is_a_member+
									 '&member_name='+$member_name+'&app_user_name='+$app_user_name+'&app_user_surname='+$app_user_surname+
									 '&user_email='+$user_email+'&phone_num='+$phone_num+'&person_email='+$person_email+'&status='+$publish,
									  success: function(data) {
											//alert(data);
											var success_url	= "user_update_detail.php?user_id="+data+"&success=success";	
										    success_url 	= success_url.replace(/\s+/g, '');
										    $("#msg").hide();	
										    $("#error").hide();	

										    if(data == -1) {
											  var message  = 'Impossibile aggiornare I dettagli';
											  $("#error").html(message);
											  $("#error").show();											 
											}
											else if(data == -2) {                                              
                                              var message  = 'Utente oppure Username oppure Email già esistente';
											  $("#error").html(message);
											  $("#error").show();					  
											}
											else if(data > 0) {  
												window.location = success_url;													
											}		
										}
								});
					}
			});
	});
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
		?>
        <!----end left part---->
        <div id="tabella_cont" class="table_main">
            <div id="tabella_head" class="table_head_main">
                <div id="top_right">
                    <div id="head_right">
                        <div class="buttons">
                        	<button class="big" onclick="location.href='users.php'"><img src="img/buttons/back.gif"/></button >
                            <button class="big" id="salva">salva</button >
                            <!--<button class="big">elimina</button >-->
                        </div>
                    </div>
                    <h1>Membro della famiglia</h1>
                </div>
            </div>
            <!-- ------------------>
            <div id="tabella">
                <div id="middle_colom">
                    <div id="usr"><p>Username*</p><input type="text" id="uname"/></div><!------When there is an error please ADD class="error" to the related divs--- -->
                    <div id="pwd"><p>Password*</p><input type="password" id="pword"/></div>
                    <div id="conpwd"><p>Confirm Password*</p><input type="password" id="cfrmpword"/></div>
                    <div id="mem"><p>Membro dell'albero*</p><input onclick="family_user()" name="alive" value="1" type="radio" class="radio"/>Sì &nbsp;&nbsp;
                    	<input onclick="external_user()" name="alive" value="0" type="radio" class="radio"/>No</div>                    
                    <div id="user_opt1">
                    	<div id="sel"><p>Seleziona membro</p>
						<?php 
							  $member = new geneuser(); 
						      $condition	= "tab_gene_user.gene_in_life ='1' AND tab_gene_user.Trash='1' ";
						      $mem = $member->familymember($condition); 
							  ?>
                        	<select id="member">							   
                            	<option value="null">Seleziona</option>
								<?php 
								for($i=0;$i<count($mem);$i++) {
									$birthYear	=	$mem[$i]['gene_birthday'];
									$year       =   explode('-', $birthYear);
									$yyyy       =   $year[0];		
								?>
	                                <option value="<?php echo $mem[$i]['gene_user_id'];?>"><?php echo $mem[$i]['gene_name'].'  '.$mem[$i]['gene_surname']." ".$yyyy;?>
	                                </option>
                                <?php } ?>
                            </select>
						</div>
                        <div id="mail"><p>email*</p><input type="text" id="useremail"/></div>
                    </div>
                    <div id="user_opt2">
                    	<div id="nam"><p>Nome*</p><input type="text" id="name"/></div>
                    	<div id="cog"><p>Cognome*</p><input type="text" id="surname"/></div>
                    	<div id="emails"><p>email*</p><input type="text" id="email"/></div>
                    	<div id="tele"><p>Telefono</p><input type="text"id="phone"/></div>
                    </div>
                </div>

                <!-- Colonna di destra - -->
                <div id="right_colom"> 
       
                    <div class="box" id="pubblicazione">
                        <div class="head"><span >Attivazione*</span></div>
                        <div class="center" id="active">
                            <p class="pub">Attivo: <span><input name="pubbl" type="radio" class="radio" value="1"/> Sì <input name="pubbl" type="radio" class="radio" value="0"/> No </span></p>
                        </div>
                   		<div class="foot"></div>
         			</div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
