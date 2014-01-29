<?php
#=============================================================================================================
# Author 		: Baranidharan
# Date	        : 2010-02-25
# Project		: Community Matrimony Product
# Module		: Admin Support Interface
# Description   : View of Phone no to given MatriId & Log the same in adminviewlog table
#=============================================================================================================
//ini_set('display_errors',0);
//FILE INCLUDES
$varRootBasePath = '/home/product/community';

include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/www/admin/includes/config.php");
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
//include_once($varRootBasePath.'/www/admin/header.php');

// Remove White spaces in string
$varMatriId=trim($_GET['Mid']);
$status = ($_GET['status'])?'Verified Phone No':'Non Verified Phone No';
$varLoginPrivilege	= $_COOKIE["loginPrivilege"];
$varPrivilegeInfo	= explode("^|", $varLoginPrivilege);
$varPhoneView		= trim($varPrivilegeInfo[3]);

if($varMatriId != '' && $adminUserName != '') {

	if($varPhoneView == 1) {

		//OBJECT DECLARTION
		$objDBSlave			= new MemcacheDB;

		//DB CONNECTION
		$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

		#Getting member information for the selected profile
		$argCondition				= "WHERE MatriId=".$objDBSlave->doEscapeString($varMatriId,$objDBSlave);
		$argFields 					= array('Phone_Verified','Contact_Phone','Contact_Mobile');
		$varMemberInfoRes			= $objDBSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varMemberInfo				= mysql_fetch_assoc($varMemberInfoRes);

		$varPhoneVerified			= $varMemberInfo['Phone_Verified'];

		//get Phone from assured contact
		if($varPhoneVerified == 1) {
			$argFields						= array('CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1');
			$varAssuredContactInfoRes		= $objDBSlave->select($varTable['ASSUREDCONTACT'],$argFields,$argCondition,0);
			$varAssuredContactInfo			= mysql_fetch_assoc($varAssuredContactInfoRes);
			if(($varAssuredContactInfo['PhoneNo']!='') && ($varAssuredContactInfo['MobileNo']!=''))
				$varTelephone = $varAssuredContactInfo['CountryCode'].'~'.$varAssuredContactInfo['AreaCode'].'~'.$varAssuredContactInfo['PhoneNo'].'/'.$varAssuredContactInfo['CountryCode'].'~'.$varAssuredContactInfo['MobileNo'];
			elseif(($varAssuredContactInfo['PhoneNo']!='') && ($varAssuredContactInfo['MobileNo']==''))
				$varTelephone = $varAssuredContactInfo['CountryCode'].'~'.$varAssuredContactInfo['AreaCode'].'~'.$varAssuredContactInfo['PhoneNo'];
			elseif(($varAssuredContactInfo['PhoneNo']=='') && ($varAssuredContactInfo['MobileNo']!=''))
				$varTelephone = $varAssuredContactInfo['CountryCode'].'~'.$varAssuredContactInfo['MobileNo'];
			else
				$varTelephone = '-';
		} else {
			if(($varMemberInfo['Contact_Phone']!='') && ($varMemberInfo['Contact_Mobile']!=''))
				$varTelephone = $varMemberInfo['Contact_Phone'].'/'.$varMemberInfo['Contact_Mobile'];
			elseif(($varMemberInfo['Contact_Phone']!='') && ($varMemberInfo['Contact_Mobile']==''))
				$varTelephone = $varMemberInfo['Contact_Phone'];
			elseif(($varMemberInfo['Contact_Phone']=='') && ($varMemberInfo['Contact_Mobile']!=''))
				$varTelephone = $varMemberInfo['Contact_Mobile'];
			else
				$varTelephone = '-';
		}
		$objDBSlave->dbClose();
		echo '<link rel=stylesheet href='.$confValues['CSSPATH'].'/global-style.css>';
		echo '<center><table border="0" cellpadding="3" cellspacing="3" align="center" WIDTH="200">
	    <caption><label class="heading">Admin Phone View</label></caption>
		<tr align="left" class=smalltxt><td>Matri Id</td><td >'.$varMatriId.'</td></tr>';
		echo "<tr class='smalltxt'><td>Phone No</td><td>".$varTelephone."</td></tr>";
		echo "<tr class='smalltxt'><td>Status</td><td>".$status."</td></tr>";
        echo '<tr><td height="10" colspan="3"></td></tr>';
	    echo '<tr><td align=middle colspan=2><input type=submit class=button value=Close onClick=javascript:self.close();></td></tr></table></center>';

		//DB CONNECTION
		$objDBMaster		= new MemcacheDB;
		$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

		#Insert phone view information by users in adminviewlog table
		$argFields=array('MatriId ','User_Name','Date_Phone_Viewed');
		array($objDBMaster->doEscapeString($varMatriId,$objDBMaster),$objDBMaster->doEscapeString($adminUserName,$objDBMaster),"NOW()");
		$objDBMaster->insert('adminviewlog',$argFields,$FieldValues);
		$objDBMaster->dbClose();
	} else {
		echo "Access Denied for this User";
	}
} else {
	echo "No Input to this page";
}
?>