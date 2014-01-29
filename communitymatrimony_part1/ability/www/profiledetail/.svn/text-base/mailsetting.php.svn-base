<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-20
# Project	  : MatrimonyProduct
# Filename	  : changepassword.php
#=====================================================================================================================================
# Description : Password change Here
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];

//OBJECT DECLARATION
$objDBSlave	= new DB;
$objDBMaster= new DB;


//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['mailset'];

if($sessMatriId==""){
	$varMessage='You are either logged off or your session timed out. <a href="http://'.$confValues['SERVERURL'].'/login/login.php" class="clr1">Click here</a> to login.';exit;
} else if($varUpdatePrimary == 'yes') {
	 $varMatchWatchFreq	    = ($_REQUEST['matchWatch']==1)?$_REQUEST['matchWatchFreq']:0;
	 $varIntPromoAlert	    = $_REQUEST['generalPromo'];	
	 $varThirdParty		    = $_REQUEST['externalPromo'];
	 $varSplFeatureAlert	= $_REQUEST['splFeatureAlert'];	
	 $varCurrentDate		= date('Y-m-d H:i:s');

	//CONNECT DATABASE
	$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	$argFields			= array('CommunityId','MatriId','Matchwatch','SpecialFeatures','Promotions','ThirdParty','Date_Updated');
	$argFieldsValues	= array($confValues['DOMAINCASTEID'],$objDBMaster->doEscapeString($sessMatriId,$objDBMaster),$objDBMaster->doEscapeString($varMatchWatchFreq,$objDBMaster),$objDBMaster->doEscapeString($varSplFeatureAlert,$objDBMaster),$objDBMaster->doEscapeString($varIntPromoAlert,$objDBMaster),$objDBMaster->doEscapeString($varThirdParty,$objDBMaster),"'".$varCurrentDate."'");
	$varInsertId		= $objDBMaster->insertOnDuplicate($varTable['MAILMANAGERINFO'],$argFields,$argFieldsValues,'MatriId');
	
	$varMessage = 'yes';
	//CLOSE DATABASE
	$objDBMaster->dbClose();
} else {
	//CONNECT DATABASE
	$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);	

	$argFields			= array('Matchwatch','SpecialFeatures','Promotions','ThirdParty');
	$argCondition		= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
	$varMWFreqResultSet	= $objDBSlave->select($varTable['MAILMANAGERINFO'],$argFields,$argCondition,0);
	$varMWFreqResult	= mysql_fetch_assoc($varMWFreqResultSet);
	
	//Getting matach freq alert
	$varMWFrequency		= $varMWFreqResult['Matchwatch'];
	if($varMWFrequency!='' && $varMWFrequency!=0) {
		$varMWFreqClass	= 'disblk';
	} else {
		$varMWFreqClass	= 'disnon';
	}
	$varSplFeatureAlert	= $varMWFreqResult['SpecialFeatures'];
	$varIntPromoAlert	= $varMWFreqResult['Promotions'];
	$varThirdParty		= $varMWFreqResult['ThirdParty'];
	
	//CLOSE DATABASE
	$objDBSlave->dbClose();
}
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<? include_once('settingsheader.php');?>
<center>
	<div class="padt20 smalltxt">
		<?if($varUpdatePrimary == 'yes') { ?>
		<center><div class='fleft' style='width:500px;'>
			Your mail alerts have been successfully updated.
		</div></center>
		<? } else { ?>
		<form name="frmMailAlert" method="post" style="margin: 0px;">
		<input type='hidden' name='act' value='mailsetting'>
		<input type='hidden' name='mailset' value='yes'>
		
		
		<div class="smalltxt clr bld fleft padl25 padtb10">E-mail Alerts</div><br clear="all"/>

		<div class="smalltxt fleft tlright pfdivlt padb10">New Message Alert - </div>	
		<div class="fleft pfdivrt tlleft">E-mail notification when you receive a message from another member</div>
		<br clear="all">

		<div class="smalltxt fleft tlright pfdivlt padb10">Best Matches - </div>
		<div class="fleft pfdivrt tlleft">An e-mail of your best matches based on your partner preference</div>
		<br clear="all">
		<div class="smalltxt fleft tlright pfdivlt padb10">&nbsp;</div>

		<div class="fleft pfdivrt tlleft">
			<div>
			<input type="radio" onClick="document.getElementById('mw').className='disblk';document.frmMailAlert.matchWatchFreq[0].checked=true;" name="matchWatch" value="1" <?if($varMWFrequency!='' && $varMWFrequency!=0) { echo "checked"; }?> class="frmelements"><font class="clr">On</font> &nbsp;&nbsp;
			<input type="radio" onClick="document.getElementById('mw').className='disnon';" name="matchWatch" value="0" <?if($varMWFrequency=='' || $varMWFrequency==0) { echo "checked"; }?> class="frmelements"><font class="clr">Off</font>
			</div><br clear="all">
			<div id="mw" class="<?=$varMWFreqClass?>">
			<input type="radio" name="matchWatchFreq" value="1" <?=($varMWFrequency==1)?'checked':'';?> class="frmelements">
				<font class="clr">Daily&nbsp;&nbsp;</font>
			<input type="radio" name="matchWatchFreq" value="2" <?=($varMWFrequency==2)?'checked':'';?> class="frmelements">
				<font class="clr">Weekly&nbsp;&nbsp;</font>
			<input type="radio" name="matchWatchFreq" value="3" <?=($varMWFrequency==3)?'checked':'';?> class="frmelements">
				<font class="clr">Fortnightly</font>
			</div>
		</div>
		<br clear="all">

		<div class="smalltxt fleft tlright pfdivlt padb10">Profile Update</div>	
		<div class="fleft pfdivrt tlleft">E-mail alert when a favourite member has updated the profile Photo/Horoscope/Phone Number Added - E-mail notification when a member has added photo/horoscope/phone number based on your request
		</div>
		<br clear="all">

		<div class="smalltxt fleft tlright pfdivlt padb10">Special Features E-mail</div>	
			<div class="fleft pfdivrt tlleft">
				<div class="fleft"><input type="radio" name="splFeatureAlert" value="1" <?if($varSplFeatureAlert==1) { echo "checked"; }?> class="frmelements"><font class="clr">On</font> &nbsp;&nbsp; <input type="radio" name="splFeatureAlert" value="0" <?if($varSplFeatureAlert==0 || $varSplFeatureAlert=='') { echo "checked"; }?> class="frmelements"><font class="clr">Off</font></div>
				<br clear="all">
				Great ways to make your search more exciting and fruitful
			</div>
		<br clear="all">

			<div class="smalltxt fleft tlright pfdivlt padb10">Promotions E-mail</div>	
			<div class="fleft pfdivrt tlleft">
				<div class="fleft"><input type="radio" name="generalPromo" value="1" <?if($varIntPromoAlert==1) { echo "checked"; }?> class="frmelements"><font class="clr">On</font> &nbsp;&nbsp; <input type="radio" name="generalPromo" value="0" <?if($varIntPromoAlert==0 || $varIntPromoAlert=='') { echo "checked"; }?> class="frmelements"><font class="clr">Off</font></div>
				<br clear="all">
				Learn about all the benefits of <?=$varUcDomain?>Matrimony Membership
			</div>
		<br clear="all">

			<div class="smalltxt fleft tlright pfdivlt padb10">Third Party Offers</div>	
			<div class="fleft pfdivrt tlleft">
				<div class="fleft"><input type="radio" name="externalPromo" value="1" <?if($varThirdParty==1) { echo "checked"; }?> class="frmelements"><font class="clr">On</font> &nbsp;&nbsp; <input type="radio" name="externalPromo" value="0" <?if($varThirdParty==0 || $varThirdParty=='') { echo "checked"; }?> class="frmelements"><font class="clr">Off</font></div>
				<br clear="all">
				Receive 3rd party offers (from our group)
			</div>
		<br clear="all">
			
			<div class="fleft pfdivlt">&nbsp;</div>
			<div class="fleft pfdivrt tlright"><input type="submit" class="button" value="Save"></div>
		</form>
		<? } ?>
	</div>
</center>
