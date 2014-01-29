<?php
#====================================================================================================
# Author 		: Prakash N
# Start Date	: 22 Sep 2009
# End Date		: 
# Project		: MatrimonyProduct
# Module		: Site - Static pages Index
#====================================================================================================
//ini_set("display_errors","1");

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/srchcontent.inc");
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsRegister.php');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath."/conf/config.inc");


$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
if($varAct == "logout"){ clearCookie(); }//if

if($_COOKIE['adminLoginInfo']==''){
	$urllogin = $confValues['ServerURL'];
    header("location:$urllogin/admin/index.php?act=login");
}


?>
<html>
<head>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script> 
	<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
    
		
</head>
<body>

<table width="88%" align="center" border="0"><tr><td>
<img src="<?=$confValues['IMGURL']?>/images/logo/community_logo.gif" alt="Community Matrimony" border="0" />
<tr><td><hr></td></tr><tr><td align="right"><a href='<?=$confValues['SERVERURL'];?>/admin/index.php?act=admin-profile-valid' class="mediumtxt clr1 boldtxt" align='right'>Home</a>
&nbsp;<a href='<?=$confValues['IMGURL'];?>/admin/successstory/index.php' class="mediumtxt clr1 boldtxt" align='right'>Admin Home</a>
</td></tr>
</td></tr></table>
<br clear="all">

<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div class="main">
			<?php include_once("../template/header.php"); ?>
			<div class="innerdiv">
				<?php include_once('../template/leftpanel.php'); ?>
				<?php
					if($varAct != "")
						{
							$varAct	= preg_replace("'\.\./'", '', $varAct);
							if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
							else{ include_once('success-valid.php'); }
						}else{ include_once('success-valid.php'); }
				?>
				<br clear="all" />
			</div>
			<?php include_once('../template/footer.php'); ?>
		</div>
	</div>
</div>
</center>
</body>
</html>