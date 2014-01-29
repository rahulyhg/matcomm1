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
<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
<div class="footdiv">
	<div class="footdiv1"><font class="smalltxt clr">
		<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=aboutus" class="smalltxt clr1">About Us</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=contactus" class="smalltxt clr1">Contact Us</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=privacypolicy" class="smalltxt clr1">Privacy Policy</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=termsandconditions" class="smalltxt clr1">Terms and Conditions</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/payment/" class="smalltxt clr1">Pay Now</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=feedback" class="smalltxt clr1">Feedback</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['IMAGEURL']?>/successstory/index.php?act=success" class="smalltxt clr1">Post Success Story</a>
	</font></div>
	<center><div class="fleft footdiv2"><font class="smalltxt clr"><?=$confPageValues["COPYRIGHT"]?></font></div></center>
</div>
