<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : primaryinfodesc.php
#=====================================================================================================================================
# Description : display information of primary info. It has primary info form and update function primary information.
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
//include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/tblfields.cil14');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessGender 	= $varGetCookieInfo["GENDER"];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];

//OBJECT DECLARTION
//$objDBSlave	= new DB;
$objDBSlave	= new MemcacheDB;
$objCommon	= new clsCommon;
$objDomain	= new domainInfo;

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['primaryinfosubmit'];

//DELETE array value
unset($arrPhysicalStatusList['2']);

function getPinNo($objMasterDBConn,$phonePinTable) {

	$funQuery	= "LOCK TABLES ".$phonePinTable." WRITE";
	mysql_query($funQuery);

	$argFields			= array('PinNo');
	$argCondition		= "WHERE UsedStatus=0 LIMIT 0,1";
	$varPinInfoResultSet= $objMasterDBConn->select($phonePinTable,$argFields,$argCondition,0);
	$varPinInfoResult	= mysql_fetch_assoc($varPinInfoResultSet);

	$varPhonePinNo		= $varPinInfoResult["PinNo"];

	$argFields 			= array('UsedStatus');
	$argFieldsValues	= array(1);
	$argCondition		= " PinNo=".$varPhonePinNo;
	$varUpdateId		= $objMasterDBConn->update($phonePinTable,$argFields,$argFieldsValues,$argCondition);

	$funQuery	= "UNLOCK TABLES";
	mysql_query($funQuery);

	return $varPhonePinNo;
}

if($varUpdatePrimary == 'yes') {

	//$objDBMaster = new DB;
	$objDBMaster = new MemcacheDB;
	$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	$varEditedName				= trim($_REQUEST["name"]);
	$varEditedNickName			= trim($_REQUEST["nickname"]);
	$varEditedName				= ($varEditedName=='')?$varEditedNickName:$varEditedName;
	$varEditedPassword			= trim($_REQUEST["cpassword"]);
	$varEditedAge				= trim($_REQUEST["age"]);
	$varEditedGender			= $_REQUEST["gender"];
	$varEditedDobYear			= $_REQUEST["dobYear"];
	$varEditedDobMonth			= $_REQUEST["dobMonth"];
	$varEditedDobDay			= $_REQUEST["dobDay"];
	$varEditedDob				= $varEditedDobYear."-".$varEditedDobMonth."-".$varEditedDobDay;
	$varEditedEmail				= trim($_REQUEST["email"]);

	$varEditedCountryCode		= trim($_REQUEST['countryCode']);
	$varEditedCountryCode		= ($varEditedCountryCode != 'ISD' && $varEditedCountryCode != '')?$varEditedCountryCode:'';
	$varEditedAreaCode			= trim($_REQUEST['areaCode']);
	$varEditedAreaCode			= ($varEditedAreaCode != 'STD' && $varEditedAreaCode != '')?$varEditedAreaCode:'';
	$varEditedPhoneNo			= trim($_REQUEST['phoneNo']);
	$varEditedPhoneNo			= ($varEditedPhoneNo != 'Telephone number' && $varEditedPhoneNo != '')?$varEditedPhoneNo:'';
	$varEditedMobileNo			= trim($_REQUEST['mobileNo']);
	$varEditedMobileNo			= ($varEditedMobileNo != 'Mobile number' && $varEditedMobileNo != '')?$varEditedMobileNo:'';

	if ($varEditedAge !="" && $varEditedDob!='--') {  $varEditedAge = $varEditedAge;}
	else if ($varEditedAge !="" && $varEditedDob=='--') {  $varEditedAge = $varEditedAge; $varEditedDob="";}
	else { $varEditedAge = $objCommon->ageCalculate($varEditedDobYear, $varEditedDobMonth, $varEditedDobDay); }


	if($sessMatriId != '') {
		$argCondition	= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);

		//Check email has changed or not
		if($varEditedEmail != trim($_REQUEST['oldemail'])) {

			//$varBlockedEmail	= 'no';
			//CHECK ALREADY REGISTERED PROFILES WITH EMAIL AND GENDER (ALLOW 1 TIMES)
			//$varBlockedEmail	= $objRegister->blockedEmail($varEditedEmail,$confValues['GETBLOCKEDEMAILSDIR']);

			$argTblName			= $varTable['MEMBERLOGININFO'].' mli,'. $varTable['MEMBERINFO'] .' mi';
			$argEmailCondition	= "WHERE mli.Email=".$objDBMaster->doEscapeString($varEditedEmail,$objDBMaster)." AND mi.CommunityId='".$arrDomainInfo[$varDomain][0]."' AND mli.MatriId = mi.MatriId AND mi.MatriId!=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
			$varNoOfTimeOccurs	= $objDBMaster->numOfRecords($argTblName, $argPrimary='mli.MatriId', $argEmailCondition);

			if ($varNoOfTimeOccurs==0) {
				//update email
				$argFields 		= array('Email','Date_Updated');
				$argFieldsValues= array($objDBMaster->doEscapeString($varEditedEmail,$objDBMaster),"NOW()");
				$varUpdateId	= $objDBMaster->update($varTable['MEMBERLOGININFO'],$argFields,$argFieldsValues,$argCondition);

				//UPDATE PHONE VERIFIED FLAG IN MEMBERINFO TABLE
				$argFields 		= array('Email_Verified','Date_Updated');
				$argFieldsValues= array(0,"NOW()");
				$varUpdateId	= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
			} else {
				$varErrorMessage	= "Email ID already exists.";
			}
		}

		if($varErrorMessage == '') {
			//Check phone no has changed or not
			if($varEditedCountryCode != trim($_REQUEST['oldCC']) || $varEditedAreaCode != trim($_REQUEST['oldAC']) || $varEditedPhoneNo != trim($_REQUEST['oldPhone']) || $varEditedMobileNo != trim($_REQUEST['oldMobile'])) {
				if($varEditedAreaCode != '') { $varLandLineNo = $varEditedCountryCode.'~'.$varEditedAreaCode.'~'.$varEditedPhoneNo; }
				if($varEditedMobileNo !='') { $varMobileNo = $varEditedCountryCode.'~'.$varEditedMobileNo; }

				//CHECK WHETHER RECORD IS AVAILABLE OR NOT FOR THIS USER
				$argSelCondition= "WHERE MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBSlave);
				$varRecordAvail	= $objDBSlave->numOfRecords($varTable['ASSUREDCONTACTBEFOREVALIDATION'],'MatriId',$argSelCondition);

				if($varMobileNo != trim($_REQUEST['oldAssuredNo'])) {
					$varPhoneNumber	= ($varEditedMobileNo !='')?$varMobileNo:$varLandLineNo;

					if($varRecordAvail == 1) {
						$argFields 		= array('TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1');
						$argFieldsValues= array("NOW()",$objDBMaster->doEscapeString($varEditedCountryCode,$objDBMaster),$objDBMaster->doEscapeString($varEditedAreaCode,$objDBMaster),$objDBMaster->doEscapeString($varEditedPhoneNo,$objDBMaster),$objDBMaster->doEscapeString($varEditedMobileNo,$objDBMaster),$objDBMaster->doEscapeString($varPhoneNumber,$objDBMaster));
						$varUpdateId	= $objDBMaster->update($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argFields,$argFieldsValues,$argCondition);
					} else {
						//INSERT INTO assuredcontactbeforevalidation
						$varPinNo		= getPinNo($objDBMaster,$varTable['ASSUREDCONTACTPINNOSERIES']);
						$argFields		= array('PinNo','MatriId','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1');
						$argFieldsValues= array($objDBMaster->doEscapeString($varPinNo,$objDBMaster),$objDBMaster->doEscapeString($sessMatriId,$objDBMaster),"NOW()",$objDBMaster->doEscapeString($varEditedCountryCode,$objDBMaster),$objDBMaster->doEscapeString($varEditedAreaCode,$objDBMaster),$objDBMaster->doEscapeString($varEditedPhoneNo,$objDBMaster),$objDBMaster->doEscapeString($varEditedMobileNo,$objDBMaster),$objDBMaster->doEscapeString($varPhoneNumber,$objDBMaster),"'0'");
						$varInsertId	= $objDBMaster->insert($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argFields,$argFieldsValues);
					}
				} else {
					if($varRecordAvail == 1) {
						$varTableName	= $varTable['ASSUREDCONTACTBEFOREVALIDATION'];
					} else {
						$varTableName	= $varTable['ASSUREDCONTACT'];
					}
					$argFields 		= array('CountryCode','AreaCode','PhoneNo');
					$argFieldsValues= array($objDBMaster->doEscapeString($varEditedCountryCode,$objDBMaster),$objDBMaster->doEscapeString($varEditedAreaCode,$objDBMaster),$objDBMaster->doEscapeString($varEditedPhoneNo,$objDBMaster));
					$varUpdateId	= $objDBMaster->update($varTableName,$argFields,$argFieldsValues,$argCondition);
				}

				//UPDATE PHONE VERIFIED FLAG IN MEMBERINFO TABLE
				$argFields 		= array('Contact_Phone','Contact_Mobile','Phone_Verified','Date_Updated');
				$argFieldsValues= array($objDBMaster->doEscapeString($varLandLineNo,$objDBMaster),$objDBMaster->doEscapeString($varMobileNo,$objDBMaster),0,"NOW()");
				$varUpdateId	= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
			}



			//Update Password
			if($varEditedPassword!='') {
				$argFields 		= array('Password','Date_Updated');
				$argFieldsValues= array($objDBMaster->doEscapeString($varEditedPassword,$objDBMaster),"NOW()");
				$varUpdateId	= $objDBMaster->update($varTable['MEMBERLOGININFO'],$argFields,$argFieldsValues,$argCondition);
			}

            $argFields			= array('Dob','Date_Updated');
			$argFieldsValues	= array($objDBMaster->doEscapeString($varEditedDob,$objDBMaster),'NOW()');

			if($varEditedDob != '') {
				array_push($argFields,'Age');
				array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedAge,$objDBMaster));
			}

			if($varEditedGender != '') {
				array_push($argFields,'Gender');
				array_push($argFieldsValues,$varEditedGender);
			}

			$varUpdateId	= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);

			// NOT VALIDATED MEMBER COMMIT OTHER DETAILS DIRECTLY
			if($sessPublish == 0 || $sessPublish == 4) {
				$argFields 			= array('Name','Nick_Name','Age');
				$argFieldsValues	= array($objDBMaster->doEscapeString($varEditedName,$objDBMaster),$objDBMaster->doEscapeString($varEditedNickName,$objDBMaster),$objDBMaster->doEscapeString($varEditedAge,$objDBMaster));

				if($sessPublish == 4) {
					array_push($argFields,'Publish');
					array_push($argFieldsValues,'0');
				}

				$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
			} else {

				if(trim(($_REQUEST['oldname']) != $varEditedName) || trim(($_REQUEST['oldnickname']) != $varEditedNickName) || ((trim($_REQUEST['oldage']) != $varEditedAge) && $varEditedDob=='')) {

					$argFields 			= array('MatriId');
					$argFieldsValues	= array($objDBMaster->doEscapeString($sessMatriId,$objDBMaster));
					$varInsertedId		= $objDBMaster->insertIgnore($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues);

					$argFields 			= array('Date_Updated');
					$argFieldsValues	= array('NOW()');

					if(trim($_REQUEST['oldname']) != $varEditedName) {
						array_push($argFields,'Name');
						array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedName,$objDBMaster));
					}

					if(trim($_REQUEST['oldnickname']) != $varEditedNickName) {
						array_push($argFields,'Nick_Name');
						array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedNickName,$objDBMaster));
					}

					if($varEditedDob == '' && (trim($_REQUEST['oldage']) != $varEditedAge)) {
						array_push($argFields,'Age');
						array_push($argFieldsValues,$objDBMaster->doEscapeString($varEditedAge,$objDBMaster));
					}

					$varUpdateId	= $objDBMaster->update($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues,$argCondition);

					$argFields 			= array('Pending_Modify_Validation');
					$argFieldsValues	= array(1);
					$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
				}
			}

			$argFields 			= array('Family_Set_Status','Date_Updated','Time_Posted');
			$argFieldsValues	= array('1','NOW()','NOW()');
			$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
		}

		$objDBMaster->dbClose();
	}
} else {

	$argFields				= $arrMEMBERINFOfields;
	$argCondition			= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave)." AND ".$varWhereClause;
	$varMemberInfo			= $objDBSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varOwnProfileMCKey);

	$argFields				= array('Email','Password');
	$argCondition			= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
	$varMemberLoginInfoRes	= $objDBSlave->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
	$varMemberLoginInfo		= mysql_fetch_assoc($varMemberLoginInfoRes);

	$argFields						= array('PhoneNo1','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneStatus1','PinNo');
	$varAssuredContactInfoRes		= $objDBSlave->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argFields,$argCondition,0);
	$varAssuredContactInfo			= mysql_fetch_assoc($varAssuredContactInfoRes);

	if($varAssuredContactInfo['PhoneNo1'] != '') {
		$varAssuredNo	= $varAssuredContactInfo['PhoneNo1'];
		$varCountryCode	= $varAssuredContactInfo['CountryCode'];
		$varAreaCode	= $varAssuredContactInfo['AreaCode'];
		$varPhoneNo		= $varAssuredContactInfo['PhoneNo'];
		$varMobileNo	= $varAssuredContactInfo['MobileNo'];
		$varPhoneStatus	= $varAssuredContactInfo['PhoneStatus1'];
		$varSelPinNo	= $varAssuredContactInfo['PinNo'];
	} else {
		$argFields						= array('PhoneNo1','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneStatus1','PinNo');
		$varAssuredContactInfoRes		= $objDBSlave->select($varTable['ASSUREDCONTACT'],$argFields,$argCondition,0);
		$varAssuredContactInfo			= mysql_fetch_assoc($varAssuredContactInfoRes);
		$varAssuredNo					= $varAssuredContactInfo['PhoneNo1'];
		$varCountryCode					= $varAssuredContactInfo['CountryCode'];
		$varAreaCode					= $varAssuredContactInfo['AreaCode'];
		$varPhoneNo						= $varAssuredContactInfo['PhoneNo'];
		$varMobileNo					= $varAssuredContactInfo['MobileNo'];
		$varPhoneStatus					= $varAssuredContactInfo['PhoneStatus1'];
	}

	$varEmail			= $varMemberLoginInfo['Email'];
	$varOldPassword		= $varMemberLoginInfo['Password'];

	$varEmailFlag       = $varMemberInfo['Email_Verified'];
	$varName			= stripslashes(trim($varMemberInfo['Name']));
	$varNickName		= stripslashes(trim($varMemberInfo['Nick_Name']));
	$varGender			= $varMemberInfo['Gender'];
	$varAge				= $varMemberInfo['Age'];
	$varPhoneProtected	= $varMemberInfo['Phone_Protected'];
	$arrDob				= explode('-',$varMemberInfo['Dob']);
	$varYear			= $arrDob[0];
	$varMonth			= $arrDob[1];
	$varDay				= $arrDob[2];

	if($varPhoneProtected==1) {
		$varPhoneHideClass	= "fleft disnon";
		$varPhoneUnHideClass= "fleft disblk";
	} else {
		$varPhoneHideClass	= "fleft disblk";
		$varPhoneUnHideClass= "fleft disnon";
	}

}

$objDBSlave	->dbClose();

//Getting start age for male & female
$varMaleStartAge	= $objDomain->getMStartAge();
$varFemaleStartAge	= $objDomain->getFStartAge();
?>
<script>var starmtage=<?=$varMaleStartAge?>,starfmtage=<?=$varFemaleStartAge?></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/primaryinfo.js" ></script>
	<? include_once('settingsheader.php');?>
		<div class="padt10">
			<?if($varErrorMessage != '') { ?>
			<div class='fleft' style='width:490px;'>
				<?=$varErrorMessage;?>
			</div>
			<? } else if($varUpdatePrimary == 'yes') { ?>
			<div class='fleft' style='width:490px;'>
				Your primary information has been modified successfully.
				<br><br><font class='errortxt'><b>Any text changes will have to be validated before it is updated on your profile. It usually takes 24 hours.</b></font>
			</div>
			<? } else { ?>
			<form method='post' name='frmProfile' style="padding:0px; margin:0px;" onsubmit='return ProfileValidate();'>
			<input type='hidden' name='act' value='primaryinfo'>
			<input type='hidden' name='primaryinfosubmit' value='yes'>
			<input type='hidden' name='oldgender' value="<?=$varGender?>">
			<input type='hidden' name='oldname' value='<?=htmlentities($varName,ENT_QUOTES);?>'>
			<input type='hidden' name='oldnickname' value='<?=htmlentities($varNickName,ENT_QUOTES);?>'>
			<input type='hidden' name='oldpassword' value='<?=addslashes(strip_tags(trim($varOldPassword)));?>'>
			<input type='hidden' name='oldage' value='<?=addslashes(strip_tags(trim($varAge)));?>'>
			<input type='hidden' name='oldemail' value='<?=addslashes(strip_tags(trim($varEmail)));?>'>
			<input type='hidden' name='oldCC' value='<?=addslashes(strip_tags(trim($varCountryCode)))?>'>
			<input type='hidden' name='oldAC' value='<?=addslashes(strip_tags(trim($varAreaCode)))?>'>
			<input type='hidden' name='oldPhone' value='<?=addslashes(strip_tags(trim($varPhoneNo)))?>'>
			<input type='hidden' name='oldMobile' value='<?=addslashes(strip_tags(trim($varMobileNo)))?>'>
			<input type='hidden' name='oldAssuredNo' value='<?=addslashes(strip_tags(trim($varAssuredNo)))?>'>
			<input type='hidden' name='matriid' value='<?=$sessMatriId?>'>
			<input type='hidden' name='emaildup' value=''>

			<!-- alert action div starts-->
			<div id="alrtdiv" class="boxdiv brdr"  style="background-color:#EEEEEE;padding-left:0px;visibility:hidden;position:absolute;">
				<center><div id="rsltdiv" class="disnon"></div></center>
				<div id="hphone" class="disnon"><div class='fright tlright'><img src='<?=$confValues['IMGSURL']?>/close.gif' class='pntr' onclick="hide_box_div('alrtdiv');"/></div><br clear='all'>
				<div class="tlleft padl25">Are you sure you want to hide your phone number?</div><div class="cleard"></div>
				<div class='fright tlright'><input type="button" class="button" value="Hide Now" onclick="phoneprotect('1');"></div>
				</div>
				<div id="uhphone" class="disnon">
				<div class='fright tlright'><img src='<?=$confValues['IMGSURL']?>/close.gif' class='pntr' onclick="hide_box_div('alrtdiv');"/></div><br clear='all'>
				<div class="tlleft padl25">By clicking on the "Unhide Now" button, your phone number will be displayed to paid members</div><div class="cleard"></div>
				<div class='fright tlright'><input type="button" class="button" value="Unhide Now" onclick="phoneprotect('2');"></div>
				</div>
			</div>
			<!-- alert action div starts-->

			<div class="fright opttxt"><span class="clr3">*</span> Mandatory</div><br clear="all">

			<div class="pfdivlt smalltxt fleft tlright">Name</div>
			<div class="pfdivrt fleft tlleft"><input type='text' name='name' value='<?=htmlentities($varName,ENT_QUOTES)?>' size=30 class='inputtext'></div>
			<br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">Display name<span class="clr3">*</span></div>
			<div class="pfdivrt fleft tlleft"><input type='text' name='nickname' value='<?=htmlentities($varNickName,ENT_QUOTES)?>' size=30 class='inputtext' onblur='ChkEmpty(document.frmProfile.nickname,"text","nicknamespan","Please enter the display name of the prospect");'><br><span id="nicknamespan" class="errortxt"></span></div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">Password<span class="clr3">*</span></div>
			<div class="pfdivrt fleft tlleft"><input type='password' name='password' size=30 class='inputtext' onFocus='showConfirmPassword();'onblur='chkPassword();'><br><span id="soldpassword" class="errortxt"></span></div><br clear="all"/>

			<div id="confirmpwd" class="disnon">
				<div class="pfdivlt smalltxt fleft tlright">Confirm Password<span class="clr3">*</span></div><div class="pfdivrt fleft tlleft"><input type="password" name="cpassword" value="" size=30 class="inputtext" onBlur="chkConfirmPassword();"><br><span id="scpassword" class="errortxt"></span></div><br clear="all"/>
			</div>

            <?if(!$sessPublish) { ?>
			<div class="smalltxt fleft tlright pfdivlt">Gender<font class="clr3">*</font></div>
			<div class="fleft pfdivrt tlleft"><input type="radio" name="gender" id='gendermale' value="1" <? if($varGender=='1') { echo "CHECKED"; } ?>><font class="smalltxt"> Male</font> &nbsp;&nbsp;<input type="radio" name="gender" value="2" <? if($varGender=='2') { echo "CHECKED"; } ?>><font class="smalltxt">Female</font><br clear="all"/><span id="genderspan" class="errortxt"></span></div><br clear="all"/>
            <? } ?>

			<div class="smalltxt fleft tlright pfdivlt">Age<span class="clr3">*</span></div>
			<div class="fleft pfdivrt tlleft">
				<select class='inputtext' NAME='dobMonth' size='1' style='width:80px;' Onchange='agesel();updateDay("month","frmProfile","dobYear","dobMonth","dobDay");'>
					<option value=''>-Month-</option>
					 <?=$objCommon->monthDropdown($varMonth)?>
					</select>
				<select name='dobDay' class='inputtext' style='width:55px;' onChange='agesel();'>
					<option value='' selected>-Date-</option>
					<option value='1' <?=$varDay=='01' ? 'selected' : '';?>>1</option>
					<option value='2' <?=$varDay=='02' ? 'selected' : '';?>>2</option>
					<option value='3' <?=$varDay=='03' ? 'selected' : '';?>>3</option>
					<option value='4' <?=$varDay=='04' ? 'selected' : '';?>>4</option>
					<option value='5' <?=$varDay=='05' ? 'selected' : '';?>>5</option>
					<option value='6' <?=$varDay=='06' ? 'selected' : '';?>>6</option>
					<option value='7' <?=$varDay=='07' ? 'selected' : '';?>>7</option>
					<option value='8' <?=$varDay=='08' ? 'selected' : '';?>>8</option>
					<option value='9' <?=$varDay=='09' ? 'selected' : '';?>>9</option>
					<option value='10' <?=$varDay=='10' ? 'selected' : '';?>>10</option>
					<option value='11' <?=$varDay=='11' ? 'selected' : '';?>>11</option>
					<option value='12' <?=$varDay=='12' ? 'selected' : '';?>>12</option>
					<option value='13' <?=$varDay=='13' ? 'selected' : '';?>>13</option>
					<option value='14' <?=$varDay=='14' ? 'selected' : '';?>>14</option>
					<option value='15' <?=$varDay=='15' ? 'selected' : '';?>>15</option>
					<option value='16' <?=$varDay=='16' ? 'selected' : '';?>>16</option>
					<option value='17' <?=$varDay=='17' ? 'selected' : '';?>>17</option>
					<option value='18' <?=$varDay=='18' ? 'selected' : '';?>>18</option>
					<option value='19' <?=$varDay=='19' ? 'selected' : '';?>>19</option>
					<option value='20' <?=$varDay=='20' ? 'selected' : '';?>>20</option>
					<option value='21' <?=$varDay=='21' ? 'selected' : '';?>>21</option>
					<option value='22' <?=$varDay=='22' ? 'selected' : '';?>>22</option>
					<option value='23' <?=$varDay=='23' ? 'selected' : '';?>>23</option>
					<option value='24' <?=$varDay=='24' ? 'selected' : '';?>>24</option>
					<option value='25' <?=$varDay=='25' ? 'selected' : '';?>>25</option>
					<option value='26' <?=$varDay=='26' ? 'selected' : '';?>>26</option>
					<option value='27' <?=$varDay=='27' ? 'selected' : '';?>>27</option>
					<option value='28' <?=$varDay=='28' ? 'selected' : '';?>>28</option>
					<option value='29' <?=$varDay=='29' ? 'selected' : '';?>>29</option>
					<option value='30' <?=$varDay=='30' ? 'selected' : '';?>>30</option>
					<option value='31' <?=$varDay=='31' ? 'selected' : '';?>>31</option>
				</select>
				<select name='dobYear' class='inputtext' style='width:60px;' onChange='agesel();updateDay("year","frmProfile","dobYear","dobMonth","dobDay");' >
					<option value='0'>-Year-</option>
					<?=$objCommon->getYears($varYear);?>
				</select>&nbsp; or&nbsp;&nbsp;<input type=text name=age value="<?=$varAge?>" size=2 maxlength=2 class='inputtext' onfocus='agefocus()' onkeypress='agefocus()' onblur='ChkEmpty(document.frmProfile.age,"text","agespan","Please enter the age or select the date of birth of the prospect");' AUTOCOMPLETE="OFF">&nbsp;yrs<br><span id="agespan" class="errortxt"></span>
			</div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">E-mail<span class="clr3">*</span></div>
			<div class="pfdivrt fleft tlleft"><input type='text' name='email' value='<?=$varEmail?>' size=30 class='inputtext' onBlur="emailChk();"> &nbsp; <br><span id="emailspan" class="errortxt"></span></div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">Phone Number<span class="clr3">*</span></div>
			<div class="pfdivrt fleft tlleft">
				<div class="fleft"><input type='text' onKeypress="return allowNumeric(event);" name='countryCode' value='<?=$varCountryCode?>' size=1 class='inputtext'>
				<input type='text' onKeypress="return allowNumeric(event);" name='areaCode' value='<?=($varAreaCode!='')?$varAreaCode:'STD';?>' size=2 class='inputtext' onFocus="if(this.value=='STD'){this.value='';}" onBlur="if(this.value==''){this.value='STD';}">
				<input type='text' onKeypress="return allowNumeric(event);" name='phoneNo' value='<?=($varPhoneNo!='')?$varPhoneNo:'Telephone number';?>' size=10 class='inputtext' onFocus="if(this.value=='Telephone number'){this.value='';}" onBlur="if(this.value==''){this.value='Telephone number';}"> (or)
				<input type='text' onKeypress="return allowNumeric(event);" name='mobileNo' value='<?=($varMobileNo!='')?$varMobileNo:'Mobile number';?>' size=10 class='inputtext' onFocus="if(this.value=='Mobile number'){this.value='';}" onBlur="if(this.value==''){this.value='Mobile number';}">&nbsp;
				</div>

				<?if($varPhoneStatus==0) {?><div class="fleft smalltxt" style="color:#ff0000;">&nbsp;x Not verified</div><br clear="all">
					<div class="fleft">
						<font class="clr2 smalltxt">Call 1-800-3000-2222. When prompted, Press 2 on your phone. You will be asked to enter your PIN - </font>
						<font class="clr3 smalltxt"><?=$varSelPinNo?></font>
						<font class="clr2 smalltxt"> to complete your verification.</font>
					</div>
				<?}else{?>
						<div class="fleft smalltxt" style="color:#ff0000;">&nbsp;Verified</div>
						<?if($sessPaidStatus==1) {?>
							<div class="fleft clr2">&nbsp;|&nbsp;</div>
							<div id="phhide" class="<?=$varPhoneUnHideClass?>"><a class="clr1 smalltxt" href="javascript:;" onclick="show_box('event','alrtdiv'); phonehide('u');">Unhide</a></div>
							<div id="phunhide" class="<?=$varPhoneHideClass?>"><a class="clr1 smalltxt" href="javascript:;" onclick="show_box('event','alrtdiv'); phonehide('h');">Hide</a></div>
					<?}
				}?>
				<br><span id="phonespan" class="errortxt"></span>
			</div><br clear="all"/>


			<div class="normtxt clr bld fleft padl25 padt10">Follow me on Twitter</div><br clear="all"/>
				<div class="smalltxt fleft tlright pfdivlt padt20">Enter Twitter ID</div>
				<div class="fleft pfdivrt tlleft"><div class="fleft padt10"><input type=text name=twitterid id=twitterid size=32 maxlength=80 value='' class='inputtext'><br><div class="fleft alerttxt disnon" style="width:190px;" id="twitdiv"></div></div><div class="fleft padl3"><a onclick="twitterupdate('<?=$sessMatriId?>');" ><img src="<?=$confValues['IMGSURL']?>/twit_img.gif" /></a></div><div class="padt10"><a class="clr1 smalltxt" href="/site/index.php?act=twithelp">&nbsp;How it works?</a></div>
				</div><br clear="all"/>



			<div class="fright padr20 padt10">
				<input type="submit" name='sbutton' value='Save' class='button'> &nbsp;
				<input type="reset" class="button" value="Reset">
			</div>
			</form>
			<img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="gettwitter('<?=$sessMatriId?>')">
			<? } ?>
		</div>