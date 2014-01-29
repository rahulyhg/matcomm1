<?php
# Author	:	A.Kirubasankar
# Date		:	12/01/2010
# Desc		:	this cron is used to trigger mail and SMS on daily basis for offer going to expire current day.
# Filename	:	sendmailandsms.php


$varRootBasePath = '/home/product/community/ability';

/* Includes */
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/domainlist.inc');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/www/admin/paymentassistance/lvars.php');

/* DB Object Declaration */
$objCommMaster 	= new DB;
$objCommSlave	= new DB;

/* Connection vars for communitymatrimony DB */
$varDBUserName	= $varDbInfo['USERNAME'];
$varDBPassword	= $varDbInfo['PASSWORD'];

/* Connecting cbssupportiface db */
$objCommMaster	->	dbConnect('M',$varDbInfo['DATABASE']);

/* Connecting communitymatrimony db */
$objCommSlave	->	dbConnect('S',$varDbInfo['DATABASE']);


# make db link if not avilable # --------------------------------------------------------------------

$mcount=0;
$j=0;
$commMailArray = array();


function cbscurl($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}


$curdate=date("Y-m-d");
$smstoSuresh = 0;

$bmOfferArgs = array('MatriId','MemberDiscountPercentage','MemberExtraPhoneNumbers','MemberNextLevelOffer','OfferEndDate','MemberAssuredGift','MemberDiscountINRFlatRate','MemberDiscountAEDFlatRate');
$bmOfferCond = " WHERE OfferSource=1 AND OfferAvailedStatus=0  AND OfferEndDate>='".$curdate." 00:00:00' and OfferEndDate<='".$curdate." 23:59:59'";

$bmOfferResult = $objCommSlave -> select($varTable['OFFERCODEINFO'],$bmOfferArgs,$bmOfferCond,0);
while($resRow = mysql_fetch_assoc($bmOfferResult))
{
	$setBcc=1;
	$membername='';
	$TelecallerName='';
	$mobile='';
	$country='';
	$content='';
	$display='';
	$discount_percent='';
	$display_nxt='';
	$display_ph='';
	$display_assur='';
	$smsNo = '';
	$smsph = '';
	$SUB = "";
	$smssent = "";


	if($resRow['MemberDiscountPercentage']!=''){
		$disc_pipe=explode("|",$resRow['MemberDiscountPercentage']);
		$disc_tilde=explode("~",$disc_pipe[0]);
		if($disc_tilde[1]=="0") {
		$discount_percent="";
		} else {
		$discount_percent=$disc_tilde[1] ."% Discount";
		}
	}
	if($resRow['MemberDiscountINRFlatRate']!=''){
		$flat_pipe=explode("|",$resRow['MemberDiscountINRFlatRate']);
		$flat_tilde=explode("~",$flat_pipe[0]);
		if($flat_tilde[1]=="0") {
		$discount_percent="";
		} else {
		$discount_percent= "Rs. ".$flat_tilde[1] ." Discount";
		}
	}
	if($resRow['MemberDiscountAEDFlatRate']!=''){
		$flatAED_pipe=explode("|",$resRow['MemberDiscountAEDFlatRate']);
		$flatAED_tilde=explode("~",$flatAED_pipe[0]);
		if($flatAED_tilde[1]=="0") {
		$discount_percent="";
		} else {
		$discount_percent= "AED ".$flatAED_tilde[1] ." Discount";
		}
	}
	if($resRow['MemberNextLevelOffer']!=''){
		if(($resRow['MemberDiscountPercentage']!='' or $resRow['MemberDiscountINRFlatRate']!='' or $resRow['MemberDiscountAEDFlatRate']!='') and $discount_percent!=''){
			$addNxplus='+';
		}
		else
		{
			$addNxplus='';
		}
		 $display_nxt=$addNxplus.'Next Level upgrade';
	}
	
	if($resRow['MemberExtraPhoneNumbers']!=''){
		if((($resRow['MemberDiscountPercentage']!=''  or $resRow['MemberDiscountINRFlatRate']!='' or $resRow['MemberDiscountAEDFlatRate']!='') and $discount_percent!='') || ($resRow['MemberNextLevelOffer']!='')){
			$addExplus='+';
		}
		else
		{
			$addExplus='';
		}

	$extraph_pipe=explode("|",$resRow['MemberExtraPhoneNumbers']);
	$extraph_tilde=explode("~",$extraph_pipe[0]);
	$phcount=$extraph_tilde[1];
	$display_ph=$addExplus.$phcount.' Extra Phone Numbers';
	}
	if($resRow['MemberAssuredGift']!=''){
		if((($resRow['MemberDiscountPercentage']!='' or $resRow['MemberDiscountINRFlatRate']!='' or $resRow['MemberDiscountAEDFlatRate']!='')and $discount_percent!='') || ($resRow['MemberNextLevelOffer']!='') || ($resRow['MemberExtraPhoneNumbers']!='')){
			$addAsplus='+';
		}
		else
		{
			$addAsplus='';
		}
		$display_assur=$addAsplus.'Assured Gift';
	}
	$display=$discount_percent.$display_nxt.$display_ph.$display_assur;
	
	$expdatetime=explode(" ",$resRow['OfferEndDate']);
	$expdate=explode("-",$expdatetime[0]);			
	$convert_date=mktime(0, 0, 0 ,$expdate[1],$expdate[2],$expdate[0]);
	$display_date=date("F j, Y", $convert_date);

	$emailArgs = array('Email');
	$emailCond = " where MatriId='".$resRow['MatriId']."'";
	$emailRow = $objCommSlave -> select($varTable['MEMBERLOGININFO'],$emailArgs,$emailCond,1);

	$email_row = $emailRow[0];

	$nameArgs = array('Name','Contact_Mobile','Phone_Verified');
	$nameCond = " where MatriId='".$resRow['MatriId']."'";
	$nameRow = $objCommSlave -> select($varTable['MEMBERINFO'],$nameArgs,$nameCond,1);
	$membername = ucfirst($nameRow[0]['Name']);
	/*
	if($nameRow[0]['Phone_Verified'] == "1")
	{
		$assuredNumberArr = array('PhoneNo1','CountryCode');
		$assuredNumberCond = " where MatriId='".$resRow['MatriId']."'";
		$assuredNumberRow = $objCommSlave -> select($varTable['ASSUREDCONTACT'],$assuredNumberArr,$assuredNumberCond,1);

		$smsNo1 = $assuredNumberRow[0]['PhoneNo1'];
		$smsNo2 = explode("~",$smsNo1);
		$country = $assuredNumberRow[0]['CountryCode'];
		if($smsNo1 != "")
		{
			$vall = count($smsNo2) - 1;
			$smsNo = $smsNo2[$vall];
			if($country == "")
				$country = $smsNo2[0];
		}
	}	
	if($smsNo == "")
	{
		$smsNo1 = $nameRow[0]['Contact_Mobile'];
		$smsNo2 = explode("~",$smsNo1);
		if($smsNo1 != "")
		{
			$vall = count($smsNo2) - 1;
			if($country == $smsNo && $country != "")
			{
				$country = $smsNo2[0];
			}
			$smsNo = $smsNo2[$vall];
			if($country == $smsNo)
			{
				$country = "";
			}
		}
	}
	$mobile = $smsNo;
	*/ //SMS part commented
	$rowArgs = array('TelecallerName','TelecallerId','MobileNo');
	$rowCond = " where MatriId='".$resRow['MatriId']."'";
	$row = $objCommSlave -> select($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['PROFILEDETAILS'],$rowArgs,$rowCond,1);

	$TelecallerName=$row[0]['TelecallerName'];
	
	$arrCbsTMLoginDetails = array('CountryCode','AreaCode','PhoneNo','ExtNo','TelecallerName','OfficeId','Email');
	$arrCbsTMLoginCond = "  where TelecallerId='".$row[0]['TelecallerId']."' and Status=4";
	
	$row_user = $objCommSlave -> select($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['CBSTMLOGINDETAILS'],$arrCbsTMLoginDetails,$arrCbsTMLoginCond,1);

	$first3 = substr($resRow['MatriId'],0,3);
	$domainName = $arrPrefixDomainList[$first3];
	$DomainNameOnly=str_replace("matrimony.com",'',$domainName);
	$DomainNameOnly=ucfirst($DomainNameOnly);

	$domainNameFolder = $arrFolderNames[$first3];
	$telecallerphone=$row_user[0]['CountryCode']."-".$row_user[0]['AreaCode'].$row_user[0]['PhoneNo'];
	$telecallerexn=$row_user[0]['ExtNo'];
	$telecallername=ucfirst($row_user[0]['TelecallerName']);
	$emailtm=strtolower($row_user[0]['TelecallerName']);
	$branchName = getBranchId($row_user[0][OfficeId]);
	$brnachsub = substr($branchName,0,3);
	$teleemail = "tme-".$brnachsub."-".$row_user[0]['Email'];
	$teleemail1 = explode("@",$teleemail);
	$teleemail2 = $teleemail1[0]."@communitymatrimony.com";
	$teleemail = strtolower($teleemail2);

	$content=file_get_contents("/home/product/community/ability/bin/paymentassistance/offerexpiremailer.html");
	$content=str_replace("#URLDIRECT#","http://www.".$domainName."/payment/",$content);
	$content=str_replace("#MEMBERNAME#",$membername,$content);
	$content=str_replace("#DOMAIN#",$DomainNameOnly,$content);
	$content=str_replace("#SHOWOFFER#",$display,$content);
	$content=str_replace("#PNO#",$telecallerphone,$content);
	$content=str_replace("#URL#","http://www.".$domainName."/payment/",$content);
	if($telecallerexn==0) {
		$content=str_replace(" Extn.<b>#EXNO#</b>",'',$content);
	} else {
		$content=str_replace("#EXNO#",$telecallerexn,$content);
	}
	$content=str_replace("#EMILID#",$teleemail,$content);
	$content=str_replace("#TELENAME#",$telecallername,$content);
	$content=str_replace("#EXPDATE#",$display_date,$content);

	$SUB="Hurry! Special Offer from ".$DomainNameOnly."Matrimony ends today!";
	$HEADERS  = "MIME-Version: 1.0\n";
	$HEADERS .= "Content-type: text/html; charset=iso-8859-1\n";
	$HEADERS .= "From: ".$DomainNameOnly."Matrimony.com <".$teleemail.">\n";
	$HEADERS .= "Reply-To: ".$DomainNameOnly."matrimony.com <doorstep@".$domainNameFolder."matrimony.com>\n";

	if(!in_array($first3,$commMailArray))
	{
		array_push($commMailArray,$first3);
		$HEADERS .= 'Bcc: suresh.a@bharatmatrimony.com' . "\n";
	}

	$to = $email_row['Email'];
	
	
	#sms
	/*
	$fmobile = MobileValidate($mobile);
	if($fmobile==''){
		$fmobile=0;		
	}
	else if(strlen($fmobile)<10){
		$fmobile=0;
	}
	*/ //SMS part commented
	/* getting Office Id values from BM Server */

	/*
	$curlUrl = "http://wcc.matchintl.com/getdetailsbmtm.php?para=bc&offid=".$row_user[0][OfficeId];
	$branchContactInfo1 = cbscurl($curlUrl);
	$branchContactInfo2 = explode(":&npn&:",$branchContactInfo1);
	$branchContactInfo3 = $branchContactInfo2[1];
	$branchContactInfo = json_decode($branchContactInfo3,true);


	if($fmobile!=0 && $country==91)
	{
		$mcount++;
		$smsph = $branchContactInfo[3]."-".$branchContactInfo[4];

		//$smscontent = "Exclusive Membership Offer on ".$DomainNameOnly."Matrimony ends today. Pay online or call ".$smsph." for payment pick-up - ".$telecallername."";

		$smscontent = "Your ".$DomainNameOnly."Matrimony offer ends today.Pay online or call ".$smsph." for doorstep collection-".$telecallername."";

		echo $msg = urlencode($smscontent);

		if(strlen($msg) > 140)
		{
			$sub1 = "CBS:SMS size exceeds";
			$conteent = "MatriId : ".$resRow['MatriId']." - Office Id : ".$row_user[0][OfficeId]." - SMS : <br>\n ".$msg;
			mail('suresh.a@bharatmatrimony.com',$sub1,$conteent);
		}


		$smsTrackArgs = array('MatriId','SentOn');
		$smsTrackValue = array("'".$resRow['MatriId']."'","now()");

		$objCommMaster -> insert($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['CBSSMSTRACK'], $smsTrackArgs, $smsTrackValue);
		if($objCommMaster -> clsErrorCode == "")
			exec('php /home/product/community/ability/bin/paymentassistance/bmsms.php '.$fmobile.' '.$msg);
	
		if($smstoSuresh == 0)
		{
			$checkMobile = '9962075272';
			exec('php /home/product/community/ability/bin/paymentassistance/bmsms.php '.$checkMobile.' '.$msg);
			$smstoSuresh = 1;
		}
	}
	*/ //SMS part commented

	if($to!='' && $content !=''){
		mail($to,$SUB,$content,$HEADERS,$MAILER_RETURNPATH);
	$j++;
	}
	$setBcc=2;
}

$mailmess="Mail alert send for offer expiry today on ". $curdate." =".$j;
//$smsmess="SMS alert send from telemarketing for offer expiry today on ".$curdate." =".$mcount;
$HEADERS  = "MIME-Version: 1.0\n";
$HEADERS .= "Content-type: text/html; charset=iso-8859-1\n";
$HEADERS .= "From: Communitymatrimony.com <doorstep@communitymatrimony.com>\n";
$totalMessMailContent = "".$mailmess."<br>".$smsmess;
mail("suresh.a@bharatmatrimony.com","CBS Offer expiry alert Count - ".$curdate,$totalMessMailContent);


//Function For Mobile Number Validating
function MobileValidate($phoneNos)
{
	if($phoneNos != "")
	{
		$stphone=strlen($phoneNos);
		for($i=0;$i<=$stphone;$i++)
		{
			$num=$phoneNos[$i];
			if(is_numeric($num))
			{
				$phoneNosfinal .= $phoneNos[$i];
			}
		}
		if(substr($phoneNosfinal,0,2) == '00'){
		$phoneNosfinal = substr($phoneNosfinal,2);
		}
		if(substr($phoneNosfinal,0,1)==0){
		$phoneNosfinal = substr($phoneNosfinal,1);
		}
		if(substr($phoneNosfinal,0,2)==91){
		$phoneNosfinal = substr($phoneNosfinal,2);
		}
		$phoneNosfinals=$phoneNosfinal;
	}
	else
	{ 
		$phoneNosfinals=""; 
	}
return $phoneNosfinals;
}

function getBranchId($branchId)
{
	global $objCommSlave,$varTable,$varCbstminterfaceDbInfo;
	$branchNameArr = array('BranchName');
	$branchCondition = " where BranchId = '$branchId'";
	$branchNameRes = $objCommSlave -> select($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['CBSTMBRANCHDETAILS'],$branchNameArr,$branchCondition,1);
return $branchNameRes[0]['BranchName'];
}
?>
