<?php	
include "../includes/init.php";
include('session_check.php');
$gallery            =  $_SESSION['gallery_id'];
$filenam            =  $_SESSION['file'];
$image_id           =  $_GET['image_id'];
//added for menu navigation
$currentpage	= 5; 

//added for menu navigation
$objimage			=   new instaimages();
$objtag             =   new instatagging();
$imagetag			=   $objtag->taggingDetails($image_id);
$tagid              =   $imagetag['id_tag'];
$imagetagging       =   count($imagetag);
for($j=$imagetagging;$j>0;$j--)
{
	$imagetag			=   $objtag->taggingDetails($image_id);
	$taggedName  		=	$imagetag[$j-1]['tagged_name'];
    $count1             =   $j;
    $input  .=  '<div id="input'.$count1.'"class="tag_list"><p class="number" id="num'.$count1.'">' .$count1. '</p><input type="text" id="tagged_name" value="'.$taggedName.'"/><div class="remove" onclick="removebox('.$count1.')">x</div></div>';
	
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="http-equiv" content="Content-type: text/html; charset=UTF-8"/>
<title>Albero Genealogico</title>
<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="css/structure.css">
<link rel="stylesheet" href="css/menu.css">
<link rel="stylesheet" href="css/photo_detail.css">

<script src="js/jquery.js"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/phpjs.js" charset="utf-8"></script>
<script src="js/insta_album_tagging.js" charset="utf-8"></script>
<script src="js/main.js" charset="utf-8"></script>
<script src="js/dropdown.js" charset="utf-8"></script>
<script charset="utf-8">

function tagLoad() {

	$("#photoTitle").focus();  
	$imageid		= $("#imageid").val(); 
	$imagewidth		= $("#taggable").width();
	$imageheight	= $("#taggable").height();
	$actualimagew   = $("#actualwidth").val();
	$actualimageh   = $("#actualheight").val();
  	$.ajax({
	        type : 'POST',
			url  : 'instalbum_tagging_update.php',
	        data :'imageid='+$imageid+'&imagewidth='+$imagewidth+'&imageheight='+$imageheight+'&actualimagew='+$actualimagew+'&actualimageh='+$actualimageh,
	        success: function(data) 
			{	
			 //alert(data);			 
			  $('#img_cont').append(data);			  
	        }

	});
}

$(window).load(function() {
    tagLoad();
    
});
$(document).ready(function(){
	var success	=	getQueryString('success');
	var error	=	getQueryString('error');

	if(success.length > 0)
	{
		if(success == 'success')
			var message		=	'Informazioni salvate correttamente';
		if(success == 'delete')
			var message		=	'Foto correttamente eliminata';
			
		$("#msg").html(message);
		$("#msg").show();
	}
	else if(error.length > 0 && error == 'error')
	{
		if(error == 'error')
			var error = 'Impossibile aggiornare i dati'; 
		$("#error").html(error);
		$("#error").show();
	}

			$("#salva").click(function(){				      
				    
				    var error_flag_foto	=	0;
				    var error_msg		=	'';
				    var error_flag_tagging = 0;
					var boxdetail = [];
					$("div[id^='box']").each(function() {
						
						var idVal	=	this.id;						
						var myvar 	= 	idVal.split('box');						
						var parentOffset2 = $("#"+this.id).position();
						var value = $("#input"+myvar[1]).find("#tagged_name").val();
					
						if ($(parentOffset2).exists()) {

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
							 var  actualheight = $("#actualheight").val();
                             var  delstatus    = $("#delstatus").val();
					         
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
							 		error_msg	=	'La larghezza del tag non può essere di 0 pixel';		
							 }
							 var boxh=$("#"+this.id).height();
							 if(boxh == '' || boxh == 0) {
							 		error_flag_foto = 1;
							 		error_msg	=	'L’altezza del tag non può essere di 0 pixel';		
							 }
							 boxdetail.push({"image_width":fotowidth,"image_height":fotoheight,"x":x1,"y":y1,"boxw":boxw,"boxh":boxh,"user":value,"actualimagewidth":actualwidth,"actualimageheight":actualheight});
						}			
						
					});

					 
					 $imageid		=	$("#imageid").val(); 				 
					 $title			=	$('#photoTitle').val();					
					 $img			=   $("#taggable");
                     $src			=   $img.attr("src");					
                     $desc			=   $("#smallDesc").val();					 
					 $status		=   $('input:radio[name=pubbl]:checked').val();					 
			         $year			=	$('#yy').val(); 
					 $month			=	$('#mm').val();
					 $day		    =	$('#dd').val();
					 $tagusrid      =   $('#dd').val();
					
					 $imgdate 	    =	$year+'-'+$month+'-'+$day;
					 $boxdetail     =   JSON.stringify(boxdetail);
					 
					 $delstatus     =   $('#delstatus').val();
					 $deluserid     =   $('#deluserid').val();
					

					 var lastModifiedTime 	= $('#lastModifiedTime').val();
					 var imagePublish 		= $('#imagePublish').val();

					 var error_flag	=	0;	
						
					 for(var i=0; i < boxdetail.length; i++)
					 {
						if(boxdetail[i].user == '')
						{							
							error_flag_tagging	=	1;
						}						
					 }

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
                        
						$("#pubblicazione").addClass('error');
						error_flag	=	1;
				    }
					else
				    {
                       $("#pubblicazione").removeClass('error');
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
                     
                    if(error_flag	==	0 && error_flag_foto == 0 && error_flag_tagging == 0)
					{

							$.ajax({
									type: 'POST',
									url: 'save_update_instalbum.php', 
									data:'imageid='+$imageid+'&title='+$title+'&image='+$src+'&desc='+$desc+'&status='+$status+'&imagedat='+$imgdate+'&boxdetail='+$boxdetail+'&delstatus='+$delstatus+'&deluserid='+$deluserid+'&lastModifiedTime='+lastModifiedTime+'&imagePublish='+imagePublish,

									success: function(data) 
									{   
										//alert(data);
										if(data =='success')
										{
											var message		=	'Informazioni salvate correttamente';
											$("#msg").html(message);
											$("#msg").show();
											$("#error").hide();
											
										}
										else
										{
										    var error_msg	=	"Impossibile aggiungere dati";	
										    $("#error").html(error_msg);
											$("#error").show();
											$("#msg").hide();
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

        	$("#elimina").click(function(){
					
			var deleteimage		=	$('#imageid').val();
			
			if (confirm("Attenzione, cancellare l'immagine corrente?")) {
				$.ajax({
						type : 'POST',
						url  : 'delete_photo_detail.php',
						data :'image_id='+deleteimage,
						success: function(data) 
							{
								window.location="insta_album.php";
							}
						});
				}
			});
});
//function goBack()
//  {
	//window.history.back();
 // }
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
						<button class="big" onclick="location.href='insta_album.php'">
                        	<!--<button class="big" onclick="javascript:goBack();">--><img src="img/buttons/back.gif"/></button >
                            <button class="big" id="salva">salva</button >
                            <button class="big" id="elimina">Elimina</button >
                        </div>
                    </div>
                    <h1>Dettaglio foto</h1>
                </div>
            </div>
            <!-------------------->
            <div id="tabella">
                <div id="middle_colom">
                	<div class="title" id="title">
					<?php  
							$image_name			= 	$objimage->imageview($image_id); 
					       	$title				= 	$image_name['image_title'];
						   	$description		= 	$image_name['image_description'];
						   	$active				= 	$image_name['image_publish'];
						   	$image_date			= 	$image_name['image_date'];
						   	$newImageDate    	= 	explode('-',$image_date);
						   	$newimageyear    	= 	$newImageDate[0]; 
						   	$newImagemonth   	= 	$newImageDate[1];
						   	$newImagedate    	= 	$newImageDate[2];
						   	$monthname        	= 	date("F", strtotime($image_date));
						   	$lastModifiedTime	=	$image_name['LastModifiedTime'];
						   	$divScrollString 	=   '';
						   	 if($image_id) {
								$image_new  = $image_name['image_src'];
	                            $new_image  = $image_new;
							 }
							 else{
                               $new_image = $filenam;
							 }
						   	list($width,$height) = getimagesize('../upload/'.$new_image);
						   	for($i=0;$i<$imagetagging;$i++){
								$tagycord           =   $imagetag[$i]['tag_y_cord'];
								$tagheight          =   $imagetag[$i]['tag_heigth'];
								$image_height 		=	$imagetag[$i]['image_height'];
						    	$y_cord 			=   ($image_height*$tagycord)/$height;
						    	$Height             =   ($tagheight*$image_height)/$height;
						    	$taggHeight			=	$y_cord+$Height;
						    	if($taggHeight>$image_height){
									$divScrollString.= "<div class=\"scrolls\" style=\"overflow-y: scroll;height:".$taggHeight."px;\">";
								}
							}
					?>
                    <input id="photoTitle" name="title" type="text" value="<?php echo getCleanString($title);?>" size="45" placeholder="Titolo della foto"/>                                 
                    </div>
                    <div class="box">
                     <div class="head"><span></span></div>
                     <div class="center">  
                      <?=isset($divScrollString)?$divScrollString:''?>                                                                                               
                          <div id="img_cont">						    							
						   <img id="taggable" src="../upload/<?php echo $new_image;?>" style="width:100%" />
                          </div>
                     <?=isset($divScrollString)?'</div>':''?>
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
                                    <textarea id="smallDesc" name="smallDesc"><?php echo getCleanString($description);?></textarea>
                                </td>
                            </tr>
                        </table>
                        </div>
                        <div class="foot"></div>
                    </div>
                </div>
                
                <!-- Colonna di destra - -->
                
                <div id="right_colom"> 
                	
                    <div class="box" id="pubblicazione">
                        <div class="head"><span >Pubblicazione*</span></div>
                        <div class="center">
                            <p class="pub">Pubblica: <span><input name="pubbl" type="radio" class="radio" value="1"<?php echo ($active=='1')?'checked':''?>/>Si<input name="pubbl" type="radio" class="radio" value="0"<?php echo ($active=='0')?'checked':''?>/>No </span></p>
                        </div>
                   		<div class="foot"></div>
         			</div>
                    
                    <div class="box" id="data">
                        <div class="head"><span >Data della foto*</span></div>
                        <div class="center">
                            <div>
                            	<p>anno:</p>
                                <select id="yy">
                                	<option value="">-------</option>
									<?php 
									$current_year	=	date("Y");	
									for($i=1850;$i<=$current_year;$i++)
							       {?>
                                    <option value="<?php echo $i;?>" <?php if($newimageyear == $i) echo "selected"; ?>><?php echo $i;?></option>
                                   
									<?php }?>
                                </select>
                            </div>
                            <div>
                            	<p>Mese: </p>
                                <select id="mm">
								<?php   $months = array(1 => 'Gennaio', 2 => 'Febbraio', 3 => 'Marzo', 4  => 'Aprile', 5 => 'Maggio', 6 => 'Giugno', 7 => 'Luglio', 8 => 'Agosto', 9 => 'Settembre', 10 => 'Ottobre', 11 => 'Novembre', 12 => 'Dicembre');
								
								?>
								 <option value="">-------</option>
                                  <?php 
                                  foreach ($months as $num => $name) {?>
                                 <option value="<?php echo $num ;?>" <?php if($newImagemonth == $num) echo "selected"; ?>><?php echo $name;?></option>;
                                 <?php } ?>
                                </select>
                            </div>
                            <div>
                            	<p>Giorno: </p>
                                <select id="dd">
                                	<option value="">-------</option>
                                	<?php for($i=1;$i<=31;$i++)
							       {?>
                                    <option value="<?php echo $i;?>" <?php if($newImagedate == $i) echo "selected"; ?>><?php echo $i;?></option>
									<?php }?>                       
                                </select>
                        	</div>
                        </div>
                   		<div class="foot"></div>
         			</div>
					 <div class="box" id="data" style="display:none;">
                     <div class="head"><span >Album di apparenenza</span></div>
					 <div class="center">
					 <div>
                        <p class="albumName"></p>
                        <input type="text" id="album" name="albumname" value="Insta Album"/>
                      </div>
					 </div>
					 <div class="foot"></div>
					 </div>
                    <!-- hidden fields    -->
                    <!--<input type="hidden" id="galid"  value="<?php echo $gallery;?>"/>-->
					<input type="hidden" id="boxids"    value="<?php echo $imagetagging;?>"/>
					<input type="hidden" id="imageid"   value="<?php echo $image_id;?>"/>
					<input type="hidden" id="xcord"     value="<?php echo $tagxcord;?>"/>
					<input type="hidden" id="ycord"     value="<?php echo $tagycord;?>"/>
					<input type="hidden" id="boxwidth"  value="<?php echo $tagwidth;?>"/>
                    <input type="hidden" id="boxheight" value="<?php echo $tagheight;?>"/>
					<input type="hidden" id="imgHeight" value=""/>
					<input type="hidden" id="actualwidth" value="<?php echo $width;?>"/>
                    <input type="hidden" id="actualheight" value="<?php echo $height;?>"/>
					
					<input type="hidden" id="delstatus"  value=""/>
					<input type="hidden" id="deluserid"   value=""/>
					<input type="hidden" id="lastModifiedTime" name="lastModifiedTime"  value="<?php echo $lastModifiedTime; ?>"/>
                    <input type="hidden" id="imagePublish" name="imagePublish" value="<?php echo $active; ?>"/>
                    <div class="box" >
                        <div class="head"><span >Tags</span></div>
                        <div class="center">
                            <div id="tags"><?php echo $input; ?></div>
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
