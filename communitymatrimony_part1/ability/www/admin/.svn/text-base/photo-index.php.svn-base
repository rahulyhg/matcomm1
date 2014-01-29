<?php
#================================================================================================================
# Author 		: S Anand
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: Search - Index Page
#================================================================================================================
//START SESSION

$act	= $_REQUEST["act"];
$act	= preg_replace("'\.\./'", '', $act);

//REDIRECT TO INDEX PAGE, WHEN USER IS NOT EXISTS
function redirectTheSelectedPageTo($argRedirectURL){ header('Location:'.$argRedirectURL); }

//FILE INCLUDES
include_once('home/header.php');

#File redirection 'based on the user action'
if($act != "")
{
	if(file_exists($act.'.php')){ include_once($act.'.php'); }//if
	else{ include_once('view.php'); }//else
}//if
else{ include_once('view.php'); }//else

//FILE INCLUDES
include_once('home/footer.php');
#================================================================================================================
?>