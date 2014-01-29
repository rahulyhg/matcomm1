<?php

#================================================================================================================
   # Author 		: K.Lakshmanan
   # Date			: 08-02-2010
   # Project		: createmaillist.php
#================================================================================================================
   # Description	: Tgo get validemail from the Original file and store into new table also in files having unique Id in Databse with Subject
#================================================================================================================
$path='/home/product/community/ability/';
require_once($path.'lib/clsDB.php');
require_once('clsclassifiedmailer.php');

$varTable['CBSCLASSFIEDMAIL']='cbsclassfiedmaillist';
$varTable['MEMBERLOGININFO']='memberlogininfo';
$varDbInfo['DATABASE']='communitymatrimony';
//$varDbInfo['DATABASE']='classifiedmailer';
$filename=$path.'mailer/classified/maillist/classified_original.txt';

$classifiedmail=new Classfiedmail($filename,$varTable['CBSCLASSFIEDMAIL']);
$classifiedmail->getContents();
$validEmailId=$classifiedmail->getValidEmailId();//to get valid Email
$connerr=$classifiedmail->connectDB($varDbInfo['DATABASE']);
if($connerr){
	echo 'Database Not Connected';
	exit;
}
$lastId=$classifiedmail->GetLastIdFromTable($varTable['CBSCLASSFIEDMAIL']);
$classifiedmail->createRecord($validEmailId,$varTable['CBSCLASSFIEDMAIL']);

?>