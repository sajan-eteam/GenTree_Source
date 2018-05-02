<?php

class testi 
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

	function insertTextdetail($insertArray) 
	{  
		
		$res = $this->db->insertQuery('tab_texts',$insertArray);
		return $res;
	}

    function getTestidata($text_id)
	{
       $sql = "select * from tab_texts Where text_id=".$text_id;
	  
	   $res = $this->db->readValues($sql);
		 if(count($res)>0)
		 {
		   return $res;
		 }

	}
    
	function updateTextdetails($update_array,$text_id)
	{    
		$res = $this->db->updateQuery('tab_texts',$update_array," text_id=".$text_id);
		return $text_id;
	}


	 function txtexist($txt_id)
	{
      $sql="select * from tab_texts WHERE text_id=".$txt_id;          
      $res = $this->db->readValues($sql); //echo $sql;		
        if(count($res) > 0) {
			return $res;
		}
	}
    function GetAllTestiDetails($condition)
	{
      $sql="SELECT * FROM tab_texts WHERE (text_id='2' OR text_id='3')";
	  /*if($condition)
	  {
		$sql.="  AND LastModifiedTime >'".$condition."'";
	  }
	  else
		{
			$sql;
		}*/
      $res = $this->db->readValues($sql); //echo $sql;		
      if(count($res) > 0) {
		return $res;
		}
	}



}	