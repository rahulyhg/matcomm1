<?php

$varRootBasePath = "/home/product/community/ability";

include_once $varRootBasePath ."/conf/wsconf.cil14";
include_once $varRootBasePath ."/lib/clsMemcacheService.php";

$objMS = new MemcacheService;
$matriid = strtoupper($_REQUEST['matriid']);
$table = $_REQUEST['table'];
$reqMethod = $_SERVER['REQUEST_METHOD'];
if(!$matriid || $reqMethod != 'POST') {
	header("WWW-Authenticate: Basic realm=\"Protected Page: Enter your username and password for access.\"");
	header("HTTP/1.0 500 Bad request");
	$arResult['status'] = false;
	$arResult['error'] = "Bad request";
}
else {
	if(_ID_WS_ENABLE_AUTHENTICATION) {
		if($_SERVER['PHP_AUTH_USER'] === _ID_WS_HTTP_USER && $_SERVER['PHP_AUTH_PW'] === _ID_WS_HTTP_PASS) {
			$rs = $objMS->deleteKey($matriid, $table);
			$arResult['status'] = true;
			$arResult['message'] = $matriid ." deleted from memory ". $table;
		}
		else {
			header("WWW-Authenticate: Basic realm=\"Protected Page: Enter your username and password for access.\"");
			header("HTTP/1.0 401 Unauthorized");
			$arResult['status'] = false;
			$arResult['error'] = "401 - Authenticate Failure";
		}
	}
	else {
		$objMS->deleteKey($matriid, $table);
		$arResult['status'] = true;
		$arResult['message'] = $matriid ." deleted from memory ". $table;
	}
}

echo json_encode($arResult);

