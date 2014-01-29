<?
#================================================================================================================
   # Author 		: Jeyakumar
   # Date			: 25-Mar-2009
   # Project		: MatrimonyProduct
   # Filename		: horoscopeadmin.php
#================================================================================================================
   # Description	: Display the horoscope for validation
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath."/lib/clsDB.php");;
//SESSION VARIABLES
//Object initialization
$objSlaveDB			= new DB;
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<? 
include_once("adminheader.php"); 

$varPassedId		= trim($_POST["ID"]);

$varQueryCondition	= '';
$varNoProfile		= 'no';


if($varPassedId != '') {
	$varFields			= array('User_Name','MatriId');
	$varCondition		= " WHERE  MatriId='".$varPassedId."'";
	$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], $argPrimary='MatriId', $varCondition);
	
	if ($varTotRecords == 1) {
		$varQueryCondition	= " AND b.MatriId='".$varPassedId."'";
	} else {
		$varCondition		= " WHERE  User_Name='".$varPassedId."'";
		$varTotRecords		= $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], $argPrimary='MatriId', $varCondition);
		if ($varTotRecords == 1) {
			$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
			$varSelectLoginInfo	= mysql_fetch_assoc($varResult);
			$varQueryCondition	= " AND b.MatriId='".$varSelectLoginInfo['MatriId']."'";
		} else {
			//Profile not found
			$varNoProfile	= 'yes';
		}
	}
} else {
	//$varMatriId			= $_GET['matriid'];
	$varGender			= (trim($_GET['gender']) == 'M' )? 1:2;
	$varPaidStatus		= (trim($_GET['entrytype']) == 'R')? 1: (($_GET['entrytype'] == 'F')? 0:'0,1');
	if (isset($_GET['matriid']) && trim($_GET['matriid'])!='')
	echo "Below Record is of Matrimonial ID : ".trim($_GET['matriid'])."     ".$id_type_str1;

	if (isset($varPaidStatus) && trim($varPaidStatus)=='2')
	$varUserType1 =" Free Membership";

	if (isset($varPaidStatus) && trim($varPaidStatus)=='1')
	$varUserType1 =" Paid Membership";

	if ($varGender==1)
	$varUserType2=" Male Profile";

	if ($varGender==2)
	$varUserType2=" Female Profile";
	
	if ( trim($varPaidStatus) != 'ALL') 
		$varQueryCondition		.= " AND Paid_Status IN  (".$varPaidStatus.")";
	if ($varGender !='' && $varGender !='ALL') 
		$varQueryCondition		.= " AND  Gender = ".trim($varGender);
}

if($varNoProfile == 'no') {
	$varQuery = "SELECT Count(a.MatriId) AS TOTAL FROM ".$varTable['MEMBERPHOTOINFO']." a, ".$varTable['MEMBERINFO']." b WHERE a.MatriId = b.MatriId AND CommunityId=2002 AND  HoroscopeStatus IN (0,2) AND HoroscopeURL <> '' AND a.Horoscope_Date_Updated > '0000-00-00 00:00:00'  ".$varQueryCondition;
	
	$varResult			 = mysql_query($varQuery,$objSlaveDB->clsDBLink);
	$arrTotal			 = mysql_fetch_assoc($varResult);
	$varTotalRecords	 = $arrTotal['TOTAL'];

	if($varPassedId == '') {
		if ($varUserType1!='' or $varUserType2!='')
			echo "<div style='padding-left:60px;'>Below Records type :".$varUserType1." Of ".$varUserType2."</div><br><br>";

		echo  "<div style='padding-left:60px;'>Total number of horoscopes pending for validation <font  class=\"mediumtxt boldtxt clr1\">".$varTotalRecords."</font></div>";
	}
	echo '<body onload="clearRadio();"><form id="frmhorovalidation" name="frmhorovalidation" method="post" onsubmit="return validate();" action="'.$confValues['IMAGEURL'].'/admin/horoscopevalidation/adminhoroscopeapprove.php"><table width="920" border="0" cellpadding="0" cellspacing="0" align="center" class="formborder"><tr class="adminformheader">
		<td align="center" style="padding-left:5px;" width="5%">S.No</td>
		<td align="center" width="10%"> Username</td>
		<td align="center" width="6%">Add</td>
		<td align="center" width="10%">MatriId</td>
		<td align="center" width="10%">Gender</td>
		<td align="center" width="6%">delete</td>
		<td align="center" width="33%">Reason for delete</td>
		<td align="center" width="10%">View</td>
	</tr>';

	if($varTotalRecords > 0){

		$varCount		= 0;
		$varRowCountt	= 0;
		$varContent		= '';
		$varQuery = "SELECT A.MatriId,A.Name,A.Gender,A.User_Name,A.Paid_Status,b.HoroscopeStatus,HoroscopeURL,HoroscopeDescription  FROM  ".$varTable['MEMBERPHOTOINFO']." b, ".$varTable['MEMBERINFO']." A  WHERE A.MatriId = b.MatriId AND CommunityId=2002 AND (HoroscopeStatus IN (0,2) AND HoroscopeURL <> '') AND   b.Horoscope_Date_Updated >  '0000-00-00 00:00:00'  ".$varQueryCondition." ORDER BY b.Horoscope_Date_Updated  LIMIT 0,20  ";
		//echo $varQuery;
		$varResult		=  mysql_query($varQuery,$objSlaveDB->clsDBLink);
	
		while($row = mysql_fetch_assoc($varResult)){	
				//Get Folder Name for corresponding MatriId
				$varPrefix			= substr($row['MatriId'],0,3);
				$varFolderName		= $arrFolderNames[$varPrefix];

				$varPendingHRPath	= $varRootBasePath."/www/pending-horoscopes/".$varFolderName.'/';

				if (($row['HoroscopeStatus'] == 0 || $row['HoroscopeStatus'] == 2) && trim($row['HoroscopeURL']) != '') {

					if (file_exists($varPendingHRPath.$row['HoroscopeURL'])){
						//print "<br>".$row['MatriId'];
						$varCount++;
						$varContent	.= "<tr>
								<td align='center' class='smalltxt' >".$varCount."</td>
								<td align='center' class='smalltxt' >".$row['User_Name']."</td>
								<td align='center'>
									<input class='frmelements' type=radio ".$disabled."  name=horoadddelete_".$varCount."   value='".$row['MatriId']."_".$i."_add'  >
									<input type='hidden' name='imagename".$varCount."' value='". $row['HoroscopeURL']."'  ></td>";
						$varContent	.= "<td align='center'><a class='smalltxt clr1' target='_blank' 		href=".$confValues['IMAGEURL']."/admin/horoscopevalidation/adminshowhoroscope.php?MATRIID=".$row["MatriId"]."&num=".$i.">".$row['MatriId']."</a></td>";
						$varContent	.= "<td align='center' class='smalltxt'>".(($row['Gender'] == 1)?'Male':'Female')."</td>";
						$varContent	.= "<td align='center'><INPUT  class='frmelements' type=radio  name=horoadddelete_".$varCount."  value=".$row['MatriId']."_".$i."_del  onclick=javascript:document.getElementById('".$varCount."').style.visibility='visible'; >  </td>";
						$varContent	.= '<td align="center"><TEXTAREA  cols=30  name="reason_'.$varCount.'" id="'.$varCount.'" style="visibility:hidden"/></textarea></td><td align="center"><a href=javascript:;  onclick=javascript:window.open("adminshowhoroscope.php?MATRIID='.$row['MatriId'].'&PNO=1","viewphoto","height=600,width=800,scrollbars=yes"); class="smalltxt clr1">View</a>';
						$varContent	.= '<input type="hidden" name="name'.$varCount.'" value ='.$row["Name"].'" ><input type="hidden" name="paidstatus_'.$varCount.'" value ='.$row["Paid_Status"].'" > </td></tr><tr><td height="5" colspan="8"></td></tr><tr class="viewinfsepline"><td colspan="8" valign="top" width="10" height="1"><img src="'.$confValues["IMGSURL"].'/trans.gif" width="100%" height="1"></td></tr><tr><td height="5" colspan="8"></td></tr>';
						//print "<br>COUNT :".$varCount;

					}
				}
				if ($varCount == 20)
				break;
		}
		$varContent		.= '<br><tr><td colspan="11" align="center" style="padding-right:10px">&nbsp;&nbsp;</td></tr><tr><td colspan="12" align="center" style="padding-right:10px"><input type="submit" class="button" value="Submit" name="submit">&nbsp&nbsp<input type="button" onclick = clearRadio(); value="Clear" name="clear" class="button"></td></tr></table></form>';
	}else {
		$varContent		.= '<tr><td height="5" colspan="8" align="center">There is no profile</td></tr></table>';
	}
} else {
	$varContent		.= '<tr><td height="5" colspan="8" align="center"></td></tr><tr><td height="5" colspan="8" align="center"></td></tr><tr><td height="5" colspan="8" align="center"><font class="smalltxt boldtxt clr1">Profile not found</font></td></tr><tr><td height="5" colspan="8" align="center"></td></tr><tr><td height="5" colspan="8" align="center"></td></tr></table>';
}
echo $varContent;
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
		alert("Please select the horoscopes that you wish to Add / Delete.");
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
	document.getElementById(radname).style.visibility='visible';
}
</script>