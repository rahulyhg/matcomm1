<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
#================================================================================================================

//FILE INCLUDES
$varServerRoot		= $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath	= dirname($varServerRoot);
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath."/conf/cityarray.cil14");

//VARIABLE DECLARATION
$varCountry	= trim($_REQUEST['country']);
$varState	= trim($_REQUEST['state']);
$varDisplay	= trim($_REQUEST['display']);
$varTabIndex= trim($_REQUEST['tabIndex']);

if ($varCountry!="" && $varDisplay == 'state') {
	$varStateList = '';

	if (($varCountry == "98")||($varCountry == "222")) {

		if($varCountry == "98") {
			$stateList = $arrResidingStateList; 
			$varStateList .= "<select class=\"srchselect\" name=\"residingState\" size=\"1\" tabindex=\"".$varTabIndex++."\" onChange=\"ajaxCityCall('".$confValues['SERVERURL']."/register/regstatecity.php','".$varTabIndex."');residingstateChk();\" onblur=\"residingstateChk();\"><option value=\"0\">--- Select ---</option>";
			
		}
		elseif($varCountry == "222") { 
			$stateList = $arrUSAStateList;
			$varStateList .= "<select class=\"srchselect\" name=\"residingState\" size=\"1\" tabindex=\"".$varTabIndex++."\" onChange=\"residingstateChk();\" onblur=\"residingstateChk();\"><option value=\"0\">--- Select ---</option>";
		}
		
		asort($stateList);
		foreach($stateList as $varIndex => $varValue) {
			$varStateList .= '<option value="'.$varIndex.'" '.$funSelectedItem.'>'.$varValue.'</option>';
		}//for
		$varStateList .= '</select><br><!-- Email Bubble out div--><div id="embubdiv" style="z-index:1001;margin-left:215px;display:none;"><span class="posabs" style="width:153px;height:62px;background:url(\'http://img.communitymatrimony.com/images/email_img.gif\') no-repeat;padding-top:1px;padding-left:21px;"><span class="smalltxt clr3 tlleft" style="width:120px;padding-left:2px;">Will not be revealed to members. It is purely for<br> helping us communicate<br> with you.</span></span></div><!-- Email Bubble out div--><span id="residingstatespan" class="errortxt"></span>';

	} else {

		$varStateList .= '<input type="text" class="inputtext" name="residingState" size="37" tabindex=\"'.$varTabIndex++.'\" maxlength="40" value="" onblur="residingstateChk();"><br><!-- Email Bubble out div--><div id="embubdiv" style="z-index:1001;margin-left:215px;display:none;"><span class="posabs" style="width:153px;height:62px;background:url(\'http://img.communitymatrimony.com/images/email_img.gif\') no-repeat;padding-top:1px;padding-left:21px;"><span class="smalltxt clr3 tlleft" style="width:120px;padding-left:2px;">Will not be revealed to members. It is purely for<br> helping us communicate<br> with you.</span></span></div><!-- Email Bubble out div--><span id="residingstatespan" class="errortxt"></span>';
		
		//&nbsp;&nbsp;<font class="normaltxt1"><font color="#FF6600"></font></font>';
	}
	echo $varStateList;
}

if ($varDisplay == 'city') {

	if ($varCountry == "98") { 
		$stateList = $$residingCityStateMappingList[$varState];
		asort($stateList);
		$varTabIndex++;
		$varCityList	.= '<select name="residingCity" size="1" tabindex="'.$varTabIndex++.'" class="srchselect"  onBlur="residingcityChk();"><option value="0">--- Select ---</option>';
		foreach($stateList as $varIndex => $varValue) {
			$varCityList .= '<option value="'.$varIndex.'" '.$funSelectedItem.'>'.$varValue.'</option>';
		}//for
		$varCityList	.= '</select><br><span id="residingcityspan" class="errortxt"></span>';

	} else {

		$varCityList	.= '<input type="text" class="inputtext" name="residingCity" tabindex="'.$varTabIndex++.'" id="residingCity" size="37" maxlength="40" onBlur="residingcityChk();"><br><span id="residingcityspan" class="errortxt"></span>';
	}

	echo $varCityList;
}
?>