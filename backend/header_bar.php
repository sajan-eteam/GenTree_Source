<?php
include_once "../includes/init.php";
$objUser	 	= 	new user();
if(isset($_SESSION['admin_user_id']))
{
	$user_details	=	$objUser->getUser($_SESSION['admin_user_id']);
}
?>
<div id="header"> 
	<div id="logo"></div>  
	<ul id="nav">
		<li id="menu-logout"><a>Ciao <?php echo $user_details['sys_name']." ".$user_details['sys_surname']; ?></a>
			<ul>
				<!--<li><a href="myaccount.php">Modifica profilo</a></li>-->
				<li><a href="logout.php">Esci</a></li>
			</ul>
		</li>
	</ul>        
</div>
<!----Messages---->
<div id="messages">
	<div id="error" style="display:none;"></div><!-- When there is an error use this div to show the message in this div -->
	<div id="msg" style="display:none;"></div>  <!-- When there is notify message use this div to show it-->
</div>
<!----end Messages---->