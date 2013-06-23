$(document).ready(function(){
	var cid=$.getUrlVar('cid');
	if(cid == undefined){cid=1;}
//hide dialogs DIVs
	$('#dialogBox').hide();
	$('#settings_dialogBox').hide();
//Process insert offline transaction POST
	$('#add_offlineTransaction').click(function() {
		$.ajax({
			type : 'POST',
			url : location.protocol + "//" + location.host + "/FinanceApp/php/insertTransactionInFile.php",
			dataType : 'json',
			data: {
				currency : cid,
				transactionDate : $('#datepicker').val(),
				accountName : $('#accountsList').val(),
				transactionType : $('#transactionTypeList').val(),
				category : $('#catList').val(),
				payee : $('#payeeList').val(),
				amount : $('#amountValue').val(),
				notes : $('#notesValue').val()
			},
			success : function(data){
				$('#dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#dialogBox').html(data.msg);
				setTimeout(function() {
        			$("#dialogBox").hide('blind', {}, 500)
    			}, 5000);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
});