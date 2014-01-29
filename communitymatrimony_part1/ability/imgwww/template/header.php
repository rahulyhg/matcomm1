<?php
#===================================================================================================================
# Author		: Dhanapal N, Ashok kumar
# Filename		: header.php
# Project		: MatrimonyProduct
# Date			: 28-Feb-2008
#===================================================================================================================
# Description	: Header part it holds Logo, first level menu strip and second level menu strip
#===================================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//File Includes
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/basefunctions.cil14");
include_once($varRootBasePath."/conf/payment.cil14");

//VARIABLE DECLARATION
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$varPhotoStatus	= $varGetCookieInfo['PHOTOSTATUS'];
$varGender		= $varGetCookieInfo['GENDER'];

$varTotalMsgCnt =  $varTotMsgRcevCnt + $varTotMsgSentCnt + $varTotIntRecvCnt + $varTotIntSentCnt + $varTotReqRecvCnt + $varTotReqSentCnt;
$varTotalRecd = $varTotMsgRcevCnt + $varTotIntRecvCnt + $varTotReqRecvCnt;
$varTotalSent = $varTotMsgSentCnt + $varTotIntSentCnt + $varTotReqSentCnt;

//Saved Searches info
$varSrchCont = '';
$varFFWidth = '120px';
$varIEWidth = '135px';
$varSrchPleftm = '131px';
$varSrchPleftie = '129px';

if($_COOKIE["savedSearchInfo"] !=''){
$arrSavedSearch	= split('~', $_COOKIE["savedSearchInfo"]);
$varSavedCnt= 0;
foreach($arrSavedSearch as $varSinSearch){
	$arrSrchInfo = split('\|', $varSinSearch);
	$varFFWidth = '235px';
	$varIEWidth = '250px';
	$varSrchPleftm = '60px';
	$varSrchPleftie = '59px';
	if($varSavedCnt==0){
		$varSrchCont .= '<div class="fleft" style="background:url('.$confValues['IMGSURL'].'/versep.gif) repeat-y;height:80px;width:1px;"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="1" /></div><div class="fleft" style="padding-left:5px;line-height:16px;"><div class="bld" style="padding-bottom:5px;">Saved search(s)</div>'; 
	}
	if($varSavedCnt <=2){
		$varEditLink = ($argSrchArray['Search_Type']==2) ? $arrSrchInfo[0].'&act=advsearch' : $arrSrchInfo[0];
		$varSrchCont .= '<img src="'.$confValues['IMGSURL'].'/arrow1.gif" hspace="5" /><a class="clr1" href="'.$confValues['SERVERURL'].'/search/index.php?act=srchresult&srchId='.$varEditLink.'" onclick="hidediv(\'searchdiv\');return true;" onmouseover="showdiv(\'searchdiv\'); return true;">'.$arrSrchInfo[2].'</a><br clear="all">';
	}
	$varSavedCnt++;
}
if($varSrchCont!=''){
	$varSrchCont .= '<div class="fright padt5"><a class="clr1" href="'.$confValues['SERVERURL'].'/search/index.php?act=savesearch">More>></a></div></div>'; 
}
}

//if (($varPhotoStatus==1) && ($sessMatriId !="")) {
if ($sessMatriId !="") {
	$varPhotoImgTag ='<img src="'.$confValues['IMGSURL'].'/noimg50_m.gif" width="50" height="50">'; //MALE
	if ($varGender==2){
		$varPhotoImgTag ='<img src="'.$confValues['IMGSURL'].'/noimg50_f.gif" width="50" height="50">';
	}//FEMALE

	$varSplit		= array();
	$varSplit		= split('~', trim($varGetCookieInfo['PHOTO']));
	$varPhotoName	= trim($varSplit[0]);
	$varPhotoAvailable	= trim($varSplit[1]);

	if (trim($varPhotoName) != '' && trim($varPhotoName) != '0' && count($varSplit) > 0) {
		if ($varPhotoAvailable == 1 and trim($varPhotoName)!='') {
			$varPhotoFolder = $varGetCookieInfo['MATRIID']{3}.'/'.$varGetCookieInfo['MATRIID']{4}.'/';
			$varPhotoUrl = $confValues['PHOTOURL'].'/'.$varPhotoFolder.$varPhotoName;
			$varPhotoImgTag = '<img src="'.$varPhotoUrl.'" width="50" height="50">';
		} elseif (($varPhotoAvailable == 0 or $varPhotoAvailable == 2) and (trim($varPhotoName)!='')) {
			$varPhotoUrl = $confValues['PHOTOURL'].'/crop75/'.$varPhotoName;
			$varPhotoImgTag = '<img src="'.$varPhotoUrl.'" width="50" height="50">';
		}
	}
}
// echo $varPhotoImgTag;

// MEMBER SINCE & PAID OR FREE MEMBER CALCULATION //
$varMemberSince = '';
$varPaidMemberSince = '';
$varPaidExpire = '';
if (trim($varGetCookieInfo['TIMECREATED']) != '') {
	$varMemberSince = date("F 'y",strtotime($varGetCookieInfo['TIMECREATED']));
}
if (trim($varGetCookieInfo['LASTPAYMENT']) != '') {
	$varPaidMemberSince = date("jS F",strtotime($varGetCookieInfo['LASTPAYMENT']));
}
if (trim($varGetCookieInfo['EXPIRYDATE']) != '') {
	$varPaidExpire = date("jS F Y",strtotime($varGetCookieInfo['EXPIRYDATE']));
}
$varPaidStatusInfo = "Free member since $varMemberSince <br /> <a href=\"".$confValues['SERVERURL']."/payment/\" class=\"clr1\">Pay Now to enjoy more benefits >></a>";
if (trim($varGetCookieInfo['PAIDSTATUS']) == 1) {
	$varPaidStatusInfo = "Paid member since $varPaidMemberSince "; //'Paid membership valid for '.$varGetCookieInfo['VALIDDAYSLEFT'].' days';
	if ($varGetCookieInfo['VALIDDAYSLEFT'] <= 15) {
		 $varPaidStatusInfo .= '<br /><font class="smalltxt">Membership Type: '.$arrPrdPackages[$varGetCookieInfo['PRODUCTID']].' | <a href="'.$confValues['SERVERURL'].'/payment/" class="smalltxt">Renewal</a> pending on '.$varPaidExpire.'</font>';
	} else {
		 $varPaidStatusInfo .= '<br /><font class="smalltxt">Membership Type: '.$arrPrdPackages[$varGetCookieInfo['PRODUCTID']].' | Membership ends on '.$varPaidExpire.'</font>';
	}
}

?>

<script>
function srch_getposOffset(overlay, offsettype){
	var totaloffset=(offsettype=="left")? overlay.offsetLeft : overlay.offsetTop;
	var parentEl=overlay.offsetParent;
	while (parentEl!=null){
		totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
		parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}

function quicklinkdisp()
{
	if (document.getElementById){
	var curobj=document.getElementById('quicklinkdisp');
	var srch_saveobj=document.getElementById('quicklinkdis');

	var browser=navigator.appName;
	var b_version=navigator.appVersion;
	var version=parseFloat(b_version);
	if (browser=="Microsoft Internet Explorer")
	{
	  	srch_saveobj.style.left=srch_getposOffset(curobj, "left")-54+"px";
		srch_saveobj.style.top=srch_getposOffset(curobj, "top")+15+"px";
	}
	else
	{
		srch_saveobj.style.left=srch_getposOffset(curobj, "left")-52+"px";
		srch_saveobj.style.top=srch_getposOffset(curobj, "top")+14+"px";
	}
	srch_saveobj.style.display="block";
	showquick();
	}
}

function showquick()
{
  var p = document.getElementById('quicklinkdisp');
  var c = document.getElementById('quicklinkdis');
  p["phone_parent"]     = p.id;
  c["phone_parent"]     = p.id;
  p["phone_child"]      = c.id;
  c["phone_child"]      = c.id;
  p["phone_position"]   = "y";
  c["phone_position"]   = "y";
  c.style.position   = "absolute";
  c.style.visibility = "visible";
  showtype="click";
  cursor="default";
  if (cursor != undefined) p.style.cursor = cursor;
   p.onclick     = quicklinkdisp;
   p.onmouseout  = quicklinkout;
   c.onmouseover = quicklinkdisp;
   c.onmouseout  = quicklinkout;
}

function quicklinkout()
{
	document.getElementById('quicklinkdis').style.visibility="hidden";
}
</script>
<link rel="alternate" type="application/rss+xml" title="RSS Feeds" href="<?=$confValues['SERVERURL']?>/feeds/" />
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css" >

<div class="fleft logodiv" style="padding-bottom:5px;padding-left:15px;"><a href="<?=$confValues['SERVERURL']?>/<?=$sessMatriId ? 'profiledetail/' : ''?>"><img src="<?=$confValues['IMGSURL']?>/logo/ability_logo.gif" alt="AbilityMatrimony" border="0" /></a></div>

<div class="fright">

<!--- Top Menu Part -->
<div class="smalltxt clr2 topdiv" id="main" style="padding-top:70px;padding-right:5px;"><font class="clr">
	<?
	if ($sessMatriId =="" && $varTopMenu!='login') {
		$varSrchPleftm = '40px';
		$varSrchPleftie = '40px';
		echo 'Already a Member? &nbsp;<a href="'.$confValues['SERVERURL'].'/login/" class="clr1">Login</a>';
	} elseif ($sessMatriId!='') { ?>
		<?=$varGetCookieInfo['NAME']?> (<?=$varGetCookieInfo['MATRIID']?>) <!--&nbsp;  <a class="<?=($varTopMenu=='profiledetail' || $varTopMenu=='photo' || $varTopMenu=='horoscope')?'clr bld':'clr1'?>" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo">Settings </a> --> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?=$confValues['SERVERURL']?>/login/logout.php" class="clr1">Logout</a>
	<? } else { $varSrchPleftm = '40px';$varSrchPleftie = '40px';echo '&nbsp;';} ?></font>
</div>
<div class="cleard"></div>

<!--- Top Menu Part -->

<!--- Main Menu Part -->
<div class="normtxt clr2 padt10" style="padding-right:5px;">
	<? if ($sessMatriId !="") { ?>
	<div class="fleft rbrdr" style="width:60px;"><a class="<?=($varTopMenu=='profiledetail') && ($varAct=='') ? 'clr bld' : 'clr1';?>" href="<?=$confValues['SERVERURL']?>/profiledetail/">My Home </a></div><div class="fleft rbrdr tlcenter" id="menumsg" style="width:70px;"><a class="<?=$varTopMenu=='mymessages' ? 'clr bld' : 'clr1';?>" onclick="showhidediv('messagediv'); return true;" onmouseover="document.getElementById('menumsg').className='tlcenter fleft mbrdr1';" onmouseout="document.getElementById('menumsg').className='tlcenter fleft rbrdr';">Inbox <img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" /></a></div><div class="fleft rbrdr tlcenter" id="menusrch" style="width:70px;"><a class="<?=$varTopMenu=='search' ? 'clr bld' : 'clr1';?>" onclick="showhidediv('searchdiv'); return true;" onmouseover="document.getElementById('menusrch').className='tlcenter fleft mbrdr1';" onmouseout="document.getElementById('menusrch').className='tlcenter fleft rbrdr';">Search <img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" /></a></div><div class="fleft tlright" style="width:70px;border:1px solid #ffffff;"><a class="<?=($varAct!='' && $varTopMenu=='profiledetail') || ($varTopMenu=='photo' || $varTopMenu=='horoscope')?'clr bld':'clr1'?>" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo">Edit Profile</a></div><!-- <div class="fleft tlcenter" style="width:70px;"><a class="<?=$varTopMenu=='payment' ? 'clr bld' : 'clr1';?>" href="<?=$confValues['SERVERURL']?>/payment/">Pay Now</a></div> -->
	<? } else if ($varDomainPart2!='communitymatrimony'){
		?>
	<div class="fleft rbrdr"><a class="clr1" href="<?=$confValues['SERVERURL']?>/">Home&nbsp;&nbsp;</a></div><div class="fleft rbrdr tlcenter" id="menusrch" style="width:70px;"><a class="<?=$varTopMenu=='search' ? 'clr bld' : 'clr1';?>" onclick="showhidediv('searchdiv'); return true;" onmouseover="document.getElementById('menusrch').className='tlcenter fleft mbrdr1';" onmouseout="document.getElementById('menusrch').className='tlcenter fleft rbrdr';">Search&nbsp;&nbsp;<img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" /></a></div><div class="fleft" style="border-top:1px solid #ffffff;"><a href="<?=$confValues['SERVERURL']?>/register/" class="clr1">&nbsp;&nbsp;Register</a></div>
	<? } ?>
</div><div class="cleard"></div>

<!-- Message menu content -->
<div style="padding-left:60px !important;padding-left:59px;">
	<div id="messagediv" class="layer" style="display:none;width:50px !important;width:71px;" onmouseout="document.getElementById('menumsg').className='tlcenter fleft rbrdr';hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv');document.getElementById('menumsg').className='tlcenter fleft mbrdr1';">
	<a class="smalltxt clr1" href="<?=$confValues['SERVERURL']?>/mymessages/" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Received</a><br>
	<a class="smalltxt clr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=SMALL" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Sent</a><br>
	<a class="smalltxt clr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=RRALL" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Request</a>
	</div>
</div>
<!-- Message menu content -->

<!-- Saved Search menu content -->
<div style="padding-left:<?=$varSrchPleftm;?> !important;padding-left:<?=$varSrchPleftie;?>;">
	<div id="searchdiv" class="smalltxt layer" style="display:none;width:<?=$varFFWidth?> !important;width:<?=$varIEWidth?>;padding-right:0px;" onmouseout="document.getElementById('menusrch').className='tlcenter fleft rbrdr';hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv');document.getElementById('menusrch').className='tlcenter fleft mbrdr1';">
		<div class="fleft" style="padding-right:5px;"><a class="clr1" href="<?=$confValues['SERVERURL']?>/search/" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">Basic search</a><br>
		<a class="clr1" href="<?=$confValues['SERVERURL']?>/search/index.php?act=advsearch" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">Advanced search</a><!-- <br>
		<a class="smalltxt clr1" href="<?=$confValues['SERVERURL']?>/search/index.php?act=whoisonline" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">Members online search</a> --><br>
		<a class="clr1" href="<?=$confValues['SERVERURL']?>/search/index.php?act=memidsearch" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">By Member Id search</a></div>
		<?=$varSrchCont;?>
	</div>
</div>
<!-- Search menu content -->

<div class="layer" style="padding:0px; position: absolute; visibility: hidden; z-index: 1001; width: 127px !important;width:130px; cursor: default;" id="quicklinkdis" onmouseout="document.getElementById">
	<div class="linesep" style="width:40px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
	<div style="padding:5px 10px 5px 10px;"><a class="smalltxt clr1" href="">Upload Photo</a><br>
	<a class="smalltxt clr1" href="">Change Password</a><br>
	<a class="smalltxt clr1" href="">View new messages</a><br>
	<a class="smalltxt clr1" href="">View favourites</a><br>
	<a class="smalltxt clr1" href="">Delete Profile</a></div>
</div>

<!--- Main Menu Part -->

</div>
<br clear="all" />
<div class="blinesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>

<? if ($sessMatriId!='' && $varTopMenu =='profiledetail' && $_REQUEST['act']=='') { ?>
<div class="fleft photodiv">
	<a href="<?=$confValues['IMAGEURL']?>/photo/" class="smalltxt clr1"><?=$varPhotoImgTag?></a><br>
	<a href="<?=$confValues['IMAGEURL']?>/photo/" class="smalltxt clr1"><?=$varPhotoStatus==1 ? 'Manage' : 'Add'?> photos</a>
</div>
<div class="fleft textdiv normtxt clr">
	<font class="clr3">Hi <?=(trim($varGetCookieInfo['USERNAME'])!=''?trim($varGetCookieInfo['USERNAME']):trim($varGetCookieInfo['NAME']))?>, </font> Welcome to <?=$confValues['PRODUCTNAME']?><br/>
		Membership Status: Your ID: <?=$varGetCookieInfo['MATRIID']?>. <?=$varPaidStatusInfo?>
</div><br clear="all" />
<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
<br clear="all" />
<? } ?>
