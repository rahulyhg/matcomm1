<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
#================================================================================================================

//FILE INCLUDES
$varRootBasePath	= '/home/product/community/ability';
include_once($varRootBasePath."/lib/clsDomain.php");

//OBJECT INITIALIZATION
$objDomain	= new domainInfo;

//VARIABLE DECLARATION
$varField			= trim($_REQUEST['field']);
$varReligionId		= trim($_REQUEST['religionId']);
$varDenominationId	= trim($_REQUEST['denominationId']);

$arrCasteList		= array();


//CATSE POPULATE LIST

if (($varReligionId >0 && $varField=='religion') || ($varDenominationId >0 && $varField=='denomination')) {
	if($objDomain->useCaste()) {
		$varIsCasteMandatory= $objDomain->isCasteMandatory();
		if($varReligionId >0 && $varField=='religion') {
			$arrCasteList	= $objDomain->getCasteOptionsForReligion($varReligionId);
		} else if($varDenominationId >0 && $varField=='denomination') {
			$arrCasteList	= $objDomain->getCasteOptionsForDenomination($varDenominationId);
		}
		$varCasteCount	= count($arrCasteList);
		
		$varContent		= "<input type='hidden' name='castetxtfeature' value='".$varCasteCount."'>";

		if ($varCasteCount == 1) {
			$varContent	.= '<input type="hidden" name="caste" value="'.key($arrRetCaste).'">';
		} else {
			if($varIsCasteMandatory==1) {
				$varSpanCasteDiv	= '<span class="clr3">*</span>';
				$varCasteOnBlur		= "onBlur='casteChk();'";
			} else {
				$varSpanCasteDiv	= '';
			}
			$varCasteLabel= $objDomain->getCasteLabel();
			echo '<input type="hidden" name="castelabel" value="'.strtolower($varCasteLabel).'">';
			$varContent	.= '<div class="smalltxt fleft tlright pfdivlt" >';
			$varContent	.= $varCasteLabel;
			$varContent	.= $varSpanCasteDiv;
			$varContent	.= '</div>';
			$varContent	.= '<div class="fleft pfdivrt tlleft">';
			
			if($varCasteCount>1){
				$varContent	.= "<div class='fleft'><select name='caste' id='caste' class='srchselect' onChange='chkOthersCaste();funCaste(\"".$varCasteCount."\");' ".$varCasteOnBlur.">";
				$varContent		.= '<option value="0">- Select -</option>';

				foreach($arrCasteList as $k=>$v) {
				$varContent		.= '<option value="'.$k.'">'.$v.'</option>';
				}
				$varContent		.= '</select></div>';
				$varContent		.= "<div class='fleft' id='othcastediv' style='display:none;padding-left:10px'><input type=text name=othCaste value='' size=15 class='inputtext' id='othCaste' ".$varCasteOnBlur."></div>";
			} else { 
				$varContent		.= "<input type=text name=othCaste value='' size=30 class='inputtext' ".$varCasteOnBlur.">";
			} 
			$varContent		.= '<br clear="all"><span id="castespan" class="errortxt"></span>';
			$varContent		.= '</div><br clear="all"/>';
		}

		if($varCasteCount>1){
			$varContent		.= '<div class="smalltxt fleft tlright pfdivlt">'.ucwords($varCasteLabel).' doesn\'t matter</div>';
			$varContent		.= '<div class="fleft pfdivrt tlleft smalltxt"><input type=checkbox name=casteNoBar value="1"> Yes <br><font class="smalltxt">Select \''.ucwords($varCasteLabel).' doesn\'t matter\' if you would like to receive alliances from other '.strtolower($varCasteLabel).'</font></div><br clear="all"/>';
		}
	} else {
		$varContent		= '<input type="hidden" name="castetxtfeature" value="0">';
	}
}
echo trim($varContent);
?>