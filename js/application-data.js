/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
	var cid=$.getUrlVar('cid');
	if(cid == undefined){cid=1;}

/* Build a HTML table
 * 
 * Requirements to use the below ready function:
 *      - current page must have one div element with 
 *          * id="table" 
 *          * class being the type of DATA to display
 *              ex: "schedules","accounts", etc...
 * 
 */

	$('#table').ready(function() {
        var s = {};
        if($('#table').attr('class') !== undefined){
            s = xmlToObj("../Files/"+$('#table').attr('class')+"_"+cid+".xml");
            //if(s.items.item !== undefined){
                var tableObj = new TableHTML(s.items.item,"table","table");
                tableObj.initConfig(configTable($('#table').attr('class')));
                tableObj.buildTable();
            //}
        }
	});
});

//Paging
$(document).on("click","ul.paging li",function(e){
    var cid=$.getUrlVar('cid');if(cid == undefined){cid=1;}
    var s = {};
    //if($('#table').attr('class') !== undefined){
        s = xmlToObj("../Files/"+$('#table').attr('class')+"_"+cid+".xml");
        var tableObj = new TableHTML(s.items.item,"table","table");
        tableObj.pageNum = $.splitOnGivenDelimiter($(this).attr("id"),'_')[1]*1;
        tableObj.initConfig(configTable($('#table').attr('class')));
        tableObj.buildTable();
    //}
});
//Process delete row data
$(document).on("click","ul.delete_item li",function(e){
    $(this).attr("id");
    ajax(configForm($('#table').attr('class')));
    //var form = new FormHTML({},"#update_row");
    //form.build();
});
//Built insert form
$(document).on("click","#show_insert_form",function(e){
    var form = new FormHTML({},"#insert_form");
    form.initConfig(configForm({type:$('#table').attr('class'),data:{}}));
    form.build();
});
//Built update form
$(document).on("click","li.update",function(e){
    var data = {}, i=0, row= e.currentTarget.classList[0]; 
    $("li."+row).each(function(){
        var current = $(this);
        //if(current.text() !== "U" || current.text() !=="D"){
            i+=1;
            data["e"+i] = {
                id : current.attr("id"),
                name : current.attr('class').split(/\s+/)[1],
                val : current.text()
            }
        //}
    });
    i+=1;
    data["e"+i] = {id:"update_row",val:"Update"}
    var form = new FormHTML({},"#update_form");
    form.initConfig(configForm({type:$('#table').attr('class'),data:data}));
    form.build();
});

//Process insert row data
$(document).on("click","#insert_row",function(e){
    var i = 0;
    ajax(configForm($('#table').attr('class')));
});
//Process update row data
$(document).on("click","#update_row",function(e){
    var data = {}, i = 0;
    $(this).parent().find('input').each(function(){
        //if($(this).context.type() !== "button"){
            i+=1;
            data["e"+i] = {
                id : (($(this).attr("id") === undefined) ? "" : $(this).attr("id")),
                name : (($(this).attr("name") === undefined) ? "" : $(this).attr("name")),
                val : $(this).val()
            }
        //  }
    });
    console.log(data);
});
