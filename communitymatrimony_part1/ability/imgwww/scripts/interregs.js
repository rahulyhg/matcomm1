var chkSelbox = new Array('lookingStatusTemp','motherTongue','partnerReligion','partnerDenomination','partnerCaste','partnerSubcaste','education','occupation','countryLivingIn','residingIndia','residingUSA','residentStatus');
function interValidate(){
	var frmProfile = document.frmRegister;
	var finalAge = frmProfile.toAge.value - frmProfile.fromAge.value;
	var stAge = 0,endAge = 0;

	if (frmProfile.numOfBrothers.value=="99") {
		if(frmProfile.brothersMarried.value > 0 && frmProfile.brothersMarried.value != "99"){
			$('marriedbrothersspan').innerHTML="Incorrect selection.";frmProfile.brothersMarried.focus();return false;
		}else {$('marriedbrothersspan').innerHTML="";}
	}

	if(!(frmProfile.numOfBrothers.value=="99") && !(frmProfile.brothersMarried.value=="99")){
		if(frmProfile.brothersMarried.value > frmProfile.numOfBrothers.value){
			$('marriedbrothersspan').innerHTML="Incorrect selection.";frmProfile.numOfBrothers.focus();return false;
		}else {$('marriedbrothersspan').innerHTML="";}
	}else{$('marriedbrothersspan').innerHTML="";}


	if (frmProfile.numOfSisters.value=="99") {
		if(frmProfile.sistersMarried.value > 0 && frmProfile.sistersMarried.value != "99"){
			$('marriedsistersspan').innerHTML="Incorrect selection.";frmProfile.sistersMarried.focus();return false;
		}else{$('marriedsistersspan').innerHTML="";}
	}

	if(!(frmProfile.numOfSisters.value=="99") && !(frmProfile.sistersMarried.value=="99")){
		if(frmProfile.sistersMarried.value > frmProfile.numOfSisters.value){
			$('marriedsistersspan').innerHTML="Incorrect selection.";frmProfile.numOfSisters.focus();return false;
		}else{$('marriedsistersspan').innerHTML="";}
	}else{$('marriedsistersspan').innerHTML="";}


	if((frmProfile.fromAge.value == "" ) || (frmProfile.toAge.value == "")) {
		$('stage').innerHTML="Please select the age range of your partner";frmProfile.fromAge.focus();return false;
	} else { $('stage').innerHTML=""; }

	if(finalAge > 20) {
		$('stage').innerHTML="Age range should not exceed 20.";frmProfile.toAge.focus();return false;
	} else { $('stage').innerHTML=""; }

	// Check Age 
	if(frmProfile.fromAge.value != "" && !ValidateNo(frmProfile.fromAge.value, "0123456789")) {
		$('stage').innerHTML="Invalid Age " + frmProfile.fromAge.value;frmProfile.fromAge.focus();return false;
	} else if(frmProfile.fromAge.value != "") {
		stAge = parseInt(frmProfile.fromAge.value);
		if((stAge < partnerage) || stAge > 70) {
			$('stage').innerHTML="Invalid Age " + frmProfile.fromAge.value + ".  Minimum age allowed is "+partnerage+" and maximum age is 70";
			frmProfile.fromAge.focus();return false;
		}
	} else { $('stage').innerHTML=""; }

	if(frmProfile.toAge.value != "" && !ValidateNo(frmProfile.toAge.value, "0123456789")) {
		$('stage').innerHTML="Invalid Age " + frmProfile.toAge.value;frmProfile.toAge.focus();return false;
	} else if (frmProfile.toAge.value != "") {
		endAge = parseInt(frmProfile.toAge.value);
		if((endAge < partnerage) || endAge > 70) {
			$('stage').innerHTML="Invalid Age " +  frmProfile.toAge.value + ".  Minimum age allowed is "+partnerage+" and maximum age is 70";
			frmProfile.toAge.focus();return false;
		}
		if(stAge != 0 && endAge < stAge) {
			$('stage').innerHTML="Invalid age range. " + stAge + " to " + endAge;
			frmProfile.fromAge.focus();return false;
		}
	} else { $('stage').innerHTML=""; }

	if(frmProfile.heightTo.selectedIndex  < frmProfile.heightFrom.selectedIndex) {
		$('stheight').innerHTML="Invalid height range.";frmProfile.heightTo.focus();return false;
	} else { $('stheight').innerHTML=""; }
    
	for(w=0; w<chkSelbox.length; w++){
			selObj = eval('this.document.frmRegister.'+chkSelbox[w]);
			if(selObj != null){selValues(selObj);}
	}
	return true;
}

function moveOptions(theSelFrom, theSelTo){
	var selLength = theSelFrom.length;
	var selectedText = new Array();
	var selectedValues = new Array();
	var selectedCount = 0;
	var selId = theSelFrom.id;
	var i;
	for(i=selLength-1; i>=0; i--)
	{
		if(theSelFrom.options[i].selected){
			selectedText[selectedCount] = theSelFrom.options[i].text;
			selectedValues[selectedCount] = theSelFrom.options[i].value;
			deleteOption(theSelFrom, i);
			selectedCount++;
		}
	}
	for(i=selectedCount-1; i>=0; i--){ addOption(theSelTo, selectedText[i], selectedValues[i]);}
		
}//moveOptions

function deleteOption(theSel, theIndex){	
	var selLength = theSel.length;
	if(selLength>0){theSel.options[theIndex] = null;}
}//deleteOption

function addOption(theSel, theText, theValue)
{
	var add_sel = 's';
	sellen	= theSel.length;
	for(i=0; i<sellen;i++){
		if(theSel.options[i].value == theValue){
		add_sel = 'n';
		}
	}

	if(add_sel=='s'){
	var newOpt = new Option(theText, theValue);
	var selLength = theSel.length;
	theSel.options[selLength] = newOpt;
	}

	sellen	= theSel.length;
	if(sellen > 0){
		for(i=0; i<(sellen-1);i++){
			theSel.options[i].selected=false;	
		}
		theSel.options[(sellen-1)].selected=true;
	}
}//addOption  

// To select all values in left side dropdown while submitting the form
function selValues(theSel){
	var selLength	= theSel.length;
	for(ww=0; ww<selLength; ww++)
	{theSel.options[ww].selected = true;}
}