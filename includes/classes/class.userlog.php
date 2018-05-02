<?php

class userlog 
{
    // Function for creating database connection......................
    function __construct(){
		$this->db = new database();
		$this->now = date("Y-m-d");
		if (!$this->db->dbConnect())
		"Error Connection" . $this->db->ErrorInfo;
	}

	function insertLogDetail($insertArray) {  
		$res = $this->db->insertQuery('tab_log',$insertArray);
		return $res;
	}

	function logTypeList($logid=""){
		
		$sql	= " SELECT * FROM tab_log_operations WHERE log_id = '".$logid."'";
		$res    = mysql_query($sql) or die(mysql_error());
		$row    = mysql_fetch_array($res);
		return $row['log_operation'];
  	}

  	function deleteUser($log_id) {  
	   
		$sql = "DELETE FROM tab_log WHERE log_id='".$log_id."'";
        $res = $this->db->executeQuery($sql);
        return $res;
    }
     function get_tab_log_details($condition="", $pageName="",$limit="",$page="", $order_by="") {
		$sql	= " SELECT * FROM tab_log";
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
				$sql.=" ORDER BY tab_log.log_id ASC";
			}	
			$sql.="  limit $pager->offset, $pager->limit ";
			$listing = $this->db->readValues($sql);
			
		}
		
		$count = count($listing);
		$paginationTable = $this->db->getPaginationTable($pageName, $filterqry, $page, $limit, $count, $total);
		$userlist= array("listing" => $listing, "paginationTable" => $paginationTable);
		return $userlist;
	}
}

?>