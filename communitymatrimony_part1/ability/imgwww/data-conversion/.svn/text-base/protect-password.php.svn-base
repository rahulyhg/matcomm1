<?php
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/ability/www';
}
$varBaseRootPath = dirname($varRootPath);

//INCLUDED FILES
include_once($varBaseRootPath."/lib/clsDataConversion.php");
include_once($varBaseRootPath.'/conf/dbainfo.inc');

//OBJECT DECLARTION
$objDC = new DataConversion;

//Connect DB
$objDC->dbConnect($varDbaServer, $varDbaInfo['USERNAME'], $varDbaInfo['PASSWORD'], $varDbaInfo['DATABASE']);

for($JJ=0; $JJ<1; $JJ++){
//GET DATAS FROM TEXT FILE - ('protect-photos-list.txt')
$varFileContent	= file($varRootPath.'/data-conversion/photo-protect-info'.$JJ.'.txt');
$varNoOfLines	= count($varFileContent);

for($i=0; $i<$varNoOfLines; $i++)
{
	$varProtectInfo	= split('~',$varFileContent[$i]);
	$varNewMatriId	= $varProtectInfo[0];
	$varPasswd		= trim($varProtectInfo[2],"\n");

	$varTableName	= $varDbaInfo['DATABASE'].'.comm_memberphotoinfo';
	$varCond		= "WHERE MatriId='".$varNewMatriId."'";
	$varUpdateCond	= "MatriId='".$varNewMatriId."'";

	$varRows		= $objDC->numOfRecords($varTableName, 'Photo_Id', $varCond);
	if($varRows == 1)
	{
		$varFields		= array('Photo_Protect_Password', 'Photo_Protected');
		$varFieldsValues= array("'".$varPasswd."'", 1);
		$objDC->update($varTableName, $varFields, $varFieldsValues, $varUpdateCond);

		$varTableName	= $varDbaInfo['DATABASE'].'.comm_memberinfo';
		$varFields		= array('Protect_Photo_Set_Status');
		$varFieldsValues= array(1);
		$objDC->update($varTableName, $varFields, $varFieldsValues, $varUpdateCond);
	}
}//for
}//for
//UNSET OBJECT
$objDC->dbClose();
unset($objDC);
?>