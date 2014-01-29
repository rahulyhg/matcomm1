<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 04-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: 
#================================================================================================================
   # Description	: This file used to add the cropped photo of the user.
#================================================================================================================
?>

<style type="text/css"> @import url("<?=$confValues['CSSPATH'];?>/global-style.css"); </style>
<script>

function managephoto(){
	if (trim(document.form1.MATRIID.value) == 0)
	{alert('Please give the Member ID');return false;}
	var url;	
	url= varConfArr['domainimage']+'/admin/photovalidation/adminmanagephoto.php';	
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
	var url;		url=varConfArr['domainimage']+'/admin/photovalidation/photoadmin.php?entrytype='+document.form1.membership.value+'&gender='+document.form1.gender.value;
	document.location.href=url;
}
function validateID(){
	if (trim(document.form1.ID.value) == '')
	{alert('Please give the MemberID');return false;}
	url= varConfArr['domainimage']+'/admin/photovalidation/singlephotovalidation.php';	
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
										<table border="0" align="center" cellpadding="0" cellspacing="0" width="845" style="border:1px solid #E0EDC2;">
										<tr><td style="padding-top:16px;padding-left:16px;">
										<table align="left" border="0" align="center" cellpadding="0" cellspacing="3" width="845">
										<tr><td colspan="6"class="mediumtxt clr3"><b>Validate Photo</b></td></tr>
										<tr><td class="smalltxt boldtxt">
										Membership:
										</td>
										<td>
										<SELECT style="font-family: Verdana, sans-serif;font-size : 8pt" NAME="membership">
											<OPTION value=""> - Select - </OPTION>
											<OPTION value="F" <? if (isset($_GET['entrytype']) && trim($_GET['entrytype'])=='F'){echo 'selected';} ?>>Free Member </OPTION>
											<OPTION value="R" <? if (isset($_GET['entrytype']) && trim($_GET['entrytype'])=='R'){echo 'selected';} ?>>Paid Member </OPTION>
											<OPTION value="ALL">Both</OPTION>

										</SELECT>
										</td>
										<td class="smalltxt boldtxt">Gender:</td>
										<td><SELECT style="font-family: Verdana, sans-serif;font-size : 8pt" NAME="gender">
											<OPTION value="ALL"> - Select - </OPTION>
											<OPTION value="M" <? if (isset($_GET['gender']) && trim($_GET['gender'])=='M'){echo 'selected';} ?>>Male Profile </OPTION>
											<OPTION value="F" <? if (isset($_GET['gender']) && trim($_GET['gender'])=='F'){echo 'selected';} ?>>Female Profile</OPTION> 
										</SELECT></td><td align="left"><input type="button" name="button1" value="Submit"   class="button" onclick="javascript:passitems();"></td><td width="333">&nbsp;</td></tr>
										<tr><td colspan="6">&nbsp;</td></tr>
										<tr><td colspan="6"><hr></td></tr>
										<tr><td colspan="6" height="6"></td></tr>
										<tr><td colspan="6" class="mediumtxt clr3"><b>Validate Photo</b></td></tr>
										<tr><td class="smalltxt boldtxt">Member ID:</td>
										<td><input type="text" name="ID" class="inputtext" value=""></td><td align="left" colspan="3"><input type="button" name="button1" value="Submit" onclick="javascript:validateID();" class="button"></td></tr>
										<tr><td colspan="6">&nbsp;</td></tr>
										<tr><td colspan="6"><hr></td></tr>
										<tr><td colspan="6" height="6"></td></tr>
										<tr><td colspan="6" class="mediumtxt clr3"><b>Add/ Manage Photo</b></td></tr>
										<tr><td class="smalltxt boldtxt">Member ID:</td>
										<td><input type="text" name="MATRIID" class="inputtext"></td><td align="left" colspan="3"><input type="button" name="button1" class="button" value="Submit" onclick="javascript:managephoto();"></td></tr>
										</td></tr>
										</table>
									</form>
									<div style="clear:both;"></div>
							

<!-- inside content -->
								</div><br clear="all">
							</div>		
						</div><br clear="all">
					</div>
				</div>
			</div>
		</div>
	</div></div>
	<!-- <b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b> -->
<!--  -->
</div>