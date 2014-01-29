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
$varCasteId			= trim($_REQUEST['casteId']);
$varCasteSize		= trim($_REQUEST['castesize']);
$arrSubCasteList	= array();	

$varContent			= '';

//STATE LIST
if ($varCasteId) {
	if($objDomain->useSubcaste()) {
		$varIsSubcasteMandatory	= $objDomain->isSubcasteMandatory();
		$arrSubCasteList		= $objDomain->getSubcasteOptionsForCaste($varCasteId);
		$varCount				= sizeof($arrSubCasteList);

		$varContent		.= '<input type="hidden" name="subcastetxtfeature" value="'.$varCount.'">';
		if($varCount==1) {
			$varContent		.= '<input type="hidden" name="subcaste" value="'.key($arrSubCasteList).'">';
		} else {
			if($varIsSubcasteMandatory==1) {
				$varSpanSubcasteDiv	= '<span class="clr3">*</span>';
				$varSubcasteOnBlur	= 'onBlur="subcasteChk();"';
			} else {
				$varSpanCasteDiv	= '';
			}
			$varSubcasteLabel= $objDomain->getSubcasteLabel();
			echo '<input type="hidden" name="subcastelabel" value="'.strtolower($varSubcasteLabel).'">';
			$varContent		.= '<div class="smalltxt fleft tlright pfdivlt">';
			$varContent		.= $varSubcasteLabel;
			$varContent		.= $varSpanSubcasteDiv;
			$varContent		.= '</div>';
			$varContent		.= '<div class="fleft pfdivrt tlleft">';
			if ($varCount > 1) {
				$varContent		.= '<div class="fleft"><select size="1" name="subcaste" id="subcaste" class="srchselect" '.$varSubcasteOnBlur.' onChange="chkOthersSubcaste();">';
				$varContent		.= '<option value="0">- Select -</option>';

				foreach($arrSubCasteList as $k=>$v) {
				$varContent		.= '<option value="'.$k.'">'.$v.'</option>';
				}
				$varContent		.= '</select></div>';
				$varContent		.= '<div class="fleft" id="othsubcastediv" style="display:none;padding-left:10px"><input type=text name=othsubCaste value="" size=15 class="inputtext" id="othsubCaste"  onBlur="checkOthSubcaste();"></div>';
			} else {
				$varContent		.='<input type="text" class="inputtext" size="30" name="othsubCaste" value="" '.$varSubcasteOnBlur.'>';
			}
			$varContent		.= '<br clear="all"><span id="subcastespan" class="errortxt"></span>';
			$varContent		.= '</div><br clear="all"/>';
			if($varCount>1 && ($varCasteSize<=1 || $varCasteSize=='')){
				$varContent		.= '<div class="smalltxt fleft tlright pfdivlt">'.ucwords($varSubcasteLabel).' doesn\'t matter</div>';
				$varContent		.= '<div class="fleft pfdivrt tlleft smalltxt"><input type=checkbox name=subCasteNoBar value="1">';
				$varContent		.= 'Yes <br><font class="smalltxt">Select \''.ucwords($varSubcasteLabel).' doesn\'t matter\' if you would like to receive alliances from other '.strtolower($varSubcasteLabel).'</font>';
				$varContent		.= '</div><br clear="all"/>';
			}
		}
	} else {
		$varContent		= '<input type="hidden" name="subcastetxtfeature" value="0">';
	}
}
echo trim($varContent);
?>