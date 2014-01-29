<?
#====================================================================================================
# File			: index.php
# Author		: Dhanapal N
# Date			: 15-July-2008
# Module		: CommunityMatrimony Login
#********************************************************************************************************/

//BASE ROOT
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//OBJECT DECLARTION
$objCBSLogin	= new DB;

//DB CONNECTION
$objCBSLogin->dbConnect('S',$varDbInfo['DATABASE']);

$varCBSDomainName	= '';
$varCheckLogin		= '0';
$varMatriId			= strtoupper(strtolower(trim($_POST["idEmail"])));
$varMatriIdPrefix	= substr($varMatriId,0,3);
$varCBSDomainName	= $arrPrefixDomainList[$varMatriIdPrefix];
$varUsername		= addslashes(trim($_POST["idEmail"]));
$varPassword		= addslashes(trim($_POST["password"]));
$varAct				= 'login';
$varErrorMessage	= 'Invalid Matrimony ID OR Incorrect Password';

if ($varCBSDomainName !='') {
	
	$varCondition	= " WHERE MatriId=".$objCBSLogin->doEscapeString($varUsername,$objCBSLogin)." AND Password=".$objCBSLogin->doEscapeString($varPassword,$objCBSLogin);
	$varCheckLogin	= $objCBSLogin->numOfRecords($varTable['MEMBERLOGININFO'], 'MatriId', $varCondition);

	if ($varCheckLogin=='1') {
		$varCBSRedirect		= 'http://www.'.$varCBSDomainName.'/login/';
		unset($_POST["act"]);
?>
	<form name="frmCBSLogin" method="post" action="<?=$varCBSRedirect?>">
		<input type="hidden" name="act" value="logincheck">
		<? foreach ($_POST as $varKey => $varValue) { ?>
		<input type="hidden" name="<?=$varKey?>" value="<?=$varValue?>">
		<? } ?>
	</form>
	<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" border="0" />
	<script>document.frmCBSLogin.submit();</script>
<?
	}
}

$objCBSLogin->dbClose();
UNSET($objCBSLogin);
?>