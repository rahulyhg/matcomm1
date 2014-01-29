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

if(isset($_REQUEST["occupationid"]) && $_REQUEST["occupationid"]!="") {
	$occupationId = $_REQUEST["occupationid"];
	$selOccId = $_REQUEST["selOcc"];
	
	$success_msg = "";
	if($occupationId == 2) {
		$success_msg.="<SELECT class='inputtext' NAME='occupation' size='1' style='width:190px;'>";

		$success_msg.=getValuesFromArray($arrDefenceOccupationList, '- Select - ', '0', $selOccId);
		$success_msg.="</select>";
	} else if($occupationId == 1) {
		$success_msg.="<SELECT class='inputtext' NAME='occupation' size='1' style='width:190px;'>";

		$success_msg.=getValuesFromArray($arrOccupationList, '- Select - ', '0', $selOccId);
		
		$success_msg.="</select>";
	} 

	$success_msg.="</div>";
	echo $success_msg;
} else {
	echo '0~-Select-';
}
?>