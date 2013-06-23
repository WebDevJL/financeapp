<?php
$fileName = "../Files/transfers.xml";
$doc = new DOMDocument('1.0');
// we want a nice output
$doc->formatOutput = true;
$root = $doc->createElement('items');
$root = $doc->appendChild($root);
try {
	echo('<!--in try&catch-->');
	require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
	$db=new DBConnection();
	$query='CALL USP_GetAccountIDForSubCategoryID ()';
	$res=$db->rq($query);
	while(($row=$db->fetch($res)) != FALSE) {
		echo('<!--in while-->');
		$i = 0;
		$accountID = $row['AccountID'];
		$scid = $row['SubCategoryID'];
		
		$l1 = $doc->createElement('item');
		$l1 = $root->appendChild($l1);
		
		$title = $doc->createElement('accountID');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($accountID);
		$text = $title->appendChild($text);
			
		$title = $doc->createElement('subCategoryID');
		$title = $l1->appendChild($title);
		
		$text = $doc->createTextNode($scid);
		$text = $title->appendChild($text);
		$i+=1;
		echo('<!--end of loop'.$i.'-->');	
	}
	$db->close();
} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}

//Save the XML in a physical file
$doc->saveXML();
$strxml = $doc->saveXML();
$handle = fopen($fileName, "w");
fwrite($handle, $strxml);
fclose($handle);

echo('File saved <a href="'.$fileName.'">here</a>')
?>