<script>
function deletemail(filename)
{
	var x = confirm('Are You sure You want delete the mail list');
	if(x == 1)
		window.location.href="checkfiles.php?opr=del&fname="+filename;
}
</script>

<?php
include "/home/cbsmailmanager/config/config.php";
//include_once "lib/authenticate.php";
include "/home/cbsmailmanager/config/header.php";

if ( (isset($_GET['opr'])) && ($_GET['opr'] != '') && $_GET['fname'] != '') {
	$fname = $_GET['fname'];
	$firstfile = '/home/cbsmailmanager/mfiles/'.$fname.".txt";
	$secondfile = '/home/cbsmailmanager/mlistfiles/'.$fname."mail.txt";
	$arrAlphabets = range('a','z');
	$arrSplitedText = array();
	$iAlpCnt = count($arrAlphabets);
	for($i=0;$i<$iAlpCnt;$i++){
	for($j=0;$j<$iAlpCnt;$j++){
		array_push($arrSplitedText,$arrAlphabets[$i].$arrAlphabets[$j]);
	 }
	}
	$splitfiles=$fname."_SPT_";

	exec("ls /home/cbsmailmanager/mlistfiles/$splitfiles*|wc -l",$out);
	if($out[0]>0){
		for($i=0;$i<$out[0];$i++){
			$sSplitFile = "$splitfiles".$arrSplitedText[$i];
			$splitpath ='/home/cbsmailmanager/mlistfiles/'.$sSplitFile.".txt";
			if (file_exists($splitpath)) {
				unlink($splitpath);
			}
		}
	}
	
	if (file_exists($firstfile)) {
		unlink ($firstfile);
	}
	if (file_exists($secondfile)) {
		unlink ($secondfile);
	}
}

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

<?
$dirname = "/home/cbsmailmanager/mfiles";
if (is_dir($dirname)) {
	if ( function_exists('scandir') ) {
		$listfiles = scandir($dirname);
	} else {
		if ($handle = opendir($dirname)) {
		   while (false !== ($file = readdir($handle))) { 
				   $listfiles[] = $file;
		   }
		   closedir($handle); 
		}
	}
	$listcnt = count($listfiles);
	
	if (is_array($listfiles) && ($listcnt > 2)) {
?>

	<table class="smalltxt" border=0 align=center cellpadding=1 cellspacing=1 width=60%>
	<tr bgcolor="#B4B2AF">
		<td class=title colspan=10 align=center>
			<table class="smalltxt" border=0 width=100% align=center cellpadding=1 cellspacing=1 >
			<tr bgcolor="FF6000">
				<td class=white align=left>List Of Mail Concepts</td>
				<td class=white align=right><a class=white href="mailconfig.php"> Create New </a> </td>
			</tr>
			</table>
		</td>
	</tr>
	<tr bgcolor="#CECECE">
		<td class="title">#</td>
		<td class="title">Date</td>
		<td class="title">Mail Name</td>
		<td class="title">View</td>
		<td class="title">Delete</td>
	</tr>

	<?php 
	  $k = 1;
	  for ($i=0; $i<$listcnt; $i++) {
	  if ($i>1) {
		  if ( substr($listfiles[$i],(strpos($listfiles[$i], '.'))+1,3) == 'txt' ) {
			 $concept = substr($listfiles[$i],0,(strlen($listfiles[$i])-4));
			 $filename = $concept.'.txt';
			 $contents = file_get_contents("/home/cbsmailmanager/mfiles/$filename", FILE_USE_INCLUDE_PATH);
			 $mailconfig = explode ("::", $contents);
			 $dateofconfig     = $mailconfig[11];
		if($i&1) {
	?>
	<tr bgcolor="#CECECE">
	<? } else { ?>
	<tr bgcolor="#E5E5E5">
	<? } ?>
		<td><?=$k?></td>
		<td><?=date('d-M-y',strtotime($dateofconfig))?></td>
		<td><?=$concept?></td>
		<td> <a href="viewdetails.php?fname=<?=$listfiles[$i]?>"> <img border=0 style="cursor:hand" src="images/button_edit.png"> </a> </td>
		<td><img border=0 style="cursor:hand" src="images/button_drop.png" onclick="deletemail('<?=$concept?>')" style="cursor:hand"></td>
	</tr>
	<? 
		$k++;
		  }
	    }
	  }
	} else {
		echo "No Mail Lists available...";
	}
	?>
	</table>
<? } ?>

<!--Middle Area End-->		
</td>

</tr>
</table>

<? include "/home/cbsmailmanager/config/footer.php"; ?>