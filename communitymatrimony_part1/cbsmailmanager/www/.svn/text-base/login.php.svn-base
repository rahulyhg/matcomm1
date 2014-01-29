<?php
//**********************************************************************
// File Name	: affiliate_login.php
// Code By		: Pradeep,Ashok kumar
//**********************************************************************

include "/home/cbsmailmanager/config/config.php";
include_once "lib/authenticate.php";
include "/home/cbsmailmanager/config/header.php";

?>

<script language="JavaScript">
function ValidateEmail( Email )
{
	var atCharPresent = false;
	var dotPresent = false;

	for ( var Idx = 0; Idx < Email.length; Idx++ )
	{
		if ( Email.charAt ( Idx ) == '@' )
			atCharPresent = true;
		if ( Email.charAt ( Idx ) == '.' )
			dotPresent = true;
	}
	if ( !atCharPresent || !dotPresent )
		return false;
	return true;
}

function validate()
{
	if (document.frm.aff_login.value=="") {
		 alert("Please Enter Your Login ID");
		 document.frm.aff_login.focus();
		 return false;
	}
    if (document.frm.aff_pwrd.value=="") {
		 alert("Please Enter Your Password");
		 document.frm.aff_pwrd.focus();
		 return false;
    }
	return true;
}
//-->
</script>

<body bgcolor="#FFFFFF" >

<form name="frm" method="post" action="" onsubmit="return validate();">
<table class="smalltxt" border="0" cellpadding="2" cellspacing="2" align="center" >
<tr>
<td bgcolor="#EAF1F6">
	<table class="smalltxt" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#6A6A6A">
	<tr>
		<td>
			<table border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF"   width="100%">
			<tr bgcolor="#6A6A6A">
				<td align="center" class="white"><?=$ret_res?></td>
			</tr>
			<tr bgcolor="FF6000">
				<td align="left" class="white">Login Here!</td>
			</tr>
			<tr>
				<td>
					<table class="smalltxt" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF" width="300">
					<tr>
						<td class="label" align="right">Username &nbsp;&nbsp;&nbsp;:</td>
						<td><input type="text" name="aff_login"  class="smalltxt" ></td>
					</tr>
					<tr>
						<td class="label" align="right">Password&nbsp;&nbsp;&nbsp;&nbsp;:</td>
						<td class="textblu"><input type="password" name="aff_pwrd" value="" class="smalltxt"></td>
					</tr>
					</table>
				</td>
			<tr>
				<td>
					<table border="0" cellpadding="1" cellspacing="1" align="center" >
					<tr>
						<td><input type="submit" name="login_submit" value="Login"></td>
						<td><input type="reset" name="reset" value="Reset"></td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</td>
</tr>
</table>
</form>
</body>

