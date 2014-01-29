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
include_once($varRootBasePath."/conf/productvars.cil14");

//VARIABLE DECLARATION
$varSectId = $_REQUEST["sectid"];

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

if(isset($varSectId) && $varSectId!="") {
	$success_msg = "";
	if($varSectId == 1) {
		unset($arrCasteDivisionList[4]);
		unset($arrCasteDivisionList[5]);
		unset($arrCasteDivisionList[6]);
		unset($arrCasteDivisionList[7]);
		unset($arrCasteDivisionList[8]);
	} else if($varSectId == 2) {
		unset($arrCasteDivisionList[1]);
		unset($arrCasteDivisionList[2]);
		unset($arrCasteDivisionList[3]);
	}
	$success_msg.="<SELECT class='inputtext' NAME='casteDivision' size='1' style='width:190px;'>";
	$success_msg.=getValuesFromArray($arrCasteDivisionList, '- Select - ', '', '');
	$success_msg.="</select>";
	
	echo $success_msg;
} else {
	echo '0~-Select-';
}
?>