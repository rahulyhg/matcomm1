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
include_once($varRootBasePath.'/lib/clsCommon.php');

//VARIABLE DECLERATION
$varSubmit		= $_POST['intSubmit'];
$varCurrInt		= $_POST['intval'];
$varIntSendIds	= $_POST['oppids'];
$varJSCloseFun	= $_POST['type']=='mul' ? "hidediv('listalldiv');" : 'hide_box_msg();';
$varCurrentDate = date('Y-m-d H:i:s');

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo['PAIDSTATUS'];
$sessPublish	= $varGetCookieInfo['PUBLISH'];
$sessGender		= $varGetCookieInfo['GENDER'];

$sessPhotoStatus = $varGetCookieInfo['PHOTOSTATUS'];
$sessPhoneStatus = $varGetCookieInfo['PHONEVERIFIED'];

/*$varAlertMsg	= '';
if($sessPhoneStatus == 0){
	$varAlertMsg = 'Verify your phone number';
}
if($sessPhotoStatus == 0){
	$varInnCont	  = $varAlertMsg=='' ? '' : ' and  ';
	$varAlertMsg .= $varInnCont.'Upload your photograph';
}*/

//OBJECT DECLARTION
$objMessage		= new Message;
$objMailManager	= new MailManager;
$objCommon		= new clsCommon;
$objMessage->dbConnect('M', $varDbInfo['DATABASE']);
$objMailManager->dbConnect('S', $varDbInfo['DATABASE']);
$varAlertMsg    = $objCommon->getPhoneNumberValidationStatus($sessPhoneStatus,$sessPaidStatus);
if($sessMatriId != ''){

	$varPubError	= 0;
	$varIntAccErr	= 0; 
	switch ($sessPublish){
		case 2:	$varPubError	= 1;
				$varDispMsg		= "Currently your profile is hidden. To send message, you must <a href=\"".$confValues['SERVERURL']."/profiledetail/index.php?act=profilestatus\" class='clr1'>click here to unhide</a> your profile.";break;

		case 3:	$varPubError	= 1;
				$varDispMsg		= "Sorry, you will not be able to send message as your profile is currently suspended. Please contact <a href='mailto:".$arrEmailsList['HELPEMAIL']."' class='clr1'>".$arrEmailsList['HELPEMAIL']."</a>";break;

		case 4:	$varPubError	= 1;
				$varDispMsg		= "Sorry, you will not be able to send message as your profile is currently rejected. Please contact <a href='mailto:".$arrEmailsList['HELPEMAIL']."' class='clr1'>".$arrEmailsList['HELPEMAIL']."</a>";break;
	}


	
	if($varPubError	== 1){
		$varCont = '<div class="fright"><img src="'.$confValues['IMGSURL'].'/close.gif" onclick="'.$varJSCloseFun.'" href="javascript:;" class="pntr" /></div><br clear="all"/>'.$varDispMsg.'<div class="fright padt10"><input type="button" class="button" value="Close" onclick="'.$varJSCloseFun.'"/></div>';
	}elseif($sessPaidStatus==0){
		$varWhereCond	= " WHERE MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
		$arrFields		= array('CumulativeAcceptSentInterest', 'CumulativeAcceptReceivedInterest');
		$varSelAccCnt	= $objMessage->select($varTable['MEMBERSTATISTICS'],$arrFields,$varWhereCond,1);
		$varIntAccCnt	= ($varSelAccCnt[0]['CumulativeAcceptSentInterest']);
		if($varIntAccCnt >= 5){
			$varIntAccErr	= 1;
			$varDispMsg		= "Sorry! You cannot express interest as you have reached the maximum number of accepted interests. To start contacting prospects directly, we recommend you to ".$varAlertMsg.". <a href='".$confValues['SERVERURL']."/profiledetail/index.php?act=primaryinfo' class='clr1'>. Click here to add details</a>";
			$varCont = '<div class="fright"><img src="'.$confValues['IMGSURL'].'/close.gif" onclick="'.$varJSCloseFun.'" href="javascript:;" class="pntr" /></div><br clear="all"/>'.$varDispMsg.'<div class="fright padt10"><input type="button" class="button" value="Close" onclick="'.$varJSCloseFun.'"/></div>';
		}
	}
	
	if($varSubmit == 'yes' && $varCurrInt != '' && $varPubError == 0 && $varIntAccErr== 0){
			if($varIntSendIds !=''){

				$varExpAlertCount		= $confValues['EXPALERTCOUNT'];
				$varTimeIntervalAllowed	= $confValues['TIMEINTERVALALLOWED'];
				$varExpIntLimit			= $confValues['EXPINTSENTCOUNT'];

				$varWhereCond		= " WHERE MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
				$varIntTrkFields	= array('Total_Count','First_Time','(UNIX_TIMESTAMP(NOW())-First_Time)');
				$varIntTrkInfo		= $objMessage->select($varTable['INTERESTSENTTRACKINFO'],$varIntTrkFields,$varWhereCond,1);
				$varIntTrkCnt		= count($varIntTrkInfo);
				$varTimediff		= $varIntTrkInfo[0]['(UNIX_TIMESTAMP(NOW())-First_Time)'];

				if($varIntTrkCnt == 1 && $varTimediff < $varTimeIntervalAllowed && $varIntTrkInfo[0]['Total_Count'] >= $varExpIntLimit)
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
					$varDisplayMsg		= "<font class=\"textsmallnormal\">You have express interest to more profiles than permissible in the last ".($varTimeIntervalAllowed/3600)."	hours. Please continue to express interest after ".$varTimeSlot.". Sorry for the inconvenience.<Br></font>";
					
					//Send alert mail to support team
					$varMessage = "Please check the Express Interest Sent Count of Matrimony Id ".$sessMatriId;
					$varSubject = "Alert Matrimony Id: ".$sessMatriId;
					$objMailManager->sendEmail($arrEmailsList['FROMMAIL'],$arrEmailsList['INFOEMAIL'],'Support Team',$arrEmailsList['ALERTEMAIL'],$varSubject,$varMessage,$arrEmailsList['INFOEMAIL']);
				}else{				

					/*if(($varIntTrkInfo[0]['Total_Count']%$varExpAlertCount) == 0)
					{
						$varMessage = "Please check the interest Count of Matrimony Id ".$sessMatriId;
						$varSubject = "Alert Matrimony Id: ".$sessMatriId;
						$objMailManager->sendEmail($arrEmailsList['FROMMAIL'],$arrEmailsList['INFOEMAIL'],'Support Team',$arrEmailsList['ALERTEMAIL'],$varSubject,$varMessage,$arrEmailsList['INFOEMAIL']);
					}*/

					$arrPostedIds = array();
					if(preg_match("/~/",$varIntSendIds)) 
						$arrPostedIds = split('~', $varIntSendIds);
					else
						$arrPostedIds[0] = $varIntSendIds;
					
					$varIntSentCnt	= 0;
					$varIntSentIds  = '';
					$varRemainingCnt= 0;

					if($varIntTrkCnt == 0)
						$varRemainingCnt = $varExpIntLimit;
					else if($varTimediff > $varTimeIntervalAllowed)
						$varRemainingCnt = $varExpIntLimit;
					else if($varIntTrkInfo[0]['Total_Count'] < $varExpIntLimit)
						$varRemainingCnt= $varExpIntLimit-$varIntTrkInfo[0]['Total_Count'];
					
					//Message Sent Starts Here
					if($varRemainingCnt > 0 && count($arrPostedIds)>0){
						$varBloked	= 0;
						$varNtExs	= 0;
						$varPend	= 0;
						$varInact	= 0;
						$varSus		= 0;
						$varRej		= 0;
						$varSamGen	= 0; 
						$varAlready	= 0;
						foreach($arrPostedIds as $varSinPostedId){
						$varChkAlready = 0;
						//Check Msg Coount limit
						if($varIntSentCnt > $varRemainingCnt){break;}

						//Err Finding Variables
						$varError	= 0;
						
						//GET Opposite Id Info
						$varFields		= array('Publish', 'Gender');
						$varWhereCond	= " WHERE MatriId='".$varSinPostedId."'";
						$varOppMemInfo	= $objMessage->select($varTable['MEMBERINFO'],$varFields,$varWhereCond,1);
						$varOppMemCnt	= count($varOppMemInfo);

						$varWhereCond	= " WHERE MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage)." AND Opposite_MatriId='".$varSinPostedId."'";
						$varAlreaySent	= $objMessage->numOfRecords($varTable['INTERESTSENTINFO'],'Interest_Id',$varWhereCond);
						if($varAlreaySent >= 1) {$varChkAlready=1; $varAlready=1; $varAlreadyId .= $varSinPostedId.", "; $varError=1;}
						
						if($varChkAlready==0 && $varOppMemCnt>0 && $varOppMemInfo[0]['Publish']==1  && ($varOppMemInfo[0]['Gender']!=$sessGender) ){
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
							// Insert in interestsentinfo
							$varFields	= array('MatriId','Opposite_MatriId','Interest_Option','Date_Sent');
							$varFldsVal	= array($objMessage->doEscapeString($sessMatriId,$objMessage),"'".$varSinPostedId."'",$objMessage->doEscapeString($varCurrInt,$objMessage),"'".$varCurrentDate."'");
							$varIntId	= $objMessage->insert($varTable['INTERESTSENTINFO'],$varFields,$varFldsVal); 
							
							if($varIntId >0)
							{
							
							// Insert in interestpendinginfo
							$varStatus  = $sessPublish==1 ? '0' : '2';
							$varFields	= array('Interest_Id','MatriId','Status','Opposite_MatriId','Interest_Option','Date_Updated');
							$varFldsVal	= array($varIntId,"'".$varSinPostedId."'",$varStatus,$objMessage->doEscapeString($sessMatriId,$objMessage),$objMessage->doEscapeString($varCurrInt,$objMessage),"'".$varCurrentDate."'");
							$objMessage->insert($varTable['INTERESTPENDINGINFO'],$varFields,$varFldsVal); 

							// Insert Mail in memberactioninfo
							$varFields	= array('Interest_Sent','MatriId','Opposite_MatriId','Interest_Sent_Date','Date_Updated', 'Interest_Sent_Status','Interest_Id_Sent');
							$varFldsVal	= array(1,$objMessage->doEscapeString($sessMatriId,$objMessage),"'".$varSinPostedId."'","'".$varCurrentDate."'","'".$varCurrentDate."'",0, $objMessage->doEscapeString($varIntId,$objMessage));
							$objMessage->insertOnDuplicate($varTable['MEMBERACTIONINFO'],$varFields,$varFldsVal,'');

							//UPDATE MAIL PENDING COUNT IN memberstatistics
							#sender side
							$varWhereCond 	= " MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
							$varFields		= array('Interest_Pending_Sent');	
							$varFldsVal		= array('(Interest_Pending_Sent+1)');
							$objMessage->update($varTable['MEMBERSTATISTICS'],$varFields,$varFldsVal,$varWhereCond);
							
							$varIntSentIds .= $varSinPostedId.", ";
							$varIntSentCnt++;
							}//if
						}//if
						}//foreach

						if($varIntSentCnt > 0){
							if($varIntTrkCnt == 0){
								$varFields		= array('MatriId', 'First_Time', 'Total_Count');
								$varFieldsVal	= array($objMessage->doEscapeString($sessMatriId,$objMessage), strtotime($varCurrentDate),$varIntSentCnt);
								$objMessage->insert($varTable['INTERESTSENTTRACKINFO'],$varFields,$varFieldsVal);
							}else if($varTimediff > $varTimeIntervalAllowed){
								$varFields		= array('First_Time', 'Total_Count');
								$varFieldsVal	= array(strtotime($varCurrentDate), $varIntSentCnt);
								$varWhereCond	= " MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
								$objMessage->update($varTable['INTERESTSENTTRACKINFO'],$varFields,$varFieldsVal,$varWhereCond);
							}else if($varIntTrkInfo[0]['Total_Count'] < $varExpIntLimit){
								$varSendIntCnt	= $varIntTrkInfo[0]['Total_Count']+$varIntSentCnt;
								$varFields		= array('Total_Count');
								$varFieldsVal	= array($varSendIntCnt);
								$varWhereCond	= " MatriId=".$objMessage->doEscapeString($sessMatriId,$objMessage);
								$objMessage->update($varTable['INTERESTSENTTRACKINFO'],$varFields,$varFieldsVal,$varWhereCond);
							}
						}//Msg Count update 

						$varDisplayMsg = '';
						if($varBloked==1){ $varDisplayMsg .= 'Sorry, <b>'.rtrim($varBlocId,', ').'</b> has been blocked you. You cannot express interest to the member.<br>'; }
						if($varPend==1){ $varDisplayMsg.="Sorry, your express interest to <b>".rtrim($varPendId,', ')."</b> could not be sent as the member's profile is currently under validation. Your personalised message will be sent to the member after the validation is complete which usually takes about 24 hours.<br>"; }
						if($varSus==1){ $varDisplayMsg.="Sorry, your express interest to <b>".rtrim($varSusId,', ')."</b> could not be sent, as the member's profile has been suspended.<br>"; }
						if($varRej==1){ $varDisplayMsg.="Sorry, your express interest to <b>".rtrim($varRejId,', ')."</b> could not be sent, as the member's profile has been rejected.<br>"; }
						if($varNtExs==1){ $varDisplayMsg .="Sorry, your express interest to <b>".rtrim($varNtExsId,', ')."</b> could not be sent as the member's profile is not found in our database.<br>"; }
						if($varSamGen==1){ $varDisplayMsg.="Sorry, you can express interest to the opposite gender only".rtrim($varSamGenId,', ').".<br>"; }
						if($varInact==1){ $varDisplayMsg.="Sorry, your express interest to <b>".rtrim($varInactId,', ')."</b> could not be sent, as the member's profile is inactive.<br>"; }
						if($varAlready==1){ $varDisplayMsg.="Sorry, you have already sent interest to <b>".rtrim($varAlreadyId,', ')."</b>.<br>"; }
						
						if($varIntSentCnt > 0) {
							//SUCCESS DISPLAY MSG
							if($sessPublish == 0)
							$varDisplayMsg .= 'Your interest will be sent to '.rtrim($varIntSentIds, ', ').' once your profile is validated.<br clear="all">';
							else if($sessPublish == 1)
							$varDisplayMsg .="Your interest has been sent successfully to ".rtrim($varIntSentIds, ', ').'<br clear="all">';

							if ($sessPaidStatus != 1) { 
								$varDisplayMsg.='<br clear="all">Would you like to contact members directly? <br clear="all">' .$varAlertMsg.' to your profile to send e-mails and to call members. <a href="'.$confValues['SERVERURL'].'/profiledetail/index.php?act=primaryinfo" class="clr1" target="_blank">Click here to add details</a>'; 
							}
						}
					}//CHK - RemainingCnt and OppIds
				}//CHK - 12 Hrs Msg Limit
				$varCont = '<div class="fright"><img src="'.$confValues['IMGSURL'].'/close.gif" onclick="'.$varJSCloseFun.'" href="javascript:;" class="pntr" /></div><br clear="all"/>'.$varDisplayMsg.'<div class="fright padt10"><input type="button" class="button" value="Close" onclick="'.$varJSCloseFun.'"/></div>';
				echo $varCont;
			}//CHK - MsgIds !=''
	}else{
		echo $varCont;
	}
}else{
	$varDisplayMsg = 'Session is expired. Kindly login again.';
	$varCont = '<div class="fright"><img src="'.$confValues['IMGSURL'].'/close.gif" onclick="'.$varJSCloseFun.'" href="javascript:;" class="pntr" /></div><br clear="all"/>Session is expired. Kindly login again.<div class="fright padt10"><input type="button" class="button" value="Close" onclick="'.$varJSCloseFun.'"/></div>';
	echo $varCont;
}

//UNSET OBJ
$objMessage->dbClose();
$objMailManager->dbClose();
unset($objMessage);
unset($objMailManager);
?>
