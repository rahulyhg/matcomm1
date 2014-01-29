<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-20
# Project	  : MatrimonyProduct
# Filename	  : deleteconfirmation.php
#=====================================================================================================================================
# Description : display	profile delete confirmation message. 
#=====================================================================================================================================
$varRootBasePath= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsMailManager.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessUsername	= $varGetCookieInfo["USERNAME"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];

//OBJECT DECLARATION
$objDBMaster	= new MemcacheDB;
$objMailManager	= new MailManager;

$objMailManager->dbConnect('S',$varDbInfo['DATABASE']);
$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varDomainName	= $confValues['DOMAINNAME'];
$varCurrentDate	= date('Y-m-d H:i:s');
$argCondition	= "WHERE MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
$varReason		= $_REQUEST["reason"];
$varComments	= $_REQUEST["comments"];

if($sessMatriId == ""){ echo '<script language="javascript">document.location.href="index.php"</script>'; }//if


//SETING MEMCACHE KEY
$varOwnProfileMCKey		= 'ProfileInfo_'.$sessMatriId;

if($_REQUEST['updatestatus'] == 'yes') {

	//SELECT MEMBERLOGIN INFO
	$argFields					= array('Email','Password','User_Name');
	$varSelectLoginInfoResult	= $objDBMaster->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
	if(mysql_num_rows($varSelectLoginInfoResult)==1){
		$varSelectLoginInfo			= mysql_fetch_array($varSelectLoginInfoResult);

		//SELECT MEMBER FAMILY INFO
		$argFields					= array('Family_Value','Family_Type','Family_Status');
		$varSelectFamilyInfoResult	= $objDBMaster->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
		$varSelectFamilyInfo		= mysql_fetch_array($varSelectFamilyInfoResult);

		//SELECT MEMBERINFO
		$argFields					= array('Name','Age','Dob','Gender','Marital_Status','No_Of_Children','Children_Living_Status','Religion','Country','Resident_Status','Citizenship','Employed_In','Height','Height_Unit','Physical_Status','Education_Category','Education_Detail','Occupation','Occupation_Detail','Mother_TongueId','Residing_State','Residing_Area','Residing_City','Residing_District','About_Myself','Profile_Created_By','Support_Comments','Date_Created','Paid_Status','Valid_Days','Last_Payment','Number_Of_Payments');
		$varSelectMemberInfoResult	= $objDBMaster->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varSelectMemberInfo		= mysql_fetch_array($varSelectMemberInfoResult);

		if ($varSelectMemberInfo['Country']==98 || $varSelectMemberInfo['Country']==222) { $varResidingState = $varMemberInfo['Residing_State'];} //if
		else {$varResidingState = $varMemberInfo['Residing_Area'];} 

		if($varSelectMemberInfo["Country"]==98) { $varCityValue = $varSelectMemberInfo["Residing_District"]; } else { $varCityValue = $varSelectMemberInfo["Residing_City"]; }
		
		//INSERT ALL SELECTED TO memberdeletedinfo TABLE
		$varIPAddress = getenv('REMOTE_ADDR');
		$argFields 			= array('MatriId','Email','Password','Date_Created','Name','Age','Dob','Gender','Marital_Status','No_Of_Children','Children_Living_Status','Religion','Country','Resident_Status','Citizenship','Employed_In','Height','Height_Unit','Physical_Status','Education_Category','Education_Detail','Occupation','Occupation_Detail','Mother_Tongue','Residing_State','Residing_City','About_Myself','Profile_Created_By','Family_Value','Family_Type','Family_Status','Deleted_Reason','Deleted_Comments','Support_Comments','Date_Deleted','User_Name','Paid_Status','Valid_Days','Last_Payment','Number_Of_Payments','IPAddress');
		$argFieldsValues	= array($objDBMaster->doEscapeString($sessMatriId,$objDBMaster),"'".$varSelectLoginInfo["Email"]."'","'".$varSelectLoginInfo["Password"]."'","'".$varSelectMemberInfo["Date_Created"]."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["Name"])))."'","'".$varSelectMemberInfo["Age"]."'","'".$varSelectMemberInfo["Dob"]."'","'".$varSelectMemberInfo["Gender"]."'","'".$varSelectMemberInfo["Marital_Status"]."'","'".$varSelectMemberInfo["No_Of_Children"]."'","'".$varSelectMemberInfo["Children_Living_Status"]."'","'".$varSelectMemberInfo["Religion"]."'","'".$varSelectMemberInfo["Country"]."'","'".$varSelectMemberInfo["Resident_Status"]."'","'".$varSelectMemberInfo["Citizenship"]."'","'".$varSelectMemberInfo["Employed_In"]."'","'".$varSelectMemberInfo["Height"]."'","'".$varSelectMemberInfo["Height_Unit"]."'","'".$varSelectMemberInfo["Physical_Status"]."'","'".$varSelectMemberInfo["Education_Category"]."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["Education_Detail"])))."'","'".$varSelectMemberInfo["Occupation"]."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["Occupation_Detail"])))."'","'".$varSelectMemberInfo["Mother_TongueId"]."'","'".addslashes(strip_tags(trim($varResidingState)))."'","'".addslashes(strip_tags(trim($varCityValue)))."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["About_Myself"])))."'","'".$varSelectMemberInfo["Profile_Created_By"]."'","'".$varSelectFamilyInfo["Family_Value"]."'","'".$varSelectFamilyInfo["Family_Type"]."'","'".$varSelectFamilyInfo["Family_Status"]."'","'".addslashes(strip_tags(trim($varReason)))."'","'".addslashes(strip_tags(trim($varComments)))."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["Support_Comments"])))."'","'".$varCurrentDate."'","'".addslashes(strip_tags(trim($varSelectLoginInfo["User_Name"])))."'","'".$varSelectMemberInfo["Paid_Status"]."'","'".$varSelectMemberInfo["Valid_Days"]."'","'".$varSelectMemberInfo["Last_Payment"]."'","'".$varSelectMemberInfo["Number_Of_Payments"]."'","'".$varIPAddress."'");
		$varInsertedId		= $objDBMaster->insert($varTable['MEMBERDELETEDINFO'],$argFields,$argFieldsValues);

		if($varReason == 1) {
			$objMailManager->sendProfileDeletedMail($sessMatriId,$varSelectMemberInfo['Name'],$confValues['SERVERURL']); 
		}

		$argCondition		= "MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);

		//DELETE profilematchinfo INFO
		$argProfilematchCond = $varWhereClause.' AND '.$argCondition;
		$objDBMaster->delete($varTable['PROFILEMATCHINFO'],$argProfilematchCond);

		//DELETE blockinfo INFO
		$objDBMaster->delete($varTable['BLOCKINFO'],$argCondition);

		//DELETE bookmarkinfo INFO
		$objDBMaster->delete($varTable['BOOKMARKINFO'],$argCondition);

		//DELETE ignoreinfo INFO
		$objDBMaster->delete($varTable['IGNOREINFO'],$argCondition);

		//DELETE interestsenttrackinfo INFO
		$objDBMaster->delete($varTable['INTERESTSENTTRACKINFO'],$argCondition);

		//DELETE maildraftinfo INFO
		$objDBMaster->delete($varTable['MAILDRAFTINFO'],$argCondition);

		//DELETE mailfolderinfo INFO
		$objDBMaster->delete($varTable['MAILFOLDERINFO'],$argCondition);

		//DELETE mailmanagerinfo INFO
		$objDBMaster->delete($varTable['MAILMANAGERINFO'],$argCondition);

		//DELETE mailsenttrackinfo INFO
		$objDBMaster->delete($varTable['MAILSENTTRACKINFO'],$argCondition);

		//DELETE memberactioninfo INFO
		$objDBMaster->delete($varTable['MEMBERACTIONINFO'],$argCondition);

		//DELETE memberfamilyinfo INFO
		$objDBMaster->delete($varTable['MEMBERFAMILYINFO'],$argCondition);

		//DELETE memberhobbiesinfo INFO
		$objDBMaster->delete($varTable['MEMBERHOBBIESINFO'],$argCondition);

		//DELETE memberfilterinfo INFO
		$objDBMaster->delete($varTable['MEMBERFILTERINFO'],$argCondition);

		//DELETE memberinfo INFO
		$objDBMaster->delete($varTable['MEMBERINFO'],$argCondition,$varOwnProfileMCKey);

		//DELETE memberlogininfo INFO
		$objDBMaster->delete($varTable['MEMBERLOGININFO'],$argCondition);

		//DELETE memberpartnerinfo INFO
		$objDBMaster->delete($varTable['MEMBERPARTNERINFO'],$argCondition);

		//DELETE memberphotoinfo INFO
		$objDBMaster->delete($varTable['MEMBERPHOTOINFO'],$argCondition);	
		
		//DELETE memberprofileviewedinfo INFO
		$objDBMaster->delete($varTable['MEMBERPROFILEVIEWEDINFO'],$argCondition);

		//DELETE memberstatistics INFO
		$objDBMaster->delete($varTable['MEMBERSTATISTICS'],$argCondition);

		//DELETE memberupdatedinfo INFO
		$objDBMaster->delete($varTable['MEMBERUPDATEDINFO'],$argCondition);

		//DELETE searchsavedinfo INFO
		$objDBMaster->delete($varTable['SEARCHSAVEDINFO'],$argCondition);

		//DELETE requestinfosent INFO
		$argCondition			= "SenderId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$objDBMaster->delete($varTable['REQUESTINFOSENT'],$argCondition);

		//DELETE requestinforeceived INFO
		$argCondition		= "ReceiverId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$objDBMaster->delete($varTable['REQUESTINFORECEIVED'],$argCondition);
	}
	$varDisplayMessage	= 'Your profile has been successfully deleted. Thank you for using our services.';
	$varDisplayButton	= '<input type="button" class="button pntr" value="Close" onclick="redirectLogin(\''.$varReason.'\');">';

	setrawcookie("browsertime",false,time() - 36, "/",$varDomainName);
	setrawcookie("loginInfo",false,time() - 36, "/",$varDomainName);
	setrawcookie("profileInfo",false,time() - 36, "/",$varDomainName);
	setrawcookie("partnerInfo",false, time() - 36, "/",$varDomainName);
	setrawcookie("messagesInfo",false, time() - 36, "/",$varDomainName);
	setrawcookie("savedSearchInfo",false,time() - 36,"/",$varDomainName);
	setrawcookie("lastViewProfile",false,time() - 36, "/",$varDomainName);
	setrawcookie("requestReceivedInfo",false,time() - 36, "/",$varDomainName);
	setrawcookie("requestSentInfo",false,time() - 36, "/",$varDomainName);
	setrawcookie("listInfo",false,time() - 36, "/",$varDomainName);
	setrawcookie("viewsInfo",false,time() - 36, "/",$varDomainName);

	$_COOKIE['loginInfo']			= '';
	$_COOKIE['profileInfo']			= '';
	$_COOKIE['partnerInfo']			= '';
	$_COOKIE['messagesInfo']		= '';
	$_COOKIE['savedSearchInfo']		= '';
	$_COOKIE['lastViewProfile']		= '';
	$_COOKIE['requestReceivedInfo']	= '';
	$_COOKIE['requestSentInfo']		= '';
	$_COOKIE['listInfo']			= '';
	$_COOKIE['viewsInfo']			= '';
	$varGetCookieInfo['MATRIID']	= '';
}

//Close Slave Db Connection
$objMailManager->dbClose();
$objDBMaster->dbClose();
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/changepass.js"></script>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
<?if($_COOKIE['loginInfo'] == '') { ?>
<script language="javascript">
parent.document.getElementById('closeicon').innerHTML = '';
</script>

<div class="brdr pad10 alerttxt">
	<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="hidediv('confirm');" ></div><br clear="all">
	<div class="pad5 smalltxt"><?=$varDisplayMessage?></div><br clear="all">
	<div class="fright"><?=$varDisplayButton?>	</div>
</div>
	
<? }?>