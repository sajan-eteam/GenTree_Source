<?php
include "../includes/init.php";
include "loggfile.php";	
 $objtesti          =  new testi();
 $title 			=	mysql_real_escape_string($_POST['title']); 
 $title 			=	$_POST['title']; 
 $description		=	mysql_real_escape_string($_POST['desc']);
 $mode				=   $_POST['mode'];
 $textid			=	$_POST['textid'];

 //echo $description; 

 $tit_le			=	htmlentities($title, ENT_COMPAT, "UTF-8");
 $desc_ription		=	html_entity_decode($description);

 $desc_ription		=	get_rid_of_mso_junk($desc_ription);
 $desc_ription		=	clean_content( $desc_ription );
 $desc_ription		=	clean_content( $desc_ription );

 //echo  "TEST2".$desc_ription; exit;

 $desc_ription		=	htmlentities($desc_ription);



 $txt_id			=   $_POST['txt_id'];
 $textidexist		=	$objtesti->txtexist($textid);
 $txtids			=	count($textidexist);

 $msg 				=	0;
if($textid=='4'){
	$tit_le = 'Email';
	$desc_ription = $_POST['title'];
}
if($textidexist[0]['text_id'] > 0) {
	$msg = 1;
}

if($title == '' ||  $description == '') {
	
			$status_msg = 'error'; 
}

else {	
			
			$insertArray		=	array(
										 "text_id"				=>  $textid,
										 "text_title"           =>	$tit_le,
										 "text_desc"		    =>	$desc_ription,
										 "LastModifiedTime"		=>  date('Y-m-d H:i:s')
				 );
			 if($msg == 0)			 
			 	$insert_testi		=   $objtesti->insertTextdetail($insertArray);
			 else if($msg == 1)
			 	$insert_testi		=   $objtesti->updateTextdetails($insertArray,$txt_id);
			 
			 $status_msg = 'success';	
}
$logtext = 'Testo aggiornato nella sezione "Testi" ';
logInsert(1, 6, $logtext);
echo $status_msg;

function get_rid_of_mso_junk($content){
	return preg_replace( '@(mso|panose)[^:]{1,25}:[^;]+;(\s+)?(\n+)?@i', '', $content );
}

function delete_between($beginning, $end, $string) {
    $beginningPos = strpos($string, $beginning);
    $endPos = strpos($string, $end);
    if (!$beginningPos || !$endPos) {
    	return $string;
    }

    $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

    return str_replace($textToDelete, '', $string);
}

function clean_content( $content ){
	
	//$pattern = "/<p[^>]*><\\/p[^>]*>/"; // regular expression
    $content = delete_all_between('<!--[if gte', ';}', $content);
    $content = delete_all_between('<!--[if !supportLists]', '<![endif]-->', $content);
   // $content = preg_replace($pattern, '', $content); 
    return $content;
}

function delete_all_between($beginning, $end, $string) {
  $beginningPos = strpos($string, $beginning);
  $endPos = strpos($string, $end);
  if (!$beginningPos || !$endPos) {
    return $string;
  }
  $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);
  return str_replace($textToDelete, '', $string);
}

?>