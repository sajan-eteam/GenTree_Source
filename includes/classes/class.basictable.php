<?php

class basictable 
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

	function insertBasictable($insertArray) 
	{  
		$res = $this->db->insertQuery('inventory',$insertArray);
		return $res;
	}
	
	function getBasicDetail($basic_id) {      
        $sql = "SELECT * FROM inventory WHERE idInventory ='".$basic_id."' ";       
        $res = $this->db->readValues($sql); //echo $sql;
		if(count($res) > 0) {
			return $res[0];
		}
    }
	function deleteBasic($basic_id) {   
		$update_array = array("basic_trash_flag"=>1);
		$res = $this->db->updateQuery('tab_basic',$update_array," basic_id=".$basic_id);
        return $basic_id;
    }

	function getBasicTable($condition="", $pageName="", $limit="", $page="", $order_by="") 
	{
		//$sql = "SELECT DISTINCT tab_basic.*,tab_library.library_file FROM tab_library,tab_basic WHERE tab_library.library_id = tab_basic.library_id ";	
		//$sql	=	"SELECT * FROM(SELECT DISTINCT tab_basic.*,tab_library.library_file FROM tab_library,tab_basic WHERE tab_library.library_id = tab_basic.library_id UNION SELECT DISTINCT tab_basic.*,  NULL AS library_file FROM tab_basic WHERE tab_basic.library_id IS NULL)tab_basic";
		$sql	=	"SELECT inventory.*,environment.name FROM inventory,environment WHERE inventory.idEnvironment = environment.idEnvironment";
		if ($condition) {
		$sql .= " AND " . $condition;
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
		$sql.=" ORDER BY inventory.idInventory ASC";
		}
		$sql.="  limit $pager->offset, $pager->limit "; //echo $sql;
		$listing = $this->db->readValues($sql);
		}
		//echo $sql;
		$count = count($listing);
		$paginationTable = $this->db->getPaginationTable($pageName, $filterqry, $page, $limit, $count, $total);
		return array("listing" => $listing, "paginationTable" => $paginationTable);
	}
	function updateBasicTable($insertArray,$gallery_id)
	{      
		$res = $this->db->updateQuery('inventory',$insertArray," idInventory=".$gallery_id);
		return $basic_id;
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

	function deleteBasicFromTrash($basic_id) {    		
        $res = $this->db->deleteQuery('inventory'," idInventory=".$basic_id);
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
}

?>
 