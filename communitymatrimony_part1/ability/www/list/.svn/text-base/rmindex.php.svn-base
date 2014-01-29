<?php
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");

//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessGender			= $varGetCookieInfo["GENDER"];
$sessPaidStatus	 	= $varGetCookieInfo["PAIDSTATUS"];
$sessPublish	 	= $varGetCookieInfo["PUBLISH"];

//Redirecting page if session is empty
if(trim($sessMatriId)=="") { header('Location:'.$confValues['SERVERURL']);}

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
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/contact.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/conceptRTE.js"></script>
	<script language="javascript">
	var cook_id = '<?=$sessMatriId?>', cook_paid = '<?=$sessPaidStatus?>', cook_publish='<?=$sessPublish?>', cook_gender = '<?=$sessGender?>', imgs_url= '<?=$confValues["IMGSURL"]?>', img_url = '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url = '<?=$confValues["SERVERURL"]?>';
	</script>

<script language="javascript" src="<?=$confValues['JSPATH']?>/myhomeresult.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhome.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>

</head>

<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div class="main">
			<div class="innerdiv">

<div class="rpanel fleft">
	<center>
			<div class="normtxt1 clr2 padb5 fleft"><font class="clr bld">Favourites</font>  
			<!-- <a class="clr1 normtxt" href="<?=$confValues['SERVERURL']?>/search/">[Modify]</a> --></div><br clear="all">
			<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>

			<div class="smalltxt clr2 padt5"><div id="del_div" class="fright"><a id="listrequests" class="clr1" onclick="funListDeleteConfirm();">Remove from favourites</a></div></div><br clear="all">

			<form method="post" name="buttonfrm">
			<input type="hidden" id="purp" name="purp" value="SL">
			<div id="errorDivConfirm" style="display:none;background-color:#ffffff;width:540px;">
				Are you sure you want to delete these members from your List?
				<input type="button" class="button" value="Yes" onClick="funListDelete();">
				<input type="button" class="button" value="No" onClick="document.getElementById('errorDiv').style.display='none'">
			</div><br clear="all">
			
			<center><div id="errorDiv" class="brdr tlleft pad10" style="display:none;background-color:#EEEEEE;width:500px;">
			</div></center><br clear="all">
			
			<div id="msgResults">
				<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" onload="funListMain('SL');"/>
			</div>
			</form>
			<div id="prevnext" class="padtb10">
			</div>
	</center>
</div>
<br clear="all" />
				<br clear="all" />
			</div>
		</div>
	</div>
</div>
</center>
</body>
</html>