<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDE FILES
include_once($varBaseRoot.'/lib/clsBasicview.php');

Class Lists extends BasicView
{
	//MEMBER VARIABLES
	public $arrListIdsDet	= array();
	
	//Get Interest Details
	function getDaysTextInfo($argDate) 
	{
		$lst = split('[- :]',$argDate);
		$funCurrenttime = time();
		$funDifftime	= $funCurrenttime - strtotime(date("d-M-Y", mktime(0,0,0,$lst[1],$lst[2],$lst[0])));
		$funDays		= $funDifftime/(24*3600);

		if($funDays > 0 && $funDays <= 7) {
			return $funDaysTxtVal = (floor($funDays) <= 1 && date("d")==$lst[2]) ? "Today" : floor($funDays)." days ago";
		}else if($funDays > 7 && $funDays <= 30) {
			return $funDaysTxtVal = (floor($funDays/7) <= 1) ? "1 week ago" : floor($funDays/7)." weeks ago";
		}else if($funDays > 30 && $funDays <= 365) {
			return $funDaysTxtVal = (floor($funDays/30) <=1) ? "1 month ago" : floor($funDays/30)." months ago";
		}else if($funDays > 365) {
			return $funDaysTxtVal = (floor($funDays/365) <=1) ? "1 year ago" : floor($funDays/365)." years ago";
		}

	}//getLastLoginInfo

	//Get Interest Details
	function SelectListDetails($argTblName, $argCondition)
	{
		$funFields		= array('Opposite_MatriId', 'Comments', 'Date_Updated');

		$funReultSet	= $this->select($argTblName, $funFields, $argCondition, 0);

		$funArrIntDet	= array(); 

		$i = 0;
		while($row = mysql_fetch_assoc($funReultSet))
		{
			$this->arrListIdsDet[$i]	= $row['Opposite_MatriId'];
			$funArrIntDet[$i]['OID']	= $row['Opposite_MatriId'];
			$funArrIntDet[$i]['Com']	= $row['Comments']." ";
			$funArrIntDet[$i]['DU']		= $row['Date_Updated'];
			$i++;
		}
		return $funArrIntDet;
	}
	function getNumberOfFavourites() {
		global $varTable;
		$varTableName	= $varTable['BOOKMARKINFO'];
		$sessMatriId = $this->clsSessMatriId;
		$varWhere		= "WHERE MatriId=".$this->doEscapeString($sessMatriId,$this);
		$varTotalRecs	= $this->numOfRecords($varTableName, 'MatriId', $varWhere);
		return $varTotalRecs;
	}
	function getNumberBlocked() {
		global $varTable;
		$varTableName	= $varTable['BLOCKINFO'];
		$sessMatriId = $this->clsSessMatriId;
		$varWhere		= "WHERE MatriId=".$this->doEscapeString($sessMatriId,$this);
		$varTotalRecs	= $this->numOfRecords($varTableName, 'MatriId', $varWhere);
		return $varTotalRecs;
	}
}
?>
