<?php
#================================================================================================================
# Author 		: N.Dhanapal
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: PhotoManagement - Add Photo
#================================================================================================================

//BASE PATH
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once $varRootBasePath."/conf/config.inc";
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objSlave	= new DB;

$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varArrPaymentType	= array(1=>"Online",2=>"Chennai");
$varArrPaymentMode	= array(1=>"Credit Card",2=>"Check",3=>"Demand Draft",4=>"Cash");
$varEdit			= $_REQUEST["edit"];
$varAction			= $varEdit ? 'action=index.php?act=edit-payment' : '';

//CONTROL STATEMENT
if ($_POST["frmPayment"]=="yes") {

	$varUsername 		= $_REQUEST["username"];
	$varCondition		= " WHERE (OrderId='".$varUsername."' OR MatriId='".$varUsername."' OR User_Name='".$varUsername."')";

	//IF ORDER ID COMES GET MatriId FROM paymenthistory table
	$varNoOfResults	= $objSlave->numOfRecords($varTable['PAYMENTHISTORYINFO'],'OrderId',$varCondition);

	if ($varNoOfResults >0) {

		$varFields			= array('MatriId','OrderId','Amount_Paid','Discount','Currency','Payment_Type','Payment_Mode','Voucher_Code','Comments','Date_Paid');
		$varSelectHistoryInfo	= $objSlave->select($varTable['PAYMENTHISTORYINFO'],$varFields,$varCondition,1);

	}//if

}//if

$objSlave->dbClose();
?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="540">
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<table border="0" cellpadding="0" cellspacing="0" align="center" width="540">
				<tr><td height="10"></td></tr>
				<tr><td valign="top" class="heading" style="padding-left:15px;">View Payment History</td></tr>
				<tr><td height="10"></td></tr>
				<?php if ($_POST["frmPayment"]=="yes" && $varNoOfResults==0) { ?>
				<tr><td align="center" class="smalltxt"><b>No Records found</b></td></tr>
				<?php }//if ?>
				<tr>
					<td colspan="2">
						<form name="frmViewFilters" <?=$varAction;?> method="post" onSubmit="return funViewProfileId();">
						<input type="hidden" name="frmPayment" value="yes">
						<input type="hidden" name="MatriId" value="">
						<table cellspacing="0" cellpadding="0" border="0" width="100%" align="center">
							<tr>
								<td width="30%" class="smalltxt" style="padding-left:12px;">&nbsp;<b>Username / Matrimony Id / Order Id</b></td>
								<td width="20%"><input type=text name="username" value="<?=$varUsername;?>" size="20" class="inputtext" value=""></td>
								<input type="hidden" name="edit" value="<?=$varEdit;?>">
								
								<td  width="10%"> <input type="submit" value="Search" class="button"></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="5" bgcolor="#FFFFFF"></td></tr>

	<?php if ($varNoOfResults > 0) { ?>
	<tr><td class="mediumtxt" style="padding-left:10px;">&nbsp;<b>Valid Days : <?=$varValidDays;?></b></td></tr>
	<tr>
		<td align="center">
			<table border="0" class="myprofsubbg"  cellpadding="0" cellspacing="1" align="left" width="743">
				<tr>
					<td valign="top" width="733" bgcolor="#FFFFFF" style="padding-left:10px;">
						<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" class="formborder">
						<tr height="25" class="adminformheader">
							<td class="smalltxt boldtxt" style="padding-left:6px;">S.No</td>
							<td class="mailerEditTop">OrderId</td>
							<td class="mailerEditTop">Amount</td>
							<td class="mailerEditTop">Mode</td>
							<td class="mailerEditTop">Upgraded on</td>
							<td class="mailerEditTop">Upgraded at</td>
							<td class="mailerEditTop">Comments</td>
						</tr>
						<?php
							$j=1;	
							for ($i=0;$i<count($varSelectHistoryInfo);$i++)
							{
								echo '<tr><td height="10" colspan="7"></td></tr>';
								echo '<tr>';
								echo '<td class="mediumtxt">&nbsp;&nbsp;&nbsp;'.$j.'</td>';
								echo '<td class="mediumtxt">'.$varSelectHistoryInfo[$i]["OrderId"].'</td>';
								echo '<td class="mediumtxt">'.$varSelectHistoryInfo[$i]["Currency"]." ".$varSelectHistoryInfo[$i]["Amount_Paid"].'</td>';
								echo '<td class="mediumtxt">'.$varArrPaymentMode[$varSelectHistoryInfo[$i]["Payment_Mode"]].'</td>';
								echo '<td class="mediumtxt">'.$varSelectHistoryInfo[$i]["Date_Paid"].'</td>';
								echo '<td class="mediumtxt">&nbsp;&nbsp;&nbsp;'.$varArrPaymentType[$varSelectHistoryInfo[$i]["Payment_Type"]].'</td>';
								echo '<td class="mediumtxt">&nbsp;&nbsp;&nbsp;'.$varSelectHistoryInfo[$i]["Comments"].'</td>';
								echo '</tr>';
								echo '<tr><td height="10" colspan="7"></td></tr>';
								echo '<tr><td height="1" colspan="7" class="bordertop"><img src="'.$confValues['IMGSURL'].'/trans.gif"  height="1"></td></tr>';
								$j++;
							}//for
						?>
						<tr><td height="10" colspan="6"></td></tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="10" colspan="6"></td></tr>
	<?php }//if ?>
</table>

<?php
//UNSET OBJECT
unset($objCommon);
?>
<script language="javascript">
function funViewProfileId()
{
	var frmName = document.frmViewFilters;
	if (frmName.username.value=="") {
		alert("Please enter  Username / Matrimony Id / Order Id");
		frmName.username.focus();
		return false;
	}//if
	return true;
}//funViewProfileId
</script>