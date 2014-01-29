<?
include "/home/cbsmailmanager/config/config.php";
//include_once "lib/authenticate.php";
include "/home/cbsmailmanager/config/header.php";
$fname = $_GET['fname'];
$type = $_GET['type'];
$submitdate = $_GET['dt'];
$priority = $_GET['pri'];
$subject = $_GET['subject'];

if(isset($_POST['send'])){
	
	$otherlist_filename = "/home/cbsmailmanager/mlistfiles/otherstest_".date('dMy').".txt";
	$textfilehandle = fopen($otherlist_filename, 'w+') or die("cannot create file");
	$String ='';
	$Category = $_POST['fname'];
	$Emailhash = explode(',',$_POST['emailhash']);
	foreach($Emailhash as $Email){
		if(emailvalid($Email)){
			$String .= "11,".$Email.",Testmailer,T111444,24,M,testpwd1,2,2009-08-07 11:30:41 \n";
		}
	}
	fwrite($textfilehandle, $String);
	fclose($textfilehandle);
	header("Location:beforetest.php?pri=3&fname=$Category&type=othertest&dt=".date('Y-m-d H:i:s'));
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function validate(){
		var textarea = document.emaillist.emailhash.value;
		if(textarea==''){
			alert(" Provide email ids to send test mail");
			return false;
		}
		else
			return true;
	}
//-->
</SCRIPT>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="780" class="maintborder" bgcolor="#ffffff">
	<tr>

		<td valign="top" width="148"  bgcolor="#E9E9E9">
		<!--Left Menu Start-->		
		<? include "/home/cbsmailmanager/config/leftmenu.php"; ?>
		<!--Left Menu End-->		
		</td>

		<td valign="top" bgcolor=#B5B5B5 class="borderclr"><img src="/images/trans.gif" width="1" height="1"></td>
		<td width="5">&nbsp;</td>
		<td valign="top" width="925" align='left'> <br>
		<FORM METHOD=POST ACTION="" NAME='emaillist'>
			
		<TABLE border='0' width='100%'>
		<TR>
			<TD bgcolor='#E9E9E9' class="title">SEND MAIL TO OTHER EMAIL ID</TD>
		</TR>
		<TR>
			<TD class="smalltxt">Category Name : <?=$fname?> </TD>
		</TR>
		<TR>
			<TD class="smalltxt">Subject : <?=$subject?> </TD>
		</TR>  
		<TR>
			<TD height='20px'></TD>
		</TR> 
		<TR>
			<TD class="title"> Email ids to Send Test Mail: (provide by comma seperated)</TD>
		</TR>  
		<TR>
			<TD><TEXTAREA NAME="emailhash" ROWS="5" COLS="50"></TEXTAREA></TD>
		</TR>  
		<TR>
			<TD class="smalltxt" width='50%'align='left'><INPUT TYPE="hidden" NAME="fname" value='<?=$fname?>'>
			<INPUT TYPE="submit" NAME='send' VALUE='Send' onclick='return validate();'></TD>
		</TR> 
		</TABLE>

		</FORM>
		<!--Middle Area End-->		
		</td></tr>
</table>
   <?  
	include "/home/cbsmailmanager/config/footer.php"; 

	function emailvalid($email)
	{
				if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$email)){
					return '1';
				}
				else{
					return '0';
				}
	}

	?>
	 