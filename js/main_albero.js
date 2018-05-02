/**
 * Albero genealogico demo js
 * 
 * @copyright e-zenit srl
 * @author Giuseppe Ripa <giuseppe.ripa@zenit.it> - Fabio Bellan  <fabio.bellan@zenit.it>
 */

$(document).ready(function(){
  $("#close_menu").hide();
  manage_menu();
  manage_notifiche();
  vscroll_menu();
  $('#contenuto').bind('pinchopen', function(){zoomin()});
  $('#contenuto').bind('pinchclose', function(){zoomout()});  
  $(".contenitor").scrollLeft(400);
});

$(window).resize(vscroll_menu);



//Scrivere che diamine fa
manage_notifiche = function(){
	$("#apri_notifiche").click(function(e){
		$("#notifiche").slideToggle('slow');
		e.stopPropagation();
  	});
	//Cliccando esternamente chiude la tendina #notifiche
    $(document).click(function() {
	  $("#notifiche").hide();
    });

	$("#apri_search").click(function(e){
		$("#search").slideToggle('slow');
  	});
	$(".search").click(function(){
	  $(this).toggleClass("on");
	});
	$(".search2").click(function(){
	  $(this).toggleClass("on");
	});
};

//Scrivere che diamine fa
manage_menu = function(){
  $("#apri_menu").on("click", function(){
	$(".cont_menu").animate({'left':'0'}, 'slow');
	$("#close_menu").show();
  });
  $("#close_menu").on("click", function(){
	  $("#close_menu").hide();
	  $(".cont_menu").animate({'left':'-400px'}, 'slow');
	});
}

//Scrivere che diamine fa
zoomin = function (){
	var mezzwind = $(window).width()/2;
	var position = $(".contenitor").scrollLeft() + mezzwind;
	if($("#table0").is(":visible")){
		$(".image0, #table0").animate({'width':'2900px'});
		$(".cont_img").animate({'width':'2900px'}, function(){    
			$(".contenitor").scrollLeft(position/2 - mezzwind);
			$("#table0").hide();
			$("#table1").show();
			$(".contenitor").scrollLeft(position*2 - mezzwind);
		});
		$(".contenitor").animate({scrollLeft:position*2 - mezzwind});
		}
}


zoomout = function (){
	var mezzwind = $(window).width()/2;
	var position = $(".contenitor").scrollLeft() + mezzwind;
	if($("#table2_3").is(":visible")){
		$(".image2_3, #table2_3").animate({'width':'4096px'});
		$(".cont_img").animate({'width':'4096px'}, function(){    
			$(".contenitor").scrollLeft(position/2 - mezzwind);
			$("#table2_3").hide();
			$("#table3").show();
			$(".contenitor").scrollLeft(position/2 - mezzwind);
		});
		$(".contenitor").animate({scrollLeft:position/2 - mezzwind});
	} else if($("#table3").is(":visible")){
		$(".image3, #table3").animate({'width':'1305px'});
		$(".cont_img").animate({'width':'1305px'}, function(){    
			$(".contenitor").scrollLeft(position/2 - mezzwind);
			$("#table3").hide();
			$("#table4").show();
			$(".contenitor").scrollLeft(position/2 - mezzwind);
		});
		$(".contenitor").animate({scrollLeft:position/2 - mezzwind});
	}
}

apri_ramo1 = function(){
	$("#table1").hide();
	$("#table2_1").show();
	$(".contenitor").scrollTop(0);
	$(".contenitor").scrollLeft(3100);
}

chiudi_ramo1 = function(){
	$("#table2_1").hide();
	$("#table1").show();
	$(".contenitor").scrollTop(330);
	$(".contenitor").scrollLeft(1000);
}

apri_ramo2 = function(){
	$("#table1").hide();
	$("#table2_2").show();
	$(".contenitor").scrollTop(100);
	$(".contenitor").scrollLeft(1400);
}

chiudi_ramo2 = function(){
	$("#table2_2").hide();
	$("#table1").show();
	$(".contenitor").scrollTop(330);
	$(".contenitor").scrollLeft(2400);
}

apri_tutto1 = function(){
	$("#table2_1").hide();
	$("#table2_3").show();
	$(".contenitor").scrollLeft(6500);
}

apri_tutto2 = function(){
	$("#table2_2").hide();
	$("#table2_3").show();
	$(".contenitor").scrollLeft(2900);
}

// menu con altezza %
 function vscroll_menu(){
	var altezza = $(window).height();
	var altezza_hd = $("#header").height();
	$("#cont_menu").height(altezza);
	$("#contenuto").height(altezza-altezza_hd);
	$("#contenuto_benvenuto").height(altezza);
	$("#close_menu").height(altezza);
}

mostrapopup1 = function(){
	$('.popup_albero1').show();
}
nascondipopup1 = function(){
	$('.popup_albero1').hide();
}

mostrapopup2 = function(){
	$('.popup_albero2').show();
}
nascondipopup2 = function(){
	$('.popup_albero2').hide();
}
	


