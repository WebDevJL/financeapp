<?php
require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
if(isset($_GET['cid'])){$c = $_GET['cid'];}else{$c = 1;}
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
		break;}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Add transaction</title>
		<?php include '../config/html-header-offline.php' ?>
    </head>
    <body>
	<!-- Menu panel div -->
		<div id="mp_off"></div>
	<!-- Content panel div -->
		<div id="cp">
		<!-- Content panel inputs div -->
            <form id="cpi" class="box" action="" method="post">
                <fieldset>
                    <legend class="ui-header">Insert a transaction</legend>
                   	<INPUT id="datepicker" class="defaultText" name="transactionDate" type="text" title="Select Date"/>
				    <INPUT id="accountsList" class="defaultText" name="accountName" type="text" title="Select Account"/>
					<INPUT id="transactionTypeList" class="defaultText" name="transactionType" type="text" title="Select Type"/>
					<INPUT id="catList" class="defaultText" name="category" type="text" title="Select Category"/>
					<INPUT id="payeeList" class="defaultText" name="payee" type="text" title="Select Payee"/>
					<INPUT id="amountValue" class="defaultText" name="amount" type="text" title="Enter Amount"/>
					<INPUT id="notesValue" class="defaultText" name="notes" type="text" title="Notes if any"/>
					<INPUT id="add_offlineTransaction" type="submit" name="submitForm" value="Add" />
					<div id="dialogBox">Message will appear here</div>
                </fieldset>
            </form>
            <script>
				$(function() {$( "#datepicker" ).datepicker();});
			</script>
		<!-- End of Content panel inputs div -->
		<!-- Content panel data div -->
			<div id="cpd2" class="box">
				<table>
				  <tr>
					<th class="col1">Date</th>
					<th class="col2">Account</th>
					<th class="col3">Type</th>
					<th class="col4">Category</th>
					<th class="col5">SubCategory</th>
					<th class="col6">Payee</th>
					<th class="col7">Amount</th>
					<th class="col8">Notes</th>
				  </tr>
				</table>
			</div>	
		<!-- End of Content panel data div -->
		</div>
	<!-- End of Content panel div -->	
    </body>
</html>