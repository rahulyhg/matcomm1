<?php
/****************************************************************************************************
File	: videodelete.php
Author	: Senthilnathan
********************************************************************************************************/
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

//SESSION VARIABLES
$varMatriId		= $_REQUEST['ID'];

if($_POST['frmDeleteHoroscopeSubmit'] == 'yes' && $varMatriId != '')
{
	//Object initialization
	$objMasterDB	= new MemcacheDB;

	//SETING MEMCACHE KEY
	$varOwnProfileMCKey= 'ProfileInfo_'.$varMatriId;

	//CONNECTION DECLARATION
	$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

	$varCondition		= " WHERE MatriId =".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
	$varFields			= array('HoroscopeURL','HoroscopeStatus');
	$varResult			= $objMasterDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
	$varMemberinfo	 	= mysql_fetch_assoc($varResult);
	$varHRAvailable		= $varMemberinfo['HoroscopeURL'];
	$varHRStatus		= $varMemberinfo['HoroscopeStatus'];

	if ($varHRAvailable != '') {
		if($varHRStatus == 0 || $varHRStatus == 2) {
			$varTempPath	= $varRootBasePath."/www/pending-horoscopes/".$arrDomainInfo[$varDomain][2].'/';
		} else {
			$varTempPath	= $varRootBasePath."/www/membershoroscope/".$arrDomainInfo[$varDomain][2].'/'.$varMatriId{3}."/".$varMatriId{4}."/";
		}
		
		if(file_exists($varTempPath.$varHRAvailable)) {
			unlink($varTempPath.$varHRAvailable);
		}

		$varCondition		= "  MatriId =".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
		if($varHRStatus == 1 || $varHRStatus == 0) {
			$varFields			= array('HoroscopeURL','HoroscopeDescription','HoroscopeStatus','Horoscope_Protected','Horoscope_Protected_Password','Horoscope_Date_Updated');
			$varFieldsValues 	= array("''","''",0,0,"''","NOW()");

			$varMIFields		= array('Horoscope_Available','Horoscope_Protected','Date_Updated');
			$varMIFieldsValues 	= array(0,0,"NOW()");
			//MEMBERTOOLS LOGIN
			$varField = 0;
		} else if($varHRStatus == 2) {
			$varFields			= array('HoroscopeStatus','Horoscope_Date_Updated');
			$varFieldsValues 	= array(1,"NOW()");

			$varMIFields		= array('Horoscope_Available','Date_Updated');
			$varMIFieldsValues 	= array(1,"NOW()");
			//MEMBERTOOLS LOGIN
			$varField = 1;
		}
		
		$varUpdate			= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldsValues, $varCondition);
		$varUpdate			= $objMasterDB->update($varTable['MEMBERINFO'], $varMIFields, $varMIFieldsValues, $varCondition, $varOwnProfileMCKey);

		//MEMBERTOOL LOGIN
		//echo "field value".$varField;
		$varType  = 3;

		$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
		$varnewCmd  = 'php /home/product/community/www/membertoollog/membertoolcheck.php '.escapeshellarg($varMatriId)." ".escapeshellarg($varType)." ".escapeshellarg($varField).' &';	escapeexec($varnewCmd,$varlogFile);
			
		
		if ($varUpdate) {
			$varMessage	=   "Horoscope has been deleted successfully from your profile.";

		} else {
			$varMessage	=	"Could not process your request at the moment. Please try after some time.";
		}
	} else {
		$varMessage		= "Could not find Horoscope";
	}
	echo '<link rel="stylesheet"	href="'.$confValues['CSSPATH'].'/global-style.css"><div><div style="padding: 0px 20px 0px 20px;"><div style="padding:5px;" class="mediumtxt clr3"><b>Delete Photo</b></div> <div style="padding:10px;" class="divborder">'.$varMessage.'<br clear="all"><div class="fright" style="padding:5px 4px 3px 3px;" id="closebt"><input type="button" value="Close" class="button" onclick="parent.document.getElementById(\'divphotodelete\').style.display=\'none\';parent.window.location.href=\'adminmanagehoroscope.php?MATRIID='.$varMatriId.'\';" id="closebutton"></div></div></div>';exit;

	//UNSET OBJ
	$objMasterDB->dbClose();
	unset($objMasterDB);
} else {
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<div id="block">
	<form name="frmDeleteConfirmation" method="post" >
	<input type = "hidden" name="frmDeleteHoroscopeSubmit" value="yes">
	<input type = "hidden" name="ID" value="<?=$_REQUEST['ID'];?>">
		<div style="padding-left:10px;padding-top:10px;width:410px;">
			<div ><font class="mediumtxt clr3"><b>Delete Horoscope</b></font></div>
				<div class="divborder fleft" style="width:407px;">
					<div>
						<div class="fleft" style="padding-top:15px;padding-left:15px;"><font class="smalltxt">Are you surely want to delete this horoscope?</font>&nbsp;&nbsp;&nbsp;
							<input type="submit" name="Yes" value="Yes" class="button">
							<input type="button" name="No" value="No" onclick="window.parent.document.getElementById('divphotodelete').style.display='none';"  class="button" >
						</div><br clear="all">
						<div class="bheight"></div>
					</div>
				</div>
			</div>
		 </div>
	</form>
</div>
<? } ?>