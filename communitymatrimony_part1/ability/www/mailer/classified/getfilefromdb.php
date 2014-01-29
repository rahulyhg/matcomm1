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
//$varDbInfo['DATABASE']='communitymatrimony';
$varDbInfo['DATABASE']='classifiedmailer';
$filename=$path.'mailer/classified/maillist/classified_original.txt';

//input
$fromdate=''; //Provide from date
$todate='';  //Provind To date
$limit='';  //provide null for no limit
$input=array('FROMDATE'=>$fromdate,'TODATE'=>$todate,'LIMIT'=>$limit);



$classifiedmail=new Classfiedmail($filename,$varTable['CBSCLASSFIEDMAIL']);
$newFileName=$classifiedmail->CreateNewFileName('_final_');//creting new name using suffix
$classifiedmail->connectDB($varDbInfo['DATABASE']);
$classifiedmail->deleteRecord($varTable['CBSCLASSFIEDMAIL'],$varTable['MEMBERLOGININFO']);
$classifiedmail->DBClose();
$classifiedmail->connectSlaveDB($varDbInfo['DATABASE']);
$classifiedmail->selectRecord($varTable['CBSCLASSFIEDMAIL'],$input);
$trackContent=$classifiedmail->getContentFromDB(); //getId,IndexandEmailId from Table
$classifiedmail->PopulateEmailIdToFile($trackContent,$newFileName);
$classifiedmail->renamingFileName();  //Rename the File
?>