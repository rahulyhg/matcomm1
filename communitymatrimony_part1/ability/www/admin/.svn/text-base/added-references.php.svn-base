<?php
//FOR SEPRATE PROFILE VALIDATIONS
$act			= $_REQUEST['act'];
$varSepartePage = $_REQUEST["spage"];
$varPaidStatus	= $_REQUEST['paid'];
//Base Path //
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
// Include the files //
include_once($varRootBasePath."/conf/reference.inc");
include_once($varRootBasePath."/lib/clsReferMailer.php");
//OBJECT DECLARTION
$objCommon		= new Common;
$objCommon1	= new Common;
$objRefMailer	= new ReferenceMailer;
$objCommon->dbConnect('S', $varDbInfo['DATABASE']);
$objRefMailer->dbConnect('S', $varDbInfo['DATABASE']);
$objCommon1->dbConnect('M', $varDbInfo['DATABASE']);
$NoOfRecords	= $_REQUEST['NumberProfile']?$_REQUEST['NumberProfile']:20;
$NameType		= $_REQUEST['type'];
$UserId			= $_REQUEST['ID'];
$varStatus		= $_REQUEST['status'];
$varStartLimit	= $_REQUEST['startFrom']?$_REQUEST['startFrom']:0;
$varCurrentDate	= date('Y-m-d');
$varRejectCount=0;
$varAddCount=0;

if($_POST['frmAddedReferenceSubmit']=='yes')
{
	$varNoOfRecords = $_POST['numofrecds'];
	//echo 'Count=='.$varNoOfRecords;
	for($i=0;$i<$varNoOfRecords;$i++)
	{
		$action			= $_REQUEST['action'.$i];
		$matriId		= $_REQUEST['refId'.$i];
		$rejectComment	= $_REQUEST['rejectComment'.$i];

		$objCommon->clsPrimary		= array('RefId');
		$objCommon->clsPrimaryValue	= array($matriId);
		
		$objCommon->clsTable		= "refereedetails";
		$objCommon->clsFields 		= array('Referee_Comments');
		$RefreeDetails				= $objCommon->selectInfo();
		$objCommon->clsTable		= "addreference";
		$objCommon->clsFields 		= array('Referee_Name','MatriId','Member_Comments','Referee_Email','Member_Name','Reference_Type','Relationship');
		$addRefreeDetails			= $objCommon->selectInfo();
		//echo '<pre>'; print_r($addRefreeDetails); echo '</pre>';
		$varMatriId					= $addRefreeDetails['MatriId'];
		$varUsername				= $objCommon->getUsername($varMatriId);
		$varRefereeName				= $addRefreeDetails['Referee_Name'];
		$varRefereeEmail			= $addRefreeDetails['Referee_Email'];
		$varUserEmail				= $objCommon->getEmail($varMatriId);
		$varRefereeComments			= $RefreeDetails['Referee_Comments'];
		$varMemberComments			= $addRefreeDetails['Member_Comments'];
		$varMemberName				= $addRefreeDetails['Member_Name'];
		$varReferenceType			= $addRefreeDetails['Reference_Type'];
		$varRelationship			= $addRefreeDetails['Relationship'];
		$varRtln					= $relationshiparray[$varRelationship];
		//Reject reference with Error And SendingMail
		if( $action == "reject")
		{
			$objCommon1->clsTable		= "addreference";
			$objCommon1->clsPrimary		= array('RefId');
			$objCommon1->clsPrimaryValue	= array($matriId);
			$varRejectCount = $varRejectCount + 1;
			$objCommon1->clsFields 		= array('Validate_Status','Reference_Status','Reject_Reason');
			$objCommon1->clsFieldsValues	= array(2,2,$rejectComment);
			$objCommon1->updateInfo();
			if($varReferenceType==2) { 
				//echo $varReferenceType.'<br>'.$matriId.'<br>'.$varRefereeName.'<br>'.$varUsername.'<br>'.$rejectComment.'<br>'.$varUserEmail;
				$retValue1=$objRefMailer->referenceRejectedMail($matriId,$varRefereeName,$varUsername,$rejectComment,$varUserEmail);
			} if($varReferenceType==1) { 
				//echo $matriId.'<br>'.$varMemberName.'<br>'.$varRefereeName.'<br>'.$rejectComment.'<br>'.$varRefereeEmail;
				$retValue=$objRefMailer->referenceModifyMail($matriId,$varMemberName,$varRefereeName,$rejectComment,$varRefereeEmail,$varRtln);
			}
		}

		//Approve new reference 
		if( $action == "add")
		{
			$objCommon1->clsTable		= "addreference";
			$objCommon1->clsPrimary		= array('RefId');
			$objCommon1->clsPrimaryValue	= array($matriId);
			$varAddCount =$varAddCount+1;
			$objCommon1->clsFields 		= array('Validate_Status','Date_Accepted','Reference_Status');
			$objCommon1->clsFieldsValues	= array(1,$varCurrentDate,1);
			$objCommon1->updateInfo();

			$objCommon1->clsTable		= "memberinfo";
			$objCommon1->clsFields 		= array('Reference_Set_Status');
			$objCommon1->clsFieldsValues	= array(1);
			$objCommon1->clsPrimary		= array('MatriId');
			$objCommon1->clsPrimaryValue	= array($varMatriId);
			$objCommon1->updateInfo();

			if($varReferenceType==2) {
			$retValue3=$objRefMailer->referenceIntimationMail($varRefereeName,$varRefereeEmail,$varMemberName,$varRtln);
			}

			if($varReferenceType==1) { $retValue1=$objRefMailer->referenceAddedMail($varRefereeName,$varUsername,$varRefereeComments,$varUserEmail,$varRtln);
			$retValue2=$objRefMailer->referenceApprovedMail($varMemberName,$varRefereeName,$varRefereeEmail,$varRtln);
			}

			//Request Added Mailer
			$objCommon->clsTable		= "requestinforeceived";
			$objCommon->clsFields 		= array('SenderId');
			$objCommon->clsPrimary		= array('ReceiverId','RequestFor','RequestMet');
			$objCommon->clsPrimaryValue	= array($varMatriId,2,0);
			$objCommon->clsPrimarySymbol = array('=','=','=');
			$objCommon->clsPrimaryKey = array('AND','AND');
			$varReqSender				= $objCommon->multiSelectInfo();
			$varReqSenderCnt			= count($varReqSender);
			if($varReqSenderCnt>0) {
				$objCommon->clsTable		= "requestinforeceived";
				$objCommon->clsFields 	= array('RequestMet','RequestMetOn');
				$objCommon->clsFieldsValues 	= array(1,$varCurrentDate);
				$objCommon->clsPrimary		= array('ReceiverId');
				$objCommon->clsPrimaryValue	= array($varMatriId);
				$objCommon->updateInfo();
				$objCommon->clsTable		= "requestinfosent";
				$objCommon->updateInfo();
			}
			//echo '$varReqSenderCnt::'.$varReqSenderCnt;
			for($j=0;$j<$varReqSenderCnt;$j++)
			{
				$objCommon->clsTable		= "memberinfo";
				$objCommon->clsFields 		= array('Paid_Status');
				$objCommon->clsPrimary		= array('MatriId');
				$objCommon->clsPrimaryValue	= array($varReqSender[$j]['SenderId']);
				$varReqSenderDet			= $objCommon->selectInfo();
				$varPaidStatus					= $varReqSenderDet['Paid_Status'];
				$varReceiverEmailId			= $objCommon->getEmail($varReqSender[$j]['SenderId']);	
				$retValue3=$objRefMailer->referenceAddedAfterReqMail($varMatriId,$varReqSender[$j]['SenderId'],$varReceiverEmailId,$varPaidStatus);
			}
		}
	}
	echo "<div class='mediumtxt' width='500' align='center'>Rejected reference Count --> ".$varRejectCount."<br>Approved reference Count --> ".$varAddCount."<br>Reference has been approved successfully</div>";
}
//------------------------------------------------------------------------------------------------------------------------------------
//BEFORE POST
$objCommon->clsFields	= array('RefId','MatriId','Referee_Name','Familarity_Duration','Referee_Email','Referee_Phone','Referee_Comments','Referee_Date_Requested','Member_Comments','Reference_Type');

if($UserId=='')
{
	$varReferenceDetails	= $objCommon->multiSelectReferencesInfo($varStartLimit,$NoOfRecords,1,$varStatus);
} else {
	if($NameType==1)
		$varReferenceDetails	= $objCommon->multiSelectReferencesInfo($varStartLimit,$NoOfRecords,2,$varStatus,$UserId);
	if($NameType==2) {
		$varRefMatriId	= $objCommon->getUserId($UserId);
		$varReferenceDetails	= $objCommon->multiSelectReferencesInfo($varStartLimit,$NoOfRecords,2,$varStatus,$varRefMatriId);
	}
}

$varTotalRow	= count($varReferenceDetails);
$varTotalTable	= "";
$varTotalTable .= '<form name="frmAddedReference" method="post" onsubmit="return radio_button_checker('.$varTotalRow.')">';
$varTotalTable .= '<input type="hidden" name="frmAddedReferenceSubmit" value="yes"><input type="hidden" name="numofrecds" value="'.$varTotalRow.'">';
if($UserId=='')
{
	$varTotalTable .= '<tr ><td class="mediumtxt" align="right" style="padding-right:10px;"><font color="red"><b>';
	$varTotalTable .=($varStatus==0)?'New':'Modified';
	$varTotalTable .=' References Pending Count :'.$varTotalRow.'</b></font></td></tr>';
}

for($i=0;$i<$varTotalRow;$i++)
{

	$varReferenceType = ($varReferenceDetails[$i]['Reference_Type']==2)?'Add':'Invite';
	$varMemberName	   = $objCommon->getUsername($varReferenceDetails[$i]['MatriId']); 
	$varTotalTable .= '<input type="hidden" name="RefId" value="'.$varReferenceDetails[$i]['RefId'].'">';
	$varTotalTable .= '<tr><td style="padding-left:10px;"><table border="0" cellpadding="0" cellspacing="0" class="formborder" width="525" align="left"><tr><td valign="top"  class="adminformheader" colspan="4">'.$varReferenceType.' Reference</td></tr>';
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="textsmallbolda" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Username:</td><td valign="top" class="mediumtxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varMemberName;
	$varTotalTable .= '</td><td valign="top" class="textsmallbolda" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Referee Name:</td><td valign="top" class="mediumtxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varReferenceDetails[$i]['Referee_Name'] ? $varReferenceDetails[$i]['Referee_Name'] :  "-";
	$varTotalTable .= '</td></tr>';

	$varTotalTable .= '<tr bgcolor="#EEEBDA"><td width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="textsmallbolda" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Familarity Duration:</td><td valign="top" class="mediumtxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varReferenceDetails[$i]['Familarity_Duration'];
	$varTotalTable .= '</td><td valign="top" class="textsmallbolda" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Referee Telephone:</td><td valign="top" class="mediumtxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varReferenceDetails[$i]['Referee_Phone'] ? $varReferenceDetails[$i]['Referee_Phone'] :  "-";
	$varTotalTable .= '</td></tr>';

	$varTotalTable .= '<tr bgcolor="#EEEBDA"><td width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="textsmallbolda" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Referee Email:</td><td valign="top" class="mediumtxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varEmail = $varReferenceDetails[$i]['Referee_Email'];
	$varValidateEmail = $objCommon->emailValidation($varEmail);
	$varTotalTable .= '<b><font color="blue">'.$varEmail."</font></b>&nbsp;&nbsp;";
	$varTotalTable .= $varValidateEmail ? "<font color='green'><b>Valid</b></font>" : "<font color='red'><b>Invalid</b></font>";
	$varTotalTable .= '</td><td valign="top" class="textsmallbolda" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%"></td><td valign="top" class="mediumtxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';

	$varTotalTable .= '<tr bgcolor="#EEEBDA"><td width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	if($varReferenceDetails[$i]['Referee_Comments']!="") {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="textsmallbolda" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Referee Comments:</td><td valign="top" class="mediumtxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3"><div style="width:90% !important;width:350px;height:auto;height:50px;margin:5px;overflow:auto;">';
	$varTotalTable .= $varReferenceDetails[$i]['Referee_Comments']!=""? $varReferenceDetails[$i]['Referee_Comments'] : "-";
	$varTotalTable .= '</div></td></tr><tr bgcolor="#EEEBDA"><td width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}
	if($varReferenceDetails[$i]['Member_Comments']!="") {
	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="textsmallbolda" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Member Comments:</td><td valign="top" class="mediumtxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3"><div style="width:90% !important;width:350px;height:auto;height:50px;margin:5px;overflow:auto;">';
	$varTotalTable .= $varReferenceDetails[$i]['Member_Comments']!=""? $varReferenceDetails[$i]['Member_Comments'] : "-";
	$varTotalTable .= '</div></td></tr><tr bgcolor="#EEEBDA"><td width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';
	}

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="textsmallbolda" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Date Posted By Referee:</td><td valign="top" class="mediumtxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">';
	$varTotalTable .= $varReferenceDetails[$i]['Referee_Date_Requested']?date("d-M-Y",strtotime($varReferenceDetails[$i]['Referee_Date_Requested'])):"-";
	$varTotalTable .= '</td><td valign="top" class="textsmallbolda" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%"></td><td valign="top" class="mediumtxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#EEEBDA"><td width="10" valign="top" height="1" colspan="4"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="100%" height="1"></td></tr>';

	$varTotalTable .= '<tr bgcolor="#FFFFFF"><td valign="top" class="textsmallbolda" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Reject Comment:</td><td valign="top" class="mediumtxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="75%" colspan="3">';
	$varTotalTable .= '<textarea name="rejectComment'.$i.'"  rows=3 cols=30></textarea>';
	$varTotalTable .= '</div></td></tr>';

	$varTotalTable .= '<tr class="memonlsbg4"><td class=mediumtxt style="padding:5px 5px 5px 5px" colspan="3"><input name="refId'.$i.'" value="'.$varReferenceDetails[$i]['RefId'].'" type="hidden"><input name="action'.$i.'" value="add" type="radio">&nbsp;&nbsp;<font class="text"><b>Approve</b></font>&nbsp;&nbsp;';

	$varTotalTable .= '<input name="action'.$i.'" value="reject" type="radio"><font class="text"><b>Reject</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class="text"></td><td class=grsearchtxt style="padding:5px 5px 5px 5px" align="right"></tr>';

	$varTotalTable .= '</table></td></tr><tr><td height="10"></td></tr>';
}
$varTotalTable .= '<tr><td height="10"></td></tr><tr><td><center><input type="submit" class="button" value="submit"></center></td></tr><tr><td height="10"></td></tr></form>';
?>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545">
	<tr><td height="10"></td></tr>
	<tr>
		<td><font class="heading" style="padding-left:10px;">Approve References</font>
		</td>
	</tr>
</table>

<br />

<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="545">
<?php if($varTotalRow==0 && $UserId!='') { ?>
<tr>
	<td class="smalltxt" style="padding-left:10px;">Reference for this member doesnot exist or not in queue for approval.</td> 
</tr>
<?php } elseif($varTotalRow==0 && $UserId=='') { ?>
<tr>
	<td class="smalltxt" style="padding-left:10px;">Sorry! No New Records Found.</td> 
</tr>
<?php } else { ?>
<?= $varTotalTable; ?>
<?php } ?>
</table>
<script language="JavaScript">
<!--
	function radio_button_checker(rc)
	{
		var rcc=rc;
		for(i=0;i<rcc;i++)
		{
			var temp1="document.frmAddedReference.action"+i+"[0]";
			var temp2="document.frmAddedReference.action"+i+"[1]";
			var temp3="document.frmAddedReference.rejectComment"+i;
			if ((eval(temp2).checked)&&(eval(temp3).value == "") )
			{
			alert("Please enter the reason for rejecting Profile "+i)
			eval(temp3).focus()
			return (false);
			}
		}
		return (true);
	}
//-->
</script>