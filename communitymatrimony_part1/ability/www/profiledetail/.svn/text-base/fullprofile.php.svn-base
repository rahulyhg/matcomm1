<?php
#=====================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-01
# Project	  : MatrimonyProduct
# Filename	  : fullprofile.php
#=====================================================================================================================
# Description : display other member profile view and print profile. 
#=====================================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');
include_once($varRootBasePath.'/lib/clsCommon.php');

//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessGender			= $varGetCookieInfo["GENDER"];
$sessPublish		= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus		= $varGetCookieInfo["PAIDSTATUS"];
$sessPhotoStatus	= $varGetCookieInfo['PHOTOSTATUS'];
$sessPhoneStatus	= $varGetCookieInfo['PHONEVERIFIED'];
$sessPhysicalStatus	= $varGetCookieInfo["PHYSICALSTATUS"];

//REQUEST VARIABLES
$varCurrPgNo		= $_REQUEST['cpno'];
$varMatriId 		= ($_REQUEST['id']!='')?trim($_REQUEST['id']):$sessMatriId;
$varTMEView = 0;

/*$varAlertMsg	= '';
if($sessPhotoStatus == 0){
	$varAlertMsg = 'Add your photo';
}
if($sessPhoneStatus == 0){
	$varInnCont	 = $varAlertMsg=='' ? '' : ' & ';
	$varAlertMsg .= $varInnCont.'Verify your phone number';
}*/

//SCRIPTS FOR CBS TME VIEW PROFILE - STARTS
function decrypt($string, $key) {
	$result = '';
	$string = base64_decode($string);
	for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	return $result;
}

if (trim($_GET['tmecode'])!='') {
	$varencstring = trim($_GET['tmecode']);
	//echo '<br /> Decrypt : '.decrypt($varencstring, '$&$');
	//echo '<br /> id : '.str_replace('CBS&TME', '', decrypt($varencstring, '$&$'));
	$varMatriId = str_replace('CBS&TME', '', decrypt($varencstring, '$&$'));
	$sessMatriId = 'TMEVIEW';
	$varTMEView = 1;
}
//SCRIPTS FOR CBS TME VIEW PROFILE - ENDS

//OBJECT DECLARATION
$objProfileDetail		= new MemcacheDB;
$objProfileOtherDtl		= new ProfileDetail;
$objDomain				= new domainInfo;
$objCommon				= new clsCommon;

$varLogoName	= $arrDomainInfo[$varDomain][2];
if ($varLogoName=='') { $varLogoName	= 'community'; }

//$objProfileDetail		= new ProfileDetail;

$objProfileDetail		-> dbConnect('S',$varDbInfo['DATABASE']);

$varCondition			= " WHERE MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail)." AND ".$varWhereClause;
$varCheckProfileId		= $objProfileDetail->numOfRecords($varTable['MEMBERINFO'],'MatriId',$varCondition);

if($sessMatriId!='') {
	if($varCheckProfileId==0) {
		$varCondition		= " WHERE User_Name=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail)." AND ".$varWhereClause;
		$varFields			= array('MatriId');
		$varSelProfileId	= $objProfileDetail->select($varTable['MEMBERINFO'],$varFields,$varCondition,1);
		$varMatriId			=  $varSelProfileId[0]['MatriId'];
		$varMatriId != ''?$varCheckProfileId=1:$varCheckProfileId=0;
	}

	//SETING MEMCACHE KEY
	$varOwnProfileMCKey		= 'ProfileInfo_'.$sessMatriId;
	$varOppositeProfileMCKey= 'ProfileInfo_'.$varMatriId;

	if($varCheckProfileId > 0 ) {
		
		$varCurrentDate		= date('Y-m-d H:i:s');

		include_once('profiledetail.php');

		#GETTING LOGIN INFORMATION FOR SELECTED PROFILE
		$argFields				= array('ml.MatriId','ml.User_Name','ml.Email','mi.Paid_Status','mi.Valid_Days','mi.Last_Payment');
		$argTables				= $varTable['MEMBERLOGININFO']." as ml,".$varTable['MEMBERINFO']." as mi";
		$argCondition			= "WHERE ml.MatriId = mi.MatriId AND ml.MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail)." AND mi.MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
		$varLoginInfoResultSet	= $objProfileDetail->select($argTables,$argFields,$argCondition,0);
		$varLoginInfo			= mysql_fetch_assoc($varLoginInfoResultSet);

		$varUserName			= $varLoginInfo['User_Name'];
		$varPaidDate			= $varLoginInfo['Last_Payment'];
		$varValidDays			= $varLoginInfo['Valid_Days'];

		//Checking Values For Profile
		if ((($sessMatriId != $varMatriId) ||$sessMatriId == "")) {
			if($varPublish == 0) {
				$varFilterMessage = "Sorry, you cannot view this member's profile as it is currently under validation.";
			} else if($sessPhysicalStatus == 0 && $sessPhysicalStatus == $varPhysicalStatusVal ) {
				$varFilterMessage = "Sorry! You cannot view profiles of same physical status.";
			} else if($varPublish == 2) {
				$varFilterMessage = "MatriId <b>".$varMatriId."</b> is hidden and cannot be viewed by others.";
			} else if($varPublish == 3) {
				$varFilterMessage = "Sorry, this member's profile has been suspended. ";
			} else if($varPublish == 4) {
				$varFilterMessage = "Sorry, this member's profile does not exist. ";
			} else if($varPublish == 5) {
				$varFilterMessage = "Sorry, this member's profile does not exist. ";
			} else if($sessGender == $varMemberInfo['Gender']) {
				$varFilterMessage = "Sorry! You cannot view profiles of your gender.";
			}
		}

		if($varFilterMessage=='') {
			//get value for first photo and horoscope for checking photo under validation and horoscope under validation
			$varPhHoroCondition	= "WHERE MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
			$varPhHoroCount		= $objProfileDetail->numOfRecords($varTable['MEMBERPHOTOINFO'],'MatriId',$varPhHoroCondition);

			if($varPhHoroCount>0) {
				$varPhHoroFields	= array('Normal_Photo1');
				$varPhHoroResultSet	= $objProfileDetail->select($varTable['MEMBERPHOTOINFO'],$varPhHoroFields,$varPhHoroCondition,0);
				$varPhoneHorosope	= mysql_fetch_array($varPhHoroResultSet);

				//Photo Part Starts
				if($varPhotoStatus == 0 && $varPhoneHorosope['Normal_Photo1']!='') {
					$varReqImg			=($varGenderCode==1)?"img85_phundval_m.gif":"img85_phundval_f.gif";
					$varSinglePhoto		= $confValues['IMGSURL']."/".$varReqImg;
				} else if($varPhotoStatus == 0 && $varPhoneHorosope['Normal_Photo1']=='') {
					$varReqImg			=($varGenderCode==1)?"img85_phnotadd_m.gif":"img85_phnotadd_f.gif";
					$varSinglePhoto		= $confValues['IMGSURL']."/".$varReqImg;
				} else {
					if($varMatriId == $sessMatriId) { 
						$varPhotoDetail	= $objProfileOtherDtl->photoDisplay(1,$varMatriId,$varDbInfo['DATABASE'],$varTable);
					} else if($varMatriId != $sessMatriId){ //FOR OTHER MEMBERS VIEWING MEMBERS PHOTO
						if($varPhotoStatus == 1 && $varProtectPhotoStatus==1) {
							$varReqImg		= "img85_pro.gif";
							$varSinglePhoto	= $confValues['IMGSURL']."/".$varReqImg;
						} else if($varPhotoStatus == 1) {
							$varPhotoDetail	= $objProfileOtherDtl->photoDisplay(2,$varMatriId,$varDbInfo['DATABASE'],$varTable);
						}
					}
				}
				//Photo Parts Ends
			} else {
				$varReqImg			=($varGenderCode==1)?"img85_phnotadd_m.gif":"img85_phnotadd_f.gif";
				$varSinglePhoto		= $confValues['IMGSURL']."/".$varReqImg;
			}

			if(sizeof($varPhotoDetail)>0) {
				$varPhotoPath		= $confValues['PHOTOURL']."/".$varMatriId{3}."/".$varMatriId{4};
				$arrPhotoDetail		= explode('~',$varPhotoDetail);
				$arrThumbPhotoName	= explode('^',$arrPhotoDetail[0]);//Thumb small Photo
				if($arrThumbPhotoName[0] != '') {
					$varPhotoCount		= sizeof($arrThumbPhotoName);
				}
				if($varPhotoCount>0) { 
					if($varMatriId != $sessMatriId && $varProtectPhotoStatus==1) { 
						$varReqImg		= "img85_pro.gif";
						$varSinglePhoto	= $confValues['IMGSURL']."/".$varReqImg;
					} else { 
						$varSinglePhoto	= $varPhotoPath."/".$arrThumbPhotoName[0];
					}
				}
			}
			?>
			</head>
			<head>
				<title><?=$confPageValues['PAGETITLE']?></title>
				<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
				<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
				<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
				<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
				<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
				<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
				<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
				<script language="javascript">var cook_id	  = '<?=$sessMatriId?>',cook_un	  = '<?=$sessUsername?>', cook_paid = '<?=$sessPaidStatus?>', cook_gender = '<?=$sessGender?>', imgs_url= '<?=$confValues["IMGSURL"]?>', img_url	= '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url	= '<?=$confValues["SERVERURL"]?>';</script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
				<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js"></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/cookie.js" ></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>
			</head>
				<body>
					<center>
						<div class="innerdiv">
							<div class="fleft logodiv"><a href="<?=$confValues['SERVERURL']?>/<?=$sessMatriId ? 'profiledetail/' : ''?>"><img src="<?=$confValues['IMGSURL']?>/logo/<?=$varLogoName?>_logo.gif" alt="<?=ucfirst($arrDomainInfo[$varDomain][2])?>Matrimony" border="0" /></a></div>
							<div class="fright padtb10 padr10"><a href="javascript:;" onclick="window.print();"><img src="<?=$confValues['IMGSURL']?>/print.gif" class="pntr" /></a></div><br clear="all"><br>
							<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
							<div id="fvpdiv1" class="fleft">

								<div id="fvpdiv3" class="normtxt bld clr fleft"><? echo ($checkcrawlingbotsexists == false)? $varDisplayName.' ('.$varMatriId.')' : $varMatriId;?>			</div>
								<div id="infdiv1" class="smalltxt clr2 fleft">Active: <?=$varLastLogin;?></div><br clear="all">
								<div id="fvpdiv4" class="normtxt clr"><?if($varAge != '0'){ echo $varAge.' yrs';}if($varMemberInfo['Height'] != '0.00'){ echo ', '.$varHeight;}?> <?if($varRelSubcaste!=''){ echo '<font class="clr2">|</font> '.$varRelSubcaste; }?>  <font class="clr2">|</font> <?if($varStar!=0){ echo $varStar.','; }?> <?if($varResidingCity != ''){ echo $varResidingCity.', ';} if($varResidingState != '0'){ echo $varResidingState.', ';} if($varCountryname != ''){ echo $varCountryname;}?> <font class="clr2">|</font> <?if($varEducation != ''){ echo $varEducation;}?>  <?if($Occupation!=''){echo '<font class="clr2">|</font> '.$Occupation;}?> </div>
							</div>

							<div id="fvpdiv2" class="fleft">
								<div id=""><img src="<?=$varSinglePhoto?>" width="85" height="85" border="0" alt="" /></div>
							</div><br clear="all"/><br clear="all">
							<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">

							<div class="normtxt bld clr padl25">About me</div><br clear="all"/>
							<?if($varProfileCreatedBy!='') {?>
							<div id="procre" class="tlright fvpdiv5 padtb3 fleft">Profile created by :</div>
							<div id="par" class="fvpdiv5a padl310 fleft"><?=$varProfileCreatedBy?></div><br clear="all"/>
							<?}?>

							<div id="probas" class="tlright fvpdiv5 padtb3 fleft">Basic Information :</div>
							<div id="bas" class="fvpdiv5a padl310 fleft"><?=$varBasicStr?></div><br clear="all"/>

							<div id="prophy" class="tlright fvpdiv5 padtb3 fleft">Physical Status :</div>
							<div id="phy" class="fvpdiv5a padl310 fleft"><?=$varPhysicalStatusStr?></div><br clear="all"/>

							<div id="probel" class="tlright fvpdiv5 padtb3 fleft">Cultural Background :</div>
							<div id="bel" class="fvpdiv5a padl310 fleft"><?=$varBeliefsStr?></div><br clear="all"/>

							<div id="procar" class="tlright fvpdiv5 padtb3 fleft">Career :</div>
							<div id="car" class="fvpdiv5a padl310 fleft"><?=$varCareerStr_EduLong?></div><br clear="all"/>

							<div id="proloc" class="tlright fvpdiv5 padtb3 fleft">Location :</div>
							<div id="loc" class="fvpdiv5a padl310 fleft"><?=$varLocationStr?></div><br clear="all"/>

							<div id="proabme" class="tlright fvpdiv5 padtb3 fleft">Few lines about me :</div>
							<div id="flines" class="fvpdiv5a padl310 fleft"><?=$varAboutmySelf?></div>
							<br clear="all"/>	<br clear="all"/>

						<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
							
							<div class="normtxt bld clr padl25">Lifestyle</div><br clear="all"/>
							<?if($varHabitsStr=='' && $varInterestSetStatus==0) { echo "<div class='fvpdiv5a padl310 fleft' style='padding-left:50px'>Life style information not set</div>";} else {?>
							<?if($varHabitsStr!='') { ?>
							<div class="tlright fvpdiv5 padtb3 fleft">Habits :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varHabitsStr?></div><br clear="all"/>
							<? } if($varInterest!='') {?>
							<div class="tlright fvpdiv5 padtb3 fleft">Interests :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varInterest?>...</div><br clear="all"/>
							<? } if($varHobbies!='') {?>
							<div class="tlright fvpdiv5 padtb3 fleft">Hobbies :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varHobbies?></div><br clear="all"/>
							<? } if($varFavouriteStr!='') {?>
							<div class="tlright fvpdiv5 padtb3 fleft">Favourites :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varFavouriteStr?>...</div><br clear="all"/> 
							<? }}?>

							<br clear="all">
						<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
							
							<div class="normtxt bld clr padl25">Family</div><br clear="all"/>
							<?if($varFamilySetStatus==0) { echo "<div class='fvpdiv5a padl310 fleft' style='padding-left:50px'>Family information not set</div>";} else {
							 if($varFamilyValue!='') {?>
							<div class="tlright fvpdiv5 padtb3 fleft">Family value :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varFamilyValue?></div><br clear="all"/>
							<? } if($varFamilyType!='' || $varFamilyStatus != '') {
								$commaSeparator = "";
								$varFamilyTypeAndStatus = "";
								if ($varFamilyType!='') {
									$varFamilyTypeAndStatus = $varFamilyType;
									$commaSeparator = ", ";
								}
								if ($varFamilyStatus != '') {
									$varFamilyTypeAndStatus .= $commaSeparator.$varFamilyStatus;
								}
							?>
							<div class="tlright fvpdiv5 padtb3 fleft">Family Type & Status :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varFamilyTypeAndStatus?></div><br clear="all"/>
							<? } if($varFamilyOrigin!='') {?>
							<div class="tlright fvpdiv5 padtb3 fleft">Ancestral Origin :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varFamilyOrigin?></div><br clear="all"/>
							<? } if($varReligiousValues!='') {?>
							<div class="tlright fvpdiv5 padtb3 fleft">Religious values :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varReligiousValues?></div><br clear="all"/>
							<? } if($varEthnicity!='') {?>
							<div class="tlright fvpdiv5 padtb3 fleft">Ethnicity :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varEthnicity?></div><br clear="all"/>
							<? } if($varParenstOccStr!='') {?>
							<div class="tlright fvpdiv5 padtb3 fleft">Parents Occupation :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varParenstOccStr?></div><br clear="all"/>
							<? } if($varSiblingsStr!='') {?>
							<div class="tlright fvpdiv5 padtb3 fleft">Siblings :</div>
							<div class="fvpdiv5a padl310 fleft"><?=trim($varSiblingsStr,', ')?></div><br clear="all"/>
							<? } if($varAboutFamily!='') {?>	
							<div class="tlright fvpdiv5 padtb3 fleft">Few lines about my family :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varAboutFamily?></div><br clear="all"/>
							<? }} ?><br clear="all">
						<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
							
							<div class="normtxt bld clr padl25">My Partner</div>
							<?if($varPartnerSetStatus==0) { echo "<div class='fvpdiv5a padl310 fleft' style='padding-left:50px'>Partner information not set</div>";} else {?>
							<div class="padtb5 padl25">I want to marry someone who meets most of my preferences which I have noted here.</div>
							<div class="tlright fvpdiv5 padtb3 fleft">Basic partner preference :</div>
							<div class="fvpdiv5a padl310 fleft"><?=trim($varPartnerBasicStr,', ')?></div><br clear="all"/>

							<?if($varPartnerBeliefs!=''){?>
							<div class="tlright fvpdiv5 padtb3 fleft">Cultural Background :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varPartnerBeliefs?></div><br clear="all"/>
							<?}?>
							
							<div class="tlright fvpdiv5 padtb3 fleft">Career :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varPartnerCareerStr?></div><br clear="all"/>

							<div class="tlright fvpdiv5 padtb3 fleft">Location :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varPartnerLocStr?></div><br clear="all"/>
							
							<?if($varPartnerHabits!='') { ?>
							<div class="tlright fvpdiv5 padtb3 fleft">Lifestyle :</div>
							<div class="fvpdiv5a padl310 fleft"><?=trim($varPartnerHabits,', ');?></div><br clear="all"/>
							<? } ?>

							<?if($varPartnerDescription!='') { ?>
							<div class="tlright fvpdiv5 padtb3 fleft">Few lines about my partner :</div>
							<div class="fvpdiv5a padl310 fleft"><?=$varPartnerDescription?></div><br clear="all"/>
							<? }} ?><br clear="all">


						<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
							<? if ($varTMEView == 0) { //TME view check ?>
							<div class="normtxt bld clr padl25 padb10">Phone</div>
							<div id='<?=$varCurrPgNo?>vp8' class="padtb5 padl25">
							<?if($varMatriId == $sessMatriId) { ?>
								<img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="getPhoneView('<?=$varMatriId?>','<?=$varCurrPgNo?>vp8');">
							<?} else { 
									if($varPhoneVerified==1 || $varPhoneVerified==3) {
										if($sessPaidStatus==1) { ?>
											<div id="phmsg" class="disblk">
												Are you sure you want to view this member's phone number?<br clear="all"><br clear="all">
												<div class="fright padr20">
													<input type="button" onClick="getPhoneView('<?=$varMatriId?>','<?=$varCurrPgNo?>vp8');" value="Yes" class="button">
													<input type="button" onClick="" value="No" class="button">
												</div>
											</div>
										<? } else { ?>
											<center>
												<div class="padtb3 fleft"><br><br><br>
													<div class="fleft pad3">Phone Number :</div>
													<div class="fleft"><img src="<?=$confValues['IMGSURL']?>/blurimg.gif" alt="" /></div>
													<div class="fleft pad3"> <a class="clr1 bld" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo"><?=$objCommon->getPhoneNumberValidationStatus($sessPhoneStatus,$sessPaidStatus);?></a> to view phone number.</div>
												</div>
											</center><br clear="all"/>
										<? }
									} else { ?>
										<div class="normtxt">
											This member has not added phone number. If you would like to view this member's phone number, you can request member to add it.<br clear="all"><br clear="all">
											<div class="fright padr20"><input type="button" class="button" name="" value="Request Now"onClick="sendRequest('<?=$varMatriId?>','3','<?=$varCurrPgNo?>vp8');"></div>
										</div>
										
									<? }
								}?>
							</div><br clear="all"/><br clear="all">

						<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
						<? } // TME VIEW Check?>

						</div>
					</center>
				</body>
			</html>
		<?}
	} else {
		$varFilterMessage = "Sorry, this member's profile does not exist.";
	}
} else {
	$varFilterMessage = "Sorry, registered member only can view full profile.";
}

//UNSET OBJECTS
$objProfileDetail->dbClose();
unset($objProfileDetail);

if($varFilterMessage!='') {?>
	<div class="rpanel brdr tlcenter pad10">
		<?=$varFilterMessage?>
	</div>
<?}?>
