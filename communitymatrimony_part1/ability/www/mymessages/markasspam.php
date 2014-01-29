<?
//BASE PATH
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//INCLUDED FILES
include_once $varRootBasePath."/conf/config.cil14";
include_once $varRootBasePath."/conf/cookieconfig.cil14";
include_once $varRootBasePath."/conf/dbinfo.cil14";
include_once $varRootBasePath."/lib/clsDB.php";

//VARIABLE DECLERATION
$varMsgId		= $_POST['msgid']>0 ? $_POST['msgid'] : '';
$varCurrentDate = date('Y-m-d H:i:s');

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];

if($varMsgId>0 && $sessMatriId!=''){
//OBJECT DECLARTION
$objMasterDB= new DB;
$objSlaveDB	= new DB;

$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

$varCond	= 'WHERE Mail_Id='.$objSlaveDB->doEscapeString($varMsgId,$objSlaveDB);
$varFields	= array('MatriId', 'Opposite_MatriId', 'Mail_Message', 'Replied_Message');
$varOldRes	= $objSlaveDB->select($varTable['MAILRECEIVEDINFO'],$varFields,$varCond,0);
$varOldDet	= mysql_fetch_assoc($varOldRes);

if(count($varOldDet)>0){
	$varFields		= array('MessageId', 'ReceiverId', 'SenderId', 'Message', 'RepliedMessage', 'AlertDate');
	$varFieldsVal	= array($objMasterDB->doEscapeString($varMsgId,$objMasterDB), $objMasterDB->doEscapeString($sessMatriId,$objMasterDB), "'".$varOldDet['Opposite_MatriId']."'", "'".$varOldDet['Mail_Message']."'", "'".$varOldDet['Replied_Message']."'", "'".$varCurrentDate."'");
	$objMasterDB->insertIgnore($varTable['SPAMMSG'],$varFields,$varFieldsVal);
}
}

//UNSET OBJ
$objMasterDB->dbClose();
$objSlaveDB->dbClose();
unset($objMasterDB);
unset($objSlaveDB);
?>
