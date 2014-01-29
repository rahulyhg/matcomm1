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
$varMatriId			= trim($_REQUEST['UNAME']);
$varMatriId			= $varMatriId ? $varMatriId : $_REQUEST["fp_idEmail"];
$varMatriIdPrefix	= substr($varMatriId,0,3);
$varCBSDomainName	= $arrPrefixDomainList[$varMatriIdPrefix];
$varFormResult		= ' This MatriId is not available. <a href="/login/index.php" class="clr1">Click here</a> to try again.';

if ($varCBSDomainName !='') {
	
	$varCondition	= " WHERE MatriId=".$objCBSLogin->doEscapeString($varMatriId,$objCBSLogin);
	$varCheckLogin	= $objCBSLogin->numOfRecords($varTable['MEMBERLOGININFO'], 'MatriId', $varCondition);

	if ($varCheckLogin=='1') {
		$varCBSRedirect		= 'http://www.'.$varCBSDomainName.'/login/index.php?act=forgotpassword';
		$varFormResult		= '';
?>
	<form name="frmCBSForgotPassword" method="post" action="<?=$varCBSRedirect?>">
		<? foreach ($_POST as $varKey => $varValue) { ?>
		<input type="hidden" name="<?=$varKey?>" value="<?=$varValue?>">
		<? } ?>
	</form>
	<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" border="0" />
	<script>document.frmCBSForgotPassword.submit();</script>
<?
	}
}
echo $varFormResult;
$objCBSLogin->dbClose();
UNSET($objCBSLogin);
?>