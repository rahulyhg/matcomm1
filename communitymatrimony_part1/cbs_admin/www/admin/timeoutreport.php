<?php
$varRootPath = $_SERVER['DOCUMENT_ROOT'];
$varBasePath = dirname($varRootPath);

include_once($varBasePath.'/www/admin/includes/userLoginCheck.php');
include_once($varBasePath.'/www/admin/includes/admin-privilege.cil14');
include_once($varBasePath.'/conf/dbinfo.cil14');
include_once($varBasePath.'/lib/clsDB.php');

$cookValue		= split('&', $_COOKIE['adminLoginInfo']);
$varUsername	= $cookValue[1];
$varSupportTable= $varTable['SUPPORT_VALIDATION_REPORT'];
$varAdminTable	= $varTable['ADMINLOGININFO'];
$varResultCont  = '';

$varWholeReport = array_key_exists($varUsername, $arrManageUsers) ? 'yes' : 'no';
if($varWholeReport=='no'){
	$varWholeReport =(($varUsername=='pramod')||($varUsername=='dinesh')||($varUsername=='senthilkumar'))?'yes' : 'no';
}

$objSlaveDB	= new DB;

$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

if($varWholeReport == 'yes'){
	$varUsersList	= '';
	$varWhereCond	= '';
	$arrFields		= array('User_Name');
	$varResultSet	= $objSlaveDB->select($varAdminTable, $arrFields, $varWhereCond, 0);
	while($row = mysql_fetch_assoc($varResultSet)){
		$varUsersList .= '<option value="'.$row['User_Name'].'">'.$row['User_Name'].'</option>';
	}
}

if($_REQUEST['newwin']=='yes') {
	$varFromdate	= $_REQUEST['fromdate'];
	$varTodate		= $_REQUEST['todate'];
	$varUserId		= $_REQUEST['userid'];
	$varWhereCond	= "WHERE reporttype=1 AND userid=".$objSlaveDB->doEscapeString($varUserId,$objSlaveDB)." AND profilestatus='Z' AND downloadeddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND downloadeddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB);
	$arrFields		= array('matriid');
	$varResultMatSet= $objSlaveDB->select($varSupportTable, $arrFields, $varWhereCond, 0);

	$varResultCont  = '<br><br><table width="380" cellspacing="2" cellpadding="2" border="1" style="border:1px solid"><tr><td colspan="2"><b>Timeout Report for User</b></td></tr><tr class="mediumtxt boldtxt"><td>Username</td><td>MatriId</td></tr>';
	if(mysql_num_rows($varResultMatSet)>0){
		while($row=mysql_fetch_assoc($varResultMatSet)){
			$varResultCont .= '<tr class="mediumtxt"><td>&nbsp;'.$varUserId.'</td><td>&nbsp;'.$row['matriid'].'</td></tr>';
		}
	}else{
		$varResultCont .= '<tr><td colspan="2" align="center">Records not available</td></tr>';
	}
	$varResultCont .= '</table>';

	echo $varResultCont;exit;
}

if($_POST['frmSubmit']=='yes'){
	$varFromdate	= $_POST['fromdate'].' '.$_POST['fromHour'].':'.$_POST['fromMin'].':00';
	$varTodate		= $_POST['todate'].' '.$_POST['toHour'].':'.$_POST['toMin'].':59';
	$varWhereCond	= '';
	
	if($varWholeReport == 'yes'){
		if(in_array('all', $_POST['userids'])){
			$varWhereCond = "WHERE reporttype=1 AND profilestatus='Z' AND downloadeddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)."  AND downloadeddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)."  GROUP BY userid";
		}else if(count($_POST['userids'])>1){
			$varUserIds	  = join("', '", $_POST['userids']);
			$varWhereCond = "WHERE reporttype=1 AND profilestatus='Z' AND userid IN('".$varUserIds."') AND downloadeddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)."  AND downloadeddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid";
		}else if(count($_POST['userids'])==1){
			$varWhereCond = "WHERE reporttype=1 AND profilestatus='Z' AND userid=".$objSlaveDB->doEscapeString($_POST['userids'][0],$objSlaveDB)." AND downloadeddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)."  AND downloadeddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB);
		}else{
			$varWhereCond = "WHERE reporttype=1 AND profilestatus='Z' AND userid=".$objSlaveDB->doEscapeString($varUsername,$objSlaveDB)." AND downloadeddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)."  AND downloadeddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB);
		}
	}else{
		$varWhereCond = "WHERE reporttype=1 AND profilestatus='Z' AND userid=".$objSlaveDB->doEscapeString($varUsername,$objSlaveDB)." AND downloadeddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)."  AND downloadeddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB);
	}
	
	//Photo Validation Report
	$arrFields		= array('userid', 'COUNT(matriid) AS Total');
	$varResultSet	= $objSlaveDB->select($varSupportTable, $arrFields, $varWhereCond, 0);
	$varResultCont  = '<br><br><br><br><table width="542" cellspacing="2" cellpadding="2" border="1" style="border:1px solid"><tr><td colspan="3"><b>Timeout Report</b></td></tr><tr class="mediumtxt boldtxt"><td>Username</td><td>Total</td><td>View MatriId(s)</td></tr>';
	if(mysql_num_rows($varResultSet)>0){
		$varGrandTotal	= 0;
		while($row=mysql_fetch_assoc($varResultSet)){
			$varResultCont .= '<tr class="mediumtxt"><td>&nbsp;'.$row['userid'].'</td><td>&nbsp;'.$row['Total'].'</td><td>&nbsp;<a href="javascript:;" onclick="showMatriIds(\''.$row['userid'].'\',\''.$varFromdate.'\',\''.$varTodate.'\');">view</a></td></tr>';
			$varGrandTotal = $varGrandTotal+$row['Total'];
		}
		if($varGrandTotal > 0){
			$varResultCont .= '<tr class="mediumtxt boldtxt"><td>&nbsp;Total</td><td colspan="2">&nbsp;'.$varGrandTotal.'</td></tr>';
		}
	}else{
		$varResultCont .= '<tr><td colspan="3" align="center">Records not available</td></tr>';
	}
	$varResultCont .= '</table>';

	
}

function getselectbox($argSelName, $argSelVal){
	$varOptions	= '<select style="border:1px solid #B3B3B3;font-size:11px;font-weight:normal;" name="'.$argSelName.'">';
	for($i=0; $i<$argSelVal; $i++){
		$varDispVal	= ($i < 10) ? "0".$i : $i;
		$varOptions.= '<option value="'.$varDispVal.'">'.$varDispVal.'</option>'; 
	}
	$varOptions .= '</select>';
	return $varOptions;
}
?>
<br clear="all">
<script language="javascript" src="<?=$confValues['JSPATH']?>/calenderJS.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/search.js"></script>
<script>
function validate(){
	if(document.frmReport.fromdate.value == ''){
		alert('Please select the from date');
		return false;
	}else if(document.frmReport.todate.value == ''){
		alert('Please select the to date');
		return false;
	}
	return true;
}

function showMatriIds(username,fromdate,todate) {
window.open("timeoutreport.php?newwin=yes&userid="+username+"&fromdate="+fromdate+"&todate="+todate,'','directories=no,width=400,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');
}

function selectUser() {
	var totleng = document.frmReport.userids.length;
	for(i=0; i<totleng; i++) {
		document.frmReport.userids.options[i].selected = true;
	}
	return true;
}
</script>

<table width="542" cellspacing="2" cellpadding="2">
	<tr class="mediumtxt boldtxt"><td colspan="4">User wise report</td></tr>
	<form name="frmReport" method="post" onsubmit="return validate();">
	<? if($varWholeReport == 'yes'){?>
	<tr class="mediumtxt">
		<td>Select User</td>
		<td width="40"><select style="border:1px solid #B3B3B3;font-size:11px;font-weight:normal;width:170px;" name="tempuserids" multiple size="4" ><option value="all">All Users</option><?=$varUsersList;?></select></td>
		<td width="10" align="center">
			<input class="button" type="button" onclick="moveOptions(this.form.tempuserids, this.form.userids);" value=">"><br><br>
			<input class="button" type="button" onclick="moveOptions(this.form.userids, this.form.tempuserids);" value="<">
		</td>
		<td width="40"><select style="border:1px solid #B3B3B3;font-size:11px;font-weight:normal;width:170px;" name="userids[]" id="userids" multiple size="4"></select></td>
	</tr>
	<? } ?>
	<tr class="mediumtxt">
		<td>From date</td>
		<td colspan="3">
		<input type="text" name="fromdate" readonly="" value="" style="width:120px" onclick="displayDatePicker('fromdate', document.frmReport.fromdate, 'ymd', '-');document.getElementById('datepicker').style.backgroundColor='#FFF0D3';">
		<?=getselectbox('fromHour', 24);?>
		<?=getselectbox('fromMin', 60);?>
		</td>
	</tr>
	<tr class="mediumtxt">
		<td>To date</td>
		<td colspan="3">
		<input type="text" name="todate" readonly="" value="" style="width:120px" onclick="displayDatePicker('todate', document.frmReport.todate, 'ymd', '-');document.getElementById('datepicker').style.backgroundColor='#FFF0D3';">
		<?=getselectbox('toHour', 24);?>
		<?=getselectbox('toMin', 60);?>
		</td>
	</tr>
	<tr class="mediumtxt">
		<td colspan="4" align="right">
			<input type="hidden" name="frmSubmit" value="yes">
			<input class="button" type="submit" name="submit" value="Submit" onClick="return selectUser();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>
<?=$varResultCont;?>