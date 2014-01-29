<?php
#=============================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 2008-09-28
# End Date		: 2008-09-28
# Project		: CommunityMatrimony
# Module		: Successstory - Story Gallery
#=============================================================================================================

$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath.'/lib/clsRegister.php');
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath."/conf/config.inc");

if($_COOKIE['adminLoginInfo']==''){
	$urllogin = $confValues['ServerURL'];
    header("location:$urllogin/admin/index.php?act=login");
}

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
$folderName = $arrFolderNames[$domainPrefix];

if($folderName=='' || !$folderName || empty($folderName)){
	
$varFields			= array('CommunityId');
$varCondition		= "WHERE Success_Id = ".addslashes(strip_tags(trim($_REQUEST['Success_Id'])));
$varResult			= $objSlave->select($varTable['SUCCESSSTORYINFO'], $varFields, $varCondition, 0);
$arrSelectPhotoInfo = mysql_fetch_assoc($varResult);
$CommunityId=$arrSelectPhotoInfo['CommunityId'];
$folderNameId=$arrMatriIdPre[$CommunityId];
$folderName=$arrFolderNames[$folderNameId];

}



$imageBaseFolderName = "../../success/$folderName";
$argFields = array('MatriId','Photo','Photo_Set_Status');
$argCondition = " WHERE Success_Id=".addslashes(strip_tags(trim($_REQUEST['Success_Id'])));
if($successPhotoViewResult = $objSlave -> select($varTable['SUCCESSSTORYINFO'],$argFields,$argCondition,0))
{
	$successPhotoViewRow = mysql_fetch_array($successPhotoViewResult);
	$fileExtArr = explode(".",$successPhotoViewRow[Photo]);
	$lessCount = count($fileExtArr) - 1;
	$fileExt = $fileExtArr[$lessCount];

	if($successPhotoViewRow['Photo_Set_Status']==1){
	
	if(is_file("$imageBaseFolderName/smallphotos/$successPhotoViewRow[MatriId]_s.".$fileExt))
		$showSmallImage = "<img src='$imageBaseFolderName/smallphotos/$successPhotoViewRow[MatriId]_s.$fileExt'>";
	else
		$showSmallImage = "120*80 Photo not found";
	if(is_file("$imageBaseFolderName/bigphotos/$successPhotoViewRow[MatriId]_b.".$fileExt))
		$showBigImage = "<img src='$imageBaseFolderName/bigphotos/$successPhotoViewRow[MatriId]_b.$fileExt'>";
	else
		$showBigImage = "300*200 Photo not found";
	if(is_file("$imageBaseFolderName/homephotos/$successPhotoViewRow[MatriId]_h.".$fileExt))
		$showHomeImage = "<img src='$imageBaseFolderName/homephotos/$successPhotoViewRow[MatriId]_h.$fileExt'>";
	else
		$showHomeImage = "60*60 Photo not found";
	}else{

       $showSmallImage = "<img src='$imageBaseFolderName/pendingphotos/$successPhotoViewRow[MatriId]_SUCCESS.$fileExt'>";

	}
}

if($_POST['successPhotoSubmit'] == "Submit")
{
	$varCurrentDate				= date('Y-m-d H:i:s');
	$varUsername				= addslashes(strip_tags(trim($_REQUEST['suplogin'])));
	$varPassword				= md5(addslashes(strip_tags(trim($_REQUEST['suppswd']))));

	$argCondition				= "WHERE User_Name='".$varUsername."' and Password = '".$varPassword."'";
	//$usernameCheckQuery			= " select User_Name,Password from ".$varTable['ADMINLOGININFO']." $argCondition";
	$varCheckUserName			= $objSlave->numOfRecords($varTable['ADMINLOGININFO'],'User_Name',$argCondition);

	if($varCheckUserName >= 1)
	{
		
		$argFields 				= array('Last_Login');
		$argFieldsValues		= array("'".$varCurrentDate."'");
		$argCondition			= "User_Name='".$varUsername."'";
		

		$varUpdateId			= $objMaster->update($varTable['ADMINLOGININFO'],$argFields,$argFieldsValues,$argCondition);

			$varAction = addslashes(strip_tags(trim($_REQUEST['action1'])));
			
			$varSuccessid = addslashes(strip_tags(trim($_REQUEST['Success_Id'])));
			
			if($varAction == "Add")
			{
				if(is_file("$imageBaseFolderName/smallphotos/$successPhotoViewRow[MatriId]_s.".$fileExt)){
				
				$argFields 				= array('Photo_Set_Status');
				$argFieldsValues		= array("'1'");
				
				$argCondition			= "Success_Id='".$varSuccessid."'";
				$varUpdateId			= $objMaster->update($varTable['SUCCESSSTORYINFO'],$argFields,$argFieldsValues,$argCondition);
				$errorMessage = "<div class='alerttxt' width='500' align='center'>Photo Validated Successfully.</div>";
				echo "<script>window.close();window.opener.location.href = window.opener.location.href;</script>";
				}else{
				$errorMessage = "<div class='errortxt' width='500' align='center'>Photo Not Validated, Please Crop the Photo.</div>";
				}
				
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

					echo "<script>window.close();window.opener.location.href = window.opener.location.href;</script>";
				}
			}
		
	}
	else
	{
		$errorMessage = "<div class='errortxt' width='500' align='center'>Invalid UserName or Password ,Enter valid UserName and Password</div>";
	}
}


?>
<script>

function story_valid()
{
	var frmDetails = document.frmValidSuccessPhoto;
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
}
</script>
<style type="text/css"> @import url("<?=$confValues['CSSPATH'];?>/global-style.css"); </style>
<table width="88%" align="center" border="0"><tr><td>
<img src="<?=$confValues['IMGURL']?>/images/logo/community_logo.gif" alt="Community Matrimony" border="0" />
<tr><td><hr></td></tr><tr><td align="right">
</td></tr>
</td></tr></table>
<?php echo $errorMessage."<br>"; 


?>


<table border="0" cellpadding="0" cellspacing="0" align="left" width="700">
	<tr>
		<td style="padding-left:60px;">
		
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="700">
			<tr><td class='mediumtxt'>
			<?php
				echo $showHomeImage;
			?>
			<br><br><br clear="all">
			<?php
				echo $showSmallImage;
			?>
			</td>
			<td></td>
			<td>
			<?php
				echo $showBigImage;
			?>
			</td></tr>
			</table>
		</td>
	</tr>
	<tr><td height="15"></td></tr>
</table>
