<?php
Class Login extends DB
{
	function chumma()
	{
		return 1;
	}
	//CALCULATE DATE DIFFERENCE
	function dateDiff($argDateSeparator, $argCurrentDate, $argPaidDate)
	{
		$funArrPaidDate		= explode($argDateSeparator, $argPaidDate);
		$funArrCurrentDate	= explode($argDateSeparator, $argCurrentDate);
		$funStartDate		= gregoriantojd($funArrPaidDate[0], $funArrPaidDate[1], $funArrPaidDate[2]);
		$funEndDate			= gregoriantojd($funArrCurrentDate[0], $funArrCurrentDate[1], $funArrCurrentDate[2]);

		return $funEndDate - $funStartDate;
	}//dateDiff
}
?>