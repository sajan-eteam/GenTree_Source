<?php
function convertDate($source, $type)
{	
		//$type =	'Y/m/d H:i:s';
		//$source = '3/28/2012  10:16:27 PM';
		$date = new DateTime($source);		
		//return $date->format('Y/m/d H:i:s');
		return $date->format($type);
}
function getCleanString($string) {

	return stripslashes(html_entity_decode($string,ENT_COMPAT, "UTF-8"));
}

function cleanString($string) {

	return addslashes(htmlentities($string, ENT_COMPAT, "UTF-8"));
}

function ranger($url){
    $headers = array(
    "Range: bytes=0-32768"
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}

?>