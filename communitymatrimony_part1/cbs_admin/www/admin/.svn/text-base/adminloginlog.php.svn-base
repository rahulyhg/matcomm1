<?php
#================================================================================================================
# Author 		: S.Naresh
# Start Date	: 2011-04-18
# End Date		: 2011-04-18
# Project		: MatrimonyProduct
# Module		: Admin Login Log #================================================================================================================

//BASE PATH
 $varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES

include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objSlave	= new DB;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION

$varUserName	= $_REQUEST['username'];
$varEmailUser	= $_REQUEST['emailusercheck'];
$varFromDate    = $_REQUEST['fromDate'];
$varToDate      = $_REQUEST['toDate'];


if($_REQUEST['frmAdminLoginLog']=="yes"){
	/*echo "<PRE>";
	print_r($_REQUEST);*/
		if(($varFromDate=="")&&($varUserName!="")){
			if($varEmailUser==1){
				$argCondition		        = "WHERE User_Name=".$objSlave->doEscapeString($varUserName,$objSlave);
			}else if($varEmailUser==2){
				$argCondition		        = "WHERE Email=".$objSlave->doEscapeString($varUserName,$objSlave);
			}
		}else if(($varFromDate!="")&&($varUserName!="")){
			if($varEmailUser==1){
				$argCondition		        = "WHERE Logged_In_At >= ".$objSlave->doEscapeString($varFromDate.' '.'00:00:00',$objSlave)." and Logged_In_At <= ".$objSlave->doEscapeString($varToDate.' '.'23:59:59',$objSlave)." and User_Name=".$objSlave->doEscapeString($varUserName,$objSlave);
			}else if($varEmailUser==2){				
				$argCondition		        = "WHERE Logged_In_At >= ".$objSlave->doEscapeString($varFromDate.' '.'00:00:00',$objSlave)." and Logged_In_At <= ".$objSlave->doEscapeString($varToDate.' '.'23:59:59',$objSlave)." and Email=".$objSlave->doEscapeString($varUserName,$objSlave);			
			}
		}

 $varAdminNoOfResults	= $objSlave->numOfRecords($varTable['ADMINLOGINLOG'],'User_Name',$argCondition);
 $varAdminInfo1	        = $objSlave->selectAll($varTable['ADMINLOGINLOG'],$argCondition,0);
}	

  $objSlave->dbClose();
 ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Admin Login Log</TITLE>
<script language="javascript" src="<?=$confValues['JSPATH']?>/calenderJS.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/search.js"></script>
</HEAD> 
<FORM METHOD=POST Name="frmAdminLog" ACTION="" onsubmit="return funAdminLoginLog();">
<input type="hidden" name="frmAdminLoginLog" value="yes">
	<table border=0 cellpadding=1 cellspacing=2 width='540'>
	<tr align=left>
		<td>
			<div style="color: rgb(51, 153, 51); font-size: 14px; font-weight: bold; margin: 5px;">Admin Login Log</div>
		</td>
	</tr>
	<tr align="center">
		<td height="10">&nbsp;</td>
	</tr>	
	<tr align="center">
		<td>
			<table  border="0" cellpadding="3" cellspacing="3" width="100%">
			<tr height="30px;">
				<td style="padding:0 0 0 25px;" class="mediumtxt"><b>User Name / Email</b></td>
				<td style="padding:0 0 0 33px;">
					<INPUT TYPE="text" NAME="username" class="mediumtxt"> <input type="radio" value="1" name="emailusercheck"><span class="mediumtxt">UserName<input type="radio" value="2" name="emailusercheck" checked><span class="mediumtxt">Email</span>
				</td>
			</tr>
			<tr class="mediumtxt">
				<td style="padding:0 0 0 25px;"><font class="mediumtxt">
					<b>Select date</b></font>
				</td>
				<td> 
					<font class="mediumtxt">From</font>&nbsp; <input type="text" name="fromDate" readonly="" value="" style="width:80px" onclick="displayDatePicker('fromDate', document.frmAdminLog.fromDate, 'ymd', '-');document.getElementById('datepicker').style.backgroundColor='#FFF0D3';">		&nbsp;&nbsp;  <font class="mediumtxt">To</font>	<input type="text" name="toDate" readonly="" value="" style="width:80px" onclick="displayDatePicker('toDate', document.frmAdminLog.toDate, 'ymd', '-');document.getElementById('datepicker').style.backgroundColor='#FFF0D3';">	
				</td>
			</tr>	    
			<tr>
				<td colspan="2" align="center">
					<INPUT TYPE="submit" name="submit" class="button" value="Submit">
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<?php if ($_REQUEST["frmAdminLoginLog"]=="yes"){
			if($varAdminNoOfResults==0){?>
	<tr>
		<td>
			<table align="center" width="50%">
			<tr>
				<td align="center" class="errortxt">
				<?php echo "No Records Found";?>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<?php }
		else if($varAdminNoOfResults>0){?>	
	<tr>
		<td>
			<table border='0' width="100%" class="formborder" cellpadding="1">
			<tr>
				<td class="adminformheader"><?php if($varEmailUser==1){echo "User_Name";}else{echo "Email";}?></td>
				<td class="adminformheader">Logged_In_At</td>
				<td class="adminformheader">Client_IP</td>
				<td class="adminformheader">Server_IP</td>
			</tr>
			<?php while($varAdminInfo = mysql_fetch_array($varAdminInfo1)){?>
			<tr>
				<td class="mediumtxt"><?php if($varEmailUser==1){echo $varAdminInfo['User_Name'];}else{echo $varAdminInfo['Email'];}?></td>
				<td class="mediumtxt"><?php echo $varAdminInfo['Logged_In_At'];?></td>
				<td class="mediumtxt"><?php echo$varAdminInfo['Client_IP'];?></td>
				<td class="mediumtxt"><?php echo$varAdminInfo['Server_IP'];?></td>
			</tr>
			<?php }	?>
			</table>	 
		</td>
	</tr>
	<tr>
		<table align="center" width="50%">
		<tr >
			<td align="center" class="mediumtxt"> <a href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=adminloginlog"> View Other profiles</a>
			
			</td>
		</tr>
	</table>
	</tr>
	<?php }}?>
	</table>
</FORM>
</HTML>

<SCRIPT LANGUAGE="JavaScript">
function  funAdminLoginLog()
{
  if(document.frmAdminLog.username.value =='')
   {
	document.frmAdminLog.username.focus();
	alert ("Enter UserName / Email");
	return false;
   }
    if(document.frmAdminLog.username.value =='')
   {
	document.frmAdminLog.username.focus();
	alert ("Enter UserName / Email");
	return false;
   }

  if(document.frmAdminLog.fromDate.value!='')
   {
      if(document.frmAdminLog.toDate.value=='')
		{
		  alert("Please Select Todate");
		  return false;
		}
   }
  document.frmAdminLog.submit();
}
</SCRIPT>