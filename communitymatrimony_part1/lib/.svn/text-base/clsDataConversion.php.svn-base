<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
if($varServerRoot == ''){
	$varServerRoot = '/home/product/community/www';
}
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot."/lib/clsDB.php");
include_once($varBaseRoot.'/conf/dbinfo.cil14');

class DataConversion extends DB
{
	//DB Connect
	function dbConnect($argHost, $argUser, $argPasswd, $argDBName) {
		$DBLink = mysql_connect($argHost, $argUser, $argPasswd);

		if(!is_resource($DBLink)) {
			return "DB_CONN_ERR";
		}else { $this->clsDBLink = $DBLink; }
		if($argDBName!='') {
			$clsDBSelect = mysql_select_db($argDBName,$DBLink);
			if (!$clsDBSelect) {
				return "DB_SEL_ERR";
			}
		}
	}//dbConnect
	
	#--------------------------------------------------------------------------------------------------------
	//GENERATE MATRIID
	function generateMatriId($argCommunityId, $argPrefix)
	{
		global $varDbInfo,$varTable;
		//UPDATE MatriId IN communitydba.matriidinfo
		$funQuery	= "INSERT INTO tempcommunitydba.".$varTable['MATRIIDINFO']."(CommunityId,MatriId) VALUES('".$argCommunityId."','')";
		mysql_query($funQuery);
		$funMatriId	= mysql_insert_id();
		$funMatriId	= $argPrefix.$funMatriId;
		return $funMatriId; 	
	}//generateMatriId
	#--------------------------------------------------------------------------------------------------------
	//CHECK ALREADY ADDED
	function checkAlreadyAdded($argMigratedId, $argDomainId)
	{
		global $varDbInfo,$varTable;

		//UPDATE MatriId IN communitydba.matriidinfo
		$funQuery	= "SELECT COUNT(MatriId) AS CNT FROM ".$varDbInfo['DATABASE'].'.'.$varTable['MEMBERINFO']." WHERE BM_MatriId='".$argMigratedId."' AND CommunityId=".$argDomainId;
		$funResult	= mysql_query($funQuery);
		$row		= mysql_fetch_assoc($funResult);
		$funCount	= $row['CNT']==0 ? 'no' : 'yes';
		return $funCount; 	
	}//checkAlreadyAdded

	#--------------------------------------------------------------------------------------------------------
	function createPassword()
	{
		$funChars		= array('a','b','d','e','f','g','h','i','j','m','n','q','r','t','u','y','A','B','D','E',
		     'F','G','H','I','J','K','L','M','N','P','Q','R','T','U','Y');
		$funTotalChars	= (count($funChars)-1);
		for($i=0;$i<7;$i++)
		{
			$funRandNumber 	= rand(0,$funTotalChars);
			$funRandomValue.= $funChars[$funRandNumber];
		}
		return $funRandomValue;
	}//createPassword
	#--------------------------------------------------------------------------------------------------------
	//CALCULATE DATE DIFFERENCE
	function dateDiff($argCurrentDate, $argPaidDate)
	{
		$VarArrPaidDate		= explode('-', $argPaidDate);
		$VarArrCurrentDate	= explode('-', $argCurrentDate);
		$VarStartDate		= gregoriantojd($VarArrPaidDate[0], $VarArrPaidDate[1], $VarArrPaidDate[2]);
		$VarEndDate			= gregoriantojd($VarArrCurrentDate[0], $VarArrCurrentDate[1], $VarArrCurrentDate[2]);
		return $VarEndDate - $VarStartDate;
	}//dateDiff
	#--------------------------------------------------------------------------------------------------------
	//Gernerating Random Values Starts Here
	function genRandValue()
	{
		$funChars   = array('a','b','c','d','e','f','g','h','i','j','m','n','q','r','t','u','y','A','B','C','D','E',
			 'F','G','H','I','J','K','L','M','N','P','Q','R','T','U','Y','1','2','3','4','5','6','7','8','9');
		$funNumber  = '';
		$funRandom	= '';
		for($i=0;$i<6;$i++)
		{
			$funNumber 	= rand(0,(count($funChars)-1));
			$funRandom .= $funChars[$funNumber];
		}
		return $funRandom;
	}//genRandValue
	#--------------------------------------------------------------------------------------------------------
}//DataConversion
?>
