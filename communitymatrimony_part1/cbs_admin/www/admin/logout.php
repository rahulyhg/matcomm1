<?php

// FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath."/www/admin/includes/config.php");

//GET DOMAIN NAME
$confDomainName	= $confValues["DOMAINNAME"];

//UNSET SESSION
setcookie("adminLoginInfo",'', '0', '/',$confDomainName);
$confUserType="";
setcookie("loginPrivilege",'','0','/',$confDomainName);
unset($_COOKIE['adminLoginInfo']);
unset($_COOKIE['loginPrivilege']);

echo "You have logged out successfuly...";

header("Location:http://".$confValues['SERVERURL']."/admin/index.php?act=login");

?>