<!DOCTYPE html>
<html>
	<head>
		<title>Settings</title>
		<meta charset="UTF-8">
		<?php include '../config/html-header-online.php' ?>
    </head>
    <body>
    <!-- Menu panel div -->
      <div id="mp"></div>
    <!-- Content panel div -->
      <div id="cp_h">
        <form class="box" method="post">
          <fieldset>
            <legend class="ui-header">Actualize the xml feeds</legend>
              <INPUT class="button" id="getCurrencies" type="submit" name="getCurrencies" value="Refresh currencies.xml" />
              <INPUT class="button" id="getAccounts" type="submit" name="getAccounts" value="Refresh accounts.xml" />
              <INPUT class="button" id="getCatsLong" type="submit" name="getCats" value="Refresh categories.xml" />
              <INPUT class="button" id="getCatsOnly" type="submit" name="getCats" value="Refresh categoriesOnly.xml" />
              <INPUT class="button" id="getPayees" type="submit" name="getPayees" value="Refresh payees.xml" />
              <INPUT class="button" id="getTypes" type="submit" name="getTypes" value="Refresh transactionTypes.xml" />
              <INPUT class="button" id="getTransactions" type="submit" name="getTransactions" value="Refresh transactions.xml" />
              <INPUT class="button" id="getBudgets" type="submit" name="getBudgets" value="Refresh budgetSettings.xml" />
              <INPUT class="button" id="getSchedules" type="submit" name="getSchedules" value="Schedules" />
              <div id="setting_dialogRefresh">Message will appear here</div>
          </fieldset>
        </form>
<!-- navigation settings -->
        <div id="slider_settings" class="nav"></div>
        <div class="clear"></div>
<!-- main div settings -->
        <div id="main_wrap_settings" class="content">
          <div id="settings_dialogBox">Message will appear here</div>
<!-- start currencies -->
          <div class="box" id="settings_cur">
            <form method="post">
              <fieldset>
                <legend class="ui-header">Add new currency</legend>
                  <INPUT id="currName" class="defaultText" name="currName" type="text" title="Enter Currency Name"/>
                  <INPUT id="currSymb" class="defaultText" name="currSymb" type="text" title="Enter Currency Symbol"/>
                  <INPUT id="add_curr" type="submit" name="submitForm" value="Add" />
              </fieldset>
            </form>
          <div class="box" id="cur_dataset"></div>
          </div>
<!-- end of currencies -->
<!-- start accounts -->
          <div class="box current" id="settings_acc">
            <form method="post">
              <fieldset>
                <legend class="ui-header">Add new account</legend>
                <INPUT id="currencyList" class="defaultText" name="currencyID" type="text" title="Select Currency"/>
                <INPUT id="accountName" class="defaultText" name="accountName" type="text" title="Enter account Name"/>
                <INPUT id="add_acc" type="submit" name="submitForm" value="Add" />
              </fieldset>
            </form>
            <div class="box" id="acc_dataset"></div>
          </div>
<!-- end of accounts -->
<!-- start cats -->
          <div class="box" id="settings_cat">
            <div class="clear"></div>
            <form method="post">
              <fieldset>
                <legend class="ui-header">Add new category</legend>
                <INPUT id="catName" class="defaultText" name="catName" type="text" title="Enter category Name"/>
                <INPUT id="add_cat" type="submit" name="submitForm" value="Add" />
              </fieldset>
            </form>
            <div class="box" id="cat_dataset"></div>
          </div>
<!-- end of cats -->
<!-- start sub cats -->
          <div class="box" id="settings_scat">
            <div class="clear"></div>
            <form method="post">
              <fieldset>
                <legend class="ui-header">Add new subCategory</legend>
                <INPUT id="catListOnly" class="defaultText" name="catName" type="text" title="Select category Name"/>
                <INPUT id="scatName" class="defaultText" name="scatName" type="text" title="Enter subCategory Name"/>
                <INPUT id="add_scat" type="submit" name="submitForm" value="Add" />
              </fieldset>
            </form>
            <div class="box" id="scat_dataset"></div>
          </div>
<!-- end of sub cats -->
<!-- start payees -->
          <div class="box" id="settings_pay">
            <div class="clear"></div>
            <form method="post">
              <fieldset>
                <legend class="ui-header">Add new payee</legend>
                <INPUT id="payeeName" class="defaultText" name="payeeName" type="text" title="Enter payee Name"/>
                <INPUT id="add_payee" type="submit" name="submitForm" value="Add" />
              </fieldset>
            </form>
            <div class="box" id="payee_dataset"></div>
          </div>
<!-- end of payees -->
<!-- start schedules -->
          <div class="box" id="settings_sch">
            <div class="clear"></div>
            <form method="post">
              <fieldset>
                <legend class="ui-header">Add new schedule</legend>
                <p>To be built :)</p>
                <INPUT id="add_schedule" type="submit" name="submitForm" value="Add" />
              </fieldset>
            </form>
            <div class="box" id="sch_dataset"></div>
          </div>
<!-- end of schedules -->
        </div>
<!-- end main div settings -->
      </div>
      <div class="box" id="edit_overlay">Display edit panel here.</div>
      <!-- End content -->
    </body>
</html>