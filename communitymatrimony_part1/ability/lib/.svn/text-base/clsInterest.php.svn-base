<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDE FILES
include_once($varBaseRoot.'/lib/clsBasicview.php');

Class Interest extends BasicView
{
	//MEMBER VARIABLES
	public $arrIntIdsDet	= array();
	
	//Get Interest Details
	function SelectIntDetails($argTblName, $argFields, $argCondition, $argIntOption)
	{
		$funReultSet	= $this->select($argTblName, $argFields, $argCondition, 0);

		$funArrIntDet	= array(); 

		$i = 0;
		while($row = mysql_fetch_assoc($funReultSet))
		{
			$this->arrIntIdsDet[$i]	= $row['Opposite_MatriId'];
			
			$funArrIntDet[$i]['IntID']	= $row['Interest_Id'];
			$funArrIntDet[$i]['OID']	= $row['Opposite_MatriId'];
			$funArrIntDet[$i]['IntOp']	= $row['Interest_Option'];

			if($argIntOption == 'IRN')
			{
				$funArrIntDet[$i]['DR']		= urlencode(date('d M y', strtotime($row['Date_Received'])));
			}
			else if($argIntOption == 'IRA')
			{
				$funArrIntDet[$i]['DR']		= urlencode(date('d M y', strtotime($row['Date_Received'])));
				$funArrIntDet[$i]['DA']		= urlencode(date('d M y', strtotime($row['Date_Acted'])));
			}
			else if($argIntOption == 'IRD')
			{
				$funArrIntDet[$i]['DR']		= urlencode(date('d M y', strtotime($row['Date_Received'])));
				$funArrIntDet[$i]['DA']		= urlencode(date('d M y', strtotime($row['Date_Acted'])));
				$funArrIntDet[$i]['DecOp']	= $row['Declined_Option'];
			}
			else if($argIntOption == 'ISN')
			{
				$funArrIntDet[$i]['DS']		= urlencode(date('d M y', strtotime($row['Date_Sent'])));
			}
			else if($argIntOption == 'ISA')
			{
				$funArrIntDet[$i]['DS']		= urlencode(date('d M y', strtotime($row['Date_Sent'])));
				$funArrIntDet[$i]['DA']		= $row['Date_Accepted'];
			}
			else if($argIntOption == 'ISD')
			{
				$funArrIntDet[$i]['DS']		= urlencode(date('d M y', strtotime($row['Date_Sent'])));
				$funArrIntDet[$i]['DA']		= urlencode(date('d M y', strtotime($row['Date_Accepted'])));
				$funArrIntDet[$i]['DecOp']	= $row['Declined_Option'];
			}

			$i++;
		}

		return $funArrIntDet;
	}
}
?>