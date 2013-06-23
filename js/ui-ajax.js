$(document).ready(function(){
	var cid=$.getUrlVar('cid');
	if(cid == undefined){cid=1;}
//hide dialogs DIVs
	$('#dialogBox').hide();
	$('#settings_dialogBox').hide();
//Process insert account POST
	$('#add_acc').click(function() {
		$.ajax({
			type : 'POST',
			url : "../php/insert.php",
			dataType : 'json',
			data: {
				type : "acc",
				currencyDefault : cid,
				currency : $('#currencyList').val(),
				accountName : $('#accountName').val()
			},
			success : function(data){
				$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
				setTimeout(function() {
        			$("#settings_dialogBox").hide('blind', {}, 500)
    			}, 5000);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
				$("#acc_dataset").html(data.dataset);
			},
			error: function(data) {
            	$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
//Process insert transaction POST
	$('#add_transaction').click(function() {
		$.ajax({
			type : 'POST',
			url : "../php/insertTransactionInDB.php",
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
				$('#dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show('fade', {}, 500);
				if (data.error === true)
					$('#dialogBox').html(data.msg);
				setTimeout(function() {
        			$("#dialogBox").hide('fade', {}, 500)
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
//Process insert category POST
	$('#add_cat').click(function() {
		$.ajax({
			type : 'POST',
			url : "../php/insert.php",
			dataType : 'json',
			data: {
				type : "cat",
				catName : $('#catName').val()
			},
			success : function(data){
				/*$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
				setTimeout(function() {
        			$("#settings_dialogBox").hide('blind', {}, 500)
    			}, 5000);*/$("#cat_dataset").html(data.dataset);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
//Process insert subCategory POST
	$('#add_scat').click(function() {
		$.ajax({
			type : 'POST',
			url : "../php/insert.php",
			dataType : 'json',
			data: {
				type : "scat",
				catName : $('#catListOnly').val(),
				scatName : $('#scatName').val()
			},
			success : function(data){
				$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
				setTimeout(function() {
        			$("#settings_dialogBox").hide('blind', {}, 500)
    			}, 5000);
          $("#scat_dataset").html(data.dataset);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
//Process insert payee POST
	$('#add_payee').click(function() {
		$.ajax({
			type : 'POST',
			url : "../php/insert.php",
			dataType : 'json',
			data: {
				type : "payee",
				payeeName : $('#payeeName').val()
			},
			success : function(data){
				/*$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
				setTimeout(function() {
        			$("#settings_dialogBox").hide('blind', {}, 500)
    			}, 5000);*/$("#payee_dataset").html(data.dataset);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
//Process insert currency POST
	$('#add_curr').click(function() {
		$.ajax({
			type : 'POST',
			url : "../php/insert.php",
			dataType : 'json',
			data: {
				type : "curr",
				currName : $('#currName').val(),
				currSymb : $('#currSymb').val()
			},
			success : function(data){
				/*$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
				setTimeout(function() {
        			$("#settings_dialogBox").hide('blind', {}, 500)
    			}, 5000);*/$("#cur_dataset").html(data.dataset);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
//Get Accounts
	$('#acc_dataset').ready(function() {
		$.ajax({
			type : 'POST',
      url : "../php/getData.php",
      dataType : 'json',
      data: {type : "acc", currency : cid},
      cache : false,
			success : function(data){
				/*$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
				setTimeout(function() {
          $("#settings_dialogBox").hide('blind', {}, 500)}, 5000);
				*/$("#acc_dataset").html(data.dataset);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
//Get Currencies
	$('#cur_dataset').ready(function() {
		$.ajax({
			type : 'POST',url : "../php/getData.php",dataType : 'json',data: {type : "curr"},
			success : function(data){
				/*$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
				setTimeout(function() {$("#settings_dialogBox").hide('blind', {}, 500)}, 5000);
				*/$("#cur_dataset").html(data.dataset);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
//Get Payees
	$('#payee_dataset').ready(function() {
		$.ajax({
			type : 'POST',url : "../php/getData.php",dataType : 'json',data: {type : "payee"},
			success : function(data){
				/*$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
				setTimeout(function() {$("#settings_dialogBox").hide('blind', {}, 500)}, 5000);
				*/$("#payee_dataset").html(data.dataset);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
//Get Categories
	$('#cat_dataset').ready(function() {
		$.ajax({
			type : 'POST',url : "../php/getData.php",dataType : 'json',data: {type : "cat"},
			success : function(data){
				/*$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
				setTimeout(function() {$("#settings_dialogBox").hide('blind', {}, 500)}, 5000);
				*/$("#cat_dataset").html(data.dataset);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
//Get SubCategories
	$('#scat_dataset').ready(function() {
		$.ajax({
			type : 'POST',url : "../php/getData.php",dataType : 'json',data: {type : "scat"},
			success : function(data){
				/*$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
				setTimeout(function() {$("#settings_dialogBox").hide('blind', {}, 500)}, 5000);
				*/$("#scat_dataset").html(data.dataset);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
//Process insert offline transaction POST
	$('#add_offlineTransaction').click(function() {
		$.ajax({
			type : 'POST',
			url : "../php/insertTransactionInFile.php",
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

