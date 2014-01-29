<?php
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/ability/www';
}
$varBaseRoot = dirname($varRootPath);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.inc');
include_once($varBaseRoot.'/conf/domainlist.inc');
include_once($varBaseRoot."/lib/clsMailManager.php");

//Object Decleration
$objMailManager = new MailManager;

//Connect DB
$objMailManager->dbConnect('M', $varDbInfo['DATABASE']);

$varCurrDate	= date("Y-m-d");
$varFields		= array('COUNT(MatriId)', 'CommunityId');
$varWhereCond	= "WHERE BM_MatriId<>'' AND Date_Created>='".$varCurrDate." 00:00:00' AND Date_Created<='".$varCurrDate." 23:59:59' GROUP BY CommunityId";
$varMigSelDet	= $objMailManager->select($varTable['MEMBERINFO'], $varFields, $varWhereCond, 1);
$varTotal		= 0;
$varContent		= '<table border="1"><tr><th>Site Name</th><th>Count</th></tr>';
foreach($varMigSelDet as $varSingVal){
	$varMatriIdPrefix	= $arrMatriIdPre[$varSingVal['CommunityId']];
	$varDomainName		= $arrPrefixDomainList[$varMatriIdPrefix];
	$varCount			= $varSingVal['COUNT(MatriId)'];
	$varTotal			+= $varCount;
	$varContent			.= '<tr><td>'.$varDomainName.'</td><td>'.$varCount.'</td></tr>'; 
}
$varContent			.= '<tr><th>Total Count</th><th>'.$varTotal.'</th></tr></table>'; 

$varToMails			= array('Senthilnathan~senthilnathan@bharatmatrimony.com', 'Dhanapal~dhanapal@bharatmatrimony.com', 'Ashok~ashokkumar@bharatmatrimony.com', 'Linux admin~sedbm@consim.com');
$varCurrentDt		= date('jS M Y');
$varFrom			= "CommunityMatrimony.Com";
$varFromEmail		= "info@communitymatrimony.com";
$varReplyToEmail	= "info@communitymatrimony.com";
$varSubject			= "Communitymatirmony's ".$varCurrentDt." migrated profiles information";
foreach($varToMails as $varSingleDetail)
{
	$varUsername	= '';
	$varUserInfo	= '';
	$varMessage		= '';
	$varToEmail		= '';

	$varUserInfo	= split('~',$varSingleDetail);
	$varUsername	= $varUserInfo[0];
	$varToEmail		= $varUserInfo[1];	
	$varMessage		= "Dear ".$varUsername.", <BR><BR>".$varContent."<BR><BR>Thanks,<BR>CommunityMatrimony Team.";
	$objMailManager->sendEmail($varFrom,$varFromEmail,$varUsername,$varToEmail,$varSubject,$varMessage, $varReplyToEmail);	
}


//UNSET OBJECT
$objMailManager->dbClose();
UNSET($objMailManager);
?>