<!DOCTYPE html>
<html>
	<head>
		<title>Search transactions</title>
		<?php include '../config/html-header-offline.php' ?>
		<script src="../js/ui-transactions-filter-offline.js"></script>
		<script src="../js/ui-disableRowAjax.js"></script>
    </head>
    <body>
	<!-- Menu panel div -->
		<div id="mp_off"></div>
	<!-- Content panel div -->
		<div id="cp">
		<!-- Content panel filters div -->
            <form id="cpi" class="h box" action="" method="post">
                <fieldset>
	                    <legend class="ui-header">Filters</legend>
<!-- 	                   	<INPUT id="limit" class="defaultText" name="Limit" type="text" title="Rows per page" value="100"/> -->
	                   	<INPUT id="datepickerStart" class="defaultText" name="startDate" type="text" title="Select Start Date"/>
	                   	<INPUT id="datepickerEnd" class="defaultText" name="endDate" type="text" title="Select End Date"/>
					    <INPUT id="accountsList" class="defaultText" name="accountName" type="text" title="Select Account"/>
						<INPUT id="transactionTypeList" class="defaultText" name="transactionType" type="text" title="Select Type"/>
						<INPUT id="catList" class="defaultText" name="category" type="text" title="Select Category"/>
						<INPUT id="payeeList" class="defaultText" name="payee" type="text" title="Select Payee"/>
						<INPUT id="filterXML_Offline" type="submit" name="submitForm" value="Apply Filters" />
						<p id="resultSummary">Summary will appear here</p>
                </fieldset>
            </form>
            <script>
				$(function() {
				$( "#datepickerStart" ).datepicker();
				$( "#datepickerEnd" ).datepicker();
			});
			</script>
		<!-- End of Content panel filters div -->
		<!-- Content panel data div -->
			<div class="h box" id="transactionsXML_Offline"></div>
		<!-- End of Content panel data div -->
		</div>
	<!-- End of Content panel div -->	
    </body>
</html>