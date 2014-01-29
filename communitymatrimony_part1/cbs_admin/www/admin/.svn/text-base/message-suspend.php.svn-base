<?php
//FILE INCLUDES
$varRootBasePathh = '/home/product/community';
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/domainlist.cil14');

//OBJECT DECLARTION
$objSlave	= new DB;
//print_r($_REQUEST);"

$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

if($_REQUEST['frmMessageSuspendSubmit']=="yes"){
$varMatriid=$_REQUEST['matriid'];

$argCondition		        = "WHERE MatriId=".$objSlave->doEscapeString($varMatriid,$objSlave);
$varSuspendedNoOfResults	= $objSlave->numOfRecords($varTable['MEMBERSUSPENDEDINFO'],'MatriID',$argCondition);
$varSuspendedInfo1	        = $objSlave->selectAll($varTable['MEMBERSUSPENDEDINFO'],$argCondition,0);

}
?>

<table border="0" cellpadding="0" cellspacing="0" align="left" width="545">	
<form name="frmMessageSuspend" method="post">
<input type="hidden" name="frmMessageSuspendSubmit" value="yes">
	<tr>
		<td class="heading" style="padding-left:15px;"> Profile Suspended Information</td>		
	</tr>
	<tr><td height="20"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><b>Enter Matrimony Id </b>&nbsp;&nbsp;<input type=text name="matriid" value="<?=$varMatriid;?>" size="20" class="inputtext">	&nbsp;&nbsp;&nbsp;<input type="submit" value="Search MatriId" class="button" onClick="return funMessageSuspend();"></td>
	</tr>
	<tr>
		<td height="5px">&nbsp;</td>
	</tr>
</form>
<br clear="all"><br>
</table>
<?php 
if ($_REQUEST["frmMessageSuspendSubmit"]=="yes"){
  if($varSuspendedNoOfResults==0){?>
	<table align="center" width="50%">
		<tr>
			<td align="center" class="errortxt">
				<?php echo "No Records Found";?>
			</td>
		</tr>
	</table>
  <?php }else if($varSuspendedNoOfResults>0){
		while($varSuspendedInfo = mysql_fetch_array($varSuspendedInfo1)){	
		?>
			
		<table border="0" cellpadding="5" cellspacing="0" align="center" width="90%" class="formborder" >
			<tr bgcolor="#EFEFEF">
				<td class="smalltxt boldtxt" style="padding-left:16px;" align="center" width="35%" colspan="2">Member Suspended Information </td>

			</tr>
			<tr>
				<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Matrimony Id : </td>
				<td class="smalltxt" style="padding-left:16px;" width="35%">
				<?=$varSuspendedInfo['MatriId']?$varSuspendedInfo['MatriId']:'-';?></td>
			</tr>						
			<tr>
				<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Message Send to : </td>
				<td class="smalltxt" style="padding-left:16px;" width="35%">
				<?=$varSuspendedInfo['Opposite_MatriId']?$varSuspendedInfo['Opposite_MatriId']:'-';?></td>
			</tr>
			<tr>
				<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Abusive Word  : </td>
				<td class="smalltxt" style="padding-left:16px;" width="35%">
				<?=$varSuspendedInfo['Abusive_word']?$varSuspendedInfo['Abusive_word']:'-';?></td>
			</tr>
			<tr>
				<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Total Abusive Content : </td>
				<td class="smalltxt" style="padding-left:16px;" width="35%">
				<?=$varSuspendedInfo['Abusive_Content']?$varSuspendedInfo['Abusive_Content']:'-';?></td>
			</tr>
			<tr>
				<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Message Sent Date : </td>
				<td class="smalltxt" style="padding-left:16px;" width="35%">
				<?=$varSuspendedInfo['Date_Sent']?$varSuspendedInfo['Date_Sent']:'-';?></td>
			</tr>
			
		</table>
<?php 
		}
	}?>
	<table align="center" width="50%">
		<tr >
			<td align="center" class="mediumtxt"> <a href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=message-suspend"> View Other profiles</a>
			
			</td>
		</tr>
	</table>
	
<?php } ?>
<script language="javascript">
function funMessageSuspend() {
	var frmName = document.frmMessageSuspend;
	if (frmName.matriid.value=="" ) {
		alert("Please enter  Matrimony-Id");
		frmName.matriid.focus();
		return false;
	}
	frmName.frmMessageSuspend.value='yes';
	frmName.submit();
	return true;
}//funViewProfileId
</script>