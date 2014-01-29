var xmlHttp


function GetResult(str)
{
	document.getElementById('ViewResult').style.visibility="visible";
if (str.length==0)
  { 
  document.getElementById("ViewResult").innerHTML=""
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
	 document.getElementById('ViewResult').style.visibility="hidden";
	 document.getElementById('headother').style.visibility="hidden";
 }	
 else{
 document.getElementById("headother").style.visibility="visible";
 document.getElementById("ViewResult").innerHTML=xmlHttp.responseText ;
 }
 }
 
}
function GetXmlHttpObject()
{
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