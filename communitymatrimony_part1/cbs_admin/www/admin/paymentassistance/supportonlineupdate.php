<?php
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';

include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/domainlist.cil14');
//include_once($varRootBasePath.'/conf/paymentassistance.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');

global $adminUserName;

if($adminUserName == "")
	header("Location: ../index.php?act=login");
/*
//OBJECT DECLARTION
$objMaster	= new DB;
$objSlave	= new DB;
$objSlaveMatri	= new DB;

$objSlaveMatri -> dbConnect('S',$varDbInfo['DATABASE']);

global $varDBUserName, $varDBPassword;
$varDBUserName = $varPaymentAssistanceDbInfo['USERNAME'];
$varDBPassword = $varPaymentAssistanceDbInfo['PASSWORD'];


//DB CONNECTION
$objSlave -> dbConnect('S',$varPaymentAssistanceDbInfo['DATABASE']);
$objMaster -> dbConnect('M',$varPaymentAssistanceDbInfo['DATABASE']);
*/
//print_r($_REQUEST);
if($_POST['PaymentCategorynew']!='' && ($_POST['disPre']!='' || $_POST['nextOffer']!='' || $_POST['assured']!=''  || $_POST['ExtraPhNo']!='') ){
//include_once("/home/office/cc/www/bmconfig/ccconf.cil14");

//$senderdomaininfo = getDomainInfo(1,$_POST['MatriId']);
//$senderdomainname = strtolower($senderdomaininfo['domainnameshort']);
$TABLE['DOMAINOFFERCODE'] = $senderdomainname.$TABLE['OFFERCODE'];
$TABLE['DOMAINOFFERCODEARCHIVE'] = $senderdomainname.$TABLE['OFFERCODEARCHIVE'];
//$dbmaster = new db();
//$dbmaster->dbConnById(2,$_POST['MatriId'],'M',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['BMOFFER']);

	$selPCat=explode(",",$_POST['PaymentCategorynew']);

 	$DiscountPercentageUpdatedOffer=getsplitvalues($_POST['DiscountPercentage'],$selPCat[1]);
	$OfferOfflineMaxDiscountUpdatedOffer=getsplitvalues($_POST['OfferOfflineMaxDiscount'],$selPCat[1]);
	$AssuredGiftUpdatedOffer=getsplitvalues($_POST['AssuredGift'],$selPCat[1]);
	$NextLevelUpdatedOffer=getsplitvalues($_POST['NextLevelOffer'],$selPCat[1]);
	$ExPhNoUpdatedOffer=getsplitvalues($_POST['ExtraPhoneNo'],$selPCat[1]);


	$up_st="";//build update query
	// extra ph no
	if(isset($ExPhNoUpdatedOffer)){	
	if($_POST['exPhNo']!=''){
	$rep_ExPhOffer=str_replace($ExPhNoUpdatedOffer,'',$_POST['ExtraPhoneNo']);
	$updated_ExPhNoOffer=$ExPhNoUpdatedOffer;
	if($ExPhNoUpdatedOffer!=$_POST['ExtraPhoneNo']){$updated_ExPhNoOffer.="|".$rep_ExPhOffer;}
	$updated_ExPhNoOffer=str_replace('||','|',$updated_ExPhNoOffer);
	$updated_ExPhNoOffer=removeendtit($updated_ExPhNoOffer);
	$up_st.=",MemberExtraPhoneNumbers='$updated_ExPhNoOffer'";
	}else {$up_st.=",MemberExtraPhoneNumbers=''";}
	}
//next level	
	if(isset($NextLevelUpdatedOffer)){	
		if($_POST['nextLvlOff']!=''){
			$rep_NextUOffer=str_replace($NextLevelUpdatedOffer,'',$_POST['NextLevelOffer']);
			$updated_NextUOffer=$NextLevelUpdatedOffer;
			if($NextLevelUpdatedOffer!=$_POST['NextLevelOffer']){$updated_NextUOffer.="|".$rep_NextUOffer;}
			$updated_NextUOffer=str_replace('||','|',$updated_NextUOffer);
			$updated_NextUOffer=removeendtit($updated_NextUOffer);
			$up_st.=",MemberNextLevelOffer='$updated_NextUOffer'";
		}else {$up_st.=",MemberNextLevelOffer=''";}
	}
	
//&& $_POST['assured']==''
	if(isset($DiscountPercentageUpdatedOffer)){	
		if($_POST['disPre']!='' ) {

			$rep_DicPrenUOffer=str_replace($DiscountPercentageUpdatedOffer,'',$_POST['DiscountPercentage']);
			$updated_DicPrenUOffer=alterPos($DiscountPercentageUpdatedOffer,$_POST['disPre']);
			if($rep_DicPrenUOffer!=$_POST['DiscountPercentage']){$updated_DicPrenUOffer.="|".$rep_DicPrenUOffer;}
			$updated_DicPrenUOffer=str_replace('||','|',$updated_DicPrenUOffer);
			$updated_DicPrenUOffer=removeendtit($updated_DicPrenUOffer);

			$discountunedit=finalvalue($updated_DicPrenUOffer);
			$discountall=removeendtit($discountunedit);
			$up_st.=",MemberDiscountPercentage='".$discountall."'";

		} else {	
			$up_st.=",MemberDiscountPercentage=''";
		}
	} 
	if(isset($AssuredGiftUpdatedOffer)){	
		if($_POST['assured']!=''){
	$assureduGift=str_replace($AssuredGiftUpdatedOffer,'',$_POST['AssuredGift']);
	$updated_assureduGift=$assureduGift;
	if(!is_array($_POST['assured'])){
	$alterPos=str_replace($selPCat[1]."~",'',$AssuredGiftUpdatedOffer);
	$alterPos=str_replace($_POST['assured'],'',$alterPos);
	$alterPos=str_replace($_POST["AssuredGiftCond"],'',$alterPos);	
	$origiPosit=$selPCat[1]."~".$_POST['assured'].$_POST["AssuredGiftCond"].$alterPos;
 	$updated_assureduGift=$origiPosit;
	}
	else{
	$updated_assureduGift=$AssuredGiftUpdatedOffer;
	}
	if($assureduGift!=$_POST['AssuredGift']){
	$updated_assureduGift.="|".$assureduGift;
	}
	$updated_assureduGift=str_replace('||','|',$updated_assureduGift);
	$updated_assureduGift=removeendtit($updated_assureduGift);
	$up_st.=",MemberAssuredGift='$updated_assureduGift'";
	}else{
	$up_st.=",MemberAssuredGift=''";
	}
	}
//echo "Query bit ".$up_st;
	//original value copied to archieve
/*
$query_select="select * from ".$DBNAME['BMOFFER'].".".$TABLE['DOMAINOFFERCODE']." where MatriId='".$_POST['MatriId']."'";
$dbmaster->select($query_select);
$OfferRs=$dbmaster->fetchArray();
	
$insert_offer_archive="insert into  ".$DBNAME['BMOFFER'].".".$TABLE['DOMAINOFFERCODEARCHIVE']." (MatriId,OfferCategoryId,OfferCode,OfferStartDate,OfferEndDate,OfferAvailedStatus,OfferAvailedOn,OfferSource,MemberExtraPhoneNumbers,MemberDiscountPercentage,MemberDiscountINRFlatRate,MemberDiscountUSDFlatRate,MemberDiscountEUROFlatRate,MemberDiscountAEDFlatRate,MemberDiscountGBPFlatRate,MemberAssuredGift,MemberNextLevelOffer,DateUpdated) values ('".$OfferRs['MatriId']."','".$OfferRs['OfferCategoryId']."','".$OfferRs['OfferCode']."','".$OfferRs['OfferStartDate']."','".$OfferRs['OfferEndDate']."','".$OfferRs['OfferAvailedStatus']."','".$OfferRs['OfferAvailedOn']."','".$OfferRs['OfferSource']."','".$OfferRs['MemberExtraPhoneNumbers']."','".$OfferRs['MemberDiscountPercentage']."','".$OfferRs['MemberDiscountINRFlatRate']."','".$OfferRs['MemberDiscountUSDFlatRate']."','".$OfferRs['MemberDiscountEUROFlatRate']."','".$OfferRs['MemberDiscountAEDFlatRate']."','".$OfferRs['MemberDiscountGBPFlatRate']."','".$OfferRs['MemberAssuredGift']."','".$OfferRs['MemberNextLevelOffer']."','".$OfferRs['DateUpdated']."')  ON DUPLICATE KEY UPDATE OfferCategoryId='".$OfferRs['OfferCategoryId']."',OfferCode='".$OfferRs['OfferCode']."',OfferStartDate='".$OfferRs['OfferStartDate']."',OfferEndDate='".$OfferRs['OfferEndDate']."',OfferAvailedStatus='".$OfferRs['OfferAvailedStatus']."',OfferAvailedOn='".$OfferRs['OfferAvailedOn']."',OfferSource='".$OfferRs['OfferSource']."',MemberExtraPhoneNumbers='".$OfferRs['MemberExtraPhoneNumbers']."',MemberDiscountPercentage='".$OfferRs['MemberDiscountPercentage']."',MemberDiscountINRFlatRate='".$OfferRs['MemberDiscountINRFlatRate']."',MemberDiscountUSDFlatRate='".$OfferRs['MemberDiscountUSDFlatRate']."',MemberDiscountEUROFlatRate='".$OfferRs['MemberDiscountEUROFlatRate']."',MemberDiscountAEDFlatRate='".$OfferRs['MemberDiscountAEDFlatRate']."',MemberDiscountGBPFlatRate='".$OfferRs['MemberDiscountGBPFlatRate']."',MemberAssuredGift='".$OfferRs['MemberAssuredGift']."',MemberNextLevelOffer='".$OfferRs['MemberNextLevelOffer']."',DateUpdated='".$OfferRs['DateUpdated']."'"; 
//OfferAvailedStatus=1 $up_st
$dbmaster->insert($insert_offer_archive);
*/
/*
$query_master="update ".$DBNAME['BMOFFER'].".".$TABLE['DOMAINOFFERCODE']." set DateUpdated=now(),OfferSource=6 $up_st where MatriId='".$_POST['MatriId']."' "; 
$dbmaster->update($query_master);
*/
//insert in new table in telemarketing
/*
$insert="insert into ".$DBNAME['TELEMARKETING'].".".$TABLE['TMOFFERCODEINFO']." (MatriId,OfferCategoryId,OfferCode,OfferSource,MemberExtraPhoneNumbers,MemberDiscountPercentage, MemberAssuredGift,MemberNextLevelOffer,DateUpdated) values('".$_POST['MatriId']."','".$_POST['Offercatid']."','".$_POST['OfferCode']."','6','$updated_ExPhNoOffer','$discountall','$updated_assureduGift','$updated_NextUOffer',now()) ON DUPLICATE KEY UPDATE  OfferCategoryId='".$_POST['Offercatid']."',OfferCode='".$_POST['OfferCode']."',OfferSource='6',MemberExtraPhoneNumbers='".$updated_NextUOffer."',MemberDiscountPercentage='$discountall', MemberAssuredGift='$updated_assureduGift',MemberNextLevelOffer='$updated_NextUOffer',DateUpdated=now() ";
$result=$dbsupport14->insert($insert);
*/
//echo "online";
$argFields = array('MatriId','OfferCategoryId','OfferCode','OfferStartDate','OfferEndDate','OfferAvailedStatus','OfferAvailedOn','OfferSource','MemberExtraPhoneNumbers','MemberDiscountPercentage','MemberAssuredGift','MemberNextLevelOffer','DateUpdated','AssuredGiftSelected');
	//$argFieldsValue = array("'".$_POST['matriidpost']."'","'".$_POST['Offercatid']."'","'".$_POST['OfferCode']."'","'".$_REQUEST['fromdate']." 00:00:00'","'".$_REQUEST['expdate']." 00:00:00'","'0000-00-00 00:00:00'","'0'","'6'","'".$updated_ExPhNoOffer."'","'".$discountall."'","'".$updated_assureduGift."'","'".$updated_NextUOffer."'","'now()'");

	$argFieldsValue = array("'".$_POST['matriidpost']."'","'".$_POST['Offercatid']."'","'".$_POST['OfferCode']."'","'".$_REQUEST['fromdate']." 00:00:00'","'".$_REQUEST['expdate']." 00:00:00'","'0'","'0000-00-00 00:00:00'","'6'","'".$updated_ExPhNoOffer."'","'".$discountall."'","'".$updated_assureduGift."'","'".$updated_NextUOffer."'","now()","'".$assured."'");

//echo "<br> OFfercode info - ".$varTable['OFFERCODEINFO'];
	$numInserted = $objMasterMatri -> insertOnDuplicate($varTable['OFFERCODEINFO'], $argFields, $argFieldsValue,'MatriId');
	if($objMaster -> clsErrorCode == "INSERT_ERR")
	{
		echo "database error insertion on";
		exit;
	}
// Update memberinfo
$argFields = array('OfferAvailable','OfferCategoryId');
$argFieldsValues = array("'1'","'1'");

$argCondition = " MatriId = '".$_POST['matriidpost']."'";
$numUpdated = $objMasterMatri -> update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);
if($objMaster -> clsErrorCode == "UPDATE_ERR")
{
	echo "database error updation";
	exit;
}

$newMss=$insert_offer_archive."\n <BR>".$query_master."\n <BR>".$insert; 
mail('kirubasankar.a@bharatmatrimony.com','offlineupdate',$newMss);
//mail('asureshmca@gmail.com','TM entry_fup1_update',$newMss);
$caste=$_POST['Caste'];
$MEMBERNAME=$_POST['memName'];
$MATRIID=$_POST['MatriId'];
$omm=$OfferRs['OmmParticipation'];
$offercode=$_POST['OfferCode'];
$discount=$_POST['disPre'];
$country=$_POST['country'];

/*include_once("mailfunction.php");
include_once("/home/office/cc/www/mailfunction.php");
mail_for_modified_profile($country,$emailid,$MEMBERNAME,$MATRIID,$lang,$discount,$NextLevelUpdatedOffer,$updated_assureduGift,$offercode,$caste,$omm);
///SMS*/
$MobileNo=$_POST['MobileNo'];
//if($country==98 && $MobileNo!='' && strlen($MobileNo)>9){//only to Indian membes sms is available
//include_once("smstomobile.php");
	//sms($MATRIID,$discount,$NextLevelUpdatedOffer,$updated_assureduGift,$MobileNo);
//}
//mysql_close($mconnect);
}	

//function added by sankar
function getsplitvalues($Override,$selValue) { 
$overArr=explode("|",$Override);
	 for($i=0;$i<count($overArr);$i++)	 {   
			$overArr1=explode("~",$overArr[$i]);
			 if($overArr1[0]==$selValue){
					$overArr2=$overArr[$i];
				}//end if 
		  }//end for
return $overArr2;
}
function removeendtit($endtiltenew) {
$end=strlen($endtiltenew);
$endstr=substr($endtiltenew, -1, 1);
if($endstr=="|") {
return substr($endtiltenew, 0, $end-1);
}
else {  return $endtiltenew; } 
}

function alterPos($orginal,$alterVal){
$result=$orginal;
$orgArr=explode("~",$orginal);
if($orgArr[1]!==$alterVal)
{
$result=$orgArr[0].'~'.$alterVal;
}

return $result;
}
function finalvalue($value){
	$packageval=explode("|",$value);
	$exp=explode("~",$packageval[0]);
	$upValue=$exp[1];
foreach($packageval as $packkey) {
	$expval=explode('~',$packkey);
	$finaldisc.=$expval[0]."~".$upValue."|";
}
return $finaldisc;
}
?>