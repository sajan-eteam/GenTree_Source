<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

<link rel="stylesheet" href="css/login.css">

<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="js/login.js"></script>

<title>Famiglia Boroli</title>
</head>

<body>
<div id="container">
	<div id="box" class="login_box">
    	<!--by default the div messages must be hidden-->
    	<div id="message" style="display:none;" class="error" onclick="hide_message(this)">Email non valida</div>
    	<h1>Famiglia Boroli</h1>
        <p style="font-size:14px;">Inserisci la tua email e riceverai la password direttamente nella tua casella di posta</p>
        <!--class="error" is to add to field reguarding the error -->
   	  	<input id="Email" type="text" value="Email" onfocus="onfocus_input(this,this.id)" onblur="onblur_input(this,this.id)"/>
      	<button id="submitButtonId">Invia richiesta</button>
		<!-- type="submit" onclick="window.location='forgot_password_message.php' -->
  	</div>
</div>
</body>
<script type="text/javascript">
    $("#submitButtonId").click(function() 
	{
		var error_flag	=	0;
		var Email		=	$('#Email').val();
        
		if(Email.trim() == "" || Email.trim() == "Email")
		{
			$("#Email").addClass("error");
			error_flag=1;
		}		

		if(error_flag == 0)	
		{
			$.ajax({
				type: "POST",
				url: 'forgot_password_action.php',
				data: 'e_mail='+Email,
				success: function (data) 
				{
					if(data == 1)
					{
						document.location = 'forgot_password_message.php';	
					}	
					else
					{
						$("#Email").addClass("error");
						$("#message").html('Indirizzo email non valido');
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
