<?php 
include_once('/home/product/community/ability/conf/ip.cil14');

//connect mysql
$mysql_connection	= mysql_connect($varDbIP['M'],$varDBUserName,$varDBPassword) or die('connection_error');
$mysql_select_db	= mysql_select_db("communitymatrimony") or die('db_selection_error');

$varEmail	= addslashes($_REQUEST['email']);

if(preg_match("/^[a-zA-Z0-9_][a-zA-Z0-9_\.\-]+@[a-zA-Z0-9_\-]+\.[a-zA-Z\.]{2,6}$/",$varEmail)) {
	echo $varEmail;
	//Delete duplicate email from cbsmailerdata table 
	$varQuery	= "UPDATE communitymatrimony.cbsmailerdata SET Unsubscribe=1 WHERE Email = '".$varEmail."'";
	echo '<BR>'.$varQuery;
	$varResult  = mysql_query($varQuery) OR die('update_error');
	echo 'You have unsubscribed successfully.'; 
} else {
	echo 'Your email-id is not in proper format.'; 
}
?>