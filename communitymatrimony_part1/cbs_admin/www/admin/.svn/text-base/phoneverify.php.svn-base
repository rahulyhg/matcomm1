<?php
#=============================================================================================================
# Author 		: N Dhanapal
# Start Date	: 2009-07-15
# End Date		: 2009-07-15
# Project		: CommunityMatrimony
# Module		: Admin - Phone Verification
#=============================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/ip.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');

//OBJECT DECLARTION
$objDB	= new MemcacheDB;

//DB CONNECTION
$objDB->dbConnect('S',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varMatriId	= $_REQUEST["matriId"];
$varSubmit	= $_REQUEST["frmPhoneVerifySubmit"];
$varThroughViewProfile	= $_REQUEST["tvprofile"];
 
//SETING MEMCACHE KEY
 $varProfileMCKey= 'ProfileInfo_'.$varMatriId;

//CONTROL STATEMENT
if (($varSubmit=="yes")||($varThroughViewProfile=="yes")) {

	//IF USERNAME COMES GET MatriId
	$varCondition	= "WHERE MatriId=".$objDB->doEscapeString($varMatriId,$objDB);
	$varNoOfResults	= $objDB->numOfRecords($varTable['MEMBERINFO'],'MatriId',$varCondition);

	if ($varNoOfResults==1) {
		$varFields			= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
		$varMemberInfo		= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0,$varProfileMCKey);
		$varPhoneStatus		= $varMemberInfo['Phone_Verified'];

		if($varPhoneStatus == 0 ) {
			$varCurrentStatus	= 'Not Verified';
			$varFields			= array('CountryCode','AreaCode','PhoneNo','MobileNo');
			$varExecute			= $objDB->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'], $varFields, $varCondition,0);
			$varContactInfo		= mysql_fetch_assoc($varExecute);

			$varCountryCode		= $varContactInfo['CountryCode'];
			$varAreaCode		= $varContactInfo['AreaCode'];
			$varPhone			= $varContactInfo['PhoneNo'];
			$varMobile			= $varContactInfo['MobileNo'];
			
			if($varCountryCode == '') {
				$varMatriId			= $varMemberInfo['MatriId'];
				$arrContactPhone	= split('~',$varMemberInfo['Contact_Phone']);
				$arrContactMobile	= split('~',$varMemberInfo['Contact_Mobile']);

				if($arrContactMobile[1]!='') {
					$varCountryCode		= $arrContactMobile[0];
					$varMobile			= $arrContactMobile[1];
				}
				if($arrContactPhone[2]!=''){
					$varCountryCode		= ($varCountryCode=='')?$arrContactPhone[0]:$varCountryCode;
					$varAreaCode		= $arrContactPhone[1];
					$varPhone			= $arrContactPhone[2];
				}
			}
		} else {
			$varCurrentStatus	= 'Verified';
			$varFields			= array('CountryCode','AreaCode','PhoneNo','MobileNo');
			$varExecute			= $objDB->select($varTable['ASSUREDCONTACT'], $varFields, $varCondition,0);
			$varContactInfo		= mysql_fetch_assoc($varExecute);

			$varCountryCode		= $varContactInfo['CountryCode'];
			$varAreaCode		= $varContactInfo['AreaCode'];
			$varPhone			= $varContactInfo['PhoneNo'];
			$varMobile			= $varContactInfo['MobileNo'];
		}
	}
}
?>
<table border='0' cellpadding='0' cellspacing='0' width="540" align="left">
	<tr><td class="heading" >Phone Verification</td></tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td>
			<table border='0' cellpadding='0' cellspacing='0' class="formborderclr" width="540">
				<form name='frmPhoneVerify' method='post' action="index.php" onSubmit='return frmValidation();'>
				<input type='hidden' name='frmPhoneVerifySubmit' value='yes'>
				<input type='hidden' name='matriId' value='<?=$varMatriId?>'>
				<input type='hidden' name='act' value='<?=($varSubmit=='yes') ? 'phoneverified' : 'phoneverify';?>'>
				<?php if(isset($varThroughViewProfile)){?>
					<input type="hidden" name="tvprofile" value="yes">
				<?php }?>
				<tr><td height="10" colspan='5'></td></tr>
				<? if ($varNoOfResults==0 && $varSubmit=='yes') { ?>
					<tr><td height="2" colspan='5'> No Record found!</td></tr>
				<? } ?>
				<tr>
					<td class="smalltxt" align='left'>&nbsp;&nbsp;<b>MatrimonyId :</b></td>
					<td class="smalltxt" colspan="4"><input type='text' name='matriId' class='smalltxt' value="<?=$varMatriId?>"></td>
				</tr>
				<? if (($varNoOfResults==1 && $varSubmit=='yes')||($varThroughViewProfile=="yes")) { ?>
				<tr><td height="10" colspan='5'></td></tr>
				<tr>
					<td class="smalltxt" align='left' width="">&nbsp;&nbsp;<b>Phone / Mobile :</b></td>
					<td class="smalltxt">ISD<br>
						<input type="text" class="inputtext" size="2" name="countryCode" value="<?=$varCountryCode?>">
					</td>
					<td class="smalltxt">STD<br>
						<input type="text" class="inputtext" size="2" name="areaCode" value="<?=$varAreaCode?>">
					</td>
					<td class="smalltxt">Telephone number<br>
						<input type="text" class="inputtext" size="13" name="phoneNo" value="<?=$varPhone?>"> <b>(and / or)</b>
					</td>
					<td class="smalltxt">Mobile number<br>
						<input type="text" class="inputtext" size="15" name="mobileNo" value="<?=$varMobile?>">
					</td>
				</tr>
				<tr><td height="10" colspan='5'></td></tr>
				<tr><td height="10" colspan='5'></td></tr>
				<tr>
					<td class="smalltxt">&nbsp;&nbsp;<b>Current Status : </b></td>
					<td class="smalltxt" colspan="4"><?=$varCurrentStatus?></td>
				</tr>


				<tr><td height="10" colspan='5'></td></tr>
				<tr>
					<td class="smalltxt"><b>&nbsp;&nbsp;To Change Status :</b> </td>
					<td class="smalltxt" colspan="4">
						<input type="radio" name="phoneVerify" value="0" <?=($varPhoneStatus==1) ? 'checked' : '';?>>Non Verify
						<input type="radio" name="phoneVerify" value="1" <?=($varPhoneStatus!=1) ? 'checked' : '';?>>Verified
					</td>
				</tr>
				<? } ?>
				<tr><td height="10" colspan='5'></td></tr>
				<tr>
					<td colspan="5" align="center">
						<input type='submit' class="button" value="Submit">
						<input type='reset' class="button" value="Clear">
					</td>
				</tr>
				<tr><td height="10" colspan='5'></td></tr>
				</form>
			</table>
		</td>
	</tr>
</table>


<script language='javascript'>
function frmValidation() {

	if (IsEmpty(document.frmPhoneVerify.matriId, 'text')) {
		alert("Please Enter the Matrimony Id");
		document.frmPhoneVerify.matriId.focus();
		return false;
	}//if
	return true;
}//IF

function IsEmpty(obj, obj_type) {
	if (obj_type == "text" ||  obj_type == "textarea" ) {

		var objValue;
		objValue = obj.value.replace(/\s+$/,"");

		if (objValue.length == 0)
		{ return true; }
		else { return false; }
	}//IF

}// CHECK FORM FILED VALUE IS EMPTY 

</script>