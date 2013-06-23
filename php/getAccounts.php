<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/Logger/sqlLogger.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/Logger/phpLogger.php';
$sqlLog = New sqlEventLogger();
$phpLog = New phpEventLogger();
$r['error'] = false;
$r['msg'] = "Default msg";
$fileName = "../Files/accounts.xml";
$doc = new DOMDocument('1.0');
// we want a nice output
$doc->encoding = 'UTF-8';
$doc->formatOutput = true;
$root = $doc->createElement('items');
$root = $doc->appendChild($root);

//Added 21-11-12
$l1 = $doc->createElement('type');
$l1 = $root->appendChild($l1);
$text = $doc->createTextNode('accounts');
$text = $l1->appendChild($text);

//Added 24-10-12
$l1 = $doc->createElement('pubDate');
$l1 = $root->appendChild($l1);
	
$text = $doc->createTextNode(date('m/d/Y h:i:s a', time()));
$text = $l1->appendChild($text);

try {
	//echo('<!--in try&catch-->');
	$db=new DBConnection();
	$query='CALL USP_GetAccounts ()';
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
		//echo('<!--in while-->');
		$i = 0;
		$name = $row['AccountName'];
		$id = $row['AccountID'];
		$cid = $row['Currency'];
		
		$mergeValue = $name . ' (' . $id . ')';//Added on 240512
		
		//echo('<!-- ' . $name . ' ' . $id . 'got values-->');
			
		$l1 = $doc->createElement('item');
		$l1 = $root->appendChild($l1);
		
		/*Commented on 240512*/
		/*UnCommented on 310512*/
		$title = $doc->createElement('name');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($name);
		$text = $title->appendChild($text);
			
		$title = $doc->createElement('id');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($id);
		$text = $title->appendChild($text);
		
		//Added on 190712
		$title = $doc->createElement('cid');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($cid);
		$text = $title->appendChild($text);

		/* Commented on 310512 */
		/*
		$title = $doc->createElement('name');//Added on 240512
		$title = $l1->appendChild($title);//Added on 240512
		
		$text = $doc->createTextNode($mergeValue);//Added on 240512
		$text = $title->appendChild($text);//Added on 240512
		*/
		$i+=1;
		//echo('<!--end of loop'.$i.'-->');	
	}
	$db->close();
} catch (Exception $e) {
	//$r['msg'] = ('Caught exception: ',  $e->getMessage(), "\n";
}

//Save the XML in a physical file
$doc->saveXML();
$strxml = $doc->saveXML();
$handle = fopen($fileName, "w");
fwrite($handle, $strxml);
fclose($handle);

$r['msg'] = "XML file refreshed!";
echo json_encode($r);
?>