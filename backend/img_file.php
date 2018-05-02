<?php
session_start(); 
include("SimpleImage.php");
$simpleImage 	= 	new SimpleImage();
$width			=	'256';
	//moving files from temp to upload
	$m= $_POST['m']; 
    $fileName = $_POST['filename'];
	$gallery  = $_POST['gallery'];
	

	$strutcure="../upload/";
	if($m=="move")
	{
		$fileNameNew	=	time().$fileName;	
		$fileNameNew 	= 	preg_replace('/\s+/', '', $fileNameNew);	
		chmod ("../upload/".$fileName, 0777);
		if (copy("../temp/".$fileName,"../upload/".$fileNameNew)) 
		{
		    unlink("../temp/".$fileName);
		    //$image=$strutcure.time().$fileName;
            $_SESSION['file']= $fileNameNew;

			$simpleImage->load("../upload/".$fileNameNew); 
			$simpleImage->resizeToWidth($width);
			//$simpleImage->scale(35);
			$simpleImage->save("../upload/"."T_".$fileNameNew);
			echo 'Il file è stato caricato come'.$fileName;		 
			exit;
		}
		else
		{
		  $_SESSION['file']= ''; 
		  echo "Sorry, there was a problem uploading your file.";
		  exit;
	    }
	}



//uploding
// Set the directory where files will be saved

	$upload_dir = '../temp/';
	$allowed_ext = array('jpg','jpeg','png','gif');

	if(strtolower($_SERVER['REQUEST_METHOD']) != 'post')
	{
		exit_status('Errore, errore http');
	}

	if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 )
	{		
		$pic = $_FILES['pic'];
		if(!in_array(get_extension($pic['name']),$allowed_ext))
		{
			exit_status('Only '.implode(',',$allowed_ext).' files are allowed!');
		}
		if($_FILES['pic']['size']>52428800)
		{
          echo "large";
		  exit;
		}
	    $files = glob('../temp/*'); // get all file names
		foreach($files as $file)
		{ // iterate files
		if(is_file($file))
			unlink($file); // delete file
		}
		// Move the uploaded file from the temporary 
		// directory to the uploads folder:
		if(move_uploaded_file($pic['tmp_name'], $upload_dir.$pic['name']))
		{ 
			/*
			$image->load($pic['name']); 
			$image->scale(35); 
            $image->save($upload_dir.time().'T_'.$pic['name']); */
			
			exit_status('File caricato con successo!');
		}
	}
	exit_status('Errore durante l\'upload');
	// Helper functions

	function exit_status($str)
	{
		echo json_encode(array('status'=>$str));
		exit;
	}

	function get_extension($file_name)
	{
		$ext = explode('.', $file_name);
		$ext = array_pop($ext);
		return strtolower($ext);
	}

?>