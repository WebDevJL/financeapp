<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Get Categories and SubCategories</title>
	</head>
	<body>
		<?php /*
		 // Connects to your Database 
		 mysql_connect("localhost", "root", "root") or die(mysql_error()); 
		 mysql_select_db("FinanceApp") or die(mysql_error()); 
		 
		 // Collects data from "Accounts" table 
		 $data = mysql_query("Select * from Categories C INNER JOIN SubCategories SC on C.categoryID=SC.categoryID ORDER BY C.categoryID") 
		 or die(mysql_error()); 
		 
		 // puts the "Accounts" info into the $info array 
		 $info = mysql_fetch_array( $data ); 
		 
	 	Print "".$info['categoryID'] . ","; 
	 	Print "".$info['categoryName'] . ","; 
	 	Print "".$info['subCategoryID'] . ","; 
	 	Print "".$info['subCategoryName'] . "<br/>"; 

		 // Print out the contents of the first entry
		 while($info = mysql_fetch_array( $data )) 
		 {
		 	Print "".$info['categoryID'] . ","; 
		 	Print "".$info['categoryName'] . ","; 
		 	Print "".$info['subCategoryID'] . ","; 
		 	Print "".$info['subCategoryName'] . "<br/>"; 
		 }
		*/?>
		<table border="1">
			<th>categoryID</th>
			<th>categoryName</th>
			<th>subCategoryID</th>
			<th>subCategoryName</th>
			<?php
			require_once '../../BusinessClasses/PHP/DatabaseUtility/db.class.php';
			$db=new DBConnection();
			$query='Select * from Categories C INNER JOIN SubCategories SC on C.categoryID=SC.categoryID ORDER BY C.categoryID';
			$res=$db->rq($query);
			while(($row=$db->fetch($res)) != FALSE) {
			 echo '<tr><td>'. $row['categoryID'].'</td><td style="text-align:right;">'.$row['subCategoryID'].'</td>';
			 echo '<td>'. $row['categoryName'].'</td><td style="text-align:right;">'.$row['subCategoryName'].'</td></tr>';
			}
			$db->close();
 			?>
 		</table>
	</body>
</html>
