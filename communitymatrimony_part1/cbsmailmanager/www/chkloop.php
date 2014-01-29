<?php

$eliminate = '';
$service = explode(",",$eliminate);

$lines = file('/home/cbsmailmanager/mlistfiles/testmaillist.txt');
$count = 1;

foreach ($lines as $line_num => $line) {

	$profileinfo = explode (",", $line);

	if(is_array($service)) {
		foreach ($service as $key => $value) {
			if (eregi($value, $profileinfo[1])) {
			   continue 2;
			} 
		}
	} else {
			if (eregi($service, $profileinfo[1])) {
			   continue;
			} 
	}

	echo $count . " ] " .$profileinfo[0] . " ] " .$profileinfo[1]."<br>";
	$count++;
}

?>