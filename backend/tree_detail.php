<?php
include "../includes/init.php";
include('session_check.php');
$currentpage	= 1;

$objUser		= 	new	geneuser();
$objrel			= 	new	generelation();	

$rootexist      =	$objUser->root();
$count          =   count($rootexist);

$rootid			=   $objUser->relationexist();
//echo $rootid;exit;
$relationexist  =   $objUser->relation_exist($rootid);
$wifeid			=	$relationexist['gene_user_id'];

$rel_tion_id    =	$objUser->relationsearchid($rootid);
$relation_count =   count($relationexist);          

$mode			=	"add";
$gene_user_id	=	mysql_real_escape_string($_REQUEST['gene_user_id']);

if($gene_user_id) 
{
	$gene_user_details	= 	$objUser->getUserDetail($gene_user_id); 
	
	$date_of_birth_arr	=	explode('-', $gene_user_details['gene_birthday']);
	$date_birth_year	=	$date_of_birth_arr[0];
	$date_birth_month	=	$date_of_birth_arr[1];
	$date_birth_date	=	$date_of_birth_arr[2];	
	
	$date_of_death_arr	=	explode('-', $gene_user_details['gene_deathday']);
	$date_death_year	=	$date_of_death_arr[0];
	$date_death_month	=	$date_of_death_arr[1];
	$date_death_date	=	$date_of_death_arr[2];

	$date_of_marriage_arr	=	explode('-', $gene_user_details['gene_marriage_year']);
	$date_marriage_year		=	$date_of_marriage_arr[0];
	$date_marriage_month	=	$date_of_marriage_arr[1];
	$date_marriage_date		=	$date_of_marriage_arr[2];	
	$mode					=	"edit";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Albero Genealogico</title>
<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css"></link>
<link rel="stylesheet" href="css/structure.css"></link>
<link rel="stylesheet" href="css/menu.css"></link>
<link rel="stylesheet" href="css/detail.css"></link>

<script src="js/jquery.js"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/main.js"></script>
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
				error     =   'Impossibile aggiornare I dettagli';
			
			
			$("#error").html(error);
			$("#error").show();
		}
	}
			
		vivo = function(){
			$("#alive_opt1").show();
			$("#alive_opt2").hide();
			$('#alive_opt1').find('input:text').val('');
        } 
		morto = function(){
			$("#alive_opt1").hide();
			$("#alive_opt2").show();
			$('#dyr').prop('selectedIndex',0);
			$('#dmm').prop('selectedIndex',0);
			$('#dgg').prop('selectedIndex',0);
        }
		
		$('#removebutton').click(function(){
				$('#removebutton').css("display","none");
				$('#imgbrowse').css("display","block");							
				$('#image_name').val('');
				$('#thumbs').attr('src', '');												
		});
		
		$("#member_type").change(function(){
			if ( $(this).val() == "0" ) { 
				$("#rel_opt1").hide();
				$("#rel_opt2").hide();
			}

			if ( $(this).val() == "1" ) 
			{ 
				$("#rel_opt1").show();
				$("#rel_opt2").hide();
				$('#father').prop('selectedIndex',0);
				$('#mother').prop('selectedIndex',0);
			}
			if ( $(this).val() == "2" ) 
			{ 
				$("#rel_opt1").hide();
				$("#rel_opt2").show();
				$('#relation_with').prop('selectedIndex',0);
				$('#relation_type').prop('selectedIndex',0);
			}	
		});
			$("#salva").click(function(){
					
					$mode				=	$("#mode").val();
					
					$gene_user_id		=	$("#gene_user_id").val();
					
					$rootid				=	$("#rootid").val();
					
					$name				=	$('#nome').val();
					
					$surname			=	$('#surname').val();
					
					$username			=	$('#username').val();
					
					$gender				=	$('input:radio[name=gender]:checked').val();
					
					$place_of_birth		=	$('#placebrth').val();
					
					$year				=	$('#yr').val();
					$month				=	$('#mm').val();
					$day				=	$('#gg').val();
					$dob				=	$day+'-'+$month+'-'+$year;
					
                    $dateOfBirth		=	$dob.split("-");
                    $newDateOFBirth		=	new Date($dateOfBirth[2], $dateOfBirth[1] - 1, $dateOfBirth[0]);
                    $birthYear          =   new Date($year).getFullYear();

					$alive				=	$('input:radio[name=alive]:checked').val();
					
					$resident			=	$("#resident").val();
					
					$cap				=	$("#cap").val();
					$city				=	$("#city").val();
					$province			=	$("#province").val();
					$country			=	$("#country").val();
					$house				=	$("#house").val();
					
					$office				=	$("#office").val();
					$mobile				=	$("#mobile").val();
                    $mobRegex			=	new RegExp(/^[\+\0-9]{10,16}$/);
					//alert($mobRegex);
					$validhouse         =   $mobRegex.test($house);
					$vaildoficnum		=   $mobRegex.test($office);
                    $validmobnum		=	$mobRegex.test($mobile);
                     
					$ofemail			=	$("#oemail").val();
					
					$premail			=	$("#pemail").val();
					
					$emailRegex 		= 	new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
					$validoficemail 	= 	$emailRegex.test($ofemail);					
					$validpersnalemail  =   $emailRegex.test($premail);
 					
					//free field
					$free1				=	encodeURIComponent($("#free1").val());
					$fre1				=	encodeURIComponent($("#fre1").val());
					$free2				=	encodeURIComponent($("#free2").val());
					$fre2				=	encodeURIComponent($("#fre2").val());
					$free3				=	encodeURIComponent($("#free3").val());
					$fre3				=	encodeURIComponent($("#fre3").val());

					$death_year			=	$("#dyr").val();
					$death_month		=	$("#dmm").val();
					$death_day			=	$("#dgg").val();
					$death_date			=	$death_day+'-'+$death_month+'-'+$death_year;
                    $dateOfDeath		=	$death_date.split("-");
                    $newDateOFDeath		=	new Date($dateOfDeath[2], $dateOfDeath[1] - 1, $dateOfDeath[0]);
					$deathYear          =   new Date($death_year).getFullYear();

					$publish			=	$('input:radio[name=pubbl]:checked').val();
					$showtab			=	$('input:radio[name=availability]:checked').val();
					$member_type		=	$('#member_type').val();
					
					$father			=	$("#father").val(); 
					//$("#father option:selected").text(); 
					$mother			=	$("#mother").val(); 
					//$("#mother option:selected").text();
					$relation_with	=	$("#relation_with").val(); 	//$("#relation_with option:selected").text();
					
					$relation_type	=	$("#relation_type").val(); 
					//$("#relation_type option:selected").val();
					/*marriage year*/
					$marriage_day 		=	$("#mrgdd").val();
					$marriage_month 	=   $("#mrgmm").val();
					$marriage_year  	=   $("#mrgyr").val();
					$marriage_date		=	$marriage_day+'-'+$marriage_month+'-'+$marriage_year;
                    $marriageOfDate		=	$marriage_date.split("-");
                    $newMarriageOFDate	=	new Date($marriageOfDate[2], $marriageOfDate[1] - 1, $marriageOfDate[0]);
                    var dates           = 	new Date();
                    
                    //alert($marriage_day+" "+$marriage_month+" "+$marriage_year);

					//$marriage_year	=	$('#marriageYear').val();
					$image_name		=	$('#image_name').val();
					
					$publish_father_name		=	$('input:radio[name=publish_father_name]:checked').val();
					$publish_year				=	$('input:radio[name=publish_year]:checked').val();
                    
                    $marriageYear   = new Date($marriage_year).getFullYear();

					var error_flag	=	0;
					
					if($name == '')
					{
						$("#name").addClass('error');
						error_flag	=	1;
					}
					else
					{	
						$("#name").removeClass('error');
					}
					if($surname=="")
					{
						$("#sur_name").addClass('error');
						error_flag	=	1;
					}
					else
					{
						$("#sur_name").removeClass('error');
					}
					
					if($gender==null)
					{
						$("#gen_der").addClass('error');
						error_flag	=	1;
					}
					else
					{
						$("#gen_der").removeClass('error');
					}
					//if($alive=='1')
					//{
					if($year == 'aaa' || $month =='mm' || $day =='gg' || $year == '' || $month =='' || $day =='')
					{
						$("#date").addClass('error');
						error_flag	=	1;
					}
					else
					{
						$("#date").removeClass('error');
					}
					//}
					if($alive==null)
					{
						$("#alive").addClass('error');
						error_flag	=	1;
					}
					else
					{
						$("#alive").removeClass('error');
					}
					if($alive=='0')
					{
					   if($death_year == 'aaa'|| $death_month == 'mm' || $death_day == 'gg' || $death_year == ''|| $death_month == '' || $death_day == ''||$newDateOFBirth>=$newDateOFDeath)
					   {					   
							$("#date_death").addClass('error');
							error_flag	=	1;
					   }
					   else
						{
							$("#date_death").removeClass('error');
						}
						
					}
					if($alive=='1')	
					{	
						if($ofemail)
						{
							if(!$validoficemail)
							{
								error_flag	=	1;
								$('#oficemails').addClass('error');	
							}
							else
							{
								
								$('#oficemails').removeClass('error');
							}
						}
						if($premail)
						{
							if(!$validpersnalemail)
							{
								error_flag	=	1;
								$('#prsonalemail').addClass('error');	
							}
							else
							{
								
								$('#prsonalemail').removeClass('error');
							}  

						}
						/*if($house)
						{
							if(!($validhouse))
							{
								
								error_flag	=	1;
								$('#housenum').addClass('error');

							}
							else
							{  
								$('#housenum').removeClass('error');
							}
						}
						if($office)
						{
							if(!($vaildoficnum))
							{   
								
								error_flag	=	1;
								$('#oficenum').addClass('error');

							}
							else
							{    
								$('#oficenum').removeClass('error');
							}
						}
						if($mobile)
						{
						  if(!($validmobnum))
							{   
							   
								error_flag	=	1;
								$('#mob').addClass('error');

							}
							else
							{   
								
								$('#mob').removeClass('error');
							}

						}*/

					}

					if($publish==null)
					{
						$("#pub_div").addClass('error');
						error_flag	=	1;
					}
					else
					{
						$("#pub_div").removeClass('error');
					}
					
					if($showtab==null)
					{
						$("#pub_div").addClass('error');
						error_flag	=	1;
					}
					else
					{
						$("#pub_div").removeClass('error');
					}
					
				
						
					if($member_type == 0)
					{
						$("#relazioni").addClass('error');
						error_flag	=	1;
					} 
					else
					{
						$("#relazioni").removeClass('error');
					}
					// if($mode == 'edit')
					//{
					//	var srcvalue  = $('#imgstld').val();
					//	alert(srcvalue);
                        //imgstld.attr('src',imgstld);
					//}
					
					if($member_type == 1)
					{
						
						var rootCheck	=	0;
						var root_id     =   0;
						var $root_id	=	0;
						if($father == 0 && $mother == 0)
						{						    
							$.ajax({
									type: 'POST',
									url: 'root_exist_check.php', 
									async: false,
									success: function(data) 
									{										
										$root_id = data;																				
										if(data > 0)
										{	
											
											$gene_user_id	=	$.trim($gene_user_id);
											$root_id		=	$.trim($root_id);
											if(($mode == 'edit')&&($gene_user_id == $root_id))
											{
												
												 $("#rel_opt1").removeClass('error');
											}
											else
											{
												alert("Attenzione, completare le informazioni nel box Relazioni prima di salvare");
												$("#rel_opt1").addClass('error');
												error_flag	=	1;
											}										
										}
										if(data == 0)
										{	
											$("#rel_opt1").removeClass('error');
											rootCheck	=	1;
										}
									}
								});							
						}						
					    else if(($mode == 'add')&&($father == 0 || $mother == 0) && (rootCheck!=1))
					    {
							alert("Attenzione, completare le informazioni nel box Relazioni prima di salvare");
							$("#rel_opt1").addClass('error');
							error_flag	=	1;
						}
						else
						{
							$("#rel_opt1").removeClass('error');
						}
                        if(($mode == 'edit') && ($gene_user_id == $root_id))
						{
						  if(($father == 0 || $mother == 0) &&(rootCheck!=1))
					      {
					         $("#rel_opt1").removeClass('error');
					      }

						}
                      
					}
					else if($member_type == 2)
					{
						
						if($relation_with == 0 || $relation_type == 0)
						{
							$("#rel_opt2").addClass('error');
							error_flag	=	1;
						}
						else
						{
							$("#rel_opt2").removeClass('error');
						}
						if($marriageYear < $birthYear  || $marriageYear > $deathYear)
						{
							$("#rel_opt2").addClass('error');
							error_flag	=	1;
						}
						else
						{
							$("#rel_opt2").removeClass('error');
						}

					}
					if(error_flag	==	0)
					{
						 
							$.ajax({
									type: 'POST',
									url: 'save_tree_details.php', 
									data:'name='+$name+'&sur='+$surname+'&uname='+$username+'&gender='+$gender+
									'&place_of_birth='+$place_of_birth+'&dob='+$dob+'&alive='+$alive+'&resident='+$resident+'&cap='+$cap+
									'&city='+$city+'&province='+$province+'&country='+$country+'&house='+encodeURIComponent($house)+
									'&office='+encodeURIComponent($office)+'&mobile='+encodeURIComponent($mobile)+'&ofemail='+$ofemail+'&premail='+$premail+
									'&death='+$death_date+'&publish='+$publish+'&showtab='+$showtab+'&member_type='+$member_type+ '&father='+$father+'&mother='+$mother+'&relation_with='+$relation_with+'&relation_type='+$relation_type+'&marriageYear='+$marriage_date+'&image_name='+$image_name+'&mode='+$mode+'&gene_user_id='+$gene_user_id+'&free1='+$free1+'&fre1='+$fre1+'&free2='+$free2+'&fre2='+$fre2+'&free3='+$free3+'&fre3='+$fre3+'&publish_father_name='+$publish_father_name+'&publish_year='+$publish_year,
														               
									success: function(data) 
									{     
									    //alert(data);                               
                                        var success_url	= "tree_detail.php?gene_user_id="+data+"&success=success";	
                                        success_url 		= success_url.replace(/\s+/g, '');
                                        if($mode == 'add' && (!isNaN(data))) {

                                        	/*
                                        	var message		=	'Informazioni salvate correttamente';
											$("#msg").html(message);
											$("#msg").show();
											*/
											
                                        	window.location = success_url; //"tree_detail.php?gene_user_id="+data+"&success=success";

                                        }
                                        else if($mode == 'add' && (isNaN(data))) {
										  window.location = "tree_detail.php?error=error";
										}										
										else
										{
											if((!isNaN(data)))
											{												
												/*
												var message		=	'Informazioni salvate correttamente';
												$("#msg").html(message);
												$("#msg").show();
												*/
												window.location = success_url; //"tree_detail.php?gene_user_id="+$gene_user_id+"&success=success";
											}
											else
											{  
												window.location = "tree_detail.php?gene_user_id="+$gene_user_id+"&error=error";
												if(data == 'fieldblank')
												{
												   $("#member_type").addClass('error');
												  error_flag	=	1;
												}
												else
												{
												   $("#member_type").removeClass('error');
												}
											
											}
										}
									}
								});
						}
					});
				});
</script>
<script src="js/ajaxupload.3.5.js"></script> 
<script src="js/jquery-1.8.2.js"></script> 
<script type="text/javascript">
			$(function(){			
				var btnUpload=$('#imgbrowse');
				$mode       = $("#mode").val();
				var imgstld = $('#imgview').val();
				var status  = $('#statuss');
				var thumb   = $('#thumb');	
				new AjaxUpload(btnUpload, {
					action: 'uploads.php',
					name: 'uploadfile',
					onSubmit: function(file, ext){
					$('#preview').css("display", "block");
					if (! (ext && /^(jpg|jpeg|png|gif)$/.test(ext)))
					{
						$('#preview').css("display", "block");
						alert('E’ possibile caricare file con queste estensioni: JPG,PNG,GIF');
						return false;
					}
					//status.text('Uploading image. Please be patient...');
					},
					onComplete: function(file, response)
					{		
						if(response === "error")
						{
							$('#preview').css("display", "none");
							$("#message").html("Impossibile caricare il file");
							$("#message").show('');
						}
						else 
						{	
								$('#imgs').show(); 
								$('#preview').css("display", "none");
								$('#image_name').val(response);
								$('#thumbs').attr('src', response);
								$('#removebutton').css("display","block");
								$('#imgbrowse').css("display","none");				
						}						
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
		
				
		<div id="message" class="error" style="display:none;"></div>		
        <!----end left part---->
        <div id="tabella_cont" class="table_main">
            <div id="tabella_head" class="table_head_main">
                <div id="top_right">
                    <div id="head_right">
                        <div class="buttons"> <?php /* location.href='tree.php' */ ?>
                        	<button class="big" onclick="goBack();"><img src="img/buttons/back.gif"/></button >
                            <button class="big" id="salva">salva</button>
                        </div>
                    </div>
                    <h1>Membro della famiglia</h1>
                </div>
            </div>
            <!-------------------->
            <div id="tabella">
                <div id="middle_colom">
				

                    <div id="name"><p>Nome*</p><input type="text" id="nome" value="<?php echo getCleanString($gene_user_details['gene_name']); ?>"/></div>
                    <div id="sur_name"><p>Cognome*</p><input type="text" id="surname" value="<?php echo getCleanString($gene_user_details['gene_surname']);?>"/></div>
                    <div id="user_name"><p>Soprannome</p><input type="text" id="username" value="<?php echo getCleanString($gene_user_details['gene_nickname']); ?>"/></div>
                    <div id="gen_der">
                    	<p>Sesso*</p><p>
						<input name="gender" onclick="gender_populate(this.value);" type="radio" class="radio" value="m" <?php if($gene_user_details['gene_sex']== 'm') { echo "checked";} ?>/>M &nbsp;&nbsp;
                        <input name="gender" onclick="gender_populate(this.value);" type="radio" class="radio" value="f" <?php if($gene_user_details['gene_sex']== 'f') { echo "checked";} ?>/>F</p>
                    </div>
                    <div id="place_birth"><p>Luogo di nascita</p><input type="text" id="placebrth" value="<?php echo getCleanString($gene_user_details['gene_place_birth']); ?>"/></div>
                    <div class="data" id="date"><p>Data di nascita*</p>
                        <select id="gg">
                        	<option value="">gg</option>
							<?php for($i=01;$i<=31;$i++)
							{?>
                           	<option value="<?php if($i>=10){ echo $i;}else{echo '0'.$i;}?>" <?php if($date_birth_date == $i) echo "selected"; ?>><?php echo $i; ?></option>
                          	    <?php } ?>                    
                        </select>


                        <select id="mm">
                        	<option value="">mm</option>
							<?php for($i=01;$i<=12;$i++)
							{?>
                        	<option value="<?php if($i>=10){ echo $i;}else{echo '0'.$i;}?>" <?php if($date_birth_month == $i) echo "selected";?>><?php if($i>=10){ echo $i;}else{echo '0'.$i;}?></option>
                        	<?php }?>
                     	</select>

                       
                        <select id="yr">
                        	<option value="">aaaa</option>
							<?php 
							$current_year	=	date("Y");
							for($i=1800;$i<=$current_year;$i++)
							{?>
                        	<option value="<?php echo $i; ?>" <?php if($date_birth_year == $i) echo "selected"; ?>><?php echo $i; ?></option>
                        	<?php } ?>
                        </select>


                    </div>
                    <div id="alive">   
                    	<p>In vita*</p><p>
						<input onclick="vivo()" name="alive" value="1" type="radio" class="radio" <?php if($gene_user_details['gene_in_life']== '1') { echo "checked";} ?>/>Sì &nbsp;&nbsp;
                    	<input onclick="morto()" name="alive" value="0" type="radio" class="radio" <?php if($gene_user_details['gene_in_life']== '0') { echo "checked";} ?>/>No</p>
                    </div>
                    <div id="alive_opt1" style="display:<?php if($gene_user_details['gene_in_life']== '1') { echo "block";} else echo "none"; ?>;">
                    	<div><p>Residente in</p><input type="text" id="resident" value="<?php echo getCleanString($gene_user_details['gene_resident_in']); ?>"/></div>
                    	<div><p>Cap</p><input type="text" id="cap" value="<?php echo getCleanString($gene_user_details['gene_cap']); ?>"/></div>
                    	<div><p>Città</p><input type="text"id="city" value="<?php echo getCleanString($gene_user_details['gene_city']); ?>"/></div>
                    	<div><p>Provincia</p><input type="text" size="2"id="province" value="<?php echo getCleanString($gene_user_details['gene_province']); ?>"/></div>
                    	<div><p>Nazione</p><input type="text"id="country" value="<?php echo getCleanString($gene_user_details['gene_nation']); ?>"/></div>
                    	<div id="housenum"><p>Tel Abitazione</p><input type="text"id="house" value="<?php echo $gene_user_details['gene_telephone_home']; ?>"/></div>
                    	<div id="oficenum"><p>Tel Ufficio</p><input type="text"id="office" value="<?php echo $gene_user_details['gene_telephone_office']; ?>"/></div>
                    	<div id="mob"><p>Mobile</p><input type="text"id="mobile" value="<?php echo $gene_user_details['gene_mobile_no_1']; ?>"/></div>
                    	<div id="oficemails"><p>Email ufficio</p><input type="text" id="oemail" value="<?php echo $gene_user_details['gene_email_office']; ?>"/></div>
                    	<div id="prsonalemail"><p>Email personale</p><input type="text"id="pemail" value="<?php echo $gene_user_details['gene_email_personel_1']; ?>"/></div>
                    	<div><p>Campo libero 1</p><input class="free" type="text" placeholder="etichetta" id="free1" value="<?php 
						echo $gene_user_details['Label1'];?>"/>&nbsp;<input class="free" type="text" placeholder="valore" id="fre1" value="<?php 
						echo $gene_user_details['Value1'];?>"/></div>
                    	<div><p>Campo libero 2</p><input class="free" type="text" placeholder="etichetta" id="free2" value="<?php 
						echo  $gene_user_details['Label2'];?>"/>&nbsp;<input class="free" type="text" placeholder="valore" id="fre2" value="<?php 
						echo $gene_user_details['Value2']; ?>"/></div>
                    	<div><p>Campo libero 3</p><input class="free" type="text" placeholder="etichetta" id="free3" value="<?php 
						echo $gene_user_details['Label3'];?>"/>&nbsp;<input class="free" type="text" placeholder="valore"id="fre3" value="<?php
						echo $gene_user_details['Value3'];?>"/></div>
                    </div>
                    <div id="alive_opt2" style="display:<?php if($gene_user_details['gene_in_life']== '0') { echo "block";} else echo "none"; ?>;">
                    <div class="data" id="date_death"><p>Data del decesso*</p>
                        <select id="dgg">
                        	<option>gg</option>
							<?php for($i=01;$i<=31;$i++)
							{?>
                           	<option value="<?php if($i>=10){ echo $i;}else{echo '0'.$i;}?>" <?php if($date_death_date == $i) echo "selected"; ?>><?php echo $i; ?></option>
                          	    <?php } ?>                         
                        </select>
                        <select id="dmm">
                        	<option>mm</option>
							<?php for($i=01;$i<=12;$i++)
							{?>
                        	<option value="<?php if($i>=10){ echo $i;}else{echo '0'.$i;}?>" <?php if($date_death_month == $i) echo "selected"; ?>><?php if($i>=10){ echo $i;}else{echo '0'.$i;}?></option>
                        	<?php }?>
                     	</select>
                       
                        <select id="dyr">
                        	<option>aaaa</option>
							<?php for($i=1800;$i<=$current_year;$i++)
							{?>
                        	<option value="<?php echo $i; ?>" <?php if($date_death_year == $i) echo "selected"; ?>><?php echo $i; ?></option>
                        	<?php } ?>
                        </select>
                    </div>
                    </div>
                </div>

                <!-- Colonna di destra -->
                
                <div id="right_colom"> 
                	
                    <div class="box" id="pubblicazione">
                        <div class="head"><span >Pubblicazione*</span></div>
                        <div class="center" id="pub_div">
                            <p class="pub" id="pub_id1">Pubblica: <span>
							<input name="pubbl" type="radio" class="radio" value="1" <?php if($gene_user_details['gene_publish_tree']== '1') { echo "checked";} ?>/> Sì 
							<input name="pubbl" type="radio" class="radio" value="0" <?php if($gene_user_details['gene_publish_tree']== '0') { echo "checked";} ?>/> No </span></p>
                            <p class="pub" id="pub_id2">Mostra scheda in app: <span>
							<input name="availability" type="radio" class="radio" value="1" <?php if($gene_user_details['gene_publish_app']== '1') { echo "checked";} ?>/> Sì 
							<input name="availability" type="radio" class="radio" value="0" <?php if($gene_user_details['gene_publish_app']== '0') { echo "checked";} ?>/> No </span></p>
                        </div>
                   		<div class="foot"></div>
         			</div>

         			<?php /* Added on 14-11-2013 for publish status birthday */	?>
         			<div class="box" id="pubblicazione">
                        <div class="head"><span >Compleanni*</span></div>
                        <div class="center" id="pub_bday_div">

                            <p class="pub" id="pub_year">Anno di nascita: <span>

							<input name="publish_year" type="radio" class="radio" value="1" <?php if($gene_user_details['gene_publish_year']== '1') { echo "checked";} ?>/> Sì 

							<input name="publish_year" type="radio" class="radio" value="0" <?php if($gene_user_details['gene_publish_year']== '0') { echo "checked";} if(!isset($gene_user_details['gene_publish_year'])) echo "checked"; ?>/> No </span></p>

							<p class="pub" id="pub_father_id">Mostra nome padre: <span>

							<input name="publish_father_name" type="radio" class="radio" value="1" <?php if($gene_user_details['gene_publish_father_name']== '1') { echo "checked";} ?>/> Sì 

							<input name="publish_father_name" type="radio" class="radio" value="0" <?php if($gene_user_details['gene_publish_father_name']== '0') { echo "checked";} if(!isset($gene_user_details['gene_publish_father_name'])) echo "checked"; ?>/> No </span></p>

                        </div>
                   		<div class="foot"></div>
         			</div>
         			<?php /* Added on 14-11-2013 for publish status birthday */	?>

                    <div id="immagine" class="box">
                        <div class="head"><span >Immagine</span></div>
                        <div class="center">
                            <span id="preview" style="display:none" >
								<img src="img/ajax-loader.gif" width="25" id="ajax-loader"/>
							</span>
							
							<?php  
							if($mode == 'edit' && $gene_user_details['gene_image'] != '')
							{
								$image_src	=	UPLOAD_PATH.$gene_user_details['gene_image'];
							}
							else
							{
								$image_src	=	'';
							}
							?>
							
							<span id="imgs" style="display:<?php if($image_src != '') echo "block"; else echo "none"; ?>" class="imgss">
								<img src="<?php echo $image_src; ?>" width="250" id="thumbs"/>
							</span>
							
							              
							<div class="img_btn">
								<input type="button" name="" value="Rimuovi immagine" id="removebutton" class="button big" style="display:<?php if($mode == 'edit' && $gene_user_details['gene_image'] != '') echo "block"; else echo "none";?>"/>
                                <input type="button" name=""value="Aggiungi" id="imgbrowse" class="button big" style="display:<?php if($gene_user_details['gene_image'] == '') echo "block"; else echo "none";?>"/>                
								<span id="statuss"></span>  
                                <span id="filenames"></span>							
								<?php 
								/*
								<span class="txt-highlite" id="img_sltd" style="display:<?php if($mode == 'edit') echo "block"; else echo "none"; ?>;">
									<?php echo $gene_user_details['gene_image'];?>
								</span>
								*/ ?>
							<!--<input class="browse" name="" type="button" value="browse" id="imgbrowse"/>-->
                            </div> 
                        </div>
                   		<div class="foot"></div>
         			</div>
					<?php if(count($rootid)> 0 && ($gene_user_details['gene_relation_type'] != 1)){ ?>
                    <div id="relazioni" class="box" >
                        <div class="head"><span >Relazioni</span></div>
                        <div class="center">
                        	<p>Tipo di familiare</p>
                        	<select id="member_type"<?php if($mode =='edit')echo "disabled";?>>
                            	<option value="0">Seleziona</option>
                                <option value="1" <?php if($gene_user_details['gene_relation_type'] == 1 || $gene_user_details['gene_relation_type'] == 2) echo "selected"; ?>>Membro della famiglia</option>
                                <option value="2" <?php if($gene_user_details['gene_relation_type']> 2) echo "selected"; ?>>Familiare acquisito</option>
                        	</select>
							
                            <div id="rel_opt1" value="1" style="display:<?php if($gene_user_details['gene_relation_type'] == 1 || $gene_user_details['gene_relation_type'] == 2) echo "block"; else echo "none"; ?>">
                            	<p>Padre</p>
                                <select id="father"<?php if(!$relation_count){if(count($rootid) == 1 || count($rootid)== 0) echo "disabled";}?>>
								<?php
									$objUser		= 	new	geneuser();
									$members_male	=	$objUser->familymember("gene_sex = 'm' AND Trash='1'");
								?>
                                    <option value="0">Seleziona</option>
									<?php
										for($i=0; $i<sizeof($members_male); $i++)
										{
											if($members_male[$i]['gene_user_id']!=$gene_user_id){
												$birthYear	=	$members_male[$i]['gene_birthday'];
												$year       =   explode('-', $birthYear);
												$yyyy       =   $year[0];
											?>

												<option value="<?php echo $members_male[$i]['gene_user_id']; ?>"<?php if($gene_user_details['gene_rel_id_1'] == $members_male[$i]['gene_user_id'])echo"selected";?>><?php echo  getCleanString($members_male[$i]['gene_name']." ".$members_male[$i]['gene_surname'])." ".$yyyy;?></option>
											<?php
										}
										}
									?>
                                </select>
                                <p>Madre</p>
                                <select id="mother"<?php if(!$relation_count){ if(count($rootid) == 1 || count($rootid)== 0) echo "disabled"; }?>>
								<?php
												
									$members_female	=	$objUser->familymember("gene_sex = 'f' AND Trash='1'");	

								?>
                                    <option value="0">Seleziona</option>
                                    <?php
										for($i=0; $i<sizeof($members_female); $i++)
										{	

											if($members_female[$i]['gene_user_id']!=$gene_user_id){									$birthYear	=	$members_female[$i]['gene_birthday'];
												$year       =   explode('-', $birthYear);
												$yyyy       =   $year[0];
											?>
												<option value="<?php echo $members_female[$i]['gene_user_id'];?>" <?php if($gene_user_details['gene_rel_id_2'] == $members_female[$i]['gene_user_id']) echo "selected"; ?>>
													<?php echo  getCleanString($members_female[$i]['gene_name']." ".$members_female[$i]['gene_surname'])." ".$yyyy;?></option>
											<?php
											}
										}
									?>
                                </select>
                            </div>
                            <div id="rel_opt2" style="display:<?php if($gene_user_details['gene_relation_type']> 2) echo "block"; else echo "none"; ?>">
                            	<p>In relazione con</p>
								<?php	
								   /*
									$condition		=	$rootid;
									$family_members	=	$objUser->family_offspringss($condition);
									*/

									$condition		=	$rootid;
									if($wifeid == '' || $wifeid < 1)
										$family_members	=	$objUser->family_offspringss();	
									else
										$family_members	=	$objUser->family_offspringss($condition, $gene_user_details['gene_rel_id_1']);
									
									//echo $gene_user_details['gene_rel_id_1']."-".$family_members[$i]['gene_user_id'];
									
								?>
                                <select id="relation_with" onchange="doSomething(this.selectedIndex.value);"<?php if(count($rootid)== 0) {echo "disabled";}?>>
                                    <option value="0">Seleziona</option>
									<?php
										for($i=0;$i<sizeof($family_members);$i++)
										{
											if($family_members[$i]['gene_user_id']!=$gene_user_id){
												$birthYear	=	$family_members[$i]['gene_birthday'];
												$year       =   explode('-', $birthYear);
												$yyyy       =   $year[0];
											?>
												<option value="<?php echo $family_members[$i]['gene_user_id']; ?>"<?php if($gene_user_details['gene_rel_id_1'] == $family_members[$i]['gene_user_id']) echo "selected";?>>
													<?php echo getCleanString($family_members[$i]['gene_name']." ".$family_members[$i]['gene_surname'])." ".$yyyy; ?>
												</option>
											<?php
											}
										}
									?>                                    
                                </select>
                                <p>Tipo di relazione</p>
								<?php 									
									$obj=$objrel->getrelation();
								?>
                                <select id="relation_type"<?php if(count($rootid)== 0) {echo "disabled";}?>>
								<option value="0">Seleziona</option>
								<?php for($i=2;$i<count($obj);$i++){
								?>								    
                                    <option value="<?php echo $obj[$i]['relation_id'];?>" <?php if($gene_user_details['gene_relation_type'] == $obj[$i]['relation_id']) echo "selected"; ?>>
										<?php echo $obj[$i]['relation_title'];?>
									</option>
                                    <?php  } ?>
                                </select>
                                <p>Anno di matrimonio</p>
                                <div class="marriage-date clearfix">
                    <select id="mrgdd">
                    	<option>gg</option>
						<?php for($i=01;$i<=31;$i++)
						{?>
                       	<option value="<?php if($i>=10){ echo $i;}else{echo '0'.$i;}?>" <?php if($date_marriage_date == $i) echo "selected"; ?>><?php echo $i; ?></option>
                      	    <?php } ?>                         
                    </select>
                    <select id="mrgmm">
                    	<option>mm</option>
						<?php for($i=01;$i<=12;$i++)
						{?>
                    	<option value="<?php if($i>=10){ echo $i;}else{echo '0'.$i;}?>" <?php if($date_marriage_month == $i) echo "selected"; ?>><?php if($i>=10){ echo $i;}else{echo '0'.$i;}?></option>
                    	<?php }?>
                 	</select>
                   
                    <select id="mrgyr">
                    	<option>aaaa</option>
						<?php for($i=1800;$i<=$current_year;$i++)
						{?>
                    	<option value="<?php echo $i; ?>" <?php if($date_marriage_year == $i) echo "selected"; ?>><?php echo $i; ?></option>
                    	<?php } ?>
                    </select>
                    </div>
								
								<?php }?>
                            </div>
                        </div>
                      
						<?php /* Hidden field added for image upload */ ?>
							<input type="hidden" name="image_name" id="image_name" value="<?php echo $gene_user_details['gene_image']; ?>" /> 
							<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
							<input type="hidden" name="gene_user_id" id="gene_user_id" value="<?php echo $gene_user_id; ?>"/>
							<input type="hidden" name="rootid" id="rootid" value="<?php echo $rootid; ?>"/>
                   		   <input type="hidden" name="wifeid" id="wifeid" value="<?php echo $wifeid;?>"/>
						    <input type="hidden" name="imgview" id="imgview" value="<?php echo $gene_user_details['gene_image'];?>"/>

						    <input type="hidden" name="madreID" id="madreID" value="<?php echo $gene_user_details['gene_rel_id_2'];?>"/>

						<div class="foot"></div>
         			</div>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
function gender_populate (value)
{
	var id			=	value;
	var rootsid      =   $('#rootid').val(); 
	
	var wifeid      =    $('#wifeid').val();
	
	var dataString 	= 	'gender='+id+'&root='+rootsid+'&wifeid='+wifeid;
	
	$.ajax({
		type: "POST",
		url: "gender_based_list.php",
		data: dataString,
		cache: false,
		success: function(html)
			{
				$("#relation_with").html(html);
			} 
	});
}
function doSomething(index)
{
  //alert($("#relation_with").val());
}
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
$(document).ready(function()
{
	defaultSelection();
	$("#nome").focus();
	$("#father").change(function()
	{
		var id			=	$(this).val();
		var dataString 	= 	'id='+ id;
		$.ajax
		({
			type: "POST",
			url: "ajax_parent_list.php",
			data: dataString,
			cache: false,
			success: function(html)
				{
					$("#mother").html(html);
				} 
		});
	});	
	/*
	$('#member_type').change(function() {
	var type =  $(this).val();
	var father = $("#father").val();
	var mother = $("#mother").val();
	$.ajax({
				type: "POST",
				url: "change.php",
				data: 'father='+father+'&mother='+mother,
				cache: false,
				success: function(html)
					{
						$("#mother").html(html);
					} 
			});
		});
	*/
function defaultSelection()
{
		var id			=	$("#father").val();
		var madreID		=	$("#madreID").val();
		var dataString 	= 	'id='+ id+'&madreID='+madreID;
		$.ajax
		({
			type: "POST",
			url: "ajax_parent_list.php",
			data: dataString,
			cache: false,			
			success: function(html)
				{
					$("#mother").html(html);
				} 
		});
}
});

function goBack()
  {
	window.history.back();
  }
</script>
</html>
