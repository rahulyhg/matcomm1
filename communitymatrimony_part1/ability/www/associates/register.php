<?php
#================================================================================================================
# Author 		: S Anand, N. Dhanapal, M Senthilnathan & S Rohini
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: Search - Whos Online
#================================================================================================================
//CHECK ALREADY LOGGED USER

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/emailsconfig.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsMailManager.php");

if($varFranchiseeId !='')
{ echo '<script language="javascript">document.location.href="index.php?act=my-page"</script>'; exit; }//if

//OBJECT DECLARATION
$objDB	= new MailManager;

//DB CONNECTION
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLLE DECLARATIONS
$varCurrentDate		= date('Y-m-d H:i:s');
$varCheckUsename	= '';

//DELETE SAVED SEARCH
if ($_REQUEST["frmAffiliatesSubmit"]=="yes") {

	//VARIABLLE DECLARATIONS
	$varUsername	= $_REQUEST["username"];
	$varPassword	= trim($_REQUEST["password"]);
	$varName		= $_REQUEST["name"];
	$varEmail		= trim($_REQUEST["email"]);
	$varCountry		= $_REQUEST["country"];
	$varState		= $_REQUEST["state"];
	$varCity		= $_REQUEST["city"];
	$varAddress		= $_REQUEST["address"];
	$varPhoneNumber	= $_REQUEST["phoneNumber"];
	$varMobileNumber= $_REQUEST["mobileNumber"];
	$varFaxNumber	= $_REQUEST["faxNumber"];
	$varZipCode		= $_REQUEST["zipCode"];
	$varResults		= 'no';
	
	$varCondition		= " WHERE User_Name='".$varUsername."'";
	$varCheckAffiliates	= $objDB->numOfRecords($varTable['FRANCHISEE'],'Franchisee_Id',$varCondition);

	if ($varCheckAffiliates=='0')	{

		$varFields		= array('User_Name','Password','Name','Email','Country','Residing_State','Residing_City','Contact_Address','ZipCode','Contact_Phone','Contact_Mobile','Fax','Date_Created');
		$varFieldsValue	= array("'".$varUsername."'","'".md5($varPassword)."'","'".$varName."'","'".$varEmail."'","'".$varCountry."'","'".$varState."'","'".$varCity."'","'".$varAddress."'","'".$varZipCode."'","'".$varPhoneNumber."'","'".$varMobileNumber."'","'".$varFaxNumber."'","'".$varCurrentDate."'");
		$objDB->insert($varTable['FRANCHISEE'], $varFields, $varFieldsValue);

		$varSubject				= "Congrats! You are now a Payment Associate.";
		$funMessage = '';
		$funMessage	.= 'Dear Associate Member,<br><br>';
		$funMessage	.= 'Congratulations on becoming an associate of '.$confValues["PRODUCTNAME"].'.com! As an associate, you have chosen a wonderful business proposition that will only show you profits on your investment. Begin today by upgrading profiles and enjoy your commission.<br><br>';
		$funMessage	.= 'Your account will be activated within 24 hours of receiving this E-mail so please login then with the Username and Password given below:<br><br>';
		$funMessage	.= '<b>Username:</b> '.$varUsername.'<br>';
		$funMessage	.= '<b>Password:</b> '.$varPassword;
		$funMessage	.= '<br><br>With 13 countries to choose from, you now have the opportunity to expand your business on a global scale. Welcome to the '.$confValues["PRODUCTNAME"].' family.<br><br>';
		$funMessage	.= 'Regards,<br>';
		$funMessage	.= 'Team '.$confValues["PRODUCTNAME"].'.Com';
		$objDB->sendEmail($arrEmailsList['FROMMAIL'],$arrEmailsList['INFOEMAIL'],$varName,$varEmail,$varSubject,$funMessage,$funReplyToEmail);


		$varResults = 'yes';

	} else { $varResults = 'exist';}
		 
}//if
$objDB->dbClose();
unset($objDB);
?>
<!-- Search Table Starts Here -->
<div class="normtxt bld padtb10">Payment Associates</div>
<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
	<table border="0" cellpadding="0" cellspacing="0" width="690">
		<tr><td height="5"></td></tr>
	<? if ($varResults=="exist") { ?>
		<tr><td align='left' class='smalltxt' colspan="2">&nbsp;Sorry! <font class='smalltxt'><b><?=$varUsername;?></b></font> is not available. Try another Username. <a href="index.php" class="smalltxt1 clr1" style="cursor: pointer;">Click here</a></td></tr>
		<tr><td><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="5"></td></tr>
	<? } else { ?>
		<tr><td class="smalltxt"><div style="padding-left:3px;padding-top:5px;padding-bottom:5px;"><b>We thank you for commitment to us. Your profile has been registered successfully and will be activated within 24 hours!.</b></div></td></td>
	<? }//if?>
	</table>