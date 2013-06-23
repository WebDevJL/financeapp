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
		<title>Overview</title>
		<meta charset="UTF-8">
		<?php include '../config/html-header-online.php' ?>
		<script src="../js/ui-home-tab1-online.js"></script>
    </head>
    <body>
	<!-- Menu panel div -->
		<div id="mp"></div>
	<!-- Content panel div -->
		<div id="cp_h">
		<!-- Content panel menu div -->
			<div id="cpm">
			
			</div>
		<!-- End of Content panel data div -->	
		<!-- Content panel data div -->
			<div id="cpd">
				<div id="wrapper1" class="box current">
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
							$query="CALL USP_InsertScheduledTransactions()";
							$res=$db->rq($query);
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
			</div>
		<!-- End of Content panel data div -->
		</div>
	<!-- End of Content panel div -->	
    </body>
</html>