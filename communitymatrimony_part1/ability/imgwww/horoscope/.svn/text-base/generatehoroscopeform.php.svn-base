<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
#================================================================================================================
//FILE INCLUDES

//UPLOAD HOROSCOPE VIEW PARE

 if ($varHoroscopeStatus=='1') { ?>
<br clear="all">
<div class="smalltxt bld fleft padb10" style="padding-left:30px;">View Horoscope</div><br clear="all">

<div class="fleft padb10 clr2" style="padding-left:50px;">
	<a href="javascript:viewHoros('<?=$sessMatriId?>');" class="smalltxt clr1">View My Horoscope</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onClick="deleteHoro();" class="smalltxt clr1">Delete My Horoscope</a></div><br><br clear="all">
<? } ?>


<!--<div class="smalltxt bld fleft" style="padding-left:30px;">Generate Horoscope</div>
<?

if ($varHoroscopeStatus=='3' && $varEdit!='yes') { 
	
if ($varBirthMinute=='0') { $varBirthMinute = '00'; }

?>
<br clear="all">
<div class="pfdivlt smalltxt fleft tlright">Date of Birth<span class="clr3">*</span></div>
<div class="pfdivrt fleft tlleft">
<?=date('M-d-Y',strtotime($varHoroDetails["BirthYear"].str_pad($varHoroDetails["BirthMonth"], 2, "0", STR_PAD_LEFT).str_pad($varHoroDetails["BirthDay"], 2, "0", STR_PAD_LEFT)))?>
</div><br clear="all">
<div class="pfdivlt smalltxt fleft tlright">Time of Birth<span class="clr3">*</span></div>
<div class="pfdivrt fleft tlleft">
<?=$varHoroDetails["BirthHour"].':'.$varBirthMinute.' '.$varHoroDetails["BirthMeridian"]?>
</div><br clear="all">
<div class="pfdivlt smalltxt fleft tlright">Country of Birth<span class="clr3">*</span></div>
<div class="pfdivrt fleft tlleft"><?=$varCountry?></div><br clear="all">
<div class="pfdivlt smalltxt fleft tlright">State of Birth<span class="clr3">*</span></div>
<div class="pfdivrt fleft tlleft"><?=$varStateName;?></div><br clear="all">
<div class="pfdivlt smalltxt fleft tlright">City of Birth<span class="clr3">*</span></div>
<div class="pfdivrt fleft tlleft"><?=$varCityName;?></div><br clear="all">
<div class="pfdivlt smalltxt fleft tlright">ChartStyle<span class="clr3">*</span></div>
<div class="pfdivrt fleft tlleft"><?=$arrChartFormat[$varHoroDetails["ChartStyle"]];?></div><br clear="all">
<center><div class="smalltxt clr2 tlleft tljust" style="width:500px;">Note: This process is compatible only in Internet Explorer 5.5 and above. This process will not function in IE Service Pack 1 or/and Opera, if the you have activated the popup blocker.</div></center>

<div class="fright padb10 clr2" style="padding-left:50px;">
	<a href="javascript:viewHoros('<?=$sessMatriId?>');" class="smalltxt clr1">View My Horoscope</a>&nbsp;&nbsp;<input type="button" class="button" value="Edit" onClick="nextPage('/horoscope/?act=addhoroscope&edit=yes');" />&nbsp;&nbsp;<input type="button" class="button" value="Delete" onClick="deleteHoro();" /></div><br><br clear="all">


<? } else {

	//COUNTRY LIST
	$varFields		= array('Country_Id','Country_Name');
	$varExecute		= $objSlaveDB->select($varTable['HOROCOUNTRIES'], $varFields, '',0);
	$varCountryList	= '';

	while($varCountyinfo	= mysql_fetch_array($varExecute)) {
		$varSelected = ($varBirthCountry==$varCountyinfo['Country_Id']) ? 'SELECTED' : '';
		$varCountryList	.= '<option value="'.$varCountyinfo['Country_Id'].'" '.$varSelected.'>'.$varCountyinfo['Country_Name'].'</option>';
	}//while


	?>

	<div class="padt10">
	<form name="generateHoroscope" method="post">
	<input type="hidden" name="generateHoroscopeSubmit" value="yes">
	<input type="hidden" name="countryName" value="">
	<input type="hidden" name="stateName" value="">
	<input type="hidden" name="cityName" value="">
	<input type="hidden" name="edit" value="<?=$varEdit?>">
	<? if($varGenerateHoroMsg !='') { echo '<div class="fleft errortxt" style="padding-top:10px;padding-bottom:10px;">'.$varGenerateHoroMsg.'</div>'; } ?>
	<div class="fright opttxt"><span class="clr3">*</span> Mandatory</div><br clear="all">
						<div class="pfdivlt smalltxt fleft tlright" >Date of Birth<span class="clr3">*</span></div>
						<div class="pfdivrt fleft tlleft">&nbsp;
						<select size="1" name="month" class="smalltxt select1" style="width:95px;" onBlur="funGenerateHoroChk();">
							<option value="0">-- Month --</option>
							<option value="01" <?=$varBirthMonth=='1' ? 'SELECTED' : ''?>>January</option>
							<option value="02" <?=$varBirthMonth=='2' ? 'SELECTED' : ''?>>February</option>
							<option value="03" <?=$varBirthMonth=='3' ? 'SELECTED' : ''?>>March</option>
							<option value="04" <?=$varBirthMonth=='4' ? 'SELECTED' : ''?>>April</option>
							<option value="05" <?=$varBirthMonth=='5' ? 'SELECTED' : ''?>>May</option>
							<option value="06" <?=$varBirthMonth=='6' ? 'SELECTED' : ''?>>June</option>
							<option value="07" <?=$varBirthMonth=='7' ? 'SELECTED' : ''?>>July</option>
							<option value="08" <?=$varBirthMonth=='8' ? 'SELECTED' : ''?>>August</option>
							<option value="09" <?=$varBirthMonth=='9' ? 'SELECTED' : ''?>>September</option>
							<option value="10" <?=$varBirthMonth=='10' ? 'SELECTED' : ''?>>October</option>
							<option value="11" <?=$varBirthMonth=='11' ? 'SELECTED' : ''?>>November</option>
							<option value="12" <?=$varBirthMonth=='12' ? 'SELECTED' : ''?>>December</option>
						</select>&nbsp;
						
						<select size="1" name="date" class="smalltxt select1" style="width:50px;" onBlur="funGenerateHoroChk();">
							<option value="0">-- Date --</option>
							<option value="01" <?=$varBirthDay=='1' ? 'SELECTED' : ''?>>1</option>
							<option value="02" <?=$varBirthDay=='2' ? 'SELECTED' : ''?>>2</option>
							<option value="03" <?=$varBirthDay=='3' ? 'SELECTED' : ''?>>3</option>
							<option value="04" <?=$varBirthDay=='4' ? 'SELECTED' : ''?>>4</option>
							<option value="05" <?=$varBirthDay=='5' ? 'SELECTED' : ''?>>5</option>
							<option value="06" <?=$varBirthDay=='6' ? 'SELECTED' : ''?>>6</option>
							<option value="07" <?=$varBirthDay=='7' ? 'SELECTED' : ''?>>7</option>
							<option value="08" <?=$varBirthDay=='8' ? 'SELECTED' : ''?>>8</option>
							<option value="09" <?=$varBirthDay=='9' ? 'SELECTED' : ''?>>9</option>
							<option value="10" <?=$varBirthDay=='10' ? 'SELECTED' : ''?>>10</option>
							<option value="11" <?=$varBirthDay=='11' ? 'SELECTED' : ''?>>11</option>
							<option value="12" <?=$varBirthDay=='12' ? 'SELECTED' : ''?>>12</option>
							<option value="13" <?=$varBirthDay=='13' ? 'SELECTED' : ''?>>13</option>
							<option value="14" <?=$varBirthDay=='14' ? 'SELECTED' : ''?>>14</option>
							<option value="15" <?=$varBirthDay=='15' ? 'SELECTED' : ''?>>15</option>
							<option value="16" <?=$varBirthDay=='16' ? 'SELECTED' : ''?>>16</option>
							<option value="17" <?=$varBirthDay=='17' ? 'SELECTED' : ''?>>17</option>
							<option value="18" <?=$varBirthDay=='18' ? 'SELECTED' : ''?>>18</option>
							<option value="19" <?=$varBirthDay=='19' ? 'SELECTED' : ''?>>19</option>
							<option value="20" <?=$varBirthDay=='20' ? 'SELECTED' : ''?>>20</option>
							<option value="21" <?=$varBirthDay=='21' ? 'SELECTED' : ''?>>21</option>
							<option value="22" <?=$varBirthDay=='22' ? 'SELECTED' : ''?>>22</option>
							<option value="23" <?=$varBirthDay=='23' ? 'SELECTED' : ''?>>23</option>
							<option value="24" <?=$varBirthDay=='24' ? 'SELECTED' : ''?>>24</option>
							<option value="25" <?=$varBirthDay=='25' ? 'SELECTED' : ''?>>25</option>
							<option value="26" <?=$varBirthDay=='26' ? 'SELECTED' : ''?>>26</option>
							<option value="27" <?=$varBirthDay=='27' ? 'SELECTED' : ''?>>27</option>
							<option value="28" <?=$varBirthDay=='28' ? 'SELECTED' : ''?>>28</option>
							<option value="29" <?=$varBirthDay=='29' ? 'SELECTED' : ''?>>29</option>
							<option value="30" <?=$varBirthDay=='30' ? 'SELECTED' : ''?>>30</option>
							<option value="31" <?=$varBirthDay=='31' ? 'SELECTED' : ''?>>31</option>
						</select>&nbsp;&nbsp;
						
						<select size="1" name="year" class="smalltxt select1" style="width:70px;" onBlur="funGenerateHoroChk();">
							<option value="0">-- Year --</option>
							<? 
								$varEndYear		= (date("Y")-18);
								$varStartYear	= ($varEndYear-56);

								for ($i=$varEndYear;$i>=$varStartYear;$i--) 
								{ 
									$varSelected = ($i==$varBirthYear) ? 'SELECTED' : '';
									echo '<option value="'.$i.'" '.$varSelected.'>'.$i.'</option>'; 
								
								}//for
							?>
						</select><br><span id="dobspan" class="errortxt"></span></div><br clear="all"/>
						
		
						<div class="pfdivlt smalltxt fleft tlright" >Time of Birth<span class="clr3">*</span></div>
						<div class="pfdivrt fleft tlleft">&nbsp;
						<select size="1"  name="hours" class="smalltxt select1" style="width:95px;" onBlur="funGenerateHoroChk();">
							<option value="0">Hours</option>
							<option value="01" <?=$varBirthHour=='1' ? 'SELECTED' : ''?>>1</option>
							<option value="02" <?=$varBirthHour=='2' ? 'SELECTED' : ''?>>2</option>
							<option value="03" <?=$varBirthHour=='3' ? 'SELECTED' : ''?>>3</option>
							<option value="04" <?=$varBirthHour=='4' ? 'SELECTED' : ''?>>4</option>
							<option value="05" <?=$varBirthHour=='5' ? 'SELECTED' : ''?>>5</option>
							<option value="06" <?=$varBirthHour=='6' ? 'SELECTED' : ''?>>6</option>
							<option value="07" <?=$varBirthHour=='7' ? 'SELECTED' : ''?>>7</option>
							<option value="08" <?=$varBirthHour=='8' ? 'SELECTED' : ''?>>8</option>
							<option value="09" <?=$varBirthHour=='9' ? 'SELECTED' : ''?>>9</option>
							<option value="10" <?=$varBirthHour=='10' ? 'SELECTED' : ''?>>10</option>
							<option value="11" <?=$varBirthHour=='11' ? 'SELECTED' : ''?>>11</option>
							<option value="12" <?=$varBirthHour=='12' ? 'SELECTED' : ''?>>12</option>
						</select>&nbsp;
						
						<select size="1"  name="mins" class="smalltxt select1" style="width:50px;" onBlur="funGenerateHoroChk();">
							<option value="">Min</option>
							<? 

							$varSelected = '';
							for ($i=0;$i<=59;$i++) { 
								if ($varEdit=='yes') { $varSelected = ($i==$varBirthMinute) ? 'SELECTED' : '';  } 
									echo '<option value="'.$i.'" '.$varSelected.'>'.$i.'</option>';
							}

							?>
						</select>&nbsp;&nbsp;
						
						<select size="1"  name="meridiem" class="smalltxt select1" style="width:70px;" onBlur="funGenerateHoroChk();">
							<option value="0">Meridiem</option>
							<option value="AM" <?=$varBirthMeridian=='AM' ? 'SELECTED' : ''?>>AM</option>
							<option value="PM" <?=$varBirthMeridian=='PM' ? 'SELECTED' : ''?>>PM</option>
						</select><br><span id="timeofbirthspan" class="errortxt"></span></div><br clear="all"/>

						<div class="pfdivlt smalltxt fleft tlright" >Country of Birth<span class="clr3">*</span></div>
						<div class="pfdivrt fleft tlleft">&nbsp;
							<select size="1" name="country" class="smalltxt select1" style="width:230px;" onChange="generateStateList();" onBlur="funGenerateHoroChk();">
								<option value="0">--- Select county ---</option>
								<?=$varCountryList?>
							</select><br><span id="countryspan" class="errortxt"></span></div><br clear="all"/>

						<div class="pfdivlt smalltxt fleft tlright" >State of Birth<span class="clr3">*</span></div>
						<div class="pfdivrt fleft tlleft" id="stateList">&nbsp;
						<select size="1" name="state" class="smalltxt select1" style="width:230px;">
							<option value="0">--- Select State ---</option>
						</select><br><span id="statespan" class="errortxt"></span></div><br clear="all"/>

						<div class="pfdivlt smalltxt fleft tlright" >City of Birth<span class="clr3">*</span></div>
						<div class="pfdivrt fleft tlleft" id="cityList">&nbsp;
							<select size="1" name="city" class="smalltxt select1" style="width:230px;">
								<option value="0">--- Select city ---</option>
								<?=$varCitiList?>
							</select><br><span id="cityspan" class="errortxt"></span></div><br clear="all"/>

						<div class="pfdivlt smalltxt fleft tlright" >Chart Style</div>
						<div class="pfdivrt fleft tlleft">&nbsp;
							<select size="1" name="chartStyle" class="smalltxt select1" style="width:230px;">
								<?=$objHoroscope->horoscopeArrayList($arrChartFormat, 0);?>
							</select></div><br clear="all"/>
						
						<center><div class="padtb10 smalltxt tljust clr2" style="width:500px;">Note: This process is compatible only in Internet Explorer 5.5 and above. This process will not function in IE Service Pack 1 or/and Opera, if the you have activated the popup blocker.</div></center>


	
						<div class="fright padr20"><input type="button" name="send" class="button" value="Save"  onClick="funGenerateHoroscope();">&nbsp;&nbsp;<input type="reset" class="button" value="Reset"></div><br clear="all">
					</form> 
					</div>
					<br clear="all"/>
<? if ($varEdit=='yes') { ?>
<script>generateStateList();</script>

<? 
	} 
} ?>-->