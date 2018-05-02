<?php

class admin 
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

	function insertAdmindetail($insertArray) 
	{  
		
		$res = $this->db->insertQuery('tab_admin',$insertArray);
		return $res;
	}
	
	function getAdmin($tab_admin_id) {      
        $sql = "SELECT * FROM tab_admin WHERE tab_admin_id ='".$tab_admin_id."' ";       
        $res = $this->db->readValues($sql); //echo $sql;
		if(count($res) > 0) {
			return $res[0];
		}
    }
	function getMetaDetails() {      
        $sql = "SELECT tab_admin_meta_title,tab_admin_meta_discription,tab_admin_meta_key FROM tab_admin WHERE tab_admin_id";       
        $res = $this->db->readValues($sql); //echo $sql;
		if(count($res) > 0) {
			return $res[0];
		}
    }

	function getAdminDetails($condition="", $pageName="", $limit="", $page="", $order_by="") 
	{

		$sql	=	"SELECT * FROM tab_admin";
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
		$sql.=" ORDER BY tab_admin.tab_admin_id ASC";
		}
		$sql.="  limit $pager->offset, $pager->limit "; //echo $sql;
		$listing = $this->db->readValues($sql);
		}
		//echo $sql;
		$count = count($listing);
		$paginationTable = $this->db->getPaginationTable($pageName, $filterqry, $page, $limit, $count, $total);
		return array("listing" => $listing, "paginationTable" => $paginationTable);
	}
	function updateAdmindetails($update_array,$tab_admin_id)
	{    
	
		$res = $this->db->updateQuery('tab_admin',$update_array," tab_admin_id=".$tab_admin_id);
		return $tab_admin_id;
	}
	
	function deleteAdmindetail($tab_admin_id) { 
		
        $res = $this->db->deleteQuery('tab_admin'," tab_admin_id=".$tab_admin_id);
        return $res;
    }
	
}

?>
 