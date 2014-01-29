<?php
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

if($varRootBasePath == ''){ $varRootBasePath = '/home/product/community/ability/www'; }

//INCLUDE FILES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/messagevars.cil14');
include_once($varRootBasePath.'/conf/cityarray.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsDomain.php');

$ObjDomain = new domainInfo();

$retFea['Religion']		= $ObjDomain->useReligion();
$retFea['Denomination']	= $ObjDomain->useDenomination();
$retFea['Caste']		= $ObjDomain->useCaste();
$retFea['Subcaste']		= $ObjDomain->useSubcaste();
$retFea['Star']			= $ObjDomain->useStar();
$retFea['MaritalStatus']= $ObjDomain->useMaritalStatus();

$retArr['Religion']		= array();
$retArr['Denomination']	= array();
$retArr['Caste']		= array();
$retArr['Subcaste']		= array();
$retArr['Star']			= array();
$retArr['MaritalStatus']= array();

if($retFea['Religion'])
	$retArr['Religion']		= $ObjDomain->getReligionOption();
if($retFea['Denomination'])
	$retArr['Denomination'] = $ObjDomain->getDenominationOption();
if($retFea['Caste'])
	$retArr['Caste']		= $ObjDomain->getCasteOption();
if($retFea['Subcaste'])
	$retArr['Subcaste']		= $ObjDomain->getSubcasteOption();
if($retFea['Star'])
	$retArr['Star']			= $ObjDomain->getStarOption();
if($retFea['MaritalStatus'])
	$retArr['MaritalStatus']= $ObjDomain->getMaritalStatusOption();


Class BasicView extends DB
{
	//MEMBER VARIABLES
	public $clsSessMatriId		= '';
	public $clsSessPartnerPref	= '';
	public $clsBVMatriIds		= array();
	public $clsDelMatriIds		= array();
	

	//SELECT BASIC VIEW DETAILS
	function selectDetails($argCondition, $argMatriIdArr)
	{
		global $varTable,$arrHeightList,$arrEducationDisplay,$arrTotalOccupationList,$arrCountryList,$arrResidingStateList,$arrUSAStateList,$residingCityStateMappingList,$retFea,$retArr;
		
		$funRows = $argCondition['CNT']!=''?$this->numOfRecords($varTable['MEMBERINFO'], 'MatriId', $argCondition['CNT']):1;
		
		if($funRows > 0)
		{
			$funArrFinalDet = array();
			if($argCondition['CNT']!='')
			{
				$funArrFinalDet['TOT_CNT'] = $funRows;
			}

			$funFields	= array('MatriId', 'Nick_Name', 'Name', 'Age', 'Gender', 'Height', 'Height_Unit', 'Physical_Status', 'Marital_Status', 'Mother_TongueId', 'Mother_TongueText', 'Education_Category', 'Education_Detail', 'Occupation', 'Occupation_Detail', 'Religion', 'Denomination', 'CasteId', 'CasteText', 'Caste_Nobar', 'SubcasteId', 'SubcasteText', 'Subcaste_Nobar', 'Citizenship', 'Country', 'Residing_State', 'Residing_City', 'Residing_District', 'Residing_Area', 'Resident_Status', 'Eating_Habits', 'Publish', 'Last_Login', 'Date_Created', 'Photo_Set_Status', 'Protect_Photo_Set_Status', 'Phone_Verified', 'Voice_Available' , 'Reference_Set_Status', 'Video_Set_Status', 'Phone_Protected', 'Video_Protected', 'Special_Priv','Horoscope_Available','Horoscope_Protected', 'Star');
			$arrMatriIdsDet = $this->select($varTable['MEMBERINFO'], $funFields, $argCondition['LIMIT'], 1);
			$funMatriIds	= '';
			$arrNoPhotoIds	= array();
			$arrPhotoIds	= array();
			$funCountRecs	= count($arrMatriIdsDet);
			
			for($i=0; $i<$funCountRecs; $i++)
			{
				$arrAllIds[]  = $arrMatriIdsDet[$i]['MatriId'];
				$funMatriIds .= "'".$arrMatriIdsDet[$i]['MatriId']."', ";
				
				if($argMatriIdArr == 'Y')
				{
					$j = $arrMatriIdsDet[$i]['MatriId'];
				}
				else
				{
					$j = $i;
				}
				$this->clsBVMatriIds[$i]	= $arrMatriIdsDet[$i]['MatriId'];
				$funArrFinalDet[$j]['PT']	= $arrMatriIdsDet[$i]['Special_Priv'];
				$funArrFinalDet[$j]['ID']	= $arrMatriIdsDet[$i]['MatriId'];
				$funArrFinalDet[$j]['PU']	= $arrMatriIdsDet[$i]['Publish'];
				$funName					= ($arrMatriIdsDet[$i]['Nick_Name'] == '') ? $arrMatriIdsDet[$i]['Name'] :												  $arrMatriIdsDet[$i]['Nick_Name'];
				$funArrFinalDet[$j]['N']	= urlencode(ucfirst($funName));
				$funArrFinalDet[$j]['G']	= $arrMatriIdsDet[$i]['Gender'];
				$funArrFinalDet[$j]['ON']	= urlencode($this->getLastLoginInfo($arrMatriIdsDet[$i]['Last_Login'],$arrMatriIdsDet[$i]['Date_Created'],$arrMatriIdsDet[$i]['MatriId']));
			
				//Profile Details Starts -->
				if($arrMatriIdsDet[$i]['Height_Unit'] == 'cm')
				{
					$funHeight = $this->getHeightInFeet($arrMatriIdsDet[$i]['Height']);
				}
				else
				{
					$funHeight = preg_replace('/\-/', '/', $arrHeightList[$arrMatriIdsDet[$i]['Height']]);
				}
				
				//Feature related variables - Religion,Caste,Subcaste,MaritalStatus,Star
				$funReligion		= '';
				$funDenomination	= '';
				$funCaste			= '';
				$funSubcaste		= '';
				$funStar			= '';
				$funMaritalStatus	= '';

				if($retFea['Religion'] == 1 && count($retArr['Religion'])>1){
				$arrTemp			= $retArr['Religion'];
				$funReligion		= $arrTemp[$arrMatriIdsDet[$i]['Religion']];
				}

				if($retFea['Denomination'] == 1 && count($retArr['Denomination'])>1){
				$arrTemp			= $retArr['Denomination'];
				$funDenomination	= $arrTemp[$arrMatriIdsDet[$i]['Denomination']];
				$funDenomination	= $funDenomination=='Others' ? '' : $funDenomination;
				}

				if($retFea['MaritalStatus'] == 1  && count($retArr['MaritalStatus'])>1){
				$arrTemp			= $retArr['MaritalStatus'];
				$funMaritalStatus	= $arrTemp[$arrMatriIdsDet[$i]['Marital_Status']];
				}

				if($retFea['Caste'] == 1){
					if(count($retArr['Caste'])>1){
						$funNullarray = array('Others', "Don't wish to specify", 'Sikh - Unspecified', 'Muslim - UnSpecified', 'Christian - unspecified', 'Jain - Unspecified');
						$arrTemp	= $retArr['Caste'];
						$funCaste	= $arrTemp[$arrMatriIdsDet[$i]['CasteId']];
						$funCaste   = in_array($funCaste, $funNullarray) ? '' : $funCaste;
					}
				}else{
				$funCaste			= $arrTemp[$arrMatriIdsDet[$i]['CasteText']];
				}
				
				if($retFea['Subcaste'] == 1){
					if(count($retArr['Subcaste'])>1){
						$funNullarray = array('Others', "Don't wish to specify", "Don't know my sub-caste", 'Sikh - Unspecified', 'Muslim - UnSpecified', 'Christian - unspecified', 'Jain - Unspecified');
						$arrTemp			= $retArr['Subcaste'];
						$funSubcaste		= $arrTemp[$arrMatriIdsDet[$i]['SubcasteId']];
						$funSubcaste = in_array($funSubcaste, $funNullarray) ? '' : $funSubcaste;
					}
				}else{
				$funSubcaste		= $arrTemp[$arrMatriIdsDet[$i]['SubcasteText']];
				}

				if($retFea['Star'] == 1  && count($retArr['Star'])>1){
				$arrTemp			= $retArr['Star'];
				$funStar			= $arrTemp[$arrMatriIdsDet[$i]['Star']];
				}


				$funEducation		= $arrEducationDisplay[$arrMatriIdsDet[$i]['Education_Category']];
				$funOccupation		= $arrTotalOccupationList[$arrMatriIdsDet[$i]['Occupation']];
				$funOccupation		= $funOccupation=='Others' ? 'Occupation - Not specified' : $funOccupation;
				$funCountry			= $arrCountryList[$arrMatriIdsDet[$i]['Country']];


				if($arrMatriIdsDet[$i]['Country'] == 98)
				{
					$funStateVal	= $residingCityStateMappingList[$arrMatriIdsDet[$i]['Residing_State']];
					global $$funStateVal;
					$funResState	= $arrResidingStateList[$arrMatriIdsDet[$i]['Residing_State']];
					$funResCity		= ${$funStateVal}[$arrMatriIdsDet[$i]['Residing_District']];
				}
				elseif($arrMatriIdsDet[$i]['Country'] == 222)
				{
					$funResState	= $arrUSAStateList[$arrMatriIdsDet[$i]['Residing_State']];
					$funResCity		= $arrMatriIdsDet[$i]['Residing_City'];
				}
				else
				{
					$funResState	= $arrMatriIdsDet[$i]['Residing_Area'];
					$funResCity		= $arrMatriIdsDet[$i]['Residing_City'];
				}

				$funPublish		= $arrMatriIdsDet[$i]['Publish'];
				$funLastLogin	= $arrMatriIdsDet[$i]['Last_Login'];

				$varDetails	= urlencode($arrMatriIdsDet[$i]['Age'].'^~^'.$funHeight.'^~^'.$funMaritalStatus.'^~^'.$funEducation.'^~^'.$arrMatriIdsDet[$i]['Education_Detail'].'^~^'.$funOccupation.'^~^'.$arrMatriIdsDet[$i]['Occupation_Detail'].'^~^'.$funReligion.'^~^'.$funCaste.'^~^'.$funSubcaste.'^~^'.$funCountry.'^~^'.$funResState.'^~^'.$funResCity.'^~^'.$funPublish.'^~^'.$funLastLogin.'^~^'.$arrMatriIdsDet[$i]['Caste_Nobar'].'^~^'.$funStar.'^~^'.$arrMatriIdsDet[$i]['Subcaste_Nobar'].'^~^'.$funDenomination);

				$funArrFinalDet[$j]['PP']	= 0;
				if($this->clsSessMatriId != ''){
				//$funArrFinalDet[$j]['PP']	= $this->getCompatablity($arrMatriIdsDet[$i]['Age'], $arrMatriIdsDet[$i]['Height'], $arrMatriIdsDet[$i]['Marital_Status'],  $arrMatriIdsDet[$i]['Physical_Status'], $arrMatriIdsDet[$i]['Mother_TongueId'], $arrMatriIdsDet[$i]['Religion'], $arrMatriIdsDet[$i]['CommunityId'], $arrMatriIdsDet[$i]['Eating_Habits'], $arrMatriIdsDet[$i]['Education_Category'], $arrMatriIdsDet[$i]['Citizenship'], $arrMatriIdsDet[$i]['Country'], $arrMatriIdsDet[$i]['Residing_State'], $arrMatriIdsDet[$i]['Resident_Status']);
				}
				
				$funArrFinalDet[$j]['DE']	= $varDetails;

				//Profile Details Ends <--

				//Get Right Icon Details Starts -->
				$funArrFinalDet[$j]['RIC'] = $arrMatriIdsDet[$i]['Phone_Verified'].'^'.$arrMatriIdsDet[$i]['Voice_Available'].'^'.$arrMatriIdsDet[$i]['Reference_Set_Status'].'^'.$arrMatriIdsDet[$i]['Video_Set_Status'].'^'.$arrMatriIdsDet[$i]['Phone_Protected'].'^'.$arrMatriIdsDet[$i]['Video_Protected'];

				if($this->clsSessMatriId == ''){
					$funArrFinalDet[$j]['RIC'] .= '^0^0^0^'.$arrMatriIdsDet[$i]['Horoscope_Available'].'^'.$arrMatriIdsDet[$i]['Horoscope_Protected'];
				}else{
					$funOtherDet[$arrMatriIdsDet[$i]['MatriId']]	= '^'.$arrMatriIdsDet[$i]['Horoscope_Available'].'^'.$arrMatriIdsDet[$i]['Horoscope_Protected'];
				}

				//Get Right Icon Details Ends -->


				//Get Photo Details Starts -->
				if($arrMatriIdsDet[$i]['Photo_Set_Status']==0)
				{
					$funArrFinalDet[$j]['PH'] = '';
				}
				else if($arrMatriIdsDet[$i]['Photo_Set_Status']==1 && $arrMatriIdsDet[$i]['Protect_Photo_Set_Status']==1)
				{
					$funArrFinalDet[$j]['PH'] = 'P';
				}
				else if($arrMatriIdsDet[$i]['Photo_Set_Status']==1 && $arrMatriIdsDet[$i]['Protect_Photo_Set_Status']==0)
				{
					$arrPhotoIds[$i]  = $arrMatriIdsDet[$i]['MatriId'];
					$funPhotoIds	 .= "'".$arrMatriIdsDet[$i]['MatriId']."', ";
				}
				//Get Photo Details Ends -->
			}
			
			$funMatriIds = rtrim($funMatriIds, ', ');
	
			//Get Validated Photos Detail Starts -->
			if($funPhotoIds != '')
			{
				$arrPhotoIdsDet	= array();
				$funPhotoIds	= rtrim($funPhotoIds, ", ");

				$funFields		= array('MatriId','Normal_Photo1','Thumb_Small_Photo1','Photo_Status1','Normal_Photo2','Thumb_Small_Photo2','Photo_Status2','Normal_Photo3','Thumb_Small_Photo3','Photo_Status3','Normal_Photo4','Thumb_Small_Photo4','Photo_Status4','Normal_Photo5','Thumb_Small_Photo5','Photo_Status5','Normal_Photo6','Thumb_Small_Photo6','Photo_Status6','Normal_Photo7','Thumb_Small_Photo7','Photo_Status7','Normal_Photo8','Thumb_Small_Photo8','Photo_Status8','Normal_Photo9','Thumb_Small_Photo9','Photo_Status9','Normal_Photo10','Thumb_Small_Photo10','Photo_Status10');
				$funCondition	= 'WHERE MatriId IN('.$funPhotoIds.')';
				
				$resPhotoIdsDet = $this->select($varTable['MEMBERPHOTOINFO'], $funFields, $funCondition, 0);

				while($row = mysql_fetch_assoc($resPhotoIdsDet))
				{
					for($i=1; $i<=10; $i++)
					{
						if($row['Photo_Status'.$i] > 0){
						$arrNormalPhotoDet[$row['MatriId']] .= $row['Normal_Photo'.$i].'^';
						$arrThumbPhotoDet[$row['MatriId']] .= $row['Thumb_Small_Photo'.$i].'^';
						}//if
					}//for
				}

				foreach($arrPhotoIds as $funKey=>$funVal)
				{
					if($argMatriIdArr == 'Y'){
					$funKey = $funVal;
					}
					$funArrFinalDet[$funKey]['PH']	= rtrim($arrNormalPhotoDet[$funVal], '^');
					$funArrFinalDet[$funKey]['TPH']	= rtrim($arrThumbPhotoDet[$funVal], '^');
				}
			}
			//Get Validated Photos Detail Ends -->


			//Get Icon Details Starts -->
			if($this->clsSessMatriId != '')
			{
				$arrIcIdsDet	= $this->getIconDetails($funMatriIds,$varTable['MEMBERACTIONINFO']);
			
				foreach($arrAllIds as $funKey => $funVal)
				{
					$funKey = ($argMatriIdArr == 'Y') ? $funVal : $funKey;
					if($arrIcIdsDet[$funVal]['MID'] == 1){
					$funArrFinalDet[$funKey]['IC']  = $arrIcIdsDet[$funVal]['BM'].'^'.$arrIcIdsDet[$funVal]['IG'].'^'.$arrIcIdsDet[$funVal]['BL'];
					$funArrFinalDet[$funKey]['RIC'].= '^'.$arrIcIdsDet[$funVal]['LastAction'].$funOtherDet[$funVal];
					}else{
					$funArrFinalDet[$funKey]['IC']  = '0^0^0';
					$funArrFinalDet[$funKey]['RIC'].= '^0^0^0'.$funOtherDet[$funVal];
					}
				}

			}

			//Get Icon Details Ends -->

			return $funArrFinalDet;
		}
		else
		{
			$funArrFinalDet['TOT_CNT'] = $funRows;
			return $funArrFinalDet;
		}
	}//selectDetails

	function getIconDetails($argOppIds, $argTblName)
	{
		$arrIcIdsDet	= array();
		$funFields = array('MatriId', 'Opposite_MatriId', 'Bookmarked', 'Ignored', 'Blocked', 'Interest_Received_Date', 'Interest_Sent_Date', 'Mail_Sent_Date', 'Mail_Received_Date', 'Receiver_Replied_Date', 'Receiver_Declined_Date', "IF(Interest_Received_Date>Interest_Sent_Date AND Interest_Received_Date>Mail_Received_Date AND Interest_Received_Date>Mail_Sent_Date AND Interest_Received=1 AND Interest_Received_Date>Receiver_Replied_Date AND Interest_Received_Date>Receiver_Declined_Date,Interest_Received_Status,'N') AS IntRec", "IF(Interest_Sent_Date>Interest_Received_Date AND Interest_Sent_Date>Mail_Received_Date AND Interest_Sent_Date>Mail_Sent_Date AND Interest_Sent=1 AND Interest_Sent_Date>Receiver_Replied_Date AND Interest_Sent_Date>Receiver_Declined_Date,Interest_Sent_Status,'N') AS IntSen", "IF(Mail_Sent_Date>Interest_Received_Date AND Mail_Sent_Date>Mail_Received_Date AND Mail_Sent_Date>Interest_Sent_Date AND Mail_Sent=1 AND Mail_Sent_Date>=Receiver_Replied_Date AND Mail_Sent_Date>Receiver_Declined_Date,Mail_Sent_Status,'N') AS MsgSen", "IF(Mail_Received_Date>Interest_Received_Date AND Mail_Received_Date>Mail_Sent_Date AND Mail_Received_Date>Interest_Sent_Date AND Mail_Received=1 AND Mail_Received_Date>Receiver_Replied_Date AND Mail_Received_Date>Receiver_Declined_Date,Mail_Received_Status,'N') AS MsgRec", "IF(Receiver_Replied_Date>Interest_Received_Date AND Receiver_Replied_Date>Mail_Sent_Date AND Receiver_Replied_Date>Interest_Sent_Date AND Receiver_Replied=1 AND Receiver_Replied_Date>Mail_Received_Date AND Receiver_Replied_Date>Receiver_Declined_Date,'Y','N') AS MsgRep", "IF(Receiver_Declined_Date>Interest_Received_Date AND Receiver_Declined_Date>Mail_Sent_Date AND Receiver_Declined_Date>Interest_Sent_Date AND Receiver_Declined=1 AND Receiver_Declined_Date>Mail_Received_Date AND Receiver_Declined_Date>Receiver_Replied_Date,'Y','N') AS MsgDec");
		$funCondition	= "WHERE MatriId =".$this->doEscapeString($this->clsSessMatriId,$this)."  AND Opposite_MatriId IN(".$argOppIds.')';
		$funIconResult	= $this->select($argTblName, $funFields, $funCondition, 0);
		while($row = mysql_fetch_assoc($funIconResult))
		{
			$arrIcIdsDet[$row['Opposite_MatriId']]['MID']	= 1;
			$arrIcIdsDet[$row['Opposite_MatriId']]['BM']	= $row['Bookmarked'];
			$arrIcIdsDet[$row['Opposite_MatriId']]['IG']	= $row['Ignored'];
			$arrIcIdsDet[$row['Opposite_MatriId']]['BL']	= $row['Blocked'];
			$arrIcIdsDet[$row['Opposite_MatriId']]['LastAction'] = '0^0^0';
			$funCIconImage = '0';
			$funCDate	   = '0';
			$funCMsg       = '0';
			if ($row['IntRec'] != 'N') {
				$funCIconImage = ($row['IntRec']==0)?"unread":($row['IntRec']==1?"accept":"decline");
				$funCDate	   = $row['Interest_Received_Date'];
				$funCMsg       = 'Int received';
			} elseif ($row['IntSen'] != 'N') {
				$funCIconImage = ($row['IntSen']==0)?"unread":($row['IntSen']==1?"accept":"decline");
				$funCDate	   = $row['Interest_Sent_Date'];
				$funCMsg       = 'Int sent';
			} elseif ($row['MsgRep'] == 'Y') {
				$funCIconImage = 'reply';
				$funCDate	   = $row['Receiver_Replied_Date'];
				$funCMsg       = 'Msg replied';
			} elseif($row['MsgDec'] == 'Y') {
				$funCIconImage = 'decline';
				$funCDate	   = $row['Receiver_Declined_Date'];
				$funCMsg       = 'Msg declined';
			} elseif ($row['MsgRec'] != 'N') {
				$funCIconImage = ($row['MsgRec']==0)?"unread":"read";
				$funCDate	   = $row['Mail_Received_Date'];
				$funCMsg       = 'Msg received';
			} elseif ($row['MsgSen'] != 'N') {
				$funCIconImage = ($row['MsgSen']==0)?"unread":($row['MsgSen']==1?"read":($row['MsgSen']==2?"reply":"decline"));
				$funCDate	   = $row['Mail_Sent_Date'];
				$funCMsg       = 'Msg sent';
			}

			if($funCDate != '0'){$funCDate = date('d-M-y', strtotime($funCDate));}
			if($funCIconImage!=''){
				$arrIcIdsDet[$row['Opposite_MatriId']]['LastAction'] = $funCIconImage.'^'.urldecode($funCMsg).'^'.$funCDate;
			}
		}
		return $arrIcIdsDet;
	}

	//GET HEIGHT FORMAT
	function getHeightInFeet($argHeightInCms)
	{
		$funConvertFeet		= floor($argHeightInCms /(12*2.54));
		$funConvertInchs	= floor(($argHeightInCms - ($funConvertFeet*12*2.54))/2.54);
		$funConvertInchs	= ($funConvertInchs > 0)? $funConvertInchs.'in':'';
		$retHeightInFeet    = $funConvertFeet.'ft '.$funConvertInchs;
		$retHeightInFeet   .= " / ".round($argHeightInCms)."cm";
		return $retHeightInFeet;	
	}//getHeightUnit


	//GET COMPATABILITY STATUS
	function getCompatablity($argAge, $argHeight, $argMaritalSt, $argPhSt, $argMotherTongue, $argReligion, $argCaste, $argEatHb, $argEdu, $argCitizen, $argCountry, $argState, $argResident)
	{
		//Compatibilty Bar array values
		$funarrPPDet	= split('\^', $this->clsSessPartnerPref);
		$funAge			= split('~', $funarrPPDet[0]);
		$funHeight		= split('~', $funarrPPDet[1]);
		$funLookingfor	= $funarrPPDet[2]!=''?split('~', $funarrPPDet[2]):'';
		$funPhStatus	= $funarrPPDet[3];
		$funMotherTongue= $funarrPPDet[4]!=''?split('~', $funarrPPDet[4]):'';
		$funReigion		= $funarrPPDet[5]!=''?split('~', $funarrPPDet[5]):'';
		$funCaste		= $funarrPPDet[6]!=''?split('~', $funarrPPDet[6]):'';
		$funEatingHabit	= $funarrPPDet[7];
		$funEducation	= $funarrPPDet[8]!=''?split('~', $funarrPPDet[8]):'';
		$funCitizenship	= $funarrPPDet[9]!=''?split('~', $funarrPPDet[9]):'';
		$funCountry		= $funarrPPDet[10]!=''?split('~', $funarrPPDet[10]):'';
		$funIndiaState	= $funarrPPDet[11]!=''?split('~', $funarrPPDet[11]):'';
		$funUSAState	= $funarrPPDet[12]!=''?split('~', $funarrPPDet[12]):'';
		$funResidentSt	= $funarrPPDet[13]!=''?split('~', $funarrPPDet[13]):'';

		$PPValue = 0;
		
		//Age percentage
		if($argAge>=$funAge[0] && $argAge<=$funAge[1])
		$PPValue += 10; 
		
		
		//Height ercentage
		if($argHeight>=$funHeight[0] && $argHeight<=$funHeight[1])
		$PPValue += 10; 

		//Marital status percentage
		if($funLookingfor != 0 && in_array($argMaritalSt, $funLookingfor))
		$PPValue += 10; 
		else if($funLookingfor == 0)
		$PPValue += 10; 

		//Physical status percentage
		if($argPhSt == $funPhStatus && $funPhStatus!=0)
		$PPValue += 5; 
		else if($funPhStatus == 0)
		$PPValue += 5; 

		//Mothertongue Percentage
		if($funMotherTongue!='' && in_array($argMotherTongue, $funMotherTongue))
		$PPValue += 10; 
		else if($funMotherTongue =='')
		$PPValue += 10; 

		//Religion Percentage
		if($funReigion!='' && in_array($argReligion, $funReigion))
		$PPValue += 10; 
		else if($funReigion =='')
		$PPValue += 10; 

		//Caste Percentage
		if($funCaste!='' && in_array($argCaste, $funCaste))
		$PPValue += 5;
		else if($funCaste =='')
		$PPValue += 5; 
	
		//Eating Habits Percentage
		if($funEatingHabit==0 || $funEatingHabit==$argEatHb)
		$PPValue += 5; 

		//Education Percentage
		if($funEducation!='' && in_array($argEdu, $funEducation))
		$PPValue += 5;
		else if($funEducation =='')
		$PPValue += 5; 

		//Citizenship Percentage
		if($funCitizenship!='' && in_array($argCitizen, $funCitizenship))
		$PPValue += 5;
		else if($funCitizenship =='')
		$PPValue += 5; 

		//Country Percentage
		if($funCountry!='' && in_array($argCountry, $funCountry))
		$PPValue += 10;
		else if($funCountry =='')
		$PPValue += 10; 

		//check india, usa is in selected country list
		$funResStateVal = 0;
		if($funIndiaState!='' && $argCountry==98 && in_array(98, $funCountry))
		{
			//IND state Percentage
			if(in_array($argState, $funIndiaState))
			$funResStateVal = 5;
		}
		else if($funUSAState!='' && $argCountry==222 && in_array(222, $funCountry))
		{
			//USA state Percentage
			if(in_array($argState, $funUSAState))
			$funResStateVal = 5;
		}
		else if($funUSAState=='' && $funUSAState=='')
		{
			$funResStateVal = 5;
		}
		$PPValue += $funResStateVal;
		
		//Resident Status Percentage
		if($funResidentSt != '' && in_array($argResident, $funResidentSt))
		$PPValue += 5;
		else if($funResidentSt =='')
		$PPValue += 5;

		$PPValue = ($PPValue > 95)? 95 : $PPValue;
		$PPValue = ($PPValue < 40 )? 40 : $PPValue;

		return $PPValue;
	}//getCompatablity


	//CHECK MEMBER ONLINE STATUS 
	function checkMemOnline($argMatriid,$argLastLogin,$argTimeCreated) 
	{
		$funOnline='N';
		if($argLastLogin!='' && $argTimeCreated!='') {
			
			if($argLastLogin=="0000-00-00 00:00:00")
				$lst = split('[- :]',$argTimeCreated);
			else
				$lst = split('[- :]',$argLastLogin);
			
			$funCurrenttime = time();
			$funDifftime	= $funCurrenttime - strtotime(date("d-M-Y H:i", mktime($lst[3],$lst[4],0,$lst[1],$lst[2],$lst[0])));
			$funDays		= $funDifftime/(24*3600);

			
			if($funDays <= 1) {
				$funHours = $funDifftime/3600;
				if($funHours < 1) {
					if(floor($funDifftime/60) <= 1) {
						$funOnline='Y';
					}			
				}
			}
		}
		if($funOnline=='N') {	
			$funOnlineFilepath = "/home/product/community/ability/www/onlineusers/".$argMatriid.".txt";
			(file_exists($funOnlineFilepath)) ? $funOnline='Y' : $funOnline='N';
		}

		return $funOnline;
	}//checkMemOnline

	//GET LAST LOGIN INFORMATION - by day/week
	function getLastLoginInfo($argLastLogin,$argTimeCreated,$argMatriId) 
	{

		if($argMatriId!="" && $this->checkMemOnline($argMatriId,$argLastLogin,$argTimeCreated)=="Y")
			return "NOW";
		
		if($argLastLogin=="0000-00-00 00:00:00")
			$lst = split('[- :]',$argTimeCreated);
		else
			$lst = split('[- :]',$argLastLogin);
		
		$funCurrenttime = time();
		$funDifftime	= $funCurrenttime - strtotime(date("d-M-Y H:i", mktime($lst[3],$lst[4],0,$lst[1],$lst[2],$lst[0])));
		$funDays		= $funDifftime/(24*3600);
		
		if($funDays <= 1) {
			$funHours = $funDifftime/3600;
			if($funHours < 1) {
				if(floor($funDifftime/60) <= 1)
					return "NOW";
				else
					return floor($funDifftime/60)." minutes";
			}else {
				if(floor($funDifftime/3600) <= 1)
					return "1 hour";
				else
					return floor($funDifftime/3600)." hours";
			}
		}
		else if($funDays > 1 && $funDays <= 7) {
			if(floor($funDays) <= 1)
				return floor($funDays)." day";
			else
				return floor($funDays)." days";
		}
		else if($funDays > 7 && $funDays <= 30) {
			if(floor($funDays/7) <= 1)
				return floor($funDays/7)." week";
			else
				return floor($funDays/7)." weeks";
		}
		else if($funDays > 30 && $funDays <= 90) {
			if(floor($funDays/30) <=1)
				return floor($funDays/30)." month";
			else
				return floor($funDays/30)." months";
		}
		else
			return "3 months";

	}//getLastLoginInfo

	function getDeletedIdsDet($argDelIds)
	{
		global $varTable;
		$funFields	  = array('MatriId','Name','Gender');
		$funCondition = 'WHERE MatriId IN('.$argDelIds.')';
		$resDelIdsDet = $this->select($varTable['MEMBERDELETEDINFO'], $funFields, $funCondition, 0);

		$arrDelIdsDet = array();
		$i = 0;
		while($row = mysql_fetch_assoc($resDelIdsDet))
		{
			$funName = $arrMatriIdsDet[$i]['Name'];
			
			$arrDelIdsDet[$row['MatriId']]['PU']= 'D';
			$arrDelIdsDet[$row['MatriId']]['N'] = $funName;
			$arrDelIdsDet[$row['MatriId']]['ID']= $row['MatriId'];
			$this->clsDelMatriIds[$i]			= $row['MatriId'];
			$i++;
		}
		return $arrDelIdsDet;
	}
}
?>