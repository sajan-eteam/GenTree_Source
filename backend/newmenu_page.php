<?php
include "../includes/init.php";
include('session_check.php');
$currentpage	= 8; 
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
        <style type="text/css">
        	.pushMessageDiv1 label{vertical-align: top; margin-right: 10px;font-size: 12px}
        	.p-notification{color: green; font-size: 12px; margin-left: 5px}
        	.p_btn{vertical-align: super}
        	.pushMessageDiv1 textarea{width: 200px}
        </style>
    
  

		<div id="tabella_cont" class="table_main"  style="border-bottom: 1px solid #cfcfcf; padding-top: 4px;">
	      	<div id="tabella_head" class="table_head_main">
	            <div id="top_right">
	                <!--<div id="head_right">
	                      <div class="buttons">
	                            <div id="btn_notselect"><button  class="big"  onclick="location.href='insta_album_upload.php'">+ Aggiungi foto</button></div>
	                            <div id="btn_select"> <button class="big" id="deleteSelected" name="deleteSelected" onclick="return confirmDelete();"><span class="delete"></span></button></div>
	                      </div>
	                </div>-->
	                <h1>New Menu</h1>
	                <!--<form id="cont_search" method="get" onSubmit="javascript:doSearch();return false;">
	                    <button type="submit" id="lens" class="icon_lens"></button>
	                    <button type="reset" id="cancel" onclick="search_reset();" class="icon_cancel"></button>
	                    <label>
	                        <input id="search" class="search" type="text" value="<?php echo $_GET['search']; //$_POST['searchtitle']; ?>" onkeydown="search_check()" onblur="search_check()" placeholder="Cerca"/>
	                    </label>
	                </form>-->
	            </div>
	        </div>    
		</div>

		<div class="pushMessageDiv1" style="margin-top:4%; margin-left:16%; color:green;">
			<form id="pushMessageFormFamiglia" name="pushMessageFormFamiglia">	
				<label>Famiglia Boroli</label>	
				<textarea rows="5" name="pushMessage_Famiglia" id="pushMessage_Famiglia"></textarea>
				<input type="button" class="p_btn" name="submit" onclick="sendMessageToFamiglia();" value="Invia">
				<span class="p-notification" id="famigliaNotificationStatus"></span>			
			</form>   
		</div>
		<div class="pushMessageDiv1" style="margin-top:4%; margin-left:16%; color:green;">
			<form id="pushMessageFormInsta" name="pushMessageFormInsta">	
				<label>Instafamily</label>	
				<textarea rows="5" name="pushMessage_Insta" id="pushMessage_Insta"></textarea>
				<input type="button" class="p_btn" name="submit" onclick="sendMessageToInstaFamily();" value="Invia">
				<span class="p-notification" id="instaNotificationStatus"></span>			
			</form> 
		</div>
		

		<!--<div id="pushMessageDiv" style="margin-top:4%; margin-left:16%; color:green;">
			<form id="pushMessageForm" name="pushMessageForm">
			
			  <input type="text" name="pushMessage" id="pushMessage" class="search" placeholder="Type Message" required>
			  <input type="button" name="submit" onclick="sendMessage();" value="Send">
		    </form>
		</div>-->
	</div>
</div>		

<script type="text/javascript">
	/*$("document").ready(function(){
	  $(".js-ajax-php-json").submit(function(){
	    var data = {
	      "action": "test"
	    };
		$.ajax({
		    type: "POST",
		    url: 'submission.php',
		    data: {name: 'Wayne', age: 27},
		    success: function(data){
		        alert(data);
		    }
		});*/

    function sendMessageToFamiglia() {
    //alert("Inn");
    var pushMessage = document.getElementById('pushMessage_Famiglia').value;
    if(pushMessage!="")
    {
    	document.getElementById("famigliaNotificationStatus").style.color = "green";
    	document.getElementById("famigliaNotificationStatus").innerHTML = "Sending . . . .";
    }
     
    //alert("Value = "+pushMessage);
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	if(pushMessage!="")
            	{
                  //document.getElementById("famigliaNotificationStatus").style.display = "block";
                  document.getElementById("famigliaNotificationStatus").style.color = "green";
                  document.getElementById("famigliaNotificationStatus").innerHTML = "Push Notification Sent Successfully!";
                  document.getElementById("pushMessage_Famiglia").value = "";
            	}
            	else
            	{
            		document.getElementById("famigliaNotificationStatus").style.color = "red";
            		document.getElementById("famigliaNotificationStatus").innerHTML = "Please enter message to send!";
            	}
            }
        };
        xmlhttp.open("GET","PushNotificationIOS.php?type=0&isMessage="+pushMessage,true);
        xmlhttp.send();
    
}


    function sendMessageToInstaFamily() 
    {
	    var pushMessage = document.getElementById('pushMessage_Insta').value;
	    if(pushMessage!="")
	    {
	    	document.getElementById("instaNotificationStatus").style.color = "green";
	    	document.getElementById("instaNotificationStatus").innerHTML = "Sending . . . .";
	    }
     
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	if(pushMessage!="")
            	{
                  //document.getElementById("famigliaNotificationStatus").style.display = "block";
                  document.getElementById("instaNotificationStatus").style.color = "green";
                  document.getElementById("instaNotificationStatus").innerHTML = "Push Notification Sent Successfully!";
                  document.getElementById("pushMessage_Insta").value = "";
            	}
            	else
            	{
            		document.getElementById("instaNotificationStatus").style.color = "red";
            		document.getElementById("instaNotificationStatus").innerHTML = "Please enter message to send!";
            	}
            }
        };

        xmlhttp.open("GET","PushNotificationIOS.php?type=1&isMessage="+pushMessage,true);
        xmlhttp.send();
    
    }
</script>

</body>
</html>         