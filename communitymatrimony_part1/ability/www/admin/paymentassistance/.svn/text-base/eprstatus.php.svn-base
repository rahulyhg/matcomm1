<?php
#====================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 07 Dec 2009

# Module		: Payment Assistance
#====================================================================================================

//BASE PATH
$varRootBasePath = '/home/product/community/ability';
//FILE INCLUDES
include_once($varRootBasePath.'/conf/ip.inc');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/www/admin/paymentassistance/lvars.php');

//$objSlaveMatri = new DB;
$objEPR			= new DB;

//Connecting communitymatrimony db
//$objSlaveMatri -> dbConnect('S',$varDbInfo['DATABASE']);
$objEPR -> dbConnect('ODB4',$varDbInfo['EPRDATABASE']);

// Fetching Contact Status Array
$curlUrl = "http://wcc.matchintl.com/getdetailsbmtm.php?para=status";
//$curlUrl = "http://www.communitymatrimony.com/admin/paymentassistance/getdetailsbmtm.php?para=status";
$branchContactInfo1 = cbscurl($curlUrl);

$branchContactInfo2 = explode(":&npn&:",$branchContactInfo1);
$branchContactInfo3 = $branchContactInfo2[1];
$branchContactInfo = json_decode($branchContactInfo3,true);

$eprValue = $_REQUEST[epr];

$userType1 = explode("&",$_COOKIE['adminLoginInfo']);
$userType2 = explode("=",$userType1[0]);
$userType = $userType2[1];

if($_REQUEST[fromform] == "1")
{
	$args = array('RequestNo','BranchId','RequestDate','MatriId','Gender','Age','ContactName','ContactPhone','ContactStatus','AppointmentTime','AppointmentDate','ResidingDistrict');

	$argCondition = " WHERE RequestNo='".$eprValue."' and EntryFrom = 11";
	if($userType == 2 && $userType1[1]!='nazir')
		$argCondition .= " and ExecutiveId = '$userType1[1]'";
	$eprNum = $objEPR -> numOfRecords($varTable['EASYPAYINFO'], 'RequestNo', $argCondition);

	if($eprNum >= 1)
	{
		$checkResult = $objEPR -> select($varTable['EASYPAYINFO'],$args,$argCondition,0);

		if($objEPR -> clsErrorCode == "")
		{
			$varEprDetails = mysql_fetch_assoc($checkResult);
			$eprDetailsTable = "<table cellpadding='0' cellspacing='4' align='center' width='300' style='border: 1px solid rgb(209, 209, 209);'>";		
			$eprDetailsTable .= "<tr><th class='rowlightbrown normaltxt1' colspan='2'>EPR Status</th></tr>";
			$eprDetailsTable .= "<tr><td class='smalltxt'>EPR No</td><td class='smalltxt'>$varEprDetails[RequestNo]</td></tr>";
			
			$branchNameShow = branchName($varEprDetails[ResidingDistrict]);
			/*
			$branchNameArr = array('BranchName','CoverageCity');
			$branchCondition = " where CoverageCity like '%$varEprDetails[ResidingDistrict]%'";
			$branchNameRes = $objEPR -> select($varTable['EASYBRANCHDETAILS'],$branchNameArr,$branchCondition,0);

			while($branchNameRow = mysql_fetch_assoc($branchNameRes))
			{				
				$cityArray = explode(",",$branchNameRow['CoverageCity']);
				if(in_array($varEprDetails[ResidingDistrict],$cityArray))
				{
					$branchNameShow = $branchNameRow['BranchName'];
				}
			}
			*/

			$eprDetailsTable .= "<tr><td class='smalltxt'>Branch Name</td><td class='smalltxt'>".$branchNameShow."</td></tr>";
			$eprDetailsTable .= "<tr><td class='smalltxt'>EPR Date</td><td class='smalltxt'>$varEprDetails[RequestDate]</td></tr>";
			$eprDetailsTable .= "<tr><td class='smalltxt'>MatriId</td><td class='smalltxt'>$varEprDetails[MatriId]</td></tr>";
			
			$eprDetailsTable .= "<tr><td class='smalltxt'>Contact Name</td><td class='smalltxt'>$varEprDetails[ContactName]</td></tr>";
			$eprDetailsTable .= "<tr><td class='smalltxt'>Contact Phone</td><td class='smalltxt'>$varEprDetails[ContactPhone]</td></tr>";

			$eprDetailsTable .= "<tr><td class='smalltxt'>Appointment Date & Time</td><td class='smalltxt'>$varEprDetails[AppointmentDate] $varEprDetails[AppointmentTime]</td></tr>";
			//$eprDetailsTable .= "<tr><td>Contact Mobile</td><td>$varEprDetails[ContactStatus]</td></tr>";

			//$ContactStatus = $assinedstatus[$varEprDetails[ContactStatus]];
			$ContactStatus = $branchContactInfo[$varEprDetails[ContactStatus]];
			////if($ContactStatus == "")
			////	$ContactStatus = $confirmstatus[$varEprDetails[ContactStatus]];

			$eprDetailsTable .= "<tr><td class='smalltxt'>EPR Status</td><td class='smalltxt'>$ContactStatus</td></tr>";
			$eprDetailsTable .= "";
			$eprDetailsTable .= "";
			$eprDetailsTable .= "</table>";
		}
		else
		{
			$eprDetailsTable = $objEPR -> clsErrorCode;
		}
	}
	else
	{
		$$eprDetailsTable = "<table cellpadding='0' cellspacing='4' align='center' width='300'>";		
		$eprDetailsTable .= "<tr><th class='rowlightbrown normaltxt1' colspan='2'>EPR Number does not exist.</th></tr>";
		$eprDetailsTable .= "</table>";
	}
}
if($_REQUEST[fromform] == "2")
{
	$fromdate = $_REQUEST['fromdate'];
	$todate = $_REQUEST['todate'];
	$argCondition = " WHERE RequestDate >= '".$fromdate."' and RequestDate <= '".$todate."' and EntryFrom = 11";
	if($userType == 2)
		$argCondition .= " and ExecutiveId = '$userType1[1]'";

	$EPRCount = 0;
	$argFields = array('RequestNo','MatriId','ContactStatus','BranchId','AppointmentDate','AppointmentTime','ResidingDistrict');
	
	$eprRes = $objEPR -> select($varTable['EASYPAYINFO'],$argFields,$argCondition,0);

	while($eprRow = mysql_fetch_assoc($eprRes))
	{
		if($eprRow[ResidingDistrict] != "")
		{
			$branchNameShow = branchName($eprRow[ResidingDistrict]);
		}
		$EPRCount++;
			
		$ContactStatus = $branchContactInfo[$eprRow['ContactStatus']];
			
		$tdValue .= "<tr class='smalltxt'><td align='center'>".$eprRow['RequestNo']."</td><td align='center'>".$eprRow['MatriId']."</td><td align='center'>".$ContactStatus."</td><td align='center'>".$branchNameShow."</td><td align='center'>".$eprRow['AppointmentDate']." ".$eprRow['AppointmentTime']."</td></tr>";
	}
	$branchNameShow = "";
	if($EPRCount == 0 && $tdValue == "")
		$tdValue = "<tr><td class='smalltxt' colspan='6' align='center'>No Results found.</td></tr>";
	$eprDetailsTable .= "<table cellpadding='0' cellspacing='0' align='center' width='98%'  style='border: 1px solid rgb(209, 209, 209);' >";
	$eprDetailsTable .= "<tr class='adminformheader'><th>Request No.</th><th>Matrimony Id</th><th>EPR Status</th><th>Branch Name</th><th>Appointment Time</th></tr>";
	$eprDetailsTable .= "$tdValue";
	$eprDetailsTable .= "</table>";

}
echo $eprDetailsTable;

function cbscurl($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}
function branchName($resDist)
{
	global $objEPR,$varTable;
	$branchNameArr = array('BranchName','CoverageCity');
	$branchCondition = " where CoverageCity like '%".$resDist."%'";

	$branchNameRes = $objEPR -> select($varTable['EASYBRANCHDETAILS'],$branchNameArr,$branchCondition,0);

	while($branchNameRow = mysql_fetch_assoc($branchNameRes))
	{
		$cityArray = explode(",",$branchNameRow['CoverageCity']);
		if(in_array($resDist,$cityArray))
		{
			return $branchNameShow = $branchNameRow['BranchName'];
		}
	}
}
?>