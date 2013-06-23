<?php
require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once '../../BusinessClasses/PHP/Logger/sqlLogger.php';
require_once '../../BusinessClasses/PHP/Logger/phpLogger.php';
require_once '../../BusinessClasses/Utility/SimpleXMLWithAddOns.php';//Added on 15-09-12

$sqlLog = New sqlEventLogger();
$phpLog = New phpEventLogger();
$r['error'] = false;
$r['msg'] = "Default msg";

/*-----------------------*/
/* Process the form DATA */
/*-----------------------*/
if(isset($_POST['currency'])){$c = $_POST['currency'];}else{$c = 1;}
$idToDisable = $_POST['transactionID'];
$phpLog->writeToFile("TransactionID to disable: <$idToDisable>\n");

$xmlFileName = "../Files/Offline/transactions_$c.xml";

#CREATING THE HANDLER
$xml = simplexml_load_file($xmlFileName); //This line will load the XML file. 
$sxe = new SimpleXMLWithAddOns($xml->asXML());
#loop through the LinkGroups to find the one we're looking for
foreach($sxe as $t)
{
	$i=0;
	$phpLog->writeToFile('Loop: '.$i.' // '.$t['tID']." vs $idToDisable.\n");
	$i += 1;
	if ($t['tID'] == $idToDisable){
		$phpLog->writeToFile("TransactionID is found: <$t[id]>\n");
		$t->enable = 0;
		break;
    }
}
$phpLog->writeToFile("For loop exited.\n");
#WRITE THE RESULTS BACK TO THE XML FILE
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($sxe->asXML());
$formatted = $dom->saveXML();

//Save XML to file
$handle = fopen($xmlFileName, "w");
fwrite($handle, $formatted);
fclose($handle);

$r['error'] = false;
$r['msg'] = "Row has been disabled.";
echo json_encode($r);//return json obj with result
?>