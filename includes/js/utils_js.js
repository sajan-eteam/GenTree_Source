function acceptNumbersOnly(txtobj, e, decimal, hyphen){
	var key = window.event ? e.keyCode : e.which;
	if(hyphen && key == 45){
		if(txtobj.value.indexOf("-") < 0) {
			return(true);
		}
	}
	if(decimal && key == 46) {
		if(txtobj.value.indexOf(".") < 0) {
			return(true);
		}
	}
	if(key >= 48 && key <= 57) {
		return true;
	}
	else {
		if(key == 0 || key == 8 || key == 13) {
			return true;
		}
		else {
			return false;
		}
	}
}

function clearField(fieldObject) {
	fieldObject = eval(fieldObject);
	if(fieldObject.type.toString().indexOf("select") >= 0) {
		for(i=(fieldObject.options.length-1); i > 0; i--) {
			fieldObject.options[i] = null;
		}
	}
	else if(fieldObject.type.toString().indexOf("text") >= 0) {
		fieldObject.value = "";
	}
	else if(fieldObject.type.toString().indexOf("checkbox") >= 0) {
		fieldObject.checked = false;
	}
	else if(fieldObject.type.toString().indexOf("hidden") >= 0) {
		fieldObject.value = "";
	}
	else if(fieldObject.type.toString().indexOf("file") >= 0) {
		fieldObject.value = "";
	}
}

function showPopups(popupLayerID, iwidth) {
	$('#overlay').css('height', $(document).height());
	$('#overlay').addClass('lightbox_bg').show();
	$('#' + popupLayerID).addClass('modalPopup');
	
	// to centralize ----------------------------------->>>>>>
	if (navigator.appVersion.indexOf("Win")!=-1) OSName = "Windows";
	if (navigator.appVersion.indexOf("Mac")!=-1) OSName = "MacOS";
	if (navigator.appVersion.indexOf("X11")!=-1) OSName = "UNIX";
	if (navigator.appVersion.indexOf("Linux")!=-1) OSName = "Linux";
	//check browser
	var op, saf, konq, moz, ie, fox;
	var userAgent	= navigator.userAgent;
	op = (userAgent.indexOf('Opera')!=-1);
	saf = (userAgent.indexOf('Safari')!=-1);
	konq = (!saf && (userAgent.indexOf('Konqueror')!=-1) ) ? true : false;
	moz = ((!saf && !konq) && ( userAgent.indexOf('Gecko')!=-1 ) ) ? true : false;
	fox = ((moz) && (userAgent.indexOf('Firefox')!=-1 ) ) ? true : false;
	ie = ((userAgent.indexOf('MSIE')!=-1)&&!op);
	//set top and left
	var topProp, leftProp, screenX, screenY;
	if(ie) {
		screenX = screen.availWidth;
		screenY = document.body.offsetHeight;
	}
	else {
		screenX = outerWidth
		screenY = outerHeight;
	}
	var leftvar = (screenX - iwidth) / 2;
	if(ie) {
		leftProp = leftvar - 10;
	}
	else if(fox || moz) {
		if(OSName == 'MacOS') {
			leftProp = (leftvar - pageXOffset) - 15;
		}
		else {
			leftProp = (leftvar - pageXOffset) - 15;
			if(leftProp < 0) {
				leftProp = 0;
			}
		}
	}
	else {
		if(OSName == 'MacOS') {
			leftProp = (leftvar - pageXOffset) - 10;
		}
		else {
			leftProp = (leftvar - pageXOffset) - 10;
			if(leftProp < 0) {
				leftProp = 0;
			}
		}
	}
	topProp = (document.documentElement.scrollTop || document.body.scrollTop) - (document.documentElement.clientTop || 0) + 100;	
	document.getElementById(popupLayerID).style.top = topProp + "px";
	document.getElementById(popupLayerID).style.left = leftProp + "px";
	
	$('#' + popupLayerID).css('display', 'block');
}

function hidePopups(popupLayerID) {
	try {
		$('#overlay').removeClass('lightbox_bg').hide();
		$('#' + popupLayerID).removeClass('modalPopup');
		document.getElementById(popupLayerID).style.top = 0;
		document.getElementById(popupLayerID).style.left = 0;
		$('#' + popupLayerID).css('display', 'none');		
	} 
	catch (e){}
}

function showPopups(bkLayerID, popupLayerID, iwidth) {
	jQ('#' + bkLayerID).css('height', jQ(document).height());
	jQ('#' + bkLayerID).addClass('lightbox_bg').show();
	jQ('#' + popupLayerID).addClass('modalPopup');
	
	// to centralize ----------------------------------->>>>>>
	if (navigator.appVersion.indexOf("Win")!=-1) OSName = "Windows";
	if (navigator.appVersion.indexOf("Mac")!=-1) OSName = "MacOS";
	if (navigator.appVersion.indexOf("X11")!=-1) OSName = "UNIX";
	if (navigator.appVersion.indexOf("Linux")!=-1) OSName = "Linux";
	//check browser
	var op, saf, konq, moz, ie, fox;
	var userAgent	= navigator.userAgent;
	op = (userAgent.indexOf('Opera')!=-1);
	saf = (userAgent.indexOf('Safari')!=-1);
	konq = (!saf && (userAgent.indexOf('Konqueror')!=-1) ) ? true : false;
	moz = ((!saf && !konq) && ( userAgent.indexOf('Gecko')!=-1 ) ) ? true : false;
	fox = ((moz) && (userAgent.indexOf('Firefox')!=-1 ) ) ? true : false;
	ie = ((userAgent.indexOf('MSIE')!=-1)&&!op);
	//set top and left
	var topProp, leftProp, screenX, screenY;
	if(ie) {
		screenX = screen.availWidth;
		screenY = document.body.offsetHeight;
	}
	else {
		screenX = outerWidth
		screenY = outerHeight;
	}
	var leftvar = (screenX - iwidth) / 2;
	if(ie) {
		leftProp = leftvar - 10;
	}
	else if(fox || moz) {
		if(OSName == 'MacOS') {
			leftProp = (leftvar - pageXOffset) - 15;
		}
		else {
			leftProp = (leftvar - pageXOffset) - 15;
			if(leftProp < 0) {
				leftProp = 0;
			}
		}
	}
	else {
		if(OSName == 'MacOS') {
			leftProp = (leftvar - pageXOffset) - 10;
		}
		else {
			leftProp = (leftvar - pageXOffset) - 10;
			if(leftProp < 0) {
				leftProp = 0;
			}
		}
	}
	topProp = (document.documentElement.scrollTop || document.body.scrollTop) - (document.documentElement.clientTop || 0) + 100;	
	document.getElementById(popupLayerID).style.top = topProp + "px";
	document.getElementById(popupLayerID).style.left = leftProp + "px";
	
	jQ('#' + popupLayerID).css('display', 'block');
}

function hidePopups(bkLayerID, popupLayerID) {
	try {
		jQ('#' + bkLayerID).removeClass('lightbox_bg').hide();
		jQ('#' + popupLayerID).removeClass('modalPopup');
		document.getElementById(popupLayerID).style.top = 0;
		document.getElementById(popupLayerID).style.left = 0;
		jQ('#' + popupLayerID).css('display', 'none');
	} 
	catch (e){}
}

function showFloatPopups(bkLayerID, popupLayerID, iwidth) {
	jQ('#' + bkLayerID).css('height', jQ(document).height());
	jQ('#' + bkLayerID).addClass('lightbox_bg').show();
	jQ('#' + popupLayerID).css('display', 'block');
}

function hideFloatPopups(bkLayerID, popupLayerID) {
	try {
		jQ('#' + bkLayerID).removeClass('lightbox_bg').hide();
		jQ('#' + popupLayerID).css('display', 'none');
	} 
	catch (e){}
}
