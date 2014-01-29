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
$varCurrentDate		= date('Y-m-d H:i:s');

//CONTROL STATEMENT
if ($varInterestId!='' && $sessMatriId !="") {

	//GET MatriId FOR IF MEMBERS DECLINED THE MESSAGES
	$varCondition			= "WHERE Interest_Id=".$objMasterDB->doEscapeString($varInterestId,$objMasterDB)." AND MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
	$varFields				= array('Opposite_MatriId','Status','Delete_Status','Interest_Option');
	$varExecute				= $objMasterDB->select($varTable['INTERESTRECEIVEDINFO'], $varFields, $varCondition, 0);
	$varInterCount			= mysql_num_rows($varExecute);
	$varInterestPrevInfo	= mysql_fetch_array($varExecute);
	$varOppMatriId			= $varInterestPrevInfo['Opposite_MatriId'];
	$varAcceptStatus		= ($varInterCount == 1 && ($varInterestPrevInfo['Status']==0 || $varInterestPrevInfo['Status']==3)) ? 'yes' : 'no';
	$varDeleteStatus		= $varInterestPrevInfo['Delete_Status'];
	$varSenderDelStatus		= 1;

	if($varAcceptStatus == 'yes' && $varDeleteStatus==0 && $varInterCount==1)
	{
		//UPDATE Decline STATUS IN SENDER TABLE
		$varFields				= array('Status');
		$varCondition			= 'WHERE Interest_Id='.$objMasterDB->doEscapeString($varInterestId,$objMasterDB);
		$varExecute				= $objMasterDB->select($varTable['INTERESTSENTINFO'], $varFields, $varCondition, 0);
		$varSenderSideStatus	= mysql_fetch_array($varExecute);
		
		if($varSenderSideStatus['Status'] != 5)
		{
			$varFields			= array('Status','Date_Acted');
			$varFieldsValues	= array(1, "'".$varCurrentDate."'");
			$varCondition		= ' Interest_Id='.$objMasterDB->doEscapeString($varInterestId,$objMasterDB);
			$objMasterDB->update($varTable['INTERESTSENTINFO'], $varFields, $varFieldsValues, $varCondition);
			$varSenderDelStatus	= 0;
		}//if
	}//if
	
	if($varAcceptStatus == 'yes' && $varInterCount==1)
	{
	$varFields			= array('Status','Date_Acted');
	$varFieldsValues	= array(1, "'".$varCurrentDate."'");
	$varCondition		= ' Interest_Id='.$objMasterDB->doEscapeString($varInterestId,$objMasterDB);
	$objMasterDB->update($varTable['INTERESTRECEIVEDINFO'], $varFields, $varFieldsValues, $varCondition);

	#Send Email to Opposite Id
	$objInboxMailer->mymessagesMailer($sessMatriId, $varOppMatriId, $varInterestId, 'InterestAccept', $varCurrentDate);
	
	//UPDATE DECLINE STATUS IN TO LAST ACTION TABLE
	if($varDeleteStatus == 0)
	{
		#sender side
		$varCondition	= " Interest_Id_Sent=".$objMasterDB->doEscapeString($varInterestId,$objMasterDB)." AND Opposite_MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$varFields		= array('Interest_Sent_Status','Date_Updated');
		$varFieldsValues= array(1,"'".$varCurrentDate."'");
		$objMasterDB->update($varTable['MEMBERACTIONINFO'], $varFields, $varFieldsValues, $varCondition);
	}//if
	#receiver side	
	$varCondition		= " Interest_Id_Received=".$objMasterDB->doEscapeString($varInterestId,$objMasterDB)." AND MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
	$varFields			= array('Interest_Received_Status','Date_Updated');
	$varFieldsValues	= array(1,"'".$varCurrentDate."'");
	$objMasterDB->update($varTable['MEMBERACTIONINFO'], $varFields, $varFieldsValues, $varCondition);

	//UPDATE DECLINE COUNT IN memberstatistics
	if($varInterestPrevInfo['Status'] == 0 && $varAcceptStatus=='yes')
	{
		if(($varDeleteStatus==0) && ($varSenderDelStatus==0))
		{
			#sender side
			$varFields			= array('Interest_Pending_Sent','Interest_Accept_Sent','CumulativeAcceptSentInterest');
			$varFieldsValues	= array('(Interest_Pending_Sent-1)','(Interest_Accept_Sent+1)','(CumulativeAcceptSentInterest+1)');
			$varCondition		= "MatriId='".$varOppMatriId."'";
			$objMasterDB->update($varTable['MEMBERSTATISTICS'], $varFields, $varFieldsValues, $varCondition);
		}//if		
		#receiver side
		$varFields			= array('Interest_Pending_Received','Interest_Accept_Received','CumulativeAcceptReceivedInterest');
		$varFieldsValues	= array('(Interest_Pending_Received-1)','(Interest_Accept_Received+1)','(CumulativeAcceptReceivedInterest+1)');
		$varCondition		= "MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$objMasterDB->update($varTable['MEMBERSTATISTICS'], $varFields, $varFieldsValues, $varCondition);
	}
	elseif($varInterestPrevInfo['Status'] == 3 && $varAcceptStatus=='yes')
	{
	if(($varDeleteStatus==0) && ($varSenderDelStatus==0))
	{
		#sender side
		$varFields			= array('Interest_Declined_Sent','Interest_Accept_Sent','CumulativeAcceptSentInterest');
		$varFieldsValues	= array('(Interest_Declined_Sent-1)','(Interest_Accept_Sent+1)','(CumulativeAcceptSentInterest+1)');
		$varCondition		= "MatriId='".$varOppMatriId."'";
		$objMasterDB->update($varTable['MEMBERSTATISTICS'], $varFields, $varFieldsValues, $varCondition);

	}//if		
	#receiver side
	$varFields			= array('Interest_Declined_Received','Interest_Accept_Received','CumulativeAcceptReceivedInterest');
	$varFieldsValues	= array('(Interest_Declined_Received-1)','(Interest_Accept_Received+1)','(CumulativeAcceptReceivedInterest+1)');
	$varCondition		= "MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
	$objMasterDB->update($varTable['MEMBERSTATISTICS'], $varFields, $varFieldsValues, $varCondition);
	}//elseif

	//UPDATE COOKIE
	include_once($varRootBasePath."/www/login/updatemessagescookie.php");
	$varMsgTxt = 'You have accepted the message.';

	/*//NEW FLOW STARTS HERE -->
	// Insert in interestsentinfo
	$varFields	= array('MatriId','Opposite_MatriId','Interest_Option','Status','Date_Sent');
	$varFldsVal	= array("'".$sessMatriId."'","'".$varOppMatriId."'",$varInterestPrevInfo['Interest_Option'],21,"'".$varCurrentDate."'");
	$varIntId	= $objMasterDB->insert($varTable['INTERESTSENTINFO'],$varFields,$varFldsVal); 
	
	if($varIntId >0)
	{
	// Insert in interestpendinginfo
	$varFields	= array('Interest_Id','MatriId','Opposite_MatriId','Interest_Option','Status','Date_Updated');
	$varFldsVal	= array($varIntId,"'".$varOppMatriId."'","'".$sessMatriId."'",$varInterestPrevInfo['Interest_Option'],21,"'".$varCurrentDate."'");
	$objMasterDB->insert($varTable['INTERESTPENDINGINFO'],$varFields,$varFldsVal); 
	}
	//NEW FLOW ENDSS HERE -->*/

	}else{
		$varTxt = ($varInterestPrevInfo['Status'] == 1) ? 'accepted' : 'deleted';
		$varMsgTxt = 'You have already '.$varTxt.' this message.';
	}
	$varCont = '<div class="fright">
			<img src="'.$confValues['IMGSURL'].'/close.gif" onclick="hide_box_div(\'div_box'.$varCurrDivNo.'\');reloadMsg();" href="javascript:;" class="pntr" /></div><br clear="all"/>'.$varMsgTxt.'<div class="fright padt10"><input type="button" class="button" value="Close" onclick="hide_box_div(\'div_box'.$varCurrDivNo.'\');reloadMsg();"/></div>';
}else{
	$varCont = '<div class="fright">
			<img src="'.$confValues['IMGSURL'].'/close.gif" onclick="hide_box_div(\'div_box'.$varCurrDivNo.'\');" href="javascript:;" class="pntr" /></div><br clear="all"/>This Interest not available.<div class="fright padt10"><input type="button" class="button" value="Close" onclick="hide_box_div(\'div_box'.$varCurrDivNo.'\');"/></div>';
}

print $varCont;

//UNSET OBJ
$objInboxMailer->dbClose();
$objMasterDB->dbClose();
unset($objInboxMailer);
unset($objMasterDB);
?>