function genNumbers() {
  var d=new Date();
  var rand_flag = "sr"+d.getSeconds()+"we";
  return rand_flag;
}
/*position find*/
function fillSelectFromArray(selectCtrl, itemArray, goodPrompt, badPrompt, defaultItem)
{
	var i;var optn = new Array();
	if (itemArray != null) {
		for (i = 0; i < itemArray.length; i++) {
			optn = itemArray.split("|");
			selectCtrl.options[i].text  = optn[0];
			selectCtrl.options[i].value = optn[1]; 
		}
		//selectCtrl.options[0].selected = true;
   }
}//fillSelectFromArray

function IsEmpty(obj, obj_type)
{
	if (obj_type == "text" || obj_type == "password" || obj_type == "textarea" || obj_type == "file")	{
		var objValue;
		objValue = obj.value.replace(/\s+$/,"");
		if (objValue.length == 0) {
			return true;
		} else {
			return false;
		}
	} else if (obj_type == "select" || obj_type == "select-one") {
		for (i=0; i < obj.length; i++) {
			if (obj.options[i].selected) 
				{
					if(obj.options[i].value==" ") 
					{return true;obj.focus();} else {return false;}
					
					if(obj.options[i].value == "0") 
					{
						if(obj.options[i].seletedIndex == "0") 
						{return true;obj.focus();}
					} else {return false;}
				}
			
		}
		return true;	
	} else if (obj_type == "radio" || obj_type == "checkbox") {
		if (!obj[0] && obj) {
			if (obj.checked) {
				return false;
			} else {
				return true;	
			}
		} else {
			for (i=0; i < obj.length; i++) {
				if (obj[i].checked) {
					return false;
				}
			}
			return true;
		}
	} else {
		return false;
	}
}

function CompareValue( NumStr, pattern )
{
	for( var Idx = 0; Idx < NumStr.length; Idx ++ )
	{
		 var Char = NumStr.charAt( Idx );
		 var Match = false;

		for( var Idx1 = 0; Idx1 < pattern.length; Idx1 ++)
		{
		 if( Char == pattern.charAt( Idx1 ) )
		 Match = true;
		}
		if ( !Match )
		return false;
 	}
   	return true;
}

function ValidateEmail(Email)
{
	var funRegExp	      = new RegExp("^[A-Za-z0-9][A-Za-z0-9_\\.\-]*\\@[a-zA-Z0-9]+\\.[a-zA-Z]+[\\.]?[a-zA-Z]*$");
	if (!Email.match(funRegExp)) { return false; }//if
	return true;
}

function ChkEmpty(obj,obj_type,spanname,msg)
{
	var msgt	= obj + obj_type + spanname + msg;
//alert(msgt);

	if (obj_type=="text" || obj_type=="password" || obj_type=="textarea" || obj_type=="file")
	{
		var objValue;
		objValue = obj.value.replace(/\s+$/,"");
		if (objValue.length == 0)
		{document.getElementById(spanname).innerHTML=msg;return true;} 
		else {document.getElementById(spanname).innerHTML=" ";return false;}
	} 
	
	if (obj_type == "select") 
	{
		if (obj.selectedIndex==0)
		{document.getElementById(spanname).innerHTML=msg;return true;} 
		else {document.getElementById(spanname).innerHTML="";return false;}
		return true;	
	} 
	
	if (obj_type == "radio" || obj_type == "checkbox") 
	{
		var objlength=obj.length
		var objcount=0;
		for (i=0;i<objlength;i++ )
		{
			if(obj[i].checked){objcount=1;break;}else{objcount=0;}
		}
		if(objcount==0)
		{document.getElementById(spanname).innerHTML=msg;}
		else{document.getElementById(spanname).innerHTML=" ";}
		
		return true;
	} 
	
		return false;
}

function ValidateNo( NumStr, String )
{
	for( var Idx = 0; Idx < NumStr.length; Idx ++ )
	{
		 var Char = NumStr.charAt( Idx );
		 var Match = false;

		for( var Idx1 = 0; Idx1 < String.length; Idx1 ++)
		{
		 if( Char == String.charAt( Idx1 ) )
		 Match = true;
		}

		if ( !Match )
		return false;
 	}
   	return true;
}

function replaceAlpha(strIn) {
	var strOut='';
	for(var i=0 ; i < strIn.length ; i++) {
		var cChar=strIn.charAt(i);
		if((cChar >= 'A' && cChar <= 'Z') || (cChar >= 'a' && cChar <= 'z') || (cChar >= '0' && cChar <= '9')) {
			strOut += cChar;
		} else {
			strOut += "_";
		}
	} return strOut;
}

function SplNameChar(txt){
	if(txt.length == 0)
		return false;
	for(var i = 0;i < txt.length;i++){
		if(txt.charAt(i) == '@' || txt.charAt(i) == '#' 
			|| txt.charAt(i) == '!' || txt.charAt(i) == '$' 
			|| txt.charAt(i) == '%' || txt.charAt(i) == '&' 
			|| txt.charAt(i) == '^' || txt.charAt(i) == '*'  
			|| txt.charAt(i) == '-' || txt.charAt(i) == '=' 
			|| txt.charAt(i) == '+' || txt.charAt(i) == '|' 
			|| txt.charAt(i) == '?' || txt.charAt(i) == '<' 
			|| txt.charAt(i) == '>' || txt.charAt(i) == '/' 
			|| txt.charAt(i) == '[' || txt.charAt(i) == ']' 
			|| txt.charAt(i) == '(' || txt.charAt(i) == ')' 
			|| txt.charAt(i) == '`' || txt.charAt(i) == "," 
			|| txt.charAt(i) == ":" || txt.charAt(i) == ";" 
			|| txt.charAt(i) == "{" 
			|| txt.charAt(i) == "}" || txt.charAt(i) == '"'
			|| txt.charAt(i) == '\\'|| txt.charAt(i) == "'" )
			return true;
	}
	return false;
}//SplNameChar

function nullchk(txt)
{
	if (txt == "" || txt == null)
	{ return true; }
		
	var i;
	for(i=0;i<txt.length;i++)
	{
		if (txt.charAt(i) != " ")
		return false
	}
	return true;
}//nullchk

function HasSpace(txt){		
	if(txt.length == 0)
		return false;
	for(var i = 0;i < txt.length;i++){
		if(txt.charAt(i) == " ")
			return true;
	}
	return false;
}//HasSpace

function getSelectedRadio(buttonGroup) {
   // returns the array number of the selected radio button or -1 if no button is selected
   if (buttonGroup[0]) { // if the button group is an array (one button is not an array)
      for (var i=0; i<buttonGroup.length; i++) {
         if (buttonGroup[i].checked) {
            return i
         }
      }
   } else {
      if (buttonGroup.checked) { return 0; } // if the one button is checked, return zero
   }
   // if we get to this point, no radio button is selected
   return -1;
} // Ends the "getSelectedRadio" function

function getSelectedRadioValue(buttonGroup) {
   // returns the value of the selected radio button or "" if no button is selected
   var i = getSelectedRadio(buttonGroup);
   if (i == -1) {
      return "";
   } else {
      if (buttonGroup[i]) { // Make sure the button group is an array (not just one button)
         return buttonGroup[i].value;
      } else { // The button group is just the one button, and it is checked
         return buttonGroup.value;
      }
   }
} // Ends the "getSelectedRadioValue" function

// function to check a specific element in specific array ,Returns false if it is not//
function checkValueInArray(arr,val) {
  var i;
  for (i=0; i < arr.length; i++) {
	if (arr[i] == val) {
	 return true;
	}
  }
  return false;
}

// function which allows user to enter only numbers and backspace key
function allowNumeric(e) {
   var charCode = (e.which) ? e.which : window.event.keyCode; 
      if(((charCode >= 48) && (charCode <= 57)) || (charCode == 8) ) {
          return true;
	  }
	  return false;
}