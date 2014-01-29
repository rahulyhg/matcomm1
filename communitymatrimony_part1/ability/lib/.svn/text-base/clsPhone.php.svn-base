<?php
include_once($varRootBasePath."/lib/clsDB.php");
class Phone extends DB {
	public $arrViewedMyPhoneNo = array(); 

	//who viewed my phone number
	function viewedMyPhoneNo($argMatriId,$argStartLimit,$argNoOfLimit) {
		global $varTable;
		
		$funCondition			= "WHERE MatriId=".$this->doEscapeString($argMatriId,$this);
		$funViewedMyPhoneNoCnt	= $this->numOfRecords($varTable['PHONEVIEWLIST'], 'MatriId', $funCondition);

		if($funViewedMyPhoneNoCnt > 0) {
			$funFields		= array('Opposite_MatriId');
			$funCondition	= "WHERE MatriId=".$this->doEscapeString($argMatriId,$this)." ORDER BY Date_Viewed DESC LIMIT ".$argStartLimit.", ".$argNoOfLimit;
			$varResultSet	= $this->select($varTable['PHONEVIEWLIST'],$funFields,$funCondition,0);

			while($row	= mysql_fetch_assoc($varResultSet)) {
				$this->arrViewedMyPhoneNo[] = $row['Opposite_MatriId'];
			}
		}

		return $funViewedMyPhoneNoCnt;
	}

	//get total count for who viewed my phone no
	function getTotalCntWhoViewedMyPhNo($argMatriId) {
		global $varTable,$varDbInfo;
		$funViewedMyPhoneNoCnt = 0;

		$this->dbConnect('S',$varDbInfo['DATABASE']);

		if ($argMatriId !="") {
			$funCondition			= "WHERE MatriId=".$this->doEscapeString($argMatriId,$this);
			$funViewedMyPhoneNoCnt	= $this->numOfRecords($varTable['PHONEVIEWLIST'], 'MatriId', $funCondition);
		}

		$this->dbClose();

		return $funViewedMyPhoneNoCnt;
	}
}
?>