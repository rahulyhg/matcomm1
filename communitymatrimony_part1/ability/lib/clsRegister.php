<?php
#============================================================================================================
# Author 		: S Rohini , A.Baskaran and N.Jeyakumar
# Start Date	: 10 Jul 2008
# End Date		: 10 Jul 2008
# Project		: MatrimonialProduct
# Module		: Register Class
#============================================================================================================
//FILE INCLUDES
include_once($varRootBasePath."/lib/clsDB.php");

class clsRegister extends DB
{
	//FOR HEIGHT CALCULATION
	function calculateHeight($argHeightFt,$argHeightCms)
	{
		if (($argHeightFt > 0)&&(strlen($argHeightFt) > 0)) {
			## Height entered in Feet.. convert to Cms and store
			$funHtArr	 = split('[\-]',$argHeightFt);
			$funFeet	 = $funHtArr[0]*30.48;
			$funInches	 = $funHtArr[1]*2.54;
			$retHeightFt = $funFeet+$funInches;
		} elseif (($argHeightCms > 0)&&(strlen($argHeightCms) > 0)) {
			$retHeightFt = $argHeightCms;
		} else { $retHeightFt = ''; }
		return $retHeightFt;
	}
	#----------------------------------------------------------------------------------------------------------
	//CALCULATE HOW MANY NO OF TIMES EMAILS USED FOR A GENDER
	function blockedEmail($argEmail,$argBlockedFile)
	{
		$blockedalready = 0;
		$blockedarray = file($argBlockedFile);
		for($i=0;$i<count($blockedarray);$i++)
		{
			if(trim($argEmail) == trim($blockedarray[$i])) {
				$blockedalready = 1; //given id exist in the blocked ids list.
				break;
			}
		}
		if($blockedalready == 1)
			return 'yes';
		else
			return 'no';

	 }//blockedEmail

	#-----------------------------------------------------------------------------------------------------

	//GET IP ADDRESS
	function getIPAddress()
	{
		if (getenv(HTTP_X_FORWARDED_FOR)) { $funIPAAddress = getenv(HTTP_X_FORWARDED_FOR); } //if
		else { $funIPAAddress = getenv(REMOTE_ADDR); }//else
		$retIPAAddress = $funIPAAddress;

		return $retIPAAddress;
	}//getIPAddress
	#----------------------------------------------------------------------------------------------------------
	//GET YEARS
	function getYears($Year)
	{
		$varEndYear	= (date("Y") - 18);
		$varStartYear	= ($varEndYear - 53);
		for ($i=$varEndYear;$i>=$varStartYear;$i--)
		{
			$funSelectedValue=$Year==$i ? "selected" : "";
			$funDisplay .= '<option value="'.$i.'" '.$funSelectedValue.'>'.$i.'</option>';
		}//for
		$retValues = $funDisplay;
		return $retValues;
	}//getYears

	#------------------------------------------------------------------------------------------------------------
}
?>