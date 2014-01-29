<?php

include '/home/cbsmailmanager/congif/config.php';
$community	= trim($_GET['cname']);
$path		= "http://img.".$community."matrimony.com/images/logo/".$community."_logo.gif";

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD><TITLE>Unsubscription</TITLE></HEAD>
<BODY>
<table width=750 cellspacing=0 cellpadding=0 border=0 style="border-top:1px solid #5D310F;border-left:1px solid #5D310F;border-right:1px solid #5D310F;border-bottom:1px solid #5D310F;">
<tr>
<td valign="top">
<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" width="748">
	<tr>
		<td valign="bottom">
		<center><img src="<?php echo $path; ?>" width="380" height="40" vspace="5" align="absmiddle" hspace="10"></center><br clear="all">
		<P STYLE="padding-left:165px;padding-right:3px;padding-top:10px;font-family: Verdana, MS Sans serif, Arial, Helvetica; font-size: 15px; font-style: normal; text-align: justify; text-transform: none; color: #000000;"><b>You have been unsubscribed from our Mailing List.</b></font></td>
	</tr>
	<tr bgcolor="#FFFFFF"><td valign="top" colspan="2"><img src="http://mail1.bharatmatrimony.com/mailmanager/trans.gif" width="498" height="1"></td></tr>
	<tr bgcolor="#D57128"><td valign="top" colspan="2"><img src="http://mail1.bharatmatrimony.com/mailmanager/trans.gif" width="498" height="5"></td></tr> 
</table>

</td></tr></table>
</BODY>
</HTML>
