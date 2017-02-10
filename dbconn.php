<?php
/**
*Database connection helper
*/

include_once("setting.php");
/**
* Database connection helper class
*/
// echo "Not connected yet!";
class dbconn{
	var $db=null;
	var $result=null;
	var $row=null;
	var $array=null;
	function dbconn(){
	}
	/**
	*Connect to database 
	*@return boolean ture if connected else false
	*/

	function connect(){										  
	$server = DB_HOST;
	$connectionInfo = array( "Database"=>DB_NAME, "UID"=>DB_USERNAME, "PWD"=>DB_PASSWORD);
	// Connect to MSSQL
	$this->db = sqlsrv_connect($server, $connectionInfo);

	if( $this->db  === false ) {
		echo"Not Connected!";
     die( print_r( sqlsrv_errors(), true));
     return false;
	}else{
		return true;
	}
		
}
	
	/**
	*Query the database 
	*@param string $strQuery sql string to execute
	*/
	function query($strQuery){
		if(!$this->connect()){
			return false;
		}
		if($this->db==null){
			return false;

		}

		$this->result=sqlsrv_query($this->db, $strQuery);


		if($this->result==false){
			die( print_r( sqlsrv_errors(), true));
			return false;

		}else{
			// echo "have retrieved!";

		return true;

}
	}
	/*
	* Fetch from the current data set and return
	*@return array one record
	*/
	function fetch(){
		//Complete this funtion to fetch from the $this->result
		if($this->result==null){
			return false;
		}
		
		if($this->result==false){
			return false;
		}
		
		// return $this->result->sqlsrv_fetch_array(SQLSRV_FETCH_ASSOC);
		 return $this->array=sqlsrv_fetch_array( $this->result, SQLSRV_FETCH_ASSOC);

	}
}

?>