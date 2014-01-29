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
if($_REQUEST['ID']!=''){
$varMatriId		= strtoupper($_REQUEST['ID']);
}
if($_REQUEST['shuffid']!=''){
$varMatriId		= strtoupper($_REQUEST['shuffid']);
}

$varTableName	= 'photovalidationpending';

$varAffectedRows= 0;
$varGetFlag		= 0;
if($varMatriId!=''){
$arrFields		= array('Validation_Status');
$arrFieldVals	= array(1);
$varWhereCond	= "Validation_Status=0 AND MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
$varAffectedRows= $objMasterDB->update($varTableName, $arrFields, $arrFieldVals, $varWhereCond);

if($varAffectedRows==0 && $_REQUEST['ID']!=''){$varAffectedRows=1; $varGetFlag=1;}
if($varAffectedRows==0 && $_REQUEST['shuffid']!=''){$varAffectedRows=1; $varGetFlag=1;}

$arrFields		= array('Gender');
$varWhereCond	= "WHERE MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
$varResultSet	= $objMasterDB->select($varTable['MEMBERINFO'], $arrFields, $varWhereCond, 0);
$varMemberinfoDet= mysql_fetch_assoc($varResultSet);
$varGender		= $varMemberinfoDet['Gender'];
$varGenderTxt	= ($varGender==1) ? 'Male' : 'Female';
$varBgColor		= ($varGender==1) ? '#FFFFFF' : '#FFF0D3';
}
if($varAffectedRows > 0){
$arrFields		= array('Normal_Photo1', 'Thumb_Small_Photo1', 'Thumb_Big_Photo1', 'Photo_Status1', 'Normal_Photo2', 'Thumb_Small_Photo2', 'Thumb_Big_Photo2', 'Photo_Status2', 'Normal_Photo3', 'Thumb_Small_Photo3', 'Thumb_Big_Photo3', 'Photo_Status3', 'Normal_Photo4', 'Thumb_Small_Photo4', 'Thumb_Big_Photo4', 'Photo_Status4', 'Normal_Photo5', 'Thumb_Small_Photo5', 'Thumb_Big_Photo5', 'Photo_Status5', 'Normal_Photo6', 'Thumb_Small_Photo6', 'Thumb_Big_Photo6', 'Photo_Status6', 'Normal_Photo7', 'Thumb_Small_Photo7', 'Thumb_Big_Photo7', 'Photo_Status7', 'Normal_Photo8', 'Thumb_Small_Photo8', 'Thumb_Big_Photo8', 'Photo_Status8', 'Normal_Photo9', 'Thumb_Small_Photo9', 'Thumb_Big_Photo9', 'Photo_Status9', 'Normal_Photo10', 'Thumb_Small_Photo10', 'Thumb_Big_Photo10', 'Photo_Status10', 'Photo_Date_Updated', 'Description1', 'Description2', 'Description3', 'Description4', 'Description5', 'Description6', 'Description7', 'Description8', 'Description9', 'Description10');
$varWhereCond	= "WHERE MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
$varResultSet	= $objMasterDB->select($varTable['MEMBERPHOTOINFO'], $arrFields, $varWhereCond, 0);
$varRow			= mysql_fetch_assoc($varResultSet);



//split photos based on status
$arrValidatedPhotos		= array();
$arrUnvalidatedPhotos	= array();
$varUnvalidatedPhNos	= '';
$ii=0; $jj=0;
for($i=1; $i<=10; $i++){
	$varNLName = $varRow['Normal_Photo'.$i];
	$varTSName = $varRow['Thumb_Small_Photo'.$i];
	$varTBName = $varRow['Thumb_Big_Photo'.$i];
	$varStatus = $varRow['Photo_Status'.$i];
	$varDesc   = $varRow['Description'.$i];
	if($varNLName!='' || $varTSName!='' || $varTBName!=''){
		if($varStatus == 1){
			$arrValidatedPhotos[$ii]['COL']	= $i;
			$arrValidatedPhotos[$ii]['NL']	= $varNLName;
			$arrValidatedPhotos[$ii]['TS']	= $varTSName;
			$arrValidatedPhotos[$ii]['TB']	= $varTBName;
			$ii++;
		}else{
			$arrUnvalidatedPhotos[$jj]['COL']	= $i;
			$arrUnvalidatedPhotos[$jj]['NL']	= $varNLName;
			$arrUnvalidatedPhotos[$jj]['TS']	= $varTSName;
			$arrUnvalidatedPhotos[$jj]['TB']	= $varTBName;
			$arrUnvalidatedPhotos[$jj]['DESC']	= $varDesc;
			$varUnvalidatedPhNos	.= $i.",";
			$jj++;
		}
	}
}

$varValidatedCnt	= count($arrValidatedPhotos);
$varUnvalidatedCnt	= count($arrUnvalidatedPhotos);
$varImageURL		= $confValues['IMAGEURL'];

if($varGetFlag==1 && $varUnvalidatedCnt>0){
$arrFields		= array('MatriId', 'Validation_Status');
$arrFieldVals	= array($objMasterDB->doEscapeString($varMatriId,$objMasterDB), 1);
$objMasterDB->insertIgnore($varTableName, $arrFields, $arrFieldVals);
}


$arrFields		= array('userid', 'matriid', 'reporttype', 'dynamicdata', 'downloadeddate','notifycustomer','profilestatus');
$arrFieldVals	= array($objMasterDB->doEscapeString($cookValue[1],$objMasterDB), $objMasterDB->doEscapeString($varMatriId,$objMasterDB), 3, "'TOT_PEND=".$varUnvalidatedCnt.'&PHNOS='.trim($varUnvalidatedPhNos,',')."'", 'NOW()', '0', '0');
$varInsertId	= $objMasterDB->insert('support_validation_report', $arrFields, $arrFieldVals);
setcookie("reportid",$varInsertId, "0", "/",$confValues["DomainName"]);

$varPInfoDet['Date_Updated'] = ($varPInfoDet['Date_Updated'] !='' && $varPInfoDet['Date_Updated'] !='0000-00-00 00:00:00') ? $varPInfoDet['Date_Updated'] : $varRow['Photo_Date_Updated'];


$varCont  = '<table width="80%" align="center" style="border:solid;"><tr><td class="mediumtxt bld">MatriId : <font class="errortxt">'.$varMatriId.'</font>&nbsp;&nbsp;&nbsp; Gender : <font class="errortxt">'.$varGenderTxt.'</font>&nbsp;&nbsp;&nbsp; Uploaded date : <font class="errortxt">'.date('d M Y H:i:s',strtotime($varPInfoDet['Date_Updated'])).'</font></td></tr>';
$varCont .= '<tr><td></td></tr>';
if($varValidatedCnt > 0){
	$varCont .= '<tr><td><table width="100%" align="center" border="1"><tr><td>';
	for($i=0; $i<$varValidatedCnt; $i++){
		$varPath = $varImageURL.'/membersphoto/'.$arrFolderNames[substr($varMatriId,0,3)].'/'.$varMatriId{3}.'/'.$varMatriId{4}.'/'.$arrValidatedPhotos[$i]['NL'];
		$varCont .= '<img src="'.$varPath.'" width="75" height="75">&nbsp;';
	}
	$varCont .= '</td></tr></table><br clear="all"><br clear="all">';
}else{$varCont .= '<tr><td>';}

if($varUnvalidatedCnt > 0){
	$varCont .= '<form name="frmphotovalidation" id="frmphotovalidation" method="post" onsubmit="return validate();" action="'.$varImageURL.'/admin1/photovalidation/adminphotoapprove.php"><table width="100%" cellspacing="0" align="center"><tr class="adminformheader" align="center"><td>Add</td><td>Photo</td><td>View</td><td>Rank</td><td>Crop photo</td><td>Description</td><td>delete</td><td>Reason for delete</td></tr>';
	
	for($i=0; $i<$varUnvalidatedCnt; $i++){
		$varPhotoNo = $arrUnvalidatedPhotos[$i]['COL'];
		$varPath = $varImageURL.'/membersphoto/'.$arrFolderNames[substr($varMatriId,0,3)].'/crop75/'.$arrUnvalidatedPhotos[$i]['NL'];
		
		$varValue = $varMatriId.'_'.$varPhotoNo.'_add';
		$varCont .= '<tr align="center" style="background-color:'.$varBgColor.'"><td><input type="radio" value="'.$varValue.'" name="photoadddelete_'.($i+1).'" onclick="vistxtarea(\'reason_'.($i+1).'\', \'hidden\');" class="frmelements"><input type="hidden" value="'.$arrUnvalidatedPhotos[$i]['TB'].'" name="imagename'.($i+1).'"></td>';
		
		$varCont .= '<td><img name="img75_'.($i+1).'" src="'.$varPath.'" width="75" height="75"></td>';
		
		$varValue = $varImageURL.'/admin1/photovalidation/adminviewphoto.php?id='.$varMatriId.'&divno='.($i+1).'&num='.$varPhotoNo;
		$varCont .= '<td><a href="javascript:;" onclick="window.open(\''.$varValue.'\',\'\',\'directories=no,width=1000,height=1000,menubar=no,resizable=yes,scrollbars=yes,status=no,titlebar=no,top=0,left=0\');" class="smalltxt clr1">'.$varMatriId.'('.$varPhotoNo.')</a></td>';

		$varValue = 'rankspan'.($i+1);
		$varCont .= '<td><span class="smalltxt" id="'.$varValue.'" name="'.$varValue.'">nil</span></td>';
		
		$varValue = $varImageURL.'/admin1/photovalidation/adminactualcropphoto.php?id='.$varMatriId.'&divno='.($i+1).'&num='.$varPhotoNo;
		$varCont .= '<td><a href="javascript:;" onclick="window.open(\''.$varValue.'\',\'\',\'directories=no,width=1000,height=1000,menubar=no,resizable=yes,scrollbars=yes,status=no,titlebar=no,top=0,left=0\')" class="smalltxt clr1">Crop / Enhance</a></td>';
		
		$varValue = $varMatriId.'_desc_'.$varPhotoNo;
		$varCont .= '<td><textarea style="width:150px;" class="inputtext" cols="50" rows="2" name="'.$varValue.'">'.$arrUnvalidatedPhotos[$i]['DESC'].'</textarea></td>';
		
		$varValue = $varMatriId.'_'.$varPhotoNo.'_del';
		$varCont .= '<td><input type="radio" onclick="vistxtarea(\'reason_'.($i+1).'\', \'visible\');" value="'.$varValue.'" name="photoadddelete_'.($i+1).'" class="frmelements"></td>';

		$varCont .= '<td><textarea style="width:150px;visibility:hidden;" id="reason_'.($i+1).'" name="reason_'.($i+1).'"></textarea></td></tr>';
	}
	$varCont .= '<tr><td colspan="7" align="center"><br><br><input type="hidden" name="bymatriid" value="'.$_REQUEST['ID'].'"><input type="submit" name="submit" value="Submit" class="button">&nbsp;<input type="button" class="button" name="clear" value="Clear" onclick="clearRadio();"><br></td></tr></table></form></td></tr>';
}else{
	$varCont .= '<div align="center" class="errortxt bld"> Pending photos not available for this MatriId('.$varMatriId.').</div>';
}
}else{ $varCont .= '<div align="center" class="errortxt bld">Photos not available for validation.</div>';}
$varCont .= '</table>';
$objMasterDB->dbClose();
}
include_once("adminheader.php");
?>
<script>
var totrows = <?=$varUnvalidatedCnt?>; 
function vistxtarea(id, mode){
	document.getElementById(id).style.visibility= mode;
}
function getRank(spno, spcont){
	spanname = 'rankspan'+spno;
	document.getElementById(spanname).innerHTML=spcont;
}

function controlrefresh() {
	document.onmousedown="if (event.button==2) return false";
	document.oncontextmenu=new Function("return false");
	document.onkeydown = showDown;
	function showDown(evt) {
	evt = (evt)? evt : ((event)? event : null);
		if (evt) {
			if (evt.keyCode == 116) {// When F5 is pressed
				cancelKey(evt);
			}			
		}
	}
	function cancelKey(evt) {
		if (evt.preventDefault) {
			evt.preventDefault();
			return false;
		}
		else {
			evt.keyCode = 0;
			evt.returnValue = false;
		}
	}
}
controlrefresh();

function validate(){
	var select = 0;
	var chk = 0;
	var eleVals	= '';
	for(i=1; i<=totrows; i++){   
		eleName = eval('document.frmphotovalidation.photoadddelete_'+i+'[0]');
		eleName1 = eval('document.frmphotovalidation.photoadddelete_'+i+'[1]');
		if(eleName.checked == true || eleName1.checked == true){ select++;}
		else{eleVals += i+', '}
	}
	if(select<totrows){
		alert("Please select the photos("+eleVals+") that you wish to Add / Delete.");
		return false;
	}
	
	eleVals='';
	for(i=1; i<=totrows; i++){ 
		eleName  = eval('document.frmphotovalidation.photoadddelete_'+i+'[1]');
		eleName1 = eval('document.frmphotovalidation.reason_'+i);
		if(eleName.checked==true && eleName1.value==''){eleVals += i+', '}
	}

	if(eleVals != ''){
		alert("Please enter the reason for the photos("+eleVals+") that you wish to Delete.");
		return false;
	}

	eleVals='';
	for(i=1; i<=totrows; i++){
		eleName  = eval('document.frmphotovalidation.photoadddelete_'+i+'[0]');
		spanname = 'rankspan'+i;
		spanval  = document.getElementById(spanname).innerHTML;
		if(eleName.checked==true && spanval=='nil'){eleVals += i+', '}
	}
	
	if(eleVals != ''){
		alert("Please view the photos and give ranking for the photos("+eleVals+")");
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