<?php
function checkUserAuth($argUrl='login/') { // CheckUserAuth
	global $varGetCookieInfo,$confValues;
	$varUserAuthUrl	= $confValues['SERVERURL'].'/'.$argUrl;
	if (trim($varGetCookieInfo['MATRIID'])=='') {
		if (!headers_sent()) { header("Location:".$varUserAuthUrl); exit; }
		else { "<script>document.location.href='".$varUserAuthUrl."';</script>"; exit; }
 	}
}

function clearCookie() { //clearCookie
	setcookie("loginInfo",'', '0', '/',$confValues["DOMAINNAME"]);
	setrawcookie("messagesInfo",'', '0', '/',$confValues["DOMAINNAME"]);
	setrawcookie("savedSearchInfo",'', '0', '/',$confValues["DOMAINNAME"]);
	unset($varCookieInfo);
	$sessMatriId		= '';
	$sessGender		= '';
	$sessUsername	= '';
	$sessLastLogin	= '';
	$sessPaidStatus	= '';
	$sessPublish		= '';
}

function profileComplAlgorithim() { // Profile completeness algorithim

	global $arrProfileCompleteScore, $varGetCookieInfo;

	$arrProfileComplInfo['SCORE'] = 0;
	$arrProfileComplInfo['PRIORITYLINK'] = '';
	$arrProfileComplInfo['PRIORITYINFO'] = '';
	$arrProfileComplInfo['PENDINGTOOLS'][] = '';
	$arrProfileComplInfo['SCORE'] += $arrProfileCompleteScore['DEFAULT'];

	if ($varGetCookieInfo['HOBBIESSTATUS']==1) {
		$arrProfileComplInfo['SCORE'] += $arrProfileCompleteScore['HOBBIES'];
	} else {
		$arrProfileComplInfo['PRIORITYLINK'] = '<a class="clr1" href="'.$confValues['SERVERURL'].'/profiledetail/index.php?act=myprofile&myid=yes&vtab=2&inname=hobbiesedit&inview=2">Add Hobbies & Interests</a>';
		$arrProfileComplInfo['PRIORITYINFO'] = 'Your Hobbies info could increase your score by 7%.';
		$arrProfileComplInfo['PENDINGTOOLS'][] = 'Hobbies';
	}
	if ($varGetCookieInfo['REFERENCESTATUS']==1) {
		$arrProfileComplInfo['SCORE'] += $arrProfileCompleteScore['REFERENCE'];
	} else {
		$arrProfileComplInfo['PRIORITYLINK'] = '<a class="clr1" href="'.$confValues['SERVERURL'].'/tools/index.php?add=refernce">Add or Invite Reference</a>';
		$arrProfileComplInfo['PRIORITYINFO'] = 'Your Reference info could increase your score by 7%.';
		$arrProfileComplInfo['PENDINGTOOLS'][] = 'Reference';
	}
	if ($varGetCookieInfo['FAMILYSTATUS']==1) {
		$arrProfileComplInfo['SCORE'] += $arrProfileCompleteScore['FAMILY'];
	} else {
		$arrProfileComplInfo['PRIORITYLINK'] = '<a class="clr1" href="'.$confValues['SERVERURL'].'/profiledetail/index.php?act=myprofile&myid=yes">Add Family Info</a>';
		$arrProfileComplInfo['PRIORITYINFO'] = 'Your Family info could increase your score by 7%.';
		$arrProfileComplInfo['PENDINGTOOLS'][] = 'Family';
	}
	if ($varGetCookieInfo['PARTNERSTATUS']==1) {
		$arrProfileComplInfo['SCORE'] += $arrProfileCompleteScore['PARTPREF'];
	} else {
		$arrProfileComplInfo['PRIORITYLINK'] = '<a class="clr1" href="'.$confValues['SERVERURL'].'/profiledetail/index.php?act=myprofile&myid=yes&vtab=2&inname=ppedit&inview=2">Add Partner Preference</a>';
		$arrProfileComplInfo['PRIORITYINFO'] = 'Your Partner preference could increase your score by 7%.';
		$arrProfileComplInfo['PENDINGTOOLS'][] = 'PartPref';
	}
	if ($varGetCookieInfo['PHOTOSTATUS']==1) {
		$arrProfileComplInfo['SCORE'] += $arrProfileCompleteScore['PHOTO'];
	} else {
		$arrProfileComplInfo['PRIORITYLINK'] = '<a class="clr1" href="'.$confValues['SERVERURL'].'/tools/index.php?add=photo">Add Photo</a>';
		$arrProfileComplInfo['PRIORITYINFO'] = 'Your Photo could increase your score by 7%.';
		$arrProfileComplInfo['PENDINGTOOLS'][] = 'Photo';
	}

	return $arrProfileComplInfo;
}

//function for background processes
# exec function for shell invoking program - Start - Feb 22nd 2011
function escapeexec($command, $logfilename='', $returnstatus=0){ 
 $shellExecArr = array("php","sh","pl","./");
 $cmdArr = explode(" ", $command);
 
 if($cmdArr[0] == "nohup" && in_array($cmdArr[1],$shellExecArr) == TRUE){
	  for($i=3; $i<count($cmdArr); $i++){
	   if(specialchardetection($cmdArr[$i],$command))
		$cmdArr[$i] = escapeshellarg($cmdArr[$i]);
	  }
	  $command = implode(" ",$cmdArr);
 }else if(in_array($cmdArr[0],$shellExecArr) == TRUE){
	  for($i=2; $i<count($cmdArr); $i++){
	   if(specialchardetection($cmdArr[$i],$command))
		$cmdArr[$i] = escapeshellarg($cmdArr[$i]);
	  }
	  $command = implode(" ",$cmdArr);
 }
 
 $cmd = escapeshellcmd($command);
 writeLog($cmd);
 
 if($returnstatus==1) {//need the full output value. so execute the command and return the full output
  return shell_exec("$cmd"); //to return the entire output use shell_exec instead of exec
 } else if($returnstatus==0 && trim($logfilename)!='') {
  shell_exec("$cmd > /var/log/cbsexeclog/".$logfilename." &"); //no need the output. execute as background ps.
 } else {
  shell_exec("$cmd &");
 }
}
?>