<?
/****************************************************************************************************
File	: adminhoroscopeapprove.php
Author	: Jeyak	umar
Date	: 25-Mar-2009
********************************************************************************************************
Description	: 
	Approve or delete the horoscope
********************************************************************************************************/

//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath."/lib/clsAdminValMailer.php");

//SESSION VARIABLES
//Object initialization
$objMasterDB		= new MemcacheDB;
$objAdminMailer		= new AdminValid;

$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

$varAddHoroList		= '';
$varDeleteHoroList	= '';
$varAddCount		= 0;
$varDelCount		= 0;

for ($i=1;$i<=20;$i++){
	if ($_POST['horoadddelete_'.$i] != ''){
		$arrPhotoDetail		= explode("_",$_POST['horoadddelete_'.$i]);

		//SETING MEMCACHE KEY
		$varOwnProfileMCKey= 'ProfileInfo_'.$arrPhotoDetail[0];
		
		//get folder name
		$varFolderName			= $objAdminMailer->getFolderName($arrPhotoDetail[0]);
		$arrDomainDtls			= $objAdminMailer->getDomainDetails($arrPhotoDetail[0]);

		if  ($arrPhotoDetail[2]=='add')  {
			$varHoroscopeName	= $_REQUEST['imagename'.$i];
			$varTempPath		= $varRootBasePath.'/www/pending-horoscopes/'.$varFolderName.'/'.$varHoroscopeName;
			$varDestinationpath	= $varRootBasePath.'/www/membershoroscope/'.$varFolderName.'/'.$arrPhotoDetail[0]{3}."/".$arrPhotoDetail[0]{4}."/";
			$varTempPath1		= $varDestinationpath.$varHoroscopeName;

			//Gernerating Random Values Starts Here
			$varChars   = array('a','b','c','d','e','f','g','h','i','j','m','n','q','r','t','u','y','A','B','C','D','E',
				 'F','G','H','I','J','K','L','M','N','P','Q','R','T','U','Y','1','2','3','4','5','6','7','8','9');
			$varLength  = 6;
			$varNumber  = "";
			$varRandom	= "";
			for($kk=0;$kk<$varLength;$kk++)
			{
				$varNumber 	= rand(0,(count($varChars)-1));
				$varRandom .=$varChars[$varNumber];
			}
			//Gernerating Random Values Ends Here
			$varNewNormalFile		= $arrPhotoDetail[0].'_'.$varRandom.'_HR'.'.jpg';
			$varNormalPath			= $varDestinationpath.$varNewNormalFile;
			copy($varTempPath,$varNormalPath);

			unlink($varTempPath);
			if(file_exists($varTempPath1))   // If horoscope status=2, 2 if condition will execute 
			unlink($varTempPath1);
			
			$varCondition		= " MatriId='".$arrPhotoDetail[0]."'";
			$varFields			= array('HoroscopeStatus','HoroscopeURL');
			$varFieldValues		= array(1,"'".$varNewNormalFile."'");
			$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues, $varCondition);

			$varFields			= array('Horoscope_Available');
			$varFieldValues		= array(1);
			$varUpdate			= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFieldValues, $varCondition, $varOwnProfileMCKey);	
			$varAddHoroList	   .= "<tr><td>".$arrPhotoDetail[0]."</td><td>".$arrPhotoDetail[1]."</td></tr>";

			//Request added intimation to user
			$objAdminMailer->dbConnect('M', $varDbInfo['DATABASE']);
			$objAdminMailer->requestAdded($arrPhotoDetail[0],5);
			
			$varAddCount++;
		
		} elseif  ($arrPhotoDetail[2]=='del')  {

			$varFields			= array('HoroscopeURL','HoroscopeStatus','Horoscope_Date_Updated','Horoscope_Protected','Horoscope_Protected_Password');
			$varCondition		= "WHERE MatriId = '".$arrPhotoDetail[0]."'";
			$varResult			= $objMasterDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
			$arrSelectHRInfo	= mysql_fetch_assoc($varResult);

			$varHoroscopeName	= $_REQUEST['imagename'.$i];
			$varMatriId			= $arrPhotoDetail[0];
			$varDelReason		= $_REQUEST['reason_'.$i];
			$vaUnLinkFileName	= $varRootBasePath."/www/pending-horoscopes/".$varFolderName.'/'.$varHoroscopeName;

			if(file_exists($vaUnLinkFileName))   
				unlink($vaUnLinkFileName);

			if($arrSelectHRInfo['HoroscopeStatus'] == 1 || $arrSelectHRInfo['HoroscopeStatus'] == 0) {
				$varFields			= array('HoroscopeURL','HoroscopeStatus','Horoscope_Date_Updated');
				$varFiledValues		= array("''",0,"NOW()");

				$varMIFields			= array('Horoscope_Available');
				$varMIFiledValues		= array(0);

			} else if($arrSelectHRInfo['HoroscopeStatus'] == 2) {
				$varFields			= array('HoroscopeStatus','Horoscope_Date_Updated');
				$varFiledValues		= array(1,"NOW()");

				$varMIFields			= array('Horoscope_Available');
				$varMIFiledValues		= array(1);
			}
			$varCondition		= " MatriId = '".$arrPhotoDetail[0]."'";
			$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledValues, $varCondition);
			$varFormResult		= $objMasterDB->update($varTable['MEMBERINFO'], $varMIFields, $varMIFiledValues, $varCondition, $varOwnProfileMCKey);
		
			$varDeleteHoroList	.= "<tr><td>".$arrPhotoDetail[0]."</td><td>".$arrPhotoDetail[1]."</td></tr>";
			$varMailedCount		= $varMailedCount + 1;
			$varToEmail			= $objMasterDB->getEmail($arrPhotoDetail[0]);
			$argSubject			= 'Your horoscope has been deleted from '.$arrDomainDtls['FROMADDRESS'];
			$argMessage			= $varDelReason;
			$varMailValue		= $objAdminMailer->sendNotifyEmail($varToEmail,$argMessage,$argSubject,$arrPhotoDetail[0]);
			$varDelCount++;
		}
	}
}
include_once("adminheader.php"); 
?>
<style type="text/css">@import url("<?=$confValues['CSSPATH'];?>/global-style.css"); </style>
<?
if ($varAddHoroList != ''){
	echo '<table border=0  class="smalltxt" width="60%" align="center"><tr><td colspan="2" height="30"><font class="mediumtxt boldtxt clr3">Added Horoscope</font></td></tr><tr><td colspan="2"> <div class="vdotline1" style="float: left; width: 480px; margin-top: 5px;"></div></td></tr><tr class="mediumtxt boldtxt"><td> MatriId</td><td>Photo  Number</td></tr>'.$varAddHoroList.'<tr  class="smalltxt boldtxt errortxt"><td>Total Added Photos</td><td>'.$varAddCount.'</td></tr><tr><td colspan="2"><div class="vdotline1" style="float: left; width: 480px; margin-top: 5px;"></div></td></tr></table>';
}
if ($varDeleteHoroList != '')
	echo '<table border=0  class="smalltxt"  width="60%" align="center"><tr><td colspan="2" height="30"><font class="mediumtxt boldtxt clr3">Deleted Horoscope</font></td></tr><tr><td colspan="2"> <div class="vdotline1" style="float: left; width: 480px; margin-top: 5px;"></div></td></tr><tr class="mediumtxt boldtxt" ><td> MatriId</td><td>Photo  Number</td></tr>'.$varDeleteHoroList.'<tr  class="smalltxt boldtxt errortxt"><td>Total Deleted Photos</td><td>'.$varDelCount.'</td></tr><tr><td colspan="2"><div class="vdotline1" style="float: left; width: 480px; margin-top: 5px;"></div></td></tr></table>';

$objMasterDB->dbClose();
unset($objAdminMailer);
unset($objMasterDB);
?>