<?php
//FILE INCLUDES
include_once('includes/clsMyMessages.php');

//OBJECT DECLARTION
$objMyMessage = new MyMessage;

//CONTROL STATEMENT
if ($_REQUEST["frmMessageSentSubmit"]=="yes")
{
	$objMyMessage->clsTable			= 'expressinterestinfo';
	$objMyMessage->clsPrimary		= array('Interest_Id');
	$objMyMessage->clsPrimaryKey	= array('AND');
	$varMessageIds = explode(",",substr($_REQUEST["messageIds"],0,-1));
	for ($i=0;$i<count($varMessageIds);$i++)
	{
		$objMyMessage->clsFields		= array('Receiver_Status');
		$objMyMessage->clsPrimaryValue	= array($varMessageIds[$i]);
		$varSenderInfo = $objMyMessage->selectMyMessage();
		if ($varSenderInfo["Receiver_Status"] >="4")
		{
			$objMyMessage->deleteMyMessage(); 
		}//if
		else
		{
			$objMyMessage->clsFieldsValues	= array('5',Date('Y-m-d H:i:s'));
			$objMyMessage->clsFields		= array('Sender_Status','Date_Updated');
			$objMyMessage->updateMyMessage();
		}//else
	}//for
}//if

#-----------------------------------------------------------------------------------------------------
?>
<script language="javascript" src="includes/interest-sent.js" type="text/javascript"></script>

<!-- Calling Ajax Function To Display Photo Starts Here -->
<script language="javascript" src="<?=$confValues['ServerURL']?>/search/includes/libAjaxForSearch.js"></script>
<script language="javascript">
	var argPlaceHolderId;
	function funShowPhoto(argMatriId, argChoice, argType)
	{
		//var photoPath	= "<?=$confValues['GetPhotoURL']?>";
		//photoPath += "?mid="+argMatriId+"&cho="+argChoice+"&typ="+argType;
		var photoPath = "../photo/get-photo.php?mid="+argMatriId+"&cho="+argChoice+"&typ="+argType;
		argPlaceHolderId="id"+argMatriId;
		funGetSearchResults(photoPath);
	}//showPhoto
</script>
<!-- Calling Ajax Function To Display Photo Ends Here -->

<!--View Similar Profiles starts here-->
<form name="frmViewSimilarProfiles" action="../search/index.php" target="_blank" method="post" onSubmit="return false;">
<input type="hidden" name="act" value="star-search-results">
<input type="hidden" name="displayFormat" value="T">
<input type="hidden" name="gender" value="<?=$_REQUEST["gender"];?>">
<input type="hidden" name="religion">
<input type="hidden" name="caste">
<input type="hidden" name="star">
<input type="hidden" name="city">
</form>
<!--View Similar Profiles ends here-->

<!-- form starts here -->
<form name="frmMessageSent" method="post" onSubmit="return false;">
<input type="hidden" name="frmMessageSentSubmit" value="yes">
<input type="hidden" name="act" value="interest-sent">
<input type="hidden" name="messageIds" value="">
<input type="hidden" name="rel" value="<?=$_REQUEST["rel"];?>">
<input type="hidden" name="cat" value="<?=$_REQUEST["cat"];?>">
<input type="hidden" name="star" value="<?=$_REQUEST["star"];?>">
<input type="hidden" name="city" value="<?=$_REQUEST["city"];?>">

<input type="hidden" name="page" value="1">
<input type="hidden" name="pageName" value="pending">

<div id="idDisplayInterestRecieved">

<!-- Ajax Function Starts Here -->
<!-- <script language="javascript" src="../search/includes/libAjaxForSearch.js"></script> -->
<script language="javascript">
	function iconshelppop()
	{
		window.open("iconshelppop.html", "", "top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=435,height=450,status=no,scrollbars=yes,titlebar=no;");
	}//iconshelppop
	
	var argGender = '<?=$varGender?>';
	var varPage3 = '<?=$pageNum?>'; // page number
	var pagePath1 = "interest-sent-results.php";	//page has to be called here //do change
	var argPlaceHolderId="idDisplayInterestRecieved"; //do change
		
</script>
<!-- Ajax Function Ends Here -->
<?php
	if ($varGetStatus==1) { echo '<script language="javascript">funAcceptedList();</script>'; }
	else if ($varGetStatus==3) { echo '<script language="javascript">funDeclinedList();</script>'; }
	else { echo '<script language="javascript">funPendingList();</script>'; }
?>

<?php
//UNSET OBJECT
unset($objMyMessage);
?>
</form>