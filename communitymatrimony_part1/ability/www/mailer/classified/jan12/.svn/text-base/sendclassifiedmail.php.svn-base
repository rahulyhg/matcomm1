<?php
#================================================================================================================
   # Author 		: K.Lakshmanan
   # Date			: 08-02-2010
   # Project		: sendclassifiedmail.php
#================================================================================================================
   # Description	: Parsing the email from the mail and send to user and tracking and overwrite every Email Id in new file
#================================================================================================================

$path='/home/product/community/ability/';
require_once($path.'lib/clsDB.php');
require_once('clsclassifiedmailer.php');
require_once("smtp.php");

$varTable['CBSCLASSFIEDMAIL']='cbsclassfiedmaillist';
$varTable['CBSMAILERREPORT']='cbsmailer_report';
$varDbInfo['COMMUNITYMATRIMONY']='communitymatrimony';


//Get argument for fileName;
$argFileName=$argv[1];

$folderPath='maillist/';
$date= date('d_m_Y');
$appendfile=$folderPath.'logmailer.txt';
$finalEmailIdwithIndex=$folderPath.'cbsmailtracker_'.$date.'.txt';
$mailerType='classifiednoncaste';
$templateFile=$folderPath.'mailtemplate.tpl'; //path for template mail
$subject="This is the Subject";  //Subject
$filename=$folderPath.'classified_original.txt'; //Filename to fetch the record
$replaceText=array('COMMUNITY'=>'Chettiarmatrimony');
$mailsettings=array('host'=>'172.28.0.236','port'=>'587','localhost'=>'localhost','timeout'=>'10','data_timeout'=>'0','emailfrom'=>'info@communitymatrimony.com','replyto'=>'noreply@bounces.communitymatrimony.com');

$classifiedmail=new Classfiedmail($filename);
$newFilename=$classifiedmail->CreateNewFileName('_final_');
  if($argFileName!=''){  //Priority for fils given in argument;
      $newFilename=trim($folderPath.$argFileName);
  }
$newFilename=$folderPath.'members_test.txt';
$classifiedmail->getContents($newFilename);
$emailWithId=GetMailWithId($newFilename);
$classifiedmail->sendEmailToUser($emailWithId,$finalEmailIdwithIndex,$appendfile,$templateFile,$replaceText,$mailsettings);
$table=$varDbInfo['COMMUNITYMATRIMONY'].'.'.$varTable['CBSMAILERREPORT'];
$connerr=$classifiedmail->connectDB($varDbInfo['COMMUNITYMATRIMONY']);
if($connerr){
	echo 'Database Not Connected';
	exit;
}

$classifiedmail->createLog($table,$mailerType);

function GetMailWithId($filename) {
	$file_array = file($filename);
	foreach ($file_array as $key=>$value){
		$order=explode(',',$value);
		 $email[$order[0]]=$order[1];
	}
     return $email;
}
?>

