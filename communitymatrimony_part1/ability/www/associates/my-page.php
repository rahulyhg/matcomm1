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
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath."/lib/clsCommon.php");

//CHECK ALREADY LOGGED USER
if($varFranchiseeId =='')
{ echo '<script language="javascript">document.location.href="index.php?act=associates-login"</script>'; exit; }//if

//OBJECT DECLARATION
$objDB	= new DB;

$objCommon = new clsCommon;

//DB CONNECTION
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLLE DECLARATIONS
$varFields			= array('Name','Email','Country');
$varCondition		= " WHERE Franchisee_Id=".$varFranchiseeId;
$varExecute			= $objDB->select($varTable['FRANCHISEE'], $varFields, $varCondition, 0);
$varFranchiseeInfo	= mysql_fetch_array($varExecute);
$varName			= $varFranchiseeInfo["Name"];
$varCountry			= $varFranchiseeInfo["Country"];

$objDB->dbClose();
unset($objDB);
?>


<table bgcolor=#FFFFFF border="0" cellspacing="0" cellpadding="2" width="600">
	<tr><td style="font: bold 18px Arial;" class="clr3 brdr pad10">Hi <?=$varName;?>, Welcome to the Associates Section !!!</td></tr>
	<tr><td height="10"></td></tr>
	<tr><td class="smalltxt"><a href="index.php?act=upgrade-profile" class="clr1"><u>Upgrade Profile</u></a>&nbsp;&nbsp;-&nbsp;&nbsp;You can introduce a new profile or upgrade an existing one.<br><br><a href="index.php?act=paymenthistory" class="clr1"><u>Check Your Balance</u></a>&nbsp;&nbsp;-&nbsp;&nbsp;Keep track of your credit balance and payment history for future reference.<br><br><a href="index.php?act=payment-associates" class="clr1"><u>Pay Online</u></a>&nbsp;&nbsp;-&nbsp;&nbsp;You can now make payments online with your credit card.<br><br><font class="bld">Your Upgraded Profiles :</font><br><br>To see a list of profiles you have upgraded, select the dates you require (from and to) and click on Get Profiles.<br><br>

		<form method="post" name="frmAffiliate" onSubmit="return funValidate('frmAffiliate');" style="padding:0px;margin:0px;">
		<input type="hidden" name="act" value="search-results">
		<input type="hidden" name="frmAffiliateSubmit" value="yes">
		<b>From : </b><select name="day1" size=1 id="req_select-one_from date" class="inputtext">
				<option value="0">Date</option>
				<?=$objCommon->dateDropdown();?>
			</select>&nbsp;&nbsp;
				<select name="mon1" size=1 id="req_select-one_from month" class="inputtext">
				<option value="0">Month</option>
<?=$objCommon->monthDropdown($varMonth)?>
</select>&nbsp;&nbsp;
			<select name="year1" size=1 id="req_select-one_from year" class="inputtext">
				<option value="0">Year</option><?=$objCommon->getYears('N');?>
			</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<b>To : </b><select name="day2" size=1 id="req_select-one_to date" class="inputtext">
				<option value="">Date</option>
				<?=$objCommon->dateDropdown();?>
			</select>&nbsp;&nbsp;

			<select name="mon2" size=1 id="req_select-one_to month" class="inputtext">
				<option value="0">Month</option>	
<?=$objCommon->monthDropdown($varMonth)?>
</select>&nbsp;&nbsp;

			<select name="year2" size=1 id="req_select-one_to year" class="inputtext">
				 <option value="0">Year</option><?=$objCommon->getYears('N');?>
			</select><br><br><br>

			<center>
				<input type="submit" class="button" value="Get Profiles">&nbsp; &nbsp;
				<input type="reset" class="button" value="Clear">
			</center>
			</form>
		</td>
	</tr>
</table>
