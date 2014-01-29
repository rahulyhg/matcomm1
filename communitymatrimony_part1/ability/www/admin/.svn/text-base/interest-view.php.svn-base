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

if(($_POST['frmSalaamViewSubmit'] == "yes"))
{

	//VARIABLE DECLARATION
	$varUserName 				= $_REQUEST["username"];
	$varAction 					= $_REQUEST["action"];
	$varStartLimit 				= $_REQUEST["startLimit"];
	$varEndLimit				= $_REQUEST["endLimit"];
	$vartype					= $_REQUEST["type"];
	

	if($vartype==2)  {

		$varFields			= array('MatriId','Email');
		$varCondition		= " WHERE User_Name='".$varUserName."'";
		$varExecute			= $objSlave->select($varTable['MEMBERLOGININFO'],$varFields,$varCondition,0);
		$varSelectUserName	= mysql_fetch_assoc($varExecute);
		$varMatriId			= $varSelectUserName['MatriId'];

	} else { $varMatriId	= $varUserName; }

	$varNoOfResults			= $objSlave->numOfRecords($varTable['MEMBERLOGININFO'],'MatriId',$varCondition);
	
	if($varNoOfResults >0) {
		echo $varAction;
		echo '<script language="javascript">document.location.href="index.php?act=interest-view-log&MatriId='.$varMatriId.'&startLimit='.$varStartLimit.'&endLimit='.$varEndLimit.'&action='.$varAction.'";</script>';
	}
}
$objSlave->dbClose();
?>
<script language="javascript">
function funValidateSalaamView()
{
	var funFormName	= document.frmSalaamView;
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
	if (!(funFormName.action[0].checked==true || funFormName.action[1].checked==true))
	{
		alert("Please select Sent Salaam(s) / Received Salaam(s)");
		funFormName.action[0].focus();
		return false;
	}//if

	return true;
}//funValidatePayment
</script>

<table border="0" cellpadding="0" cellspacing="0" width="545">
	<tr><td height="15"></td></tr>
	<tr>
		<td valign="middle" class="heading" style="padding-left:15px;">View Member Interest Log</td>
	</tr>
	<?php if ($varRecordsNumber==0 && $_POST["frmSalaamViewSubmit"]=="yes") { ?>
	<tr><td height="10"></td></tr>
	<tr><td class="errorMsg" align="center">This Username is not available. Please check</td></tr>
	<tr><td height="10"></td></tr>
	<?php }//if?>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="545" align="left">
	<form method="post" name="frmSalaamView" target="_blank" onSubmit="return funValidateSalaamView();" style="padding:0px;margin:0px;">
	<input type="hidden" name="frmSalaamViewSubmit" value="yes">
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
							<td width="75%" colspan="3"><input name="startLimit" value="" type="text" size="10" class="inputtext">&nbsp;&nbsp;<font class="smalltxt"><b>End With</b></font>
							&nbsp;<input name="endLimit" value="" type="text" size="10" class="inputtext">
							</td>
						</tr>
						<tr><td class="mailbxstalbg" colspan="4"><IMG height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"></td></tr>
				
						<tr height="28" valign="middle">
							<td class="smalltxt" valign=middle align=left colspan="4">
							<input name="action" value="sentSalaams" type="radio"><font class="smalltxt">Sent Interest(s)</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="action" value="receivedSalaams" type="radio"><font class="smalltxt">Received Interest(s)</font>
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
