<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-20
# Project	  : MatrimonyProduct
# Filename	  : changepassword.php
#=====================================================================================================================================
# Description : Password change Here
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];

//OBJECT DECLARATION
$objDBMaster= new MemcacheDB;
$objCommon	= new clsCommon;

//VARIABLE DECLARATION
$varUpdateStatus	= $_REQUEST['updatestatus'];
$varStatusType		= $_REQUEST['statustype'];
$varCurrentDate		= date('Y-m-d H:i:s');

//CONNECT DATABASE
$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

if($sessMatriId==""){
	$varMessage='You are either logged off or your session timed out. <a href="http://'.$confValues['SERVERURL'].'/login/login.php" class="clr1">Click here</a> to login.';exit;
} else if($varUpdateStatus == 'yes' && $varStatusType==5) { 
} else if($varUpdateStatus == 'yes' && ($sessPublish==1 || $sessPublish==2)) { 
	//Set activate/deactivate and update login info cookie
	$varPublish			= $varStatusType;
	$argFields			= array('Publish', 'Date_Updated');
	$argFieldsValues	= array($objDBMaster->doEscapeString($varPublish,$objDBMaster), "'".$varCurrentDate."'");
	$argCondition		= "MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster)." AND (Publish=1 OR Publish=2)";
	$varUpdated			= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
	if($varUpdated == 1) {
		$varOldCookie	= $_COOKIE['profileInfo'];
		//So concatenate publuish value (replace old publsih value with new publish value) with profile info cookie
		$varNewCookie	= $varPublish.substr($_COOKIE['profileInfo'],1);		
		setcookie("profileInfo", $varNewCookie, 0, "/", $confValues['DOMAINNAME']);
		header("Location: index.php?act=profilestatus&editprofilestatus=yes");
		exit;
	}
} else {
	//SELECT MEMBERLOGIN INFO
	$argFields		= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
	$argCondition	= "WHERE MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster)." AND ".$varWhereClause;
	$varBasicInfo	= $objDBMaster->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varOwnProfileMCKey);
	$varPublish		= $varBasicInfo['Publish'];
}

$varMsg	= '';
if($varPublish==0) {
	$varMsg	= 'not yet validated.';
} else if($varPublish==3) {
	$varMsg	= 'suspended';
} else if($varPublish==4) {
	$varMsg	= 'rejected';
} else if($varPublish==1) {
	$varStatusHead	= 'Hide';
	$varStatusMsg	= "Want to take a short break from your life partner search? You can still use all of the site's features, but other members will not be able to see you.";
	$varProileValue	= 2;
} else if($varPublish==2) {
	$varStatusHead	= 'Unhide';
	$varStatusMsg	= "Your profile is currently hidden. Do you want to unhide it so all members can view it and contact you if they're interested?";
	$varProileValue	= 1;
}
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/profilestatus.js" ></script>
<?include_once('settingsheader.php');?>		
<center>
<div class="rpanelinner">
	<div class="padt20">
		<div class="fleft clr bld padb10">Hide/Delete Profile</div><br clear="all">
		<? if($varPublish==0 || $varPublish==3 || $varPublish==4) { ?>
		<div id='opend' class="alerttxt">
			Your profile is <?=$varMsg;?>.
		</div>
		<?} else { ?>
		<form name="hideprof" method="post" style="margin: 0px;">
		<input type="hidden" name="updatestatus" value="yes">
		<input type="hidden" name="act" value="profilestatus">
		<div class="rpannel">
			<div class="fleft clr bld padb5"><?=$varStatusHead?> your profile</div><br clear="all">
			<div class=" fleft smalltxt padtb3 padt10 tljust"><?=$varStatusMsg?></div><br clear="all">
			<div class="fleft"><input type="radio" name="statustype" value="<?=$varProileValue?>" class="radiobtn" onClick="dispDelReason(1);"></div>
			<div class="padtb3 fleft  smalltxt">
			Yes, I want to <?=strtolower($varStatusHead);?> my profile
			<br><span id="profilestatusspan" class="errortxt"></span>
			</div>
			
		</div><br clear="all">
		
		<div class="rpannel">
			<div class="fleft  clr bld padt20 padb5">Permanently delete your profile</div><br clear="all">
			<div class="fleft smalltxt padtb3 padt10" >This action is permanent. Profile once deleted cannot be restored.</div><br clear="all">
			<div class="fleft"><input type="radio" name="statustype" value="5" class="radiobtn" onClick="dispDelReason(2);"></div>
			<div class="padtb3 fleft  smalltxt">Yes, I want to delete my profile</div><br clear="all">


			<!-- njk -->
			<div id="deloption" class="disnon">
				<div class="smalltxt fleft tlright padtb10 padr20" style="width:190px;"><label for="reason">Please select reason for deletion</label></div>
				<div id="delprofilereason" class="fleft padtb10" style="width:290px;">
					<select id="reason" name="reason" class="inputtext" onblur="ChkEmpty(reason, 'select','profilespan','Please select the reason for deleting your profile.');" onChange="dispOtherSite();">
						<?=$objCommon->getValuesFromArray($arrDeleteProfileReason, "-- Select Reason --", "", $_REQUEST["reason"]);?>
					</select><br><span id="profilespan" class="errortxt"></span>
				</div><br clear="all">
				<div id="othersitename" class="disnon">
					<div class="smalltxt fleft tlright padr20 padb10" style="width:190px;padding-top:0px;">Please specify the site name</div>
					<div class="fleft padb10" style="width:290px;padding-top:0px;"><input id="othersite" name="othersite" value="" size="38" class="inputtext" type="text"></div>
				</div>
			</div>
			<!-- njk -->
		</div> <br clear="all">
		
		<div id="confirm" class="disnon">
			<div class="brdr pad10 alerttxt">
			<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="hidediv('confirm');" ></div><br clear="all">
			Are you sure you want to delete your profile on <?=$confValues['SERVERNAME']?>?<br clear="all"><br clear="all">
			<div class="fright padb10">
			<input type="button" class="button" onClick="afterDelconfirm();" value="Yes">
			<input type="button" class="button" value="No" onclick="hidediv('confirm');"></div><br clear="all">
			</div>
		</div> <br clear="all">

		<div class="fright padr20">
			<input type="button" class="button" value="Submit" onClick="return chkProfileStatus();"> &nbsp; <input type="reset" class="button" value="Reset">
		</div>
		</form>
		<? } ?>
	</div>
	</div>
</center>