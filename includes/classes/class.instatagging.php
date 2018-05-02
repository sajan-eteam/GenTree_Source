<?php
class instatagging
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

	function insertTagdetail($insertarray) 
	{  
		
		$res = $this->db->insertQuery('tab_insta_tags', $insertarray);
		return $res;
	}
	function updateTaggingdetails($update_array, $image_id)
	{  
		$res = $this->db->updateQuery('tab_insta_tags', $update_array, "id_tag=".$image_id);
		return $res;
	}

    function deletetagging($deltime,$image_id) 
    {  
		$sql = "UPDATE tab_insta_tags SET Trash='0',LastModifiedTime='$deltime' where id_image=".$image_id;
        $res = $this->db->executeQuery($sql);
        return $res;
    }
   function taggingDetails($id_image,$condition="")
   {
     $sql = "select * from tab_insta_tags where id_image=".$id_image;
	 if($condition)
			{
             $sql .= " AND ((LastModifiedTime >'".$condition."') AND (Trash='1' OR Trash='0'))";
			
			}
			else
	   {
				$sql .= " AND "."Trash='1'";
	   }

	 $res = $this->db->readValues($sql);
	 if(count($res)>0)
	 {
       return $res;
	 }
   }
  function getimageuserid($image_id)
	{
       $sql    = "select gene_user_id from tab_insta_tags WHERE id_image=".$image_id;       
	   $res = $this->db->readValues($sql);
		 if(count($res)>0)
		 {
		   return $res;
		 }

	}
  function taggingDetailslist($image_id,$lastimage_time,$time)
   {
     $sql = "select * from tab_insta_tags where (id_image='$id_image' OR LastModifiedTime='$lastimage_time'>'$time')";
	
	 $res = $this->db->readValues($sql);
	 if(count($res)>0)
	 {
       return $res;
	 }
   }
  function taggingtime()
 {
	$sql = "select * from  tab_insta_tags";
	$res = $this->db->readValues($sql);
	 if(count($res)>0)
	 {
	   return $res;
	 }

 }
  function deletetag($delstatus,$deltime,$image_id,$deluserid)
	{
       $sql	="UPDATE tab_insta_tags SET Trash='$delstatus',LastModifiedTime='$deltime' where (id_image ='$image_id' AND gene_user_id='$deluserid')";
	   $res 	= 	$this->db->executeQuery($sql);
        return $res;
	}
   function taggingupdatearray()
	{
    $sql = "select * from  tab_insta_tags where Trash='0'";
	
	$res = $this->db->readValues($sql);
	 if(count($res))
	 {
	   return $res;
	 }
	}
	function taggaddarray($image_id)
	{
      $sql = "select * from  tab_insta_tags where id_image=".$image_id." AND  Trash='1'";
	 
	  $res = $this->db->readValues($sql);
	  if(count($res))
	  {
	return $res;
	  }
	}
	function taguserID($image_id)
	{
      $sql = "select gene_user_id from  tab_insta_tags where id_image=".$image_id." AND  Trash='1'";
	 
	  $res = $this->db->readValues($sql);
	  if(count($res))
	  {
	  return $res;
	  }

	}

  function deviceTaggingUpdate($update_array, $tagId, $image_id, $tag_counter){
  	
		$res = $this->db->updateQuery('tab_insta_tags', $update_array, 'id_tag = '.$tagId.' AND id_image = '.$image_id.' AND tag_counter = '.$tag_counter.'');
		return $res;
   }

	function deviceTaggingDelete($update_array, $tagId, $image_id){

		$res = $this->db->updateQuery('tab_insta_tags', $update_array, 'id_tag = '.$tagId.' AND id_image = '.$image_id.'');
		return $res;
	}

	function getTagDetetion($image_id, $tag_detetion,$Trash=1){

		$sql = 'select * from tab_insta_tags where id_image='.$image_id.' AND tag_detetion='.$tag_detetion.' AND Trash='.$Trash.' ';
		$res = $this->db->readValues($sql);
		if(count($res)){
			return $res;
		}
	}

}

?>