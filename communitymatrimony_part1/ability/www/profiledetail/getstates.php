<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-08-13
# Project	  : MatrimonyProduct
# Filename	  : getstates.php
#=====================================================================================================================================
# Description : display corresponding states for country which is passed from Ajaxcall.
#=====================================================================================================================================
//PATH INCLUDES
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/vars.cil14");

//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
function getValuesFromArray($argArrName, $argNullOptionName, $argNullOptionValue, $argSelectedValue) {
	$funOptions	="";	
	if($argNullOptionName !="")
	{ $funOptions .= '<option value="'.$argNullOptionValue.'">'.$argNullOptionName.'</option>'; }//if
	foreach($argArrName as $funIndex => $funValues) {
		$funSelectedItem = $argSelectedValue==$funIndex ? "selected" : "";
		$funOptions .= '<option value="'.$funIndex.'" '.$funSelectedItem.'>'.$funValues.'</option>';
	}//for
	
	return $funOptions;
	
}//getValuesFromArray

if(isset($_REQUEST["countryid"]) && $_REQUEST["countryid"]!="") {
	$countryid = $_REQUEST["countryid"];
	$success_msg = "<div class='smalltxt fleft tlright pfdivlt'>State<span class='clr3'>*</span></div><div class='fleft pfdivrt tlleft'>";
	if($countryid == 98) {
		$success_msg.="<select  name='residingState' id='residingState' class='srchselect' onChange=modrequestnew(this.value); onblur='ChkEmpty(document.frmProfile.residingState, \"select\", \"locresidingstate\",\"Please select the resident state of the prospect\");'>";

		$success_msg.=getValuesFromArray($arrResidingStateList, '- Select - ', '0', $varMemberInfo['Residing_State']);
		$success_msg.="</select>";
	} else if($countryid == 222) {
		$success_msg.="<select  name='residingState' id='residingState' class='srchselect' onblur='ChkEmpty(document.frmProfile.residingState, \"select\", \"locresidingstate\",\"Please select the resident state of the prospect\");'>";

		$success_msg.=getValuesFromArray($arrUSAStateList, '- Select - ', '0', $varMemberInfo['Residing_State']);
		
		$success_msg.="</select>";
	} else {
		$success_msg.="<input type=hidden name='otherState' value='1'>";
		$success_msg.="<input type=text name='residingState' size=32 maxlength=40 id='residingState' class='inputtext' value='' onblur='ChkEmpty(document.frmProfile.residingState, \"text\", \"locresidingstate\",\"Please enter the resident state of the prospect\");'>";
	}

	$success_msg.="<br><span id='locresidingstate' class='errortxt'></span></div><br clear='all'>";
							
						
	if($countryid == 98) {

		$success_msg.="<div class='smalltxt fleft tlright pfdivlt'>City/District<span class='clr3'>*</span></div>";
	} else {
	
		$success_msg.="<div class='smalltxt fleft tlright pfdivlt'>City<span class='clr3'>*</span></div>";
	}
	$success_msg.="<div class='fleft pfdivrt tlleft'>";
	if($countryid == 98) {
		//$varTmpState = ${$residingCityStateMappingList[$varMemberInfo['Residing_State']]};
		$varTmpState = array();
	 $success_msg.="<select  name='residingCity' id='residingCity' class='srchselect' onblur='ChkEmpty(document.frmProfile.residingCity, \"select\", \"locresidingcity\",\"Please select the residing city of the prospect\");'>";
	 $success_msg.=getValuesFromArray($varTmpState, '- Select - ', '0', $varMemberInfo['Residing_District']);
	 $success_msg.="</select>";
	} else {
		 $success_msg.="<input type=hidden name='otherCity' value='1'>";
		 $success_msg.="<input type=text name='residingCity' size=32 maxlength=40 class='inputtext'  id='residingCity' value='".$varMemberInfo['Residing_City']."' onblur='ChkEmpty(document.frmProfile.residingCity, \"text\", \"locresidingcity\",\"Please enter the residing city of the prospect\");'>";
	}
				
	$success_msg.="<br><span id='locresidingcity' class='errortxt'></span></div><br clear='all'>";
	echo $success_msg;
} else {
	echo '0~-Select-';
}
?>