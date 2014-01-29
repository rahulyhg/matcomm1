<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 28-Aug-2008
   # Project		: MatrimonyProduct
   # Filename		: Photodeletemsg.php
#================================================================================================================
   # Description	: display delete message
#================================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.inc");
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<div>
<?
$varDisplayMessage = '';
$varDisplayMessage .= '<div style="padding: 0px 20px 0px 20px;">';
$varDisplayMessage .= '<div style="padding:5px;" class="mediumtxt boldtxt clr3">Delete Photo</div> <div style="padding:10px;" class="divborder">';
$varDisplayMessage .= "Photo deleted from profile successfully.<br clear='all'><div class='fright' style='padding:5px 4px 3px 3px;' id='closebt'><input type='button' value='Close' class='button' onclick='parent.document.getElementById(\"divphotodelete\").style.display=\"none\";parent.window.location.reload();' id='closebutton'></div>";
$varDisplayMessage .= '</div>';
$varDisplayMessage .= '</div>';
echo $varDisplayMessage;
?>