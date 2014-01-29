<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================

//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';

//FILE INCLUDES
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath.'/conf/emailsconfig.cil14');
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/conf/basefunctions.cil14');
include_once($varRootBasePath."/www/admin/includes/config.php");
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsPhoneSupport.php');


//OBJECT DECLARTION
$objMaster		= new MemcacheDB;
$objSlave		= new PhoneSupport;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLERATION
$varMatriId				= $_REQUEST['matriid'];
$varComplaintOn			= strtoupper($_REQUEST['complainton']);
$varComplaintBy			= strtoupper($_REQUEST['complaintby']);
$varComplaintTag		= $_REQUEST['complaint_tag'];
$varStLt				= $_REQUEST['startLimit'];
$varNumORec				= $_REQUEST['norec'];
$varTotUpdCnt			= $_REQUEST['totalcnt'];
$varDateTime			= date("Y-m-d H:i:s");
$varThroughViewProfile	= $_REQUEST['tvprofile'];

if(($_REQUEST['singleProfilePhoneSubmit']=="yes") ||($varThroughViewProfile=="yes")) {
	//GET MatriId FROM Username
	$argCondition			= "WHERE Complaint_On=".$objSlave->doEscapeString($varMatriId,$objSlave)." AND Request_Closed=0 GROUP BY Complaint_Tag";
	$argFields 				= array('Complaint_On','Complaint_Tag');
	$varSelectMatriIdRes	= $objSlave->select($varTable['PHONENOTWORK_LOG'],$argFields,$argCondition,0);
	$varTotalCnt			= mysql_num_rows($varSelectMatriIdRes);

} else if($_REQUEST['multipleProfilePhoneSubmit']=="yes") {
	$argCondition			= "WHERE Request_Closed=0 GROUP BY Complaint_On,Complaint_Tag LIMIT ".$varStLt.",".$varNumORec;
	$argFields 				= array('Complaint_On','Complaint_Tag');
	$varSelectMatriIdRes	= $objSlave->select($varTable['PHONENOTWORK_LOG'],$argFields,$argCondition,0);
	$varTotalCnt			= mysql_num_rows($varSelectMatriIdRes);
} else if($_REQUEST['phoneComplaintSubmit'] == "yes") {
	//check complaint already posted or not
	$argCondition			= " WHERE Complaint_On = ".$objSlave->doEscapeString($varComplaintOn,$objSlave)." AND Complaint_By=".$objSlave->doEscapeString($varComplaintBy,$objSlave)." AND Request_Closed=0";
	$varTotComplRecords		= $objSlave->numOfRecords($varTable['PHONENOTWORK_LOG'], $argPrimary='Id', $argCondition);

	if($varTotComplRecords==0) {
		$varFields			= array('Complaint_On','Complaint_By','Complaint_Tag','Request_Received');
		$varFieldsValues	= 
			array($objMaster->doEscapeString($varComplaintOn,$objMaster),$objMaster->doEscapeString($varComplaintBy,$objMaster),$objMaster->doEscapeString($varComplaintTag,$objMaster),"'".$varDateTime."'");
	$varResult			= $objMaster->insert($varTable['PHONENOTWORK_LOG'], $varFields, $varFieldsValues);
	}
} else if($_REQUEST['updphone'] == "yes") {
	for($j=1; $j<=$varTotUpdCnt; $j++) {
		$varComplaintOnId	= $_REQUEST['complainton'.$j];
		$varProfileMCKey	= "ProfileInfo_".$varComplaintOnId;
		$varDateTime		= date("Y-m-d H:i:s");
		$varComplaintByIds	= $_REQUEST['complaintby'.$j];
		$varPhoneNo			= $_REQUEST['phoneno'.$j];
		$varComplaintByTot	= "'".str_replace(', ','\',\'',$varComplaintByIds)."'";
		$varComplaintByTotForEmail	= str_replace(', ','~',$varComplaintByIds);
		$varComplaintTag	= $_REQUEST['complainttag'.$j];
		$varValidRequestType= $_REQUEST['reqtype'.$j];
		$varComments		= addslashes(strip_tags(trim($_REQUEST['comments'.$j])));
		$varDateTime		= date("Y-m-d H:i:s");
		//echo $varComplaintOnId.' == '.$varComplaintByTot.' == '.$varValidRequestType."<BR>";

		if($varValidRequestType==1) { //complaint is coorect
			//delete from phoneviewlist table
			$argCondition	= "MatriId=".$objMaster->doEscapeString($varComplaintOnId,$objMaster)." AND Opposite_MatriId IN (".$varComplaintByTot.")";
			$varDeleteId	= $objMaster->delete($varTable['PHONEVIEWLIST'],$argCondition);

			if($varDeleteId>0) {
				//update phone verified to 0
				$argCondition	= "MatriId=".$objMaster->doEscapeString($varComplaintOnId,$objMaster);
				$argFields 		= array('Phone_Verified','Date_Updated');
				$argFieldsValues= array(0,"'".$varDateTime."'");
				$varUpdateId	= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);
				
				//MEMBERTOOL LOGIN
				$varType  = 1;
				$varField = 0;
				$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
				$varphnsuppCmd  = 'php /home/product/community/www/membertoollog/membertoolcheck.php '.escapeshellarg($varMatriId)." ".escapeshellarg($varType)." ".escapeshellarg($varField).' &';	escapeexec($varphnsuppCmd,$varlogFile);
			

				//update phone count to opposite member
				$argCondition	= "MatriId IN (".$varComplaintByTot.")";
				$argFields 		= array('NumbersLeft');
				$argFieldsValues= array('NumbersLeft+1');
				$varUpdateId	= $objMaster->update($varTable['PHONEPACKAGEDET'],$argFields,$argFieldsValues,$argCondition);

				//update phonenotwork_log
				$argCondition	= "Complaint_On=".$objMaster->doEscapeString($varComplaintOnId,$objMaster)." AND Request_Closed=0 AND Complaint_By IN (".$varComplaintByTot.")";
				$argFields 		= array('Request_Valid','Request_Closed','Comment');
				$argFieldsValues= array(1,1,$objMaster->doEscapeString($varComments,$objMaster));
				$varUpdateId	= $objMaster->update($varTable['PHONENOTWORK_LOG'],$argFields,$argFieldsValues,$argCondition);

				//delete from assured contact
				$argCondition	= "MatriId=".$objMaster->doEscapeString($varComplaintOnId,$objMaster);
				$varDeleteId	= $objMaster->delete($varTable['ASSUREDCONTACT'],$argCondition);

				//insert into log file  (comments=>phone no value, reporttype=>4 is phone support validation, validateddate=>request completed date, editprofile=>1 is request valid, 0 is not valid)
				$argFields 		= array('userid','matriid','editprofile','comments','reporttype','validateddate');

				$argFieldsValues= 					array($objMaster->doEscapeString($adminUserName,$objMaster),$objMaster->doEscapeString($varComplaintOnId,$objMaster),1,$objMaster->doEscapeString($varPhoneNo,$objMaster),4,"'".$varDateTime."'");
				$varUpdateId	= $objMaster->insert($varTable['SUPPORT_VALIDATION_REPORT'],$argFields,$argFieldsValues);

				//send mail to complaint by (who made complaint)
				$retValue = $objSlave->sendPhoneSupportMail($varComplaintOnId,$varComplaintByTotForEmail,$varComplaintTag,1);
			}
		} else {
			//update phonenotwork_log
			$argCondition	= "Complaint_On=".$objMaster->doEscapeString($varComplaintOnId,$objMaster)." AND Request_Closed=0 AND Complaint_By IN (".$varComplaintByTot.")";
			$argFields 		= array('Request_Valid','Request_Closed','Comment');
			$argFieldsValues= array(2,1,$objMaster->doEscapeString($varComments,$objMaster));
			$varUpdateId	= $objMaster->update($varTable['PHONENOTWORK_LOG'],$argFields,$argFieldsValues,$argCondition);

			//insert into log file  (comments=>phone no value, reporttype=>4 is phone support validation, validateddate=>request completed date, editprofile=>1 is request valid, 0 is not valid)
			$argFields 		= array('userid','matriid','editprofile','comments','reporttype','validateddate');
			$argFieldsValues= array($objMaster->doEscapeString($adminUserName,$objMaster),$objMaster->doEscapeString($varComplaintOnId,$objMaster),0,$objMaster->doEscapeString($varPhoneNo,$objMaster),4,"'".$varDateTime."'");
			$varUpdateId	= $objMaster->insert($varTable['SUPPORT_VALIDATION_REPORT'],$argFields,$argFieldsValues);

			//send mail to complaint by (who made complaint)
			$retValue = $objSlave->sendPhoneSupportMail($varComplaintOnId,$varComplaintByTotForEmail,$varComplaintTag,2);
		}
	}
}
?>
<html>
<head>
	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/global-style.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/usericons-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/useractions-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/useractivity-sprites.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/messages.css">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/admin/fade.css">
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript">var imgs_url= '<?=$confValues["IMGSURL"]?>', img_url	= '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url	= '<?=$confValues["SERVERURL"]?>';</script>
	<script language="javascript">
	function fnPhoneUpdate() {
		var k;
		for(k=1; k<=document.updatephonedtl.totalcnt.value; k++) {
			var reqtype1 ="document.updatephonedtl.reqtype"+k+"[0]";
			var reqtype2 ="document.updatephonedtl.reqtype"+k+"[1]";
			var comments ="document.updatephonedtl.comments"+k;
			if(!(eval(reqtype1).checked) && !(eval(reqtype2).checked)) {
				alert("Please select valid request for profile "+k);
				eval(reqtype1).focus();
				return false;
			}

			if((eval(reqtype2).checked) && (eval(comments).value == '')) {
				alert("Please enter comments for profile "+k);
				eval(comments).focus();
				return false;
			}
		}
		return true;
	}
	</script>
</head>
<body>

<form method="post" name="updatephonedtl" onSubmit="return fnPhoneUpdate();">
<input type="hidden" name="totalcnt" value="<?=$varTotalCnt?>">
<input type="hidden" name="updphone" value="yes">
<table border="0" cellpadding="0" cellspacing="0" align="left" width="620">

 <tr>
	<td height="5px" colspan="6">
	  &nbsp;
	</td>
 </tr>
 <?php if(($_REQUEST['singleProfilePhoneSubmit']=="yes")||($varThroughViewProfile=="yes")){?>
 <tr width="300"> 
	<td  colspan="6" class="smalltxt" style="padding-left:10px" align="center">
		<b>MatriId :</b><?php echo $varMatriId;?>
	</td>		
 </tr>
<?php }?>
 <?php if(!isset($varThroughViewProfile)){?>
 <tr>
	<td colspan="6" class="smalltxt" align="right" style="padding-right:10px">
		<a href="<? echo $confValues["ServerURL"];?>/admin/index.php?act=phonesupport">back</a>
	</td>
 </tr>
	<?php }?>
 <tr>
	<td height="5px" colspan="6">
	  &nbsp;
	</td>
 </tr>
 
	<?if($_REQUEST['phoneComplaintSubmit'] != "yes") {
		if($varTotalCnt>0) {?>
	
	<tr>
		<td class="mediumtxt" align="center" valign="middle" style="border:1px solid #000;width:40px;height:30px;"><b>&nbsp;S.No</b></td>
		<td class="mediumtxt" align="center" valign="middle" style="border:1px solid #000;width:100px;border-left:0px;"><b>&nbsp;Compliant On</b></td>
		<td class="mediumtxt" align="center" valign="middle" style="border:1px solid #000;width:80px;border-left:0px;"><b>&nbsp;Compliant By</b></td>
		<td class="mediumtxt" align="center" valign="middle" style="border:1px solid #000;width:100px;border-left:0px;"><b>&nbsp;Compliant Tag</b></td>
		<td class="mediumtxt" align="center" valign="middle" style="border:1px solid #000;width:90px;border-left:0px;"><b>&nbsp;Valid Request</b></td>
		<td class="mediumtxt" align="center" valign="middle" style="border:1px solid #000;width:150px;border-left:0px;"><b>&nbsp;Comment</b></td>
	</tr>
    <?
		$i = 1;
		while($varSelectMatriId = mysql_fetch_assoc($varSelectMatriIdRes)) {
			$varComplaintBy = '';
			//Get Phone
			$argCondition			= "WHERE MatriId=".$varSelectMatriId['Complaint_On']."'";
			$argFields 				= array('PhoneNo1');
			$varSelectPhoneRes		= $objSlave->select($varTable['ASSUREDCONTACT'],$argFields,$argCondition,0);
			$varPhoneNoRes			= mysql_fetch_assoc($varSelectPhoneRes);
			$varPhoneNo				= str_replace('~','-',$varPhoneNoRes['PhoneNo1']);

			//GET MatriId FROM Username
			$argCondition			= "WHERE Complaint_On='".$varSelectMatriId['Complaint_On']."' AND Request_Closed=0 AND Complaint_Tag=".$varSelectMatriId['Complaint_Tag'];
			$argFields 				= array('Complaint_By','Complaint_Tag');
			$varSelectComplaintByRes= $objSlave->select($varTable['PHONENOTWORK_LOG'],$argFields,$argCondition,0);
			while($varSelectComplaintBy = mysql_fetch_assoc($varSelectComplaintByRes)) {
				$varComplaintBy .= $varSelectComplaintBy['Complaint_By'].', ';
				$varComplaintTag = $varSelectComplaintBy['Complaint_Tag'];
			}
	?>
    <tr>
		<td class="smalltxt" align="center" valign="top" style="padding-top:10px;height:80px;border:1px solid #000;width:40px;border-top:0px;">&nbsp;<?=$i;?></td>
		<td align="center" valign="top" style="font-size:12px;padding-top:10px;border:1px solid #000;width:100px;border-top:0px;border-left:0px;"><font color="#FF0000">&nbsp;<b><?=$varSelectMatriId['Complaint_On']?></b><br><br>&nbsp;<?=$varPhoneNo?></font><input type="hidden" name="complainton<?=$i?>" value="<?=$varSelectMatriId['Complaint_On']?>"><input type="hidden" name="phoneno<?=$i?>" value="<?=$varPhoneNo?>"></td>
		<td class="smalltxt" align="center" valign="top" style="padding-top:10px;border:1px solid #000;width:80px;border-top:0px;border-left:0px;">&nbsp;<?=trim($varComplaintBy,', ');?><input type="hidden" name="complaintby<?=$i?>" value="<?=trim($varComplaintBy,', ')?>"></td>
		<td class="smalltxt" align="center" valign="top" style="padding-top:10px;border:1px solid #000;width:100px;border-top:0px;border-left:0px;">&nbsp;<?=$arrPhoneNotWorking[$varComplaintTag]?><input type="hidden" name="complainttag<?=$i?>" value="<?=$varComplaintTag?>"></td>
		<td class="smalltxt" align="center" valign="top" style="padding-top:10px;border:1px solid #000;width:90px;border-top:0px;border-left:0px;">&nbsp;<input type="radio" name="reqtype<?=$i?>" value="1">Yes <input type="radio" name="reqtype<?=$i?>" value="2">No</td>
		<td class="smalltxt" align="center" valign="top" style="padding-top:10px;border:1px solid #000;width:150px;border-top:0px;border-left:0px;"><textarea name="comments<?=$i?>" style="height:55px;width:140px;"></textarea></td>
	</tr>
	<?$i++;}?>
    	<tr><td align="center" valign="top" class="smalltxt" colspan="6" style="padding-top:10px;height:40px;"><input type="submit" name="updatephone" class="button" value="Submit">&nbsp;<input type="reset" class="button" value="Reset"></td></tr>
	<?} else {?>
	<tr><td height="5px"> &nbsp;</td></tr>
	<tr>
		<td class="smalltxt" colspan="6" align="center">No record available</td>
	</tr>
	<tr><td height="5px"> &nbsp;</td></tr>
	<?}} else {?>
	<tr><td height="5px"> &nbsp;</td></tr>
	<tr>
		<td class="smalltxt" colspan="6">Complaint added successfully</td>
	</tr>
	<tr><td height="5px"> &nbsp;</td></tr>
	<?}?>

</table>
</form>
</body>
</html>
<?
//UNSET OBJECTS
$objSlave->dbClose();
$objMaster->dbClose();
unset($objSlave);
unset($objMaster);
?>