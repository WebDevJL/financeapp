$(document).ready(function() {
    // Payees
    /*var listOflinks = [];
    $.get("Files/navigationBar.xml", {}, function(xml){
    	$('a', xml).each(function(i) {
    		cssClass = "class:" + $(this).find("class").text();
    	});
    });*/
    //Main nav bar - commun to all pages
    //alert(window.location.pathname);
    var sPath = window.location.pathname;
	var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
    $("nav#offline").html('<a class="button currency first" href="'+sPage+'?cid=1">&euro;</a>');
    $("nav#offline").append('<a class="button currency" href="'+sPage+'?cid=2">Fr.</a>');
    $("nav#offline").append('<a class="button currency" href="'+sPage+'?cid=3">$</a>');
    $("nav#offline").append('<a class="button" id="homeLink" href="'+$.createUrl('index.php','')+'">Home</a>');
    $("nav#offline").append('<a class="button" id="addTransaction" href="'+$.createUrl('addTransaction.php','')+'">Add</a>');
    $("nav#offline").append('<a class="button" id="tLink" href="'+$.createUrl('transactions.php','')+'">Transactions</a>');
	$("nav#offline").append('<a class="button last" id="settingsLink" href="'+$.createUrl('index.php','')+'">Go Online</a>');
    //Home secondary nav bar
    $("div#slider_home").html('<div id="tab1_home" class="tab current first"><a href="#wrapper1">Overview</a></div>');
	$("div#slider_home").append('<div id="tab2_home" class="tab"><a href="#wrapper3">Latest transactions</a></div>');
	$("div#slider_home").append('<div id="tab3_home" class="tab last"><a href="#wrapper4">Incoming Events</a></div>');
    //Settings secondary nav bar
    $("div#slider_settings").html('<div id="tab1_settings" class="tab first"><a href="#settings_cur">Currencies</a></div>');
	$("div#slider_settings").append('<div id="tab2_settings" class="tab current"><a href="#settings_acc">Accounts</a></div>');
	$("div#slider_settings").append('<div id="tab3_settings" class="tab"><a href="#settings_cat">Categories</a></div>');
	$("div#slider_settings").append('<div id="tab4_settings" class="tab"><a href="#settings_scat">SubCategories</a></div>');
	$("div#slider_settings").append('<div id="tab5_settings" class="tab last"><a href="#settings_pay">Payees</a></div>');
	
	//
	

});