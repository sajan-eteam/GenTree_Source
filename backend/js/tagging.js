/**
 * Albero genealogico backend js
 * 
 * @copyright e-zenit srl
 * @author Giuseppe Ripa  <giuseppe.ripa@zenit.it>
 * verision 1.0
 *
 * Library for tagging management
 * The image to tag has to be insered in a div with id="taggable"
 * The dropdown will be inserted in a div with id="tags"
 */
var i = 0; //Counter for tagging boxes
//var option; //options for the family dropdown
//var dropdown; //dropdown with the full list of the family member
var image_width;
var image_height;
var requestRunning = false;
var myArray = [];
//option = '<li>Seleziona familiare</li><li>Seleziona familiare2</li><li>Marco Boroli</li><li>Marco Drago</li><li>Seleziona familiare</li><li>Seleziona familiare2</li><li>Marco Boroli</li><li>Marco Drago</li><li>Seleziona familiare con nome molto molto lungo</li><li>Seleziona familiare2</li><li>Marco Boroli</li><li>Marco Drago</li>';
//dropdown = '<div class="dropdown"><input type="text"/><ul>'+option+'</ul></div>';

$(document).bind("dragstart", function(e) {
	if (e.target.nodeName.toUpperCase() == "IMG") {
         return false;
     }
});


$(document).ready(function() {
	
	image_width = $("#taggable").width();
	image_height = $("#taggable").height();
	var x1,y1;
	var boxcount = $("#boxids").val();
	if(boxcount>0)
	{
		i = boxcount;
		myArray.push(boxcount);			
	}
	
	$("#taggable").mousedown(function (e){
		if (requestRunning) { // don't do anything if an AJAX request is pending
        return;
       }else{

		
	    var parentOffset = $(this).parent().offset();
		x1 = e.pageX - parentOffset.left;
		y1 = e.pageY - parentOffset.top;

		if(myArray.length == 0){
			i = 0;
		}
	  
		$("#current").attr({ id: 'box'+ i +'' })
		var boxw=$("#box"+i).width();
		var boxh=$("#box"+i).height();
		
	   	myArray.push("#box"+i);
		
		
         var ajaxOpts = {  
         	type: 'POST',
           url: 'photo_detail.php',
		   data: 'tag=1'+'&x_cord='+x1+'&y_cord='+y1,
           success: function(data)
           {
           		
			    var box   = $('<div id="box'+ i +'"class="tagbox">' + i +'</div>').hide();
				var input = $('<div id="input'+ i +'"class="tag_list"><p class="number" id="num'+ i +'">' + i + '</p><div class="input"><p class="id_val" id="user_id_selected" style="display:none;"></p><p id="username">Seleziona familiare</p><span></span></div><div class="remove" onclick="removebox('+i+')">x</div>' + data +'</div>');
               
				$("#current").attr({ id: ''})
				$("#img_cont").append(box);
				$("#tags").prepend(input);  
					
				box.attr({id: 'current'}).css({
					top: y1 , //offsets
					left: x1 //offsets
				}).fadeIn();
				
				$(".tagbox").draggable({containment: $("#taggable")});//this is to do draggable the boxes
				$(".tagbox").resizable({containment: $("#taggable")});//this is to do resizable the boxes

				$('p[id^="num"]').removeClass('tagcolor');
				$("#num"+ i).addClass('tagcolor');
				
			},
        	complete: function() {
            	requestRunning = false;
        	}
        };
		
    	$.ajax(ajaxOpts);
    	requestRunning = true;
    	i++;
    	return false; 
    	}	
	});
	
	$("#taggable").mousemove(function(e) {
		parentOffset = $(this).parent().offset(); 
		$("#current").css({
			width:((e.pageX - parentOffset.left) - x1), //offsets
			height:((e.pageY - parentOffset.top) - y1) //offsets
		}).fadeIn();
     
	});
	
	$(document).mouseup(function(event) {

		
		$("#current").attr({ id: 'box'+ i +'' })
		var boxw=$("#box"+i).width();
		var boxh=$("#box"+i).height();
		$("#box").val(i);

			     
	});	

	$(document).click(function() {
		
		$(".tagbox").draggable({containment: $("#taggable")});//this is to do draggable the boxes
		$(".tagbox").resizable({containment: $("#taggable")});//this is to do resizable the boxes		     
	});	

	
});


//Manage the boxes delating
removebox = function(element){	
	
	var box    = '#box' + element;
	var input  = '#input' + element;
	$(box).remove();
	$(input).remove();
	myArray.splice(myArray, 1);
}

$(window).resize(function(){
	//scalebox();
});

jQuery.fn.exists = function(){return this.length>0;}

//Manage the resize of the boxes at the window resize
scalebox = function(){
	var image_width_fin 		= $("#taggable").width();
	var image_height_fin		= $("#taggable").height();
    var actual_image_width    	= $("#actualwidth").val();
	var actual_image_height	  	=  $("#actualheight").val();
	 
	
	var propX = image_width_fin/image_width;
	var propY = image_height_fin/image_height;

	image_width				= $("#taggable").width();
    image_height			= $("#taggable").height();
  
	
	for(var n=1;n<=i;n++){
		var boxino = '#box'+ n;
		if ($(boxino).exists()) {
			var parentOffset2 = $(boxino).position();
			if ($(parentOffset2).exists()){
				var x1 = parentOffset2.left;
				var y1 = parentOffset2.top;				
				$(boxino).width($(boxino).width()*propX);
				$(boxino).height($(boxino).height()*propY);
				$(boxino).css({
					left:(x1*propX), //offsets
					top:(y1*propY) //offsets
				}).fadeIn();
			}
		}	
	}
  }
$(window).load(function () {
	var centerWidth = $('#tabella #img_cont').width();
	$('#img_cont').css('width', centerWidth);
	var tabellaWidth = $('#tabella').width();
	$('#tabella').css('width', tabellaWidth);
})