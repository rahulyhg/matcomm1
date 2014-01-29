<?php
include "/home/cbsmailmanager/config/config.php";
//include_once "lib/authenticate.php";
include "/home/cbsmailmanager/config/header.php";
include "/home/cbsmailmanager/config/styleheader.php";

$fname = $_GET['fname'];
?>

<table border="0" cellpadding="0" cellspacing="0" align="center" width="780" class="maintborder" bgcolor="#ffffff">
<tr>

<td valign="top" width="148"  bgcolor="#E9E9E9">
<!--Left Menu Start-->		
<? include "/home/cbsmailmanager/config/leftmenu.php"; ?>
<!--Left Menu End-->		
</td>

<td valign="top" bgcolor=#B5B5B5 class="borderclr"><img src="/images/trans.gif" width="1" height="1"></td>
<td width="5">&nbsp;</td>

<td valign="top" width="625">
<br>
<!--Middle Area Start-->		

<form name="frm" method="post" action="" >
<table class="title" border=0 align=center cellpadding=1 cellspacing=1 >
<tr  bgcolor="FF6000">
	<td class="white" align=center colspan=3> Log Report </td>
</tr>
<tr>
<td> Choose Date : <input class="smalltxt" type="text" name="Choose_Date" value="" maxlength=10 size=13 onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;">
<a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.Choose_Date',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt=""></a>
</td>
</tr>
<tr>
<td class="smalltxt" align="right">
	<input type="submit" class="smalltxt"  name="do_submit" value="Submit"> 
	<input type="reset" class="smalltxt" name="reset" value="Reset">
</td>
</tr>
</table>
</form>

<? 
if ($_POST['do_submit'] == 'Submit' ) {	
?>
<table class="title" border=0 align=center cellpadding=2 cellspacing=1 >
<tr  bgcolor="FF6000">
	<td class="white" align=center colspan=5> Log Report </td>
</tr>
<tr  bgcolor="FF6000">
	<td class="white" align=center> # </td>
	<td class="white" align=center> DateTime </td>
	<td class="white" align=center> Mail Concept </td>
	<td class="white" align=center> # of Records </td>
	<td class="white" align=center> # of Mail Sents </td>
</tr>
<?
	$choosendate = $_POST['Choose_Date'];
	// Assigning the filename of Flat file...
	$flatfile = '/home/cbsmailmanager/maillog/maillog.txt';
	$counter = 0;
	$lines = file($flatfile);
	foreach ($lines as $line_num => $line) {
		$finallog = explode ("::", $line);
		if (substr($finallog[0],0,10) == $choosendate) {
			//echo $counter . " > " ;
			$counter = $counter + 1;
			
			if (($counter % 2) == 0) {
				$bgcolor = '#E5E5E5';
			} else {
				$bgcolor = '#CECECE';
			}

			echo "<tr  bgcolor='$bgcolor' class='smalltxt'>";
			echo "<td align=left> $counter </td> ";
			echo "<td align=left> <a style=\"text-decoration:none\" href=\"viewlog.php?dt=".$finallog[0]."&catg=".$finallog[1]."\">".DateTimeStamp1($finallog[0])."</a></td>";
			echo "<td align=center> ".$finallog[1]." </td>";
			echo "<td align=center> ".$finallog[2]." </td>";
			echo "<td align=center> ".$finallog[3]." </td>";
			echo "</tr>";
		} elseif ($_GET['rpt'] == 'all') {
			$counter = $counter + 1;
			
			if (($counter % 2) == 0) {
				$bgcolor = '#E5E5E5';
			} else {
				$bgcolor = '#CECECE';
			}

			echo "<tr  bgcolor='$bgcolor' class='smalltxt'>";
			echo "<td align=left> $counter </td> ";
			echo "<td align=left> <a style=\"text-decoration:none\" href=\"viewlog.php?dt=".$finallog[0]."&catg=".$finallog[1]."\">".DateTimeStamp1($finallog[0])."</a></td>";
			echo "<td align=center> ".$finallog[1]." </td>";
			echo "<td align=center> ".$finallog[2]." </td>";
			echo "<td align=center> ".$finallog[3]." </td>";
			echo "</tr>";
		}
	}
}
?>
</table>

<!--Middle Area End-->		
</td>

</tr>
</table>

<? include "/home/cbsmailmanager/config/footer.php"; ?>