<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';// DB interface
if(isset($_POST['currency'])){$c = $_POST['currency'];}else{$c = 1;}
$r['error'] = false;
$r['msg'] = "Nothing was processed";
$r['dataset'] = [];
$query= null;

if(isset($_POST['src'])){$type = $_POST['type'];}//Get type to build the right query
switch ($type){/* Start Building Query */
    case "account":
        $query2="CALL USP_GetAccounts();";
        break;
    case "categoryS":
        $query2="CALL USP_GetCategories();";
        break;
    case "categoryL":
        $query2="CALL USP_GetCategories2();";
        break;
    case "subCategory":
        $query2="CALL USP_GetSubCategories();";
        break;
    case "payee":
        $query2="CALL USP_GetPayees();";
        break;
    case "currency":
        $query2="CALL USP_GetCurrencies();";
        break;
    case "schedule":
        $query2="CALL USP_GetSchedules();";
        break;
    case "budget":
        $query2="CALL USP_GetBudgets();";
        break;
    case "budgetSetup":
        $query2="CALL USP_GetBudgetSettings();";
        break;
    default:
        $query2=null;
        break;
}
/* End building query */
//Get DATA Set to return
if(isset($query2)){
	$db=new DBConnection();
	try {
		$res=$db->rq($query2);
		if($res['error'] === true){
			$r['error'] = true;
			$r['msg'] = $res['msg'];
		} else {
			while(($row=$db->fetch($res)) != FALSE) {
				switch ($type){/* Start Building Query */
				case "accounts":
					//$phpLog->writeToFile("Currency in DB=<$row[Currency]>. currency var=<$c>.\n");
					if ($row['Currency'] === $c){array_push($r['dataset'],utf8_encode($row['AccountName']));}
					break;
				case "categoriesShort":
					array_push($r['dataset'],utf8_encode($row['CategoryName']));
					break;
				case "categoriesLong":
					array_push($r['dataset'],utf8_encode($row['CategoryName']).':'.utf8_encode($row['SubCategoryName']));
					break;
				case "subCategories":
					array_push($r['dataset'],utf8_encode($row['SubCategoryName']));
					break;
				case "payees":
					array_push($r['dataset'],utf8_encode($row['PayeeName']));
					break;
				case "currencies":
					array_push($r['dataset'],utf8_encode($row['Name']));
					break;
				default:
					break;}
			}
			$r['error'] = false;
			$r['msg'] = "Dataset is returned!";
		}
	} catch (Exception $e) {
    	//$phpLog->writeToFile($e->getMessage());
	}
	$db->close();
} else {
	$r['error'] = true;
	$r['msg'] = "Query2 is null";
}

echo json_encode($r);//return json obj with result
?>
