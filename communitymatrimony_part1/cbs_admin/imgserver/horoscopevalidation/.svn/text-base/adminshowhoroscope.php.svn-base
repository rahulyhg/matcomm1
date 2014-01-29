<?php
#================================================================================================================
   # Author 		: Jeyakumar
   # Date			: 24-Mar-2009
   # Project		: MatrimonyProduct
   # Filename		: adminshowhoroscope.php
#================================================================================================================
   # Description	: Display the horoscope of the particular user
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
//SESSION VARIABLES
$sessMatriId= $_REQUEST['id'];

//Object initialization
$objSlaveDB	= new MemcacheDB;
$objMasterDB= clone $objSlaveDB;


//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($sessMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

$varFields			= array('HoroscopeURL','HoroscopeStatus','Horoscope_Date_Updated','Horoscope_Protected','Horoscope_Protected_Password');
$varCondition		= "WHERE MatriId = ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
$varSelectHRInfo	= mysql_fetch_assoc($varResult);

$cookValue			= $_COOKIE['reportid'];
$arrFields			= array('comments');
$arrFieldVals		= array("CONCAT(comments, '-viewed')");
$varWhereCond		= 'id='.$objMasterDB->doEscapeString($cookValue,$objMasterDB);
$objMasterDB->update('support_validation_report', $arrFields, $arrFieldVals, $varWhereCond);
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<div style="width:880px;margin:10px;">
<div class="fleft" style="width:"640">
	<? if ($varSelectHRInfo['HoroscopeURL'] != ''){?>
	<table border="0" cellpadding="0" cellspacing="0" width="640">
		<tr><td colspan=4>
			<div class="fleft">
				<img src="<?=$confValues['IMGSURL'];?>/logo.gif" ></div>
			</td>
		</tr>
		<tr><td style="padding-top:5px;"colspan=4>
				<div class="vdotline1"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" height="1"
				></div></td>
		</tr>
		<tr colspan=4>
			<td valign="top" align="center" colspan="4">
				<?	if (($varSelectHRInfo['HoroscopeStatus'] == 1 )  && file_exists($varRootBasePath."/www/membershoroscope/".$varFolderName.'/'.$sessMatriId{3}."/".$sessMatriId{4}."/".$varSelectHRInfo['HoroscopeURL'])) {	
				?>
					<div style="padding-top:10px; padding-right:5px;">
						<img src="<?=$confValues['IMAGEURL']?>/membershoroscope/<?=$varFolderName.'/'.$sessMatriId{3}.'/'.$sessMatriId{4}.'/'.$varSelectHRInfo['HoroscopeURL'];?>" border=0><br clear="all"><font class="smalltxt clr1">&nbsp;</font>
					</div>
				<? } elseif (($varSelectHRInfo['HoroscopeStatus'] == 0 || $varSelectHRInfo['HoroscopeStatus'] == 2 )  &&  file_exists($varRootBasePath."/www/pending-horoscopes/".$varFolderName.'/'.$varSelectHRInfo['HoroscopeURL'])) { ?>
					<div style="padding-top:10px; padding-right:5px;">
						<img src="<?=$confValues['IMAGEURL']?>/pending-horoscopes/<?=$varFolderName.'/'.$varSelectHRInfo['HoroscopeURL'];?>" border=0><br clear="all"><br clear="all"><font class="smalltxt">Under validation</font>
					</div>
				<?	} ?>
			</td> 
			</tr> 
			<tr>  <td>&nbsp;</td> <td>&nbsp;</td></tr>
			<tr><td colspan=4 style="padding-top:5px;">
				<div class="vdotline1"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" height="1"></div>
			</td></tr>
		</table>
	<? }
	$objSlaveDB->dbClose();
	$objMasterDB->dbClose();
	?>
	</div>
</div>