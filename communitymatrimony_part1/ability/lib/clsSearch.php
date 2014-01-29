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
	public $clsSearchErr	= 0;
	public $clsNewSavedSrchId= '';
	function formDefaultValues(){
		global $frm;
		if(trim($_REQUEST['randId'])=='') { $_REQUEST['randId'] = rand(1000000,9999999); }
		if($_REQUEST['ageFrom']==''|| $_REQUEST['ageTo']=='') { 
			if($_REQUEST['gender'] == 1){ $_REQUEST['ageFrom']= 21;$_REQUEST['ageTo']= 40;}
			else{ $_REQUEST['ageFrom']= 18;$_REQUEST['ageTo']= 40;}
		}
		if($_REQUEST['heightFrom']=="") { $_REQUEST['heightFrom']= '121.92'; }
		if($_REQUEST['heightTo']=="") { $_REQUEST['heightTo']='241.3'; }
	}
	
	function getStringValues($argCurrVal, $argSourceArray, $argString){
		$funRetVal = '';
		$varVal = '0';
		
		if(is_array($argCurrVal) && count($argCurrVal)>0){
			
			foreach($argCurrVal as $funVal){
				$funRetVal .= ($funVal==0 && $argSourceArray[0]=='') ? 'Any, ' : $argSourceArray[$funVal].', ';
			}
			$funRetVal = rtrim($funRetVal,', ');
			$varVal = 1;
		}else if($argCurrVal > 0){
			$funRetVal = $argSourceArray[$argCurrVal];
			$varVal = 1;
		}else if($argCurrVal == '0'){
			$varVal = 1;
			$funRetVal = 'Any';
		}
		$argString = ($varVal == '0') ? '' : $argString;
		return $argString.$funRetVal;
	}

	function refineSearch(){
		$funPrevValwc	= $_POST['wc'];
		$funPrevValcn	= $_POST['cn'];
		$funNewAgeFrom	= $_POST['ageFrom'];
		$funNewAgeTo	= $_POST['ageTo'];
		$funNewHtFrom	= $_POST['heightFrom'];
		$funNewHtTo		= $_POST['heightTo'];
		$funNewEdu		= $_POST['education'];
		$funNewOccu		= $_POST['occupation'];
		$funNewCountry	= $_POST['country'];
		$funNewMTongue	= $_POST['motherTongue'];
		$funNewStar		= $_POST['star'];
		$funNewSubcaste	= $_POST['subcaste'];
		$funNewDivision	= $_POST['caste'];
		$funNewDenomination	= $_POST['denominatoin'];


		
		$arrPrevValwc	= split('OB@', $funPrevValwc);

		$funVal = preg_replace("/@\^ >\^~\^[0-9]{2}/", '@^ >^~^'.$funNewAgeFrom, $arrPrevValwc[0]);
		$funVal = preg_replace("/@\^ <\^~\^[0-9]{2}/", '@^ <^~^'.$funNewAgeTo, $funVal);
		
		if(preg_match("/!\^ >\^~\^[0-9]{3}\.[0-9]{2}/",$funVal)){
			$funVal = preg_replace("/!\^ >\^~\^[0-9]{3}\.[0-9]{2}/", '!^ >^~^'.$funNewHtFrom, $funVal);
			$funVal = preg_replace("/!\^ <\^~\^[0-9]{3}\.[0-9]{2}/", '!^ <^~^'.$funNewHtTo, $funVal);
		}else if($funNewHtFrom>0 && $funNewHtTo>0){
			$funVal .= '$!^ >^~^'.$funNewHtFrom.'$!^ <^~^'.$funNewHtTo;
		}

		
		if(preg_match("/SID\^ I@\([0-9,]+\)/",$funVal)){
			$varPattern = "/SID\^ I@\([0-9,]+\)/";
			$varRplVal	= 'SID^ ^~^'.$funNewSubcaste;
			if($funNewSubcaste == 0){
				$varPattern = "/[\$]?SID\^ I@\([0-9,]+\)/";
				$varRplVal	= '';
			}
			$funVal		= preg_replace($varPattern, $varRplVal, $funVal);
		}else if(preg_match("/SID\^ \^~\^[0-9]+/",$funVal)){
			if($funNewSubcaste == 0){
				$funVal		= preg_replace("/[\$]?SID\^ \^~\^[0-9]+/", '', $funVal);
			}else{
				$funVal		= preg_replace("/SID\^ \^~\^[0-9]+/", 'SID^ ^~^'.$funNewSubcaste, $funVal);
			}
		}else if($funNewSubcaste>0){
			$funVal .= '$SID^ ^~^'.$funNewSubcaste;
		}

		if(preg_match("/EC\^ I@\([0-9,]+\)/",$funVal)){
			$varPattern = "/EC\^ I@\([0-9,]+\)/";
			$varRplVal	= 'EC^ ^~^'.$funNewEdu;
			if($funNewEdu == 0){
				$varPattern = "/[\$]?EC\^ I@\([0-9,]+\)/";
				$varRplVal	= '';
			}
			$funVal		= preg_replace($varPattern, $varRplVal, $funVal);
		}else if(preg_match("/EC\^ \^~\^[0-9]+/",$funVal)){
			if($funNewEdu == 0){
				$funVal		= preg_replace("/[\$]?EC\^ \^~\^[0-9]+/", '', $funVal);
			}else{
				$funVal		= preg_replace("/EC\^ \^~\^[0-9]+/", 'EC^ ^~^'.$funNewEdu, $funVal);
			}
		}else if($funNewEdu > 0){
			$funVal .= '$EC^ ^~^'.$funNewEdu;
		}
		
		if(preg_match("/OC\^ I@\([0-9,]+\)/",$funVal)){
			$varPattern = "/OC\^ I@\([0-9,]+\)/";
			$varRplVal	= 'OC^ ^~^'.$funNewOccu;
			if($funNewOccu == 0){
				$varPattern = "/[\$]?OC\^ I@\([0-9,]+\)/";
				$varRplVal	= '';
			}
			$funVal		= preg_replace($varPattern, $varRplVal, $funVal);
		}else if(preg_match("/OC\^ \^~\^[0-9]+/",$funVal)){
			if($funNewOccu == 0){
				$funVal		= preg_replace("/[\$]?OC\^ \^~\^[0-9]+/", '', $funVal);
			}else{
				$funVal		= preg_replace("/OC\^ \^~\^[0-9]+/", 'OC^ ^~^'.$funNewOccu, $funVal);
			}
		}else if($funNewOccu > 0){
			$funVal .= '$OC^ ^~^'.$funNewOccu;
		}

		if(preg_match("/MT\^ I@\([0-9,]+\)/",$funVal)){
			$varPattern = "/MT\^ I@\([0-9,]+\)/";
			$varRplVal	= 'MT^ ^~^'.$funNewMTongue;
			if($funNewMTongue == 0){
				$varPattern = "/[\$]?MT\^ I@\([0-9,]+\)/";
				$varRplVal	= '';
			}
			$funVal		= preg_replace($varPattern, $varRplVal, $funVal);
		}else if(preg_match("/MT\^ \^~\^[0-9]+/",$funVal)){
			if($funNewMTongue == 0){
				$funVal		= preg_replace("/[\$]?MT\^ \^~\^[0-9]+/", '', $funVal);
			}else{
				$funVal		= preg_replace("/MT\^ \^~\^[0-9]+/", 'MT^ ^~^'.$funNewMTongue, $funVal);
			}
		}else if($funNewMTongue > 0){
			$funVal .= '$MT^ ^~^'.$funNewMTongue;
		}

		if(preg_match("/STR\^ I@\([0-9,]+\)/",$funVal)){
			$varPattern = "/STR\^ I@\([0-9,]+\)/";
			$varRplVal	= 'STR^ ^~^'.$funNewStar;
			if($funNewStar == 0){
				$varPattern = "/[\$]?STR\^ I@\([0-9,]+\)/";
				$varRplVal	= '';
			}
			$funVal		= preg_replace($varPattern, $varRplVal, $funVal);
		}else if(preg_match("/STR\^ \^~\^[0-9]+/",$funVal)){
			if($funNewStar == 0){
				$funVal		= preg_replace("/[\$]?STR\^ \^~\^[0-9]+/", '', $funVal);
			}else{
				$funVal		= preg_replace("/STR\^ \^~\^[0-9]+/", 'STR^ ^~^'.$funNewStar, $funVal);
			}
		}else if($funNewStar > 0){
			$funVal .= '$STR^ ^~^'.$funNewStar;
		}

		if(preg_match("/DE\^ I@\([0-9,]+\)/",$funVal)){
			$varPattern = "/DE\^ I@\([0-9,]+\)/";
			$varRplVal	= 'DE^ ^~^'.$funNewDenomination;
			if($funNewDenomination == 0){
				$varPattern = "/[\$]?DE\^ I@\([0-9,]+\)/";
				$varRplVal	= '';
			}
			$funVal		= preg_replace($varPattern, $varRplVal, $funVal);
		}else if(preg_match("/DE\^ \^~\^[0-9]+/",$funVal)){
			if($funNewDenomination == 0){
				$funVal		= preg_replace("/[\$]?DE\^ \^~\^[0-9]+/", '', $funVal);
			}else{
				$funVal		= preg_replace("/DE\^ \^~\^[0-9]+/", 'DE^ ^~^'.$funNewDenomination, $funVal);
			}
		}else if($funNewDenomination > 0){
			$funVal .= '$DE^ ^~^'.$funNewDenomination;
		}

		if(preg_match("/CAID\^ I@\([0-9,]+\)/",$funVal)){
			$varPattern = "/CAID\^ I@\([0-9,]+\)/";
			$varRplVal	= 'CAID^ ^~^'.$funNewDivision;
			if($funNewDivision == 0){
				$varPattern = "/[\$]?CAID\^ I@\([0-9,]+\)/";
				$varRplVal	= '';
			}
			$funVal		= preg_replace($varPattern, $varRplVal, $funVal);
		}else if(preg_match("/CAID\^ \^~\^[0-9]+/",$funVal)){
			if($funNewDivision == 0){
				$funVal		= preg_replace("/[\$]?CAID\^ \^~\^[0-9]+/", '', $funVal);
			}else{
				$funVal		= preg_replace("/CAID\^ \^~\^[0-9]+/", 'CAID^ ^~^'.$funNewDivision, $funVal);
			}
		}else if($funNewDivision > 0){
			$funVal .= '$CAID^ ^~^'.$funNewDivision;
		}


		
		
		if($funNewCountry >= 0){
			
			//INDIA COUNTRY WITH STATE || STATE & CITY
			if(preg_match("/\(CO\^\^~\^98[\$]RST\^ I@\([0-9,]+\)\)/", $funVal)){
				$funVal = preg_replace("/\(CO\^\^~\^98[\$]RST\^ I@\([0-9,]+\)\)/", '', $funVal);
			}else if(preg_match("/\(CO\^\^~\^98[\$]RST\^ I@\([0-9,]+\)[\$]RD\^ I@\([0-9,]+\)\)/", $funVal)){
				$funVal = preg_replace("/\(CO\^\^~\^98[\$]RST\^ I@\([0-9,]+\)[\$]RD\^ I@\([0-9,]+\)\)/", '', $funVal);
			}

			//USA WITH STATE
			if(preg_match("/#?\(CO\^\^~\^222[\$]RST\^ I@\([0-9,]+\)\)/", $funVal)){
				$funVal = preg_replace("/#?\(CO\^\^~\^222[\$]RST\^ I@\([0-9,]+\)\)/", '', $funVal);
			}
			
			//OTHER COUNTRY
			if(preg_match("/#CO\^ I@\([0-9,]+\)/", $funVal)){
				$funVal = preg_replace("/#?\CO\^ I@\([0-9,]+\)/", '', $funVal);
			}

			//ONLY COUNTRYS CONDITION
			if(preg_match("/[\$]?CO\^ I@\([0-9,]+\)/", $funVal)){
				$funVal = preg_replace("/[\$]?CO\^ I@\([0-9,]+\)/", '', $funVal);
			}
						
			//COUNTRY WITH EQUAL OPERATOR
			if(preg_match("/[\$]?CO\^ \^~\^[0-9]+/",$funVal)){
				$funVal	= preg_replace("/[\$]?CO\^ \^~\^[0-9]+/", '', $funVal);
			}
			//CLEAR UNWANTED BRACKETS
			if(preg_match("/[\$]\(\s*\)/", $funVal)){
				$funVal = preg_replace("/[\$]\(\s*\)/", '', $funVal);
			}
			
			
			if($funNewCountry>0){ $funVal .= '$CO^ ^~^'.$funNewCountry;}

		}

		return $funVal.'OB@'.$arrPrevValwc[1];
	}


	function getQueryVal($argArray){
		if(is_array($argArray))
			return $argArray;
		else
			return split('~', trim($argArray,'~'));
	}

	function getOpionalValues($argSavedSrchVal, $argSourceArray){
		$funArrSrchVal = split('~', $argSavedSrchVal);
		foreach($funArrSrchVal as $funSinVal){
			if(array_key_exists($funSinVal, $argSourceArray)){
			echo '<option value="'.$funSinVal.'">'.$argSourceArray[$funSinVal].'</option>';
			}
		}
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
			}else if($arglabelval == 'state' && $funRetVal=='' && substr($funSinVal,0,2)==98){
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

	function viewSimilarProfile($argOppId) {
		global $sessMatriId,$varTable,$varWhereClause;
		
		$varFields		= array('Gender','Age','Height','Religion','CommunityId','SubcasteId','Country','Mother_Tongue');
		$varCond		= " WHERE MatriId=".$this->doEscapeString($argOppId,$this);
		$varMemInfo		= $this->select($varTable['MEMBERINFO'],$varFields,$varCond,1);
		
		if(count($varMemInfo) > 0){
		$varGender		= $varMemInfo[0]['Gender'];
		$varAge			= $varMemInfo[0]['Age'];
		$varHeight		= $varMemInfo[0]['Height'];
		$varReligion	= $varMemInfo[0]['Religion'];
		$varDivision	= $varMemInfo[0]['CommunityId'];
		$varCaste		= $varMemInfo[0]['SubcasteId'];
		$varCountry		= $varMemInfo[0]['Country'];
		$varMotherTon	= $varMemInfo[0]['Mother_Tongue'];
		$varQuery		= 'WHERE '.$varWhereClause;
		$varQuery	   .= " AND  MatriId <> '".$argOppId."' AND Publish=1";
		if($sessMatriId!="") { $varQuery .= "  AND MatriId<>'".$sessMatriId."'"; }
		if($varGender!='' && $varGender!=0) { $varQuery .= "  AND Gender=".$varGender; }
		$varStAge			= $varMemInfo[0]['Age']-3;
		$varEndAge		= $varMemInfo[0]['Age']+3;
		if($varStAge!='' && $varEndAge!='') { $varQuery .= " AND Age >= ".$varStAge." AND Age <= ".$varEndAge; }
		$varStHt			= $varMemInfo[0]['Height']-3;
		$varEndHt		= $varMemInfo[0]['Height']+3;
		if($varStHt!='' && $varEndHt!='') { $varQuery .= " AND Height >= ".$varStHt." AND Height <= ".$varEndHt; }
		if($varReligion!='' && $varReligion!=0) { $varQuery .= "  AND Religion=".$varReligion; }
		if($varDivision!='' && $varDivision!=0) { $varQuery .= "  AND CommunityId=".$varDivision; }
		if($varCaste!='' && $varCaste!=0) { $varQuery .= "  AND SubcasteId=".$varCaste; }
		if($varCountry!='' && $varCountry!=0) { $varQuery .= "  AND Country=".$varCountry; }
		if($varMotherTon!='' && $varMotherTon!=0) { $varQuery .= "  AND Mother_Tongue=".$varMotherTon; }
		}else{
		$this->formDefaultValues();
		$this->regSearch();
		}
		$varQuery			.= " ORDER BY Last_Login DESC";
		//echo $varQuery	;
		return $varQuery;
	}

	function regSearch()
	{
		global $sessMatriId,$sessGender,$varWhereClause;

		if($sessMatriId!='')
			$varGender	= $sessGender==2 ? 1 : 2;
		else
			$varGender	= $_REQUEST["gender"]!='' ? $_REQUEST["gender"] : 2;
				
		$varAgeFrom			= trim($_REQUEST["ageFrom"]);	
		$varAgeTo			= trim($_REQUEST["ageTo"]);
		if($varGender==1){ 
			$varAgeFrom	= ($varAgeFrom<21 || $varAgeFrom>70) ? 21 : $varAgeFrom;
			$varAgeTo	= ($varAgeTo<21 || $varAgeTo>70)? 33 : $varAgeTo;
		}else{
			$varAgeFrom	= ($varAgeFrom<18 || $varAgeFrom>70) ? 18 : $varAgeFrom;
			$varAgeTo	= ($varAgeTo<18 || $varAgeTo>70)? 30 : $varAgeTo;
		}
		
		$varHeightFrom		= ($_REQUEST['heightFrom']=="")?'121.92':$_REQUEST["heightFrom"];	
		$varHeightTo		= ($_REQUEST['heightTo']=="")?'241.3':$_REQUEST["heightTo"];
		$varHaveChildren	= $_REQUEST["haveChildren"];
		$varAllDays			= $_REQUEST["days"];
		$varPostedMonth		= $_REQUEST["postedMonth"];
		$varPostedDay		= $_REQUEST["postedDay"];
		$varPostedYear		= $_REQUEST["postedYear"];
		$varPhysicalStatus	= $_REQUEST["physicalStatus"];
		$varAnnualIncome	= $_REQUEST["annualIncome"];
		$varAnnualIncome1	= $_REQUEST["annualIncome1"];
		$varManglik			= $_REQUEST["manglik"];
		$varEatinghabits	= $_REQUEST["eating"];
		$varDrinking		= $_REQUEST["drinking"];
		$varSmoking			= $_REQUEST["smoking"];
		$varPhotoOpt		= $_REQUEST["photoOpt"];
		$varHoroscopeOpt	= $_REQUEST["horoscopeOpt"];
		$varSearchBy		= $_REQUEST["searchBy"];
		$varSearchName		= trim($_REQUEST["searchName"]);
		$varIgnoreOpt		= $_REQUEST["ignoreOpt"];
		$varContactOpt		= $_REQUEST["contactOpt"];
		$varMaritalStatus	= $_REQUEST["maritalStatus"];
		$varReligion		= $_REQUEST["religion"];	
		$varDenomination	= $_REQUEST["denomination"];
		$varCaste			= $_REQUEST["caste"];
		$varSubcaste		= $_REQUEST["subcaste"];
		$varOccupationCat	= $_REQUEST["occupationCat"];
		$varEducation		= $_REQUEST["education"];
		$varOccupation		= $_REQUEST["occupation"];
		$varMotherTongue	= $_REQUEST["motherTongue"];
		$varResidingState	= $_REQUEST["residingState"];
		$varResidingCity	= $_REQUEST["residingCity"];
		$varResidentStatus	= $_REQUEST["residentStatus"];
		$varCitizenship		= $_REQUEST["citizenship"];
		$varCountry			= $_REQUEST["country"];
		$varGothram			= $_REQUEST["gothram"];
		$varStar			= $_REQUEST["star"];
		$varRaasi			= $_REQUEST["raasi"];

		$varCasteTxt		= $_REQUEST["casteTxt"];
		$varSubcasteTxt		= $_REQUEST["subcasteTxt"];
		$varMotherTongTxt	= $_REQUEST["motherTongueTxt"];
		$varGothramTxt		= $_REQUEST["gothramTxt"];

		
		if($varMaritalStatus != '')
		$varMaritalStatus	= $this->getQueryVal($varMaritalStatus);
		else
		$varMaritalStatus	= array();
		
		if($varReligion != '')
		$varReligion		= $this->getQueryVal($varReligion);

		if($varDenomination != '')
		$varDenomination	= $this->getQueryVal($varDenomination);

		if($varEatinghabits != '')
		$varEatinghabits	= $this->getQueryVal($varEatinghabits);

		if($varDrinking != '')
		$varDrinking	= $this->getQueryVal($varDrinking);

		if($varSmoking != '')
		$varSmoking	= $this->getQueryVal($varSmoking);
		
		if($varCaste != '' && $varCasteTxt=='')
		$varCaste			= $this->getQueryVal($varCaste);
		else if($varCaste != '' && $varCasteTxt=='yes')
		$varCaste			= addslashes(trim($varCaste));
		
		if($varSubcaste!= '' && $varSubcasteTxt=='')
		$varSubcaste		= $this->getQueryVal($varSubcaste);
		else if($varSubcaste != '' && $varSubcasteTxt=='yes')
		$varSubcaste		= addslashes(trim($varSubcaste));

		if($varOccupationCat!= '')
		$varOccupationCat	= $this->getQueryVal($varOccupationCat);

		if($varEducation != '')
		$varEducation		= $this->getQueryVal($varEducation);
		
		if($varOccupation != '')
		$varOccupation		= $this->getQueryVal($varOccupation);

		if($varMotherTongue != '' && $varMotherTongTxt=='')
		$varMotherTongue	= $this->getQueryVal($varMotherTongue);
		else if($varMotherTongue != '' && $varMotherTongTxt=='yes')
		$varMotherTongue	= addslashes(trim($varMotherTongue));

		if($varResidingState != '')
		$varResidingState	= $this->getQueryVal($varResidingState);
		else
		$varResidingState	= array();

		if($varResidingCity != '')
		$varResidingCity	= $this->getQueryVal($varResidingCity);
		else
		$varResidingCity	= array();

		if($varResidentStatus != '')
		$varResidentStatus	= $this->getQueryVal($varResidentStatus);
		
		if($varCitizenship != '')
		$varCitizenship		= $this->getQueryVal($varCitizenship);
		
		if($varCountry != '')
		$varCountry			= $this->getQueryVal($varCountry);

		if($varGothram!= '' && $varGothramTxt=='')
		$varGothram			= $this->getQueryVal($varGothram);
		else if($varGothram != '' && $varGothramTxt=='yes')
		$varGothram			= addslashes(trim($varGothram));

		if($varStar != '')
		$varStar			= $this->getQueryVal($varStar);

		if($varRaasi != '')
		$varRaasi			= $this->getQueryVal($varRaasi);

		
		//Query Formation
		$varQuery	= 'WHERE '.$varWhereClause.' AND Publish=1';
		if($varGender!='') { $varQuery	.= ' AND Gender='.$varGender; }
		if($sessMatriId!="") { $varQuery .= " AND MatriId<>'".$sessMatriId."'"; }
		if($varAgeFrom!='') { $varQuery	.= ' AND Age >='.$varAgeFrom; }
		if($varAgeTo!='') { $varQuery	.= ' AND Age <='.$varAgeTo; }
		if($varHeightFrom!='') { $varQuery	.= ' AND Height >='.$varHeightFrom; }
		if($varHeightTo!='') { $varQuery	.= ' AND Height <='.$varHeightTo; }
		if($varPhysicalStatus!=2 && $varPhysicalStatus!='') { $varQuery	.= ' AND Physical_Status='.$varPhysicalStatus;}

		//For Manglik & Annual Income
		if($varManglik!='' && $varManglik!=0){ $varQuery .= ' AND Chevvai_Dosham='.$varManglik; }

		if($varAnnualIncome!='' && $varAnnualIncome>0 && $varAnnualIncome1>$varAnnualIncome){ 
			if($varAnnualIncome == 0.49){$varAnnualIncome = '< 50000';}
			else if($varAnnualIncome == 101){$varAnnualIncome = '>=10000000';}
			else{$varAnnualIncome = '>='.($varAnnualIncome*100000).' AND Temp_Annual_Income<='.($varAnnualIncome1*100000);}
			$varQuery	.= ' AND Temp_Annual_Income'.$varAnnualIncome; 
		}

		if($varPhotoOpt==1){ $varQuery	.= ' AND Photo_Set_Status = 1';}
		if($varHoroscopeOpt==1){$varQuery	.= ' AND Horoscope_Available IN(1, 3)';}

		//For Habits
		$varDrinkCnt = count($varDrinking);
		$varSmokeCnt = count($varSmoking);
		$varEatingCnt = count($varEatinghabits);
		if($varDrinkCnt>0) { 
			if($varDrinkCnt==1 && $varDrinking[0]!=0){
				$varQuery	.= ' AND Drink='.$varDrinking[0];
			}else if($varDrinkCnt>1 && !in_array("0", $varDrinking)){
				$varQuery	.= ' AND Drink IN('.join(",", $varDrinking).')';
			}
		}

		if($varSmokeCnt>0) { 
			if($varSmokeCnt==1 && $varSmoking[0]!=0){
				$varQuery	.= ' AND Smoke='.$varSmoking[0];
			}else if($varSmokeCnt>1 && !in_array("0", $varSmoking)){
				$varQuery	.= ' AND Smoke IN('.join(",", $varSmoking).')';
			}
		}
		
		if($varEatingCnt>0) { 
			if($varEatingCnt==1 && $varEatinghabits[0]!=0){
				$varQuery	.= ' AND Eating_Habits='.$varEatinghabits[0];
			}else if($varEatingCnt>1 && !in_array("0", $varEatinghabits)){
				$varQuery	.= ' AND Eating_Habits IN('.join(",", $varEatinghabits).')';
			}
		}

		//For MaritalStatus & Children living
		if($varMaritalStatus!='' && count($varMaritalStatus)>0 && !in_array(0, $varMaritalStatus) && ($varHaveChildren==0 || ($varHaveChildren>=1 && $varMaritalStatus[0]==1 && count($varMaritalStatus)==1))) 
		{
			if(count($varMaritalStatus) == 1){
				$varQuery	.= ' AND Marital_Status='.$varMaritalStatus[0];	
			}else{
				$varQuery	.= ' AND Marital_Status IN ('.join(',', $varMaritalStatus).')';	
			}
		}
		
		$varCloseBracket = '';
		$varAND4Chilren	 = ' AND ';
		if($varHaveChildren >= 1 && ((in_array(1, $varMaritalStatus) && count($varMaritalStatus)>1)||in_array(0, $varMaritalStatus))) 
		{ 
			$varQuery		.= ' AND (Marital_Status=1 OR ';
			$varCloseBracket = ')';
			$varAND4Chilren	 = '';
			if(in_array(0, $varMaritalStatus)){
				$varMaritalStatus = array(2,3,4,5);
			}else{
				unset($varMaritalStatus[array_search('1', $varMaritalStatus)]);
			}
		}
		
		if(in_array(2, $varMaritalStatus) || in_array(3, $varMaritalStatus) || in_array(4, $varMaritalStatus) || in_array(5, $varMaritalStatus))
		{
			if($varHaveChildren == 1) 
			{ 
				$varQuery	.= $varAND4Chilren.'(Marital_Status IN ('.join(',', $varMaritalStatus).') AND No_Of_Children=0)'.$varCloseBracket; 
			}else if($varHaveChildren >1){ 
				$varChHaveChildren = ($varHaveChildren-2);
				$varQuery	.= $varAND4Chilren.'(Marital_Status IN ('.join(',', $varMaritalStatus).') AND Children_Living_Status='.$varChHaveChildren.')'.$varCloseBracket; 
			}
		}
		
		if($varReligion!='' && !in_array(0,$varReligion)) {
			$varQuery  .= ' AND Religion IN ('.join(',', $varReligion).')'; 
		}

		if($varDenomination!='' && !in_array(0,$varDenomination)) {
			$varQuery  .= ' AND Denomination IN ('.join(',', $varDenomination).')'; 
		}

		if($varCaste!='' && $varCasteTxt=='' && !in_array(0,$varCaste)){
			$varQuery  .= ' AND CasteId IN ('.join(',', $varCaste).')';
		}else if($varCaste!='' && $varCasteTxt=='yes'){
			$varQuery  .= " AND CasteText LIKE '%".$varCaste."%'";
		}
		
		if($varSubcaste!='' && $varSubcasteTxt=='' && !in_array(0,$varSubcaste)){
			$varQuery  .= ' AND SubcasteId IN ('.join(',', $varSubcaste).')';
		}else if($varSubcaste!='' && $varSubcasteTxt=='yes'){
			$varQuery  .= " AND SubcasteText LIKE '%".$varSubcaste."%'";
		}		

		if($varOccupationCat!='' && !in_array(0,$varOccupationCat)) {
			$varQuery  .= ' AND Employed_In IN ('.join(',', $varOccupationCat).')';
		}

		if($varEducation!='' && !in_array(0,$varEducation)) {
			$varQuery  .= ' AND Education_Category IN ('.join(',', $varEducation).')';
		}

		if($varOccupation!='' && !in_array(0,$varOccupation)) {
			$varQuery  .= ' AND Occupation IN ('.join(',', $varOccupation).')';
		}
		
		if($varMotherTongue!='' && $varMotherTongTxt=='' && !in_array(0,$varMotherTongue)) {
			$varQuery  .= ' AND Mother_TongueId IN ('.join(',', $varMotherTongue).')';
		}else if($varMotherTongue!='' && $varMotherTongTxt=='yes'){
			$varQuery  .= " AND Mother_TongueText LIKE '%".$varMotherTongue."%'";
		}

		if($varCountry!='' && !in_array(0,$varCountry) && (count($varResidingState)==0 || in_array(0,$varResidingState))){
			$varQuery	  .= ' AND Country IN ('.join(',',$varCountry) .')';
		}
		
		if($varResidingState!='' && !in_array(0,$varResidingState) && count($varResidingState)>0) { 
			if($varResidingCity!='' && !in_array(0,$varResidingCity)) { $varResidingCityVal = implode(",",$varResidingCity);}
			$varStateCond = $this->getStateCond($varResidingState,$varCountry,$varResidingCityVal);
			$varQuery	 .= $varStateCond;
		}
		
		if($varCitizenship!='' && !in_array(0,$varCitizenship)){
			$varQuery	.= ' AND Citizenship IN ('.join(',', $varCitizenship).')';
		}

		if($varAllDays=='P'){
			$varDateCreated=$varPostedYear."-".$varPostedMonth."-".$varPostedDay.' 23:59:59';
			$varQuery	.= " AND Date_Created >= '".$varDateCreated."'";
		}
		
		if($varResidentStatus!='' && !in_array(0, $varResidentStatus)){ 
			$varQuery	.= ' AND Resident_Status IN('.join(',', $varResidentStatus).')';
		}
		
		if($varStar!='' && !in_array(0, $varStar)){
			$varQuery	.= ' AND Star IN('.join(',', $varStar).')';
		}
		
		if($varRaasi!='' && !in_array(0, $varRaasi)){
			$varQuery	.= ' AND Raasi IN('.join(',', $varRaasi).')';
		}

		if($varGothram!='' && $varGothramTxt=='' && !in_array(0, $varGothram)){
			$varQuery	.= ' AND GothramId IN('.join(',', $varGothram).')';
		}else if($varGothram!='' && $varGothramTxt=='yes'){
			$varQuery	.= " AND GothramText LIKE '%".$varGothram."%'";
		}

		/*if($sessMatriId!='') {
			if($varIgnoreOpt==1) { $varIgnoreIds = $this->getNotInProfiles('ignoreinfo'); if($varIgnoreIds!='') { $varQuery.= ' AND MatriId NOT IN ('.trim($varIgnoreIds,',').')';} }
			if($varContactOpt==1) { $varContactIds = $this->getNotInProfiles('memberactioninfo'); if($varContactIds!='') { $varQuery.= ' AND  MatriId NOT IN ('.trim($varContactIds,',').')';} }
		}*/
		
		if($varSearchBy==1){ $varSrchBy = 'Date_Created'; }else{ $varSrchBy = 'Last_Login';}
		$varQuery.= " ORDER BY ".$varSrchBy.' DESC';
		return $varQuery;
	}

	function getStateCond($argResidingState, $argCountry, $argCity)
	{
		$funIndiaStates = '';
		$funUSAStates	= '';
		foreach($argResidingState as $valStat)
		{
			if(preg_match("/^98/", $valStat)){
				$funIndiaStates .= preg_replace("/^98/",'',$valStat).',';
			}
			else if(preg_match("/^222/", $valStat)){
				$funUSAStates .= preg_replace("/^222/",'',$valStat).',';
			}
		}

		$funIndiaStates = trim($funIndiaStates,',');
		$funUSAStates	= trim($funUSAStates,',');
		
		$varIndiaQuery	= '';
		$varUSAQuery	= '';
		$varOtherQuery	= '';
		$varTotalQuery  = '';

		if($funIndiaStates != ''){
			$varCityCond	= ($argCity!='')?' AND Residing_District IN ('.$argCity.')':'';
			$varIndiaQuery	= '(Country=98 AND Residing_State IN ('.$funIndiaStates.')'.$varCityCond.') ';
			if($funKey = array_search('98',$argCountry))
			unset($argCountry[$funKey]);

			if($funKey==0 && $argCountry[$funKey]==98)
			unset($argCountry[$funKey]);
			
		}
		if($funUSAStates != ''){
			if($varIndiaQuery != ''){$varIndiaQuery .= ' OR ';}
			$varUSAQuery	= '(Country=222 AND Residing_State IN ('.$funUSAStates.'))';
			if($funKey = array_search('222',$argCountry))
			unset($argCountry[$funKey]);

			if($funKey==0 && $argCountry[$funKey]==222)
			unset($argCountry[$funKey]);
		}
		
		if(count($argCountry)>0){
			$varCounrty		= join(',', $argCountry);
			if($varUSAQuery != '' || $varIndiaQuery != ''){	$varOtherQuery	.= ' OR ';}
			$varOtherQuery	.= 'Country IN ('.$varCounrty.')';
		}

		if($varIndiaQuery != ''){
			$varTotalQuery = ' AND ('.$varIndiaQuery.$varUSAQuery.$varOtherQuery.')';
		}else if($varUSAQuery != ''){
			$varTotalQuery = ' AND ('.$varUSAQuery.$varOtherQuery.')';
		}else if($varOtherQuery != ''){
			$varTotalQuery = ' AND '.$varOtherQuery;
		}
		return $varTotalQuery;
	}

	function getNotInProfiles($argTblName)
	{
		global $sessMatriId;
		$funMatriIds	= '';
		$funfields		= array('Opposite_MatriId');
		$funcondition	= " WHERE MatriId=".$this->doEscapeString($sessMatriId,$this);
		if($argTblName == 'memberactioninfo'){$funcondition .= ' AND (Mail_Sent=1 OR Interest_Sent=1)';}
		$funArrRes = $this->select($argTblName,$funfields,$funcondition,1);
		$funMatriIdCnt = count($funArrRes);
		//if($funMatriIdCnt<3000) { 
			for($i=0;$i<$funMatriIdCnt;$i++) { $funMatriIds = $funMatriIds."'".$funArrRes[$i]['Opposite_MatriId']."',"; }
			$funMatriIds = substr($funMatriIds,0,-1);
		//}
		return $funMatriIds;
	}
	
	function putSaveSrchData()
	{
		global $sessMatriId,$sessGender,$sessPaidStatus,$varTable,$varSrchName,$_COOKIE;
		$funSrchName = addslashes(trim($_POST['searchName']));
		extract($_POST);
		$funTblName	= $varTable['SEARCHSAVEDINFO'];
		$varSaveGo	= 0;

		if($saveSrch=='yes' && is_numeric($srchId)){ 
			$funCondition	= " WHERE Search_Id=".$srchId." AND MatriId='".$sessMatriId."' AND Search_Type=".$srchType; 
			$varSrchCnt		= $this->numOfRecords($funTblName,'Search_Id', $funCondition);
			$varSaveGo		= $varSrchCnt;
		}else{ 
			$funCondition	= " WHERE MatriId='".$sessMatriId."' AND Search_Name='".$funSrchName."'"; 
			$varSrchCnt		= $this->numOfRecords($funTblName,'Search_Id', $funCondition);
			$varSrchNameExists	= ($varSrchCnt == 0) ? 'no' : 'yes';
			if($varSrchNameExists == 'no') {
				if($sessPaidStatus==0){
					$varSrchCntExceed	= 'yes';
					$funCondition	= " WHERE MatriId='".$sessMatriId."'";  
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
			$education		= is_array($education) ? implode('~',$education) : $education;
			$occupation		= is_array($occupation) ? implode('~',$occupation) : $occupation;
			$maritalStatus	= is_array($maritalStatus) ? implode('~',$maritalStatus) : $maritalStatus;
			$caste			= is_array($caste) ? implode('~',$caste) : addslashes($caste);
			$subcaste		= is_array($subcaste) ? implode('~',$subcaste) : addslashes($subcaste);
			$gothram		= is_array($gothram) ? implode('~',$gothram) : addslashes($gothram);
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
			$funIgnorCnct	= '';

			$funFields		= array('MatriId','Search_Name','Gender','Marital_Status','Children','Age_From','Age_To','Height_From','Height_To','Physical_Status','Mother_Tongue','Religion','Caste_Or_Division','Subcaste','Gothram','Eating_Habits','Drinking','Smoking','Education','Occupation_Category','Occupation','Citizenship','Country','Residing_District','Resident_Status','Posted_After','Search_By','Show_Photo_Horoscope','Show_Ignore_AlreadyContact','Search_Type','Days','Date_Updated','Residing_State','Chevvai_Dosham', 'Annual_Income','Star','Raasi','Denomination');
			$funFieldVals	= array("'".$sessMatriId."'","'".$funSrchName."'",$gender,"'".$maritalStatus."'","'".$haveChildren."'",$ageFrom,$ageTo,"'".$heightFrom."'","'".$heightTo."'","'".$physicalStatus."'","'".$motherTongue."'","'".$religion."'","'".$caste."'","'".$subcaste."'","'".$gothram."'","'".$eating."'","'".$drinking."'","'".$smoking."'","'".$education."'","'".$occupationCat."'","'".$occupation."'","'".$citizenship."'","'".$country."'","'".$residingCity."'","'".$residentStatus."'","'".$funPostedAft."'","'".$searchBy."'","'".$funPhotoHoro."'","'".$funIgnorCnct."'","'".$srchType."'","'".$days."'","'".date('Y-m-d H:i:s')."'", "'".$residingState."'",$manglik,"'".$annualIncome."'","'".$star."'","'".$raasi."'","'".$denomination."'");

			if($saveSrch=='yes' && is_numeric($srchId)) { 
				$funCond	= " MatriId=".$this->doEscapeString($sessMatriId,$this)." AND Search_Id=".$this->doEscapeString($srchId,$this)." AND Search_Type=".$this->doEscapeString($srchType,$this);
				$this->update($funTblName, $funFields, $funFieldVals,$funCond); 
			}else {
				$this->clsNewSavedSrchId = $this->insert($funTblName, $funFields, $funFieldVals);
			}
			return $this->regSearch();
		}else{
			if($varSrchNameExists == 'yes'){$varRetMsg = 'This search name already exists.';}
			else if($varSrchCntExceed == 'yes'){$varRetMsg = 'You have reached the maximum number of count.';}
			else{$varRetMsg = 'given saved search is not found.';}
			$this->clsSearchErr = 1;
			return $varRetMsg;
		}
	}
	function saveSearch($argSrchId) 
	{
		global $sessMatriId, $varWhereClause, $varTable;
		$funTblName	= $varTable['SEARCHSAVEDINFO'];
		$funFields			= array('MatriId','Search_Name','Gender','Marital_Status','Children','Age_From','Age_To','Height_From','Height_To','Physical_Status','Mother_Tongue','Religion','Caste_Or_Division','Subcaste','Gothram','Eating_Habits','Drinking','Smoking','Education','Occupation_Category','Occupation','Citizenship','Country','Residing_District','Resident_Status','Posted_After','Search_By','Show_Photo_Horoscope','Show_Ignore_AlreadyContact','Display_Format','Search_Type','Days','Date_Updated','Residing_State','Residing_State','Chevvai_Dosham', 'Annual_Income','Star','Raasi','Denomination');
		$funCondition	= " WHERE MatriId=".$this->doEscapeString($sessMatriId,$this)." AND Search_Id=".$this->doEscapeString($argSrchId,$this);
		$funSrchInfo	= $this->select($funTblName,$funFields,$funCondition,1);
		
		$funSrchType	= $funSrchInfo[0]['Search_Type'];
			
		if($funSrchInfo[0]['Posted_After'] != '0000-00-00 00:00:00' && $funSrchInfo[0]['Posted_After'] != ''){
			$_REQUEST["days"]	= 'P';
			$varPADateTime		= split(' ', $funSrchInfo[0]['Posted_After']);
			$arrPADate			= split('-', $varPADateTime[0]);
			$_REQUEST["postedMonth"]	= $arrPADate[1];
			$_REQUEST["postedDay"]		= $arrPADate[2];
			$_REQUEST["postedYear"]		= $arrPADate[0];
		}
		
		if($funSrchInfo[0]['Annual_Income'] != ''){
			$arrAnnualIncome	= split('~', $funSrchInfo[0]['Annual_Income']);
			$_REQUEST["annualIncome"]	= $arrAnnualIncome[0];
			$_REQUEST["annualIncome1"]	= $arrAnnualIncome[1];
		}

		$funPhotoHoro	= explode("~",$funSrchInfo[0]['Show_Photo_Horoscope']);
		
		if(preg_match("/[a-zA-Z][a-zA-Z0-9\\s]+/", trim($funSrchInfo[0]['Caste_Or_Division'])))
			$_REQUEST["casteTxt"]	= 'yes';
		if(preg_match("/[a-zA-Z][a-zA-Z0-9\\s]+/", trim($funSrchInfo[0]['Subcaste'])))
			$_REQUEST["subcasteTxt"]= 'yes';
		if(preg_match("/[a-zA-Z][a-zA-Z0-9\\s]+/", trim($funSrchInfo[0]['Gothram'])))
			$_REQUEST["gothramTxt"]	= 'yes';

		$_REQUEST["gender"]		= $funSrchInfo[0]["gender"];
		$_REQUEST["ageFrom"]	= $funSrchInfo[0]["Age_From"];	
		$_REQUEST["ageTo"]		= $funSrchInfo[0]["Age_To"];
		$_REQUEST["heightFrom"]	= $funSrchInfo[0]["Height_From"];	
		$_REQUEST["heightTo"]	= $funSrchInfo[0]["Height_To"];
		$_REQUEST["haveChildren"]	= $funSrchInfo[0]["Children"];
		if($funSrchType == 2){ 
			$_REQUEST["physicalStatus"] = $funSrchInfo[0]['Physical_Status'];
		}
		$_REQUEST["manglik"]		= $funSrchInfo[0]['Chevvai_Dosham'];
		$_REQUEST["eating"]			= $funSrchInfo[0]['Eating_Habits'];
		$_REQUEST["drinking"]		= $funSrchInfo[0]['Drinking'];
		$_REQUEST["smoking"]		= $funSrchInfo[0]['Smoking'];
		$_REQUEST["photoOpt"]		= $funPhotoHoro[0];
		$_REQUEST["horoscopeOpt"]	= $funPhotoHoro[1];
		$_REQUEST["searchBy"]		= $funSrchInfo[0]['Search_By'];
		$_REQUEST["maritalStatus"]	= $funSrchInfo[0]['Marital_Status'];
		$_REQUEST["religion"]		= $funSrchInfo[0]['Religion'];
		$_REQUEST["denomination"]	= $funSrchInfo[0]['Denomination'];
		$_REQUEST["caste"]			= $funSrchInfo[0]['Caste_Or_Division'];
		$_REQUEST["subcaste"]		= $funSrchInfo[0]['Subcaste'];
		$_REQUEST["gothram"]		= $funSrchInfo[0]['Gothram'];
		$_REQUEST["occupationCat"]	= $funSrchInfo[0]['Occupation_Category'];
		$_REQUEST["education"]		= $funSrchInfo[0]['Education'];
		$_REQUEST["occupation"]		= $funSrchInfo[0]['Occupation'];
		$_REQUEST["motherTongue"]	= $funSrchInfo[0]['Mother_Tongue'];
		$_REQUEST["residingState"]	= $funSrchInfo[0]['Residing_State'];
		$_REQUEST["residingCity"]	= $funSrchInfo[0]['Residing_District'];
		$_REQUEST["residentStatus"] = $funSrchInfo[0]['Resident_Status'];
		$_REQUEST["citizenship"]	= $funSrchInfo[0]['Citizenship'];
		$_REQUEST["country"]		= $funSrchInfo[0]['Country'];
		$_REQUEST["star"]			= $funSrchInfo[0]['Star'];
		$_REQUEST["raasi"]			= $funSrchInfo[0]['Raasi'];

		return $this->regSearch();
	}
}
?>