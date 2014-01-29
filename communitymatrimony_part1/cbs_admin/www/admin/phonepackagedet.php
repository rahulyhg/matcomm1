<?php

//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath.'/lib/clsRegister.php');

$varAction	  = $_REQUEST["submit1"];    

//OBJECT DECLARTION
$objSlave	= new clsRegister;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

//CONTROL STATEMENT
if ($_POST["frmViewProfileSubmit"]=="yes") {
	$varTextValue 					=  trim($_REQUEST["textboxvalue"]);
    if($varAction == 'Search' && $varTextValue != '') {
	 $argCondition				= "WHERE ma.MatriId = ph.MatriId AND ph.MatriId=".$objSlave->doEscapeString($varTextValue,$objSlave);
	 $argFields 					= array('ma.MatriId','ph.TotalPhoneNos','ph.NumbersLeft');
	 $varCombinedTables			= $varTable['MEMBERINFO'].' as ma,'.$varTable['PHONEPACKAGEDET'].' as ph';
	 $varProfileRes				= $objSlave->select($varCombinedTables,$argFields,$argCondition,0);
	 $varNumOfRecords			= mysql_num_rows($varProfileRes);
	}
	else if($varAction == 'Submit' && $varTextValue != '') {
      
	  //OBJECT DECLARTION
      $objMaster	= new clsRegister;

      //DB CONNECTION
      $objMaster->dbConnect('M',$varDbInfo['DATABASE']);
	  $varTotalPhoneNos 					=  addslashes(strip_tags(trim($_REQUEST["totalphonenos"])));
	  $varNumbersLeft 					=  addslashes(strip_tags(trim($_REQUEST["numbersleft"])));
	  $argCondition				= " MatriId=".$objSlave->doEscapeString($varTextValue,$objSlave);
	  $argFields 				= array('TotalPhoneNos','NumbersLeft');
	  $argFieldsValues=array($varTotalPhoneNos,$varNumbersLeft);
	  $varUpdateId		= $objMaster->update($varTable['PHONEPACKAGEDET'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);
	  $varTextValue = '';
	  echo "New values are updated successfully";

	}
	else {
	 $varTextValue = '';
	}
} //if

$varProfileRes = mysql_fetch_array($varProfileRes);
$objSlave->dbClose();

?>
<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script> 
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/usericons-sprites.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/useractions-sprites.css">
<body align="center">
<table width="88%" align="center" border="0"><tr><td>
<img src="<?=$confValues['IMGSURL']?>/logo/community_logo.gif" alt="Community Matrimony" border="0" />
</td></tr></table>
<br clear="all">

<form name="frmViewEmailProfile" target="" method="post">
<input type="hidden" name="frmViewProfileSubmit" value="">
<input type="hidden" name="MatriId" value="">
<table border="0" cellpadding="0" cellspacing="0" align="left" width="545">
	<tr><td height="10"></td></tr>
	<tr><td height="15" colspan="2"></td></tr>
	<tr><td class="heading"  style="padding-left:15px;"><?=$varTitle; ?></td></tr>
	<tr><td height="15" colspan="2"></td></tr>

	<?php if ($_POST["frmViewProfileSubmit"]=="yes" && $varAction == 'Search' && $varNumOfRecords==0) { ?>
	<tr><td align="center" class="errortxt">No Records found</td></tr><tr><td height="10" ></td></tr>
	<?php }//if ?>
	<tr>
		<td class="smalltxt" align="left" style="padding-left:15px;"><b>MatriID</b>&nbsp;<input type=text <?print ($varNumOfRecords > 0)?'readonly=""':''?> name="textboxvalue" value="<?=$varTextValue;?>" size="35" class="inputtext">&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>

	<? if($varNumOfRecords > 0) { ?>
    <tr>
		<td class="smalltxt" style="padding-left:15px;">&nbsp;<br></td>
	</tr>
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><b>Numbers Left</b> <?=$varProfileRes['NumbersLeft'];?><br></td>
	</tr>
	<tr>
		<td class="smalltxt" style="padding-left:15px;">&nbsp;<br></td>
	</tr>
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><b>Total Phone Nos</b> <?=$varProfileRes['TotalPhoneNos'];?><br></td>
	</tr>
	<tr>
		<td class="smalltxt" style="padding-left:15px;">&nbsp;<br></td>
	</tr>
	 <tr>
		<td class="smalltxt" align="left" style="padding-left:15px;"><b>Total Phone Nos</b>&nbsp;<input type=text name="totalphonenos" size="3" value="<?=$varProfileRes['TotalPhoneNos'];?>" class="inputtext" onKeypress="return allowNumeric(event)">&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td class="smalltxt" style="padding-left:15px;">&nbsp;<br></td>
	</tr>
	<tr>
		<td class="smalltxt" align="left" style="padding-left:15px;"><b>Numbers Left</b>&nbsp;<input type=text name="numbersleft" size="3" value="<?=$varProfileRes['NumbersLeft'];?>" class="inputtext" onKeypress="return allowNumeric(event)">&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<? } ?>
    <tr>
		<td class="smalltxt" style="padding-left:15px;">&nbsp;<br></td>
	</tr>
	<tr>
		<td align="center"><input type="submit" name="submit1" value="<?print ($varNumOfRecords > 0)?'Submit':'Search'?>" class="button" onClick="return funViewProfileId();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Cancel" class="button"></td>
	</tr>
	<tr><td height="20"></td></tr>
</table>
</form><br><br>	

<script language="javascript">
function funViewProfileId() {
    var frmName = document.frmViewEmailProfile;
	var action = frmName.submit1.value;
	if (frmName.textboxvalue.value=="" ) {
		alert("Please enter  E-Mail / BM-MatriId");
		frmName.textboxvalue.focus();
		return false;
	}
	frmName.frmViewProfileSubmit.value='yes';
	if(action == "Submit") {
	  if(confirm("Are you sure to continue??") == false)
		 return false;
	}
	frmName.submit();
	return true;
}//funViewProfileId

// function which allows user to enter only numbers and backspace key
function allowNumeric(e) {
   var charCode = (e.which) ? e.which : window.event.keyCode; 
      if(((charCode >= 48) && (charCode <= 57)) || (charCode == 8) ) {
          return true;
	  }
	  return false;
}
</script>