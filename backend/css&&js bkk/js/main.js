/**
 * Assolatte backend js
 * 
 * @copyright e-zenit srl
 * @author Giuseppe Ripa  <giuseppe.ripa@zenit.it>
 */
(function($) {
	$(function() {	
		vscroll_contenuto();
		check_management();
		messages();			
		search_check();
		extend_link();
		
	});
	$(window).resize(function() {
		vscroll_contenuto();
	});
	
	
	search_check = function(){		
		if($("#search").val() !=''){
			$("#lens").hide();
			$("#cancel").show();
		}else {			
			$("#lens").show();
			$("#cancel").hide();
		}
	}
	search_reset = function(){		
			$('#search').removeAttr('value');
			$("#lens").show();
			$("#cancel").hide();
	}
	//manage checkbox and function
	check_management = function(){
		$("#btn_select").hide();		
		$("input[type=checkbox]").on("click", function(){
			setTimeout(function(){
				if ($(".checkbox").is(":checked")){
				$("#btn_notselect").hide();
				$("#btn_select").show();	
			}else{
				$("#btn_notselect").show();
				$("#btn_select").hide();  
			}
				
				}, 80);
			
		});
	};
	//manage Message
	messages = function(){
		$("#msg").on("click", function(){
			$(this).fadeOut("slow");
		});
		$("#error").on("click", function(){
			$(this).fadeOut("slow");
		});
	}
	//div and table size management
	vscroll_contenuto = function() {
		var altezza = $(window).height()-$("#header").height();
		$("#container").height(altezza);
		$("#left_column").height(altezza);
		$("#tabella").height(altezza-$("#tabella_head").height());
		$("#tabella_head").css("top", $("#header").height());
		$("#tabella_head").css("left", $("#left_column").width());
		$("#tabella").css("padding-top", $("#tabella_head").height());
		$("#table_body").css("width", $("#tabella_head").width());
		if($("#tabella").hasClass("table_list_view")){
			$(".preview").css("width", $("#tabella_head").width());
		}
	};
	
	//Check All
	toggleChecked = function(status) {
		$(".checkbox").each(function() {
			$(this).prop("checked", status);			
			selection_color(this);
		});
	};
	//color of checked row
	selection_color = function(element){
		var row = $(element.parentNode.parentNode.parentNode);	
		if ($(element).is(":checked")){
			row.addClass("selected");
		}else{
			row.removeClass("selected");
			$("#checkAll").prop("checked",false);//remove the check status from the checkbox in the header of the table
		}
	};
	
	//Extend the href to the table row
	extend_link = function(){ 
		$(".preview").bind("click", function(e){
			if (e.target.type != "checkbox") {
				var url = $(this).find("a").attr("href");
				if(url){
					window.location.href = url;
				}
		 	}
		});
	}
	//open the popup from tr
	fromTablePopup = function(element){
		if (event.target.type != "checkbox") {
			dimPopup(element);
		 }
	}
})(jQuery);

/*Get Query string value by key*/ 
	function getQueryString(key) {
		//Holds key:value pairs 
		var queryStrings = null;
		//Get querystring from url 
		//window.location.search returns the part of the URL that follows the ? symbol, including the ? symbol 
		var requestUrl = window.location.search; 

		if (requestUrl !== '') { 
			requestUrl = requestUrl.substring(1); 
			queryStrings = []; 

			//Get key:value pairs from querystring 
			var kvPairs = requestUrl.split('&'); 

			for (var i = 0; i < kvPairs.length; i++) { 
				var kvPair = kvPairs[i].split('='); 
				queryStrings[kvPair[0]] = kvPair[1]; 
			} 
		} 
		return queryStrings[key] || ''; 
	}