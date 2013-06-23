/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 $(document).on("click",".edit_row",function(e){
 	var cid=$.getUrlVar('cid');
	if(cid == undefined){cid="1";}
 	//alert($(this).parent().find(".edit_acc td.col2").html()); 
//hide dialogs DIVs
  var node1_id = [], node2_id = [], node1_value = "", node2_value = "";
  if($(this)[0].firstChild.id !== undefined){
    node1_id = $(this)[0].firstChild.id;
  }
  if($(this)[0].lastChild.id !== undefined){
    node2_id = $(this)[0].lastChild.id;
    if(node2_id.length === 0){node2_id = node1_id;}
  }
  if($(this)[0].firstChild.innerText !== undefined){
    node1_value = $(this)[0].firstChild.innerText;
  }
  if($(this)[0].lastChild.innerText !== undefined){
    node2_value = $(this)[0].lastChild.innerText;
  }
  var html_out = '<form method="post"><fieldset><legend class="ui-header">Edit your DATA</legend>';
  html_out += '<INPUT class="button" id="'+node1_id+'" type="text" name="'+node1_id+'" value="'+node1_value+'" />'
  if (node1_id !== node2_id){
    html_out += '<INPUT class="button" id="'+node2_id+'" type="text" name="'+node2_id+'" value="'+node2_value+'" />'
  }
  html_out += '<INPUT id="update_row" type="button" name="update_row" value="Save" />'
  html_out += '</fieldset></form><div class="delete_row" id="'+node1_id+'%'+node2_id+'">Delete selected row</div>'
  html_out += '<div class="close_overlay">Close</div>'
	$('#edit_overlay').css("visibility", "visible").css("position","absolute").css("top","100px").css("left","250px");;
	$('#edit_overlay').html(html_out);
});
$(document).on("click",".close_overlay",function(e){
  $("#"+$(this).parent().attr("id")).css("visibility", "hidden").css("position","absolute").css("top","-9999px").css("left","-9999px");
  $("#"+$(this).parent().attr("id")).html('');
});
//Process update row data POST
$(document).on("click","tr#update_row",function(e){
  var cid=$.getUrlVar('cid');
  if(cid == undefined){cid="1";}
  //$('#edit_overlay').css("visibility", "visible").css("position","absolute").css("top","100px").css("left","250px");;
  //$("#edit_overlay").html('<p>AJAX CALL Done!</p><span class="close_overlay">Cancel</span>');
  var node1_id = "", node2_id = "", node1_value = "", node2_value = "", sql="";
  var update_type="", fieldID="", fieldValue="", fieldID2="", fieldValue2="";
  if($(this).context.form[1].id !== undefined){
    node1_id = $.splitOnGivenDelimiter($(this).context.form[1].id,"_");
  }
  if($(this).context.form[2].id !== undefined){
    node2_id = $.splitOnGivenDelimiter($(this).context.form[2].id,"_");
  }
  if($(this).context.form[1].value !== undefined){
    node1_value = $(this).context.form[1].value;
  }
  if($(this).context.form[2].value !== undefined){
    node2_value = $(this).context.form[2].value;
  }
  switch(node1_id[0])
  {
    case "acc":
      update_type="acc";
      break;
    case "cat":
      if(node2_id[0] == 'update'){
        update_type="cat";
      }else{
        update_type="scat";
      }
      break;
    case "payee":
      update_type="payee";
      break;
    case "curr":
      update_type="curr";
      break;
    default:
  }
  $.ajax({
    type : 'POST',
    url : location.protocol + "//" + location.host + "/FinanceApp/php/updateRow.php",
    dataType : 'json',
    data: {
        currency : cid,
        type : update_type,
        fieldID : node1_id[1],
        fieldID2 : node2_id[1],
        fieldValue : node1_value,
        fieldValue2 : node2_value
      },
			success : function(data){
				/*$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
				setTimeout(function() {$("#settings_dialogBox").hide('blind', {}, 500)}, 5000);
				*/
       switch(data.update_type)
        {
          case "acc":
            $("#acc_dataset").html(data.dataset);
            break;
          case "cat":
            $("#cat_dataset").html(data.dataset);
            break;
          case "scat":
            $("#scat_dataset").html(data.dataset);
            break;
          case "payee":
            $("#payee_dataset").html(data.dataset);
            break;
          case "curr":
            $("#curr_dataset").html(data.dataset);
            break;
          default:
        }
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
        $('#edit_overlay').css("visibility", "visible").css("position","absolute").css("top","100px").css("left","250px");;
        $("#edit_overlay").html('<p>'+data.msg+'</p><p>Click "close" to continue.</p><span class="close_overlay">Close</span>');
			},
			error: function(data) {
            	$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
                      $('#edit_overlay').css("visibility", "visible").css("position","absolute").css("top","100px").css("left","250px");;
        $("#edit_overlay").html('<p>'+data.msg+'</p><p>Your DATA has been edited! Click "close" to continue.</p>');
        $("#edit_overlay").html('<div class="close_overlay">Close</div>');

        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
//Process update row data POST
$(document).on("click",".delete_row",function(e){
  var cid=$.getUrlVar('cid');
  if(cid == undefined){cid="1";}
  //$('#edit_overlay').css("visibility", "visible").css("position","absolute").css("top","100px").css("left","250px");;
  //$("#edit_overlay").html('<p>AJAX CALL Done!</p><span class="close_overlay">Cancel</span>');
  var node = [];
  var update_type="", fieldID="", fieldID2="";
  if($(this).context.id !== undefined){
    var tmp = $.splitOnGivenDelimiter($(this).context.id,"%");
    for (var i = 0; i < tmp.length; i++){
      var tmp2 = $.splitOnGivenDelimiter(tmp[i],"_");
      node.push(tmp2);
    } 
  }
  $.ajax({
    type : 'POST',
    url : location.protocol + "//" + location.host + "/FinanceApp/php/deleteRow.php",
    dataType : 'json',
    data: {
        currency : cid,
        arrayObj : node
      },
			success : function(data){
				/*$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
				setTimeout(function() {$("#settings_dialogBox").hide('blind', {}, 500)}, 5000);
				*/
       switch(data.update_type)
        {
          case "acc":
            $("#acc_dataset").html(data.dataset);
            break;
          case "cat":
            $("#cat_dataset").html(data.dataset);
            break;
          case "scat":
            $("#scat_dataset").html(data.dataset);
            break;
          case "payee":
            $("#payee_dataset").html(data.dataset);
            break;
          case "curr":
            $("#curr_dataset").html(data.dataset);
            break;
          default:
        }
				//console.log('Can\'t see me in Chrome, but ok in firefox !')
        $('#edit_overlay').css("visibility", "visible").css("position","absolute").css("top","100px").css("left","250px");
        $("#edit_overlay").html('<p>'+data.msg+'</p><span class="close_overlay">Close</span>');
			},
			error: function(data) {
            	$('#settings_dialogBox').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
				if (data.error === true)
					$('#settings_dialogBox').html(data.msg);
            	//console.log($.makeArray(arguments));
                      $('#edit_overlay').css("visibility", "visible").css("position","absolute").css("top","100px").css("left","250px");
        $("#edit_overlay").html('<p>'+data.msg+'</p><p>Click "close" to continue.</p>');
        $("#edit_overlay").html('<div class="close_overlay">Close</div>');

        	},
        	complete: function() {
            	console.log($.makeArray(arguments));
        	}
		});
		return false;
	});
