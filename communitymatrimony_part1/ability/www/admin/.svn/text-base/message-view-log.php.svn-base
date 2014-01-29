<?php

//FILE INCLUDES
include_once $varRootBasePath."/conf/config.inc";
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/productvars.inc');
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath.'/lib/clsMailManager.php');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');

//OBJECT DECLARATION
$objSlave		= new MailManager;
$objMemcacheDB	= new MemcacheDB;

//message array
$arrMessageStatus = array(0=>'Pending',1=>'Read',2=>'Replied',3=>'Declined',4=>'Pending-Delete',5=>'Read-Delete',6=>'Replied-Delete',7=>'Declined-Delete');

$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objMemcacheDB->dbConnect('S',$varDbInfo['DATABASE']);

$varMatriId		= $_REQUEST['MatriId'];
$varStartLimit	= $_REQUEST['startLimit'];
$varEndLimit	= $_REQUEST['endLimit'];
$varAction		= $_REQUEST['action'];
$varCondition	= " WHERE MatriId='".$varMatriId."'";

if($varStartLimit!='' && $varEndLimit!='') { $varCondition	= $varCondition." LIMIT ".$varStartLimit.",".$varEndLimit; }

if($varAction=='receivedMessages') {

	$varTableName		= $varTable['MAILRECEIVEDINFO']; 
	$varFields			= array('MatriId','Opposite_MatriId', 'Date_Received','Status','Mail_Message');	
	$varDisplayErrorMsg	= 'Sorry, no received messages for the selected profile.';
	$varDisplayHeading	= 'Messages Received';
}

if($varAction=='sentMessages') {

	$varTableName		= $varTable['MAILSENTINFO']; 
	$varFields			= array('MatriId','Opposite_MatriId', 'Date_Sent','Status','Mail_Message','Date_Read');	
	$varDisplayErrorMsg	= 'Sorry, no sent messages for the selected profile.';
	$varDisplayHeading	= 'Messages Sent';
}

if($varAction=='viewSentList') {
	$varTableName		= $varTable['MAILSENTINFO']; 
	$varFields			= array('MatriId','Opposite_MatriId', 'Date_Sent');	
	$varDisplayErrorMsg	= 'Sorry, no sent Messages for the selected profile.';
	$varDisplayHeading	= 'View Sent List';
}

if($varAction=='viewReceivedList') {
	$varTableName		= $varTable['MAILRECEIVEDINFO']; 
	$varFields			= array('MatriId','Opposite_MatriId', 'Date_Received');	
	$varDisplayErrorMsg	= 'Sorry, no received messages for the selected profile.';
	$varDisplayHeading	= 'View Received List';
}

$varMessagesResult	= $objSlave->select($varTableName,$varFields,$varCondition,1);
$varMessagesCount	= count($varMessagesResult);
	


?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="542">
	<tr>
		<td valign="top" class="heading" style="padding-left:10px;padding-top:10px;"><?php echo $varDisplayHeading;?></td>
	</tr>
	<tr><td height="10"></td></tr>
	<tr><td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="3" align="center" width="523"  class="formborder">
					<tr class="adminformheader">
						<td width="4%"></td>
						<? if($varAction=='receivedMessages') { ?>
						<td class="smalltxt" width="8%" align="left"><b>S.No</td>
						<td class="smalltxt" width="15%" align="left"><b>From</td>
						<td class="smalltxt" width="28%" align="left"><b>Date Received</b></td>
						<td class="smalltxt" width="15%" align="left"><b>Status</b></td>
						<td class="smalltxt" width="58%" align="left" colspan="2"><b>Message</b></td>
						<? } if($varAction=='sentMessages') { ?>
						<td class="smalltxt" width="8%" align="left"><b>S.No</td>
						<td class="smalltxt" width="15%" align="left"><b>To</td>
						<td class="smalltxt" width="28%" align="left"><b>Date Sent</b></td>
						<td class="smalltxt" width="15%" align="left"><b>Status</b></td>
						<td class="smalltxt" width="32%" align="left"><b>Message</b></td>
						<td class="smalltxt" width="18%" align="left"><b>DateRead</b></td>
						<? } if($varAction=='viewReceivedList') { ?>
						<td class="smalltxt" width="8%" align="left"><b>S.No</td>
						<td class="smalltxt" width="15%" align="left"><b>From</td>
						<td class="smalltxt" width="28%" align="left"><b>Date Received</b></td>
						<td class="smalltxt" width="27%" align="left"><b>Age</b></td>
						<td class="smalltxt" width="23%" align="left" colspan="2"><b>Caste</b></td>
						<? } if($varAction=='viewSentList') { ?>
						<td class="smalltxt" width="8%" align="left"><b>S.No</td>
						<td class="smalltxt" width="15%" align="left"><b>To</td>
						<td class="smalltxt" width="25%" align="left"><b>Date Sent</b></td>
						<td class="smalltxt" width="27%" align="left"><b>Age</b></td>
						<td class="smalltxt" width="23%" align="left" colspan="2"><b>Caste</b></td>
						<? } ?>	
					</tr>
					<?php
					 if($varMessagesCount==0)
						echo '<tr><td class="smalltxt" height="40" valign="middle" align="center" colspan="6">'.$varDisplayErrorMsg.'</td></tr>';
					else
					{
						 for($i=0;$i<$varMessagesCount;$i++)
						{ 
							
							$funLink = '<a href="../admin/index.php?act=view-profile&matrimonyId='.$varMessagesResult[$i]['Opposite_MatriId'].'"class="navlinktxt1admin" target="_blank">';
							$varUserName = $objSlave->getUsername($varMessagesResult[$i]['Opposite_MatriId']);
							if ($varUserName=="") { $funUsername	= $objSlave->getDeleteUsername($varMessagesResult[$i]['Opposite_MatriId']); }
							else {$funUsername	= $varUserName; }//else
							if($varAction=='receivedMessages' || $varAction=='viewReceivedList') { 
								$varDateReceived = $varMessagesResult[$i]['Date_Received'];
								$varDateDisplay = ($varDateReceived =="0000-00-00 00:00:00")?"":date("d M Y H:i", strtotime($varDateReceived));
								//$varStatus = $varMessageReceivedStatus[$varMessagesResult[$i]['Status']];
								$varStatus = $arrMessageStatus[$varMessagesResult[$i]['Status']];
							}
							if($varAction=='sentMessages' || $varAction=='viewSentList') { 
								$varDateSent = $varMessagesResult[$i]['Date_Sent']; 
								$varDateDisplay = ($varDateSent =="0000-00-00 00:00:00")?"":date("d M Y H:i", strtotime($varDateSent));
								$varSentStatus = $varMessagesResult[$i]['Status'];
								/*if($varSentStatus==5) {
									$varStatus = $varMessageSentStatus[$varMessagesResult[$i]['Status']];
								} else {
									$varStatus = $varMessageReceivedStatus[$varMessagesResult[$i]['Status']]; 
								}*/
								$varStatus = $arrMessageStatus[$varMessagesResult[$i]['Status']];
							}
							if($varAction=='receivedMessages' || $varAction=='sentMessages') {
								$varMessageDet = $varMessagesResult[$i]['Mail_Message'];
								$varCovertedMessage = $varMessageDet; 
							}
							echo '<tr><td align="center" width="1%"></td><td align="center" width="3%" class="smalltxt" valign="top">'.($i+1).'</td><td class="smalltxt" width="15%" valign="top">'.$funLink.$funUsername.'</a></td><td class="smalltxt" align="left" width="18%" valign="top">'.$varDateDisplay.'</td>';
							if($varAction=='receivedMessages') { 
								echo '<td class="smalltxt" align="left" valign="top"><b>'.$varStatus.'</b></td><td  align="left" colspan="2" class="smalltxt" valign="top">'.$varCovertedMessage.'</td></tr>';
							}
							if($varAction=='sentMessages') { 
								$varDateRead = $varMessagesResult[$i]['Date_Read'];
								$varReadDate = ($varDateRead =="0000-00-00 00:00:00")?"":date("d M Y H:i", strtotime($varDateRead));
								echo '<td class="smalltxt" align="left" valign="top"><b>'.$varStatus.'</b></td><td  align="left" class="smalltxt" valign="top">'.$varCovertedMessage.'</td><td class="smalltxt" align="left" valign="top">'.$varReadDate.'</td></tr>';
							}

							if($varAction=='viewSentList' || $varAction=='viewReceivedList') { 
								//SETING MEMCACHE KEY
								$varOwnProfileMCKey= 'ProfileInfo_'.$varMessagesResult[$i]['Opposite_MatriId'];

								$varFields		= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');	
								$varCondition	= " WHERE MatriId='".$varMessagesResult[$i]['Opposite_MatriId']."'";
								$varProfDetails	= $objMemcacheDB->select($varTable['MEMBERINFO'],$varFields,$varCondition,0);
								if(array_key_exists($varProfDetails['CommunityId'],$arrCasteDivisionList))
								{  $varSubCaste =$arrCasteDivisionList[$varProfDetails['CommunityId']]; }
								else { $varSubCaste = $varProfDetails['SubcasteId']!="" ? $varProfDetails['SubcasteId']: "-"; }
								echo '<td class="smalltxt" align="left" valign="top">'.$varProfDetails['Age'].'</td><td class="smalltxt" align="left" colspan="2" valign="top">'.$varSubCaste.'</td></tr>';
							}

						}
					}
				?>
		</table>
		<tr><td height="10"></td></tr>
	</table>
    </td>
  </tr>
  <tr><td height="10" colspan="2"></td></tr>
</table>
<script language="javascript">
function funMessageShow(argMsgId)
{
	var funUrl = "message-popup.php?msg="+argMsgId;
	window.open(funUrl,'Message','toolbar=no,scrollbars=yes,resizable=yes,width=500,height=200');
}//funMessageShow

</script>