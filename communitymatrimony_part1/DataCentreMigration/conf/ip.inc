<?php
#================================================================================================================
# Author 		: Ashok kumar, Dhanapal
# Date	        : 2008-07-15
# Project		: MatrimonyProduct
# Filename		: ip.inc
#================================================================================================================
# Description   : IP Configuration file
#================================================================================================================

// VARIABLE DECLARATION
$varAppServer			= array();
$varVideoServer			= array();
$varDbIP				= array();

// DB CONNECTION IP'S
$varDbIP['M']				= '172.29.23.95';
$varDbIP['S']				= '172.29.23.96'; //'172.28.100.83';
$varDbIP['S2']				= '172.29.22.100';
//$varDbIP['S']				= '172.28.100.236'; //'172.28.100.83';
$varDbIP['ODB4']			= '172.29.23.72'; //Telemarketing - Doorstep

// DB USERNAME & PASSWORD
$varDBUserName				= 'User4Cbs';
$varDBPassword				= '3rmMWua4';

//TWITTER USERNAME & PASSWORD
$varTwitterUserName			= 'cbs_tweet';
$varTwitterPassword			= 't8e3e3w9t8_1s7b2c2';

// APPLICATION SERVER DETAILS
$varAppServer['WEB']		= '173.203.191.100	';
$varAppServer['IMG']		= '173.203.191.108';

// VIDEO SERVER USER NAME & PASSWORD FOR APP SERVER
$varVideoServer['HOST']		= '72.32.59.238';
$varVideoServer['USERNAME'] = 'jainvideo';
$varVideoServer['PASSWORD'] = 'Uv%J5GPu2';

$varAudioServer['HOST']		= '72.32.59.238';
$varAudioServer['USERNAME']	= 'jainvoice';
$varAudioServer['PASSWORD']	= '?4;=,>fKj';

$varChat['OPENFIRE']		= '172.29.22.102';

?>
