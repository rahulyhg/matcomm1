<?php
#=====================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-01
# Project	  : MatrimonyProduct
# Filename	  : viewprofile.php
#=====================================================================================================================
# Description : display other member profile view and print profile. It includes Icon list, photo display, right icon list and profile                  description
#=====================================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/messagevars.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath."/conf/privilege.cil14");


//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessGender			= $varGetCookieInfo["GENDER"];
$sessPublish		= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus		= $varGetCookieInfo["PAIDSTATUS"];

$sessPhotoStatus	= $varGetCookieInfo['PHOTOSTATUS'];
$sessPhoneStatus	= $varGetCookieInfo['PHONEVERIFIED'];
$sessPhysicalStatus	= $varGetCookieInfo["PHYSICALSTATUS"];

/*$varAlertMsg	= '';
if($sessPhotoStatus == 0){
	$varAlertMsg = 'Add your photo';
}
if($sessPhoneStatus == 0){
	$varInnCont	 = $varAlertMsg=='' ? '' : ' & ';
	$varAlertMsg .= $varInnCont.'Verify your phone number';
}*/

//REQUEST VARIABLES
$varCurrPgNo		= $_REQUEST['cpno']?$_REQUEST['cpno']:0;

//OBJECT DECLARATION
$objProfileDetail		= new MemcacheDB;
$objProfileDetailMaster	= new MemcacheDB;
$objProfileOtherDtl		= new ProfileDetail;
$objDomain				= new domainInfo;
$objCommon				= new clsCommon;

$objProfileDetail-> dbConnect('S',$varDbInfo['DATABASE']);
$objProfileDetailMaster-> dbConnect('M',$varDbInfo['DATABASE']);

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

		//INSERT RECORD INTO memberprofileviewedinfo
		if ($sessMatriId !='' && $sessGender!=$varMemberInfo['Gender']) {
			$varViewedFields		= array('MatriId','Opposite_MatriId','Date_Viewed');
			$varViewFieldsVal		= array($objProfileDetailMaster->doEscapeString($sessMatriId,$objProfileDetailMaster),$objProfileDetailMaster->doEscapeString($varMatriId,$objProfileDetailMaster),"'".$varCurrentDate."'");
			$objProfileDetailMaster	-> insert($varTable['MEMBERPROFILEVIEWEDINFO'], $varViewedFields, $varViewFieldsVal);
		}

		#GETTING LOGIN INFORMATION FOR SELECTED PROFILE
		$argFields				= array('ml.MatriId','ml.User_Name','ml.Email','mi.Paid_Status','mi.Valid_Days','mi.Last_Payment');
		$argTables				= $varTable['MEMBERLOGININFO']." as ml,".$varTable['MEMBERINFO']." as mi";
		$argCondition			= "WHERE ml.MatriId = mi.MatriId AND ml.MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail)." AND mi.MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
		$varLoginInfoResultSet	= $objProfileDetail->select($argTables,$argFields,$argCondition,0);
		$varLoginInfo			= mysql_fetch_assoc($varLoginInfoResultSet);

		$varUserName			= $varLoginInfo['User_Name'];
		$varPaidDate			= $varLoginInfo['Last_Payment'];
		$varValidDays			= $varLoginInfo['Valid_Days'];

		#UPDATE PROFILE VIEW COUNT
		if($varMatriId != $sessMatriId) { 
			$argFields 			= array('Profile_Viewed');
			$argFieldsValues	= array("(Profile_Viewed + 1)");
			$argCondition		= "MatriId = ".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail)." AND ".$varWhereClause;
			$varUpdateId		= $objProfileDetailMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);
		}//if

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
						$argFields		= array('MatriId', 'Opposite_MatriId', 'Bookmarked', 'Ignored', 'Blocked','Interest_Received_Date', 'Interest_Sent_Date', 'Mail_Sent_Date', 'Mail_Received_Date', 'Receiver_Replied_Date', 'Receiver_Declined_Date',"IF(Interest_Received_Date>Interest_Sent_Date AND Interest_Received_Date>Mail_Received_Date AND Interest_Received_Date>Mail_Sent_Date AND Interest_Received=1 AND Interest_Received_Date>Receiver_Replied_Date AND Interest_Received_Date>Receiver_Declined_Date,Interest_Received_Status,'N') AS IntRec", "IF(Interest_Sent_Date>Interest_Received_Date AND Interest_Sent_Date>Mail_Received_Date AND Interest_Sent_Date>Mail_Sent_Date AND Interest_Sent=1 AND Interest_Sent_Date>Receiver_Replied_Date AND Interest_Sent_Date>Receiver_Declined_Date,Interest_Sent_Status,'N') AS IntSen", "IF(Mail_Sent_Date>Interest_Received_Date AND Mail_Sent_Date>Mail_Received_Date AND Mail_Sent_Date>Interest_Sent_Date AND Mail_Sent=1 AND Mail_Sent_Date>=Receiver_Replied_Date AND Mail_Sent_Date>Receiver_Declined_Date,Mail_Sent_Status,'N') AS MsgSen", "IF(Mail_Received_Date>Interest_Received_Date AND Mail_Received_Date>Mail_Sent_Date AND Mail_Received_Date>Interest_Sent_Date AND Mail_Received=1 AND Mail_Received_Date>Receiver_Replied_Date AND Mail_Received_Date>Receiver_Declined_Date,Mail_Received_Status,'N') AS MsgRec", "IF(Receiver_Replied_Date>Interest_Received_Date AND Receiver_Replied_Date>Mail_Sent_Date AND Receiver_Replied_Date>Interest_Sent_Date AND Receiver_Replied=1 AND Receiver_Replied_Date>Mail_Received_Date AND Receiver_Replied_Date>Receiver_Declined_Date,'Y','N') AS MsgRep", "IF(Receiver_Declined_Date>Interest_Received_Date AND Receiver_Declined_Date>Mail_Sent_Date AND Receiver_Declined_Date>Interest_Sent_Date AND Receiver_Declined=1 AND Receiver_Declined_Date>Mail_Received_Date AND Receiver_Declined_Date>Receiver_Replied_Date,'Y','N') AS MsgDec");
						$funIconResult	= $objProfileDetail->select($varTable['MEMBERACTIONINFO'],$argFields,$argCondition,0);

						while($row = mysql_fetch_array($funIconResult)) {
							$funBookmark	= $row['Bookmarked'];
							$funIgnored		= $row['Ignored'];
							$funBlocked		= $row['Blocked'];
							
							if ($row['IntRec'] != 'N') {
								$varContactIconStatus	= 1; //intreceived
								$varCIconImage			= ($row['IntRec']==0)?"unread":($row['IntRec']==1?"accept":"decline");
								$funCDate				= $row['Interest_Received_Date'];
								$funCMsg				= 'Interest received';
							} elseif ($row['IntSen'] != 'N') {
								$varContactIconStatus	= 1; //intsent
								$varCIconImage			= ($row['IntSen']==0)?"unread":($row['IntSen']==1?"accept":"decline");
								$funCDate				= $row['Interest_Sent_Date'];
								$funCMsg				= 'Interest sent';
							} elseif ($row['MsgRep'] == 'Y') {
								$varContactIconStatus	= 1; //msgaccept
								$varCIconImage			= 'reply';
								$funCDate				= $row['Receiver_Replied_Date'];
								$funCMsg				= 'Message replied';
							} elseif($row['MsgDec'] == 'Y') {
								$varContactIconStatus	= 1; //msgdecline
								$varCIconImage			= 'decline';
								$funCDate				= $row['Receiver_Declined_Date'];
								$funCMsg				= 'Message declined';
							} elseif ($row['MsgRec'] != 'N') {
								$varContactIconStatus	= 1; //sgrecd
								$varCIconImage			= ($row['MsgRec']==0)?"unread":"read";
								$funCDate				= $row['Mail_Received_Date'];
								$funCMsg				= 'Message received';
							} elseif ($row['MsgSen'] != 'N') {
								$varContactIconStatus	= 1; //msgsent
								$varCIconImage			=  ($row['MsgSen']==0)?"unread":($row['MsgSen']==1?"read":($row['MsgSen']==2?"reply":"decline"));
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
			$varContactIconPart = '<div style="padding-bottom: 5px;" class="vpdiv3 fleft"><font class="smalltxt"><a class="clr1" onclick="'.$varOnClick.'">Last Activity: </a></font><a onclick="'.$varOnClick.'"><img border="0" src="'.$confValues['IMGSURL'].'/'.$varCIconImage.'.gif"/></a><font class="smalltxt clr"> '.$funCMsg.': '.date('d-M-y', strtotime($funCDate)).'</font></div>';
		}
		

		//Checking Values For Profile
		if ((($sessMatriId != $varMatriId) ||$sessMatriId == "")) {
			if($varPublish == 0) {
				$varFilterMessage = "Sorry, this member's profile is currently under validation.";
			} else if($sessPhysicalStatus == 0 && $sessPhysicalStatus == $varPhysicalStatusVal ) {
				$varFilterMessage = "Sorry! You cannot view profiles of same physical status.";
			} else if($varPublish == 2) {
				$varFilterMessage = "MatriId <b>".$varMatriId."</b> is hidden and cannot be viewed by others.";
			} else if($varPublish == 3) {
				$varFilterMessage = "Sorry, this member's profile has been suspended.";
			} else if($varPublish == 4) {
				$varFilterMessage = "Sorry, this member's profile has been rejected.";
			} else if($sessGender == $varMemberInfo['Gender']) {
				$varFilterMessage = "Sorry! You cannot view profiles of your gender.";
			}
		}

		if($varFilterMessage=='') {
			
			//For getting total tab
			$varTotaltab	= 4;
			$varMissedTab	= '';
			$varPhtoTabAvail= 1;

			//check Horoscope feature available or not
			$VarHoroFeature	= $objDomain->useHoroscope();
			if($VarHoroFeature==1) {
				$varTotaltab++;
			} else {
				$varMissedTab.='4~';
				$varHoroscopeMsg='';
			}

			if($varHabitsStr!='' || $varInterestSetStatus==1) {$varTotaltab++;} else { $varMissedTab.='5~';}
			if($varFamilySetStatus==1){$varTotaltab++;} else { $varMissedTab.='6~';}
			if($varPartnerSetStatus==1){$varTotaltab++;} else { $varMissedTab.='7~';}
			$varMissedTab	= trim($varMissedTab,'~');

			if($varPhHoroCount>0) {
				//Photo Part Starts
				if($varPhotoStatus == 0 && $varPhoneHorosope['Normal_Photo1']!='') {
					$varReqImg			=($varGenderCode==1)?"img85_phundval_m.gif":"img85_phundval_f.gif";
					$varSinglePhoto		= $confValues['IMGSURL']."/".$varReqImg;
					$varOnClick			= '';
					$varPhotoMsg		= '';

					if($varMatriId != $sessMatriId) { 
					$varPhtoTabAvail	= 0;
					$varTotaltab--;	//Photo tab is not coming in view profile. So decreased one value in total tab
					$varMissedTab		='3~'.$varMissedTab; //missed tab already trimmed. So I added ~ before missed tab value
					$varMissedTab		= trim($varMissedTab,'~');
					}
				} else if($varPhotoStatus == 0 && $varPhoneHorosope['Normal_Photo1']=='') {
					$varReqImg			=($varGenderCode==1)?"img85_phnotadd_m.gif":"img85_phnotadd_f.gif";
					$varSinglePhoto		= $confValues['IMGSURL']."/".$varReqImg;
					$varPhotoMsg		= '<div class="normtxt">This member has not added photo. If you would like to view this member\'s photo, you can request member to add it.<br clear="all"><br clear="all"><div class="fright padr20"><input type="button" class="button" value="Request Now" onClick="sendRequest(\''.$varMatriId.'\',\'1\',\''.$varCurrPgNo.'vp3\');"></div></div>';
					$varOnClick		= "slidemtab('".$varCurrPgNo."','".$varCurrPgNo."vp3',".$varTotaltab.",'".$varMissedTab."');";
				} else {
					if($varMatriId == $sessMatriId) { 
						$varPhotoDetail	= $objProfileOtherDtl->photoDisplay(1,$varMatriId,$varDbInfo['DATABASE'],$varTable);
						$varOnClick		= "window.open('".$confValues['IMGURL']."/photo/viewphoto.php?ID=".$varMatriId."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
					} else if($varMatriId != $sessMatriId){ //FOR OTHER MEMBERS VIEWING MEMBERS PHOTO
						if($varPhotoStatus == 1 && $varProtectPhotoStatus==1) {
							$varReqImg		= "img85_pro.gif";
							$varSinglePhoto	= $confValues['IMGSURL']."/".$varReqImg;
							$varOnClick		= "slidemtab('".$varCurrPgNo."','".$varCurrPgNo."vp3',".$varTotaltab.",'".$varMissedTab."');";
						} else if($varPhotoStatus == 1) {
							$varPhotoDetail	= $objProfileOtherDtl->photoDisplay(2,$varMatriId,$varDbInfo['DATABASE'],$varTable);
							$varOnClick		= "window.open('".$confValues['IMGURL']."/photo/viewphoto.php?ID=".$varMatriId."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
						}
					}
				}
				//Photo Parts Ends

				if($varHoroAvailable==0 && $varPhoneHorosope['HoroscopeURL']!='') {
					$varHoroscopeMsg	= '<div class="normtxt">'.$varMatriId.' horoscope is under validation. Please revisit this member\'s profile after a few hours<br clear="all"><br clear="all"></div>';
				} else if($varHoroAvailable==0 && $varPhoneHorosope['HoroscopeURL']=='') {
					$varHoroscopeMsg	= '<div class="normtxt">This member has not added horoscope. If you would like to view this member\'s horoscope, you can request member to add it.<br clear="all"><br clear="all"><div class="fright padr20"><input type="button" class="button" value="Request Now" onClick="sendRequest(\''.$varMatriId.'\',\'5\',\''.$varCurrPgNo.'vp4\');"></div></div>';
				}
			} else {
				$varReqImg			=($varGenderCode==1)?"img85_phnotadd_m.gif":"img85_phnotadd_f.gif";
				$varSinglePhoto		= $confValues['IMGSURL']."/".$varReqImg;
				$varPhotoMsg		= '<div class="normtxt">This member has not added photo. If you would like to view this member\'s photo, you can request member to add it.<br clear="all"><br clear="all"><div class="fright padr20"><input type="button" class="button" value="Request Now" onClick="sendRequest(\''.$varMatriId.'\',\'1\',\''.$varCurrPgNo.'vp3\');"></div></div>';

				$varHoroscopeMsg	= '<div class="normtxt">This member has not added horoscope. If you would like to view this member\'s horoscope, you can request member to add it.<br clear="all"><br clear="all"><div class="fright padr20"><input type="button" class="button" value="Request Now" onClick="sendRequest(\''.$varMatriId.'\',\'5\',\''.$varCurrPgNo.'vp4\');"></div></div>';
			}

			//Photo Part Starts
			if((($varPhotoStatus == 1 && $varProtectPhotoStatus==1) && ($varMatriId != $sessMatriId)) || ($varPhotoStatus == 0 && $varPhHoroCount==0)) {
				$varOnClick		= "slidemtab('".$varCurrPgNo."','".$varCurrPgNo."vp3',".$varTotaltab.",'".$varMissedTab."');";
			}
			//Photo Parts Ends

			//Horoscope Parts Starts
			if(sizeof($varPhotoDetail)==0 && $varMatriId == $sessMatriId) {
				$varPhotoDetail	= $objProfileOtherDtl->photoDisplay(1,$varMatriId,$varDbInfo['DATABASE'],$varTable);
			} else if(($varMatriId != $sessMatriId) && ($varHoroAvailable!=0) && (sizeof($varPhotoDetail)==0)){ 
				//FOR OTHER MEMBERS VIEWING MEMBERS HOROSCOPE
				$varPhotoDetail	= $objProfileOtherDtl->photoDisplay(2,$varMatriId,$varDbInfo['DATABASE'],$varTable);
			}
			//Horoscope Parts Ends

			if(sizeof($varPhotoDetail)>0) {
				$varPhotoPath		= $confValues['PHOTOURL']."/".$varMatriId{3}."/".$varMatriId{4};
				$arrPhotoDetail		= explode('~',$varPhotoDetail);
				$arrThumbPhotoName	= explode('^',$arrPhotoDetail[0]);//Thumb small Photo
				$arrPhotoStatus		= explode('^',$arrPhotoDetail[1]);//Photo Status
				$arrNormalPhotoName	= explode('^',$arrPhotoDetail[2]);//Normal Photo
				$varHoroscopeURL	= $arrPhotoDetail[3];//Horoscope
				if($arrThumbPhotoName[0] != '') {
					$varPhotoCount		= sizeof($arrThumbPhotoName);
				}
				if($varPhotoCount>0) { 
					if($varMatriId != $sessMatriId) {
						if($varProtectPhotoStatus==1) { 
							$varReqImg		= "img85_pro.gif";
							$varSinglePhoto	= $confValues['IMGSURL']."/".$varReqImg;
						} else { 
							$varSinglePhoto	= $varPhotoPath."/".$arrThumbPhotoName[0];
							$varStrArg		= "'".$arrThumbPhotoName[0]."',".$varMatriId{3}.",".$varMatriId{4};
						}
					} else if($varMatriId == $sessMatriId) {
						if($varPhotoStatus==0) { 
							$varSinglePhoto	= $confValues['PHOTOURL']."/crop150/".$arrThumbPhotoName[0];
							$varOnClick		= "window.open('".$confValues['IMGURL']."/photo/viewphoto.php?ID=".$varMatriId."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
						} else { 
							$varSinglePhoto	= $varPhotoPath."/".$arrThumbPhotoName[0];
							$varStrArg		= "'".$arrThumbPhotoName[0]."',".$varMatriId{3}.",".$varMatriId{4};
						}
					}
				}
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


		
			<!-- get twitter id-->
     		<img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="getothertwitterid('<?=$varCurrPgNo?>','<?=$varMatriId?>','<?=$sessPaidStatus?>')">
			<!-- get twitter id-->
			<?php
			if($varGetCookieInfo['HOROSCOPESTATUS']>1 && $varHoroAvailable>1){
			?>
			<img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="javascript:showhoromatch('horomatchdiv-<?=$varCurrPgNo?>','<?=$sessMatriId?>','<?=$varMatriId?>','<?=$htype?>','msgactpart<?=$varCurrPgNo?>');">
			<?php } ?>


			<div class="viewdivouter" style="background-color:#D2EDF4;">
				<div class="viewdivouter"  style="height:180px;">
					<div style="width:30px;" class="fleft padt100" id="prev"><a href="javascript:;" onclick="slideclick('<?=$varCurrPgNo?>','prev',<?=$varTotaltab?>,'<?=$varMissedTab?>');"><img src="<?=$confValues['IMGSURL']?>/ltabarrow.gif" width="24" height="25" class="pntr" /></a></div>
					<div style="width:500px;" class="fleft">
						<div class="viewdiv1 fright tlright padt10"><a href="<?=$confValues['SERVERURL']?>/profiledetail/fullprofile.php?id=<?=$varMatriId?>" target="_blank"><img src="<?=$confValues['IMGSURL']?>/print.gif" class="pntr" /></a> &nbsp; <?if("$varCurrPgNo"!='' && $_GET['act'] != 'viewprofile'){?><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="closeViewDisp(<?=$varCurrPgNo?>)"/><?}?></div><br clear="all">
						<center>
						<div class="viewbg viewdiv1 vnormtxt clr2 padt3b10 tlleft">
							<a class="clr bld" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp1',<?=$varTotaltab?>,'<?=$varMissedTab?>');" id="<?=$varCurrPgNo?>vtab1">Basic Info</a>&nbsp;|&nbsp;
							<a class="clr1" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp2',<?=$varTotaltab?>,'<?=$varMissedTab?>');" id="<?=$varCurrPgNo?>vtab2">About Me</a> &nbsp;|&nbsp; 
							<?if($varPhtoTabAvail==1) {?><a class="clr1" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp3',<?=$varTotaltab?>,'<?=$varMissedTab?>');" id="<?=$varCurrPgNo?>vtab3">Photos</a> &nbsp;|&nbsp; <?}?>
							<?if($VarHoroFeature==1) {?><a class="clr1" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp4',<?=$varTotaltab?>,'<?=$varMissedTab?>');" id="<?=$varCurrPgNo?>vtab4">Horoscope</a> &nbsp;|&nbsp; <?}?>
							<?if($varHabitsStr!='' || $varInterestSetStatus==1) { ?><a class="clr1" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp5',<?=$varTotaltab?>,'<?=$varMissedTab?>');" id="<?=$varCurrPgNo?>vtab5">Lifestyle</a> &nbsp;|&nbsp; <?}?>
							<?if($varFamilySetStatus==1){?><a class="clr1" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp6',<?=$varTotaltab?>,'<?=$varMissedTab?>');" id="<?=$varCurrPgNo?>vtab6">Family</a> &nbsp;|&nbsp; <?}?>
							<?if($varPartnerSetStatus==1){?><a class="clr1" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp7',<?=$varTotaltab?>,'<?=$varMissedTab?>');" id="<?=$varCurrPgNo?>vtab7">My Partner</a> &nbsp;|&nbsp; <?}?>
							<a class="clr1" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp8',<?=$varTotaltab?>,'<?=$varMissedTab?>');" id="<?=$varCurrPgNo?>vtab8">Phone</a>
						</div>
						<!-- message action div starts-->
						<div id="div_box<?=$varCurrPgNo?>" class="vishid posabs" style="padding-left:30px !important;padding-left:0px;">
							<div id="msgactpart<?=$varCurrPgNo?>" class="boxdiv brdr tlleft" style="background-color:#EEEEEE;"></div>
						</div>
						<!-- message action div starts-->

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



						<div id="<?=$varCurrPgNo?>twitmain" class="disnon">
						<center>
							<div class="fleft pad5 brdr"><img src="<?=$confValues['IMGSURL']?>/twit_img.gif" /></div><div class="fleft normtxt1 clr1 tlleft bld" style="padding-top:5px;padding-left:10px;"><? echo ($checkcrawlingbotsexists == false)?$varDisplayName:''; ?><font class="clr">'s<br>Twitter Updates</font><div id="<?=$varCurrPgNo?>twitteriddiv"></div></div><br clear="all"/><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5" /><br>
							<div id="<?=$varCurrPgNo?>twitterdiv" class="fleft posabs brdr smalltxt tlleft" style="height:140px !important;height:183px; width:460px! important;width:500px; background-color:#FFFFFF; overflow:auto;padding:20px;">
							</div>
						</center>
						</div>
						<div id="<?=$varCurrPgNo?>vp1" class="padtb10 viewdiv1 disblk">
							<div id="vpdiv1" class="fleft">
								<?=$varContactIconPart?>
								<div id="infdiv1" class="smalltxt clr2 fright">Active: <?=$varLastLogin;?></div><br clear="all">

								<div id="vpdiv3" class="fleft padb10"><a class="normtxt bld clr" onMouseOver="this.className='normtxt bld clr1'" onMouseOut="this.className='normtxt bld clr'" href="<?=$confValues['SERVERURL']?>/profiledetail/<?=$varFullViewIndex?>?act=fullprofilenew&id=<?=$varMatriId?>" target="_blank"><?
								echo ($checkcrawlingbotsexists == false)? $varDisplayName.' ('.$varMatriId.')' : $varMatriId;								
								?></a>&nbsp;
								<!--<img src="<?=$confValues['SERVERURL'];?>/profiledetail/createimage.php?text=<? echo $varDisplayName.' ('.$varMatriId.')';?>"> --><br><div id="horomatchdiv-<?=$varCurrPgNo?>"></div>
								</div>



								<!--<div id="infdiv1" class="smalltxt clr2 fleft">Active: <?=$varLastLogin;?></div> --> <br clear="all">
								<!-- <div id="vpdiv4" class="normtxt clr padtb5">Profile Match: <font class="clr1">90%</font>&nbsp; &nbsp; &nbsp; &nbsp;Horoscope Match: <font class="clr1">Average</font></div> -->

								<div id="vpdiv4" class="normtxt clr"><?if($varAge != '0'){ echo $varAge.' yrs';}if($varMemberInfo['Height'] != '0.00'){ echo ', '.$varHeight;}?> <?if($varRelSubcaste!=''){ echo '<font class="clr2">|</font> '.$varRelSubcaste; }?>  <font class="clr2">|</font> <?if($varStar!=0){ echo htmlentities($varStar,ENT_QUOTES).','; }?> <?if($varResidingCity != ''){ echo htmlentities($varResidingCity,ENT_QUOTES).', ';} if($varResidingState != '0'){ echo htmlentities($varResidingState,ENT_QUOTES).', ';} if($varCountryname != ''){ echo htmlentities($varCountryname,ENT_QUOTES);}?> <font class="clr2">|</font> <?if($varEducation != ''){ echo htmlentities($varEducation,ENT_QUOTES);}?>  <?if($Occupation!=''){echo '<font class="clr2">|</font> '.htmlentities($Occupation,ENT_QUOTES);}?></div><br clear="all">

								<div style="width:355px;" class="fleft"><!--<div class="fright">							<div style="width:12px;height:32px;background:url(<?=$confValues['IMGSURL']?>/twitvplft.gif);float:left;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="12" height="32" /></div>
								 <div style="background:url(<?=$confValues['IMGSURL']?>/twitbgvp.gif) repeat-x;float:left;height:32px;padding-top:3px;padding-left:10px;" class="smalltxt">Follow me on twitter [<?=$varDisplayName?>]</div> <div style="width:22px;height:32px;background:url(<?=$confValues['IMGSURL']?>/twitvprht.gif);float:left;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="12" height="32" /></div>
								</div><div class="cleard"></div>-->
								<div class="smalltxt clr2 fleft" style="width:355px;padding-top:5px;">
									<div id="favdiv" class="<?=$varBookMarkClass?>"><a class="clr1" onClick="show_box(event,'div_box<?=$varCurrPgNo?>');lisatadd('shortlist','<?=$varMatriId?>','favdiv','<?=$varCurrPgNo?>');">Add to Favourites</a></div>
								<? if ($varPartialFlag=='0') { ?>	
									<div id="bardiv" class="<?=$varBarDivClass?>"> | </div>
									<div id="blockdiv" class="<?=$varBlockedClass?>"><a class="clr1" onClick="show_box(event,'div_box<?=$varCurrPgNo?>');lisatadd('block','<?=$varMatriId?>','blockdiv','<?=$varCurrPgNo?>');">Block Member</a></div><div class="fright" style="padding-right:4px; display:none;" id="<?=$varCurrPgNo?>twitterlinkdiv"><a class="clr1" onClick="showTwitterUp('<?=$varCurrPgNo?>','<?=$varMatriId?>');">Twitter Updates</a></div>
								<? } ?>
								</div>
								</div>
								<? if ($varPartialFlag=='0') { ?>
									<div class="fleft" style="padding-top:0px; display:none;" id="<?=$varCurrPgNo?>twitterimgdiv"><a onClick="showTwitterUp('<?=$varMatriId?>');"><img src="<?=$confValues['IMGSURL']?>/twit_img.gif" border="0" /></a></div>
								<? } ?>
							</div>
							
							<div id="vpdiv2" class="fleft">
								<div id="smphdiv1"><a onclick="<?=$varOnClick?>" id="<?=$varMatriId?>photos"><img src="<?=$varSinglePhoto?>" width="85" height="85" border="0" alt="" /></a></div>
								<!-- Online Chat starts here -->
								<? 
									if ($varPartialFlag=='0') {
								if ($varLastLogin=='NOW' && $sessMatriId != $varMatriId ) {
									if($sessPaidStatus == '1') { $varChat = "href=\"javascript:;\" onClick=\"launchIC('$sessMatriId','$varMatriId');\""; }
									else { $varChat = ' href="'.$confValues['SERVERURL'].'/payment/" target="_blank"'; } ?><div style="padding-top:3px;"><a <?=$varChat?> class="pntr"><img src="<?=$confValues['IMGSURL']?>/chat_icon.gif" /></a></div>

									<? } } ?>

								<!-- Online Chat ends here -->
							</div>
							<!-- <div id="listres<?=$varCurrPgNo?>" class="disnon posabs brdr boxdiv" style="padding-left:30px !important;padding-left:0px; z-index:1001">
							</div> -->

						</div>

						<div id="<?=$varCurrPgNo?>vp2" class="padtb10 viewdiv1 disnon">
							<?if($varProfileCreatedBy!='') {?>
							<div id="procre" class="tlright vpdiv5 padtb3 fleft">Profile created by :</div>
							<div id="par" class="vpdiv5a padl310 fleft"><?=htmlentities($varProfileCreatedBy,ENT_QUOTES)?></div><br clear="all"/>
							<?}?>

							<div id="probas" class="tlright vpdiv5 padtb3 fleft">Basic Information :</div>
							<div id="bas" class="vpdiv5a padl310 fleft"><?=htmlentities($varBasicStr,ENT_QUOTES)?></div><br clear="all"/>

							<div id="prophy" class="tlright vpdiv5 padtb3 fleft">Physical Status :</div>
							<div id="phy" class="vpdiv5a padl310 fleft"><?=htmlentities($varPhysicalStatusStr,ENT_QUOTES)?></div><br clear="all"/>

							<div id="probel" class="tlright vpdiv5 padtb3 fleft">Cultural Background :</div>
							<div id="bel" class="vpdiv5a padl310 fleft"><?=htmlentities($varBeliefsStr,ENT_QUOTES)?></div><br clear="all"/>

							<div id="procar" class="tlright vpdiv5 padtb3 fleft">Career :</div>
							<div id="car" class="vpdiv5a padl310 fleft"><?=htmlentities($varCareerStr_EduLong,ENT_QUOTES)?></div> 

							<div id="proloc" class="tlright vpdiv5 padtb3 fleft">Location :</div>
							<div id="loc" class="vpdiv5a padl310 fleft"><?=htmlentities($varLocationStr,ENT_QUOTES)?></div>

							<div id="proabme" class="tlright vpdiv5 padtb3 fleft">Few lines about me :</div>
							<div id="flines" class="vpdiv5a padl310 fleft"><?=htmlentities($varAboutmySelf,ENT_QUOTES)?></div>
						</div>

						<div id="<?=$varCurrPgNo?>vp3" class="padtb10 viewdiv1 disnon">
							<? if($varPhotoStatus == 0 && $varMatriId != $sessMatriId) { 
								echo $varPhotoMsg;  
							} else if($varPhotoStatus == 1 && $varProtectPhotoStatus==1 && $varMatriId != $sessMatriId) {
									$varReqImg		= "img50_pro.gif";
									$varStrArg		= $confValues['IMGSURL']."/".$varReqImg; ?>
								<div class="vpphdiv padtb3 fleft">
									<div class="photodiv1 fleft"><a><img src="<?=$varStrArg?>" width="50" height="50"/></a></div>
								</div><br clear="all">
								<div class="normtxt">
									To view the photo of this member, you require a password. Please enter the password below. If you do not have the password, please send an e-mail request to the member <br>and get the password.<br clear="all"><br clear="all">
									Enter photo password: <input type="password" class="inputtext" id="password" name="password">&nbsp;&nbsp;&nbsp;<input type="button" class="button" name="" onClick="getPhotoView('<?=$varMatriId?>');" value="Submit"><br clear="all">
									<span id="protecterror" class="errortxt"></span>
								</div>
								<div id="photodiv">
								</div>
							<? } else if($varPhotoCount>0) {?>
								<div class="vpphdiv padtb3 fleft">
									<?$varFMPhotoCnt	= $confValues['FMPHOTOCNT']-1;
									for($i=0;$i<$varPhotoCount;$i++) {
										if($varMatriId == $sessMatriId) {
											if($arrPhotoStatus[$i] == 1) {
												$varPhotoStr	= $varPhotoPath."/".$arrNormalPhotoName[$i];
												$varStrArg		= "'".$arrThumbPhotoName[$i]."',".$varMatriId{3}.",".$varMatriId{4}.",".$varCurrPgNo;

												echo '<div class="photodiv1 fleft"><a><img src="'.$varPhotoStr.'" width="50" height="50" onClick="displayBigPhoto('.$varStrArg.');"/></a></div>';
											} else {
												$varPhotoStr	= $confValues['PHOTOURL']."/crop75/".$arrNormalPhotoName[$i];
												$varStrArg		= "'crop150/".$arrThumbPhotoName[$i]."',".$varCurrPgNo;
												echo '<div class="photodiv1 fleft"><a><img src="'.$varPhotoStr.'" width="50" height="50" onClick="displayBigCropPhoto('.$varStrArg.');"/></a><div>under validation</div></div>';
											}

										} else if($varMatriId != $sessMatriId) {
											//For Opposite MatriId
											$varPhotoStr	= $varPhotoPath."/".$arrNormalPhotoName[$i];
											$varStrArg		= "'".$arrThumbPhotoName[$i]."',".$varMatriId{3}.",".$varMatriId{4}.",".$varCurrPgNo;
											
											echo '<div class="photodiv1 fleft"><a><img src="'.$varPhotoStr.'" width="50" height="50" onClick="displayBigPhoto('.$varStrArg.');"/></a></div>';
										}
										if($i==4) {
											echo '<br clear="all"/>';
										}
									}?>
								</div>
								<div class="vpphdiv1 padtb3 fleft">
									<div id="bigviewphoto<?=$varCurrPgNo?>">
										<?
											if($varPhotoStatus==0) {
												$varFirstPhotoStr	= $confValues['PHOTOURL']."/crop150/".$arrThumbPhotoName[0];
											} else {
												$varFirstPhotoStr	= $varPhotoPath."/".$arrThumbPhotoName[0];
											}
										?>
										<img src="<?=$varFirstPhotoStr?>" width="150" height="150" />
									</div>
								</div>
							<? } ?>
						</div>

						<div id="<?=$varCurrPgNo?>vp4" class="padtb10 viewdiv1 disnon">
							<?if($varHoroAvailable == 0 && $varMatriId != $sessMatriId) { 
								echo $varHoroscopeMsg;
							} else if(($varHoroAvailable == 1 || $varHoroAvailable==3) && $varHoroProtected==1 && $varMatriId != $sessMatriId) {
									$varReqImg		= "img50_pro.gif";
									$varStrArg		= $confValues['IMGSURL']."/".$varReqImg; ?>
								<div class="vpphdiv padtb3 fleft">
									<div class="photodiv1 fleft"><a><img src="<?=$varStrArg?>" width="50" height="50"/></a></div>
								</div><br clear="all">
								<div class="normtxt">
									To view the horoscope of this member, you require a password. Please enter the password below. If you do not have the password, please send an e-mail request to the member <br>and get the password.<br clear="all"><br clear="all">
									Enter horoscope password: <input type="password" class="inputtext" id="horopass" name="horopass">&nbsp;&nbsp;&nbsp;<input type="button" class="button" name="" onClick="getHoroscopeView('<?=$varMatriId?>');" value="Submit"><br clear="all">
									<span id="horoprotecterror" class="errortxt"></span>
								</div>
								<div id="horodiv">
								</div>
							<? } else if($varHoroscopeURL!='') { 
									$varHoroOnClick = $confValues['IMAGEURL'].'/horoscope/viewhoroscope.php?ID='.$varMatriId;
									$varViewButton		= '<input type="button" class="button" name="" value="View Horoscope" onClick="window.open(\''.$varHoroOnClick.'\',\'\',\'directories=no,width=650,height=650,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');">';
									$varHoroTimeOfBirth	= $varHoroBirthTimeStr.', Standard Time';
									$varHoroTimeZone	= '(Hrs. Mins):'.$varTimeZone;
									
									if($varUploadMsg!=''){
										echo '<div class="normtxt">'.$varUploadMsg.'</div><br clear="all"><br clear="all">';
									} else if($varHoroAvailable==1) {
										echo '<div class="normtxt">This member has uploaded a scanned horoscope.</div><br clear="all"><br clear="all">';
									} else if($varHoroAvailable==3) { ?>
									<div class="tlright vpdiv5 padtb3 fleft">Name :</div>
									<div class="vpdiv5a padl310 fleft"><?=$varName?></div><br clear="all"/>

									<div class="tlright vpdiv5 padtb3 fleft">Date of Birth :</div>
									<div class="vpdiv5a padl310 fleft"><?=$varHoroBirthDateStr?></div><br clear="all"/>

									<div class="tlright vpdiv5 padtb3 fleft">Time of Birth :</div>
									<div class="vpdiv5a padl310 fleft"><?=$varHoroTimeOfBirth?></div><br clear="all"/>

									<div class="tlright vpdiv5 padtb3 fleft">Time Zone :</div>
									<div class="vpdiv5a padl310 fleft"><?=$varHoroTimeZone?> </div> 
										
									<div class="tlright vpdiv5 padtb3 fleft">Time Correction :</div>
									<div class="vpdiv5a padl310 fleft">Standard Time</div>

									<div class="tlright vpdiv5 padtb3 fleft">Place of Birth :</div>
									<div class="vpdiv5a padl310 fleft"><?=$varCityName?></div>
								<? } ?>
								<div class="fright padr20">
									<?=$varViewButton?>
								</div><br clear="all"/>
							<? } ?>
						</div>

						<div id="<?=$varCurrPgNo?>vp5" class="padtb10 viewdiv1 disnon">
							<?if($varHabitsStr!='') { ?>
							<div class="tlright vpdiv5 padtb3 fleft">Habits :</div>
							<div class="vpdiv5a padl310 fleft"><?=htmlentities($varHabitsStr,ENT_QUOTES)?></div><br clear="all"/>
							<? } if($varInterest!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Interests :</div>
							<div class="vpdiv5a padl310 fleft"><?=htmlentities($varInterest,ENT_QUOTES)?>...</div><br clear="all"/>
							<? } if($varHobbies!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Hobbies :</div>
							<div class="vpdiv5a padl310 fleft"><?=htmlentities($varHobbies,ENT_QUOTES)?></div><br clear="all"/>
							<? } if($varFavouriteStr!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Favourites :</div>
							<div class="vpdiv5a padl310 fleft"><?=htmlentities($varFavouriteStr,ENT_QUOTES)?>...</div> 
							<? }?>
						</div>

						<div id="<?=$varCurrPgNo?>vp6" class="padtb10 viewdiv1 disnon">
							<? if($varFamilyValue!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Family value :</div>
							<div class="vpdiv5a padl310 fleft"><?=htmlentities($varFamilyValue,ENT_QUOTES)?></div><br clear="all"/>
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
							<div class="tlright vpdiv5 padtb3 fleft">Family type & status :</div>
							<div class="vpdiv5a padl310 fleft"><?=htmlentities($varFamilyTypeAndStatus,ENT_QUOTES)?></div><br clear="all"/>
							<? } if($varFamilyOrigin!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Ancestral Origin :</div>
							<div class="vpdiv5a padl310 fleft"><?=htmlentities($varFamilyOrigin,ENT_QUOTES)?></div><br clear="all"/>
							<? } if($varReligiousValues!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Religious values :</div>
							<div class="vpdiv5a padl310 fleft"><?=htmlentities($varReligiousValues,ENT_QUOTES)?></div><br clear="all"/>
							<? } if($varEthnicity!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Ethnicity :</div>
							<div class="vpdiv5a padl310 fleft"><?=htmlentities($varEthnicity,ENT_QUOTES)?></div><br clear="all"/>
							<? } if($varParenstOccStr!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Parents Occupation :</div>
							<div class="vpdiv5a padl310 fleft"><?=htmlentities($varParenstOccStr,ENT_QUOTES)?></div><br clear="all"/>
							<? } if($varSiblingsStr!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Siblings :</div>
							<div class="vpdiv5a padl310 fleft"><?=htmlentities(trim($varSiblingsStr,', '),ENT_QUOTES)?></div> 
							<? } if($varAboutFamily!='') {?>	
							<div class="tlright vpdiv5 padtb3 fleft">Few lines about my family :</div>
							<div class="vpdiv5a padl310 fleft"><?=htmlentities($varAboutFamily,ENT_QUOTES)?></div>
							<? } ?>
						</div>

						<div id="<?=$varCurrPgNo?>vp7" class="padtb10 viewdiv1 disnon">
							<div class="padtb3">I want to marry someone who meets most of my preferences which I have noted here.</div>
							<div class="tlright vpdiv6 padtb3 fleft">Basic Information :</div>
							<div class="vpdiv6a padl310 fleft"><?=htmlentities(trim($varPartnerBasicStr,', '),ENT_QUOTES)?></div><br clear="all"/>

							<?if($varPartnerBeliefs!=''){?>
							<div class="tlright vpdiv6 padtb3 fleft">Cultural Background :</div>
							<div class="vpdiv6a padl310 fleft"><?=htmlentities($varPartnerBeliefs,ENT_QUOTES)?></div><br clear="all"/>
							<?}?>
							
							<div class="tlright vpdiv6 padtb3 fleft">Career :</div>
							<div class="vpdiv6a padl310 fleft"><?=htmlentities($varPartnerEducation,ENT_QUOTES)?></div><br clear="all"/>

							<div class="tlright vpdiv6 padtb3 fleft">Location :</div>
							<div class="vpdiv6a padl310 fleft"><?=htmlentities($varPartnerLocStr,ENT_QUOTES)?></div> 
							
							<?if($varPartnerHabits!='') { ?>
							<div class="tlright vpdiv6 padtb3 fleft">Lifestyle :</div>
							<div class="vpdiv6a padl310 fleft"><?=htmlentities(trim($varPartnerHabits,', '),ENT_QUOTES)?></div>
							<? } ?>

							<?if($varPartnerDescription!='') { ?>
							<div class="tlright vpdiv6 padtb3 fleft">Few lines about my partner :</div>
							<div class="vpdiv6a padl310 fleft"><?=htmlentities($varPartnerDescription,ENT_QUOTES)?></div>
							<? } ?>
						</div>

						<div id="<?=$varCurrPgNo?>vp8" class="padtb10 viewdiv1 disnon">
							<?if($varMatriId == $sessMatriId) { ?>
							<img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="getPhoneView('<?=$varMatriId?>','<?=$varCurrPgNo?>vp8');">
							<? } else {
									if($varPhoneVerified==1 || $varPhoneVerified==3) {
										if($sessPaidStatus==1) { ?>
											<div id="phmsg" class="disblk">
												Are you sure you want to view this member's phone number?<br clear="all"><br clear="all">
												<div class="fright padr20">
													<input type="button" onClick="getPhoneView('<?=$varMatriId?>','<?=$varCurrPgNo?>vp8');" value="Yes" class="button">
													<input type="button" onClick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp1',<?=$varTotaltab?>,'<?=$varMissedTab?>');" value="No" class="button">
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
								} ?>
						</div><br clear="all">
						<? if ($varPartialFlag =='0') { if($sessMatriId !='' && $sessGender!=$varMemberInfo['Gender'] && $sessMatriId !=$varMatriId && $sessPublish>=0 && $sessPublish<=2) { ?>
							<br clear="all"><div class="dotsep1"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="2"></div>
							<? include_once('profileinboxview.php'); } } ?>
						</center>
					</div>
					<div style="width:30px;" class="fleft padt100 tlright" id="nxt"><a href="javascript:;" onclick="slideclick('<?=$varCurrPgNo?>','nxt',<?=$varTotaltab?>,'<?=$varMissedTab?>');" ><img src="<?=$confValues['IMGSURL']?>/rtabarrow.gif" width="24" height="25" class="pntr" /></a></div>
				</div>
			<div><br clear="all">
			<center>
			<div class="linesep viewdiv1"><img src="images/trans.gif" height="1" width="1" /></div></center>
		</div>
	</div>
		<?}
	} else {
		$varFilterMessage = "Sorry, this member's profile does not exist.";
	}
} else {
	$varStyle = "style='display:none'";
	$varFilterMessage = "Register free to view full profile details and to contact this member.<br clear='all'/><a class='clr1' href='".$confValues['SERVERURL']."/register/'>Click here to Register</a> or <a class='clr1' href='".$confValues['SERVERURL']."/login/'>Login NOW.</a>";
}

//CLOSE DB
$objProfileDetail->dbClose();
$objProfileDetailMaster->dbClose();

//UNSET OBJECTS
unset($objProfileDetail);
unset($objProfileDetailMaster);

if($varFilterMessage!='') {?>
		<div class="rpanel brdr pad10">
			<div class="fright tlright" <?=$varStyle?>><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="closeViewDisp(<?=$varCurrPgNo?>)"/></div><br clear="all">
			<?=$varFilterMessage?>
		</div>
<?}?>

