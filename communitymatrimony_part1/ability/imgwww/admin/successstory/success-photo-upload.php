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

//if($folderName=='' || !$folderName || empty($folderName)){
	
$varFields			= array('MatriId','Photo','Photo_Set_Status','CommunityId');
$varCondition		= "WHERE Success_Id = ".addslashes(strip_tags(trim($_REQUEST['Success_Id'])));
$varResult			= $objSlave->select($varTable['SUCCESSSTORYINFO'], $varFields, $varCondition, 0);
$arrSelectPhotoInfo = mysql_fetch_assoc($varResult);
$CommunityId=$arrSelectPhotoInfo['CommunityId'];
$folderNameId=$arrMatriIdPre[$CommunityId];
$folderName=$arrFolderNames[$folderNameId];
$MatriId = $arrSelectPhotoInfo['MatriId'];
//}


if(isset($_POST['successPhotoSubmit'])) {


		//photo moving to appropriate domain wise folder
	
		if($_FILES['photo']['name'] != '') {
			
           
			if($folderName != '') {
				$varPhotoFile	= explode(".",$_FILES['photo']['name']);
				$varFileName	= $MatriId."_SUCCESS.".$varPhotoFile[1];
				$varUploadPath	= $varRootBasePath."/www/success/".$folderName."/pendingphotos/";
				$varTargetPath	= $varUploadPath.$varFileName;

				if(!move_uploaded_file($_FILES['photo']['tmp_name'], $varTargetPath)) {
					$errorMessage= "<div class='errortxt' width='500' align='center'>Photo Not Uploaded!</div>";
				}else{
					$bigPhotosDir = $varRootBasePath."/www/success/".$folderName."/bigphotos";
                    $smallPhotosDir = $varRootBasePath."/www/success/".$folderName."/smallphotos";
                    $homePhotosDir = $varRootBasePath."/www/success/".$folderName."/homephotos";
					if(is_file($smallPhotosDir."/".$MatriId."_s.jpg"))
					{
							@unlink($smallPhotosDir."/".$MatriId."_s.jpg");
					}
					if(is_file($bigPhotosDir."/".$MatriId."_b.jpg"))
					{
					    	@unlink($bigPhotosDir."/".$MatriId."_b.jpg");
					}
					if(is_file($homePhotosDir."/".$MatriId."_h.jpg"))
					{
							@unlink($homePhotosDir."/".$MatriId."_h.jpg");
					}

					$argFields 				= array('Photo_Set_Status','Photo');
					$argFieldsValues		= array('0',"'".$varFileName."'");
					$argCondition			= "Success_Id='".$_REQUEST['Success_Id']."'";
					$varUpdateId			= $objMaster->update($varTable['SUCCESSSTORYINFO'],$argFields,$argFieldsValues,$argCondition);
					
					$errorMessage= "<div class='errortxt' width='500' align='center'>Photo Uploaded Successfully!!</div>";
				}
			}
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
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script>
	function successphotovalidate(){
	var sucfrm = document.frmSuccess;
    if(sucfrm.photo.value==''){
		alert("Please Upload the Photo!");
		return false;
	}
	if(sucfrm.photo.value!='') {
		var varFrm = sucfrm;
		var extPos = varFrm.photo.value.lastIndexOf( "." );
		if (extPos == - 1) {
			document.getElementById('upPhotoSpan').innerHTML="Only gif or jpg files can be added";varFrm.photo.focus();return false;
		} else {
			var extn =  varFrm.photo.value.substring(extPos + 1, varFrm.photo.value.length);
			if ( extn != "gif" && extn != "jpg" && extn != "jpeg" && extn != "GIF" && extn != "JPG" && extn != "JPEG" ) {
				document.getElementById('upPhotoSpan').innerHTML="Only gif or jpg files can be added";
				varFrm.photo.value= "";
				varFrm.photo.focus();
				return false; }
		}
	}

}
function photouploadval() {
	var varFrm = document.frmSuccess;
	var extPos = varFrm.photo.value.lastIndexOf( "." );
	if (extPos == - 1) {
		//$('upPhotoSpan').innerHTML="Only gif or jpg files can be added into your success story";varFrm.photo.focus();return false;
	} else {
		var extn =  varFrm.photo.value.substring(extPos + 1, varFrm.photo.value.length);
		if ( extn != "gif" && extn != "jpg" && extn != "jpeg" && extn != "GIF" && extn != "JPG" && extn != "JPEG" )
		{
			document.getElementById('upPhotoSpan').innerHTML="Only gif or jpg files can be added into your success story";
			varFrm.photo.value= "";
			varFrm.photo.focus();
			return false; }
	} return true;
}
</script>

<form method="post" name="frmSuccess" enctype="multipart/form-data" onSubmit="return successphotovalidate();">
<table border="0" cellpadding="0" cellspacing="0" align="left" width="700">
	<tr>
		<td style="padding-left:60px;">
		
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="600">
			<tr><td class='mediumtxt'>
			<div class="srchdivlt fleft tlright smalltxt">Attach Photo<br></div>
			<div class="srchdivrt fleft">
				<input type="file" name="photo" class="button" size="36" tabindex="8" style="width:270px;" onBlur="photouploadval();"><br clear="all"><span id="upPhotoSpan" class="errortxt"></span>
				<!-- Sysdet Bubble out div-->
				<div id="addrdetdiv" style="z-index:2110;margin-left:205px;display:none;"><span class="posabs" style="width:153px; height:78px;background:url('http://img.communitymatrimony.com/images/success_img1.gif') no-repeat;padding-top:25px;padding-left:22px;"><span class="smalltxt clr3 tlleft" style="width:122px;padding-left:2px;">Mention your address <br>below so that we can <br>send you a special gift.</span></span></div>
				<!-- Sysdet Bubble out div-->
			</div>
			</td>
			</tr>
			<tr><td><center>&nbsp;</center></td></tr>
			<tr><td><center><input type="submit" name="successPhotoSubmit" class="button" value="Submit"></center></td></tr>
			</table>
		</td>
	</tr>
	<tr><td height="15"></td></tr>
</table>
</form>
