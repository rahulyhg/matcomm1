<?php
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$varSrchId		= $_POST['srchId'];

if($sessMatriId!='' && is_numeric($varSrchId)){
	//OBJECT DECLARTION
	$objDB	= new DB;

	$objDB->dbConnect('M', $varDbInfo['DATABASE']);

	//$varWhereCond	= 'Search_Id='.$varSrchId." AND MatriId='".$sessMatriId."'";
	$varWhereCond	= 'Search_Id='.$objDB->doEscapeString($varSrchId,$objDB)." AND MatriId=".$objDB->doEscapeString($sessMatriId,$objDB);
	$varDeletedRows	= $objDB->delete($varTable['SEARCHSAVEDINFO'], $varWhereCond);
	if($varDeletedRows==1){
		//$varWhereCond	= " WHERE MatriId='".$sessMatriId."' ORDER BY Date_Updated DESC";
		$varWhereCond	= " WHERE MatriId=".$objDB->doEscapeString($sessMatriId,$objDB)." ORDER BY Date_Updated DESC";
		$varFields		= array('Search_Id', 'Search_Name', 'Search_Type');
		$varResInfo		= $objDB->select($varTable['SEARCHSAVEDINFO'], $varFields, $varWhereCond, 0);
		$varNoOfRows	= mysql_num_rows($varResInfo);
		$varSavedSearchInfo	= '';
		if($varNoOfRows > 0){
			while($row=mysql_fetch_assoc($varResInfo)){
				$varSavedSearchInfo	.= $row['Search_Id'].'|'.$row['Search_Type'].'|'.$row['Search_Name'].'~';
			}//for
			$varSavedSearchInfo = trim($varSavedSearchInfo,'~');
		}
		setcookie("savedSearchInfo","$varSavedSearchInfo", "0", "/",$confValues['DOMAINNAME']);
		$varMsg = 'Saved search has been successfully deleted.';
	}else{
		$varMsg = 'Given saved search is currently not available.';
	}
}else{
	if($sessMatriId == '')
		$varMsg = 'Your session has expired or you have logged out. <br>Please <a href="'.$confValues['SERVERURL'].'/login/"  class="clr1">Click here</a> to login again.';
	else
		$varMsg = 'Given saved search is currently not available.';
}
print $varMsg;
?>