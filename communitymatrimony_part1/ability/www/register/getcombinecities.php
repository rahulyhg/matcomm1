<?php
#=============================================================================================================
# Author 		: M Baranidharan
# Start Date	: 2010-07-02
# End Date		: 2008-07-02
# Project		: MatrimonyProduct
# Module		: Profile Detail - Member partner info
#=============================================================================================================

//PATH INCLUDES
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/cityarray.cil14");

if(isset($_REQUEST["stateid"]) && $_REQUEST["stateid"]!="")
{
	$options	= '';$resultarray = array();
	$arrStateid	= split("~",$_REQUEST["stateid"]);
	foreach($arrStateid as $stateid ) {
	 $statename	= $residingCityStateMappingList[$stateid];
	 $cityarray	= $$statename;
	 $resultarray = $resultarray + $cityarray; 
	}
	asort($resultarray);
	while(list($ind,$val)=each($resultarray))
	{
	  $options .= $ind."~".$val."~";
	}
	$options = substr($options,0,-1);
	echo $options;
}
else
{
	echo '0~Any';
}
?>