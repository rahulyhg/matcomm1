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
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
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

if($_POST['horoadddelete_1'] != ''){
	$arrPhotoDetail		= explode("_",$_POST['horoadddelete_1']);

	//SETING MEMCACHE KEY
	$varOwnProfileMCKey= 'ProfileInfo_'.$arrPhotoDetail[0];
	
	//get folder name
	$varFolderName			= $objAdminMailer->getFolderName($arrPhotoDetail[0]);
	$arrDomainDtls			= $objAdminMailer->getDomainDetails($arrPhotoDetail[0]);

	if  ($arrPhotoDetail[2]=='add')  {
		$varHoroscopeName	= $_REQUEST['imagename1'];
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
		
		$varCondition		= " MatriId=".$objMasterDB->doEscapeString($arrPhotoDetail[0],$objMasterDB);
		$varFields			= array('HoroscopeStatus','HoroscopeURL');
		$varFieldValues		= array(1,$objMasterDB->doEscapeString($varNewNormalFile,$objMasterDB));
		$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues, $varCondition);

		$varFields			= array('Horoscope_Available');
		$varFieldValues		= array(1);
		$varUpdate			= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFieldValues, $varCondition, $varOwnProfileMCKey);	
		$varAddHoroList	   .= "<tr><td>".$arrPhotoDetail[0]."</td><td>".$arrPhotoDetail[1]."</td></tr>";
		
		//MEMBERTOOL LOGIN
		$varMatriId = $arrPhotoDetail[0];
		$varType  = 3;
		$varField = 1;
		echo system('php /home/product/community/www/membertoollog/membertoolcheck.php '.escapeshellarg($varMatriId)." ".escapeshellarg($varType)." ".escapeshellarg($varField) ); 
			
		//Request added intimation to user
		$objAdminMailer->dbConnect('M', $varDbInfo['DATABASE']);
		$objAdminMailer->requestAdded($arrPhotoDetail[0],5);
		
		$varAddCount++;
		$varMsgTxt = 'added';
		$varTotCont = 'Added-';
	
	} elseif  ($arrPhotoDetail[2]=='del')  {

		$varFields			= array('HoroscopeURL','HoroscopeStatus','Horoscope_Date_Updated','Horoscope_Protected','Horoscope_Protected_Password');
		$varCondition		= "WHERE MatriId = ".$objMasterDB->doEscapeString($arrPhotoDetail[0],$objMasterDB);
		$varResult			= $objMasterDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
		$arrSelectHRInfo	= mysql_fetch_assoc($varResult);

		$varHoroscopeName	= $_REQUEST['imagename1'];
		$varMatriId			= $arrPhotoDetail[0];
		$varDelReason		= $_REQUEST['reason_1'];
		$vaUnLinkFileName	= $varRootBasePath."/www/pending-horoscopes/".$varFolderName.'/'.$varHoroscopeName;

		if(file_exists($vaUnLinkFileName))   
			unlink($vaUnLinkFileName);

		if($arrSelectHRInfo['HoroscopeStatus'] == 1 || $arrSelectHRInfo['HoroscopeStatus'] == 0) {
			$varFields			= array('HoroscopeURL','HoroscopeStatus','Horoscope_Date_Updated');
			$varFiledValues		= array("''",0,"NOW()");

			$varMIFields			= array('Horoscope_Available');
			$varMIFiledValues		= array(0);
			//MEMBERTOOL LOGIN
			$varField = 0;
		} else if($arrSelectHRInfo['HoroscopeStatus'] == 2) {
			$varFields			= array('HoroscopeStatus','Horoscope_Date_Updated');
			$varFiledValues		= array(1,"NOW()");

			$varMIFields			= array('Horoscope_Available');
			$varMIFiledValues		= array(1);
			//MEMBERTOOL LOGIN
			$varField = 1;

		}
		$varCondition		= " MatriId = '".$arrPhotoDetail[0]."'";
		$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledValues, $varCondition);
		$varFormResult		= $objMasterDB->update($varTable['MEMBERINFO'], $varMIFields, $varMIFiledValues, $varCondition, $varOwnProfileMCKey);

		//MEMBERTOOL LOGIN
		$varMatriId = $arrPhotoDetail[0];
		$varType  = 3;
		$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
		$varnewCmd  = 'php /home/product/community/www/membertoollog/membertoolcheck.php '.escapeshellarg($varMatriId)." ".escapeshellarg($varType)." ".escapeshellarg($varField).' &';	escapeexec($varnewCmd,$varlogFile);
		

		$varDeleteHoroList	.= "<tr><td>".$arrPhotoDetail[0]."</td><td>".$arrPhotoDetail[1]."</td></tr>";
		$varMailedCount		= $varMailedCount + 1;
		$varToEmail			= $objMasterDB->getEmail($arrPhotoDetail[0]);
		$argSubject			= 'Your horoscope has been deleted from '.$arrDomainDtls['FROMADDRESS'];
		$argMessage			= $varDelReason;
		$varMailValue		= $objAdminMailer->sendNotifyEmail($varToEmail,$argMessage,$argSubject,$arrPhotoDetail[0]);
		$varDelCount++;
		$varMsgTxt = 'deleted';
		$varTotCont = 'Rejected-'.addslashes($varDelReason);
	}
	$cookValue		= $_COOKIE['reportid'];
	$arrFields		= array('comments', 'validateddate','profilestatus','notifycustomer');
	$arrFieldVals	= array("CONCAT(comments, '-validated(".$varTotCont.")')", 'NOW()', "'".$varAddCount."'", "'".$varDelCount."'");
	$varWhereCond	= 'id='.$cookValue;
	$objMasterDB->update('support_validation_report', $arrFields, $arrFieldVals, $varWhereCond);
}

$objMasterDB->dbClose();
unset($objAdminMailer);
unset($objMasterDB);

if($_POST['bymatriid']!=''){
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<body >
<?include_once("adminheader.php");?>
<a name="top"></a>
<div style="padding-left:60px;"><div style="padding-bottom:10px;"><font class="mediumtxt clr3"><b>Horoscope Validated</b></font></div>
<div style="float:left; width:492px;border:1px solid #D3D3D3;" class="smalltxt">	
	<div style="padding: 20px;">
	<div style="text-align:left;" class="smalltxt">
		Congrats! You have successfully <?=$varMsgTxt?>.<br></div>	
		<div class="fright"><input type="button" class="button" name="addphotos"  value="Close" onClick="javascript:parent.window.close();">
</div><br clear="all">
</div>
<?
exit;
}else{
	header("Location:".$confValues['IMAGEURL'].'/admin1/horoscopevalidation/newhoroscopevalidation.php');exit;
}
?>