<?php
##########################################################################################
##########################################################################################
#File Name		:	CBS paging
#Author Name	:	A.Kirubasankar
#Description	:	Paging Class
#
#
##########################################################################################

class clsPaging
{

	function displayPaging($totalNum,$linkURL,$offsetNum=1,$showNum=5)
	{
		$lowerLimit1 = round($showNum / 2) - 1;
		$lowerLimit = $_REQUEST[offset] - $lowerLimit1;
		if($lowerLimit < 0)
			$lowerLimit = 0;

		$upperLimit = $lowerLimit + $showNum;
		if($upperLimit > $totalNum)
			$upperLimit = $totalNum;
		$num = $lowerLimit;

		for($i=$lowerLimit;$i <= $upperLimit;$i = $i + $offsetNum)
		{
			$num++;
			if($num >= $lowerLimit && $num <= $upperLimit && $upperLimit <= $totalNum)
			{
				if($_REQUEST[offset] != $i)
				{
					$displayLink .= " <a href='$linkURL&offset=$i'>$num</a> ";
				}
				else
				{
					$displayLink .= "[ $num ]";
					$nextOffset = $i + 1;
					$prevOffset = $i - 1;
					$currNum = $i;
				}
			}
		}
		$displayLink .= " of $totalNum";
		
		if($_REQUEST[offset] != 0)
			$previousLink = " - <a href='$linkURL&offset=$prevOffset'>Prev</a> ";
		else
			$previousLink = " - Prev ";

		$displayLink .= $previousLink;
		
		if($nextOffset < $totalNum)
			$displayLink .= " | <a href='$linkURL&offset=$nextOffset'>Next</a>";
		else
			$displayLink .= " | Next";

	return $displayLink;
	}
}

?>