<?php
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

if($varRootBasePath == ''){ $varRootBasePath = '/home/product/community'; }

//INCLUDE FILES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

Class MailerBasicView extends DB
{
	public $clsProtectedPhotoImage = 'img50_pro.gif';
	public $clsRequestPhotofImage = 'noimg50_f.gif';
	public $clsRequestPhotomImage = 'noimg50_m.gif';

	//SELECT BASIC VIEW DETAILS
	function selectDetails($argMatriIdArr,$argVMM='')
	{
		global $varTable,$arrHeightList,$arrMaritalList,$arrEducationList,$arrCountryList,$arrResidingStateList,$arrUSAStateList,$residingCityStateMappingList;

		$varMatchMatriIdStr	= implode(",",$argMatriIdArr);
		echo "Condition=".$argCondition	= " WHERE MatriId IN (".$varMatchMatriIdStr.") AND Publish=1";
		$funFields	= array('MatriId', 'User_Name', 'Name', 'Nick_Name', 'Age', 'Gender', 'Height', 'Height_Unit', 'Physical_Status', 'Marital_Status', 'Mother_TongueId', 'Education_Category', 'Education_Detail', 'Occupation', 'Occupation_Detail', 'Religion', 'Denomination', 'CasteId', 'Caste_Nobar','SubcasteId', 'Subcaste_Nobar', 'Citizenship', 'Country', 'Residing_State', 'Residing_City', 'Residing_District', 'Residing_Area', 'Resident_Status', 'Eating_Habits', 'Publish', 'Last_Login', 'Date_Created', 'Photo_Set_Status', 'Protect_Photo_Set_Status', 'Phone_Verified', 'Voice_Available' , 'Reference_Set_Status','Video_Set_Status','Phone_Protected','Video_Protected');

		//$arrMatriIdsDet = $this->select($varTable['MEMBERINFO'], $funFields, $argCondition, 1);
		if ($argVMM=='1') {
			$arrMatriIdsDet = $this->select('memberinfo', $funFields, $argCondition, 1);
		} else {
			$arrMatriIdsDet = $this->select('memberinfo_mw', $funFields, $argCondition, 1);
		}
		

echo "TestTest";
print_r($arrMatriIdsDet);
		
		$arrNoPhotoIds	= array();
		$arrPhotoIds	= array();
		$funCountRecs	= count($arrMatriIdsDet);
		
		for($i=0; $i<$funCountRecs; $i++)
		{
			$funArrFinalDet[$i]['ID']	= $arrMatriIdsDet[$i]['MatriId'];
			$funArrFinalDet[$i]['PU']	= $arrMatriIdsDet[$i]['Publish'];
			$funArrFinalDet[$i]['UN']	= $arrMatriIdsDet[$i]['User_Name'];
			$funArrFinalDet[$i]['N']	= $arrMatriIdsDet[$i]['Name'];
			$funArrFinalDet[$i]['NN']	= $arrMatriIdsDet[$i]['Nick_Name'];
			$funArrFinalDet[$i]['G']	= $arrMatriIdsDet[$i]['Gender'];
			
			//Profile Details Starts -->
			if($arrMatriIdsDet[$i]['Height_Unit'] == 'cm')
			{
				$funHeight = $this->getHeightInFeet($arrMatriIdsDet[$i]['Height']);
			}
			else
			{
				$funHeight = preg_replace('/\-/', '/', $arrHeightList[$arrMatriIdsDet[$i]['Height']]);
			}
			
			$funMaritalStatus	= $arrMaritalList[$arrMatriIdsDet[$i]['Marital_Status']];
			$funEducation		= $arrEducationList[$arrMatriIdsDet[$i]['Education_Category']];
			$funOccupation		= $arrOccupationList[$arrMatriIdsDet[$i]['Occupation']];
			$funCountry			= $arrCountryList[$arrMatriIdsDet[$i]['Country']];

			if($this->funReligionArrayFeature>1) {
				if($arrMatriIdsDet[$i]['Religion'] != 0 && $arrMatriIdsDet[$i]['Religion'] != '') {
					$funReligion= $this->arrMWReligionList[$arrMatriIdsDet[$i]['Religion']];
				}
			}

			if($this->funDenomArrayFeature>1) {
				if($arrMatriIdsDet[$i]['Denomination'] != 0 && $arrMatriIdsDet[$i]['Denomination'] != '') {
					$funDenomination= $this->arrMWDenomList[$arrMatriIdsDet[$i]['Denomination']];
				}
			}

			if($this->funCasteArrayFeature>1) {
				if($arrMatriIdsDet[$i]['CasteId'] != 0 && $arrMatriIdsDet[$i]['CasteId'] != '') {
					$funCaste	= $this->arrMWCasteList[$arrMatriIdsDet[$i]['CasteId']];
				}
			}

			if($this->funSubcasteArrayFeature>1) {
				if($arrMatriIdsDet[$i]['SubcasteId'] != '' && $arrMatriIdsDet[$i]['SubcasteId'] != 0 ) {
					$funSubcaste= $this->arrMWSubcasteList[$arrMatriIdsDet[$i]['SubcasteId']];
				}
			}
			

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

			$varDetails	= $arrMatriIdsDet[$i]['Age'].'^~^'.$funHeight.'^~^'.$funMaritalStatus.'^~^'.$funEducation.'^~^'.$arrMatriIdsDet[$i]['Education_Detail'].'^~^'.$funOccupation.'^~^'.$arrMatriIdsDet[$i]['Occupation_Detail'].'^~^'.$funReligion.'^~^'.$funCaste.'^~^'.$funSubcaste.'^~^'.$funCountry.'^~^'.$funResState.'^~^'.$funResCity.'^~^'.$funPublish.'^~^'.$arrMatriIdsDet[$i]['Caste_Nobar'].'^~^'.$arrMatriIdsDet[$i]['Subcaste_Nobar'].'^~^'.$funDenomination;

			$funArrFinalDet[$i]['DE']	= $varDetails;

			//Get Photo Details Starts -->
			if($arrMatriIdsDet[$i]['Photo_Set_Status']==0)
			{
				$funArrFinalDet[$i]['PH'] = '';
			}
			else if($arrMatriIdsDet[$i]['Photo_Set_Status']==1 && $arrMatriIdsDet[$i]['Protect_Photo_Set_Status']==1)
			{
				$funArrFinalDet[$i]['PH'] = 'P';
			}
			else if($arrMatriIdsDet[$i]['Photo_Set_Status']==1 && $arrMatriIdsDet[$i]['Protect_Photo_Set_Status']==0)
			{
				$arrPhotoIds[$i]  = $arrMatriIdsDet[$i]['MatriId'];
				$funPhotoIds	 .= "'".$arrMatriIdsDet[$i]['MatriId']."', ";
			}
			//Get Photo Details Ends -->
		}

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
					break;
					}//if
				}//for
			}

			foreach($arrPhotoIds as $funKey=>$funVal)
			{
				$funArrFinalDet[$funKey]['PH']	= rtrim($arrNormalPhotoDet[$funVal], '^');
				$funArrFinalDet[$funKey]['TPH']	= rtrim($arrThumbPhotoDet[$funVal], '^');
			}
		}
		//Get Validated Photos Detail Ends -->

		return $funArrFinalDet;
	}//selectDetails

	//GET HEIGHT FORMAT
	function getHeightInFeet($argHeightInCms)
	{
		$funConvertFeet		= floor($argHeightInCms /(12*2.54));
		$funConvertInchs	= floor(($argHeightInCms - ($funConvertFeet*12*2.54))/2.54);
		$funConvertInchs	= ($funConvertInchs > 0)? $funConvertInchs.'in':'';
		$retHeightInFeet    = $funConvertFeet.'ft '.$funConvertInchs;
		//$retHeightInFeet   .= " / ".round($argHeightInCms)."cm";
		return $retHeightInFeet;	
	}//getHeightUnit

	#------------------------------------------------------------------------------------------------------------
	//BASIC DISPLAY for Match Watch Mailer
	function mailMatchWatchBasicDetails($argPurpose,$varBasicDetails,$argLink='',$argMailerName='', $argTrackDtls='', $argMsgId='')
	{
		global $arrResidingStateList,$arrUSAStateList, $arrCountryList, $arrEducationList,$arrOccupationList,$varOnlineUser,$confValues,$varTable;

		$funServerUrl			= $this->funServerUrl;
		$funXtaLink				= '';
		$funInboxLink			= '';
		$funMatriId				= $varBasicDetails['ID'];
		$varBasicUserName		= $varBasicDetails['UN'];
		$varBasicName			= ($varBasicDetails['NN']!='') ? $varBasicDetails['NN']:$varBasicDetails['N'];
		$varBasicGender			= $varBasicDetails['G'] == 1?'Male':'Female';
		$arrDetail				= explode("^~^",$varBasicDetails['DE']);
		$varBasicAge			= $arrDetail[0];
		$varBasicCountry		= $arrDetail[10];
		$varBasicReligion		= $arrDetail[7];
		$varContentState		= $arrDetail[11];
		$varBasicResCity		= $arrDetail[12];
		$varBasicCasteDiv		= $arrDetail[8];
		$varBasicSubcaste		= $arrDetail[9];
		$varBasicEduDet			= $arrDetail[4];
		$varBasicOccDet			= $arrDetail[6];
		$varBasicHtUnit			= $arrDetail[1];

		if($argPurpose=='match' || $argPurpose=='photo') {
			$varBasicView		= $this->funMailerTplPath."/matchwatchbasic.tpl"; //do change (template file)
		} else if($argPurpose=='inbox_msg') {
			$varBasicView		= $this->funMailerTplPath."/inboxbasic.tpl"; //do change (template file)
			$funInboxLink		= '<a href="'.$this->funServerUrl.'/login/index.php?'.$varTrackDetail.'redirect='.$this->funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$funMatriId.'~msgfl=1~msgty=R~msgid='.$argMsgId.'" style="text-decoration:none; color:#FC4700;">Reply</a>&nbsp;&nbsp;&nbsp;<a href="'.$this->funServerUrl.'/login/index.php?'.$varTrackDetail.'redirect='.$this->funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$funMatriId.'~msgfl=1~msgty=R~msgid='.$argMsgId.'" style="text-decoration:none; color:#FC4700;">Decline</a>';
		} else if($argPurpose=='inbox_ei') {
			$varBasicView		= $this->funMailerTplPath."/inboxbasic.tpl"; //do change (template file)
			$funInboxLink		= '<a href="'.$this->funServerUrl.'/login/index.php?'.$varTrackDetail.'redirect='.$this->funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$funMatriId.'~msgfl=2~msgty=R~msgid='.$argMsgId.'" style="text-decoration:none; color:#FC4700;">Accept</a>&nbsp;&nbsp;&nbsp;<a href="'.$this->funServerUrl.'/login/index.php?'.$varTrackDetail.'redirect='.$this->funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$funMatriId.'~msgfl=2~msgty=R~msgid='.$argMsgId.'" style="text-decoration:none; color:#FC4700;">Decline</a>';
		}
		$varProfileBasicView	= $this->getContentFromFile($varBasicView);

		//religion & subcaste part
		if($arrDetail[14] == '1') {
			$cas_no_cont	= '(CasteNoBar)';
		} else {
			$cas_no_cont	= '';
		}

		if($arrDetail[15] == '1') {
			$sub_cas_no_cont	= '(SubcasteNoBar)';
		} else {
			$sub_cas_no_cont	= '';
		}

		if($arrDetail[7] !='') {
			$varBasicReligionSubcaste	= $arrDetail[7];
		} else {
			$varBasicReligionSubcaste	= '';
		}

		if($varBasicReligionSubcaste !='' && $arrDetail[16]!='') {
			$varBasicReligionSubcaste	.= ', '.$arrDetail[16];
		} else if($varBasicReligionSubcaste =='' && $arrDetail[16]!='') {
			$varBasicReligionSubcaste	.= $arrDetail[16];
		} else if($varBasicReligionSubcaste =='' && $arrDetail[16]=='') {
			$varBasicReligionSubcaste	.= '';
		}

		if($varBasicReligionSubcaste !='' && $arrDetail[8]!='') {
			$varBasicReligionSubcaste	.= ', '.$arrDetail[8].$cas_no_cont;
		} else if($varBasicReligionSubcaste =='' && $arrDetail[8]!='') {
			$varBasicReligionSubcaste	.= $arrDetail[8].$cas_no_cont;
		} else if($varBasicReligionSubcaste =='' && $arrDetail[8]=='') {
			$varBasicReligionSubcaste	.= '';
		}

		if($varBasicReligionSubcaste !='' && $arrDetail[9]!='') {
			$varBasicReligionSubcaste	.= ', '.$arrDetail[9].$sub_cas_no_cont;
		} else if($varBasicReligionSubcaste =='' && $arrDetail[9]!='') {
			$varBasicReligionSubcaste	.= $arrDetail[9].$sub_cas_no_cont;
		} else if($varBasicReligionSubcaste =='' && $arrDetail[9]=='') {
			$varBasicReligionSubcaste	.= '';
		}

		//Country part
		if($varBasicCountry != '' && $arrDetail[11] !='' && $arrDetail[11] !='0') {
			$ctry_stat			= $arrDetail[11].', '.$varBasicCountry;
		} else {
			$ctry_stat			= $varBasicCountry;
		}

		if($varBasicCountry != '' && $arrDetail[12] !='' && $arrDetail[12] !='0') {
			$ctry_st_ci			= $arrDetail[12].', '.$ctry_stat;
		} else {
			$ctry_st_ci			= $ctry_stat;
		}
		$varBasicCountry		= $ctry_st_ci;

		//Education Part
		if($arrDetail[3]!='') {
			$varContentEdu		= $arrDetail[3];
		} else {
			$varContentEdu		= '';
		}

		if($varContentEdu !='' && $arrDetail[4]!='') {
			$varContentEdu	.= ', '.$arrDetail[4];
		} else if($varContentEdu =='' && $arrDetail[4]!='') {
			$varContentEdu	.= $arrDetail[4];
		} else if($varContentEdu =='' && $arrDetail[4]=='') {
			$varContentEdu	.= '';
		}
		
		//Occupation part
		/*if($arrDetail[5]!='Others' && $arrDetail[5]!='') {
			$varContentOcc		= $arrDetail[5];
		} else {
			$varContentOcc		= '';
		}

		if($varContentOcc !='' && $arrDetail[6]!='') {
			$varContentOcc	.= ', '.$arrDetail[6];
		} else if($varContentOcc =='' && $arrDetail[6]!='') {
			$varContentOcc	.= $arrDetail[6];
		} else if($varContentOcc =='' && $arrDetail[6]=='') {
			$varContentOcc	.= '';
		}*/

		if($varContentEdu!=''&&$varContentOcc!='') {
			$varContentEduOcc	= $varContentEdu.', '.$varContentOcc;
		} else if($varContentEdu!=''&&$varContentOcc=='') {
			$varContentEduOcc	= $varContentEdu;
		} else if($varContentEdu==''&&$varContentOcc!='') {
			$varContentEduOcc	= $varContentOcc;
		}

		$varTrackDetail='';
		if($argMailerName!='') {
			$varTrackDetail	= $argTrackDtls.'&';
		}

		if ($varBasicDetails['PH'] == '') {
			//photo not available
			if($varBasicDetails['G']==2) { $funReqPhoto = $this->clsRequestPhotofImage; } else { $funReqPhoto = $this->clsRequestPhotomImage; }
			$funPhotoPath	= $this->funMailerImgPath.'/'.$funReqPhoto;
			$funPhotoLink	= $this->funServerUrl.'/login/index.php?'.$varTrackDetail.'redirect='.$this->funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$funMatriId;
		} else if($varBasicDetails['PH'] == 'P') {
			//photo available with protect status
			$funPhotoPath	= $this->funMailerImgPath.'/'.$this->clsProtectedPhotoImage; // Display Protectd Photo.
			$funPhotoLink	= $this->funServerUrl.'/login/index.php?'.$varTrackDetail.'redirect='.$this->funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$funMatriId;
		} else {
			//photo available
			$funFirstFolder		= substr($funMatriId,3,1);
			$funSecondFolder	= substr($funMatriId,4,1);
			$funPhotoPath		= $this->funImgsServerPath.'/membersphoto/'.$this->funFolderName.'/'.$funFirstFolder.'/'.$funSecondFolder.'/'.$varBasicDetails['PH'];
			$funPhotoLink		= $this->funServerUrl.'/login/index.php?'.$varTrackDetail.'redirect='.$this->funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$funMatriId;
		}

		$varProfileViewLink		= $this->funServerUrl."/login/index.php?".$varTrackDetail."redirect=".$this->funServerUrl."/profiledetail/index.php?act=viewprofile~id=".$funMatriId;
		
		
		if($argLink==1) {
			//paid member
			$funXtaLink			= '<a href="'.$this->funServerUrl.'/login/index.php?'.$varTrackDetail.'redirect='.$this->funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$funMatriId.'" style="text-decoration:none; color:#FC4700;">Send Message</a>';
			$funTransWidth		= "250";
		} elseif($argLink==0) { 
			//free member
			$funXtaLink			= '<a href="'.$this->funServerUrl.'/login/index.php?'.$varTrackDetail.'redirect='.$this->funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$funMatriId.'" style="text-decoration:none; color:#FC4700;">Express Interest FREE</a>';
			$funTransWidth		= "210";
		}else { $funXtaLink			= ''; }

		$funBasicXerox			= $varProfileBasicView;
		$funBasicXerox			= str_replace('<--NAME-->',$varBasicName,$funBasicXerox);
		$funBasicXerox			= str_replace('<--MATRIID-->',$funMatriId,$funBasicXerox);
		$funBasicXerox			= str_replace('<--AGE-->',$varBasicAge,$funBasicXerox);
		$funBasicXerox			= str_replace('<--HEIGHT-->',$varBasicHtUnit,$funBasicXerox);
		$funBasicXerox			= str_replace('<--RELIGION_SUBCASTE-->',$varBasicReligionSubcaste,$funBasicXerox);
		$funBasicXerox			= str_replace('<--COUNTRY-->',$varBasicCountry,$funBasicXerox);
		$funBasicXerox			= str_replace('<--EDUCATION_OCCU-->',$varContentEduOcc,$funBasicXerox);
		$funBasicXerox			= str_replace('<--PROFILE_VIEW_LINK-->',$varProfileViewLink,$funBasicXerox);
		$funBasicXerox			= str_replace('<--ACTION_LINK-->',$funXtaLink,$funBasicXerox);
		$funBasicXerox			= str_replace('<--INBOX_ACTION_LINK-->',$funInboxLink,$funBasicXerox);
		$funBasicXerox			= str_replace('<--TRANS_WIDTH-->',$funTransWidth,$funBasicXerox);
		$funBasicXerox			= str_replace('<--PHOTO_LINK-->',$funPhotoLink,$funBasicXerox);
		$funBasicXerox			= str_replace('<--PHOTO_PATH-->',$funPhotoPath,$funBasicXerox);
		
		return $funBasicXerox;
	}//mailBasicDetails
}
?>