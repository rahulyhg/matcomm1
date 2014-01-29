<?php
//FILE INCLUDES
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//HEADER INCLUDE
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/emailsconfig.cil14");
include_once($varRootBasePath."/lib/clsMailManager.php");

//OBJECT DECLARATION
$objMailManager = new MailManager;
$objMailManager->dbConnect('S', $varDbInfo['DATABASE']);

//SESSION VARIABLES
$varSessionId		= $varGetCookieInfo["MATRIID"];
$varSessionName		= $varGetCookieInfo["NAME"];
$varTab				= $_REQUEST["tab"];
$varDisplayMsg		= "";

if($_POST['frmFeedbackSubmit']=='yes') {
		$varEmailId			= addslashes($_REQUEST['fbEmail']);
		$varFlds			= array('User_Name','MatriId');
		$varCond			= " WHERE Email='".$varEmailId."'";
		$varSessSel			= $objMailManager->select($varTable['MEMBERLOGININFO'],$varFlds,$varCond,1);
		$varMatriId			= $varSessSel[0]['MatriId'];
		$varToday = date("F j, Y, g:i a");
		$varMessage='<html><title>Feed Back Queries From '.$confValues['FROMMAIL'].'</title><body><table>';
		if($varMatriId != "") { $varMessage.='<tr><td>MatriId :'.$varMatriId.'</td></tr>'; }
		$varMessage.=  '<tr><td>Time :'.$varToday.'</td></tr><tr><td>Your Name :'.$_REQUEST['fbName'].'</td></tr><tr><td>Phone Number :'.$_REQUEST['fbPhone'].'</td></tr><tr><td>Your Mail :'.$_REQUEST['fbEmail'].'</td></tr><tr><td>System Details :'.$_REQUEST['fbEnv'].'</td></tr><tr><td>Comments:'.$_REQUEST['fbFeedback'].'.</td></tr></table></body></html>';
		 //$varTo = 'jshree@bharatmatrimony.com,dhanapal@bharatmatrimony.com,support@'.$confValues['LOWERCASE'].'.com,nazir@bharatmatrimony.com,ashokkumar@bharatmatrimony.com';
		//$varTo = 'customercare@'.$confValues['LOWERCASE'].'.com,mahul_shah@hotmail.com';

		$varTo = $arrEmailsList['FEEDBACKEMAIL']; //'bmtestemails@gmail.com,balajiramnathan@consim.com';

		$varSubject="Suggestion / Feedback from ".$_REQUEST['fbName'];

		if($_REQUEST['fbName'] && $_REQUEST['fbEmail'] && $_REQUEST['fbFeedback']) {
			$objMailManager->sendEmail($varMatriId,$varEmailId,$varTo,$varTo,$varSubject,$varMessage,$varEmailId);
			$varDisplayMsg .= "<div class=\"pad10\"><font class='smalltxt'>Thank you for posting your questions, comments and suggestions.</font><br><div class=\"fright padtb10\"><input type=\"button\" class=\"button pntr\" value=\"Back\" onclick=\"window.location='index.php?act=feedback'\" /></div></div>";
		} else {
			$varDisplayMsg .= "<div class=\"brdr pad10\"><font class='smalltxt'>Please enter your feedback correctly.</font></div>";
		}
}
$objMailManager->dbClose();
unset($objMailManager);
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/feedback.js" ></script>

<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5 padl"><font class="clr bld">Feedback</font></div>
	<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<br clear="all">
	<center>
	<div class="rpanel padt10">

	<? if($varDisplayMsg!='') { echo '<div style="padding:17px">'.$varDisplayMsg.'</div>'; } else { ?>
		<div class="normtxt clr padl">Please feel free to post your questions, comments and suggestions. We are eager to assist you and serve you better.
		</div>
		<br clear="all">

		<form method="POST" action="" name="feedbackform"  onSubmit="return validateFeedback();">
			<input type="hidden" name="frmFeedbackSubmit" value="yes">
			<div class="srchdivlt fleft tlright smalltxt">Name</div>
			<div class="srchdivrt fleft">
				<input type="text" name="fbName" size="35" class="inputtext" value="<?=$varSessionName?>" tabindex="1"><br clear="all"><span id="name" class="errortxt"></span><!-- Email Bubble out div-->
				<div id="embubdiv" style="z-index:2100;margin-left:205px;display:none;"><span class="posabs" style="width:153px; height:62px;background:url('http://img.communitymatrimony.com/images/feedback_img1.gif') no-repeat;padding-top:1px;padding-left:22px;"><span class="smalltxt clr3 tlleft" style="width:120px;padding-left:2px;">Please provide a valid<br> and active e-mail ID so<br> that we could get in <br>touch with you.</span></span></div>
				<!-- Email Bubble out div-->
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Phone number</div>
			<div class="srchdivrt fleft">
				<input type="text" name="fbPhone" size=35 class="inputtext"  tabindex="2">
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">E-mail</div>
			<div class="srchdivrt fleft">
				<input type="text" name="fbEmail" class="inputtext" tabindex="3" size="35" onfocus="showdiv('embubdiv');" onblur="hidediv('embubdiv');"><br><span id="email" class="errortxt"></span><!-- Sysdet Bubble out div-->
				<div id="sysdetdiv" style="z-index:2110;margin-left:205px;display:none;"><span class="posabs" style="width:153px; height:78px;background:url('http://img.communitymatrimony.com/images/feedback_img2.gif') no-repeat;padding-top:1px;padding-left:22px;"><span class="smalltxt clr3 tlleft" style="width:122px;padding-left:2px;">Please include your<br> browser name and the<br> version. E.g. Windows<br> XP, IE Version 7.0. 5730.<br> 13 Updated Version SP2</span></span></div>
				<!-- Sysdet Bubble out div-->
			</div>
			<br clear="all">

<!--
			<div class="srchdivlt fleft tlright smalltxt">Subject</div>
			<div class="srchdivrt fleft">
				<input type="text" name="name" value="" class="inputtext" tabindex="1" size="30">
			</div>
			<br clear="all">
-->

			<div class="srchdivlt fleft tlright smalltxt">System Details</div>
			<div class="srchdivrt fleft">
				<textarea class="tareareg" style="width:205px;" name="fbEnv" tabindex="4" onfocus="showdiv('sysdetdiv');" onblur="hidediv('sysdetdiv');"></textarea>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Suggestions/<BR>Feedback</div>
			<div class="srchdivrt fleft">
				<textarea class="tareareg" style="width:205px;" name="fbFeedback" tabindex="5"></textarea><br>
				<span id="feedback" class="errortxt"></span>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">&nbsp;</div>
			<div class="srchdivrt fleft">
				<div class="fright">
					<input type="submit" value="Submit" class="button" tabindex="7" onClick="return funLogin();">
				</div>
			</div>
		</form>
	<?}?>	<!-- Close if varDisplayMsg -->
	</div>
	</center>
</div>