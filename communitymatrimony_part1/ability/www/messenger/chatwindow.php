<?
/********************************************************************************
AUTHOR      : Karthikeyan.S, Dhanapal N
DESCRIPTION : Chat Window Codings.
MODIFICATION HISTORY:
****************************************************************************** 
| Version |	Date        | Author	                    | Remarks													 	
******************************************************************************
| 0.1     | 25-JAN-2009 | Dhanapal						| Initial Version    
/*******************************************************************************/

//FILE INCLUDES
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsBasicview.php");
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');

//VARIABLE DECLARATION
$varMatriId		= trim($_REQUEST['myid']);
$varOppositeId	= trim($_REQUEST['recpid']);
$varBlockedId	= '0';	

$varFirstMsg	= trim($_REQUEST['firstmsg']);
$varConditionArr= array();
$varMemberInfo	= array();

//OBJECT DECLARATION
$objBasicView	= new BasicView;
$objDBSlave		= new MemcacheDB;

//Slave connection
$objBasicView->dbConnect('S', $varDbInfo['DATABASE']);
$objDBSlave->dbConnect('S', $varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$varMatriId;

//SELECT MatriId
$varFields		= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
$varCondition	= "  WHERE MatriId ='".$varMatriId."'";
$varMatriIdInfo	= $objDBSlave->select($varTable['MEMBERINFO'], $varFields, $varCondition,0,$varOwnProfileMCKey);
$varGender		= $varMatriIdInfo["Gender"];
$varGender		= ($varGender=='1') ? 'M' : 'F';

//UNBLOCK USER
//if(!isset($_REQUEST["ref"])) {

$varCondition	= "  WHERE MatriId ='".$varMatriId."' AND BlockedId ='".$varOppositeId."'";
$varFields		= array('BlockedId');
$varBlockedId	= $objBasicView->numOfRecords($varTable['ICBLOCKED'], 'MatriId', $varCondition);

//$varExecute		= $objBasicView->select($varTable['ICBLOCKED'], $varFields, $varCondition,0);
//$varBlockedInfo	= mysql_fetch_assoc($varExecute);
//$varBlockedId= $varBlockedInfo["BlockedId"];
//echo 'Blocked Id='.$varBlockedId;

//} else { $varBlockedId=0; }



$varCondition				= " WHERE MatriId ='".$varOppositeId."'";
$varConditionArr['LIMIT']	= $varCondition;
$varSelectMemberDetails		= $objBasicView->selectDetails($varConditionArr, 'N');
$varMemberInfo				= $varSelectMemberDetails[0];
$varName				= urldecode($varMemberInfo['N']);
$varOppositeId			= strtoupper($varMemberInfo['ID']); // Opposite Id
$varDetails				= split('\^~\^',urldecode($varMemberInfo["DE"]));
$varAge					= $varDetails[0];
$varHeight				= $varDetails[1];
$varMaritalStatus		= $varDetails[2];
$varEducation			= $varDetails[3];
$varEducationDetails	= $varDetails[4];
$varOccupation			= $varDetails[5];
$varOccupationDetails	= $varDetails[6];

$varReligion	= $varDetails[7];
$varCaste		= $varDetails[8];
$varSubCaste	= $varDetails[9];
$varCountry		= $varDetails[10];
$varState		= $varDetails[11];
$varCity		= $varDetails[12];
$varLastLogin	= $varDetails[13];
$varPhotoStatus	= $varMemberInfo["PH"];

if ($varEducation=='Others' && $varEducationDetails !="" ) { $varEducation = $varEducationDetails;  }
else if ($varEducation!='Others' && $varEducationDetails !="" ) { $varEducation .= ', '.$varEducationDetails;  }

if ($varOccupation=='Others' && $varOccupationDetails !="" ) { $varOccupation = $varOccupationDetails;  }
else if ($varOccupation!='Others' && $varOccupationDetails !="" ) { $varOccupation .= ', '.$varOccupationDetails;  }

if ($varCaste !="") { $varReligion .= ': '.$varCaste; }
if ($varCaste !="" && $varSubCaste !="") { $varReligion .= ', Subcaste: '.$varSubCaste; }

$varDivPhoto	= '<div>';
if ($varPhotoStatus=='') {
	$varPhotoImage	= ($varGender=='M') ? 'f' : 'm';
	$varDivPhoto	= '<img src="'.$confValues['IMGSURL'].'/img85_phnotadd_'.$varPhotoImage.'.gif" width="85" height="85" border="0" alt=""/>';

} else if ($varPhotoStatus=='P') { //PROTECT PART COMES HERE
	$varDivPhoto	= '<img src="'.$confValues['IMGSURL'].'/img85_pro.gif" width="85" height="85" border="0" alt=""/>';
} else if($varPhotoStatus !="") {
	$varFirstPhoto	= split('\^', trim($varPhotoStatus));
	$varPhotoPath	= $confValues['PHOTOURL'].'/'.$varOppositeId{3}.'/'.$varOppositeId{4}.'/'.$varFirstPhoto[0];
	$varDivPhoto	= '<img src="'.$varPhotoPath.'" width="85" height="85" border="0" alt=""/>';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title> <?=$varMatriId." chatting with ".$varOppositeId;?> </title>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/iconimgs.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractions-sprites.css">
<script language="javascript"><? include_once($varRootBasePath."/www/template/commonjs.php"); ?></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/blockkeys.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/disright.js"></script>
<script src="<?=$confValues['JSPATH']?>/ajax.js"></script>
<script>var first_msg;</script>
<? if(strlen($varFirstMsg)>0) {echo "<script>first_msg='".$varFirstMsg."';</script>";} ?>
<script language="javascript1.3" type="text/javascript">
var recid = '<?php echo $varOppositeId;?>';
var recuser = '<?php echo $varOppositeId;?>';
var myid ='<?php echo $varMatriId;?>';

var gender ='<?php echo $varGender;?>';



var http = null;
var send_http=null;
var rec_http=null;
var win_http=null;
var block_http=null;
var opb_http=null;
var first_http=null;
var rec_ping;var win_ping;var send_glob=0;var waitmsg="";

//==============================================

function unblockChatUser() {
	document.getElementById('mainblock').innerHTML="<center><img src='"+varConfArr['domainimgs']+"/small-loading.gif' border='0'></center>";


unblk_http =msgn_getHTTPObject();
packet="BID="+recuser;
url=varConfArr['domainweb']+"/messenger/icunblocked.php";
unblk_http.open("POST", url, true);
unblk_http.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
unblk_http.setRequestHeader("Content-length", packet.length);
unblk_http.setRequestHeader("Connection", "close");
unblk_http.onreadystatechange =removeblockuser;
unblk_http.send(packet);

}

function refreshMainDiv() {
	window.location.href=varConfArr['domainweb']+'/messenger/chatwindow.php?myid='+myid+'&recpid='+recid+'&ref=1';
}
function divrefresh(){ //UN WANTED FUNCTION NEED TO CHECK..
	if(unblk_http.readyState==4){ 
 	 if(unblk_http.status==200){ 
		var refreshdivtext=unblk_http.responseText;
		document.getElementById('mainblock').innerHTML=refreshdivtext;
	 }
	}
}
function removeblockuser(){  
  if(unblk_http.readyState==4){ 
 	 if(unblk_http.status==200){ 
		var unblockrequest=unblk_http.responseText;
		document.getElementById('mainblock').innerHTML='Sucessfully unblocked';
		document.getElementById('mainblock').innerHTML="<center><img src='"+varConfArr['domainimgs']+"/small-loading.gif' border='0'></center>";
		refreshMainDiv();
		/*if(unblockrequest == 'RESULT=105')
		{
			document.getElementById('mainblock').innerHTML='Login Failed';
		}else if(unblockrequest == 'RESULT=510')
		{
			document.getElementById('mainblock').innerHTML='Please try Again';
		}
		else if(unblockrequest == 'RESULT=107'){
			document.getElementById('mainblock').innerHTML='Not Available profile table';
		}
		else if(unblockrequest == 'RESULT=110') {refreshMainDiv();
			document.getElementById('mainblock').innerHTML='Not Available in block table';
		}else if(unblockrequest == 'RESULT=141') 
		{
			document.getElementById('mainblock').innerHTML='Sucessfully unblocked';
			document.getElementById('mainblock').innerHTML="<center><img src='http://imgs.bharatmatrimony.com/bmimages/loading-icon.gif' border='0'></center>";
			refreshMainDiv();
		}else if(unblockrequest == 'RESULT=150'){ 
			document.getElementById('mainblock').innerHTML='DB ERROR';
		}*/
  	 }
   }
 }


//To find domain


function findloc()
{loc=location.href;loc=loc.toLowerCase();loc=loc.substring(0,(loc.indexOf('.com/')));dm=loc.substring(loc.indexOf('.'),loc.length);dm=dm+".com";
return dm}
function setCookie(c_name,value){document.cookie = c_name + "=" + escape(value)+";DOMAIN="+findloc()+";PATH=/";}
function genNumbers() {var d=new Date();var rand_flag = "ms"+d.getSeconds()+"gn";return rand_flag;}

function ismaxlength(obj){
var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
if (obj.getAttribute && obj.value.length>mlength)
obj.value=obj.value.substring(0,mlength)
}

function IsEmpty(obj, obj_type)
{
	if (obj_type == "text" || obj_type == "textarea")
	{var objValue;objValue = obj.value.replace(/\s+$/,"");if (objValue.length == 0) {return true;} else {return false;}}
}

/*Get cookie value*/
function GetCookie(name)
{
var cname = name + "=";var dc = document.cookie;
if (dc.length > 0)
{ 
	begin = parseInt(dc.indexOf(cname));
	if (begin >= 0)
	{
		begin += cname.length;end = dc.indexOf(";", begin);
		if (end == -1) end = dc.length;return unescape(dc.substring(begin, end));
	}
}
return null;
}

function msgn_getHTTPObject() {
	var http = false;
	//Use IE's ActiveX items to load the file.
	if(typeof ActiveXObject != 'undefined') {
		try {http = new ActiveXObject("Msxml2.XMLHTTP");}
		catch (e) {
			try {http = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (E) {http = false;}
		}
	//If ActiveX is not available, use the XMLHttpRequest of Firefox/Mozilla etc. to load the document.
	} else if (XMLHttpRequest) {
		try {http = new XMLHttpRequest();}
		catch (e) {http = false;}
	}
	return http;
}

function sendMsg(newMsg) 
{	
	try{
		if(send_glob==0)
		{
		send_glob=1;
		send_http =msgn_getHTTPObject();
		packet="type=send&domainname="+varConfArr['DOMAINCASTEID']+"&to="+recid+"&from="+myid+"&message="+newMsg+"&gender="+gender+"&trand="+genNumbers();
		url=varConfArr['domainweb']+"/http-bind/";
		send_http.open("POST", url, true);
		send_http.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
		send_http.setRequestHeader("Content-length", packet.length);
		send_http.setRequestHeader("Connection", "close");
		send_http.onreadystatechange =send_respon;
		send_http.send(packet);
		}
		else {if(waitmsg.length==0){waitmsg=newMsg;}else{waitmsg+="~"+newMsg;}}
	}
	catch(e) {}
}

function send_respon(){
try{
	if(send_http.readyState == 4 && send_http.status == 200) 
	{
		send_glob=0;
		send_process(send_http.responseText);
	}
} catch(e) {}
}

function send_process(send_res_txt)
{
	if(send_res_txt!=null && send_res_txt!="")
		{
			send_txt=send_res_txt;
			if(send_txt!="ok" && send_txt!="err" && send_txt!="invldreq" && send_txt.indexOf('Internal Server Error')==-1)
			{
				if(send_txt.indexOf('~')!=-1)
				{
					var send_arr=send_txt.split('~');
					for(i=0;i<send_arr.length;i++)
					{
						if(send_arr[i]=="#block#")
						{
						printMsg_rec(recuser,"<font color='red'><b>This member has blocked you.</b></font>",'red');document.getElementById('msg').disabled=true;document.getElementById('send').disabled=true;}
						else if(send_arr[i]=="#out#")
						{printMsg_rec(recuser,"<font color='red'><b>The member has logged out.</b></font>",'red');}
						else{printMsg_rec(recuser,send_arr[i],'red');}
					}
				}
				else
				{
					if(send_txt=="#block#")
					{printMsg_rec(recuser,"<font color='red'><b>This member has blocked you.</b></font>",'red');document.getElementById('msg').disabled=true;document.getElementById('send').disabled=true;}
					else if(send_txt=="#out#")
					{printMsg_rec(recuser,"<font color='red'><b>The member has logged out.</b></font>",'red');}
					else{printMsg_rec(recuser,send_txt,'red');}
				}
			}
			if(waitmsg.length!=0){sendMsg(waitmsg);waitmsg="";}
		}
}

function reciveMsg() 
{	
	try
	{
	clearTimeout(rec_ping);
	rec_http =msgn_getHTTPObject();
	packet="type=startmpoll&domainname="+varConfArr['DOMAINCASTEID']+"&gender="+gender+"&from="+myid+"&buddyid="+recid+"&trand="+genNumbers();
	url=varConfArr['domainweb']+"/http-bind/";
	rec_http.open("POST", url, true);
	rec_http.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
	rec_http.setRequestHeader("Content-length", packet.length);
	rec_http.setRequestHeader("Connection", "close");
	rec_http.onreadystatechange =rec_respon;
	rec_http.send(packet);
	}
	catch (e) {}
}

function rec_respon()
{
	try{
		if(rec_http.readyState == 4 && rec_http.status == 200) 
		{
			rec_ping=setTimeout('reciveMsg();',5000);
			var res_msg=rec_http.responseText;
			res_process(res_msg);
		}
	} catch (e) {}
}

function res_process(res_msg)
{
	if(res_msg!=null && res_msg!="")
	{			
		var rec_txt=res_msg;
		if(rec_txt!="nomsg" && rec_txt!="err" && rec_txt!="invldreq" && rec_txt.indexOf('Internal Server Error')==-1)
		{
			if(rec_txt.indexOf('~')!=-1)
			{
				var rec_arr=rec_txt.split('~'); for(i=0;i<rec_arr.length;i++)
				{
					if(rec_arr[i]=="#block#")
					{printMsg_rec(recuser,"<font color='red'><b>This member has blocked you.</b></font>",'red');document.getElementById('msg').disabled=true;document.getElementById('send').disabled=true;}
					else if(rec_arr[i]=="#out#")
					{printMsg_rec(recuser,"<font color='red'><b>The member has logged out.</b></font>",'red');}
					else{printMsg_rec(recuser,rec_arr[i],'red');}
				}
			}
			else
			{
				if(rec_txt=="#block#")
				{printMsg_rec(recuser,"<font color='red'><b>This member has blocked you.</b></font>",'red');document.getElementById('msg').disabled=true;document.getElementById('send').disabled=true;}
				else if(rec_txt=="#out#")
				{printMsg_rec(recuser,"<font color='red'><b>The member has logged out.</b></font>",'red');}
				else{printMsg_rec(recuser,rec_txt,'red');}
			}
		}
	}
}

 function entsub(e) 
{   
	var agt, isIe, isGecko, key;var keychar;var splcheck;

	agt = navigator.userAgent.toLowerCase();
	isIE    = ((agt.indexOf("msie")  != -1) && (agt.indexOf("opera") == -1));
	isGecko = ((agt.indexOf('gecko') != -1) && (agt.indexOf("khtml") == -1));

	if (isIE)
	{
		key = window.event.keyCode;
		if (key == 13){addEvent();event.keyCode = 0;}
	}

	if(isGecko)
	{
		key = e.which;
		if (key == 13){addEvent();(e.which) ? e.which : 0;return false;}
	}
	keychar = String.fromCharCode(key)
	splcheck = /\'|\"/
	return !splcheck.test(keychar);
	
}

function addEvent()
{  
	if(!IsEmpty(document.frm.msg,'textarea'))
	{printMsg(document.frm.myid.value,document.frm.msg.value,'green');
		sendMsg(escape(document.frm.msg.value));document.frm.msg.value="";clearmsg="";
	}
	document.frm.msg.focus();
}

function printMsg(id,mess,tcolor)
{   
	txtcolor=tcolor;
	var ni = document.getElementById('myDiv');
	var numi = document.getElementById('theValue');
	var num = (document.getElementById("theValue").value -1)+ 2;
	numi.value = num;
	var divIdName = "my"+num+"Div";
	var newdiv = document.createElement('div');
	newdiv.setAttribute("id",divIdName);
	mess=mess.replace(/SYSMSG/,"<font color='#ff0000'><b>");
	mess=mess.replace(/CSYSMSG/,"</b></font>");
	newdiv.innerHTML ="<div class='apclass'><font color='"+txtcolor+"'><b>"+id+"</b>:</font>"+unescape(mess)+"</div>";
	ni.appendChild(newdiv);
	document.getElementById('myDiv').scrollTop = 99999;
	document.frm.msg.focus();
}

function printMsg_rec(id,mess,tcolor)
{   
	txtcolor=tcolor;
	var ni = document.getElementById('myDiv');
	var numi = document.getElementById('sValue');
	var num = (document.getElementById("sValue").value -1)+ 2;
	numi.value = num;
	var divIdName = "s"+num+"Div";
	var newdiv = document.createElement('div');
	newdiv.setAttribute("id",divIdName);
	mess=mess.replace(/SYSMSG/,"<font color='#ff0000'><b>");
	mess=mess.replace(/CSYSMSG/,"</b></font>");
	newdiv.innerHTML ="<div class='apclass'><font color='"+txtcolor+"'><b>"+id+"</b>:</font>"+unescape(mess)+"</div>";
	ni.appendChild(newdiv);
	document.getElementById('myDiv').scrollTop = 99999;
	document.frm.msg.focus();
}

function firstcall()
{
try{
	if(first_msg==null || first_msg=="" || first_msg=="undefined")
	{
		first_http =new msgn_getHTTPObject();
		packet="type=firstmpoll&domainname="+varConfArr['DOMAINCASTEID']+"&gender="+gender+"&from="+myid+"&buddyid="+recid;
		url=varConfArr['domainweb']+"/http-bind/";
		first_http.open("POST", url, true);
		first_http.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
		first_http.setRequestHeader("Content-length", packet.length);
		first_http.setRequestHeader("Connection", "close");
		first_http.onreadystatechange =first_respon;
		first_http.send(packet);
	}
	else
	{
		if(first_msg.indexOf('~')!=-1)
		{
			var first_arr=first_msg.split('~');
			for(f=0;f<first_arr.length;f++)
			{
				if(first_arr[f]=="#block#")
				{printMsg(recuser,"<font color='red'><b>This member has blocked you.</b></font>",'red');document.getElementById('msg').disabled=true;document.getElementById('send').disabled=true;}
				else if(first_arr[f]=="#out#")
				{printMsg(recuser,"<font color='red'><b>The member has logged out.</b></font>",'red');}	
				else{printMsg(recuser,first_arr[f],'red');}
			}
		}
		else
		{
			if(first_msg=="#block#")
			{printMsg(recuser,"<font color='red'><b>This member has blocked you.</b></font>",'red');document.getElementById('msg').disabled=true;document.getElementById('send').disabled=true;}
			else if(first_msg=="#out#")
			{printMsg(recuser,"<font color='red'><b>The member has logged out.</b></font>",'red');}	
			else{printMsg(recuser,first_msg,'red');}
		}

		rec_ping=setTimeout('reciveMsg();',10000);
	}
	} catch (e) {}
}

function first_respon()
{
	try{
		if(first_http.readyState == 4 && first_http.status == 200) 
		{rec_ping=setTimeout('reciveMsg();',10000);}
	} catch (e) {}
}


//block
function block_call()
{

	block_http =new msgn_getHTTPObject();
	packet="BID="+recuser;
	url=varConfArr['domainweb']+"/messenger/icblocked.php";
	block_http.open("POST", url, true);
	block_http.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
	block_http.setRequestHeader("Content-length", packet.length);
	block_http.setRequestHeader("Connection", "close");
	block_http.onreadystatechange =block_respon;
	block_http.send(packet);
}

function block_respon()
{
	try{
		if(block_http.readyState == 4 && block_http.status == 200) 
		{
			alert("You have successfully blocked this member.");
			window.close();
			/*if(block_http.responseText!=null && block_http.responseText!="")
			{
				var block_txt=block_http.responseText;
				if(block_txt.indexOf('&')!=-1)
				{
					var block_arr=block_txt.split('&');
					if(block_arr[1]=="RESULT=201"){alert("You have successfully blocked this member."); window.close();
				}
				}
			}*/
		}
	} catch (e) {}
}


function close_win()
{
	var cl_win_id;
	if(GetCookie("closewin")==null || GetCookie("closewin")=="null"){setCookie("closewin",recid);}
	else{cl_win_id=GetCookie("closewin")+"~"+recid;setCookie("closewin",cl_win_id);}
}
</script>
</head> 
<? if($varBlockedId > 0) {
		echo "<body style='margin:0px;'><center><br><br><div id='mainblock'>You have already Deny this member to chat. <a href='javascript:;' class='clr1' onclick=\"javascript:unblockChatUser();\"> Click here </a> to Allow chat</center></div>";
 } else {
 ?>

<body style="margin:0px;" onload="firstcall();" onKeyDown="return disableCtrlKeyCombination(event)" onbeforeunload="close_win()">
<div style="width:496px;position:relative;" id="mainblock">
	<div style="position:absolute;">
		<div style="float:left;background-image: url('<?=$confValues['IMGSURL']?>/top_left_curve.gif'); width:4px; height:29px;"></div>	
		<div style="float:left;width:488px;background: url(<?=$confValues['IMGSURL']?>/chat_bg.gif) repeat-x;height:29px;">
			<div style="padding: 3px 0px 0px 5px;color:#868686;width:227px;" class="fleft"><img src="<?=$confValues['IMGSURL']?>/chatlogo/<?=$arrDomainInfo[$varDomain][2]?>_logo.gif" height="26" /></div>
			<div style="padding-top: 5px;color:#868686;" class="fleft normtxt bld">Matrimony Messenger</div>
			<div class="fright padt5"><a href="javascript:window.close();" class="smalltxt clr1">Close</a></div>
		</div>
		<div style="float:left;background-image: url('<?=$confValues['IMGSURL']?>/top_right_curve.gif');width:4px; height:29px;"></div>
	</div>
	<!--{ Middle Area -->
	<div style="position:absolute;margin-top:29px;background:#F5F5F5;width:494px !important;width:496px;border-left: 1px solid #CECECE;border-right: 1px solid #CECECE;">
		<div class="fleft" style="width:490px;">
			<div class="fleft" style="padding: 8px 0px 3px 7px;">

				<div id="imagecontainer">
					<div id="useracticons">
						<div style="float: left;" id="useracticonsimgs">
							<div style="float: left;">
								<a style="cursor: pointer;" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=viewprofile&id=<?=$varOppositeId?>" target="_blank"><?=$varDivPhoto?></a>
							</div>
						</div>
					</div>
				</div>
				<div class="fleft" style="width:330px;"><div class="fleft mediumtxt" style="padding-left:10px;"><a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=viewprofile&id=<?=$varOppositeId?>" class="mediumtxt bld clr" target="_blank"><?php echo $varName." "."(".$varOppositeId.")"; ?></a><br clear="all">
				<?=$varAge;?> yrs, <?=$varHeight;?> | <?=$varReligion?> | <?=$varCountry;?> | <?=$varEducation;?> | <?=$varOccupation;?> <a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=viewprofile&id=<?=$varOppositeId?>" class="mediumtxt clr1" target="_blank">Full Profile >></a>
				</div>
				
				</div>
				<br clear="all">
				<div class="fleft" style="padding-top:4px;">
				<div style="float:right;text-align:right;" class="smalltxt"><a href="javascript:block_call();" class="smalltxt clr1 fright bld">Deny chat</a>&nbsp;</div>
					<div class="fleft" id="myDiv" style="width:478px !important;width:480px;height:98px !important;height:100px;overflow:auto;border: 1px solid #CECECE;background:#ffffff;">
					<!-- Text  -->
					<div class="apclass" id="myDiv1" ></div>
					<div class="apclass" id="sDiv1" ></div>
					<!-- Text  -->
					</div>					
				</div>
			
		</div> <br clear="all">	
		
		<div style="background:#F5F5F5;height:82px; padding: 0px 0px 0px 7px;" id="type_area">
			<div class="fleft"><form name="frm" >
		<textarea name="msg" id="msg" rows="3" cols="40" maxlength="500" style="width:390px;height:80px;border: 1px solid #CECECE;" onKeyPress="return entsub(event)" onkeyup="return ismaxlength(this)"></textarea> 
		<input type="hidden" name="recpid" value="<?=$varOppositeId;?>"><input type="hidden" name="myid" value="<?=$varMatriId?>" id="myid"><input type="hidden" name="latest" value=""><input type="hidden" value="0" id="theValue" /><input type="hidden" value="0" id="sValue" /></form>
		
	 </div><div class="fleft" style="margin-top:1px !important;margin-top:2px;height:78px;background:#fff;border: 1px solid #CECECE;border-left:0px;"><div  style="padding: 25px 0px 0px 0px;width:88px;text-align:center;"><input type="button" class="button" value="Send" id="send" onClick="addEvent()"></div></div></div>
		</div>
	</div>
	<!-- Middle Area }-->
	<div style="position:absolute;margin-top:325px !important;margin-top:328px;">
		<div class="fleft" style="background: url(<?=$confValues['IMGSURL']?>/chat-curv-left.gif);width:6px;height:6px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="6" height="6" border="0" alt=""/></div>
		<div class="fleft" style="width:484px;background:#F5F5F5;border-bottom: 1px solid #CECECE;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5" border="0" alt=""/></div>
		<div class="fleft" style="background: url(<?=$confValues['IMGSURL']?>/chat-curv-right.gif);width:6px;height:6px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="6" height="6" border="0" alt=""/></div>
	</div>
	<div class="fleft" style="position:absolute;padding-left:7px;"><div style="background: url(<?=$confValues['IMGSURL']?>/chat-logo.gif); width:103px; height:35px;"></div></div>
</div><? } ?>
</body>
</html>
