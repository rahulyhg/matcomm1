<?php 
if($varRootBasePath == '') {
  $varRootBasePath = '/home/product/community';
}
include_once($varRootBasePath."/www/admin/includes/admin-privilege.cil14");
include_once($varRootBasePathh.'/conf/dbinfo.cil14');

if($adminUserName == '') {
  header("Location: index.php?act=login");
}
ini_set('display_errors',1);
$arrManageUsers1 = array_keys($arrManageUsers);
if (!in_array($adminUserName,$arrManageUsers1)) {
  echo "You are not a authorised user to access this page";exit();
}

    $objDBSlave			= new DB;
    $objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
    $objDBMaster		= new DB;
    $objDBMaster->dbConnect('S',$varDbInfo['DATABASE']);

	if($_REQUEST['action']=='update'){
		$varUpdateCondtn	    = " MatriId=".$objDBMaster->doEscapeString($_REQUEST['MatriId'],$objDBMaster);
		$varProfileUpdateFields	= array("Incomplete_Story_Flag");
		$varProfileUpdateVal	= array("1");
		$objDBMaster->update($varTable['MEMBERDELETEDINFO'], $varProfileUpdateFields, $varProfileUpdateVal, $varUpdateCondtn);
		header('location : '.$confValues['SERVERURL'].'/admin/index.php?act=manage-incomplete-users&page='.$_REQUEST['page'].'&flag='.$_REQUEST['flag']);
	}

	//Include the PS_Pagination class
	include('ps_pagination.php');
    $flag   = $_REQUEST['flag'];
	$opflag = $flag?0:1;
	$query="select MatriId,Email,Name,Contact_Phone,Contact_Mobile,Date_Deleted from ".$varTable['MEMBERDELETEDINFO']." where Incomplete_Story_Flag=".$flag." and Deleted_Reason=1 and MatriId NOT IN(select MatriId from ".$varTable['SUCCESSSTORYINFO'].") order by Date_Deleted desc";

	$pager = new PS_Pagination($objDBSlave->clsDBLink,$query, 10, 5,"act=manage-incomplete-users&flag=".$flag);

	$pager->setDebug(true);

	$rs = $pager->paginate();
	if(!$rs) die(mysql_error());
    $statusLabel    =  $flag?'Completed':'Incomplete';
	$opstatusLabel  =  $flag?'Incomplete':'Completed';
	echo "<div style='width:600px;'><div style='float:left;width:140px; float:left;'><b>".$pager->renderFullNav()."</b></div><div style='float:left;;width:250px;padding:0px 0px 0px 50px;'><b>".$statusLabel." Success Story - User Details</b></div><div style='float:left;;width:120px;padding:0px 0px 0px 20px;float:left'><a href='".$confValues['SERVERURL']."/admin/index.php?act=manage-incomplete-users&flag=".$opflag."'>Go to ".$opstatusLabel." List</a></div></div>";

	$adminloginfoTblContent='<table width=500 cellspacing=3 cellpadding=2 border=1 style=border-collapse:collapse><tr class="mediumtxt clr5"><th width=8%>S.No</th><th width=12%>MatriId</th><th width=30%>Email</th><th nowrap>Contact Number</th><th nowrap>Date Deleted</th><th>Action</th>';
	$i=1;
	if($_REQUEST['page']>1){
	$i=($_REQUEST['page']-1)*10;
	$i=$i+1;
	}
	while($row = mysql_fetch_array($rs)) {
        $status     =  $flag?'Completed':'Pending';
       	$tblContent.='<tr align=center class="mediumtxt clr5">';
		$tblContent.='<td>'.$i.'</td>';
		$tblContent.='<td>'.$row['MatriId'].'</td>';
       // $tblContent.='<td>'.$row['Name'].'</td>';
        $tblContent.='<td>'.$row['Email'].'</td>';
        $tblContent.='<td nowrap>'.$row['Contact_Phone'].'/'.$row['Contact_Mobile'].'</td>';
        $tblContent.='<td nowrap>'.date_mysql($row['Date_Deleted'],'M jS,Y').'</td>';
		//$tblContent.='<td>'.$status.'</td>';

		if($flag==0)
		$tblContent.='<td><input type=submit class=button value=Complete onClick="javascript:return updateId(\''.$row['MatriId'].'\',\''.$_REQUEST['page'].'\',\''.$_REQUEST['flag'].'\');"></td>';
        else
		$tblContent.='<td>Taken</td>';

       	$tblContent.='</tr>';
	    $i++;
	}
	$tblContent.='</table>';
	$adminloginfoTblContent.=$tblContent;
	echo $adminloginfoTblContent;

	//Display the full navigation in one go
	echo "<b>".$pager->renderFullNav()."</b>";

?>
<script>
	var varConfArr=new Array(); varConfArr['domainimgs']="<?=$confValues['IMGSURL']?>"; varConfArr['domainweb'] = "<?=$confValues['SERVERURL']?>";varConfArr['domainname'] = "<?=$confValues['DOMAINNAME']?>"; varConfArr['domainimage'] = "<?=$confValues['IMAGEURL']?>";varConfArr['webimgs']="<?=$confValues['PHOTOURL']?>"; varConfArr['domainimg'] = "<?=$confValues['IMGURL']?>"; varConfArr['productname'] = "<?=$confValues['PRODUCTNAME']?>";
</script>
<script type="text/javascript">
function updateId(id,page,flag){
	var r=confirm("Are you sure, You want to confirm complete?");
    if (r==true) {
	  var url=varConfArr['domainweb']+'admin/index.php?act=manage-incomplete-users&action=update&page='+page+'&MatriId='+id+'&flag='+flag;
	  location.href=url;
    }
    else{
      return false;
   }
}
</script>