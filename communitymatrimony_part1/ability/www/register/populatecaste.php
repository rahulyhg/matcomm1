<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
#================================================================================================================

//FILE INCLUDES
$varRootBasePath	= '/home/product/community';
include_once($varRootBasePath."/lib/clsDomain.php");

//OBJECT INITIALIZATION
$objDomainInfo	= new domainInfo;

//VARIABLE DECLARATION
$varField			= trim($_REQUEST['field']);
$varReligionId		= trim($_REQUEST['religionId']);
$varDenominationId	= trim($_REQUEST['denominationId']);
$varCasteId			= trim($_REQUEST['casteId']);
$varSubCasteId		= trim($_REQUEST['subcasteId']);
$varCommunityId = trim($_REQUEST['communityId']);

$arrCasteList		= array();	
$arrSubCasteList	= array();	
$varCasteOnBlur		='';
$varSubcasteOnBlur	='';


//SUBCATSE POPULATE LIST

if (($varReligionId >0 && $varField=='religion') || ($varDenominationId >0 && $varField=='denomination')) {
	
	if($objDomainInfo->useCaste()) {
		$varCasteMandatory	= $objDomainInfo->isCasteMandatory();
		if($varCasteMandatory==1) {
			$varCasteOnBlur='onBlur="casteChk();"';
		}
		if($varReligionId >0 && $varField=='religion') {
			
			if ($varReligionId=='7'){
				
				$arrCasteList = array(38=>"Mahayana",39=>"Nichiren Buddhism",40=>"Pure Land Buddhism",41=>"Tantrayana (Vajrayana Tibetan)",42=>"Theravada (Hinayana)",43=>"Tendai Buddhism  (Japanese)",44=>"Zen Buddhism (China)",9997=>"Others"); //8=>"Others" changed as 9997=>"Others";

			} else { $arrCasteList	= $objDomainInfo->getCasteOptionsForReligion($varReligionId); }

		} else if($varDenominationId >0 && $varField=='denomination') {
			$arrCasteList	= $objDomainInfo->getCasteOptionsForDenomination($varDenominationId);
		}
		$varCasteCount	= count($arrCasteList);

		if ($varCasteCount > 0) {
		
			$varContent		= "<select size=\"1\" name=\"caste\" tabindex=\"26\" class=\"srchselect\" ".$varCasteOnBlur." onChange=\"casteOthersChk();funCaste('');\">";

			$varContent		.= '<option value="0">--- Select ---</option>';

			foreach($arrCasteList as $k=>$v) {
			  if($k == $varCasteId)
              $varContent		.= '<option value="'.$k.'" selected>'.$v.'</option>';
			  else
			  $varContent		.= '<option value="'.$k.'">'.$v.'</option>';
			}
			$varContent		.= '</select>';
			$varContent		= $varCasteCount.'~'.$varContent;
		} else {
			$varContent		="<input type=\"text\" class=\"inputtext\" tabindex=\"26\" size=\"35\" name=\"casteText\" ".$varCasteOnBlur.">";
			$varContent		= '0~'.$varContent;
		}

	} else { $varContent		= '0~'; }

} else {

	$varSubcasteMandatory	= $objDomainInfo->isSubcasteMandatory();
	if($varSubcasteMandatory==1) {
		$varSubcasteOnBlur="onBlur='subcasteChk();'";
	}
	if($varSubcasteMandatory == 0) {
		$varSubcasteOnChange="onChange='subCasteOthersChk();'";
	}

	if ($varCasteId > 0 && $varField=='caste') {
	
		if($objDomainInfo->useSubcaste()) {
			
			$arrSubCasteList	= $objDomainInfo->getSubcasteOptionsForCaste($varCasteId);
			$varSubCasteCount	= count($arrSubCasteList);

			if ($varSubCasteCount > 0) {
			
				$varContent		= "<select size='1' name='subCaste' id='subCaste' tabindex='29' class='srchselect' ".$varSubcasteOnBlur. "   " .$varSubcasteOnChange." >";
				$varContent		.= '<option value="0">--- Select subcaste ---</option>';

				foreach($arrSubCasteList as $k=>$v) {
				  if($k == $varSubCasteId)
				  $varContent		.= '<option value="'.$k.'" selected>'.$v.'</option>';
				  else
				  $varContent		.= '<option value="'.$k.'">'.$v.'</option>';
				}
				$varContent		.= '</select>';
				$varContent		= $varSubCasteCount.'~'.$varContent;
			} else {
				$varContent		="<input type='text' class='inputtext' tabindex='29' size='35' name='subCasteText' value=''  ".$varSubcasteOnBlur.">";
				$varContent		= '~'.$varContent;
			}
		} else {
			$varContent		= '0~';
		}
	} else if ($varField=='subCasteText') {

			$varContent		="<input type='text' class='inputtext' tabindex='29' size='35' name='subCasteText' value='' ".$varSubcasteOnBlur.">";
			$varContent		= '~'.$varContent;

	}
}




/*
if (castefeate==1 ) {
	if sizeof(religion==1){
		$retCaste=$objDomainInfo->getCasteOption();
	} else if sizeof(religion>1){
		$retCaste=$objDomainInfo->getReligionCasteOption();
	}
 }*/

echo trim($varContent);
?>