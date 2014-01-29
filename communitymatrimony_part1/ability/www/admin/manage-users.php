<?php

//include($varRootBasePath."/www/admin/includes/config.php");

$action = $_GET['action'];
if($adminUserName == '') {
  header("Location: index.php?act=login");
}
if($adminUserName != 'nazir' && $adminUserName != 'vijay.anand' && $adminUserName != 'admin') {
  echo "You are not a authorised user to access this page";exit();
}
$arrUserType=array('nazir'=>array(2=>'Admin executive'),'admin'=>array(2=>'Admin executive'),'vijay.anand'=>array(3=>'Admin view access'));
$arrViewCounter=array(50=>50,100=>100,150=>150,200=>200);
$arrBranchId=array(4=>'USA',5=>'Chennai',6=>'Hyderabad',7=>'Mumbai',8=>'Bangalore',9=>'Delhi',10=>'Cochin',11=>'Kolkata',12=>'Mangalore',13=>'Pune',14=>'Coimbatore',15=>'Mysore',16=>'Chandigarh',17=>'Madurai',18=>'Ahmedabad',19=>'Vizag',20=>'Indore',21=>'TVM',22=>'Trichy',23=>'TNJ',24=>'Lucknow',26=>'Calicut',27=>'Guruvayur',28=>'Dubai',29=>'Pondichery',34=>'Jaipur',36=>'Nagpur',37=>'Ludhiana',41=>'Dehradun',42=>'Goa',43=>'Surat', 84=>'Palakkadu',85=>'Kannur',88=>'Tirunelveli',89=>'Royapuram',90=>'Vadapalani',91=>'Annanagar',92=>'Tnagar',93=>'Salem',55=>'Karnal',51=>'HYD Greenlands',52=>'KOL Kankurgachi', 53=>'Rourkela', 54=>'Udaipur', 56=>'Rajkot', 57=>'Thane',58=>'Vadodara',59=>'NGR Gandhiputla',95=>'Kanpur',61=>'Belgaum',62=>'Thrissur',63=>'Kottayam',64=>'Allapuzha',65=>'Kollam',66=>'Malapuram',67=>'Calicut',68=>'Nagercovil');
//echo $adminUserName;
function checkAvailability($objDBCon,$tblName,$colName,$varValue) {
    $argFields		= array($colName);
    $argCondition	    = " WHERE $colName = '".$varValue."'";
    $varExecute		= $objDBCon->select($tblName, $argFields, $argCondition,0);
	if(mysql_num_rows($varExecute)) {
	    return true;
	}
	else {
	    return false;
	}
}

function date_mysql($date, $format) {
  $d = explode("-", $date);
  $time = explode(" ", $d[2]);
  $t = explode(":", $time[1]);
  $datetime_converted = date($format, mktime ($t[0],$t[1],$t[2],$d[1],$d[2],$d[0]));
  return $datetime_converted;
}

if($_POST['frmAddUserSubmit'] == 'yes') {
   $objDBSlave			= new DB;
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
<table border="0" cellpadding="0" cellspacing="0" align="left" WIDTH="542">
		<tr><td height="15" colspan="3"></td></tr>
		<tr><td valign="middle" class="heading" colspan="3"  style="padding-left:15px;_padding-left:15px;">Add New User</td></tr>
		<tr><td height="10" colspan="3"></td></tr>

		<tr>
			<td class="smalltxt" style="padding-left:15px;_padding-left:15px;"><b>User Name</b>&nbsp;</td>
			<td class="smalltxt"><input type="text" name="User_Name" id="User_Name" size="15" class="normaltxt1 required" value="<?php echo $_POST['User_Name'];?>">&nbsp;</td>
		</tr>
		<tr><td height="30" colspan="3"></td></tr>

		<tr>
			<td class="smalltxt" style="padding-left:15px;_padding-left:15px;"><b>Email</b>&nbsp;</td>
			<td class="smalltxt"><input type="text" name="Email" id="Email" size="30" class="normaltxt1 required email" value="<?php echo $_POST['Email'];?>">&nbsp;</td>
		</tr>
		<tr><td height="30" colspan="3"></td></tr>

		<tr>
			<td class="smalltxt" style="padding-left:15px;_padding-left:15px;"><b>Status</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="Publish" id="Publish" class="required" value=1 <?php echo ($_POST['Publish'] || !$_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>Active&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Publish" id="Publish" class="required" value=0 <?php echo (!$_POST['Publish'] && $_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>Inactive</td>
			<td class="smalltxt" style="padding-left:15px;_padding-left:15px;"><b>User Type</b>&nbsp;</td>
			<td class="smalltxt">
				<select name="User_Type" id="User_Type">
				 <?php
			      foreach($arrUserType as $key => $value) {
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
		<tr><td height="30" colspan="3"></td></tr>

		<tr>
			<td class="smalltxt" style="padding-left:15px;_padding-left:15px;"><b>Phone View</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="Phone_View" id="Phone_View" class="required" value=1 <?php echo ($_POST['Phone_View'] || !$_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Phone_View" id="Phone_View" class="required" value=0 <?php echo (!$_POST['Phone_View'] && $_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>No</td>
			<td class="smalltxt" style="padding-left:15px;_padding-left:15px;"><b>Photo View</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="Photo_View" id="Photo_View" class="required" value=1 <?php echo ($_POST['Photo_View'] || !$_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Photo_View" id="Photo_View" class="required" value=0 <?php echo (!$_POST['Photo_View'] && $_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>No</td>
		</tr>
		<tr><td height="30" colspan="3"></td></tr>

		<tr>
			<td class="smalltxt" style="padding-left:15px;_padding-left:15px;"><b>Horoscope View</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="Horoscope_View" id="Horoscope_View" class="required" value=1 <?php echo ($_POST['Horoscope_View'] || !$_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Horoscope_View" id="Horoscope_View" class="required" value=0 <?php echo (!$_POST['Horoscope_View'] && $_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>No</td>
			<td class="smalltxt" style="padding-left:15px;_padding-left:15px;"><b>Send Mail</b>&nbsp;</td>
			<td class="smalltxt">
			<input type="radio" name="SendMail" id="SendMail" class="required" value=1 <?php echo ($_POST['SendMail'] || !$_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>Yes&nbsp;&nbsp;&nbsp;
			<input type="radio" name="SendMail" id="SendMail" class="required" value=0 <?php echo (!$_POST['SendMail'] && $_POST['frmAddUserSubmit'])?"checked=checked":"" ?>>No</td>
		</tr>
		<tr><td height="30" colspan="3"></td></tr>

		<tr>
			<td class="smalltxt" style="padding-left:15px;_padding-left:15px;"><b>Branch Id</b>&nbsp;</td>
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
            <td class="smalltxt" style="padding-left:15px;_padding-left:15px;"><b>View Counter</b>&nbsp;</td>
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
        <tr><td height="30" colspan="3"></td></tr>

		<tr><td height="30" colspan="3" align="center">
		    <input type="hidden" name="frmAddUserSubmit" value="yes">
			<input type="Submit" Value="Submit" name="Submit" class="button submit">
		</td></tr>
	</table>
	</form>
<?php
}
else {
    $objDBSlave			= new DB;
    $objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

	//Include the PS_Pagination class
	include('ps_pagination.php');

	if($adminUserName == 'nazir' || $adminUserName == 'admin') {
	  $query="select * from adminlogininfo where user_type = 2 order by Date_Created desc";
	}
	if($adminUserName == 'vijay.anand') {
	  $query="select * from adminlogininfo where user_type = 3 order by Date_Created desc";
	}
	$pager = new PS_Pagination($objDBSlave->clsDBLink,$query, 10, 5,"act=manage-users");

	$pager->setDebug(true);

	$rs = $pager->paginate();
	if(!$rs) die(mysql_error());

	echo "<div style='width:600px;'><div style='width:200px; float:left;'><b>".$pager->renderFullNav()."</b></div><div style='padding:0px 0px 0px 100px;'><b>User Details</b></div></div>";

	$adminloginfoTblContent='<table width=500 cellspacing=3 cellpadding=2 border=1 style=border-collapse:collapse><tr class="mediumtxt clr5"><th width=8%>S.No</th><th width=12%>User Name</th><th width=30%>Email</th><th>Status</th><th>Branch</th><th>Date Created</th><th>View</th><th>Edit</th><th>Delete</th>';
	$i=1;
	while($row = mysql_fetch_array($rs)) {
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
	echo "<b>".$pager->renderFullNav()."</b>";
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
</script>