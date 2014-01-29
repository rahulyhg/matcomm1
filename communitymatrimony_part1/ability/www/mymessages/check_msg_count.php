<?php
#====================================================================================================
# Author 		: S Rohini
# Start Date	: 03 Sep 2008
# End Date		: 03 Sep 2008
# Project		: MatrimonyProduct
# Module		: Decline Personalized Message
#====================================================================================================
//Base Path //
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

// Include the files //
include_once $varRootBasePath."/conf/config.cil14";
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once $varRootBasePath."/lib/clsDB.php";

//OBJECT DECLARTION
$objDB		= new DB;

$objDB->dbConnect('M', $varDbInfo['DATABASE']);

//VARIABLES
$varMatriId	= trim($_GET['id']);

if ($varMatriId!="")
{
	//SELECT Opposite MatriId
	$varWhereCond	= " WHERE MatriId=".$objDB->doEscapeString($varMatriId,$objDB);
	$varFields		= array('Interest_Pending_Received','Interest_Accept_Received','Interest_Declined_Received','Interest_Pending_Sent','Interest_Accept_Sent', 'Interest_Declined_Sent','Mail_Read_Received','Mail_UnRead_Received','Mail_Replied_Received','Mail_Declined_Received','Mail_Read_Sent','Mail_UnRead_Sent','Mail_Replied_Sent','Mail_Declined_Sent');
	$varStatRes		= $objDB->select($varTable['MEMBERSTATISTICS'], $varFields, $varWhereCond, 0);
	$varStatInfo	= mysql_fetch_assoc($varStatRes);
	if(mysql_num_rows($varStatRes) > 0){
		$varCont   = '<table border="1">';
		$varCont  .= '<tr><th>Mesages Received</th><th>Messages Sent</th><th>Interests Received</th><th>Interests Sent</th></tr>';
		$varCont  .= '<tr><td>UnRead   : '.$varStatInfo['Mail_UnRead_Received'].'</td><td>UnRead   : '.$varStatInfo['Mail_UnRead_Sent'].'</td><td>Pending : '.$varStatInfo['Interest_Pending_Received'].'</td><td>Pending : '.$varStatInfo['Interest_Pending_Sent'].'</td></tr>';
		$varCont  .= '<tr><td>Read     : '.$varStatInfo['Mail_Read_Received'].'</td><td>Read     : '.$varStatInfo['Mail_Read_Sent'].'</td><td>Accept : '.$varStatInfo['Interest_Accept_Received'].'</td><td>Accept : '.$varStatInfo['Interest_Accept_Sent'].'</td></tr>';
		$varCont  .= '<tr><td>Replied  : '.$varStatInfo['Mail_Replied_Received'].'</td><td>Replied  : '.$varStatInfo['Mail_Replied_Sent'].'</td><td>Decline : '.$varStatInfo['Interest_Declined_Received'].'</td><td>Decline : '.$varStatInfo['Interest_Declined_Sent'].'</td></tr>';
		$varCont  .= '<tr><td>Declined : '.$varStatInfo['Mail_Declined_Received'].'</td><td>Declined : '.$varStatInfo['Mail_Declined_Sent'].'</td><td colspan="2"></td></tr></table>';
		echo $varCont;
	}else{
		echo 'Not Available';
	}
}

//UNSET OBJECT
$objDB->dbClose();
unset($objDB);
?>