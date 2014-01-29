<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		: 
#================================================================================================================
   # Description	: 
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

//SESSION VARIABLES
//Object initialization
$objSlaveDB			= new MemcacheDB;
$objMasterDB		= new MemcacheDB;
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$varMasterConn		= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

$sessMatriId		= $varGetCookieInfo['MATRIID'];
$varGender			= $varGetCookieInfo["GENDER"];
$varMemberStatus 	= $varGetCookieInfo['PUBLISH'];
$varOppsiteId		= $_REQUEST['id'];

//SETING MEMCACHE KEY
$varOppositeProfileMCKey= 'ProfileInfo_'.$varOppsiteId;

$varCondition		= " WHERE MatriId = ".$objSlaveDB->doEscapeString($varOppsiteId,$objSlaveDB)." AND ".$varWhereClause;
$varFields			= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
$varMemberInfo		= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0, $varOppositeProfileMCKey);
$varOppsiteUName	= $varMemberInfo['MatriId'];	

if($sessMatriId == $varMemberInfo['MatriId'] ) { 
		
	if($varMemberInfo['Phone_Verified'] == 1 || $varMemberInfo['Phone_Verified'] == 3) {
		$varTableName	= $varTable['ASSUREDCONTACT'];
	} else {
		$varTableName	= $varTable['ASSUREDCONTACTBEFOREVALIDATION'];
	}
	//Get Phone No
	$argFields				= array('PhoneNo1');
	$argCondition			= "WHERE MatriId = ".$objSlaveDB->doEscapeString($varMemberInfo['MatriId'],$objSlaveDB);
	$varAssuredContactResSet= $objSlaveDB->select($varTableName,$argFields,$argCondition,0);
	$varAssuredContact		= mysql_fetch_assoc($varAssuredContactResSet);
	$varSelPhone			= $varAssuredContact["PhoneNo1"];
	
	if(trim($varSelPhone) != ''){ ?>
	<div class="tlright vpdiv6 padtb3 fleft">Phone Number :</div>
	<div class="vpdiv6a padl310 fleft"><?=eregi_replace("~","-",eregi_replace("~~","~",$varSelPhone))?></div>
	<br clear="all">
	<?}?>

<? } elseif($varMemberInfo['Gender'] == $varGender && $sessMatriId != $varMemberInfo['MatriId']) {?>
	 Sorry, only members of the opposite gender can view the phone number of <?=$varOppsiteUName;?>
<?} elseif($sessMatriId != '' && $sessMatriId != $varMemberInfo['MatriId'] && ($varMemberInfo['Phone_Verified'] == 1 || $varMemberInfo['Phone_Verified'] == 3)) {
	$varFields 			= array('MatriId','Opposite_MatriId','Date_Viewed');
	$varFieldValues		= array($objMasterDB->doEscapeString($varMemberInfo['MatriId'],$objMasterDB),$objMasterDB->doEscapeString($sessMatriId,$objMasterDB),"NOW()");
	$varFormResult		= $objMasterDB->insertOnDuplicate($varTable['PHONEVIEWLIST'], $varFields, $varFieldValues, '');

	//Get Phone No
	$argFields				= array('PhoneNo1');
	$argCondition			= "WHERE MatriId = ".$objSlaveDB->doEscapeString($varMemberInfo['MatriId'],$objSlaveDB);
	$varAssuredContactResSet= $objSlaveDB->select($varTable['ASSUREDCONTACT'],$argFields,$argCondition,0);
	$varAssuredContact		= mysql_fetch_assoc($varAssuredContactResSet);
	
	if(trim($varAssuredContact["PhoneNo1"]) != ''){ 
		echo '<br clear="all"><div class="tlright vpdiv6 padtb3 fleft">Phone Number :</div><div class="vpdiv6a padl310 fleft">'.eregi_replace("~","-",eregi_replace("~~","~",$varAssuredContact["PhoneNo1"])).'</div>';
	}?>
	<br clear="all">
	<?
}
//UNSET OBJ
$objSlaveDB->dbClose();
$objMasterDB->dbClose();
unset($objSlaveDB);
unset($objMasterDB);
?>