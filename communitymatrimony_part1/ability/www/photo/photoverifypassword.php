<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 28-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: photoverifypassword.php
#================================================================================================================
   # Description	: verify the protected password
#================================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//Select Query Decleration
$varOppsiteMatriId	= $_REQUEST['ID'];
$varReqPassword		= trim($_REQUEST['password']);
$varSuccessMsg		= '';

//if ($_REQUEST['frmPasswordSubmit']=='yes'){
	//Object initialization
	$objSlaveDB			= new DB;
	//CONNECTION DECLARATION
	$varSlaveConn			= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
	$varCondition			= " WHERE MatriId =".$objSlaveDB->doEscapeString($varOppsiteMatriId,$objSlaveDB);
	$varFields				= array('Photo_Protect_Password');
	$varResult				= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
	$arrSelectPhotoInfo		= mysql_fetch_assoc($varResult);
	$varPhotoProtPassword	= trim($arrSelectPhotoInfo['Photo_Protect_Password']);

	if (($varPhotoProtPassword == md5($varReqPassword)) || ($varPhotoProtPassword == $varReqPassword)) {
		$varSuccessMsg		=	"1~".$varOppsiteMatriId."~".base64_encode($varReqPassword);
	} else {
		$varSuccessMsg		=	"0~";
	}
	$objSlaveDB->dbClose();
	unset($objSlaveDB);
//}
echo $varSuccessMsg;
?>