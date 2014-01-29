<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		: viewphoto.php
#================================================================================================================
   # Description	: photo class use to resize photo and new photoname
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/privilege.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

//SESSION VARIABLES
$sessMatriId		= $varGetCookieInfo['MATRIID'];
$sessPaidStatus		= $varGetCookieInfo["PAIDSTATUS"];

//OBJECT INITIALIZATION
$objSlaveDB			= new MemcacheDB;

//CONNECTION DECLARATION
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$varOppositeId		= $_REQUEST['ID'];
$varPassword		= base64_decode(trim($_REQUEST['PID']));
$varFields			= array('Photo_Protected','Photo_Protect_Password');
$varCondition		= "WHERE MatriId = ".$objSlaveDB->doEscapeString($varOppositeId,$objSlaveDB);
$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
$varSelectPhotoInfo = mysql_fetch_assoc($varResult);
$varProtectPassword = $varSelectPhotoInfo['Photo_Protect_Password'];

if ($sessMatriId != $varOppositeId && $varSelectPhotoInfo['Photo_Protected'] == 1) {
	if ((md5($varPassword) != $varProtectPassword) && ($varPassword != $varProtectPassword)) { header("Location: ".$confValues['SERVERURL']."/profiledetail/".$varFullViewIndex."?act=fullprofilenew&id=".$varOppositeId);exit;
	}
}


//SETING MEMCACHE KEY
$varOppositeProfileMCKey= 'ProfileInfo_'.$varOppositeId;

$varFields			= array('*');
$varCondition		= "WHERE MatriId = ".$objSlaveDB->doEscapeString($varOppositeId,$objSlaveDB);
$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 0);
$varSelectPhotoInfo = mysql_fetch_assoc($varResult);
$varFields			= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
$varCondition		= "WHERE MatriId = ".$objSlaveDB->doEscapeString($varOppositeId,$objSlaveDB)." AND ".$varWhereClause;
$varMemberInfo		= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0, $varOppositeProfileMCKey);
$varName			= $varMemberInfo['Name'];
$varPhotoStatus		= $varMemberInfo['Photo_Set_Status'];
$varoppositeGender	= $varMemberInfo['Gender'];

$varDefaultMode			= 0;
if (($varPhotoStatus == 1 || $varPhotoStatus == 0) && $varOppositeId == $sessMatriId) 
	$varDefaultMode		= 1;
elseif ($varPhotoStatus == 1 && $varOppositeId != $sessMatriId) 
	$varDefaultMode		= 1;
$varPhotoNo				= trim($_REQUEST['PNO'] != '')? $_REQUEST['PNO']:1;
if (($varPhotoNo == '' || $varPhotoNo == 0 || $varPhotoNo > 10) && $varOppositeId != $sessMatriId )
	$varPhotoNo			= 1;

?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
<script	language=javascript src="<?=$confValues['JSPATH'];?>/ajax.js" ></script>
<script language=javascript  src="<?=$confValues['JSPATH'];?>/viewphoto.js"></script>
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

<div class="fleft">
	<table border="0" cellpadding="0" cellspacing="0" width="640">
		<tr><td colspan=4 width="640">
			<div class="fleft">
				<img src="<?=$confValues['IMGSURL']?>/logo/<?=$arrDomainInfo[$varDomain][2]?>_logo.gif"></div>
			</td>
		</tr>
		<tr><td style="padding-top:5px;" colspan=4 ><div class="linesep"><img height="1" width="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div></td></tr>
		<tr>
			<td valign="top" align="right" width="95">
				<?		$varTemValue	= 0;
						$varSelPhoto	= 0;
						$varFMPhotoCnt	= $confValues['FMPHOTOCNT'];
						$varReqPayImg	= ($varoppositeGender == 1)?'img75_pnow_m.gif':'img75_pnow_f.gif';
						for ($i=1;$i<=10;$i++){
							
							if ($varSelectPhotoInfo['Photo_Status'.$i] == 1 || ($varSelectPhotoInfo['Photo_Status'.$i] == 2 && $varOppositeId != $sessMatriId)&& file_exists($varRootBasePath."/www/membersphoto/".$arrDomainInfo[$varDomain][2]."/".$varOppositeId{3}."/".$varOppositeId{4}."/".$varSelectPhotoInfo['Thumb_Big_Photo'.$i])) {	
								if($varTemValue == 5){echo '</td><td valign="top" align="right" width="95">';}
								$varTemValue++;
								$varSelPhoto++;
								if($varSelPhoto == $varPhotoNo){
										$varDescription		= $varSelectPhotoInfo['Description'.$i];
										$varImg	= $confValues['PHOTOURL']."/".$varOppositeId{3}."/".$varOppositeId{4}."/".$varSelectPhotoInfo['Thumb_Big_Photo'.$i];
								}
				?>
							
								<div style="padding-top:10px; width:80px; height:85px;" id="thumb<?=$i;?>">
										<a href="#">
										<img src="<?=$confValues['PHOTOURL'];?>/<?=$varOppositeId{3}?>/<?=$varOppositeId{4}?>/<?=$varSelectPhotoInfo['Normal_Photo'.$i];?>" width=75 border=0 height="75" onclick="javascript:showloader();javascript:ph('<?=$confValues['PHOTOURL'];?>/<?=$varOppositeId{3}?>/<?=$varOppositeId{4}?>/<?=$varSelectPhotoInfo['Thumb_Big_Photo'.$i];?>');showcomment('<?=$varSelectPhotoInfo['Description'.$i];?>');undervalidation('');"></a><br clear="all">
										<font class="smalltxt clr1">&nbsp;</font>
								</div>
								
							<?} elseif (($varSelectPhotoInfo['Photo_Status'.$i] == 0 || $varSelectPhotoInfo['Photo_Status'.$i] == 2 ) && ($varOppositeId == $sessMatriId) &&  file_exists($varRootBasePath."/www/membersphoto/".$arrDomainInfo[$varDomain][2]."/crop450/".$varSelectPhotoInfo['Thumb_Big_Photo'.$i]) && $varSelectPhotoInfo['Thumb_Big_Photo'.$i] != '') {
								if($varTemValue == 5){echo '</td><td valign="top" align="right" width="95">';}
								$varTemValue++;
								$varSelPhoto++;
								if($varSelPhoto == $varPhotoNo){
										$varDescription		= $varSelectPhotoInfo['Description'.$i];
										$varImg	= $confValues['PHOTOURL']."/crop450/".$varSelectPhotoInfo['Thumb_Big_Photo'.$i]; 
								}
					?>

										<div style="padding-top:10px; width:80px; height:85px;" id="thumb<?=$i;?>">
									<a href="#">
										<img src="<?=$confValues['PHOTOURL'];?>/crop75/<?=$varSelectPhotoInfo['Normal_Photo'.$i];?>" width=75 border=0 height="75" onclick="showloader();javascript:ph('<?=$confValues['PHOTOURL'];?>/crop450/<?=$varSelectPhotoInfo['Thumb_Big_Photo'.$i];?>');showcomment('<?=$varSelectPhotoInfo['Description'.$i];?>');undervalidation('Under validation');"></a><br clear="all"><font class="smalltxt">Under validation</font>
								</div>
							<?	}
						}?>
				 
				
			</td>
			<? 
				if ($varTemValue > 0 && trim($varPhotoNo) >= 1 && trim($varPhotoNo) <=10 && $varDefaultMode == 1 && $_REQUEST['uv'] == 1)
				$varImg	= $confValues['PHOTOURL']."/crop450/".$varSelectPhotoInfo['Thumb_Big_Photo'.$varPhotoNo];
			?>
		
			<td valign="top" width="5"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" width="1" height="35"></td>
			<td valign="top" width="460" style="padding:10px 0px 10px 10px;">
			<div class="fleft" style="padding-left:5px;" >
			<font class="smalltxt bold"><?=($varMemberInfo['Nick_Name']==''? $varMemberInfo['Name']: $varMemberInfo['Nick_Name'])?>&nbsp;&nbsp;-&nbsp;&nbsp;
			<a href="<?=$confValues['SERVERURL'];?>/profiledetail/<?=$varFullViewIndex?>?act=fullprofilenew&id=<?=$varOppositeId;?>" class="smalltxt clr1" target="_blank"><?=$varOppositeId;?></a></font>
			</div><br clear="all"><span id="myloader" class="dotline" style="text-align:center;"></span>
			<img src="<?=$varImg;?>" id="large" hspace="2" vspace="2" GALLERYIMG="no"  onLoad="javascript:hideloader();"><br><span id='validation' class='mediumtxt fleft'><?=($_REQUEST['uv']==1)? 'Under validationn':'';?></span>
			<div class="divborder content" style="margin-top:5px; padding:5px; width:440px !important; width:450px; display:<?=((trim($varDescription)!= '')?'block':'none');?>" id="descript"><?=$varDescription;?></div>
			</td> 
			</tr> 
			<tr><td colspan=4 style="padding-top:5px;">
				<div class="vdotline1"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" height="1"></div>
			</td></tr>
		</table>
	<? 
	$objSlaveDB->dbClose();
	?>
	</div>

<script>
	window.resizeTo(width=650,height=650);
</script>