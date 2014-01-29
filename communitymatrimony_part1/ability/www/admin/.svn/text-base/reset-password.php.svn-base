<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================
//FILE INCLUDES
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsRegister.php');
include_once($varRootBasePath.'/lib/clsMailManager.php');

//OBJECT DECLARTION
$objMaster		= new clsRegister;
$objMailManager = new MailManager;

//DB CONNECTION
$objMailManager->dbConnect('S',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varErrorMessage	=	'no';
$varSubmit			=	$_REQUEST['frmResetPasswordSubmit'];

if ($varSubmit == 'yes')
{
	$varPrimary					= $_REQUEST['primary'];
	$varUsername				= $_REQUEST['username'];
	$varNewPassword				= $_REQUEST['newPassword'];

	if ($varPrimary=="User_Name")
	{
		//GET MatriId FROM Username
		$argCondition			= "WHERE User_Name='".$varUsername."'";
		$argFields 				= array('MatriId');
		$varSelectMatriIdRes	= $objMailManager->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
		$varSelectMatriId		= mysql_fetch_assoc($varSelectMatriIdRes);
		$varMatriId				= $varSelectMatriId["MatriId"];
	}//if
	else
	{
		$varMatriId				= $varUsername;
	}//

	$argCondition				= "WHERE MatriId='".$varMatriId."'";
	$varRecordsNumber			= $objMailManager->numOfRecords($varTable['MEMBERLOGININFO'],'MatriId',$argCondition);

	if ($varRecordsNumber=='1')
	{
		$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

		$argFields 				= array('User_Name','Email');
		$varSelectInfoRes		= $objMailManager->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
		$varSelectInfo			= mysql_fetch_assoc($varSelectInfoRes);

		$argFields				= array("Password");
		$argFieldsValues		= array("'".md5($varNewPassword)."'");
		$argCondition			= "MatriId='".$varMatriId."'";
		$varResultUpdate		= $objMaster->update($varTable['MEMBERLOGININFO'],$argFields,$argFieldsValues,$argCondition);
		
		$argFrom					=	$confValues['FROMMAIL'];
		$argFromEmailAddress		=	$confValues['HELPEMAIL'];
		$argTo						=	$varSelectInfo['User_Name'];
		$argToEmailAddress			=	$varSelectInfo['Email'];
		$argSubject					=	'Your new '.$confValues['PRODUCTNAME'].'.Com Password';
		$argMessage					=	"Dear ".$argTo.",<br><br> According to your request for change of password, we have set a new password for you. <br><br>Username:     <b>".$argTo."</b><br>Password:     <b>".$varNewPassword."</b><br><br> is your new username and password set by us.<br>You can use your new password to login to ".$confValues['PRODUCTNAME'].".com from now.<br><br><br>Thanking you, <br>Team - ".$confValues['PRODUCTNAME'].".Com";
		$argReplyToEmailAddress		=	$argFromEmailAddress;
	
		$objMailManager->sendEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress);
			
		$varErrorMessage	= '<font class="smalltxt">Password Reset Successfully</font>';

		$objMaster->dbClose();
			
	} else { $varErrorMessage = 'No Record found!'; }//if
}//if
$objMailManager->dbClose();
?>
<table border='0' cellpadding='0' cellspacing='0' align="left" width="542">
	<tr>
		<td style="padding-left:15px;padding-top:15px;">
			<table border='0' cellpadding='0' cellspacing='0' align="left" width="527">
				<tr><td colspan='4' class="heading"> Reset Password</td></tr>
				<tr><td colspan='4' height='10'></td></tr>
			<?php if ($varErrorMessage != '' && $varSubmit =='yes') { ?>
				<tr><td colspan='4' height='10' class= 'errorMsg' align='center'> <?=$varErrorMessage;?>.</td></tr>
			<?php } if ($varSubmit !='yes') { ?>
				<tr>
					<td align='left' valign='top'> 
						<form name='frmResetPassword' method='post'  onSubmit="return validate();">
						<input type='hidden' name='frmResetPasswordSubmit' value='yes' >
							<table border='0' cellpadding='2' cellspacing='0' width="515" align="left">
								<tr>	
									<td class="smalltxt boldtxt" align='right'>Username / MatriID :</td>
									<td> <input type='text'  name='username' class='inputtext'></td>
									<td class="smalltxt"> <input type='radio' name='primary' value='User_Name'> Username &nbsp;<input type='radio' name='primary' value='MatriId'> MatriID</td>
								</tr>
								<tr>
									<td class="smalltxt boldtxt" align='right'>New Password : </td>
									<td colspan='3'><input type='password' name='newPassword' maxlength='15' class="inputtext"></td>
								</tr>
								<tr>
									<td class="smalltxt boldtxt" align='right'>Confirm Password: </td>
									<td><input type='password' name='confirmPassWord' maxlength='15' class="inputtext"></td>
									<td align="left"><input type='submit' value="Reset Password" class="button">&nbsp;<input type='reset' value="Clear" class="button"></td>
								</tr>
								</table>
							</form>
			</td></tr>
			<?php } //IF ?>
			<tr><td height='20'></td></tr>
			</table>
		</td>
	</tr>
</table>

<script language='javascript'>
function validate()
{

	var frmName = document.frmResetPassword;
	if (IsEmpty(frmName.username,'text'))
	{
		alert("Please Enter Username / MatriID");
		frmName.username.focus();
		return false;
	}
	if ( !(frmName.primary[0].checked== true || frmName.primary[1].checked== true)) 
	{
		alert("Please select Gender OR Username / MatrimonyID");
		frmName.primary[0].focus();
		return false;
	}
	if (IsEmpty(frmName.newPassword,'text'))
	{
		alert("Please Enter Password");
		frmName.newPassword.value = '';
		frmName.newPassword.focus();
		return false;
	}
	if ( IsEmpty(frmName.confirmPassWord,'text'))
	{
		alert("Please Enter Confirm Password");
		frmName.confirmPassWord.value = '';
		frmName.confirmPassWord.focus();
		return false;
	}
	if (frmName.newPassword.value != frmName.confirmPassWord.value)
	{
		alert("Password is mismatch! Please retype again");
		frmName.newPassword.focus();
		frmName.newPassword.value = '';
		frmName.confirmPassWord.value = '';
		return false;
	}
	return true;
}
function IsEmpty(obj, obj_type)
{
	if (obj_type == "text" ||  obj_type == "textarea" )
	{
		var objValue;
		objValue = obj.value.replace(/\s+$/,"");

		if (objValue.length == 0)
		{ return true; }
		else { return false; }
	}
}
function clear()
{
	var frmName = document.frmResetPassword;
	frmName.username.value = '';
	frmName.newPassword.value = '';
	frmName.confirmPassWord.value = '';
	frmName.primary[0].checked= false;
	frmName.primary[1].checked= false;
}
</script>