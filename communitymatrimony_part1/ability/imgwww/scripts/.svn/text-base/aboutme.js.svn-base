var isSubcasteMandatory = 1;
function HaveChildnp(){
  var frmProfile=document.frmProfile;
  var marSt = frmProfile.maritalStatus.options[frmProfile.maritalStatus.selectedIndex].value;
  var childLW = frmProfile.noOfChildren.options[frmProfile.noOfChildren.selectedIndex].value;
  if(childLW > 0){ if(marSt == 1){
    if ( (frmProfile.childLivingWithMe[0].checked || frmProfile.childLivingWithMe[1].checked) && (!frmProfile.childLivingWithMe[0].checked || !frmProfile.childLivingWithMe[1].checked) ){
      frmProfile.childLivingWithMe[0].checked=false;frmProfile.childLivingWithMe[1].checked=false;
      frmProfile.childLivingWithMe[0].disabled=true;frmProfile.childLivingWithMe[1].disabled=true;
    }
  }}
  if(marSt == 1){
  frmProfile.noOfChildren.disabled=true;frmProfile.childLivingWithMe[0].disabled=true;
  frmProfile.childLivingWithMe[1].disabled=true;
    }else if ( marSt > 1){
    frmProfile.noOfChildren.disabled=false;
    frmProfile.childLivingWithMe[0].disabled=false;frmProfile.childLivingWithMe[1].disabled=false;
  }
  if(marSt == 1 && frmProfile.childLivingWithMe[0].checked || frmProfile.childLivingWithMe[1].checked){
  frmProfile.childLivingWithMe[0].disabled=true;frmProfile.childLivingWithMe[1].disabled=true;
  }
  if(childLW == 0){
  frmProfile.childLivingWithMe[0].disabled=true;frmProfile.childLivingWithMe[1].disabled=true;
    }else if ( childLW >=1 && marSt > 1){
  frmProfile.childLivingWithMe[0].disabled=false;frmProfile.childLivingWithMe[1].disabled=false;
  }
}

function onKGS() {
	if (!(document.frmProfile.weightLbs.value=="0")){document.frmProfile.weightLbs.value="0";}
}
	
function onLBS() {
	if (!(document.frmProfile.weightKgs.value=="0")){document.frmProfile.weightKgs.value="0";}		
}

function chkIncomeDet() {
	var frmProfile = document.frmProfile;
	if(frmProfile.annualIncomeCurrency.selectedIndex!=0){
		 if(frmProfile.annualIncome.value == '') {
			$('income').innerHTML="Please enter annual income amount";frmProfile.annualIncome.focus();return false;
		  }else {$('income').innerHTML="";}
	}
}

function chkOthersGotram() {
	var frmProfile = this.document.frmProfile;
	if(document.frmProfile.gothram.value == 9997) {
		document.getElementById('othgotramdiv').style.display="block";
	} else {
		document.getElementById('othgotramdiv').style.display="none";
	}
}

function aboutmeValidate() {
	var frmProfile = document.frmProfile;
    var communityId = frmProfile.communityId.value;

	if(frmProfile.maritalstatusfeature.value == 1){
		if(frmProfile.maritaltxtfeature.value == 1) { //hidden value
		} else if(frmProfile.maritaltxtfeature.value > 1){ //drop down values
			if(frmProfile.maritalStatus.selectedIndex == 0){
				$('mstatus').innerHTML="Please select the marital status of the prospect";frmProfile.maritalStatus.focus();return false;
			} else { $('mstatus').innerHTML=""; }

			if(frmProfile.maritalStatus.options[frmProfile.maritalStatus.selectedIndex].value > 1 && frmProfile.noOfChildren.selectedIndex == 0 ){
				$('mstatus').innerHTML="Please select the number of children";frmProfile.noOfChildren.focus();return false;
			} else { $('mstatus').innerHTML=""; }

			if(frmProfile.maritalStatus.options[frmProfile.maritalStatus.selectedIndex].value > 1 && frmProfile.noOfChildren.options[frmProfile.noOfChildren.selectedIndex].value >= 1 && !frmProfile.childLivingWithMe[0].checked && !frmProfile.childLivingWithMe[1].checked) {
				$('mstatus').innerHTML="Please indicate whether the child/children is/are living with you";frmProfile.childLivingWithMe[0].focus();
				return false;
			} else { $('mstatus').innerHTML=""; }
		}
	}
    
    if(frmProfile.heightFeet.selectedIndex==0 && frmProfile.heightCms.selectedIndex==0){
		$('height').innerHTML="Please select the height of the prospect";frmProfile.heightFeet.focus();return false;
	}else{
		$('height').innerHTML="";
	}

	/*if(!frmProfile.physicalStatus[0].checked && !frmProfile.physicalStatus[1].checked){
		$('physical').innerHTML="Please select the physical status of the prospect";frmProfile.physicalStatus[0].focus();return false;
	}else{ $('physical').innerHTML=""; } */

	if (parseInt(document.frmProfile.appearanceFeature.value)==1) {
		if (!frmProfile.appearance[0].checked && !frmProfile.appearance[1].checked) {
			document.getElementById('spanappearance').innerHTML="Select the appearance of the prospect";
			frmProfile.appearance[0].focus();
			return false;
		} else { document.getElementById('spanappearance').innerHTML=""; }
	}

	if(frmProfile.mothertonguefeature.value == 1){
		if(frmProfile.mothertonguetxtfeature.value == 1) { //hidden value
		} else if(frmProfile.mothertonguetxtfeature.value > 1){ //drop down values
			if(frmProfile.motherTongue.selectedIndex == 0){
				$('mothertong').innerHTML="Please select the mother tongue of the prospect";frmProfile.motherTongue.focus();return false;
			} else {
				$('mothertong').innerHTML="";
			}

			//chkOthers();

			/*if(document.frmProfile.motherTongue.value == 9997) {
				if(frmProfile.motherTongueTxt.value == '') {
					$('mothertong').innerHTML="Please enter the mother tongue of the prospect";frmProfile.motherTongueTxt.focus();return false;
				} else {
					$('mothertong').innerHTML="";
				}
			}*/
		} else { //text box value
			if(frmProfile.motherTongueTxt.value == '') {
				$('mothertong').innerHTML="Please enter the mother tongue of the prospect";frmProfile.motherTongueTxt.focus();return false;
			} else {
				$('mothertong').innerHTML="";
			}
		}
	}
    
	if (parseInt(document.frmProfile.religionfeature.value)==1 && parseInt(document.frmProfile.religionOption.value)>1 ) {
		if (parseInt(document.frmProfile.religion.options[document.frmProfile.religion.selectedIndex].value)== 0) {
			document.getElementById('religionspan').innerHTML="Select the religion of the prospect";
			document.frmProfile.religion.focus();return false;
		} else { document.getElementById('religionspan').innerHTML=''; }

	}

	if (parseInt(frmProfile.denominationfeature.value)==1 && parseInt(frmProfile.denominationOption.value)>1 ) {
		if (parseInt(frmProfile.denomination.options[frmProfile.denomination.selectedIndex].value)== 0) {
			document.getElementById('denominationspan').innerHTML="Select the "+frmProfile.denominationlabel.value+" of the prospect";
			document.frmProfile.denomination.focus();return false;
		}
		else if(parseInt(frmProfile.denomination.options[frmProfile.denomination.selectedIndex].value) == 9997) {
		   if(frmProfile.denominationText.value == '') {
			 document.getElementById('denominationspan').innerHTML="Select the "+frmProfile.denominationlabel.value+" of the prospect";
			 document.frmProfile.denominationText.focus();
			 return false;
		   }
		   else {
			 document.getElementById('denominationspan').innerHTML='';
		   }
		}
		else {
			document.getElementById('denominationspan').innerHTML='';
		}
	}

	if (parseInt(document.frmProfile.castefeature.value)==1 && document.frmProfile.castemandatory.value==1) {

		if (parseInt(document.frmProfile.casteOption.value)==1) {} else {
			
			if (parseInt(document.frmProfile.casteOption.value)>1) {

				/*if (parseInt(document.frmProfile.caste.options[document.frmProfile.caste.selectedIndex].value)== 0) {
				document.getElementById('castespan').innerHTML="Select the "+document.frmProfile.castelabel.value+" of the prospect";
				document.frmProfile.caste.focus();
				return false;
				} else { document.getElementById('castespan').innerHTML=''; }*/

				var casteId = parseInt(document.frmProfile.caste.options[document.frmProfile.caste.selectedIndex].value);
				if (casteId == 0) {
				document.getElementById('castespan').innerHTML="Select the "+document.frmProfile.castelabel.value+" of the prospect";
				document.frmProfile.caste.focus();
				return false;
				}
				else if(casteId == 9997) {
				  if (document.frmProfile.casteOthers.value=="") {
						document.getElementById('castespan').innerHTML="Enter the "+document.frmProfile.castelabel.value+" of the prospect";
						document.frmProfile.casteOthers.focus();
						return false;
				  }
				  else { document.getElementById('castespan').innerHTML=''; }
				}
				else { document.getElementById('castespan').innerHTML=''; }


			} else {
				var validateSubCaste = 'yes';

				if((document.frmProfile.communityId.value=='2001')) {
					var religionId	= document.frmProfile.religion.options[document.frmProfile.religion.selectedIndex].value;
					if ((religionId=='8') || (religionId=='9')) { validateSubCaste = 'no'; }
				}

				if (validateSubCaste=='yes') {
					//if (IsEmpty(document.frmProfile.casteText,'text')) {
					if(document.frmProfile.casteText.value == "") {
						document.getElementById('castespan').innerHTML="Enter the "+document.frmProfile.castelabel.value+" of the prospect";
						document.frmProfile.casteText.focus();
						return false;
					} else { document.getElementById('castespan').innerHTML=''; }
				}
			}
		}
	}

	if (parseInt(document.frmProfile.subcastefeature.value)==1 && document.frmProfile.subcastemandatory.value==1 && isSubcasteMandatory == 1) { 
		if (parseInt(document.frmProfile.subCasteOption.value)==1) { } else {
			if (parseInt(document.frmProfile.subCasteOption.value)>1) { 
				var subCasteId = parseInt(document.frmProfile.subCaste.options[document.frmProfile.subCaste.selectedIndex].value);
				document.getElementById("subCasteDivText").style.display="none";
				if (subCasteId== 0) {
					document.getElementById("subCasteDivText").style.display="none";
					document.getElementById('subcastespan').innerHTML="Select the "+document.frmProfile.subcastelabel.value+" of the prospect";
					document.frmProfile.subCaste.focus();return false;
				} else if (subCasteId==9997) {
					document.getElementById("subCasteDivText").style.display="block";
					if (document.frmProfile.subCasteOthers.value=="") {
						document.getElementById('subcastespan').innerHTML="Enter the "+document.frmProfile.subcastelabel.value+" of the prospect";
						document.frmProfile.subCasteOthers.focus();return false;
					} else { document.getElementById('subcastespan').innerHTML=''; }
				} else { document.getElementById('subcastespan').innerHTML=''; }

			} else {

				if (document.frmProfile.subCasteText.value=="") { 
					document.getElementById('subcastespan').innerHTML="Enter the "+document.frmProfile.subcastelabel.value+" of the prospect";
					document.frmProfile.subCasteText.focus();return false;
				} else { document.getElementById('subcastespan').innerHTML=''; }

			}
		}
	}

	if (parseInt(document.frmProfile.gothramfeature.value)==1) {
		if (parseInt(document.frmProfile.gothramOption.value)>1) {
			var gothramId = parseInt(document.frmProfile.gothram.options[document.frmProfile.gothram.selectedIndex].value);
			if (gothramId== 0 && communityId != 2004) {
				document.getElementById("gothramDivText").style.display="none";
				document.getElementById('gothraspan').innerHTML="Select the gothram of the prospect";
				document.frmProfile.gothram.focus();return false;
			} else if (gothramId==9997) {
				document.getElementById("gothramDivText").style.display="block";
				if (document.frmProfile.gothramOthers.value=="" && communityId != 2004) {
					document.getElementById('gothraspan').innerHTML="Enter the gothram of the prospect";
					document.frmProfile.gothramOthers.focus();return false;
				} else { document.getElementById('gothraspan').innerHTML=''; }
			} else { document.getElementById('gothraspan').innerHTML=''; }
		}
	}
 
	if (frmProfile.educationCategory.selectedIndex==0)
     {document.getElementById('educationcategoryspan').innerHTML="Select the education category of the prospect";frmProfile.educationCategory.focus();return false;}	
    else{document.getElementById('educationcategoryspan').innerHTML="";}
   
    if (frmProfile.occupation.selectedIndex==0)
     {document.getElementById('occupationspan').innerHTML="Select the occupation of the prospect";frmProfile.occupation.focus();return false;}	
     else{document.getElementById('occupationspan').innerHTML="";}

    if(frmProfile.occupation.options[frmProfile.occupation.selectedIndex].value != 888) {
		if (parseInt(document.frmProfile.empinfeature.value)==1) {
			if (parseInt(document.frmProfile.employedinOption.value)>1) {
				if ( IsEmpty(document.frmProfile.employmentCategory,'radio')) {
				  document.getElementById('employmentCategoryspan').innerHTML="Select the employment category of the prospect";
				  frmProfile.employmentCategory[0].focus();
				  return false;}
				else{document.getElementById('employmentCategoryspan').innerHTML=""; }
			}
		}

		var inCurr = document.frmProfile.annualIncomeCurrency.options[document.frmProfile.annualIncomeCurrency.selectedIndex].value;

		if (inCurr==0) {
			document.getElementById('annualincomespan').innerHTML="Select the currency type";
			document.frmProfile.annualIncomeCurrency.focus();
			return false;
		} else { document.getElementById('annualincomespan').innerHTML=""; }

		if (IsEmpty(document.frmProfile.annualIncome,'text')) {

			document.getElementById('amountspan').innerHTML="Enter a valid income";frmProfile.annualIncome.focus();return false;

		} else { document.getElementById('amountspan').innerHTML=""; }

		if (!(IsEmpty(document.frmProfile.annualIncome,'text'))) {

			if(!ValidateNo(document.frmProfile.annualIncome.value,'1234567890 ,.'))
			{document.getElementById('amountspan').innerHTML="Enter a valid income";frmProfile.annualIncome.focus();return false;}	
			else { document.getElementById('amountspan').innerHTML=""; }
		 }
   }


	/*if(!(IsEmpty(frmProfile.annualIncome,'text'))){
		if(frmProfile.annualIncomeCurrency.selectedIndex==0){
			$('income').innerHTML="Please first select the currency and then enter the annual income of the prospect.";frmProfile.annualIncome.focus();return false;
		}else{$('income').innerHTML="";}
		
		if(!ValidateNo(frmProfile.annualIncome.value,'1234567890,. ')){
			$('income').innerHTML="Please enter valid Income of the prospect";frmProfile.annualIncome.focus();return false;
		}else {$('income').innerHTML="";}
	}*/

  
   
   if(frmProfile.country.value == 0){
		$('loccountry').innerHTML="Please select the country of living of the prospect";frmProfile.country.focus();return false;
	}else{
		$('loccountry').innerHTML="";
	}

	var cntry = frmProfile.country.value;
	if(cntry == 98 || cntry == 222) {
		if(frmProfile.residingState.selectedIndex == 0 ){
			$('locresidingstate').innerHTML="Please select the resident state of the prospect";frmProfile.residingState.focus();
			return false;
		}else{
			$('locresidingstate').innerHTML="";
		}
	} else {
		if(frmProfile.residingState.value == '' ){
			$('locresidingstate').innerHTML="Please enter the resident state of the prospect";frmProfile.residingState.focus();
			return false;
		}else{
			$('locresidingstate').innerHTML="";
		}
	}

	if(cntry == 98) {
		if(frmProfile.residingCity.selectedIndex == 0 ){
			$('locresidingcity').innerHTML="Please select the residing city of the prospect";frmProfile.residingCity.focus();
			return false;
		}else{
			$('locresidingcity').innerHTML="";
		}
	} else {
		if(frmProfile.residingCity.value == '' ){
			$('locresidingcity').innerHTML="Please enter the residing city of the prospect";
			frmProfile.residingCity.focus();
			return false;
		}else{
			$('locresidingcity').innerHTML="";
		}
	}


   var countryId;
   countryId = document.frmProfile.country.options[document.frmProfile.country.selectedIndex].value;
   if (countryId!=98) {
	if(frmProfile.citizenship.selectedIndex == 0){
		$('loccitizenship').innerHTML="Please select the citizenship of the prospect";frmProfile.citizenship.focus();return false;
	}else{$('loccitizenship').innerHTML="";}
   }
	if(frmProfile.residentStatus.selectedIndex == 0 && communityId != 2006){
		$('locresident').innerHTML="Please select the resident status of the prospect";frmProfile.residentStatus.focus();
		return false;
	}else {$('locresident').innerHTML="";}  
	
	if((IsEmpty(frmProfile.DESCDET,'textarea'))){
		$('aboutmyselfspan').innerHTML="Please enter your description.";frmProfile.DESCDET.focus();return false;
	}else{$('aboutmyselfspan').innerHTML="";}

	if (frmProfile.DESCDET.value.length<50) {
		$('aboutmyselfspan').innerHTML="Please enter a profile description in not less than 50 characters";
		document.frmProfile.DESCDET.focus();
		return false;
	} else { $('aboutmyselfspan').innerHTML=""; }
}

function onCMS() {
	if (!(document.frmProfile.heightFeet.value=="0"))
	{document.frmProfile.heightFeet.value="0";}
}
	
function onFEET() {
	if (!(document.frmProfile.heightCms.value=="0"))
	{document.frmProfile.heightCms.value="0";}
}

function heightChk(){
	var frmProfile = this.document.frmProfile;
	if (frmProfile.heightFeet.selectedIndex==0 && frmProfile.heightCms.selectedIndex==0) {
		$('height').innerHTML="Please select the height of the prospect";
		return;
	} else {
		$('height').innerHTML=" ";
	}
}

function checkEmployment() {
	if ( IsEmpty(document.frmProfile.employmentCategory,'radio')) {
	document.getElementById('employmentCategoryspan').innerHTML="Select the employment category of the prospect";
	return false;}
	else{document.getElementById('employmentCategoryspan').innerHTML=""; }
}

var objOccupationCall;
function ajaxOccupationCall(url) {
	var varEmploymentIn = "";
	var varOccupationId = frmProfile.occupationid.value; 
	for (var i=0; i < frmProfile.employmentCategory.length; i++) {

		if (frmProfile.employmentCategory[i].checked) {
			varEmploymentIn	= frmProfile.employmentCategory[i].value;break;
		}
	}
	if (varEmploymentIn!=5) {
	   objOccupationCall = AjaxCall();
	   var parameters	=  "selectedEmploymentIn="+varEmploymentIn+"&selectedOccupationId="+varOccupationId+"&display=state&rand="+Math.random();
	   objOccupationCall.onreadystatechange = regOccupationList;
	   objOccupationCall.open('POST', url, true);
	   objOccupationCall.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	   objOccupationCall.setRequestHeader("Content-length", parameters.length);
	   objOccupationCall.setRequestHeader("Connection", "close");
	   objOccupationCall.send(parameters);
	   return objOccupationCall;	
	}
}

function regOccupationList() {

	if (objOccupationCall.readyState == 4 && objOccupationCall.status == 200) {
		document.getElementById('occdiv').innerHTML	= objOccupationCall.responseText;
	}
}

function occupationChk() {
		var frmProfile = document.frmProfile;
		var inCurr = document.frmProfile.annualIncomeCurrency.options[document.frmProfile.annualIncomeCurrency.selectedIndex].value;

		if (inCurr==0) {
			document.getElementById('annualincomespan').innerHTML="Select the currency type";
			return false;
		} else { document.getElementById('annualincomespan').innerHTML=""; }
	
		if (!(IsEmpty(document.frmProfile.annualIncome,'text'))) {

			if(!ValidateNo(document.frmProfile.annualIncome.value,'1234567890 ,.'))
			{document.getElementById('amountspan').innerHTML="Enter a valid income";frmProfile.annualIncome.focus();return false;}	
			else{document.getElementById('amountspan').innerHTML="";}
		}
}

function amountChk() {
	var frmProfile = this.document.frmProfile;
	if (!(IsEmpty(document.frmProfile.annualIncome,'text')))
	{
		if (frmProfile.annualIncomeCurrency.selectedIndex==0)
		{document.getElementById('annualincomespan').innerHTML="Select the currency type";return;}	
		else{document.getElementById('annualincomespan').innerHTML=" ";}

		if(!ValidateNo(document.frmProfile.annualIncome.value,'1234567890,.'))
		{document.getElementById('amountspan').innerHTML="Enter a valid income";return;}	
		else{document.getElementById('amountspan').innerHTML=" ";}
	}
}


function countryChk() {
	 var frmProfile = document.frmProfile;
	 var countryId = parseInt( frmProfile.country.options[frmProfile.country.selectedIndex].value);
	if ( countryId == 0 || countryId == "" ) {
		$('loccountry').innerHTML="Please select the country of living of the prospect";
		return;
	} else {
		$('loccountry').innerHTML="";
		if (countryId != 98) {
			document.getElementById('showCitizenship').style.display="block";
	    } else { document.getElementById('showCitizenship').style.display="none"; }
		modifystate(frmProfile.country.value);
	}

	//makerequest(document.frmProfile.country.options[document.frmProfile.country.selectedIndex].value);
}

var state_request = false;
function modifystate(cval) {	
	if(cval>0 && cval!=null) {
		state_request = AjaxCall();
		var url="../profiledetail/getstates.php?countryid="+cval; //Mano
		state_request.onreadystatechange = processResponseState;
		state_request.open('GET', url, true);
		state_request.send(null);
	} else {}
}

function processResponseState() {
	if (state_request.readyState == 4) {
		if (state_request.status == 200) {
			$("statecitydiv").innerHTML = '';
			$("statecitydiv").innerHTML = state_request.responseText;
		}
	}
}

var ccode_request = false;
function modrequestnew(cvalue) {	
	if(cvalue>0 && cvalue!=null) {
		ccode_request = AjaxCall();
		var url="../register/getcities.php?stateid="+cvalue; //Mano
		ccode_request.onreadystatechange = processResponsenew;
		ccode_request.open('GET', url, true);
		ccode_request.send(null);
	} else {
		emptyCitySel();
	}
}

function emptyCitySel() {
	var citysel = $('residingCity');
	if (citysel.length>0) {
		for(i=citysel.length;i>=0;i--) {
			citysel.remove(i);
		}
	}
	var y=document.createElement('option');
	y.value='0';
	y.text='-Select-';
	try {
		citysel.add(y,null); // standards compliant
	} catch(ex) {
		citysel.add(y); // IE only
	}
}

function processResponsenew() {
	if (ccode_request.readyState == 4) {
		if (ccode_request.status == 200) {
			var citysel = $('residingCity');
			var listValues = ccode_request.responseText;
			listValueArray = listValues.split('~');
			var y;
			for(i=0;i<listValueArray.length;i=i+2) {
			  y=document.createElement('option');
			  y.value=listValueArray[i];
			  y.text=listValueArray[i+1];
			  try {
				citysel.add(y,null); // standards compliant
			  } catch(ex) {
				citysel.add(y); // IE only
			  }
			}
		}
	}
	else
	{
		emptyCitySel();
	}
}

var countrycode_request=false;
function makerequest(cvalue) {
	if(cvalue>0 && cvalue!=null) {
		countrycode_request = AjaxCall();
		var url="../register/countrycode.php?country="+cvalue; //Mano
		countrycode_request.onreadystatechange = processResponse;
		countrycode_request.open('GET', url, true);
		countrycode_request.send(null);
	}
}

function processResponse() {
	if (countrycode_request.readyState == 4) {
		if (countrycode_request.status == 200) {
			document.frmProfile.countryCode.value=countrycode_request.responseText;
		}
	}
}

// function to handle occupation selection in dropdown box //
function selectOccupation(occupationValue) {
  if(occupationValue == 888) {
   frmProfile.occupationInDetail.disabled = true;
   EnableDisableEmployedIn(true);
   frmProfile.annualIncomeCurrency.disabled=true;
   frmProfile.annualIncome.disabled=true;
   document.getElementById('employmentCategoryspan').innerHTML="";
   document.getElementById('annualincomespan').innerHTML="";
   document.getElementById('amountspan').innerHTML="";
  }
  else {
   frmProfile.occupationInDetail.disabled = false;
   EnableDisableEmployedIn(false);
   frmProfile.annualIncomeCurrency.disabled=false;
   frmProfile.annualIncome.disabled=false;
  }
}

 // function to disable whole employedin category radio buttons //
 function EnableDisableEmployedIn(flgStatus) {
   for(var i=0;i < frmProfile.employmentCategory.length;i++) {
    frmProfile.employmentCategory[i].disabled = flgStatus;
   }
 }

 function othsubcasteChk(){
	var frmProfile = this.document.frmProfile;
	if (frmProfile.subCasteOthers.value=='' && (isSubcasteMandatory == 1)) {
		document.getElementById('subcastespan').innerHTML="Enter the "+document.frmProfile.subcastelabel.value+" of the prospect";
		return;
	} else {
		document.getElementById('subcastespan').innerHTML=" ";
	}
}

function othgothramChk(){
	var frmProfile = this.document.frmProfile;
	if (frmProfile.gothramOthers.value=='') {
		document.getElementById('gothraspan').innerHTML="Enter the gothram of the prospect";
		return;
	} else {
		document.getElementById('gothraspan').innerHTML=" ";
	}
}

function denominationChk() {
	var frmProfile = this.document.frmProfile;
	if (parseInt(frmProfile.denominationfeature.value)==1 && parseInt(frmProfile.denominationOption.value)>1 ) {
		if (parseInt(frmProfile.denomination.options[frmProfile.denomination.selectedIndex].value)== 0) {
			document.getElementById('denominationspan').innerHTML="Select the "+frmProfile.denominationlabel.value+" of the prospect";
			return false;
		}
		else if(parseInt(frmProfile.denomination.options[frmProfile.denomination.selectedIndex].value) == 9997) {
			if(frmProfile.denominationText.value == '') {
			document.getElementById('denominationspan').innerHTML="Enter the "+frmProfile.denominationlabel.value+" of the prospect";
			return false;
			}
			else {
			 document.getElementById('denominationspan').innerHTML='';
			}
		}
		else {
			document.getElementById('denominationspan').innerHTML='';
		}

	}
}

function religiousChk() {
	var frmProfile = this.document.frmProfile;
	if (parseInt(frmProfile.religiousfeature.value)==1 && parseInt(frmProfile.religiousOption.value)>1 ) {
		if (parseInt(frmProfile.religious.options[frmProfile.religious.selectedIndex].value)== 0) {
			document.getElementById('religiousspan').innerHTML="Select the religious values of the prospect";
			return false;
		} else {
			document.getElementById('religiousspan').innerHTML='';
		}

	}
}

function ethnicityChk() {
	var frmProfile = this.document.frmProfile;
	if (parseInt(frmProfile.ethinicityfeature.value)==1 && parseInt(frmProfile.ethnicityOption.value)>1 ) {
		if (parseInt(frmProfile.ethnicity.options[frmProfile.ethnicity.selectedIndex].value)== 0) {
			document.getElementById('ethnicityspan').innerHTML="Select the ethnicity of the prospect";
			return false;
		} else {
			document.getElementById('ethnicityspan').innerHTML='';
		}

	}
}

function religionChk() {
	var frmProfile = this.document.frmProfile;
	if(document.getElementById('casteDivText') != null) {
	  document.getElementById('casteDivText').style.display='none';
	}
	if (parseInt(frmProfile.religionfeature.value)==1 && parseInt(frmProfile.religionOption.value)>1 ) {
		if (parseInt(frmProfile.religion.options[frmProfile.religion.selectedIndex].value)== 0) {
			document.getElementById('religionspan').innerHTML="Select the religion of the prospect";
			return;
		} else {
			var selectedReligion = parseInt(frmProfile.religion.options[frmProfile.religion.selectedIndex].value);
			if(checkValueInArray(religionWithSubcasteOptional,selectedReligion) == true)	{ 
				isSubcasteMandatory = 0;
				if(document.getElementById('subcasteMandatorySymbol') != null) {
				 document.getElementById('subcasteMandatorySymbol').innerHTML='';
				}
				document.getElementById('subcastespan').innerHTML=''; 
			} else {
				isSubcasteMandatory = 1;
				if(document.getElementById('subcasteMandatorySymbol') != null) {
				  document.getElementById('subcasteMandatorySymbol').innerHTML='*';
				}
			}
			document.getElementById('religionspan').innerHTML='';
		}

	}
}

function casteChk() {

	if (parseInt(document.frmProfile.castefeature.value)==1) {
		
	if (parseInt(document.frmProfile.casteOption.value)==1) {} else {
		
		if (parseInt(document.frmProfile.casteOption.value)>1) {
            var casteId = parseInt(document.frmProfile.caste.options[document.frmProfile.caste.selectedIndex].value);
			if (casteId == 0) {
			document.getElementById('castespan').innerHTML="Select the "+document.frmProfile.castelabel.value+" of the prospect";
			return;
			}
			else if(casteId == 9997) {
			  if (document.frmProfile.casteOthers.value=="") {
					document.getElementById('castespan').innerHTML="Enter the "+document.frmProfile.castelabel.value+" of the prospect";
					//document.frmProfile.casteOthers.focus();
					return;
			  }
			  else { document.getElementById('castespan').innerHTML=''; }
			}
			else { document.getElementById('castespan').innerHTML=''; }

		} else {

var validateSubCaste='yes';

		if((document.frmProfile.communityId.value=='2001')) {
			var religionId	= document.frmProfile.religion.options[document.frmProfile.religion.selectedIndex].value;
			if ((religionId=='8') || (religionId=='9')) { validateSubCaste = 'no'; }
		}

			if (validateSubCaste=='yes') {

				//if (IsEmpty(document.frmProfile.casteText.value,'text')) {
				  if (document.frmProfile.casteText.value == "") {
					document.getElementById('castespan').innerHTML="Enter the "+document.frmProfile.castelabel.value+" of the prospect";
					return;
				} else { document.getElementById('castespan').innerHTML=''; }

			}


		}
	}

	}



	/*if (parseInt(frmProfile.castefeature.value)==1) {
		if (parseInt(frmProfile.casteOption.value)==1) {

			if (IsEmpty(frmProfile.casteText.value,'text')) {
				document.getElementById('castespan').innerHTML="Enter the caste of the prospect";
				return;
			} else { document.getElementById('castespan').innerHTML=''; }

		} else {
			if (parseInt(frmProfile.caste.options[frmProfile.caste.selectedIndex].value)== 0) {
			document.getElementById('castespan').innerHTML="Select the caste of the prospect";
			return;
			} else { document.getElementById('castespan').innerHTML=''; }
		}

	}*/
}

function casteOthersChk(){
	var casteId =  parseInt(document.frmProfile.caste.options[document.frmProfile.caste.selectedIndex].value);
    var communityId = frmProfile.communityId.value;
	if (casteId== 9997) {
	        document.getElementById('casteDivText').style.display='block';
			if (document.frmProfile.casteOthers.value=="" && communityId != 2004) {
			document.getElementById('castespan').innerHTML="Enter the "+document.frmProfile.castelabel.value+" of the prospect";
			return;

		} else {  document.getElementById('castespan').innerHTML=""; }

	} else { document.getElementById('casteDivText').style.display='none'; }
}

/*
function subcasteChk() {
	if (parseInt(document.frmProfile.subcastefeature.value)==1) { 
		if (parseInt(document.frmProfile.subCasteOption.value)==1) { } else {
			if (parseInt(document.frmProfile.subCasteOption.value)>1) { 

				if (parseInt(document.frmProfile.subCaste.options[document.frmProfile.subCaste.selectedIndex].value)== 0) {
				document.getElementById('subcastespan').innerHTML="Select the subcaste of the prospect";
				return;
				} else { document.getElementById('subcastespan').innerHTML=''; }

			} else {

				if (document.frmProfile.subCasteText.value=="") { 
					document.getElementById('subcastespan').innerHTML="Enter the subcaste of the prospect";
					return;
				} else { document.getElementById('subcastespan').innerHTML=''; }

			}
		}
	}
}*/

function subcasteChk(){

   if(document.frmProfile.subCasteOthers != 'undefined') {
     document.frmProfile.subCasteOthers.value ='';
   }

	if (parseInt(document.frmProfile.subcastefeature.value)==1) { 
		if (parseInt(document.frmProfile.subCasteOption.value)==1) { } else {
			if (parseInt(document.frmProfile.subCasteOption.value)>1) { 
				var subCasteId = parseInt(document.frmProfile.subCaste.options[document.frmProfile.subCaste.selectedIndex].value);
				document.getElementById("subCasteDivText").style.display="none";
				if (subCasteId== 0 && (isSubcasteMandatory == 1) ) {
					document.getElementById("subCasteDivText").style.display="none";
					document.getElementById('subcastespan').innerHTML="Select the "+document.frmProfile.subcastelabel.value+" of the prospect";
					//document.frmProfile.subCaste.focus();
					return;
				} else if (subCasteId==9997) {
					document.getElementById("subCasteDivText").style.display="block";
					if (document.frmProfile.subCasteOthers.value=="" && (isSubcasteMandatory == 1)) {
						document.getElementById('subcastespan').innerHTML="Enter the "+document.frmProfile.subcastelabel.value+" of the prospect";
						//document.frmProfile.subCasteOthers.focus();
						return;
					} else { document.getElementById('subcastespan').innerHTML=''; }
				} else { document.getElementById('subcastespan').innerHTML=''; }

			} else {

				if (document.frmProfile.subCasteText.value=="" && (isSubcasteMandatory == 1)) { 
					document.getElementById('subcastespan').innerHTML="Enter the "+document.frmProfile.subcastelabel.value+" of the prospect";
					//document.frmProfile.subCasteText.focus();
					return;
				} else { document.getElementById('subcastespan').innerHTML=''; }

			}
		}
	}
}//subcasteChk


//***********************************************
var objSubCaste;
function funCaste(argCasteId){

	var casteId;
	if(document.frmProfile.casteOthers != 'undefined') {
	  document.frmProfile.casteOthers.value='';
	}
	if (document.getElementById('subCasteDivText')) {
		document.frmProfile.subCasteOthers.value='';
		document.getElementById('subCasteDivText').style.display='none';
		
	}//if

	// added by barani //
      communityId = document.frmProfile.communityId.value;
	// end by barani //

	if (argCasteId=='') {
		casteId = document.frmProfile.caste.options[document.frmProfile.caste.selectedIndex].value;
	} else { casteId = argCasteId; }

	if (casteId > 0) {

		objSubCaste = AjaxCall();
		var parameters	= "casteId="+casteId+"&communityId="+communityId+"&field=caste&rand="+Math.random();
		var stateURL	= '/register/populatecaste.php';
		objSubCaste.onreadystatechange = populateSubCasteList;
		objSubCaste.open('POST', stateURL, true);
		objSubCaste.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		objSubCaste.setRequestHeader("Content-length", parameters.length);
		objSubCaste.setRequestHeader("Connection", "close");
		objSubCaste.send(parameters);
		return objSubCaste;
	}//if
}//funCaste

function populateSubCasteList() {
	if (objSubCaste.readyState == 4 && objSubCaste.status == 200) {
		var subCasteList = objSubCaste.responseText.split('~');
		document.frmProfile.subCasteOption.value	= subCasteList[0];
		document.getElementById('subCasteDivId').innerHTML	= subCasteList[1];
	}
	funGothramChk();
}


//***************************************************************
var objCaste;
function funReligion(){

    // added by barani //
      communityId = document.frmProfile.communityId.value;
	// end by barani //

	var casteId = 0;
	var casteFeature = document.frmProfile.castefeature.value;
	var casteOption = document.frmProfile.casteOption.value;
	var religionId	= document.frmProfile.religion.options[document.frmProfile.religion.selectedIndex].value;
	var relOpt		= document.frmProfile.religionOption.value;

	if (casteOption==1) { casteId = document.frmProfile.caste.value; }

	if ((religionId=='8') || (religionId=='9')) { funSubCasteText(); }

	if (religionId=='1') { document.getElementById('gothramCommonDivId').style.display='block'; }
	else { document.getElementById('gothramCommonDivId').style.display='none'; }

	//Caste Label Changes
	if ((religionId=='2') || (religionId=='10') || (religionId=='11' ))  { document.getElementById('branchDiv').innerHTML='Sect';  } 
	else if ((religionId=='3') || (religionId=='12') || (religionId=='13' ) || (religionId=='14' )) { document.getElementById('branchDiv').innerHTML='Denomination';  } 
	else if (religionId=='7') { document.getElementById('branchDiv').innerHTML='Branch';  } 
	else { 
		if (document.getElementById('branchDiv')) { document.getElementById('branchDiv').innerHTML='Caste'; } } 

	
	if (casteFeature==1 && casteOption==1) { funCaste(casteId); } //call subcaste function...
	else {
		if (religionId > 0) {
			objCaste = AjaxCall();
			var parameters	= "religionId="+religionId+"&communityId="+communityId+"&field=religion&rand="+Math.random();
			var stateURL	= '/register/populatecaste.php';
			objCaste.onreadystatechange = populateCasteList;
			objCaste.open('POST', stateURL, true);
			objCaste.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			objCaste.setRequestHeader("Content-length", parameters.length);
			objCaste.setRequestHeader("Connection", "close");
			objCaste.send(parameters);
			return objCaste;
		}//if
	}
}//funCaste

function funDenomination(){
    
	// added by barani //
      communityId = document.frmProfile.communityId.value;
	// end by barani //

    if(document.frmProfile.denominationText != 'undefined') {
	  document.frmProfile.denominationText.value = '';
	}

    if(document.getElementById('casteDivText') != null) {
	  document.getElementById('casteDivText').style.display='none';
	}

	var casteId = 0;
	var casteFeature = document.frmProfile.castefeature.value;
	var casteOption = document.frmProfile.casteOption.value;
	var denominationId	= document.frmProfile.denomination.options[document.frmProfile.denomination.selectedIndex].value;
	var denominationOpt	= document.frmProfile.denominationOption.value;
	//document.frmProfile.casteOthers.value = "";
	//document.getElementById('casteDivText').style.display='none';
	document.frmProfile.denominationText.value = '';
	if (casteOption==1) { casteId = document.frmProfile.caste.value; }

	if (casteFeature==1 && casteOption==1) { funCaste(casteId); } //call subcaste function...
	else {
		if (denominationId > 0) {
           
		    //by barani 
            if(denominationId == 9997) {
			  document.frmProfile.denominationText.style.visibility = "visible";
			  document.getElementById('subCasteDivId').innerHTML = '<input type="text" value="" name="subCasteText" size="35" class="inputtext" tabindex="31">';
			  document.getElementById('subCasteDivText').style.display = 'none';
			}
            else {
			  document.frmProfile.denominationText.style.visibility = "hidden";
			}
           // end by barani
			objCaste = AjaxCall();
			var parameters	= "denominationId="+denominationId+"&communityId="+communityId+"&field=denomination&rand="+Math.random();
			var stateURL	= '/register/populatecaste.php';
			objCaste.onreadystatechange = populateCasteList;
			objCaste.open('POST', stateURL, true);
			objCaste.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			objCaste.setRequestHeader("Content-length", parameters.length);
			objCaste.setRequestHeader("Connection", "close");
			objCaste.send(parameters);
			return objCaste;
		}//if
	}
}//funCaste



function populateCasteList() {
	if (objCaste.readyState == 4 && objCaste.status == 200) {
		var casteList = objCaste.responseText.split('~');
		document.frmProfile.casteOption.value	= casteList[0];
		document.getElementById('casteDivId').innerHTML	= casteList[1];
	}
}

function funGothramChk(){

	var gothramFeatureId = parseInt(document.frmProfile.gothramfeature.value);
	var casteFeatureId	 = parseInt(document.frmProfile.castefeature.value);
	var casteOptionId	 = parseInt(document.frmProfile.casteOption.value);
	var casteId	= 0;

    // added by barani //
      communityId = document.frmProfile.communityId.value;
	// end by barani //

	if (gothramFeatureId==1 && casteFeatureId==1) {

		if (casteOptionId > 1) { 
			casteId = document.frmProfile.caste.options[document.frmProfile.caste.selectedIndex].value;
		}
		objGothram = AjaxCall();
		//var parameters	= "casteId="+casteId+"&rand="+Math.random();
		var parameters	= "casteId="+casteId+"&communityId="+communityId+"&rand="+Math.random();
		var gothramURL	= '/register/populategothram.php';
		objGothram.onreadystatechange = populateGothramList;
		objGothram.open('POST', gothramURL, true);
		objGothram.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		objGothram.setRequestHeader("Content-length", parameters.length);
		objGothram.setRequestHeader("Connection", "close");
		objGothram.send(parameters);
		return objGothram;


	}

}
function populateGothramList() {
	if (objGothram.readyState == 4 && objGothram.status == 200) {
		var gothramList = objGothram.responseText.split('~');
		document.frmProfile.gothramOption.value				= gothramList[0];
		if(gothramList[0]) {
			document.getElementById('gothramMandatorySymbol').innerHTML = '*';
		}
		else {
			document.getElementById('gothramMandatorySymbol').innerHTML = '';
		}
		document.getElementById('gothramMainDivId').innerHTML	= gothramList[1];
	}
}

function gothramChk() {
	if (parseInt(document.frmProfile.gothramfeature.value)==1) {
		if (parseInt(document.frmProfile.gothramOption.value)>1) {
			var gothramId = parseInt(document.frmProfile.gothram.options[document.frmProfile.gothram.selectedIndex].value);
			if (gothramId== 0) {
				document.getElementById("gothramDivText").style.display="none";
				document.getElementById('gothraspan').innerHTML="Select the gothram of the prospect";
				//document.frmProfile.gothram.focus();
				return;
			} else if (gothramId==9997) {
				document.getElementById("gothramDivText").style.display="block";
				if (document.frmProfile.gothramOthers.value=="") {
					document.getElementById('gothraspan').innerHTML="Enter the gothram of the prospect";
					//document.frmProfile.gothramOthers.focus();
					return;
				} else { document.getElementById('gothraspan').innerHTML=''; }
			} else { document.getElementById("gothramDivText").style.display="none";document.getElementById('gothraspan').innerHTML=''; }
		}
	}

}

function anycastegothramChk() {
	if (parseInt(document.frmProfile.gothramfeature.value)==1) {
		if (parseInt(document.frmProfile.gothramOption.value)>1) {
			var gothramId = parseInt(document.frmProfile.gothram.options[document.frmProfile.gothram.selectedIndex].value);
			if (gothramId==9997) {
				document.getElementById("gothramDivText").style.display="block";
				if (document.frmProfile.gothramOthers.value=="") {
					document.getElementById('gothraspan').innerHTML="Enter the gothram of the prospect";
					//document.frmProfile.gothramOthers.focus();
					return;
				} else { document.getElementById('gothraspan').innerHTML=''; }
			} else {
				document.getElementById("gothramDivText").style.display="none";document.getElementById('gothraspan').innerHTML=''; 
			}
		}
	}
}

function funSubCasteText() { // Buddhist, Inter Religion, 
        // added by barani //
        communityId = document.frmProfile.communityId.value;
	    // end by barani //

		objSubCaste = AjaxCall();
		var parameters	= "field=subCasteText&communityId="+communityId+"&rand="+Math.random();
		var stateURL	= '/register/populatecaste.php';
		objSubCaste.onreadystatechange = populateSubCasteList;
		objSubCaste.open('POST', stateURL, true);
		objSubCaste.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		objSubCaste.setRequestHeader("Content-length", parameters.length);
		objSubCaste.setRequestHeader("Connection", "close");
		objSubCaste.send(parameters);
		return objSubCaste;
}//funSubCasteText


// function written by barani on june-08-2010 //
function subCasteOthersChk(){
	var subCasteId =  parseInt(document.frmProfile.subCaste.options[document.frmProfile.subCaste.selectedIndex].value);
    
	if (subCasteId== 9997) {
			document.getElementById('subCasteDivText').style.display='block';
	} else {
		document.getElementById('subCasteDivText').style.display='none';
	}
	document.frmProfile.subCasteOthers.value='';
}

function funEditReligion(){

    // added by barani //
      communityId = document.frmProfile.communityId.value;
	// end by barani //
 
	var casteId = 0;
	var casteOption = document.frmProfile.casteOption.value;
	var religionId	= document.frmProfile.religion.options[document.frmProfile.religion.selectedIndex].value;
    

    if(checkValueInArray(religionWithSubcasteOptional,religionId) == true)	{ 
				isSubcasteMandatory = 0;
				if(document.getElementById('subcasteMandatorySymbol') != null) {
				 document.getElementById('subcasteMandatorySymbol').innerHTML='';
				}
				document.getElementById('subcastespan').innerHTML=''; 
	} else {
				isSubcasteMandatory = 1;
				if(document.getElementById('subcasteMandatorySymbol') != null) {
				 document.getElementById('subcasteMandatorySymbol').innerHTML='*';
				}
    }

	if (casteOption==1) { casteId = document.frmProfile.caste.value; }

	//if ((religionId=='8') || (religionId=='9')) { funSubCasteText(); }

	if (religionId=='1') { document.getElementById('gothramCommonDivId').style.display='block'; }
	else { document.getElementById('gothramCommonDivId').style.display='none'; }

	//Caste Label Changes
	if ((religionId=='2') || (religionId=='10') || (religionId=='11' ))  { document.getElementById('branchDiv').innerHTML='Sect';  } 
	else if ((religionId=='3') || (religionId=='12') || (religionId=='13' ) || (religionId=='14' )) { document.getElementById('branchDiv').innerHTML='Denomination';  } 
	else if (religionId=='7') { document.getElementById('branchDiv').innerHTML='Branch';  } 
	else { 
		if (document.getElementById('branchDiv')) { document.getElementById('branchDiv').innerHTML='Caste'; } } 

}//funCaste

function disableHandicappedByWar() {
  var frmProfile = this.document.frmProfile;
  var communityId = frmProfile.communityId.value;
  var PhysicalStatusCnt = frmProfile.PhysicalStatusCnt.value;
 
  if(communityId == 2006 && gender == 2) {
	for(i=0; i<PhysicalStatusCnt; i++) {
      if(frmProfile.maritalStatus.value == 2) {
		if(frmProfile.physicalStatus[i].value == 3 ){
		  frmProfile.physicalStatus[i].checked = false;
		  frmProfile.physicalStatus[i].disabled = true;
		}
	  }
	  else {
		  frmProfile.physicalStatus[i].disabled = false;
	  }
    }
  }
 
}
