<?php	
include "../includes/init.php";
include('session_check.php');
$gallery            =  $_SESSION['gallery_id'];
$filenam            =  $_SESSION['file'];
$image_id           =  $_GET['image_id'];

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
	}
}
//added for menu navigation
$objimage			=   new images();
$tagobj             =   new geneuser();
$objtag             =   new tagging();
$imagetag			=   $objtag->taggingDetails($image_id);
$tagid              =   $imagetag['id_tag'];

$imagetagging       =   count($imagetag);
$dropdown           =   '';
$option             =   '';
$input				=	'';
$options			=   '';
$dropdowns          =   '';
$tagobj             =   new geneuser();
$family_members		=	$tagobj->user_tag();

	for($i=0;$i<count($family_members);$i++)
	{	 
		$gene_user_id       =   $family_members[$i]['gene_user_id'];
		$gene_name          =   $family_members[$i]['gene_name'];
		$gene_surname       =   $family_members[$i]['gene_surname'];
		$options .='<li value='.$gene_user_id.'>'.$gene_name ." ".$gene_surname.'</li>';		
	}
$dropdowns = '<div class="dropdown"><input type="text"/><ul>'.$options.'</ul></div>';
for($j=$imagetagging;$j>0;$j--)
{
	$imagetag			=   $objtag->taggingDetails($image_id);
	$taguserid			=	$imagetag[$j-1]['gene_user_id'];
	$tagusername        =   $tagobj->tagImageUserID($taguserid);
	$tag_user_id		=	$tagusername[0]['gene_user_id'];
	$genename			=   $tagusername[0]['gene_name'];
	$genesurname        =   $tagusername[0]['gene_surname'];
    $count1             =   $j;
	$gentreename		=	$genename." ".$genesurname;	
	
	$input .= '<div id="input'.$count1.'" class="tag_list"><p class="number">'.$count1.'</p><div class="input"><p class="id_val" id="user_id_selected" style="display:none;">'.$tag_user_id.'</p><p id="username">'.$genename." ".$genesurname.'</p><span></span></div><div class="remove" onclick="removebox('.$count1.')">x</div>'.$dropdowns.'</div>';	
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
$("#photoTitle").focus();  
$imageid		= $("#imageid").val(); 
$imagewidth		= $("#taggable").width();
$imageheight	= $("#taggable").height();
$actualimagew   = $("#actualwidth").val();
$actualimageh   = $("#actualheight").val();
$.ajax({
        type : 'POST',
		url  : 'tagging_update.php',
        data :'imageid='+$imageid+'&imagewidth='+$imagewidth+'&imageheight='+$imageheight+'&actualimagew='+$actualimagew+'&actualimageh='+$actualimageh,
        success: function(data) 
		{	
		 
		  $('#img_cont').append(data);
		  
        }

	 });

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
                             var  delstatus    =    $("#delstatus").val();
					         
							 var x1 = parentOffset2.left;
							 var y1 = parentOffset2.top;
							 var boxw=$("#"+this.id).width();
							 var boxh=$("#"+this.id).height();
							boxdetail.push({"image_width":fotowidth,"image_height":fotoheight,"x":x1,"y":y1,"boxw":boxw,"boxh":boxh,"user":value,"actualimagewidth":actualwidth,"actualimageheight":actualheight});
						}			
						
					});

					 
					 $imageid		=	$("#imageid").val(); 
					 
					 $galleryid		=   $('#galid').val();					 
					 $title			=	$('#photoTitle').val();					
					 $img			=   $("#taggable");
                     $src			=   $img.attr("src");					
                     $desc			=   $("#smallDesc").val();					 
					 $status		=   $('input:radio[name=pubbl]:checked').val();					 
			         $year			=	$('#yy').val(); 
					 $month			=	$('#mm').val();
					 $day		    =	$('#dd').val();
					 $tagusrid      =   $('#dd').val();
					 //$imgdate 	    =	$day+'-'+$month+'-'+$year;
					 $imgdate 	    =	$year+'-'+$month+'-'+$day;
					 $boxdetail     =   JSON.stringify(boxdetail);
					 $delstatus     =   $('#delstatus').val();
					 $deluserid     =   $('#deluserid').val();
					
					 var error_flag	=	0;	
						
					 for(var i=0; i < boxdetail.length; i++)
					 {
						if(boxdetail[i].user == '')
						{
							alert('Tagging is not completed');
							error_flag	=	1;
						}						
					 }

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


                   if(error_flag	==	0)
					{

							$.ajax({
									type: 'POST',
									url: 'save_update_photodetails.php', 
							data:'imageid='+$imageid+'&galleryid='+$galleryid+'&title='+$title+'&image='+$src+'&desc='+$desc+'&status='+$status+'&imagedat='+$imgdate+'&boxdetail='+$boxdetail+'&delstatus='+$delstatus+'&deluserid='+$deluserid,

									success: function(data) 
									{	
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

        $("#elimina").click(function(){
					
			var deleteimage		=	$('#imageid').val();
			var galleryid		=   $('#galid').val();
			if (confirm('Are you sure you want to delete this?')) {
				$.ajax({
						type : 'POST',
						url  : 'delete_photo_detail.php',
						data :'imageid='+deleteimage+'&galleryid='+galleryid,
						success: function(data) 
							{
								window.location="photo.php?id_gallery="+galleryid;
			
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
                        	<button class="big" onclick="location.href='photo.php?id_gallery=<?php echo $gallery;?>'"><img src="img/buttons/back.gif"/></button >
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
					<?php  $image_name		= $objimage->imageview($image_id); 
					       $title			= $image_name['image_title'];
						   $description		= $image_name['image_description'];
						   $active			= $image_name['image_publish'];
						   $image_date		= $image_name['image_date'];
						   $newImageDate    = explode('-',$image_date);
						   $newimageyear    = $newImageDate[0]; 
						   $newImagemonth   = $newImageDate[1];
						   $newImagedate    = $newImageDate[2];
						   $monthname        = date("F", strtotime($image_date));
						 
						  ?>
                    	<input id="photoTitle" name="title" type="text" value="<?php echo stripslashes($title); ?>" size="45" placeholder="Titolo della foto"/>
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
						    ?>
                          <img id="taggable" src="../upload/<?php echo $new_image;?>" style="width:100%" />
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
                                    <textarea id="smallDesc" name="smallDesc"><?php echo stripslashes($description);?></textarea>
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
                                	<option value="<?php echo $newimageyear;?>">-------</option>
									<?php for($i=1900;$i<=2013;$i++)
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
                    <!-- hidden fields    -->
                    <input type="hidden" id="galid"  value="<?php echo $gallery;?>"/>
					<input type="hidden" id="boxids" value="<?php echo $imagetagging;?>"/>
					<input type="hidden" id="imageid" value="<?php echo $image_id;?>"/>
					<input type="hidden" id="xcord"    value="<?php echo $tagxcord;?>"/>
					<input type="hidden" id="ycord"     value="<?php echo $tagycord;?>"/>
					<input type="hidden" id="boxwidth"   value="<?php echo $tagwidth;?>"/>
                    <input type="hidden" id="boxheight"   value="<?php echo $tagheight;?>"/>
					<input type="hidden" id="gentreename" value="<?php echo $tag_user_id;?>"/>
					<input type="hidden" id="actualwidth" value="<?php echo $width;?>"/>
                    <input type="hidden" id="actualheight" value="<?php echo $height;?>"/>
					<input type="hidden" id="delstatus"  value=""/>
					<input type="hidden" id="deluserid"   value=""/>
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
