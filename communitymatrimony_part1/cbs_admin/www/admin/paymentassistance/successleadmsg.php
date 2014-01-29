<?
/*******************************************************************************************************
File Name	: sucessleadmsg.php
Location	: /home/office/www/support
Author		: Anish.G
Created On	: 16-MAY-2009
Description	: After insert and update successful information is showed this file is a call file from supportpmentoption.php
*********************************************************************************************************/

$MatriID=$_GET['mid'];
$msgInsert='Successfully your MatriId ['.$MatriID.'] has been inserted.';
$msgUpdate='Successfully your MatriId ['.$MatriID.'] has been updated.';
if($_GET['task']=='1'){
		$task=$msgUpdate;
	}
	elseif($_GET['task']=='2'){
		$task=$msgInsert;
	}
	elseif($_GET['task']=='3'){
		$error='yes';
		$task='<FONT SIZE="1.5" COLOR="#FF0066">The MatriId ['.$MatriID.'] found to be invalid</FONT>';
	}
	elseif($_GET['task']=='4'){
		$error='yes';
		$task='<FONT SIZE="1.5" COLOR="#FF0066">The MatriId ['.$MatriID.'] is a Paid Member cant update Leads Again</FONT>';
	}

	//$page='supportpaymentoptions.php';
	$page='index.php';
?>
<HTML>
<HEAD>
<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=<?=$page?>">
	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/usericons-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractions-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractivity-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/messages.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/fade.css">
</head><body>
<table width="65%" align=center  border=0 cellpadding=2 cellspacing=0 class="adminformheader">
	<tr>
		<td align=center>
			<b>Support Payment Options-<?if($error==''){?>Success Msg<?}else{?>Error!<?}?></b>
		</td>
	</tr>
	<tr><td align='center'><?=$task?></td></tr>
</table>