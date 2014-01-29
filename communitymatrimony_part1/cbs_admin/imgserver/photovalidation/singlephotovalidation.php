<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		:
#================================================================================================================
   # Description	: 
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/www/admin1/includes/userLoginCheck.php"); // Added for authentication
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION VARIABLES
//Object initialization
$objSlaveDB			= new DB;
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
//print $varSlaveConn;
?>
<script>
function passitems(){
	var url;
	url='photoadmin.php?matriid='+document.form1.memberid.value+'&entrytype='+document.form1.membership.value+'&gender='+document.form1.gender.value;
	document.location.href=url;
	//document.form1.submit();
}
</script>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/usericons-sprites.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/useractions-sprites.css">
<style type="text/css">

	a.id:link              { color:black; text-decoration:none; }
    a.id:visited           { color:brown; text-decoration:none; }
    a.id:hover             { color:black; text-decoration:underline; }
    a.id:active            { color:green; text-decoration:none; }
</style>
<? 
include_once("adminheader.php");
$varUsername		= trim(strtoupper($_POST["ID"]));

//Get Folder Name for corresponding MatriId
$varPrefix			= substr($varUsername,0,3);
$varFolderName		= $arrFolderNames[$varPrefix];

$varDomainPHPath	= $varRootBasePath.'/www/membersphoto/'.$varFolderName;
$varPhotoBupPath	= $varDomainPHPath."/backup/";
$varPhotoCrop450	= $varDomainPHPath."/crop450/";
$varPhotoCrop150	= $varDomainPHPath."/crop150/";
$varPhotoCrop75		= $varDomainPHPath."/crop75/";

$varQueryCondition	= '';
//$varMatriId			= $_GET['matriid'];
$varFields			= array('User_Name','MatriId');
$varCondition		= " WHERE  MatriId  =".$objSlaveDB->doEscapeString($varUsername,$objSlaveDB);
$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], $argPrimary='MatriId', $varCondition);
//print "<br> TOTAL RECORDS ".$varTotRecords;
if ($varTotRecords == 1) {
	$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
	$varSelectLoginInfo	= mysql_fetch_assoc($varResult);
} else {
	$varCondition		= " WHERE  User_Name  =".$objSlaveDB->doEscapeString($varUsername,$objSlaveDB);
	$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], $argPrimary='MatriId', $varCondition);
	if ($varTotRecords == 1) {
		$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
		$varSelectLoginInfo	= mysql_fetch_assoc($varResult);
	}
}
$varContent	.= '';
if ($varTotRecords == 0 ) {
	echo '<table width="100%" border="0"><tr><td align="center"><font class="smalltxt boldtxt clr1"> Profile not found </font></td></tr></table>';
} else {
	$varQuery			= " SELECT A.MatriId,A.Name,A.Gender,A.Paid_Status,B.*  FROM  ".$varTable['MEMBERPHOTOINFO']." B, ".$varTable['MEMBERINFO']." A  WHERE A.MatriId = B.MatriId  AND A.MatriId =".$objSlaveDB->doEscapeString($varSelectLoginInfo['MatriId'],$objSlaveDB);
	//print "<br>".$varQuery;
	$varResult			=  mysql_query($varQuery,$objSlaveDB->clsDBLink);
	$row				= mysql_fetch_assoc($varResult);
	echo '<body onload="clearRadio();">';
	$varContent	.= '<form id="frmphotovalidation" name="frmphotovalidation" method="post" onsubmit="return validate();" action="'.$confValues['IMAGEURL'].'/admin1/photovalidation/adminphotoapprove.php"><table width="920" border="0" cellpadding="0" cellspacing="0" align="center" class="formborder"><tr class="adminformheader"><td align="center"  height="35"><font  class="mediumtxt boldtxt clr">&nbsp;S.No</font></td><td align="center"><font  class="mediumtxt boldtxt clr">Add</font></td><td align="center"><font  class="mediumtxt boldtxt clr">MatriId</font></td><td align="center"><font  class="mediumtxt boldtxt clr">Gender</font></td><td align="center"><font  class="mediumtxt boldtxt clr">Crop photo</font></td> <td class="mediumtxt boldtxt clr">Description</td><td align="center"><font  class="mediumtxt boldtxt clr">delete</font></td><td align="center"><font  class="mediumtxt boldtxt clr">Reason for delete</font></td><td align="center"><font  class="mediumtxt boldtxt clr">View</font></td></tr><tr><td colspan="9" height="15"></td></tr>';
	$varCount		= 0;
	$varRowCountt	= 0;
	for($i=1;$i<=10;$i++){
		if (($row['Photo_Status'.$i] == 0 || $row['Photo_Status'.$i] == 2) && trim($row['Normal_Photo'.$i]) != '' && trim($row['Thumb_Small_Photo'.$i]) != '' && $row['Thumb_Big_Photo'.$i] != '') {
			if (file_exists($varPhotoCrop75.$row['Normal_Photo'.$i]) && file_exists($varPhotoCrop150.$row['Thumb_Small_Photo'.$i]) && file_exists($varPhotoCrop450.$row['Thumb_Big_Photo'.$i])){
				//print "<br>".$row['MatriId'];
				$varCount++;
				$varContent	.= "<tr class='smalltxt' ><td width='3%' align='center' class='smalltxt' >".$varCount."</td><td width='7%' align='center' class='smalltxt' ><input class='frmelements' type=radio ".$disabled."  name=photoadddelete_".$varCount."   value='".$row['MatriId']."_".$i."_add'  ><input type='hidden' name='imagename".$varCount."' value='". $row['Thumb_Big_Photo'.$i]."'  ></td>";
				$varContent	.= "<td width='8%' align='center' class='smalltxt' ><a class='smalltxt clr1' target='_blank' 		href=".$confValues['IMAGEURL']."/admin1/photovalidation/adminviewphoto.php?id=".$row["MatriId"]."&num=".$i.">".$row['MatriId']."_".$i."</a></td>";
				$varContent	.= "<td width='7%' align='center' class='smalltxt' >".(($row['Gender'] == 1)?'Male':'Female')."</td>";
				$varContent	.= "<td width='12%' align='center' class='smalltxt' >";
				$varContent	.= "<a class='smalltxt clr1' href=javascript:;  onclick=javascript:window.open('".$confValues['IMAGEURL']."/admin1/photovalidation/adminphotobrightness.php?id=".$row['MatriId']."&num=".$i."&PNO=1','viewphoto','scrollbars=yes','height=600,width=800');>Enhancement_photo </a><br><a class='smalltxt clr1' target=_blank href=".$confValues['IMAGEURL']."/admin1/photovalidation/adminactualcropphoto.php?id=".$row['MatriId']."&num=".$i.">Crop 450 </a><br><a class='smalltxt clr1' target=_blank href=".$confValues['IMAGEURL']."/admin1/photovalidation/admincropphoto.php?id=".$row['MatriId']."&num=".$i.">Crop photo </a><br><a class='smalltxt clr1' target=_blank href=".$confValues['IMAGEURL']."/admin1/photovalidation/adminphotorotate.php?id=".$row['MatriId']."&num=".$i.">Photo_Rotate </a>";
				$varContent	.= "</td>";
				//$varContent	.= "<td width='12%' align='center' class='smalltxt' ><a href='javascript:;' class='mediumtxt clr1' onClick=window.open('".$confValues['IMAGEURL']."/admin/photovalidation/admincropphoto.php?id=".$row['MatriId']."&num=".$i."','','directories=no,width=700,height=700,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');>Recrop photo </a></td>";
				$varContent	.= "<td width='1%' align='center' class='smalltxt' ><TEXTAREA name='".$row['MatriId']."_desc_".$i."'  ROWS='2' COLS='50' class=inputtext style=width:175px;>".$row['Description'.$i]."</TEXTAREA></td>";
				$varContent	.= "<td width='8%' align='center' class='smalltxt' ><INPUT  class='frmelements' type=radio  name=photoadddelete_".$varCount."  value=".$row['MatriId']."_".$i."_del  onclick=javascript:document.getElementById('".$varCount."').style.visibility='visible'; >  </td>";
				$varContent	.= '<td align="center"><TEXTAREA   name="reason_'.$varCount.'" id="'.$varCount.'" style="visibility:hidden"/></textarea>';
				$varContent	.= '<input type="hidden" name="name'.$varCount.'" value ='.$row["Name"].'" ><input type="hidden" name="paidstatus_'.$varCount.'" value ='.$row["Paid_Status"].'" > </td></tr><tr><td colspan="8" height="10"></td>';
				$varContent	.= '<td width="10%" align="center" valign="center"><a href=javascript:;  onclick=javascript:window.open("adminshowphoto.php?MATRIID='.$row['MatriId'].'&PNO=1","viewphoto","height=600,width=800"); class="smalltxt clr1">View</a></tr>';
				//print "<br>COUNT :".$varCount;
			}
		}

	}
	if ($varCount == 0){
			echo '<table width="100%" border="0"><tr><td align="center"><font class="smalltxt boldtxt clr1"> New photos not found </font></td></tr></table>';
	} else {
		$varContent		.= '<br><tr><td colspan="8" align="center" style="padding-bottom:10px"><input type="submit" class="button" value="Submit" name="submit">&nbsp&nbsp<input type="button" onclick = clearRadio(); value="Clear" name="clear" class="button"></td></tr></table></form>';
		echo $varContent;
	}
	
}
?>
<script>
function validate(){
	var select = 0;
	var chk = 0;
	var r = document.getElementsByTagName('input');   
        for (var i = 0, n; n = r[i]; i++) {   
            if (n.type == 'radio' && n.checked == true)  {   
                select = 1;
				break;
            }  
       }  
	   if(select == 0){
		alert("Please select the photos that you wish to Add / Delete.");
		return false;
	   }
	   for (var i = 0, n; n = r[i]; i++) {   
            if (n.type == 'radio' && n.checked == true && (n.value.search(/del/) > 1))  { 
				var splitval = n.name.split("_");
				txtname = splitval[1];	
				if((document.getElementById(txtname).value) == ""){
					chk = 1;
					alert("Please enter the reason for delete");
					document.getElementById(txtname).focus();					
					return false;
					break;
				}			
            }  
       }  
	   if(chk == 0 ){
		   return true;
	   } else {
			return false;
	   }
 }
 function clearRadio() {       
        var r = document.getElementsByTagName('input');   
        for (var i = 0, n; n = r[i]; i++) {   
            if (n.type == 'radio') {   
                n.checked = false;   
            }  
        }   
 }
 function enable_reason(radname){
	//alert(radname);
	//alert("document.getElementById("+radname+").style.visibility");
	document.getElementById(radname).style.visibility='visible';
}
</script>