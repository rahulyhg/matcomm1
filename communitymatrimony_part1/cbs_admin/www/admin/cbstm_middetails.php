<?php
############### It show past history of followup information ##################################3
#ini_set('display_errors','on');
#error_reporting(E_ALL ^ E_NOTICE);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
//OBJECT DECLARTION
$objSlave	= new DB;
//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE>TM-Searchby MatriId </TITLE>
  <SCRIPT LANGUAGE="JavaScript">
function  validation()
{
  if(document.searchbyid.matrid.value =='')
  {
	document.searchbyid.matrid.focus();
	alert ("Please Enter the MatriId");
	return false;
  }
  else
	  return true;
}

  </SCRIPT>
 </HEAD>
<FORM METHOD=POST Name="searchbyid" ACTION="" onsubmit="return validation();">
 <BODY>
 <title>Search By Matri-Id</title>
  <center>
  <br/>
  
	<table width="525" cellspacing="0" cellpadding="0" border="0" align="center" class="formborder">
		<tr><td class="adminformheader" colspan="3" style="padding-left:15px;_padding-left:15px;">Follow Up</td>
		</tr>
		
		<tr><td  style="width:10; height:50px;">
		<font class='mediumtxt'>&nbsp;&nbsp;&nbsp;&nbsp;<b>Search By Matrid :</b></font>
		<INPUT TYPE="text" NAME="matrid" size=35 >
		<INPUT TYPE="submit" name="submit" value="submit" class="button submit">
		</SELECT>
		</td></tr>
	</table>
  <table border=0 cellpadding=1 cellspacing=2 width='540'>
	
	<tr><td>
	<?if(isset($_POST[submit])){
	$db = 'cbssupportiface'; // support DB
	$matrid= $_POST[matrid];
	$matr_id = explode(" ",$matrid);
	$val=count($matr_id);
		if($val == 1)
		{
		echo "<br><br>"; 
			if($db =='cbssupportiface')
			{
			$argCondition				=" WHERE matriid=".$objSlave->doEscapeString($matrid,$objSlave);
			$PaymentOptionTableName=$varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONS'];
			$PaymentOptionFollowupTableName=$varPaymentAssistanceDbInfo['DATABASE'].".".$varTable['PAYMENTOPTIONSFOLLOWUPDETAILS'];
			$varUpdatedNoOfRecords		= $objSlave->numOfRecords($PaymentOptionFollowupTableName,'MatriId',$argCondition);

				if($varUpdatedNoOfRecords==0){
					echo "<center>The given $matrid  matrid is not found</center>";
				}
				else{
					//$varFields4		= array('Product_Id','Comments','Date_Paid');
					$varFields4		= array('Last_Payment','Valid_Days','Expiry_Date','Support_Comments');
					$varCondition4	= " where MatriId=".$objSlave->doEscapeString($matrid,$objSlave);
					$varTableName	= $varDbInfo['DATABASE'].'.'.$varTable['MEMBERINFO'];
					$varExecute4	= $objSlave->select($varTableName,$varFields4, $varCondition4,0);
					$varResults4	= mysql_fetch_assoc($varExecute4);
				
					$lastPaymentDate=$varResults4['Last_Payment'];
					$validdays=$varResults4['Valid_Days'];
					$expdate=$varResults4['Expiry_Date'];
					$sepLastPayDate=explode(' ',$lastPaymentDate);
					$sepExpDate=explode(' ',$expdate);
					$supportcmds=$varResults4['Support_Comments'];
					$validdays=$varResults4['Valid_Days'];						
					?>		
								<table border=0 cellpadding=0 cellspacing=1 width=70% bgcolor=#898D72 align=center>
								<tr><td height=18>&nbsp;&nbsp;<font color=white face=arial size=2><b>Payment Information</td></tr>
								<tr><td>
								<table border=0 cellpadding=0 cellspacing=0 width=100% bgcolor=white>
								<tr><td colspan=2>
								<table border=0 cellpadding=0 cellspacing=0 width=100% align=center>
								<tr height=18><td class="adminformheader">MatriId</td><td class="adminformheader"><?=$matrid?></td></tr>
							 	<?if($lastPaymentDate!='' and $lastPaymentDate!='0000-00-00 00:00:00'){ ?>
								<tr height=18><td class="adminformheader">Last Payment</td><td class="adminformheader"><?=$sepLastPayDate[0]?></td></tr>
								<?}if($expdate!='' and $expdate!='0000-00-00 00:00:00'){ ?>
								<tr height=18><td class="adminformheader">Expiry Date</td><td class="adminformheader"><?=$sepExpDate[0]?></td></tr> <?}?>
								<?if($validdays!=''){?>
								<tr height=18><td class="adminformheader">Valid Days</td><td class="adminformheader"><?=$validdays?></td></tr>
								<?}?>
								<!-- <tr height=18><td class="adminformheader">Date Called</td><td class="adminformheader"><?=$sepDateUpdated[0]?></td></tr> -->
								</table>
								</td></tr></table>
								</td></tr></table><br><br>
								<table border=0 cellpadding=0 cellspacing=1 width=95% bgcolor=#898D72 align=center>
								<tr align='center' ><td height=18>&nbsp;&nbsp;<font color=white face=arial size=2><b>Follow Up Details</b></td></tr>
								<tr><td>
								<table border=0 cellpadding=0 cellspacing=0 width=100% bgcolor=white>
								<?php
								$j=1;
								$varFields3=array('SupportUserId','SupportUserName','FollowupStatus','FollowupDate','DateUpdated','LeadSource');
								$varCondition3=" where MatriId=".$objSlave->doEscapeString($matrid,$objSlave)." order by DateUpdated desc ";
								$varExecute3= $objSlave->select($PaymentOptionFollowupTableName,$varFields3, $varCondition3,0);
								?>
							
								<table border=0 cellpadding=0 cellspacing=4 width=100% align=center>
								<tr align='center'>
								<td class="adminformheader" >No</td>
								<td class="adminformheader">SupportUserName</td>
								<td class="adminformheader">FollowupStatus</td>
								<td class="adminformheader">Last Called Date</td>
								<td class="adminformheader">Next FollowUpDate</td>
								<td class="adminformheader">Lead Source</td>
								</tr>
								<?while($varResults3	= mysql_fetch_array($varExecute3)){ 

									$sepDateUpdated=explode(' ',$varResults3[DateUpdated]);
									$sepFollowupDate=explode(' ',$varResults3[FollowupDate]);

								?>
								<tr align=center bgcolor='white'>
								<td class="smalltxt" ><?=$j?></td>
								<td class="smalltxt"><?=$varResults3[SupportUserName];?></td>
								<td class="smalltxt"><?=$paymentoption_followup_status[$varResults3[FollowupStatus]];?></td>
								<td class="smalltxt"><?=$sepDateUpdated[0];?></td>
								<td class="smalltxt"><?=$sepFollowupDate[0];?></td>
								<td class="smalltxt"><?=$leadsource[$varResults3[LeadSource]];?></td>
								</tr>
								<? $j++; }?>
								</td></tr>
								</table><br>
								</table>

				<?	 }
			
			}//cbssupportiface closed
		
		}//$val closed

	}
	 $objSlave->dbClose();
	?>
	</td></tr>
	</table>

  </center>
 </BODY>
 </FORM>
</HTML>
