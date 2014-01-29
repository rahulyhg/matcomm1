<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
#================================================================================================================

//FILE INCLUDES
$varRootBasePath		= '/home/product/community';
$varDomainNameInfo	= trim($_REQUEST['domain']);
$_SERVER["HTTP_HOST"]	= 'www.'.$varDomainNameInfo;
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");

$varTabIndex	= 14;
$varReligiousFeature	= 0;
$varEthinicityFeature	= 0;
$i=1;

//$varMaritalStatus = '<script>var MaritalCnt='.sizeof($arrMaritalList).'</script>';
$varMaritalStatus = '';

foreach($arrMaritalList as $funIndex => $funValues) {
	if($i==5) { $varMaritalStatus .= '<br>'; }
	
	if($funIndex == 1) {
		$varOnclick = "onClick=\"document.getElementById('cstatus').style.display='none';document.getElementById('childliving').style.display='none';maritalChk();return HaveChildnp(this);\"";
	} else {
		$varOnclick .= 'onClick=\'document.getElementById("cstatus").style.display="block";maritalChk();return HaveChildnp(this);\'';
	}
		$varMaritalStatus .= '<input type="radio" name="maritalStatus" class="smalltxt" value="'.$funIndex.'" tabindex="'.$varTabIndex++.'" onClick="maritalChk();HaveChildnp(this);" onblur="maritalChk();"> '.$funValues;
		$i++;
}

$varMaritalStatus .= '<br><span id="maritalspan" class="errortxt"></span>';

#===================== Marital Staus Display Part ==========================

//VARIABLE DECLARATION
$varTabIndex	= trim($_REQUEST['tabIndex']);

$arrMotherTongueList = $arrMotherTongueList;
unset($arrMotherTongueList['9997']);

if(sizeof($arrMotherTongueList)>1) {

	$varMotherTongue	.= '<select name="motherTongue" onblur="motherChk();" tabindex="'.$varTabIndex++.'" class="srchselect"><option value="0">--- Select ---</option>';

	foreach($arrMotherTongueList as $varIndex => $varValue) {
		$varMotherTongue .= '<option value="'.$varIndex.'">'.$varValue.'</option>';
	}//for

	$varMotherTongue	.= '</select>';
 } else {
	$varMotherTongue	.= '<input type="text" tabindex="'.$varTabIndex++.'" name="motherTongueText" class="inputtext" value="">';
 } 
	$varMotherTongue	.= '<br><span id="mothertonguespan" class="errortxt"></span>';

$varTabIndex++;$varTabIndex++;$varTabIndex++;
#===================== Religious  & Ethnicity ==========================

$varReligiousEthnicity	= '';
$varSizeReligious		= 0;
$varSizeEthnicity		= 0;

if (($varDomainNameInfo=='muslimmatrimony.com') || ($varDomainNameInfo=='christianmatrimony.com') || ($varDomainNameInfo=='buddhistmatrimony.com') ) {

	$varReligiousFeature	= 1;
	$varEthinicityFeature	= 1;

	if ($varDomainNameInfo=='buddhistmatrimony.com') { $varReligiousFeature	= 0;  }

	if ($varDomainNameInfo!='buddhistmatrimony.com') {

	$varSizeReligious		= sizeof($arrReligiousList);
	//$varReligiousEthnicity	.= '<input type="hidden" name="religiousOption" value="'.$varSizeReligious.'">';
	$varReligiousEthnicity	.= '<div class="pfdivlt smalltxt fleft tlright">Religious Values<font class="clr3">*</font></div>';
	$varReligiousEthnicity	.= '<div class="pfdivrt smalltxt fleft">';
	
	if($varSizeReligious>1) { 

		$varReligiousEthnicity	.= '<select name="religious" size="1" tabindex="'.$varTabIndex++.'" class="srchselect" onblur="religiousChk();"><option value="0">--- Select ---</option>';

		foreach($arrReligiousList as $varIndex => $varValue) {
			$varReligiousEthnicity .= '<option value="'.$varIndex.'">'.$varValue.'</option>';
		}//for

		$varReligiousEthnicity	.= '</select><br><span id="religiousspan" class="errortxt"></span>';
	} else if($varSizeReligious==1){ 

		$varReligiousEthnicity	.= '<input type="hidden" name="religious" value="'.key($arrReligiousList).'">';
	} 
	$varReligiousEthnicity	.= '</div><br clear="all"/>';

}


	$varSizeEthnicity		= sizeof($arrEthnicityList);
	//$varReligiousEthnicity	.= '<input type="hidden" name="ethnicityOption" value="'.$varSizeEthnicity.'">';
	$varReligiousEthnicity	.= '<div class="pfdivlt smalltxt fleft tlright">Ethnicity<font class="clr3">*</font></div>';
	$varReligiousEthnicity	.= '<div class="pfdivrt smalltxt fleft">';
	
	if($varSizeEthnicity>1) {

	$varReligiousEthnicity	.= '<select name="ethnicity" size="1" tabindex="'.$varTabIndex++.'" class="srchselect" onblur="ethnicityChk();"><option value="0">--- Select ---</option>';

		foreach($arrEthnicityList as $varIndex => $varValue) {
			$varReligiousEthnicity .= '<option value="'.$varIndex.'">'.$varValue.'</option>';
		}//for

	$varReligiousEthnicity	.= '</select><br><span id="ethnicityspan" class="errortxt"></span>';

	} else if($varSizeEthnicity==1){ 

		$varReligiousEthnicity	.= '<input type="hidden" name="ethnicity" value="'.key($arrEthnicityList).'">';
	} 
	$varReligiousEthnicity	.= '</div><br clear="all"/>';

}

#===================== Appearance ==========================

$varAppearanceContent	= '';
$varAppearanceFeature	= 0;

if ($varDomainNameInfo=='sikhmatrimony.com') {

$varAppearanceFeature = 1;

$varAppearanceContent .= '<div class="pfdivlt smalltxt fleft tlright">Appearance<font class="clr3">*</font></div>';

$varAppearanceContent .= '<div class="pfdivrt smalltxt fleft">';

$varSizeAppearance	= sizeof($arrAppearanceList);
	if($varSizeAppearance>1) {

		foreach($arrAppearanceList as $key=>$value){

			$varChecked = ($key == $varAppearance)?'checked':'';
						$varAppearanceContent .= '<input type="radio" class="smalltxt" name="appearance" tabindex="'.$varTabIndex++.'" value="'.$key.'"  id="appearance'.$key.'" '.$varChecked.' onblur="ChkEmpty(document.frmRegister.appearance, \'radio\',\'appearancespan\',\'Select the appearance of the prospect\');">'.$value;
					} 

	$varAppearanceContent .= '<br><span id="appearancespan" class="errortxt"></span>';

				 } 

	$varAppearanceContent .= '</div><br clear="all"/>';

}
//echo $varDomainNameInfo.'='.$varAppearanceFeature.'#~$'.$varReligiousFeature.'#~$'.$varEthinicityFeature;
echo $varMaritalStatus.'#~$'.$varMotherTongue.'#~$'.$varReligiousEthnicity.'#~$'.sizeof($arrMaritalList).'#~$'.$varSizeReligious.'#~$'.$varSizeEthnicity.'#~$'.$varAppearanceContent.'#~$'.$varAppearanceFeature.'#~$'.$varReligiousFeature.'#~$'.$varEthinicityFeature;

UNSET($objDomainInfo1);


?>