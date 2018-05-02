<?php 
	/*
	File Name	:	database.class.php
	Purpose		:	For creating database connection and other necessary functions
	Created By	:	Biswajith KR
	Created On	: 	08 Sep 2007
	*/
class database
{
	var			$lnk; 
	var 		$mysqli; 
	var 		$HostName;
	var			$UserName;
	var			$Password;
	var			$DatabaseName;
	var			$ErrorInfo;
		 		
	function __construct()
	{
		$this->HostName			=	DB_HOST;
		$this->UserName			=	DB_USER;
		$this->Password			=	DB_PASSWORD;
		$this->DatabaseName		=	DB_NAME;
		$this->dbConnect();
	}
		
	#	The following method establish a connection with the database server and on success return TRUE, on failure return FALSE
	#	On failure ErrorInfo property contains the error information.
	function dbConnect()
	{
		$this->mysqli 	= 	mysql_connect($this->HostName, $this->UserName, $this->Password);
		if(!$this->mysqli)
		{ 
			$this->ErrorInfo	=	mysql_error();
			return FALSE;
		}
		else
		{
			if(!mysql_select_db($this->DatabaseName))
			{
				$this->ErrorInfo	=	mysql_error();
				return FALSE;
			} else 
			{
				return TRUE;
			}
		}
	} # Close method dbConnect
	
	//function dbClose()
	//{
	//	$this->mysqli->close();
		//mysql_close($this->mysqli);
				
	//} # Close method dbClose
	

	# On insert, update it returns TRUE,  and on select it returns result set object
	function setQuery($Query)
	{
		$ExecStatus		=	mysql_query($Query, $this->mysqli);
		if($ExecStatus	===	FALSE) {
			$this->ErrorInfo	=	mysql_error();
			return FALSE;
		} else {
			return $ExecStatus;
		} 
	} # Close method setQuery			
		
	 function executeQuery($Sql)
	  {
	 		// echo $Sql; 
			$result  = mysql_query($Sql,$this->mysqli) or die (mysql_error()."<br>Please check the following query-<br>".$Sql);
			//echo "  ???   ".mysql_affected_rows()." ??";			
			return   $result;
	  }
		
	# On Success returns number of records corresponding to the query, else return 0	
	function numberOfRecords($Query)
	{
		$RowCount	=	0;
		$ResultSet	=	mysql_query($Query, $this->mysqli);
		if($ResultSet) {
			$RowCount	=	 mysql_num_rows($ResultSet);
			mysql_free_result($ResultSet);
			return $RowCount;
		} else {
			$this->ErrorInfo	=	mysql_error();
			return $RowCount;
		}
	} # Close numberOfRecords method

	
	# Returns an array of rows in the result set
	function readValues($Query)
	{
		$ResultData		=	array();
		$ResultSet		=	mysql_query($Query, $this->mysqli);
		
		if($ResultSet) {
			$RowCount		=	mysql_num_rows($ResultSet);
			for($i=0; $i<$RowCount; $i++)
				$ResultData[$i]	=	mysql_fetch_array($ResultSet); 	
			mysql_free_result($ResultSet);
			return $ResultData;
		} else {
			$this->ErrorInfo	=	mysql_error();
			return $ResultData;
		}	
	} # Close method readValues
	
	# Return a single row 
	function readValue($Query)
	{
		$ResultData		=	array();
		$ResultSet		=	mysql_query($Query, $this->mysqli);
		
		if($ResultSet) {
			$ResultData[0]	=	mysql_fetch_array($ResultSet); 	
			mysql_free_result($ResultSet);
			return $ResultData[0];
		} else {
			$this->ErrorInfo	=	mysql_error();
			return $ResultData;
		}		
	} # Close method readValue

	# Method returns the last insert Id of this connection	
	function getInsertId()
	{
		return mysql_insert_id();
	}

	function insertQuery($tablename,$dataArray) {
		
		 if(is_array($dataArray))
		  {
				$query 			  		= "INSERT INTO $tablename SET ";
				$arrayCount				= sizeof($dataArray);
				$count					= 1;
				while(list($key,$val)   = each($dataArray))
				 {
					if ($count==$arrayCount)
					 {
						if($val == "")
							$query .=" $key=NULL";
						else
							$query .=" $key='$val'";
					 }
					else
					 {
						if($val == "")
							$query .=" $key=NULL ,";
						else
							$query .=" $key='$val', ";
					 }
						
					$count ++;	
				 }//End Of while loop
				$this->executeQuery($query);//Calling the execute query 
				
				return mysql_insert_id();
		 }
		

	 }

	function updateQuery($tablename, $dataArray, $condition="") {	
		 if(is_array($dataArray))
		  {			 
				$query 			    = "UPDATE  $tablename SET ";
				$arrayCount			= sizeof($dataArray);
				$count				= 1;
				while(list($key,$val)  = each($dataArray))
				 {
					if ($count==$arrayCount)
						$query .=" $key='$val'";
					else
						$query .=" $key='$val', ";
					$count ++;	
				 }//End Of while loop	
				if ($condition!="")
				 {
					$query   .= " WHERE  $condition ";
				 } //echo $query;//end of if 
				//echo $query;
				//exit;
			

				$r=$this->executeQuery($query);//Calling the execute query 
		  }
		  return $r;
	 }

	 function updateQueryToNull($tablename,$dataArray,$condition="") {	 
		 if(is_array($dataArray))
		  {
				$query 			    = "UPDATE  $tablename SET ";
				$arrayCount			= sizeof($dataArray);
				$count				= 1;
				while(list($key,$val)  = each($dataArray))
				 {
					if ($count==$arrayCount)
						$query .=" $key=NULL";
					else
						$query .=" $key=NULL, ";
					$count ++;	
				 }//End Of while loop	
				if ($condition!="")
				 {
					$query   .= " WHERE  $condition ";
				 } //echo $query;//end of if 
				// echo $query;
				$r=$this->executeQuery($query);//Calling the execute query 
		  }
		  return $r;
	 }

	 /*   End of insertquery Function.   */
	 /**
       *Get Multiple array of values from a table
       *
       * @param string $table     table
       * @param string $condition condition     
       *
       * @return array
       */ 
    function getTableValuesMultiArray($table,$condition="")
    {
         $ary = array();
        $i     = 0;
        $query    = "SELECT * FROM $table ";
        if ($condition<>"") {
            $query .=" WHERE $condition";    
        }
            ///    echo "<BR>" . $query;    
        
        $result    = $this->executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_array($result)) {
                $ary[$i] = $row;
                $i++;
            }
        
        }
            return $ary;
        
    }
	 /**    Get select box values when a query is passed....  
         *
         * @param string $query    query
         * @param string $curvalue value to be shown selected  
         * @param string $caption  caption
         * 
         * @return mixed
         **/
    function getComboValuesWithQuery($query,$curvalue,$caption="")
    {
        
        $result    = $this->executeQuery($query);
        if ($caption) {
                $option = "<option value=''>$caption</option>";
        } else {
            $option = "";
        }

        if (mysql_num_rows($result)) {        
            while ($row=mysql_fetch_object($result)) {
                if ($curvalue==$row->f2) {
                    
                    $option .= "<option value='$row->f2' selected=\"selected\">". 
                    stripslashes($row->f1)."</option>";   
					/* $option .= "<option value='$row->f2' selected=\"selected\"><strong>". 
                    stripslashes($row->f1)."</strong></option>";   */  
                } else {
                    $option .= "<option value='$row->f2'>". 
                    stripslashes($row->f1)."</option>";
                }
            }
        }
         return $option;
    }
	 /**
     * Get value from table
     *
     * @param string $field     field
     * @param string $table     table name
     * @param string $condition condition
     *  
     * @return mixed
     */
    function getTableValue($field,$table,$condition="")
    {
        $query = "SELECT $field as f1 FROM $table ";
        if ($condition<>"") {
            $query.=" WHERE $condition";
        }
            
			/*if($field=='Content')	
			echo "<BR>" . $query;*/
        
		$result    = $this->executeQuery($query);
        if (mysql_num_rows($result)) {
            $row    = mysql_fetch_object($result);
            $f1        = $row->f1;
        } else {
            $f1    =    "";
        }
        return stripslashes($f1);
    }
	/**  
     * Get an array of value from a table
     *
     * @param string $table     tablename
     * @param string $condition condition
     *  
     * @return mixed
     */
    function getTableValuesArray($table,$condition="")
    {
        $query    = "SELECT * FROM $table ";
        if ($condition<>"") {
            $query .=" WHERE $condition";  
        }  
            ///    echo "<BR>" . $query;    
        
        $result    = $this->executeQuery($query);
        if (mysql_num_rows($result)) {
            $row1    = mysql_fetch_array($result);
        }
            return $row1;
        
    }
	 /**  Function to count the rows in a table.
      *     
      * @param mixed $result result
      *
      * @return int
      */ 
    function countRows($result)
    {
        if (is_resource($result)) {
                 return mysql_num_rows($result);
        }
    }
	/**  Delete table data
    *
    * @param string $tablename tablename
    * @param string $condition condition
    *
    * @return mixed
    */
    function deleteQuery($tablename,$condition="")
    {
        $query = "DELETE FROM $tablename ";
        if ($condition!="") {
            $query       .= " WHERE $condition";
        }
        $this->executeQuery($query)or die (mysql_error()."<br>Please check the following query-<br>".$Sql);//Calling the execute query 
    
    } 
	/**  To get the field value as array 
       *     
       * @param integer $field       field
       * @param string  $table     table name
       * @param string  $condition condition
       *
       * @return  array
       */ 
    function getArrayfield($field,$table,$condition="")
    {
      
        $i     = 0;
        $query    = "SELECT $field FROM $table ";
        if ($condition<>"") {
            $query .="$condition";    
        }
           // echo "<BR>" . $query;    
        
        $result    = $this->executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_array($result)) {
               $ary .= $row[$i].",";
              
            }
            // $ary = array($ary);
			$ary=explode(",",$ary);
        }
            return $ary;
        
    }
	
	 function getPagerData($numHits, $limit, $page) {
        $numHits = (int) $numHits;
        $limit = max((int) $limit, 1);
        $page = (int) $page;
        $numPages = ceil($numHits / $limit);

        $page = max($page, 1);
        $page = min($page, $numPages);


        $offset = ($page - 1) * $limit;

        $ret = new stdClass;

        $ret->offset = $offset;
        $ret->limit = $limit;
        $ret->numPages = $numPages;
        $ret->page = $page;

        return $ret;
    }

	public function getPaginationTable($pagename, $filterqry, $page, $plimit, $recordsPerPage, $totalrecord) {
	
        $pager 	= $this->getPagerData($totalrecord, $plimit, $page);
        $start 	= $pager->offset + 1;
        $end 	= $pager->offset + $recordsPerPage;
		if($page > $pager->numPages) {
			$page = 1;
		}
		$totalPages = $pager->numPages;
		
		$first_count	=	$page*$plimit - ($plimit-1);
		$last_count		=	$page*$plimit;
		
		if($last_count > $totalrecord)
			$last_count	=	$totalrecord;
		
		$records = $first_count . "-" . $last_count . " di " . $totalrecord;
		
		$first_page		=	1;
		$previous_page	=	$page - 1;
		if($previous_page <= 1)
			$previous_page	=	1;		
		$next_page		=	$page + 1;
		if($next_page >= $totalPages)
			$next_page	=	$totalPages;		
		$last_page		=	$totalPages;
		
		$paginationtable = '<div class="pagination">';
		$paginationtable .= '<a href="' . $pagename . '?page=' . ($first_page) . $filterqry . '"><button class="square" onclick="return pageSubmit(1)">&laquo;</button></a>'; 
		$paginationtable .= '<a href="' . $pagename . '?page=' . ($previous_page) . $filterqry . '"><button class="square" onclick="return pageSubmit(\''.($previous_page).'\')">&lsaquo;</button></a>'; 
		$paginationtable .= '<span>'.$records.'</span>'; 
		$paginationtable .= '<a href="' . $pagename . '?page=' . ($next_page) . $filterqry . '"><button class="square" onclick="return pageSubmit(\''.($next_page).'\')">&rsaquo;</button></a>'; 
		$paginationtable .= '<a href="' . $pagename . '?page=' . ($last_page) . $filterqry . '"><button class="square" onclick="return pageSubmit(\''.($last_page).'\')">&raquo;</button></a>'; 
		$paginationtable .= '</div>';	
		
        if ($totalrecord <= 0) {
            $paginationtable = "";
        }
		if ($pager->numPages == 1) {
        }
        return $paginationtable;
    }
} # Close class definition
//}
?>
