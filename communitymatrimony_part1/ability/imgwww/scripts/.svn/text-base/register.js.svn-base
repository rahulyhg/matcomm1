var appImgsPath = varConfArr['domainimgs'];
var img_url = varConfArr['domainimg'];
var pho_url = varConfArr['webimgs'];
var productname = varConfArr['productname'];
var prevemail = '';
var preverrmsg = '';
var isSubcasteMandatory = 1;
//Validation for addbasic start here
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
	if ((change == 'month' && month == 2) || (change == 'year' && month == 2))
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
		i=i+1;

		while(j < i)
		{
			if(j==0){daySelect[j] = new Option("-Date-",j);j=j+1;}
			else
			{
				daySelect[j] = new Option(j,j);
				j = j + 1;
			}
		}
		
		/*if (day <= i)
		{daySelect.selectedIndex = day - 1;}
		else
		{daySelect.selectedIndex = daySelect.length - 1;}*/

	}
}
}


var uname_request=false;
function makerequestUserCheck(uvalue)
{

	document.getElementById("unamespan").innerHTML="<img src='"+appImgsPath+"/loading-icon.gif' />"; 
	document.getElementById("unamespan").style.display="block";
	var urltoget = "../register/checkuser.php?username="+uvalue;

	 uname_request = AjaxCall();
	  if (uname_request)
	  {
		uname_request.open("GET", urltoget, true);
		uname_request.onreadystatechange = processResponseUserCheck;
		uname_request.send(null);
	  }
}

function processResponseUserCheck() 
{
  if (uname_request.readyState == 4)
  {
	var msg=0;	
	 msg = uname_request.responseText;

		if(msg == 1)
		{
			document.getElementById("unamespan").innerHTML="";
			document.getElementById("unamespan").innerHTML="Username not available"; 
			//document.getElementById("unamespan").style.display="inline";
			document.frmRegister.username.focus();
		}
		else 
		{
			document.frmRegister.name.focus();
			document.getElementById("unamespan").style.display="none";
			document.getElementById("tempspan").style.display="none";
		}
	}
}

function citizen()
{
	if 	(frmRegister.citizenship.value==frmRegister.country.value)
	{frmRegister.residentStatus.value=1}
	else
	{frmRegister.residentStatus.value=0}
}
	
function HaveChildnp()
{
	var MaritalCnt = document.frmRegister.MaritalCnt.value;
	var childLW = document.frmRegister.noOfChildren.options[document.frmRegister.noOfChildren.selectedIndex].value;
	for(i=0; i<MaritalCnt; i++){
		if(document.frmRegister.maritalStatus[i].checked && document.frmRegister.maritalStatus[i].value==1){
		chkUMD = 1;
		document.getElementById('cstatus').style.display='none';
		document.getElementById('childliving').style.display='none';

		}else if(document.frmRegister.maritalStatus[i].checked && document.frmRegister.maritalStatus[i].value==2){
		chkUMD = 2;
		document.getElementById('cstatus').style.display='block';
		document.getElementById('childliving').style.display='block';
		}else if(document.frmRegister.maritalStatus[i].checked && document.frmRegister.maritalStatus[i].value==3){
		chkUMD = 3;
		document.getElementById('cstatus').style.display='block';
		document.getElementById('childliving').style.display='block';
		}else if(document.frmRegister.maritalStatus[i].checked && document.frmRegister.maritalStatus[i].value==4){
		chkUMD = 4;
		document.getElementById('cstatus').style.display='block';
		document.getElementById('childliving').style.display='block';
		}else if(document.frmRegister.maritalStatus[i].checked && document.frmRegister.maritalStatus[i].value==5){
		chkUMD = 5;
		document.getElementById('cstatus').style.display='block';
		document.getElementById('childliving').style.display='block';
		}
		else if(document.frmRegister.maritalStatus[i].checked && document.frmRegister.maritalStatus[i].value==6){
		chkUMD = 6;
		document.getElementById('cstatus').style.display='block';
		document.getElementById('childliving').style.display='block';
		}
	}
	if(chkUMD==1)
	{
		document.frmRegister.noOfChildren.disabled=true;	
		document.frmRegister.childrenLivingWithMe[0].disabled=true;		
		document.frmRegister.childrenLivingWithMe[1].disabled=true;
		document.getElementById('nocspan').innerHTML="";
		document.getElementById('clsspan').innerHTML="";
    }
	else 
	{
		if(MaritalCnt>2) {
			document.frmRegister.noOfChildren.disabled=false;			
			document.frmRegister.childrenLivingWithMe[0].disabled=true;		
			document.frmRegister.childrenLivingWithMe[1].disabled=true;
			document.frmRegister.noOfChildren.options.selectedIndex=0;
		}
	}
}

function Childliv()
{

if (document.frmRegister.domainRegister.value!='divorceematrimony.com')
{


	var childLW = document.frmRegister.noOfChildren.options[document.frmRegister.noOfChildren.selectedIndex].value;
	if(document.frmRegister.maritalStatus[0].checked)
	{
		document.frmRegister.noOfChildren.disabled=true;	
		document.frmRegister.childrenLivingWithMe[0].disabled=true;		
		document.frmRegister.childrenLivingWithMe[1].disabled=true;	
		document.getElementById('nocspan').innerHTML=" ";
		document.getElementById('clsspan').innerHTML=" ";
	}

	if(document.frmRegister.maritalStatus[0].checked==false)
	{
		if(childLW==0 || childLW=="")
		{
			document.getElementById('childliving').style.display='none';
			document.frmRegister.childrenLivingWithMe[0].checked=false;
			document.frmRegister.childrenLivingWithMe[1].checked=false;
			document.frmRegister.childrenLivingWithMe[0].disabled=true;		
			document.frmRegister.childrenLivingWithMe[1].disabled=true;	
			document.getElementById('clsspan').innerHTML=" ";
		}
		else
		{
			document.getElementById('childliving').style.display='block';
			document.frmRegister.childrenLivingWithMe[0].disabled=false;		
			document.frmRegister.childrenLivingWithMe[1].disabled=false;	
		}
	}
} else {

	if (document.frmRegister.noOfChildren.value=='0') { document.getElementById('childliving').style.display='none'; } 
	else { document.getElementById('childliving').style.display='block'; }
}
}	

function agefocus()
{
	if(document.frmRegister.age.value!=""){
		//if(!(document.frmRegister.dobYear.value=="0") && !(document.frmRegister.dobMonth.value=="0") && !(document.frmRegister.dobDay.value=="0"))
		//{
			document.frmRegister.dobMonth.value="0"; 
			document.frmRegister.dobDay.value="0"; 
			document.frmRegister.dobYear.value="0";// }
	}
}//agefocus

function agesel() { 
	document.getElementById('agespan').innerHTML='';
	var frmRegister = this.document.frmRegister;frmRegister.age.value="";
}
	
// Function to validate all the inputs
function ValidateReg() {
	var frmRegister = this.document.frmRegister;
	var communityId = document.frmRegister.communityId.value;

	if (communityId==0) {

		if (parseInt(document.frmRegister.domainName.options[document.frmRegister.domainName.selectedIndex].value)== 0) {
			document.getElementById('domainlistspan').innerHTML="Select the domain of the prospect";
			document.frmRegister.domainName.focus();return false;
		} else { document.getElementById('domainlistspan').innerHTML=''; }
	}//if

	if (IsEmpty(document.frmRegister.profileCreatedBy,'radio')) {
		document.getElementById('profilecreatedbyspan').innerHTML="Select your relationship with the prospect";
		document.frmRegister.profileCreatedBy[0].focus();
		return false;
	} else { document.getElementById('profilecreatedbyspan').innerHTML=""; }

	if(IsEmpty(document.frmRegister.nickName,"text")) {
	document.getElementById('nicknamespan').innerHTML="Enter the display name of the prospect";
	frmRegister.nickName.value='';
	frmRegister.nickName.focus();
	return false;
	} else { document.getElementById('nicknamespan').innerHTML=""; }

	if (!frmRegister.gender[0].checked && !frmRegister.gender[1].checked) {
		document.getElementById('genderspan').innerHTML="Select the gender of the prospect";
		frmRegister.gender[0].focus();
		return false;
	} else { document.getElementById('genderspan').innerHTML=""; }

	if(IsEmpty(document.frmRegister.age,"text") && (document.frmRegister.dobMonth.options[document.frmRegister.dobMonth.selectedIndex].text=="-Month-" && document.frmRegister.dobDay.options[document.frmRegister.dobDay.selectedIndex].text=="-Date-" && document.frmRegister.dobYear.options[document.frmRegister.dobYear.selectedIndex].text=="-Year-")) 
	{
	document.getElementById('agespan').innerHTML="Enter the age or select the date of birth of the prospect";frmRegister.age.value="";frmRegister.age.focus();return false;
	}else{document.getElementById('agespan').innerHTML="";}
	
	if(IsEmpty(document.frmRegister.age,"text")) {
	 if (document.frmRegister.dobMonth.options[document.frmRegister.dobMonth.selectedIndex].text=="-Month-")	
	  {
  document.getElementById('agespan').innerHTML="Select month";frmRegister.dobMonth.focus();return false;}
else{document.getElementById('agespan').innerHTML="";}

if (document.frmRegister.dobDay.options[document.frmRegister.dobDay.selectedIndex].text=="-Date-") {
  document.getElementById('agespan').innerHTML="Select date";frmRegister.dobDay.focus();return false;}
else{document.getElementById('agespan').innerHTML="";}

if (document.frmRegister.dobYear.value=="0")		
{
  document.getElementById('agespan').innerHTML="Select year";frmRegister.dobYear.focus();return false;}
else{document.getElementById('agespan').innerHTML="";}
}
	
var age = parseInt( frmRegister.age.value );

if( !ValidateNo( frmRegister.age.value, "0123456789" ) )
{
	document.getElementById('agespan').innerHTML="Enter a valid age";frmRegister.age.focus();return false;}
else{document.getElementById('agespan').innerHTML="";}

var calyear = displayage(frmRegister.dobYear.value,frmRegister.dobMonth.value,frmRegister.dobDay.value, 'years', 0, 'rounddown')

if (frmRegister.age.value<startMaleAge && frmRegister.gender[0].checked && !(frmRegister.age.value==""))
{
	document.getElementById('agespan').innerHTML="Prospect should be "+startMaleAge+" years to register";frmRegister.age.focus();return false;}
else{document.getElementById('agespan').innerHTML="";}
			
if (frmRegister.age.value=="" && calyear < startMaleAge && frmRegister.gender[0].checked)
{
	document.getElementById('agespan').innerHTML="Prospect should be "+startMaleAge+" years to register";frmRegister.age.focus();return false;}
else{document.getElementById('agespan').innerHTML="";}

if (frmRegister.age.value < startFemaleAge && frmRegister.gender[1].checked && !(frmRegister.age.value==""))
{
	document.getElementById('agespan').innerHTML="Prospect should be "+startFemaleAge+" years to register";frmRegister.age.focus();return false;}
else{document.getElementById('agespan').innerHTML="";}
			
if (frmRegister.age.value=="" && calyear < startFemaleAge && frmRegister.gender[1].checked)
{
    document.getElementById('agespan').innerHTML="Prospect Should be "+startFemaleAge+" years to Register";frmRegister.age.focus();return false;}
else{document.getElementById('agespan').innerHTML="";}

if ( age > 70 && calyear > 70)
{
	document.getElementById('agespan').innerHTML="Maximum age allowed is 70";frmRegister.age.focus( );return false;}
else{document.getElementById('agespan').innerHTML="";}

if(IsEmpty(document.frmRegister.age,"text") && (document.frmRegister.dobMonth.options[document.frmRegister.dobMonth.selectedIndex].text=="-Month-" && document.frmRegister.dobDay.options[document.frmRegister.dobDay.selectedIndex].text=="-Date-" && document.frmRegister.dobYear.options[document.frmRegister.dobYear.selectedIndex].text=="-Year-")) 
{
document.getElementById('agespan').innerHTML="Enter the age or select the date of birth of the prospect";frmRegister.age.value="";frmRegister.age.focus();return false;
}else{document.getElementById('agespan').innerHTML="";}
	
if(IsEmpty(document.frmRegister.age,"text")) {

  if (document.frmRegister.dobMonth.options[document.frmRegister.dobMonth.selectedIndex].text=="-Month-") {
	  document.getElementById('agespan').innerHTML="Select month";
	  frmRegister.dobMonth.focus();return false;
  } else{ document.getElementById('agespan').innerHTML=""; }

  if (document.frmRegister.dobDay.options[document.frmRegister.dobDay.selectedIndex].text=="-Date-") {
	  document.getElementById('agespan').innerHTML="Select date";frmRegister.dobDay.focus();return false;}
  else{document.getElementById('agespan').innerHTML="";}

  if (document.frmRegister.dobYear.value=="0") {
	  document.getElementById('agespan').innerHTML="Select year";
	  frmRegister.dobYear.focus();return false;}
  else{document.getElementById('agespan').innerHTML="";}
}
var age = parseInt( frmRegister.age.value );

if(!ValidateNo( frmRegister.age.value, "0123456789" )) {
	document.getElementById('agespan').innerHTML="Enter a valid age";
	frmRegister.age.focus();return false;}
else{document.getElementById('agespan').innerHTML="";}

var calyear = displayage(frmRegister.dobYear.value,frmRegister.dobMonth.value,frmRegister.dobDay.value, 'years', 0, 'rounddown')

if (frmRegister.age.value<startMaleAge && frmRegister.gender[0].checked && !(frmRegister.age.value=="")) {
	document.getElementById('agespan').innerHTML="Prospect should be "+startMaleAge+" years to register";frmRegister.age.focus();return false; }
else{ document.getElementById('agespan').innerHTML=""; }
			
if (frmRegister.age.value=="" && calyear < startMaleAge && frmRegister.gender[0].checked) {
	document.getElementById('agespan').innerHTML="Prospect should be "+startMaleAge+" years to register";frmRegister.age.focus();return false;
} else{ document.getElementById('agespan').innerHTML=""; }

if (frmRegister.age.value < startFemaleAge && frmRegister.gender[1].checked && !(frmRegister.age.value=="")) {
	document.getElementById('agespan').innerHTML="Prospect should be "+startFemaleAge+" years to register";frmRegister.age.focus();return false;}
else{document.getElementById('agespan').innerHTML="";}
			
if (frmRegister.age.value=="" && calyear < startFemaleAge && frmRegister.gender[1].checked) {
	document.getElementById('agespan').innerHTML="Prospect Should be "+startFemaleAge+" years to Register";frmRegister.age.focus();return false;}
else{ document.getElementById('agespan').innerHTML=""; }

if ( age > 70 && calyear > 70) {
	document.getElementById('agespan').innerHTML="Maximum age allowed is 70";frmRegister.age.focus();return false;}
else{ document.getElementById('agespan').innerHTML=""; }

if ( IsEmpty(document.frmRegister.maritalStatus,'radio')) {
	document.getElementById('maritalspan').innerHTML="Select the marital status of the prospect";frmRegister.maritalStatus[0].focus( );return false;}
else{document.getElementById('maritalspan').innerHTML=""; }


if ((document.frmRegister.communityId.value=='2001') || (document.frmRegister.domainRegister.value=='divorceematrimony.com'))  {
	if (document.frmRegister.noOfChildren.options[document.frmRegister.noOfChildren.selectedIndex].value=="") {
		document.getElementById('nocspan').innerHTML="Select the number of children"; 
		document.frmRegister.noOfChildren.focus();
		return false;
	} else { document.getElementById('nocspan').innerHTML=""; }
}
else if (!(document.frmRegister.maritalStatus[0].checked) && frmRegister.noOfChildren.selectedIndex == 0 ) {
	document.getElementById('nocspan').innerHTML="Select the number of children";
	frmRegister.noOfChildren.focus( );return false;}
else{ document.getElementById('nocspan').innerHTML=""; }

if (((document.frmRegister.domainRegister.value=='divorceematrimony.com') || (document.frmRegister.communityId.value=='2001')) && document.frmRegister.noOfChildren.options[document.frmRegister.noOfChildren.selectedIndex].value >= 1) {

	if (!frmRegister.childrenLivingWithMe[0].checked && !frmRegister.childrenLivingWithMe[1].checked) {

		document.getElementById('clsspan').innerHTML="indicate whether the child/children is/are living with you";
		frmRegister.childrenLivingWithMe[0].focus( );return false;
	} else { document.getElementById('clsspan').innerHTML=""; }

} else if (!(document.frmRegister.maritalStatus[0].checked) && document.frmRegister.noOfChildren.options[document.frmRegister.noOfChildren.selectedIndex].value >= 1 && !frmRegister.childrenLivingWithMe[0].checked && !frmRegister.childrenLivingWithMe[1].checked) {
	document.getElementById('clsspan').innerHTML="Indicate whether the child/children is/are living with you";frmRegister.childrenLivingWithMe[0].focus( );return false;}
else{document.getElementById('clsspan').innerHTML="";}

if (document.frmRegister.heightFeet.value=="0") {
	document.getElementById('heightspan').innerHTML="Select the height of the prospect";
	document.frmRegister.heightFeet.focus();return false;}
else{document.getElementById('heightspan').innerHTML="";}

retValue = abilityValidation('frmRegister');
if(retValue==false) {
	return false;
}

if (parseInt(document.frmRegister.appearancefeature.value)==1) {
	if (!frmRegister.appearance[0].checked && !frmRegister.appearance[1].checked) {
		document.getElementById('appearancespan').innerHTML="Select the appearance of the prospect";
		frmRegister.appearance[0].focus();
		return false;
	} else { document.getElementById('appearancespan').innerHTML=""; }
}

if (parseInt(document.frmRegister.communityId.value) > 0) {


if (parseInt(document.frmRegister.religionfeature.value)==1 && parseInt(document.frmRegister.religionOption.value)>1 ) {
	if (parseInt(document.frmRegister.religion.options[document.frmRegister.religion.selectedIndex].value)== 0) {
		document.getElementById('religionspan').innerHTML="Select the religion of the prospect";
		document.frmRegister.religion.focus();return false;
	} else { document.getElementById('religionspan').innerHTML=''; }

}

if (parseInt(frmRegister.denominationfeature.value)==1 && parseInt(frmRegister.denominationOption.value)>1 ) {
	if (parseInt(frmRegister.denomination.options[frmRegister.denomination.selectedIndex].value)== 0) {
		document.getElementById('denominationspan').innerHTML="Select the "+frmRegister.denominationlabel.value+" of the prospect";
		document.frmRegister.denomination.focus();return false;
	}
	else if(parseInt(frmRegister.denomination.options[frmRegister.denomination.selectedIndex].value) == 9997) {
       if(frmRegister.denominationText.value == '') {
	     document.getElementById('denominationspan').innerHTML="Select the "+frmRegister.denominationlabel.value+" of the prospect";
	     document.frmRegister.denominationText.focus();
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

if (parseInt(document.frmRegister.castefeature.value)==1 && document.frmRegister.castemandatory.value==1) {

	if (parseInt(document.frmRegister.casteOption.value)==1) {} else {
		
		if (parseInt(document.frmRegister.casteOption.value)>1) {

			/*if (parseInt(document.frmRegister.caste.options[document.frmRegister.caste.selectedIndex].value)== 0) {
			document.getElementById('castespan').innerHTML="Select the "+document.frmRegister.castelabel.value+" of the prospect";
			document.frmRegister.caste.focus();
			return false;
			} else { document.getElementById('castespan').innerHTML=''; }*/

            var casteId = parseInt(document.frmRegister.caste.options[document.frmRegister.caste.selectedIndex].value);
		    
			if (casteId == 0) {
			  document.getElementById('castespan').innerHTML="Select the "+document.frmRegister.castelabel.value+" of the prospect";
			  document.frmRegister.caste.focus();
			  return false;
			}
			else if(casteId == 9997) {
			  if (document.frmRegister.casteOthers.value=="") {
					document.getElementById('castespan').innerHTML="Enter the "+document.frmRegister.castelabel.value+" of the prospect";
					document.frmRegister.casteOthers.focus();
					return false;
			  }
			  else { document.getElementById('castespan').innerHTML=''; }
			}
			else { document.getElementById('castespan').innerHTML=''; }


		} else {
			var validateSubCaste = 'yes';

			if((document.frmRegister.domainRegister.value=='divorceematrimony.com') || (document.frmRegister.communityId.value=='2001')) {
				var religionId	= document.frmRegister.religion.options[document.frmRegister.religion.selectedIndex].value;
				if ((religionId=='8') || (religionId=='9')) { validateSubCaste = 'no'; }
			}

			if (validateSubCaste=='yes') {
				//if (IsEmpty(document.frmRegister.casteText,'text')) {
				  if(document.frmRegister.casteText.value == "") {
					document.getElementById('castespan').innerHTML="Enter the "+document.frmRegister.castelabel.value+" of the prospect";
					document.frmRegister.casteText.focus();
					return false;
				} else { document.getElementById('castespan').innerHTML=''; }
			}
		}
	}
}

if (parseInt(document.frmRegister.subcastefeature.value)==1 && document.frmRegister.subcastemandatory.value==1 && isSubcasteMandatory == 1) { 
	if (parseInt(document.frmRegister.subCasteOption.value)==1) { } else {
		if (parseInt(document.frmRegister.subCasteOption.value)>1) { 
			var subCasteId = parseInt(document.frmRegister.subCaste.options[document.frmRegister.subCaste.selectedIndex].value);
			document.getElementById("subCasteDivText").style.display="none";
			if (subCasteId== 0) {
				document.getElementById("subCasteDivText").style.display="none";
				document.getElementById('subcastespan').innerHTML="Select the "+document.frmRegister.subcastelabel.value+" of the prospect";
				document.frmRegister.subCaste.focus();return false;
			} else if (subCasteId==9997) {
				document.getElementById("subCasteDivText").style.display="block";
				if (document.frmRegister.subCasteOthers.value=="") {
					document.getElementById('subcastespan').innerHTML="Enter the "+document.frmRegister.subcastelabel.value+" of the prospect";
					document.frmRegister.subCasteOthers.focus();return false;
				} else { document.getElementById('subcastespan').innerHTML=''; }
			} else { document.getElementById('subcastespan').innerHTML=''; }

		} else {

			if (document.frmRegister.subCasteText.value=="") { 
				document.getElementById('subcastespan').innerHTML="Enter the "+document.frmRegister.subcastelabel.value+" of the prospect";
				document.frmRegister.subCasteText.focus();return false;
			} else { document.getElementById('subcastespan').innerHTML=''; }

		}
	}
}

if (parseInt(document.frmRegister.gothramfeature.value)==1) {
	if (parseInt(document.frmRegister.gothramOption.value)>1) {
		var gothramId = parseInt(document.frmRegister.gothram.options[document.frmRegister.gothram.selectedIndex].value);
		if (gothramId== 0 && communityId != 2004) {
			document.getElementById("gothramDivText").style.display="none";
			document.getElementById('gothraspan').innerHTML="Select the gothram of the prospect";
			document.frmRegister.gothram.focus();return false;
		} else if (gothramId==9997) {
			document.getElementById("gothramDivText").style.display="block";
			if (document.frmRegister.gothramOthers.value=="" && communityId != 2004) {
				document.getElementById('gothraspan').innerHTML="Enter the gothram of the prospect";
				document.frmRegister.gothramOthers.focus();return false;
			} else { document.getElementById('gothraspan').innerHTML=''; }
		} else { document.getElementById('gothraspan').innerHTML=''; }
	}
}

}

if (frmRegister.educationCategory.selectedIndex==0)
{document.getElementById('educationcategoryspan').innerHTML="Select the education category of the prospect";frmRegister.educationCategory.focus();return false;}	
else{document.getElementById('educationcategoryspan').innerHTML="";}

if (frmRegister.occupation.selectedIndex==0)
{document.getElementById('occupationspan').innerHTML="Select the occupation of the prospect";frmRegister.occupation.focus();return false;}	
else{document.getElementById('occupationspan').innerHTML="";}

if(frmRegister.occupation.options[frmRegister.occupation.selectedIndex].value != 888) {

  if (parseInt(document.frmRegister.empinfeature.value)==1) {
		if (parseInt(document.frmRegister.employedinOption.value)>1) {
			if ( IsEmpty(document.frmRegister.employmentCategory,'radio')) {
			  document.getElementById('employmentCategoryspan').innerHTML="Select the employment category of the prospect";
			  frmRegister.employmentCategory[0].focus();
			  return false;}
			else{document.getElementById('employmentCategoryspan').innerHTML=""; }
		}
  }

	var inCurr = document.frmRegister.annualIncomeCurrency.options[document.frmRegister.annualIncomeCurrency.selectedIndex].value;

	if (inCurr==0) {
		document.getElementById('annualincomespan').innerHTML="Select the currency type";
		document.frmRegister.annualIncomeCurrency.focus();
		return false;
	} else { document.getElementById('annualincomespan').innerHTML=""; }

	if (IsEmpty(document.frmRegister.annualIncome,'text')) {

		document.getElementById('amountspan').innerHTML="Enter a valid income";frmRegister.annualIncome.focus();return false;

 	} else { document.getElementById('amountspan').innerHTML=""; }

	if (!(IsEmpty(document.frmRegister.annualIncome,'text'))) {

		if(!ValidateNo(document.frmRegister.annualIncome.value,'1234567890 ,.'))
		{document.getElementById('amountspan').innerHTML="Enter a valid income";frmRegister.annualIncome.focus();return false;}	
		else { document.getElementById('amountspan').innerHTML=""; }
	}
}

if ( parseInt( frmRegister.country.options[frmRegister.country.selectedIndex].value ) == 0 || frmRegister.country.options[frmRegister.country.selectedIndex].value=="" )
{
	document.getElementById('clspan').innerHTML="Select the country of living of the prospect";frmRegister.country.focus( );return false;}
else{document.getElementById('clspan').innerHTML="";}

var countryId;
countryId = document.frmRegister.country.options[document.frmRegister.country.selectedIndex].value;
if (countryId!=98) {

		if (document.frmRegister.citizenship.options[document.frmRegister.citizenship.selectedIndex].value==0) {

			document.getElementById('citispan').innerHTML="Select the citizenship of the prospect";
			document.frmRegister.citizenship.focus();
			return false;

		} else { document.getElementById('citispan').innerHTML=""; }
}



//var cId = document.frmRegister.country.options[document.frmRegister.country.selectedIndex].value;

if (countryId==98 || countryId==222) {
	if (frmRegister.residingState.selectedIndex==0) {
		document.getElementById('residingstatespan').innerHTML="Select the residing state of the prospect";
		document.frmRegister.residingState.focus();
		return false;
	} else{ document.getElementById('residingstatespan').innerHTML=""; }

} else {
		if (IsEmpty(document.frmRegister.residingState,'text')){
			document.getElementById('residingstatespan').innerHTML="Enter the residing state of the prospect";
			document.frmRegister.residingState.focus();
			return false;
		} else { document.getElementById('residingstatespan').innerHTML=""; }
}


if (countryId==98) {
	if (frmRegister.residingCity.selectedIndex==0) {
		document.getElementById('residingcityspan').innerHTML="Select the residing city of the prospect";
		frmRegister.residingCity.focus();
		return false;
	} else{ document.getElementById('residingcityspan').innerHTML=""; }

} else {
		if (IsEmpty(document.frmRegister.residingCity,'text')){
			document.getElementById('residingcityspan').innerHTML="Enter the residing city of the prospect";
			frmRegister.residingCity.focus();
			return false;
		} else { document.getElementById('residingcityspan').innerHTML=""; }
}

// Check E-mail
if (IsEmpty(document.frmRegister.email,"text")) {
	document.getElementById('emailspan').innerHTML="Enter a valid e-mail address";
	frmRegister.email.focus();return false; 
} else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(document.frmRegister.email.value))) {
	document.getElementById('emailspan').innerHTML="Enter a valid e-mail address";
	frmRegister.email.focus();
	return false;
} else if(document.frmRegister.emaildup.value=='1') {
	frmRegister.email.focus();return false;
} else {
	document.getElementById('emailspan').innerHTML="";
}

if(!ValidateNo(document.frmRegister.countryCode.value,'1234567890')) {
  document.frmRegister.countryCode.value="ISD";
}
if(!ValidateNo(document.frmRegister.areaCode.value,'1234567890')) {
  document.frmRegister.areaCode.value="STD";
}
if(!ValidateNo(document.frmRegister.phoneNo.value,'1234567890')) {
  document.frmRegister.phoneNo.value="Telephone number";
}
if(!ValidateNo(document.frmRegister.mobileNo.value,'1234567890')) {
  document.frmRegister.mobileNo.value="Mobile number";
}

//Phone validation
if((IsEmpty(document.frmRegister.countryCode,'text') && IsEmpty(document.frmRegister.areaCode,'text') && IsEmpty(document.frmRegister.phoneNo,'text') && IsEmpty(document.frmRegister.mobileNo,'text')) || (
	document.frmRegister.countryCode.value=="ISD" && document.frmRegister.areaCode.value=="STD" && document.frmRegister.phoneNo.value=="Telephone number" &&  document.frmRegister.mobileNo.value=="Mobile number"))
	{document.getElementById('phonespan').innerHTML="Enter the phone or mobile number";
	document.frmRegister.phoneNo.focus();
	return false; }
	else{document.getElementById('phonespan').innerHTML="";}

if ((IsEmpty(document.frmRegister.phoneNo,'text') || document.frmRegister.phoneNo.value=="Telephone number")  && (IsEmpty(document.frmRegister.mobileNo,'text') || document.frmRegister.mobileNo.value=="Mobile number"))
{
	document.getElementById('phonespan').innerHTML="Enter the contact number";document.frmRegister.phoneNo.focus();return false;}
else{document.getElementById('phonespan').innerHTML="";}

if (!(IsEmpty(document.frmRegister.countryCode,'text')))
{
	if (!ValidateNo(document.frmRegister.countryCode.value,'1234567890'))
	{
		document.getElementById('phonespan').innerHTML="Enter a valid country code";
		document.frmRegister.countryCode.focus();return false;}
	else{document.getElementById('phonespan').innerHTML="";}
}

if (!IsEmpty(document.frmRegister.phoneNo,'text') && document.frmRegister.phoneNo.value!="" && document.frmRegister.phoneNo.value!="Telephone number")
{
	if (IsEmpty(document.frmRegister.countryCode,'text') || document.frmRegister.countryCode.value=="ISD" || document.frmRegister.countryCode.value=="")
	{
		document.getElementById('phonespan').innerHTML="Enter the country code";document.frmRegister.countryCode.focus();return false;}
	else{document.getElementById('phonespan').innerHTML="";}
			
	//if (IsEmpty(document.frmRegister.areaCode,'text') || document.frmRegister.areaCode.value=="STD" || document.frmRegister.areaCode.value=="")
	if((document.frmRegister.areaCode.value=="STD" || document.frmRegister.areaCode.value=="") && (document.frmRegister.mobileNo.value=="Mobile number" || document.frmRegister.mobileNo.value==""))
	{
		document.getElementById('phonespan').innerHTML="Enter area / STD code";
		document.frmRegister.areaCode.focus();
		return false;}
	else{document.getElementById('phonespan').innerHTML="";}
}

if (!IsEmpty(document.frmRegister.mobileNo,'text') && document.frmRegister.mobileNo.value!="" && document.frmRegister.mobileNo.value!="Mobile number")
{
	if (IsEmpty(document.frmRegister.countryCode,'text') || document.frmRegister.countryCode.value=="ISD" || document.frmRegister.countryCode.value=="")
	{
		document.getElementById('phonespan').innerHTML="Enter the country code";document.frmRegister.countryCode.focus();return false;}
	else{document.getElementById('phonespan').innerHTML="";}
}

if (frmRegister.motherTongue.selectedIndex==0)
{document.getElementById('mothertonguespan').innerHTML="Select the mother tongue of the prospect";frmRegister.motherTongue.focus();return false;}	
else{document.getElementById('mothertonguespan').innerHTML="";}

if (frmRegister.familyValue.selectedIndex==0)
{document.getElementById('familyvaluespan').innerHTML="Select the family value of the prospect";frmRegister.familyValue.focus();return false;}	
else{document.getElementById('familyvaluespan').innerHTML="";}


if (frmRegister.familyType.selectedIndex==0)
{document.getElementById('familytypespan').innerHTML="Select the family type of the prospect";frmRegister.familyType.focus();return false;}	
else{document.getElementById('familytypespan').innerHTML="";}

if (frmRegister.familyStatus.selectedIndex==0)
{document.getElementById('familystatusspan').innerHTML="Select the family status of the prospect";frmRegister.familyStatus.focus();return false;}	
else{document.getElementById('familystatusspan').innerHTML="";}


if (frmRegister.familyStatus.selectedIndex==0)
{document.getElementById('familystatusspan').innerHTML="Select the family status of the prospect";frmRegister.familyStatus.focus();return false;}	
else{document.getElementById('familystatusspan').innerHTML="";}

if(IsEmpty(document.frmRegister.password,"password")) {
	document.getElementById('passwdspan').innerHTML="Enter your password";frmRegister.password.focus();return false;}
else{document.getElementById('passwdspan').innerHTML="";}

if ( frmRegister.password.value.length < 4 ) {
	document.getElementById('passwdspan').innerHTML="Password must have a minimum of 4 characters";frmRegister.password.focus( );return false;}
else{document.getElementById('passwdspan').innerHTML="";}

var pwd1=frmRegister.password.value;
pwd1=pwd1.toUpperCase()
var una=frmRegister.name.value
una=una.toUpperCase()

if (pwd1 == una)
{
	document.getElementById('passwdspan').innerHTML="The name and password cannot be the same.  change the password";frmRegister.password.focus();return false;}
else{document.getElementById('passwdspan').innerHTML="";}

tmpPass = frmRegister.password.value;
goodPasswd = 1;

for( var idx=0; idx< tmpPass.length; idx++ )
{
	ch = tmpPass.charAt(idx);
	if( !((ch>='a') && (ch<='z')) && !((ch>='A') && (ch<='Z')) && !((ch>=0) && (ch <=9)) )
	{goodPasswd = 0;break;}
}

if ( goodPasswd ==0 )
{
	document.getElementById('passwdspan').innerHTML="Spaces or special characters are not allowed in the password";frmRegister.password.focus();return false;}
else{document.getElementById('passwdspan').innerHTML="";}

if(IsEmpty(document.frmRegister.password,"password"))
{
	document.getElementById('passwdspan').innerHTML="Enter your password";frmRegister.password.focus( );return false;}
else{document.getElementById('passwdspan').innerHTML="";}

if(IsEmpty(document.frmRegister.confirmPassword,"password"))
{
	document.getElementById('cpasswdspan').innerHTML=" confirm your password";frmRegister.confirmPassword.focus();return false;}
else{document.getElementById('cpasswdspan').innerHTML="";}

if ( frmRegister.password.value != frmRegister.confirmPassword.value )
{	document.getElementById('cpasswdspan').innerHTML="Sorry, both the passwords do not match";frmRegister.confirmPassword.focus( );return false;}
else{document.getElementById('cpasswdspan').innerHTML="";}



	document.frmRegister.description.value=document.getElementById('description1').value;
	if (nullchk(document.frmRegister.description.value)) {
		document.getElementById('aboutmyselfspan').innerHTML="Enter a profile description in not less than 50 characters";
		//document.frmRegister.description.focus();
		document.frmRegister.DESCDET.focus();
		return false;
	} else { document.getElementById('aboutmyselfspan').innerHTML=""; }

	if (document.frmRegister.description.value=="") {
		document.getElementById('aboutmyselfspan').innerHTML="Enter a profile description in not less than 50 characters";
				//document.frmRegister.description.focus();
				document.frmRegister.DESCDET.focus();
		return false;
	} else { document.getElementById('aboutmyselfspan').innerHTML=""; }
	var desc=document.getElementById('description1').value;
	if (desc.length<50) {
		document.getElementById('aboutmyselfspan').innerHTML="Enter a profile description in not less than 50 characters";
		//document.frmRegister.description.focus();
		document.frmRegister.DESCDET.focus();
		return false;
	} else { document.getElementById('aboutmyselfspan').innerHTML=""; }

if (IsEmpty(document.frmRegister.aboutMyPartner,'text')) {
	document.getElementById('aboutmypartnerspan').innerHTML="Enter partner details of the prospect";frmRegister.aboutMyPartner.focus();return false;
	} else { document.getElementById('aboutmypartnerspan').innerHTML=""; }


if (IsEmpty(document.frmRegister.getMarried,"radio")) {
	document.getElementById('getmarriedspan').innerHTML="Select the how soon you want to get married of the prospect";
	frmRegister.getMarried[0].focus();
	return false;
} else{document.getElementById('getmarriedspan').innerHTML="";}

if(!document.frmRegister.termsAndConditions.checked)
{
	document.getElementById('termsspan').innerHTML="Accept the terms and conditions to proceed further";frmRegister.termsAndConditions.focus();return false;}
else{document.getElementById('termsspan').innerHTML="";}

	if (communityId==0) {
		var mainDomain = document.frmRegister.domainName.value;
		document.frmRegister.action='http://www.'+mainDomain+'/register/index.php?act=addedbasic';
	}

	return true;
}

function nameChk() {
	var frmRegister = this.document.frmRegister;
	if (IsEmpty(document.frmRegister.nickName,"text")) {
		document.getElementById('nicknamespan').innerHTML="Enter the display name of the prospect";
		//document.frmRegister.nickName.focus();
		return;
	} else { document.getElementById('nicknamespan').innerHTML=""; }
}

function ageChk() {
	
	genderChk();

	var frmRegister = this.document.frmRegister;
	if (IsEmpty(document.frmRegister.age,"text") && (document.frmRegister.dobMonth.options[document.frmRegister.dobMonth.selectedIndex].text=="-Month-" && document.frmRegister.dobDay.options[document.frmRegister.dobDay.selectedIndex].text=="-Date-" && document.frmRegister.dobYear.options[document.frmRegister.dobYear.selectedIndex].text=="-Year-")) {
		document.getElementById('agespan').innerHTML="Enter the age or select the date of birth of the prospect";
		frmRegister.age.value="";
		return;
	} else {
		document.getElementById('agespan').innerHTML="";
	}

	if (IsEmpty(document.frmRegister.age,"text")) {
		if (document.frmRegister.dobMonth.options[document.frmRegister.dobMonth.selectedIndex].text=="-Month-") {
			document.getElementById('agespan').innerHTML="Select month";
			return;
		} else {
			document.getElementById('agespan').innerHTML="";
		}

		if (document.frmRegister.dobDay.options[document.frmRegister.dobDay.selectedIndex].text=="-Date-") {
			document.getElementById('agespan').innerHTML="Select date";
			return;
		} else {
			document.getElementById('agespan').innerHTML="";
		}

		if (document.frmRegister.dobYear.value=="0") {
			document.getElementById('agespan').innerHTML="Select year";
			return;
		} else {
			document.getElementById('agespan').innerHTML="";
		}
	}

	var age = parseInt( frmRegister.age.value );

	if ( !ValidateNo( frmRegister.age.value, "0123456789" ) ) {
		document.getElementById('agespan').innerHTML="Enter a valid age";
		return;
	} else {
		document.getElementById('agespan').innerHTML="";
	}

	var calyear = displayage(frmRegister.dobYear.value,frmRegister.dobMonth.value,frmRegister.dobDay.value, 'years', 0, 'rounddown')

	if (frmRegister.age.value<startMaleAge && frmRegister.gender[0].checked && !(frmRegister.age.value=="")) {
		document.getElementById('agespan').innerHTML="Prospect should be "+startMaleAge+" years to register";
		return;
	} else {
		document.getElementById('agespan').innerHTML="";
	}

	if (frmRegister.age.value=="" && calyear < startMaleAge && frmRegister.gender[0].checked) {
		document.getElementById('agespan').innerHTML="Prospect should be "+startMaleAge+" years to register";
		return;
	} else {
		document.getElementById('agespan').innerHTML="";
	}

	if (frmRegister.age.value < startFemaleAge && frmRegister.gender[1].checked && !(frmRegister.age.value=="")) {
		document.getElementById('agespan').innerHTML="Prospect should be "+startFemaleAge+" years to register";
		return;
	} else {
		document.getElementById('agespan').innerHTML="";
	}

	if (frmRegister.age.value=="" && calyear < startFemaleAge && frmRegister.gender[1].checked) {
		document.getElementById('agespan').innerHTML="Prospect Should be "+startFemaleAge+" years to Register";
		return;
	} else {
		document.getElementById('agespan').innerHTML="";
	}

	if ( age > 70 && calyear > 70) {
		document.getElementById('agespan').innerHTML="Maximum age allowed is 70";
		return;
	} else {
		document.getElementById('agespan').innerHTML="";
	}
    
}

function genderChk() {
	var frmRegister = this.document.frmRegister;
	if (!frmRegister.gender[0].checked && !frmRegister.gender[1].checked) {
		document.getElementById('genderspan').innerHTML="Select the gender of the prospect";
		return;
	} else if (frmRegister.gender[0].checked || frmRegister.gender[1].checked) {
		document.getElementById('genderspan').innerHTML="";
	}
}

function isMaleChk() {
	var communityId = document.frmRegister.communityId.value;
	var MaritalCnt = document.frmRegister.MaritalCnt.value;
	var frmRegister = this.document.frmRegister;
	ageChk();
	
	if(communityId == 2503 || communityId == 2006) {
	  for(i=0; i<MaritalCnt; i++) {
       if(communityId == 2503) {
	     if(document.frmRegister.gender[1].checked == true) {
		  if(document.frmRegister.maritalStatus[i].value == 5 ){
		    document.frmRegister.maritalStatus[i].checked = false;
		    document.frmRegister.maritalStatus[i].disabled = true;
		  }
		  else if(document.frmRegister.maritalStatus[i].value== 6) {
		    document.frmRegister.maritalStatus[i].checked = false;
		    document.frmRegister.maritalStatus[i].disabled = true;
		  }
	     }
	     else {
		    document.frmRegister.maritalStatus[i].disabled = false;
	     }
	   }
	   if(communityId == 2006) {
	     if(document.frmRegister.gender[0].checked == true) {
		  if(document.frmRegister.maritalStatus[i].value == 5 ){
		    document.frmRegister.maritalStatus[i].checked = false;
		    document.frmRegister.maritalStatus[i].disabled = true;
		  }
		  else if(document.frmRegister.maritalStatus[i].value== 6) {
		    document.frmRegister.maritalStatus[i].checked = false;
		    document.frmRegister.maritalStatus[i].disabled = true;
		  }
	     }
	     else {
		    document.frmRegister.maritalStatus[i].disabled = false;
	     }
	   }
	 }
	}

	/*if(MaritalCnt>4) {
		if(document.frmRegister.gender[1].checked == true) {
			document.frmRegister.maritalStatus[4].checked = false;
			document.frmRegister.maritalStatus[4].disabled = true;
		} else {
			document.frmRegister.maritalStatus[4].disabled = false;
		}
	}*/
}

function maritalChk() {
	var frmRegister = this.document.frmRegister;
	if ( IsEmpty(document.frmRegister.maritalStatus,'radio')) {
		document.getElementById('maritalspan').innerHTML="Select the marital status of the prospect";
		return;
	} else {
		document.getElementById('maritalspan').innerHTML="";
	}
}

function displayCStatus() {
	var frmRegister = this.document.frmRegister;
	if(getSelectedRadioValue(frmRegister.maritalStatus) == 1) {
		document.getElementById('cstatus').style.display='none';
		document.getElementById('childliving').style.display='none';
	} else {
		document.getElementById('cstatus').style.display='block';
		document.getElementById('childliving').style.display='block';
	}
}

function childChk() {
	var frmRegister = this.document.frmRegister;

	if((document.frmRegister.domainRegister.value=='divorceematrimony.com') || (document.frmRegister.communityId.value=='2001')) {

		if (document.frmRegister.noOfChildren.options[document.frmRegister.noOfChildren.selectedIndex].value=="") {
			document.getElementById('nocspan').innerHTML="Select the number of children"; 
			return;
		} else if (document.frmRegister.noOfChildren.options[document.frmRegister.noOfChildren.selectedIndex].value=="0") {
			
			document.frmRegister.childrenLivingWithMe[0].disabled=true;
			document.frmRegister.childrenLivingWithMe[1].disabled=true;
			document.getElementById('nocspan').innerHTML="";

		} else { 
			document.frmRegister.childrenLivingWithMe[0].disabled=false;		
			document.frmRegister.childrenLivingWithMe[1].disabled=false;
			document.getElementById('nocspan').innerHTML="";
		}
	
	} else if ( !(document.frmRegister.maritalStatus[0].checked) && frmRegister.noOfChildren.selectedIndex == 0 ) {
		document.getElementById('nocspan').innerHTML="Select the number of children";
		return;
	} else {
		document.getElementById('nocspan').innerHTML=" ";
	}

}

function childstatusChk() {
	var frmRegister = this.document.frmRegister;

	if (((document.frmRegister.domainRegister.value=='divorceematrimony.com') || (document.frmRegister.communityId.value=='2001')) && document.frmRegister.noOfChildren.options[document.frmRegister.noOfChildren.selectedIndex].value >= 1) {

		if (!frmRegister.childrenLivingWithMe[0].checked && !frmRegister.childrenLivingWithMe[1].checked) {

			document.getElementById('clsspan').innerHTML="indicate whether the child/children is/are living with you";
			return;
		} else { document.getElementById('clsspan').innerHTML=""; }

	} else if ( !(document.frmRegister.maritalStatus[0].checked) && document.frmRegister.noOfChildren.options[document.frmRegister.noOfChildren.selectedIndex].value >= 1 && !frmRegister.childrenLivingWithMe[0].checked && !frmRegister.childrenLivingWithMe[1].checked) {
		document.getElementById('clsspan').innerHTML="indicate whether the child/children is/are living with you";
		return;
	} else { document.getElementById('clsspan').innerHTML=""; }
}

function othsubcasteChk(){
	var frmRegister = this.document.frmRegister;
	if (frmRegister.subCasteOthers.value=='' && (isSubcasteMandatory == 1)) {
		document.getElementById('subcastespan').innerHTML="Enter the "+document.frmRegister.subcastelabel.value+" of the prospect";
		return;
	} else {
		document.getElementById('subcastespan').innerHTML=" ";
	}
}

function othgothramChk(){
	var frmRegister = this.document.frmRegister;
	if (frmRegister.gothramOthers.value=='') {
		document.getElementById('gothraspan').innerHTML="Enter the gothram of the prospect";
		return;
	} else {
		document.getElementById('gothraspan').innerHTML=" ";
	}
}

function denominationChk() {

	var frmRegister = this.document.frmRegister;
	
	if (parseInt(frmRegister.denominationfeature.value)==1 && parseInt(frmRegister.denominationOption.value)>1 ) {
		if (parseInt(frmRegister.denomination.options[frmRegister.denomination.selectedIndex].value)== 0) {
			document.getElementById('denominationspan').innerHTML="Select the "+frmRegister.denominationlabel.value+" of the prospect";
			return false;
		}
		else if(parseInt(frmRegister.denomination.options[frmRegister.denomination.selectedIndex].value) == 9997) {
			if(frmRegister.denominationText.value == '') {
			document.getElementById('denominationspan').innerHTML="Enter the "+frmRegister.denominationlabel.value+" of the prospect";
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
	var frmRegister = this.document.frmRegister;
	if (parseInt(frmRegister.religiousfeature.value)==1 && parseInt(frmRegister.religiousOption.value)>1 ) {
		if (parseInt(frmRegister.religious.options[frmRegister.religious.selectedIndex].value)== 0) {
			document.getElementById('religiousspan').innerHTML="Select the religious values of the prospect";
			return false;
		} else {
			document.getElementById('religiousspan').innerHTML='';
		}

	}
}

function ethnicityChk() {
	var frmRegister = this.document.frmRegister;
	if (parseInt(frmRegister.ethinicityfeature.value)==1 && parseInt(frmRegister.ethnicityOption.value)>1 ) {
		if (parseInt(frmRegister.ethnicity.options[frmRegister.ethnicity.selectedIndex].value)== 0) {
			document.getElementById('ethnicityspan').innerHTML="Select the ethnicity of the prospect";
			return false;
		} else {
			document.getElementById('ethnicityspan').innerHTML='';
		}

	}
}

function religionChk() {
	var frmRegister = this.document.frmRegister;
	if(document.getElementById('casteDivText') != null) {
	  document.getElementById('casteDivText').style.display='none';
	}
	if (parseInt(frmRegister.religionfeature.value)==1 && parseInt(frmRegister.religionOption.value)>1 ) {
		if (parseInt(frmRegister.religion.options[frmRegister.religion.selectedIndex].value)== 0) {
			document.getElementById('religionspan').innerHTML="Select the religion of the prospect";
			return;
		} else {
			var selectedReligion = parseInt(frmRegister.religion.options[frmRegister.religion.selectedIndex].value);
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

	if (parseInt(document.frmRegister.castefeature.value)==1) {
		
	if (parseInt(document.frmRegister.casteOption.value)==1) {} else {
		
		if (parseInt(document.frmRegister.casteOption.value)>1) {
           
		    var casteId = parseInt(document.frmRegister.caste.options[document.frmRegister.caste.selectedIndex].value);
		    
			if (casteId == 0) {
			  document.getElementById('castespan').innerHTML="Select the "+document.frmRegister.castelabel.value+" of the prospect";
			  return;
			}
			else if(casteId == 9997) {
			  if (document.frmRegister.casteOthers.value=="") {
					document.getElementById('castespan').innerHTML="Enter the "+document.frmRegister.castelabel.value+" of the prospect";
					//document.frmRegister.casteOthers.focus();
					return;
			  }
			  else { document.getElementById('castespan').innerHTML=''; }
			}
			else { document.getElementById('castespan').innerHTML=''; }

		} else {

var validateSubCaste='yes';

		if ((document.frmRegister.domainRegister.value=='divorceematrimony.com') || (document.frmRegister.communityId.value=='2001')) {
			var religionId	= document.frmRegister.religion.options[document.frmRegister.religion.selectedIndex].value;
			if ((religionId=='8') || (religionId=='9')) { validateSubCaste = 'no'; }
		}

			if (validateSubCaste=='yes') {
				//if (IsEmpty(document.frmRegister.casteText.value,'text')) {
				  if (document.frmRegister.casteText.value == "") {
					document.getElementById('castespan').innerHTML="Enter the "+document.frmRegister.castelabel.value+" of the prospect";
					return;
				} else { document.getElementById('castespan').innerHTML=''; }

			}


		}
	}

	}



	/*if (parseInt(frmRegister.castefeature.value)==1) {
		if (parseInt(frmRegister.casteOption.value)==1) {

			if (IsEmpty(frmRegister.casteText.value,'text')) {
				document.getElementById('castespan').innerHTML="Enter the caste of the prospect";
				return;
			} else { document.getElementById('castespan').innerHTML=''; }

		} else {
			if (parseInt(frmRegister.caste.options[frmRegister.caste.selectedIndex].value)== 0) {
			document.getElementById('castespan').innerHTML="Select the caste of the prospect";
			return;
			} else { document.getElementById('castespan').innerHTML=''; }
		}

	}*/
}

function casteOthersChk(){
	var casteId =  parseInt(document.frmRegister.caste.options[document.frmRegister.caste.selectedIndex].value);

	if (casteId== 9997) {
		document.getElementById('casteDivText').style.display='block';
		if (document.frmRegister.casteOthers.value=="" && communityId != 2004 ) {
			document.getElementById('castespan').innerHTML="Enter the "+document.frmRegister.castelabel.value+" of the prospect";
			return;

		} else {  document.getElementById('castespan').innerHTML=""; }

	} else { document.getElementById('casteDivText').style.display='none'; }
}

/*
function subcasteChk() {
	if (parseInt(document.frmRegister.subcastefeature.value)==1) { 
		if (parseInt(document.frmRegister.subCasteOption.value)==1) { } else {
			if (parseInt(document.frmRegister.subCasteOption.value)>1) { 

				if (parseInt(document.frmRegister.subCaste.options[document.frmRegister.subCaste.selectedIndex].value)== 0) {
				document.getElementById('subcastespan').innerHTML="Select the subcaste of the prospect";
				return;
				} else { document.getElementById('subcastespan').innerHTML=''; }

			} else {

				if (document.frmRegister.subCasteText.value=="") { 
					document.getElementById('subcastespan').innerHTML="Enter the subcaste of the prospect";
					return;
				} else { document.getElementById('subcastespan').innerHTML=''; }

			}
		}
	}
}*/

function subcasteChk(){
  
  if(document.frmRegister.subCasteOthers != 'undefined') {
     document.frmRegister.subCasteOthers.value ='';
  }
	if (parseInt(document.frmRegister.subcastefeature.value)==1) { 
		if (parseInt(document.frmRegister.subCasteOption.value)==1) { } else {
			if (parseInt(document.frmRegister.subCasteOption.value)>1) { 
				var subCasteId = parseInt(document.frmRegister.subCaste.options[document.frmRegister.subCaste.selectedIndex].value);
				document.getElementById("subCasteDivText").style.display="none";
				if (subCasteId== 0 && (isSubcasteMandatory == 1) ) {
					document.getElementById("subCasteDivText").style.display="none";
					document.getElementById('subcastespan').innerHTML="Select the "+document.frmRegister.subcastelabel.value+" of the prospect";
					//document.frmRegister.subCaste.focus();
					return;
				} else if (subCasteId==9997) {
					document.getElementById("subCasteDivText").style.display="block";
					if (document.frmRegister.subCasteOthers.value=="" && (isSubcasteMandatory == 1)) {
						document.getElementById('subcastespan').innerHTML="Enter the "+document.frmRegister.subcastelabel.value+" of the prospect";
						//document.frmRegister.subCasteOthers.focus();
						return;
					} else { document.getElementById('subcastespan').innerHTML=''; }
				} else { document.getElementById('subcastespan').innerHTML=''; }

			} else {

				if (document.frmRegister.subCasteText.value=="" && (isSubcasteMandatory == 1)) { 
					document.getElementById('subcastespan').innerHTML="Enter the "+document.frmRegister.subcastelabel.value+" of the prospect";
					//document.frmRegister.subCasteText.focus();
					return;
				} else { document.getElementById('subcastespan').innerHTML=''; }

			}
		}
	}
}//subcasteChk


function countryChk() {
	var frmRegister = this.document.frmRegister;

	var countryId	= parseInt(frmRegister.country.options[frmRegister.country.selectedIndex].value);
	if ( countryId == 0 || countryId=="" ) {
		document.getElementById('clspan').innerHTML="Select the country of living of the prospect";
		return;

	} else { document.getElementById('clspan').innerHTML=""; }
	if (countryId != 98) {
			document.getElementById('showCitizenship').style.display="block";
	} else { document.getElementById('showCitizenship').style.display="none"; }

	makerequest(document.frmRegister.country.options[document.frmRegister.country.selectedIndex].value);
}

function residingChk() {
	var frmRegister = this.document.frmRegister;
	if ( IsEmpty(document.frmRegister.residentStatus,'radio')) {
		document.getElementById('resspan').innerHTML="Select the resident status of the prospect";
		return;
	} else {
		document.getElementById('resspan').innerHTML=" ";
	}
}

function employedInChk() {
	var frmRegister = this.document.frmRegister;
	if ( !frmRegister.employmentCategory[0].checked && !frmRegister.employmentCategory[1].checked && !frmRegister.employmentCategory[2].checked && !frmRegister.employmentCategory[3].checked && !frmRegister.employmentCategory[4].checked) {
		document.getElementById('empspan').innerHTML="Select the employment status";
		return;
	} else {
		document.getElementById('empspan').innerHTML=" ";
	}
}

function conchk() {
	/*alert(document.frmRegister.countryCode.value)
	alert(document.frmRegister.areaCode.value)
	alert(document.frmRegister.phoneNo.value)
	alert(document.frmRegister.mobileNo.value)*/

	if((document.frmRegister.countryCode.value=="ISD" || document.frmRegister.countryCode.value=="" || !ValidateNo(document.frmRegister.countryCode.value,'1234567890')) && (document.frmRegister.areaCode.value=="STD" || document.frmRegister.areaCode.value=="" || !ValidateNo(document.frmRegister.areaCode.value,'1234567890')) && (document.frmRegister.phoneNo.value=="Telephone number" || document.frmRegister.phoneNo.value=="" || !ValidateNo(document.frmRegister.phoneNo.value,'1234567890')) &&  (document.frmRegister.mobileNo.value=="Mobile number" || document.frmRegister.mobileNo.value=="" || !ValidateNo(document.frmRegister.mobileNo.value,'1234567890')))
	{document.getElementById('phonespan').innerHTML="Enter the phone or mobile number";return; }

	else if(document.frmRegister.countryCode.value=="ISD" || document.frmRegister.countryCode.value=="" || !ValidateNo(document.frmRegister.countryCode.value,'1234567890')) {

		document.getElementById('phonespan').innerHTML="Enter the ISD number";
		//document.frmRegister.countryCode.focus();
		return;

	} else if((document.frmRegister.areaCode.value=="STD" || document.frmRegister.areaCode.value=="" || !ValidateNo(document.frmRegister.areaCode.value,'1234567890')) && (document.frmRegister.mobileNo.value=="Mobile number" || document.frmRegister.mobileNo.value=="" || !ValidateNo(document.frmRegister.mobileNo.value,'1234567890'))) {

		document.getElementById('phonespan').innerHTML="Enter area / STD code";
		//document.frmRegister.areaCode.focus();
		return;

	}  else if((document.frmRegister.phoneNo.value=="Telephone number" || document.frmRegister.phoneNo.value=="" || !ValidateNo(document.frmRegister.phoneNo.value,'1234567890')) && (document.frmRegister.mobileNo.value=="Mobile number" || document.frmRegister.mobileNo.value=="" || !ValidateNo(document.frmRegister.mobileNo.value,'1234567890'))) {

		document.getElementById('phonespan').innerHTML="Enter the phone or mobile number";
		//document.frmRegister.phoneNo.focus();
		return;

	} else { document.getElementById('phonespan').innerHTML=""; }
}//conchk

function emailChk() {
	var frmRegister = this.document.frmRegister;
	// Check E-mail
	if (IsEmpty(document.frmRegister.email,"text")) {
		document.getElementById('emailspan').innerHTML="Enter a valid e-mail address";
		//document.frmRegister.email.focus();
		return false;
	} else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(document.frmRegister.email.value))) {
		document.getElementById('emailspan').innerHTML="Enter a valid e-mail address";
		//document.frmRegister.email.focus();
		return false;
	} else {
		document.getElementById('emailspan').innerHTML="";
		var evalue = document.frmRegister.email.value;
		if(evalue != '') { makerequestEmailCheck(evalue); }//if

		/*if(prevemail != evalue) {
			prevemail = evalue;
			makerequestEmailCheck(evalue);
		}*/
	}
}

var email_request;//=false;
function makerequestEmailCheck(evalue)
{
	var communityId = document.frmRegister.communityId.value;
	if(communityId == 0) {
      var selectedDomain = document.frmRegister.domainName.value;
	}
	if(communityId != 0 || selectedDomain != "0") {
	var urltoget = "../register/checkemail.php?varemail="+evalue+"&varSelectedDomain="+selectedDomain;

	 email_request = AjaxCall();
	  if (email_request)
	  {
		email_request.open("GET", urltoget, true);
		email_request.onreadystatechange = processResponseEmailCheck;
		email_request.send(null);
	  }
	}
	else {
	 // nothing //
	}
}


function processResponseEmailCheck() 
{
  if (email_request.readyState == 4)
  {
    if(email_request.status == 200) {
	 var msg=0;	
	 msg = email_request.responseText;
	 arrMsg = msg.split('^');
		if(arrMsg[0] == 'yes')
		{
			document.getElementById("emailspan").innerHTML="Email ID exists in the blocked E-mail list. Your computer IP address has been logged.";
			document.frmRegister.emaildup.value=1;
			document.frmRegister.email.focus();
		}
		else if(arrMsg[0] > 0) {
			document.getElementById("emailspan").innerHTML="You have already registered on "+productname+".com using the same e-mail ID.";
			document.frmRegister.emaildup.value=1;
			document.frmRegister.email.focus();
		} else { 
			document.frmRegister.emaildup.value=0;
			document.getElementById("emailspan").innerHTML="";
		}
	} else {
		document.getElementById("emailspan").innerHTML="<img src='"+appImgsPath+"/loading-icon.gif' />"; 
	}
 }
 else {
   document.getElementById("emailspan").innerHTML="<img src='"+appImgsPath+"/loading-icon.gif' />";
 }
}

function passwordChk() {
	var frmRegister = this.document.frmRegister;

	if (IsEmpty(document.frmRegister.password,"password")) {
		document.getElementById('passwdspan').innerHTML="Enter your password";
		return;
	} else {
		document.getElementById('passwdspan').innerHTML=" ";
	}


	if ( frmRegister.password.value.length < 4 ) {
		document.getElementById('passwdspan').innerHTML="Your password must have a minimum of 4 characters";
		return;
	} else {
		document.getElementById('passwdspan').innerHTML=" ";
	}

	var pwd1=frmRegister.password.value;
	pwd1=pwd1.toUpperCase()
	var una=frmRegister.name.value
	una=una.toUpperCase()

	if (pwd1 == una) {
		document.getElementById('passwdspan').innerHTML="The name and password cannot be the same. Please change the password.";
		return false;
	} else {
		document.getElementById('passwdspan').innerHTML=" ";
	}

	tmpPass = frmRegister.password.value;
	goodPasswd = 1;

	for ( var idx=0; idx< tmpPass.length; idx++ ) {
		ch = tmpPass.charAt(idx);
		if ( !((ch>='a') && (ch<='z')) && !((ch>='A') && (ch<='Z')) && !((ch>=0) && (ch <=9)) ) 
			{goodPasswd = 0;break;}
	}

	if ( goodPasswd ==0 ) {
		document.getElementById('passwdspan').innerHTML="Spaces or special characters are not allowed in the password";
		return;
	} else {
		document.getElementById('passwdspan').innerHTML=" ";
	}
}
function passwordCChk() {
	var frmRegister = this.document.frmRegister;

	if (IsEmpty(document.frmRegister.confirmPassword,"password")) {
		document.getElementById('cpasswdspan').innerHTML=" confirm your password";
		return;
	} else {
		document.getElementById('cpasswdspan').innerHTML=" ";
	}

	if ( frmRegister.password.value != frmRegister.confirmPassword.value ) {
		document.getElementById('cpasswdspan').innerHTML="Sorry, both the passwords do not match";
		return;
	} else {
		document.getElementById('cpasswdspan').innerHTML=" ";
	}

}

function citizen_chk() {

	var countryId = document.frmRegister.country.options[document.frmRegister.country.selectedIndex].value;

	if (countryId!=98) {

		if (document.frmRegister.citizenship.options[document.frmRegister.citizenship.selectedIndex].value==0) {

			document.getElementById('citispan').innerHTML="Select the citizenship of the prospect";

		} else { document.getElementById('citispan').innerHTML=""; }
	}
}//citizen_chk

var ccode_request=false;
function makerequest(cvalue)
{
	if(cvalue>0 && cvalue!=null)
	{
	ccode_request = AjaxCall();
	var url="../register/countrycode.php?country="+cvalue; //Mano
	ccode_request.onreadystatechange = processResponse;
	ccode_request.open('GET', url, true);
	ccode_request.send(null);
	}
}

function processResponse()
{
	if (ccode_request.readyState == 4) 
	{
		if (ccode_request.status == 200) 
		{
			document.frmRegister.countryCode.value=ccode_request.responseText;
		}
	}
}

function termschk()
{
	if(!document.frmRegister.termsAndConditions.checked)
	{document.getElementById('termsspan').innerHTML="Accept the terms and conditions to proceed further ";document.frmRegister.termsAndConditions.focus();return false; }
	else{document.getElementById('termsspan').innerHTML="";}
}
function clearErrorMsg(rowid,spanid)
{
	document.getElementById(spanid).innerHTML='';
}
function clearErrorMsg1(rowid,spanid)
{
	document.getElementById(spanid).innerHTML='';
}
var phoneInterchanged = 0;
function phoneInpAlign(countryValue) {
	if(countryValue == '98'){
		if(phoneInterchanged != 1) {
			var cont1 = document.getElementById('firstContDiv').innerHTML;
			var cont2 = document.getElementById('secContDiv').innerHTML;
			document.getElementById('firstContDiv').innerHTML=cont2;
			document.getElementById('secContDiv').innerHTML=cont1;
			phoneInterchanged =1;
		}
		document.getElementById('areacodelabel').innerHTML='STD';

	} else {
		if(phoneInterchanged == 1) {
			var cont1 = document.getElementById('firstContDiv').innerHTML;
			var cont2 = document.getElementById('secContDiv').innerHTML;
			document.getElementById('firstContDiv').innerHTML=cont2;
			document.getElementById('secContDiv').innerHTML=cont1;
			phoneInterchanged =0;
		}
		document.getElementById('areacodelabel').innerHTML='Area';
	}
}

function regslidemtab(dname, hpscount) {
	for(var i=1; i<=hpscount; i++)
	{
		var divid = "rsdiv"+i;
		var tdivid = "rstab"+i;
		var tdividc = "rstabc"+i;			
		document.getElementById(divid).style.display="none";
		document.getElementById(tdivid).style.display="none";
		document.getElementById(tdividc).style.display="block";		
	}

	for(var i=1; i<=hpscount; i++)
	{
		var divid1 = "rsdiv"+i;
		var tdivid = "rstab"+i;
		var tdividc = "rstabc"+i;
		if(divid1==dname)
		{				
			document.getElementById(dname).style.display = "block";
			document.getElementById(tdivid).style.display = "block";
			document.getElementById(tdividc).style.display = "none";			
		}
	}
}
//validation for addbasic end here


//Validation for addphysical start here
function onCMS()
{
	if (!(document.frmRegister.heightFeet.value=="0"))
	{document.frmRegister.heightFeet.value="0";}
	
	if (!(document.frmRegister.heightCms.value=="0"))
	{document.getElementById('heightspan').innerHTML="";}
}

function cmsleft()
{
	if (document.frmRegister.heightFeet.value=="0" && document.frmRegister.heightCms.value=="0")
	{document.getElementById('heightspan').innerHTML="Select the height of the prospect";return false}
}
	
function onFEET()
{
	if (!(document.frmRegister.heightCms.value=="0"))
	{document.frmRegister.heightCms.value="0";}

	if (!(document.frmRegister.heightFeet.value=="0"))
	{document.getElementById('heightspan').innerHTML="";}		
}
	

function onKGS()
{
	if (!(document.frmRegister.weightLbs.value=="0")){document.frmRegister.weightLbs.value="0";}
}
	
function onLBS()
{
	if (!(document.frmRegister.weightKgs.value=="0")){document.frmRegister.weightKgs.value="0";}		
}

function heightChk(){
	var frmRegister = this.document.frmRegister;
	if (frmRegister.heightFeet.selectedIndex==0) {
		document.getElementById('heightspan').innerHTML="Select the height of the prospect";
		return;
	} else {
		document.getElementById('heightspan').innerHTML="";
	}
}

function educationChk() {
	var frmRegister = this.document.frmRegister;
	if (frmRegister.educationCategory.selectedIndex==0) {
		document.getElementById('educationcategoryspan').innerHTML="Select the education category of the prospect";
		return;
	} else {
		document.getElementById('educationcategoryspan').innerHTML=" ";
	}
}

function otherEducationChk() {
	var frmRegister = this.document.frmRegister;
	if (frmRegister.educationCategory.value==10) {
		if(frmRegister.educationInDetail.value == '') {
			document.getElementById('edudetspan').innerHTML="Enter education in detail";
			return;
		} else {
			document.getElementById('edudetspan').innerHTML=" ";
		}
	}
}


function occupationChk() {
		var frmRegister = document.frmRegister;

		var inCurr = document.frmRegister.annualIncomeCurrency.options[document.frmRegister.annualIncomeCurrency.selectedIndex].value;

		if (inCurr==0) {
			document.getElementById('annualincomespan').innerHTML="Select the currency type";
			return false;
		} else { document.getElementById('annualincomespan').innerHTML=""; }
	
		if (!(IsEmpty(document.frmRegister.annualIncome,'text'))) {

			if(!ValidateNo(document.frmRegister.annualIncome.value,'1234567890 ,.'))
			{document.getElementById('amountspan').innerHTML="Enter a valid income";frmRegister.annualIncome.focus();return false;}	
			else{document.getElementById('amountspan').innerHTML="";}
		}
}

function otherOccupationChk() {
	var frmRegister = this.document.frmRegister;
	if(frmRegister.employmentCategory.value!=4) {
		if (frmRegister.occupation.value==60) {
			if(frmRegister.occupationInDetail.value == '') {
				document.getElementById('occdetspan').innerHTML="Enter occupation in detail";
				return;
			} else {
				document.getElementById('occdetspan').innerHTML="";
			}
		}
	} else if(frmRegister.employmentCategory.value==4) {
		if(frmRegister.occupationInDetail.value == '') {
			document.getElementById('occdetspan').innerHTML="Enter occupation in detail";
			return;
		} else {
			document.getElementById('occdetspan').innerHTML="";
		}
	}
}

function amountChk() {
	var frmRegister = this.document.frmRegister;
	if (!(IsEmpty(document.frmRegister.annualIncome,'text')))
	{
		if (frmRegister.annualIncomeCurrency.selectedIndex==0)
		{document.getElementById('annualincomespan').innerHTML="Select the currency type";return;}	
		else{document.getElementById('annualincomespan').innerHTML=" ";}

		if(!ValidateNo(document.frmRegister.annualIncome.value,'1234567890,.'))
		{document.getElementById('amountspan').innerHTML="Enter a valid income";return;}	
		else{document.getElementById('amountspan').innerHTML=" ";}
	}
}

function motherChk() {
	if (parseInt(document.frmRegister.mothertonguefeature.value)==1) {
		if (parseInt(document.frmRegister.motherTongueOption.value)==1) {

			if (IsEmpty(document.frmRegister.motherTongueText.value,'text')) {
				document.getElementById('mothertonguespan').innerHTML="Enter the mother tongue of the prospect";return;
			} else { document.getElementById('mothertonguespan').innerHTML=''; }

		} else {
			if (parseInt(document.frmRegister.motherTongue.options[document.frmRegister.motherTongue.selectedIndex].value)== 0) {
			document.getElementById('mothertonguespan').innerHTML="Select the mother tongue of the prospect";return;
			} else { document.getElementById('mothertonguespan').innerHTML=''; }
		}
	}
}//motherChk

function residingstateChk() {
	var frmRegister = this.document.frmRegister;
	var cId = document.frmRegister.country.options[document.frmRegister.country.selectedIndex].value;

	if (cId==98 || cId==222) {
		if (frmRegister.residingState.selectedIndex==0) {
			document.getElementById('residingstatespan').innerHTML="Select the residing state of the prospect";return;
		} else{ document.getElementById('residingstatespan').innerHTML=""; }

	} else {
			if (IsEmpty(document.frmRegister.residingState,'text')){
				document.getElementById('residingstatespan').innerHTML="Enter the residing state of the prospect";return;
			} else { document.getElementById('residingstatespan').innerHTML=""; }
	}
}//residingstateChk

function residingcityChk() {
	var frmRegister = this.document.frmRegister;
	var cId = document.frmRegister.country.options[document.frmRegister.country.selectedIndex].value;

	if (cId==98) {
		if (frmRegister.residingCity.selectedIndex==0)
		{document.getElementById('residingcityspan').innerHTML="Select the residing city of the prospect";return;}	
		else{document.getElementById('residingcityspan').innerHTML="";}
	} else {
	if (IsEmpty(document.frmRegister.residingCity,'text'))
	{document.getElementById('residingcityspan').innerHTML="Enter the residing city of the prospect";return;}	
	else{document.getElementById('residingcityspan').innerHTML="";}
	}
}

function descChk() {
	var frmRegister = this.document.frmRegister;
	document.frmRegister.description.value=document.getElementById('description1').value;

	if (nullchk(document.frmRegister.description.value)) {
		document.getElementById('aboutmyselfspan').innerHTML="Enter a profile description in not less than 50 characters";
		return;
	} else {
		document.getElementById('aboutmyselfspan').innerHTML=" ";
	}
	if (document.frmRegister.description.value=="") {
		document.getElementById('aboutmyselfspan').innerHTML="Enter a profile description in not less than 50 characters";
		return;
	} else {
		document.getElementById('aboutmyselfspan').innerHTML=" ";
	}
	var desc=document.getElementById('description1').value;
	if (desc.length<50) {
		document.getElementById('aboutmyselfspan').innerHTML="Enter a profile description in not less than 50 characters";
		return;
	} else {
		document.getElementById('aboutmyselfspan').innerHTML=" ";
	}
}

function chkDomain(){

	var frmRegister = this.document.frmRegister;
	var communityId = document.frmRegister.communityId.value;
    var selectedDomain = document.frmRegister.domainName.value;
    
	if(selectedDomain == "40plusmatrimony.com") {
	  startMaleAge = 40;startFemaleAge = 35;
	}
	else {
	  startMaleAge = 21;startFemaleAge = 18;
	}
	if (communityId==0) {

		if (parseInt(document.frmRegister.domainName.options[document.frmRegister.domainName.selectedIndex].value)== 0) {
			document.getElementById('domainlistspan').innerHTML="Select the domain of the prospect";
		} else { document.getElementById('domainlistspan').innerHTML=''; }
	}//if
}



function createdChk() {
	var frmRegister = this.document.frmRegister;
	if ( IsEmpty(document.frmRegister.profileCreatedBy,'radio')) {
		document.getElementById('profilecreatedbyspan').innerHTML="Select your relationship with the prospect";
	} else { document.getElementById('profilecreatedbyspan').innerHTML=""; }
}

function whats(Name,Width,Height,Scrollbars,tcont,content)
{
	var features = 'status=no left=0 top=0,scrollbars=' + Scrollbars + ',width=' + Width + ',height=' + Height;
	var what=window.open('','', features );
	what.document.write('<html><head><title>'+Name+'</title></head><body style="margin:0px"><table border="0" cellpadding="0" cellspacing="0" style="border:5px solid #F48442"><tr><td valign="top">');
	what.document.write('<div style="padding:5px;line-height:17px"><font style="font-family:verdana;font-size:11px;"><b>'+tcont+':</b><br><br>'+content+'</font></div>');
	what.document.write('<div style="padding:5px;text-align:right"><a href="javascript:window.close();" style="font-family:verdana;font-size:11px;color:#000000">Close</a></div>');
	what.document.write('</td></tr></table></body></html>');
	what.document.close();
}


var ccode_request=false;
function makerequestnew(cvalue)
{
	if(cvalue>0 && cvalue!=null)
	{
	ccode_request = AjaxCall();
	var url="../register/getcities.php?stateid="+cvalue; 
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
	var citysel = document.getElementById('residingCity');
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
			var citysel = document.getElementById('residingCity');
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

//Validation for addphysical end here

	//Validation for addpartner start here

	function childlivingst()
	{	
		var frmRegister = this.document.frmRegister;
		if (frmRegister.lookingStatus[0].checked && frmRegister.lookingStatus[1].checked && frmRegister.lookingStatus[2].checked && frmRegister.lookingStatus[3].checked) {
			document.frmRegister.lookingStatus[4].checked=true;
			document.frmRegister.lookingStatus[0].checked=false;
			document.frmRegister.lookingStatus[1].checked=false;
			document.frmRegister.lookingStatus[2].checked=false;
			document.frmRegister.lookingStatus[3].checked=false;
		} else {
			if (frmRegister.lookingStatus[0].checked || frmRegister.lookingStatus[1].checked || frmRegister.lookingStatus[2].checked || frmRegister.lookingStatus[3].checked) {
				document.frmRegister.lookingStatus[4].checked=false;
			} else {
				document.frmRegister.lookingStatus[0].checked=false;
				document.frmRegister.lookingStatus[1].checked=false;
				document.frmRegister.lookingStatus[2].checked=false;
				document.frmRegister.lookingStatus[3].checked=false;
			}
		}
		getLookingStatusValue(frmRegister);
	}
		
	function childlivingstany()
	{	
		var frmRegister = this.document.frmRegister;
		if ( frmRegister.lookingStatus[4].checked) {
			document.frmRegister.lookingStatus[0].checked=false;					
			document.frmRegister.lookingStatus[1].checked=false;					
			document.frmRegister.lookingStatus[2].checked=false;
			document.frmRegister.lookingStatus[3].checked=false;														
		}
		getLookingStatusValue(frmRegister);
	}

	function getLookingStatusValue(frm)
	{
		var totalValue=""
		for(var i=0; i < frm.lookingStatus.length; i++){
			if(frm.lookingStatus[i].checked)
			totalValue +="~" + frm.lookingStatus[i].value;
			totalValue=totalValue;
		}
		document.frmRegister.lookingStatusValue.value=totalValue;

	}//getLookingStatusValue


	// Function to validate all the inputs
	function addPartnerValidate()
	{		
		var frmRegister = this.document.frmRegister;
		
		var finalAge = frmRegister.toAge.value - frmRegister.fromAge.value;		
		var stAge = 0, endAge = 0;

		if( IsEmpty(document.frmRegister.fromAge,"text"))
		{document.getElementById('partneragespan').innerHTML="Enter the age range of your partner";frmRegister.fromAge.value="";document.getElementById('row222').className="errorrow";frmRegister.fromAge.focus();return false;
		}else{document.getElementById('partneragespan').innerHTML="&nbsp";}

		if( IsEmpty(document.frmRegister.toAge,"text"))
		{document.getElementById('partneragespan').innerHTML="Enter the age range of your partner";frmRegister.toAge.value="";document.getElementById('row222').className="errorrow";frmRegister.toAge.focus();return false;
		}else{document.getElementById('partneragespan').innerHTML="";}
		
		if ( finalAge > 20 )
		{document.getElementById('partneragespan').innerHTML="Age range should not exceed 20";document.getElementById('row222').className="errorrow";frmRegister.toAge.focus();return false;
		}else{document.getElementById('partneragespan').innerHTML="";}
	
		// Check Age 
		if (!ValidateNo( frmRegister.fromAge.value, "0123456789" ) )
		{document.getElementById('partneragespan').innerHTML="Invalid Age " + frmRegister.fromAge.value;document.getElementById('row222').className="errorrow";frmRegister.fromAge.focus();return false;
		}else{document.getElementById('partneragespan').innerHTML="";}

		if (!IsEmpty(document.frmRegister.fromAge,"text"))
		{
			stAge = parseInt( frmRegister.fromAge.value );
			if ( stAge < startFemaleAge || stAge > 70 )
			{document.getElementById('partneragespan').innerHTML="Invalid Age " +  frmRegister.fromAge.value + ".  Minimum age allowed is "+startFemaleAge+" and maximum age is 70.";document.getElementById('row222').className="errorrow";frmRegister.fromAge.focus();return false;
			}else{document.getElementById('partneragespan').innerHTML="&nbsp";}
		}
		
		if(!ValidateNo( frmRegister.toAge.value, "0123456789"))
		{document.getElementById('partneragespan').innerHTML="Invalid Age " + frmRegister.toAge.value;document.getElementById('row222').className="errorrow";frmRegister.toAge.focus();return false;
		}else{document.getElementById('partneragespan').innerHTML="";}

		if (!IsEmpty(document.frmRegister.toAge,"text"))
		{
			endAge = parseInt( frmRegister.toAge.value );
			if ( endAge < startFemaleAge || endAge > 70 )
			{document.getElementById('partneragespan').innerHTML="Invalid Age " +  frmRegister.fromAge.value + ".  Minimum age allowed is "+startFemaleAge+" and maximum age is 70.";document.getElementById('row222').className="errorrow";frmRegister.toAge.focus();return false;
			}else{document.getElementById('partneragespan').innerHTML="";}
			

			if ( stAge != 0 && endAge < stAge )
			{document.getElementById('partneragespan').innerHTML="Invalid age range " + stAge + " to " + endAge;document.getElementById('row222').className="errorrow";frmRegister.fromAge.focus();return false;
			}else{document.getElementById('partneragespan').innerHTML="";}

		}

		if ( frmRegister.heightTo.selectedIndex  < frmRegister.heightFrom.selectedIndex )
		{document.getElementById('partnerheightspan').innerHTML="Invalid height range";document.getElementById('row222').className="errorrow";frmRegister.heightTo.focus();return false;
		}else{document.getElementById('partnerheightspan').innerHTML="";}

		return true;
	}
	//Validation for addpartner end here


	//validation for add family start here
	function addFamilyValidate()
	{
		var frmRegister = this.document.frmRegister;

		if(!(document.frmRegister.familyValue[0].checked) && !(document.frmRegister.familyValue[1].checked) && !(document.frmRegister.familyValue[2].checked))
		{document.getElementById('familyvaluespan').innerHTML="Select the family value of the prospect";document.getElementById('row1').className="errorrow";document.frmRegister.familyValue[0].focus();return false;}
		else{document.getElementById('familyvaluespan').innerHTML=" ";}

			
		if(!(document.frmRegister.familyType[0].checked) && !(document.frmRegister.familyType[1].checked) && !(document.frmRegister.familyType[2].checked))
		{document.getElementById('familytypespan').innerHTML="Select the family type of the prospect";document.getElementById('row2').className="errorrow";document.frmRegister.familyType[0].focus();return false;}
		else{document.getElementById('familytypespan').innerHTML=" ";}

		if (!(document.frmRegister.marriedBrothers.value=="0") && document.frmRegister.brothers.value=="0")
		{document.getElementById('siblingsdetailsspan').innerHTML="Select no of brother(s) you have";document.getElementById('row7').className="errorrow";document.frmRegister.brothers.focus();return false;}
		else{document.getElementById('siblingsdetailsspan').innerHTML=" ";}

		
		document.getElementById('siblingssisterspan').innerHTML=" ";
		document.getElementById('siblingsbrotherspan').innerHTML=" ";
		if(!(document.frmRegister.brothers.value=="0") && !(document.frmRegister.marriedBrothers.value=="0"))
		{
			if (document.frmRegister.marriedBrothers.value > document.frmRegister.brothers.value)
			{document.getElementById('siblingsbrotherspan').innerHTML="Incorrect selection";document.getElementById('row7').className="errorrow";document.frmRegister.brothers.focus();return false;}
			else{document.getElementById('siblingsbrotherspan').innerHTML=" ";}
		}

		if (!(document.frmRegister.marriedSisters.value=="0") && document.frmRegister.sisters.value=="0")
		{document.getElementById('siblingsdetailsspan').innerHTML="Select no of Sister(s) you have";document.getElementById('row7').className="errorrow";document.frmRegister.sisters.focus();return false;}
		else{document.getElementById('siblingsdetailsspan').innerHTML=" ";}

		
		if(!(document.frmRegister.sisters.value=="0") && !(document.frmRegister.marriedSisters.value=="0"))
		{
			if (document.frmRegister.marriedSisters.value > document.frmRegister.sisters.value)
			{document.getElementById('siblingssisterspan').innerHTML="Incorrect selection";document.getElementById('row7').className="errorrow";document.frmRegister.sisters.focus();return false;}
			else{document.getElementById('siblingssisterspan').innerHTML=" ";}
		}

		return true;
	}

	function brothersChk() {
		if (!(document.frmRegister.marriedBrothers.value=="0") && document.frmRegister.brothers.value=="0") {
		document.getElementById('siblingsdetailsspan').innerHTML="Select no of brother(s) you have";document.getElementById('row7').className="errorrow";document.frmRegister.brothers.focus();return false;}
		else{document.getElementById('siblingsdetailsspan').innerHTML=" ";
		}
		if(!(document.frmRegister.brothers.value=="0") && !(document.frmRegister.marriedBrothers.value=="0"))
		{
			if (document.frmRegister.marriedBrothers.value > document.frmRegister.brothers.value)
			{document.getElementById('siblingsbrotherspan').innerHTML="Incorrect selection";document.getElementById('row7').className="errorrow";document.frmRegister.brothers.focus();return false;}
			else{document.getElementById('siblingsbrotherspan').innerHTML=" ";}
		}
		if(!(document.frmRegister.brothers.value=="0") && document.frmRegister.marriedBrothers.value=="0")
		{
			document.getElementById('siblingsbrotherspan').innerHTML=" ";
		}
	}

	function sistersChk() {
		if (!(document.frmRegister.marriedSisters.value=="0") && document.frmRegister.sisters.value=="0")
		{document.getElementById('siblingsdetailsspan').innerHTML="Select no of Sister(s) you have";document.getElementById('row7').className="errorrow";document.frmRegister.sisters.focus();return false;}
		else{document.getElementById('siblingsdetailsspan').innerHTML=" ";}

		
		if(!(document.frmRegister.sisters.value=="0") && !(document.frmRegister.marriedSisters.value=="0"))
		{
			if (document.frmRegister.marriedSisters.value > document.frmRegister.sisters.value)
			{document.getElementById('siblingssisterspan').innerHTML="Incorrect selection";document.getElementById('row7').className="errorrow";document.frmRegister.sisters.focus();return false;}
			else{document.getElementById('siblingssisterspan').innerHTML=" ";}
		}
		if(!(document.frmRegister.sisters.value=="0") && document.frmRegister.marriedSisters.value=="0")
		{
			document.getElementById('siblingssisterspan').innerHTML=" ";
		}
	}
	//validation for add family end here

	//validation for add interest start here

	function HobbiesValidate(){
	
	  var frmRegister = document.frmRegister;
	  
	   if (frmRegister.hobothertxt.checked == true) {
		   if (IsEmpty(document.frmRegister.hobbiesDesc,'text')){
			document.getElementById('hobbiesDescspan').innerHTML="Enter other hobbies";
			frmRegister.hobbiesDesc.value = '';
			frmRegister.hobbiesDesc.focus();return false;
		  }else{document.getElementById('hobbiesDescspan').innerHTML="";}
	   }

	   if (frmRegister.intothertxt.checked == true) {
		   if (IsEmpty(document.frmRegister.interestDesc,'text')){
			document.getElementById('interestDescspan').innerHTML="Enter other interests";
			frmRegister.interestDesc.value = '';
			frmRegister.interestDesc.focus();return false;
		  }else{document.getElementById('interestDescspan').innerHTML="";}
	   }

	   if (frmRegister.mscothertxt.checked == true) {
		   if (IsEmpty(document.frmRegister.musicDesc,'text')){
			document.getElementById('musicDescspan').innerHTML="Enter other favourite musics";
			frmRegister.musicDesc.value = '';
			frmRegister.musicDesc.focus();return false;
		  }else{document.getElementById('musicDescspan').innerHTML="";}
	   }

	   if (frmRegister.frdothertxt.checked == true) {
		   if (IsEmpty(document.frmRegister.readDesc,'text')){
			document.getElementById('readDescspan').innerHTML="Enter other favourite reads";
			frmRegister.readDesc.value = '';
			frmRegister.readDesc.focus();return false;
		  }else{document.getElementById('readDescspan').innerHTML="";}
	   }

	   if (frmRegister.mvothertxt.checked == true) {
		   if (IsEmpty(document.frmRegister.movieDesc,'text')){
			document.getElementById('movieDescspan').innerHTML="Enter other preferred movies";
			frmRegister.movieDesc.value = '';
			frmRegister.movieDesc.focus();return false;
		  }else{document.getElementById('movieDescspan').innerHTML="";}
	   }

	   if (frmRegister.sftothertxt.checked == true) {
		   if (IsEmpty(document.frmRegister.sportsDesc,'text')){
			document.getElementById('sportsDescspan').innerHTML="Enter other sports/fitness activities";
			frmRegister.sportsDesc.value = '';
			frmRegister.sportsDesc.focus();return false;
		  }else{document.getElementById('sportsDescspan').innerHTML="";}
	   }

	   if (frmRegister.fcsnothertxt.checked == true) {
		   if (IsEmpty(document.frmRegister.foodDesc,'text')){
			document.getElementById('foodDescspan').innerHTML="Enter other favourite cuisine";
			frmRegister.foodDesc.value = '';
			frmRegister.foodDesc.focus();return false;
		  }else{document.getElementById('foodDescspan').innerHTML="";}
	   }

	   if (frmRegister.pdsothertxt.checked == true) {
		   if (IsEmpty(document.frmRegister.dressDesc,'text')){
			document.getElementById('dressDescspan').innerHTML="Enter other preferred dress style";
			frmRegister.dressDesc.value = '';
			frmRegister.dressDesc.focus();return false;
		  }else{document.getElementById('dressDescspan').innerHTML="";}
	   }

	   if (frmRegister.slangothertxt.checked == true) {
		   if (IsEmpty(document.frmRegister.spokenLangDesc,'text')){
			document.getElementById('spokenLangDescspan').innerHTML="Enter other spoken languages";
			frmRegister.spokenLangDesc.value = '';
			frmRegister.spokenLangDesc.focus();return false;
		  }else{document.getElementById('spokenLangDescspan').innerHTML="";}
	   }
	  return true;
	}

	function divswitch(c, a, b) {
	if(c.length < 1) { return; }
	if(document.getElementById(c).style.display == "none") 
		{
			document.getElementById(c).style.display = "block";
			document.getElementById(a).style.display = "none";
			document.getElementById(b).style.display = "block";
		}
	else 
		{
			document.getElementById(c).style.display = "none";
			document.getElementById(a).style.display = "block";
			document.getElementById(b).style.display = "none";
		}
	}

	function othrtxt(a, b) {

		if(eval("document.frmRegister."+a+".checked")==true)		
		{ eval("document.frmRegister."+b+".disabled = false");}
		else {eval("document.frmRegister."+b+".disabled = true");document.getElementById(b+'span').innerHTML = '';}	
	}
	//validation for add interest end here

function photoPaging(ph_det, curr_ph, tot_ph, photo_status, ph_ownview, matid, tabview)
{
	var	pagingCont='', prev, next, prev_pg, next_pg;

	if(curr_ph<1){curr_ph =1;}
	if(curr_ph>tot_ph){curr_ph =tot_ph;}

	var pre='<div style="padding:5px 0px 0px 0px;">';
	var inter='<div class="phnumpadd smalltxt fleft" style="padding-top:1px;">'+curr_ph+'&nbsp;of&nbsp;'+tot_ph+'</div>';

	if(curr_ph>1) {
		var prev_pg = parseInt(curr_ph)-1;	
		prev='<div class="fleft vc6pd-top"><a href="javascript:;" onClick="javascript:first_photo(\''+ph_det+"','"+prev_pg+"','"+photo_status+"','"+ph_ownview+"','"+matid+"','"+tabview+"');\"><div class='useracticonsimgs phnavlfton'></div></a></div>";
	} else {
		prev='<div class="fleft vc6pd-top"><div class="useracticonsimgs phnavlftoff"></div></div>';
	}


	if(curr_ph<tot_ph) {
		var next_pg = parseInt(curr_ph)+1;	
		next='<div class="fleft vc6pd-top"><a href="javascript:;" onclick="javascript:first_photo(\''+ph_det+"','"+next_pg+"','"+photo_status+"','"+ph_ownview+"','"+matid+"','"+tabview+"');\"><div class='useracticonsimgs phnavrigon'></div></a></div>";
	} else { 
		next='<div class="fleft vc6pd-top"><div class="useracticonsimgs phnavrigoff"></div></div>';
	}

	pagingCont = pre+prev+inter+next+'</div>';
	return pagingCont;
}

var i=0;
function first_photo(ph_det, ph_no, ph_status, ph_ownview, matid, tabview)
{
	var arrPhotos	= ph_det.split('^');
	var arrPhotosStatus	= ph_status.split('^');
	var totPhotos	= arrPhotos.length;
	var photo_no	= parseInt(ph_no)-1;
	var photo_path = '';
	var onclickpart = '';

	ph_folder= arrPhotos[photo_no].substring(1,2)+'/'+arrPhotos[photo_no].substring(2,3)+'/';
	var disp_photo = img_url+"/photo/viewphoto.php?ID="+matid+"&PNO="+ph_no;
	
	photo_path = "<img  style='cursor: pointer;' src='"+pho_url+"/";
	onclickpart = "onclick=window.open('"+disp_photo+"','','directories=no,width=900,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
	ph_cont = photo_path+ph_folder+arrPhotos[photo_no]+"' alt='' border='0' height='75' width='75' "+onclickpart+">";
	

	//replace display photo area
	repl_div = 'imagecontainer';
	document.getElementById(repl_div).innerHTML = '';
	document.getElementById(repl_div).innerHTML = ph_cont;

	if(totPhotos > 1 ){
	//paging called here
	var pag_cont = photoPaging(ph_det, ph_no, totPhotos, ph_status, ph_ownview,matid,tabview);

	//replace photo paging area
	repl_div = 'backforthbuttons';
	//window.parent.document.getElementById('backforthbuttons').innerHTML = '';
	document.getElementById('backforthbuttons').innerHTML = pag_cont;
	}
}

function formFocus(frmName) {
	eval('document.'+frmName+'.elements[0].focus();');
}

var objStateCall;
function ajaxStateCall(url,tabIndex) {
	objStateCall = AjaxCall();
	var country = document.frmRegister.country.value;

	if (country!=98) { ajaxCityCall(url,tabIndex); }

	var parameters	=  "country="+country+"&tabIndex="+tabIndex+"&display=state&rand="+Math.random();
	 objStateCall.onreadystatechange = regStateList;
	 objStateCall.open('POST', url, true);
	 objStateCall.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 objStateCall.setRequestHeader("Content-length", parameters.length);
	 objStateCall.setRequestHeader("Connection", "close");
	 objStateCall.send(parameters);
	 return objStateCall;
}

function regStateList() {

	if (objStateCall.readyState == 4 && objStateCall.status == 200) {
		document.getElementById('stateList').innerHTML	= objStateCall.responseText;
	}
}
var objCityCall;
function ajaxCityCall(url,tabIndex) {
	objCityCall = AjaxCall();

	var country = document.frmRegister.country.value;
	var state = 0;
	if (country==98) {
		state = document.frmRegister.residingState.value;
	}
	var parameters	=  "country="+country+"&tabIndex="+tabIndex+"&state="+state+"&display=city&rand="+Math.random();
	 objCityCall.onreadystatechange = regCityList;
	 objCityCall.open('POST', url, true);
	 objCityCall.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 objCityCall.setRequestHeader("Content-length", parameters.length);
	 objCityCall.setRequestHeader("Connection", "close");
	 objCityCall.send(parameters);
	 return objCityCall;
}

function regCityList() {
	if (objCityCall.readyState == 4 && objCityCall.status == 200) {
		document.getElementById('cityList').innerHTML	= objCityCall.responseText;
	}
}


function phCCode() {
	var ccodevalue	= document.frmRegister.countryCode.value;
	if (ccodevalue=='ISD') { document.frmRegister.countryCode.value=''; }
	if (ccodevalue=='') { document.frmRegister.countryCode.value='ISD'; }
}

function phSCode() {
	var cstdvalue	= document.frmRegister.areaCode.value;
	if (cstdvalue=='STD') { document.frmRegister.areaCode.value=''; }
	if (cstdvalue=='') { document.frmRegister.areaCode.value='STD'; }
}

function teleNoCheck() {
	var tno	= document.frmRegister.phoneNo.value;
	if (tno=='Telephone number') { document.frmRegister.phoneNo.value=''; }
	if (tno=='') { document.frmRegister.phoneNo.value='Telephone number'; }
}


function mobNoCheck() {
	var mno	= document.frmRegister.mobileNo.value;
	if (mno=='Mobile number') { document.frmRegister.mobileNo.value=''; }
	if (mno=='') { document.frmRegister.mobileNo.value='Mobile number'; }
}

function checkEmployment() {
    if (parseInt(document.frmRegister.empinfeature.value) == 1) {
	 if ( IsEmpty(document.frmRegister.employmentCategory,'radio')) {
	 document.getElementById('employmentCategoryspan').innerHTML="Select the employment category of the prospect";
	 return false;}
	 else{document.getElementById('employmentCategoryspan').innerHTML=""; }
	}
}

function physicalStatusChk() {
    if ( IsEmpty(document.frmRegister.physicalStatus,'radio')) {
	document.getElementById('physicalspan').innerHTML="Select the physical status of the prospect";
	return false;}
	else{document.getElementById('physicalspan').innerHTML=""; }
}

function chkAnnualInc() {
	if (document.frmRegister.annualIncome.value!=5) {
	if (IsEmpty(document.frmRegister.annualIncome,'text')) {
	document.getElementById('amountspan').innerHTML="Enter the annual income of the prospect";frmRegister.annualIncome.focus();return false;
	} else { document.getElementById('amountspan').innerHTML=""; }
	}
}

function getMarriedChk() {
	if (IsEmpty(document.frmRegister.getMarried,"radio")) {
		document.getElementById('getmarriedspan').innerHTML="Select the how soon you want to get married of the prospect";return;}	
else{document.getElementById('getmarriedspan').innerHTML="";}
}

function commterms(){
	communityId = document.frmRegister.communityId.value;
	if(communityId == 0) {
	  termsAndCondPage = 'termsandconditions_com.php';
	}
	else if(communityId == 2503) {
	  termsAndCondPage = 'mus_terms.php';
	}
	else if(communityId == 2500) {
	  termsAndCondPage = 'chris_terms.php';
	}
	else {
	  termsAndCondPage = 'termsandconditions.php';
	}
	window.open('/site/'+termsAndCondPage+'','mywindow1','location=0,status=0,scrollbars=yes,toolbar=0,menubar=0,resizable=0,width=650,height=600');
}

//***********************************************
var objSubCaste;
function funCaste(argCasteId,argSubCasteId){

	var casteId;
	if(document.frmRegister.casteOthers  != 'undefined') {
	  document.frmRegister.casteOthers.value='';
	}
	if (document.getElementById('subCasteDivText')) {
		document.frmRegister.subCasteOthers.value='';
		document.getElementById('subCasteDivText').style.display='none';
		
	}//if

	// added by barani //
      communityId = document.frmRegister.communityId.value;
	// end by barani //

	if (argCasteId=='') {
		casteId = document.frmRegister.caste.options[document.frmRegister.caste.selectedIndex].value;
	} else { casteId = argCasteId; }

	if (casteId > 0) {

		objSubCaste = AjaxCall();
		var parameters	= "casteId="+casteId+"&subcasteId="+argSubCasteId+"&communityId="+communityId+"&field=caste&rand="+Math.random();
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
		document.frmRegister.subCasteOption.value	= subCasteList[0];
		document.getElementById('subCasteDivId').innerHTML	= subCasteList[1];
	}
	funGothramChk();
}


//***************************************************************
var objCaste;
function funReligion(submittedCasteId){

    // added by barani //
      communityId = document.frmRegister.communityId.value;
	// end by barani //

	var casteId = 0;
	var casteFeature = document.frmRegister.castefeature.value;
	var casteOption = document.frmRegister.casteOption.value;
	var religionId	= document.frmRegister.religion.options[document.frmRegister.religion.selectedIndex].value;
	var relOpt		= document.frmRegister.religionOption.value;

	if (casteOption==1) { casteId = document.frmRegister.caste.value; }

	if ((religionId=='8') || (religionId=='9')) { funSubCasteText(); }

	if (religionId=='1') { document.getElementById('gothramCommonDivId').style.display='block'; }
	else { document.getElementById('gothramCommonDivId').style.display='none'; }

	//Caste Label Changes
	if ((religionId=='2') || (religionId=='10') || (religionId=='11' ))  { document.getElementById('branchDiv').innerHTML='Sect';  } 
	else if ((religionId=='3') || (religionId=='12') || (religionId=='13' ) || (religionId=='14' )) { document.getElementById('branchDiv').innerHTML='Denomination';  } 
	else if (religionId=='7') { document.getElementById('branchDiv').innerHTML='Branch';  } 
	else { 
		if (document.getElementById('branchDiv')) { document.getElementById('branchDiv').innerHTML='Caste'; } } 

	
	if (casteFeature==1 && casteOption==1) { funCaste(casteId,''); } //call subcaste function...
	else {
		if (religionId > 0) {
			objCaste = AjaxCall();
			var parameters	= "religionId="+religionId+"&casteId="+submittedCasteId+"&communityId="+communityId+"&field=religion&rand="+Math.random();
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

function funDenomination(submittedCasteId){
    
	// added by barani //
      communityId = document.frmRegister.communityId.value;
	// end by barani //
    
    if(frmRegister.denominationText != 'undefined') {
	  frmRegister.denominationText.value = '';
	}

    if(document.getElementById('casteDivText') != null) {
	  document.getElementById('casteDivText').style.display='none';
	}

	var casteId = 0;
	var casteFeature = document.frmRegister.castefeature.value;
	var casteOption = document.frmRegister.casteOption.value;
	var denominationId	= document.frmRegister.denomination.options[document.frmRegister.denomination.selectedIndex].value;
	var denominationOpt	= document.frmRegister.denominationOption.value;
	//document.frmRegister.casteOthers.value = "";
	//document.getElementById('casteDivText').style.display='none';
	document.frmRegister.denominationText.value = '';
	if (casteOption==1) { casteId = document.frmRegister.caste.value; }

	if (casteFeature==1 && casteOption==1) { funCaste(casteId,''); } //call subcaste function...
	else {
		if (denominationId > 0) {
           
		    //by barani 
            if(denominationId == 9997) {
			  document.frmRegister.denominationText.style.visibility = "visible";
	          document.getElementById('subCasteDivId').innerHTML = '<input type="text" value="" name="subCasteText" size="35" class="inputtext" tabindex="31">';
			  document.getElementById('subCasteDivText').style.display = 'none';
			}
            else {
			  document.frmRegister.denominationText.style.visibility = "hidden";
			}
           // end by barani
			objCaste = AjaxCall();
			var parameters	= "denominationId="+denominationId+"&casteId="+submittedCasteId+"&communityId="+communityId+"&field=denomination&rand="+Math.random();
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
		document.frmRegister.casteOption.value	= casteList[0];
		document.getElementById('casteDivId').innerHTML	= casteList[1];
	}
}

function funGothramChk(submittedGothram){
//alert('test barani');
//alert(submittedGothram);
	var gothramFeatureId = parseInt(document.frmRegister.gothramfeature.value);
	var casteFeatureId	 = parseInt(document.frmRegister.castefeature.value);
	var casteOptionId	 = parseInt(document.frmRegister.casteOption.value);
	var casteId	= 0;

    // added by barani //
      communityId = document.frmRegister.communityId.value;
	// end by barani //

	if (gothramFeatureId==1 && casteFeatureId==1) {

		if (casteOptionId > 1) { 
			casteId = document.frmRegister.caste.options[document.frmRegister.caste.selectedIndex].value;
		}
		objGothram = AjaxCall();
		//var parameters	= "casteId="+casteId+"&rand="+Math.random();
		var parameters	= "casteId="+casteId+"&gothramId="+submittedGothram+"&communityId="+communityId+"&rand="+Math.random();
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
		document.frmRegister.gothramOption.value				= gothramList[0];
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
	if (parseInt(document.frmRegister.gothramfeature.value)==1) {
		if (parseInt(document.frmRegister.gothramOption.value)>1) {
			var gothramId = parseInt(document.frmRegister.gothram.options[document.frmRegister.gothram.selectedIndex].value);
			if (gothramId== 0) {
				document.getElementById("gothramDivText").style.display="none";
				document.getElementById('gothraspan').innerHTML="Select the gothram of the prospect";
				//document.frmRegister.gothram.focus();
				return;
			} else if (gothramId==9997) {
				document.getElementById("gothramDivText").style.display="block";
				if (document.frmRegister.gothramOthers.value=="") {
					document.getElementById('gothraspan').innerHTML="Enter the gothram of the prospect";
					//document.frmRegister.gothramOthers.focus();
					return;
				} else { document.getElementById('gothraspan').innerHTML=''; }
			} else { document.getElementById("gothramDivText").style.display="none";document.getElementById('gothraspan').innerHTML=''; }
		}
	}

}

function anycastegothramChk() {
	if (parseInt(document.frmRegister.gothramfeature.value)==1) {
		if (parseInt(document.frmRegister.gothramOption.value)>1) {
			var gothramId = parseInt(document.frmRegister.gothram.options[document.frmRegister.gothram.selectedIndex].value);
			if (gothramId==9997) {
				document.getElementById("gothramDivText").style.display="block";
				if (document.frmRegister.gothramOthers.value=="") {
					document.getElementById('gothraspan').innerHTML="Enter the gothram of the prospect";
					//document.frmRegister.gothramOthers.focus();
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
        communityId = document.frmRegister.communityId.value;
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


function funMotherTongue(){

		objMotherTongue = AjaxCall();
		var domain		= document.frmRegister.domainName.options[document.frmRegister.domainName.selectedIndex].value;
		var mtabindex	= document.frmRegister.motherTonguetabIndex.value;
		document.frmRegister.domainRegister.value = domain;

		if (domain=='divorceematrimony.com') {

			document.getElementById('cstatus').style.display='block';
			document.getElementById('childliving').style.display='block';

		} else { 

			document.getElementById('cstatus').style.display='none';
			document.getElementById('childliving').style.display='none';
		}



		if (domain !="" && domain >'0') {

			var parameters	= "domain="+domain+"&tabIndex="+mtabindex+"&rand="+Math.random();
			var stateURL	= '/register/populatemaritalmothertongue.php';
			objMotherTongue.onreadystatechange = populatemotherTongue;
			objMotherTongue.open('POST', stateURL, true);
			objMotherTongue.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			objMotherTongue.setRequestHeader("Content-length", parameters.length);
			objMotherTongue.setRequestHeader("Connection", "close");
			objMotherTongue.send(parameters);
			return objMotherTongue;
		}
}

function populatemotherTongue() {
	if (objMotherTongue.readyState == 4 && objMotherTongue.status == 200) {

		var MotherMaritalList = objMotherTongue.responseText.split('#~$');
		//document.frmRegister.gothramOption.value					= gothramList[0];
		//document.getElementById('gothramMainDivId').innerHTML		= gothramList[1];

		document.getElementById('MaritalStatusDivId').innerHTML		= MotherMaritalList[0];
		document.getElementById('MotherTongueDivId').innerHTML		= MotherMaritalList[1];
		document.getElementById('religiousethnicityDiv').innerHTML	= MotherMaritalList[2];
		document.frmRegister.MaritalCnt.value						= MotherMaritalList[3];
		document.frmRegister.religiousOption.value					= MotherMaritalList[4];
		document.frmRegister.ethnicityOption.value					= MotherMaritalList[5];
		document.getElementById('appearanceDiv').innerHTML			= MotherMaritalList[6];
		document.frmRegister.appearancefeature.value				= MotherMaritalList[7];
		document.frmRegister.religiousfeature.value					= MotherMaritalList[8];
		document.frmRegister.ethinicityfeature.value				= MotherMaritalList[9];


		
		
	}
}

// function written by barani on june-08-2010 //
function subCasteOthersChk(){
   var subCasteId =  parseInt(document.frmRegister.subCaste.options[document.frmRegister.subCaste.selectedIndex].value);
   
   if (subCasteId== 9997) {
			document.getElementById('subCasteDivText').style.display='block';
   } else { document.getElementById('subCasteDivText').style.display='none'; }
}

// function to handle occupation selection in dropdown box //
function selectOccupation(occupationValue) {
  if(occupationValue == 888) {
   EnableDisableEmployedIn(true);
   document.frmRegister.annualIncomeCurrency.disabled=true;
   document.frmRegister.annualIncome.disabled=true;
    document.getElementById('employmentCategoryspan').innerHTML="";
   document.getElementById('annualincomespan').innerHTML="";
   document.getElementById('amountspan').innerHTML="";
  }
  else {
   EnableDisableEmployedIn(false);
   document.frmRegister.annualIncomeCurrency.disabled=false;
   document.frmRegister.annualIncome.disabled=false;
  }
}

 // function to disable whole employedin category radio buttons //
 function EnableDisableEmployedIn(flgStatus) {
   for(var i=0;i<document.frmRegister.employmentCategory.length;i++) {
    document.frmRegister.employmentCategory[i].disabled = flgStatus;
   }
 }

// function to populate occupation based on the selection of gender for defence matrimony
function populateOccupation(gender,occupation) {
	var communityId = document.frmRegister.communityId.value;
	if(communityId == 2006) {
	 occupation_request = AjaxCall();
	 var url="../register/populateoccupation.php?gender="+gender+"&occupation="+occupation; //Mano
	 occupation_request.onreadystatechange = processOccupation;
	 occupation_request.open('GET', url, true);
	 occupation_request.send(null);
	} 
}

function processOccupation()
{
	if (occupation_request.readyState == 4) 
	{
		if (occupation_request.status == 200) 
		{
			document.getElementById('occupationDivId').innerHTML =''; 
			document.getElementById('occupationDivId').innerHTML=occupation_request.responseText;
		}
	}
}

function disableHandicappedByWar() {
  var frmRegister = this.document.frmRegister;
  var communityId = frmRegister.communityId.value;
  var PhysicalStatusCnt = frmRegister.PhysicalStatusCnt.value;

  if(communityId == 2006) {
	for(i=0; i<PhysicalStatusCnt; i++) {
      if(frmRegister.gender[1].checked == true && frmRegister.maritalStatus[1].checked == true) {
		if(frmRegister.physicalStatus[i].value == 3 ){
		  frmRegister.physicalStatus[i].checked = false;
		  frmRegister.physicalStatus[i].disabled = true;
		}
	  }
	  else {
		  frmRegister.physicalStatus[i].disabled = false;
	  }
    }
  }
}
