<?php
require_once '../BusinessClasses/PHP/DatabaseUtility/db.class.php';
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
		<title>Overview</title>
		<?php include 'config/html-header-online.php' ?>
		<script src="js/ui-home-tab1-offline.js"></script>
    </head>
    <body>
    	<div id="wrapper0">
	    	<div id="online" class="nav"></div>
	    	<div class="clear"></div>
	    	<!-- Start content -->
	    	<div class="content" id="main_wrap_home">
		    	<div id="slider_home" class="nav box"></div>
<!-- 		    	<div class="clear"></div> -->
				<div class="box current" id="wrapper1">
					<!-- overview Panel -->
					<div id="overviewPan"></div>
					<!-- end overview Panel -->
					<!-- budget Panel -->
					<div id="budgetPan"></div>
					<!-- end budget Panel -->
				</div>
				<div class="box" id="wrapper3">
					<!-- latest transactions Panel -->
						<table id="latestPan">
						  <tr>
							<th>Date</th>
							<th>Account</th>
							<th>Type</th>
							<th>Category</th>
							<th>SubCategory</th>
							<th>Payee</th>
							<th>Amount</th>
							<th>Notes</th>
						  </tr>
						<?php
							$db=new DBConnection();
							$query="call USP_GetTransactions(0,10,$c,NULL,NULL,NULL,NULL,NULL,NULL,NULL);";
							$res=$db->rq($query);
							while(($row=$db->fetch($res)) != FALSE) {
					 			echo '<tr>';//Open row
					 			echo '<td>';
					 			echo ''. $row['Date'].'</td>';
					 			echo '<td>';
					 			echo ''. $row['AccountName'].'</td>';
					 			echo '<td>';
					 			echo ''. $row['Type'].'</td>';
					 			echo '<td>';
					 			echo ''. $row['Category'].'</td>';
					 			echo '<td>';
					 			echo ''. $row['SubCategory'].'</td>';
					 			echo '<td>';
					 			echo ''. $row['Payee'].'</td>';
					 			IF($row['Amount']>0){
					 				echo '<td class="positive">';
					 				echo $cSymbol.' '. $row['Amount'].'</td>';
					 			}	ELSE	{ 	
					 				echo '<td class="negative">';
					 				echo $cSymbol.' '. $row['Amount'].'</td>';
					 			}
					 			echo '<td>';
					 			echo ''. $row['Notes'].'</td>';
					 			echo '</tr>';//Close row
							}
							$db->close();
						?>
						</table>
					<!-- end latest transactions Panel -->
				</div>
				<div class="box" id="wrapper4">
					<!-- events Panel -->
						<table id="eventsPan">
						  <tr>
							<th>Date</th>
							<th>Account</th>
		<!-- 					<th class="ui-header column3">Status</th> -->
							<th>Type</th>
							<th>Category</th>
							<th>SubCategory</th>
							<th>Payee</th>
							<th>Amount</th>
							<th>Notes</th>
						  </tr>
						<?php
							$db=new DBConnection();
							$query="CALL USP_GetSchedules(10,$c);";
							$res=$db->rq($query);
							while(($row=$db->fetch($res)) != FALSE) {
					 			echo '<tr>';//Open row
					 			echo '<td>';
					 			echo ''. $row['Date'].'</td>';
					 			echo '<td>';
					 			echo ''. $row['AccountName'].'</td>';
		/*
					 			echo '<td class="cell column3">';
					 			echo ''. $row['Status'].'</td>';
		*/
					 			echo '<td>';
					 			echo ''. $row['Type'].'</td>';
					 			echo '<td>';
					 			echo ''. $row['Category'].'</td>';
					 			echo '<td>';
					 			echo ''. $row['SubCategory'].'</td>';
					 			echo '<td>';
					 			echo ''. $row['Payee'].'</td>';
					 			IF($row['Amount']>0){
					 				echo '<td class="positive">';
					 				echo '&euro; '. $row['Amount'].'</td>';
					 			}	ELSE	{ 	
					 				echo '<td class="negative">';
					 				echo '&euro; '. $row['Amount'].'</td>';
					 			}
					 			echo '<td>';
					 			echo ''. $row['Notes'].'</td>';
					 			echo '</tr>';//Close row
							}
							$db->close();
						?>
						</table>
					<!-- end events Panel -->
				</div>
	    	</div><!-- End content -->
    	</div>
	</body>
</html>