<?php

/**
 * @file
 * File: index.php
 * Version: 1.1
 *
 *  Creator: Ilayaraja M
 *  Created On: Oct 28, 2009
 *  Updated On: Oct 29, 2009
 *
 *  Purpose : To server the request from client.
 *
 *
**/


$docRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$docRoot = ($docRoot == "")?"/home/product/community/ability":$docRoot;

include_once $docRoot ."/lib/twitter/clsTwitterServer.php";
include_once $docRoot ."/conf/twitter/conf.php";

function processRequest() {
	$twitterApi = new TwitterServer;

	$rs = $twitterApi->processRequest();

	echo $rs;
}

if(_ID_ENABLE_AUTHENTICATION) {
	if($_SERVER['PHP_AUTH_USER'] === _ID_HTTP_USER && $_SERVER['PHP_AUTH_PW'] === _ID_HTTP_PASS) {
		processRequest();
	}
	else {
		header("WWW-Authenticate: Basic realm=\"Protected Page: Enter your username and password for access.\"");
		header("HTTP/1.0 401 Unauthorized");
		$arResult['status'] = false;
		$arResult['Error'] = "401 - Authenticate Failure";
		echo json_encode($arResult);
	}
}
else {
	processRequest();
}
