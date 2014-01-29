<?php
//*************************************
// File Name	: adminuser.php
// Code By		: Pradeep, Ashok kumar
//*************************************

include "/home/cbsmailmanager/config/config.php";
//include_once "lib/authenticate.php";

$catg		= $_GET['catg'];
$membertype = $_GET['mtype'];

$sql = "select BodyContent from " . $tbl['mailer'] . " where Category = '$catg' ";
$res = mysql_query ($sql);
$row = mysql_fetch_array ($res);

echo stripslashes($row['BodyContent']);

?>