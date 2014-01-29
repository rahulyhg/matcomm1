<?php
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/www/admin/includes/config.php");
include_once($varRootBasePath."/www/admin//includes/clsCommon.php");
include_once($varRootBasePath."/conf/config.cil14");
?>

<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css" />
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/fade.css" />
<script language="JavaScript" src="<?=$confValues['JSPATH']?>/quicktour-slide.js" type="text/javascript"></script>
<script language="JavaScript" src="<?=$confValues['JSPATH']?>/position.js" type="text/javascript"></script>

 <div style="width: 611px; display: block; left: 181.5px; top: 24.6667px;" class="dispdiv" id="dispdiv">
    
	<div id="dispcontent" style="overflow: auto; background-color: #FFFFFF;" class="smalltxt">
		<div style="margin-left: 5px;">
			<div style="background-image: url(<?=$confValues['IMGSURL']?>/quick-mm-bg.gif); background-repeat: no-repeat; width: 601px; height: 438px;">
				<div id="qtslide0" style="position: relative; height: 392px; display: block;">		
					<div style="padding-left: 236px; position: absolute; padding-top: 63px;"><img src="<?=$confValues['IMGSURL']?>/quick-mm-model.jpg" width="361" height="329" alt="" /></div>

					<div style="padding: 15px 0px 0px 25px; position: absolute;">			
						<img src="<?=$confValues['IMGSURL']?>/quick-mm-logo.gif" alt="" border="0" width="170" height="62">
						<div style="padding-top: 15px;font-size:19px;" class="clr11">Welcome to <?=$confValues['PRODUCTNAME']?></div>
						<div class="smalltxt" style="padding-top: 2px;line-height:13px;">The Quick Tour will help you understand how<br> to use our site better</div>			
						<div style="padding: 25px 0px 0px 10px;">
							<div class="mediumtxt boldtxt" style="padding: 2px 0px 0px 5px; background-image: url(<?=$confValues['IMGSURL']?>/qtnug-num-bg.gif); background-repeat: no-repeat; height: 19px;"><i>1</i> <a href="javascript:;" onclick="qtpnumtab('qtslide1', '7')" class="clr1" style="padding-left: 10px;">FREE Registration</a></div>
							<div class="vdotline1" style="margin: 2px 0px; width: 170px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>

							<div class="mediumtxt boldtxt" style="padding: 2px 0px 0px 5px; background-image: url(<?=$confValues['IMGSURL']?>/qtnug-num-bg.gif); background-repeat: no-repeat;"><i>2</i> <a href="javascript:;" onclick="qtpnumtab('qtslide2', '7')" class="clr1" style="padding-left: 10px;">Profile Completion</a></div>
							
							<div class="vdotline1" style="margin: 2px 0px; width: 170px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
							<div class="mediumtxt boldtxt" style="padding: 2px 0px 0px 5px; background-image: url(<?=$confValues['IMGSURL']?>/qtnug-num-bg.gif); background-repeat: no-repeat;"><i>3</i> <a href="javascript:;" onclick="qtpnumtab('qtslide3', '7')" class="clr1" style="padding-left: 10px;">Partner Search</a></div>

							<div class="vdotline1" style="margin: 2px 0px; width: 170px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
							<div class="mediumtxt boldtxt" style="padding: 1px 0px 0px 5px; background-image: url(<?=$confValues['IMGSURL']?>/qtnug-num-bg.gif); background-repeat: no-repeat;"><i>4</i> <a href="javascript:;" onclick="qtpnumtab('qtslide4', '7')" class="clr1" style="padding-left: 10px;">Contact Options - Free</a></div>
							<div class="vdotline1" style="margin: 2px 0px; width: 170px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
							<div class="mediumtxt boldtxt" style="padding: 2px 0px 0px 5px; background-image: url(<?=$confValues['IMGSURL']?>/qtnug-num-bg.gif); background-repeat: no-repeat;"><i>5</i> <a href="javascript:;" onclick="qtpnumtab('qtslide5', '7')" class="clr1" style="padding-left: 10px;">Contact Options - Paid</a></div>
							<div class="vdotline1" style="margin: 2px 0px; width: 170px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
							<div class="mediumtxt boldtxt" style="padding: 2px 0px 0px 5px; background-image: url(<?=$confValues['IMGSURL']?>/qtnug-num-bg.gif); background-repeat: no-repeat;"><i>6</i> <a href="javascript:;" onclick="qtpnumtab('qtslide6', '7')" class="clr1" style="padding-left: 10px;">Managing Responses</a></div>

							<div class="vdotline1" style="margin: 2px 0px; width: 170px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
							<div class="mediumtxt boldtxt" style="padding: 2px 0px 0px 5px; background-image: url(<?=$confValues['IMGSURL']?>/qtnug-num-bg.gif); background-repeat: no-repeat;"><i>7</i> <a href="javascript:;" onclick="qtpnumtab('qtslide7', '7')" class="clr1" style="padding-left: 10px;">Memberships</a></div>
						</div>
					</div>			
				</div>

				<div id="qtslide1" style="position: relative; height: 392px; display: none;">	
					<div style="padding-left: 274px; position: absolute; padding-top: 135px;"><img src="<?=$confValues['IMGSURL']?>/quick-cm-regfree-bg.gif" alt="" border="0" width="322" height="257"></div>
					<div style="padding: 25px 0px 0px 25px; position: absolute;">			
						<div style="font-size:19px;" class="clr11">FREE Registration</div>
						<div class="content" style="padding: 15px 0px 0px 3px;">Registration is free, simple and takes only a few minutes of your time. During registration we collect only the <br>necessary details required for you to find a match.</div>
						<div class="mediumtxt boldtxt clr12" style="padding-top: 25px;padding-left: 3px;">Why register on <?=$confValues['PRODUCTNAME']?>.com</div>
						<div class="smalltxt content" style="padding-top: 5px;padding-left: 3px;"><img src="<?=$confValues['IMGSURL']?>/hp-arrow.gif" alt="" border="0" vspace="1" width="3" height="6" hspace="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="8" height="6">Search over 1.1 Million active Profiles</div>

						<div class="smalltxt content" style="padding-top: 3px;padding-left: 3px;"><img src="<?=$confValues['IMGSURL']?>/hp-arrow.gif" alt="" border="0" vspace="1" width="3" height="6" hspace="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="8" height="6">World's No.1 <?=$confValues['PRODUCTNAME']?> Portal</div>
						<div class="smalltxt content" style="padding-top: 3px;padding-left: 3px;"><img src="<?=$confValues['IMGSURL']?>/hp-arrow.gif" alt="" border="0" vspace="1" width="3" height="6" hspace="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="8" height="6">Safest <?=$confValues['PRODUCTNAME']?> Portal</div>
						<div class="mediumtxt boldtxt" style="padding-top: 25px;"><a href="<?=$confValues['SERVERURL']?>/register/" class="clr1" target="_blank"><u>Click here to Register</u></a></div>			
					</div>			
				</div>

				<div id="qtslide2" style="position: relative; height: 392px; display: none;">
					<div style="padding: 25px 0px 0px 25px; position: absolute;">			
						<div style="font-size:19px;" class="clr11">Profile Completion</div>
						<div class="content" style="padding: 10px 35px 0px 0px;">To create a complete profile, you can add the following features to your profile which will present a wholesome picture of you to prospects at the same time bringing you the best response. </div>
						<div class="fright" style="padding: 40px 8px 0px 0px;"><img src="<?=$confValues['IMGSURL']?>/qtnug-prof-comp.gif" alt="" border="0" width="496" height="270"></div>
						<br clear="all">			
					</div>			
				</div>

				<div id="qtslide3" style="position: relative; height: 392px; display: none;">	
					<div style="padding-left: 338px; position: absolute; padding-top: 129px;"><img src="<?=$confValues['IMGSURL']?>/qt-regu-search.gif" alt="" border="0" width="259" height="263"></div>
					<div style="padding: 25px 0px 0px 25px; position: absolute;">			
						<div style="font-size:19px;" class="clr11">Partner Search</div>
						<div class="content" style="padding: 10px 15px 20px 0px;">Over 1.1 Million active profiles is a lot to search from! Use our various search options to find that special one for you. From a minimum of 5 basic fields to a maximum of 30 fields you can search based on various paramaters.</div>				
						<div class="fleft" style="padding-top: 5px;"><img src="<?=$confValues['IMGSURL']?>/qtnug-reglsearch-icon.gif" alt="" border="0" width="25" height="24"></div> 
						<div class="fleft content" style="padding: 5px 0px 0px 15px; width: 250px;"><font class="mediumtxt boldtxt clr12">Regular Search</font> - allows you to search on the basic criteria one would look for in a partner.</div> <br clear="all">

						<div class="vdotline1" style="border-top: 10px solid rgb(255, 255, 255); width: 300px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
						<div class="fleft" style="padding-top: 10px;"><img src="<?=$confValues['IMGSURL']?>/qtnug-advsearch-icon.gif" alt="" border="0" width="25" height="32"></div> 
						<div class="fleft content" style="padding: 10px 0px 0px 15px; width: 250px;"><font class="mediumtxt boldtxt clr12">Advanced Search</font> - allows you to search with great detail and helps you get only focused results.</div> <br clear="all">
						<div class="vdotline1" style="border-top: 10px solid rgb(255, 255, 255); width: 300px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
						
						<div class="fleft" style="padding-top: 10px;"><img src="<?=$confValues['IMGSURL']?>/qtnug-memonline-icon.gif" alt="" border="0" width="26" height="25"></div> 
						<div class="fleft content" style="padding: 10px 0px 0px 15px; width: 250px;"><font class="mediumtxt boldtxt clr12">Members Online</font> - helps you locate members who are online at the same time as you. If you're a paid member, you can chat with them instantly.</div> <br clear="all">
						<div class="vdotline1" style="border-top: 10px solid rgb(255, 255, 255); width: 300px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
						<div class="fleft" style="padding-top: 10px;"><img src="<?=$confValues['IMGSURL']?>/qtnug-memid-search-icon.gif" alt="" border="0" width="26" height="22"></div> 
						<div class="fleft content" style="padding: 10px 0px 0px 15px; width: 250px;"><font class="mediumtxt boldtxt clr12">Search by User Name</font> -  takes you to the member's profile directly by entering the user name of the member.</div> <br clear="all">
						<div class="vdotline1" style="border-top: 10px solid rgb(255, 255, 255); width: 300px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
					</div>			
				</div>
				
				<div id="qtslide4" style="height: 392px; display: none;">
					<div style="padding: 25px 0px 0px 20px;">			
						<div style="font-size:19px;" class="clr11">Contact Options - Free</div>
						<div class="mediumtxt boldtxt clr12" style="padding-top: 10px;">Contact options available to all members</div>
						<div class="fleft smalltxt clr13" style="margin-top: 10px; background-image: url(<?=$confValues['IMGSURL']?>/qt-pnkbtn.gif); width: 27px; height: 27px; background-repeat: no-repeat;"><div class="fleft boldtxt" style="padding: 5px 0px 0px 10px;">1</div></div>	
						<div class="fleft smalltxt" style="padding: 5px 0px 0px 5px; margin-top: 10px; width: 540px;"><font class="boldtxt">Express Interest</font> <br>You can send a free Express Interest Message to members with whom you want to initiate contact. These messages are template messages and are ideal for the start. </div><br clear="all">			
						<div class="fright" style="padding: 49px 4px 0px 0px;"><img src="<?=$confValues['IMGSURL']?>/qt-cont-free.gif" alt="" border="0" width="543" height="213"></div><br clear="all">
					</div>			
				</div>

				<div id="qtslide5" style="height: 392px; display: none;">
					<div style="padding: 25px 0px 0px 20px;">			
						<div style="font-size:19px;" class="clr11">Contact Options - Paid</div>
						<div class="mediumtxt boldtxt clr12" style="padding-top: 10px;">Contact options available to paid members</div>

						<div class="fleft smalltxt clr13" style="margin-top: 20px; background-image: url(<?=$confValues['IMGSURL']?>/qt-pnkbtn.gif); width: 27px; height: 27px; background-repeat: no-repeat;"><div class="fleft boldtxt" style="padding: 5px 0px 0px 10px;">1</div></div>	
						<div class="fleft content" style="line-height:12px;word-spacing:-2px;padding: 5px 0px 0px 5px; margin-top: 20px; width: 145px ! important;"><font class="boldtxt">Mail</font> <br>You can send personalised messages&nbsp; to&nbsp; members. </div>	
						<div class="fleft dotline" style="margin: 10px 0px 0px 10px; width: 1px; height: 100px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="100"></div>
						<div class="fleft smalltxt clr13" style="margin: 20px 0px 0px 5px; background-image: url(<?=$confValues['IMGSURL']?>/qt-pnkbtn.gif); width: 27px; height: 27px; background-repeat: no-repeat;"><div class="fleft boldtxt" style="padding: 5px 0px 0px 10px;">2</div></div>	
						<div class="fleft content" style="line-height:12px;word-spacing:-2px;padding: 5px 0px 0px 5px; margin-top: 20px; width: 145px ! important;"><font class="boldtxt">Chat</font> <br>You can chat with members by clicking on the "Online" icon in the&nbsp; search&nbsp; results&nbsp; page.</div>			
						<div class="fleft dotline" style="margin: 10px 0px 0px 10px; width: 1px; height: 100px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="100"></div>
						<div class="fleft smalltxt clr13" style="margin: 20px 0px 0px 5px; background-image: url(<?=$confValues['IMGSURL']?>/qt-pnkbtn.gif); width: 27px; height: 27px; background-repeat: no-repeat;"><div class="fleft boldtxt" style="padding: 5px 0px 0px 10px;">3</div></div>	
						<div class="fleft content" style="line-height:12px;word-spacing:-2px;padding: 5px 0px 0px 5px; margin-top: 20px; width: 145px ! important;"><font class="boldtxt">Phone</font> <br>You can contact members directly&nbsp; through&nbsp; phone.</div>	
						<br clear="all">				
						<div class="fleft" style="padding: 10px 0px 0px 30px;"><img src="<?=$confValues['IMGSURL']?>/qt-cont-paid1.gif" alt="" border="0" width="272" height="203"></div>

						<div class="fleft" style="padding: 10px 5px 0px 0px;"><img src="<?=$confValues['IMGSURL']?>/qt-cont-paid2.gif" alt="" border="0" width="267" height="203"></div>			
					</div>			
				</div>

				<div id="qtslide6" style="position: relative; height: 392px; display: none;">	
					<div style="padding-left: 269px; position: absolute; padding-top: 99px;"><img src="<?=$confValues['IMGSURL']?>/qt-mang-resp.gif" alt="" border="0" width="328" height="293"></div>
					<div style="padding: 25px 0px 0px 25px; position: absolute;">			
						<div style="font-size:19px;" class="clr11">Managing Responses</div>
						<div class="content" style="padding: 10px 65px 10px 0px;">Every time you sign in to your account you will be directly taken to <b>"My Home"</b> where you can manage your entire activities on the site such as: </div>	
						<div class="fleft" style="padding-top: 10px;"><img src="<?=$confValues['IMGSURL']?>/qtnug-personalmsg-icon.gif" alt="" border="0" width="35" height="27"></div> 
						<div class="fleft content" style="padding: 5px 0px 0px 15px; width: 190px;"><font class="mediumtxt boldtxt clr12">Personalised Messages </font> <br>- Sent & received</div> <br clear="all">
						<div class="vdotline1" style="border-top: 5px solid rgb(255, 255, 255); width: 230px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
						<div class="fleft" style="padding-top: 5px;"><img src="<?=$confValues['IMGSURL']?>/qtnug-expint-icon.gif" alt="" border="0" width="32" height="26"></div> 
						<div class="fleft content" style="padding: 5px 0px 0px 15px; width: 190px;"><font class="mediumtxt boldtxt clr12">Expression of Interests</font> <br>- Sent & received.</div> <br clear="all">
						<div class="vdotline1" style="border-top: 5px solid rgb(255, 255, 255); width: 230px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
						<div class="fleft" style="padding-top: 5px;"><img src="<?=$confValues['IMGSURL']?>/qtnug-request-icon.gif" alt="" border="0" width="31" height="30"></div> 
						<div class="fleft content" style="padding: 10px 0px 0px 15px; width: 190px;"><font class="mediumtxt boldtxt clr12">Requests</font> - Sent & received</div> <br clear="all">
						<div class="vdotline1" style="border-top: 5px solid rgb(255, 255, 255); width: 230px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
						<div class="fleft" style="padding-top: 5px;"><img src="<?=$confValues['IMGSURL']?>/qtnug-lists-icon.gif" alt="" border="0" width="23" height="20"></div> 
						<div class="fleft content" style="padding: 5px 0px 0px 25px; width: 190px;"><font class="mediumtxt boldtxt clr12">Lists</font> - Members you have shortlisted, ignored and blocked</div> <br clear="all">
						<div class="vdotline1" style="border-top: 5px solid rgb(255, 255, 255); width: 230px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
						<div class="fleft" style="padding-top: 5px;"><img src="<?=$confValues['IMGSURL']?>/qtnug-views-icon.gif" alt="" border="0" width="29" height="26"></div> 
						<div class="fleft content" style="padding: 5px 0px 0px 20px; width: 190px;line-height:14px;"><font class="mediumtxt boldtxt clr12">Views</font> - Members who viewed your phone number and your profile views</div> <br clear="all">
						<div class="vdotline1" style="border-top: 5px solid rgb(255, 255, 255); width: 230px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
						<div class="fleft" style="padding-top: 5px;"><img src="<?=$confValues['IMGSURL']?>/qtnug-mwatch-icon.gif" alt="" border="0" width="25" height="27"></div> 
						<div class="fleft content" style="padding: 5px 0px 0px 25px; width: 190px;line-height:14px;"><font class="mediumtxt boldtxt clr12">MatchWatch</font> - Profiles you're looking for, profiles looking for you and mutual matches</div> <br clear="all">
						<div class="vdotline1" style="border-top: 5px solid rgb(255, 255, 255); width: 230px; height: 1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" border="0" width="1" height="1"></div>
								
					</div>			
				</div>

				<div id="qtslide7" style="position: relative; height: 392px; display: none;">	
					<div style="padding-left: 310px; position: absolute; padding-top: 18px;"><img src="<?=$confValues['IMGSURL']?>/qt-paymnt1.gif" alt="" border="0" width="287" height="182"><img src="<?=$confValues['IMGSURL']?>/qt-paymnt2.gif" alt="" border="0" width="287" height="192"></div>
					<div style="padding: 25px 0px 0px 25px; position: absolute;">			
						<div style="font-size:19px;" class="clr11">Memberships</div>
						<div class="mediumtxt boldtxt clr12" style="padding-top: 10px;">Why become a Paid Member?</div>
						<div class="smalltxt boldtxt" style="padding-top: 5px;">As a paid member you can:</div>
						<div class="fleft" style="padding: 10px 5px 0px 0px;"><img src="<?=$confValues['IMGSURL']?>/hp-arrow.gif" alt="" border="0" width="3" height="6"></div>

						<div class="fleft smalltxt" style="padding-top: 5px;">Access phone numbers</div><br clear="all">
						<div class="fleft" style="padding: 10px 5px 0px 0px;"><img src="<?=$confValues['IMGSURL']?>/hp-arrow.gif" alt="" border="0" width="3" height="6"></div>
						<div class="fleft smalltxt" style="padding-top: 5px;">Send and receive personalised e-mail messages</div><br clear="all">
						<div class="fleft" style="padding: 10px 5px 0px 0px;"><img src="<?=$confValues['IMGSURL']?>/hp-arrow.gif" alt="" border="0" width="3" height="6"></div>
						<div class="fleft smalltxt" style="padding-top: 5px;">Chat with prospects</div><br clear="all">
						
						<div class="smalltxt" style="padding: 5px 0px 0px 8px;">And much more benefits...</div>
						<div class="mediumtxt boldtxt clr12" style="padding-top: 15px;">Membership Schemes</div>			
						<div class="content" style="width: 240px; padding-top: 5px;line-height:12px;word-spacing:-1px;">We have various membership schemes to suit your convenience.</div>
						<div class="mediumtxt boldtxt clr12" style="padding-top: 15px;">Payment Options</div>
						<div style="padding-top: 4px;"><a href="<?=$confValues['SERVERURL']?>/payment/" target="_blank"><font class="smalltxt boldtxt clr1">Online payment</font> - <font class="content">Almost all cards accepted.</font></a></div>			
						<div style="width: 240px; padding-top: 4px;"><a href="<?=$confValues['SERVERURL']?>/payment/" target="_blank"><font class="smalltxt boldtxt clr1">Cheques and Demand Drafts</a></font></div>
												 
					</div>			
				</div>

				<div class="fleft">
					<div class="fleft smalltxt" style="width:160px;padding-left: 10px;">
						<div id="pnumoff0" class="fleft clr4 pntr" onclick="javascript:qtpnumtab('qtslide0', '6')" style="text-align: center;">&nbsp;</div>
						<div id="pnumon0" class="fleft clr4 pntr" style="text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-off-bg.gif); width: 15px; height: 18px; display: none;">0</div>
						<div id="pnumoff1" class="fleft clr4 pntr" onclick="javascript:qtpnumtab('qtslide1', '7')" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-off-bg.gif); width: 15px; height: 18px; display: none;">1</div>
						<div id="pnumon1" class="fleft clr6" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-on-bg.gif); width: 15px; height: 18px; display: none;">1</div>
						<div id="pnumoff2" class="fleft clr4 pntr" onclick="javascript:qtpnumtab('qtslide2', '7')" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-off-bg.gif); width: 15px; height: 18px; display: none;">2</div>
						<div id="pnumon2" class="fleft clr6" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-on-bg.gif); width: 15px; height: 18px; display: none;">2</div>
						
						<div id="pnumoff3" class="fleft clr4 pntr" onclick="javascript:qtpnumtab('qtslide3', '7')" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-off-bg.gif); width: 15px; height: 18px; display: none;">3</div>
						<div id="pnumon3" class="fleft clr6" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-on-bg.gif); width: 15px; height: 18px; display: none;">3</div>
						<div id="pnumoff4" class="fleft clr4 pntr" onclick="javascript:qtpnumtab('qtslide4', '7')" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-off-bg.gif); width: 15px; height: 18px; display: none;">4</div>

						<div id="pnumon4" class="fleft clr6" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-on-bg.gif); width: 15px; height: 18px; display: none;">4</div>
						<div id="pnumoff5" class="fleft clr4 pntr" onclick="javascript:qtpnumtab('qtslide5', '7')" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-off-bg.gif); width: 15px; height: 18px; display: none;">5</div>
						<div id="pnumon5" class="fleft clr6" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-on-bg.gif); width: 15px; height: 18px; display: none;">5</div>
						<div id="pnumoff6" class="fleft clr4 pntr" onclick="javascript:qtpnumtab('qtslide6', '7')" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-off-bg.gif); width: 15px; height: 18px; display: none;">6</div>
						<div id="pnumon6" class="fleft clr6" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-on-bg.gif); width: 15px; height: 18px; display: none;">6</div>
						<div id="pnumoff7" class="fleft clr4 pntr" onclick="javascript:qtpnumtab('qtslide7', '7')" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-off-bg.gif); width: 15px; height: 18px; display: none;">7</div>

						<div id="pnumon7" class="fleft clr6" style="margin-left: 5px; text-align: center; background-image: url(<?=$confValues['IMGSURL']?>/qt-on-bg.gif); width: 15px; height: 18px; display: none;">7</div>
					</div>
					
					<div class="fright" style="width:415px;padding: 7px 0px 0px 10px;">
						<div id="backbutton" class="fleft" style="display: none;padding-left:265px;"><a href="javascript:;" onclick="qtclickbutton('prev', '7');"><img src="<?=$confValues['IMGSURL']?>/quick-cm-backbutton.gif" alt="" border="0" width="64" height="30"></a></div>
						<div id="nextbutton" class="fright" style="display: block;padding-right:10px;"><a href="javascript:;" onclick="qtclickbutton('nxt', '7');"><img src="<?=$confValues['IMGSURL']?>/quick-cm-nextbutton.gif" alt="" border="0" width="64" height="31"></a></div>
					</div>
				</div>
			</div>
		</div>
	 </div>
 </div>
 

