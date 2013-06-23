<?php
/**
 * @author Marijan Šuflaj <msufflaj32@gmail.com>
 * @link http://www.php4every1.com
 */

$return['error'] = false;

while (true) {
    if (empty($_POST['datepicker'])) {
    	$return['error'] = true;
    	$return['msg'] = 'No datepicker.';
    	break;
    }

    if (empty($_POST['accountID'])) {
        $return['error'] = true;
    	$return['msg'] = 'No accountsList.';
        break;
    }

/*
    if (empty($_POST['cT'])) {
        $return['error'] = true;
    	$return['msg'] = 'No .';
        break;
    }
*/
    if (empty($_POST['transactionTypeID'])) {
        $return['error'] = true;
    	$return['msg'] = 'No transactionTypeList.';
        break;
    }
    if (empty($_POST['catID'])) {
        $return['error'] = true;
    	$return['msg'] = 'No catList.';
        break;
    }
    if (empty($_POST['subcatID'])) {
        $return['error'] = true;
    	$return['msg'] = 'No subcatList.';
        break;
    }
    if (empty($_POST['payeeID'])) {
        $return['error'] = true;
    	$return['msg'] = 'No payeeList.';
        break;
    }
    if (empty($_POST['amountValue'])) {
        $return['error'] = true;
    	$return['msg'] = 'No amountValue.';
        break;
    }
/*
    if (empty($_POST['notesValue'])) {
        $return['error'] = true;
    	$return['msg'] = 'No notesValue.';
        break;
    }
*/

    break;
}
function extract_numbers($string)
{
preg_match_all('/\((.*)\)/', $string, $match);

return $match[1][0];
}
if (!$return['error'])
	//$pattern = '/\((.*)\)/';
	//$Str = $_POST['accountID'];
	//preg_match($pattern,$Str,$matches,PREG_PATTERN_ORDER);
	//$accountID = $matches[1];
	$accountID = extract_numbers($_POST['accountID']);
	$typeID = extract_numbers($_POST['transactionTypeID']);
	$catID = extract_numbers($_POST['catID']);
	$subcatID = extract_numbers($_POST['subcatID']);
	$payeeID = extract_numbers($_POST['payeeID']);
	$date = $_POST['datepicker'];
	$amount = $_POST['amountValue'];
	$notes = $_POST['notesValue'];
	
	$return['msg'] = 'date: ' . $_POST['datepicker'] . ';'; 
    $return['msg'] .= ' accountID: ' . $accountID . ';';
    $return['msg'] .= ' validated: ' . $_POST['cT'] . ';';
    $return['msg'] .= ' typeID: ' . $typeID . ';';
    $return['msg'] .= ' catID: ' . $catID . ';';
    $return['msg'] .= ' subcatID: ' . $subcatID . ';';
    $return['msg'] .= ' payeeID: ' . $payeeID . ';';
    $return['msg'] .= ' amountValue: ' . $_POST['amountValue'] . ';';
    $return['msg'] .= ' notesValue: ' . $_POST['notesValue'] . ';';
    //$return['msg'] .= 'CALL USP_InsertTransaction('. $date .','. $accountID .',1,'. $typeID .','. $catID .','. $subcatID .','. $payeeID .','. $amount .','. $notes .')';
    //try {
		//echo('<!--in try&catch-->');
		require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
		$db=new DBConnection();
		//$query='CALL USP_InsertTransaction('. $_POST['datepicker'] .','. $accountID .',1,'. $typeID .','. $catID .','. $subcatID .','. $payeeID .','. $_POST['amountValue'] .','. $_POST['notesValue'] .')';
		//$query='CALL USP_InsertTransaction('. $date .','. $accountID .',1,'. $typeID .','. $catID .','. $subcatID .','. $payeeID .','. $amount .','. $notes .')';
		//$res=$db->rq($query);
		$db->close();
	//} catch (Exception $e) {
	//	$return['msg'] = 'Error trying inserting the DATA';
		//echo 'Caught exception: ',  $e->getMessage(), "\n";
	//	$return = 'Error in SQL.';
	//}
	
echo json_encode($return);