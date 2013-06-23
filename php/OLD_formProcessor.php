<?php
/*try {
	//function to validate the email address
	//returns false if email is invalid
	/*
	function checkEmail($email){
	
		if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $email)){
			return FALSE;
		}
	
		list($Username, $Domain) = split("@",$email);
	
		if(@getmxrr($Domain, $MXHost)){
			return TRUE;
	
		} else {
			if(@fsockopen($Domain, 25, $errno, $errstr, 30)){
				return TRUE;
			} else {
	
				return FALSE;
			}
		}
	}
		
	
	//response array with status code and message
	$response_array = array();
	
	//validate the post form
	
	//check the transactionDate field
	if(empty($_POST['transactionDate'])){
	
		//set the response
		$response_array['status'] = 'error';
		$response_array['message'] = 'You mush select a date!';
	
	//check the accountName field
	} elseif(!checkEmail($_POST['accountName'])) {
	
		//set the response
		$response_array['status'] = 'error';
		$response_array['message'] = 'You mush select an account!';
	
	//check the transactionType field
	} elseif(empty($_POST['transactionType'])) {
	
		//set the response
		$response_array['status'] = 'error';
		$response_array['message'] = 'You mush select a value!';
		
	//check the category field
	} elseif(empty($_POST['category'])) {
	
		//set the response
		$response_array['status'] = 'error';
		$response_array['message'] = 'You mush select a category!';
		
	//check the subCategory field
	} elseif(empty($_POST['subCategory'])) {
	
		//set the response
		$response_array['status'] = 'error';
		$response_array['message'] = 'You mush select a subCategory!';
		
	//check the message field
	} elseif(empty($_POST['amount'])) {
	
		//set the response
		$response_array['status'] = 'error';
		$response_array['message'] = 'You mush enter a value!';
		
	/*
	//check the notes field
	} elseif(empty($_POST['notes'])) {
	
		//set the response
		$response_array['status'] = 'error';
		$response_array['message'] = 'You must enter a note!';
	
	
	//form validated. insert the transaction
	} else {
	
		$transactionDate = $_POST['transactionDate'];
		$accountName = $_POST['accountName'];
		$clearedTransaction = $_POST['clearedTransaction'];
		$transactionType = $_POST['transactionType'];
		$category = $_POST['category'];
		$subCategory = $_POST['subCategory'];
		$amount = $_POST['amount'];
		$notes = $_POST['notes'];
	
		try {
			echo('<!--in try&catch-->');
			echo($transactionDate.','.$accountName.','.$clearedTransaction.','.$transactionType.','.$category.','.$subCategory.','.$amount.','.$notes);
			//require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
			//$db=new DBConnection();
			//$query='CALL USP_GetSubCategories ('.$transactionDate.','.$accountName.','.$clearedTransaction.','.$transactionType.','.$category.','.$subCategory.','.$amount.','.$notes.')';
			//$res=$db->rq($query);
			//if(($row=$db->fetch($res)) != FALSE) {
				//DATA INSERTED
			//}
			//else {
				//FAILS INSERT
			//}
			//$db->close();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	
		//set the response
		$response_array['status'] = 'success';
		$response_array['message'] = 'Email sent!';
	
	}
	
	//send the response back
	echo json_encode($response_array);
} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}*/
?>
<?php
/**
 * @author Marijan Šuflaj <msufflaj32@gmail.com>
 * @link http://www.php4every1.com
 */
/*
            	datepicker : $('#datepicker').val(),
            	accountsList : $('#accountsList').val(),
            	cT : $('#cT').val(),
            	transactionTypeList : $('#transactionTypeList').val(),
            	catList : $('#catList').val(),
            	subcatList : $('#subcatList').val(),
            	payeeList : $('#payeeList').val(),
            	amountValue : $('#amountValue').val(),
            	notesValue : $('#notesValue').val()

*/
$return['error'] = false;

while (true) {
    if (empty($_POST['datepicker'])) {
    	$return['error'] = true;
    	$return['msg'] = 'You did not enter you email.';
    	break;
    }

    if (empty($_POST['accountsList'])) {
        $return['error'] = true;
        $return['msg'] = 'You did not enter you name.';
        break;
    }

    if (empty($_POST['cT'])) {
        $return['error'] = true;
        $return['msg'] = 'You did not enter you url.';
        break;
    }
    if (empty($_POST['transactionTypeList'])) {
        $return['error'] = true;
        $return['msg'] = 'You did not enter you url.';
        break;
    }
    if (empty($_POST['catList'])) {
        $return['error'] = true;
        $return['msg'] = 'You did not enter you url.';
        break;
    }
    if (empty($_POST['subcatList'])) {
        $return['error'] = true;
        $return['msg'] = 'You did not enter you url.';
        break;
    }
    if (empty($_POST['payeeList'])) {
        $return['error'] = true;
        $return['msg'] = 'You did not enter you url.';
        break;
    }
    if (empty($_POST['amountValue'])) {
        $return['error'] = true;
        $return['msg'] = 'You did not enter you url.';
        break;
    }
    if (empty($_POST['notesValue'])) {
        $return['error'] = true;
        $return['msg'] = 'You did not enter you url.';
        break;
    }

    break;
}

if (!$return['error'])
    $return['msg'] = 'You\'ve entered: ' . $_POST['datepicker'] . ', ' . $_POST['accountsList'] . ', ' . $_POST['cT'] . '.';

echo json_encode($return);