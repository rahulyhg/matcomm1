<?php
$varCookieInfo			= $_COOKIE["adminLoginInfo"];
if (isset($varCookieInfo))
{
	$varCookieInfo	= split("=",str_replace("&","=",$varCookieInfo));
	$confUserType	= $varCookieInfo[1];
	$adminUserName	= $varCookieInfo[2];
}//if
else { $confUserType = '';  }//else
$confValues = array(
'ServerURL' => 'http://www.communitymatrimony.com',
'PhotoURL' => 'http://image.communitymatrimony.com',
'GetPhotoURL' => 'http://image.communitymatrimony.com/photo/get-photo.php',
'DomainName' => '.communitymatrimony.com',
'DomainUrlOrder' => '2',
'IMGURL'				=> 'http://img.communitymatrimony.com',
'IMGSURL'				=> 'http://image.communitymatrimony.com/cmimages',
'PHOTOURL'				=> 'http://image.communitymatrimony.com',
'IMAGEURL'				=> 'http://image.communitymatrimony.com/newimages',
'JSPATH'				=> 'http://imgs.communitymatrimony.com/scripts',
'CSSPATH'				=> 'http://img.communitymatrimony.com/styles',
'DOMAINNAME'			=> '.communitymatrimony.com',
'DOMAINPREFIX'			=> 'www.',
'PRODUCTNAME'			=> 'communitymatrimony',
'sessUserType' => $confUserType
);
?>