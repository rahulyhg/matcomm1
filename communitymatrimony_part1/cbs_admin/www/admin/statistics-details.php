<?php
//BASE PATH
$varRootBasePath = '/home/product/community';

//FILE INCLUDES
include_once $varRootBasePath."/conf/config.cil14";
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/conf/productvars.cil14');
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath.'/lib/clsMailManager.php');
include_once($varRootBasePath."/www/admin/includes/config.php");
include_once($varRootBasePath."/www/admin/includes/clsCommon.php");

//OBJECT DECLARATION
$objSlave	= new MailManager;

$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

$varMatriId				    = $_REQUEST['MatriId'];
$varMessageReceiverStatus	= $_REQUEST['MsgReceiverStatus'];
$varInterestReceiverStatus	= $_REQUEST['InterestReceiverStatus'];
$varMessageStatus			= $_REQUEST['MsgStatus'];
$varInterestStatus			= $_REQUEST['InterestStatus'];
$varLists					= $_REQUEST['List'];
$varact                     = $_REQUEST['act'];

$varArrSendSalamList = array(1=>"I like your profile and I want to get in touch with you. Please accept if interested too.",2=>"We have a lot in common and could make a good pair. Awaiting your reply.",3=>"Our children's profiles match. Can we contact you? Please reply.");

$varMessageReceivedInfo=array(0=>"New Messages",1=>"Awaiting Messages",2=>"Replied Messages",3=>"Declined Messages",4=>"New Messages",5=>"Awaiting Messages",6=>"Replied Messages",7=>"Declined Messages",9=>"New Messages",10=>"Awaiting Messages",11=>"Replied Messages",12=>"Declined Messages",13=>"New Messages",14=>"Awaiting Messages",15=>"Replied Messages",16=>"Declined Messages");

$varMessageSentInfo=array(0=>"UnRead Sent Messages",1=>"Read Sent Messages",2=>"Replied Messages",
3=>"Declined Messages",5=>"Deleted Messages",9=>"UnRead Sent Messages Before Profile Deletion",10=>"Read Sent Messages  Before Profile Deletion",11=>"Replied Messages Before Profile Deletion",12=>"Declined Messages Before Profile Deletion",14=>"Deleted messages with profile Deletion");

$varInterestReceivedInfo=array(0=>"New Interest",1=>"Accepted Interest",3=>"Declined Interest",4=>"New Interest",6=>"Accepted Interest",7=>"Declined Interest",9=>"New Interest",10=>"Accepted Interest",12=>"Declined Interest",13=>"New Interest",15=>"Accepted Interest",16=>"Declined Interest");

$varInterestSentInfo=array(0=>"Interest Sent-Pending",1=>"Interest Sent-Accepted",3=>"Interest Sent Declined",
5=>"Deleted Interest",9=>"Pending Sent Interest Before Profile Deletion",10=>"Accepted Sent Interest Before Profile Deletion",12=>"Deleted Sent Interest Before Profile Deletion",14=>"Deleted Interest with profile Deletion");


	// GET MAIL RECEIVED STATISTICS
	if($varMessageReceiverStatus==1) { 

		$varTableName	= $varTable['MAILRECEIVEDINFO']; 
		$varFields		= array('MatriId','Opposite_MatriId', 'Date_Received','Mail_Message','Status');	

		if($varMessageStatus==0) { 
			$varCondition		= "WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (0,4,9,13) ORDER BY Date_Received DESC";
			$varDisplayMessage	= "No New Messages For The Selected Member";
			$varHeading			= "Unread Messages";
		}

		if($varMessageStatus==1) {
			$varCondition		= "WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (1,5,10,14) ORDER BY Date_Received DESC";
			$varDisplayMessage	= "No UnReplied Messages For The Selected Member";
			$varHeading			= "Read Messages";
		}

		if($varMessageStatus==2) {
			$varCondition		= "WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (2,6,11,15) ORDER BY Date_Received DESC";
			$varDisplayMessage	= "No Replied Messages For The Selected Member";
			$varHeading			= "Replied By Me";
		}

		if($varMessageStatus==3) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (3,7,12,16) ORDER BY Date_Received DESC";
			$varDisplayMessage	="No Decline Messages For The Selected Member";
			$varHeading			= "Declined By Me";
		}
		if($varMessageStatus==4) {
			 $varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." ORDER BY Date_Received DESC";
			$varDisplayMessage	="No  Messages For The Selected Member";
			$varHeading			= "Total Message Received";
		}	
	}

	if($varMessageReceiverStatus==2)
	{
		$varTableName	= $varTable['MAILSENTINFO'];
		$varFields		= array('MatriId','Opposite_MatriId', 'Date_Sent','Mail_Message','Status');	

		if($varMessageStatus==1) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (1,5,10,14) ORDER BY Date_Sent DESC";
			$varDisplayMessage = "No Read Messages For The Selected Member";
			$varHeading			= "Read Messages";
		}

		if($varMessageStatus==0) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (0,5,9,14) ORDER BY Date_Sent DESC";
			$varDisplayMessage = "No UnRead Messages For The Selected Member";
			$varHeading			= "Unread Messages";
		}
		if($varMessageStatus==2) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (2,5,11,14) ORDER BY Date_Sent DESC";
			$varDisplayMessage	= "No Replied Messages For The Selected Member";
			$varHeading			= "Replied By Members";
		}

		if($varMessageStatus==3) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (3,5,12,14) ORDER BY Date_Sent DESC";
			$varDisplayMessage	= "No Declined Messages For The Selected Member";
			$varHeading			= "Declined By Members";
		}

		if($varMessageStatus==5) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." ORDER BY Date_Sent DESC";
			$varDisplayMessage	= "No Messages For The Selected Member";
			$varHeading			= "Total Sent Messages";
		}
	}

	if($varInterestReceiverStatus==1)
	{
		$varTableName	= $varTable['INTERESTRECEIVEDINFO']; 
		$varFields		= array('MatriId','Opposite_MatriId', 'Date_Received','Interest_Option',
			'Declined_Option','Status');	

		if($varInterestStatus==0) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (0,4,9,13) ORDER BY Date_Received DESC ";
			$varDisplayMessage	= "No Pending Interest For The Selected Member";
			$varHeading			= "Reply Pending";
		}
		if($varInterestStatus==1) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (1,6,10,15) ORDER BY Date_Received DESC";
			$varDisplayMessage	= "No Accepted Interest For The Selected Member";
			$varHeading			= "Accepted By Me";
		}
		if($varInterestStatus==2) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (3,7,12,16) ORDER BY Date_Received DESC";
			$varDisplayMessage	= "No Declined Interest For The Selected Member";
			$varHeading			= "Declined By Me";
		}
		if($varInterestStatus==6) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." ORDER BY Date_Received DESC";
			$varDisplayMessage	= "No Interest For The Selected Member";
			$varHeading			= "Total Interest Received";
		}
	}

	if($varInterestReceiverStatus==2)
	{

		$varTableName	= $varTable['INTERESTSENTINFO']; 
		$varFields		= array('MatriId','Opposite_MatriId', 'Date_Sent','Interest_Option',
			'Declined_Option','Status');	

		if($varInterestStatus==0) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (0,5,9,14) ORDER BY Date_Sent DESC";
			$varDisplayMessage	= "No Pending Interest For The Selected Member";
			$varHeading			= " Pending Interests";
		}
		if($varInterestStatus==1) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (1,5,10,14) ORDER BY Date_Sent DESC";
			$varDisplayMessage	= "No Accepted Interest For The Selected Member";
			$varHeading			= "Accepted Interests";
		}
		if($varInterestStatus==2) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Status In (3,5,12,14) ORDER BY Date_Sent DESC";
			$varDisplayMessage	= "No Declined Interest For The Selected Member";
			$varHeading			= "Declined Interests";
		}
		if($varInterestStatus==7) {
			$varCondition		= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." ORDER BY Date_Sent DESC";
			$varDisplayMessage	= "No Interest For The Selected Member";
			$varHeading			= "Total Interest Sent";
		}
	}


	// GET FAVORITES STATISTICS
	if($varLists==1) {
		$varCondition			= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." ";
		$varTableName			=  $varTable['BOOKMARKINFO'];
		$varFields				= array('MatriId','Opposite_MatriId', 'Date_Updated','Comments');
		$varDisplayMessage		= "No Favorites Members For The Selected Member";
		$varHeading				= "Favourites";
	}
	// GET BLOCKS STATISTICS
	if($varLists==2) {
		$varCondition			= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." ";
		$varTableName			=  $varTable['BLOCKINFO'];
		$varFields				= array('MatriId','Opposite_MatriId', 'Date_Updated','Comments');	
		$varDisplayMessage		= "No Blocked Members For The Selected Member";
		$varHeading				= "Blocked Profiles";
	}
	// GET IGNORES STATISTICS
	if($varLists==3) {
		$varCondition			= " WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." ";
		$varTableName			= $varTable['IGNOREINFO'];
		$varFields				= array('MatriId','Opposite_MatriId', 'Date_Updated','Comments');	
		$varDisplayMessage		= "No Ignored Members For The Selected Member";
		$varHeading				= "Ignore List";
	}


		$varStatisticsResult	= $objSlave->select($varTableName,$varFields,$varCondition,0);
		$varMessagesCount		= mysql_num_rows($varStatisticsResult);
	?>
<html>
	<head>
		<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/global-style.css">
		<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/usericons-sprites.css">
		<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/useractions-sprites.css">
		<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/useractivity-sprites.css">
		<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/messages.css">
		<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/fade.css">
	</head>
<body>
	<table border="0" cellpadding="0" cellspacing="0" align="center" width="600">
	<tr>
		<td height="20px"></td>
	</tr>
	<tr>
		<td class="mediumhdtxt" align="left" colspan="2"><b>MatriId:</b> <font class="mediumtxt"> <?php echo $varMatriId;?></font>	</td>
	</tr>
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td class="mediumhdtxt" align="right" colspan="2"><b>Total Message Count:</b> <font class="mediumtxt"> <?php echo $varMessagesCount;?></font>	</td>
	</tr>
	<tr>
		<td width="10"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="10" height="1"></td>
		<td valign="top" bgcolor="#FFFFFF">
			<div style="padding-top:5px;padding-bottom:5px;"><font class="heading"><?=$varHeading;?>		
			</font></div>
		</td>
	</tr>
	<tr><td colspan="2" height="3px"></td></tr>
	<tr>
		<td colspan="2">
			<table width="594" border="0" cellspacing="0" cellpadding="0" class="formborderclr">
			<?php if($varMessagesCount==0){ ?>
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="3" align="center" width="75%" class="formborder">
						<tr>
							<td align ="center" class="mediumhdtxt"><b><?php echo $varDisplayMessage;?></b></td>
						</tr>
					</table>
				</td>
			</tr>
			<?php }else {?>
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="3" align="center" width="100%" class="formborder">	
					<tr class="memonlsbg4" class="adminformheader" bgcolor="#EFEFEF">
						<td class="smalltxt bold" width="20%" align="left"><b>Matrimony-Id</b></td>
						<?php if(!isset($_REQUEST['List'])){?><td class="smalltxt bold" width="20%" align="left"><b>Status</b></td><?php }?>
						<?php if(isset($_REQUEST['Msgval'])){?><td class="smalltxt bold" width="20%" align="left"><b>Message type</b></td><?php }?>
						<td class="smalltxt bold" width="20%" align="left"><b>
						<?php if($varMessageReceiverStatus!="")  
								echo "Message";
							  elseif($varInterestReceiverStatus !="")
								echo "Interest Message";
							  else
								echo 'Comments';
						?>
						</b></td>
						<td class="smalltxt bold" width="20%" align="left"><b>
						<?php if($varMessageReceiverStatus==1 || $varInterestReceiverStatus==1)  
								echo "Received Date";
							  elseif($varMessageReceiverStatus==2 || $varInterestReceiverStatus==2)
								echo "Sent Date";
							  else
								echo "Updated Date";
						?>
						</b></td>
					</tr>	
					<?php 
							while($varStatistics = mysql_fetch_array($varStatisticsResult)){
								if($varMessageReceiverStatus==1 || $varInterestReceiverStatus ==1) 
									$varDate			= $varStatistics['Date_Received'];
								if($varMessageReceiverStatus==2 || $varInterestReceiverStatus ==2) 
									$varDate			= $varStatistics['Date_Sent'];

								if($varMessageReceiverStatus!="") 
									$varMessageOption	= $varStatistics['Mail_Message'];
								elseif($varInterestReceiverStatus !="")
								$varMessageOption	= $varArrSendSalamList[$varStatistics['Interest_Option']];
								else
								{
									$varDate = $varStatistics['Date_Updated'];
									$varMessageOption	= $varStatistics['Comments'];
								}
								if(strlen($varMessageOption)>40) 
									$varCovertedMessage = substr($varMessageOption,0,40)."...";
								   $varCovertedMessage = $varMessageOption;
								   
								  if(($varMessageReceiverStatus==1)||($varMessageReceiverStatus==2)) { 
									if(($varStatistics['Status']==0)||($varStatistics['Status']==1)||($varStatistics['Status']==2)||($varStatistics['Status']==3)){
											$varStatus="Message active";
									}  if(($varStatistics['Status']==4)||($varStatistics['Status']==5)||										($varStatistics['Status']==6)||($varStatistics['Status']==7)){
										$varStatus="Message deleted by user";
									} if(($varStatistics['Status']==9)||($varStatistics['Status']==10)||										($varStatistics['Status']==11)||($varStatistics['Status']==12)){
										$varStatus="Profile deleted with message active ";
									} if(($varStatistics['Status']==13)||($varStatistics['Status']==14)||										($varStatistics['Status']==15)||($varStatistics['Status']==16)){
										$varStatus="Profile deleted with message deleted";
									}
									}

									if(($varInterestReceiverStatus==1)||($varInterestReceiverStatus==2)) { 
									if(($varStatistics['Status']==0)||($varStatistics['Status']==1)||($varStatistics['Status']==3)){
										$varStatus="Interest active";
									}  if(($varStatistics['Status']==4)||($varStatistics['Status']==5)||								($varStatistics['Status']==6)||($varStatistics['Status']==7)){
										$varStatus="Interest deleted by user";
									} if(($varStatistics['Status']==9)||($varStatistics['Status']==10)||										($varStatistics['Status']==11)||($varStatistics['Status']==12)){
										$varStatus="Profile deleted with interest active ";
									} if(($varStatistics['Status']==13)||($varStatistics['Status']==14)||										($varStatistics['Status']==15)||($varStatistics['Status']==16)){
										$varStatus="Profile deleted with interest deleted";
									}
									}		

					?>
					<tr>						
						<td class="smalltxt" width="20%">
							<a href="../admin/index.php?act=view-profile1&actstatus=yes&
							matrimonyId=<?=$varStatistics['Opposite_MatriId']?>"class="navlinktxt1admin" 
							target="_blank"><?php echo $varStatistics['Opposite_MatriId'];?></a>
						</td>						
						<?php if(!isset($_REQUEST['List'])){?>
							<td class="smalltxt" width="20%"><?php echo $varStatus;?></td>
						<?php }?>
						<?php  if(isset($_REQUEST['Msgval'])){?>
						<td class="smalltxt" width="20%">
							<?php 
								if($varMessageStatus==4){
									if(array_key_exists($varStatistics['Status'], $varMessageReceivedInfo)){
										echo $varMessageReceivedInfo[$varStatistics['Status']];
									}else{
										echo"-----";
									}							
								}if($varMessageStatus==5){
									if(array_key_exists($varStatistics['Status'], $varMessageSentInfo)){
										echo $varMessageSentInfo[$varStatistics['Status']];
									}else{
										echo"-----";
									}
								}if($varInterestStatus==6){
									if(array_key_exists($varStatistics['Status'], $varInterestReceivedInfo)){
										echo $varInterestReceivedInfo[$varStatistics['Status']];
									}else{
										echo"-----";
									}
								}if($varInterestStatus==7){
									if(array_key_exists($varStatistics['Status'], $varInterestSentInfo)){
										echo $varInterestSentInfo[$varStatistics['Status']];
									}else{
										echo"-----";
									}
								}
							?>
						</td>
						<?php }?>
						<td class="smalltxt" width="20%"> 
							<?php if($varMessageOption==''){ echo "-----";}else{?>
							<a href="javascript:funMessageShow('<?=$varMessageOption?>');"><?php echo $varMessageOption;?></a><?php }?>
						</td>
						<td class="smalltxt" width="20%">
							<?php echo date("d M Y", strtotime($varDate));?>
						</td>

					</tr>
					<?php }?>
					</table>
				</td>
			</tr>
			<?php }?>
			</table>
		</td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr><td align="right" colspan="2" style="padding-right:10px"><?php if (isset($_REQUEST['act'])){?> <a href="javascript:history.back();" class="formlink1">Back</a><?php } ?></td></tr>
	<tr><td align="center" colspan="2" style="padding-right:10px" ><?php if (!isset($_REQUEST['act'])){?><input type="button" value="Close Window" onClick="window.close()" class="button"> <?php }?></td></tr>
	</table>
</body>
</html>
<script language="javascript">
function funMessageShow(argMsgId)
{
	var funUrl = "message-popup.php?msg="+argMsgId;
	window.open(funUrl,'Message','toolbar=no,scrollbars=yes,resizable=yes,width=500,height=200');
}//funMessageShow

</script>
<? $objSlave->dbClose(); ?>