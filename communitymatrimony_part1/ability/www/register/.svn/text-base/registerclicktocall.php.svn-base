<?php
/**********************************/
/*Name:Thavaprkash.S.             */
/*Date:June 04-2010		          */
/**********************************/
include_once($varRootBasePath.'/conf/com_phonefunction.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');

/* begin thava edited for auto click to call on June 04-2010*/

	$varCondition	= " WHERE MatriId=".$objRegister->doEscapeString($sessMatriId,$objRegister);
	$varFields		= array('Password');
	$varResults		= $objRegister->select($varTable['MEMBERLOGININFO'],$varFields,$varCondition,1);
	$varPassword	= $varResults[0]['Password'];

	//DELETE memberpartlyinfo INFO
	if ($varPartlyId !="" && $sessMatriId!="") {
		$varCondition		= "Member_Id=".$objRegister->doEscapeString($varPartlyId,$objRegister);
		$objRegister->delete($varTable['MEMBERPARTLYINFO'],$varCondition);
	}

	$varCondition	= " WHERE MatriId=".$objRegister->doEscapeString($sessMatriId,$objRegister);
	$varFields		= array('PhoneNo1','PinNo','CountryCode','AreaCode','PhoneNo','MobileNo');
	$varPhResults	= $objRegister->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$varFields,$varCondition,1);
	$iCountry		= $varPhResults[0]['CountryCode'];
	$iArea			= $varPhResults[0]['AreaCode'];
	$iPhoneNo		= $varPhResults[0]['PhoneNo'];
	$iMobile		= $varPhResults[0]['MobileNo'];
	$varPhoneNo		= $varPhResults[0]['PhoneNo1'];
	$varPhonePin	= $varPhResults[0]['PinNo'];

	//Get the member detail
	$varAge		    = $varGetCookieInfo["AGE"];
	$varGender		= $varGetCookieInfo["GENDER"];
	$varCommunityId	= $confValues['DOMAINCASTEID'];

	$iTollFree = fnGetIvrNo($iCountry);
	if($iMobile!=''){
	$iPhoneNo = '';
	$iAutoCall = $iMobile;
	$iMobileNumber=$iAutoCall;// for update mobile number
	if($iCountry!=91){
	  if($iArea != ''){
		$iAutoCall = $iArea.$iMobile;
		$iMobileNumber = $iAutoCall;// for update mobile number
	  }else{
		$iArea = '';
	  }
	}else{
	  $iArea = '';
	  if(substr($iMobile,0,1)!='0')
		$iAutoCall = '0'.$iMobile;
	}
	}else{
	$iMobile='';
	$iAutoCall = $iArea.$iPhoneNo;
	}
	$iCallNumber = $iAutoCall; 
	if($iCountry!=91)
	$iAutoCall = "00".$iCountry.$iAutoCall;
	$iAutoCall = preg_replace('/\D/','',$iAutoCall);

	$res=fnInsertAutoClickToLog($objRegister,$sessMatriId,$iCallNumber,$iAutoCall,$iCountry,$varAge,$varGender,$varCommunityId,$varPhonePin);

/* end thava edited for auto click to call on June 04-2010*/

/* begin thava edited for congrates on June 04-2010*/

	$varPno=str_replace("~","-",$varPhoneNo);
	if($iMobile!=''){
		$sPhoneTxt='mobile';
	}else{
		$sPhoneTxt='phone';
	}


if($iCountry==91){ //this is for india only 
?>
<script language=javascript src="<?=$confValues["JSPATH"];?>/com_editphone.js"></script>
<div class="fleft normtxt1 clr bld padb5">Registration Complete!</div><br clear="all" />
<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all" />
<center>
	<div class="padtb10 smalltxt clr" style="width:700px;">
		<div class="normtxt fleft"><b>Congratulations!</b> You have successfully registered with <?=$varUcDomain?>Matrimony a part of CommunityMatrimony.com.</div><br clear="all"><br>
		<div class="fleft tlleft padb5 lh16">This is your <?=$varUcDomain?>Matrimony ID: <font class="clr3 normtxt bld"><?=$sessMatriId;?></font> &nbsp; Password: <font class="clr3 normtxt bld"><?=$varPassword;?></font><br>
		Please use this ID or your e-mail ID to login to <?=$varUcDomain?>Matrimony.com. A confirmation mail will be sent to you with your <?=$varUcDomain?>Matrimony ID and Password. <br><br></div><br clear="all">
		<div class="linesep" style="width:700px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all" /><br>
		<div class="normtxt fleft tlleft padb5 lh16"><b>What Next : </b> <font class="clr3 bld">Verify your Phone Number</font> - This is the best way to get other members to contact you.  Phone number already verified? <a class="clr1" href="index.php?act=intermediateregister">Skip this page</a>.</div><br clear="all">
		<div class="brdr">
		<center>
			<div style="width:620px;padding:25px 0px;" class="normtxt lh20 tlleft">
				<font class="normtxt1 clr3 bld">Option 1</font><br>
				<b>How to verify your phone number:</b><br>
				You will receive a call shortly from us on your <span id='phonetxtcont' name='phonetxtcont'><?=$sPhoneTxt;?></span> number <font class="clr3 bld"  name='phonenocont'><span id='phonenocont' name='phonenocont'><?=$varPno?></span></font>. <span id='cont-edit'>&nbsp;&nbsp;<input type="button" class="button" value="Edit Number" onClick="document.getElementById('cont-edit').style.display='none';document.getElementById('num_content_1').style.display='block';"/><br>
				Press 1 on your mobile to complete your verification.</span>
				<br><br>

<?php
	//VARIABLE DECLARITON
	/* uncomment when instruction change for all country
	asort($arrCountryList);
	UNSET($arrCountryList[98]);
	UNSET($arrCountryList[222]);
	UNSET($arrCountryList[220]);
	UNSET($arrCountryList[129]);
	UNSET($arrCountryList[221]);
	UNSET($arrCountryList[13]);
	UNSET($arrCountryList[185]);
	UNSET($arrCountryList[39]);
	UNSET($arrCountryList[189]);
	UNSET($arrCountryList[114]);
	$varCountryKey=array_search($iCountry,$arrIsdCountryCode);
	*/
	if($iMobileNumber!='')
		$lable="Edit Mobile number";
	else
		$lable="Edit Landline number";

?>

		  <div  id="num_content_1" style="padding:2px 0px 0px 0px;display:none;"><b>Edit Number</b><br/>
		  <form name="frmassuredcontact" method="post" style='margin:0px;'>
		  <input type='hidden' name='memid' value='<?=$sessMatriId;?>'>
		  <input type='hidden' name='age' value='<?=$varAge;?>'>
		  <input type='hidden' name='gender' value='<?=$varGender;?>'>
		  <input type='hidden' name='langid' value='<?=$varCommunityId;?>'>
		  <input type="hidden" name="getDomainInfo" value="<?=$varRootBasePath;?>">
		  <?=$lable;?>&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp; India(+91)

		  <span id="span_assured_country" style="display:none">	
		  <select  name="assuredcountry" id="assuredcountry" class="inputtext" style="width:84px;">
			<option value="98" selected>India(+91)</option>
		  </select>
		  </span>
		 <!-- here india hard code when instraction change uncomment the belew select box and use it -->

<!-- 
		  <select name="assuredcountry" id="assuredcountry" class="inputtext" style="width:84px;">
			<option value="0">--- Select ---</option>
			<option value="98" <?=$varCountryKey=='98' ? 'selected' : '';?>>India(+91)</option>
			<option value="222" <?=$varCountryKey=='222' ? 'selected' : '';?>>United States of America(+1)</option>
			<option value="220" <?=$varCountryKey=='220' ? 'selected' : '';?>>United Arab Emirates(+971)</option>
			<option value="129" <?=$varCountryKey=='129' ? 'selected' : '';?>>Malaysia(+60)</option>
			<option value="221" <?=$varCountryKey=='221' ? 'selected' : '';?>>United Kingdom(+44)</option>
			<option value="13" <?=$varCountryKey=='13' ? 'selected' : '';?>>Australia(+61)</option>
			<option value="185" <?=$varCountryKey=='185' ? 'selected' : '';?>>Saudi Arabia(+966)</option>
			<option value="39" <?=$varCountryKey=='39' ? 'selected' : '';?>>Canada(+1)</option>
			<option value="189" <?=$varCountryKey=='189' ? 'selected' : '';?>>Singapore(+65)</option>
			<option value="114" <?=$varCountryKey=='114' ? 'selected' : '';?>>Kuwait(+965)</option>
			<option value="">-------------------------</option>
			<?php
			foreach($arrCountryList as $cntryKey=>$cntryValue){
				$varCountryCode= $arrIsdCountryCode[$cntryKey]; 
				$selected=($varCountryKey==$cntryKey)?'selected':'';
				if($varCountryCode){
				echo '<option value="'.$cntryKey.'" '. $selected.'>'.$cntryValue.'(+'.$varCountryCode.')</option>';
				}
			}
			?>
		</select> -->
<?php
  if($iMobileNumber!=''){
?>
			<input type="text" class="inputtext" onKeypress="return allowNumeric(event);" size="15" name="MOBILENO" id="MOBILENO" value="<?=$iMobileNumber;?>">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button" value="Update" onClick="javascript:funregphoneupdate(1);"><br/>&nbsp;&nbsp;&nbsp;&nbsp;<span id="errcountry" class="errortxt"></span><span id="errmobileno" class="errortxt"></span>
<?php
  }else{
?>

	  <input type=text name="area" onKeypress="return allowNumeric(event);" size="8" class="inputtext" id="area" style="width:42px; height:20px; vertical-align:middle;" value="<?=$iArea;?>">&nbsp;&nbsp;
	  <input type=text name="phoneno" onKeypress="return allowNumeric(event);" id="phoneno" size="15" maxlength="8" class="inputtext" value="<?=$iPhoneNo  ;?>" style="width:90px; height:20px; vertical-align:middle;">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button" value="Update" onClick="javascript:funregphoneupdate(2);"><br/>&nbsp;&nbsp;&nbsp;&nbsp;<span id="errcountry" class="errortxt"></span><span id="errarea" class="errortxt"></span><span id="errphoneno" class="errortxt"></span>

<?php
  }
?>
	</form>



</div>
<br clear="all">

<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
<br clear="all" />
<font class="normtxt1 clr3 bld">Option 2</font><br>
If you do not receive a call from us shortly, you can initiate the verification process by calling the following number:<br><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="6" /><br>
Call <font class="clr3 bld" id='tollfreeno'><?=$iTollFree;?></font> <span id='tollfreecont'><?=($iCountry!='44')?'Toll Free':'';?></span> from <font class="clr3 bld" id='phonenocont1'><?=$varPno?></font><br>
Press 2 for phone verification<br>
You will be asked to enter your 6 digit <b>IVR PIN:</b> <font class="clr3 bld"><span id='span_pin_no'><?=$varPhonePin?></span></font><br><br>
<font class="smalltxt">Note:Your IVR PIN is valid for 7 days only. Please verify your phone number at the earliest</font>

<?php 
}else{ //othere than inidia congrates 
?>

<div class="fleft normtxt1 clr bld padb5">Congrats, you have successfully registered on <?=$varUcDomain?> Matrimony!</div>
<br clear="all" />
<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
<br clear="all" /> 
<center>
<div class="padtb10 smalltxt clr">
	<div class="bld padl25 fleft">Your login details</div><br clear="all">
	<div class="fleft tlright pfdivlt">User ID:</div>
	<div class="fleft tlleft pfdivrt"><?=$sessMatriId?></div><br clear="all">
	<div class="fleft tlright pfdivlt">Password:</div>
	<div class="fleft tlleft pfdivrt"><?=$varPassword?></div><br clear="all">
	<div class="fleft padl25">(Please use it henceforth to login to the site.)</div><br clear="all"><br>
	<div class="dotsep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<br clear="all" />
	<div class="fleft normtxt bld padtb10 tlleft padl25"><font class="normtxt">Verify your phone number</font><br><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="10" /><br>
	<font class="smalltxt notbld">&nbsp;We display only verified phone numbers to members. If you would like to contact prospects and be contacted by prospects, please verify your phone number right away.</font><br><br>
	<font class="normtxt">How to verify your phone number:</font><br><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="10" /><br>
	<font class="smalltxt">Step 1:</font> &nbsp;<font class="notbld smalltxt"> Call number <font class="clr3">91-44-39115022</font> from <font class="clr3"><<?=$varPhoneNo?>></font></font><br />
	<font class="smalltxt">Step 2:</font> &nbsp;<font class="notbld smalltxt"> Press 2 on your phone. You will be asked to enter your PIN - <font class="clr3 smalltxt"><?=$varPhonePin?></font><font class="notbld smalltxt"> to complete your verification.</font><!-- <br><br>Note: If you do not want to display your phone number to all members, you can hide it. --></font>
	<!-- <font class="smalltxt">Step 2:</font> &nbsp;<font class="notbld smalltxt"> Press 1 on your landline phone or mobile phone to complete your verification.<br><br>Note: If you do not want to display your phone number to all members, you can hide it.</font> -->
	</div>
    <br clear="all" />
<?php
}
?>
	</div>
</center>
</div>
<br clear="all" />

		<div class="bld normtxt fleft tlleft padb5">Benefits of verification</div><br clear="all" />
		<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all" />
		<div class="tlleft">
			<div style="width:340px;" class="fleft normtxt"><img src="<?=$confValues['IMGSURL']?>/verph1.gif" align="left" hspace="15" />Prospects will be able to contact you directly.</div><div class="fleft" style="background:url(<?=$confValues['IMGSURL']?>/versep.gif);height:40px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="40"  /></div>
			<div style="width:300px;" class="fleft normtxt"><img src="<?=$confValues['IMGSURL']?>/verph2.gif" align="left" hspace="15" />You can find out who viewed your phone number.</div><!-- <div class="fleft" style="background:url(<?=$confValues['IMGSURL']?>/versep.gif);height:50px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="50"  /></div>
			<div style="width:230px;" class="fleft normtxt"><img src="<?=$confValues['IMGSURL']?>/verph3.gif" align="left" hspace="15" />If you do not want to show your phone number to all members, <br><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="57" height="1"  />you can hide it.</div> -->
		</div><br clear="all"><br>
		<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all" />
		<div class="fleft tlleft normtxt">If you require any further assistance in verifying your phone number, please do not hesitate to contact <a href="/site/index.php?act=LiveHelp" class="clr1">24X7 Live Help.</a></div><br clear="all"><br>
		<div class="normtxt fright padr20"><a class="clr1" href="index.php?act=intermediateregister">Skip this page</a></div><br clear="all">
	</div>
</center>

<!-- end thava edited for congrates on June 04-2010 -->
