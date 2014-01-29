<?php if($varRecordsNumber > 0) {
?><table border="0" width="185px">
	<?php if (($sessUserType =='2') ||(in_array($varPrivelageEmail,$arrPaymentUsers))) {?>
	 <tr>
		<td class="mediumhdtxt" style="padding-left:5px;padding-top:5px;padding-bottom:5px"><a  href="javascript:frmAdminVerifyLogin();"><b>Login Member Profile</b></a></td>
	</tr>
	<?php }?>
	<tr>
		<td class="mediumhdtxt"><b>Member Statistics Details</b></td>
	</tr>
	<tr>
		<td style="padding-left:5px">
			<table border="0" width="185px">
				<tr>
					<td style="padding-left:5px">
						<a	class= "smalltxt bold clr5"
						onclick="window.open('statistics-details.php?MatriId=<?=$varMatriId?>
						&MsgReceiverStatus=1&MsgStatus=4&Msgval=Total','','height=500, width=700, scrollbars=yes');" >Messages Received(<?=assignValue($varTotalMailReceived)?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&MsgReceiverStatus=1&MsgStatus=0','','height=500, width=700, scrollbars=yes');" >
						 Unread Messages(<?=assignValue($varMemberStatsRes['Mail_UnRead_Received'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&MsgReceiverStatus=1&MsgStatus=1','','height=500, width=700, scrollbars=yes');" >Read Messages
						(<?=assignValue($varMemberStatsRes['Mail_Read_Received'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&MsgReceiverStatus=1&MsgStatus=2','','height=500, width=700, scrollbars=yes');" >Replied By Me(<?=assignValue($varMemberStatsRes['Mail_Replied_Received'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&MsgReceiverStatus=1&MsgStatus=3','','height=500, width=700, scrollbars=yes');" >Declined By Me(<?=assignValue($varMemberStatsRes['Mail_Declined_Received'])?>)</a>
					</td>
				</tr>
				<tr><td height="5px"></td></tr>
				<tr>
					<td  style="padding-left:5px">
						<a	class= "smalltxt bold clr5" onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&MsgReceiverStatus=2&MsgStatus=5&Msgval=Total','','height=500, width=700, scrollbars=yes');" >Messages Sent(<?=$varTotalMailSent?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&MsgReceiverStatus=2&MsgStatus=0','','height=500, width=700, scrollbars=yes');" >Unread Messages(<?=assignValue($varMemberStatsRes['Mail_UnRead_Sent'])?>)</a>
					</td>
				</tr>				
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&MsgReceiverStatus=2&MsgStatus=1','','height=500, width=700, scrollbars=yes');" >Read Messages(<?=assignValue($varMemberStatsRes['Mail_Read_Sent'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&MsgReceiverStatus=2&MsgStatus=2','','height=500, width=700, scrollbars=yes');" >Replied By Members(<?=assignValue($varMemberStatsRes['Mail_Replied_Sent'])?>)</a>
					</td>
				</tr>				
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&MsgReceiverStatus=2&MsgStatus=3','','height=500, width=700, scrollbars=yes');" >Declined By Members(<?=assignValue($varMemberStatsRes['Mail_Declined_Sent'])?>)</a>
					</td>
				</tr>

				<tr><td height="5px"></td></tr>
				<tr>
					<td style="padding-left:5px">
					<a	 class= "smalltxt bold clr5" onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&InterestReceiverStatus=1&InterestStatus=6&Msgval=Total','','height=500, width=700, scrollbars=yes');" >	Interests Received(<?=$varTotalInterestReceived?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&InterestReceiverStatus=1&InterestStatus=0','','height=500, width=700, scrollbars=yes');" >Reply Pending (<?=assignValue($varMemberStatsRes['Interest_Pending_Received'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&InterestReceiverStatus=1&InterestStatus=1','','height=500, width=700, scrollbars=yes');" >Accepted By Me(<?=assignValue($varMemberStatsRes['Interest_Accept_Received'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&InterestReceiverStatus=1&InterestStatus=2','','height=500, width=700, scrollbars=yes');" >Declined By Me(<?=assignValue($varMemberStatsRes['Interest_Declined_Received'])?>)</a>
					</td>
				</tr>

				<tr><td height="5px"></td></tr>
				<tr>
					<td  style="padding-left:5px">
						<a	class= "smalltxt bold clr5" onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&InterestReceiverStatus=2&InterestStatus=7&Msgval=Total','','height=500, width=700, scrollbars=yes');" >Interests Sent(<?=assignValue($varTotalInterestSent)?>)
					</td>
				</tr>				
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&InterestReceiverStatus=2&InterestStatus=0','','height=500, width=700, scrollbars=yes');" >Pending Interests(<?=assignValue($varMemberStatsRes['Interest_Pending_Sent'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&InterestReceiverStatus=2&InterestStatus=1','','height=500, width=700, scrollbars=yes');" >Accepted Interests(<?=assignValue($varMemberStatsRes['Interest_Accept_Sent'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&InterestReceiverStatus=2&InterestStatus=2','','height=500, width=700, scrollbars=yes');" >Declined Interests(<?=assignValue($varMemberStatsRes['Interest_Declined_Sent'])?>)</a>
					</td>
				</tr>

				<tr><td height="5px"></td></tr>
				<tr>
					<td class="smalltxt bold" style="padding-left:5px">
						Request Received(<?=assignValue($varTotalReqInfoReceived)?>)
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('requestmade.php?MatriId=<?= $varMatriId ?>&rm=rr&pph=p',
				'','height=500, width=700, scrollbars=yes');" >Photo Requests(<?=assignValue($varReqInfoReceivedRes['Photo'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('requestmade.php?MatriId=<?= $varMatriId ?>&rm=rr&pph=ph',
				'','height=500, width=700, scrollbars=yes');" >Phone Number Requests (<?=assignValue($varReqInfoReceivedRes['Phone'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('requestmade.php?MatriId=<?= $varMatriId ?>&rm=rr&pph=h','','height=500, width=700, scrollbars=yes');" >Horoscope Requests(<?=assignValue($varReqInfoReceivedRes['Horoscope'])?>)</a>
					</td>
				</tr>

				<tr><td height="5px"></td></tr>
				<tr>
					<td class="smalltxt bold" style="padding-left:5px">
						Request Sent(<?=assignValue($varTotalReqInfoSent)?>)
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('requestmade.php?MatriId=<?= $varMatriId ?>&rm=rs&pph=p','','height=500, width=700, scrollbars=yes');" >Photo Requests(<?=assignValue($varReqInfoSentRes['Photo'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('requestmade.php?MatriId=<?= $varMatriId ?>&rm=rs&pph=ph','','height=500, width=700, scrollbars=yes');" >Phone Number Requests(<?=assignValue($varReqInfoSentRes['Phone'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('requestmade.php?MatriId=<?= $varMatriId ?>&rm=rs&pph=h','','height=500, width=700, scrollbars=yes');" >Horoscope Requests(<?=assignValue($varReqInfoSentRes['Horoscope'])?>)</a>
					</td>
				</tr>

				<tr><td height="5px"></td></tr>
				<tr>
					<td class="smalltxt bold" style="padding-left:5px">
						Lists
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&List=1&Records=<?=$varFavoritesCount ?>','','height=500, width=700, scrollbars=yes');" >Favourites(<?=assignValue($varBookMarkInfoRes['COUNT'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('statistics-details.php?MatriId=<?= $varMatriId ?>&List=2&Records=<?=$varBlocksCount ?>','','height=500, width=700, scrollbars=yes');" >Blocked Profiles(<?=assignValue($varBlockInfoRes['COUNT'])?>)</a>
					</td>
				</tr>

				<tr><td height="5px"></td></tr>
				<tr>
					<td class="smalltxt bold" style="padding-left:5px">
						Views
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('viewphone.php?MatriId=<?= $varMatriId ?>&mem=vmem','',
						'height=300,width=450,scrollbars=yes');" >Who Viewed My Phone Number
							(<?=assignValue($varPhoneViewListInfoRes['COUNT'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<a	 onclick="window.open('viewphone.php?MatriId=<?= $varMatriId ?>&mem=bmem','',
						'height=300, width=450,scrollbars=yes');" >Phone Number Viewed By Me(<?=assignValue($varViewedPhoneListByMemberRes['COUNT'])?>)</a>
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						Who Viewed My Profile(<?=assignValue($varMemberStatsRes['ViewedByVisitor'])?>)
					</td>
				</tr>
				<tr><td height="5px"></td></tr>
				<tr>
					<td class="smalltxt bold" style="padding-left:5px">
						Match Watch Email
					</td>
				</tr>
				<tr>
					<td class="smalltxt" style="padding-left:20px">
						<?if($varMatchwatch!=0){?><a href="javascript:;" onclick="window.open('<?=$confValues['SERVERURL']?>/admin/matchwatchinfo.php?id=<?=$varMatriId?>&totmw=<?=$varMatchwatch?>', 'mywindow', 'height=200,width=400,scrollbars=1')">Match Watch Email(<?=assignValue($varMatchwatch)?>)</a><?}else{?>Match Watch Email (<?=assignValue($varMatchwatch)?>)<?}?>
					</td>
				</tr>


			</table>
		</td>
	</tr>
</table>
<?php }
 $varMatriIdPrefix=substr($varMatriId,0,3);
 $varDomainName=$arrPrefixDomainList[$varMatriIdPrefix];
 $varCBSRedirect = 'http://www.'.$varDomainName.'/admin/adminautologin.php';
?>
<script language="javascript">
	function frmAdminVerifyLogin()

	{
		document.frmAdminAutoLogin.submit();
	}//funChooseLogin
</script>
<form name="frmAdminAutoLogin" method="post" target="_blank" action="<?=$varCBSRedirect?>">
<input type="hidden" name="chooseLogin" value="yes">
<input type="hidden" name="frmLoginSubmit" value="yes">
<input type="hidden" name="idEmail" value="<?=$varMatriId?>">
</form>
