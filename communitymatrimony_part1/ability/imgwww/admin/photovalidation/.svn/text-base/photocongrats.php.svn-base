<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 04-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: photocongrats.php
#================================================================================================================
   # Description	: success message for add photo.
#================================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/lib/clsAdminValMailer.php");
$objAdminMailer		= new AdminValid;

//Request added intimation to user
$objAdminMailer->dbConnect('M', $varDbInfo['DATABASE']);
$objAdminMailer->requestAdded($_GET['ID'],1);
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<body >
<?include_once("adminheader.php");?>
<a name="top"></a>
<div style="padding-left:20px;"><div style="padding-bottom:10px;"><font class="mediumtxt boldtxt clr3">Photo Added</font></div>
<div style="float:left; width:492px;border:1px solid #D3D3D3;" class="smalltxt">	
	<div style="padding: 20px;">
	<div style="text-align:left;" class="smalltxt">
		Congrats! You have successfully added  photo.<br></div>	
		<div class="fright"><input type="button" class="button" name="addphotos"  value="Add More Photos"onClick="javascript:window.location='<?=$confValues['IMAGEURL'];?>/admin/photovalidation/adminmanagephoto.php?MATRIID=<?=$_GET['ID'];?>';">
</div><br clear="all">
</div>