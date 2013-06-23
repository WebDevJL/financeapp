<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/Logger/sqlLogger.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/Logger/phpLogger.php';
$sqlLog = New sqlEventLogger();
$phpLog = New phpEventLogger();

header("Cache-Control: no-cache");
header("Pragma: no-cache");
$fileName = "/FinanceApp/Files/transactions.xml";
$fileName2 = "/FinanceApp/Files/Offline/transactions.xml";
$doc = new DOMDocument('1.0');
// we want a nice output
$doc->encoding = "UTF-8";
$doc->formatOutput = true;
$root = $doc->createElement('transactions');
$root = $doc->appendChild($root);
try {
	$db=new DBConnection();
	$numOfRows = 10000;
	if(isset($_GET['cid'])){$inputCurrency = $_GET['cid'];}else{$inputCurrency = NULL;}
	$phpLog->writeToFile("Currency = <$inputCurrency>.\n");
        if($inputCurrency == NULL){
            $query="call USP_GetTransactionsForXMLFile('$numOfRows',null);";
        }else{
            $query="call USP_GetTransactionsForXMLFile('$numOfRows','$inputCurrency');";
        }
	$sqlLog->writeToFile("$query\n");
	$res=$db->rq($query);
	while(($row=$db->fetch($res)) != FALSE) {
		$id = $row['ID'];
		$date = $row['Date'];
		$c = $row['Currency'];
		$aID = $row['AccountID'];
		$account = $row['AccountName'];
		$tTID = $row['TypeID'];
		$type = $row['Type'];
		$cID = $row['CategoryID'];
		$category = $row['Category'];
		$scID = $row['SubCategoryID'];
		$subcategory = $row['SubCategory'];
		$pID = $row['PayeeID'];
		$payee = $row['Payee'];
		$amount = $row['Amount'];
		$notes = $row['Notes'];
		$ConvertedValue =$row['ConvertedValue'];
                
		$l1 = $doc->createElement('transaction');
		$l1_attr = $doc->appendChild($l1);
		$l1_attr->setAttribute("ID", "t_".$id);
		$l1 = $root->appendChild($l1);

		// add date	
		$title = $doc->createElement('date');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($date);
		$text = $title->appendChild($text);
		
		// add currency	
		$title = $doc->createElement('currency');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($c);
		$text = $title->appendChild($text);
		
		// add account	
		$title = $doc->createElement('account');
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("ID", $aID);
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("name", $account);
		$title = $l1->appendChild($title);
		
		//$text = $doc->createTextNode($account);
		//$text = $title->appendChild($text);
		
		// add type	
		$title = $doc->createElement('type');
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("ID", $tTID);
		//$t_attr = $doc->appendChild($title);
		//$t_attr->setAttribute("name", $type);		
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($type);
		$text = $title->appendChild($text);
		
		// add category	
		$title = $doc->createElement('category');
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("ID", $cID);
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("name", $category);
		$title = $l1->appendChild($title);
		
		//$text = $doc->createTextNode($category);
		//$text = $title->appendChild($text);
		
		// add subcategory	
		$title = $doc->createElement('subcategory');
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("ID", $scID);
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("name", $subcategory);
		$title = $l1->appendChild($title);
		
		//$text = $doc->createTextNode($subcategory);
		//$text = $title->appendChild($text);
		
		// add payee	
		$title = $doc->createElement('payee');
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("ID", $pID);
		//$t_attr = $doc->appendChild($title);
		//$t_attr->setAttribute("name", $payee);
		$title = $l1->appendChild($title);
		
		$l2 = $doc->createElement('name');
		$l2 = $title->appendChild($l2);
		
		$text = $doc->createTextNode($payee);
		$text = $l2->appendChild($text);
		
		//$text = $doc->createTextNode($payee);
		//$text = $title->appendChild($text);
		
		// add amount	
		$title = $doc->createElement('amount');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($amount);
		$text = $title->appendChild($text);
		
                // add converted amount	
		$title = $doc->createElement('ConvertedValue');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($ConvertedValue);
		$text = $title->appendChild($text);
		
		// add notes	
		$title = $doc->createElement('notes');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($notes);
		$text = $title->appendChild($text);
	}
	$db->close();
} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}

//Save the XML in a physical file
//$doc->saveXML();
$strxml = $doc->saveXML();
/*Get currency symbol*/
$tmpfilename="";
switch ($inputCurrency){
        case NULL:
                $tmpfilename = "../Files/transactions_all.xml";
		break;
	case 1:
		$tmpfilename = "../Files/transactions_1.xml";
		break;
	case 2:
		$tmpfilename = "../Files/transactions_2.xml";
		break;
	case 3:
		$tmpfilename = "../Files/transactions_3.xml";
		break;
	default:
		break;}
echo('Writting file 1</br>');
$handle = fopen($tmpfilename, "w");
fwrite($handle, $strxml);
fclose($handle);
echo('Finished writting file 1</br>');
echo $tmpfilename . " ; <" . $inputCurrency . ">";
echo('<p>File 1 saved <a href="http://myapps.local/FinanceApp/Files/"'.$tmpfilename.'">here</a></p>');
?>