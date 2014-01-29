<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-08-04
# End Date		: 2008-08-04
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

//PATH INCLUDES
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/cityarray.cil14");

if(isset($_REQUEST["stateid"]) && $_REQUEST["stateid"]!="")
{
	$stateid	= $_REQUEST["stateid"];
	$statename	= $residingCityStateMappingList[$stateid];
	$cityarray	= $$statename;
	asort($cityarray);
	$options	='';
	while(list($ind,$val)=each($cityarray))
	{
		$options .= $ind."~".$val."~";
	}
	$options = substr($options,0,-1);
	echo $options;
}
else
{
	echo '0~-Select-';
}
?>