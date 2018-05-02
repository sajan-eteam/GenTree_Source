<?php
class geneuser {
    // Function for creating database connection......................
	//table : tab_user
    function __construct() {
        $this->db = new database();
        $this->now = date("Y-m-d");
        if (!$this->db->dbConnect())
            "Error Connection" . $this->db->ErrorInfo;
		//bool PDO::beginTransaction ( void );
    }
	function insertUser($insertArray) {      
        $res = $this->db->insertQuery('tab_gene_user',$insertArray);
        return $res;
    }
	
	function editUser($insertArray,$user_id) {      
        $res = $this->db->updateQuery('tab_gene_user',$insertArray," gene_user_id=".$user_id);
        return $res;
    }
	function deleteUser($user_id) 
	{    
		$sql = "DELETE FROM tab_user WHERE gene_user_id=".$user_id;
        $res = $this->db->executeQuery($sql);
		
		$sql = "DELETE FROM tab_tags WHERE gene_user_id=".$user_id;
        $res = $this->db->executeQuery($sql);
        	
		$sql = "DELETE FROM tab_gene_user WHERE gene_user_id=".$user_id;
        $res = $this->db->executeQuery($sql);
        return $res;
    }
	function getUserDetail($user_id) 
		{       
		$sql = "SELECT * FROM tab_gene_user WHERE gene_user_id=".$user_id;
		$res = $this->db->readValues($sql); //echo $sql;		
        if(count($res) > 0) {
			return $res[0];
		}
    }
	function reltion($reltion)
	{
    $sql = "SELECT * FROM tab_gene_user WHERE gene_relation_type=".$reltion;
	//echo $sql;exit;
	$res = $this->db->readValue($sql); //echo $sql;		
        if(count($res) > 0) {
			return $res;
		}
	}
	function get_generation($user_id)
	{
		$sql = "SELECT gene_generation FROM tab_gene_user WHERE gene_user_id=".$user_id;
		$res = $this->db->readValue($sql); //echo $sql;		
			if(count($res) > 0) {
				return $res['gene_generation'];
			}
	}
    function familymember($condition="")
	{	
      $sql = "SELECT * FROM tab_gene_user";	  
	  if ($condition) 
	  {
		$sql .= " WHERE " . $condition;		
	  }	   
	  $res = $this->db->readValues($sql); 
	 
      if(count($res) > 0) 
	  {
		return $res;
	  }
    }
	
	function family_offsprings($condition="", $rootid, $wifeid)
	{
      $sql = "SELECT * FROM tab_gene_user WHERE (gene_relation_type = 1 OR gene_relation_type = 2) ";
	 
	 //AND (gene_user_id !='$rootid' OR gene_user_id !='$wifeid')
	  if ($condition) 
	  {
		$sql .= $condition;
		
	  }	 
	 //else
	//{
      //  $sql .= "AND gene_user_id =='1'";	
	 // }

	 //echo $sql; exit;
	  
	  $res = $this->db->readValues($sql); 
      if(count($res) > 0) 
	  {
		return $res;
	  }
    }

   function family_offspringss($condition="")
	{
      $sql = "SELECT * FROM tab_gene_user WHERE (gene_relation_type = 1 OR gene_relation_type = 2)";
	  if ($condition) 
	  {
		$sql .= " AND ".'gene_user_id!='.$condition;
		//echo $sql;exit;
	  }	 
	  $res = $this->db->readValues($sql); 
      if(count($res) > 0) 
	  {
		return $res;
	  }
    }

	function getuser($userid)
	{
      $sql = "SELECT * FROM tab_gene_user WHERE gene_user_id=".$userid;
	  $res = $this->db->readValue($sql); 
      if(count($res) > 0) 
	  {
		return $res;
	  }
	} 
		
	function romanNumerals($num) 
	{
		$n = intval($num);
		$res = '';
	 
		/*** roman_numerals array  ***/
		$roman_numerals = array(
					'M'  => 1000,
					'CM' => 900,
					'D'  => 500,
					'CD' => 400,
					'C'  => 100,
					'XC' => 90,
					'L'  => 50,
					'XL' => 40,
					'X'  => 10,
					'IX' => 9,
					'V'  => 5,
					'IV' => 4,
					'I'  => 1);
 
		foreach ($roman_numerals as $roman => $number) 
		{
			/*** divide to get  matches ***/
			$matches = intval($n / $number);
	 
			/*** assign the roman char * $matches ***/
			$res .= str_repeat($roman, $matches);
	 
			/*** substract from the number ***/
			$n = $n % $number;
		}
	 
		/*** return the res ***/
		return $res;
    }
	
	function get_gene_user_details($condition="", $pageName="", $order_by="") 
	{
		$sql	=	"SELECT * FROM tab_gene_user";
		if ($condition) {
		$sql .= " WHERE " . $condition;
		}
		$res = $this->db->readValues($sql); 
		$total = count($res);
		
		if ($total > 0) {
			if ($order_by) {
				$sql.="  ORDER BY " . $order_by;
			} else {
				$sql.=" ORDER BY tab_gene_user.gene_user_id ASC";
			}			
			$listing = $this->db->readValues($sql);
		}
		$count = count($listing);
		//return array("listing" => $listing);
		return $listing;
	}
/*for updating appuser*/
	function family_name($seluseid)
	{
		$sql =    "SELECT * from tab_gene_user where gene_user_id='".$seluseid."'";	
		$res    = mysql_query($sql) or die(mysql_error());
		$row    = mysql_fetch_array($res);
		return $row;
	}


	function user_tag()
	{
     $sql =    "SELECT * from tab_gene_user";
	
     $res = $this->db->readValues($sql); 
      if(count($res) > 0) 
	  {
		return $res;
	  }
	}

    function tagImageUserID($user_id)
	{
		
		$sql ="select * from tab_gene_user WHERE gene_user_id=".$user_id;
		
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}
	}

/* for create json object*/
	function allusers($condition="")
	{    
	   // $sql = "select gene_user_id,gene_generation,gene_name,gene_surname,gene_sex,gene_birthday,gene_deathday from tab_gene_user";
		$sql = "select * from tab_gene_user";
		if($condition)
		{
			$sql .=" "."WHERE"." "."LastModifiedTime > '$condition'";
			
		}
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}
	}
     function allpairs($condition="")
	{ 
		$sql="select gene_user_id, gene_rel_id_1 from tab_gene_user where gene_relation_type ='3'";
        if($condition)
		{
			$sql .= " AND "."LastModifiedTime >'$condition'";
			
		}
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}
	}
	function allchild($user_id,$spouse_id)
	{
		$sql="select gene_user_id from tab_gene_user where gene_relation_type='3' AND (gene_rel_id_1='$user_id' AND gene_rel_id_2='$spouse_id') OR (gene_rel_id_1='$spouse_id' AND gene_rel_id_2='$user_id')";
		
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}
	}
	function fathermother($user_id)
	{
      $sql="select  gene_user_id, gene_name,gene_surname,gene_sex,gene_rel_id_1 from tab_gene_user where gene_user_id='".$user_id."'";
	 
		$res    = mysql_query($sql) or die(mysql_error());
		$row    = mysql_fetch_array($res);
		return $row;
	}
	function motherrelation($user_id)
	{
      $sql="select  gene_user_id, gene_name,gene_surname,gene_sex,gene_rel_id_1 from tab_gene_user where gene_user_id='".$user_id."'";

		$res    = mysql_query($sql) or die(mysql_error());
		$row    = mysql_fetch_array($res);
		return $row;
	}
    function alluserslist($lastModified_time,$time)
	{
    
	    $sql = "select gene_user_id,gene_generation,gene_name,gene_surname,gene_sex,gene_birthday,gene_deathday from  tab_gene_user where (LastModifiedTime='$lastModified_time' > '$time')";
		
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}
	}

     function allpairslist($lastModified_time,$time)
	{ 
		
		$sql="select gene_user_id, gene_rel_id_1 from tab_gene_user where gene_relation_type ='3' OR (LastModifiedTime='$lastModified_time' > '$time')";
		
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}
	}
    function allchildlist($user_id,$spouse_id)
	{
		$sql="select gene_user_id from tab_gene_user where gene_relation_type='3' AND (gene_rel_id_1='$user_id' AND gene_rel_id_2='$spouse_id') OR (gene_rel_id_1='$spouse_id' AND gene_rel_id_2='$user_id')";
		
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}
	}









/*end of json create object*/

	function root() 
	{
		$sql	="select * from tab_gene_user";
		$res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res;
		}
	}
   function relationexist()
	{
      $sql	  = "select gene_user_id from tab_gene_user where gene_relation_type='1'";
	  $res    = mysql_query($sql) or die(mysql_error());
	  $row    = mysql_fetch_array($res);
	  return $row['gene_user_id'];
	}
   function relation_exist($rootid)
	{
	   $sql	="select gene_user_id from tab_gene_user where(gene_relation_type='3' AND gene_rel_id_1='$rootid')";
	   //echo $sql;exit;
	   $res = $this->db->readValues($sql); 
		if(count($res)> 0 )
		{
            return $res[0];
		}
	}
	function relationsearchid($rootid)
	{
		$sql	="select gene_user_id from tab_gene_user where(gene_relation_type='3'AND gene_rel_id_1='$rootid')"; 
		$res    = mysql_query($sql) or die(mysql_error());
	    $row    = mysql_fetch_array($res);
	    return $row['gene_user_id'];
	}
	

}
# Closing class geneuser
?>
 