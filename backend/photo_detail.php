<?php
include "../includes/init.php";
include('session_check.php');
$gallery            =  $_SESSION['gallery_id'];
$filenam            =  $_SESSION['file'];
$image_id           =  $_GET['image_id'];

$option             =  '';
$dropdown           =  '';
$tagging            =  $_POST['tag'];

//added for menu navigation
$currentpage	= 2; 
$menu_id 		= 1;
if(isset($gallery ))
{
	$id_gallery	=	$gallery;
	switch($gallery) 
	{
		case 1: $menu_id = 1;
		break;
		case 2: $menu_id = 2;
		break;	
		case 3: $menu_id = 3;
		break;
		case 4: $menu_id = 4;
		break;
		case 5: $menu_id = 5;
		break;
		case 6: $menu_id = 6;
		break;		
		case 7: $menu_id = 7;
		break;
		case 8: $menu_id = 8;
		break;
	}
}
//added for menu navigation

$objimage   =  new images();
$image		=  $objimage->allImages();
$objtaging  =  new tagging();
/*for($i=0;$i<count($image);$i++)
{
  $imageID = $image[$i]['id_image']; 
  for($j=0;$j<count($image);$j++)
  {
	  //echo $userid;exit;
  }
}*/
$image		=  $objtaging->getimageuserid($imageID);
$userid  = $image['gene_user_id'];
if($tagging == '1')
{	
	//$condition			=	$userid;
	$tagobj             =   new geneuser();
	$family_members		=	$tagobj->user_tag();
	//echo count($family_members);exit;
	for($i=0;$i<count($family_members);$i++)
	{
    $birthyear          =   $family_members[$i]['gene_birthday'];
	$year               =   explode('-',$birthyear);
	$yyyy               =   $year[0];
	$option .='<li value='.$family_members[$i]['gene_user_id'].'>'.$family_members[$i]['gene_name']." ".$family_members[$i]['gene_surname']." ".$yyyy.'</li>';
	}
	$dropdown .= '<div class="dropdown"><input type="text"/><ul>'.$option.'</ul></div>';
	echo $dropdown;exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>Albero Genealogico</title>
<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="css/structure.css">
<link rel="stylesheet" href="css/menu.css">
<link rel="stylesheet" href="css/photo_detail.css">

<script src="js/jquery.js"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/main.js" charset="utf-8"></script>
<script src="js/tagging.js" charset="utf-8"></script>
<script src="js/dropdown.js" charset="utf-8"></script>
<script src="js/phpjs.js" charset="utf-8"></script>
<script charset="utf-8" >
$(document).ready(function(){
			$("#salva").click(function(){

					var boxdetail = [];
					var error_flag_tagging = 0;
					var error_flag_foto	=	0;
					$("div[id^='box']").each(function()
					{
						var idVal	=	this.id;
						var myvar 	= 	idVal.split('box');						
						var parentOffset2 = $("#"+this.id).position();
						var ids = $('[id="'+this.id+'"]');
  						if(ids.length>1 && ids[0]==this)
    					alert("Duplicate tag exist");
					
						var value = $("#input"+myvar[1]).find("#user_id_selected").text();
						
					    
						if ($(parentOffset2).exists())
						{   
							 var  fotowidth    = $("#taggable").width();	
							 if(fotowidth == '' || fotowidth == 0) {
							 		error_flag_foto = 1;
							 		error_msg	=	'La larghezza della foto non può essere di 0 pixel';	
									
							 }						 
							 var  fotoheight   = $("#taggable").height();	
							 if(fotoheight == '' || fotoheight == 0) {
							 		error_flag_foto = 1;
							 		error_msg	=	'L’altezza della foto non può essere di 0 pixel';
									
							 }						  
                             var  actualwidth  = $("#actualwidth").val();
                             var actualheight  = $("#actualheight").val();

							 var x1 = parentOffset2.left;
							 if(x1 == '' || x1 < 1) {
							 		x1 = 0;							 				
							 }
							 var y1 = parentOffset2.top;
							 if(y1 == '' || y1 < 1) {
							 		y1 = 0;							 				
							 }
							 var boxw=$("#"+this.id).width();
							  if(boxw == '' || boxw == 0) {
							 		error_flag_foto = 1; 
							 		error_msg	='La larghezza del tag non può essere di 0 pixel';
									
							 }
							 var boxh=$("#"+this.id).height();
							 if(boxh == '' || boxh == 0) {
							 		error_flag_foto = 1;
							 		error_msg	="L’altezza del tag non può essere di 0 pixel";
									
									
							 }
							 boxdetail.push({"image_width":fotowidth,"image_height":fotoheight,"x":x1,"y":y1,"boxw":boxw,"boxh":boxh,"user":value,"actualimagewidth":actualwidth,"actualimageheight":actualheight});
						}			
						
					});		
					
					 
						
					 $galleryid		=   $('#galid').val();
					 
					 $title			=	$('#photoTitle').val();
					
					 $img			=   $("#taggable");
                     $src			=   $img.attr("src");
				
                     $desc			=   $("#smallDesc").val();
					 
					 $status		=   $('input:radio[name=pubbl]:checked').val();
					 
			         $year			=	$('#yy').val();
					 $month			=	$('#mm').val();
					 $day		    =	$('#dd').val();

					 //$imgdate 	    =	$day+'-'+$month+'-'+$year;
					 $imgdate 	    =	$year+'-'+$month+'-'+$day;				 
					 $time 			=	$('#time').val();
					 $boxdetail     =   JSON.stringify(boxdetail);
					 
			         for(var i=0; i < boxdetail.length; i++)
					 {
						if(boxdetail[i].user == '')
						{	
							error_flag_tagging	=	1;
						}						
					 }
                     
					 var error_flag	=	0;	


					   if($title  == '' )
					{
						$("#title").addClass('error');
						$("#error").html("Aggiungere un titolo alla foto");
						$("#error").show();
						error_flag	=	1;
					}
					else	
				    {
                        $("#title").removeClass('error');
                        $("#error").hide();

				    }
					
					   if($status ==null)
				    { 
                       
						$("#status").addClass('error');
						error_flag	=	1;
				    }
					else
				    {
                       $("#status").removeClass('error');
					}
					
					if($year  == '' || $month  == '' || $day == '')
				    { 
                     
						$("#data").addClass('error');
						error_flag	=	1;
				    }
					else
					{

						$("#data").removeClass('error');
					}

					if($src == '' || $src == null || $src == undefined)
					{
						$("#img_cont").addClass('error');
						 error_flag	=	1;
					}
					else
					{
						$("#img_cont").removeClass('error');
					}
						

                   if(error_flag ==	0 && error_flag_tagging == 0 && error_flag_foto == 0)
					{

                   	 	$.ajax({
									type: 'POST',
									url: 'save_image_details.php', 
									data:'galleryid='+$galleryid+'&title='+$title+'&image='+$src+'&desc='+$desc+'&status='+$status+'&imagedat='+$imgdate+'&time='+$time+'&boxdetail='+$boxdetail,

									success: function(data) 
									{									 
									   //alert(data);
										if(data =='success')
										{
                                           location.href="photo.php?id_gallery="+$galleryid+"&success=success";
										}
										else
										{
											alert('Impossibile aggiungere dettagli all’immagine');
										}
										
									}


						});
					}
					if(error_flag	==	0 && error_flag_foto != 0) {

						alert(error_msg);
					}
					if(error_flag_tagging	!=	0)
					{
						alert('Taggatura non competa');
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
                        	<button class="big" onclick="location.href='photo.php'"><img src="img/buttons/back.gif"/></button >
                            <button class="big" id="salva">salva</button >
                            <button class="big" onclick="location.href='photo.php'">Elimina</button >
                        </div>
                    </div>
                    <h1>Dettaglio foto</h1>
                </div>
            </div>
            <!-------------------->
			
            <div id="tabella">
                <div id="middle_colom">
                	<div class="title" id="title">
                    	<input id="photoTitle" name="title" type="text" value="" size="45"  class="error" placeholder="Titolo della foto" onclick="this.placeholder =''" onblur="this.placeholder = 'Titolo della foto'"/>
                    </div>
                    <div class="box">
                        <div class="head"><span></span></div>
                        <div class="center">
                        
                          <div id="img_cont"><?php 
							
							 $image_new  = $image_name['image_src'];
							 
                             if($image_id) 
							 {   
								
								$new_image  = $image_new;
							 }
							 else
							 {
								$new_image = $filenam;
							 }
							 list($width,$height) = getimagesize('../upload/'.$new_image);
							 //echo "width: " . $width . "<br />";
							// echo "height: " .  $height;
						    ?><img id="taggable" src="../upload/<?php echo $new_image ;?>" style="width:100%" />
                          </div>
                        </div>
                   		<div class="foot"></div>
         			</div>
                    <div id="description" class="box">
                        <div class="head"><span>Descrizione</span>
						</div>
                        <div class="center">
                        <table>
                            <tr>
                                <td>
                                    <textarea id="smallDesc" name="smallDesc" class="error"></textarea>
                                </td>
                            </tr>
                        </table>
                        </div>
                        <div class="foot"></div>
                    </div>
                </div>
                
                <!-- Colonna di destra -->
                
                <div id="right_colom"> 
                	
                    <div class="box" id="pubblicazione">
                        <div class="head"><span >Pubblicazione*</span></div>
                        <div class="center" id="status">
                            <p class="pub">Pubblica:<span><input name="pubbl" type="radio" class="radio" value="1"/> Si <input name="pubbl" type="radio" class="radio" value="0"/> No </span></p>
                        </div>
                   		<div class="foot"></div>
         			</div>
                    
                    <div class="box" id="data">
                        <div class="head"><span >Data della foto*</span></div>
                        <div class="center">
                            <div>
                            	<p>anno:</p>
                                <select id="yy">
                                	<option value="">Seleziona</option>
									<?php 
									$current_year	=	date("Y");	
									for($i=1850;$i<=$current_year;$i++)
							       {?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                   
									<?php }?>
                                </select>
                            </div>
                            <div>
                            	<p>Mese: </p>
                                <select id="mm">
                                 <option value="">Seleziona</option>
                                  <?php   $months = array(1 => 'Gennaio', 2 => 'Febbraio', 3 => 'Marzo', 4 => 'Aprile', 5 => 'Maggio', 6 => 'Giugno', 7 => 'Luglio', 8 => 'Agosto', 9 => 'Settembre', 10 => 'Ottobre', 11 => 'Novembre', 12 => 'Dicembre');
                                  foreach ($months as $num => $name) {?>
                                 <option value="<?php echo $num ;?>"><?php echo $name;?></option>;
                                 <?php } ?>
                                </select>
                            </div>
                            <div>
                            	<p>Giorno: </p>
                                <select id="dd">
                                	<option value="">Seleziona</option>
                                	<?php for($i=1;$i<=31;$i++)
							       {?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                   
									<?php }?>                       
                                </select>
                        	</div>
                        	<div>
                            	<p>Ora: </p>
                        		<select id='time'>
                        		<option value="">Seleziona</option>
								<?php for($hours=0; $hours<24; $hours++) // the interval for hours is '1'
    								  for($mins=0; $mins<60; $mins+=1) // the interval for mins is '30'
        							  echo '<option>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                       				  .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';?>
								</select>
							</div>
                        </div>
                   		<div class="foot"></div>
         			</div>
                    <!-- hidden fields -->
					
                    <input type="hidden" id="galid"  value="<?php echo $gallery;?>"/>
					<input type="hidden" id="box" value=""/>
					<input type="hidden" id="actualwidth" value="<?php echo $width;?>"/>
                    <input type="hidden" id="actualheight" value="<?php echo $height;?>"/>
					<input type="hidden" id="use"          value="<?php echo $userid;?>"/>
					<div class="box" >
                        <div class="head"><span >Tags</span></div>
                        <div class="center">
                            <div id="tags"></div>
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
