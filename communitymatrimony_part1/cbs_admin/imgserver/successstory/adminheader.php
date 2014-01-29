<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		: contacthistory.php
#================================================================================================================
   # Description	: photo class use to resize photo and new photoname
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
?>
<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script> 
<style type="text/css"> @import url("<?=$confValues['CSSPATH'];?>/global-style.css"); </style>

<table width="88%" align="center" border="0"><tr><td>
<img src="<?=$confValues['IMGSURL']?>/logo/community_logo.gif" alt="Community Matrimony" border="0" />
<tr><td colspan=9><hr></td></tr>
<tr >
<td align="right"><a href='<?=$confValues['IMAGEURL'];?>/admin1/successstory/manage-incomplete-users.php?flag=0' class="mediumtxt clr1 boldtxt" align='right'>Pending Success Stories</a>&nbsp;&nbsp;&nbsp;</td><td> | </td>
<td align="center"><a href='<?=$confValues['IMAGEURL'];?>/admin1/successstory/manage-incomplete-photo.php?flag=0' class="mediumtxt clr1 boldtxt" align='right'>Pending Success Photo</a></td><td> | </td>
<!--td align="right"><a href='<?=$confValues['IMAGEURL'];?>/admin/successstory/manage-incomplete-users.php?flag=1' class="mediumtxt clr1 boldtxt" align='right'>Completed Success Stories</a></td><td> | </td-->
<td align="center"><a href='<?=$confValues['IMAGEURL'];?>/admin1/successstory/manage-incomplete-photo.php?flag=1' class="mediumtxt clr1 boldtxt" align='right'>Completed Success Photo</a></td><td> | </td>
<td align="center"><a  onclick="parent.window.location.href='http://support.communitymatrimony.com/admin/index.php?act=manage-users'" class="mediumtxt clr1 boldtxt" align='right'>Home</a></td>
</tr>

</td></tr></table>
	<br clear="all">
