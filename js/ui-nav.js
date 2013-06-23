$(document).ready(function() {
  //alert(window.location.pathname);
  var sPath = window.location.pathname;
	var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
	//Online navigation bar
	var onlineMenu = '<ul>';
	onlineMenu += '<li class="button degug"><p>w='+ window.innerWidth+'px</p><p>h='+window.innerHeight+'px</p></li>';
	onlineMenu += '<li><a class="button currency" href="'+sPage+'?cid=1">&euro;</a></li>';
  onlineMenu += '<li><a class="button currency" href="'+sPage+'?cid=2">Fr.</a></li>';
  onlineMenu += '<li><a class="button currency" href="'+sPage+'?cid=3">$</a></li>';
  onlineMenu += '<li><a class="button tab" id="homeLink" href="'+$.createUrl('index.php','')+'">Home</a></li>';
  onlineMenu += '<li><a class="button tab" id="addTransaction" href="'+$.createUrl('addTransaction.php','')+'">Add</a></li>';
  onlineMenu += '<li><a class="button tab" id="tLink" href="'+$.createUrl('transactions.php','')+'">Transactions</a></li>';
/*     onlineMenu += '<li><a class="button" id="rLink" href="'+$.createUrl('reports.php','')+'">Reports</a></li>'; */
  onlineMenu += '<li><a class="button" id="sLink" href="'+$.createUrl('schedules.php','')+'">Schedules</a></li>';
  onlineMenu += '<li><a class="button tab" id="settingsLink" href="'+$.createUrl('settings.php','')+'">Preferences</a></li>';
  onlineMenu += '<li><a class="button tab" id="settingsLink" href="'+$.createUrl('../Offline/'+sPage,'')+'">Go Offline</a></li>';
  onlineMenu += '</ul>';
  $("#online").html(onlineMenu);
  $("#mp").html(onlineMenu);

  //Offline navigation bar
  var offlineMenu = '<ul>';
	offlineMenu += '<li class="button degug"><p>w='+ window.innerWidth+'px</p><p>h='+window.innerHeight+'px</p></li>';
	offlineMenu += '<li><a class="button currency" href="'+sPage+'?cid=1">&euro;</a></li>';
  offlineMenu += '<li><a class="button currency" href="'+sPage+'?cid=2">Fr.</a></li>';
  offlineMenu += '<li><a class="button currency" href="'+sPage+'?cid=3">$</a></li>';
  offlineMenu += '<li><a class="button tab" id="homeLink" href="'+$.createUrl('index.php','')+'">Home</a></li>';
  offlineMenu += '<li><a class="button tab" id="addTransaction" href="'+$.createUrl('addTransaction.php','')+'">Add</a></li>';
  offlineMenu += '<li><a class="button tab" id="tLink" href="'+$.createUrl('transactions.php','')+'">Transactions</a></li>';
/*     offlineMenu += '<li><a class="button" id="rLink" href="'+$.createUrl('reports.php','')+'">Reports</a></li>'; */
/*     offlineMenu += '<li><a class="button" id="sLink" href="'+$.createUrl('scheduler.php','')+'">Schedules</a></li>'; */
  offlineMenu += '<li><a class="button tab" id="settingsLink" href="'+$.createUrl('settings.php','')+'">Preferences</a></li>';
  offlineMenu += '<li><a class="button tab" id="settingsLink" href="'+$.createUrl('../Online/'+sPage,'')+'">Go Online</a></li>';
  offlineMenu += '</ul>';
  $("#offline").html(offlineMenu);
  $("#mp_off").html(offlineMenu);

    //Home secondary nav bar
  var slider_home = '<ul id="sub_menu">';
  slider_home += '<li class="current"><a href="#wrapper1">Overview</a></li>';
	slider_home += '<li><a href="#wrapper3">Latest transactions</a></li>';
	slider_home += '<li><a href="#wrapper4">Incoming Events</a></li>';
 	slider_home += '</ul>';
  $("#slider_home").html(slider_home);
	$("#cpm").html(slider_home);
	
    //Settings secondary nav bar
  var slider_settings = '<ul id="sub_menu">';
  slider_settings += '<li><a href="#settings_cur">Currencies</a></li>';
	slider_settings += '<li class="current"><a href="#settings_acc">Accounts</a></li>';
	slider_settings += '<li><a href="#settings_cat">Categories</a></li>';
	slider_settings += '<li><a href="#settings_scat">SubCategories</a></li>';
	slider_settings += '<li><a href="#settings_pay">Payees</a></li>';
	//slider_settings += '<li><a href="#settings_sch">Schedules</a></li>';
 	slider_settings += '</ul>';
  $("#slider_settings").html(slider_settings);
});