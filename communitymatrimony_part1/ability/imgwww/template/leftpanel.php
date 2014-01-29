<?php
$varLiveHelp	= '1';
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$varPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
if ($sessMatriId != '') {
	$varPending		= '';
	$arrTools		= array();
	$arrTools		= $varPromotion['PENDINGTOOLS'];
	//print_r($arrTools);
	for ($i=sizeof($arrTools);$i>0;$i--){
		if (trim($arrTools[$i]) != ''){
			$varPending	.= $i."~";
		}
	}
	$varPending	=	trim($varPending,"~");
	$varTotal	= explode("~",$varPending);
	$arrContent= array();
	$arrContent['Voice'] ="Voice Adds Life ~ Voice makes your profile more convincing. Most prospects will be thrilled to hear you. Add your voice, get better chances of finding the right person in your life.~".$confValues['SERVERURL']."/tools/index.php?add=voice";
	$arrContent['Photo'] = "Photos Create Interest~Even if members aren't only interested in looks, they may end up looking at profiles with photos.~".$confValues['SERVERURL']."/tools/index.php?add=photo";
	$arrContent['Reference'] = "Reference Adds Value~Get your relatives and friends to add references about you. This will go a long way to give an authentic picture about you and will speed your match search.~".$confValues['SERVERURL']."/tools/index.php?add=reference";
	$arrContent['Video'] = "Get Noticed Instantly~A picture speaks a thousand words and a moving picture definitely a thousand more. Add FREE video now and make your profile more delightful!~".$confValues['SERVERURL']."/tools/index.php?add=video";
	$arrContent['PartPref'] = "Add Partner Details~It does a lot of good to set your partner preferences. It will help to focus your search for your perfect life partner. Set them today and get the best results! ~".$confValues['SERVERURL']."/profiledetail/index.php?act=myprofile&myid=yes&vtab=2&inname=ppedit&inview=2";
	$arrContent['Family'] = "Add Family Details~By adding details about your family you will make your profile more complete. So add information now and make it interesting for those who view your profile.~".$confValues['SERVERURL']."/profiledetail/index.php?act=myprofile&myid=yes&vtab=2&inname=familyedit&inview=2";
	$arrContent['Hobbies'] = "Fine Tune Your Profile~What are your hobbies? Every little detail about yourself is needed to make your profile complete. These details help to determine how perfect a partner you are. Add details on your pastime activity and fine tune your profile.~".$confValues['SERVERURL']."/profiledetail/index.php?act=myprofile&myid=yes&vtab=2&inname=hobbiesedit&inview=2";
	$varDisplay1	= '';
	$varDisplay2	= '';
	if (sizeof($varTotal)==2){
		$varDisplay1	= $arrContent[$arrTools[$varTotal[1]]];
	}elseif (sizeof($varTotal)>=3){
		$varDisplay1	= $arrContent[$arrTools[$varTotal[1]]];
		$varDisplay2	= $arrContent[$arrTools[$varTotal[2]]];
	}
}
?>
<div class="lpanel fright" style="padding-top:35px;">
	<center>
	<div class="lpanelinner brdr padt10">
			<a class="clr1 bld normtxt1" href="<?=$confValues['SERVERURL']?>/site/index.php?act=LiveHelp">24x7 Live Help</a><br>
			<div id="livehelpno" class="fleft bld clr padl25 padtb10">91-44-39115022</div><div class="fleft clr2 padtb10">&nbsp;&nbsp;|&nbsp;&nbsp;<a class="clr1 bld normtxt1" href='https://server.iad.liveperson.net/hc/45118402/?cmd=file&file=visitorWantsToChat&site=45118402&byhref=1&imageUrl=https://server.iad.liveperson.net/hcp/Gallery/ChatButton-Gallery/English/General/1a/' target='chat45118402'  onClick="javascript:window.open('https://server.iad.liveperson.net/hc/45118402/?cmd=file&file=visitorWantsToChat&site=45118402&imageUrl=https://server.iad.liveperson.net/hcp/Gallery/ChatButton-Gallery/English/General/1a/&referrer='+escape(document.location),'chat45118402','width=475,height=400,resizable=yes');return false;">Chat</a></div><br clear="all">
			<center><div style="background-color:#ffffff;padding:5px 0px;border-top:1px solid #cbcbcb;"><a class="clr1 bld normtxt" href="<?=$confValues['SERVERURL']?>/site/index.php?act=contactus">Worldwide Locations</a></div></center>
	</div>
	<br clear="all"/>

	<!-- <div class="lpanelinner brdr normtxt1 clr2 padtb10"><div class="fleft" style="padding-left:8px;"><a class="bld clr1" href="<?=$confValues['SERVERURL']?>/site/index.php?act=LiveHelp">Live Help</a> &nbsp;|&nbsp; </div><div id="livehelpno" class="fleft bld clr">1-800-3000-2222</div>
	</div>
	<br clear="all"/> -->

	<? if ($sessMatriId =="") { ?>
	<div class="lpanelinner1 brdr smalltxt clr padt10">
		<center>
		<div class="lpanelinner1b tlleft"><font class="normtxt bld">Experience the joys of finding a <?=$varUcDomain?> Partner</font><br/><br/>
		<font class="clr3 bld">As a visitor, you can:</font>
		<ul class="lh16" style="margin-top:4px;margin-bottom:10px;margin-left:10px !important;margin-left:16px; padding-left:5px !important;padding-left:0px;"><li>Get a preview of profiles.</li>
		</ul>
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
		<font class="clr3 bld">Register & get started: </font>
		<ul class="lh16" style="margin-top:4px;margin-bottom:10px;margin-left:10px !important;margin-left:16px; padding-left:5px !important;padding-left:0px;"><li>Actively search & contact profiles</li>
		<li>Get relevant matches from your community</li>
		<li>Receive free matches by e-mail</li>
		<li>Send introductory messages</li>
		</ul>
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
		<font class="clr3 bld">Enjoy all benefits with a premium membership:</font>
		<ul class="lh16" style="margin-top:4px;margin-bottom:10px;margin-left:10px !important;margin-left:16px; padding-left:5px !important;padding-left:0px;"><li>Connect directly with members via Phone, E-mail & Chat</li>
		<li>Access complete profile details like horoscope & all photos</li>
		<li>Protect personal information</li>
		</ul>
		And much more... <br><br><div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
		<b>We are eager to help you find happiness.</b><br>
		<? if ($varTopMenu!='register' && $varDomainPart2!='communitymatrimony') { ?><a class="clr1" href="<?=$confValues['SERVERURL']?>/register/">Click here to register</a><br><? } ?><br>
		</div>
	</center>
	</div>
	<br clear="all"/>
	<? } else { ?>

	<div class="lpanelinner1 brdr">
		<div class="pad5"><font class="bld clr">Become a Verified <br/>Member to enjoy full access</font></div>
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>

		<div class="fleft lpanelinner2 smalltxt pad3">View Phone Number</div>
		<div class="fleft smalltxt lpanelinner2a"><img src="<?=$confValues['IMGSURL']?>/no.gif" vspace="10" /></div>
		<div class="fleft smalltxt lpanelinner2b"><img src="<?=$confValues['IMGSURL']?>/yes.gif" vspace="10" /></div><br clear="all"/>
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>

		<div class="fleft lpanelinner2 smalltxt pad3">Protect Photo/<br>Horoscope/Phone</div>
		<div class="fleft smalltxt lpanelinner2a"><img src="<?=$confValues['IMGSURL']?>/no.gif" vspace="10" /></div>
		<div class="fleft smalltxt lpanelinner2b"><img src="<?=$confValues['IMGSURL']?>/yes.gif" vspace="10" /></div><br clear="all"/>
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>

		<div class="fleft lpanelinner2 smalltxt pad3">Send message in own words</div>
		<div class="fleft smalltxt lpanelinner2a"><img src="<?=$confValues['IMGSURL']?>/no.gif" vspace="10" /></div>
		<div class="fleft smalltxt lpanelinner2b"><img src="<?=$confValues['IMGSURL']?>/yes.gif" vspace="10" /></div><br clear="all"/>
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>

		<div class="fleft lpanelinner2 smalltxt pad3">Add to favourites </div>
		<div class="fleft smalltxt lpanelinner2a">3</div>
		<div class="fleft smalltxt lpanelinner2b">1000</div><br clear="all"/>
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>

		<div class="fleft lpanelinner2 smalltxt pad3">Block Profiles</div>
		<div class="fleft smalltxt lpanelinner2a">1</div>
		<div class="fleft smalltxt lpanelinner2b">1000</div><br clear="all"/>
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><center>
		<div class="lpanelinner1b smalltxt clr padtb5">For further queries call:<br/><center><div class="normtxt1 bld clr padt5" id="livehelpno1"></div></center>
		</div></center>
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
		
		<div class="fright lpanelinner2d pad5"><input type="button" class="button pntr" value="Verify Now" onClick="document.location.href='<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo'"></div>
	</div>
	<br clear="all"/>
	<? } ?>

	<div class="lpanelinner1 brdr smalltxt clr padtb10">
		<center>
		<div class="lpanelinner1b tlleft"><font class="normtxt bld">You're safe on <?=$varUcDomain?> Matrimony</font><br/><br>We use encryption to protect sensitive information transmitted online. We do not sell any information posted by our members to external sources or use it for marketing purposes.</div>
		</center>
	</div>
<br clear="all"/>
<? if ($varAct!='register' && basename(dirname($_SERVER['PHP_SELF']))!='register') { ?>
	<div class="lpanelinner1 brdr padtb10">
		<center>
		<div class="lpanelinner1b">
		<!-- begin ZEDO for channel: community_ros_160x600 , publisher: Bharatmatrimony , Ad Dimension: Wide Skyscraper - 160 x 600 -->
<iframe src="http://c2.zedo.com/jsc/c2/ff2.html?n=570;c=2491;s=64;d=7;w=160;h=600" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=160 height=600></iframe>
<!-- end ZEDO for channel: community_ros_160x600 , publisher: Bharatmatrimony , Ad Dimension: Wide Skyscraper - 160 x 600 -->
		</div>
		</center>
	</div><br clear="all">
<? } ?>
</center>
</div>