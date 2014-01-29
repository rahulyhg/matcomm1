<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-07-18
# End Date		: 2008-07-18
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================
//ini_set('display_errors',1);
//error_reporting(E_ALL);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsRegister.php');
include_once($varRootBasePath.'/lib/clsError.php');
include_once($varRootBasePath.'/conf/ppinfo.cil14');

//OBJECT DECLARTION
$objCommon			= new clsCommon;
$objPartlyRegister	= new clsRegister;
$objDomainInfo		= new domainInfo;

$varUseMatritalStatus	= $objDomainInfo->useMaritalStatus();
$varUseAppearance		= $objDomainInfo->useAppearance();
$varUseReligion			= $objDomainInfo->useReligion();
$varUseDenomination		= $objDomainInfo->useDenomination();
$varUseCaste			= $objDomainInfo->useCaste();
$varIsCasteMandatory	= $objDomainInfo->isCasteMandatory();
$varUseSubcaste			= $objDomainInfo->useSubcaste();
$varUseMotherTongue		= $objDomainInfo->useMotherTongue();
$varUserGothram			= $objDomainInfo->useGothram();
$varUseReligious		= $objDomainInfo->useReligiousValues();
$varUseEthnicity		= $objDomainInfo->useEthnicity();
$varUseEmployedIn		= $objDomainInfo->useEmployedIn();

if($_POST['addRegister']!='yes') {
  $varCasteNoBarCheck		= $objDomainInfo->isCasteNoBarCheck();
  $varIsSubcasteMandatory	= $objDomainInfo->isSubcasteMandatory();
}
$varSizeReligious		= sizeof($arrReligiousList);
$varSizeEthnicity		= sizeof($arrEthnicityList);


//VARIABLE DECLARITON
asort($arrCountryList);
UNSET($arrCountryList[98]);
UNSET($arrCountryList[222]);
UNSET($arrCountryList[220]);
UNSET($arrCountryList[129]);
UNSET($arrCountryList[221]);
UNSET($arrCountryList[13]);
UNSET($arrCountryList[185]);
UNSET($arrCountryList[39]);
UNSET($arrCountryList[189]);
UNSET($arrCountryList[114]);
UNSET($arrFamilyType[3]);
$varTabIndex = 1;

// Assign religion values for which subcaste is not mandatory in javascript array
if($varUseReligion) {
 $arrGetReligionOption = $objDomainInfo->getReligionOption();
 if (sizeof($arrGetReligionOption) > 1 ) { 
   echo $objCommon->getReligionWithSubcasteOptional($arrReligionListWithSubcasteOptional);
 }
}

//PRCASE
$varCurrentDate			= date('Y-m-d H:i:s');
$varPartnerLanding		= $_REQUEST['partnerLanding'];
$varName				= trim($_REQUEST['name']);
$varGender				= $_REQUEST['gender'];
$varMonth				= $_REQUEST['dobMonth'];
$varDay					= $_REQUEST['dobDay'];
$varYear				= $_REQUEST['dobYear'];
$varDomainName			= $_REQUEST['domainName'];
$varDOB					= $varYear.'-'.$varMonth.'-'.$varDay;
$varAge					= trim($_REQUEST['age']);
$varAge					= ($varAge=='yrs') ? '' : $varAge;
$varCountry				= $_REQUEST['country'];
$varCountryCode			= trim($_REQUEST['countryCode']);
$varCountryCode			= ($varCountryCode != 'ISD' && $varCountryCode != '')?$varCountryCode:'';
$varAreaCode			= trim($_REQUEST['areaCode']);
$varAreaCode			= ($varAreaCode != 'STD' && $varAreaCode != '')?$varAreaCode:'';
$varPhoneNo				= trim($_REQUEST['phoneNo']);
$varPhoneNo				= ($varPhoneNo != 'Telephone number' && $varPhoneNo != '')?$varCountryCode.'~'.$varAreaCode.'~'.$varPhoneNo:'';
$varMobileNo			= trim($_REQUEST['mobileNo']);
$varMobileNo			= ($varMobileNo != 'Mobile number' && $varMobileNo != '')?$varCountryCode.'~'.$varMobileNo:'';
$varEmail				= trim($_REQUEST['email']);
$varPassword			= trim($_REQUEST['password']);
$varPartlyId			= trim($_REQUEST['partlyId']);
$varTrackId				= trim($_REQUEST['trackid']);
$varFormFeed			= trim($_REQUEST['formfeed']);

if ($varPartnerLanding=='yes'){

	//CONNECT DATABASE
	$objPartlyRegister->dbConnect('M',$varDbInfo['DATABASE']);
	$varFields = array('CommunityId','Name','Age','Dob','Gender','Country','Contact_Phone','Contact_Mobile','Email','Password','Date_Created');
	$varFieldsValues = array("'".$confValues["DOMAINCASTEID"]."'",$objPartlyRegister->doEscapeString($varName,$objPartlyRegister),$objPartlyRegister->doEscapeString($varAge,$objPartlyRegister),$objPartlyRegister->doEscapeString($varDOB,$objPartlyRegister),$objPartlyRegister->doEscapeString($varGender,$objPartlyRegister),$objPartlyRegister->doEscapeString($varCountry,$objPartlyRegister),$objPartlyRegister->doEscapeString($varPhoneNo,$objPartlyRegister),$objPartlyRegister->doEscapeString($varMobileNo,$objPartlyRegister),$objPartlyRegister->doEscapeString($varEmail,$objPartlyRegister),$objPartlyRegister->doEscapeString($varPassword,$objPartlyRegister),"'".$varCurrentDate."'");
	$varPartlyId = $objPartlyRegister->insert($varTable['MEMBERPARTLYINFO'],$varFields,$varFieldsValues);
	$objPartlyRegister->dbClose();




}

if($_REQUEST['refpg']=='srch'){
	$varTopCont	= '<div class="normtxt1 clr bld padb5 brdr" style="background-color:#EEEEEE;padding:10px;height:50px !important;height:70px;padding-bottom:5px;"><div class="fleft"><img src="'.$confValues['IMGSURL'].'/info_img.gif" align="left" /></div><div class="fleft pad10" style="width:460px;">Want to view more profiles? Register free to begin a full fledged partner search and to contact prospects.</div></div>';
}else{
	$varTopCont	= '<div class="fleft normtxt1 clr bld padb5">Your partner search begins here. Take the first step and register.</div>';
}

$varCommunityId	= $confValues["DOMAINCASTEID"];
$varCommunityId	= $varCommunityId ? $varCommunityId : '0';
?>

<script>var startMaleAge=<?=$varMStartAge?>,startFemaleAge=<?=$varFStartAge?></script>

<div class="rpanel fleft">

<?php if($_REQUEST['page'] == 'errorlanding') { include_once($varRootBasePath.'/www/register/errorlanding.php'); } ?>

<form name="frmRegister" method="POST" action="index.php?act=addedbasic" style="padding:0px;margin:0px;" onSubmit="return ValidateReg();">
<input type="hidden" name="addRegister" value="yes">
<!--<? if ($_REQUEST['domainName'] !="" && $_REQUEST['domainName'] !="0") { ?>
	<input type="hidden" name="domainName" value="<?=$_REQUEST['domainName']?>"> 
<? } ?>-->
<input type="hidden" name="category" value="<?=$varCategory?>">
<input type="hidden" name="oppositeId" value="<?=$varOppId?>">
<input type="hidden" name="religionfeature" value="<?=$varUseReligion?>">
<input type="hidden" name="denominationfeature" value="<?=$varUseDenomination?>">
<input type="hidden" name="appearancefeature" value="<?=$varUseAppearance?>">
<input type="hidden" name="castefeature" value="<?=$varUseCaste?>">
<input type="hidden" name="castemandatory" value="<?=$varIsCasteMandatory?>">
<input type="hidden" name="subcastefeature" value="<?=$varUseSubcaste?>">
<input type="hidden" name="subcastemandatory" value="<?=$varIsSubcasteMandatory?>">
<input type="hidden" name="mothertonguefeature" value="<?=$varUseMotherTongue?>">
<input type="hidden" name="gothramfeature" value="<?=$varUserGothram?>">
<input type="hidden" name="religiousfeature" value="<?=$varUseReligious?>">
<input type="hidden" name="ethinicityfeature" value="<?=$varUseEthnicity?>">
<input type="hidden" name="empinfeature" value="<?=$varUseEmployedIn?>">
<input type="hidden" name="communityId" value="<?=$varCommunityId?>">
<input type='hidden' name='emaildup' value=''>
<input type="hidden" name="partlyId" value="<?=$varPartlyId?>">
<input type="hidden" name="MaritalCnt" value="<?=sizeof($arrMaritalList)?>">
<input type="hidden" name="religiousOption" value="<?=$varSizeReligious?>">
<input type="hidden" name="ethnicityOption" value="<?=$varSizeEthnicity?>">
<input type="hidden" name="domainRegister" value="community">
<?=$varTopCont?><br clear="all" />
	<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<div class="fleft smalltxt padt5">Fill in the form below to complete your registration.</div>
	<div class="fright opttxt padt5"><font class="clr3">*</font> Mandatory </div><br clear="all" />
		<div class="padt10">
			<? if ($varErrorPage=='yes') { ?>
			<!--<center>-->
			<div class="clr3 pad10 brdr" style="background-color:#efefef;"> <!--You have already registered on <?=$confValues["PRODUCTNAME"]?>.com using the same e-mail ID.,-->
			<?php Error::showErrors(); ?> </div>
			<!--</center>-->
			<? } if ($confValues["DOMAINCASTEID"] =="") { ?>

			<div class="normtxt fleft bld padl25">Select your community matrimony site in which you would like to register:</div><center><div class="fleft padt10" style="width:525px;">
			<?
					$arrMatriIdPre1 = array_flip($arrMatriIdPre);
					asort($arrPrefixDomainList);
					echo "<select name='domainName' class='select1' tabindex='".$varTabIndex++."' onBlur='chkDomain();onChange=funMotherTongue();'>";
					echo "<option value='0'>-- Select Community --</option>";
					unset($arrPrefixDomainList['ABL']);
                    unset($arrPrefixDomainList['DEF']);
					//unset($arrPrefixDomainList['FPM']);
					foreach($arrPrefixDomainList as $key => $value){
						if($value == $varDomainName) {
						  echo '<option value="'.$value.'" selected>'.$value.'</option>';
						}
						else {
						  echo '<option value="'.$value.'">'.$value.'</option>';
					    }
					}
					echo "</select>";
			?><br><span id="domainlistspan" class="errortxt"><?=$varErrorCommunityList;?></span></div></center><br clear="all"/>
		<? } ?>

			<div class="normtxt clr bld fleft padl25 padtb20">Basic information</div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">Profile created by<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
			<?=$objCommon->displayRadioOptions($arrProfileCreatedByList, "profileCreatedBy",$varProfileCreatedBy,'smalltxt','onBlur="createdChk();"',$varTabIndex++);?><br><span id="profilecreatedbyspan" class="errortxt"></span>
			</div><br clear="all"/>
			<? $varTabIndex =  (count($arrProfileCreatedByList)+$varTabIndex-1); ?>
			<div class="pfdivlt smalltxt fleft tlright">Name</div>
			<div class="pfdivrt smalltxt fleft"><input type="text" name="name" value="<?=$varName;?>" size="35" class="inputtext" tabindex="<?=$varTabIndex++?>"><br><span id="namespan" class="errortxt"></span></div><br clear="all"/>


			<div class="pfdivlt smalltxt fleft tlright">Display name<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft"><input type="text" name="nickName" value="<?=$varNickName;?>" size="35" class="inputtext" onblur="nameChk();" onkeyup="nameChk();" tabindex="<?=$varTabIndex++?>"><br><span id="nicknamespan" class="errortxt"></span></div><br clear="all"/>


			<div class="pfdivlt smalltxt fleft tlright">Gender<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft"><input type="radio" tabindex="<?=$varTabIndex++?>" name="gender" id='gendermale' value="1" onClick="isMaleChk();populateOccupation(this.value);" onblur="genderChk();isMaleChk();" <? if($varGender=='1') { echo "CHECKED"; } ?>>Male &nbsp;&nbsp;<input type="radio" tabindex="<?=$varTabIndex++?>" name="gender" value="2" onClick="genderChk();isMaleChk();populateOccupation(this.value);" onBlur="genderChk();isMaleChk();" <? if($varGender=='2') { echo "CHECKED"; } ?>>Female<br clear="all"/><span id="genderspan" class="errortxt"></span></div><br clear="all"/>


		<div class="pfdivlt smalltxt fleft tlright">Date of birth<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
			<select name="dobMonth" tabindex="<?=$varTabIndex++?>" size="1" class="select" onChange="agesel();updateDay('month','frmRegister','dobYear','dobMonth','dobDay');" onBlur="ageChk();" style="width:85px;">
			<option value="0" selected>-Month-</option>
				 <?=$objCommon->monthDropdown($varMonth)?>
			</select>
			<select name="dobDay" tabindex="<?=$varTabIndex++?>" style="width:55px;" class="select" onblur="agesel();ageChk();">
					<option value="0" selected>-Date-</option>
					<option value="1" <?=$varDay==1 ? 'selected' : '';?>>1</option>
					<option value="2" <?=$varDay==2 ? 'selected' : '';?>>2</option>
					<option value="3" <?=$varDay==3 ? 'selected' : '';?>>3</option>
					<option value="4" <?=$varDay==4 ? 'selected' : '';?>>4</option>
					<option value="5" <?=$varDay==5 ? 'selected' : '';?>>5</option>
					<option value="6" <?=$varDay==6 ? 'selected' : '';?>>6</option>
					<option value="7" <?=$varDay==7 ? 'selected' : '';?>>7</option>
					<option value="8" <?=$varDay==8 ? 'selected' : '';?>>8</option>
					<option value="9" <?=$varDay==9 ? 'selected' : '';?>>9</option>
					<option value="10" <?=$varDay==10 ? 'selected' : '';?>>10</option>
					<option value="11" <?=$varDay==11 ? 'selected' : '';?>>11</option>
					<option value="12" <?=$varDay==12 ? 'selected' : '';?>>12</option>
					<option value="13" <?=$varDay==13 ? 'selected' : '';?>>13</option>
					<option value="14" <?=$varDay==14 ? 'selected' : '';?>>14</option>
					<option value="15" <?=$varDay==15 ? 'selected' : '';?>>15</option>
					<option value="16" <?=$varDay==16 ? 'selected' : '';?>>16</option>
					<option value="17" <?=$varDay==17 ? 'selected' : '';?>>17</option>
					<option value="18" <?=$varDay==18 ? 'selected' : '';?>>18</option>
					<option value="19" <?=$varDay==19 ? 'selected' : '';?>>19</option>
					<option value="20" <?=$varDay==20 ? 'selected' : '';?>>20</option>
					<option value="21" <?=$varDay==21 ? 'selected' : '';?>>21</option>
					<option value="22" <?=$varDay==22 ? 'selected' : '';?>>22</option>
					<option value="23" <?=$varDay==23 ? 'selected' : '';?>>23</option>
					<option value="24" <?=$varDay==24 ? 'selected' : '';?>>24</option>
					<option value="25" <?=$varDay==25 ? 'selected' : '';?>>25</option>
					<option value="26" <?=$varDay==26 ? 'selected' : '';?>>26</option>
					<option value="27" <?=$varDay==27 ? 'selected' : '';?>>27</option>
					<option value="28" <?=$varDay==28 ? 'selected' : '';?>>28</option>
					<option value="29" <?=$varDay==29 ? 'selected' : '';?>>29</option>
					<option value="30" <?=$varDay==30 ? 'selected' : '';?>>30</option>
					<option value="31" <?=$varDay==31 ? 'selected' : '';?>>31</option>
				</select>

				<select name="dobYear" tabindex="<?=$varTabIndex++?>" style="width:55px;" class="select" onChange="agesel();updateDay('year','frmRegister','dobYear','dobMonth','dobDay');" onBlur="ageChk();">
					<option value="0">-Year-</option>
					<?=$objCommon->getYears($varYear)?>
				</select> or Age <input type="text" name="age" value="<?=$varAge?>" tabindex="<?=$varTabIndex++?>" size=2 maxlength="2" class="inputtext" onfocus="agefocus();" onkeypress="agefocus();ageChk();" onkeyup="agefocus();" onblur="ageChk();" AUTOCOMPLETE="OFF"><br><span id="agespan" class="errortxt"></span></div><br clear="all"/>

				<?if($varUseMatritalStatus) {
					$arrRetMaritalStatus	= $objDomainInfo->getMaritalStatusOption();
					$varSizeMaritalStatus	= sizeof($arrRetMaritalStatus);
					?>
					<input type="hidden" name="maritalStatusOption" value="<?=$varSizeMaritalStatus;?>">
					<?
					if($varSizeMaritalStatus==1) {?>
						<input type="hidden" name="maritalStatus" value="<?=key($arrRetMaritalStatus)?>">
					<?} else {?>
						<div class="smalltxt fleft tlright pfdivlt"><?=$objDomainInfo->getMaritalStatusLabel()?><font class="clr3">*</font></div>
						<div class="pfdivrt smalltxt fleft" id="MaritalStatusDivId">
							<? $i=1;foreach($arrRetMaritalStatus as $funIndex => $funValues) {
								if($i==5) {echo "<BR>";}
								if($funIndex == 1) {
									$varOnclick = "onClick='document.getElementById(\"cstatus\").style.display=\"none\";document.getElementById(\"childliving\").style.display=\"none\";maritalChk();return HaveChildnp(this);'";
								} else {
									$varOnclick = "onClick='document.getElementById(\"cstatus\").style.display=\"block\";maritalChk();return HaveChildnp(this);'";
								}
								$checked = '';
								if($funIndex == $varMaritalStatus) {
								   $checked = "checked";
								}
								echo '<input type="radio" name="maritalStatus" class="smalltxt" value="'.$funIndex.'" tabindex="'.$varTabIndex++.'" '.$varOnclick.' onblur="maritalChk();"'.$checked.'> '.$funValues;
								$i++;
							}//for?>
							<br><span id="maritalspan" class="errortxt"></span>
						</div><br clear="all"/>
					<? }
				} ?>

			<div id="cstatus" <? if ($varCommunityId !='2001') { echo 'style="display:none;"'; } ?>>
				<div class="pfdivlt smalltxt fleft tlright">No. of children<font class="clr3">*</font></div>
				<div class="pfdivrt smalltxt fleft">
					<select class="select1" style="width:100px;" name="noOfChildren" size="1" tabindex="<?=$varTabIndex++?>" onChange="childChk();<? if ($varCommunityId !='2001') { echo 'return Childliv();'; } ?>" onblur="childChk();">
					<option value="" selected >--- Select ---</option>
					<option value="0" <?php if ($varNoOfChildren==0 && $varSelectedChild=="yes") { echo "selected";}?>>None</option>
					<option value="1" <?=$varNoOfChildren==1 ? 'selected' : '';?>>1</option>
					<option value="2" <?=$varNoOfChildren==2 ? 'selected' : '';?>>2</option>
					<option value="3" <?=$varNoOfChildren==3 ? 'selected' : '';?>>3+</option>
					</select>
					<br><span id="nocspan" class="errortxt"></span>
				</div><br clear="all"/>
			</div>

			<div id='childliving' <? if ($varCommunityId !='2001') { echo 'style="display:none;"'; } ?>>
			<div class="pfdivlt smalltxt fleft tlright">Children living status<font class="clr3">*</font></div>
				<div class="pfdivrt smalltxt fleft">
				<input type="radio" class='inputtext' name="childrenLivingWithMe" id="childrenLivingWithMe1" value="0" onfocus="childChk();" onClick="childstatusChk();" tabindex="<?=$varTabIndex++?>" onblur="childstatusChk();" <?php if ($varChildLivingStatus==0 && $varSelectedChild=="yes") { echo "checked"; }//if?> > <label for='childrenLivingWithMe1'><font class="smalltxt">Living with me</font></label>&nbsp;
				<input type="radio" class='inputtext' name="childrenLivingWithMe" id="childrenLivingWithMe2" value="1" onFocus="if(disabled)blur();childChk()" tabindex="<?=$varTabIndex++?>" onClick="childstatusChk();" onblur="childstatusChk();" <?=$varChildLivingStatus==1 ? "checked" : '';?>> <label for='childrenLivingWithMe2'><font class="textsmall">Not living with me</font></label><br><span id="clsspan" class="errortxt"></span>
			</div><br clear="all"/>
			</div>

			<div class="pfdivlt smalltxt fleft tlright">Height<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
				<select name="heightFeet" size="1" tabindex="<?=$varTabIndex++?>" class="select1" style="width:100px;" name="heightFeet" size="1" onChange="return heightChk();" onblur="heightChk();">
				<?=$objCommon->getValuesFromArray($arrHeightFeetList, "--- Select ---", "0", $varHeightFeet);?>
				</select><br><span id="heightspan" class="errortxt"></span>
			</div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">Physical status<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
				<input type="radio" name="physicalStatus" value="0" tabindex="<?=$varTabIndex++?>" class='smalltxt' onClick="showDisabilty(this.form);" onBlur="chkPhysicalStatus(this.form);">Normal
				<input type="radio" name="physicalStatus" value="1" tabindex="<?=$varTabIndex++?>" class='smalltxt' onClick="showDisabilty(this.form);" onBlur="chkPhysicalStatus(this.form);">Physically Challenged
				<br><span id="physicalspan" class="errortxt"></span>
			</div><br clear="all"/>
			
			<div id="disabilitydiv" style="display:none;">
			<div class="pfdivlt smalltxt fleft tlright">Cause of disability</div>
			<div class="pfdivrt smalltxt fleft">
				<select name="disabilitycause" size="1" tabindex="<?=$varTabIndex++?>" class="select1" style="width:150px;" id="disabilitycause" size="1">
				<?=$objCommon->getValuesFromArray($arrDisabilityCause, "--- Select ---", "0", $varDisabilityCause);?>
				</select><br><span id="causespan" class="errortxt"></span>
			</div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">Disability Type</div>
			<div class="pfdivrt smalltxt fleft">
				<? $i=0;
				foreach ($arrDisabilityType as $disabilitytypeval=>$disabilitytypename) {
					$ended=0;
					if ($disabilitytypeval!=0) {
						if($i%3==0) { ?>
							<div class='fleft' style='width:360px;'>
							<? } ?>
							<div class='fleft smalltxt'><input type=checkbox name='disabilitytype[]' id='disabilitytype' value='<?=$disabilitytypeval?>'  tabindex='<?=$varTabIndex++?>' onBlur='chkDisabilityType(this.form);'  onClick='chkDisabilityType(this.form);'></div>
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

			<div id="signlangdiv" style="display:none;">
			<div class="pfdivlt smalltxt fleft tlright">Sign Language<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
				<input type="radio" name="signlanguage" value="1" tabindex="<?=$varTabIndex++?>" class='smalltxt'  onBlur='chkSignLanguage(this.form);'>Yes
				<input type="radio" name="signlanguage" value="2" tabindex="<?=$varTabIndex++?>" class='smalltxt'  onBlur='chkSignLanguage(this.form);'>No<br><span id="signlanguagespan" class="errortxt"></span>
			</div><br clear="all"/>
			</div>

			<div id="severitydiv" style="display:none;">
			<div class="pfdivlt smalltxt fleft tlright">Disability Severity<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
			<?=$objCommon->displayRadioOptions($arrDisabilitySeverity, "disseverity",'','smalltxt','onBlur="chkSeverity(this.form);"',$varTabIndex++);?><br><span id="disseverityspan" class="errortxt"></span>
			</div><br clear="all"/>
			</div>

			<div class="pfdivlt smalltxt fleft tlright">Disability Products</div>
			<div class="pfdivrt smalltxt fleft">
				<? $i=0;
				foreach ($arrDisabilityProducts as $arrdisabilityproductsval=>$arrdisabilityproductsname) {
					$ended=0;
					if ($arrdisabilityproductsval!=0) {
						if($i%3==0) { ?>
							<div class='fleft' style='width:360px;'>
							<? } ?>
							<div class='fleft smalltxt'><input type=checkbox name='disabilityproducts[]' id='disabilityproducts' value='<?=$arrdisabilityproductsval?>' tabindex='<?=$varTabIndex++?>'></div>
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

			<div id="appearanceDiv">
			<? if($varUseAppearance == 1) {
				$arrGetAppearanceOption	= $objDomainInfo->getAppearanceOption();
				$varSizeAppearance		= sizeof($arrGetAppearanceOption);
				?>
				<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getAppearanceLabel();?><font class="clr3">*</font></div>
				<div class="pfdivrt smalltxt fleft">
				<? if($varSizeAppearance>1) {?>
					<? foreach($arrGetAppearanceOption as $key=>$value){
						$varChecked = ($key == $varAppearance)?'checked':'';
						echo '<input type="radio" class="smalltxt" name="appearance" tabindex="'.$varTabIndex++.'" value="'.$key.'"  id="appearance'.$key.'" '.$varChecked.' onblur="ChkEmpty(document.frmRegister.appearance, \'radio\',\'appearancespan\',\'Select the appearance of the prospect\');">'.$value;
					}?><br><span id="appearancespan" class="errortxt"></span>
				<? } ?>
				</div>
				<br clear="all"/>
			<? } echo '</div>';
					if ($confValues["DOMAINCASTEID"] !="") { ?>

			
			<div class="normtxt clr bld fleft padl25 padtb20">Cultural background</div><br clear="all"/>

			<? if($varUseReligion) {
				$arrGetReligionOption = $objDomainInfo->getReligionOption();
				echo '<input type="hidden" name="religionOption" value="'.sizeof($arrGetReligionOption).'">';
				if (sizeof($arrGetReligionOption)==1) { //For Hidden

					echo '<input type="hidden" name="religion" value="'.key($arrGetReligionOption).'">';

				} else { ?>
					<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getReligionLabel()?><font class="clr3">*</font></div>
					<div class="pfdivrt smalltxt fleft">

					<? if (sizeof($arrGetReligionOption)>1) { ?>
					<select name="religion" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect" onChange="funReligion();" onblur="religionChk();">
					<?=$objCommon->getValuesFromArray($arrGetReligionOption, "--- Select ---", "0", $varReligion);?>
					</select>
					<? } else { ?><input type="text" name="religionText" tabindex="<?=$varTabIndex++?>" value=""><? } ?><br><span id="religionspan" class="errortxt"></span></div><br clear="all"/>

			<? }
			}

			if($varUseDenomination) {
				$arrGetDenominationOption = $objDomainInfo->getDenominationOption();
				echo '<input type="hidden" name="denominationOption" value="'.sizeof($arrGetDenominationOption).'">';
				if (sizeof($arrGetDenominationOption)==1) { //For Hidden

					echo '<input type="hidden" name="denomination" value="'.key($arrGetDenominationOption).'">';

				} else {
					$varDenominationLabel	= $objDomainInfo->getDenominationLabel();
					echo '<input type="hidden" name="denominationlabel" value="'.strtolower($varDenominationLabel).'">';
					?>
					<div class="pfdivlt smalltxt fleft tlright"><?=$varDenominationLabel?><font class="clr3">*</font></div>
					<div class="pfdivrt smalltxt fleft">

					<? if (sizeof($arrGetDenominationOption)>1) { ?>
					<select name="denomination" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect" onChange="funDenomination();" onblur="denominationChk();">
					<?=$objCommon->getValuesFromArray($arrGetDenominationOption, "--- Select ---", "0", $varDenomination);?>
					</select><!--start barani -->
					&nbsp;<input type="text" name="denominationText" value="<?=$varDenominationText;?>" onblur="denominationChk();" size="15" class="inputtext" tabindex="<?=$varTabIndex++?>" style="visibility:hidden;" >
					<!--end barani -->
					<? }?><br><span id="denominationspan" class="errortxt"></span></div>
					<br clear="all"/>
			<? }
			}


			if($varUseCaste) {
				$arrGetCasteOption	= $objDomainInfo->getCasteOption();
				$varSizeCaste		= sizeof($arrGetCasteOption);
				echo '<input type="hidden" name="casteOption" value="'.$varSizeCaste.'">';

				if ($varSizeCaste==1) { //For Hidden

				echo '<input type="hidden" class="inputtext" size="35" name="caste" value="'.key($arrGetCasteOption).'" tabindex="'.$varTabIndex++.'">';

				} else {
				$varCasteLabel	= $objDomainInfo->getCasteLabel();
				echo '<input type="hidden" name="castelabel" value="'.strtolower($varCasteLabel).'">';?>
				<div class="pfdivlt smalltxt fleft tlright">
					<? echo '<span id="branchDiv">'.$varCasteLabel.'</span>'; if($varIsCasteMandatory==1){echo '<font class="clr3">*</font>'; $varCasteOnBlur='onBlur="casteChk();"';}?>
				</div>
				<div class="pfdivrt smalltxt fleft">
				<? if ($varSizeCaste>1) { ?>
				<div class="fleft" id="casteDivId"><select class="srchselect" tabindex="<?=$varTabIndex++?>" name="caste" <?=$varCasteOnBlur?> onChange="funCaste('','');casteOthersChk();">
				<?=$objCommon->getValuesFromArray($arrGetCasteOption, "--- Select ---", "0", $varCaste);?>
				</select></div><div class="fleft disnon" id="casteDivText" style="padding-left:10px;"><input type="text" name="casteOthers" size="16" class="inputtext" value="<?=$varCasteText?>" <?=$varCasteOnBlur?> tabindex="<?=$varTabIndex++?>" /></div><br clear="all">
				<? } else { ?> <input type="text" name="casteText" class="inputtext" size="35" value="<?=$varCasteText?>" <?=$varCasteOnBlur?> tabindex="<?=$varTabIndex++?>" style="display:none"> <? } ?><span id="castespan" class="errortxt"></span>
				
				<!-- start barani
				&nbsp;&nbsp;&nbsp;<input type="text" name="casteText1" value="<?=$varCasteText1;?>" size="35" class="inputtext" tabindex="<?=$varTabIndex++?>" style="display:none">
                <!-- end barani -->

				<br clear="all"/><input type="checkbox" tabindex="<?=$varTabIndex++?>" name="casteNoBar" value="1"<?=($varCasteNoBarCheck==1)?"checked=checked":''?>><?=ucwords($varCasteLabel);?> doesn't matter<br><font class="opttxt" style="line-height:11px;">Select '<?=ucwords($varCasteLabel);?> doesn't matter' if you would like to receive alliances from other <?=ucwords($varCasteLabel);?></font></div><br clear="all"/>

			<? }  }else{echo '<input type="hidden" name="casteOption" value=""><div class="fleft" id="casteDivId"></div>';}

			if($varUseSubcaste) {

				$arrGetSubcasteOption = $objDomainInfo->getSubcasteOption();
				echo '<input type="hidden" name="subCasteOption" value="'.sizeof($arrGetSubcasteOption).'">';
				if (sizeof($arrGetSubcasteOption)==1) { //For Hidden
					echo '<input type="hidden" name="subCaste" id="subCaste" value="'.key($arrGetSubcasteOption).'">';
				} else {
					$varSubcasteLabel	= $objDomainInfo->getSubcasteLabel();
					echo '<input type="hidden" name="subcastelabel" value="'.strtolower($varSubcasteLabel).'">';?>
				<div class="pfdivlt smalltxt fleft tlright">
					<?echo $varSubcasteLabel;if($varIsSubcasteMandatory==1){echo '<font class="clr3"><span  id="subcasteMandatorySymbol">*</span></font>'; $varSubcasteOnBlur='onBlur="subcasteChk();" ';}
				if($varIsSubcasteMandatory == 0) {
				   $varSubcasteOnChange=' onChange="subCasteOthersChk();"';}
				?>
				</div>
				<div class="pfdivrt smalltxt fleft">
				<? if (sizeof($arrGetSubcasteOption)>1) { ?>
				<div class="fleft" id="subCasteDivId"><select class="srchselect" tabindex="<?=$varTabIndex++?>" name="subCaste" id="subCaste" <?=$varSubcasteOnBlur?> <?=$varSubcasteOnChange?>>
				<?=$objCommon->getValuesFromArray($arrGetSubcasteOption, "--- Select ---", "0", $varCaste);?>
				</select></div>
				<? } else { ?> <div class="fleft" id="subCasteDivId"><input type="text" tabindex="<?=$varTabIndex++?>" class="inputtext" size="35" name="subCasteText" value="" <?=$varSubcasteOnBlur?>></div> <? } ?><div class="fleft disnon" id="subCasteDivText" style="padding-left:10px;"><input type="text" name="subCasteOthers" onBlur="othsubcasteChk()" size="16" class="inputtext" value="" tabindex="<?=$varTabIndex++?>" /></div><br clear="all"><span id="subcastespan" class="errortxt"></span>
				<? if (sizeof($arrGetCasteOption)==1) { ?><br clear="all"><input type="checkbox" tabindex="<?=$varTabIndex++?>" name="subCasteNoBar" value="1" <?=($varIsSubcasteMandatory==0)?"checked=checked":''?>><?=ucwords($varSubcasteLabel);?> doesn't matter<br><font class="opttxt" style="line-height:11px;">Select '<?=ucwords($varSubcasteLabel);?> doesn't matter' if you would like to receive alliances from other subcaste</font>
				<? } ?>
				</div><br clear="all"/>

			<? }  }else{echo '<input type="hidden" name="subCasteOption" value=""><div class="fleft" id="subCasteDivId"><span id="subcastespan" class="errortxt"></span><br clear="all"/></div>';}  ?>


			<? if($objDomainInfo->useStar() == 1) {
				$arrGetStarOption = $objDomainInfo->getStarOption();

				?>
				<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getStarLabel();?></div>
				<div class="pfdivrt smalltxt fleft">
				<? if(sizeof($arrGetStarOption)>1) {?>
					<select name="star" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect">
					<?=$objCommon->getValuesFromArray($arrGetStarOption, "--- Select ---", "0", $varStar);?>
					</select>
				<? } else { ?>
					<input type="text" name="starText" tabindex="<?=$varTabIndex++?>" class="inputtext" value="<?=$varStar?>">
				<? } ?>
				</div>
				<br clear="all"/>
			<? } ?>


			<? if($varUserGothram == 1) {
				$arrGetGothramOption	= $objDomainInfo->getGothramOption();
				$varGothramCount		= sizeof($arrGetGothramOption);
				$varGotharamMan			= ($varGothramCount > 1) ? '*' : '';
				if($confValues["DOMAINCASTEID"] == 2004) {
				  $varGotharamMan = '';
				}
				echo '<input type="hidden" name="gothramOption" value="'.$varGothramCount.'">';
			?>
				<div id="gothramCommonDivId">
				<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getGothramLabel();?><font class="clr3" ><span id="gothramMandatorySymbol"><?=$varGotharamMan?></span></font></div>
				<div class="pfdivrt smalltxt fleft" id="gothramMainDivId">
				<? if($varGothramCount>1) {
                     if($confValues["DOMAINCASTEID"] == 2004) {
				       $varGothramCheck = 'onChange="anycastegothramChk();"';
					 }
					 else {
					   $varGothramCheck = 'onChange="gothramChk();" onBlur="gothramChk()";';
					 }
				?>
					<div class="fleft" id="gothramDivId"><select name="gothram" size="1" tabindex="<?=$varTabIndex++?>" <?=$varGothramCheck?>  class="srchselect">
					<?=$objCommon->getValuesFromArray($arrGetGothramOption, "--- Select ---", "0", $varGothram);?>
					</select></div><div class="fleft disnon" id="gothramDivText" style="padding-left:10px;"><input type="text" name="gothramOthers" size="16" class="inputtext" value="" onBlur="othgothramChk();" tabindex="<?=$varTabIndex++?>" /></div><br clear="all"><span id="gothraspan" class="errortxt"></span>
				<? } else { ?>
					<input type="text" name="gothramText" size="35" tabindex="<?=$varTabIndex++?>" class="inputtext" value="<?=$varGothramText?>">
				<? } ?>
				</div>
				<br clear="all"/>
				</div>
			<? } } ?>
			<div class="normtxt clr bld fleft padl25 padtb20">Career</div><br clear="all"/>
           
		    <!-- commented on july5-2010
			<div class="pfdivlt smalltxt fleft tlright">Education<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
				<select name="educationCategory" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect" onblur="ChkEmpty(educationCategory, 'select','educationcategoryspan','Please select the education category of the prospect');">
				<?=$objCommon->getValuesFromArray($arrEducationList, "--- Select ---", "0", $varEducationCategory);?>
				</select><br><span id="educationcategoryspan" class="errortxt"></span>
			</div><br clear="all">
            -->

            <div class="pfdivlt smalltxt fleft tlright">Education<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
				<select name="educationCategory" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect" onblur="ChkEmpty(educationCategory, 'select','educationcategoryspan','Please select the education category of the prospect');">
				<option value="0">--- Select ---</option>
				<?
				foreach($arrEducationList as $key1 => $value1) {
	             echo "<optgroup label='".$value1."'>";
                 foreach( $arrEducationMapping as $key2 => $value2 ) {
                  if($value2 == $key1 ) {
	                if($key2 == $varEducationSubcategory) {
		              echo "<option value=$key2 selected>".$arrEducationSubList[$key2]."</option>";
		            }
	                else {
		              echo "<option value=$key2>".$arrEducationSubList[$key2]."</option>";
		            }
		          }
	             }
	             echo "</optgroup>";
                } ?>
				</select><br><span id="educationcategoryspan" class="errortxt"></span>
			</div><br clear="all">

            <?php
			if($confValues["DOMAINCASTEID"] == 2006) {
			  $arrGroupOccupationList = $arrFemaleGroupOccupationList;
			}
			unset($arrGroupOccupationList['u']);unset($arrGroupOccupationList['v']);unset($arrGroupOccupationList['w']); ?>
            <div class="smalltxt fleft tlright pfdivlt">Occupation<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft" id="occupationDivId">
					<select class='srchselect' NAME='occupation' size='1' tabindex="<?=$varTabIndex++?>" class="srchselect" onblur="ChkEmpty(occupation, 'select','occupationspan','Please select the occupation of the prospect');" onchange="selectOccupation(this.value);">
				      <option value="0">--- Select ---</option>
					  <?
					  foreach($arrGroupOccupationList as $key => $value) {
                        $Tmp_arrOccupationMapping = $arrOccupationMapping[$key];
	                    echo "<optgroup label='".$value."'>"; 
                        foreach( $Tmp_arrOccupationMapping as $value ) {
	                     if($value == $varOccupation) {
	                     	echo "<option value=$value selected>".$arrTotalOccupationList[$value]."</option>";
	                     }
		                 else {
		                    echo "<option value=$value>".$arrTotalOccupationList[$value]."</option>";
		                 }
	                    }
	                    echo "</optgroup>";
                     }?>
					</select><br><span id="occupationspan" class="errortxt"></span>
		    </div><br clear="all">

			<? if($varUseEmployedIn) {
					$arrRetEmployedIn	= $objDomainInfo->getEmployedInOption();
					$varSizeEmployedIn	= sizeof($arrRetEmployedIn);
					?>
					<input type="hidden" name="employedinOption" value="<?=$varSizeEmployedIn;?>">
					<?
					if($varSizeEmployedIn==1) {?>
						<input type="hidden" name="employmentCategory" value="<?=key($arrRetEmployedIn)?>">
					<?} else {?>
						<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomainInfo->getEmployedInLabel()?><font class="clr3">*</font></div>
						<div class="fleft smalltxt pfdivrt tlleft">
							<?	foreach($arrRetEmployedIn as $key=>$value){
									$varChecked = ($key == $varEmploymentCategory)?'checked':'';
									echo '<input type="radio" name=employmentCategory value="'.$key.'" id="employmentCategory'.$key.'" '.$varChecked.' onBlur="checkEmployment();" onClick="checkEmployment();"   onKeyPress="checkEmployment();" tabindex='.$varTabIndex++.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>&nbsp;&nbsp;&nbsp;';
							} ?>
							<br><span id="employmentCategoryspan" class="errortxt"></span>
						</div><br clear="all"/>
					<? }
				} ?>
			
			<!--
			<div class="pfdivlt smalltxt fleft tlright">Employed in<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft tlleft">
				<?=$objCommon->displayRadioOptionsForEmployedIn($arrEmployedInList, 'employmentCategory', $varEmploymentCategory,'smalltxt', 'onBlur="checkEmployment();" onKeyPress="checkEmployment();"',$varTabIndex++);?><br><span id="employmentCategoryspan" class="errortxt"></span>
			</div><br clear="all">
            -->

			<? $varTabIndex =  (count($arrEmployedInList)+$varTabIndex-1); ?>

			<div class="pfdivlt smalltxt fleft tlright">Annual income<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
				<select name="annualIncomeCurrency" size="1" tabindex="<?=$varTabIndex++?>" class="select1" onBlur="occupationChk();" style="width:180px;">
				<?=$objCommon->getValuesFromArray($arrSelectCurrencyList, "- Select - ", "0", $varAnnualIncomeCurrency);?>
				</select>&nbsp; &nbsp;&nbsp;<input type="text" tabindex="<?=$varTabIndex++?>" name="annualIncome" value="<?=$varAnnualIncome?>" size="20" class="inputtext" onBlur="amountChk();"><br><span id="annualincomespan" class="errortxt"></span><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="112" height="1" /><span id="amountspan" class="errortxt"></span>
			</div><br clear="all"/>
           
			<div class="normtxt clr bld fleft padl25 padtb20">Location / Contact</div><br clear="all"/>
<? $varTabIndexFooter = $varTabIndex; ?>
			<div class="pfdivlt smalltxt fleft tlright">Country living in<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
				<select name="country" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect"  onChange="countryChk();ajaxStateCall('<?=$confValues['SERVERURL']?>/register/regstatecity.php','<?=$varTabIndex?>');" onblur="countryChk();">
					<? if($confValues["DOMAINCASTEID"] != 2006) { ?>
					<option value="0">--- Select ---</option>
					<option value="98" <?=$varCountry=='98' ? 'selected' : '';?>>India</option>
					<option value="222" <?=$varCountry=='222' ? 'selected' : '';?>>United States of America</option>
					<option value="220" <?=$varCountry=='220' ? 'selected' : '';?>>United Arab Emirates</option>
					<option value="129" <?=$varCountry=='129' ? 'selected' : '';?>>Malaysia</option>
					<option value="221" <?=$varCountry=='221' ? 'selected' : '';?>>United Kingdom</option>
					<option value="13" <?=$varCountry=='13' ? 'selected' : '';?>>Australia</option>
					<option value="185" <?=$varCountry=='185' ? 'selected' : '';?>>Saudi Arabia</option>
					<option value="39" <?=$varCountry=='39' ? 'selected' : '';?>>Canada</option>
					<option value="189" <?=$varCountry=='189' ? 'selected' : '';?>>Singapore</option>
					<option value="114" <?=$varCountry=='114' ? 'selected' : '';?>>Kuwait</option>
					<option value="">-------------------------</option>
					<?=$objCommon->getValuesFromArray($arrCountryList, "", "", $varCountry);?>
					<? } else{ $varCountry = 98;?> <option value="98">India</option> <? } ?>
				</select><br><span id="clspan" class="errortxt"></span>
			</div><br clear="all"/>
            
			<div id="showCitizenship" style="display:<?echo ($varCountry != 98)?'block;':'none;' ?>">
			<div class="pfdivlt smalltxt fleft tlright">Citizenship<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
				<select name="citizenship" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect" onChange="citizen_chk();" onblur="citizen_chk();">
					<option value="0">--- Select ---</option>
					<option value="98" <?=$varCitizenship=='98' ? 'selected' : '';?>>India</option>
					<option value="222" <?=$varCitizenship=='222' ? 'selected' : '';?>>United States of America</option>
					<option value="220" <?=$varCitizenship=='220' ? 'selected' : '';?>>United Arab Emirates</option>
					<option value="129" <?=$varCitizenship=='129' ? 'selected' : '';?>>Malaysia</option>
					<option value="221" <?=$varCitizenship=='221' ? 'selected' : '';?>>United Kingdom</option>
					<option value="13" <?=$varCitizenship=='13' ? 'selected' : '';?>>Australia</option>
					<option value="185" <?=$varCitizenship=='185' ? 'selected' : '';?>>Saudi Arabia</option>
					<option value="39" <?=$varCitizenship=='39' ? 'selected' : '';?>>Canada</option>
					<option value="189" <?=$varCitizenship=='189' ? 'selected' : '';?>>Singapore</option>
					<option value="114" <?=$varCitizenship=='114' ? 'selected' : '';?>>Kuwait</option>
					<option value="">-------------------------</option>
					<?=$objCommon->getValuesFromArray($arrCountryList, "", "", $varCitizenship);?>
				</select><br><span id="citispan" class="errortxt"></span>
			</div><br clear="all"/>
			</div>

			<div class="pfdivlt smalltxt fleft tlright">Residing state<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft" id="stateList">
				<? if($varCountry == 98 || $varCountry == 222) { ?>
				<select name="residingState" tabindex="<?=$varTabIndex++?>" class="srchselect" onBlur="residingstateChk();" onChange="ajaxCityCall('<?=$confValues['SERVERURL']?>/register/regstatecity.php',<?=$varTabIndex?>);residingstateChk();">
					<? if($varCountry == 98){
					    $stateList = $arrResidingStateList;
					   }
					   else if($varCountry == 222) {
					    $stateList = $arrUSAStateList;
					   }
					   $objCommon->getValuesFromArray($stateList, "---Select---", "0", $varResidingState);
					?>
				</select>
				<? } else { ?> 
					<input type="text" class="inputtext" name="residingState" size="37" tabindex=<?=$varTabIndex++?> maxlength="40" value="<?=$varResidingState?>" onblur="residingstateChk();">	
				<? } ?>
				<br>

				<!-- Email Bubble out div-->
				<div id="embubdiv" style="z-index:2001;margin-left:215px;display:none;"><span class="posabs" style="width:153px; height:62px;background:url('http://img.communitymatrimony.com/images/email_img.gif') no-repeat;padding-top:1px;padding-left:21px;"><span class="smalltxt clr3 tlleft" style="width:120px;padding-left:2px;">Will not be revealed to members. It is purely for<br> helping us communicate<br> with you.</span></span></div>
				<!-- Email Bubble out div-->

				<span id="residingstatespan" class="errortxt"></span>
			</div><br clear="all"/>
            <? if($varResidingState > 0) { include_once($varRootBasePath."/conf/cityarray.cil14"); } ?>
			<div class="pfdivlt smalltxt fleft tlright">Residing City / District<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft" id="cityList">
				<? if($varCountry == 98) { ?>
				<select name="residingCity" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect" onBlur="residingcityChk();">
				<? if ($varCountry == 98 && $varResidingState > 0) { 
		            $stateList = $$residingCityStateMappingList[$varResidingState];
			        $objCommon->getValuesFromArray($stateList, "---Select---", "0", $varResidingCity);
				   }
				   else {
				    echo '<option value="0">--- Select ---</option>'; 
				   }
				?>
				</select>
				<? } else { ?>
				    <input type="text" class="inputtext" name="residingCity" tabindex=<?=$varTabIndex++?> id="residingCity" size="37" maxlength="40" onBlur="residingcityChk();" value="<?=$varResidingCity?>">
				<? } ?>
				<br><span id="residingcityspan" class="errortxt"></span>
			</div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">Email<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft"><input type="text" name="email" value="<?=$varEmail;?>" size=37 class="inputtext" tabindex="<?=$varTabIndex++?>" onfocus="showdiv('embubdiv');" onblur="emailChk();hidediv('embubdiv');"><br><span id="emailspan" class="errortxt"></span></div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright" id="firstContDiv">Phone number<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft" id='secContDiv'>
			<input type="text" onKeypress="return allowNumeric(event);" tabindex="<?=$varTabIndex++?>" class="inputtext" size="2" name="countryCode" value="<?=($varCountryCode!='') ? $varCountryCode : 'ISD';?>" onBlur="conchk();phCCode();" onFocus="phCCode();">
			<input type="text" onKeypress="return allowNumeric(event);" tabindex="<?=$varTabIndex++?>" class="inputtext" size="2" name="areaCode" value="<?=($varAreaCode!='') ? $varAreaCode : 'STD';?>" onBlur="conchk();phSCode();" onFocus="phSCode();">
			<input type="text" onKeypress="return allowNumeric(event);" tabindex="<?=$varTabIndex++?>" class="inputtext" size="13" name="phoneNo" value="<?=($varPhoneNo!='') ? $_REQUEST['phoneNo'] : 'Telephone number';?>" onBlur="conchk();teleNoCheck();" onFocus="teleNoCheck();">&nbsp;&nbsp;(and / or)&nbsp;&nbsp;<input type="text" tabindex="<?=$varTabIndex++?>" onKeypress="return allowNumeric(event);" class="inputtext" size="15" name="mobileNo" value="<?=($varMobileNo!='') ? $_REQUEST['mobileNo'] : 'Mobile number';?>" onBlur="conchk();mobNoCheck();" onFocus="mobNoCheck();"><br>
			<font class="opttxt" style="line-height:11px;">Please enter a valid phone number otherwise members will not be able to contact you. It is also mandatory that you verify your phone number.</font><br><span id="phonespan" class="errortxt"></span></div><br clear="all"/>

			<!-- Need help content -->
			<div id="needhelpdiv" class="boxdiv posabs brdr" style="display:none;z-index:1001;margin:0px !important;margin:0px;margin-left:-50px;">
				<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="hidediv('needhelpdiv');showSelectBoxes();" class="pntr" ></div><br clear="all">
				<div class="smalltxt clr">Hi, I'm Sachin from Bangalore. I'm a software professional employed in a leading BPO. I speak English, Hindi & Kannada. I'm smart and pleasing in nature and have a lot of friends. I hope to find someone who is cheerful, pleasant and a good friend.<br><br>
				I'm an architect and work as a consultant for a Real Estate firm in Chennai. I love my job and will continue working after marriage. Being the only child for my parents, I prefer to marry someone from the same city. He should be understanding, co-operative and must be well-settled in his career.<br><br>
				We are seeking a suitable alliance for our daughter from the same caste and preferably from the same city we live in. our daughter is slim and fair and currently employed as an HR Manager in a reputed firm. We have 3 children. Our 2 boys are married and live in different cities. <br><br>
				Hi, I'm Manoj, a doctor by profession and practicing in a government hospital in Delhi. I'm passionate about good Dhaba food and whenever I get free time, I love to sleep or watch movies. I'm looking for an understanding partner who will support me in my career aspirations. <br>
				<div class="fright padtb10"><input type="button" class="button pntr" value="Close" onclick="hidediv('needhelpdiv');showSelectBoxes();"></div>
				</div>
			</div>
			<!-- Need help content -->

			<div class="normtxt clr bld fleft padl25 padtb20">Family details</div><br clear="all"/>


			<? if($varUseMotherTongue == 1) {
				$arrMotherTongueOption = $objDomainInfo->getMotherTongueOption();
				unset($arrMotherTongueOption['9997']);

				?>

				<input type="hidden" name="motherTongueOption" value="<?=sizeof($arrMotherTongueOption)?>">

				<input type="hidden" name="motherTonguetabIndex" value="<?=$varTabIndex?>">

				<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getMotherTongueLabel();?><font class="clr3">*</font></div>
				<div class="pfdivrt smalltxt fleft" id="MotherTongueDivId">
				<? if(sizeof($arrMotherTongueOption)>1) { ?>
					<select name="motherTongue" onblur="motherChk();" tabindex="<?=$varTabIndex++?>" class="srchselect">
					<?=$objCommon->getValuesFromArray($arrMotherTongueOption, "--- Select ---", "0", $varMotherTongue);?>
					</select>
				<? } else { ?>
					<input type="text" tabindex="<?=$varTabIndex++?>" name="motherTongueText" class="inputtext" value="<?=$varMotherTongue?>">
				<? } ?><br><span id="mothertonguespan" class="errortxt"></span></div><br clear="all"/>
			<? } ?>


			<div class="pfdivlt smalltxt fleft tlright">Family value<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
				<select name="familyValue" class="srchselect" onblur="ChkEmpty(familyValue, 'select','familyvaluespan','Please select the family value of the prospect');" tabindex="<?=$varTabIndex++?>">
				<?=$objCommon->getValuesFromArray($arrFamilyValuesList, "--- Select ---", "0", $varFamilyValue);?>
				</select><br><span id="familyvaluespan" class="errortxt"></span></div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">Family type<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
				<select name="familyType" tabindex="<?=$varTabIndex++?>" class="srchselect" onblur="ChkEmpty(familyType, 'select','familytypespan','Please select the family type of the prospect');">
				<?=$objCommon->getValuesFromArray($arrFamilyType, "--- Select ---", "0", $varFamilyType);?>
				</select><br><span id="familytypespan" class="errortxt"></span></div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">Status<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">
				<select name="familyStatus" tabindex="<?=$varTabIndex++?>" class="srchselect" onblur="ChkEmpty(familyStatus, 'select','familystatusspan','Please select the family status of the prospect');">
				<?=$objCommon->getValuesFromArray($arrFamilyStatus, "--- Select ---", "0", $varFamilyStatus);?>
				</select><br><span id="familystatusspan" class="errortxt"></span></div><br clear="all"/>

			<div id="religiousethnicityDiv">
			<? if($varUseReligious == 1) {
				$arrGetReligiousOption	= $objDomainInfo->getReligiousValuesOption();
				$varSizeReligious		= sizeof($arrGetReligiousOption);
				//echo '<input type="hidden" name="religiousOption" value="'.$varSizeReligious.'">';
				?>
				<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getReligiousValuesLabel();?></div>
				<div class="pfdivrt smalltxt fleft">
				<? if($varSizeReligious>1) {?>
					<select name="religious" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect">
					<?=$objCommon->getValuesFromArray($arrGetReligiousOption, "--- Select ---", "0", $varReligious);?>
					</select><br><span id="religiousspan" class="errortxt"></span>
				<? } else if($varSizeReligious==1){ ?>
					<input type="hidden" name="religious" value="<?=key($arrGetReligiousOption)?>">
				<? } ?>
				</div>
				<br clear="all"/>
			<? } ?>

			<? if($varUseEthnicity == 1) {
				$arrGetEthnicityOption	= $objDomainInfo->getEthnicityOption();
				$varSizeEthnicity		= sizeof($arrGetEthnicityOption);
				//echo '<input type="hidden" name="ethnicityOption" value="'.$varSizeEthnicity.'">';
				?>
				<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getEthnicityLabel();?></div>
				<div class="pfdivrt smalltxt fleft">
				<? if($varSizeEthnicity>1) {?>
					<select name="ethnicity" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect">
					<?=$objCommon->getValuesFromArray($arrGetEthnicityOption, "--- Select ---", "0", $varEthnicity);?>
					</select><br><span id="ethnicityspan" class="errortxt"></span>
				<? } else if($varSizeEthnicity==1){ ?>
					<input type="hidden" name="ethnicity" value="<?=key($arrGetEthnicityOption)?>">
				<? } ?>
				</div>
				<br clear="all"/>
			<? } ?>
			</div>

			<div class="normtxt clr bld fleft padl25 padtb20">Password for login</div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">Password<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft"><input type="password" name="password" value="<?=$varPassword;?>" size=35 class="inputtext" tabindex="<?=$varTabIndex++?>" onBlur="passwordChk();"><br><span id="passwdspan" class="errortxt"></span></div>
			<br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">Confirm password<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft"><input type="password" name="confirmPassword" value="<?=$varPassword;?>" size=35 class="inputtext" tabindex="<?=$varTabIndex++?>" onBlur="passwordCChk();"><br><span id="cpasswdspan" class="errortxt"></span></div><br clear="all"/><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright"><div class="normtxt clr bld fleft padl25 padtb5">About Me</div><br clear="all"/>A few lines about you<font class="clr3">*</font><br><a class="clr1 notbld smalltxt" onclick="showdiv('needhelpdiv');hideSelectBoxes('frmRegister');">Need help?</a></div>
			<div class="pfdivrt smalltxt fleft">
				<textarea title="spellcheck" accesskey="<?=$confValues["SERVERURL"];?>/spellchecker/spellchecker.php" name="DESCDET" id="description1" cols="42" rows="4" class="tareareg" tabindex="<?=$varTabIndex++?>" onfocus="alen=this.value;document.getElementById('desccount').innerHTML=alen.length;" onkeyup='alen=this.value;document.getElementById("desccount").innerHTML=alen.length;' onblur="descChk();alen=this.value;document.getElementById('desccount').innerHTML=alen.length;" style="width:325px;"><?=$varAboutMyself?></textarea><br><span>Min. 50 characters</span><span id="desccount" style="padding-left:30px;">0</span><span> Characters typed</span><br><span id="aboutmyselfspan" class="errortxt"></span><input name="description" value="" id="description" type="hidden">
			</div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">About my partner<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft"><input type="text" name="aboutMyPartner" value="<?=$varAboutMyPartner;?>" size=35 maxlength="100" class="inputtext" tabindex="<?=$varTabIndex++?>" onBlur="ChkEmpty(document.frmRegister.aboutMyPartner, 'text','aboutmypartnerspan','Please enter partner details of the prospect');"> &nbsp;<font class="opttxt">Max. 100 characters</font><br><span id="aboutmypartnerspan" class="errortxt"></span></div><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">I want to marry<font class="clr3">*</font></div>
			<div class="pfdivrt smalltxt fleft">			<?=$objCommon->displayRadioOptions($arrWantToMarry,'getMarried',$varGetMarried,'smalltxt','onBlur="getMarriedChk();"',$varTabIndex++);?><br><span id="getmarriedspan" class="errortxt"></span>
			</div><br clear="all"/>
			<? $varTabIndex =  (count($arrWantToMarry)+$varTabIndex-1); ?>
            <?php
		      if($_POST['addRegister'] == 'yes') {
			    if($varTermsAndConditions == 'Y') {
			      $acceptChecked = 'checked';
			    } 
			    else {
			      $acceptChecked = '';
			    }
			  }
			  else {
			    $acceptChecked = 'checked';
			  }
		   ?>
		   <div class="pfdivlt fleft"><!-- --></div><div class="pfdivrt fleft"><font class="smalltxt"><input type="checkbox" <?=$acceptChecked?> tabindex="<?=$varTabIndex++?>" value="Y" name="termsAndConditions"/> I accept the <a href="javascript:commterms();" class="clr1">Terms & Conditions</a> </font><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="125" /><input type="submit" class="button" tabindex="<?=$varTabIndex++?>" value="Submit"/><br><span id="termsspan" class="errortxt"></span></div><br clear="all"/>

	</div><br clear="all"/>
	</form>
	</div>

<?

	if ($varCommunityId=='0'){

		echo '<script language="javascript">document.frmRegister.domainName.focus();</script>';

	} else {

		echo '<script language="javascript">document.frmRegister.profileCreatedBy[0].focus();</script>';

	}


// Inorganic (Google) campaign lead track calling - Starts //
if(trim($varPartlyId)!='' && $varPartnerLanding=='yes') {

	// CBS Campaign Leadtrack script calling - Added by Ashok / Dhanapal //
	echo "<script src=\"http://campaign.bharatmatrimony.com/cbstrack/leadtrack.php?regid=".$varPartlyId."&language=\"></script>";

	echo "<script>countryChk();ajaxStateCall('".$confValues['SERVERURL']."/register/regstatecity.php','".$varTabIndexFooter++."');</script>";
}

/* Click Tracking Initiate */
if ($varTrackId!="" && $varFormFeed=='y') {
	$varTrackType = '';
	if ($_REQUEST['type']=='internal') {
		$varTrackType = 'internal';
	}
	echo "<script src=\"http://campaign.bharatmatrimony.com/cbstrack/clicktrack.php?trackid=".$varTrackId."&type=".$varTrackType."&formfeed=y\"></script>";
}

//UNSET
UNSET($objPartlyRegister);

if($varGender) {
 echo "<script>populateOccupation('$varGender','$varOccupation');</script>";
}

if($varPhysicalStatus)
echo "<script>showDisabilty('document.frmRegister');</script>";
if($_REQUEST['disabilitytype'])
echo "<script>chkDisabilityType('document.frmRegister');</script>";

if($varUseReligion && sizeof($arrGetReligionOption)>1 && $varReligion) {
  echo "<script>funReligion('$varCaste');</script>";
}
if($varUseDenomination && sizeof($arrGetDenominationOption)>1 && $varDenomination) {
  echo "<script>funDenomination('$varCaste');</script>";
}
if($varUseCaste && $varSizeCaste>1 && $varCaste) {
  if($varSubCaste == 9997) {$varSubCaste=0; }
  echo "<script>funCaste('$varCaste','$varSubCaste');casteOthersChk();</script>";
}
if($varUserGothram && $varGothram) { 
 echo "<script>funGothramChk('".$varGothram."');</script>";
}
/*
if ($varCountry !="" && $varCountry >'0') { 
	echo "<script>countryChk();ajaxStateCall('".$confValues['SERVERURL']."/register/regstatecity.php','".$varTabIndexFooter++."','".$varResidingState."','".$varResidingCity."');</script>";
}*/ 
if ($varMaritalStatus !="" ) { echo "<script>maritalChk();HaveChildnp();</script>"; }
if ($varEmploymentCategory !="" && $confValues["DOMAINCASTEID"] != 2006 ) { echo "<script>checkEmployment();</script>"; }
if($varOccupation) {
	echo "<script>selectOccupation(document.frmRegister.occupation.value);</script>";
}
?>