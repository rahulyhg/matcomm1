<?php
include "/home/cbsmailmanager/config/config.php";
//include_once "lib/authenticate.php";
//include "config/header.php";
$fname = trim($_SERVER['argv'][1]);//$_GET['fname']
$type = trim($_SERVER['argv'][2]);//$_GET['type'];
$submitdate = trim($_SERVER['argv'][3]);//$_GET['dt'];
$priority =trim($_SERVER['argv'][4]);// $_GET['pri'];
$mailertype =trim($_SERVER['argv'][5]);//$_GET['mtype'];
$dir=0;
$spfname=$fname."_SPT_";

if($type=='live'){

$arrAlphabets = range('a','z');
$arrSplitedText = array();
$iAlpCnt = count($arrAlphabets);
for($i=0;$i<$iAlpCnt;$i++){
  for($j=0;$j<$iAlpCnt;$j++){
    array_push($arrSplitedText,$arrAlphabets[$i].$arrAlphabets[$j]);
  }
}
$ofname=$fname."mail.txt";
$sF2pTxtFile = "/home/cbsmailmanager/mlistfiles/$ofname";
exec("cat '$sF2pTxtFile' | wc -l",$sOut);
if($sOut[0] >200000){
	$dir=1;
  exec("split -l 200000 $sF2pTxtFile /home/cbsmailmanager/mlistfiles/$spfname");
	
 // exec("mv /home/mailmanager/mlistfiles/$spfname* /home/mailmanager/mlistfiles/");
  exec("ls /home/mailmanager/mlistfiles/$spfname*|wc -l",$out);
  for($i=0;$i<$out[0];$i++){
	  $sSplitFile = "$spfname".$arrSplitedText[$i];
		$sSplitFiletxt=$sSplitFile.".txt"; 
    exec("mv /home/cbsmailmanager/mlistfiles/$sSplitFile /home/mailmanager/mlistfiles/$sSplitFiletxt");
  }
  		
   for($i=0;$i<$out[0];$i++){
	   
	   $fname=$spfname.$arrSplitedText[$i];
	   $logfile = ' 1> /home/cbsmailmanager/maillog/'.$fname.'.txt &'; 
	   $tfilename.=$fname.".txt".",";

system ('nohup php sendmail_smtp.php ' .escapeshellarg($fname)." ".escapeshellarg($type)." ".escapeshellarg($dir)." ".escapeshellarg($submitdate)." ".escapeshellarg($priority)." ".escapeshellarg($mailertype)." ".$logfile);

//echo 'nohup php sendmail_smtp.php ' .escapeshellarg($fname)." ".escapeshellarg($type)." ".escapeshellarg($dir)." ".escapeshellarg($submitdate)." ".escapeshellarg($priority)." ".escapeshellarg($mailertype)." ".$logfile;

 }
echo 'Total files currently running after the split'."<br>";
echo '<b>'.$files_disp=substr($tfilename, 0, -1).'</b>';

 }
 else{

$logfile = ' 1> /home/cbsmailmanager/maillog/'.$fname.'.txt &'; 
 system ('nohup php sendmail_smtp.php ' .escapeshellarg($fname)." ".escapeshellarg($type)." ".escapeshellarg($dir)." ".escapeshellarg($submitdate)." ".escapeshellarg($priority)." ".escapeshellarg($mailertype)." ".$logfile);

}
}else{
	$logfile = ' 1> /home/cbsmailmanager/maillog/'.$fname.'.txt &'; 
	system ('nohup php sendmail_smtp.php ' .escapeshellarg($fname)." ".escapeshellarg($type)." ".escapeshellarg($dir)." ".escapeshellarg($submitdate)." ".escapeshellarg($priority)." ".escapeshellarg($mailertype)." ".$logfile);
}
//echo "<br><a href='index.php'>Back</a>";
?>
