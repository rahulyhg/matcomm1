<?php
#================================================================================================================
   # Author 		: Jeyakumar
   # Date			: 24-Mar-2009
   # Project		: MatrimonyProduct
   # Filename		: adminshowhoroscope.php
#================================================================================================================
   # Description	: Display the horoscope of the particular user
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
//SESSION VARIABLES
$sessMatriId		= $_REQUEST['MATRIID'];

//Object initialization
$objSlaveDB			= new MemcacheDB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($sessMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

$varFields			= array('HoroscopeURL','HoroscopeStatus','Horoscope_Date_Updated','Horoscope_Protected','Horoscope_Protected_Password');
$varCondition		= "WHERE MatriId = '".$sessMatriId."'";
$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
$varSelectHRInfo	= mysql_fetch_assoc($varResult);
$varFields			= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
$varCondition		= "WHERE MatriId = '".$sessMatriId."'";
$varMemberInfo		= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0, $varOwnProfileMCKey);
$varName			= $varMemberInfo['Name'];
$varHoroscopeStatus	= $varMemberInfo['Horoscope_Available'];

?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<div style="width:880px;margin:10px;">
<div class="fleft" style="width:"640">
	<? if ($varSelectHRInfo['HoroscopeURL'] != ''){?>
	<table border="0" cellpadding="0" cellspacing="0" width="640">
		<tr><td colspan=4>
			<div class="fleft">
				<img src="<?=$confValues['IMGSURL'];?>/logo.gif" ></div>
			</td>
		</tr>
		<tr><td style="padding-top:5px;"colspan=4>
				<div class="vdotline1"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" height="1"
				></div></td>
		</tr>
		<tr colspan=4>
			<td valign="top" align="center" colspan="4">
				<?	if (($varSelectHRInfo['HoroscopeStatus'] == 1 )  && file_exists($varRootBasePath."/www/membershoroscope/".$varFolderName.'/'.$sessMatriId{3}."/".$sessMatriId{4}."/".$varSelectHRInfo['HoroscopeURL'])) {	
				?>
					<div style="padding-top:10px; padding-right:5px;">
						<img src="<?=$confValues['IMGURL']?>/membershoroscope/<?=$varFolderName.'/'.$sessMatriId{3}.'/'.$sessMatriId{4}.'/'.$varSelectHRInfo['HoroscopeURL'];?>" border=0><br clear="all"><font class="smalltxt clr1">&nbsp;</font>
					</div>
				<? } elseif (($varSelectHRInfo['HoroscopeStatus'] == 0 || $varSelectHRInfo['HoroscopeStatus'] == 2 )  &&  file_exists($varRootBasePath."/www/pending-horoscopes/".$varFolderName.'/'.$varSelectHRInfo['HoroscopeURL'])) { ?>
					<div style="padding-top:10px; padding-right:5px;">
						<img src="<?=$confValues['IMGURL']?>/pending-horoscopes/<?=$varFolderName.'/'.$varSelectHRInfo['HoroscopeURL'];?>" border=0><br clear="all"><br clear="all"><font class="smalltxt">Under validation</font>
					</div>
				<?	} ?>
			</td> 
			</tr> 
			<tr>  <td>&nbsp;</td> <td>&nbsp;</td></tr>
			<tr><td colspan=4 style="padding-top:5px;">
				<div class="vdotline1"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" height="1"></div>
			</td></tr>
		</table>
	<? }
	$objSlaveDB->dbClose();
	?>
	</div>
</div>