$(document).ready(function(){
 var timeout = 2000;
	$('#setting_dialogRefresh').hide();
	$('#getCurrencies').click(function() {
		$.ajax({
			type : 'POST',
			url : '../php/getCurrencies.php',
			dataType : 'json',
			success : function(data){
				$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
				setTimeout(function() {
        			$("#setting_dialogRefresh").hide('blind', {}, 500)
    			}, timeout);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
	$('#getAccounts').click(function() {
		$.ajax({
			type : 'POST',
			url : '../php/getAccounts.php',
			dataType : 'json',
			success : function(data){
				$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
				setTimeout(function() {
        			$("#setting_dialogRefresh").hide('blind', {}, 500)
    			}, timeout);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
   		});
		return false;
	});
	$('#getCatsLong').click(function() {
		$.ajax({
			type : 'POST',
			url : '../php/getCategoriesLong.php',
			dataType : 'json',
			success : function(data){
				$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
				setTimeout(function() {
        			$("#setting_dialogRefresh").hide('blind', {}, 500)
    			}, timeout);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
	$('#getCatsOnly').click(function() {
		$.ajax({
			type : 'POST',
			url : '../php/getCategoriesOnly.php',
			dataType : 'json',
			success : function(data){
				$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
				setTimeout(function() {
        			$("#setting_dialogRefresh").hide('blind', {}, 500)
    			}, timeout);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
	$('#getPayees').click(function() {
		$.ajax({
			type : 'POST',
			url : '../php/getPayees.php',
			dataType : 'json',
			success : function(data){
				$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
				setTimeout(function() {
        			$("#setting_dialogRefresh").hide('blind', {}, 500)
    			}, timeout);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
	$('#getTypes').click(function() {
		$.ajax({
			type : 'POST',
			url : '../php/getTransactionTypes.php',
			dataType : 'json',
			success : function(data){
				$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
				setTimeout(function() {
        			$("#setting_dialogRefresh").hide('blind', {}, 500)
    			}, timeout);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
	$('#getTransactions').click(function() {
		$.ajax({
			type : 'POST',
			url : '../php/storeTransactions.php'/*,
			success : alert("Refreshed")//,error : alert("Error")*/
		});
		return false;
	});
	$('#getBudgets').click(function() {
		$.ajax({
			type : 'POST',
			url : '../php/getBudgetSettings.php',
			dataType : 'json',
			success : function(data){
				$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
				setTimeout(function() {
        			$("#setting_dialogRefresh").hide('blind', {}, 500)
    			}, timeout);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
	$('#getSchedules').click(function() {
		$.ajax({
			type : 'POST',
			url : '../php/getSchedules.php',
			dataType : 'json',
			success : function(data){
				$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
				setTimeout(function() {
        			$("#setting_dialogRefresh").hide('blind', {}, 500)
    			}, timeout);
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
			},
			error: function(data) {
            	$('#setting_dialogRefresh').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#setting_dialogRefresh').html(data.msg);
            	//console.log($.makeArray(arguments));
        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
});