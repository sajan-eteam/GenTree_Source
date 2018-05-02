<?php

class users {
    // Function for creating database connection......................
	//table : tab_user
    function __construct() {
        $this->db = new database();
        $this->now = date("Y-m-d");
        if (!$this->db->dbConnect())
            "Error Connection" . $this->db->ErrorInfo;
		//bool PDO::beginTransaction ( void );
    }

     function getUsers($condition="", $pageName="", $limit="", $page="", $order_by="") {
        $sql = "SELECT *,(SELECT COUNT(*) AS cnt FROM tab_article WHERE user_id=tab_user.user_id AND article_delete_flag=0 ) AS article_cnt FROM tab_user ";
        if ($condition) {
            $sql .= " WHERE " . $condition;
        }
        $res = $this->db->readValues($sql); //echo $sql;
        $total = count($res);
        $limit = ($limit) ? $limit : 30;
        $page = ($page) ? $page : 1;
        $pager = $this->db->getPagerData($total, $limit, $page); 
        if ($total > 0) {
            if ($order_by) {
                $sql.="  ORDER BY " . $order_by;
            } else {
                $sql.=" ORDER BY user_id ASC";
            }
            $sql.="  limit $pager->offset, $pager->limit "; //echo $sql;
            $listing = $this->db->readValues($sql);
        }
        $count = count($listing);
        $paginationTable = $this->db->getPaginationTable($pageName, $filterqry, $page, $limit, $count, $total);

        return array("listing" => $listing, "paginationTable" => $paginationTable);
    }


	function insertUser($insertArray) {      
        $res = $this->db->insertQuery('tab_user',$insertArray);
        return $res;
    }

	function editUser($insertArray,$user_id) {      
        $res = $this->db->updateQuery('tab_user',$insertArray," user_id=".$user_id);
        return $res;
    }
	function deleteUser($user_id) {    
		$sql = "DELETE FROM tab_user WHERE user_id=".$user_id;
        $res = $this->db->executeQuery($sql);
        return $res;
    }
	function getUserDetail($user_id) {       
		$sql = "SELECT * FROM tab_user WHERE user_id=".$user_id;
		$res = $this->db->readValues($sql); //echo $sql;		
        if(count($res) > 0) {
			return $res[0];
		}
    }
	function loginCheck($username,$password) {        
		$sql = "SELECT * FROM tab_user WHERE user_username='".$username."' AND user_password= '".$password."'";
		$res = $this->db->readValues($sql); //echo $sql;
        if(count($res) > 0) {
			return $res[0];
		} else {
			return false;
		}
    }
	function forgotPassword($data) {        
		$sql = "SELECT * FROM tab_user WHERE user_username='".$data."' OR user_email= '".$data."'";
		$res = $this->db->readValues($sql); //echo $sql;
        if(count($res) > 0) {
			return $res[0];
		} else {
			return false;
		}
    }	

	function countArticles($user_id) {        
		$sql = "SELECT * FROM tab_article WHERE user_id='".$user_id."' AND article_delete_flag=0 ";
		$res = $this->db->readValues($sql); //echo $sql;
        if(count($res) > 0) {
			return count($res);
		} else {
			return 0;
		}
    }	
	
}
# Closing class Test
?>
 