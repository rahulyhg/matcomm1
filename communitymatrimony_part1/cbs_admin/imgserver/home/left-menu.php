<div style="float:left;width:197px;" id="rightnavh"><div style="clear:both;"></div>
<div>
	<div class="upgrade1"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1"></div>
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
								<?php if ($sessUserType ==4 || $sessUserType ==5) { ?>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=view-profile" title='View Profile' class="clr5">&nbsp;View Profile</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>					
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=add-payment" title='Payment' class="mediumtxt clr5">&nbsp;Upgrade profile</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=paymenthistory" title='Payment' target="_blank" class="mediumtxt clr5">&nbsp;View Payment Details</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=view-profile-email" title='Hide / Delete Profile' class="mediumtxt clr5">&nbsp;Username From Email</A></td>
									</tr>
								<?php } else { if ($sessUserType !=3) { ?>
								<?php if ($sessUserType !=1) { ?>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=admin-profile-valid" title='Validate Profiles' class="mediumtxt clr5">&nbsp;Current Validate Profiles</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=Message-view" title='Message View' class="mediumtxt clr5">&nbsp;Message View</A></td>
									</tr>
									 <tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=interest-view" title='Interest View' class="mediumtxt clr5">&nbsp;Interest View</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["IMAGEURL"];?>/admin/photovalidation/index.php" title='Photos' target="_blank" class="mediumtxt clr5">&nbsp;Photos</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["IMAGEURL"];?>/admin/horoscopevalidation/index.php" title='Horoscope' target="_blank" class="mediumtxt clr5">&nbsp;Horoscope</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=phonenotwork" title='Phone Not Working' target="_blank" class="mediumtxt clr5">&nbsp;Phone Not Working</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<?php } if ($sessUserType==1) { ?>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=add-payment" title='Payment' class="mediumtxt clr5">&nbsp;Add Payment</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=paymenthistory" title='Payment' target="_blank" class="mediumtxt clr5">&nbsp;View Payment</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=paymenthistory&edit=true" title='Payment' class="mediumtxt clr5">&nbsp;Update Payment</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=update-validity-period" title='View Deleted Profile' class="mediumtxt clr5">&nbsp;Update Validity Period</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=maxmind-upgrade" title='Upgrade Profile' class="mediumtxt clr5">&nbsp;Upgrade Profile (<b>Maxmind</b>)</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=paymenttracking" title='Upgrade Profile' class="mediumtxt clr5" target="_blank">&nbsp;Payment Tracking (<b>Followups</b>)</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=phone-count" title='Phone Count Related Info' class="mediumtxt clr5">&nbsp;Phone Count</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<?php } if ($sessUserType !=1) { ?>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=view-profile" title='View Profile' class="mediumtxt clr5">&nbsp;View Profile</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=paymenthistory" title='Payment' target="_blank" class="mediumtxt clr5">&nbsp;View Payment Details</A></td>
									</tr>
 									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=modify-profile" title='View Profile' class="mediumtxt clr5">&nbsp;Modify / Edit profile</A></td>
									</tr> 
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=admin-statistics" title='Statistics' class="mediumtxt clr5">&nbsp;Statistics</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=profile-status" title='Hide / Delete Profile' class="mediumtxt clr5">&nbsp;Hide / Delete Profile</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=view-profile-email" title='Hide / Delete Profile' class="mediumtxt clr5">&nbsp;Username From Email</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=view-filter-settings" title='Statistics' class="mediumtxt clr5">&nbsp;View Filter Settings</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=deleted-profile" title='View Deleted Profile' class="mediumtxt clr5">&nbsp;View Deleted Profile</A></td>
									</tr>
<!-- 									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=reset-password" title='View Deleted Profile' class="mediumtxt clr5">&nbsp;Reset Password</A></td>
									</tr> -->
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=phone-count" title='Phone Count Related Info' class="mediumtxt clr5">&nbsp;Phone Count</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
									<tr>
										<td><A href="<?php echo $confValues["ServerURL"];?>/admin/index.php?act=phoneverify" title='Phone Verification' class="mediumtxt clr5">&nbsp;Phone Verification</A></td>
									</tr>
									<tr><td style="border-top:1px solid #FFFFFF"><img src="<?=$confValues['IMGSURL']?>/mm_trans.gif" height="1"></td></tr>
								
									<?php } } } ?>
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