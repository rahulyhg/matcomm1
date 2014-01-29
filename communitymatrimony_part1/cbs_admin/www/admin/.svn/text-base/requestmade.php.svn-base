<?php 
#=============================================================================================================
# Author 		: S.Naresh
# Start Date	: 2010-10-21
# End Date		: 2010-10-21
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePathh = '/home/product/community';

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objDBase	= new DB;

  $varMatriId =    $_REQUEST["MatriId"];
  $check      =    $_REQUEST["rm"]; 
  $pph        =    $_REQUEST["pph"];

$objDBase->dbConnect('S',$varDbInfo['DATABASE']);

if($check=='rs'){
	if($pph=='p'){
	$varCondition		=  "WHERE SenderId=".$objDBase->doEscapeString($varMatriId,$objDBase)." and requestfor='1'";
	$varheading         =  "Photo Requests - Sent";
	$varNoValues        =  "No List Of Photo Request Sent By User";
	}else if($pph=='ph'){
	$varCondition		=  "WHERE SenderId=".$objDBase->doEscapeString($varMatriId,$objDBase)." and requestfor='3'";
	$varheading         =  "Phone Number Requests - Sent";
	$varNoValues        =  "No List Of Phone Number Request Sent By User";
	}else if($pph=='h'){
	$varCondition		=  "WHERE SenderId=".$objDBase->doEscapeString($varMatriId,$objDBase)." and requestfor='5'";
	$varheading         =  "Horoscope Requests - Sent";
	$varNoValues         =  "No List Of Horoscope Request Sent By User";
	}
	$varFields			= array('SenderId','ReceiverId','RequestDate','RequestMetOn');
	$varExecute	        = $objDBase->select($varDbInfo['DATABASE'].'.'.$varTable['REQUESTINFOSENT'],$varFields,$varCondition,0);
	 $varNumOfRecords	= mysql_num_rows($varExecute);
}else if($check=='rr') {
	if($pph=='p'){
	$varCondition		=  "WHERE ReceiverId=".$objDBase->doEscapeString($varMatriId,$objDBase)." and requestfor='1'";
	$varheading         =  "Photo Requests - Received";
	$varNoValues         =  "No List Of Photo Request Received To User";
	}else if($pph=='ph'){
	$varCondition		= " WHERE ReceiverId=".$objDBase->doEscapeString($varMatriId,$objDBase)." and requestfor='3'";
	$varheading         =  "Phone Number Requests - Received";
	$varNoValues         =  "No List Of Phone Number Request Received To User";
	}else if($pph=='h'){
	$varCondition		= " WHERE ReceiverId=".$objDBase->doEscapeString($varMatriId,$objDBase)." and requestfor='5'";
	$varheading         =  "Horoscope Requests - Received";
	$varNoValues         =  "No List Of Phone Number Request Received To User";
	}
	$varFields			= array('SenderId','ReceiverId','RequestDate','RequestMetOn');
	$varExecute	        = $objDBase->select($varDbInfo['DATABASE'].'.'.$varTable['REQUESTINFORECEIVED'],$varFields,$varCondition,0);
	 $varNumOfRecords	= mysql_num_rows($varExecute);	
}
$objDBase->dbClose();
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
</html>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="middle" width="600" class="">
	<tr>
		<td height="20px"></td>
	</tr>
	<tr>
		<td class="smalltxt bold" align="center" colspan="4">MatriId: <font class="smalltxt"> <?php echo $varMatriId;?></font>	</td>
	</tr>
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td class="heading" align="left" colspan="4"><?php echo $varheading;?></td>
	</tr>
	<tr>
		<td height="10px"></td>
	</tr>
<?php if($varNumOfRecords>0){?>
<tr>
	<td>
		<table border="0" cellspacing="0" cellpadding="3" align="center" width="100%" class="formborder">
			<tr class="adminformheader" bgcolor="#EFEFEF">
				<td class="smalltxt bold" align="center">Sender ID</td>
				<td class="smalltxt bold" align="center">Receiver ID</td>
				<td class="smalltxt bold" align="center">Request Date</td>
				<td class="smalltxt bold" align="center">Request Met On</td>
			</tr>
			<?php while ($varPhoneViewList =mysql_fetch_assoc($varExecute)){?>	
			<tr >	
				<td class="smalltxt" align="center"><?php echo $varPhoneViewList['SenderId'];?></td>
				<td class="smalltxt" align="center"><?php echo $varPhoneViewList['ReceiverId'];?></td>
				<td class="smalltxt" align="center"><?php echo $varPhoneViewList['RequestDate'];?></td>
				<td class="smalltxt" align="center"><?php echo $varPhoneViewList['RequestMetOn'];?></td>
			</tr>
			<?php }?>
		</table>
	</td>
</tr>
<?php } else {?>
<tr>
	<td colspan="4" align="center">
	<table width="100%"><tr height="25px"><td align="center" colspan="4" bgcolor="#EFEFEF">
	<font color="#ff0000"><?php echo $varNoValues;?></font></td></tr></table></td>
</tr>
<?php }?>
<tr>
	<td height="10px"></td>
</tr>
<tr><td align="center" colspan="4" style="padding-right:10px" ><input type="button" value="Close Window" onClick="window.close()" class="button"></td></tr>
</table>