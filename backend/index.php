<?php
include('../includes/init.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

<link rel="stylesheet" href="css/login.css">

<script src="js/jquery.js"></script>
<script src="js/login.js"></script>

<title>Famiglia Boroli</title>
</head>

<body>
<div id="container"> 
	<div id="box" class="login_box">
		
    	<!--by default the div messages must be hidden-->
    	<div id="message" class="error" style="display:none;">Password non valida</div>
    	<h1>Famiglia Boroli</h1>
        <!--class="error" is to add to field reguarding the error  class="error" onclick="window.location='tree.html'"  -->
   	  	<input id="UserName" type="text" value="User Name" onfocus="onfocus_input(this,this.value)" onblur="onblur_input(this,'User Name')"/>
        <input id="UserPassword" type="text" value="User Password" onfocus="onfocus_input(this,this.value); this.type = 'password';" onblur="if(this.value==''){this.type = 'text';}; onblur_input(this,'User Password'); "/>
      	<button id="submitButtonId">Accedi</button>
        <p><a href="forgot_password.php">Hai dimenticato la password?</a></p>
  	</div>
</div>
</body>
<script type="text/javascript">

    $("#submitButtonId").click(function() 
	{
		var error_flag	=	0;
		var userName		=	$('#UserName').val();
		var user_password	=	$('#UserPassword').val();
        
		if(userName.trim() == "" || userName.trim() == "User Name")
		{
			$("#UserName").addClass("error");
			error_flag=1;
		}
		else
		{
			$("#UserName").removeClass("error");
		}
		
		if(user_password.trim() == "" || user_password.trim() == "User Password")
		{
			$("#UserPassword").addClass("error");
			error_flag=1;
		}	
		else
		{
			$("#UserPassword").removeClass("error");
		}
		
		if(error_flag == 0)	
		{
			$.ajax({
				type: "POST",
				url: 'login_check.php',
				data: 'user_name='+userName+'&user_password='+user_password,
				success: function (data) {
					if(data == 1)
					{
						document.location = 'tree.php';	
					}	
					else
					{
						$("#UserName").addClass("error");
						$("#UserPassword").addClass("error");
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
