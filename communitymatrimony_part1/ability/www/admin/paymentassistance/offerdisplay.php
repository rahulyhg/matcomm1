<?php
//offer display function 

function offerdisplay($Minper,$Maxper,$productid)
//function offerdisplay($Minper,$Maxper,$castenew,$ccode,$productid)
{
	$Minper = getsplitvaluesnew($Minper,$productid);
	$Maxper = getsplitvaluesnew($Maxper,$productid);
	$OfferStatus="<table width='100%' border=0   style='border: 1px solid #d1d1d1;'>";
	if($Minper != 'null' && $Maxper != 'null')
	{
		$OfferStatus.="<tr><td width='35%'  class='textsmallnormal'  style='border: 1px solid #d1d1d1;background-color:#efefef;' colspan=2><b>Discount Given : ".$Minper."&nbsp;%&nbsp;; Max Discount : ".$Maxper."&nbsp;%</b></td>";
		$OfferStatus.="</tr>";
	}
	if($Minper == 'null' && $Maxper != 'null')
	{
		$OfferStatus.="<tr><td width='35%'  class='textsmallnormal'  style='border: 1px solid #d1d1d1;background-color:#efefef;' colspan=2><b>No Discount Given &nbsp;%&nbsp;; <br>Max Discount : ".$Maxper."&nbsp;%</b></td>";
		$OfferStatus.="</tr>";
	}
	/*
	if($Minper != 'null' && $Maxper == 'null')
	{
		$OfferStatus.="<tr><td width='35%'  class='textsmallnormal'  style='border: 1px solid #d1d1d1;background-color:#efefef;' colspan=2><b>Discount Given:".$Minper."&nbsp;%&nbsp;; <br>Max Discount: ".$Maxper."&nbsp;%</b></td>";
		$OfferStatus.="</tr>";
	}
	*/
$OfferStatus.="</table><br>";
//return $OfferStatus;
$OfferStatus1 = array();
$OfferStatus1[0] = $OfferStatus;
$OfferStatus1[1] = $Minper;
return $OfferStatus1;
}
//get min and max discount 
function getsplitvaluesnew($disoffer,$productid)
{
	/*
	$discount=explode("|",$disoffer);
$Disfirst=explode("~",$discount[0]);
$Finaldis=$Disfirst[1];
return $Finaldis;
*/

	$discount=explode("|",$disoffer);
	$discountcount = count($discount);
	$i = 0;
	do
	{
		$productidequate = explode("~",$discount[$i]);
		if($productid == $productidequate[0])
		{
			return $productidequate[1];
		}
		$i++;
	}while($i < $discount);
return "null";

}
?>