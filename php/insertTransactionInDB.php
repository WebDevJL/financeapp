<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/Logger/sqlLogger.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/Logger/phpLogger.php';
if(isset($_POST['currency'])){$c = $_POST['currency'];}else{$c = 1;}
/*-----------------------*/
/* Process the form DATA */
/*-----------------------*/
$sqlLog = New sqlEventLogger();
$phpLog = New phpEventLogger();
$r['error'] = true;
$r['msg'] = "Default msg";
if($_POST['transactionDate'] === "Select Date" || $_POST['transactionDate'] === ""){
	$r['error'] = true;
	$r['msg'] = "No date selected!";
	echo json_encode($r);//return json obj with result
	die();
}
if($_POST['transactionType'] === "Select Type" || $_POST['transactionType'] === ""){
	$r['error'] = true;
	$r['msg'] = "No value selected. Please select a type.";
	echo json_encode($r);//return json obj with result
	die();
}
if($_POST['category'] === "Select Category" || $_POST['category'] === ""){
	$r['error'] = true;
	$r['msg'] = "No value selected. Please select a category.";
	echo json_encode($r);//return json obj with result
	die();
}
if($_POST['payee'] === "Select Payee" || $_POST['payee'] === ""){
	$r['error'] = true;
	$r['msg'] = "No value selected. Please select a payee.";
	echo json_encode($r);//return json obj with result
	die();
}
$amountTest=preg_match_all("/^-?,?[0-9]+(,[0-9]+)*,?/",$_POST['amount'], $arr, PREG_PATTERN_ORDER);
$phpLog->writeToFile("Amount value: ".$_POST['amount'].". Preg_match_all result is <".$amountTest.">\n");
if($_POST['amount'] === "Enter Amount" || $_POST['amount'] === "" || $amountTest === 0){
	$r['error'] = true;
	$r['msg'] = "Value entered is empty. Please enter an amount.";
	echo json_encode($r);//return json obj with result
	die();
}
$tTID = 0;
$cID = 0;
$scID = 0;
$pID = 0;
$date = $_POST['transactionDate'];
$date = date("Y-m-d", strtotime($date));
/* added on 10-06-12: make sure the comma is replace by a dot since MySQL will truncate the 2 digits */
$amount = 0.00;
$amount = str_replace(',', '.', $_POST['amount']);
/* added on 10-06-12: assign empty.string if notes is default text */
$notes = "";
if( $_POST['notes'] != "Notes if any") {
	$notes = $_POST['notes'];
}
if (file_exists('../Files/accounts.xml')) {
	$xml = simplexml_load_file('../Files/accounts.xml');
	foreach($xml->item as $obj){
	 	if ($obj->name == $_POST['accountName'] && $obj->cid == $c) {
 		//echo("accountID: " . $xml->account[0]->id);
 		$aID = $obj->id;
	 	unset($obj);
	 	//echo $aID;
 		}
	}
} else {
    exit('Failed to open ../Files/accounts.xml.');
}
//
if (file_exists('../Files/transactionTypes.xml')) {
	$xml = simplexml_load_file('../Files/transactionTypes.xml');
	foreach($xml->item as $obj){
		 	if ($obj->name == $_POST['transactionType']) {
 			$tTID = $obj->id;
	 		//echo $tTID;
 		}
	}
} else {
    exit('Failed to open ../Files/transactionTypes.xml.');
}
//Lookup category and subCategory
//$phpLog->writeToFile("insertTransactionInDB.php (Line=85) -> Category: <".$_POST['category'].">.\n"
if (file_exists('../Files/categories.xml')) {
	$xml = simplexml_load_file('../Files/categories.xml');
	foreach($xml->item as $obj){
	 	if ($obj->name == $_POST['category']) {
 			$tmpID = $obj->id;
 			$idArray = explode(":",$tmpID);
 			$cID = $idArray[0];
 			$scID = $idArray[1];
	 		//echo $cID;
 		}
	}
} else {
    exit('Failed to open ../Files/categories.xml.');
}
//
if (file_exists('../Files/payees.xml')) {
	$xml = simplexml_load_file('../Files/payees.xml');
	foreach($xml->item as $obj){
		 	if ($obj->name == utf8_decode($_POST['payee'])) {
 			$pID = $obj->id;
 			//echo $pID;
 		}
	}
} else {
    exit('Failed to open ../Files/payees.xml.');
}
//
/*if (file_exists('../Files/subCategories.xml')) {
	$xml = simplexml_load_file('../Files/subCategories.xml');
	foreach($xml->subcategory as $obj){
		 	if ($obj->name == $_POST['subCategory']) {
 			$scID = $obj->id;
	 		//echo $scID;
 		} else {
 			//echo 0;
 		}
	}
} else {
    exit('Failed to open ../Files/subCategories.xml.');
}*/
?>
<?php
	$db=new DBConnection();
	$query="CALL USP_InsertTransaction('$date','$aID','1','$tTID','$cID','$scID','$pID','$amount','$notes');";
	try {
		$res=$db->rq($query);
		//$sqlLog->writeToFile("$query\n");
		if($res['error'] === true){
			$r['error'] = true;
			$r['msg'] = $res['msg'];
		} else {
			$sqlLog->writeToFile("$query\n");
			//$phpLog->writeToFile("Query has run: <$query>.\n");
			$r['error'] = false;
			$r['msg'] = "Transaction added! (Query was: <$query>)";
		}
	} catch (Exception $e) {
    	$phpLog->writeToFile($e->getMessage());
	}
	$db->close();
	//header( "Location: ../addTransaction.php" ) ;
	//exit;
	/* Insert other transaction if it is a transfer */
	if($tTID == 3){
		if (file_exists('../Files/payees.xml')) {
    		$xml = simplexml_load_file('../Files/transfers.xml');
    		foreach($xml->item as $obj){
	 		 	if ($obj->subCategoryID == $scID) {
		 			$aID = $obj->accountID;
		 		}
	 		 	if ($obj->accountID == $aID) {
		 			$scID = $obj->subCategoryID;
		 		}
    		}
		} else {
		    exit('Failed to open ../Files/payees.xml.');
		}
		$amount *= (-1);
		$db=new DBConnection();
		$query="CALL USP_InsertTransaction('$date','$aID','1','$tTID','$cID','$scID','$pID','$amount','$notes');";
		try {
			$res=$db->rq($query);
			//$sqlLog->writeToFile("$query\n");
			if($res['error'] === true){
				$r['error'] = true;
				$r['msg'] .= $res['msg'];
			} else {
				$sqlLog->writeToFile("$query\n");
				//$phpLog->writeToFile("Query has run: <$query>.\n");
				$r['error'] = false;
				$r['msg'] = "Transfer added!";
			}
		} catch (Exception $e) {
	    	$phpLog->writeToFile($e->getMessage());
		}
		$db->close();
	}
	//Refresh transactions.xml
	$output = file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/storeTransactions.php?cid='.$c);
echo json_encode($r);//return json obj with result
?>