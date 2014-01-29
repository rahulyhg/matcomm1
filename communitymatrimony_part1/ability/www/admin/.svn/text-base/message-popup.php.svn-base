<?php

//VARIABLE
$varMatriId		= $_REQUEST['MatriId'];
$varOppMatriId	= $_REQUEST['OppMatriId'];
$varUsername	= $_REQUEST['Username'];
$varNotesId		= $_REQUEST["msgid"];
$varRequestId   = $_REQUEST["reqid"];
$varMessage		= $_REQUEST["msg"];
//echo $varNotesId,$varRequestId;	
//FILE INCLUDES
include_once('../includes/config.php');
include_once('../includes/dbConn.php');
include_once('includes/clsCommon.php');
include_once('../registration/includes/registration-array-values.php');

//OBJECT DECLARATIONS
$objCommon					= new Common;
if($varRequestId==1)
{
	$objCommon->clsTable		= "mailreceivedinfo";
	$objCommon->clsPrimary		= array('Message_Id');
	$objCommon->clsPrimaryValue	= array($varNotesId);
	$objCommon->clsFields		= array('Mail_Message');
	$varCommon					= $objCommon->selectInfo();
}
if($varRequestId==2)
{
	$objCommon->clsTable		= "expressinterestinfo";
	$objCommon->clsPrimary		= array('Interest_Id');
	$objCommon->clsPrimaryValue	= array($varNotesId);
	$objCommon->clsFields		= array('Interest_Option');
	$varCommon					= $objCommon->selectInfo();
}
if($varRequestId==3)
{
	$objCommon->clsTable		= "bookmarkinfo";
	$objCommon->clsPrimary		= array('MatriId','Opposite_MatriId');
	$objCommon->clsPrimaryValue	= array($varMatriId,$varOppMatriId);
	$objCommon->clsPrimaryKey	= array('AND');
	$objCommon->clsFields		= array('Comments');
	$varCommon					= $objCommon->selectInfo();
}
if($varRequestId==4)
{
	$objCommon->clsTable		= "blockinfo";
	$objCommon->clsPrimary		= array('MatriId','Opposite_MatriId');
	$objCommon->clsPrimaryValue	= array($varMatriId,$varOppMatriId);
	$objCommon->clsPrimaryKey	= array('AND');
	$objCommon->clsFields		= array('Comments');
	$varCommon					= $objCommon->selectInfo();
}
if($varRequestId==5)
{
	$objCommon->clsTable		= "ignoreinfo";
	$objCommon->clsPrimary		= array('MatriId','Opposite_MatriId');
	$objCommon->clsPrimaryValue	= array($varMatriId,$varOppMatriId);
	$objCommon->clsPrimaryKey	= array('AND');
	$objCommon->clsFields		= array('Comments');
	$varCommon					= $objCommon->selectInfo();
}

?>
	<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<table border="0" cellpadding="4" cellspacing="0" class="brownpopclr" width="500" bgcolor="#FFFFFF" height="200">
			<tr><td valign="top" class="smalltxt"><p align="justify">
			</td>
			</tr>
			<tr><td valign="top" class="smalltxt"><p align="justify">
			<?php 
				echo $varMessage;
			?>
			</p></td></tr>
			<tr><td align="right" valign="bottom"><a href="javascript:window.close();" class="formlink1">Close</a>&nbsp;</td></tr>
		</table>
	</body>
</html>

<?php
//UNSET OBJECT
unset($objMyMessage);
?>