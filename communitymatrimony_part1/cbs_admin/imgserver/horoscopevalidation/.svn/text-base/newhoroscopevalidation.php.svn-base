<?php
$varRootPath = $_SERVER['DOCUMENT_ROOT'];
$varBasePath = dirname($varRootPath);

include_once($varBasePath.'/www/admin1/includes/userLoginCheck.php');
include_once($varBasePath.'/conf/config.cil14');
include_once($varBasePath.'/conf/domainlist.cil14');
include_once($varBasePath.'/conf/dbinfo.cil14');
include_once($varBasePath.'/lib/clsDB.php');

$cookValue	= split('&', $_COOKIE['adminLoginInfo']);

$varCont	= '';
if($cookValue[1]==''){
	$varCont = '<div class="errortxt">Session is not available, Kindly login again.</div>';
}else{
$objMasterDB	= new DB;

$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

$varTableName	= 'horoscopevalidationpending';

$varWhereCond	= 'WHERE Validation_Status=0';
$varNumOfRows	= $objMasterDB->numOfRecords($varTableName, 'MatriId', $varWhereCond);

if($varNumOfRows<50){
	//Populate Records in  horoscopevalidationpending table
	$varDateCond		= date( "Y-m-d H:i:s", mktime(date("H"), date("i")-15, date("s"),date("m"),date("d"),date("Y")));
	$varOnemonthDate	= date( "Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"),date("m")-1,date("d"),date("Y")));
	$varQuery	= "INSERT IGNORE INTO horoscopevalidationpending (SELECT MatriId,0,Horoscope_Date_Updated FROM ".$varTable['MEMBERPHOTOINFO']." WHERE Horoscope_Date_Updated>='".$varOnemonthDate."' AND Horoscope_Date_Updated<='".$varDateCond."' AND HoroscopeURL!='' AND (HoroscopeStatus=0 OR HoroscopeStatus=2))";
	$objMasterDB->ExecuteQryResult($varQuery,0);

	$varWhereCond	= 'WHERE Validation_Status=1';
	$varNumOfRows	= $objMasterDB->numOfRecords($varTableName, 'MatriId', $varWhereCond);
	if($varNumOfRows > 20){
		$varNumOfRows	= $varNumOfRows-10;
		$varWhereCond	= 'Validation_Status=1 ORDER BY Date_Updated ASC LIMIT '.$varNumOfRows;
		$objMasterDB->delete($varTableName, $varWhereCond);
	}
}
$varMatriId		= $_REQUEST['ID'];
if($varMatriId == ''){
$arrFields		= array('MatriId', 'Date_Updated');
$varWhereCond	= 'WHERE Validation_Status=0 ORDER BY Date_Updated ASC LIMIT 1';
$varResultSet	= $objMasterDB->select($varTableName, $arrFields, $varWhereCond, 0);
$varPInfoDet	= mysql_fetch_assoc($varResultSet);
$varMatriId		= $varPInfoDet['MatriId'];
}

$varAffectedRows= 0;
$varGetFlag		= 0;
if($varMatriId!=''){
$arrFields		= array('Validation_Status');
$arrFieldVals	= array(1);
$varWhereCond	= "Validation_Status=0 AND MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
$varAffectedRows= $objMasterDB->update($varTableName, $arrFields, $arrFieldVals, $varWhereCond);

if($varAffectedRows==0 && $_REQUEST['ID']!=''){$varAffectedRows=1; $varGetFlag=1;}

$arrFields		= array('Gender');
$varWhereCond	= "WHERE MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
$varResultSet	= $objMasterDB->select($varTable['MEMBERINFO'], $arrFields, $varWhereCond, 0);
$varMemberinfoDet= mysql_fetch_assoc($varResultSet);
$varGender		= $varMemberinfoDet['Gender'];
$varGenderTxt	= ($varGender==1) ? 'Male' : 'Female';
$varBgColor		= ($varGender==1) ? '#FFFFFF' : '#FFF0D3';
}

if($varAffectedRows > 0){
$arrFields		= array('HoroscopeURL', 'HoroscopeStatus', 'Horoscope_Date_Updated');
$varWhereCond	= "WHERE MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
$varResultSet	= $objMasterDB->select($varTable['MEMBERPHOTOINFO'], $arrFields, $varWhereCond, 0);
$varRow			= mysql_fetch_assoc($varResultSet);

$varUnvalHoroscope	= 0;
$varValHoroscope	= 0;
$varUnavailHoroscope= 0;

if($varRow['HoroscopeURL']==''){
	$varUnavailHoroscope = 1;
}else if($varRow['HoroscopeStatus']==0 || $varRow['HoroscopeStatus']==2){
	$varUnvalHoroscope = 1;
}else{
	$varValHoroscope = 1;
}

$varImageURL		= $confValues['IMAGEURL'];

if($varGetFlag==1 && $varUnvalHoroscope==1){
$arrFields		= array('MatriId', 'Validation_Status');
$arrFieldVals	= array($objMasterDB->doEscapeString($varMatriId,$objMasterDB), 1);
$objMasterDB->insertIgnore($varTableName, $arrFields, $arrFieldVals);
}

if($varUnvalHoroscope == 1){
$arrFields		= array('userid', 'matriid', 'reporttype', 'dynamicdata', 'downloadeddate','notifycustomer','profilestatus');
$arrFieldVals	= array($objMasterDB->doEscapeString($cookValue[1],$objMasterDB), $objMasterDB->doEscapeString($varMatriId,$objMasterDB), 5, "'TOT_PEND=".$varUnvalHoroscope."'", 'NOW()', '0', '0');
$varInsertId	= $objMasterDB->insert('support_validation_report', $arrFields, $arrFieldVals);
setcookie("reportid",$varInsertId, "0", "/",$confValues["DomainName"]);
}
$varPInfoDet['Date_Updated'] = ($varPInfoDet['Date_Updated'] !='' && $varPInfoDet['Date_Updated'] !='0000-00-00 00:00:00') ? $varPInfoDet['Date_Updated'] : $varRow['Horoscope_Date_Updated'];


$varCont  = '<table width="80%" align="center" style="border:solid;"><tr><td class="mediumtxt bld"><br><br>MatriId : <font class="errortxt">'.$varMatriId.'</font>&nbsp;&nbsp;&nbsp; Gender : <font class="errortxt">'.$varGenderTxt.'</font>&nbsp;&nbsp;&nbsp;';
if($varPInfoDet['Date_Updated'] != ''){
$varCont  .= 'Uploaded date : <font class="errortxt">'.date('d M Y H:i:s',strtotime($varPInfoDet['Date_Updated'])).'</font>';
}
$varCont  .= '<br><br></td></tr>';
$varCont .= '<tr><td></td></tr>';

if($varUnvalHoroscope == 1){
	$varCont .= '<tr><td><form name="frmhorovalidation" id="frmhorovalidation" method="post" onsubmit="return validate();" action="'.$varImageURL.'/admin1/horoscopevalidation/adminhoroscopeapprove.php"><table width="100%" cellspacing="0" align="center"><tr class="adminformheader" align="center"><td>Add</td><td>View</td><td>delete</td><td>Reason for delete</td></tr>';
	
	$varPath = $varImageURL.'/pending-horoscopes/'.$arrFolderNames[substr($varMatriId,0,3)].'/'.$varRow['HoroscopeURL'];
		
	$varValue = $varMatriId.'_1_add';
	$varCont .= '<tr align="center" style="background-color:'.$varBgColor.'"><td><input type="hidden" name="imagename1" value="'.$varRow['HoroscopeURL'].'"><input type="radio" value="'.$varValue.'" name="horoadddelete_1" onclick="vistxtarea(\'reason_1\', \'hidden\');" class="frmelements"></td>';
		
	$varValue = $varImageURL.'/admin1/horoscopevalidation/adminshowhoroscope.php?id='.$varMatriId;
	$varCont .= '<td><a href="javascript:;" onclick="window.open(\''.$varValue.'\',\'\',\'directories=no,width=1000,height=1000,menubar=no,resizable=yes,scrollbars=yes,status=no,titlebar=no,top=0,left=0\');" class="smalltxt clr1">'.$varRow['HoroscopeURL'].'</a></td>';

	$varValue = $varMatriId.'_1_del';
	$varCont .= '<td><input type="radio" onclick="vistxtarea(\'reason_1\', \'visible\');" value="'.$varValue.'" name="horoadddelete_1" class="frmelements"></td>';

	$varCont .= '<td><textarea style="width:200px;visibility:hidden;" id="reason_1" name="reason_1"></textarea></td></tr>';

	$varCont .= '<tr><td colspan="4" align="center"><br><br><input type="hidden" name="bymatriid" value="'.$_REQUEST['ID'].'"><input type="submit" name="submit" value="Submit" class="button">&nbsp;<input type="button" class="button" name="clear" value="Clear" onclick="clearRadio();"><br></td></tr></table></form></td></tr>';
}else if($varValHoroscope==1){
	$varCont .= '<tr><td><div align="center" class="errortxt bld">Horoscope has already validated.</div></td></tr>';
}else{
	$varCont .= '<tr><td><div align="center" class="errortxt bld">Horoscope not available for validation.</div></td></tr>';
}

}else{ $varCont .= '<div align="center" class="errortxt bld">Horoscope not available for validation.</div>';}
$varCont .= '</table>';
$objMasterDB->dbClose();
}
include_once("adminheader.php");
?>
<script>
var totrows = <?=$varUnvalHoroscope?>; 
function vistxtarea(id, mode){
	document.getElementById(id).style.visibility= mode;
}
function getRank(spno, spcont){
	spanname = 'rankspan'+spno;
	document.getElementById(spanname).innerHTML=spcont;
}
function validate(){
	var select = 0;
	var chk = 0;
	var eleVals	= '';
	for(i=1; i<=totrows; i++){   
		eleName = eval('document.frmhorovalidation.horoadddelete_'+i+'[0]');
		eleName1 = eval('document.frmhorovalidation.horoadddelete_'+i+'[1]');
		if(eleName.checked == true || eleName1.checked == true){ select++;}
		else{eleVals += i+', '}
	}
	if(select<totrows){
		alert("Please select the horoscope that you wish to Add / Delete.");
		return false;
	}
	
	eleVals='';
	for(i=1; i<=totrows; i++){ 
		eleName  = eval('document.frmhorovalidation.horoadddelete_'+i+'[1]');
		eleName1 = eval('document.frmhorovalidation.reason_'+i);
		if(eleName.checked==true && eleName1.value==''){eleVals += i+', '}
	}

	if(eleVals != ''){
		alert("Please enter the reason for the horoscope that you wish to Delete.");
		return false;
	}

	return true;
 }

 function clearRadio() {       
        var r = document.getElementsByTagName('input');   
        for (var i = 0, n; n = r[i]; i++) {   
            if (n.type == 'radio') {   
                n.checked = false;   
            }  
        }   
 }

function loadimagesrc(imgName) {
	imgid = 'img75_'+imgName;
	imgurl= document.images[imgid].src; 
	document.images[imgid].src = imgurl+'?rand='+Math.random();
}
</script>
<?=$varCont;?>