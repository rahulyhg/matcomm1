<?php
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsDB.php");

//OBJECT DECLARATION
$objDB	= new DB;

//DB CONNECTION
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLLE DECLARATIONS
$varUsername		= $_REQUEST["username"];
$varCurrentDate		= date('Y-m-d H:i:s');
$varCheckUsename	= '';

//CHECK IF USERNAME ALREADY EXISIT OR NOT (franchisee)
$varCondition		= " WHERE User_Name='".str_replace(" ","",trim($varUsername))."'";
$varNumOfRecord		= $objDB->numOfRecords($varTable['FRANCHISEE'],'Franchisee_Id',$varCondition);
$objDB->dbClose();
unset($objDB);
?>
<html>
<head><title>Check Availability Popup</title>
<script language="javascript">
function funCallMe(record) {

	if(record == 0) { window.opener.document.frmAssociatesLogin.password.focus(); }//if
	else {
		window.opener.document.frmAssociatesLogin.username.value="";
		window.opener.document.frmAssociatesLogin.username.focus();
	}//else

}//funCallMe
</script>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
</head>


<BODY aLink="#000000" bgColor="#ffffff" link="#000000" text="#000000" vLink="#000000" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
<table width="450" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td colspan="3"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="7"></td>
	</tr>
	<tr>
		<td ><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" width="7" height="1" border="0"></td>
		<td width="437" valign="top">
			<table width="437" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td ><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" width="136" height="12" border="0"></td>
				<td ><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" width="300" height="12" border="0"></td>
			</tr>
			<? if($varNumOfRecord == '0'){?>
			<tr>
				<td width='136' align='center'><img src='<?=$confValues['IMGSURL']?>/dm_smile.gif' alt='' width='90' height='90' border='0'></td>
				<td width='290' align='left' class='smalltxt'>Congratulations! <font  class='smalltxt'><?=$varUsername ?></font> is available. Go ahead and complete your registration to become a payment associate.</td>
			</tr>
			<tr>
				<td height="10" colspan="2" align="center" class="smalltxt clr1"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" width="360" height="1" border="0"><a href="javascript:window.close();" style="cursor: pointer;" class="smalltxt1 clr1"><u>Close</u></a></td>
			</tr>
			<?}else{?>
			<tr>
				<td width='136' align='center'><img src='<?=$confValues['IMGSURL']?>/dm_cry.gif' alt='' width='90' height='90' border='0'></td>
				<td width='290' align='left' class='smalltxt'>Sorry! <font class='smalltxt'><?=$varUsername ?></font> is not available.Try another Username.</td>
			</tr>
			<tr>
				<td height="10" colspan="2" align="center" class="smalltxt clr1"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" width="360" height="1" border="0"><a href="javascript:window.close();" style="cursor: pointer;" class="smalltxt1 clr1"><u>Close</u></a></td>
			</tr>
<?}?>
			<tr>
				<td colspan="2" height="10"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" width="1" height="12" border="0"></td>
			</tr>
			</table>
		</td>
	<td ><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" width="7" height="1" border="0"></td>
</tr>
<tr>
	<td colspan="3" ><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="7"></td>
</tr>
</table>
