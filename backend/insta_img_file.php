<?php
session_start(); 
include("SimpleImage.php");
include "loggfile.php";
$simpleImage 	= 	new SimpleImage();
$width			=	'256';
$largeWidth 	=    '638';
$smallWidth 	=    '319';
$user_id 		=  $_SESSION['user_id'];
	//moving files from temp to upload
	$m= $_POST['m']; 
    $fileName = $_POST['filename'];
	$strutcure="../upload/";
	if($m=="move"){
		$fileNameNew	=	time().'_'.$user_id.'_'.$fileName;	
		$fileNameNew 	= 	preg_replace('/\s+/', '_' , $fileNameNew);	
		chmod ("../upload/".$fileName, 0777);
		if (copy("../temp/".$fileName,"../upload/".$fileNameNew)) {
		    unlink("../temp/".$fileName);
            $_SESSION['file']= $fileNameNew;
			$simpleImage->load("../upload/".$fileNameNew); 
			$simpleImage->resizeToWidth($width);
			$simpleImage->save("../upload/"."T_".$fileNameNew);
			$simpleImage->resizeToWidth($largeWidth);
			$simpleImage->save("../upload/"."TL_".$fileNameNew);
			$simpleImage->resizeToWidth($smallWidth);
			$simpleImage->save("../upload/"."TS_".$fileNameNew);
			$msg = 'Il file è stato caricato come'.$fileName;
			$logtext = 'InstaAlbum image Caricamento di una fotografia negli album avvenuta con successo.';
			logInsert(1, 14, $logtext);	
			echo $msg;			 
			exit;
		}
		else{
		  $_SESSION['file']= ''; 
		  $msg = "Spiacente, c'è stato un problema il caricamento del file";
		  $logtext = 'InstaAlbum image  Caricamento di una fotografia negli album fallito.';
		  logInsert(1, 14, $logtext);
		  echo $msg;		
		  exit;
	    }
	}
	$upload_dir = '../temp/';
	$allowed_ext = array('jpg','jpeg','png','gif');

	if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
		exit_status('Errore, errore http');
	}

	if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 ){		
		$pic = $_FILES['pic'];
		if(!in_array(get_extension($pic['name']),$allowed_ext)){
			exit_status('Only '.implode(',',$allowed_ext).' files are allowed!');
		}
		if($_FILES['pic']['size']>52428800){
          echo "large";
		  exit;
		}
	    $files = glob('../temp/*'); // get all file names
		foreach($files as $file){ // iterate files
		if(is_file($file))
			unlink($file); // delete file
		}
		// Move the uploaded file from the temporary 
		// directory to the uploads folder:
		if(move_uploaded_file($pic['tmp_name'], $upload_dir.$pic['name'])){ 
			exit_status('File caricato con successo!');
		}
	}
	exit_status('Errore durante l\'upload');
	
	function exit_status($str){
		echo json_encode(array('status'=>$str));
		exit;
	}
	function get_extension($file_name){
		$ext = explode('.', $file_name);
		$ext = array_pop($ext);
		return strtolower($ext);
	}

?>