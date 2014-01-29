<?php
//*************************************
// File Name	: adminuser.php
// Code By		: Pradeep, Ashok kumar
//*************************************

include "/home/cbsmailmanager/config/config.php";
include_once "lib/authenticate.php";
include "/home/cbsmailmanager/config/header.php";

if ($_SESSION['access'] != 1) {
	echo "<br> <center> <font class='title'> Sorry, Your are not authorised member to view this page...! <br><br> <a href='index.php'> Back </a> </font> </center>";
	exit;
} 


if ( $_POST['do_submit'] ) {

	$name		= $_POST['name'];
	$email		= $_POST['email'];
	$user_name	= $_POST['user_name'];
	$pass_wrd	= $_POST['pass_wrd'];
	$previlage	= $_POST['previlage'];

	if ( $_POST['do_submit'] == 'Add') {
		$exists = record_already_exists($user_name, 'user_name', $tbl['adminuser']);
		if ( $exists == 0 ) {
			$sql = "insert into ".$tbl['adminuser']." (name,email,user_name,pass_wrd,previlage) values ('$name','$email','$user_name','$pass_wrd','$previlage')";
			$ret_res = query_execute ($sql,'add'); 
		} else {
			$ret_res = "User Name already exists...";
		}
	}		
	if ( $_POST['do_submit'] == 'Update') {
		$sql = "update ".$tbl['adminuser']." set name='$name',email='$email',user_name='$user_name',pass_wrd='$pass_wrd',previlage='$previlage' where id='$id'";
		$ret_res = query_execute ($sql,'update');
	}
	if ( $_POST['do_submit'] == 'Delete') {
		$sql = "delete from ".$tbl['adminuser']." where id='$id'";
		$ret_res = query_execute ($sql,'del');
	}
}

?>

<script language="JavaScript" type="text/javascript">
var state;
function set_operation(val1,val2,val3,val4,val5,val6,val7) {
	if ( val1 ) {
		state = 1;
		document.frm.id.value = val2;
		document.frm.name.value = val3;
		document.frm.email.value = val4;
		document.frm.user_name.value = val5;
		document.frm.pass_wrd.value = val6;
		document.frm.previlage.value = val7;
		if ( val1.name == 'edit' ) {
			document.frm.do_submit.value = "Update";
		}
		if ( val1.name == 'del' ) {
			document.frm.do_submit.value = "Delete";
		}
	}
}

function aval()
{
	if(document.frm.name.value=="") {
		alert("please enter The Name");
		document.frm.name.focus();
		return false;
	}
	if(document.frm.email.value=="") {
		alert("please enter Email Address");
		document.frm.email.focus();
		return false;
	}
	if ( !ValidateEmail( frm.email.value ) ) {
		alert( "Invalid E-mail " + frm.email.value );
		frm.email.focus( );
		return false;
	}
	if(document.frm.user_name.value=="") {
		alert("please enter User Name");
		document.frm.user_name.focus();
		return false;
	}
	if(document.frm.pass_wrd.value=="") {
		alert("please enter Password");
		document.frm.pass_wrd.focus();
		return false;
	}
	if(document.frm.previlage.value=="x") {
		alert("please enter Previlage");
		document.frm.previlage.focus();
		return false;
	}
	return true;
}
</script>


<table border="0" cellpadding="0" cellspacing="0" align="center" width="780" class="maintborder" bgcolor="#ffffff">
<tr>

<td valign="top" width="148" bgcolor=#E9E9E9 >
<!--Left Menu Start-->		
<? include "/home/cbsmailmanager/config/leftmenu.php"; ?>
<!--Left Menu End-->		
</td>

<td valign="top" bgcolor=#B5B5B5 class="borderclr"><img src="/images/trans.gif" width="1" height="1"></td>
<td width="5">&nbsp;</td>

<td valign="top" width="625">
<br>
<!--Middle Area Start-->		
		<form name="frm" method="post" action="" onsubmit="return aval();">
		<table class="title" border=0 align=center cellpadding=1 cellspacing=1 >
		<tr>
			<td bgcolor="#B4B2AF">
					<table class="title" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF" >
					<tr>
						<td>
							<table class="title" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF">
							<tr  bgcolor="#6A6A6A">
								<td class="white" align=center colspan=3><?=$ret_res?></td>
							</tr>
							<tr  bgcolor="FF6000">
								<td class="white" align=center colspan=3>Admin Info</td>
							</tr>
							<tr>
								<td>
									   <table class="smalltxt" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF">
									   <input class="title" type="hidden" name="id" value="" >
									<tr>
										<td class="title">Name</td>
										<td><input class="smalltxt" type="text" name="name" value=""></td>
									</tr>
									<tr>
										<td class="title">Email</td>
										<td><input class="smalltxt" type="text" name="email" value=""></td>
										
									</tr>
									<tr>
										<td class="title">User Name</td>
										<td><input class="smalltxt" type="text" name="user_name" value=""></td>
										
									</tr>
									<tr>
										<td class="title">Password</td>
										<td><input class="smalltxt" type="text" name="pass_wrd" value=""></td>
										
									</tr>
									<tr>
									<td class="title">Previlage</td>
									<td>
									<select  class="smalltxt" name="previlage">
										<option value="x">--Select One--</option>
										<option value="1">Admin</option>
										<option value="2">User</option>
										
									</select>
									</td>
								</tr>
								<tr>
									<td class="title" align="right"><input type="submit" name="do_submit" value="Add"></td>
									<td><input type="reset" name="reset" value="Reset"></td>
								</tr>
							   </table>
						</td>
					</tr>
					</table>
			</td>
		</tr>
		</table>
			</td>
		</tr>
		</table>
		</form>
		<?
		$select = "select * from " . $tbl['adminuser'];
		$res = mysql_query($select);
		$total_count = mysql_num_rows($res);
		include "paging.php";
		$select = "select * from " . $tbl['adminuser'] ." order by id limit $start_value, $record_count ";
		$res = mysql_query($select);
		?>

		<table class="smalltxt" border=0 align=center cellpadding=1 cellspacing=1 >
		<tr bgcolor="#B4B2AF">
			<td class=title colspan=10 align=center>
				<table class="smalltxt" border=0 width=100% align=center cellpadding=1 cellspacing=1 >
				<tr bgcolor="FF6000">
					<td class=white align=left>Admin Details</td>
					<td class=white align=center>Total Count - <?=$total_count?></td>
					<td class=white align=right><a class=white href="adminuser.php"> Add New </a> </td>
				</tr>
				</table>
			</td>
		</tr>
		<tr bgcolor="#B4B2AF">
			<td class=title colspan=8 align=center>
				<table class="smalltxt" border=0 width=100% align=center cellpadding=1 cellspacing=1 >
				<tr bgcolor="#B4B2AF">
					<td class=title align=center>
					<?
						echo "Page : $page of $no_of_pages &nbsp;&nbsp; ";
						for ( $i=1;$i<=$no_of_pages;$i++ ) {
							echo "<a href='adminuser.php?page=$i'>$i</a> &nbsp;";
						}
					?>
					</td>
				</tr>
				</table>
			</td>
		</tr>

		<tr bgcolor="#CECECE">
			<td class="title">Id</td>
			<td class="title">Name</td>
			<td class="title">Email</td>
			<td class="title">User Name</td>
			<td class="title">Previlage</td>
			<td class="title">Edit</td>
			<td class="title">Delete</td>
		</tr>
		<?php

		while ( $row = mysql_fetch_array ($res) ) {
		?>
		<tr bgcolor="#CECECE">
			<td><?=$row['id']?></td>
			<td><?=$row['name']?></td>
			<td><?=$row['email']?></td>
			<td><?=$row['user_name']?></td>
			<td><?=$row['previlage']?></td>
			<td><img style="cursor:hand" src="images/button_edit.png" name="edit" value=" Edit " 
			onclick="set_operation(this,<?=$row['id']?>,'<?=$row['name']?>','<?=$row['email']?>','<?=$row['user_name']?>','<?=$row['pass_wrd']?>','<?=$row['previlage']?>');"></td>
			 
		<td><img style="cursor:hand" src="images/button_drop.png" name="del" value="Delete" 	onclick="set_operation(this,<?=$row['id']?>,'<?=$row['name']?>','<?=$row['email']?>','<?=$row['user_name']?>','<?=$row['pass_wrd']?>','<?=$row['previlage']?>');"></td>
			 </tr>


		<?
		}
		?>
		</table>

<!--Middle Area End-->		
</td>

</tr>
</table>

<?
include "/home/cbsmailmanager/config/footer.php";
?>