<?php
#comman include file
//ini_set('display_errors','on');
//error_reporting(E_ALL ^ E_NOTICE);

$varRootBasePath = '/home/product/community';

//include_once("header.php");
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/conf/domainrates.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/www/admin/paymentassistance/clsPaging.php');
include_once($varRootBasePath.'/www/admin/paymentassistance/lvars.php');
include_once($varRootBasePath.'/www/admin/paymentassistance/pavar.php');
include_once ($varRootBasePath."/www/admin/paymentassistance/offer/cbstmofferarray.php");
include_once ($varRootBasePath."/www/admin/paymentassistance/offer/cbstmofferflow.class.php");
include_once ($varRootBasePath."/www/admin/paymentassistance/offer/supportgetpackagedetails.php");

$matriId=$_REQUEST['mid'];
$offerId=$_REQUEST['cateId'];
$tmCateOfferMax=$_REQUEST['maxoffer'];
$defutShow=$_REQUEST['newcurr'];
$offerCategorType=$_REQUEST['cattype'];
$showOffer='';

$CateType='CBSTMSUPPORT';
if($matriId!='') {

$memberempty		= new DB;
$memberempty->dbConnect('S',$varDbInfo['DATABASE']);

$objOffer =new offershow();
$offerArray=$objOffer->showofferdetails($offerId,$tmCateOfferMax,$defutShow,$offerCategorType,$memberempty,$matriId);

if($offerId==$checkOfferCatId[$CateType]) {
$offerType="Offline Offer Available";
} else {
$offerType="Online Offer Available";
}
$retuenMax=$objOffer->getmaxofferonly();
$retuenMaxAmount=$objOffer->getmaxAmountofferonly();
	foreach($offerArray as $offerKey=>$offerValue){
				$showOffer.=$offerValue;
				if($offerKey%3==0){
					$showOffer.="<br clear='all'><div style='width:280px;' class='vdotline1'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='1'></div><br clear='all'>";
				}
	}
	$showOffer.="<br clear='all'><div style='width:280px;' class='vdotline1'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='1'></div><br clear='all'>";
}
echo $showOffer;
?>