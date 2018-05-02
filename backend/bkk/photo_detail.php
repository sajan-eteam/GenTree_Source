<?php
include "../includes/init.php";
include('session_check.php');
$gallery            =  $_SESSION['gallery_id'];
$filenam            =  $_SESSION['file'];
$image_id           =  $_GET['image_id'];

$option             =  '';
$dropdown           =  '';
$tagging            =  $_POST['tag'];
//$objimage   =  new images();
//$image		=  $objimage->allImages();
//$objtaging  =  new tagging();
//for($i=0;$i<count($image);$i++)
//{
  //$imageID = $image[$i]['id_image']; 
  //for($j=0;$j<count($image);$j++)
  //{
	  //echo $userid;exit;
  //}
//}
//$image		=  $objtaging->getimageuserid($imageID);
//$userid  = $image['gene_user_id'];
if($tagging == '1')
{	
	//$condition			=	$userid;
	$tagobj             =   new geneuser();
	$family_members		=	$tagobj->user_tag();
	for($i=0;$i<count($family_members);$i++)
	{
	$option .='<li value='.$family_members[$i]['gene_user_id'].'>'.$family_members[$i]['gene_name']." ".$family_members[$i]['gene_surname'].'</li>';
	}
	$dropdown .= '<div class="dropdown"><input type="text"/><ul>'.$option.'</ul></div>';
	echo $dropdown;exit;
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
<link rel="stylesheet" href="css/photo_detail.css">

<script src="js/jquery.js"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/main.js"></script>
<script src="js/tagging.js"></script>
<script src="js/dropdown.js"></script>
<script>
$(document).ready(function(){


			$("#salva").click(function(){
				  
					var boxdetail = [];
					$("div[id^='box']").each(function()
					{
						var idVal	=	this.id;
						var myvar 	= 	idVal.split('box');						
						var parentOffset2 = $("#"+this.id).position();
						
					
						var value = $("#input"+myvar[1]).find("#user_id_selected").text();
						
					    
						if ($(parentOffset2).exists())
						{   
							 var  fotowidth    = $("#taggable").width();
							 
							 var  fotoheight   = $("#taggable").height();
							  
                             var  actualwidth  = $("#actualwidth").val();

							 

							 var actualheight  = $("#actualheight").val();

							 

							 var x1 = parentOffset2.left;
							 var y1 = parentOffset2.top;
							 var boxw=$("#"+this.id).width();
							 var boxh=$("#"+this.id).height();
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

					 

					 $boxdetail     =   JSON.stringify(boxdetail);
			         
                     
					 var error_flag	=	0;	


					   if($title  == '' )
					{
					    
						$("#title").addClass('error');
						error_flag	=	1;
					}
					else	
				    {
                        $("#title").removeClass('error');

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
						

                   if(error_flag	==	0)
				{


                    $.ajax({
									type: 'POST',
									url: 'save_image_details.php', 
									data:'galleryid='+$galleryid+'&title='+$title+'&image='+$src+'&desc='+$desc+'&status='+$status+'&imagedat='+$imgdate+'&boxdetail='+$boxdetail,

									success: function(data) 
									{
									 
									   //alert(data);
										if(data =='success')
										{
                                           location.href="photo.php?id_gallery="+$galleryid;
										}
										else
										{
											alert('Unable to add image details');
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
                        
                          <div id="img_cont">
						  
                           <?php 
							
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
						    ?>
							    
                                <img id="taggable" src="../upload/<?php echo $new_image ;?>" style="width:100%" />
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
                
                <!-- Colonna di destra --->
                
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
									<?php for($i=1900;$i<=2013;$i++)
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
