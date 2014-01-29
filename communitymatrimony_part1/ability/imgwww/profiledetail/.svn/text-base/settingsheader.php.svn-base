<?
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath.'/lib/clsDomain.php');
$objDomain	= new domainInfo;
?>
<div class="normtxt1 padb5 fleft"><font class="clr bld">Profile Settings</font></div>
<div class="fright"><a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=fullprofilenew&id=<?=$sessMatriId?>" class="clr1 smalltxt">View my profile</a></div><br clear="all">
<div class="linesep"><img src="images/trans.gif" height="1" width="1" /></div>
<div class="smalltxt clr2 padt5">
	<a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo" class="<?=($_REQUEST['act'] == 'primaryinfo')?'smalltxt clr bld':'clr1'?>">Basic Info </a>&nbsp|&nbsp
	<a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=aboutme" class="<?=($_REQUEST['act'] == 'aboutme')?'smalltxt clr bld':'clr1'?>">About Me</a> &nbsp|&nbsp;
	<a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=hobbiesinfodesc" class="<?=($_REQUEST['act'] == 'hobbiesinfodesc')?'smalltxt clr bld':'clr1'?>">Lifestyle</a> &nbsp;|&nbsp;
	<a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=familyinfodesc" class="<?=($_REQUEST['act'] == 'familyinfodesc')?'smalltxt clr bld':'clr1'?>">Family</a> &nbsp&nbsp;|&nbsp;&nbsp;
	<a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=partnerinfodesc" class="<?=($_REQUEST['act'] == 'partnerinfodesc')?'smalltxt clr bld':'clr1'?>">My Partner</a> &nbsp&nbsp;|&nbsp;&nbsp;
	<a href="<?=$confValues['IMAGEURL']?>/photo/index.php?act=addphoto" class="<?=($_REQUEST['act'] == 'addphoto')?'smalltxt clr bld':'clr1'?>">Photos</a> &nbsp&nbsp;|&nbsp;&nbsp;
	<? if($objDomain->useHoroscope()) {?>
	<a href="<?=$confValues['IMAGEURL']?>/horoscope/index.php?act=addhoroscope" class="<?=($_REQUEST['act'] == 'addhoroscope')?'smalltxt clr bld':'clr1'?>">Horoscope</a>&nbsp&nbsp;|&nbsp;&nbsp;
	<?}?>
	<a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=mailsetting" class="<?=($_REQUEST['act'] == 'mailsetting')?'smalltxt clr bld':'clr1'?>">Alerts</a>&nbsp&nbsp;|&nbsp;&nbsp;
	<a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=profilestatus" class="<?=($_REQUEST['act'] == 'profilestatus')?'smalltxt clr bld':'clr1'?>">Delete</a>
</div>