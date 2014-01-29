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
'ServerURL' => 'http://www.abilitymatrimony.com',
'PhotoURL' => 'http://image.abilitymatrimony.com',
'GetPhotoURL' => 'http://image.abilitymatrimony.com/photo/get-photo.php',
'DomainName' => '.abilitymatrimony.com',
'DomainUrlOrder' => '2',
'IMGURL'				=> 'http://img.abilitymatrimony.com',
'IMGSURL'				=> 'http://image.abilitymatrimony.com/cmimages',
'PHOTOURL'				=> 'http://image.abilitymatrimony.com',
'IMAGEURL'				=> 'http://image.abilitymatrimony.com/newimages',
'JSPATH'				=> 'http://imgs.abilitymatrimony.com/scripts',
'CSSPATH'				=> 'http://img.abilitymatrimony.com/styles',
'MAILTEMPLATEPATH'		=> 'http://www.abilitymatrimony.com/mailer/templates',
'DOMAINNAME'			=> '.abilitymatrimony.com',
'DOMAINPREFIX'			=> 'www.',
'PRODUCTNAME'			=> 'abilitymatrimony',
'sessUserType' => $confUserType
);
?>