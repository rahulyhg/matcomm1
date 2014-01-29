<?php
//*************************************
// File Name	: createmaillist.php
// Code By		: Ashok kumar
//*************************************

if ($category != '') {

		$maillistfilename = "/home/cbsmailmanager/mlistfiles/".$category."mail.txt";

		$mailsql = "select id, Email, MatriId, Name from " . $tbl['profile'] . " where 1 ";

		if ($memberstatus != '0' && $memberstatus != 'x' && $memberstatus != '') {
			$mailsql .= " and MemberStatus = '$memberstatus' ";
		}

		if ($memberstatus == 1) {
			if ($validated != 'x' && $validated != '') {
				$mailsql .= " and Validated = '$validated' ";
			}

			if ($authorise != 'x' && $authorise != '') {
				$mailsql .= " and Authorized = '$authorise' ";
			}

			if ($paidmembers != 'x' && $paidmembers != '') {
				if ($paidmembers == 'F') {
					$mailsql .= " and EntryType = 'F' ";
				} elseif ($paidmembers == 'P') {
					$mailsql .= " and EntryType != 'F' ";
				}
			}

			if ($phone != 'x' && $phone != '') {
				$mailsql .= " and PhoneVerified = '$phone' ";
			}

			if ($status != '') {
				$mailsql .= " and Status in ($status) ";
			}

			if ($fromlastlogin != '' && $tolastlogin != '') {
				$mailsql .= " and DATE_FORMAT(LastLogin, '%Y-%m-%d') >= '$fromlastlogin' and DATE_FORMAT(LastLogin, '%Y-%m-%d') <= '$tolastlogin' ";
			}

		}

		if ($memberstatus == 1 || $memberstatus == 5) {
			if ($language != '') {
				$mailsql .= " and Language in ($language) ";
			}

			if ($country != '') {
				$mailsql .= " and CountrySelected in ($country) ";
			}
		}

		$mailsql .= " order by id ";
		echo $mailsql;
		
		$mailres = mysql_query ($mailsql);
		$mailnum = mysql_num_rows ($mailres);
		
		if ($mailnum > 0) {
			if (!$mailfp = fopen($maillistfilename, 'a+')) {
				echo "Cannot open file ($filename)";
				exit;
			}

			while ($mailrow = mysql_fetch_array($mailres)) {
				$bounceexists = checkbouncemailexists ($mailrow['Email'],$category);
				$unsubscribeexists = checkunsubscribeexists ($mailrow['Email'],$category);
				if ($bounceexists != 1 && $unsubscribeexists != 1) {
					$wrtcontent = trim($mailrow['id']).",".trim($mailrow['Email']).",".trim($mailrow['Name']).",".trim($mailrow['MatriId'])."\n";
					
					if (fwrite($mailfp, $wrtcontent) === FALSE) {
					   echo "Cannot write to file..";
					   exit;
					}
				}
			}

			fclose($mailfp);
		} else {
			//echo "No Record found...";
		}
}

?>