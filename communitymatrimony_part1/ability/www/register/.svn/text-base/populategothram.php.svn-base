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


//VARIABLE DECLARATION
$varContent	= '';
$varCasteId	= trim($_REQUEST['casteId']);
$varGothramId	= trim($_REQUEST['gothramId']);
$varCommunityId = trim($_REQUEST['communityId']);

//OBJECT INITIALIZATION
$objDomainInfo			= new domainInfo;
$arrGetGothramOption	= $objDomainInfo->getGothramOptionsForCaste($varCasteId);
$varGothramCount		= sizeof($arrGetGothramOption);

//GOTHRAM POPULATE LIST
 if($varGothramCount>1) {

	  if($varCommunityId == 2004) {
		$varGothramCheck = ' onChange="anycastegothramChk();"';
	  }
	  else {
		$varGothramCheck = ' onChange="gothramChk();"      onBlur="gothramChk();" ';
	  }
	  $varContent  .='<div class="fleft" id="gothramDivId"><select name="gothram" size="1" ';
	  $varContent .= $varGothramCheck;
	  $varContent  .=' class="srchselect"><option value="0">--- Select ---</option>';
	  foreach($arrGetGothramOption as $k=>$v) {
       if($k == $varGothramId)
	    $varContent	.= '<option value="'.$k.'" selected>'.$v.'</option>';
	   else
        $varContent	.= '<option value="'.$k.'">'.$v.'</option>'; 
	  }
	  $varContent	.= '</select></div><div class="fleft disnon" id="gothramDivText" style="padding-left:10px;"><input type="text" name="gothramOthers" onBlur="othgothramChk();" size="16" class="inputtext"/></div><br clear="all"><span id="gothraspan" class="errortxt"></span>';
	  $varContent	= $varGothramCount.'~'.$varContent;
	} else {

		$varContent		.= '<input type="text" name="gothramText" size="35" class="inputtext fleft" value="">';
		$varContent		= '~'.$varContent;
	}
echo trim($varContent);
?>