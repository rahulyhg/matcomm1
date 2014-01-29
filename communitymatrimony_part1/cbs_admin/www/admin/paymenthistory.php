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
include_once $varRootBasePath."/conf/config.cil14";
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/payment.cil14");
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objSlave	= new DB;
$objOffline	= new DB;

$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

##LIVE OFFLINE CONNECTION
$objOffline->dbConnect('ODB4_offlinecbs',$varOfflineCbsDbInfo['DATABASE']);
 
## Local DB Connection
##$objOffline->dbConnection($varDbIP['ODB4_offlinecbs'],'communitypay','community4dump',$varOfflineCbsDbInfo['DATABASE']);


function findExpiredate($date){
	if($date!= '0000-00-00 00:00:00'){
		$expire=date("Y-m-d",strtotime($date));
		$current=date("Y-m-d");
		 $dates=Array();  $count_day=0; 
		while (strtotime($expire)>strtotime("+".$count_day." day",strtotime($current))) {
			$count_day++; 
		}		 
		//$count_day = (strtotime($expire) - strtotime($current))/(60 * 60 * 24);		
		if($count_day>1){
			$day='Days';
		}else{
			$day='Day';
		}
		$days=($count_day<=10 && $count_day!=0)? "<font color='red'> ".$count_day."</font>  ".$day:$count_day." ".$day;
		return $days;
	}
}

//VARIABLE DECLARATION

$varMembershipType	= array(0=>"Gold Member",1=>"SuperGold Member",2=>"Platinum Member",3=>"Privelage Member",4=>"Privelage Member");
$varArrPaymentMode	= array(1=>"Online",2=>"Cheque",3=>"Demand Draft",4=>"Cash Payment",5=>"Direct Deposit");
$varEdit			= $_REQUEST["edit"];
$varAction			= $varEdit ? 'action=index.php?act=edit-payment' : '';
$varPaymentThroughViewProfile	= $_REQUEST["tvprofile"];
$varUsername 		  = $_REQUEST["username"];

//from member info
	 $varMemberCondition  = " WHERE MatriId=".$objSlave->doEscapeString($varUsername,$objSlave);
	 $varMemberNoOfResults	  =$objSlave->numOfRecords($varTable['MEMBERINFO'],'MatriId',$varMemberCondition);
 	if ($varMemberNoOfResults >0) {		
		$varMemberInfoSelect	= $objSlave->selectAll($varTable['MEMBERINFO'],$varMemberCondition,0);		 	
	}
	//from member statictics
	$varMemberStatisticsCondition  = " WHERE MatriId=".$objSlave->doEscapeString($varUsername,$objSlave);
	$varMemberStatisticsNoOfResults	  =$objSlave->numOfRecords($varTable['MEMBERSTATISTICS'],'MatriId',$varMemberStatisticsCondition);
	if ($varMemberStatisticsNoOfResults >0) {		
		$varMemberStatisticsInfoSelect	= $objSlave->selectAll($varTable['MEMBERSTATISTICS'],$varMemberStatisticsCondition,0);		
	}
	while($varMemberStatisticsInfo = mysql_fetch_array($varMemberStatisticsInfoSelect)){
			
			$varMail_Read_Sent     =$varMemberStatisticsInfo['Mail_Read_Sent'];
			$varMail_UnRead_Sent   =$varMemberStatisticsInfo['Mail_UnRead_Sent'];
			 $varMail_Replied_Sent  =$varMemberStatisticsInfo['Mail_Replied_Sent'];
			 $varMail_Declined_Sent =$varMemberStatisticsInfo['Mail_Declined_Sent'];			
	}
	$varTotalMail     = $varMail_Read_Sent+$varMail_UnRead_Sent+$varMail_Replied_Sent+$varMail_Declined_Sent;
	//if

//from phone package details

		  $varPhonePackageCondition  = " WHERE MatriId=".$objSlave->doEscapeString($varUsername,$objSlave);
		  $varPhonePackageNoOfResults		=$objSlave->numOfRecords($varTable['PHONEPACKAGEDET'],'MatriId',$varPhonePackageCondition);
		 if ($varPhonePackageNoOfResults >0) {		
		$varPhonePackageInfoSelect	= $objSlave->selectAll($varTable['PHONEPACKAGEDET'],$varPhonePackageCondition,0);	
		}
		while($varPhonePackageInfo = mysql_fetch_array($varPhonePackageInfoSelect)){			
			 $varTotalPhoneNos = $varPhonePackageInfo['TotalPhoneNos'];
			 $varNumbersLeft   = $varPhonePackageInfo['NumbersLeft'];			 		
		}

	
	$varPaymentCondition  = " WHERE MatriId=".$objSlave->doEscapeString($varUsername,$objSlave);
	$varFields			= array('MatriId','OrderId','Amount_Paid','Discount','Currency','Payment_Type','Payment_Mode','Voucher_Code','Comments','Date_Paid','Product_Id','Discount','DiscountFlatRate');
	$resultArrayPaymentDetails	= $objSlave->select($varTable['PAYMENTHISTORYINFO'],$varFields,$varPaymentCondition,1);
	
	$displayArray=array();
	$displayArray1=array();
	 if(is_array($resultArrayPaymentDetails)){
		foreach($resultArrayPaymentDetails as $key => $value){
			$date = strtotime($resultArrayPaymentDetails[$key]['Date_Paid']);
			$displayArray[$date]['MatriId'] = $resultArrayPaymentDetails[$key]['MatriId'];
			$displayArray[$date]['Amount'] = $resultArrayPaymentDetails[$key]['Amount_Paid'];
			$displayArray[$date]['Currency'] = $resultArrayPaymentDetails[$key]['Currency'];
			$displayArray[$date]['Date'] = $resultArrayPaymentDetails[$key]['Date_Paid'];
			$displayArray[$date]['PaymentMode'] = $resultArrayPaymentDetails[$key]['Payment_Mode'];
			$displayArray[$date]['PaymentType'] = $resultArrayPaymentDetails[$key]['Payment_Type'];
			$displayArray[$date]['Comments'] = $resultArrayPaymentDetails[$key]['Comments'];
			$displayArray[$date]['ProductId'] = $resultArrayPaymentDetails[$key]['Product_Id'];
			$displayArray[$date]['OrderId'] = $resultArrayPaymentDetails[$key]['OrderId'];
			$displayArray[$date]['Discount'] = $resultArrayPaymentDetails[$key]['Discount'];
			$displayArray[$date]['DiscountFlatRate'] = $resultArrayPaymentDetails[$key]['DiscountFlatRate'];
			$displayArray[$date]['Payment'] = 'Payment';			
		}
	 }

	 $varRefundCondition  = " WHERE MatriId=".$objOffline->doEscapeString($varUsername,$objOffline)." and Status='1'";
	$varFields			= array('MatriId','AmountRaised','DateActed','RejectReason','ProductId','UserID','OrderId','BranchId','Status');
	$resultArrayRefundPayment	= $objOffline->select('cm_paymentdetails_refund',$varFields,$varRefundCondition,1);

	if(is_array($resultArrayRefundPayment)){
		foreach($resultArrayRefundPayment as $key => $value) {
			$date = strtotime($resultArrayRefundPayment[$key]['DateActed']);
			$displayArray1[$date]['MatriId'] = $resultArrayRefundPayment[$key]['MatriId'];
			$displayArray1[$date]['Amount'] = $resultArrayRefundPayment[$key]['AmountRaised'];
			$displayArray1[$date]['Date'] = $resultArrayRefundPayment[$key]['DateActed'];
			$displayArray1[$date]['Comments'] = $resultArrayRefundPayment[$key]['RejectReason'];
			$displayArray1[$date]['ProductId'] = $resultArrayRefundPayment[$key]['ProductId'];
			$displayArray1[$date]['PaymentMode'] = '-';
			$displayArray1[$date]['UserID'] = $resultArrayRefundPayment[$key]['UserID'];		
			$displayArray1[$date]['OrderId'] = $resultArrayRefundPayment[$key]['OrderId'];
			$displayArray1[$date]['PaymentType'] = $resultArrayRefundPayment[$key]['BranchId'];
			$displayArray1[$date]['Status'] = $resultArrayRefundPayment[$key]['Status'];
			$displayArray1[$date]['Discount'] = '0.00';
			$displayArray1[$date]['DiscountFlatRate'] = '0.00';
			$displayArray1[$date]['Payment'] = 'Refund';
		}
	}
/*echo"<PRE>";
print_r($displayArray);
echo "<PRE>";
print_r($displayArray1);*/
$resArr = $displayArray+$displayArray1;
if(count($resArr)){
 	 krsort($resArr); 
}else{
 	$norcd = "No Record Found";
	}

?>



<table border="0" cellpadding="0" cellspacing="0" align="left">
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<table border="0" cellpadding="0" cellspacing="0" align="left" width="540">
				<tr><td height="10"></td></tr>
				<tr><td valign="top" class="heading" style="padding-left:15px;">View Payment History</td></tr>
				<tr><td height="10"></td></tr>			
				<tr>
					<td>						
						<table cellspacing="1" cellpadding="5" border="0" width="540" align="left">
							<tr>
								<td width="17.5%" class="mediumtxt bold" align="right">&nbsp;<b> Matrimony Id  :</b></td>
								<td width="32.5%" class="mediumtxt bold clr1" style="padding:10px;" ><b><?=$varUsername;?></b></td>												
							</tr>
						</table>
					</td>
				</tr>				
			</table>
		</td>
	</tr>
	<tr><td height="5" bgcolor="#FFFFFF"></td></tr>
	
	<tr>
		<td valign="top">
			<table border="0" cellpadding="5" cellspacing="1" align="left" width="50%">
				<?php if($varMemberNoOfResults > 0){ 
			while($varMemberInfo = mysql_fetch_array($varMemberInfoSelect)){?>
				<tr>
					<td class="mediumtxt" width="20%" align="right"><b> Current Membership Type :</b></td>
					<td class="smalltxt" width="30%"><?php
				if($varMemberInfo['Paid_Status']==1){
				 echo  $varMembershipType[$varMemberInfo['Special_Priv']];}else {
					 echo "Free Member";}?></td>
				</tr>
				<tr>
					<td class="mediumtxt" align="right"><b>Days left :</b></td>
					<td class="smalltxt"><?php echo findExpiredate($varMemberInfo['Expiry_Date']);?></td>
				</tr>
				<tr>
					<td class="mediumtxt" align="right"><b>Expiry Date :</b></td>
					<td class="smalltxt"><?php 
						 if($varMemberInfo['Expiry_Date']=="0000-00-00 00:00:00"){
						 echo "-";
						 }else{
						 echo date("Y-m-d",strtotime($varMemberInfo['Expiry_Date']));
					 }?></td>
				</tr>
				<tr>
					<td class="mediumtxt" align="right"><b>Number Of Payments :</b></td>
					<td class="smalltxt"><?php echo $varMemberInfo['Number_Of_Payments'];?></td>
				</tr><?php } }?>
				<?php if($varMemberStatisticsNoOfResults > 0){ ?>
				<tr>
					<td class="mediumtxt" align="right"><b>Total Messages Sent :</b></td>
					<td class="smalltxt"><?php echo $varTotalMail?></td>
				</tr>
				<?php }?>
				<?php if($varPhonePackageNoOfResults > 0){ ?>
				<tr>
					<td class="mediumtxt" align="right"><b>Total Phone Numbers :</b></td>
					<td class="smalltxt"><?php echo $varTotalPhoneNos;?></td>
				</tr>
				<tr>
					<td class="mediumtxt" align="right"><b> Phone Numbers Left  :</b></td>
					<td class="smalltxt"><?php echo $varNumbersLeft;?></td>
				</tr>
				<?php }?>
				
			</table>			
		</td>
	</tr>	
	<tr><td height="5" bgcolor="#FFFFFF"></td></tr>
	<tr>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="1" align="left" width="943">
				<tr>
					<td valign="top" width="733" bgcolor="#FFFFFF">
						<table border="0" cellpadding="0" cellspacing="1" align="center" width="99%" class="formborder" bgcolor="#C5D653">
						<tr height="25" class="adminformheader">
							<td class="smalltxt bold" width="5%" align="center">S.NO</td>
							<td class="smalltxt bold" width="10%" align="center">OrderId</td>
							<td class="smalltxt bold" width="10%" align="center">Amount</td>
							<td class="smalltxt bold" width="10%" align="center">Mode</td>
							<td class="smalltxt bold" width="10%" align="center">Upgraded on</td>
							<td class="smalltxt bold" width="10%" align="center">Upgraded at</td>
							<td class="smalltxt bold" width="15%" align="center">Comments</td>
							<td class="smalltxt bold" width="10%" align="center">Package</td>
							<td class="smalltxt bold" width="15%" align="center">Upgraded/Downgraded by </td>
							<td class="smalltxt bold" width="15%" align="center">Upgraded/Refund </td>
							<td class="smalltxt bold" width="10%" align="center">Discount(%)/Flat Rate</td>
						</tr>
						<?php 
						 $i=1;
							if(is_array($resArr)){
							foreach($resArr as $key => $val) {
								if($val['Payment']=="Payment"){

									$varOrderCondition  = " WHERE MatriId='".$varUsername."' and OrderId='". 
									$val["OrderId"]."'"; 
									$varOrderFields 	 = array('UpgraderId');
									$varOrderNoOfResults =$objOffline->numOfRecords('cm_orderdetails','MatriId',$varOrderCondition);		
									if ($varOrderNoOfResults >0) {									 
									$varOrderInfoSelect	= $objOffline->select('cm_orderdetails',$varOrderFields,$varOrderCondition,0);	
										while ($varOrderInfo=mysql_fetch_array($varOrderInfoSelect)){
										//print_r($varOrderInfo);
										 $varUpgraderId=$varOrderInfo['UpgraderId'];							
										}				
									}
								}else{
										$varUpgraderId=$val['UserID'];

									}
									
									$varUserCondition  = " WHERE UserId='".$varUpgraderId."'"; 
								
								$varUserFields 	 = array('Email','Status');							 
								 $varUserInfoSelect	= $objOffline->select('cm_users',$varUserFields,$varUserCondition,0);	
								while ($varUserInfo=mysql_fetch_array($varUserInfoSelect)){
									//print_r($varOrderInfo);
									 $varEmail=$varUserInfo['Email'];
									 $varStatus=$varUserInfo['Status'];
									$expemail = explode("@",$varEmail);
									 $approvedby=$expemail[0];
								}

								 $varBranchCondition  = " WHERE BranchId='".$val['PaymentType']."'"; 
								$varBranchFields 	 = array('BranchName');
																	 
									$varBranchInfoSelect	= $objOffline->select('cm_branches',$varBranchFields,$varBranchCondition,0);	
										while ($varBranchInfo=mysql_fetch_array($varBranchInfoSelect)){
											  $varbranch=$varBranchInfo['BranchName'];							
										}				
									
								
								?>
							<tr>
							<td class="smalltxt" width="5%" bgcolor="#ffffff" align="center"><?php echo $i++; ?></td>
							<td class="smalltxt" width="10%" bgcolor="#ffffff" align="center"><?php echo $val["OrderId"]; ?></td>
							<td class="smalltxt" width="10%" bgcolor="#ffffff" align="center"><?php echo $val["Currency"]?> <?php echo $val["Amount"]; ?></td>
							<td class="smalltxt" width="10%" bgcolor="#ffffff" align="center"><?php 
								if($val["PaymentMode"]=="-"){echo"-----";}else{echo $varArrPaymentMode[$val["PaymentMode"]];}?></td>
							<td class="smalltxt" width="10%" bgcolor="#ffffff" align="center"><?php echo $val["Date"];?></td>
							<td class="smalltxt" width="10%" bgcolor="#ffffff" align="center">
							<?php echo $varbranch;?></td>
							<td class="smalltxt" width="15%" style="padding:5px" bgcolor="#ffffff" align="center"><?php 
								if($val["Comments"]!=""){echo $val["Comments"];}else {echo"-----";}?></td>
							<td class="smalltxt" width="10%" bgcolor="#ffffff" align="center"><?php echo $arrPrdPackages[$val["ProductId"]];?></td>
							<td class="smalltxt" width="15%" bgcolor="#ffffff" align="center"><?php echo $approvedby;?> </td>
							<td class="smalltxt" width="15%" bgcolor="#ffffff" align="center"><?php 
									if($val["Payment"]=="Payment"){echo "Profile Payment";}else{echo  "Profile Refund Payment";}?> </td>
							<td class="smalltxt" width="10%" bgcolor="#ffffff" align="center"><?php  
									if($val["Discount"]!="0.00"){
										echo $val["Discount"].'%';
										} if(($val["Discount"]!="0.00")
											&&($val["DiscountFlatRate"]!="0.00")){echo " & ";
										} if($val["DiscountFlatRate"]!="0.00"){
										echo "Amount".$val["DiscountFlatRate"];}								 
										 if(($val["Discount"]=="0.00")									&&($val["DiscountFlatRate"]=="0.00")){
											echo "------";
										};?></td>
						</tr>
						<?php }?>
						<tr height="15" bgcolor="#ffffff">
						<td class="smalltxt bold" colspan="11" align="center"><?php echo $norcd; ?></td>
						</tr>
						
					<?php } ?>
						
					</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="10" colspan="11"></td></tr>
</table>
<?php
//UNSET OBJECT
unset($objCommon);
?>