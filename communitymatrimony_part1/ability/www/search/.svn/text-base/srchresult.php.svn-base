<?php
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsSearch.php");
include_once($varRootBasePath.'/lib/clsBasicviewCommon.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGender		= $varGetCookieInfo["GENDER"];
$varDomainId	= $confValues['DOMAINCASTEID'];

//OBJECT DECLARTION
$objDomainInfo	= new domainInfo;
$objCommon		= new clsCommon;
$objSearch		= new Search;
$objBasicComm	= new BasicviewCommon;

//SORT CONF ARRAYS
asort($arrEducationList);
asort($arrCountryList);
asort($arrTotalOccupationList);

//VARIABLE DECLARATION
$varCurrentDate	= date('Y-m-d H:i:s');
$varSrchType	= trim($_REQUEST["srchType"]);	
$varSrchName	= trim($_REQUEST["searchName"]);
$varSrchId		= trim($_REQUEST["srchId"]);
$varSaveSrch	= trim($_REQUEST["saveSrch"]);
$varDomainName	= $confValues['DOMAINNAME'];
$varErrorMsg	= "";
$objSearch->formDefaultValues();


$varMStAge	= $objDomainInfo->getMStartAge();
$varMEdAge	= $objDomainInfo->getMEndAge();
$varFMStAge	= $objDomainInfo->getFStartAge();
$varFMEdAge	= $objDomainInfo->getFEndAge();

if($_REQUEST['gender'] == 1 || $sessGender==2){
$varOppGen	= 1;
$varMaleChk = 'checked';
$varStAge	= $varMStAge;
$varEdAge	= $varMEdAge;
}else{
$varFemaleChk= 'checked';
$varOppGen	= 2;
$varStAge	= $varFMStAge;
$varEdAge	= $varFMEdAge;
}

//DB Connection
$objSearch->dbConnect('M', $varDbInfo['DATABASE']);

$varCondition['CNT']	= "S";

if($_REQUEST['type'] == 'refine'){
	$varCondition['LIMIT']	= $objSearch->refineSearch();
}else{
	if($varSaveSrch == 'yes' && $varSrchName!='' && preg_match("/^[a-zA-Z0-9\\s]{1,14}$/", $varSrchName))
		$varResponse =  $objSearch->putSaveSrchData();
	else if(is_numeric($varSrchId)) 
		$varResponse = $objSearch->saveSearch($varSrchId) ;
	else if(strlen($_REQUEST['ID'])>=9)
		$varResponse = $objSearch->viewSimilarProfile($_REQUEST['ID']); 
	else 
		$varResponse = $objSearch->regSearch(); 

	$varCondition['LIMIT']	= $objBasicComm->encryptData($varResponse);
}

//For Search Creitiria content
$varSearchCont	= '';
if($_POST['ageFrom']>0 && $_POST['ageTo']>0){
	$varSearchCont	= 'Age: '.$_POST['ageFrom'].' to '.$_POST['ageTo'].' yrs';
}

if($_POST['heightFrom']>0 && $_POST['heightTo']>0){
	$varSearchCont	.= ', Height: '.$arrHeightFeetList[$_POST['heightFrom']].' to '.$arrHeightFeetList[$_POST['heightTo']];
}

$varSearchCont	.= $objSearch->getStringValues($_POST['country'], $arrCountryList, ', Location: ');
$varSearchCont	.= $objSearch->getStringValues($_POST['motherTongue'], $arrMotherTongueList, ', Mother Tongue: ');
$varSearchCont	.= $objSearch->getStringValues($_POST['education'], $arrEducationList, ', Education: ');
$varSearchCont	.= $objSearch->getStringValues($_POST['occupation'], $arrTotalOccupationList, ', Occupation: ');
$varStringCont   = ($varDomainId == 2503) ? ', Sect:' : ', Denomination:';
$varSearchCont	.= $objSearch->getStringValues($_POST['denomination'], $arrDenominationList, $varStringCont);
$varSearchCont	.= $objSearch->getStringValues($_POST['caste'], $arrCasteList, ', Division: ');
$varSearchCont	.= $objSearch->getStringValues($_POST['subcaste'], $arrSubcasteList, ', Subcaste: ');
$varSearchCont	.= $objSearch->getStringValues($_POST['star'], $arrStarList, ', Star: ');


$varResCity = '';
if($sessMatriId != ''){
	$varFields	= array('Residing_District');
	$varCond	= "WHERE MatriId='".$sessMatriId."' AND Country=98";
	$varCityDet	= $objSearch->select($varTable['MEMBERINFO'], $varFields, $varCond, 1);
	$varResCity	= $varCityDet[0]['Residing_District'];
}
//UNSET OBJECT
$objSearch->dbClose();
unset($objBasicComm);
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/search.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/searchpaging.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchbasicview.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
<script>
function stylechange(vl)
{
	if(vl==0)
	{document.getElementById('conall').style.display='none';
 	 document.getElementById('conall1').style.display='block';
	}
	else
	{document.getElementById('conall').style.display='block';document.getElementById('conall1').style.display='none';}
}
</script>
<script>
	var MStAge=<?=$varMStAge;?>, MEdAge=<?=$varMEdAge;?>, FMStAge=<?=$varFMStAge;?>, FMEdAge=<?=$varFMEdAge;?>;
</script>
<div class="rpanel fleft">
	<div class="normtxt1 clr padb5 padl"><font class="clr bld">Search Results</font> &nbsp; [ <a onclick="javascript:showdiv('modsearch');" class="clr1">Modify Search</a> ]</div>
	<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><div style="clear:both;"></div>
	<div class="smalltxt clr2 padt5 padl" id="srtopbt">
		<?if($sessMatriId != '' && $objSearch->clsSearchErr==0){ ?>
		<font class="clr">Select : </font>
		<a class="clr1" href="javascript:;" onclick="chkAllTxt();">All</a> &nbsp|&nbsp; 
		<a class="clr1"  href="javascript:;" onclick="chkNoneTxt();">None</a> 
		<? } ?>
	</div>
	<center>
	<form name='frmSearchConds' style="margin:0px;padding:0px;">
		<input type="hidden" name="wc" Value="<?=$varCondition['LIMIT']?>">
		<input type="hidden" name="cn" Value="<?=$varCondition['CNT']?>">
		<input type="hidden" name="srchId" Value="<?=$objSearch->clsNewSavedSrchId;?>">
		<input type="hidden" name="srchName" Value="<?=$varSrchName;?>">
		<input type="hidden" name="srchType" Value="<?=$varSrchType;?>">
		<input type="hidden" name="gender" Value="<?=$varOppGen;?>">
	</form>
	
	<!-- Modify search panel starts -->
			<div id="modsearch" class="brdr disnon" style="background-color:#efefef;"> 
				<div class="pad10"> 
					<form name="RSearchForm" method="post" action="/search/index.php?type=refine">
					<input type="hidden" name="act" value="srchresult">
					<input type="hidden" name="wc" Value="<?=$varCondition['LIMIT']?>">
					<input type="hidden" name="srchType" Value="<?=$varSrchType;?>">
					<div class="fright"><a onclick="javascript:hidediv('modsearch');" class="pntr"><img src="<?=$confValues['IMGSURL']?>/close.gif" /></a></div>
					<?if($sessGender == ''){
					echo '<div class="disnon"><input type="radio" value="2" name="gender" '.$varFemaleChk.'/><input type="radio" value="1" name="gender" '.$varMaleChk.'/></div>';
					}?>
					<div class="smalltxt padtb5 tlleft">You have searched for: <?=$varSearchCont;?></div>
					<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div><br clear="all">
					<div class="smalltxt padtb3 fleft frmeldiv">Age</div> 
					<div class="fleft frmeldiv1a padtb3">
						<input type="text" class="inputtext" maxlength="2" size="2" value="<?=$varStAge?>" name="ageFrom"> 
						&nbsp;&nbsp;&nbsp;<font class="smalltxt">to</font>&nbsp;&nbsp;
						<input type="text" class="inputtext" maxlength="2" size="2" value="<?=$varEdAge?>" name="ageTo" onBlur="validateAge(this.form,'ageerr');">&nbsp;years
						<div id="ageerr" class="errortxt fleft" style="display:none;"></div>
					</div>
					<div class="smalltxt padtb3 fleft frmeldiv">Height</div><div class="fleft frmeldiv1a padtb3" style="padding-left:3px !important;padding-left:5px;">
						<select class="inputtext" name="heightFrom" size="1" onBlur="validateHeight(this.form,'heighterr')" tabindex="5" style="width:80px;"><?=$objCommon->getValuesFromArray($arrHeightList, "", "", "121.92");?></select>&nbsp;
						<select class="inputtext" NAME="heightTo" size="1" onBlur="validateHeight(this.form,'heighterr')" tabindex="6" style="width:80px;"><?=$objCommon->getValuesFromArray($arrHeightList, "", "", "241.3");?></select>
						<div id="heighterr" class="errortxt fleft" style="display:none;"></div>
					</div>
					
					
					<br clear="all"/>

					<div class="smalltxt padtb3 fleft frmeldiv">Location</div> 
					<div class="fleft frmeldiv1a padtb3">
						<select size="1" name="country" class="smalltxt select1" id="country"><?=$objCommon->getValuesFromArray($arrCountryList, "Any", "0", "");?></select>
					</div> 
					
					<?
					if($objDomainInfo->useMotherTongue()){
						$arrRetVal	= $objDomainInfo->getMotherTongueOption();
						$arrRetVal	= $objCommon->changingArray($arrRetVal);
					?>
					<div class="smalltxt padtb3 fleft frmeldiv">Mother Tongue</div> 
					<div class="fleft frmeldiv1a padtb3" style="padding-left:3px !important;padding-left:5px;">
						<select size="1" name="motherTongue" class="smalltxt select1" id="motherTongue"><?=$objCommon->getValuesFromArray($arrRetVal, "Any", "0", "");?></select>
					</div>
					<?}//MOTHER TONGUE?>
					<br clear="all"/>
					<div class="smalltxt padtb3 fleft frmeldiv">Education</div> 
					<div class="fleft frmeldiv1a padtb3">
						<select class="smalltxt select1" name="education" id="education" class="inputtext">
							<?=$objCommon->getValuesFromArray($arrEducationList, "Any", "0", "");?>
						</select>
					</div> 
					<div class="smalltxt padtb3 fleft frmeldiv">Occupation</div> 
					<div class="fleft frmeldiv1 padtb3" style="padding-left:3px !important;padding-left:5px;">
						<select size="1" id="occupation" name="occupation" class="smalltxt select1"><?=$objCommon->getValuesFromArray($arrTotalOccupationList, "Any", "0", "");?></select>
					</div>
					<br clear="all"/>

					<?
					$varDenomation = 0;
					if($objDomainInfo->useDenomination()){
						$varDenomation = 1;
						$arrRetVal	= $objDomainInfo->getDenominationOption();
						$arrRetVal	= $objCommon->changingArray($arrRetVal);
						$varRetCnt	= count($arrRetVal);
						$varRetLabel= $objDomainInfo->getDenominationLabel();
						if($varRetCnt > 1){
						echo '<div class="smalltxt padtb3 fleft frmeldiv">'.$varRetLabel.'</div><div class="fleft frmeldiv1a padtb3">
						<select size="1" name="denomination" id="denomination" class="smalltxt select1">';
						echo $objCommon->getValuesFromArray($arrRetVal, "Any", "0", "").'</select></div>';
						}
					}else if($objDomainInfo->useSubcaste()){
						$arrRetVal	= $objDomainInfo->getSubcasteOption();
						$arrRetVal	= $objCommon->changingArray($arrRetVal);
						$varRetCnt	= count($arrRetVal);
						$varRetLabel= $objDomainInfo->getSubcasteLabel();
						if($varRetCnt > 0){
						echo '<div class="smalltxt padtb3 fleft frmeldiv">'.$varRetLabel.'</div><div class="fleft frmeldiv1a padtb3">
						<select size="1" name="subcaste" id="subcaste" class="smalltxt select1">';
						echo $objCommon->getValuesFromArray($arrRetVal, "Any", "0", "").'</select></div>';
						}
					}


					if($varDenomation==1 && $objDomainInfo->useCaste()){
						$arrRetVal	= $objDomainInfo->getCasteOption();
						$arrRetVal	= $objCommon->changingArray($arrRetVal);
						$varRetCnt	= count($arrRetVal);
						$varRetLabel= $objDomainInfo->getCasteLabel();
						if($varRetCnt > 1){
						echo '<div class="smalltxt padtb3 fleft frmeldiv">'.$varRetLabel.'</div><div class="fleft frmeldiv1a padtb3">
						<select size="1" name="caste" id="caste" class="smalltxt select1">';
						echo $objCommon->getValuesFromArray($arrRetVal, "Any", "0", "").'</select></div>';
						}
					}else{
					?>
					<div class="smalltxt padtb3 fleft frmeldiv">Star</div> 
					<div class="fleft frmeldiv1 padtb3" style="padding-left:3px !important;padding-left:5px;">
						<select size="1" name="star" id="star" class="smalltxt select1">
							<?=$objCommon->getValuesFromArray($arrStarList, "Any", "0", "");?>
						</select>
					</div>
					<br clear="all"/>
					<?}?>

					<div class="padtb5"> 
						<div class="fright lpanelinner2d">
							<input type="button" class="button pntr" value="Search" onclick="refineSearch();">
						</div> 
					</div>
					</form>
				</div>
				<br clear="all"/> 
			</div> 
		</center>
		<!-- Modify search panel ends -->


	<div class="padt10">
		<div id='search_div'>
		<form name="buttonfrm" method="post" target="_blank" style="margin:0px;">
		<div id="srinnertopbt">
			<?if($sessMatriId != '' && $objSearch->clsSearchErr==0){ ?>
			<div id="checkdiv" class="fleft" style="width:30px;"><div class="disblk"><input type="checkbox" id="chk_all" name="chk_all" onclick="selectall(this.form, 'chk_all');"/> </div></div>
			<div id="mesgdiv" class="fleft">
				<div class="smalltxt clr2 padb5"><div class="fleft" style="padding-top:2px;"><?if ($varPartialFlag=='0') { ?><a class="clr1" onclick="sendListId('block','chk_all');">Block </a> &nbsp;|&nbsp; <? } ?><a class="clr1" onclick="sendListId('shortlist','chk_all');">Favourites</a>&nbsp;</div><div id="conall" class="fleft conallbf disblk" style="padding-top:2px;width:75px;height:25px;">&nbsp;|&nbsp; <a class="clr1" onclick="chkMsgSelIds();">Contact All</a></div><div id="conall1" class="fleft conallaf disnon" style="padding-top:2px;padding-left:11px;width:70px !important;width:75px;height:25px;"><a class="clr1" onclick="showdiv('contalldiv');stylechange(0);">Contact All</a></div> </div>
			</div><br clear="all">
			<? } ?>
			<div id="prevnext" class="padtb10"></div><br clear="all">	
		</div>
			
		<!-- Error throw div -->
		<center><div id="listalldiv" class="brdr tlleft pad10" style="display:none;background-color:#EEEEEE;width:500px;">
		</div></center><div class="cleard"></div>
		<!-- Error throw div -->
		<div id="contalldiv" class="disnon brdr tlleft pad10 posabs" style="background-color:#D2EDF4;width:520px !important;width:540px;left:150px;top:214px !important;top:216px;">
			<div class="fright tlright"><img onclick="hidediv('contalldiv');stylechange(1);" class="pntr" src="<?=$confValues['IMGSURL']?>/close.gif"/></div><br clear="all">
			<?include_once($varRootBasePath.'/www/search/contactall.php');?>
		</div>
	   <center>
		<div id="serResArea" style="border-bottom:1px solid #cbcbcb;margin:5px;">
			<?if($objSearch->clsSearchErr == 0){?>
			<img src='<?=$confValues['IMGSURL']?>/trans.gif' width="1" height="1" onload="getResult('1');">
			<?}else{ echo '<font class="smalltxt">'.$varResponse.'</font><BR><BR>';}?>
		</div></center>
		</form><br clear="all" />
		<div id="prevnext1" class="padtb10"></div>
		</div><br clear="all" /><br>
		<div style="margin-left:5px;"><?include_once($varRootBasePath.'/www/site/ipsearch.php');?></div>
		<br clear="all" />
		<div id='viewprof_div'></div>
	</div><br clear="all" />
</div>
<?php
unset($objSearch);
unset($objDomainInfo);
unset($objCommon);
?>