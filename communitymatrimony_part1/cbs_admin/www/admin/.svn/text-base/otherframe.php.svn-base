<?php
//FILE INCLUDES
$varRootBasePathh = '/home/product/community';
include_once($varRootBasePathh.'/conf/config.cil14');

/*Photo validation Begins here*/
if($_REQUEST['val']=='shuffphotoval'){
	$url= $confValues['IMAGEURL']."/admin1/photovalidation/shuffled_photovalidation.php";
}
if($_REQUEST['val']=='singlephotoval'){
	$url=$confValues['IMAGEURL']."/admin1/photovalidation/index.php?proc=val";
}
if($_REQUEST['val']=='addphotoval'){
	$url=$confValues['IMAGEURL']."/admin1/photovalidation/index.php?proc=add";
}
/*Photo validation Ends here*/
/*Horoscope validation Begins here*/
if($_REQUEST['val']=='shuffhoroval'){
	$url=$confValues['IMAGEURL']."/admin1/horoscopevalidation/newhoroscopevalidation.php";
}
if($_REQUEST['val']=='singlehoroval'){
	$url=$confValues['IMAGEURL']."/admin1/horoscopevalidation/index.php?proc=val";
}
if($_REQUEST['val']=='addhoroval'){
	$url=$confValues['IMAGEURL']."/admin1/horoscopevalidation/index.php?proc=add";
}
/*Horoscope validation Ends here*/
/*sucess stories begins here**/
if($_REQUEST['val']=='successvalid'){
	$url=$confValues['IMAGEURL']."/admin1/successstory/index.php?act=success-valid";
}
if($_REQUEST['val']=='successpending'){
	$url=$confValues['IMAGEURL']."/admin1/successstory/manage-incomplete-users.php?flag=0";
}
if($_REQUEST['val']=='photopending'){
	$url=$confValues['IMAGEURL']."/admin1/successstory/manage-incomplete-photo.php?flag=0";
}
/*sucess stories begins here*/

?>
<iframe src="<?=$url;?>" frameborder="0" height="100%" width="100%"></iframe>