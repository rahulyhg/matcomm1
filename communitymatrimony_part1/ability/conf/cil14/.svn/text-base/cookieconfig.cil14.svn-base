<?php
$varSalt = 'cbstest';

// FUNCTIONS DECLARATION
function funCookieInfo() {
	global $varCookieLoginInfo, $varCookieMessagesInfo, $varCookieSavedSearchInfo, $varCookieFeatureBuzz, $varCookieWebNotification, $varCookieProfileInfo, $varCookieReqRecvInfo, $varCookieReqSentInfo, $varCookieListInfo, $varCookieViewsInfo, $varCookiePartnerInfo;

	if (isset($varCookieLoginInfo) && ($varCookieLoginInfo!="")) {
		$varCookieLoginInfo		= explode("^|", $varCookieLoginInfo);
		$varCookieMessagesInfo	= explode("^|", $varCookieMessagesInfo);
		$varCookieProfileInfo	= explode("^|", $varCookieProfileInfo);
		$varCookieReqRecvInfo	= explode("^|", $varCookieReqRecvInfo);
		$varCookieReqSentInfo	= explode("^|", $varCookieReqSentInfo);
		$varCookieListInfo		= explode("^|", $varCookieListInfo);
		$varCookieViewsInfo		= explode("^|", $varCookieViewsInfo);
		$varCookiePartnerInfo	= explode("^|", $varCookiePartnerInfo);

		$varCookieInfo							= array();
		$varCookieInfo['MATRIID']				= trim($varCookieLoginInfo[0]);
		$varCookieInfo['GENDER']				= trim($varCookieLoginInfo[1]);
		$varCookieInfo['STATUS']				= trim($varCookieLoginInfo[2]);
		$varCookieInfo['LASTLOGIN']				= $varCookieLoginInfo[3];
		$varCookieInfo['SALT']					= $varCookieLoginInfo[5];
		$varCookieInfo['DEFAULTVIEW']			= $varCookieLoginInfo[8];
		$varCookieInfo['ACTIVITYRANK']			= $varCookieLoginInfo[9];
		$varCookieInfo['NAME']					= ucwords(strtolower(trim($varCookieLoginInfo[10])));
		$varCookieInfo['USERNAME']				= trim($varCookieLoginInfo[11]);
		$varCookieInfo['VALIDDAYSLEFT']			= $varCookieLoginInfo[20];
		$varCookieInfo['TIMECREATED']			= $varCookieLoginInfo[21];
		$varCookieInfo['CREATEDWITHIN']			= $varCookieLoginInfo[22];
		$varCookieInfo['OFFERAVAILABLE']		= $varCookieLoginInfo[27];

		$varCookieInfo['MAILRECEIVEDNEW']			= $varCookieMessagesInfo[0];
		$varCookieInfo['MAILRECEIVEDREAD']			= $varCookieMessagesInfo[1];
		$varCookieInfo['MAILRECEIVEDREPLIED']		= $varCookieMessagesInfo[2];
		$varCookieInfo['MAILRECEIVEDDECLINED']		= $varCookieMessagesInfo[3];
		$varCookieInfo['MAILSENTNEW']				= $varCookieMessagesInfo[4];
		$varCookieInfo['MAILSENTREAD']				= $varCookieMessagesInfo[5];
		$varCookieInfo['MAILSENTREPLIED']			= $varCookieMessagesInfo[6];
		$varCookieInfo['MAILSENTDECLINED']			= $varCookieMessagesInfo[7];
		$varCookieInfo['INTERESTRECEIVEDNEW']		= $varCookieMessagesInfo[8];
		$varCookieInfo['INTERESTRECEIVEDACCEPT']	= $varCookieMessagesInfo[9];
		$varCookieInfo['INTERESTRECEIVEDDECLINED']	= $varCookieMessagesInfo[10];
		$varCookieInfo['INTERESTSENTNEW']			= $varCookieMessagesInfo[11];
		$varCookieInfo['INTERESTSENTACCEPT']		= $varCookieMessagesInfo[12];
		$varCookieInfo['INTERESTSENTDECLINED']		= $varCookieMessagesInfo[13];
		$varCookieInfo['TOTALREQUEST']				= $varCookieMessagesInfo[14];

		$varCookieInfo['PUBLISH']				= $varCookieProfileInfo[0];
		$varCookieInfo['PAIDSTATUS']			= $varCookieProfileInfo[1];
		$varCookieInfo['EXPIRYDATE']			= urldecode($varCookieProfileInfo[2]);
		$varCookieInfo['PHOTO']					= urldecode($varCookieProfileInfo[3]);// Photo name
		$varCookieInfo['FAMILYSTATUS']			= $varCookieProfileInfo[4];
		$varCookieInfo['HOBBIESSTATUS']			= $varCookieProfileInfo[5];
		$varCookieInfo['PARTNERSTATUS']			= $varCookieProfileInfo[6];
		$varCookieInfo['PHOTOSTATUS']			= $varCookieProfileInfo[7];
		$varCookieInfo['VIDEOSTATUS']			= $varCookieProfileInfo[8];
		$varCookieInfo['VOICESTATUS']			= $varCookieProfileInfo[9];
		$varCookieInfo['REFERENCESTATUS']		= $varCookieProfileInfo[10];
		$varCookieInfo['BOOKMARKCOUNT']			= $varCookieProfileInfo[11];
		$varCookieInfo['PHONEVIEWSCOUNT']		= $varCookieProfileInfo[12];
		$varCookieInfo['PHONEVERIFIED']			= $varCookieProfileInfo[13];
		$varCookieInfo['PRODUCTID']				= $varCookieProfileInfo[14];
		$varCookieInfo['LASTPAYMENT']			= urldecode($varCookieProfileInfo[15]);
		$varCookieInfo['NUMBEROFPAYMENTS']		= $varCookieProfileInfo[16];
		$varCookieInfo['VALIDDAYSLEFT']			= $varCookieProfileInfo[17];
		$varCookieInfo['HOROSCOPESTATUS']		= $varCookieProfileInfo[18];
		$varCookieInfo['PHYSICALSTATUS']		= $varCookieProfileInfo[19];

		$varCookieInfo['REQRECVPHOTOCNT']		= $varCookieReqRecvInfo[0];
		$varCookieInfo['REQRECVPHONECNT']		= $varCookieReqRecvInfo[1];
		$varCookieInfo['REQRECVHOROSCOPECNT']	= $varCookieReqRecvInfo[2];
		//$varCookieInfo['REQRECVREFERENCECNT']	= $varCookieReqRecvInfo[3];
		//$varCookieInfo['REQRECVQVOICECNT']	= $varCookieReqRecvInfo[4];


		$varCookieInfo['REQSENTPHOTOCNT']		= $varCookieReqSentInfo[0];
		$varCookieInfo['REQSENTPHONECNT']		= $varCookieReqSentInfo[1];
		$varCookieInfo['REQSENTHOROSCOPECNT']	= $varCookieReqSentInfo[2];
		//$varCookieInfo['REQSENTREFERENCECNT']	= $varCookieReqSentInfo[3];
		//$varCookieInfo['REQSENTVOICECNT']		= $varCookieReqSentInfo[4];


		$varCookieInfo['SHORTLISTCNT']			= $varCookieListInfo[0];
		$varCookieInfo['INGNORELISTCNT']		= $varCookieListInfo[1];
		$varCookieInfo['BLOCKLISTCNT']			= $varCookieListInfo[2];

		$varCookieInfo['VIEWSPHONEBYMECNT']		= $varCookieViewsInfo[0];
		$varCookieInfo['VIEWSPHONEBYOTHERCNT']	= $varCookieViewsInfo[1];
		$varCookieInfo['VIEWSPROFILEBYOTHERCNT']= $varCookieViewsInfo[2];

		$varCookieInfo['PPAGE']					= $varCookiePartnerInfo[0];
		$varCookieInfo['PPHEIGHT']				= $varCookiePartnerInfo[1];
		$varCookieInfo['PPLOOKINGFOR']			= $varCookiePartnerInfo[2];
		$varCookieInfo['PPPHYSICALSTATUS']		= $varCookiePartnerInfo[3];
		$varCookieInfo['PPMOTHERTONGUE']		= $varCookiePartnerInfo[4];
		$varCookieInfo['PPRELIGION']			= $varCookiePartnerInfo[5];
		$varCookieInfo['PPCASTE']				= $varCookiePartnerInfo[6];
		$varCookieInfo['PPEATHABITS']			= $varCookiePartnerInfo[7];
		$varCookieInfo['PPEDUCATION']			= $varCookiePartnerInfo[8];
		$varCookieInfo['PPCITIZENSHIP']			= $varCookiePartnerInfo[9];
		$varCookieInfo['PPCOUNTRY']				= $varCookiePartnerInfo[10];
		$varCookieInfo['PPINDIASTATE']			= $varCookiePartnerInfo[11];
		$varCookieInfo['PPUSASTATE']			= $varCookiePartnerInfo[12];
		$varCookieInfo['PPRESIDENTSTATUS']		= $varCookiePartnerInfo[13];
		$varCookieInfo['PPSMOKEHABITS']			= $varCookiePartnerInfo[14];
		$varCookieInfo['PPDRINKHABITS']			= $varCookiePartnerInfo[15];
		$varCookieInfo['PPSUBCASTE']			= $varCookiePartnerInfo[16];
	}
	return $varCookieInfo;
}

//COOKIE VARIABLES
$varCookieLoginInfo			= $_COOKIE["loginInfo"];
$varCookieMessagesInfo		= $_COOKIE["messagesInfo"];
$varCookieSavedSearchInfo	= $_COOKIE["savedSearchInfo"];
$varCookieFeatureBuzz		= $_COOKIE["featureBuzz"];
$varCookieWebNotification	= $_COOKIE["webNotify"];
$varCookieProfileInfo		= $_COOKIE["profileInfo"];
$varCookieReqRecvInfo		= $_COOKIE["requestReceivedInfo"];
$varCookieReqSentInfo		= $_COOKIE["requestSentInfo"];
$varCookieListInfo		    = $_COOKIE["listInfo"];
$varCookieViewsInfo		    = $_COOKIE["viewsInfo"];
$varCookiePartnerInfo		= $_COOKIE["partnerInfo"];

// FUNCTIONS CALLING
$varGetCookieInfo = funCookieInfo();

//CHECK SALT AND COOKIE VALUE IS SAME OR NOT

if($varGetCookieInfo['SALT'] != crypt($varGetCookieInfo['MATRIID'],$varSalt)) {
	$_COOKIE['loginInfo']			= '';
	$_COOKIE['profileInfo']			= '';
	$_COOKIE['partnerInfo']			= '';
	$_COOKIE['messagesInfo']		= '';
	$_COOKIE['savedSearchInfo']		= '';
	$_COOKIE['lastViewProfile']		= '';
	$_COOKIE['requestReceivedInfo']	= '';
	$_COOKIE['requestSentInfo']		= '';
	$_COOKIE['listInfo']			= '';
	$_COOKIE['viewsInfo']			= '';
	$varGetCookieInfo['MATRIID']	= '';
}


//PROFILE STATIC'S COUNTS
$varTotMsgRcevCnt = $varGetCookieInfo['MAILRECEIVEDNEW'] + $varGetCookieInfo['MAILRECEIVEDREAD'] + $varGetCookieInfo['MAILRECEIVEDREPLIED'] + $varGetCookieInfo['MAILRECEIVEDDECLINED'];
$varTotMsgSentCnt = $varGetCookieInfo['MAILSENTNEW'] + $varGetCookieInfo['MAILSENTREAD'] + $varGetCookieInfo['MAILSENTREPLIED'] + $varGetCookieInfo['MAILSENTDECLINED'];
$varTotIntRecvCnt = $varGetCookieInfo['INTERESTRECEIVEDNEW'] + $varGetCookieInfo['INTERESTRECEIVEDACCEPT'] + $varGetCookieInfo['INTERESTRECEIVEDDECLINED'];
$varTotIntSentCnt = $varGetCookieInfo['INTERESTSENTNEW'] + $varGetCookieInfo['INTERESTSENTACCEPT'] + $varGetCookieInfo['INTERESTSENTDECLINED'];
$varTotReqRecvCnt = $varGetCookieInfo['REQRECVPHOTOCNT'] + $varGetCookieInfo['REQRECVPHONECNT'] + $varGetCookieInfo['REQRECVHOROSCOPECNT'];
$varTotReqSentCnt = $varGetCookieInfo['REQSENTPHOTOCNT'] + $varGetCookieInfo['REQSENTPHONECNT'] + $varGetCookieInfo['REQSENTHOROSCOPECNT'];

function chkPremimumMembership() {

global $varGetCookieInfo;
$varBecomePaidMemberMsg = '';
if ($varGetCookieInfo["PHOTOSTATUS"]=='0' && $varGetCookieInfo["PHONEVERIFIED"]=='0') {

	$varBecomePaidMemberMsg = 'Add your Photo and Phone to get paid membership';

} else if ($varGetCookieInfo["PHOTOSTATUS"]=='0') {

	$varBecomePaidMemberMsg = 'Add your Photo to get paid membership';

} else if ($varGetCookieInfo["PHONEVERIFIED"]=='0') {

	$varBecomePaidMemberMsg = 'Verify your Phone to get paid membership';

}
	return $varBecomePaidMemberMsg;
}

?>