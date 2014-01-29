<?php
error_reporting(0);
include "/home/cbsmailmanager/config/config.php";
//include_once "lib/authenticate.php";
include "/home/cbsmailmanager/config/header.php";
include "paging.php";
ini_set("memory_limit","512M");
$maillist_filename = '/home/cbsmailmanager/mlistfiles/beforetestmaillist.txt';
$lines = file($maillist_filename);
$beforetest =  count($lines);
$maillist_filenames = '/home/cbsmailmanager/mlistfiles/creativeteam.txt';
$line = file($maillist_filenames);
$aftertest =count($line);


?>
	<table border="0" cellpadding="0" cellspacing="0" align="center" width="780" class="maintborder" bgcolor="#ffffff">
	<tr>

		<td valign="top" width="148"  bgcolor="#E9E9E9">
		<!--Left Menu Start-->
		<? include "/home/cbsmailmanager/config/leftmenu.php"; ?>
		<!--Left Menu End-->
		</td>

		<td valign="top" bgcolor=#B5B5B5 class="borderclr"><img src="/images/trans.gif" width="1" height="1"></td>
		<td width="5">&nbsp;</td>

		<td valign="top" width="925">
		<script language="JavaScript" type="text/javascript">
		function validate1()
		{
			if ((document.ser.cate.value=="") && (document.ser.sub.value=="")){
				alert("Please Enter Category or Subject");
				document.ser.cate.focus();
				return false;
		}
	        return true;
    }
		</script>
		<form name="ser" method="post" action="view_templates.php?search=do" onsubmit="return validate1();">

		<table border="0" cellpadding="1" cellspacing="1" align="center" class="maintborder" bgcolor="#ffffff">
		<tr>
		<tr class="title" bgcolor="FF6000">
		<td colspan="8"align="left" >
		 Search By
		</td>
		</tr>
		<tr class="title" bgcolor="#FFFFFF">

		<td align="left">
		 Category: <input class="smalltxt" type="text" name="cate" value="<?=$_REQUEST['cate']?>" size="20">[OR]
		</td>
		</td>
		<td align="left">
		 Subject : <input class="smalltxt" type="text" name="sub" value="<?=$_REQUEST['sub']?>" size="20">
		  <input class="smalltxt" type="submit" name="search_id_submit" value="Search" >
		</td>
		</tr>
		</tr>
		</table></form>
		<br>
		<!--Middle Area Start-->
		<?
	    $select = "select count(*) as cnt from emailtemplate";
		$res = mysql_query($select);
		$row1 = mysql_fetch_array ($res);
		$total_count = $row1['cnt'];
        include "paging.php";
		if($_REQUEST['search'] == 'do')
		{
			$select="select id,Category,CategoryName,Subject,BodyContent from ".$tbl['mailer']." where DelFlag =0";
			if ( $_REQUEST['cate'] != '' ) {
				 $select .= " and Category = '".addslashes($_REQUEST['cate'])."'";
			}
			if ( $_REQUEST['sub'] != '' ) {
				 $select .= " and Subject like '%".addslashes($_REQUEST['sub'])."%' ";
			}
			$select .= " Order by id DESC "; //previously order by CreatedDate
		}
		else {
		$select="select id,Category,CategoryName,Subject,BodyContent from ".$tbl['mailer']." where DelFlag =0 Order by id DESC limit $start_value, $record_count"; }
		$resMatrimony=mysql_query($select)or die($select. mysql_error());
		$total_rows = mysql_num_rows($resMatrimony);

		if($total_rows !=0){
 		?>

			<table class="smalltxt" border=0 align=center cellpadding=1 cellspacing=1 width=100%>
			<tr bgcolor="#B4B2AF">
				<td class=title colspan=10 align=center>
					<table class="smalltxt" border=0 width=100% align=center cellpadding=1 cellspacing=1 >
					<tr bgcolor="FF6000">
						<td class=white align=left colspan=2>List Of Mail Concepts</td>
 					</tr>
					</table>
				</td>
			</tr>
			<tr bgcolor="#CECECE">
				<td class="title"  >Id</td>
				<td class="title" >Mail Name</td>
     			<td class="title" align ="center">Subject</td>
				<td class="title" >Edit </td>
				<td class="title" >View </td>
				<td class="title" >Test mails <!-- (<?=$beforetest ?>) --></td>
				<!-- <td class="title" >Test mail(<?=$aftertest ?>)</td>
				<td class="title" >Test mail for others</td> -->
			</tr>
		<?
		while( $datMatrimony=mysql_fetch_array($resMatrimony)) { ?>
			<tr bgcolor="#CECECE">
				<td ><?=$datMatrimony['id']?></td>
				<td ><?=$datMatrimony['Category']?></td>
				<td><?=$datMatrimony['Subject']?></td>
		        <td > <a href="email_template.php?opr=edit&id=<?=$datMatrimony['id']?>"> <img border=0 style="cursor:hand" src="images/button_edit.png"> </a> </td>
				<td > <a href="gettemplate.php?catg=<?=$datMatrimony['Category']?>" target="_blank" style="font-family: Verdana, MS sans serif, Arial, Verdana; font-weight: normal;font-size: 11px;	color: #000000;	font-style: normal;	text-decoration: underline"> <img alt="View Banner" src="images/lens.jpg" border=0> </a> </td>
				<td > <a href="beforetest.php?pri=3&fname=<?=$datMatrimony['Category']?>&type=beforetest&dt=<?=date('Y-m-d H:i:s')?>" style="font-family: Verdana, MS sans serif, Arial, Verdana; font-weight: normal;font-size: 11px;	color: #000000;	font-style: normal;	text-decoration: underline"> Test mail </a> </td>
				<!-- <td > <a href="beforetest.php?pri=3&fname=<?=$datMatrimony['Category']?>&type=aftertest&dt=<?=date('Y-m-d H:i:s')?>" style="font-family: Verdana, MS sans serif, Arial, Verdana; font-weight: normal;font-size: 11px;	color: #000000;	font-style: normal;	text-decoration: underline"> Test mail </a> </td>
				<td > <a href="otherstest.php?pri=3&fname=<?=$datMatrimony['Category']?>&type=aftertest&dt=<?=date('Y-m-d H:i:s')?>&subject=<? echo htmlentities($datMatrimony['Subject'])?>" style="font-family: Verdana, MS sans serif, Arial, Verdana; font-weight: normal;font-size: 11px;	color: #000000;	font-style: normal;	text-decoration: underline"> Test mail for others </a> </td>	 -->
			</tr>
		    <?
		}

if($_REQUEST['search'] != 'do'){
			?><br>
			<tr bgcolor="#B4B2AF">
			<td class=title colspan=8 align=center>
				<table class="smalltxt" border=0 width=80% align=center cellpadding=1 cellspacing=1 >
				<tr bgcolor="#B4B2AF">
					<td class=title align=center>
					<?
						echo "Page : $page of $no_of_pages &nbsp;&nbsp; ";
						for ( $i=1;$i<=$no_of_pages;$i++ ) {
							echo "<a href='view_templates.php?page=$i' style='font-family: Verdana, MS sans serif, Arial, Verdana; font-weight: normal;font-size: 11px;	color: #000000;	font-style: normal;	text-decoration: underline'>$i</a> &nbsp;";
						}
					?>
					</td>
				</tr><? } ?>
				</table>
			</td>
		</tr>
			</table>

		<!--Middle Area End-->
		</td>

		</tr>
		</table>
    <? }
	else {?> <p  style="text-align:center"><b>No Records Found</b></p> <? }
		include "/home/cbsmailmanager/config/footer.php"; ?>
