<?php

//FILE INCLUDES
include_once $varRootBasePath."/conf/config.inc";
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/productvars.inc');
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath.'/lib/clsMailManager.php');

//OBJECT DECLARATION
$objSlave	= new MailManager;

//interest status
$arrInterestStatus	= array(0=>'Pending',1=>'Accepted',3=>'Declined',4=>'Pending-Delete',5=>'Accepted-Delete',7=>'Declined-Delete');

$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

$varMatriId		= $_REQUEST['MatriId'];
$varStartLimit	= $_REQUEST['startLimit'];
$varEndLimit	= $_REQUEST['endLimit'];
$varAction		= $_REQUEST['action'];
$varCondition	= " WHERE MatriId='".$varMatriId."'";

if($varStartLimit!='' && $varEndLimit!='') { $varCondition	= $varCondition." LIMIT ".$varStartLimit.",".$varEndLimit; }


if($varAction=='receivedSalaams') {
	$varTableName			= $varTable['INTERESTRECEIVEDINFO']; 
	$varFields				= array('MatriId','Opposite_MatriId', 'Date_Received','Status');
	$varDisplayErrorMsg		= 'Sorry, no received interests for the selected profile.';
	$varDisplayHeading		= 'Express Interests Received';
}

if($varAction=='sentSalaams') {
	$varTableName			= $varTable['INTERESTSENTINFO']; 
	$varFields				= array('MatriId','Opposite_MatriId', 'Date_Sent','Status');
	$varDisplayErrorMsg		= 'Sorry, no sent interests for the selected profile.';
	$varDisplayHeading		= 'Express Interests Sent';
}

$varMessagesResult	= $objSlave->select($varTableName,$varFields,$varCondition,1);
$varMessagesCount	= count($varMessagesResult);

?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="542">
	<tr>
		<td valign="top" class="heading" style="padding-left:10px;padding-top:10px;"><?=$varDisplayHeading;?></td>
	</tr>
	<tr><td height="10"></td></tr>
	<tr><td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="3" align="center"   class="formborder" width="523">
					<tr class="adminformheader">
						<td width="4%"></td>
						<? if($varAction=='receivedSalaams') { ?>
						<td class="smalltxt" width="30%" align="left">&nbsp;&nbsp;<b>From</td>
						<td class="smalltxt" width="30%" align="left"><b>Date Received</b></td>
						<? } if($varAction=='sentSalaams') { ?>
						<td class="smalltxt" width="30%" align="left">&nbsp;&nbsp;<b>To</td>
						<td class="smalltxt" width="30%" align="left"><b>Date Sent</b></td>
						<? } ?>	
						<td class="smalltxt" width="30%" align="left"><b>Status</b></td>
					</tr>
					<?php
					 if($varMessagesCount==0)
						echo '<tr><td class="smalltxt boldtxt" height="40" valign="middle" align="center" colspan="4">'.$varDisplayErrorMsg.'</td></tr>';
					else
					{
						 for($i=0;$i<$varMessagesCount;$i++)
						{ 
							$funLink = '<a href="../admin/index.php?act=view-profile&matrimonyId='.$varMessagesResult[$i]['Opposite_MatriId'].'"class="navlinktxt1admin" target="_blank">';
							$varUserName = $objSlave->getUsername($varMessagesResult[$i]['Opposite_MatriId']);
							if ($varUserName=="") { $funUsername	= $objSlave->getDeleteUsername($varMessagesResult[$i]['Opposite_MatriId']); }
							else {$funUsername	= $varUserName; }//else
							if($varAction=='receivedSalaams') { 
								$varDateDisplay = $varMessagesResult[$i]['Date_Received'];
								$varStatus = $arrInterestStatus[$varMessagesResult[$i]['Status']]; }
							if($varAction=='sentSalaams') { 
								$varDateDisplay = $varMessagesResult[$i]['Date_Sent']; 
								$varSentStatus = $varMessagesResult[$i]['Status'];
								/*if($varSentStatus==5) 
									$varStatus = $varSalaamSentStatus[$varMessagesResult[$i]['Status']];
								else
									$varStatus = $varSalaamReceivedStatus[$varMessagesResult[$i]['Status']]; */
								$varStatus = $arrInterestStatus[$varMessagesResult[$i]['Status']];
							}
							echo '<tr><td align="left"></td><td class="smalltxt">'.$funLink.$funUsername.'</a></td><td class="smalltxt" align="left">'.date("d M Y", strtotime($varDateDisplay)).'</td><td class="smalltxt" align="left"><b>'.$varStatus.'</b></td></tr>';
						}
					}
				?>
				</table>
			</td>
		</tr>
		<tr><td height="10"></td></tr>
	</table>
    </td>
  </tr>
  <tr><td height="10" colspan="2"></td></tr>
</table>
