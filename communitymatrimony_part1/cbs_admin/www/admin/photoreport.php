<?php
$varRootPath = $_SERVER['DOCUMENT_ROOT'];
$varBasePath = dirname($varRootPath);

include_once($varBasePath.'/www/admin/includes/userLoginCheck.php');
include_once($varBasePath.'/www/admin/includes/admin-privilege.cil14');
include_once($varBasePath.'/conf/dbinfo.cil14');
include_once($varBasePath.'/lib/clsDB.php');

$cookValue		= split('&', $_COOKIE['adminLoginInfo']);
$varUsername	= $cookValue[1];
$varSupportTable= 'support_validation_report';
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

if($_POST['frmSubmit']=='yes'){
	$varFromdate	= $_POST['fromdate'].' '.$_POST['fromHour'].':'.$_POST['fromMin'].':00';
	$varTodate		= $_POST['todate'].' '.$_POST['toHour'].':'.$_POST['toMin'].':59';
	$arrFields		= array('userid', 'SUM(notifycustomer) AS reject', 'SUM(profilestatus) AS added');
	$varWhereCond	= '';
	if($varWholeReport == 'yes'){
		if(in_array('all', $_POST['userids'])){
			$varWhereCond = "WHERE reporttype=3 AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid";
			$varPhoneWhereCond = "WHERE reporttype=4 AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,editprofile";
			$varSucessWhereCond = "WHERE reporttype=7 AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,editprofile";
			$varHoroWhereCond = "WHERE reporttype=5 AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid";
			$varPmodiWhereCond = "WHERE reporttype=6 AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,profilestatus";
			$varProfileWhereCond = "WHERE reporttype=1 AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,profilestatus";
		}else if(count($_POST['userids'])>1){
			$varUserIds	  = join("', '", $_POST['userids']);
			$varWhereCond = "WHERE reporttype=3 AND userid IN('".$varUserIds."') AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid";
			$varPhoneWhereCond = "WHERE reporttype=4 AND userid IN('".$varUserIds."') AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,editprofile";
			$varSucessWhereCond = "WHERE reporttype=7 AND userid IN('".$varUserIds."') AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,editprofile";
			$varHoroWhereCond = "WHERE reporttype=5 AND userid IN('".$varUserIds."') AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid";
			$varPmodiWhereCond = "WHERE reporttype=6 AND userid IN('".$varUserIds."') AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,profilestatus";
			$varProfileWhereCond = "WHERE reporttype=1 AND userid IN('".$varUserIds."') AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,profilestatus";
		}else if(count($_POST['userids'])==1){
			$varWhereCond = "WHERE reporttype=3 AND userid='".$_POST['userids'][0]."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB);
			$varPhoneWhereCond = "WHERE reporttype=4 AND userid='".$_POST['userids'][0]."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,editprofile" ;
			$varSucessWhereCond = "WHERE reporttype=7 AND userid='".$_POST['userids'][0]."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,editprofile";
			$varHoroWhereCond = "WHERE reporttype=5 AND userid='".$_POST['userids'][0]."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB);
			$varPmodiWhereCond = "WHERE reporttype=6 AND userid='".$_POST['userids'][0]."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,profilestatus";
			$varProfileWhereCond = "WHERE reporttype=1 AND userid='".$_POST['userids'][0]."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,profilestatus";
		}else{
			$varWhereCond = "WHERE reporttype=3 AND userid='".$varUsername."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB);
			$varPhoneWhereCond = "WHERE reporttype=4 AND userid='".$varUsername."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,editprofile";
			$varSucessWhereCond = "WHERE reporttype=7 AND userid='".$varUsername."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,editprofile";
			$varHoroWhereCond = "WHERE reporttype=5 AND userid='".$varUsername."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB);
			$varPmodiWhereCond = "WHERE reporttype=6 AND userid='".$varUsername."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,profilestatus";
			$varProfileWhereCond = "WHERE reporttype=1 AND userid='".$varUsername."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,profilestatus";
		}
	}else{
			$varWhereCond = "WHERE reporttype=3 AND userid='".$varUsername."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB);
			$varPhoneWhereCond = "WHERE reporttype=4 AND userid='".$varUsername."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,editprofile";
			$varSucessWhereCond = "WHERE reporttype=7 AND userid='".$varUsername."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,editprofile";
			$varHoroWhereCond = "WHERE reporttype=5 AND userid='".$varUsername."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB);
			$varPmodiWhereCond = "WHERE reporttype=6 AND userid='".$varUsername."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,profilestatus";
			$varProfileWhereCond = "WHERE reporttype=1 AND userid='".$varUsername."' AND validateddate>=".$objSlaveDB->doEscapeString($varFromdate,$objSlaveDB)." AND validateddate<".$objSlaveDB->doEscapeString($varTodate,$objSlaveDB)." GROUP BY userid,profilestatus";
	}	

	//Photo Validation Report
	$varResultSet = $objSlaveDB->select($varSupportTable, $arrFields, $varWhereCond, 0);
	$varResultCont  = '<br><br><br><br><table width="542" cellspacing="2" cellpadding="2" border="1" style="border:1px solid"><tr><td colspan="3"><b>Photo Validation Report</b></td></tr><tr class="mediumtxt boldtxt"><td>Username</td><td>Added</td><td>Rejected</td></tr>';
	if(mysql_num_rows($varResultSet)>0){
		$varTotalAdded	= 0;
		$varTotalReject	= 0;
		while($row=mysql_fetch_assoc($varResultSet)){
			$varResultCont .= '<tr class="mediumtxt"><td>'.$row['userid'].'</td><td>'.$row['added'].'</td><td>'.$row['reject'].'</td></tr>';
			$varTotalReject = $varTotalReject+$row['reject'];
			$varTotalAdded = $varTotalAdded+$row['added'];
		}
		if($varTotalAdded > 0 || $varTotalReject>0){
			$varResultCont .= '<tr class="mediumtxt boldtxt"><td>Total</td><td>'.$varTotalAdded.'</td><td>'.$varTotalReject.'</td></tr>';
		}
		
	}else{
		$varResultCont .= '<tr><td colspan="3" align="center">Records not available</td></tr>';
	}
	$varResultCont .= '</table>';

	//Phone Validation Report
	$arrPhotoofFields		= array('userid', 'editprofile', 'COUNT(editprofile) AS Cnt');
	$varPhoneResultSet = $objSlaveDB->select($varSupportTable, $arrPhotoofFields, $varPhoneWhereCond, 0);

	$varPhoneResultCont  = '<br><br><table width="542" cellspacing="2" cellpadding="2" border="1" style="border:1px solid"><tr><td colspan="4"><b>Phone Not Working Report</b></td></tr><tr class="mediumtxt boldtxt"><td>Username</td><td>Approved</td><td>Rejected</td></tr>';

	if(mysql_num_rows($varPhoneResultSet)>0){
		while($row=mysql_fetch_assoc($varPhoneResultSet)){
			//if($row['profilestatus']=='') {echo "Hai";$row['profilestatus']='X';}
			$arrPhotoUserDet[$row['userid']][$row['editprofile']] = $row['Cnt'];
		}

		$varTotalApproved	= 0;
		$varTotalRejected	= 0;		
		foreach($arrPhotoUserDet as $key=>$arrSingle) {
			$arrSingle['1'] = $arrSingle['1']==''?0:$arrSingle['1'];
			$arrSingle['0'] = $arrSingle['0']==''?0:$arrSingle['0'];
			
			$varPhoneResultCont .= '<tr class="mediumtxt"><td>'.$key.'</td><td>'.$arrSingle['1'].'</td><td>'.$arrSingle['0'].'</td></tr>';

			$varTotalApproved	= $varTotalApproved+$arrSingle['1'];
			$varTotalRejected	= $varTotalRejected+$arrSingle['0'];			
		}
		
		if($varTotalApproved>0 ||  $varTotalRejected>0 ){
			$varPhoneResultCont .= '<tr class="mediumtxt boldtxt"><td>Total</td><td>'.$varTotalApproved.'</td><td>'.$varTotalRejected.'</td></tr>';
		}
		$varPhoneResultCont .= '</table>';
	}else{
		$varPhoneResultCont .= '<tr><td colspan="4" align="center">Records not available</td></tr>';
	}
	$varPhoneResultCont .= '</table>';


	//Sucess Validation Report
	$arrSucessofFields		= array('userid', 'editprofile', 'COUNT(editprofile) AS Cnt');
	$varSucessResultSet = $objSlaveDB->select($varSupportTable, $arrSucessofFields, $varSucessWhereCond, 0);

	$varSucessResultCont  = '<br><br><table width="542" cellspacing="2" cellpadding="2" border="1" style="border:1px solid"><tr><td colspan="4"><b>Sucess Stories Report</b></td></tr><tr class="mediumtxt boldtxt"><td>Username</td><td>Approved</td><td>Rejected</td></tr>';

	if(mysql_num_rows($varSucessResultSet)>0){
		while($row=mysql_fetch_assoc($varSucessResultSet)){
			//if($row['profilestatus']=='') {echo "Hai";$row['profilestatus']='X';}
			$arrSucessUserDet[$row['userid']][$row['editprofile']] = $row['Cnt'];
		}

		$varTotalApproved	= 0;
		$varTotalRejected	= 0;		
		foreach($arrSucessUserDet as $key=>$arrSingle) {
			$arrSingle['2'] = $arrSingle['2']==''?0:$arrSingle['2'];
			$arrSingle['3'] = $arrSingle['3']==''?0:$arrSingle['3'];
			
			$varSucessResultCont .= '<tr class="mediumtxt"><td>'.$key.'</td><td>'.$arrSingle['2'].'</td><td>'.$arrSingle['3'].'</td></tr>';

			$varTotalApproved	= $varTotalApproved+$arrSingle['2'];
			$varTotalRejected	= $varTotalRejected+$arrSingle['3'];			
		}
		
		if($varTotalApproved>0 ||  $varTotalRejected>0 ){
			$varSucessResultCont .= '<tr class="mediumtxt boldtxt"><td>Total</td><td>'.$varTotalApproved.'</td><td>'.$varTotalRejected.'</td></tr>';
		}
		$varSucessResultCont .= '</table>';
	}else{
		$varSucessResultCont .= '<tr><td colspan="4" align="center">Records not available</td></tr>';
	}
	$varSucessResultCont .= '</table>';

	

	//Horoscope Validation Report
	$varHoroResultSet = $objSlaveDB->select($varSupportTable, $arrFields, $varHoroWhereCond, 0);
	$varHoroResultCont= '<br><br><br><br><table width="542" cellspacing="2" cellpadding="2" border="1" style="border:1px solid"><tr><td colspan="3"><b>Horoscope Validation Report</b></td></tr><tr class="mediumtxt boldtxt"><td>Username</td><td>Added</td><td>Rejected</td></tr>';
	if(mysql_num_rows($varHoroResultSet)>0){
		$varTotalAdded	= 0;
		$varTotalReject	= 0;
		while($row=mysql_fetch_assoc($varHoroResultSet)){
			$varHoroResultCont .= '<tr class="mediumtxt"><td>'.$row['userid'].'</td><td>'.$row['added'].'</td><td>'.$row['reject'].'</td></tr>';
			$varTotalReject = $varTotalReject+$row['reject'];
			$varTotalAdded = $varTotalAdded+$row['added'];
		}
		if($varTotalAdded > 0 || $varTotalReject>0){
			$varHoroResultCont .= '<tr class="mediumtxt boldtxt"><td>Total</td><td>'.$varTotalAdded.'</td><td>'.$varTotalReject.'</td></tr>';
		}
		
	}else{
		$varHoroResultCont .= '<tr><td colspan="3" align="center">Records not available</td></tr>';
	}
	$varHoroResultCont .= '</table>';


	//Profile Validation Report
	$arrFields		= array('userid', 'profilestatus', 'COUNT(profilestatus) AS Cnt');
	$varProfileResultSet = $objSlaveDB->select($varSupportTable, $arrFields, $varProfileWhereCond, 0);

	$varProfileResultCont  = '<br><br><table width="542" cellspacing="2" cellpadding="2" border="1" style="border:1px solid"><tr><td colspan="4"><b>Profile Validation Report</b></td></tr><tr class="mediumtxt boldtxt"><td>Username</td><td>Approved</td><td>Ignored</td><td>Rejected</td></tr>';

	if(mysql_num_rows($varProfileResultSet)>0){
		while($row=mysql_fetch_assoc($varProfileResultSet)){
			//if($row['profilestatus']=='') {echo "Hai";$row['profilestatus']='X';}
			$arrUserDet[$row['userid']][$row['profilestatus']] = $row['Cnt'];
		}

		$varTotalApproved	= 0;
		$varTotalIgnored	= 0;
		$varTotalRejected	= 0;
		$varTotalTimeouted	= 0;
		//$varTotalNothingDone= 0;

		foreach($arrUserDet as $key=>$arrSingle) {
			$arrSingle['A'] = $arrSingle['A']==''?0:$arrSingle['A'];
			$arrSingle['I'] = $arrSingle['I']==''?0:$arrSingle['I'];
			$arrSingle['R'] = $arrSingle['R']==''?0:$arrSingle['R'];
			//$arrSingle['Z'] = $arrSingle['Z']==''?0:$arrSingle['Z'];
			//$arrSingle['X'] = $arrSingle['X']==''?0:$arrSingle['X'];

			$varProfileResultCont .= '<tr class="mediumtxt"><td>'.$key.'</td><td>'.$arrSingle['A'].'</td><td>'.$arrSingle['I'].'</td><td>'.$arrSingle['R'].'</td></tr>';

			$varTotalApproved	= $varTotalApproved+$arrSingle['A'];
			$varTotalIgnored	= $varTotalIgnored+$arrSingle['I'];
			$varTotalRejected	= $varTotalRejected+$arrSingle['R'];
			//$varTotalTimeouted	= $varTotalTimeouted+$arrSingle['Z'];
			//$varTotalNothingDone= $varTotalNothingDone+$arrSingle['X'];
		}
		
		if($varTotalApproved>0 || $varTotalIgnored>0 || $varTotalRejected>0 || $varTotalTimeouted>0 || $varTotalNothingDone>0){
			$varProfileResultCont .= '<tr class="mediumtxt boldtxt"><td>Total</td><td>'.$varTotalApproved.'</td><td>'.$varTotalIgnored.'</td><td>'.$varTotalRejected.'</td></tr>';
		}
		$varProfileResultCont .= '</table>';
	}else{
		$varProfileResultCont .= '<tr><td colspan="4" align="center">Records not available</td></tr>';
	}
	$varProfileResultCont .= '</table>';


	//Profile Modification Report
	$arrProfFields		= array('userid', 'profilestatus', 'COUNT(profilestatus) AS Cnt');
	$varModificationResultSet = $objSlaveDB->select($varSupportTable, $arrProfFields, $varPmodiWhereCond, 0);

	$varModificationResultCont  = '<br><br><table width="542" cellspacing="2" cellpadding="2" border="1" style="border:1px solid"><tr><td colspan="4"><b>Profile Modification Report</b></td></tr><tr class="mediumtxt boldtxt"><td>Username</td><td>Approved</td><td>Rejected</td></tr>';

	if(mysql_num_rows($varModificationResultSet)>0){
		while($row=mysql_fetch_assoc($varModificationResultSet)){
			//if($row['profilestatus']=='') {echo "Hai";$row['profilestatus']='X';}
			$arrProfUserDet[$row['userid']][$row['profilestatus']] = $row['Cnt'];
		}

		$varTotalApproved	= 0;
		$varTotalRejected	= 0;		
		foreach($arrProfUserDet as $key=>$arrSingle) {
			$arrSingle['A'] = $arrSingle['A']==''?0:$arrSingle['A'];
			$arrSingle['R'] = $arrSingle['R']==''?0:$arrSingle['R'];
			
			$varModificationResultCont .= '<tr class="mediumtxt"><td>'.$key.'</td><td>'.$arrSingle['A'].'</td><td>'.$arrSingle['R'].'</td></tr>';

			$varTotalApproved	= $varTotalApproved+$arrSingle['A'];
			$varTotalRejected	= $varTotalRejected+$arrSingle['R'];			
		}
		
		if($varTotalApproved>0 ||  $varTotalRejected>0 ){
			$varModificationResultCont .= '<tr class="mediumtxt boldtxt"><td>Total</td><td>'.$varTotalApproved.'</td><td>'.$varTotalRejected.'</td></tr>';
		}
		$varModificationResultCont .= '</table>';
	}else{
		$varModificationResultCont .= '<tr><td colspan="4" align="center">Records not available</td></tr>';
	}
	$varModificationResultCont .= '</table>';
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
<?=$varPhoneResultCont;?>
<?=$varSucessResultCont;?>
<?=$varHoroResultCont;?>
<?=$varProfileResultCont;?>
<?=$varModificationResultCont;?>