<?php
//FILE INCLUDES
include_once('/home/product/community/ability/conf/config.inc');
include_once('/home/product/community/ability/conf/ip.inc');
include_once('/home/product/community/ability/conf/dbinfo.inc');
include_once('/home/product/community/ability/lib/clsDB.php');

$objDB		= new DB;

$objDB->dbConnect('M', $varDbInfo['DATABASE']);

$varQuery	= "SELECT A.Email, B.Country, A.MatriId, B.Nick_Name, B.Name FROM communitymatrimony.memberlogininfo A, communitymatrimony.memberinfo B WHERE A.MatriId=B.MatriId AND A.CommunityId >0 AND B.Paid_Status=0 AND B.Publish<=2 AND B.CommunityId in (3,294,281,9,10,12,13,14,15,296,17,22,33,34,36,301,37,38,43,302,49,307,26,313,67,71,77,81,320,82,83,85,89,90,97,99,106,109,132,329,138,142,331,146,149,156,160,161,170,171,173,178,198,343,202,210,212,218,225,226,236,237,239,357,122,315,6,164,673,11,16,57,78,95,325,114,131,143,144,172,204,206,213,64,24,107,151,209,227,31,45,47,303,310,62,312,65,29,317,69,72,84,321,326,113,118,328,126,128,150,155,358,165,169,176,217,220,21,39,48,53,60,92,101,102,119,141,145,211,238,7,44,50,311,91,152,175,351,353,120,5,295,297,18,30,41,51,304,305,306,66,80,86,96,111,117,123,125,147,334,340,179,197,203,208,221,323,148,163,32,46,61,318,68,75,94,158,344,201,205,1,19,56,73,108,110,115,166,167,168,174,223,200,298,339,42,52,55,250,314,70,98,112,116,129,134,330,333,335,157,336,162,338,293,207,346,348,215,216,219,222,235,356,25,74,76,54,88,214,309,673,2502,2501,2504,254,255,256,257,245,260,261,251,252,130,263,264,337,265,266,267,240,242,63,299,241,248,100,327,243,246,268,247,244,249,271,272,274,105,275,276,278,280,349,259,258,233,234,20,269,270,273,322,283,253,284,224,286,287,288,289,347,291,319,121,292,285,231,354,277) ORDER BY B.Date_Created DESC";


$varResult  = mysql_query($varQuery) OR die('error');
$varNo		= mysql_num_rows($varResult);

//FILE NAME
$varFilename= date('Ymd').'_makar.txt';
$varContent	= '';

//DELETE FILE
@unlink($varFilename);

//CREATE FILE
$varFileHandler	= fopen($varFilename,"w");

while($row = mysql_fetch_assoc($varResult)) {

	$varNickName	= $row['Nick_Name'];
	$varName		= $varNickName ? $varNickName : $row['Name'];

	$varContent .= $row['Email'].'~'.$row['Country'].'~'.$row['MatriId'].'~'.$varName."\n";

	//padmanaban@consim.com~98~CHI100377~Padhu

}
fwrite($varFileHandler,$varContent);
fclose($varFileHandler);
?>