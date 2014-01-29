<?php
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');


function processRequest($url, $postFields = false){

	$con = curl_init($url);

	if($postFields) {
		curl_setopt ($con, CURLOPT_POST, true);
		curl_setopt ($con, CURLOPT_POSTFIELDS, $postFields);
	}

	curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($con, CURLOPT_USERPWD, 'user:pass');

	$response = curl_exec($con);
	curl_close($con);

	if($response === false) {
		$response = '0';
	}

	echo $response;
}

$postValues = false;

if($_POST['msgall'] == 'yes') {
	$url = $confValues['TWITTERSERVERNAME']."/twitterv2/?action=getallmessages&msgtype=0&msgstart=".$_POST['startlt']."&msgend=".$_POST['endlt'];
} else if($_POST['msgformatriid'] == 'yes') {
	$url = $confValues['TWITTERSERVERNAME']."/twitterv2/?action=gettwittermessages&msgtype=0&matriid=".$_POST['matriid'];
} else if($_POST['msgvalidate'] == 'yes') {
	$postValues['action'] = 'setmessageapproval';
	$postValues['amsgid'] = $_POST['chkmsgid'];
	$postValues['namsgid'] = $_POST['unchkmsgid'];
	$postValues['verifiedby'] = $_POST['verifiedby'];

	$url = $confValues['TWITTERSERVERNAME']."/twitterv2/";
} else {
	$url = $confValues['TWITTERSERVERNAME']."/twitterv2/?action=getallmessages&msgtype=0";
}

processRequest($url, $postValues);
?>