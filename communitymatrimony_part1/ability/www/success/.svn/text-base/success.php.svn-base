<?php
//FILE INCLUDES
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//HEADER INCLUDE
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
?>

<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/feedback.js" ></script>

<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5"><font class="clr bld">Success Stories</font></div>
	<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<div class="smalltxt clr2 padt5 fleft"><a class="clr1">Success Story</a>&nbsp;&nbsp;|&nbsp;&nbsp;<font class="clr bld">Post Your Success Story</font></div><br clear="all">
	<center>
	<div class="rpanel padt10">

	<? if($varDisplayMsg!='') { echo '<div style="padding:17px">'.$varDisplayMsg.'</div>'; } else { ?>
		<div class="normtxt clr" style="padding:15px 15px 0px 50px;">Share your success story and get a gift to treasure forever. Your story will also be an inspiration to our members.
		</div>
		<br clear="all">
		<div class="fright opttxt"><font class="clr1">*</font>Mandatory</div>
		<br clear="all">	
		<form method="POST" action="" name="feedbackform"  onSubmit="return validateFeedback();">
			<input type="hidden" name="frmFeedbackSubmit" value="yes">
			<div class="srchdivlt fleft tlright smalltxt">Bride Name (Female)<font class="clr1">*</font></div>
			<div class="srchdivrt fleft">
				<input type="text" name="fbName" size=35 class="inputtext"  tabindex="1"><br clear="all"><span id="name" class="errortxt"></span><!-- Email Bubble out div-->
			</div>
			<br clear="all">
			
			<div class="srchdivlt fleft tlright smalltxt">Groom Name (Male)<font class="clr1">*</font></div>
			<div class="srchdivrt fleft">
				<input type="text" name="" size=35 class="inputtext"  tabindex="2">
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">MatriId<font class="clr1">*</font></div>
			<div class="srchdivrt fleft">
				<input type="text" name="" size=35 class="inputtext"  tabindex="3">
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Email<font class="clr1">*</font></div>
			<div class="srchdivrt fleft">
				<input type="text" name="fbPhone" size=35 class="inputtext"  tabindex="4">
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Marriage Date<br><font class="opttxt">(Optional)</font></div>
			<div class="srchdivrt fleft">
				<input type="text" name="fbEmail" class="inputtext" tabindex="5" size="35"><br><span id="email" class="errortxt"></span>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Attach Photo<br><font class="opttxt">(Optional)</font></div>
			<div class="srchdivrt fleft">
				<input type="file" name="fbPhone" class="button" size="36" tabindex="6" style="width:270px;">
				<!-- Sysdet Bubble out div-->
				<div id="addrdetdiv" style="z-index:2110;margin-left:205px;display:none;"><span class="posabs" style="width:153px; height:78px;background:url('http://img.communitymatrimony.com/images/success_img1.gif') no-repeat;padding-top:25px;padding-left:22px;"><span class="smalltxt clr3 tlleft" style="width:122px;padding-left:2px;">Mention your address <br>below so that we can <br>send you a special gift.</span></span></div>
				<!-- Sysdet Bubble out div-->
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Address<br><font class="opttxt">(Optional)</font></div>
			<div class="srchdivrt fleft">
				<textarea class="tareareg" style="width:205px;height:90px;" name="fbEnv" tabindex="7" onfocus="showdiv('addrdetdiv');" onblur="hidediv('addrdetdiv');"></textarea>
				
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Telephone<font class="clr1">*</font></div>
			<div class="srchdivrt fleft">
				<input type="text" name="fbEmail" class="inputtext" tabindex="5" size="35"><br><span id="email" class="errortxt"></span>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Success Story<font class="clr1">*</font></div>
			<div class="srchdivrt fleft">
				<textarea class="tareareg" style="width:205px;height:90px;" name="fbFeedback" tabindex="5"></textarea><br>
				<span id="feedback" class="errortxt"></span>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">&nbsp;</div>
			<div class="srchdivrt fleft">
				<div class="fright">
					<input type="button" value="Save" class="button" tabindex="7" onClick="return funLogin();">&nbsp;&nbsp;<input type="button" value="Reset" class="button" tabindex="7">
				</div>
			</div>
		</form>
	<?}?>	<!-- Close if varDisplayMsg -->
	</div>
	</center>
</div>