<?php
//*************************************
// File Name	: adminuser.php
// Code By		: Pradeep, Ashok kumar
//*************************************
include "/home/cbsmailmanager/config/config.php";
include_once "lib/authenticate.php";
include "/home/cbsmailmanager/config/header.php";

if ( $_POST['do_submit'] ) {
		$id 			= mysql_escape_string(trim($_POST['id']));
		$Category		= mysql_escape_string(trim($_POST['Category']));
		$CategoryName	= mysql_escape_string(trim($_POST['CategoryName']));
		$EmailFrom		= mysql_escape_string(trim($_POST['EmailFrom']));
		$ReplyTo		= mysql_escape_string(trim($_POST['ReplyTo']));
		$Subject		= mysql_escape_string(trim($_POST['Subject']));
		$BodyContent	= mysql_escape_string(trim($_POST['BodyContent']));
		$Comment		= mysql_escape_string(trim($_POST['Comment']));
		$CreatedDate	= trim($_POST['CreatedDate']);
		$ModifiedDate	= trim($_POST['ModifiedDate']);
		$ValidFlag		= trim($_POST['ValidFlag']);

		if ( $_POST['do_submit'] == 'Add') {
			$exists = record_already_exists($Category, 'Category', $tbl['mailer']);
			if ( $exists == 0 ) {
				$sql = "insert into ".$tbl['mailer']." (Category,CategoryName,EmailFrom,ReplyTo,Subject,BodyContent,Comment,CreatedDate,ValidFlag) values ('$Category','$CategoryName','$EmailFrom','$ReplyTo','$Subject','$BodyContent','$Comment',DATE_FORMAT(NOW(),'%Y-%m-%d'),$ValidFlag)";
				$ret_res = query_execute ($sql,'add');
			} else {
				$ret_res = "Category [OR] Category Name  already exists...";
			}
		}		
		if ( $_POST['do_submit'] == 'Copy') {
			$exists = record_already_exists($Category, 'Category', $tbl['mailer']);
			if ( $exists == 0 ) {
				$sql = "insert into ".$tbl['mailer']." (Category,CategoryName,EmailFrom,ReplyTo,Subject,BodyContent,Comment,CreatedDate,ValidFlag) values ('$Category','$CategoryName','$EmailFrom','$ReplyTo','$Subject','$BodyContent','$Comment',DATE_FORMAT(NOW(),'%Y-%m-%d'),$ValidFlag)";
				$ret_res = query_execute ($sql,'add');
			} else {
				$ret_res = "Category [OR] Category Name  already exists...";
			}
		}	
		if ( $_POST['do_submit'] == 'Update') {
			$sql = "update ".$tbl['mailer']." set Category='$Category',CategoryName='$CategoryName',EmailFrom='$EmailFrom',ReplyTo='$ReplyTo',Subject='$Subject',BodyContent='$BodyContent',Comment='$Comment',ModifiedDate=DATE_FORMAT(NOW(),'%Y-%m-%d'),ValidFlag='$ValidFlag' where id='$id'";
			$ret_res = query_execute ($sql,'update');
		}
		if ( $_POST['do_submit'] == 'Delete') {
			$sql = "update ".$tbl['mailer']." set DelFlag=1  where id='$id'";
			$ret_res = query_execute ($sql,'del');
		}
}

//Getting the ID for Edit/Copy
if ( ($_GET['id'] != '') && (($_GET['opr'] == 'edit') || $_GET['opr'] == 'copy'  || $_GET['opr'] == 'del') ) {
	$id = $_GET['id'];
	$esql = "select Category,CategoryName,EmailFrom,ReplyTo,Subject,BodyContent,Comment from ".$tbl['mailer']." where id = '$id' ";
	$eres = mysql_query($esql);
	$erow = mysql_fetch_array($eres);
}
?>

<script language="JavaScript" type="text/javascript">

var state;
function set_operation(val1,val2,val3,val4,val5,val6,val7,val8,val9) {
	if ( val1 ) {
		state = 1;
		document.frm.id.value = val2;
		document.frm.Category.value = val3;
		document.frm.CategoryName.value = val4;
		document.frm.EmailFrom.value = val5;
		document.frm.Subject.value = val6;
		document.frm.BodyContent.value = val7;
		document.frm.Comment.value = val8;

		if (document.frm.ValidFlag[0].value == val9) {
			document.frm.ValidFlag[0].checked = true;
		} else if (document.frm.ValidFlag[1].value == val9) {
			document.frm.ValidFlag[1].checked = true;
		}
		if ( val1.name == 'edit' ) {
			document.frm.do_submit.value = "Update";
		}
		if ( val1.name == 'copy' ) {
			document.frm.do_submit.value = "Copy";
		}
		if ( val1.name == 'del' ) {
			document.frm.do_submit.value = "Delete";
		}
	}
}

function aval()
{
	if(document.frm.Category.value=="") {
		alert("please enter Category");
		document.frm.Category.focus();
		return false;
	}
	if(document.frm.Category.value.search((/^[0-9a-zA-Z\-]+$/))) {
		alert("please enter a valid Category");
		document.frm.Category.focus();
		return false;
	}
	if(document.frm.CategoryName.value=="") {
		alert("please enter Category Name");
		document.frm.CategoryName.focus();
		return false;
	}
	if(document.frm.CategoryName.value.search((/^[0-9a-zA-Z\-]+$/))) {
		alert("please enter a valid Category Name");
		document.frm.CategoryName.focus();
		return false;
	}
	if(document.frm.EmailFrom.value=="") {
		alert("please enter Email Address");
		document.frm.EmailFrom.focus();
		return false;
	}
	if(document.frm.ReplyTo.value=="") {
		alert("please enter ReplyTo Address");
		document.frm.ReplyTo.focus();
		return false;
	}
	/*function ValidateEmail( Email )
	{
		var atCharPresent = false;
		var dotPresent = false;

		for ( var Idx = 0; Idx < Email.length; Idx++ )
		{
			if ( Email.charAt ( Idx ) == '@' )
				atCharPresent = true;
			if ( Email.charAt ( Idx ) == '.' )
				dotPresent = true;
		}

		if ( !atCharPresent || !dotPresent )
			return false;

		return true;
	}
	if ( !ValidateEmail(frm.EmailFrom.value ) ) {
		alert( "Invalid Email: " + frm.EmailFrom.value );
		frm.EmailFrom.focus();
		return false;
	} 
	for ( var Idx = 0; Idx < frm.EmailFrom.value.length; Idx++ )
	{
		if ( frm.EmailFrom.value.charAt(Idx) == '	'
			|| frm.EmailFrom.value.charAt(Idx) == ' '
			|| frm.EmailFrom.value.charAt(Idx) == ','
			|| frm.EmailFrom.value.charAt(Idx) == ';' )
		{
			alert( "No spaces or other invalid characters are not allowed in the email. Please enter only one  email address" );
			frm.EmailFrom.focus( );
			return false;
		}
	}*/
	if(document.frm.Subject.value=="") {
		alert("please enter Subject");
		document.frm.Subject.focus();
		return false;
	}	
	if(document.frm.BodyContent.value=="") {
		alert("please enter Body Content");
		document.frm.BodyContent.focus();
		return false;
	}	
	if(document.frm.Comment.value=="") {
		alert("please enter Comment");
		document.frm.Comment.focus();
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
		<br><!--Middle Area Start-->		
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
												<td class="white" align=left colspan=3>Config Email Template Here!</td>
											</tr>
											<tr>
												<td>
													   <table class="smalltxt" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF">
													   <input class="title" type="hidden" name="id" value="<?=$id?>" >
													<tr>
														<td class="title">Category</td>
														<td><input class="smalltxt" type="text" name="Category" value="<?=$erow['Category']?>" maxlength="15" size="15"></td>
													</tr>
													<tr>
														<td class="title">Category Name</td>
														<td><input class="smalltxt" type="text" name="CategoryName" value="<?=$erow['CategoryName']?>" size="15"></td>
													</tr>
													<tr>
														<td class="title">From</td>
														<td><input class="smalltxt" type="text" name="EmailFrom" value="<?=$erow['EmailFrom']?>" size="15"> [ @domainname.com ]</td>
														
													</tr>
													<tr>
														<td class="title">Reply To</td>
														<td><input class="smalltxt" type="text" name="ReplyTo" value="<?=$erow['ReplyTo']?>" size="15"> [ @domainname.com] </td>
														
													</tr>
													<tr>
														<td class="title">Subject</td>
														<td><input class="smalltxt" type="text" name="Subject" value="<?=htmlentities($erow['Subject'])?>" size="30"></td>
														
													<tr>
														<td class="title"><b>Body Content</b></td>
														 <td><textarea class="smalltxt" name="BodyContent" rows="4" cols="60" onkeypress="javascript: if ((event.keyCode==13) || (event.keyCode==34) || (event.keyCode ==39)) event.returnValue=false;"><?=htmlentities($erow['BodyContent'])?></textarea></td>
													</tr>
													<tr>
														<td class="title"><b>Comment</b></td>
														 <td><textarea class="smalltxt" name="Comment" rows="4" cols="60" onkeypress="javascript: if ((event.keyCode==13) || (event.keyCode==34) || (event.keyCode ==39)) event.returnValue=false;"><?=htmlentities($erow['Comment'])?></textarea></td>
													</tr>
													<tr>
														<td class="title"> Mode  </td>
														<td> <input type="radio" name="ValidFlag" value=1 > Activate 
															 <input type="radio" name="ValidFlag" value=0 checked> De-Activate
														</td>
														</tr>
												<tr>
													<td></td>	
													<td class="title" align="left">
													<? if ( ($_GET['id'] != '') && ($_GET['opr'] == 'edit') ) { ?>
													<input type="submit" name="do_submit" value="Update">&nbsp;&nbsp;
													<?} else if ( ($_GET['id'] != '') && ($_GET['opr'] == 'copy') ) { ?>
													<input type="submit" name="do_submit" value="Copy">&nbsp;&nbsp;
													<? } else if ( ($_GET['id'] != '') && ($_GET['opr'] == 'del') ) { ?>
													<input type="submit" name="do_submit" value="Delete">&nbsp;&nbsp;
													<? }  else  { ?>
													<input type="submit" name="do_submit" value="Add">&nbsp;&nbsp;
													<? } ?>
													<input type="reset" name="reset" value="Reset">
													</td>
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
				<script language="JavaScript" type="text/javascript">
		var state;
		function validate1() 
		{
			if (((document.ser.cate.value=="") &&(document.ser.cate.value>99999) || (document.ser.cate.value<999))&&	(document.ser.catename.value=="")&& (document.ser.sub.value=="")){
				alert("please enter Four Digit Category or Category Name or Subject");
				document.ser.cate.focus();
				return false;
			}
			
			
			return true;
		}
		</script>
			<form name="ser" method="post" action="" onsubmit="return validate1();">
				<table border="0" cellpadding="1" cellspacing="1" align="center" class="maintborder" bgcolor="#ffffff">
					<tr class="title" bgcolor="FF6000">
						<td colspan="5"align="left" >
						 Search By
						</td> 
					</tr>
					<tr class="title" bgcolor="#FFFFFF">
						<td align="left">Category :
						  <input class="smalltxt" type="text" name="cate" value="<?=$_REQUEST['cate']?>" maxlength=4 size=4 >[OR]
						 </td>
						<td align="left">
						 Category Name : <input class="smalltxt" type="text" name="catename" value="<?=$_REQUEST['catename']?>" size="20">[OR]
						</td>
						</td>
						<td align="left">
						 Subject : <input class="smalltxt" type="text" name="sub" value="<?=$_REQUEST['sub']?>" size="20">
						  <input class="smalltxt" type="submit" name="search_id_submit" value="Search" >	
						</td>
					</tr>
				</table>
			</form>
				<?
				$select = "select count(*) as cnt from " . $tbl['mailer']." where DelFlag =0";

				if ( $_REQUEST['search_id_submit'] == 'Search' ) {
					if ( $_REQUEST['cate'] != '' ) {
						$select .= " and Category = '".$_REQUEST['cate']."'";
						
					}
					if ( $_REQUEST['catename'] != '' ) {
					$select .= " and CategoryName like '".$_REQUEST['catename']."%' ";
						
					}
					if ( $_REQUEST['sub'] != '' ) {
						$select .= " and Subject like '".$_REQUEST['sub']."%' ";
						
					}

				}
				$res = mysql_query($select);
				$row1 = mysql_fetch_array ($res);
				$total_count = $row1['cnt'];

				include "paging.php";						// Paging file include
				$select = "select id,CreatedDate,Category,CategoryName,EmailFrom,Subject,BodyContent,Comment,ValidFlag from " . $tbl['mailer']." where DelFlag =0";
				if ( $_REQUEST['search_id_submit'] == 'Search' ) {
					if ( $_REQUEST['cate'] != '' ) {
						$select .= " and Category = '".$_REQUEST['cate']."'";
					}
					if ( $_REQUEST['catename'] != '' ) {
					$select .= " and CategoryName like '".$_REQUEST['catename']."%' ";
					}
					if ( $_REQUEST['sub'] != '' ) {
						$select .= " and Subject like '".$_REQUEST['sub']."%' ";
					}
				}
				$select .= " order by id desc  limit $start_value, $record_count "; 	
				$res = mysql_query($select);
				?>

				<table class="smalltxt" border=0 align=center cellpadding=1 cellspacing=1 >
				<tr bgcolor="#B4B2AF">
					<td class=title colspan=10 align=center>
						<table class="smalltxt" border=0 width=100% align=center cellpadding=1 cellspacing=1 >
						<tr bgcolor="FF6000">
							<td class=white align=left>Mailer Details</td>
							<td class=white align=center>Total Count - <?=$total_count?></td>
							<td class=white align=right><a class=white href="email_template.php"> Add New </a> </td>
						</tr>
						</table>
					</td>
				</tr>
				<tr bgcolor="#B4B2AF">
					<td class=title colspan=10 align=center>
						<table class="smalltxt" border=0 width=100% align=center cellpadding=1 cellspacing=1 >
						<tr bgcolor="#B4B2AF">
							<td class=title align=center>
							<?
								echo "Page : $page of $no_of_pages &nbsp;&nbsp; ";
								for ( $i=1;$i<=$no_of_pages;$i++ ) {
									echo "<a href='email_template.php?page=$i'>$i</a> &nbsp;";
								}
							?>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr bgcolor="#CECECE">
					<td class="title">Id</td>
					<td class="title">Date</td>
					<td class="title">Category</td>
					<td class="title">Category Name</td>
					<td class="title">From</td>
					<td class="title">View</td>
					<td class="title">Edit</td>
					<td class="title">Copy</td>
					<td class="title">Delete</td>
				</tr>
				<?php
				while ( $row = mysql_fetch_array ($res) ) {
				?>
				<tr bgcolor="#CECECE">
					<td><?=$row['id']?></td>
					<td><?=DateTimeStamp($row['CreatedDate'])?></td>
					<td><?=$row['Category']?></td>
					<td><?=$row['CategoryName']?></td>
					<td><?=$row['EmailFrom']?></td>
					<td align=center><a href="#" onclick="javascript: window.open('gettemplate.php?catg=<?=$row['Category']?>','viewbanner');"><img alt="View Banner" src="images/lens.jpg" border=0></a></td>
					<td> <a href="email_template.php?opr=edit&id=<?=$row['id']?>"><img border=0 style="cursor:hand" src="images/button_edit.png" name="edit" value=" Edit "></a> </td>
					<td> <a href="email_template.php?opr=copy&id=<?=$row['id']?>"><img border=0 style="cursor:hand" src="images/copy.gif" name="copy" value="Copy"></a> </td>
					<td><a href="email_template.php?opr=del&id=<?=$row['id']?>" ><img style="cursor:hand" border=0 src="images/button_drop.png" style="text-decoration:none;cursor:hand" name="del" value="Delete" ></a></td>
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