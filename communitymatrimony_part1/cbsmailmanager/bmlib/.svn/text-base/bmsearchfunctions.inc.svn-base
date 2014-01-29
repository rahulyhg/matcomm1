<?php
/****************************************************************************************************
File		: bmsearchfunctions.inc
Author		: Andal.V
Date		: 12-Dec-2007
*****************************************************************************************************
Description	: 
	 common functions related to search module
************************************************************************************************** */

function selectPartnerPrefHeight($arryhashname, $in='') {
	global $$arryhashname, $HEIGHTVALPARTNER;
	foreach ($$arryhashname as $key => $value) {
		if ($in == $key){
			$selected = 'Selected';
		} else {
			$selected = '';
		}
		echo "<option value=\"".$HEIGHTVALPARTNER[$key]."\" ".$selected.">".$value."</option>";
	}
}

function selectRevPartnerPrefHeight($arryhashname, $in='') {
	global $$arryhashname, $HEIGHTVALPARTNER;

	foreach ($HEIGHTVALPARTNER as $key => $value) {
		if ($value == $in) {
			$needkey = $key;
			break;
		}
	}
	foreach ($$arryhashname as $key1 => $value1) {
		if ($needkey == $key1) {
			$selected = 'Selected';
		} else {
			$selected = '';
		}
		echo "<option value=\"".$HEIGHTVALPARTNER[$key1]."\" ".$selected.">".$value1."</option>";
	}
}

// Fetching datas from inc arrays for occupations and puts into select options...
function selectOccArrayHash($arryhashname, $in='') {
	global $$arryhashname,$job11,$job21,$job31,$jobdividerhash;

	if ($arryhashname == 'job2') {
			$arryhashname = 'job21';
			foreach ($$arryhashname as $key => $value) {
				if ($in == $key) {
					$selected = 'Selected';
				} else {
					$selected = '';
				}
				echo "<option value=\"".$key."\" ".$selected.">".$value."</option>";
			}
	} 
	else {
			foreach ($$arryhashname as $key => $occvalue) {
				echo "<option value=\"\" >".$jobdividerhash[$key]."</option>";
				foreach ($occvalue as $key1 => $occvalue1) {
					if ($in == $occvalue1) {
						$selected = 'Selected';
					} else {
						$selected = '';
					}
					echo "<option value=\"".$occvalue1."\" ".$selected.">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".${$arryhashname.'1'}[$occvalue1]."</option>";
				}
			}
	}
}

function selectOccArrayHashAdd($arryhashname, $in='') {
	global $$arryhashname,$job11,$job21,$job31,$jobdividerhash;

	if ($arryhashname == 'job2') {
			$arryhashname = 'job21';
			foreach ($$arryhashname as $key => $value) {
				if ($in == $key) {
					$selected = 'Selected';
				} else {
					$selected = '';
				}
				echo "<option value=\"".$key."\" >".$value."</option>";
			}
	} else {
			foreach ($$arryhashname as $key => $occvalue) {
				echo "<option value=\"\" >".$jobdividerhash[$key]."</option>";
				foreach ($occvalue as $key1 => $occvalue1) {
					if ($in == $occvalue1) {
						$selected = 'Selected';
					} else {
						$selected = '';
					}
					echo "<option value=\"".$occvalue1."\" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".${$arryhashname.'1'}[$occvalue1]."</option>";
				}
			}
	}
}

function getFromPartPrefArryHash ($arryhashname, $in='') {
	global $$arryhashname, $l_any;
	$errflag = 0;
	$get_params = split ('[~,]', $in);
	foreach ($get_params as $key => $value) {
		if (array_key_exists($value,$$arryhashname)) {
			$retarray .=  ${$arryhashname}[$value].", ";
		} else {
			$errflag = 1;
		}
	}
	$retarray = substr ($retarray, 0, strlen($retarray)-2);
	if ($errflag == 1 || $in == '' || $in == 0 || $in == NULL) {
		$retarray = $l_any;
	}
	return $retarray;
}

function getFromHobbiesArryHash ($arryhashname, $in='', $others='') {
	global $$arryhashname;
	$errflag = 0;
	if (trim($in)!='') {
		$get_params = explode ("~", $in);
		foreach ($get_params as $key => $value) {
			if (array_key_exists($value,$$arryhashname)) {
				$retarray .=  ${$arryhashname}[$value].", ";
			} else {
				$errflag = 1;
			}
		}
	}
	if ($others != '') {
		$retarray .=  $others.", ";
	}
	$retarray = substr ($retarray, 0, strlen($retarray)-2);
	if ($errflag == 1) {
		$retarray = '-';
	}
	return $retarray;
}

//function for height and cm convertion
function calFloatHeight ($ft,$inch) {
	$heightincms = ($ft*30.48) + ($inch*2.54);
	return $heightincms; // return as float value as cms...
}

function calRevFloatHeight ($incms) {
	$qout = ($incms/30.48);
	list($ft,$decimal) = explode(".",$qout);
	$dec = ".".$decimal;
	$inchs = round(($dec*30.48)/2.54);
	$retheight['ft'] = $ft;
	$retheight['inchs'] = $inchs;
	return $retheight; // return in ft and inch...
}

//functions for getting array with delimeters
function getArrayFldVal ($fldval='') {
	if (is_array($_POST[$fldval])) {
		foreach($_POST[$fldval] as $key => $val) {
			$varname .= $val.'~';
		}
		$varname = substr ($varname, 0, strlen($varname)-1);
	} elseif (trim($_POST[$fldval]) != '') {
		$varname = $_POST[$fldval];
	}
	return $varname;
}

function calRevFloatWeight ($inkgs) {
	$retweight = ($inkgs / 2.2046);
	return round($retweight);  // return in kgs...
}

function getPhoto ($imgname,$id) {
	global $GLOBALS, $COMMONVARS;
	if ($imgname != '') {
		$bid = $id;
		$url = "";
		if (strtoupper(substr($bid,0,3)) == 'BMC') {
			$img_url = 'http://'.$img_domain_url.'/bmcphotos/';
			$folder1 = substr($bid,3,1);
			$folder2 = substr($bid,4,1);
			$url = $img_url.$folder1."/".$folder2."/".$imgname;

		} else {
			$domaincaps = substr($bid,0,1);

			$img_url = 'http://'.$COMMONVARS['AKKAMI_SERVER_PREFFIX'].".".$GLOBALS['DOMAINNAME'][array_search($domaincaps, $GLOBALS['IDSTARTLETTERHASH'])].'matrimony.com/photos/';
			$folder1 = substr($bid,1,1);
			$folder2 = substr($bid,2,1);
			$url = $img_url.$folder1."/".$folder2."/".$imgname;
		}
	}
	return $url;
}

function checkOnlineStatus ($matriid='',$dbObj='') {
	global $DOMAINTABLE, $DBNAME, $DBINFO, $MERGETABLE,$TABLE;
	if ($matriid != '') {
		$sql = "select MatriId from ".$DBNAME['MESSENGER'].".".$TABLE['ICSTATUS'] ." where MatriId = '".$matriid."' and Status = 1";
		$count=$dbObj->select($sql);
		if (trim($count) > 0) {
			return 'Online';
		} else {
			return 'Offline';
		}
	}
}

// Matrimonyprofile table //
function getMatrimonyProfileOfUser ($id='',$dbObj='',$tablename='') {
	global $DOMAINTABLE, $DBNAME, $DBINFO;
	
	if($tablename=="") {
		return " please send table name :) ";
	}

	$DMARRAY = getDomainInfo(1,$id);
	$dmname = strtoupper($DMARRAY['domainnameshort']);

	$sql = "select Language,MatriId,Status,Authorized,Validated,EntryType,SpecialPriv,PowerPackOpted,PowerPackStatus,Name,Age,DayOfBirth,MonOfBirth,YearOfBirth,Gender,MaritalStatus,LookingStatus,NoOfChildren,ChildrenLivingStatus,DivorceDetails,InCms,Height,BodyType,Complexion,BloodGroup,InLbs,Weight,SpecialCase,MotherTongue,Religion,Caste,SubCaste,CasteNoBar,Gothra,Star,Raasi,Dosham,EatingHabits,SmokingHabits,DrinkingHabits,EducationSelected,Education,OccupationCategory,OccupationSelected,Occupation,IncomeCurrency,AnnualIncome,Citizenship,CountrySelected,ResidentStatus,ResidingState,ResidingArea,ResidingDistrict,ResidingCity,Tel,ProfileVerified,PhoneVerified,ProfileDescription,FamilyDetailsAvailable,HobbiesAvailable,FiltersAvailable,PrivacySetting,MobileAlertsAvailable,PhotoAvailable,PhotoProtected,HoroscopeAvailable,HoroscopeProtected,BirthDetailsAvailable,HoroscopeMatch,VideoAvailable,VideoProtected,VoiceAvailable,ReferenceAvailable,PartnerPrefSet,MatchWatchEmail,LastLogin,TimeModified,TimePosted,NumberOfPayments,LastPayment,ValidDays,USPaidValidated,ReceiveEmail,TimeCreated,ByWhom,ReferredBy,IpAddress,Comments,WebNotification,WebNotifyDisableView,PromotionNotification,DateUpdated from ".$tablename." where MatriId = '".$id."'";
	
	$dbObj->select($sql);
	$row = $dbObj->fetchArray("MYSQL_ASSOC");
	if(trim($row['LastLogin'])!="") {
	$lst=split('[- :]',$row['LastLogin']);
	$row['LastLogin']=date ("d-M-Y H:i", mktime ($lst[3],$lst[4],0,$lst[1],$lst[2],$lst[0]));	 	
	}
	return $row;
}

// contactinfo table //
function getContactInfoOfUser ($id='',$dbObj='') {
	global $DOMAINTABLE, $DBNAME, $DBINFO, $MERGETABLE;

	$DMARRAY=getDomainInfo(1,$id);
	$dmname=strtoupper($DMARRAY['domainnameshort']); 

	$sql = "SELECT MatriId,ContactAddress,CountryCode,AreaCode,PhoneNo,MobileNo from ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[$dmname]['CONTACTINFO']." Where Matriid = '".$id."'";
	$dbObj->select($sql);
	
	return $dbObj->fetchArray("MYSQL_ASSOC");
}

// Familyinfo table //
function getFamilyInfoOfUser ($id='',$dbObj='',$tablename='') {
	global $DOMAINTABLE, $DBNAME, $DBINFO, $MERGETABLE;

	if($tablename=="") {
		return "please send table name :) ";	
	}

	//  check whether merge or individual table
	$sql = "select MatriId,FamilyValue,FamilyType,FamilyStatus,FatherOccupation,MotherOccupation,AncestralOrigin,Brothers,Sisters ,BrothersMarried,SistersMarried,Familydescription,DateUpdated from ".$tablename." where MatriId = '$id'";
	
	$dbObj->select($sql);
	return $dbObj->fetchArray("MYSQL_ASSOC");
}

// Hoobbiesinfo table //
function getHobbiesInfoOfUser ($id='',$dbObj='',$tablename='') {
	global $DOMAINTABLE, $DBNAME, $DBINFO, $MERGETABLE;
	
	if($tablename=="") {
		return "please send table name :) ";	
	}
	//  check whether merge or individual table
	$sql = "select MatriId,HobbiesSelected,HobbiesOthers,InterestsSelected,InterestsOthers,MusicSelected,MusicOthers,BooksSelected,BooksOthers,MoviesSelected,MoviesOthers,SportsSelected,SportsOthers,FoodSelected,FoodOthers,DressStyleSelected,DressStyleOthers,LanguagesSelected,LanguagesOthers, DateUpdated from ".$tablename." where MatriId = '$id'";
	$dbObj->select($sql);

	return $dbObj->fetchArray("MYSQL_ASSOC");
}

// horodetails table //
function getHoroDetailsOfUser ($id='',$dbObj='') {
	global $DOMAINTABLE, $DBNAME, $DBINFO, $MERGETABLE,$TABLE;
	
	$DMARRAY=getDomainInfo(1,$id);
	$dmname=strtoupper($DMARRAY['domainnameshort']); 

	$sql = "SELECT BirthDay,BirthMonth,BirthYear,BirthHour,BirthMinute,BirthSeconds,BirthMeridian,MatriID,BirthCity ,BirthState,BirthLongitude,BirthLatitude,Language,RequestDateTime,Charttype,BirthCountry,TimeCorrection,ChartStyle from ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[$dmname]['HORODETAILS']." Where Matriid = '".$id."'";
	$dbObj->select($sql);

	return $dbObj->fetchArray("MYSQL_ASSOC");
}

// paymentdetails table //
function getPaymentDetailsOfUser ($id='',$dbObj='') {
	global $DOMAINTABLE, $DBNAME, $DBINFO, $MERGETABLE,$TABLE;
	
	$sql = "select * from ".$TABLE['PAYMENTDETAILS']." where MatriId = '".$id."'";
	
	$dbObj->select($sql);
	return $dbObj->fetchArray("MYSQL_ASSOC");
}

// Logininfo table //
function getLoginInfoOfUser ($id='',$dbObj='') { //  check whether merge or individual table
	global $DOMAINTABLE, $DBNAME, $DBINFO, $MERGETABLE,$TABLE;
	
	$sql = "select MatriId,Password,EmailStatus,Email,DateUpdated from ".$DBNAME['MATRIMONYMS'].".".$MERGETABLE['LOGININFO']." where MatriId = '".$id."'";
	
	$dbObj->select($sql);
	return $dbObj->fetchArray("MYSQL_ASSOC");	
}

// photoinfo table //
function getPhotoInfoOfUser ($id='',$dbObj='',$tablename='') {
	global $DOMAINTABLE, $DBNAME, $DBINFO, $MERGETABLE;  //  check whether merge or individual table
	if($tablename=="") {
		return "please send table name :) ";	
	}
	$sql = "select MatriId,PhotoProtected,HoroscopeProtected,VideoProtected,VoiceProtected,Photo_ProtectedPassword,Horoscope_ProtectedPassword,Video_ProtectedPassword,Voice_ProtectedPassword,PhotoURL1,PhotoDescription1,PhotoStatus1,ThumbImg1,ThumbImgs1,PhotoURL2,PhotoDescription2,PhotoStatus2,ThumbImg2,ThumbImgs2,PhotoURL3,PhotoDescription3,PhotoStatus3,ThumbImg3,ThumbImgs3,PhotoLastUpdatedOn,HoroscopeURL,HoroscopeDescription,HoroscopeStatus,VideoURL,VideoDescription,VoiceURL,VoiceDescription,DateUpdated from ".$tablename." where MatriId = '".$id."'";

	$dbObj->select($sql);
	return $dbObj->fetchArray("MYSQL_ASSOC");
}

// Matchwatch table //
function getMatchWatchOfUser ($id='',$dbObj='',$tablename='') {
	global $DOMAINTABLE, $DBNAME, $DBINFO, $MERGETABLE;  //  check whether merge or individual table
	if($tablename=="") {
		return "please send table name :) ";	
	}
	$sql = "select MatriId,EmailType,MatchLanguage,MatchMaritalStatus,HavingChildren,StAge,EndAge,StHeight,EndHeight,PhysicalStatus,MotherTongue,MatchReligion,MatchCaste,MatchSubCaste,Manglik,EatingHabitsPref,MatchEducation,MatchCitizenship,MatchCountry,MatchIndianStates,MatchUSStates,MatchResidentStatus,PartnerDescription,DateUpdated from ".$tablename." where MatriId = '".$id."'";

	$dbObj->select($sql);
	return $dbObj->fetchArray("MYSQL_ASSOC");	
}

// verifiedphonedet_mast table //
function getVerifiedPhoneDetMastOfUser ($id='',$dbObj='') {
	global $DOMAINTABLE, $DBNAME, $DBINFO, $MERGETABLE;  //  check whether merge or individual table

	$sql = "select PinNo,MatriId,TimeGenerated,PhoneNo1,PhoneStatus1,ContactPerson1,Relationship1,Timetocall1,DateConfirmed,VerifiedFlag,Description,VerificationSource ".$DBNAME['ASSUREDCONTACT']." where MatriId = '".$id."'";
	
	$dbObj->select($sql);
	return $dbObj->fetchArray("MYSQL_ASSOC");	
}

// ignored table //
function getIgnoredOfUser ($id='',$dbObj='') {
	global $DOMAINTABLE, $DBNAME,$TABLE,$DBINFO,$MERGETABLE;
	
	$DMARRAY=getDomainInfo(1,$id);
	$dmname=strtoupper($DMARRAY['domainnameshort']); 
	$sql = "SELECT MatriId,IgnoredId,TimeIgnored,Comments from ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[$dmname]['IGNORED']." Where MatriId = '".$id."'";

	$dbObj->select($sql);
	return $dbObj->fetchArray("MYSQL_ASSOC");
}

// ignored table //
function getMailSubscribeOfUser ($email='',$dbObj='') {
	global $DOMAINTABLE,$DBNAME,$TABLE,$MERGETABLE;

	$sql = "select * from ".$TABLE['MAILSUBSCRIBE']." where Email = '".$email."'";
	$dbObj->select($sql);
	return $dbObj->fetchArray("MYSQL_ASSOC");
}


// BMC Tables //

// bmc Matrimonyprofile table //
function getBmcMatrimonyProfileOfUser ($id='',$dbObj) {
	global $matrimonyprofile;
	$sql = "select *, Date_format(LastLogin,'%d-%m-%Y') as LastLogin from bmcmatrimonyprofile where MatriId = '".$id."'";	
	if ($dbObj->select($sql) > 0) {
		$row = $dbObj->fetchArray();
		return $row;
	} else {
		return '';
	}
}

// bmc contactinfo table //
function getBmcContactInfoOfUser ($id='',$dbObj) {
	global $matrimonyprofile;
	$sql = "select * from bmccontactinfo where MatriId = '".$id."'";
	if ($dbObj->select($sql) > 0) {
		$row = $dbObj->fetchArray();
		return $row;
	} else {
		return '';
	}
}

// bmc Familyinfo table //
function getBmcFamilyInfoOfUser ($id='',$dbObj) {
	global $matrimonyprofile;

	$sql = "select * from bmcfamilyinfo where MatriId = '".$id."'";
	if ($dbObj->select($sql) > 0) {
		$row = $dbObj->fetchArray();
		return $row;
	} else {
		return '';
	}
}

// bmc Logininfo table //
function getBmcLoginInfoOfUser ($id='',$dbObj)  {
	$sql = "select * from bmclogininfo where MatriId = '".$id."'";
	if ($dbObj->select($sql) > 0) {
		$row = $dbObj->fetchArray();
		return $row;
	} else {
		return '';
	}
}

// bmc photoinfo table //
function getBmcPhotoInfoOfUser ($id='',$dbObj) {

	$sql = "select * from bmcphotoinfo where MatriId = '".$id."'";
	if ($dbObj->select($sql) > 0) {
		$row = $dbObj->fetchArray();
		return $row;
	} else {
		return '';
	}
}

// bmc Matchwatch table //
function getBmcMatchWatchOfUser ($id='',$dbObj) {
	$sql = "select * from bmcmatchwatch where MatriId = '".$id."'";
	if ($dbObj->select($sql) > 0) {
		$row = $dbObj->fetchArray();
		return $row;
	} else {
		return '';
	}
}

// bmc verifiedphonedet_mast table //
function getBmcVerifiedPhoneDetMastOfUser ($id='',$dbObj) {
	$sql = "select * from bmcverifiedphonedet_mast where MatriId = '".$id."'";
	if ($dbObj->select($sql) > 0) {
		$row = $dbObj->fetchArray();
		return $row;
	} else {
		return '';
	}
}

// bmc_contactrequestlist table //
function getBmcContactRequestListOfUser ($id='',$dbObj) {
	$sql = "select * from bmmatrimony.bmccontactrequestlist where MatriId = '".$id."'";
	if ($dbObj->select($sql) > 0) {
		$row = $dbObj->fetchArray();
		return $row;
	} else {
		return '';
	}
}

// ignore table //
function getIgnoreInfo ($id='',$ignoredid='',$dbObj='') {
	global $DOMAINTABLE,$DBNAME,$TABLE,$MERGETABLE;
	
	$DMARRAY=getDomainInfo(1,$id);
	$dmname=strtoupper($DMARRAY['domainnameshort']); 

	$sql = "SELECT MatriId,IgnoredId,TimeIgnored,Comments from ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[$dmname]['IGNORED']." WHERE MatriId = '".$id."' and IgnoredId = '".$ignoredid."'";
	
	$dbObj->select($sql);
	return $dbObj->fetchArray("MYSQL_ASSOC");
}

// bookmark table //
function getBookmarkInfo ($id='',$bookmarkedid='',$dbObj='') {
	global $DOMAINTABLE,$DBNAME,$TABLE,$MERGETABLE;
	
	$DMARRAY=getDomainInfo(1,$id);
	$dmname=strtoupper($DMARRAY['domainnameshort']); 

	$sql = "SELECT MatriId,BookmarkedId,TimeBookmarked,Comments from ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[$dmname]['BOOKMARKED']." WHERE MatriId = '".$id."' and BookmarkedId = '".$bookmarkedid."'";
	
	$dbObj->select($sql);
	return $dbObj->fetchArray("MYSQL_ASSOC");
}

// Last action - from profile notes (Search template) //
function lastAction($memberid='',$partnerid='',$dbObj='') {
	global $DOMAINTABLE,$DBNAME,$TABLE,$MERGETABLE;

	$DMARRAY=getDomainInfo(1,$memberid);
	$dmname=strtoupper($DMARRAY['domainnameshort']);  

	$sql = "select MatriId,PartnerId,MessageSent,MessageSentDate,MessageSentStatus,MessageIdSent,MessageReceived,MessageReceivedDate,MessageReceivedStatus,MessageIdReceived,Replied,DateReplied,Declined,DateDeclined,RepliedSent,DateRepliedSent,DeclinedSent,DateDeclinedSent,InterestSent,InterestSentDate,InterestSentStatus,InterestIdSent,InterestReceived,InterestReceivedDate,InterestReceivedStatus,InterestIdReceived,Bookmarked,Ignored,Blocked,BookmarkedbyPartnerId,IgnoredbyPartnerId,BlockedbyPartnerId,DateUpdated, IF(InterestReceivedDate>InterestSentDate and InterestReceivedDate>MessageReceivedDate and InterestReceivedDate>MessageSentDate and InterestReceived=1 and InterestReceivedDate>DateReplied and InterestReceivedDate>DateDeclined,'Y','N') as IntRec,IF(InterestSentDate>InterestReceivedDate and InterestSentDate>MessageReceivedDate and InterestSentDate>MessageSentDate and InterestSent=1 and InterestSentdate>DateReplied and InterestSentDate>DateDeclined,'Y','N') as IntSen,IF(MessageSentDate>InterestReceivedDate and MessageSentDate>MessageReceivedDate and MessageSentDate>InterestSentDate and MessageSent=1 and MessageSentdate>DateReplied and MessageSentDate>DateDeclined,'Y','N') as MsgSen,IF(MessageReceivedDate>InterestReceivedDate and MessageReceivedDate>MessageSentDate and MessageReceivedDate>InterestSentDate and MessageReceived=1 and MessageReceivedDate>DateReplied and MessageReceivedDate>DateDeclined,'Y','N') as MsgRec,IF(DateReplied>InterestReceivedDate and DateReplied>MessageSentDate and DateReplied>InterestSentDate and Replied=1 and DateReplied>MessageReceivedDate and DateReplied>DateDeclined,'Y','N') as MsgRep,IF(DateDeclined>InterestReceivedDate and DateDeclined>MessageSentDate and DateDeclined>InterestSentDate and Declined=1 and DateDeclined>MessageReceivedDate and DateDeclined>DateReplied,'Y','N') as MsgDec from ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[$dmname]['PROFILENOTES']." where MatriID = '".$memberid."' and PartnerID = '".$partnerid."'";

	$dbObj->select($sql);
	return $dbObj->fetchArray("MYSQL_ASSOC");
}

function getProfilePendingStatus ($status='') {
	if ($status==0) {
		return 'Pending';
	} elseif ($status==1) {
		return 'Accepted';
	} elseif ($status==2) {
		return 'Declined';
	}
}

function getProfileReadStatus ($status='',$repstatus='',$decstatus='',$daterepliedsent='', $datedeclinedsent='') {
	if ($status==0) {
		return 'Unread';
	} elseif ($status==1 && $repstatus==0 && $decstatus==0) {
		return 'Read';
	} elseif ($status==1 && $repstatus==1 && $daterepliedsent > $datedeclinedsent) {
		return 'Replied';
	} elseif ($status==1 && $decstatus==1 && $datedeclinedsent > $daterepliedsent) {
		return 'Declined';
	}
}

// to search nav pans
function toBuildNavPans($displayformat='B',$tab_links,$smart=1) {
	$spacer_td = '<td valign="top" width="5"><spacer width="5" height="21"></spacer></td>';
	$nav_pans = '<table cellpadding=0 cellspacing=0 border=0 align=right><tr height="21px">'.$spacer_td;
	$start_td = '<td bgcolor="#FFFFFF" ';
	$cur_bgcolor = "#FBEED6";
	$cur_border = 'border:1px solid #C19B7A;border-bottom:0px';
	$spacer = "&nbsp;";
	if($displayformat=='B' || $displayformat=='basic') {
		$nav_pans .= $spacer_td.'<td bgcolor="'.$cur_bgcolor.'" style="'.$cur_border.'"><font class="linktxt2">'.$spacer.'Basic View'.$spacer.'</font></td>'.$spacer_td.$start_td.' style="'.$cur_border.'"><a '.$tab_links['thumb'].'><font class="cstyle">'.$spacer.'Thumbnail View'.$spacer.'</font></a>';
		if($smart==true) {
			$nav_pans .= "</td>".$spacer_td.$start_td.' style="'.$cur_border.'"><a '.$tab_links['photogallery'].'><font class="cstyle">'.$spacer.'Photo Gallery'.$spacer.'</font></a></td>'.$spacer_td.$start_td.' style="'.$cur_border.'"><a '.$tab_links['slideshow'].'><font class="cstyle">'.$spacer.'Slide Show'.$spacer.'</font></a>';
		}
	}
	else if(($displayformat=='P' || $displayformat=='photogallery') && $smart==true) {
		$nav_pans .= $start_td.' style="'.$cur_border.'"><a '.$tab_links['basic'].'><font class="cstyle">'.$spacer.'Basic View'.$spacer.'</font></a></td>'.$spacer_td.$start_td.' style="'.$cur_border.'"><a '.$tab_links['thumb'].'><font class="cstyle">'.$spacer.'Thumbnail View'.$spacer.'</font></a></td>'.$spacer_td.'<td bgcolor="'.$cur_bgcolor.'" style="'.$cur_border.'"><font class="linktxt2">'.$spacer.'Photo Gallery'.$spacer.'</font></td>'.$spacer_td.$start_td.' style="'.$cur_border.'"><a '.$tab_links['slideshow'].'><font class="cstyle">'.$spacer.'Slide Show'.$spacer.'</font></a>';
	}
	else if(($displayformat=='S' || $displayformat=='slideshow') && $smart==true) {
		$nav_pans .= $start_td.' style="'.$cur_border.'"><a '.$tab_links['basic'].'><font class="cstyle">'.$spacer.'Basic View'.$spacer.'</font></a></td>'.$spacer_td.$start_td.' style="'.$cur_border.'"><a '.$tab_links['thumb'].'><font class="cstyle">'.$spacer.'Thumbnail View'.$spacer.'</font></a></td>'.$spacer_td.$start_td.' style="'.$cur_border.'"><a '.$tab_links['photogallery'].'><font class="cstyle">'.$spacer.'Photo Gallery'.$spacer.'</font></a></td>'.$spacer_td.'<td bgcolor="'.$cur_bgcolor.'" style="'.$cur_border.'"><font class="linktxt2">'.$spacer.'Slide Show'.$spacer.'</font>';
	} 
	else {
		$nav_pans .= $start_td.' style="'.$cur_border.'"><a '.$tab_links['basic'].'><font class="cstyle">'.$spacer.'Basic View'.$spacer.'</font></a></td>'.$spacer_td.'<td bgcolor="'.$cur_bgcolor.'" style="'.$cur_border.'"><font class="linktxt2">'.$spacer.'Thumbnail View'.$spacer.'</font>';
		if($smart==true) {		
			$nav_pans .= "</td>".$spacer_td.$start_td.' style="'.$cur_border.'"><a '.$tab_links['photogallery'].'><font class="cstyle">'.$spacer.'Photo Gallery'.$spacer.'</font></a></td>'.$spacer_td.$start_td.' style="'.$cur_border.'"><a '.$tab_links['slideshow'].'><font class="cstyle">'.$spacer.'Slide Show'.$spacer.'</font></a>';
		}
	} 
	$nav_pans .= '</td>';
	if($smart==true) {
		$nav_pans .= $spacer_td;
	}
	return $nav_pans .= '</tr></table>';
}

function formatCasteVal($cv) {
	$patterns[0] = '/Christian - /';
	$patterns[1] = '/Jain - /';
	$patterns[2] = '/Sikh - /';
	$patterns[3] = '/Muslim - /';
	return preg_replace($patterns, '', $cv);
}

function bharatFormatCasteVal($cv) {
	$patterns[0] = '/Christian - /';
	$patterns[1] = '/Jain - /';
	$patterns[2] = '/Sikh - /';
	$patterns[3] = '/Muslim - /';
	$replace[0] = 'Chr-';
	$replace[1] = 'Jain-';
	$replace[2] = 'Sikh-';
	$replace[3] = 'Mus-';
	return preg_replace($patterns, $replace, $cv);
}

function forLanguageWiseFontSize($ln) {
	global $selectbox_fontsize, $selectbox_fontfamily;
	switch ($ln) {
		case 'hi':
			$selectbox_fontsize = 8;
			$selectbox_fontfamily = "Verdana, arial, Verdana, sans-serif";
			//return "<style>.for_language { font-size:25px; } </style>";
			break;
		case 'te':
			$selectbox_fontsize = 11;
			$selectbox_fontfamily = "Verdana, arial, Verdana, sans-serif";
			return "<style>.for_language { font-size:12px; } </style>";
			break;
		case 'ta':
			$selectbox_fontsize = 8;
			$selectbox_fontfamily = "Verdana, arial, Verdana, sans-serif";
			//return "<style>.for_language { font-size:15px; } </style>";
			break;
		case 'kn':
			$selectbox_fontsize = 8;
			$selectbox_fontfamily = "Verdana, arial, Verdana, sans-serif";
			//return "<style>.for_language { font-size:15px; } </style>";
			break;
		case 'mr':
			$selectbox_fontsize = 8;
			$selectbox_fontfamily = "Verdana, arial, Verdana, sans-serif";
			//return "<style>.for_language { font-size:15px; } </style>";
			break;
		case 'gu':
			$selectbox_fontsize = 8;
			$selectbox_fontfamily = "Verdana, arial, Verdana, sans-serif";
			//return "<style>.for_language { font-size:15px; } </style>";
			break;
		case 'en':
			$selectbox_fontsize = 8;
			$selectbox_fontfamily = "Verdana, arial, Verdana, sans-serif";
			//return "<style>.for_language { font-size:15px; } </style>";
			break;
		case 'bn':
			$selectbox_fontsize = 11;
			$selectbox_fontfamily = "Vrinda";
			return "<style>@font-face { font-family: Vrinda;font-style:  normal;font-weight: normal;src: url(/styles/VRINDA0.eot); } .for_language { font-size:17px; font-family: Vrinda; } </style>";
			break;
		case 'ml':
			$selectbox_fontsize = 11;
			$selectbox_fontfamily = "Kartika";
			return "<style>@font-face { font-family: Kartika;font-style: normal;font-weight: normal;src: url(/styles/KARTIKA0.eot); }  .for_language { font-size:13px; font-family: Kartika; } </style>";
			break;
	   default:
			$selectbox_fontsize = 8;
	}
}

function generateLangLables($filename='',$params='',$smartsearch='',$old_search='') {
	global $LANGLABELARRAY, $ln, $LANGVERSION;
	$lang_labels = '<font class="textsmallnormal">View in:&nbsp;';

	foreach($LANGLABELARRAY as $lang_key=>$lang_val) {
		$forlang_class = "";
		if ($lang_key == 'ml' || $lang_key == 'bn') {
			$forlang_class = "<font class='for_language'>";
		}
		if($LANGVERSION[$ln]!=$LANGVERSION[$lang_key]) {
			if($smartsearch!=true) {
				if($old_search==true && $LANGVERSION[$lang_key]=="english") {
					$lang_labels .= '<font class="textsmallnormal">'.$forlang_class.'<a href="'.$filename.'?ln='.$lang_key.'&'.$params.'" class="linktxt" title="'.$LANGVERSION[$lang_key].'">'.$lang_val.'</a>&nbsp;|&nbsp;</font>';
				}
				else {
					$lang_labels .= '<font class="textsmallnormal">'.$forlang_class.'<a href="'.$filename.'?ln='.$lang_key.'&'.$params.'" class="linktxt" title="'.$LANGVERSION[$lang_key].'">'.$lang_val.'</a>&nbsp;|&nbsp;</font>';
				}
			}
			else {
				$lang_labels .= '<font class="textsmallnormal">'.$forlang_class.'<a href="#" onClick="javascript:load_languages(\''.$lang_key.'\');" class="linktxt" title="'.$LANGVERSION[$lang_key].'">'.$lang_val.'</a>&nbsp;|&nbsp;</font>';
			}
		}
		else {
			$lang_labels .= "<span title=".$LANGVERSION[$lang_key]."> ".$forlang_class.$lang_val."</span>&nbsp;|&nbsp;</font>";
		}
	}
	$lang_labels = substr($lang_labels, 0, -20);
	$lang_labels .= "</font>";

	$js_br = getBrowserDetails();
	if($js_br=="I") {
		return $lang_labels;
	} else {
		return '';
	}
}
?>