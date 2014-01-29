<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 2007-11-29
# End Date		: 2007-11-29
# Project		: MatrimonialProduct
# Module		: Success Story - Validation
#=============================================================================================================
//FILE INCLUDES
include_once('includes/clsCommon.php');	

//OBJECT DECLARTION
$objCommon		= new Common;

$objCommon->clsCountField		= 'Bride_Name';
$objCommon->clsTable			= 'successstoryinfo';
$objCommon->clsPrimary			= array('Publish');
$objCommon->clsPrimaryValue		= array(0);
$objCommon->clsAllowedPrimary	= "yes";
$varNoOfRecords	= $objCommon->numOfResults();

if($_POST['addedStorySubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=added-stories&Recds='.$varNoOfRecords.'&NumberStory='.$_REQUEST[norec].'&startFrom='.$_REQUEST[startLimit].'"; </script>';
}
?>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="600">
	<tr><td class="heading">Validate Stories</td></tr>
	<tr><td class="smalltxtadmin" align="right" style="padding-right:45px;padding-top:5px;padding-bottom:0px;color:red"><b>New Stories Pending Count : <?=$varNoOfRecords?></b></td></tr>
</table>
<br>
<form method="post" name="frmAddStories" target="_blank">
	<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="600">
		<tr><td valign="top" colspan="2" class="mailerEditTop">Add Stories</td></tr>
		<tr><td colspan="2" height="5"></td></tr>
		<tr bgcolor="#FFFFFF">
		<td width="10"></td>
		<td align="left" class="smalltxt">
		Enter Number of Stories to be display and click 'Validate' to validate the Stories available in for addition. 
		</td></tr>
		<tr>
		<td width="10"></td>
		<td valign="top">
		<font face="Arial" size="2"><b>No.of Stories to be displayed: </b></font>&nbsp;
		<input name="norec" size="4" value="" type="text" class="smalltxt">
		&nbsp;&nbsp;<font face="Arial" size="2"><b>Start From </b></font>&nbsp;<input name="startLimit" size="4" type="text" class="smalltxt">&nbsp;&nbsp;&nbsp;
		<input value="Validate" type="submit" name="addedStorySubmit" class="button">
		</td>
		</tr>
		<tr><td colspan="2" height="5"></td></tr>
	</table>
</form>