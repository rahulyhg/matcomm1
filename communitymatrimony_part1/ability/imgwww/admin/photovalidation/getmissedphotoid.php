<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		: 
#================================================================================================================
   # Description	: photo class use to resize photo and new photoname
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath."/lib/clsDB.php");
//SESSION VARIABLES
//Object initialization
$objSlaveDB			= new DB;
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
//print $varSlaveConn;
include_once("adminheader.php"); 


$varQuery = " SELECT A.MatriId,A.Name,A.Gender,A.User_Name,A.Paid_Status,B.Photo_Status1,B.Photo_Status2,B.Photo_Status3,B.Photo_Status4,B.Photo_Status5,B.Photo_Status5,B.Photo_Status7,B.Photo_Status8,B.Photo_Status9,B.Photo_Status10,Normal_Photo1,Thumb_Small_Photo1,Thumb_Big_Photo1,Normal_Photo2,Thumb_Small_Photo2,Thumb_Big_Photo2,Normal_Photo3,Thumb_Small_Photo3,Thumb_Big_Photo3,Normal_Photo4,Thumb_Small_Photo4,Thumb_Big_Photo4,Normal_Photo5,Thumb_Small_Photo5,Thumb_Big_Photo5,Normal_Photo6,Thumb_Small_Photo6,Thumb_Big_Photo6,Normal_Photo7,Thumb_Small_Photo7,Thumb_Big_Photo7,Normal_Photo8,Thumb_Small_Photo8,Thumb_Big_Photo8,Normal_Photo9,Thumb_Small_Photo9,Thumb_Big_Photo9,Normal_Photo10,Thumb_Small_Photo10,Thumb_Big_Photo10,Description1,Description2,Description3,Description4,Description5,Description6,Description7,Description8,Description9,Description10,B.Photo_Date_Updated  FROM  ".$varTable['MEMBERPHOTOINFO']." B, ".$varTable['MEMBERINFO']." A  WHERE A.MatriId = B.MatriId AND ((Photo_Status1 IN (0,2) AND Normal_Photo1 <> '' AND Thumb_Small_Photo1 <> '' AND Thumb_Big_Photo1 <> '' ) OR (Photo_Status2 IN (0,2) AND Normal_Photo2 <> '' AND Thumb_Small_Photo2 <> '' AND Thumb_Big_Photo2 <> '' ) OR (Photo_Status3 IN (0,2) AND Normal_Photo3 <> '' AND Thumb_Small_Photo3 <> '' AND Thumb_Big_Photo3 <> '' ) OR (Photo_Status4 IN (0,2) AND Normal_Photo4 <> '' AND Thumb_Small_Photo4 <> '' AND Thumb_Big_Photo4 <> '' ) OR (Photo_Status5 IN (0,2) AND Normal_Photo5 <> '' AND Thumb_Small_Photo5 <> '' AND Thumb_Big_Photo5 <> '' ) OR (Photo_Status6 IN (0,2) AND Normal_Photo6 <> '' AND Thumb_Small_Photo6 <> '' AND Thumb_Big_Photo6 <> '' ) OR (Photo_Status7 IN (0,2) AND Normal_Photo7 <> '' AND Thumb_Small_Photo7 <> '' AND Thumb_Big_Photo7 <> '' ) OR (Photo_Status8 IN (0,2) AND Normal_Photo8 <> '' AND Thumb_Small_Photo8 <> '' AND Thumb_Big_Photo8 <> '' ) OR (Photo_Status9 IN (0,2) AND Normal_Photo9 <> '' AND Thumb_Small_Photo9 <> '' AND Thumb_Big_Photo9 <> '' ) OR (Photo_Status10 IN (0,2) AND Normal_Photo10 <> '' AND Thumb_Small_Photo10 <> '' AND Thumb_Big_Photo10 <> '' )) AND   B.Photo_Date_Updated >  '0000-00-00 00:00:00'  AND A.Publish = 1 ORDER BY B.Photo_Date_Updated";
//print "<br>".$varQuery;
$varResult			=  mysql_query($varQuery,$objSlaveDB->clsDBLink);

$varCount		= 0;
$varRowCountt	= 0;
$varContent	= '';
$arrMissedId = array();
while ($row = mysql_fetch_assoc($varResult)) {	

		//Get Folder Name for corresponding MatriId
		$varPrefix			= substr($row['MatriId'],0,3);
		$varFolderName		= $arrFolderNames[$varPrefix];

		$varDomainPHPath	= $varRootBasePath."/www/membersphoto/".$varFolderName;	
		$varPhotoBupPath	= $varDomainPHPath."/backup/";
		$varPhotoCrop800	= $varDomainPHPath."/crop800/";
		$varPhotoCrop450	= $varDomainPHPath."/crop450/";
		$varPhotoCrop150	= $varDomainPHPath."/crop150/";
		$varPhotoCrop75		= $varDomainPHPath."/crop75/";
		
		for($i=1;$i<=10;$i++){
			if (($row['Photo_Status'.$i] == 0 || $row['Photo_Status'.$i] == 2) && trim($row['Normal_Photo'.$i]) != '' && trim($row['Thumb_Small_Photo'.$i]) != '' && $row['Thumb_Big_Photo'.$i] != '') {
				
				if (!file_exists($varPhotoCrop75.$row['Normal_Photo'.$i]) && !file_exists($varPhotoCrop150.$row['Thumb_Small_Photo'.$i]) && !file_exists($varPhotoCrop450.$row['Thumb_Big_Photo'.$i] )){
					$varCount++;
					$arrMissedId[$row['MatriId']] = $row['MatriId'].' --- '.$row['Photo_Date_Updated'];
				}
			}
		}
}
print(join($arrMissedId,"<BR>"));
?>