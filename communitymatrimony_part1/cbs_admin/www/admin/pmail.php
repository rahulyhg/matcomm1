<?php
//FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsMailManager.php');

//OBJECT DECLARTION
$objDBase	= new DB;
$objMailManager	= new MailManager;

//DB CONNECTION
if($varStatus=='Inactive') {
	$objDBase->dbConnect('S',$varInactiveDbInfo['DATABASE']);
	$varTitle ='View Inactive Profile';
	$varActStatus ='no';
}else {
	$objDBase->dbConnect('S',$varDbInfo['DATABASE']);
	$varTitle ='View Profile';
	$varActStatus ='yes';
}

//CONTROL STATEMENT
if ($_POST["frmViewProfileSubmit"]=="yes") {
	$varTextValue 		= trim($_REQUEST["textboxvalue"]);
	$argCondition		= "WHERE MatriId=".$objDBase->doEscapeString($varTextValue,$objDBase);
	$argFields 			= array('MatriId','Email','Password','User_Name');
	$varProfileRes		= $objDBase->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
	$varNumOfRecords	= mysql_num_rows($varProfileRes);
	} 
$objDBase->dbClose();
	
if ($varNumOfRecords > 0) {
	$varSelectProfile = mysql_fetch_assoc($varProfileRes);	
	global $confvalues;
	$email=$varSelectProfile['Email'];
	$argMatriId=$varSelectProfile['MatriId'];
	$argPassword=$varSelectProfile['Password'];
	$argName=$varSelectProfile['User_Name'];
	$arrGetProductInfo		= $objMailManager->getDomainDetails($argMatriId);
	$arrGetEmailInfo		= $objMailManager->getDomainEmailList($argMatriId);
	
	$funFrom			    = $arrGetProductInfo['FROMADDRESS'];
	$funFromEmail			= $arrGetEmailInfo['INFOEMAIL'];
	$funReplyToEmail		= $arrGetEmailInfo['NOREPLYMAIL'];	
	$funServerUrl			= $arrGetProductInfo['SERVERURL'];
	$funMailerImagePath		= $arrGetProductInfo['MAILERIMGURL'];	 
	$funIMGSPath			= $arrGetProductInfo['IMGURL'];	 
	
	$argTo = "$argName";
	$argToEmailAddress = "$email";
	$funFolderName			= $objMailManager->getFolderName($argMatriId);
	
	$funProductName		= $arrGetProductInfo['PRODUCTNAME'];	
	$varTemplateFileName	= $confValues['MAILTEMPLATEPATH']."/admindeleteprofile.tpl"; //do change (template file)	
	 $funSubject			= "Welcome to ".$funProductName."Matrimony.com";
	 $unsubscibeLink			= $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";
		$getcontent	= $objMailManager->getContentFromFile($varTemplateFileName);
		$getcontent	= str_replace("<--MATRIID-->",$argMatriId,$getcontent);
		$getcontent	= str_replace("<--PASSWORD-->",$argPassword,$getcontent);
		$getcontent	= str_replace("<--NAME-->",ucfirst($argName),$getcontent);		
		$getcontent	= str_replace("<--LOGO-->",$funIMGSPath.'/logo/'.$funFolderName,$getcontent);
		$getcontent	= str_replace("<--MAILERIMGSPATH-->",$funMailerImagePath,$getcontent);
		$getcontent	= str_replace("<--PRODUCTNAME-->",$funProductName,$getcontent);	
		$getcontent	= str_replace("<--UNSUBSCRIBE_LINK-->",$unsubscibeLink,$getcontent);
		$funMessage	= stripslashes($getcontent);
	
	
	 $varFolderName = $objMailManager->sendEmail($funFrom,$funFromEmail,$argTo,$argToEmailAddress,$funSubject,$funMessage,$funReplyToEmail);	
	
}
?>
<script language="javascript">
function funViewProfileId() {
	var frmName = document.frmSendMailProfile;
	if (frmName.textboxvalue.value=="" ) {
		alert("Please enter  MatriId");
		frmName.textboxvalue.focus();
		return false;
	}
	frmName.frmViewProfileSubmit.value='yes';
	frmName.submit();
	return true;
}//funViewProfileId
</script>

<form name="frmSendMailProfile" method="post">
<input type="hidden" name="frmViewProfileSubmit" value="">
<table border="0" cellpadding="0" cellspacing="0" align="left" width="545">
	<tr><td height="10"></td></tr>
	<tr>
		<td valign="middle" class="heading" style="padding-left:15px;">Delete Profile Mailer</td>
	</tr>
	<tr><td height="15" colspan="2"></td></tr>
	<tr><td height="15" colspan="2"></td></tr>
	<?php if ($_POST["frmViewProfileSubmit"]=="yes" && $varNumOfRecords==0) { ?>
	<tr><td align="center" class="errortxt">No data found</td></tr><tr><td height="10" ></td></tr>
	<?php }//if ?>	
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><b>MatriID </b>&nbsp;<input type=text name="textboxvalue" value="<?=$varTextValue;?>" size="35" class="inputtext">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Submit" class="button" onClick="return funViewProfileId();"></td>
	</tr>
	<tr><td height="20"></td></tr>
	<?php if($_POST["frmViewProfileSubmit"]=="yes" && $varFolderName=="yes"){?>
		<tr><td align="center" class="errortxt">Message Sent Sucessfully</td></tr><tr><td height="10" ></td></tr>
	<?php }?>
</table>
</form><br><br>