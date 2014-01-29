<?php
# Author	:	A.Kirubasankar
# Date		:	18/01/2010
# Desc		:	File to retrieve array details from BM server (To be put in the BM server)
# Filename	:	getdetailsbmtm.php
#---------------------------------------------------------------------------------------------


/* Includes */
$path = '/home/office/';
//bc = branch contact details
if($_REQUEST[para] == "bc")
{
	if($_REQUEST[offid] == "")
	{
		include_once $path."bmconf/bmbranchcontactinfo.inc";//contains the contact details of each and every bmoffice
		echo "<br>:&npn&:";
		$var = json_encode($BRANCHCONTACTINFO);
	}
	else
	{
		include_once $path."bmconf/bmbranchcontactinfo.inc";//contains the contact details of each and every bmoffice
		echo "<br>:&npn&:";
		$var = json_encode($BRANCHCONTACTINFO[$_REQUEST[offid]]);
	}
}
if($_REQUEST[para] == "status")
{
//		include_once $path."collectioninterface/www/config/arrfile.php";//contains the status arrays
		echo "<br>:&npn&:";

include("/home/product/community/ability/www/admin/paymentassistance/arrfile.php");
		$assinedstatus1 = array_flip($assinedstatus);
		$confirmstatus1 = array_flip($confirmstatus);

		$confirmstatusmax = max($confirmstatus1);
		$statusMaxCount = $assinedstatusmax = max($assinedstatus1);
		if($confirmstatusmax > $assinedstatusmax) { $statusMaxCount = $confirmstatusmax; }

		for($statusCount=0;$statusCount<=$statusMaxCount;$statusCount++)
		{
			if(in_array($statusCount,$assinedstatus1))
			{
				$mergedStatusArray[$statusCount] = $assinedstatus[$statusCount];
			}
			if(in_array($statusCount,$confirmstatus1))
			{
				$mergedStatusArray[$statusCount] = $confirmstatus[$statusCount];
			}
		}

		$var = json_encode($mergedStatusArray);
}
// pm stands for Mode of payment
if($_REQUEST[para] == "pm")
{
//	include_once($path."wcc/www/config/easypayarrays.php");
	include("/home/product/community/ability/www/admin/paymentassistance/easypayarrays.php");
	echo "<br>:&npn&:";
	$var = json_encode($paymentmode);
	$var .= ":&npn&:";
	$var .= json_encode($handingover);
}
print($var);
?>
