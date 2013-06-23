$(document).ready(function(){
	//Home - tabs logic
	$('#cpd div.current').fadeIn('slow', function(){
		$('#cpd div').css("visibility", "hidden").css("position","absolute").css("top","-9999px").css("left","-9999px");
		$('#cpd div.current').css("visibility", "visible").css("position","relative").css("top","0").css("left","0");
		$('#cpd #cpm').css("visibility", "visible").css("position","relative").css("top","0").css("left","-1px");
	});
	
	$('#sub_menu li').click(function(event) {
		$("#cpm li.current").removeClass("current");
		$("#cpd div.current").removeClass("current");
		$(this).addClass("current");
		$('#cpd div').css("visibility", "hidden").css("position","absolute").css("top","-9999px").css("left","-9999px");
		$('#cpd #cpm').css("visibility", "visible").css("position","relative").css("top","0").css("left","-1px");
		var idToShow = $(this).find("a").attr("href");
		$("#cpd div"+idToShow).show('5000', function(){
			$(this).addClass("current");
			$('#cpd div.current').css("visibility", "visible").css("position","relative").css("top","0").css("left","0");
		});
  		return false;        
 	});
 	//Settings - tabs logic
	$('div#main_wrap_settings div.current').fadeIn('slow', function(){
		$('div#main_wrap_settings div').css("visibility", "hidden").css("position","absolute").css("top","-9999px").css("left","-9999px");
		$('div#main_wrap_settings div.current').css("visibility", "visible").css("position","relative").css("top","0").css("left","0");
		$('div#main_wrap_settings div.current div').css("visibility", "visible").css("position","relative").css("top","0").css("left","0");
		$('div#main_wrap_settings div#settings_dialogBox').css("visibility", "visible").css("position","relative").css("top","0").css("left","0");
		$('div#main_wrap_settings div.clear').css("visibility", "hidden");
	});
	//
	$('div#slider_settings li').click(function(event) {
		$(".current").removeClass("current");
		$(this).addClass("current");
		$('div#main_wrap_settings div').css("visibility", "hidden").css("position","absolute").css("top","-9999px").css("left","-9999px");
		var idToShow = $(this).find("a").attr("href");
		$("div#main_wrap_settings div"+idToShow).show('5000', function(){
			$(this).addClass("current");
   		$('div#main_wrap_settings div').css("visibility", "hidden").css("position","absolute").css("top","-9999px").css("left","-9999px");
			$('div#main_wrap_settings div.current').css("visibility", "visible").css("position","relative").css("top","0").css("left","0");
			$('div#main_wrap_settings div.current div').css("visibility", "visible").css("position","relative").css("top","0").css("left","0");
			$('div#main_wrap_settings div#settings_dialogBox').css("visibility", "visible").css("position","relative").css("top","0").css("left","0");
			$('div#main_wrap_settings div.clear').css("visibility", "hidden");
		});
  		return false;        
 	});

}); 