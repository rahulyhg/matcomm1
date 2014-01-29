<?php
#=============================================================================================================
# Author 		: S Anand, N Dhanapal, M Senthilnathan & S Rohini
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================
$sessUserType	= '';
?>
<script language="javascript">
<!--
	function Validate()
	{
		var frmLoginDetails=this.document.frmLogin;
		if(frmLoginDetails.idEmail.value == "")
		{
			alert("Please enter username");
			frmLoginDetails.idEmail.focus();
			return false;
		}
		if(frmLoginDetails.password.value == "")
		{
			alert("Please enter password");
			frmLoginDetails.password.focus();
			return false;
		}
	return true;
	}
//-->
</script>
<!--main table starts here-->
<div style="clear: both;padding-bottom:10px"></div>
<div style="padding-left:220px;display:block;" id='formdiv'>
	<div id="mydiv">
		<div id="rndcorner" style="float:left;width:322px;">
			<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
			<div class="middiv-pad">
				<div style="float:left;">
					<div style="float:left;background:url(<?=$confValues['IMGSURL']?>/tab-curve-bg.gif) repeat-x;height:41px;width:290px;">
						<div class="fleft">
							<div style="float:left;"></div>
							<div style="float:left;background:url(<?=$confValues['IMGSURL']?>/tab-clr-right.gif) no-repeat top right;height:41px;">
								<div class="tabpadd"><font class="mediumtxt1 boldtxt clr4">Admin Login</font></div>
							</div>
						</div>
					</div>
					<div style="float:left;background:url(<?=$confValues['IMGSURL']?>/tr-3.gif) no-repeat;width:10px;height:41px;border:0px solid #000000;"></div>
				</div>
				
				<!-- Content Area -->
				<div style="width:300px;" id='log'>
					<div class="bl" >
						<div class="br">
							<div class="middiv-pad1" id="middlediv">   <!-- for equal div and 1024 res -->
								<div style="padding:5px 0px 0px 35px; width:266px;">
									<div class="fleft smalltxt">
										<form name="frmLogin"  method="post" style="margin:0px;"  onSubmit="return Validate();">
											<input type="hidden" name="frmLoginSubmit" value="yes">
											<input type="hidden" name="act" value="login">
											<div style="width:210px">
											<? if ($_POST["frmLoginSubmit"]=="yes"  || $_REQUEST['varLogin']=="failed") { ?>
											<span id="error" class="errortxt" style="padding: 0 0 0 0;display:block">Invalid Username OR Incorrect Password</span>
											<?php } ?>
											<font class="smalltxt boldtxt"><label for="idEmail">Username</label></font><br><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="1" height="3"><br><input type="text" name="idEmail" id="idEmail" value="" tabindex="1" size="32" class="inputtext"></div>
											<div style="padding-top:5px;width:225px"><font class="smalltxt boldtxt"><label for="password">Password</label></font><br><img src="<?=$confValues["IMGSURL"];?>/trans.gif" width="1" height="3"><br><input type="password" id="password" name="password" value="" tabindex="2" size="32" class="inputtext"></div>
											<div style="width:188px;padding-top:5px;text-align:right"><input type="submit" value="Submit" class="button" tabindex="3" ></div>
										</form>
									</div>
									<br clear="all" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Content Area -->
			</div>
			<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
		</div><br clear="all">
	</div>
</div>
<?
//UNSET OBJECT
unset($objCommon);
?>
<script language="javascript">document.frmLogin.idEmail.focus();</script>