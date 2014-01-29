<?php
//include("stagingpath.php");

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';


//include_once("header.php");
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once("PageNav.php");
include_once("../includes/date_functions.php");
include_once("easypay_arrays.php");

global $adminUserName,$paymentoption_followup_status;

$varTable['OFFERCATEGORYINFO'] = "offercategoryinfo";

if($adminUserName == "")
	header("Location: ../index.php?act=login");


$objSlaveMatri = new DB;

$objSlaveMatri->dbConnect('S',$varDbInfo['DATABASE']);

	$offercategoryid = mysql_real_escape_string($_GET['sid']);
//	$dbslave=getDomainNameSlave($_GET['mid']);
	$matriId = mysql_real_escape_string($_GET['mid']); 
	$selValue = mysql_real_escape_string($_GET['val']);
	$selVal=split(",",$selValue);

//$s1connect= mysql_connect($dbslave[2], 'matriservices', 'services');
//	if (!$s1connect) {   die('Could not connect: ' . mysql_error());}
	
	//get offercategoryinfo
	/*
	 $cat_query="select OfferOfflineMaxDiscount,NextLevelOffer,ExtraPhoneNumbers,DiscountPercentage,AssuredGift,Override from bmoffer.offercategoryinfo where OfferCategoryId=$offercategoryid";
	
	 $cat_result=mysql_query($cat_query,$s1connect);
	
	if(mysql_num_rows($cat_result)>0){
		 $row_cat=mysql_fetch_array($cat_result); 
	*/

/*
$presentDiscountArgs = array('MemberDiscountPercentage');
$presentDiscountCondition = " WHERE MatriId = '".$matriId."'";
$currentDiscountResult = $objSlaveMatri -> select($varTable['OFFERCODEINFO'],$presentDiscountArgs,$presentDiscountCondition,0);
if($objSlaveMatri -> clsErrorCode == "SELECT_ERR")
{
	echo "Database error";
	exit;
}
$currentDiscountRow = mysql_fetch_assoc($currentDiscountResult);

$paymentDetailsColumns = array('Product_Id','Payment_Mode','Payment_Type','Branch_Id');
$paymentCondition = " WHERE matriId = '".$matriId."'";
$paymentResult = $objSlaveMatri -> select($varTable['PAYMENTHISTORYINFO'],$paymentDetailsColumns,$paymentCondition,0);
if($objSlaveMatri -> clsErrorCode		== "SELECT_ERR")
{
	echo "Database Error";
	exit;
}
$pay = mysql_fetch_assoc($paymentResult);

getsplitvaluesnew($disoffer,$productid);
*/
//print_r($_REQUEST[defval]);
$argFields = array('OfferOfflineMaxDiscount','NextLevelOffer','ExtraPhoneNumbers','DiscountPercentage','AssuredGift','Override');
//$argCondition = " WHERE OfferCategoryId = '".$offercategoryid."'";
$argCondition = " WHERE OfferCategoryId = '1'";

if($numrec = $objSlaveMatri->numOfRecords($varTable['OFFERCATEGORYINFO'], 'NextLevelOffer',$argCondition)>0)
{
		
		$cat_result = $objSlaveMatri->select($varTable['OFFERCATEGORYINFO'],$argFields,$argCondition,0);
		 $row_cat=mysql_fetch_array($cat_result);
		 $Override=$row_cat['Override'];
		 $val=getsplitvalues($Override,$selVal[1]);
		 $cond=$val[1];		
		 $overArr2=$val[0];
		
	    $AssuredGift=$row_cat['AssuredGift']; //1
	    $AssVal=getsplitvalues($row_cat['AssuredGift'],$selVal[1]);

	    $DiscountPercentage=$row_cat['DiscountPercentage']; //2
	    $DisPer=getsplitvalues($DiscountPercentage,$selVal[1]);
	
	    $OfferOfflineMaxDiscount=$row_cat['OfferOfflineMaxDiscount']; //
	    $MaxDis=getsplitvalues($OfferOfflineMaxDiscount,$selVal[1]);		 
		 
	    $NextLevelOffer=$row_cat['NextLevelOffer']; //3
	    $NextLelOff=getsplitvalues($NextLevelOffer,$selVal[1]);		 

		$ExtraPhoneNo=$row_cat['ExtraPhoneNumbers']; //4
		$ExtraPhNo=getsplitvalues($ExtraPhoneNo,$selVal[1]);		 

//---------------------------------------------------------------------------------------------------------------
function one($nexpack,$nexpacknew,$first,$last){
			global $overArr2,$AssVal,$AGFcond,$AssuredGift,$OFFERGIFTARRAY,$cond,$newCondvalue;
			if($first==1) { $check="checked";}
			if($last==1) { $dis="disabled";}
	
			if(count($OFFERGIFTARRAY)==0) {
//				$hidden="style='display:none'";
			}
			else { 

		 $lastcount = count($AssVal[0]); 
		if(($overArr2[0]==1 || $overArr2[1]==1)&&($lastcount>0)) {	
			$returnvalue .= $newCondvalue;
			$returnvalue .= "<INPUT TYPE='hidden' value='$AssuredGift' name='AssuredGift'>";
		
			$returnvalue .= " <tr class='mediumtxt' $hidden><td width='153'>Assured Gift</td><td colspan='4'>";
			if(is_array($AssVal))
			{
				for($i=0;$i<count($AssVal[0]);$i++){
					$tmp = $AssVal[0][$i];
					if($AssVal[1]=="OR"){  $AGFcond='#';
							$returnvalue .= "<INPUT TYPE='radio' NAME='assured' id='assured".$i."' value='$tmp'";
							if($i==0) { $returnvalue .= $check; }
							$returnvalue .= " $dis>".$OFFERGIFTARRAY[$tmp]."&nbsp;&nbsp;&nbsp;";
					}
					if($AssVal[1]=="AND"){ $AGFcond='&';
						$returnvalue.= "<INPUT TYPE='checkbox' NAME='assured[]' id='assured".$i."' value='$tmp'";
						$returnvalue.=" checked $dis>".$OFFERGIFTARRAY[$tmp]."&nbsp;&nbsp;&nbsp;";
					}
				}
			}
			else
			{
				for($i=0;$i<count($AssVal);$i++){
					$tmp = $AssVal[$i];
					if($AssVal[1]=="OR"){  $AGFcond='#';
							$returnvalue.="<INPUT TYPE='radio' NAME='assured' id='assured".$i."' value='$tmp'";
							if($i==0) { $returnvalue.=$check; }
							$returnvalue.=" $dis>".$OFFERGIFTARRAY[$tmp]."&nbsp;&nbsp;&nbsp;";
					}
					if($AssVal[1]=="AND"){ $AGFcond='&';
						$returnvalue.= "<INPUT TYPE='checkbox' NAME='assured[]' id='assured".$i."' value='$tmp'";
						$returnvalue.=" checked $dis>".$OFFERGIFTARRAY[$tmp]."&nbsp;&nbsp;&nbsp;";
					}
				}
			}
				$returnvalue.="<INPUT TYPE='hidden' value='$AGFcond' name='AssuredGiftCond'>";
				$returnvalue.="<INPUT TYPE='hidden' value=".$lastcount." name='Asslast' id='Asslast'>";
				
				$returnvalue.=$nexpack."".$nexpacknew."</td></tr>";
			}
		}
		return $returnvalue;
	}
//---------------------------------------------------------------------------------------------------------------
		function two($nexpack,$nexpacknew,$first,$last) {
		if($first==2) { $check="selected"; }	
		if($last==2) { $dis="disabled";}
		
			global $overArr2,$DisPer,$MaxDis,$DiscountPercentage,$OfferOfflineMaxDiscount,$cond,$newCondvalue;
		if(($overArr2[0]==2 || $overArr2[1]==2)&&($DisPer[0]>0)){
			$returnvalue.=$newCondvalue;	
			$returnvalue.="<INPUT TYPE='hidden' value='$DiscountPercentage' name='DiscountPercentage'>";
			$returnvalue.="<INPUT TYPE='hidden' value='$OfferOfflineMaxDiscount' name='OfferOfflineMaxDiscount'>";
			$returnvalue.="<tr class='mediumtxt'><td width='153' valign='top'>Discount Percentage</td><td ><select name='disPre' id='disPre'  class='mediumtxt' $dis>";
			//$returnvalue.="<option value='0'>--Select--</option>"; 
			if($DisPer[0]<$MaxDis[0]) { $val=$MaxDis[0]; } else { $val=$DisPer[0];} 
			for($i=$DisPer[0];$i<=$val;$i++)
			{ 
				$returnvalue.="<option value='$i'"; 
				//if($i == $DisPer[0]) { $returnvalue .= $check; }
				if($i == $_REQUEST[defval]) { $returnvalue .= " selected "; }
				
				//$returnvalue.=">".$i."% $check : $DisPer[0] : $i </option>";
				$returnvalue.=">".$i."%</option>";
			}
			$returnvalue.="</select> Max DisCount:$val&nbsp;%&nbsp;&nbsp;".$nexpacknew."</td></tr> ";
			//$nexpack='';

		}
		return $returnvalue;
	}
//---------------------------------------------------------------------------------------------------------------				
	 function three($nexpack,$nexpacknew,$first,$last){

	 if($first==3) { $check="checked"; }		
	 if($last==3) { $dis="disabled";}	
	 global $overArr2,$package,$NextLelOff,$NextLevelOffer,$NextLelOff,$newCondvalue;

		if(($overArr2[0]==3 || $overArr2[1]==3)&&($NextLelOff[0]!='')){	
			$returnvalue.=$newCondvalue;
			$returnvalue.="<tr class='mediumtxt'><td width='153' valign='top'>NextLevel Offer</td><td ><INPUT TYPE='checkbox' NAME='nextLvlOff' id='nextLvlOff' $check $dis value=1>&nbsp;".$package[$NextLelOff[0]]['name']."&nbsp;&nbsp;".$nexpack."".$nexpacknew."</td></tr>";
			$returnvalue.="<INPUT TYPE='hidden' value='$NextLevelOffer' name='NextLevelOffer'>";
			$returnvalue.="<INPUT TYPE='hidden' value='$NextLelOff[0]' name='nextOffer'>";
		//$nexpack='';
		}
		return $returnvalue;
	 }
	 
 function four($nexpack,$nexpacknew,$first,$last){

	 if($first==4) { $check="checked"; }		
	 if($last==4) { $dis="disabled";}	
	 global $overArr2,$ExtraPhNo,$ExtraPhoneNo,$newCondvalue;
		if(($overArr2[0]==4 || $overArr2[1]==4)&&($ExtraPhoneNo!='')){	
		$returnvalue.=$newCondvalue;
		$returnvalue.="<tr class='mediumtxt'><td width='153'>&nbsp;<B>".$ExtraPhNo[0]."</B> Extra Phone Numbers</td><td ><INPUT TYPE='checkbox' NAME='exPhNo' id='exPhNo' $check $dis value=1>&nbsp;&nbsp;".$nexpack.$nexpacknew."</td></tr>";
		$returnvalue.="<INPUT TYPE='hidden' value='$ExtraPhoneNo' name='ExtraPhoneNo'>";
		$returnvalue.="<INPUT TYPE='hidden' value='$ExtraPhNo[0]' name='ExtraPhNo'>";
		//$nexpack='';
		}
		return $returnvalue;
	 }
	 
	$newreturnvalue='';

	$newcount=1;
	$packsend='All';

	if(!is_array($overArr2)){
	if($overArr2==1) { $packsend.=",assured-array";  }
		if($overArr2==2) { $packsend.=",disPre";  }
		if($overArr2==3) { $packsend.=",nextLvlOff";  }
		if($overArr2==4) { $packsend.=",exPhNo";  }
	switch($overArr2) {
		//case 1:
		//	  $newreturnvalue.=one($nexpack,$nexpacknew,$first,$last);
		//	break;
		case 2:
			  $newreturnvalue.=two($nexpack,$nexpacknew,$first,$last);
			break;
		case 3:
			 $newreturnvalue.=three($nexpack,$nexpacknew,$first,$last);
			break;
		case 4:
			 $newreturnvalue.=four($nexpack,$nexpacknew,$first,$last);
			break;
		}

	}else{
		foreach($overArr2 as $key=>$value) {
		if($value==1) { $packsend.=",assured-array";  }
		if($value==2) { $packsend.=",disPre";  }
		if($value==3) { $packsend.=",nextLvlOff";  }
		if($value==4) { $packsend.=",exPhNo";  }
		}
	}	

	 foreach($overArr2 as $overr2 =>$overArr2value) {
		 if(((count($OFFERGIFTARRAY)==0) && (!in_array("1",$overArr2))) || (count($OFFERGIFTARRAY)!=0))
		 {

			if($newcount==2)
			{
					$newCondvalue=" <tr class='mediumtxt'><td width='153' colspan=2><font color='red'>".$cond."</font><INPUT TYPE='hidden' value='$cond' name='condor'></td><td>";
			
				if($cond=="AND")
				{ //$nexpack="<font color='red'>You are also eligible to this Offer</font>"; 
				}
				if($cond=="OR")
				{ 
					$nexpacknew="<br><font color='red'><input type='checkbox' name='nextpack' id='nextpack' onclick='disableanyone(this.value);' value='$packsend'>&nbsp;&nbsp;Click to enable Other Offer</font>"; 
					$last=$overArr2value;
				}
			}
		}
		if($newcount==1) { 	$first=$overArr2value;	}
	
		$newcount++;
		
		switch($overArr2value) {
		//case 1:
		//	  $newreturnvalue.=one($nexpack,$nexpacknew,$first,$last);
		//	break;
		case 2:
			  $newreturnvalue.=two($nexpack,$nexpacknew,$first,$last);
			break;
		case 3:
			 $newreturnvalue.=three($nexpack,$nexpacknew,$first,$last);
		case 4:
			 if($newcount != 2)
			 {
				 $newreturnvalue.=four($nexpack,$nexpacknew,$first,$last);
			 }
			break;
		}
		
		}
		if($newreturnvalue!=''){
		$newreturnvalue.="<tr height=10><td class='mediumtxt'><font color='#FF0000' face='Arial, Helvetica, sans-serif' size='-1'><b>Send Mail</b></font></td><td colspan=3 class='mediumtxt'>Cust Name:&nbsp;<input type='text' id='Came' name='CName' size=10 class='inputtext'>";

		$newreturnvalue.="<br><br>&nbsp;Valid from :&nbsp;<input type='text' id='fromdate' name='fromdate' value=".date('Y-m-d')." readonly  size=10 class='inputtext'>&nbsp;";
	$expdatee = date('Y-m-d') + 3;

$date = date("Y-m-d");
$newdate = strtotime ( '+3 day' , strtotime ( $date ) ) ;
$expdatee = date ( 'Y-m-d' , $newdate );


		$newreturnvalue.="<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid till :&nbsp;<input type='text' id='expdate' name='expdate' value=".$expdatee." readonly class='inputtext'  size=10 onClick='displayDatePicker(\"expdate\", \"\", \"ymd\", \"-\");' onBlur='datePickerClosed(\"expdate\",this.value);' HIDEFOCUS>&nbsp;";
		$newreturnvalue.="</td></tr>";

		$newreturnvalue.="<tr class='mediumtxt'><td class='mediumtxt'>confirm the offer</td>
		<td class='mediumtxt' colspan=2><input type='checkbox' name='confirms' id='confirms' value=1></td></tr>";
		}

		$newreturnvalue="<table  style='border: 1px solid #4A84AD;' width='90%' align='center'>".$newreturnvalue; 
		$newreturnvalue.="<INPUT TYPE='hidden' value='$offercategoryid' name='Offercatid'>";
		$newreturnvalue.= "</table>";
	}
//---------------------------------------------------------------------------------------------------------------
if(trim($newreturnvalue)!='') {
echo $newreturnvalue;
} else { echo $newreturnvalue="<center><font color='red' class='smalltxt'>No Offer Available for This Package</font><center>"; }
//---------------------------------------------------------------------------------------------------------------
function getsplitvalues($Override,$selValue)
{ 
$overArr=explode("|",$Override);
			 for($i=0;$i<count($overArr);$i++)
			 {   
				$overArr1=explode("~",$overArr[$i]);
				 if($overArr1[0]==$selValue){
					 if(strrchr($overArr1[1], '&')==TRUE){
						$overArr2=explode("&",$overArr1[1]);
						$spl="AND";
					}elseif(strrchr($overArr1[1], '#')==TRUE){
						$overArr2=explode("#",$overArr1[1]);
						$spl="OR";
					}else{
					$overArr2=$overArr1[1];
					}
				
				}
			  
			 }
$val[0]=$overArr2;
$val[1]=$spl;
return $val;
}
//---------------------------------------------------------------------------------------------------------------

function getsplitvaluesnew($disoffer,$productid)
{
	/*
	$discount=explode("|",$disoffer);
$Disfirst=explode("~",$discount[0]);
$Finaldis=$Disfirst[1];
return $Finaldis;
*/

	$discount=explode("|",$disoffer);
	$discountcount = count($discount);
	$i = 0;
	do
	{
		$productidequate = explode("~",$discount[$i]);
		if($productid == $productidequate[0])
		{
			return $productidequate[1];
		}
		$i++;
	}while($i < $discount);
return "null";

}
?>
