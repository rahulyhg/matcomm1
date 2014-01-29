<?php
$varPath		= "/home/product/community/www/brightness_backup/";
$varSourcePath	= $varPath.$_REQUEST['imagename'];

$varAutofixCommand = "autolevel -c luminance ".$varSourcePath." ".$varSourcePath;
$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
escapeexec($varAutofixCommand,$varlogFile);
?>