<?php

//BASE PATH
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once $varRootBasePath."/conf/config.inc";
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objSlave	= new DB;

$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

if(($_POST['frmMessageViewSubmit'] == "yes")) {

	//VARIABLE DECLARATION
	$varUserName 	= $_REQUEST["username"];
	$varAction 		= $_REQUEST["action"];
	$varStartLimit 	= $_REQUEST["startLimit"];
	$varEndLimit	= $_REQUEST["endLimit"];
	$vartype		= $_REQUEST["type"];
	
	if($vartype==2)  {

		$varFields			= array('MatriId','Email');
		$varCondition		= " WHERE User_Name='".$varUserName."'";
		$varExecute			= $objSlave->select($varTable['MEMBERLOGININFO'],$varFields,$varCondition,0);
		$varSelectUserName	= mysql_fetch_assoc($varExecute);
		$varMatriId			= $varSelectUserName['MatriId'];

	} else { $varMatriId	= $varUserName; }

	$varNoOfResults	= $objSlave->numOfRecords($varTable['MEMBERLOGININFO'],'MatriId',$varCondition);


	if($varNoOfResults >0) {

		echo '<script language="javascript">document.location.href="index.php?act=message-view-log&MatriId='.$varMatriId.'&startLimit='.$varStartLimit.'&endLimit='.$varEndLimit.'&action='.$varAction.'";</script>';
	}
}
$objSlave->dbClose();
?>
<script language="javascript">
function funValidateMessageView()
{
	var funFormName	= document.frmMessageView;
	if (funFormName.username.value=="")
	{
		alert("please enter Username / Matrimony Id");
		funFormName.username.focus();
		return false;
	}//if
	if (!(funFormName.type[0].checked==true || funFormName.type[1].checked==true))
	{
		alert("Please select Username / Matrimony Id");
		funFormName.type[0].focus();
		return false;
	}//if
	if (!(funFormName.action[0].checked==true || funFormName.action[1].checked==true || funFormName.action[2].checked==true || funFormName.action[3].checked==true))
	{
		alert("Please select Sent Messages/Received Messages/View Received List/View Sent List");
		funFormName.action[0].focus();
		return false;
	}//if

	return true;
}//funValidatePayment
</script>

<table border="0" cellpadding="0" cellspacing="0" width="542">
	<tr><td height="15"></td></tr>
	<tr>
		<td valign="middle" class="heading" style="padding-left:15px;">View Member Message Log</td>
	</tr>
	<?php if ($varNoOfResults==0 && $_POST["frmMessageViewSubmit"]=="yes") { ?>
	<tr><td height="10"></td></tr>
	<tr><td class="errorMsg" align="center">This Username is not available. Please check</td></tr>
	<tr><td height="10"></td></tr>
	<?php }//if?>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="542" align="left">
	<form method="post" name="frmMessageView" target="_blank" onSubmit="return funValidateMessageView();">
	<input type="hidden" name="frmMessageViewSubmit" value="yes">
	<tr>
		<td>
			<table border="0" cellpadding="6" cellspacing="6" class="serboxtitle2" width="100%">
				<tr><td>
					<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" width="100%">
						<!--form starts here-->
						<tr height="28" valign="middle">
							<td class="smalltxt" valign=middle style="padding-left:5px;" align=left width="25%"><b>MatrimonyId/UserName</b></td>
							<td width="75%" colspan="3" class="smalltxt">&nbsp;<input type="text" name="username" size="20" class="inputtext">&nbsp;<input type="radio" name="type" value="1">&nbsp;MatrimonyId&nbsp;&nbsp;<input type="radio" name="type" value="2">&nbsp;UserName</td>
						</tr>
						<tr><td class="mailbxstalbg" colspan="4"><IMG height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"></td></tr>
				
						<tr height="28" valign="middle">
							<td class="smalltxt" width="25%" valign=middle style="padding-left:5px;" align=left><b>Start From</b></td>
							<td width="75%" colspan="3">&nbsp;<input name="startLimit" value="" type="text" size="10" class="inputtext">&nbsp;&nbsp;<font class="smalltxt"><b>End With</b></font>
							&nbsp;<input name="endLimit" value="" type="text" size="10" class="inputtext">
							</td>
						</tr>
						<tr><td class="mailbxstalbg" colspan="4"><IMG height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"></td></tr>
				
						<tr height="28" valign="middle">
							<td class="smalltxt" valign=middle align=left colspan="4">
							<input name="action" value="sentMessages" type="radio"><font class="smalltxt">Sent Messages</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="action" value="receivedMessages" type="radio"><font class="smalltxt">Received Messages</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="action" value="viewReceivedList" type="radio"><font class="smalltxt">View Received List</font>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="action" value="viewSentList" type="radio"><font class="smalltxt">View Sent List</font>
							</td>
						</tr>
						<tr><td class="mailbxstalbg" colspan="4"><IMG height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"></td></tr>	<!--form ends here-->
				</table>				
			   </td></tr>
			</table>
		</td>
	</tr>
	<tr><td height="11"></td></tr>
	<tr>
		<td align="center"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="28" height="5"><input type='submit' class="button" value="Submit" align="top" ><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="18" height="5"><input type='reset' class="button" value="Reset" align="top" onClick="document.frmMessageView.reset();return false;" ></td>
	</tr>
	<tr>
		<td class="lastnull"><img src="<?=$confValues['IMGSURL']?>/trans.gif"  height="12"></td>
	</tr>
	</form>
</table>
