<?php
include "/home/cbsmailmanager/config/config.php";
//include_once "lib/authenticate.php";
include "/home/cbsmailmanager/config/header.php";
ini_set("memory_limit","1024M");

$fname = $_GET['fname'];
?>
<!-- added by anish for send mail confirmation dialog box -->
<script>
function disp_confirm(a,b,c,d,e,f) {
	var r=confirm('Confirm To send the mail to Customers?')
	if (r==true){
		document.location="sys.php?fname="+a+"&type=live&dt="+b+"&pri="+c+"&mtype="+d+"&sendtype="+e+"&membertype="+f+"";
	} else {
		return false
	}
}
	
function get_testfile(type) {
	var a = document.getElementById("testfile").value;
	window.open("testfilegen.php?id="+a+"&category="+type,"mywindow","width=500,height=20,scrollbars=yes");
	location.reload(true);
}
			

</script>
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
	$filename = "/home/cbsmailmanager/mfiles/".$fname;
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
	$castenobar       = $mailconfig[31];
	$occupation       = $mailconfig[32];
	$expirydate_from  = $mailconfig[34];
	$expirydate_to	  = $mailconfig[35];
	$familystatus	  = $mailconfig[36];
	$oavailable		  = $mailconfig[37];
	$phystatus		  = $mailconfig[38];
	$horoscope		  = $mailconfig[39];

	$PhotoAvl		  = $mailconfig[40];
	$PhotoProtected	  = $mailconfig[41];
	$VoiceAvl		  = $mailconfig[42];
	$VideoAvl		  = $mailconfig[43];
	$HealthProfAvl	  = $mailconfig[44];
	$logincountfrom	  = $mailconfig[45];
	$logincountto	  = $mailconfig[46];
	$subcaste		  = $mailconfig[47];
	$NoofPayment	  = $mailconfig[48];
	$MaritalStatus	  = $mailconfig[49];
	$mailerunsubtype  = $mailconfig[50];
	$offercategoryid  = $mailconfig[51];
	$sendtype		  =	$mailconfig[52];
	// for cbs
	$membertype		  = $mailconfig[53];
	$otherdistict	  = $mailconfig[54];

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
	$occupationis     = explode(",",$occupation);
	$Family_Status    = explode(",",$familystatus);
	$Horoscope_Available = explode(",",$horoscope);

	$Photo_Available  = explode(",",$PhotoAvl);
	$PhotoProtectedis = explode(",",$PhotoProtected);
	$Voice_Available  = explode(",",$VoiceAvl);
	$Video_Available  = explode(",",$VideoAvl);
	$Health_Available = explode(",",$HealthProfAvl);

	$NoofPaymentis    = explode(",",$NoofPayment);
	$subcasteis		  = explode(",",$subcaste);
	$MaritalStatus_Available  = explode(",",$MaritalStatus);

	$QueryType = "count";

	if($membertype ==1) {  // For CBS members
		//$dblink->dbClose();
		//$dblink1 = new db();
		//$dblink1->connect($DBCONIP['DB15'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['COMMUNITYMATRIMONY']);			
		$mailsql = cbsCreateQuery($category,$QueryType);
		$mailres = mysql_query($mailsql);
		$mailnum = cbsrecordcount($QueryType,$mailres);
		//$catginfo  = cbsgetcateginfo($mailconfig[0]);
		$catginfo['ValidFlag'] =1;
		
	} else {  // For BM members
		$dblink->dbClose();
		$bmdblink = new db();
		$bmdblink->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MAILSYSTEM']);
		$mailsql = CreateQuery($category,$QueryType);
		$mailres = mysql_query ($mailsql);
		$mailnum = recordcount($QueryType,$mailres);
		$catginfo  = getcateginfo($mailconfig[0]); 
	}
	$maillistcount	= $mailnum;

	$testmaillistcount	= test_file_rec_count(); 

?>
	<table class="title" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF" width=90%>
	<tr  bgcolor="FF6000">
		<td class="white" align=center ><?=$ret_res?></td>
	</tr>
	<tr  bgcolor="FF6000">
		<td class="white" align=left > Send Mail Now! </td>
	</tr>
	<tr>
		<td colspan=2>
			<table class="smalltxt" border="0" cellpadding="1" cellspacing="2" align="center" bgcolor="#FFFFFF">
			<tr bgcolor="#E9E9E9"> 
				<td class="title">Category</td>
				<td colspan=3> [<?=$category?>]  <?=$catginfo['CategoryName']?> - (<?=(($catginfo['ValidFlag']==1)?'Active Mode':'DeActive Mode')?>) &nbsp;&nbsp; <?=$dateofconfig?>	</td>
			</tr>
			<tr bgcolor="#E9E9E9">
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
							echo "Inactive Only";
						} elseif ($memberstatus == '3') {
							echo "Past Members";
						} elseif ($memberstatus == '4') {
							echo "Partly Register Case 1";
						} elseif ($memberstatus == '5') {
							echo "Partly Register Case 2";
						} elseif ($memberstatus == '6') {
							echo "Matrimony Xpress Members";
						}
					?>&nbsp;&nbsp;(Send Through-<span style="font:bold 12px arial;color:#ff0000;"><?if($sendtype==1) echo "Smtp"; else echo "MailMethod";?></span>)
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
				<td class="title" valign=top>Community</td>
				<td colspan=3> <?
						foreach ($casteis as $key => $value) {
							echo get_from_arryhash('castehash',$value);
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Sub Caste</td>
				<td colspan=3> <?
						foreach ($subcasteis as $key => $value) {
							echo get_from_arryhash('subcastehash',$value);
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
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Occupation</td>
				<td colspan=3> <?
						foreach ($occupationis as $key => $value) {
							echo get_from_arryhash('occupationhash',$value);
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Familystatus</td>
				<td colspan=3> <?
						foreach ($Family_Status as $key => $value) {
							echo get_from_arryhash('familystatushash',$value);
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
				<td> <?=(($gender=='1')?'Male':(($gender=='2')?'Female':'Both'))?> </td>
				<td class="title">Age</td>
				<td> From : <?=$agefrom?> - To : <?=$ageto?> </td>
			</tr>
			
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Marital Status</td>
				<td colspan=3> <?
						foreach ($MaritalStatus_Available as $key => $value) {
							echo get_from_arryhash('maritalhash',$value);
							if ($value != '') 
								echo "<br>";
						}
					 ?> 
				</td>
			</tr>
			
			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>Photo Available</td>
				<td> <?=(($PhotoAvl=='1')?'Available':(($PhotoAvl=='0')?'Not Available':'Both'))?> </td>
				<td class="title">Photo Protected</td>
				<td> <?=(($PhotoProtected=='1')?'Protected':(($PhotoProtected=='0')?'Not Protected':'Both'))?></td>
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
				<td colspan=3> <?=$fromlastlogin?> to <?
				 if($tolastlogin == date('Y-m-d'))
				 echo $tolastlogin;
				 else
					 echo "<font color='red'>".$tolastlogin."</font>";?></td>
			</tr>
			<? } ?>

			<? if ($expire != '') { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Payment Going to expiry on</td>
				<td colspan=3> within <?=$expire?> days</td>
			</tr>
			<? } ?>
			<? } 
			
			 if ($fromtimecreated != '' && $totimecreated != '') { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Time Created</td>
				<td colspan=3> <?=$fromtimecreated?> to <?=$totimecreated?></td>
			</tr>
			<? } 

			if ($expirydate_from != '' && $expirydate_to != '') { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" valign=top>Expiry Date</td>
				<td colspan=3> <?=$expirydate_from?> to <?=$expirydate_to?></td>
			</tr>
			<? } ?>

			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>Number of Test Records</td>
				<td colspan=3> <?=$testmaillistcount?> 
				</td>
			</tr>

			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>Number of Records</td>
				<td colspan=3> <?=$maillistcount?> 
				</td>
			</tr>

			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>Number of lines in text file</td>
				<td colspan=3> <?=file_rec_count($category)?> 
				</td>
			</tr>

			<? if ($maillistcount > 0) { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title" nowrap>Text File </td>
				<td class="title" colspan=3> <?
				$maillistfilename = "/home/cbsmailmanager/mlistfiles/".$category."mail.txt";
				if (!$mailfp = @fopen($maillistfilename, 'r')) {
					echo "<font color='green'>Text File Not Yet Generated </font>";
				} else {
					echo "<font color='red'>Text File Generated</font>";
				}
				?>
				</td>
			</tr>
			<? } ?>
			<? if ($maillistcount <= 0) { ?>
			<tr bgcolor="#E9E9E9">
				<td class="title">Error Report</td>
				<td colspan=3> <b> Sorry, Mailer not genrated for above Concept and Criteria...! Check the Query </b></td>
			</tr>
			<? } ?>
			<!-- <tr>
				<td class="title" height='20px'></td>
				<td colspan=3></td>
			</tr> -->
			<tr bgcolor="#E9E9E9">
				<td class="title" colspan=4 align="center"> 
 <a href="gettemplate.php?catg=<?=$category?>" target=new>View Template</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
				<? if ($maillistcount > 0) { ?>
					<a href='' onClick="window.open('callcreatemail.php?catg=<?=$category?>&mtype=<?=$membertype?>&mailertype=<?=$mailerunsubtype ?>','mywindow','width=200,height=10,scrollbars=yes' )">Create Text File</a>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
					<!-- added by Anish for the javascript Validation -->
					
				<? } ?>
					<a href="checkfiles.php?opr=del&fname=<?=$category?>">Delete The Concept</a>
				</td>
			</tr>
			<tr>
				<td class="title" height='20px'></td>
				<td colspan=2></td>
			</tr>
			<tr bgcolor="#E9E9E9">
				<td class="title" colspan=2 align="center">Create Test File</td>
				<td colspan=4>
				<select class="smalltxt" id="testfile">
					<option value='EZH179860'>General(F)</option>
					<option value='CHR809452'>Christian(F)</option>
					<option value='CHR441101'>Christian(R)</option>
					<option value='MUS794608'>Muslim(F)</option>
					<option value='MUS935422'>Muslim(R)</option>					
					<option value='SIK100025'>Sikh</option>
					<option value='BDH100025'>Buddhist</option>
					<option value='VNI134962'>Vanniyar(R)</option>
					<option value='MUK100025'>Thevar</option>
					<option value='MDH111377'>Madhva(F)</option>
					<option value='MPI110659'>Mapilla(R)</option>
					<option value='MPI111693'>Mapilla(F)</option>
					<option value='RDY158300'>Reddy(R)</option>
				</select>
				<a href="Javascript:;" onclick=get_testfile("<?=$category?>")>Generate</a></td>
			</tr>
			<tr>
				<td class="title" height='10px'></td>
				<td colspan=3></td>
			</tr>

			<? if ($maillistcount > 0) { ?>
			<tr  bgcolor="FF6000">
			<td class="title" colspan=4 align="center">
			<a href="Javascript:;" onclick="disp_confirm('<?=$category?>','<?=date('Y-m-d H:i:s')?>','<?=$priority?>','<?=$mailertypeval?>','<?=$sendtype?>','<?=$membertype?>');">Send Mail To Live!</a>&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;
			</td>
			</tr>
			<? } ?>
			</table>
		</td>
	</tr>
	</table>

<!--Middle Area End-->		
</td>

</tr>
</table>

<? include "/home/cbsmailmanager/config/footer.php"; ?>