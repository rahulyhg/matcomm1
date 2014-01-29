<?php
#================================================================================================================
   # Author 		: Jeyakumar
   # Date			: 20-Mar-2009
   # Project		: MatrimonyProduct
   # Filename		: viewhoroscope.php
#================================================================================================================
   # Description    : view horoscope
#================================================================================================================

//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];

//Object initialization
$objSlaveDB		= new DB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('M', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varRequestId	= $_REQUEST["ID"];
$varPassword	= md5(trim($_REQUEST['PID']));
$varDisplayAddedHoroscope='';

$varCondition	= " WHERE MatriId = ".$objSlaveDB->doEscapeString($varRequestId,$objSlaveDB);

#GETTING LOGIN INFORMATION FOR THE SELECTED PROFILE
$varFields			= array('User_Name');
$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
$varLoginInfo		= mysql_fetch_assoc($varResult);
$varProfileUsername	= $varLoginInfo["User_Name"];

#CHECK PHOTO PROTECTED FOR THE SELECTED PROFILE
if ($sessMatriId != $varRequestId)
{
	$varFields					= array('Horoscope_Available','Horoscope_Protected');
	$varResult					= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
	$varSelectHoroscopeStatus	= mysql_fetch_assoc($varResult);
	$varProtectHoroscopeStatus	= $varSelectHoroscopeStatus["Horoscope_Protected"];

	/*if ($varProtectHoroscopeStatus==1)
	{
		$varFields					= array('Horoscope_Protected_Password');
		$varResult					= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
		$varSelectPassword			= mysql_fetch_assoc($varResult);
		$varProtectHoroscopePwd		= $varSelectPassword["Horoscope_Protected_Password"];

		if($varProtectHoroscopePwd!=$varPassword)
		{
			header("Location: ".$confValues['SERVERURL']."/horoscope/horoscopeviewpassword.php?ID=".$varRequestId."&UNAME=".$varProfileUsername);exit;
		}
	}*/
}//if

//SELECT PHOTOS FROM memberphotoinfo
$varFields					= array('HoroscopeURL','HoroscopeStatus');
$varResult					= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
$varSelectHoroscopeList		= mysql_fetch_assoc($varResult);
$varHoroscopeStatus			= $varSelectHoroscopeList['HoroscopeStatus'];
$varHoroscopeURL			= $varSelectHoroscopeList['HoroscopeURL'];

if($sessMatriId==$varRequestId && ( $varHoroscopeStatus==2 || $varHoroscopeStatus==0))
{
	$varStatusMessage			= "<font style='color:#FF0000;font-size:12px'>(Under validation)</font>";
	$varHoroscopeFilePath		= $confValues['IMGURL']."/pending-horoscopes/".$arrDomainInfo[$varDomain][2].'/';
	$varDisplayAddedHoroscope  .= '<tr><td valign="top"><div class="formborder" style="overflow:auto;width:580px;"><img src="'.$varHoroscopeFilePath.$varHoroscopeURL.'" hspace="2" vspace="2" border="0" GALLERYIMG="no" oncontextmenu="return false"></div></td></tr>';
} else if($varHoroscopeStatus==1 || $varHoroscopeStatus==2) {
	$varStatusMessage			= '';
	$varHoroscopeFolder			= $confValues['IMGURL'].'/membershoroscope/'.$arrDomainInfo[$varDomain][2].'/'; 
	$varHoroscopeFilePath		= $varHoroscopeFolder.$varRequestId{3}."/".$varRequestId{4}."/";
	$varDisplayAddedHoroscope  .= '<tr><td valign="top"><div class="formborder" style="overflow:auto;width:580px;"><img src="'.$varHoroscopeFilePath.$varHoroscopeURL.'" hspace="2" vspace="2" border="0" GALLERYIMG="no" oncontextmenu="return false"></div></td></tr>';
}
?>
<html><head><title>View Horoscope</title>
</head><link rel="stylesheet" href="../styles/global-style.css">
<script language="javascript">
function funGenerateBill()
{
	window.print();
	location.reload();
}//funGenerateBill
</script>
<body marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" bgcolor="#FFFFFF">
<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="613" bgcolor="#FFFFFF"  height="100%">
	<tr><td valign="top" width="613">
			<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" width="613">
				<tr>
					<td class="bigtxt clr10 backcolor" valign="top" style="padding-top:2px;padding-left:5px;padding-bottom:2px;" width="50%"><b><?=$confValues['PRODUCTNAME']?>.com</b></td>
					<td valign="top" align="right" class="backcolor" style="padding-right:10px;"><a href="javascript:window.close();" width="50%"><font class="mediumtxt clr1"><u>Close</u></font></a></td>	
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" bgcolor="#FFFFFF" align="center">
						<!-- START OF THUMBNAIL PHOTO DISPLAY -->
						<table border="0" cellpadding="5" cellspacing="0" width="613" height="100%">
							<tr><td valign="top" class="mediumtxt clr11" align="center"><font style="font-size:14px"><b>Horoscope of <?=$varProfileUsername;?></b></font>&nbsp;<?=$varStatusMessage;?><div style="padding-left:2px;padding-top:3px;"></font></div></td></tr>
							<tr><td align="right"><img src="../images/horodownloadicon.gif" align="absmiddle" border="0" height="12" hspace="3" width="11" alt="Download Horoscope"><a href="onlineHoroscopedownload.php?file=<?=$varHoroscopeURL?>" class="mediumtxt clr1" style="text-decoration: underline;">Download Horoscope</a>&nbsp;&nbsp;<img src="../images/viewprofileicon.gif" align="absmiddle" border="0" height="12" hspace="3" width="11" alt="Print Horoscope"><a href="javascript:void(0);" onClick="javascript:funGenerateBill();" class="mediumtxt clr1" style="text-decoration: underline;">Print Horoscope</a></td></tr>
							<?= $varDisplayAddedHoroscope; ?>
						</table>
						<!-- END OF THUMBNAIL PHOTO DISPLAY -->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>