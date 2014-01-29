<?php
#===================================================================================================
# File		   : myhome.php
# Author	   : Dhanapal, Senthilnathan
# Date		   : 29-Feb-2008
# Description  : MyHomePage.
#====================================================================================================
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/contact.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/conceptRTE.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhomeresult.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhome.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js"></script>
<script type="text/javascript">
var lpos;
function sel(){
	$('lightpic').style.display='block';
	$('fade').style.display='block';
	ll();floatdiv('lightpic',lpos,100).floatIt();
}

function selclose(){
$('lightpic').style.display='none';
$('fade').style.display='none';
window.location.href="http://www.abilitymatrimony.com/profiledetail/index.php?act=abilitydesc";
}


function ll()
{
	lpos=document.body.clientWidth/2 - parseInt($('lightpic').style.width)/2;
}
var ns = (navigator.appName.indexOf("Netscape") != -1);
var d = document;
function floatdiv(id, sx, sy)
{
	var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
	var px = document.layers ? "" : "px";
	window[id + "_obj"] = el;
	if(d.layers)el.style=el;
	el.cx = el.sx = sx;el.cy = el.sy = sy;
	el.sP=function(x,y){this.style.left=x+px;this.style.top=y+px;};

	el.floatIt=function()
	{
		var pX, pY;
		pX = (this.sx >= 0) ? 0 : ns ? innerWidth : 
		document.documentElement && document.documentElement.clientWidth ? 
		document.documentElement.clientWidth : document.body.clientWidth;
		pY = ns ? pageYOffset : document.documentElement && document.documentElement.scrollTop ? 
		document.documentElement.scrollTop : document.body.scrollTop;
		if(this.sy<0) 
		pY += ns ? innerHeight : document.documentElement && document.documentElement.clientHeight ? 
		document.documentElement.clientHeight : document.body.clientHeight;
		this.cx += (pX + this.sx - this.cx)/8;this.cy += (pY + this.sy - this.cy)/8;
		this.sP(this.cx, this.cy);
		setTimeout(this.id + "_obj.floatIt()", 1);
	}
	return el;
}
</script>
<style type="text/css">
.bgfadediv{ display: none;position: absolute;top: 0;left: 0;width: 1000px; height:1450px;background-color: #fff; z-index:1001;	-moz-opacity: 0.4; opacity:0.40;filter: alpha(opacity=40);}

 .frdispdiv{display: none;position: absolute;margin: 0 auto;width: 85%;padding: 5px;border: 0px;
			 z-index:1002;}
</style>
<!-- NEW MyHome Starts -->
<?
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsLists.php');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');
include_once($varRootBasePath.'/lib/clsPhone.php');

//OBJECT DECLARTION
$objCommon			= new clsCommon;
$objProfileDetail	= new ProfileDetail;
$objLists			= new Lists;
$objPhone			= new Phone;

//Connect DB
$objLists->dbConnect('S', $varDbInfo['DATABASE']);

//$varTotalMsgCnt	=  $varTotMsgRcevCnt + $varTotMsgSentCnt + $varTotIntRecvCnt + $varTotIntSentCnt + $varTotReqRecvCnt + $varTotReqSentCnt;
//$varTotalRecd	= $varTotMsgRcevCnt + $varTotIntRecvCnt + $varTotReqRecvCnt;
//$varTotalSent	= $varTotMsgSentCnt + $varTotIntSentCnt + $varTotReqSentCnt;

$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$sessPP			= $_COOKIE['partnerInfo'];

$objLists->clsSessMatriId	= $sessMatriId;
$varNumberBlocked			= $objLists->getNumberBlocked();
$varNumberOfFavs			= $objLists->getNumberOfFavourites();

// Getting Profile Info details - Complete_Now value
$arrProfileInfo = $objProfileDetail->getProfileInfo($sessMatriId);
// Getting Profile pending tools details
$varPendingToolLink = $objProfileDetail->profilePendingTools();

?>
<input type='hidden' id='partval' value=''>

<!-- Photo & Welcome & Member since part -->
<? if ($sessMatriId!='' && $varTopMenu =='profiledetail' && $_REQUEST['act']=='') { ?>
<div class="fleft photodiv">
	<a href="<?=$confValues['IMAGEURL']?>/photo/" class="smalltxt clr1"><?=$varPhotoImgTag?></a>
	<a href="<?=$confValues['IMAGEURL']?>/photo/" class="smalltxt clr1"><?=$varPhotoStatus==1 ? 'Manage' : 'Add'?>&nbsp;photos</a>
</div>
<div class="fleft normtxt clr" style="width:450px;padding:0px;line-height:17px;">
	<font class="clr bld">Hi <?=(trim($varGetCookieInfo['USERNAME'])!=''?trim($varGetCookieInfo['USERNAME']):trim($varGetCookieInfo['NAME']))?> (<?=$varGetCookieInfo['MATRIID']?>),</font> Welcome to <?=$confValues['PRODUCTNAME']?><br/>Membership Status: <?=$varPaidStatusInfo?>
</div>
<br clear="all" /><div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all" />
<? } ?>
<!-- Photo & Welcome & Member since part -->

<div class="rpanel fleft">
	<div class="normtxt1 clr2" style="padding:10px 0px 5px 15px;">
		<font class="clr bld">Total Prospects:</font> <font class="clr3 bld"><?=$objProfileDetail->getNoOfOppProfile($sessGender)?> </font><!-- &nbsp&nbsp;|&nbsp;&nbsp; -->
		<!-- <font class="clr bld">Matches sent by mail:</font> <font class="clr3 bld"><?=$objProfileDetail->getMatchesSentCnt($varGetCookieInfo['MATRIID'])?></font>&nbsp&nbsp;&nbsp;&nbsp; -->
		<!-- <font class="clr bld">Members in contact:</font> <font class="clr3 bld"><?=$objProfileDetail->getMembersInContactCnt($varGetCookieInfo['MATRIID'])?></font> -->
	</div>
	<div class="linesep fright" style="width:545px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">

		<center>
			<? if ($arrProfileInfo['Complete_Now']==0 || $varPendingToolLink != '') { ?>
			<div id="warningdiv" class="rpanelinner obrdr padtb10 obg" style="overflow:hidden;">
				<div class="fleft tlright" style="width:60px;"><img src="<?=$confValues['IMGSURL']?>/warning.gif" border="0" vspace="5" /></div>
				<div class="fleft padtb10 clr" style="padding-left:10px;line-height:16px;"><? if ($arrProfileInfo['Complete_Now']!=1) { ?><font class="normtxt1 clr bld">Some more profile information needed. </font><a class="normtxt1 clr1 bld" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=completenow">Complete Now.</a><br><? if ($varPendingToolLink != '') { ?><font class="smalltxt bld clr">Also </font><? } ?><? } ?><? if ($varPendingToolLink != '') { ?><font class="smalltxt bld clr">Need to: </font><? echo $objProfileDetail->profilePendingTools(); ?><? } ?></div>
				<div class="fright" style="padding-right:10px;"><img src="<?=$confValues['IMGSURL']?>/close.gif" border="0" class="pntr" onclick="hidediv('warningdiv');" /></div>
			</div>
			<? } ?>
			<div class="rpanelinner padt20">
			<div class="fleft tlleft normtxt lh20" style="width:248px;">
				<font class="normtxt1 bld">Received (<?=$varTotMsgRcevCnt + $varTotIntRecvCnt + $varTotReqRecvCnt?>)</font><br>
				<a class="clr1" href="<?=$confValues['SERVERURL']?>/mymessages/">Messages </a><font class="clr">(<?=$varTotMsgRcevCnt?>) / </font><a class="clr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=RMUNREAD">New </a><font class="clr">(<b><?=$varGetCookieInfo['MAILRECEIVEDNEW']?></b>)</font><br>
				<a class="clr1"  href="<?=$confValues['SERVERURL']?>/mymessages/?part=RIALL">Interests </a><font class="clr">(<?=$varTotIntRecvCnt?>) / </font><a class="clr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=RIPENDING">New </a><font class="clr">(<b><?=$varGetCookieInfo['INTERESTRECEIVEDNEW']?></b>)</font><br>
				<a class="clr1"  href="<?=$confValues['SERVERURL']?>/mymessages/?part=RRALL">Request </a><font class="clr">(<?=$varTotReqRecvCnt?>) </font>
			</div>
			<div class="fleft" style="width:1px;background:url(<?=$confValues['IMGSURL']?>/versep.gif) repeat-y;height:80px;"></div>
			<div class="fleft tlleft normtxt lh20" style="width:228px;padding-left:20px;">
				<font class="normtxt1 bld">Sent (<?=$varTotMsgSentCnt + $varTotIntSentCnt + $varTotReqSentCnt?>)</font><br>
				<a class="clr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=SMALL">Messages </a><font class="clr">(<?=$varTotMsgSentCnt?>)</font><br>
				<a class="clr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=SIALL">Interests </a><font class="clr">(<?=$varTotIntSentCnt?>)</font><br>
				<a class="clr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=SRALL">Request </a><font class="clr">(<?=$varTotReqSentCnt?>)</font>
			</div>
		</div></center>
		<div class="fright" style="padding-right:35px;padding-bottom:5px;"><a class="clr1" href="/mymessages/index.php?act=msghowall">More</a>&nbsp;<img src="<?=$confValues['IMGSURL']?>/arrow1.gif" border="0" class="pntr" /></a></div><br clear="all">
		<center>
		<div class="linesep rpanelinner"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1"></div>

		<div class="normtxt1 clr bld padt10 tlleft rpanelinner">Lists</div>
		<div class="normtxt clr2 padtb10 tlleft rpanelinner">
			<a class="clr1" href="<?=$confValues['SERVERURL']?>/list/index.php?act=listshowall&listtype=BK">Block</a> <font class="clr">(<?=$varNumberBlocked?>)</font>&nbsp&nbsp;|&nbsp;&nbsp;
			<a class="clr1" href="<?=$confValues['SERVERURL']?>/list/index.php?act=listshowall&listtype=SL">Favourites</a> <font class="clr">(<?=$varNumberOfFavs?>)</font>&nbsp&nbsp;
		</div>
		<div class="linesep rpanelinner"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1"></div>
		<div class="normtxt1 clr bld padt10 tlleft rpanelinner">Views</div>
		<div class="normtxt clr2 padtb10 tlleft rpanelinner">
			<a class="clr1" href="<?=$confValues['SERVERURL']?>/phone">Who viewed my phone number</a> <font class="clr">(<?=$objPhone->getTotalCntWhoViewedMyPhNo($varGetCookieInfo['MATRIID'])?>)</font>
		</div>

		<div class="linesep rpanelinner"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1"></div>
		<? include_once($varRootBasePath.'/www/mymatches/recom_match.php'); ?>
	</center>
	<br clear="all"/>
	<?//if($sessPaidStatus==1){?>
	<!-- get twitter id-->
	<div><img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="gettwitterid('<?=$sessMatriId?>')" style="text-align:center;" \></div>
	<!-- get twitter id-->
	<br><center>
	<div class="padt10 rpanelinner" id="twitinputdiv" style="display:block;">
		<div class="fleft padt5 smalltxt" style="background: url(<?=$confValues['IMGSURL']?>/twit_lt.gif) no-repeat top left; height:54px;width:54px;"></div>
		<div class="fleft tlleft smalltxt" style="background: url(<?=$confValues['IMGSURL']?>/twitbg.gif);height:36px !important;height:54px;width:428px !important;width:438px;padding:9px 5px;"><b>Got Twitter Account?</b><br> <a class="clr1" href="/profiledetail/index.php?act=primaryinfo">Click here to add your Twitter ID</a> &nbsp;<font class="clr2">|</font>&nbsp; <a class="clr1" href="/site/index.php?act=twithelp">How it works?</a></div>
		<div class="fleft" style="background: url(<?=$confValues['IMGSURL']?>/twit_rt.gif) no-repeat; height:54px;width:8px;"></div>
	</div>
	</center>
	<?//}?>
</div>
<div id="lightpic" class="frdispdiv" style="width: 500px;">
	<div style="background:url(<?=$confValues['IMGSURL']?>/pop1.gif);width:468px;height:125px;" valign="top"><a onclick="$('lightpic').style.display='none';
$('fade').style.display='none';"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="55" height="17" align="right" /></a></div><div style="background:url(<?=$confValues['IMGSURL']?>/pop2.gif);width:468px;height:117px ;"><br><br><center>
<input type="button" class="button" value="Click here to update" onclick="javascript:selclose();" /></center>
</div>
</div>

<div id="fade" class="bgfadediv"></div> 
<br clear="all" />
<? if ($arrProfileInfo['Physical_Status']==1 && ($arrProfileInfo['Disability_Cause']==0 || $arrProfileInfo['Disability_Cause']=='') && preg_replace('/(~)+/', '', trim($arrProfileInfo['Disability_Type'],'~'))=='' && preg_replace('/(~)+/', '', trim($arrProfileInfo['Disability_Product_Used'],'~'))=='') {?>
<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" onLoad="javascript:sel();">
<? } ?>
<!-- NEW MyHome Ends -->
<script language="javascript" src="<?=$confValues['SERVERURL']?>/login/updatemessagescookie.php"></script>
<?
unset($objCommon);
unset($objLists);
?>