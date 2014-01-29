function funGenerateHoroscope() {

	var frmName = document.generateHoroscope;

	var month1 = frmName.month.options[frmName.month.selectedIndex].value;
	var date1 = frmName.date.options[frmName.date.selectedIndex].value;
	var year1 = frmName.year.options[frmName.year.selectedIndex].value;

	var hours1 = frmName.hours.options[frmName.hours.selectedIndex].value;
	var mins1 = frmName.mins.options[frmName.mins.selectedIndex].value;
	var meridiem1 = frmName.meridiem.options[frmName.meridiem.selectedIndex].value;
	var country1 = frmName.country.options[frmName.country.selectedIndex].value;
	var state1 = document.generateHoroscope.state.options[document.generateHoroscope.state.selectedIndex].value;
	var city1 = document.generateHoroscope.city.options[document.generateHoroscope.city.selectedIndex].value;

	if(month1=='0') {
		$('dobspan').innerHTML='&nbsp;&nbsp;Please select the month of birth';
		frmName.month.focus();
		return false;
	} else { $('dobspan').innerHTML=''; }

	if(date1=='0') {
		$('dobspan').innerHTML='&nbsp;&nbsp;Please select the day of birth';
		frmName.date.focus();
		return false;
	} else { $('dobspan').innerHTML=''; }

	if(year1=='0') {
		$('dobspan').innerHTML='&nbsp;&nbsp;Please select the year of birth';
		frmName.year.focus();
		return false;
	} else { $('dobspan').innerHTML=''; }

	if(hours1=='0') {
		$('timeofbirthspan').innerHTML='&nbsp;&nbsp;Please select the hour of birth';
		frmName.hours.focus();
		return false;
	} else { $('timeofbirthspan').innerHTML=''; }

	if(mins1=='') {
		$('timeofbirthspan').innerHTML='&nbsp;&nbsp;Please select the minutes';
		frmName.mins.focus();
		return false;
	} else { $('timeofbirthspan').innerHTML=''; }

	if(meridiem1=='0') {
		$('timeofbirthspan').innerHTML='&nbsp;&nbsp;Please select AM/PM';
		frmName.meridiem.focus();
		return false;
	} else { $('timeofbirthspan').innerHTML=''; }

	if(country1=='0') {
		$('countryspan').innerHTML='&nbsp;&nbsp;Please select the country of birth';
		frmName.country.focus();
		return false;
	} else { $('countryspan').innerHTML=''; }


	if(state1=='0') {
		$('statespan').innerHTML='&nbsp;&nbsp;Please select the state of birth';
		frmName.state.focus();
		return false;
	} else { $('statespan').innerHTML=''; }

	if(city1=='0') {
		$('cityspan').innerHTML='&nbsp;&nbsp;Please select the city of birth';
		frmName.city.focus();
		return false;
	} else { $('cityspan').innerHTML=''; }
	document.generateHoroscope.submit();
}

function funGenerateHoroChk() {

	var frmName = document.generateHoroscope;

	var month1 = frmName.month.options[frmName.month.selectedIndex].value;
	var date1 = frmName.date.options[frmName.date.selectedIndex].value;
	var year1 = frmName.year.options[frmName.year.selectedIndex].value;

	var hours1 = frmName.hours.options[frmName.hours.selectedIndex].value;
	var mins1 = frmName.mins.options[frmName.mins.selectedIndex].value;
	var meridiem1 = frmName.meridiem.options[frmName.meridiem.selectedIndex].value;
	var country1 = frmName.country.options[frmName.country.selectedIndex].value;
	var state1 = document.generateHoroscope.state.options[document.generateHoroscope.state.selectedIndex].value;
	var city1 = document.generateHoroscope.city.options[document.generateHoroscope.city.selectedIndex].value;

	if(month1=='0') { $('dobspan').innerHTML='&nbsp;&nbsp;Please select the month of birth'; return false; } else { $('dobspan').innerHTML=''; }

	if(date1=='0') {
		$('dobspan').innerHTML='&nbsp;&nbsp;Please select the day of birth';
		return false;
	} else { $('dobspan').innerHTML=''; }

	if(year1=='0') {
		$('dobspan').innerHTML='&nbsp;&nbsp;Please select the year of birth';
		return false;
	} else { $('dobspan').innerHTML=''; }

	if(hours1=='0') {
		$('timeofbirthspan').innerHTML='&nbsp;&nbsp;Please select the hour of birth';
		return false;
	} else { $('timeofbirthspan').innerHTML=''; }

	if(mins1=='') {
		$('timeofbirthspan').innerHTML='&nbsp;&nbsp;Please select the minutes';
		return false;
	} else { $('timeofbirthspan').innerHTML=''; }

	if(meridiem1=='0') {
		$('timeofbirthspan').innerHTML='&nbsp;&nbsp;Please select AM/PM';
		return false;
	} else { $('timeofbirthspan').innerHTML=''; }

	if(country1=='0') {
		$('countryspan').innerHTML='&nbsp;&nbsp;Please select the country of birth';
		return false;
	} else { $('countryspan').innerHTML=''; }


	if(state1=='0') {
		$('statespan').innerHTML='&nbsp;&nbsp;Please select the state of birth';
		return false;
	} else { $('statespan').innerHTML=''; }

	if(city1=='0') {
		$('cityspan').innerHTML='&nbsp;&nbsp;Please select the city of birth';
		return false;
	} else { $('cityspan').innerHTML=''; }
}

function funValidateHoroscope() {
	var frmName=document.frmHoroscopeUpload;
	$('horoscopeuploadspan').innerHTML='';
	if((frmName.horoscopeupload.value).replace(' /\s+/','')=="") {
		$('horoscopeuploadspan').innerHTML='Please select horoscope file';
		frmName.horoscopeupload.focus();
		return false;
	} else { $('horoscopeuploadspan').innerHTML=''; }
	var file=frmName.horoscopeupload.value.split(".");
	var fileext=(file.length>1)?(file[1].toLowerCase()).replace(' /\s+/',''):'';
	if((file.length>1)&&(fileext=="gif"||fileext=='jpg'||fileext=='jpeg')) {
		$('horoscopeuploadspan').innerHTML='';
	} else {
		$('horoscopeuploadspan').innerHTML='Please upload your horoscope in gif, jpg or jpeg format only.';
		frmName.horoscopeupload.focus();
		return false;
	}
	frmName.submit();
	return true;
}

function funProtectHoroscope() {
	var horoscopeProtect	= this.document.protectHoroscope;  	
	var horoscopeAvailable	= horoscopeProtect.horoscopeAvailable.value;
	if (horoscopeAvailable=='0') {
			$('hormsgdiv').style.display='block';
			$('horoconmsg').innerHTML = "you can protect your horoscope only after it is uploaded & validated.";
	} else {
			$('hormsgdiv').style.display='none';
		if ( horoscopeProtect.horoscopepwd.value == "" )	{
			$('horopwdspan').innerHTML = "Please enter the horoscope password";
			horoscopeProtect.horoscopepwd.focus();
			return false;
		} else { $('horopwdspan').innerHTML = '';  }

		if ( horoscopeProtect.horoscopeconfpwd.value == "" )	{
			$('horoconpwdspan').innerHTML = "Please enter the confirm horoscope password";
			horoscopeProtect.horoscopeconfpwd.focus();
			return false;
		}  else { $('horoconpwdspan').innerHTML = '';  }

		if ( horoscopeProtect.horoscopepwd.value != horoscopeProtect.horoscopeconfpwd.value )	{
			$('horoconpwdspan').innerHTML = "The horoscope password and confirm password did not match";
			horoscopeProtect.horoscopeconfpwd.focus();
			return false;
		} else { $('horoconpwdspan').innerHTML = '';  }  
		url= "protecthoroscope.php?";
		pass = horoscopeProtect.horoscopepwd.value;
		var poststr = "password=" + encodeURI(pass)+"&Submit=yes";
		MakePostRequest(url,poststr,alertChangePass);

	}
}

function funUnProtectHoroscope() {
	url= "protecthoroscope.php?";
	var poststr = "Submit=protect";
	MakePostRequest(url,poststr,alertChangePass);
}


function funProtectPwdChk() { 
	var horoscopeProtect	= this.document.protectHoroscope;  	
	var horoscopeAvailable	= horoscopeProtect.horoscopeAvailable.value;
	if (horoscopeAvailable=='0') {
			$('hormsgdiv').style.display='block';
			$('horoconmsg').innerHTML = "you can protect your horoscope only after it is uploaded & validated.";
			return false;
	} else {
			$('hormsgdiv').style.display='none';
		if ( horoscopeProtect.horoscopepwd.value == "" )	{
			$('horopwdspan').innerHTML = "Please enter the horoscope password";
			return false;
		} else { $('horopwdspan').innerHTML = '';  }

		if ( horoscopeProtect.horoscopepwd.value != horoscopeProtect.horoscopeconfpwd.value )	{
			$('horoconpwdspan').innerHTML = "The horoscope password and confirm password did not match";
			return false;
		} else { $('horoconpwdspan').innerHTML = '';  }  

	}
}

function funProtectConfPwdChk() {
	var horoscopeProtect	= this.document.protectHoroscope;  	
	var horoscopeAvailable	= horoscopeProtect.horoscopeAvailable.value;
	if (horoscopeAvailable=='0') {
			$('hormsgdiv').style.display='block';
			$('horoconmsg').innerHTML = "you can protect your horoscope only after it is uploaded & validated.";
			return false;
	} else {
			$('hormsgdiv').style.display='none';

		if ( horoscopeProtect.horoscopeconfpwd.value == "" )	{
			$('horoconpwdspan').innerHTML = "Please enter the confirm horoscope password";
			return false;
		}  else { $('horoconpwdspan').innerHTML = '';  }

		if ( horoscopeProtect.horoscopepwd.value != horoscopeProtect.horoscopeconfpwd.value )	{
			$('horoconpwdspan').innerHTML = "The horoscope password and confirm password did not match";
			return false;
		} else { $('horoconpwdspan').innerHTML = '';  }  

	}
}

function MakePostRequest(url,parameters,functionname){
	 var objHoroscope = AjaxCall();
	 eval("objHoroscope.onreadystatechange = "+functionname+";");
	 objHoroscope.open('POST', url, true);
	 objHoroscope.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 objHoroscope.setRequestHeader("Content-length", parameters.length);
	 objHoroscope.setRequestHeader("Connection", "close");
	 objHoroscope.send(parameters);
	 return objHoroscope;
}

function alertChangePass () {
	if (objHoroscope.readyState == 4) {
		if (objHoroscope.status == 200) {
			$('hormsgdiv').style.display='block';
			$('horoconmsg').innerHTML=objHoroscope.responseText;
		}
	}
}
//##################### Generate Horoscope...
//function generateHoroPostRequest(url,functionname){
var objHoroState;
function generateStateList(){
	objHoroState = AjaxCall();
	var country		= document.generateHoroscope.country.options[document.generateHoroscope.country.selectedIndex].value;
	var state		= 0;
	document.generateHoroscope.city.value=0;

	var parameters	= "country="+country+"&state="+state+"&rand="+Math.random();
	var stateURL	= '/horoscope/statecity.php';

	//eval("objHoroState.onreadystatechange = "+functionname+";");
	objHoroState.onreadystatechange = populateStateList;
	objHoroState.open('POST', stateURL, true);
	objHoroState.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	objHoroState.setRequestHeader("Content-length", parameters.length);
	objHoroState.setRequestHeader("Connection", "close");
	objHoroState.send(parameters);
	return objHoroState;
}

function populateStateList() { 
	if (objHoroState.readyState == 4 && objHoroState.status == 200) {
		$('stateList').innerHTML	= objHoroState.responseText;

		if (document.generateHoroscope.edit.value=='yes') { generateCityList(); }
		
	}
}

var objHoroCity;
function generateCityList(){
	objHoroCity = AjaxCall();
	var country		= document.generateHoroscope.country.options[document.generateHoroscope.country.selectedIndex].value;
	var state		= document.generateHoroscope.state.options[document.generateHoroscope.state.selectedIndex].value;
	var parameters	= "country="+country+"&state="+state+"&rand="+Math.random();
	var stateURL	= '/horoscope/statecity.php';

	objHoroCity.onreadystatechange = populateCityList;
	objHoroCity.open('POST', stateURL, true);
	objHoroCity.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	objHoroCity.setRequestHeader("Content-length", parameters.length);
	objHoroCity.setRequestHeader("Connection", "close");
	objHoroCity.send(parameters);
	return objHoroCity;
}


function populateCityList() {
	if (objHoroCity.readyState == 4 && objHoroCity.status == 200) {
		$('cityList').innerHTML	= objHoroCity.responseText;
	}
}

//=================================================================================================================
function viewHoros(argId){
	window.open('/horoscope/viewhoroscope.php?ID='+argId,'mywindow1','location=0,status=0,scrollbars=yes,toolbar=0,menubar=0,resizable=0,width=720,height=600');
}


function nextPage(url){ document.location.href=url; }

function deleteHoro() { if (confirm('Are you sure you want to delete your horoscope')){ document.location.href="/horoscope/?myact=HWKASGL23"; } }

function changePassword(){ document.protectHoroscope.submit(); }