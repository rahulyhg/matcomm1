<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-11-19
# End Date		: 2008-11-19
# Project		: MatrimonyProduct
# Module		: Mailer
#=============================================================================================================
//FILE INCLUDES
$varServerBasePath	= '/home/product/community';
include_once($varServerBasePath.'/conf/dbinfo.inc');
include_once($varServerBasePath.'/conf/config.inc');
include_once($varServerBasePath.'/conf/cityarray.inc');
include_once($varServerBasePath.'/conf/emailsconfig.inc');
include_once($varServerBasePath.'/conf/domainlist.inc');
include_once($varServerBasePath.'/conf/mwdomainlist.inc');
include_once($varServerBasePath.'/lib/clsDB.php');


//OBJECT DECLARATION
$objDB = new DB;
$objMasterDB = new DB;

//CONNECT DB
$objDB->dbConnect('S2',$varMatchwatchDbInfo['DATABASE']);
if($objDB->clsErrorCode!='') {
	echo $objDB->clsErrorCode;
	exit;
}

for($loop=1; $loop<=4; $loop++) {
	$varCnt					= 0;
	$varLimitRec			= 1000;
	$funCondition			= " WHERE Status=1";
	$varMatchwatchMailTbl	= 'cbsmatchwatch.matchwatchmail_'.$loop;
	$totalmailsresAll		= $objDB->numOfRecords($varMatchwatchMailTbl, 'MatriId', $funCondition);
	$varMWLoop				= ceil($totalmailsresAll/$varLimitRec);

	for($i=0,$j=0; $i < $varMWLoop; $i++) {
		$varStLt			= $i*$varLimitRec;
		$varEndLt			= $varLimitRec;
		$funFields			= array('CommunityId','MatriId','TotalMatches');
		$funCondition		= " WHERE Status=1 LIMIT ".$varStLt.",".$varEndLt;
		$arrMatriIdsDetRes	= $objDB->select($varMatchwatchMailTbl, $funFields, $funCondition, 0); 

		$m=0;
		while ($arrMatriIdsDet = mysql_fetch_assoc($arrMatriIdsDetRes)) {
			$varMatchCnt[$m]['MatriId'] = $arrMatriIdsDet['MatriId'];
			$varMatchCnt[$m]['CNT'] = $arrMatriIdsDet['TotalMatches'];
			$m++;
		}

		$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);
		for($k=0; $k<=count($varMatchCnt); $k++) {
			if($varMatchCnt[$k]['MatriId']!='' && $varMatchCnt[$k]['CNT']!='') {
				$argFields		= array('Match_Watch_Email');
				$argFieldValues	= array('Match_Watch_Email+'.$varMatchCnt[$k]['CNT']);
				$argCondition	= " MatriId	= '".$varMatchCnt[$k]['MatriId']."'";
				$varUpdateMSRet	= $objMasterDB->update($varTable['MEMBERSTATISTICS'],$argFields,$argFieldValues,$argCondition);
			}
		}
		$objMasterDB->dbClose();
	}


	
}
?>
