<?php
#================================================================================================================
# Author 		: Baskaran
# Date	        : 2008-07-09
# Project		: MatrimonyProduct
# Filename		: dbinfo.inc
#================================================================================================================
# Description   : MySQL Database and Table name variables
#================================================================================================================

// VARIABLE DECLARATION
$varDbInfo	= array();
$varTable	= array();

// DB AUTH INFO
$varDbInfo['USERNAME']			= 'User4Cbs';
$varDbInfo['PASSWORD']			= '3rmMWua4';
$varDbInfo['DATABASE']			= 'communitymatrimony';
$varCbstminterfaceDbInfo['DATABASE']	= 'cbstminterface';
$varCbsRminterfaceDbInfo['DATABASE']	= "cbsrminterface";

// 48 TABLES NAME VARIABLES
$varTable['ACTIVITYRATIO']		= 'activityratio';
$varTable['ADDREFERENCE']		= 'addreference';
$varTable['ADMINLOGININFO']		= 'adminlogininfo';
$varTable['BLOCKINFO']			= 'blockinfo';
$varTable['BOOKMARKINFO']		= 'bookmarkinfo';
$varTable['COMMUNICATIONRECEIVED']	= 'communicationreceived';
$varTable['COMMUNICATIONSENT']		= 'communicationsent';
$varTable['IGNOREINFO']				= 'ignoreinfo';
$varTable['INTERESTPENDINGINFO']	= 'interestpendinginfo';
$varTable['INTERESTRECEIVEDINFO']	= 'interestreceivedinfo';
$varTable['INTERESTSENTINFO']		= 'interestsentinfo';
$varTable['INTERESTSENTTRACKINFO']	= 'interestsenttrackinfo';
$varTable['MAILDRAFTINFO']		= 'maildraftinfo';
$varTable['MAILFOLDERINFO']		= 'mailfolderinfo';
$varTable['MAILMANAGERINFO']		= 'mailmanagerinfo';
$varTable['MAILPENDINGINFO']		= 'mailpendinginfo';
$varTable['MAILRECEIVEDINFO']		= 'mailreceivedinfo';
$varTable['MAILSENTINFO']		= 'mailsentinfo';
$varTable['MAILSENTTRACKINFO']		= 'mailsenttrackinfo';
$varTable['MATRIIDINFO']		= 'matriidinfo';
$varTable['MEMBERACTIONINFO']		= 'memberactioninfo';
$varTable['MEMBERDELETEDINFO']		= 'memberdeletedinfo';
$varTable['MEMBERFAMILYINFO']		= 'memberfamilyinfo';
$varTable['MEMBERFILTERINFO']		= 'memberfilterinfo';
$varTable['MEMBERHOBBIESINFO']      = 'memberhobbiesinfo';
$varTable['MEMBERINFO']			= 'memberinfo';
$varTable['MEMBERLOGININFO']		= 'memberlogininfo';
$varTable['MEMBERLOGINLOG']			= 'memberloginlog';
$varTable['MEMBEROFFERINFO']		= 'memberofferinfo';
$varTable['MEMBERPARTLYCASEONEINFO']= 'memberpartlycaseoneinfo';
$varTable['MEMBERPARTLYINFO']		= 'memberpartlyinfo';
$varTable['MEMBERPARTNERINFO']		= 'memberpartnerinfo';
$varTable['MEMBERPHOTOINFO']		= 'memberphotoinfo';
$varTable['MEMBERPROFILEVIEWEDINFO']= 'memberprofileviewedinfo';
$varTable['MEMBERSTATISTICS']		= 'memberstatistics';
$varTable['MEMBERTRACKINGINFO']		= 'membertrackinginfo';
$varTable['MEMBERUPDATEDINFO']		= 'memberupdatedinfo';
$varTable['MEMBERVIEWEDLOGINFO']	= 'memberviewedloginfo';
$varTable['PAYMENTHISTORYINFO']		= 'paymenthistoryinfo';
$varTable['PAYMENTTRACKING']		= 'paymenttracking';
$varTable['PROFILEMATCHINFO']		= 'profilematchinfo';
$varTable['PROFILEMATCHINFO_NEW']	= 'profilematchinfo_new';
$varTable['REFEREEDETAILS']			= 'refereedetails';
$varTable['REFERENCESETTING']		= 'referencesetting';
$varTable['REQUESTINFOSENT']		= 'requestinfosent';
$varTable['SEARCHSAVEDINFO']		= 'searchsavedinfo';
$varTable['SUCCESSSTORYINFO']		= 'successstoryinfo';
$varTable['REQUESTINFORECEIVED']	= 'requestinforeceived';
$varTable['VOICEMATRIMONYPINNOSERIES'] = 'voicematrimonypinnoseries';
$varTable['VOICEPROFILE']			= 'voiceprofile';
$varTable['PHONEPACKAGEDET']		= 'phonepackagedet';
$varTable['PHONEVIEWLIST']			= 'phoneviewlist';
$varTable['PHOTOINFOLOG']			= 'photoinfolog';
$varTable['CITIAUTH']				= 'citiauth';
$varTable['CITITRACE']				= 'cititrace';
$varTable['PURGEIMG']				= 'purgeimg';
$varTable['PREPAYMENTTRACKINFO']	= 'prepaymenttrackinfo';
$varTable['PREPAYMENTHISTORYINFO']	= 'prepaymenthistoryinfo';
$varTable['MAXMINDPAYMENTCAPTURE']	= 'maxmindpaymentcapture';
$varTable['PAYMENTAUTHORIZATION']	= 'paymentauthorization';
$varTable['ASSUREDCONTACTBEFOREVALIDATION']	= 'assuredcontactbeforevalidation';
$varTable['ASSUREDCONTACT']	= 'assuredcontact';
$varTable['ASSUREDCONTACTPINNOSERIES']	= 'assuredcontactpinnoseries';
$varTable['MATCHWATCHSENTDETAILS']	= 'matchwatchsentdetails';

$varTable['ASTROMATCH']				= 'astromatch';
$varTable['ASTROMATCHPACKAGEDET']	= 'astromatchpackagedet';
$varTable['ASTROMATCHPARTNER']		= 'astromatchpartner';
$varTable['BULKHOROSCOPELOG']		= 'bulkhoroscopelog';
$varTable['HOROALLCOUNTRIESCITIES']	= 'horoallcountriescities';
$varTable['HOROCITIES']				= 'horocities';
$varTable['HOROCOUNTRIES']			= 'horocountries';
$varTable['HORODETAILS']			= 'horodetails';
$varTable['HORODISTRICT']			= 'horodistrict';
$varTable['HOROINDIANSTATES']		= 'horoindianstates';
$varTable['HORONRISTATES']			= 'horonristates';

//Franchisee Registration Info Table Name
$varTable['FRANCHISEE'] = 'franchisee';

//Franchisee Credit Balance Info Table Name
$varTable['FRANCHISEEPAYMENTS']='franchiseepayments';

//USER PLAN TABLES
$varTable['CHATLOGINFO']		= 'chat_initiated_log';
$varTable['ICBLOCKED']			= 'icblocked';
$varTable['ICBUDDY']			= 'icbuddy';
$varTable['ICPENDING']			= 'icpending';
$varTable['ICSTATUS']			= 'icstatus';

// TME - Doorstep
$varDbInfo['EPRDATABASE']		= 'collectioninterface';
$varTable['EASYPAYINFO']		= 'easypay_info';

//PAYMENT ASSISTANCE
$varPaymentAssistanceDbInfo['USERNAME']	= 'User4Cbs';
$varPaymentAssistanceDbInfo['PASSWORD']	= "3rmMWua4";
$varPaymentAssistanceDbInfo['DATABASE']	= "cbssupportiface";

$varTable['PAYMENTOPTIONS']					= 'paymentoptions';
$varTable['PAYMENTOPTIONSFOLLOWUPDETAILS']	= 'paymentoptionsfollowupdetails';
$varTable['OFFERCODEINFO']					= 'offercodeinfo';
$varTable['DOORSTEPPAYMENT']				= 'doorsteppayment';

//cbstminterface table
$varTable['PROFILEDETAILS']			= 'cbstmprofiledetails';

//RM INTERFACE TABLES
$TABLE['MEMBERCONTACTINFOBKUP'] = 'memberContactInfobkup';
$TABLE['MEMBERCONTACTINFOBKUPARCHIVE'] = 'memberContactInfobkuparchive';
$TABLE['MEMPARTNERPREF'] = 'mempartnerpref';
$TABLE['RMLOGININFO'] = 'rmlogininfo';
$TABLE['RMMEMBERINFO'] = 'rmmemberinfo';
$TABLE['RMMAIL'] = 'rmmail';
$TABLE['MEMBERCONTACTINFOBKUP'] = 'memberContactInfobkup';
$TABLE['RMVIEWPHONELOG'] = 'rmviewphonelog';
$TABLE['RMMEMBERLOG'] = 'rmmemberlogininfo';		      
$TABLE['RMMATRIUSERCONTACT'] = 'rmmatriusercontact';
$TABLE['RMMEMBERINFOBKUP'] = 'rmmemberinfobkup';
?>