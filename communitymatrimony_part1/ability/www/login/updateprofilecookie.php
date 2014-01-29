<?php
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath."/lib/clsLogin.php");
//OBJECT DECLARTION
$objSlaveDB		= new Login;
$objMasterDB1	= new Login;
$varMatriId		= $varGetCookieInfo['MATRIID'];
$varPhotoName	= $varGetCookieInfo['PHOTO'];
$varDomainName	= $confValues["DOMAINNAME"];
$objSlaveDB->dbConnect('S',$varDbInfo['DATABASE']);
$objMasterDB1->dbConnect('M',$varDbInfo['DATABASE']);
$varCondition	= " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
$varFields			= array('Publish','Paid_Status','Expiry_Date','Family_Set_Status','Interest_Set_Status','Partner_Set_Status','Photo_Set_Status','Video_Set_Status','Voice_Available','Reference_Set_Status','Phone_Verified','Last_Payment','Number_Of_Payments','(Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment))) as ValidDaysLeft');
$varExecute			= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
$varSelectLoginInfo= mysql_fetch_assoc($varExecute);
$varPublish				= $varSelectLoginInfo['Publish'];
$varPaidStatus			= $varSelectLoginInfo['Paid_Status'];
$varFamilySetStatus		= $varSelectLoginInfo['Family_Set_Status'];
$varHobbiesAvailable	= $varSelectLoginInfo['Interest_Set_Status'];
$varPartnerSetStatus	= $varSelectLoginInfo['Partner_Set_Status'];
$varPhotoSetStatus		= $varSelectLoginInfo['Photo_Set_Status'];
$varVideoSetStatus		= $varSelectLoginInfo['Video_Set_Status'];
$varVoiceAvailable		= $varSelectLoginInfo['Voice_Available'];
$varReferenceSetStatus	= $varSelectLoginInfo['Reference_Set_Status'];
$varPhoneVerified		= $varSelectLoginInfo['Phone_Verified'];
$varPaidDate			= $varSelectLoginInfo['Last_Payment'];
$varNumberOfPayments	= $varSelectLoginInfo['Number_Of_Payments'];
$varExpiryDate			= $varSelectLoginInfo['Expiry_Date'];
$varValidDaysLeft		= $varSelectLoginInfo['ValidDaysLeft'];

$varFields				= array('Product_Id');
$varExecute				= $objSlaveDB->select($varTable['PAYMENTHISTORYINFO'], $varFields, $varCondition,0);
$varProductInfo			= mysql_fetch_assoc($varExecute);
$varProductId			= $varProductInfo['Product_Id'];


if ($_REQUEST['photo']==1) {
	$argFields			= array('Normal_Photo1','Photo_Status1');
	$varExecute			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $argFields, $varCondition,0);
	$varPhotoInfo		= mysql_fetch_assoc($varExecute);
	$varPhotoName		= $varPhotoInfo["Normal_Photo1"].'~'.$varPhotoInfo["Photo_Status1"];

}//if
//SELECT LIST COUNT
$varBookMarkCnt		= $objSlaveDB->numOfRecords($varTable['BOOKMARKINFO'], 'MatriId', $varCondition);
//SELECT PHONE COUNT
$argCondition	= " WHERE Opposite_MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
$varPhoneCnt		= $objSlaveDB->numOfRecords($varTable['PHONEVIEWLIST'], 'MatriId', $argCondition);
$varProfileValue	= $varPublish.'^|'.$varPaidStatus.'^|'.urlencode($varExpiryDate).'^|'.$varPhotoName.'^|'.$varFamilySetStatus.'^|'.$varHobbiesAvailable.'^|'.$varPartnerSetStatus.'^|'.$varPhotoSetStatus.'^|'.$varVideoSetStatus.'^|'.$varVoiceAvailable.'^|'.$varReferenceSetStatus.'^|'.$varBookMarkCnt.'^|'.$varPhoneCnt.'^|'.$varPhoneVerified.'^|'.$varProductId.'^|'.urlencode($varPaidDate).'^|'.$varNumberOfPayments.'^|'.$varValidDaysLeft;
header("set-cookie:profileInfo=$varProfileValue;path=/;domain=$varDomainName");


//CUMULATIVE INTEREST COUNT RESET PURPOSE IF PAID MEMBER
if($varPaidStatus=='1'){

	$varCondition	= " MatriId=".$objMasterDB1->doEscapeString($varMatriId,$objMasterDB1);
	$varFields		= array('CumulativeAcceptSentInterest','CumulativeAcceptReceivedInterest');
	$varFiledvalues	= array('0','0');
	$objMasterDB1->update($varTable['MEMBERSTATISTICS'], $varFields, $varFiledvalues, $varCondition);
}


$objSlaveDB->dbClose(); 
?>