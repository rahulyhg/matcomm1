<?php
#=============================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 2008-09-28
# End Date		: 2008-09-28
# Project		: CommunityMatrimony
# Module		: Successstory - Story Gallery
#=============================================================================================================
//FILE INCLUDES

include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsRegister.php');
include_once($varRootBasePath.'/conf/domainlist.cil14');

//OBJECT DECLARTION
$objMaster	= new DB;
$objSlave	= new clsRegister;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

if($_POST[successStorySubmit] == "Submit")
{
	//print_r($_REQUEST);
	$varCurrentDate				= date('Y-m-d H:i:s');
	$varUsername				= $_REQUEST['suplogin'];
	$varPassword				= md5($_REQUEST['suppswd']);

	$argCondition				= "WHERE User_Name=".$objSlave->doEscapeString($varUsername,$objSlave)."and Password = ".$objSlave->doEscapeString($varPassword,$objSlave);
	//$usernameCheckQuery			= " select User_Name,Password from ".$varTable['ADMINLOGININFO']." $argCondition";
	$varCheckUserName			= $objSlave->numOfRecords($varTable['ADMINLOGININFO'],'User_Name',$argCondition);

	if($varCheckUserName >= 1)
	{
		//print_r($_REQUEST);
		$argFields 				= array('Last_Login');
		$argFieldsValues		= array("'".$varCurrentDate."'");
		$argCondition			= "User_Name=".$objMaster->doEscapeString($varUsername,$objMaster);
		$varUpdateId			= $objMaster->update($varTable['ADMINLOGININFO'],$argFields,$argFieldsValues,$argCondition);
		$totrec = $_REQUEST['totrec'];
		for($i=0;$i<$totrec;$i++)
		{
			$action = "action$i";
			$success = "successid$i";
			$martiId = "martiId$i";
			echo "<br>".$_REQUEST[$action];
			if($_REQUEST[$action] == "Ignore")
			{
				$delArgCondition = "Success_Id=".$_REQUEST[$success];
				echo "Del num rows - ".$numDelRows = $objMaster -> delete($varTable['SUCCESSSTORYINFO'],$delArgCondition);
			}
			if($_REQUEST[$action] == "Add")
			{
				$argFields 				= array('Publish','Date_Updated');
				$argFieldsValues		= array(1,"'".$varCurrentDate."'");
				$argCondition			= "Success_Id=".$_REQUEST[$success]."";
				//$varUpdateId			= $objMaster->update($varTable['SUCCESSSTORYINFO'],$argFields,$argFieldsValues,$argCondition);
			}
		}
	}
	else
	{
		echo "<div class='errorMsg' width='500' align='center'>Invalid UserName or Password ,Enter valid UserName and Password</div>";
	}
	
}

$NumberStories = $_REQUEST['NumberStories'];
$startFrom = $_REQUEST['startFrom'];

$domainName = str_replace("www.","",$_SERVER[SERVER_NAME]);
$arrPrefixDomainList1 = array_flip($arrPrefixDomainList);
$domainPrefix = $arrPrefixDomainList1[$domainName];
$arrMatriIdPre1 = array_flip($arrMatriIdPre);
$domainId = $arrMatriIdPre1[$domainPrefix];
$folderName = $arrFolderNames[$domainPrefix];

if($NumberStories == "")
	$NumberStories = 10;
if($startFrom == "")
	$startFrom = 1;
$argFields = array('Success_Id','MatriId','CommunityId','Email','Bride_Name','Groom_Name','Marriage_Date','Success_Message','Telephone','Contact_Address','Publish','Date_Updated');
$argCondition = " WHERE Publish=0 and CommunityId = ".$domainId." LIMIT ".$startFrom.",".$NumberStories;

$totalNumRec = $objSlave -> numOfRecords($varTable['SUCCESSSTORYINFO'],'MatriId',' WHERE Publish=0 and CommunityId='.$domainId);

$varTotalTable .= '<form method="post" name="frmValidSuccessStory" onSubmit="return story_valid();">';
$varTotalTable .= '<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545">
	<tr><td height="10"></td></tr>
	<tr>
		<td class="heading" style="padding-left:10px;">New Profiles </td>
	</tr>
	<tr><td width="50%" class="smalltxt" align="right"><font color="red"><b>New Profiles Pending Count - '.$totalNumRec.'</b></font></td></tr>
	</table>';

if($varSelectSuccessInfoRes	= $objSlave -> select($varTable['SUCCESSSTORYINFO'],$argFields,$argCondition))
{
	$varTotalNumRec = mysql_num_rows($varSelectSuccessInfoRes);
	$varTotalTable .= '<input type="hidden" name="totrec" value="'.$varTotalNumRec.'">';
	$count = 0;
	while($varSelectSuccessInfo = mysql_fetch_array($varSelectSuccessInfoRes))
	{
		$varTotalTable .= '<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="545" align="center">';
		$varTotalTable .= '<tr><td>&nbsp;<input type="hidden" name="successid'.$count.'" value="'.$varSelectSuccessInfo['Success_Id'].'"></td></tr>';
		$varTotalTable .= '<tr><td valign="top" class="smalltxt boldtxt" colspan="4" style="padding-left:10px;">MatriId : '.$varSelectSuccessInfo['MatriId'].'<input type="hidden" name="martiId'.$count.'" value="'.$varSelectSuccessInfo['MatriId'].'"></td></tr>';
		$varTotalTable .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Bride Name :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">'.$varSelectSuccessInfo['Bride_Name'].'</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Groom Name :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">'.$varSelectSuccessInfo['Groom_Name'].'</td></tr>';
		$varSelectSuccessInfo['Marriage_Date'] = explode(" ",$varSelectSuccessInfo['Marriage_Date']);

		$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Telephone :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">'.$varSelectSuccessInfo['Telephone'];
		$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%" rowspan="2">Contact Address :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
		$varTotalTable .= $varSelectSuccessInfo['Contact_Address'];
		$varTotalTable .= '</td></tr>';

		$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Marriage Date :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
		$varTotalTable .= $varSelectSuccessInfo['Marriage_Date'][0];
		$varTotalTable .= '</td></tr>';


		$varTotalTable .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Success Message </td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%" colspan="3">'.$varSelectSuccessInfo['Success_Message'].'</td></tr>';
		$varTotalTable .= '<tr><td class="smalltxt"><input type="radio" name="action'.$count.'" value="Add"> Add &nbsp; <input type="radio" name="action'.$count.'" value="Ignore"> Ignore</td><td colspan="3" align="right" class="formlink1"><a href="" class="smalltxt boldtxt">Modify Story</a></td></tr>';
		$varTotalTable .= '<tr><td height="10" width="100%"  class="vdotline1" colspan="4"><HR></td></tr>';
		$varTotalTable .= '</table>';
		$count++;
	}
}
$varTotalTable .= '<table border="0" cellpadding="3" cellspacing="0" width="530" class="formborder">
	<tr><td class="adminformheader">Please enter your login details :</td></tr><tr><td>
<table border="0" cellpadding="3" cellspacing="3" width="230"><tbody><tr><td><font class="smalltxt boldtxt"><b>Username : </b></font></td><td><input name="suplogin" class="inputtxt" size="15" type="text" value=""></td></tr><tr><td><font class="smalltxt boldtxt"><b>Password : </b></font></td><td><input name="suppswd" size="15" type="password" value=""></td></tr></tbody></table></td></tr></table><br><br></td></tr><tr><td><center><input type="submit" name="successStorySubmit" class="button" value="Submit"><input type="hidden" name="spage" class="smalltxt" value="'.$varSepartePage.'"></center></td></tr></form>';
$objSlave->dbClose();
echo $varTotalTable;
?>
<script language="javascript" type="text/javascript">
function story_valid()
{
	var totrec = document.frmValidSuccessStory.totrec.value;
	var trc = totrec;
	var frmDetails = document.frmValidSuccessStory;
	var j;
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
	for(i=0;i<trc;i++)
	{
		j = i+1; 
		var matriid = "document.frmValidSuccessStory.martiId"+i+"";
		var addaction = "document.frmValidSuccessStory.action"+i+"[0]";
		var rejectaction = "document.frmValidSuccessStory.action"+i+"[1]";
		//alert(eval(matriid).value);
		//alert(addaction + ":" +eval(addaction).checked);
		//alert(rejectaction + ":" +eval(rejectaction).checked);
		if(!(eval(addaction).checked) && !(eval(rejectaction).checked))
		{
			alert("Please select Add or Ignore of story "+j+" of "+eval(matriid).value);
			eval(addaction).focus();
			return false;
		}
	}
	return true;
}
</script>