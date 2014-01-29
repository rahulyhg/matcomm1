<?php
#====================================================================================================
# Author 		: S Rohini
# Start Date	: 19  Sep 2008
# End Date	: 19  Sep 2008
# Project		: MatrimonyProduct
# Module		: Success Story 
#====================================================================================================
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootPath			= $_SERVER['DOCUMENT_ROOT'];

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/lib/clsSuccessMailer.php");
include_once($varRootBasePath."/lib/clsDB.php");
//Variable Declaration
$varPagePost			= $_REQUEST['postpg'];
$varSessionId			= $varGetCookieInfo['MATRIID'];
$objDb						= new DB;
$objSuccess				= new SuccessMailer;
$objSuccess->dbConnect('S', $varDbInfo['DATABASE']);
$objDb->dbConnect('M', $varDbInfo['DATABASE']);
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/fade.css" />
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractions-sprites.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractivity-sprites.css">
<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/successstory.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/menutabber.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<?
if($_REQUEST['frmSuccessSubmit']=='yes')
{
	echo "<script>clickTab(2,2,'success')</script>";
	$varCurrentDate	= date("Y-m-d");
	$varBrideName	 	= trim($_REQUEST["bridename"]);
	$varGroomName	= trim($_REQUEST["groomname"]);
	$varUsername		= trim($_REQUEST["matid"]);
	$varEmail				= trim($_REQUEST["matEmail"]);
	$varMarriageDate= trim($_REQUEST["marrdate"]);
	$varContAddr		= trim($_REQUEST["succaddress"]);
	$varTelNum			= trim($_REQUEST["succtel"]);	
	$varStory				= trim($_REQUEST["succStory"]);
	$varAttachPhoto	= trim($_REQUEST["succphoto"]);
	$varFileType			= explode(".",$_FILES['succphoto']['name']);
	$varFileName		= $varUsername."_SUCCESS.".$varFileType[1];
	$varFromId			= $varEmail;
	
	// To insert into Successstory table
	$varSuccFlds			= array('MatriId','User_Name','Bride_Name','Groom_Name','Email','Marriage_Date','Success_Message','Telephone','Contact_Address','Publish','Date_Updated');
	$varSuccFldVal		= array("'".$varSessionId."'","'".$varUsername."'","'".$varBrideName."'","'".$varGroomName."'","'".$varEmail."'","'".$varMarriageDate."'","'".$varStory."'","'".$varTelNum."'","'".$varContAddr."'",0,"'".$varCurrentDate."'");
	$varInsId				= $objDb->insert($varTable['SUCCESSSTORYINFO'],$varSuccFlds,$varSuccFldVal);
	$varTargetPath		= $varRootPath."/success/photos/".date("Y")."/tmp/".$varFileName;
	//echo '<pre>'; print_r($_FILES); echo '</pre>';
	
	$varToId				= $confValues['SUCCESSEMAIL']; 
	$varToCC				= $confValues['SUCCSUPMAIL']; 

	$varSubject			= "Success Story";
	$varMessage			= "<font face=Arial size=2><b>Groom : </b>".$varGroomName."<br><br><b>Bride : </b>".$varBrideName."<br><br><b>Username </b>: ".$varUsername."<br><br><b>Marriage Date : </b>".$varMarriageDate."<br><br><b>Success Story : </b>".$varStory."<br><br><b>Submitted on : </b>".$varCurrentDate."<br></font>";
	//echo '<pre>'; print_r($_FILES); echo '</pre>';
	if($_FILES['succphoto']['error']=='') {
		$varSendRes = $objSuccess->sendMailAttach($varFromId, $varToId, $varToCC, $varSubject, $varMessage, $_FILES['succphoto'],$varFileName);
	} else {
		$varSendRes = $objSuccess->sendEmail($varFromId,$varFromId,$varToId,$varToId,$varSubject,$varMessage,$varFromId);
	}


	if(move_uploaded_file($_FILES['succphoto']['tmp_name'], $varTargetPath) === true)
	{
		$varPhotoUploaded = 1;
	}
	if($varPhotoUploaded == 1) // Photo Upload check... 
	{
		$varPhoStatus = 1;
		$varPhotoURL = $varFileName;
	} 
	else 
	{
		$varPhoStatus = 0;
	}
	$varSuccUpFlds	= array('Photo','Photo_Set_Status');
	$varSucUpFldVal	= array("'".$varPhotoURL."'","'".$varPhoStatus."'");
	$varSucCond			= " Success_Id=".$varInsId;
	$varUpSucc			= $objDb->update($varTable['SUCCESSSTORYINFO'],$varSuccUpFlds,$varSucUpFldVal,$varSucCond);
	
	$varFrom2			= $confValues['INFOEMAIL'];
	$varSubject2			= "Congratulations ".$varUsername;
	$varMessage2		= "<font face=Arial size=2>Dear Member,<br><br>Thank you for submitting the Success Story. We wish the bride and groom a very happy and prosperous life together. Please make sure to delete your profile by logging into your account and clicking on the 'Delete Profile' option.<br><br>Warm Regards,<br>".$confValues['PRODUCTNAME'].".com Family<br><br></font>";
	$varSendRes2 = $objSuccess->sendEmail($varFrom2,$varFrom2,$varEmail,$varEmail,$varSubject2,$varMessage2,$varFrom2);
	$varFrom3			= $confValues['WEMASTERMAIL'];
	$varSubject3			= "Success Story Contact details";
	$varMessage3		= "<font face=Arial size=2><b>Username </b>:".$varUsername."<br><br><b>Address : </b>".$varContAddr."<br><br><b>Phone no. : </b>".$varTelNum."<br><br>Warm Regards,<br>".$confValues['PRODUCTNAME'].".com Family<br><br></font>";
	$varToCC = '';
	$varSendRes3 = $objSuccess->sendEmailwithCC($varFrom3,$varToId,$varSubject3,$varMessage3,$varFrom3,$varToCC,'');
	$varDisplayMsg	= '<div>Now that you have found your life partner, why don\'t you recommend '.$confValues['PRODUCTNAME'].' to your relatives, friends and colleagues and help them in their partner search.<br><br><font class="smalltxt boldtxt">Please enter the names and e-mail IDs of the persons to whom you would like to refer our site.</font><br></div><br clear="all"><div class="normalrow"><div class="smalltxt"><form name="frmEmailFwd" method="post" onSubmit="return emailFwdvalidate();"><input type="hidden" name="frmEmailFwdSubmit" value="yes"><input type="hidden" value="'.$varBrideName.'" name="bridevalue"><input type="hidden" value="'.$varGroomName.'" name="groomvalue">';
	for($i=1;$i<=5;$i++)
	{
		$varDisplayMsg .= '<div style="padding-bottom:10px;"><div class="fleft mediumtxt2 bold" style="width:235px;"><span id="emailerrmsgnam'.$i.'" class="errortxt"></span><br>Name&nbsp;<br><input type=text name="frndname'.$i.'" size=40 class="inputtext"></div><div class="fleft mediumtxt2 bold" style="padding:0px 0px 10px 5px;"><span id="emailerrmsgemail'.$i.'" class="errortxt"></span><br>E-mail ID&nbsp;<br><input type=text name="frndemail'.$i.'" size=40 class="inputtext"></div></div><br clear="all">';
	}
	$varDisplayMsg		.= '<div class="fright" style="padding-right:16px;"><input type="submit" class="button" value="Submit"></div><br clear="all"></form></div></div>';
}
if($_REQUEST['frmEmailFwdSubmit']=='yes')
{
	echo "<script>clickTab(2,2,'success')</script>";
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';

	$varBride				= $_REQUEST['bridevalue'];
	$varGroom			= $_REQUEST['groomvalue'];
	for($j=1;$j<=5;$j++)
	{
		$varFrndName	= $_REQUEST['frndname'.$j];
		if($varFrndName!='')
		{
			$varFrndMail		= $_REQUEST['frndemail'.$j];
			$retMailer = $objSuccess->referFriendMail($varBride,$varGroom,$varFrndMail,$varFrndName);
			$varNumCond	= " where Email='".$varFrndMail."' and MemberStatus=12";
			$varResult = $objSuccess->numOfRecords($varTable['MAILERPROFILE'],'User_Name',$varNumCond);
			if($varResult==0){
				$varMailFlds		= array('Id','User_Name','Email','Name','MemberStatus');
				$varMailFldVal	= array("'".$varSessionId."'","'".$varUsername."'","'".$varFrndMail."'","'".$varFrndName."'",12);
				$objDb->insert($varTable['MAILERPROFILE'],$varMailFlds,$varMailFldVal);
			}//if
		}//if
	}//for
	$varDisplayMsg = 'Thank you for referring '.$confValues['PRODUCTNAME'].' to people whom you know looking for a life partner. We wish you a Happy and Prosperous Married Life!';
}
?>
<div class="fleft">
	<div class="tabcurbg fleft">
	<!--{ tab button none -->
	<?php if($varPagePost==1) { ?> 
		<div id="success1" class="fleft">									
			<div id="successlink1_inactive" class="fleft" style="display:block;">
				<div class="fleft tableft"></div>
				<div class="fleft tabright"><div class="tabpadd"><a href="javascript:void(0)" onclick="clickTab(1,2,'success')" class="mediumtxt1 boldtxt clr3">Success Story</a> </div></div>
			</div>
			<div id="successlink1_active" class="fleft" style="display:none;">
				<div class="fleft tabclrleft"></div>
				<div class="fleft tabclrright"><div class="tabpadd"><a href="" class="mediumtxt1 boldtxt clr4">Success Story</a> </div></div>
			</div>
		</div> 
		<div id="success2" class="fleft">
			<div id="successlink2_inactive" class="fleft" style="display:none;">
				<div class="fleft tableftsw"></div>
				<div class="fleft tabrightsw"><div class="tabpadd"><a href="javascript:void(0)" onclick="clickTab(2,2,'success');" class="mediumtxt1 boldtxt clr3">Post Your Success Story</a> </div></div>
			</div>
			<div id="successlink2_active" class="fleft" style="display:block;">
				<div class="fleft tabclrleft"></div>
				<div class="fleft tabclrrtsw"><div class="tabpadd"><font class="mediumtxt boldtxt clr4">Post Your Success Story</font> </div></div>
			</div>
		</div>
	<?php } else { ?>
		<div id="success1" class="fleft">									
			<div id="successlink1_inactive" class="fleft" style="display:none;">
				<div class="fleft tableft"></div>
				<div class="fleft tabright"><div class="tabpadd"><a href="javascript:void(0)" onclick="clickTab(1,2,'success')" class="mediumtxt1 boldtxt clr3">Success Story</a> </div></div>
			</div>
			<div id="successlink1_active" class="fleft" style="display:block;">
				<div class="fleft tabclrleft"></div>
				<div class="fleft tabclrright"><div class="tabpadd"><a href="" class="mediumtxt1 boldtxt clr4">Success Story</a> </div></div>
			</div>
		</div> 
		<div id="success2" class="fleft">
			<div id="successlink2_inactive" class="fleft" style="display:block;">
				<div class="fleft tableftsw"></div>
				<div class="fleft tabrightsw"><div class="tabpadd"><a href="javascript:void(0)" onclick="clickTab(2,2,'success');" class="mediumtxt1 boldtxt clr3">Post Your Success Story</a> </div></div>
			</div>
			<div id="successlink2_active" class="fleft" style="display:none;">
				<div class="fleft tabclrleft"></div>
				<div class="fleft tabclrrtsw"><div class="tabpadd"><font class="mediumtxt boldtxt clr4">Post Your Success Story</font> </div></div>
			</div>
		</div>
		<?php } ?>
		<!-- tab button none }-->
	</div>
	<div class="fleft tr-3"></div>
</div>
<div style="clear:both;"></div>
<div class="middiv1">
	<div class="bl">
		<div class="br">
			
			<div class="middiv-pad1" id="middlediv" style="padding-left:15px;">
				<div id="success_content_1" class="smalltxt" style="display:<?=($varPagePost==1)?'none':'block';?>;">
					<div style="padding: 15px 0px 0px 2px;" class="fleft">
						<div style="width:500px;" class="fleft smalltxt">
							<div style="text-align:text-align:center;padding-bottom:15px;" class="mediumtxt clr3 boldtxt ">Most successful portal for <?=$confValues['PRODUCT']?>s world over!</div>
							<div class="smalltxt content"><?=$confValues['PRODUCTNAME']?> is the most popular site for <?=$confValues['PRODUCT']?>s to connect globally. It is safe and fast for <?=$confValues['PRODUCT']?>s to register, search, and find their perfect life partner. At <?=$confValues['PRODUCTNAME']?>, you get a chance to search across over more than 1.1 million active profiles of <?=$confValues['PRODUCT']?>s anywhere in the world.</div>
						</div>
						<!-- <div style="padding-left:20px;_padding-left:30px;" class="fleft"> -->
							<!-- <div style="width:240px;border: 1px solid #ebebeb;" >
								<div style="padding: 1px 0px 0px 2px;width:95px;" class="fleft"><img src="<?=$confValues['IMGSURL']?>/success-gift.gif" width="94" height="72" border="0" alt=""></div>
								<div style="padding: 5px 0px 10px 2px;width:140px;" class="fleft smalltxt">
								Share your <br>success story & <br>
								<font class="smalltxt clr3 boldtxt ">Get an Attractive Gift!</font><br>
								<a href="javascript:void(0)" onclick="clickTab(2,2,'success');" class="clr1">Post Your Success Story >></a></div>
								<br clear="all">
							</div>		 -->		
							<!-- <div style="width:170px;border: 1px solid #ebebeb;" >
								<div style="padding: 9px 0px 0px 9px;text-align:center;"><img src="<?=$confValues['IMGSURL']?>/success-hum-sbook.gif" width="120" height="89" border="0" alt=""/></div>
								<div style="padding: 10px 10px 15px 10px;text-align:center;" class="smalltxt">
								Share your success story and get<font class="smalltxt clr3 boldtxt "> HUM - A Family Story Book</font><br>
								Where you can add memories,events and photos!<br><a href="javascript:void(0)" onclick="clickTab(2,2,'success');" class="clr1">Post Your Success Story >></a></div>
							</div>						 -->	
						<!-- </div> -->
						<br clear="all">
						<div style="width:508px; height:50px;" > 
							<div style="float:left; width:1px; height:50px;background:url(<?=$confValues['IMGSURL']?>/inner-tab-border1.gif);"></div>
							<div style="float:left; width:506px; height:50px; background-image:url('<?=$confValues['IMGSURL']?>/inner-tab-bg.gif');">&nbsp;</div>
							<div style="float:left;background:url(<?=$confValues['IMGSURL']?>/inner-tab-border1.gif);width:1px; height:50px;"></div>
						</div> 
						<div style=" width:508px;" class="smalltxt">
							<div style="float:left; background:url(<?=$confValues['IMGSURL']?>/inner-tab-border2.gif);width:1px; height:33px;"></div>
							
							<div style=" width:506px;" class="fleft smalltxt">
								<div style="padding: 4px 10px 0px 10px;" class="fright">
									<div id="useracticons">
										<div id="useracticonsimgs">
											<div style="float:left;padding-top:2px;">
												<div class="useracticonsimgs prfnavlftoff" style="display:block" id='prevoff'></div>
												<a href="javascript:void(0);" onclick="javascript:succprev();">
												<div class="useracticonsimgs prfnavlfton pntr" style="display:none"  id='prevon'></div></a>
											</div>				
											<div style="float:left;padding: 0px 3px 2px 3px;" class="smalltxt"><a href="javascript:void(0);" onclick="javascript:succprev();">Prev</a></div>										
											<div style="float:left;padding: 0px 3px 2px 5px;" class="smalltxt"><a href="javascript:void(0);" onclick="javascript:succnxt();">Next</a></div>	
											<div style="float:left;padding-top:2px;"><a href="javascript:void(0);" onclick="javascript:succnxt();">
												<div class="useracticonsimgs prfnavrigon pntr"  style="display:block"  id='nxton'></div></a>
												<div class="useracticonsimgs prfnavrigoff"  style="display:none" id='nxtoff'></div>
											</div>	
										</div>
									</div><br clear="all">
								</div>
							</div>
							<div style="float:left; background:url(<?=$confValues['IMGSURL']?>/inner-tab-border2.gif);width:1px; height:33px;"></div>
						</div><br clear="all">
					
						<!-- Sucess Story content -->
						<div id="syeartab_content_1" style="display:block;">
							<div style="padding-left:10px;" id="successstories"><? include_once('success1.php'); ?></div>
						</div>
											<!-- button -->
						<div style=" width:506px;" class="smalltxt">
							<div style="padding: 4px 10px 0px 10px;" class="fright">
								<div id="useracticons">
									<div id="useracticonsimgs">
										<div style="float:left;padding-top:2px;">
											<div class="useracticonsimgs prfnavlftoff" style="display:block" id='prevoff1'></div><a href="javascript:void(0);" onclick="javascript:succprev();">
											<div class="useracticonsimgs prfnavlfton pntr" style="display:none"  id='prevon1'></div></a>
										</div>				
										<div style="float:left;padding: 0px 3px 2px 3px;" class="smalltxt"><a href="javascript:void(0);" onclick="javascript:succprev();">Prev</a></div>										
										<div style="float:left;padding: 0px 3px 2px 5px;" class="smalltxt"><a href="javascript:void(0);" onclick="javascript:succnxt();">Next</a></div>	
										<div style="float:left;padding-top:2px;"><a href="javascript:void(0);" onclick="javascript:succnxt();">
											<div class="useracticonsimgs prfnavrigon pntr"  style="display:block"  id='nxton1'></div></a>
											<div class="useracticonsimgs prfnavrigoff"  style="display:none" id='nxtoff1'></div>
										</div>	
									</div>
								</div>
							</div>
						</div>
						<!-- button -->
							<!-- Sucess Story content Ends Here -->
				<!-- Middle Content -->
					
					</div><br clear="all">
				</div>
				<!-- Post Sucess Story Starts Here -->
				<div id="success_content_2" style="display:<?=($varPagePost==1)?'block':'none';?>;">
					<div style="padding:15px 0px 0px 4px" class="fleft">
				<? if($_REQUEST['frmSuccessSubmit']!='yes' && $_REQUEST['frmEmailFwdSubmit']!='yes') { ?>
						<div style="width:500px;" class="fleft smalltxt">
							<div class="smalltxt content">Share your success story and get a gift to treasure forever. Your story will also be an inspiration to our members. </div>
						</div>
						<!-- <div style="padding-left:10px;" class="fleft">
							<div style="width:240px;border: 1px solid #ebebeb;" >
								<div style="padding: 1px 0px 0px 2px;width:95px;" class="fleft"><img src="<?=$confValues['IMGSURL']?>/success-gift.gif" width="94" height="72" border="0" alt=""></div>
								<div style="padding: 5px 0px 10px 2px;width:140px;" class="fleft smalltxt">
								Share your <br>success story & <br>
								<font class="smalltxt clr3 boldtxt ">Get an Attractive Gift!</font><br></div>
								<br clear="all">
							</div>							
						</div> --><br clear="all">
				<? } ?>
						<div class="fleft" style="width:508px">
							<div class="innertabbr1 fleft"></div>
							<div style="float:left; width:506px; height:50px; background:url(<?=$confValues['IMGSURL']?>/inner-tab-bg.gif) repeat-x;">
								<div class="smalltxt1 fright" style="margin-top:6px;">
									<font class="smalltxt1 clr">All fields marked with <font class="clr1 mediumtxt boldtxt">*</font> are mandatory</font>
								</div>
							</div>
							<div class="innertabbr1 fleft"></div>
						</div>
						<div style="width:508px;">
							<div class="fleft innertabbr2"></div>
							<div class="smalltxt fleft"  style="width:506px;">
						<? if($_REQUEST['frmSuccessSubmit']=='yes' || $_REQUEST['frmEmailFwdSubmit']=='yes') { ?>
								<div class="smalltxt" style="padding: 0px 0px 0px 20px;"><?=$varDisplayMsg?></div>
						<? } else { ?>
								<div class="smalltxt" style="padding: 0px 0px 0px 40px">
								<form name="frmSuccess" method="POST" enctype="multipart/form-data"  style="margin:0px;" onSubmit="return successvalidate();"> 
								<input type="hidden" name="domain" value="<?=$confValues['SERVERURL']?>">
								<input type="hidden" name="frmSuccessSubmit" value="yes">
									<div id="row1" style="padding-bottom:10px;">
										<div class="fleft" style="width:230px;padding-bottom:10px;"><font class=" mediumtxt2 bold">Bride Name (Female)</font>&nbsp;<font class="clr1">*</font>&nbsp;<span id="bridenamespan" class="errortxt"></span><br><font class="smalltxt1 clr" style="padding-bottom:4px;">Type the name of the girl.</font><br><input type=text name="bridename" size=32 class="inputtext" onblur="ChkEmpty(document.frmSuccess.bridename, 'text','row1','bridenamespan','Enter bride name');" tabindex="4"></div>
										<div class="fleft" style="padding-bottom:10px;"><font class=" mediumtxt2 bold">Groom Name (Male)</font>&nbsp;<font class="clr1">*</font>&nbsp;<span id="groomnamespan" class="errortxt"></span><br><font class="smalltxt1 clr" style="padding-bottom:4px;">Type the name of the boy.</font><br><input type=text name="groomname" size=32 class="inputtext" onblur="ChkEmpty(document.frmSuccess.groomname, 'text','row1','groomnamespan','Enter groom name');" tabindex="5"></div>
									</div>
									<br clear="all">
									<div id="row2">
										<div class="fleft" style="width:230px;padding-bottom:10px;"><font class=" mediumtxt2 bold">Username</font>&nbsp;<font class="clr1">*</font>&nbsp;<span id="matidspan" class="errortxt"></span><br><font class="smalltxt1 clr" style="padding-bottom:4px;">Mention the username of the bride or groom.</font><br><input type=text name="matid" size=32 class="inputtext" onblur="ChkEmpty(document.frmSuccess.matid, 'text','row2','matidspan','Enter matrimony id');" tabindex="6"></div>
										<div class="fleft" style="padding-bottom:10px;"><font class=" mediumtxt2 bold">E-mail</font>&nbsp;<font class="clr1">*</font>&nbsp;<span id="matEmailspan" class="errortxt"></span><br><font class="smalltxt1 clr" style="padding-bottom:4px;">Enter your e-mail ID.</font><br><input type=text name="matEmail" size=32 class="inputtext" onblur="ChkEmpty(document.frmSuccess.matEmail, 'text','row2','matEmailspan','Enter your email id');" tabindex="7"></div>
									</div>
									<br clear="all">
									<div id="row3">
										<div class="fleft" style="width:230px;padding-bottom:10px;"><font class=" mediumtxt2 bold">Marriage Date</font>&nbsp;<font class=" smalltxt1 clr">(Optional)</font>&nbsp;<span id="marrdatespan" class="errortxt"></span><br><font class="smalltxt1 clr" style="padding-bottom:4px;">It would be wonderful if you could share with us marriage date.</font><br><input type=text name="marrdate" size=32 class="inputtext" tabindex="8"></div>
										<div style="padding-bottom:10px;"><font class=" mediumtxt2 bold">Attach Photo</font>&nbsp;<font class=" smalltxt1 clr">(Optional)</font>&nbsp;<span id="upPhotoSpan" class="errortxt"></span><br><font class="smalltxt1 clr" style="padding-bottom:4px;">Attach your marriage photo, we will publish it along with your success story.</font><br><input type="file" name="succphoto" size=21 style="width:190px;" class="inputtext" tabindex="9"></div>
									</div><br clear="all">
									<div id="row4">
										<div class="fleft" style="width:230px;padding-bottom:10px;"><font class=" mediumtxt2 bold">Address</font>&nbsp;<font class=" smalltxt1 clr">(Optional)</font>&nbsp;<span id="succaddressspan" class="errortxt"></span><br><font class="smalltxt clr" style="padding-bottom:4px;">Mention your address below so that we can sent you a special gift.</font><br><textarea name="succaddress" rows="5" cols="30"  class="inputtext" tabindex="10" ></textarea></div>
										<div style="padding-bottom:10px;"><font class=" mediumtxt2 bold">Telephone</font>&nbsp;<font class="clr1">*</font>&nbsp;<span id="succtelspan" class="errortxt"></span><br><font class="smalltxt1 clr" style="padding-bottom:4px;">Mention your telephone number so that we can call you before delivering the gift.</font><br><input type=text name="succtel" size=32 class="inputtext" onblur="ChkEmpty(document.frmSuccess.succtel,'text','row4','succtelspan','Enter your telephone number');" tabindex="11"></div>
									</div><br clear="all">
									<div id="row5">
										<div class="fleft" style="padding-bottom:10px;"><font class=" mediumtxt2 bold">Success Story</font>&nbsp;<font class="clr1">*</font>&nbsp;<span id="succStoryspan" class="errortxt"></span><br><font class="smalltxt1 clr" style="padding-bottom:4px;">Tell us in a few lines how you both met and got married.</font><br><textarea name="succStory" rows="5" cols="30" style="width:440px" class="inputtext" tabindex="12" onblur="ChkEmpty(document.frmSuccess.succStory, 'text','row5','succStoryspan','Enter your success story');"></textarea></div>
									</div><br clear="all">
									<div class="fright" style="padding-right:25px"><input type="submit" class="button" value="Submit" tabindex="13"></div><br clear="all">
									</form>
								</div>
								<div style="padding-top:10px;"></div>
								<div style="padding-left:10px;">
									<center>
									<div class="vdotline1" style="width:445px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1"></div>
									</center>
								</div>
								<div style="padding-top:10px;"></div>
								<div style="padding:10px 0px 10px 40px;" class="smalltxt ">
									<div style="float:left;padding: 5px 10px 8px 15px;" class="topnavrowclr formborder">
										<div style="padding:5px;"><font class="smalltxt boldtxt clr">A good success story should cover these topics:</font><br><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1">
										<img src="<?=$confValues['IMGSURL']?>/hp-arrow.gif">&nbsp;&nbsp;How you went about your search for a partner<br><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1">
										<img src="<?=$confValues['IMGSURL']?>/hp-arrow.gif">&nbsp;&nbsp;How you and your partner met and established contact.<br><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1">
										<img src="<?=$confValues['IMGSURL']?>/hp-arrow.gif">&nbsp;&nbsp;How you got to know each other's expectations and decided to proceed further.<br><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1">
										<img src="<?=$confValues['IMGSURL']?>/hp-arrow.gif">&nbsp;&nbsp;Your experience of <?=$confValues['PRODUCTNAME']?>.com<br></div>
									</div><br clear="all">
								</div>
								<? } ?>
							</div>
							<div class="fleft innertabbr2"></div>						
						</div>
					</div>
				</div><br clear="all">
			<!-- Post Sucess Story Ends Here -->
			</div>
		</div>
	</div>
</div>
<?
	$objSuccess->dbClose();
	$objDb->dbClose();
	unset($objDb);
	unset($objSuccess);
?>