<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
#================================================================================================================
//FILE INCLUDES
$varServerRoot		= $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath	= dirname($varServerRoot);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$sessPaidStatus	= 1;

//OBJECT INITIALIZATION
$objSlaveDB	= new DB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

//VARIABLE
$varPartnerId	= $varGetCookieInfo['partnerId'];

echo 'Paid Status='.$sessPaidStatus;
if ($sessPaidStatus==1) {

	
//SELECT LOGGED MEMBER HORO DETAILS
$varCondition	= " WHERE MatriId= ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
$varFields	= array('BirthDay','BirthMonth','BirthYear','BirthHour','BirthMinute','BirthSeconds','BirthMeridian','MatriId','BirthCity','BirthState','BirthLongitude','BirthLatitude','Language','RequestDateTime','Charttype','BirthCountry','TimeCorrection','ChartStyle','PlanetPositions','StarCheck','KujaCheck','DasaCheck','PapaCheck','StarValue','RasiValue','KujaDosha','RahuDosha');
$varExecute	= $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
$varMyInfo	= mysql_fetch_array($varExecute);


//SELECT PARTNER MEMBER HORO DETAILS
$varCondition	= " WHERE MatriId= ".$objSlaveDB->doEscapeString($varPartnerId,$objSlaveDB);
$varFields	= array('BirthDay','BirthMonth','BirthYear','BirthHour','BirthMinute','BirthSeconds','BirthMeridian','MatriId','BirthCity','BirthState','BirthLongitude','BirthLatitude','Language','RequestDateTime','Charttype','BirthCountry','TimeCorrection','ChartStyle','PlanetPositions','StarCheck','KujaCheck','DasaCheck','PapaCheck','StarValue','RasiValue','KujaDosha','RahuDosha');
$varExecute		= $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
$varPartnerInfo	= mysql_fetch_array($varExecute);

//print_r($varMyInfo);
	
	?>
<!--Quick Links-->
<div id="rndcorner" style="float:left;width:565px;">
<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
<div class="middiv-pad" id="toolsid">
<div class="fleft">
	<div class="tabcurbg fleft">
		<div class="fleft">

			<div class="fleft tabclrleft"></div>
			<div class="fleft tabclrrtsw"><div class="tabpadd mediumtxt boldtxt clr4"> AstroMatch </div></div>
		</div>	
	</div>
	<div class="fleft tr-3"></div>								
</div>
<!-- Content Area -->
<div style="width:543px;">
	<div class="bl"><div class="br">
	 <div style="padding:0px 17px 10px 17px;">

	 <div style="padding:0px 15px 10px 15px;">
	 	<!-- Middle form start -->
		<form name="frm"  method="post" action="horomatchcomposexml.php" accept-charset="ISO-8859-1" style="margin:0px;">
				<div class="smalltxt">
		  <div class="mediumtxt boldtxt">Real Time Horoscope Matching</div>
		  <div style="text-align:justify; padding:7px 0px 0px 0px;">Now you can do real time horoscope matching with a prospective life partner to find out how compatible you are as a couple. You can get your reports in 3 different formats (North, South and West) and also in 6 different languages English, Tamil, Malayalam, Hindi, Kannada and Telugu. More languages will be added shortly.</div>
          <div style="text-align:justify; padding:10px 0px 0px 0px;">AstroMatch is based on place, date and time of birth. BharatMatrimony has these details only for those members who have generated their horoscope through our system.</div>

		  <div style="text-align:justify; padding:10px 0px 0px 0px;">
		    <div style="float:left;"><img src="http://imgs.tamilmatrimony.com/bmimages/astromatch-horo-icon-1.gif" width="27" height="25" hspace="3" align="absbottom" alt="Scanned horoscope"></div>
			<div style="float:left; width:440px; text-align:justify; padding-left:5px;">Denotes that member has generated a horoscope through BharatMatrimony which means you can do an instant AstroMatch.</div>
		  </div>

		  <div style="float:left; padding:12px 0px 0px 0px;">
			<div style="float:left;"><img src="http://imgs.tamilmatrimony.com/bmimages/astromatch-horo-icon-2.gif" width="27" height="23" hspace="3" alt="Computer generated horoscope"></div>
			<div style="float:left; width:440px; text-align:justify; padding-left:5px;">Denotes that member has added a scanned horoscope. In this case BharatMatrimony does not have their place, date and time of birth details. To match against this member you need to enter his/her details, which maybe available in the scanned horoscope or you can request member for their details.</div>

		 </div><br clear="all">

		  <div style="padding:12px 0px 0px 0px;">
		  <div style="padding:2px 0px 2px 10px; background-color:#E0EDC2; border:1px solid #CAD6AE;">Currently you have 197 AstroMatches remaining</div></div>
		  <div id="newdiv" style="padding:12px 0px 0px 0px;" class="fleft"> 
		  <div class="fleft"><div style="float:left; width:230px;border:1px solid #C9D4AE;">
		<div style="float:left; width:230px; background:url(http://imgs.tamilmatrimony.com/bmimages/live-hlp-div-bg.gif) repeat-x; margin:1 0 1 0;"><div style="margin:0 2 2 10;"><div style="width:205px;">

					<div style="padding-top:10px;"><font class="mediumtxt boldtxt">Your details</font></div>

					<div class="dottedline" style="background: url('http://img.bharatmatrimony.com/bmimages/dot.gif') repeat-x 0px 3px;">

					<div class="smalltxt boldtxt" style="padding-top:10px;">Matrimony ID</div>
					<div class="smalltxt">M982397<input type="hidden" size=25 name="F_REGNO" class="addtextfiled" value="M982397"></div>
					
					<div class="smalltxt boldtxt" style="padding-top:10px;">Name</div>
					<div class="smalltxt"><input type="hidden" size=25 name="F_PERSON_FNAME" class="addtextfiled" value="priya">priya</div>

					<div class="smalltxt boldtxt" style="padding-top:10px;">Date of Birth</div>
					<div class="smalltxt">1-1-1983<input type="hidden" NAME="F_BIRTH_DAY" value=1><input type="hidden" NAME="F_BIRTH_MONTH" value=1><input type="hidden" NAME="F_BIRTH_YEAR" value=1983></div>
					
					<div class="smalltxt boldtxt" style="padding-top:10px;">Time of Birth</div>
					<div class="smalltxt">04 Hr 26 Min 0 Sec [24 Hr]<input type="hidden" NAME="F_BIRTH_HOUR" value=4><input type="hidden" NAME="F_BIRTH_MIN" value=26><input type="hidden" NAME="F_BIRTH_SEC" value=0></div><!--country selection -->
					<div class="smalltxt boldtxt" style="padding-top:10px;">Country of Birth</div>
					<div class="smalltxt">India<input type=hidden NAME="F_Countries" id="F_Countries" value="India"></div><!--endcountry--><!--state selection -->

					
					<div class="smalltxt boldtxt" style="padding-top:10px;">State of Birth</div>
					<div class="smalltxt">Tamil Nadu<input type="hidden" id="F_States" name="F_States" value="Tamil Nadu"><input type="hidden" name="populateState" value="Tamil Nadu"><input type="hidden" name="populateCity" value="Salem"></div><!--endstate--><!--city selection -->
					<div class="smalltxt boldtxt" style="padding-top:10px;">City of Birth</div>
					<div class="smalltxt">Salem<input type="hidden" id="F_Cities" name="F_Cities" value="Salem"></div><div class="smalltxt boldtxt" style="padding-top:10px;">Time correction</div>
					<div class="smalltxt"><select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="F_TIMECORRECTION" size="1">
					<option value="1" Selected>Standard Time</option>

					<option value="2">Daylight Saving</option></select></div></div><INPUT TYPE="hidden" NAME="F_PLACE_LONGITUDE_HOUR" readonly value = "078" size=7 class="addtextfiled" id="F_PLACE_LONGITUDE_HOUR">&nbsp;<INPUT TYPE="hidden" NAME="F_PLACE_LONGITUDE_MIN" readonly value = "10" size=7 class="addtextfiled" id="F_PLACE_LONGITUDE_MIN">&nbsp;<input type="hidden" name="F_PLACE_LONGITUDE_DIR" readonly value = "E" size=3 class="addtextfiled" id="F_PLACE_LONGITUDE_DIR"><INPUT TYPE="hidden" NAME="F_PLACE_LATITUDE_HOUR" readonly value = "11" size=7 class="addtextfiled" id="F_PLACE_LATITUDE_HOUR">&nbsp;<INPUT TYPE="hidden" NAME="F_PLACE_LATITUDE_MIN" readonly value = "40" size=7 class="addtextfiled" id="F_PLACE_LATITUDE_MIN">&nbsp;<input type="hidden" name="F_PLACE_LATITUDE_DIR" readonly value = "N" size=3 class="addtextfiled" id="F_PLACE_LATITUDE_DIR"><INPUT TYPE="hidden" NAME="F_TIMEZONE" readonly value = "05.30E" size=25 class="addtextfiled" id="F_TIMEZONE"><input type="hidden" name="F_BIRTH_PLACE_NAME" value="" id="F_BIRTH_PLACE_NAME"> <!-- used to set the place of birth -->
					<input type="hidden" name="CUSTID" value="M982397"> <!-- used to set the login members matriid as custid -->
					<input type="hidden" name="findlogingend" id="findlogingend" value="F"> <!-- used to find the login mem gender for inserting into db astromatch --><input type="hidden" name="F_BirthMedian" value="AM"></div></div></div></div></div>		  </div>
		  <div class="fleft" width="13"><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" width="13" height="1"></div>
		  <div class="fleft" style="padding:12px 0px 0px 0px;">
		  <div class="fleft"><div style="float:left; width:230px;border:1px solid #C9D4AE;">

		<div style="float:left; width:230px; background:url(http://imgs.tamilmatrimony.com/bmimages/live-hlp-div-bg.gif) repeat-x; margin:1 0 1 0;"><div style="margin:0 2 2 10;"><div style="width:205px;">
		<div style="padding-top:10px;"><font class="mediumtxt boldtxt">Partner details</font></div>
		<div class="dottedline" style="background: url('http://img.bharatmatrimony.com/bmimages/dot.gif') repeat-x 0px 3px;">

		<div class="smalltxt boldtxt" style="padding-top:10px;">Matrimony ID</div>
		<div class="smalltxt">M1409908<input type="hidden" size=25 name="M_REGNO" class="addtextfiled" value="M1409908"></div>

		<div class="smalltxt boldtxt" style="padding-top:10px;">Name</div>

		<div class="smalltxt">KUMAR SHANKAR<input type="hidden" size=25 name="M_PERSON_FNAME" class="addtextfiled" value="KUMAR SHANKAR"></div>

		<div class="smalltxt boldtxt" style="padding-top:10px;">Date of Birth</div>
		<div class="smalltxt">12-9-1983<input type="hidden" NAME="M_BIRTH_DAY" value=12><input type="hidden" NAME="M_BIRTH_MONTH" value=9><input type="hidden" NAME="M_BIRTH_YEAR" value=1983></div>

		<div class="smalltxt boldtxt" style="padding-top:10px;">Time of Birth</div>
		<div class="smalltxt">00 Hr 12 Min 0 Sec [24 Hr]<input type="hidden" NAME="M_BIRTH_HOUR" value=12><input type="hidden" NAME="M_BIRTH_MIN" value=12><input type="hidden" NAME="M_BIRTH_SEC" value=0></div>

		<!--country selection -->
					
		<div class="smalltxt boldtxt" style="padding-top:10px;">Country of Birth</div>
		<div class="smalltxt">India<input type=hidden id="M_Countries" NAME="M_Countries" value="India"></div><!--endcountry--><!--state selection -->	
		<div class="smalltxt boldtxt" style="padding-top:10px;">State of Birth</div>
		<div class="smalltxt">Tamil Nadu<input type="hidden" id="M_States" name="M_States" value="Tamil Nadu"></div><input type="hidden" name="populateState" value="Tamil Nadu"><input type="hidden" name="populateCity" value="Madurai"><!--endstate--><!--city selection --><div class="smalltxt boldtxt" style="padding-top:10px;">City of Birth</div>
		<div class="smalltxt">Madurai<input type="hidden" id="M_Cities" name="M_Cities" value="Madurai"></div><!--endcity--><div class="smalltxt boldtxt" style="padding-top:10px;">Time correction</div>

			<div class="smalltxt"><select style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="M_TIMECORRECTION" size="1"><option value="1">Standard Time</option>
			<option value="2">Daylight Saving</option></select></div></div><INPUT TYPE="hidden" NAME="M_PLACE_LONGITUDE_HOUR" readonly value = "078" size=7 class="addtextfiled" id="M_PLACE_LONGITUDE_HOUR">&nbsp;<INPUT TYPE="hidden" NAME="M_PLACE_LONGITUDE_MIN" readonly value = "07" size=7 class="addtextfiled" id="M_PLACE_LONGITUDE_MIN">&nbsp;<input type="hidden" name="M_PLACE_LONGITUDE_DIR" readonly value = "E" size=3 class="addtextfiled" id="M_PLACE_LONGITUDE_DIR"><INPUT TYPE="hidden" NAME="M_PLACE_LATITUDE_HOUR" readonly value = "09" size=7 class="addtextfiled" id="M_PLACE_LATITUDE_HOUR">&nbsp;<INPUT TYPE="hidden" NAME="M_PLACE_LATITUDE_MIN" readonly value = "55" size=7 class="addtextfiled" id="M_PLACE_LATITUDE_MIN">&nbsp;<input type="hidden" name="M_PLACE_LATITUDE_DIR" readonly value = "N" size=3 class="addtextfiled" id="M_PLACE_LATITUDE_DIR"><INPUT TYPE="hidden" NAME="M_TIMEZONE" readonly value = "05.30E" size=25 class="addtextfiled" id="M_TIMEZONE"><input type="hidden" name="M_BIRTH_PLACE_NAME" value="Madurai" id="M_BIRTH_PLACE_NAME"> <!-- used to set the place of birth -->
			
			<input type="hidden" name="findlogingendNew" id="findlogingendNew" value="M"> <!-- used to find the login mem gender for inserting into db astromatch --> <input type="hidden" name="partnervalue" id="partnervalue" value="1"><input type="hidden" name="M_BirthMedian" value="AM"></div></div></div></div></div>          </div>
		  </div><br clear=all><!--Middle form end -->
<div>
<div style="width:481px;">
<div style="padding-top:10px;"><font class="mediumtxt boldtxt">Report Type</font></div>

<div class="dottedline" style="background: url('http://img.bharatmatrimony.com/bmimages/dot.gif') repeat-x 0px 3px;">

		<div style="float:left;width:260px;"><div class="smalltxt boldtxt" style="padding-top:10px;">Report Type</div><div class="smalltxt">
		<select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="REPORT_TYPE" size="1">
		 <option value="1" selected>Soulmate Porutham Detailed</option>
		 <option value="0" >Soulmate Porutham Summary</option></select></div></div>	
		<div style="float:left;">					
			<div class="smalltxt boldtxt" style="padding-top:10px;">Report Language</div>
			<div class="smalltxt"><select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="REPORT_LANGUAGE" size="1"><option  value="ENG">English</option>

			<option  value="MAL">Malayalam</option>
			<option  value="TAM">Tamil</option> 

			<option  value="HIN">Hindi</option> 

			<option  value="KAN">Kannada</option> 

			<option  value="TEL">Telugu</option> </select></div>						
		</div> <br clear="all">
		<div><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" width="5"></div>

		<div style="float:left;width:260px;">
			<div class="smalltxt boldtxt" style="padding-top:10px;">Chart Format</div>
			<div class="smalltxt"><select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="REPORT_CHART_FORMAT" size="1" onchange="ch_method()">
			<option value="0" Selected>South Indian</option>
			<option value="1">North Indian</option>
			<option value="2">East Indian</option>

			<option value="3">Kerala</option>
			<option value="1" >South Indian</option>
		</select></div>
		</div>
		<div style="float:left;">					
			<div class="smalltxt boldtxt" style="padding-top:10px;">Method</div>
			<div class="smalltxt"><select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="METHOD" size="1"><option  value="S1">Kerala System</option>

				<option  value="S2" Selected>TamilNadu System</option>
				<option  value="S3">GunaMilan System</option>
				<option  value="S4">North Indian</option></select></div>						
		</div><br clear="all">
	</div>
	<div><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" width="10"></div>

<div style="border:1px solid #C9D4AE;" id="advopt"><div style="background-color:#E0EDC1;padding-left:5px;padding-top:5px;padding-bottom:5px;"><font class="smalltxt boldtxt">Would you like to compare more fields like KujaDosha, PapaSamya and DasaSandhi?</font><br><a href="javascript:opendiv()" class="clr1"><font class="smalltxt clr1">For In-depth Horoscope Match, Click here</font></a></div></div><div id="advopt1" style="display:none;">

	<div style="background-color:#E0EDC1;padding-left:5px;padding-top:5px;padding-bottom:5px;border:1px solid #C9D4AE;"><font class="smalltxt boldtxt">Would you like to compare more fields like KujaDosha, PapaSamya and DasaSandhi?</font><br><a href="javascript:hclosediv()" class="clr1"><font class="smalltxt clr1">For In-depth Horoscope Match, click here</font></a></div>

	<div style="float:left;width:260px;"><div class="smalltxt boldtxt" style="padding-top:10px;">KujaDosha</div><div class="smalltxt">
		
		<select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="KUJADOSHA" size="1">
		 <option value="K0">No KujaDosha Check</option>
			<option value="K1">Ordinary Check</option>
			<option value="K2" Selected>Strict Check</option>

		</select>
		</div></div>	
	
		<div class="fleft">					
			<div class="smalltxt boldtxt" style="padding-top:10px;">PapaSamya</div>
			<div class="smalltxt"><select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="PAPASAMYA" size="1">
			<option value="P0">No PapaSamya Check</option>
			<option value="P1" Selected>Ordinary Check</option></select></div>						
		</div><br clear="all">
	
		<div style="float:left;">

			<div class="smalltxt boldtxt" style="padding-top:10px;">DasaSandhi</div>
			<div class="smalltxt"><select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="DASASANDHI" size="1" onchange="ch_method()">
			<option value="D00">No DasaSandhi Check</option>
			<option value="D03">Ordinary Check</option>
			<option value="D06" Selected>Strict Check</option>
			</select></div>						
		</div></div></div><br clear="all">	<div class="fright" style="padding-top:10px;"><input type="hidden" name="domurl" value="PROFILE.TAMILMATRIMONY.COM"><INPUT TYPE="button" value="Match Horoscope" name="next" onclick="processpage();" class="button"></div><br clear="all">

</form>
</div>
</div><br clear="all">
</div></div>	
</div>	</div>
<!-- Content Area -->
</div>	
     <b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div>

<div class="fleft" style="width:207px;">
 <div style="float:right;width:197px;" id="rightnavh">
 <div style="clear:both;"></div>
 <div>


<? } else { ?>

<div id="rndcorner" style="float:left;width:565px;">
<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
<div class="middiv-pad" id="toolsid">
<div class="fleft">
	<div class="tabcurbg fleft">
		<div class="fleft">

			<div class="fleft tabclrleft"></div>
			<div class="fleft tabclrrtsw"><div class="tabpadd mediumtxt boldtxt clr4"> AstroMatch </div></div>
		</div>	
	</div>
	<div class="fleft tr-3"></div>								
</div>
<!-- Content Area -->
<div style="width:543px;">
	<div class="bl"><div class="br">
	 <div style="padding:0px 17px 10px 17px;" class="smalltxt">

	 	<div style="text-align:justify; padding:7px 0px 0px 0px;"><b>AstroMatch</b> enables you to match horoscope to find out how compatible you are with a prospective life partner  based on Birth Stars, Papasamya, Kujadosha and Dasasandhi. You can get your reports in North, South and West formats in English, Tamil, Malayalam, Hindi, Kannada and Telugu.</div>
		
		<div style="text-align:justify; padding:10px 0px 0px 0px;">AstroMatch is a paid service and costs Rs. 500 / US$ 15 for 50 AstroMatches or Rs. 750 / US$ 23 for 100 AstroMatches.</div>
		
		<div style="text-align:justify; padding:10px 0px 0px 0px;">To do an AstroMatch we need the place, date and time of birth of both you and the person with whom you wish to match your horoscope.</div>

	  <div style="text-align:justify; padding:10px 0px 0px 0px;">
		<div style="float:left;"><img src="http://imgs.tamilmatrimony.com/bmimages/astromatch-horo-icon-1.gif" width="27" height="25" hspace="3" align="absbottom" alt="Scanned horoscope"></div>
		<div style="float:left; width:440px; text-align:justify; padding-left:5px;">Denotes a horoscope generated by member.  To match against this member just click on Match Horoscope to get real time Astro report.</div>

	  </div>

	    <div style="float:left; padding:12px 0px 0px 0px;">
			<div style="float:left;"><img src="http://imgs.tamilmatrimony.com/bmimages/astromatch-horo-icon-2.gif" width="27" height="23" hspace="3" alt="Computer generated horoscope"></div>
			<div style="float:left; width:440px; text-align:justify; padding-left:5px;">Denotes a scanned horoscope added by member. To match against this member you need to enter his/her details available in scanned horoscope or you can request member for details.</div>
		 </div>
		<br clear="all">

		<div style="text-align:justify; padding:10px 0px 0px 0px;">You can subscribe to AstroMatch by<br>1. Selecting preferred Payment Type and Package<br>2. Clicking on "Submit "</div>

<div class="smalltxt">
<form name="astroform" method="POST" onSubmit="return validate()">
<div style="">
<div class="mediumtxt boldtxt" style="padding:5px 0px 0px 0px;">Payment Details</div>
<div class="vdotline1"><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" height="1"></div>
<div class="smalltxt boldtxt" style="padding:10px 0px 10px 0px;">Payment Type<br clear="all">

<input type="radio" NAME="PAYOPTION" value=1>Payment in US$ &nbsp;&nbsp;<input type="radio" NAME="PAYOPTION" value=2>Payment in Indian Rs.
</div>
<div class="vdotline1"><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" height="1"></div>

<div class="smalltxt boldtxt" style="padding:10px 0px 10px 0px;">Payment Package<br clear="all">
<input type="radio" NAME="ASTROMATCHPACK" value=1>Rs. 500 / US$ 15 for 50 Astro Matches &nbsp;&nbsp;
<input type="radio" NAME="ASTROMATCHPACK" value=2>Rs. 750 / US$ 23 for 100 Astro Matches
<input type="hidden" name="Cardtype" value="1">
<input type="hidden" name="ID" value="">
</div>
<div class="vdotline1"><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" height="1"></div>
<div class="fright" style="padding:10px 0px 0px 0px;"><input type="submit" name="horosubmit" class="button" value="Submit"></div>
</div>
</form>
</div>
<br clear="all">
</div>
</div>
</div></div>
<? }//else ?>