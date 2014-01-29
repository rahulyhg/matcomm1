<?php
#====================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 07 Dec 2009

# Module		: Payment Assistance
#====================================================================================================

//BASE PATH
$varRootBasePath = '/home/product/community';
//FILE INCLUDES
include_once($varRootBasePath.'/conf/ip.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');

//$objSlaveMatri = new DB;
$objEPR			= new DB;

//Connecting communitymatrimony db
//$objSlaveMatri -> dbConnect('S',$varDbInfo['DATABASE']);
$objEPR -> dbConnect('ODB4',$varDbInfo['EPRDATABASE']);

// Contact Status Array
$assinedstatus=array(5=>"Not Assigned",1=>"Progress",0=>"Pending");
$confirmstatus=array(3=>"Completed",4=>"Not Intrested",2=>"Postponed",6=>"Online Payment");

$varTable['EASYPAYBRANCHDETAILS'] = "easypay_branch_details";

$eprValue = $_REQUEST[epr];

$userType1 = explode("&",$_COOKIE['adminLoginInfo']);
$userType2 = explode("=",$userType1[0]);
$userType = $userType2[1];

if($_REQUEST[fromform] == "1")
{
	$args = array('RequestNo','BranchId','RequestDate','MatriId','Gender','Age','ContactName','ContactPhone','ContactStatus','AppointmentTime','AppointmentDate','ResidingDistrict');

	$argCondition = " WHERE RequestNo=".$objEPR->doEscapeString($eprValue,$objEPR)." and EntryFrom = 11";
	
	if($userType == 2 && $userType1[1]!='nazir')
		$argCondition .= " and ExecutiveId = '$userType1[1]'";
//techo $argCondition;
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
			
			$branchNameArr = array('BranchName','CoverageCity');
			//$branchCondition = " where BranchId = '$varEprDetails[ResidingDistrict]'";
			$branchCondition = " where CoverageCity like '%$varEprDetails[ResidingDistrict]%'";
			$branchNameRes = $objEPR -> select($varTable['EASYPAYBRANCHDETAILS'],$branchNameArr,$branchCondition,0);

			while($branchNameRow = mysql_fetch_assoc($branchNameRes))
			{				
				$cityArray = explode(",",$branchNameRow['CoverageCity']);
				if(in_array($varEprDetails[ResidingDistrict],$cityArray))
				{
					$branchNameShow = $branchNameRow['BranchName'];
				}
			}

$eprnewDate= explode(" ",$varEprDetails[RequestDate]);
$ueprnewDate= $eprnewDate[0];
			$eprDetailsTable .= "<tr><td class='smalltxt'>Branch Name</td><td class='smalltxt'>".$branchNameShow."</td></tr>";
			$eprDetailsTable .= "<tr><td class='smalltxt'>EPR Date</td><td class='smalltxt'>$ueprnewDate</td></tr>";
			$eprDetailsTable .= "<tr><td class='smalltxt'>MatriId</td><td class='smalltxt'>$varEprDetails[MatriId]</td></tr>";
			/*
			if($varEprDetails[Gender] == "1")
				$gender = "Male";
			else
				$gender = "Female";
			$eprDetailsTable .= "<tr><td class='smalltxt'>Gender</td><td class='smalltxt'>$gender</td></tr>";
			*/
			//$eprDetailsTable .= "<tr><td class='smalltxt'>Age</td><td class='smalltxt'>$varEprDetails[Age]</td></tr>";
			$eprDetailsTable .= "<tr><td class='smalltxt'>Contact Name</td><td class='smalltxt'>$varEprDetails[ContactName]</td></tr>";
			$eprDetailsTable .= "<tr><td class='smalltxt'>Contact Phone</td><td class='smalltxt'>$varEprDetails[ContactPhone]</td></tr>";

			$eprDetailsTable .= "<tr><td class='smalltxt'>Appointment Date & Time</td><td class='smalltxt'>$varEprDetails[AppointmentDate] $varEprDetails[AppointmentTime]</td></tr>";
			//$eprDetailsTable .= "<tr><td>Contact Mobile</td><td>$varEprDetails[ContactStatus]</td></tr>";

			$ContactStatus = $assinedstatus[$varEprDetails[ContactStatus]];
			if($ContactStatus == "")
				$ContactStatus = $confirmstatus[$varEprDetails[ContactStatus]];

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
	$argCondition = " WHERE RequestDate >= '".$fromdate." 00:00:00' and RequestDate <= '".$todate." 23:59:59' and EntryFrom = 11";
	if($userType == 2)
		$argCondition .= " and ExecutiveId = '$userType1[1]'";

$assinedstatus1 = array_flip($assinedstatus);
$confirmstatus1 = array_flip($confirmstatus);

$confirmstatusmax = max($confirmstatus1);
$statusMaxCount = $assinedstatusmax = max($assinedstatus1);
if($confirmstatusmax > $assinedstatusmax) { $statusMaxCount = $confirmstatusmax; }
$EPRCount = 0;
	$argFields = array('RequestNo','MatriId','ContactStatus','BranchId','AppointmentDate','AppointmentTime','ResidingDistrict');
	for($statusCount=0;$statusCount<=$statusMaxCount;$statusCount++)
	{
		if(in_array($statusCount,$assinedstatus1))
		{
			$contactStatusQuery = " and ContactStatus = $statusCount";
		}
		if(in_array($statusCount,$confirmstatus1))
		{
			$contactStatusQuery = " and ContactStatus = $statusCount";
		}

		$argCondition1 = $argCondition.$contactStatusQuery;
		//techo $argCondition1;
		$eprRes = $objEPR -> select($varTable['EASYPAYINFO'],$argFields,$argCondition1,0);

		while($eprRow = mysql_fetch_assoc($eprRes))
		{
			$branchNameArr = array('BranchName','CoverageCity');
			//$branchCondition = " where BranchId = '".$eprRes[0][BranchId]."'";
			$branchCondition = " where CoverageCity like '%".$eprRow[ResidingDistrict]."%'";

			$branchNameRes = $objEPR -> select($varTable['EASYPAYBRANCHDETAILS'],$branchNameArr,$branchCondition,0);
			if($eprRow[ResidingDistrict] != "")
			{
				while($branchNameRow = mysql_fetch_assoc($branchNameRes))
				{
					$cityArray = explode(",",$branchNameRow['CoverageCity']);
					if(in_array($eprRow[ResidingDistrict],$cityArray))
					{
						$branchNameShow = $branchNameRow['BranchName'];
					}
				}
			}
			if(count($branchNameRes) >= 1)
				$EPRCount++;
				$ContactStatus = $assinedstatus[$eprRow['ContactStatus']];
				if($ContactStatus == "")
					$ContactStatus = $confirmstatus[$eprRow['ContactStatus']];

			$tdValue .= "<tr class='smalltxt'><td align='center'>".$eprRow['RequestNo']."</td><td align='center'>".$eprRow['MatriId']."</td><td align='center'>".$ContactStatus."</td><td align='center'>".$branchNameShow."</td><td align='center'>".$eprRow['AppointmentDate']." ".$eprRow['AppointmentTime']."</td></tr>";
			$contactStatusQuery = "";
		}
	}
	if($EPRCount == 0)
		$tdValue = "<tr><td class='smalltxt' colspan='6' align='center'>No Results found.</td></tr>";
	$eprDetailsTable .= "<table cellpadding='0' cellspacing='0' align='center' width='98%'  style='border: 1px solid rgb(209, 209, 209);' >";
	$eprDetailsTable .= "<tr class='adminformheader'><th>Request No.</th><th>Matrimony Id</th><th>EPR Status</th><th>Branch Name</th><th>Appointment Time</th></tr>";
	$eprDetailsTable .= "<tr>$tdValue</tr>";
	$eprDetailsTable .= "</table>";

}
echo $eprDetailsTable;

$objEPR->dbClose();
?>
