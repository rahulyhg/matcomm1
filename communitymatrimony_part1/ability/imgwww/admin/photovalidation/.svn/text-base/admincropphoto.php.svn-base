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
$sessMatriId		=	$_REQUEST['id'];

//Object initialization
$objSlaveDB			= new Photo;

//CONNECTION DECLARATION
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$varPhotoNo			= $_REQUEST['num'];
$varFields			= array('Normal_Photo'.$varPhotoNo,'Thumb_Small_Photo'.$varPhotoNo,'Thumb_Big_Photo'.$varPhotoNo);
$varCondition		= "WHERE MatriId = '".$sessMatriId."'";
$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
$arrSelectPhotoInfo = mysql_fetch_assoc($varResult);
$varImageName		= $arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo];
$varImage75			= $arrSelectPhotoInfo['Normal_Photo'.$varPhotoNo];
$varImage150		= $arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo];

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($sessMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

$varPhotoCrop800	= $varRootBasePath.'/www/membersphoto/'.$varFolderName.'/crop800/';
if(file_exists($varPhotoCrop800.$varImageName)){
	$varEditPhotoPath = $confValues['IMAGEURL'].'/membersphoto/'.$varFolderName.'/crop800/'.$varImageName;
} else {
	$varEditPhotoPath = $confValues['IMAGEURL'].'/membersphoto/'.$varFolderName.'/crop450/'.$varImageName;
}
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
		<script language="javascript" src="<?=$confValues['JSPATH'];?>/prototype.js"></script>
		<script language="javascript" src="<?=$confValues['JSPATH'];?>/scriptaculous.js?load=builder,dragdrop"></script>
		<script language="javascript" src="<?=$confValues['JSPATH'];?>/cropper.js"></script>	
	<script type="text/javascript" charset="utf-8">
		function onEndCrop( coords, dimensions ) {
			$( 'x1' ).value = coords.x1;
			$( 'y1' ).value = coords.y1;
			$( 'x2' ).value = coords.x2;
			$( 'y2' ).value = coords.y2;
			$( 'width' ).value = dimensions.width;
			$( 'height' ).value = dimensions.height;
		}
		
		// example with a preview of crop results, must have minimumm dimensions
		function loadcroptool() {
				new Cropper.ImgWithPreview( 
					'testImage',
					{ 
						minWidth: 75, 
						minHeight: 75,
						ratioDim: { x: 150, y: 150 },
						displayOnInit: true, 
						onEndCrop: onEndCrop,
						previewWrap: 'previewArea'
					}
				) 
			} 	
	function clearcroptool(){
			document.getElementById('testWrap').innerHTML = '<img src="<?=$varEditPhotoPath;?>" alt="test image" id="testImage"/>';
	}
	function load_crop(){
		document.getElementById('cropbutton').disabled=true;
		document.getElementById('cropbutton').value = 'Processing'; 
		x1=document.getElementById('x1').value;
		y1=document.getElementById('y1').value;
		
		x2=document.getElementById('width').value;
		y2=document.getElementById('height').value;
		imagename=document.getElementById('imagename').value;
		url= "photoprocessimg.php?id=<?=$sessMatriId;?>&x="+x1+"&y="+y1+"&w="+x2+"&h="+y2+"&ph="+imagename+"&ph2=<?=$varImage150;?>"+"&ph3=<?=$varImage75;?>";
		makeRequest1(url);
	}
	
	function makeRequest1(url) {
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
        http_request.onreadystatechange = alertContents_crop;		 
        http_request.open('GET', url, true);
        http_request.send(null);
    }

	function alertContents_crop() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) 
			{
				document.getElementById('result').innerHTML= "<br> photo 75*75 cropped successfully. <br>photo 150*150 cropped successfully.<br><br clear='all'><a href='<?=$_SERVER['HTTP_REFERER']?>' class=clr1>Back</a>";
				document.getElementById('cropbutton').value = 'Crop & Save Again'; 
				document.getElementById('cropbutton').disabled = false;
			} else {
                alert('There was a problem with the request.');
            }
        }else{
			document.getElementById('result').innerHTML= "<img src='<?=$confValues['IMGSURL']?>/small-loading.gif'>";
		}

    }

</script>
 </head>
 <body align="center" onload="loadcroptool();">
 <?include_once("adminheader.php"); ?>
 <div id="main_div" style="width:700px;padding-left:60px;padding-top:5px;padding-bottom:10px;">
	<div class="smalltxt">
		<font class="mediumtxt1 boldtxt">Crop photo</font><br><br>Crop the photo using crop tool, when you are happy with cropped photo, click the "Save Photo" button.<br><br>
	</div>
	<br clear="all">
	<div style="float:left;padding-left:195px;">
		<div id="sectab_content_2" style="float:left;width:349px;">		
			<div style="float:left; width:15px;"><img src="<?=$confValues['IMGSURL'];?>/ph-submenu-leftcurve.gif" width="15" height="46" border="0" alt=""></div>
			<div style="float:left; width:150px; height:46px; background-image:url('<?=$confValues['IMGSURL'];?>/ph-submenu-bg.gif');">
				<div style="float:left; padding-top:5px;">
					<div style="float:left;" class="smalltxt clr5" ></div>
					<div style="float:left;">
						<input id="cropbutton" type="submit" value="Crop & Save Photo" class="button pntr" onclick="load_crop();">
					</div>
				</div>
			</div>
			<div style="float:left; width:15px;"><img src="<?=$confValues['IMGSURL'];?>/ph-submenu-rightcurve.gif" width="15" height="46" border="0" alt=""></div>
		</div>
	</div>  
	<div>
		<br clear="all">
		<div style="padding-left:240px;padding-top:20px;">
			<div id="previewArea" style="display:block;float:left;" class="fleft"></div>
		</div>
		<form name="test">
				<input type="hidden" id="imagename" value="<?=$varImageName?>">			
				<input type="hidden" name="x1" id="x1" />	
				<input type="hidden" name="y1" id="y1" />
				<input type="hidden" name="x2" id="x2" />
				<input type="hidden" name="y2" id="y2" />
				<input type="hidden" name="width" id="width" />
				<input type="hidden" name="height" id="height" />
				<input type="hidden" name="phnum" id="phnum" value="<?=$varPhotoNo?>">
		</form>
	</div> <br clear="all">
	<div style="padding-left:20px;padding-top:2px" id="result"></div><br>
	<div style="padding-left:60px;">
			<div id="testWrap" style="padding:20px;padding-right:20px;float:left;border:solid 4px #F0AF8F">
				<img src="<?=$varEditPhotoPath;?>" alt="test image" id="testImage" />
			</div>
	</div>
</div>
</body>
</html>