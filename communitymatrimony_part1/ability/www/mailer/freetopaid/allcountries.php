<?php
$varTemplate	= '';
$varTemplate	= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><HTML><HEAD><TITLE>'.$varDomainEmail.'</TITLE></HEAD><BODY>
<table width="550" border="0" cellpadding="0" cellspacing="0">
	<tbody>
	<tr><td>
			<table width="550" border="0" cellpadding="0" cellspacing="0">
				<tr><td width="550" background="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/top.jpg" height="68" style="padding-left:30px;"><img src="'.$varLogo.'" width="380" height="40" /></td></tr>
				<tr><td width="550" background="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/head.jpg" height="96"></td></tr>
				<tr><td width="550" background="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/mid1.jpg" height="101"></td></tr>
				<tr><td width="550" background="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/mid2.jpg" height="39" style="padding-left:250px;padding-right:140px;" valign="top"><a rel="nofollow" target="_blank" href="'.$varServerURL.'/payment/index.php?act=payment&pamid='.$varMatriId.'&palead=11"><img src="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/trans.gif" alt="" style="display: block;" width="148" valign="top" border="0" height="37"></a></td></tr>
				<tr><td width="550" background="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/mid3.jpg" height="69"></td></tr>
				<tr><td width="550" valign="top" background="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/txtbg.gif" height="87">
					<table width="485" border="0" cellpadding="0" cellspacing="0" align="center">
						<tbody>
						<tr><td style="text-align:justify;"><font style="font-family: Arial; font-size: 11px; color: rgb(90,90,90);"><b>Dear '.$varName.' ('.$varMatriId.'),</b></font></td></tr>
						<tr><td height="10"></td></tr>
						<tr>
						<td style="text-align:justify;line-height:16px;"><font style="font-family: Arial; font-size: 11px; color: rgb(90,90,90);">You\'re just a step away from finding your life partner. Become a paid member today and enjoy the privileges of contacting members directly.</font></td></tr>
					</table>
					</td>
				</tr>
				<tr><td width="550" background="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/mid4.gif" height="81"></td></tr>
				<tr><td width="550" background="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/mid5.gif" height="59"></td></tr>
				<tr><td width="550" background="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/mid6.gif" height="72"></td></tr>
				<tr><td width="550" background="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/mid7.gif" height="50" style="padding-left:200px;padding-right:170px;" valign="top"><a rel="nofollow" target="_blank" href="'.$varServerURL.'/payment/index.php?act=payment&pamid='.$varMatriId.'&palead=11"><img src="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/trans.gif" alt="" style="display: block;" width="150" valign="top" border="0" height="37"></a></td></tr>
				<tr><td style="padding-left: 20px;" width="550" valign="top" background="http://www.communitymatrimony.com/mailer/freetopaid/img_060110/btm.gif" height="69">
				<table width="510" border="0" cellpadding="0" cellspacing="0" align="center">
					<tbody>
						<tr><td height="10"></td></tr>
							<tr>
							<td style="padding-left:2px;" valign="top"><font style="font-family: Arial; font-size: 11px; color: rgb(90,90,90);">Our warmest wishes,<br><b>'.$varDomainName.'Matrimony Team</b></font></td>
							</tr>
					</tbody>
				</table>
			</td>
			</tr>
			</tbody>
			</table>
			</td></tr>
	</tbody></table>';
$varTemplate	.= '<table width="550" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="padding-left: 4px;padding-top: 3px;"><p><font style="font-family: Arial,MS Sans serif,Arial,Verdana,Helvetica; font-size: 9px; font-style: normal; text-align: justify; text-transform: none; color: rgb(166, 166, 166);">You have received this E-mail because you are a <a target="_blank" href="'.$varServerURL.'/">'.$varDomainName.'Matrimony.com</a> registered member and have elected to receive E-mail notifications whenever someone expresses interest in you through automated messages, mails, etc., If you prefer not to receive this type of E-mail in the future, please <a rel="nofollow" target="_blank" href="'.$varServerURL.'/login/index.php?redirect='.$varServerURL.'/profiledetail/index.php?act=mailsetting"><font color="#a6a6a6"><u>click here</u></font></a> to unsubscribe.</font></p></td></tr></tbody></table></BODY></HTML>';
?>