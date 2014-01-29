<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : success.php
#=====================================================================================================================================
# Description : getting success story information
#=====================================================================================================================================
//ini_set('display_errors',1);
//error_reporting(E_ALL);
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath."/lib/clsSuccessMailer.php");

//OBJECT CREATION
$objCommon	= new clsCommon;
$objSuccess	= new SuccessMailer;
$objSuccess->dbConnect('M', $varDbInfo['DATABASE']);

if($_POST['act'] == 'success' && $_POST['frmsuccessstorySubmit'] == 'yes') {

	$varCommunityId	= $confValues['DOMAINCASTEID'];
	$varBrideName	= trim($_POST['bride']);
	$varGroomName	= trim($_POST['groom']);
	$varMatriId		= trim($_POST['matriid']);
	$varDomainPrefix= strtoupper(substr($varMatriId,0,3));
	$varEmail		= trim($_POST['email']);
	$varMageYear	= $_POST['mageyear'];
	$varMageMonth	= $_POST['magemonth'];
	$varMageday		= $_POST['mageday'];	
	$varMariageDate	= $varMageYear.'-'.$varMageMonth.'-'.$varMageday;
	$varAddress		= trim($_POST['address']);
	$varPhone		= trim($_POST['phone']);
	$varSuceessStory= trim($_POST['successstory']);
	$varCurrentDate	= date("Y-m-d");

	if(!preg_match("/^[a-zA-Z]{3}[0-9]{6,8}$/",$varMatriId)) {
		$varErrMsg = 'Enter correct user id.';
	} else if($arrMatriIdPre[$varCommunityId]!=$varDomainPrefix) {
		$varErrMsg = 'Enter correct user id.';
	} else {
		//photo moving to appropriate domain wise folder
	
		if($_FILES['photo']['name'] != '') {
			$varFolderName	= $objSuccess->getFolderName($varMatriId);
            if(!is_dir($varRootBasePath."/www/success/".$varFolderName)){
				mkdir($varRootBasePath."/www/success/".$varFolderName,0777);
                chmod($varRootBasePath."/www/success/".$varFolderName,0777);
				mkdir($varRootBasePath."/www/success/".$varFolderName."/stories",0777);
				chmod($varRootBasePath."/www/success/".$varFolderName."/stories",0777);
				mkdir($varRootBasePath."/www/success/".$varFolderName."/pendingphotos",0777);
				chmod($varRootBasePath."/www/success/".$varFolderName."/pendingphotos",0777);
				mkdir($varRootBasePath."/www/success/".$varFolderName."/smallphotos",0777);
				chmod($varRootBasePath."/www/success/".$varFolderName."/smallphotos",0777);
				mkdir($varRootBasePath."/www/success/".$varFolderName."/homephotos",0777);
				chmod($varRootBasePath."/www/success/".$varFolderName."/homephotos",0777);
				mkdir($varRootBasePath."/www/success/".$varFolderName."/bigphotos",0777);
				chmod($varRootBasePath."/www/success/".$varFolderName."/bigphotos",0777);

				if(!is_dir($varRootBasePath."/www/success/".$varFolderName)){
					echo "There is no permission to create directory ".$varFolderName;
					exit;
				}
			}
			
			if($varFolderName != '') {
				$varPhotoFile	= explode(".",$_FILES['photo']['name']);
				$varFileName	= $varMatriId."_SUCCESS.".$varPhotoFile[1];
				$varUploadPath	= $varRootBasePath."/www/success/".$varFolderName."/pendingphotos/";
				$varTargetPath	= $varUploadPath.$varFileName;

				if(!move_uploaded_file($_FILES['photo']['tmp_name'], $varTargetPath)) {
					$varFileName= '';
				}
			}
		}

		// To insert into Successstory table
		$arrFields		= array('CommunityId','MatriId','Email','Bride_Name','Groom_Name','Marriage_Date','Success_Message','Photo','Telephone','Contact_Address','Date_Updated');
		$arrFieldValues	= array($varCommunityId,$objSuccess->doEscapeString($varMatriId,$objSuccess),$objSuccess->doEscapeString($varEmail,$objSuccess),$objSuccess->doEscapeString($varBrideName,$objSuccess),$objSuccess->doEscapeString($varGroomName,$objSuccess),$objSuccess->doEscapeString($varMariageDate,$objSuccess),$objSuccess->doEscapeString($varSuceessStory,$objSuccess),$objSuccess->doEscapeString($varFileName,$objSuccess),$objSuccess->doEscapeString($varPhone,$objSuccess),$objSuccess->doEscapeString($varAddress,$objSuccess),"'".$varCurrentDate."'");
		$varInsId		= $objSuccess->insert($varTable['SUCCESSSTORYINFO'],$arrFields,$arrFieldValues);

		//Sending mail to user according success message
		$varFromId		= $varEmail;
		$arrRetEmailList= $objSuccess->getDomainEmailList($varMatriId);
		$varToId		= $arrRetEmailList['SUCCESSEMAIL']; 
		$varToCC		= $arrRetEmailList['SUCCSUPMAIL']; 

		$varSubject		= "Success Story";
		$varMessage		= "Member has submitted details of his/her success story.<br><br><font face=Arial size=2><b>Groom : </b>".$varGroomName."<br><br><b>Bride : </b>".$varBrideName."<br><br><b>MatriId </b>: ".$varMatriId."<br><br><b>Marriage Date : </b>".$varMariageDate."<br><br><b>Success Story : </b>".$varSuceessStory."<br><br><b>Submitted on : </b>".$varCurrentDate."<br></font>";

		if($_FILES['photo']['error']=='' && $varFileName!='') {

			$varReturn = $objSuccess->sendMailAttach($varFromId, $varToId, $varToCC, $varSubject, $varMessage, $varUploadPath,$varFileName);
		} else {
			$varReturn = $objSuccess->sendEmail($varFromId,$varFromId,$varToId,$varToId,$varSubject,$varMessage,$varFromId);
		}

		$varFrom2		= $arrRetEmailList['INFOEMAIL'];
		$varSubject2	= "Congratulations ".$varMatriId;
		$varMessage2	= "<font face=Arial size=2>Dear Member,<br><br>Thank you for submitting the Success Story. We wish the bride and groom a very happy and prosperous life together. Please make sure you delete your profile, by logging into your account and clicking on the 'Delete Profile' option.<br><br>Warm Regards,<br>".$confValues['PRODUCTNAME'].".com<br><br></font>";

		$varSendRes2	= $objSuccess->sendEmail($varFrom2,$varFrom2,$varEmail,$varEmail,$varSubject2,$varMessage2,$varFrom2);

		$varFrom3		= $arrRetEmailList['WEMASTERMAIL'];
		$varSubject3	= "Success Story Contact details";
		$varMessage3	= "Member has included contact details for submission of his/her success story.<br><br><font face=Arial size=2><b>MatriId </b>:".$varMatriId."<br><br><b>Address : </b>".$varAddress."<br><br><b>Phone no. : </b>".$varPhone."<br><br>Warm Regards,<br>".$confValues['PRODUCTNAME'].".com<br><br></font>";
		$varToCC		= '';
		$varSendRes3	= $objSuccess->sendEmailwithCC($varFrom3,$varToId,$varSubject3,$varMessage3,$varFrom3,$varToCC,'');

		$varDisplayMsg = 'Thank you for submitting the Success Story. We wish the bride and groom a very happy and prosperous life together.';
		
		//Referring friends to our matrimony site
		/*$varDisplayMsg	= '<div>Now that you have found your life partner, why don\'t you recommend '.$confValues['PRODUCTNAME'].' to your relatives, friends and colleagues and help them in their partner search.<br><br><font class="smalltxt boldtxt">Please enter the names and e-mail IDs of the persons to whom you would like to refer our site.</font><br></div><br clear="all"><div class="normalrow"><div class="smalltxt"><form name="frmEmailFwd" method="post" onSubmit="return emailFwdvalidate();"><input type="hidden" name="frmEmailFwdSubmit" value="yes"><input type="hidden" value="'.$varBrideName.'" name="bridevalue"><input type="hidden" value="'.$varGroomName.'" name="groomvalue"><input type="hidden" name="matriid" value="'.$varMatriId.'">';
		for($i=1;$i<=5;$i++)
		{
			$varDisplayMsg .= '<div style="padding-bottom:10px;"><div class="fleft mediumtxt2 bold" style="width:235px;"><span id="emailerrmsgnam'.$i.'" class="errortxt"></span><br>Name&nbsp;<br><input type=text name="frndname'.$i.'" size=40 class="inputtext"></div><div class="fleft mediumtxt2 bold" style="padding:0px 0px 10px 5px;"><span id="emailerrmsgemail'.$i.'" class="errortxt"></span><br>E-mail ID&nbsp;<br><input type=text name="frndemail'.$i.'" size=40 class="inputtext"></div></div><br clear="all">';
		}
		$varDisplayMsg		.= '<div class="fright" style="padding-right:16px;"><input type="submit" class="button" value="Submit"></div><br clear="all"></form></div></div>';*/
	}
	
}

/*if($_REQUEST['frmEmailFwdSubmit']=='yes') {

	$varBride	= $_POST['bridevalue'];
	$varGroom	= $_POST['groomvalue'];
	$varMatriId	= $_POST['matriid'];

	for($j=1;$j<=5;$j++) {
		$varFrndName	= $_REQUEST['frndname'.$j];
		if($varFrndName!='') {
			$varFrndMail	= $_REQUEST['frndemail'.$j];
			$retMailer		= $objSuccess->referFriendMail($varBride,$varGroom,$varFrndMail,$varFrndName);
			$varNumCond		= " where Email='".$varFrndMail."' and MemberStatus=12";
			$varResult		= $objSuccess->numOfRecords($varTable['MAILERPROFILE'],'MatriId',$varNumCond);
			if($varResult==0){
				$varMailFlds	= array('MatriId','Email','Name','MemberStatus');
				$varMailFldVal	= array("'".$varMatriId."'","'".$varFrndMail."'","'".$varFrndName."'",12);
				$objSuccess->insert($varTable['MAILERPROFILE'],$varMailFlds,$varMailFldVal);
			}//if
		}//if
	}//for
	$varDisplayMsg = 'Thank you for referring '.$confValues['PRODUCTNAME'].' to people whom you know looking for a life partner. We wish you a Happy and Prosperous Married Life!';
}*/
?>

<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/successstory.js" ></script>

<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5 padl"><font class="clr bld">Success Stories</font></div>
	<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<div class="smalltxt clr2 padt5 fleft padl"><a class="clr1" href="/successstory/index.php?act=successgallery">Success Story</a>&nbsp;&nbsp;|&nbsp;&nbsp; <font class="clr bld">Post Your Success Story</font></div><br clear="all">
	<center>
	<div class="rpanel padt10">

	<? if($varDisplayMsg!='') { echo '<div style="padding:17px">'.$varDisplayMsg.'</div>'; } else { if($varErrMsg!='') {echo '<div class="errortxt" style="padding:15px 15px 0px 50px;">'.$varErrMsg.'</div>';}?>
		<div class="normtxt clr" style="padding:15px 15px 0px 50px;">Share your success story and get a gift to treasure forever. Your story will also be an inspiration to our members.
		</div>
		<br clear="all">
		<div class="fright opttxt" style="padding-right:8px;"><font class="clr1">*</font>Mandatory</div>
		<br clear="all">	
		<form method="post" name="frmSuccess" enctype="multipart/form-data" onSubmit="return successvalidate();">
			<input type="hidden" name="act" value="success">
			<input type="hidden" name="frmsuccessstorySubmit" value="yes">
			<div class="srchdivlt fleft tlright smalltxt">Bride Name (Female)<font class="clr1">*</font></div>
			<div class="srchdivrt fleft">
				<input type="text" name="bride" size=35 class="inputtext" tabindex="1" value=<?=$varBrideName?>><br clear="all"><span id="bridenamespan" class="errortxt"></span>
			</div>
			<br clear="all">
			
			<div class="srchdivlt fleft tlright smalltxt">Groom Name (Male)<font class="clr1">*</font></div>
			<div class="srchdivrt fleft">
				<input type="text" name="groom" size=35 class="inputtext" tabindex="2" value=<?=$varGroomName?>><br clear="all"><span id="groomnamespan" class="errortxt"></span>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">User Id<font class="clr1">*</font></div>
			<div class="srchdivrt fleft">
				<input type="text" name="matriid" size=35 class="inputtext" tabindex="3" value=<?=$varMatriId?>><br clear="all"><span id="matidspan" class="errortxt"></span>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Email<font class="clr1">*</font></div>
			<div class="srchdivrt fleft">
				<input type="text" name="email" size=35 class="inputtext" tabindex="4" value=<?=$varEmail?>><br clear="all"><span id="matEmailspan" class="errortxt"></span>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Marriage Date<br><font class="opttxt">(Optional)</font></div>
			<div class="srchdivrt fleft">
				<select class='inputtext' NAME='magemonth' size='1' style='width:60px;' tabindex="5">
					<option value=''>-Month-</option>
					 <?=$objCommon->monthDropdown($varMageMonth)?>
				</select>
				<select name='mageday' class='inputtext' style='width:55px;' tabindex="6">
					<option value='' selected>-Date-</option>
					<? for($i=1; $i<=31; $i++) {
						$varSelected	= ($i==$varMageday)?'selected':'';
						echo '<option value="'.$i.'" '.$varSelected.'>'.$i.'</option>';
			        } ?>
				</select>
				<select name='mageyear' class='inputtext' style='width:60px;' tabindex="7">
					<option value=''>-Year-</option>
					<? for($i=date("Y"); $i>=(date("Y")-5); $i--) {
						$varSelected	= ($i==$varMageYear)?'selected':'';
						echo '<option value="'.$i.'" '.$varSelected.'>'.$i.'</option>';
			        } ?>
				</select>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Attach Photo<br><font class="opttxt">(Optional)</font></div>
			<div class="srchdivrt fleft">
				<input type="file" name="photo" class="button" size="36" tabindex="8" style="width:270px;" onBlur="photouploadval();"><br clear="all"><span id="upPhotoSpan" class="errortxt"></span>
				<!-- Sysdet Bubble out div-->
				<div id="addrdetdiv" style="z-index:2110;margin-left:205px;display:none;"><span class="posabs" style="width:153px; height:78px;background:url('http://img.communitymatrimony.com/images/success_img1.gif') no-repeat;padding-top:25px;padding-left:22px;"><span class="smalltxt clr3 tlleft" style="width:122px;padding-left:2px;">Mention your address <br>below so that we can <br>send you a special gift.</span></span></div>
				<!-- Sysdet Bubble out div-->
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Address<br><font class="opttxt">(Optional)</font></div>
			<div class="srchdivrt fleft">
				<textarea class="tareareg" style="width:205px;height:90px;" name="address" tabindex="9" onfocus="showdiv('addrdetdiv');" onblur="hidediv('addrdetdiv');"><?=$varAddress?></textarea>
				
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Telephone<font class="clr1">*</font></div>
			<div class="srchdivrt fleft">
				<input type="text" name="phone" class="inputtext" tabindex="10" size="35" value="<?=$varPhone?>"><br><span id="succtelspan" class="errortxt"></span>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Success Story<font class="clr1">*</font></div>
			<div class="srchdivrt fleft">
				<textarea class="tareareg" style="width:205px;height:90px;" name="successstory" tabindex="11"><?=$varSuceessStory?></textarea><br>
				<span id="succStoryspan" class="errortxt"></span>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">&nbsp;</div>
			<div class="srchdivrt fleft">
				<div class="fright" style="padding-right:10px;">
					<input type="submit" value="Save" class="button" tabindex="12">&nbsp;&nbsp;
					<input type="reset" value="Reset" class="button" tabindex="13">
				</div>
			</div>
		</form>
	<?}?>	<!-- Close if varDisplayMsg -->
	</div>
	</center>
</div>
<?php

UNSET($objCommon);
UNSET($objSuccess);
?>