<?php
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
	$("#user_opt1").hide();
	$("#user_opt2").hide();
	family_user = function(){
		$("#user_opt1").show();
		$("#user_opt2").hide();
    } 
	external_user = function(){
		$("#user_opt1").hide();
		$("#user_opt2").show();
    }
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
                            <button class="big">salva</button >
                            <button class="big">elimina</button >
                        </div>
                    </div>
                    <h1>Membro della famiglia</h1>
                </div>
            </div>
            <!-------------------->
            <div id="tabella">
                <div id="middle_colom">
                    <div class="error"><p>Username*</p><input type="text"/></div><!------When there is an error please ADD class="error" to the related divs----->
                    <div><p>Password*</p><input type="text"/></div>
                    <div><p>Membro dell'albero*</p><input onclick="family_user()" name="alive" value="yes" type="radio" class="radio"/>Sì &nbsp;&nbsp;
                    	<input onclick="external_user()" name="alive" value="no" type="radio" class="radio"/>No</div>                    
                    <div id="user_opt1">
                    	<div><p>Seleziona membro</p>
                        	<select>
                            	<option>Seleziona</option>
                                <option>Nome Cognome</option>
                                <option>Nome Cognome</option>
                                <option>Nome Cognome</option>
                                <option>Nome Cognome</option>
                            </select>
						</div>
                    </div>
                    <div id="user_opt2">
                    	<div><p>Nome*</p><input type="text"/></div>
                    	<div><p>Cognome*</p><input type="text"/></div>
                    	<div><p>email</p><input type="text"/></div>
                    	<div><p>Telefono</p><input type="text"/></div>
                    </div>
                </div>

                <!-- Colonna di destra --->
                
                <div id="right_colom"> 
                	
                    <div class="box" id="pubblicazione">
                        <div class="head"><span >Attivazione*</span></div>
                        <div class="center">
                            <p class="pub">Attivo: <span><input name="pubbl" type="radio" class="radio"/> Sì <input name="pubbl" type="radio" class="radio"/> No </span></p>
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
