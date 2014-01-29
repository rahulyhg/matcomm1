<?php
#================================================================================================================
   # Author 		: Jeyakumar
   # Date			: 25-Mar-2009
   # Project		: MatrimonyProduct
   # Filename		: adminhoroscopeadd.php
#================================================================================================================
   # Description	: Admin can add, change or delete horoscope for particulr user
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath."/lib/clsAdminValMailer.php");

//SESSION VARIABLES
$varMatriId			= trim(strtoupper($_REQUEST['matriid']));

//Object initialization
$objSlaveDB			= new MemcacheDB;
$objMasterDB		= new MemcacheDB;
$objAdminMailer		= new AdminValid;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$varMatriId;


//Get Folder Name for corresponding MatriId
$varPrefix			= substr($varMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

//VARIABLE DECLARATION
$varPhotoSize		= $_FILES['newhoroscope']['size'];
$varUpPhotoError 	= (int)$_FILES['newhoroscope']['error'];
if (($_POST['frmAddPhotoSubmit'] == 'yes')  && ($varPhotoSize < $confValues['HOROSCOPEMAXSIZE'] ) &&  $varMatriId != '') {

	$varAction			= $_REQUEST["action"];
	$varHoroscopeName	= $_FILES['newhoroscope']['name'];
	$arrHoroscopeName	= split('\.',$varHoroscopeName);
	$varFileType		= strtolower($arrHoroscopeName[1]);
	$varErrorType		= '';
	$varFileExts		= array('gif','jpg','jpeg');
	$varSourceFile		= $_FILES['newhoroscope']['tmp_name'];
	$varDestinationpath	= $varRootBasePath."/www/membershoroscope/".$varFolderName.'/'.$varMatriId{3}."/".$varMatriId{4}."/";

	if (!in_array($varFileType,$varFileExts)) { // check the horoscope file format
		$varErrorType	= 'imageext';
		$varErrorMode	= 1;
	}
	else if ($_FILES['newhoroscope']['size'] > $confValues['HOROSCOPEMAXSIZE'] )	{ // check the horoscope file size
		$varErrorType	= 'imagesize';
		$varErrorMode	= 1;
	}
	else {

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

		$varNewNormalFile		= $varMatriId.'_'.$varRandom.'_HR'.'.jpg';
		$varNormalPath			= $varDestinationpath.$varNewNormalFile;
		
		$varHoroscopeUpload	=	@move_uploaded_file($varSourceFile, $varNormalPath);

		if (!$varHoroscopeUpload) {
			$varErrorType		= 'horoscopeerror';
			$varErrorMode		= 1;
		}else {
			$varCondition	= " WHERE MatriId= '".$varMatriId."'";

			//delete already added horoscope
			$varMPFields			= array('HoroscopeURL');
			$varMPResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varMPFields, $varCondition,0);
			$arrMemberPhotoinfo	 	= mysql_fetch_assoc($varMPResult);
			$varHRURLAvailable		= $arrMemberPhotoinfo['HoroscopeURL'];
			if(file_exists($varDestinationpath.$varHRURLAvailable)) {
				unlink($varDestinationpath.$varHRURLAvailable);
			}

			$varTotRecords	=	$objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], $argPrimary='MatriId', $varCondition);

			if ($varTotRecords > 0) {
				$varFields		= array('HoroscopeStatus','HoroscopeURL','Horoscope_Date_Updated');
				$varFiledvalues	= array(1,"'".$varNewNormalFile."'","NOW()");
				$varCondition	= "  MatriId= '".$varMatriId."'";
				$varUpdate		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledvalues, $varCondition);
			}else {				
				$varFields 		= array('MatriId','HoroscopeStatus','HoroscopeURL','Horoscope_Date_Updated');
				$varFieldValues	= array("'".$varMatriId."'",1,"'".$varNewNormalFile."'","NOW()");
				$varUpdate		= $objMasterDB->insert($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues);
			}

			//UPDATE MEMBERINFO
			$varFields		= array('Horoscope_Available','Date_Updated');
			$varFiledvalues	= array(1,"NOW()");
			$varCondition	= "  MatriId= '".$varMatriId."'";
			$varUpdate		= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFiledvalues, $varCondition, $varOwnProfileMCKey);

			$varSuccessMsg	= "Horoscope successfully added";
			
			//Request added intimation to user
			$objAdminMailer->dbConnect('M', $varDbInfo['DATABASE']);
			$objAdminMailer->requestAdded($varMatriId,5);
		}
	} 
	

} elseif ($confValues['HOROSCOPEMAXSIZE'] < $varPhotoSize ){
	$varErrorMode		= 1;
	$varErrorType		= 'imagesize';
	$varPhotoSize		= round($varPhotoSize / 1024);
	//print "<BR> ERROR MSG".$varErrorMsg; 
} elseif ($varUpPhotoError == 1){
	$varErrorMode		= 1;
	$varErrorType		= 'imageerror'; 
}
$objMasterDB->dbClose();
$objSlaveDB->dbClose();
$objAdminMailer->dbClose();
if ($varErrorMode == 1){ 
	$varRedirectUrl	= "adminhoroscopeerror.php?errortype=".$varErrorType."&imagesize=".$varPhotoSize."&MATRIID=".$varMatriId;
	echo '<script>window.location="'.$varRedirectUrl.'";</script>';
} else if ($varErrorMode == 0) {
?>
<!DOCTYPE HTML PUBLIC "//W3C//DTD HTML 4.0 Transitional//EN" >
<html>
<head>
	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
		<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
	</head>
	<body align="center">
	<?include_once("adminheader.php"); ?>
	<div id="main_div" style="width:550px;padding-left:40px;padding-top:5px;padding-bottom:10px;">
		<div class="mediumtxt boldtxt clr3">Add Horoscope</div><br clear="all">
		<div class="mediumtxt boldtxt clr3"><?=$varSuccessMsg;?></div><br clear="all">
		<div class="fleft"><a href=javascript:;  onclick='javascript:window.open("adminshowhoroscope.php?MATRIID=<?=$varMatriId;?>&PNO=1","viewphoto","height=600,width=800,scrollbars=yes");' class="clr1 pntr">View Horoscope</a></div>
	</div>
</body>
</html>
<?
}
?>