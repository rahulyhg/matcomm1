<?php
#====================================================================================================
# Author 		: S Rohini
# Start Date	: 03 Sep 2008
# End Date		: 03 Sep 2008
# Project		: MatrimonyProduct
# Module		: Decline Personalized Message
#====================================================================================================
//Base Path //
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

// Include the files //
include_once $varRootBasePath."/conf/config.cil14";
include_once $varRootBasePath."/conf/cookieconfig.cil14";
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once $varRootBasePath."/lib/clsMessage.php";
include_once($varRootBasePath."/lib/clsInboxMailer.php");

//OBJECT DECLARTION
$objMessage		= new Message;
$objInboxMailer	= new InboxMailer;

$objInboxMailer->dbConnect('M', $varDbInfo['DATABASE']);
$objMessage->dbConnect('M', $varDbInfo['DATABASE']);

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];

//VARIABLE DECLARATION
$varCurrentDate	= date('Y-m-d H:i:s');
$varMessageId	= $_REQUEST["msgid"];
$varFormSubmit	= $_REQUEST['decSubmit'];

#CHECK SESSION IS SET OR NOT
if ($sessMatriId=="")	{ echo "You are either logged off or your session timed out. <a href='../login/' class=\"smalltxt clr1\">Click here </a> to login.";exit;}

if ($varFormSubmit=="yes")
{
	//SELECT Opposite MatriId
	$varWhereCond	= " WHERE Mail_Id=".$objMessage->doEscapeString($varMessageId,$objMessage);
	$varFields		= array('Opposite_MatriId','Status','Delete_Status','Mail_Message');
	$varRecvInfo	= $objMessage->select($varTable['MAILRECEIVEDINFO'],$varFields,$varWhereCond,1);
	$varOppMatriId	= $varRecvInfo[0]['Opposite_MatriId'];
	$varPrevStatus	= $varRecvInfo[0]['Status'];
	$varCurrMsg		= addslashes(nl2br($varRecvInfo[0]['Mail_Message']));

	if($varPrevStatus == 1  && count($varRecvInfo)==1 ){

		//UPDATE Status in mailreceivedinfo
		$varWhereCond	= " Mail_Id=".$objMessage->doEscapeString($varMessageId,$objMessage);
		$varFields		= array('Date_Declined','Status');
		$varFldsVal		= array("'".$varCurrentDate."'", 3);
		$objMessage->update($varTable['MAILRECEIVEDINFO'],$varFields,$varFldsVal,$varWhereCond);
		
		$varSenderDelStatus		= 1;
		if($varRecvInfo[0]['Delete_Status']==0)
		{
			//UPDATE Status in mailsentinfo
			$varWhereCond		= "WHERE Mail_Id=".$objMessage->doEscapeString($varMessageId,$objMessage);
			$varFields			= array('Status');
			$varSenderStatus 	= $objMessage->select($varTable['MAILSENTINFO'],$varFields,$varWhereCond,1);
			$varWhereCond		= " Mail_Id=".$varMessageId;
			if($varSenderStatus[0]['Status'] != 5)
			{
				$varFields		= array('Date_Declined','Status');
				$varFldsVal		= array("'".$varCurrentDate."'", 3);
				$objMessage->update($varTable['MAILSENTINFO'],$varFields,$varFldsVal,$varWhereCond);
				$varSenderDelStatus		= 0;
			}//if
			
			$varWhereCond	= " Mail_Id_Sent=".$objMessage->doEscapeString($varMessageId,$objMessage)." AND Opposite_MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
			$varFields		= array('Mail_Sent_Status','Date_Updated','Sender_Declined','Sender_Declined_Date');
			$varFldsVal		= array(3,"'".$varCurrentDate."'",1,"'".$varCurrentDate."'");
			$objMessage->update($varTable['MEMBERACTIONINFO'],$varFields,$varFldsVal,$varWhereCond);
		}//if

		#receiver side	
		$varWhereCond	= " Mail_Id_Received=".$objMessage->doEscapeString($varMessageId,$objMessage)." AND MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
		$varFields		= array('Mail_Received_Status','Date_Updated','Receiver_Declined','Receiver_Declined_Date');
		$varFldsVal		= array(3,"'".$varCurrentDate."'",1,"'".$varCurrentDate."'");
		$objMessage->update($varTable['MEMBERACTIONINFO'],$varFields,$varFldsVal,$varWhereCond);

		//SEND E-MAIL TO RECEIVER
		$objInboxMailer->mymessagesMailer($sessMatriId, $varOppMatriId, $varMessageId, 'Decline', $varCurrentDate);

		//UPDATE MAIL DECLINE COUNT IN memberstatistics
		if($varSenderDelStatus	== 0)
		{
			#sender side
			$varWhereCond	= " MatriId='".$varOppMatriId."'";
			$varFields		= array('Mail_Read_Sent','Mail_Declined_Sent');	
			$varFldsVal		= array("(Mail_Read_Sent-1)",'(Mail_Declined_Sent+1)');
			$objMessage->update($varTable['MEMBERSTATISTICS'],$varFields,$varFldsVal,$varWhereCond);
		}//if
		#receiver side
		$varWhereCond	= " MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
		$varFields		= array('Mail_Read_Received','Mail_Declined_Received');	
		$varFldsVal		= array("(Mail_Read_Received-1)",'(Mail_Declined_Received+1)');
		$objMessage->update($varTable['MEMBERSTATISTICS'],$varFields,$varFldsVal,$varWhereCond);
		$varDisplayResult="You have declined the message.";

		/*//NEW MESSAGE FLOW STARTS HERE -->
		// Insert Mail in mailsentinfo
		$varFields	= array('MatriId','Opposite_MatriId','Mail_Message','Date_Sent','Status');
		$varFldsVal	= array("'".$sessMatriId."'","'".$varOppMatriId."'","'".$varCurrMsg."'","'".$varCurrentDate."'",13);
		$varMailId	= $objMessage->insert($varTable['MAILSENTINFO'],$varFields,$varFldsVal); 
		
		if($varMailId >0)
		{
		// Insert Mail in mailpendinginfo
		$varFields	= array('Mail_Id','MatriId','Opposite_MatriId','Mail_Message','Date_Updated','Status');
		$varFldsVal	= array($varMailId,"'".$varOppMatriId."'","'".$sessMatriId."'","'".$varCurrMsg."'","'".$varCurrentDate."'",13);
		$objMessage->insert($varTable['MAILPENDINGINFO'],$varFields,$varFldsVal);
		}

		//NEW MESSAGE FLOW STARTS HERE -->*/
	}else{
		if($varPrevStatus == 2){$varDisplayResult="You have alreay replied for this message.";}
		else if($varPrevStatus == 3){$varDisplayResult="You have alreay declined for this message.";}
		else if(count($varRecvInfo) ==0){$varDisplayResult="This message is not available.";}
	}

	$varCont	= '<div class="fright"><img src="'.$confValues['IMGSURL'].'/close.gif" onclick="hideDecDiv();" class="pntr"/></div><br clear="all"/><div class="fleft">'.$varDisplayResult.'</div><div class="fright padt10"><input type="button" class="button" value="Close" onclick="hideDecDiv()"/>&nbsp;&nbsp;&nbsp;</div>';

}else{
	$varCont	= '<div class="fright"><img src="'.$confValues['IMGSURL'].'/close.gif" onclick="hideDecDiv();" class="pntr"/></div><br clear="all"/><div class="fleft">Are you sure you want to decline this member\'s message?</div><div class="fright padt10"><input type="button" class="button" value="Yes" onclick="showDecDiv('.$varMessageId.',\'S\')"/> &nbsp;<input type="button" class="button" value="No" onclick="hideDecDiv()"/>&nbsp;&nbsp;</div>';
}
echo $varCont;
//if
//UNSET OBJECT
$objMessage->dbClose();
$objInboxMailer->dbClose();

unset($objMessage);
unset($objInboxMailer);
?>