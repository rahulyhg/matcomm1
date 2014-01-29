<?php
#================================================================================================================
# Author 	: Baranidharan
# Date		: 09-Aug-2010
# Project	: MatrimonyProduct
# Filename	: populateoccupation.php
#================================================================================================================

//FILE INCLUDES
$varRootBasePath	= '/home/product/community';
include_once($varRootBasePath."/lib/clsDomain.php");
include_once($varRootBasePath.'/conf/ppinfo.cil14');

//VARIABLE DECLARATION
$varGenderId		= trim($_REQUEST['gender']);
$varOccupation		= trim($_REQUEST['occupation']);

if($varGenderId) {
if($varGenderId == 1) {
  $arrGroupOccupationList = $arrMaleGroupOccupationList;
  $arrTotalOccupationList = $arrMaleDefenceOccupationList;
}
else {
  $arrGroupOccupationList = $arrFemaleGroupOccupationList;
  $arrTotalOccupationList = $arrFemaleDefenceOccupationList;
}
?><select class='srchselect' NAME='occupation' size='1' class="srchselect" onblur="ChkEmpty(occupation, 'select','occupationspan','Please select the occupation of the prospect');" onchange="selectOccupation(this.value);">
<option value="0">--- Select ---</option>
<?
foreach($arrGroupOccupationList as $key => $value) {
      $Tmp_arrOccupationMapping = $arrOccupationMapping[$key];
	   if($varGenderId != 1) {
		  $varContent.= "<optgroup label='".$value."'>"; }
        foreach( $Tmp_arrOccupationMapping as $value ) {
		  if($value == $varOccupation) {
	         	$varContent .="<option value=$value selected>".$arrTotalOccupationList[$value]."</option>";
	       }
	       else {
		        $varContent .= "<option value=$value>".$arrTotalOccupationList[$value]."</option>";
	       }
        }
		$varContent.="</optgroup>";
}
$varContent.='</select><br><span id="occupationspan" class="errortxt"></span>';
echo $varContent;
} 