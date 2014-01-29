<?php
include "/home/cbsmailmanager/config/config.php";
//include_once "lib/authenticate.php";
include "/home/cbsmailmanager/config/header.php";

$catg = $_GET['catg'];
$dt = $_GET['dt'];

	// Assigning the filename of Flat file...
	$flatfile = '/home/cbsmailmanager/maillog/maillog.txt';
	$counter = 1;
	$lines = file($flatfile);
	foreach ($lines as $line_num => $line) {
		$finallog = explode ("::", $line);

		if ($finallog[0] == $dt && $finallog[1] == $catg) {

			$datetime		= trim($finallog[0]); 
			$category		= trim($finallog[1]); 
			$totalrec		= trim($finallog[2]); 
			$totalmail		= trim($finallog[3]); 
			$language		= trim($finallog[4]); 
			$country		= trim($finallog[5]); 
			$testemails		= trim($finallog[6]); 
			$validated	    = trim($finallog[7]); 
			$authorise		= trim($finallog[8]); 
			$status			= trim($finallog[9]); 
			$paidmembers    = trim($finallog[10]); 
			$phone			= trim($finallog[11]);
			$remarks		= trim($finallog[12]);
			$memberstatus   = trim($finallog[13]);
			$dateofconfig   = trim($finallog[14]);
			$fromlastlogin  = trim($finallog[15]);
			$tolastlogin    = trim($finallog[16]);
			$education      = trim($finallog[17]);
			$fromtimecreated= trim($finallog[18]);
			$totimecreated  = trim($finallog[19]);
			$gender         = trim($finallog[20]);
			$agefrom        = trim($finallog[21]);
			$ageto          = trim($finallog[22]);

			$languageis		= explode(",",$language);
			$countryis		= explode(",",$country);
			$statusis		= explode(",",$status);
			$educationis	= explode(",",$education);

			$catginfo		= getcateginfo($category); 
			$maillistcount	= $totalrec;
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

	<table class="title" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF" width=90%>
	<tr  bgcolor="#6A6A6A">
		<td class="white" align=center ><?=$ret_res?></td>
	</tr>
	<tr  bgcolor="FF6000">
		<td class="white" align=left > Detail Log Report -  [ <?=$category?> ]  <?=$datetime?>   </td>
	</tr>
	<tr>
		<td colspan=2>
			<table class="smalltxt" border="0" cellpadding="1" cellspacing="2" align="center" bgcolor="#FFFFFF">
			<tr>
				<td class="title">Category</td>
				<td colspan=3> [<?=$category?>]  <?=$catginfo['CategoryName']?> - (<?=(($catginfo['ValidFlag']==1)?'Active Mode':'DeActive Mode')?>) &nbsp;&nbsp; <?=$dateofconfig?>	</td>
			</tr>
			<tr>
				<td class="title" colspan=4>About this mailer</td>
			</tr>
			<tr>
				<td colspan=4> <?=$catginfo['Comment']?>	</td>
			</tr>
			<tr> <td colspan=4> &nbsp;	</td>	</tr>
			<tr bgcolor="#E9E9E9">
				<td class="smalltxt" colspan=4> <b> You are going to send mail for : </b>  
					<?
						if ($memberstatus == '0') {
							echo "All Kind of Members";
						} elseif ($memberstatus == '1') {
							echo "Members Only";
						} elseif ($memberstatus == '2') {
							echo "Non Members Only";
						} elseif ($memberstatus == '3') {
							echo "Past Members";
						} elseif ($memberstatus == '4') {
							echo "Partly Register Case 1";
						} elseif ($memberstatus == '5') {
							echo "Partly Register Case 2";
						} elseif ($memberstatus == '6') {
							echo "Matrimony Xpress Members";
						}
					?>
				</td>
			</tr>
			<tr> <td colspan=4> &nbsp;	</td>	</tr>
			<? if ($memberstatus == '1') { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>Is Validated?</td>
				<td> <?=(($validated=='1')?'Validated':(($validated=='0')?'Not Validated':'Both'))?> </td>
				<td class="title">Is Authorised?</td>
				<td> <?=(($authorise=='1')?'Authorised':(($authorise=='0')?'Not Authorised':'Both'))?></td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>Is Paid Members?</td>
				<td> <?=get_from_arryhash('paidhash',$paidmembers)?> </td>
				<td class="title">Is PhoneVerfied? </td>
				<td> <?=get_from_arryhash('phonehash',$phone)?> </td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title">Profile Status</td>
				<td colspan=3> <?
						foreach ($statusis as $key => $value) {
								echo get_from_arryhash('statushash',$value);
								if ($value != '') 
									echo ",&nbsp;&nbsp;";
						}
					 ?> 
				</td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Education</td>
				<td colspan=3> <?
						foreach ($educationis as $key => $value) {
							echo get_from_arryhash('educationhash',$value);
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>
			</tr>
			<? } ?>
			<? if ($memberstatus == '1' || $memberstatus == '5') { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>Gender</td>
				<td> <?=(($gender=='M')?'Male':(($validated=='F')?'Female':'Both'))?> </td>
				<td class="title">Age</td>
				<td> From : <?=$agefrom?> - To : <?=$ageto?> </td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Language</td>
				<td colspan=3> <?
						foreach ($languageis as $key => $value) {
							echo get_from_arryhash('languagedomain',$value);
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Country</td>
				<td colspan=3> <?
						foreach ($countryis as $key => $value) {
							echo get_from_arryhash('countryhash',$value);
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>
			</tr>
			<? } ?>
			<? if ($memberstatus == '1') { ?>
			<? if ($fromlastlogin != '' && $tolastlogin != '') { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Last Login</td>
				<td colspan=3> <?=$fromlastlogin?> to <?=$tolastlogin?></td>
			</tr>
			<? } ?>
			<? if ($fromtimecreated != '' && $totimecreated != '') { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Time Created</td>
				<td colspan=3> <?=$fromtimecreated?> to <?=$totimecreated?></td>
			</tr>
			<? } ?>
			<? } ?>
			<tr> <td colspan=4> &nbsp;	</td>	</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Remarks</td>
				<td colspan=3 wrap> <?=$remarks?> 
				</td>
			</tr>
			<tr> <td colspan=4> &nbsp;	</td>	</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Test Email Id's</td>
				<td colspan=3 wrap> <?=$testemails?> 
				</td>
			</tr>
			<tr> <td colspan=4> &nbsp;	</td>	</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>Number of Records</td>
				<td colspan=3> <?=$totalrec?> 
				</td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>Number of Mail sent</td>
				<td colspan=3> <?=$totalmail?> 
				</td>
			</tr>
			<tr> <td colspan=4> &nbsp;	</td>	</tr>
			<? if ($maillistcount <= 0) { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title">Error Report</td>
				<td colspan=3> <b> Sorry, Mail list not genrated for above Concept and Criteria...! </b>	</td>
			</tr>
			<? } ?>
			<tr> <td colspan=4> &nbsp;	</td>	</tr>

			</table>
		</td>
	</tr>
	</table>

<!--Middle Area End-->		
</td>

</tr>
</table>

<? include "/home/cbsmailmanager/config/footer.php"; ?>