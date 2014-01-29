<?php
include "/home/cbsmailmanager/config/config.php";
include_once "lib/authenticate.php";
include "/home/cbsmailmanager/config/header.php";
$fname = $_GET['fname'];
$type = $_GET['type'];
$submitdate = $_GET['dt'];
$priority = $_GET['pri'];
$mailertype =$_GET['mtype'];
$sendtype = $_GET['sendtype'];
$membertype = $_GET['membertype'];
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
	
	exec("ls /home/cbsmailmanager/mlistfiles/$spfname*|wc -l",$out);
  for($i=0;$i<$out[0];$i++){
	  $sSplitFile = "$spfname".$arrSplitedText[$i];
		$sSplitFiletxt=$sSplitFile.".txt"; 
    exec("mv /home/cbsmailmanager/mlistfiles/$sSplitFile /home/cbsmailmanager/mlistfiles/$sSplitFiletxt");
  }
  		
   for($i=0;$i<$out[0];$i++){
	   
	   $fname=$spfname.$arrSplitedText[$i];
	   $logfile = ' 1> /home/cbsmailmanager/maillog/'.$fname.'.txt &'; 
	   $tfilename.=$fname.".txt".",";

 system ('nohup php /home/cbsmailmanager/www/sendmail.php ' .escapeshellarg($fname)." ".escapeshellarg($type)." ".escapeshellarg($dir)." ".escapeshellarg($submitdate)." ".escapeshellarg($priority)." ".escapeshellarg($mailertype)." ".escapeshellarg($sendtype)." ".escapeshellarg($membertype)."  ".$logfile); 

 }
echo 'Total files currently running after the split'."<br>";
echo '<b>'.$files_disp=substr($tfilename, 0, -1).'</b>';

 }else{
	echo "IN";
	$logfile = ' 1> /home/cbsmailmanager/maillog/'.$fname.'.txt &'; 

	echo  system ('nohup php /home/cbsmailmanager/www/sendmail.php ' .escapeshellarg($fname)." ".escapeshellarg($type)." ".escapeshellarg($dir)." ".escapeshellarg($submitdate)." ".escapeshellarg($priority)." ".escapeshellarg($mailertype)." ".escapeshellarg($sendtype)."  ".escapeshellarg($membertype)."  ".$logfile);

}
}else{
	$logfile = ' 1> /home/cbsmailmanager/maillog/'.$fname.'.txt &'; 
	system ('nohup php /home/cbsmailmanager/www/sendmail.php ' .escapeshellarg($fname)." ".escapeshellarg($type)." ".escapeshellarg($dir)." ".escapeshellarg($submitdate)." ".escapeshellarg($priority)." ".escapeshellarg($mailertype)." ".escapeshellarg($sendtype)." ".escapeshellarg($membertype)."  ".$logfile);
}
echo "<br><a href='index.php'>Back</a>";
?>
