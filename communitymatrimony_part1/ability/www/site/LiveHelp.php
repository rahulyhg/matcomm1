<?php
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');
?>

<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5">
		<font class="clr bld">Live help - 24x7 Customer Care</font>
	</div>
	<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
	<div class="smalltxt clr">
		<div class="content"><?=$confValues['PRODUCTNAME']?> is eager to help you find your partner at the earliest. Our customer care team will be pleased to assist you anytime you have a query. You can contact our customer care team in one of the following ways.
		</div>
	</div>

	<div class="padt10 padb10">
		<div class="smalltxt bld" style="padding-left:50px;">Helpline Numbers</div>
		<br clear="all">

			<div class="srchdivlt tlright fleft">INDIA:</div>
			<div class="srchdivrt fleft">1800 - 3000 - 2222 &nbsp;(Toll Free)</div>

			<div class="srchdivlt tlright fleft">Other Countries:</div>
			<div class="srchdivrt fleft">91 - 44 - 39115022</div>

			<div class="srchdivlt tlright fleft">USA:</div>
			<div class="srchdivrt fleft">1 - 877 - 496 - 2779</div>

			<div class="srchdivlt tlright fleft">UK:</div>
			<div class="srchdivrt fleft">0 - 800 - 635 - 0674</div>

			<div class="srchdivlt tlright fleft">UAE:</div>
			<div class="srchdivrt fleft"><?if($varDomainPart2=='muslimmatrimony'){?>+971 4 3831008.<?}else{?> +971-4-3968637.<?}?><BR>
				<font class="smalltxt">
					Sat-Thu: 9.00 AM to 9.00 PM.<br>Friday: 10.00 AM to 5.00 PM.
				</font>
			</div>
			<div class="fleft" style="padding:10px 0px 10px 100px;">For payment related queries, <font class="bld">Call Toll Free No. 1-800-3000-2222.</font>&nbsp;<font class="smalltxt clr2">(India)</font></div>
	</div>
	<br clear="all">

	<div class="padt10 padb10">
		<div class="smalltxt bld fleft" style="padding-left:50px;padding-top:15px;">Live Chat</div>
		<div class="fleft"><img src="<?=$confValues['IMGSURL']?>/livechat.gif" /></div><br clear="all">
		<div class="smalltxt clr padtb10" style="padding-left:50px;">You can also chat live with our customer care team online and get instant solutions to all your queries right away.</div><br clear="all">
		<div class="fright"><input type="button" class="button" style="cursor:pointer;" value="Click here to chat NOW" id="_lpChatBtn" href='https://server.iad.liveperson.net/hc/45118402/?cmd=file&file=visitorWantsToChat&site=45118402&byhref=1&imageUrl=https://server.iad.liveperson.net/hcp/Gallery/ChatButton-Gallery/English/General/1a/' target='chat45118402'  onClick="javascript:window.open('https://server.iad.liveperson.net/hc/45118402/?cmd=file&file=visitorWantsToChat&site=45118402&imageUrl=https://server.iad.liveperson.net/hcp/Gallery/ChatButton-Gallery/English/General/1a/&referrer='+escape(document.location),'chat45118402','width=475,height=400,resizable=yes');return false;" /></div>
	</div>



	<!-- <div class="padt10 padb10">
		<div class="smalltxt bld" style="padding-left:50px;">Create a Support Ticket</div>
		<div class="smalltxt clr" style="padding-left:50px;">Ask your question and receive the answers in your mailbox. We respond at the earliest.</div>
	<br clear="all">
		<div style="padding-left:50px;">
			<a class="clr1" onclick="showhidediv('rmFeedback');">Registered Members ></a>
			<div id="rmFeedback" style="display:none;">
				<form method="POST" action="" name="feedbackform" onSubmit="return validateFeedback();">
					<input type="hidden" name="frmFeedbackSubmit" value="yes">

					<div class="logdivlta smalltxt">Name</div>
					<div class="logdivltb"><input type="text" name="name" value="" class="inputtext" tabindex="1" size="30"></div>
					<br clear="all">

					<div class="logdivlta smalltxt">E-mail</div>
					<div class="logdivltb"><input type="text" name="name" value="" class="inputtext" tabindex="1" size="30"></div>
					<br clear="all">

					<div class="logdivlta smalltxt">Phone number</div>
					<div class="logdivltb"><input type="text" name="name" value="" class="inputtext" tabindex="1" size="30"></div>
					<br clear="all">

					<div class="logdivlta smalltxt">Subject</div>
					<div class="logdivltb"><input type="text" name="name" value="" class="inputtext" tabindex="1" size="30"></div>
					<br clear="all">

					<div class="logdivlta smalltxt">System Details</div>
					<div class="logdivltb"><input type="text" name="name" value="" class="inputtext" tabindex="1" size="30"></div>
					<br clear="all">

					<div class="logdivlta smalltxt">Question</div>
					<div class="logdivltb"><input type="text" name="name" value="" class="inputtext" tabindex="1" size="30"></div>
					<br clear="all">

					<div class="logdivlta smalltxt">&nbsp;</div>
					<div class="logdivltb">
						<div class="fright"><input type="submit" value="Submit" class="button" tabindex="7"></div>
					</div>
				</form>
			</div>
		</div>
		<BR clear="all">

		<div style="padding-left:50px;">
			<a class="clr1">Non-Registered Members ></a>
		</div><br clear="all">
	</div> -->

	<!-- BEGIN LivePerson Button Code --><!-- <div><a id="_lpChatBtn" href='https://server.iad.liveperson.net/hc/45118402/?cmd=file&file=visitorWantsToChat&site=45118402&byhref=1&imageUrl=https://server.iad.liveperson.net/hcp/Gallery/ChatButton-Gallery/English/General/1a/' target='chat45118402'  onClick="javascript:window.open('https://server.iad.liveperson.net/hc/45118402/?cmd=file&file=visitorWantsToChat&site=45118402&imageUrl=https://server.iad.liveperson.net/hcp/Gallery/ChatButton-Gallery/English/General/1a/&referrer='+escape(document.location),'chat45118402','width=475,height=400,resizable=yes');return false;" ><span style="font:normal 11px Arial, Helvetica, sans-serif;" class="clr1 smalltxt">Live Help</span></a></div> --><!-- END LivePerson Button code -->


</div>
