<?php
#=============================================================================================================
# Author 		: Senthilnathan
# Start Date	: 2009-01-22
# End Date		: 2009-01-22
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================
//DOCUMENT ROOT
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
//$objSlave   = new DB();
$objDB		= new DB();

//DB CONNECTION
//$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objDB->dbConnect('S',$varMatchwatchDbInfo['DATABASE']);


//VARIALBE DECLERATION
$varTotalMWCnt	= $_GET['totmw'];
$varMatriId		= $_GET['id'];

$varFields		= array('ActualMatches','MatchwatchSentDate');
$varCondition	= "WHERE MatriId=".$objDB->doEscapeString($varMatriId,$objDB)." ORDER BY MatchwatchSentDate DESC limit 1";
$varSelUserRes	= $objDB->select('matchwatchmailarchive', $varFields, $varCondition, 0);
$varTotalNoOfRows =mysql_num_rows($varSelUserRes);
$varSelectUser	= mysql_fetch_array($varSelUserRes);
$varActualMatch = explode(',',$varSelectUser['ActualMatches']);
//echo count($varActualMatch);
if($varTotalNoOfRows>0){ 
$varContent			= '<table border="0" cellpadding="2" bgcolor="#FFFFFF" cellspacing="2" align="left" width="390" style="padding:5px"><tr><td colspan="4" bgcolor="#EEEEEE" class="heading">Matchwatch Sent Details</td></tr>';
$varContent		   .= '<tr class="boldtxt mediumtxt"><td bgcolor="#EEEEEE" >MatriId</td><td bgcolor="#EEEEEE" >'.$varMatriId.'</td></tr><tr class="boldtxt mediumtxt"><td bgcolor="#EEEEEE" >Total Matches sent count</td><td bgcolor="#EEEEEE" >'.$varTotalMWCnt.'</td></tr><tr class="boldtxt mediumtxt"><td bgcolor="#EEEEEE" >Last sent date</td><td bgcolor="#EEEEEE" >'.date("d-m-Y",strtotime($varSelectUser['MatchwatchSentDate'])).'</td></tr><tr class="boldtxt mediumtxt"><td bgcolor="#EEEEEE" >Matches sent on last day</td><td bgcolor="#EEEEEE" >'.count($varActualMatch).'</td></tr>';
$varContent	.= '</table>';
}else {
$varContent			= '<table border="0" cellpadding="2" bgcolor="#FFFFFF" cellspacing="2" align="left" width="390" style="padding:5px"><tr><td colspan="4" bgcolor="#EEEEEE" class="heading">Matchwatch Sent Details</td></tr>';
$varContent		   .= '<tr class="boldtxt mediumtxt" align="center"><td bgcolor="#EEEEEE" >Last 30 Days No MatchWatch Has Sent</td></tr>';
$varContent	.= '</table>';
}

//Unset Object
$objDB->dbClose();
unset($objDB);
?>
<html>
<head>
<title>Match watch mail sent details</title>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/global-style.css">
<style>
	td{padding-left:5px;}
</style>
</head>
<body>
<?=$varContent?>
</body>
</html>