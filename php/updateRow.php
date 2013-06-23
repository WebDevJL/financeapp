<?php
require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once '../../BusinessClasses/PHP/Logger/sqlLogger.php';
require_once '../../BusinessClasses/PHP/Logger/phpLogger.php';
$sqlLog = New sqlEventLogger();
$phpLog = New phpEventLogger();
$r['error'] = false;
$r['msg'] = "";
$r['dataset'] = "";
$c=null;
$catID=null;
$scatID=null;
$type="";
$query= null;
$query2= null;
if(isset($_POST['type'])){$type = $_POST['type'];}//Get type to build the right query
$payeesXML = $_SERVER['DOCUMENT_ROOT'].'/FinanceApp/Files/payees.xml';
$subCategoriesXML = $_SERVER['DOCUMENT_ROOT'].'/FinanceApp/Files/subCategories.xml';
$categoriesXML = $_SERVER['DOCUMENT_ROOT'].'/FinanceApp/Files/categoriesOnly.xml';
$accountsXML = $_SERVER['DOCUMENT_ROOT'].'/FinanceApp/Files/accounts.xml';
$currenciesXML = $_SERVER['DOCUMENT_ROOT'].'/FinanceApp/Files/currencies.xml';

if(isset($_POST['currency']) && $c !== null){$c = $_POST['currency'];}else{$c = 1;}

switch ($type){/* Start Building Queries */
case "acc":
  $query="CALL USP_UpdateAccount ($c,'$_POST[fieldID]','$_POST[fieldValue]');";
	$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header column1">Name</th></tr>';
  $query2="CALL USP_GetAccounts();";
	break;
case "cat":
	try {
    $r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header column1">Name</th></tr>';
		if(strlen($_POST['fieldValue'])<46){//Check if the value is there and doesn't exceed the max length
			$query="CALL USP_UpdateCategory ('$_POST[fieldID]','$_POST[fieldValue]');";
		} else {//otherwise, return error status.
			$r['error'] = true;
			$r['msg'] = "Category Name too long! Max. length is 45 characters.";
			echo json_encode($r);//return json obj with result
			die();
			//$phpLog->writeToFile("Error status: $r[error]; $r[msg]\n");
		}//$phpLog->writeToFile("Query to run: <$query>.\n");}
		$query2="CALL USP_GetCategories();";
	} catch (Exception $e) {
    $r['error'] = true;
		$r['msg'] = $e->getMessage();
		echo json_encode($r);//return json obj with result
		die();
	}
	break;
case "scat":
	try {
    $r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header column1>CategoryName</th><th class="ui-header column2">SubCategoryName</th></tr>';
		if(strlen($_POST['fieldValue2'])<46 && $_POST['fieldID'] !== null && $_POST['fieldID2'] !== null){//Check if the value is there and doesn't exceed the max length
			$query="CALL USP_UpdateSubCategory ('$_POST[fieldID]','$_POST[fieldID2]','$_POST[fieldValue2]');";
		} else {//otherwise, return error status.
			$r['error'] = true;
			$r['msg'] = "CategoryID value is <$catID>) or SubCategory Name too long (Max. length is 45 characters)!";
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
  	$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header column1">Name</th></tr>';
		if(strlen($_POST['fieldValue'])<46){//Check if the value is there and doesn't exceed the max length
			$query="CALL USP_UpdatePayee ('$_POST[fieldID]','$_POST[fieldValue]');";
		} else {//otherwise, return error status.
			$r['error'] = true;
			$r['msg'] = "Payee Name too long! Max. length is 45 characters.";
			echo json_encode($r);//return json obj with result
			die();
		//$phpLog->writeToFile("Error status: $r[error]; $r[msg]\n");
		}
		$query2="CALL USP_GetPayees();";
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
		if(strlen($_POST['fieldValue'])<46 && strlen($_POST['fieldValue2'])<6){//Check if the value is there and doesn't exceed the max length
			$query="CALL USP_UpdateCurrency ('$_POST[fieldID]','$_POST[fieldValue]','$_POST[fieldValue2]');";
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
      //Added on 28-10-12: refresh the xml feed for given type
      switch ($type) {
        case "acc":
          $output = file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/getAccounts.php');
          break;
        case "cat":
          $output = file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/getCategoriesOnly.php');
					break;
				case "scat":
          $output = file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/getCategoriesLong.php');
          $output = file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/getSubCategories.php');
					break;
				case "payee":
          $output = file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/getPayees.php');
					break;
				case "curr":
          $output = file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/FinanceApp/php/getCurrencies.php');
					break;
        default:
          break;
      }
		}
	} catch (Exception $e) {
    	$phpLog->writeToFile($e->getMessage()."\n");
	}
	$db->close();
} else {
	$r['error'] = true;
	$r['msg'] = "Query 1 is null";
}
//*******************************Get DATA Set to return*******************************//
if(isset($query2)){
	$db=new DBConnection();
	try {
		$res=$db->rq($query2);
		if($res['error'] === true){
			$r['error'] = true;
			$r['msg'] .= $res['msg'];
		} else {
      $r['update_type'] = $type;
			while(($row=$db->fetch($res)) != FALSE) {
				$i=0;
				$i+=1;
				switch ($type){/* Start Building Query */
				case "acc":
					//$phpLog->writeToFile("Currency in DB=<$row[Currency]>. currency var=<$c>.\n");
					if (intval($row['Currency']) === $c){$r['dataset'] .= '<tr class="edit_row"><td id="acc_'.$row['AccountID'].'" class="cell col1">'.utf8_encode($row['AccountName']).'</td></tr>';}
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
					$r['dataset'] .= '<tr class="edit_row"><td id="curr_'.$row['ID'].'" class="cell col1">'.$row['Name'].'</td></tr>';
					break;
				default:
					break;}
			}
			$r['dataset'] .= '</table><br clear="all">';// closing table
			if($r['error'] == false){
        $r['msg'] .= "<p>Row updated :-)</p>";
      }
		}
	} catch (Exception $e) {
    	$phpLog->writeToFile($e->getMessage());
	}
	$db->close();
} else {
	$r['error'] = true;
	$r['msg'] .= "Query 2 is null";
}
//*******************************Return json obj with result*******************************//
echo json_encode($r);
?>