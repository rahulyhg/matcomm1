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

function validlandpage()
{
	var frmLand = this.document.landfrm;
	if(IsEmpty(frmLand.name,"text")) {
	alert("Enter the name of the prospect");
	frmLand.name.value='';
	frmLand.name.focus();
	return false;
	}

	if((IsEmpty(frmLand.age,"text") || (frmLand.age.value=="yrs")) && (frmLand.dobMonth.options[frmLand.dobMonth.selectedIndex].text=="MM" && frmLand.dobDay.options[frmLand.dobDay.selectedIndex].text=="DD" && frmLand.dobYear.options[frmLand.dobYear.selectedIndex].text=="YYYY"))  
	{
		alert("Enter the age or select the date of birth of the prospect");frmLand.age.value="";frmLand.age.focus();return false;
	}
	if(IsEmpty(frmLand.age,"text") || (frmLand.age.value=="yrs"))
	{
	if (frmLand.dobMonth.options[frmLand.dobMonth.selectedIndex].text=="MM")	
		  {alert("Select month");frmLand.dobMonth.focus();return false;}
	if (frmLand.dobDay.options[frmLand.dobDay.selectedIndex].text=="DD")
		  {alert("Select date");frmLand.dobDay.focus();return false;}
	if (frmLand.dobYear.value=="0")		
		  {alert("Select year");frmLand.dobYear.focus();return false;}
	}

	var age = parseInt(frmLand.age.value);
	if(!IsEmpty(frmLand.age.value) && (frmLand.dobMonth.options[frmLand.dobMonth.selectedIndex].text=="MM") || (frmLand.dobDay.options[frmLand.dobMonth.selectedIndex].text=="DD") || (frmLand.dobYear.value=="0"))
	{
	if(!ValidateNo(frmLand.age.value,"0123456789"))
	{alert("Enter a valid age");frmLand.age.focus();return false;}
	}

	var calyear = displayage(frmLand.dobYear.value,frmLand.dobMonth.value,frmLand.dobDay.value, 'years', 0, 'rounddown')

	if (frmLand.age.value<21 && frmLand.gender[0].checked && !(frmLand.age.value==""))
	{alert("Prospect should be 21 years to register");frmLand.age.focus();return false;}
	if (frmLand.age.value=="" && calyear < 21 && frmLand.gender[0].checked)
	{alert("Prospect should be 21 years to register");frmLand.age.focus();return false;}
	if (frmLand.age.value < 18 && frmLand.gender[1].checked && !(frmLand.age.value==""))
	{alert("Prospect should be 18 years to register");frmLand.age.focus();return false;}
	if (frmLand.age.value=="" && calyear < 18 && frmLand.gender[1].checked)
	{alert("Prospect Should be 18 years to Register");document.getElementById('row1').className="rowcolorreg";frmLand.age.focus();return false;}
	if ( age > 70 && calyear > 70)
	{alert("Maximum age allowed is 70");frmLand.age.focus( );return false;}

	if(!(frmLand.gender[0].checked) && !(frmLand.gender[1].checked))
	{alert("Select the gender");frmLand.gender[0].focus;return false;}

	if (frmLand.community.value==0)
	{alert("Select the community of the prospect");frmLand.community.focus();return false;}	

	if (parseInt(frmLand.country.options[frmLand.country.selectedIndex].value) == 0 || frmLand.country.options[frmLand.country.selectedIndex].value=="" )
	{alert("Select the country of living of the prospect");frmLand.country.focus( );return false;}
	
	if((IsEmpty(frmLand.countryCode,'text') || frmLand.countryCode.value == "91") && IsEmpty(frmLand.areaCode,'text') && IsEmpty(frmLand.phoneNo,'text') && IsEmpty(frmLand.mobileNo,'text')) 
	{alert("Enter the phone or mobile number");frmLand.mobileNo.focus();
	return false;}
	
	if (!(IsEmpty(frmLand.countryCode,'text')))
	{
		if (!ValidateNo(frmLand.countryCode.value,'1234567890'))
		{alert("Enter a valid country code");frmLand.countryCode.focus();return false;}
		if(IsEmpty(frmLand.mobileNo,'text'))
		{alert("Enter the mobile number");frmLand.mobileNo.focus();return false;}
	}
	
	if (!(IsEmpty(frmLand.mobileNo,'text')))
	{
		var mno=frmLand.mobileNo.value;
		if (!ValidateNo(frmLand.mobileNo.value,'1234567890'))
		{alert("Enter a valid mobile number");frmLand.mobileNo.focus();return false;}
		if(IsEmpty(frmLand.countryCode,'text'))
		{alert("Enter the country code");frmLand.countryCode.focus();return false;}
	}

	if (!(IsEmpty(frmLand.areaCode,'text')))
	{
		if (!ValidateNo(frmLand.areaCode.value,'1234567890'))
		{alert("Enter a valid area code");frmLand.areaCode.focus();return false;}
		if(IsEmpty(frmLand.phoneNo,'text'))
		{alert("Enter the phone number");frmLand.phoneNo.focus();return false;}
	}
	
	if (!(IsEmpty(frmLand.phoneNo,'text')))
	{
		if (!ValidateNo(frmLand.phoneNo.value,'1234567890'))
		{alert("Enter a valid phone number");frmLand.phoneNo.focus();return false;}
		if(IsEmpty(frmLand.areaCode,'text'))
		{alert("Enter the area code");frmLand.areaCode.focus();return false;}
	}
	
	if (IsEmpty(frmLand.email,"text")) 
		{alert("Enter the e-mail address");frmLand.email.focus();return false;} 
	else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(frmLand.email.value))) 
		{alert("Enter a valid e-mail address");frmLand.email.focus();return false;}

	if(frmLand.password.value == '') {
	alert("Enter the password");frmLand.password.focus();return false;}

	if(frmLand.password.value == frmLand.name.value) {
	alert("Name and Password should not be same");frmLand.password.focus();return false;}
	
	if (frmLand.password.value.length < 4 ) {
	alert("Password must have a minimum of 4 characters");frmLand.password.focus();return false;}

	frmLand.action="http://www."+frmLand.community.value+"matrimony.com/register/index.php?act=register";
}