<?php
//**********************************************************************
// File Name	: authenticate.php
// Code By		: Ashok kumar
//**********************************************************************

//session start
session_start();

if ( $_POST['login_submit'] == 'Login' ) {

	$aff_login = trim($_POST['aff_login']);
	$aff_pwrd = trim($_POST['aff_pwrd']);

	$sql = "select * from ".$tbl['adminuser']." where user_name='$aff_login' and pass_wrd='$aff_pwrd'";
	$res=mysql_query($sql);
	$row = mysql_fetch_array($res);
	if ( mysql_num_rows($res) > 0 ) {
		$_SESSION['auth'] = 1;
		$_SESSION['user'] = $row['id'];
		$_SESSION['access'] = $row['previlage'];
		$_SESSION['siteid'] = $row['sites'];
		$_SESSION['module'] = 'admin';
		$auth = $_SESSION['auth'];
		$user = $_SESSION['user'];
		$access = $_SESSION['access'];
		$module = $_SESSION['module'];
	} else {
		$_SESSION['auth'] = 0;
		$_SESSION['access'] = 0;
		$_SESSION['module'] = '';
		$auth = $_SESSION['auth'];
		$module = $_SESSION['module'];
		$ret_res = "Invalid Login";
		include "/home/cbsmailmanager/config/header.php";
		include_once "login.php";
		include "/home/cbsmailmanager/config/footer.php";
		exit;
	}
}

if ($_SESSION['module'] == '' ) {
	$_SESSION['auth'] = 0;
	$phase = '';
}

if ( $_SESSION['auth'] == '' ) {
	//$auth = 0;
	$_SESSION['auth'] = 0;
}

if ( $_SESSION['auth'] != 1 ) {
	$ret_res = "";
	//echo "inside...";
	include "/home/cbsmailmanager/config/header.php";
	include_once "login.php";
	include "/home/cbsmailmanager/config/footer.php";
	exit;
}


?>
