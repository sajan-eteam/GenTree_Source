<?php
//echo "Entry";
//error_reporting(E_ALL);
//ini_set('display_errors',1);
//set_time_limit(300);
//include"SimpleImage.php";
//include "json_functions.php";
//include "../includes/init_json.php";
//require 'Fastimage.php';


//include('../includes/eteamUtil.php');
//include "loggfile.php";
	#-----------------------------------#
	
	#-----------------------------------#

	

	/*if(!isset($_GET['hello'])) {
	    echo $f->send1();
	  }*/

	if(isset($_GET['isMessage'])) 
	{
		include "../includes/init_json.php";
		$f = new PushNotificationIOS();
	    $newMenuMessage  =   new instaimages();
	    
		if($_GET['isMessage']!="")
		{
			$message = $_GET['isMessage'];
			$type = $_GET['type'];
			//echo "hi";
			//exit;
			$pushnotificationn = $newMenuMessage->selectAllDevices();
			//echo "hi";
			//print_r($pushnotification);
			//exit;
  
            if($type=="0")
            {
               foreach($pushnotificationn as $pushnotifyy)
		        {

					$f->setDeviceTocken($pushnotifyy['device_tocken']);
					$f->setPassphrase('');
					$f->setMessage($message);
				    $f->sendToFamiglia($message);	
			    }
            }
            if($type=="1")
            {
               foreach($pushnotificationn as $pushnotifyy)
		        {

					$f->setDeviceTocken($pushnotifyy['device_tocken']);
					$f->setPassphrase('');
					$f->setMessage($message);
				    $f->sendToInstaFamily($message);	
			    }
            }
		}        
	}
	/*if(isset($_GET['isNoMessage'])){

		include "../includes/init_json.php";
		$f = new PushNotificationIOS();
	    $newMenuMessage  =   new instaimages();

	    $message = "New Implementation";

	    $pushnotificationn = $newMenuMessage->selectAllDevices();

	    foreach($pushnotificationn as $pushnotifyy)
        {
			$f->setDeviceTocken($pushnotifyy['device_tocken']);
			$f->setPassphrase('');
			$f->setMessage($message);
		    $f->send();	
	    }
	    
	}*/

	/*if(isset($_GET['isMessage'])) 
	{
		//echo "entry 1";
		if($_GET['isMessage']!="")
		{
			//echo "entry 2";
			echo $f->send($_GET['isMessage']);
		}
	    
	}  */




	class PushNotificationIOS{

		

	  

		public $deviceToken;
		public $passphrase;
		public $message;
		public $error;
		#setting device tocken
		public function setDeviceTocken($tocken){ 
			$this->deviceToken = $tocken;
		}
		#setting passphrase
		public function setPassphrase($pass){ 
			$this->passphrase = $pass;
		}
		#setting push notification messages
		public function setMessage($msg){ 
			$this->message = $msg;
		}
		/*#getting device tocken
		private function getDeviceTocken(){ 
			return $this->deviceToken;
		}
		#getting passphrase
		private function getPassphrase(){ 
			return $this->passphrase;
		}
		#getting push notification messages
		private function getMessage(){ 
			return $this->message;
		}*/

        #getting device tocken
		private function getDeviceTocken(){ 
			return $this->deviceToken;
			//return "4d84452342c16c6afb8097ce0896e53cb1240dc18f208aa75e15d153bdce910e";
			//return "f8403c35df8cfcf8b2616c366e0eead86e165fae912172b9030844d6a6c0e5d8";
		}
		#getting passphrase
		private function getPassphrase(){ 
			//return $this->passphrase;
			//return "Sample  Phrase";
			return "";
		}
		#getting push notification messages
		private function getMessage(){ 
			//return $this->message;
		     //return "Sample Message";
			//$msgArray  = array("s_id" => "s_id","u_id" => "u_id","status"=>"status");
			//return json_encode($msgArray); 
			return $this->message;
			
		}
		

		#sending push notification messages
		/*public function send(){

			$this->validate();
			if($this->error)
				return json_encode($this->error); 

			//$ckFilename = $_SERVER['DOCUMENT_ROOT'].'/dea_albero_2/includes/gentree.pem';
			$ckFilename = "gen_tree_insta_dev.pem";;
			
			////////////////////////////////////////////////////////////////////////////////
	 
                 $aContext = array(
                      'http' => array(
                          //'proxy' => '10.168.3.46:8888',
                      ),
                 );

			$ctx = stream_context_create($aContext);
			stream_context_set_option($ctx, 'ssl', 'local_cert', $ckFilename);
			stream_context_set_option($ctx, 'ssl', 'passphrase', $this->getPassphrase());
      		if(!$ctx){
      			echo "Failed to connect" . PHP_EOL;
      		}
	 
			// Open a connection to the APNS server
			$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	 
			if (!$fp)
				echo "Failed to connect: $err $errstr" . PHP_EOL;
	 
			//echo 'Connected to APNS' . PHP_EOL;
	 		$action = $this->getMessage();
			// Create the payload body
			$body['aps'] = array(
				"content-available" => "1",
			    'sound' => '',
				'data' => array(
			        'u_id' => $action['u_id'],
			        's_id' => $action['s_id'],
					'status'=>$action['status']
			    )
			);
			

			// Encode the payload as JSON
			$payload = json_encode($body);
			 
			// Build the binary notification
			$msg = chr(0) . pack('n', 32) . pack('H*', $this->getDeviceTocken()) . pack('n', strlen($payload)) . $payload;
			 
			// Send it to the server
			
       try{  
       		$result = fwrite($fp, $msg, strlen($msg));
				//echo $result;
			if(!$result){
				$res = json_encode(array('error'=>'Message not delivered' . PHP_EOL));
			}else{
				$res = "1";
			}
			fclose($fp);
		}catch(Exception $e){
			fclose($fp);
	     }

		return $res;
		}*/






		public function sendToFamigliaSilent()
        {
        	$isDevelopment = true;
			 
			if($isDevelopment == true)
			{
               $apnsHost = 'gateway.sandbox.push.apple.com';
		       $apnsPort = 2195;
		       $apnsCert = "gen_tree_dev.pem";
			}
			else
			{
               $apnsHost = 'gateway.push.apple.com';
		       $apnsPort = 2195;
		       $apnsCert = "gen_tree_prod.pem";
			}
            
            $pushMessage = "";

			//echo "1 - ".$pushMessage;

		    /*$apnsHost = 'gateway.sandbox.push.apple.com';
		    $apnsPort = 2195;
		    //$apnsCert = $_SERVER['DOCUMENT_ROOT'].'/dea_albero_2/includes/gentree.pem';gentreetest.pem
		    $apnsCert = "gentreetest.pem";*/


		    $streamContext = stream_context_create();
		    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);

		    $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);

            $action = $this->getMessage();

            $payload['aps'] = array(
				"content-available" => "1",
			    'sound' => '',
				'data' => array(
			        'u_id' => $action['u_id'],
			        's_id' => $action['s_id'],
					'status'=>$action['status']
			    )
			);

		    //$payload['aps'] = array('alert' => $pushMessage, 'badge' => 0, 'sound' => 'none');
		    //$payload['aps'] = array('content-available' => 1, 'sound' => '');
		    $payload = json_encode($payload);

		// Note: $device_tokens_array has list of 5 devices' tokens

		    for($i=0; $i<1; $i++)
		    	//echo "ok";
		    {
		    	//echo "2 - ".$pushMessage;
		            $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $this->getDeviceTocken())) . chr(0) . chr(strlen($payload)) . $payload;
		            //print_r($apnsMessage);
		            fwrite($apns, $apnsMessage);
		    }
		}





		public function sendToInstaFamilySilent()
        {
        	$isDevelopment = true;
			 
			if($isDevelopment == true)
			{
               $apnsHost = 'gateway.sandbox.push.apple.com';
		       $apnsPort = 2195;
		       $apnsCert = "gen_tree_insta_dev.pem";
			}
			else
			{
               $apnsHost = 'gateway.push.apple.com';
		       $apnsPort = 2195;
		       $apnsCert = "gen_tree_insta_prod.pem";
			}
            
            $pushMessage = "";

			//echo "1 - ".$pushMessage;

		    /*$apnsHost = 'gateway.sandbox.push.apple.com';
		    $apnsPort = 2195;
		    //$apnsCert = $_SERVER['DOCUMENT_ROOT'].'/dea_albero_2/includes/gentree.pem';gentreetest.pem
		    $apnsCert = "gentreetest.pem";*/


		    $streamContext = stream_context_create();
		    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);

		    $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);

            $action = $this->getMessage();

            $payload['aps'] = array(
				"content-available" => "1",
			    'sound' => '',
				'data' => array(
			        'u_id' => $action['u_id'],
			        's_id' => $action['s_id'],
					'status'=>$action['status']
			    )
			);

		    //$payload['aps'] = array('alert' => $pushMessage, 'badge' => 0, 'sound' => 'none');
		    //$payload['aps'] = array('content-available' => 1, 'sound' => '');
		    $payload = json_encode($payload);

		// Note: $device_tokens_array has list of 5 devices' tokens

		    for($i=0; $i<1; $i++)
		    	//echo "ok";
		    {
		    	//echo "2 - ".$pushMessage;
		            $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $this->getDeviceTocken())) . chr(0) . chr(strlen($payload)) . $payload;
		            //print_r($apnsMessage);
		            fwrite($apns, $apnsMessage);
		    }
		}






        public function sendToFamiglia($pushMessage)
        {
        	$isDevelopment = true;
			 
			if($isDevelopment == true)
			{
               $apnsHost = 'gateway.sandbox.push.apple.com';
		       $apnsPort = 2195;
		       $apnsCert = "gen_tree_dev.pem";
			}
			else
			{
               $apnsHost = 'gateway.push.apple.com';
		       $apnsPort = 2195;
		       $apnsCert = "gen_tree_prod.pem";
			}

			//echo "1 - ".$pushMessage;

		    /*$apnsHost = 'gateway.sandbox.push.apple.com';
		    $apnsPort = 2195;
		    //$apnsCert = $_SERVER['DOCUMENT_ROOT'].'/dea_albero_2/includes/gentree.pem';gentreetest.pem
		    $apnsCert = "gentreetest.pem";*/


		    $streamContext = stream_context_create();
		    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);

		    $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);

		    $payload['aps'] = array('alert' => $pushMessage, 'badge' => 0, 'sound' => 'none');
		    $payload = json_encode($payload);

		// Note: $device_tokens_array has list of 5 devices' tokens

		    for($i=0; $i<1; $i++)
		    	//echo "ok";
		    {
		    	//echo "2 - ".$pushMessage;
		            $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $this->getDeviceTocken())) . chr(0) . chr(strlen($payload)) . $payload;
		            //print_r($apnsMessage);
		            fwrite($apns, $apnsMessage);
		    }
		}

		public function sendToInstaFamily($pushMessage)
        {
        	$isDevelopment = true;
			 
			if($isDevelopment == true)
			{
               $apnsHost = 'gateway.sandbox.push.apple.com';
		       $apnsPort = 2195;
		       $apnsCert = "gen_tree_insta_dev.pem";
			}
			else
			{
               $apnsHost = 'gateway.push.apple.com';
		       $apnsPort = 2195;
		       $apnsCert = "gen_tree_insta_prod.pem";
			}

			//echo "Yes";
		    //$apnsHost = 'gateway.push.apple.com';

		    /*$apnsHost = 'gateway.sandbox.push.apple.com';
		    $apnsPort = 2195;
		    //$apnsCert = $_SERVER['DOCUMENT_ROOT'].'/dea_albero_2/includes/gentree.pem';gentreetest.pem
		    $apnsCert = "gentreetestinsta.pem";*/

		    $streamContext = stream_context_create();
		    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);

		    $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);

		    $payload['aps'] = array('alert' => $pushMessage, 'badge' => 0, 'sound' => 'none');
		    $payload = json_encode($payload);

		// Note: $device_tokens_array has list of 5 devices' tokens

		    for($i=0; $i<1; $i++)
		    	//echo "ok";
		    {
		            $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $this->getDeviceTocken())) . chr(0) . chr(strlen($payload)) . $payload;
		            //print_r($apnsMessage);
		            fwrite($apns, $apnsMessage);
		    }
		}

		#validaing fields
		private function validate(){
			$this->error = '';
			if(!$this->getDeviceTocken()){
				$this->error['deviceToken'] = "Device tocken not specified";
			}
			/*if(!$this->getPassphrase()){
				$this->error['passphrase'] = "Passphrase not specified";
			}*/
			if(!$this->getMessage()){
				$this->error['message'] = "Message not specified";
			}
		}
	}

?>