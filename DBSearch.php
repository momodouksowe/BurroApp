<?php 
	if(!isset($_REQUEST['cmd'])){
		echo "cmd is not provided";
		exit();
	}
	include_once("RefreshQueryFile.php");
	include_once("ArrayToXml.php");
	
	/*get command*/
	$cmd=$_REQUEST['cmd'];
	switch($cmd){
		case 1:
			$UserDetails = "select username, userPass from userAccounts";
			$users = "Users.xml";
			Refresh($UserDetails, $users);		
			break;
	}

 function Refresh($takeQuery, $FileName){
    $obj = new RefreshQueryFile();
    $result = $obj->RefreshDB($takeQuery);
    $row = $obj->fetch();
    
        if($row<1){
			echo "This user does not exist";	
			return;
		}else{
		$ArrayToXml = new ArrayToXml();
		//creating object of SimpleXMLElement
		$xml_user_info = new SimpleXMLElement("<?xml version=\"1.0\"?><user_info></user_info>");
		//function call to convert array to xml
		$ArrayToXml->array_to_xml($row,$xml_user_info);
		while ($row = $obj->fetch()){
			$ArrayToXml->array_to_xml($row,$xml_user_info);
		}
		//saving generated xml file
		$xml_file = $xml_user_info->asXML($FileName);
		//success and error message based on xml creation
		if($xml_file){
    	echo 'XML file have been generated successfully.';
		}else{
   		 echo 'XML file generation error.';
   }
 }
}

?>