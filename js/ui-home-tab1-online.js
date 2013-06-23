$(document).ready(function(){
	var cid=$.getUrlVar('cid');
	if(cid == undefined){cid="1";}
//hide dialogs DIVs
	$('#dialogBox').hide();
	$('#settings_dialogBox').hide();
//Fill the tab 1 containing the account balance and budgets
	$('#main_wrap_home').ready(function() {
/******************************************************************************************************************************************/
/* Fill accounts balance table */
/******************************************************************************************************************************************/
		if ($.jStorage.get("currency", '') !== '' && $.jStorage.get("currency", '') !== undefined){if($.jStorage.get("currency", '') !== cid){$.jStorage.flush();}}
		var cSymbol = "";
		var htmlStr_AccountBalance = '';
		var htmlStr_Budgets = '';
		switch (cid){
			case "1":
				cSymbol = "&euro;";
				$.jStorage.set("currency", cid);
				break;
			case "2":
				cSymbol = "Fr.";
				$.jStorage.set("currency", cid);
				break;
			case "3":
				cSymbol = "$";
				$.jStorage.set("currency", cid);
				break;
			default:
				cSymbol = "N/A";
				$.jStorage.set("currency", cid);
				break;
		}
		//Check local storage
		var tmpStr_1 = $.jStorage.get("AccountsBalance_Str", '');
		var tmpStr_2 = $.jStorage.get("Budgets_Str", '');
		if(tmpStr_1 !== '' && tmpStr_1 !== undefined ){htmlStr_AccountBalance =tmpStr_1;}
		if(tmpStr_2 !== '' && tmpStr_2 !== undefined ){htmlStr_Budgets =tmpStr_2;}
		//Local checked
		//Only build the table if not the local storage
		if(htmlStr_AccountBalance === ''){
			$('#wrapper1').empty();
			var i=0, j=0;
			//Get filters data
			var url = "../Files/accounts.xml";
			var xml = new JKL.ParseXML( url );
			var tmpobj1 = xml.parse();
			var accounts = [];
			//Filter accounts list:
			//	-Add "balance" variable to store the balance of account while looping through the transactions later on.
			//	-Add only accounts matching current currency
			for (var j = 0; j < tmpobj1.items.item.length; j++){
				if(cid === tmpobj1.items.item[j].cid && !(tmpobj1.items.item[j].id==="9" || tmpobj1.items.item[j].id==="10" || tmpobj1.items.item[j].id==="15" || tmpobj1.items.item[j].id==="16" || tmpobj1.items.item[j].id==="28")){
					tmpobj1.items.item[j]["balance"]=0;
					accounts.push(tmpobj1.items.item[j]);
				}
			}
			//obj1.accounts["Full_balance"] = 0;//Add "Full_balance" for overall balance of all accounts.
			//console.log(accounts);//print object in console
			url = "../Files/transactions_"+cid+".xml";
			xml = new JKL.ParseXML( url );
			var obj2 = xml.parse();
			for (var i = 0; i < obj2.transactions.transaction.length; i++){//loop through each transaction
				for (var j = 0; j < accounts.length; j++){//loop through each account until found
					if(accounts[j].id === obj2.transactions.transaction[i].account.ID){//if accountID match then add amount to account balance
						accounts[j].balance += (1*obj2.transactions.transaction[i].amount);
						break;
					}
				}
			}
			//Print out the account/balance array
		    htmlStr_AccountBalance += '<table class="table"><tr class="row">';
			htmlStr_AccountBalance += '<th class="ui-header">Account</th>';
			htmlStr_AccountBalance += '<th class="ui-header">Balance</th>';
			htmlStr_AccountBalance += '</tr>';
			for (var j = 0; j < accounts.length; j++){
				htmlStr_AccountBalance += '<tr>';
		    	htmlStr_AccountBalance += '<td>'+accounts[j].name+'</td>';
		    	if(accounts[j].balance > 0){
		    	htmlStr_AccountBalance += '<td class="positive">'+cSymbol+' '+(accounts[j].balance).toFixed(2)+'</td>';
		    	}else{
		    	htmlStr_AccountBalance += '<td class="negative">'+cSymbol+' '+(accounts[j].balance).toFixed(2)+'</td>';
		    	}
		    	htmlStr_AccountBalance += '</tr>';
			}				
			htmlStr_AccountBalance += '</table>';
		}
		$("#wrapper1").html(htmlStr_AccountBalance);
		//Store output string in local storage
		//cache table
        //if(tmpStr_1 === ''){$.jStorage.set("AccountsBalance_Str", htmlStr_AccountBalance, {TTL : 60000});}
/******************************************************************************************************************************************/
/* Fill budget table*/
/******************************************************************************************************************************************/
		if(htmlStr_Budgets === ''){
			url = "../Files/transactions_"+cid+".xml";
			xml = new JKL.ParseXML( url );
			var obj2 = xml.parse();
			console.log(obj2);
	
			url = "../Files/budgetSettings.xml";
			xml = new JKL.ParseXML( url );
			var obj3 = xml.parse();
			for (var i = 0; i < obj3.budgets.budget.length; i++){
				obj3.budgets.budget[i]["balance"]=0;
			}
			console.log(obj3);
			for (var i = 0; i < obj2.transactions.transaction.length; i++){//loop through each transaction
				if(obj2.transactions.transaction[i].currency === cid){
					for (var j = 0; j < obj3.budgets.budget.length; j++){//loop through each budget
						if (obj3.budgets.budget[j].items.item.length === undefined){//current budget has one item so length is undefined 
							if(obj2.transactions.transaction[i].category.ID === obj3.budgets.budget[j].items.item.CatID && obj2.transactions.transaction[i].subcategory.ID === obj3.budgets.budget[j].items.item.ScatID){
								obj3.budgets.budget[j].balance += (1*obj2.transactions.transaction[i].amount);
								break;
							}
						} else {//current budget has more than one item so length is an int
							for (var k = 0; k < obj3.budgets.budget[j].items.item.length; k++){//loop through each item of budget
								if(obj2.transactions.transaction[i].category.ID === obj3.budgets.budget[j].items.item[k].CatID && obj2.transactions.transaction[i].subcategory.ID === obj3.budgets.budget[j].items.item[k].ScatID){//if categorID and subCategoryId match, add amount to budget balance
									obj3.budgets.budget[j].balance += (1*obj2.transactions.transaction[i].amount);
									break;
								}
							}
						}
					}
				}
			}
			var savingCheck = 0;
			var cogIterance = 0;
			var cogBalance = 0;
			for (var j = 0; j < accounts.length; j++){
				var accountCheck = 0;
				//if current account is 
				if(accounts[j].id === "2" || accounts[j].id === "3" || accounts[j].id === "4" || accounts[j].id === "5" || accounts[j].id === "7" || accounts[j].id === "8" || accounts[j].id === "26" || accounts[j].id === "27"){accountCheck=1;}
				for (var k = 0; k < obj3.budgets.budget.length; k++){
					//for the budget "Savings", invert value which is positive to negative
					if (savingCheck !== 1 && obj3.budgets.budget[k].id === "26" && obj3.budgets.budget[k].balance !== 0){
						obj3.budgets.budget[k].balance *= (-1);
						savingCheck = 1;
					}
					//for the budget "Savings", add to budget balance the account balance when accountCheck is true
					if (obj3.budgets.budget[k].id === "26" && accountCheck === 1){obj3.budgets.budget[k].balance += accounts[j].balance;}
					//finally, calculate the cogBalance which will be used to calculate the budget "Savings" balance.
					if ((obj3.budgets.budget[k].id === "21" || obj3.budgets.budget[k].id === "22" || obj3.budgets.budget[k].id === "23") && cogIterance < 3){
						cogBalance -= obj3.budgets.budget[k].balance;
						cogIterance += 1;
					}
				}
			}
			//Print out the account/balance array
		    htmlStr_Budgets += '<table><tr>';
			htmlStr_Budgets += '<th>Budget</th>';
			htmlStr_Budgets += '<th>Amount</th>';
			htmlStr_Budgets += '<th>Balance</th>';
			htmlStr_Budgets += '</tr>';
			for (var j = 0; j < obj3.budgets.budget.length; j++){
				htmlStr_Budgets += '<tr>';
		    	htmlStr_Budgets += '<td>'+obj3.budgets.budget[j].name+'</td>';
		    	htmlStr_Budgets += '<td>'+obj3.budgets.budget[j].amount+'</td>';
		    	if (obj3.budgets.budget[j].id === "26"){obj3.budgets.budget[j].balance += cogBalance;}
		    	if(obj3.budgets.budget[j].balance > 0){
		    		htmlStr_Budgets += '<td class="positive">'+cSymbol+' '+(obj3.budgets.budget[j].balance).toFixed(2)+'</td>';
		    	}else{
		    		htmlStr_Budgets += '<td class="negative">'+cSymbol+' '+(obj3.budgets.budget[j].balance).toFixed(2)+'</td>';
		    	}
		    	htmlStr_Budgets += '</tr>';
			}				
			htmlStr_Budgets += '</table><br clear="all">';
		}
		$("#wrapper1").append(htmlStr_Budgets);
		//Store output string in local storage
		//cache table
        //if(tmpStr_2 === ''){$.jStorage.set("Budgets_Str", htmlStr_Budgets, {TTL : 60000});}
	});
});