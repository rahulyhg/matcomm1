<?php
#=============================================================================================================
# Author 		: S Anand, N Dhanapal, M Senthilnathan & S Rohini
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsDB.php");

if($varLoginSubmit == "yes") {

	//OBJECT DECLARTION
	$objDB	= new DB;

	//DB CONNECTION
	$objDB->dbConnect('M',$varDbInfo['DATABASE']);

	//VARIABLE DECLARATIONS
	$varCurrentDate		= date('Y-m-d H:i:s');
	$varUsername		= trim($_REQUEST["username"]);
	$varPassword		= trim($_REQUEST["password"]);

	//CONTROL STATEMENTS
	$varCondition		= " WHERE User_Name='".$varUsername."' AND Password=md5('".$varPassword."') AND Status=1";
	$varCheckUserName	= $objDB->numOfRecords($varTable['FRANCHISEE'],'Franchisee_Id',$varCondition);

	#Username && Franchisee_Id not available in DB (*ND 20060926)
	if ($varCheckUserName==1) {
		$varCondition		= " WHERE User_Name='".$varUsername."'";
		$varFields			= array('Franchisee_Id');
		$varExecute			= $objDB->select($varTable['FRANCHISEE'], $varFields, $varCondition, 0);
		$varSelectLoginInfo	= mysql_fetch_array($varExecute);
		$varFranchiseeId	= $varSelectLoginInfo["Franchisee_Id"];

		#ASSIGN Franchisee_Id to COOKIE
		setcookie("FranchiseeId","franchiseeId=$varFranchiseeId", "0", "/",$confValues['DOMAINNAME']);

		//REDIRECT PAGE
		echo "<script language=\"javascript\">document.location.href='index.php?act=my-page'</script>";exit;
	}//if
	
	//UNSET OBJECT
	$objDB->dbClose();
	unset($objDB);
}//if
?>