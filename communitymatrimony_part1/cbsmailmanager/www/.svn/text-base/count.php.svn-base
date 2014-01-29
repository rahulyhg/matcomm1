<?php
ini_set("memory_limit","512M");
$maillist_filename = '/home/cbsmailmanager/mlistfiles/ME28mail.txt';

	if (file_exists($maillist_filename)) {
		echo $maillist_filename;
		$lines = file($maillist_filename);

		$cnt = count($lines);
		if ($cnt != 0 && $cnt != '') {
			echo $cnt;
		} else {
			echo '0';
		}
	} 
?>