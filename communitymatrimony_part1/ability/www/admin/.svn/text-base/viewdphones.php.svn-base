<?php
#=============================================================================================================
# Author 		: Senthilnathan
# Start Date	: 2009-01-22
# End Date		: 2009-01-22
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================
//DOCUMENT ROOT
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objDB		= new DB();

//DB CONNECTION
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIALBE DECLERATION
$varMatriId		= $_GET['id'];
$varFields		= array('Name','Nick_Name','Date_Viewed','a.MatriId');
$varCondition	= "WHERE a.Opposite_MatriId='".$varMatriId."' AND a.MatriId=b.MatriId ORDER BY a.Date_Viewed ASC";
$varTablName	= $varTable['PHONEVIEWLIST'].' as a,'.$varTable['MEMBERINFO'].' as b';
$varSelectUserRes	= $objDB->select($varTablName, $varFields, $varCondition, 0);
$varContent			= '<table border="0" cellpadding="2" bgcolor="#FFFFFF" cellspacing="2" align="left" width="390" style="padding:5px"><tr><td colspan="4" bgcolor="#EEEEEE" class="heading">Viewed Phone Info</td></tr>';
$varContent		   .= '<tr class="boldtxt mediumtxt"><td bgcolor="#EEEEEE" >S.No</td><td bgcolor="#EEEEEE" >Name</td><td bgcolor="#EEEEEE" >Matri Id</td><td bgcolor="#EEEEEE">Date viewed</td></tr>';
$i=1;
if(mysql_num_rows($varSelectUserRes)>0){
	while($row = mysql_fetch_assoc($varSelectUserRes)){
		$varContent	.= '<tr class="mediumtxt"><td align="left" bgcolor="#EEEEEE" >'.$i.'</td><td bgcolor="#EEEEEE" >'.($row['Nick_Name']!=''?$row['Nick_Name']:$row['Name']).'</td><td bgcolor="#EEEEEE"><a href="index.php?act=view-profile&matrimonyId='.$row['MatriId'].'" target="_blank">'.$row['MatriId'].'</a></td><td bgcolor="#EEEEEE" >'.date('d-M-y H:i:s', strtotime($row['Date_Viewed'])).'</td></tr>';
		$i++;
	}
}else{
	$varContent	.= '<tr rowspan="7" class="boldtxt mediumtxt"><td colspan="3">&nbsp;</td></tr><tr class="boldtxt mediumtxt"><td colspan="3">&nbsp;</td></tr><tr class="boldtxt mediumtxt"><td colspan="3">&nbsp;</td></tr><tr align="center" class="boldtxt mediumtxt errortxt"><td colspan="3">Viewed phone list not availble.</td></tr><tr class="boldtxt mediumtxt"><td colspan="3">&nbsp;</td></tr><tr class="boldtxt mediumtxt"><td colspan="3">&nbsp;</td></tr><tr class="boldtxt mediumtxt"><td colspan="3">&nbsp;</td></tr>';
}

$varContent	.= '</td></tr></table>';

//Unset Object
$objDB->dbClose();
unset($objDB);
?>
<html>
<head>
<title>Viewed phone list</title>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/global-style.css">
<style>
	td{padding-left:5px;}
</style>
</head>
<body>
<?=$varContent?>
</body>
</html>