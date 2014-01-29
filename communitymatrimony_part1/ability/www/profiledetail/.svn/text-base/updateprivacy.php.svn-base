<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-23
# Project	  : MatrimonyProduct
# Filename	  : updateprivacy.php
#=====================================================================================================================================
# Description : Privacy Setting change Here
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];


//OBJECT DECLARATION
$objProfileDetailMaster	= new ProfileDetail;
$objProfileDetailSlave	= new ProfileDetail;
//VARIABLE DECLARATION
$varCurrentDate			= date('Y-m-d H:i:s');
$varPrivacyVal			= $_REQUEST['privacyval'];
$varFields				= $_REQUEST['fields'];

if($sessMatriId==""){
	$varMessage='You are either logged off or your session timed out. <a href="http://'.$confValues['SERVERURL'].'/login/login.php" class="clr1">Click here</a> to login.';
}else{
	$objProfileDetailMaster	->dbConnect('M',$varDbInfo['DATABASE']);
	$argCondition			= "MatriId=".$objProfileDetailMaster->doEscapeString($sessMatriId,$objProfileDetailMaster);

	if($varPrivacyVal == 0) {
		//delete filter info
		$objProfileDetailMaster->delete($varTable['MEMBERFILTERINFO'],$argCondition);

		//set filter set status in memberinfo table
		$argFields 			= array('Filter_Set_Status','Date_Updated');
		$argFieldsValues	= array(0,"'".$varCurrentDate."'");
		$varUpdateId		= $objProfileDetailMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);

	} else if($varPrivacyVal == 2) {
		//Getting Member Caste or denomination based on their citizenchip
		$objProfileDetailSlave	->dbConnect('S',$varDbInfo['DATABASE']);
		$argFields					= array('Citizenship');
		$argCondition				= "WHERE MatriId=".$objProfileDetailSlave->doEscapeString($sessMatriId,$objProfileDetailSlave);
		$varMemberInfoResultSet		= $objProfileDetailSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varMemberInfoResult		= mysql_fetch_assoc($varMemberInfoResultSet);
		$varCitizenId				= $varMemberInfoResult['Citizenship'];

		//set filter info
		$arrFilter				= explode('^',$varFields);
		$varReligiousVal		= trim($arrFilter[0],'~');
		$arrAge					= explode(',',$arrFilter[1]);
		$varCountryVal			= trim($arrFilter[2],'~');
		$varCasteVal			= trim($arrFilter[3],'~');
		$varMaritalVal			= trim($arrFilter[4],'~');
		$varMotherTongueVal		= trim($arrFilter[5],'~');
		
		$argCondition			= "MatriId='".$sessMatriId."'";
		$argFields				= array('MatriId','Religion','Caste','Mother_Tongue','Marital_Status','Age_Above','Age_Below','Country','Date_Updated');
		$argFieldsValues		= array($objProfileDetailMaster->doEscapeString($sessMatriId,$objProfileDetailMaster),"'".$varReligiousVal."'","'".$varCasteVal."'","'".$varMotherTongueVal."'","'".$varMaritalVal."'","'".$arrAge[0]."'","'".$arrAge[1]."'","'".$varCountryVal."'","'".$varCurrentDate."'");
		$varUpdateId			= $objProfileDetailMaster->insertOnDuplicate($varTable['MEMBERFILTERINFO'],$argFields,$argFieldsValues,$argCondition);

		//set filter set status in memberinfo table
		$argFields 			= array('Filter_Set_Status','Date_Updated');
		$argFieldsValues	= array(1,"'".$varCurrentDate."'");
		$varUpdateId		= $objProfileDetailMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);
	}
	$objProfileDetailMaster->dbClose();
	$objProfileDetailSlave->dbClose();
	
}
unset($objProfileDetailMaster);
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/fade.css">
<div  style="padding: 10px;">
	<div style="padding: 0 0 2 0px"><font class="mediumtxt boldtxt clr3"><b>Privacy Settings</b></font></div>
	<div>
	  <div class="divborder" style="margin: 0px 0px 0px 0px">
		<div style="padding: 5px;">
				<font class="smalltxt">Your privacy settings have been successfully updated.</font>
			 </div>
		</div>
		<div class="fright" style="padding-top: 5px;">
	<input type="button" class="button" value="Close" onclick="javascript:parent.closeIframe('iframeicon','icondiv');"></div>
	</div>
</div>