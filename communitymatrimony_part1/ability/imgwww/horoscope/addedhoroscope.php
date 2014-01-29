<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
#================================================================================================================

 //UPLOAD THE  HOROSCOPE FILE START HERE
if ($_REQUEST['frmFileUploadSubmit'] == 'yes') {

	$varUploadHoroscopeMsg			= '';
	$varHoroscopeName	= $_FILES['horoscopeupload']['name'];
	$arrHoroscopeName	= split('\.',$varHoroscopeName);
	$varFileType		= strtolower($arrHoroscopeName[1]);
	$varFileExts		= array('gif','jpg','jpeg');
	$varHRConvertedName	= $sessMatriId."_Horoscope.".$varFileType;
	$varDestination		= $varServerRoot.'/pending-horoscopes/'.$arrDomainInfo[$varDomain][2].'/'.$sessMatriId."_Horoscope.".$varFileType;
	$varSourceFile		= $_FILES['horoscopeupload']['tmp_name'];
	if (!in_array($varFileType,$varFileExts)) { // check the horoscope file format

			$varUploadHoroscopeMsg	= '<center><div class="errortxt">Please upload your horoscope in gif, jpg or jpeg format only.</div></center>';
	}
	else if($_FILES['horoscopeupload']['size'] > $confValues['HOROSCOPEMAXSIZE'] )	{ // check the horoscope file size
			$varUploadHoroscopeMsg	= '<center><div class="errortxt">Sorry, your file size should not be more than 300KB.</div></center>';
	}
	else {

		$varHRStatus	= ($varHoroscopeStatus == '1' && $varHoroscopeURL != '') ? 2 : 0;
		$varHoroscopeUpload	= @move_uploaded_file($varSourceFile, $varDestination);

		if (!$varHoroscopeUpload) {

			$varUploadHoroscopeMsg	= '<center><div class="errortxt">Sorry, unable to upload horoscope file.Please try again</div></center>';

		}else {

			$varTotRecords	= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], 'MatriId', $varCondition);

			if ($varTotRecords=='1') {
				$varFields		= array('HoroscopeStatus','HoroscopeURL','Horoscope_Date_Updated');
				$varFiledvalues	= array($varHRStatus,"'".$varHRConvertedName."'","NOW()");
				$varCondition	= " MatriId= ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
				$varUpdate		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledvalues, $varCondition);
			}else {				
				$varFields 		= array('MatriId','HoroscopeStatus','HoroscopeURL','Horoscope_Date_Updated');
				$varFieldValues	= array($objMasterDB->doEscapeString($sessMatriId,$objMasterDB),$varHRStatus,"'".$varHRConvertedName."'","NOW()");
				$varUpdate		= $objMasterDB->insert($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues);
			}

			if($varUpdate != '') {
				$varUploadHoroscopeMsg	= '<center><div class="brdr pad10 tlleft smalltxt" style="width:500px;background-color:#efefef;">Thank you for uploading your horoscope. Any uploaded image has to go through a manual screening process before it is added to your profile. This usually takes a few of hours.<br/><br/><font class="opttxt">Note: Please note that it will be added to your profile only after validation, which usually takes 48 hours</font></div></center><br><br>';
				$varHoroscopeURL	= '';
				$varHoroscopeStatus	= '0';
			}
		}
	}
}
if ($varHoroscopeURL !='' && ($varHoroscopeStatus=='0' || $varHoroscopeStatus=='2')) {
	$varUploadHoroscopeMsg	= '<center><div class="alerttxt">Your horoscope under validation.</div></center>';
}

?>