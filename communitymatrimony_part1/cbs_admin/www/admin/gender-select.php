<?php
#================================================================================================================
# Author 		: S.Rohini
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: PhotoManagement - Add Photo
#================================================================================================================
//FILE INCLUDES
include_once('includes/clsCommon.php');

//OBJECT DECLARTION
$objCommon = new Common;

if($_POST['frmAddGenderSubmit']=='yes')
{
	//VARIABLE DECLARITIONS
	$varUserName		= $_REQUEST['username'];
	$varPrimary			= $_REQUEST['primary'];
	$varErrorMessage	= 'no'; 

	if($_REQUEST['gender'] != '')
	{
		echo '<script language="javascript"> document.location.href = "index.php?act=validate-photos&gender='.$_REQUEST[gender].'"; </script>';
	} //IF
	else if ($varUserName != '' && $varPrimary != "")
	{
		$objCommon->clsTable		= 'memberlogininfo';
		$objCommon->clsCountField	= 'MatriId';
		$objCommon->clsPrimary		= array($varPrimary);
		$objCommon->clsPrimaryValue	= array($varUserName);
		$objCommon->clsFields		= array('MatriId');
		$varRecordsNumber			= $objCommon->numOfResults();
		if ($varRecordsNumber==0) { $varErrorMessage	= 'yes';  }//if

		if ($varErrorMessage=='no')
		{
			$varGenderResult	=	$objCommon->selectInfo();
			$varMatriId			=	$varGenderResult['MatriId'];	
			echo '<script language="javascript"> document.location.href = "index.php?act=validate-photos&matrimonyId='.$varMatriId.'"; </script>';
		}//if
	}//IF
}

?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="545">
	<tr><td height="15"></td></tr>
	<tr><td valign="top" class="heading" style="padding-left:15px;">Photo View</font></div></td></tr>
	<tr><td height="10"></td></tr>
	<tr>
	<td>
		<form name="frmAddGender" method="post" onSubmit="return funViewProfileId();" style="padding:0px;margin:0px;">
			<input type="hidden" name="frmAddGenderSubmit" value="yes">
			<table cellspacing="0" cellpadding="0" border="0" width="545" align="left"  class="formborderclr">
			<tr>
				<td class="smalltxt"  width="35%" align='right'><b>Gender :</b>&nbsp;&nbsp;&nbsp;</td>
				<td width="50%" class="smalltxt" colspan='4'><input type="radio" name="gender" value="1">&nbsp;Male&nbsp;&nbsp;<input type="radio" name="gender" value="2">&nbsp;Female</td>
			</tr>
			<tr><td colspan="4" class="smalltxt"  align='center'> <b>OR</b> </td></tr>
			<tr>
				<td class="smalltxt" width='40%' align='right'>&nbsp;<b>Username / Matrimony ID :</b> &nbsp;&nbsp;&nbsp;</td>
				<td width="10%">
					<input type='text' name='username' size="20"  value="" class="inputtext"></td>
				<td class="smalltxt"  width="20%">
					<input type='radio' name='primary' value ='User_Name'>Username&nbsp;&nbsp;</td>
				<td class="smalltxt"  width="20%"><input type='radio' name='primary' value='MatriId'>MatrimonyID&nbsp;
				</td>
			</tr>							
			<tr><td height="5" colspan="4"></td></tr>
			<tr>
				<td colspan="4" align="right" style="padding-right:15px;"> <input type="submit" value="Search" class="button"></td>
			</tr>
			<tr><td height="10" colspan="4"></td></tr>
		</table>
		</form>
	</td></tr>
</table>
<?php
//UNSET OBJECT
unset($objCommon);
?>
<script language="javascript">
function funViewProfileId()
{
	var frmName = document.frmAddGender;
	if (!(frmName.username.value != '' || frmName.gender[0].checked==true || frmName.gender[1].checked==true || frmName.primary[0].checked == true || frmName.primary[1].checked == true))
	{
		alert("Please select Gender OR Username / MatrimonyID");
		frmName.gender[0].focus();
		return false;
	}//if
	if ((frmName.gender[0].checked==true || frmName.gender[1].checked==true) && (frmName.primary[0].checked == true || frmName.primary[1].checked == true || frmName.username.value != ''))
	{
		alert("Don't Select both option,Please select any one of the option");
		frmName.gender[0].checked		=	false;
		frmName.gender[1].checked		=	false;
		frmName.primary[0].checked	=	false;
		frmName.primary[1].checked	=	false;
		frmName.username.value			=	'';
		frmName.gender[0].focus();
		return false;
	}//if
	if (!(IsEmpty(frmName.username,'text')) && (frmName.primary[0].checked != true &&  frmName.primary[1].checked != true)) 
	{
		alert('Please select Username / MatrimonyID');
		frmName.primary[0].focus();
		return false;
	}//IF
	
	if ((IsEmpty(frmName.username,'text')) && (frmName.primary[0].checked == true || frmName.primary[1].checked == true)) 
	{
		alert('Please Enter the Username / MatrimonyID value');
		frmName.username.focus();
		return false;
	}//IF
	return true;
}//funViewProfileId
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
}// CHECK FORM FILED VALUE IS EMPTY 
</script>