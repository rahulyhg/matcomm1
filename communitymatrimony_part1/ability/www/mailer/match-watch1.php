<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-11-19
# End Date		: 2008-11-19
# Project		: MatrimonyProduct
# Module		: Mailer
#=============================================================================================================
//FILE INCLUDES
$varServerBasePath	= '/home/product/community/ability';
include_once($varServerBasePath.'/conf/dbinfo.cil14');
include_once($varServerBasePath.'/conf/config.cil14');
include_once($varServerBasePath.'/conf/cityarray.cil14');
include_once($varServerBasePath.'/conf/emailsconfig.cil14');
include_once($varServerBasePath.'/conf/domainlist.cil14');
include_once($varServerBasePath.'/lib/clsMailerMatchWatch.php');

function sendMatchWatch($varDomainId,$varDomainPrefix,$objMailerMatchWatch,$objMasterDB,$arrMWMatriIds) {

	global $varDbInfo,$varMatchSentDate;

	$varMSateOnly	= date('Y-m-d',strtotime($varMatchSentDate));
	$varPurpose		= 'match';
	$varMWType		= '1';

	$ResMailerSetMembers	= $objMailerMatchWatch->getMatchWatchMatriIds($varDomainId,$varDomainPrefix,$arrMWMatriIds);
	$varMailerSetMembersCnt	= mysql_num_rows($ResMailerSetMembers);

	$Cnt=0;
	if($varMailerSetMembersCnt != 0) {
		 while($varMailerSetMembers = mysql_fetch_assoc($ResMailerSetMembers)) {
			$arrProfileMatchId = array();
			$varMatriId		= $varMailerSetMembers['MatriId'];
			$varGender		= $varMailerSetMembers['Gender']==2?'1':'2';
			$varPartnerSet	= $varMailerSetMembers['Partner_Set_Status'];
			$varCommunityId	= $varMailerSetMembers['CommunityId'];
			$varCasteOrDivision	= $varMailerSetMembers['CasteId'];
			$varSubcaste	= $varMailerSetMembers['SubcasteId'];
			$varPaidStatus	= $varMailerSetMembers['Paid_Status'];
			$varLastPayment	= $varMailerSetMembers['Last_Payment'];
			$varValidDays	= $varMailerSetMembers['Valid_Days'];

			$varName		= $varMailerSetMembers['Name'];
			$varActivityRank= $varMailerSetMembers['Activity_Rank'];
			$varUserName	= $varMailerSetMembers['User_Name'];
			$varEmail		= $varMailerSetMembers['Email'];
			
			$varExpiryDate	= $varMailerSetMembers['Expiry_Date'];

			//Calculate Valid days for Paid members
			$varTodayDate		= date('m-d-Y');
			$varLastPayment		= date('m-d-Y',strtotime($varLastPayment));
			$varNumOfDays		= $objMailerMatchWatch->dateDiff("-",$varTodayDate,$varLastPayment);
			$varRemainingDays	= $varValidDays - $varNumOfDays;

			//Getting Profile Match MatriId
			$arrProfileMatchId	= $objMailerMatchWatch->ProfileIamLooking($varCommunityId,$varMatriId,$varGender,$varPartnerSet,$varPurpose,$varCasteOrDivision,$varSubcaste,$varPaidStatus,$varMSateOnly);
			if(sizeof($arrProfileMatchId) != 0) {
				//Send Match Watch Mail
				$varRetValue= $objMailerMatchWatch->sendMatchWatchMail($varMatriId,$varName,$varEmail,$varPaidStatus,$varPartnerSet,$varLastPayment,$varValidDays,$varRemainingDays,$varExpiryDate,$arrProfileMatchId,$varCasteOrDivision,$varPurpose);

				if($varRetValue=='yes') {
					$Cnt++;
					//Match sent by mail has to updates in matchwatchsentdetails
					$varUpdateRet	= $objMasterDB->updateMWSentDtls($varMatriId,$varCasteOrDivision,sizeof($arrProfileMatchId),$varMWType,$varMatchSentDate);
				}
			}
		 }
	}

	return $Cnt;
}

//OBJECT DECLARATION
$objMailerMatchWatch= new MailerMatchWatch;
$objMasterDB		= new MailerMatchWatch;

//Connect DB
$objMailerMatchWatch->dbConnect('S',$varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARAIBLE DECLARATION
$varMatchSentDate		= date("Y-m-d H:i:s");
$domnum					= 0;

//DELETE alert off record
$varDeleteCond			= "Matchwatch=0 AND SpecialFeatures=0 AND Promotions=0 AND ThirdParty=0";
$objMasterDB->delete($varTable['MAILMANAGERINFO'],$varDeleteCond);

//Match watch starts here
$argFrom				= "MatchWatch for Community";
$argFromEmailAddress	= "info@communitymatrimony.com";
$argTo					= "MatchWatchCron for Community";
$argToEmailAddress		= "jeyakumar@bharatmatrimony.com,dhanapal@bharatmatrimony.com";
//$argToEmailAddress		= "greennjk@gmail.com";
$argSubject				= "Community MatchWatch Starts";
$argMessage				= "Community MatchWatch Starts (".$varMatchSentDate.")";
$argReplyToEmailAddress = "";
$objMailerMatchWatch->sendEmail($argFrom,$argFromEmailAddress,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress);

$arrRestrictedCommId	= array(1, 3, 5, 6, 7, 294, 281, 8, 9, 10, 11, 12, 13, 14, 15, 295, 296, 297, 16, 17, 18, 19, 298, 21, 22, 23, 24, 30, 31, 32, 339, 33, 34, 36, 301, 37, 38, 39, 42, 41, 43, 44, 45, 46, 47, 302, 303, 48, 49, 50, 2000);

foreach($arrMatriIdPre as $key=>$val) {
	if(!in_array($key,$arrRestrictedCommId)) {
		//get community wise matchwatch record count
		$varCnt				= 0;
		$varLimitRec		= 500;
		$argMWCondition		= " WHERE CommunityId=".$key." AND Matchwatch=1";
		$varMWMatchCount	= $objMailerMatchWatch->numOfRecords($varTable['MAILMANAGERINFO'], 'MatriId', $argMWCondition);
		$varMWLoop			= ceil($varMWMatchCount/$varLimitRec);

		for($i=0,$j=0; $i < $varMWLoop; $i++) {
			$varStLt		= $i*$varLimitRec;
			$varEndLt		= $varLimitRec;
			$arrMWMatriIds	= $objMailerMatchWatch->getLimitedMWMatriIds($key, $varStLt, $varEndLt);
			//print_r($arrMWMatriIds);
			//echo "<BR>";
			$varCnt	+= sendMatchWatch($key,$val,$objMailerMatchWatch,$objMasterDB,$arrMWMatriIds);
			$j++; 
			if ($j==10) { sleep(5);$j=0; }
		}
		
		$totalMW[$val]	= "<tr><td>&nbsp;".$arrPrefixDomainList[$val]."</td><td>&nbsp;".$varCnt."</td></tr>";
		$domnum++; 
	}
}

//Total Matches sent by mail has to update in memberinfo
$varUpdate	= $objMasterDB->updateMWCount($varMatchSentDate);
$countMsg	= $domnum.' Domain match watch mails Sent Successfully<br>';
$countMsg	.= "<table border=1 cellspacing=0 cellpadding=0><tr><td><b>&nbsp;Domain Name</b></td><td><b>&nbsp;Total no of mails sent</b></td></tr>";

//Match Watch Report
$argToEmailAddress		= "jeyakumar@bharatmatrimony.com,dhanapal@bharatmatrimony.com,ashokkumar@bharatmatrimony.com,mahadevan@bharatmatrimony.com,jshree@bharatmatrimony.com,shankar@consim.com";
$totalMW			= join('',$totalMW);
$argSubject			= "Community MatchWatch Finished (".$varMatchSentDate.")";
$countMsg			.=$totalMW."</table>";
$argMessage			= $countMsg;
$argReplyToEmailAddress = "";
$objMailerMatchWatch->sendEmail($argFrom,$argFromEmailAddress,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress);


$objMailerMatchWatch->dbClose();
$objMasterDB->dbClose();
?>