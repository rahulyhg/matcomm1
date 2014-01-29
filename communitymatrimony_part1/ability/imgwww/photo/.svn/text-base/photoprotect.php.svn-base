<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 28-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: photoprotect.php
#================================================================================================================
   # Description	: protected the photos
#================================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

$sessMatriId		= $varGetCookieInfo['MATRIID'];
$varPaidStatus		= $varGetCookieInfo["PAIDSTATUS"];
$varGender			= $varGetCookieInfo["GENDER"];

//Object Initilization
$objSlaveDB			= new MemcacheDB;
$objMasterDB		= new MemcacheDB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

$varOption		= $_REQUEST['option'];
$varFields		= array('Photo_Set_Status','Protect_Photo_Set_Status', 'Pending_Photo_Validation');
$varCondition	= " WHERE MatriId = ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
$varResult		= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
$arrPhotoInfoDetails = mysql_fetch_assoc($varResult);
$varProtectStatus	 = $arrPhotoInfoDetails['Protect_Photo_Set_Status'];
$varUpdate			 = 0;

if ($varOption =='Y' || $varOption =='N') {
	//if ($varPaidStatus == 1){
	if ($varGetCookieInfo["PHOTOSTATUS"]=='1' && $varGetCookieInfo["PHONEVERIFIED"]=='1') {
		if ($arrPhotoInfoDetails['Photo_Set_Status'] == 1) {
			$varFields			= array('Password');
			$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition, 0);
			$arrLoginInfo 		= mysql_fetch_assoc($varResult);
			$varPassword		=  trim($_REQUEST['password']);
			$varProtectPassword	=  trim($_REQUEST['repassword']);


			$varHoroFields		= array('Horoscope_Protected_Password');
			$varHoroscopeInfo	= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varHoroFields, $varCondition);
			$varHoroscopePassword=  trim($varHoroscopeInfo[0]['Horoscope_Protected_Password']);

			
			if ($varPassword != $varProtectPassword && $varOption == 'Y')
				$varProtectMsg	= "0~The Photo Password and Confirm Photo Password Should be Same.";
			elseif ($varPassword === $arrLoginInfo['Password'] && $varOption == 'Y'){
				$varProtectMsg	= "0~Your Photo-Password can't be same as your Profile Password. Please choose a different Photo-Password.";
			} elseif ($varPassword === $varHoroscopePassword && $varOption == 'Y'){
				$varProtectMsg	= "0~Your Photo-Password can't be same as your Horoscope Password. Please choose a different Photo-Password.";
			}			
			else{	
				$varFields1				= array('Protect_Photo_Set_Status');
				$varFields2				= array('Photo_Protected','Photo_Protect_Password');
				
				if($varOption == 'Y'){
					$varFieldValues1	= array("1");
					$varFieldValues2	= array("1","'".$varPassword."'");
					$varProtectMsg		= '1~Your photo password has been successfully created';
				}else{
					$varFieldValues1	= array("0");
					$varFieldValues2	= array("0","''");
					$varProtectMsg 		= '2~Your Photo password has been successfully removed.';
				}
				$varCondition			= " MatriId = ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
				$arrPhotoInfoDetailsRes	= $objMasterDB->update($varTable['MEMBERINFO'], $varFields1, $varFieldValues1, $varCondition, $varOwnProfileMCKey);
				$varPhotoinfoRes		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields2, $varFieldValues2, $varCondition);
			}
		}
		else if($arrPhotoInfoDetails['Pending_Photo_Validation'] == 1 && $arrPhotoInfoDetails['Photo_Set_Status'] == 0)
			$varProtectMsg	=	"0~Sorry, you can protect your photo only after it is validated.";
		else if($arrPhotoInfoDetails['Pending_Photo_Validation'] == 0 && $arrPhotoInfoDetails['Photo_Set_Status'] == 0)
			$varProtectMsg	=	"0~Sorry! Photo not uploaded cannot be protected.";

	}else{
		$varProtectMsg	=	"0~Only members who have added their photo and verified their phone number can use the protect photo. <a target='_blank' href='http://".$confValues['SERVERURL']."/profiledetail/index.php?act=primaryinfo' class='smalltxt clr1'> Click here to complete details</a>";
	}
}
$objSlaveDB->dbClose();
$objMasterDB->dbClose();
unset($objSlaveDB);
unset($objMasterDB);
echo $varProtectMsg;
?>