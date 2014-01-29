<?php
//FILE INCLUDES
//include_once('/home/mailmanager/cbsmailer/ip.inc');
include_once('/home/product/community/ability/conf/ip.inc');

$varSourceType	= strtolower(trim($_REQUEST["sourcetype"]));
$varContentFile	= array('prcase1'=>'0','prcase2'=>'1','deleted'=>'2','classified'=>'3','inactive'=>'4');
$varFileName	= $varSourceType;
$varSourceType	= $varContentFile[$varSourceType];

if ($varFileName!="" && $varSourceType !="") {



//connect mysql
$mysql_connection	= mysql_connect($varDbIP['M'],$varDBUserName,$varDBPassword) or die('connection_error');
$mysql_select_db	= mysql_select_db("communitymatrimony") or die('db_selection_error');

//Delete duplicate email from cbsmailerdata table 
$varQuery	= "DELETE FROM  communitymatrimony.cbsmailerdata WHERE Email IN (SELECT Email FROM communitymatrimony.memberlogininfo)";
$varResult  = mysql_query($varQuery) OR die('delete_error');

$varQuery	= "SELECT Email,Caste FROM communitymatrimony.cbsmailerdata WHERE sourcetype=".$varSourceType." AND Unsubscribe=0 ORDER BY Id ASC";
$varResult  = mysql_query($varQuery) OR die('select_error');
$varNo		= mysql_num_rows($varResult);

//FILE NAME
$varFileCount	= 1;
$varFilename= date('Ymd').'_'.$varFileName.'_'.$varFileCount.'.txt';
$varContent	= '';

//CREATE FILE
$varFileHandler	= fopen($varFilename,"w");

$j=1;
//$varLimit		= '800000';
$varLimit		= '1';
$varTotalFiles		= array();
$varTotalFiles[0]	= $varFilename;
while($row = mysql_fetch_assoc($varResult)) {

	$varEmail	= $row['Email'];
	$varCaste	= $row['Caste'];
	$varContent .= $varEmail.'~'.$varCaste."\n";

	if ($varLimit==$j){

		fwrite($varFileHandler,$varContent);
		fclose($varFileHandler);


		//FILE NAME
		$varFileCount++;
		$varFilename= date('Ymd').'_'.$varFileName.'_'.$varFileCount.'.txt';
		$varContent	= '';

		//CREATE FILE
		$varFileHandler		= fopen($varFilename,"w");
		$varTotalFiles[]	= $varFilename;

		$j=0;
	}
	$j++;
}
fwrite($varFileHandler,$varContent);
fclose($varFileHandler);

echo 'Successfull created following files<br>';
foreach($varTotalFiles as $varKey =>$varValue) {
	if (filesize($varValue)) { echo '<br>'.$varValue; chmod($varValue, 0777); } else { unlink($varValue); };


}

mysql_close($mysql_connection) or die('error');

} else { echo 'Please specify the mail type'; }
?>
