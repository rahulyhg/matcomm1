<?php
#====================================================================================================
# Author   : A.Kirubasankar
# Start Date : 08 Oct 2009
# End Date  : 20 Aug 2008
# Module  : Payment Assistance
#====================================================================================================
############################################ Include file #################################################
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/payment.cil14');

//$objSlave	= new DB;
$objSlaveMatri = new DB;
$objEPR			= new DB;

$objEPR -> dbConnect('ODB4',$varDbInfo['EPRDATABASE']);

$objSlaveMatri -> dbConnect('S',$varDbInfo['DATABASE']);

$varDBUserName = $varPaymentAssistanceDbInfo['USERNAME'];
$varDBPassword = $varPaymentAssistanceDbInfo['PASSWORD'];
//$objSlave -> dbConnect('S',$varPaymentAssistanceDbInfo['DATABASE']);

/* Status Arrays */
$assinedstatus=array(5=>"Not Assigned",1=>"Progress",0=>"Pending");
$confirmstatus=array(3=>"Completed",4=>"Not Intrested",2=>"Postponed",6=>"Online Payment");

$arrOfferSource = array(1=>"Telemarketing",2=>"Support");

$matriId = $_REQUEST[COMMATRIID];

?>

<style type="text/css">
	@import url("http://imgs.bharatmatrimony.com/bmstyles/global-style.css");
</style>

<SCRIPT LANGUAGE="JavaScript"></SCRIPT>
<div style="width:370px;">	
<div style="padding:10px 0px 10px 10px;">
<div class="fleft" style=" width: 180px; ">
	<table cellpadding='3' cellspacing='1'>
			<tr>
				<td class="smalltxt boldtxt">
					MatriId:&nbsp;&nbsp;<?=$_REQUEST['COMMATRIID']?> 
				</td>
			</tr>
	</table>
</div>	

</div>
</div>

<?php
		//echo newTMDetails($matriId);

		echo "<br>".tmFollowupDetails($matriId)."<br>";

		echo offerDetails($matriId);

		echo easyPay($matriId);


		//echo $tmfollowupinfo;
		//echo "<br>".$tmOfferinfo;
		//echo "<br>".$tmDoorstepinfo;
?>
<?php
function newTMDetails($matriId)
{
	global $objSlaveMatri, $varTable,$paymentoption_followup_status;
		$arrArgFields = array('CallerId','FollowupStatus','FollowupDate','SupportUserName','DateUpdated','Comments');
		
		$varCondition = " WHERE MatriId =".$objSlaveMatri->doEscapeString($matriId,$objSlaveMatri)." ";
		$countCom	= $objSlaveMatri -> numOfRecords($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS'], 'MatriId', $varCondition);
		if($objSlaveMatri -> clsErrorCode == "CNT_ERR")
		{
			echo "DB Eror";
			exit;
		}
		if($countCom > 0)
		{
			$tmfollowupinfo='';
			$tmfollowupinfo="<table cellpadding='2' cellspacing='1' bgcolor='gray' align='center' width='98%'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6'>New TM Interface Details Info:</td></tr><tr class='smalltxt boldtxt' align='center'bgcolor='#f7f7f7'><td>TelecallerUserName</td><td>Followup Status</td><td>FollowupDate</td><td>Branch Name</td><td>Date Called On</td><td>Comments</td></tr>";
			$m='1';

			$tmFollowupStatusResult	= $objSlaveMatri -> select($varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS'],$arrArgFields,$varCondition,0);
			if($objSlaveMatri -> clsErrorCode		== "SELECT_ERR")
			{
				echo "Database Error";
				exit;
			}

			//while($getComments=db::fetchArray()) {
			while($tmFollowupStatus = mysql_fetch_assoc($tmFollowupStatusResult))
			{
				$followpstatus = $tmFollowupStatus['FollowupStatus'];
				$tmCmds = $getComments['Comments'];
//print_r($getComments);
				//$tmfollowupinfo .="<form method='post' name='formtmcmd".$m."' action='tmprivilegecoments.php'><tr class='smalltxt' style='padding: 15px 0px 0px 15px;' align='center' bgcolor='white'>";

				//$showComments="<a href=\"javascript:document.formtmcmd".$m.".submit();\" class='clr1 boldtxt'>ClickHere</a>";
				$showComments = "";

				$followpstatus = $paymentoption_followup_status[$tmFollowupStatus['FollowupStatus']]." ($tmFollowupStatus[FollowupStatus])";
				$tmfollowupinfo.="<td>".$tmFollowupStatus['SupportUserName']."</td><td>".$followpstatus."</td><td>".$tmFollowupStatus['FollowupDate']."</td><td>".$officeName."</td><td>".$tmFollowupStatus['FollowupDate']."</td><td>".$showComments."</td></tr>";

//				$tmfollowupinfo.="</form>";

				$m++;
		 }
		 $tmfollowupinfo.="</table><br/>";
		}// records not found 
		else{
			$tmfollowupinfo ="<br><FONT COLOR=#339966><B>New Telemarketing Details:</B></FONT></br><table cellpadding='2' cellspacing='1' bgcolor='gray'  width='300'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6'>No history found in new telemarketing interface </td></tr></table></br>";
		}
return $tmfollowupinfo;
}
function offerDetails($matriId)
{
	global $objSlaveMatri, $varTable,$arrOfferSource,$arrPrdPackages;
	$arrArgFields = array('OfferCode','OfferSource','OfferEndDate','OfferAvailedStatus','DateUpdated','MemberExtraPhoneNumbers','MemberDiscountINRFlatRate','MemberNextLevelOffer','OfferAvailedOn');
	
	$varCondition = " WHERE MatriId =".$objSlaveMatri->doEscapeString($matriId,$objSlaveMatri)." order by DateUpdated desc limit 1";
	$countCom	= $objSlaveMatri -> numOfRecords($varTable['OFFERCODEINFO'], 'MatriId', $varCondition);
	if($objSlaveMatri -> clsErrorCode == "CNT_ERR")
	{
		echo "DB Eror";
		exit;
	}
	if($countCom > 0)
	{
		$tmOfferinfo='';
		$tmOfferinfo="<table cellpadding='2' cellspacing='1' bgcolor='gray' width='98%' align='center'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='8'>Offer Details:</td></tr><tr class='smalltxt boldtxt' align='center'bgcolor='#f7f7f7'><td>Offer Source</td><td>Offer End Date</td><td>Extra Phone</td><td>Flat Discount</td><td>Next Level Offer</td><td>Package</td><td>DateUpdated</td></tr>";
		$m='1';

		$tmOfferStatusResult	= $objSlaveMatri -> select($varTable['OFFERCODEINFO'],$arrArgFields,$varCondition,0);
		if($objSlaveMatri -> clsErrorCode		== "SELECT_ERR")
		{
			echo "Database Error";
			exit;
		}

		while($tmOfferStatusResult = mysql_fetch_assoc($tmOfferStatusResult))
		{
			$tmOfferStatusResult['OfferEndDate'] = explode(" ",$tmOfferStatusResult['OfferEndDate']);
			$tmOfferStatusResult['DateUpdated'] = explode(" ",$tmOfferStatusResult['DateUpdated']);
			if($tmOfferStatusResult['OfferAvailedStatus'] == "1")
				$tmOfferStatusResult['OfferAvailedStatus'] = "YES";
			else
				$tmOfferStatusResult['OfferAvailedStatus'] = "NO";
			
			$inrFlat = substr($tmOfferStatusResult['MemberDiscountINRFlatRate'],0,1);
			//$tmOfferStatusResult['MemberDiscountINRFlatRate'];

			$tmOfferStatusResult['MemberDiscountINRFlatRate'] = explode("|",$tmOfferStatusResult['MemberDiscountINRFlatRate']);
			$tmOfferStatusResult['MemberDiscountINRFlatRate'] = explode("~",$tmOfferStatusResult['MemberDiscountINRFlatRate'][0]);

			if($tmOfferStatusResult['MemberNextLevelOffer'] != "")
			{
				$fromToOffer = explode("~",$tmOfferStatusResult['MemberNextLevelOffer']);
				$fromOfferVal = $arrPackageName[$fromToOffer[0]];
				$toOfferVal = $arrPackageName[$fromToOffer[1]];
				$memberNextLeverOffer = "<b>".$fromOfferVal."</b> to <b>".$toOfferVal."</b>";
				$memberNextLeverOffer = substr($tmOfferStatusResult['MemberNextLevelOffer'],2,1);
			}


			$offerEndDate1 = explode("-",$tmOfferStatusResult['OfferEndDate'][0]);
			$offerEndDate = $offerEndDate1[2]."-".$offerEndDate1[1]."-".$offerEndDate1[0];

			$package = $arrPrdPackages[$inrFlat];
			$extraPhoneNumber = substr($tmOfferStatusResult['MemberExtraPhoneNumbers'],2,2);
			$dateUpdated1 = explode("-",$tmOfferStatusResult['DateUpdated'][0]);
			$dateUpdated = $dateUpdated1[2]."-".$dateUpdated1[1]."-".$dateUpdated1[0];
			$tmOfferinfo.="<tr class='smalltxt' style='background-color:#FFFFFF;'><td>".$arrOfferSource[$tmOfferStatusResult['OfferSource']]."</td><td>".$offerEndDate."</td><td>".$extraPhoneNumber."</td><td>".$tmOfferStatusResult['MemberDiscountINRFlatRate'][1]."</td><td>".$arrPrdPackages[$memberNextLeverOffer]."</td><td>".$package."</td><td>".$dateUpdated."</td></tr>";

	 }
	 $tmOfferinfo.="</table><br/>";
	}// records not found 
	else{
		$tmOfferinfo ="<br><FONT COLOR=#339966><B>Offer Details:</B></FONT></br><table cellpadding='2' cellspacing='1' bgcolor='gray'  width='98%' align='center'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6' align='center'>No history found on offers </td></tr></table></br>";
	}
return $tmOfferinfo;
}
function easyPay($matriId)
{
	global $varTable,$objEPR,$assinedstatus,$confirmstatus,$arrPrdPackages;
	$eprArgs = array('MatriId','RequestNo','BranchId','ExecutiveId','RequestDate','AppointmentDate','AppointmentTime','PaymentCollectedDate','Discount','PreferredPackage','ModeofPayment','ContactStatus');
	$eprCond = " where matriId =".$objEPR->doEscapeString($matriId,$objEPR)." order by RequestDate desc limit 1";
	$eprNum = $objEPR -> numOfRecords($varTable['EASYPAYINFO'], 'MatriId', $eprCond);
	if($eprNum > 0)
	{
		$eprRes = $objEPR -> select($varTable['EASYPAYINFO'],$eprArgs,$eprCond);

		$tmDoorstepinfo="<table cellpadding='2' cellspacing='1' bgcolor='gray' width='98%' align='center'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='9'>Door Step Payment Offer :</td></tr><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' align='center' ><td>EPR No</td><td>Office</td><td>TelecallerId</td><td>Request Date</td><td>Package</td></tr>";
		while($eprRow = mysql_fetch_assoc($eprRes))
		{
			//print_r($eprRow);
			$branchName = getBranchId($eprRow['BranchId']);
			//$contactStatus = $confirmstatus[$eprRow['ContactStatus']];
			//if($contactStatus == "")
			//	$contactStatus = $assinedstatus[$eprRow['ContactStatus']];
			$package = $arrPrdPackages[$eprRow['PreferredPackage']];

			$requestDate1 = explode("-",$eprRow['RequestDate']);
			$requestDate = $requestDate1[2]."-".$requestDate1[1]."-".$requestDate1[0];

			$tmDoorstepinfo.="<tr class='smalltxt' style='background-color:#FFFFFF;'><td>".$eprRow['RequestNo']."</td><td>".$branchName."</td><td>".$eprRow['ExecutiveId']."</td><td>".$requestDate."</td><td>".$package."</td></tr>";
		}
	}
	else
	{
		$tmDoorstepinfo ="<br><FONT COLOR=#339966><B>Door Step Details:</B></FONT></br><table cellpadding='2' cellspacing='1' bgcolor='gray'  width='98%' align='center'><tr class='smalltxt boldtxt' bgcolor='#f7f7f7' ><td colspan='6' align='center'>No history found in door step payment </td></tr></table></br>";
	}
	$tmDoorstepinfo .= "</table>";
return $tmDoorstepinfo;
}
function tmFollowupDetails($matriId)
{
	global $objSlaveMatri,$varTable,$varCbstminterfaceDbInfo,$paymentoption_followup_status;
	$varCondition = " where MatriId =".$objSlaveMatri->doEscapeString($matriId,$objSlaveMatri)." order by DateCalled desc limit 1";

	$num = $objSlaveMatri -> numOfRecords($varCbstminterfaceDbInfo['DATABASE'].".cbstmfollowupdetails", 'MatriId', $varCondition);
	$cbsFolloupCount = 0;
	$cbsFolloupRowDetails .= "<table cellpadding='2' cellspacing='1' bgcolor='gray' align='center' width='98%'>";
	$cbsFolloupRowDetails .= "<tr><td class='smalltxt boldtxt' bgcolor='#f7f7f7' colspan='5'>CBS Interface Details Info:</td></tr>";
	$cbsFolloupRowDetails .= "<tr class='smalltxt boldtxt' bgcolor='#f7f7f7'><th>Telecaller Name</th><th>Follwowup Date</th><th>Branch</th><th>Last Called On</th><th>Comments </th></tr>";
	if($num > 0)
	{
		$arrArgFields = array('TelecallerName','FollowupDate','OfficeId','DateCalled','Comments');
		$cbsFolloupRes = $objSlaveMatri ->  select($varCbstminterfaceDbInfo['DATABASE'].".cbstmfollowupdetails",$arrArgFields,$varCondition,0);
		if($objSlaveMatri -> clsErrorCode == "SELECT_ERR")
		{
			$cbsFolloupRowDetails .= "<tr class='smalltxt' bgcolor='white'><td align='center' colspan='6'>Table $varCbstminterfaceDbInfo[DATABASE].cbstmfollowupdetails SELECT_ERR Error</td></tr>";
		}
		else
		{
			
			while($cbsFolloupRow = mysql_fetch_assoc($cbsFolloupRes))
			{
				$followupStatus = $cbsFolloupRow[TelecallerName];
				$branchName = getBranchId($cbsFolloupRow[OfficeId]);
				$dateCalled = explode(" ",$cbsFolloupRow['DateCalled']);
				$cbsFolloupRow[FollowupDate] = explode(" ",$cbsFolloupRow[FollowupDate]);
				//$comments = substr($cbsFolloupRow[Comments],0,10);
	
				$followupDate1 = explode("-",$cbsFolloupRow[FollowupDate][0]);
				$follupDate = $followupDate1[2]."-".$followupDate1[1]."-".$followupDate1[0];

				$comments = "<a href='tmcomments.php?comments=$cbsFolloupRow[Comments]' style='color:red;'>Click here<a>";
				$cbsFolloupRowDetails .= "<tr class='smalltxt' bgcolor='white'><td align='center'>$followupStatus</td><td align='center'>".$follupDate."</td><td align='center'>$branchName</td><td align='center'>$dateCalled[0]</td><td align='center'>$comments</td></tr>";
				$cbsFolloupCount++;
			}
			//if($cbsFolloupCount <= 0)
				
		}
	}
	else
	{
		$cbsFolloupRowDetails .= "<tr class='smalltxt' bgcolor='white'><td align='center' colspan='6'>No Followup details found</td></tr>";
	}
	$cbsFolloupRowDetails .= "</table>";
return $cbsFolloupRowDetails;
}
function getBranchId($branchId)
{
	global $objEPR;
	$branchNameArr = array('BranchName');
	$branchCondition = " where BranchId =".$objEPR->doEscapeString($branchId,$objEPR)." ";
	$branchNameRes = $objEPR -> select('easypay_branch_details',$branchNameArr,$branchCondition,1);
return $branchNameRes[0]['BranchName'];
}
?>