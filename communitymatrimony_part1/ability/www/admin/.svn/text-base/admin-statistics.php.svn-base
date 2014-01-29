<?php
//FILE INCLUDES
include_once $varRootBasePath."/conf/config.inc";
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/productvars.inc');
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath.'/lib/clsMailManager.php');


//OBJECT DECLARATION
$objSlave	= new DB;
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

if(($_POST['frmStatisticsSubmit'] == "yes"))
{

	//VARIABLE DECLARATION
	$varUserName 			= $_REQUEST["matrimonyId"];
	$vartype				= $_REQUEST["type"];
	$varFields 				= array('MatriId','Email');
	
	if($vartype==2) 
	{
		$varCondition		= " WHERE User_Name='".$varUserName."'";
		$varExecute			= $objSlave->select($varTable['MEMBERLOGININFO'],$varFields,$varCondition,0);
		$varSelectMatriId	= mysql_fetch_assoc($varExecute);
		$varMatriId			= $varSelectMatriId['MatriId'];

	} else { $varMatriId = $varUserName; }

	$varNoOfResults	= $objSlave->numOfRecords($varTable['MEMBERLOGININFO'],'MatriId',$varCondition);

	if($varNoOfResults==0)
	{
			echo '<br><table width="543" border="0" cellspacing="0" cellpadding="0" align="left" class="formborderclr" valign="top"><tr><td class="errorMsg" height="40" valign="middle" align="center">No members match with your selected criteria. <a href="javascript:history.back();" class="formlink"><b>Click here to try again</b></a></td></tr><tr><td height="10"></td></tr><tr><td></td></tr></table>';

	 } else {
	
	// GET MAIL RECEIVED STATISTICS
	$varCondition					= " WHERE MatriId='".$varMatriId."'";
	$varMailReceivedCount			= $objSlave->numOfRecords($varTable['MAILRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=1";
	$varNotRepliedMsgRecievedCount	= $objSlave->numOfRecords($varTable['MAILRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=2";
	$varRepliedMsgRecievedCount		= $objSlave->numOfRecords($varTable['MAILRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=3";
	$varDeclineMsgRecievedCount		= $objSlave->numOfRecords($varTable['MAILRECEIVEDINFO'],'MatriId',$varCondition);


	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=0";
	$varNewMsgRecievedCount			= $objSlave->numOfRecords($varTable['MAILRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=6 OR Status=7 OR Status=8 OR Status=9)";
	$varMailRecievedDeleteCount		= $objSlave->numOfRecords($varTable['MAILRECEIVEDINFO'],'MatriId',$varCondition);

	// GET MAIL SENT STATISTICS
	$varCondition					= " WHERE MatriId='".$varMatriId."'";
	$varMailSentCount				= $objSlave->numOfRecords($varTable['MAILSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=5";
	$varMailSentDeleteCount			= $objSlave->numOfRecords($varTable['MAILSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=1 OR Status=2 OR Status=7 OR Status=8)";
	$varMailSentReadCount			= $objSlave->numOfRecords($varTable['MAILSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=0 OR Status=6)";
	$varMailSentNotReadCount		= $objSlave->numOfRecords($varTable['MAILSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=3 OR Status=9)";
	$varMailSentDeclinedCount		= $objSlave->numOfRecords($varTable['MAILSENTINFO'],'MatriId',$varCondition);


	// GET INTEREST RECEIVED STATISTICS
	$varCondition					= " WHERE MatriId='".$varMatriId."'";
	$varInterestReceivedCount		= $objSlave->numOfRecords($varTable['INTERESTRECEIVEDINFO'],'MatriId',$varCondition);

	//Interest_Status 0=>Pending, 1=>Accepted, 2=>Declined
	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=0";
	$varNoOfPendingList				= $objSlave->numOfRecords($varTable['INTERESTRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=1";
	$varNoOfAcceptList				= $objSlave->numOfRecords($varTable['INTERESTRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=3";
	$varNoOfDeclineList				= $objSlave->numOfRecords($varTable['INTERESTRECEIVEDINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=6 OR Status=7)";
	$varNoOfDeletedList				= $objSlave->numOfRecords($varTable['INTERESTRECEIVEDINFO'],'MatriId',$varCondition);


	// GET INTEREST SENT STATISTICS
	$varCondition					= " WHERE MatriId='".$varMatriId."'";
	$varInterestSentCount			= $objSlave->numOfRecords($varTable['INTERESTSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=0";
	$varInterestSentPendingList		= $objSlave->numOfRecords($varTable['INTERESTSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND Status=5";
	$varInterestSentDeleteList		= $objSlave->numOfRecords($varTable['INTERESTSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=1 OR Status=6)";
	$varInterestSentAcceptList		= $objSlave->numOfRecords($varTable['INTERESTSENTINFO'],'MatriId',$varCondition);

	$varCondition					= " WHERE MatriId='".$varMatriId."' AND (Status=3 OR Status=7)";
	$varInterestSentDeclineList		= $objSlave->numOfRecords($varTable['INTERESTSENTINFO'],'MatriId',$varCondition);

	// GET FAVORITES STATISTICS
	$varCondition					= " WHERE MatriId='".$varMatriId."'";

	$varFavoritesCount				= $objSlave->numOfRecords($varTable['BOOKMARKINFO'],'MatriId',$varCondition);
	$varBlocksCount					= $objSlave->numOfRecords($varTable['BLOCKINFO'],'MatriId',$varCondition);
	$varIgnoresCount				= $objSlave->numOfRecords($varTable['IGNOREINFO'],'MatriId',$varCondition);

?>
<script language="javascript" src="includes/admin.js" type="text/javascript"></script>

<table border="0" cellpadding="0" cellspacing="0" align="left" width="543">
	<tr><td height="10"></td></tr>
	<tr><td valign="middle" class="heading" style="padding-left:10px;">Statistics</td></tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td valign="top">
		<!-- My Messages starts here-->
			<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="523" align="center">
				<tr class="adminformheader">
					<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="mediumtxt boldtxt">My Messages</td>
				</tr>
				

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%">No of Messages Received:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varMailReceivedCount; ?>
					</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%">No of Messages Sent:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varMailSentCount; ?>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&MsgReceiverStatus=1&MsgStatus=0&Records=<?=$varNewMsgRecievedCount ?>" class="smalltxt">No of UnRead Messages:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varNewMsgRecievedCount; ?>
							</td>
							
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&MsgReceiverStatus=2&MsgStatus=1&Records=<?=$varMailSentReadCount ?>" class="smalltxt">No of Read Messages:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varMailSentReadCount; ?>
							</td>
						</tr>
						<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
						<tr bgcolor="#FFFFFF">
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&MsgReceiverStatus=1&MsgStatus=1&Records=<?=$varNotRepliedMsgRecievedCount ?>" class="smalltxt">No of NotReplied Messages:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varNotRepliedMsgRecievedCount; ?>
							</td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&MsgReceiverStatus=2&MsgStatus=0&Records=<?=$varMailSentNotReadCount ?>" class="smalltxt">No of UnRead Messages:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varMailSentNotReadCount; ?>
							</td>
						</tr>
						<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

						<tr bgcolor="#FFFFFF">
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&MsgReceiverStatus=1&MsgStatus=2&Records=<?=$varRepliedMsgRecievedCount ?>" class="smalltxt">No of Replied Messages:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varRepliedMsgRecievedCount; ?>
							</td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&MsgReceiverStatus=2&MsgStatus=2&Records=<?=$varMailSentDeclinedCount ?>" class="smalltxt">No of Declined Messages:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varMailSentDeclinedCount; ?>
							</td>
						</tr>
						<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
						<tr bgcolor="#FFFFFF">
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&MsgReceiverStatus=1&MsgStatus=3&Records=<?=$varDeclineMsgRecievedCount ?>" class="smalltxt">No of Declined Messages:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varDeclineMsgRecievedCount; ?>
							</td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&MsgReceiverStatus=2&MsgStatus=4&Records=<?=$varMailSentDeleteCount ?>" class="smalltxt">No of Deleted Messages:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varMailSentDeleteCount; ?>
							</td>
						</tr>
						<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
						<tr bgcolor="#FFFFFF">
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&MsgReceiverStatus=1&MsgStatus=4&Records=<?=$varMailRecievedDeleteCount ?>" class="smalltxt">No of Deleted Messages:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varMailRecievedDeleteCount; ?>
							</td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:20px;padding-bottom:3px;" width="35%"> </td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:24px;padding-bottom:3px;" width="15%">
							</td>
						</tr>
						<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			</table><br>
			<!-- My Interest Starts Here -->
			<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="523" align="center">
				<tr class="adminformheader">
					<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="viewheading">My Express Interests</td>
				</tr>
				
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%">No of Interests Received:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varInterestReceivedCount; ?>
					</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%">No of Interests Sent:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varInterestSentCount; ?>
					</td>
				</tr>
				
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&InterestReceiverStatus=1&InterestStatus=0&Records=<?=$varNoOfPendingList ?>" class="smalltxt">No of Pending Interests:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varNoOfPendingList; ?>
							</td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&InterestReceiverStatus=2&InterestStatus=0&Records=<?=$varInterestSentPendingList ?>" class="smalltxt">No of Interest Sent Pending:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varInterestSentPendingList; ?>
							</td>
						</tr>
						<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
						<tr bgcolor="#FFFFFF">
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&InterestReceiverStatus=1&InterestStatus=1&Records=<?=$varNoOfAcceptList ?>" class="smalltxt">No of Accepted Interests:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varNoOfAcceptList; ?>
							</td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&InterestReceiverStatus=2&InterestStatus=1&Records=<?=$varInterestSentAcceptList ?>" class="smalltxt">No of Interest Sent Accepted:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varInterestSentAcceptList; ?>
							</td>
						</tr>
						<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
						<tr bgcolor="#FFFFFF">
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&InterestReceiverStatus=1&InterestStatus=2&Records=<?=$varNoOfDeclineList ?>" class="smalltxt">No of Declined Interests:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="8%"><?= $varNoOfDeclineList; ?>
							</td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&InterestReceiverStatus=2&InterestStatus=2&Records=<?=$varInterestSentDeclineList ?>" class="smalltxt">No of Interest Sent Declined:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varInterestSentDeclineList; ?>
							</td>
						</tr>
						<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
						<tr bgcolor="#FFFFFF">
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&InterestReceiverStatus=1&InterestStatus=3&Records=<?=$varNoOfDeletedList ?>" class="smalltxt">No of Deleted Interests:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="8%"><?= $varNoOfDeletedList; ?>
							</td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&InterestReceiverStatus=2&InterestStatus=3&Records=<?=$varInterestSentDeleteList ?>" class="smalltxt">No of Interest Sent Deleted:</a></td>
							<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varInterestSentDeleteList; ?>
							</td>
						</tr>
						<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			</table><br>
			<!-- My Interest Ends Here -->
						<!-- My Lists Starts Here -->
			<table border="0" cellpadding="0" cellspacing="0" class="formborder" width="523" align="center">
				<tr class="adminformheader">
					<td valign="top" colspan="2" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="viewheading">My Lists</td>
				</tr>
				
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&List=1&Records=<?=$varFavoritesCount ?>" class="smalltxt">My Bookmarks:</a></td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="60%"><?= $varFavoritesCount; ?>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&List=2&Records=<?=$varBlocksCount ?>" class="smalltxt">My Blocks:</a></td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" align="left"><?= $varBlocksCount; ?>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>

				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%"><a href="index.php?act=statistics-details&MatriId=<?= $varMatriId ?>&List=3&Records=<?=$varIgnoresCount ?>" class="smalltxt">My Ignores:</a></td>
					<td valign="top" class="	 smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%"><?= $varIgnoresCount; ?>
					</td>
				</tr>
				<tr class="viewinfsepline"><td width="10" valign="top" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="100%" height="1"></td></tr>
			</table><br>
			<!-- My Lists Ends Here -->
		</td>
	</tr>
</table>
<?php

}
}
else
{
?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="543">
	<tr><td height="10" colspan="2"></td></tr>
	<tr><td valign="middle" class="heading" colspan="2" style="padding-left:15px;">Statistics</td></tr>
	<tr><td height="10" colspan="2"></td></tr>
	<form name="frmStatistics" method="post" target="_blank" onSubmit="return funViewProfileId();">
	<input type="hidden" name="frmStatisticsSubmit" value="yes">
	<tr>
		<td class="smalltxt"  width="30%" style="padding-left:15px;"><b>MatrimonyId/UserName</b>&nbsp;</td>
		<td width="70%" class="smalltxt"><input type=text name="matrimonyId" size="15" class="inputtext">&nbsp;<input type="radio" name="type" value="1">&nbsp;MatrimonyId&nbsp;&nbsp;<input type="radio" name="type" value="2">&nbsp;UserName&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" class="button"></td>
	</tr>
	<tr><td height="20" colspan="2"></td></tr>
	</form>
</table>
<?php
}
$objSlave->dbClose();
?>
<?php
//UNSET OBJECT
unset($objCommon);
?>
<script language="javascript">
function funViewProfileId()
{
	var frmName = document.frmStatistics;
	if (frmName.matrimonyId.value=="")
	{
		alert("Please enter  Username / Matrimony Id");
		frmName.matrimonyId.focus();
		return false;
	}//if
	if (!(frmName.type[0].checked==true || frmName.type[1].checked==true))
	{
		alert("Please select Username / Matrimony Id");
		frmName.type[0].focus();
		return false;
	}//if

	return true;
}//funViewProfileId
</script>