<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-20
# Project	  : MatrimonyProduct
# Filename	  : changepassword.php
#=====================================================================================================================================
# Description : Password change Here
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
include_once($varRootBasePath.'/lib/clsDB.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];

//OBJECT DECLARATION
$objDBMaster= new DB;
$objDBslave	= new DB;

//CONNECT DATABASE
$objDBslave->dbConnect('S',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['updatefilter'];
$varPrivacyVal		= $_REQUEST['privacyval'];
$varFields			= $_REQUEST['fields'];
$varCurrentDate		= date('Y-m-d H:i:s');

$varSelectedDiv		= 1;
$varTotalDiv		= 4;

unset($arrSubCasteTrimmed['9998']);
$varSubcasteCnt	= count($arrSubCasteTrimmed);
if($varSubcasteCnt<=1 && $_FeatureSubcaste==1 && $_FeatureSubcasteTxt==0) {
	$_FeatureSubcaste=0;
}


function findFlagDtls($_FeatureSubcaste,$_FeatureSubcasteTxt,$_FeatureCaste,$_FeatureReligion) {
	if(($_FeatureSubcaste==1 && $_FeatureSubcasteTxt==0) && $_FeatureCaste==1 && $_FeatureReligion==1) {
		return 1;
	} else if(($_FeatureSubcaste==1 && $_FeatureSubcasteTxt==0) && $_FeatureCaste==1 && $_FeatureReligion==0) {
		return 2;
	} else if(($_FeatureSubcaste==1 && $_FeatureSubcasteTxt==0) && $_FeatureCaste==0 && $_FeatureReligion==1) {
		return 3;
	} else if(($_FeatureSubcaste==1 && $_FeatureSubcasteTxt==0) && $_FeatureCaste==0 && $_FeatureReligion==0) {
		return 4;
	} else if($_FeatureSubcaste==0 && $_FeatureCaste==1 && $_FeatureReligion==1) {
		return 5;
	} else if($_FeatureSubcaste==0 && $_FeatureCaste==1 && $_FeatureReligion==0) {
		return 6;
	} else if($_FeatureSubcaste==0 && $_FeatureCaste==0 && $_FeatureReligion==1) {
		return 7;
	}
}

function createShowSlideFn($argSelectedDiv,$argTotalDiv) {
	//'div_1','div_2','div_3','div_4','div_5','div_6','d1','d2','d3','d4','d5','d6'
	$firstDiv	= '';
	$firstD		= '';
	$remainDiv	= '';
	$remainD	= '';
	for($i=1;$i<=$argTotalDiv;$i++) {
		if($i == $argSelectedDiv) {
			$firstDiv	= "'div_".$i."',";
			$firstD		= "'d".$i."',";
		} else {
			$remainDiv	.= "'div_".$i."',";
			$remainD	.= "'d".$i."',";
		}
	}

	$varTotalArg	= $firstDiv.$remainDiv.$firstD.$remainD;
	return trim($varTotalArg,',');
}

if($sessMatriId==""){
	$varMessage='You are either logged off or your session timed out. <a href="http://'.$confValues['SERVERURL'].'/login/login.php" class="clr1">Click here</a> to login.';exit;
} else if($varUpdatePrimary == 'yes') {

	$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);
	$argCondition	= "MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);

	if($varPrivacyVal == 0) {
		//delete filter info
		$objDBMaster->delete($varTable['MEMBERFILTERINFO'],$argCondition);

		//set filter set status in memberinfo table
		$argFields 			= array('Filter_Set_Status','Date_Updated');
		$argFieldsValues	= array(0,"'".$varCurrentDate."'");
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);

	} else if($varPrivacyVal == 2) {
		//set filter info
		$arrFilter			= explode('^',$varFields);
		$arrAge				= explode(',',$arrFilter[0]);
		$varCountryVal		= trim($arrFilter[1],'~');
		$varMaritalVal		= trim($arrFilter[2],'~');
		$varMotherTongueVal	= trim($arrFilter[3],'~');

		switch(findFlagDtls($_FeatureSubcaste,$_FeatureSubcasteTxt,$_FeatureCaste,$_FeatureReligion)) {
			case 1:
					$varSubcasteVal	= trim($arrFilter[4],'~');
					$varCasteVal	= trim($arrFilter[5],'~');
					$varReligiousVal= trim($arrFilter[6],'~');
					break;

			case 2:
					$varSubcasteVal	= trim($arrFilter[4],'~');
					$varCasteVal	= trim($arrFilter[5],'~');
					$varReligiousVal= '';
					break;

			case 3:
					$varSubcasteVal	= trim($arrFilter[4],'~');
					$varCasteVal	= '';
					$varReligiousVal= trim($arrFilter[5],'~');
					break;

			case 4:
					$varSubcasteVal	= trim($arrFilter[4],'~');
					$varCasteVal	= '';
					$varReligiousVal= '';
					break;
			
			case 5:
					$varSubcasteVal	= '';
					$varCasteVal	= trim($arrFilter[4],'~');
					$varReligiousVal= trim($arrFilter[5],'~');
					break;

			case 6:
					$varSubcasteVal	= '';
					$varCasteVal	= trim($arrFilter[4],'~');
					$varReligiousVal= '';
					break;

			case 7:
					$varSubcasteVal	= '';
					$varCasteVal	= '';
					$varReligiousVal= trim($arrFilter[4],'~');
					break;
		}
		
		
		$argCondition		= "MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$argFields			= array('MatriId','Religion','CommunityId','SubcasteId','Mother_Tongue','Marital_Status','Age_Above','Age_Below','Country','Date_Updated');
		$argFieldsValues	= array($objDBMaster->doEscapeString($sessMatriId,$objDBMaster),$objDBMaster->doEscapeString($varReligiousVal,$objDBMaster),$objDBMaster->doEscapeString($varCasteVal,$objDBMaster),$objDBMaster->doEscapeString($varSubcasteVal,$objDBMaster),$objDBMaster->doEscapeString($varMotherTongueVal,$objDBMaster),$objDBMaster->doEscapeString($varMaritalVal,$objDBMaster),$objDBMaster->doEscapeString($arrAge[0],$objDBMaster),$objDBMaster->doEscapeString($arrAge[1],$objDBMaster),$objDBMaster->doEscapeString($varCountryVal,$objDBMaster),"'".$varCurrentDate."'");
		$varUpdateId		= $objDBMaster->insertOnDuplicate($varTable['MEMBERFILTERINFO'],$argFields,$argFieldsValues,$argCondition);

		//set filter set status in memberinfo table
		$argFields 		= array('Filter_Set_Status','Date_Updated');
		$argFieldsValues= array(1,"'".$varCurrentDate."'");
		$varUpdateId	= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);

		$varMessage		= 'Your privacy settings have been successfully updated.';
	}
	$objDBMaster->dbClose();
}

//CREATE ARRAY FOR ALREADY SELECTED FILTER VALUE
$arrReligionChecked			= array();
$arrCasteChecked			= array();
$arrMotherTongueChecked		= array();
$arrMaritalChecked			= array();
$arrCountryChecked			= array();
$arrSubcasteChecked			= array();

//Check Filter Information available or not
$argCondition				= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
$varFilterAvailable			= $objDBslave->numOfRecords($varTable['MEMBERFILTERINFO'],'MatriId',$argCondition);

//Getting Filter Information
if($varFilterAvailable == 1) {
	$argFields				= array('Religion','CommunityId','SubcasteId','Mother_Tongue','Marital_Status','Age_Above','Age_Below','Country');
	$argCondition			= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
	$varFilterInfoResultSet	= $objDBslave->select($varTable['MEMBERFILTERINFO'],$argFields,$argCondition,0);
	$varFilterInfoResult	= mysql_fetch_assoc($varFilterInfoResultSet);

	$arrReligionChecked		= explode("~",$varFilterInfoResult["Religion"]);
	$arrCasteChecked		= explode("~",$varFilterInfoResult["CommunityId"]);
	$arrMotherTongueChecked	= explode("~",$varFilterInfoResult["Mother_Tongue"]);
	$arrMaritalChecked		= explode("~",$varFilterInfoResult["Marital_Status"]);
	$arrCountryChecked		= explode("~",$varFilterInfoResult["Country"]);
	$arrSubcasteChecked		= explode("~",$varFilterInfoResult["SubcasteId"]);
}

//DB CLOSE
$objDBslave->dbClose();

switch(findFlagDtls($_FeatureSubcaste,$_FeatureSubcasteTxt,$_FeatureCaste,$_FeatureReligion)) {
	case 1:
			$varSubcastePadding	= '122';
			$varCastePadding	= '243';
			$varreligionPadding	= '347';
			$varTotalDiv		= $varTotalDiv + 3;
			break;

	case 2:
			$varSubcastePadding	= '122';
			$varCastePadding	= '243';
			$varreligionPadding	= '0';
			$varTotalDiv		= $varTotalDiv + 2;
			break;

	case 3:
			$varSubcastePadding	= '122';
			$varCastePadding	= '0';
			$varreligionPadding	= '243';
			$varTotalDiv		= $varTotalDiv + 2;
			break;

	case 4:
			$varSubcastePadding	= '122';
			$varCastePadding	= '0';
			$varreligionPadding	= '0';
			$varTotalDiv		= $varTotalDiv + 1;
			break;
	
	case 5:
			$varSubcastePadding	= '0';
			$varCastePadding	= '122';
			$varreligionPadding	= '228';
			$varTotalDiv		= $varTotalDiv + 2;
			break;

	case 6:
			$varSubcastePadding	= '0';
			$varCastePadding	= '122';
			$varreligionPadding	= '0';
			$varTotalDiv		= $varTotalDiv + 1;
			break;

	case 7:
			$varSubcastePadding	= '0';
			$varCastePadding	= '0';
			$varreligionPadding	= '122';
			$varTotalDiv		= $varTotalDiv + 1;
			break;
}?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/filtersetting.js" ></script>
<? if($varFilterAvailable == 1) {echo '<img src="'.$confValues['IMGSURL'].'/trans.gif" onload="filterenable(2);">';}?>
<div class="fleft">
	<div class="tabcurbg fleft">
		<div class="fleft">
			<div class="fleft tabclrleft"></div>
			<div class="fleft tabclrrtsw">
				<div class="tabpadd"><font class="mediumtxt1 boldtxt clr4">Manage Contact Filters</font></div>
			</div>
		</div>

		<div class="fright">
			<div style="position: absolute; margin-left: -100px;">
				<div style="background: transparent url(<?=$confValues['IMGSURL']?>/msg-back1.gif) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 21px; height: 27px;" class="fleft"></div>
				<div style="background: transparent url(<?=$confValues['IMGSURL']?>/msg-back2.gif) no-repeat scroll right top; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; height: 27px;" class="fleft">
					<div style="padding: 2px 10px 0px 7px; line-height: 11px;" class="smalltxt clr3">Back to<br/><b>Edit Profile</b></div>
				</div>
			</div>
			<div style="position: absolute; margin-left: -100px;">
				<a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=editprofile"><img height="27" width="100" src="<?=$confValues['IMGSURL']?>/trans.gif"/></a>
			</div>
		</div>
	</div>
	<div class="fleft tr-3"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="10" height="41" /></div>
</div>
<br>
<div class="middiv1">
	<div class="bl">
		<div class="br" >
			<div class="middiv-pad1" id="middlediv">
				<div style="padding:10px 0px 0px 5px; width:505px;height:685px;" class="smalltxt">
					

					<div style="width: 521px;">
						<div style="background: transparent url(<?=$confValues['IMGSURL']?>/inner-tab-border2.gif) repeat scroll 0%; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 1px; height: 33px;"></div>
						<div style="float: left; width: 519px;" id="middleContent">
							<div id="sectab_content_1" class="poppadding">
								<div class="mediumtxt boldtxt clr3" style="padding-bottom: 3px;">Privacy Options</div>
								The purpose of a filter is to help you decide on the type of members who'll contact you. Set a broad preference so that you get good response while eliminating non-relevant members from contacting you. If you set narrow preferences, you will not get any response.
								<br clear="all"><br clear="all">

								<a href="#" name="FSA"></a>
								<div class="mediumtext boldtxt">Privacy Settings</div>

								<div>
								<form name="privacysettings" method="post" style="margin: 0px;">
									<input type='hidden' name='act' value='filtersetting'>
									<input type='hidden' name='updatefilter' value='yes'>
									<input type='hidden' name='fields' value='yes'>
									<div><input name="privacyval" value="0" style="vertical-align: middle;" onclick="filterenable(0);"  type="radio" <? if($varFilterAvailable == 0){echo 'checked';} ?>>Allow all members to contact me</div>
									<div><input name="privacyval" value="2" style="vertical-align: middle;" onclick="filterenable(2);" type="radio" <? if($varFilterAvailable == 1){echo 'checked';} ?>>Allow only the members who pass my filter to contact me.&nbsp;(<a href="javascript:void(0);" style="cursor: pointer;" onclick = "document.privacysettings.privacyval[1].checked=true;filterenable(2);document.getElementById('wtsfltr').style.display='block';document.getElementById('fade').style.display='block';ll('wtsfltr');floatdiv('wtsfltr',lpos,200).floatIt();hideSelectBoxes();" class="clr1">What's this?</a>)</div>
								</form>
								</div>

								<div id="wtsfltr" class="frdispdiv" style="width: 440px;padding:8px 7px 15px 15px;">
									<div class="fleft mediumtxt boldtxt clr3">What is a Filter?</div>
									<div class="fright"><a href="javascript:;" style="cursor:pointer;" onclick="document.getElementById('wtsfltr').style.display='none';document.getElementById('fade').style.display='none';showSelectBoxes();"><img src="<?=$confValues["IMGSURL"];?>/close-icon.gif" border="0" alt="" align="right" /></a></div>
									<br clear="all" />
									<div class="fleft" style="align:center;padding-top:7px;">
										<div class='divborder' style='width:423px;_width:405px;padding:5px;'>
										The purpose of a filter is to help you decide on the type of members who'll contact you. Set a broad preference so that you get good responses while eliminating non-relevant members from contacting you.
										</div>
									</div>
								</div>
								<br clear="all">

								<div id="filt">
									<div style="padding-top: 10px; display: none;" id="filterdiv">
										<div class="mediumtext boldtxt">Filter</div>
										<div>
										The purpose of a filter is to help you decide on the type of members who'll contact you. Set a broad preference so that you get good response while eliminating non-relevant members from contacting you. If you set narrow preferences, you will not get any response.
										</div><br clear="all">
										<div>Please set your filter preference by choosing from the options below.</div>
										<span id="filterspan" class="errortxt"></span><br clear="all">

										<span>
										<font class="smalltxt" onclick="showslide(<?=createShowSlideFn($varSelectedDiv,$varTotalDiv)?>);"><a href="#FSA" style="text-decoration: none;"><img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d1"></a>&nbsp;Select Age<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="33"></font>
										<div style="float: left; padding-left: 0px;">
										<div id="div_<?=$varSelectedDiv?>" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">

										<!--Age part-->	
										<form name="frmresultd<?=$varSelectedDiv?>" style="margin: 0px; padding: 0px;">
										<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="130">
										<tbody><tr><td>
											<div class="fleft mediumtxt boldtxt">&nbsp;<b>Age</b></div>
											<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_<?=$varSelectedDiv?>', 'd<?=$varSelectedDiv?>');"><b>X</b></a>&nbsp;</div>
										</td></tr>
										<tr><td>
											<div style="overflow: auto; background-color: #FFFFFF; height: 60px;">
												<table class="mediumtxt" border="0" cellpadding="1" cellspacing="1">
												<tbody><tr><td valign="top"><div>
												<b>Age above : </b>
												<input name="AgeAbove" value="<? if($varFilterInfoResult['Age_Above'] > 0) { echo $varFilterInfoResult['Age_Above'];} ?>" size="2" type="text"><br>
												<b>Age below : </b>
												<input name="AgeBelow" value="<? if($varFilterInfoResult['Age_Below'] > 0) { echo $varFilterInfoResult['Age_Below'];} ?>" size="2" type="text">
												</div></td></tr>
												</tbody></table>
											</div>
										</td></tr>
										<tr align="right"><td><input class="button" value="Submit" onclick="srchblocking('div_<?=$varSelectedDiv?>','d<?=$varSelectedDiv?>');" type="button">
										</td></tr>
										</tbody></table>
										</form>
										<!--Age part-->	
										</div>

										</div>
										</span>
										<?$varSelectedDiv++;?>
										<span>
										<font class="smalltxt" onclick="showslide(<?=createShowSlideFn($varSelectedDiv,$varTotalDiv)?>);"><a href="#FSA" style="text-decoration: none;"><img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d2"></a>&nbsp;Select Country Living in<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="50"></font>
										<div style="float: left; padding-left: 104px">
										<div id="div_<?=$varSelectedDiv?>" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">
										<!--Country part-->
										<form name="frmresultd<?=$varSelectedDiv?>" style="margin: 0px; padding: 0px;">

										<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="250">
										<tbody><tr><td>
											<div class="fleft mediumtxt boldtxt">&nbsp;<b>Country Living in</b></div>
											<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_<?=$varSelectedDiv?>', 'd<?=$varSelectedDiv?>');"><b>X</b></a>&nbsp;</div>
										</td></tr>
										<tr><td>
											<div style="overflow: auto; background-color: #FFFFFF; height: 200px;">
												<table class="smalltxt" border="0" cellpadding="1" cellspacing="1">
												<tbody><tr><td valign="top">
												<div>
													<? foreach ($arrCountryList as $countryval=>$countryname) {
														if(sizeof($arrCountryChecked)>0) {
															$varChecked = in_array($countryval,$arrCountryChecked)?' checked':'';
														}
														?>
														<input name="chk" value="<?=$countryval?>" id="chk" type="checkbox" <?=$varChecked?>><?=$countryname?><br>
													<? } ?>
												</div></td></tr>
												</tbody></table>
											</div>
										</td></tr>
										<tr align="right"><td><input class="button" value="Submit" onclick="srchblocking('div_<?=$varSelectedDiv?>','d<?=$varSelectedDiv?>');" type="button"></td></tr>
										</tbody></table>
										</form>
										<!--Country part-->
										</div>
										</div>
										</span>
										<?$varSelectedDiv++;?>
										<span>							
										<font class="smalltxt" onclick="showslide(<?=createShowSlideFn($varSelectedDiv,$varTotalDiv)?>);"><a href="#FSA" style="text-decoration: none;"><img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d3"></a>&nbsp;Select Marital Status<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="24"></font>
										<div style="float: left; padding-left: 285px;">
										<div id="div_<?=$varSelectedDiv?>" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">
										<!--Marital Status part-->
										<form name="frmresultd<?=$varSelectedDiv?>" style="margin: 0px; padding: 0px;">

										<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="200">
										<tbody><tr><td>
											<div class="fleft mediumtxt boldtxt">&nbsp;<b>Marital Status</b></div>
											<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_<?=$varSelectedDiv?>', 'd<?=$varSelectedDiv?>');"><b>X</b></a>&nbsp;</div>
										</td></tr>
										<tr><td>
											<div style="overflow: auto; background-color: #FFFFFF; height: 90px;">
												<table class="smalltxt" border="0" cellpadding="1" cellspacing="1">
												<tbody><tr><td valign="top">
												<div>
													<?
													foreach ($arrMaritalList as $maritalval=>$maritalname) {
														if(sizeof($arrMaritalChecked)>0) {
															$varChecked = in_array($maritalval,$arrMaritalChecked)?' checked':'';
														}?>
														<input name="chk" value="<?=$maritalval?>" id="chk" type="checkbox" <?=$varChecked?>><?=$maritalname?><br>
													<? } ?>
												</div></td></tr>
												</tbody></table>
											</div>
										</td></tr>
										<tr align="right"><td><input class="button" value="Submit" onclick="srchblocking('div_<?=$varSelectedDiv?>','d<?=$varSelectedDiv?>');" type="button"></td></tr>
										</tbody></table>
										</form>

										<!--Marital Status part-->
										</div>	
										</div>
										</span>
										<?$varSelectedDiv++;?>
									</div>

									<div style="padding-top: 15px; display: none;" id="filterdiv1">

										<span>
											<font class="smalltxt" onclick="showslide(<?=createShowSlideFn($varSelectedDiv,$varTotalDiv)?>);"><a href="#FSA" style="text-decoration: none;"><img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d4"></a>&nbsp;Select Mother Tongue</font>
											<div style="float: left; padding-left: 0px;">
											<div id="div_<?=$varSelectedDiv?>" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">
											<!--Mother Tongue part-->	
											<form name="frmresultd<?=$varSelectedDiv?>" style="margin: 0px; padding: 0px;">

											<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="200">
											<tbody><tr><td>
												<div class="fleft mediumtxt boldtxt">&nbsp;<b>Mother Tongue</b></div>
												<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_<?=$varSelectedDiv?>', 'd<?=$varSelectedDiv?>');"><b>X</b></a>&nbsp;</div>
											</td></tr>
											<tr><td>
												<div style="overflow: auto; background-color: #FFFFFF; height: 200px;">
													<table class="smalltxt" border="0" cellpadding="1" cellspacing="1">
													<tbody><tr><td valign="top"><div>
														<? 
														unset($arrMotherTongueList[99]);
														foreach ($arrMotherTongueList as $mothertongueval=>$mothertonguename) {
															if(sizeof($arrMotherTongueChecked)>0) {
																$varChecked = in_array($mothertongueval,$arrMotherTongueChecked)?' checked':'';
															}
															?>
															<input name="chk" value="<?=$mothertongueval?>" id="chk" type="checkbox" <?=$varChecked?>><?=$mothertonguename?><br>
														<? } ?>
													</div></td></tr>
													</tbody></table>
												</div>
											</td></tr>
											<tr align="right"><td><input class="button" value="Submit" onclick="srchblocking('div_<?=$varSelectedDiv?>','d<?=$varSelectedDiv?>');" type="button"></td></tr>
											</tbody></table>
											</form>
											<!--Mother Tongue part-->
											</div>
											
										</div>

										</span>	
										
										<?  if($_FeatureSubcaste==1 && $_FeatureSubcasteTxt==0 && $varSubcasteCnt>1) { $varSelectedDiv++;?>
										<span>
										<font class="smalltxt" onclick="showslide(<?=createShowSlideFn($varSelectedDiv,$varTotalDiv)?>);"><a href="#FSA" style="text-decoration: none;"><img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d5"></a>&nbsp;Select Subcaste<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="25"></font>
										<div style="float: left; padding-left: <?=$varSubcastePadding?>px;">
										<div id="div_<?=$varSelectedDiv?>" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">
										<!--Caste part-->
										<form name="frmresultd<?=$varSelectedDiv?>" style="margin: 0px; padding: 0px;">
										<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="200">

										<tbody><tr><td>
											<div class="fleft mediumtxt boldtxt">&nbsp;<b>Subcaste</b></div>
											<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_<?=$varSelectedDiv?>', 'd<?=$varSelectedDiv?>');"><b>X</b></a>&nbsp;</div>
										</td></tr>
										<tr><td>
											<div style="overflow: auto; background-color: #FFFFFF; height: 170px;">
												<table class="smalltxt" border="0" cellpadding="1" cellspacing="1">
												<tbody><tr><td valign="top">
													<div>
														<?  foreach ($arrSubCasteTrimmed as $subcasteval=>$subcastename) {
															if(sizeof($arrSubcasteChecked)>0) {
																$varChecked = in_array($subcasteval,$arrSubcasteChecked)?' checked':'';
															}?>
															<input name='chk' value="<?=$subcasteval?>" id='chk' type='checkbox' <?=$varChecked?>><?=$subcastename?><br>
														<? } ?>
													</div>
												</td></tr>
												</tbody></table>
											</div>
										</td></tr>
										<tr align="right"><td>
										<input class="button" value="Submit" onclick="srchblocking('div_<?=$varSelectedDiv?>','d<?=$varSelectedDiv?>');" type="button">						
										</td></tr>
										</tbody></table>
										</form>
										<!--Caste part-->
										</div>

										</div>
										</span>

										<?} if($_FeatureCaste==1) { $varSelectedDiv++;?>
										<span>
										<font class="smalltxt" onclick="showslide(<?=createShowSlideFn($varSelectedDiv,$varTotalDiv)?>);"><a href="#FSA" style="text-decoration: none;"><img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d6"></a>&nbsp;Select Caste<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="25"></font>
										<div style="float: left; padding-left: <?=$varCastePadding?>px;">
										<div id="div_<?=$varSelectedDiv?>" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">
										<!--Caste part-->
										<form name="frmresultd<?=$varSelectedDiv?>" style="margin: 0px; padding: 0px;">
										<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="130">

										<tbody><tr><td>
											<div class="fleft mediumtxt boldtxt">&nbsp;<b>Caste</b></div>
											<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_<?=$varSelectedDiv?>', 'd<?=$varSelectedDiv?>');"><b>X</b></a>&nbsp;</div>
										</td></tr>
										<tr><td>
											<div style="overflow: auto; background-color: #FFFFFF; height: 60px;">
												<table class="smalltxt" border="0" cellpadding="1" cellspacing="1">
												<tbody><tr><td valign="top">
													<div>
														<? foreach ($arrCasteList as $casteval=>$castename) {
															if(sizeof($arrCasteChecked)>0) {
																$varChecked = in_array($casteval,$arrCasteChecked)?' checked':'';
															}?>
															<input name='chk' value="<?=$casteval?>" id='chk' type='checkbox' <?=$varChecked?>><?=$castename?><br>
														<? } ?>
													</div>
												</td></tr>
												</tbody></table>
											</div>
										</td></tr>
										<tr align="right"><td>
										<input class="button" value="Submit" onclick="srchblocking('div_<?=$varSelectedDiv?>','d<?=$varSelectedDiv?>');" type="button">						
										</td></tr>
										</tbody></table>
										</form>
										<!--Caste part-->
										</div>

										</div>
										</span>
										<?} if($_FeatureReligion==1) { $varSelectedDiv++;?>
										<span>
										<font class="smalltxt" onclick="showslide(<?=createShowSlideFn($varSelectedDiv,$varTotalDiv)?>);"><a href="#FSA" style="text-decoration: none;"><img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d6"></a>&nbsp;Select Religion<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="25"></font>
										<div style="float: left; padding-left: <?=$varreligionPadding?>px;">
										<div id="div_<?=$varSelectedDiv?>" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">
										<!--Religion part-->
										<form name="frmresultd<?=$varSelectedDiv?>" style="margin: 0px; padding: 0px;">
										<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="130">

										<tbody><tr><td>
											<div class="fleft mediumtxt boldtxt">&nbsp;<b>Religion</b></div>
											<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_<?=$varSelectedDiv?>', 'd<?=$varSelectedDiv?>');"><b>X</b></a>&nbsp;</div>
										</td></tr>
										<tr><td>
											<div style="overflow: auto; background-color: #FFFFFF; height: 60px;">
												<table class="smalltxt" border="0" cellpadding="1" cellspacing="1">
												<tbody><tr><td valign="top">
													<div>
														<? foreach ($arrReligionList as $religionval=>$religionname) {
															if(sizeof($arrReligionChecked)>0) {
																$varChecked = in_array($religionval,$arrReligionChecked)?' checked':'';
															}?>
															<input name='chk' value="<?=$religionval?>" id='chk' type='checkbox' <?=$varChecked?>><?=$religionname?><br>
														<? } ?>
													</div>
												</td></tr>
												</tbody></table>
											</div>
										</td></tr>
										<tr align="right"><td>
										<input class="button" value="Submit" onclick="srchblocking('div_<?=$varSelectedDiv?>','d<?=$varSelectedDiv?>');" type="button">						
										</td></tr>
										</tbody></table>
										</form>
										<!--Religion part-->
										</div>

										</div>
										</span>
										<? } ?>
									</div>
								</div>

								<div class="fright"><input class="button" value="Update" onclick="filterupdate(<?=$varTotalDiv?>);" type="button"></div><br clear="all">
								<div class="smalltxt1" style="padding: 15px 0px 0px;">Note: If you choose second option, only your basic details like Name, Matrimony Username, Age, Height, Caste, Occupation and City will be shown to visitors.</div>

								<div class="vdotline1 poppadding1" style="width: 475px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1"></div>
							</div>
						</div>
					</div>
					
					<div id="filtersetdiv" class="frdispdiv" style="width: 440px;padding:5px 5px 15px 15px;_padding:5px 0px 5px 0px;">
						<div class="fleft mediumtxt boldtxt clr3">Privacy Settings</div>
						<div class="fright" style="margin-bottom:7px;"><a href="javascript:;" onclick="document.getElementById('filtersetdiv').style.display='none';document.getElementById('fade').style.display='none';showSelectBoxes('privacysettings');"><img src="<?=$confValues["IMGSURL"];?>/close-icon.gif" border="0" alt="" align="right"/></a></div><br clear="all" />
						<div class="fleft" style="align:center;">
							<div class='divborder' style='width:413px;_width:395px;padding:10px;'>
								<?=$varMessage?>
							</div>
						</div>
					</div>
					<?if($varMessage != '') { ?>	<script>document.getElementById('filtersetdiv').style.display='block';document.getElementById('fade').style.display='block';ll('filtersetdiv');floatdiv('filtersetdiv',lpos,50).floatIt();hideSelectBoxes('PasswordForm');	</script>
					<? } ?>










				</div>
			</div>	
		</div>
	</div>
</div>