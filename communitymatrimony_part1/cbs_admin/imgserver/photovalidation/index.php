<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 04-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		:
#================================================================================================================
   # Description	: This file used to add the cropped photo of the user.
#================================================================================================================

// FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath."/www/admin1/includes/userLoginCheck.php");

?>
<style type="text/css"> @import url("<?=$confValues['CSSPATH'];?>/global-style.css"); </style>
<script>

function managephoto(){
	if (trim(document.form1.MATRIID.value) == 0)
	{alert('Please give the Member ID');return false;}
	var url;
	url= varConfArr['domainimage']+'/admin1/photovalidation/adminmanagephoto.php';
	document.form1.action=url;
	document.form1.submit();
}

function trimold(stringToTrim)
{return stringToTrim.replace(/^\s+|\s+$/g,"");}

function trim(str){
	str = str.replace(/^\s+/, '');
	for (var i = str.length - 1; i >= 0; i--){
		if (/\S/.test(str.charAt(i))){str = str.substring(0, i + 1);break;}
	}return str;
}

function passitems(){
	if (trim(document.form1.membership.value) == '')
	{alert('Please select Membership');return false;}
	if (trim(document.form1.gender.value) == 'ALL')
	{alert('Please select Gender');return false;}
	var url;		url=varConfArr['domainimage']+'/admin1/photovalidation/photoadmin.php?entrytype='+document.form1.membership.value+'&gender='+document.form1.gender.value+'&startsFrom='+document.form1.startsFrom.value;
	document.location.href=url;
}
function validateID(){
	if (trim(document.form1.ID.value) == '')
	{alert('Please give the MemberID');return false;}
	url= varConfArr['domainimage']+'/admin1/photovalidation/newphotovalidation.php';
	document.form1.action=url;
	document.form1.submit();
}
</script>

<?
	include_once("adminheader.php");
?>
<style type="text/css"> @import url("<?=$confValues['CSSPATH'];?>/global-style.css"); </style>
<div style="width:90%;padding-left:60px;">
<!--  -->
<div id="rndcorner" style="float:left;width:892px;">
	<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
	<div style="padding:6px 10px 6px 10px;">
		<div style="width:auto;text-align:center;">
			<div class="bl">
				<div class="br">
					<div class="tl">
						<div class="tr">
							<div style="clear:both;"></div>
							<div style="text-align:center;">
								<div style="text-align:center;padding:10px 0px 2px 0px !important;">
								<!-- inside content -->
									<!--  -->
									<form name="form1" id="form1" method="POST">
										<table border="0" align="center" cellpadding="0" cellspacing="0" width="450" style="border:1px solid #E0EDC2;">
										<tr><td style="padding-top:16px;padding-left:16px;">
										<table align="left" border="0" align="center" cellpadding="0" cellspacing="3" width="60%">
										<? if ($confUserType =='3' && $_GET['proc']=='add') { ?>
										<tr><td height="6"></td></tr>
										<tr><td class="mediumtxt clr3"><b>Add/ Manage Photo</b></td></tr>
										<tr><td class="smalltxt boldtxt">Member ID:</td>
										<td><input type="text" name="MATRIID" class="inputtext"></td><td align="left" colspan="3"><input type="button" name="button1" class="button" value="Submit" onclick="javascript:managephoto();"></td></tr>
										</td></tr>
										<?
										} else { 
											if($_GET['proc']=='val'){
										?>
										<tr><td colspan="3" class="mediumtxt clr3"><b>Validate Photo</b></td></tr>
										<tr><td class="smalltxt boldtxt">Member ID:</td>
										<td><input type="text" name="ID" class="inputtext" value=""></td><td align="left" colspan="3"><input type="button" name="button1" value="Submit" onclick="javascript:validateID();" class="button"></td></tr>
										<?	} else { ?>
										<tr><td colspan="3" class="mediumtxt clr3"><b>Add/ Manage Photo</b></td></tr>
										<tr><td class="smalltxt boldtxt">Member ID:</td>
										<td><input type="text" name="MATRIID" class="inputtext"></td><td align="left" colspan="3"><input type="button" name="button1" class="button" value="Submit" onclick="javascript:managephoto();"></td></tr>
										</td></tr>
										<? 
											}
										} 
										?>
										</table>
									</form>
									<div style="clear:both;"></div>
								</div><br clear="all">
							</div>
						</div><br clear="all">
					</div>
				</div>
			</div>
		</div>
	</div></div>
</div>