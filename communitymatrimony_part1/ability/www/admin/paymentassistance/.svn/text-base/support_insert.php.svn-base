<?php
/* **************************************************************************************************
FILENAME        :support_insert.php
AUTHOR			:A.Kirubasankar
PROJECT			:Payment Assistance
DESCRIPTION : to insert  payment ok epr into collection interface
************************************************************************************************* */
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community/ability';

include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/wsconf.inc');
include_once($varRootBasePath.'/lib/clsDB.php');
//Memcache DB
//include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/conf/domainlist.inc');
include_once($varRootBasePath.'/conf/config.inc');
//include_once($varRootBasePath.'/conf/paymentassistance.inc');
include_once($varRootBasePath.'/conf/vars.inc');

//File for Memcache
include_once($varRootBasePath.'/lib/clsWSMemcacheClient.php');

global $adminUserName;

if($adminUserName == "")
	header("Location: ../index.php?act=login");

//OBJECT DECLARTION
//$objMaster	= new DB;
//$objSlave	= new DB;
//$objSlaveMatri	= new DB;

// Memcache COnn 
//$objMasterMatri	= new MemcacheDB;

$objMasterMatri	= new DB;


//$objSlaveMatri -> dbConnect('S',$varDbInfo['DATABASE']);

//$objMasterMatri -> dbConnect('M',$varDbInfo['DATABASE']);
$objMasterMatri -> dbConnect('M',$varDbInfo['DATABASE']);

//global $varDBUserName, $varDBPassword;
//$varDBUserName = $varPaymentAssistanceDbInfo['USERNAME'];
//$varDBPassword = $varPaymentAssistanceDbInfo['PASSWORD'];

//DB CONNECTION
//$objSlave -> dbConnect('S',$varPaymentAssistanceDbInfo['DATABASE']);
//$objMaster -> dbConnect('M',$varPaymentAssistanceDbInfo['DATABASE']);

//SETING MEMCACHE KEY


$uid        = db_escape_quotes($_REQUEST['userid']);
$uname      = db_escape_quotes($_REQUEST['username']);
$cookieuname = $adminUserName;
$mat 		= db_escape_quotes($_REQUEST['matriidpost']);
$cate 		= db_escape_quotes($_REQUEST['cate']);
$follow		= db_escape_quotes($_REQUEST['tstatus']);
$curdesc	= db_escape_quotes($_REQUEST['fdesc']);
$assured    = db_escape_quotes($_REQUEST['assured']);

$sessMatriId = $mat;

//$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

function db_spl_chars_encode($str) 	{
	return htmlentities($str);
}
function db_escape_quotes($value) 	{
	$value = db_spl_chars_encode($value);
	if (get_magic_quotes_gpc()) 
		{
			$value = stripslashes($value);
		}
		if (!is_numeric($value)) 
		{
			$value = mysql_real_escape_string($value);
		}
		return trim($value); 
}

if($cate==3) {
$upUserId=",SupportUserName='".$cookieuname."'";
} else { $upUserId=''; } 

if(db_escape_quotes($_REQUEST['Fyear']) != "yyyy" and db_escape_quotes($_REQUEST['Fmon']) != "mmm" and db_escape_quotes($_REQUEST['Fday']) != "dd" and db_escape_quotes($_REQUEST['Fyear']) !="" and db_escape_quotes($_REQUEST['Fmon']) !="" and db_escape_quotes($_REQUEST['Fday']) != "")
{
	$darr[0] = db_escape_quotes($_REQUEST['Fyear']);
	$darr[1] = db_escape_quotes($_REQUEST['Fmon']);
	$darr[2] = db_escape_quotes($_REQUEST['Fday']); 
	$FDATE=implode("-",$darr);
	$fdt=",FollowupDate='".$FDATE."'";

	$argFields = array('LockTime','Comments','LeadSource','FreshlyAddedOn');
	$argConditions = " WHERE MatriId = '".$mat."'";
	$total = $objMasterMatri -> numOfRecords($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS'],'Comments',$argConditions);
	if($objMasterMatri -> clsErrorCode == "CNT_ERR")
	{
		echo "Datebase error";
		exit;
	}
	$recset = $objMasterMatri -> select($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS'],$argFields,$argConditions,0);
	if($objMasterMatri -> clsErrorCode == "SELECT_ERR")
	{
	echo "Database Error";
	exit;
	}
	$rec = mysql_fetch_assoc($recset);

	if($total == 1)
	{
		if($rec['Comments'])
		{
			$COMMENTS=$rec['Comments'].date("Y-m-d h:i:s",time()).":". $curdesc."\n";
		}
		else
		{	
			$COMMENTS=date("Y-m-d h:i:s",time()).":".$curdesc."\n";
		}
		$COMMENTS= db_escape_quotes($COMMENTS);

		if($rec['LockTime'] =="0000-00-00 00:00:00")
		{
			//$app = ",LockTime=Now(),SupportUserId='".$uid."'";
			$app = ",LockTime=Now(),SupportUserName='".$cookieuname."'";
		}
		else
		{ $app =" ";  }
	}
	if($follow == "1" || $follow == "9" || $follow == "10")
	{
		$updateArgFields = array('FollowupStatus','Comments','DateUpdated','SupportUserName','FollowupDate','PaymentDate');
		$updateArgConditions = array("'".$follow."'","'".$COMMENTS."'","NOW()","'".$cookieuname."'","'".$FDATE."'","'".$FDATE."'");
	}
	else
	{
		$updateArgFields = array('FollowupStatus','Comments','DateUpdated','SupportUserName','FollowupDate');
		$updateArgConditions = array("'".$follow."'","'".$COMMENTS."'","NOW()","'".$cookieuname."'","'".$FDATE."'");
	}
	$argCondition = " MatriId = '".$mat."'";

	$objMasterMatri -> update($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS'], $updateArgFields, $updateArgConditions, $argCondition);

	if($objMasterMatri -> clsErrorCode == "UPDATE_ERR")
	{
		echo "Database Error ";
		exit;
	}

	
	$followupFields = array('MatriId','SupportUserId','SupportUserName','FollowupStatus','FollowupDate','DateUpdated','LeadSource');
	$followupValues = array("'".$mat."'","'".$uid."'","'".$cookieuname."'","'".$follow."'","'".$FDATE."'","now()","'".$rec[LeadSource]."'");
	$objMasterMatri -> insert($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONSFOLLOWUPDETAILS'], $followupFields, $followupValues);
	if($objMasterMatri -> clsErrorCode == "INSERT_ERR")
	{
		echo "Database Error ";
		exit;
	}
	else {
		$retmess = "Details Updated Successfully";
	}
}
else
{
	$FDATENEW=mktime(0,0,0,date(m),date(d)+1,date(Y));
	$FDATE=date("Y-m-d",$FDATENEW);
	$fdt=",FollowupDate='".$FDATE."'";

	$selectArgs = array('LockTime','Comments','LeadSource');
	$selectConditions = " WHERE MatriId = '".$mat."'";
	$recset = $objMasterMatri -> select($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS'],$selectArgs,$selectConditions,0);
	if($objMasterMatri -> clsErrorCode == "SELECT_ERR")
	{
		echo "Database Error";
		exit;
	}
	$rec = mysql_fetch_assoc($recset);

	if($total == 1)
	{
		if($rec['Comments'])
		{
			$COMMENTS=$rec['Comments'].date("Y-m-d h:i:s",time()).":". $curdesc."\n";
		}
		else 
		{	
			$COMMENTS=date("Y-m-d h:i:s",time()).":".$curdesc."\n";
		}
		$COMMENTS= db_escape_quotes($COMMENTS);
		if($rec['LockTime'] =="0000-00-00 00:00:00")
		{
			$app = ",LockTime=Now(),SupportUserName='".$cookieuname."'";
		}
		else { $app =" ";  }
	}
	else
		$COMMENTS= db_escape_quotes($curdesc);

	
		$updateFields = array('FollowupStatus','Comments','FollowupDate','DateUpdated','SupportUserName');
		$updateValues = array("'".$follow."'","'".$COMMENTS."'","'".$FDATE."'","Now()","'".$uname."'");
	
	$argCondition = " MatriId = '".$mat."'";
	$countins = $objMasterMatri -> update($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS'], $updateFields, $updateValues, $argCondition);
	if($objMasterMatri -> clsErrorCode == "UPDATE_ERR")
	{
		echo "Database Error ";
		exit;
	}

	$insertFields = array('MatriId','SupportUserName','FollowupStatus','FollowupDate','DateUpdated','LeadSource');
	$insertValues = array("'".$mat."'","'".$uname."'","'".$follow."'","'".$FDATE."'","now()","'".$rec[LeadSource]."'");
	$countins = $objMasterMatri -> insert($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONSFOLLOWUPDETAILS'], $insertFields, $insertValues);

	if($objMasterMatri -> clsErrorCode == "INSERT_ERR")
	{
		echo "Database Error ";
		exit;
	}
	else
	{
		$retmess = "Details Updated Successfully";
	}
}



#mailflow------------------------------------------------------------------
	##OFFER PROCESS 
	$packageSelected=$_REQUEST['PACKAGESELECT'];
	if(!empty($packageSelected)) {
		$offerSource=1;
		include_once ($varRootBasePath."/www/admin/paymentassistance/offer/offerpost.php");

		if($offerMail==1) {
			$offerUpdate =new tmofferupdate();
			$getExecutedQuery=$offerUpdate->getiniciate($mat,$offerId,$offerCode,$assuredGift,$offerPresentage,$nextLevelOffer,$phoneOffer,$_REQUEST['UAETOINDIACURRENCE'],$amountOfferAed,$amountOfferRs,$offerExpDate,$offerSource,$objMasterMatri);
			//mail("kirubasankar.a@bharatmatrimony.com","Offer update-Query",$getExecutedQuery);
			}
		}

if($follow == "6")
{

	$argFields = array('User_Name','Email');
	$argConditions = " WHERE MatriId = '".$mat."'";
	$total = $objMasterMatri -> numOfRecords($varTable['MEMBERLOGININFO'],'Email',$argConditions);
	if($objMasterMatri -> clsErrorCode == "CNT_ERR")
	{
		echo "Datebase error";
		exit;
	}
	$recset = $objMasterMatri -> select($varTable['MEMBERLOGININFO'],$argFields,$argConditions,0);
	if($objMasterMatri -> clsErrorCode == "SELECT_ERR")
	{
		echo "Database Error";
		exit;
	}
	$rec = mysql_fetch_assoc($recset);


	 $Email    = $rec['Email'];
	 $MatriId  = $mat;
	 $Name     = $rec['User_Name'];

	 //$MailCont = file_get_contents($varRootBasePath."/support/www/mailer/notreachable-mailer.html");
	// $MailCont = file_get_contents($varRootBasePath."/www/mailer/notreacheable_template.html");
	 $MailCont = file_get_contents($varRootBasePath."/www/mailer/notreachable-mailer.html");
	  
		$subject = "Unable to reach you. Here's something you shouldn't miss.";
	 
		if($MatriId!="" && $Email!="" && $Name != "")	{
		  $MailCont;
		  $encodedid = base64_encode(trim($MatriId));
		/*
		  $domaininfo= getDomainInfo(1,$MatriId);
		  $DOMAIN = $domaininfo['domainnamelong'];
		  $DOMAINSHORT = ucfirst($domaininfo['domainnameshort']);
		*/
		$matriId = $mat;
		$domainFirst3 = substr($matriId,0,3);
		$arrMatriIdPre1 = array_flip($arrMatriIdPre);
		$domaininfo = $arrMatriIdPre1[$domainFirst3];
		$DOMAIN = $arrPrefixDomainList[$domainFirst3];
		  
		  $PAYMENTURL = "http://www.$DOMAIN/payment/";
		 
		  $MailCont=str_replace("<<NAME>>","$Name",$MailCont);
		  $MailCont=str_replace("<<MATRIID>>","$matriId",$MailCont);
		  $MailCont=str_replace("<<<DOMAINNAME>>","$DOMAIN",$MailCont);
		  $MailCont=str_replace("<<DOMAIN>>","www.$DOMAIN",$MailCont);
		  $MailCont=str_replace("<<CONTACTURL>>","http://www.$DOMAIN/payment/",$MailCont);

		  $MailCont=str_replace("<<PHONEURL>>","http://www.$DOMAIN",$MailCont);
		  $MailCont=str_replace("<<PAYMENTURL>>","$PAYMENTURL",$MailCont);
		  $MailCont=str_replace("<<DOORSTEPURL>>","$PAYMENTURL",$MailCont);

		 // $MailCont=str_replace("<<PAIDMEMBERSHIPDETAILSURL>>","$PAYMENTURL",$MailCont);
		 // $MailCont=str_replace("<<PHONENUMBER>>","Phone number",$MailCont);
		 // $MailCont=str_replace("<<EMAILID>>","$Name",$MailCont);
		 // $MailCont=str_replace("<<TEMNAME>>","$Name",$MailCont);
	   }
			//$Email='kirubasankar.a@bharatmatrimony.com';

			//echo $MailCont;
			 if(trim($Email)!='' && $MailCont!=''){
				$headers .= "From: CommunityMatrimony.com <info@communitymatrimony.com>\n";
				$headers .= "X-Mailer: PHP mailer\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\n";
				//$headers .= "Reply-To: payment@bharatmatrimony.com . \n";
				//$headers .= "Reply-To: assistance@bharatmatrimony.com . \n";
				$headers .= "Reply-To: info@communitymatrimony.com . \n";
				//$headers .= "Bcc: asureshmca@gmail.com . \n";
				mail($Email,$subject,$MailCont,$headers);
				
				
				
	}
}

#mailflow------------------------------------------------------------------
/*
$objSlaveMatri -> dbClose();
$objMasterMatri -> dbClose();
*/
$objMasterMatri -> dbClose();

$cururl = $_SERVER[HTTP_REFERER];
$curpos = strpos($cururl, "&retmess");
$curlink = substr($cururl, 0, $curpos);
if($curlink == "")
	$curlink = $cururl;

$redirect = $curlink."&mtid=".$mat."&retmess=$retmess";

if(ereg("offset",$redirect))  {
$url = parse_str($redirect);
//if($_REQUEST[category] == "2")
	$offset++;
$offset_find="offset=".$offset ;

$offset_replace = "offset=".($offset - 1);
$newoff=$offset - 1;

if($newoff=="-1") $offset_replace="offset="."0";

$redirect = ereg_replace($offset_find,$offset_replace,$redirect);
#echo $redirect;
}
$redirecteasypay=$_POST['easypayhide'];
//echo "Follow - ".$follow;

if($cate == "3") {
	$cururl = $_SERVER[HTTP_REFERER];
	$curpos = strpos($cururl, "&retmess");
	$curlink = substr($cururl, 0, $curpos);
	if($curlink == "")
		$curlink = $cururl;
	$redirectUrl = "".$redirect = $curlink."&mtid=".$mat."&retmess=$retmess";
	//header("Location: $redirectUrl");
	$redirect = $redirectUrl;
}


if($follow != 1) {
//header("Location: $redirect");
$redirect = $redirect;
}
else {
//$redirecteasypay.="&PaymentCategorynew=".$selPCat[1]."&disPre=".$_POST['disPre']."&nextOffer=".$_POST['nextOffer']."&assured=".$_POST['assured']."&ExtPhone=".$_POST['exPhNo'];
$redirecteasypay.="&PaymentCategorynew=".$_POST['PaymentCategorynew']."&disPre=".$_POST['disPre']."&nextOffer=".$_POST['nextOffer']."&assured=".$_POST['assured']."&ExtPhone=".$_POST['exPhNo']."&prefdesc=".$_POST['fdesc']."&mtid=".$mat."&retmess=$retmess";
$redirect = $redirecteasypay;
header("Location: $redirecteasypay");
}

?>
<html> 
<head>

	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">

	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/usericons-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractions-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractivity-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/messages.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/fade.css">



</head>
<table align=center border="0" cellpadding="0" cellspacing="0" width="80%">
<tr><td  width="1px" align="left" height="40">
<?php
	include("../home/header.php");
?>
</td></tr>
</table>

<table align=center border="0" cellpadding="0" cellspacing="0"  width="780"  style='border: 1px solid #d1d1d1;'>
<tr align="right"  class='adminformheader'><td>TeleCallerId [<?=$uname;?>] &nbsp;<a href='index.php' class='textsmallnormal'><B>Home</B></a> | <A HREF="logout.php" class='textsmallnormal'><B>Logout</B></A></td></tr>
<?php
if($cate != "3")
{
	echo "<tr   class='textsmallnormal'><td   style='border: 1px solid #d1d1d1;' align='center'>&nbsp;&nbsp;$meses $retmess <a href='$redirect'>Next</a></td></tr>";
}
else
{
	echo "<tr   class='textsmallnormal'><td   style='border: 1px solid #d1d1d1;' align='center'>&nbsp;&nbsp;$meses $retmess <a href='index.php'>Back</a></td></tr>";
}
?>
</table>
</body>
</html>