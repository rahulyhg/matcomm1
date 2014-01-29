function citizen(){
  var frmProfile = document.frmProfile;
  if(frmProfile.citizenship.value==frmProfile.country.value)
  {frmProfile.residentStatus.value=1;frmProfile.residentStatus.disabled=true;}
  else
  {frmProfile.residentStatus.value=0;frmProfile.residentStatus.disabled=false;}
}

function countryChk() {
	 var frmProfile = document.frmProfile;
	if ( parseInt( frmProfile.country.options[frmProfile.country.selectedIndex].value ) == 0 || frmProfile.country.options[frmProfile.country.selectedIndex].value=="" ) {
		$('loccountry').innerHTML="Please select the country of living of the prospect";
		return;
	} else {
		$('loccountry').innerHTML="";
		modifystate(frmProfile.country.value);
	}
}

var state_request = false;
function modifystate(cval)
{	
	if(cval>0 && cval!=null) {
		state_request = AjaxCall();
		var url="../profiledetail/getstates.php?countryid="+cval; //Mano
		state_request.onreadystatechange = processResponseState;
		state_request.open('GET', url, true);
		state_request.send(null);
	} else {}
}
function processResponseState()
{
	if (state_request.readyState == 4) {
		if (state_request.status == 200) {
			$("statecitydiv").innerHTML = '';
			$("statecitydiv").innerHTML = state_request.responseText;
		}
	}
}

function LocationValidate(){
  var frmProfile = document.frmProfile;
  
  var cntry = frmProfile.country.value;var citizn = frmProfile.citizenship.value;
  if(frmProfile.country.selectedIndex == 0){
    $('loccountry').innerHTML="Please select the country of living of the prospect";frmProfile.country.focus();return false;
  }else{$('loccountry').innerHTML="";}
  if(frmProfile.citizenship.selectedIndex == 0){
    $('loccitizenship').innerHTML="Please select the citizenship of the prospect";frmProfile.citizenship.focus();return false;
  }else{$('loccitizenship').innerHTML="";}
  if (cntry == citizn){frmProfile.residentStatus.disabled = true;
  }else{
    if(frmProfile.residentStatus.selectedIndex == 0 ){
      $('locresident').innerHTML="Please select the resident status of the prospect";frmProfile.residentStatus.focus();
      $('locresidingcity').innerHTML="";
      return false;
    }else {$('locresident').innerHTML="";}
  }
 
	if(cntry == 98 || cntry == 222) {
	  if(frmProfile.residingState.selectedIndex == 0 ){
		$('locresidingstate').innerHTML="Please select the resident state of the prospect";frmProfile.residingState.focus();
		return false;
	  }else{$('locresidingstate').innerHTML="";}
	} else {
		 if(frmProfile.residingState.value == '' ){
			$('locresidingstate').innerHTML="Please enter the resident state of the prospect";frmProfile.residingState.focus();
			return false;
		  }else{$('locresidingstate').innerHTML="";}
	}

	if(cntry == 98) {
		  if(frmProfile.residingCity.selectedIndex == 0 ){
			$('locresidingcity').innerHTML="Please select the residing city of the prospect";frmProfile.residingCity.focus();
			return false;
		  }else{$('locresidingcity').innerHTML="";}
	} else {
		if(frmProfile.residingCity.value == '' ){
			$('locresidingcity').innerHTML="Please enter the residing city of the prospect";frmProfile.residingCity.focus();
			return false;
		  }else{$('locresidingcity').innerHTML="";}
	}
	return true;
}

var ccode_request = false;
function modrequestnew(cvalue)
{	
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
function emptyCitySel()
{
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
function processResponsenew()
{
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