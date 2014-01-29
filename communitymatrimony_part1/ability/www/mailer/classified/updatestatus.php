<?php
#================================================================================================================
   # Author 		: K.Lakshmanan
   # Date			: 08-02-2010
   # Project		: UpdateStatus.php
#================================================================================================================
   # Description	: Update the status afte the mail sent to DB
#================================================================================================================

$path='/home/product/community/ability/';
require_once($path.'lib/clsDB.php');
require_once('clsclassifiedmailer.php');
$varTable['CBSCLASSFIEDMAIL']='cbsclassfiedmaillist';
$varTable['CBSMAILERREPORT']='cbsmailer_report';
$varDbInfo['CLASSIFIEDMAILER']='classifiedmailer';
$varDbInfo['COMMUNITYMATRIMONY']='communitymatrimony';

$filename='logmailer.txt';

$classifiedmail=new Classfiedmail($filename,$varTable['CBSCLASSFIEDMAIL']);
$validEmailId=$classifiedmail->getValidEmailId();
$classifiedmail->connectDB($varDbInfo['CLASSIFIEDMAILER']);
$classifiedmail->updateStatus($validEmailId,$varTable['CBSCLASSFIEDMAIL']);

?>