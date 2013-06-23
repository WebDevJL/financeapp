/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function setDDL(type){
    var cid=$.getUrlVar('cid');
    var ajaxUrl=ajaxUrl;
	if(cid == undefined){cid=1;}
    if(type === "xml"){
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
                cache : false,
                timeout : 360000});
        //if($(this).find("cid").text() == cid){
        // transactionTypes
        buildAutoCompleteFromXML(
            {
                url : "../Files/transactionTypes.xml",
                id :"#transactionTypeList",
                type : {val:"normal"},
                cache : false,
                timeout : 360000});
        // Categories with SubCategories
        buildAutoCompleteFromXML(
            {
                url : "../Files/categories.xml",
                id :"#catList",
                type : {val:"normal"},
                cache : false,
                timeout : 360000});
        // Categories Only
        buildAutoCompleteFromXML(
            {
                url : "../Files/categoriesOnly.xml",
                id :"#catListOnly",
                type : {val:"normal"},
                cache : false,
                timeout : 360000});
        // Payees
        buildAutoCompleteFromXML(
            {
                url : "../Files/payees.xml",
                id :"#payeeList",
                type : {val:"normal"},
                cache : false,
                timeout : 360000});
        // Intervals
        buildAutoCompleteFromXML(
            {
                url : "../Files/intervals.xml",
                id :"#intervalList",
                type : {val:"normal"},
                cache : true,
                timeout : 360000});
    }else{
        //Get an set all autocomplete lists
        ajaxR({
            type:"POST",url:ajaxUrl,dataType:"JSON",
            data:{type:1,filter:cid}
        });
    }
}

function configForm(obj){
    var config = {};
    switch(obj.type){
        case "transaction":
            
            break;
        case "schedules":
            config = {
                legend : "Insert a scheduler",
                tableId : $(".table").parent().attr("id"),
                inputsConfig : (Object.keys(obj.data).length === 0) ? {} : {
                    c1 : {
                        id : "datepicker",
                        name : ((obj.data.e3.name === undefined) ? "date" : obj.data.e3.name),
                        dV : ((obj.data.e3.val === undefined) ? "Select starting date" : obj.data.e3.val), 
                        type : "input"
                        },
                    c2 : {
                        id : "intervalList", 
                        name : ((obj.data.e4.name === undefined) ? "interval" : obj.data.e4.name),
                        dV : ((obj.data.e4.val === undefined) ? "Select repeat period" : obj.data.e4.val), 
                        type : "input"
                        },
                    c3 : {
                        id : "accountsList", 
                        name : ((obj.data.e5.name === undefined) ? "account" : obj.data.e5.name),
                        dV : ((obj.data.e5.val === undefined) ? "Select account" : obj.data.e5.val), 
                        type : "input"
                        },
                    c4 : {
                        id : "transactionTypeList", 
                        name : ((obj.data.e6.name === undefined) ? "transactionType" : obj.data.e6.name),
                        dV : ((obj.data.e6.val === undefined) ? "Select type" : obj.data.e6.val), 
                        type : "input"
                        },
                    c5 : {
                        id : "catList", 
                        name : ((obj.data.e7.name === undefined && obj.data.e8.name === undefined) ? "category" : obj.data.e7.name+'%'+obj.data.e8.name),
                        dV : ((obj.data.e7.val === undefined && obj.data.e8.val === undefined) ? "Select category": obj.data.e7.val+':'+obj.data.e8.val), 
                        type : "input"
                        },
                    c6 : {
                        id : "payeeList", 
                        name : ((obj.data.e9.name === undefined) ? "payee" : obj.data.e9.name),
                        dV : ((obj.data.e9.val === undefined) ? "Select payee" : obj.data.e9.val), 
                        type : "input"
                        },
                    c7 : {
                        id : "ammount", 
                        name : "amount",
                        dV : ((obj.data.e10.val === undefined) ? "Enter amount" : obj.data.e10.val), 
                        type : "input"
                        },
                    c8 : {
                        id : ((obj.data.e11.id === undefined) ? "insert_row" : obj.data.e11.id), 
                        name : "button",
                        dV : ((obj.data.e11.val === undefined) ? "Add" : obj.data.e11.val), 
                        type : "button"
                        }
                }
            };
            break;
        case "account":
            
            break;
        case "cateogory":
            
            break;
        case "subcategory":
            
            break;
        case "payee":
            
            break;
        case "transactionType":
            
            break;
        case "interval":
            
            break;
        default:
            break;
    }
    return config;
}
function configTable(type){
    var config = {};
    switch(type){
        case "transaction":
            
            break;
        case "schedules":
            config = {
                customHeaders : {
                    c2 : "Date",
                    c4 : "Repeating",
                    c5 : "Account", 
                    c6 : "Type",
                    c7 : "Category",
                    c8 : "SubCategory",
                    c9 : "Payee",
                    c10 : "Amount"},
                excludedHeaders : $.splitOnGivenDelimiter("id,currency",","),
                showPaging : true,
                emptyMsg : "<p>There is no items to display.<p>",
                rpp : 10
            };
            break;
        case "account":
            
            break;
        case "cateogory":
            
            break;
        case "subcategory":
            
            break;
        case "payee":
            
            break;
        case "transactionType":
            
            break;
        case "interval":
            
            break;
        default:
            break;
    }
    return config;
}
function configAjaxRequest(type){
    var config = {};
    switch(type){
        case "transaction":
            
            break;
        case "schedules":
            config = {
                customHeaders : {
                    c2 : "Date",
                    c4 : "Repeating",
                    c5 : "Account", 
                    c6 : "Type",
                    c7 : "Category",
                    c8 : "SubCategory",
                    c9 : "Payee",
                    c10 : "Amount"},
                excludedHeaders : $.splitOnGivenDelimiter("id,currency",","),
                showPaging : true,
                rpp : 10
            };
            break;
        case "account":
            
            break;
        case "cateogory":
            
            break;
        case "subcategory":
            
            break;
        case "payee":
            
            break;
        case "transactionType":
            
            break;
        case "interval":
            
            break;
        default:
            break;
    }
    return config;
}