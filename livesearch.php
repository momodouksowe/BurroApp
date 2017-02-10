<?php 
	if(!isset($_REQUEST['cmd'])){
		echo "cmd is not provided";
		exit();
	}
  include_once("queryFile.php");
	/*get command*/
	$cmd=$_REQUEST['cmd'];
	switch($cmd){
		case 1:
			SearchPartyDetails();		
			break;
    case 2:
      SearchTouchPoints();   
      break;
    case 3:
      SearchSales();   
      break;
    case 4:
      SalesDetails();
      break;
	}

  function FetchFromDB($takeQuery){
      $obj = new queryFile();
    if($obj->findWord($takeQuery)){
      $row = $obj->fetch();
      $result=array();
       while($row!=false){
        $result[]=$row;
      $row=$obj->fetch();
      }
      echo'{"result":1,"user":';
      echo json_encode($result);
      echo '}';
  }
    else{
      echo'{"result":0,"message":"this user can not be found"}';
    }
}

	function SearchPartyDetails(){
		if(!isset($_REQUEST['value'])){
			echo "word is not given";		
			exit();
		}
	  $SearchWord=$_REQUEST['value'];
    // echo $SearchWord;
    $SearchWord=str_replace("'","''","$SearchWord");
    // echo $SearchWord;


    $strQuery= "Select top(5) a.partyId, partyName, phoneNos, cityTown,partyType, isNull(creditLimit,0) creditLimit, isNull(PaidT90,0) PaidT90, isNull(AccBalance,0) AccBalance from VallPartiesWithExtraDatails a 
    left outer join (Select partyID, isNull(creditLimit,0) creditLimit from reseller) b on a.partyID=b.partyID left outer join vPaidT90nAccBalance T90 on a.partyID=T90.partyID
    where partyName like '%$SearchWord%' or a.partyID like '%$SearchWord%' or phoneNos like '%$SearchWord%' or 
    cityTown like '%$SearchWord%' or partyType like '%$SearchWord%'";
    FetchFromDB($strQuery);
}

 function SearchSales(){
    if(!isset($_REQUEST['value'])){
      echo "word is not given";   
      exit();
    }
    $SearchWord=$_REQUEST['value'];
    $strQuery= "Exec getLastNSalesForMobile 5 , '$SearchWord'";
    FetchFromDB($strQuery);
}

  function SearchTouchPoints(){
    if(!isset($_REQUEST['value'])){
      echo "word is not given";   
      exit();
    }
    $SearchWord=$_REQUEST['value'];
    $strQuery= "Exec getTouchPointsForMobile '$SearchWord'";
    FetchFromDB($strQuery);
}
  function SalesDetails(){
    if(!isset($_REQUEST['value'])){
      echo "word is not given";   
      exit();
    }
   $SearchWord=$_REQUEST['value'];
    $strQuery= "select customer, Convert(varchar,saleDate,3) saleDate,productName, soldCount,unitprice, pricelist discountList, 
    productDiscount, (lineAmount + VAT) Amount from vSalesLogByProduct where void = 'false' and saleid ='$SearchWord'";
    FetchFromDB($strQuery);
}

?>