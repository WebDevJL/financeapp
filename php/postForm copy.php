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

if (!$return['error'])
    $return['msg'] = 'date: ' . $_POST['datepicker'] . ';'; 
/*
    $return['msg'] .= '<br> accountID: ' . $_POST['accountID'] . ';';
    $return['msg'] .= '<br> validated: ' . $_POST['cT'] . ';';
    $return['msg'] .= '<br> typeID: ' . $_POST['transactionTypeID'] . ';';
    $return['msg'] .= '<br> catID: ' . $_POST['catID'] . ';';
    $return['msg'] .= '<br> subcatID: ' . $_POST['subcatID'] . ';';
    $return['msg'] .= '<br> payeeID: ' . $_POST['payeeID'] . ';';
    $return['msg'] .= '<br> amountValue: ' . $_POST['amountValue'] . ';';
    $return['msg'] .= '<br> notesValue: ' . $_POST['notesValue'] . ';';
*/

echo json_encode($return);