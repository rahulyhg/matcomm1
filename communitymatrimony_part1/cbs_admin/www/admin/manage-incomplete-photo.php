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
    $objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	if($_REQUEST['action']=='update'){
		$varUpdateCondtn	    = " MatriId=".$objDBMaster->doEscapeString($_REQUEST['MatriId'],$objDBMaster);
		$varProfileUpdateFields	= array("Incomplete_Photo_Flag","Photo_Set_Status");
		$varProfileUpdateVal	= array("1","1");
		$objDBMaster->update($varTable['SUCCESSSTORYINFO'], $varProfileUpdateFields, $varProfileUpdateVal, $varUpdateCondtn);
		
		$path =' http://'.$confValues['IMAGEURL'].'/admin/successstory/regenerate-stories.php?page='.$_REQUEST['page'].'&flag='.$_REQUEST['flag'].'&MatriId='.$_REQUEST['MatriId'];

        echo "<script>location.href='".$path."'</script>";
		
		//@header('location : http://www.communitymatrimony.com/admin/index.php?act=manage-incomplete-photo&page='.$_REQUEST['page'].'&flag='.$_REQUEST['flag']);
	}

	//Include the PS_Pagination class
	include('ps_pagination.php');
    $flag = $_REQUEST['flag'];
	$opflag = $flag?0:1;
	$query="select MatriId,Email,User_Name,Telephone,Date_Updated from ".$varTable['SUCCESSSTORYINFO']." where Photo_Set_Status=".$flag." and Incomplete_Photo_Flag=".$flag." order by Date_Updated desc";

	//and publish=1
	//select MatriID from memberdeletedinfo where MatriId NOT IN(select MatriId from successstoryinfo)

	$pager = new PS_Pagination($objDBSlave->clsDBLink,$query, 10, 5,"act=manage-incomplete-photo&flag=".$flag);

	$pager->setDebug(true);

	$rs = $pager->paginate();
	if(!$rs) die(mysql_error());
    $statusLabel  =  $flag?'Completed':'Incomplete';
	$opstatusLabel  =  $flag?'Incomplete':'Completed';
	echo "<div style='width:600px;'><div style='float:left;width:180px; float:left;'><b>".$pager->renderFullNav()."</b></div><div style='float:left;padding:0px 0px 0px 20px;'><b>".$statusLabel." Photo - User Details</b></div><div style='float:left;;width:120px;padding:0px 0px 0px 20px;float:left'><a href='http://".$confValues['SERVERURL']."/admin/index.php?act=manage-incomplete-photo&flag=".$opflag."'>Go to ".$opstatusLabel." List</a></div></div>";

	$adminloginfoTblContent='<table width=500 cellspacing=3 cellpadding=2 border=1 style=border-collapse:collapse><tr class="mediumtxt clr5"><th width=8%>S.No</th><th width=12%>MatriId</th><th width=30%>Email</th><th>Contact Number</th><th nowrap>Date Deleted</th><th>Photo</th><th>Action</th>';
	$i=1;
	if($_REQUEST['page']>1){
	$i=($_REQUEST['page']-1)*10;
	$i=$i+1;
	}
	
	while($row = mysql_fetch_array($rs)) {

        $status         =  $flag?'Completed':'Pending';
		$varActFields	= array("Success_Id","Photo","Photo_Set_Status");
        $varActCondtn	= " WHERE MatriId='".$row['MatriId']."'";
        $varActInf		= $objDBSlave->select($varTable['SUCCESSSTORYINFO'],$varActFields,$varActCondtn,1);
        $Success_Id     = $varActInf[0]["Success_Id"];
       	$tblContent.='<tr align=center class="mediumtxt clr5">';
		$tblContent.='<td>'.$i.'</td>';
		$tblContent.='<td>'.$row['MatriId'].'</td>';
        //$tblContent.='<td>'.$varName.'</td>';
        $tblContent.='<td>'.$row['Email'].'</td>';
        $tblContent.='<td>'.$row['Telephone'].'</td>';
        $tblContent.='<td nowrap>'.date_mysql($row['Date_Updated'],'M jS,Y').'</td>';
		//$tblContent.='<td>'.$status.'</td>';

			       
		if($flag==0)
		$tblContent.='<td nowrap><a class="smalltxt boldtxt" href="javascript:uploadPhotos(\''.$Success_Id.'\');">Upload Photo</a>&nbsp;&nbsp;
            <a class="smalltxt boldtxt" href="javascript:viewPhotos(\''.$Success_Id.'\');">View Photo</a>&nbsp;&nbsp;<a class="smalltxt boldtxt" href="javascript:cropPhotos(\''.$Success_Id.'\');">Crop Photo</a></td>';
        else
        $tblContent.='<td nowrap><a class="smalltxt boldtxt" href="javascript:viewPhotos(\''.$Success_Id.'\');">View Photo</a></td>';

		if($flag==0)
		$tblContent.='<td><input type=submit class=button value=Complete onClick="javascript:return updateId(\''.$row['MatriId'].'\',\''.$_REQUEST['page'].'\',\''.$_REQUEST['flag'].'\',\''.$row['Photo_Set_Status'].'\');"></td>';
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
<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
<script type="text/javascript">
function viewPhotos(succesId){
   http://image.communitymatrimony.com/admin/successstory/success-photo-upload.php?Success_Id=394 
   var path=varConfArr['domainimage']+'/admin/successstory/success-photo-view.php?Success_Id='+succesId;
   window.open(path, "myWindow", "status = 0, height = 550, width = 650, resizable = 1,scrollbars=1");
}
function uploadPhotos(succesId){
   var path=varConfArr['domainimage']+'/admin/successstory/success-photo-upload.php?Success_Id='+succesId;
   window.open(path, "myWindow", "status = 0, height = 550, width = 650, resizable = 1,scrollbars=1");
}
function cropPhotos(succesId){
   var path=varConfArr['domainimage']+'/admin/successstory/success-photo-crop.php?Success_Id='+succesId;
   window.open(path, "myWindow", "status = 0, height = 550, width = 650, resizable = 1,scrollbars=1");
}
var http_request;
function updateId(id,page,flag,photostatus){
	if(photostatus==0){
		//alert("Please upload and validate photo first before complete.");
		//return false;
	}
	var r=confirm("Are you sure, You want to confirm complete?");
    if (r==true){
		http_request=AjaxCall();
		url = varConfArr['domainweb']+"/admin/successstory/regenerate-stories.php?MatriId="+id+"&page="+page+"&flag="+flag;
		AjaxGetReq(url,MatriidResponse,http_request);
	}else{ return false; }
}
function MatriidResponse(){
	alert(http_request.readyState+'===='+http_request.status);
	if(http_request.readyState == 4){
	    	alert(http_request.responseText);
	}
}
function addPhto(id){
	var url=varConfArr['domainimage']+'/admin/successstory/index.php?act=fullfill_success_photo&MatriId='+id;
	location.href=url;
   
}
</script>