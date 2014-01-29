<?php
$strArr = array("1","2","3","4","5","6","7","8","9","0","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

echo "<pre>";
print_r($strArr);
echo "</pre>";

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
?>