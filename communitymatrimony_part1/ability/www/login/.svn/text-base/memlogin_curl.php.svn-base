<?
if($argv[1] != '') {$varCommunityId	= $argv[1];}
if($argv[2] != '') {$varMatriId	= $argv[2];}
if($argv[3] != '') {$varGender	= $argv[3];}


//$POSTURL= "http://".$varIP.":80/plugins/multipledomainmessenger/mdinterface";
$POSTURL= "http://messenger.communitymatrimony.com/plugins/multipledomainmessenger/mdinterface?";
$POSTVARS="type=login&domainname=".$varCommunityId."&username=".ucfirst($varMatriId)."&gender=".$varGender;
//echo 'POSTURL='.$POSTURL;
//echo 'POSTVARS='.$POSTVARS;
$ch="";
$ch = curl_init($POSTURL);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTVARS);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1); 
curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
$login = curl_exec($ch);
//echo 'Response='.$login;



//http://messenger.communitymatrimony.com/plugins/multipledomainmessenger/mdinterface?type=login&domainname=25&username=BRH101779&gender=F
//type=setdebug&debug=true&debugmsg=true&debuginfo=true




?>