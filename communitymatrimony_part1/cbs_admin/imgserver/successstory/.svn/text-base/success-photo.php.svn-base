<?php
#=============================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 2008-09-28
# End Date		: 2008-09-28
# Project		: CommunityMatrimony
# Module		: Successstory - Story Gallery
#=============================================================================================================


//OBJECT DECLARTION
$objMaster	= new DB;
$objSlave	= new clsRegister;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

$domainName = str_replace("image.","",$_SERVER[SERVER_NAME]);
$arrPrefixDomainList1 = array_flip($arrPrefixDomainList);
$domainPrefix = $arrPrefixDomainList1[$domainName];
$arrMatriIdPre1 = array_flip($arrMatriIdPre);
$domainId = $arrMatriIdPre1[$domainPrefix];

if($_REQUEST['domain'][0]){
	if($_REQUEST['domain'][0] !='All') $domainId = $_REQUEST['domain'][0] ;	else $domainId = '' ;
}else{
    $domainId = $arrMatriIdPre1[$domainPrefix];
}
$folderName = $arrFolderNames[$domainPrefix];

if($_POST[successPhotoSubmit] == "Submit")
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

		$totrec = addslashes(strip_tags(trim($_REQUEST['totrec'])));

		for($i=1;$i<=$totrec;$i++)
		{
			$action = "action$i";
			$matriid = "matriId$i";
			$successid = "successid$i";

			$varAction = addslashes(strip_tags(trim($_REQUEST[$action])));
			$varMatriId = addslashes(strip_tags(trim($_REQUEST[$matriid])));
			$varSuccessid = addslashes(strip_tags(trim($_REQUEST[$successid])));
			
			if($varAction == "Add")
			{
				$argFields 				= array('Photo_Set_Status');
				$argFieldsValues		= array("'1'");
				
				$argCondition			= "Success_Id='".$varSuccessid."'";
				$varUpdateId			= $objMaster->update($varTable['SUCCESSSTORYINFO'],$argFields,$argFieldsValues,$argCondition);
				$errorMessage = "<div class='alerttxt' width='500' align='center'>Photo Validated Successfully.</div>";
			}
			if($varAction == "Ignore")
			{
				$argCondition			= "WHERE Success_Id='".$varSuccessid."'";
				$argFields = array('Photo','CommunityId');
				if($varSelectSuccessForPhoto	= $objSlave -> select($varTable['SUCCESSSTORYINFO'],$argFields,$argCondition,0))
				{
					$varSelectSuccessForPhotoRow = mysql_fetch_assoc($varSelectSuccessForPhoto);
					$CommunityId=$varSelectSuccessForPhotoRow['CommunityId'];
					$folderNameId=$arrMatriIdPre[$CommunityId];
					$folderName=$arrFolderNames[$folderNameId];
					
					if($varSelectSuccessForPhotoRow['Photo'] != "")
					{
						$pendingPhoto = $varRootBasePath."/www/success/$folderName/pendingphotos/".$varSelectSuccessForPhotoRow['Photo'];
						@unlink($pendingPhoto);
					}
					$varUpdateId			= $objMaster->delete($varTable['SUCCESSSTORYINFO'],$argCondition);
					$errorMessage = "<div class='alerttxt' width='500' align='center'>Photo Deleted Successfully.</div>";
				}
			}
		}
	}
	else
	{
		$errorMessage = "<div class='errorMsg' width='500' align='center'>Invalid UserName or Password ,Enter valid UserName and Password</div>";
	}
}

$NumberStories = addslashes(strip_tags(trim($_REQUEST['NumberPhoto'])));
$StartFrom = addslashes(strip_tags(trim($_REQUEST['startFrom'])));

if($NumberStories == "")
	$NumberStories = 10;
if($StartFrom == "")
	$StartFrom = 1;


$argFields = array('Success_Id','MatriId','Bride_Name','Groom_Name','Success_Message','Marriage_Date','Photo_Set_Status');

if($domainId){
	$domainPre=$arrMatriIdPre[$domainId];
	$argCondition = " WHERE Photo_Set_Status=0 and CommunityId = ".$domainId." and substring(MatriId,1,3)='".$domainPre."' and Photo!='' and Photo!='photo/'  LIMIT ".$StartFrom.",".$NumberStories;
}else{
	$argCondition = " WHERE Photo_Set_Status=0 and Photo!='' and Photo!='photo/' LIMIT ".$StartFrom.",".$NumberStories;
}
if($varSelectSuccessForFile	= $objSlave -> select($varTable['SUCCESSSTORYINFO'],$argFields,$argCondition,0))
{
	$numRows = mysql_num_rows($varSelectSuccessForFile);
	$success_photo .= '<form method="post" name="frmSuccessPhoto" onSubmit="return photo_valid();">';
	$success_photo .= '<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="545" align="center">';
	$success_photo .= '<tr>
		<td class="heading" style="padding-left:10px;">Filter By Domains : '.showDomains().'</td>
	</tr>
	<tr>
		<td class="heading" style="padding-left:10px;">&nbsp;</td>
	</tr>';
	$success_photo .= '<tr><td align="right" class="smalltxt">&nbsp;<input type="hidden" name="totrec" value="'.$numRows.'"><font color="red"><b>New Photos Pending Count - '.$numRows.'</b></font></td></tr><tr><td>';
	$count=0;
	while($varSelectSuccessForFileRow = mysql_fetch_assoc($varSelectSuccessForFile))
	{
		$count++;
		$success_photo .= '<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="545" align="center">';
		$success_photo .= '<tr><td>&nbsp;<input type="hidden" name="successid'.$count.'" value="'.$varSelectSuccessForFileRow['Success_Id'].'"></td></tr>';
		$success_photo .= '<tr><td valign="top" class="smalltxt boldtxt" colspan="4" style="padding-left:10px;padding-bottom:3px"><b>MatriId : '.$varSelectSuccessForFileRow['MatriId'].'<input type="hidden" name="matriId'.$count.'" value="'.$varSelectSuccessForFileRow['MatriId'].'"></td></tr>';
		$success_photo .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Bride Name :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">'.$varSelectSuccessForFileRow['Bride_Name'].'</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Groom Name :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">'.$varSelectSuccessForFileRow['Groom_Name'].'</td></tr>';
		$varSelectSuccessForFileRow['Marriage_Date'] = explode(" ",$varSelectSuccessForFileRow['Marriage_Date']);
		$success_photo .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Marriage Date :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">'.$varSelectSuccessForFileRow['Marriage_Date'][0].'</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Contact Adderess :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">'.$varSelectSuccessForFileRow['Contact_Address'].'</td></tr>';

		$success_photo .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Bride Name :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%" colspan="3">'.$varSelectSuccessForFileRow['Success_Message'].'</td></tr>';

		$success_photo .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%"><a href="javascript:viewPhotos('.$varSelectSuccessForFileRow['Success_Id'].');">View Photo</a></td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%" colspan="3"><a href="javascript:cropPhotos('.$varSelectSuccessForFileRow['Success_Id'].');" >Crop Photo</a></td></tr>';

		$success_photo .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%"><input type="radio" name="action'.$count.'" value="Add"> Add</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%" colspan="3"><input type="radio" name="action'.$count.'" value="Ignore"> Ignore</td></tr>';
		$success_photo .= '</table>';
	}
		$success_photo .= '<br><table border="0" cellpadding="3" cellspacing="0" width="530" class="formborder" align="center">
		<tr><td class="adminformheader">Please enter your login details :</td></tr><tr><td>
		<table border="0" cellpadding="3" cellspacing="3" width="230"><tbody><tr><td><font class="smalltxt boldtxt"><b>Username : </b></font></td><td><input name="suplogin" class="inputtxt" size="15" type="text" value=""></td></tr><tr><td><font class="smalltxt boldtxt"><b>Password : </b></font></td><td><input name="suppswd" size="15" type="password" value=""></td></tr></tbody></table></td></tr></table><br><br></td></tr><tr><td><center><input type="submit" name="successPhotoSubmit" class="button" value="Submit"><input type="hidden" name="spage" class="smalltxt" value="'.$varSepartePage.'"></center></td></tr></form>';
}
$success_photo .= '</td></tr><table>';
$success_photo .= '</table>';
$success_photo .= '</form>';
$success_photo .= '</body>';
$objSlave->dbClose();

echo $errorMessage;
echo $success_photo;
function showDomains()
{
 global $arrPrefixDomainList, $arrMatriIdPre;
 $arrMatriIdPre1 = array_flip($arrMatriIdPre);
 $showDomains .= "<select name='domain[]'  onchange='FilterByDomain()'>";
 $showDomains .= "<option value='All'";
 if(is_array($_REQUEST[domain]))
 {
  if(in_array("All",$_REQUEST[domain]))
   $showDomains .= " selected ";
 }
 else
 {
  if($key == $_REQUEST[domain])
   $showDomains .= " selected ";
 }
 $showDomains .= "> --- All ---    </option>";
 foreach($arrPrefixDomainList as $key => $value)
 {
  $numKey = $arrMatriIdPre1[$key];
  $showDomains .= "<option value='".$numKey."'";
  if(is_array($_REQUEST[domain]))
  {
   if(in_array($numKey,$_REQUEST[domain]))
    $showDomains .= " selected ";
  }
  else
  {
   if($key == $_REQUEST[domain])
    $showDomains .= " selected ";
  }
  $showDomains .= ">$value</option>";
 }
 $showDomains .= "</select>";
return $showDomains;
}
?>
<script language="javascript" type="text/javascript">
function viewPhotos(succesId){
   var path='success-photo-view.php?Success_Id='+succesId;
   window.open(path, "myWindow", "status = 0, height = 550, width = 650, resizable = 1,scrollbars=1");
}
function cropPhotos(succesId){
   var path='success-photo-crop.php?Success_Id='+succesId;
   window.open(path, "myWindow", "status = 0, height = 550, width = 650, resizable = 1,scrollbars=1");
}
function FilterByDomain(){
	document.frmSuccessPhoto.submit();
}
function photo_valid()
{
	var totrec = document.frmSuccessPhoto.totrec.value;
	var trc = totrec;
	var frmDetails = document.frmSuccessPhoto;
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
	for(i=1;i<=trc;i++)
	{
		j = i+1; 
		var matriid = "document.frmSuccessPhoto.matriId"+i+"";
		var addaction = "document.frmSuccessPhoto.action"+i+"[0]";
		var rejectaction = "document.frmSuccessPhoto.action"+i+"[1]";
//		alert(eval(matriid).value);
//		alert(addaction + ":" +eval(addaction).checked);
//		alert(rejectaction + ":" +eval(rejectaction).checked);
		if(!(eval(addaction).checked) && !(eval(rejectaction).checked))
		{
			alert("Please select Add or Ignore of story "+i+" of "+eval(matriid).value);
			eval(addaction).focus();
			return false;
		}
	}
	return true;
}
</script>