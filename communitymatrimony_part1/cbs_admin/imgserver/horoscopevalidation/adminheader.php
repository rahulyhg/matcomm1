<?
#================================================================================================================
   # Author 		: Jeyakumar
   # Date			: 25-MAr-2009
   # Project		: MatrimonyProduct
   # Filename		: adminheader.php
#================================================================================================================
   # Description	: header part for admin side horoscope
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
?>
<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script> 
<style type="text/css"> @import url("<?=$confValues['CSSPATH'];?>/global-style.css"); </style>

<table width="88%" align="center" border="0">
<tr><td><img src="<?=$confValues['IMGSURL']?>/logo/community_logo.gif" alt="Community Matrimony" border="0"/></td></tr>
<tr><td><hr></td></tr>
</table>
	<br clear="all">