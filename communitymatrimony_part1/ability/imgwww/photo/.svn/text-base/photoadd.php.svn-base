<?php
#================================================================================================================
   # Author 		: Senthilnathan
   # Date			: 17-July-2008
   # Project		: MatrimonyProduct
   # Filename		: photoadd.php
#================================================================================================================
   # Description	: PhotoManagement - Managephoto
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/emailsconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath."/lib/clsPhoto.php");

//SESSION VARIABLES
$sessMatriId		= $varGetCookieInfo['MATRIID'];

//Object initialization
$objPhoto			= new Photo;
$objSlaveDB			= new MemcacheDB;
$objMasterDB		= new MemcacheDB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//VARIABLE DECLARATION
$varDomainPHPath	= $varRootBasePath.'/www/membersphoto/'.$arrDomainInfo[$varDomain][2];
$varPhotoBupPath	= $varDomainPHPath.'/backup/';
$varPhotoCrop800	= $varDomainPHPath.'/crop800/';
$varPhotoCrop450	= $varDomainPHPath.'/crop450/';
$varPhotoCrop150	= $varDomainPHPath.'/crop150/';
$varPhotoCrop75		= $varDomainPHPath.'/crop75/';
$varErrorMode		= 0;
$varUpdate 			= ''; 
$varErrorType		= ''; 
$varUpPhotoError	= 0;
$varTmpPhoto		= $_FILES['newphoto'];
$varPhotoPath		= $_FILES['newphoto']['tmp_name'];
$varPhotoName		= $_FILES['newphoto']['name'];
$varPhotoSize		= $_FILES['newphoto']['size'];
$varUpPhotoError 	= (int)$_FILES['newphoto']['error'];

//echo $confValues['PHOTOMAXSIZE'] .'<'. $varPhotoSize;exit;
function file_upload_error_message($error_code) {
    switch ($error_code) {
        case 1:
			//UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case 2:
			//UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case 3:
			//UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case 4:
			//UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case 6:
			//UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case 7:
			//UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case 8:
			//UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
} 

if (($_POST['frmAddPhotoSubmit'] == 'yes')  && ($varPhotoSize < $confValues['PHOTOMAXSIZE'] ) && ($varUpPhotoError == 0) && $sessMatriId != '') {
	
	$varNum			= substr_count($varPhotoName,'.'); 
	$arrPhotoSplit	= explode(".",$varPhotoName);
	$varPhotoOrgExt	= strtolower($arrPhotoSplit[$varNum]);
	$varPhotoExt	= 'jpg';
	$varPhotoNo		= $_REQUEST['photono'];
	$varCondition	= " WHERE  MatriId= '".$sessMatriId."'";
	$varTotRecords	= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], $argPrimary='MatriId', $varCondition);
	
	if($varTotRecords == 0 )	{
		$varFields 		= array('MatriId');
		$varFieldValues	= array("'".$sessMatriId."'");
		$varFormResult	= $objMasterDB->insert($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues);
		$varPhotoNo		= 1;
	}
	
	$varAction			= $_REQUEST["actionval"];
	$varFields			= array('*');
	$varCondition		= "WHERE MatriId = '".$sessMatriId."'";
	$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
	$arrSelectPhotoInfo = mysql_fetch_assoc($varResult);
	$varRandnNumber		= rand(0,1000);
	
	if ($varAction == "add" ){
		for($i=1;$i<=10;$i++){
			if (trim($arrSelectPhotoInfo['Thumb_Big_Photo'.$i])== '') {
				$varPhotoNo			=  $i;
				$varNewStatus		=	0;
				break;
			}
		}
		$varSelectName		= $objPhoto->createPhotoName($sessMatriId);
		$varImgProcName		= $varSelectName."_TB_".$varPhotoNo;
		$varOriImageName	= $varSelectName."_TB_".$varPhotoNo.".".$varPhotoExt;
		$varThumpImage75	= $varSelectName."_NL_".$varPhotoNo.".".$varPhotoExt;
		$varThumpImage150	= $varSelectName."_TS_".$varPhotoNo.".".$varPhotoExt;
	} elseif ($varAction == "change" ) {
		$varOriImageName	= $arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo];
		$arrImgInfo			= explode(".",$varOriImageName);
		$varImgProcName		= $arrImgInfo[0];
		$varThumpImage75	= $arrSelectPhotoInfo['Normal_Photo'.$varPhotoNo];
		$varThumpImage150	= $arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo];
		
		if ($arrSelectPhotoInfo['Photo_Status'.$varPhotoNo] == 1  || $arrSelectPhotoInfo['Photo_Status'.$varPhotoNo] == 2) {
			$varNewStatus		= 2;
		} else
			$varNewStatus		= 0;
	}
	$varPhotoFormat		= array('jpeg','jpg','gif','png');
	$varPhotoId			= $varOriImageName."?id=".$varRandnNumber;
	list($varPhotoWidth,$varPhotoHeight)	=	getimagesize($varPhotoPath);
	
	if (in_array($varPhotoOrgExt,$varPhotoFormat) &&  $varPhotoWidth >= 75 &&  $varPhotoHeight >= 75) {
		if ($_FILES['newphoto']['error'] == 0) {
			if (file_exists($varPhotoBupPath.$varOriImageName))
				unlink($varPhotoBupPath.$varOriImageName);
			if (file_exists($varPhotoCrop75.$varThumpImage75))
				unlink($varPhotoCrop75.$varThumpImage75);
			if (file_exists($varPhotoCrop150.$varThumpImage150))
				unlink($varPhotoCrop150.$varThumpImage150);
			if (file_exists($varPhotoCrop800.$varOriImageName))
				unlink($varPhotoCrop800.$varOriImageName);
			
			$varMoveFiles	= move_uploaded_file($varPhotoPath,$varPhotoBupPath.$varImgProcName.".".$varPhotoOrgExt);
			chmod($varPhotoBupPath.$varImgProcName.".".$varPhotoOrgExt,0777);
			
			if ($varPhotoOrgExt == 'gif' ){
				$img = imagecreatefromgif($varPhotoBupPath.$varImgProcName.".".$varPhotoOrgExt);
				imagejpeg($img,$varPhotoBupPath.$varOriImageName);
				ImageDestroy($img);
			} elseif ($varPhotoOrgExt == 'png' ) {
				$img = imagecreatefrompng($varPhotoBupPath.$varImgProcName.".".$varPhotoOrgExt);
				imagejpeg($img,$varPhotoBupPath.$varOriImageName);
				ImageDestroy($img);
			}
			
			if ($varPhotoWidth > 800 || $varPhotoHeight > 600 ) {
				try {
					copy ($varPhotoBupPath."".$varOriImageName,$varPhotoCrop800."".$varOriImageName);
				} catch (Exception $varError){
					$varErrorMode	= 1;
				}
			}
			
			try { 
				 copy ($varPhotoBupPath."".$varOriImageName,$varPhotoCrop450."".$varOriImageName);
			} catch (Exception $varError){
				$varErrorMode	= 1;
			}
			
			try { 
				 copy ($varPhotoBupPath."".$varOriImageName,$varPhotoCrop150."".$varThumpImage150);
			} catch (Exception $varError){
				$varErrorMode	= 1;
			}
			
			try { 
				 copy ($varPhotoBupPath."".$varOriImageName,$varPhotoCrop75."".$varThumpImage75);
			} catch (Exception $varError){
				$varErrorMode	= 1;
			}
			
			if (file_exists($varPhotoCrop450."".$varOriImageName) && ($varPhotoWidth > 450 || $varPhotoHeight > 450 ) && $varErrorMode == 0)
				$objPhoto->funResizePhoto($varPhotoCrop450,$varOriImageName,450,450);
			if(file_exists($varPhotoCrop800."".$varOriImageName) && ($varPhotoWidth > 800 || $varPhotoHeight > 600 ) && $varErrorMode == 0) 
				$objPhoto->funResizePhoto($varPhotoCrop800,$varOriImageName,600,800);
			if (file_exists($varPhotoCrop150."".$varThumpImage150) && ($varPhotoWidth > 150 || $varPhotoHeight >150 ) && $varErrorMode == 0)
				$objPhoto->funResizePhoto($varPhotoCrop150,$varThumpImage150,150,150);
			if (file_exists($varPhotoCrop75."".$varThumpImage75) && ($varPhotoWidth > 75 || $varPhotoHeight > 75 ) && $varErrorMode == 0){
				$objPhoto->funResizePhoto($varPhotoCrop75,$varThumpImage75,75,75);
			}
		} else {
			$error_message = file_upload_error_message($_FILES['newphoto']['error']); 
			$varErrorMode	= 1;
			
			$funFileContent	 = "\n".date('h:i:s').'#~#'.$sessMatriId.'#~#'.$error_message;
			$funFileName = "/var/log/dberrorlog/".date('d-m-Y')."_".$_SERVER['SERVER_ADDR']."db_community_photo_error_log.txt";

			$funFileOpen = fopen($funFileName,"a");
			@fwrite($funFileOpen, $funFileContent);
			fclose($funFileOpen);
		}
		
	}else if ($varPhotoWidth <= 75 ||  $varPhotoHeight <= 75){
		$varErrorMode	= 1;
		$varErrorType	= 'imagelength';
	}else {
		$varErrorMode	= 1;
		$varErrorType	= 'imageext';
	}

	if($varErrorMode	== 0) {
		$varThumb75			= 'Normal_Photo'.$varPhotoNo;
		$varThumb150		= 'Thumb_Small_Photo'.$varPhotoNo;
		$varOriginal450		= 'Thumb_Big_Photo'.$varPhotoNo;
		$varOldOriPhoStatus	= 'Photo_Status'.$varPhotoNo;
		$varFields			= array($varThumb75,$varThumb150,$varOriginal450,$varOldOriPhoStatus,'Photo_Date_Updated');
		$varFieldValues		= array("'".$varThumpImage75."'","'".$varThumpImage150."'","'".$varOriImageName."'",$varNewStatus,"NOW()");
		$varCondition		= "  MatriId= ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$varFormResult		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues, $varCondition);
		$varFields			= array('Pending_Photo_Validation','Date_Updated');
		$varFieldValues		= array(1,"NOW()");
		$varUpdate			= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFieldValues, $varCondition, $varOwnProfileMCKey);
		$varFields 			= array('MatriId','Time_Posted','PhotoOrder');
		$varFieldValues		= array($objMasterDB->doEscapeString($sessMatriId,$objMasterDB),"'".date('Y-m-d h:i:s')."'",$varPhotoNo);
		$varFormResult		= $objMasterDB->insert($varTable['PHOTOINFOLOG'], $varFields, $varFieldValues);
	}
} elseif ($varUpPhotoError==1 ){
	$varErrorMode		= 1;
	$varErrorType		= 'imagesize';
	$varPhotoSize		= round($varPhotoSize / 1024);
} elseif ($varUpPhotoError>1){
	$varErrorMode		= 1;
	$varErrorType		= 'imageerror'; 
}
$objMasterDB->dbClose();
$objSlaveDB->dbClose();

if ($varErrorMode == 1){ 
	$varRedirectUrl	= $confValues['SERVERURL']."/photo/index.php?act=photoerror&errortype=".$varErrorType."&imagesize=".$varPhotoSize;
	echo '<script>window.location="'.$varRedirectUrl.'";</script>';
} else if ($varErrorMode == 0) {
?>
<script>
var preview='0', crop_url='';
function onEndCrop( coords, dimensions ) {
	$( 'x1' ).value = coords.x1;
	$( 'y1' ).value = coords.y1;
	$( 'x2' ).value = coords.x2;
	$( 'y2' ).value = coords.y2;
	$( 'width' ).value = dimensions.width;
	$( 'height' ).value = dimensions.height;
}	
// example with a preview of crop results, must have minimumm dimensions	
function funLoadCropTool() {
	document.body.scrollTop	=	0;
	new Cropper.ImgWithPreview( 
			'testImage',
			{ 
				minWidth: 75, 
				minHeight: 75,
				displayOnInit: true,
				onEndCrop: onEndCrop,
				onloadCoords: { x1: 145, y1: 90, x2: 295, y2: 240 },
				previewWrap: 'previewArea'
				
		}
	) 
} 	

function delete_photo(pno){
		http_request = false;
		if (window.XMLHttpRequest) { // Mozilla, Safari,...
			http_request = new XMLHttpRequest();
		} else if (window.ActiveXObject) { // IE
			try {
				http_request = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					http_request = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {}
			}
		}
		if (!http_request) {
			alert('Giving up :( Cannot create an XMLHTTP instance');
			return false;
		}
		url = "<?=$confValues['IMAGEURL'];?>/photo/photodelete.php";
		http_request.onreadystatechange = delPhoto;	
		http_request.open('POST', url, true);
		postvals = "cancel=yes&frmDeleteSubmit=yes&PNO="+pno;
		http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http_request.setRequestHeader("Content-length", postvals.length);
		http_request.setRequestHeader("Connection", "close");
		http_request.send(postvals);
}

function delPhoto(){
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {				
			window.location="<?=$confValues['IMAGEURL']?>/photo/index.php?act=addphoto&rand=<?=rand(1,1000);?>";
		} else 	{
			alert('There was a problem with the request.');
		}
	}
}

function load_crop(sta){
	preview = sta;
	JsLoadCrop();
}

function JsLoadCrop(){
	if(preview=='0'){$('cropbutton').disabled=true;$('cropbutton').value="processing";}
	x1=$('x1').value;
	y1=$('y1').value;
	x2=$('width').value;
	y2=$('height').value;
	imagename=$('imagename').value;
	phnum		=$('phnum').value;
	desc 		=$('DESC1').value;
	url= "<?=$confValues['IMAGEURL'];?>/photo/photoprocessimg.php?x="+x1+"&y="+y1+"&w="+x2+"&h="+y2+"&ph="+imagename+"&ph2=<?=$varThumpImage150;?>"+"&ph3=<?=$varThumpImage75;?>"+"&phnum="+phnum+"&photodesc="+desc;

	if(preview == '1'){ 
	crop_url=url;
	window.open("<?=$confValues['IMAGEURL'];?>/photo/photopreview.php?x="+x1+"&y="+y1+"&w="+x2+"&h="+y2+"&ph="+imagename+"&ph2=<?=$varThumpImage150;?>"+"&ph3=<?=$varThumpImage75;?>", "Photo Preview","location=0,status=0,scrollbars=1,width=400,height=400");
	}else{
	JsMakeRequest(url);
	}
}

function JsMakeRequest(url) {
	http_request = false;
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}

	if (!http_request) {
		alert('Giving up :( Cannot create an XMLHTTP instance');
		return false;
	}
	http_request.onreadystatechange = JsCropContents;	
	http_request.open('GET', url, true);
	http_request.send(null);
}

function JsCropContents() {
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
			window.location="<?=$confValues['IMAGEURL']?>/photo/index.php?act=addphoto&rand=<?=rand(1,1000);?>";
		} else 	{
			alert('There was a problem with the request.');
		}
	}
}

function savePhoto(){
	JsMakeRequest(crop_url);
}

function gotop(){
	$('DESC1').focus();
}
</script>

<center>
	<div class="rpanel fleft">
		<? include_once('../profiledetail/settingsheader.php');?>
		<!-- Content Area -->     
		   <center>
			<div id="main_div" class="smalltxt" style="width:500px;padding-top:15px;padding-bottom:10px;">
				<div class="normtxt bld tlleft lh20">Edit your photo<br><font class="smalltxt notbld">Using this tool, you can crop your photo. When you're done with cropping please save your photo.</font></div><br clear="all">
				<div style="width:456px;" >
					<? 	$rand = rand(0,1000); ?>
					<div id="testWrap" style="float:left;padding:5px 3px;width:450px !important; width:456px;"><img src="<?=$confValues['PHOTOURL']."/crop450/".$varOriImageName."?id=".$rand;?>?" alt="loading" id="testImage" /></div>
					<br clear="all">
					<div style="width:456px;padding:10px 0px;">
						<div class="tlleft fleft padt10 smalltxt">Add a caption for your photo</div>
						<div class="fleft" style="padding-left:10px;"><textarea name='DESC1' id='DESC1' class="inputtext" style="width:220px;height:45px;"></textarea><br><font class="opttxt tlleft">Example: photo taken at office.</font>
						</div>
						<div style="margin:0px 0px 8px 8px;width:90px;height:75px;border:1px solid #D3D3D3;" class="fleft" id="previewArea"></div>
					</div>
					<div class="fright padtb10">
							<!-- <input id="cropbutton_preview" type="submit" value="Preview" class="button" onclick="load_crop('1');"> -->
							<input id="cropbutton" type="submit" value="Save Photo" class="button" onclick="load_crop('0');"> <!-- <input id="cropbutton_del" type="button" value="Cancel" class="button" onclick="delete_photo('<?=$varPhotoNo;?>');"> -->
					</div>
				</div>
			</div>
			<div style="padding-left:20px;" id="result"></div>

			<div style="padding-left:20px;"></div>
			<form name="test">
			<input type="hidden" id="imagename" value="<?=$varOriImageName?>">			
			<input type="hidden" name="x1" id="x1" />	
			<input type="hidden" name="y1" id="y1" />
			<input type="hidden" name="x2" id="x2" />
			<input type="hidden" name="y2" id="y2" />
			<input type="hidden" name="width" id="width" />
			<input type="hidden" name="height" id="height" />
			<input type="hidden" name="phnum" id="phnum" value="<?=$varPhotoNo?>">			
			</form>
		</center>
	</div>
<br clear="all" />
</center>
<?
}
?>