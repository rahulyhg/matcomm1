<?php
#============================================================================================================
# Author 		: S Rohini
# Start Date	: 17 Jul 2008
# End Date		: 17 Jul 2008
# Project		: MatrimonialProduct
# Module		: Search Class 
#============================================================================================================
//FILE INCLUDES
include_once($varRootBasePath."/lib/clsDB.php");
class Search extends DB
{
	public $clsSearchErr	 = 0;
	public $clsNewSavedSrchId= '';
	public $clsContactIds	 = 0;
	public $clsViewedIds	 = 0;
	function formDefaultValues(){
		global $frm;
		if(trim($_REQUEST['randId'])=='') { $_REQUEST['randId'] = rand(1000000,9999999); }
		if($_POST['ageFrom']==''|| $_POST['ageTo']=='') { 
			if($_POST['gender'] == 1){ $_POST['ageFrom']= 21;$_POST['ageTo']= 40;}
			else{ $_POST['ageFrom']= 18;$_POST['ageTo']= 40;}
		}
		if($_POST['heightFrom']=="") { $_POST['heightFrom']= '121.92'; }
		if($_POST['heightTo']=="") { $_POST['heightTo']='241.30'; }
	}
	
	function getPostVal($argArray){
		if(is_array($argArray))
			return join('~', $argArray);
		else
			return trim($argArray, '~');
	}

	function getOpionalValues($argSavedSrchVal, $argSourceArray){
		$funArrSrchVal = split('~', $argSavedSrchVal);
		foreach($funArrSrchVal as $funSinVal){
			if(array_key_exists($funSinVal, $argSourceArray)){
			echo '<option value="'.$funSinVal.'">'.$argSourceArray[$funSinVal].'</option>';
			}
		}
	}

	function getCityOpionalValues($argSavedSrchVal, $argSourceArray, $arglabelval=''){
		global $arrCityStateMapping;
		$funArrSrchVal = split('~', $argSavedSrchVal);
		$funRetVal		= '';
		foreach($funArrSrchVal as $funSinVal){
			if(array_key_exists($funSinVal, $argSourceArray)){
			echo '<option value="'.$arrCityStateMapping[$funSinVal].'#'.$funSinVal.'">'.$argSourceArray[$funSinVal].'</option>';
			}

			//for enable state &  city
			if($arglabelval == 'state' && $funRetVal=='' && $funSinVal<100 && $funSinVal>0){
				$funRetVal		= $funSinVal;
			}
		}
		return $funRetVal;
	}

	function getOpionalValues2($argSavedSrchVal, $argSourceArray, $arglabelval=''){
		$funArrSrchVal = split('~', $argSavedSrchVal);
		$funRetVal		= '';
		foreach($funArrSrchVal as $funSinVal){
			if(array_key_exists($funSinVal, $argSourceArray)){
			echo '<option value="'.$funSinVal.'">'.$argSourceArray[$funSinVal].'</option>';
			}

			//for enable state &  city
			if($arglabelval == 'country' && $funRetVal=='' && ($funSinVal==98 || $funSinVal==222)){
				$funRetVal		= $funSinVal;
			}else if($arglabelval == 'state' && $funRetVal=='' && $funSinVal<100 && $funSinVal>0){
				$funRetVal		= $funSinVal;
			}
		}
		return $funRetVal;
	}

	
	function getCheckBoxValues($argSavedSrchVal, $argSourceArray, $argChkName, $argOnclick){
		$funArrSrchVal	= split('~', $argSavedSrchVal);
		$funRetVal		= '';
		foreach($argSourceArray as $funKey=>$funVal){
			$varChecked = in_array($funKey, $funArrSrchVal) ? 'checked' : ''; 
			echo '<input type="checkbox" name="'.$argChkName.'[]" id="'.$argChkName.'" value="'.$funKey.'" onclick="'.$argOnclick.'" '.$varChecked.'/>'.$funVal;

			//for enable children status
			if($argChkName == 'maritalStatus' && $funRetVal==''){
				if($varChecked=='checked' && ($funKey==2 || $funKey==3 || $funKey==4)){
					$funRetVal = 'yes';
				}
			}
		}
		return $funRetVal;
	}

	function getRadioValues($argSavedSrchVal, $argSourceArray, $argRadioName, $argOnclick){
		foreach($argSourceArray as $funKey=>$funVal){
			$varChecked = ($funKey=="$argSavedSrchVal") ? 'checked' : '';
			if($argRadioName == 'residentStatus' && $funKey==5){echo '<br clear="all">';}
			echo '<input type="radio" class="frmelements" name="'.$argRadioName.'" id="'.$argRadioName.'" value="'.$funKey.'" '.$varChecked.'/>'.$funVal.'&nbsp';
		}
	}

	function regSearch()
	{
		global $sessMatriId,$sessGender;
		$funCities	= array();

		if($sessMatriId!='')
			$varGender	= $sessGender==2 ? 1 : 2;
		else
			$varGender	= $_POST["gender"]!='' ? $_POST["gender"] : 2;
				
		$varAgeFrom			= trim($_POST["ageFrom"]);	
		$varAgeTo			= trim($_POST["ageTo"]);
		if($varGender==1){ 
			$varAgeFrom	= ($varAgeFrom<21 || $varAgeFrom>70) ? 21 : $varAgeFrom;
			$varAgeTo	= ($varAgeTo<21 || $varAgeTo>70)? 33 : $varAgeTo;
		}else{
			$varAgeFrom	= ($varAgeFrom<18 || $varAgeFrom>70) ? 18 : $varAgeFrom;
			$varAgeTo	= ($varAgeTo<18 || $varAgeTo>70)? 30 : $varAgeTo;
		}
		
		$varHeightFrom		= ($_POST['heightFrom']=="")?'121.92':$_POST["heightFrom"];	
		$varHeightTo		= ($_POST['heightTo']=="")?'241.30':$_POST["heightTo"];
		$varHaveChildren	= $_POST["haveChildren"];
		$varAllDays			= $_POST["days"];
		$varPostedMonth		= $_POST["postedMonth"];
		$varPostedDay		= $_POST["postedDay"];
		$varPostedYear		= $_POST["postedYear"];
		$varPhysicalStatus	= $_POST["physicalStatus"];
		$varAnnualIncome	= $_POST["annualIncome"];
		$varAnnualIncome1	= $_POST["annualIncome1"];
		$varManglik			= $_POST["manglik"];
		$varEating			= $_POST["eating"];
		$varDrinking		= $_POST["drinking"];
		$varSmoking			= $_POST["smoking"];
		$varPhotoOpt		= $_POST["photoOpt"];
		$varHoroscopeOpt	= $_POST["horoscopeOpt"];
		$varSearchBy		= $_POST["searchBy"];
		$varSearchName		= trim($_POST["searchName"]);
		$varViewedOpt		= $_POST["alreadyViewedOpt"];
		$varContactOpt		= $_POST["alreadyContOpt"];
		$varShortListOpt	= $_POST["shortlistOpt"];
		
		$varMaritalStatus	= $_POST["maritalStatus"];
		$varReligion		= $_POST["religion"];	
		$varDenomination	= $_POST["denomination"];
		$varCaste			= $_POST["caste"];
		$varSubcaste		= $_POST["subcaste"];
		$varOccupationCat	= $_POST["occupationCat"];
		$varEducation		= $_POST["education"];
		$varOccupation		= $_POST["occupation"];
		$varMotherTongue	= $_POST["motherTongue"];
		$varResidingState	= $_POST["residingState"];
		$varResidingCity	= $_POST["residingCity"];
		$varResidentStatus	= $_POST["residentStatus"];
		$varCitizenship		= $_POST["citizenship"];
		$varCountry			= $_POST["country"];
		$varGothram			= $_POST["gothram"];
		$varStar			= $_POST["star"];
		$varRaasi			= $_POST["raasi"];

		$varCasteTxt		= $_POST["casteTxt"];
		$varSubcasteTxt		= $_POST["subcasteTxt"];
		$varMotherTongTxt	= $_POST["motherTongueTxt"];
		$varGothramTxt		= $_POST["gothramTxt"];
				
		if($varMaritalStatus != '')
		$varMaritalStatus	= $this->getPostVal($varMaritalStatus);
		
		if($varReligion != '')
		$varReligion		= $this->getPostVal($varReligion);

		if($varDenomination != '')
		$varDenomination	= $this->getPostVal($varDenomination);

		if($varEating != '')
		$varEating	= $this->getPostVal($varEating);

		if($varDrinking != '')
		$varDrinking	= $this->getPostVal($varDrinking);

		if($varSmoking != '')
		$varSmoking	= $this->getPostVal($varSmoking);
		
		if($varCaste != '' && $varCasteTxt=='')
		$varCaste			= $this->getPostVal($varCaste);
		else if($varCaste != '' && $varCasteTxt=='yes')
		$varCaste			= addslashes(trim($varCaste));
		
		if($varSubcaste!= '' && $varSubcasteTxt=='')
		$varSubcaste		= $this->getPostVal($varSubcaste);
		else if($varSubcaste != '' && $varSubcasteTxt=='yes')
		$varSubcaste		= addslashes(trim($varSubcaste));

		if($varMotherTongue != '' && $varMotherTongTxt=='')
		$varMotherTongue	= $this->getPostVal($varMotherTongue);
		else if($varMotherTongue != '' && $varMotherTongTxt=='yes')
		$varMotherTongue	= addslashes(trim($varMotherTongue));

		if($varGothram!= '' && $varGothramTxt=='')
		$varGothram			= $this->getPostVal($varGothram);
		else if($varGothram != '' && $varGothramTxt=='yes')
		$varGothram			= addslashes(trim($varGothram));

		if($varOccupationCat!= '')
		$varOccupationCat	= $this->getPostVal($varOccupationCat);

		if($varEducation != '')
		$varEducation		= $this->getPostVal($varEducation);
		
		if($varOccupation != '')
		$varOccupation		= $this->getPostVal($varOccupation);

		

		if($varResidingState != '')
		$varResidingState	= $this->getPostVal($varResidingState);

		if($varResidingCity != '')
		$varResidingCity	= $this->getPostVal($varResidingCity);

		if($varResidentStatus != '')
		$varResidentStatus	= $this->getPostVal($varResidentStatus);
		
		if($varCitizenship != '')
		$varCitizenship		= $this->getPostVal($varCitizenship);
		
		if($varCountry != '')
		$varCountry			= $this->getPostVal($varCountry);

		

		if($varStar != '')
		$varStar			= $this->getPostVal($varStar);

		if($varRaasi != '')
		$varRaasi			= $this->getPostVal($varRaasi);

		
		//Query Formation
		$varPOSTcont = '';
		if($varGender!='') {$varPOSTcont .= 'gender='.$varGender.'#^#'; }
		if($varAgeFrom!=''){$varPOSTcont .= 'ageFrom='.$varAgeFrom.'#^#'; }
		if($varAgeTo!=''){$varPOSTcont .= 'ageTo='.$varAgeTo.'#^#'; }
		if($varHeightFrom!=''){$varPOSTcont .= 'heightFrom='.$varHeightFrom.'#^#'; }
		if($varHeightTo!=''){ $varPOSTcont .= 'heightTo='.$varHeightTo.'#^#'; }
		if($varPhysicalStatus!=2 && $varPhysicalStatus!=''){ $varPOSTcont .= 'physicalStatus='.$varPhysicalStatus.'#^#';}
		if($varManglik!='' && $varManglik!=0){ $varPOSTcont .= 'manglik='.$varManglik.'#^#'; }
		if($varAnnualIncome!='' && $varAnnualIncome>0 && $varAnnualIncome1>$varAnnualIncome){ 
			$varPOSTcont .= 'annualIncome='.$varAnnualIncome.'#^#'; 
			$varPOSTcont .= 'annualIncome1='.$varAnnualIncome1.'#^#'; 
		}

		//For Habits
		if($varEating!=''){$varPOSTcont.= 'eating='.$varEating.'#^#';}
		if($varSmoking!=''){$varPOSTcont.= 'smoking='.$varSmoking.'#^#';}
		if($varDrinking!=''){$varPOSTcont.= 'drinking='.$varDrinking.'#^#';}

		if($varMaritalStatus!=''){	$varPOSTcont.= 'maritalStatus='.$varMaritalStatus.'#^#';}
		if(is_numeric($varHaveChildren)){$varPOSTcont.= 'haveChildren='.$varHaveChildren.'#^#';}
		if($varReligion!=''){$varPOSTcont.= 'religion='.$varReligion.'#^#'; }
		if($varDenomination!=''){$varPOSTcont.= 'denomination='.$varDenomination.'#^#'; }
		if($varCaste!=''){$varPOSTcont.= 'caste='.$varCaste.'#^#';}
		if($varSubcaste!=''){$varPOSTcont.= 'subcaste='.$varSubcaste.'#^#';}		
		if($varOccupationCat!=''){$varPOSTcont.= 'occupationCat='.$varOccupationCat.'#^#';}
		if($varEducation!=''){$varPOSTcont.= 'education='.$varEducation.'#^#';}
		if($varOccupation!=''){	$varPOSTcont.= 'occupation='.$varOccupation.'#^#';}
		if($varMotherTongue!=''){$varPOSTcont.= 'motherTongue='.$varMotherTongue.'#^#';}
		if($varCountry!=''){$varPOSTcont.= 'country='.$varCountry.'#^#';}
		if($varResidingState!=''){$varPOSTcont.='residingState='.$varResidingState.'#^#';}
		if($varResidingCity!=''){$varPOSTcont.= 'residingCity='.$varResidingCity.'#^#';}
		if($varCitizenship!=''){$varPOSTcont.= 'citizenship='.$varCitizenship.'#^#';}
		if($varResidentStatus!=''){$varPOSTcont.= 'residentStatus='.$varResidentStatus.'#^#';}
		if($varStar!=''){$varPOSTcont.= 'star='.$varStar.'#^#';}
		if($varRaasi!=''){$varPOSTcont.= 'raasi='.$varRaasi.'#^#';}
		if($varGothram!=''){ $varPOSTcont.= 'gothram='.$varGothram.'#^#';}

		//Extra options
		if($varPhotoOpt==1){$varPOSTcont.= 'photoOpt=1#^#';}
		if($varHoroscopeOpt==1){$varPOSTcont.= 'horoscopeOpt=1#^#';}
		if($varViewedOpt==1){$varPOSTcont.= 'alreadyViewedOpt=1#^#';}
		if($varContactOpt==1){$varPOSTcont.= 'alreadyContOpt=1#^#';}
		if($varShortListOpt==1){$varPOSTcont.= 'shortlistOpt=1#^#';}

		return $varPOSTcont;
	}

	function putSaveSrchData()
	{
		global $sessMatriId,$sessGender,$sessPaidStatus,$varTable,$varSrchName,$_COOKIE;
		$funSrchName = addslashes(trim($_POST['searchName']));
		extract($_POST);
		$funTblName	= $varTable['SEARCHSAVEDINFO'];
		$varSaveGo	= 0;

		if($saveSrch=='yes' && is_numeric($srchId)){ 
			$funCondition	= " WHERE MatriId=".$this->doEscapeString($sessMatriId,$this)." AND Search_Id=".$this->doEscapeString($srchId,$this)." AND Search_Type=".$this->doEscapeString($srchType,$this);
			$varSrchCnt		= $this->numOfRecords($funTblName,'Search_Id', $funCondition);
			$varSaveGo		= $varSrchCnt;
		}else{ 
			$funCondition	= " WHERE MatriId=".$this->doEscapeString($sessMatriId,$this)." AND Search_Name=".$this->doEscapeString($funSrchName,$this);
			$varSrchCnt		= $this->numOfRecords($funTblName,'Search_Id', $funCondition);
			$varSrchNameExists	= ($varSrchCnt == 0) ? 'no' : 'yes';
			if($varSrchNameExists == 'no') {
				if($sessPaidStatus==0){
					$varSrchCntExceed	= 'yes';
					$funCondition	= " WHERE MatriId=".$this->doEscapeString($sessMatriId,$this);
					$varSrchCnt		= $this->numOfRecords($funTblName,'MatriId', $funCondition);
					if($varSrchCnt<3){
						$varSrchCntExceed	= 'no';
						$varSaveGo			= 1;
					}
				}else{ $varSaveGo = 1;}
			}
		}

		if($varSaveGo ==1){
			$gender			= ($sessGender == 1) ? 2 : 1;
			$motherTongue	= is_array($motherTongue) ? implode('~',$motherTongue) : addslashes($motherTongue);
			$residingState	= is_array($residingState) ? implode('~',$residingState) : $residingState;
			$residingCity	= is_array($residingCity) ? implode('~',$residingCity) : $residingCity;
			$varPatternMatch	= '/[0-9]+#/';
			$residingCity		= preg_replace($varPatternMatch, '', $residingCity);
			$education		= is_array($education) ? implode('~',$education) : $education;
			$occupation		= is_array($occupation) ? implode('~',$occupation) : $occupation;
			$maritalStatus	= is_array($maritalStatus) ? implode('~',$maritalStatus) : $maritalStatus;
			$caste			= is_array($caste) ? implode('~',$caste) : addslashes($caste);
			$subcaste		= is_array($subcaste) ? implode('~',$subcaste) : addslashes($subcaste);
			$citizenship	= is_array($citizenship) ? implode('~',$citizenship) : $citizenship;
			$country		= is_array($country) ? implode('~',$country) : $country;
			$eating			= is_array($eating) ? implode('~',$eating) : $eating;
			$drinking		= is_array($drinking) ? implode('~',$drinking) : $drinking;
			$smoking		= is_array($smoking) ? implode('~',$smoking) : $smoking;
			$residingState	= is_array($residingState) ? implode('~',$residingState) : $residingState;
			$star			= is_array($star) ? implode('~',$star) : $star;
			$raasi			= is_array($raasi) ? implode('~',$raasi) : $raasi;
			$denomination	= is_array($denomination) ? implode('~',$denomination) : $denomination;
			$manglik		= ($manglik=='') ? 0 : $manglik;
			$htype_search	= ($htype_search=='') ? 0 : $htype_search;
			$alreadyContOpt = ($alreadyContOpt=='') ? 0 : $alreadyContOpt;
			$alreadyViewedOpt = ($alreadyViewedOpt=='') ? 0 : $alreadyViewedOpt;
			if(is_array($gothram)){
				$gothram	= in_array(99,$gothram) ? 99 : implode('~',$gothram);
			}else{
				$gothram	= addslashes($gothram);
			}
			
			$funPostedAft	= '0000-00-00 00:00:00';
			if(checkdate($postedMonth, $postedDay, $postedYear)){
				$funPostedAft	= $postedYear.'-'.$postedMonth.'-'.$postedDay.' 00:00:00';
			}
			
			if(($annualIncome!=0.49 && $annualIncome!=0 && $annualIncome!=101) && ($annualIncome1>$annualIncome)){
				$annualIncome = $annualIncome.'~'.$annualIncome1;
			}else{
				$annualIncome = '';
			}
			$funPhotoOpt	= $photoOpt==1 ? 1 : 0;
			$funHoroOpt	    = $horoscopeOpt==1 ? 1 : 0;
			$funPhotoHoro	= $funPhotoOpt.'~'.$funHoroOpt;
			$funIgnorCnct	= $alreadyContOpt.'~'.$alreadyViewedOpt;

			$funFields		= array('MatriId','Search_Name','Gender','Marital_Status','Children','Age_From','Age_To','Height_From','Height_To','Physical_Status','Mother_Tongue','Religion','Caste_Or_Division','Subcaste','Gothram','Eating_Habits','Drinking','Smoking','Education','Occupation_Category','Occupation','Citizenship','Country','Residing_District','Resident_Status','Posted_After','Search_By','Show_Photo_Horoscope','Show_Ignore_AlreadyContact','Search_Type','Days','Date_Updated','Residing_State','Chevvai_Dosham', 'Annual_Income','Star','Raasi','Denomination','Ashtakoota_Dashakoota');
			$funFieldVals	= array("'".$sessMatriId."'","'".$funSrchName."'",$gender,"'".$maritalStatus."'","'".$haveChildren."'",$ageFrom,$ageTo,"'".$heightFrom."'","'".$heightTo."'","'".$physicalStatus."'","'".$motherTongue."'","'".$religion."'","'".$caste."'","'".$subcaste."'","'".$gothram."'","'".$eating."'","'".$drinking."'","'".$smoking."'","'".$education."'","'".$occupationCat."'","'".$occupation."'","'".$citizenship."'","'".$country."'","'".$residingCity."'","'".$residentStatus."'","'".$funPostedAft."'","'".$searchBy."'","'".$funPhotoHoro."'","'".$funIgnorCnct."'","'".$srchType."'","'".$days."'","'".date('Y-m-d H:i:s')."'", "'".$residingState."'",$manglik,"'".$annualIncome."'","'".$star."'","'".$raasi."'","'".$denomination."'","'".$htype_search."'");

			if($saveSrch=='yes' && is_numeric($srchId)) { 

				$funCond	= " MatriId=".$this->doEscapeString($sessMatriId,$this)." AND Search_Id=".$this->doEscapeString($srchId,$this)." AND Search_Type=".$this->doEscapeString($srchType,$this);
				$varAffectedRows = $this->update($funTblName, $funFields, $funFieldVals,$funCond);
				if($varAffectedRows > 0){ $this->clsNewSavedSrchId = $srchId;}
			}else {
				$this->clsNewSavedSrchId = $this->insert($funTblName, $funFields, $funFieldVals);
			}
			return $this->regSearch();
		}else{
			$this->clsSearchErr = 1;
			if($varSrchNameExists == 'yes'){$varRetMsg = 'This search name already exists.';}
			else if($varSrchCntExceed == 'yes'){$varRetMsg = 'You have reached the maximum number of count.';}
			else{$varRetMsg = 'given saved search is not found.';$this->clsSearchErr = 2;}
			return $varRetMsg;
		}
	}

	function saveSearch($argSrchId) 
	{
		global $sessMatriId, $varWhereClause, $varTable, $arrCityStateMapping;
		$funTblName	= $varTable['SEARCHSAVEDINFO'];
		$funFields			= array('MatriId','Search_Name','Gender','Marital_Status','Children','Age_From','Age_To','Height_From','Height_To','Physical_Status','Mother_Tongue','Religion','Caste_Or_Division','Subcaste','Gothram','Eating_Habits','Drinking','Smoking','Education','Occupation_Category','Occupation','Citizenship','Country','Residing_District','Resident_Status','Posted_After','Search_By','Show_Photo_Horoscope','Show_Ignore_AlreadyContact','Display_Format','Search_Type','Days','Date_Updated','Residing_State','Residing_State','Chevvai_Dosham', 'Annual_Income','Star','Raasi','Denomination','Ashtakoota_Dashakoota');
		$funCondition	= " WHERE MatriId=".$this->doEscapeString($sessMatriId,$this)." AND Search_Id=".$this->doEscapeString($argSrchId,$this);
		
		$funSrchInfo	= $this->select($funTblName,$funFields,$funCondition,1);
		
		$funSrchType	= $funSrchInfo[0]['Search_Type'];
			
		if($funSrchInfo[0]['Posted_After'] != '0000-00-00 00:00:00' && $funSrchInfo[0]['Posted_After'] != ''){
			$_POST["days"]	= 'P';
			$varPADateTime		= split(' ', $funSrchInfo[0]['Posted_After']);
			$arrPADate			= split('-', $varPADateTime[0]);
			$_POST["postedMonth"]	= $arrPADate[1];
			$_POST["postedDay"]		= $arrPADate[2];
			$_POST["postedYear"]		= $arrPADate[0];
		}
		
		if($funSrchInfo[0]['Annual_Income'] != ''){
			$arrAnnualIncome	= split('~', $funSrchInfo[0]['Annual_Income']);
			$_POST["annualIncome"]	= $arrAnnualIncome[0];
			$_POST["annualIncome1"]	= $arrAnnualIncome[1];
		}

		$funPhotoHoro	= explode("~",$funSrchInfo[0]['Show_Photo_Horoscope']);
		$funArrDontOpt	= explode("~",$funSrchInfo[0]['Show_Ignore_AlreadyContact']);
		
		if(preg_match("/[a-zA-Z][a-zA-Z0-9\\s]+/", trim($funSrchInfo[0]['Caste_Or_Division'])))
			$_POST["casteTxt"]	= 'yes';
		if(preg_match("/[a-zA-Z][a-zA-Z0-9\\s]+/", trim($funSrchInfo[0]['Subcaste'])))
			$_POST["subcasteTxt"]= 'yes';
		if(preg_match("/[a-zA-Z][a-zA-Z0-9\\s]+/", trim($funSrchInfo[0]['Gothram'])))
			$_POST["gothramTxt"]	= 'yes';

		$_POST["gender"]			= $funSrchInfo[0]["Gender"];
		$_POST["ageFrom"]		= $funSrchInfo[0]["Age_From"];	
		$_POST["ageTo"]			= $funSrchInfo[0]["Age_To"];
		$_POST["heightFrom"]		= $funSrchInfo[0]["Height_From"];	
		$_POST["heightTo"]		= $funSrchInfo[0]["Height_To"];
		$_POST["haveChildren"]	= $funSrchInfo[0]["Children"];
		$_POST["physicalStatus"]	= $funSrchInfo[0]['Physical_Status'];
		$_POST["manglik"]		= $funSrchInfo[0]['Chevvai_Dosham'];
		$_POST["eating"]			= $funSrchInfo[0]['Eating_Habits'];
		$_POST["drinking"]		= $funSrchInfo[0]['Drinking'];
		$_POST["smoking"]		= $funSrchInfo[0]['Smoking'];
		$_POST["photoOpt"]		= $funPhotoHoro[0];
		$_POST["horoscopeOpt"]	= $funPhotoHoro[1];
		$_POST["alreadyContOpt"] = $funArrDontOpt[0];
		$_POST["alreadyViewedOpt"]= $funArrDontOpt[1];
		$_POST["searchBy"]		= $funSrchInfo[0]['Search_By'];
		$_POST["maritalStatus"]	= $funSrchInfo[0]['Marital_Status'];
		$_POST["religion"]		= $funSrchInfo[0]['Religion'];
		$_POST["denomination"]	= $funSrchInfo[0]['Denomination'];
		$_POST["caste"]			= $funSrchInfo[0]['Caste_Or_Division'];
		$_POST["subcaste"]		= $funSrchInfo[0]['Subcaste'];
		$_POST["gothram"]		= $funSrchInfo[0]['Gothram'];
		$_POST["occupationCat"]	= $funSrchInfo[0]['Occupation_Category'];
		$_POST["education"]		= $funSrchInfo[0]['Education'];
		$_POST["occupation"]		= $funSrchInfo[0]['Occupation'];
		$_POST["motherTongue"]	= $funSrchInfo[0]['Mother_Tongue'];
		$_POST["residingState"]	= $funSrchInfo[0]['Residing_State'];
		$funResidingDistrict		= $funSrchInfo[0]['Residing_District'];
		$funCities = array();
		if ($funResidingDistrict !=""){
			$varSplitCity	= split('~',$funResidingDistrict);
			foreach($varSplitCity as $varKey => $varValue){
				$funCities[]	= $arrCityStateMapping[$varValue].'#'.$varValue;
			}//foreach
		}//if
		$_POST["residingCity"]	= join('~', $funCities);
		$_POST["residentStatus"] = $funSrchInfo[0]['Resident_Status'];
		$_POST["citizenship"]	= $funSrchInfo[0]['Citizenship'];
		$_POST["country"]		= $funSrchInfo[0]['Country'];
		$_POST["star"]			= $funSrchInfo[0]['Star'];
		$_POST["raasi"]			= $funSrchInfo[0]['Raasi'];
		$_POST["htype_search"]	= $funSrchInfo[0]['Ashtakoota_Dashakoota'];


		if($funArrDontOpt[0] == 1){
			$this->clsContactIds = 1;
		}

		if($funArrDontOpt[1] == 1){
			$this->clsViewedIds = 1;
		}

		return $this->regSearch();
	}
}
?>