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
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objDB		= new DB();

//DB CONNECTION
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIALBE DECLERATION
$varMatriId		= $_GET['id'];
//get total no of records (including inactive and deleted members)
$varTotCondition= "WHERE Opposite_MatriId=".$objDB->doEscapeString($varMatriId,$objDB); 
$varTotalRecords= $objDB->numOfRecords($varTable['PHONEVIEWLIST'], 'Opposite_MatriId', $varTotCondition);

$varFields		= array('Name','Nick_Name','Date_Viewed','a.MatriId');
$varCondition	= "WHERE a.Opposite_MatriId=".$objDB->doEscapeString($varMatriId,$objDB)." AND a.MatriId=b.MatriId ORDER BY a.Date_Viewed ASC";
$varTablName	= $varTable['PHONEVIEWLIST'].' as a,'.$varTable['MEMBERINFO'].' as b';
$varSelectUserRes= $objDB->select($varTablName, $varFields, $varCondition, 0);
$varTotCombineRec=mysql_num_rows($varSelectUserRes);
$varContent			= '<table border="0" cellpadding="2" bgcolor="#FFFFFF" cellspacing="2" align="left" width="390" style="padding:5px"><tr><td colspan="4" bgcolor="#EEEEEE" class="heading">Viewed Phone Info</td></tr>';
$varContent		   .= '<tr class="boldtxt mediumtxt"><td bgcolor="#EEEEEE" >S.No</td><td bgcolor="#EEEEEE" >Name</td><td bgcolor="#EEEEEE" >Matri Id</td><td bgcolor="#EEEEEE">Date viewed</td></tr>';
$i=1;
if($varTotCombineRec>0){
	while($row = mysql_fetch_assoc($varSelectUserRes)){
		$arrLiveUser[]=$row['MatriId']; 
		$varContent	.= '<tr class="mediumtxt"><td align="left" bgcolor="#EEEEEE" >'.$i.'</td><td bgcolor="#EEEEEE" >'.($row['Nick_Name']!=''?$row['Nick_Name']:$row['Name']).'</td><td bgcolor="#EEEEEE"><a href="index.php?act=view-profile1&actstatus=yes&matrimonyId='.$row['MatriId'].'" target="_blank">'.$row['MatriId'].'</a></td><td bgcolor="#EEEEEE" >'.date('d-M-y H:i:s', strtotime($row['Date_Viewed'])).'</td></tr>';
		$i++;
	}
	if($varTotCombineRec<$varTotalRecords) {
		$varFields				= array('Date_Viewed','MatriId');
		$varCondition			= "WHERE Opposite_MatriId='".$varMatriId."'";
		$varSelectDeletedUserRes= $objDB->select($varTable['PHONEVIEWLIST'], $varFields, $varCondition, 0);
		while($rowAll = mysql_fetch_assoc($varSelectDeletedUserRes)) {
			if(!in_array($rowAll['MatriId'],$arrLiveUser)){
				$varContent	.= '<tr class="mediumtxt"><td align="left" bgcolor="#EEEEEE" >'.$i.'</td><td bgcolor="#EEEEEE" ><font color="#FF0000">Deleted</font></td><td bgcolor="#EEEEEE">'.$rowAll['MatriId'].'</td><td bgcolor="#EEEEEE" >'.date('d-M-y H:i:s', strtotime($rowAll['Date_Viewed'])).'</td></tr>';
				$i++;
			}
		}
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