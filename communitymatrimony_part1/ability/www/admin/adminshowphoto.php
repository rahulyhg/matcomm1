<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		: viewphoto.php
#================================================================================================================
   # Description	: photo class use to resize photo and new photoname
#================================================================================================================

//ini_set('display_errors',1);
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath."/www/admin/includes/config.php");
//SESSION VARIABLES
$sessMatriId		= $_REQUEST['MATRIID'];
$varOppositeId		= $sessMatriId;
//Object initialization
$objSlaveDB			= new DB;

//CONNECTION DECLARATION
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($sessMatriId,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

//img server path
$varDomainName		= $arrPrefixDomainList[$varPrefix];
$varIMGServer		= 'http://img.'.$varDomainName;

$varPhotoURL		= $varIMGServer.'/membersphoto/'.$varFolderName;

$varFields			= array('*');
$varCondition		= "WHERE MatriId = '".$varOppositeId."'";
$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
$varSelectPhotoInfo = mysql_fetch_assoc($varResult);
$varFields			= array('Name','Photo_Set_Status','User_Name','Protect_Photo_Set_Status');
$varCondition		= "WHERE MatriId = '".$varOppositeId."'";
$varResult			= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
$varMemberInfo		 = mysql_fetch_assoc($varResult);
$varName			= $varMemberInfo['Name'];
$varPhotoStatus		= $varMemberInfo['Photo_Set_Status'];
$varPhotoProtect	= $varMemberInfo['Protect_Photo_Set_Status'];
$varPhotoCount		=	0;



function viewPhotoPermit($adminUserName='',$objSlaveDB) {
	global $varDbInfo, $varTable;
	//DB CONNECTION
	//$objDBSlave = new DB;
	//$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
	$varCondition		= " WHERE User_Name='".$adminUserName."'";
	$varFields			= array('Photo_View');
	$varSelProfileId	= $objSlaveDB->select($varTable['ADMINLOGININFO'],$varFields,$varCondition,1);
	$varPhotoViewOpt	=  $varSelProfileId[0]['Photo_View'];
	return $varPhotoViewOpt;
}

$varPhotoViewOpt = viewPhotoPermit($adminUserName,$objSlaveDB);
if ($varPhotoViewOpt==0 && $varPhotoProtect==1) {
	echo 'You are not authorized to view the photo...';
	exit;
}

if($sessMatriId == $varOppositeId){
	for ($i=1;$i<=10;$i++){
		if($varSelectPhotoInfo['Thumb_Big_Photo'.$i] != '' )
		$varPhotoCount++;
	}
}else{
	for ($i=1;$i<=10;$i++){
		if (($varSelectPhotoInfo['Photo_Status'.$i] == 1 || $varSelectPhotoInfo['Photo_Status'.$i] == 2) && $varSelectPhotoInfo['Thumb_Big_Photo'.$i] != '' )
		$varPhotoCount++;
	}
}

$varDefaultMode			= 0;
if (($varPhotoStatus == 1 || $varPhotoStatus == 0) && $varOppositeId == $sessMatriId)
	$varDefaultMode		= 1;
elseif ($varPhotoStatus == 1 && $varOppositeId != $sessMatriId)
	$varDefaultMode		= 1;
$varPhotoNo				= trim($_REQUEST['PNO'] != '')? $_REQUEST['PNO']:1;
if (($varPhotoNo == '' || $varPhotoNo == 0 || $varPhotoNo > 10) && $varOppositeId != $sessMatriId )
	$varPhotoNo			= 1;
$varDescription			= $varSelectPhotoInfo['Description'.$varPhotoNo];
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/useractions-sprites.css">
<script>
var varConfArr=new Array(); varConfArr['domainimgs']="<?=$confValues['IMGSURL']?>"; varConfArr['domainweb'] = "<?=$confValues['SERVERURL']?>";varConfArr['domainname'] = "<?=$confValues['DOMAINNAME']?>"; varConfArr['domainimage'] = "<?=$confValues['IMAGEURL']?>";varConfArr['webimgs']="<?=$confValues['PHOTOURL']?>"; varConfArr['domainimg'] = "<?=$confValues['IMGURL']?>"; varConfArr['productname'] = "<?=$confValues['PRODUCTNAME']?>";
</script>
<script	language=javascript src="<?=$confValues['JSPATH'];?>/ajax.js" ></script>
<script language=javascript  src="<?=$confValues['JSPATH'];?>/adminviewphoto.js"></script>
<script>if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){
document.write("<body style='margin:0px' ondragstart='return false;' onmousemove='return false' onmousedown='return false' onselectstart='return false;' oncontextmenu='return false;' onload='clearData();' onunload='clearData();' onblur='clearData();'>");
function clearData(){
		window.clipboardData.setData('text','')
}
window.focus=clearData();
setInterval('clearData();',1000)
document.write("</body>");
}</script>
<script>var message="";function clickIE() {if (document.all){(message);return false;}}
function clickNS(e) {if(document.layers||(document.getElementById&&!document.all)){
if (e.which==2||e.which==3) {(message);return false;}}}if (document.layers)
{document.captureEvents(Event.MOUSEDOWN);document.  onmousedown=clickNS;}else{document.onmouseup=clickNS;document.oncontextmenu  =clickIE;}
document.oncontextmenu=new Function("return false")</script>
<div style="width:880px;margin:10px;">
<div class="fleft" style="width:"640">
	<? if ($varPhotoCount > 0){?>
	<table border="0" cellpadding="0" cellspacing="0" width="640">
		<tr><td colspan=4>
			<div class="fleft">
				<img src="http://img.communitymatrimony.com/images/logo/community_logo.gif" ></div>
			</td>
		</tr>
		<tr><td style="padding-top:5px;"colspan=4>
				<div class="vdotline1"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" height="1"
				></div></td>
		</tr>
		<tr colspan=4>
			<td valign="top" align="center">
				<?		$varTemValue	= 0;
						for ($i=1;$i<=$varPhotoCount;$i++){
							//echo $varRootBasePath;
							//echo $varSelectPhotoInfo['Photo_Status'.$i].'<br>';
							//echo $varRootBasePath."/www/membersphoto/".$varFolderName."/".$varOppositeId{3}."/".$varOppositeId{4}."/".$varSelectPhotoInfo['Thumb_Big_Photo'.$i];
							//echo $varPhotoURL."/".$varOppositeId{3}."/".$varOppositeId{4}."/".$varSelectPhotoInfo['Thumb_Big_Photo'.$i];
							//if (($varSelectPhotoInfo['Photo_Status'.$i] == 1 )  && file_exists($varRootBasePath."/www/membersphoto/".$varFolderName."/".$varOppositeId{3}."/".$varOppositeId{4}."/".$varSelectPhotoInfo['Thumb_Big_Photo'.$i])) {
							if (($varSelectPhotoInfo['Photo_Status'.$i] == 1 )  ) {
								$varTemValue++;
				?>
								<div style="padding-top:10px; padding-right:5px;" id="thumb<?=$i;?>">
									<a href="#">
										<img src="<?=$varPhotoURL;?>/<?=$varOppositeId{3}?>/<?=$varOppositeId{4}?>/<?=$varSelectPhotoInfo['Normal_Photo'.$i];?>" width=75 border=0 height="75" onclick="javascript:showloader();javascript:ph('<?=$varPhotoURL;?>/<?=$varOppositeId{3}?>/<?=$varOppositeId{4}?>/<?=$varSelectPhotoInfo['Thumb_Big_Photo'.$i];?>');showcomment('<?=$varSelectPhotoInfo['Description'.$i];?>');undervalidation('');"></a><br clear="all"><font class="smalltxt clr1">&nbsp;</font>
								</div>
							<?} elseif (($varSelectPhotoInfo['Photo_Status'.$i] == 0 || $varSelectPhotoInfo['Photo_Status'.$i] == 2 )  ) {   //&&  file_exists($varRootBasePath."/www/membersphoto/".$varFolderName."/crop450/".$varSelectPhotoInfo['Thumb_Big_Photo'.$i])
								$varTemValue++;
					?>

										<div style="padding-top:10px; padding-right:5px;" id="thumb<?=$i;?>">
									<a href="#">this one...
										<img src="<?=$varPhotoURL;?>/crop75/<?=$varSelectPhotoInfo['Normal_Photo'.$i];?>" width=75 border=0 height="75" onclick="showloader();javascript:ph('<?=$varPhotoURL;?>/crop450/<?=$varSelectPhotoInfo['Thumb_Big_Photo'.$i];?>');showcomment('<?=$varSelectPhotoInfo['Description'.$i];?>');undervalidation('Under validation');"></a><br clear="all"><font class="smalltxt">Under validation</font>
								</div>
							<?	}
							if ($varTemValue == 5 )
								echo '</td><td valign="top" align="center">';
						}?>

				<img src="<?=$confValues['IMGSURL'];?>/trans.gif" height="1">
			</td>
			<?
				if ($varSelectPhotoInfo['Photo_Status1'] == 1){
					$varImg	= $varPhotoURL."/".$varOppositeId{3}."/".$varOppositeId{4}."/".$varSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo];
					$varValidation	= 0;
				}else{
					$varImg	= $varPhotoURL."/crop450/".$varSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo];
					$varValidation	= 1;
				}
			?>

			<td valign="top" width="5"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" width="1" height="35"></td>
			<td rowspan="2" width="1" style="background-image:url(<?=$confValues['IMGSURL'];?>/vdotline.gif);"><img src="<?=$confValues['IMGSURL'];?>/trans.gif"  width="1"></td>
			<td valign="top" width="460" style="padding:10px 0px 10px 10px;">
			<div class="fleft" style="padding-left:5px;" >
			<font class="smalltxt bold"><?=$varName?>&nbsp;&nbsp;-&nbsp;&nbsp;<?=$varOppositeId;?></font>
<!-- 			<a href="<?=$confValues['SERVERURL'];?>/profiledetail/index.php?act=viewprofile&id=<?=$varOppositeId;?>" class="smalltxt clr1" target="_blank"><?=$varOppositeId;?></a></font> -->
			</div><br clear="all"><span id="myloader" class="dotline" style="text-align:center;"></span>
			<img src="<?=$varImg;?>" id="large" hspace="2" vspace="2" GALLERYIMG="no"  onLoad="javascript:hideloader();"><br><span id='validation' class='mediumtxt fleft'><?=($varValidation==1)? 'Under validation':'';?></span>
			<div class="divborder content" style="margin-top:5px; padding:5px; width:440px !important; width:450px; display:<?=((trim($varDescription)!= '')?'block':'none');?>" id="descript"><?=$varDescription;?></div>
			</td>
			</tr>
			<tr>  <td>&nbsp;</td> <td>&nbsp;</td></tr>
			<tr><td colspan=4 style="padding-top:5px;">
				<div class="vdotline1"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" height="1"></div>
			</td></tr>
		</table>
	<? }
	$objSlaveDB->dbClose();
	?>
	</div>
</div>
<?
$varPhotoView = 1;
$varMatriId = $sessMatriId;
include_once "adminviewlog.php";
?>