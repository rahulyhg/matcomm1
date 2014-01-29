<?php
/*
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';

include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/domainlist.cil14');
//include_once($varRootBasePath.'/conf/paymentassistance.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
*/
//echo "Offline update ".$varRootBasePath;


//print_r($_REQUEST);

if($_REQUEST['PaymentCategorynew']!='' && ($_REQUEST['disPre']!='' || $_REQUEST['nextOffer']!='' || $_REQUEST['assured']!='' || $_REQUEST['ExtraPhNo']!='')) {
//include_once("/home/office/cc/www/bmconfig/ccconf.cil14");
#post values from query1.php
	$expiryDatetrm = trim($_REQUEST['expdate']);
	$telecallerexpdate = $expiryDatetrm." 23:59:59";
	$matriid = $_REQUEST['MatriId'];
	if($matriid == "")
		$matriid = $_REQUEST['matriidpost'];
	$matriId = $_REQUEST['matriidpost'];
	$caste = $_REQUEST['Caste'];
//	$MEMBERNAME = $_REQUEST['memName'];
//	$MATRIID=$_REQUEST['MatriId'];
	$omm=$OfferRs['OmmParticipation'];
	$offercode=$_REQUEST['OfferCode'];
	$offercategory=$_REQUEST['offercateid'];
	$discount=$_REQUEST['disPre'];
	$country=$_REQUEST['country'];

 
//$senderdomaininfo = getDomainInfo(1,$_POST['MatriId']);
//$senderdomainname = strtolower($senderdomaininfo['domainnameshort']);
//$TABLE['DOMAINOFFERCODE'] = $senderdomainname.$TABLE['OFFERCODE'];
//$TABLE['DOMAINOFFERCODEARCHIVE'] = $senderdomainname.$TABLE['OFFERCODEARCHIVE'];
//$TABLE['DOMAINMATRIMONYPROFILEE'] = $senderdomainname.$TABLE['MATRIMONYPROFILE'];
//$dbmaster = new db();
//$dbmaster->dbConnById(2,$_POST['MatriId'],'M',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['BMOFFER']);


$selPCat = explode(",",$_POST['PaymentCategorynew']);


$DiscountPercentageUpdatedOffer = getsplitvalues($_REQUEST['DiscountPercentage'],$selPCat[1]);
$OfferOfflineMaxDiscountUpdatedOffer = getsplitvalues($_REQUEST['OfferOfflineMaxDiscount'],$selPCat[1]);
$AssuredGiftUpdatedOffer = getsplitvalues($_REQUEST['AssuredGift'],$selPCat[1]);
$NextLevelUpdatedOffer = getsplitvalues($_REQUEST['NextLevelOffer'],$selPCat[1]);
$ExPhNoUpdatedOffer = getsplitvalues($_POST['ExtraPhoneNo'],$selPCat[1]);

if(isset($ExPhNoUpdatedOffer)){
	if($_POST['exPhNo']!=''){
		$rep_ExPhOffer = str_replace($ExPhNoUpdatedOffer,'',$_POST['ExtraPhoneNo']);
		$updated_ExPhNoOffer = $ExPhNoUpdatedOffer;
		if($ExPhNoUpdatedOffer != $_POST['ExtraPhoneNo']){$updated_ExPhNoOffer.="|".$rep_ExPhOffer;}
		$updated_ExPhNoOffer = str_replace('||','|',$updated_ExPhNoOffer);
		$updated_ExPhNoOffer = removeendtit($updated_ExPhNoOffer);
		$exPhoneNo = $updated_ExPhNoOffer;
	}else {$exPhoneNo='';}
}

if(isset($NextLevelUpdatedOffer)){	
	if($_REQUEST['nextLvlOff']!=''){
		$rep_NextUOffer=str_replace($NextLevelUpdatedOffer,'',$_REQUEST['NextLevelOffer']);
		$updated_NextUOffer=$NextLevelUpdatedOffer;
		if($NextLevelUpdatedOffer!=$_REQUEST['NextLevelOffer']){$updated_NextUOffer.="|".$rep_NextUOffer;}
		$updated_NextUOffer=str_replace('||','|',$updated_NextUOffer);
		$updated_NextUOffer=removeendtit($updated_NextUOffer);
		$nextoffer=$updated_NextUOffer;
	}else {$nextoffer='';}
}

if(isset($DiscountPercentageUpdatedOffer)){	
	if($_REQUEST['disPre']!='' ) {
		$rep_DicPrenUOffer=str_replace($DiscountPercentageUpdatedOffer,'',$_REQUEST['DiscountPercentage']);
		$updated_DicPrenUOffer=alterPos($DiscountPercentageUpdatedOffer,$_REQUEST['disPre']);
		if($rep_DicPrenUOffer!=$_REQUEST['DiscountPercentage']){$updated_DicPrenUOffer.="|".$rep_DicPrenUOffer;}
		$updated_DicPrenUOffer=str_replace('||','|',$updated_DicPrenUOffer);
		$updated_DicPrenUOffer=removeendtit($updated_DicPrenUOffer);

		$discountunedit=finalvalue($updated_DicPrenUOffer);
		$discountall=removeendtit($discountunedit);
		$menmberdis=$discountall;
	} else {	
	$menmberdis='';
	}
}


if(isset($AssuredGiftUpdatedOffer)){	
	if($_REQUEST['assured']!=''){
		$assureduGift=str_replace($AssuredGiftUpdatedOffer,'',$_REQUEST['AssuredGift']);
		$updated_assureduGift=$assureduGift;
		if(!is_array($_REQUEST['assured'])){
			$alterPos=str_replace($selPCat[1]."~",'',$AssuredGiftUpdatedOffer);
			$alterPos=str_replace($_REQUEST['assured'],'',$alterPos);
			$alterPos=str_replace($_REQUEST["AssuredGiftCond"],'',$alterPos);	
			$origiPosit=$selPCat[1]."~".$_REQUEST['assured'].$_REQUEST["AssuredGiftCond"].$alterPos;
			$updated_assureduGift=$origiPosit;
		}
		else{
		$updated_assureduGift=$AssuredGiftUpdatedOffer;
		}

		if($assureduGift!=$_REQUEST['AssuredGift']){
			$updated_assureduGift.="|".$assureduGift;
		}
		$updated_assureduGift=str_replace('||','|',$updated_assureduGift);
		$updated_assureduGift=removeendtit($updated_assureduGift);
		$asugift=$updated_assureduGift;
	}else{
	$asugift='';
	}
}

//$querys=$offerstend.'<br>';
//Insert Offercodeinfo
	$argFields = array('MatriId','OfferCategoryId','OfferAvailedStatus','OfferAvailedOn','OfferCode','OfferStartDate','OfferEndDate','OfferSource','MemberExtraPhoneNumbers','MemberDiscountPercentage','MemberDiscountINRFlatRate','MemberDiscountUSDFlatRate','MemberDiscountEUROFlatRate','MemberDiscountAEDFlatRate','MemberDiscountGBPFlatRate','MemberAssuredGift','AssuredGiftSelected','MemberNextLevelOffer','DateUpdated','OmmParticipation');
//	$argFieldsValue = array("'".$matriId."'","'".$offercategory."'","'0'","'0000-00-00  00:00:00'","'".$offercode."'","'now()'","'".$telecallerexpdate."'","'6'","'".$exPhoneNo."'","'".$DiscountPercentage."'","''","''","''","''","''","'".$asugift."'","''","'".$nextoffer."'","'now()'","'0'");

		$argFieldsValue = array("'".$matriId."'","'".$offercategory."'","'0'","'0000-00-00  00:00:00'","'".$offercode."'","'".$_REQUEST[fromdate]."'","'".$telecallerexpdate."'","'6'","'".$exPhoneNo."'","'".$menmberdis."'","''","''","''","''","''","'".$asugift."'","''","'".$nextoffer."'","now()","'0'");

//echo "<br> OFfercode info - ".$varTable['OFFERCODEINFO'];
	$numInserted = $objMasterMatri -> insertOnDuplicate($varTable['OFFERCODEINFO'], $argFields, $argFieldsValue,'MatriId');
	if($objMasterMatri -> clsErrorCode == "INSERT_ERR")
	{
		echo "database error insertion";
		exit;
	}
// Update memberinfo
$argFields = array('OfferAvailable','OfferCategoryId');
$argFieldsValues = array("'1'","'1'");

$argCondition = " MatriId = '".$matriid."'";
//Memcache insert 
//$numUpdated = $objMasterMatri -> update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
$numUpdated = $objMasterMatri -> update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);
if($objMasterMatri -> clsErrorCode == "UPDATE_ERR")
{
	echo "database error updation";
	exit;
}
$wsmemClient = new WSMemcacheClient;

$rs = $wsmemClient->processRequest($matriId, $varTable['MEMBERINFO']);

/*
#insert offercodeinfo
$offercodeinsert="insert into ".$DBNAME['BMOFFER'].".".$TABLE['DOMAINOFFERCODE']." (MatriId,OfferCategoryId,OfferAvailedStatus,OfferAvailedOn,OfferCode,OfferStartDate,OfferEndDate,OfferSource,MemberExtraPhoneNumbers,MemberDiscountPercentage,MemberDiscountINRFlatRate,MemberDiscountUSDFlatRate,MemberDiscountEUROFlatRate,MemberDiscountAEDFlatRate,MemberDiscountGBPFlatRate,MemberAssuredGift,AssuredGiftSelected,MemberNextLevelOffer,DateUpdated,OmmParticipation) value('".$matriid."','".$offercategory."',0,'0000-00-00  00:00:00','".$offercode."',now(),'".$telecallerexpdate."',6,'$exPhoneNo','".$menmberdis."','','','','','','".$asugift."','','".$nextoffer."',now(),0) ON DUPLICATE KEY UPDATE  OfferCategoryId='".$offercategory."',OfferAvailedStatus=0,OfferAvailedOn='0000-00-00 00:00:00',OfferCode='".$offercode."',OfferStartDate=now(),OfferEndDate='".$telecallerexpdate."',OfferSource=6,MemberExtraPhoneNumbers='$exPhoneNo',MemberDiscountPercentage='".$menmberdis."',MemberDiscountINRFlatRate='',MemberDiscountUSDFlatRate='',MemberDiscountEUROFlatRate='',MemberDiscountAEDFlatRate='',MemberDiscountGBPFlatRate='',MemberAssuredGift='".$asugift."',AssuredGiftSelected='',MemberNextLevelOffer='".$nextoffer."',DateUpdated=now(),OmmParticipation=0";
$resultinsert=$dbmaster->insert($offercodeinsert);
$querys.=$offercodeinsert.'<br>';

#update matrimonyms
$updateMs="update ".$DBNAME['MATRIMONYMS'].".".$TABLE['DOMAINMATRIMONYPROFILEE']." set OfferAvailable=1,OfferCategoryId=753,DateUpdated=now() where matriid='".$matriid."'";
$dbmaster->update($updateMs,$mconnect);
$querys.=$updateMs.'<br>';

#update telemarketing db
$updateTm="update ".$DBNAME['TELEMARKETING'].".".$TABLE['TELEMARKETING']." set OfferAvailable=1,OfferCategoryId=753 where matriid='".$matriid."'";
$dbsupport14->update($updateTm);
$querys.=$updateTm.'<br>';

#insert in new table in telemarketing
$insertTm="insert into ".$DBNAME['TELEMARKETING'].".".$TABLE['TMOFFERCODEINFO']." (MatriId,OfferCategoryId,OfferCode,OfferSource,MemberExtraPhoneNumbers,MemberDiscountPercentage, MemberAssuredGift,MemberNextLevelOffer,DateUpdated)values('".$_REQUEST['MatriId']."','".$_REQUEST['Offercatid']."','".$_REQUEST['OfferCode']."','6','$exPhoneNo','$discountall','$updated_assureduGift','$updated_NextUOffer',now()) ON DUPLICATE KEY UPDATE  OfferCategoryId='".$_REQUEST['Offercatid']."',OfferCode='".$_REQUEST['OfferCode']."',OfferSource='6',MemberExtraPhoneNumbers='$exPhoneNo',MemberDiscountPercentage='$discountall', MemberAssuredGift='$updated_assureduGift',MemberNextLevelOffer='$updated_NextUOffer',DateUpdated=now()";
$dbsupport14->insert($insertTm);

*/
//echo $querys.=$insertTm.'<br>';
#mail('suresh.a@bharatmatrimony.com','offlineupdate query',$querys);
}	
/***************** mail the queries************************************/
$fixquery="insert table->".$offercodeinsert."<br>updateMS".$updateMs."<br>update telemarketing".$updateTm."<br>INSERT tm".$insertTm;
#mail('suresh.a@bharatmatrimony.com','query from supportofflineUpdate.php',$fixquery);
/********************************************************************************/
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