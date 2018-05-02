<?php
include('session_check.php');
include "../includes/init.php";
$objUser	 	= 	new user();
$currentpage	= 16;
if(isset($_SESSION['admin_user_id']))
{
	$user_details	=	$objUser->getUser($_SESSION['admin_user_id']);
}
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
                            <button class="big" id="submitButtonId">salva</button >
                        </div>
                    </div>
                    <h1>Modifica profilo</h1>
                </div>
            </div>
			<div id="message" class="error" style="display:none;"></div>
            <!-------------------->
            <div id="tabella">
                <div id="middle_colom">
                    <div id="username_div"><p>Username*</p><input type="text" id="userName" value="<?php echo $user_details['sys_user_name']; ?>"/></div><!------When there is an error please ADD class="error" to the related divs----->
                    <div id="password_div"><p>Password*</p><input type="text" id="user_password" value="<?php echo $user_details['sys_password']; ?>"/></div>
                    <div id="email_div"><p>E-mail*</p><input type="text" id="user_email" value="<?php echo $user_details['sys_email']; ?>"/></div>                           
                </div>

                <!-- Colonna di destra --->
                
                <div id="right_colom"> 
                	
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<script type="text/javascript">
$(document).ready(function()
{
	$("#userName").focus();
});	
    $("#submitButtonId").click(function() 
	{
		var error_flag	=	0;
		var userName		=	$('#userName').val();
		var user_password	=	$('#user_password').val();
		var user_email		=	$('#user_email').val();
        
		if(userName.trim() == "" || userName.trim() == "UserName")
		{
			$("#username_div").addClass("error");
			error_flag=1;
		}
		
		if(user_password.trim() == "" || user_password.trim() == "UserPassword")
		{
			$("#password_div").addClass("error");
			error_flag=1;
		}	
		
		if(user_email.trim() == "" || user_email.trim() == "user_email")
		{
			$("#email_div").addClass("error");
			error_flag=1;
		}
		
		if(error_flag == 0)	
		{
			$.ajax({
				type: "POST",
				url: 'update_user_details.php',
				data: 'user_name='+userName+'&user_password='+user_password+'&user_email='+user_email,
				success: function (data) {
					if(data == 1)
					{
						document.location = 'logout.php';	
					}	
					else
					{
						$("#userName").addClass("error");
						$("#user_password").addClass("error");
						$("#user_email").addClass("error");
						$("#message").html('Username o Password non valida');
						$("#message").show('');
					}
				}
			});
		}
		else
			return false;
		
    });

// binding enter ket press to submit the form //
$(document).keypress(function(event) 
{
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13') {
        $("#submitButtonId").click();    
    }
});
</script>
</html>
