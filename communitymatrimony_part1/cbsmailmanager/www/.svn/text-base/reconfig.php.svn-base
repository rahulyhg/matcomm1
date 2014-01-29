<?php
include "/home/mailmanager/config/config.php";
include_once "lib/authenticate.php";
include "/home/mailmanager/config/header.php";
 
include "/home/mailmanager/config/styleheader.php";
ini_set("memory_limit","512M");

$fname = $_GET['fname'];
?>

<table border="0" cellpadding="0" cellspacing="0" align="center" width="780" class="maintborder" bgcolor="#ffffff">
<tr>

<td valign="top" width="148"  bgcolor="#E9E9E9">
<!--Left Menu Start-->		
<? include "/home/mailmanager/config/leftmenu.php"; ?>
<!--Left Menu End-->		
</td>

<td valign="top" bgcolor=#B5B5B5 class="borderclr"><img src="/images/trans.gif" width="1" height="1"></td>
<td width="5">&nbsp;</td>

<td valign="top" width="625">
<br>
<!--Middle Area Start-->		
<? 
if ( $_POST['do_submit'] == "Submit" ) {
	$fromlastlogin  = trim($_POST['fromlastlogin']);    // From LastLogin
	$tolastlogin    = trim($_POST['tolastlogin']);      // To last login
	$getfilename = "/home/mailmanager/mfiles/".$fname;
	$get_handle = fopen($getfilename, "r");
	$getcontents = fread($get_handle, filesize($getfilename));
	fclose($get_handle);

	$mailconfigval = explode ("::", $getcontents);

	$updatecontent = $mailconfigval[0]."::".$mailconfigval[1]."::".$mailconfigval[2]."::".$mailconfigval[3]."::".$mailconfigval[4]."::".$mailconfigval[5]."::".$mailconfigval[6]."::".$mailconfigval[7]."::".$mailconfigval[8]."::".$mailconfigval[9]."::".$mailconfigval[10]."::".date('Y-m-d H:i:s')."::".$fromlastlogin."::".$tolastlogin."::".$mailconfigval[14]."::".$mailconfigval[15]."::".$mailconfigval[16]."::".$mailconfigval[17]."::".$mailconfigval[18]."::".$mailconfigval[19]."::".$mailconfigval[20]."::".$mailconfigval[21]."::".$mailconfigval[22]."::".$mailconfigval[23]."::".$mailconfigval[24]."::".$mailconfigval[25]."::".$mailconfigval[26]."::".$mailconfigval[27]."::".$mailconfigval[28]."::".$mailconfigval[29]."::".$mailconfigval[30];
	if(file_exists($getfilename)){
		unlink($getfilename);
	}
	if (!$handlewrite = fopen($getfilename, 'w')) {
        echo "Cannot open file ($getfilename)";
        exit;
	}
	if (fwrite($handlewrite, $updatecontent) === FALSE) {
       echo "Cannot write to file ($getfilename)";
       exit;
	}
	fclose($handlewrite);
	echo "<img src='callcreatemail.php?catg=$mailconfigval[0]'>";
 }
	$filename = "/home/mailmanager/mfiles/".$fname;
	$handle = fopen($filename, "r");
	$contents = fread($handle, filesize($filename));
	fclose($handle);

	$mailconfig = explode ("::", $contents);

	$category		  = $mailconfig[0]; 
	$language		  = $mailconfig[1]; 
	$country		  = $mailconfig[2]; 
	$testemails		  = $mailconfig[3]; 
	$validated	      = $mailconfig[4]; 
	$authorise		  = $mailconfig[5]; 
	$status			  = $mailconfig[6]; 
	$paidmembers      = $mailconfig[7]; 
	$phone			  = $mailconfig[8];
	$remarks		  = $mailconfig[9];
	$memberstatus     = $mailconfig[10];
	$dateofconfig     = $mailconfig[11];
	$fromlastlogin    = $mailconfig[12];
	$tolastlogin      = $mailconfig[13];
	$education        = $mailconfig[14];
	$fromtimecreated  = $mailconfig[15];
	$totimecreated    = $mailconfig[16];
	$gender           = $mailconfig[17];
	$agefrom          = $mailconfig[18];
	$ageto            = $mailconfig[19];
	$profile		  = $mailconfig[21];
	$indianstate	  = $mailconfig[22];
	$usstate		  = $mailconfig[23];
	$district		  = $mailconfig[24];
	$mothertongue	  = $mailconfig[25];
	$religion		  = $mailconfig[26];
	$caste			  = $mailconfig[27];
	$priority         = $mailconfig[28];
	$bywhom           = $mailconfig[29];
	$expire           = $mailconfig[30];
	$castenobar     = $mailconfig[31];


	$languageis		  = explode(",",$language);
	$countryis		  = explode(",",$country);
	$statusis		  = explode(",",$status);
	$educationis	  = explode(",",$education);
	$indianstateis	  = explode(",",$indianstate);
	$usstateis		  = explode(",",$usstate);
	$districtis		  = explode(",",$district);
	$mothertongueis	  = explode(",",$mothertongue);
	$religionis		  = explode(",",$religion);
	$casteis		  = explode(",",$caste);
	$bywhomis         = explode(",",$bywhom);


	$catginfo		= getcateginfo($mailconfig[0]); 
	$maillistcount	= file_rec_count($category);
	$testmaillistcount	= test_file_rec_count();

	

  

?><form name="frm" method="post" action="" >
	<table class="title" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF" width=90%>
	<tr  bgcolor="#6A6A6A">
		<td class="white" align=center ><?=$ret_res?></td>
	</tr>
	<tr  bgcolor="#6A6A6A">
		<td class="white" align=left > Send Mail Now! </td>
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
			<td class="title" nowrap>Is Profile Verified?</td>
				<td> <?=(($profile=='1')?'Verified':(($profile=='0')?'Not Verified':'Both'))?> </td>
				<td class="title">Profile Status</td>
				<td> <?
						foreach ($statusis as $key => $value) {
								echo get_from_arryhash('statushash',$value);
								if ($value != '') 
									echo ",&nbsp;&nbsp;";
						}
					 ?> 
				</td>
			</tr>
			<?
				if(in_array("98",$countryis)) {
			?>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>ResidingStates in India</td>
				<td colspan=3> <?
						foreach ($indianstateis as $key => $value) {
							echo get_from_arryhash('residingindianames',$value);
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>
			</tr>
			<? } 
			   if(in_array("222",$countryis)) {
			?>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>ResidingStates in US</td>
				<td colspan=3> <?
						foreach ($usstateis as $key => $value) {
							echo get_from_arryhash('residingusanames',$value);
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>
			</tr>
			<? } ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Residing District</td>
				<td colspan=3> <?
						foreach ($districtis as $key => $value) {  
							 echo get_from_arryhash('city',$value);
 
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>MotherTongue</td>
				<td colspan=3> <?
						foreach ($mothertongueis as $key => $value) {
							echo get_from_arryhash('mothertonguehash',$value);
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Religion</td>
				<td colspan=3> <?
						foreach ($religionis as $key => $value) {
							echo get_from_arryhash('religionhash',$value);
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Caste</td>
				<td colspan=3> <?
						foreach ($casteis as $key => $value) {
							echo get_from_arryhash('castehash',$value);
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>
			</tr>
			<? if($castenobar != ''){?>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>CasteNobar</td>
				<td colspan=3> Caste Nobar
					 
				</td>
			</tr><? } ?>
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
			<? if ($memberstatus == '1' || $memberstatus == '5') {  ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>Gender</td>
				<td> <?=(($gender=='M')?'Male':(($gender=='F')?'Female':'Both'))?> </td>
				<td class="title">Age</td>
				<td> From : <?=$agefrom?> - To : <?=$ageto?> </td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>By Whom</td>
				<td colspan=3> <?
						foreach ($bywhomis as $key => $value) {
							echo get_from_arryhash('bywhomhash',$value);
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>  

 
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
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Priority of the mailer</td>
				<td colspan=3> 
				<? if($priority == 1)    echo "High"; 
				else if($priority == 2) echo "Medium"; 
				else if($priority == 3) echo "Normal";
					 ?> 
				</td>
			</tr>

			<? if ($memberstatus == '1') { ?>
			<? if ($fromlastlogin != '' && $tolastlogin != '') { ?>
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
			<? if ($expire != '') { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Payment Going to expirey on</td>
				<td colspan=3> within <?=$expire?> days</td>
			</tr>
			<? } ?>
			<? } ?>
			<tr> <td colspan=4> &nbsp;	</td>	</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>Number of Records</td>
				<td colspan=3> <?=$maillistcount?> 
				</td>
			</tr>
								<tr>
										<td class="title"> LastLogin From date </td>
										<td> <input class="smalltxt" name="fromlastlogin" value="" maxlength="10" size="13" onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;" type="text">
											 <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.fromlastlogin',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" alt="" border="0" height="21" width="34"></a>
											</td>
								</tr> 
								<tr>
											<td class="title"> LastLogin To date </td><td>
										     <input class="smalltxt" name="tolastlogin" value="" maxlength="10" size="13" onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;" type="text">
											 <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.tolastlogin',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" alt="" border="0" height="21" width="34"></a>
										</td>
								</tr>
			<? } ?>
			<? if ($fromtimecreated != '' && $totimecreated != '') { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Time Created</td>
				<td colspan=3> <?=$fromtimecreated?> to <?=$totimecreated?></td>
			</tr>
			<? } ?>
			<? if ($expire != '') { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Payment Going to expirey on</td>
				<td colspan=3> within <?=$expire?> days</td>
			</tr>
			<? } ?>
			<? } ?>
			<tr> <td colspan=4> &nbsp;	</td>	</tr>
	
			 <tr>
					<td class="smalltxt" align="right"><input type="submit" class="smalltxt"  name="do_submit" value="Submit"></td>
				</tr>
			</table>
		</td>
	</tr>
	</table>

<!--Middle Area End-->		
</td>

</tr>
</table></form>

<? include "/home/mailmanager/config/footer.php"; ?>