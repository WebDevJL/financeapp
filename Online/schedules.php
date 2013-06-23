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
		<title>Add scheduled transaction</title>
		<?php include '../config/html-header-online.php' ?>
    </head>
    <body>
	<!-- Menu panel div -->
		<div id="mp"></div>
	<!-- Content panel div -->
		<div id="cp">
            <span id="show_insert_form">Insert</span>
            <span id="insert_form" class="schedules">Insert Form</span>
            <span id="update_form" class="schedules">Update Form</span>
            <span id="delete_form" class="schedules">Delete Form</span>
			<div id="table" class="schedules"></div>
		<!-- End of Content panel data div -->
		</div>
	<!-- End of Content panel div -->	
    </body>
</html>