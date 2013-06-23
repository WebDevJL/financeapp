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
		<?php include '../config/html-header-offline.php' ?>
		<script src="../js/ui-home-tab1-offline.js"></script>
    </head>
    <body>
	<!-- Menu panel div -->
		<div id="mp_off"></div>
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
			</div>
		<!-- End of Content panel data div -->
		</div>
	<!-- End of Content panel div -->	
    </body>
</html>