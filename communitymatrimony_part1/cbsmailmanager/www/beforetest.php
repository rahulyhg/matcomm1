<?php
include "/home/cbsmailmanager/config/config.php";
//include_once "lib/authenticate.php";
include "/home/cbsmailmanager/config/header.php";
$fname = $_GET['fname'];
$type = $_GET['type'];
$submitdate = $_GET['dt'];
$priority = $_GET['pri'];
$logfile = ' > /home/cbsmailmanager/maillog/'.$fname.'.txt&'; 

//system ('php beforetestmail.php ' .escapeshellarg($fname)." ".escapeshellarg($type)." ".escapeshellarg($submitdate)." ".escapeshellarg($priority)." ".$logfile);

system ('php testsendmail.php ' .escapeshellarg($fname)." ".escapeshellarg($type)." ".escapeshellarg($submitdate)." ".escapeshellarg($priority)." ".$logfile);

echo "<a href='index.php'>Back</a>";
?>