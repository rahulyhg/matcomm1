<?php 
#================================================================================================================
# Author 		: A.Baskaran
# Start Date	: 2006-07-11
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: Admin	- Update Validity Period
#================================================================================================================
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');

//OBJECT DECLARTION
$objSlaveDB		= new DB;
$objCommon		= new clsCommon;

//DB CONNECTION
$objSlaveDB->dbConnect('S',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varSubmit						=	$_REQUEST['frmGetUsenameIdSubmit'];
$varCurrentDate					=	date('Y-m-d h:i:s');
$varErrorMessage				= 	'no';
if ($varSubmit	== 'yes') {

	$varMatriId			= $_REQUEST["username"];
	$varCondition		= " WHERE MatriId='".$varMatriId."'";
	$varNumberOfRecords	= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], 'MatriId', $varCondition);

	if ($varNumberOfRecords==1)
	{
		$varFields				=	array('MatriId','Valid_Days','Last_Payment');
		$varExecute				= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
		$varMemberInfo			= mysql_fetch_assoc($varExecute);
		$varMatriId				=	$varMemberInfo['MatriId'];
		$varValidDays			=	$varMemberInfo['Valid_Days'];
		$varPaidDate			=	$varMemberInfo['Last_Payment'];
		$varRemaingDays			=	$objCommon->dateDiff('=',$varCurrentDate,$varPaidDate);
		$varNewRemainingDays	=	($varRemaingDays >= $varValidDays) ? 0 : $varValidDays - $varRemaingDays;
?>		
		<table  border='0' cellpadding='0' cellspacing='0' width='540' align="left">
			<tr>
				<td class="heading">Update Validity Period</td></tr>
				<tr><td height="10"></td></tr>
				<tr><td>
					<form name='frmCheckValidityPeriod' method='post' onSubmit='return frmCheckValidityPeriodValidation();'>
						<input type='hidden' value='yes' name='frmCheckValidityPeriodSubmit'>
						<input type='hidden' value='<?=$varMatriId; ?>' name='matriId' >
						<input type='hidden' value='<?=$varNewRemainingDays; ?>' name='oldValidityPeriod'>
						<input type='hidden' name='act' value='updated-validity-period'>
						<table cellspacing='4' class="formborderclr">
							<tr>
								<td class="textsmallbolda" >Remaining Validity Period :</td>
								<td class="smalltxt"><b><? print $varNewRemainingDays; ?></b></td>
								</tr>
							<tr>
								<td class="textsmallbolda" align='right'> New Validity Period :</td>
								<td class="smalltxt">
									<input type='text' align="absmiddle" name='newValidityPeriod' class="smalltxt">
									<input type='submit' align="absmiddle" class="button" value="Submit">
									<input type='reset' align="absmiddle" class="button" value="Clear">
								</td>
							</tr>
						<table>
					</form>
				</td>
			</tr>
		</table>
		</td></tr></table>
<?php } else { $varErrorMessage =	'No Records found'; }//else
}

if ($varNumberOfRecords==0) {
?>


<table border='0' cellpadding='0' cellspacing='0' width="540" align="left">
	<tr><td class="heading" >Update Validity Period</td></tr>
	<tr><td height="10"></td></tr>
	<? if ($varErrorMessage != 'no' && $varSubmit=='yes') { ?>
	<tr><td  class="errorMsg"><?=$varErrorMessage;?></td></tr>
	<?php } if ($varSubmit	!= 'yes' ) { ?>
	<tr>
		<td>
			<table border='0' cellpadding='0' cellspacing='0' class="formborderclr" width="500">
				<form name='frmGetUsenameId' method='post' onSubmit='return frmValidation();'>
				<input type='hidden' name='frmGetUsenameIdSubmit' value='yes'>
				<tr><td height="10" colspan='3'></td></tr>
				<tr>	
					<td class="textsmallbolda" align='left' width="20%">&nbsp;&nbsp;MatrimonyId :</td>
					<td width="30%"> <input type='text' name='username' class='smalltxt'></td>
					<td width="50%"><input type='submit' class="button" value="Submit"> <input type='reset' class="button" value="Clear"></td>
				</tr>
				<tr><td height="10" colspan='3'></td></tr>
				</form>
			</table>
		</td>
	<?php } ?>
	</tr>
</table>
<?php }//if?>

<script language='javascript'>
function frmValidation()
{
	if (IsEmpty(document.frmGetUsenameId.username, 'text'))
	{
		alert("Please Enter the Matrimony Id");
		document.frmGetUsenameId.username.focus();
		return false;
	}//if
	if (IsEmpty(document.frmCheckValidityPeriod.newValidityPeriod,'text'))
	{
		alert('test');
		alert("Please Enter the New Validity Period");
		document.frmCheckValidityPeriod.newValidityPeriod.focus();
		return false;
	}//IF
  return true;
}//IF
function frmCheckValidityPeriodValidation()
{
	if (IsEmpty(document.frmCheckValidityPeriod.newValidityPeriod,'text'))
	{
		alert("Please Enter the New Validity Period");
		document.frmCheckValidityPeriod.newValidityPeriod.focus();
		return false;
	}//IF
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
	}//IF

}// CHECK FORM FILED VALUE IS EMPTY 
function clear()
{
	document.frmGetUsenameId.username.value					= 	'';
	document.frmGetUsenameId.primary[0].checked				= 	false;
	document.frmGetUsenameId.primary[1].checked				= 	false;
	
}//IF
function clear2()
{
	document.frmCheckValidityPeriod.newValidityPeriod.value		=	'';
}	//IF
</script>