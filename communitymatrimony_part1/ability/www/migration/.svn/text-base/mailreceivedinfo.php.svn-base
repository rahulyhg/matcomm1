<?php

	//BASE DIRECTORY
	$varRootBasePath = '/home/product/community/ability';

	//OBJECT DECLARTION
	$objProductDB	= new DB;
	$objCommunityDB	= new DB;

	//DB CONNECTION
	$objProductDB->dbConnect('M',$varDbInfo['DATABASE']);
	$objCommunityDB->dbConnect('M','mmatrimonytemp');

	#Product DB fields
	$varFields		= array('Mail_Id','MatriId','Opposite_MatriId','Mail_Message','Replied_Message','Mail_Folder','Mail_Follow_Up','Status','Replied_Status','Notes','Forwarded','Date_Forwarded','Date_Read','Date_Replied','Date_Declined','Date_Received','Date_Deleted','Message_Read','Delete_Status');
	$varCondition	= ' ORDER BY Mail_Id ASC LIMIT 10';
	$varExecute		= $objProductDB->select($varTable['MAILRECEIVEDINFO'], $varFields, $varCondition,0);


	while($varMailReceivedInfo	= mysql_fetch_array($varExecute)) {

		$varProductMailId			= $varMailReceivedInfo['Mail_Id'];
		$varProductMatriId			= $varMailReceivedInfo['MatriId'];
		$varProductOppositeMatriId	= $varMailReceivedInfo['Opposite_MatriId'];
		$varProductMailMessage		= $varMailReceivedInfo['Mail_Message'];
		$varProductRepliedMessage	= $varMailReceivedInfo['Replied_Message'];
		$varProductMailFolder		= $varMailReceivedInfo['Mail_Folder'];
		$varProductMailFollowUp		= $varMailReceivedInfo['Mail_Follow_Up'];
		$varProductStatus			= $varMailReceivedInfo['Status'];
		$varProductRepliedStatus	= $varMailReceivedInfo['Replied_Status'];
		$varProductNotes			= $varMailReceivedInfo['Notes'];
		$varProductForwarded		= $varMailReceivedInfo['Forwarded'];
		$varProductDateForwarded	= $varMailReceivedInfo['Date_Forwarded'];
		$varProductDateRead			= $varMailReceivedInfo['Date_Read'];
		$varProductDateReplied		= $varMailReceivedInfo['Date_Replied'];
		$varProductDateDeclined		= $varMailReceivedInfo['Date_Declined'];
		$varProductDateReceived		= $varMailReceivedInfo['Date_Received'];
		$varProductDateDeleted		= $varMailReceivedInfo['Date_Deleted'];
		$varProductMessageRead		= $varMailReceivedInfo['Message_Read'];
		$varProductDeleteStatus		= $varMailReceivedInfo['Delete_Status'];

		//MIGRATE RECORD FROM MMATRIMONY TO COMMUNITYMATRIMONY INTERESTSENTINFO TABLE

		#CommunityMatrimony DB fields
		$varFields	= array('Mail_Id','MatriId','Opposite_MatriId','Mail_Message','Status','Date_Read','Date_Declined','Date_Received','Date_Deleted');

		$varFieldsValues	= array("'".$varProductMailId."'","'".$varProductMatriId."'","'".$varProductOppositeMatriId."'","'".$varProductMailMessage."'","'".$varProductStatus."'","'".$varProductDateRead."'","'".$varProductDateDeclined."'","'".$varProductDateReceived."'","'".$varProductDateDeleted."'");

		//New Mail
		$objCommunityDB->insert($varTable['MAILRECEIVEDINFO'], $varFields, $varFieldsValues);

		// REPLY PART
		if ($varProductStatus=='2' || $varProductStatus=='3'){

		if ($varProductStatus=='2') {
		$varFinalMailMessage	= $varProductRepliedMessage.'<BR> ----- Original Message ----- <BR>From: '.$varProductMatriId.'<BR>To: '.$varProductOppositeMatriId.'<BR><BR>'.$varProductMailMessage;
		} else { $varFinalMailMessage	= $varProductRepliedMessage; }

		$varProductStatus		= ($varProductStatus=='3') ? '13' : '1';

		
		#Insert one record into all replied members MAILSENTINFO table
		$varFields		= array('MatriId','Opposite_MatriId','Mail_Message','Status','Date_Read','Date_Declined','Date_Sent','Date_Deleted');

		$varFieldsValues	= array("'".$varProductMatriId."'","'".$varProductOppositeMatriId."'","'".$varFinalMailMessage."'","'".$varProductStatus."'","'".$varProductDateRead."'","'".$varProductDateDeclined."'","'".$varProductDateSent."'","'".$varProductDateDeleted."'");

		$varCommunityMailReceivedId	= $objCommunityDB->insert($varTable['MAILSENTINFO'], $varFields, $varFieldsValues);


		#Insert one record into all replied received members MAILRECEIVEDINFO table
		$varFields	= array('Mail_Id','MatriId','Opposite_MatriId','Mail_Message','Status','Date_Read','Date_Declined','Date_Received','Date_Deleted');

		$varFieldsValues	= array("'".$varCommunityMailReceivedId."'","'".$varProductOppositeMatriId."'","'".$varProductMatriId."'","'".$varFinalMailMessage."'","'".$varProductStatus."'","'".$varProductDateRead."'","'".$varProductDateDeclined."'","'".$varProductDateReceived."'","'".$varProductDateDeleted."'");

		$objCommunityDB->insert($varTable['MAILRECEIVEDINFO'], $varFields, $varFieldsValues);

		}

	}//while

?>