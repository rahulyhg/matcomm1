<?php
//******************************************************************
// AUTHOR		: ASHOK KUMAR
// FILENAME		: FUNCTIONS.PHP
// PROJECT		: CAMPAIGN ADMIN CONTROL MANAGEMENT
// DATE			: 21-06-2005
// DISCRIPTION	: FILE CONTAINS FUNCTIONS USING ON THIS PROJECT
//******************************************************************

// Format the date and time
function DateTimeStamp($regdate) {
	$datetime=split(" ",$regdate);
	$date = split("-",$datetime[0]);
	$time = split(":",$datetime[1]);
	list($year,$month,$day)=$date;
	$dt = @date("d-M-y",mktime(0,0,0,$month,$day,$year));
	return $dt;
}

function DateTimeStamp1($regdate){
	$datetime=split(" ",$regdate);
	$date = split("-",$datetime[0]);
	$time = split(":",$datetime[1]);
	list($year,$month,$day)=$date;
	list($hr,$mn,$sc)=$time;
	$dt = @date("d-M-y H:i:s",mktime($hr,$mn,$sc,$month,$day,$year));
	return $dt;
}

// Fetching datas from inc arrays and puts into select options...
function select_arrayhash($arryhashname, $in='') {
	global $$arryhashname;
	asort($$arryhashname);
	foreach ($$arryhashname as $key => $value) {
		if(is_int($in)) {
		if ($in == $key) {
			$selected = 'Selected';
		} else {
			$selected = '';
		}
		}
		echo "<option value=\"$key\" $selected>$value</option>";
	}
}

// Fetching datas from inc arrays ...
function get_from_arryhash ($arryhashname, $in='') {
	global $$arryhashname;
	if (array_key_exists($in,$$arryhashname)) {
		return ${$arryhashname}[$in];
	} else {
		return '-';
	}
}

function query_execute ($query,$opr) {
	mysql_query ($query);
	$qry_res = mysql_affected_rows();
	if ( $qry_res == -1 ) {
		$str_res = "<img src='images/icon1.gif' border=0 width=15 height=15> <font color=black>";
		if ( $opr == 'add' ) {
			$str_res .= "New Mailer is not addedd... ";
		} elseif ( $opr == 'update' ) {
			$str_res .= " Mailer is not updated properly... ";
		} elseif ( $opr == 'del' ) {
			$str_res .= "Given Mailer detail is not removed properly... ";
		}
	} else {
		$str_res = "<img src='images/icon1.gif' border=0 width=15 height=15> <font color=black>";
		if ( $opr == 'add' ) {
			$str_res .= "New Mailer is added... ";
		} elseif ( $opr == 'update' ) {
			$str_res .= "Mailer details updated... ";
		} elseif ( $opr == 'del' ) {
			$str_res .= "Given Mailer is removed... ";
		}
	}
	$str_res .= "</font>";
	return $str_res;
}

function record_already_exists($id, $field, $tbl_name) {
	global $tbl, $dblink;

	$sql = "select * from $tbl_name where $field = '$id'";
	$res = mysql_query($sql);
	$row = mysql_fetch_array ($res);
	$num_rows = mysql_num_rows($res);
	if ( $num_rows <= 0 ) {
		return 0; // Record not exists
	} else {
		return 1; // Record exists
	}
}


function unsubscribemaillist($MailerType) {
	global $tbl, $dblink;
	$blockedemails = array();
	$selectquery = "select Distinct Email from ".$tbl['mailunsubscribe']." Where MailerType like '%|".$MailerType."|%'";
	$res = mysql_query($selectquery);
	while($row = mysql_fetch_array($res)){
	array_push($blockedemails,$row['Email']);
	}
	return $blockedemails;
}

function select_month($in='') {
	global $MON;
	foreach ($MON as $key => $value) {
		if ($in == $key) {
			$selected = 'Selected';
		} else {
			$selected = '';
		}
		echo "<option value=\"$key\" $selected>$value</option>";
	}
}

// Select Option Query Function...
function select_option ($fld1='',$fld2='',$table='',$orderby='',$in='',$wherefld='',$whereval='') {
	if ($wherefld != '' && $whereval != '') {
		$sql = "select $fld1, $fld2 from $table where $wherefld = '$whereval' order by $orderby";
	} else {
		$sql = "select $fld1, $fld2 from $table order by $orderby";
	}
	//echo $sql;
	$res = mysql_query ($sql);
	while ( $row = mysql_fetch_array($res) ) {
		if ( $row[$fld1] == $in ) {
			$selected = 'selected';
		} else {
			$selected = '';
		}
		echo "<option value=\"".$row[$fld1]."\" $selected>".$row[$fld2]."</option>";
	}
}

function select_category($in='') {
	global $tbl, $dblink;

	$sql = "select distinct Category, CategoryName from ".$tbl['mailer']." where DelFlag =0 order by Id ";
	$res = mysql_query($sql);
	$num_rows = mysql_num_rows($res);
	while($row = mysql_fetch_array ($res)) {
		if ($in == $row['Category']) {
			$selected = 'Selected';
		} else {
			$selected = '';
		}
		echo "<option value=\"".$row['Category']."\" $selected>".$row['CategoryName']." [ ".$row['Category']." ] "."</option>";
	}
}

function get_value($table,$fld1,$fld2,$id) {
	global $tbl,$dblink;
 	$sql = "select $fld2 from $table where $fld1 = $id";
	$res = mysql_query($sql);
	$row = mysql_fetch_array ($res);
	return $row[$fld2];
}


function getcateginfo($category='') {
	global $tbl,$dblink;
 	$sql = "select * from ". $tbl['mailer'] . " where Category = '$category'";
	$res = mysql_query($sql);
	$row = mysql_fetch_array ($res);
	return $row;
}

function frameunsubscribesql($mailerunsubtype) {
	global $tbl,$bmdblink;
	$sql = "select Email from ". $tbl['bmunsubscribe'] ." where MailerType Like  '%|".$mailerunsubtype."|%'";
	return $sql;
}

function cbsframeunsubscribesql($mailerunsubtype) {
	global $tbl,$dblink;
	$sql = "select Email from ".$tbl['mailunsubscribe']." where MailerType Like  '%|".$mailerunsubtype."|%'";
	return $sql;
}

function file_rec_count ($catg='') {
	$cnt = 0;
	$maillist_filename = '/home/cbsmailmanager/mlistfiles/'.$catg.'mail.txt';
	if (file_exists($maillist_filename)) {
		$lines = file($maillist_filename);
		if (is_array($lines)) {
		$cnt = count($lines);
			if ($cnt != 0 && $cnt != '') {
				return $cnt;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	} else {
		return 0; //return 'Mail list file not exists...';
	}
}

function test_file_rec_count () {
	$cnt = 0;
	$maillist_filename = '/home/cbsmailmanager/mlistfiles/testmaillist.txt';
	if (file_exists($maillist_filename)) {
		$lines = file($maillist_filename);
		if (is_array($lines)) {
		$cnt = count($lines);
			if ($cnt != 0 && $cnt != '') {
				return $cnt;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	} else {
		return 0; //return 'Mail list file not exists...';
	}
}

function cbsCreateQuery($category,$QueryType) {
	global $tbl, $dblink,$ReportEmailids ;
	$catgfile = "/home/cbsmailmanager/mfiles/".$category.".txt";
	$catgfp = fopen($catgfile, "r");
	$catgcont = fread($catgfp, filesize($catgfile));
	fclose($catgfp);
	$mailconfig = explode ("::", $catgcont);
	if ($mailconfig[0] == $category) {
		$category		= $mailconfig[0];
		$language		= $mailconfig[1];
		$country		= $mailconfig[2];
		$testemails		= $mailconfig[3];
		$validated	    = $mailconfig[4];
		$authorise		= $mailconfig[5];
		$status			= $mailconfig[6];
		$paidmembers    = $mailconfig[7];
		$phone			= $mailconfig[8];
		$remarks		= $mailconfig[9];
		$memberstatus   = $mailconfig[10];
		$dateofconfig   = $mailconfig[11];
		$fromlastlogin  = $mailconfig[12];
		$tolastlogin    = $mailconfig[13];
		$education      = $mailconfig[14];
		$fromtimecreated= $mailconfig[15];
		$totimecreated  = $mailconfig[16];
		$gender         = $mailconfig[17];
		$agefrom        = $mailconfig[18];
		$ageto          = $mailconfig[19];
		$allowemails    = $mailconfig[20];
		$profile		= $mailconfig[21];
		$indianstate	= $mailconfig[22];
		$usstate		= $mailconfig[23];
		$district		= $mailconfig[24];
		$mothertongue	= $mailconfig[25];
		$religion		= $mailconfig[26];
		$caste			= $mailconfig[27];
		$bywhom         = $mailconfig[29];
		$payexpire      = $mailconfig[30];
		$castenobar     = $mailconfig[31];
		$occupation     = $mailconfig[32];
		$option_andor	= $mailconfig[33];
		$expirydate_from = $mailconfig[34];
		$expirydate_to	= $mailconfig[35];
		$familystatus	= $mailconfig[36];
		$oavailable		= $mailconfig[37];
		$phystatus		= $mailconfig[38];
		$horoscope		= $mailconfig[39];
		// Newly added conditions
		$PhotoAvl		= $mailconfig[40];
		$PhotoProtected	= $mailconfig[41];
		$VoiceAvl		= $mailconfig[42];
		$VideoAvl		= $mailconfig[43];
		$HealthProfAvl	= $mailconfig[44];
		$logincountfrom	= $mailconfig[45];
		$logincountto	= $mailconfig[46];
		$subcaste		= $mailconfig[47];
		$NoofPayment	= $mailconfig[48];
		$MaritalStatus	= $mailconfig[49];
		$mailerunsubtype= $mailconfig[50];
		$offercategoryid = $mailconfig[51];//note 52 is allocated for send mail
		$mailertype      = $mailconfig[53];
		$otherdistrictid = $mailconfig[54];
		$selecttype      = $mailconfig[55];
		$mothertongueselecttype = $mailconfig[57];  //selecting mothertongue

		if (trim($mailconfig[3]) != '') {
			$service = explode(",",trim($mailconfig[3])); // Gathering Email Serivce Portal names...
		}
		if (trim($mailconfig[20]) != '') {
			$allow = explode(",",trim($mailconfig[20])); // Gathering Email Serivce Portal names...
		}

		if ($category != '') {
			$mailsql = "select ";
			if( $memberstatus == 1)
				$SPLITTED_MAILERTABLE = $tbl['profile'];   //'communitymatrimony.memberinfo'; //For cbs members
			if( $memberstatus == 2)
				$SPLITTED_MAILERTABLE = $tbl['inactive'];  // For CBS Inactive members
			if( $memberstatus == 3)
				$SPLITTED_MAILERTABLE = $tbl['profiledel']; //'communitymatrimony.memberdeletedinfo'; // Deleted profile
			if( $memberstatus == 4)
				$SPLITTED_MAILERTABLE = $tbl['prcase1'];   //'communitymatrimony.memberpartlyinfo'; //PRcase1 profile
			if( $memberstatus == 5)
				$SPLITTED_MAILERTABLE = $tbl['prcase2'];   //'communitymatrimony.memberpartlyinfo'; //PRcase2 profile

			if($QueryType == "select") {		
				if( $memberstatus ==4 || $memberstatus ==5) {
					$mailsql .=  " Email, Member_Id, Name, Age, Gender, CommunityId,Marital_Status,CasteId from ".$SPLITTED_MAILERTABLE." where 1 ";
				} else if ($memberstatus ==1){
					$mailsql .= "Email, MatriId, Name, Age, Gender, Password, CommunityId, Mother_TongueId, Marital_Status, CasteId,Country from ".$SPLITTED_MAILERTABLE." where 1";
				} else {
					$mailsql .= "Email, MatriId, Name, Age, Gender, CommunityId,Mother_Tongue,CasteId from ".$SPLITTED_MAILERTABLE." where 1 ";
				}
			} elseif($QueryType == "count") {
				$mailsql .= " count(1) from " . $SPLITTED_MAILERTABLE . " where 1 ";
			}
			if ($memberstatus == 1 || $memberstatus == 3 || $memberstatus == 2) {
				// Added by karthik
				/*if($bywhom != '') { 
					$mailsql .= " and Profile_Created_By in ($bywhom) ";
				}
				if($payexpire != '') {
					$mailsql .= " and EntryType='R' and ((ValidDays - (TO_DAYS(NOW()) - TO_DAYS(LastPayment))) <= $payexpire and (ValidDays - (TO_DAYS(NOW()) - TO_DAYS(LastPayment))) >0) ";
				}
				if($phystatus != 'x' && $phystatus != ''){
					$mailsql .= "and SpecialCase = '$phystatus' ";
				} */
	
				// Ended
				if($memberstatus != 2) {
					/*if ($validated != 'x' && $validated != '') {
						$mailsql .= " and Validated = '$validated' ";
					}
										
					if ($authorise != 'x' && $authorise != '') {
						$mailsql .= " and Publish = '$authorise' ";
					} */

					if ($status != '') {
						$mailsql .= " and Publish in ($status) ";
					}
				} 
				
				if ($phone != 'x' && $phone != '') {
					$mailsql .= " and Phone_Verified = '$phone' ";
				}
				if ($profile != 'x' && $profile != '') {
					$mailsql .= " and Profile_Verified = '$profile' ";
				}
				if ($paidmembers != 'x' && $paidmembers != '') {
					if ($paidmembers == 'F') {
						$mailsql .= " and Paid_Status = 0 ";
					} elseif ($paidmembers == 'P') {
						$mailsql .= " and Paid_Status = 1 ";
					}
				}
				if($oavailable != 'x' && $oavailable != '') {
					$mailsql .= "and OfferAvailable = '$oavailable' ";
				}
				if ($MartialStatus != '0' && $MaritalStatus != '') {
					$mailsql .= " and Marital_Status in ($MaritalStatus) ";
				}
				/*if ($horoscope != 'x' && $horoscope != '') {
					$mailsql .= " and Horoscope_Available in ($horoscope) ";
				}*/
				if ($fromlastlogin != '' && $tolastlogin != '' && $option_andor==0) {
					$mailsql .= " and Last_Login >= '$fromlastlogin 00:00:00' and Last_Login <= '$tolastlogin 23:59:59' ";
				}
				if ($education != '') {
					$mailsql .= " and Education_category in ($education) ";
				}
				if ($mothertongue != '') {
					if($mothertongueselecttype==1) {
						$mailsql .= " and Mother_TongueId not in ($mothertongue) ";
					} else {
						$mailsql .= " and Mother_TongueId in ($mothertongue) ";
					}
				}
				if ($religion != '') {
					$mailsql .= " and Religion in ($religion) ";
				}
				if($selecttype ==1) {
					if ($caste != '') {
						$mailsql .= " and CommunityId not in (2002,$caste) ";
					}
				} else {
					if ($caste != '') {
						$mailsql .= " and CommunityId in ($caste) ";
					}
				}
				if ($subcaste != '') {
					$mailsql .= " and SubcasteId in ($subcaste) ";
				}
				if ($castenobar != '') {
					$mailsql .= " and Caste_Nobar=$castenobar ";
				}
				if ($occupation != '') {
					$occupation=explode(',',$occupation);
					$result=$occupation;
					foreach($occupation as $key => $value) {
						if($value==101 || $value==102){
							unset($occupation[$key]);
						}				
					}
					$occupation=implode(',',$occupation);
					if($occupation!='') {
						$mailsql .= " and (Occupation in ($occupation)";
					}
					
					$mailsql .= " )";
				}
				if ($familystatus != '') {
					$mailsql .= " and Family_Status in ($familystatus)";
				}
				
				// NEWLY ADDED
				if ($NoofPayment != '' && $NoofPayment != 'x') {
					if($NoofPayment ==0) {
						$mailsql .= " and Number_Of_Payments =$NoofPayment ";
					} else if($NoofPayment ==1) {
						$mailsql .= " and Number_Of_Payments >=$NoofPayment ";
					}
				}
				/* if ($PhotoAvl != 'x' && $PhotoAvl != '') {
					$mailsql .= " and PhotoAvailable = '$PhotoAvl' ";
				} 
				if ($VoiceAvl != 'x' && $VoiceAvl != '') {
					$mailsql .= " and Voice_Available = '$VoiceAvl' ";
				}
				if ($VideoAvl != 'x' && $VideoAvl != '') {
					$mailsql .= " and Video_Protected = '$VideoAvl' ";
				}
				if ($HealthProfAvl != 'x' && $HealthProfAvl != '') {
					$mailsql .= " and Health_Profile_Available = '$HealthProfAvl' ";
				} 
				if ($PhotoProtected != 'x' && $PhotoProtected != '') {
					$mailsql .= " and ProfileVerified = '$PhotoProtected' ";
				}*/
				
				if ($offercategoryid != 'x' && $offercategoryid != '') {
					$mailsql .= " and OfferCategoryId = '$offercategoryid' ";
				}
				if ($logincountfrom != '' && $logincountto != '') {
					$mailsql .= " and LoginCount >= '".$logincountfrom."'  and  LoginCount <= '".$logincountto."' ";
				}
			}

			if ($memberstatus == 1 || $memberstatus == 5 || $memberstatus == 3 || $memberstatus == 2) {
				if ($language != '') {
						$mailsql .= " and Language in ($language) ";
				}
				if ($country != '') {
					$country_array = explode(",",$country);
					if(!in_array("98", $country_array) && !in_array("222", $country_array)) {
						$mailsql .= " and Country in ($country) ";
					} else {
						foreach( $country_array as $value ) {
							if($value != "98" && $value !="222")
								$country_val .= $value.",";
						}
						$country_val = substr($country_val, 0, -1);
						if($memberstatus == 5) {
							if(!empty($country_val))
								$mailsql .= " and  CountrySelected in ($country_val) ";
							else 
								$mailsql .= " and ( ";
						} else {
							if(!empty($country_val))
							$mailsql .= " and ( Country in ($country_val) or ";
						else 
							$mailsql .= " and ( ";

						}
					}
				}
				if ($memberstatus != "5") {
					if ($country != '') {
						if(in_array("98", $country_array) && in_array("222", $country_array)) {
							if($indianstate != '' && $usstate != '') {
								$mailsql .= " ( ( Country = 98 and Residing_State in ($indianstate) ) or ( Country = 222 and Residing_State in ($usstate) ) ) ";
							}
							if($indianstate != '' && $usstate == '') {
								$mailsql .= " ( Country = 98 and Residing_State in ($indianstate) )";
							}	
							if($indianstate == '' && $usstate != '') {
								$mailsql .= " ( Country = 222 and Residing_State in ($usstate) )";
							}
							if($district != '' && $indianstate == '' && $usstate == '' && $otherdistrictid=='') {
								$mailsql .= " ( Country = 98 and Residing_District in ($district) ) ";
							}
							if($district != '' && ( $indianstate != '' || $usstate != '' && $otherdistrictid=='') ) {
								$mailsql .= " or Residing_District in ($district) ";
							}
							
							if($indianstate == '' && $usstate == '' && $district == '' && $otherdistrictid == '') {
								$mailsql .= " Country = 98 or Country = 222 ";
							}
							$mailsql .= " ) ";
						} else if(in_array("98", $country_array) || in_array("222", $country_array)) {
							if(($indianstate != '') && (in_array("98", $country_array))) {
								$mailsql .= " ( ( Country = 98 and Residing_State in ($indianstate) ) )";
							}
							if(($usstate != '') && (in_array("222", $country_array))) {
								$mailsql .= " ( ( Country = 222 and Residing_State in ($usstate) ) )";
							}
							if($district != '' && $otherdistrictid=='' && (in_array("98", $country_array)) && $indianstate == '')	{
								$mailsql .= " ( Country = 98 and Residing_District in ($district) )";
							}
							if($district != '' && $otherdistrictid=='' && (in_array("98", $country_array)) && $indianstate != '')	{
								$mailsql .= " or Residing_District in ($district) ";
							}
							
							if($indianstate == '' && $usstate == '' && $district == '' && $otherdistrictid == '') {
								if(in_array("98", $country_array)) {
									$mailsql .= " Country = 98 ";
								}
								if(in_array("222", $country_array)) {
									$mailsql .= " Country = 222 ";
								}
							}
							$mailsql .= " ) ";
						} // end else
					} // end if for country!=""
				} // end if for memberstatus!=5
			}
			if ($memberstatus == 1 || $memberstatus == 3 || $memberstatus == 4 || $memberstatus == 2) {
				if ($gender != '' && $gender != 'x') {
					$mailsql .= " and Gender = '$gender' ";
				}
				if ($agefrom != '' && $ageto != '') {
					$mailsql .= " and Age >= $agefrom and Age <= $ageto ";
				}
				if ($fromtimecreated != '' && $totimecreated != '' && $option_andor==0) {
					$mailsql .= " and Date_Created >= '$fromtimecreated 00:00:00' and Date_Created <= '$totimecreated 23:59:59' ";
				}
				if($option_andor!=0 ) {
					if ($fromtimecreated != '' && $totimecreated != '' && $fromlastlogin != '' && $tolastlogin != '' && $option_andor ==1) {
						$mailsql .= " and ((Last_Login >= '$fromlastlogin 00:00:00' and Last_Login <= '$tolastlogin 23:59:59') and (Date_Created >= '$fromtimecreated 00:00:00' and Date_Created <= '$totimecreated 23:59:59')) ";			
					} else if($fromtimecreated != '' && $totimecreated != '' && $fromlastlogin != '' && $tolastlogin != '' && $option_andor ==2) {
						$mailsql .= " and ((Last_Login >= '$fromlastlogin 00:00:00' and Last_Login <= '$tolastlogin 23:59:59') or (Date_Created >= '$fromtimecreated 00:00:00' and Date_Created <= '$totimecreated 23:59:59')) ";				
					}			
				}//if
				if($expirydate_from !='' && $expirydate_to !='') {
					$mailsql .= " and Expiry_Date >= '$expirydate_from 00:00:00' and Expiry_Date <= '$expirydate_to 23:59:59' ";		
				}
			}//member status if
			//$subqry = cbsframeunsubscribesql($mailerunsubtype);
			//$mailsql .= " and Email not in ($subqry) ";
			
			if(	$QueryType == "select") {
				$mailsql .= "  order by Last_Login DESC ";
			}
			echo $mailsql;
			return $mailsql;
		} //End of category
	}
}

function cbsrecordcount($QueryType,$Queryresult){
	global $tbl, $dblink;
	if($QueryType == "select"){
		return $mailnum = mysql_num_rows ($Queryresult);
	} elseif($QueryType == "count") {
		$mailnum = mysql_fetch_array($Queryresult);
		return $mailnum = $mailnum[0];
	}
}

function recordcount($QueryType,$Queryresult){
	global $bmdblink;
	if($QueryType == "select") {
		return $mailnum = mysql_num_rows ($Queryresult);
	} elseif($QueryType == "count") {
		$mailnum = mysql_fetch_array($Queryresult);
		return $mailnum = $mailnum[0];
	}
}

function send_reportmail_query($mailsql,$mailnum,$category){
	global $ReportEmailids;
	$reportheader  = "MIME-Version: 1.0\n";
	$reportheader .= "From: MailManager<info@communitymatrimony.com\n";
	$reportheader .= "Content-type: text/html\n";
	$reportheader .= "Sender: Communitymatrimony.com<info@communitymatrimony.com>\n";
	$reportheader .= "Reply-To: noreply@communitymatrimony.com\n";
	$reportheader .= "X-Mailer: PHP mailer\n";

	$reportsubject = " Query : ".$mailsql."<br>";
	$reportsubject .= " Count : ".$mailnum."<br>";
	$reportsubject .= " File : ".$category."mail.txt <br>";

	mail($ReportEmailids,"Text File Generated - $category",$reportsubject,$reportheader);
}

?>