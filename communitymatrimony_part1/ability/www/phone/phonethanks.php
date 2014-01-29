<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		:
#================================================================================================================
   # Description	:
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");
$objSlaveDB			= new DB;
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

$varUserName		= trim($_POST['problemid']);
$varPhoneDetail		= str_replace("~","-",trim($_POST['phonedetail']));
$SenderUserName		= trim($varGetCookieInfo['USERNAME']);
$SenderId			= trim($_POST['senderid']);
$varComplaint		= trim($_POST['complaint']);
$varCondition		= "WHERE MatriId=".$objSlaveDB->doEscapeString($varGetCookieInfo['MATRIID'],$objSlaveDB);
$varFields			= array('Email');
$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition, 0);
$varMemberInfo 		= mysql_fetch_assoc($varResult);
$varFromEmail 		= $varMemberInfo['Email'];
$varToEmail			= $confValues['HELPEMAIL'];
$varSubject			= 'Phone not working';
$varMessage			='
    <html>
    <body>

      <table>
      <tr>
       <td>Compliant by :</td><td>'.$SenderUserName.'</td>
     </tr>
     <tr>
       <td>Matrimony Username :</td><td>'.$varUserName.'</td>
     </tr>
     <tr>
        <td>Phone :</td><td>'.trim($varPhoneDetail,",").'</td>
     </tr>
     <tr>
        <td>Complaint Details :</td><td>'.$varComplaint.'</td>
     </tr>
     </table>
    </body>
    </html>';
//sending mail
$headers  = 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
$headers .= "From:".$varFromEmail." \n";
$headers .= "Reply To: ".$varFromEmail."\n";
$headers .= "Sender: ".$confValues['INFOEMAIL']."<".$confValues['INFOEMAIL'].">\n";
mail($varToEmail, $varSubject, $varMessage, $headers);
if ($_REQUEST['index'] ==1 )
	$varContent.="Thank you for bringing to our notice that the phone number of $varUserName is not working. We will look into the issue and get it sorted out at the earliest.";
elseif ($_REQUEST['index'] ==2 )
	$varContent.=" Thank you for bringing to our notice that the phone number of $varUserName is changed. We will look into the issue and get it sorted out at the earliest.";
elseif ($_REQUEST['index'] ==3 )
	$varContent.="Thank you for bringing to our notice.</div>";
echo "<div class='errortxt' style='width:410px;'>".$varContent."<div>";

$objSlaveDB->dbClose();
UNSET($objSlaveDB);
?>