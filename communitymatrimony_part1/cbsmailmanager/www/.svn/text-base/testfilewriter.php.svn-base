<?php


$maillogfname='/home/mailmanager/mlistfiles/testmailer.txt';
$maillogfp = fopen($maillogfname, 'a+');
for($i=0;$i<1000000;$i++){
$wrtcontent = "11,anish@bharatmatrimony.com,linux,M224175,24,M,testpwd1,2,2007-10-08 10:23:54" ."\n";
fwrite($maillogfp, $wrtcontent);
}
echo 'done';

