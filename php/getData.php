  <?php
require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once '../../BusinessClasses/PHP/Logger/sqlLogger.php';
require_once '../../BusinessClasses/PHP/Logger/phpLogger.php';
$sqlLog = New sqlEventLogger();
$phpLog = New phpEventLogger();
$c = null;
if(isset($_POST['currency'])){$c = $_POST['currency'];}else{$c = 1;}
$r['error'] = true;
$r['msg'] = "Default msg";
$r['dataset'] = "";
$type="";
$query= null;
$query2= null;
if(isset($_POST['type'])){$type = $_POST['type'];}//Get type to build the right query
switch ($type){/* Start Building Query */
case "acc":
	$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header column1">Name</th></tr>';
	$query2="CALL USP_GetAccounts();";//$phpLog->writeToFile("Query to run: <$query>.\n");
	break;
case "cat":
	$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header column1">Name</th></tr>';
	$query2="CALL USP_GetCategories();";//$phpLog->writeToFile("Query to run: <$query>.\n");
	break;
case "scat":
	$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header column1>CategoryName</th><th class="ui-header column2">SubCategoryName</th></tr>';
	$query2="CALL USP_GetCategories2();";//$phpLog->writeToFile("Query to run: <$query>.\n");
	break;
case "payee":
	$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header column1">Name</th></tr>';
	$query2="CALL USP_GetPayees();";//$phpLog->writeToFile("Query to run: <$query>.\n");
	break;
case "curr":
	$r['dataset'] = '<table class="table"><tr class="row"><th class="ui-header col1">Currency Name</th><th class="ui-header col2">Currency Symbol</th></tr>';
	$query2="CALL USP_GetCurrencies();";//$phpLog->writeToFile("Query to run: <$query>.\n");
	break;
default:
	$query = null;
	break;}
/* End building query */
//Get DATA Set to return
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
					$r['dataset'] .= '<tr class="edit_row"><td id="curr_'.$row['ID'].'" class="cell col1">'.utf8_encode($row['Name']).'</td><td class="cell col1">'.utf8_encode($row['Symbol']).'</td></tr>';
					break;
				default:
					break;}
			}
			$r['dataset'] .= '</table><br clear="all">';// closing table
			$sqlLog->writeToFile("$query2\n");
			$phpLog->writeToFile("Query has run: <$query2>.\n");
			$r['error'] = false;
			$r['msg'] = "Dataset is returned! Look how how beautiful it is :-)";
		}
	} catch (Exception $e) {
    	$phpLog->writeToFile($e->getMessage());
	}
	$db->close();
	$phpLog->writeToFile("... Got dataset to return in json obj\n");
} else {
	$r['error'] = true;
	$r['msg'] = "Query is null";
}

echo json_encode($r);//return json obj with result
?>