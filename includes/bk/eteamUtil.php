<?php
require "classes/class.phpmailer.php";
function eteam_sendMail($from, $to, $subject, $mailContent)
{
    $your_email =   $from;
    $email      =   $to;
    $first_name =   "Albero genealogico Famiglia Boroli";

    $your_smtp = "swmail";
	//$your_smtp = "localhost";
    $your_smtp_user = "root";
	//$your_smtp_user = "admin@thekidzparade.com";
    $your_smtp_pass = "";
	// $your_smtp_pass = "";
    $your_website = "Albero genealogico Famiglia Boroli";
    $url = "";

    //start phpmailer code

    $ip = $_SERVER["REMOTE_ADDR"];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $mail = new PHPmailer();
    $mail->IsSMTP();
    $mail->From     = $your_email;
    $mail->FromName = $your_website;
    $mail->Host     = $your_smtp;
    $mail->Mailer   = "smtp";
    $mail->Password = $your_smtp_pass;
    $mail->Username = $your_smtp_user;

    $mail->Subject = $subject;
    $mail->SMTPAuth  =  "true";
    $mail->IsHTML(true);

    $mail->Body = $mailContent;

    //$mail->AddEmbeddedImage('email_banner.jpg', 'banner', 'email_banner.jpg');
    $mail->AddAddress($email,"$your_website admin");
    $mail->AddReplyTo($your_email, $first_name);

    if (!$mail->Send())
    {
        echo "<p>There was an error in sending mail, please try again later</p>";
        echo "<p>".$mail->ErrorInfo."</p>";
    }
    else
    {
        //echo "<p>Mail Sent Successfully</p>";
	    $mail->ClearAddresses();
        $mail->ClearAttachments();
		return 1;
		//echo  "1" ;

    }
}

function eteam_mail_with_attachment($from, $to, $subject, $mailContent, $attachemnt_file)
{
    $your_email =   $from;
    $email      =   $to;
    $first_name =   "Dea-Albero";

    $your_smtp = "swmail";
	//$your_smtp = "localhost";
    $your_smtp_user = "root";
	//$your_smtp_user = "admin@thekidzparade.com";
    $your_smtp_pass = "";
	// $your_smtp_pass = "";
    $your_website = "Albero genealogico Famiglia Boroli";
    $url = "";

    //start phpmailer code

    $ip = $_SERVER["REMOTE_ADDR"];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $mail = new PHPmailer();
    $mail->IsSMTP();
    $mail->From = $your_email;
    $mail->FromName = $your_website;
    $mail->Host = $your_smtp;
    $mail->Mailer   = "smtp";
    $mail->Password = $your_smtp_pass;
    $mail->Username = $your_smtp_user;

    $mail->Subject = $subject;
    $mail->SMTPAuth  =  "true";
    $mail->IsHTML(true);

    $mail->Body = $mailContent;

    //$mail->AddEmbeddedImage('email_banner.jpg', 'banner', 'email_banner.jpg');
    $mail->AddAddress($email,"$your_website admin");
    $mail->AddReplyTo($your_email,$first_name);

	$mail->AddAttachment($attachemnt_file);

    if (!$mail->Send())
    {
        echo "<p>There was an error in sending mail, please try again later</p>";
        echo "<p>".$mail->ErrorInfo."</p>";
    }
    else
    {
        //echo "<p>Mail Sent Successfully</p>";
	    $mail->ClearAddresses();
        $mail->ClearAttachments();
		return 1;
		//echo  "1" ;

    }
}

function uploadFile()
{
	global $attachments;
	while(list($key,$value) = each($_FILES[images][name]))
	{
		if(!empty($value))
		{
			$filename = $value;
			//the Array will be used later to attach the files and then remove them from server ! array_push($attachments, $filename);
			$dir = "attachments/$filename";
			//chmod("attachments",0777);
			$success = copy($_FILES[images][tmp_name][$key], $dir);
		}
	}
	if ($success)
	{
		echo " Files Uploaded Successfully<BR>";
		//eteamMail($attachments ,$toName, $toAddr, $fromName, $fromAddr, $subject, $body);
	}
	else
	{
		exit("Sorry the server was unable to upload the files...");
	}
}

function checkType() 
{
	while(list($key,$value) = each($_FILES[images][type]))
	{
		strtolower($value);
		if($value != "image/jpeg" AND $value != "image/pjpeg" AND $value != "") 
		{
			exit('Sorry , current format is <b>'.($value).'</b> ,only Jpeg or jpg are allowed.') ;
		}
	}
	checkSize();
}
function checkSize()
{
	while(list($key,$value) = each($_FILES[images][size]))
	{
		$maxSize = 5000000;
		if(!empty($value))
		{
			if ($value > $maxSize)
			{
				echo"Sorry this is a very big file .. max file size is $maxSize Bytes = 5 MB";
				exit();
			}
			else 
			{
				$result = "File size is ok !<br>";
			}
		}
	}
	uploadFile();
}

function readTemplateFile($FileName)
{
	$fp = fopen($FileName,"r") or exit("Unable to open File ".$FileName);
	$str = "";
	while(!feof($fp))
	{
		$str .= fread($fp,1024);
	}
	return $str;
}




?>