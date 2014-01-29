<style type="text/css"> @import url("<?=$confValues['CSSPATH'];?>/global-style.css"); </style>
<script>

function managehoroscope(){
	if (trim(document.form1.MATRIID.value) == 0)
	{alert('Please give the Member ID');return false;}
	var url;	
	url= varConfArr['domainimage']+'/admin1/horoscopevalidation/adminmanagehoroscope.php';	
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
	var url;		url=varConfArr['domainimage']+'/admin1/horoscopevalidation/horoscopeadmin.php?entrytype='+document.form1.membership.value+'&gender='+document.form1.gender.value;
	document.location.href=url;
}
function validateID(){
	if (trim(document.form1.ID.value) == '')
	{alert('Please give the MemberID');return false;}
	url= varConfArr['domainimage']+'/admin1/horoscopevalidation/newhoroscopevalidation.php';	
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
										<table border="0" align="center" cellpadding="0" cellspacing="0" width="380" style="border:1px solid #E0EDC2;">
										<tr><td style="padding-top:16px;padding-left:16px;">
										<table align="left" border="0" align="center" cellpadding="0" cellspacing="3" width="370">
										<? if($_GET['proc']=='val'){ ?>
										<tr><td colspan="6" class="mediumtxt clr3"><b>Validate Horoscope</b></td></tr>
										<tr><td class="smalltxt boldtxt">Member ID / Username:</td>
										<td><input type="text" name="ID" class="inputtext" value=""></td><td align="left" colspan="3"><input type="button" name="button1" value="Submit" onclick="javascript:validateID();" class="button"></td></tr>
										<tr><td colspan="6">&nbsp;</td></tr>
										<? } else if($_GET['proc']=='add'){ ?>
										<tr><td colspan="6" class="mediumtxt clr3"><b>Add/ Manage Horoscope</b></td></tr>
										<tr><td class="smalltxt boldtxt">Member ID / Username:</td>
										<td><input type="text" name="MATRIID" class="inputtext"></td><td align="left" colspan="3"><input type="button" name="button1" class="button" value="Submit" onclick="javascript:managehoroscope();"></td></tr>
										<tr><td colspan="6">&nbsp;</td></tr>
										<? } ?>
										</table>
										</td></tr>
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