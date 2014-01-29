<?php
$varRootPath = $_SERVER['DOCUMENT_ROOT'];
$varBasePath = dirname($varRootPath);

include_once($varBasePath.'/www/admin/includes/userLoginCheck.php');
include_once($varBasePath.'/www/admin/includes/admin-privilege.cil14');
include_once($varBasePath.'/conf/dbinfo.cil14');
include_once($varBasePath.'/lib/clsDB.php');

$cookValue		= split('&', $_COOKIE['adminLoginInfo']);
$varUsername	= $cookValue[1];

$varWholeReport = array_key_exists($varUsername, $arrManageUsers) ? 'yes' : 'no';
if($varWholeReport=='no'){
	$varWholeReport =(($varUsername=='pramod')||($varUsername=='dinesh')||($varUsername=='senthilkumar'))?'yes' : 'no';
}


if($varWholeReport == 'yes'){

	$varCurrentdate	= date('Y-m-d-H-i-s');
	$arrDate		= split('-', $varCurrentdate);

	$varOneDayBeforeDate	= date('Y-m-d H:i:s', mktime($arrDate[3], $arrDate[4], $arrDate[5], $arrDate[1], $arrDate[2]-1, $arrDate[0]));
	$varTwoHourBeforeDate	= date('Y-m-d H:i:s', mktime($arrDate[3]-2, $arrDate[4], $arrDate[5], $arrDate[1], $arrDate[2], $arrDate[0]));
	$varOneHourBeforeDate	= date('Y-m-d H:i:s', mktime($arrDate[3]-1, $arrDate[4], $arrDate[5], $arrDate[1], $arrDate[2], $arrDate[0]));
	$varOneMonthBeforeDate	= date('Y-m-d H:i:s', mktime($arrDate[3], $arrDate[4], $arrDate[5], $arrDate[1], $arrDate[2]-30, $arrDate[0]));

	$objSlaveDB	= new DB;

	$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

	//Getting profile validation report
	$varFirstCondition	= "WHERE Publish=0 AND Date_Created>='".$varOneMonthBeforeDate."' AND Date_Created<'";
	$varWhereCond		= $varFirstCondition.$varOneDayBeforeDate."'";
	$arrCnt['NewProfile'][0]	= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], 'MatriId', $varWhereCond);

	$varFirstCondition	= "WHERE Publish=0 AND Date_Created>='".$varOneDayBeforeDate."' AND Date_Created<'";
	$varWhereCond		= $varFirstCondition.$varTwoHourBeforeDate."'";
	$arrCnt['NewProfile'][1]	= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], 'MatriId', $varWhereCond);

	$varFirstCondition	= "WHERE Publish=0 AND Date_Created>='".$varTwoHourBeforeDate."' AND Date_Created<'";
	$varWhereCond		= $varFirstCondition.$varOneHourBeforeDate."'";
	$arrCnt['NewProfile'][2]	= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], 'MatriId', $varWhereCond);

	$varFirstCondition	= "WHERE Publish=0 AND Date_Created>='".$varOneHourBeforeDate."'";
	$varWhereCond		= $varFirstCondition;
	$arrCnt['NewProfile'][3]	= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], 'MatriId', $varWhereCond);

	$arrCnt['NewProfile']['TOT']= $arrCnt['NewProfile'][0]+$arrCnt['NewProfile'][1]+$arrCnt['NewProfile'][2]+$arrCnt['NewProfile'][3];

	//Getting modify validation report
	$varWhereCond	= "WHERE Date_Updated<'".$varOneDayBeforeDate."'";
	$arrCnt['ModifyProfile'][0]	= $objSlaveDB->numOfRecords($varTable['MEMBERUPDATEDINFO'], 'MatriId', $varWhereCond);

	$varWhereCond	= "WHERE Date_Updated>='".$varOneDayBeforeDate."' AND Date_Updated<'".$varTwoHourBeforeDate."'";
	$arrCnt['ModifyProfile'][1]	= $objSlaveDB->numOfRecords($varTable['MEMBERUPDATEDINFO'], 'MatriId', $varWhereCond);

	$varWhereCond	= "WHERE Date_Updated>='".$varTwoHourBeforeDate."' AND Date_Updated<'".$varOneHourBeforeDate."'";
	$arrCnt['ModifyProfile'][2]	= $objSlaveDB->numOfRecords($varTable['MEMBERUPDATEDINFO'], 'MatriId', $varWhereCond);

	$varWhereCond	= "WHERE Date_Updated>='".$varOneHourBeforeDate."'";
	$arrCnt['ModifyProfile'][3]	= $objSlaveDB->numOfRecords($varTable['MEMBERUPDATEDINFO'], 'MatriId', $varWhereCond);

	$arrCnt['ModifyProfile']['TOT']= $arrCnt['ModifyProfile'][0]+$arrCnt['ModifyProfile'][1]+$arrCnt['ModifyProfile'][2]+$arrCnt['ModifyProfile'][3];
	

	//Getting photo validation report
	$varCondition	= " AND ((Normal_Photo1!='' AND Photo_Status1=0) OR (Normal_Photo2!='' AND Photo_Status2=0) OR (Normal_Photo3!='' AND Photo_Status3=0) OR (Normal_Photo4!='' AND Photo_Status4=0) OR (Normal_Photo5!='' AND Photo_Status5=0) OR (Normal_Photo6!='' AND Photo_Status6=0) OR (Normal_Photo7!='' AND Photo_Status7=0) OR (Normal_Photo8!='' AND Photo_Status8=0) OR (Normal_Photo9!='' AND Photo_Status9=0) OR (Normal_Photo10!='' AND Photo_Status10=0))";

	$varFirstCondition	= "WHERE Photo_Date_Updated>='".$varOneMonthBeforeDate."' AND Photo_Date_Updated<'";
	$varWhereCond		= $varFirstCondition.$varOneDayBeforeDate."'".$varCondition;
	$arrCnt['Photo'][0]	= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], 'Photo_Id', $varWhereCond);

	$varFirstCondition	= "WHERE Photo_Date_Updated>='".$varOneDayBeforeDate."' AND Photo_Date_Updated<'";
	$varWhereCond		= $varFirstCondition.$varTwoHourBeforeDate."'".$varCondition;
	$arrCnt['Photo'][1]	= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], 'Photo_Id', $varWhereCond);

	$varFirstCondition	= "WHERE Photo_Date_Updated>='".$varTwoHourBeforeDate."' AND Photo_Date_Updated<'";
	$varWhereCond		= $varFirstCondition.$varOneHourBeforeDate."'".$varCondition;
	$arrCnt['Photo'][2]	= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], 'Photo_Id', $varWhereCond);
	
	$varFirstCondition	= "WHERE Photo_Date_Updated>='".$varOneHourBeforeDate."'";
	$varWhereCond		= $varFirstCondition;
	$arrCnt['Photo'][3]	= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], 'Photo_Id', $varWhereCond);

	$arrCnt['Photo']['TOT']= $arrCnt['Photo'][0]+$arrCnt['Photo'][1]+$arrCnt['Photo'][2]+$arrCnt['Photo'][3];


	//Getting Horoscope validation report
	$varCondition	= " AND HoroscopeStatus=0 AND HoroscopeURL!=''";

	$varFirstCondition		= "WHERE Horoscope_Date_Updated>='".$varOneMonthBeforeDate."' AND Horoscope_Date_Updated<'";
	$varWhereCond			= $varFirstCondition.$varOneDayBeforeDate."'".$varCondition;
	$arrCnt['Horoscope'][0]	= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], 'Photo_Id', $varWhereCond);

	$varFirstCondition		= "WHERE Horoscope_Date_Updated>='".$varOneDayBeforeDate."' AND Horoscope_Date_Updated<'";
	$varWhereCond			= $varFirstCondition.$varTwoHourBeforeDate."'".$varCondition;
	$arrCnt['Horoscope'][1]	= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], 'Photo_Id', $varWhereCond);

	$varFirstCondition		= "WHERE Horoscope_Date_Updated>='".$varTwoHourBeforeDate."' AND Horoscope_Date_Updated<'";
	$varWhereCond			= $varFirstCondition.$varOneHourBeforeDate."'".$varCondition;
	$arrCnt['Horoscope'][2]	= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], 'Photo_Id', $varWhereCond);

	$varFirstCondition		= "WHERE Horoscope_Date_Updated>='".$varOneHourBeforeDate."'";
	$varWhereCond			= $varFirstCondition;
	$arrCnt['Horoscope'][3]	= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], 'Photo_Id', $varWhereCond);
	
	$arrCnt['Horoscope']['TOT']= $arrCnt['Horoscope'][0]+$arrCnt['Horoscope'][1]+$arrCnt['Horoscope'][2]+$arrCnt['Horoscope'][3];

	//Getting NRI Message validation report
	$varCondition	= " AND Status=2";

	$varFirstCondition	= "WHERE Date_Updated>='".$varOneMonthBeforeDate."' AND Date_Updated<'";
	$varWhereCond		= $varFirstCondition.$varOneDayBeforeDate."'".$varCondition;
	$arrCnt['NRIMsg'][0]= $objSlaveDB->numOfRecords($varTable['MAILPENDINGINFO'], 'Mail_Id', $varWhereCond);

	$varFirstCondition	= "WHERE Date_Updated>='".$varOneDayBeforeDate."' AND Date_Updated<'";
	$varWhereCond		= $varFirstCondition.$varTwoHourBeforeDate."'".$varCondition;
	$arrCnt['NRIMsg'][1]= $objSlaveDB->numOfRecords($varTable['MAILPENDINGINFO'], 'Mail_Id', $varWhereCond);

	$varFirstCondition	= "WHERE Date_Updated>='".$varTwoHourBeforeDate."' AND Date_Updated<'";
	$varWhereCond		= $varFirstCondition.$varOneHourBeforeDate."'".$varCondition;
	$arrCnt['NRIMsg'][2]= $objSlaveDB->numOfRecords($varTable['MAILPENDINGINFO'], 'Mail_Id', $varWhereCond);

	$varFirstCondition	= "WHERE Date_Updated>='".$varOneHourBeforeDate."'";
	$varWhereCond		= $varFirstCondition;
	$arrCnt['NRIMsg'][3]= $objSlaveDB->numOfRecords($varTable['MAILPENDINGINFO'], 'Mail_Id', $varWhereCond);

	$arrCnt['NRIMsg']['TOT']= $arrCnt['NRIMsg'][0]+$arrCnt['NRIMsg'][1]+$arrCnt['NRIMsg'][2]+$arrCnt['NRIMsg'][3];

	//Getting Success Story validation report
	$varCondition	= " AND Publish=0";
	
	$varFirstCondition		= "WHERE Date_Updated>='".$varOneMonthBeforeDate."' AND Date_Updated<'";
	$varWhereCond			= $varFirstCondition.$varOneDayBeforeDate."'".$varCondition;
	$arrCnt['Success'][0]	= $objSlaveDB->numOfRecords($varTable['SUCCESSSTORYINFO'], 'MatriId', $varWhereCond);

	$varFirstCondition		= "WHERE Date_Updated>='".$varOneDayBeforeDate."' AND Date_Updated<'";
	$varWhereCond			= $varFirstCondition.$varTwoHourBeforeDate."'".$varCondition;
	$arrCnt['Success'][1]	= $objSlaveDB->numOfRecords($varTable['SUCCESSSTORYINFO'], 'MatriId', $varWhereCond);

	$varFirstCondition		= "WHERE Date_Updated>='".$varTwoHourBeforeDate."' AND Date_Updated<'";
	$varWhereCond			= $varFirstCondition.$varOneHourBeforeDate."'".$varCondition;
	$arrCnt['Success'][2]	= $objSlaveDB->numOfRecords($varTable['SUCCESSSTORYINFO'], 'MatriId', $varWhereCond);

	$varFirstCondition		= "WHERE Date_Updated>='".$varOneHourBeforeDate."'";
	$varWhereCond			= $varFirstCondition;
	$arrCnt['Success'][3]	= $objSlaveDB->numOfRecords($varTable['SUCCESSSTORYINFO'], 'MatriId', $varWhereCond);

	$arrCnt['Success']['TOT']= $arrCnt['Success'][0]+$arrCnt['Success'][1]+$arrCnt['Success'][2]+$arrCnt['Success'][3];

	//Getting Phone not working validation report
	$varCondition	= " AND Request_Closed=0";

	$varFirstCondition	= "WHERE Request_Received>='".$varOneMonthBeforeDate."' AND Request_Received<'";
	$varWhereCond		= $varFirstCondition.$varOneDayBeforeDate."'".$varCondition;
	$arrCnt['Phone'][0]	= $objSlaveDB->numOfRecords($varTable['PHONENOTWORK_LOG'], 'Id', $varWhereCond);

	$varFirstCondition	= "WHERE Request_Received>='".$varOneDayBeforeDate."' AND Request_Received<'";
	$varWhereCond		= $varFirstCondition.$varTwoHourBeforeDate."'".$varCondition;
	$arrCnt['Phone'][1]	= $objSlaveDB->numOfRecords($varTable['PHONENOTWORK_LOG'], 'Id', $varWhereCond);

	$varFirstCondition	= "WHERE Request_Received>='".$varTwoHourBeforeDate."' AND Request_Received<'";
	$varWhereCond		= $varFirstCondition.$varOneHourBeforeDate."'".$varCondition;
	$arrCnt['Phone'][2]	= $objSlaveDB->numOfRecords($varTable['PHONENOTWORK_LOG'], 'Id', $varWhereCond);

	$varFirstCondition	= "WHERE Request_Received>='".$varOneHourBeforeDate."'";
	$varWhereCond		= $varFirstCondition;
	$arrCnt['Phone'][3]	= $objSlaveDB->numOfRecords($varTable['PHONENOTWORK_LOG'], 'Id', $varWhereCond);

	$arrCnt['Phone']['TOT']= $arrCnt['Phone'][0]+$arrCnt['Phone'][1]+$arrCnt['Phone'][2]+$arrCnt['Phone'][3];

	//Getting Spam message validation report
	$varCondition		= " AND ValidationStatus=0";

	$varFirstCondition	= "WHERE AlertDate>='".strtotime($varOneMonthBeforeDate)."' AND AlertDate<";
	$varWhereCond		= $varFirstCondition.strtotime($varOneDayBeforeDate).$varCondition;
	$arrCnt['Spam'][0]	= $objSlaveDB->numOfRecords($varTable["SPAMMSG"], 'MessageId', $varWhereCond);

	$varFirstCondition	= "WHERE AlertDate>='".strtotime($varOneDayBeforeDate)."' AND AlertDate<";
	$varWhereCond		= $varFirstCondition.strtotime($varTwoHourBeforeDate).$varCondition;
	$arrCnt['Spam'][1]	= $objSlaveDB->numOfRecords($varTable["SPAMMSG"], 'MessageId', $varWhereCond);

	$varFirstCondition	= "WHERE AlertDate>='".strtotime($varTwoHourBeforeDate)."' AND AlertDate<";
	$varWhereCond		= $varFirstCondition.strtotime($varOneHourBeforeDate).$varCondition;
	$arrCnt['Spam'][2]	= $objSlaveDB->numOfRecords($varTable["SPAMMSG"], 'MessageId', $varWhereCond);

	$varFirstCondition	= "WHERE AlertDate>='".strtotime($varOneHourBeforeDate)."'";
	$varWhereCond		= $varFirstCondition;
	$arrCnt['Spam'][3]	= $objSlaveDB->numOfRecords($varTable["SPAMMSG"], 'MessageId', $varWhereCond);

	$arrCnt['Spam']['TOT']= $arrCnt['Spam'][0]+$arrCnt['Spam'][1]+$arrCnt['Spam'][2]+$arrCnt['Spam'][3];
	
	$objSlaveDB->dbClose();
	unset($objSlaveDB);

	$varCont = '<tr class="mediumtxt boldtxt" style="background-color:#EEEEEE"><td width="110">Process</td><td width="40" align="center">>24 Hrs</td><td width="40"  align="center">>2 Hrs</td><td width="40" align="center">>1 Hr</td><td width="40" align="center"><1 Hr</td><td width="40" align="center">Total</td></tr>';

	$arrLblExpansion	= array('NewProfile'=>'Profile validation', 'ModifyProfile'=>'Profile modification', 'Photo'=>'Photo validation', 'Horoscope'=>'Horoscope validation', 'NRIMsg'=>'NRI message validation', 'Success'=>'Success story validation', 'Phone'=>'Phone Not Working', 'Spam'=>'Spam Message Validation');
	foreach($arrLblExpansion as $arrName=>$varLblVal){
		$arrName  = $arrCnt[$arrName];
		$varCont .= '<tr class="smalltxt"><td>'.$varLblVal.'</td><td  align="center">'.$arrName[0].'</td><td align="center">'.$arrName[1].'</td><td align="center">'.$arrName[2].'</td><td align="center">'.$arrName[3].'</td><td align="center">'.$arrName['TOT'].'</td></tr>';
	}
}else{
	$varCont = "<tr><td colspan='6'><br><br><span class='errortxt'>You don't have privilege to view this report</span></td></tr>";
}
?>
<br clear="all">
<table width="542" cellspacing="3" cellpadding="3" border="1" style="border:1px solid #000000;">
	<tr class="mediumtxt boldtxt"><td colspan="6" align="center">Validation pending report</td></tr>
	<?=$varCont;?>
</table>