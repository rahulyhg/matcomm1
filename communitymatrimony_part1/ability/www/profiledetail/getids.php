<?php

//BASE PATH
$varRootBasePath = '/home/product/community/ability';

//Include files
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');


// DB Connection Object //
$objSlaveMatri	= new DB;

// Connecting DB  //
$objSlaveMatri -> dbConnect('S',$varDbInfo['DATABASE']);

 
// Array variables //
$status = array(0=>'Open',1=>'Hidden',2=>'Suspended',3,4,5,6);
$type   = array('0'=>'Free','1'=>'Paid');
$ipArrays = array("61.16.161.93","192.168.10.25","192.168.1.15");
 
// Getting email id from query string //
$emailid = db_escape_quotes(base64_decode($_GET['emailid']));
$ip = $_GET['ip'];
if($emailid != "" && in_array($ip,$ipArrays))
{
	$args = array('MatriId');
	$argConditions = " WHERE Email = ".$objSlaveMatri->doEscapeString($emailid,$objSlaveMatri);
	$total = $objSlaveMatri -> numOfRecords($varTable['MEMBERLOGININFO'],'MatriId',$argConditions);
	if($total > 0)
	{
		$memRes = $objSlaveMatri -> select($varTable['MEMBERLOGININFO'],$args,$argConditions,0);
		if($objSlaveMatri -> clsErrorCode == "SELECT_ERR")
		{
			mail("suresh.a@bharatmatrimony.com","Select Error - /profiledetail/getids.php - SELECT_ERR","Line no : 35");
			exit;
		}
		$matriIdForIn = array();
		while($memRow = mysql_fetch_array($memRes))
		{
			array_push($matriIdForIn,$memRow['MatriId']);
		}
		$matriIdForInImp = implode("','",$matriIdForIn);

		$memDetArg = array('MatriId','Status','Paid_Status');
		$memDetCondition = " where MatriId IN ('$matriIdForInImp')";
		$memDetRes = $objSlaveMatri -> select($varTable['MEMBERINFO'],$memDetArg,$memDetCondition,0);
		if($objSlaveMatri -> clsErrorCode == "SELECT_ERR")
		{
			mail("suresh.a@bharatmatrimony.com","Select Error - /profiledetail/getids.php - SELECT_ERR","Line no : 35");
			exit;
		}
		$memDet .= "<table border=1 cellpadding=1 cellspacing=1>";
		$memDet .= "<tr><th>ID</th><th>Status</th><th>Type</th></tr>";
		while($memDetRow = mysql_fetch_assoc($memDetRes))
		{
			$memDet .= "<tr><td>$memDetRow[MatriId]</td><td>".$status[$memDetRow['Status']]."</td><td>".$type[$memDetRow['Paid_Status']]."</td></tr>";
		}
		$memDet .= "</table>";
		echo $memDet;
	}
}
else
	mail("suresh.a@bharatmatrimony.com","Unauthorized request - /profiledetail/getids.php","Unauthorized request");
$objSlaveMatri -> dbClose();
?>

<?php
#function to escape the quotes 
function db_spl_chars_encode($str)     { 
    return htmlentities($str); 
} 
function db_escape_quotes($value)     { 
    $value = db_spl_chars_encode($value); 
    if (get_magic_quotes_gpc()) { 
        $value = stripslashes($value); 
        } 
        if (!is_numeric($value)) { 
        $value = mysql_real_escape_string($value); 
        } 
        return trim($value);  
}
?>