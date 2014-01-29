// JavaScript Document
function enableField1(){
		document.PROFILEUPDATE.Fmon.disabled=false;
		document.PROFILEUPDATE.Fday.disabled=false;
		document.PROFILEUPDATE.Fyear.disabled=false;
	}
function dynamic_popup(url,w,h,s,r) { 
	var dyn_pop=window.open(url, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable="+r+",width="+w+",height="+h+",status=no,scrollbars=Yes,titlebar=yes;");
	dyn_pop.focus();
}

function validatethis(){

	if(document.PROFILEUPDATE.tstatus.value == "")
	{
		alert("Select Status");
				document.PROFILEUPDATE.tstatus.focus();	
				return false;
}
	
if (document.PROFILEUPDATE.tstatus.options[document.PROFILEUPDATE.tstatus.selectedIndex].value==5 || document.PROFILEUPDATE.tstatus.options[document.PROFILEUPDATE.tstatus.selectedIndex].value==11 || document.PROFILEUPDATE.tstatus.options[document.PROFILEUPDATE.tstatus.selectedIndex].value==1 || document.PROFILEUPDATE.tstatus.options[document.PROFILEUPDATE.tstatus.selectedIndex].value==6 || document.PROFILEUPDATE.tstatus.options[document.PROFILEUPDATE.tstatus.selectedIndex].value==7 || document.PROFILEUPDATE.tstatus.options[document.PROFILEUPDATE.tstatus.selectedIndex].value==9)  { 

if(document.PROFILEUPDATE.Fday.options[document.PROFILEUPDATE.Fday.selectedIndex].text=="dd") {
	alert("Select Day");
	document.PROFILEUPDATE.Fday.focus();	
	return false;
}
if(document.PROFILEUPDATE.Fmon.options[document.PROFILEUPDATE.Fmon.selectedIndex].text=="mmm") {
	alert("Select Month");
	document.PROFILEUPDATE.Fmon.focus();
	return false;	
}
if(document.PROFILEUPDATE.Fyear.options[document.PROFILEUPDATE.Fyear.selectedIndex].text=="yyyy") {
	alert("Select Year");
	document.PROFILEUPDATE.Fyear.focus();
	return false;	
} 
}

if(document.PROFILEUPDATE.Fday.disabled==false) {
var myDate="";
var today="";
myDate = new Date;
var month = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
var selmon = document.PROFILEUPDATE.Fmon.options[document.PROFILEUPDATE.Fmon.selectedIndex].text;
for(var i=0;i<12;i++){	
if(selmon == month[i])
var j = i;			
}
	myDate.setDate(document.PROFILEUPDATE.Fday.options[document.PROFILEUPDATE.Fday.selectedIndex].text);
	myDate.setMonth(j); 	
	myDate.setFullYear(document.PROFILEUPDATE.Fyear.options[document.PROFILEUPDATE.Fyear.selectedIndex].text); 
	today = new Date;

	var mydatenew=myDate.getTime();
	var todaynew=today.getTime();
	var mydateup=mydatenew+2;
	if(mydateup < todaynew){	
//	alert('Appointment date should be equal to current date or greater than current date');
//	return false;
	}
}
//alert(document.PROFILEUPDATE.Fday.disabled);
if(document.PROFILEUPDATE.Fday.disabled == false)
{
	var curdate = new Date();
	var followupdate = document.PROFILEUPDATE.Fday.value;
	var followupmonth = document.PROFILEUPDATE.Fmon.value;
	var followupyear = document.PROFILEUPDATE.Fyear.value;
	var follTime = new Date(followupyear,followupmonth,followupdate);
	followupmonth = parseInt(followupmonth);
	if(followupmonth <= 9)
		followupmonth = "0"+followupmonth;

	follTime.setHours(0);
	follTime.setMinutes(0);
	follTime.setSeconds(0);

	curdate.setHours(0);
	curdate.setMinutes(0);
	curdate.setSeconds(0);

	var curgetmonth = curdate.getMonth();
	curgetmonth = curgetmonth + 1;

	curdate.setMonth(curgetmonth);

	var currgettime = follTime.getTime();
	var timediff = parseInt((follTime.getTime()/1000)) - parseInt((curdate.getTime()/1000));
	if(timediff < 0)
	{
		alert("Follow up date should be equal to current date or greater than current date");
		return false;
	}
}

if(document.PROFILEUPDATE.FDATEEXP)
{
	var expcurDate = new Date();
	expcurDate.setHours(0);
	expcurDate.setMinutes(0);
	expcurDate.setSeconds(0);

	var expdate = document.PROFILEUPDATE.FDATEEXP.value;
	var expspl = expdate.split("-");
	var expTimeobj = new Date(expspl[0],(expspl[1]-1),expspl[2]);
	
	var expgettime = expTimeobj.getTime();
	var oneday = 60 * 60 * 24;
	var exptimediff = parseInt((expgettime)/1000) - parseInt((expcurDate.getTime()/1000));
	var numdays = exptimediff/oneday;
	if(numdays > 3 || numdays < 0)
	{
		alert("Offer Expiry date should be greater than Today");
		return false;
	}
}
//alert('FollowUp Date should be equal to current date or greater than current date');
if(document.PROFILEUPDATE.tstatus.value == 14 && document.getElementById('orderId').value == "")
{
	alert("Please Generate Order Id, by clicking (Generate Order-ID) link");
return false;
}
if (document.PROFILEUPDATE.fdesc.value=="")	{		
		alert ("Please enter your Comment");
		document.PROFILEUPDATE.fdesc.focus();
		return false;	
}
	
return true;

}

function doopen(UrlForOpen,WinSize){ 
		var newpopup=window.open(UrlForOpen,"EasyPay",WinSize);

		newpopup.focus();
}

function enableField(){	
	//2,3,4,6,7,8
//if (document.PROFILEUPDATE.tstatus.value == 14 || document.PROFILEUPDATE.tstatus.value == 5 || document.PROFILEUPDATE.tstatus.value == 1 || document.PROFILEUPDATE.tstatus.value == 9 || document.PROFILEUPDATE.tstatus.value==10 || document.PROFILEUPDATE.tstatus.value==11)
if (document.PROFILEUPDATE.tstatus.value == 14 || document.PROFILEUPDATE.tstatus.value == 5 || document.PROFILEUPDATE.tstatus.value == 1 || document.PROFILEUPDATE.tstatus.value == 9 || document.PROFILEUPDATE.tstatus.value == 15)
	{
		document.PROFILEUPDATE.Fmon.disabled=false;
		document.PROFILEUPDATE.Fday.disabled=false;
		document.PROFILEUPDATE.Fyear.disabled=false;		
	}
	else if(document.PROFILEUPDATE.tstatus.value == 1){
		document.PROFILEUPDATE.Fmon.disabled=true;
		document.PROFILEUPDATE.Fday.disabled=true;
		document.PROFILEUPDATE.Fyear.disabled=true;		
		document.easypay.submit();
		}
	else {
		document.PROFILEUPDATE.Fmon.disabled=true;
		document.PROFILEUPDATE.Fday.disabled=true;
		document.PROFILEUPDATE.Fyear.disabled=true;		
	}

		// ivr followup	
	if (document.PROFILEUPDATE.tstatus.value == 14)	{
		displayValue = "block";
		document.getElementById('view').style.display = displayValue;
		document.getElementById('ordehide').style.display = displayValue;
	} else {
		displayValue = "none";
		document.getElementById('view').style.display = displayValue;
		document.getElementById('ordehide').style.display = displayValue;
	}

	if (document.PROFILEUPDATE.tstatus.value == 2 || document.PROFILEUPDATE.tstatus.value == 3 || document.PROFILEUPDATE.tstatus.value == 4 || document.PROFILEUPDATE.tstatus.value == 6 || document.PROFILEUPDATE.tstatus.value==7 || document.PROFILEUPDATE.tstatus.value==8 || document.PROFILEUPDATE.tstatus.value==10 || document.PROFILEUPDATE.tstatus.value==11)
	{
		document.getElementById('offerframe').style.display = "none";
	}
	else
	{
		document.getElementById('offerframe').style.display = "block";
	}

}

//matching count
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

function matchingcount(matid){ 
	var xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null) 	{
		alert ("Your browser does not support AJAX!");return;
	}else {
		var url="supportgetsta.php";
		url=url+"?mid="+matid;
		xmlHttp.onreadystatechange=stateChangedmatch;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}

function stateChangedmatch() {
	if(xmlHttp.readyState==4){
		var returnstring = xmlHttp.responseText; 
		document.getElementById('msgcountdiv').innerHTML=returnstring;
	}
  }
}


var xmlHttp

/*
function orderidAjax(str1,str2,str3,str4,str5) {


	if((str4.value==0)  && (str2.value==0)) {
	alert("Select the Package");
	return;
	}
	else
		{ 
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
 	 	{
 	 	alert ("Your browser does not support AJAX!");
 		 return;
  		} 
		id=str1;
		if(str4.value!=0){
		str4val=str4.value;
		str4Array=str4val.split(",");
		payVal=str4Array[1];
		}
		if(str2.value!=0){
		str2val=str2.value;
		str2Array=str2val.split(",");
		payVal=str2Array[1];
		}
		

		//var pay=parseInt(str4Array[1])+parseInt(str2Array[1]); 
		var pay=parseInt(payVal);
		var coutrycode=str3.value;
		var url="ordergen.php";
		url=url+"?mid="+id;
		url=url+"&paycat="+pay;
		alert(str5);
		if(document.PROFILEUPDATE.elements['CountryselectedNew']) {
			if(str5.checked==true) {
				coutrycode= 98;
			}
			alert(coutrycode);
		}
		url=url+"&ccode="+coutrycode;
		alert(url);
		xmlHttp.onreadystatechange=stateChanged;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		} 
}
*/
function orderidAjax(mid) {

var reqcountrycode=	document.getElementById('SELECTEDCURRENCY').value;;
var lengthpack=document.PROFILEUPDATE.PACKAGESELECT.length;
var reqpack=document.getElementById('PACKAGESELECT').value;

var checked = false; 

	for (var i=0; i<lengthpack; i++) {
		if(document.PROFILEUPDATE.PACKAGESELECT[i].checked == true) {
		var packvalue=document.PROFILEUPDATE.PACKAGESELECT[i].value;
		checked=true;
		}
	}
	if(!checked) {
	alert("you have to choose a Package for Order id usage");
	return;
	}

		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
 	 	{
 	 	alert ("Your browser does not support AJAX!");
 		 return;
  		} 

		var url="ordergen.php";
		url=url+"?mid="+mid;
		url=url+"&paycat="+packvalue;
		url=url+"&ccode="+reqcountrycode;
		url=url+"&sid="+Math.random();
		url=url+"&ccode="+reqcountrycode;
		xmlHttp.onreadystatechange=stateChanged;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}
function stateChanged() { 
if (xmlHttp.readyState==4){ 
returnstring=xmlHttp.responseText;
		if(returnstring=="1"){
		alert("Unable to generate Order-ID now");
		}
		else if(returnstring=="Try again...")
		{
		alert("Generete New Order-Id...");
		}
		else if((returnstring!="Unable to generate Order-ID now") && (returnstring!="Try again..."))
		{
		$valuesren=returnstring.split(",");
		document.getElementById('ordehide').style.display = "none";
		document.getElementById("orderId").value=$valuesren[0];
		document.getElementById("ProID").value=$valuesren[1];
		document.getElementById('ordehide').style.display="none";
		}
	}
}

function disableanyone(offer) {
var packkey=new Array();
packkey=offer.split(",");

pack1=packkey[0];
pack2=packkey[1];
pack3=packkey[2];

//alert('pack1='+pack1);
//alert('pack2='+pack2);
//alert('pack3='+pack3);
//alert(typeof(packkey));
//alert(typeof(pack3));
//alert(pack2.indexOf('-'));
if(pack2.indexOf('-')!=-1) {
	var newpack=pack2.split("-");
	var assue=newpack[0];
}
else { var other2=pack2;   }

if(pack3.indexOf('-')!=-1) {
	var newpack=pack3.split("-");
	var assue=newpack[0];
}
else { var other3=pack3; }

if(document.getElementById('nextpack').checked==false) { //uncheck
	if(assue=='assured') {
		var cb=document.getElementById('Asslast').value;
		for (var i=0; i<cb; i++) {
		document.getElementById('assured'+i).disabled=false; //enable
		var falcount=1;
		}
	}  if((other2=='disPre') || (other2=='nextLvlOff') || (other2=='exPhNo')) {

	if(falcount==1) {
	document.getElementById(other2).disabled=true;	//disbale
	} else {
		document.getElementById(other2).disabled=false;	
		var falcount=1;
	}
	}  if(other3=='disPre' || other3=='nextLvlOff' || other3=='exPhNo') {
	if(falcount==1)
		document.getElementById(other3).disabled=true; // disable
		else
		document.getElementById(other3).disabled=false; // enable
	} 
	}
	else { //check
	if(assue=='assured') {
		var cb=document.getElementById('Asslast').value;
		for (var i=0; i<cb; i++) {
		document.getElementById('assured'+i).disabled=true;// disbale
		var falcountelse=1;
		}
	}  if(other2=='disPre' || other2=='nextLvlOff' || other2=='exPhNo') {

	if(falcountelse==1) {
	document.getElementById(other2).disabled=false;	 // enable
	} else {
		document.getElementById(other2).disabled=true;	//disable
		var falcountelse=1;
	}
	}  if(other3=='disPre' || other3=='nextLvlOff' || other3=='exPhNo') {
	if(falcountelse==1)
		document.getElementById(other3).disabled=false;
		else
		document.getElementById(other3).disabled=true;
	}
	}
}