var objAjax,globaldivid='',closedivid='',reqComeFrom=0; //reqComeFrom=0 means viewprofile, reqComeFrom=1 full profile

function displayBigPhoto(photoname,matid1,matid2,currpgno) {
	var divid='', imgstr = pho_url+"/"+matid1+"/"+matid2+"/"+photoname;
	divid = 'bigviewphoto'+currpgno;
	$(divid).innerHTML =  '<img src="'+imgstr+'" width="170" height="170" />';
	
}

function displayBigCropPhoto(photoname,currpgno) {
	var imgstr = pho_url+"/"+photoname;
	divid = 'bigviewphoto'+currpgno;
	$(divid).innerHTML =  '<img src="'+imgstr+'" width="170" height="170" />';
	
}

function funVP(matid,opt){
if(previnnerdiv != ''){hide_box_div(previnnerdiv);}
if(opt==matid+'Hi'){$(matid+'Hi').className='clr bld';$(matid+'vp1').className='padtb10 viewdiv1 disblk';}else{$(matid+'Hi').className='clr1';$(matid+'vp1').className='disnon';}
if(opt==matid+'abme'){$(matid+'abme').className='clr bld';$(matid+'vp2').className='padtb10 viewdiv1 disblk';}else{$(matid+'abme').className='clr1';$(matid+'vp2').className='disnon';}
if(opt==matid+'photos'){$(matid+'photos').className='clr bld';$(matid+'vp3').className='padtb10 viewdiv1 disblk';}else{$(matid+'photos').className='clr1';$(matid+'vp3').className='disnon';}
if(opt==matid+'horos'){$(matid+'horos').className='clr bld';$(matid+'vp4').className='padtb10 viewdiv1 disblk';}else{$(matid+'horos').className='clr1';$(matid+'vp4').className='disnon';}
if(opt==matid+'lifest'){$(matid+'lifest').className='clr bld';$(matid+'vp5').className='padtb10 viewdiv1 disblk';}else{$(matid+'lifest').className='clr1';$(matid+'vp5').className='disnon';}
if(opt==matid+'famly'){$(matid+'famly').className='clr bld';$(matid+'vp6').className='padtb10 viewdiv1 disblk';}else{$(matid+'famly').className='clr1';$(matid+'vp6').className='disnon';}
if(opt==matid+'mypart'){$(matid+'mypart').className='clr bld';$(matid+'vp7').className='padtb10 viewdiv1 disblk';}else{$(matid+'mypart').className='clr1';$(matid+'vp7').className='disnon';}
if(opt==matid+'cont'){$(matid+'cont').className='clr bld';$(matid+'vp8').className='padtb10 viewdiv1 disblk';}else{$(matid+'cont').className='clr1';$(matid+'vp8').className='disnon';}
}

function checktwitdiv(matid)
{
	var twitid = matid+'twitmain';
	if(document.getElementById(twitid).style.display=='block'){document.getElementById(twitid).style.display='none';}
}

var TabNxtVar = 0;
var splarr ='';
function slidemtab(matid,dname, hpscount,missedtab) {
	checktwitdiv(matid);
	splarr=missedtab.split('~');

	for(var i=1; i<=8; i++)
		{
			if(i==splarr[4] || i==splarr[3] || i==splarr[2] || i==splarr[1] || i==splarr[0]) {continue;}
			var divid = matid+"vp"+i;
			var tdivid = matid+"vtab"+i;
			
			document.getElementById(divid).className="disnon";
			document.getElementById(tdivid).className="notbld clr1";
		}

		for(var i=1; i<=8; i++)
		{
			if(i==splarr[4] || i==splarr[3] || i==splarr[2] || i==splarr[1] || i==splarr[0]) {continue;}
			var divid1 = matid+"vp"+i;
			var tdivid = matid+"vtab"+i;

			if(divid1==dname && TabNxtVar==0)
			{	
				document.getElementById(dname).className = "padtb10 viewdiv1 disblk";
				document.getElementById(tdivid).className = "clr bld";
			}
		}
	}


function slideclick(matid,c, hpscount,missedtab) {	
	checktwitdiv(matid);
	splarr=missedtab.split('~');
	if(c=="nxt" && TabNxtVar==0)
		{
			for(var i=1; i<=8; i++)
			{
				var divid = matid+"vp"+i;
				var tdivid = matid+"vtab"+i;
					if(document.getElementById(divid).className=="padtb10 viewdiv1 disblk")
					{
					document.getElementById(divid).className="disnon";
					document.getElementById(tdivid).className="notbld clr1";
					if(i==8)
					{
						i=1;						
						var divid1 = matid+"vp"+i;
						var tdivid = matid+"vtab"+i;
						document.getElementById(divid1).className="padtb10 viewdiv1 disblk";						
						document.getElementById(tdivid).className = "clr bld";
					}
					else
					{
						i++;
						if(i==splarr[0]){i++;}
						if(i==splarr[1]){i++;}
						if(i==splarr[2]){i++;}
						if(i==splarr[3]){i++;}
						if(i==splarr[4]){i++;}
						var divid1 = matid+"vp"+i;
						var tdivid = matid+"vtab"+i;
						document.getElementById(divid1).className="padtb10 viewdiv1 disblk";						
						document.getElementById(tdivid).className = "clr bld";
					}					
				}
			}
		}


	if(c=="prev" && TabNxtVar==0)
		{
			for(var i=1; i<=8; i++)
			{
				var divid = matid+"vp"+i;
				var tdivid = matid+"vtab"+i;
				if(document.getElementById(divid).className=="padtb10 viewdiv1 disblk")
				{
					document.getElementById(divid).className="disnon";
					document.getElementById(tdivid).className="notbld clr1";
	
					if(i==1)
					{						
						i=8;
						var divid1 = matid+"vp"+i;
						var tdivid = matid+"vtab"+i;
						document.getElementById(divid1).className="padtb10 viewdiv1 disblk";						
						document.getElementById(tdivid).className = "clr bld";
					}
					else
					{
						i--;
						if(i==splarr[4]){i--;}
						if(i==splarr[3]){i--;}
						if(i==splarr[2]){i--;}
						if(i==splarr[1]){i--;}
						if(i==splarr[0]){i--;}

						var divid1 = matid+"vp"+i;
						var tdivid = matid+"vtab"+i;
						document.getElementById(divid1).className="padtb10 viewdiv1 disblk";						
						document.getElementById(tdivid).className = "clr bld";
	
					}
					
				}
			}
		}
	}


function showOption(optval) {
	a="msg1div"+optval;
	b="msg2div"+optval;
	c="firstct"+optval;
	$(a).className = "disblk";
	$(b).className = "disnon";
	$(c).className = "disnon";
}

function swapdiv(vpgno, msgdivno) {
	a="radio1div"+vpgno;
	b="radio2div"+vpgno;
	if(msgdivno == '1') {
		$(a).className = "disblk tlcenter";
		$(b).className = "disblk";
		if(cook_paid=='1' && cook_publish=='1'){
		buttVal= '<input type="button" class="button" value="Send Message" onclick="javascript:RTESubmit(\'\');show_box(event,\'div_box'+vpgno+'\');">';
		}else{buttVal = '<input type="button" class="button" value="Send Message">';}
		$('buttonSub'+vpgno).innerHTML = buttVal;
	} else if(msgdivno == '2') {
		$(b).className = "disblk";
		$(a).className = "disblk tlcenter";
		$('buttonSub'+vpgno).innerHTML = '<input type="button" class="button" value="Send Message" onclick="javascript:sendInterest('+vpgno+');show_box(event,\'div_box'+vpgno+'\');">';
	}
}

function getPhoneView(matid,divid,curpgno,pgename){
	url		= ser_url+'/phone/phoneview.php?rno='+Math.random();
	globaldivid='';
	globaldivid=divid;
	param	= 'id='+matid+'&divnname='+divid+'&curpgno='+curpgno+'&pgename='+pgename;
	objAjax = AjaxCall();
	AjaxPostReq(url,param,phoneResponse,objAjax);
}

function fnphonecomplaint(currentpageno){
	var selIndex = 'document.buttonfrm.complaint'+currentpageno+'.selectedIndex';
	var errdiv = "document.getElementById('error"+currentpageno+"')";
	if (eval(selIndex)==0) {
		eval(errdiv).innerHTML="Select the reason<br>";
		return false;
	} else {
		var probid = eval('document.buttonfrm.problemid'+currentpageno+'.value');
		var phdetail = eval('document.buttonfrm.phonedetail'+currentpageno+'.value');
		var senid = eval('document.buttonfrm.senderid'+currentpageno+'.value');
		var comp = eval('document.buttonfrm.complaint'+currentpageno+'.value');
		var phndiv = eval('document.buttonfrm.phnediv'+currentpageno+'.value');
		var index = eval(selIndex);
		
		globaldivid='';
		globaldivid=phndiv;

		eval(errdiv).innerHTML="";
		parameters='problemid='+probid+'&phonedetail='+phdetail+'&senderid='+senid+'&complaint='+comp+'&index='+index;
		var argUrl= ser_url+'/phone/phonethanks.php?rno='+Math.random();
		
		objAjax=AjaxCall();
		AjaxPostReq(argUrl,parameters,phoneResponse,objAjax);
	}
}

function phoneResponse() {
	if(objAjax.readyState == 4){
		//$('phmsg').className = "disnon";
		$(globaldivid).innerHTML = objAjax.responseText;
	}else{
		$(globaldivid).innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}

function sendRequest(matid,reqid,divid,cldivid,reqComeFrom) {
	url		= ser_url+'/request/request.php?rno='+Math.random();
	param	= 'id='+matid+'&rid='+reqid+'&reqCF='+reqComeFrom;
	closedivid = '';
	closedivid = cldivid;
	globaldivid='';
	globaldivid=divid;
	objAjax = AjaxCall();
	AjaxPostReq(url,param,requestResponse,objAjax);
}

function requestResponse() {
	if(objAjax.readyState == 4){
		$(globaldivid).innerHTML = objAjax.responseText;
	}else{
		$(globaldivid).innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}

function displayAlert(divid,cldivid,reqid) {
	var requestpart='';
	closedivid = '';
	closedivid = cldivid;
	globaldivid='';
	globaldivid=divid;
	if(reqid==3) {
		requestpart='phone number';
	} else if(reqid==5) {
		requestpart='horoscope';
	} 
	$(divid).innerHTML = '<div class="fright"><img src="'+imgs_url+'/close.gif" onclick="hide_box();" href="javascript:;" class="pntr" /></div><br clear="all"/><a class="clr1 bld" href="/profiledetail/index.php?act=primaryinfo">Verify your phone number</a> to view '+requestpart+'.<div class="fright padt10"><input type="button" class="button" value="Close" onclick="hide_box();"/></div>';
}

function showContactHistory(matid,oppmatid,divid,cldivid,reqComeFrom) {
	url		= ser_url+'/mymessages/contacthistory.php?rno='+Math.random();
	param	= 'ID='+oppmatid+'&reqCF='+reqComeFrom;
	closedivid = '';
	closedivid = cldivid;
	globaldivid='';
	globaldivid=divid;
	objAjax = AjaxCall();
	AjaxPostReq(url,param,contactHistoryResponse,objAjax);
}

function contactHistoryResponse() {
	if(objAjax.readyState == 4){
		$(globaldivid).innerHTML = objAjax.responseText;
	}else{
		$(globaldivid).innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}

function hide_box(){
	hide_box_div(closedivid);
}

function getPhotoView(matid){
	var passwd = $('password').value;
	if(passwd.replace('/\s+/','')==''){
		 $('protecterror').innerHTML='Enter photo password';
		 passwd='';
		 $('password').focus();
		 return false;
	}else{
		$('protecterror').innerHTML="";
		url		= ser_url+'/photo/photoverifypassword.php?rno='+Math.random();
		param	= 'ID='+matid+'&password='+passwd;
		objAjax = AjaxCall();
		AjaxPostReq(url,param,photoResponse,objAjax);
	}
}

function photoResponse() {
	if(objAjax.readyState == 4){
		 var str	= new Array();
		 str		= objAjax.responseText.split('~');
		 if (str[0] == 1) {
			 	openphoto = window.open(img_url+"/photo/viewphoto.php?ID="+str[1]+"&PID="+str[2],'','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');
		 } else {
			$('protecterror').innerHTML="Photo password did not match.";
			passwd='';
			$('password').focus();
		 }
		 $("photodiv").innerHTML = '';
	}else{
		$("photodiv").innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}


function getHoroscopeView(matid){
	var passwd = $('horopass').value;
	if(passwd.replace('/\s+/','')==''){
		 $('horoprotecterror').innerHTML='Enter horoscope password';
		 passwd='';
		 $('horopass').focus();
		 return false;
	}else{
		$('horoprotecterror').innerHTML="";
		url		= ser_url+'/horoscope/horoscopeverifypassword.php?rno='+Math.random();
		param	= 'ID='+matid+'&password='+passwd+'&frmPasswordSubmit=yes';
		objAjax = AjaxCall();
		AjaxPostReq(url,param,horoscopeResponse,objAjax);
	}
}

function horoscopeResponse() {
	if(objAjax.readyState == 4){
		 var str	= new Array();
		 str		= objAjax.responseText.split('~');
		 if (str[0] == 1) {
			 	openphoto = window.open(img_url+"/horoscope/viewhoroscope.php?ID="+str[1],'','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');
		 } else {
			$('horoprotecterror').innerHTML="Horoscope password did not match.";
			passwd='';
			$('horopass').focus();
		 }
		 $("horodiv").innerHTML = '';
	}else{
		$("horodiv").innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}



var ajaxobj=false;
var twitcurrentPgNo = '';
var paidstatus = '';

var ajaxobj1=false;
var varhorodivid='';
var varhorocontentdivid='',horocpno='';

function showhoromatch(horodivid,matriid,partnermatriid,htype,horocontentdivid) {
	var argurl="/horoscope/horoscopematch.php";
	var htyp='';
	totforms = document.forms.length;
	for(jj=0; jj<totforms; jj++){
		if(document.forms[jj].name == 'frmSearchConds'){
		htyp = document.frmSearchConds.htype_search.value;
		}	
	}
	if(htyp!=''){htype=htyp;}	
	var postval = "loginid="+matriid+"&htype="+htype+"&partnerid="+partnermatriid;
	varhorodivid=horodivid;
	varhorocontentdivid=horocontentdivid;	
	ajaxobj1=AjaxCall();
	AjaxPostReq(argurl,postval,populatehoromatch,ajaxobj1);
}

function disphoromatch(){
document.getElementById('msgactpart'+viewrec).innerHTML = document.getElementById('horomatchcontentdiv-'+viewrec).innerHTML;
closedivid = 'div_box'+viewrec;
}

function populatehoromatch() {
	if (ajaxobj1.readyState == 4 && ajaxobj1.status == 200) {
		var b=ajaxobj1.responseText;
		
		if(b!='ERR'){	
			var temptext = new Array();temptext = b.split('|');
			if(temptext[0]!=''){
				temptextnormal=temptext[0].split('~');
				if(temptextnormal[0]!='' && temptextnormal[1]!='' && temptextnormal[2]!='' && temptextnormal[3]!=''){
					var t='<a class="clr1" onClick="disphoromatch();show_box(event,\''+'div_box'+viewrec+'\');">'+temptextnormal[4]+'</a>';
					closedivid = 'div_box'+viewrec;
					document.getElementById(varhorodivid).innerHTML=t;
					document.getElementById('horomatchcontentdiv-'+viewrec).innerHTML='<div class="fright"><img class="pntr" href="javascript:;" onclick="hide_box();" src="'+imgs_url+'/close.gif"/></div><br clear="all">'+temptextnormal[0];
				}
			}
		}
		//document.getElementById(varhorodivid).innerHTML=ajaxobj1.responseText;
	}
}
function showTwitterUp(cpno,matid) {
	twitcurrentPgNo = cpno;
	var argurl="/profiledetail/twitter_req.php";
	var postval = "matriid="+matid;
	ajaxobj=AjaxCall();
	AjaxPostReq(argurl,postval,populateTwitter,ajaxobj);
}

function populateTwitter() {
	if (ajaxobj.readyState == 4 && ajaxobj.status == 200) {
		if(ajaxobj.responseText != '0') {
			eval("respTxt="+ajaxobj.responseText);
			var rettwitterid = respTxt['twitterid'];
			var msgsize = respTxt['numberOfMessages'];
			var twitmaindiv = twitcurrentPgNo+'twitmain';
			var curtwitterdiv = twitcurrentPgNo+'twitterdiv';

			document.getElementById(twitmaindiv).style.display="block";
			document.getElementById(curtwitterdiv).innerHTML = "<img src='http://img.communitymatrimony.com/images/loading-icon.gif' />";

			if(msgsize > 0) {
				var respMsg = '';
				var respMsgArray = respTxt['messages'];
				for(i=0; i<msgsize; i++) {
					respMsg += respMsgArray[i]['msg']+'<br><div class=\'dotsep\'><img src=\'images/trans.gif\' width=\'1\' height=\'1\' /></div><br>';
				}
				document.getElementById(curtwitterdiv).innerHTML	= respMsg;
			} else {
				document.getElementById(curtwitterdiv).innerHTML	= "No messages";
			}
		} else {
			document.getElementById(twitmaindiv).style.display="block";
			document.getElementById(curtwitterdiv).innerHTML	= "Due to server problem unable to respond";
		}
	}
}

function gettwitterid(matriid)
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
				document.getElementById('twitinputdiv').style.display="none";
			} else {
				document.getElementById('twitinputdiv').style.display="block";
			}
		}
	}
}

function getothertwitterid(cpno,matriid,ps)
{
	paidstatus = ps;
	twitcurrentPgNo = cpno;
	var argurl='/profiledetail/twitter_req.php';
	ajaxobj=AjaxCall();
	var postval = "matriid="+matriid+"&gettacc=yes";
	AjaxPostReq(argurl,postval,getothtwitidfunc,ajaxobj);
}

function getothtwitidfunc()
{
	if(ajaxobj.readyState==4){
		if(ajaxobj.status==200){
			eval("vari="+ajaxobj.responseText);
			var twitdiv = twitcurrentPgNo+'twitteriddiv';
			var twitimgdiv = twitcurrentPgNo+'twitterimgdiv';
			var twitlinkdiv = twitcurrentPgNo+'twitterlinkdiv';
			if(vari['status'] == true) {
				if(paidstatus==1) {
					document.getElementById(twitdiv).innerHTML='('+vari['twitterId']+')';
				} else {
					document.getElementById(twitdiv).innerHTML='';
				}
				document.getElementById(twitimgdiv).style.display="block";
				document.getElementById(twitlinkdiv).style.display="block";
			} else {
				document.getElementById(twitdiv).innerHTML="";
				document.getElementById(twitimgdiv).style.display="none";
				document.getElementById(twitlinkdiv).style.display="none";
			}
		}
	}
}