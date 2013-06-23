$(document).ready(function() {  
/* 	alert($("table.box").width()); */
	$("table.box").css("left", ($("div#transactions").width()-$("table.box").width())/2);
});