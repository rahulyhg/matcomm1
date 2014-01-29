<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-07-18
# End Date		: 2008-07-18
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsRegister.php');

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
$varIsSubcasteMandatory	= $objDomainInfo->isSubcasteMandatory();
$varUseSubcaste			= $objDomainInfo->useSubcaste();
$varUseMotherTongue		= $objDomainInfo->useMotherTongue();
$varUserGothram			= $objDomainInfo->useGothram();
$varUseReligious		= $objDomainInfo->useReligiousValues();
$varUseEthnicity		= $objDomainInfo->useEthnicity();

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

?>
<script language=javascript src="<?=$confValues["JSPATH"];?>/cbsregister.js"></script>
<form name="frmRegister" method="POST" style="padding:0px;margin:0px;" onSubmit="return cbsRegisterValidate();">
<input type="hidden" name="cbsRegister" value="yes">
<input type="hidden" name="act" value="congrats">
<input type="hidden" name="category" value="<?=$varCategory?>">
<input type="hidden" name="oppositeId" value="<?=$varOppId?>">
<input type="hidden" name="religionfeature" value="<?=$varUseReligion?>">
<input type="hidden" name="denominationfeature" value="<?=$varUseDenomination?>">
<input type="hidden" name="castefeature" value="<?=$varUseCaste?>">
<input type="hidden" name="castemandatory" value="<?=$varIsCasteMandatory?>">
<input type="hidden" name="subcastefeature" value="<?=$varUseSubcaste?>">
<input type="hidden" name="subcastemandatory" value="<?=$varIsSubcasteMandatory?>">
<input type="hidden" name="gothramfeature" value="<?=$varUserGothram?>">
<input type="hidden" name="religiousfeature" value="<?=$varUseReligious?>">
<input type="hidden" name="communityId" value="<?=$confValues["DOMAINCASTEID"]?>">

<div class="rpanel fleft">
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
		</select>
		<? }?><br><span id="denominationspan" class="errortxt"></span></div><br clear="all"/>
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
		<?echo $varCasteLabel;if($varIsCasteMandatory==1){echo '<font class="clr3">*</font>'; $varCasteOnBlur='onBlur="casteChk();"';}?>
	</div>
	<div class="pfdivrt smalltxt fleft">
	<? if ($varSizeCaste>1) { ?>
	<div class="fleft" id="casteDivId"><select class="srchselect" tabindex="<?=$varTabIndex++?>" name="caste" <?=$varCasteOnBlur?> onChange="casteOthersChk();funCaste('');">
	<?=$objCommon->getValuesFromArray($arrGetCasteOption, "--- Select ---", "0", $varCaste);?>
	</select></div><div class="fleft disnon" id="casteDivText" style="padding-left:10px;"><input type="text" name="casteOthers" size="16" class="inputtext" value="" tabindex="<?=$varTabIndex++?>" /></div><br clear="all">
	<? } else { ?> <input type="text" name="casteText" class="inputtext" size="35" value="" tabindex="<?=$varTabIndex++?>"> <? } ?><span id="castespan" class="errortxt"></span><br clear="all"/><input type="checkbox" tabindex="<?=$varTabIndex++?>" name="casteNoBar" value="1"><?=ucwords($varCasteLabel);?> doesn't matter<br><font class="opttxt" style="line-height:11px;">Select '<?=ucwords($varCasteLabel);?> doesn't matter' if you would like to receive alliances from other <?=ucwords($varCasteLabel);?></font></div><br clear="all"/>

	<? }  }else{echo '<input type="hidden" name="casteOption" value=""><div class="fleft" id="casteDivId"></div>';}

	if($varUseSubcaste) {

	$arrGetSubcasteOption = $objDomainInfo->getSubcasteOption();
	echo '<input type="hidden" name="subCasteOption" value="'.sizeof($arrGetSubcasteOption).'">';
	if (sizeof($arrGetSubcasteOption)==1) { //For Hidden
		echo '<input type="text" name="subCaste" value="'.key($arrGetSubcasteOption).'">';
	} else {
		$varSubcasteLabel	= $objDomainInfo->getSubcasteLabel();
		echo '<input type="hidden" name="subcastelabel" value="'.strtolower($varSubcasteLabel).'">';?>
	<div class="pfdivlt smalltxt fleft tlright">
		<?echo $varSubcasteLabel;if($varIsSubcasteMandatory==1){echo '<font class="clr3">*</font>'; $varSubcasteOnBlur='onBlur="subcasteChk();"';}?>
	</div>
	<div class="pfdivrt smalltxt fleft">
	<? if (sizeof($arrGetSubcasteOption)>1) { ?>
	<div class="fleft" id="subCasteDivId"><select class="srchselect" tabindex="<?=$varTabIndex++?>" name="subCaste" <?=$varSubcasteOnBlur?>>
	<?=$objCommon->getValuesFromArray($arrGetSubcasteOption, "--- Select ---", "0", $varCaste);?>
	</select></div><div class="fleft disnon" id="subCasteDivText" style="padding-left:10px;"><input type="text" name="subCasteOthers" size="16" class="inputtext" value="" tabindex="<?=$varTabIndex++?>" /></div><br clear="all">
	<? } else { ?> <div id="subCasteDivId"><input type="text" tabindex="<?=$varTabIndex++?>" class="inputtext" size="35" name="subCasteText" value="" <?=$varSubcasteOnBlur?>></div> <? } ?><span id="subcastespan" class="errortxt"></span><br clear="all"/>
	<? if (sizeof($arrGetCasteOption)==1) { ?><input type="checkbox" tabindex="<?=$varTabIndex++?>" name="subCasteNoBar" value="1"><?=ucwords($varSubcasteLabel);?> doesn't matter<br><font class="opttxt" style="line-height:11px;">Select '<?=ucwords($varSubcasteLabel);?> doesn't matter' if you would like to receive alliances from other subcaste</font>
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
	echo '<input type="hidden" name="gothramOption" value="'.$varGothramCount.'">';
	?>
	<div id="gothramCommonDivId">
	<div class="pfdivlt smalltxt fleft tlright"><?=$objDomainInfo->getGothramLabel();?><font class="clr3"><?=$varGotharamMan?></font></div>
	<div class="pfdivrt smalltxt fleft" id="gothramMainDivId">
	<? if($varGothramCount>1) {?>
		<div class="fleft" id="gothramDivId"><select name="gothram" size="1" tabindex="<?=$varTabIndex++?>" onChange="gothramChk();" onBlur="gothramChk();" class="srchselect">
		<?=$objCommon->getValuesFromArray($arrGetGothramOption, "--- Select ---", "0", $varGothram);?>
		</select></div><div class="fleft disnon" id="gothramDivText" style="padding-left:10px;"><input type="text" name="gothramOthers" size="16" class="inputtext" value="" tabindex="<?=$varTabIndex++?>" /></div><br clear="all"><span id="gothraspan" class="errortxt"></span>
	<? } else { ?>
		<input type="text" name="gothramText" size="35" tabindex="<?=$varTabIndex++?>" class="inputtext" value="<?=$varGothramText?>">
	<? } ?>
	</div>
	<br clear="all"/>
	</div>
<? } ?>
</div>
			<div class="pfdivlt fleft">&nbsp;</div>
			<div class="pfdivrt fright"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="225" /><input type="submit" class="button" tabindex="<?=$varTabIndex++?>" value="Submit"/><br><span id="termsspan" class="errortxt"></span></div><br clear="all"/>
</form>