/*
 	ETeam Web Solutions India Pvt Ltd ,Trivandrum. 
 	eteam@asianetindia.com 
 
	*@ name		: String_JS.js 				@ version:1.0
 	*@ author	: arun@eteamindia.com
*/
/************************* STRING FUNCTIONS **********************************************
****************	boolean = String.endsWith(<string>)	**********************************
****************	<string> = String.replace(<string>, <string>)	**********************
****************	<string> = String.replaceAll(<string>, <string>)	******************
****************	<string> = String.ltrim()	******************************************
****************	<string> = String.rtrim()	******************************************
****************	<string> = String.trim()	******************************************
****************	<Date> = String.toDate()	******************************************
******************************************************************************************/

theAgent = navigator.userAgent.toLowerCase();
var isMozilla = false;
var isKonqueror = (theAgent.indexOf("konqueror") != -1);
var isSafari = (theAgent.indexOf("safari") != -1);
var isOpera = (theAgent.indexOf("opera") != -1);
var isGecko = !isKonqueror && !isSafari && (theAgent.indexOf("gecko/") != -1);
var isNetscape = !isOpera && ((theAgent.indexOf('mozilla')!=-1) && ((theAgent.indexOf('spoofer')==-1) && (theAgent.indexOf('compatible') == -1)));
var isWebtv = (theAgent.indexOf("webtv") != -1);
var isIE = !isWebtv && !isOpera && (theAgent.indexOf("msie") != -1);

/////////////////////////// Starts with the specified string//////////////////////////////
if (!String.prototype.startsWith) {
	String.prototype.startsWith = function(suffix) {
		var startPos = this.length - suffix.length;
		if (startPos < 0) {
			return false;
		}
		return (this.indexOf(suffix, 0) == 0);
	};
}

/////////////////////////// Ends with the specified string//////////////////////////////
if (!String.prototype.endsWith) {
	String.prototype.endsWith = function(suffix) {
		var startPos = this.length - suffix.length;
		if (startPos < 0) {
			return false;
		}
		return (this.lastIndexOf(suffix, startPos) == startPos);
	};
}

//////////// replaces only the first occurance of the given text with new text/////////////////////////////////////
if (!String.prototype.replace) {
	String.prototype.replace = function(strWhich, strToWhat) {   
		var regWhich = new RegExp(strWhich);
		return(this.replace(regWhich, strToWhat));
	};
}

//////////// replaces the occurance of the given text with new text/////////////////////////////////////
if (!String.prototype.replaceAll) {
	String.prototype.replaceAll = function(strWhich, strToWhat) {   
		var regWhich = new RegExp(strWhich, "g");
		return(this.replace(regWhich, strToWhat));
	};
}

//////////// removes the space from left of the string /////////////////////////////////////
if (!String.prototype.ltrim) {
	String.prototype.ltrim = function() {
		var retAr = new RegExp(/\S/i).exec(this);
		if(retAr == null) return(this);
		return(this.substring(retAr.index, this.length));
	};
}

//////////// removes the space from right of the string /////////////////////////////////////
if (!String.prototype.rtrim) {
	String.prototype.rtrim = function() {
		//var retAr = new RegExp(/( *)$/).exec(this);
		var retAr = new RegExp(/(\s*)$/i).exec(this);		
		return(this.substring(0, retAr.index));
	};
}

//////////// removes the space from left & right of the string /////////////////////////////////////
if (!String.prototype.trim) {
	String.prototype.trim = function() {
		var strTmp = this.ltrim();
		return(strTmp.rtrim());
	};
}

/////////////////////// converts string to date (if any error in the input string, the functio returns todays date) ///////
if (!String.prototype.toDate) {
	String.prototype.toDate = function() {
		var date_type = "INVALIDDATE";
		var regValid1 = new RegExp(/^([0-3$]{0,1})([0-9$]{0,1})(\-|\/|\.)([0-1$]{0,1})([0-9$]{0,1})\3(\d{4})$/); //dd-mm-yyyy
		var regValid2 = new RegExp(/^([0-1$]{0,1})([0-2$]{0,1})(\-|\/|\.)([0-3$]{0,1})([0-9$]{0,1})\3(\d{4})$/); //mm-dd-yyyy
		var regValid3 = new RegExp(/^(\d{4})(\-|\/|\.)([0-1$]{0,1})([0-2$]{0,1})\2([0-3$]{0,1})([0-9$]{0,1})$/); //yyyy-mm-dd
		if(regValid1.test(this)){
			date_type = "DDMMYYYY";
		}else if(regValid2.test(this)){
			date_type = "MMDDYYYY";
		}else if(regValid3.test(this)){
			date_type = "YYYYMMDD";
		}
		if(date_type != "INVALIDDATE"){
			var arr = this.split(/(\-|\/|\.)/);	
			var tmpDate = new Date();
			if(isIE || isSafari){
				if(date_type == "DDMMYYYY"){
					if(isSafari){
						tmonth = parseInt(arr[2], 10);
						tmpDate.setFullYear(arr[4], tmonth - 1, arr[0]);
					}else{
						tmonth = parseInt(arr[1], 10);
						tmpDate.setFullYear(arr[2], tmonth - 1, arr[0]);
					}
				}else if(date_type == "MMDDYYYY"){
					if(isSafari){
						tmonth = parseInt(arr[0], 10);
						tmpDate.setFullYear(arr[4], tmonth - 1, arr[2]);
					}else{
						tmonth = parseInt(arr[0], 10);
						tmpDate.setFullYear(arr[2], tmonth - 1, arr[1]);
					}
				}else if(date_type == "YYYYMMDD"){
					if(isSafari){
						tmonth = parseInt(arr[2], 10);
						tmpDate.setFullYear(arr[0], tmonth - 1, arr[4]);
					}else{
						tmonth = parseInt(arr[1], 10);
						tmpDate.setFullYear(arr[0], tmonth - 1, arr[2]);
					}
				}
			}else if(isOpera || isNetscape){
				if(date_type == "DDMMYYYY"){
					tmpDate.setFullYear(arr[4], arr[2] - 1, arr[0]);
				}else if(date_type == "MMDDYYYY"){
					tmpDate.setFullYear(arr[4], arr[0] - 1, arr[2]);
				}else if(date_type == "YYYYMMDD"){
					tmpDate.setFullYear(arr[0], arr[2] - 1, arr[4]);
				}
			}
			return(tmpDate);
		}
		return(new Date());
	};
}

/////////////////////// converts string to date (if any error in the input string, the functio returns todays date) ///////
if (!String.prototype.toFDate) {
	String.prototype.toFDate = function(format) {		
		var date_type = "";
		if(format == '') date_type = "INVALIDDATE";
		else date_type = format;
		
		if(date_type != "INVALIDDATE"){
			var arr = this.split(/(\-|\/|\.)/);	
			var tmpDate = new Date();
			if(isIE || isSafari){
				if(date_type == "DDMMYYYY"){
					if(isSafari){
						tmonth = parseInt(arr[2], 10);
						tmpDate.setFullYear(arr[4], tmonth - 1, arr[0]);
					}else{
						tmonth = parseInt(arr[1], 10);
						tmpDate.setFullYear(arr[2], tmonth - 1, arr[0]);
					}
				}else if(date_type == "MMDDYYYY"){
					if(isSafari){
						tmonth = parseInt(arr[0], 10);
						tmpDate.setFullYear(arr[4], tmonth - 1, arr[2]);
					}else{
						tmonth = parseInt(arr[0], 10);
						tmpDate.setFullYear(arr[2], tmonth - 1, arr[1]);
					}
				}else if(date_type == "YYYYMMDD"){
					if(isSafari){
						tmonth = parseInt(arr[2], 10);
						tmpDate.setFullYear(arr[0], tmonth - 1, arr[4]);
					}else{
						tmonth = parseInt(arr[1], 10);
						tmpDate.setFullYear(arr[0], tmonth - 1, arr[2]);
					}
				}
			}else if(isOpera || isNetscape){
				if(date_type == "DDMMYYYY"){
					tmpDate.setFullYear(arr[4], arr[2] - 1, arr[0]);
				}else if(date_type == "MMDDYYYY"){
					tmpDate.setFullYear(arr[4], arr[0] - 1, arr[2]);
				}else if(date_type == "YYYYMMDD"){
					tmpDate.setFullYear(arr[0], arr[2] - 1, arr[4]);
				}
			}
			return(tmpDate);
		}
		return(new Date());
	};
}

if (!String.prototype.hasSpecialCharacters) {
	String.prototype.hasSpecialCharacters = function() {
		var regValid = new RegExp(/^((\w)|(\_|\-))*$/);
		var regInvalid = new RegExp(/^[\_|\-]+$/);
		return(!(regValid.test(this) && !regInvalid.test(this)));
	}
}

if (!String.prototype.isNumber) {
	String.prototype.isNumber = function() {
		var regValidNum = new RegExp(/^[0-9]*$/);
		return(regValidNum.test(this));
	}
}

if (!String.prototype.isDecimalNumber) {
	String.prototype.isDecimalNumber = function() {
		var regValidNum = new RegExp(/^[0-9]*\.{1,1}[0-9]*$/);
		return(regValidNum.test(this));
	}
}

if (!String.prototype.isDecimalNumber3) {
	String.prototype.isDecimalNumber3 = function() {
		var regValidNum = new RegExp(/^[0-9]{1,7}(\.{1,1}\d{1,3})*$/);
		return(regValidNum.test(this));
	}
}

if (!String.prototype.isDecimalNumber15) {
	String.prototype.isDecimalNumber15 = function() {
		var regValidNum = new RegExp(/^[0-9]{1,13}(\.{1,1}\d{1,2})*$/);
		return(regValidNum.test(this));
	}
}

if (!String.prototype.isValidNumbers) {
	String.prototype.isValidNumbers = function(numRange) {
		return(numRange.indexOf("\|" + this + "\|") >= 0);
	}
}

if (!String.prototype.compareTo) {
	String.prototype.compareTo = function( withString ) {
		var thisLength = this.length;
		var wStringLength = withString.length;
		var nLength = ( thisLength < wStringLength ? thisLength : wStringLength );
		for( var i = 0 ; i < nLength ; i++ ) {
			var a = this.charCodeAt( i );
			var b = withString.charCodeAt( i )
			if( a != b ) {
				return( a - b );
			}
		}
		return( thisLength - wStringLength );
	}
}