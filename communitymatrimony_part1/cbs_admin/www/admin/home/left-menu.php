<?php
if($varRootBasePath == '') {
  $varRootBasePath = '/home/product/community';
}
include($varRootBasePath."/www/admin/includes/admin-privilege.cil14");
?>
<div style="float:left;width:197px;" id="rightnavh"><div style="clear:both;"></div>
<div>
	<div class="upgrade3">
			<div style="width:197px; padding-bottom:7px;">
				<div style="margin:0px; " class="rigpanel bigtxt">&nbsp;&nbsp;Control Panel</div>
			</div>
			<div style="margin-left:8px;text-align:left">
				<div class="eg-bar " style="overflow:hidden;border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC;">
					<table width="197" border="0" cellspacing="0" cellpadding="0" align="left">
						<tr>
							<td valign="top" align="center">
								<table width="197" cellspacing="3" cellpadding="1" border="0">
								<?
								$arrManageUsersKeys = array_keys($arrManageUsers);
								if (in_array($adminUserName,$arrManageUsersKeys) && ($adminUserName!='Pooja.Kaura' && $adminUserName!='chandra')) { ?>
									<tr>
										<td class="mediumtxt">Manage Users
										<ul style="padding-left:10px;margin-left:10px;"><li><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=manage-users" title='List Users Profile' class="mediumtxt clr5">&nbsp;List Users</A></li>
										<li><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=manage-users&action=add" title='Add Users' class="mediumtxt clr5">&nbsp;Add Users</A></li>
										<li><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=cbstm_middetails" title='MatriId Followup' class="mediumtxt clr5">&nbsp;Show MatriId Followup</A></li></ul>
										</td>
									</tr>
									<? } ?>
									<? if ($adminUserName=='nazir' || $adminUserName=='admin' || $adminUserName=='Pooja.Kaura' || $adminUserName=='chandra' || $adminUserName=='senthilkumar' || $adminUserName=='pramod'|| $adminUserName=='naresh') { ?>
									<tr>
										<td class="mediumtxt">Report
										<ul style="padding-left:10px;margin-left:10px;">
										<li><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=overallpendingreport" class="mediumtxt clr5">&nbsp;Total Pending Validation</A></li>
										<li><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=photoreport" class="mediumtxt clr5">&nbsp;All Validation</A></li>
										<li><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=timeoutreport" class="mediumtxt clr5">&nbsp;Timeout report</A></li>
										<li><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=validation-log" title='Validation Log' class="mediumtxt clr5">&nbsp;Validation Log</A></li>
										<li><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=adminloginlog" title='AdminLoginLog' class="mediumtxt clr5">&nbsp;Admin Login Log</A></li>
										</ul>
										</td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
								<? } if ($sessUserType =='3' || $sessUserType =='4'||$sessUserType =='6') { ?>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=profile" title='View Profile' class="mediumtxt clr5">&nbsp;View Profile</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<? } if ($sessUserType =='3' || $sessUserType =='4') { ?>
									<tr>
										<td><A href="<? echo $confValues["IMAGEURL"];?>/admin/photovalidation/index.php" title='Photos' target="_blank" class="mediumtxt clr5">&nbsp;Add/Manage Profile Photos</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=paymenthistory" title='Payment' target="_blank" class="mediumtxt clr5">&nbsp;View Payment Details</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=view-profile-email" title='Hide / Delete Profile' class="mediumtxt clr5">&nbsp;MatriId by Phone|Email|BM-ID</A></td>
									</tr>
								<? }  if ($sessUserType =='2') { ?>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=admin-profile-valid&pps=no&ps=yes" title='Validate Profiles' class="mediumtxt clr5">&nbsp;Profiles Count</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td class="mediumtxt"><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=photoreport&individual=yes" title='Message View' class="mediumtxt clr5">&nbsp;My report</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td class="mediumtxt boldtxt">&nbsp;Profile Validation
										<ul style="padding-left:10px;margin-left:10px;">
										<li><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=shuffled_profile_validation" title='Shuffled Profile Validation' class="mediumtxt clr5">&nbsp;Shuffled Profile Validation</A></li>
										<li><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=single_profile_validation" title='Single Profile Validation' class="mediumtxt clr5">&nbsp;Validation by MatriId</A></li>
										</ul>
										</td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td class="mediumtxt boldtxt">&nbsp;Profile Modification
										<ul style="padding-left:10px;margin-left:10px;">
										<li><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=shuffled_profile_modification" title='Shuffled Profile Modification' class="mediumtxt clr5">&nbsp;Shuffled Profile Modification</A></li>
										<li><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=single_profile_modification" title='Single Profile Modification' class="mediumtxt clr5">&nbsp;Modification by MatriId</A></li>
										</ul>
										</td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>	
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=spammsgval" title='Spam Message Validation' class="mediumtxt clr5">&nbsp;Spam Message validation</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=uspaidmsgval" title='NRI Message Validation' class="mediumtxt clr5">&nbsp;NRI Message validation</A></td>
									</tr>
									 <tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td class="mediumtxt boldtxt">&nbsp;Photo Validation
										<ul style="padding-left:10px;margin-left:10px;"><li><A href="<? echo $confValues["ServerURL"];?>/admin/otherframe.php?val=shuffphotoval" target="_blank" class="mediumtxt clr5">Validate Photo</A></li>
										<li><A href="<?=$confValues["ServerURL"];?>/admin/otherframe.php?val=singlephotoval" target="_blank" class="mediumtxt clr5">Validate Photo by MatriId</A></li>
										<li><A href="<?=$confValues["ServerURL"];?>/admin/otherframe.php?val=addphotoval" target="_blank" class="mediumtxt clr5">Add Photo by Single Id</A></li></ul>
										</td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td class="mediumtxt boldtxt">Horoscope Validation
										<ul style="padding-left:10px;margin-left:10px;"><li><A href="<?=$confValues["ServerURL"];?>/admin/otherframe.php?val=shuffhoroval" target="_blank" class="mediumtxt clr5">Validate Horoscope</A></li>
										<li><A href="<?=$confValues["ServerURL"];?>/admin/otherframe.php?val=singlehoroval" target="_blank" class="mediumtxt clr5">Validate Horoscope by <br>MatriId</A></li>
										<li><A href="<?=$confValues["ServerURL"];?>/admin/otherframe.php?val=addhoroval" target="_blank" class="mediumtxt clr5">Add Horoscope by MatriId</A></li></ul>
										</td>

									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=phonesupport" title='Phone Not Working' target="_blank" class="mediumtxt clr5">&nbsp;Phone Not Working</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=message-suspend" title='Member Suspend Info' class="mediumtxt clr5">&nbsp;Member Suspend Info</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<!--<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=phoneview-bymember" title='Phone View By Member' class="mediumtxt clr5">&nbsp;Member Viewed Phone No Info</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr-->		<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=twitter_msg_valid" class="mediumtxt clr5">&nbsp;Validate Twitter Messages</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=profile" title='View Profile' class="mediumtxt clr5">&nbsp;View Profile</A></td>
									</tr>
									<? } if ($sessUserType =='2' || $sessUserType =='6') { ?>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>		
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/paymentassistance/index.php" title='Payment Assistance' class="mediumtxt clr5">&nbsp;Payment Assistance</A></td>
									</tr>
									<? }if ($sessUserType =='2') { ?>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/otherframe.php?val=successvalid" title='Validate Profiles' class="mediumtxt clr5">&nbsp;Success Story Validate</A></td>
									</tr>

									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/otherframe.php?val=successpending" title='Validate Profiles' class="mediumtxt clr5">&nbsp;Pending Success Stories</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/otherframe.php?val=photopending" title='Validate Profiles' class="mediumtxt clr5">&nbsp;Pending Succ.Stories Photos</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=unprotectpassword" title='Validate Profiles' class="mediumtxt clr5">&nbsp;Unprotect Photo Password</A></td>
									</tr>									
									<? } ?>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=logout" title='Logout' class="mediumtxt clr5">&nbsp;Logout</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
								</table>
								<tr><td height="5"></td></tr>
					</table>
				</div>
			</div>
			<div class="upgrade2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1"></div>
	</div>
</div>
</div>
<div style="float:left;width:8px"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="8"></div>