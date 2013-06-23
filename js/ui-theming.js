$(document).ready(function() {
// Get DATA from xml and store in object
	var themeID = 1;
	var i = 0, j = 0; 
	var listOfCssClass = [];
	$.ajax({
        type: "GET",
		url: location.protocol + "//" + location.host + "/FinanceApp/Files/theming.xml",
		dataType: "xml",
		success: function(xml) {
 			$(xml).find('theme').each(function(){
 				if($(this).attr('id') == themeID){
	 				$(this).find('class').each(function(){
	 					classObj = new cssClass();
	 					classObj.cssClassName = $(this).attr('name');
						$(this).find('property').each(function(){
							propName = $(this).find('name').text();
							propVal = $(this).find('value').text();
							propObj = addCssProperty(propName,propVal);
							classObj.cssProperties.push(propObj);
						});
						listOfCssClass.push(classObj);
					});
				}
			});
			//alert(listOfCssClass);
			// Build dynamic theming CSS
    		while (i < listOfCssClass.length){
    			while(j < listOfCssClass[i].cssProperties.length){
    				$(listOfCssClass[i].cssClassName).css(listOfCssClass[i].cssProperties[j].propName, listOfCssClass[i].cssProperties[j].propValue);
	    			j++;
    			}
    			j = 0;
    			i++;
    		}//end ajax function
		},error: function(jqXHR, textStatus, errorThrown) {
			// URL is bad
			alert(jqXHR + ',' + textStatus + ',' + errorThrown);
        }
    }); 
	//});
    
    // Error handling
    /*$.ajaxSetup({
	        error: function(jqXHR, exception) {
	            if (jqXHR.status === 0) {
	                alert('Not connect.\n Verify Network.');
	            } else if (jqXHR.status == 404) {
	                alert('Requested page not found. [404]');
	            } else if (jqXHR.status == 500) {
	                alert('Internal Server Error [500].');
	            } else if (exception === 'parsererror') {
	                alert('Requested JSON parse failed.');
	            } else if (exception === 'timeout') {
	                alert('Time out error.');
	            } else if (exception === 'abort') {
	                alert('Ajax request aborted.');
	            } else {
	                alert('Uncaught Error.\n' + jqXHR.responseText);
	            }
	        }
    });*/
});