<?php

//FILE INCLUDES
include_once $varRootBasePath."/conf/config.inc";
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/productvars.inc');
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath.'/lib/clsMailManager.php');

//OBJECT DECLARATION
$objSlave	= new MailManager;

$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

$varMatriId					= $_REQUEST['MatriId'];
$varMessageReceiverStatus	= $_REQUEST['MsgReceiverStatus'];
$varInterestReceiverStatus	= $_REQUEST['InterestReceiverStatus'];
$varMessageStatus			= $_REQUEST['MsgStatus'];
$varInterestStatus			= $_REQUEST['InterestStatus'];
$varLists					= $_REQUEST['List'];
$varNoOfRecords				= $_REQUEST['Records'];

$varArrSendSalamList = array(1=>"Hi, I like your profile. Can I message you?.",2=>"I'm interested in knowing you better.",3=>"We could make a great match!.",4=>"I like your photo and I'd like to know you.",5=>"Can I chat with you?",6=>"Have you seen my profile? What do you think of me?",7=>"You're just my type. Can we chat?",8=>"I'm looking for a life partner.",9=>"Lets get to know each other better.",10=>"To begin with, lets be friends.");


//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
if($varNoOfRecords==0)
	$varStatisticsResult="no";

$varNoRecordsMsg			= '<br><table width="590" border="0" cellspacing="0" cellpadding="0" align="center"  valign="top"><tr><td class="errorMsg" height="40" valign="middle" align="center">';
if($varNoOfRecords==0)
{
	if(($varMessageReceiverStatus==1) && ($varMessageStatus==0)) $varNoRecordsMsg .= "No New Messages For The Selected Member";
	if(($varMessageReceiverStatus==1) && ($varMessageStatus==1)) $varNoRecordsMsg .= "No UnReplied Messages For The Selected Member";
	if(($varMessageReceiverStatus==1) && ($varMessageStatus==2)) $varNoRecordsMsg .= "No Replied Messages For The Selected Member";
	if(($varMessageReceiverStatus==1) && ($varMessageStatus==3)) $varNoRecordsMsg .= "No Declined Messages For The Selected Member";
	if(($varMessageReceiverStatus==2) && ($varMessageStatus==0)) $varNoRecordsMsg .= "No UnRead Messages For The Selected Member";
	if(($varMessageReceiverStatus==2) && ($varMessageStatus==1)) $varNoRecordsMsg .= "No Read Messages For The Selected Member";
	if(($varMessageReceiverStatus==2) && ($varMessageStatus==2)) $varNoRecordsMsg .= "No Deleted Messages For The Selected Member";
	if(($varInterestReceiverStatus==1) && ($varInterestStatus==0)) $varNoRecordsMsg .= "No Pending Interest For The Selected Member";
	if(($varInterestReceiverStatus==1) && ($varInterestStatus==1)) $varNoRecordsMsg .= "No Pending Interest For The Selected Member";
	if(($varInterestReceiverStatus==1) && ($varInterestStatus==2)) $varNoRecordsMsg .= "No Accepted Interest For The Selected Member";
	if(($varInterestReceiverStatus==2) && ($varInterestStatus==0)) $varNoRecordsMsg .= "No Deleted Interest For The Selected Member";
	if(($varInterestReceiverStatus==2) && ($varInterestStatus==1)) $varNoRecordsMsg .= "No Pending Interest For The Selected Member";
	if(($varInterestReceiverStatus==2) && ($varInterestStatus==2)) $varNoRecordsMsg .= "No Accepted Interest For The Selected Member";
	if(($varInterestReceiverStatus==1) && ($varInterestStatus==0)) $varNoRecordsMsg .= "No Deleted Interest For The Selected Member";
	if(($varLists==1)) $varNoRecordsMsg .= "No Favorite Members For The Selected Member";
	if(($varLists==2)) $varNoRecordsMsg .= "No Block Members For The Selected Member";
	if(($varLists==3)) $varNoRecordsMsg .= "No Ignored Members For The Selected Member";
}
$varNoRecordsMsg			.='. <a href="javascript:history.back();" class="smalltxt2"><u><b>Click here to try again</b></u></a></td></tr><tr><td height="10"></td></tr><tr><td></td></tr></table>';

if($varNoOfRecords!=0) {
	// GET MAIL RECEIVED STATISTICS
	if($varMessageReceiverStatus==1) { echo "AAAAAAA".$varMessageReceiverStatus;

		$varTableName	= $varTable['MAILRECEIVEDINFO']; 
		$varFields		= array('MatriId','Opposite_MatriId', 'Date_Received','Mail_Message');	

		if($varMessageStatus==0) { 
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND Status=0";
			$varDisplayMessage	= "No New Messages For The Selected Member";
			$varHeading			= "New Messages Received";
		}

		if($varMessageStatus==1) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND Status=1";
			$varDisplayMessage	= "No UnReplied Messages For The Selected Member";
			$varHeading			= "Not Replied Messages Received";
		}

		if($varMessageStatus==2) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND Status=2";
			$varDisplayMessage	= "No Replied Messages For The Selected Member";
			$varHeading			= "Replied Messages Received";
		}

		if($varMessageStatus==3) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND Status=3";
			$varDisplayMessage	="No Decline Messages For The Selected Member";
			$varHeading			= "Declined Received Messages";
		}

		if($varMessageStatus==4) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND (Status=6 OR Status=7 OR Status=8 OR Status=9) ";
			$varDisplayMessage	= "No Deleted Messages For The Selected Member";
			$varHeading			= "Deleted Received Messages";
		}
	}


	// GET MAIL SENT STATISTICS
	if($varMessageReceiverStatus==2)
	{
		$varTableName	= $varTable['MAILSENTINFO'];
		$varFields		= array('MatriId','Opposite_MatriId', 'Date_Sent','Mail_Message');	

		if($varMessageStatus==1) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND (Status=1 OR Status=2 OR Status=7 OR Status=8) ";
			$varDisplayMessage = "No Read Messages For The Selected Member";
			$varHeading			= "Read Sent Messages";
		}

		if($varMessageStatus==0) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND (Status=0 OR Status=6) ";
			$varDisplayMessage = "No UnRead Messages For The Selected Member";
			$varHeading			= "UnRead Sent Messages";
		}

		if($varMessageStatus==2) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND (Status=3 OR Status=9) ";
			$varDisplayMessage	= "No Declined Messages For The Selected Member";
			$varHeading			= "Declined Sent Messages";
		}
		if($varMessageStatus==4) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND Status=5 ";
			$varDisplayMessage	="No Deleted Messages For The Selected Member";
			$varHeading			= "Deleted Sent Messages";
		}

	}


	// GET INTEREST SENT STATISTICS
	if($varInterestReceiverStatus==2)
	{

		$varTableName	= $varTable['INTERESTSENTINFO']; 
		$varFields		= array('MatriId','Opposite_MatriId', 'Date_Sent','Interest_Option','Declined_Option');	

		if($varInterestStatus==0) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND Status=0 ";
			$varDisplayMessage	= "No Pending Interest For The Selected Member";
			$varHeading			= "Salaam Sent - Pending";
		}
		if($varInterestStatus==1) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND (Status=1 OR Status=6) ";
			$varDisplayMessage	= "No Accepted Interest For The Selected Member";
			$varHeading			= "Salaam Sent - Accepted";
		}
		if($varInterestStatus==2) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND (Status=3 OR Status=7) ";
			$varDisplayMessage	= "No Declined Interest For The Selected Member";
			$varHeading			= "Salaam Sent - Declined";
		}
		if($varInterestStatus==3) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND Status=5 ";
			$varDisplayMessage	= "No Deleted Interest For The Selected Member";
			$varHeading			= "Salaam Sent - Deleted";
		}

	}

	// GET INTEREST RECEIVED STATISTICS
	if($varInterestReceiverStatus==1)
	{
		$varTableName	= $varTable['INTERESTRECEIVEDINFO']; 
		$varFields		= array('MatriId','Opposite_MatriId', 'Date_Received','Interest_Option','Declined_Option');	

		if($varInterestStatus==0) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND Status=0 ";
			$varDisplayMessage	= "No Pending Interest For The Selected Member";
			$varHeading			= "Salaam Received - Pending";
		}
		if($varInterestStatus==1) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND Status=1 ";
			$varDisplayMessage	= "No Accepted Interest For The Selected Member";
			$varHeading			= "Salaam Received - Accepted";
		}
		if($varInterestStatus==2) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND Status=3 ";
			$varDisplayMessage	= "No Declined Interest For The Selected Member";
			$varHeading			= "Salaam Received - Declined";
		}
		if($varInterestStatus==3) {
			$varCondition		= " WHERE MatriId='".$varMatriId."' AND (Status=6 OR Status=7) ";
			$varDisplayMessage	= "No Deleted Interest For The Selected Member";
			$varHeading			= "Salaam Received - Deleted";
		}
	}

	// GET FAVORITES STATISTICS
	if($varLists==1) {
		$varCondition			= " WHERE MatriId='".$varMatriId."' ";
		$varTableName			=  $varTable['BOOKMARKINFO'];
		$varFields				= array('MatriId','Opposite_MatriId', 'Date_Updated','Comments');
		$varDisplayMessage		= "No Favorites Members For The Selected Member";
		$varHeading				= "Favorites List";
	}
	// GET BLOCKS STATISTICS
	if($varLists==2) {
		$varCondition			= " WHERE MatriId='".$varMatriId."' ";
		$varTableName			=  $varTable['BLOCKINFO'];
		$varFields				= array('MatriId','Opposite_MatriId', 'Date_Updated','Comments');	
		$varDisplayMessage		= "No Blocked Members For The Selected Member";
		$varHeading				= "Block List";
	}
	// GET IGNORES STATISTICS
	if($varLists==3) {
		$varCondition			= " WHERE MatriId='".$varMatriId."' ";
		$varTableName			= $varTable['IGNOREINFO'];
		$varFields				= array('MatriId','Opposite_MatriId', 'Date_Updated','Comments');	
		$varDisplayMessage		= "No Ignored Members For The Selected Member";
		$varHeading				= "Ignore List";
	}
	$varStatisticsResult	= $objSlave->select($varTableName,$varFields,$varCondition,1);
	$varMessagesCount		= count($varStatisticsResult);
}

?>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="600">
	<tr>
		<td width="10"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="10" height="1"></td>
		<td valign="top" bgcolor="#FFFFFF">
		<div style="padding-top:5px;padding-bottom:5px;"><font class="heading"><?=$varHeading;?>		
		</font></div>
		</td>
	</tr>
	<tr><td colspan="2">
	<table width="594" border="0" cellspacing="0" cellpadding="0" class="formborderclr">
		<?php //if ($varMessageReceivedResult !="no") { ?>
		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="3" align="center" width="100%">
					<tr class="memonlsbg4">
						<td width="4%"></td>
						<td class="smalltxt" width="25%" align="left"><b>Username</b></td>
						<td class="smalltxt" width="50%" align="left"><b>
						<?php if($varMessageReceiverStatus!="")  
								echo "Message";
							  elseif($varInterestReceiverStatus !="")
								echo "Interest Message";
							  else
								echo 'Comments';
						?>
						</b></td>

						<td class="smalltxt" width="20%" align="left"><b>
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
					 if($varMessagesCount==0)
						echo '<tr><td class="errorMsg" height="40" valign="middle" align="center" colspan="4">'.$varDisplayErrorMsg.'</td></tr>';
					else
					{
						 for($i=0;$i<$varMessagesCount;$i++)
						{ 
							$funLink = '<a href="../search/index.php?act=profile-view&matrimonyId='.$varStatisticsResult[$i]['Opposite_MatriId'].'"class="navlinktxt1admin" target="_blank">';
							$varUserName = $objSlave->getUsername($varStatisticsResult[$i]['Opposite_MatriId']);
							if ($varUserName=="") { $funUsername	= $objSlave->getDeleteUsername($varStatisticsResult[$i]['Opposite_MatriId']); }
							else {$funUsername	= $varUserName; }//else

							if($varMessageReceiverStatus==1 || $varInterestReceiverStatus ==1) 
								$varDate			= $varStatisticsResult[$i]['Date_Received'];
							if($varMessageReceiverStatus==2 || $varInterestReceiverStatus ==2) 
								$varDate			= $varStatisticsResult[$i]['Date_Sent'];

							if($varMessageReceiverStatus!="") 
								$varMessageOption	= $varStatisticsResult[$i]['Mail_Message'];
							elseif($varInterestReceiverStatus !="")
							$varMessageOption	= $varArrSendSalamList[$varStatisticsResult[$i]['Interest_Option']];
							else
							{
								$varDate = $varStatisticsResult[$i]['Date_Updated'];
								$varMessageOption	= $varStatisticsResult[$i]['Comments'];
							}
							if(strlen($varMessageOption)>40) 
								$varCovertedMessage = substr($varMessageOption,0,40)."...";
							else $varCovertedMessage = $varMessageOption; 
							$funLink2 ='<a href="javascript:funMessageShow(\''.$varMessageOption.'\');" class="navlinktxt1admin">'; 
							echo '<tr><td align="left"></td><td class="smalltxtadmin">'.$funLink.$funUsername.'</a></td><td class="smalltxtadmin" align="left">'.$funLink2.$varCovertedMessage.'</td><td class="smalltxtadmin" align="left">'.date("d M Y", strtotime($varDate)).'</td></tr>';

						}
					}
					?>
				</table>
		<tr><td height="10"></td></tr>
	</table>
    </td>
  </tr>
  <tr><td height="10" colspan="2"></td></tr>
  <tr><td align="right" colspan="2" style="padding-right:10px"><a href="javascript:history.back();" class="formlink1">Back</a></td></tr>
</table>
<script language="javascript">
function funMessageShow(argMsgId)
{
	var funUrl = "message-popup.php?msg="+argMsgId;
	window.open(funUrl,'Message','toolbar=no,scrollbars=yes,resizable=yes,width=500,height=200');
}//funMessageShow

</script>
<? $objSlave->dbClose(); ?>