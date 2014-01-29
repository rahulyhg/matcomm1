<?php
//*************************************
// File Name	: mailconfig.php
// Code By		: Pradeep, Ashok kumar
//*************************************
include "/home/cbsmailmanager/config/config.php";
include_once "lib/authenticate.php";
include "/home/cbsmailmanager/bmconf/bmvarssearcharrincen.inc";
include "/home/cbsmailmanager/config/header.php";
include "/home/cbsmailmanager/config/styleheader.php";
//ini_set('DISPLAY_ERRORS',1);
//error_reporting(E_ALL);
if ( $_POST['do_submit'] == "Submit" ) {
	$categoryname	= trim($_POST['category']);         // select Catagory name
	$memberstatus   = trim($_POST['memberstatus']);     //  For What Kind of Members? 
	$validated		= trim($_POST['validated']);        // Is for Validated?
	$authorise		= trim($_POST['authorise']);        // Is for Authorised?
	$paidmembers    = trim($_POST['paidmembers']);      // Is for Paid members?
	$phone		    = trim($_POST['phone']);            // Is for Phone Verified?
	$profile        = trim($_POST['profile']);          // Is for Profile Verified?
	$oavailable     = trim($_POST['oavailable']);		// Is for Offer Available?
	$phystatus      = trim($_POST['phystatus']);		// Physical Status?
	$testemails		= trim($_POST['testemails']);       // Restrict Domains
	$allowemails	= trim($_POST['allowemails']);      // Allowed Domains
	$remarks		= trim($_POST['remarks']);          // Remarks
	$fromlastlogin  = trim($_POST['fromlastlogin']);    // From LastLogin
	$tolastlogin    = trim($_POST['tolastlogin']);      // To last login
	$fromtimecreated = trim($_POST['fromtimecreated']); // From Time Created
	$totimecreated  = trim($_POST['totimecreated']);    // To Time Created
	$gender         = trim($_POST['gender']);           // Gender
	$agefrom        = trim($_POST['agefrom']);          // Age From
	$ageto          = trim($_POST['ageto']);            // Age To
	$xpriority      =trim($_POST['priority']);          // X - Prioritys
	$bywhom         =trim($_POST['bywhom']);
	$expiry         =trim($_POST['expire']);
	$castenobar     =trim($_POST['cnobar']);
	$option_andor   =trim($_POST['andor']); 
	$expirydate_from  =trim($_POST['exdatef']);
	$expirydate_to   =trim($_POST['exdatet']);
	
	// Newly added conditions;
	$PhotoAvl		= trim($_POST['photoavailable']);
	$PhotoProtected	= trim($_POST['photoprotected']);
	$VoiceAvl		= trim($_POST['videoavailable']);
	$VideoAvl		= trim($_POST['voiceavailable']);
	$HealthProfAvl	= trim($_POST['hpavailable']);
	$logincountfrom	= trim($_POST['logincountfrom']);
	$logincountto	= trim($_POST['logincountto']);
	$mailerunsubtype	= trim($_POST['mailerunsubtype']);
	$offercategoryid	= trim($_POST['offercategoryid']);
	$sendtype		= trim($_POST['sendtype']);
	$membertype		= trim($_POST['membertype']);

	if($membertype==1) {
		$dblink->dbClose();
		$category = 'cbs'.$categoryname;
		$dblink1 = new db();
		$dblink1->connect($DBCONIP['DB15'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['COMMUNITYMATRIMONY']);			
	} else {
		$category = $categoryname;
	}
	

	$writefilename = "/home/cbsmailmanager/mfiles/".$category.".txt";

	$bywhom = '';
	if (is_array($_POST['bywhom'])) {
	foreach($_POST['bywhom'] as $whomkey => $whomval) {
		$bywhom .= $whomval.",";
	}
	$bywhom = substr ($bywhom, 0, strlen($bywhom)-1);
	}

	// Language sepration...
	$language = '';
	if (is_array($_POST['language'])) {
	foreach($_POST['language'] as $langkey => $langval) {
		$language .= $langval.",";
	}
	$language = substr ($language, 0, strlen($language)-1);
	}

	//Country sepration...
	$country = '';
	if (is_array($_POST['country'])) {
	foreach($_POST['country'] as $countkey => $countval) {
		$country .= $countval.",";
	}
	$country = substr ($country, 0, strlen($country)-1);
	}

	//Indian State sepration...
	$indianstate = '';
	if (is_array($_POST['residingindianames'])) {
	foreach($_POST['residingindianames'] as $instatekey => $instateval) {
		$indianstate .= $instateval.",";
	}
	$indianstate = substr ($indianstate, 0, strlen($indianstate)-1);
	}

	//US State sepration...
	$usstate = '';
	if (is_array($_POST['residingusanames'])) {
	foreach($_POST['residingusanames'] as $usstatekey => $usstateval) {
		$usstate .= $usstateval.",";
	}
	$usstate = substr ($usstate, 0, strlen($usstate)-1);
	}
	
	//District sepration...
	$district = '';
	if (is_array($_POST['residingdistrict'])) {
	foreach($_POST['residingdistrict'] as $districtkey => $districtval) {
		$district .= $districtval.",";
	}
	$district = substr ($district, 0, strlen($district)-1);
	}
	
	//others District sepration...
	$otherdistrict = '';
	if (is_array($_POST['residingotherdistrict'])) {
	foreach($_POST['residingotherdistrict'] as $otherdistrictkey => $otherdistrictval) {
		$otherdistrict .= $otherdistrictval.",";
	}
	    $otherdistrict = substr ($otherdistrict, 0, strlen($otherdistrict)-1);
	}	

	//MotherTongue sepration...
	$mothertongue = '';
	if (is_array($_POST['mothertongue'])) {
	foreach($_POST['mothertongue'] as $mothertonguekey => $mothertongueval) {
		$mothertongue .= $mothertongueval.",";
	}
	$mothertongue = substr ($mothertongue, 0, strlen($mothertongue)-1);
	}
	
	//Religion sepration...
	$religion = '';
	if (is_array($_POST['religion'])) {
	foreach($_POST['religion'] as $religionkey => $religionval) {
		$religion .= $religionval.",";
	}
	$religion = substr ($religion, 0, strlen($religion)-1);
	}

	//Caste sepration...
	$caste = '';
	if (is_array($_POST['caste'])) {
	foreach($_POST['caste'] as $castekey => $casteval) {
		$caste .= $casteval.",";
	}
	$caste = substr ($caste, 0, strlen($caste)-1);
	}

	// Education sepration...
	$education = '';
	if (is_array($_POST['education'])) {
	foreach($_POST['education'] as $edukey => $eduval) {
		$education .= $eduval.",";
	}
	$education = substr ($education, 0, strlen($education)-1);
	}

	//occupation-Added by Anish
	$occupation = '';
	if (is_array($_POST['occupation'])) {
	foreach($_POST['occupation'] as $occkey => $occval) {
		$occupation .= $occval.",";
	}
	$occupation = substr ($occupation, 0, strlen($occupation)-1);
	}

	//familystatus
	if (is_array($_POST['familystatus'])) {
	foreach($_POST['familystatus'] as $familykey => $familyval) {
		$familystatus .= $familyval.",";
	}
	$familystatus = substr ($familystatus, 0, strlen($familystatus)-1);
	}

	//Profile Status sepration...
	$status = '';
	if (is_array($_POST['status'])) {
	foreach($_POST['status'] as $statuskey => $statusval) {
		$status .= $statusval.",";
	}
	$status = substr ($status, 0, strlen($status)-1);
	}

	//Horoscope  sepration...
	$horoscope = '';
	if (is_array($_POST['horoscope'])) {
	foreach($_POST['horoscope'] as $horokey => $horoval) {
		$horoscope .= $horoval.",";
	}
	$horoscope = substr ($horoscope, 0, strlen($horoscope)-1);
	}

	// Newly added conditions.....

	//subcaste 
	$subcaste = '';
	if (is_array($_POST['subcaste'])) {
	foreach($_POST['subcaste'] as $subcastekey => $subcasteval) {
		$subcaste .= $subcasteval.",";
	}
	$subcaste = substr ($subcaste, 0, strlen($subcaste)-1);
	}

	// No of Payment
	$NoofPayment = '';
	if (is_array($_POST['paymentcnt'])) {
	foreach($_POST['paymentcnt'] as $paymentkey => $paymentval) {
		$NoofPayment .= $paymentval.",";
	}
	$NoofPayment = substr ($NoofPayment, 0, strlen($NoofPayment)-1);
	}

	// maritalval
	$MaritalStatus = '';
	if (is_array($_POST['maritalval'])) {
	foreach($_POST['maritalval'] as $Maritalkey => $Maritalval) {
		$MaritalStatus .= $Maritalval.",";
	}
	$MaritalStatus = substr ($MaritalStatus, 0, strlen($MaritalStatus)-1);
	$tempstatus = explode(",",$MaritalStatus);
	if(in_array(0,$tempstatus )){
		$MaritalStatus ='';
	}
	}
	
	$writecontent = $category."::".$language."::".$country."::".$testemails."::".$validated."::".$authorise."::".$status."::".$paidmembers."::".$phone."::".$remarks."::".$memberstatus."::".date('Y-m-d H:i:s')."::".$fromlastlogin."::".$tolastlogin."::".$education."::".$fromtimecreated."::".$totimecreated."::".$gender."::".$agefrom."::".$ageto."::".$allowemails."::".$profile."::".$indianstate."::".$usstate."::".$district."::".$mothertongue."::".$religion."::".$caste."::".$xpriority."::".$bywhom."::".$expiry."::".$castenobar."::".$occupation."::".$option_andor."::".$expirydate_from."::".$expirydate_to."::".$familystatus."::".$oavailable."::".$phystatus."::".$horoscope."::".$PhotoAvl."::".$PhotoProtected."::".$VoiceAvl."::".$VideoAvl."::".$HealthProfAvl."::".$logincountfrom."::".$logincountto."::".$subcaste."::".$NoofPayment."::".$MaritalStatus."::".$mailerunsubtype."::".$offercategoryid."::".$sendtype."::".$membertype."::".$otherdistrict;

	// Writing the email setting into a flat text file...
	if (!$handle = fopen($writefilename, 'w+')) {
        echo "Cannot open file ($filename)";
        exit;
	}
	if (fwrite($handle, $writecontent) === FALSE) {
       echo "Cannot write to file ($filename)";
       exit;
	}

	$writecontent;
	fclose($handle);
	$QueryType = "select";
	if($membertype ==1) {
		global $dblink1;
		$mailsql = cbsCreateQuery($category,$QueryType);
		$mailres = mysql_query ($mailsql,$dblink1);
		$mailnum = recordcount($QueryType,$mailres);
	} else {
		global $dblink;
		$mailsql = CreateQuery($category,$QueryType);
		$mailres = mysql_query ($mailsql,$dblink);
		$mailnum = recordcount($QueryType,$mailres);
	}

	$reportheader  = "MIME-Version: 1.0\n";
	$reportheader .= "From: MailManager<info@communitymatrimony.com\n";
	$reportheader .= "Content-type: text/html\n";
	$reportheader .= "Sender: communitymatrimony.com<info@communitymatrimony.com>\n";
	$reportheader .= "Reply-To: noreply@communitymatrimony.com\n";
	$reportheader .= "X-Mailer: PHP mailer\n";

	$reportsubject = " Query : ".$mailsql."<br>";
	$reportsubject .= " Count : ".$mailnum;

	mail($ReportEmailids,"Query Generated - $category",$reportsubject,$reportheader);
	
	echo "<table><tr><td class='smalltxt'><font color='red'>Query Configured</font></td></tr></table>";
}
?>
<script type="text/javascript">



var cities=new Array();
cities[1]=["Select-one|0", "BM-PRcase1|1", "BM-PRcase2|2", "BM-Inactive|3", "BM-Deleted|4", "BM-classified|5", "BM-General|6"];
cities[2]=["Select-one|0", "CBS-PRcase1|1", "CBS-PRcase2|2", "CBS-Inactive|3", "CBS-Deleted|4", "BM-classified|5", "CBS-General|6"];

function updatecities(selectedcitygroup){
var citieslist=document.classic.cities;
alert(citieslist);
citieslist.options.length=0;
	if (selectedcitygroup>0){
		for (i=0; i<cities[selectedcitygroup].length; i++) {
			citieslist.options[citieslist.options.length]=new Option(cities[selectedcitygroup][i].split("|")[0], cities[selectedcitygroup][i].split("|")[1]);
		}
	}
}

function dspmailertype(val) {
	var getVal=document.getElementById("cities").options;
	alert(getVal);
	if (val ==4) {
		getVal[4].selected = true;
		getVal.disabled =true;
	} else if (val ==3) {
		getVal[1].selected = true;
		getVal.disabled =true;
	}else if (val ==2) {
		getVal[3].selected = true;
		getVal.disabled =true;
	} else if (val ==1) {
		getVal[2].selected = true;
		getVal.disabled =true;
	} else if (val ==5) {
		getVal[5].selected = true;
		getVal.disabled =true;
	}
}

</script>

<table border="0" cellpadding="0" cellspacing="0" align="center" width="780" class="maintborder" bgcolor="#ffffff">
<tr>
	<td valign="top" width="148" bgcolor=#E9E9E9 >
	<!--Left Menu Start-->		
	<? include "/home/cbsmailmanager/config/leftmenu.php"; ?>
	<!--Left Menu End-->		
	</td>

	<td valign="top" bgcolor=#B5B5B5 class="borderclr"><img src="/images/trans.gif" width="1" height="1"></td>
	<td width="5">&nbsp;</td>

	<td valign="top" width="625">
	<br>
	<!--Middle Area Start-->		
		<form name="classic" method="post">
			<!-- <select name="countries" size="4" onChange="updatecities(this.selectedIndex)" style="width: 150px">
			<option selected>Select MailerType</option>
			<option value="usa">BM Members</option>
			<option value="canada">CBS Members</option>
			</select> -->
			<table>
			<tr>
			<td>
			<input type="radio" name="membertype" id="membertype" value='2' onclick="updatecities(this.value)"> CBS Members
			<input type="radio" name="membertype" id="membertype"value='1'  onclick="updatecities(this.value)"> BM Members					</td></tr>
						
			<tr>
				<td class="title"> For What Kind of Members?  </td>
				<td>  <select  class="smalltxt" name="memberstatus" onchange="dspmailertype(value);">
						<option value="x">--Select One--</option>
						<!-- COMMENTED TYPES ARE DEPRECATED -->
						<!-- <option value="0">All</option> -->
						<option value="1">Members</option>
						<option value="2">Inactive Member</option>
						<option value="3">Past Members</option>
						<option value="4">Partly Register Case 1</option>
						<option value="5">Partly Register Case 2</option>		
					 </select>
				</td>
			</tr>	
<tr><td>
			<select name="cities" class="smalltxt" size="1" id="cities"><option value="x">--Select One--</option></select>
			</td></tr>
			</table>
		</form> 	
		<!--Middle Area End-->		
	</td>
</tr>
</table>
<?
include "/home/cbsmailmanager/config/footer.php";
?>