<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-08-27
# Project	  : MatrimonyProduct
# Filename	  : primaryinfodesc.php
#=====================================================================================================================================
# Description : display information of hobbies info. It has hobbies info form and update function hobbies information.
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];


//OBJECT DECLARTION
$objDBSlave	= new MemcacheDB;
$objCommon	= new clsCommon;

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['abilityinfosubmit'];

if($varUpdatePrimary == 'yes') {

	$objDBMaster = new MemcacheDB;
	$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	$varEditedPhysicalStatus		= $_REQUEST['physicalStatus'];
	if($varEditedPhysicalStatus==0) {
		$varEditedDisabilityCause		= '';
		$varEditedDisabilityType		= '';
		$varEditedSignLanguage			= '';
		$varEditedDisabilitySeverity	= '';
		$varEditedDisabilityProducts	= '';
	} else {
		$varEditedDisabilityCause		= $_REQUEST['disabilitycause'];
		$varEditedDisabilityType		= ($_REQUEST['disabilitytype']!='')?join('~',$_REQUEST['disabilitytype']):'';
		if(is_array($_REQUEST['disabilitytype']) && in_array(4,$_REQUEST['disabilitytype'])) {
			$varEditedSignLanguage		= $_REQUEST['signlanguage'];
		} else {
			$varEditedSignLanguage		= '';
		}

		if(is_array($_REQUEST['disabilitytype']) && (in_array(2,$_REQUEST['disabilitytype']) || in_array(3,$_REQUEST['disabilitytype']) || in_array(4,$_REQUEST['disabilitytype']))) {
			$varEditedDisabilitySeverity= $_REQUEST['disseverity'];
		} else {
			$varEditedDisabilitySeverity= '';
		}
		$varEditedDisabilityProducts	= ($_REQUEST['disabilityproducts']!='')?join('~',$_REQUEST['disabilityproducts']):'';
	}

	//INSERT INTO MEMBERINFO TABLE
	if($sessMatriId != '') {
		//Direct updatation for array field
		$argFields 			= array('Physical_Status','Disability_Cause','Disability_Type','Disability_Severity','Disability_Product_Used','Sign_Language','Date_Updated','Time_Posted');
		$argFieldsValues	= array($objDBMaster->doEscapeString($varEditedPhysicalStatus,$objDBMaster),$objDBMaster->doEscapeString($varEditedDisabilityCause,$objDBMaster),$objDBMaster->doEscapeString($varEditedDisabilityType,$objDBMaster),$objDBMaster->doEscapeString($varEditedDisabilitySeverity,$objDBMaster),$objDBMaster->doEscapeString($varEditedDisabilityProducts,$objDBMaster),$objDBMaster->doEscapeString($varEditedSignLanguage,$objDBMaster),'NOW()','NOW()');
		$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);
	}
	$objDBMaster->dbClose();
} else {

	//GETTING VALUE FROM MEMBERINFO
	$argFields			= array('MatriId','BM_MatriId','CommunityId','Physical_Status','Disability_Cause','Disability_Type','Disability_Severity','Disability_Product_Used','Sign_Language');
	$argCondition		= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave)." AND ".$varWhereClause;
	$varPhysicalInfoRes	= $objDBSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
	$varPhysicalInfo	= mysql_fetch_assoc($varPhysicalInfoRes);

	$varPhysicalStatus			= $varPhysicalInfo['Physical_Status'];
	$varDisabilityCause			= $varPhysicalInfo['Disability_Cause'];
	$arrDisabilityTypeChecked	= explode("~",$varPhysicalInfo["Disability_Type"]);
	$varDisabilitySeverity		= $varPhysicalInfo['Disability_Severity'];
	$arrDisabilityProductChecked= explode("~",$varPhysicalInfo["Disability_Product_Used"]);
	$varSignLanguage			= $varPhysicalInfo['Sign_Language'];

	$varShowDisability			= ($varPhysicalStatus==1)?"block":"none";
	if(in_array(4,$arrDisabilityTypeChecked)) {
		$varShowSignLang		= "block";
	} else {
		$varShowSignLang		= 'none';
	}

	if(in_array(2,$arrDisabilityTypeChecked) || in_array(3,$arrDisabilityTypeChecked) || in_array(4,$arrDisabilityTypeChecked)) {
		$varShowSeverity		= "block";
	} else {
		$varShowSeverity		= "block";
	}
}
$objDBSlave->dbClose();
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/ability.js" ></script>

		<? include_once('settingsheader.php');?>

		<center>
			<div class="padt20">
				<?if($varUpdatePrimary == 'yes') { ?>
				<center><div style='width:500px;' class="padt10">
					Your physical information has been modified successfully.
					<br><br><div class='alerttxt pad10 brdr'><b>Any text changes will have to be validated before it is updated on your profile. It usually takes 24 hours.</b></div>
				</div></center>
				<? } else { ?>
				<form method='post' name='frmProfile' onSubmit="return abilityValidation('frmProfile');" style="padding:0px;margin:0px;padding-top:10px;">
				<input type='hidden' name='act' value='abilitydesc'>
				<input type='hidden' name='abilityinfosubmit' value='yes'>

				<div class="smalltxt fleft tlright pfdivlt" >Physical Status<span class="clr3">*</span></div>
				<div class="fleft pfdivrt tlleft">
					<? unset($arrPhysicalStatusList[2]);foreach($arrPhysicalStatusList as $key=>$value){
						$varChecked = ($key == $varPhysicalStatus)?'checked':'';
						echo '<input type="radio" name=physicalStatus value="'.$key.'"  id="physicalStatus'.$key.'" '.$varChecked.' onClick="showDisabilty(this.form);" onBlur="chkPhysicalStatus(this.form);"><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
					}?><br><span id="physicalspan" class="errortxt"></span>
				</div><br clear="all"/>

				<div id="disabilitydiv" style="display:<?=$varShowDisability?>;">
				<div class="smalltxt fleft tlright pfdivlt" >Cause of disability</div>
				<div class="fleft pfdivrt tlleft">
					<select class='inputtext' name='disabilitycause' size='1'>
						<?=$objCommon->getValuesFromArray($arrDisabilityCause, "--- Select ---", "0", $varDisabilityCause);?>
					</select><br><span id="causespan" class="errortxt"></span>
				</div><br clear="all"/>

				<div class="smalltxt fleft tlright pfdivlt">Disability Type</div>
				<div class="fleft pfdivrt tlleft">
					<? $i=0;
					foreach ($arrDisabilityType as $disabilitytypeval=>$disabilitytypename) {
						$ended=0;
						if ($disabilitytypeval!=0) {
							$varChecked = in_array($disabilitytypeval,$arrDisabilityTypeChecked)?' checked':'';
							if($i%3==0) { ?>
								<div class='fleft' style='width:360px;'>
								<? } ?>
								<div class='fleft smalltxt'><input type=checkbox name='disabilitytype[]' id='disabilitytype' value='<?=$disabilitytypeval?>' <?=$varChecked?>  onBlur='chkDisabilityType(this.form);'  onClick='chkDisabilityType(this.form);'></div>
								<div class='fleft smalltxt' style='width:100px; padding-top:2px;text-align:left'><?=stripslashes($disabilitytypename)?></div>
							<? if ($i%3==2) { ?>
								</div>
								<? $ended = 1;
							}
							$i++;
						}
					}
					if($ended != 1) { ?>
						</div>
					<? } ?>	<br clear="all"><span id="distypespan" class="errortxt"></span>
				</div><br clear="all"/>
				
				<div id="signlangdiv" style="display:<?=$varShowSignLang?>;">
				<div class="smalltxt fleft tlright pfdivlt" >Sign Language<span class="clr3">*</span></div>
				<div class="fleft pfdivrt tlleft">
					<input type="radio" name=signlanguage value="1"  id="signlanguage1" <?=($varSignLanguage==1)?"checked":""?> onBlur='chkSignLanguage(this.form);'><font class="smalltxt" style="padding-right: 10px;">Yes</font>
					<input type="radio" name=signlanguage value="2"  id="signlanguage2" <?=($varSignLanguage==2)?"checked":""?> onBlur='chkSignLanguage(this.form);'><font class="smalltxt" style="padding-right: 10px;">No</font><br><span id="signlanguagespan" class="errortxt"></span>
				</div><br clear="all"/>
				</div>

				<div id="severitydiv" style="display:<?=$varShowSeverity?>;">
				<div class="smalltxt fleft tlright pfdivlt">Disability Severity<span class="clr3">*</span></div>
				<div class="fleft pfdivrt tlleft">
					<? foreach($arrDisabilitySeverity as $key=>$value){
						$varChecked = ($key == $varDisabilitySeverity)?'checked':'';
						echo '<input type="radio" name=disseverity value="'.$key.'"  id="disseverity'.$key.'" '.$varChecked.' onBlur="chkSeverity(this.form);"><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
					}?><br><span id="disseverityspan" class="errortxt"></span>
				</div><br clear="all"/>
				</div>

				<div class="smalltxt fleft tlright pfdivlt">Disability Products</div>
				<div class="fleft pfdivrt tlleft">
					<? $i=0;
					foreach ($arrDisabilityProducts as $arrdisabilityproductsval=>$arrdisabilityproductsname) {
						$ended=0;
						if ($arrdisabilityproductsval!=0) {
							$varChecked = in_array($arrdisabilityproductsval,$arrDisabilityProductChecked)?' checked':'';
							if($i%3==0) { ?>
								<div class='fleft' style='width:360px;'>
								<? } ?>
								<div class='fleft smalltxt'><input type=checkbox name='disabilityproducts[]'  id='disabilityproducts' value='<?=$arrdisabilityproductsval?>' <?=$varChecked?>></div>
								<div class='fleft smalltxt' style='width:100px; padding-top:2px;text-align:left'><?=stripslashes($arrdisabilityproductsname)?></div>
							<? if ($i%3==2) { ?>
								</div>
								<? $ended = 1;
							}
							$i++;
						}
					}
					if($ended != 1) { ?>
						</div>
					<? } ?>	<br clear="all"><span id="disproductspan" class="errortxt"></span>
				</div><br clear="all"/>
				</div>
				<br clear="all"/>
				<div class="tlright padr20" >
				<input type="submit" class="button" value="Save"> &nbsp; <input type="reset" class="button" value="Reset"></div>
				</form>
				<? } ?>
			</div>
		</center>