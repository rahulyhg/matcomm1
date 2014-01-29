<?php
#================================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-02-12
# End Date		: 2010-02-12
# Project		: CommunityMatrimony
# Module		: Login Remainder Text File Creation
#================================================================================================================

//FILE INCLUDES
include_once('/home/product/community/ability/conf/config.inc');
include_once('/home/product/community/ability/conf/ip.inc');
include_once('/home/product/community/ability/conf/dbinfo.inc');
include_once('/home/product/community/ability/lib/clsDB.php');

//VARIABLE DECLARATION
$cnt=0;
$finc=0;
$varContent	= '';
$fileNames	= '';


//OBJECT DECLARATION
$objDB		= new DB;
$objDB->dbConnect('S', $varDbInfo['DATABASE']);

//CHECK DB CONECTION STATUS
if($objDB->clsErrorCode){
	echo "DataBase Connection Error.";
	exit;
}

//Query to get the records from memberinfo and memberlogininfo
$before15days  = date("Y-m-d",mktime(0,0,0,date("m") ,date("d")-15,date("Y")));
//$before6months = date("Y-m-d",mktime(0,0,0,date("m")-6 ,date("d"),date("Y")));
$yesterday     = date("Y-m-d",mktime(0,0,0,date("m") ,date("d")-1,date("Y")));
$today         = date("Y-m-d");
if($argv[1]=='LoginRemainder'){
	$varQuery	= "SELECT A.Email,A.Password,A.MatriId, B.Nick_Name, B.Name,B.CommunityId,B.Paid_Status FROM communitymatrimony.memberlogininfo A, communitymatrimony.memberinfo B WHERE A.MatriId=B.MatriId AND B.Publish<=2 AND B.Last_Login >='".$before15days." 00:00:00' AND B.Last_Login <='".$before15days." 23:59:59'";
}

//Query to get the records from interestreceivedinfo
if($argv[1]=='ExpressInterest'){
	$varQuery	= "SELECT MatriId,Interest_Pending_Received FROM memberstatistics WHERE Interest_Pending_Received>0";
	//$varQuery	= "SELECT MatriId, COUNT(MatriId) AS count FROM communitymatrimony.interestreceivedinfo WHERE Status=0 AND Date_Received <='".$yesterday." 23:59:59' GROUP BY MatriId HAVING ( COUNT(MatriId) >= 1 )";
}

//Query to get the records from mailreceivedinfo
if($argv[1]=='PersonalizedMessages'){
	$varQuery	= "SELECT MatriId,Mail_UnRead_Received FROM memberstatistics WHERE Mail_UnRead_Received>0";
	//$varQuery	= "SELECT MatriId, COUNT(MatriId) AS count FROM communitymatrimony.mailreceivedinfo WHERE Status=0 AND Date_Received <='".$yesterday." 23:59:59' GROUP BY MatriId HAVING ( COUNT(MatriId) >= 1 )";
}

if($varQuery){
	$varResult  = mysql_query($varQuery) OR die('error');
	$varNo		= mysql_num_rows($varResult);


	while($row = mysql_fetch_assoc($varResult)) {
		$cnt++;

		//LOGIN REMAINDER LOGIC PART START HERE
		if($argv[1]=='LoginRemainder'){
				$varNickName	= $row['Nick_Name'];
				$varName		= $varNickName ? $varNickName : $row['Name'];
				
				//QUERY TO GET THE RECORDS FROM mailreceivedinfo
				$mailreceivedinfoQuery	= "SELECT COUNT(1) as count FROM communitymatrimony.mailreceivedinfo WHERE MatriId='".$row['MatriId']."' AND Status=0";
				$mailreceivedDB     = mysql_query($mailreceivedinfoQuery) OR die('error');
				$mailreceivedResult = mysql_fetch_assoc($mailreceivedDB);

				//QUERY TO GET THE RECORDS FROM interestreceivedinfo
				$interestreceivedinfoQuery	= "SELECT COUNT(1) as count FROM communitymatrimony.interestreceivedinfo WHERE MatriId='".$row['MatriId']."' AND Status=0";
				$interestreceivedDB  = mysql_query($interestreceivedinfoQuery) OR die('error');
				$interestreceivedResult = mysql_fetch_assoc($interestreceivedDB);

				//CONTENT FORMATION
				$varContent .= $cnt.'~'.$row['MatriId'].'~'.$row['Email'].'~'.$row['Password'].'~'.$row['CommunityId'].'~'.$row['Paid_Status'].'~'.$varName.'~'.$mailreceivedResult['count'].'~'.$interestreceivedResult['count']."\n";

				//$varFilename= "LoginReminder_count_".date('Ymd').'.txt';
				$varFilename= "/home/product/community/ability/remindermailer/loginreminder/LoginReminder_".date('Ymd').'_count.txt';


		}
		//LOGIN REMAINDER LOGIC PART END HERE

		//EXPRESS INTEREST LOGIC PART START HERE
		if($argv[1]=='ExpressInterest'){

				//QUERY TO GET THE RECORDS FROM memberinfo
				$memberinfoQuery	= "SELECT CommunityId,Nick_Name,Name,Last_Login,Paid_Status FROM communitymatrimony.memberinfo WHERE MatriId='".$row['MatriId']."'";
				$memberinfoDB     = mysql_query($memberinfoQuery) OR die('error');
				$memberinfoResult = mysql_fetch_assoc($memberinfoDB);
				$varNickName	= $memberinfoResult['Nick_Name'];
				$varName		= $varNickName ? $varNickName : $memberinfoResult['Name'];

				//QUERY TO GET THE RECORDS FROM memberlogininfo
				$memberLogininfoQuery	= "SELECT Email FROM communitymatrimony.memberlogininfo WHERE MatriId='".$row['MatriId']."'";
				$memberLogininfoDB		= mysql_query($memberLogininfoQuery) OR die('error');
				$memberLogininfoResult	= mysql_fetch_assoc($memberLogininfoDB);

				//QUERY TO GET THE RECORDS FROM interestreceivedinfo
				$interestreceivedinfoQuery	= "SELECT Opposite_MatriId,Interest_Id_Received FROM communitymatrimony.memberactioninfo WHERE MatriId='".$row['MatriId']."' AND Interest_Id_Received!=0 AND Interest_Received_Status=0 ORDER BY Interest_Id_Received DESC limit 0,1";
				//$interestreceivedinfoQuery	= "SELECT Opposite_MatriId,Interest_Option,Date_Received FROM communitymatrimony.interestreceivedinfo WHERE MatriId='".$row['MatriId']."' AND Status=0 order by Date_Received desc limit 0,1";
				$interestreceivedDB  = mysql_query($interestreceivedinfoQuery) OR die('error');
				$interestreceivedResult = mysql_fetch_assoc($interestreceivedDB);

				//CONTENT FORMATION
				$varContent .= $cnt.'~'.$row['MatriId'].'~'.$memberLogininfoResult['Email'].'~'.$memberinfoResult['Last_Login'].'~'.$row['Interest_Pending_Received'].'~'.$interestreceivedResult['Opposite_MatriId'].'~'.$memberinfoResult['CommunityId'].'~'.$varName.'~'.$memberinfoResult['Paid_Status'].'~'.$interestreceivedResult['Interest_Id_Received']."\n";

				//$varFilename= "ExpressInterest_count_".date('Ymd').'.txt';
				$varFilename= "/home/product/community/ability/remindermailer/expintpending/ExpressInterest_".date('Ymd').'_count.txt';
				

		}
		//EXPRESS INTEREST LOGIC PART END HERE

		//PERSONALIZED MESSAGES LOGIC PART START HERE
		if($argv[1]=='PersonalizedMessages'){

				//QUERY TO GET THE RECORDS FROM memberinfo
				$memberinfoQuery	= "SELECT CommunityId,Nick_Name,Name,Last_Login,Paid_Status FROM communitymatrimony.memberinfo WHERE MatriId='".$row['MatriId']."'";
				$memberinfoDB     = mysql_query($memberinfoQuery) OR die('error');
				$memberinfoResult = mysql_fetch_assoc($memberinfoDB);
				$varNickName	= $memberinfoResult['Nick_Name'];
				$varName		= $varNickName ? $varNickName : $memberinfoResult['Name'];

				//QUERY TO GET THE RECORDS FROM memberlogininfo
				$memberLogininfoQuery	= "SELECT Email FROM communitymatrimony.memberlogininfo WHERE MatriId='".$row['MatriId']."'";
				$memberLogininfoDB		= mysql_query($memberLogininfoQuery) OR die('error');
				$memberLogininfoResult	= mysql_fetch_assoc($memberLogininfoDB);

				//QUERY TO GET THE RECORDS FROM mailreceivedinfo
				$mailreceivedinfoQuery	= "SELECT Opposite_MatriId,Mail_Id_Received FROM memberactioninfo WHERE MatriId='".$row['MatriId']."' AND Mail_Id_Received!=0 AND Mail_Received_Status=0 ORDER BY Mail_Id_Received DESC limit 0,1";
				//$mailreceivedinfoQuery	= "SELECT Opposite_MatriId,Date_Received FROM communitymatrimony.mailreceivedinfo WHERE MatriId='".$row['MatriId']."' AND Status=0 order by Date_Received desc limit 0,1";
				$mailreceivedinfoDB  = mysql_query($mailreceivedinfoQuery) OR die('error');
				$mailreceivedinfoResult = mysql_fetch_assoc($mailreceivedinfoDB);

				//CONTENT FORMATION
				$varContent .= $cnt.'~'.$row['MatriId'].'~'.$memberLogininfoResult['Email'].'~'.$memberinfoResult['Last_Login'].'~'.$row['Mail_UnRead_Received'].'~'.$mailreceivedinfoResult['Opposite_MatriId'].'~'.$memberinfoResult['CommunityId'].'~'.$varName.'~'.$memberinfoResult['Paid_Status'].'~'.$mailreceivedinfoResult['Mail_Id_Received']."\n";

				//$varFilename= "PersonalizedMessages_count_".date('Ymd').'.txt';
				$varFilename= "/home/product/community/ability/remindermailer/msgpending/PersonalizedMessages_".date('Ymd').'_count.txt';


		}
		//PERSONALIZED MESSAGES LOGIC PART END HERE

		if($cnt==$varNo){
			$part_cnt=$varNo;
		}else{
			$part_cnt=800000;
		}
		if(($cnt%$part_cnt)==0){//800000
			//CREATE FILE
			$finc++;
			$varFilename=str_replace('count',$finc,$varFilename);
			$varFileHandler	= fopen($varFilename,"w");
			fwrite($varFileHandler,$varContent);
			fclose($varFileHandler);
			$varContent ='';
			$fileNames	.=$varFilename."<br>";

		}
	}
}
?>