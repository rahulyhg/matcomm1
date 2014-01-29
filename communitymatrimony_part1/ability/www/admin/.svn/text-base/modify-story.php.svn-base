<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 2007-11-30
# End Date		: 2007-11-30
# Project		: MatrimonialProduct
# Module		: Success Story - Modify
#=============================================================================================================
//FILE INCLUDES
include_once('includes/clsCommon.php');

//OBJECT DECLARTION
$objCommon = new Common;

//CONTROL STATEMENT
if ($_POST["frmModifyStorySubmit"]=="yes")
{
	$varSuccessId				= $_REQUEST["SuccessId"];
	$objCommon->clsPrimaryValue = array($varSuccessId);
	$objCommon->clsPrimary      = array('Success_Id');
	$objCommon->clsCountField	= 'Success_Id';
	$objCommon->clsTable		= "successstoryinfo";
	$varNoOfResults				= $objCommon->numOfResults();
	if ($varNoOfResults=='1')
	{
		echo "<script language=\"javascript\">document.location.href='index.php?act=edit-story&SuccessId=".$varSuccessId."'</script>";
	}//if
}//if
?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="600">
	<tr><td valign="middle" class="heading" colspan="3">Modify Success Story</td></tr>
	<tr><td height="10" colspan="3"></td></tr>
	<?php if ($_POST["frmModifyStorySubmit"]=="yes" && $varNoOfResults==0) { ?>
	<tr><td align="center" class="errorMsg" colspan="3">No Records found</td></tr><tr><td height="10" colspan="3"></td></tr>
	<?php }//if ?>
	<tr>
		<form name="frmModifyStory" method="post" onSubmit="return funViewStory();">
		<input type="hidden" name="frmModifyStorySubmit" value="yes">
		<input type="hidden" name="MatriId" value="">
		<td width="15%" class="textsmallbolda">Success Id</td>
		<td width="30%" class="smalltxt">
			<input type=text name="SuccessId" value="<?=$varSuccessId;?>" size="25" class="smalltxt" value="">
		</td>
		<td width="55%"><input type="image" src="../images/search.gif"></td>
		</form>
	</tr>
</table>
<?php
//UNSET OBJECT
unset($objCommon);
?>
<script language="javascript">
function funViewStory()
{
	var frmName = document.frmModifyStory;
	if (frmName.SuccessId.value=="")
	{
		alert("Please enter  Success Id");
		frmName.SuccessId.focus();
		return false;
	}//if
	return true;
}//funViewStory
</script>

