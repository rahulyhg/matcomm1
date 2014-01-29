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
	    
    $objDBSlave			= new DB;
    $objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
	$objDBMaster		= new DB;
    $objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	if($_REQUEST['action']=='update'){
				
		header('location :'.$confValues['IMAGEURL'].' /admin1/successstory/manage-incomplete-photo.php?page='.$_REQUEST['page'].'&flag='.$_REQUEST['flag']);
	}

	//Include the PS_Pagination class
	include('../ps_pagination.php');
    $flag = $_REQUEST['flag'];
	$opflag = $flag?0:1;
	$query="select MatriId,Email,User_Name,Telephone,Date_Updated,Incomplete_Photo_Flag from ".$varTable['SUCCESSSTORYINFO']." where Photo_Set_Status=".$flag." and (Incomplete_Photo_Flag=".$flag." or Incomplete_Photo_Flag=2) and Publish=1 order by Date_Updated desc";

	//and publish=1
	//select MatriID from memberdeletedinfo where MatriId NOT IN(select MatriId from successstoryinfo)

	$pager = new PS_Pagination($objDBSlave->clsDBLink,$query, 10, 5,"flag=".$flag);

	$pager->setDebug(true);

	$rs = $pager->paginate();
	if(!$rs) die(mysql_error());
    $statusLabel  =  $flag?'Completed':'Pending';
	$opstatusLabel  =  $flag?'Pending':'Completed';
	echo "<div style='width:600px;padding:0px 0px 0px 155px;'><div style='float:left;width:180px; float:left;'><b>".$pager->renderFullNav()."</b></div><div style='float:left;padding:0px 0px 0px 20px;'><b>".$statusLabel." Photo - User Details</b></div><div style='float:left;;width:120px;padding:0px 0px 0px 20px;float:left'><a href='manage-incomplete-photo.php?flag=".$opflag."'></a></div></div>";

	$adminloginfoTblContent='<table  width=500 cellspacing=3 cellpadding=2 border=1 style="border-collapse:collapse;margin-left:155px;"><tr class="mediumtxt clr1"><th width=8%>S.No</th><th width=12%>MatriId</th><th width=30%>Email</th><th>Contact Number</th><th nowrap>Date Deleted</th><th>Photo</th><th>Action</th>';
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
       	$tblContent.='<tr align=center class="mediumtxt clr1">';
		$tblContent.='<td>'.$i.'</td>';
		$tblContent.='<td>'.$row['MatriId'].'</td>';
        //$tblContent.='<td>'.$varName.'</td>';
        $tblContent.='<td>'.$row['Email'].'</td>';
        $tblContent.='<td>'.$row['Telephone'].'</td>';
        $tblContent.='<td nowrap>'.date("M jS,Y", strtotime($row['Date_Updated'])).'</td>';
		//$tblContent.='<td>'.$status.'</td>';
        			       
		if($flag==0)
		$tblContent.='<td nowrap><a class="smalltxt clr5" href="javascript:uploadPhotos(\''.$Success_Id.'\');">Upload Photo</a>&nbsp;&nbsp;
            <a class="smalltxt clr5" href="javascript:viewPhotos(\''.$Success_Id.'\');">View Photo</a>&nbsp;&nbsp;<a class="smalltxt clr5" href="javascript:cropPhotos(\''.$Success_Id.'\');">Crop Photo</a></td>';
        else
        $tblContent.='<td nowrap><a class="smalltxt clr5" href="javascript:viewPhotos(\''.$Success_Id.'\');">View Photo</a></td>';

		if($flag==0)
		$tblContent.='<td><input type=submit class=button value=Complete onClick="javascript:return updateId(\''.$row['MatriId'].'\',\''.$_REQUEST['page'].'\',\''.$_REQUEST['flag'].'\',\''.$row['Incomplete_Photo_Flag'].'\');"></td>';
        else
		$tblContent.='<td>Taken</td>';
       
		$tblContent.='</tr>';
	    $i++;
	}
	$tblContent.='</table>';
	$adminloginfoTblContent.=$tblContent;
	echo $adminloginfoTblContent;

	//Display the full navigation in one go
	//echo "<b>".$pager->renderFullNav()."</b>";
    echo "<div style='width:600px;padding:0px 0px 0px 155px;'><div style='float:left;width:180px; float:left;'><b>".$pager->renderFullNav()."</b></div>";

?>
<script>
	var varConfArr=new Array(); varConfArr['domainimgs']="<?=$confValues['IMGSURL']?>"; varConfArr['domainweb'] = "<?=$confValues['SERVERURL']?>";varConfArr['domainname'] = "<?=$confValues['DOMAINNAME']?>"; varConfArr['domainimage'] = "<?=$confValues['IMAGEURL']?>";varConfArr['webimgs']="<?=$confValues['PHOTOURL']?>"; varConfArr['domainimg'] = "<?=$confValues['IMGURL']?>"; varConfArr['productname'] = "<?=$confValues['PRODUCTNAME']?>";
</script>
<script type="text/javascript">
function viewPhotos(succesId){
    var path=varConfArr['domainimage']+'/admin1/successstory/success-photo-view.php?Success_Id='+succesId;
   window.open(path, "myWindow", "status = 0, height = 550, width = 650, resizable = 1,scrollbars=1");
}
function uploadPhotos(succesId){
   var path=varConfArr['domainimage']+'/admin1/successstory/success-photo-upload.php?Success_Id='+succesId;
   window.open(path, "myWindow", "status = 0, height = 550, width = 650, resizable = 1,scrollbars=1");
}
function cropPhotos(succesId){
   var path=varConfArr['domainimage']+'/admin1/successstory/success-photo-crop-regenerate.php?Success_Id='+succesId;
   window.open(path, "myWindow", "status = 0, height = 550, width = 650, resizable = 1,scrollbars=1");
}
function createRequestObject() {
		var http_request;
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            http_request = new XMLHttpRequest();
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) { 
						//alert(e);
					}
            }
        }
        if (!http_request) {
            //alert("Giving up :( Cannot create an XMLHTTP instance");
            return false;
        }
        return http_request;
}
function updateId(id,page,flag,photostatus){

	if(photostatus!=2){
		alert("Please upload and validate photo first before complete.");
		return false;
	}
	var r=confirm("Are you sure, You want to confirm complete?");
    if (r==true) {
	 
	    http_request = false;
		http_request=createRequestObject();
		if (!http_request) {
			alert('Giving up :( Cannot create an XMLHTTP instance');
			return false;
		}
		if(http_request.readyState == 4 || http_request.readyState == 0 ){
			queryString= varConfArr['domainimage']+"/admin1/successstory/regenerate-stories.php?MatriId="+id+"&page="+page+"&flag="+flag;
			http_request.open("GET", queryString , true);
			http_request.onreadystatechange = MatriidResponse;
			http_request.send(null);
		}
	}
    else{
      return false;
   }
}
function MatriidResponse(){
	if(http_request.readyState == 4){
		if(http_request.status == 200){
			var xmlResponse = http_request.responseText;
	    	var res_str     = xmlResponse.split("~");
			var url=varConfArr['domainimage']+'/admin1/successstory/manage-incomplete-photo.php?action=update&page='+res_str[0]+'&MatriId='+res_str[1]+'&flag='+res_str[2];
			location.href=url;
			
		}else{
			alert("There was a problem accessing the server: " +http_request.statusText);
		}
	}
}

</script>