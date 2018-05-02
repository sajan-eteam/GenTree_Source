<?php

class like 
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

	function insertLikedetail($insertArray) 
	{  
		
		$res = $this->db->insertQuery('tab_like',$insertArray);
		return $res;
	}

	function updateLikedetail($update_array,$like_id)
	{    
	
		$res = $this->db->updateQuery('tab_like',$update_array,"like_id=".$like_id);
		return $image_id;
	}

	function instaLikeImages($id_image,$condition="")
	{
		$sql = "select * from tab_like where image_id='".$id_image."' AND last_modified > '".$condition."'";
	    $res = $this->db->readValues($sql);
		 if(count($res)>0)
		 {
	       return $res;
		 }
    }

    function getLikeImage($id_image, $user_id){

    	$sql = "select * from tab_like where image_id='".$id_image."' AND user_id ='".$user_id."'";
	    $res = $this->db->readValues($sql);
		 if(count($res)>0)
		 {
	       return $res;
		 }
    }	

    function getInstaAllusers($condition=""){

		 $sql = "select DISTINCT user_id,like_status from tab_like WHERE last_modified >'".$condition."' AND like_status = '1' ";
		 $res = $this->db->readValues($sql); 
		 if(count($res)> 0 ) {
	        return $res;
		}
		
	}
	
	function deletelike($image_id){
		$sql = "DELETE FROM tab_like WHERE image_id=".$image_id;
        $res = $this->db->executeQuery($sql);
        return $res;
	}
}