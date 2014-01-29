<?php
//FILE INCLUDES
//include_once('/home/mailmanager/cbsmailer/ip.inc');
include_once('/home/product/community/ability/conf/ip.inc');

//connect mysql
$mysql_connection	= mysql_connect($varDbIP['M'],$varDBUserName,$varDBPassword) or die('connection_error');
$mysql_select_db	= mysql_select_db("communitymatrimony") or die('db_selection_error');

//Delete duplicate email from cbsmailerdata table 
$varQuery	= "DELETE FROM  communitymatrimony.cbsmailerdata WHERE Email IN (SELECT Email FROM communitymatrimony.memberlogininfo)";
$varResult  = mysql_query($varQuery) OR die('delete_error');

$varQuery	= "SELECT Id,Email FROM communitymatrimony.cbsmailerdata WHERE sourcetype=0 AND Unsubscribe=0";
$varResult  = mysql_query($varQuery) OR die('select_error');
$varNo		= mysql_num_rows($varResult);

//FILE NAME
$varFilename= date('Ymd').'.txt';
$varContent	= '';

//DELETE FILE
@unlink($varFilename);

//CREATE FILE
$varFileHandler	= fopen($varFilename,"w");

while($row = mysql_fetch_assoc($varResult)) {
	$varContent .= $row['Email'].'~'.$row['Id']."\n";
}
fwrite($varFileHandler,$varContent);
fclose($varFileHandler);

mysql_close($mysql_connection) or die('error');
?>
