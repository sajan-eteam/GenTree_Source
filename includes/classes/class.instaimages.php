<?php

class instaimages 
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

	function insertImagedetail($insertArray) 
	{  
		
		$res = $this->db->insertQuery('tab_insta_images',$insertArray);
		return $res;
	}

	function updateImagedetails($update_array,$image_id)
	{    
	
		$res = $this->db->updateQuery('tab_insta_images',$update_array,"id_image=".$image_id);
		return $image_id;
	}
    
	function imagelist($condition="",$order_by="")
    {
		$sql="select  * from tab_insta_images";
		if ($condition) {
		$sql .= " WHERE " . $condition;
		}
        $res = $this->db->readValues($sql);
        if (count($res) > 0) {
			if ($order_by) {
			$sql.="  ORDER BY " . $order_by;

			} else {
				$sql.=" ORDER BY tab_insta_images.LastModifiedTime DESC";
			}	
			
			$listing = $this->db->readValues($sql);
			return $listing;
		}
	}
	 function deleteImage($image_id) 
	{  
			$sql	=	"Delete from tab_tags where id_image =".$image_id;
			$res 	= 	$this->db->executeQuery($sql);
		    $sql	=	"Delete from tab_insta_images where id_image =".$image_id;
            $res 	= 	$this->db->executeQuery($sql);
            return $res;
    }
	function imageview($image_id)
	{
       $sql		="select  * from tab_insta_images WHERE id_image=".$image_id;
	   $res    = mysql_query($sql) or die(mysql_error());
	   $row    = mysql_fetch_array($res);
	   return $row;

	}
	
	function getGallery($gallery_id)
	{
			$sql="SELECT * FROM tab_gallery WHERE id_gallery =".$gallery_id;
			//echo $sql;exit;
			$res    = mysql_query($sql) or die(mysql_error());
			$row    = mysql_fetch_array($res);
			return $row['gallery_title'];
	}


/* create json object for images*/
  function allImages()
	{
		$sql="select id_gallery, id_image, image_src, image_title, image_description, image_date from tab_insta_images";
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}

	}
 function  tab_insta_images()
	{
		$sql="select id_image,image_src from tab_insta_images";
		
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}

	}

 function allImageslist($lastimage_time,$time)
	{
		$sql="select id_gallery,id_image,image_src from tab_insta_images where (LastModifiedTime='$lastimage_time'>'$time')";
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}

	}
  function getGallerylist($gallery_id)
	{
			$sql="SELECT * FROM tab_gallery WHERE id_gallery='$gallery_id'";
		
			$res    = mysql_query($sql) or die(mysql_error());
			$row    = mysql_fetch_array($res);
			return $row['gallery_title'];
	}

	/*function  tab_insta_images()
	{
		$sql="select id_image,image_src from tab_insta_images";
		
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}

	}*/

   function  imagetimelist()
  {
	    $sql="select * from tab_insta_images";
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}

  }
  function getgaldetails()
  {
		$sql    ="select * from tab_gallery";
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
		return $res;
	   }
  }

 function galleryImages($album_id, $condition="")
	{
		/*
		login time : all the data with trash = 1 and image_publish 1  (delStatus = publish)  
		sync time  : all the data with trash = 1 and Trash = 0  : Bijin
		sync time  : if image publish = 0, make response status delStatus = 0  : jojin
					 if image publish = 1, make response status delStatus = 1 only if trash = 1 : jojin
		Date  : 13-11-2013
		*/
		$sql="select * from tab_insta_images WHERE id_gallery =".$album_id;
		if($condition) {
         		 //$sql .= " AND ((LastModifiedTime >'".$condition."') AND (Trash='1' OR Trash='0') AND (image_publish='1'))"; //commented on 13-11-2013 as per Jojin's requiremnet
         		 $sql .= " AND (LastModifiedTime >'".$condition."')";			 
		}
		else
		{
				 $sql .= " AND Trash='1' AND image_publish='1'";
		}

		$res = $this->db->readValues($sql); 
		if(count($res)> 0 ) {
            return $res;
		}
		
	}
 function getGalleryLists()
  {
		$sql    ="select * from tab_gallery";
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
		return $res;
	   }
  }

   function deleteTrashImage($trash,$deletetime,$image_id) 
	{  
			$sql	=	"UPDATE tab_tags SET Trash='$trash',LastModifiedTime='$deletetime' where id_image =".$image_id;
			$res 	= 	$this->db->executeQuery($sql);
		    $sql	=	"UPDATE tab_insta_images SET Trash='$trash',LastModifiedTime='$deletetime' where id_image =".$image_id;
            $res 	= 	$this->db->executeQuery($sql);
            $sql	=	"DELETE FROM tab_like WHERE image_id=".$image_id;
            $res 	= 	$this->db->executeQuery($sql);
            return $res;
    }
	function getImages($image_id)
	{
		$sql    ="select * from tab_insta_images WHERE id_image =".$image_id;
		$res    = mysql_query($sql) or die(mysql_error());
		$row    = mysql_fetch_array($res);
		return $row['id_gallery'];
	}
	 function instaImages($condition="")
	{
		
		if($condition) {
         		 //$sql .= " AND ((LastModifiedTime >'".$condition."') AND (Trash='1' OR Trash='0') AND (image_publish='1'))"; //commented on 13-11-2013 as per Jojin's requiremnet
         		 $sql = "select * from tab_insta_images WHERE LastModifiedTime >'".$condition."'";			 
		}
		else
		{
				 $sql = "select * from tab_insta_images WHERE Trash='1' AND image_publish='1'";
		}

		$res = $this->db->readValues($sql); 
		if(count($res)> 0 ) {
            return $res;
		}
		
	}

	function getImageDetails($image_id)
	{
		$sql    ="select * from tab_insta_images WHERE id_image =".$image_id;
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 ) {
            return $res[0];
		}
		
	}
	
	function getInstaImgAllusers($condition=""){

		 $sql = "select DISTINCT user_id from tab_insta_images WHERE LastModifiedTime >'".$condition."' AND Trash = '1' ";
		 $res = $this->db->readValues($sql); 
		 if(count($res)> 0 ) {
	        return $res;
		}
	}	

	function insertDevice($insertArray){
	  $res = $this->db->insertQuery('tab_device',$insertArray);
		return $res;
	}

   function updateDevice($update_array,$device_id){    
		$res = $this->db->updateQuery('tab_device',$update_array,"device_id=".$device_id);
		return $device_id;
	}
	function selectAllDevice($device_id){
		$sql = "select * from tab_device where device_id!='".$device_id."' ";
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 ) {
            return $res;
		}
	}

    function selectAllDevices(){
    	echo "selectAllDevices";
		$sql = "select * from tab_device";
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 ) {
            return $res;
		}
	}

}