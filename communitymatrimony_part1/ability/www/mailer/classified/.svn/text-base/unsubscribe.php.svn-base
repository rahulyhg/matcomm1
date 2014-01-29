<?php
#================================================================================================================
   # Author 		: K.Lakshmanan
   # Date			: 08-02-2010
   # Project		: unsubscribe.php
#================================================================================================================
   # Description	: TO unsubscribte from the given mail Id
#================================================================================================================



$path='/home/product/community/ability/';
require_once($path.'lib/clsDB1.php');

$email=trim($_GET['emailid']);
$varTable['CBSCLASSFIEDMAIL']='cbsclassfiedmaillist';
$varDbInfo['CLASSIFIEDMAILER']='classifiedmailer';

$db=new DB();
$db->dbConnect('M',$varDbInfo['CLASSIFIEDMAILER']);

$argFields=array('0'=>'Unsubscribe');
$argFieldsValue=array('0'=>'1');
$argCondition= "  EmailId='".$email."'";

$db->update($varTable['CBSCLASSFIEDMAIL'], $argFields, $argFieldsValue, $argCondition); //To Update the status for Unsubscribe




?>