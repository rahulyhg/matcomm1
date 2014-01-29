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
 $check      =    $_REQUEST["mem"];
$objDBase->dbConnect('S',$varDbInfo['DATABASE']);

if($check=='vmem'){
	$varCondition		= " WHERE matriid=".$objDBase->doEscapeString($varMatriId,$objDBase);
	$varFields			= array('Opposite_MatriId', 'Date_Viewed');
	$varExecute	        = $objDBase->select($varDbInfo['DATABASE'].'.'.$varTable['PHONEVIEWLIST'],$varFields,$varCondition,0);
	$varNumOfRecords	= mysql_num_rows($varExecute);	
	$varheading         = "Who Viewed My Phone Number ";
	$varNoValues        = "No Users Has Viewed My Phone Number";
	

}else if($check=='bmem') {
	$varCondition		= " WHERE Opposite_MatriId=".$objDBase->doEscapeString($varMatriId,$objDBase);;
	$varFields			= array('MatriId', 'Date_Viewed');
	$varExecute	        = $objDBase->select($varDbInfo['DATABASE'].'.'.$varTable['PHONEVIEWLIST'],$varFields,$varCondition,0);
	$varNumOfRecords	= mysql_num_rows($varExecute);
	$varheading         = "Phone Number Viewed By Me";
	$varNoValues        = "No Phone Number Is Viewed MY Me";
	
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

<table border="0" cellpadding="0" cellspacing="0" align="center" valign="middle" width="400">
	<tr>
		<td height="20px"></td>
	</tr>
	<tr>
		<td class="smalltxt bold" align="center" colspan="2">MatriId: <font class="smalltxt"> <?php echo $varMatriId;?></font>	</td>
	</tr>
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td class="heading" align="left" colspan="2"><?php echo $varheading;?></td>
	</tr>
	<tr>
		<td height="10px"></td>
	</tr>
<?php if($varNumOfRecords>0){?>
<tr>
	<td>
		<table border="0" cellspacing="0" cellpadding="3" align="center" width="100%" class="formborder">
			<tr class="adminformheader" bgcolor="#EFEFEF">
				<td class="smalltxt bold" align="center">Viewed ID</td>
				<td class="smalltxt bold" align="center">Date & Time</td>				
			</tr>
			<?php while ($varPhoneViewList = mysql_fetch_array($varExecute)){?>	
			<tr >	
				<td class="smalltxt" align="center"><?php echo $varPhoneViewList[0];?></td>
				<td class="smalltxt" align="center"><?php echo $varPhoneViewList[1]?></td>				
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