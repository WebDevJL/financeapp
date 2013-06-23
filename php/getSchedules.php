<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/Logger/sqlLogger.php';
$sqlLog = New sqlEventLogger();
$r['error'] = false;
$r['msg'] = "Default msg";
$fileName = "../Files/schedules.xml";
$doc = new DOMDocument('1.0');
// we want a nice output
$doc->encoding = 'UTF-8';
$doc->formatOutput = true;
$root = $doc->createElement('items');
$root = $doc->appendChild($root);

//print out publication date
$l1 = $doc->createElement('pubDate');
$l1 = $root->appendChild($l1);
	
$text = $doc->createTextNode(date('m/d/Y h:i:s a', time()));
$text = $l1->appendChild($text);

//Added 21-11-12
$l1 = $doc->createElement('type');
$l1 = $root->appendChild($l1);
$text = $doc->createTextNode('schedules');
$text = $l1->appendChild($text);

try {
	//echo('<!--in try&catch-->');
	$db=new DBConnection();
	$numOfRows = 10000;
	//if(isset($_GET['cid'])){$c = $_GET['cid'];}else{$c = 1;}
	$c = $_GET['cid'];
	$query="CALL USP_GetSchedules ('$numOfRows','$c')";
	$res=$db->rq($query);
	if($res['error'] === true){
		$r['error'] = true;
		$r['msg'] = $res['msg'];
		echo json_encode($r);
		die();
	} else {
		$r['error'] = false;
		$r['msg'] = "DATA Returned!";
	}
	while(($row=$db->fetch($res)) != FALSE) {
		//echo('<!--in while-->');
		$i = 0;
		$id = $row['ID'];
		$date = $row['Date'];
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
		$scheduleInterval = $row['Interval'];
		$scheduleIntervalID = $row['IntervalID'];
		
		$l1 = $doc->createElement('item');
		$l1_attr = $doc->appendChild($l1);
		$l1_attr->setAttribute("ID", "s_".$id);
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
		
        //add interval
        $title = $doc->createElement('interval');
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("ID", $scheduleIntervalID);
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("name", $scheduleInterval);
		$title = $l1->appendChild($title);
    
		// add account	
		$title = $doc->createElement('account');
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("ID", $aID);
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("name", $account);
		$title = $l1->appendChild($title);
		
		// add type	
		$title = $doc->createElement('type');
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("ID", $tTID);
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("name", $type);
		$title = $l1->appendChild($title);
		
		// add category	
		$title = $doc->createElement('category');
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("ID", $cID);
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("name", $category);
		$title = $l1->appendChild($title);
		
		// add subcategory	
		$title = $doc->createElement('subcategory');
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("ID", $scID);
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("name", $subcategory);
		$title = $l1->appendChild($title);
		
		// add payee	
		$title = $doc->createElement('payee');
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("ID", $pID);
		$t_attr = $doc->appendChild($title);
		$t_attr->setAttribute("name", $payee);
		$title = $l1->appendChild($title);
		
		// add amount	
		$title = $doc->createElement('amount');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($amount);
		$text = $title->appendChild($text);
		
		// add notes	
		$title = $doc->createElement('notes');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($notes);
		$text = $title->appendChild($text);
	}
	$db->close();
} catch (Exception $e) {
	//$r['msg'] = ('Caught exception: ',  $e->getMessage(), "\n";
}

//Save the XML in a physical file
//$doc->saveXML();
$strxml = $doc->saveXML();
/*Get currency symbol*/
$tmpfilename="";
switch ($c){
	case 1:
		$tmpfilename = "../Files/schedules_1.xml";
		break;
	case 2:
		$tmpfilename = "../Files/schedules_2.xml";
		break;
	case 3:
		$tmpfilename = "../Files/schedules_3.xml";
		break;
	default:
		break;}
$handle = fopen($tmpfilename, "w");
fwrite($handle, $strxml);
fclose($handle);

$r['msg'] = "XML file refreshed!";
echo json_encode($r);
?>