$(document).ready(function() {
	var cid=$.getUrlVar('cid');
	if(cid == undefined){cid=1;}
	//currencies
	var listOfCurrencies = [];
    $.get(location.protocol + "//" + location.host + "/FinanceApp/Files/currencies.xml", {}, function(xml){
    	$('item', xml).each(function(i) {
    		curName = $(this).find("name").text();
    		listOfCurrencies.push(curName);
    	});
    	
    	$("#currencyList").autocomplete({
			source: listOfCurrencies
			//typeAhead: true
		});
    });
	//accounts
	var listOfAccounts = [];
    $.get(location.protocol + "//" + location.host + "/FinanceApp/Files/accounts.xml", {}, function(xml){
    	$('item', xml).each(function(i) {
    		if($(this).find("cid").text() == cid){
	   			accName = $(this).find("name").text();
    			listOfAccounts.push(accName);
    		}
    	});
    	
    	$("#accountsList").autocomplete({
			source: listOfAccounts
			//typeAhead: true
		});
    });

    // transactionTypes
    var listOfTransacTypes = [];
    $.get(location.protocol + "//" + location.host + "/FinanceApp/Files/transactionTypes.xml", {}, function(xml){
    	$('item', xml).each(function(i) {
    		typeName = $(this).find("name").text();
    		listOfTransacTypes.push(typeName);
    	});
    	
    	$("#transactionTypeList").autocomplete({
			source: listOfTransacTypes
		});
    });
	// Categories with SubCategories
    //var selectedCatValue = ''; //Commented on 05-06-12
    var listOfCategories = [];
    $.get(location.protocol + "//" + location.host + "/FinanceApp/Files/categories.xml", {}, function(xml){
    	$('item', xml).each(function(i) {
    		catName = $(this).find("name").text();
    		listOfCategories.push(catName);
    	});
    	
    	$("#catList").autocomplete({
			source: listOfCategories,
			//select: AutoCompleteSelectHandler //Commented on 05-06-12
		});
    });
	// Categories Only
    //var selectedCatValue = ''; //Commented on 05-06-12
    var listOfCategoriesOnly = [];
    $.get(location.protocol + "//" + location.host + "/FinanceApp/Files/categoriesOnly.xml", {}, function(xml){
    	$('item', xml).each(function(i) {
    		catName = $(this).find("name").text();
    		listOfCategoriesOnly.push(catName);
    	});
    	
    	$("#catListOnly").autocomplete({
			source: listOfCategoriesOnly,
			//select: AutoCompleteSelectHandler //Commented on 05-06-12
		});
    });
    // Payees
    var listOfPayees = [];
    $.get(location.protocol + "//" + location.host + "/FinanceApp/Files/payees.xml", {}, function(xml){
    	$('item', xml).each(function(i) {
    		pName = $(this).find("name").text();
    		listOfPayees.push(pName);
    	});
    	
    	$("#payeeList").autocomplete({
			source: listOfPayees
		});
    });
});