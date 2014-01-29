<?php
/*****************************************************************
Author Name : C.Arunkumar
Created Date : 18-02-2010
File Description: This is used to send mails of elite admin usage report to respective heads.
******************************************************************/

/* Includes */
$DOCROOTBASEPATH = "/home/product/community/ability";
include_once($DOCROOTBASEPATH."/conf/dbinfo.inc");
include_once($DOCROOTBASEPATH."/lib/clsDB.php");
include_once($DOCROOTBASEPATH."/www/admin/includes/config.php");

if ($adminUserName=='') {
	echo 'Invalid Access';
	exit;
}

/* Variable declaration */
$flag=0;
$err="";
$updir = $DOCROOTBASEPATH."/www/admin/tmpfile/";
$attachment_array = array();

/* Table array declaration */
$varTable['ADMINMESSAGETRACK'] = 'adminmessagetrack';

$toemail = $_REQUEST['eid'];

$fileatt = $_FILES['fileatt']['name'];
$fileatt_type = $_FILES['fileatt']['type'];
$fileatt_name = $_FILES['fileatt']['name'];
$uploadfile1 = $updir.basename($_FILES['fileatt']['name']);

if(isset($_POST['sendmail']) && $fileatt!='' && $_FILES['fileatt']['size'] <= 2097152) {
	if($_FILES['fileatt']['type']=="image/jpeg" || $_FILES['fileatt']['type']=="image/gif" || $_FILES['fileatt']['type']=="application/pdf" || $_FILES['fileatt']['type']=="application/msword"){
		if(move_uploaded_file($_FILES['fileatt']['tmp_name'], $uploadfile1)) {
			array_push($attachment_array,$uploadfile1);
		}
	} else {
		$flag=1;
		$err="You can upload only pdf,jpeg,gif and doc file and the size of the file must be less than 2 MB ";
	}
}

print "<pre>";
print_r ($_FILES);
print_r ($_REQUEST);
print "</pre>";
if(isset($_POST['sendmail'])) {
//	exit;
}

if($_POST['sendmail'] && $flag!=1) {
	$attachmentflag=($fileatt!='')?1:0;

	$objMasterDB = new DB();
	$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);
	echo $objMasterDB->clsErrorCode;
	echo $objMasterDB->clsDBLink;

	$useridvalue = $_POST['userid'];
	$subject =  addslashes($_POST['subject']);
	$message = addslashes(nl2br($_POST['message']));
	$fromemail = get_support_user_email($objMasterDB);
	$to = base64_decode($_POST['toemail']);
	echo 'pemail:'.$to;
	$to = 'r_ashok2000@rediffmail.com';
	$ccId = '';
	$send = sendMail($fromemail, $to, $ccId, $subject, $message, $attachment_array);

	$varFields = array('User_Name','To_Email','Subject','Message','Date_Sent','Attachment_Flag');
	$varFieldsValues = array("'".mysql_real_escape_string($adminUserName)."'","'".mysql_real_escape_string($to)."'","'".mysql_real_escape_string($subject)."'","'".mysql_real_escape_string($message)."'","NOW()","'".mysql_real_escape_string($attachmentflag)."'");
	$varInsRes = $objMasterDB->insert($varTable['ADMINMESSAGETRACK'],$varFields,$varFieldsValues);
	//$qry = "insert into ".$varTable['ADMINMESSAGETRACK']." values('','".$useridvalue."','".$to."','".mysql_real_escape_string($subject)."','".mysql_real_escape_string($message)."',now(),'".$attachmentflag."')";
}


function get_support_user_email($objMasterDB='') {
	global $varTable, $adminUserName;

	$argFields 	   = array('Email');
	$argCondition  = "WHERE User_Name = '".$adminUserName."'";
	$varQryRes     = $objMasterDB->select($varTable['ADMINLOGININFO'],$argFields,$argCondition,1);
	$varQryRows    = $varQryRes[0]['Email'];
	//echo 'Email:'.$varQryRows;
	return $varQryRows;
}

?>
<html>
<head>
<title>Send Email</title>
<style>
.rfnt{
font-family:arial;
font-size:12px;
font-weight:bold;
}
</style>
<script>
function trim(s) {
	return s.replace(/^\s+|\s+$/, '');
}
function validatesendmail() {
	frm = document.frmsendemail;
	if(trim(frm.subject.value) == '') {
			alert("Enter Subject!");
			frm.subject.focus();
			return false;
	} else if(trim(frm.message.value) == '') {
			alert("Enter Message!");
			frm.message.focus();
			return false;
	} else {
			return true;
	}
}
</script>
</head>
<body>
<?php if((!isset($_POST['sendmail'])) || $flag==1) { ?>
		<form name='frmsendemail' method='post' enctype="multipart/form-data" onsubmit='return validatesendmail()'>
		<table>
		<tr>
			<td class=rfnt>Subject</td><td><input type='text' name='subject' size=40 value='' maxlength=100></input></td>
		</tr>
		<tr>
			<td class=rfnt>AttachFile</td><td><input type="file" name="fileatt"  id="at1"></td>
			<?if($err!=""){?><td  align=center style="font:bold 12px arial;color:#ff0000;"><?=$err?></td><?}?>
		</tr>

		<tr>
			<td class=rfnt>Message</td><td><textarea name='message' rows=15 cols=40></textarea></td>
		</tr>
		<tr>
			<td colspan=2 align=center><input type=submit name=sendmail value='Send Email'></td>
		</tr>

		</table>
		<input type=hidden name=toemail value='<?=$toemail;?>'>
		<input type=hidden name=userid value='<?=$adminUserName;?>'>

</form>
<? } else {
	echo "<center><span class=rfnt>Mail Sent Successfully!</span></center>";
	echo "<br>";
	echo "<center><input type=button onClick='javascript:self.close()' name=close value='Close'></input></center>";
}
?>
</body>
</html>
<?
function sendMail($fromId, $toId, $ccId, $subject, $message, $attachment_array) {

	$email_from = $fromId; // Who the email is from
	$email_subject = $subject; // The Subject of the email
	$email_txt = $message; // Message that the email has in it
	$email_cc = $ccId;

	$headers = "From: ".$email_from."\n";
	$headers .= "Cc: ".$email_cc."\n";
	$headers .= "Reply-To: <".$email_from.">" . "\n";
	$semi_rand = md5(time());
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
	$headers .= "MIME-Version: 1.0\n" .
	"Content-Type: multipart/mixed;\n" .
	" boundary=\"{$mime_boundary}\"";

	$email_message = "";
	$email_message .= $email_txt."\n\n";
	$email_message .= "This is a multi-part message in MIME format.\n\n" .
	"--{$mime_boundary}\n" .
	"Content-Type:text/html; charset=\"iso-8859-1\"\n" .
	"Content-Transfer-Encoding: 7bit\n\n" .
	$email_message . "\n\n";

	foreach($attachment_array as $filename) {
		$fileatt = $filename; // Path to the file
		$fileatt_type = "application/octet-stream"; // File Type
		$fileatt_name = $filename; // Filename that will be used for the file as the attachment
		$pos =  strripos($fileatt_name,"/");
		$fileatt_name =	substr($fileatt_name,$pos+1);
		$file = fopen($fileatt,'rb');
		$data = fread($file,filesize($fileatt));
		fclose($file);
		$data = chunk_split(base64_encode($data));
		$email_message .= "--{$mime_boundary}\n" .
		"Content-Type: {$fileatt_type};" .
		" name=\"{$fileatt_name}\"\n" .
		//"Content-Disposition: attachment;" .
		//" filename=\"{$fileatt_name}\"\n\n" .
		"Content-Transfer-Encoding: base64\n\n" .
		$data . "\n\n";
		//."--{$mime_boundary}--\n\n";
	}

	$email_message .="--{$mime_boundary}--\n\n";
	if(stripos($toId,',')) {
		$to = explode(',',$toId);
	}
	$i=1;
	if(is_array($to)) {
		foreach($to as $email_to) {
			$ok = @mail($email_to, $email_subject, $email_message, $headers);
			if($ok)
				$i++;
		}
		$i=$i-1;
	} else {
		$email_to = $toId; // Who the email is too
		$ok = @mail($email_to, $email_subject, $email_message, $headers);
	}

	if($i>=1){
		return $i;
	} else {
		return 0;
	}
}

?>