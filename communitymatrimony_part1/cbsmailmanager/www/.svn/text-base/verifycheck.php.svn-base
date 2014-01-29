<?
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
 

 $sqlSelectMatrimony="select VerificationSource from matrimony.AssuredProfile where Matriid in('H1314190','H1312983', 'H1437276', 'B437332','B444333','B439296','B433376','H1270645','H1276857',' R476497','B428880','H1273450','H1518303','B454479','B454444','R566489','H1505119') and Validated=1 and Authorized=1 and Status<2"; //  mailer

$resMatrimony=mysql_query($sqlSelectMatrimony,$dblink)or die(mysql_error());
 while($res_rec = mysql_fetch_array($resMatrimony))
{
	echo $res_rec['VerificationSource']."<br>";
}
?>