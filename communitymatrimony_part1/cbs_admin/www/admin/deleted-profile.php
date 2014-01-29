<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================
//FILE INCLUDES
$varRootBasePathh = '/home/product/community';
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsMailManager.php');
include_once($varRootBasePathh.'/lib/clsProfileDetail.php');
include_once($varRootBasePathh.'/conf/payment.cil14');


//OBJECT DECLARTION
$objSlave	= new MailManager;
$objProfileDetail	= new ProfileDetail;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objProfileDetail->dbConnect('S',$varDbInfo['DATABASE']);

$varCurrentDate = date('Y-m-d H:i:s');

function daysDifference($endDate, $beginDate)
{
$date_parts1=explode("-", $beginDate);
$date_parts2=explode("-", $endDate);
$start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
$end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
return $end_date - $start_date;
}



//CONTROL STATEMENT
//if ($_POST["frmViewFiltersSubmit"]=="yes")
//{
	$varUsername 				= $_GET["username"];
	$varPrimary					= $_GET["primary"];
	$varSelectFilter			= "yes";

	//IF USERNAME COMES GET MatriId
	if ($varPrimary=="User_Name")
	{
		//GET MatriId FROM Username
		$argCondition			= "WHERE User_Name=".$objSlave->doEscapeString($varUsername,$objSlave);
		$argFields 				= array('MatriId');
		$varSelectMatriIdRes	= $objSlave->select($varTable['MEMBERDELETEDINFO'],$argFields,$argCondition,0);
		$varSelectMatriId		= mysql_fetch_assoc($varSelectMatriIdRes);
		$varMatriId				= $varSelectMatriId["MatriId"];

	} else { $varMatriId		= $varUsername; }//

	$arrDomainDetails	= $objSlave->getDomainDetails($varMatriId);
	$varSiteName		= $arrDomainDetails['PRODUCTNAME'].'Matrimony';

	$argCondition				= "WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave);
	$varNoOfResults				= $objSlave->numOfRecords($varTable['MEMBERDELETEDINFO'],'MatriId',$argCondition);
	
	if ($varNoOfResults==0){ $varSelectFilter = "no"; }//if
	if ($varNoOfResults > 0) { $varSelectFilter		= "yes"; }//if

	if ($varSelectFilter=="yes")
	{
		$argFields 				= array('MatriId','Email','Password','Date_Created','Name','Age','Dob','Gender','Marital_Status','No_Of_Children','Children_Living_Status','Religion','Country','Resident_Status','Citizenship','Employed_In','Height','Height_Unit','Physical_Status','Education_Category','Education_Detail','Occupation','Occupation_Detail','Mother_Tongue','Residing_State','Residing_City','PhoneNo1','About_Myself','Profile_Created_By','Family_Value','Family_Type','Family_Status','Deleted_Reason','Deleted_Comments','Support_Comments','Date_Deleted','User_Name','Paid_Status','Valid_Days','Last_Payment','Number_Of_Payments','IPAddress','Publish','Special_Priv','Body_Type','Complexion','Blood_Group','CommunityId','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','GothramId','GothramText','Star','Raasi','Chevvai_Dosham','Eating_Habits','Smoke','Drink','Income_Currency','Annual_Income','Annual_Income_INR','Residing_Area','Residing_District','Phone_Verified','Family_Set_Status','Interest_Set_Status','Filter_Set_Status','Privacy_Setting','Mobile_Alerts_Available','Photo_Set_Status','Protect_Photo_Set_Status','Horoscope_Available','Horoscope_Protected','Birth_Deatils_Available','Horoscope_Match','Video_Set_Status','Video_Protected','Voice_Available','Reference_Set_Status','Partner_Set_Status','Match_Watch_Email','Last_Login','Date_Updated','Time_Posted','Profile_Referred_By','Weight','Weight_Unit','Appearance','Denomination','Contact_Phone','Contact_Mobile','Incomplete_Story_Flag');
		$varSelectFilterInfoRes	= $objSlave->select($varTable['MEMBERDELETEDINFO'],$argFields,$argCondition,0);
		$varSelectFilterInfo	= mysql_fetch_assoc($varSelectFilterInfoRes);
		$varPaidStatus			= $varSelectFilterInfo['Paid_Status'];
		$varValidDays			= $varSelectFilterInfo['Valid_Days'];
		$varNumberOfPayment	    = $varSelectFilterInfo['Number_Of_Payments'];
		$varPaidDate		    = $varSelectFilterInfo['Last_Payment'];
		
	}//if
	
	// GET HEIGHT AND WEIGHT
	$varAbsHeight = $varSelectFilterInfo['Height'];
	$arrHt = explode(".",$varAbsHeight);
	if($arrHt[1] == '00') {
		$varAbsHeight = str_replace(".00","",$varAbsHeight);
		$varHeight = $arrHeightFeetList[$arrParHeightList[$varAbsHeight]].' / '.round($varAbsHeight).' Cms';
	} else {
		if((trim($varAbsHeight)=='167.64') || (trim($varAbsHeight)=='167.74'))
		$varAbsHeight	= '167.74';
		$varHeight = $arrHeightFeetList[$varAbsHeight].' / '.round($varAbsHeight).' Cms';
	}

	$varAbsWeight = str_replace(".00","",$varSelectFilterInfo['Weight']);
	if($varAbsWeight==0) {
		$varWeight = ' - ';
	} else {
		if($varMemberInfo['Weight_Unit'] == 'lbs') {
			$varWeight = round(($varSelectFilterInfo['Weight'])/2.2).' Kgs / '.round($varSelectFilterInfo['Weight']).' lbs';
		} else {
			$varWeight = round($varSelectFilterInfo['Weight']).' Kgs / '.round($varSelectFilterInfo['Weight']*2.2).' lbs';
		}
	}

	//GET RESIDING STATE AND CITY MAPING
	if(($varSelectFilterInfo['Residing_State'] != '0' && $varSelectFilterInfo['Residing_State'] != '') || $varSelectFilterInfo['Residing_Area'] != '') {
		if ($varSelectFilterInfo['Country']==98)	{ $varResidingState = $arrResidingStateList[$varSelectFilterInfo['Residing_State']];} //if
		elseif ($varSelectFilterInfo['Country']==222){ $varResidingState = $arrUSAStateList[$varSelectFilterInfo['Residing_State']];}//elseif
		else {$varResidingState = $varSelectFilterInfo['Residing_Area'];}
	} else {
		$varResidingState = '-';
	}

	if($varSelectFilterInfo['Residing_City'] != '' || $varSelectFilterInfo['Residing_District'] != 0) {
		if ($varSelectFilterInfo['Country']==98) {
			$varResidingCity = ${$residingCityStateMappingList[$varSelectFilterInfo['Residing_State']]}[$varSelectFilterInfo['Residing_District']];
		} else {
			$varResidingCity = $varSelectFilterInfo['Residing_City'];
		}
	} else {
		$varResidingCity = '-';
	}

	// Membership Status
	if($varPaidStatus==1) {
		$varPaidDate		= $varPaidDate;
		//Calculate Valid days for Paid members
		$varLastPaidDate	= date('d-M-Y H:i:s',strtotime($varPaidDate));
		$varTodayDate		= date('m-d-Y');
		$varPaidDate		= date('m-d-Y',strtotime($varPaidDate));
		$varNumOfDays		= $objSlave->dateDiff("-",$varTodayDate,$varPaidDate);
		$varRemainingDays	= $varValidDays- $varNumOfDays;

		if($varRemainingDays <= 0) {
			$varRemainingDays = 0;
		}
		$varrCondition		= "WHERE MatriId=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Product_Id IN (1,2,3,4,5,6,7,8,9,48,56) ORDER BY Date_Paid DESC LIMIT 1";
		$argFields 			= array('MatriId','OrderId','Product_Id');
		$varPaymentRes		= $objProfileDetail->select($varDbInfo['DATABASE'].'.'.$varTable['PAYMENTHISTORYINFO'],$argFields,$varrCondition,0);
		$varPaymentInfo		= mysql_fetch_assoc($varPaymentRes);
		$varPackageName		= $arrPrdPackages[$varPaymentInfo['Product_Id']];
	}
//}//if
//$varSelectFilter
$objSlave->dbClose();
?>
<!-- <table border="0" cellpadding="0" cellspacing="0" align="left" width="543">
	<tr><td height="10" colspan="2"></td></tr>
	<tr><td valign="middle" class="heading" colspan="2" style="padding-left:15px;">View Deleted Profile</td></tr>
	<tr><td height="15" colspan="2"></td></tr>
	<?php if ($_POST["frmViewFiltersSubmit"]=="yes" && $varNoOfResults==0) { ?>
	<tr><td align="center" class="errorMsg" colspan="2">No Records found</td></tr><tr><td height="10" colspan="2"></td></tr>
	<?php }//if ?>
	<form name="frmViewFilters" target="_blank" method="post" onSubmit="return funViewProfileId();">
	<input type="hidden" name="frmViewFiltersSubmit" value="yes">
	<input type="hidden" name="MatriId" value="">	
		<td width="30%" class="smalltxt" style="padding-left:15px;"><b>Username / Matrimony Id</b></td>
		<td width="70%" class="smalltxt">
			<input type=text name="username" value="<?=$varUsername;?>" size="15" class="inputtext" value="">&nbsp;<input type="radio" name="primary" value="MatriId" <?=$varPrimary=="MatriId" ? "checked" : "";?>> Matrimony Id
			<input type="radio" name="primary" value="User_Name" <?=$varPrimary=="User_Name" ? "checked" : "";?>> Username&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" class="button">
		</td>
	</tr>
	<tr><td height="20" colspan="2"></td></tr>
	</form>
</table><br><br clear="all"> -->
<script>
	var varConfArr=new Array(); varConfArr['domainimgs']="<?=$confValues['IMGSURL']?>"; varConfArr['domainweb'] = "<?=$confValues['SERVERURL']?>";varConfArr['domainname'] = "<?=$confValues['DOMAINNAME']?>"; varConfArr['domainimage'] = "<?=$confValues['IMAGEURL']?>";varConfArr['webimgs']="<?=$confValues['PHOTOURL']?>"; varConfArr['domainimg'] = "<?=$confValues['IMGURL']?>"; varConfArr['productname'] = "<?=$confValues['PRODUCTNAME']?>";				
</script>
	<table width="543">
	<tr><td height="10" colspan="2"></td></tr>
	<tr><td class="heading" colspan="2" style="padding-left:5px;" align="center" >View Deleted Profile</td></tr>
	<tr><td height="10" colspan="2"></td></tr>
    </table><br>
<?php if ($varNoOfResults > 0 && $varSelectFilter=="yes" ) { ?>
<table border="0" class="formborder"  cellpadding="0" cellspacing="1" align="center" width="523">
	
	<tr height="25" class="adminformheader">
		<td class="mediumtxt boldtxt" colspan="2" style="padding-left:5px;">&nbsp;Profile Details</td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" width="20%" valign="top" style="padding-left:5px;">&nbsp;Sitename : </td>
		<td class="smalltxt" width="80%"><?=$varSiteName;?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" width="20%" valign="top" style="padding-left:5px;">&nbsp;Matrimony Id : </td>
		<td class="smalltxt" width="80%"><?=$varSelectFilterInfo['MatriId'];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Username : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo['User_Name'];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Gender : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo['Gender']==1 ? "Male" :"Female";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" valign="top" style="padding-left:5px;">&nbsp;Age : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Age"];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Name : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Name"];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" valign="top" style="padding-left:5px;">&nbsp;Country : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo['Country'] ? $arrCountryList[$varSelectFilterInfo['Country']] : "-";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Email : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Email"];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Date Created : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Date_Created"];?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Deleted Date : </td>
		<td class="smalltxt">		
		<?=$varSelectFilterInfo["Date_Deleted"] ? $varSelectFilterInfo["Date_Deleted"] : "-";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;No of days the profile has been deleted : </td>
		<td class="smalltxt">
		<?php echo daysDifference($varCurrentDate,$varSelectFilterInfo["Date_Deleted"]);?> Days
		</td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Deleted Reason : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Deleted_Reason"] ? $arrDeleteProfileReason[$varSelectFilterInfo["Deleted_Reason"]] : "-";?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smalltxt" style="padding-left:5px;">&nbsp;Comments : </td>
		<td class="smalltxt"><?=$varSelectFilterInfo["Deleted_Comments"] ? $varSelectFilterInfo["Deleted_Comments"] : "-";?></td>
	</tr>
	<tr><td height="7" colspan="2"></td></tr>
</table><br>


<!--payment details starts here -->		
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" WIDTH="523">
			<tr class="adminformheader">
				<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">Payment Details</td>
			</tr>
			
			
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Payment Details  :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?= $varPaidStatus==0?'Free Member':'Paid Member'; ?> ----To View Before Record <a 
				onclick="javascript:funPaymentProfile('<?=$varMatriId?>')" ><b>Click Here</b></a></td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>			
		</table><br>
			<!--Payment details ends here -->

		<!--Profile password details starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" WIDTH="523">
			<tr class="adminformheader">
				<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">Profile Password Details</td>
			</tr>
			<? if ($sessUserType=='2') { ?>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Login Password:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=$varSelectFilterInfo['Password']?>
				</td>
			</tr>
			<? } ?>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Photo Protected:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=($varProtectPhotoSetStatus['Protect_Photo_Set_Status']==1) ? 'Yes' : 'No';?></td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Horoscope Protected:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=($varProtectHoroSetStatus==1) ? 'Yes' : 'No';?></td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
		</table><br>
		<!--Profile password details ends here -->

		<!-- About myself Information starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" WIDTH="523">
			<tr class="adminformheader"><td valign="top" style="padding-left:5px;padding-right:5px;padding-top:5px;padding-bottom:5px;text-align:justify;">About myself</td></tr>
			<tr bgcolor="#FFFFFF">
			   <td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">
					<?=$varSelectFilterInfo['About_Myself'] ? str_replace("''","'",$varSelectFilterInfo['About_Myself']) : "-";?>
			   </td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
		</table><br>
		<!-- About myself Information ends here -->

		<!-- My Appearance starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" WIDTH="523">
			<tr class="adminformheader">
				<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">My Appearance</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Complexion:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=$varSelectFilterInfo['Complexion']!="0" ? $arrComplexionList[$varSelectFilterInfo['Complexion']] : "-";?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Physical status:</td>
				<td valign="top" width="200" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=$varSelectFilterInfo['Physical_Status'] ? $arrPhysicalStatusList[$varSelectFilterInfo['Physical_Status']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Height :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?= $varSelectFilterInfo['Height']!='0.00'?$varHeight:'-'; ?></td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Weight :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varSelectFilterInfo['Weight']!='0.00' ? $varWeight : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Body type :</span></td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varSelectFilterInfo['Body_Type']!="0" ? $arrBodyTypeList[$varSelectFilterInfo['Body_Type']] : "-";?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Blood group :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=($varSelectFilterInfo['Blood_Group']!="0")? $arrBloodGroupList[$varSelectFilterInfo['Blood_Group']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
		</table><br>
		<!-- My Appearance ends here -->

		<!-- My LifeStyle starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" WIDTH="523">
			<tr class="adminformheader"><td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">My LifeStyle </td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Education :</td>
				<td valign="top" class="smalltxt" width="25%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=($varSelectFilterInfo['Education_Category']!=0)?$arrEducationList[$varSelectFilterInfo['Education_Category']]:$arrGroupEducationList[$varSelectFilterInfo['Education_Category']];?>
				</td>
				<td valign="top" width="25%" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Education in detail :</td>
				<td valign="top" class="smalltxt" width="25%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?
					if($varSelectFilterInfo['Education_Detail']!='')
						echo wordwrap($varSelectFilterInfo['Education_Detail'], 20, "<br>");
					else
					 echo "-";
				?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Employed in :</td>
				<td valign="top" class="smalltxt"  style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varSelectFilterInfo['Employed_In'] ? $arrEmployedInList[$varSelectFilterInfo['Employed_In']] : "-";?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Occupation :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=($varSelectFilterInfo['Occupation']!="0" && $varSelectFilterInfo['Occupation']!="60")? ltrim($arrOccupationList[$varSelectFilterInfo['Occupation']],'&nbsp;&nbsp;') : "Not specified";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Occupation in detail :</td>
				<td valign="top" class="smalltxt"  style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?
					if($varSelectFilterInfo['Occupation_Detail']!='')
						echo wordwrap($varSelectFilterInfo['Occupation_Detail'], 20, "<br>");
					else
					 echo "-";
				?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Annual income :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varSelectFilterInfo['Annual_Income'] !="0.00" ? $arrSelectCurrencyList[$varSelectFilterInfo['Income_Currency']].' '.$varSelectFilterInfo['Annual_Income'] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Eating habits :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varSelectFilterInfo['Eating_Habits'] ? $arrEatingHabitsList[$varSelectFilterInfo['Eating_Habits']] : "-";?>
				</td>
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Drinking habits:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varSelectFilterInfo['Drink'] ? $arrDrinkListList[$varSelectFilterInfo['Drink']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt boldtxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Smoking habits :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
					<?=$varSelectFilterInfo['Smoke'] ? $arrSmokeListList[$varSelectFilterInfo['Smoke']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
		</table><br>
		<!-- My LifeStyle ends here -->

		<!-- Home Truths starts here -->
		<table border="0" cellpadding="0" cellspacing="0" class="formborder" align="center" WIDTH="523">
			<tr class="adminformheader"><td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">Home Truths </td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" width="25%" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Family values :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
				<?=$arrFamilyValuesList[$varSelectFilterInfo['Family_Value']]? $arrFamilyValuesList[$varSelectFilterInfo['Family_Value']] : "-";?></td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Native language :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=($varSelectFilterInfo['Mother_TongueId']!="0")? $arrMotherTongueList[$varSelectFilterInfo['Mother_Tongue']] : "-";?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Residing state :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varResidingState; ?>
				</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Residing city / district :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varResidingCity; ?>
				</td>
			</tr>
			<tr>
				<td class="viewinfsepline" colspan="4"><img src="<?=$confValues['IMGSURL']?>/trans.gif" WIDTH="523" height="1"></td>
			</tr>
		</table><br>
		<table align="center">
		<tr>
           <td align="center"><a href="index.php?act=profile" class="grtxt"><b><font class="smalltxt boldtxt" color="red">View other Profiles</font></b></a>&nbsp;</td>
		</tr>
		</table>
		<br>
		<!--Home Truths ends here-->

<?php }//if
      else { //else
		echo '<br><table width="532" border="0" cellspacing="0" cellpadding="0" align="center" class="viewpgborderclr" valign="top"><tr><td class="errorMsg" height="40" valign="middle" align="center">No members match with your selected criteria. <a href="index.php?act=profile" class="formlink"><b>Click here to try again</b></a></td></tr><tr><td height="10"></td></tr><tr><td></td></tr></table>';
	}

?>	
<?php 

//UNSET OBJECT
unset($objCommon);
?>

<script language="javascript">
function funViewProfileId()
{
	var frmName = document.frmViewFilters;
	if (frmName.username.value=="")
	{
		alert("Please enter  Username / Matrimony Id");
		frmName.username.focus();
		return false;
	}//if

	if (!(frmName.primary[0].checked==true || frmName.primary[1].checked==true))
	{
		alert("Please select Username / Matrimony Id");
		frmName.primary[0].focus();
		return false;
	}//if

	return true;
}//funViewProfileId

function funPaymentProfile(argMatrId) {
	//img_url+"/photo/viewphoto.php?ID="+matid+"&PNO="+ph_no;
	//admin/index.php?act=paymenthistory&username=BRH102122&tvprofile=yes
	var funPaymentUrl = varConfArr['domainweb']+"/admin/index.php?act=paymenthistory&username="+ argMatrId+"&tvprofile=yes";
	window.open(funPaymentUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,status=no,scrollbars=yes,titlebar=no;");
}
</script>

