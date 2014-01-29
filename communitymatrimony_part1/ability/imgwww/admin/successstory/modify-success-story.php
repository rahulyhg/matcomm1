<?php
#=============================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 2008-09-28
# End Date		: 2008-09-28
# Project		: CommunityMatrimony
# Module		: Successstory - Story Gallery
#=============================================================================================================
//FILE INCLUDES
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsRegister.php');
include_once($varRootBasePath.'/conf/domainlist.inc');
include_once($varRootBasePath.'/www/admin/includes/config.php');

//OBJECT DECLARTION
$objMaster	= new DB;
$objSlave	= new clsRegister;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

if($_COOKIE['adminLoginInfo']==''){
	$urllogin = $confValues['ServerURL'];
    header("location:$urllogin/admin/index.php?act=login");
}

if($_POST[Modify] == "Modify")
{
	$varCurrentDate				= date('Y-m-d H:i:s');
	$varUsername				= addslashes(strip_tags(trim($_REQUEST['suplogin'])));
	$varPassword				= md5(addslashes(strip_tags(trim($_REQUEST['suppswd']))));

	$argCondition				= "WHERE User_Name='".$varUsername."' and Password = '".$varPassword."'";
	//$usernameCheckQuery			= " select User_Name,Password from ".$varTable['ADMINLOGININFO']." $argCondition";
	$varCheckUserName			= $objSlave->numOfRecords($varTable['ADMINLOGININFO'],'User_Name',$argCondition);

	if($varCheckUserName >= 1)
	{
		//print_r($_REQUEST);
		$argFields 				= array('Last_Login');
		$argFieldsValues		= array("'".$varCurrentDate."'");
		$argCondition			= "User_Name='".$varUsername."'";
		$varUpdateId			= $objMaster->update($varTable['ADMINLOGININFO'],$argFields,$argFieldsValues,$argCondition);

		$argFields = array('Success_Message');
		$argFieldsValue = array("'".addslashes(strip_tags(trim($_REQUEST['successmessage'])))."'");
		$argCondition = " Success_Id=".addslashes(strip_tags(trim($_REQUEST['successid'])));
		$varUpdateSuccess = $objMaster -> update($varTable['SUCCESSSTORYINFO'], $argFields, $argFieldsValue, $argCondition);
		$message = "<div width='500' align='center' class='alerttxt'>Success Story updated Successfully.</div>";		
	}
	else
	{
		$message = "<div class='errorMsg' width='500' align='center'>Invalid UserName or Password ,Enter valid UserName and Password</div>";
	}
}

$argFields = array('Success_Id','MatriId','CommunityId','Email','Bride_Name','Groom_Name','Marriage_Date','Success_Message','Telephone','Contact_Address','Publish','Date_Updated');

$argCondition = " WHERE Success_Id=".addslashes(strip_tags(trim($_REQUEST[Success_Id])));
if($varSelectSuccessInfoRes	= $objSlave -> select($varTable['SUCCESSSTORYINFO'],$argFields,$argCondition,0))
{
//	$varSelectSuccessInfoNum = mysql_num_rows($varSelectSuccessInfoRes);
	$varSelectSuccessInfo = mysql_fetch_assoc($varSelectSuccessInfoRes);
	
	$varTotalTable .= '<form method="post" name="frmModifySuccess" onSubmit="return modify_valid();">';
	$varTotalTable .= '<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="545" align="center">';
	$varTotalTable .= '<tr><td>&nbsp;<input type="hidden" name="successid'.$count.'" value="'.$varSelectSuccessInfo['Success_Id'].'"></td></tr>';
	$varTotalTable .= '<tr><td valign="top" class="smalltxt boldtxt" colspan="4" style="padding-left:10px;padding-bottom:3px;"><b>MatriId : '.$varSelectSuccessInfo['MatriId'].'<input type="hidden" name="martiId'.$count.'" value="'.$varSelectSuccessInfo['MatriId'].'"></td></tr>';
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Bride Name :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">'.$varSelectSuccessInfo['Bride_Name'].'</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Groom Name :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">'.$varSelectSuccessInfo['Groom_Name'].'</td></tr>';
	$varSelectSuccessInfo['Marriage_Date'] = explode(" ",$varSelectSuccessInfo['Marriage_Date']);

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Telephone :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">'.$varSelectSuccessInfo['Telephone'];
	$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%" rowspan="2">Contact Address :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varSelectSuccessInfo['Contact_Address'];
	$varTotalTable .= '</td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Marriage Date :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varSelectSuccessInfo['Marriage_Date'][0];
	$varTotalTable .= '</td></tr>';


	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Success Message </td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%" colspan="3"><textarea name="successmessage" cols="50" rows="6">'.$varSelectSuccessInfo['Success_Message'].'</textarea></td></tr>';
//	$varTotalTable .= '<tr><td class="smalltxt"><input type="radio" name="action'.$count.'" value="Add"> Add &nbsp; <input type="radio" name="action'.$count.'" value="Ignore"> Ignore</td><td colspan="3" align="right" class="formlink1"><a href="modify-success-story.php?Success_Id='.$varSelectSuccessInfo['Success_Id'].'" class="smalltxt boldtxt" target="_blank">Modify Story</a></td></tr>';
	$varTotalTable .= '<tr><td height="10" width="100%"  class="vdotline1" colspan="4" align="right">&nbsp;</td></tr>';
	$varTotalTable .= '</table>';
	$varTotalTable .= '<table border="0" cellpadding="3" cellspacing="0" width="530" class="formborder" align="center">
	<tr><td class="adminformheader">Please enter your login details :</td></tr><tr><td>
<table border="0" cellpadding="3" cellspacing="3" width="230"><tbody><tr><td><font class="smalltxt boldtxt"><b>Username : </b></font></td><td><input name="suplogin" class="inputtxt" size="15" type="text" value=""></td></tr><tr><td><font class="smalltxt boldtxt"><b>Password : </b></font></td><td><input name="suppswd" size="15" type="password" value=""></td></tr></tbody></table></td></tr></table><br><br></td></tr><tr><td><center><input type="submit" name="Modify" value="Modify" class="button"><input type="hidden" name="spage" class="smalltxt" value="'.$varSepartePage.'"></center></td></tr>';
	$varTotalTable .= '</form>';

}
?>
<table width="88%" align="center" border="0"><tr><td>
<img src="<?=$confValues['IMGURL']?>/images/logo/community_logo.gif" alt="Community Matrimony" border="0" />
<tr><td><hr></td></tr><tr><td align="right">
</td></tr>
</td></tr></table>
<?

echo "<br>$message <br>".$varTotalTable;
?>

<style type="text/css"> @import url("<?=$confValues['PHOTOURL'];?>/styles/global-style.css"); </style>
<script language="javascript" type="text/javascript">
function modify_valid()
{
	var frmDetails = document.frmModifySuccess;
	if(frmDetails.suplogin.value == "")
	{
		alert("Please enter Username");
		frmDetails.suplogin.focus();
		return false;
	}
	if(frmDetails.suppswd.value == "")
	{
		alert("Please enter Password");
		frmDetails.suppswd.focus();
		return false;
	}
	return true;
}
</script>