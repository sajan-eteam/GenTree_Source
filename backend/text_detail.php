<?php
include "../includes/init.php";
include('session_check.php');
$currentpage	= 3; 
$menu_id 		= 2;
if(isset($_GET['text_id']))
{
	$menu_id			=	$_GET['text_id'];	
	switch($_GET['text_id']) 
	{
		case 1: $menu_id = 1;
		break;
		case 2: $menu_id = 2;
		break;	
		case 3: $menu_id = 3;
		break;
		case 4: $menu_id = 4;
		break;
		
	}
}
else
{
	$menu_id	=	'2';
}
$objtexti		=	new	testi();
$objtext        =	$objtexti->getTestidata($menu_id);
$title_data		=   $objtext[0]['text_title'];
$title_desc		=	$objtext[0]['text_desc'];
$txt_id			=	$objtext[0]['text_id'];

if($txt_id)
{
	$mode = "edit";
}
else
{
	$mode = "add";
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
<link rel="stylesheet" href="css/text_detail.css">

<script src="js/jquery.js"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/main.js"></script>
<script src="library/tinymce/tinymce.min.js"></script>
<script>

	tinymce.init({
		selector: "textarea#desc",
		menubar : false,
		language : 'it',
		resize: false,
		height : 250,
		plugins : "paste",
	 // mode : "textarea",
     //theme : "advanced",
      force_br_newlines :true,
      force_p_newlines : false,
      forced_root_block : '',
		style_formats: [
			{title: 'Grassetto', inline: 'b'},
			{title: 'Corsivo', inline: 'i'},
		],
		 plugins: [
            'advlist autolink link lists charmap preview',
            'searchreplace wordcount code media',
           'save textcolor'
       ],

       theme_advanced_buttons3_add : "pastetext,pasteword,selectall",
        paste_auto_cleanup_on_paste : true,
        paste_preprocess : function(pl, o) {
            // Content string containing the HTML from the clipboard
            alert(o.content);
            o.content = "-: CLEANED :-\n" + o.content;
        },
        paste_postprocess : function(pl, o) {
            // Content DOM node containing the DOM structure of the clipboard
            alert(o.node.innerHTML);
            o.node.innerHTML = o.node.innerHTML + "\n-: CLEANED :-";
        }
       
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
				error     =   'Unable to update data';
			
			
			$("#error").html(error);
			$("#error").show();
		}
	}

	$("#salva").click(function(){
      
      var mode			 	=  $('#mode').val();
	  var txt_id		 	=  $('#text_id').val();
	  var text_id        	=  $('#txt_id').val();
	 
      var title			 	=	$('#articleTitle').val();
      var emailRegex 		= 	new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
      var validemail 		=   emailRegex.test(title);
	  if(txt_id!='4'){
	  var description	 =	tinymce.get('desc').getContent();
	  }
	   
	  var error_flag	 =  0;

      

       if(title == '')	
		{
		    
          	$("#title").addClass('error');
			error_flag	=	1;

		}
		else
		{
			 $("#title").removeClass('error');
		}
		if(txt_id == '4')
		{
			if(!validemail){
				$("#title").addClass('error');
				error_flag	=	1;
			}
			else
			{
			  	$("#title").removeClass('error');
			}
		}

	    if(txt_id!='4'){
		if(description == '')	
		{
		  // alert("Please enter Your Description");
           $("#description").addClass('error');
		   error_flag	=	1;
		}
		else
		{
		  $("#description").removeClass('error');
		}
	   }
	    if(error_flag == 0)
		{
			
			$.ajax({
					type: 'POST',
					url: 'save_testi_details.php', 
					data:'mode='+mode+'&txt_id='+txt_id+'&textid='+text_id+'&title='+title+'&desc='+encodeURIComponent(description),

						success: function(data) 
						{
							
							if(data == 'error')
							{
                             window.location = "text_detail.php?text_id="+txt_id+"&&error=error";
								
							}
						   
							if(data == 'success')
							{
							 window.location = "text_detail.php?text_id="+text_id+"&&success=success";
                             
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
                        	<?php /* <button class="big" onclick="location.href='users.php'"><img src="img/buttons/back.gif"/></button > */ ?>
                            <button class="big" id="salva">salva</button >
                        </div>
                    </div><?php if($menu_id != 4) {?>
                    <h1>Testo di benvenuto</h1><?php } 
                    else {?>
                     <h1>Rubrica Email </h1>
                    <?php } ?>
                </div>
            </div>
            <!-------------------->
            <div id="tabella">
                <div id="middle_colom">
                	<?php if($menu_id == 4) {?>
                   <div class="title" id="title">
<input id="articleTitle" name="title" type="text" placeholder="Inserire qui il titolo" size="45" value="<?php  echo $title_desc; ?>"/>
                    </div>
                    <?php }else{ ?>
                    <div class="title" id="title">
<input id="articleTitle" name="title" type="text" placeholder="Inserire qui il titolo" size="45" value="<?php  echo html_entity_decode($title_data, ENT_COMPAT, "UTF-8");?>"/>
                    </div>
                    <div  class="box">
                        <div class="head"><span>Descrizione*</span></div>
                        <div class="center" id="description">
                            <!--<form onsubmit='umce();ut(); return false;'> -->
                              <textarea id="desc" name="desc"><?php echo 
							  html_entity_decode(stripslashes($title_desc), ENT_COMPAT, "UTF-8");?></textarea>
                           <!-- </form>-->
                        </div>
         			</div><?php } ?>

                <!-- Colonna di destra --->
                
                <div id="right_colom"> 
                	<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>"/>
					<input  type="hidden" id="text_id" name="text_id" value="<?php echo $txt_id;?>"/>
					<input  type="hidden" id="txt_id" name="txt_id" value="<?php echo $menu_id;?>"/>
                    <!--<div class="box" id="pubblicazione">
                        <div class="head"><span >Attivazione*</span></div>
                        <div class="center">
                            <p class="pub">Attivo: <span><input name="pubbl" type="radio" class="radio"/> Sì <input name="pubbl" type="radio" class="radio"/> No </span></p>
                        </div>
                   		<div class="foot"></div>
         			</div>-->
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
