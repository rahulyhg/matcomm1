<?php
 

//*******************************************DB server******************************
//BM DB Server / Group1 Connection details...

$dbhost = "172.28.0.245"; // db6 server
$dbuser = "matriservices";
$dbpass = "services";
$dbname = "matrimony";

//BM DB Connection script...
$dblink = mysql_connect($dbhost, $dbuser, $dbpass);

if (!$dblink) 
{
   die('Could not connect: ' . mysql_error());
}
mysql_select_db($dbname);

 
//friend 

$sqlSelectMatrimony="select Countryselected,Matriid,Status from matrimony.Assuredprofile where Matriid in('G397875','G399782') ";

$resMatrimony=mysql_query($sqlSelectMatrimony,$dblink)or die(mysql_error());
echo mysql_num_rows($resMatrimony)."<br>";
 
while($datMatrimony=mysql_fetch_array($resMatrimony))
{

 
echo $EmailId=$datMatrimony["Countryselected"]."<br>";
echo $Password=$datMatrimony["Status"]."<br>";
echo $Password=$datMatrimony["Matriid"]."<br>";

 
//if ($total == 5) exit;
}


mysql_close($dblink);
 


?>
