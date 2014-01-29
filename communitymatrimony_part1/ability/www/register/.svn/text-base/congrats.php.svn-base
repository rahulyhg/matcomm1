<?php
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//file includes
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/basefunctions.cil14");
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsRegister.php');

//OBJECT DECLARTION
$objRegister	= new clsRegister;

//CONNECT DATABASE
$objRegister->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$varPhotoStatus	= $varGetCookieInfo['PHOTOSTATUS'];
$varGender		= $varGetCookieInfo['GENDER'];
$varPartlyId	= $_REQUEST["partlyId"];

//COMMUNITY REGISTRATION PAGE
if ($sessPublish=='5') {

	$varCurrentDate		= date('Y-m-d H:i:s');
	$varGothramText		= '';
	$varReligion		= $_REQUEST['religion'];
	$varCaste			= $_REQUEST['caste'];
	$varCasteText		= addslashes(strip_tags(trim($_REQUEST['casteText'])));
	$varCasteText		= $varCasteText ? $varCasteText : $varCasteOthers;
	$varCasteNoBar		= $_REQUEST['casteNoBar'];
	$varSubCaste		= $_REQUEST['subCaste'];
    $varSubCasteOthers		= addslashes(strip_tags(trim($_REQUEST['subCasteOthers'])));
	$varSubCasteText		= addslashes(strip_tags(trim($_REQUEST['subCasteText'])));
	$varSubCasteText		= $varSubCasteText ? $varSubCasteText : $varSubCasteOthers;
	$varSubCasteNoBar	= $_REQUEST['subCasteNoBar'];
	$varGothram			= $_REQUEST['gothram'];
	$varGothramOthers	= $_REQUEST['gothramOthers'];
	$varGothramText		= addslashes(strip_tags(trim($_REQUEST['gothramText'])));
	$varGothramText		= $varGothramOthers ? $varGothramOthers : $varGothramText;
	$varStar			= $_REQUEST['star'];
	$varStarText		= addslashes(strip_tags(trim($_REQUEST['starText'])));
	$varDenomination	= $_REQUEST['denomination'];

	$varCondition	= " MatriId=".$objRegister->doEscapeString($sessMatriId,$objRegister);
	$varFields				= array('Religion','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','GothramId','GothramText','Star','Denomination','Publish','Date_Updated');
	$varFieldsValues		= array($objRegister->doEscapeString($varReligion,$objRegister),$objRegister->doEscapeString($varCaste,$objRegister),$objRegister->doEscapeString($varCasteText,$objRegister),$objRegister->doEscapeString($varCasteNoBar,$objRegister),$objRegister->doEscapeString($varSubCaste,$objRegister),$objRegister->doEscapeString($varSubCasteText,$objRegister),$objRegister->doEscapeString($varSubCasteNoBar,$objRegister),$objRegister->doEscapeString($varGothram,$objRegister),$objRegister->doEscapeString($varGothramText,$objRegister),$objRegister->doEscapeString($varStar,$objRegister),$objRegister->doEscapeString($varDenomination,$objRegister),'0',"'".$varCurrentDate."'");
	$objRegister->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);

	echo '<script src="'.$confValues['SERVERURL'].'/login/updateprofilecookie.php"></script>';

}

	/*begin thava added for auto click ivr call*/
	include_once('registerclicktocall.php');
	/*end thava added for auto click ivr call*/

// Inorganic (Google) campaign lead track calling - Starts //
if(trim($sessMatriId)!='') {
 echo "<script src=\"http://www.communitymatrimony.com/googlecamp/landing/inorgleadtrack.php?matriid=".$sessMatriId."\"></script>";

 // CBS Campaign Leadtrack script calling - Added by Ashok / Dhanapal //
 echo "<script src=\"http://campaign.bharatmatrimony.com/cbstrack/leadtrack.php?matriid=".$sessMatriId."&regid=".$varPartlyId."&language=\"></script>";

}
// Inorganic (Google) campaign lead track calling - Ends //
?>

<!-- Google Code for Lead Conversion Page -->

<!-- CommunityMatrimony(P-Y)-3 ( Client ID: 793-880-3070 ) -->
<script type="text/javascript">
<!--
var google_conversion_id = 1030284173;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "mx3ECO2ByAEQjcej6wM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1030284173/?label=mx3ECO2ByAEQjcej6wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- RI-SE-CommunityMatrimony(K-P)-2 ( Client ID: 129-630-7623 ) -->
<script type="text/javascript">
<!--
var google_conversion_id = 1031624939;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "0P-xCPv_twEQ67H16wM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1031624939/?label=0P-xCPv_twEQ67H16wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


<!-- RI-SE-CommunityMatrimony(A-K)-PH ( Client ID: 184-740-8980 ) -->
<script type="text/javascript">
<!--
var google_conversion_id = 1029883705;
var google_conversion_language = "en_US";
var google_conversion_format = "1";
var google_conversion_color = "ffffff";
var google_conversion_label = "vlEQCN_ftAEQuY6L6wM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1029883705/?label=vlEQCN_ftAEQuY6L6wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- RI-SE-CommunityMatrimony(A-K)-EX ( Client ID: 330-814-5474 ) -->
<script type="text/javascript">
<!--
var google_conversion_id = 1044425647;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "j5XKCJ-wpwEQr9eC8gM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1044425647/?label=j5XKCJ-wpwEQr9eC8gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- RI-SE-CommunityMatrimony(A-K)-BR ( Client ID: 919-320-8580 ) -->
<script type="text/javascript">
<!--
var google_conversion_id = 1031730121;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "2O35CIeYuQEQyef76wM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1031730121/?label=2O35CIeYuQEQyef76wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- NRI-SE-CommunityMatrimony(A-K)-1 ( Client ID: 137-467-7823 ) -->
<script type="text/javascript">
<!--
var google_conversion_id = 1030719088;
var google_conversion_language = "en_US";
var google_conversion_format = "1";
var google_conversion_color = "ffffff";
var google_conversion_label = "up1dCODRsQEQ8Iy-6wM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1030719088/?label=up1dCODRsQEQ8Iy-6wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- NRI-SE-CommunityMatrimony(K-P)-2 ( Client ID: 826-678-6180 ) -->
<script type="text/javascript">
<!--
var google_conversion_id = 1030052305;
var google_conversion_language = "en_US";
var google_conversion_format = "1";
var google_conversion_color = "ffffff";
var google_conversion_label = "pQZGCJmAqgEQ0bOV6wM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1030052305/?label=pQZGCJmAqgEQ0bOV6wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- NRI-SE-CommunityMatrimony(P-Y)-3 ( Client ID: 410-819-2976 ) -->
<script type="text/javascript">
<!--
var google_conversion_id = 1042700356;
var google_conversion_language = "en_US";
var google_conversion_format = "1";
var google_conversion_color = "ffffff";
var google_conversion_label = "OQcLCNiNqAEQxLCZ8QM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1042700356/?label=OQcLCNiNqAEQxLCZ8QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


<!-- Google Code for Lead Conversion Page RI-CT-CommunityMatrimony(A-K)-->
<script type="text/javascript">
<!--
var google_conversion_id = 1039716952;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "tHrqCJqWpAEQ2KTj7wM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1039716952/?label=tHrqCJqWpAEQ2KTj7wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Google Code for Lead Conversion Page RI-CT-CommunityMatrimony(K-P)-->
<script type="text/javascript">
<!--
var google_conversion_id = 1044402826;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "jzyCCPbgmAEQiqWB8gM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1044402826/?label=jzyCCPbgmAEQiqWB8gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Google Code for Lead Conversion Page RI-CT-CommunityMatrimony(P-Y)-->
<script type="text/javascript">
<!--
var google_conversion_id = 1032774407;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "8TTaCLm5qgEQh8a77AM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1032774407/?label=8TTaCLm5qgEQh8a77AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Google Code for CPA Conversion Page - By Sathiya 15 July 2010 - For all Domain -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1013353859;
var google_conversion_language = "en";
var google_conversion_format = "1";
var google_conversion_color = "ffffff";
var google_conversion_label = "KXkHCK2z4wEQg5ua4wM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1013353859/?label=KXkHCK2z4wEQg5ua4wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


<!-- Google Code for CPA Conversion Page - By Pandian 15 July 2010 - For all Domain -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1015814563;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "revRCLXV3QEQo7Ow5AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1015814563/?label=revRCLXV3QEQo7Ow5AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<? if ($confValues['DOMAINCASTEID']=='2503') { ?>
<!-- Google Code for Lead1 Conversion Page MuslimMatrimony Account (Client ID: 870-731-6292) -->
<script type="text/javascript">
<!--
var google_conversion_id = 1068141794;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "F0pICMiVoQEQ4pmq_QM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1068141794/?label=F0pICMiVoQEQ4pmq_QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<? } ?>

<!-- Google Code for Lead Conversion Page - ChristianMatrimony -->
<? if ($confValues['DOMAINCASTEID']=='2500') { ?>
<script type="text/javascript">
<!--
var google_conversion_id = 1028500368;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "Q5RkCOCTvwEQkNe26gM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1028500368/?label=Q5RkCOCTvwEQkNe26gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<? } ?>
<!-- Google Code for Lead Conversion Page -->

<!-- Google Code for Lead Conversion Page - Jainmatrimony -->
<? if ($confValues['DOMAINCASTEID']=='2501') { ?>
<script type="text/javascript">
<!--
var google_conversion_id = 1017310053;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "Gn9KCOu40AEQ5daL5QM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1017310053/?label=Gn9KCOu40AEQ5daL5QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<? } ?>
<!-- Google Code for Lead Conversion Page -->

<!-- Google Code for Lead Conversion Page - Sikhmatrimony -->
<? if ($confValues['DOMAINCASTEID']=='2502') { ?>
<script type="text/javascript">
<!--
var google_conversion_id = 1018710812;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "CcUWCKTNxwEQnJbh5QM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1018710812/?label=CcUWCKTNxwEQnJbh5QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<? } ?>
<!-- Google Code for Lead Conversion Page -->

<!-- Google Code for Lead Conversion Page - Manglikmatrimony -->
<? if ($confValues['DOMAINCASTEID']=='2003') { ?>
<script type="text/javascript">
<!--
var google_conversion_id = 1018050925;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "h0dWCLvz4AEQ7fK45QM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1018050925/?label=h0dWCLvz4AEQ7fK45QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<? } ?>
<!-- Google Code for Lead Conversion Page -->


<!-- Google Code for lead Conversion Page Starts Here [2010-April-22] -->

<? if ($confValues['DOMAINCASTEID']!='25' && $confValues['DOMAINCASTEID']!='2001' ) { ?>
<script type="text/javascript">
<!--
var google_conversion_id = 1024850328;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "YNooCJS0zAEQmPPX6AM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1024850328/?label=YNooCJS0zAEQmPPX6AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<? } ?>

<? if ($confValues['DOMAINCASTEID']=='25') { ?>
<script type="text/javascript">
<!--
var google_conversion_id = 1020043952;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "-yCYCJz1xAEQsMWy5gM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1020043952/?label=-yCYCJz1xAEQsMWy5gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<? } ?>


<? if ($confValues['DOMAINCASTEID']=='2001') { ?>
<script type="text/javascript">
<!--
var google_conversion_id = 1021017307;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "c0rrCJ_-vwEQ2_nt5gM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1021017307/?label=c0rrCJ_-vwEQ2_nt5gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<? } ?>

<!-- Below Google Code for Lead Conversion Page from sathya for anycaste sites -->
<? if ($confValues['DOMAINCASTEID']=='2004') { ?>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1014329106;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "pMmWCIb0wwEQkt7V4wM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1014329106/?label=pMmWCIb0wwEQkt7V4wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<? } ?>

<!-- Google Code for Lead Conversion Page from sathya + laxman for 100 sites -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1017309333;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "YU79COPb1wEQldGL5QM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1017309333/?label=YU79COPb1wEQldGL5QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Google Code for Lead Conversion Page Ends Here [2010-April-22] -->

<!-- Advertiser 'Community matrimony Aug10',  Conversion tracking 'Community matrimony Conversion Pixel' - DO NOT MODIFY THIS PIXEL IN ANY WAY -->
<img src="http://ext.tyroo.com/pixel?id=641488&t=2" width="1" height="1" />
<!-- End of conversion tag -->

<!-- Komli Pixel RI - DO NOT MODIFY THIS PIXEL IN ANY WAY -->
<script src="http://ads.komli.com/pixel?id=99155&t=1" type="text/javascript"></script>
<!-- End of conversion tag -->

<!-- Admagnet Pixel Code -->
<img src='http://n.admagnet.net/panda/www/delivery/ti.php?trackerid=208&amp;adid=&amp;cb=%%RANDOM_NUMBER%%' width='0' height='0' alt='' />
<!-- Admagnet Pixel Code -->

<!-- Ibibo Pixel Code -->
<div id='m3_tracker_98' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'><img src='http://ads.ibibo.com/ad/www/delivery/ti.php?trackerid=98&amp;cb=%%RANDOM_NUMBER%%' width='0' height='0' alt='' /></div>
<!-- Ibibo Pixel Code -->

<!-- xxxxx  Begin Action Tracking code - OzoneMedia -->
<script language="JavaScript" type="text/javascript">
var zzp=new Image();
if (location.protocol == "https:") {
zzp.src="https://tt1.zedo.com/ads2/t?o=224713;h=837371;z="+Math.random();
} else {
zzp.src="http://yads.zedo.com/ads2/t?o=224713;h=837371;z="+Math.random();
}
</script>
<img width="1" height="1" src="http://ads.ozonemedia.co.in/TrackAction/ADVID=404"/>
<!-- xxxxxx  Action Tracking Code -OzoneMedia -->

<!-- Advertiser 'Community matrimony Dec09',  Include user in conversion 'Community matrimony Conversion Pixel' - DO NOT MODIFY THIS PIXEL IN ANY WAY -->
<script src="http://ext.tyroo.com/pixel?id=641488&t=1" type="text/javascript"></script>
<!-- End of conversion tag -->

<!-- Affiliate Offer: CommunityMatrimony -->
<iframe src="http://jump.advertextrack.com/aff_l?offer_id=6" scrolling="no" frameborder="0" width="1" height="1"></iframe>
<!-- // End Affiliate Offer -->

<!-- Advertiser Yahoo, Conversion tracking '754328_CPA_BM' - DO NOT MODIFY THIS PIXEL IN ANY WAY -->
<img src="http://ad.yieldmanager.com/pixel?id=607256&t=2" width="1" height="1" />
<!-- End of segment tag -->

<!-- Advertiser 'CONSIM INFO PVT. LTD.',  Conversion tracking '762238_CPL_CM@100_Feb10_Pixel' - DO NOT MODIFY THIS PIXEL IN ANY WAY -->
<img src="http://ad.yieldmanager.com/pixel?id=693205&t=2" width="1" height="1" />
<!-- End of segment tag -->

<!-- Admagnet Pixel code -->
<script type='text/javascript'><!--//<![CDATA[

    var OA_p=location.protocol=='https:'?'https:':'http:';
    var OA_r=Math.floor(Math.random()*999999);
    document.write ("<" + "script language='JavaScript' ");
    document.write ("type='text/javascript' src='"+OA_p);
    document.write ("//n.admagnet.net/panda/www/delivery/tjs.php");
    document.write ("?trackerid=264&amp;r="+OA_r+"'><" + "/script>");
//]]>--></script><noscript><div id='m3_tracker_264' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'><img src='http://n.admagnet.net/panda/www/delivery/ti.php?trackerid=264&amp;adid=&amp;sname=%%SNAME_VALUE%%&amp;Order_ID=%%ORDER_ID_VALUE%%&amp;OrderID=%%ORDERID_VALUE%%&amp;Quantity=%%QUANTITY_VALUE%%&amp;Value=%%VALUE_VALUE%%&amp;Transactionid=%%TRANSACTIONID_VALUE%%&amp;cb=%%RANDOM_NUMBER%%' width='0' height='0' alt='' /></div></noscript>
<!-- Admagnet Pixel code -->

<SCRIPT language="JavaScript" type="text/javascript">
<!-- Yahoo!
window.ysm_customData = new Object();
window.ysm_customData.conversion = "transId=,currency=,amount=";
var ysm_accountid  = "1SVVNP202VC9U4KGQJGMG8V292G";
document.write("<SCR" + "IPT language='JavaScript' type='text/javascript' "
+ "SRC=//" + "srv2.wa.marketingsolutions.yahoo.com" + "/script/ScriptServlet" + "?aid=" + ysm_accountid
+ "></SCR" + "IPT>");
// -->
</SCRIPT>