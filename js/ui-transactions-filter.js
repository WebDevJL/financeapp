$(document).ready(function(){
	var cid=$.getUrlVar('cid');
	if(cid == undefined){cid="1";}
//hide dialogs DIVs
	$('#dialogBox').hide();
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
	$('#filterXML_Online').click(function() {
		$('#transactionsXML').empty();
		//Get filters data
		var sDate = new Date("1900-01-01"), eDate = new Date("2100-01-01"), acc = "", tt = "", cat = "", scat = "", pay = "";
		var tr=0, amountFiltered=0, check=0, checkAcc=0, checkTT=0, checkCat=0, checkPay=0;
		if ($('#datepickerStart').val() !== "Select Start Date"){sDate= new Date($.formatISO($('#datepickerStart').val()))};
		if ($('#datepickerEnd').val() !== "Select End Date"){eDate= new Date($.formatISO($('#datepickerEnd').val()))};
		if ($('#accountsList').val() !== "Select Account"){acc=$('#accountsList').val()};
		if ($('#transactionTypeList').val() !== "Select Type"){tt=$('#transactionTypeList').val()};
		if ($('#catList').val() !== "Select Category"){cat=$('#catList').val()};
		if ($('#payeeList').val() !== "Select Payee"){pay=$('#payeeList').val()};
		$.get(location.protocol + "//" + location.host + "/FinanceApp/Files/transactions_"+cid+".xml",function(data){
			var htmlOutputStr = '';
	    	htmlOutputStr += '<table><tr>';
			htmlOutputStr += '<th>Date</th>';
			htmlOutputStr += '<th>Account</th>';
			htmlOutputStr += '<th>Type</th>';
			htmlOutputStr += '<th>Category</th>';
			htmlOutputStr += '<th>SubCategory</th>';
			htmlOutputStr += '<th>Payee</th>';
			htmlOutputStr += '<th>Amount</th>';
			htmlOutputStr += '<th>Notes</th>';
			htmlOutputStr += '</tr>';
			$(data).find('transaction').each(function(){
				currentDate = new Date($(this).find("date").text());
				catObj = $(this).find("category").attr("name")+":"+$(this).find("subcategory").attr("name");
				check=0, checkAcc=0, checkTT=0, checkCat=0, checkPay=0;
				//alert(acc === $(this).find("account").text());
				if(acc === "" || acc === $(this).find("account").attr("name")){
					checkAcc=1;
				}else{
					checkAcc=0;
				}
				if(checkAcc===1 && (tt === "" || tt === $(this).find("type").attr("name"))){
					checkTT=1;
				}else{
					checkTT=0;
				}
				if(checkTT===1 && (cat === "" || cat === catObj)){
					checkCat=1;
				}else{
					checkCat=0;
				}
				//if(scat === "null" || scat === $(this).find("subcategory").text()){check=1;}else{check=0;}
				if(checkCat===1 && (pay === "" || pay === $(this).find("payee").find("name").text())){
					checkPay=1;
				}else{
					checkPay=0;
				}
				if(sDate <= currentDate && eDate >= currentDate && checkPay===1){
					check=1;
				}else{
					check=0;
				}
				//if(eDate >= currentDate){check=1;}else{check=0;}
				//alert(check);
				if(check===1){
					tr+=1;//count transaction
					htmlOutputStr += '<tr>';
		    		htmlOutputStr += '<td class="column1">'+$(this).find("date").text()+'</td>';
		    		htmlOutputStr += '<td class="column2">'+$(this).find("account").attr("name")+'</td>';
		    		htmlOutputStr += '<td class="column4">'+$(this).find("type").text()+'</td>';
		    		//htmlOutputStr += '<td class="column5">'+$(this).find("category").text()+'</td>';
		    		//Modified on 06-09-12
		    		htmlOutputStr += '<td class="column5">'+$(this).find("category").attr("name")+'</td>';
		    		//htmlOutputStr += '<td class="column6">'+$(this).find("subcategory").text()+'</td>';
		    		//Modified on 06-09-12
		    		htmlOutputStr += '<td class="column6">'+$(this).find("subcategory").attr("name")+'</td>';
		    		htmlOutputStr += '<td class="column7">'+$(this).find("payee").text()+'</td>';
		    		//Added on 06-09-12
		    		var amountClass="positive";
                    if($(this).find("account").attr("name") !== "N/A"){amountFiltered+=1*($(this).find("amount").text());}
		    		if(1*($(this).find("amount").text())<0){amountClass="negative";}
		    		htmlOutputStr += '<td class="column8 '+amountClass+'">'+$(this).find("amount").text()+'</td>';
		    		htmlOutputStr += '<td class="column9">'+$(this).find("notes").text()+'</td>';
		    		htmlOutputStr += '</tr>';
				}
			});	
    		htmlOutputStr += '</table>';
   			$("#transactionsXML").html(htmlOutputStr);
			$('#resultSummary').html('<p>transactions returned: '+tr);
			$('#resultSummary').append('<p>Total spent: '+amountFiltered);
			/*$('#resultSummary').append('<p>From Date: '+sDate+'</p>');
			$('#resultSummary').append('<p>To Date: '+eDate+'</p>');
			$('#resultSummary').append('<p>account: '+acc+'</p>');
			$('#resultSummary').append('<p>type: '+tt+'</p>');
			$('#resultSummary').append('<p>category: '+cat+'</p>');
			$('#resultSummary').append('<p>payee: '+pay+'</p>');*/
			check=0;
			console.log(htmlOutputStr);
		});
		return false;
	});
});