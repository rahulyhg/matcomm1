<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDE FILES
include_once($varBaseRoot.'/lib/clsBasicview.php');

Class Views extends BasicView
{
	//MEMBER VARIABLES
	public $arrViewsDet	= array();
	
	//Get Interest Details
	function SelectViewsDetails($argTblName, $argFields, $argCondition, $argViewsOption)
	{
		$funReultSet	= $this->select($argTblName, $argFields, $argCondition, 0);
		$funArrViewsDet	= array(); 

		$i = 0;
		while($row = mysql_fetch_assoc($funReultSet))
		{
			$this->arrViewsDet[$i]	= $row['Opposite_MatriId'];
			$funArrViewsDet[$i]['OID']	= $row['Opposite_MatriId'];
			$funArrViewsDet[$i]['DV']	= date('d M y', strtotime($row['Date_Viewed']));
			$i++;
		}
		return $funArrViewsDet;
	}
}
?>