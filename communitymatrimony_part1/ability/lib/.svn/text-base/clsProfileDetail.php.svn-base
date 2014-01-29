<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-08-13
# End Date		: 2008-08-13
# Project		: MatrimonyProduct
# Module		: Profiledetail - view profile
#=============================================================================================================
//FILE INCLUDES
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

class ProfileDetail extends MemcacheDB
{
	public $clsSessPartnerPref	= '';

	function photoDisplay($varOwnView,$varMatriId,$varDbInfo,$varTable) {
		//$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
		global $confValues;

		$this->dbConnect('S',$varDbInfo);
		$argFields	= array('Thumb_Small_Photo1','Normal_Photo1','Photo_Status1','Thumb_Small_Photo2','Normal_Photo2','Photo_Status2','Thumb_Small_Photo3','Normal_Photo3','Photo_Status3','Thumb_Small_Photo4','Normal_Photo4','Photo_Status4','Thumb_Small_Photo5','Normal_Photo5','Photo_Status5','Thumb_Small_Photo6','Normal_Photo6','Photo_Status6','Thumb_Small_Photo7','Normal_Photo7','Photo_Status7','Thumb_Small_Photo8','Normal_Photo8','Photo_Status8','Thumb_Small_Photo9','Normal_Photo9','Photo_Status9','Thumb_Small_Photo10','Normal_Photo10','Photo_Status10','HoroscopeURL','HoroscopeStatus');
		$argCondition			= "WHERE MatriId=".$this->doEscapeString($varMatriId,$this);
		$varPhotoInfoResultSet		= $this->select($varTable['MEMBERPHOTOINFO'],$argFields,$argCondition,0);
		$varPhotoInfo				= mysql_fetch_array($varPhotoInfoResultSet);
		$this->dbClose();

		$varPhotoName = '';
		$varNormalPhotoName = '';
		for($i = 1; $i <= 10; $i++)
		{
			if($varPhotoInfo['Photo_Status'.$i] != '' && $varPhotoInfo['Thumb_Small_Photo'.$i] != '')
			{
				if($varOwnView == 1)
				{
					$varPhotoStatus = $varPhotoStatus.$varPhotoInfo["Photo_Status$i"].'^';
					$varPhotoName = $varPhotoName.$varPhotoInfo["Thumb_Small_Photo$i"].'^';
					$varNormalPhotoName = $varNormalPhotoName.$varPhotoInfo["Normal_Photo$i"].'^';
				}
				else
				{
					if($varPhotoInfo["Photo_Status$i"]== 1 || $varPhotoInfo["Photo_Status$i"]== 2)
					{
						$varPhotoStatus = $varPhotoStatus.$varPhotoInfo["Photo_Status$i"].'^';
						$varPhotoName = $varPhotoName.$varPhotoInfo["Thumb_Small_Photo$i"].'^';
						$varNormalPhotoName = $varNormalPhotoName.$varPhotoInfo["Normal_Photo$i"].'^';
					}
				}
			}
		}

		if($varPhotoInfo['HoroscopeStatus'] != '' && $varPhotoInfo['HoroscopeURL'] != '') {
			if($varOwnView == 1) {
				$varHoroscopeURL = $varPhotoInfo["HoroscopeURL"];
			} else {
				if($varPhotoInfo["HoroscopeStatus"]== 1 || $varPhotoInfo["HoroscopeStatus"]== 3) {
					$varHoroscopeURL = $varPhotoInfo["HoroscopeURL"];
				}
			}
		}

		$varPhotoName		= trim($varPhotoName,'^');
		$varPhotoStatus		= trim($varPhotoStatus,'^');
		$varNormalPhotoName = trim($varNormalPhotoName,'^');
		$varPhotoDetail		= $varPhotoName.'~'.$varPhotoStatus.'~'.$varNormalPhotoName.'~'.$varHoroscopeURL;
		return $varPhotoDetail;
	}

	//Check Ignored,Block,Decline Profiles
	function checkMyListViewProfile($argOppMatriId,$argMatriId,$varDbInfo,$varMemberActionInfo)
	{
		$this->dbConnect('S',$varDbInfo);
		$funCheckBookMark	= '';
		$funCheckIgnore		= '';
		$funCheckBlock		= '';
		$funMyListInfo			= '';
		if ($argOppMatriId !="" && $argMatriId !="")
		{
			$argFields	= array('Opposite_MatriId','Bookmarked','Ignored','Blocked');
			$argCondition = "WHERE MatriId=".$this->doEscapeString($argMatriId,$this)." AND Opposite_MatriId=".$this->doEscapeString($argOppMatriId,$this);
			$funListQueryResultSet		= $this->select($varMemberActionInfo,$argFields,$argCondition,0);
			$funListQueryResultSet				= mysql_fetch_assoc($funListQueryResultSet);

			$funBookmark	= $funListQueryResultSet["Bookmarked"];
			$funIgnored		= $funListQueryResultSet["Ignored"];
			$funBlocked		= $funListQueryResultSet["Blocked"];
			$funOppMatriId	= $funListQueryResultSet["Opposite_MatriId"];
		}//if

		if ($funBookmark=="1")
		{
			$funMyListInfo		.= '<div id="shortlist'.$argOppMatriId.'" style="padding: 2px 0px 0px 3px; float: left;"><a href="javascript:void(0)" onClick="javascript:funIframeURL(\'list/listadd.php?id='.$argOppMatriId.'&ed=ed&purp=shortlist\',\'375\',\'173\',\'iframeicon\',\'icondiv\');"><div class="useracticonsimgs shortlist pntr" style="float:left;padding: 0px 0px 0px 3px;" title="This member is currently in your Shortlist"></div></a></div>';
			//$funMyListInfo		= '<a href="javascript:void(0);" onClick="javascript:showbookmark(\'show-bookmarkmessage.php?id='.$argOppMatriId.'\'); return false;"><img src="'.$this->clsFavoritesIcon.'" title="Bookmarked Profile" border="0"></a>';
		}//if
		if ($funIgnored=="1")
		{
			$funMyListInfo		.= '<div id="ignore'.$argOppMatriId.'" style="padding: 2px 0px 0px 3px; float: left;"><a href="javascript:void(0)" onClick="javascript:funIframeURL(\'list/listadd.php?id='.$argOppMatriId.'&ed=ed&purp=ignore\',\'375\',\'173\',\'iframeicon\',\'icondiv\');"><div class="useracticonsimgs ignore" style="float:left;padding: 0px 0px 0px 3px;" title="This member is currently in your ignore list"></div></a></div>';
			//$funMyListInfo		= '<a href="javascript:void(0);" onClick="javascript:showbookmark(\'show-ignoremessage.php?id='.$argOppMatriId.'\'); return false;"><img src="'.$this->clsIgnoreIcon.'" title="Ignored Profile" border="0"></a>';
		}//if
		if ($funBlocked=="1")
		{
			$funMyListInfo		.= '<div id="block'.$argOppMatriId.'" style="padding: 2px 0px 0px 3px; float: left;"><a href="javascript:void(0)" onClick="javascript:funIframeURL(\'list/listadd.php?id='.$argOppMatriId.'&ed=ed&purp=block\',\'375\',\'173\',\'iframeicon\',\'icondiv\');"><div class="useracticonsimgs block fleft" style="float:left;padding: 0px 0px 0px 3px;" title="This member is currently in your block list"></div></a></div>';
			//$funMyListInfo	   .= '<img title="Blocked Profile" src='.$this->clsBlockIcon.' border="0"> ';
		}//if
		$retMyListInfo	= '<div id="useracticons"><div id="useracticonsimgs"><div class="fleft">'.$funMyListInfo.'</div></div></div>';

		return $retMyListInfo;
	}//checkMyListProfiles

	//GET DATE FORMAT [DATE-MONTH-YEAR]
	function getDateMonthYear($argFormat,$argDateTime,$argOppositeId='')
	{
		$retDateValue		= date($argFormat,strtotime($argDateTime));
	/*	if($argOppositeId != '')
		{
			$funGetMyListInfo	= $this->checkMyListProfiles($argOppositeId);
			$retDateValue	   .= '&nbsp;&nbsp;'.$funGetMyListInfo;
		}//if*/
		return $retDateValue;
	}//getDateMothYear

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

				//print $PPValue;exit;

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

	// GET Total Prospects (my home)- getNumberOfOppositeGenderProfiles
	function getNoOfOppProfile ($argGender) {
		global $varDbInfo, $varWhereClause, $varTable;
		$this->dbConnect('S',$varDbInfo['DATABASE']);
		if ($argGender !="") {
			//$argCondition = "WHERE ". $varWhereClause. " AND Gender != $argGender";
			//$varOppGenderCount = $this->numOfRecords('gendercountinfo', 'MatriId', $argCondition);
            //return $this->getApproxOppGenCnt($varOppGenderCount);
			$varGetGender = (($argGender==1)? 2:1);
			$argFields	= array('Count');
			$argCondition = "WHERE ". $varWhereClause. " AND Gender = ".$varGetGender;
			$funQueryResultSet = $this->select('gendercountinfo',$argFields,$argCondition,0);
			$funQueryResultSet = mysql_fetch_assoc($funQueryResultSet);
			return $this->getApproxOppGenCnt($funQueryResultSet['Count']);
		}
	}

	// GET Matches sent by mail : (my home)
	function getMatchesSentCnt ($argMatriId) {
		global $varDbInfo, $varTable;
		$this->dbConnect('S',$varDbInfo['DATABASE']);
		if ($argMatriId !="") {
			$argFields	= array('Match_Watch_Email');
			$argCondition = "WHERE MatriId=".$this->doEscapeString($argMatriId,$this);
			$funQueryResultSet = $this->select($varTable['MEMBERSTATISTICS'],$argFields,$argCondition,0);
			$funQueryResultSet = mysql_fetch_assoc($funQueryResultSet);
			return $funQueryResultSet['Match_Watch_Email'];
		}
	}

	// GET Members in contact: (my home)
	function getMembersInContactCnt ($argMatriId) {
		global $varDbInfo, $varWhereClause, $varTable;
		$this->dbConnect('S',$varDbInfo['DATABASE']);
		if ($argMatriId !="") {
			$argFields	= array('Interest_Accept_Sent','Mail_Replied_Sent');
			$argCondition = "WHERE MatriId=".$this->doEscapeString($argMatriId,$this);
			$funListQueryResultSet = $this->select($varTable['MEMBERSTATISTICS'],$argFields,$argCondition,0);
			$funListQueryResultSet = mysql_fetch_assoc($funListQueryResultSet);
			return $funListQueryResultSet["Interest_Accept_Sent"] + $funListQueryResultSet["Mail_Replied_Sent"];
		}
	}

	// GET Total Prospects count details
	function getApproxOppGenCnt ($varCount) {
		if ($varCount >= 1 && $varCount <= 250) {
			return 'Over '.$varCount;
		} elseif ($varCount > 250 && $varCount <= 500) {
			return 'Over 250';
		} elseif ($varCount > 500 && $varCount <= 1000) {
			return 'Over 500';
		} elseif ($varCount > 1000 && $varCount <= 10000) {
			return 'Over '.(floor($varCount/1000)*1000);
		} elseif ($varCount > 10000) {
			return 'Over 10000';
		} else {
			return 0;
		}
	}

	// GET Profile Master Info (Memberinfo Table)
	function getProfileInfo ($argMatriId) {
		global $varDbInfo, $varTable;
		$this->dbConnect('S',$varDbInfo['DATABASE']);
		if ($argMatriId !="") {
			$argFields	= array('MatriId','Name','Gender','Publish','Paid_Status','Complete_Now','Physical_Status','Disability_Cause','Disability_Type','Disability_Product_Used');
			$argCondition = "WHERE MatriId=".$this->doEscapeString($argMatriId,$this);
			$funQueryResultSet = $this->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
			$funQueryResultSet = mysql_fetch_assoc($funQueryResultSet);
			return $funQueryResultSet;
		}
	}

	// To get Pending tools details
	function profilePendingTools() { // Profile completeness algorithim
		global $varGetCookieInfo, $confValues, $varPhotoUrl;
		$varPendingToolsLink = ''; $varPendingTools = '';

		$objClsDomain = new domainInfo;

		if ($varGetCookieInfo['PHONEVERIFIED'] != 1 && $varGetCookieInfo['PHONEVERIFIED'] != 3) {
			$varPendingTools .= '<a href="http://www'.$confValues['DOMAINNAME'].'/profiledetail/index.php?act=primaryinfo" class="clr1 smalltxt">Verify phone number</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
		}
		if ($varGetCookieInfo['PHOTOSTATUS'] != 1 && trim($varPhotoUrl) == '') {
			$varPendingTools .= '<a href="'.$confValues['IMAGEURL'].'/photo/index.php?act=addphoto" class="clr1 smalltxt">Add photo</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
		}
		if ($varGetCookieInfo['HOROSCOPESTATUS'] != 1 && $varGetCookieInfo['HOROSCOPESTATUS'] != 3 && $objClsDomain->useHoroscope() == 1) {
			$varPendingTools .= '<a href="'.$confValues['IMAGEURL'].'/horoscope/index.php?act=addhoroscope" class="clr1 smalltxt">Add Horoscope</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
		}
		if ($varPendingTools != '') {
			$varPendingToolsLink = substr($varPendingTools,0,strlen($varPendingTools)-25); //substr($varPendingToolsLink,0,5);
		}
		return $varPendingToolsLink;
	}

	// To get Duplicate Email ids for a specific matri id
	function getDuplicateEmails($varMatriId,$varEmail) {
       global $varDbInfo,$varTable;
	   $this->dbConnect('S',$varDbInfo['DATABASE']);
	    $argCondition = "WHERE MatriId !=".$this->doEscapeString($varMatriId,$this)." AND  Email=".$this->doEscapeString($varEmail,$this);
	   return $this->numOfRecords($varTable['MEMBERLOGININFO'],'Email',$argCondition);
    }
}

?>