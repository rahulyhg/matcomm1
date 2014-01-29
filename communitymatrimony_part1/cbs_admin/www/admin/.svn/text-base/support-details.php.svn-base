<?php
//FILE INCLUDES
include_once('../includes/config.php');
include_once('../includes/dbConn.php');
include_once('includes/clsCommon.php');

//OBJECT DECLARATION
$objCommon = new Common;

if(($_POST['frmSupportProfileViewSubmit'] == "yes"))
{

//VARIABLE DECLARATION
$varUserName 				= $_REQUEST["matrimonyId"];


$objCommon->clsTable		= "memberlogininfo";
$objCommon->clsFields 		= array('MatriId','Email');
$objCommon->clsPrimary      = array('User_Name');
$objCommon->clsCountField	= 'User_Name';
$objCommon->clsPrimaryValue = array($varUserName);
$varSelectUserName			= $objCommon->selectinfo();
$varRecordsNumber			= $objCommon->numOfResults();
$varMatriId = $varSelectUserName['MatriId'];

if($varRecordsNumber==0)
{
	echo '<table border="0" cellpadding="0" cellspacing="0" align="left" width="600">
	<tr><td valign="middle" class="heading" colspan="2">Support Profile View</td></tr>
	<tr><td height="10" colspan="2"></td></tr><tr><td colspan="2"><table width="600" border="0" cellspacing="0" cellpadding="0" align="left" class="formborderclr" valign="top"><tr><td class="errorMsg" height="40" valign="middle" align="center">No members match with your selected criteria. <a href="javascript:history.back();" class="formlink"><b>Click here to try again</b></a></td></tr><tr><td height="10"></td></tr><tr><td></td></tr></table></td></tr></table>';
}
else
{
// GET MAIL RECEIVED STATISTICS
$objCommon->clsTable			= "mailbasicinfo";
$objCommon->clsFields		= array('MatriId','Opposite_MatriId','Mail_Message','Forwarded','Date_Forwarded','Mail_Folder','Mail_Follow_Up','Date_Read','Date_Replied','Sender_Status','Receiver_Status','Date_Updated','Trash_Status','Mark_Status','Date_Declined');
$objCommon->clsPrimary			= array('Opposite_MatriId'); 
$objCommon->clsCountField		= 'Opposite_MatriId'; 
$objCommon->clsPrimaryValue		= array($varMatriId);
$objCommon->clsPrimarySymbol	= array('=');
$varMailReceivedCount			= $objCommon->numOfResults();

$objCommon->clsPrimary			= array('Opposite_MatriId','Receiver_Status','Mark_Status'); 
$objCommon->clsPrimaryKey		= array('AND','AND');
$objCommon->clsPrimarySymbol	= array('=','=','=');

$objCommon->clsPrimaryValue		= array($varMatriId,'1','0');
$varNotRepliedMsgRecievedCount	= $objCommon->numOfResults();

$objCommon->clsPrimaryValue		= array($varMatriId,'2','0');
$varRepliedMsgRecievedCount	= $objCommon->numOfResults();

$objCommon->clsPrimaryValue		= array($varMatriId,'3','0');
$varDeclineMsgRecievedCount		= $objCommon->numOfResults();

$objCommon->clsPrimaryValue		= array($varMatriId,'0','1');
$objCommon->clsPrimaryKey		= array('AND','OR');
$objCommon->clsPrimaryGroupStart=  "1";
$objCommon->clsPrimaryGroupEnd	= "2";
$varNewMsgRecievedCount			= $objCommon->numOfResults();


// GET MAIL SENT STATISTICS
$objCommon->clsPrimary			= array('MatriId'); 
$objCommon->clsCountField		= 'MatriId'; 
$objCommon->clsPrimaryValue		= array($varMatriId);
$objCommon->clsPrimarySymbol	= array('=');
$varMailSentCount				= $objCommon->numOfResults();

$objCommon->clsPrimary			= array('MatriId', 'Sender_Status','Receiver_Status','Receiver_Status','Receiver_Status','Receiver_Status');
$objCommon->clsPrimaryKey		= array('AND','AND','OR','OR','OR');
$objCommon->clsPrimaryGroupStart = 2;
$objCommon->clsPrimaryGroupEnd	= 5;
$objCommon->clsPrimaryValue		= array($varMatriId, '0','1','2','7','8');
$varMailSentReadCount			= $objCommon->numOfResults();

$objCommon->clsPrimary			= array('MatriId', 'Sender_Status','Receiver_Status','Receiver_Status');
$objCommon->clsPrimaryGroupStart = 2;
$objCommon->clsPrimaryGroupEnd	= 3;

$objCommon->clsPrimaryValue		= array($varMatriId, '0','0','6');
$varMailSentNotReadCount		= $objCommon->numOfResults();

$objCommon->clsPrimaryValue		= array($varMatriId, '0','3','9');
$varMailSentDeclinedCount		= $objCommon->numOfResults();


// GET INTEREST RECEIVED STATISTICS
$objCommon->clsTable			= "expressinterestinfo";
$objCommon->clsFields			= array('MatriId','Opposite_MatriId','Interest_Option','Sender_Status','Receiver_Status','Date_Updated','Declined_Option','Date_Accepted','Date_Declined');
$objCommon->clsPrimary			= array('Opposite_MatriId');
$objCommon->clsCountField		= 'Opposite_MatriId'; 
$objCommon->clsPrimaryValue		= array($varMatriId);
$objCommon->clsPrimarySymbol	= array('=');
$varInterestReceivedCount		= $objCommon->numOfResults();

$objCommon->clsPrimary	= array('Opposite_MatriId', 'Receiver_Status'); //Interest_Status 0=>Pending, 1=>Accepted, 2=>Declined
$objCommon->clsPrimaryValue	= array($varMatriId, '0');
$objCommon->clsPrimaryKey	= array('AND');
$varNoOfPendingList = $objCommon->numOfResults();
$objCommon->clsPrimaryValue	= array($varMatriId, '1');
$varNoOfAcceptList = $objCommon->numOfResults();
$objCommon->clsPrimaryValue	= array($varMatriId, '3');
$varNoOfDeclineList = $objCommon->numOfResults();


// GET INTEREST SENT STATISTICS
$objCommon->clsPrimary			= array('MatriId'); 
$objCommon->clsCountField		= 'MatriId';
$varInterestSentCount			= $objCommon->numOfResults();

$objCommon->clsPrimary		= array('MatriId', 'Sender_Status','Receiver_Status');
$objCommon->clsPrimaryKey	= array('AND','AND');
$objCommon->clsPrimaryValue	= array($varMatriId, '0','0');
$objCommon->clsPrimaryGroupStart = 0.1;
$objCommon->clsPrimaryGroupEnd	= 0.1;

$varInterestSentPendingList = $objCommon->numOfResults();

$objCommon->clsPrimary		= array('MatriId', 'Sender_Status','Receiver_Status','Receiver_Status');
$objCommon->clsPrimaryKey	= array('AND','AND','OR');
$objCommon->clsPrimaryGroupStart = 2;
$objCommon->clsPrimaryGroupEnd	= 3;

$objCommon->clsPrimaryValue	= array($varMatriId, '0','1','6');
$varInterestSentAcceptList = $objCommon->numOfResults();
$objCommon->clsPrimaryValue	= array($varMatriId, '0','3','7');
$varInterestSentDeclineList = $objCommon->numOfResults();

// GET FAVORITES STATISTICS
$objCommon->clsTable			= "bookmarkinfo";
$objCommon->clsFields			= array('MatriId','Opposite_MatriId','Bookmarked','Comments ','Date_Updated');
$objCommon->clsPrimary			= array('MatriId'); 
$objCommon->clsPrimaryValue		= array($varMatriId);
$objCommon->clsPrimarySymbol	= array('=');
$varFavoritesCount				= $objCommon->numOfResults();

// GET BLOCKS STATISTICS
$objCommon->clsTable			= "blockinfo";
$objCommon->clsFields			= array('MatriId','Opposite_MatriId','Blocked','Comments ','Date_Updated');
$objCommon->clsPrimary			= array('MatriId'); 
$objCommon->clsPrimaryValue		= array($varMatriId);
$objCommon->clsPrimarySymbol	= array('=');
$varBlocksCount					= $objCommon->numOfResults();

// GET IGNORES STATISTICS
$objCommon->clsTable			= "ignoreinfo";
$objCommon->clsFields			= array('MatriId','Opposite_MatriId','Ignored','Comments ','Date_Updated');
$objCommon->clsPrimary			= array('MatriId'); 
$objCommon->clsPrimaryValue		= array($varMatriId);
$objCommon->clsPrimarySymbol	= array('=');
$varIgnoresCount				= $objCommon->numOfResults();

?>
<script language="javascript" src="includes/admin.js" type="text/javascript"></script>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="600">
	<tr><td valign="middle" class="heading">Statistics</td></tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<!-- My Messages starts here-->
			<table border="0" cellpadding="0" cellspacing="0" class="formborderclr" width="100%" align="left">
				<tr class="myprofsubbg">
					<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;" class="grtxtbold2">My Messages</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="formlink1" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%">No of Messages Received:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varMailReceivedCount; ?>
					</td>
					<td valign="top" class="formlink1" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="40%">No of Messages Sent:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="10%"><?= $varMailSentCount; ?>
					</td>
				</tr>
					</table>
				</td></tr>
			<table><br>
			<!-- My Salaams Starts Here -->

			</td>
			<td width="10"><img src="images/trans.gif" width="10" height="1"></td>
		</tr>
</table>
<?php
}
}
else
{
?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="600">
	<tr><td valign="middle" class="heading" colspan="2">Support Profile View</td></tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr><td colspan="2">
	<form name="frmSupportProfileView" method="post" onSubmit="return funViewProfileId();">
	<input type="hidden" name="frmSupportProfileViewSubmit" value="yes">
	<table cellspacing="0" cellpadding="0" border="0" width="50%" align="left">
		<tr>
			<td height="38px" class="textsmallbolda">Enter username&nbsp;&nbsp;
			<input type=text name="matrimonyId" size="15" class="adftextfiled"></td>
			<td><input type="image" src="../images/search.gif"></td>
		</tr>
	</table>
	</form>
	</td></tr>
</table>
<?php
}
?>
<?php
//UNSET OBJECT
unset($objCommon);
?>
<script language="javascript">
function funViewProfileId()
{
	var frmName = document.frmSupportProfileView;
	if (frmName.matrimonyId.value=="")
	{
		alert("Please enter  Username");
		frmName.matrimonyId.focus();
		return false;
	}//if
	return true;
}//funViewProfileId
</script>
