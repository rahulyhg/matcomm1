<?php 
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
if($varRootBasePath == '') {
  $varRootBasePath = '/home/product/community';
}
include_once($varRootBasePath."/www/admin1/includes/userLoginCheck.php"); // Added for authentication
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/lib/clsDB.php");
include_once("adminheader.php");
//ini_set('display_errors',1);
//error_reporting(E_ALL);
    $objDBSlave			= new DB;
    $objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
    $objDBMaster		= new DB;
    $objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	if($_REQUEST['action']=='update'){
		$varUpdateCondtn	    = " MatriId='".$_REQUEST['MatriId']."'";
		$varProfileUpdateFields	= array("Incomplete_Story_Flag");
		$varProfileUpdateVal	= array("1");
		$objDBMaster->update($varTable['MEMBERDELETEDINFO'], $varProfileUpdateFields, $varProfileUpdateVal, $varUpdateCondtn);
		header('location : '.$confValues['IMAGEURL'].'/admin1/successstory/manage-incomplete-users.php?page='.$_REQUEST['page'].'&flag='.$_REQUEST['flag']);
	}

	//Include the PS_Pagination class
	include('../ps_pagination.php');
    $flag   = $_REQUEST['flag'];
	$opflag = $flag?0:1;
	//$query="select MatriId,Email,Name,Contact_Phone,Contact_Mobile,Date_Deleted from ".$varTable['MEMBERDELETEDINFO']." where Incomplete_Story_Flag=".$flag." and Deleted_Reason=1 and MatriId NOT IN(select MatriId from ".$varTable['SUCCESSSTORYINFO'].") order by Date_Deleted desc";

	$query="select MatriId,Email,Name,Contact_Phone,Contact_Mobile,Date_Deleted from ".$varTable['MEMBERDELETEDINFO']." where Incomplete_Story_Flag=0 and Deleted_Reason=1 order by Date_Deleted desc";

	$pager = new PS_Pagination($objDBSlave->clsDBLink,$query, 10, 5,"flag=".$flag);

	$pager->setDebug(true);

	$rs = $pager->paginate();
	if(!$rs) die(mysql_error());
    $statusLabel    =  $flag?'Completed':'Pending';
	$opstatusLabel  =  $flag?'Pending':'Completed';
	echo "<div style='width:600px;padding:0px 0px 0px 155px;'><div style='float:left;width:140px; float:left;'><b>".$pager->renderFullNav()."</b></div><div style='float:left;;width:250px;padding:0px 0px 0px 50px;'><b>".$statusLabel." Success Story - User Details</b></div><div style='float:left;;width:120px;padding:0px 0px 0px 20px;float:left'><a href='manage-incomplete-users.php?flag=".$opflag."'></a></div></div>";

	$adminloginfoTblContent='<table width=500 cellspacing=3 cellpadding=2 border=1 style="border-collapse:collapse;margin-left:155px;"><tr class="mediumtxt clr1"><th width=8%>S.No</th><th width=12%>MatriId</th><th width=30%>Email</th><th nowrap>Contact Number</th><th nowrap>Date Deleted</th>';
	$i=1;
	if($_REQUEST['page']>1){
	$i=($_REQUEST['page']-1)*10;
	$i=$i+1;
	}
	while($row = mysql_fetch_array($rs)) {
        $status     =  $flag?'Completed':'Pending';
       	$tblContent.='<tr align=center class="mediumtxt clr1">';
		$tblContent.='<td>'.$i.'</td>';
		$tblContent.='<td>'.$row['MatriId'].'</td>';
       // $tblContent.='<td>'.$row['Name'].'</td>';
        $tblContent.='<td>'.$row['Email'].'</td>';
        $tblContent.='<td nowrap>'.$row['Contact_Phone'].'/'.$row['Contact_Mobile'].'</td>';
        $tblContent.='<td nowrap>'.date("M jS,Y", strtotime($row['Date_Deleted'])).'</td>';
		//$tblContent.='<td>'.$status.'</td>';

		/*if($flag==0)
		$tblContent.='<td><input type=submit class=button value=Complete onClick="javascript:return updateId(\''.$row['MatriId'].'\',\''.$_REQUEST['page'].'\',\''.$_REQUEST['flag'].'\');"></td>';
        else
		$tblContent.='<td>Taken</td>';*/

       	$tblContent.='</tr>';
	    $i++;
	}
	$tblContent.='</table>';
	$adminloginfoTblContent.=$tblContent;
	echo $adminloginfoTblContent;

	//Display the full navigation in one go
	echo "<div style='width:600px;padding:0px 0px 0px 155px;'><div style='float:left;width:140px; float:left;'><b>".$pager->renderFullNav()."</b></div>";

?>
<script>
	var varConfArr=new Array(); varConfArr['domainimgs']="<?=$confValues['IMGSURL']?>"; varConfArr['domainweb'] = "<?=$confValues['SERVERURL']?>";varConfArr['domainname'] = "<?=$confValues['DOMAINNAME']?>"; varConfArr['domainimage'] = "<?=$confValues['IMAGEURL']?>";varConfArr['webimgs']="<?=$confValues['PHOTOURL']?>"; varConfArr['domainimg'] = "<?=$confValues['IMGURL']?>"; varConfArr['productname'] = "<?=$confValues['PRODUCTNAME']?>";
</script>
<script type="text/javascript">
function updateId(id,page,flag){
	var r=confirm("Are you sure, You want to confirm complete?");
    if (r==true) {
	  var url=varConfArr['domainimage']+'/admin1/successstory/manage-incomplete-users.php?action=update&page='+page+'&MatriId='+id+'&flag='+flag;
	  location.href=url;
    }
    else{
      return false;
   }
}
</script>