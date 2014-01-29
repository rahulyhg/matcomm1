<?php
#====================================================================================================
# File			: index.php
# Author		: Rohini
# Date			: 15-July-2008
#*****************************************************************************************************
# Description	:
#********************************************************************************************************/
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/basefunctions.cil14");

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessUsername	= $varGetCookieInfo["USERNAME"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];

$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

if($_POST['partnerinfosubmit'] == 'yes') { include_once('addedpartnerdesc.php'); }//if
if($_POST['updatestatus'] == 'yes' && $_POST['act']=='profilestatus') { include_once('profilestatus.php'); }//if

if ($varAct == 'logout') { clearCookie();  }//if
else if($varAct != 'viewprofile') { checkUserAuth('login'); }//if


?>
<html>
<head>
	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<script language="javascript">var cook_id	  = '<?=$sessMatriId?>',cook_publish='<?=$sessPublish?>',cook_un	  = '<?=$sessUsername?>', cook_paid = '<?=$sessPaidStatus?>', cook_gender = '<?=$sessGender?>', imgs_url= '<?=$confValues["IMGSURL"]?>', img_url	= '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url	= '<?=$confValues["SERVERURL"]?>';</script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/cookie.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>
	<script>
		var ajaxobj=false;
		function showTwitterUp(matid) {
			var argurl="/profiledetail/example1.php";
			var postval = "matriid="+matid;
			ajaxobj=AjaxCall();
			AjaxPostReq(argurl,postval,populateTwitter,ajaxobj);
		}

		function populateTwitter() {
			if (ajaxobj.readyState == 4 && ajaxobj.status == 200) {
				document.getElementById('twitterdiv').innerHTML	= ajaxobj.responseText;
			}
		}
	</script>
</head>
<body>
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div class="main">
			<div class="innerdiv">
				<div class="rpanel fleft">
					<?php
						if($varAct != "")
							{
								$varAct	= preg_replace("'\.\./'", '', $varAct);
								if(file_exists($varAct.'.php')){ 
									if($varAct=='viewprofile' || $varAct=='fullprofilenew') {?>
									<script language="javascript" src="<?=$confValues['JSPATH']?>/al.js" ></script>
									<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
									<script language="javascript" src="<?=$confValues['JSPATH']?>/conceptRTE.js" ></script>
									<script language="javascript" src="<?=$confValues['JSPATH']?>/contact.js" ></script>
									<script language="javascript" src="<?=$confValues['JSPATH']?>/search.js" ></script>
									<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
									<script>viewrec=0;curroppid="<?=$_GET['id']?>";</script>
									<form name="buttonfrm">
									<? } 
									include_once($varAct.'.php'); 
									if($varAct=='viewprofile' || $varAct=='fullprofilenew') {?>
									</form>
									<?}
								}//if
								else{ include_once('myhome.php'); }
							}else{ include_once('myhome.php'); }
					?>
				</div>
				<br clear="all" />
			</div>
		</div>
	</div>
</div>
</center>
</body>
</html>