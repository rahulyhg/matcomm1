<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		: photoadd.php
#================================================================================================================
   # Description	: PhotoManagement - View Photo
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath."/lib/clsPhoto.php");

//SESSION VARIABLES
$sessMatriId			= trim(strtoupper($_REQUEST['matriid']));
//Object initialization
$objSlaveDB			= new Photo;
$objMasterDB		= new Photo;

//CONNECTION DECLARATION
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$varMasterConn		= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($sessMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

//img server path 
$varDomainName		= $arrPrefixDomainList[$varPrefix];
$varIMGServer		= 'http://img.'.$varDomainName;
$varPhotoURL		= $varIMGServer.'/membersphoto/'.$varFolderName;

//VARIABLE DECLARATION
$varDomainPHPath	= $varRootBasePath.'/www/membersphoto/'.$varFolderName;
$varPhotoBupPath	= $varDomainPHPath."/backup/";
$varPhotoCrop800	= $varDomainPHPath."/crop800/";
$varPhotoCrop450	= $varDomainPHPath."/crop450/";
$varPhotoCrop150	= $varDomainPHPath."/crop150/";
$varPhotoCrop75		= $varDomainPHPath."/crop75/";
$varErrorMode		= 0;
$varUpdate 			= ''; 
$varErrorType		= ''; 
$varUpPhotoError	= 0;
$varTmpPhoto		= $_FILES['newphoto'];
$varPhotoPath		= $_FILES['newphoto']['tmp_name'];
$varPhotoName		= $_FILES['newphoto']['name'];
$varPhotoSize		= $_FILES['newphoto']['size'];
$varUpPhotoError 	= (int)$_FILES['newphoto']['error'];
if (($_POST['frmAddPhotoSubmit'] == 'yes')  && ($varPhotoSize < $confValues['PHOTOMAXSIZE'] ) && ($varUpPhotoError == 0) && $sessMatriId != '') {
	
	$varNum			= substr_count($varPhotoName,'.'); 
	$arrPhotoSplit	= explode(".",$varPhotoName);
	$varPhotoExt	= strtolower($arrPhotoSplit[$varNum]);
	$varPhotoNo		= $_REQUEST['photono'];
	//print "<br> Photo NUMBER".$varPhotoNo;
	$varCondition	= " WHERE  MatriId= '".$sessMatriId."'";
	$varTotRecords	= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], $argPrimary='MatriId', $varCondition);
	
	if($varTotRecords == 0 )	{
		$varFields 		= array('MatriId');
		$varFieldValues	= array("'".$sessMatriId."'");
		$varFormResult	= $objMasterDB->insert($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldValues);
		$varPhotoNo		= 1;
	}
	
	$varAction			= $_REQUEST["action"];
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
				$i = 11;
			}
		}
		$varSelectName		= $objSlaveDB->createPhotoName($sessMatriId);
		$varOriImageName	= $varSelectName."_TB_".$varPhotoNo.".".$varPhotoExt;
		$varThumpImage75	= $varSelectName."_NL_".$varPhotoNo.".".$varPhotoExt;
		$varThumpImage150	= $varSelectName."_TS_".$varPhotoNo.".".$varPhotoExt;
	} elseif ($varAction == "change" ) {
		$varOriImageName	= $arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo];
		$varThumpImage75	= $arrSelectPhotoInfo['Normal_Photo'.$varPhotoNo];
		$varThumpImage150	= $arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo];
		if ($arrSelectPhotoInfo['Photo_Status'.$varPhotoNo] == 1  || $arrSelectPhotoInfo['Photo_Status'.$varPhotoNo] == 2) {
			$varNewStatus		= 2;
		} else
			$varNewStatus		= 0;
	}
	//print "<br> Photo NUMBER".$varPhotoNo;
	$varPhotoFormat		= array('jpeg','jpg','gif','png');
	$varPhotoId			= $varOriImageName."?id=".$varRandnNumber;
	list($varPhotoWidth,$varPhotoHeight)	=	getimagesize($varPhotoPath);
	if (in_array($varPhotoExt,$varPhotoFormat) &&  $varPhotoWidth >= 75 &&  $varPhotoHeight >= 75) {
		if (file_exists($varPhotoBupPath."".$varOriImageName))
			unlink($varPhotoBupPath."".$varOriImageName);
		$varMoveFiles	=	move_uploaded_file($varPhotoPath,$varPhotoBupPath.$varOriImageName);
		if ( $varPhotoWidth > 800 || $varPhotoHeight > 600 ) {
			try { 
				 copy ($varPhotoBupPath.$varOriImageName,$varPhotoCrop800.$varOriImageName);
			} catch (Exception $varError){
				$varErrorMode	= 1;
			}
		}
		try { 
			 copy ($varPhotoBupPath.$varOriImageName,$varPhotoCrop450.$varOriImageName);
		} catch (Exception $varError){
			$varErrorMode	= 1;
		}
		try { 
			 copy ($varPhotoBupPath.$varOriImageName,$varPhotoCrop150."".$varThumpImage150);
		} catch (Exception $varError){
			$varErrorMode	= 1;
		}
		try { 
			 copy ($varPhotoBupPath.$varOriImageName,$varPhotoCrop75."".$varThumpImage75);
		} catch (Exception $varError){
			$varErrorMode	= 1;
		}
			
		if(file_exists($varPhotoCrop800.$varOriImageName) && ($varPhotoWidth > 800 || $varPhotoHeight > 600 ) && $varErrorMode == 0) {
			$objSlaveDB->funResizePhoto($varPhotoCrop800,$varOriImageName,600,800);
		}
		if(file_exists($varPhotoCrop450.$varOriImageName) && ($varPhotoWidth >= 450 || $varPhotoHeight >= 450 ) && $varErrorMode == 0){
			$objSlaveDB->funResizePhoto($varPhotoCrop450,$varOriImageName,450,450);
		}
		if (file_exists($varPhotoCrop150.$varThumpImage150) && ($varPhotoWidth > 150 || $varPhotoHeight >150 ) && $varErrorMode == 0)
			$objSlaveDB->funResizePhoto($varPhotoCrop150,$varThumpImage150,150,150);
		if (file_exists($varPhotoCrop75.$varThumpImage75) && ($varPhotoWidth > 75 || $varPhotoHeight > 75 ) && $varErrorMode == 0){
			$objSlaveDB->funResizePhoto($varPhotoCrop75,$varThumpImage75,75,75);
		}
		$varErrorMode	= 0;
	}else if ($varPhotoWidth <= 75 ||  $varPhotoHeight <= 75){
		$varErrorMode	= 1;
		$varErrorType	= 'imagelength';
	}else {
		$varErrorMode	= 1;
		$varErrorType	= 'imageext';
	}

} elseif ($confValues['PHOTOMAXSIZE'] < $varPhotoSize ){
	$varErrorMode		= 1;
	$varErrorType		= 'imagesize';
	$varPhotoSize		= round($varPhotoSize / 1024);
	//print "<BR> ERROR MSG".$varErrorMsg; 
} elseif ($varUpPhotoError == 1){
	$varErrorMode		= 1;
	$varErrorType		= 'imageerror'; 
}
$objMasterDB->dbClose();
$objSlaveDB->dbClose();
if ($varErrorMode == 1){ 
	$varRedirectUrl	= "adminphotoerror.php?errortype=".$varErrorType."&imagesize=".$varPhotoSize."&MATRIID=".$sessMatriId;
	echo '<script>window.location="'.$varRedirectUrl.'";</script>';
} else if ($varErrorMode == 0) {
?>
<!DOCTYPE HTML PUBLIC "//W3C//DTD HTML 4.0 Transitional//EN" >
<html>
<head>
	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
		<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
		<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/cropper.css">
		<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/ImageEditor.css">
		<script	language=javascript src="<?=$confValues['JSPATH'];?>/ajax.js" ></script>
		<script language="javascript" src="<?=$confValues['JSPATH'];?>/adminphotoadd.js"></script>
		<script language="javascript" src="<?=$confValues['JSPATH'];?>/cropfunction.js"></script>
		<script language="javascript" src="<?=$confValues['JSPATH'];?>/prototype.js"></script>
		<script language="javascript" src="<?=$confValues['JSPATH'];?>/scriptaculous.js?load=builder,dragdrop"></script>
		<script language="javascript" src="<?=$confValues['JSPATH'];?>/cropper.js"></script>
		<script type="text/javascript" >
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
							//ratioDim: { x: 150, y: 150 },
							displayOnInit: true,
							//displayOnInit: true, 
							onEndCrop: onEndCrop,
							onloadCoords: { x1: 145, y1: 90, x2: 295, y2: 240 },
							previewWrap: 'previewArea'
							
						}
					) 
			} 	
			
			function funClearCropTool(){
					var randomnumber=Math.floor(Math.random()*101)
					document.getElementById('testWrap').innerHTML = '<img src=<?=$varPhotoURL;?>/crop450/<?=$varPhotoId?> alt="test image" id="testImage" />';
			}
			
			function JsLoadCrop(){
				//alert("JsLoadCrop");
				document.getElementById('cropbutton').disabled=true;
				document.getElementById('cropbutton').value="processing";
				x1=document.getElementById('x1').value;
				y1=document.getElementById('y1').value;
				
				x2=document.getElementById('width').value;
				y2=document.getElementById('height').value;
				imagename=document.getElementById('imagename').value;
				bigimage = "<?=$varOriginalImgMode?>";
				url= "managephotoprocess.php?action=crop&x="+x1+"&y="+y1+"&w="+x2+"&h="+y2+"&imageName="+imagename+"&ID=<?=$sessMatriId;?>&photo75=<?=$varThumpImage75;?>&photo150=<?=$varThumpImage150;?>&photo450=<?=$varOriImageName;?>";
				//alert(url);
				JsMakeRequest(url);
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
				//alert("JsCropContents"+JsCropContents);	 
				http_request.open('GET', url, true);
				http_request.send(null);
			}
			function JsCropContents() {
				if (http_request.readyState == 4) {
					if (http_request.status == 200) {				
						//alert(http_request.responseText);
						JsLoadManage();
						document.getElementById('cropbutton').value="Crop";
					} else 	{
						alert('There was a problem with the request.');
					}
				}
			}
			function JsLoadManage(){		
				//document.getElementById('savbutton').disabled=true;
				//document.getElementById('savbutton').value="processing";
				imagename	=document.getElementById('imagename').value;
				phnum		=document.getElementById('phnum').value;
				desc 		=document.getElementById('DESC1').value;
				action 		="<?=$_REQUEST['action'];?>";
				url			="<?=$confValues['IMAGEURL']?>/admin/photovalidation/managephotoaddcrop.php?ID=<?=$sessMatriId;?>&photo75=<?=$varThumpImage75;?>&photo150=<?=$varThumpImage150;?>&photo450=<?=$varOriImageName;?>&phnum="+phnum+"&action="+action+"&photodesc="+desc;
				//alert("addcropphoto:     "+url);
				JsAddPhotoCropRequest(url);
			}
			 function JsAddPhotoCropRequest(url) {
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
				http_request.onreadystatechange = JsPhotoCongrats;	
				//alert("	 JsPhotoCongrats"+JsPhotoCongrats);
				http_request.open('GET', url, true);
			   //alert(' JSCROP'+http_request.responseText);
				http_request.send(null);
			}
			function JsPhotoCongrats() {
				if (http_request.readyState == 4) {
					if (http_request.status == 200) {
						//alert(' JSCROP'+http_request.responseText);
						window.location="<?=$confValues['IMAGEURL']?>/admin/photovalidation/photocongrats.php?ID=<?=$sessMatriId;?>&rand=<?=rand(1,1000)#top;?>";
					}else 
						alert('There was a problem with the request.');
				}
			}
		function gotop(){
			document.getElementById('htxt').focus();
			document.getElementById('txtdiv').style.display="none";
		}
	</script>
	</head>
	<body align="center" onload="funLoadCropTool();gotop()">
	<?include_once("adminheader.php"); ?>
	<div id="main_div" style="width:550px;padding-left:40px;padding-top:5px;padding-bottom:10px;">
		<div class="mediumtxt boldtxt clr3">Add Photo</div><br clear="all">
	<!--  to laod the contents from manage photopage after adding the photos   -->
		<div id="txtdiv"><input type=hidden name="htxt" id="htxt" value=""></div>
		<div style="width:451px;">

			<div style="float:left;" class="grn-top-lft"><!----></div>
			<div style="float:left;" class="grn-top-tile fleft"><!----></div>
			<div style="float:left;" class="grn-top-right fleft"><!----></div>
			<div style="clear:both;"></div>

	<center>

			<div style="width:450px;" class="rowcolor">

				<div style="margin:5px 0px 8px 8px;float:left;width:90px;height:75px;border:1px solid #D3D3D3;"  id="previewArea"></div>
				<div style="margin:8px 0px 8px 15px;float:left;width:210px;height:75px;">
					<div style="padding:0px 0px 0px 0px;width:210px;text-align:left" class="fleft">
					<font class="smalltxt boldtxt">Add a caption for your photo</font><br>
			<TEXTAREA name='DESC1' id='DESC1' ROWS="2" COLS="20" class="inputtext" style="width:200px;"></TEXTAREA><br>
			<font class="smalltxt1 clr2">Example: photo taken at office.</font></div><br clear="all">
				</div>
				<div style="float:left;margin:8px 0px 8px 5px;width:90px;height:75px;">
					<div style="padding:25px 0px 28px 0px;width:100px;border:2px solid #FFFFFF;" align="center">
					<input id="cropbutton" type="button" value="Save Photo" class="button" onclick="javascript:JsLoadCrop();"></div>
				</div><br clear="all">
			</div>
	</center>
	<? 	$rand = rand(0,1000); ?>
			<div id="testWrap" style="float:left;width:450px;border:solid 4px #A54284"><img src="<?=$varPhotoURL."/crop450/".$varOriImageName."?id=".$rand;?>" alt="test image" id="testImage"   /></div>
			<div style="clear:both;"></div>
			<div style="float:left;" class="grn-bot-lft"><!----></div>
			<div style="float:left;" class="grn-bot-tile fleft"><!----></div>
			<div style="float:left;" class="grn-bot-right fleft"><!----></div>
			<div style="clear:both;"></div>
		</div>
		<div style="padding-left:20px;" id="result"> </div>
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
	</div> 
</div>
</body>
</html>
<?
}
?>