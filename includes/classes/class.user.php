<?php

class user 
{
    // Function for creating database connection......................
    function __construct()
	{
		
		$this->db = new database();
		$this->now = date("Y-m-d");
		if (!$this->db->dbConnect())
		"Error Connection" . $this->db->ErrorInfo;
		//bool PDO::beginTransaction ( void );
	}

	function insertUserdetail($insertArray) 
	{  
		
		$res = $this->db->insertQuery('tab_user',$insertArray);
		return $res;
	}
	
	function getUser($user_id) {      
        $sql = "SELECT * FROM tab_user WHERE user_id ='".$user_id."' ";   
		 
        $res = $this->db->readValues($sql); //echo $sql;
		if(count($res) > 0) {
			return $res[0];
		}
    }
	function user_detail($email)
	{
		$sql = "SELECT * FROM tab_user WHERE email ='".$email."' ";       
        $res = $this->db->readValues($sql); //echo $sql;
		if(count($res) > 0) {
			return $res[0];
		}
	}
	function check_user($username,$password) {      
        $sql = "SELECT user_id FROM tab_user WHERE sys_user_name ='".$username."' and sys_password = '".$password."' "; 
		$res = $this->db->readValues($sql); 
		if(count($res) > 0) {
			return $res[0];
		}
    }
	function check_user_email($email) {      
        $sql = "SELECT * FROM tab_user WHERE sys_email ='".$email."' and Trash ='1' "; 
		$res = $this->db->readValues($sql); 
		return count($res);
		
    }
	function check_user_id($email,$userid) { 

        $sql = "SELECT * FROM tab_user WHERE (sys_email='".$email."' AND user_id!='".$userid."' AND Trash='1')";
		$res = $this->db->readValues($sql); 
		return count($res);
		
    }
    function check_email_id($email,$userid) { 
       
        $sql = "SELECT * FROM tab_user WHERE (sys_email='".$email."' AND gene_user_id!='".$userid."' AND Trash='1')";
		//echo $sql;exit;
		$res = $this->db->readValues($sql); 
		return count($res);
		
    }
    function check_user_emailids($email,$user_id) { 

        $sql = "SELECT * FROM tab_user WHERE (sys_email='".$email."' AND user_id!='".$user_id."' AND sys_is_a_member='0' AND Trash='1')";
		$res = $this->db->readValues($sql); 
		return count($res);
		
    }
    function  check_exist_id($user_id,$userid) {
        
    	$sql = "SELECT * FROM tab_user WHERE (user_id!='".$user_id."' AND gene_user_id='".$userid."' AND Trash='1')";
    	$res = $this->db->readValues($sql);
    	return count($res);

    }

	function check_user_temp_password($email) {      
        $sql = "SELECT * FROM tab_user WHERE md5(email) ='".$email."'"; 
		$res = $this->db->readValues($sql); 
		if(count($res) > 0) {
			return $res[0];
		}
		
    }
	function deleteBasic($basic_id) {   
		$update_array = array("basic_trash_flag"=>1);
		$res = $this->db->updateQuery('tab_basic',$update_array," basic_id=".$basic_id);
        return $basic_id;
    }

	function getUserDetails($condition,$pageName,$limit,$page) 
	{
	
		//$sql = "SELECT DISTINCT tab_basic.*,tab_library.library_file FROM tab_library,tab_basic WHERE tab_library.library_id = tab_basic.library_id ";	
		//$sql	=	"SELECT * FROM(SELECT DISTINCT tab_basic.*,tab_library.library_file FROM tab_library,tab_basic WHERE tab_library.library_id = tab_basic.library_id UNION SELECT DISTINCT tab_basic.*,  NULL AS library_file FROM tab_basic WHERE tab_basic.library_id IS NULL)tab_basic";
		$sql	=	"SELECT * FROM tab_user";
		if ($condition) {
		$sql .= " WHERE " . $condition;
		}
		//echo $sql;
		$res = $this->db->readValues($sql); //echo $sql;
		$total = count($res);
		$limit = ($limit) ? $limit : 30;
		$page = ($page) ? $page : 1;
		$pager = $this->db->getPagerData($total, $limit, $page); 
		if ($total > 0) {
		if ($order_by) {
		$sql.="  ORDER BY " . $order_by;
		} else {
		$sql.=" ORDER BY tab_user.user_id DESC";
		}
		$sql.="  limit $pager->offset, $pager->limit "; //echo $sql;
		$listing = $this->db->readValues($sql);
		}
		//echo $sql;
		$count = count($listing);
		$paginationTable = $this->db->getPaginationTable($pageName, $filterqry, $page, $limit, $count, $total);
		return array("listing" => $listing, "paginationTable" => $paginationTable);
	}
	function updateUserdetails($update_array,$user_id)
	{    
	
		$res = $this->db->updateQuery('tab_user',$update_array," user_id=".$user_id);
		return $user_id;
	}
	function getBasicList($type)
	{
		$sql = "SELECT basic_id, basic_title FROM tab_basic WHERE basic_trash_flag = 0 AND basic_type =".$type." ORDER BY basic_title";  
		$res = $this->db->readValues($sql); //echo $sql;
		if(count($res) > 0) {
			return $res;
		}
	}
	function restoreBasic($basic_id) {    	
		$update_array = array("basic_trash_flag"=>0);
		$res = $this->db->updateQuery('tab_basic',$update_array," basic_id=".$basic_id); 
        return $basic_id;
    }

	function deleteUserdetail($user_id) { 
		$res = $this->db->deleteQuery('tab_creativity',"user_id=".$user_id);
		$res = $this->db->deleteQuery('tab_feedback',"user_id=".$user_id);
        $res = $this->db->deleteQuery('tab_user'," user_id=".$user_id);
        return $res;
    }
	function unlinkImage($basic_id)
	{
		$update_array = array("library_id"=>NULL);
		$res = $this->db->updateQueryToNull('tab_basic',$update_array," basic_id=".$basic_id); 
        return $item_id;
		
	}
	function getBasicType()
	{
		$sql = "SELECT DISTINCT basic_type FROM tab_basic";
		$res = $this->db->readValues($sql); //echo $sql;
		if(count($res) > 0) {
			return $res;
		}
	}
	function changePassword($newpassword, $user_id,$current_password)
	{
		$sql = "SELECT * FROM tab_user WHERE user_id = '".$user_id."' and password = '".md5($current_password)."'";
		$res = $this->db->readValues($sql);
		if(count($res) > 0) 
		{
			$sql1 = "UPDATE tab_user SET password = '".md5($newpassword)."' WHERE user_id = '".$user_id."'";
			$updateres = mysql_query($sql1) or die(mysql_error());
		}
		else
		{
			$updateres = 0;
		}
		
		return $updateres;	
	}
	function reset_password_temp($email,$temp_password)
	{
			$sql1 = "UPDATE tab_user SET temp_password = '".md5($temp_password)."' WHERE email = '".$email."'";
			$update_temp_passwrd = mysql_query($sql1) or die(mysql_error());
			return $update_temp_passwrd;
	}
	function password_reset($new_password,$user_id)
	{
			$sql1 = "UPDATE tab_user SET password = '".md5($new_password)."',temp_password=NULL  WHERE user_id = '".$user_id."'";
			$update_new_passwrd = mysql_query($sql1) or die(mysql_error());
			return $update_new_passwrd;
	}
    /*tab_user function*/
    function userexist($userid,$username,$appemail)
	{
      $sql="select * from tab_user WHERE ((gene_user_id='".$userid."' OR sys_user_name ='".$username."' OR sys_email = '".$appemail."') AND  (Trash ='1'))";          
      $res = $this->db->readValues($sql); //echo $sql;		
        if(count($res) > 0) {
			return $res;
		}
	}
    
	function userdetail()
    {
		$sql="select  * from tab_user ORDER BY tab_user.user_id DESC";
        $res = $this->db->readValues($sql);
        if(count($res) > 0)
		{
			return $res;
		}
	}

   function appuserdetail($useid)
  {
	  $sql    = "select * from tab_user Where user_id='".$useid."'";
	  $res    = mysql_query($sql) or die(mysql_error());
	  $row    = mysql_fetch_array($res);
	  return $row;
  }

  function get_tab_user_details($condition="", $pageName="",$limit="",$page="", $order_by="") 
	{
		$sql	=	"SELECT * FROM tab_user";
		
		if ($condition) {
       
		$sql .= " WHERE " . $condition;
		}
		$res = $this->db->readValues($sql); 
		$total = count($res);
		
		$limit = ($limit) ? $limit : 10;
		
		$page = ($page) ? $page : 1;

		$pager = $this->db->getPagerData($total, $limit, $page); 
		
		if ($total > 0) {
			if ($order_by) {
				
				$sql.="  ORDER BY " . $order_by;
				
			} else {
				$sql.=" ORDER BY tab_user.user_id ASC";
			}	
			$sql.="  limit $pager->offset, $pager->limit "; //echo $sql;
			$listing = $this->db->readValues($sql);
			
		}
		
		$count = count($listing);
		$paginationTable = $this->db->getPaginationTable($pageName, $filterqry, $page, $limit, $count, $total);
		//print_r($paginationTable);exit;
		$userlist= array("listing" => $listing, "paginationTable" => $paginationTable);
		//print_r($userlist);exit;
		return $userlist;
	}
   function deleteUser($trash,$user_id) 
   {  
	   
		$sql = "Update tab_user SET Trash='$trash' WHERE user_id=".$user_id;
		//echo $sql;exit;
        $res = $this->db->executeQuery($sql);
        return $res;
    }
	/*create json for login check*/
	function loginJsoncheck($username,$password)
	{		
      $sql    = "SELECT * from tab_user Where sys_user_name='".$username."' AND sys_password ='".$password."' AND sys_active='1' AND Trash='1'";
	  $res    = mysql_query($sql) or die(mysql_error());
	  if(mysql_num_rows($res) > 0)
	  {
			$row    = mysql_fetch_array($res);
			return $row;		
	  }
	  else
			return 0;
	  //$row    = mysql_fetch_array($res);
	  //return $row;
	}
    
    function check_appuser_email($email) {      
        $sql = "SELECT * FROM tab_user WHERE sys_email ='".$email."' AND Trash='1'"; 
		$res = $this->db->readValues($sql); 
		if(count($res) > 0) {
			return $res[0];
		}
		
    }
	function check_users($username, $password) {      
        $sql = "SELECT * FROM tab_user WHERE sys_user_name='".$username."' and sys_password = '".$password."'"; 
        //echo $sql;exit;
		$res = $this->db->readValues($sql); 
		if(count($res) > 0) {
			return $res[0];
		}
    }

	function password_resets($new_password,$user_id)
	{
			$sql1 = "UPDATE tab_user SET sys_password ='".$new_password."' WHERE user_id = '".$user_id."'";
			$update_new_passwrd = mysql_query($sql1) or die(mysql_error());
			return $update_new_passwrd;
	}

	function getusers($userid)
	{
      $sql = "SELECT * FROM  tab_user WHERE gene_user_id=".$userid;
      
	  $res = $this->db->readValue($sql); 
      if(count($res) > 0) 
	  {
		return $res;
	  }
	} 

}

?>
 