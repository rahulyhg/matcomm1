<?
//BASE PATH
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//INCLUDED FILES
include_once $varRootBasePath."/conf/config.cil14";
include_once $varRootBasePath."/conf/cookieconfig.cil14";
include_once $varRootBasePath."/conf/emailsconfig.cil14";
include_once $varRootBasePath."/conf/dbinfo.cil14";
include_once $varRootBasePath."/lib/clsMessage.php";
include_once $varRootBasePath."/lib/clsMailManager.php";

//VARIABLE DECLERATION
$varMessageId	= $_POST['msgid'];
$varSubmit		= $_POST['msgSubmit'];
$varCurrMsg		= $_POST['msgTxt'];
$varMsgSendIds	= $_POST['oppids'];
$varJSCloseFun	= $_POST['type']=='mul' ? "hidediv('listalldiv');" : 'hide_box_msg();';
$varCurrentDate = date('Y-m-d H:i:s');

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo['PAIDSTATUS'];
$sessPublish	= $varGetCookieInfo['PUBLISH'];
$sessGender		= $varGetCookieInfo['GENDER'];
$sessName		= $varGetCookieInfo['NAME'];

//OBJECT DECLARTION
$objMessage		= new Message;
$objMailManager	= new MailManager;
$objMessage->dbConnect('M', $varDbInfo['DATABASE']);
$objMailManager->dbConnect('S', $varDbInfo['DATABASE']);

if($sessMatriId != ''){
	if($varSubmit == 'yes' && $varCurrMsg != ''){
		$varCurrMsg = preg_replace("/~\^~/", '&', $varCurrMsg);
		$varCurrMsg = $objMessage->fixScriptTag($varCurrMsg);
		$varCurrMsg = $objMessage->cross($varCurrMsg);
		$varCurrMsg = nl2br($varCurrMsg);
		$varCurrMsg = eregi_replace("&lt;javascript&gt;"," ",$varCurrMsg);
		$varCurrMsg = eregi_replace("&lt;/javascript&gt;"," ",$varCurrMsg);
		$varCurrMsg = eregi_replace("&lt;script&gt;"," ",$varCurrMsg);
		$varCurrMsg = eregi_replace("&lt;/script&gt;"," ",$varCurrMsg);
		$varCurrMsg = eregi_replace("&lt;vbscript&gt;"," ",$varCurrMsg);
		$varCurrMsg = eregi_replace("&lt;/vbscript&gt;"," ",$varCurrMsg);
		$varCurrMsg = eregi_replace("<br />","<br>",$varCurrMsg);

		//FOR ABUSIVE WORDS
		$varAbusivewords = $objMessage->abusivewordsOccurance(preg_replace("/\n/", '<BR>',$varCurrMsg));

		if($varAbusivewords == 1){
			$varFields		= array('Publish', 'Date_Updated');
			$varFieldsVal	= array(3, 'NOW()');
			$varWhereCond	= " MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
			$objMessage->update($varTable['MEMBERINFO'],$varFields,$varFieldsVal,$varWhereCond);
			$objMailManager->sendEmail($arrEmailsList['FROMMAIL'],$arrEmailsList['INFOEMAIL'],'Support Team',$arrEmailsList['SPECIALALERTEMAIL'].', nazir@bharatmatrimony.com',"Message with Abusive words - $sessMatriId",$varCurrMsg,$arrEmailsList['INFOEMAIL']);

		}else if($varAbusivewords == 0){
			if($varMessageId != '' && $varMsgSendIds!=''){
				$varDisplayMsg  = '';
				$varWhereCond	= 'WHERE Mail_Id='.$objMessage->doEscapeString($varMessageId,$objMessage);
				$varFields		= array('Opposite_MatriId','Mail_Message','Status','Delete_Status');
				$varMsgInfo		= $objMessage->select($varTable['MAILRECEIVEDINFO'],$varFields,$varWhereCond,1);
				$varPrevStatus	= $varMsgInfo[0]['Status'];
				$varOppMatriId	= $varMsgInfo[0]['Opposite_MatriId'];
				$varSenDel		= $varMsgInfo[0]['Delete_Status'];
				$varOldMessage	= $varMsgInfo[0]['Mail_Message'];

				if(count($varMsgInfo)==1 && $varPrevStatus==1)
				{
					//UPDATE REPLY STATUS
					$varWhereCond	= " Mail_Id=".$objMessage->doEscapeString($varMessageId,$objMessage);
					$varFields		= array('Date_Replied','Status','Replied_Message');
					$varFldsVal		= array("'".$varCurrentDate."'",2,$objMessage->doEscapeString($varCurrMsg,$objMessage));
					$objMessage->update($varTable['MAILRECEIVEDINFO'],$varFields,$varFldsVal,$varWhereCond);

					$varSenderDelStatus	= 1;
					if($varSenDel==0)
					{
						// Update Status IN mailsentinfo
						$varFields		= array('Status');
						$varWhereCond	= " WHERE Mail_Id=".$objMessage->doEscapeString($varMessageId,$objMessage);
						$varSenStatus 	= $objMessage->select($varTable['MAILSENTINFO'],$varFields,$varWhereCond,1);
						if($varSenStatus[0]['Status'] != 5)
						{
							$varWhereCond	= " Mail_Id=".$objMessage->doEscapeString($varMessageId,$objMessage);
							$varFields		= array('Date_Replied','Status','Replied_Message');
							$varFldsVal		= array("'".$varCurrentDate."'",2,$objMessage->doEscapeString($varCurrMsg,$objMessage));
							$objMessage->update($varTable['MAILSENTINFO'],$varFields,$varFldsVal,$varWhereCond);
							$varSenderDelStatus		= 0;
						}//if
					}//if

					//UPDATE REPLY STATUS IN TO LAST ACTION TABLE
					#sender side
					if($varSenderDelStatus==0)
					{
						$varWhereCond	= " Mail_Id_Sent=".$objMessage->doEscapeString($varMessageId,$objMessage)." AND Opposite_MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
						$varFields		= array('Mail_Sent_Status','Date_Updated','Sender_Replied','Sender_Replied_Date');
						$varFldsVal		= array(2,"'".$varCurrentDate."'",1,"'".$varCurrentDate."'");
						$objMessage->update($varTable['MEMBERACTIONINFO'],$varFields,$varFldsVal,$varWhereCond);
					}//if
					#receiver side
					$varWhereCond	= " Mail_Id_Received=".$objMessage->doEscapeString($varMessageId,$objMessage)." AND MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
					$varFldsVal		= array(2,"'".$varCurrentDate."'",1,"'".$varCurrentDate."'");
					$varFields		= array('Mail_Received_Status','Date_Updated','Receiver_Replied','Receiver_Replied_Date');
					$objMessage->update($varTable['MEMBERACTIONINFO'],$varFields,$varFldsVal,$varWhereCond);

					//UPDATE REPLY STATUS IN TO MEMERSTATISTICS TABLE
					if($varSenderDelStatus	== 0)
					{
						#sender side
						$varWhereCond	= " MatriId=".$objMessage->doEscapeString($varOppMatriId,$objMessage);
						$varFields		= array('Mail_Read_Sent','Mail_Replied_Sent');
						$varFldsVal		= array('(Mail_Read_Sent-1)','(Mail_Replied_Sent+1)');
						$objMessage->update($varTable['MEMBERSTATISTICS'],$varFields,$varFldsVal,$varWhereCond);
					}//if

					#receiver side
					$varWhereCond	= " MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
					$varFields		= array('Mail_Read_Received','Mail_Replied_Received');
					$varFldsVal		= array('(Mail_Read_Received-1)','(Mail_Replied_Received+1)');
					$objMessage->update($varTable['MEMBERSTATISTICS'],$varFields,$varFldsVal,$varWhereCond);

					/*$varFromEmailAddress	= $objMailManager->getEmail($sessMatriId);
					$varToEmailAddress		= $objMailManager->getEmail($varOppMatriId);
					$varSubject				= 'You have received a reply for your Personlised Message from '.$sessName.' ('.$sessMatriId.') ';
					$varSendMail			= $objMailManager->sendEmail($sessMatriId,$varFromEmailAddress,$varOppMatriId,$varToEmailAddress,$varSubject,$varCurrMsg,$varFromEmailAddress);*/
					$varDisplayMsg = 'Your reply has been successfully sent to '.$varOppMatriId.'. Wishing you luck in your partner search.';

					//NEW FLOW STARTS HERE ---->

					$varCurrMsg .= '<BR> ----- Original Message ----- <BR>From: '.$varOppMatriId.'<BR>To: '. $sessMatriId.'<BR><BR>'.$varOldMessage;

					// Insert Mail in mailsentinfo
					$varFields	= array('MatriId','Opposite_MatriId','Mail_Message','Date_Sent');
					$varFldsVal	= array($objMessage->doEscapeString($sessMatriId,$objMessage),$objMessage->doEscapeString($varOppMatriId,$objMessage),$objMessage->doEscapeString(addslashes($varCurrMsg),$objMessage),"'".$varCurrentDate."'");
					$varMailId	= $objMessage->insert($varTable['MAILSENTINFO'],$varFields,$varFldsVal);

					if($varMailId >0)
					{
					// Insert Mail in mailpendinginfo
					$varFields	= array('Mail_Id','MatriId','Opposite_MatriId','Mail_Message','Status','Date_Updated','Reply_Flag');
					$varFldsVal	= array($objMessage->doEscapeString($varMailId,$objMessage),$objMessage->doEscapeString($varOppMatriId,$objMessage),$objMessage->doEscapeString($sessMatriId,$objMessage),$objMessage->doEscapeString(addslashes($varCurrMsg),$objMessage),0,"'".$varCurrentDate."'","1");
					$objMessage->insert($varTable['MAILPENDINGINFO'],$varFields,$varFldsVal);

					// Insert Mail in memberactioninfo
					$varFields	= array('Mail_Sent','MatriId','Opposite_MatriId','Mail_Sent_Date','Date_Updated', 'Mail_Sent_Status','Mail_Id_Sent');
					$varFldsVal	= array(1,$objMessage->doEscapeString($sessMatriId,$objMessage),$objMessage->doEscapeString($varOppMatriId,$objMessage),"'".$varCurrentDate."'","'".$varCurrentDate."'",0, $objMessage->doEscapeString($varMailId,$objMessage));
					$objMessage->insertOnDuplicate($varTable['MEMBERACTIONINFO'],$varFields,$varFldsVal,'');

					//UPDATE MAIL PENDING COUNT IN memberstatistics
					#sender side
					$varWhereCond 	= " MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
					$varFields		= array('Mail_UnRead_Sent');
					$varFldsVal		= array('(Mail_UnRead_Sent+1)');
					$objMessage->update($varTable['MEMBERSTATISTICS'],$varFields,$varFldsVal,$varWhereCond);
					}
					//NEW FLOW ENDS HERE --->
				}else if($varPrevStatus==2){
					$varDisplayMsg = "You have already replied this member's message. Wishing you luck in your partner search.";
				}else if($varPrevStatus==3){
					$varDisplayMsg = "You have already declined this member's message. Wishing you luck in your partner search.";
				}
			}else if($varMsgSendIds !=''){
				$varMsgAlertCount		= $confValues['MESSAGEALERTCOUNT'];
				$varTimeIntervalAllowed	= $confValues['TIMEINTERVALALLOWED'];
				$varMsgLimit			= $confValues['MESSAGESENTCOUNT'];

				$varWhereCond		= " WHERE MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
				$varMsgTrkFields	= array('Total_Count','First_Time','(UNIX_TIMESTAMP(NOW())-First_Time)');
				$varMsgTrkInfo		= $objMessage->select($varTable['MAILSENTTRACKINFO'],$varMsgTrkFields,$varWhereCond,1);

				$varMsgTrkCnt		= count($varMsgTrkInfo);
				$varTimediff		= $varMsgTrkInfo[0]['(UNIX_TIMESTAMP(NOW())-First_Time)'];

				if($varMsgTrkCnt == 1 && $varTimediff < $varTimeIntervalAllowed && $varMsgTrkInfo[0]['Total_Count'] >= $varMsgLimit)
				{
					$varTimeDiffNew		= $varTimeIntervalAllowed-$varTimediff;
					$varTotalHrs		= $varTimeDiffNew/3600;
					$varTotalMins		= $varTimeDiffNew%3600;
					$varTotalMins		= $varTotalMins/60;
					$varTotalSecs		= $varTotalMins%60;
					$varTotalHrs		= sprintf("%2d",$varTotalHrs);
					$varTotalMins		= sprintf("%2d",$varTotalMins);
					$varTotalSecs		= sprintf("%2d",$varTotalSecs);
					$varTimeSlot		= "$varTotalHrs hour(s) $varTotalMins minute(s) $varTotalSecs second(s)";
					$varDisplayMsg		= "<font class=\"textsmallnormal\">You have Sent Messages to more profiles than permissible in the last ".($varTimeIntervalAllowed/3600)."	hours. Please continue sending Messages after ".$varTimeSlot.". Sorry for the inconvenience.<Br></font>";

					//Send alert mail to support team
					$varMessage = "Please check the Messages Sent Count of Matrimony Id ".$sessMatriId;
					$varSubject = "Alert Matrimony Id: ".$sessMatriId;
					$objMailManager->sendEmail($arrEmailsList['FROMMAIL'],$arrEmailsList['INFOEMAIL'],'Support Team',$arrEmailsList['ALERTEMAIL'],$varSubject,$varMessage,$arrEmailsList['INFOEMAIL']);
				}else{

					if(($varMsgTrkInfo[0]['Total_Count']%$varMsgAlertCount) == 0)
					{
						$varMessage = "Please check the send mail Count of Matrimony Id ".$sessMatriId;
						$varSubject = "Alert Matrimony Id: ".$sessMatriId;
						$objMailManager->sendEmail($arrEmailsList['FROMMAIL'],$arrEmailsList['INFOEMAIL'],'Support Team',$arrEmailsList['ALERTEMAIL'],$varSubject,$varMessage,$arrEmailsList['INFOEMAIL']);
					}

					$arrPostedIds = array();
					if(preg_match("/~/",$varMsgSendIds))
						$arrPostedIds = split('~', $varMsgSendIds);
					else
						$arrPostedIds[0] = $varMsgSendIds;

					$varMsgSentCnt	= 0;
					$varMsgSentIds  = '';
					$varRemainingCnt= 0;

					if($varMsgTrkCnt == 0)
						$varRemainingCnt = $varMsgLimit;
					else if($varTimediff > $varTimeIntervalAllowed)
						$varRemainingCnt = $varMsgLimit;
					else if($varMsgTrkInfo[0]['Total_Count'] < $varMsgLimit)
						$varRemainingCnt= $varMsgLimit-$varMsgTrkInfo[0]['Total_Count'];

					//Message Sent Starts Here
					if($varRemainingCnt > 0 && count($arrPostedIds)>0){
						$varBloked	= 0;
						$varNtExs	= 0;
						$varPend	= 0;
						$varInact	= 0;
						$varSus		= 0;
						$varRej		= 0;
						$varSamGen	= 0;
						foreach($arrPostedIds as $varSinPostedId){

						//Check Msg Coount limit
						if($varMsgSentCnt > $varRemainingCnt){break;}

						//Err Finding Variables
						$varError	= 0;

						//GET Opposite Id Info
						$varFields		= array('Publish', 'Gender');
						$varWhereCond	= " WHERE MatriId='".$varSinPostedId."'";
						$varOppMemInfo	= $objMessage->select($varTable['MEMBERINFO'],$varFields,$varWhereCond,1);
						$varOppMemCnt		= count($varOppMemInfo);


						if($varOppMemCnt>0 && $varOppMemInfo[0]['Publish']==1  && ($varOppMemInfo[0]['Gender']!=$sessGender)){
							$varBlockCond		= " WHERE MatriId='".$varSinPostedId."' AND Opposite_MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
							$varBlockedProfile	= $objMessage->numOfRecords($varTable['BLOCKINFO'],'MatriId',$varBlockCond);
							if($varBlockedProfile >= 1) {$varBloked=1; $varBlocId .= $varSinPostedId.", "; $varError=1;}
						}elseif($varOppMemCnt==0) { $varNtExs=1;$varNtExsId .= $varSinPostedId.", ";$varError=1;}
						elseif($varOppMemInfo[0]['Publish']==0){ $varPend=1;$varPendId .= $varSinPostedId.", ";$varError=1;}
						elseif($varOppMemInfo[0]['Publish']==0){ $varInact=1;$varInactId .= $varSinPostedId.", ";$varError=1;}
						elseif($varOppMemInfo[0]['Publish']==3){ $varSus=1;$varSusId .= $varSinPostedId.", ";$varError=1;}
						elseif($varOppMemInfo[0]['Publish']==4){ $varRej=1;$varRejId .= $varSinPostedId.", ";$varError=1;}
						elseif($varOppMemInfo[0]['Gender']==$sessGender){ $varSamGen=1;$varSamGenId .= $varSinPostedId.", "; $varError=1;}

						if($varError ==0){
							// Insert Mail in mailsentinfo
							$varFields	= array('MatriId','Opposite_MatriId','Mail_Message','Date_Sent');
							$varFldsVal	= array($objMessage->doEscapeString($sessMatriId,$objMessage),"'".$varSinPostedId."'",$objMessage->doEscapeString($varCurrMsg,$objMessage),"'".$varCurrentDate."'");
							$varMailId	= $objMessage->insert($varTable['MAILSENTINFO'],$varFields,$varFldsVal);

							if($varMailId >0)
							{
							// Insert Mail in mailpendinginfo
							$varFields	= array('Mail_Id','MatriId','Opposite_MatriId','Mail_Message','Date_Updated');
							$varFldsVal	= array($objMessage->doEscapeString($varMailId,$objMessage),"'".$varSinPostedId."'",$objMessage->doEscapeString($sessMatriId,$objMessage),$objMessage->doEscapeString($varCurrMsg,$objMessage),"'".$varCurrentDate."'");
							$objMessage->insert($varTable['MAILPENDINGINFO'],$varFields,$varFldsVal);

							// Insert Mail in memberactioninfo
							$varFields	= array('Mail_Sent','MatriId','Opposite_MatriId','Mail_Sent_Date','Date_Updated', 'Mail_Sent_Status','Mail_Id_Sent');
							$varFldsVal	= array(1,$objMessage->doEscapeString($sessMatriId,$objMessage),"'".$varSinPostedId."'","'".$varCurrentDate."'","'".$varCurrentDate."'",0, $varMailId);
							$objMessage->insertOnDuplicate($varTable['MEMBERACTIONINFO'],$varFields,$varFldsVal,'');


							//UPDATE MAIL PENDING COUNT IN memberstatistics
							#sender side
							$varWhereCond 	= " MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
							$varFields		= array('Mail_UnRead_Sent');
							$varFldsVal		= array('(Mail_UnRead_Sent+1)');
							$objMessage->update($varTable['MEMBERSTATISTICS'],$varFields,$varFldsVal,$varWhereCond);

							$varMsgSentIds .= $varSinPostedId.", ";
							$varMsgSentCnt++;
							}//if
						}//if
						}//foreach

						if($varMsgSentCnt > 0){
							if($varMsgTrkCnt == 0){
								$varFields		= array('MatriId', 'First_Time', 'Total_Count');
								$varFieldsVal	= array($objMessage->doEscapeString($sessMatriId,$objMessage), strtotime($varCurrentDate),$varMsgSentCnt);
								$objMessage->insert($varTable['MAILSENTTRACKINFO'],$varFields,$varFieldsVal);
							}else if($varTimediff > $varTimeIntervalAllowed){
								$varFields		= array('First_Time', 'Total_Count');
								$varFieldsVal	= array(strtotime($varCurrentDate), $varMsgSentCnt);
								$varWhereCond	= " MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
								$objMessage->update($varTable['MAILSENTTRACKINFO'],$varFields,$varFieldsVal,$varWhereCond);
							}else if($varMsgTrkInfo[0]['Total_Count'] < $varMsgLimit){
								$varSendMailCnt	= $varMsgTrkInfo[0]['Total_Count']+$varMsgSentCnt;
								$varFields		= array('Total_Count');
								$varFieldsVal	= array($varSendMailCnt);
								$varWhereCond	= " MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
								$objMessage->update($varTable['MAILSENTTRACKINFO'],$varFields,$varFieldsVal,$varWhereCond);
							}
						}//Msg Count update

						$varDisplayMsg = '';
						if($varBloked==1){ $varDisplayMsg .= 'Sorry, <b>'.rtrim($varBlocId,', ').'</b> has been blocked you. You cannot send personalised message to the member.<br>'; }
						if($varPend==1){ $varDisplayMsg.="Sorry, your personalised message to <b>".rtrim($varPendId,', ')."</b> could not be sent as the member's profile is currently under validation. Your personalised message will be sent to the member after the validation is complete which usually takes about 24 hours.<br>"; }
						if($varSus==1){ $varDisplayMsg.="Sorry, your personalised message to <b>".rtrim($varSusId,', ')."</b> could not be sent, as the member's profile has been suspended.<br>"; }
						if($varRej==1){ $varDisplayMsg.="Sorry, your personalised message to <b>".rtrim($varRejId,', ')."</b> could not be sent, as the member's profile has been rejected.<br>"; }
						if($varNtExs==1){ $varDisplayMsg .="Sorry, your personalised message to <b>".rtrim($varNtExsId,', ')."</b> could not be sent as the member's profile is not found in our database.<br>"; }
						if($varSamGen==1){ $varDisplayMsg.="Sorry, you can send personalised message to the opposite gender only".rtrim($varSamGenId,', ').".<br>"; }
						if($varInact==1){ $varDisplayMsg.="Sorry, your personalised message to <b>".rtrim($varInactId,', ')."</b> could not be sent, as the member's profile is inactive.<br>"; }
						if($varMsgSentCnt > 0){ $varDisplayMsg.="Message successfully sent to ".rtrim($varMsgSentIds, ', '); }

					}//CHK - RemainingCnt and OppIds
				}//CHK - 12 Hrs Msg Limit
			}//CHK - MsgIds !=''


			$varCont = '<div class="fright"><img src="'.$confValues['IMGSURL'].'/close.gif" onclick="'.$varJSCloseFun.'" href="javascript:;" class="pntr" /></div><br clear="all"/>'.$varDisplayMsg.'<div class="fright padt10"><input type="button" class="button" value="Close" onclick="'.$varJSCloseFun.'"/></div>';
			echo $varCont;
		}//CHK -ABUSE
	}//CHK - Submit
}else{echo 'Session expired, Kindly login again.';}

//UNSET OBJ
$objMessage->dbClose();
$objMailManager->dbClose();
unset($objMessage);
unset($objMailManager);
?>