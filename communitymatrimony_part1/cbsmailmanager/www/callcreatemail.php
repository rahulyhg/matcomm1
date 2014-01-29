<?php
//*************************************
// File Name	: callcreatemail.php
// Code By		: Ashok kumar
//*************************************
error_reporting(0);

$category   = $_GET['catg'];
$membertype = $_GET['mtype'];
$mailertype = $_GET['mailertype'];
system ('php /home/cbsmailmanager/www/syscreatemaillist.php ' .escapeshellarg($category)."  ".escapeshellarg($membertype)."  ".escapeshellarg($mailertype));
echo " Text File Generated <br>";
echo "File Name :".$category."mail.txt";

?>