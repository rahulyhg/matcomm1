<?php
#================================================================================================================
   # Author 		: Jeyakumar
   # Date			: 23-Mar-2009
   # Project		: MatrimonyProduct
   # Filename		: horoscopeviewpassword.php
#================================================================================================================
   # Description	: Protect Password UI
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
?>
<!-- include javascript files -->
<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
<script	language=javascript src="<?=$confValues['JSPATH'];?>/ajax.js" ></script>
<script	language=javascript src="<?=$confValues['JSPATH'];?>/viewhoroscope.js"	type="text/javascript"></script> 

<link rel="stylesheet"	href="<?=$confValues['CSSPATH'];?>/global-style.css">
<div id="Photo">	
			<div  class="smalltxt" style="padding-left:10px;">
				<!-- upload Start -->
				<!-- Middle Content -->
				<div style="width:508px;">
					<div style="float:left; width:506px;">
						<div style="padding-left:15px;padding-top:10px;">
						<!-- sub-Contant - Starts -->
							<div style="width:500px;">
								<form method="POST"   name="frmProtectedPassword" onsubmit="funProtectedPassword();return false;">
								<input type=hidden name="frmProtectedPasswordSubmit" value="yes"  >
								<input type=hidden name="ID" value="<?=$_REQUEST['ID'];?>" >
									<div class="mediumtxt boldtxt clr3" style="text-align:left;">Horoscope Protected</div>
				
										<div class="divborder" style="width:470px;">
											
											<div class="smalltxt" style="padding:10px;pading-right:10px;">
											<div class="smalltxt boldtxt">Horoscope of <?=$_REQUEST['UNAME'];?> has been protected</div><br clear="all">
												<div class="smalltxt">To view the horoscope of this member, you require a password. Please enter the password below.<br><?=$varContent;?></div>
												<br clear="all">
																	
												<div style="float:left;" >
													<div class="smalltxt boldtxt" style=";float:left;">Enter horoscope password</div><span id="protecterror" class="errortxt" style="padding-left:10px;"></span><br clear="all">
													<div style="padding-top:7px;" ><?='<input type="password" name="password" size="20" class="inputtext">';?>&nbsp;<input type="submit" value="Submit" class="button" >
													</div><br clear="all">
												</div><br clear="all">	
										</div></div>
										<div class="fright" style="padding-top:5px;padding-right:30px;"></div>
									</div>
								</form>	
							</div>
						<!-- sub-Contant - End -->
						</div><br clear="all">	
					</div>
				</div>		
				<!-- Middle Content -->	
		</div>
</div>