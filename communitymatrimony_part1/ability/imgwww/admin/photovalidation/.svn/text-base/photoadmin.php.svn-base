<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		: 
#================================================================================================================
   # Description	: photo class use to resize photo and new photoname
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath."/lib/clsDB.php");
//SESSION VARIABLES
//Object initialization
$objSlaveDB			= new DB;
$varSlaveConn		= $objSlaveDB->dbConnect('M', $varDbInfo['DATABASE']);
//print $varSlaveConn;
?>
<style type="text/css"> @import url("<?=$confValues['CSSPATH'];?>/global-style.css"); </style>
<script>
function passitems()
{
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

$varQueryCondition	= '';
//$varMatriId			= $_GET['matriid'];
$varGender			= (trim($_GET['gender']) == 'M' )? 1:2;
$varPaidStatus		= (trim($_GET['entrytype']) == 'R')?'1' : (($_GET['entrytype'] == 'F')? '0' :'0,1');
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
	$varQueryCondition		.= " AND CommunityId=2002 AND Paid_Status IN  (".$varPaidStatus.")";
if ($varGender !='' && $varGender !='ALL') 
	$varQueryCondition		.= " AND  CommunityId=2002 AND Gender = ".trim($varGender);

$varQuery = "SELECT (SELECT Count(a.MatriId) FROM ".$varTable['MEMBERPHOTOINFO']." a, ".$varTable['MEMBERINFO']." b WHERE a.MatriId = b.MatriId AND  Photo_Status1 IN (0,2) AND Normal_Photo1 <> '' AND Thumb_Small_Photo1 <> '' AND Thumb_Big_Photo1 <> ''  AND a.Photo_Date_Updated > '0000-00-00 00:00:00'  AND b.Publish IN (1,2) ".$varQueryCondition." ) + (SELECT Count(a.MatriId) FROM memberphotoinfo a,memberinfo b WHERE a.MatriId = b.MatriId AND  Photo_Status2 IN (0,2) AND Normal_Photo2 <> '' AND Thumb_Small_Photo2 <> '' AND Thumb_Big_Photo2 <> ''  AND a.Photo_Date_Updated > '0000-00-00 00:00:00' AND b.Publish IN (1,2) ".$varQueryCondition." ) + (SELECT Count(a.MatriId) FROM memberphotoinfo a,memberinfo b WHERE a.MatriId = b.MatriId  AND  Photo_Status3 IN (0,2) AND Normal_Photo3 <> '' AND Thumb_Small_Photo3 <> '' AND Thumb_Big_Photo3 <> ''  AND a.Photo_Date_Updated > '0000-00-00 00:00:00' AND b.Publish IN (1,2) ".$varQueryCondition." ) + (SELECT Count(a.MatriId) FROM memberphotoinfo a,memberinfo b WHERE a.MatriId = b.MatriId AND  Photo_Status4 IN (0,2) AND Normal_Photo4 <> '' AND Thumb_Small_Photo4 <> '' AND Thumb_Big_Photo4 <> ''  AND a.Photo_Date_Updated > '0000-00-00 00:00:00' AND b.Publish IN (1,2) ".$varQueryCondition." ) + (SELECT Count(a.MatriId) FROM memberphotoinfo a,memberinfo b WHERE a.MatriId = b.MatriId AND  Photo_Status5 IN (0,2) AND Normal_Photo5 <> '' AND Thumb_Small_Photo5 <> '' AND Thumb_Big_Photo5 <> ''  AND a.Photo_Date_Updated > '0000-00-00 00:00:00' AND b.Publish IN (1,2) ".$varQueryCondition." ) + (SELECT Count(a.MatriId) FROM memberphotoinfo a,memberinfo b WHERE a.MatriId = b.MatriId AND  Photo_Status6 IN (0,2) AND Normal_Photo6 <> '' AND Thumb_Small_Photo6 <> '' AND Thumb_Big_Photo6 <> ''  AND a.Photo_Date_Updated > '0000-00-00 00:00:00' AND b.Publish IN (1,2) ".$varQueryCondition." ) + (SELECT Count(a.MatriId) FROM memberphotoinfo a,memberinfo b WHERE a.MatriId = b.MatriId AND  Photo_Status7 IN (0,2) AND Normal_Photo7 <> '' AND Thumb_Small_Photo7 <> '' AND Thumb_Big_Photo7 <> ''  AND a.Photo_Date_Updated > '0000-00-00 00:00:00' AND b.Publish IN (1,2) ".$varQueryCondition." ) + (SELECT Count(a.MatriId) FROM memberphotoinfo a,memberinfo b WHERE a.MatriId = b.MatriId AND  Photo_Status8 IN (0,2) AND Normal_Photo8 <> '' AND Thumb_Small_Photo8 <> '' AND Thumb_Big_Photo8 <> ''  AND a.Photo_Date_Updated > '0000-00-00 00:00:00' AND b.Publish IN (1,2) ".$varQueryCondition." ) + (SELECT Count(a.MatriId) FROM memberphotoinfo a,memberinfo b WHERE a.MatriId = b.MatriId AND  Photo_Status9 IN (0,2) AND Normal_Photo9 <> '' AND Thumb_Small_Photo9 <> '' AND Thumb_Big_Photo9 <> ''  AND a.Photo_Date_Updated > '0000-00-00 00:00:00' AND b.Publish IN (1,2) ".$varQueryCondition." ) + (SELECT Count(a.MatriId) FROM memberphotoinfo a,memberinfo b WHERE a.MatriId = b.MatriId AND  Photo_Status10 IN (0,2) AND Normal_Photo10 <> '' AND Thumb_Small_Photo10 <> '' AND Thumb_Big_Photo10 <> ''  AND a.Photo_Date_Updated > '0000-00-00 00:00:00' AND b.Publish IN (1,2) ".$varQueryCondition." ) AS TOTAL";

//print "<br>".$varQuery;
$varResult			 = mysql_query($varQuery,$objSlaveDB->clsDBLink);
$arrTotal			 = mysql_fetch_assoc($varResult);
$varTotalRecords	 = $arrTotal['TOTAL'];

//print "<br> TOTAL :".$varTotalRecords;
if($varTotalRecords > 0){

$varQuery = " SELECT A.MatriId,A.Name,A.Gender,A.User_Name,A.Paid_Status,B.Photo_Status1,B.Photo_Status2,B.Photo_Status3,B.Photo_Status4,B.Photo_Status5,B.Photo_Status5,B.Photo_Status7,B.Photo_Status8,B.Photo_Status9,B.Photo_Status10,Normal_Photo1,Thumb_Small_Photo1,Thumb_Big_Photo1,Normal_Photo2,Thumb_Small_Photo2,Thumb_Big_Photo2,Normal_Photo3,Thumb_Small_Photo3,Thumb_Big_Photo3,Normal_Photo4,Thumb_Small_Photo4,Thumb_Big_Photo4,Normal_Photo5,Thumb_Small_Photo5,Thumb_Big_Photo5,Normal_Photo6,Thumb_Small_Photo6,Thumb_Big_Photo6,Normal_Photo7,Thumb_Small_Photo7,Thumb_Big_Photo7,Normal_Photo8,Thumb_Small_Photo8,Thumb_Big_Photo8,Normal_Photo9,Thumb_Small_Photo9,Thumb_Big_Photo9,Normal_Photo10,Thumb_Small_Photo10,Thumb_Big_Photo10,Description1,Description2,Description3,Description4,Description5,Description6,Description7,Description8,Description9,Description10  FROM  ".$varTable['MEMBERPHOTOINFO']." B, ".$varTable['MEMBERINFO']." A  WHERE A.MatriId = B.MatriId AND A.CommunityId=2002 AND ((Photo_Status1 IN (0,2) AND Normal_Photo1 <> '' AND Thumb_Small_Photo1 <> '' AND Thumb_Big_Photo1 <> '' ) OR (Photo_Status2 IN (0,2) AND Normal_Photo2 <> '' AND Thumb_Small_Photo2 <> '' AND Thumb_Big_Photo2 <> '' ) OR (Photo_Status3 IN (0,2) AND Normal_Photo3 <> '' AND Thumb_Small_Photo3 <> '' AND Thumb_Big_Photo3 <> '' ) OR (Photo_Status4 IN (0,2) AND Normal_Photo4 <> '' AND Thumb_Small_Photo4 <> '' AND Thumb_Big_Photo4 <> '' ) OR (Photo_Status5 IN (0,2) AND Normal_Photo5 <> '' AND Thumb_Small_Photo5 <> '' AND Thumb_Big_Photo5 <> '' ) OR (Photo_Status6 IN (0,2) AND Normal_Photo6 <> '' AND Thumb_Small_Photo6 <> '' AND Thumb_Big_Photo6 <> '' ) OR (Photo_Status7 IN (0,2) AND Normal_Photo7 <> '' AND Thumb_Small_Photo7 <> '' AND Thumb_Big_Photo7 <> '' ) OR (Photo_Status8 IN (0,2) AND Normal_Photo8 <> '' AND Thumb_Small_Photo8 <> '' AND Thumb_Big_Photo8 <> '' ) OR (Photo_Status9 IN (0,2) AND Normal_Photo9 <> '' AND Thumb_Small_Photo9 <> '' AND Thumb_Big_Photo9 <> '' ) OR (Photo_Status10 IN (0,2) AND Normal_Photo10 <> '' AND Thumb_Small_Photo10 <> '' AND Thumb_Big_Photo10 <> '' )) AND   B.Photo_Date_Updated >  '0000-00-00 00:00:00'  AND A.Publish IN (1,2) ".$varQueryCondition." ORDER BY B.Photo_Date_Updated  LIMIT 0,50  ";
//print "<br>".$varQuery;
$varResult			=  mysql_query($varQuery,$objSlaveDB->clsDBLink);


if ($varUserType!='' or $varUserType2!='')
echo "<div style='padding-left:60px;'>Below Records type :".$varUserType1." Of ".$varUserType2."</div><br><br>";

echo  "<div style='padding-left:60px;'>Total number of photos pending for validation <font  class=\"mediumtxt boldtxt clr1\">".$varTotalRecords."</font></div>";
//	<div class="mediumtxt boldtxt clr3">Photo<br clear="all"></div> 

echo '<body onload="clearRadio();"><form id="frmphotovalidation" name="frmphotovalidation" method="post" onsubmit="return validate();" action="'.$confValues['IMAGEURL'].'/admin/photovalidation/adminphotoapprove.php"><table width="920" border="0" cellpadding="0" cellspacing="0" align="center" class="formborder"><tr class="adminformheader"><td align="left" style="padding-left:5px;">S.No</td><td align="left"> Username</td><td align="left">Add</td><td align="left">MatriId</td><td align="left">Gender</td><td align="left"> Photo No</td><td align="left">Crop photo</td><td align="left">Description</td><td align="left">delete</td><td align="left">Reason for delete</td><td align="left">View</td></tr>';
}
$varCount		= 0;
$varRowCountt	= 0;
$varContent	= '';
while ($row = mysql_fetch_assoc($varResult)) {	
		//print "<br>";
		//print_r($row);
		//print "<br>";

		//Get Folder Name for corresponding MatriId
		$varPrefix			= substr($row['MatriId'],0,3);
		$varFolderName		= $arrFolderNames[$varPrefix];

		$varDomainPHPath	= $varRootBasePath."/www/membersphoto/".$varFolderName;	
		$varPhotoBupPath	= $varDomainPHPath."/backup/";
		$varPhotoCrop800	= $varDomainPHPath."/crop800/";
		$varPhotoCrop450	= $varDomainPHPath."/crop450/";
		$varPhotoCrop150	= $varDomainPHPath."/crop150/";
		$varPhotoCrop75		= $varDomainPHPath."/crop75/";
	
		for($i=1;$i<=10;$i++){
			if (($row['Photo_Status'.$i] == 0 || $row['Photo_Status'.$i] == 2) && trim($row['Normal_Photo'.$i]) != '' && trim($row['Thumb_Small_Photo'.$i]) != '' && trim($row['Thumb_Big_Photo'.$i]) != '') {
				
				//if (file_exists($varPhotoCrop75.$row['Normal_Photo'.$i]) && file_exists($varPhotoCrop150.$row['Thumb_Small_Photo'.$i]) && file_exists($varPhotoCrop450.$row['Thumb_Big_Photo'.$i])){
					//print "<br>".$row['MatriId'];
					$varCount++;
					$varContent	.= "<tr><td width='3%' align='center' class='smalltxt' >".$varCount."</td><td width='7%' align='center' class='smalltxt' >".$row['User_Name']."</td><td width='6%' align='center'><input class='frmelements' type=radio ".$disabled."  name=photoadddelete_".$varCount."   value='".$row['MatriId']."_".$i."_add'  ><input type='hidden' name='imagename".$varCount."' value='". $row['Thumb_Big_Photo'.$i]."'  ></td>";
					$varContent	.= "<td width='8%' align='center'><a class='smalltxt clr1' target='_blank' 		href=".$confValues['IMAGEURL']."/admin/photovalidation/adminviewphoto.php?id=".$row["MatriId"]."&num=".$i.">".$row['MatriId']."_".$i."</a></td>";
					$varContent	.= "<td width='6%' align='center' class='smalltxt'>".(($row['Gender'] == 1)?'Male':'Female')."</td>";
					$varContent	.= "<td width='5%' align='center' class='smalltxt' > ".$i."</td><td width='9%' align='center'><a class='smalltxt clr1' target=_blank href=".$confValues['IMAGEURL']."/admin/photovalidation/admincropphoto.php?id=".$row['MatriId']."&num=".$i.">Crop Photo </a></td>";
					$varContent	.= "<td width='12%' align='center'><TEXTAREA name='".$row['MatriId']."_desc_".$i."'  ROWS='2' COLS='75' class=inputtext style=width:175px;>".$row['Description'.$i]."</TEXTAREA></td>";
					$varContent	.= "<td width='5%' align='center'><INPUT  class='frmelements' type=radio  name=photoadddelete_".$varCount."  value=".$row['MatriId']."_".$i."_del  onclick=javascript:document.getElementById('".$varCount."').style.visibility='visible'; >  </td>";
					$varContent	.= '<td align="left"><TEXTAREA   name="reason_'.$varCount.'" id="'.$varCount.'" style="visibility:hidden"/></textarea></td><td width="10%" align="center"><a href=javascript:;  onclick=javascript:window.open("adminshowphoto.php?MATRIID='.$row['MatriId'].'&PNO=1","viewphoto","height=600,width=800"); class="smalltxt clr1">View</a>';
					$varContent	.= '<input type="hidden" name="name'.$varCount.'" value ='.$row["Name"].'" ><input type="hidden" name="paidstatus_'.$varCount.'" value ='.$row["Paid_Status"].'" > </td></tr><tr><td height="5" colspan="12"></td></tr><tr class="viewinfsepline"><td colspan="12" valign="top" width="10" height="1"><img src="http://imgs.jainmatrimony.com/images/trans.gif" width="100%" height="1"></td></tr><tr><td height="5" colspan="12"></td></tr>';
					//print "<br>COUNT :".$varCount;
				//}
				if ($varCount == 50)
					break;
			}
			
		}
		if ($varCount == 50)
					break;
}

if($varTotalRecords>0) {
$varContent		.= '<br><tr><td colspan="11" align="center" style="padding-right:10px">&nbsp;&nbsp;</td></tr><tr><td colspan="12" align="center" style="padding-right:10px"><input type="submit" class="button" value="Submit" name="submit">&nbsp&nbsp<input type="button" onclick = clearRadio(); value="Clear" name="clear" class="button"></td></tr></table></form>';
echo $varContent;
} else {
	echo '<center>There is no records available</center>';
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