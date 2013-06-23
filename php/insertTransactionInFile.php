<?php
require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once '../../BusinessClasses/PHP/Logger/sqlLogger.php';
require_once '../../BusinessClasses/PHP/Logger/phpLogger.php';
require_once '../../BusinessClasses/Utility/SimpleXMLWithAddOns.php';//Added on 15-09-12

if(isset($_POST['currency'])){$c = $_POST['currency'];}else{$c = 1;}
/*-----------------------*/
/* Process the form DATA */
/*-----------------------*/
//$sqlLog = New sqlEventLogger();
$phpLog = New phpEventLogger();
$r['error'] = false;
$r['msg'] = "Default msg";
/*Checks on the POST Values*/
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

$amount = 0.00;
$amount = str_replace(',', '.', $_POST['amount']);
$notes = "";
//Find IDs based String value
//Get accountID
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
//Get Transaction typeID
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
//GEt payeeID
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
/*------------------------------------------------------------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------------------------*/
/* - Insert SQL query in file																												*/
/* - Add new transaction to XML file																										*/
/*------------------------------------------------------------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------------------------*/
/* 1. Insert SQL query in file																												*/

$ts = date('m/d/Y h:i:s a', time());
$query="CALL USP_CheckTransaction('$date','$aID','1','$tTID','$cID','$scID','$pID','$amount');#$ts;\n";
$query="CALL USP_InsertTransaction('$date','$aID','1','$tTID','$cID','$scID','$pID','$amount','$notes');#$ts;\n";
//$log = "$ts: $query";
$log = "$query";
$date = date("Y-m-d", strtotime($date));
$offlineFile = $_SERVER['DOCUMENT_ROOT'].'/FinanceApp/Files/Offline/Transactions_'.$c.'_'.$date.'.sql';
if (file_exists($offlineFile)) {
	$bitWrote = file_put_contents($offlineFile, $log, FILE_APPEND | LOCK_EX);
	if($bitWrote === 0){//String not written to file so ERROR
		$r['error'] = true;
		$r['msg'] = "Error writing to the file the query: <$query>.";
		echo json_encode($r);//return json obj with result
		die();
	} else {//String written file so OK
		$r['error'] = false;
		$r['msg'] = "Query wrote to file \"$offlineFile\" (<$query>).";
	}			
} else {
	$handle = fopen($offlineFile, "w");
	fwrite($handle, $log);
	fclose($handle);
    //exit('Failed to open ' . $fileLogName . '.');
	$r['error'] = false;
	$r['msg'] = "File created. Query wrote to file \"$offlineFile\" <br/>(<$query>).";
}
/*------------------------------------------------------------------------------------------------------------------------------------------*/
$account = $_POST['accountName'];
$type = $_POST['transactionType'];
$array = explode(":",$_POST['category']);
$category = $array[0];
$subcategory = $array[1];
$payee = $_POST['payee'];
//$amount = $_POST['amount']; //done above already
//$notes = $_POST['notes']; //done above already

/*------------------------------------------------------------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------------------------*/
/* 2. Add new transaction to XML file																										*/

$xmlFileName = "../Files/Offline/transactions_$c.xml";

$xml = simplexml_load_file($xmlFileName); //This line will load the XML file. 

$sxe = new SimpleXMLWithAddOns($xml->asXML()); //In this line it create a SimpleXMLElement object with the source of the XML file.
//Get number of transactions from the current xml
$num_transactions = $sxe->count();
/* $phpLog->writeToFile("number of transactions in XML: <$num_transactions>\n"); */
 
//The following lines will add a new child and others child inside the previous child created. 
$xml_t = $sxe->prependChild("transaction", "");
$xml_t->addAttribute("tID",$num_transactions+1); 
$xml_t->addChild("date", $date);
$xml_t->addChild("currency", $c);

$xml_enable = $xml_t->addChild("enable", "1");

$xml_acc = $xml_t->addChild("account", "");
$xml_acc->addAttribute("ID",$aID);
$xml_acc->addAttribute("name",$account);

$xml_type = $xml_t->addChild("type", $type);
$xml_type->addAttribute("ID",$tTID);

$xml_cat = $xml_t->addChild("category", "");
$xml_cat->addAttribute("ID",$cID);
$xml_cat->addAttribute("name",$category);

$xml_scat = $xml_t->addChild("subcategory", "");
$xml_scat->addAttribute("ID",$scID);
$xml_scat->addAttribute("name",$subcategory);

$xml_payee = $xml_t->addChild("payee", "");
$xml_payee->addAttribute("ID",$pID);
//$xml_payee->addAttribute("name",$payee);
$xml_payee->addChild("name", $payee);

$xml_t->addChild("amount", $amount);
$xml_t->addChild("notes", $notes);
//This next line will overwrite the original XML file with new data added 
//$sxe->asXML($xmlFileName);

//Format the XML so that it has a nice output
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($sxe->asXML());
$formatted = $dom->saveXML();

//Save XML to file
$handle = fopen($xmlFileName, "w");
fwrite($handle, $formatted);
fclose($handle);

echo json_encode($r);//return json obj with result
?>