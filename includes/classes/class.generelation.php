<?php
class generelation
{
 function __construct() {
        $this->db = new database();
        $this->now = date("Y-m-d");
        if (!$this->db->dbConnect())
            "Error Connection" . $this->db->ErrorInfo;
		//bool PDO::beginTransaction ( void );
    }
 function getrelation() 
		{       
		$sql = "SELECT * FROM tab_gene_relations";
		$res = $this->db->readValues($sql); //echo $sql;
		//echo $sql ;exit; 
        if(count($res) > 0) {
			return $res;
		}
    }
}
?>