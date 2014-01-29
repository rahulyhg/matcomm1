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
include_once($varRootBasePath.'/conf/privilege.cil14');
include_once($varRootBasePath.'/conf/messagevars.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');

//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessGender			= $varGetCookieInfo["GENDER"];
$sessPublish		= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus		= $varGetCookieInfo["PAIDSTATUS"];
$sessPhysicalStatus	= $varGetCookieInfo["PHYSICALSTATUS"];
$sessPhotoStatus	= $varGetCookieInfo['PHOTOSTATUS'];
$sessPhoneStatus	= $varGetCookieInfo['PHONEVERIFIED'];

//REQUEST VARIABLES
$varCurrPgNo		= 0;
$arrPhotoDetail		= array();

/*$varAlertMsg	= '';
if($sessPhotoStatus == 0){
	$varAlertMsg = 'Add your photo';
}
if($sessPhoneStatus == 0){
	$varInnCont	 = $varAlertMsg=='' ? '' : ' & ';
	$varAlertMsg .= $varInnCont.'Verify your phone number';
}*/

//OBJECT DECLARATION
$objProfileDetail		= new MemcacheDB;
$objProfileOtherDtl		= new ProfileDetail;
$objDomain				= new domainInfo;
$objCommon				= new clsCommon;

$objProfileDetail-> dbConnect('S',$varDbInfo['DATABASE']);

function givePhotoHoroName($arrTotPhotoDetail,$varMatriId) {
	$arrPhotoHoroName	= array();
	if(sizeof($arrTotPhotoDetail)>0) {
		$arrPhotoDetail		= explode('~',$arrTotPhotoDetail);
		$arrThumbPhotoName	= explode('^',$arrPhotoDetail[0]);//Thumb small Photo
		$arrPhotoStatus		= explode('^',$arrPhotoDetail[1]);//Photo Status
		$arrNormalPhotoName	= explode('^',$arrPhotoDetail[2]);//Normal Photo
		$varHoroscopeURL	= $arrPhotoDetail[3];//Horoscope
		
		if(sizeof($arrThumbPhotoName)>0) { 
			$varSinglePhoto	= $arrThumbPhotoName[0];
		} else {
			$varSinglePhoto	= '';
		}

		$arrPhotoHoroName[]	= $varSinglePhoto;
		$arrPhotoHoroName[]	= $varHoroscopeURL;
	}

	return $arrPhotoHoroName;
}

$varMatriId 			= ($_REQUEST['id']!='')?strtoupper(trim($_REQUEST['id'])):$sessMatriId;
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

		//GETTING BOOKMARKED,IGNORED,BLOCKED INFORMATION FOR THE SELECTED PROFILE
		$varBookMarkClass		= "disnon";
		$varBarDivClass			= "disnon";
		$varBlockedClass		= "disnon";
		$varContactIconStatus	= 0;

		if ($sessMatriId !='') {
			if($sessGender!=$varMemberInfo['Gender']) {
				if ($varMatriId !="" && $sessMatriId !="") {
					$funBookmark	= 0;
					$funIgnored		= 0;
					$funBlocked		= 0;

					//check member action is available or not
					$argCondition	= "WHERE MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND Opposite_MatriId =".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
					$varCheckAction	= $objProfileDetail->numOfRecords($varTable['MEMBERACTIONINFO'],'MatriId',$argCondition);

					if($varCheckAction > 0) {
						$argFields		= array('MatriId', 'Opposite_MatriId', 'Bookmarked', 'Ignored', 'Blocked','Mail_Id_Sent','Mail_Id_Received','Interest_Id_Sent','Interest_Id_Received','Interest_Received_Date', 'Interest_Sent_Date', 'Mail_Sent_Date', 'Mail_Received_Date', 'Receiver_Replied_Date', 'Receiver_Declined_Date', "IF(Interest_Received_Date>Interest_Sent_Date AND Interest_Received_Date>Mail_Received_Date AND Interest_Received_Date>Mail_Sent_Date AND Interest_Received=1 AND Interest_Received_Date>Receiver_Replied_Date AND Interest_Received_Date>Receiver_Declined_Date,Interest_Received_Status,'N') AS IntRec", "IF(Interest_Sent_Date>Interest_Received_Date AND Interest_Sent_Date>Mail_Received_Date AND Interest_Sent_Date>Mail_Sent_Date AND Interest_Sent=1 AND Interest_Sent_Date>Receiver_Replied_Date AND Interest_Sent_Date>Receiver_Declined_Date,Interest_Sent_Status,'N') AS IntSen", "IF(Mail_Sent_Date>Interest_Received_Date AND Mail_Sent_Date>Mail_Received_Date AND Mail_Sent_Date>Interest_Sent_Date AND Mail_Sent=1 AND Mail_Sent_Date>=Receiver_Replied_Date AND Mail_Sent_Date>Receiver_Declined_Date,Mail_Sent_Status,'N') AS MsgSen", "IF(Mail_Received_Date>Interest_Received_Date AND Mail_Received_Date>Mail_Sent_Date AND Mail_Received_Date>Interest_Sent_Date AND Mail_Received=1 AND Mail_Received_Date>Receiver_Replied_Date AND Mail_Received_Date>Receiver_Declined_Date,Mail_Received_Status,'N') AS MsgRec", "IF(Receiver_Replied_Date>Interest_Received_Date AND Receiver_Replied_Date>Mail_Sent_Date AND Receiver_Replied_Date>Interest_Sent_Date AND Receiver_Replied=1 AND Receiver_Replied_Date>Mail_Received_Date AND Receiver_Replied_Date>Receiver_Declined_Date,'Y','N') AS MsgRep", "IF(Receiver_Declined_Date>Interest_Received_Date AND Receiver_Declined_Date>Mail_Sent_Date AND Receiver_Declined_Date>Interest_Sent_Date AND Receiver_Declined=1 AND Receiver_Declined_Date>Mail_Received_Date AND Receiver_Declined_Date>Receiver_Replied_Date,'Y','N') AS MsgDec");
						$funIconResult	= $objProfileDetail->select($varTable['MEMBERACTIONINFO'],$argFields,$argCondition,0);

						while($row = mysql_fetch_array($funIconResult)) {
							$funBookmark	= $row['Bookmarked'];
							$funIgnored		= $row['Ignored'];
							$funBlocked		= $row['Blocked'];
							
							if ($row['IntRec'] != 'N') {
								$varContactIconStatus	= 1; //intreceived
								$varCIconImage			= ($row['IntRec']==0)?"unread":($row['IntRec']==1?"accept":"decline");
								$_REQUEST['msgfl']		= 2;
								$_REQUEST['msgid']		= $row['Interest_Id_Received'];
								$_REQUEST['msgty']		= "R";
								$funCDate				= $row['Interest_Received_Date'];
								$funCMsg				= 'Interest received';
							} elseif ($row['IntSen'] != 'N') {
								$varContactIconStatus	= 1; //intsent
								$varCIconImage			= ($row['IntSen']==0)?"unread":($row['IntSen']==1?"accept":"decline");
								$_REQUEST['msgfl']		= 2;
								$_REQUEST['msgid']		= $row['Interest_Id_Sent'];
								$_REQUEST['msgty']		= "S";
								$funCDate				= $row['Interest_Sent_Date'];
								$funCMsg				= 'Interest sent';
							} elseif ($row['MsgRep'] == 'Y') {
								$varContactIconStatus	= 1; //msgaccept
								$varCIconImage			= 'reply';
								$_REQUEST['msgfl']		= 1;
								$_REQUEST['msgid']		= $row['Mail_Id_Received'];
								$_REQUEST['msgty']		= "R";
								$funCDate				= $row['Receiver_Replied_Date'];
								$funCMsg				= 'Message replied';
							} elseif($row['MsgDec'] == 'Y') {
								$varContactIconStatus	= 1; //msgdecline
								$varCIconImage			= 'decline';
								$_REQUEST['msgfl']		= 1;
								$_REQUEST['msgid']		= $row['Mail_Id_Received'];
								$_REQUEST['msgty']		= "R";
								$funCDate				= $row['Receiver_Declined_Date'];
								$funCMsg				= 'Message declined';
							} elseif ($row['MsgRec'] != 'N') {
								$varContactIconStatus	= 1; //sgrecd
								$varCIconImage			= ($row['MsgRec']==0)?"unread":"read";
								$_REQUEST['msgfl']		= 1;
								$_REQUEST['msgid']		= $row['Mail_Id_Received'];
								$_REQUEST['msgty']		= "R";
								$funCDate				= $row['Mail_Received_Date'];
								$funCMsg				= 'Message received';
							} elseif ($row['MsgSen'] != 'N') {
								$varContactIconStatus	= 1; //msgsent
								$varCIconImage			= ($row['MsgSen']==0)?"unread":($row['MsgSen']==1?"read":($row['MsgSen']==2?"reply":"decline"));
								$_REQUEST['msgfl']		= 1;
								$_REQUEST['msgid']		= $row['Mail_Id_Sent'];
								$_REQUEST['msgty']		= "S";
								$funCDate				= $row['Mail_Sent_Date'];
								$funCMsg				= 'Message sent';
							} else {
								$varContactIconStatus = 0;
								$varCIconImage = '';
							}
						}
					}
				}//if
				
				if($funBookmark==0 && $funBlocked==0) {
					$varBookMarkClass	= "disblk fleft pad3";
					$varBlockedClass	= "disblk fleft pad3";
					$varBarDivClass		= "disblk fleft pad3";
				} else {
					$varBarDivClass		= "disnon";
				}

				if ($funBookmark==1) {
					$varBookMarkClass	= "disnon";
				} else {
					$varBookMarkClass	= "disblk fleft pad3";
				}

				if ($funBlocked==1) { 
					$varBlockedClass	= "disnon";
				}else{
					$varBlockedClass	= "disblk fleft pad3";
				}
			}
		}//if

		if($varContactIconStatus==1) {
			$varOnClick			= 'show_box(event,\'div_box'.$varCurrPgNo.'\');showContactHistory(\''.$sessMatriId.'\',\''.$varMatriId.'\',\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',1);';
			$varContactIconPart = '<div style="padding-top: 10px;" class="vpdiv3 fleft"><font class="smalltxt clr3"><a onclick="'.$varOnClick.'">Last Activity: </a></font><a onclick="'.$varOnClick.'"><img border="0" src="'.$confValues['IMGSURL'].'/'.$varCIconImage.'.gif"/></a><font class="smalltxt clr"> '.$funCMsg.': '.date('d-M-y', strtotime($funCDate)).'</font></div>';
		}


		//Checking Values For Profile
		if ((($sessMatriId != $varMatriId) ||$sessMatriId == "")) {
			if($varPublish == 0) {
				$varFilterMessage = "Sorry, this member's profile does not exist. ";
			} else if($sessPhysicalStatus == 0 && $sessPhysicalStatus == $varPhysicalStatusVal ) {
				$varFilterMessage = "Sorry! You cannot view profiles of same physical status.";
			} else if($varPublish == 2) {
				$varFilterMessage = "MatriId <b>".$varMatriId."</b> is hidden and cannot be viewed by others.";
			} else if($varPublish == 3) {
				$varFilterMessage = "Sorry, this member's profile has been suspended. ";
			} else if($varPublish == 4) {
				$varFilterMessage = "Sorry, this member's profile does not exist. ";
			} else if($sessGender == $varMemberInfo['Gender']) {
				$varFilterMessage = "Sorry! You cannot view profiles of your gender.";
			}
		}

		if($varFilterMessage=='') {
			$varAlertPhotoHoroMsg='';
			//getting Photo Part
			if($varMatriId == $sessMatriId) {
				$arrPhotoDetail		= $objProfileOtherDtl->photoDisplay(1,$varMatriId,$varDbInfo['DATABASE'],$varTable);
				$arrPhotoHoroDetail	= givePhotoHoroName($arrPhotoDetail,$varMatriId);
				if($arrPhotoHoroDetail[0]!= '') {
					if($varPhotoStatus == 1) {
						$varPhotoPath	= $confValues['PHOTOURL']."/".$varMatriId{3}."/".$varMatriId{4};
						$varSinglePhoto	= $varPhotoPath."/".$arrPhotoHoroDetail[0];
					} else {
						$varSinglePhoto = $confValues['PHOTOURL']."/crop150/".$arrPhotoHoroDetail[0];
						$varAlertPhotoHoroMsg	= "Under validation";
					}
					$varOnClick			= "window.open('".$confValues['IMGURL']."/photo/viewphoto.php?ID=".$varMatriId."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
					$varPhotoDispalyPart = '<a onclick="'.$varOnClick.'"><img src="'.$varSinglePhoto.'" width="150" height="150" border="0" alt="" /></a>';
				} else {
					$varReqImg		=($varGenderCode==1)?"img150_phnotadd_m.gif":"img150_phnotadd_f.gif";
					$varSinglePhoto	= $confValues['IMGSURL']."/".$varReqImg;
					$varPhotoDispalyPart = '<img src="'.$varSinglePhoto.'" width="150" height="150" border="0" alt="" />';
				} 
			} else {
				if($varPhotoStatus == 1 && $varProtectPhotoStatus==1) {
					$varSinglePhoto	= $confValues['IMGSURL']."/img150_pro.gif";
					$varOnClick		= ''; 
					$varPhotoDispalyPart = '<a onclick="'.$varOnClick.'"><img src="'.$varSinglePhoto.'" width="150" height="150" border="0" alt="" /></a>';
				} else if($varPhotoStatus == 1) {
					$arrPhotoDetail		= $objProfileOtherDtl->photoDisplay(2,$varMatriId,$varDbInfo['DATABASE'],$varTable);
					$arrPhotoHoroDetail	= givePhotoHoroName($arrPhotoDetail,$varMatriId);
					$varPhotoPath	= $confValues['PHOTOURL']."/".$varMatriId{3}."/".$varMatriId{4};
					$varSinglePhoto	= $varPhotoPath."/".$arrPhotoHoroDetail[0];
					$varOnClick			= "window.open('".$confValues['IMGURL']."/photo/viewphoto.php?ID=".$varMatriId."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
					$varPhotoDispalyPart = '<a onclick="'.$varOnClick.'"><img src="'.$varSinglePhoto.'" width="150" height="150" border="0" alt="" /></a>';
				} else {
					$varReqImg		=($varGenderCode==1)?"img150_phnotadd_m.gif":"img150_phnotadd_f.gif";
					$varSinglePhoto	= $confValues['IMGSURL']."/".$varReqImg;
					$varOnClick		= 'show_box(event,\'div_box'.$varCurrPgNo.'\');sendRequest(\''.$varMatriId.'\',\'1\',\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',1);';
					$varPhotoDispalyPart = '<a onclick="'.$varOnClick.'"><img src="'.$varSinglePhoto.'" width="150" height="150" border="0" alt="" /></a>';
				} 
			}

			//getting Horoscope Part
			//check Horoscope feature available or not
			$varHoroFeature		= $objDomain->useHoroscope();
			$varHoroscopePart	= '';
			if($varHoroFeature == 1) {
				if($varMatriId == $sessMatriId && ($varSameUser==1 || $varUploadMsg!='' || $varHoroAvailable==1 || $varHoroAvailable==3)) {
						$varHoroOnClick = $confValues['IMAGEURL'].'/horoscope/viewhoroscope.php?ID='.$varMatriId;
						$varHoroImg	= ($varHoroAvailable==3 || $varSameUser==1)?'genhoros.gif':'horoscope.gif';
						$varHoroIconPart	= '<a href="#" onClick="window.open(\''.$varHoroOnClick.'\',\'\',\'directories=no,width=650,height=650,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');"><img border="0" src="'.$confValues['IMGSURL'].'/'.$varHoroImg.'"></a>';
				} else {
					if($varHoroAvailable==1 || $varHoroAvailable==3) {
						$varHoroImg	= ($varHoroAvailable==3)?'genhoros.gif':'horoscope.gif';
						if($sessPaidStatus==1) {
							$varHoroOnClick = $confValues['IMAGEURL'].'/horoscope/viewhoroscope.php?ID='.$varMatriId;
							$varHoroIconPart	= '<a href="#" onClick="window.open(\''.$varHoroOnClick.'\',\'\',\'directories=no,width=650,height=650,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');"><img border="0" src="'.$confValues['IMGSURL'].'/'.$varHoroImg.'"></a>';
						} else {
							$varHoroIconPart	= '<a href="#" onClick="show_box(event,\'div_box'.$varCurrPgNo.'\');displayAlert(\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',\'5\');"><img border="0" src="'.$confValues['IMGSURL'].'/'.$varHoroImg.'"></a>';
						}
					} else {
						$varHoroscopePart	= '<div class="disblk fleft pad3">|</div><div class="fleft pad3"><a class="clr1" onClick="show_box(event,\'div_box'.$varCurrPgNo.'\');sendRequest(\''.$varMatriId.'\',\'5\',\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',1);">Request Horoscope</a></div>';
					} 
				}
			}

			//getting Phono No Part
			if($varMatriId != $sessMatriId) {
				if($varPhoneVerified==0 || $varPhoneVerified==2) {
					$varPhonePart	= '<div class="fleft disblk pad3">|</div><div class="fleft pad3"><a class="clr1" onClick="show_box(event,\'div_box'.$varCurrPgNo.'\');sendRequest(\''.$varMatriId.'\',\'3\',\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',1);">Request PhoneNo</a></div>';
				} else if($varPhoneVerified==1 || $varPhoneVerified==3) {
					if($sessPaidStatus==1) {
						$varPhoneIconPart	= '<a href="#phpart"><img border="0" src="'.$confValues['IMGSURL'].'/reqphone.gif"/></a>';
					} else {
						$varPhoneIconPart	= '<a href="#" onClick="show_box(event,\'div_box'.$varCurrPgNo.'\');displayAlert(\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',\'3\');"><img border="0" src="'.$confValues['IMGSURL'].'/reqphone.gif"/></a>';
					}
				}
			} else if($varMatriId == $sessMatriId) {
				$varPhoneIconPart	= '<a href="#phpart"><img border="0" src="'.$confValues['IMGSURL'].'/reqphone.gif"/></a>';
			}
			?>
			<?php
			
			if($_REQUEST['htype']==1 || $_REQUEST['htype']==2){
				$htype=$_REQUEST['htype'];
			}else{
				$horocomparray=array(19,31,47,48);
				if(in_array($varGetCookieInfo['MOTHERTONGUE'],$horocomparray)){
					$htype=2;
				}else{
					$htype=1;
				}
			}
			?>




				<script language="javascript">var cook_id	  = '<?=$sessMatriId?>',cook_un	  = '<?=$sessUsername?>', cook_paid = '<?=$sessPaidStatus?>', cook_gender = '<?=$sessGender?>', imgs_url= '<?=$confValues["IMGSURL"]?>', img_url	= '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url	= '<?=$confValues["SERVERURL"]?>', VPRefresh=true;</script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
				<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js"></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/cookie.js" ></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>
				
				<div class="rpanel fleft normtxt">
					<?=$varContactIconPart?> 
					<div class="fright padtb10 padr10"><a href="<?=$confValues['SERVERURL']?>/profiledetail/fullprofile.php?id=<?=$varMatriId?>" target="_blank"><img src="<?=$confValues['IMGSURL']?>/print.gif" class="pntr" /></a></div><br clear="all">
					<div id="nfvpdiv1" class="fleft" style="line-height:18px;padding-left:4px;">
								<div id="nfvpdiv3" class="normtxt bld clr fleft">
								<? echo ($checkcrawlingbotsexists == false)? $varDisplayName.' ('.$varMatriId.')' : $varMatriId;?>
								<?=$varPhoneIconPart?>
								<?=$varHoroIconPart?><br><div id="horomatchdiv-<?=$varCurrPgNo?>" style="font-weight:normal;"></div>
								</div>
								<div id="ninfdiv1" style="padding-right:5px;" class="smalltxt clr2 fleft">Active: <?=$varLastLogin;?></div><br clear="all">
								<div id="nfvpdiv4" class="normtxt clr"><?if($varAge != '0'){ echo $varAge.' yrs';}if($varMemberInfo['Height'] != '0.00'){ echo ', '.$varHeight;}?> <?if($varRelSubcaste!=''){ echo '<font class="clr2">|</font> '.$varRelSubcaste; }?>  <font class="clr2">|</font> <?if($varStar!=0){ echo $varStar.','; }?> <?if($varResidingCity != ''){ echo $varResidingCity.', ';} if($varResidingState != '0'){ echo $varResidingState.', ';} if($varCountryname != ''){ echo $varCountryname;}?> <font class="clr2">|</font> <?if($varEducation != ''){ echo $varEducation;}?>  <?if($Occupation!=''){echo '<font class="clr2">|</font> '.$Occupation;}?> </div><br clear="all">
								<? if($sessMatriId !=$varMatriId) {
										if(($varPhoneVerified==1 || $varPhoneVerified==3) && $sessPaidStatus==0) { ?>
										<div class="fleft">
											<div class="fleft pad3">Phone Number :</div>
												<div class="fleft"><img src="<?=$confValues['IMGSURL']?>/blurimg.gif" alt="" /></div>
												<div class="fleft pad3"> <a class="clr1 bld" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo"><?=$objCommon->getPhoneNumberValidationStatus($sessPhoneStatus,$sessPaidStatus);?></a> to view phone number.</div>
										</div>
										<? } ?>

										<? if(($varHoroAvailable==1 || $varHoroAvailable==3) && $sessPaidStatus==0) { ?>
										<div class="fleft">
											<div class="fleft pad3">Horoscope :</div>
												<div class="fleft pad3"> <a class="clr1 bld" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo"><?=$objCommon->getPhoneNumberValidationStatus($sessPhoneStatus,$sessPaidStatus);?></a> to view horoscope.</div>
										</div>
										<? } ?>

										<br clear="all"><div class="smalltxt clr2 fleft" style="width:400px;padding-top:15px;">
											<div id="favdiv" class="<?=$varBookMarkClass?> fleft"><a class="clr1" onClick="show_box(event,'div_box<?=$varCurrPgNo?>');lisatadd('shortlist','<?=$varMatriId?>','favdiv','<?=$varCurrPgNo?>');">Add to favourites</a></div>

											<? if ($varPartialFlag =='0') { ?>

											<div id="bardiv" class="<?=$varBarDivClass?> fleft">|</div>
											<div id="blockdiv" class="<?=$varBlockedClass?> fleft"><a class="clr1" onClick="show_box(event,'div_box<?=$varCurrPgNo?>');lisatadd('block','<?=$varMatriId?>','blockdiv','<?=$varCurrPgNo?>');">Block Member</a></div>
											<? echo $varPhonePart;
												echo $varHoroscopePart; } ?>
										</div>
									<? } ?>
							</div>
							<div id="nfvpdiv2" class="fleft">
								<div style="padding:2px;" class="brdr"><?=$varPhotoDispalyPart?></div>
								<div align="center"><?=$varAlertPhotoHoroMsg?></div>
							</div><br clear="all"/>
							<div id="div_box<?=$varCurrPgNo?>" style="padding-left:0px;visibility:hidden;position:absolute;">
								<div id="msgactpart<?=$varCurrPgNo?>" class="boxdiv brdr tlleft" style="background-color:#EEEEEE;"></div>
							</div>

							<!-- ashtakoota horoscope action div starts-->
						<div id="horid" class="posabs vishid">
							<div id="hormsgid" class="brdr tlleft" style="background-color:#EEEEEE;">
							<div class="rpanelinner padtb10">
								<div class="fright tlright" style="padding-right:10px;"><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="closeViewDisp(<?=$varCurrPgNo?>)"/></div><br clear="all">
								<div id="horomatchcontentdiv-<?=$varCurrPgNo?>"></div>
							</div>
							</div>
						</div>
						<!-- horoscope action div starts-->

						<br clear="all">
							<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>

							<?
								if ($varPartialFlag =='0') {
								if($sessMatriId !='' && $sessGender!=$varMemberInfo['Gender'] && $sessMatriId !=$varMatriId && $sessPublish>=0 && $sessPublish<=2) { ?>
							<div class="fright" style="background-color:#D2EDF4;padding-top:10px;padding-left:5px;padding-right:5px;width:540px !important;width:550px;">
								<center>
										<?include('profileinboxview.php'); ?>
								</center>
							</div>

							<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all"/>
							<? } } ?>

							<div class="normtxt bld clr padt10 padl">About me</div><br clear="all"/>
							<?if($varProfileCreatedBy!='') {?>
							<div id="procre" class="tlright nfvpdiv5 padtb3 fleft">Profile created by :</div>
							<div id="par" class="nfvpdiv5a padl310 fleft"><?=$varProfileCreatedBy?></div><br clear="all"/>
							<?}?>
							<div id="probas" class="tlright nfvpdiv5 padtb3 fleft">Basic Information :</div>
							<div id="bas" class="nfvpdiv5a padl310 fleft"><?=$varBasicStr?></div><br clear="all"/>

							<div id="prophy" class="tlright nfvpdiv5 padtb3 fleft">Physical Status :</div>
							<div id="phy" class="nfvpdiv5a padl310 fleft"><?=$varPhysicalStatusStr?></div><br clear="all"/>

							<div id="probel" class="tlright nfvpdiv5 padtb3 fleft">Cultural Background :</div>
							<div id="bel" class="nfvpdiv5a padl310 fleft"><?=$varBeliefsStr?></div><br clear="all"/>

							<div id="procar" class="tlright nfvpdiv5 padtb3 fleft">Career :</div>
							<div id="car" class="nfvpdiv5a padl310 fleft"><?=$varCareerStr_EduLong?></div><br clear="all"/>

							<div id="proloc" class="tlright nfvpdiv5 padtb3 fleft">Location :</div>
							<div id="loc" class="nfvpdiv5a padl310 fleft"><?=$varLocationStr?></div><br clear="all"/>

							<div id="proabme" class="tlright nfvpdiv5 padtb3 fleft">Few lines about me :</div>
							<div id="flines" class="nfvpdiv5a padl310 fleft"><?=$varAboutmySelf?></div>
							<br clear="all"/>	<br clear="all"/>

							<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">

							<div class="normtxt bld clr padl">Lifestyle</div><br clear="all"/>
							<?if($varHabitsStr=='' && $varInterestSetStatus==0) { echo "<div class='nfvpdiv5a padl310 fleft' style='padding-left:50px'>Life style information not set</div><br clear='all'>";} else {?>
							<?if($varHabitsStr!='') { ?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Habits :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varHabitsStr?></div><br clear="all"/>
							<? } if($varInterest!='') {?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Interests :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varInterest?>...</div><br clear="all"/>
							<? } if($varHobbies!='') {?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Hobbies :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varHobbies?></div><br clear="all"/>
							<? } if($varFavouriteStr!='') {?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Favourites :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varFavouriteStr?>...</div><br clear="all"/>
							<? }}?>

							<br clear="all">
							<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">

							<div class="normtxt bld clr padl">Family</div><br clear="all"/>
							<?if($varFamilySetStatus==0) { echo "<div class='nfvpdiv5a padl310 fleft' style='padding-left:50px'>Family information not set</div>";} else {?>
							<? if($varFamilyValue!='') {?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Family value :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varFamilyValue?></div><br clear="all"/>
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
							<div class="tlright nfvpdiv5 padtb3 fleft">Family Type & Status :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varFamilyTypeAndStatus?></div><br clear="all"/>
							<? } if($varFamilyOrigin!='') {?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Ancestral Origin :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varFamilyOrigin?></div><br clear="all"/>
							<? } if($varReligiousValues!='') {?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Religious values :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varReligiousValues?></div><br clear="all"/>
							<? } if($varEthnicity!='') {?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Ethnicity :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varEthnicity?></div><br clear="all"/>
							<? } if($varParenstOccStr!='') {?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Parents Occupation :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varParenstOccStr?></div><br clear="all"/>
							<? } if($varSiblingsStr!='') {?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Siblings :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=trim($varSiblingsStr,', ')?></div><br clear="all"/>
							<? } if($varAboutFamily!='') {?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Few lines about my family :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varAboutFamily?></div><br clear="all"/>
							<? }} ?><br clear="all">
							<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">

							<div class="normtxt bld clr padl">My Partner</div>
							<?if($varPartnerSetStatus==0) { echo "<div class='nfvpdiv5a padl310 fleft' style='padding-left:50px'>Partner information not set</div>";} else {?>
							<div class="padtb5 padl">I want to marry someone who meets most of my preferences which I have noted here.</div>
							<div class="tlright nfvpdiv5 padtb3 fleft">Basic partner preference :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=trim($varPartnerBasicStr,', ')?></div><br clear="all"/>

							<?if($varPartnerBeliefs!=''){?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Cultural Background :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varPartnerBeliefs?></div><br clear="all"/>
							<?}?>

							<div class="tlright nfvpdiv5 padtb3 fleft">Career :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varPartnerCareerStr?></div><br clear="all"/>

							<div class="tlright nfvpdiv5 padtb3 fleft">Location :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varPartnerLocStr?></div><br clear="all"/>

							<?if($varPartnerHabits!='') { ?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Lifestyle :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=trim($varPartnerHabits,', ');?></div><br clear="all"/>
							<? } ?>

							<?if($varPartnerDescription!='') { ?>
							<div class="tlright nfvpdiv5 padtb3 fleft">Few lines about my partner :</div>
							<div class="nfvpdiv5a padl310 fleft"><?=$varPartnerDescription?></div><br clear="all"/>
							<? }} ?><br clear="all">

							<?if(($varMatriId == $sessMatriId) || (($varMatriId != $sessMatriId) && $sessPaidStatus==1 && ($varPhoneVerified==1 || $varPhoneVerified==3))) { ?>
							<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
							<a name="phpart"></a><div class="normtxt bld clr padb10 padl">Phone</div>
								<div id='<?=$varCurrPgNo?>vp8' class="padtb5 padl25">
								<?if($varMatriId == $sessMatriId) { ?>
									<img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="getPhoneView('<?=$varMatriId?>','<?=$varCurrPgNo?>vp8');">
								<?} else { ?>
									<div id="phmsg" class="disblk" style='padding-left:25px'>
										Are you sure you want to view this member's phone number?<br clear="all"><br clear="all">
										<div class="fright padr20">
											<input type="button" onClick="getPhoneView('<?=$varMatriId?>','<?=$varCurrPgNo?>vp8');" value="Yes" class="button">
											<input type="button" onClick="" value="No" class="button">
										</div>
									</div>
								<?}?>
							</div><br clear="all"/><br clear="all">
							<!-- <div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div> -->
							<? } ?>

				
				</div>





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
