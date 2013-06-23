 $(document).on("click",".disableRow",function(e){
 	var cid=$.getUrlVar('cid');
	if(cid == undefined){cid="1";}
/* 	alert($(this).parent().find(".disableRow").html()); */
//hide dialogs DIVs
	$('#dialogBox').hide();
	$.ajax({
		type : 'POST',
		url : location.protocol + "//" + location.host + "/FinanceApp/php/disableRowInXML.php",
		dataType : 'json',
		data: {
			currency : cid,
			transactionID : $(this).parent().find(".disableRow").html()
		},
		success : function(data){
			$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
			if (data.error === true)
				$('#settings_dialogBox').html(data.msg);
			setTimeout(function() {
    			$("#settings_dialogBox").hide('blind', {}, 500)
			}, 5000);
			//alert("before hide");
			//$(this).hide('blind', {}, 500);
			//alert("hide");
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