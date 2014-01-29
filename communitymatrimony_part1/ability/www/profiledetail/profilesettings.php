<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-20
# Project	  : MatrimonyProduct
# Filename	  : profilesettings.php
#=====================================================================================================================================
# Description : Display Profile setting Information. It includes alert, privacy oprions amd change password information
#=====================================================================================================================================
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/conf/productvars.cil14');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessUsername	= $varGetCookieInfo["USERNAME"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];

if($sessMatriId == ""){ 
	echo '<img src="'.$confValues['IMGSURL'].'/trans.gif" onload="javascript:window.location.href=\''.$confValues['SERVERURL'].'\'"/>'; 
}//if

//OBJECT DECLARATION
$objProfileDetailSlave	= new ProfileDetail;

//VARIABLE DECLARATION
$varInnerTabName			= $_REQUEST['inname'];
$arrReligionChecked			= array();
$arrCasteChecked			= array();
$arrMotherTongueChecked		= array();
$arrMaritalChecked			= array();
$arrCountryChecked			= array();

//DB CONNECT
$objProfileDetailSlave->dbConnect('S',$varDbInfo['DATABASE']);

//Getting Match Watch Alert
$argCondition				= "WHERE MatriId=".$objProfileDetailSlave->doEscapeString($sessMatriId,$objProfileDetailSlave)." AND Mailer_Medium='1'";
$varMatchWatchResults		= $objProfileDetailSlave->numOfRecords($varTable['MAILMANAGERINFO'],'MatriId',$argCondition);

//Getting Product Promotion Alert
$argCondition				= "WHERE MatriId=".$objProfileDetailSlave->doEscapeString($sessMatriId,$objProfileDetailSlave)." AND Mailer_Medium='2'";
$varInternalPromoResults	= $objProfileDetailSlave->numOfRecords($varTable['MAILMANAGERINFO'],'MatriId',$argCondition);

//Getting External Product Promotion Alert
$argCondition				= "WHERE MatriId=".$objProfileDetailSlave->doEscapeString($sessMatriId,$objProfileDetailSlave)." AND Mailer_Medium='3'";
$varExternalPromoResults	= $objProfileDetailSlave->numOfRecords($varTable['MAILMANAGERINFO'],'MatriId',$argCondition);

//Check Filter Information available or not
$argCondition				= "WHERE MatriId=".$objProfileDetailSlave->doEscapeString($sessMatriId,$objProfileDetailSlave);
$varFilterAvailable			= $objProfileDetailSlave->numOfRecords($varTable['MEMBERFILTERINFO'],'MatriId',$argCondition);

//Getting Filter Information
if($varFilterAvailable == 1) {
	$argFields					= array('Religion','Caste','Mother_Tongue','Marital_Status','Age_Above','Age_Below','Country');
	$argCondition				= "WHERE MatriId=".$objProfileDetailSlave->doEscapeString($sessMatriId,$objProfileDetailSlave);
	$varFilterInfoResultSet		= $objProfileDetailSlave->select($varTable['MEMBERFILTERINFO'],$argFields,$argCondition,0);
	$varFilterInfoResult		= mysql_fetch_assoc($varFilterInfoResultSet);

	$arrReligionChecked			= explode("~",$varFilterInfoResult["Religion"]);
	$arrCasteChecked			= explode("~",$varFilterInfoResult["Caste"]);
	$arrMotherTongueChecked		= explode("~",$varFilterInfoResult["Mother_Tongue"]);
	$arrMaritalChecked			= explode("~",$varFilterInfoResult["Marital_Status"]);
	$arrCountryChecked			= explode("~",$varFilterInfoResult["Country"]);

	echo '<img src="'.$confValues['IMGSURL'].'/trans.gif" onload="filterenable(2);">';
}

//DB CLOSE
$objProfileDetailSlave->dbClose();
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/fade.css">
<!--{ Content Area -->
<div class="middiv1" name="viewprofilemaindiv" id="viewprofilemaindiv">
	<div class="bl">
		<div class="br">
			<div id="middlediv"> <!-- for equal div and 1024 res -->
				<div id="loadcontent" style="display: block;"><!-- Content Area -->		
					<div style="display: none;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="clickTab(2,6,'sectab');cookieChecker('alt');"></div>
					<div class="popcontainer smalltxt" id="mailalert" style="padding-left: 10px;">
				
						<div style="float: left; width: 521px;">
							<div style="background: transparent url(<?=$confValues['IMGSURL']?>/inner-tab-border1.gif) repeat scroll 0%; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 1px; height: 50px;"></div>
							<div style="background: transparent url(<?=$confValues['IMGSURL']?>/inner-tab-bg.gif) repeat-x ; float: left; width: 519px; height: 50px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;">	

							<!-- tab1 - start-->
								<div id="sectab3" style="float: left; padding-left: 10px;">
									<div id="sectablink3_inactive" style="float: left; display: block;"></div>
									<div id="sectablink3_active" style="float: left; display: none;">	</div>
								</div>
							<!-- tab1 - ends-->

							<!-- tab2 - start-->
								<div id="sectab4" style="float: left;">
									<div id="sectablink4_inactive" style="float: left; display: block;"></div>
									<div id="sectablink4_active" style="float: left; display: none;">	</div>
								</div>
							<!-- tab2 - ends-->


							<!-- tab3 - start-->
								<div id="sectab5" style="float: left;">
									<div id="sectablink5_inactive" style="float: left; display: block;"></div>
									<div id="sectablink5_active" style="float: left; display: none;">	</div>
								</div>	
							<!-- tab3 - ends-->


							<!-- tab4 - start-->
								<div id="sectab2" style="float: left;">
									<div id="sectablink2_inactive" style="float: left; display: none;">				
										<div style="padding: 4px 8px 0px;" class="mediumtxt"><a href="javascript:void(0)" onclick="clickTab(2,6,'sectab');cookieChecker('alt');" onmouseover="showhint('Here you can select the e-mail and mobile alerts you wish to receive.',this,event,'170');" onmouseout="hidetip();">Alert</a></div>
									</div>

									<div id="sectablink2_active" style="float: left; display: block;">
										<div style="background: transparent url(<?=$confValues['IMGSURL']?>/inner-mtab-bg1.gif) repeat scroll 0%; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 5px; height: 26px;"></div>
										<div style="background: transparent url(<?=$confValues['IMGSURL']?>/inner-mtab-bg2.gif) no-repeat scroll right top; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; height: 26px;">
											<div style="padding: 5px 8px 0px 3px;" class="mediumtxt" onmouseover="showhint('Here you can select the e-mail and mobile alerts you wish to receive.',this,event,'170');" onmouseout="hidetip();">Alert</div>

											<div style="margin-top: 5px; padding-left: 10px;"><img src="<?=$confValues['IMGSURL']?>/inner-mtab-down-arrow.gif" alt="" border="0" height="7" width="11"></div>
										</div>						
									</div>
								</div>
							<!-- tab4 - ends-->


							<!-- tab5 - start-->
								<div id="sectab1" style="float: left;">
									<div id="sectablink1_inactive" style="float: left; display: block;">				
										<div style="padding: 5px 8px 0px;" class="mediumtxt"><a href="javascript:void(0)" onclick="clickTab(1,6,'sectab');cookieChecker();" onmouseover="showhint('Here you can choose your privacy settings.',this,event,'170');" onmouseout="hidetip();">Privacy</a></div>
									</div>

									<div id="sectablink1_active" style="float: left; display: none;">
										<div style="background: transparent url(<?=$confValues['IMGSURL']?>/inner-mtab-bg1.gif) repeat scroll 0%; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 5px; height: 26px;"></div>
										<div style="background: transparent url(<?=$confValues['IMGSURL']?>/inner-mtab-bg2.gif) no-repeat scroll right top; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; height: 26px;">
											<div style="padding: 5px 8px 0px 3px;" class="mediumtxt" onmouseover="showhint('Here you can choose your privacy settings.',this,event,'170');" onmouseout="hidetip();">Privacy</div>
											<div style="margin-top: 5px; padding-left: 15px;"><img src="<?=$confValues['IMGSURL']?>/inner-mtab-down-arrow.gif" alt="" border="0" height="7" width="11"></div>
										</div>						
									</div>
								</div>
							<!-- tab5 - ends-->


							<!-- tab6 - start-->
								<div id="sectab6" style="float: left;">
									<div id="sectablink6_inactive" style="float: left; display: block;">				
										<div style="padding: 5px 8px 0px;" class="mediumtxt"><a href="javascript:void(0)" onclick="clickTab(6,6,'sectab');cookieChecker('pswd');" onmouseover="showhint('Here you can change your password.',this,event,'170');" onmouseout="hidetip();">Password</a></div>
									</div>

									<div id="sectablink6_active" style="float: left; display: none;">
										<div style="background: transparent url(<?=$confValues['IMGSURL']?>/inner-mtab-bg1.gif) repeat scroll 0%; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 5px; height: 26px;"></div>
										<div style="background: transparent url(<?=$confValues['IMGSURL']?>/inner-mtab-bg2.gif) no-repeat scroll right top; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; height: 26px;">
											<div style="padding: 5px 8px 0px 3px;" class="mediumtxt" onmouseover="showhint('Here you can change your password.',this,event,'170');" onmouseout="hidetip();">Password</div>
											<div style="margin-top: 5px; padding-left: 25px;"><img src="<?=$confValues['IMGSURL']?>/inner-mtab-down-arrow.gif" alt="" border="0" height="7" width="11"></div>
										</div>						
									</div>
								</div>
							</div>
							<div style="background: transparent url(<?=$confValues['IMGSURL']?>/inner-tab-border1.gif) repeat scroll 0%; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 1px; height: 50px;"></div>
						
							
				<!-- Middle Content -->
							<div style="width: 521px;">
								<div style="background: transparent url(<?=$confValues['IMGSURL']?>/inner-tab-border2.gif) repeat scroll 0%; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 1px; height: 33px;"></div>
								<div style="float: left; width: 519px;" id="middleContent">

						<!-- Stab1 - Start-->
									<div id="sectab_content_1" class="poppadding" style="display: none;">
										<div class="mediumtxt boldtxt clr3" style="padding-bottom: 3px;">Privacy Options</div>
										The purpose of a filter is to help you decide on the type of members who'll contact you. Set a broad preference so that you get good response while eliminating non-relevant members from contacting you. If you set narrow preferences, you will not get any response.
										<br clear="all"><br clear="all">

								<!-- privacy settings form starts here-->
										<a href="#" name="FSA"></a>
										<div class="mediumtext boldtxt">Privacy Settings</div>

										<div>
										<form name="privacysettings" style="margin: 0px;">
											<div><input name="privacyval" value="0" style="vertical-align: middle;" onclick="filterenable(0);"  type="radio" <? if($varFilterAvailable == 0){echo 'checked';} ?>>Allow all members to contact me</div>
											<div><input name="privacyval" value="2" style="vertical-align: middle;" onclick="filterenable(2);" type="radio" <? if($varFilterAvailable == 1){echo 'checked';} ?>>Allow only the members who pass my filter to contact me.&nbsp;(<a href="javascript:void(0);" style="cursor: pointer;" onclick = "document.privacysettings.privacyval[1].checked=true;filterenable(2);document.getElementById('wtsfltr').style.display='block';document.getElementById('fade').style.display='block';ll('wtsfltr');floatdiv('wtsfltr',lpos,200).floatIt();hideSelectBoxes();" class="clr1">What's this?</a>)</div>
								<!--<input name="filterflag" value="0" type="hidden">-->
										</form>
										</div>

										<!-- filter fade -->
										<div id="wtsfltr" class="frdispdiv" style="width: 440px;padding:8px 7px 15px 15px;">
																						
											<div class="fleft mediumtxt boldtxt clr3">What is a Filter?</div>
											<div class="fright"><a href="javascript:;" style="cursor:pointer;" onclick="document.getElementById('wtsfltr').style.display='none';document.getElementById('fade').style.display='none';showSelectBoxes();" ><img src="<?=$confValues["IMGSURL"];?>/close-icon.gif" border="0" alt="" align="right" /></a></div>
											<br clear="all" />
											<div class="fleft" style="align:center;padding-top:7px;">
												<div class='divborder' style='width:423px;_width:405px;padding:5px;'>
												The purpose of a filter is to help you decide on the type of members who'll contact you. Set a broad preference so that you get good responses while eliminating non-relevant members from contacting you.
												</div>
											</div>
										</div>
										<br clear="all">
										<!-- filter fade -->
							
							<!-- privacy settings form ends here-->

									<div id="filt">
										<div style="padding-top: 10px; display: none;" id="filterdiv">
											<div class="mediumtext boldtxt">Filter</div>
											<div>
											The purpose of a filter is to help you decide on the type of members who'll contact you. Set a broad preference so that you get good response while eliminating non-relevant members from contacting you. If you set narrow preferences, you will not get any response.
											</div><br clear="all">
											<div>Please set your filter preference by choosing from the options below.</div>
											<span id="filterspan" class="errortxt"></span><br clear="all">

								<span>
								<font class="smalltxt" onclick="showslide('div_1','div_2','div_3','div_4','div_5','div_6','d1','d2','d3','d4','d5','d6');"><a href="#FSA" style="text-decoration: none;"><img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d1"></a>&nbsp;Select Sect<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="25"></font>
								<div style="float: left; padding-left: 0px;">
								<div id="div_1" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">
								<!--Caste part-->
								<form name="frmresultd1" style="margin: 0px; padding: 0px;">
								<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="130">

								<tbody><tr><td>
									<div class="fleft mediumtxt boldtxt">&nbsp;<b>Sect</b></div>
									<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_1', 'd1');"><b>X</b></a>&nbsp;</div>
								</td></tr>
								<tr><td>
									<div style="overflow: auto; background-color: #FFFFFF; height: 60px;">
											<table class="smalltxt" border="0" cellpadding="1" cellspacing="1">
											<tbody><tr><td valign="top">
												<div>
													<?
													foreach ($arrReligionList as $religionval=>$religionname) {
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
								<input class="button" value="Submit" onclick="srchblocking('div_1','d1');" type="button">						
								</td></tr>
								</tbody></table>
								</form>
								<!--Caste part-->
								</div>

								</div>
								</span>	

								<span>
								<font class="smalltxt" onclick="showslide('div_2','div_1','div_3','div_4','div_5','div_6','d2','d1','d3','d4','d5','d6');"><a href="#FSA" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d2"></a>&nbsp;Select Age<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="33"></font>
								<div style="float: left; padding-left: 120px;">
								<div id="div_2" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">

								<!--Age part-->	
								<form name="frmresultd2" style="margin: 0px; padding: 0px;">
								<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="130">
								<tbody><tr><td>
									<div class="fleft mediumtxt boldtxt">&nbsp;<b>Age</b></div>
									<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_2', 'd2');"><b>X</b></a>&nbsp;</div>
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
								<tr align="right"><td><input class="button" value="Submit" onclick="srchblocking('div_2','d2');" type="button">
								</td></tr>
								</tbody></table>
								</form>
								<!--Age part-->	
								</div>

								</div>
								</span>

								<span>
								<font class="smalltxt" onclick="showslide('div_3','div_1','div_2','div_4','div_5','div_6','d3','d1','d2','d4','d5','d5');"><a href="#FSA" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d3"></a>&nbsp;Select Country Living in<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="50"></font>
								<div style="float: left; padding-left: 260px !important;padding-left: 140px;">
								<div id="div_3" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">
								<!--Country part-->
								<form name="frmresultd3" style="margin: 0px; padding: 0px;">

								<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="250">
								<tbody><tr><td>
									<div class="fleft mediumtxt boldtxt">&nbsp;<b>Country Living in</b></div>
									<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_3', 'd3');"><b>X</b></a>&nbsp;</div>
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
								<tr align="right"><td><input class="button" value="Submit" onclick="srchblocking('div_3','d3');" type="button"></td></tr>
								</tbody></table>
								</form>
								<!--Country part-->
								</div>
								</div>

								</span>


							</div>

							<div style="padding-top: 15px; display: none;" id="filterdiv1">
								<span>
								<font class="smalltxt" onclick="showslide('div_4','div_1','div_2','div_3','div_5','div_6','d4','d1','d2','d3','d5','d6');"><a href="#FSA" style="text-decoration: none;"><img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d4"></a>&nbsp;Select Seb sect<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="25"></font>
								<div style="float: left; padding-left: 0px;">
								<div id="div_4" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">
								<!--Caste part-->
								<form name="frmresultd4" style="margin: 0px; padding: 0px;">
								<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="200">

								<tbody><tr><td>
									<div class="fleft mediumtxt boldtxt">&nbsp;<b>Sub sect</b></div>
									<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_4', 'd4');"><b>X</b></a>&nbsp;</div>
								</td></tr>
								<tr><td>
									<div style="overflow: auto; background-color: #FFFFFF; height: 170px;">
											<table class="smalltxt" border="0" cellpadding="1" cellspacing="1">
											<tbody><tr><td valign="top">
												<div>
													<?
													unset($arrCasteDivisionList[9]);
													foreach ($arrCasteDivisionList as $casteval=>$castename) {
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
								<input class="button" value="Submit" onclick="srchblocking('div_4','d4');" type="button">						
								</td></tr>
								</tbody></table>
								</form>
								<!--Caste part-->
								</div>

								</div>
								</span>	

								<span>							
								<font class="smalltxt" onclick="showslide('div_5','div_1','div_2','div_3','div_4','div_6','d5','d1','d2','d3','d4','d6');"><a href="#FSA" style="text-decoration: none;"><img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d5"></a>&nbsp;Select Marital Status<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="24"></font>
								<div style="float: left; padding-left: 120px;">
								<div id="div_5" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">
								<!--Marital Status part-->
								<form name="frmresultd5" style="margin: 0px; padding: 0px;">

								<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="200">
								<tbody><tr><td>
									<div class="fleft mediumtxt boldtxt">&nbsp;<b>Marital Status</b></div>
									<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_5', 'd5');"><b>X</b></a>&nbsp;</div>
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
								<tr align="right"><td><input class="button" value="Submit" onclick="srchblocking('div_5','d5');" type="button"></td></tr>
								</tbody></table>
								</form>

								<!--Marital Status part-->
								</div>	
								</div>
								</span>

								<span>
									<font class="smalltxt" onclick="showslide('div_6','div_1','div_2','div_3','div_4','div_5','d6','d1','d2','d3','d4','d5');"><a href="#FSA" style="text-decoration: none;"><img src="<?=$confValues['IMGSURL']?>/hob-plus-icon.gif" id="d6"></a>&nbsp;Select Mother Tongue</font>
									<div style="float: left; padding-left: 260px !important;padding-left: 140px;">
									<div id="div_6" style="padding: 1px; z-index: 100; position: absolute; display: none; background-color: #FFE9D8;">
									<!--Mother Tongue part-->	
									<form name="frmresultd6" style="margin: 0px; padding: 0px;">

									<table class="normaltxt2" border="0" cellpadding="1" cellspacing="1" width="200">
									<tbody><tr><td>
										<div class="fleft mediumtxt boldtxt">&nbsp;<b>Mother Tongue</b></div>
										<div class="fright"><a href="javascript:;" class="smalltxt pntr" onclick="closing('div_6', 'd6');"><b>X</b></a>&nbsp;</div>
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
									<tr align="right"><td><input class="button" value="Submit" onclick="srchblocking('div_6','d6');" type="button"></td></tr>
									</tbody></table>
									</form>
									<!--Mother Tongue part-->
									</div>
									
								</div>

								</span>				
								</div>
							</div>
							<!-- filter div - End -->
							<div class="fright"><input class="button" value="Update" onclick="filterupdate();" type="button"></div><br clear="all">
							<div class="smalltxt1" style="padding: 15px 0px 0px;">Note: If you choose second option, only your basic details like Name, Matrimony Username, Age, Height, Caste, Occupation and City will be shown to visitors.</div>

							<div class="vdotline1 poppadding1" style="width: 475px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1"></div>
						</div>
						<!-- Stab1 - End-->

						<!-- Stab2 - Start-->
						<div id="web_alert_div">

							<div id="sectab_content_2" style="display: block; width: 506px;">
								<div style="padding: 0px 15px;">
								<div class="mediumtxt boldtxt clr3" style="padding-bottom: 3px;">Alerts</div>

								Listed below are the alerts you will receive from us through e-mail. If you wish to unsubscribe to any of the alerts, please de-select the alert.
								<div class="vdotline1 poppadding1" style="height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1"></div>

								<div class="smalltxt boldtxt">Mail Alerts</div>
								<div>
								<form name="frmMailAlert" style="margin: 0px;">
									
									<div class="fleft">
										<input name="partnerAlerts" value="1" <?if($varMatchWatchResults==1) { echo "checked"; }?> id="palert" type="checkbox">
									</div>
									<div class="fleft" style="padding: 2px; width: 425px;"><label for="extpro"><b>Daily MatchWatch and weekly Photo MatchWatch</b></label></div><br clear="all">

									<div class="fleft">
										<input id="genpro" name="generalPromo" value="2" <?if($varInternalPromoResults==1) { echo "checked"; }?> type="checkbox">
									</div>
									<div class="fleft" style="padding: 2px; width: 425px;"><label for="genpro"><b>Product and feature promotions</b> - Get updates on new features and products as soon as they are launched.</label></div><br clear="all">

				
									<div class="fleft">
										<input id="extpro" name="externalPromo" value="3" <?if($varExternalPromoResults==1) { echo "checked"; }?> type="checkbox">
									</div>
									<div class="fleft" style="padding: 2px; width: 425px;"><label for="palert"><b>Promotions from our group portals </b> - Receive promotional mailers from Consim Group of portals.</label></div><br clear="all">

									<div class="smalltxt1" style="text-align: justify;">						
									Note: In addition to the above mailers, you will receive e-mail notifications whenever a member sends you an Express Interest or a Personalised Message and also when a member accepts or declines your Express Interest or Personalised Message. The moment you delete your profile from <?=$confValues['PRODUCTNAME'];?> you will stop receiving all alerts.
									</div>

									<div class="fright" style="padding: 0pt 0pt 10px 0px;"><input class="button" value="Update" name="MM" onclick="submitMailAlert();" type="button"></div><br clear="all"><div class="vdotline1" style="height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1"></div>
								</form>
								</div>
								
								<div class="bheight"></div>					
							</div>

						</div>
					</div>
					<!-- Stab2 - End-->

					<!-- Stab3 - Start-->
					<div id="sectab_content_3" style="display: none;">

					</div>

					<!-- Stab3 - End-->

					<!-- Stab4 - Start-->
					<div id="sectab_content_4" style="width: 490px; display: none;">
							<p>Here's a list of members ignored by you. To remove a member from your "Ignore" list, check the box and click on the delete button.</p>
					</div>
					<!-- Stab4 - End-->

					<!-- Stab5 - Start-->

					<div id="sectab_content_5" style="width: 490px; display: none;">
							<p>Here's a list of members blocked by you. If you want to unblock a member, check the box and click on the "Delete" button.</p>
					</div>
					<!-- Stab5 - End-->

					<!-- Stab6 - Start-->
					<div id="sectab_content_6" class="poppadding" style="display: none;">
						<div class="mediumtxt boldtxt clr3" style="padding-bottom: 3px;">Change Password</div>

						Your password must have a minimum of 4 characters. We recommend you choose an alphanumeric password. E.g.: Matri123
						<br clear="all"><br clear="all">
						<form name="PasswordForm" style="margin: 0px;padding:0px;">
						<div><span id="oldpass" class="errortxt"></span><br><font class="smalltxt boldtxt"><label for="cur_pass">Enter Current Password</label></font></div>
						<div class="fleft" style="padding: 0px 0px 0px 0px;"><input name="oldpasswd" size="20" maxlength="8" value="" class="inputtext" id="cur_pass" tabindex="1" type="password"></div>
						<br clear="all">
						<div>
						<div class="fleft" style="width:198px;"><span id="firstpass" class="errortxt"></span></div><div class="fleft" style="width:190px;"><span id="secondpass" class="errortxt"></span></div><br clear="all">
						<div class="fleft" style="padding: 0px 0px 0px 0px;width:185px;"><font class="smalltxt boldtxt"><label for="cur_pass">Enter New Password</label></font><br><input name="passwd1" size="20" maxlength="8" value="" class="inputtext" id="newpass" tabindex="2" type="password"></div>

						<div class="fleft" style="padding: 0px 0px 0px 10px;width:165px;"><font class="smalltxt boldtxt"><label for="cur_pass">Confirm Password</label></font><br><input name="passwd2" size="20" maxlength="8" value="" class="inputtext" id="confpass" tabindex="3" type="password"></div>
						<!-- <br clear="all"> -->
						<div class="fleft" style="padding:15px 0px 15px 0px;"><div class="divbutton"><input name="change" value="Change Password" class="button" onclick="validateofpass();" tabindex="4" type="button"></div></div></form></div>
						<br><br>
					</div>
				</div>

				<div style="background: transparent url(<?=$confValues['IMGSURL']?>/inner-tab-border2.gif) repeat scroll 0%; float: left; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 1px; height: 33px;"></div>
			</div></div><br clear="all">
							<!-- Middle Contant }-->
		</div>
	</div><!-- inner div }-->
</div> <!-- for equal height and 1024 res -->
</div>  <!-- end div fro laoding content!-->			
</div>
</div>	
<!-- Content Area }-->
<?
if($varInnerTabName==2) { echo '<img src="'.$confValues['IMGSURL'].'/trans.gif" onload="clickTab(1,6,\'sectab\');">'; }
elseif($varInnerTabName==3) { echo '<img src="'.$confValues['IMGSURL'].'/trans.gif" onload="clickTab(6,6,\'sectab\');">'; }
else {  echo '<img src="'.$confValues['IMGSURL'].'/trans.gif" onload="clickTab(2,6,\'sectab\');">'; }

?>