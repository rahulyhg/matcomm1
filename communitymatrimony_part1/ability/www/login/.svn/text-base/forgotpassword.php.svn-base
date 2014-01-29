<?php
#=============================================================================================================
# Author 		: A.Baskaran
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath.'/lib/clsMailManager.php');?>
<?
if ($_REQUEST["frmForgotPasswordSubmit"]=="yes" ) {
	//OBJECT DECLARTION
	$objMailManager		  = new MailManager;
	$objSlaveDB			  = new DB;
	$objMasterDB		  = new DB;
	//CONNECTION DECLARATION
	$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
	$varMasterConn		= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

	//VARIABLE DECLARATIONS
	$varUsername	= trim($_REQUEST['UNAME']);
	$varUsername	= $varUsername ? $varUsername : $_REQUEST["fp_idEmail"];

	if ($varUsername=='ID / E-mail') { $varUsername = ''; }
	
	if($varUsername!='') {
		if (strpos($varUsername, '@')) { $varPrimary = 'Email'; } else { $varPrimary = 'MatriId'; }//else
	}

	if ($varUsername!='') {
	
		$varCondition		= " WHERE ".$varWhereClause." AND ".$objSlaveDB->doEscapeString($varPrimary,$objSlaveDB)."  =".$objSlaveDB->doEscapeString($varUsername,$objSlaveDB);
		$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], $argPrimary='Email', $varCondition);
		$varMultiUser		= ($_REQUEST['MULTIUSER'] == 1)? 1: 0;

		if ($varPrimary == 'Email' && $varTotRecords > 1 && trim($varMultiUser) == 0){
			print "<script>window.location.href='".$confValues['SERVERURL'].'/login/index.php?act=forgetpwdhshow&EMAIL='.$varUsername."'; </script>";
			exit;
		}
	}

	if ($varUsername=='') {
		$varFormResult = 'Please enter matrimony id / e-mail. <a href="'.$confValues['SERVERURL'].'/login/" class="clr1 smalltxt">Click here</a>';





	} else if ($varTotRecords == 0) {
		$varFormResult = "This MatriId is not available.";
	}//if
	elseif ($varTotRecords > 0)
	{
		$varFields			= array('MatriId','Password','Email');
		$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
		$varSelectLoginInfo	= mysql_fetch_assoc($varResult);
		$varEmail			=  $varSelectLoginInfo["Email"];
		$varUsername		=  $varSelectLoginInfo["MatriId"];
		$varPassword		=  $varSelectLoginInfo["Password"];
		$varPaidStatus		= 0;
		//Gernerating Random Values Starts Here
		 $varSendMail		= $objMailManager->sendForgotPasswordMail($varUsername,$varPassword,$varEmail);

		if ($varSendMail=="yes")
			$varFormResult='MatriId and password has been sent to your e-mail ID. <a href="'.$confValues['SERVERURL'].'/login/" class="clr1 smalltxt">Click here</a>'; 
		else
			$varFormResult='Sorry! Mail Sent Failed. <a href="'.$confValues['SERVERURL'].'/login/" class="clr1 smalltxt">Click here</a>'; 
	}//else	
	echo '<div style="padding: 10px 5px 0px 5px;width:380px;height:80px;"><font class="mediumtxt">'.$varFormResult.'</font></div>';
}//if
//UNSET OBJECT
unset($objMailManager);
?>