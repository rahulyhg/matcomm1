<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		: photoview.php
#================================================================================================================
   # Description	: display the user photos for view profile and search result pages.
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath."/lib/clsDB.php");
//SESSION VARIABLES
$sessMatriId		= $_REQUEST['MATRIID'];
//Object initialization
$objSlaveDB			= new DB;
$objMasterDB		= new DB;
//VARIABLE DECLARATION
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$varMasterConn		= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($sessMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

//img server path 
$varDomainName		= $arrPrefixDomainList[$varPrefix];
$varIMGServer		= 'http://img.'.$varDomainName;
$varPhotoURL		= $varIMGServer.'/membersphoto/'.$varFolderName;

$varFields			= array('User_Name','MatriId');
$varCondition		= " WHERE  MatriId  ='".$sessMatriId."'";
$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], $argPrimary='MatriId', $varCondition);
//print "<br> TOTAL RECORDS ".$varTotRecords;
if ($varTotRecords == 1) {
	$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
	$varSelectLoginInfo	= mysql_fetch_assoc($varResult);
} else {
	$varCondition		= " WHERE  User_Name  ='".$sessMatriId."'";
	$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], $argPrimary='MatriId', $varCondition);
	if ($varTotRecords == 1) {
		$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
		$varSelectLoginInfo	= mysql_fetch_assoc($varResult);
		$sessMatriId		= $varSelectLoginInfo['MatriId'];
	}
}
$varContent	.= '';
if ($varTotRecords == 0 ) {
	echo '<table width="100%" border="0"><tr><td align="center"><font class="smalltxt boldtxt clr1"> Profile not found </font></td></tr></table>';
} else {
	//CONTROL STATEMENT
	$varCondition			= " WHERE MatriId = '".$sessMatriId."'";
	$varTotRecords			= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], $argPrimary='MatriId', $varCondition);
	$arrSelectPhotoInfo		= array();
	$varFields				= array('*');
	$varResult				= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
	$arrSelectPhotoInfo 	= mysql_fetch_assoc($varResult);
	?>
	<script	language=javascript src="<?=$confValues['JSPATH'];?>/ajax.js" ></script>
	<script language = 'javascript' src="<?=$confValues['JSPATH'];?>/adminphotoadd.js" ></script>
	<script src="<?=$confValues['JSPATH'];?>/div-opacity.js" type="text/javascript" ></script>
	<script language="javascript"  src="<?=$confValues['JSPATH'];?>/position.js" ></script>
	<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/useractions-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/fade.css">
	<?include_once("adminheader.php");?>
	<div style="padding-left:60px;">
	<div id="rndcorner" style="float:left;width:902px;_width:880px;">
	<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
	<div style="padding:5px 10px 5px 10px;">
		<div style="width:auto;text-align:center;">
			<div class="bl">
				<div class="br">
					<div class="tl">
						<div class="tr">
							<div style="clear:both;"></div>
							
							<div style="text-align:center;">
								<div style="text-align:center;padding:5px 0 2px 0px;">
								<!-- inside content -->
	<form method="post" name="addphoto" action="<?=$confValues['IMAGEURL'];?>/admin/photovalidation/adminphotoadd.php" enctype="multipart/form-data" onSubmit="return validateFile();" style="padding:0px;margin:0px;"> 
		<div class="smalltxt">
			<div id="photodiv" style="padding: 0px 20px 20px 15px;">
			<!-- TR1 -->
				<div style="text-align: left;align:left;">
					<div class="mediumtxt boldtxt clr3">Manage Photo<br clear="all"></div>
					<div style="padding-top: 5px;">
						Members prefer to view and contact profiles that have photos. A photo increases your chances of being contacted by 20 times.<br>
						You can upload up to 10 photos in JPG, GIF format. (File size limit is 350 KB for each photo)</div>
					</div><br clear="all"> 
					<!-- TR-2 - Photo -Div -->								
					<!-- Icon Div -->
					<div id="useracticons">
						<div id="useracticonsimgs">
						<!-- Row 1 -->
						<div>
						<? 
						for($i=1;$i<=10;$i++){ 
							if (trim($arrSelectPhotoInfo['Thumb_Big_Photo'.$i]) != ''){
								$varPhotoFolder	=	($arrSelectPhotoInfo['Photo_Status'.$i]==1)? "/".$sessMatriId{3}."/".$sessMatriId{4}."/":"/crop75/";					
							?>
							<div style="display:block;padding: 8px;" class="fleft">
								<img src="<?=$varPhotoURL.''.$varPhotoFolder.$arrSelectPhotoInfo['Normal_Photo'.$i];?>" width="75" height="75" style="border:1px solid #D3D3D3;">
								<div class="smalltxt">
									<div class="fleft">
										<A  onClick="photoUpload('uploadDIV','<?=$i;?>','change');" class="clr1 pntr">Change</A>
									</div>
									<div class="fleft" style="padding-left:8px;">
										<A href="javascript:;" onclick="javascript:document.getElementById('photodelete').src='adminphotodeleteconfirm.php?PNO=<?=$i;?>&ID=<?=$sessMatriId;?>';document.getElementById('divphotodelete').style.display='block';document.getElementById('photodelete').height='75px';"  class="clr1 pntr">Delete</A>
									</div>
								</div>
								<? if($arrSelectPhotoInfo['Photo_Status'.$i]==1){?>
									<? if ($i != 1) {?>
									<br>
									<div>
										 <a   href="javascript:;" onclick="funPhotoSwap('<?=$i;?>','<?=$sessMatriId;?>');" class="clr1 pntr">Make default</a>
									</div>
									<? }?>
								<? } elseif ($arrSelectPhotoInfo['Photo_Status'.$i]== 0 || $arrSelectPhotoInfo['Photo_Status'.$i]== 2){ ?>
											<br><div class="errortxt">Under Validation</div>
								<? }?>
							</div>
							<?} else { ?>
								<div style="display:block; padding: 8px;" class="fleft"><a onClick="photoUpload('uploadDIV','<?=$i?>','add');"><div class="pntr"><img src="<?=$confValues['IMGSURL']?>/<?=($varGender == 1)?'img85_phnotadd_m.gif':'img85_phnotadd_f.gif'?>" width="75" height="75"><div class="phototalign smalltxt clr1"><u>Add Photo</u></div></div></a></div>
							<? }
							if ($i==5)
								echo '<br clear="all">';
						}					
						?>
						</div>
					
						<!-- Row 2 - End -->		
						<a name="addphoto"></a>
						<div style="margin:0px; padding:0px;">	
							<div id="uploadDIV" class="photow" style="display:none; padding-top:5px;">
								<div class="vdotline1" style="float: left; width: 480px; height: 4px;"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" width="1" height="4" /></div><br clear="all">
								<span class="errortxt" style="width:450px;padding-top:3px;display:none;" id="errdiv"></span>
								<div class="fleft" style="width:450px;">
									<div style="float: left;">
										<input type="file" id="newphoto" name="newphoto" accept="image/gif, image/jpeg" >
									</div> 
									<div style="float: left; padding-left: 20px; padding-top: 3px;">
										<input value="Upload" class="button" type="submit" >
									</div>
									<div style="float: left; padding-left: 20px; padding-top: 5px;">
										<a href="javascript:;" onclick="divclose('uploadDIV');" class="smalltxt clr1">
											<u>Cancel</u>
										</a><input name="photono" id="photono" type="hidden">
										<input name="matriid" type="hidden"  value="<?=$sessMatriId;?>">
										<input name="frmAddPhotoSubmit" id="frmAddPhotoSubmit" type="hidden" value="yes">
										<input name="action" id="action" type="hidden" value="">
									</div>	
								</div>
							</div>			
						</div>
					</div></div>
				</div>
				</div>
				</div>
			</form>
			
						<!-- Icon Div - End-->
			<!-- TR-2 - Photo -Div  - End-->
			<!-- <div class="bheight"></div>  -->
			<!-- Photo password -->	
	 <br clear="all">
	 <div id="divphotodelete" style="width:450px;display:none;border:1px solid #CBCBCB;">
			<iframe src ="" width="420" height="50" frameborder="0" scrolling="no" allowTransparency="true" style="margin:0px;padding:0px;" id="photodelete"></iframe>
			<br clear="all">		
	</div><br clear="all"><br clear="all">
	<? if (trim($arrSelectPhotoInfo['Thumb_Big_Photo1']) != ''){ ?>
	<div><a href=javascript:;  onclick='javascript:window.open("adminshowphoto.php?MATRIID=<?=$sessMatriId;?>&PNO=1","viewphoto","height=600,width=800");' class="mediumtxt clr1">Enlarge Photo</a></div>
	<? } ?>
	<!-- inside content -->
								</div>
							</div>		
						</div><br clear="all">
						<!-- <div style="width:300px;"><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" width="1" height="50"></div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div></div>
<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>

	<?
	$objSlaveDB->dbClose();
	$objMasterDB->dbClose();
	?>
	
	<script>
	function photoUpload(divid,num,action){	
		document.getElementById('action').value=action;
		document.getElementById('photono').value=num;
		if (parseInt(navigator.appVersion)>3) {
			 if (navigator.appName=="Netscape") {
				  winH = window.outerWidth;	
				  winW = window.outerHeight;
			 }
			 if (navigator.appName.indexOf("Microsoft")!=-1) {
				  winW = screen.availHeight;
				  winH = screen.availWidth;
			 }
		}
		if(divid=='uploadDIV') {
			document.getElementById('uploadDIV').style.display="block";
		if (winH <= 810)
			focusdiv();
		document.getElementById('newphoto').focus();
		}	
	}
	function validate(frm){
		var PhotoProtectForm = this.document.frmPhotoProtect;  		
		if ( PhotoProtectForm.photopwd.value == "" ) {
			document.getElementById('result').innerHTML = "Please enter the photo password";
			PhotoProtectForm.photopwd.focus();
			return false;
		}
		if ( PhotoProtectForm.photoprotectpwd.value == "" )	{
			document.getElementById('result').innerHTML = "Please enter the confirm photo password";
			PhotoProtectForm.photoprotectpwd.focus();
			return false;
		}
		if ( PhotoProtectForm.photopwd.value!= PhotoProtectForm.photoprotectpwd.value )	{
			document.getElementById('result').innerHTML = "The photo password and confirm password did not match";
			PhotoProtectForm.photopwd.focus();
			return false;
		}
		FunProtectPassword(PhotoProtectForm.photopwd.value,PhotoProtectForm.photoprotectpwd.value);
		return true;
	}		
	</script>
<? }?>
