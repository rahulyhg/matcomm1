<?php
/*  ************************************************************************************** 
FILENAME				supportconfig.php     								  
AUTHOR					Vijayakanth						 
PROJECT					Mail manager
DESCRIPTION			photoremainder,delete-email-ids page                 			  
****************************************************************************************  */
//photoremainder,delete-email-ids page.
error_reporting(0);
include '/home/mailmanager/config/config.php';
$pagenum= $_GET['pagenum'];
$endnum=$_GET['endnum'];
$InterfaceType=$_GET['interfacetype'];
?>
<html>
	<head>
		<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
		<title>Mail Manager</title>
		<script language="javascript" type="text/javascript" src="js/validation.js"></script>
	</head>
<body bgcolor="#EEF1F3" topmargin="0" leftmargin="0" MARGINHEIGHT=0 MARGINWIDTH=0>
	<table border="0" cellspacing="0" cellpadding="0" width=100% height="100%">
		<tr>
			<td bgcolor="#5A97CD" >
			<?php include 'header.php';?>
			</td>
		</tr>
		<tr>
			<td bgcolor = "#EEF1F3" height="90%">
				<table  border="0" height="100%" width="100%"> 
					<tr>
						<td valign="top" width = "10%" align="center">
							<?php include 'menu.php';?>
						</td>
						<td align="center" valign="top"  bgcolor = "#FFFFFF">
						<? 	//list emailid
						if($_GET['type']=='list') {	  			
							list_emailid();
						} if($_GET['type']=='Delete' && !($_POST['Delete']=='Delete')) { 
							//checking the type whether "delete" or not
							remove_emailid();
						} else if($_GET['type']=='photo') {	 
							//checking the type whether "photo" or not
							photoreminder();
							//checking the type
						}else if($_GET['type']=='insert' && !($_POST['Insert']=='Insert')) {
							insert_emailid();						
						} if($_POST['Insert']=='Insert') {
							//insert emailid to db
							insert();
						} if($_POST['Delete']=='Delete') { 
							//delete the mailid from db
							deleteid();	
						} if($_GET['id']) {								
							delete_emailid();
							list_emailid();
						} 
						if($_GET['type']=='blockem'  && !($_POST['Insert']=='Insert')) {
							insert_emailid();												
						}
						?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td bgcolor="#5A97CD" height="5%">
			<?php include 'footer.php';?>
			</td>
		</tr>
	</table>
</body>
</html>
<?
function delete_emailid() {
	$deleteid="Delete from bulkmail_successmembers where EmailID='".$_GET['id']."'";
	if(mysql_query($deleteid))
		echo "EmailID "." ".$_GET['id']." "."Deleted <br /><br />";
	else
		echo "EmailID not Deleted <br /><br />";
}
function list_emailid() { 
	
	$pagenum= $_GET['pagenum'];
	$endnum=$_GET['endnum'];	
	$q="Select count(ID) as cnt from  bulkmail_successmembers";
	$count=mysql_query($q);
	$num=mysql_fetch_array($count);	
	$last=$num['cnt'];
	//echo $last;
	$lang="";
	$lang.='<form method="post"><table border="0">';
	$lang.='<tr><td>Enter the email id</td><td><input type="text" name="id"></td><td><input type="submit" value="Search" name="Search"></td></tr>';
	$lang.='</table></form>';
	echo $lang;
	echo'<br /><br />';
	if($_POST['Search']=='Search') {
		search();
	} else { 		
		$html="";
		$html ='<font style="font:bold 12px verdana;color:#000000;">List Of EmailId</font> <br /><br />';
		$html.='<form method="post"><table border="0" cellpadding="4" cellspacing="2" bgcolor="#5A97CD" width="300"><tr bgcolor="#ffffff"><td style="font:bold 12px verdana;color:#000000;">Email Id</td><td style="font:bold 12px verdana;color:#000000;">Option</td></tr>';		
		$perpage = 100;
		$pagenum = $_GET['pagenum']>0?$_GET['pagenum']:0; 		

		$select="Select EmailID from bulkmail_successmembers order by EmailID asc limit ".$pagenum.", ".$perpage;		

		$row=mysql_query($select);	
		
		while($result=mysql_fetch_array($row)) {  			

			$html.='<tr bgcolor="#ffffff"><td>'.$result['0'].'</td>';
			$html.='<td><a href="supportconfig.php?interfacetype='.$_GET['interfacetype'].'&id='.$result['0'].'&pagenum='.$_GET['pagenum'].'" style="color:#ff0000;">Delete</a></td></tr>';
			
		}
		$html.='</table></form>';
		echo $html;
		if($pagenum >0) 
			echo '<a href="supportconfig.php?interfacetype='.$_GET['interfacetype'].'&type=list&pagenum='.($pagenum-$perpage).'">Previous</a>';
		if(($pagenum+$perpage)<$last)
		echo '&nbsp;&nbsp;&nbsp;<a href="supportconfig.php?interfacetype='.$_GET['interfacetype'].'&type=list&pagenum='.($pagenum+$perpage).'">Next</a>';
		
	}
}
function remove_emailid() {
?>
<table border="0"  width="100%" height="100%">
	<tr height=15px >
		<td bgcolor="#5A97CD" colspan=2 >
			<font size='5'>Delete-Success-Story-Emailids</font>
		</td>
	</tr>	
	<tr>
		<td>
			<form method="post"  name="details" id="delete" onsubmit="return validate(this)">
				<table border=0  cellspacing="4" cellpadding="4" width="100%" style="border:1px solid #3399FF;padding-bottom:150px;" >
					<tr>
						<td height="280" style="font:bold 12px arial;color:#000000;">
								Enter the Emailid to be deleted
						</td>
						<td><textarea name="email" rows="10" cols="80"></textarea><br><font size=1 color=#CC0000> Email-ID's should be comma( , ) seperated</font></td>
					</tr>
					<tr>
						<td align="center" colspan="2" style="padding-bottom:10px;"><INPUT TYPE="submit" name="Delete" value="Delete"></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>
<?
}
function deleteid() {
	global $InterfaceType;
		$email=trim($_POST['email']);
	$arrEmail = explode(",",$email);	
	echo '<table border=0 bgcolor="#5A97CD" ><tr>
	<td width="75px" align="center" style="font:bold 12px arial;"> EMailId</td>
	</tr></table><br /><br />
	<a href="supportconfig.php?interfacetype='.$InterfaceType.'&type=Delete">Back</a><br /><br />';
	foreach($arrEmail as $value) {
		mysql_escape_string;
		$select="select EmailID from bulkmail_successmembers where EmailID='".$value."' ";
		$count = mysql_num_rows(mysql_query($select));
		//checking wheather already available
		if($count) {
			if($value!="") {
				$q="delete from bulkmail_successmembers where EmailID='".$value."'";
				if(mysql_query($q))	{
					echo "<table border='0' align='center'><tr><td style='font:bold 12px arial;color:#000000;'>$value DELETED <br /></td></tr></table>";
				} else {
					echo "<table border='0' align='center'><tr><td style='font:bold 12px arial;color:#000000;'>$value Not Deleted <br /></td></tr></table>";
				}
			}
		} else {
			echo  "
			<table border='0' align='center'>
			<tr>
			<td style='font:bold 12px arial;color:#000000;'>$value Not Available in Database <br /></td></tr></table>";
		}
	}
	//echo "<a href='home.php?interfacetype=$InterfaceType'>Back</a>";
} 
function photoreminder() {
?>
<table border=0  width="100%">
	<tr height=15px >
		<td bgcolor="#5A97CD" colspan=2><font size='5'>Photo-Upload-Remainder</font></td>
	</tr>
	<tr>
		<td height=10px>
		<?//insert the details in db AND SEND MAIL
		if(!($_POST['submit'])) {?>
			<form method="post"  name="details" id="photo" onsubmit="return validate(this)">
				<table border="0" cellspacing="4" cellpadding="4" style="border:1px solid #3399FF;padding-bottom:150px;" align="center" width="100%" height="100%">
					<tr>
						<td style="font:bold 12px arial;color:#000000">Fromid:</td>
						<td><input type="text" name="toid" style="width:180px"></td>
					</tr>
					<tr>
						<td style="font:bold 12px arial;color:#000000">To-IDs:</td>
						<td><textarea name="email" rows="10" cols="80"></textarea></td>
					</tr>
					<!-- <tr><td style="font:bold 12px arial;color:#000000">Subject:</td><td><input type="text" name="subject"  style="width:180px"></td></tr>
					<tr><td style="font:bold 12px arial;color:#000000">Enter the HTMLContent Here:</td><td><textarea name="body" rows="10" cols="80"></textarea></td></tr> -->
					<tr>
						<td align="center" colspan="2"><input type="submit" name="submit" value="submit">
						</td>
					</tr>
				</table>
			</form>
		<? }
		$count=0;
		//$Content=$_POST['body'];
		$Content="
		Dear Member,
		 
		We are immensely pleased that you have found your life partner through our matrimonial service. We have facilitated many such unions for life and are in the Limca Book of Records for record number of documented marriages online. With your success story a part of the record it would be wonderful to share it with all our members.

		To post your success story and feature your happiness as part of the record on our website, we require your marriage photo or any photo in which you are together as a couple. 

		Please e-mail your photo to <A HREF=' mailto:success@bharatmatrimony.com'>success@bharatmatrimony.com</A> to be a part of this great record that you helped  create.


		Wishing you a happy married life

		Warm Regards,
		Customer Care Team
		BharatMatrimony.com";
		$order   = array("\r\n", "\n", "\r");
		$replace = '<br />';
		// Processes \r\n's first so they aren't converted twice.
		$message = str_replace($order, $replace, $Content);
		$Email=$_POST['email'];
		$FromID=$_POST['toid'];
		//$Subject=$_POST['subject'];
		$Subject="Get featured in the record you helped create!";
		$arrLines = explode("\n",$_POST['email']);

		$headers="";
		$headers .= "From:".$FromID."\n";
		$headers .= "X-Mailer: PHP mailer\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "Reply-To:success@bharatmatrimony.com\n";

		foreach($arrLines as $key=>$value) {	
			$arrEmail = explode(",",$value);	
			foreach($arrEmail as $key1=>$value1) {
				if(trim($value1)!='') {
					if(eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,3})?(\.[a-zA-Z]{2,3})?$', trim($value1)))	{
						if(mail($value1, $Subject, $message, $headers))	{				
							$count=$count+1;				
						}				
					}	
					else {
						echo "<div style='float:left;font:bold 12px arial;color:#000000;padding-top:30px;padding-left:360px;'>Email-ID"." ".$value1." " ."InCorrect<br /></div> ";
					}
				}
			}	
		}
		if(($_POST['submit'])) {
			mysql_escape_string;
			$q="insert into bulkmail_photoremdetails(Content,Toid,Date) values('".$message."','".$Email."',now())";
			mysql_query($q);
			echo "<table border='0' align='center'><tr><td bgcolor='#5A97CD' style='font:bold 12px arial;'>Your Mail Has Been Sent</td></tr><tr><td style='font:bold 12px arial;color:#000000;'>NUMBER OF MAIL SEND"." ".$count."</div></td></tr></table>"; 
		}
?>
		</td>
	</tr>
</table>
<?
}
function insert_emailid() {
?>
<table border="0"  width="100%" height="100%">
	<tr height=15px >
		<td bgcolor="#5A97CD" colspan=2 >
		<?if($_GET['type']=='blockem' ){?>
		<font size='5'>Block-Emailids</font>
		<?}
			else{?>
				<font size='5'>Insert-Success-Story-Emailids</font>
				<?}?>			
		</td>
	</tr>	
	<tr>
		<td>
			<form method="post"  name="details" id="insert" onsubmit="return validate(this)">
				<table border=0  cellspacing="4" cellpadding="4" width="100%" style="border:1px solid #3399FF;padding-bottom:150px;" >
				<?if($_GET['type']=='blockem'){?>
				<tr><td  style="font:bold 12px arial;color:#000000;">Select the Type</td><td><select name='blockid'>
						<option value="1">EliteMatrimony-Email Blocking</option>
						<option value="2">FreeToPaid-EmailBlocking</option>
						<option value="3">All-Promos-Email Blocking</option>
						<option value="4">All-Site-Related-Email Blocking</option>
				</select></td></tr>
				<?}?>
					<tr>
						<td height="280" style="font:bold 12px arial;color:#000000;">
								Enter the Emailid to be inserted
						</td>
						<td ><textarea name="email" rows="10" cols="80"></textarea><br><font size=1 color=#CC0000> Email-ID's should be comma( , ) seperated</font></td>
					</tr>
					<tr>
						<td align="center" colspan="2" style="padding-bottom:10px;"><INPUT TYPE="submit" name="Insert" value="Insert"></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>
<?
}
function insert() {
	global $InterfaceType;
	$insertcount=0;
	$email=trim($_POST['email']);
	$arrEmail = explode(",",$email);	
	echo '<table border="0" align="center"  bgcolor="#5A97CD">
	<tr>
	<td align="center" width="75px" style="font:bold 12px arial;">EMailId</td>
	</tr>
	</table><br /><br />';
	if($_GET['type']=='blockem'){
		echo '<a href="supportconfig.php?interfacetype='.$InterfaceType.'&type=blockem">Back</a><br /><br />';
	}
	else{
		echo '<a href="supportconfig.php?interfacetype='.$InterfaceType.'&type=insert">Back</a><br /><br />';	
	}
	 
	foreach($arrEmail as $value1) {
		$value=trim($value1);
		mysql_escape_string;
		if($_GET['type']=='blockem'){
			$select="select Email from mailer_blockedlist where Email='".$value."' ";
			
		}
		else{
		$select="select EmailID from bulkmail_successmembers where EmailID='".$value."' ";
		
		}
		$count = mysql_num_rows(mysql_query($select));
		if(!($count)) {
			if($value!=""  && eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,3})?(\.[a-zA-Z]{2,3})?$', trim($value)))	{
				if($_POST['blockid'])
					{
					$mailertype=$_POST['blockid'];
					$q="insert into mailer_blockedlist(Email,Addedon,MailerType) values('".$value."',now(),".$mailertype.")";

					}
				else
				{
				$q="insert into bulkmail_successmembers(EmailID) values('".$value."')";
				}
				if(mysql_query($q))	{
					$insertcount=$insertcount+1;
				} else {
					echo "<div style='font:bold 12px arial;color:#000000;padding-top:60px;padding-left:350px;'>EMAILId Not Inserted</div>";
				}
			} else echo "$value Incorrect";
		} else {
		 echo "<table border='0'><tr><td style='font:bold 12px arial;color:#000000;'>$value Available in Database <br /></td></tr></table>";
		}
	}
	echo "<table border='0' align='center' style='padding-top:20px;'><tr><td bgcolor='#5A97CD' style='font:bold 12px arial;'>Your EMailID Has Been Inserted</td></tr><TR><TD style='font:bold 12px arial;color:#000000;'>NUMBER OF EMAILId Inserted"." ".$insertcount."</div></td></tr></table>"; 
	//echo "<a href='home.php?interfacetype=$InterfaceType'>Back</a>";
}
function search() {
	$id =trim($_POST['id']);
	$select="Select EmailID from bulkmail_successmembers where EmailID like '".$id ."%' order by EmailID asc";
	$row = mysql_query($select);
	$count = mysql_num_rows($row);
	if($count > 0)	{
		echo "<b>Email Id available</b> <br /> <br />";
		$html="";	
		$html.='<form method="post"><table border="0" cellpadding="4" cellspacing="2" bgcolor="#5A97CD" width="200"><tr bgcolor="#ffffff"><td style="font:bold 12px verdana;color:#000000;">S.No</td><td style="font:bold 12px verdana;color:#000000;">Email Id</td><td style="font:bold 12px verdana;color:#000000;">Option</td></tr>';
		$i=1;
		while($result = mysql_fetch_array($row)) {
			$html.='<tr bgcolor="#ffffff"><td>'.$i.'</td><td>'.$result['EmailID'].'</td>';
			$html.='<td><a href="supportconfig.php?interfacetype='.$_GET['interfacetype'].'&id='.$result['EmailID'].'" style="color:#ff0000;">Delete</a></td></tr>';
			$i++;
		}
		$html.='</table></form>';
		echo $html;
	} else
		echo "<b>Email Id not available</b><br /><br />"; 
}
?>