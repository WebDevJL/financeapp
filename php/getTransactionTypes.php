<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/Logger/sqlLogger.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/Logger/phpLogger.php';
$sqlLog = New sqlEventLogger();
$phpLog = New phpEventLogger();
$r['error'] = false;
$r['msg'] = "Default msg";
$fileName = "../Files/transactionTypes.xml";
$doc = new DOMDocument('1.0');
// we want a nice output
$doc->encoding = 'UTF-8';
$doc->formatOutput = true;
$root = $doc->createElement('items');
$root = $doc->appendChild($root);
//Added 21-11-12
$l1 = $doc->createElement('type');
$l1 = $root->appendChild($l1);
$text = $doc->createTextNode('transactionTypes');
$text = $l1->appendChild($text);


try {
	$db=new DBConnection();
	$query='CALL USP_GetTransactionTypes ()';
	$res=$db->rq($query);
	if($res['error'] === true){
		$r['error'] = true;
		$r['msg'] = $res['msg'];
		$phpLog->writeToFile("problem with DB result\n");
		echo json_encode($r);
		die();
	} else {
		$sqlLog->writeToFile("$query\n");
		$phpLog->writeToFile("Query has run: <$query>.\n");
		$r['error'] = false;
		$r['msg'] = "Added to DB!";
	}
	while(($row=$db->fetch($res)) != FALSE) {
		$i = 0;
		$name = $row['Type'];
		$id = $row['TypeID'];
				
		$mergeValue = $name . ' (' . $id . ')';//Added on 240512

		$l1 = $doc->createElement('item');
		$l1 = $root->appendChild($l1);
		
		/* Commented on 240512 */
		/* Uncommented on 310512 */
		$title = $doc->createElement('name');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($name);
		$text = $title->appendChild($text);
			
		$title = $doc->createElement('id');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($id);
		$text = $title->appendChild($text);
		
		/* Uncommented on 310512 */
		/*
		$title = $doc->createElement('name');//Added on 240512
		$title = $l1->appendChild($title);//Added on 240512
		
		$text = $doc->createTextNode($mergeValue);//Added on 240512
		$text = $title->appendChild($text);//Added on 240512
		*/
	}
	$db->close();
} catch (Exception $e) {}

//Save the XML in a physical file
$doc->saveXML();
$strxml = $doc->saveXML();
$handle = fopen($fileName, "w");
fwrite($handle, $strxml);
fclose($handle);
$r['msg'] = "XML file refreshed!";
echo json_encode($r);
?>