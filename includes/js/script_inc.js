
function showDiv(type) {
		if(type == 'computer') {
			document.getElementById('browse_continer_popup1').style.display = "";
			document.getElementById('browse_continer_popup2').style.display = "none"
			document.getElementById('divtab1').className = 'tabs_hover'; 
			document.getElementById('divtab2').className = 'tabs'; 
		}
		if(type == 'library') {
			document.getElementById('browse_continer_popup1').style.display = "none";
			document.getElementById('browse_continer_popup2').style.display = "";		
			document.getElementById('divtab1').className = 'tabs'; 
			document.getElementById('divtab2').className = 'tabs_hover'; 
		}
		return false;
	}

function orderBy(orderby) { 
	document.frm_addgallery.mode.value = "filter";
	document.frm_addgallery.orderby.value = orderby;
	$('#frm_addgallery').submit();
}
function doSearch() {
	document.frm_addgallery.mode.value = "filter";	
	$('#frm_addgallery').submit();
}
function linkMedia(id,type) {
	if(type == 1) {            //REMOVE
		document.getElementById('reletediv_'+id).style.display = "";
		document.getElementById('unlinkdiv_'+id).style.display = "none";
		image_number = parent.document.getElementById('hdn_gallery_image_number').value;
		parent.document.getElementById('hdn_gallery_image_ids').value = '';
		parent.document.getElementById('hdn_gallery_image_number').value = (image_number*1 - 1);
		parent.unlinkImagesFromList(id);
		parent.dragTables();
	}
	if(type == 0) {
		document.getElementById('reletediv_'+id).style.display = "none";
		document.getElementById('unlinkdiv_'+id).style.display = "";
		image_number = parent.document.getElementById('hdn_gallery_image_number').value;
		parent.document.getElementById('hdn_gallery_image_ids').value = id;
		parent.document.getElementById('hdn_gallery_image_number').value = (image_number*1 + 1);
		parent.displayImages();
		parent.dragTables();
	}		
	return false;
}

function checkforEnter(event) {	
	if(event.which  == 13) { 		
		doSearch();return false;
	}	
}
function pageSubmit(page) {
	document.getElementById('page').value=page;
	$('#frm_addgallery').submit(); 
	return false;
}

function validateForm1() {
	alert("in validate 1");
	 errors = '';
	 String.prototype.Trim = function() {
		return this.replace(/(^\s*)|(\s*$)/g);
	}

	document.getElementById('mediaFile').style.border = "1px solid #000000";

	  if(document.getElementById("mediaFile").value=="") {
				errors = "Please upload any images";
				document.getElementById('mediaFile').style.border = "1px solid #F40F0F";
		  }
		  if(document.getElementById("mediaFile").value!="") {
				data = document.getElementById("mediaFile").value; 
				indx = (data.lastIndexOf(".")); 
				extension = (data.substring(indx)); 
				if(extension.lastIndexOf(".jpg")==-1 && extension.lastIndexOf(".gif")==-1 && extension.lastIndexOf(".png")==-1  && extension.lastIndexOf(".jpeg")==-1 && extension.lastIndexOf(".JPG")==-1 && extension.lastIndexOf(".GIF")==-1 && extension.lastIndexOf(".PNG")==-1  && extension.lastIndexOf(".JPEG")==-1 ) {		 	
				errors = "Please upload only .jpg/ .png/.gif images";	
				document.getElementById('mediaFile').style.border = "1px solid #F40F0F";
				}
		  }	 
	
	  if(errors.length > 0) {			
			document.getElementById('validation_msg').className = 'validation_field'
			document.getElementById('validation_msg').innerHTML = errors;
			return false;
	  } else {
			return true;
	  }
}

function validateForm2() {
	alert("in validate 2");
	 errors = ''; 

	 errors_array = new Array();
	 String.prototype.Trim = function() {
		return this.replace(/(^\s*)|(\s*$)/g);
	}
	 document.getElementById('mediaFile').style.border = "1px solid #000000";
	 document.getElementById('article_gallery_title').style.border = "1px solid #000000";
	 document.getElementById('article_gallery_alttext').style.border = "1px solid #000000";
	 document.getElementById('article_thumbnail').style.border = "1px solid #000000";
	  if(document.getElementById("mediaFile").value!="") {
			data = document.getElementById("mediaFile").value; 
			indx = (data.lastIndexOf(".")); 
			extension = (data.substring(indx)); 
			if(extension.lastIndexOf(".jpg")==-1 && extension.lastIndexOf(".gif")==-1 && extension.lastIndexOf(".png")==-1  && extension.lastIndexOf(".jpeg")==-1 && extension.lastIndexOf(".JPG")==-1 && extension.lastIndexOf(".GIF")==-1 && extension.lastIndexOf(".PNG")==-1  && extension.lastIndexOf(".JPEG")==-1 ) {		 	
				errors = "Please upload only .jpg/ .png/.gif images";	
				document.getElementById('mediaFile').style.border = "1px solid #F40F0F";
			}				
	  }	 
	  if(document.getElementById("article_thumbnail").value!="") {
			data = document.getElementById("article_thumbnail").value; 
			indx = (data.lastIndexOf(".")); 
			extension = (data.substring(indx)); 
			if(extension.lastIndexOf(".jpg")==-1 && extension.lastIndexOf(".gif")==-1 && extension.lastIndexOf(".png")==-1  && extension.lastIndexOf(".jpeg")==-1 && extension.lastIndexOf(".JPG")==-1 && extension.lastIndexOf(".GIF")==-1 && extension.lastIndexOf(".PNG")==-1  && extension.lastIndexOf(".JPEG")==-1 ) {		 	
				errors = "Please upload only .jpg/ .png/.gif images";	
				document.getElementById('article_thumbnail').style.border = "1px solid #F40F0F";
			}				
	  }
	  data = document.getElementById("article_gallery_title").value;
	  data = data.trim();
	  if(data == '') {
		  errors_array.push("Title");	
		  document.getElementById('article_gallery_title').style.border = "1px solid #F40F0F";
	  }
	  data = document.getElementById("article_gallery_alttext").value;
	  data = data.trim();
	  if(data == '') {
		  errors_array.push("Alt text");
		  document.getElementById('article_gallery_alttext').style.border = "1px solid #F40F0F";
	  }
	
	  if(errors.length > 0 || errors_array.length > 0) {
			error_string = '';
			if(errors_array.length > 0 ) {
				error_string += 'You missed this required field: <font class=red_text>'+errors_array.join(', ')+'</font>';
			}

			if(errors.length > 0 ) {
				error_string += '<br />'+errors;
			}
			
			document.getElementById('validation_msg').className = 'validation_field'
			document.getElementById('validation_msg').innerHTML = error_string;
			return false;
	  } else {
			return true;
	  }
}

