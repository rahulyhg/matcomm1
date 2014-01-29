<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-07-31
# End Date		: 2008-07-31
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

//PATH INCLUDES
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/vars.cil14");

$countryselected = trim($_GET["country"]);
if($countryselected != '')
{
	//get the country code
	echo $arrIsdCountryCode[$countryselected];
}
else
{
	//echo 'country code not found';
}
?>