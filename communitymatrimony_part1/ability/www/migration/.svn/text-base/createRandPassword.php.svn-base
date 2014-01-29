<?php
$funChars		= array('A','B','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','T','U','Y','2','3','4','5','6','7','8','9');
$funTotalChars	= (count($funChars)-1);

$varFileHandler	= fopen('randomPassword.txt', 'w');

for($i=0; $i<20; $i++)
{
	$funRandomValue	= '';
	for($j=0;$j<7;$j++)
	{
		$funRandNumber 	= rand(0,26);
		$funRandomValue.= $funChars[$funRandNumber];
	}

	fwrite($varFileHandler, $funRandomValue."\n");
}

fclose($varFileHandler);
?>