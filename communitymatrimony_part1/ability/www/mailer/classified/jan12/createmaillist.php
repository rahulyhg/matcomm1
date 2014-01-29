<?php

#================================================================================================================
   # Author 		: K.Lakshmanan
   # Date			: 08-02-2010
   # Project		: createmaillist.php
#================================================================================================================
   # Description	: Tgo get validemail from the Original file and store into new table also in files having unique Id in Databse with Subject
#================================================================================================================
$path='/home/product/community/ability/';
require_once($path.'lib/clsDB1.php');
require_once('clsclassifiedmailer.php');

$varTable['CBSCLASSFIEDMAIL']='cbsclassfiedmaillist';
$varTable['MEMBERLOGININFO']='memberlogininfo';
$varDbInfo['DATABASE']='communitymatrimony';
$filename='maillist/classified_original.txt';

$classifiedmail=new Classfiedmail($filename,$varTable['CBSCLASSFIEDMAIL']);
$classifiedmail->getContents();
$validEmailId=$classifiedmail->getValidEmailId();//to get valid Email
$newFileName=$classifiedmail->CreateNewFileName('_final_');//creting new name using suffix
$connerr=$classifiedmail->connectDB($varDbInfo['DATABASE']);
if($connerr){
	echo 'Database Not Connected';
	exit;
}
$lastId=$classifiedmail->GetLastIdFromTable($varTable['CBSCLASSFIEDMAIL']);
//$classifiedmail->createRecord($validEmailId,$varTable['CBSCLASSFIEDMAIL']);
$classifiedmail->deleteRecord($varTable['CBSCLASSFIEDMAIL'],$varTable['MEMBERLOGININFO']);
//$classifiedmail->selectRecord($varTable['CBSCLASSFIEDMAIL'],0);
//$trackContent=$classifiedmail->getContentFromDB(); //getId,IndexandEmailId from Table
//$classifiedmail->PopulateEmailIdToFile($trackContent,$newFileName);
//$classifiedmail->renamingFileName();  //Rename the File
?>