<?php
#====================================================================================================
# Author 		: S Rohini
# Start Date	: 11 Sep 2008
# End Date	: 11 Sep 2008
# Project		: MatrimonyProduct
# Module		: Message Status Update
#====================================================================================================
if($varOppMatriId!='') {
	$varMsgStatusCond		= ' Mail_Id='.$varMessageId;
	$varMsgStatusFlds		= array('Status','Date_Read');
	$varMsgStatusFldVal		= array(1,"'".$varCurrentDate."'");
	$objMessage->update($varTable['MAILRECEIVEDINFO'],$varMsgStatusFlds,$varMsgStatusFldVal,$varMsgStatusCond);

	if ($varSenderDelStatus==0){
		$objMessage->update($varTable['MAILSENTINFO'],$varMsgStatusFlds,$varMsgStatusFldVal,$varMsgStatusCond);
		$varMemSentCond		= " MatriId='".$varOppMatriId."'";
		$varMemSentFlds		= array('Mail_Read_Sent','Mail_UnRead_Sent');
		$varMemSentFldVal	= array('(Mail_Read_Sent+1)','(Mail_UnRead_Sent-1)');
		$objMessage->update($varTable['MEMBERSTATISTICS'],$varMemSentFlds,$varMemSentFldVal,$varMemSentCond);
	}

	$varMemRecCond		= " MatriId='".$sessMatriId."'";
	$varMemRecFlds		= array('Mail_Read_Received','Mail_UnRead_Received');
	$varMemRecFldVal	= array('(Mail_Read_Received+1)','(Mail_UnRead_Received-1)');
	$objMessage->update($varTable['MEMBERSTATISTICS'],$varMemRecFlds,$varMemRecFldVal,$varMemRecCond);

	$varMemStSentCond		= " MatriId='".$varOppMatriId."' AND Opposite_MatriId='".$sessMatriId."' AND Mail_Id_Sent=".$varMessageId;
	$varMemActFlds			= array('Mail_Sent_Status');
	$varMemActFldVal		= array(1);
	$objMessage->update($varTable['MEMBERACTIONINFO'],$varMemActFlds,$varMemActFldVal,$varMemStSentCond);

	$varMemActFlds			= array('Mail_Received_Status');
	$varMemStRecCond		= " MatriId='".$sessMatriId."' AND Opposite_MatriId='".$varOppMatriId."' AND Mail_Id_Received=".$varMessageId;
	$objMessage->update($varTable['MEMBERACTIONINFO'],$varMemActFlds,$varMemActFldVal,$varMemStRecCond);
}
?>