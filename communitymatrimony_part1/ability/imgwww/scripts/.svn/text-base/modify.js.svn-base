function ValidateDesc(){
	var frmProfile=document.frmProfile;
	if(descvalidate()==true){
		frmProfile.action = 'aboutmedesc.php?edit=3';
		frmProfile.submit();
	}
}

function descvalidate(){
  var frmProfile=document.frmProfile;
  document.frmProfile.description.value = $('description1').value;
 if ( IsEmpty(document.frmProfile.DESCDET,'textarea')){
    $('desccount').innerHTML="Please enter your description";frmProfile.DESCDET.focus();return false;
  }else{$('desccount').innerHTML="&nbsp;";}
  
	var desc=frmProfile.description.value;
	if(desc.length<50){
		$('desccount').innerHTML="Please enter your description minimum 50 characters.";
		frmProfile.description.focus();
		return false;
	}
	timeresize("mdfrm");
	return true;
}

function ValidateProfile(){
	var frmProfile=document.frmProfile;
	if(ProfileValidate()==true){
		frmProfile.action = 'primaryinfodesc.php?primaryedit=3';
		frmProfile.submit();
	}
}

function ProfileValidate(){
  var frmProfile=document.frmProfile;
  if (IsEmpty(document.frmProfile.name,"text")){
	$('name').innerHTML="Please enter the name of the prospect";
    frmProfile.name.focus();return false;
  }else{$('name').innerHTML="&nbsp";}
  
  if(frmProfile.age.value=="" && (frmProfile.dobMonth.options[frmProfile.dobMonth.selectedIndex].text=="-Month-" && frmProfile.dobDay.options[frmProfile.dobDay.selectedIndex].text=="-Date-" && frmProfile.dobYear.options[frmProfile.dobYear.selectedIndex].text=="-Year-")) {
    $('age').innerHTML="Please enter the age or select the date of birth of the prospect";frmProfile.age.focus();return false;}
    else{$('age').innerHTML="&nbsp";}

  if(IsEmpty(document.frmProfile.age,"text"))
	{ 
	  if (document.frmProfile.dobMonth.options[document.frmProfile.dobMonth.selectedIndex].text=="-Month-")	
	  {$('age').innerHTML="Please select month";frmProfile.dobMonth.focus();return false;}
	  else{$('age').innerHTML="&nbsp;";}

	  if (document.frmProfile.dobDay.options[document.frmProfile.dobDay.selectedIndex].text=="-DATE-")	
	  {$('age').innerHTML="Please select date";frmProfile.dobDay.focus();return false;}
	  else{$('age').innerHTML="&nbsp;";}

	  if (document.frmProfile.dobYear.value=="0")		
	  {$('age').innerHTML="Please select year";frmProfile.dobYear.focus();return false;}
	  else{$('age').innerHTML="&nbsp;";}
	}	
  if(!ValidateNo(frmProfile.age.value,"0123456789")){
    $('age').innerHTML="Please enter a valid age.";frmProfile.age.focus();return false;
  }else{
    var ageint = parseInt(frmProfile.age.value );
    if (ageint < 18){
      $('age').innerHTML="Sorry! prospect need to be at least 18 if you are a woman and 21 if you are a man to register.";
      frmProfile.age.focus();return false;
    }else{$('age').innerHTML="&nbsp";}
      if (ageint > 70){
        $('age').innerHTML="Maximum age allowed is 70.";frmProfile.age.focus();return false;
      }else{$('age').innerHTML="&nbsp";}
  }
  var calyear = displayage(frmProfile.dobYear.value,frmProfile.dobMonth.value,frmProfile.dobDay.value, 'years', 0, 'rounddown')
  if(frmProfile.oldgender.value==1){
    if(frmProfile.age.value<21 && !(frmProfile.age.value=="")) {
      $('age').innerHTML="prospect should be 21 years to register";frmProfile.age.focus();return false;
    }else{$('age').innerHTML="&nbsp";}
      if(frmProfile.age.value=="" && calyear < 21){
      $('age').innerHTML="prospect should be 21 years to register";frmProfile.age.focus();return false;
    }else{$('age').innerHTML="&nbsp";}
  }
  if(frmProfile.age.value < 18 && !(frmProfile.age.value=="")){
    $('age').innerHTML="prospect Should be 18 years to Register";frmProfile.age.focus();return false;
  }else{$('age').innerHTML="&nbsp";}
  if(frmProfile.age.value=="" && calyear < 18 ){
    $('age').innerHTML="prospect should be 18 years to register";frmProfile.age.focus();return false;
  }else{$('age').innerHTML="&nbsp";}
  if(frmProfile.age.value=="" && calyear > 70){
    $('age').innerHTML="Maximum age allowed is 70";frmProfile.age.focus();return false;
  }else{$('age').innerHTML="&nbsp";}
  if(frmProfile.maritalStatus.selectedIndex == 0){
    $('mstatus').innerHTML="Please select the marital status of the prospect";frmProfile.maritalStatus.focus();return false;
  }else{$('mstatus').innerHTML="&nbsp";}
  if(frmProfile.maritalStatus.options[frmProfile.maritalStatus.selectedIndex].value > 1 && frmProfile.noOfChildren.selectedIndex == 0 ){
      $('mstatus').innerHTML="Please select the number of children";frmProfile.noOfChildren.focus();return false;
    }
  if(frmProfile.maritalStatus.options[frmProfile.maritalStatus.selectedIndex].value > 1 && frmProfile.noOfChildren.options[frmProfile.noOfChildren.selectedIndex].value >= 1 && !frmProfile.childLivingWithMe[0].checked && !frmProfile.childLivingWithMe[1].checked)
  {
    $('mstatus').innerHTML="Please indicate whether the child/children is/are living with you";frmProfile.childLivingWithMe[0].focus();
    return false;
  }
  if(frmProfile.heightFeet.selectedIndex==0 && frmProfile.heightCms.selectedIndex==0){
    $('height').innerHTML="Please select the height of the prospect";frmProfile.heightFeet.focus();return false;
  }else{$('height').innerHTML="&nbsp";}
  if(!frmProfile.horoscope[0].checked && !frmProfile.horoscope[1].checked){
    $('shoroscope').innerHTML="Please select the horoscope match of the prospect";frmProfile.horoscope[0].focus();return false;
  }else{$('shoroscope').innerHTML="&nbsp";}
  if(frmProfile.motherTongue.selectedIndex == 0){
    $('mothertong').innerHTML="Please select the mother tongue of the prospect";frmProfile.motherTongue.focus();return false;
  }else{$('mothertong').innerHTML="&nbsp";}
  if(frmProfile.profileCreatedBy.selectedIndex==0){
    $('profilecreate').innerHTML="Please select the profile created by";frmProfile.profileCreatedBy.focus();return false;
  }else{$('profilecreate').innerHTML="&nbsp";}
  timeresize("mpfrm");
  return true;
}

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
		var j = 0;
		while(j < i)
		{
			daySelect[j] = new Option(j+1,j+1);
			j = j + 1;
		}
		if (day <= i)
		{
			daySelect.selectedIndex = day - 1;
		}
		else
		{
			daySelect.selectedIndex = daySelect.length - 1;
		}
	}
}
}

function agefocus(){
  var frmProfile=document.frmProfile;
  if(document.frmProfile.age.value!=""){
		if(!(document.frmProfile.dobYear.value=="0") || !(document.frmProfile.dobMonth.value=="") || !(document.frmProfile.dobDay.value=="0"))
		{document.frmProfile.dobMonth.value=""; document.frmProfile.dobDay.value="1"; document.frmProfile.dobYear.value="0";}
	}
}

function agesel(){
  document.frmProfile.age.value="";$('age').innerHTML="&nbsp";
}

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

function onCMS()
{
	if (!(document.frmProfile.heightFeet.value=="0"))
	{document.frmProfile.heightFeet.value="0";}
}
	
function onFEET()
{
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

function onKGS()
{
	if (!(document.frmProfile.weightLbs.value=="0")){document.frmProfile.weightLbs.value="0";}
}
	
function onLBS()
{
	if (!(document.frmProfile.weightKgs.value=="0")){document.frmProfile.weightKgs.value="0";}		
}

function ValidateSocial(){
	var frmProfile = document.frmProfile;
	if(SocialValidate()==true){
		frmProfile.action = 'socioinfodesc.php?socioedit=3';
		frmProfile.submit();
	}
}

function SocialValidate(){
	var frmProfile = document.frmProfile;

	if (frmProfile.religion.selectedIndex==0) {
		document.getElementById('ssect').innerHTML="Please select the sect of the prospect";
		return;
	} else {
		document.getElementById('ssect').innerHTML=" ";
	}

	if (frmProfile.casteDivision.selectedIndex==0) {
		document.getElementById('ssubsect').innerHTML="Please select the sub sect of the prospect";
		return;
	} else {
		document.getElementById('ssubsect').innerHTML=" ";
	}

	if (frmProfile.caste.selectedIndex==0) {
		document.getElementById('scaste').innerHTML="Please select the caste of the prospect";
		return;
	} else {
		document.getElementById('scaste').innerHTML=" ";
	}

	if (frmProfile.caste.value==6) {
	  if (IsEmpty(frmProfile.subCaste,'text')) {
		$('ssubcaste').innerHTML="Please enter the caste of the prospect";frmProfile.subCaste.focus();return false;
	  }else{$('ssubcaste').innerHTML="&nbsp";}
	}

  timeresize("msfrm");
  return true;
}

function checkCaste()
{
	var frmProfile = this.document.frmProfile;
	if (frmProfile.caste.selectedIndex==0) {
		document.getElementById('scaste').innerHTML="Please select the caste of the prospect";
		return;
	} else {
		document.getElementById('scaste').innerHTML=" ";
	}
}

function toggleSubcaste() {
	var frmProfile = this.document.frmProfile;
	if(document.frmProfile.caste.value=='6') {
		document.frmProfile.subCaste.disabled=false;
		document.frmProfile.subCaste.focus();
	} else {
		document.frmProfile.subCaste.value='';
		document.getElementById('ssubcaste').innerHTML=" "; 
		document.frmProfile.subCaste.disabled=true;
	}
}

function subcasteChk(){
	var frmProfile = this.document.frmProfile;
	if (frmProfile.caste.value==6) {
		if (IsEmpty(frmProfile.subCaste,'text')) {
			$('ssubcaste').innerHTML="Please enter the caste of the prospect";
		} else {
			$('ssubcaste').innerHTML=" ";
		}
	}
}

var sect_request = false;
function modifyDivision(sectval) {	
	if(sectval>0 && sectval!=null) {
		sect_request = AjaxCall();
		var url="../profiledetail/getdivision.php?sectid="+sectval;
		sect_request.onreadystatechange = processResponseDivision;
		sect_request.open('GET', url, true);
		sect_request.send(null);
	} else {}
}
function processResponseDivision() {
	if (sect_request.readyState == 4) {
		if (sect_request.status == 200) {
			$("lcasteDivision").innerHTML = '';
			$("lcasteDivision").innerHTML = sect_request.responseText;
		}
	}
}

function ValidateLocation(){
	var frmProfile = document.frmProfile;
	if(LocationValidate()==true){
		frmProfile.action = 'locationinfodesc.php?locedit=3';
		frmProfile.submit();
	}
}

function LocationValidate(){
  var frmProfile = document.frmProfile;
  
  var cntry = frmProfile.country.value;var citizn = frmProfile.citizenship.value;
  if(frmProfile.country.selectedIndex == 0){
    $('loccountry').innerHTML="Please select the country of living of the prospect";frmProfile.country.focus();return false;
  }else{$('loccountry').innerHTML="&nbsp";}
  if(frmProfile.citizenship.selectedIndex == 0){
    $('loccitizenship').innerHTML="Please select the citizenship of the prospect";frmProfile.citizenship.focus();return false;
  }else{$('loccitizenship').innerHTML="&nbsp";}
  if (cntry == citizn){frmProfile.residentStatus.disabled = true;
  }else{
    if(frmProfile.residentStatus.selectedIndex == 0 ){
      $('locresident').innerHTML="Please select the resident status of the prospect";frmProfile.residentStatus.focus();
      $('locresidingcity').innerHTML="&nbsp";
      return false;
    }else {$('locresident').innerHTML="&nbsp";}
  }
 
	if(cntry == 98 || cntry == 222)
	{
	  if(frmProfile.residingState.selectedIndex == 0 ){
		$('locresidingstate').innerHTML="Please select the resident state of the prospect";frmProfile.residingState.focus();
		return false;
	  }else{$('locresidingstate').innerHTML="&nbsp";}
	}
	else
	{
		 if(frmProfile.residingState.value == '' ){
			$('locresidingstate').innerHTML="Please enter the resident state of the prospect";frmProfile.residingState.focus();
			return false;
		  }else{$('locresidingstate').innerHTML="&nbsp";}
	}

	if(cntry == 98)
	{
		  if(frmProfile.residingCity.selectedIndex == 0 ){
			$('locresidingcity').innerHTML="Please select the residing city of the prospect";frmProfile.residingCity.focus();
			return false;
		  }else{$('locresidingcity').innerHTML="&nbsp";}
	}
	else
	{
		if(frmProfile.residingCity.value == '' ){
			$('locresidingcity').innerHTML="Please enter the residing city of the prospect";frmProfile.residingCity.focus();
			return false;
		  }else{$('locresidingcity').innerHTML="&nbsp";}
	}
	timeresize("mlfrm");
	return true;
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
{	if(cval>0 && cval!=null)
	{
		state_request = AjaxCall();
		var url="../profiledetail/getstates.php?countryid="+cval; //Mano
		state_request.onreadystatechange = processResponseState;
		state_request.open('GET', url, true);
		state_request.send(null);
	}
	else
	{
	}
}
function processResponseState()
{
	if (state_request.readyState == 4) 
	{
		if (state_request.status == 200) 
		{
			$("statecitydiv").innerHTML = '';
			$("statecitydiv").innerHTML = state_request.responseText;
		}
	}
}


var ccode_request = false;
function modrequestnew(cvalue)
{	if(cvalue>0 && cvalue!=null)
	{
		ccode_request = AjaxCall();
		var url="../register/getcities.php?stateid="+cvalue; //Mano
		ccode_request.onreadystatechange = processResponsenew;
		ccode_request.open('GET', url, true);
		ccode_request.send(null);
	}
	else
	{
		emptyCitySel();
	}
}
function emptyCitySel()
{
	var citysel = $('residingCity');
	if (citysel.length>0)
	{
		for(i=citysel.length;i>=0;i--)
		{
			citysel.remove(i);
		}
	}
	var y=document.createElement('option');
	y.value='0';
	y.text='-Select-';
	try
	{
		citysel.add(y,null); // standards compliant
	}
	catch(ex)
	{
		citysel.add(y); // IE only
	}
}
function processResponsenew()
{
	if (ccode_request.readyState == 4) 
	{
		if (ccode_request.status == 200) 
		{
			var citysel = $('residingCity');
			var listValues = ccode_request.responseText;
			listValueArray = listValues.split('~');
			var y;
			for(i=0;i<listValueArray.length;i=i+2) {
			  y=document.createElement('option');
			  y.value=listValueArray[i];
			  y.text=listValueArray[i+1];
			  try
				{
				citysel.add(y,null); // standards compliant
				}
			  catch(ex)
				{
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

function citizen(){
  var frmProfile = document.frmProfile;
  if(frmProfile.citizenship.value==frmProfile.country.value)
  {frmProfile.residentStatus.value=1;frmProfile.residentStatus.disabled=true;}
  else
  {frmProfile.residentStatus.value=0;frmProfile.residentStatus.disabled=false;}
}

//Contact Info scripts starts here
function ValidateContact(){
	var frmProfile=document.frmProfile;
	if(ContactValidate()==true){
		frmProfile.action = 'contactinfodesc.php?contactedit=3';
		frmProfile.submit();
	}
}

function ContactValidate(){
	
  var frmProfile=document.frmProfile;

	// Check E-mail
	if (document.frmProfile.email.value=="")
	{$('emailspan').innerHTML="Please enter a valid e-mail address";frmProfile.email.focus();return false;}
	else{$('emailspan').innerHTML=" ";}
	if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(document.frmProfile.email.value)))
	{
	$('emailspan').innerHTML="Please enter a valid e-mail address";frmProfile.email.focus();return false;}
	else{
		$('emailspan').innerHTML="";
	}

	//Phone validation
	if(document.frmProfile.countryCode.value=="" && document.frmProfile.areaCode.value=="" && document.frmProfile.phoneNo.value=="" && document.frmProfile.mobileNo.value=="")
	{
		$('contact').innerHTML="Please enter the contact number";
		document.frmProfile.phoneNo.focus();
		return false; }
	else{$('contact').innerHTML="";}

	if (document.frmProfile.phoneNo.value==""  && document.frmProfile.mobileNo.value=="")
	{$('contact').innerHTML="Please enter the contact number";document.frmProfile.phoneNo.focus();return false;}
	else{$('contact').innerHTML="";}

	if (document.frmProfile.phoneNo.value!="")
	{
		if (document.frmProfile.countryCode.value=="")
		{$('contact').innerHTML="Please enter the country code";document.frmProfile.countryCode.focus();return false;}
		else{$('contact').innerHTML="";}
				
		if (document.frmProfile.areaCode.value=="")
		{$('contact').innerHTML="Please enter area / STD code";document.frmProfile.areaCode.focus();return false;}
		else{$('contact').innerHTML="";}
	}

	if (document.frmProfile.mobileNo.value!="")
	{
		if (document.frmProfile.countryCode.value=="")
		{$('contact').innerHTML="Please enter the country code";document.frmProfile.countryCode.focus();return false;}
		else{$('contact').innerHTML="";}
	}

	if (document.frmProfile.countryCode.value!="")
	{
		if (!ValidateNo(document.frmProfile.countryCode.value,'1234567890'))
		{$('contact').innerHTML="Please enter a valid country code";document.frmProfile.countryCode.focus();return false;}
		else{$('contact').innerHTML="";}
	}
	if (document.frmProfile.areaCode.value!="")
	{
		if (!ValidateNo(document.frmProfile.areaCode.value,'1234567890'))
		{$('contact').innerHTML="Please enter a valid area code";document.frmProfile.areaCode.focus();return false;}
		else{$('contact').innerHTML="";}
	}
	if (document.frmProfile.phoneNo.value!="")
	{
		if (!ValidateNo(document.frmProfile.phoneNo.value,'1234567890'))
		{$('contact').innerHTML="Please enter a valid phone number";document.frmProfile.phoneNo.focus();return false;}
		else{$('contact').innerHTML="";}
	}
	if (document.frmProfile.mobileNo.value!="")
	{
		if (!ValidateNo(document.frmProfile.mobileNo.value,'1234567890'))
		{$('contact').innerHTML="Please enter a valid mobile number";document.frmProfile.mobileNo.focus();return false;}
		else{$('contact').innerHTML="";}
	}
	
	timeresize("mcfrm");
  return true;
}
//Contact Info scripts end here

//Education details Script Start here
function ValidateEducation(){
	var frmProfile = document.frmProfile;
	if(EducationValidate()==true){
		frmProfile.action = 'educationinfodesc.php?eduedit=3';
		frmProfile.submit();
	}
}

function EducationValidate(){
  var frmProfile = document.frmProfile;
  if(frmProfile.educationCategory.selectedIndex==0){
    $('education').innerHTML="Please select the Education of the prospect";frmProfile.educationCategory.focus();return false;
  }else {$('education').innerHTML="&nbsp";}
  if(frmProfile.educationCategory.selectedIndex==10){
	if(frmProfile.educationInDetail.value == '') {
		$('othereducation').innerHTML="Please enter education in detail";frmProfile.educationInDetail.focus();return false;
	  }else {$('othereducation').innerHTML="&nbsp";}
  }
  if(!frmProfile.occupationCategory[0].checked && !frmProfile.occupationCategory[1].checked && !frmProfile.occupationCategory[2].checked && !frmProfile.occupationCategory[3].checked && !frmProfile.occupationCategory[4].checked){
      $('occupationCategoryid').innerHTML="Please select the Employment Status of the prospect";frmProfile.occupationCategory[0].focus();
      return false;
    }else {$('occupationCategoryid').innerHTML="&nbsp";}
  if(frmProfile.occupationCategory[2].checked){
	  frmProfile.occupation.disabled=true;
	if(!(IsEmpty(frmProfile.annualIncome,'text'))){
        if(!ValidateNo(frmProfile.annualIncome.value,'1234567890., ')){
          $('income').innerHTML="Please enter Valid Income of the prospect";frmProfile.annualIncome.focus();return false;
        }else{$('income').innerHTML="&nbsp";}
      }
  }else if((frmProfile.occupationCategory[0].checked)  || (frmProfile.occupationCategory[1].checked) || (frmProfile.occupationCategory[3].checked)){

	frmProfile.occupation.disabled=false;
		
    if(frmProfile.occupation.selectedIndex==0){
      $('occupationid').innerHTML="Please select the Occupation of the prospect";frmProfile.occupation.focus();return false;
    }else{$('occupationid').innerHTML="&nbsp";}

	re = new RegExp("^[a-m A-M .]*$");
    if(!(frmProfile.occupation.selectedIndex==0)){
      if(re.test(document.frmProfile.occupation.value)){
        $('occupationid').innerHTML="Please select the Occupation of the prospect";frmProfile.occupation.focus();return false;
      }else {$('occupationid').innerHTML="&nbsp";}
    }
	
	if(frmProfile.occupation.value==60){
		if(frmProfile.occupationInDetail.value == '') {
			$('otheroccupation').innerHTML="Please enter occupation in detail";frmProfile.occupationInDetail.focus();return false;
		  }else {$('otheroccupation').innerHTML="&nbsp";}
	}
    if(!(IsEmpty(frmProfile.annualIncome,'text'))){
      if(frmProfile.annualIncomeCurrency.selectedIndex==0){
        $('income').innerHTML="Please first select the currency and then enter the annual income of the prospect.";frmProfile.annualIncome.focus();return false;
      }else{$('income').innerHTML="&nbsp";}
      if(!ValidateNo(frmProfile.annualIncome.value,'1234567890,. ')){
        $('income').innerHTML="Please enter valid Income of the prospect";frmProfile.annualIncome.focus();return false;
      }else {$('income').innerHTML="&nbsp";}
    }
  }

  if(frmProfile.annualIncomeCurrency.selectedIndex!=0){
	  if(frmProfile.annualIncome.value == '') {
		$('income').innerHTML="Please enter annual income amount";frmProfile.annualIncome.focus();return false;
	  }else {$('income').innerHTML="&nbsp";}
  }

  timeresize("mefrm");
  return true;
}

function chkOthEducation() {
	if(frmProfile.educationCategory.selectedIndex==10){
		if(frmProfile.educationInDetail.value == '') {
			$('othereducation').innerHTML="Please enter education in detail";frmProfile.educationInDetail.focus();return false;
		  }else {$('othereducation').innerHTML="&nbsp";}
	}
}

function chkOthOccupation() {
	if(frmProfile.occupation.value==60 && (frmProfile.occupationCategory[0].checked)  || (frmProfile.occupationCategory[1].checked) || (frmProfile.occupationCategory[3].checked)){
		if(frmProfile.occupationInDetail.value == '') {
			$('otheroccupation').innerHTML="Please enter occupation in detail";frmProfile.occupationInDetail.focus();return false;
		  }else {$('otheroccupation').innerHTML="&nbsp";}
	}
}

function chkIncomeDet() {
	if(frmProfile.annualIncomeCurrency.selectedIndex!=0){
		 if(frmProfile.annualIncome.value == '') {
			$('income').innerHTML="Please enter annual income amount";frmProfile.annualIncome.focus();return false;
		  }else {$('income').innerHTML="&nbsp";}
	}
}

function occDependencyChk() { 
	var frmProfile = document.frmProfile;
	frmProfile.occupationInDetail.disabled=false;
	frmProfile.annualIncomeCurrency.disabled=false;
	frmProfile.annualIncome.disabled=false;
	frmProfile.occupation.disabled=false;
	modifyoccupation(1,frmProfile.oldOccupation.value); //1 means govt, private
}

function occBusinessChk() { 
	var frmProfile = document.frmProfile;
	frmProfile.occupationInDetail.disabled=false;
	frmProfile.annualIncomeCurrency.disabled=false;
	frmProfile.annualIncome.disabled=false;
	frmProfile.occupation.disabled=true;
}

function occDefenceChk() { 
	var frmProfile = document.frmProfile;
	frmProfile.occupationInDetail.disabled=false;
	frmProfile.annualIncomeCurrency.disabled=false;
	frmProfile.annualIncome.disabled=false;
	frmProfile.occupation.disabled=false;
	modifyoccupation(2,frmProfile.oldOccupation.value); //2 means defence
}

function notWorkChk() {
	var frmProfile = document.frmProfile;
	frmProfile.occupationInDetail.disabled=true;
	frmProfile.annualIncomeCurrency.disabled=true;
	frmProfile.annualIncome.disabled=true;
	frmProfile.occupation.disabled=true;
	frmProfile.occupationInDetail.value = '';
	frmProfile.annualIncomeCurrency.selectedIndex = 0;
	frmProfile.annualIncome.value = '';
}

var occupation_request = false;
function modifyoccupation(cval,selectedOcc)
{	if(cval>0 && cval!=null)
	{
		occupation_request = AjaxCall();
		var url="../profiledetail/getoccupation.php?occupationid="+cval+"&selOcc="+selectedOcc; //Mano
		occupation_request.onreadystatechange = processResponse;
		occupation_request.open('GET', url, true);
		occupation_request.send(null);
	}
	else
	{
	}
}
function processResponse()
{
	if (occupation_request.readyState == 4) 
	{
		if (occupation_request.status == 200) 
		{
			$("occdiv").innerHTML = '';
			$("occdiv").innerHTML = occupation_request.responseText;
		}
	}
}
//Education details Script Ends here

//Family details Script Start here
function ValidateFamily(){
	var frmProfile = document.frmProfile;
	if(familyValidate()==true){
		frmProfile.action = 'familyinfodesc.php?familyedit=3';
		frmProfile.submit();
	}
	
}

function familyValidate(){
	
  var frmProfile = document.frmProfile;
  
  if(!frmProfile.familyValue[0].checked && !frmProfile.familyValue[1].checked && !frmProfile.familyValue[2].checked){
      $('familyvalue').innerHTML="Please select the family value of the prospect";frmProfile.familyValue[0].focus();return false;
    }else{$('familyvalue').innerHTML="&nbsp";}
  if(!frmProfile.familyType[0].checked && !frmProfile.familyType[1].checked && !frmProfile.familyType[2].checked){
      $('familytype').innerHTML="Please select the family type of the prospect";frmProfile.familyType[0].focus();return false;
    }else{$('familytype').innerHTML="&nbsp";}
  if(!(frmProfile.brothers.value=="0") && !(frmProfile.marriedBrothers.value=="0")){
    if(frmProfile.marriedBrothers.value > frmProfile.brothers.value){
      $('brothersid').innerHTML="Incorrect selection.";frmProfile.brothers.focus();return false;
    }else {$('brothersid').innerHTML="&nbsp";}
  }
  if(!(frmProfile.marriedBrothers.value=="0") && frmProfile.brothers.value=="0"){
      $('brothersid').innerHTML="Please select no of brother(s) of the prospect";frmProfile.brothers.focus();return false;
    }else{$('brothersid').innerHTML="&nbsp";}
  if(!(frmProfile.sisters.value=="0") && !(frmProfile.marriedSisters.value=="0")){
    if(frmProfile.marriedSisters.value > frmProfile.sisters.value){
      $('sistersid').innerHTML="Incorrect selection.";frmProfile.sisters.focus();return false;
    }else{$('sistersid').innerHTML="&nbsp";}
    }
  if(!(frmProfile.marriedSisters.value=="0") && frmProfile.sisters.value=="0"){
      $('sistersid').innerHTML="Please select no of Sister(s) of the prospect";frmProfile.sisters.focus();return false;
  }else{$('sistersid').innerHTML="&nbsp";}
  timeresize("mffrm");
  return true;
}
//Family details Script Ends here


//Hobbies details Script Start here
function ValidateHobbies(){
	var frmProfile = document.frmProfile;
	if(HobbiesValidate()==true){
		frmProfile.action = 'hobbiesinfodesc.php?hobbiesedit=3';
		frmProfile.submit();
	} else {
		return false;
	}
	
}

function HobbiesValidate(){
	
  var frmProfile = document.frmProfile;
  
   if (frmProfile.hobothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.hobbiesDesc,'text')){
		$('hobbiesDescspan').innerHTML="Please enter other hobbies";
		frmProfile.hobbiesDesc.value = '';
		frmProfile.hobbiesDesc.focus();return false;
	  }else{$('hobbiesDescspan').innerHTML="&nbsp;";}
   }

   if (frmProfile.intothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.interestDesc,'text')){
		$('interestDescspan').innerHTML="Please enter other interests";
		frmProfile.interestDesc.value = '';
		frmProfile.interestDesc.focus();return false;
	  }else{$('interestDescspan').innerHTML="&nbsp;";}
   }

   if (frmProfile.mscothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.musicDesc,'text')){
		$('musicDescspan').innerHTML="Please enter other favourite musics";
		frmProfile.musicDesc.value = '';
		frmProfile.musicDesc.focus();return false;
	  }else{$('musicDescspan').innerHTML="&nbsp;";}
   }

   if (frmProfile.frdothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.readDesc,'text')){
		$('readDescspan').innerHTML="Please enter other favourite reads";
		frmProfile.readDesc.value = '';
		frmProfile.readDesc.focus();return false;
	  }else{$('readDescspan').innerHTML="&nbsp;";}
   }

   if (frmProfile.mvothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.movieDesc,'text')){
		$('movieDescspan').innerHTML="Please enter other preferred movies";
		frmProfile.movieDesc.value = '';
		frmProfile.movieDesc.focus();return false;
	  }else{$('movieDescspan').innerHTML="&nbsp;";}
   }

   if (frmProfile.sftothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.sportsDesc,'text')){
		$('sportsDescspan').innerHTML="Please enter other sports/fitness activities";
		frmProfile.sportsDesc.value = '';
		frmProfile.sportsDesc.focus();return false;
	  }else{$('sportsDescspan').innerHTML="&nbsp;";}
   }

   if (frmProfile.fcsnothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.foodDesc,'text')){
		$('foodDescspan').innerHTML="Please enter other favourite cuisine";
		frmProfile.foodDesc.value = '';
		frmProfile.foodDesc.focus();return false;
	  }else{$('foodDescspan').innerHTML="&nbsp;";}
   }

   if (frmProfile.pdsothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.dressDesc,'text')){
		$('dressDescspan').innerHTML="Please enter other preferred dress style";
		frmProfile.dressDesc.value = '';
		frmProfile.dressDesc.focus();return false;
	  }else{$('dressDescspan').innerHTML="&nbsp;";}
   }

   if (frmProfile.slangothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.spokenLangDesc,'text')){
		$('spokenLangDescspan').innerHTML="Please enter other spoken languages";
		frmProfile.spokenLangDesc.value = '';
		frmProfile.spokenLangDesc.focus();return false;
	  }else{$('spokenLangDescspan').innerHTML="&nbsp;";}
   }
   timeresize("mhfrm");
  return true;
}
//Hobbies details Script Ends here

//validation for Hobbies start here
function divswitch(c, a, b) {
if(c.length < 1) { return; }
if($(c).style.display == "none") 
	{
		$(c).style.display = "block";
		$(a).style.display = "none";
		$(b).style.display = "block";
	}
else 
	{
		$(c).style.display = "none";
		$(a).style.display = "block";
		$(b).style.display = "none";
	}
}

function othrtxt(a, b) {

	if(eval("document.frmProfile."+a+".checked")==true)		
	{ eval("document.frmProfile."+b+".disabled = false");}
	else {eval("document.frmProfile."+b+".disabled = true");$(b+'span').innerHTML = '';}	
}
//validation for hobbies end here

//Partenr details script Start Here
function ValidatePartner(){
	var frmProfile = document.frmProfile;
	if(PartnerValidate()==true){
		frmProfile.action = 'partnerinfodesc.php?ppedit=3';
		frmProfile.submit();
	}
}

function PartnerValidate(){
  var frmProfile = document.frmProfile;
  var finalAge = frmProfile.toAge.value - frmProfile.fromAge.value;
  var stAge = 0,endAge = 0;
  if((frmProfile.fromAge.value == "" ) || (frmProfile.toAge.value == "")){
    $('stage').innerHTML="Please select the age range of your partner";frmProfile.fromAge.focus();return false;
  }else{$('stage').innerHTML="&nbsp;";}
  if(finalAge > 20){
    $('stage').innerHTML="Age range should not exceed 20.";frmProfile.toAge.focus();return false;
  }else{$('stage').innerHTML="&nbsp;";}
  // Check Age 
  if(frmProfile.fromAge.value != "" && !ValidateNo(frmProfile.fromAge.value, "0123456789")){
    $('stage').innerHTML="Invalid Age " + frmProfile.fromAge.value;frmProfile.fromAge.focus();return false;
  }else if(frmProfile.fromAge.value != ""){
    stAge = parseInt(frmProfile.fromAge.value);
    if(stAge < 18 || stAge > 70){
      $('stage').innerHTML="Invalid Age " + frmProfile.fromAge.value + ".  Minimum age allowed is 18 and maximum age is 70";
      frmProfile.fromAge.focus();return false;
    }
  }else{$('stage').innerHTML="&nbsp;";}
  if(frmProfile.toAge.value != "" && !ValidateNo(frmProfile.toAge.value, "0123456789")){
    $('stage').innerHTML="Invalid Age " + frmProfile.toAge.value;frmProfile.toAge.focus();return false;
  }else if (frmProfile.toAge.value != ""){
    endAge = parseInt(frmProfile.toAge.value);
    if(endAge < 18 || endAge > 70){
      $('stage').innerHTML="Invalid Age " +  frmProfile.toAge.value + ".  Minimum age allowed is 18 and maximum age is 70";
      frmProfile.toAge.focus();return false;
    }
    if(stAge != 0 && endAge < stAge){
      $('stage').innerHTML="Invalid age range. " + stAge + " to " + endAge;
      frmProfile.fromAge.focus();return false;
    }
  }else {$('stage').innerHTML="&nbsp;";}
  if(!frmProfile.lookingStatus[0].checked && !frmProfile.lookingStatus[1].checked && !frmProfile.lookingStatus[2].checked && !frmProfile.lookingStatus[3].checked && !frmProfile.lookingStatus[4].checked){
      $('mstatus').innerHTML="Please select the type of partner you're looking for";frmProfile.lookingStatus[0].focus();
      return false;
  }else{$('mstatus').innerHTML="&nbsp;";}
  if (frmProfile.heightTo.selectedIndex  < frmProfile.heightFrom.selectedIndex){
    $('stheight').innerHTML="Invalid height range.";frmProfile.heightTo.focus();return false;
  }else {$('stheight').innerHTML="&nbsp;";}
  timeresize("mpafrm");
  return true;
}




//Partenr details script end Here

//common delay script
function delay(dvid)
{
	setTimeout("timedelay('"+dvid+"')",2000);
}
function timedelay(dvid) {
	$(dvid).style.display='none';
	$(dvid+'outer').style.display='none';
} 
