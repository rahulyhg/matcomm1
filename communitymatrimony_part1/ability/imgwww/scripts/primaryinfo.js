var objAjax1=null;
var appImgsPath = varConfArr['domainimgs'];
var productname = varConfArr['productname'];
var objSubCaste;
var preverrmsg = '';
var prevemail = '';
var one_day=1000*60*60*24
var one_month=1000*60*60*24*30
var one_year=1000*60*60*24*30*12

function displayage(yr, mon, day, unit, decimal, round){
today=new Date()
var pastdate=new Date(yr, mon-1, day)

var countunit=unit
var decimals=decimal
var rounding=round

finalunit=(countunit=="days")? one_day : (countunit=="months")? one_month : one_year
decimals=(decimals<=0)? 1 : decimals*10

if (unit!="years"){
if (rounding=="rounddown")
alert (Math.floor((today.getTime()-pastdate.getTime())/(finalunit)*decimals)/decimals+' '+countunit)
else
alert (Math.ceil((today.getTime()-pastdate.getTime())/(finalunit)*decimals)/decimals+' '+countunit)
}
else
{
yearspast=today.getFullYear()-yr-1
tail=(today.getMonth()>mon-1 || today.getMonth()==mon-1 && today.getDate()>=day)? 1 : 0
pastdate.setFullYear(today.getFullYear())
pastdate2=new Date(today.getFullYear()-1, mon-1, day)
tail=(tail==1)? tail+Math.floor((today.getTime()-pastdate.getTime())/(finalunit)*decimals)/decimals : Math.floor((today.getTime()-pastdate2.getTime())/(finalunit)*decimals)/decimals
var calyear=yearspast+tail;
}
return calyear;
}

function updateDay(change,formName,yearName,monthName,dayName)
{	
	var form = document.forms[formName];
	var yearSelect = form[yearName];
	var monthSelect = form[monthName];
	var daySelect = form[dayName];
	var year = yearSelect[yearSelect.selectedIndex].value;
	var month = monthSelect[monthSelect.selectedIndex].value;
	var day = daySelect[daySelect.selectedIndex].value;

if (month>0)
{
	if (change == 'month' || (change == 'year' && month == 2))
	{
		var i = 31;
		var flag = true;
		while(flag)
		{
			var date = new Date(year,month-1,i);
			if (date.getMonth() == month - 1)
			{
				flag = false;
			}
			else
			{
				i = i - 1;
			}
		}

		daySelect.length = 0;
		daySelect.length = i;
		var jj = 1, j=0;
		daySelect[0] = new Option('-Date-','');
		while(j < i)
		{
			daySelect[jj] = new Option(j+1,j+1);
			jj = jj + 1;
			j =j+1;
		}
		if (day <= i && day!=0)
		{
			daySelect.selectedIndex = day;
		}
		else
		{
			daySelect.selectedIndex = 0;
		}
	}
}
}

function ProfileValidate(){

	var frmProfile=document.frmProfile;

	if (IsEmpty(document.frmProfile.nickname,"text")){
		 $('nicknamespan').innerHTML="Please enter the display name of the prospect";
		 frmProfile.nickname.focus();return false;
	}else{ 
		$('nicknamespan').innerHTML=""; 
	}
    
    //if(!IsEmpty(frmProfile.password,"text")) {
	 if(frmProfile.password.value) {
	  if(chkPassword() == false)
	   return false;	
	  if(chkConfirmPassword() == false)
	   return false;
	}

	/*if(IsEmpty(frmProfile.password,"text")){
		$('soldpassword').innerHTML="Please enter the old password of the prospect";
		frmProfile.password.focus();return false;
	}else{
		if(frmProfile.password.value.length<4) {
			$('soldpassword').innerHTML="Please enter the password atleast 4 characters";
			frmProfile.password.focus();return false;
		} else {
			$('soldpassword').innerHTML=""; 
		}
	}

	if($('confirmpwd').className=='disblk') {
		if(IsEmpty(frmProfile.cpassword,"text")){
			$('scpassword').innerHTML="Please enter the confirm password of the prospect";
			frmProfile.cpassword.focus();return false;
		}else{
			if(frmProfile.password.value != frmProfile.cpassword.value) {
				$('scpassword').innerHTML='New password did not match'; 
				frmProfile.cpassword.focus();return false;
			} else {
				$('scpassword').innerHTML="";
			}
		}
	}*/
  
	if(frmProfile.age.value=="" && (frmProfile.dobMonth.options[frmProfile.dobMonth.selectedIndex].text=="-Month-" && frmProfile.dobDay.options[frmProfile.dobDay.selectedIndex].text=="-Date-" && frmProfile.dobYear.options[frmProfile.dobYear.selectedIndex].text=="-Year-")) {
		$('agespan').innerHTML="Please enter the age or select the date of birth of the prospect";frmProfile.age.focus();return false;}
	else { 
		$('agespan').innerHTML=""; 
	}

	if(IsEmpty(document.frmProfile.age,"text")) { 
		if (document.frmProfile.dobMonth.options[document.frmProfile.dobMonth.selectedIndex].text=="-Month-") {
			$('agespan').innerHTML="Please select month";frmProfile.dobMonth.focus();return false;
		} else { 
			$('agespan').innerHTML=""; 
		}

		if (document.frmProfile.dobDay.options[document.frmProfile.dobDay.selectedIndex].text=="-DATE-") {
			$('agespan').innerHTML="Please select date";frmProfile.dobDay.focus();return false;
		} else {
			$('agespan').innerHTML="";
		}

		if (document.frmProfile.dobYear.value=="0")	{
			$('agespan').innerHTML="Please select year";frmProfile.dobYear.focus();return false;
		} else {
			$('agespan').innerHTML="";
		}
	}	
 
	if(!ValidateNo(frmProfile.age.value,"0123456789")){
		$('agespan').innerHTML="Please enter a valid age.";frmProfile.age.focus();return false;
	} else {
		var ageint = parseInt(frmProfile.age.value );
		if (ageint < starfmtage){
			$('agespan').innerHTML="Sorry! prospect need to be at least "+starfmtage+" if you are a woman and "+starmtage+" if you are a man to register.";
			frmProfile.age.focus();return false;
		}else{
			$('agespan').innerHTML="";
		}
		if (ageint > 70){
			$('agespan').innerHTML="Maximum age allowed is 70.";frmProfile.age.focus();return false;
		}else{
			$('agespan').innerHTML="";
		}
	}

	var calyear = displayage(frmProfile.dobYear.value,frmProfile.dobMonth.value,frmProfile.dobDay.value, 'years', 0, 'rounddown');
	if(frmProfile.oldgender.value==1){
		if((frmProfile.age.value<starmtage) && !(frmProfile.age.value=="")) {
			$('agespan').innerHTML="prospect should be "+starmtage+" years to register";frmProfile.age.focus();return false;
		}else{
			$('agespan').innerHTML="";
		}

		if(frmProfile.age.value=="" && (calyear < starmtage)){
			$('agespan').innerHTML="prospect should be "+starmtage+" years to register";frmProfile.age.focus();return false;
		}else{
			$('agespan').innerHTML="";
		}
	}
 
	if((frmProfile.age.value < starfmtage) && !(frmProfile.age.value=="")){
		$('agespan').innerHTML="prospect Should be "+starfmtage+" years to Register";frmProfile.age.focus();return false;
	}else{
		$('agespan').innerHTML="";
	}

	if(frmProfile.age.value=="" && (calyear < starfmtage) ){
		$('agespan').innerHTML="prospect should be "+starfmtage+" years to register";frmProfile.age.focus();return false;
	}else{
		$('agespan').innerHTML="";
	}

	if(frmProfile.age.value=="" && calyear > 70){
		$('agespan').innerHTML="Maximum age allowed is 70";frmProfile.age.focus();return false;
	}else{
		$('agespan').innerHTML="";
	}
	
	if(IsEmpty(document.frmProfile.email,"text")){
		$('emailspan').innerHTML="Please enter the email of the prospect";
		frmProfile.email.focus();return false;
	} else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(frmProfile.email.value))) {
		$('emailspan').innerHTML="Please enter a valid e-mail address";
		frmProfile.email.focus();return false;
	} else if(document.frmProfile.emaildup.value=='1') {
		frmProfile.email.focus();return false;
	} else {
		$('emailspan').innerHTML="";
	}

	if(!ValidateNo(document.frmProfile.countryCode.value,'1234567890')) {
     document.frmProfile.countryCode.value="ISD";
    }
    if(!ValidateNo(document.frmProfile.areaCode.value,'1234567890')) {
     document.frmProfile.areaCode.value="STD";
    }
    if(!ValidateNo(document.frmProfile.phoneNo.value,'1234567890')) {
     document.frmProfile.phoneNo.value="Telephone number";
    }
    if(!ValidateNo(document.frmProfile.mobileNo.value,'1234567890')) {
     document.frmProfile.mobileNo.value="Mobile number";
    }

	//Phone validation
	if(document.frmProfile.countryCode.value=='' && document.frmProfile.areaCode.value=='STD' && document.frmProfile.phoneNo.value=='Telephone number' && document.frmProfile.mobileNo.value=='Mobile number') {
		$('phonespan').innerHTML="Enter the phone or mobile number";
		document.frmProfile.phoneNo.focus();
		return false; 
	} else {$('phonespan').innerHTML="";}

	if(IsEmpty(document.frmProfile.countryCode,'text') && IsEmpty(document.frmProfile.areaCode,'text') && IsEmpty(document.frmProfile.phoneNo,'text') && IsEmpty(document.frmProfile.mobileNo,'text')) {
		$('phonespan').innerHTML="Enter the phone or mobile number";
		document.frmProfile.phoneNo.focus();
		return false; 
	} else {$('phonespan').innerHTML="";}

	if ((IsEmpty(document.frmProfile.phoneNo,'text') || document.frmProfile.phoneNo.value=='Telephone number') && (IsEmpty(document.frmProfile.mobileNo,'text') || document.frmProfile.mobileNo.value=='Mobile number')) {
		$('phonespan').innerHTML="Enter the contact number";
		document.frmProfile.phoneNo.focus();
		return false;
	} else {$('phonespan').innerHTML="";}

	if (!(IsEmpty(document.frmProfile.countryCode,'text'))) {
		if (!ValidateNo(document.frmProfile.countryCode.value,'1234567890')) {
			$('phonespan').innerHTML="Enter a valid country code";
			document.frmProfile.countryCode.focus();
			return false;
		} else {$('phonespan').innerHTML="";}
	}

	if ((!IsEmpty(document.frmProfile.phoneNo,'text')) && document.frmProfile.phoneNo.value!='Telephone number') {
		if (IsEmpty(document.frmProfile.countryCode,'text')) {
			$('phonespan').innerHTML="Enter the country code";
			document.frmProfile.countryCode.focus();
			return false;
		} else {$('phonespan').innerHTML="";}
				
		if(IsEmpty(document.frmProfile.areaCode,'text') || document.frmProfile.areaCode.value=='STD') {
			$('phonespan').innerHTML="Enter area / STD code";
			document.frmProfile.areaCode.focus();
			return false;
		} else { $('phonespan').innerHTML="";}

		if (!(IsEmpty(document.frmProfile.areaCode,'text'))) {
			if (!ValidateNo(document.frmProfile.areaCode.value,'1234567890')) {
				$('phonespan').innerHTML="Enter a valid area code";
				document.frmProfile.areaCode.focus();
				return false;
			} else {$('phonespan').innerHTML="";}
		}

		if (!(IsEmpty(document.frmProfile.phoneNo,'text'))) {
			if (!ValidateNo(document.frmProfile.phoneNo.value,'1234567890')) {
				$('phonespan').innerHTML="Enter a valid phone number";
				document.frmProfile.phoneNo.focus();
				return false;
			} else {$('phonespan').innerHTML="";}
		}
	}

	if ((!IsEmpty(document.frmProfile.mobileNo,'text')) || document.frmProfile.mobileNo.value!='Mobile number') {
		if (IsEmpty(document.frmProfile.countryCode,'text')) {
			$('phonespan').innerHTML="Enter the country code";
			document.frmProfile.countryCode.focus();
			return false;
		} else {$('phonespan').innerHTML="";}

		if (!(IsEmpty(document.frmProfile.mobileNo,'text')) && document.frmProfile.mobileNo.value!='Mobile number') {
			if (!ValidateNo(document.frmProfile.mobileNo.value,'1234567890')) {
				$('phonespan').innerHTML="Enter a valid mobile number";
				document.frmProfile.mobileNo.focus();
				return false;
			} else {$('phonespan').innerHTML="";}
		}
	}

	return true;
}


/*function chkPassword() {
	var frmProfile=document.frmProfile;
	if(IsEmpty(frmProfile.password,"text")){
		$('soldpassword').innerHTML="Please enter the old password of the prospect";
		frmProfile.password.focus();return false;
	}else{
		if(frmProfile.password.value.length<4) {
			$('soldpassword').innerHTML="Please enter the password atleast 4 characters";
			frmProfile.password.focus();return false;
		} else if(frmProfile.password.value != frmProfile.oldpassword.value) {
			$('confirmpwd').className='disblk';
			frmProfile.cpassword.focus();
		} else {
			$('confirmpwd').className="disnon";
		}
		$('soldpassword').innerHTML=""; 
	}
}*/

function chkPassword() {
	var frmProfile=document.frmProfile;
	if(IsEmpty(frmProfile.password,"text")){
		$('soldpassword').innerHTML="Please enter the new password of the prospect";
		return false;
	}else{
		pass_val = frmProfile.password.value;
        goodPasswd = 1;
		for ( var idx=0; idx< pass_val.length; idx++ ) {
		ch = pass_val.charAt(idx);
		if (( !((ch>='a') && (ch<='z')) && !((ch>='A') && (ch<='Z')) && !((ch>=0) && (ch <=9)) ) || (ch==' '))
			{goodPasswd = 0;break;}
		}
		if (pass_val.length<4)
		{$('soldpassword').innerHTML = "Your password must have a minimum of 4 characters.";return false;}
		else if(pass_val.toUpperCase()==frmProfile.name.value.toUpperCase())
		{$('soldpassword').innerHTML="The name and password cannot be the same. Please change the password.";return false;}
		else if ( goodPasswd ==0 ) 
		{$('soldpassword').innerHTML="Spaces or special characters are not allowed in the password.";return false;}
		else if(pass_val=='123456')
		{$('soldpassword').innerHTML="Sorry, your password has been rejected.It is recommended that you submit a password with alphanumeric characters.";return false;}
		else{$('soldpassword').innerHTML="";}

	}
}

function showConfirmPassword() {
	$('confirmpwd').className='disblk';
}
function chkConfirmPassword() {
	var frmProfile=document.frmProfile;
	if(IsEmpty(frmProfile.cpassword,"text")){
		$('scpassword').innerHTML="Please enter the confirm password of the prospect";
		//frmProfile.cpassword.focus();
		return false;
	}else{
		if(frmProfile.password.value != frmProfile.cpassword.value) {
			$('scpassword').innerHTML='New password did not match';
			//frmProfile.cpassword.focus();
			return false;
		} else {
			$('scpassword').innerHTML="";
		}
	}
}

function agefocus(){
  var frmProfile=document.frmProfile;
  if(document.frmProfile.age.value!=""){
		if(!(document.frmProfile.dobYear.value=="0") || !(document.frmProfile.dobMonth.value=="") || !(document.frmProfile.dobDay.value==""))
		{document.frmProfile.dobMonth.value=""; document.frmProfile.dobDay.value=""; document.frmProfile.dobYear.value="0";}
	}
}

function agesel(){
  document.frmProfile.age.value="";$('agespan').innerHTML="";
}

function emailChk() {
	var frmProfile = this.document.frmProfile;
	// Check E-mail
	if (IsEmpty(frmProfile.email,"text")) {
		$('emailspan').innerHTML="Please enter the email of the prospect";
		frmProfile.email.focus();
		return false;
	} else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(frmProfile.email.value))) {
		$('emailspan').innerHTML="Please enter a valid e-mail address";
		frmProfile.email.focus();
		return false;
	} else {
		var evalue = frmProfile.email.value;
		if(prevemail != evalue) {
			prevemail = evalue;
			makerequestEmailCheck(evalue);
		}
	}
}

function makerequestEmailCheck(evalue) {
	var urltoget = "../register/checkemail.php?varemail="+evalue+"&rand="+Math.random();

	 email_request = AjaxCall();
	  if (email_request)
	  {
		email_request.open("GET", urltoget, true);
		email_request.onreadystatechange = processResponseEmailCheck;
		email_request.send(null);
	  }
}


function processResponseEmailCheck() 
{
  if (email_request.readyState == 4)
  {
	var msg=0;	
	 msg = email_request.responseText;
	 arrMsg = msg.split('^');
		if(arrMsg[0] == 'yes')
		{
			$("emailspan").innerHTML="Email ID exists in the blocked E-mail list. Your computer IP address has been logged.";
			document.frmProfile.emaildup.value=1;
			document.frmProfile.email.focus();
		}
		else if(arrMsg[0] > 0)
		{
			$("emailspan").innerHTML="You have already registered on "+productname+".com using the same e-mail ID.";
			document.frmProfile.emaildup.value=1;
			document.frmProfile.email.focus();
			
		}
		else
		{
			document.frmProfile.emaildup.value=0;
			$("emailspan").innerHTML="";
		}
	} else {
		$("emailspan").innerHTML="<img src='"+appImgsPath+"/loading-icon.gif' />"; 
	}
}

var ajaxobj=false;
function twitterupdate(matriid)
{
	var argurl='/profiledetail/twitter_req.php';
	ajaxobj=AjaxCall();
	var postval = "matriid="+matriid+"&twitterid="+document.frmProfile.twitterid.value+"&updatetw=yes";
	AjaxPostReq(argurl,postval,twitfunc,ajaxobj);
}

function twitfunc()
{
	document.getElementById('twitdiv').style.display="block";
	document.getElementById('twitdiv').innerHTML = "<img src='http://img.communitymatrimony.com/images/loading-icon.gif' />";
	if(ajaxobj.readyState==4){
		if(ajaxobj.status==200){
			if(ajaxobj.responseText == '0') {
				document.getElementById('twitdiv').innerHTML='Server busy. Try again later';
			} else {
				eval("vari="+ajaxobj.responseText);
				if(vari['status'] == true) {
					document.getElementById('twitdiv').innerHTML="Your Twitter updates are currently under validation and will be added to your matrimony profile once the validation is complete.";
				} else {
					document.getElementById('twitdiv').innerHTML=vari['Error'];
				}
			}
		}else{document.getElementById('twitdiv').innerHTML='There was a problem with the request.';}
	}
}

function gettwitter(matriid)
{
	var argurl='/profiledetail/twitter_req.php';
	ajaxobj=AjaxCall();
	var postval = "matriid="+matriid+"&gettacc=yes";
	AjaxPostReq(argurl,postval,gettwitidfunc,ajaxobj);
}

function gettwitidfunc()
{
	if(ajaxobj.readyState==4){
		if(ajaxobj.status==200){
			eval("vari="+ajaxobj.responseText);
			if(vari['status'] == true) {
				document.getElementById('twitterid').value=vari['twitterId'];
			} else {
				document.getElementById('twitterid').value="";
			}
		}
	}
}

function phonehide(phnst) {
	if(phnst=='u') {
		$('rsltdiv').innerHTML	= '';
		$('rsltdiv').className	= 'disnon';
		$('uhphone').className	= 'disblk';
		$('hphone').className	= 'disnon';
	} else {
		$('rsltdiv').innerHTML	= '';
		$('rsltdiv').className	= 'disnon';
		$('hphone').className	= 'disblk';
		$('uhphone').className	= 'disnon';
	}
}

function phoneprotect(phnval) {
	objAjax1	= AjaxCall();
	parameters	= 'phnval='+phnval;
	var argUrl	= ser_url+'/phone/phoneprotect.php?ph='+Math.random();
	AjaxPostReq(argUrl,parameters,phnProtectResDiv,objAjax1); 
}

function phnProtectResDiv() {
	if (objAjax1.readyState == 4) {
		if (objAjax1.status == 200) {
			$('hphone').className	= "disnon";
			$('uhphone').className	= "disnon";
			$('rsltdiv').className	= 'disblk';
			$('rsltdiv').innerHTML	= objAjax1.responseText;
		} else {
			alert('There was a problem with the request.');
		}
	}
}

function phhidelnkswap(phhidestatus) {
	hide_box_div("alrtdiv");
	if(phhidestatus==1) {
		$('phhide').className	= "fleft disblk";
		$('phunhide').className	= "fleft disnon";
	} else {
		$('phhide').className	= "fleft disnon";
		$('phunhide').className	= "fleft disblk";
	}
}
