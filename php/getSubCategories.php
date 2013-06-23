<?php
$fileName = "../Files/subCategories.xml";
$doc = new DOMDocument('1.0');
// we want a nice output
$doc->encoding = 'UTF-8';
$doc->formatOutput = true;
$root = $doc->createElement('items');
$root = $doc->appendChild($root);
//Added 21-11-12
$l1 = $doc->createElement('type');
$l1 = $root->appendChild($l1);
$text = $doc->createTextNode('subcategories');
$text = $l1->appendChild($text);

try {
	echo('<!--in try&catch-->');
	require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
	$db=new DBConnection();
	$query='CALL USP_GetSubCategories ()';
	$res=$db->rq($query);
	while(($row=$db->fetch($res)) != FALSE) {
		echo('<!--in while-->');
		$i = 0;
		$catName = $row['CategoryName'];
		$catID = $row['CategoryID'];//Added on 2400512
		
		$mergeValueCat = $catName . ' (' . $catID . ')';//Added on 240512
		
		$name = $row['SubCategoryName'];
		$id = $row['SubCategoryID'];
		
		$mergeValue = $name . ' (' . $id . ')';//Added on 240512
		
		echo('<!--got values-->');
			
		$l1 = $doc->createElement('item');
		$l1_attr = $doc->appendChild($l1);
		//Uncommented on 310512
		$l1_attr->setAttribute("cID", $catID);//Commented on 240512
		//Commented on 310512
		//$l1_attr->setAttribute("categoryName", $mergeValueCat);//Added on 240512
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
		/* Commented on 310512 */
		/*
		$title = $doc->createElement('name');//Added on 240512
		$title = $l1->appendChild($title);//Added on 240512
		
		$text = $doc->createTextNode($mergeValue);//Added on 240512
		$text = $title->appendChild($text);//Added on 240512
		*/
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