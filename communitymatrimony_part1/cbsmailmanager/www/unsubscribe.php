<?php
//*************************************
// File Name	: adminuser.php
// Code By		: Pradeep, Ashok kumar
//*************************************
error_reporting(0);
include "/home/cbsmailmanager/config/config.php";

$emailid    = mysql_escape_string(trim($_GET['email']));
$mailertype = mysql_escape_string(trim($_GET['mailertype']));
$membertype	= trim($_GET['membertype']); // Get membertype  from CBS or BM
$name		= strtolower(trim($_GET['name']));

$mailertoinsert = "|".$mailertype."|";
if ($mailertype != '' || $emailid != '') {
	//if($membertype ==1) { //For CBS member unsubscribe table
		
		$insert_sql = "insert into ".$tbl['mailunsubscribe']."(Email, MailerType,DateAdded ) values ('$emailid','$mailertoinsert',Now())";
		mysql_query($insert_sql);
		if (mysql_affected_rows() <= 0 ) {
			$select_sql = "select MailerType from ".$tbl['mailunsubscribe']." where Email='$emailid'";
			$select_res = mysql_query($select_sql);
			$select_row = mysql_fetch_array($select_res);
			$MailerTypehash = $select_row['MailerType'];
			$MailerTypearray = explode("|",$MailerTypehash);
			if(!(in_array($mailertype,$MailerTypearray))){
				$MailerTypehash = $MailerTypehash.$mailertype."|";
				$update_sql = "update ".$tbl['mailunsubscribe']." set MailerType='$MailerTypehash' where Email = '$emailid'";
				mysql_query($update_sql);
			}
		}
	//} 
	/*else { //For BM member unsubscribe table;
	    $dblink->dbClose();
		$bmdblink = new db();
		$bmdblink->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MAILSYSTEM']);
		$insert_sql = "insert into ".$tbl['unsubscribe']."(Email, MailerType,DateAdded ) values ('$emailid','$mailertoinsert',Now())";
		mysql_query($insert_sql);
		if (mysql_affected_rows() <= 0 ) {
			$select_sql = "select MailerType from ".$tbl['unsubscribe']." where Email='$emailid'";
			$select_res = mysql_query($select_sql);
			$select_row = mysql_fetch_array($select_res);
			$MailerTypehash = $select_row['MailerType'];
			$MailerTypearray = explode("|",$MailerTypehash);
			if(!(in_array($mailertype,$MailerTypearray))){
				$MailerTypehash = $MailerTypehash.$mailertype."|";
				$update_sql = "update ".$tbl['unsubscribe']." set MailerType='$MailerTypehash' where Email = '$emailid'";
				mysql_query($update_sql);
			}
		}
	} */
}

header('location: http://mailer.communitymatrimony.com/unsubscribe1.php?cname='.$name );

?>