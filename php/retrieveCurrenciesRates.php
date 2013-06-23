<?php
require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once '../../BusinessClasses/PHP/Logger/sqlLogger.php';
$sqlLog = New sqlEventLogger();

    //This is aPHP(5)script example on how eurofxref-daily.xml can be parsed
    //Read eurofxref-daily.xml file in memory
    //For the next command you will need the config option allow_url_fopen=On (default)
    switch ($_GET['src']) {
        case 'today':
            $XML=simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
            break;
        case '90d':
            $XML=simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist-90d.xml");
            break;
        case 'all':
            $XML=simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist.xml");
            break;
        default:
            break;
    }
    //the file is updated daily between 2.15 p.m. and 3.00 p.m. CET
    foreach($XML->Cube->Cube as $date)
    {
        $rateDate = $date["time"];
        //print_r($date);
        echo '<br/>';
        foreach($date->Cube as $rate){
            //Output the value of 1EUR for a currency code
            $query = "";
            $db=new DBConnection();
            if($_GET["db"] === "sb"){
                $query = "CALL soundbudget.USP_InsertCurrencyRate('".$rateDate."','".$rate["currency"]."','".$rate["rate"]."');\n";
                $res=$db->rq($query);                
            }
            if($_GET["db"] === "fa"){
                $query = "CALL financeapp.USP_InsertCurrencyRate('".$rateDate."','".$rate["currency"]."','".$rate["rate"]."');\n";
                $res=$db->rq($query);                
            }
            if($_GET["db"] === "all"){
                $query = "CALL financeapp.USP_InsertCurrencyRate('".$rateDate."','".$rate["currency"]."','".$rate["rate"]."');\n";
                $res=$db->rq($query);                
                $query = "CALL soundbudget.USP_InsertCurrencyRate('".$rateDate."','".$rate["currency"]."','".$rate["rate"]."');\n";
                $res2=$db->rq($query);                
            }
            //$sqlLog->writeToFile("$query");
            //echo $query . "</br>";
            $db->close();
            //--------------------------------------------------
            //Here you can add your code for inserting
            //$rate["rate"] and $rate["currency"] into your database
            //--------------------------------------------------
        }
    }
?>