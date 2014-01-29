<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-11-19
# End Date		: 2008-11-19
# Project		: MatrimonyProduct
# Module		: Mailer
#=============================================================================================================

//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

if($varRootBasePath == ''){ $varRootBasePath = '/home/product/community/ability'; }

//INCLUDE FILES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsMailerMatchWatch.php');

class Privilege extends MailerMatchWatch {

	public $clsViewTemplate		= "";
	public $varMatchWatchDate	= "";
	public $arrPartnerDetails	= array();
	public $funSiteName			= "";
	public $funServerUrl		= "";
	public $funProductName		= "";
	public $funMailerImgPath	= "";
	public $funReligionFeature	= "";
	public $funReligionArrayFeature= "";
	public $arrMWReligionList	= array();
	public $funDenomFeature		= "";
	public $funDenomArrayFeature= "";
	public $arrMWDenomList		= array();
	public $funCasteFeature		= "";
	public $funCasteArrayFeature= "";
	public $arrMWCasteList		= array();
	public $funSubcasteFeature	= "";
	public $funSubcasteArrayFeature= "";
	public $arrMWSubcasteList	= array();

	//SUBTRACT 2 DAYS FROM CURRENT DATE
	function getSubtractDate($varDays,$varMatchSentDateOnly) {
		$varCurrentDate	= strtotime($varMatchSentDateOnly);
	    $varMWTimeStamp	= $varCurrentDate - ($varDays * 86400); 
		$varMWDate		= date("Y-m-d",$varMWTimeStamp);
		return $varMWDate;
	}
    function getPhotoDetails($varCommunityId,$matriid,$obj) {
		global $varTable,$varDbInfo;
		$memberinfotbl=$varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'];	

		$argFields			= array('MatriId','Photo_Set_Status','Protect_Photo_Set_Status');
		$argCondition		= "WHERE CommunityId=".$varCommunityId." AND  MatriId=".$obj->doEscapeString($matriid,$obj);
		$arrPhotoResultSet	= $obj->select($memberinfotbl, $argFields, $argCondition, 0);
		$arrPhotoResult		= mysql_fetch_assoc($arrPhotoResultSet);
		
		//Get Photo Details Starts -->
		if($arrPhotoResult['Photo_Set_Status']==0)
		{
			$varReturnPhDetail = '';
		}
		else if($arrPhotoResult['Photo_Set_Status']==1 && $arrPhotoResult['Protect_Photo_Set_Status']==1)
		{
			$varReturnPhDetail = 'PP';
		}
		else if($arrPhotoResult['Photo_Set_Status']==1 && $arrPhotoResult['Protect_Photo_Set_Status']==0)
		{
			$funFields		= array('MatriId','Normal_Photo1','Thumb_Small_Photo1','Photo_Status1','Normal_Photo2','Thumb_Small_Photo2','Photo_Status2','Normal_Photo3','Thumb_Small_Photo3','Photo_Status3','Normal_Photo4','Thumb_Small_Photo4','Photo_Status4','Normal_Photo5','Thumb_Small_Photo5','Photo_Status5','Normal_Photo6','Thumb_Small_Photo6','Photo_Status6','Normal_Photo7','Thumb_Small_Photo7','Photo_Status7','Normal_Photo8','Thumb_Small_Photo8','Photo_Status8','Normal_Photo9','Thumb_Small_Photo9','Photo_Status9','Normal_Photo10','Thumb_Small_Photo10','Photo_Status10');
			$funCondition		= "WHERE MatriId=".$obj->doEscapeString($matriid,$obj);
			$resPhotoIdsDetRes = $obj->select($varTable['MEMBERPHOTOINFO'], $funFields, $funCondition, 0);
			$resPhotoIdsDet		= mysql_fetch_assoc($resPhotoIdsDetRes);
			$varReturnPhDetail = $resPhotoIdsDet['Normal_Photo1'].'~'.$resPhotoIdsDet['Thumb_Small_Photo1'];
		}
		//Get Photo Details Ends -->

		

	   return $varReturnPhDetail;
	}
	//TO GET SUBCASTE DETAIL
	function getCommunityWiseDtls($argDomainPrefix) {
		global $arrFolderNames,$arrPrefixDomainList,$arrMailerTplFolder;
		
		$this->funSiteName			= '';
		$this->funServerUrl			= '';
		$this->funProductName		= '';
		$this->funMailerImgPath		= '';
		$this->funMailerTplPath		= '';
		$this->funReligionFeature	= "";
		$this->funReligionArrayFeature= "";
		$this->arrMWReligionList	= array();
		$this->funDenomFeature		= "";
		$this->funDenomArrayFeature	= "";
		$this->arrMWDenomList		= array();
		$this->funCasteFeature		= "";
		$this->funCasteArrayFeature	= "";
		$this->arrMWCasteList		= array();
		$this->funSubcasteFeature	= '';
		$this->funSubcasteArrayFeature= '';
		$this->arrMWSubcasteList	= array();
		$this->arrPartnerDetails	= array();

		$this->funSiteName		= $arrPrefixDomainList[$argDomainPrefix];
		$this->funServerUrl		= 'http://www.'.$this->funSiteName;
		$this->funProductName	= ucfirst(str_replace('matrimony.com','',$this->funSiteName)).'Matrimony';
		$this->funMailerImgPath	= 'http://www.'.$this->funSiteName.'/mailer/images';
		$this->funImgsServerPath= 'http://img.'.$this->funSiteName;
		$this->funLogoPath		= 'http://img.'.$this->funSiteName.'/images/logo/'.$arrFolderNames[$argDomainPrefix];
		$varMailerTplPath		= ($arrMailerTplFolder[$argDomainPrefix]!='')?('/'.$arrMailerTplFolder[$argDomainPrefix]):'';
		$this->funMailerTplPath	= '/home/product/community/www/mailer/templates'.$varMailerTplPath;


		$varRootBasePath		= '/home/product/community/ability';
		include($varRootBasePath."/domainslist/".$arrFolderNames[$argDomainPrefix]."/conf.cil14");

		$this->funReligionFeature	= $_FeatureReligion;
		$this->arrMWReligionList	= $arrReligionList;
		if($this->funReligionFeature == 1) {
			$this->funReligionArrayFeature=sizeof($this->arrMWReligionList);
		}
		
		$this->funDenomFeature		= $_FeatureDenomination;
		$this->arrMWDenomList		= $arrDenominationList;
		if($this->funDenomFeature == 1) {
			$this->funDenomArrayFeature=sizeof($this->arrMWDenomList);
		}

		$this->funCasteFeature		= $_FeatureCaste;
		$this->arrMWCasteList		= $arrCasteList;
		if($this->funCasteFeature == 1) {
			$this->funCasteArrayFeature=sizeof($this->arrMWCasteList);
		}

		$this->funSubcasteFeature	= $_FeatureSubcaste;
		$this->arrMWSubcasteList	= $arrSubcasteList;
		if($this->funSubcasteFeature == 1) {
			$this->funSubcasteArrayFeature=sizeof($this->arrMWSubcasteList);
		}

	}
     //BASIC DISPLAY for Match Watch Mailer For Rm
	function mailMatchWatchBasicDetailsForRM($varBasicDetails,$argLink='')
	{
		global $arrResidingStateList,$arrUSAStateList, $arrCountryList, $arrEducationList,$arrOccupationList,$varOnlineUser,$confValues,$varTable,$arrMatriIdPre,$arrFolderNames;

		$varBasicView			= $this->funMailerTplPath."/partnerpref.tpl"; //do change (template file)
		
		$varProfileBasicView	= $this->getContentFromFile($varBasicView);
		$funServerUrl			= $this->funServerUrl;
				
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
		

        //Variable Declaration
		$arrFlippedMatriIdPre	= array_flip($arrMatriIdPre);
		$varPrefix				= substr($funMatriId,0,3);
	    $varCommunityId			= $arrFlippedMatriIdPre[$varPrefix];

		//getPhotoUel
	    $varPhotoUrl = 'http://img.'.$this->funSiteName.'/membersphoto/'.$arrFolderNames[$varPrefix];

		$varUserPhotoDetail	= $this->getPhotoDetails($varCommunityId,$funMatriId,$this);
		

		if($varUserPhotoDetail == 'PP') {
			$varReplacePhUrl	= $this->funImgsServerPath.'/images/img85_pro.gif';
		} else if($varUserPhotoDetail != '') {
			$arrUserPhotoDetail = explode('~',$varUserPhotoDetail);
			$varReplacePhUrl	= $varPhotoUrl.'/'.$funMatriId{3}.'/'.$funMatriId{4}.'/'.$arrUserPhotoDetail[0];
		} else {
			$varGenderImg		= ($varBasicDetails[0]['G']==1)?'img85_phnotadd_m.gif':'img85_phnotadd_f.gif';
			$varReplacePhUrl	= $this->funImgsServerPath.'/images/'.$varGenderImg;
		}
		//$varProfileViewLink		= $this->funServerUrl."/login/index.php?redirect=".$this->funServerUrl."/profiledetail/index.php?act=viewprofile~id=".$funMatriId;

		$varProfileViewLink		= $funServerUrl."/login/index.php?redirect=".$this->funServerUrl."/profiledetail/index.php?act=viewprofile~id=".$funMatriId;
		
		if($argLink==1) {
			//paid member
			$funXtaLink			= '<a href="'.$this->funServerUrl.'/login/index.php?redirect='.$this->funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$funMatriId.'" style="text-decoration:none; color:#FC4700;">Send Message</a>';
		} elseif($argLink==0) { 
			//free member
			$funXtaLink			= '<a href="'.$this->funServerUrl.'/login/index.php?redirect='.$this->funServerUrl.'/profiledetail/index.php?act=viewprofile~id='.$funMatriId.'" style="text-decoration:none; color:#FC4700;">Express Interest FREE</a>';
		}else { $funXtaLink			= ''; }

        $unsubscibeLink = $funServerUrl."/login/index.php?redirect=".$this->funServerUrl."/profiledetail/index.php?act=mailsetting";
		$funBasicXerox			= $varProfileBasicView;
		$funBasicXerox = str_replace("<--PHOTOURL-->",$varReplacePhUrl,$funBasicXerox);
		$funBasicXerox = str_replace("<--NAME-->",ucwords($varBasicName),$funBasicXerox);
		$funBasicXerox = str_replace("<--OPPNAME-->",ucwords($varBasicName),$funBasicXerox);
		$funBasicXerox = str_replace("<--OPPMATRIID-->",ucwords($funMatriId),$funBasicXerox);
		$funBasicXerox = str_replace("<--AGE-->",$varBasicAge,$funBasicXerox);
		$funBasicXerox = str_replace("<--HEIGHT-->",$varBasicHtUnit,$funBasicXerox);
		$funBasicXerox = str_replace("<--RELIGIOUS-->",$varBasicReligionSubcaste,$funBasicXerox);
		$funBasicXerox = str_replace("<--COUNTRY-->",$varBasicCountry,$funBasicXerox);
		$funBasicXerox = str_replace("<--EDUOCC-->",$varContentEduOcc,$funBasicXerox);
		$funBasicXerox = str_replace("<--MATRIID-->",$funMatriId,$funBasicXerox);
		$funBasicXerox = str_replace("<--PROFILEURL-->",$varProfileViewLink,$funBasicXerox);
		$funBasicXerox = str_replace('<--PRODUCT_NAME-->',$this->funProductName,$funBasicXerox);
		$funBasicXerox = str_replace('<--LOGO-->',$this->funLogoPath,$funBasicXerox);
		$funBasicXerox = str_replace('<--MAILERIMGSPATH-->',$this->funMailerImgPath,$funBasicXerox);
	    $funBasicXerox = str_replace('<--UNSUBSCRIBE_LINK-->',$unsubscibeLink,$funBasicXerox);
	
		return $funBasicXerox;
	}//mailBasicDetailsForRm
	
	//TO GET MATCH WATCH RM DETAILS
	function getMatchWatchRmRegularDetails($argPurpose,$varProfileBasicResultSet,$argPaidStatus)
	{
		for($i = 0; $i < sizeof($varProfileBasicResultSet); $i++)
		{
			$funDispBasic=$this->mailMatchWatchBasicDetailsForRM($varProfileBasicResultSet[$i],$argPaidStatus);
			$funDisplayBasicVal .= $funDispBasic; 
		}//while
		return $funDisplayBasicVal;		
	}//getMatchWatchRegularDetails
	#------------------------------------------------------------------------------------------------------------

}

?>