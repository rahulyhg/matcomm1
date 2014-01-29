<?php
//**************************************************************************************//
//               File Name	: syscreatemaillist.php                                     //
//				 Code By	: Ashok kumar                                               //
//**************************************************************************************//

include "/home/cbsmailmanager/config/config.php";
include_once "lib/functions.php";

ini_set("memory_limit","512M");
global $tbl, $dblink;
// ************* Starts - Assigning the input argument(parameter) values to variables ***************//
	$arg1		 = trim($_SERVER['argv'][0]); // php filename itself
	$arg2		 = trim($_SERVER['argv'][1]); // Email Concept Category
	$membertype  = trim($_SERVER['argv'][2]); // Member type for CBS or BM
	$mailertype  = trim($_SERVER['argv'][3]); // Mailer type of CBS or BM for unsubscribe
	//$argcount	 = trim($_SERVER['argc']);    // Count of arguments catched as input
	
// ************* Ends - Assigning the input argument(parameter) values to variables *****************//

//Unsubscribe email list
$blockedEmailList = unsubscribemaillist($mailertype);

if ($arg2 != '') {
	$category = $arg2;
}

$QueryType = "select";
	if($membertype ==1) {   // For CBS members
		$mailsql = cbsCreateQuery($category,$QueryType);
		$mailsql;
		$mailres = mysql_query ($mailsql);
		$mailnum = cbsrecordcount($QueryType,$mailres);
	}
	$maillistfilename = "/home/cbsmailmanager/mlistfiles/".$category."mail.txt";

	if ($mailnum > 0) {
		if (!$mailfp = fopen($maillistfilename, 'w+')) {
			echo "Cannot open file ($filename)";
			exit;
		}
		$idcount = 1;
		if($QueryType == "select") {
			while ($mailrow = mysql_fetch_array($mailres)) {
				if($mailrow['MotherTongue']=='11' || $mailrow['MotherTongue']=='10' || $mailrow['MotherTongue']=='0' ||			$mailrow['MotherTongue']=='53') {
					$mailrow['Language']='10';
				}
			
			// Script to protect the given Email Service...
				if (trim($service) != '') {
					if(is_array($service)) {
						foreach ($service as $key => $value) {
							if (eregi($value, trim($mailrow['Email']))) {
							   continue 2;
							}
						}
					} else {
						if (eregi($service, trim($mailrow['Email']))) {
						   continue;
						}
					}
				}
			// Script to allow the given Email Service...
				if (trim($allow) != '') {
					if(is_array($allow)) {
						foreach ($allow as $key => $value) {
							if (!eregi($value, trim($mailrow['Email']))) {
							   continue 2;
							}
						}
					} else {
						if (!eregi($allow, trim($mailrow['Email']))) {
						   continue;
						}
					}
				}
				// Writing text file for both CBS & BM members
				if(!(in_array($mailrow['Email'],$blockedEmailList))) {
					if($membertype==1) {  //For CBS members
						$varGender = ($mailrow['Gender']==1)?'M':'F';
						$wrtcontent = trim($idcount).",".trim($mailrow['Email']).",".trim($mailrow['Name']).",".trim($mailrow['MatriId']).",".trim($mailrow['Age']).",".$varGender.",".trim($mailrow['Password']).",".trim($mailrow['CommunityId']).",".trim($mailrow['CasteId']).",".trim($mailrow['Country']).",".date("Y-m-d H:i:s") ."\n";
					} else { // For BM members
						$wrtcontent = trim($idcount).",".trim($mailrow['Email']).",".trim($mailrow['Name']).",".trim($mailrow['MatriId']).",".trim($mailrow['Age']).",".trim($mailrow['Gender']).",".trim($mailrow['Password']).",".trim($mailrow['Language']).",".trim($mailrow['Caste']).",".date("Y-m-d H:i:s") ."\n";
					}
					$idcount++;
					if (fwrite($mailfp, $wrtcontent) === FALSE) {
					   echo "Cannot write to file..";
					   exit;
					}
				} else {
					echo "Blocked email";
				}

				
				
			}
	
		}
		fclose($mailfp);

		//send_reportmail_query($mailsql,$mailnum,$category);			
		/*********************************  Genrating query in below file path*****************/
		//added by anish
		$mailqueryfilename = "/home/cbsmailmanager/www/querylog/Mailer_Query_Log.txt";
		$queryfileopen=fopen($mailqueryfilename,'a+');
		if($mailsql!='') {
			$today = date("F j, Y, g:i a");
			$content_query=$today."|~|".$category."|~|".$mailnum."|~|".$mailsql."\n";
			fwrite($queryfileopen,$content_query);
		}
		fclose($queryfileopen);
		/*********** end of query file creation ********************************/
	}

?>