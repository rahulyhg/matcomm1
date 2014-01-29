<?php
$varDBLink		= mysql_connect('192.168.1.24', 'matriservices', 'services');
mysql_select_db('communitymatrimony', $varDBLink);

$varFields		= array('Interest_Pending_Sent', 'Interest_Accept_Sent', 'Interest_Declined_Sent', 'Interest_Pending_Received', 'Interest_Accept_Received', 'Interest_Declined_Received', 'Mail_Read_Sent', 'Mail_UnRead_Sent', 'Mail_Replied_Sent', 'Mail_Declined_Sent', 'Mail_Read_Received', 'Mail_UnRead_Received', 'Mail_Replied_Received', 'Mail_Declined_Received');

$arrTableName	= array('interestsentinfo', 'interestsentinfo', 'interestsentinfo', 'interestreceivedinfo', 'interestreceivedinfo', 'interestreceivedinfo', 'mailsentinfo', 'mailsentinfo', 'mailsentinfo', 'mailsentinfo', 'mailreceivedinfo', 'mailreceivedinfo', 'mailreceivedinfo', 'mailreceivedinfo');

$arrStatus		= array(0, 1, 3, 0, 1, 3, 1, 0, 2, 3, 1, 0, 2, 3);

$arrMainTables	= array('interestreceivedinfo', 'interestsentinfo', 'mailreceivedinfo', 'mailsentinfo');

for($jj=0; $jj<4; $jj++){
$varMIQuery	= 'SELECT Opposite_MatriId FROM '.$arrMainTables[$jj].' GROUP BY Opposite_MatriId';
$varMIResult= mysql_query($varMIQuery);
print $varMIQuery."\n";

$ik = 0;
while($row = mysql_fetch_assoc($varMIResult))
{
	$varMatriId			= $row['Opposite_MatriId'];
	$varSelCondition	= " WHERE MatriId='".$varMatriId."' AND Status=";
	$varUpdCondition	= " WHERE MatriId='".$varMatriId."'";
	$varFinalRe			= array();

	$varResultset		= '';
	$varQuery			= 'SELECT MatriId FROM statmatriids'.$varUpdCondition;
	$varResultset		= mysql_query($varQuery);
	if(mysql_num_rows($varResultset)==0){
		$varQuery		= "INSERT INTO statmatriids VALUES('".$varMatriId."')";
		$varResultset	= mysql_query($varQuery);
		for($i=0; $i<=13; $i++){
		$varResultset	= '';
		$varNoOfRecs	= '';
		$varTableName	= $arrTableName[$i];
		$varStatus		= $arrStatus[$i];
		$varQuery		= 'SELECT MatriId FROM '.$varTableName.$varSelCondition.$varStatus;
		$varResultset	= mysql_query($varQuery);
		$varNoOfRecs	= mysql_num_rows($varResultset);
		$varFinalRe[$varFields[$i]]	= $varNoOfRecs;
		}

		$varFinalQuery	 = '';
		$varUpdateQuery  = 'UPDATE memberstatistics SET ';
		foreach($varFinalRe as $key=>$val){
		$varUpdateQuery	.= $key.'='.$val.', ';
		}
		$varFinalQuery	 = trim($varUpdateQuery, ', ').$varUpdCondition;
		//print $varFinalQuery."\n";
		mysql_query($varFinalQuery);
		$ik++;
	}
	if($ik==500){ sleep(5); $ik=0;}
}//while
}//for
mysql_close($varDBLink);
?>