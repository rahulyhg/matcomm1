function chkOthOccupation() {
	var frmProfile = document.frmProfile;
	if(frmProfile.occupation.value==0 && (frmProfile.occupationCategory[0].checked)  || (frmProfile.occupationCategory[1].checked) || (frmProfile.occupationCategory[3].checked)){
		if(frmProfile.occupationInDetail.value == '') {
			$('otheroccupation').innerHTML="Please enter occupation in detail";frmProfile.occupationInDetail.focus();return false;
		  }else {$('otheroccupation').innerHTML="";}
	}
}

function chkIncomeDet() {
	var frmProfile = document.frmProfile;
	if(frmProfile.annualIncomeCurrency.selectedIndex!=0){
		 if(frmProfile.annualIncome.value == '') {
			$('income').innerHTML="Please enter annual income amount";frmProfile.annualIncome.focus();return false;
		  }else {$('income').innerHTML="";}
	}
}

function occDependencyChk() { 
	var frmProfile = document.frmProfile;
	if(frmProfile.occupationInDetail.disabled == true) {frmProfile.occupationInDetail.disabled=false;}
	if(frmProfile.annualIncomeCurrency.disabled == true) {frmProfile.annualIncomeCurrency.disabled=false;}
	if(frmProfile.annualIncome.disabled == true) {frmProfile.annualIncome.disabled=false;}
	if(frmProfile.occupation.disabled == true) {frmProfile.occupation.disabled=false;}
	modifyoccupation(1,frmProfile.oldOccupation.value); //1 means govt, private
}

function occBusinessChk() { 
	var frmProfile = document.frmProfile;
	if(frmProfile.occupationInDetail.disabled == true) {frmProfile.occupationInDetail.disabled=false;}
	if(frmProfile.annualIncomeCurrency.disabled == true) {frmProfile.annualIncomeCurrency.disabled=false;}
	if(frmProfile.annualIncome.disabled == true) {frmProfile.annualIncome.disabled=false;}
	if(frmProfile.occupation.disabled == false) {frmProfile.occupation.disabled=true;}
}

function occDefenceChk() { 
	var frmProfile = document.frmProfile;
	if(frmProfile.occupationInDetail.disabled == true) {frmProfile.occupationInDetail.disabled=false;}
	if(frmProfile.annualIncomeCurrency.disabled == true) {frmProfile.annualIncomeCurrency.disabled=false;}
	if(frmProfile.annualIncome.disabled == true) {frmProfile.annualIncome.disabled=false;}
	if(frmProfile.occupation.disabled == true) {frmProfile.occupation.disabled=false;}
	modifyoccupation(2,frmProfile.oldOccupation.value); //2 means defence
}

function notWorkChk() {
	var frmProfile = document.frmProfile;
	if(frmProfile.occupationInDetail.disabled == false) {frmProfile.occupationInDetail.disabled=true;}
	if(frmProfile.annualIncomeCurrency.disabled == false) {frmProfile.annualIncomeCurrency.disabled=true;}
	if(frmProfile.annualIncome.disabled == false) {frmProfile.annualIncome.disabled=true;}
	if(frmProfile.occupation.disabled == false) {frmProfile.occupation.disabled=true;}
	frmProfile.occupationInDetail.value = '';
	frmProfile.annualIncomeCurrency.selectedIndex = 0;
	frmProfile.annualIncome.value = '';
}

function employedInChk() {
	var frmProfile = document.frmProfile;
	var selectedvalue = getSelectedRadioValue(frmProfile.occupationCategory);
	if(selectedvalue == 1 || selectedvalue == 3) {
		occDependencyChk();
	} else if(selectedvalue == 4) {
		occBusinessChk();
	} else if(selectedvalue == 2) {
		occDefenceChk();
	}  else if(selectedvalue == 5) {
		notWorkChk();
	}
}

var occupation_request = false;
function modifyoccupation(cval,selectedOcc) {	
	if(cval>0 && cval!=null) {
		occupation_request = AjaxCall();
		var url="../profiledetail/getoccupation.php?occupationid="+cval+"&selOcc="+selectedOcc; //Mano
		occupation_request.onreadystatechange = processResponse;
		occupation_request.open('GET', url, true);
		occupation_request.send(null);
	} else {}
}

function processResponse() {
	if (occupation_request.readyState == 4) {
		if (occupation_request.status == 200) {
			$("occdiv").innerHTML = '';
			$("occdiv").innerHTML = occupation_request.responseText;
		}
	}
}

function EducationValidate(){
  var frmProfile = document.frmProfile;
  if(frmProfile.educationCategory.selectedIndex==0){
    $('education').innerHTML="Please select the Education of the prospect";frmProfile.educationCategory.focus();return false;
  }else {$('education').innerHTML="";}

  if(!frmProfile.occupationCategory[0].checked && !frmProfile.occupationCategory[1].checked && !frmProfile.occupationCategory[2].checked && !frmProfile.occupationCategory[3].checked && !frmProfile.occupationCategory[4].checked){
      $('occupationCategoryid').innerHTML="Please select the Employment Status of the prospect";frmProfile.occupationCategory[0].focus();
      return false;
    }else {$('occupationCategoryid').innerHTML="";}
  if(frmProfile.occupationCategory[2].checked){
	  frmProfile.occupation.disabled=true;
	if(!(IsEmpty(frmProfile.annualIncome,'text'))){
        if(!ValidateNo(frmProfile.annualIncome.value,'1234567890., ')){
          $('income').innerHTML="Please enter Valid Income of the prospect";frmProfile.annualIncome.focus();return false;
        }else{$('income').innerHTML="";}
      }
  }else if((frmProfile.occupationCategory[0].checked)  || (frmProfile.occupationCategory[1].checked) || (frmProfile.occupationCategory[3].checked)){

	frmProfile.occupation.disabled=false;
		
    if(frmProfile.occupation.selectedIndex==0){
      $('occupationid').innerHTML="Please select the Occupation of the prospect";frmProfile.occupation.focus();return false;
    }else{$('occupationid').innerHTML="";}
	
	if(frmProfile.occupation.value==0){
		if(frmProfile.occupationInDetail.value == '') {
			$('otheroccupation').innerHTML="Please enter occupation in detail";frmProfile.occupationInDetail.focus();return false;
		  }else {$('otheroccupation').innerHTML="";}
	}
    if(!(IsEmpty(frmProfile.annualIncome,'text'))){
      if(frmProfile.annualIncomeCurrency.selectedIndex==0){
        $('income').innerHTML="Please first select the currency and then enter the annual income of the prospect.";frmProfile.annualIncome.focus();return false;
      }else{$('income').innerHTML="";}
      if(!ValidateNo(frmProfile.annualIncome.value,'1234567890,. ')){
        $('income').innerHTML="Please enter valid Income of the prospect";frmProfile.annualIncome.focus();return false;
      }else {$('income').innerHTML="";}
    }
  }

  if(frmProfile.annualIncomeCurrency.selectedIndex!=0){
	  if(frmProfile.annualIncome.value == '') {
		$('income').innerHTML="Please enter annual income amount";frmProfile.annualIncome.focus();return false;
	  }else {$('income').innerHTML="";}
  }
  return true;
}