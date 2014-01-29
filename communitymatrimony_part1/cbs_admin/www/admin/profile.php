<?php
//FILE INCLUDES
$varRootBasePathh = '/home/product/community';
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/lib/clsRegister.php');

$varPrimary	  = $_REQUEST["primary"];   
//$varActStatus = $_REQUEST["actstatus"];
$varStatus	  = $_REQUEST["status"];  

//OBJECT DECLARTION
$objSlave	= new clsRegister;
//print_r($_REQUEST);

//DB CONNECTION
if($varStatus=='Inactive') {
	$objSlave->dbConnect('S',$varInactiveDbInfo['DATABASE']);
	$varTitle ='View Inactive Profile';
	$varActStatus ='no';
}else {
	$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
	$varTitle ='View Profile';
	$varActStatus ='yes';
}

function getDateMonthYear($argFormat,$argDateTime)
{
	if (trim($argDateTime) !="0000-00-00 00:00:00")
	{ $retDateValue = date($argFormat,strtotime($argDateTime)); }//if
	else $retDateValue="";
	return $retDateValue;
}//getDateMothYear

//CONTROL STATEMENT
if ($_POST["frmViewProfileSubmit"]=="yes") {

	$varTextValue 					= trim($_REQUEST["textboxvalue"]);
	if($varPrimary =='Email') {
		$argCondition				= "WHERE ml.MatriId = mi.MatriId AND ml.Email=".$objSlave->doEscapeString($varTextValue,$objSlave);
		$varCombinedTables			= $varTable['MEMBERLOGININFO'].' as ml,'.$varTable['MEMBERINFO'].' as mi';
		$argFields 					= array('mi.MatriId','mi.Date_Created','mi.Paid_Status','mi.Last_Payment','mi.Valid_Days');
		$varProfileRes				= $objSlave->select($varCombinedTables,$argFields,$argCondition,0);
		$varNumOfRecords			= mysql_num_rows($varProfileRes);
	} else if ($varPrimary =='BM-MatriId') {
		$argCondition				= "WHERE BM_MatriId=".$objSlave->doEscapeString($varTextValue,$objSlave);
		$argFields 					= array('MatriId','Date_Created','Paid_Status','Last_Payment','Valid_Days');
		$varProfileRes				= $objSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varNumOfRecords			= mysql_num_rows($varProfileRes);
	} else if ($varPrimary =='MatriId') {
		$argCondition				= "WHERE MatriId=".$objSlave->doEscapeString($varTextValue,$objSlave);
		$argFields 					= array('MatriId','Date_Created','Paid_Status','Last_Payment','Valid_Days');
		$varProfileRes				= $objSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varNumOfRecords			= mysql_num_rows($varProfileRes);
	} else if( $varPrimary =='Phone') {
		$argCondition				= "WHERE Contact_Mobile like '%".$objSlave->doEscapeString($varTextValue,$objSlave)."%'";
		$argFields 					= array('MatriId','Date_Created','Paid_Status','Last_Payment','Valid_Days');
		$varProfileRes				= $objSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varNumOfRecords			= mysql_num_rows($varProfileRes);
	}

	if($varStatus =='Deleted') {
		if ($varPrimary =='MatriId') {
		$argCondition				= "WHERE MatriId=".$objSlave->doEscapeString($varTextValue,$objSlave);
		$argFields 					= array('MatriId','Date_Created','Paid_Status','Last_Payment','Valid_Days');
		$varProfileRes				= $objSlave->select($varTable['MEMBERDELETEDINFO'],$argFields,$argCondition,0);
		$varNumOfRecords			= mysql_num_rows($varProfileRes);
	}
	if ($varPrimary =='Email') {
		$argCondition				= "WHERE Email=".$objSlave->doEscapeString($varTextValue,$objSlave);
		$argFields 					= array('MatriId','Date_Created','Paid_Status','Last_Payment','Valid_Days');
		$varProfileRes				= $objSlave->select($varTable['MEMBERDELETEDINFO'],$argFields,$argCondition,0);
		$varNumOfRecords			= mysql_num_rows($varProfileRes);
	}
	}
} //if

$objSlave->dbClose();

?>

<table border="0" cellpadding="0" cellspacing="0" align="left" width="545">
<form name="frmViewEmailProfile" method="post">
<input type="hidden" name="frmViewProfileSubmit" value="">
<input type="hidden" name="MatriId" value="">
	<tr><td height="10"></td></tr>
	<tr><td height="15" colspan="2"></td></tr>
	<tr>
	<td class="heading" style="padding-left:15px;">
		<input type="radio" name="status" value="Active" checked<?=$varStatus=="Active" ? "checked" : "";?>> View Active Profile
	    <input type="radio" name="status" value="Inactive" <?=$varStatus=="Inactive" ? "checked" : "";?>> View Inactive Profile
		<input type="radio" name="status" value="Deleted" <?=$varStatus=="Deleted" ? "checked" : "";?>> View Deleted Profile
	</td>
	</tr>
	<tr><td height="15" colspan="2"></td></tr>

	<?php if ($_POST["frmViewProfileSubmit"]=="yes" && $varNumOfRecords==0) { ?>
	<tr><td align="center" class="errortxt">No Records found</td></tr><tr><td height="10" ></td></tr>
	<?php }//if ?>
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><b>MatriID / Email / BM-MatriId </b>&nbsp;<input type=text name="textboxvalue" value="<?=$varTextValue;?>" size="35" class="inputtext">&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
	<td class="smalltxt" style="padding-left:15px;">
		<input type="radio" name="primary" value="MatriId" checked<?=$varPrimary=="MatriId" ? "checked" : "";?>> MatriId
	    <input type="radio" name="primary" value="Email" <?=$varPrimary=="Email" ? "checked" : "";?>> Email
		<input type="radio" name="primary" value="BM-MatriId" <?=$varPrimary=="BM-MatriId" ? "checked" : "";?>> BM-Matrimony Id
		<!-- <input type="radio" name="primary" value="Phone" <?=$varPrimary=="Phone" ? "checked" : "";?>> Phone -->
	</td>
	</tr>
	<tr>
		<td align="center"><input type="button" value="Search" class="button" onClick="return funViewProfileId();"></td>
	</tr>
	<tr><td height="20"></td></tr>
</form>	
</table>
<br clear="all"><br>
<?php if ($sessUserType == '2') {?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="545">	
<form name="frmViewMatriIdProfile" method="post" action="index.php?act=view-matriid-byphone">
<input type="hidden" name="frmViewMatrimonySubmit" value="yes">
<input type="hidden" name="MatriId" value="">
	<tr><td height="20"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><b>Mobile No / Phone No </b>&nbsp;<input type=text name="mobilephoneno" value="<?=$varMobilePhoneNo;?>" size="35" class="inputtext">
		&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td class="smalltxt" style="padding-left:15px;"><input type="checkbox" name="verified" class="inputtext" value="verified" checked> Verified &nbsp;&nbsp;<input type="checkbox" name="nonverified" class="inputtext" value="nonverified"> Non Verified</td>
	</tr>
	<tr>
		<td align="center"><input type="submit" value="Search MatriId" class="button" onClick="return funViewMatrimonyId();"></td>
	</tr>
	<tr>
		<td height="5px">&nbsp;</td>
	</tr>
</form>
</table>
<br clear="all"><br>
<?php }?>

<?php if ($varNumOfRecords > 0) { 
	if($varStatus=='Active' || $varStatus=='Inactive') {
	if($varPrimary =='MatriId') {
		echo '<script>location.href="'.$confValues['SERVERURL'].'/admin/index.php?act=view-profile1&actstatus='.$varActStatus.'&matrimonyId='.$varTextValue.'";</script>';

	} else if($varPrimary =='BM-MatriId'){
		$varSelectProfile = mysql_fetch_assoc($varProfileRes);
		$varMatriId = $varSelectProfile['MatriId'];
		echo '<script>location.href="'.$confValues['SERVERURL'].'/admin/index.php?act=view-profile1&actstatus='.$varActStatus.'&matrimonyId='.$varMatriId.'";</script>';
	
	}else { ?>
	<table border="0" class="formborderclr"  cellpadding="0" cellspacing="1" align="left" width="545">
	<?php if($varStatus=='Active'){ ?>
	<tr>
		<td align="center" class="bigtxt">List of Active Profile </td>
	</tr>
	<?php }else if($varStatus=='Inactive'){?>
	<tr>
		<td align="center" class="bigtxt">List of InActive Profile</td>
	</tr>
	<?php }?>
	<tr>
		<td valign="top" width="545" bgcolor="#FFFFFF">
			<table border="0" cellpadding="0" cellspacing="0" align="center" width="85%" class="formborder">
			<tr height="25" class="adminformheader">
				<td class="mailerEditTop" width="25%">MatriId</td>
				<td class="mailerEditTop" width="25%">Profile Type</td>
				<td class="mailerEditTop" width="25%">Date Created</td>
			</tr>
			<?php
			 while($varSelectEmailProfile = mysql_fetch_assoc($varProfileRes)) {
			 
			 $varMatriId			= $varSelectEmailProfile["MatriId"];
			 $varMatriIdPrefix		= substr($varMatriId,0,3);
			 $arrMatriIdPreReverse	= array_flip($arrMatriIdPre);
			 $varCommunityId		= $arrMatriIdPreReverse[$varMatriIdPrefix];
			 $varProfileType		= $varSelectEmailProfile["Paid_Status"];
			 $varCreatedDate		= getDateMonthYear('d-M-Y',$varSelectEmailProfile["Date_Created"]);
			?>
			<tr>
				<td class="smalltxt" style="padding-left:10px"><a href="#" onClick="javascript:window.open('<?=$confValues['SERVERURL']?>/admin/index.php?act=view-profile1&actstatus=<?=$varActStatus?>&matrimonyId=<?=$varMatriId?>&communityid=<?=$varCommunityId?>');"><?=$varMatriId?></a></td>
				<td class="smalltxt" style="padding-left:30px"><?=$varProfileType==1 ? "Paid" : "Free"; ?></td>
				<td class="smalltxt" style="padding-left:15px"><?=$varCreatedDate ? $varCreatedDate : "-";?></td>
			</tr>
			<tr><td height="7"></td></tr>
			<?}//if?>
			</table>
		</td>
	</tr>
</table>
<br clear="all"><br>
<?php }
	}//if 
	 else if ($varStatus=='Deleted') {
		if($varPrimary =='MatriId') {
		echo '<script>location.href="'.$confValues['SERVERURL'].'/admin/index.php?act=deleted-profile&primary=matriid&username='.$varTextValue.'";</script>';

	}if($varPrimary =='Email') {
		if($varNumOfRecords==1){
		$varSelectProfile = mysql_fetch_assoc($varProfileRes);
		$varMatriId = $varSelectProfile['MatriId'];
		echo '<script>location.href="'.$confValues['SERVERURL'].'/admin/index.php?act=deleted-profile&primary=matriid&username='.$varMatriId.'";</script>';
		}else{?>
	<table border="0" class="formborderclr"  cellpadding="0" cellspacing="1" align="left" width="545">	
	<tr>
		<td align="center" class="mediumhdtxt"><b>List of Deleted Profile</b></td>
	</tr>
	
	<tr>
		<td valign="top" width="545" bgcolor="#FFFFFF">
			<table border="0" cellpadding="0" cellspacing="0" align="center" width="85%" class="formborder">
			<tr height="25" class="adminformheader">
				<td class="mailerEditTop" width="25%">MatriId</td>
				<td class="mailerEditTop" width="25%">Profile Type</td>
				<td class="mailerEditTop" width="25%">Date Created</td>
			</tr>
			<?php
			 while($varSelectEmailProfile = mysql_fetch_assoc($varProfileRes)) {
			 
			 $varMatriId			= $varSelectEmailProfile["MatriId"];
			 $varMatriIdPrefix		= substr($varMatriId,0,3);
			 $arrMatriIdPreReverse	= array_flip($arrMatriIdPre);
			 $varCommunityId		= $arrMatriIdPreReverse[$varMatriIdPrefix];
			 $varProfileType		= $varSelectEmailProfile["Paid_Status"];
			 $varCreatedDate		= getDateMonthYear('d-M-Y',$varSelectEmailProfile["Date_Created"]);
			?>
			<tr>
				<td class="smalltxt" style="padding-left:10px"><a href="#" onClick="javascript:window.open('<?=$confValues['SERVERURL']?>/admin/index.php?act=deleted-profile&primary=matriid&username=<?=$varMatriId?>');"><?=$varMatriId?></a></td>
				<td class="smalltxt" style="padding-left:30px"><?=$varProfileType==1 ? "Paid" : "Free"; ?></td>
				<td class="smalltxt" style="padding-left:15px"><?=$varCreatedDate ? $varCreatedDate : "-";?></td>
			</tr>
			<tr><td height="7"></td></tr>
			<?}//if?>
			</table>
		</td>
	</tr>
</table>
<br clear="all"><br>
<?php }

	}
	}	
	
}?>		

<script language="javascript">
function funViewProfileId() {
	var frmName = document.frmViewEmailProfile;
	if (frmName.textboxvalue.value=="" ) {
		alert("Please enter  E-Mail / BM-MatriId");
		frmName.textboxvalue.focus();
		return false;
	}
	frmName.frmViewProfileSubmit.value='yes';
	frmName.submit();
	return true;
}//funViewProfileId

function funViewMatrimonyId() {
	var frmName = document.frmViewMatriIdProfile;
	if (frmName.mobilephoneno.value=="" ) {
		alert("Please enter  Mobile no");
		frmName.mobilephoneno.focus();
		return false;
	}
	if (frmName.verified.checked == false && frmName.nonverified.checked == false )
	{
		alert ('You didn\'t choose any of the checkboxes!');
		return false;
		}
		else
		{
		return true;
		}
	
}
</script>

