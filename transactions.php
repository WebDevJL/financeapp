<?php
require_once '../BusinessClasses/PHP/DatabaseUtility/db.class.php';
require_once '../BusinessClasses/PHP/Logger/sqlLogger.php';
require_once '../BusinessClasses/PHP/Logger/phpLogger.php';
require_once '../BusinessClasses/Utility/Pagination.php';
//get currency from request
if(isset($_GET['cid'])){$c = $_GET['cid'];}else{$c = 1;}
/* Business Classes required */
// Properties to show next/prev or page numbers links
$config['showpagenumbers'] = false; //true or false
$config['showprevnext'] = true; //true or false
$startIndex = 0;//start row to select from on DB. Will be calculated based on page number and number of rows per page.
$limit = 10;//max rows per page. Used to calculate the number of pages.
$page = 1;//page number
$Pagination = new Pagination();//new pager obj
$sqlLog = New sqlEventLogger();
$phpLog = New phpEventLogger();
$aID = 'null';//accountID
$tTID = 'null';//transaction type id
$catID = 'null';//categoryID
$scID = 'null';//subCategoryID
$pID = 'null';//payeeID
$sDate = '1990-01-01';//start date filter
$eDate = '2100-01-01';//end date filter
$totalrows = 0;//var to calculate number of pages
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Overview</title>
		<?php include 'config/html-header-online.php' ?>
    </head>
    <body>
	    <div id="online" class="nav"></div>
    	<div class="content">
    	<!-- Filters panel -->
	    	<div id="wrapper1">
	            <form class="box" action="" method="get">
	                <fieldset>
	                    <legend class="ui-header">Filters</legend>
	                   	<INPUT id="datepickerStart" class="defaultText" name="startDate" type="text" title="Select Start Date"/>
	                   	<INPUT id="datepickerEnd" class="defaultText" name="endDate" type="text" title="Select End Date"/>
					    <INPUT id="accountsList" class="defaultText" name="accountName" type="text" title="Select Account"/>
	<!-- 					<INPUT id="cT" name="clearedTransaction" type="checkbox" value="1"/> -->
						<INPUT id="transactionTypeList" class="defaultText" name="transactionType" type="text" title="Select Type"/>
						<INPUT id="catList" class="defaultText" name="category" type="text" title="Select Category"/>
	<!-- 					<INPUT id="subcatList" class="defaultText" name="subCategory" type="text" title="Select SubCategory"/> -->
						<INPUT id="payeeList" class="defaultText" name="payee" type="text" title="Select Payee"/>
<!-- 						<INPUT id="amountValue" class="defaultText" name="amount" type="text" title="Enter Amount"/> -->
<!-- 						<INPUT id="notesValue" class="defaultText" name="notes" type="text" title="Notes if any"/> -->
						<INPUT id="submit" type="submit" name="submitForm" value="Apply Filters" />
	                </fieldset>
	            </form>
	   		</div>
	   		<script>
			$(function() {
				$( "#datepickerStart" ).datepicker();
				$( "#datepickerEnd" ).datepicker();
			});
			</script>
			<!-- End of Filters panel -->
    		<div class="box" id="transactionsdb">
    			<table class="table" id="latestPan">
				  <tr class="row">
					<th class="ui-header column1">Date</th>
					<th class="ui-header column2">Account</th>
					<th class="ui-header column4">Type</th>
					<th class="ui-header column5">Category</th>
					<th class="ui-header column6">SubCategory</th>
					<th class="ui-header column7">Payee</th>
					<th class="ui-header column8">Amount</th>
					<th class="ui-header column9">Notes</th>
				  </tr>
    			<?php
    			//$phpLog->writeToFile("accountName: (".$_GET['accountName']."); \n");
/*accountID lookup*/
//get account value from request and find id in xml
					if(isset($_GET['accountName'])){
						if (file_exists('Files/accounts.xml')) {
				    		$xml = simplexml_load_file('Files/accounts.xml');
				    		foreach($xml->account as $obj){
					 		 	if ($obj->name == $_GET['accountName']) {
						 			$aID = $obj->id;
							 		unset($obj);
							 		$phpLog->writeToFile("get accountID - ID=$aID\n");
						 		}
				    		}
						} else {
						    exit('Failed to open Files/accounts.xml.');
						}
					}else{$aID = 'null';}
/*End of accountID lookup*/
/*transactionType lookup*/
//get transactionType value from request and find id in xml
					if(isset($_GET['transactionType'])){
						if (file_exists('Files/transactionTypes.xml')) {
				    		$xml = simplexml_load_file('Files/transactionTypes.xml');
				    		foreach($xml->type as $obj){
					 		 	if ($obj->name == $_GET['transactionType']) {
						 			$tTID = $obj->id;
							 		unset($obj);
							 		$phpLog->writeToFile("get transactionType - ID=$tTID\n");
						 		}
				    		}
						} else {
						    exit('Failed to open Files/transactionTypes.xml.');
						}
					}else{$tTID = 'null';}
/*End of transactionType lookup*/
/*category lookup*/
//get category value from request and find id in xml
					if(isset($_GET['category'])){
						if (file_exists('Files/categories.xml')) {
				    		$xml = simplexml_load_file('Files/categories.xml');
				    		foreach($xml->category as $obj){
					 		 	if ($obj->name == $_GET['category']) {
						 			$tmpID = $obj->id;
						 			$idArray = explode(":",$tmpID);
						 			$catID = $idArray[0];
						 			$scID = $idArray[1];
							 		unset($obj);
							 		$phpLog->writeToFile("get Category/SubCategory - catID=$catID; sCatID=$scID\n");
						 		}
				    		}
						} else {
						    exit('Failed to open Files/categories.xml.');
						}
					}else{
						$cID = 'null';
						$scID = 'null';
					}
/*End of category lookup*/
/*payee lookup*/
//get payee value from request and find id in xml
					if(isset($_GET['payee'])){
						if (file_exists('Files/payees.xml')) {
				    		$xml = simplexml_load_file('Files/payees.xml');
				    		foreach($xml->payee as $obj){
					 		 	if ($obj->name == $_GET['category']) {
						 			$pID = $obj->id;
							 		unset($obj);
							 		$phpLog->writeToFile("get Payee - payeeID=$pID\n");
						 		}
				    		}
						} else {
						    exit('Failed to open Files/payees.xml.');
						}
					}else{$pID = 'null';}
/*End of payee lookup*/
					$phpLog->writeToFile("dates filters: start:$_GET[startDate] and end:$_GET[endDate]\n");
/*start date lookup*/
//get start date value from request and process it
					if(isset($_GET['startDate']) && ($_GET['startDate']) != "Select Start Date"){
						$sDate = $_GET['startDate'];
						$sDate = date("Y-m-d", strtotime($sDate));
					}
/*End of start date lookup*/
/*end date lookup*/
//get end date value from request and process it
					if(isset($_GET['endDate']) && ($_GET['endDate']) != "Select End Date"){
						$eDate = $_GET['endDate'];
						$eDate = date("Y-m-d", strtotime($eDate));
					}
/*End of end date lookup*/
					$phpLog->writeToFile("dates filters: start:$sDate and end:$eDate\n");
/*Get total rows*/
					$db=new DBConnection();
					$query="CALL USP_GetNumberOfRowsUsingFilters_Transactions ($c,$aID,$tTID,$catID,$scID,$pID,'$sDate','$eDate');";
					$res=$db->rq($query);
					$sqlLog->writeToFile("$query\n");
					while(($row=$db->fetch($res)) != FALSE) {$totalrows = $row['total'];}
					$resFree = $db->free_result($res);
					$db->close();
					$phpLog->writeToFile("totalrows=$totalrows;page=$page,limit=$limit\n");
					$query_string = $_SERVER['QUERY_STRING'];
					$phpLog->writeToFile("query string=$query_string\n");
/*generate paging*/
					if(isset($_GET['page']) && is_numeric(trim($_GET['page']))){$page = $_GET['page'];}else{$page = 1;}
					if($config['showprevnext'] == true){
						$prev_link = $Pagination->showPrev($totalrows,$page,$limit);
						$phpLog->writeToFile("totalrows=$totalrows;page=$page,limit=$limit\n");
						$next_link = $Pagination->showNext($totalrows,$page,$limit);
						$phpLog->writeToFile("totalrows=$totalrows;page=$page,limit=$limit\n");
					}else{$prev_link=null;$next_link=null;}
/*print out the pagination*/
					if(!($prev_link==null && $next_link==null && $pagination_links==null)){
						echo '<div class="pagination">'."\n";
						echo $prev_link;
						echo $pagination_links;
						echo $next_link;
						echo '<div style="clear:both;"></div>'."\n";
						echo "</div>\n";
					}
					$startIndex = $Pagination->getStartRow($page,$limit);//calculate the row index to select data from					
					$phpLog->writeToFile("totalrows=$totalrows;page=$page,limit=$limit;startIndex=$startIndex\n");
/*Get currency symbol*/
					switch ($c){
						case 1:
							$cSymbol = "&euro;";
							break;
						case 2:
							$cSymbol = "Fr.";
							break;
						case 3:
							$cSymbol = "$";
							break;
						default:
							break;
					}
/*Get transactions based on filters*/
					$db=new DBConnection();
					$query="call USP_GetTransactions($startIndex,$limit,$c,$aID,$tTID,$catID,$scID,$pID,'$sDate','$eDate');";
					$res=$db->rq($query);
					$sqlLog->writeToFile("$query\n");
					while(($row=$db->fetch($res)) != FALSE) {
		 				echo '<tr class="row">';//Open row
		 				echo '<td>'. $row['Date'].'</td>';
		 				echo '<td>'. $row['AccountName'].'</td>';
		 				echo '<td>'. $row['Type'].'</td>';
		 				echo '<td>'. $row['Category'].'</td>';
		 				echo '<td>'. $row['SubCategory'].'</td>';
		 				echo '<td class="cell column7">'. $row['Payee'].'</td>';
		 				IF($row['Amount']>0){
		 					echo '<td class="cell column8 positive">'.$cSymbol.' '. $row['Amount'].'</td>';
		 				}	ELSE	{ 	
		 					echo '<td class="cell column8 negative">'.$cSymbol.' '. $row['Amount'].'</td>';
		 				}
		 				echo '<td class="cell column9 last">'. $row['Notes'].'</td>';
		 				echo '</tr>';//Close row
					}
					$db->close();
				?>
				</table>
    		</div>
    	</div>
	</body
</html>