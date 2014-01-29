<?php
#=============================================================================================================
# Author 		: Baranidharan
# Date	        : 2010-05-14
# Project		: Community Matrimony Product
# Module		: Admin Support Interface
# Description   : showing count of Pending profiles to be validated
#=============================================================================================================

$varRootBasePath	= '/home/product/community';

//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsRegister.php');

//OBJECT DECLARTION
$objSlave	= new clsRegister;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

$varYesterDay	= mktime(date("h"),date("i"),date("s"),date("m"),date("d")-1,date("Y"));
$varYesterDay	= date("Y-m-d h:i:s", $varYesterDay);

//getting profiles yet to be validated in memberinfo, more 24 hours
$varCondition	= " WHERE Publish = 0 AND date_created <= ' $varYesterDay'";
$varProfileCount= $objSlave->numOfRecords($varTable['MEMBERINFO'],'MatriId',$varCondition);

//getting profiles yet to be validated in memberupdatedinfo
$varCondition		= " WHERE date_updated <= '$varYesterDay'";
$varUpdatedCount	= $objSlave->numOfRecords($varTable['MEMBERUPDATEDINFO'],'MatriId',$varCondition);

$objSlave->dbClose();
?>
<html>
<head>
<title>
showing count of Pending profiles to be validated
</title>
<link rel=stylesheet href="<?=$confValues["CSSPATH"]?>/global-style.css">
</head>

<body>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545">
	<tr><td height="15"></td></tr>
	<tr><td class="heading" style="padding-left:10px;">Current Validate Profiles After One Day </td></tr>
	<tr><td class="mediumtxt" align="right" style="padding-right:45px;padding-top:5px;padding-bottom:0px;color:red"><b>New Profiles Pending Count After One Day : <?=$varProfileCount?></b></td></tr>
	<tr><td class="mediumtxt" align="right"  style="padding-right:45px;padding-top:5px;padding-bottom:0px;color:red"><b>Modify Profiles Pending Count After One Day : <?=$varUpdatedCount?></b></font></div></td></tr>
</table>
</body>
</html>