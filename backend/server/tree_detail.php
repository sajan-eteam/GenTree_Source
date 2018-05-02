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
	$mode				=	"edit";
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
$(document).ready(function() {
	//$("#rel_opt1").hide();
	//$("#rel_opt2").hide();
	//$("#alive_opt1").hide();
	//$("#alive_opt2").hide();
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
});
</script>
<script>
	$(document).ready(function(){
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
                   

					$alive				=	$('input:radio[name=alive]:checked').val();
					$resident			=	$("#resident").val();
					$cap				=	$("#cap").val();
					$city				=	$("#city").val();
					$province			=	$("#province").val();
					$country			=	$("#country").val();
					$house				=	$("#house").val();
					$office				=	$("#office").val();
					$mobile				=	$("#mobile").val();
                    $mobRegex			=	/^[0-9-+]+$/;
					$vaildoficnum		=   $mobRegex.test($office);
                    $validmobnum		=	$mobRegex.test($mobile);
                     
					$ofemail			=	$("#oemail").val();
					
					$premail			=	$("#pemail").val();
					
					$emailRegex 		= 	new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
					$validoficemail 	= 	$emailRegex.test($ofemail);					
					$validpersnalemail  =   $emailRegex.test($premail);
 
					
					//free field
					//$free1=$("#free1").val();
					//$fre1=$("#fre1").val();
					//$free2=$("#free2").val();
					//$fre2=$("#fre2").val();
					//$free3=$("#free3").val();
					//$fre3=$("#fre3").val();
					
					$death_year		=	$("#dyr").val();
					$death_month	=	$("#dmm").val();
					$death_day		=	$("#dgg").val();
					$death_date		=	$death_day+'-'+$death_month+'-'+$death_year;
                    $dateOfDeath	=	$death_date.split("-");
                    $newDateOFDeath	=	new Date($dateOfDeath[2], $dateOfDeath[1] - 1, $dateOfDeath[0]);
					
					$publish		=	$('input:radio[name=pubbl]:checked').val();
					$showtab		=	$('input:radio[name=availability]:checked').val();
					$member_type	=	$('#member_type').val();
					
					$father			=	$("#father").val(); 		//$("#father option:selected").text(); 
					$mother			=	$("#mother").val(); 		//$("#mother option:selected").text();
					$relation_with	=	$("#relation_with").val(); 	//$("#relation_with option:selected").text();
					$relation_type	=	$("#relation_type").val(); 
					//$("#relation_type option:selected").val();
					$image_name		=	$('#image_name').val();
					


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
					if($username == "")
					{
						$("#user_name").addClass('error');
						error_flag	=	1;
					}
					else
					{	
						$("#user_name").removeClass('error');
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
					if($place_of_birth == '')
					{
						$("#place_birth").addClass('error');
						error_flag	=	1;
					}
					else
					{
						$("#place_birth").removeClass('error');
					}
					if($year == 'aaa' || $month =='mm' || $day =='gg' || $year == '' || $month =='' || $day =='')
					{
						$("#date").addClass('error');
						error_flag	=	1;
					}
					else
					{
						$("#date").removeClass('error');
					}
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

						}

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
					//if($rootid)
				//{ 
						
					//if($member_type == 0)
					//{
					//	$("#relazioni").addClass('error');
					//	error_flag	=	1;
					//} 
					//else
					//{
					//	$("#relazioni").removeClass('error');
					//}
				//}
					
					if($member_type == 1)
					{
						
						var rootCheck	=	0;
						var root_id     =   0;
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
							$("#rel_opt2").removeClass('error');
					}
					if(error_flag	==	0)
					{
							$.ajax({
									type: 'POST',
									url: 'save_tree_details.php', 
									data:'name='+$name+'&sur='+$surname+'&uname='+$username+'&gender='+$gender+
									'&place_of_birth='+$place_of_birth+'&dob='+$dob+'&alive='+$alive+'&resident='+$resident+'&cap='+$cap+
									'&city='+$city+'&province='+$province+'&country='+$country+'&house='+$house+
									'&office='+$office+'&mobile='+$mobile+'&ofemail='+$ofemail+'&premail='+$premail+
									'&death='+$death_date+'&publish='+$publish+'&showtab='+$showtab+'&member_type='+$member_type+ '&father='+$father+'&mother='+$mother+'&relation_with='+$relation_with+'&relation_type='+$relation_type+'&image_name='+$image_name+'&mode='+$mode+'&gene_user_id='+$gene_user_id,
									
									success: function(data) 
									{
										if(data == 1)
										{	
											window.location = "tree.php";
										}
										else
										{
											alert(data);
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
				var status =$('#statuss');
				new AjaxUpload(btnUpload, {
					action: 'uploads.php',
					name: 'uploadfile',
					onSubmit: function(file, ext){
					if (! (ext && /^(jpg|jpeg|png|gif)$/.test(ext)))
					{
						alert('Only JPG,PNG,GIF files are allowed');
						return false;
					}
					//status.text('Uploading image. Please be patient...');
					},
					onComplete: function(file, response)
					{						
						if(response === "error")
						{
							
							$("#message").html("Unable to upload");
							$("#message").show('');
						}
						else 
						{							
							$('#image_name').val(response);
							$('#img_sltd').html('1 Image Selected');	
							$('#img_sltd').show();							
							
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
                        <div class="buttons">
                        	<button class="big" onclick="location.href='tree.php'"><img src="img/buttons/back.gif"/></button >
                            <button class="big" id="salva">salva</button>
                        </div>
                    </div>
                    <h1>Membro della famiglia</h1>
                </div>
            </div>
            <!-------------------->
            <div id="tabella">
                <div id="middle_colom">
                    <div id="name"><p>Nome*</p><input type="text" id="nome" value="<?php echo $gene_user_details['gene_name']; ?>"/></div><!------When there is an error please ADD class="error" to the related divs----->
                    <div id="sur_name"><p>Cognome*</p><input type="text" id="surname" value="<?php echo $gene_user_details['gene_surname']; ?>"/></div>
                    <div id="user_name"><p>Soprannome*</p><input type="text" id="username" value="<?php echo $gene_user_details['gene_nickname']; ?>"/></div>
                    <div id="gen_der">
                    	<p>Sesso*</p><p>
						<input name="gender" onclick="gender_populate(this.value);" type="radio" class="radio" value="m" <?php if($gene_user_details['gene_sex']== 'm') { echo "checked";} ?>/>M &nbsp;&nbsp;
                        <input name="gender" onclick="gender_populate(this.value);" type="radio" class="radio" value="f" <?php if($gene_user_details['gene_sex']== 'f') { echo "checked";} ?>/>F</p>
                    </div>
                    <div id="place_birth"><p>Luogo di nascita*</p><input type="text" id="placebrth" value="<?php echo $gene_user_details['gene_place_birth']; ?>"/></div>
                    <div class="data" id="date"><p>Data di nascita*</p><select id="yr">
                        	<option value="">aaaa</option>
							<?php for($i=1800;$i<=2013;$i++)
							{?>
                        	<option value="<?php echo $i; ?>" <?php if($date_birth_year == $i) echo "selected"; ?>><?php echo $i; ?></option>
                        	<?php } ?>
                        </select>
                        <select id="mm">
                        	<option value="">mm</option>
							<?php for($i=01;$i<=12;$i++)
							{?>
                        	<option value="<?php if($i>=10){ echo $i;}else{echo '0'.$i;}?>" <?php if($date_birth_month == $i) echo "selected";?>><?php if($i>=10){ echo $i;}else{echo '0'.$i;}?></option>
                        	<?php }?>
                     	</select>

                        <select id="gg">
                        	<option value="">gg</option>
							<?php for($i=01;$i<=31;$i++)
							{?>
                           	<option value="<?php if($i>=10){ echo $i;}else{echo '0'.$i;}?>" <?php if($date_birth_date == $i) echo "selected"; ?>><?php echo $i; ?></option>
                          	    <?php } ?>                    
                        </select>
                    </div>
                    <div id="alive">   
                    	<p>In vita*</p><p>
						<input onclick="vivo()" name="alive" value="1" type="radio" class="radio" <?php if($gene_user_details['gene_in_life']== '1') { echo "checked";} ?>/>Sì &nbsp;&nbsp;
                    	<input onclick="morto()" name="alive" value="0" type="radio" class="radio" <?php if($gene_user_details['gene_in_life']== '0') { echo "checked";} ?>/>No</p>
                    </div>
                    <div id="alive_opt1" style="display:<?php if($gene_user_details['gene_in_life']== '1') { echo "block";} else echo "none"; ?>;">
                    	<div><p>Residente in</p><input type="text" id="resident" value="<?php echo $gene_user_details['gene_resident_in']; ?>"/></div>
                    	<div><p>Cap</p><input type="text" id="cap" value="<?php echo $gene_user_details['gene_cap']; ?>"/></div>
                    	<div><p>Città</p><input type="text"id="city" value="<?php echo $gene_user_details['gene_city']; ?>"/></div>
                    	<div><p>Provincia</p><input type="text" size="2"id="province" value="<?php echo $gene_user_details['gene_province']; ?>"/></div>
                    	<div><p>Nazione</p><input type="text"id="country" value="<?php echo $gene_user_details['gene_nation']; ?>"/></div>
                    	<div><p>Tel Abitazione</p><input type="text"id="house" value="<?php echo $gene_user_details['gene_telephone_home']; ?>"/></div>
                    	<div id="oficenum"><p>Tel Ufficio</p><input type="text"id="office" value="<?php echo $gene_user_details['gene_telephone_office']; ?>"/></div>
                    	<div id="mob"><p>Mobile</p><input type="text"id="mobile" value="<?php echo $gene_user_details['gene_mobile_no_1']; ?>"/></div>
                    	<div id="oficemails"><p>Email ufficio</p><input type="text" id="oemail" value="<?php echo $gene_user_details['gene_email_office']; ?>"/></div>
                    	<div id="prsonalemail"><p>Email personale</p><input type="text"id="pemail" value="<?php echo $gene_user_details['gene_email_personel_1']; ?>"/></div>
                    	<div><p>Campo libero 1</p><input class="free" type="text" placeholder="etichetta" id="free1"/> <input class="free" type="text" placeholder="valore" id="fre1"/></div>
                    	<div><p>Campo libero 2</p><input class="free" type="text" placeholder="etichetta" id="free2"/> <input class="free" type="text" placeholder="valore" id="fre2"/></div>
                    	<div><p>Campo libero 3</p><input class="free" type="text" placeholder="etichetta" id="free3" /> <input class="free" type="text" placeholder="valore"id="fre3"/></div>
                    </div>
                    <div id="alive_opt2" style="display:<?php if($gene_user_details['gene_in_life']== '0') { echo "block";} else echo "none"; ?>;">
                    <div class="data" id="date_death"><p>Data del decesso*</p><select id="dyr">
                        	<option>aaaa</option>
							<?php for($i=1800;$i<=2013;$i++)
							{?>
                        	<option value="<?php echo $i; ?>" <?php if($date_death_year == $i) echo "selected"; ?>><?php echo $i; ?></option>
                        	<?php } ?>
                        </select>
                        <select id="dmm">
                        	<option>mm</option>
							<?php for($i=01;$i<=12;$i++)
							{?>
                        	<option value="<?php if($i>=10){ echo $i;}else{echo '0'.$i;}?>" <?php if($date_death_month == $i) echo "selected"; ?>><?php if($i>=10){ echo $i;}else{echo '0'.$i;}?></option>
                        	<?php }?>
                     	</select>
                        <select id="dgg">
                        	<option>gg</option>
							<?php for($i=01;$i<=31;$i++)
							{?>
                           	<option value="<?php if($i>=10){ echo $i;}else{echo '0'.$i;}?>" <?php if($date_death_date == $i) echo "selected"; ?>><?php echo $i; ?></option>
                          	    <?php } ?>                         
                        </select>
                    </div>
                    </div>
                </div>

                <!-- Colonna di destra --->
                
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
                    <div id="immagine" class="box">
                        <div class="head"><span >Immagine</span></div>
                        <div class="center">
                            <!--<img src="img/test.jpg" width="250"  />-->
                          
							<div class="img_btn">
                                <button class="button big" style="display:none;">Rimuovi immagine</button>
                                <input type="button" name="" type="button" value="Aggiungi" id="imgbrowse" class="button big"/>                
								<span id="statuss"></span>  
                                <span id="filenames"></span>   
								<span class="txt-highlite" id="img_sltd" style="display:<?php if($mode == 'edit') echo "block"; else echo "none"; ?>;"><?php echo $gene_user_details['gene_image'];?></span>
							<!--<input class="browse" name="" type="button" value="browse" id="imgbrowse"/>-->
                            </div> 
                        </div>
                   		<div class="foot"></div>
         			</div>
					<?php if(count($rootid)>0){ ?>
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
									$members_male	=	$objUser->familymember("gene_sex = 'm'");
								?>
                                    <option value="0">Seleziona</option>
									<?php
										for($i=0; $i<sizeof($members_male); $i++)
										{
											if($members_male[$i]['gene_user_id']!=$gene_user_id){
											?>

												<option value="<?php echo $members_male[$i]['gene_user_id']; ?>"<?php if($gene_user_details['gene_rel_id_1'] == $members_male[$i]['gene_user_id'])echo "selected";?> ><?php echo $members_male[$i]['gene_name']." ".$members_male[$i]['gene_surname'];?></option>
											<?php
										}
										}
									?>
                                </select>
                                <p>Madre</p>
                                <select id="mother"<?php if(!$relation_count){ if(count($rootid) == 1 || count($rootid)== 0) echo "disabled"; }?>>
								<?php							
									$members_female	=	$objUser->familymember("gene_sex = 'f'");	
								?>
                                    <option value="0">Seleziona</option>
                                    <?php
										for($i=0; $i<sizeof($members_female); $i++)
										{
											if($members_female[$i]['gene_user_id']!=$gene_user_id){
											?>
												<option value="<?php echo $members_female[$i]['gene_user_id'];?>"<?php if($gene_user_details['gene_rel_id_2'] == $members_female[$i]['gene_user_id']) echo "selected"; ?>><?php echo $members_female[$i]['gene_name']." ".$members_female[$i]['gene_surname'];?></option>
											<?php
											}
										}
									?>
									
                                </select>
								
                            </div>
							
                            <div id="rel_opt2" style="display:<?php if($gene_user_details['gene_relation_type']> 2) echo "block"; else echo "none"; ?>">
                            	<p>In relazione con</p>
								<?php	
									//echo $rootid;
								    $condition		=	$rootid;
									if($wifeid == '' || $wifeid < 1)
										$family_members	=	$objUser->family_offspringss();	
									else
										$family_members	=	$objUser->family_offspringss($condition);		
								?>
                                <select id="relation_with" onchange="doSomething(this.selectedIndex.value);"<?php if(count($rootid)== 0) {echo "disabled";}?>>
                                    <option value="0">Seleziona</option>
									<?php
										for($i=0;$i<sizeof($family_members);$i++)
										{
											if($family_members[$i]['gene_user_id']!=$gene_user_id){
											?>
												<option value="<?php echo $family_members[$i]['gene_user_id']; ?>"<?php if($gene_user_details['gene_rel_id_1'] == $family_members[$i]['gene_user_id']) echo "selected";?>>
													<?php echo $family_members[$i]['gene_name']." ".$family_members[$i]['gene_surname']; ?>
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
								<?php }?>
                            </div>
                        </div>
                      
						<?php /* Hidden field added for image upload */ ?>
							<input type="hidden" name="image_name" id="image_name" value="" /> 
							<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
							<input type="hidden" name="gene_user_id" id="gene_user_id" value="<?php echo $gene_user_id; ?>"/>
							<input type="hidden" name="rootid" id="rootid" value="<?php echo $rootid; ?>"/>
                   		   <input type="hidden" name="wifeid" id="wifeid" value="<?php echo $wifeid;?>"/>
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
	var rootid      =   $('#rootid').val(); 
	
	var wifeid      =    $('#wifeid').val();
	
	var dataString 	= 	'gender='+id+'&root='+rootid+'&wifeid='+wifeid;
	
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
	
$(document).ready(function()
{
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

});
</script>
</html>
