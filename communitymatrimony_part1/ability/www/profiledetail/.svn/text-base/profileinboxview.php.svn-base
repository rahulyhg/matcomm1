<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : profileinboxview.php
#=====================================================================================================================================
# Description : display information of inbox detail.
#=====================================================================================================================================
//OBJECT DECLARATION
$objProfileDetail		= new ProfileDetail;

//CONNECT DATABASE
$objProfileDetail->dbConnect('M',$varDbInfo['DATABASE']);


//VARIABLE DECLARATION
$varMessageFlag	= $_REQUEST['msgfl'];
$varMessageId	= $_REQUEST['msgid'];
$varMessageType	= $_REQUEST['msgty'];
$varButtonName	= "Send Message";
//$varMessageFlag	= '';
//$varMessageId	= '46691';

$sessPhotoStatus = $varGetCookieInfo['PHOTOSTATUS'];
$sessPhoneStatus = $varGetCookieInfo['PHONEVERIFIED'];


/*$varAlertMsg	= '';
if($sessPhoneStatus == 0){
	$varAlertMsg = 'verified your phone number';
}
if($sessPhotoStatus == 0){
	$varInnCont	  = $varAlertMsg=='' ? '' : ' and  ';
	$varAlertMsg .= $varInnCont.'added a photograph';
}*/

$varCurrentDate		= date('Y-m-d H:i:s');

$varAlertMsg = $objCommon->getPhoneNumberValidationStatus($varGetCookieInfo['PHONEVERIFIED'],$varGetCookieInfo["PAIDSTATUS"]);
if($varMessageFlag != '') {
		if($varMessageType == 'R') {
			switch($varMessageFlag) { //Interest & Mail Received Part
				//mail received
				case 1: 
						$varInbFields	= array('Mail_Message','Replied_Message','Status','Delete_Status');
						$varInbCondition= "WHERE Mail_Id=".$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail)." AND MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND Opposite_MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
						$varTableName	= $varTable['MAILRECEIVEDINFO'];
						break;
				//interest received
				case 2: 
						$varInbFields	= array('Interest_Option','Declined_Option','Status','Delete_Status');
						$varInbCondition= "WHERE Interest_Id=".$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail)." AND MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND Opposite_MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
						$varTableName	= $varTable['INTERESTRECEIVEDINFO'];
						break;
				//request received
				case 3: 
						$varInbFields	= array('RequestFor','SenderId','RequestDate');
						$varInbCondition= "WHERE RequestId=".$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail)." AND ReceiverId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND SenderId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
						$varTableName	= $varTable['REQUESTINFORECEIVED'];
						break;
			}

			//FETCHING RECORD FROM CORRESPONDING TABLE
			$varInboxInfoResultSet	= $objProfileDetail->select($varTableName,$varInbFields,$varInbCondition,0);
			$varInboxInfo			= mysql_fetch_assoc($varInboxInfoResultSet);
			
			//Getting message
			$varFrame		= 0;
			$varinnerCont	= '';
			$varSpamOpt		= 0;
			$varMarkasSpam	= '';

			if($varMessageFlag==1) {
				$varInbStatus		= $varInboxInfo['Status'];
				$varInbMessage		= $varInboxInfo['Mail_Message'];
				$varSenderDelStatus = $varInboxInfo['Delete_Status'];
				$varOppMatriId		= $varMatriId; 

				if($varInbStatus == 0 || $varInbStatus == 1){
					$varSpamCond	= 'WHERE MessageId='.$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail);
					$varSpamOpt		= $objProfileDetail->numOfRecords($varTable['SPAMMSG'], 'MessageId', $varSpamCond);
				}

				if($varInbStatus == 0) {//not read

					$objMessage = $objProfileDetail;
					include_once $varRootBasePath."/www/mymessages/msgstatus.php";
					$varMsgStatusContent= 'This member has sent you a message.<br clear="all">If you do not reply, you may keep the member in anticipation.';
					$varButton	= '<input type="button" class="button" value="Reply" onclick="showRlyDiv()"/> &nbsp;
					<input type="button" class="button" value="Decline" onclick="showDecDiv('.$varMessageId.',\'\');show_box(event,\'div_box'.$varCurrPgNo.'\');"/>';
					$varInbMessage	= '<b>Member\'s Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;" >'.stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';
					$varFrame = 1; 
					$varMarkasSpam = $varSpamOpt==0 ? '<a href="javascript:;" class="clr1" onclick="markasSpam(\''.$varMessageId.'\', \'\');show_box(event,\'div_box'.$varCurrPgNo.'\');">Mark as spam</a>' : '';

				} elseif($varInbStatus==1) { //read, not replied
					
					$varMsgStatusContent= 'This member has sent you a message.<br clear="all">If you do not reply, you may keep the member in anticipation.';
					$varButton	= '<input type="button" class="button" value="Reply" onclick="showRlyDiv()"/> &nbsp;
					<input type="button" class="button" value="Decline" onclick="showDecDiv('.$varMessageId.',\'\');show_box(event,\'div_box'.$varCurrPgNo.'\');"/>';
					$varInbMessage		= '<b>Member\'s Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;">'. stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';
					$varFrame = 1; 
					$varMarkasSpam = $varSpamOpt==0 ? '<a href="javascript:;" class="clr1" onclick="markasSpam(\''.$varMessageId.'\', \'\');show_box(event,\'div_box'.$varCurrPgNo.'\');">Mark as spam</a>' : '';

				} elseif($varInbStatus==2){ //replied
					
					$varMsgStatusContent= 'You have replied to this member\'s message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
					$varInbMessage		= '<b>Member\'s Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;">'.stripslashes(str_replace('\n', '<br>',$varInboxInfo['Replied_Message']))."<BR> ----- Original Message ----- <BR>From: ".$varMatriId."<BR>To: ". $sessMatriId."<BR><BR>".stripslashes(str_replace('\n', '<br>',$varInboxInfo['Mail_Message'])).'</div>';

				} elseif($varInbStatus==3) { //declined
					
					$varMsgStatusContent= 'You have declined this member\'s message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
					$varInbMessage		= '<b>Member\'s Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;">'. stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';

				} elseif($varInbStatus==13) { //declined
					$varMsgStatusContent= 'This member has declined to your message.<br clear="all">Move ahead in your partner search and start contacting other profiles.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
					$varInbMessage		= '<b>Your Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;">'. stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';
				}
			}else if($varMessageFlag==2) {
				$varInbStatus	= $varInboxInfo['Status'];
				$varInbMessage	= $arrExpressInterestList[$varInboxInfo['Interest_Option']];			
				if($varInbStatus == 0) {//new interest

					$varMsgStatusContent= 'This member has sent you a message.<br clear="all">If you do not reply, you may keep the member in anticipation.';
					$varButton	= '<input type="button" class="button" value="Accept" onclick="intAccCall('.$varMessageId.','.$varCurrPgNo.'); show_box(event,\'div_box'.$varCurrPgNo.'\');"> &nbsp;
					<input type="button" class="button" value="Decline" onclick="intDecCall('.$varMessageId.','.$varCurrPgNo.',\'0\'); show_box(event,\'div_box'.$varCurrPgNo.'\');">';
					$varInbMessage	= '<b>Member\'s Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));

				} elseif($varInbStatus==1) { //interest accepted
					
					$varMsgStatusContent= 'You have accepted this member\'s message.';
					if($sessPaidStatus == 1){
						$varDispalyMsgPart	= 1;
					} else  {
						$varMsgStatusContent.= '<br clear="all">Would you like to contact members directly? <br clear="all">' .$varAlertMsg.' to your profile to send e-mails and to call members. <a href="'.$confValues['SERVERURL'].'/profiledetail/index.php?act=primaryinfo" class="clr1" target="_blank">Click here to add details</a>';
						$varButton	= '';
					}					
					$varInbMessage	= '<b>Member\'s Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));

				} elseif($varInbStatus==3) { //interest declined
					
					$varMsgStatusContent= 'You have declined this member\'s message.<br clear="all">Move ahead in your partner search and start contacting other profiles.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
					//$varButton	= '<input type="button" class="button" value="Accept" onclick="intAccCall('.$varMessageId.','.$varCurrPgNo.'); show_box(event,\'div_box'.$varCurrPgNo.'\');">';
					$varInbMessage	= '<b>Member\'s Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));

				} elseif($varInbStatus==21) { //declined
					
					$varMsgStatusContent= 'This member has accepted to your message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
					$varInbMessage	= '<b>Your Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));

				} elseif($varInbStatus==23) { //declined
					
					$varMsgStatusContent= 'This member has declined to your message.<br clear="all">Move ahead in your partner search and start contacting other profiles.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
					$varInbMessage	= '<b>Your Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));

				}
			}else if($varMessageFlag==3) {

				$varFields	= array('Photo_Set_Status', 'Phone_Verified', 'Horoscope_Available');
				$varCond	= "WHERE MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail);
				$varStatusInfo	= $objProfileDetail->select($varTable['MEMBERINFO'],$varFields,$varCond,1);				

				$varInbMessage ='';
				$varReqFor	= $varInboxInfo['RequestFor'];
				$varReqMsg	= strtolower($arrRequestList[$varReqFor]);
				$varMsgStatusContent= 'You have received a '.$varReqMsg.' request.';

				if($varReqFor == 1 && $varStatusInfo[0]['Photo_Set_Status']==0){
					$varinnerCont = '<div class="fright"><input type="button" class="button" value="Add Photo" onclick="javascript:window.location.href=\''.$confValues['IMAGEURL'].'/photo/\';"></div>';
				}elseif($varReqFor == 3 && $varStatusInfo[0]['Phone_Verified']==0){
					$varinnerCont = '<div class="fright"><input type="button" class="button" value="Add Phone" onclick="javascript:window.location.href=\''.$confValues['SERVERURL'].'/profiledetail/index.php?act=primaryinfo\';"></div>';
				}else if($varReqFor == 5 && $varStatusInfo[0]['Horoscope_Available']==0){
					$varinnerCont = '<div class="fright"><input type="button" class="button" value="Add Horoscope" onclick="window.location.href=\''.$confValues['IMAGEURL'].'/horoscope/\';"></div>';
				}

			}


		} else if($varMessageType == 'S') {
			
			//Request related add Button
			$varinnerCont	= '';

			switch($varMessageFlag) { //Interest & Mail Sent Part
				//mail sent
				case 1: 
						$varInbFields	= array('Mail_Message','Replied_Message','Status');
						$varInbCondition= "WHERE Mail_Id=".$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail)." AND MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND Opposite_MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
						$varTableName	= $varTable['MAILSENTINFO'];
						break;
				//interest sent
				case 2: 
						$varInbFields	= array('Interest_Option','Declined_Option','Status','Delete_Status');
						$varInbCondition= "WHERE Interest_Id=".$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail)." AND MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND Opposite_MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
						$varTableName	= $varTable['INTERESTSENTINFO'];
						break;
				//request sent
				case 3: 
						$varInbFields	=  array('RequestFor','ReceiverId','RequestDate');
						$varInbCondition	= "WHERE RequestId=".$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail)." AND SenderId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND ReceiverId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
						$varTableName	= $varTable['REQUESTINFOSENT'];
						break;
			}

			//FETCHING RECORD FROM CORRESPONDING TABLE
			$varInboxInfoResultSet	= $objProfileDetail->select($varTableName,$varInbFields,$varInbCondition,0);
			$varInboxInfo			= mysql_fetch_assoc($varInboxInfoResultSet);

			$varInbStatus	= $varInboxInfo['Status'];

			if($varMessageFlag==1){
				$varInbMessage	= $varInboxInfo['Mail_Message'];
				if($varInbStatus == 0){//not read
					
					$varMsgStatusContent= 'You have sent this member a message.<br clear="all">Member hasn\'t replied, you can send a reminder.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1')";
						$varButtonName		= "Send Reminder";
					} else {
						$varButton			= '<input type="button" class="button" value="Send Reminder" onclick="sendreminder('.$varMessageFlag.', '.$varMessageId.','.$varCurrPgNo.'); show_box(event,\'div_box'.$varCurrPgNo.'\');">';
					}
					$varInbMessage		= '<b>Your Earlier Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;" >'.stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';

				}else if($varInbStatus == 1){
					
					$varMsgStatusContent= 'You have sent this member a message.<br clear="all">If the member hasn\'t replied, you can send a reminder.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1')";
						$varButtonName		= "Send Reminder";
					} else {
						$varButton			= '<input type="button" class="button" value="Send Reminder" onclick="sendreminder('.$varMessageFlag.', '.$varMessageId.','.$varCurrPgNo.'); show_box(event,\'div_box'.$varCurrPgNo.'\');">';
					}
					$varInbMessage		= '<b>Your Earlier Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;" >'.stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';

				}else if($varInbStatus == 2){
					
					$varMsgStatusContent= 'This member has replied to your message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1')";
						$varButtonName		= "Send Message";
					} else {
						$varButton			= '';
					}
					$varInbMessage		= '<b>Your Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;">'. stripslashes(str_replace('\n', '<br>',$varInboxInfo['Replied_Message']))."<BR> ----- Original Message ----- <BR>From: ".$sessMatriId."<BR>To: ". $varMatriId."<BR><BR>".stripslashes(str_replace('\n', '<br>',$varInboxInfo['Mail_Message'])).'</div>';

				}else if($varInbStatus == 3){

					$varMsgStatusContent= 'This member has declined to your message.<br clear="all">Move ahead in your partner search and start contacting other profiles';
					$varInbMessage		= '<b>Your Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;" >'.stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1')";
						$varButtonName		= "Send Message";
					} else {
						$varButton			= '';
					}

				}else if($varInbStatus == 13){

					$varMsgStatusContent= 'You have declined this member\'s message';
					$varInbMessage		= '<b>Member\'s Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;" >'.stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1')";
						$varButtonName		= "Send Message";
					} else {
						$varButton			= '';
					}

				}
			}else if($varMessageFlag==2){
				$varInbStatus	= $varInboxInfo['Status'];
				$varInbMessage	= $arrExpressInterestList[$varInboxInfo['Interest_Option']];
				if($varInbStatus == 0){//new interest
					$varMsgStatusContent= 'You have sent this member a message.<br clear="all">Member hasn\'t replied, you can send a reminder.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1')";
						$varButtonName		= "Send Reminder";
					} else {
						$varButton		= '<input type="button" class="button" value="Send Reminder" onclick="sendreminder('.$varMessageFlag.', '.$varMessageId.','.$varCurrPgNo.'); show_box(event,\'div_box'.$varCurrPgNo.'\');">';
					}
					$varInbMessage	= '<b>Your Earlier Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));
				}elseif($varInbStatus==1){ //interest accepted
					$varMsgStatusContent= 'This member has accepted to your message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton	= '';
					}
					$varInbMessage	= '<b>Your Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));
				}elseif($varInbStatus==3){ //interest declined
					$varMsgStatusContent= 'This member has declined to your message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton	= '';
					}
					$varInbMessage	= '<b>Your Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));
				}elseif($varInbStatus==21){ //declined
					$varMsgStatusContent= 'You have accepted this member\'s message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton	= '';
					}
					$varInbMessage	= '<b>Member\'s Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));
				}elseif($varInbStatus==23){ //declined
					$varMsgStatusContent= 'You have declined this member\'s message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton	= '';
					}
					$varInbMessage	= '<b>Member\'s Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));
				}
			}else if($varMessageFlag==3){

				$varInbMessage ='';
				$varReqFor	= $varInboxInfo['RequestFor'];
				$varReqMsg	= strtolower($arrRequestList[$varReqFor]);
				$varMsgStatusContent= 'You have sent a '.$varReqMsg.' request.';
			}
		}
}
?>
<div class="padt10 tlleft" id="actiondiv" style="background-color:#D2EDF4;">
	<?if($varMessageFlag != '' && $varMessageType!=''){ ?>
	<!-- Inbox Message Starts-->
	<div id="msg2div<?=$varCurrPgNo?>" class="tlleft">
		<div id="msgdispdiv<?=$varCurrPgNo;?>" class="tlleft">
			<div class="padb10"><div class="statusarea fleft tlleft"><?=$varMsgStatusContent;?></div><?=$varinnerCont;?></div><br clear="all">
			<div class="dotsep1"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="2"></div><br clear="all">
			<div class="normtxt clr lh16"><?=$varInbMessage;?></div>
			<div id="spam<?=$varCurrPgNo?>" class="fleft padt10"><?=$varMarkasSpam;?></div>
			<div class="fright padt10"><?=$varButton;?></div>
		</div>
		<?if($varFrame == 1){?>
		<div id="replyDiv<?=$varCurrPgNo?>" class="disnon"><div><iframe width="500" height="205" contentEditable="true" frameborder="0" src="<?=$confValues['SERVERURL'];?>/mymessages/sendmail.php?currrec=<?=$varCurrPgNo?>&msgid=<?=$varMessageId?>" style="margin:0px;padding:0px" id="parentrte<?=$varCurrPgNo?>" name="parentrte<?=$varCurrPgNo?>"></iframe></div><div class="fright padt10" id="buttonSub" style="background-color:#D2EDF4;"><input type="button" class="button" value="Send Message" onclick="javascript:RTESubmit('reply');show_box(event,'div_box<?=$varCurrPgNo?>');"/></div></div>
		<?}else{?>
		<div id="replyDiv<?=$varCurrPgNo?>" class="disnon"></div>
		<?}?>
	</div><br clear="all">
	<!-- Inbox Message Ends-->
	<?}
	if($varDispalyMsgPart==1 || ($varMessageFlag=='' && $varMessageType=='')){ //For Search Part?>
	<!-- Search Options Starts-->
	<div class="fleft normtxt clr bld padb5">Interested in <a class="normtxt bld clr" onMouseOver="this.className='normtxt bld clr1'" onMouseOut="this.className='normtxt bld clr'" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=fullprofilenew&id=<?=$varMatriId?>" target="_blank"> 
	<? echo ($checkcrawlingbotsexists == false)? $varDisplayName.' ('.$varMatriId.')' : $varMatriId;?>?</a></div>
	<div class="fright padb5" style="background-color:#D2EDF4;"><div id="firstct<?=$varCurrPgNo?>" class="disblk"><input type="button" class="button" value="<?=$varButtonName?>" onclick="showOption('<?=$varCurrPgNo?>');<?=$varSenderSideFn;?>"/></div></div><br clear="all">
		<div id="msg1div<?=$varCurrPgNo?>" class="disnon">
			<div id="replyDiv<?=$varCurrPgNo?>"></div>
			<!--Interest Action Area Part-->
			<div class="smalltxt tlleft padtb10 fleft brdr" style="width:240px;height:170px !important;height:190px;">
				<div class="smalltxt clr bld padb5" style="padding-left:10px;"><input type="radio" name="msgtype<?=$varCurrPgNo?>" id="msgtype1" <?php if($sessPaidStatus == 0){echo 'checked';}?> onclick="swapdiv('<?=$varCurrPgNo?>','2');"> Send templated message</div>
				<center>
				<div class="dotsep2" style="width:210px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1"></div></center>
				<div id="radio2div<?=$varCurrPgNo?>" class="disblk">
					<div class="fleft">
						<div class="radiodiv2 lh16" style="padding-top:8px;">
							<? foreach($arrExpressInterestList as $key=>$value){
								$varChecked = ($key == 1) ? 'Checked' : '';
								echo '<div class="fleft tlright" style="width:30px;padding-top:8px !important;padding-top:5px;"><input type="radio" class="frmelements" name="intopt'.$varCurrPgNo.'" value="'.$key.'"  id="intopt'.$key.'" '.$varChecked.'></div><div class="fleft" style="width:205px;padding-top:7px;padding-left:5px;">'.$value.'</div><br clear="all">';
							}?>
						</div>
					</div>
				</div>
			</div><div class="fleft" style="width:5px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="1" /></div>
			<!--Interest Action Area Part Ends-->
			<!--Richtext Area Part-->
			<div class="smalltxt tlleft fleft brdr padtb10" style="width:250px !important;width:254px;height:170px !important;height:190px;">
			<div class="smalltxt clr bld padb5" style="padding-left:10px;"><input type="radio" name="msgtype<?=$varCurrPgNo?>" id="msgtype2" <?php if($sessPaidStatus == 1){echo 'checked';}?>  <?php if($sessPaidStatus == 0){echo 'disabled';}?> onclick="swapdiv('<?=$varCurrPgNo?>','1');"> Send personalized message</div>
			
			<div id="radio1div<?=$varCurrPgNo?>" class="disblk tlleft" style="padding-left:5px;">
			<?
				if($sessPaidStatus == 1 && $sessPublish==1){
					$varButtonVal = '<input type="button" class="button" value="Send Message" onclick="javascript:RTESubmit(\'\');show_box(event,\'div_box'.$varCurrPgNo.'\');"/>'; 
			?>
				<iframe width="235" height="140" frameborder="0" src="<?=$confValues['SERVERURL'];?>/mymessages/sendmail.php?currrec=<?=$varCurrPgNo?>" style="margin:0px;padding:0px" id="parentrte<?=$varCurrPgNo?>" name="parentrte<?=$varCurrPgNo?>" contentEditable="true"></iframe>
			<?	}else if($sessPaidStatus == 1 && $sessPublish==2){
					$varButtonVal = '<input type="button" class="button" value="Send Message"/>'; 
			?>
				<div class="padl25">
						<div><br>Currently your profile is hidden. To send message, you must <a href="<?=$confValues['SERVERURL'];?>/profiledetail/index.php?act=profilestatus" class='clr1'>click here to unhide</a> your profile.<br></div>
				</div>
			<?  }else{
				$varButtonVal = '<input type="button" class="button" value="Send Message" onClick="javascript:sendInterest('.$varCurrPgNo.');show_box(event,\'div_box'.$varCurrPgNo.'\');"/>'; 
			?>
				<div>
					<div class="radiodiv1a normtxt"><br><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="2"><br>Sorry! You cannot send personalised messages unless you have <?=$varAlertMsg;?> to your profile. <a class="clr1 bld" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo"><br>Click here to add details </a></div>						
				</div>
			<?}?>
			</div>
			<!--Richtext Area Part Ends-->
		</div>
		<div style="background-color:#D2EDF4;height:38px;"><div style="background-color:#D2EDF4;" class="fright padt10 padb5" id="buttonSub<?=$varCurrPgNo?>"><?=$varButtonVal;?></div></div>
	</div>
	<!-- Search Options Ends-->
	<? }?>
	<br clear="all">
</div>	