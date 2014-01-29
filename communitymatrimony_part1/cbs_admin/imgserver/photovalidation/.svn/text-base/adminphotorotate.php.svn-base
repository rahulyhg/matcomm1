<?php
#================================================================================================================
   # Author 		: Baranidharan
   # Date			: 16-June-2010
   # Project		: MatrimonyProduct
   # Filename		: adminphotorotate.php
#================================================================================================================
   # Description	: PhotoManagement - To rotate and rank the member's photo
#================================================================================================================

//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/www/admin1/includes/userLoginCheck.php"); // Added for authentication
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION VARIABLES
$varMatriId		=	$_REQUEST['id'];
$varPhotoNo			= $_REQUEST['num'];

//Object initialization
$objSlaveDB			= new DB;
//$objMasterDB        = new DB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
//$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

// Update photo rank info in memberinfo table //
/*if($_REQUEST['frmPhotoRank'] == "submit") {
  $varFields = array('Photo_Rank');
  $varFieldsValues = array($_REQUEST['photoRank']);
  $varCondition		= " MatriId = '".$varMatriId."'";
  $varUpdateId		= $objMasterDB->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);
}
//

// Update photo Quality info in memberinfo table //
if($_REQUEST['frmPhotoRank'] == "submit") {
  $varFields = array('Photo_Quality'.$varPhotoNo);
  $varFieldsValues = array($_REQUEST['photoQuality']);
  $varCondition		= " MatriId = '".$varMatriId."'";
  $varUpdateId		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'],$varFields,$varFieldsValues,$varCondition);
}
//

// select photo rank info from memberinfo table //
$varFields			= array('Photo_Rank');
$varCondition		= "WHERE MatriId = '".$varMatriId."'";
$varResult			= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
$arrSelectPhotoRank = mysql_fetch_assoc($varResult);
$varPhotoRank =  $arrSelectPhotoRank['Photo_Rank'];
*/
//


$varFields			= array('Normal_Photo'.$varPhotoNo,'Thumb_Small_Photo'.$varPhotoNo,'Thumb_Big_Photo'.$varPhotoNo,'Photo_Quality'.$varPhotoNo);
$varCondition		= "WHERE MatriId = ".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
$arrSelectPhotoInfo = mysql_fetch_assoc($varResult);
$varImageName		= $arrSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo];
$varImage75			= $arrSelectPhotoInfo['Normal_Photo'.$varPhotoNo];
$varImage150		= $arrSelectPhotoInfo['Thumb_Small_Photo'.$varPhotoNo];
$varPhotoQuality = $arrSelectPhotoInfo['Photo_Quality'.$varPhotoNo];

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($varMatriId,0,3);
$varDomainFolder		= $arrFolderNames[$varPrefix];

$varPhotoCrop800	= $varRootBasePath.'/www/membersphoto/'.$varFolderName.'/crop800/';
if(file_exists($varPhotoCrop800.$varImageName)){
	$varEditPhotoPath = $confValues['IMAGEURL'].'/membersphoto/'.$varDomainFolder.'/crop800/'.$varImageName;
	$varImageFolder = '/crop800/';
} else {
	$varEditPhotoPath = $confValues['IMAGEURL'].'/membersphoto/'.$varDomainFolder.'/crop450/'.$varImageName;
	$varImageFolder = '/crop450/';
}
//$varEditPhotoPath = $confValues['IMAGEURL'].'/membersphoto/'.$varFolderName.'/crop450/'.$varImageName;*/
?>
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
		<script	language=javascript src="<?=$confValues['JSPATH'];?>/ajax.js" ></script>	
	<script type="text/javascript" charset="utf-8">

   function rotateimage(domainfolder,imagefolder,imagename,degree,rotateact) {	document.getElementById('refresh').style.visibility="hidden";
   document.getElementById('successMsg').style.visibility="hidden";
   url="rotate_image_ajax.php?domainfolder="+domainfolder+"&imagefolder="+imagefolder+"&imagename="+imagename+"&degree="+degree+"&act="+rotateact+"&checkSubmit="+document.getElementById('checkSubmit').value+"&randNo="+Math.random(1000);			
		makeRequest_rotate(url,rotateact,degree);
   }
   function makeRequest_rotate(url,rotateact,degree) {
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
		http_request.onreadystatechange = function() {			
			if (http_request.readyState == 4) {
				if (http_request.status == 200) {
					if(http_request.responseText == 'saved') {
					 document.getElementById('refresh').style.visibility="visible";
		             document.getElementById('successMsg').style.visibility="visible";
					 document.getElementById('frameId').src ='';
					}
					else {
					document.getElementById('frameId').src = http_request.responseText;
					}
					if(rotateact == 'tmp') {
					document.getElementById('checkSubmit').value = 1;
                    }
				} else 
				{
					alert('There was a problem with the request.');
				}
			}
		}; 
		http_request.send(null);
  }
</script>
 </head>
 <body align="center">
 <?include_once("adminheader.php"); ?>

<div class="fleft" id="rotatediv" style="padding-top:20px;">
<div style="float:left;padding-left:40px;padding-top:2px;">Rotate Image:	
<input id="rotate" type="submit" value="0" class="button pntr" onclick="rotateimage('<?=$varDomainFolder?>','<?=$varImageFolder?>','<?=$varImageName?>','0','tmp');">
<input id="rotate" type="submit" value="90" class="button pntr" onclick="rotateimage('<?=$varDomainFolder?>','<?=$varImageFolder?>','<?=$varImageName?>','90','tmp');">		
<input id="rotate" type="submit" value="180" class="button pntr" onclick="rotateimage('<?=$varDomainFolder?>','<?=$varImageFolder?>','<?=$varImageName?>','180','tmp');">
<input id="rotate" type="submit" value="-90" class="button pntr" onclick="rotateimage('<?=$varDomainFolder?>','<?=$varImageFolder?>','<?=$varImageName?>','-90','tmp');">
<input id="saveImage" type="submit" value="Save Image" class="button pntr" onclick="rotateimage('<?=$varDomainFolder?>','<?=$varImageFolder?>','<?=$varImageName?>','0','save');">
<input id="refresh" type="submit" value="Refresh" style="visibility:hidden;" class="button pntr" onclick="javascript:window.location.reload(true);">
<br clear="all"><br clear="all">
<span id="successMsg" style="visibility:hidden;" class='mediumtxt'>Photo has been saved successfully,Please do click on refresh button</span>

<br clear="all"><br clear="all">
 		<form name="PhotoRank">			
				<input type="hidden" name="id" id="id" value="<?=$varMatriId?>">
				<input type="hidden" name="num" id="num" value="<?=$varPhotoNo?>">
	    <!--
		<?php
		if(empty($varPhotoRank)) {
        ?>
		<label class="boldtxt clr1">Photo Looking</label><br>
		<input type="radio" <?=($varPhotoRank == 1)?"checked":''?> name="photoRank" value="1">&nbsp;BelowAverage 
		<input type="radio" <?=($varPhotoRank == 2)?"checked":''?> name="photoRank" value="2">&nbsp;Average
		<input type="radio" <?=($varPhotoRank == 3)?"checked":''?> name="photoRank" value="3">&nbsp;Good Looking
		<input type="radio" <?=($varPhotoRank == 4)?"checked":''?> name="photoRank" value="4">&nbsp;Very Beautiful
		<br clear="all"><br clear="all">
		<?php
		}
		?>
		<label class="boldtxt clr1">Photo Quality</label><br>
		<input type="radio" <?=($varPhotoQuality == 1 && !empty($varPhotoQuality))?"checked":''?> name="photoQuality" value="1">&nbsp;Poor 
		<input type="radio" <?=($varPhotoQuality == 2 && !empty($varPhotoQuality))?"checked":''?> name="photoQuality" value="2">&nbsp;Average
		<input type="radio" <?=($varPhotoQuality == 3 && !empty($varPhotoQuality))?"checked":''?> name="photoQuality" value="3">&nbsp;Good
		<input type="submit" name="frmPhotoRank" value="submit" class="button pntr">
		-->
		</form>
</div></div>
	<br clear="all"><br clear="all">

	<div id="tmpwrap" style="padding-left:20px;padding-right:20px;float:left;">
	<img id="img_div" src="<?=$varEditPhotoPath?>" />
	<input type="hidden" name="checkSubmit" id="checkSubmit" value="0">
	</div>
	<br clear="all">
	<br>
	<div id="iframewrap" style="padding-left:20px;padding-right:20px;float:left;">
	<iframe id="frameId" frameborder="0" src=""></iframe>
	</div>
</div>
<script>
if(document.getElementById('frameId').width == "0" ) {
document.getElementById('frameId').width=document.getElementById('img_div').width;
}
if(document.getElementById('frameId').height == "0") { 
document.getElementById('frameId').height=document.getElementById('img_div').height;
}
</script>
</body>
</html>
<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: -1");
?>