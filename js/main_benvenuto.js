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
  $('.image').bind('pinchopen', function(){zoomin()});
  $('.image').bind('pinchclose', function(){zoomout()});
  $('#contenuto').bind('pinchopen', function(){zoomin()});
  $('#contenuto').bind('pinchclose', function(){zoomout()});  
});

$(window).resize(vscroll_menu);

//Zoom immagine pagina benvenuto
zoomin = function (){
	if($("#img1").is(":visible")){
		$("#img2").click({'display':'block'});
	}
}

//Apre e chiudere elementi, aggiunge classi
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
	    e.stopPropagation();
    });
	//Cliccando esternamente chiude la tendina #search
    $(document).click(function() {
	  $("#search").hide();
    });
	$(".search").click(function(){
	  $(this).toggleClass("on");
	});
	$(".search2").click(function(){
	  $(this).toggleClass("on");
	});
	
	$(".contenitor_libro").click(function(e){
		if($(".libro_footer").is(":hidden")){
			$(".libro_testata").show('slow');
			$(".libro_footer").show('slow');
		}else{
			$(".libro_footer").hide();
			$(".libro_testata").slideUp('slow');
	}
  	});
};

//Apre e chiude il menu sulla sinistra
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

//Con ipad, gestisce la dimensione delle immagini 
zoomout = function (){
	var mezzwind = $(window).width()/2;
	var position = $(".contenitor").scrollLeft() + mezzwind;
	$(".image").animate({'width':'2000px'});
	$("#table").animate({'width':'4000px'});
	$(".cont_img").animate({'width':'4000px'});
	$(".contenitor").scrollLeft(position/2 - mezzwind);
}

zoomin = function (){
	var mezzwind = $(window).width()/2;
	var position = $(".contenitor").scrollLeft() + mezzwind;
	$(".image").animate({'width':'4000px'});
	$("#table").animate({'width':'8000px'});
	$(".cont_img").css('width','8000px');
	$(".contenitor").scrollLeft(position * 2 - mezzwind);
}

// Settare altezza elementi %
 function vscroll_menu(){
	var altezza = $(window).height();
	var altezza_hd = $("#header").height();
	$("#cont_menu").height(altezza);
	$("#contenuto").height(altezza-altezza_hd);
	$("#contenuto_benvenuto").height(altezza);
	$("#immagine_libro").height(altezza);
	$("#close_menu").height(altezza);
}