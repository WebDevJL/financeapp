<?php
require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once '../../BusinessClasses/PHP/Logger/phpLogger.php';
require_once '../../BusinessClasses/PHP/Logger/sqlLogger.php';
$sqlLog = New sqlEventLogger();
$r['error'] = false;
$r['msg'] = "Default msg";
$r['dataset'] = "";
$type="";
$query= null;
$query2= null;
$c = null;
if(isset($_POST['currency']) && $c !== null){$c = $_POST['currency'];}else{$c = 1;}
/*  Start processing */
$arrayObj[] = $_POST["arrayObj"];
//$num = extract($arrayObj);
if($arrayObj[0][0][0] == $arrayObj[0][1][0]){
  $type = $arrayObj[0][0][0];
  $id_to_remove = $arrayObj[0][0][1];
}else{
  $type = $arrayObj[0][1][0];
  $id_to_remove = $arrayObj[0][1][1];
}
$query="CALL USP_DeleteRow('$type','$id_to_remove');";
switch ($type){/* Start Building Query */
case "acc":
	$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header column1">Name</th></tr>';
	$query2="CALL USP_GetAccounts();";
	break;
case "cat":
	$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header column1">Name</th></tr>';
	$query2="CALL USP_GetCategories();";
	break;
case "scat":
	$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header column1>CategoryName</th><th class="ui-header column2">SubCategoryName</th></tr>';
	$query2="CALL USP_GetCategories2();";
	break;
case "payee":
	$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header column1">Name</th></tr>';
	$query2="CALL USP_GetPayees();";
	break;
case "curr":
	$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header col1">Currency Name</th><th class="ui-header col2">Currency Symbol</th></tr>';
	$query2="CALL USP_GetCurrencies();";
	break;
default:
	$query = null;
	break;}
/* End building query */
  //*******************************Run Delete QUERY*******************************//
if(isset($query) && $r['error'] !== true){
	$db=new DBConnection();
	try {
		$res=$db->rq($query);
		if($res['error'] === true){
			$r['error'] = true;
			$r['msg'] = $res['msg'];
		} else {
			$r['error'] = false;
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
			$r['msg'] = $res['msg'];
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
					$r['dataset'] .= '<tr class="edit_row"><td id="curr_'.$row['ID'].'" class="cell col1">'.utf8_encode($row['Name']).'</td><td class="cell col1">'.utf8_encode($row['Symbol']).'</td></tr>';
					break;
				default:
					break;}
			}
			$r['dataset'] .= '</table><br clear="all">';// closing table
			if($r['error'] == false){
        $r['msg'] = "<p>Row deleted :-)</p>";
      }
		}
	} catch (Exception $e) {
    	$phpLog->writeToFile($e->getMessage());
	}
	$db->close();
} else {
	$r['error'] = true;
	$r['msg'] = "Query is null";
}

//*******************************Return json obj with result*******************************//
echo json_encode($r);
?>