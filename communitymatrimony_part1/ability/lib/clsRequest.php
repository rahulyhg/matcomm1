<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDE FILES
include_once($varBaseRoot.'/lib/clsBasicview.php');

Class Request extends BasicView
{
	//MEMBER VARIABLES
	public $arrReqIdsDet	= array();
	
	//Get Interest Details
	function SelectReqDetails($argTblName, $argFields, $argCondition,$argOption)
	{
		$funReultSet	= $this->select($argTblName, $argFields, $argCondition, 0);

		$funArrReqDet	= array(); 

		$i = 0;
		while($row = mysql_fetch_assoc($funReultSet))
		{
			if($argOption=='RR') { $rowField = $row['SenderId']; }
			else { $rowField = $row['ReceiverId']; }
			$this->arrReqIdsDet[$i]	= $rowField;
			$funArrIntDet[$i]['RID'] =	$row['RequestId'];
			$funArrIntDet[$i]['OID']	= $rowField;
			$funArrIntDet[$i]['RD']		= $row['RequestDate'];
			$i++;
		}
		return $funArrIntDet;
	}
}
?>