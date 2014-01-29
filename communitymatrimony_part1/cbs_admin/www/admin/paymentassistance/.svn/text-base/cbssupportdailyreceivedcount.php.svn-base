<?php
#====================================================================================================
# Author		: J.P.Senthil Kumar
# Date			: 17 Feb 2011
# Module		: Payment Assistance
# Description	: This file allows the admin user of CBS INTERFACE to view the counts regarding domain wise and leadsource wise individually and the total counts of both
#====================================================================================================
//BASE PATH
$varRootBasePath = '/home/product/community';

//FILE INCLUDES
include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/www/admin/paymentassistance/lvars.php');
include_once($varRootBasePath.'/www/admin/paymentassistance/pavar.php');

global $adminUserName;
if($adminUserName == "")
header("Location: ../index.php?act=login");
$uname      = $adminUserName;

if(($uname == 'sureshtme') || ($uname == 'admin') || ($uname == 'prabhur') || ($uname == 'vijay.anand')) { 

//OBJECT DECLARTION
$objSlave = new DB;
//$objSlaveMatri = new DB;
 
//Connecting communitymatrimony db
//$objSlaveMatri -> dbConnect('S',$varDbInfo['DATABASE']);
 
global $varDBUserName, $varDBPassword;
$varDBUserName = $varPaymentAssistanceDbInfo['USERNAME'];
$varDBPassword = $varPaymentAssistanceDbInfo['PASSWORD'];
 
//Conecting cbssupportiface db
$objSlave-> dbConnect('S',$varPaymentAssistanceDbInfo['DATABASE']);
 
$lockTime=mktime(date(H),date(i)-15,date(s),date(m),date(d),date(Y));
$lockTimeNow=date("Y-m-d H:i:s",$lockTime);

$curdate=date("Y-m-d");

$args = array('count(1) as Counts','MotherTongueGrouping','LeadSource');
$argCondition = "where (SupportUserName='') and Followupstatus=0 and LockTime < '$lockTimeNow' and ((EntryType=1 and PaymentDate='0000-00-00 00:00:00') or (EntryType=0)) and FreshlyAddedOn>='$curdate 00:00:00' and MotherTongueGrouping > 0 group by MotherTongueGrouping,LeadSource";


//$argCondition = "where (SupportUserName='') and Followupstatus=0 and ((EntryType=1 and PaymentDate='0000-00-00 00:00:00') or (EntryType=0)) and FreshlyAddedOn>='2009-02-17 00:00:00' and MotherTongueGrouping > 0 group by MotherTongueGrouping,LeadSource";
 $checkResult = $objSlave -> select($varTable['PAYMENTOPTIONS'],$args,$argCondition,0);

$lead = array();

$arraycombinelead=array(1,15);
while($supportdailycount_list = mysql_fetch_assoc($checkResult)) { 
			
			$lang = $supportdailycount_list[MotherTongueGrouping];
			$ls = $supportdailycount_list[LeadSource];			
			
			if($lang != '0') {
				if($lead[$lang][$ls] != '') {
					if(in_array($supportdailycount_list[LeadSource],$arraycombinelead)) {
						$lead[$lang][2] += $supportdailycount_list[Counts];
					}
					else {
						$lead[$lang][$ls] += $supportdailycount_list[Counts];
					}
				}
				else
				{
					if(in_array($supportdailycount_list[LeadSource],$arraycombinelead)) {
						$lead[$lang][2] += $supportdailycount_list[Counts];
					}
					else {
						$lead[$lang][$ls] += $supportdailycount_list[Counts];
					}
				}
			}
			
}
?>
<center>
<div style="padding-top: 5px;" >
	<!-- Header Top Level  -->
	<?php
	$varGetFolderLogo = "community";
	if($varGetFolder != "")
		$varGetFolderLogo = $varGetFolder;
	?>
		<div class="fleft" style="width:380px;" id="logo"><a href="<?php echo "http://".$communitypath."/admin/paymentassistance/index.php"; ?>" target="_self"><img src="<?=$confValues['IMGSURL']?>/logo/<?=$varGetFolderLogo;?>_logo.gif" alt="Community Matrimony" border="0" height="40" width="380"></a></div>
		</div>
	<br clear="all">
	<!-- Header Top Level  -->
<div style="clear: both;padding-bottom:10px;border-top: 1px solid rgb(255, 255, 255);"></div>


<div id="" style="position:absolute; top:140px; left:0px; height:600px; width:860px; ">
<table width="100%" align=center valign="top" border=0 cellpadding=4 cellspacing=1 class="normaltxt1">
<tr>
	<td align="right" colspan="16"><a href="http://<?=$communitypath;?>/admin/paymentassistance/index.php">&#171; Home</a></td>
</tr>
</table>
<table width="100%" align=center valign="top" border=1 cellpadding=4 cellspacing=1 class="normaltxt1" style="border:solid 1px #FFDD91;">
<tr>
	<th colspan="23">DOMAIN & LEADSOURCE WISE RECEIVED REPORT ON <? echo date('M d Y'); ?></th>
</tr>
<tr style="border:solid 1px #FFDD91;">
	<th nowrap="nowrap">LEAD SOURCE</th>
	<?php foreach($paLanguageKeys as $key1=>$value1) { ?>
	<th><?php if(($value1 == "Marwari") || ($value1 == "Marathi")) { echo ucwords(substr($value1,0,4)); } elseif(($value1 == "Malayalam") || ($value1 == "Manipuri")) { echo ucwords(substr($value1,0,3)); } else { echo ucwords(substr($value1,0,2)); } } ?></th>
	<th>LEADS TOTAL</th>
</tr>

<?php $tot = array(); ksort($leadsource); ksort($paLanguageKeys); foreach($leadsource as $leadkey=>$leadvalue) {	

	if(($leadkey != 1) && ($leadkey != 15)) {
	$p = 0;  $col_tot = ''; ?>
	<tr style="border:solid 1px #FFDD91;"><td align="left"><? echo $leadvalue; ?></td>
	<? foreach($paLanguageKeys as $langkey=>$langvalue) {				
		
		if($lead[$langkey][$leadkey] != '') { 
		?>
		<td align="center" nowrap="nowrap"><?  $col_tot += $lead[$langkey][$leadkey];  $tot[$p] += $lead[$langkey][$leadkey]; echo $lead[$langkey][$leadkey]; ?></td>	
		<? } else { ?>
		<td align="center" nowrap="nowrap"><? $col_tot += $lead[$langkey][$leadkey]; $tot[$p] += $lead[$langkey][$leadkey]; ?>0</td>		
		<? }  $p++;	
	} ?>
	<td align="center"><? echo $col_tot; ?></td>
	</tr>
<? $tot[$p]; 
	 } } ksort($tot); ?>
	<tr style="border:solid 1px #FFDD91;"><td align="left">TOTAL</td>
	<? foreach($tot as $totkey=>$totvalue) { 
		if($totvalue != '') { ?>		
		<td align="center"><? echo $totvalue; ?></td>			
		<? } else { ?>		
		<td align="center">0</td><? } }?>
		<td align="center"><? echo array_sum($tot); ?></td>
	</tr>
</table>
</div>
</center>
<?php
$objSlave->dbClose();
if($_GET[fix]) {
	echo $argCondition;
}
}
else {
	header("Location:http://".$communitypath."/admin/paymentassistance/index.php");
}
?>