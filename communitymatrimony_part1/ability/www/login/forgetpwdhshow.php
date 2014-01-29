<?php
#=============================================================================================================
# Author 		: A.Baskaran
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================
if ($_REQUEST["EMAIL"] != "") {
	//FILE INCLUDES
	$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
	include_once($varRootBasePath."/conf/config.cil14");
	include_once($varRootBasePath."/conf/dbinfo.cil14");
	include_once($varRootBasePath."/lib/clsDB.php");
	include_once($varRootBasePath.'/lib/clsMailManager.php');
	//OBJECT DECLARTION
	$objMailManager		  = new MailManager;
	$objSlaveDB			  = new DB;
	//CONNECTION DECLARATION
	$varSlaveConn			= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
	//VARIABLE DECLARATIONS
	$varEmail			= trim($_REQUEST["EMAIL"]);
	$varCondition		= " WHERE ".$varWhereClause." AND Email=".$objSlaveDB->doEscapeString($varEmail,$objSlaveDB);
	$varFields			= array('MatriId');
	$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
	//$varSelectLoginInfo	= mysql_fetch_assoc($varResult);
	//print_r($varSelectLoginInfo);
?>

<div class="smalltxt poppadding">
<div class="smalltxt boldtxt" > Select Username</div>
	<span id="error" class="errortxt clr1"></span><br clear="all">
	<form name='frmforgetPassword' method='post' style="margin:0px;padding:0px">
		<?  $i=0;
			while ($row = mysql_fetch_assoc($varResult)) {?>
		<INPUT TYPE="radio" NAME="username" value="<?=$row["MatriId"];?>" > <?=$row["MatriId"];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<? $i++ ; } ?>
		<input type=hidden value=<?=$i;?> name="totalrecords">	
		<input type="hidden" name="MULTIUSER" value="1" >
		<INPUT TYPE="button" value="Submit"  name="submit" class="button" onclick="javascript:funValidation();" >
	</form>
</div>
<? }?>
<script>
function funValidation(){
	var frm = document.frmforgetPassword;
	var checked = -1;
	for (var i=0; i< frm.totalrecords.value; i++){
		if (frm.username[i].checked == true){
			checked  = i;
			i = frm.totalrecords.value+1;
		}
	}
	if (checked == -1){
		document.getElementById('error').innerHTML = "Please select username";
		frm.username[0].focus();
		return false;
	} else {
		window.location = "index.php?act=forgotpassword&MULTIUSER=1&frmForgotPasswordSubmit=yes&UNAME="+frm.username[checked].value;
	}
	return true;
}
</script>
