<?php
//BASE PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath= dirname($varRootPath);

//INCLUDE FILES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/conf/messagevars.cil14');
include_once($varRootBasePath.'/conf/cityarray.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootPath.'/sphinx/sphinxarray.php');

Class SrchBasicView extends DB
{
	//MEMBER VARIABLES
	public $clsSessMatriId		= '';
	public $clsSessPartnerPref	= '';
	public $clsBVMatriIds		= array();
	public $clsDelMatriIds		= array();


	//SELECT BASIC VIEW DETAILS
	function selectBVDetails($argResultArr)
	{
		global $varTable,$arrEducationDisplay,$arrTotalOccupationList,$arrCountryList,$arrResidingStateList,$arrUSAStateList,$residingCityStateMappingList,$retFea,$retArr,$varWhereClause;

		$funArrFinalDet = array();
		
		$arrMatriIds = array_keys($argResultArr);
		$varTotCnt	 = count($arrMatriIds);
		if($varTotCnt>0){
		$funWhereCond = 'WHERE '.$varWhereClause." AND MatriId IN('".join("', '", $arrMatriIds)."')";
		$funFields	= array('MatriId', 'Nick_Name', 'Name', 'Education_Detail', 'Occupation_Detail', 'CasteText', 'SubcasteText', 'Residing_City', 'Residing_Area');
		$varResMatriIds = $this->select($varTable['MEMBERINFOSEARCH'], $funFields, $funWhereCond, 0);
		while($row = mysql_fetch_assoc($varResMatriIds)){
			$argResultArr[$row['MatriId']] = $argResultArr[$row['MatriId']]+$row;
		}
		$funMatriIds	= '';
		$arrNoPhotoIds	= array();
		$arrPhotoIds	= array();
		}
		$i= 0;
		foreach($argResultArr as $arrMatriId)
		{
			$arrAllIds[]  = $arrMatriId['MatriId'];
			$funMatriIds .= "'".$arrMatriId['MatriId']."', ";

			if($argMatriIdArr == 'Y')
			{
				$j = $arrMatriId['MatriId'];
			}
			else
			{
				$j = $i;
			}
			$this->clsBVMatriIds[$i]	= $arrMatriId['MatriId'];
			$funArrFinalDet[$j]['PT']	= $arrMatriId['Special_Priv'];
			$funArrFinalDet[$j]['ID']	= $arrMatriId['MatriId'];
			$funArrFinalDet[$j]['PU']	= $arrMatriId['Publish'];
			$funName					= ($arrMatriId['Nick_Name'] == '') ? $arrMatriId['Name'] : $arrMatriId['Nick_Name'];
			$funArrFinalDet[$j]['N']	= urlencode(ucfirst($funName));
			$funArrFinalDet[$j]['G']	= $arrMatriId['Gender'];
			$funArrFinalDet[$j]['ON']	= urlencode($this->getLastLoginInfo($arrMatriId['Last_Login'],$arrMatriId['Online_Status'],$arrMatriId['Date_Created'],$arrMatriId['MatriId']));

			//Profile Details Starts -->
			$funHeight = $this->getHeightInFeet($arrMatriId['Height']);
						
			//Feature related variables - Religion,Caste,Subcaste,MaritalStatus,Star
			$funReligion		= '';
			$funDenomination	= '';
			$funCaste			= '';
			$funSubcaste		= '';
			$funStar			= '';
			$funMaritalStatus	= '';

			if($retFea['Religion'] == 1 && count($retArr['Religion'])>1){
			$arrTemp			= $retArr['Religion'];
			$funReligion		= $arrTemp[$arrMatriId['Religion']];
			}

			if($retFea['Denomination'] == 1 && count($retArr['Denomination'])>1){
			$arrTemp			= $retArr['Denomination'];
			$funDenomination	= $arrTemp[$arrMatriId['Denomination']];
			$funDenomination	= $funDenomination=='Others' ? '' : $funDenomination;
			}

			if($retFea['MaritalStatus'] == 1  && count($retArr['MaritalStatus'])>1){
			$arrTemp			= $retArr['MaritalStatus'];
			$funMaritalStatus	= $arrTemp[$arrMatriId['Marital_Status']];
			}

			if($retFea['Caste'] == 1){
				if(count($retArr['Caste'])>1){
					$funNullarray = array('Others', "Don't wish to specify", 'Sikh - Unspecified', 'Muslim - UnSpecified', 'Christian - unspecified', 'Jain - Unspecified');
					$arrTemp	= $retArr['Caste'];
					$funCaste	= $arrTemp[$arrMatriId['CasteId']];
					$funCaste   = in_array($funCaste, $funNullarray) ? '' : $funCaste;
				}
			}else{
			$funCaste			= $arrTemp[$arrMatriId['CasteText']];
			}

			if($retFea['Subcaste'] == 1){
				if(count($retArr['Subcaste'])>1){
					$funNullarray = array('Others', "Don't wish to specify", "Don't know my sub-caste", 'Sikh - Unspecified', 'Muslim - UnSpecified', 'Christian - unspecified', 'Jain - Unspecified');
					$arrTemp	 = $retArr['Subcaste'];
					$funSubcaste = $arrTemp[$arrMatriId['SubcasteId']];
					$funSubcaste = in_array($funSubcaste, $funNullarray) ? '' : $funSubcaste;
				}
			}else{
			$funSubcaste		= $arrTemp[$arrMatriId['SubcasteText']];
			}

			if($retFea['Star'] == 1  && count($retArr['Star'])>1){
			$arrTemp			= $retArr['Star'];
			$funStar			= $arrTemp[$arrMatriId['Star']];
			}


			$funEducation		= $arrEducationDisplay[$arrMatriId['Education_Category']];
			$funOccupation		= $arrTotalOccupationList[$arrMatriId['Occupation']];
			$funOccupation		= $funOccupation=='Others' ? 'Occupation - Not specified' : $funOccupation;
			$funCountry			= $arrCountryList[$arrMatriId['Country']];


			if($arrMatriId['Country'] == 98)
			{
				$funStateVal	= $residingCityStateMappingList[$arrMatriId['Residing_State']];
				global $$funStateVal;
				$funResState	= $arrResidingStateList[$arrMatriId['Residing_State']];
				$funResCity		= ${$funStateVal}[$arrMatriId['Residing_District']];
			}
			elseif($arrMatriId['Country'] == 222)
			{
				$funResState	= $arrUSAStateList[$arrMatriId['Residing_State']];
				$funResCity		= $arrMatriId['Residing_City'];
			}
			else
			{
				$funResState	= $arrMatriId['Residing_Area'];
				$funResCity		= $arrMatriId['Residing_City'];
			}

			$funPublish		= $arrMatriId['Publish'];
			$funLastLogin	= $arrMatriId['Last_Login'];

			$varDetails	= urlencode($arrMatriId['Age'].'^~^'.$funHeight.'^~^'.$funMaritalStatus.'^~^'.$funEducation.'^~^'.$arrMatriId['Education_Detail'].'^~^'.$funOccupation.'^~^'.$arrMatriId['Occupation_Detail'].'^~^'.$funReligion.'^~^'.$funCaste.'^~^'.$funSubcaste.'^~^'.$funCountry.'^~^'.$funResState.'^~^'.$funResCity.'^~^'.$funPublish.'^~^'.$funLastLogin.'^~^'.$arrMatriId['Caste_Nobar'].'^~^'.$funStar.'^~^'.$arrMatriId['Subcaste_Nobar'].'^~^'.$funDenomination);

			$funArrFinalDet[$j]['DE']	= $varDetails;

			//Profile Details Ends <--

			//Get Right Icon Details Starts -->
			$funArrFinalDet[$j]['RIC'] = $arrMatriId['Phone_Verified'].'^'.$arrMatriId['Voice_Available'].'^'.$arrMatriId['Reference_Set_Status'].'^'.$arrMatriId['Video_Set_Status'].'^'.$arrMatriId['Phone_Protected'].'^'.$arrMatriId['Video_Protected'];

			if($this->clsSessMatriId == ''){
				$funArrFinalDet[$j]['RIC'] .= '^0^0^0^'.$arrMatriId['Horoscope_Available'].'^'.$arrMatriId['Horoscope_Protected'];
			}else{
				$funOtherDet[$arrMatriId['MatriId']]	= '^'.$arrMatriId['Horoscope_Available'].'^'.$arrMatriId['Horoscope_Protected'];
			}

			//Get Right Icon Details Ends -->


			//Get Photo Details Starts -->
			if($arrMatriId['Photo_Set_Status']==0)
			{
				$funArrFinalDet[$j]['PH'] = '';
			}
			else if($arrMatriId['Photo_Set_Status']==1 && $arrMatriId['Protect_Photo_Set_Status']==1)
			{
				$funArrFinalDet[$j]['PH'] = 'P';
			}
			else if($arrMatriId['Photo_Set_Status']==1 && $arrMatriId['Protect_Photo_Set_Status']==0)
			{
				$arrPhotoIds[$i]  = $arrMatriId['MatriId'];
				$funPhotoIds	 .= "'".$arrMatriId['MatriId']."', ";
			}
			//Get Photo Details Ends -->
			$i++;
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

		return $funArrFinalDet;

	}//selectDetails

	function getIconDetails($argOppIds, $argTblName)
	{
		$arrIcIdsDet	= array();
		$funFields = array('MatriId', 'Opposite_MatriId', 'Bookmarked', 'Ignored', 'Blocked', 'Interest_Received_Date', 'Interest_Sent_Date', 'Mail_Sent_Date', 'Mail_Received_Date', 'Receiver_Replied_Date', 'Receiver_Declined_Date', "IF(Interest_Received_Date>Interest_Sent_Date AND Interest_Received_Date>Mail_Received_Date AND Interest_Received_Date>Mail_Sent_Date AND Interest_Received=1 AND Interest_Received_Date>Receiver_Replied_Date AND Interest_Received_Date>Receiver_Declined_Date,Interest_Received_Status,'N') AS IntRec", "IF(Interest_Sent_Date>Interest_Received_Date AND Interest_Sent_Date>Mail_Received_Date AND Interest_Sent_Date>Mail_Sent_Date AND Interest_Sent=1 AND Interest_Sent_Date>Receiver_Replied_Date AND Interest_Sent_Date>Receiver_Declined_Date,Interest_Sent_Status,'N') AS IntSen", "IF(Mail_Sent_Date>Interest_Received_Date AND Mail_Sent_Date>Mail_Received_Date AND Mail_Sent_Date>Interest_Sent_Date AND Mail_Sent=1 AND Mail_Sent_Date>=Receiver_Replied_Date AND Mail_Sent_Date>Receiver_Declined_Date,Mail_Sent_Status,'N') AS MsgSen", "IF(Mail_Received_Date>Interest_Received_Date AND Mail_Received_Date>Mail_Sent_Date AND Mail_Received_Date>Interest_Sent_Date AND Mail_Received=1 AND Mail_Received_Date>Receiver_Replied_Date AND Mail_Received_Date>Receiver_Declined_Date,Mail_Received_Status,'N') AS MsgRec", "IF(Receiver_Replied_Date>Interest_Received_Date AND Receiver_Replied_Date>Mail_Sent_Date AND Receiver_Replied_Date>Interest_Sent_Date AND Receiver_Replied=1 AND Receiver_Replied_Date>Mail_Received_Date AND Receiver_Replied_Date>Receiver_Declined_Date,'Y','N') AS MsgRep", "IF(Receiver_Declined_Date>Interest_Received_Date AND Receiver_Declined_Date>Mail_Sent_Date AND Receiver_Declined_Date>Interest_Sent_Date AND Receiver_Declined=1 AND Receiver_Declined_Date>Mail_Received_Date AND Receiver_Declined_Date>Receiver_Replied_Date,'Y','N') AS MsgDec");
		$funCondition	= "WHERE MatriId =".$this->doEscapeString($this->clsSessMatriId,$this)." AND Opposite_MatriId IN(".$argOppIds.')';
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
		$funConvertInchs	= ($argHeightInCms - ($funConvertFeet*12*2.54))/2.54;
		$funConvertInchs	= floor("$funConvertInchs");
		$funConvertInchs	= ($funConvertInchs > 0)? $funConvertInchs.'in':'';
		$retHeightInFeet    = $funConvertFeet.'ft '.$funConvertInchs;
		$retHeightInFeet   .= " / ".round($argHeightInCms)."cm";
		return $retHeightInFeet;
	}//getHeightUnit


	//GET LAST LOGIN INFORMATION - by day/week
	function getLastLoginInfo($argLastLogin,$argOnlineStatus,$argTimeCreated,$argMatriId)
	{

		if($argMatriId!="" && $argOnlineStatus==1)
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

	function getFacetingContent($argArrFacet){
		global $varImgsURL, $arrFacetingDetails, $varFacetingUsed, $arrFacetNotSpecified,$arrFacetOthers,$arrFaceting,$varFeaHoroscope;
		$varRefineTxt = $varFacetingUsed==0 ? 'Refine search' :  'Refine search <span id="testspan" onclick="javascript:getFirstSrch();" style="cursor:pointer;" class="clr1 normtxt">[ Clear all ]</span>';
		$funCont = '<table border="0" cellpadding="0" cellspacing="0" id="src_main">
			<tr>
				<td colspan="3">
				<div id="more_opt" style="display:none;width:430px;position:absolute;margin-left:15px;">
				   <div style="z-index:500;position:absolute;margin-left:140px;margin-top:5px;width:430px !important;width:290px;display:inline;"><img src="'.$varImgsURL.'/pop-curve-top.gif" width="11" height="6" border="0" alt=""></div>
                   <div style="z-index:499;position:absolute;width:430px;margin-top:10px;border: 1px solid #DBDBDB; background:#F5F4D6;">
						<div class="fright" style="padding:3px;"><a href="javascript:closeMore()">
							<img src="'.$varImgsURL.'/close.gif" style="vertical-align:middle;border:0px"/></a>
						</div><br clear="all">
						<div id="facetMoreContainer">
							<div align="center"><img src="'.$varImgsURL.'/moreloading.gif" border="0"></div>
						</div><br clear="all">
					</div>
				</div>
				</td>
			</tr>
			<tr>
				<td valign="top" id="navearea">
				<div style="float: left; width: 190px;border:1px solid #DBDBDB;">
					<div id="panel">
						<div class="normtxt1 clr fnt17 bld" style="padding-left:12px;padding-top:9px;">'.$varRefineTxt.'</div>';
		
		foreach($arrFacetingDetails as $key=>$arrSinVal){
			$funFacetLbl		= $arrSinVal[0];
			$funFacetSphxName	= $arrSinVal[1];
			$funFacetDivName	= $arrSinVal[2];
			$funFacetArrName	= $arrSinVal[3];
			$varDividerLine		= '<div class="facetdot"><img src="'.$varImgsURL.'/trans.gif" height="1"/></div>';
			$funDivder			= 0;
			if($key=='age' || $key=='height'){
				$arrSinFacet = $argArrFacet[$funFacetSphxName];
				list($varFacetTxt, $varFacetVal) = each($arrSinFacet);
				$funCont	.='<dl><dt class="mediumtxt boldtxt">'.$funFacetLbl.'</dt><dd style="line-height: 14px;" class="tick"><font class="clr1">'.$varFacetTxt.' </font> ('.$varFacetVal.')</dd><dd id="'.$funFacetDivName.'" style="text-align: right;"><a class="clr1" href="javascript:showMore(\''.$key.'\',\''.$funFacetDivName.'\')">More &gt;&gt;</a></dd></dl>';
				$funDivder = 1;
			}else if($key=='active'){
				$arrSinFacet[0] = $argArrFacet['OnlineStatus'][1];
				$arrSinFacet[1] = $argArrFacet['activeweek'][0]+$argArrFacet['activeweek'][1];
				$arrSinFacet[2] = $argArrFacet['activemonth'][0]+$argArrFacet['activemonth'][1];
				$arrSinFacet[3] = $argArrFacet['activetotal'][0];
								
				$funActivePost	= $_POST[$key];
				$arrSinFacet	= (is_numeric($funActivePost) && $funActivePost>=0 && $funActivePost<=3) ? array($funActivePost=>$arrSinFacet[$funActivePost]) : $arrSinFacet;
				
				$funCont	.= '<dl><dt class="mediumtxt boldtxt">'.$funFacetLbl.'</dt>';
				$arrActiveTxt = array(0=>'Online now', 1=>'One week', 2=>'One month', 3=>'One month and above');
				foreach($arrSinFacet as $activekey=>$activeval){
					if($activeval>0){
						$funCont	.= '<dd style="line-height: 14px;" class="tick"><a href="javascript:submitFrmFacet(\''.$key.'\',\''.$activekey.'\')"><font class="clr1">'.$arrActiveTxt[$activekey].'</font><font class="clr"> ('.$activeval.')</font></a></dd>';
					}
				}
				$funCont	.= '<dd id="'.$funFacetDivName.'" style="text-align: right;"><a class="clr1" href="javascript:showMore(\''.$key.'\',\''.$funFacetDivName.'\')">More &gt;&gt;</a></dd></dl>';
				$funDivder = 1;
			}else if($key=='physicalStatus'){
				global $$funFacetArrName;
				$varConfArr	= $$funFacetArrName;

				$arrSinFacet  = $argArrFacet['Physical_Status'];
								
				$funCont	.= '<dl><dt class="mediumtxt boldtxt">'.$funFacetLbl.'</dt>';
				foreach($arrSinFacet as $activekey=>$activeval){
					if($activeval>0){
						$funCont	.= '<dd style="line-height: 14px;" class="tick"><a href="javascript:submitFrmFacet(\''.$key.'\',\''.$activekey.'\')"><font class="clr1">'.$varConfArr[$activekey].'</font><font class="clr"> ('.$activeval.')</font></a></dd>';
					}
				}
				$funCont	.= '<dd id="'.$funFacetDivName.'" style="text-align: right;"><a class="clr1" href="javascript:showMore(\''.$key.'\',\''.$funFacetDivName.'\')">More &gt;&gt;</a></dd></dl>';
				$funDivder = 1;
			}else if($key=='profiletype'){
				$arrSinFacet = $argArrFacet['Photo_Set_Status'];
				$varWithHoro = '';
				$varWithPhoto= '';
				if($arrSinFacet[1]>0 && ($_POST['photoOpt']==1 || $_POST['photoOpt']==0 || ($_POST['photoOpt']=='' && $_POST['horoscopeOpt']==''))){
					$varWithPhoto = '<dd style="line-height: 14px;" class="tick"><a href="javascript:submitFrmFacet(\'photoOpt\',\'1\')"><font class="clr1">With Photo</font><font class="clr"> ('.$arrSinFacet[1].')</font></a></dd>';
				}
				
				$arrSinFacet = $argArrFacet['Horoscope_Available'];
				
				if($varFeaHoroscope==1 && $arrFaceting['Star']==1 && ($arrSinFacet[1]>0 || $arrSinFacet[3]>0) && ($_POST['horoscopeOpt']==1 || $_POST['horoscopeOpt']==0 || ($_POST['photoOpt']=='' && $_POST['horoscopeOpt']==''))){
					$varWithHoro = '<dd style="line-height: 14px;" class="tick"><a href="javascript:submitFrmFacet(\'horoscopeOpt\',\'1\')"><font class="clr1">With Horoscope</font><font class="clr"> ('.($arrSinFacet[1]+$arrSinFacet[3]).')</font></dd>';
				}

				if($varWithPhoto!='' || $varWithHoro!=''){
					$funCont	.= '<dl><dt class="mediumtxt boldtxt">'.$funFacetLbl.'</dt>'.$varWithPhoto.$varWithHoro.'<dd id="'.$funFacetDivName.'" style="text-align: right;"><a class="clr1" href="javascript:showMore(\''.$key.'\',\''.$funFacetDivName.'\')">More &gt;&gt;</a></dd></dl>';
					$funDivder = 1;
				}

			}else if($key=='annualIncome'){
				$varAnnualIncome = '';
				global $$funFacetArrName;
				$varConfArr	= $$funFacetArrName;
				if($argArrFacet['Annual_Income_INR'][1]>0){
					$funAnnaulVal = $_POST['annualIncome'].'~'.$_POST['annualIncome1'];
					if($_POST['annualIncome']>=0.50 && $_POST['annualIncome1']<=101 && $_POST['annualIncome1']>$_POST['annualIncome']){
						$funAnnaulTxt = $varConfArr[$_POST['annualIncome']].' to '.$varConfArr[$_POST['annualIncome1']];
					}else if($_POST['annualIncome']==101){
						$funAnnaulTxt = $varConfArr[$_POST['annualIncome']];
					}else if($_POST['annualIncome']==0.49){
						$funAnnaulTxt = $varConfArr[$_POST['annualIncome']];
					}
					$varAnnualIncome .= '<dd style="line-height: 14px;" class="tick"><a href="javascript:submitFrmFacet(\''.$key.'\',\''.$funAnnaulVal.'\')"><font class="clr1">'.$funAnnaulTxt.'</font><font class="clr"> ('.$argArrFacet['Annual_Income_INR'][1].')</font></a></dd>';
				}else{
					for($i=1; $i<=3; $i++){
						$funAnnaulTxt = array(1=>'Rs.1 lakh to Rs.3 lakh', 2=>'Rs.3 lakh to Rs.5 lakh', 3=>'Rs.5 lakh to Rs.10 lakh');
						$funAnnaulVal = array(1=>'1~3', 2=>'3~5', 3=>'5~10');
						if($argArrFacet['Annual_Income_INR'.$i][1]>0){
						$varAnnualIncome .= '<dd style="line-height: 14px;" class="tick"><a href="javascript:submitFrmFacet(\''.$key.'\',\''.$funAnnaulVal[$i].'\')"><font class="clr1">'.$funAnnaulTxt[$i].'</font><font class="clr">  ('.$argArrFacet['Annual_Income_INR'.$i][1].')</font></a></dd>';
						}
					}
				}

				if($varAnnualIncome!=''){
					$funCont	.= '<dl><dt class="mediumtxt boldtxt">'.$funFacetLbl.'</dt>'.$varAnnualIncome.'<dd id="'.$funFacetDivName.'" style="text-align: right;"><a class="clr1" href="javascript:showMore(\''.$key.'\',\''.$funFacetDivName.'\')">More &gt;&gt;</a></dd></dl>';
					$funDivder = 1;
				}
				
			}else if($key =='residingCity'){
				global $residingCityStateMappingList, $arrCityStateMapping;
				
				$arrCurrentVals = $argArrFacet[$funFacetSphxName];
				
				$arrPostVals	= array();
				
				if($_POST[$key]!=''){
					$arrPostVals	= getQueryVal($_POST[$key]);
				}else if(count($arrCurrentVals)>0){
					$arrModifiedCity = array();
					
					foreach($arrCurrentVals as $citykey=>$cityval){
						if($arrCityStateMapping[$citykey] != ''){
							$arrModifiedCity[]	= $arrCityStateMapping[$citykey].'#'.$citykey;
						}
					}
					$arrPostVals = $arrModifiedCity;
				}

				if(count($arrPostVals)>0){
					$funCityCont = '';
					$jj=1;
					foreach($arrPostVals as $varSingleVal){
						$arrCityInfo  = split('#', $varSingleVal);
						$arrStateName = $residingCityStateMappingList[$arrCityInfo[0]];
						global $$arrStateName;
						$arrStateVal = $$arrStateName;
						$varOptionName = $arrStateVal[$arrCityInfo[1]];
						
						if($varSingleVal!='' && $arrCurrentVals[$arrCityInfo[1]]>0 && $varOptionName!=''){
							$funCityCont .='<dd style="line-height: 14px;" class="tick"><a href="javascript:submitFrmFacet(\''.$key.'\',\''.$varSingleVal.'\')"><font class="clr1">'.$varOptionName.'</font><font class="clr"> ('.$arrCurrentVals[$arrCityInfo[1]].')</font></a></dd>';
							if($jj>2){break;}else{ $jj++;}
						}
						
					}
					if($funCityCont!=''){
					$funCont .= '<dl><dt class="mediumtxt boldtxt">'.$funFacetLbl.'</dt>'.$funCityCont.'<dd id="'.$funFacetDivName.'" style="text-align: right;"><a class="clr1" href="javascript:showMore(\''.$key.'\',\''.$funFacetDivName.'\')">More &gt;&gt;</a></dd></dl>';
					$funDivder = 1;
					}
				}
			}else if($key!='photoOpt' && $key!='horoscopeOpt' && $funFacetArrName!=''){

				//for commercial sites - If muslim & christian based religion selected need to avoid horoscope related things 
				if($varFeaHoroscope==0 && ($key=='manglik' || $key=='star' || $key=='gothram')){
					continue;
				}

				global $$funFacetArrName;
				$varConfArr		= $$funFacetArrName;
				$arrCurrentVals = $argArrFacet[$funFacetSphxName];
				
				$arrPostVals	= array();
				if($_POST[$key]!='' && $_POST[$key]!=0){
					if($key=='manglik'){ 
						if($_POST[$key]=='2'){$_POST[$key]='2~0';}
						else if(preg_match("/99/", $_POST[$key])){
							$_POST[$key] = preg_replace("/99/","0",$_POST[$key]);
						}
					}else if($key=='eating' || $key=='smoking' || $key=='drinking'){
						if(preg_match("/99/", $_POST[$key])){
							$_POST[$key] = preg_replace("/99/","0",$_POST[$key]);
						}
					}

					if($key=='gothram' && preg_match("/99/", $_POST[$key])){
						$arrPostVals = array_flip($arrCurrentVals);
					}else{
						$arrPostVals = getQueryVal($_POST[$key]);
					}
				}else if(count($arrCurrentVals)>0){
					$arrPostVals	= array_flip($arrCurrentVals);
				}

				if(count($arrPostVals)>0){
					$funDynaCont  = '';
					$funOtherCont = '';
					$jj=1;
					foreach($arrPostVals as $varSingleVal){
						//$varOptionName   = ($varConfArr[$varSingleVal]=='' && in_array($key, $arrFacetNotSpecified)) ? 'Not specified' : $varConfArr[$varSingleVal];
						//for Not specified in manglik, eating, smoking and drinking
						if($varConfArr[$varSingleVal]=='' && in_array($key, $arrFacetNotSpecified)){
							$varDynaKeyVal	= 99;
							$varOptionName  = 'Not specified';
						}else{
							$varDynaKeyVal	= $varSingleVal;
							$varOptionName  = $varConfArr[$varSingleVal];
						}

						if(array_key_exists($varSingleVal, $arrFacetOthers) && $arrCurrentVals[$varSingleVal]>0){
							$funOtherCont .= '<dd style="line-height: 14px;" class="tick"><a href="javascript:submitFrmFacet(\''.$key.'\',\''.$varDynaKeyVal.'\')"><font class="clr1">'.$varOptionName.'</font><font class="clr"> ('.$arrCurrentVals[$varSingleVal].')</font></a></dd>';
							if($jj>2){break;}else{ $jj++;}
						}else if($varSingleVal!='' && $arrCurrentVals[$varSingleVal]>0 && $varOptionName!=''){
							$funDynaCont	.='<dd style="line-height: 14px;" class="tick"><a href="javascript:submitFrmFacet(\''.$key.'\',\''.$varDynaKeyVal.'\')"><font class="clr1">'.$varOptionName.'</font><font class="clr"> ('.$arrCurrentVals[$varSingleVal].')</font></a></dd>';
							if($jj>2){break;}else{ $jj++;}
						}
					}
					if($funDynaCont != '' || $funOtherCont!=''){
					$funCont .= '<dl><dt class="mediumtxt boldtxt">'.$funFacetLbl.'</dt>'.$funDynaCont.$funOtherCont.'<dd id="'.$funFacetDivName.'" style="text-align: right;"><a class="clr1" href="javascript:showMore(\''.$key.'\',\''.$funFacetDivName.'\')">More &gt;&gt;</a></dd></dl>';
					$funDivder = 1;
					}
				}
			}
			if($funDivder == 1){ $funCont .= $varDividerLine;}
		}
		$funCont  = rtrim($funCont, $varDividerLine);
		$funCont .='</div></div><div style="clear:both;"></div></td></tr></table>';
		return $funCont;
	}
}
?>