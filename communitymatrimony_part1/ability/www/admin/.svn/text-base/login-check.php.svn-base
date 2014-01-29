<?php
#=============================================================================================================
# Author 		: S Anand, N Dhanapal, M Senthilnathan & S Rohini
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

// INCLUDES
$varDocPath = "/home/product/community/ability";
include_once $varDocPath."/www/admin/ldap.php";

//CONFIG VALUES
$confDomainName	= $confValues["DomainName"];
$confDomainName	= $confDomainName ? $confDomainName : $confValues["DOMAINNAME"];

if($_REQUEST["frmLoginSubmit"]=="yes")
{
	//FILE INCLUDES
	$objMasterDB	= new DB;
	$objSlaveDB		= new DB;

	//OBJECT DECLARTION
	$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);
	$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);


	$varUsername	= trim($_POST["idEmail"]);
	$varPassword	= trim($_POST["password"]);
	$varCurrentDate	= date('Y-m-d H:i:s');

	$varEmailInfo = explode("@",$varUsername);
	$varEmailUser = $varEmailInfo[0];
	$varMailDomain = $varEmailInfo[1];

	//$varLdapRet = authenticate_ldap($varEmailUser,$varPassword,$varMailDomain);

	$varLdapRet = '1';
    if ($varLdapRet == '1') {

		$varCondition	= " WHERE Email='".$varUsername."' AND Publish=1";
		//$varCondition	= " WHERE User_Name='".$varUsername."' AND Password='".md5($varPassword)."' AND Publish=1";
		$varCheckLogin	= $objSlaveDB->numOfRecords($varTable['ADMINLOGININFO'], 'User_Name', $varCondition);

		if ($varCheckLogin==1) {


			$varFields		= array('User_Name','User_Type','View_Counter','Phone_View','Photo_View','Horoscope_View','SendMail','BranchId');
			$varExecuteInfo		= $objSlaveDB->select($varTable['ADMINLOGININFO'], $varFields, $varCondition, 0);
			$varLoginInfo		= mysql_fetch_array($varExecuteInfo);
			$varUserType		= $varLoginInfo['User_Type'];
			$varUserName		= $varLoginInfo['User_Name'];
			$varViewCounter		= $varLoginInfo['View_Counter'];
			$varPhoneView		= $varLoginInfo['Phone_View'];
			$varPhotoView		= $varLoginInfo['Photo_View'];
			$varHoroscopeView	= $varLoginInfo['Horoscope_View'];
			$varSendMail		= $varLoginInfo['SendMail'];
			$varBranchId		= $varLoginInfo['BranchId'];

			//UPDATE LOGIN
			$varFields		= array('Last_Login');
			$varFieldsValue	= array("'".$varCurrentDate."'");
			$varCondition	= ' User_Name='."'".$varUsername."'";
			$objMasterDB->update($varTable['ADMINLOGININFO'], $varFields, $varFieldsValue, $varCondition);
			setcookie("adminLoginInfo","UserType=$varUserType&$varUserName", "0", "/",$confDomainName);

			//LOGIN PRIVILEGE
			$varAdminLoginPrivilege	= $varUserType.'^|'.$varUserName.'^|'.$varViewCounter.'^|'.$varPhoneView.'^|'.$varPhotoView.'^|'.$varHoroscopeView.'^|'.$varSendMail.'^|'.$varBranchId;
			setrawcookie("loginPrivilege","$varAdminLoginPrivilege", "0", "/",$confValues['DOMAINNAME']);

			//setcookie("adminUserName","$varUserName", "0", "/",$confDomainName);
			$varCookieInfo	= split("=",str_replace("&","=",$_COOKIE["adminLoginInfo"]));

			if($varUserName == 'nazir' || $varUserName == 'vijay.anand') {
			  $varRedirectFileName = 'manage-users';
			}
			else {
			    if ($varUserType=='3') {	$varRedirectFileName = 'view-profile'; }//if
			    else { $varRedirectFileName = 'admin-profile-valid'; }//else
            }

			$objMasterDB->dbClose();
			$objSlaveDB->dbClose();
			echo '<script language="javascript"> document.location.href = "index.php?act='.$varRedirectFileName.'";</script>';exit;
			//header("Location: index.php?act=".$varRedirectFileName);exit;

		} else { header("Location: index.php?act=login&varLogin=failed");}exit;
	}



}