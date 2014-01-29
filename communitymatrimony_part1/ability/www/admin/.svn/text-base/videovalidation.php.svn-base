<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		:
#================================================================================================================
   # Description	: 
#================================================================================================================
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath."/lib/clsMailManager.php");

$objSlaveDB			  = new DB;
$objMasterDB		  = new DB;
$objMailManager		  = new MailManager;
//CONNECTION DECLARATION
$varSlaveConn			= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$varMasterConn			= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);
if ($_POST['frmVideoProfileSubmit'] != 'yes' &&  $_POST['frmVideoProcessSubmit'] != 'yes'){
?>
<form METHOD=POST ACTION="" NAME="frmVideoProfile">
<input TYPE="hidden" NAME="frmVideoProfileSubmit" value="yes">
<table border="0" cellpadding="0" cellspacing="0" align="left" width="542">
	<tr>
		<td align="left" style="padding-left:15px;">
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="415">
			<tr><td colspan="3" height="15"></td></tr>
			<tr><td colspan="3" class="mediumtxt boldtxt clr3">Video Validation</td></tr>
			<tr><td colspan="3" height="20"></td></tr>
			<tr><td class="smalltxt boldtxt"><b>Username :</b><td align="left"><input type ="text" name="USERNAME" value=""></td><td align="left"><input type="submit" value="submit" class="button" >&nbsp;&nbsp;&nbsp;<input TYPE="reset" NAME="reset" class="button"></td></tr>
			<tr><td colspan="3" height="20"></td></tr>
		</table>
		</td>
	</tr>
</table>

</form>
<?
} else if ($_POST['frmVideoProfileSubmit'] == 'yes' &&  $_POST['frmVideoProcessSubmit'] != 'yes' ){
	$varError			= '';
	$varMatriId			= trim($_POST["USERNAME"]);
	$varFields			= array('User_Name','MatriId');
	$varCondition		= " WHERE  MatriId  ='".$varMatriId."'";
	$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], $argPrimary='MatriId', $varCondition);
	if ($varTotRecords == 1) {
		$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
		$varSelectLoginInfo	= mysql_fetch_assoc($varResult);
	} else {
		$varCondition		= " WHERE  User_Name  ='".$varMatriId."'";
		$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], $argPrimary='MatriId', $varCondition);
		if ($varTotRecords == 1) {
			$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
			$varSelectLoginInfo	= mysql_fetch_assoc($varResult);
		}
	}
	if ($varTotRecords == 0 ) {
		echo '<table width="542" border="0"><tr><td class="mediumtxt boldtxt clr3" align="center" >Video Profile</td></tr><tr><td align="center" height="50">&nbsp;&nbsp;</td><tr><td align="center"><font class="smalltxt boldtxt errortxt"> Profile not found </font></td></tr></table>';
	} else {
		$varFields			= array('Video_Set_Status');
		$varCondition		= " WHERE  MatriId  ='".$varSelectLoginInfo['MatriId']."'";
		$varResult			= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
		$row				= mysql_fetch_assoc($varResult);
		$varMessage			=   'Dear Member '.$varSelectLoginInfo['User_Name'].',<br>Thanks for using the \'Add Video\' feature and uploading your video clipping to your profile.<br>Unfortunately there is an error and the file does not play. Kindly check the file again and re-upload the video clipping, by logging in with your User Id and password.<br>Should you have further queries, please contact '.$confValues['VIDEOMAIL'].'<br>Thank you, <br><b>Team '.$confValues['PRODUCTNAME'].'</b>.';
		echo '<body onload="clearRadio();">';
		$varContent		.= '<form name="frmVideoProcess" method="post"><input TYPE="hidden" NAME="frmVideoProcessSubmit" value="yes"><input TYPE="hidden" NAME="id" value="'.$varSelectLoginInfo['MatriId'].'"><input TYPE="hidden" NAME="username" value="'.$varSelectLoginInfo['User_Name'].'"><table  border="0" width="543" align="left"><tr class="mediumtxt boldtxt clr3"><td colspan="5" align="left" style="padding-left:10px;padding-top:10px;">Video Validation</td></tr><tr><td height="5"></td></tr>
		<tr class="smalltxt boldtxt"><td width="10%" style="padding-left:10px;">S.No</td><td width="20%">Username</td><td width="10%" >Add</td><td width="10%" >Delete</td><td>Delete Reason</td></tr>
		<tr class="smalltxt" valign="top" ><td style="padding-left:17px;">1</td><td>'.ucfirst($varSelectLoginInfo['User_Name']).'</td><td><input type="radio" name="videoadddelete" value="add" onclick=javascript:document.getElementById("deletemsg").style.visibility="hidden"; >Add </td><td><input type="radio" name="videoadddelete" value="delete" onclick=javascript:document.getElementById("deletemsg").style.visibility="visible"; >Delete </td><td align="left"><TEXTAREA   name="deletemsg" id="deletemsg" cols="40" rows="5" style="visibility:hidden"/>'.$varMessage.'</textarea></td></tr>';
		$varContent		.= '<tr><td  align="center" style="padding-right:10px" colspan="5"><input type="submit" class="button" value="Submit" name="submit" onClick="return validate();" >&nbsp&nbsp<input type="button" onclick = clearRadio(); value="Clear" name="clear" class="button"></td></tr><tr><td height="10"></td></tr></table></form>';
		echo $varContent;
	}
} else if ($_POST['frmVideoProcessSubmit'] == 'yes' &&  $_POST['frmVideoProfileSubmit'] != 'yes' ){
	$varMatriId			= $_POST['id'];
	$varToEmail		= $objMailManager->getEmail($arrPhotoDetail[0]);
	if ($_POST['videoadddelete'] == 'add') {
		$varCondition		= " WHERE  MatriId  ='".$varMatriId."'";
		$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], $argPrimary='MatriId', $varCondition);
		$varVideoURl		= $confValues['VIDEOURL'].$varMatriId."/";
		if ($varTotRecords == 1) {
			$varFields			= array('Video_URL','Video_Date_Updated');
			$varFieldValues		= array("'".$varVideoURl."'", "'".date('Y-m-d h:i:s')."'");
			$varCondition		= " MatriId = '".$varMatriId."'";
			$varUpdate			= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues, $varCondition);
		} else if ($varTotRecords == 0) {
			$varFields			= array('MatriId','Video_URL','Video_Date_Updated');
			$varFieldValues		= array("'".$varMatriId."'","'".$varVideoURl."'", "'".date('Y-m-d h:i:s')."'");
			$varFormResult	= $objMasterDB->insert($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues);
		}
		$varFields			= array('Video_Set_Status');
		$varFieldValues		= array(1);
		$varCondition		= " MatriId = '".$varMatriId."'";
		$varUpdate			= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFieldValues, $varCondition);
		$varToEmail			= $objMailManager->getEmail($arrPhotoDetail[0]);
		$varMessage			= 'Dear Member '.ucfirst($_POST['username']).' ,<br>Thank You! Your request to upload your video clipping, has been accepted.<br>Login with your Matrimony id and use the View Profile option to view your profile along with your video clipping.<br>For further queries please email us at '.$confValues['VIDEOMAIL'].'.<br>Thank you, <br><b>Team '.$confValues['PRODUCTNAME'].'</b>';
		$argSubject		= " Video added successfully";
		$varMailValue	=	$objMailManager->sendNotifyEmail($varToEmail,$varMessage,$argSubject);
		echo '<table align="left" width="542"><tr><td style="padding-left:10px;padding-top:10px;"> <font  class="smalltxt">Video added successfully to '.$_POST['username'].'\'s  profile. </font></td></tr><tr><td height="10"></td></tr></table>';
	} elseif ($_POST['videoadddelete'] == 'delete')  {
		$argSubject		=   'Error in your video clipping';
		$varMailValue	=	$objMailManager->sendNotifyEmail($varToEmail,$_POST['deletemsg'],$argSubject);
		echo '<table align="center" width="542"><tr><td style="padding-left:10px;padding-top:10px;"> <font  class="smalltxt" >Video deleted successfully to '.$_POST['username'].'\'s  profile. </font></td></tr><tr><td height="10"></td></tr></table>';
	}
}
?>
<script>
function validate(){
	var select = 0;
	var chk = 0;
	var r = document.getElementsByTagName('input');   
        for (var i = 0, n; n = r[i]; i++) {   
            if (n.type == 'radio' && n.checked == true)  {   
                select = 1;
				break;
            }  
       }  
	   if(select == 0){
		alert("Please select the video that you wish to Add / Delete.");
		return false;
	   }
	   for (var i = 0, n; n = r[i]; i++) {   
            if (n.type == 'radio' && n.checked == true && (n.value.search(/del/) > 1))  { 
				var splitval = n.name.split("_");
				txtname = splitval[2];	
				if((document.getElementById(txtname).value) == ""){
					chk = 1;
					alert("Please enter the reason for delete");
					document.getElementById(txtname).focus();					
					return false;
					break;
				}			
            }  
       }  
	   if(chk == 0 ){
		   return true;
	   } else {
			return false;
	   }
 }
 function clearRadio() {       
        var r = document.getElementsByTagName('input');   
        for (var i = 0, n; n = r[i]; i++) {   
            if (n.type == 'radio') {   
                n.checked = false;   
            }  
        }   
 }
 function enable_reason(radname){
	//alert(radname);
	//alert("document.getElementById("+radname+").style.visibility");
	document.getElementById(radname).style.visibility='visible';
}
</script>