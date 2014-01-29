<?php
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/ip.cil14');
include_once($varRootBasePath.'/conf/config.cil14');

function processRequest($url, $postFields = false){
	global $varTwitterUserName,$varTwitterPassword;
	$con = curl_init($url);

	if($postFields) {
		curl_setopt ($con, CURLOPT_POST, true);
		curl_setopt ($con, CURLOPT_POSTFIELDS, $postFields);
	}

	curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($con, CURLOPT_USERPWD, $varTwitterUserName.':'.$varTwitterPassword);

	$response = curl_exec($con);
	curl_close($con);

	if($response === false) {
		$response = '0';
	}

	echo $response;
}

$postValues = false;

if($_REQUEST['msgall'] == 'yes') {
	$url = $confValues['TWITTERSERVERNAME']."?action=getportalmessages&portalid=". $confValues['TWITTERPORTALID'] ."&msgtype=0&msgstart=".$_REQUEST['startlt']."&msgend=".$_REQUEST['endlt'];
} else if($_REQUEST['msgformatriid'] == 'yes') {
	$url = $confValues['TWITTERSERVERNAME']."?action=gettwittermessages&msgtype=0&matriid=".$_REQUEST['matriid'];
} else if($_REQUEST['msgvalidate'] == 'yes') {
	$postValues['action'] = 'setmessageapproval';
	$postValues['amsgid'] = $_REQUEST['chkmsgid'];
	$postValues['namsgid'] = $_REQUEST['unchkmsgid'];
	$postValues['verifiedby'] = $_REQUEST['verifiedby'];

	$url = $confValues['TWITTERSERVERNAME']."";
} else {
	$url = $confValues['TWITTERSERVERNAME']."?action=getportalmessages&portalid=". $confValues['TWITTERPORTALID'] ."&msgtype=0";
}

processRequest($url, $postValues);

?>