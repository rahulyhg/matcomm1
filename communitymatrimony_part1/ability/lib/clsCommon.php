<?php
#============================================================================================================
# Author 		: S Rohini , A.Baskaran and N.Jeyakumar
# Start Date	: 10 Jul 2008
# End Date		: 10 Jul 2008
# Project		: MatrimonialProduct
# Module		: Common Class
#============================================================================================================
class clsCommon
{
	//FOR Subcaste, Caste
	function changingArray($argArray){
		unset($argArray[9997]);
		unset($argArray[9999]);
		if($argArray[9998] == 'Don\'t wish to specify'){$argArray[9998]= 'Not specified';}
		return $argArray;
	}

	//FOR VALIDATION PURPOSE
	function validateInput($argValue, $argPatternType)
	{
		if($argValue != ''){
		switch($argPatternType)
		{
			case 'numeric':	  $funRgExpPat = "/^[0-9]+$/"; break;
			case 'joinArray': $funRgExpPat = "/^[0-9\~]+$/"; break;
			case 'alphabet':  $funRgExpPat = "/^[a-z A-Z]+$/"; break;
			case 'date':	  $funRgExpPat = "/^[1-2][0-9]{3}[\-][0-1][0-9][\-][0-3][0-9]$/"; break;
			case 'float':	  $funRgExpPat = "/^[0-9]+[\.]?[0-9]+$/"; break;
			case 'username':  $funRgExpPat = "/^[a-z A-Z][a-z A-Z 0-9 \_]+$/"; break;
			case 'email':	  $funRgExpPat = "/^[a-z A-Z 0-9][a-z A-Z 0-9 \_ \. \-]+\@[a-z A-Z 0-9]+\.[a-z A-Z]+[\.]?[a-z A-Z]+$/"; break;
		}

		if (is_array($argValue)){
		foreach($argValue as $argSingleValue){
			if($argSingleValue!='' && !preg_match($funRgExpPat , $argSingleValue))
			{ echo '<script>document.location.href="index.php?act=invalid-input"</script>';exit;}//if
		}//foreach
		}//if
		else
		{
			if(!preg_match($funRgExpPat , $argValue))
			{ echo '<script>document.location.href="index.php?act=invalid-input"</script>';exit;}//if
		}
		}//if
		return $argValue;
	}//validateInput
	
	//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
	function getValuesFromArray($argArrName, $argNullOptionName, $argNullOptionValue, $argSelectedValue)
	{
		$funOptions	="";
		if($argNullOptionName !="")
		{ 
			$funSelectedItem = ($argSelectedValue=='' || $argSelectedValue == '0') ? "selected" : "";
			$funOptions .= '<option value="'.$argNullOptionValue.'" '.$funSelectedItem.'>'.$argNullOptionName.'</option>'; 
		}//if
		foreach($argArrName as $funIndex => $funValues)
		{
			$funSelectedItem = ($argSelectedValue!='' && $argSelectedValue==$funIndex) ? "selected" : "";
			$funOptions .= '<option value="'.$funIndex.'" '.$funSelectedItem.'>'.$funValues.'</option>';
		}//for

		echo $funOptions;

	}//getValuesFromArray
	
	
	//GENERATE OPTIONS FOR RATIO BUTTON/
	function displayRadioOptions($argArrName,$argFieldName,$argSelectedValue,$argclass,$argFunction,$tabIndex) {

		$funRadioOptions	= '';
		foreach($argArrName as $funIndex => $funValues) {
		$funChecked='';
		if($argSelectedValue == $funIndex) { $funChecked='CHECKED'; }
		$funRadioOptions	.= '<input type="radio" name="'.$argFieldName.'" '.$funChecked.' class='.$argclass.' value="'.$funIndex.'" '.$argFunction.' tabindex="'.$tabIndex.'"> '.$funValues;
		$tabIndex++;
		}//for
		echo $funRadioOptions;

	}//displayRadioOptions
	

    //GENERATE OPTIONS FOR RATIO BUTTON/
	function displayRadioOptionsForEmployedIn($argArrName,$argFieldName,$argSelectedValue,$argclass,$argFunction,$tabIndex) {

		$funRadioOptions	= '';
		foreach($argArrName as $funIndex => $funValues) {
		$funChecked='';
		if($argSelectedValue == $funIndex) { $funChecked='CHECKED'; }
		$funRadioOptions	.= '<input type="radio" name="'.$argFieldName.'" '.$funChecked.' class='.$argclass.' value="'.$funIndex.'" '.$argFunction.' tabindex="'.$tabIndex.'"> '.$funValues."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$tabIndex++;
		}//for
		echo $funRadioOptions;

	}//displayRadioOptions


	//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
	function displaySelectedValuesFromArray($argArrName,$argSelectedValue)
	{
		$funArrSelectedValue = explode("~", $argSelectedValue);
		foreach($argArrName as $funIndex => $funValues)
		{
			if (in_array($funIndex, $funArrSelectedValue))
			{ $funOptions .= '<option value="'.$funIndex.'" '.$funCheckSelectedValue.' selected>'.$funValues.'</option>';}
		}//for
		echo $funOptions;

	}//displaySelectedValuesFromArray
	
	//CALCULATE FROM DOB
	function ageCalculate($argYear, $argMonth, $argDay)
	{
		$funConvertTimeStamp = mktime(0,0,0, $argMonth, $argDay, $argYear);
		$funGetToday		= date("U");
		$funSubtract		= $funGetToday - $funConvertTimeStamp;
		$funYearsRemainder	= $funSubtract%31536000;
		$funRawYears		= $funSubtract-$funYearsRemainder;
		$funYears			= $funRawYears/31536000;
		$funMonthsRemainder	= $funYearsRemainder%2628000;
		$funRawMonths		= $funYearsRemainder-$funMonthsRemainder;
		$funMonths			= $funRawMonths/2628000;
		$funDaysRemainder	= $funMonthsRemainder%86400;
		$funRawDays			= $funMonthsRemainder-$funDaysRemainder;
		$funDays			= $funRawDays/86400;
		$retAge				= $funYears;
		return $retAge;
	}//ageCalculate
	
	//CALCULATE DATE DIFFERENCE
	function dateDiff($argDateSeparator, $argCurrentDate, $argPaidDate)
	{
		$funArrPaidDate		= explode($argDateSeparator, $argPaidDate);
		$funArrCurrentDate	= explode($argDateSeparator, $argCurrentDate);
		$funStartDate		= gregoriantojd($funArrPaidDate[0], $funArrPaidDate[1], $funArrPaidDate[2]);
		$funEndDate			= gregoriantojd($funArrCurrentDate[0], $funArrCurrentDate[1], $funArrCurrentDate[2]);

		return $funEndDate - $funStartDate;
	}//dateDiff
	
	//GET LAST LOGIN INFORMATION - by day/week
	function getLastLoginInfoCommon($argLastLogin,$argTimeCreated,$argMatriId)
	{

		if($argMatriId!="" && $this->checkMemOnlineCommon($argMatriId,$argLastLogin,$argTimeCreated)=="Y")
			return "NOW";

		if($argLastLogin=="0000-00-00 00:00:00")
			$lst = split('[- :]',$argTimeCreated);
		else
			$lst = split('[- :]',$argLastLogin);


		$funCurrenttime = time();
		$funDifftime	= $funCurrenttime - strtotime(date("d-M-Y H:i", mktime($lst[3],$lst[4],0,$lst[1],$lst[2],$lst[0])));
		$funDays		= $funDifftime/(24*3600);

		if($funDays <= 1) {
			$funHours = $funDifftime/3600;
			if($funHours < 1) {
				if(floor($funDifftime/60) <= 1)
					return "NOW";
				else
					return floor($funDifftime/60)." minutes";
			}else {
				if(floor($funDifftime/3600) <= 1)
					return "1 hour";
				else
					return floor($funDifftime/3600)." hours";
			}
		}
		else if($funDays > 1 && $funDays <= 7) {
			if(floor($funDays) <= 1)
				return floor($funDays)." day";
			else
				return floor($funDays)." days";
		}
		else if($funDays > 7 && $funDays <= 30) {
			if(floor($funDays/7) <= 1)
				return floor($funDays/7)." week";
			else
				return floor($funDays/7)." weeks";
		}
		else if($funDays > 30 && $funDays <= 90) {
			if(floor($funDays/30) <=1)
				return floor($funDays/30)." month";
			else
				return floor($funDays/30)." months";
		}
		else
			return "3 months";

	}//getLastLoginInfo
	
	function checkMemOnlineCommon($argMatriid,$argLastLogin,$argTimeCreated)
	{
		$funOnline='N';
		if($argLastLogin!='' && $argTimeCreated!='') {

			if($argLastLogin=="0000-00-00 00:00:00")
				$lst = split('[- :]',$argTimeCreated);
			else
				$lst = split('[- :]',$argLastLogin);

			$funCurrenttime = time();
			$funDifftime	= $funCurrenttime - strtotime(date("d-M-Y H:i", mktime($lst[3],$lst[4],0,$lst[1],$lst[2],$lst[0])));
			$funDays		= $funDifftime/(24*3600);


			if($funDays <= 1) {
				$funHours = $funDifftime/3600;
				if($funHours < 1) {
					if(floor($funDifftime/60) <= 1) {
						$funOnline='Y';
					}
				}
			}
		}
		if($funOnline=='N') {
			$funOnlineFilepath = "/home/product/community/www/onlineusers/".$argMatriid.".txt";
			(file_exists($funOnlineFilepath)) ? $funOnline='Y' : $funOnline='N';
		}

		return $funOnline;
	}//checkMemOnline
	
	//GET DATE FORMAT [DATE-MONTH-YEAR]
	function getDateMonthYear($argFormat,$argDateTime,$argOppositeId)
	{
		$retDateValue = date($argFormat,strtotime($argDateTime));
		$funGetMyListInfo	= $this->checkMyListProfiles($argOppositeId);
		$retDateValue .= '&nbsp;&nbsp;'.$funGetMyListInfo;
		return $retDateValue;
	}//getDateMothYear
	
	//GET YEARS
function getYears($Year) {
    global $varFStartAge;
	if($Year=='N') {
		$varEndYear	= date("Y");
		$varStartYear   = ($varEndYear-5);
	} else {
		$varEndYear     = (date("Y") - $varFStartAge);
		$varYearDecrement = ($varFStartAge == 35)?35:52;
		$varStartYear   = ($varEndYear - $varYearDecrement);
	}

	for ($i=$varStartYear;$i<=$varEndYear;$i++) {
		$varChecked	= ($i == $Year)?'selected':'';
		$funDisplay .= '<option value="'.$i.'" '.$varChecked.'>'.$i.'</option>';
	}//for
    
	$retValues = $funDisplay;
	return $retValues;
}//getYears

//get month
function monthDropdown($Month){
	$months = array(1 => 'January',2 => 'February',3 => 'March',4 => 'April',5 => 'May',6 => 'June',7 => 'July',8 => 'August',9 => 'September',10 => 'October',11 => 'November',12 => 'December');

	for ($i = 1; $i <= 12; $i++) {
		$funSelectedValue=$Month==$i ? "selected" :"";
		$funDisplay .= '<option value="'.str_pad($i, 2, "0", STR_PAD_LEFT).'"'.$funSelectedValue.'>'.$months[$i].'</option>';
	}//for
	$retValues = $funDisplay;
	return $retValues;
}//monthDropdown   

function dateDropdown() {
        for ($i=1; $i<=31; $i++){
                $Date=str_pad($i, 2, "0", STR_PAD_LEFT);
                $funDisplay .= '<option value="'.$Date.'">'.$Date.'</option>';
        }//for
        $retValues = $funDisplay;
        return $retValues;
}

	
	//generate string from array string values (1~3~5)
	function getArrayFromString($argGivenString,$argArrName)
	{

		$funArr = explode("~", $argGivenString);
		foreach($funArr as $funIndex => $funValues)
		{
			$funArr[$funIndex] = $argArrName[$funValues];
		}//for
		$funString = implode(", ",$funArr);
		$funString = stripslashes($funString);
		return $funString;

	}

	//generate phono number validate message
   function getPhoneNumberValidationStatus($sessPhoneStatus,$sessPaidStatus) {
    if($sessPhoneStatus == 0 || $sessPhoneStatus == 1 && $sessPaidStatus == 0){
        $varAlertMsg = 'Verify your phone number';
        }
 
    return $varAlertMsg;
  
   }

	function getReligionWithSubcasteOptional($arrReligionListWithSubcasteOptional) {
	?>
	  <script language="javascript"> var religionWithSubcasteOptional=new Array;
      <? $i=0;
	   foreach($arrReligionListWithSubcasteOptional as $key => $value){
		echo "religionWithSubcasteOptional[$i]='".$key."';\n";
	    $i = $i +1;
	  }
	  ?>
     </script>
	<?
   }
}
?>
