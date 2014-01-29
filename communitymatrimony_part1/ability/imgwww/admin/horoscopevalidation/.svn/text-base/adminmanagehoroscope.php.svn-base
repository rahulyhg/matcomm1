<?php
#================================================================================================================
   # Author 		: Jeyakumar
   # Date			: 25-Mar-2009
   # Project		: MatrimonyProduct
   # Filename		: adminmanagehoroscope.php
#================================================================================================================
   # Description	: admin can add, change or delete the particular user's horoscope.
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION VARIABLES
$varMatriId		= $_REQUEST['MATRIID'];

//Object initialization
$objSlaveDB		= new DB;
$objMasterDB	= new DB;

//VARIABLE DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

$varFields			= array('User_Name','MatriId');
$varCondition		= " WHERE  MatriId  ='".$varMatriId."'";
$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], $argPrimary='MatriId', $varCondition);

if ($varTotRecords == 1) {
	$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
	$varSelectLoginInfo	= mysql_fetch_assoc($varResult);
} else {
	$varCondition		= " WHERE  User_Name  ='".$varMatriId."'";
	$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], $argPrimary='MatriId', $varCondition);
	if ($varTotRecords == 1) {
		$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
		$varSelectLoginInfo	= mysql_fetch_assoc($varResult);
		$varMatriId		= $varSelectLoginInfo['MatriId'];
	}
}
$varContent	.= '';
if ($varTotRecords == 0 ) {
	echo '<table width="100%" border="0"><tr><td align="center"><font class="smalltxt boldtxt clr1"> Profile not found </font></td></tr></table>';
} else {
	//CONTROL STATEMENT
	$varCondition			= " WHERE MatriId = '".$varMatriId."'";
	$varTotRecords			= $objSlaveDB->numOfRecords($varTable['MEMBERPHOTOINFO'], $argPrimary='MatriId', $varCondition);
	
	$arrSelectPhotoInfo		= array();
	$varFields				= array('HoroscopeURL','HoroscopeStatus','Horoscope_Date_Updated','Horoscope_Protected','Horoscope_Protected_Password');
	$varResult				= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
	$arrSelectPhotoInfo 	= mysql_fetch_assoc($varResult);
	?>
	<script	language=javascript src="<?=$confValues['JSPATH'];?>/ajax.js" ></script>
	<script language = 'javascript' src="<?=$confValues['JSPATH'];?>/adminhoroscopeadd.js" ></script>
		<script language = 'javascript' src="<?=$confValues['JSPATH'];?>/global.js" ></script>
	<script language = 'javascript' src="<?=$confValues['JSPATH'];?>/tools.js" ></script>
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
	<form method="post" name="addphoto" action="<?=$confValues['IMAGEURL'];?>/admin/horoscopevalidation/adminhoroscopeadd.php" enctype="multipart/form-data" style="padding:0px;margin:0px;"> 
			<div class="smalltxt">
			<div id="photodiv" style="padding: 0px 20px 20px 15px;">
			<!-- TR1 -->
			<div style="text-align: left;align:left;">
			<div class="mediumtxt boldtxt clr3">Manage Horoscope<br clear="all"></div>
			<div style="padding-top: 5px;">
			Members prefer to view and contact profiles that have horoscope. A horoscope increases your chances of being contacted by 20 times.<br>
			You can upload horoscope in JPG, GIF format. (File size limit is 300 KB for horoscope)</div>
			</div><br clear="all"> 
			<!-- TR-2 - Photo -Div -->								
				<!-- Icon Div -->
				<div id="useracticons">
				<div id="useracticonsimgs">
					<!-- Row 1 -->
					<div>
						<? if (trim($arrSelectPhotoInfo['HoroscopeURL']) != ''){
							?>
							<div style="display:block;padding: 8px;" class="fleft">
								<div class="smalltxt">
									<div class="fleft">
										<A  onClick="photoUpload('change');" class="clr1 pntr">Change</A>
									</div>
									<div class="fleft" style="padding-left:8px;">
										<A href="javascript:;" onclick="javascript:document.getElementById('photodelete').src='horoscopedelete.php?ID=<?=$varMatriId;?>';document.getElementById('divphotodelete').style.display='block';document.getElementById('photodelete').height='75px';"  class="clr1 pntr">Delete</A>

										<!-- <A href="javascript:;" onclick="javascript:horo_del('<?=$varMatriId;?>')"  class="clr1 pntr">Delete</A> -->
									</div>
									<div class="fleft" style="padding-left:8px;"><a href=javascript:;  onclick='javascript:window.open("adminshowhoroscope.php?MATRIID=<?=$varMatriId;?>&PNO=1","viewphoto","height=600,width=800,scrollbars=yes");' class="clr1 pntr">View Horoscope</a></div>
									
								</div><br clear="all">
							<div>
							<?} else { ?>
								<div style="display:block; padding: 8px;" class="fleft"><a class="smalltxt clr1" onClick="photoUpload('add');"><u>Add Horoscope</u></a></div>
							<? }
						?>
					</div>
					
					<!-- Row 2 - End -->		
					<a name="addphoto"></a>
					<div style="margin:0px; padding:0px;">	
						<div id="uploadDIV" class="photow" style="display:none; padding-top:5px;">
						<div class="vdotline1" style="float: left; width: 480px; height: 4px;"><img src="<?=$confValues["IMGSURL"]?>/trans.gif" width="1" height="4" /></div><br clear="all">
							<span class="errortxt" style="width:450px;padding-top:3px;display:none;" id="errdiv"></span>
							<div class="fleft" style="width:450px;">
								<div style="float: left;">
								<input type="file" id="newhoroscope" name="newhoroscope" accept="image/gif, image/jpeg" >
							</div> 
							<div style="float: left; padding-left: 20px; padding-top: 3px;">
								<input value="Upload" class="button" type="submit" >
							</div>
							<div style="float: left; padding-left: 20px; padding-top: 5px;">
								<a href="javascript:;" onclick="divclose('uploadDIV');" class="smalltxt clr1">
									<u>Cancel</u>
								</a><input name="photono" id="photono" type="hidden">
								<input name="matriid" type="hidden"  value="<?=$varMatriId;?>">
								<input name="frmAddPhotoSubmit" id="frmAddPhotoSubmit" type="hidden" value="yes">
								<input name="action" id="action" type="hidden" value="">
							</div>					
						</div>			
					</div>
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

<!-- 	<div id="icondiv" class="frdispdiv" style="padding:10px;"><div style="float:right;" id="closeicon"><a href="javascript:;" onclick="closeIframe('iframeicon','icondiv');window.location.reload();"><img src="<?=$confValues['IMGSURL']?>/close-icon.gif" alt="" border="0" height="11" width="11" align="right"></a></div><iframe src="" id="iframeicon" frameborder="0"></iframe></div>
	<div id="fade" class="bgfadediv"></div> -->
	<!-- inside content -->
								</div>
							</div>		
						</div><br clear="all">
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
function photoUpload(action){	
	document.getElementById('action').value=action;
	document.getElementById('uploadDIV').style.display="block";
}
</script>
<? }?>
