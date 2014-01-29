<?php

//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

//OBJECT DECLARTION
$objMasterDB	= new MemcacheDB;

//DB CONNECTION
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

if ($_REQUEST['frmCheckValidityPeriodSubmit'] == 'yes') {

	$varMatriId				= $_REQUEST['matriId'];
	$varCurrentDate			= date('Y-m-d h:i:s');
	$varNewValidityPeriod	= $_REQUEST['newValidityPeriod'];	

	//SETING MEMCACHE KEY
	$varProfileMCKey		= 'ProfileInfo_'.$varMatriId;

	$varCondition	= " MatriId='".$varMatriId."'";
	$varFields		= array('Valid_Days','Last_Payment','Expiry_Date','Paid_Status');
	$varFieldsValue	= array("'".$varNewValidityPeriod."'","'".$varCurrentDate."'",'DATE_ADD(\''.$varCurrentDate.'\', INTERVAL '.$varNewValidityPeriod.' DAY)','1');
	$objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFieldsValue, $varCondition,$varProfileMCKey);

}//IF
?>
<table border='0' cellpadding='4' cellspacing='4' width="540">
	<tr><td  class="heading">Update Validity Period</td></tr>
	<tr><td  class="smalltxt">Validity Period Updated as <b><?=$varNewValidityPeriod;?></b> Successfully.</td></tr>
</table>