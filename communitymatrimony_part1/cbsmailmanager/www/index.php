<?php
//******************************************************************
// AUTHOR		: ASHOK KUMAR
// FILENAME		: INDEX.PHP
// PROJECT		: CAMPAIGN ADMIN CONTROL MANAGEMENT
// DATE			: 21-06-2005
// DISCRIPTION	: FILE CONTAINS FUNCTIONS USING ON THIS PROJECT
//******************************************************************

include "/home/cbsmailmanager/config/config.php";
include_once "lib/authenticate.php";
include "/home/cbsmailmanager/config/header.php";

if ( $_SESSION['auth'] != 1 ) {
	include "login.php";
	include "/home/cbsmailmanager/config/footer.php";
	exit;
} else {
	
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="780" class="maintborder" bgcolor="#ffffff">
<tr>

<td valign="top" width="148"  bgcolor="E9E9E9">
<!--Left Menu Start-->		
<? include "/home/cbsmailmanager/config/leftmenu.php"; ?>
<!--Left Menu End-->		
</td>

<td valign="top" bgcolor=#B5B5B5 class="borderclr"><img src="/images/trans.gif" width="1" height="1"></td>
<td width="5">&nbsp;</td>

<td valign="top" width="625">
<br>
<!--Middle Area Start-->		
<font class="title"> Hi , Welcome to CommunityMatrimony Mail Manager ! </font>
<!--Middle Area End-->		
</td>

</tr>
</table>
<?php
}
include "/home/cbsmailmanager/config/footer.php";

?>