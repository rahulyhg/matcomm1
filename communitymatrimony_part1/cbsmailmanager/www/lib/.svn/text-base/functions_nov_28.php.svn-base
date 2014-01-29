<?php
//******************************************************************
// AUTHOR		: ASHOK KUMAR
// FILENAME		: FUNCTIONS.PHP
// PROJECT		: CAMPAIGN ADMIN CONTROL MANAGEMENT
// DATE			: 21-06-2005
// DISCRIPTION	: FILE CONTAINS FUNCTIONS USING ON THIS PROJECT
//******************************************************************

// Format the date and time
function DateTimeStamp($regdate){
	$datetime=split(" ",$regdate);
	$date = split("-",$datetime[0]);
	$time = split(":",$datetime[1]);
	list($year,$month,$day)=$date;
	$dt = @date("d-M-y",mktime(0,0,0,$month,$day,$year));
	return $dt;
}

function DateTimeStamp1($regdate){
	$datetime=split(" ",$regdate);
	$date = split("-",$datetime[0]);
	$time = split(":",$datetime[1]);
	list($year,$month,$day)=$date;
	list($hr,$mn,$sc)=$time;
	$dt = @date("d-M-y H:i:s",mktime($hr,$mn,$sc,$month,$day,$year));
	return $dt;
}

// Fetching datas from inc arrays and puts into select options...
function select_arrayhash($arryhashname, $in='') {
	global $$arryhashname;
	foreach ($$arryhashname as $key => $value) {
		if ($in == $key) {
			$selected = 'Selected';
		} else {
			$selected = '';
		}
		echo "<option value=\"$key\" $selected>$value</option>";
	}
}

// Fetching datas from inc arrays ...
function get_from_arryhash ($arryhashname, $in='') {
	global $$arryhashname;
	if (array_key_exists($in,$$arryhashname)) {
		return ${$arryhashname}[$in];
	} else {
		return '-';
	}
}

function query_execute ($query,$opr) {
	mysql_query ($query);
	$qry_res = mysql_affected_rows();
	if ( $qry_res == -1 ) {
		$str_res = "<img src='images/icon1.gif' border=0 width=15 height=15> <font color=black>";
		if ( $opr == 'add' ) {
			$str_res .= "New Mailer is not addedd... ";
		} elseif ( $opr == 'update' ) {
			$str_res .= " Mailer is not updated properly... ";
		} elseif ( $opr == 'del' ) {
			$str_res .= "Given Mailer detail is not removed properly... ";
		}
	} else {
		$str_res = "<img src='images/icon1.gif' border=0 width=15 height=15> <font color=black>";
		if ( $opr == 'add' ) {
			$str_res .= "New Mailer is added... ";
		} elseif ( $opr == 'update' ) {
			$str_res .= "Mailer details updated... ";
		} elseif ( $opr == 'del' ) {
			$str_res .= "Given Mailer is removed... ";
		}
	}
	$str_res .= "</font>";
	return $str_res;
}

function record_already_exists($id, $field, $tbl_name) {
	global $tbl, $dblink;

	$sql = "select * from $tbl_name where $field = '$id'";
	$res = mysql_query($sql);
	$row = mysql_fetch_array ($res);
	$num_rows = mysql_num_rows($res);
	if ( $num_rows <= 0 ) {
		return 0; // Record not exists
	} else {
		return 1; // Record exists
	}
}

function select_month($in='') {
	global $MON;
	foreach ($MON as $key => $value) {
		if ($in == $key) {
			$selected = 'Selected';
		} else {
			$selected = '';
		}
		echo "<option value=\"$key\" $selected>$value</option>";
	}
}

// Select Option Query Function...
function select_option ($fld1='',$fld2='',$table='',$orderby='',$in='',$wherefld='',$whereval='') {
	if ($wherefld != '' && $whereval != '') {
		$sql = "select $fld1, $fld2 from $table where $wherefld = '$whereval' order by $orderby";
	} else {
		$sql = "select $fld1, $fld2 from $table order by $orderby";
	}
	//echo $sql;
	$res = mysql_query ($sql);
	while ( $row = mysql_fetch_array($res) ) {
		if ( $row[$fld1] == $in ) {
			$selected = 'selected';
		} else {
			$selected = '';
		}
		echo "<option value=\"".$row[$fld1]."\" $selected>".$row[$fld2]."</option>";
	}
}

function select_category($in='') {
	global $tbl, $dblink;

	$sql = "select distinct Category, CategoryName from ".$tbl['mailer']." order by Id ";
	$res = mysql_query($sql);
	$num_rows = mysql_num_rows($res);
	while($row = mysql_fetch_array ($res)) {
		if ($in == $row['Category']) {
			$selected = 'Selected';
		} else {
			$selected = '';
		}
		echo "<option value=\"".$row['Category']."\" $selected>".$row['CategoryName']." [ ".$row['Category']." ] "."</option>";
	}
}

function get_value($table,$fld1,$fld2,$id) {
	global $tbl,$dblink;
 	$sql = "select $fld2 from $table where $fld1 = $id";
	$res = mysql_query($sql);
	$row = mysql_fetch_array ($res);
	return $row[$fld2];
}

function getcateginfo($category='') {
	global $tbl,$dblink;
 	$sql = "select * from ". $tbl['mailer'] . " where Category = '$category'";
	$res = mysql_query($sql);
	$row = mysql_fetch_array ($res);
	return $row;
}

function checkbouncemailexists($emailid,$catg) {
	global $tbl,$dblink;
	$sql = "select * from ". $tbl['bouncemail'] ." where Email = '$emailid' ";
	$res = mysql_query($sql);
	$cnt = mysql_num_rows ($res);
	if ($cnt <= 0) {
		return 0;
	} else {
		return 1;
	}
}

function checkunsubscribeexists($emailid,$catg) {
	global $tbl,$dblink;

	$catg = substr($catg,0,2);

	$sql = "select * from ". $tbl['unsubscribe'] ." where Email = '$emailid' ";
			if ($catg == 'ME') {
				$sql .= " and MatriExpressSubscribe = '1' ";
			} elseif ($catg == 'MU') {
				$sql .= " and MemberUpdateSubscribe = '1' ";
			} elseif ($catg == 'PE') {
				$sql .= " and PaymentExpirySubscribe = '1' ";
			} elseif ($catg == 'LR') {
				$sql .= " and LoginReminderSubscribe = '1' ";
			} elseif ($catg == 'GP') {
				$sql .= " and GenralPromotionSubscribe = '1' ";
			} elseif ($catg == 'EP') {
				$sql .= " and ExternalPromotionSubscribe = '1' ";
			} elseif ($catg == 'PR') {
				$sql .= " and PartlyRegisterSubscribe = '1' ";
			} elseif ($catg == 'CJ') {
				$sql .= " and ClickJobsSubscribe = '1' ";
			} elseif ($catg == 'IP') {
				$sql .= " and IndianPropertySubscribe = '1' ";
			}			
			
	$res = mysql_query($sql);
	$row = mysql_fetch_array ($res);
	$cnt = mysql_num_rows ($res);
	if ($cnt <= 0) {
		return 0;
	} else {
		return 1;
	}
}

function frameunsubscribesql($catg) {
	global $tbl,$dblink;

	$catg = strtoupper(substr($catg,0,2));

	$sql = "select Email from ". $tbl['unsubscribe'] ." where ";
			if ($catg == 'ME') {
				$sql .= " MatriExpressSubscribe = '1' ";
			} elseif ($catg == 'MU') {
				$sql .= " MemberUpdateSubscribe = '1' ";
			} elseif ($catg == 'PE') {
				$sql .= " PaymentExpirySubscribe = '1' ";
			} elseif ($catg == 'LR') {
				$sql .= " LoginReminderSubscribe = '1' ";
			} elseif ($catg == 'GP') {
				$sql .= " GenralPromotionSubscribe = '1' ";
			} elseif ($catg == 'EP') {
				$sql .= " ExternalPromotionSubscribe = '1' ";
			} elseif ($catg == 'PR') {
				$sql .= " PartlyRegisterSubscribe = '1' ";
			} elseif ($catg == 'CJ') {
				$sql .= " ClickJobsSubscribe = '1' ";
			} elseif ($catg == 'IP') {
				$sql .= " IndianPropertySubscribe = '1' ";
			}			
			
	return $sql;
}

function file_rec_count ($catg='') {
	$cnt = 0;

	$maillist_filename = 'mlistfiles/'.$catg.'mail.txt';
	if (file_exists($maillist_filename)) {
		$lines = file($maillist_filename);
		if (is_array($lines)) {
		$cnt = count($lines);
			if ($cnt != 0 && $cnt != '') {
				return $cnt;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	} else {
		return 0; //return 'Mail list file not exists...';
	}
}

function test_file_rec_count () {
	$cnt = 0;

	$maillist_filename = 'mlistfiles/testmaillist.txt';
	if (file_exists($maillist_filename)) {
		$lines = file($maillist_filename);
		if (is_array($lines)) {
		$cnt = count($lines);
			if ($cnt != 0 && $cnt != '') {
				return $cnt;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	} else {
		return 0; //return 'Mail list file not exists...';
	}
}
?>

