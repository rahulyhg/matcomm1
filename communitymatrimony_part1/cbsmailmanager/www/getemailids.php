<?php

include "config/config.php";
$count=1;

$sql="SELECT Email,Name,MatriId,Age,Gender,Password,Language FROM mailerprofile WHERE Validated=1 AND Authorized=1 AND Status<>2 AND LastLogin<'2005-03-01 00:00:00' AND TimeCreated<'2005-03-01 23:59:59' AND Email NOT LIKE '%@yahoo%'";

$result=mysql_query($sql);

$filename="LRBM1003.txt";

while($field=mysql_fetch_array($result))
{
	$handle = fopen ($filename, "a"); 
	$data=$count.",".$field['Email'].",".$field['Name'].",".$field['MatriId'].",".$field['Age'].",".$field['Gender'].",".$field['Password'].",".$field['Language']."\n";
	$filecontents = fwrite($handle,$data);
	fclose ($handle); 
	$count++;
}

$noofEmails=file($filename);
echo "\nTotal No:of Emails : ".count($noofEmails);

?>
