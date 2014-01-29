<?php
#=============================================================================================================
# Author 		: S Anand, N Dhanapal, M Senthilnathan & S Rohini
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

//FILE INCLUDES
// /home/product/community/ability
$varRootBasePath        = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/ip.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsDB.php");

//OBJECT DECLARATION
$objDB	= new DB;

//DB CONNECTION
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLLE DECLARATIONS
$varDisplayPayments	= '';
$varStartDate		= $_REQUEST["year1"].'-'.$_REQUEST["mon1"].'-'.$_REQUEST["day1"].' 00:00:00';
$varEndDate			= $_REQUEST["year2"].'-'.$_REQUEST["mon2"].'-'.$_REQUEST["day2"].' 23:23:59';
$varArrPaymentMode	= array(2=>"Check",3=>"Demand Draft",4=>"Cash Payment");


$varFields		= array('MatriId','Amount_Paid','Currency','Payment_Mode','Comments','Date_Paid');
$varCondition	= " WHERE Franchisee_Id='".$varFranchiseeId."' AND Date_Paid >='".$varStartDate."' AND Date_Paid <='".$varEndDate."'";
$varExecute		= $objDB->select($varTable['PAYMENTHISTORYINFO'],$varFields,$varCondition,0);

$varNoOfRecords	= $objDB->numOfRecords($varTable['PAYMENTHISTORYINFO'],'MatriId',$varCondition);

while ($varFranchiseePaymentInfo = mysql_fetch_array($varExecute)){

	$varMatriId			= trim($varFranchiseePaymentInfo["MatriId"]);
	$varCondition1		= " WHERE MatriId='".$varMatriId."'";
	$varNoOfRecords1	= $objDB->numOfRecords($varTable['MEMBERLOGININFO'],'MatriId',$varCondition1);

	if ($varNoOfRecords1==1) {
	$varFields			= array('User_Name');
	$varExecute1			= $objDB->select($varTable['MEMBERLOGININFO'],$varFields,$varCondition1,0);
	$varSelectUsername	= mysql_fetch_array($varExecute1);

	}
	$varAmount			= $varFranchiseePaymentInfo["Currency"].' '.$varFranchiseePaymentInfo["Amount_Paid"];
	$varPaymentMode		= $varArrPaymentMode[$varFranchiseePaymentInfo["Payment_Mode"]];
	$varComments		= $varFranchiseePaymentInfo["MatriId"];
	$varDatePaid		= $varFranchiseePaymentInfo["Date_Paid"];
	$varComments		= $varFranchiseePaymentInfo["Comments"];
	$varDisplayPayments	.= '<tr><td class="smalltxt">'.$varSelectUsername['User_Name'].'</td>';
	$varDisplayPayments	.= '<td class="smalltxt">'.$varAmount.'</td>';
	$varDisplayPayments	.= '<td class="smalltxt">'.$varPaymentMode.'</td>';
	$varDisplayPayments	.= '<td class="smalltxt">'.$varDatePaid.'</td>';
	$varDisplayPayments	.= '<td class="smalltxt">'.$varComments.'</td>';
}//for
$objDB->dbClose();
unset($objDB);
?>
<table border="0" cellpadding="0" cellspacing="0" width="770">
	<tr>
		<td valign="middle"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px !important;padding-bottom:10px"><font class="heading">Profile Upgradations</font></div>
			<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" width="100%">
				<tr>
					<td valign="top" class="smalltxt" style="padding-left:3px;">Use our varied search tools to find the partner of your choice. You could do a general search or a detailed search or search by specific criteria. We have created a fast and easy way to help you get matching results. Remember to try all of them.</div></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td style="height:20px !important;height:20px"></td></tr>
</table><br>

<table align=center bgcolor="#FFFFFF" border="0" class="formborder" cellspacing="0" cellpadding="2" width="600">
	<tr>
		<td valign="middle" class="smalltxt">
			<? if ($varNoOfRecords	> 0) { ?>
			<table border=0 width=590 cellspacing=2 cellpadding=2 align=center>
				<tr>
					<td class="smalltxt"><b>Username</b></td>
					<td class="smalltxt"><b>Amount Paid</b></td>
					<td class="smalltxt"><b>Payment Mode</b></td>
					<td class="smalltxt"><b>Payment Time</b></td>
					<td class="smalltxt"><b>Comments</b></td>
				</tr>
				<?=$varDisplayPayments;?>
			</table>
			<? }else { echo '<b>Profile Upgradations not found</b>'; }//else ?>
		</td>
	</tr>
</table>
<br>
