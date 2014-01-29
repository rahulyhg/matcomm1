<?php
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/messagevars.cil14");
include_once($varRootBasePath."/lib/clsInboxMailer.php");

//OBJECT DECLARATION
$objInboxMailer	= new InboxMailer;
$objMasterDB	= new DB;

//DB CONNECTION
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);
$objInboxMailer->dbConnect('S', $varDbInfo['DATABASE']);

//SESSION VARIABLES
$sessMatriId		= $varGetCookieInfo["MATRIID"];

//CHECK COOKIE 
if($sessMatriId=='') {
	echo "You are either logged off or your session timed out. <a href='".$confValues['SERVERURL']."/login/' class='clr1'>Click here </a> to login.<br>";exit;
}//if

//VARIABLE DECLARATION
$varInterestId		= $_POST['iid'];
$varCurrDivNo		= $_POST['currno'];
$varDeclineSubmit	= $_POST['frmDecSubmit'];
$varCurrentDate		= date('Y-m-d H:i:s');

//CONTROL STATEMENT
if ($varInterestId!='' && $sessMatriId !="" && $varDeclineSubmit=='yes') {

	//Delined Message option
	$varDeclineMsg = $_POST['declineopt'];
	
	//GET MatriId FOR IF MEMBERS DECLINED THE MESSAGES
	$varCondition			= "WHERE Interest_Id=".$objMasterDB->doEscapeString($varInterestId,$objMasterDB)." AND MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
	$varFields				= array('Opposite_MatriId','Status','Delete_Status', 'Interest_Option');
	$varExecute				= $objMasterDB->select($varTable['INTERESTRECEIVEDINFO'], $varFields, $varCondition, 0);
	$varInterCount			= mysql_num_rows($varExecute);
	$varInterestPrevInfo	= mysql_fetch_array($varExecute);
	$varOppMatriId			= $varInterestPrevInfo['Opposite_MatriId'];
	$varPrevStatus			= $varInterestPrevInfo['Status'];
	$varDeleteStatus		= $varInterestPrevInfo['Delete_Status'];
	$varSenderDelStatus		= 1;

	if($varPrevStatus == 0 && $varDeleteStatus==0 && $varInterCount==1)
	{
		//UPDATE Decline STATUS IN SENDER TABLE
		$varFields				= array('Status');
		$varCondition			= "WHERE Interest_Id=".$objMasterDB->doEscapeString($varInterestId,$objMasterDB);
		$varExecute				= $objMasterDB->select($varTable['INTERESTSENTINFO'], $varFields, $varCondition, 0);
		$varSenderSideStatus	= mysql_fetch_array($varExecute);
		
		if($varSenderSideStatus['Status'] != 5)
		{
			$varFields			= array('Status','Date_Acted','Declined_Option');
			$varFieldsValues	= array(3, "'".$varCurrentDate."'", $objMasterDB->doEscapeString($varDeclineMsg,$objMasterDB));
			$varCondition		= " Interest_Id=".$objMasterDB->doEscapeString($varInterestId,$objMasterDB);
			$objMasterDB->update($varTable['INTERESTSENTINFO'], $varFields, $varFieldsValues, $varCondition);
			$varSenderDelStatus	= 0;
		}//if
	}//if
	
	if($varPrevStatus == 0 && $varInterCount==1)
	{
	$varFields			= array('Status','Date_Acted','Declined_Option');
	$varFieldsValues	= array(3, "'".$varCurrentDate."'", "'".$varDeclineMsg."'");
	$varCondition		= ' Interest_Id='.$objMasterDB->doEscapeString($varInterestId,$objMasterDB);
	$objMasterDB->update($varTable['INTERESTRECEIVEDINFO'], $varFields, $varFieldsValues, $varCondition);

	//SEND E-MAIL TO RECEIVER
	$objInboxMailer->mymessagesMailer($sessMatriId, $varOppMatriId, $varInterestId, 'InterestDecline', $varCurrentDate);
	
	//UPDATE DECLINE STATUS IN TO LAST ACTION TABLE
	if($varDeleteStatus == 0)
	{
		#sender side
		$varCondition	= " Interest_Id_Sent=".$objMasterDB->doEscapeString($varInterestId,$objMasterDB)." AND Opposite_MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$varFields		= array('Interest_Sent_Status','Date_Updated');
		$varFieldsValues= array('3',"'".$varCurrentDate."'");
		$objMasterDB->update($varTable['MEMBERACTIONINFO'], $varFields, $varFieldsValues, $varCondition);
	}//if
	#receiver side	
	$varCondition		= " Interest_Id_Received=".$objMasterDB->doEscapeString($varInterestId,$objMasterDB)." AND MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
	$varFields			= array('Interest_Received_Status','Date_Updated');
	$varFieldsValues	= array('3',"'".$varCurrentDate."'");
	$objMasterDB->update($varTable['MEMBERACTIONINFO'], $varFields, $varFieldsValues, $varCondition);


	//UPDATE DECLINE COUNT IN memberstatistics
	#sender side
	if(($varDeleteStatus == 0) && ($varSenderDelStatus==0))
	{
		$varCondition		= " MatriId=".$objMasterDB->doEscapeString($varOppMatriId,$objMasterDB);
		$varFields			= array('Interest_Pending_Sent','Interest_Declined_Sent');
		$varFieldsValues	= array('(Interest_Pending_Sent-1)','(Interest_Declined_Sent+1)');
		$objMasterDB->update($varTable['MEMBERSTATISTICS'], $varFields, $varFieldsValues, $varCondition);

	}//if
	
	#receiver side
	$varCondition		= " MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
	$varFields			= array('Interest_Pending_Received','Interest_Declined_Received');
	$varFieldsValues	= array('(Interest_Pending_Received-1)','(Interest_Declined_Received+1)');
	$objMasterDB->update($varTable['MEMBERSTATISTICS'], $varFields, $varFieldsValues, $varCondition);

	//UPDATE COOKIE
	include_once($varRootBasePath."/www/login/updatemessagescookie.php");
	$varMsgTxt = 'You have declined the message.';

	/*//NEW FLOW STARTS HERE -->
	// Insert in interestsentinfo
	$varFields	= array('MatriId','Opposite_MatriId','Interest_Option','Status','Date_Sent');
	$varFldsVal	= array("'".$sessMatriId."'","'".$varOppMatriId."'",$varInterestPrevInfo['Interest_Option'],23,"'".$varCurrentDate."'");
	$varIntId	= $objMasterDB->insert($varTable['INTERESTSENTINFO'],$varFields,$varFldsVal); 
	
	if($varIntId >0)
	{
	// Insert in interestpendinginfo
	$varFields	= array('Interest_Id','MatriId','Opposite_MatriId','Interest_Option','Status','Date_Updated');
	$varFldsVal	= array($varIntId,"'".$varOppMatriId."'","'".$sessMatriId."'",$varInterestPrevInfo['Interest_Option'],23,"'".$varCurrentDate."'");
	$objMasterDB->insert($varTable['INTERESTPENDINGINFO'],$varFields,$varFldsVal); 
	}
	//NEW FLOW ENDSS HERE -->*/

	}else{
		$varTxt = ($varPrevStatus == 1) ? 'Accepted' : ($varPrevStatus == 3) ? 'Declined' : 'Deleted';
		$varMsgTxt = 'This interest is already '.$varTxt.'.';
	}
	$varCont = '<div class="fright">
			<img src="'.$confValues['IMGSURL'].'/close.gif" onclick="hide_box_div(\'div_box'.$varCurrDivNo.'\');reloadMsg();" href="javascript:;" class="pntr" /></div><br clear="all"/>'.$varMsgTxt.'<div class="fright padt10"><input type="button" class="button" value="Close" onclick="hide_box_div(\'div_box'.$varCurrDivNo.'\');reloadMsg();"/></div>';
}
/*else if($varInterestId!='' && $varDeclineSubmit!='yes')
{
	$varCondition			= ' WHERE Interest_Id='.$varInterestId;
	$varFields				= array('Opposite_MatriId');
	$varExecute				= $objInboxMailer->select($varTable['INTERESTRECEIVEDINFO'], $varFields, $varCondition, 0);
	$varInterestPrevInfo	= mysql_fetch_array($varExecute);
	$varOppMatriId			= $varInterestPrevInfo['Opposite_MatriId'];

	if($varOppMatriId != ''){
	$varCont = '<div class="fright"><img src="'.$confValues['IMGSURL'].'/close.gif" onclick="hide_box_div(\'div_box'.$varCurrDivNo.'\');" href="javascript:;" class="pntr" /></div><br clear="all"/>Choose a message from below to convey to member that you\'re not interested.<br clear="all"><br clear="all"><form name="frmDec">';
	foreach($arrDeclineInterestList as $key=>$value){
		$varChecked	 = ($key==1)? 'checked' : ''; 
		$varCont	.= '<input type="radio" class="frmelements" name="declinedopt" value="'.$key.'" id="declinedopt" '.$varChecked.'>'.$value.'<br>';
	}
	$varCont .= '</form><div class="fright padt10"><input type="button" class="button" value="Decline Now" onclick="intDecCall('.$varInterestId.','.$varCurrDivNo.',\'1\');"/></div>';
	}else{
	$varCont  = 'This message is not available.';
	}
}*/

print $varCont;

//UNSET OBJ
$objInboxMailer->dbClose();
$objMasterDB->dbClose();
unset($objInboxMailer);
unset($objMasterDB);
?>