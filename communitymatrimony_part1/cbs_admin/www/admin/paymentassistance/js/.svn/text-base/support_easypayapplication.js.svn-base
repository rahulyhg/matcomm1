function enableprocess(getval){

	if(getval == 1){
		document.getElementById('visiblestate').disabled=true;
		document.getElementById('visiblefreetxt').disabled=true;
		document.getElementById('visibleselect').disabled=false;
		document.getElementById('ViewResult').style.visibility="hidden";
		document.getElementById('headother').style.visibility="hidden";
		document.getElementById('visiblefreetxt').value="";
	}
	else if(getval == 2){
		document.getElementById('visiblestate').disabled=false;
		document.getElementById('visibleselect').disabled=true;
		document.getElementById('visiblefreetxt').disabled=false;

	}
 }

 function hiddeviewresult() {
document.getElementById('ViewResult').style.visibility="hidden";
document.getElementById('headother').style.visibility="hidden";
}
function getname(n){
document.getElementById('visiblefreetxt').value=n;
document.getElementById('ViewResult').style.visibility="hidden";
document.getElementById('headother').style.visibility="hidden";
}

function validate(){
//For Residing district
 if(document.frm.City.value == 0 && document.getElementById('visibleoption').checked == true){
	alert("select the Residing District");
	document.frm.City.focus();
	return false;
}
if(document.getElementById('visibleoption1').checked == true){
	if(document.frm.otherstxt.value == ""){
	alert("Enter the City Name");
	document.frm.otherstxt.focus();
	return false;
}
	if(document.frm.otehrstate.value==0){
	alert("Enter the State Name");
	document.frm.otehrstate.focus();
	return false;
}
}
//For payment category
if(document.frm.PaymentCategory.value == 0){
	alert("Select the payment category");
	document.frm.PaymentCategory.focus();
	return false;
}
//For contact name
if(document.frm.ContactName.value == ""){
	alert("Enter the contact name");
	document.frm.ContactName.focus();
	return false;
}

	//For Appointment date
if(document.frm.APPTDATE.value==''){
	alert("Please select a Appointment Date from the Date Picker");
	document.frm.APPTDATE.focus();
	return false;
}
 var varGivenDate     = document.frm.APPTDATE.value;
 var varGivenFullDate = varGivenDate.split('-');
 var varGivenYear     = varGivenFullDate[0];
 var varGivenMonth    = varGivenFullDate[1];
 var varonlyDate      = varGivenFullDate[2];

 if(((varGivenYear>=servyear)&&(varGivenYear<=nextweekservyear))&&((varGivenMonth>=servmonth)&&
 (varGivenMonth<=nextweekservmonth))&&((varonlyDate>=servdate)&&(varonlyDate<=nextweekservdate))){
 }else {
//  alert("Date Should not exceed more than a week");
//  document.frm.APPTDATE.focus();
//  return false;
 }

 if((varGivenYear==servyear)&&(varGivenMonth==servmonth)&&(varonlyDate==servdate)){
  Selectedtime=document.frm.appfromtime.options[document.frm.appfromtime.selectedIndex].value;
  Selectedcorrecttime=Selectedtime.split(':');
  selectedmatchtime=Selectedcorrecttime[0];
  if(selectedmatchtime <= servhour){
   alert("The time you have selected has passed. Please select a future time.");
   document.frm.APPTDATE.focus();
   return false;
  }
  }

if((document.frm.appfromtime.options[document.frm.appfromtime.selectedIndex].value)>=(document.frm.apptotime.options[document.frm.apptotime.selectedIndex].value)){
alert("Please select a 'to time' that comes after the 'from time' on the same day. i.e. From 10am to 8pm");
 return false;
 }

if(document.frm.collectioncont.value==""){
	alert("Enter the Phone/Mobile No");
	document.frm.collectioncont.focus();
	return false;
}
//For address
if(document.frm.Address.value==""){
	alert("Enter the address");
	document.frm.Address.focus();
	return false;
}
//For modeofpayment
if(document.frm.ModeofPayment.value=="0"){
	alert("Enter the Modeofpayment");
	document.frm.ModeofPayment.focus();
	return false;
}
}
function IsEmpty(obj, obj_type)
{
	if (obj_type == "radio" || obj_type == "checkbox") {
		if (!obj[0] && obj) {
			if (obj.checked) {
				return false;
			} else {
				return true;
			}
		} else {
			for (i=0; i < obj.length; i++) {
				if (obj[i].checked) {
					return false;
				}
			}
			return true;
		}
	}
}

function GetXmlHttpObject(){
	var xmlHttp=null;
	try
		{
			// Firefox, Opera 8.0+, Safari
			xmlHttp=new XMLHttpRequest();
		}
	catch (e)
		{
			// Internet Explorer
	try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
	catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
return xmlHttp;
} 
var xmlHttp
function GetResult(str)
{
	document.getElementById('VIEWRESULT').style.visibility="visible";
if (str.length==0)
  { 
  document.getElementById("VIEWRESULT").innerHTML=""
  return
  }
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
var url="autosuggest.php"
url=url+"?q="+str
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
	 if(xmlHttp.responseText ==0){
	 document.getElementById('VIEWRESULT').style.visibility="hidden";
	 document.getElementById('HEADOTHER').style.visibility="hidden";
 }	
 else{
 document.getElementById("HEADOTHER").style.visibility="visible";
 document.getElementById("VIEWRESULT").innerHTML=xmlHttp.responseText ;
 }
 }
 
}
