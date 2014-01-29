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
$varMatriId			= trim($_POST["idEmail"]);
$varMatriIdPrefix	= substr($varMatriId,0,3);
$varCBSDomainName	= $arrPrefixDomainList[$varMatriIdPrefix];
$varUsername		= trim($_POST["idEmail"]);
$varPassword		= trim($_POST["password"]);
$varAct				= 'login';
$varErrorMessage	= 'Invalid Matrimony ID OR Incorrect Password';

if(empty($_POST) && !empty($_REQUEST)){
$varMatriId			= trim($_REQUEST["idEmail"]);
$varMatriIdPrefix	= substr($varMatriId,0,3);
$varCBSDomainName	= $arrPrefixDomainList[$varMatriIdPrefix];
$varUsername		= trim($_REQUEST["idEmail"]);
$varPassword		= trim($_REQUEST["password"]);
$_REQUEST['frmLoginSubmit']='yes';
//setcookie("rmusername", $_REQUEST['RMIUID'], time()+3600);
setrawcookie("rmusername",$_REQUEST['RMIUID'], "0", "/",".".$varCBSDomainName);
$goto=$_REQUEST['GOTO1'];
$goto=explode('?',$goto);
$page=$goto[0];
if($page=='privilege/search/search.php'){
$_REQUEST['redirect']='http://www.'.$varCBSDomainName.'/search/search.php?';
}else{
$_REQUEST['redirect']='';
}
$_REQUEST['chooseLogin']='';
$_REQUEST['countryCode']='';


}

if ($varCBSDomainName !='') {
	
	$varCondition	= " WHERE MatriId=".$objCBSLogin->doEscapeString($varUsername,$objCBSLogin)." AND Password=".$objCBSLogin->doEscapeString($varPassword,$objCBSLogin);
	$varCheckLogin	= $objCBSLogin->numOfRecords($varTable['MEMBERLOGININFO'], 'MatriId', $varCondition);

	if ($varCheckLogin=='1') {
		/*if($page=='privilege/search/search.php'){
		$varCBSRedirect		= 'http://www.'.$varCBSDomainName.'/search/index.php?rmuser=1';
		}else{*/
        $varCBSRedirect		= 'http://www.'.$varCBSDomainName.'/login/rmlogincheck.php';
		//}
		unset($_POST["act"]);
?>
	<form name="frmCBSLogin" method="post" action="<?=$varCBSRedirect?>">
		
		<?  if(empty($_POST) && !empty($_REQUEST)){
	     foreach ($_REQUEST as $varKey => $varValue) { ?>
		<input type="hidden" name="<?=$varKey?>" value="<?=$varValue?>">
		<? }
		 }else{

		 foreach ($_POST as $varKey => $varValue) { ?>
		<input type="hidden" name="<?=$varKey?>" value="<?=$varValue?>">
		<? }  } ?>
	</form>
	<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" border="0" />
	<script>
		function TestTestTest1()
			{

			document.frmCBSLogin.submit();

		 }

		 TestTestTest1();

	

			 
		 </script>
<?
	}
}

$objCBSLogin->dbClose();
UNSET($objCBSLogin);
?>