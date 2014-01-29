<?php
/* Horoscope Display Page */

$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/www/admin/includes/config.php");

$varHoroShowUrl = urldecode($_GET['horo']);
$varHoroType = $_GET['type'];
$varHoroscopeView = 1;
$varMatriId = $_GET['mid'];
include_once "adminviewlog.php";
?>

<? if ($varHoroType==1) { ?><img src="<?=$varHoroShowUrl?>"></img><? } ?>
<? if ($varHoroType==3) { ?><iframe src="<?=$varHoroShowUrl?>" scrolling=no border=0 height="100%" width="100%"></iframe><? } ?>