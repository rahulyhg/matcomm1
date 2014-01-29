<? if (trim($varGetCookieInfo['MATRIID']) !="") { ?>
	<script>var msgn_myid='<?=$varGetCookieInfo['MATRIID']?>';</script>
	<script src='<?=$confValues['JSPATH']?>/al.js'></script><script>anonConnection();</script>
<? }
//SEO ORGANIC TRACK CODE...
if(!empty($_SERVER['HTTP_REFERER'])) {
	$varOrgAct	= $_REQUEST['act'] ? '/'.$_REQUEST['act'].'.php' : '';
?>
	<iframe src="http://www.communitymatrimony.com/googlecamp/seo/seoorganictrack.php?ref=<?=urlencode($_SERVER['HTTP_REFERER'])?>&ip=<?=urlencode($_SERVER['REMOTE_ADDR'])?>&page=<?=$_SERVER['PHP_SELF'].$varOrgAct?>&matriid=<?=trim($varGetCookieInfo['MATRIID'])?>" width="0" height="0" frameborder="0"></iframe>
<?	} ?>
<br clear="all" />
<?
$varprivacy='';
$vartermcond='';
if($varDomainPart2 == 'communitymatrimony') {
	$varprivacy='privacypolicy_com';
	$vartermcond='termsandconditions_com';
} else {
	$varprivacy='privacypolicy';
	$vartermcond='termsandconditions';
}

?>
<!-- <div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div> -->
<div class="footdiv" style="background:url(<?=$confValues['IMGSURL']?>/footerbg.gif) repeat-x;">
	<div class="footdiv1 padt10"><font class="smalltxt clr">
		<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=aboutus" class="smalltxt clr1">About Us</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=contactus" class="smalltxt clr1">Contact Us</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=<?=$varprivacy?>" class="smalltxt clr1">Privacy Policy</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=<?=$vartermcond?>" class="smalltxt clr1">Terms and Conditions</a>
		<? if($varDomainPart2 != 'communitymatrimony') { ?>
		<!-- &nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/payment/" class="smalltxt clr1">Pay Now</a> -->
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=feedback" class="smalltxt clr1">Feedback</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['IMAGEURL']?>/successstory/index.php?act=success" class="smalltxt clr1">Post Success Story</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/rsscomm/community/" class="smalltxt clr1">Popular Matrimony Searches</a>
		<? } else { ?>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=feedback" class="smalltxt clr1">Feedback</a>
		<? } ?>
	</font></div>
	<div style="width:772px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="150" height="1" /><font class="smalltxt clr"><?=$confPageValues["COPYRIGHT"]?></font><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="200" height="1" /><a href="<?=$confValues['SERVERURL']?>/feeds/"><img src="<?=$confValues['IMGSURL']?>/rss/rssicon.gif" /></a></div>
</div>
<?

/* Campaign LMS Click track call statements */
/* Query string parameters */
$varCampTrackId	 = addslashes(strip_tags(trim($_REQUEST['trackid'])));
$varCampType	 = addslashes(strip_tags(trim($_REQUEST['type'])));
$varCampFormFeed = addslashes(strip_tags(trim($_REQUEST['formfeed'])));

/* Campaign LMS Click Track */
if ($varCampTrackId!="" && $varCampFormFeed=='y') {
 echo "<script src=\"http://campaign.bharatmatrimony.com/cbstrack/clicktrack.php?trackid=".$varCampTrackId."&type=".$varCampType."&formfeed=y\"></script>";
}

if ($varSplitDomain[0]=='image') { $varLiveHelpURL	= $confValues['IMAGEURL']; } else {
$varLiveHelpURL	= $confValues['SERVERURL']; }

if ($varLiveHelp=='1') { ?>

<script language="javascript">

function funLiveHelpNo(){

		objLiveHelp = AjaxCall();
		var parameters	= Math.random();
		var liveHelpURL	= '<?=$varLiveHelpURL;?>' + "/site/livehelpno.php";
		objLiveHelp.onreadystatechange = funLiveHelp;
		objLiveHelp.open('POST', liveHelpURL, true);
		objLiveHelp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		objLiveHelp.setRequestHeader("Content-length", parameters.length);
		objLiveHelp.setRequestHeader("Connection", "close");
		objLiveHelp.send(parameters);
		return objLiveHelp;
}

function funLiveHelp() {
	if (objLiveHelp.readyState == 4 && objLiveHelp.status == 200) {
		var tollFreeNo = objLiveHelp.responseText;
		document.getElementById('livehelpno').innerHTML = tollFreeNo;
		if(document.getElementById('livehelpno1')){
			document.getElementById('livehelpno1').innerHTML = tollFreeNo;
		}
	}
}

function funDisplayNo(argNo) {

	document.getElementById('livehelpno').innerHTML = argNo;
	if(document.getElementById('livehelpno1')){
		document.getElementById('livehelpno1').innerHTML = argNo;
	}

}//funDisplayNo

//funLiveHelpNo();

</script>

<?	

$varLiveHelpNo	= $_COOKIE['liveHelpNo'];
if ($varLiveHelpNo !="") {
	echo '<script>';
	echo 'funDisplayNo(\''.$varLiveHelpNo.'\');';
	echo '</script>';
 } else { echo '<script>funLiveHelpNo();</script>'; }
	 
}
?>