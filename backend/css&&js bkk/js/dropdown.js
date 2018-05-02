// JavaScript Document
$(document).ready(function () {

  jQuery.expr[':'].Contains = function(a,i,m){
      return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
  };
  var boxOpened
  listFilter = function (mySelect) {
    var mySearch = $(mySelect).find("input")
	var myList = $(mySelect).find("ul")
    $(mySearch).change( function () {
        var filter = $(this).val();
        if(filter) {
          $(myList).find("li:not(:Contains(" + filter + "))").hide();
          $(myList).find("li:Contains(" + filter + ")").show();
        } else {
          $(myList).find("li").show();
        }
        return false;
      })
    .keyup( function () {
        $(this).change();
    });
		
  }

  	apri = function (mySelect){
		var myList = $(mySelect).find(".dropdown");
		var input = $(myList).find("input");
		$(myList).show(); 
		$(myList).find("li").show();
		$(myList).find("li").removeClass("selected");
		$(myList).find("li").first().addClass("selected");
		$(myList).find("ul").scrollTop(0);
		$(input).val("");
		listFilter(mySelect);
		setTimeout(function(){
        	$(input).focus();
        },100);

	}
var boxdetail = [];
	select_item = function(myChoice){
	
		i++;
		var keys = [];
		var values = [];
		var person = $(myChoice).text();
		var personv = $(myChoice).val();
		var input = boxOpened + " .input p"
		$(input).empty();
		$(input).append(person);
		
		//alert(person);
		var input2 = boxOpened + " .input p.id_val"
		//alert(input2);
		$(input2).text(personv);
		
		//$('#user_id_selected').text(personv);
		
		$(boxOpened).find("input").val("");
		$(boxOpened + " .dropdown").hide();
		var numFiled = boxOpened + " p.number"; //added for coloring the selected combo box
		$(numFiled).removeClass('tagcolor'); //added for coloring the selected combo box
        var i= $("#box").val();
		var parentOffset2 = $("#box"+i).position();
		
			if ($(parentOffset2).exists())
			{
				var x1 = parentOffset2.left;
				var y1 = parentOffset2.top;	
				var boxw=$("#box"+i).width();
				var boxh=$("#box"+i).height();  
			}
		
    // The following statement will only be executed
    // if the conditional "something" has not been met
	}
	$(document).click(function (e){
		if($(e.target).is(".input")){
			var id = "#" + $(e.target.parentNode).attr("id");
			if(boxOpened != undefined){
				$(".dropdown").hide();
			}
			boxOpened = id;
			apri(id);
		} else if($(e.target).is(".input p") || $(e.target).is(".input span")){
			var id = "#" + $(e.target.parentNode.parentNode).attr("id");
			if(boxOpened != undefined){
				$(".dropdown").hide();
			}
			boxOpened = id;
			apri(id);
		}else if($(e.target).is(boxOpened + " .dropdown li")){
			select_item(e.target);
		} else if(boxOpened!= undefined){
			var container = $(".dropdown");
			if (!container.is(e.target) && container.has(e.target).length === 0){
				container.hide();
				boxOpened = undefined;
			}
		} 

	});
	$(document).keydown(function(e){
		if(boxOpened!= undefined){
			var selected = $(boxOpened).find($(".selected"));
			if (e.keyCode == 40) {				
				$("li").removeClass("selected");
				// if there is no element before the selected one, we select the last one
				if (selected.nextAll(":visible:first").length == 0 ) {
				  var li = selected.prevAll(":visible:last");
				  li.addClass("selected");
				  isScrolledIntoView(li);
				} else { // otherwise we just select the next one
					var li = selected.nextAll(":visible:first")
					li.addClass("selected");
					isScrolledIntoView(li)
				}
			} else if (e.keyCode == 38) {
				$("li").removeClass("selected");
				// if there is no element before the selected one, we select the last one
				if (selected.prevAll(":visible:first").length == 0) {
					var li = selected.nextAll(":visible:last")
				  	li.addClass("selected");
				  	isScrolledIntoView(li)
				} else { // otherwise we just select the next one
					var li = selected.prevAll(":visible:first");
					li.addClass("selected");
					isScrolledIntoView(li)
				}
			}else if (e.keyCode == 13) {
				var person = boxOpened + " li.selected";
				select_item(person);
			}
		}
	});
	isScrolledIntoView = function (elem){
		var docViewTop = $(boxOpened + " ul").scrollTop();
		var docViewBottom = docViewTop + $(boxOpened + " ul").height();
		var elemTop = $(elem).position().top;
		var elemBottom = elemTop + $(elem).height();
	
		if ((elemBottom >= docViewBottom) || (elemTop <= docViewTop)){
			$(boxOpened + " ul").scrollTop(elemTop);
		}
	}
}(jQuery));