var checkBoxCount = 0; //global variable to hold the checkbox count
var checkBoxSelectedCount = 0; //global variable to hold the checked checkbox count
var valueHolderObject = null; // global variable for holding selected checkbox values; and the values are written with ~ as delimiter
var dummyValue = "0"; // need to edit if this value is using as one of the values in objects
var valueDelimiter = ","; // need to edit this value if need to change the delimiter
var listSelectorArray = new Array();

var ListSelector = {
	createListSelector : function(){
		switch(arguments.length){
			case 2:
				return(new this.createWith2Arguments(arguments[0], arguments[1]));
			case 3:
				return(new this.createWith3Arguments(arguments[0], arguments[1], arguments[2]));

		}
	},
	createWith2Arguments: function(arg1, arg2){
		this.checkBoxName = null;
		this.checkBoxNames = null;
		this.formName = arg1;
		this.checkBoxCount = 0;
		this.checkBoxSelectedCount = 0;
		if(typeof(arg2) == 'string'){
			this.checkBoxName = arg2;
			this.checkNaming = "GENERATE_SEQUENCE";
		}else{
			this.checkBoxNames = arg2;
			this.checkNaming = "NAMES_ARRAY";
		}
		this.selectAllCheckBox = "";
		this.valueHolder = "";
		this.callBack = null;
		this.selectAllCallback = null;
		this.forceChecked = false;
		listSelectorArray.push(this);
	},
	createWith3Arguments: function(arg1, arg2, arg3){
		this.checkBoxName = null;
		this.checkBoxNames = null;
		this.checkBoxCount = 0;
		this.checkBoxSelectedCount = 0;
		this.formName = arg1;
		if(typeof(arg2) == 'string'){
			this.checkBoxName = arg2;
			this.checkNaming = "GENERATE_SEQUENCE";
		}else{
			this.checkBoxNames = arg2;
			this.checkNaming = "NAMES_ARRAY";
		}
		this.selectAllCheckBox = arg3;
		this.valueHolder = "";
		this.callBack = null;
		this.selectAllCallback = null;
		this.forceChecked = false;
		listSelectorArray.push(this);
	}
};

ListSelector.createWith2Arguments.prototype = {
	getFormName : function(){
		return(this.formName);
	},	
	getCheckBoxNames: function(){
		return(this.checkBoxNames);
	},
	getCheckBoxName: function(){
		return(this.checkBoxName);
	},
	getSelectAllCheckBox : function(){
		return(this.selectAllCheckBox);
	},
	setValueHolder : function(valueHolder){
		this.valueHolder = valueHolder;
	},
	getValueHolder : function(){
		return(this.valueHolder);
	},
	getCheckBoxNaming: function(){
		return(this.checkNaming);
	},
	setCheckBoxCount : function(checkBoxCount){
		this.checkBoxCount = checkBoxCount;
	},
	getCheckBoxCount : function(){
		return(this.checkBoxCount);
	},
	setCheckBoxSelectedCount : function(checkBoxSelectedCount){
		this.checkBoxSelectedCount = checkBoxSelectedCount;
	},
	getCheckBoxSelectedCount : function(){
		return(this.checkBoxSelectedCount);
	},
	getValueHolderObject : function(){
		return(eval(this.formName + "." + this.valueHolder));
	},
	setCallbackFunction : function(callBack) {
		this.callBack = callBack;
	},
	getCallbackFunction : function() {
		return(this.callBack);
	},
	forceClick: function(flag) {
		try{
			selectAllObject = eval(this.formName + "." + this.selectAllCheckBox);
			this.forceChecked = flag;
			selectAllObject.click();
		} catch(e){}
	},
	setAfterSelectAll: function(selectAllCallback) {
		this.selectAllCallback = selectAllCallback;
	},
	getAfterSelectAll: function() {
		return(this.selectAllCallback);
	}
};

ListSelector.createWith3Arguments.prototype = {
	getFormName : function(){
		return(this.formName);
	},
	getCheckBoxNames: function(){
		return(this.checkBoxNames);
	},
	getCheckBoxName : function(){
		return(this.checkBoxName);
	},
	getSelectAllCheckBox : function(){
		return(this.selectAllCheckBox);
	},
	setValueHolder : function(valueHolder){
		this.valueHolder = valueHolder;
	},
	getValueHolder : function(){
		return(this.valueHolder);
	},
	getCheckBoxNaming: function(){
		return(this.checkNaming);
	},
	setCheckBoxCount : function(checkBoxCount){
		this.checkBoxCount = checkBoxCount;
	},
	getCheckBoxCount : function(){
		return(this.checkBoxCount);
	},
	setCheckBoxSelectedCount : function(checkBoxSelectedCount){
		this.checkBoxSelectedCount = checkBoxSelectedCount;
	},
	getCheckBoxSelectedCount : function(){
		return(this.checkBoxSelectedCount);
	},
	getValueHolderObject : function(){
		return(eval(this.formName + "." + this.valueHolder));
	},
	setCallbackFunction : function(callBack) {
		this.callBack = callBack;
	},
	getCallbackFunction : function() {
		return(this.callBack);
	},	
	forceClick: function(flag) {
		try{
			selectAllObject = eval(this.formName + "." + this.selectAllCheckBox);
			this.forceChecked = flag;
			selectAllObject.click();
		} catch(e){}
	},
	setAfterSelectAll: function(selectAllCallback) {
		this.selectAllCallback = selectAllCallback;
	},
	getAfterSelectAll: function() {
		return(this.selectAllCallback);
	}
};

addLoadEvent(function(){
	for(i=0; i<listSelectorArray.length; i++){
		addHandler(listSelectorArray[i]);
	}
});

function getAllListSelectors() {
	return listSelectorArray;
}

function addLoadEvent(func){
	if ( typeof window.addEventListener != "undefined" ){
		window.addEventListener( "load", func, false );
	}else if ( typeof window.attachEvent != "undefined" ) {
		window.attachEvent( "onload", func );
	}else{
		var oldonload = window.onload;
		if(typeof window.onload != 'function'){
			window.onload = func;
		}else{
			window.onload = function() {
				if (oldonload) {				
					oldonload();
				}
				func();
			}
		}
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
function addHandler(listSelector){
	selectAllObject = null;
	if(listSelector.getFormName() != ''){
		formObject = eval(listSelector.getFormName());
		if(typeof(formObject) != 'undefined' && formObject != null){
			if(listSelector.getSelectAllCheckBox() != ''){
				selectAllObject = eval(listSelector.getFormName() + "." + listSelector.getSelectAllCheckBox());
				if(typeof(selectAllObject) != 'undefined' && selectAllObject != null){
					selectAllObject.checked = false;					
					if(selectAllObject.attachEvent){
						selectAllObject.attachEvent('onclick', function(e){
								doSelectAllIE(listSelector, e)
							});
					}else if(selectAllObject.addEventListener){
						selectAllObject.addEventListener('change', function(e){
								doSelectAll(listSelector, e)
							}, true);
					}else{
						selectAllObject.addEventListener('change', function(e){
								doSelectAll(listSelector, e)
							}, false);
					}

				}//if(selectAllObject.toString() != 'null' || selectAllObject.toString() != 'undefined'){
			}//if(listSelector.getSelectAllCheckBox() != ''){
			
			
			/*adding handler to other check boxes in the list*/
			if(listSelector.getCheckBoxNaming() == 'GENERATE_SEQUENCE'){
				formObjectElements = formObject.elements;
				for(index=0; index<formObjectElements.length; index++){
					if(formObjectElements[index].type.toLowerCase() == 'checkbox'){						
						if(formObjectElements[index].name.startsWith(listSelector.getCheckBoxName())){
							listSelector.setCheckBoxCount(listSelector.getCheckBoxCount() + 1);
							formObjectElements[index].checked = false; // this is to refresh the checkboxes, sometimes it will not reset while refreshing... so that the count will be incorrect.							
							setEventForCheckBox(formObjectElements[index], listSelector, selectAllObject);
						}
					}
				}
			}else if(listSelector.getCheckBoxNaming() == 'NAMES_ARRAY'){
				if(listSelector.getCheckBoxNames() != null){
					var checkObject;
					for(index=0; index < listSelector.getCheckBoxNames().length; index++){
						//checkBoxCount++;
						listSelector.setCheckBoxCount(listSelector.getCheckBoxCount() + 1);
						checkObject = eval(listSelector.getFormName() + "." + listSelector.getCheckBoxNames()[index]);
						checkObject.checked = false; // this is to refresh the checkboxes, sometimes it will not reset while refreshing... so that the count will be incorrect.
						setEventForCheckBox(checkObject, listSelector, selectAllObject);
					}
				}
			}
		}//if(formObject.toString() != 'null' || formObject.toString() != 'undefined'){
	}//if(listSelector.getFormName() != ''){
	
	if(listSelector.getValueHolder() != null && listSelector.getValueHolder() != ''){
		if(typeof(listSelector.getValueHolderObject()) != 'undefined' && listSelector.getValueHolderObject() != null){
			if(listSelector.getValueHolderObject().value == '') listSelector.getValueHolderObject().value = dummyValue;
			else initValues(listSelector, selectAllObject, listSelector.getValueHolderObject().value + valueDelimiter);
		}
	}
};

function initValues(listSelector, selectAllObject, intialValue){
	if(listSelector.getCheckBoxNaming() == 'GENERATE_SEQUENCE'){
		formObjectElements = eval(listSelector.getFormName()).elements;	
		for(index=0; index<formObjectElements.length; index++){
			if(formObjectElements[index].type.toLowerCase() == 'checkbox'){				
				if(formObjectElements[index].name.startsWith(listSelector.getCheckBoxName())){
					if(intialValue.indexOf(valueDelimiter + formObjectElements[index].value + valueDelimiter) >= 0){
						formObjectElements[index].checked = true;
						listSelector.setCheckBoxSelectedCount(listSelector.getCheckBoxSelectedCount() + 1);
					}
				}
			}
		}
	}else if(listSelector.getCheckBoxNaming() == 'NAMES_ARRAY'){
		if(listSelector.getCheckBoxNames() != null){
			var checkObject;
			for(index=0; index < listSelector.getCheckBoxNames().length; index++){
				checkObject = eval(listSelector.getFormName() + "." + listSelector.getCheckBoxNames()[index]);
				if(intialValue.indexOf(valueDelimiter + checkObject.value + valueDelimiter) >= 0){
					checkObject.checked = true;
					listSelector.setCheckBoxSelectedCount(listSelector.getCheckBoxSelectedCount() + 1);
				}
			}
		}
	}
	if(selectAllObject != null){	
		if(listSelector.getCheckBoxCount() == listSelector.getCheckBoxSelectedCount()){
			selectAllObject.checked = true;
		}else{
			if(selectAllObject.checked) selectAllObject.checked = false;
		}
	}
}

//select all method for IE
function doSelectAllIE(listSelector, e){	
	if(listSelector.getCheckBoxNaming() == 'GENERATE_SEQUENCE'){
		formObjectElements = eval(listSelector.getFormName()).elements;	
		for(index=0; index<formObjectElements.length; index++){
			if(formObjectElements[index].type.toLowerCase() == 'checkbox'){				
				if(formObjectElements[index].name.startsWith(listSelector.getCheckBoxName())){
					if(e.srcElement.checked){
						if(!formObjectElements[index].checked) {
							formObjectElements[index].checked = e.srcElement.checked;							
							if(listSelector.getValueHolderObject() != null) listSelector.getValueHolderObject().value = listSelector.getValueHolderObject().value + valueDelimiter + formObjectElements[index].value;
							if(listSelector.getCallbackFunction() != null) {								
								listSelector.getCallbackFunction().apply(this, new Array(formObjectElements[index]));
							}
						}
					}else{
						formObjectElements[index].checked = e.srcElement.checked;
						if(listSelector.getValueHolderObject() != null) listSelector.getValueHolderObject().value = listSelector.getValueHolderObject().value.replace(valueDelimiter + formObjectElements[index].value, "");
						if(listSelector.getCallbackFunction() != null) {							
							listSelector.getCallbackFunction().apply(this, new Array(formObjectElements[index]));
						}
					}
				}
			}
		}
	}else if(listSelector.getCheckBoxNaming() == 'NAMES_ARRAY'){
		if(listSelector.getCheckBoxNames() != null){
			var checkObject;
			var selectAllFromEvent = e.srcElement;
			if(listSelector.forceChecked) {
				selectAllFromEvent.checked = true;
			}
			for(index=0; index < listSelector.getCheckBoxNames().length; index++){
				checkObject = eval(listSelector.getFormName() + "." + listSelector.getCheckBoxNames()[index]);
				if(selectAllFromEvent.checked){
					if(!checkObject.checked){
						checkObject.checked = selectAllFromEvent.checked;
						if(listSelector.getValueHolderObject() != null) 
							listSelector.getValueHolderObject().value = listSelector.getValueHolderObject().value + valueDelimiter + checkObject.value;
					}
				}else{
					checkObject.checked = selectAllFromEvent.checked;
					if(listSelector.getValueHolderObject() != null) listSelector.getValueHolderObject().value = listSelector.getValueHolderObject().value.replace(valueDelimiter + checkObject.value, "");
				}
			}
		}
	}
	if(e.srcElement.checked) listSelector.setCheckBoxSelectedCount(listSelector.getCheckBoxCount());
	else listSelector.setCheckBoxSelectedCount(0);
	listSelector.forceChecked = false;
	
	/*invoking callback after selectAll*/
	if(listSelector.getAfterSelectAll() != null) {
		listSelector.getAfterSelectAll().apply(this, new Array(e.srcElement));
	}
};

//select all method for other browsers
function doSelectAll(listSelector, e){
	if(listSelector.getCheckBoxNaming() == 'GENERATE_SEQUENCE'){
		formObjectElements = eval(listSelector.getFormName()).elements;
		for(index=0; index < formObjectElements.length; index++){
			if(formObjectElements[index].type.toLowerCase() == 'checkbox'){				
				if(formObjectElements[index].name.startsWith(listSelector.getCheckBoxName())){
					if(e.target.checked){
						if(!formObjectElements[index].checked){
							formObjectElements[index].checked = e.target.checked;							
							if(listSelector.getValueHolderObject() != null) listSelector.getValueHolderObject().value = listSelector.getValueHolderObject().value + valueDelimiter + formObjectElements[index].value;
							if(listSelector.getCallbackFunction() != null) {								
								listSelector.getCallbackFunction().apply(this, new Array(formObjectElements[index]));
							}
						}
					}else{
						formObjectElements[index].checked = e.target.checked;						
						if(listSelector.getValueHolderObject() != null) listSelector.getValueHolderObject().value = listSelector.getValueHolderObject().value.replace(valueDelimiter + formObjectElements[index].value, "");
						if(listSelector.getCallbackFunction() != null) {								
							listSelector.getCallbackFunction().apply(this, new Array(formObjectElements[index]));
						}
					}
				}
			}
		}
	}else if(listSelector.getCheckBoxNaming() == 'NAMES_ARRAY'){
		if(listSelector.getCheckBoxNames() != null){
			var checkObject;
			var selectAllFromEvent = e.target;
			if(listSelector.forceChecked) {
				selectAllFromEvent.checked = true;
			}
			for(index=0; index < listSelector.getCheckBoxNames().length; index++){
				checkObject = eval(listSelector.getFormName() + "." + listSelector.getCheckBoxNames()[index]);
				if(selectAllFromEvent.checked){
					if(!checkObject.checked){
						checkObject.checked = selectAllFromEvent.checked;						
						if(listSelector.getValueHolderObject() != null) listSelector.getValueHolderObject().value = listSelector.getValueHolderObject().value + valueDelimiter + checkObject.value;
					}
				}else{
					checkObject.checked = selectAllFromEvent.checked;					
					if(listSelector.getValueHolderObject() != null) listSelector.getValueHolderObject().value = listSelector.getValueHolderObject().value.replace(valueDelimiter + checkObject.value, "");
				}
			}
		}
	}
	if(e.target.checked) listSelector.setCheckBoxSelectedCount(listSelector.getCheckBoxCount());
	else listSelector.setCheckBoxSelectedCount(0);
	listSelector.forceChecked = false;
	
	/*invoking callback after selectAll*/
	if(listSelector.getAfterSelectAll() != null) {
		listSelector.getAfterSelectAll().apply(this, new Array(e.target));
	}
};

//select for IE
function doSelectIE(listSelector, selectAllObject, e){
	if(e.srcElement.checked){
		//checkBoxSelectedCount++;
		listSelector.setCheckBoxSelectedCount(listSelector.getCheckBoxSelectedCount() + 1);
		if(listSelector.getValueHolderObject() != null) listSelector.getValueHolderObject().value = listSelector.getValueHolderObject().value + valueDelimiter + e.srcElement.value;		
		
	}else{
		//checkBoxSelectedCount--;
		listSelector.setCheckBoxSelectedCount(listSelector.getCheckBoxSelectedCount() - 1);		
		if(listSelector.getValueHolderObject() != null) listSelector.getValueHolderObject().value = listSelector.getValueHolderObject().value.replace(valueDelimiter + e.srcElement.value, "");
	}

	if(selectAllObject != null){
		if(listSelector.getCheckBoxCount() == listSelector.getCheckBoxSelectedCount()){
			selectAllObject.checked = true;
		}else{
			if(selectAllObject.checked) selectAllObject.checked = false;
		}
	}
};

//select for other browsers
function doSelect(listSelector, selectAllObject, e){	
	if(e.target.checked){
		//checkBoxSelectedCount++;
		listSelector.setCheckBoxSelectedCount(listSelector.getCheckBoxSelectedCount() + 1);
		
		if(listSelector.getValueHolderObject() != null) listSelector.getValueHolderObject().value = listSelector.getValueHolderObject().value + valueDelimiter + e.target.value;
	}else{
		//checkBoxSelectedCount--;
		listSelector.setCheckBoxSelectedCount(listSelector.getCheckBoxSelectedCount() - 1);		
		if(listSelector.getValueHolderObject() != null) listSelector.getValueHolderObject().value = listSelector.getValueHolderObject().value.replace(valueDelimiter + e.target.value, "");
	}
	if(selectAllObject != null){
		if(listSelector.getCheckBoxCount() == listSelector.getCheckBoxSelectedCount()){
			selectAllObject.checked = true;
		}else{
			if(selectAllObject.checked) selectAllObject.checked = false;
		}
	}
};

function setEventForCheckBox(element, listSelector, selectAllObject) {
	if(element.attachEvent){
		element.attachEvent('onclick', function(e){									
				doSelectIE(listSelector, selectAllObject, e)
			});
	}else if(element.addEventListener){
		element.addEventListener('change', function(e){
				doSelect(listSelector, selectAllObject, e)
			}, true);
	}else{
		element.addEventListener('change', function(e){
				doSelect(listSelector, selectAllObject, e)
			}, false);
	}
};