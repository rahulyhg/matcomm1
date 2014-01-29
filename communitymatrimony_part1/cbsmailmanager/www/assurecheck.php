<?php

error_reporting(0);

$total=0;

$filename=realpath("inactive2.dat");
$fp=fopen($filename,"w");

//*******************************************DB server******************************
//BM DB Server / Group1 Connection details...

$dbhost = "172.28.0.244"; // db6 server
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

$sqlSelectMatrimony="select PhoneVerified,FollowupComments,FollowupStatus from matrimony.AssuredProfile where Matriid='T790823' and Status<2 and Authorized=1 and Validated=1";
$resMatrimony=mysql_query($sqlSelectMatrimony,$dblink)or die(mysql_error()); 

while($datMatrimony=mysql_fetch_array($resMatrimony))
{
  
echo $verified=$datMatrimony["PhoneVerified"]."~".$datMatrimony["FollowupComments"]."~".$datMatrimony["FollowupStatus"];

	 

}

 


?>
