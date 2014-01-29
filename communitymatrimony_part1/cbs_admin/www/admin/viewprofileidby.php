<?php
#=============================================================================================================
# Author 		: Ashok kumar
# Project		: Community Matrimony Product
# Module		: Admin
# Date  		: 23-June-2010
#=============================================================================================================

print_r($_POST);

if ($_POST['fldviewidbysubmit']=='Submit') {
	$varViewIdBy = $_POST['rdviewidby'];
	$varViewIdByValue = $_POST['fldviewby'];
	getProfileIdBy($varViewIdBy, $varViewIdByValue);
}

function getProfileIdBy($varViewIdBy='', $varViewIdByValue='') {
	echo $varViewIdBy, $varViewIdByValue;
}

?>
<form name="viewprofileidby" action="index.php?act=viewprofileidby" method="POST">
	<table>
		<tr><td><font class="smalltxt bld">View / List Profile Id By :</font></td>
			<td class="smalltxt bld"><input type="radio" name="rdviewidby" value="1">Phone / Mobile</td>
			<td class="smalltxt bld"><input type="radio" name="rdviewidby" value="2">BM MatriId</td>
			<td class="smalltxt bld"><input type="radio" name="rdviewidby" value="3">Email</td>
			<td><input type="text" name="fldviewby" class="smalltxt" value=""></td>
			<td><input type="submit" name="fldviewidbysubmit" value="Submit" class="button"></td>
		</tr>
	</table>
</form>