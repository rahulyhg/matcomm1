<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : success.php
#=====================================================================================================================================
# Description : getting success story information
#=====================================================================================================================================
//ini_set('display_errors',1);
//error_reporting(E_ALL);
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath."/lib/clsSuccessMailer.php");

//OBJECT CREATION
$objCommon	= new clsCommon;
$objSuccess	= new SuccessMailer;
$objSlave	= new SuccessMailer;

$objSuccess->dbConnect('M', $varDbInfo['DATABASE']);
$objSlave->dbConnect('S', $varDbInfo['DATABASE']);

$varMatriId		= $_REQUEST['MatriId'];
$varActFields	= array("Success_Id","Photo");
$varActCondtn	= " WHERE MatriId='".$varMatriId."'";
$varActInf		= $objSuccess->select($varTable['SUCCESSSTORYINFO'],$varActFields,$varActCondtn,1);

if($_POST['act'] == 'fullfill_success_photo' && $_POST['frmsuccessstorySubmit'] == 'yes') { 
    
	$varMatriId		= strtoupper(addslashes(strip_tags(trim($_POST['matriid']))));
	$varCurrentDate	= date("Y-m-d");

			
	if(!preg_match("/^[a-zA-Z]{3}[0-9]{6,8}$/",$varMatriId)) {
		$varErrMsg = 'Enter correct matrimony id1.';
	} else {
		//photo moving to appropriate domain wise folder
	
		if($_FILES['photo']['name'] != '') {
			$varFolderName	= $objSuccess->getFolderName($varMatriId);
			echo $varRootBasePath."/www/success/".$varFolderName;
            if(!is_dir($varRootBasePath."/www/success/".$varFolderName)){
				mkdir($varRootBasePath."/www/success/".$varFolderName,0777);
                chmod($varRootBasePath."/www/success/".$varFolderName,0777);
				mkdir($varRootBasePath."/www/success/".$varFolderName."/pendingphotos",0777);
				chmod($varRootBasePath."/www/success/".$varFolderName."/pendingphotos",0777);
				mkdir($varRootBasePath."/www/success/".$varFolderName."/smallphotos",0777);
				chmod($varRootBasePath."/www/success/".$varFolderName."/smallphotos",0777);
				mkdir($varRootBasePath."/www/success/".$varFolderName."/homephotos",0777);
				chmod($varRootBasePath."/www/success/".$varFolderName."/homephotos",0777);
				mkdir($varRootBasePath."/www/success/".$varFolderName."/bigphotos",0777);
				chmod($varRootBasePath."/www/success/".$varFolderName."/bigphotos",0777);

				if(!is_dir($varRootBasePath."/www/success/".$varFolderName)){
					echo "There is no permission to create directory ".$varFolderName;
					exit;
				}
			}
			
			if($varFolderName != '') {
				$varPhotoFile	= explode(".",$_FILES['photo']['name']);
				$varFileName	= $varMatriId."_SUCCESS.".$varPhotoFile[1];
				$varUploadPath	= $varRootBasePath."/www/success/".$varFolderName."/pendingphotos/";
				$varTargetPath	= $varUploadPath.$varFileName;

				if(!move_uploaded_file($_FILES['photo']['tmp_name'], $varTargetPath)) {
					$varFileName= '';
				}
			}
		}

		// To update Successstory table
		        
		$varUpdateCondtn	    = " MatriId='".$varMatriId."'";
		$varPhoneupdateFields	= array("Photo");
	    $varPhoneupdateVal	    = array("'".$varFileName."'");
	    $objSuccess->update($varTable['SUCCESSSTORYINFO'], $varPhoneupdateFields, $varPhoneupdateVal, $varUpdateCondtn);

		$varDisplayMsg = 'Thank you for submitting the Success Story Photo.';
		
		
	}
	
}


?>



<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5"><font class="clr bld">Add Success Story Photo</font></div>
	<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<br clear="all">
	<center>
	<div class="rpanel padt10">
		<? if(@$varDisplayMsg!='') { echo '<div style="padding:17px">'.@$varDisplayMsg.'</div>'; } else { if($varErrMsg!='') {echo '<div class="errortxt" style="padding:15px 15px 0px 50px;">'.@$varErrMsg.'</div>';}?>
		<br clear="all">
		<div class="fright opttxt"><font class="clr1">*</font>Mandatory</div>
		<br clear="all">	
		<form method="post" name="frmSuccess" enctype="multipart/form-data" onSubmit="return successvalidate();">
			<input type="hidden" name="act" value="fullfill_success_photo">
			<input type="hidden" name="frmsuccessstorySubmit" value="yes">
			
            <div class="pntr" align="center">
			<a class="smalltxt boldtxt" href="javascript:uploadPhotos(<?=$varActInf[0]['Success_Id'];?>);">Upload Photo</a>&nbsp;&nbsp;
            <a class="smalltxt boldtxt" href="javascript:viewPhotos(<?=$varActInf[0]['Success_Id'];?>);">View Photo</a>&nbsp;&nbsp;
            <a class="smalltxt boldtxt" href="javascript:cropPhotos(<?=$varActInf[0]['Success_Id'];?>);">Crop Photo</a>
			</div>

            <br clear="all">
			<br clear="all">
			<div class="srchdivlt fleft tlright smalltxt">Matrimony Id<font class="clr1">*</font>&nbsp;&nbsp;&nbsp;&nbsp;</div>
			<div class="srchdivrt fleft" >
				<input type="text" name="matriid" readonly size=35 class="inputtext" tabindex="3" value=<?=@$varMatriId?>>
			</div>
			<br clear="all">

			<br clear="all">
            <div class="srchdivlt fleft tlright smalltxt">Attach photo<font class="clr1">*</font>&nbsp;&nbsp;</div>
			<div class="srchdivrt fleft">
				<input type="file" name="photo" class="button" size="36" tabindex="8" style="width:270px;">
				<!-- Sysdet Bubble out div-->
				<div id="addrdetdiv" style="z-index:2110;margin-left:205px;display:none;"><span class="posabs" style="width:153px; height:78px;background:url('<?=$confValues['IMGURL']?>/images/success_img1.gif') no-repeat;padding-top:25px;padding-left:22px;"><span class="smalltxt clr3 tlleft" style="width:122px;padding-left:2px;">Mention your address <br>below so that we can <br>send you a special gift.</span></span></div>
				<!-- Sysdet Bubble out div-->
			</div>
			<br clear="all">
			<br clear="all">
			<div class="srchdivlt fleft tlright smalltxt">&nbsp;</div>
			<div class="srchdivrt fleft">
				<div class="fright">
					<input type="submit" value="Save" class="button" tabindex="12">&nbsp;&nbsp;
					<input type="reset" value="Reset" class="button" tabindex="13">
				</div>
			</div>
		</form>
	<?}?>	<!-- Close if varDisplayMsg -->
	</div>
	</center>
</div>
<script>
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
function $(obj) {
   if(document.getElementById) {
        if(document.getElementById(obj)!=null) {
            return document.getElementById(obj)
        } else {
           return "";
       }
    } else if(document.all) {
        if(document.all[obj]!=null) {
            return document.all[obj]
        } else  {
          return "";
       }
    }
}

function IsEmpty(obj, obj_type)
{
	if (obj_type == "text" || obj_type == "password" || obj_type == "textarea" || obj_type == "file")	{
		var objValue;
		objValue = obj.value.replace(/\s+$/,"");
		if (objValue.length == 0) {
			return true;
		} else {
			return false;
		}
	} else if (obj_type == "select" || obj_type == "select-one") {
		for (i=0; i < obj.length; i++) {
			if (obj.options[i].selected) 
				{
					if(obj.options[i].value==" ") 
					{return true;obj.focus();} else {return false;}
					
					if(obj.options[i].value == "0") 
					{
						if(obj.options[i].seletedIndex == "0") 
						{return true;obj.focus();}
					} else {return false;}
				}
			
		}
		return true;	
	} else if (obj_type == "radio" || obj_type == "checkbox") {
		if (!obj[0] && obj) {
			if (obj.checked) {
				return false;
			} else {
				return true;	
			}
		} else {
			for (i=0; i < obj.length; i++) {
				if (obj[i].checked) {
					return false;
				}
			}
			return true;
		}
	} else {
		return false;
	}
}

function successvalidate(){
	var sucfrm = document.frmSuccess;
	
	if(IsEmpty(sucfrm.matriid,"text")) {
	//$('matidspan').innerHTML="Enter matrimony id";
	alert("Enter matrimony id");
	sucfrm.matriid.focus();
	return false;
	} 
		
	if(sucfrm.photo.value!='') {
		var varFrm = sucfrm;var extPos = varFrm.photo.value.lastIndexOf( "." );
		if (extPos == - 1) {
			//$('upPhotoSpan').innerHTML="Only gif or jpg files can be added";
			alert("Only gif or jpg files can be added");
			varFrm.photo.focus();return false;
		} else {
			var extn =  varFrm.photo.value.substring(extPos + 1, varFrm.photo.value.length);
			if ( extn != "gif" && extn != "jpg" && extn != "jpeg" && extn != "GIF" && extn != "JPG" && extn != "JPEG" ) {
				//$('upPhotoSpan').innerHTML="Only gif or jpg files can be added";
				alert("Only gif or jpg files can be added");
				varFrm.photo.value= "";
				varFrm.photo.focus();
				return false; }
		}
	}else{
		alert("Please upload photo.");
		sucfrm.photo.value= "";
		sucfrm.photo.focus();
		return false;
	}
	return true;
}

</script>