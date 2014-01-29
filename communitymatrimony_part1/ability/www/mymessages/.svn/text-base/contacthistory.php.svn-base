<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		: contacthistory.php
#================================================================================================================
   # Description	: 
#================================================================================================================

//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/messagevars.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION VARIABLES
$sessMatriId		= $varGetCookieInfo['MATRIID'];
$varOppositeMatriId	= $_REQUEST['ID'];
$varReqComeFrom		= $_REQUEST['reqCF'];

if ($sessMatriId != ''  && $varOppositeMatriId != ''){
	//Object initialization
	$objSlaveDB		= new DB;

	//CONNECTION DECLARATION
	$varSlaveConn	= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

	//get Opposite matriid's name and Username
	$arrFields		= array('Name','MatriId');
	$varCondition	= "WHERE MatriId=".$objSlaveDB->doEscapeString($varOppositeMatriId,$objSlaveDB);
	$arrResultSet	= $objSlaveDB->select($varTable['MEMBERINFO'],$arrFields,$varCondition,0);
	$resultSet		= mysql_fetch_assoc($arrResultSet);

	$arrInterestReceiverStatus		= array(0=>'Pending',1=>'Accepted',3=>'Declined',6=>'Accepted',7=>'Declined');
	$arrInterestSenderStatus		= array(0=>'Pending',1=>'Accepted',3=>'Declined',5=>'Deleted');
	$arrMailReceiverStatus			= array(0=>'Unread',1=>'Not Replied',2=>'Replied',3=>'Declined',6=>'Unread', 7=>'Not Replied',8=>'Replied',9=>'Declined');
	$arrMailSenderStatus			= array(0=>'Unread',1=>'Not Replied',2=>'Replied',3=>'Declined',5=>'Deleted');

	$funQuery		= "SELECT Opposite_MatriId AS ToId,MatriId AS FromId, Status, Date_Received AS Date, Mail_Message AS Msg,Replied_Status AS ReplyStatus,Replied_Message as ReplyMsg,Date_Replied AS ReplyDate, 1 AS MsgReceived,0 AS MsgSent,0 AS IntReceived,0 AS IntSent,0 AS IntOpt,0 AS DecOpt ,0 AS DecDate,0 AS DecMsg,0 AS IntSendDate ,0 AS IntRecDate FROM ".$varTable['MAILRECEIVEDINFO']." WHERE Opposite_MatriId=".$objSlaveDB->doEscapeString($varOppositeMatriId,$objSlaveDB)." AND MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB)." AND Status!=13 UNION	SELECT MatriId AS FromId,Opposite_MatriId AS ToId, Status, Date_Sent AS Date,Mail_Message AS Msg,Replied_Status AS ReplyStatus,Replied_Message as ReplyMsg,Date_Replied AS ReplyDate, 0 AS MsgReceived,1 AS MsgSent,0 AS IntReceived,0 AS IntSent ,0 AS IntOpt,0 AS DecOpt ,0 AS DecDate,0 AS DecMsg,0 AS IntSendDate ,0 AS IntRecDate  FROM ".$varTable['MAILSENTINFO']." WHERE Opposite_MatriId=".$objSlaveDB->doEscapeString($varOppositeMatriId,$objSlaveDB)." AND MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB)." AND Status!=13 UNION SELECT Opposite_MatriId AS ToId,MatriId AS FromId,Status, Date_Received AS Date,Interest_Option AS Msg,0 AS ReplyStatus, 0 as ReplyMsg,0 AS ReplyDate,0 AS MsgReceived,0 AS MsgSent,1 AS IntReceived,0 AS IntSent ,Interest_Option AS IntOpt,1 AS DecOpt ,Date_Acted AS DecDate ,Declined_Option AS DecMsg,0 AS IntSendDate ,Date_Received AS IntRecDate FROM ".$varTable['INTERESTRECEIVEDINFO']." WHERE Opposite_MatriId=".$objSlaveDB->doEscapeString($varOppositeMatriId,$objSlaveDB)." AND MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB)." AND (Status!=21 OR Status!=23) UNION SELECT Opposite_MatriId AS ToId, MatriId AS FromId, Status, Date_Sent AS Date,Interest_Option AS Msg,0 AS ReplyStatus, 0 as ReplyMsg,0 AS ReplyDate,0 AS MsgReceived,0 AS MsgSent,0 AS IntReceived,1 AS IntSent , Interest_Option AS IntOpt,1 AS DecOpt ,Date_Accepted AS DecDate, Declined_Option AS DecMsg,Date_Sent AS IntSendDate ,0 AS IntRecDate FROM ".$varTable['INTERESTSENTINFO']." WHERE Opposite_MatriId=".$objSlaveDB->doEscapeString($varOppositeMatriId,$objSlaveDB)." AND MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB)." AND (Status!=21 OR Status!=23) order by Date desc";
			
	$varExecute	=  mysql_query($funQuery,$objSlaveDB->clsDBLink);
	$varContent	= '';
	$varContent.='<div id="dispcontent" style="overflow: auto; background-color: white; width: 520px;" class="smalltxt"><br><div style="padding: 0px 20px 10px;"><font class="mediumtxt boldtxt clr3"><b>Contact History </b></font><div class="vdotline1"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="1"></div><br clear="all"><font class="smalltxt">All the communication exchanged between <b> '.$varGetCookieInfo["NAME"].' ('.$sessMatriId.')</b> and <b>'.$resultSet["Name"].' ('.$resultSet["MatriId"].')</b> is displayed here. This includes Personalised Messages and Express Interest messages.</font><br><br clear="all">
	<div style="height:160px;overflow: auto;border: 1px solid #666;background-color: #FFF;padding:8px;">';
	while ($row = mysql_fetch_assoc($varExecute)) {		
		
		if($row['MsgReceived'] == 1 || $row['MsgSent'] == 1  ){
				if ($row['MsgReceived'] == 1) {
					if ($row['ReplyStatus'] == 1) {
					
						$varContent.= "<b>Message Reply on :</b>".date("d-M-Y H:i",  strtotime($row['ReplyDate']))."<br>"."<b>Status :</b> ".$arrMailReceiverStatus[$row['Status']]."<br><b> Message :</b>".stripslashes(str_replace('\n', '<br>',$row['ReplyMsg']));
						$varContent.='<br><br><div class="vdotline1"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="1"></div>';	
					}
					$varContent.=" <b>Message received on :</b>".date("d-M-Y H:i",  strtotime($row['Date']))."<br>"."<b>Status :</b>".$arrMailReceiverStatus[$row['Status']]."<br><b> Message :</b>".stripslashes(str_replace('\n', '<br>',$row['Msg']));
					$varContent.='<br><br><div class="vdotline1"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="1"></div>';	
				}else if($row['MsgSent'] == 1) {
					if ($row['ReplyStatus'] == 1) {
						$varContent.= "<b>Message Reply on :</b>".date("d-M-Y H:i",  strtotime($row['ReplyDate']))."<br>"."<b>Status :</b> Read And "." ".$arrMailSenderStatus[$row['Status']]."<br><b> Message :</b>".stripslashes(str_replace('\n', '<br>',$row['ReplyMsg']));
						$varContent.='<br><br><div class="vdotline1"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="1"></div>';	
					}
					$varContent.="<b>Message sent on :</b>".date("d-M-Y H:i",  strtotime($row['Date']))."<br>"."<b>Status :</b>"." ".$arrMailSenderStatus[$row['Status']]."<br><b> Message :</b>".stripslashes(str_replace('\n', '<br>',$row['Msg']));
					$varContent.='<br><br><div class="vdotline1"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="1"></div>';	
				}
		}elseif($row['IntReceived'] == 1 || $row['IntSent'] == 1){
				if ($row['Status'] == 3 && $row['Status'] == 3){
						$varContent.= "<b>Express interest Declined on :</b>".date("d-M-Y H:i", strtotime($row['DecDate']))."<br> <b>Status :</b>".$arrInterestReceiverStatus[$row['Status']]."<br><b>Message :</b>".stripslashes(str_replace('\n', '<br>',$arrDeclineInterestList[$row['DecOpt']]));
						$varContent.='<br><br><div class="vdotline1"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="1"></div>';	
				}
				if ($row['IntReceived'] == 1) {
					$varContent.= "<b>Express interest recived on :</b>".date("d-M-Y H:i", strtotime($row['IntRecDate']))."<br><b> Status :</b>".$arrInterestReceiverStatus[$row['Status']]."<br><b>Message :</b>".stripslashes(str_replace('\n', '<br>',$arrExpressInterestList[$row['Msg']]));
					$varContent.='<br><br><div class="vdotline1"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="1"></div>';	
				}elseif ($row['IntSent'] == 1) {
					$varContent.= "<b>Express interest Sent on :</b>".date("d-M-Y H:i", strtotime($row['IntSendDate']))."<br> <b>Status :</b>".$arrInterestSenderStatus[$row['Status']]."<br><b>Message :</b>".stripslashes(str_replace('\n', '<br>',$arrExpressInterestList[$row['Msg']]));
					$varContent.='<br><br><div class="vdotline1"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="1"></div>';	
				}
		}	
	}

	$varContent.='</div></div></div></div>';
	echo '<link rel="stylesheet" href="'.$confValues['CSSPATH'].'/global-style.css">';

	if($varReqComeFrom == 1) {
		echo '<div class="fright"><img src="'.$confValues['IMGSURL'].'/close.gif" onclick="hide_box();" href="javascript:;" class="pntr" /></div><br clear="all"/>'.$varContent.'<div class="fright padt10"><input type="button" class="button" value="Close" onclick="hide_box();"/></div>';
	} else {
		echo $varContent;
	}

	$objSlaveDB->dbClose();
	unset($objSlaveDB);
}
?>
<!-- <div class="fright" style="padding-top:2px;padding-right:27px;_padding-right:11px;"><input type="button" class="button" name="btnclose" value="Close" onclick="javascript:parent.closeIframe('iframeicon','icondiv');"></div> -->