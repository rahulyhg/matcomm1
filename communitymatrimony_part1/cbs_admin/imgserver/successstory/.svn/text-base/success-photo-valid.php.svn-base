<?php
#=============================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 2008-09-30
# End Date		: 2008-09-24
# Project		: CommunityMatrimony
# Module		: Successstory - Story Gallery
#=============================================================================================================


//OBJECT DECLARTION
$objSlave	= new clsRegister;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);


$objSlave->dbClose();
if($_POST['successValidSubmit'])
{
	echo '<script language="javascript"> document.location.href = "index.php?act=success-photo&NumberPhoto='.addslashes(strip_tags(trim($_REQUEST[norec]))).'&startFrom='.addslashes(strip_tags(trim($_REQUEST[startLimit]))).'"; </script>';
}

?>
<br><br>
<form method="post" name="frmSuccessValidProfiles" target="_blank">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="center">
<tr><td valign="top" colspan="2" class="adminformheader">Success Story Photo Validation</td></tr>
<tr><td colspan="2" height="5"></td></tr>
<tr bgcolor="#FFFFFF">
<td width="10" height="25"></td>
<td align="left" class="smalltxt">
Enter Number of stories to be displayed and click 'Validate' to validate the profiles available in for Publishing. 
</td></tr>
<tr>
<td width="10"></td>
<td valign="top" class="mediumtxt"><b>No.of profiles to be displayed: </b>&nbsp;
<input name="norec" size="4" value="" type="text" class="inputtext">
&nbsp;&nbsp;<b>Start From </b>&nbsp;<input name="startLimit" size="4" type="text" class="inputtext">&nbsp;&nbsp;&nbsp;
<input value="Validate" type="submit" name="successValidSubmit" class="button">
</td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
</table>
</form>