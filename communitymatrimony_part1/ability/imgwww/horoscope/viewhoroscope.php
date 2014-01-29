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
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessGender 	= $varGetCookieInfo["GENDER"];

//Object initialization
$objSlaveDB		= new MemcacheDB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varRequestId	= $_REQUEST["ID"];
$varPassword	= trim($_REQUEST['PID']);
$varDisplayAddedHoroscope='';

$varCondition	= " WHERE MatriId = ".$objSlaveDB->doEscapeString($varRequestId,$objSlaveDB);

//SETING MEMCACHE KEY
$varOppositeProfileMCKey= 'ProfileInfo_'.$varRequestId;

if($sessMatriId != '') {
	#CHECK PHOTO PROTECTED FOR THE SELECTED PROFILE
	if ($sessMatriId != $varRequestId)
	{
		$varFields					= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
		$varSelectHoroscopeStatus	= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0, $varOppositeProfileMCKey);
		$varProtectHoroscopeStatus	= $varSelectHoroscopeStatus["Horoscope_Protected"];
	}//if

	//SELECT PHOTOS FROM memberphotoinfo
	$varFields					= array('HoroscopeURL','HoroscopeStatus');
	$varResult					= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
	$varSelectHoroscopeList		= mysql_fetch_assoc($varResult);
	$varHoroscopeStatus			= $varSelectHoroscopeList['HoroscopeStatus'];
	$varHoroscopeURL			= $varSelectHoroscopeList['HoroscopeURL'];

	$arrHRFileinfo				= split('\.', $varHoroscopeURL);

	if($sessMatriId==$varRequestId && ( $varHoroscopeStatus==2 || $varHoroscopeStatus==0))
	{
		$varStatusMessage			= "<font style='color:#FF0000;font-size:12px'>(Under validation)</font>";
		$varHoroscopeFilePath		= $confValues['IMGURL']."/pending-horoscopes/".$arrDomainInfo[$varDomain][2].'/';
		$varHoroscopeSource			= ($arrHRFileinfo[1]=='html')?(file_get_contents($varHoroscopeFilePath.$varHoroscopeURL)):'<img src="'.$varHoroscopeFilePath.$varHoroscopeURL.'" hspace="2" vspace="2" border="0" GALLERYIMG="no" oncontextmenu="return false">';
		$varDisplayAddedHoroscope  .= '<tr><td valign="top"><div class="formborder">'.$varHoroscopeSource.'</div></td></tr>';
		$varViewHoroscope			= 1;
	} else if($sessMatriId==$varRequestId && ($varHoroscopeStatus==1 || $varHoroscopeStatus==3)) {
		$varStatusMessage			= '';
		$varHoroscopeFolder			= $confValues['IMGURL'].'/membershoroscope/'.$arrDomainInfo[$varDomain][2].'/'; 
		$varHoroscopeFilePath		= $varHoroscopeFolder.$varRequestId{3}."/".$varRequestId{4}."/";
		$varHoroscopeSource			= ($arrHRFileinfo[1]=='html')?(file_get_contents($varHoroscopeFilePath.$varHoroscopeURL)):'<img src="'.$varHoroscopeFilePath.$varHoroscopeURL.'" hspace="2" vspace="2" border="0" GALLERYIMG="no" oncontextmenu="return false">';
		$varDisplayAddedHoroscope  .= '<tr><td valign="top"><div class="formborder">'.$varHoroscopeSource.'</div></td></tr>';
		$varViewHoroscope			= 1;
	} else if(($varHoroscopeStatus==1 || $varHoroscopeStatus==2 || $varHoroscopeStatus==3) && $sessMatriId!=$varRequestId) {
		$varStatusMessage			= '';
		$varHoroscopeFolder			= $confValues['IMGURL'].'/membershoroscope/'.$arrDomainInfo[$varDomain][2].'/'; 
		$varHoroscopeFilePath		= $varHoroscopeFolder.$varRequestId{3}."/".$varRequestId{4}."/";
		$varHoroscopeSource			= ($arrHRFileinfo[1]=='html')?(file_get_contents($varHoroscopeFilePath.$varHoroscopeURL)):'<img src="'.$varHoroscopeFilePath.$varHoroscopeURL.'" hspace="2" vspace="2" border="0" GALLERYIMG="no" oncontextmenu="return false">';
		$varDisplayAddedHoroscope  .= '<tr><td valign="top"><div class="formborder">'.$varHoroscopeSource.'</div></td></tr>';
		$varViewHoroscope			= 1;
	}

	if($varViewHoroscope==1) {
	?>
	<html><head><title>View Horoscope</title>
	</head>
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<link rel="stylesheet" href="<?=$confValues['DOMAINCSSPATH']?>/global.css">
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
						<td class="bigtxt clr10 backcolor" valign="top" style="padding-top:2px;padding-left:5px;padding-bottom:2px;" width="50%"><img src="<?=$confValues['IMGSURL']?>/logo/<?=$arrDomainInfo[$varDomain][2]?>_logo.gif" alt="communitymatrimony" border="0" /></td>
						<td valign="top" align="right" class="backcolor" style="padding-right:10px;"><a href="javascript:window.close();" width="50%"><font class="smalltxt clr1"><u>Close</u></font></a></td>	
					</tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" bgcolor="#FFFFFF" align="center">
							<!-- START OF THUMBNAIL PHOTO DISPLAY -->
							<table border="0" cellpadding="5" cellspacing="0" width="613" height="100%">
								<tr><td valign="top" class="mediumtxt clr11" align="center"><font style="font-size:14px"><b>Horoscope of <?=$varRequestId;?></b></font>&nbsp;<?=$varStatusMessage;?><div style="padding-left:2px;padding-top:3px;"></font></div></td></tr>
								<tr><td align="right"><img src="<?=$confValues['IMGSURL']?>/horodownloadicon.gif" align="absmiddle" border="0" height="12" hspace="3" width="11" alt="Download Horoscope"><a href="onlineHoroscopedownload.php?file=<?=$varHoroscopeURL?>" class="smalltxt clr1" style="text-decoration: underline;">Download Horoscope</a>&nbsp;&nbsp;<img src="<?=$confValues['IMGSURL']?>/viewprofileicon.gif" align="absmiddle" border="0" height="12" hspace="3" width="11" alt="Print Horoscope"><a href="javascript:void(0);" onClick="javascript:funGenerateBill();" class="smalltxt clr1" style="text-decoration: underline;">Print Horoscope</a></td></tr>
								<?= $varDisplayAddedHoroscope; ?>
							</table>
							<!-- END OF THUMBNAIL PHOTO DISPLAY -->
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<?
	}
}
?>