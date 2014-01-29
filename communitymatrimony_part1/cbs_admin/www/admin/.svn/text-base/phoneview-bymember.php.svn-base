<?php
//FILE INCLUDES
$varRootBasePathh = '/home/product/community';
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/domainlist.cil14');

//OBJECT DECLARTION
$objSlave	= new DB;
//print_r($_REQUEST);"

$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

if($_REQUEST['frmPhoneByMemberSubmit']=="yes"){
$varMatriid=$_REQUEST['matriid'];

$argCondition		    = "WHERE Opposite_MatriId=".$objSlave->doEscapeString($varMatriid,$objSlave);
$varViewedNoOfResults	= $objSlave->numOfRecords($varTable['PHONEVIEWLIST'],'MatriID',$argCondition);
$varViewedInfo1	        = $objSlave->selectAll($varTable['PHONEVIEWLIST'],$argCondition,0);

}
?>

<table border="0" cellpadding="0" cellspacing="0" align="left" width="545">	
<form name="frmPhoneByMember" method="post">
<input type="hidden" name="frmPhoneByMemberSubmit" value="yes">
	<tr>
		<td class="heading" style="padding-left:15px;"> Phone Number Viewed by Member</td>		
	</tr>
	<tr><td height="20"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><b>Enter Matrimony Id </b>&nbsp;&nbsp;<input type=text name="matriid" value="<?=$varMatriid;?>" size="20" class="inputtext">	&nbsp;&nbsp;&nbsp;<input type="submit" value="Search MatriId" class="button" onClick="return funPhoneByMember();"></td>
	</tr>
	<tr>
		<td height="5px">&nbsp;</td>
	</tr>
</form>
<br clear="all"><br>
</table>
<?php 
if ($_REQUEST["frmPhoneByMemberSubmit"]=="yes"){
  if($varViewedNoOfResults==0){?>
	<table align="center" width="50%">
		<tr>
			<td align="center" class="errortxt">
				<?php echo "No Records Found";?>
			</td>
		</tr>
	</table>
  <?php }?> 
			
		<table border="0" cellpadding="5" cellspacing="0" align="center" width="90%" class="formborder" >
		<?php if($varViewedNoOfResults>0){?>
			<tr bgcolor="#EFEFEF">
				<td class="smalltxt boldtxt" style="padding-left:16px;" align="center" width="35%" >Matrimony-Id </td>
				<td class="smalltxt boldtxt" style="padding-left:16px;" align="center" width="35%" >Date Viewed</td>
			</tr>
			
					<?php while($varViewedInfo = mysql_fetch_array($varViewedInfo1)){	
		?>
			<tr>
				<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" align="center"><?=$varViewedInfo['MatriId']?$varViewedInfo['MatriId']:'-';?></td>
				<td class="smalltxt" style="padding-left:16px;" width="35%" align="center">
				<?=$varViewedInfo['Date_Viewed']?$varViewedInfo['Date_Viewed']:'-';?></td>
			</tr>
			<?php } 
				}?>				
		</table>
		<table border="0" cellpadding="5" cellspacing="0" align="center" width="90%">
			<tr>
				<td align="center" class="mediumtxt"><a href="index.php?act=phoneview-bymember">View Other Profiles</a></td>
			</tr>
		</table>
<?php	
	}
?>
<script language="javascript">
function funPhoneByMember() {
	var frmName = document.frmPhoneByMember;
	if (frmName.matriid.value=="" ) {
		alert("Please enter  Matrimony-Id");
		frmName.matriid.focus();
		return false;
	}
	frmName.frmPhoneByMember.value='yes';
	frmName.submit();
	return true;
}//funViewProfileId
</script>