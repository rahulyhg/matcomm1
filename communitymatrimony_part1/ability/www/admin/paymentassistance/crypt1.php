<?php

function encrypt($str,$sugar=10)
{
	while($sugar > 255)	$sugar = $sugar - 255;
	while($sugar < 0)	$sugar = $sugar + 255;

	for($i=0;$i<strlen($str);$i++)
	{
		$j = ord($str[$i]) + $sugar;
		$output .= chr($j);
	}
return $output;
}
function decrypt($encstr,$sugar=10)
{
	while($sugar > 255)	$sugar = $sugar - 255;
	while($sugar < 0)	$sugar = $sugar + 255;

	for($i=0;$i<strlen($encstr);$i++)
	{
		$j = ord($encstr[$i]) - $sugar;
		$output .= chr($j);
	}
return $output;
}
$str2 = $_REQUEST['str2'];
echo $enc2 = encrypt($str2,160);
echo " <br><br>";
echo $dec2 = decrypt($enc2,160)."<br><br>";


echo "<br><br><br>";
echo "For zero - ".chr(0);
?>