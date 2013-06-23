<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/Logger/sqlLogger.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BusinessClasses/PHP/Logger/phpLogger.php';
$sqlLog = New sqlEventLogger();
$phpLog = New phpEventLogger();
$r['error'] = false;
$r['msg'] = "Default msg";
$fileName = "../Files/budgetSettings.xml";
$doc = new DOMDocument('1.0');
// we want a nice output
$doc->encoding = 'UTF-8';
$doc->formatOutput = true;
$root = $doc->createElement('budgets');
$root = $doc->appendChild($root);
try {
	//echo('<!--in try&catch-->');
	$db=new DBConnection();
	$query='CALL USP_GetBudgetSettings ()';
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
	$lastbID=0;
	$i = 0;
	$phpLog->writeToFile("Start while Loop;\n");
	while(($row=$db->fetch($res)) != FALSE) {
		$bName = $row['BudgetName'];
		$bID = $row['BudgetID'];
		$bAmount = $row['BudgetAmount'];
		$bs_CatID = $row['CategoryID'];
		$bs_ScatID = $row['SubCategoryID'];
		$phpLog->writeToFile("Loop $i: lastbID=$lastbID ; bID=$bID;\n");
		$check =0;
		if($lastbID === $bID){
			$check = 1;//"continue_CURRENT"
			$phpLog->writeToFile("Loop $i: check=$check;\n");
		}else{
			$check =2;//"add_NEW"
			$phpLog->writeToFile("Loop $i: check=$check;\n");
		}
		
		//Add new budget
		if($check == 2){
			//open budget tag
			$l1 = $doc->createElement('budget');
			$l1 = $root->appendChild($l1);
			//write the budget name
			$title = $doc->createElement('name');
			$title = $l1->appendChild($title);
			$text = $doc->createTextNode($bName);
			$text = $title->appendChild($text);
			//write the budget id
			$title = $doc->createElement('id');
			$title = $l1->appendChild($title);
			$text = $doc->createTextNode($bID);
			$text = $title->appendChild($text);
			//write the budget amount
			$title = $doc->createElement('amount');
			$title = $l1->appendChild($title);
			$text = $doc->createTextNode($bAmount);
			$text = $title->appendChild($text);
			//open items tag to write the item CatID/ScatID
			$items = $doc->createElement('items');
			$items = $l1->appendChild($items);
			//write the first item
			$item = $doc->createElement('item');
			$item_attr = $doc->appendChild($item);
			$item_attr->setAttribute("CatID", $bs_CatID);
			$item2_attr = $doc->appendChild($item);
			$item2_attr->setAttribute("ScatID", $bs_ScatID);
			$item = $items->appendChild($item);
		}
		//Continue adding to current budget items
		if($check == 1){
			$item = $doc->createElement('item');
			$item_attr = $doc->appendChild($item);
			$item_attr->setAttribute("CatID", $bs_CatID);
			$item2_attr = $doc->appendChild($item);
			$item2_attr->setAttribute("ScatID", $bs_ScatID);
			$item = $items->appendChild($item);
		}
		$lastbID = $bID;
		$i+=1;
	}
	$phpLog->writeToFile("End while Loop;\n");
	$db->close();
} catch (Exception $e) {}
$l1 = $root->appendChild($l1);
//Save the XML in a physical file
$doc->saveXML();
$strxml = $doc->saveXML();
$handle = fopen($fileName, "w");
fwrite($handle, $strxml);
fclose($handle);

$r['msg'] = "XML file refreshed!";
echo json_encode($r);
?>