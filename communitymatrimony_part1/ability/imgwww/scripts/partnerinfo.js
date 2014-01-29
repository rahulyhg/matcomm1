var chkSelbox = new Array('motherTongue','religion','denomination','casteDivision','subCaste','star','gothram','raasi','education','employedIn','occupation','citizenship','countryLivingIn','residingIndia','residingCity','residentStatus');
function PartnerValidate(){
	var frmProfile = document.frmProfile;
	var finalAge = frmProfile.toAge.value - frmProfile.fromAge.value;
	var i,atleastonechk = 0,stAge = 0,endAge = 0;

	for(i=0; i<=mstatuscnt; i++) {
		if(frmProfile.lookingStatus[i].checked) {
			atleastonechk = 1;
			break;
		}
	}
	if(!atleastonechk) {
		$('mstatus').innerHTML="Please select the type of partner you are looking for";frmProfile.lookingStatus[0].focus();
		return false;
	} else { $('mstatus').innerHTML=""; }
	
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
		if((stAge < starfmtage) || stAge > 70) {
			$('stage').innerHTML="Invalid Age " + frmProfile.fromAge.value + ".  Minimum age allowed is "+starfmtage+" and maximum age is 70";
			frmProfile.fromAge.focus();return false;
		}
	} else { $('stage').innerHTML=""; }

	if(frmProfile.toAge.value != "" && !ValidateNo(frmProfile.toAge.value, "0123456789")) {
		$('stage').innerHTML="Invalid Age " + frmProfile.toAge.value;frmProfile.toAge.focus();return false;
	} else if (frmProfile.toAge.value != "") {
		endAge = parseInt(frmProfile.toAge.value);
		if((endAge < starfmtage) || endAge > 70) {
			$('stage').innerHTML="Invalid Age " +  frmProfile.toAge.value + ".  Minimum age allowed is "+starfmtage+" and maximum age is 70";
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
			selObj = eval('this.document.frmProfile.'+chkSelbox[w]);
			if(selObj != null && selObj != undefined){selValues(selObj);}
	}
	return true;
}

function maritalst(){
	var frmProfile = document.frmProfile;
	var i,allchked=1;
	for(i=1; i<=mstatuscnt; i++) {
		if(frmProfile.lookingStatus[i].checked) {
			continue;
		} else {
			allchked = 0;
			break;
		}
	}

	if(allchked==1){
		frmProfile.lookingStatus[0].checked=true;
		for(i=1; i<=mstatuscnt; i++) {
			frmProfile.lookingStatus[i].checked=false;
		}
	} else {
		frmProfile.lookingStatus[0].checked=false;
	}
	$('mstatus').innerHTML="";
}

function maritalstany(){
	var frmProfile = document.frmProfile;
	var i;
	if (frmProfile.lookingStatus[0].checked) {
		for(i=1; i<=mstatuscnt; i++) {
			frmProfile.lookingStatus[i].checked=false;
		}
	}
	$('mstatus').innerHTML="";
}

function checkAnElementInArrray(arr, val) {
  var i = arr.length;
  while (i--) {
    if (arr[i] === val) {
      return true;
    }
  }
  return false;
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
		
	if(selId == 'countryLivingInTemp'){	coun_moveOptions(theSelFrom,theSelTo);}
	else if(selId == 'countryLivingIn'){ coun_moveOptions(theSelTo,theSelFrom);}
	else if(selId == 'residingIndiaTemp'){	coun_moveOptions(theSelFrom,theSelTo);}
	else if(selId == 'residingIndia'){ coun_moveOptions(theSelTo,theSelFrom);}
}//moveOptions

function getFirstOptVal(theSelFrom, optVal){
	firstOptVal = theSelFrom.options[0].value;
	if(optVal == 'country'){
		theSelTo = this.document.frmProfile.countryLivingInTemp;
		selLen = theSelTo.length;
		theSelTo.options[0].selected =false;
		for(XX=0; XX<selLen; XX++){
			if(theSelTo.options[XX].value == firstOptVal){
				theSelTo.options[XX].selected =true;break;
			}
		}
		moveOptions(this.document.frmProfile.countryLivingInTemp, this.document.frmProfile.countryLivingIn);
	}else if(optVal == 'state'){
		coun_moveOptions(this.document.frmProfile.residingIndiaTemp, this.document.frmProfile.residingIndia)
	}
}

function deleteOption(theSel, theIndex){	
	var selLength = theSel.length;
	if(selLength>0){theSel.options[theIndex] = null;}
}//deleteOption

function coun_moveOptions(theSelFrom,theSelTo)
{
	var selLength	= theSelTo.length;
	var selId		= theSelTo.id;
	var selectedValues = new Array();
	var selectedCount = 0;
	var cityAvail	= 0;
	var stateAvail	= 0;
	var w;

	if(selLength==0 && selId=='countryLivingIn'){
		$('residingIndia').innerHTML='';$('residingIndiaTemp').innerHTML='';
		$('residingCity').innerHTML='';$('residingCityTemp').innerHTML='';
		$('statesblock').style.display = "none";$('cityblock').style.display = "none";
	}else if(selId=='residingIndia' && selLength==0){
		$('residingCity').innerHTML='';$('residingCityTemp').innerHTML='';
		$('cityblock').style.display = "none";
	}else{
		for(w=selLength-1; w>=0; w--)
		{
			if(selId == 'countryLivingIn'){
				selectedValues[selectedCount]=theSelTo.options[w].value;
				selectedCount++;
				USStateAvail = 0;
				INDStateAvail = 0;
			}
			else if(selId == 'residingIndia'){
				selectedValues[selectedCount]=theSelTo.options[w].value;
				selectedCount++;
			}
		}
		
		for(w=0; w<selectedCount; w++)
		{
			selVal = selectedValues[w];
			
			if(selId == 'countryLivingIn' && (selVal == 98 || selVal==222) && (INDStateAvail==0 || USStateAvail==0)) {
				$('statesblock').style.display = "block";
				if(stateAvail == 0){
				stateAvail = 1;
				$('residingIndia').innerHTML='';$('residingCity').innerHTML='';
				$('residingIndiaTemp').innerHTML='';$('residingCityTemp').innerHTML='';
				if($('cityblock')!=''){$('cityblock').style.display = "none";}
				coun_updatestate(selVal,'residingIndiaTemp','states',theSelFrom);
				}else{coun_updatestate(selVal,'residingIndiaTemp','states',theSelFrom);	}
				if(selVal == 98 && INDStateAvail==0){ INDStateAvail=1;}
				if(selVal == 222 && USStateAvail==0){ USStateAvail=1;}
			}
			else if(selId == 'countryLivingIn' && INDStateAvail==0 && USStateAvail==0) {
				$('residingIndia').innerHTML='';$('residingCity').innerHTML='';
				$('residingIndiaTemp').innerHTML='';$('residingCityTemp').innerHTML='';
				$('statesblock').style.display = "none";
				if($('cityblock')!=''){$('cityblock').style.display = "none";}
			}
			else if(selId == 'residingIndia' && INDStateAvail ==1 && selVal.substr(0,2)==98) {
				if(cityAvail==0){
					cityAvail=1;
					$('residingCity').innerHTML='';$('residingCityTemp').innerHTML='';
					coun_updatecity(selVal,'residingCityTemp','cities',theSelFrom);
				}else{coun_updatecity(selVal,'residingCityTemp','cities',theSelFrom);}
			}
			else if(selId == 'residingIndia' && cityAvail==0){
				$('cityblock').style.display = "none"; $('residingCity').innerHTML='';$('residingCityTemp').innerHTML='';
			}
		}
	}	
}//moveOptions

function coun_updatecity(j,obj,aryname,selOption)
{
	var aryname	=eval(aryname);
	var obj1	=$(obj);
	var selId	= selOption.id;
	var k = j;
	if(j.substr(0,2)==98)
	{
		for (var i=0; i<aryname[j].length; i++) {
			$('cityblock').style.display = "block";
			addOption(obj1,aryname[j][i].split("|")[0],aryname[j][i].split("|")[1]); 
		}
	}
}

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

function coun_updatestate(j,obj,aryname,selOption)
{	
	var aryname = eval(aryname);
	var selId	= selOption.id;
	var selLength = selOption.length;
	var obj1=$(obj);
	var optionexits = '';
	if(selId=='country'){
		for(i=selLength-1; i>=0; i--) { var optionexits = optionexits +  '~~' + selOption.options[i].value; }
		optionexits = optionexits+'~~';
		if(j == 98){
			for(var i=0; i<aryname[j].length; i++) { 
			addOption(obj1,aryname[j][i].split("|")[0],aryname[j][i].split("|")[1]); 
			}
		}else if(j == 222){
			for(var i=0; i<aryname[j].length; i++) {	
				addOption(obj1,aryname[j][i].split("|")[0],aryname[j][i].split("|")[1]);
			}
		}else {$('statesblock').style.display = "none";$(obj).innerHTML = '';}
	}else {
		for (var i=0; i<aryname[j].length; i++) { 
		addOption(obj1,aryname[j][i].split("|")[0],aryname[j][i].split("|")[1]); 
		}
	}
}  
function city_moveOptions(theSelFrom, theForm)
{
	var selLength=theSelFrom.length;
	var cselectedValues=new Array();
	var cselectedCount=0;
	var cou;
	var ii,z;
	
	for(ii=selLength-1; ii>=0; ii--) {
		if(theSelFrom.options[ii].selected) {
			cselectedValues[cselectedCount]=theSelFrom.options[ii].value;
			cselectedCount++;
		}
	}
	coun_moveOptions(theSelFrom);
	for(d=cselectedCount-1; d>=0; d--) {
		var stobj=cselectedValues[d];
		if(stobj.substr(0,2)==98) {
		for (t=0;t<cities[stobj].length;t++) {
			for (g=0;g<theForm.residingCity.length;g++) {
				if (theForm.residingCity.options[g].value==cities[stobj][t].split("|")[1])
				{theForm.residingCity.remove(g);}
			}
		}
		}
	}
	
	for(z=selLength-1; z>=0; z--) { if((theSelFrom.options[z] != null) && (theSelFrom.options[z].selected)) { 	state_based_enable_disable(theSelFrom);}}
}
function state_based_enable_disable(theSelFrom) {
	var selLength=theSelFrom.length;
	var cselectedText=new Array();
	var cselectedValues=new Array();
	var cselectedCount=0;
	var city_flag=true;
	for(i=selLength-1; i>=0; i--) { cselectedValues[cselectedCount]=theSelFrom.options[i].value;cselectedCount++; }
	for(d=cselectedCount-1; d>=0; d--)
	{
		var stobj=cselectedValues[d];
		if(stobj.substr(0,2)==98) { city_flag=false;break; }
	}
	if(city_flag==true) { $('cityblock').style.display = "none"; }
}

// To select all values in left side dropdown while submitting the form
function selValues(theSel){
	var selLength	= theSel.length;
	for(ww=0; ww<selLength; ww++)
	{theSel.options[ww].selected = true;}
	
}