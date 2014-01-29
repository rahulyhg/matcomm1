<?php
#=============================================================================================================
# Author 		: Senthilnathan
# Start Date	: 2009-01-22
# End Date		: 2009-01-22
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================
//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objDB		= new DB();

//DB CONNECTION
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIALBE DECLERATION
$varSubmit	= $_POST['frmPhoneCntSubmit'];
$varSubmit1	= $_POST['frmUpdatePhoneSubmit'];
$varResult	= '';

if($varSubmit == 'yes'){
	//VARIABLE DECLARATION
	$varMatriId	 = '';
	$varUserName = '';
	if($_POST['primary'] == 'MatriId'){
		$varMatriId		= $_POST['username'];
		$varFields 		= array('User_Name');
		$varCondition	= "WHERE MatriId='".$varMatriId."'";	
	}else if($_POST['primary'] == 'User_Name'){
		$varUserName	= $_POST['username'];
		$varFields 		= array('MatriId');
		$varCondition	= "WHERE User_Name='".$varUserName."'";
	}

	//GET MatriId or Username
	$varErrorMessage		= '';
	$varUserDoesnotExists	= 1;
	$varSelectUserRes		= $objDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition, 0);
	if(mysql_num_rows($varSelectUserRes)>0)
		$varSelectUserInfo	= mysql_fetch_assoc($varSelectUserRes);
	else{
		$varSelectUserRes	= $objDB->select($varTable['MEMBERDELETEDINFO'], $varFields, $varCondition, 0);
		if(mysql_num_rows($varSelectUserRes)>0){
			$varErrorMessage	  = '<font class="errortxt">This member is deleted.</font>';
			$varUserDoesnotExists = 3;
			$varSelectUserInfo= mysql_fetch_assoc($varSelectUserRes);
		}else{
			$varUserDoesnotExists = 0;
			$varErrorMessage	  = '<font class="errortxt">Given MatriId/Username does not exists.</font>';
		}
	}
	

	//SELECT Phont count details
	if($varUserDoesnotExists != 0){
		if($varFields[0]=='MatriId'){
			$varCondition	= "WHERE MatriId='".$varSelectUserInfo['MatriId']."'";
			$varMatriId		= $varSelectUserInfo['MatriId'];
		}else if($varFields[0]=='User_Name'){
			$varUserName = $varSelectUserInfo['User_Name'];
		}

		$varFields1		= array('TotalPhoneNos', 'NumbersLeft');
		$varPhoneCntRes	= $objDB->select($varTable['PHONEPACKAGEDET'], $varFields1, $varCondition, 0);

		if($varUserDoesnotExists != 3 && $sessUserType ==1){
			$varTitle			= (mysql_num_rows($varPhoneCntRes)>0) ? 'Edit' : 'Add';
			$varPhoneCntInfo	= (mysql_num_rows($varPhoneCntRes)>0) ? mysql_fetch_assoc($varPhoneCntRes) : array();
			$varLink			= '';
			if($varPhoneCntInfo['NumbersLeft']<$varPhoneCntInfo['TotalPhoneNos'] && $varTitle=='Edit'){
				$varLink		= '&nbsp;&nbsp;<a class="smalltxt clr1" href="javascript:;" onclick="window.open(\''.$confValues['SERVERURL'].'/admin/viewdphones.php?id='.$varMatriId.'\', \'mywindow\', \'height=600,width=400,scrollbars=1\')">Viewed Phones List</a>';
			}
			$varResult          = '<tr><td height="20"><form name="frmUpdatePhone" method="POST" onSubmit="return validate2();"><input type="hidden" name="frmUpdatePhoneSubmit" value="yes"><input type="hidden" name="InsertType" value="'.$varTitle.'"><input type="hidden" name="MatriId" value="'.$varMatriId.'">
			<table border="0" cellpadding="2" cellspacing="0" width="250" align="left"><tr><td colspan="2"><font class="heading">'.$varTitle.' phone count</font>'.$varLink.'</td></tr><tr><td class="smalltxt boldtxt" align="right">MatriId:</td><td class="mediumtxt">'.$varMatriId.'</td></tr><tr><td class="smalltxt boldtxt" align="right">Total Count :</td><td><input type="text" name="TotalCnt" class="inputtext" value="'.$varPhoneCntInfo['TotalPhoneNos'].'"></td></tr><tr><td class="smalltxt boldtxt" align="right">Numbers Left:</td><td><input type="text" name="LeftCnt" class="inputtext" value="'.$varPhoneCntInfo['NumbersLeft'].'"></td></tr>
			<tr><td colspan="2" align="right"><input type="submit" value="Submit" class="button"></td></tr></table></form></td></tr>';
		}else if(mysql_num_rows($varPhoneCntRes) > 0 && ($varUserDoesnotExists == 3 || $sessUserType != 1)){
			$varPhoneCntInfo	= mysql_fetch_assoc($varPhoneCntRes);
			$varLink			= '';
			if($varPhoneCntInfo['NumbersLeft']<$varPhoneCntInfo['TotalPhoneNos']){
				$varLink		= '&nbsp;&nbsp;<a class="smalltxt clr1" href="javascript:;" onclick="window.open(\''.$confValues['SERVERURL'].'/admin/viewdphones.php?id='.$varMatriId.'\', \'mywindow\', \'height=600,width=400,scrollbars=1\')">Viewed Phones List</a>';
			}
			$varResult          = '<tr><td height="20"><table border="0" cellpadding="2" cellspacing="0" width="250" align="left"><tr><td colspan="2"><font class="heading">View phone count</font>'.$varLink.'</td></tr><tr><td class="smalltxt boldtxt" align="right">MatriId :</td><td class="mediumtxt">'.$varMatriId.'</td></tr><tr><td class="smalltxt boldtxt" align="right">Total Count :</td><td class="mediumtxt">'.$varPhoneCntInfo['TotalPhoneNos'].'</td></tr><tr><td class="smalltxt boldtxt" align="right">Numbers Left:</td><td class="mediumtxt">'.$varPhoneCntInfo['NumbersLeft'].'</td></tr></table></form></td></tr>';
		}else if($varUserDoesnotExists == 3 || mysql_num_rows($varPhoneCntRes)==0){
			$varErrorMessage	.= '<BR><font class="errortxt">Phone count not available for this Username ('.$varUserName.').<font>';
		}
	}
}else if($varSubmit1 == 'yes'){
	
	$varMatriId		= $_POST['MatriId'];
	if($_POST['InsertType'] == 'Edit'){
		$varCondition	= "MatriId='".$varMatriId."'";
		$varFields		= array('TotalPhoneNos', 'NumbersLeft');
		$varFieldsVal	= array($_POST['TotalCnt'], $_POST['LeftCnt']);
		$objDB->update($varTable['PHONEPACKAGEDET'], $varFields, $varFieldsVal, $varCondition);
		$varErrorMessage = '<font class="smalltxt boldtxt">Successfully Updated.<font>';
	}else if($_POST['InsertType'] == 'Add'){
		$varFields		= array('MatriId', 'TotalPhoneNos', 'NumbersLeft');
		$varFieldsVal	= array("'".$varMatriId."'", $_POST['TotalCnt'], $_POST['LeftCnt']);
		$objDB->insert($varTable['PHONEPACKAGEDET'], $varFields, $varFieldsVal);
		$varErrorMessage = '<font class="smalltxt boldtxt">Successfully Inserted.<font>';
	}
}

//Unset Object
$objDB->dbClose();
unset($objDB);
?>
<script language='javascript'>
function validate2()
{
	var frmName = document.frmUpdatePhone;
	if (IsEmpty(frmName.TotalCnt,'text')){
		alert("Please Enter the total phone count");
		frmName.TotalCnt.focus();
		return false;
	}
	if (IsEmpty(frmName.LeftCnt,'text')){
		alert("Please Enter the number of phone counts left");
		frmName.LeftCnt.focus();
		return false;
	}
	return true;
}

function validate()
{
	var frmName = document.frmPhoneCnt;
	if (IsEmpty(frmName.username,'text')){
		alert("Please Enter Username / MatriID");
		frmName.username.focus();
		return false;
	}
	if ( !(frmName.primary[0].checked== true || frmName.primary[1].checked== true)){
		alert("Please select Gender OR Username / MatrimonyID");
		frmName.primary[0].focus();
		return false;
	}
	return true;
}

function IsEmpty(obj, obj_type)
{
	if (obj_type == "text" ||  obj_type == "textarea" ){
		var objValue;
		objValue = obj.value.replace(/\s+$/,"");
		if (objValue.length == 0){ return true; }else {return false; }
	}
}
</script>
<table border='0' cellpadding='0' cellspacing='0' align="left" width="542">
	<tr>
		<td style="padding-left:15px;padding-top:15px;">
			<table border='0' cellpadding='0' cellspacing='0' align="left" width="527">
				<tr><td colspan='4' class="heading"> Phone Count Info</td></tr>
				<tr><td colspan='4' height='10'></td></tr>
			<?php if ($varErrorMessage != '' && ($varSubmit =='yes' || $varSubmit1 =='yes')) { ?>
				<tr><td colspan='4' height='10' class= 'errorMsg' align='center'><?=$varErrorMessage;?></td></tr>
			<?php }?>
				<tr>
					<td align='left' valign='top'> 
						<form name='frmPhoneCnt' method='post'  onSubmit="return validate();">
						<input type='hidden' name='frmPhoneCntSubmit' value='yes' >
							<table border='0' cellpadding='2' cellspacing='0' width="515" align="left">
								<tr>	
									<td class="smalltxt boldtxt" align='right'>Username / MatriID :</td>
									<td> <input type='text'  name='username' class='inputtext'></td>
									<td class="smalltxt"> <input type='radio' name='primary' value='User_Name'> Username &nbsp;<input type='radio' name='primary' value='MatriId'> MatriID&nbsp;&nbsp;&nbsp;<input type='submit' value="Submit" class="button"></td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
				<tr><td height='20'></td></tr>
				<?=$varResult?>
			</table>
		</td>
	</tr>
</table>