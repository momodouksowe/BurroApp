<?php
include_once("dbconn.php");
class queryFile extends dbconn{
	
function findWord($strQuery){
		// $strQuery= " Exec searchParty '$SearchWord'";
	return $this->query($strQuery);
}
}
?>