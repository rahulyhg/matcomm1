<?php
#=============================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 2008-09-28
# End Date		: 2008-10-01
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
if($_REQUEST['domain'][0]){
	if($_REQUEST['domain'][0] !='All') $domainId = $_REQUEST['domain'][0] ;	else $domainId = '' ;
}else{
    $domainId = $arrMatriIdPre1[$domainPrefix];
}
$folderName = $arrFolderNames[$domainPrefix];

$pendingPhotosDir = $varRootBasePath."/www/success/".$folderName."/pendingphotos";
$bigPhotosDir = $varRootBasePath."/www/success/".$folderName."/bigphotos";
$smallPhotosDir = $varRootBasePath."/www/success/".$folderName."/smallphotos";
$homePhotosDir = $varRootBasePath."/www/success/".$folderName."/homephotos";

if($_POST[successStorySubmit] == "Submit")
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

		$validStatus=0;
		for($i=0;$i<$totrec;$i++)
		{
			$action = "action$i";
			$success = "successid$i";
			$martiId = "martiId$i";
			$Bride_Name = $_POST['Bride_Name'.$i];
			$Groom_Name = $_POST['Groom_Name'.$i];
			$Telephone = $_POST['Telephone'.$i];
			$Contact_Address = $_POST['Contact_Address'.$i];
			$Marriage_Date = $_POST['Marriage_Date'.$i];
			$Success_Message = $_POST['Success_Message'.$i];
			
			
			
			$argFields = array('MatriId','Bride_Name','Groom_Name','Success_Message','Marriage_Date','Photo_Set_Status','CommunityId','Photo');
			$argCondition			= "WHERE Success_Id=".addslashes(strip_tags(trim($_REQUEST[$success])))."";
			//$varSelectSuccessForFile	= $objSlave -> select($varTable['SUCCESSSTORYINFO'],$argFields,$argCondition,0);
			$varSelectSuccessForFileRow = $objSlave -> select($varTable['SUCCESSSTORYINFO'],$argFields,$argCondition,1);

			$CommunityId=$varSelectSuccessForFileRow[0]['CommunityId'];
			$folderNameId=$arrMatriIdPre[$CommunityId];
			$folderName=$arrFolderNames[$folderNameId];
			$pendingPhotosDir = $varRootBasePath."/www/success/".$folderName."/pendingphotos";
            $bigPhotosDir = $varRootBasePath."/www/success/".$folderName."/bigphotos";
            $smallPhotosDir = $varRootBasePath."/www/success/".$folderName."/smallphotos";
            $homePhotosDir = $varRootBasePath."/www/success/".$folderName."/homephotos";
             
            
			if($varSelectSuccessForFileRow[0]['Photo_Set_Status']==0 && is_file($varRootBasePath."/www/success/".$folderName."/pendingphotos"."/".$varSelectSuccessForFileRow[0]['Photo'])){
				
                if(addslashes(strip_tags(trim($_REQUEST[$action])))=='Add'){
				$validStatus=1;
					if($photoNotValidatedMatriids)
						$photoNotValidatedMatriids.=', ';
						$photoNotValidatedMatriids.=$varSelectSuccessForFileRow[0]['MatriId'];
					}
					$errorMessage = "<div width='500' align='center'><font color=red>Please Validate the photo for following Matriids : ".$photoNotValidatedMatriids."</font></div>";
		    }
			
            if($validStatus==0){          
            //$varSelectSuccessForFileRow = mysql_fetch_assoc($varSelectSuccessForFile);
			if(addslashes(strip_tags(trim($_REQUEST[$action]))) == "Ignore")
			{
				$delArgCondition = "Success_Id=".addslashes(strip_tags(trim($_REQUEST[$success])));

				if($numDelRows = $objMaster -> delete($varTable['SUCCESSSTORYINFO'],$delArgCondition) >= 1)
				{
					if($varSelectSuccessForFileRow[0]['Photo_Set_Status'] == 0)
					{
						if(is_file($pendingPhotosDir."/".$_REQUEST[$martiId]."_SUCCESS.jpg"))
						{
							@unlink($pendingPhotosDir."/".$_REQUEST[$martiId]."_SUCCESS.jpg");
						}
					}
					if($varSelectSuccessForFileRow[0]['Photo_Set_Status'] == 1)
					{
						if(is_file($smallPhotosDir."/".$_REQUEST[$martiId]."_s.jpg"))
						{
							@unlink($smallPhotosDir."/".$_REQUEST[$martiId]."_s.jpg");
						}
						if(is_file($bigPhotosDir."/".$_REQUEST[$martiId]."_b.jpg"))
						{
							@unlink($bigPhotosDir."/".$_REQUEST[$martiId]."_b.jpg");
						}
						if(is_file($homePhotosDir."/".$_REQUEST[$martiId]."_h.jpg"))
						{
							@unlink($homePhotosDir."/".$_REQUEST[$martiId]."_h.jpg");
						}
					}
				}
			}
			if(addslashes(strip_tags(trim($_REQUEST[$action]))) == "Add")
			{
				

				$argFields 				= array('Publish','Date_Updated','Bride_Name','Groom_Name','Telephone','Contact_Address','Marriage_Date','Success_Message');
				$argFieldsValues		= array(1,"'".$varCurrentDate."'","'".$Bride_Name."'","'".$Groom_Name."'","'".$Telephone."'","'".$Contact_Address."'","'".$Marriage_Date."'","'".$Success_Message."'");
				$argCondition			= "Success_Id=".addslashes(strip_tags(trim($_REQUEST[$success])))."";
				$varUpdateId			= $objMaster->update($varTable['SUCCESSSTORYINFO'],$argFields,$argFieldsValues,$argCondition);
				//Txt file creation in stories folder
				$storiesFolderPath = $varRootBasePath."/www/success/$folderName/stories/";
                				
				$countFile = $storiesFolderPath."count.txt";
				if(is_file($countFile)){
					$countFileHandle = fopen($countFile,'r+');
				}else{
					$countFileHandle = fopen($countFile,'w');
					chmod($countFile,0777);  
					fwrite($countFileHandle,'0');
				}
				$countNumber = @fread($countFileHandle,filesize($countFile));
				if(!$countNumber)
					$countNumber=1;
				else
					$countNumber++;

				$countFileWriteHandle = fopen($countFile,'w+');
				fwrite($countFileWriteHandle,$countNumber);
                
                $MarriageDate=explode(" ",$varSelectSuccessForFileRow[0]['Marriage_Date']);
								
				$varSelectSuccessForFileContent = $varSelectSuccessForFileRow[0]['MatriId']."|".$Bride_Name."|".$Groom_Name."|".$Success_Message."|".$Marriage_Date."|".$varSelectSuccessForFileRow[0]['Photo_Set_Status'];
				$newFileName = $storiesFolderPath.$countNumber."_".addslashes(strip_tags(trim($_REQUEST[$martiId]))).".txt";
				$newFileHandle = fopen($newFileName,'x+');
				fwrite($newFileHandle,"".$varSelectSuccessForFileContent);
				fclose($newFileHandle);
				fclose($countFileWriteHandle);
				fclose($countFileHandle);
				$errorMessage = "<div class='alerttxt' width='500' align='center'>Success Story added Successfully.</div>";
			}
			if(addslashes(strip_tags(trim($_REQUEST[$action]))) == "Ignorephoto")
			{
				
				////Photo Ignore Part Start////////
				$argCondition = "WHERE Success_Id='".addslashes(strip_tags(trim($_REQUEST[$success])))."'";
				$argFields = array('Photo','CommunityId','Photo_Set_Status');
				if($varSelectSuccessForPhoto	= $objSlave -> select($varTable['SUCCESSSTORYINFO'],$argFields,$argCondition,0))
				{
					$varSelectSuccessForPhotoRow = mysql_fetch_assoc($varSelectSuccessForPhoto);
					
					$CommunityId=$varSelectSuccessForPhotoRow['CommunityId'];
					$folderNameId=$arrMatriIdPre[$CommunityId];
					$folderName=$arrFolderNames[$folderNameId];
					
					if($varSelectSuccessForPhotoRow['Photo'] != "")
					{
						$pendingPhoto = $varRootBasePath."/www/success/$folderName/pendingphotos/".$_REQUEST[$martiId]."_SUCCESS.jpg";
						@unlink($pendingPhoto);
					}
					if($varSelectSuccessForPhotoRow['Photo_Set_Status'] == 1)
					{
						if(is_file($smallPhotosDir."/".$_REQUEST[$martiId]."_s.jpg"))
						{
							@unlink($smallPhotosDir."/".$_REQUEST[$martiId]."_s.jpg");
						}
						if(is_file($bigPhotosDir."/".$_REQUEST[$martiId]."_b.jpg"))
						{
							@unlink($bigPhotosDir."/".$_REQUEST[$martiId]."_b.jpg");
						}
						if(is_file($homePhotosDir."/".$_REQUEST[$martiId]."_h.jpg"))
						{
							@unlink($homePhotosDir."/".$_REQUEST[$martiId]."_h.jpg");
						}
					}
				
				}
				
				////////Photo Ignore Part End//////

				$argFields 				= array('Publish','Date_Updated','Bride_Name','Groom_Name','Telephone','Contact_Address','Marriage_Date','Success_Message');
				$argFieldsValues		= array(1,"'".$varCurrentDate."'","'".$Bride_Name."'","'".$Groom_Name."'","'".$Telephone."'","'".$Contact_Address."'","'".$Marriage_Date."'","'".$Success_Message."'");
				$argCondition			= "Success_Id=".addslashes(strip_tags(trim($_REQUEST[$success])))."";
				$varUpdateId			= $objMaster->update($varTable['SUCCESSSTORYINFO'],$argFields,$argFieldsValues,$argCondition);
				//Txt file creation in stories folder
				$storiesFolderPath = $varRootBasePath."/www/success/$folderName/stories/";
                				
				$countFile = $storiesFolderPath."count.txt";
				if(is_file($countFile)){
					$countFileHandle = fopen($countFile,'r+');
				}else{
					$countFileHandle = fopen($countFile,'w');
					chmod($countFile,0777);  
					fwrite($countFileHandle,'0');
				}
				$countNumber = @fread($countFileHandle,filesize($countFile));
				if(!$countNumber)
					$countNumber=1;
				else
					$countNumber++;

				$countFileWriteHandle = fopen($countFile,'w+');
				fwrite($countFileWriteHandle,$countNumber);

                $MarriageDate=explode(" ",$varSelectSuccessForFileRow[0]['Marriage_Date']);
								
				$varSelectSuccessForFileContent = $varSelectSuccessForFileRow[0]['MatriId']."|".$Bride_Name."|".$Groom_Name."|".$Success_Message."|".$Marriage_Date."|".$varSelectSuccessForFileRow[0]['Photo_Set_Status'];
				$newFileName = $storiesFolderPath.$countNumber."_".addslashes(strip_tags(trim($_REQUEST[$martiId]))).".txt";
				$newFileHandle = fopen($newFileName,'x+');
				fwrite($newFileHandle,"".$varSelectSuccessForFileContent);
				fclose($newFileHandle);
				fclose($countFileWriteHandle);
				fclose($countFileHandle);
				$errorMessage = "<div class='alerttxt' width='500' align='center'>Success Story added Successfully.</div>";
			}
		 }
		}
	}
	else
	{
		$errorMessage = "<div class='errorMsg' width='500' align='center'>Invalid UserName or Password ,Enter valid UserName and Password</div>";
	}
	
}

$NumberStories = addslashes(strip_tags(trim($_REQUEST['NumberStories'])));
$startFrom = addslashes(strip_tags(trim($_REQUEST['startFrom'])));



if($NumberStories == "")
	$NumberStories = 10;
if($startFrom == "")
	$startFrom = 1;

if($domainId){
	$domainPre=$arrMatriIdPre[$domainId];
	$argFields = array('Success_Id','MatriId','CommunityId','Email','Bride_Name','Groom_Name','Marriage_Date','Success_Message','Telephone','Contact_Address','Publish','Date_Updated','Photo_Set_Status','Photo');
	$argCondition = " WHERE Publish=0 and CommunityId = ".$domainId." and substring(MatriId,1,3)='".$domainPre."' order by Date_Updated desc LIMIT ".$startFrom.",".$NumberStories;

	$totalNumRec = $objSlave -> numOfRecords($varTable['SUCCESSSTORYINFO'],'MatriId',' WHERE Publish=0 and CommunityId='.$domainId);
}else{
	$argFields = array('Success_Id','MatriId','CommunityId','Email','Bride_Name','Groom_Name','Marriage_Date','Success_Message','Telephone','Contact_Address','Publish','Date_Updated','Photo_Set_Status','Photo');
	$argCondition = " WHERE Publish=0 order by Date_Updated desc LIMIT ".$startFrom.",".$NumberStories;

	$totalNumRec = $objSlave -> numOfRecords($varTable['SUCCESSSTORYINFO'],'MatriId',' WHERE Publish=0');

}

$varTotalTable .= '<form method="post" name="frmValidSuccessStory" onSubmit="return story_valid();">';
$varTotalTable .= '<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545" align="center">
	<tr><td height="10"></td></tr>
	<tr>
		<td class="heading" style="padding-left:10px;">Filter By Domains : '.showDomains().' <input type="button" value="Go" class="button" onClick="FilterByDomain()"></td>
	</tr>
	<tr>
		<td class="heading" style="padding-left:10px;">&nbsp;</td>
	</tr>
	<tr>
		<td class="heading" style="padding-left:10px;">New Profiles </td>
	</tr>
	<tr><td width="50%" class="smalltxt" align="right"><font color="red"><b>New Profiles Pending Count - '.$totalNumRec.'</b></font></td></tr>
	</table>';

if($varSelectSuccessInfoRes	= $objSlave -> select($varTable['SUCCESSSTORYINFO'],$argFields,$argCondition,0))
{
	$varTotalNumRec = mysql_num_rows($varSelectSuccessInfoRes);
    
	if($domainId){
	$varTotalNumRec = $objSlave -> numOfRecords($varTable['SUCCESSSTORYINFO'],'MatriId',' WHERE Publish=0 and CommunityId='.$domainId);
	}else{
    $varTotalNumRec = $objSlave -> numOfRecords($varTable['SUCCESSSTORYINFO'],'MatriId',' WHERE Publish=0 ');
	}

	$varTotalTable .= '<input type="hidden" name="totrec" value="'.$varTotalNumRec.'">';
	$count = 0;
	$photoNotValidatedMatriids='';
	while($varSelectSuccessInfo = mysql_fetch_array($varSelectSuccessInfoRes))
	{
        $validStatus=0;
		$CommunityId=$varSelectSuccessInfo['CommunityId'];
		$folderNameId=$arrMatriIdPre[$CommunityId];
		$folderName=$arrFolderNames[$folderNameId];
      	
		//echo "<br>".$varRootBasePath."/www/success/".$folderName."/pendingphotos"."/".$varSelectSuccessInfo['Photo'];

        /*if($varSelectSuccessInfo['Photo_Set_Status']==0 && is_file($varRootBasePath."/www/success/".$folderName."/pendingphotos"."/".$varSelectSuccessInfo['Photo'])){
        $validStatus=1;
		if($photoNotValidatedMatriids)
			$photoNotValidatedMatriids.=',';
		    $photoNotValidatedMatriids.=$varSelectSuccessInfo['MatriId'];
		}*/
		

		$varTotalTable .= '<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="545" align="center">';
		$varTotalTable .= '<tr><td>&nbsp;<input type="hidden" name="successid'.$count.'" value="'.$varSelectSuccessInfo['Success_Id'].'"><input type="hidden" name="validStatus" id="validStatus" value="'.$validStatus.'"></td></tr>';
		$varTotalTable .= '<tr><td valign="top" class="smalltxt boldtxt" colspan="4" style="padding-left:10px;padding-bottom:3px;"><b>MatriId : '.$varSelectSuccessInfo['MatriId'].'<input type="hidden" name="martiId'.$count.'" value="'.$varSelectSuccessInfo['MatriId'].'"></td></tr>';
		$varTotalTable .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Bride Name :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><input type="text" name="Bride_Name'.$count.'" id="Bride_Name'.$count.'" value="'.$varSelectSuccessInfo['Bride_Name'].'"></td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Groom Name :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><input type="text" name="Groom_Name'.$count.'" id="Groom_Name'.$count.'" value="'.$varSelectSuccessInfo['Groom_Name'].'"></td></tr>';
		$varSelectSuccessInfo['Marriage_Date'] = explode(" ",$varSelectSuccessInfo['Marriage_Date']);

		$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Telephone :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"><input type="text" name="Telephone'.$count.'" id="Telephone'.$count.'" value="'.$varSelectSuccessInfo['Telephone'].'">';
		$varTotalTable .= '</td><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%" rowspan="2">Contact Address :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
		$varTotalTable .= '<input type="text" name="Contact_Address'.$count.'" id="Contact_Address'.$count.'" value="'.$varSelectSuccessInfo['Contact_Address'].'">';
		$varTotalTable .= '</td></tr>';

		$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Marriage Date :</td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
		$varTotalTable .= '<input type="text" name="Marriage_Date'.$count.'" id="Marriage_Date'.$count.'" value="'.$varSelectSuccessInfo['Marriage_Date'][0].'">';
		$varTotalTable .= '</td></tr>';


		$varTotalTable .= '<tr bgcolor="#FFFFFF"><td  valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Success Message </td><td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%" colspan="3"><textarea name="Success_Message'.$count.'" id="Success_Message'.$count.'" cols="40" rows="5">'.$varSelectSuccessInfo['Success_Message'].'</textarea></td></tr>';
		$varTotalTable .= '<tr><td class="smalltxt" colspan=2><input type="radio" name="action'.$count.'" value="Add"> Add &nbsp; <input type="radio" name="action'.$count.'" value="Ignore"> Ignore&nbsp; <input type="radio" name="action'.$count.'" value="Ignorephoto"> Add without Photo</td><td colspan="2" align="right" class="formlink1">';
		if(is_file($varRootBasePath."/www/success/".$folderName."/pendingphotos"."/".$varSelectSuccessInfo['Photo']) || is_file($varRootBasePath."/www/success/".$folderName."/bigphotos"."/".$varSelectSuccessInfo['Photo'])) {
              
            $varTotalTable .= '<a href="javascript:uploadPhotos('.$varSelectSuccessInfo['Success_Id'].');" class="smalltxt boldtxt" >Upload Photo</a>&nbsp;&nbsp;';
			
            //if(is_file($varRootBasePath."/www/success/".$folderName."/bigphotos"."/".$varSelectSuccessInfo['Photo'])){
			$varTotalTable .= '<a href="javascript:viewPhotos('.$varSelectSuccessInfo['Success_Id'].');" class="smalltxt boldtxt" >View Photo</a>&nbsp;&nbsp;';
			//}
			
			$varTotalTable .= '<a href="javascript:cropPhotos('.$varSelectSuccessInfo['Success_Id'].');" class="smalltxt boldtxt" >Crop Photo</a>';

		}else{
            $varTotalTable .= '<font class="smalltxt">No Photo Found</font>';
		}

		$varTotalTable .= '</td></tr>';
		$varTotalTable .= '<tr><td height="10" width="100%"  class="vdotline1" colspan="4"><HR></td></tr>';
		$varTotalTable .= '</table>';
		$count++;
	}
}
$varTotalTable .= '<input type="hidden" name="photoNotValidatedMatriids" id="photoNotValidatedMatriids" value="'.$photoNotValidatedMatriids.'"><table border="0" cellpadding="3" cellspacing="0" width="530" class="formborder" align="center">
	<tr><td class="adminformheader">Please enter your login details :</td></tr><tr><td>
<table border="0" cellpadding="3" cellspacing="3" width="230"><tbody><tr><td><font class="smalltxt boldtxt"><b>Username : </b></font></td><td><input name="suplogin" class="inputtxt" size="15" type="text" value=""></td></tr><tr><td><font class="smalltxt boldtxt"><b>Password : </b></font></td><td><input name="suppswd" size="15" type="password" value=""></td></tr></tbody></table></td></tr></table><br><br></td></tr><tr><td><center><input type="submit" name="successStorySubmit" class="button" value="Submit"><input type="hidden" name="spage" class="smalltxt" value="'.$varSepartePage.'"></center></td></tr></form>';
$objSlave->dbClose();

echo $errorMessage."<br>";
echo $varTotalTable;

function showDomains()
{
 global $arrPrefixDomainList, $arrMatriIdPre;
 $arrMatriIdPre1 = array_flip($arrMatriIdPre);
 $showDomains .= "<select name='domain[]'>";
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
function uploadPhotos(succesId){
   var path='success-photo-upload.php?Success_Id='+succesId;
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
		var photoreject = "document.frmSuccessPhoto.action"+i+"[2]";
		
//		alert(eval(matriid).value);
//		alert(addaction + ":" +eval(addaction).checked);
//		alert(rejectaction + ":" +eval(rejectaction).checked);
		if(!(eval(addaction).checked) && !(eval(rejectaction).checked) && !(eval(photoreject).checked))
		{
			alert("Please select Add or Ignore of story "+i+" of "+eval(matriid).value);
			eval(addaction).focus();
			return false;
		}
	}
	return true;
}
</script>
<script language="javascript" type="text/javascript">
function modifySuccessStory(succesId){
   var path='modify-success-story.php?Success_Id='+succesId;
   window.open(path, "myWindow", "status = 0, height = 550, width = 650, resizable = 1,scrollbars=1");
}
function FilterByDomain(){
	document.frmValidSuccessStory.submit();
}
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
	
	//alert(document.getElementById('photoNotValidatedMatriids').value);
	/*if(document.getElementById('validStatus').value==1){
		var mIds=document.getElementById('photoNotValidatedMatriids').value;
		alert("Please validate the photos for following Matriids : "+mIds);
		return false;
	}*/
	
	for(i=0;i<trc;i++)
	{
		j = i+1; 
		var matriid = "document.frmValidSuccessStory.martiId"+i+"";
		var addaction = "document.frmValidSuccessStory.action"+i+"[0]";
		var rejectaction = "document.frmValidSuccessStory.action"+i+"[1]";
		var photoreject = "document.frmValidSuccessStory.action"+i+"[2]";
		//alert(eval(matriid).value);
		//alert(addaction + ":" +eval(addaction).checked);
		//alert(rejectaction + ":" +eval(rejectaction).checked);
		if(!(eval(addaction).checked) && !(eval(rejectaction).checked) && !(eval(photoreject).checked))
		{
			alert("Please select Add or Ignore of story "+j+" of "+eval(matriid).value);
			eval(addaction).focus();
			return false;
		}
	}
	return true;
}
</script>