<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================
if($_POST['ModifySingleProfileSubmit']) {
	echo '<script language="javascript">document.location.href = "index.php?act=profile_modification&id='.$_REQUEST['ID'].'"; </script>';
}
?>
<br>
<form method="post" name="frmSingleProfile" target="_blank" onSubmit="return funValidateSingleProfile();">
<table border="0" cellpadding="0" cellspacing="0" width="543" align="center">
<tr>
    <td align="left">
        <table cellpadding="0" cellspacing="0" width="533" class="formborder" style="margin-left:5px;margin-right:5px;">
            <tr><td valign="top" colspan="2" class="adminformheader">Single Profile Modification</td></tr>
              <tr><td colspan="2" height="5"></td></tr>
              <tr bgcolor="#FFFFFF">
              <td width="10"></td>
              <td align="left" class="smalltxt">Matrimony Id :&nbsp;
              <input name="ID" size="10" type="text" class="inputtext">
              &nbsp;<input value="Modify" type="submit" name="ModifySingleProfileSubmit" class="button">
              <input value="Clear" type="reset" class="button">
              </td></tr>
              <tr><td colspan="2" height="5"></td></tr>
        </table>
    </td>
</tr>
</table>
</form>


<script language="javascript">
function funValidateSingleProfile() {
	var funFormName	= document.frmSingleProfile;
	if (funFormName.ID.value=="") {
		alert("please enter Matrimony Id");
		funFormName.ID.focus();
		return false;
	}
	return true;
}//funValidateSingleProfile
</script>
