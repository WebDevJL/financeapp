$(document).ready(function() {
	var cid=$.getUrlVar('cid');
	if(cid == undefined){cid=1;}
	//currencies
    buildAutoCompleteFromXML(
        {
            url : "../Files/currencies.xml",
            id :"#currencyList",
            type : {val:"normal"},
            cache : true,
            timeout : 360000});
	//accounts
    buildAutoCompleteFromXML(
        {
            url : "../Files/accounts.xml",
            id :"#accountsList",
            type : {val:"condition",filter:cid},
            cache : true,
            timeout : 360000});
    //if($(this).find("cid").text() == cid){
    // transactionTypes
    buildAutoCompleteFromXML(
        {
            url : "../Files/transactionTypes.xml",
            id :"#transactionTypeList",
            type : {val:"normal"},
            cache : true,
            timeout : 360000});
	// Categories with SubCategories
    buildAutoCompleteFromXML(
        {
            url : "../Files/categories.xml",
            id :"#catList",
            type : {val:"normal"},
            cache : true,
            timeout : 360000});
	// Categories Only
    buildAutoCompleteFromXML(
        {
            url : "../Files/categoriesOnly.xml",
            id :"#catListOnly",
            type : {val:"normal"},
            cache : true,
            timeout : 360000});
    // Payees
    buildAutoCompleteFromXML(
        {
            url : "../Files/payees.xml",
            id :"#payeeList",
            type : {val:"normal"},
            cache : true,
            timeout : 360000});
    // Intervals
    buildAutoCompleteFromXML(
        {
            url : "../Files/intervals.xml",
            id :"#intervalList",
            type : {val:"normal"},
            cache : true,
            timeout : 360000});
});