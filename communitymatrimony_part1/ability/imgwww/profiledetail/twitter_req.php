<?php
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/cookieconfig.inc");

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];

function processRequest($url, $postFields = false){

	$con = curl_init($url);

	if($postFields) {
		curl_setopt ($con, CURLOPT_POST, true);
		curl_setopt ($con, CURLOPT_POSTFIELDS, $postFields);
	}

	curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($con, CURLOPT_TIMEOUT, 30);
	curl_setopt($con, CURLOPT_USERPWD, 'user:pass');

	$response = curl_exec($con);
	curl_close($con);

	if($response === false) {
		$response = '0';
	}

	echo $response;
}

if($sessMatriId != '') {
	$postValues = false;

	if($_REQUEST['updatetw'] == 'yes') {
		$postValues['action'] = 'settwitteraccountid';
		$postValues['matriid'] = $_REQUEST['matriid'];
		$postValues['twitterid'] = $_REQUEST['twitterid'];

		$url = $confValues['TWITTERSERVERNAME']."/twitterv2/";
	} else {
		$url = $confValues['TWITTERSERVERNAME']."/twitterv2/?action=gettwittermessages&matriid=".$_REQUEST['matriid']."&msgtype=1&msglimit=10";
	}

	processRequest($url, $postValues);
} else {
	echo 'Sorry, Your session has been expired. Please login again.';
}
?>