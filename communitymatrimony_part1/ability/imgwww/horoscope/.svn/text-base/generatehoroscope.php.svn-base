<?php

//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

//Object initialization
$objMasterDB	= new MemcacheDB;

//CONNECTION
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

$defaulthoro	= urldecode($_POST["DefaultHtml"]);
$minihoro		= urldecode($_POST["HtmlResult"]);
$varMatriId		= trim($_POST["Uid"]);
$varCurrentDate	= date('Y-m-d H:i:s');

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$varMatriId;

$varDomainPrefix	= substr($varMatriId,0,3);
$varFolderName		= $arrFolderNames[$varDomainPrefix];

// CHANGES ON 25FEB09 FOR STORING PLANETPOSITION,STAR,RASI,DOSA VALUE STARTS... new mapping array
$avtobmrasiarraymapping = array(1=>7,2=>11,3=>8,4=>3,5=>9,6=>2,7=>10,8=>12,9=>1,10=>5,11=>4,12=>6);
$planetposval			= trim($_POST["PlanetPos"]);
$str					= trim($_POST["DoshaValues"]);

$xml = simplexml_load_string($str);

$starvalpost = $xml->xpath('/DATA/STAR');
$rasivalpost = $xml->xpath('/DATA/BIRTHRASI');
$kujavalpost = $xml->xpath('/DATA/PAPARESULT/KUJADOSHA');
$rahuvalpost = $xml->xpath('/DATA/PAPARESULT/RAHUDOSHA');
$rasivalpost = $avtobmrasiarraymapping[trim($rasivalpost[0])];
$starval	= trim($starvalpost[0]); 
$rasival	= trim($rasivalpost); 
$kujaval	= trim($kujavalpost[0]);
$rahuval	= trim($rahuvalpost[0]);

// changes on 25feb09 for storing planetposition,star,rasi,dosa value ends...

// for updating the value of star while generating the horoscope based on the login member domain starts
//if(trim($domainarr["domainnameshort"]) == "tamil"){	$stchk = 2;}
//else if(trim($domainarr["domainnameshort"]) == "kerala"){$stchk = 1;}
//else{$stchk = 3;}
// for updating the value of star while generating the horoscope based on the login member domain ends.
$header = '<STYLE type=text/css>@font-face { font-family: '.$fontfamily.'; src:url(http://65.60.57.146/CBS/SMEXE/Webfonts/'.$fontname.');  }  </STYLE><link rel="stylesheet" href="'.$confValues['CSSPATH'].'/global-style.css"><link rel="stylesheet" href="'.$confValues['DOMAINCSSPATH'].'/global.css"> <script language="javascript">function cleardis(){document.getElementById("dis").innerHTML="<font size=1><font face=Verdana, Arial, Helvetica, sans-serif><b>Disclaimer:</b> All astrological calculations are based purely on scientific equations and not on any specific published almanac.  Therefore we shall not be responsible for decisions that may be taken by anyone based on this report.</font>";	window.print();}</script><table cellspacing=0 cellpadding=0 border=0 width="700"><tr><td valign="bottom" align="right"><div align="right"><font size="3"><a href="javascript:;" onClick="cleardis();"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#94663E">Print</font></a>&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1">';

//$header=$header.'<a href="http://'.$GLOBALS['BMIMAGEDOMAINPREFIX'].trim($domainname3).'matrimony.com/cgi-bin/horoonlinedownload.php?download_filename=MH'.$varMatriId.'.html&mid='.$varMatriId.'">';

	//$header=$header.'<font color="#94663E">Save</font></a>&nbsp;<a href="http://'.$downloadfont.'/downloadfonts.html" target="_blank" ><font color="#94663E">Download fonts</font></a>&nbsp;';
	$header=$header.'</div></td></tr></table>';

	$header=$header.'<div id="rndcorner" class="fleft"><div style="width:694px;"><div id="register" style="width:680px;"><div style="border-top:6px solid #EDEFEE;"></div><div class="middiv-pad"><div class="bl"><div class="br"><div class="tl"><div class="tr"><div style="padding:15px 15px 0px 15px !important;padding:1px 15px 0px 15px;"><div><div id="row1" class="normalrow" style="width:640px;">';

	$footer='</div><br clear="all"></div></div></div></div></div></div></div></div><b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b></div></div>';

	$footer=$footer.'<table cellspacing=0 cellpadding=0 border=0 width="650" align="right"><tr><td><div align="right"><a href="javascript:;" onClick="cleardis();"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#94663E">Print</font></a><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;';

	///$footer=$footer.'<a href="http://image.'.trim($domainname3).'matrimony.com/cgi-bin/horoonlinedownload.php?download_filename=MH'.$varMatriId.'.html&mid='.$varMatriId.'">';

	//$footer=$footer.'<font color="#94663E">Save</font></a>&nbsp;<a href="http://72.32.59.238/downloadfonts.html" target="_blank" ><font color="#94663E">Download fonts</font></a> &nbsp;</p></div></td></tr></table>';
	$footer=$footer.'</p></div></td></tr></table>';


	//$varMatriId = "M516695"; //new code
	$varHoroscopePath	= '';
	$varFileName		= "MH".$varMatriId.".html";  
	$varHoroscopePath			= '/home/product/community/www/membershoroscope/'.$varFolderName.'/'.$varMatriId{3}.'/'.$varMatriId{4};

	$regionalhoro = $varHoroscopePath."/".$varFileName;
	$fp=fopen($regionalhoro,"w");
	fwrite($fp,$minihoro);
	fclose($fp);

	$defname		= "MHENG".$varMatriId.".html"; 
	$englishhoro	= $varHoroscopePath."/".$defname;
	$fp				= fopen($englishhoro,"w");
	fwrite($fp,$defaulthoro);
	fclose($fp);

	//Modification12/12/2006
	$rasireg	= base64_decode($_POST["RegRasi"]);
	$navreg		= base64_decode($_POST["RegNavamsa"]);
	$rasieng	= base64_decode($_POST["EngRasi"]);
	$naveng		= base64_decode($_POST["EngNavamsa"]);

	$rfilename=$varHoroscopePath."/".$varMatriId.'RASI.gif';
	$fp=fopen($rfilename,"w");
	fwrite($fp,$rasireg);
	fclose($fp);

	$nfilename=$varHoroscopePath."/".$varMatriId.'NAVAMSA.gif';
	$fp=fopen($nfilename,"w");
	fwrite($fp,$navreg);
	fclose($fp);

	$rfilename=$varHoroscopePath."/".$varMatriId.'RASIENG.gif';
	$fp=fopen($rfilename,"w");
	fwrite($fp,$rasieng);
	fclose($fp);

	$nfilename=$varHoroscopePath."/".$varMatriId.'NAVAMSAENG.gif';
	$fp=fopen($nfilename,"w");
	fwrite($fp,$naveng);
	fclose($fp);
	
	// changes on 25feb09 for storing planetposition,star,rasi,dosa value starts...StarCheck field added on 28thMay09

	$varCondition	= " WHERE MatriId= ".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
	$varTotRecords	= $objMasterDB->numOfRecords($varTable['MEMBERPHOTOINFO'], 'Photo_Id', $varCondition);


	$varCondition	= " MatriId= ".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);

	if ($varTotRecords=='1') {

		$varFields		= array('HoroscopeStatus','HoroscopeURL','Horoscope_Date_Updated');
		$varFiledvalues	= array('3',"'".$varFileName."'","'".$varCurrentDate."'");
		$objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledvalues,$varCondition); 
	} else {

		$varFields		= array('MatriId','HoroscopeStatus','HoroscopeURL','Horoscope_Date_Updated');
		$varFiledvalues	= array($objMasterDB->doEscapeString($varMatriId,$objMasterDB),'3',"'".$varFileName."'","'".$varCurrentDate."'");
		$objMasterDB->insert($varTable['MEMBERPHOTOINFO'], $varFields, $varFiledvalues, 'MatriId'); 
	}


	//UPDATE STATUS TO MEMBERINFO TABLE
	$varFields		= array('Horoscope_Available');
	$varFiledvalues	= array('3');
	$objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFiledvalues,$varCondition, $varOwnProfileMCKey); 



	$varFields		= array('StarCheck','PlanetPositions','StarValue','RasiValue','KujaDosha','RahuDosha');
	$varFiledvalues	= array("'".$stchk."'",$objMasterDB->doEscapeString($planetposval,$objMasterDB),"'".$starval."'","'".$rasival."'","'".$kujaval."'","'".$rahuval."'");
	$objMasterDB->update($varTable['HORODETAILS'], $varFields, $varFiledvalues, $varCondition);

	$varHoroscopeDetails=$header.$minihoro.$footer;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=$PAGEVARS['PAGETITLE']?></title>
</head>
<body>
<?php

echo $varHoroscopeDetails;
echo '<body>';

$objMasterDB->dbClose();
?>