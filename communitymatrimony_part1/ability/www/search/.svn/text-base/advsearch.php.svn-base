<?php
//FILE INCLUDE
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath."/conf/cityarray.cil14");
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsSearch.php');

//OBJECT DECLARTION
$objDomainInfo	= new domainInfo;
$objCommon		= new clsCommon;
$objSearch		= new Search;

//SORT CONF ARRAYS
asort($arrEducationList);
asort($arrCountryList);
asort($arrTotalOccupationList);

//SavedsearchId
$varSrchType	= 2;
$varSrchId		= $_REQUEST['srchId'];
$varDomainIdVal	= $confValues['DOMAINCASTEID'];

include_once($varRootBasePath.'/www/search/srchcommonfuns.php');

$varTitle	= is_numeric($varSrchId) ? 'Edit Saved ' : ''; 
$varMStAge	= $objDomainInfo->getMStartAge();
$varMEdAge	= $objDomainInfo->getMEndAge();
$varFMStAge	= $objDomainInfo->getFStartAge();
$varFMEdAge	= $objDomainInfo->getFEndAge();
$varFeaMartitalStatus = $objDomainInfo->useMaritalStatus();
$varMSRetCnt = 0;
if($varFeaMartitalStatus == 1){
	$arrRetVal		= $objDomainInfo->getMaritalStatusOption();
	$varMSRetCnt	= count($arrRetVal);
}

$varFeaHoroscope	= $objDomainInfo->useHoroscope();

//Age Values
$varAgeFrom = $arrSelSavedSrchInfo['Age_From']==''?($sessGender==2 ? $varMStAge : $varFMStAge) : $arrSelSavedSrchInfo['Age_From'];
$varAgeTo	= $arrSelSavedSrchInfo['Age_To']==''?($sessGender==2 ? $varMEdAge : $varFMEdAge) : $arrSelSavedSrchInfo['Age_To'];

//Height Values
$varHeightFrom = $arrSelSavedSrchInfo['Height_From']==''? '121.92' : $arrSelSavedSrchInfo['Height_From'];
$varHeightTo   = $arrSelSavedSrchInfo['Height_To']==''? '241.3' : $arrSelSavedSrchInfo['Height_To'];

//Annual Income
$arrAnnIncome = split('~', $arrSelSavedSrchInfo['Annual_Income']);

//Photo & Horoscope
$arrPhotoHoro	= split('~', $arrSelSavedSrchInfo['Show_Photo_Horoscope']);
$varPhotoChk	= ($arrPhotoHoro[0] == '1') ? 'checked' : '';
$varHoroChk		= ($arrPhotoHoro[1] == '1') ? 'checked' : '';
if($sessMatriId == '' || $varSrchId ==''){$arrSelSavedSrchInfo['Marital_Status']=1;}
$varAnyMaritalStatus = '';
if($arrSelSavedSrchInfo['Marital_Status']=='0'){$varAnyMaritalStatus = "checked";}
?>
<script>
	<?php echo genCountrybasedStates();?>
	var MaritalCnt=<?=$varMSRetCnt;?>, MStAge=<?=$varMStAge;?>, MEdAge=<?=$varMEdAge;?>, FMStAge=<?=$varFMStAge;?>, FMEdAge=<?=$varFMEdAge;?>;
</script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/search.js" ></script>
<style>.srchselect {width: 180px;}</style>
<!-- Content Area -->
<center>
<div>
<form style="margin: 0px; padding: 0px;" name="RSearchForm" action="<?=$varResultsURL;?>" method="post">
	<div class="rpanel fleft">
		<input type="hidden" name="randId" value="">
		<input type="hidden" name="srchType" value="2">
		<input type="hidden" name="saveSrch" value="">
		<input type="hidden" name="srchId" value="<?=$arrSelSavedSrchInfo['Search_Id'];?>">
		<input type="hidden" name="act" value="srchresult">
		<input type="hidden" name="page" value="1">
		<input type="hidden" name="redirectjspath" id="redirectjspath" value="<?=$varResultsURL;?>">

		<div class="normtxt1 clr2 padb5 padl"><font class="clr bld"><?=$varTitle;?>Search Options</font></div>
		<div class="linesep fright" style="width:550px;"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div><div style="clear:both;"></div>
		<div class="smalltxt clr2 padt5 padl"><a href="<?=$confValues['SERVERURL']?>/search/" class="clr1">Basic</a> &nbsp;|&nbsp; <font class="clr bld">Advanced</font> &nbsp;|&nbsp; <a href="index.php?act=memidsearch" class="clr1">By Member ID</a></div><br clear="all"><br clear="all">

		<div class="linesep fright" style="width:550px;"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
		<div class="normtxt clr2 padtb5 padl"><font class="clr bld">Basic Search Criteria</font></div><br clear="all">
		<?if($sessMatriId ==""){?>
		<div style="display:<?=$varGenderBlock?>">
		<div class="srchdivlt smalltxt fleft tlright"><?=$arrLabel['lblLookingFor']?></div>
		<div class="srchdivrt smalltxt fleft"><input type="radio" onclick="checkGenderAge(this.form);validateAge(this.form,'ageerr');" tabindex="1" value="2" name="gender" checked/> <font class="smalltxt">Female</font><input type="radio" onclick="checkGenderAge(this.form);validateAge(this.form,'ageerr');" tabindex="2" value="1" name="gender"/> <font class="smalltxt">Male</font>
		</div>
		<br clear="all">
		</div>
		<?}?>

		<!-- Age -->
		<div class="srchdivlt smalltxt fleft tlright"><?=$arrLabel['lblAge']?></div>
		<div class="srchdivrt smalltxt fleft">From
			<input type="text" name="ageFrom" tabindex="3" size=2 maxlength=2  value="<?=$varAgeFrom;?>" class="inputtext" onBlur="validateAge(this.form,'ageerr');" >&nbsp;&nbsp;&nbsp;
		  to&nbsp;&nbsp;&nbsp;	
			<input type="text" name="ageTo" size=2 maxlength=2 value="<?=$varAgeTo;?>"  tabindex="4" class="inputtext" onBlur="validateAge(this.form,'ageerr');">
			&nbsp;years
		</div>
		<div id="ageerr" class="errortxt fleft" style="display:none;padding-left:9px;"></div>
		<br clear="all">

		<!-- Height -->
		<div class="smalltxt fleft tlright srchdivlt"><?=$arrLabel['lblHeight']?>&nbsp;</div>
		<div class="fleft srchdivrt tlleft smalltxt">From
			<select class="inputtext" NAME="heightFrom" size="1" onBlur="validateHeight(this.form,'heighterr')" tabindex="5" style="width: 110px;"><?=$objCommon->getValuesFromArray($arrHeightList, "", "", $varHeightFrom);?></select>
			&nbsp;&nbsp;to&nbsp;
			<select style="width:110px" class="inputtext" NAME="heightTo" size="1" onBlur="validateHeight(this.form,'heighterr')" tabindex="6"><?=$objCommon->getValuesFromArray($arrHeightList, "", "", $varHeightTo);?></select><br>
			<span id="heighterr" class="errortxt"></span>
		</div><br clear="all">

		<!-- Marital Status -->
		<?php
		$varRetrunVal == '';
		if($varFeaMartitalStatus==1){
			if($varMSRetCnt > 1){
				echo '<div class="srchdivlt smalltxt fleft tlright">'.$objDomainInfo->getMaritalStatusLabel().'</div><div class="srchdivrt smalltxt fleft">';
				echo '<input type="checkbox" onclick="funMaritalStatusAny(\'RSearchForm\');" class="frmchkbox" value="0" name="maritalStatus[]" id="maritalStatus" '.$varAnyMaritalStatus.'/><font class="smalltxt"> Any   </font>';
				$varReturnVal	= $objSearch->getCheckBoxValues($arrSelSavedSrchInfo['Marital_Status'], $arrRetVal, 'maritalStatus', "funMaritalStatus('RSearchForm');");
				echo '<br><span id="maritalerr" class="errortxt"></span></div><br clear="all">';
			}
		}
		?>
		<!-- Child Block-->
		<div style="display:<?=($varReturnVal == '') ? 'none' : 'block'?>" id="childblock">
			<div class="srchdivlt smalltxt fleft tlright">Have Children</div>
			<div class="srchdivrt smalltxt fleft">
				<input type="radio" class='frmelements' name='haveChildren' id='haveChildren' value='0'>Doesn't matter&nbsp;
				<?$objSearch->getRadioValues($arrSelSavedSrchInfo['Children'], $arrChildLivingStatus, 'haveChildren', '')?>
			</div>
		</div>
		
		<?php
		//Religion
		if($objDomainInfo->useReligion()){
			$arrRetVal = $objDomainInfo->getReligionOption();
			$varRetCnt = count($arrRetVal);
			if($varRetCnt > 1){
			echo '<div class="srchdivlt smalltxt fleft tlright">'.$objDomainInfo->getReligionLabel().'</div>';
			echo '<div class="srchdivrt fleft"><select class="srchselect" name="religion" tabindex="7">';
			echo $objCommon->getValuesFromArray($arrRetVal, "Any", "0", $arrSelSavedSrchInfo['Religion']);
			echo '</select><br></div>';
			}
		}

		//Denomination
		if($objDomainInfo->useDenomination()){
			$arrRetVal	= $objDomainInfo->getDenominationOption();
			$arrRetVal	= $objCommon->changingArray($arrRetVal);
			$varRetCnt	= count($arrRetVal);
			$varRetLabel= $objDomainInfo->getDenominationLabel();
			if($varRetCnt > 1){
			echo '<div class="srchdivlt smalltxt fleft tlright">'.$varRetLabel.'</div>'; 
			echo '<div class="srchdivrt fleft"><div class="fleft"><select class="srchselect" size="4" multiple id="denominationTemp" name="denominationTemp[]" tabindex="8" ondblclick="moveOptions(this.form.denominationTemp, this.form.denomination)">';
			echo  $objCommon->getValuesFromArray($arrRetVal, "Any", "0", "");
			echo '</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.denominationTemp, this.form.denomination)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.denomination, this.form.denominationTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="denomination" name="denomination[]" tabindex="8" ondblclick="moveOptions(this.form.denomination, this.form.denominationTemp)">';
			echo $objSearch->getOpionalValues($arrSelSavedSrchInfo['Denomination'], $arrRetVal);
			echo '</select></div><br clear="all"><font class=\'opttxt\'>Hold CTRL key to select multiple items.</font><br clear="all"/></div>';
			}
		}
		

		//Caste
		if($objDomainInfo->useCaste()){
			$arrRetVal		= $objDomainInfo->getCasteOption();
			$arrRetVal		= $objCommon->changingArray($arrRetVal);
			$varRetCnt		= count($arrRetVal);
			$varRetLabel	= $objDomainInfo->getCasteLabel();
			if($varRetCnt > 1){
				echo '<div class="srchdivlt smalltxt fleft tlright">'.$varRetLabel.'</div>'; 
				echo '<div class="srchdivrt fleft"><div class="fleft"><select class="srchselect" size="4" multiple id="casteTemp" name="casteTemp[]" tabindex="8" ondblclick="moveOptions(this.form.casteTemp, this.form.caste)">';
				echo  $objCommon->getValuesFromArray($arrRetVal, "Any", "0", "");
				echo '</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.casteTemp, this.form.caste)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.caste, this.form.casteTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="caste" name="caste[]" tabindex="8" ondblclick="moveOptions(this.form.caste, this.form.casteTemp)">';
				echo $objSearch->getOpionalValues($arrSelSavedSrchInfo['Caste_Or_Division'], $arrRetVal);
				echo '</select></div><br clear="all"><font class=\'opttxt\'>Hold CTRL key to select multiple items.</font><br clear="all"/></div>';
			}else if($varRetCnt == 0) {
				echo '<div class="srchdivlt smalltxt fleft tlright">'.$varRetLabel.'</div>'; 
				echo '<div class="srchdivrt fleft">
						<div  style="float:left;"><input type="hidden" name="casteTxt" value="yes"><input type="text" NAME="caste" id="caste" class="inputtext" tabindex="8" value="'.$arrSelSavedSrchInfo['Caste_Or_Division'].'"></div>
					  </div>';
			}
		}

		//Subcaste
		if($objDomainInfo->useSubcaste()){
			$arrRetVal		= $objDomainInfo->getSubcasteOption();
			$arrRetVal		= $objCommon->changingArray($arrRetVal);
			$varRetCnt		= count($arrRetVal);
			$varRetLabel	= $objDomainInfo->getSubcasteLabel();			
			if($varRetCnt > 1){
				echo '<div class="srchdivlt smalltxt fleft tlright">'.$varRetLabel.'</div>'; 
				echo '<div class="srchdivrt fleft"><div class="fleft"><select class="srchselect" size="4" multiple id="subcasteTemp" name="subcasteTemp[]" tabindex="7" ondblclick="moveOptions(this.form.subcasteTemp, this.form.subcaste)">';
				echo $objCommon->getValuesFromArray($arrRetVal, "Any", "0", "");
				echo '</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.subcasteTemp, this.form.subcaste)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.subcaste, this.form.subcasteTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="subcaste" name="subcaste[]" tabindex="8" ondblclick="moveOptions(this.form.subcaste, this.form.subcasteTemp)">';
				echo $objSearch->getOpionalValues($arrSelSavedSrchInfo['Subcaste'], $arrRetVal);
				echo'</select></div><br clear="all"><font class=\'opttxt\'>Hold CTRL key to select multiple items.</font><br clear="all"/></div>';
			}else if($varRetCnt == 0) {
				$varDispSubcaste = is_numeric($arrSelSavedSrchInfo['Subcaste'])? '' : $arrSelSavedSrchInfo['Subcaste'];
				echo '<div class="srchdivlt smalltxt fleft tlright">'.$varRetLabel.'</div>'; 
				echo '<div class="srchdivrt fleft">
						<div style="float:left;"><input type="hidden" name="subcasteTxt" value="yes"><input type="text" NAME="subcaste" id="subcaste" class="inputtext" tabindex="7" value="'.$varDispSubcaste.'"></div>
					  </div>';
			}
		}

		//Mother Tongue
		if($objDomainInfo->useMotherTongue()){
			$arrRetVal		= $objDomainInfo->getMotherTongueOption();
			$arrRetVal		= $objCommon->changingArray($arrRetVal);
			$varRetCnt		= count($arrRetVal);
			$varRetLabel	= $objDomainInfo->getMotherTongueLabel();			
			if($varRetCnt > 1){
				echo '<div class="srchdivlt smalltxt fleft tlright">'.$varRetLabel.'</div>';
				echo '<div class="srchdivrt fleft"><div class="fleft"><select class="srchselect" id="motherTongueTemp" name="motherTongueTemp[]" size="4" multiple tabindex="10" ondblclick="moveOptions(this.form.motherTongueTemp, this.form.motherTongue)">';
				echo $objCommon->getValuesFromArray($arrRetVal, "Any", "0", "");
				echo '</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.motherTongueTemp, this.form.motherTongue)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.motherTongue, this.form.motherTongueTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="motherTongue" name="motherTongue[]" tabindex="11" ondblclick="moveOptions(this.form.motherTongue, this.form.motherTongueTemp)">';
				echo $objSearch->getOpionalValues($arrSelSavedSrchInfo['Mother_Tongue'], $arrRetVal);
				echo '</select></div><br><font class=\'opttxt\'>Hold CTRL key to select multiple items.</font></div>';
			}else if($varRetCnt == 0){
				echo '<div class="srchdivlt smalltxt fleft tlright">'.$varRetLabel.'</div>'; 
				echo '<div class="srchdivrt fleft">
						<div style="float:left;"><input type="hidden" name="motherTongueTxt" value="yes"><input type="text" NAME="motherTongue" id="motherTongue" class="inputtext" tabindex="7"></div>
					  </div>';
			}
		}
		
		//Physical Status
		echo '<div class="srchdivlt smalltxt fleft tlright">'.$arrLabel['lblPhysicalStatus'].'&nbsp;</div><div class="srchdivrt smalltxt fleft"><select class="srchselect" name="physicalStatus" tabindex="12">';
		echo $objCommon->getValuesFromArray($arrPhysicalStatusList, "", "", $arrSelSavedSrchInfo['Physical_Status']).'</select></div>';
		
		//Gothram
		if($objDomainInfo->useGothram()){
			$arrRetVal		= $objDomainInfo->getGothramOption();
			$arrRetVal		= $objCommon->changingArray($arrRetVal);
			$varRetCnt		= count($arrRetVal);
			$varRetLabel	= $objDomainInfo->getGothramLabel();			
			if($varRetCnt > 1){
				echo '<div class="srchdivlt smalltxt fleft tlright">'.$varRetLabel.'</div>';
				echo '<div class="srchdivrt fleft"><div class="fleft"><select class="srchselect" name="gothramTemp[]" size="4" multiple tabindex="9" id="gothramTemp" ondblclick="moveOptions(this.form.gothramTemp, this.form.gothram)">';
				if($sessMatriId != ''){
					echo $objCommon->getValuesFromArray($arrRetVal, "All(Except my gothra)", 99, "");
				}else{
					echo $objCommon->getValuesFromArray($arrRetVal, "", "", "");
				}
				echo '</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.gothramTemp, this.form.gothram)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.gothram, this.form.gothramTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="gothram" name="gothram[]" tabindex="11" ondblclick="moveOptions(this.form.gothram, this.form.gothramTemp)">';
				$arrRetVal[99]	= "All(Except my gothra)";
				echo $objSearch->getOpionalValues($arrSelSavedSrchInfo['Gothram'], $arrRetVal);
				echo '</select></div><br><font class=\'opttxt\'>';
				if($sessMatriId==''){
					echo 'Please select Gothra(m) of the prospect.The Gothra(m) should not be the same as yours.<br>';
				}
				echo 'Hold CTRL key to select multiple items.</font></div>';
			}else if($varRetCnt == 0){
				echo '<div class="srchdivlt smalltxt fleft tlright">'.$varRetLabel.'</div>'; 
				echo '<div class="srchdivrt fleft">
						<div style="float:left;"><input type="hidden" name="gothramTxt" value="yes"><input type="text" NAME="gothram" id="gothram" class="inputtext" tabindex="7" value="'.$arrSelSavedSrchInfo['Gothram'].'"></div>
					  </div><br>';
			}
		}
		
		if($objDomainInfo->useStar() && $objDomainInfo->useRaasi()){
		echo '<br clear="all"><div class="pad3 pntr" style="background-color:#efefef;height:17px;" onclick="javascript:showhidediv(\'horosdiv\');chswap(\'h1\',document.getElementById(\'h1\').innerHTML);"><div class="smalltxt bld fleft" style="padding-left:5px;">Horoscope</div><div class="fright normtxt clr bld"><div id="h1" style="border:1px solid #999999;padding:0px 3px;">+</div></div></div>';

		//Star 
		$arrRetVal		= $objDomainInfo->getStarOption();
		$varRetCnt		= count($arrRetVal);
		$varRetLabel	= $objDomainInfo->getStarLabel();			
		if($varRetCnt > 1){
			echo '<div id="horosdiv" class="padtb10" style="display:none;"><div class="srchdivlt smalltxt fleft tlright">'.$varRetLabel.'</div>';
			echo '<div class="srchdivrt fleft"><div class="fleft"><select class="srchselect" id="starTemp" name="starTemp[]" size="4" multiple tabindex="10" ondblclick="moveOptions(this.form.starTemp, this.form.star)">';
			echo $objCommon->getValuesFromArray($arrRetVal, "Any", "0", "");
			echo '</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.starTemp, this.form.star)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.star, this.form.starTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="star" name="star[]" tabindex="11" ondblclick="moveOptions(this.form.star, this.form.starTemp)">';
			echo $objSearch->getOpionalValues($arrSelSavedSrchInfo['Star'], $arrRetVal);
			echo '</select></div><br><font class=\'opttxt\'>Hold CTRL key to select multiple items.</font></div>';
		}
		
		//Raasi
		$arrRetVal		= $objDomainInfo->getRaasiOption();
		$varRetCnt		= count($arrRetVal);
		$varRetLabel	= $objDomainInfo->getRaasiLabel();			
		if($varRetCnt > 1){
			echo '<div class="srchdivlt smalltxt fleft tlright">'.$varRetLabel.'</div>';
			echo '<div class="srchdivrt fleft"><div class="fleft"><select class="srchselect" id="raasiTemp" name="raasiTemp[]" size="4" multiple tabindex="11" ondblclick="moveOptions(this.form.raasiTemp, this.form.raasi)">';
			echo $objCommon->getValuesFromArray($arrRetVal, "Any", "0", "");
			echo '</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.raasiTemp, this.form.raasi)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.raasi, this.form.raasiTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="raasi" name="raasi[]" tabindex="11" ondblclick="moveOptions(this.form.raasi, this.form.raasiTemp)">';
			echo $objSearch->getOpionalValues($arrSelSavedSrchInfo['Raasi'], $arrRetVal);
			echo '</select></div><br><font class=\'opttxt\'>Hold CTRL key to select multiple items.</font></div>';
		}
		?>
		<div class="srchdivlt smalltxt fleft tlright">Manglik / Chevvai dosham</div>
		<div class="srchdivrt smalltxt fleft">
		<?$objSearch->getRadioValues($arrSelSavedSrchInfo['Chevvai_Dosham'], $arrManglikList, 'manglik', '')?>
		</div>
		</div>
		
		<?}?>
		<br clear="all">
		<div class="pad3 pntr" onclick="javascript:showhidediv('locdiv');chswap('l1',document.getElementById('l1').innerHTML);" style="background-color:#efefef;height:17px;"><div class="smalltxt bld fleft" style="padding-left:5px;">Location</div><div class="fright normtxt clr bld"><div id="l1" style="border:1px solid #999999;padding:0px 3px;">+</div></div></div><div id="locdiv" style="display:none;" class="padb10">

		<div class="srchdivlt smalltxt fleft tlright"><?=$arrLabel['lblCountry']?></div>
		<div class="srchdivrt smalltxt fleft">
			<div class="fleft"><select name="countryTemp[]" id="countryTemp" size="4" multiple class="srchselect" ondblclick="moveOptions(this.form.countryTemp, this.form.country)"> <?=$objCommon->getValuesFromArray($arrCountryList, "Any", "0", "");?></select>
			</div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button"  onclick="moveOptions(this.form.countryTemp, this.form.country)"><br><img src="<?=$confValues['IMGSURL'].'/trans.gif';?>" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.country, this.form.countryTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="country" name="country[]" ondblclick="moveOptions(this.form.country, this.form.countryTemp)">
			<?	$varCtryReturnVal = $objSearch->getOpionalValues2($arrSelSavedSrchInfo['Country'], $arrCountryList, 'country');	?>
			</select></div><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
		</div>
		<br clear="all">
		<div style="display:<?=($varCtryReturnVal == '') ? 'none' : 'block'?>;" id="statesblock">
		<div class="srchdivlt smalltxt fleft tlright"><?=$arrLabel['lblState']?></div>
		<div class="srchdivrt smalltxt fleft">
			<div class="fleft"><select id="residingStateTemp" name="residingStateTemp[]" size="4" multiple class="srchselect" ondblclick="moveOptions(this.form.residingStateTemp, this.form.residingState)"></select>
			</div>
			<?if($varCtryReturnVal != ''){?>
				<script>getFirstOptVal(this.document.RSearchForm.country, 'country');</script>
			<? }?>
			<div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.residingStateTemp, this.form.residingState)"><br><img src="<?=$confValues['IMGSURL'].'/trans.gif';?>" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.residingState, this.form.residingStateTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple name="residingState[]" id="residingState" ondblclick="moveOptions(this.form.residingState, this.form.residingStateTemp)">
			<?$varStatReturnVal = $objSearch->getOpionalValues2($arrSelSavedSrchInfo['Residing_State'], $arrSaveResStateList, 'state');?>
			</select></div><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
		</div>
		<br clear="all">
		</div>
		<div style="display:<?=($varStatReturnVal == '') ? 'none' : 'block'?>;" id="cityblock">
		<div class="srchdivlt smalltxt fleft tlright"><?=$arrLabel['lblCity']?></div>
		<div class="srchdivrt smalltxt fleft">
			<div class="fleft"><select name="residingCityTemp[]" id="residingCityTemp" size="4" multiple class="srchselect" ondblclick="moveOptions(this.form.residingCityTemp, this.form.residingCity)"></select>
			</div>
			<? if($varStatReturnVal != ''){ getTotalSavedCity($arrSelSavedSrchInfo['Residing_State']);?>
				<script>getFirstOptVal(this.document.RSearchForm.residingState, 'state');</script>
			<? }?>
			<div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.residingCityTemp, this.form.residingCity)"><br><img src="<?=$confValues['IMGSURL'].'/trans.gif';?>" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.residingCity, this.form.residingCityTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple name="residingCity[]" id="residingCity" ondblclick="moveOptions(this.form.residingCity, this.form.residingCityTemp)">
			<? $objSearch->getOpionalValues($arrSelSavedSrchInfo['Residing_District'], $arrSaveResCityList);?>
			</select></div><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
		</div>
		<br clear="all">
		</div>

		<div style="display:bock;" id="residentblock">
		<div class="srchdivlt smalltxt fleft tlright">Resident status</div>
		<div class="srchdivrt smalltxt fleft">
		<input type="radio" tabindex="1" value="0" name="residentStatus"/>Any
		<?
		unset($arrResidentStatusList[6]);
		$objSearch->getRadioValues($arrSelSavedSrchInfo['Resident_Status'], $arrResidentStatusList, 'residentStatus', '')
		?>
		</div>
		</div>
		</div>

		<br clear="all"><div class="pad3 pntr" style="background-color:#efefef;height:17px;" onclick="javascript:showhidediv('edudiv');chswap('e1',document.getElementById('e1').innerHTML);"><div class="smalltxt bld fleft" style="padding-left:5px;">Education / Occupation</div><div class="fright normtxt clr bld"><div id="e1" style="border:1px solid #999999;padding:0px 3px;">+</div></div></div><div id="edudiv" style="display:none;" class="padtb10">
		<!-- Education -->
		<div class="srchdivlt smalltxt fleft tlright">Education</div> 
		<div class="srchdivrt smalltxt fleft">
			<div class="fleft"><select class="srchselect" multiple name="educationTemp[]" size="4" id="educationTemp" ondblclick="moveOptions(this.form.educationTemp, this.form.education)">
				<?=$objCommon->getValuesFromArray($arrEducationList, "Any", "0", "");?>
			</select>
			</div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.educationTemp, this.form.education)"><br><img src="<?=$confValues['IMGSURL'].'/trans.gif';?>" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.education, this.form.educationTemp)"></div><div class="fleft"><select class="srchselect" multiple name="education[]" size="4" id="education" ondblclick="moveOptions(this.form.education, this.form.educationTemp)">
			<? $objSearch->getOpionalValues($arrSelSavedSrchInfo['Education'], $arrEducationList);?>
			</select></div><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
		</div> 

		<!-- Occupation -->
		<div class="srchdivlt smalltxt fleft tlright">Occupation</div> 
		<div class="srchdivrt smalltxt fleft">
			<div class="fleft"><select multiple size="4" id="occupationTemp" name="occupationTemp[]" class="srchselect" ondblclick="moveOptions(this.form.occupationTemp, this.form.occupation)">
				<?php
				 $arrRet = $objCommon->changingArray($arrTotalOccupationList);
				 echo $objCommon->getValuesFromArray($arrRet, "Any", "0", "");
				?>
			</select>
			</div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.occupationTemp, this.form.occupation)"><br><img src="<?=$confValues['IMGSURL'];?>/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.occupation, this.form.occupationTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="occupation" name="occupation[]" ondblclick="moveOptions(this.form.occupation, this.form.occupationTemp)">
			<? $objSearch->getOpionalValues($arrSelSavedSrchInfo['Occupation'], $arrRet);?>
			</select></div><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
		</div>
		<br clear="all"/>
		</div>		

		<br clear="all"><div class="pad3 pntr" style="background-color:#efefef;height:17px;" onclick="javascript:showhidediv('habitdiv');chswap('ha1',document.getElementById('ha1').innerHTML);"><div class="smalltxt bld fleft" style="padding-left:5px;">Habits</div><div class="fright normtxt clr bld"><div id="ha1" style="border:1px solid #999999;padding:0px 3px;">+</div></div></div><div id="habitdiv" style="display:none;" class="padb10">
		<!--Eating-->
		<div class="srchdivlt smalltxt fleft tlright">Eating habits</div>
		<div class="srchdivrt smalltxt fleft">
		<input type="checkbox" tabindex="1" value="0" id="eating" name="eating[]" onclick="checkHabits('RSearchForm', 'eating');"/><font class="smalltxt">Any</font>
		<? $objSearch->getCheckBoxValues($arrSelSavedSrchInfo['Eating_Habits'], $arrEatingHabitsList, 'eating', 'checkHabits(\'RSearchForm\', \'eating\');')?>
		</div>
		<br clear="all">

		<!--Drinking-->
		<div class="srchdivlt smalltxt fleft tlright">Drinking</div>
		<div class="srchdivrt smalltxt fleft">
		<input type="checkbox" tabindex="1" value="0"  id="drinking" name="drinking[]" onclick="checkHabits('RSearchForm', 'drinking');"/><font class="smalltxt">Any</font>
		<? $objSearch->getCheckBoxValues($arrSelSavedSrchInfo['Drinking'], $arrDrinkList, 'drinking', 'checkHabits(\'RSearchForm\', \'drinking\');')?>
		</div>
		<br clear="all">

		<!--Smoking-->
		<div class="srchdivlt smalltxt fleft tlright">Smoking</div>
		<div class="srchdivrt smalltxt fleft">
		<input type="checkbox" tabindex="1" value="0" id="smoking" name="smoking[]" onclick="checkHabits('RSearchForm', 'smoking');"/><font class="smalltxt">Any</font>
		<? $objSearch->getCheckBoxValues($arrSelSavedSrchInfo['Smoking'], $arrSmokeList, 'smoking', 'checkHabits(\'RSearchForm\', \'smoking\');')?>
		</div>
		<br clear="all">
		</div>
		
		<?php if($sessMatriId != ''){?>
		<div id="search_savebox" class="fright posabs" style="background: transparent url(<?=$confValues['IMGSURL']?>/savesearch.gif) no-repeat scroll left top; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; width: 264px; height:115px; text-align: left; display: none; position: absolute;">
			<div style="padding: 14px 15px 10px 10px;">
				<div style="padding: 2px 0px 0px;" class="fleft"><font class="normtxt bld">Save Search</font></div>
				<div style="padding: 2px 0px 0px;" class="fright"><a onclick="javascript:$('search_savebox').style.display='none';" href="javascript:;"><img height="12" border="0" width="12" alt="" src="<?=$confValues['IMGSURL']?>/close.gif"/></a></div><br clear="all"/>
				<input type="text" onfocus="if(this.value=='Enter search name'){ this.value=''}" onblur="if(this.value==''){this.value='Enter search name';}" value="<?=$varSaveSrchName?>" style="margin: 5px 0px; width: 220px; vertical-align: middle;" class="inputtext smalltxt" id="searchName" name="searchName" maxlength="14"/><br clear="all"/>
				<span style="vertical-align: top; padding-right: 18px;" class="opttxt">(Example: My Search)</span><input type="button" value="Save & Search" class="button" onclick="multiple_save('RSearchForm')"/><br clear="all"><span class="errortxt" id="saveerr"></span>
			</div>
		</div>
		<?}?>
		<br clear="all">
		<div class="srchdivlt smalltxt fleft tlright">Show profiles with</div> 
		<div class="srchdivrt smalltxt fleft">
			<input type="checkbox"  class="frmelements" name="photoOpt" id="photoOpt" value="1" <?=$varPhotoChk;?>><font class="smalltxt">&nbsp;<?=$arrLabel['lblPhoto']?></font>
			<?php 
			$varWidth = 175;
			if($varFeaHoroscope == 1){
			echo '&nbsp;&nbsp;<input type="checkbox"  class="frmelements" name="horoscopeOpt" id="horoscopeOpt" value="1" '.$varHoroChk.'><font class="smalltxt">&nbsp;'.$arrLabel['lblHoroscope'].'</font>';
			$varWidth = 105;
			}
			?>
			<img width="<?=$varWidth;?>" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/>
			<?if($sessMatriId != ''){?>
			<span id="save_srch_link"><a style="cursor: pointer;" class="smalltxt clr1" onclick="save_search_box('save_srch_link','search_savebox')">Save & Search</a></span> <img width="5" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/> <b>or</b> &nbsp;<?}?>
			<input type="button" class="button" value="Search" onClick="return validate('RSearchForm');">
		</div> 
		<br clear="all"/><br clear="all"/>
	</div>
</form>
</div>
</center>
<?php
unset($objCommon); 
unset($objSearch); 
unset($objDomainInfo); 
?>