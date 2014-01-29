<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : partnerinfodesc.php
#=====================================================================================================================================
# Description : display information of partner info. It has partner info form and update function partner information.
#=====================================================================================================================================
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/tblfields.cil14');

//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessPublish		= $varGetCookieInfo["PUBLISH"];

//OBJECT DECLARTION
$objDBSlave	= new MemcacheDB;
$objCommon	= new clsCommon;
$objDomain	= new domainInfo;

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['editpartner'];

//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
function displaySelectedValuesFromArray($argArrName,$argSelectedValue) {
	$funArrSelectedValue	= explode("~", $argSelectedValue);
	if($argSelectedValue == 0 || $argSelectedValue == '') { $varSelectec = 'selected';}
	$funOptions				= '<option value="0" '.$varSelectec.'>Any</option>';
	foreach($argArrName as $funIndex => $funValues)
	{
		if (in_array($funIndex, $funArrSelectedValue))
		{ $funOptions .= '<option value="'.$funIndex.'"  selected>'.$funValues.'</option>';}
		else
		{ $funOptions .= '<option value="'.$funIndex.'">'.$funValues.'</option>';}
	}//for
	return $funOptions;

}//displaySelectedValuesFromArray


$argFields						= array('Age_From','Age_To','Looking_Status','Have_Children','Height_From','Height_To','Weight_From','Weight_To','Physical_Status','Education','Religion','Denomination','CommunityId','CasteId','SubcasteId','Chevvai_Dosham','Citizenship','Country','Resident_India_State','Resident_District','Resident_USA_State','Resident_Status','Mother_Tongue','Partner_Description','Eating_Habits','Drinking_Habits','Smoking_Habits','Employed_In','Occupation','GothramId','Star','Raasi');
$argCondition = "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
$varMemberPartnerInfoResultSet	= $objDBSlave->select($varTable['MEMBERPARTNERINFO'],$argFields,$argCondition,0);
$varMemberInfo					= mysql_fetch_array($varMemberPartnerInfoResultSet);
//echo "<pre>";print_r($varMemberInfo);echo "</pre>";
$argCondition				= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave)." AND ".$varWhereClause;
$argFields 					= $arrMEMBERINFOfields;
$varSelectPartnerInfoRes	= $objDBSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varOwnProfileMCKey);

//CHECK USER HAS FROMAGE AND end AGE FOR PARTNER PREFERENCE TABLE
	$varCommunityId			= $varSelectPartnerInfoRes['CommunityId'];
	$varGender				= $varSelectPartnerInfoRes['Gender'];
	$funPartnerStartAge		= $varMemberInfo['Age_From'];
	$funPartnerEndAge		= $varMemberInfo['Age_To'];
	$funPartnerStartHeight	= $varMemberInfo['Height_From'];
	$funPartnerEndHeight	= $varMemberInfo['Height_To'];

	$arrMaritalChecked		= explode("~",$varMemberInfo["Looking_Status"]);
	$varHaveChildStatus		= $varMemberInfo['Have_Children'];
	$varPhysicalStatus		= $varMemberInfo['Physical_Status'];
	$varMotherTongueString	= $varMemberInfo["Mother_Tongue"];
	$varReligionString		= $varMemberInfo["Religion"];
	$varDenominationString	= $varMemberInfo["Denomination"];
	$varCasteString			= $varMemberInfo["CasteId"];
	$varSubCasteString		= $varMemberInfo["SubcasteId"];
	$varManglikStatus		= $varMemberInfo["Chevvai_Dosham"];
	$varEatStatus			= $varMemberInfo["Eating_Habits"];
	$varSmokeStatus			= $varMemberInfo["Smoking_Habits"];
	$varDrinkStatus			= $varMemberInfo["Drinking_Habits"];
	$varEduString			= $varMemberInfo["Education"];
	$varCitizenshipString	= $varMemberInfo["Citizenship"];
	$varCountryString		= $varMemberInfo["Country"];
	$varResidingIndiaString = $varMemberInfo["Resident_India_State"];
	$varResidingUSAString	= $varMemberInfo["Resident_USA_State"];
	$varResidentString		= $varMemberInfo["Resident_Status"];

	$varResidentDistrictString  = $varMemberInfo["Resident_District"];
	$varEmployedInString        = $varMemberInfo["Employed_In"];
	$varOccupationString        = $varMemberInfo["Occupation"];
	$varGothramString           = $varMemberInfo["GothramId"];
	$varStarString              = $varMemberInfo["Star"];
	$varRaasiString             = $varMemberInfo["Raasi"];

$objDBSlave->dbClose();

//Getting start age for male & female
$varMaleStartAge	= $objDomain->getMStartAge();
$varFemaleStartAge	= $objDomain->getFStartAge();

//getting size of marital status option and used in javascript
$varSizeMaritalStatus	= 0;
$varMStatusFeature		= $objDomain->useMaritalStatus(); 
if($varMStatusFeature == 1) {
	$arrRetMaritalStatus	= $objDomain->getMaritalStatusOption();
	if($varSelectPartnerInfoRes['Gender'] == 1 && $varCommunityId==2503) {
		unset($arrRetMaritalStatus[5]);
	} else if($varSelectPartnerInfoRes['Gender'] == 2 && $varCommunityId==2006) {
		unset($arrRetMaritalStatus[6]);
	}
	$varSizeMaritalStatus	= sizeof($arrRetMaritalStatus);
}
?>
<script>var starmtage=<?=$varMaleStartAge?>,starfmtage=<?=$varFemaleStartAge?>,mstatuscnt=<?=$varSizeMaritalStatus?></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/partnerinfo.js" ></script>

		<? include_once('settingsheader.php');?>

		<center>
			<div class="padt10">
				<?if($varUpdatePrimary == 'yes') { ?>
				<div class='fleft'>
					Your Partner preference has been modified successfully.
					<br><br><font class='errortxt'><b>Any text changes will have to be validated before it is updated on your profile. It usually takes 24 hours.</b></font>
				</div>
				<? } else { ?>
				<form method='post' name='frmProfile' id='frmProfile' onSubmit='return PartnerValidate();' style="padding:0px;margin:0px;">
				<input type='hidden' name='act' value='addedpartnerdesc'>
				<input type='hidden' name='partnerinfosubmit' value='yes'>
				<input type='hidden' name='oldpartnerdesc' value='<?=htmlentities($varMemberInfo['Partner_Description'],ENT_QUTOES)?>'>
				<input type='hidden' name='sessgenderval' value='<?=$varGender?>'>
				<input type="hidden" name="district" id="district" value="<?=$varResidentDistrictString?>">
				<div class="fright opttxt"><span class="clr3">*</span> Mandatory</div><br clear="all">
				<div class="normtxt clr bld fleft padl25">Basic Information</div><br clear="all"/>
				<? if($varMStatusFeature==1) {
					if($varSizeMaritalStatus>1) {
					?>
						<div class="smalltxt fleft tlright pfdivlt"><?=$objDomain->getMaritalStatusLabel()?></div>
						<div class="fleft pfdivrt tlleft" >
							<input type='checkbox' name='lookingStatus[]' id='lookingStatus' value='0' <?if(in_array(0,$arrMaritalChecked)){ echo "checked";}?> onClick='return maritalstany();'>Any &nbsp;
							<? $i=1; foreach($arrRetMaritalStatus as $key=>$value){
								$varChecked = (in_array($key,$arrMaritalChecked))?'checked':'';
								echo '<input type="checkbox" name="lookingStatus[]" value="'.$key.'"  id="lookingStatus" '.$varChecked.' onClick="return maritalst();"><font class="smalltxt" style="padding-right: 5px;">'.$value.'</font>';
								if($i==3) {echo "<BR>";}
								$i++;
							}?><br><span id='mstatus' class='errortxt'></span>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="lookingStatus[]" value="<?=key($arrRetMaritalStatus)?>">
					<? }
				 } ?>
				
				<div class="smalltxt fleft tlright pfdivlt">Age</div>
				<div class="fleft pfdivrt tlleft smalltxt">From <input type=text name=fromAge size=2 maxlength=2 value='<?=$funPartnerStartAge?>' class='inputtext'> &nbsp; to &nbsp; <input type=text name=toAge size=2 maxlength=2 value='<?=$funPartnerEndAge?>' class='inputtext'> yrs<br><span id='stage' class='errortxt'></span>
				</div><br clear="all"/>
				
				<div class="smalltxt fleft tlright pfdivlt" >Height</div>
				<div class="fleft pfdivrt tlleft smalltxt">From 
					<select class='inputtext' name='heightFrom' size='1'>
					<?=$objCommon->getValuesFromArray($arrHeightList, "", "", $funPartnerStartHeight);?>
					</select>&nbsp;&nbsp; To
					<select class='inputtext' NAME='heightTo' size='1'>
					<?=$objCommon->getValuesFromArray($arrHeightList, "", "", $funPartnerEndHeight);?>
					</select>
					<br><span id='stheight' class='errortxt'></span>
				</div><br clear="all"/>
				
				<div class="smalltxt fleft tlright pfdivlt">Physical Status</div>
				<div class="fleft pfdivrt tlleft" >
					<? $index=1; foreach($arrPhysicalStatusList as $key=>$value){
						$varChecked = ($key == $varPhysicalStatus)?'checked':'';
						if($index > 3) echo "<br>";
						echo '<input type="radio" name=physicalStatus value="'.$key.'"  id="physicalStatus'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
					$index++;}?>
				</div><br clear="all"/>

				<? if($objDomain->useMotherTongue()) {
					$arrRetMotherTongue	= $objDomain->getMotherTongueOption();
					$varSizeMotherTongue= sizeof($arrRetMotherTongue);
					if($varSizeMotherTongue>1) {
						$arrRetMotherTongue	= $objCommon->changingArray($arrRetMotherTongue);
					?>
						<div class="smalltxt fleft tlright pfdivlt"><?=$objDomain->getMotherTongueLabel()?></div>
						<div class="fleft pfdivrt tlleft" ><select class='srchselect' NAME='motherTongue[]' size='5' MULTIPLE >
								<?=displaySelectedValuesFromArray($arrRetMotherTongue, $varMotherTongueString);?>
							</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="motherTongue[]" value="<?=key($arrRetMotherTongue)?>">
					<? }
				 } ?>
				
				<div class="normtxt clr bld fleft padl25 padt10">Cultural Background</div><br clear="all"/>
				
				<? if($objDomain->useReligion()) {
					$arrRetReligion	= $objDomain->getReligionOption();
					$varSizeReligion= sizeof($arrRetReligion);
					if($varSizeReligion>1) {
					?>
						<div class="smalltxt fleft tlright pfdivlt"><?=$objDomain->getReligionLabel()?></div>
						<div class="fleft pfdivrt tlleft" >
							<select class='srchselect' NAME='religion[]' size='5' MULTIPLE >
								<?=displaySelectedValuesFromArray($arrRetReligion, $varReligionString);?>
							</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="religion[]" value="<?=key($arrRetReligion)?>">
					<? }
				 } ?>

				 <? if($objDomain->useDenomination()) {
					$arrRetDenomination	= $objDomain->getDenominationOption();
					$varSizeDenomination= sizeof($arrRetDenomination);
					if($varSizeDenomination>1) {
					?>
						<div class="smalltxt fleft tlright pfdivlt"><?=$objDomain->getDenominationLabel()?></div>
						<div class="fleft pfdivrt tlleft" >
							<select class='srchselect' NAME='denomination[]' size='5' MULTIPLE >
								<?=displaySelectedValuesFromArray($arrRetDenomination, $varDenominationString);?>
							</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="denomination[]" value="<?=key($arrRetDenomination)?>">
					<? }
				 } ?>

				<? if($objDomain->useCaste() && $objDomain->isCasteMandatory() == 1) {
					$arrRetCaste	= $objDomain->getCasteOption();
					$varSizeCaste	= sizeof($arrRetCaste);
					if($varSizeCaste>1) {
						$arrRetCaste= $objCommon->changingArray($arrRetCaste);
						unset($arrRetCaste['9998']);
					?>
						<div class="smalltxt fleft tlright pfdivlt"><?=$objDomain->getCasteLabel()?></div>
						<div class="fleft pfdivrt tlleft" >
							<select class='srchselect' NAME='casteDivision[]' size='5' MULTIPLE >
								<?=displaySelectedValuesFromArray($arrRetCaste, $varCasteString);?>
							</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="casteDivision[]" value="<?=key($arrRetCaste)?>">
					<? }
				 } ?>

				<? if($objDomain->useSubcaste() && $objDomain->isSubcasteMandatory() == 1) {
					$arrRetSubcaste	= $objDomain->getSubcasteOption();
					$varSizeSubcaste= sizeof($arrRetSubcaste);
					if($varSizeSubcaste>1) {
						$arrRetSubcaste	= $objCommon->changingArray($arrRetSubcaste);
						unset($arrRetSubcaste['9998']);
					?>
						<div class="smalltxt fleft tlright pfdivlt"><?=$objDomain->getSubcasteLabel()?></div>
						<div class="fleft pfdivrt tlleft" >
							<select class='srchselect' NAME='subCaste[]' size='5' MULTIPLE >
								<?=displaySelectedValuesFromArray($arrRetSubcaste, $varSubCasteString);?>
							</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="subCaste[]" value="<?=key($arrRetSubcaste)?>">
					<? }
				 } ?>
                
               
              <?if($objDomain->useStar()) { ?>
				<div class="smalltxt fleft tlright pfdivlt"><?=$objDomain->getStarLabel();?></div>
				<div class="fleft pfdivrt tlleft">
					<select class='srchselect' name='star[]' size='5' multiple>
				    <?=displaySelectedValuesFromArray($arrGetStarOption = $objDomain->getStarOption(),$varStarString);?>
					</select>
				</div><br clear="all"/>
			  <? } ?>
			
              
              <? if($objDomain->useGothram()) {
			        $varCasteId = $varSelectPartnerInfoRes['CasteId'];
					$arrRetGothram	= $objDomain->getGothramOptionsForCaste($varCasteId);
					$varSizeGothram	= sizeof($arrRetGothram);
		            if($varSizeGothram > 1) {
					  ?>
						<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getGothramLabel()?></div>
						<div class="fleft pfdivrt tlleft">
							<div class="fleft"><select name='gothram[]' id='gothram[]' size='5' multiple  class='srchselect'><?=displaySelectedValuesFromArray($arrRetGothram,$varGothramString);?>
							</select></div></div>
							<? } ?>
						<br clear="all"/>
					<?  } ?>
				
				<? if($objDomain->useRaasi()) { ?>
					<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getRaasiLabel()?></div>
					<div class="fleft pfdivrt tlleft">
						<select class='srchselect' name='raasi[]' size='5' multiple><?=displaySelectedValuesFromArray($objDomain->getRaasiOption(),$varRaasiString);?>
						</select>
					</div><br clear="all"/>
				<? } ?>




				<? if($objDomain->useDosham()) {
					$arrRetDosham	= $objDomain->getDoshamOption();
					unset($arrRetDosham['3']);
					$varSizeDosham	= sizeof($arrRetDosham);
					if($varSizeDosham>1) {
					?>
						<div class="smalltxt fleft tlright pfdivlt"><?=$objDomain->getDoshamLabel()?></div>
						<div class="fleft pfdivrt tlleft" >
							<input type=radio name=manglik value='0' <?if($varManglikStatus == 0){ echo "checked";}?>><font class='smalltxt normaltxt'>Doesn't matter&nbsp;</font>
							<? foreach($arrRetDosham as $key=>$value){
								$varChecked = ($key == $varManglikStatus)?'checked':'';
								echo '<input type="radio" name=manglik value="'.$key.'"  id="manglik'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
							}?>
						</div><br clear="all"/>
					<? }  else { ?>
						<input type="hidden" name="manglik" value="<?=key($arrRetDosham)?>">
					<? }
				 } ?>
				
				<div class="normtxt clr bld fleft padl25 padt10">Career</div><br clear="all"/>
				
				<div class="smalltxt fleft tlright pfdivlt">Education in Detail</div>
				<div class="fleft pfdivrt tlleft" ><select class='srchselect' name='education[]' size='5' multiple >
						<?=displaySelectedValuesFromArray($arrEducationList, $varEduString);?>
					</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
                
				 <? if($objDomain->useEmployedIn()) {
					$arrRetEmployedIn	= $objDomain->getEmployedInOption();
					$varSizeEmployedIn	= sizeof($arrRetEmployedIn);
		            if($varSizeEmployedIn > 1) {
					  ?>
						<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getEmployedInLabel()?></div>
						<div class="fleft pfdivrt tlleft">
							<div class="fleft"><select name='employedIn[]' id='employedIn[]' size='5' multiple  class='srchselect'><?=displaySelectedValuesFromArray($arrRetEmployedIn,$varEmployedInString);?>
							</select></div>
						</div><br clear="all"/>
					<?  }  else { ?>
						<input type="hidden" name="employedIn[]" value="<?=key($arrRetEmployedIn)?>">
					<? } 
				 } ?>
                <!-- <div class="smalltxt fleft tlright pfdivlt">Employed in</div>
				<div class="fleft pfdivrt tlleft" ><select class='srchselect' name='employedIn[]' size='5' multiple >   <?=displaySelectedValuesFromArray($arrEmployedInList,$varEmployedInString);?>
					</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>    -->
                
				<? if($confValues["DOMAINCASTEID"] == 2006 && $varGender==1) {
					$arrTotalOccupationList = $arrFemaleDefenceOccupationList;
				} else if($confValues["DOMAINCASTEID"] == 2006 && $varGender==2) {
					$arrTotalOccupationList = $arrDefenceOccupationList;
				}?>
				<div class="smalltxt fleft tlright pfdivlt">Occupation</div>
				<div class="fleft pfdivrt tlleft" ><select class='srchselect' name='occupation[]' size='5' multiple ><?=displaySelectedValuesFromArray($arrTotalOccupationList,$varOccupationString);?>
					</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
 
             
				<div class="normtxt clr bld fleft padl25 padt10">Location</div><br clear="all"/>
                <? if($confValues["DOMAINCASTEID"] == 2006) { ?>
				   <select class='srchselect' name='citizenship[]' multiple size='5' style="display:none">
						<option value="98" selected>India</option>
					</select>
				<? } else { ?>
				<div class="smalltxt fleft tlright pfdivlt">Citizenship</div>
				<div class="fleft pfdivrt tlleft" ><select class='srchselect' name='citizenship[]' multiple size='5'>
						<?=displaySelectedValuesFromArray($arrCountryList, $varCitizenshipString);?>
					</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
				<? } ?>
				
				<? if($confValues["DOMAINCASTEID"] == 2006) { ?>
				<select class='srchselect' name='countryLivingIn[]' id='countryLivingIn[]' multiple size='5' Onchange="displayCityState();" style="display:none">
			          <option value="98" selected>India</option>
				</select>
                <? } else { ?>
				<div class="smalltxt fleft tlright pfdivlt">Country Living in</div>
				<div class="fleft pfdivrt tlleft" ><select class='srchselect' name='countryLivingIn[]' id='countryLivingIn[]' multiple size='5' Onchange="displayCityState();">
						<?=displaySelectedValuesFromArray($arrCountryList, $varCountryString);?>
					</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
				<? } ?>

				<!-- <div class="smalltxt fleft tlright pfdivlt">Residing State</div>
				<div class="fleft pfdivrt tlleft"><select class='srchselect' name='residingIndia[]' multiple size='5'>
						<?=displaySelectedValuesFromArray($arrResidingStateList, $varResidingIndiaString);?>
					</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/> -->
				
				<div id="residingIndiaDiv" style="display:none">
				<div class="smalltxt fleft tlright pfdivlt">Residing in India</div>
				<div class="fleft pfdivrt tlleft" ><select class='srchselect' id='residingIndia[]' name='residingIndia[]' multiple size='5' onChange='modrequestnew();'>
						<?=displaySelectedValuesFromArray($arrResidingStateList, $varResidingIndiaString);?>
					</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
				</div>

                <div id="residingUsaDiv" style="display:none">
				<div class="smalltxt fleft tlright pfdivlt">Residing in USA</div>
				<div class="fleft pfdivrt tlleft" ><select class='srchselect' id="residingUSA[]" name='residingUSA[]' multiple size='5'>
						<?=displaySelectedValuesFromArray($arrUSAStateList, $varResidingUSAString);?>
					</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
				</div>

				<div id='residingCityDiv' style="display:none">
                <div class="smalltxt fleft tlright pfdivlt">Residing in City/District</div>
				<div class="fleft pfdivrt tlleft" ><select class='srchselect' id="residingCity[]" name='residingCity[]' multiple size='5'>
						<?=displaySelectedValuesFromArray($varTmpState, $varResidentDistrictString);?>
					</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
				</div>
                
				<? if($confValues["DOMAINCASTEID"] == 2006) { ?>
				   <select class='srchselect' name='residentStatus[]' size='5' multiple style="display:none">
						<option value=1>citizen</option>
					</select>
				<? } else { ?>
				<div class="smalltxt fleft tlright pfdivlt">Resident Status</div>
				<div class="fleft pfdivrt tlleft" ><select class='srchselect' name='residentStatus[]' size='5' multiple >
						<?=displaySelectedValuesFromArray($arrResidentStatusList, $varResidentString);?>
					</select> <br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
                <? } ?>

				<div class="normtxt clr bld fleft padl25 padt10">Lifestyle - Habits</div><br clear="all"/>

				<div class="smalltxt fleft tlright pfdivlt">Food</div>
				<div class="fleft pfdivrt tlleft" >
					<input type=radio name=eatingHabits value='0'<?if($varEatStatus == 0){ echo "checked";}?>><font class='smalltxt'>Doesn't matter&nbsp;</font>
					<? foreach($arrEatingHabitsList as $key=>$value){
						$varChecked = ($key == $varEatStatus)?'checked':'';
						echo '<input type="radio" name=eatingHabits value="'.$key.'"  id="eatingHabits'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
					}?>
				</div><br clear="all"/>

				<div class="smalltxt fleft tlright pfdivlt">Smoking</div>
				<div class="fleft pfdivrt tlleft" >
					<input type=radio name=smokingHabits value='0'<?if($varSmokeStatus == 0){ echo "checked";}?>><font class='smalltxt'>Doesn't matter &nbsp; &nbsp;</font>
					<? foreach($arrSmokeList as $key=>$value){
						$varChecked = ($key == $varSmokeStatus)?'checked':'';
						echo '<input type="radio" name=smokingHabits value="'.$key.'"  id="smokingHabits'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 25px;">'.$value.'</font>';
					}?>
				</div><br clear="all"/>

				<div class="smalltxt fleft tlright pfdivlt">Drinking</div>
				<div class="fleft pfdivrt tlleft" >
					<input type=radio name=drinkingHabits value='0'<?if($varDrinkStatus == 0){ echo "checked";}?>><font class='smalltxt'>Doesn't matter &nbsp; &nbsp;</font>
					<? foreach($arrDrinkList as $key=>$value){
						$varChecked = ($key == $varDrinkStatus)?'checked':'';
						echo '<input type="radio" name=drinkingHabits value="'.$key.'"  id="drinkingHabits'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 25px;">'.$value.'</font>';
					}?>
				</div><br clear="all"/>

				<div class="normtxt fleft tlright pfdivlt bld">Few lines about my partner</div>
				<div class="fleft pfdivrt tlleft" ><textarea class="tareareg" name="partnerDescription"><?=htmlentities($varMemberInfo['Partner_Description'],ENT_QUOTES)?></textarea><br />
				</div><br clear="all">				

				<div class="tlright padr20 padt10">
					<input type="submit" class="button" value="Save"> &nbsp;
					<input type="reset" class="button" value="Reset">
				</div>
                <?
				 echo '<script>displayCityState();modrequestnew();</script>';
				?>
				</form><br>
				<? } ?>
			</div>
		</center>