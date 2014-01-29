<?php
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/www/admin1/includes/userLoginCheck.php"); // Added for authentication
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/lib/clsPhoto.php");

//SESSION VARIABLES
$sessMatriId	= $_REQUEST['id'];
$varDivNum		= $_REQUEST['divno'];

//Object initialization
$objSlaveDB		= new Photo;

//CONNECTION DECLARATION
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

$varPhotoNo			= $_REQUEST['num'];
$varFields			= array('Normal_Photo'.$varPhotoNo,'Thumb_Small_Photo'.$varPhotoNo,'Thumb_Big_Photo'.$varPhotoNo);
$varCondition		= "WHERE MatriId = ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
$arrSelectPhotoInfo = mysql_fetch_assoc($varResult);
$varImageName		= $arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo];
$varImage75			= $arrSelectPhotoInfo['Normal_Photo'.$varPhotoNo];
$varImage150		= $arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo];

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($sessMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

$varBrightBkpPath	=	$varRootBasePath."/www/brightness_backup/";
$varCrop450Path		=	$varRootBasePath."/www/membersphoto/".$varFolderName.'/crop450/';
$varRotateTmpPath	=	$varRootBasePath."/www/membersphoto/tmp/";

if(!file_exists($varBrightBkpPath.$varImageName)) {	
	copy($varCrop450Path.$varImageName,$varBrightBkpPath.$varImageName);
} 

if(file_exists($varRotateTmpPath.$varImageName)) {	
	unlink($varRotateTmpPath.$varImageName);
}

$varEditPhotoPath = $confValues['IMAGEURL'].'/brightness_backup/'.$varImageName;
$varEditRotatePath = $confValues['IMAGEURL'].'/membersphoto/tmp/'.$varImageName;
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
		$('cropbutton').disabled=true;
		$('cropbutton').value = 'Processing'; 
	} 	
	function clearcroptool(){
			$('testWrap').innerHTML = '<img src="<?=$varEditPhotoPath;?>" alt="test image" id="testImage"/>';
	}

	function saveandclose(){
		var imagename=$('imagename').value;
		var matid=$('matid').value;
		var uid=$('uid').value;
		var phnum=$('phnum').value;
		x1=$('x1').value;
		y1=$('y1').value;
		w=$('width').value;
		h=$('height').value;
		url= "support_brightness_process.php?imagename="+imagename+"&save=1&matid="+matid+"&uid="+uid+"&phnum="+phnum+"&x="+x1+"&y="+y1+"&w="+w+"&h="+h;
		makeSaveRequest(url);
	}

	function makeSaveRequest(url) {
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
        http_request.onreadystatechange = getResult;		 
        http_request.open('GET', url, true);
        http_request.send(null);
    }

	function getResult(){
        if (http_request.readyState == 4) {
            if (http_request.status == 200) 
			{
				window.opener.loadimagesrc('<?=$varDivNum;?>');
				window.close();
			} else {
                alert('There was a problem with the request.');
            }
        }
    }

	function refreshpage() {
	    
		var imagename=$('imagename').value;
		var matid=$('matid').value;
		var uid=$('uid').value;
		var phnum=$('phnum').value;

	    $('refreshbtn').disabled=true;
	    $('refreshbtn').value="processing";			

		url= "support_brightness_process.php?imagename="+imagename+"&reload=1&matid="+matid+"&uid="+uid+"&phnum="+phnum+'&divno=<?=$varDivNum?>';     
		window.location.href=url;		
	}

	function load_bright(button){
		var imagename=$('imagename').value;
		var matid=$('matid').value;
		var uid=$('uid').value;
		var phnum=$('phnum').value;

		if(button =='brightAdd') {
		  $('brightAdd').disabled=true;
		  $('brightAdd').value="processing";		
		  urlloc= "support_brightness_process.php?action=add&imagename="+imagename+"&reload=0&matid="+matid+"&uid="+uid+"&phnum="+phnum+"&property=brightadd";
		} else if(button =='contrastAdd') {
		  $('contrastAdd').disabled=true;
		  $('contrastAdd').value="processing";		
		  urlloc= "support_brightness_process.php?action=add&imagename="+imagename+"&reload=0&matid="+matid+"&uid="+uid+"&phnum="+phnum+"&property=contrastadd";
		} else if(button =='contrastSub') {
		  $('contrastSub').disabled=true;
		  $('contrastSub').value="processing";		
		  urlloc= "support_brightness_process.php?action=sub&imagename="+imagename+"&reload=0&matid="+matid+"&uid="+uid+"&phnum="+phnum+"&property=contrastsub";
		} else {
			$('brightSub').disabled=true;
			$('brightSub').value="processing";		
			urlloc= "support_brightness_process.php?action=sub&imagename="+imagename+"&reload=0&matid="+matid+"&uid="+uid+"&phnum="+phnum+"&property=brightsub";
		}

		window.location.href=urlloc+'&divno=<?=$varDivNum?>';
	}

	//ROTATE
	function saverotimage(imagename){
		url="rotate_image_ajax.php?imagename="+imagename+"&act=save&randNo="+Math.random(1000);			
		makeRequest_rotate(url,'finalrotresult');
	}
	
	function rotateimage(imagename,degree){
		url="rotate_image_ajax.php?imagename="+imagename+"&act=tmp&degree="+degree+"&randNo="+Math.random(1000);			
		makeRequest_rotate(url,'tmprotresult');
	}

    function makeRequest_rotate(url,funName){
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
		http_request.open("GET", url, true);
		http_request.onreadystatechange = eval(funName);
		http_request.send(null);
	}

	function finalrotresult() {			
		if (http_request.readyState == 4) {
			if (http_request.status == 200) {
				imgurl= document.images['testImage'].src; 
				document.images['testImage'].src = imgurl+'?rand='+Math.random();
				$('rotate_div').style.display = 'none';
			}else{ alert('There was a problem with the request.'); }
		}
	} 

	function tmprotresult() {
		imgurl= '<?=$varEditRotatePath?>'; 
		document.images['img_div'].src = imgurl+'?rand='+Math.random();
	}

	function load_rotate() {
		$('rotate_div').style.display = "block";
		imgurl= '<?=$varEditPhotoPath?>'; 
		document.images['img_div'].src = imgurl+'?rand='+Math.random();
	}

	function load_autofix() {
		$('autofixbtn').disabled=true;
	    $('autofixbtn').value="processing";			
		url= "photoautofix.php?imagename=<?=$varImageName?>";
		makeAutofixRequest(url);
	}

	function makeAutofixRequest(url) {
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
        http_request.onreadystatechange = getAutoResult;		 
        http_request.open('GET', url, true);
        http_request.send(null);
    }

	function getAutoResult(){
		if (http_request.readyState == 4) {
			if (http_request.status == 200) {
				$('autofixbtn').value="Auto Fix";	
				$('autofixbtn').disabled=false;
				imgurl= document.images['testImage'].src; 
				document.images['testImage'].src = imgurl+'?rand='+Math.random();
			}
		}
	}

	function loadimages(){
		imgurl= document.images['testImage'].src; 
		document.images['testImage'].src = imgurl+'?rand='+Math.random();
		imgurl= document.images['img_div'].src; 
		document.images['img_div'].src = imgurl+'?rand='+Math.random();
	}

</script>
 </head>
 <body align="center">
 <?include_once("adminheader.php"); ?>
 <div style="padding-left:20px;">
	 <input id="refreshbtn" type="button" value="Restore Original Image" class="button pntr" onclick="refreshpage();">
	 <input id="refreshbtn" type="button" value="Download Photo" class="button pntr" onclick="window.open('<?=$varEditPhotoPath;?>');"><br/><br/>
	 <input type="hidden" name="greycflag" id="greycflag" value="">
	 <input id="brightAdd" type="button" value="   Bright ++   " class="button pntr" onclick="load_bright(this.id);">&nbsp;&nbsp;
	 <input id="brightSub" type="button" value="   Bright --   " class="button pntr" onclick="load_bright(this.id);">&nbsp;&nbsp;<br/><br/>
	 <input id="contrastAdd" type="button" value="Contrast ++" class="button pntr" onclick="load_bright(this.id);">&nbsp;&nbsp;
	 <input id="contrastSub" type="button" value="Contrast --" class="button pntr" onclick="load_bright(this.id);">&nbsp;&nbsp;<br/><br/>
	 <input id="rotatePhoto" type="button" value="Rotate Photo" class="button pntr" onclick="load_rotate();">&nbsp;&nbsp;
	 <input id="autofixbtn" type="button" value="Auto Fix" class="button pntr" onclick="load_autofix();">&nbsp;&nbsp;<br/><br/>
     <input id="cropbutton" type="button" value="Crop 75" class="button pntr" onclick="loadcroptool();">&nbsp;&nbsp;
	 <input id="closebutton" type="button" value="Save & Close" class="button pntr" onclick="saveandclose();">&nbsp;&nbsp;

     
</div>
 <div id="main_div" style="width:475px;padding-top:15px;padding-bottom:10px;float:left">
	<div>
		<div style="padding-left:90px;">
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
				<input type="hidden" name="matid" id="matid" value="<?=$sessMatriId?>">
				<input type="hidden" name="uid" id="uid" value="<?=$userid?>">
		</form>
	</div> <br clear="all">
	<div style="padding-left:20px;padding-top:2px" id="result"></div><br>
	<div style="padding-left:10px;">
		<div id="testWrap" style="padding:10px;float:left;border:solid 4px #F0AF8F">
			<img src="<?=$varEditPhotoPath;?>" alt="test image" id="testImage" />
		</div>
	</div>
</div>
<div id="rotate_div" style="width:475px;padding-top:5px;padding-bottom:10px;float:right;display:none;">
	<div style="padding-top:2px;">Rotate Image:	
	<input id="rotate" type="submit" value="0" class="button pntr" onclick="rotateimage('<?=$varImageName;?>','0');">
	<input id="rotate" type="submit" value="90" class="button pntr" onclick="rotateimage('<?=$varImageName;?>','90');">		
	<input id="rotate" type="submit" value="180" class="button pntr" onclick="rotateimage('<?=$varImageName;?>','180');">
	<input id="rotate" type="submit" value="-90" class="button pntr" onclick="rotateimage('<?=$varImageName;?>','-90');">
	<input id="saveImage" type="submit" value="Save Image" class="button pntr" onclick="saverotimage('<?=$varImageName;?>')">
	</div>
	<br clear="all"><br clear="all">
	<div id="tmpwrap" style="padding-left:20px;padding-right:20px;float:left;">
	<img id="img_div" src="<?=$varEditPhotoPath?>" />
	</div>
</div>
<script>loadimages();</script>
</body>
</html>