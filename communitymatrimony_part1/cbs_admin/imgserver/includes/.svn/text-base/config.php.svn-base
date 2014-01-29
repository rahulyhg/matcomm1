<?php
$varCookieInfo			= $_COOKIE["adminLoginInfo"];
if (isset($varCookieInfo))
{
	$varCookieInfo	= split("=",str_replace("&","=",$varCookieInfo));
	$confUserType	= $varCookieInfo[1];
}//if
else { $confUserType = '';  }//else
$confValues = array(
'ServerURL' => 'http://support.communitymatrimony.com',
'PhotoURL' => 'http://image.communitymatrimony.com',
'GetPhotoURL' => 'http://image.communitymatrimony.com/photo/get-photo.php',
'DomainName' => '.communitymatrimony.com',
'DomainUrlOrder' => '2',
'IMGURL'				=> 'http://img.communitymatrimony.com',
'IMGSURL'				=> 'http://image.communitymatrimony.com/cmimages',
'PHOTOURL'				=> 'http://image.communitymatrimony.com',
'IMAGEURL'				=> 'http://image.communitymatrimony.com/newimages',
'JSPATH'				=> 'http://www.communitymatrimony.com/scripts',
'CSSPATH'				=> 'http://www.communitymatrimony.com/styles',
'MAILTEMPLATEPATH'		=> 'http://www.communitymatrimony.com/mailer/templates',
'DOMAINNAME'			=> '.communitymatrimony.com',
'DOMAINPREFIX'			=> 'support.',
'PRODUCTNAME'			=> 'communitymatrimony',
'sessUserType' => $confUserType
);
?>