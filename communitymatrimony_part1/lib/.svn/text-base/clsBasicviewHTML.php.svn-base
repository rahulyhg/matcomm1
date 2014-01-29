<?php

$varRootBasePath = '/home/product/community';

//INCLUDED FILES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/conf/domainlist.cil14');


if ($confValues['DOMAINCONFFOLDER'] !="") {		
	include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
}//if

class BasicviewHTML {
	public $clsServerUrl			= '';
	public $clsImgsUrl				= '';
	public $clsPhotoUrl				= '';
	public $clsProtectedPhotoImage	= 'img50_pro.gif';
	public $clsRequestPhotofImage	= 'noimg50_f.gif';
	public $clsRequestPhotomImage	= 'noimg50_m.gif';
	public $clsSessMatriId			= '';

	function basicview($argBasicDetails,$tpl=NULL)
	{
		global $arrResidingStateList,$arrUSAStateList, $arrCountryList, $arrEducationList,$arrOccupationList,$varOnlineUser,$confValues,$varTable;
			//,$arrFolderNames;

		$funRecordCount = count($argBasicDetails);

		for($i=0;$i<$funRecordCount;$i++) {

		$varBasicDetails = $argBasicDetails[$i];	

		$funMatriId				= $varBasicDetails['ID'];
		$varBasicUserName		= $varBasicDetails['UN'];
		$varBasicName			= ($varBasicDetails['NN']!='') ? $varBasicDetails['NN']:$varBasicDetails['N'];
		$varBasicGender			= $varBasicDetails['G'] == 1?'Male':'Female';
		$arrDetail				= explode("^~^",urldecode($varBasicDetails['DE']));
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

		if($varBasicReligionSubcaste !='' && $arrDetail[18]!='') {
			$varBasicReligionSubcaste	.= ', '.$arrDetail[18];
		} else if($varBasicReligionSubcaste =='' && $arrDetail[18]!='') {
			$varBasicReligionSubcaste	.= $arrDetail[18];
		} else if($varBasicReligionSubcaste =='' && $arrDetail[18]=='') {
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
		
		if($varContentEdu!=''&&$varContentOcc!='') {
			$varContentEduOcc	= $varContentEdu.', '.$varContentOcc;
		} else if($varContentEdu!=''&&$varContentOcc=='') {
			$varContentEduOcc	= $varContentEdu;
		} else if($varContentEdu==''&&$varContentOcc!='') {
			$varContentEduOcc	= $varContentOcc;
		}


		if ($varBasicDetails['PH'] == '') {
			//photo not available
			if($varBasicDetails['G']==2) { $funReqPhoto = $this->clsRequestPhotofImage; } else { $funReqPhoto = $this->clsRequestPhotomImage; }
			$funPhotoPath	= $this->clsImgsUrl.'/'.$funReqPhoto;
			$funPhotoLink	= $this->redirectPhotoURL($funMatriId);
		} else if($varBasicDetails['PH'] == 'P') {
			//photo available with protect status
			$funPhotoPath	= $this->clsImgsUrl.'/'.$this->clsProtectedPhotoImage; // Display Protectd Photo.
			$funPhotoLink	= $this->redirectPhotoURL($funMatriId);
		} else {
			//photo available
			$funFirstFolder		= $funMatriId{3};
			$funSecondFolder	= $funMatriId{4};
			$funPrefix			= substr($funMatriId,0,3);
			//$varFolder			= strtolower($arrFolderNames[$funPrefix]);
			$funPhotoPath		= $this->clsPhotoUrl.'/'.$funFirstFolder.'/'.$funSecondFolder.'/'.$varBasicDetails['PH'];
			$varExplode	=  explode('^',$funPhotoPath);
			$funPhotoPath	= $varExplode[0];

//http://www.yadavmatrimony.com/membersphoto/yadav/1/3/YDV136644_2rqqTC_NL_1.jpg%5EYDV136644_2yEGfc_NL_2.jpg

			$funPhotoLink	= $this->redirectPhotoURL($funMatriId);
		}


		
		//FOR COMMUNITY SEARCH PURPOSE
		if($tpl=='')
		$varBasicView			= $confValues['MAILTEMPLATEPATH']."/rsscommunity.tpl"; //do change (template file)
		else
		$varBasicView			= $confValues['MAILTEMPLATEPATH']."/rssregister.tpl"; //do change (template file)

		$funBasicXerox			= $this->getContentFromFile($varBasicView);
		$funBasicXerox			= str_replace('<--NAME-->',urldecode($varBasicName),$funBasicXerox);
		$funBasicXerox			= str_replace('<--MATRIID-->',$funMatriId,$funBasicXerox);
		$funBasicXerox			= str_replace('<--AGE-->',$varBasicAge,$funBasicXerox);
		$funBasicXerox			= str_replace('<--HEIGHT-->',$varBasicHtUnit,$funBasicXerox);
		$funBasicXerox			= str_replace('<--RELIGION_SUBCASTE-->',$varBasicReligionSubcaste,$funBasicXerox);
		$funBasicXerox			= str_replace('<--COUNTRY-->',$varBasicCountry,$funBasicXerox);
		$funBasicXerox			= str_replace('<--EDUCATION_OCCU-->',$varContentEduOcc,$funBasicXerox);
		$funBasicXerox			= str_replace('<--PROFILE_VIEW_LINK-->',$this->redirectProfileURL($funMatriId),$funBasicXerox);
		$funBasicXerox			= str_replace('<--PHOTO_LINK-->',$funPhotoLink,$funBasicXerox);
		$funBasicXerox			= str_replace('<--PHOTO_PATH-->',$funPhotoPath,$funBasicXerox);

		 echo $funBasicXerox;
		}

	}//mailBasicDetails

	function redirectPhotoURL($argOppMatriId){

	$varLoginURL	= $this->clsServerUrl."/login/index.php?page=rsscomm";
	$varViewProfile	= $this->clsServerUrl."/profiledetail/index.php?act=fullprofilenew";

		if ($this->clsSessMatriId ==''){

			$varViewProfile	= $varLoginURL."&redirect=".$varViewProfile."~id=".$argOppMatriId;

		} else { $varViewProfile = $varViewProfile."&id=".$argOppMatriId; }
		return $varViewProfile;

	}

	//========================================================================

	function redirectProfileURL($argOppMatriId){

	$varLoginURL1	= $this->clsServerUrl."/login/index.php?";
	$varLoginURL	= $this->clsServerUrl."/register/index.php?";
	$varViewProfile	= $this->clsServerUrl."/profiledetail/index.php?act=fullprofilenew";
		
		if ($this->clsSessMatriId ==''){

			//$varViewProfile	= $varLoginURL."&redirect=".$varViewProfile."~id=".$argOppMatriId;
			$varViewProfile	= $varLoginURL."regid=".$argOppMatriId;

		} else { 
			//$varViewProfile = $varViewProfile."&id=".$argOppMatriId; 
			$varViewProfile	= $varLoginURL1."redirect=".$varViewProfile."~id=".$argOppMatriId;
		}
		return $varViewProfile;

	}


	function getContentFromFile($argFileName){
		if(!file_exists($argFileName))
			echo 'Error: This file does not exist.';
		else
			return trim(file_get_contents($argFileName));
	}

}
?>