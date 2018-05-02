<?php
 function logInsert($userid, $logType, $logText){

   $objLog  		   =   new userlog();
   $insertLogArray    =  array(  'user_id' 			=> $userid,
							     'log_type' 		=> $logType,
							     'log_text'     	=> $logText,
							     'log_user_version' => '',
							     'log_time'			=> date('Y-m-d H:i:s'),
							);
   $insertLog  	= $objLog->insertLogDetail($insertLogArray);
   return $insertLogArray;
 }
?>