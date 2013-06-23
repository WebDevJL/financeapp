<?php
require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once '../../BusinessClasses/PHP/Logger/sqlLogger.php';
require_once '../../BusinessClasses/PHP/Logger/phpLogger.php';
$sqlLog = New sqlEventLogger();
$phpLog = New phpEventLogger();
$r['error'] = false;
$r['msg'] = "Default msg";
$r['dataset'] = "";
$c=null;
$catID=null;
$cDefault=null;
$type="";
$query= null;
$query2= null;
if(isset($_POST['type'])){$type = $_POST['type'];}//Get type to build the right query
$payeesXML = $_SERVER['DOCUMENT_ROOT'].'/FinanceApp/Files/payees.xml';
$subCategoriesXML = $_SERVER['DOCUMENT_ROOT'].'/FinanceApp/Files/subCategories.xml';
$categoriesXML = $_SERVER['DOCUMENT_ROOT'].'/FinanceApp/Files/categoriesOnly.xml';
$accountsXML = $_SERVER['DOCUMENT_ROOT'].'/FinanceApp/Files/accounts.xml';
$currenciesXML = $_SERVER['DOCUMENT_ROOT'].'/FinanceApp/Files/currencies.xml';

//$phpLog->writeToFile("Start lookup for currency...\n");
/*currencyID lookup*/
//get account value from request and find id in xml
if(isset($_POST['currency'])){
	if (file_exists($currenciesXML)) {
		$xml = simplexml_load_file($currenciesXML);
		$i=0;
		foreach($xml->item as $obj){
 		 	if ($obj->name == $_POST['currency']) {
	 			$c = $obj->id->__toString();//Updated 27-10-12: must get value from object otherwise it won't work!
		 		unset($obj);//$phpLog->writeToFile("got currency - ID=$c\n");
	 		}//$phpLog->writeToFile("For loop - item$i\n");
		}
	} else {
		exit('Failed to open '.$currenciesXML);//$phpLog->writeToFile("no currency in file\n");
	}
}else{
	$c = null;//$phpLog->writeToFile("no currency\n");
}
//Get default otherwise
if(isset($_POST['currencyDefault']) && $c !== null){$cDefault = $_POST['currencyDefault'];}else{$cDefault = 1;}
/*End of currencyID lookup*/
//$phpLog->writeToFile("... Finished lookup for currency.\n");
/*categoryID lookup*/
//get category value from request and find id in xml
if(isset($_POST['catName'])){
	if (file_exists($categoriesXML)) {
		$xml = simplexml_load_file($categoriesXML);
		$i=0;
		foreach($xml->item as $obj){
 		 	if ($obj->name == $_POST['catName']) {
	 			$catID = $obj->id;//->__toString();//Updated 27-10-12: must get value from object otherwise it won't work!
		 		unset($obj);
	 		}//$phpLog->writeToFile("For loop - item$i\n");
		}
	} else {
		exit('Failed to open '.$categoriesXML);//$phpLog->writeToFile("no category in file\n");
	}
}else{
	$catID = null;//$phpLog->writeToFile("no category\n");
}

switch ($type){/* Start Building Query */
case "acc":
  if($_POST[accountName] == "Enter account Name"){
    $r['error'] = TRUE;
    $r['dataset'] = 'Please enter value';
    $query2="CALL USP_GetAccounts();";
  }else{
    $query="CALL USP_InsertAccount ($c,'$_POST[accountName]');";
    $r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header col1">Name</th></tr>';
    $phpLog->writeToFile("Line 48-> Query1 to run: <$query>.\n");
    $query2="CALL USP_GetAccounts();";
    $phpLog->writeToFile("Line 50-> Query2 to run: <$query2>.\n");
  }
	break;
case "cat":
	try {
		$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header col1">Name</th></tr>';
		if(strlen($_POST['catName'])<46){//Check if the value is there and doesn't exceed the max length
			$query="CALL USP_InsertCategory ('$_POST[catName]');";
		} else {//otherwise, return error status.
			$r['error'] = true;
			$r['msg'] = "Category Name too long! Max. length is 45 characters.";
			echo json_encode($r);//return json obj with result
			die();
			//$phpLog->writeToFile("Error status: $r[error]; $r[msg]\n");
		}//$phpLog->writeToFile("Query to run: <$query>.\n");}
		$query2="CALL USP_GetCategories();";
		$phpLog->writeToFile("Line 65-> Query2 to run: <$query2>.\n");
	} catch (Exception $e) {
    	$r['error'] = true;
		$r['msg'] = $e->getMessage();
		echo json_encode($r);//return json obj with result
		die();
	}
	break;
case "scat":
	try {
		$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header col1">Category Name</th><th class="ui-header col2">SubCategory Name</th></tr>';
		if(strlen($_POST['scatName'])<46 && $catID !== null){//Check if the value is there and doesn't exceed the max length
			$query="CALL USP_InsertSubCategory ('$catID','$_POST[scatName]');";
		} else {//otherwise, return error status.
			$r['error'] = true;
			$r['msg'] = "CategoryID for <".$_POST['scatName']."> not found (value of catID=<$catID>) or SubCategory Name too long (Max. length is 45 characters)!";
			echo json_encode($r);//return json obj with result
			die();
			//$phpLog->writeToFile("Error status: $r[error]; $r[msg]\n");
		}//$phpLog->writeToFile("Query to run: <$query>.\n");}
		$query2="CALL USP_GetCategories2();";
	} catch (Exception $e) {
    	$r['error'] = true;
		$r['msg'] = $e->getMessage();
		echo json_encode($r);//return json obj with result
		die();
	}
	break;
case "payee":
	try {
		$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header col1">Name</th></tr>';
		if(strlen($_POST['payeeName'])<46){//Check if the value is there and doesn't exceed the max length
			$query="CALL USP_InsertPayee ('$_POST[payeeName]');";
		} else {//otherwise, return error status.
			$r['error'] = true;
			$r['msg'] = "Payee Name too long! Max. length is 45 characters.";
			echo json_encode($r);//return json obj with result
			die();
		//$phpLog->writeToFile("Error status: $r[error]; $r[msg]\n");
		}
		$phpLog->writeToFile("Line 78-> Query 1 to run: <$query>.\n");
		$query2="CALL USP_GetPayees();";
		$phpLog->writeToFile("Line 87-> Query2 to run: <$query2>.\n");
	} catch (Exception $e) {
    	$r['error'] = true;
		$r['msg'] = $e->getMessage();
		echo json_encode($r);//return json obj with result
		die();
	}
	break;
case "curr":
	try {
		$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header col1">Currency Name</th><th class="ui-header col2">Currency Symbol</th></tr>';
		//$phpLog->writeToFile('Line 98-> Currency Name=<'.$_POST['currName'].'> and length=<'.strlen($_POST['currName']).'>. Currency Symbol=<'.$_POST['currSymb'].'> and length=<'.strlen($_POST['currSymb']).'>.'."\n");
		if(strlen($_POST['currName'])<46 && strlen($_POST['currSymb'])<6){//Check if the value is there and doesn't exceed the max length
			$query="CALL USP_InsertCurrency ('$_POST[currName]','$_POST[currSymb]');";
		} else {//otherwise, return error status.
			$r['error'] = true;
			$r['msg'] = "Currency Name or Currency Symbol too long! Max. length is 45 characters for the Currency Name and 5 characters for Currency Symbol.";
			echo json_encode($r);//return json obj with result
			die();
			//$phpLog->writeToFile("Error status: $r[error]; $r[msg]\n");
		}//$phpLog->writeToFile("Query to run: <$query>.\n");}
		$query2="CALL USP_GetCurrencies();";
	} catch (Exception $e) {
    	$r['error'] = true;
		$r['msg'] = $e->getMessage();
		echo json_encode($r);//return json obj with result
		die();
	}
	break;
default:
	$query = null;}
/* End building query */
//$phpLog->writeToFile("Line 121-> Error status: $r[error]; $r[msg]\n");
//*******************************Run INSERT QUERY*******************************//
if(isset($query) && $r['error'] !== true){
	$db=new DBConnection();
	$phpLog->writeToFile("Start insert...\n");
	try {
		$res=$db->rq($query);
		if($res['error'] === true){
			$r['error'] = true;
			$r['msg'] = $res['msg'];
			$phpLog->writeToFile($res['msg']."\n");
		} else {
			$sqlLog->writeToFile("$query\n");
			$phpLog->writeToFile("Query has run: <$query>.\n");
			$r['error'] = false;
			$r['msg'] = "Added to DB!";
      //Added on 28-10-12: refresh the xml feed for given type
      switch ($type) {
        case "acc":
          file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/getAccounts.php');
          break;
        case "cat":
          file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/getCategoriesOnly.php');
					break;
				case "scat":
          file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/getCategoriesLong.php');
          file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/getSubCategories.php');
					break;
				case "payee":
          file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/getPayees.php');
					break;
				case "curr":
          file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/getCurrencies.php');
					break;
        default:
          break;
      }
		}
	} catch (Exception $e) {
    	$phpLog->writeToFile($e->getMessage()."\n");
	}
	$db->close();
	$phpLog->writeToFile("... End insert\n");
} else {
	$r['error'] = true;
	$r['msg'] = "Query 1 is null";
}
//*******************************Get DATA Set to return*******************************//
if(isset($query2)){
	$db=new DBConnection();
	$phpLog->writeToFile("Get the dataset to return in json obj...\n");
	try {
		$res=$db->rq($query2);
		if($res['error'] === true){
			$r['error'] = true;
			$r['msg'] = $res['msg'];
		} else {
			while(($row=$db->fetch($res)) != FALSE) {
				$i=0;
				$i+=1;
				switch ($type){/* Start Building Query */
				case "acc":
					//$phpLog->writeToFile("Currency in DB=<$row[Currency]>. currency var=<$c>.\n");
					if ($row['Currency'] === $c){$r['dataset'] .= '<tr class="edit_row"><td id="acc_'.$row['AccountID'].'" class="cell col1">'.utf8_encode($row['AccountName']).'</td></tr>';}
					break;
				case "cat":
					$r['dataset'] .= '<tr class="edit_row"><td id="cat_'.$row['CategoryID'].'" class="cell col1">'.utf8_encode($row['CategoryName']).'</td></tr>';
					break;
				case "scat":
					$r['dataset'] .= '<tr class="edit_row"><td id="cat_'.$row['CategoryID'].'" class="cell col1">'.utf8_encode($row['CategoryName']).'</td><td id="scat_'.$row['SubCategoryID'].'" class="cell col2">'.utf8_encode($row['SubCategoryName']).'</td></tr>';
					break;
				case "payee":
					$r['dataset'] .= '<tr class="edit_row"><td id="payee_'.$row['PayeeID'].'" class="cell col1">'.utf8_encode($row['PayeeName']).'</td></tr>';
					break;
				case "curr":
					$r['dataset'] .= '<tr class="edit_row"><td id="curr_'.$row['ID'].'" class="cell col1">'.$row['Name'].'</td><td class="cell col1">'.$row['Symbol'].'</td></tr>';
					break;
				default:
					break;}
			}
			$r['dataset'] .= '</table><br clear="all">';// closing table
			$sqlLog->writeToFile("$query2\n");
			$phpLog->writeToFile("Query has run: <$query2>.\n");
			$r['error'] = false;
			//$r['msg'] = "Dataset is returned! Look how how beautiful it is :-)";
		}
	} catch (Exception $e) {
    	$phpLog->writeToFile($e->getMessage());
	}
	$db->close();
	$phpLog->writeToFile("... Got dataset to return in json obj\n");
} else {
	$r['error'] = true;
	$r['msg'] = "Query 2 is null";
}
//*******************************Return json obj with result*******************************//
echo json_encode($r);
?>