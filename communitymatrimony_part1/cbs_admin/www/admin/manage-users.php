<?php
if($varRootBasePath == '') {
  $varRootBasePath = '/home/product/community';
}
include_once($varRootBasePath."/www/admin/includes/admin-privilege.cil14");

$action = $_GET['action'];
if($adminUserName == '') {
  header("Location: index.php?act=login");
}
ini_set('display_errors',1);
$arrManageUsers1 = array_keys($arrManageUsers);
if (!in_array($adminUserName,$arrManageUsers1)) {
  echo "You are not a authorised user to access this page";exit();
}
//object declaration
$objDBSlave	 = new DB;

//echo $adminUserName;
function checkAvailability($objDBCon,$tblName,$colName,$varValue) {
    $argFields		= array($colName);
    $argCondition	    = " WHERE $colName = ".$objDBCon->doEscapeString($varValue,$objDBCon);
    $varExecute		= $objDBCon->select($tblName, $argFields, $argCondition,0);
	if(mysql_num_rows($varExecute)) {
	    return true;
	}
	else {
	    return false;
	}
}

if($_POST['frmAddUserSubmit'] == 'yes') {	
	
   $objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
   if(!$objDBSlave->clsErrorCode) {
	   $_POST['User_Name']=strip_tags(trim($_POST['User_Name']));
	   $_POST['Email']=strip_tags(trim($_POST['Email']));
	   if(!checkAvailability($objDBSlave,$varTable['ADMINLOGININFO'],'User_Name',$_POST['User_Name'])) {
          if(!checkAvailability($objDBSlave,$varTable['ADMINLOGININFO'],'Email',$_POST['Email'])) {
	          @extract($_POST); $fields=""; $fields=$_POST;array_pop($fields);array_pop($fields); $argFields=array();$argFieldsValues=array();
              foreach($fields as $key=>$value) {
	          $value='"'.$value.'"';
              array_push($argFields,$key);array_push($argFieldsValues,strip_tags(trim($value)));
              }			  
              array_push($argFields,'Date_Created');array_push($argFieldsValues,'NOW()');
		      $objDBSlave->dbClose();
              $objDBMaster			= new DB;
              $objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);
              $objDBMaster->insert($varTable['ADMINLOGININFO'],$argFields,$argFieldsValues);
              if(!$objDBMaster->clsErrorCode) {
		        $action='';
		      }
		      else {
		        echo $objDBMaster->clsErrorCode;
		      }
		  }
		  else {
		     echo "Email already exists!!!";
		  }
	   }
	   else {
	     echo "User Name already exists!!!";
	   }
   }
   else {
	  echo $objDBSlave->clsErrorCode;
   }
}

if($action =='add') {
?>
<script src="<?php echo $confValues["JSPATH"].'/jquery.js'; ?>" type="text/javascript"></script>
<script src="<?php echo $confValues["JSPATH"].'/jquery-validate.js';?>" type="text/javascript"></script>
<script src="<?php echo $confValues["JSPATH"].'/common.js';?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	$("#frmAddUser").validate();
});


</script>
<style type="text/css">
#frmAddUser label.error
{
	color:red;
	display:block;
	width:130px;
}
</style>
<form name="frmAddUser" id="frmAddUser" method="post">
<table>
<tr><td height="15" colspan="3"></td></tr>
		<tr><td valign="middle" class="heading" colspan="3"  style="padding-left:15px;_padding-left:15px;"><u>Add New User</u></td></tr>
		<tr><td height="10" colspan="3"></td></tr>
</table>

<table border="1" cellpadding="2" cellspacing="3" align="left" style="border-collapse:collapse;margin-left:5px;margin-right:10px;" WIDTH="600" style="margin:3px;" class="formborder">
		<tr>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>User Name</b>&nbsp;</td>
			<td class="smalltxt"><input type="text" name="User_Name" id="User_Name" size="20" class="normaltxt1 required checkSpace" minlength="3" maxlength="15" value="<?php echo $_POST['User_Name'];?>">&nbsp;</td>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Email</b>&nbsp;</td>
			<td class="smalltxt"><input type="text" name="Email" id="Email" size="20" class="normaltxt1 required email" value="<?php echo $_POST['Email'];?>">&nbsp;</td>
		</tr>
		<tr><td height="15" colspan="4"></td></tr>

		<tr>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Mobile</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="text" name="Mobile" id="Mobile" size="20" class="normaltxt1 required checkSpace" minlength="10" maxlength="10" value="<?php echo $_POST['Mobile'];?>" 
			onKeypress="return allowNumeric(event);">
			</td>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>SMS Active Status</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="SMSFlag" id="SMSFlag" class="required" value=1 <?php echo ($_POST['SMSFlag'] || !$_POST['frmAddUserSubmit'])?"":"checked=checked" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="SMSFlag" id="SMSFlag" class="required"  value=0 <?php echo (!$_POST['SMSFlag'] && $_POST['frmAddUserSubmit'])?"":"checked=checked" ?>>No
			</td>
		</tr>
		<tr><td height="15" colspan="4"></td></tr>

		<tr>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Status</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="Publish" id="Publish" class="required" value=1 <?php echo ($_POST['Publish'] || !$_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>Active&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Publish" id="Publish" class="required" value=0 <?php echo (!$_POST['Publish'] && $_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>Inactive</td>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>User Type</b>&nbsp;</td>
			<td class="smalltxt" style="padding-right:5px;">
				<select name="User_Type" id="User_Type">
				 <?php
			      foreach($arrManageUsers as $key => $value) {
		           if($key == $adminUserName) {
					   foreach($value as $key1 => $value1) {
				         echo '<option value='.$key1.' selected>'.$value1.'</option>';
					   }
				   }
				  }
		         ?>
				</select>
			</td>
		</tr>
		<tr><td height="15" colspan="4"></td></tr>

		<tr>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Phone View</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="Phone_View" id="Phone_View" class="required" value=1 <?php echo ($_POST['Phone_View'] || !$_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Phone_View" id="Phone_View" class="required" value=0 <?php echo (!$_POST['Phone_View'] && $_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>No</td>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Photo View</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="Photo_View" id="Photo_View" class="required" value=1 <?php echo ($_POST['Photo_View'] || !$_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Photo_View" id="Photo_View" class="required" value=0 <?php echo (!$_POST['Photo_View'] && $_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>No</td>
		</tr>
		<tr><td height="15" colspan="4"></td></tr>

		<tr>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Horoscope View</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="Horoscope_View" id="Horoscope_View" class="required" value=1 <?php echo ($_POST['Horoscope_View'] || !$_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Horoscope_View" id="Horoscope_View" class="required" value=0 <?php echo (!$_POST['Horoscope_View'] && $_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>No</td>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Send Mail</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="SendMail" id="SendMail" class="required" value=1 <?php echo ($_POST['SendMail'] || !$_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="SendMail" id="SendMail" class="required" value=0 <?php echo (!$_POST['SendMail'] && $_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>No</td>
		</tr>
		<tr><td height="15" colspan="4"></td></tr>

		<tr>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Branch Id</b>&nbsp;</td>
			<td class="smalltxt"><select name="BranchId" id="BranchId" class="required">
			<?php
			   foreach($arrBranchId as $key => $value) {
		          if($key == $_POST['BranchId']) {
				     echo '<option value='.$key.' selected>'.$value.'</option>';
				  }
				  else {
				     echo '<option value='.$key.'>'.$value.'</option>';
				   }
			   }
		    ?>
			</select>&nbsp;</td>
            <td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>View Counter</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="hidden" name="View_Counter" id="View_Counter" value="200">
			<select name="View_Counter" id="View_Counter" class="required" disabled="disabled">
			<?php
			   foreach($arrViewCounter as $key => $value) {
		          if($key == $_POST['View_Counter']) {
				     echo '<option value='.$key.' selected>'.$value.'</option>';
				   }
				   else {
				     echo '<option value='.$key.'>'.$value.'</option>';
				   }
			   }
		     ?>
			</select>&nbsp;</td>
        </tr>
        <tr><td height="15" colspan="4"></td></tr>

		
	</table>
	<div> &nbsp; </div>
	<table  border="0" cellpadding="0" cellspacing="0" align="left" style="border-collapse:collapse;margin-left:5px;margin-right:10px;" WIDTH="610" style="margin:3px;">
	<tr><td height="30" colspan="4" align="center">
		    <input type="hidden" name="frmAddUserSubmit" value="yes">
			<input type="Submit" Value="Submit" name="Submit" class="button submit">
		</td></tr>
	</table>
	</form>
	
<?php
}
else {
	echo '<form name="frmSearchUser" id="frmSearchUser" method="post">';
	echo '<div id="listUsersStyle" style="color:#339933;font-size:14px;font-weight:bold;margin:5px;"> List Users </div>';
	echo'<div  style=width:700px;> &nbsp;&nbsp;<b>Search By User_Name / Email : </b>&nbsp;&nbsp;
	 <input type="radio" name="rcheck" value="1" checked>User_Name&nbsp;&nbsp; 
	 <input type="radio" name="rcheck" value="2">Email&nbsp;&nbsp;
	 <input type="text" name="suser" id="suser" value="">&nbsp;&nbsp;
	 <input type="hidden" name="frmSearchUserSubmit" value="yes">
	 <input type="Submit" Value="Search" name="SearchSubmit" class="button submit" 
	 onClick="javascript:return funSearchUserId();">
	  <a href="index.php?act=manage-users"><input type="button" Value="LIST"  class="button"></a></div>';
	 echo '</form>';
	  $user=addslashes(strip_tags(trim($_POST['suser'])));
	  $rch=$_POST['rcheck'];
	 $objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
	//Include the PS_Pagination class
	include('ps_pagination.php');    
	$varUserType = key($arrManageUsers[$adminUserName]);
	if(($_POST['frmSearchUserSubmit'] == 'yes')&& ($rch == '1')) {
		$query="select * from adminlogininfo WHERE User_Name like '%$user%' AND user_type='$varUserType'  order by Date_Created desc";
	}
	else if(($_POST['frmSearchUserSubmit'] == 'yes')&& ($rch == '2')) {
		$query="select * from adminlogininfo WHERE Email = '$user' AND user_type='$varUserType'  order by Date_Created desc";		
	}else{
	$query="select * from adminlogininfo where user_type = $varUserType order by Date_Created desc";
	}

	$pager = new PS_Pagination($objDBSlave->clsDBLink,$query, 10, 5,"act=manage-users");

	$pager->setDebug(true);
	$rs = $pager->paginate();
	if(!$rs) die(mysql_error());	
	echo "<div style='width:600px;'><div style='width:200px; float:left;'><b style='margin:5px'>".$pager->renderFullNav()."</b></div><div style='padding:0px 0px 0px 100px;'><b  style='color:#F26A26'>User Details</b></div></div>";
	$adminloginfoTblContent='<table width=500 cellspacing=3 cellpadding=2 border=1 style=border-collapse:collapse;margin:5px; class=formborder ><tr class="adminformheader"><th width=8%>S.No</th><th width=12%>User Name</th><th width=30%>Email</th><th>Status</th><th>Branch</th><th>Date Created</th><th>View</th><th>Edit</th><th>Delete</th>';
	$i=1;
	while($row = mysql_fetch_array($rs)) 	 	
	{
        $row['Publish'] = ($row['Publish'])?'active':'inactive';

		$tblContent.='<tr align=center class="mediumtxt clr5">';
		$tblContent.='<td>'.$i.'</td>';
		$tblContent.='<td>'.$row['User_Name'].'</td>';
        $tblContent.='<td>'.$row['Email'].'</td>';
		$tblContent.='<td>'.$row['Publish'].'</td>';
        $tblContent.='<td>'.$arrBranchId[$row['BranchId']].'</td>';
        $tblContent.='<td>'.date_mysql($row['Date_Created'],'M jS,Y').'</td>';
		$tblContent.='<td><input type=submit class=button value=View onClick=window.open("/admin/users-edit-view.php?action=view&userName='.$row['User_Name'].'","popup","width=500,height=500");></td>';
		//$tblContent.='<td><a href='.$confValues["ServerURL"].'/admin/index.php?act=users-edit-view&action=edit&userName='.$row['User_Name'].'>Edit</a></td>';
        $tblContent.='<td><input type=submit class=button value=Edit onClick=window.open("/admin/users-edit-view.php?action=edit&userName='.$row['User_Name'].'","popup","width=650,height=500");></td>';
        $tblContent.='<td><a href='.$confValues["ServerURL"].'/admin/index.php?act=users-edit-view&action=delete&userName='.$row['User_Name'].' onClick="javascript:return show_confirm();"><input type=submit class=button value=Delete></a></td>';
		$tblContent.='</tr>';
	    $i++;
	}
	$tblContent.='</table>';
	$adminloginfoTblContent.=$tblContent;
	echo $adminloginfoTblContent;

	//Display the full navigation in one go
	echo "<b style='margin:5px'>".$pager->renderFullNav()."</b>";
} 
?>
<script type="text/javascript">
function show_confirm()
{
var r=confirm("Are you sure, You want to delete?");
if (r==true) {
  return true
  }
else{
  return false;
  }
}

function funSearchUserId() {
	var frmName = document.frmSearchUser;
	if (frmName.suser.value=="" ) {
		alert("Please enter  User_Name or Email");
		frmName.suser.focus();
		return false;
	}
	frmName.frmSearchUserSubmit.value='yes';
	frmName.submit();
	return true;
}
</script>
