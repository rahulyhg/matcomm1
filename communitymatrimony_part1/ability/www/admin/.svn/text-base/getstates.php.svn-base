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
include_once($varRootBasePath."/conf/vars.inc");

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
	$success_msg = "<tr><td valign='top' class='smalltxt boldtxt' style='padding-top:5px;padding-left:10px;padding-bottom:3px;' width='25%'>Residing state :</td><td valign='top' class='smalltxt' style='padding-top:5px;padding-left:0px;padding-bottom:3px;' width='25%'><span id='locresidingstate' class='errortxt'></span>";
	if($countryid == 98) {
		$success_msg.="<select class='combobox' name='residingState' size='1' onChange=cityrequest(this.value);>";
		$success_msg.=getValuesFromArray($arrResidingStateList, '- Select - ', '0', $varMemberInfo['Residing_State']);
		$success_msg.="</select>";
	} else if($countryid == 222) {
		$success_msg.="<select class='combobox' name='residingState' size='1'>";
		$success_msg.=getValuesFromArray($arrUSAStateList, '- Select - ', '0', $varMemberInfo['Residing_State']);
		$success_msg.="</select>";
	} else {
		$success_msg.="<input type=hidden name='otherState' value='1'>";
		$success_msg.="<input type=text name='residingState' size=20 maxlength=20 id='residingState' class='smalltxt' value=''>";
	}						
						
	$success_msg.="</td><td valign='top' class='smalltxt boldtxt' style='padding-top:5px;padding-left:10px;padding-bottom:3px;' width='25%'>Residing city / district:</td><td valign='top' class='smalltxt' style='padding-top:5px;padding-left:0px;padding-bottom:3px;' width='25%'><span id='locresidingstate' class='errortxt'></span>";
	if($countryid == 98) {
		$varTmpState = ${$residingCityStateMappingList[$varMemberInfo['Residing_State']]};
	 $success_msg.="<select class='combobox' name='residingCity' id='residingCity' size='1'>";
	 $success_msg.=getValuesFromArray($varTmpState, '- Select - ', '0', $varMemberInfo['Residing_District']);
	 $success_msg.="</select>";
	} else {
		 $success_msg.="<input type=hidden name='otherCity' value='1'>";
		 $success_msg.="<input type=text name='residingCity' id='residingCity' size=20 maxlength=20 class='smalltxt'  id='residingCity' value='".$varMemberInfo['Residing_City']."'>";
	}
	$success_msg.="</td></tr>";
	echo $success_msg;
} else {
	echo '0~-Select-';
}
?>