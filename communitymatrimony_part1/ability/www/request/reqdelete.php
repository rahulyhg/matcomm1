<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 18 Sep 2008
# End Date	: 18 Sep 2008
# Project		: MatrimonyProduct
# Module		: Request - Delete
#=============================================================================================================
//Base Path //
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
// Include the files //
include_once $varRootBasePath."/conf/config.cil14"; // This includes error reporting functionalities
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once $varRootBasePath."/lib/clsDB.php";

//Variable Declaration
$varSessionId	= $varGetCookieInfo['MATRIID'];
$varDisplayMsg	= "";

//VARIABLE DECLARATION
$varReqIds		= $_REQUEST["id"];
$varPurpose		= $_REQUEST["purp"];
$varForm		= $_REQUEST["frmnam"];
$varElem		= $_REQUEST["elemid"];
$varDelId		= $_REQUEST["delid"];
$varDelConfirm  = $_REQUEST['frmReqDelSub'];
$varReqs		= str_replace("~",",",trim($varReqIds,','));

$varMessage	 	= "Are you sure you want to delete the selected request(s)?";
$varButton		='<input type="hidden" name="frmReqDelSub" value="yes"><input type="hidden" name="id" value="'.$varReqIds.'"><input type="hidden" name="purp" value="'.$varPurpose.'"><input type="submit" value="Yes" class="button">&nbsp;&nbsp;<input type="button" name="Button2" value="No" class="button" onclick="javascript:closeIframe(\'iframeicon\',\'icondiv\');">';

if($varDelConfirm == 'yes') { 

	// Object Declaration
	$objDb			= new DB();
	$objDb->dbConnect('M', $varDbInfo['DATABASE']);

	if($varPurpose{1}=='R') { $varREQTable= $varTable['REQUESTINFORECEIVED'];} 
	else { $varREQTable	= $varTable['REQUESTINFOSENT'];}
	
	$arrFields		= array('Delete_Status');
	$arrFieldValues = array(1);
	$varCond		= " RequestId IN (".$objDb->doEscapeString($varReqs,$objDb).")";
	$objDb->update($varREQTable, $arrFields, $arrFieldValues, $varCond);
	$varMessage	 	= "Request deleted successfully.";
	
    $varButton		="<input type='button' name='close' value='Close' class='button' onclick=\"javascript:parent.reLoadMyHome('/request/requestall_ctrl.php','".$varPurpose."','',1);\">";

	//UNSET OBJECT
	$objDb->dbClose();
	unset($objDb);
} 
?>
<html>
<head>
	<title><?=$confPageValues['PAGETITLE']?></title>
	<link href="<?=$confValues['CSSPATH']?>/global-style.css" rel="stylesheet" type="text/css"/>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/position.js" ></script>
	<script>
	function populateId() {
		var a;a=selectedids('~','<?=$varForm?>','<?=$varElem?>');
		document.delfrm.id.value = a;
	}
	</script>
</head>
<body onload="<?=($varDelId!='')?'populateId();':''?>">
<form name="delfrm">
 <div id="reqdel">
  <div style='width:470px;'>
    <div style="padding: 5px 10px 5px 10px;"><font class='mediumtxt boldtxt clr3'>Confirmation</font>
    <div class="divborder"><div style="padding:10px;">
		<div class="smalltxt boldtxt" style='padding-top:5px'><font class="smalltxt"><?=$varMessage?></font></div>
     </div></div>
     </div>
   <div class="fright" style="padding-top:5px; padding-right:7px;"><?= $varButton?></div>
  </div>
 </div>
</form>
</body>
</html>