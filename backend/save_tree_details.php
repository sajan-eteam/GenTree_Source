<?php
include "../includes/init.php"; 
include "loggfile.php";
$objUser			= 	new geneuser();
$objrel     		= 	new generelation();
$name				= 	cleanString($_POST['name']);
$sur_name			= 	cleanString($_POST['sur']);
$nick_name			= 	cleanString($_POST['uname']);
$gender	    		= 	$_POST['gender'];
$place_of_birth	    = 	cleanString($_POST['place_of_birth']);
$dob	    		= 	$_POST['dob']; 
$dob_array			=	explode('-', $dob);
$newformat 			= 	$dob_array[2]."-".$dob_array[1]."-".$dob_array[0];
$birthyear			=	date($newformat);
$alive  			= 	mysql_real_escape_string($_POST['alive']);
$resident			= 	cleanString($_POST['resident']);
$cap	    		= 	cleanString($_POST['cap']);
$city	    		= 	cleanString($_POST['city']);
$province			= 	cleanString($_POST['province']);
$country			= 	cleanString($_POST['country']);
$house	    		= 	stripslashes(urlencode($_POST['house']));
$house				=	urldecode($house);
$office	    		= 	stripslashes(urlencode($_POST['office']));
$office				=	urldecode($office);
$mobile	    		= 	stripslashes(urlencode($_POST['mobile'])); //  $_POST['mobile']; 
$mobile				=	urldecode($mobile);
$ofemail			= 	stripslashes($_POST['ofemail']);
$premail			= 	stripslashes($_POST['premail']);
$death	    		= 	$_POST['death'];
//$dod				=	strtotime($death);
//$newdeath			=	date('Y-m-d',$dod);
$death_array		=	explode('-', $death);
$newdeath 			= 	$death_array[2]."-".$death_array[1]."-".$death_array[0];
$deathyear			=	date($newdeath);

$publish			= 	$_POST['publish'];
$showtab			= 	$_POST['showtab'];
$member_type		= 	mysql_real_escape_string($_POST['member_type']);
$father	    		= 	mysql_real_escape_string($_POST['father']);
$mother	    		= 	mysql_real_escape_string($_POST['mother']);
$relation_with		= 	mysql_real_escape_string($_POST['relation_with']);
$relation_type 		= 	mysql_real_escape_string($_POST['relation_type']);

$marriageYear       =   $_POST['marriageYear'];
$mrgyear_array		=	explode('-', $marriageYear);
$mrgformat 			= 	marriage_year_date($mrgyear_array[2],$mrgyear_array[1],$mrgyear_array[0]);
$currentYear 		=	date("Y-m-d");
$mrgYear   			=   date($mrgformat);

$image_name			= 	mysql_real_escape_string($_POST['image_name']);
$image1				=	explode("/", $image_name);
//$img				=	$image1[2];
$img				=	$image1[sizeof($image1) - 1];
$free1				=	stripslashes($_POST['free1']);
$fre1				=	stripslashes($_POST['fre1']);
$free2				=	stripslashes($_POST['free2']);
$fre2				=	stripslashes($_POST['fre2']);
$free3				=	stripslashes($_POST['free3']);
$fre3				=	stripslashes($_POST['fre3']);
$LastModifiedTime	=   date('Y-m-d H:i:s');
$publish_father_name	= 	$_POST['publish_father_name'];
$publish_year			= 	$_POST['publish_year'];
$NoticationStatus 	= 	'1';
$gene_rel_id_1		=	0;
$gene_rel_id_2		=	0;
$generation_num		=	0;
$gene_user_id		=	0;

if($marriageYear=='gg-mm-aaaa'){
    $mrgformat = '0000-00-00';}
if($alive == 1){
	$newdeath = '0000-00-00';}
if($alive == 0){
$NoticationStatus = '0';
}
if($relation_type == '5' || $relation_type == '6'){
	$NoticationStatus = '0';
}
$mode				=	mysql_real_escape_string($_POST['mode']);

if($mode == 'edit'){
	$gene_user_id	=	mysql_real_escape_string($_POST['gene_user_id']);
	if($alive == 0){
	 $getDeathDay =	$objUser->getUserDetail($gene_user_id);
	 $deathDaySpecify = $getDeathDay['gene_deathday'];
	  if($deathDaySpecify == '0000-00-00' || $relation_type == '5' || $relation_type == '6'){
	  	$NoticationStatus = '0';
	  }
	}
	if($alive == 1){
		if($relation_type == '5' || $relation_type == '6'){
			$NoticationStatus = '0';
		}
	}
}

if($name==''||$sur_name==''||$gender==''||$dob=='gg-mm-aaaa'||$alive=='')
{
	echo "Il campo non può essere vuoto";exit;
}
else if(($alive == '0'&& $death == 'gg-mm-aaaa')|| ($alive == '0' && $newformat >= $newdeath))
{
	echo "La data di decesso non può essere antecedente alla data di nascita"; exit;
}
else
{
	if(($member_type	==	1 || $member_type	==	0) && $father	== 0 && $mother == 0)
	{
			$result	=	gene_root_check($db);
			if($result== 0)
			{
				$relation_type	=	1;
				$gene_rel_id_1	=	'0';
				$gene_rel_id_2	=	'0';		
				$generation_num	=	1;
			}
			else
			{
				$root_id	=	$result;
				if($root_id != $gene_user_id)
				{
					echo "fieldblank"; exit;
				}
				else if(($mode == 'edit')&&($root_id == $gene_user_id))
				{
					$relation_type	=	1;
					$gene_rel_id_1	=	'0';
					$gene_rel_id_2	=	'0';		
					$generation_num	=	1;
				}
			}				
	}
	else if($member_type	==	1 && ($father	== 0 || $mother == 0))
	{
		echo "Selezionare madre e padre"; exit;				
	}
	/*
	else if($member_type	==	1 && ($father	== 0 || $mother == 0))
	{
		echo "Please select both father and mother"; exit;				
	}*/
	else if($member_type	==	2 && ($relation_with	== '0' || $relation_type == '0'))
	{
		echo "Selezionare le persone da relazionare e la tipologia di relazione"; exit;				
	}
	else if($member_type	==	1 && $father	!= 0 && $mother != 0)
	{
		$relation_type	=	2;
		$gene_rel_id_1	=	$father;
		$gene_rel_id_2	=	$mother;
		$generation_num	=	$objUser->get_generation($gene_rel_id_1)+1;
	}
	else if($member_type	==	2 && $relation_with	!= '0' && $relation_type != '0')
	{
		$relation_type	=	$relation_type;
		$gene_rel_id_1	=	$relation_with;
		$gene_rel_id_2	=	0;	
		$generation_num	=	$objUser->get_generation($gene_rel_id_1);
	}
		
	$insertArray=array(
					 "gene_name"			=>	$name,
					 "gene_surname"			=>	$sur_name,
					 "gene_nickname"		=>	$nick_name,
					 "gene_sex"				=>	$gender,
					 "gene_birthday"		=>	$newformat,
					 "gene_place_birth"		=>	$place_of_birth,
					 "gene_deathday"        =>	$newdeath,
					 "gene_in_life"         =>	$alive,
					 "gene_resident_in"     =>	$resident,
					 "gene_cap"             =>	$cap,
					 "gene_city"            =>	$city,
					 "gene_province"        =>	$province,
					 "gene_nation"          =>	$country,
					 "gene_telephone_home"  =>	$house,
					 "gene_telephone_office"=>	$office,
					 "gene_mobile_no_1"     =>	$mobile,
					 "gene_email_office"    =>	$ofemail,
					 "gene_email_personel_1"=>	$premail,
					 "gene_publish_tree"    =>	$publish,
					 "gene_publish_app"     =>	$showtab,
					 "gene_image"           =>	$img,
					 "gene_relation_type"	=>	$relation_type,
					 "gene_marriage_year"   =>  $mrgformat,
					 "gene_rel_id_1"		=>	$gene_rel_id_1,
					 "gene_rel_id_2"		=>	$gene_rel_id_2,
					 "gene_generation"		=>	$generation_num,
					 "LastModifiedTime"     =>  date('Y-m-d H:i:s'),
					 "Trash"				=>	'1',
					 "label1"				=>  $free1,
		             "value1"				=>  $fre1,
					 "label2"				=>  $free2,
					 "value2"				=>  $fre2,
					 "label3"				=>  $free3,
					 "value3"				=>	$fre3,
					 "gene_publish_father_name"	=>  $publish_father_name,
					 "gene_publish_year"	=>	$publish_year,
					 "threshold_status"     =>  $NoticationStatus

				);
	if($gene_user_id == 0){	
		$logtext 		=	$name.' '.$sur_name.' Utente Famgilia Boroli Aggiornato con successo';
		logInsert(1, 5, $logtext);
		$insert_user	=	$objUser->insertUser($insertArray);
		$last_id		=	mysql_insert_id();
		echo $last_id; exit;
	}
	else if($gene_user_id > 0){
		$logtext 			=	$name.' '.$sur_name.' Utente Famgilia Boroli Aggiornato con successo';
		logInsert(1, 6, $logtext);
		$insert_user	=	$objUser->editUser($insertArray, $gene_user_id);
		echo $gene_user_id;exit;
	}
}

function gene_root_check($db){
	$query_check	=	"SELECT * FROM tab_gene_user WHERE gene_relation_type = 1";
	$query_check	=	mysql_query($query_check);
	if(mysql_num_rows($query_check) > 0)
	{
		$result_array	=	mysql_fetch_array($query_check);
		$result			=	$result_array['gene_user_id'];
	}
	else
	{
		$result	=	0;
	}
	return	$result;
}	

function marriage_year_date($year,$month,$day){

       if($year=='aaaa'){
       	  $year = '0000';
       }
       if($month=='mm'){
       	 $month = '00';
       }
       if($day == 'gg'){
       	 $day = '00';
       }
    return $year.'-'.$month.'-'.$day;
}
?>