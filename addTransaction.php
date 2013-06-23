<?php
/**
 * @author Marijan Šuflaj <msufflaj32@gmail.com>
 * @link http://www.php4every1.com
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Add Transaction</title>
		<?php include 'config/html-header-online.php' ?>
    </head>

    <body>
	    <div id="online" class="nav"></div>
        <div id="wrapper1">
            <form class="box" action="" method="post">
                <fieldset>
                    <legend class="ui-header">Insert a transaction</legend>
                   	<INPUT id="datepicker" class="defaultText" name="transactionDate" type="text" title="Select Date"/>
				    <INPUT id="accountsList" class="defaultText" name="accountName" type="text" title="Select Account"/>
<!-- 					<INPUT id="cT" name="clearedTransaction" type="checkbox" value="1"/> -->
					<INPUT id="transactionTypeList" class="defaultText" name="transactionType" type="text" title="Select Type"/>
					<INPUT id="catList" class="defaultText" name="category" type="text" title="Select Category"/>
<!-- 					<INPUT id="subcatList" class="defaultText" name="subCategory" type="text" title="Select SubCategory"/> -->
					<INPUT id="payeeList" class="defaultText" name="payee" type="text" title="Select Payee"/>
					<INPUT id="amountValue" class="defaultText" name="amount" type="text" title="Enter Amount"/>
					<INPUT id="notesValue" class="defaultText" name="notes" type="text" title="Notes if any"/>
					<INPUT id="add_transaction" type="submit" name="submitForm" value="Add" />
					<div id="dialogBox">Message will appear here</div>
                </fieldset>
            </form>
   		</div>
		<script>
		$(function() {
		
			$( "#datepicker" ).datepicker();
			$( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
		});
		</script>
    </body>
</html>