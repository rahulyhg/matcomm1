<?php

//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
if($varServerRoot == ''){ $varServerRoot  = '/home/product/community/ability/www'; }

$varBaseRoot	= dirname($varServerRoot);

//INCLUDE FILES
include_once($varBaseRoot.'/lib/clsCronMailer.php');

//OBJECT DECLARATION
$objCronMailer = new cronMailer;

//Connect DB
$objCronMailer->dbConnect('S', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varSelectMatriId	= $objCronMailer->NotLoggedIn();
$varNumOfRows		= count($varSelectMatriId);

for($i=0;$i<$varNumOfRows;$i++)
{
	$varUsername	= $varSelectMatriId[$i]['User_Name'];
	$varEmail		= $varSelectMatriId[$i]['Email'];
	$varMemberId	= $varSelectMatriId[$i]['MatriId'];
	
	$varFields		= array('Interest_Pending_Received', 'Mail_UnRead_Received')
	$varCondition	= "WHERE MatriId='".$varMemberId."'";
	$varResult		= $objCronMailer->select($varTable['MEMBERSTATISTICS'], $varFields, $varCondition, 1);
	$varMsgNewCnt	= $varResult['Mail_UnRead_Received']; 
	$varIntNewCnt	= $varResult['Interest_Pending_Received'];
	$varRetValue	= $objMailManager->sendNotLoggedInMail($varUsername,$varEmail,$confValues['ServerURL'],$varMsgNewCnt,$varIntNewCnt);
}

//Unset object
$objCronMailer->dbClose();
unset($objCronMailer);
?>