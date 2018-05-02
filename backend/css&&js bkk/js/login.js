(function($) {
	$(document).ready(function(){
		vscroll_contenuto();
		centerBox();
		$("#message").on("click", function(){
			$("#message").hide();
		});
	});
	$(window).resize(function(){
		vscroll_contenuto();
		centerBox();
	});
	
	//div and table size management
	vscroll_contenuto = function () {
		var altezza = $(window).height()-$("#header").height(); 
		$("#container").height(altezza);
	}
	
	//Center the Box function
	centerPopup = function (element){
		var winw = $(window).width();  
		var winh = $(window).height();  
		var popw = $(element).width();  
		var poph = $(element).height(); 
		$(element).css({  
			"position" : "absolute",  
			"top" : winh/2-poph/2 - 40,  
			"left" : winw/2-popw/2  
		});  
		$(element).css({ "z-index" : "10"});
		//IE6  
	};
	
	centerBox = function () {  
		centerPopup("#box");  
	};  
	
	//Input onFocus
	onfocus_input = function(element,default_value){
		if (element.value==default_value) {
			element.value=''; 
			element.style.color='#000';
		}
	}
	onblur_input = function (element,default_value)
	{
		if (element.value=='') 
		{ 
			element.style.color='#999';
			if (element.value=='') 
			{
				element.value=default_value;
			}
		}
	}
})(jQuery);