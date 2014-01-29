<?php
if($varRootBasePath == '') {
$varRootBasePath = '/home/product/community';
}
include_once($varRootBasePath."/www/admin/includes/config.php");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath."/www/admin/includes/admin-privilege.cil14");


if($adminUserName == '') {
  header("Location: index.php?act=login");
}

$arrManageUsers1 = array_keys($arrManageUsers);
if (!in_array($adminUserName,$arrManageUsers1)) {
  echo "You are not a authorised user to access this page";exit();
}

$action = $_GET['action'];
$userName= $_GET['userName'];

function checkAvailabilityForEdit($objDBCon,$tblName,$colName,$varValue,$varUserName) {
    $argFields		= array($colName);
    $argCondition	    = " WHERE $colName = ".$objDBCon->doEscapeString($varValue,$objDBCon)." and User_Name != ".$objDBCon->doEscapeString($varUserName,$objDBCon);
    $varExecute		= $objDBCon->select($tblName, $argFields, $argCondition,0);
	if(mysql_num_rows($varExecute)) {
	    return true;
	}
	else {
	    return false;
	}
}

if($_POST['frmEditUserSubmit'] == 'yes') { 
   $objDBSlave			= new DB;
   $objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
   if(!$objDBSlave->clsErrorCode) {
      if(!checkAvailabilityForEdit($objDBSlave,$varTable['ADMINLOGININFO'],'Email',$_POST['Email'],$_POST['User_Name'])) {
         @extract($_POST); $fields=""; $fields=$_POST;array_pop($fields);array_pop($fields);array_pop($fields); $argFields=array();$argFieldsValues=array();
         foreach($fields as $key=>$value) {
	        $value='"'.$value.'"';
            array_push($argFields,$key);array_push($argFieldsValues,strip_tags(trim($value)));
         }
		 $argCondition="User_Name = '".$userName."'";
	     $objDBMaster			= new DB;
         $objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);
         if(!$objDBMaster->clsErrorCode) {
		    $objDBMaster->update($varTable['ADMINLOGININFO'],$argFields,$argFieldsValues,$argCondition);
            if(!$objDBMaster->clsErrorCode) {
			    //echo "<script>document.location.href='/admin/index.php?act=manage-users';</script>";exit;
		         echo "<script>self.close();window.opener.location.reload();</script>";exit;
			}
		    else {
		        echo $objDBMaster->clsErrorCode;
		    }
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
	  echo $objDBSlave->clsErrorCode;
   }
}

if($action == 'edit' && $userName) {
   $objDBSlave			= new DB;
   $objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
     if(!$objDBSlave->clsErrorCode) {
     $argFields		=     array('User_Name','Email','Mobile','SMSFlag','Publish','User_Type','Phone_View','Photo_View', 'Horoscope_View','SendMail','BranchId','View_Counter');
     $argCondition	    = " WHERE User_Name = ".$objDBSlave->doEscapeString($userName,$objDBSlave);
     $varExecute		= $objDBSlave->select($varTable['ADMINLOGININFO'], $argFields, $argCondition,0);
     $varUserInfo = mysql_fetch_assoc($varExecute);
	 if(!$_POST['frmEditUserSubmit']) {
     $_POST=$varUserInfo;
	 }


?>
<script src="<?=$confValues["JSPATH"].'/jquery.js'; ?>" type="text/javascript"></script>
<script src="<?=$confValues["JSPATH"].'/jquery-validate.js';?>" type="text/javascript"></script>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/global-style.css">
<script type="text/javascript">
$(document).ready(function() {
	$("#frmEditUser").validate();
});
</script>
<style type="text/css">
#frmEditUser label.error
{
	color:red;
	display:block;
	width:130px;
}
</style>
<div style="border: 4px solid rgb(219, 219, 219); background: rgb(255, 255, 255) none repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;margin:6px;">

<form name="frmEditUser" id="frmEditUser" method="post">
<table border="0" cellpadding="0" cellspacing="0" align="center" WIDTH="625" style="margin:3px;">
<tr class="mediumtxt clr5" align="center"><td height="15" colspan="4"></td></tr>
		<tr class="mediumtxt clr5" align="left"><td valign="middle" class="heading" colspan="4" style="padding-left:15px;_padding-left:15px;margin: 5px; color: rgb(51, 153, 51);font-size:14px;font-weight:bold;">Edit User</td></tr>
		<tr><td height="10" colspan="4"></td></tr>
</table>
<div style="margin:5px;">
<table border="1" cellpadding="2" cellspacing="3" align="center" style="border-collapse:collapse;margin-left:5px;margin-right:10px;" WIDTH="610" style="margin:3px;" class="formborder">
			
		<tr class="mediumtxt clr5">
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>User Name</b>&nbsp;</td>
			<td class="smalltxt" style="margin-left:5px;"><label><b><?php echo $_POST['User_Name'];?></b></label>&nbsp;</td>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Email</b>&nbsp;</td>
			<td class="smalltxt"><input type="text" name="Email" id="Email" size="25" class="normaltxt1 required email" value="<?php echo $_POST['Email'];?>">&nbsp;</td>
		</tr>
		
		<tr>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Mobile</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="text" name="Mobile" id="Mobile" size="25" class="normaltxt1 required checkSpace" minlength="10" maxlength="10" value="<?php echo $_POST['Mobile'];?>">
			</td>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>SMS Active Status</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="SMSFlag" id="SMSFlag" class="required" value=1 <?php echo ($_POST['SMSFlag'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="SMSFlag" id="SMSFlag" class="required" value=0 <?php echo (!$_POST['SMSFlag'])?"checked=checked":"" ?>>No</td>			
		</tr>
		

		<tr>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Status</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="Publish" id="Publish" class="required" value=1 <?php echo ($_POST['Publish'])?"checked=checked":"" ?>>Active&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Publish" id="Publish" class="required" value=0 <?php echo (!$_POST['Publish'])?"checked=checked":"" ?>>Inactive</td>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>User Type</b>&nbsp;</td>
			<td class="smalltxt">
				<select name="User_Type" id="User_Type"  style="width:180px">
				 <?php
			      foreach($arrUserTypes as $key => $value) {
		           if($key == $_POST['User_Type']) {
				         echo '<option value='.$key.' selected>'.$value.'</option>';
				   }
				  }
		         ?>
				</select>
			</td>
		</tr>
		

		<tr>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Phone View</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="Phone_View" id="Phone_View" class="required" value=1 <?php echo ($_POST['Phone_View'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Phone_View" id="Phone_View" class="required" value=0 <?php echo (!$_POST['Phone_View'])?"checked=checked":"" ?>>No</td>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Photo View</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="Photo_View" id="Photo_View" class="required" value=1 <?php echo ($_POST['Photo_View'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Photo_View" id="Photo_View" class="required" value=0 <?php echo (!$_POST['Photo_View'])?"checked=checked":"" ?>>No</td>
		</tr>
		
        
		<tr>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Horoscope View</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="Horoscope_View" id="Horoscope_View" class="required" value=1 <?php echo ($_POST['Horoscope_View'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Horoscope_View" id="Horoscope_View" class="required" value=0 <?php echo (!$_POST['Horoscope_View'])?"checked=checked":"" ?>>No</td>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Send Mail</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="SendMail" id="SendMail" class="required" value=1 <?php echo ($_POST['SendMail'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="SendMail" id="SendMail" class="required" value=0 <?php echo (!$_POST['SendMail'])?"checked=checked":"" ?>>No</td>
		</tr>
		
		
		<tr>
			<td class="adminformheader" style="padding-left:15px;_padding-left:15px;"><b>Branch Id</b>&nbsp;</td>
			<td class="smalltxt"><select name="BranchId" id="BranchId" class="required" style="width:180px">
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
			<td class="smalltxt"><select name="View_Counter" id="View_Counter" class="required" style="width:180px">
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
        

			
	</table>
	<table  border="0" cellpadding="0" cellspacing="0" align="center" WIDTH="625" style="margin:3px;">
		<tr><td height="30" colspan="4" align="center">
		    <input type="hidden" name="frmEditUserSubmit" value="yes">
			<input type="hidden" name="User_Name" value="<?php echo $_POST['User_Name']; ?>">
			<input type="Submit" Value="Update" name="Submit" class="button submit">
		</td></tr>
	</table>
	</form>
	</div>
<?php 
	 }
     else {
		 echo $objDBSlave->clsErrorCode;
	 }
}
if($action == 'view' && $userName) {
  $objDBSlave			= new DB;
  $objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
  if(!$objDBSlave->clsErrorCode) {
	 $argCondition="where User_Name =".$objDBSlave->doEscapeString($userName,$objDBSlave);
     $varUserInfo=$objDBSlave->selectAll($varTable['ADMINLOGININFO'],$argCondition,1);
	 echo '<link rel=stylesheet href='.$confValues['CSSPATH'].'/global-style.css>';
	 //echo '<table align="center" cellspacing=5 cellpadding=5 border=1 style=border-collapse:collapse><caption>User Details</caption><tr class="mediumtxt clr5"><th>Field Name</th><th>Value</th>';
	 ?>
	
	 <div  align="center" style="margin-left:30px;margin-top:10px;">
	 <div style="clear: both; padding-bottom: 10px;"> </div>
	

	 <table border="0" cellpadding="0" cellspacing="0" align="center" WIDTH="625" style="margin:3px;">
		<tr class="mediumtxt clr5" align="center"><td height="15" colspan="4"></td></tr>
		<tr class="mediumtxt clr5" align="left"><td valign="middle" class="heading" colspan="4" style="padding-left:15px;_padding-left:15px;margin: 5px; color: rgb(51, 153, 51);font-size:14px;font-weight:bold;">Edit User</td></tr>
		<tr><td height="10" colspan="4"></td></tr>
	</table>

	 <table border="1" cellpadding="2" cellspacing="0" align="left" WIDTH="400" style="border:1px solid #C5D653;color:#606060;">
		
				
	 <?php
		 $arrLables=array("User Name","Email","Mobile","SMS Active Status","Status","User Type","View Counter","Phone View","Photo View","Horoscope View","Send Mail","Branch","Date Created","Last Login");$varIndex=0;
	   foreach($varUserInfo as $key=>$value) {
		  if($key != 'Password') {
			  if($key == 'SMSFlag' ||$key == 'Publish' || $key == 'Phone_View' || $key == 'Photo_View' || $key == 'Horoscope_View' || $key == 'SendMail') {
			   $value = ($value)?'yes':'No';
			  }
			  if($key == 'BranchId') {
			    $value=$arrBranchId[$value];
			  }
			  if($key == 'User_Type') {
			    $value=$arrUserTypes[$value];
			  }
              if($key == 'Date_Created' || $key == 'Last_Login') {
		        $value=date_mysql($value,'M jS,Y');
		      }  ?>
	      <tr>
			<td class="smalltxt" style="padding-right:50px;_padding-right:50px;background-color:#F2F7CE;
border-bottom:1px solid #C5D653;font-size:13px;font-weight:bold;"><b><?=$arrLables[$varIndex]?></b>&nbsp;</td>
			<td class="smalltxt"><label><?=$value?></label>&nbsp;</td>
		  </tr>
		  
	 <?php 
          $varIndex=$varIndex+1;
		  }
	   }
	 
	      echo '<tr><td align=center colspan=2><input type=submit class=button value=Close onClick=javascript:self.close();></td></tr></table> </div>';
		
		
  }
  else {
   echo $objDBSlave->clsErrorCode;
  }
}
if($action == 'delete') {
  $objDBMaster = new DB;
  $objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);
  if(!$objDBMaster->clsErrorCode) {
     $argCondition="User_Name =".$objDBMaster->doEscapeString($userName,$objDBMaster);
     $objDBMaster->delete($varTable['ADMINLOGININFO'],$argCondition);
     if(!$objDBMaster->clsErrorCode) {
        echo "<script>document.location.href='/admin/index.php?act=manage-users';</script>";exit;
     }
     else {
       echo $objDBSlave->clsErrorCode;  
     }
  }
  else {
    echo $objDBSlave->clsErrorCode;
  }
}
?>
