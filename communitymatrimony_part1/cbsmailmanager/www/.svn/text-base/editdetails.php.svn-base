<?php
//*************************************
// File Name	: editdetails.php
// Code By		: M.Vijayakanth
//*************************************

include "/home/mailmanager/config/config.php";
include_once "lib/authenticate.php";
include "/home/mailmanager/config/header.php";
include "/home/mailmanager/config/styleheader.php";


/*if ($access != 1) {
	echo "<br> <center> <font class='title'> Sorry, Your are not authorised member to view this page...! <br><br> <a href='index.php'> Back </a> </font> </center>";
	exit;
}*/
if($_GET['type']=='edit'){
$data="/home/mailmanager/mfiles/".$_GET['fname'];
if (!$handle = fopen($data, 'r')){
        echo "Cannot open file ($data)";
        exit;
	}
$theData = fgets($handle);
$file=explode("::",$theData);
$category=$file[0];
$language=$file[1];
$country=$file[2];
$testemails=$file[3];
$validated=$file[4];
$authorise=$file[5];
$status=$file[6];
$paidmembers=$file[7];
$phone=$file[8];
$remarks=$file[9];
$memberstatus=$file[10];
$date=$file[11];
$fromlastlogin=$file[12];
$tolastlogin=$file[13];
$education=$file[14];
$fromtimecreated=$file[15];
$totimecreated=$file[16];
$gender=$file[17];
$agefrom=$file[18];
$ageto=$file[19];
$allowemails=$file[20];
$profile=$file[21];
$indianstate=$file[22];
$usstate=$file[23];
$district=$file[24];
$mothertongue=$file[25];
$religion=$file[26];
$caste=$file[27];
$xpriority=$file[28];
$bywhom=$file[29];
$expiry=$file[30];
$castenobar=$file[31];
$occupation=$file[32];
$option_andor=$file[33];
$expirydate_from=$file[34];
$expirydate_to=$file[35];
$familystatus=$file[36];
$oavailable=$file[37];
$phystatus=$file[38];
$horoscope=$file[39];
$PhotoAvl=$file[40];
$PhotoProtected=$file[41];
$VoiceAvl=$file[42];
$VideoAvl=$file[43];
$HealthProfAvl=$file[44];
$logincountfrom=$file[45];
$logincountto=$file[46];
$subcaste=$file[47];
$NoofPayment=$file[48];
$MaritalStatus=$file[49];
$mailerunsubtype=$file[50];
$offercategoryid=$file[51];
}


if ( $_POST['do_submit'] == "Submit" ) {

	$category		= trim($_POST['category']);         // select Catagory
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

	//and or condition
	//$language		= trim($_POST['language']);
	//$country		= trim($_POST['country']);
	//$actionflag	= trim($_POST['actionflag']);
	//$status1		= trim($_POST['status1']);
	//$status2		= trim($_POST['status2']);
	//$status3		= trim($_POST['status3']);

	$writefilename = "/home/mailmanager/mfiles/".$category.".txt";
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
	
	$writecontent = $category."::".$language."::".$country."::".$testemails."::".$validated."::".$authorise."::".$status."::".$paidmembers."::".$phone."::".$remarks."::".$memberstatus."::".date('Y-m-d H:i:s')."::".$fromlastlogin."::".$tolastlogin."::".$education."::".$fromtimecreated."::".$totimecreated."::".$gender."::".$agefrom."::".$ageto."::".$allowemails."::".$profile."::".$indianstate."::".$usstate."::".$district."::".$mothertongue."::".$religion."::".$caste."::".$xpriority."::".$bywhom."::".$expiry."::".$castenobar."::".$occupation."::".$option_andor."::".$expirydate_from."::".$expirydate_to."::".$familystatus."::".$oavailable."::".$phystatus."::".$horoscope."::".$PhotoAvl."::".$PhotoProtected."::".$VoiceAvl."::".$VideoAvl."::".$HealthProfAvl."::".$logincountfrom."::".$logincountto."::".$subcaste."::".$NoofPayment."::".$MaritalStatus."::".$mailerunsubtype."::".$offercategoryid;

	// Writing the email setting into a flat text file...
	if (!$handle = fopen($writefilename, 'w+')) {
        echo "Cannot open file ($filename)";
        exit;
	}
	if (fwrite($handle, $writecontent) === FALSE) {
       echo "Cannot write to file ($filename)";
       exit;
	}
	fclose($handle);
	global $dblink;
	$QueryType = "select";
	$mailsql = CreateQuery($category,$QueryType);
	$mailres = mysql_query ($mailsql);
	$mailnum = recordcount($QueryType,$mailres);

	$reportheader  = "MIME-Version: 1.0\n";
	$reportheader .= "From: MailManager<info@bharatmatrimony.com\n";
	$reportheader .= "Content-type: text/html\n";
	$reportheader .= "Reply-To: noreply@bharatmatrimony.com\n";
	$reportheader .= "X-Mailer: PHP mailer\n";

	$reportsubject = " Query : ".$mailsql."<br>";
	$reportsubject .= " Count : ".$mailnum;

	mail($ReportEmailids,"Query Generated - $category",$reportsubject,$reportheader);
	
	//echo "<img src='callcreatemail.php?catg=$category'>";
	echo "<table><tr><td class='smalltxt'><font color='red'>Query Configured</font></td></tr></table>";

	//system ('php syscreatemaillist.php ' .escapeshellarg($category));
	//include "createmaillist.php";
	header ("Location:checkfiles.php");
	exit;
}

?>

<script language="JavaScript" type="text/javascript">


function partcall(part) {
	var part2 = document.getElementById(part);
	if ( part2.className == 'hidden' ) {
	part2.className = 'visible';
	} else {
	part2.className = 'hidden';
	}

}

function aval() {
	if (document.frm.category.value=="" || document.frm.category.value=="x")  {
		alert("please select Category");
		document.frm.category.focus();
		return false;
	}
	if (document.frm.memberstatus.value=="" || document.frm.memberstatus.value=="x")  {
		alert("please select Member Type");
		document.frm.memberstatus.focus();
		return false;
	}
	if (document.frm.mailerunsubtype.value=="" || document.frm.mailerunsubtype.value=="x")  {
		alert("please select Mailer Type");
		document.frm.mailerunsubtype.focus();
		return false;
	}
	return true;
}

function winpop() { 		
	if (document.frm.category.value=="" || document.frm.category.value=="x")  {
		alert("please select Category");
		document.frm.category.focus();
	} else {	
		var catg = document.frm.category.value;
		var popurl = "gettemplate.php?catg="+catg;
		window.open(popurl,"childpop2",'height=500,width=500,scrollbars=yes');
	}
}
function chkhoro(bnm){
	
	if(bnm!='x')
	document.getElementById('horoscope4').checked=false;
	
}
function searchSel() {
  var input=document.getElementById('realtxt').value.toLowerCase();
  var output=document.getElementById('realitems').options;
  for(var i=0;i<output.length;i++) {	  
	var cmpTxt = output[i].text.toLowerCase();
    if(cmpTxt.indexOf(input)==0){
      output[i].selected=true;
      }
    if(document.forms[0].realtxt.value==''){
      output[0].selected=true;
      }
  }
}



</script>

<table border="0" cellpadding="0" cellspacing="0" align="center" width="780" class="maintborder" bgcolor="#ffffff">
<tr>

<td valign="top" width="148"  >
<!--Left Menu Start-->		
<? include "/home/mailmanager/config/leftmenu.php"; ?>
<!--Left Menu End-->		
</td>

<td valign="top"  class="borderclr"><img src="/images/trans.gif" width="1" height="1"></td>
<td width="5">&nbsp;</td>

<td valign="top" width="625">
<br>
<!--Middle Area Start-->		
		<form name="frm" method="post" action="" onsubmit="return aval();">
		<table class="title" border=0 align=center cellpadding=1 cellspacing=1 >
		<tr>
			<td bgcolor="#B4B2AF">
					<table class="title" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF" >
					<tr>
						<td>
							<table class="title" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF">
							<tr  bgcolor="#6A6A6A">
								<td class="white" align=center colspan=3><?=$ret_res?></td>
							</tr>
							<tr  bgcolor="#6A6A6A">
								<td class="white" align=left colspan=3> Config Mail Setting here!</td>
							</tr>
							<tr>
								<td>
									   <table class="smalltxt" border="0" cellpadding="2" cellspacing="2" align="center" bgcolor="#FFFFFF">
										<tr>
										<td class="title">Select Category</td>
										<td valign='bottom'> 
											<select  class="smalltxt" name="category" id="realitems">
												<option value="x">--Select One--</option>
												<?if($_GET['type']=='edit'){
													echo select_categoryedit($category);									
												}else?>
												<?=select_category('')?> 
											 </select> <a href="javascript: winpop('');" > <img border=0 src="images/rightfinger.jpg"> Choose and View Template</a> <!-- <a href="gettemplate.php?catg=<script language="javascript">document.write(frm.category.options[frm.category.selectedIndex].value)</script>" target=new> <- Choose and View Template</a> -->
										</td>
										</tr>
										<tr>
										<td class="title">Search Category</td>
										<td valign='bottom'><input type="text" id="realtxt" onblur="searchSel()">
										</td>
										</tr>
										<tr><td colspan=4><b>&nbsp;</b></td></tr>
										<tr>
										<td class="title"> For What Kind of Members?  </td>
										<td>  <select  class="smalltxt" name="memberstatus">
												
												<option value="x" <?if($memberstatus=="x") echo "selected";?>>--Select One--</option>
												<!-- COMMENTED TYPES ARE DEPRECATED -->
												<!-- <option value="0">All</option> -->
												<option value="1" <?if($memberstatus=="1") echo "selected";?>>Members</option>
												<!-- <option value="2">Non Members</option> -->
												<option value="3" <?if($memberstatus=="3") echo "selected";?>>Past Members</option>
												<option value="4" <?if($memberstatus=="4") echo "selected";?>>Partly Register Case 1</option>
												<option value="5" <?if($memberstatus=="5") echo "selected";?>>Partly Register Case 2</option>
												<!-- <option value="7">Partly Register Case 3</option>
												<option value="6">Matrimony Express Member</option> -->
											 </select>
										</td>
										</tr>									

										<tr>
										<td colspan=2> <!-- Inner tbl starts -->
									    <table class="smalltxt" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="#B5B5B5" width=100%>
										<tr> <td> 
									    <table class="smalltxt" border="0" cellpadding="2" cellspacing="2" align="center" bgcolor="#FFFFFF"  width=100%>
										<tr bgcolor='#EAEAEA'>
										<td class="title" colspan=2 > Options [ Note: Only Applicable for Members Group alone ] </td>
										</tr>
										<tr><td colspan='2' height='10px' bgcolor='#ADADAD' >
										<div id="part1"><a name='#ver'></a>
										<a onclick="partcall('part2');" class="title" href="#ver">+ Verification </a>
										</div>
										</td></tr>										
										<tr><td colspan=2> <div id="part2" class="hidden">
										<table border=0 width='100%'>										
										<tr bgcolor='#EAEAEA'>

										<td class="title" > Is for Validated?  </td>
										<td class="smalltxt"><input type="radio" name="validated" value='1' <?if($validated=="1") echo "checked";?>> Validated 
											 <input type="radio" name="validated" value='0' <?if($validated=="0") echo "checked";?> > NotValidated
											 <input type="radio" name="validated" value='x' <?if($validated=="x") echo "checked";?>> Both
										</td>
										</tr>

										<tr>
										<td class="title"> Is for Authorised?  </td>
										<td class="smalltxt"> <input type="radio" name="authorise" value='1' <?if($authorise=="1") echo "checked";?>> Authorised 
											 <input type="radio" name="authorise" value='0' <?if($authorise=="0") echo "checked";?>> NotAuthorised
											 <input type="radio" name="authorise" value='x' <?if($authorise=="x") echo "checked";?>> Both
										</td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title"> Is for Phone Verified?  </td>
										<td class="smalltxt"> <input type="radio" name="phone" value='1'<?if($phone=="1") echo "checked";?>> Verify Completed 
											 <input type="radio" name="phone" value='2' <?if($phone=="2") echo "checked";?>> Verify Pending 
											 <input type="radio" name="phone" value='0' <?if($phone=="0") echo "checked";?>> Non Phone Verified
											 <input type="radio" name="phone" value='x' <?if($phone=="x") echo "checked";?>> All
										</td>
										</tr>

										<tr>
										<td class="title"> Is for Profile Verified?  </td>
										<td class="smalltxt"> <input type="radio" name="profile" value='1' <?if($profile=="1") echo "checked";?>> Verified Profile 
											 <input type="radio" name="profile" value='0' <?if($profile=="0") echo "checked";?>> Non Verified Profile
											 <input type="radio" name="profile" value='x' <?if($profile=="x") echo "checked";?>> All
										</td>
										</tr>

										</table></div>
										</td></tr>

										<tr>
										<td colspan=2 class="title" height='10px' bgcolor='#ADADAD' >
										<div id="part3"><a name='#mem'></a>
										<a onclick="partcall('part4');" class="title" href="#mem">+ Member Type -Offer Details </a>
										</div></td>
										</tr>
										
										<tr><td colspan='2'>
										<div id="part4" class="hidden">
										<table border=0 width='100%'>

										<tr width='40%' bgcolor='#EAEAEA'>
										<td class="title"> Is for Paid members?  </td>
										<td class="smalltxt"> <input type="radio" name="paidmembers" value='P' <?if($paidmembers=="P") echo "checked";?>> Paid Members 
											 <input type="radio" name="paidmembers" value='F' <?if($paidmembers=="F") echo "checked";?>> Free Members
											 <input type="radio" name="paidmembers" value='x' <?if($paidmembers=="x") echo "checked";?>> Both
										</td>
										</tr>

										<tr>
										<td class="title"> Is Offer Available?  </td>
										<td class="smalltxt"> <input type="radio" name="oavailable" value='1' <?if($oavailable=="1") echo "checked";?>> With Offer 
											 <input type="radio" name="oavailable" value='0' <?if($oavailable=="0") echo "checked";?>> Without Offer
											 <input type="radio" name="oavailable" value='x' <?if($oavailable=="x") echo "checked";?>> All
										</td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title"> Offer Category Type </td>
										<td class="smalltxt">&nbsp;&nbsp;<select  class="smalltxt" name="offercategoryid">
											<option value="x" selected> -Select Offer Category- </option>
											<?if($_GET['type']=='edit'){
													displayoffercategoryedit($offercategoryid);									
												}else										 displayoffercategory(); ?>
										</select>
										</td>
										</tr>

										<tr>
										<td class="title"> For What Profile Status?  </td>
										<td class="smalltxt"> 
										<?php
											
												$status_arr=explode(',',$status)
										?>
										<input type="checkbox" name="status[]" value='0'  <?php if(in_array('0',$status_arr)) echo 'checked'; else '';?>> Open 
											 <input type="checkbox" name="status[]" value='1' <?php if(in_array('1',$status_arr)) echo 'checked'; else '';?>> Hidden
											 <input type="checkbox" name="status[]" value='2' <?php if(in_array('2',$status_arr)) echo 'checked'; else '';?>> Suspend
										</td>
										</tr></table></div>
										</td></tr>

										<tr>
										<td colspan=2 class="title" height='10px' bgcolor='#ADADAD'>
										<div id="part5"><a name='#pro'></a>
										<a onclick="partcall('part6');"  class="title" href="#pro">+ Profile Details </a>
										</div></td>
										</tr>

										<tr><td colspan='2'>
										<div id="part6" class="hidden">
										<table border=0 width='100%'>
										
										<tr bgcolor='#EAEAEA' >
										<td class="title"  width='40%'> Is Photo Avaliable?  </td>
										<td class="smalltxt"> <input type="radio" name="photoavailable" value='1' <?if($PhotoAvl=="1") echo "checked";?>> Yes 
											 <input type="radio" name="photoavailable" value='0' <?if($PhotoAvl=="0") echo "checked";?>> No
											 <input type="radio" name="photoavailable" value='x' <?if($PhotoAvl=="x") echo "checked";?>> Both
										</td>
										<tr>

										<td class="title"> Is Photo Protected?  </td>
										<td class="smalltxt"> <input type="radio" name="photoprotected" value='Y' <?if($PhotoProtected=="Y") echo "checked";?>> Yes 
											 <input type="radio" name="photoprotected" value='N' <?if($PhotoProtected=="N") echo "checked";?>> No
											 <input type="radio" name="photoprotected" value='x' <?if($PhotoProtected=="x") echo "checked";?>> Both
										</td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title" > Is Video Avaliable?  </td>
										<td class="smalltxt"> <input type="radio" name="videoavailable" value='1' <?if($VoiceAvl=="1") echo "checked";?>> Yes 
											 <input type="radio" name="videoavailable" value='0' <?if($VoiceAvl=="0") echo "checked";?>> No
											 <input type="radio" name="videoavailable" value='x' <?if($VoiceAvl=="x") echo "checked";?>> Both
										</td>
										</tr>
										<tr>

										<td class="title"> Is Voice Avaliable?  </td>
										<td class="smalltxt"> <input type="radio" name="voiceavailable" value='1' <?if($VideoAvl=="1") echo "checked";?>> Yes 
											 <input type="radio" name="voiceavailable" value='0' <?if($VideoAvl=="0") echo "checked";?>> No
											 <input type="radio" name="voiceavailable" value='x' <?if($VideoAvl=="x") echo "checked";?>> Both
										</td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title" > Is HealthProfile Avaliable?  </td>
										<td class="smalltxt"> <input type="radio" name="hpavailable" value='1' <?if($HealthProfAvl=="1") echo "checked";?>> Yes 
											 <input type="radio" name="hpavailable" value='0' <?if($HealthProfAvl=="0") echo "checked";?>> No
											 <input type="radio" name="hpavailable" value='x' <?if($HealthProfAvl=="x") echo "checked";?>> Both
										</td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title" > Martial Status  </td>
										<td class="smalltxt">
											<?php 
											$matrial_status_arr = explode(",",$MaritalStatus);
											?>
											 <input type="checkbox" name="maritalval[]" value='0' <?php if(!$MaritalStatus) echo 'checked'; else '';?>> Any
											 <input type="checkbox" name="maritalval[]" value='1' <?php if(in_array('1',$matrial_status_arr)) echo 'checked'; else '';?>> Unmarried
											 <input type="checkbox" name="maritalval[]" value='2' <?php if(in_array('2',$matrial_status_arr)) echo 'checked'; else '';?>> Widow/Widower<br>
											 <input type="checkbox" name="maritalval[]" value='3' <?php if(in_array('3',$matrial_status_arr)) echo 'checked'; else '';?>> Divorced
											 <input type="checkbox" name="maritalval[]" value='4' <?php if(in_array('4',$matrial_status_arr)) echo 'checked'; else '';?>> Seperated
										</td>
										</tr></table></div>
										</td></tr>

										<tr>
										<td colspan=2 class="title" height='10px' bgcolor='#ADADAD'>
										<div id="part7"><a name='#cas'></a>
										<a onclick="partcall('part8');" class="title" href="#cas">+  Caste No Bar & Horo , Physical status</a>
										</div></td>
										</tr>

										<tr><td colspan='2'>
										<div id="part8" class="hidden">
										<table border=0 width='100%'><tr bgcolor='#EAEAEA'>
										<td class="title"> Horoscope Available?  </td>
										<td class="smalltxt"> 
										<?php 
										$horo_arr=explode(',',$horoscope);									
										?>
										<input type="checkbox" name="horoscope[]" id="horoscope1" value='0' onClick="chkhoro(this.value);" <?php if(in_array('0',$horo_arr)) echo 'checked'; else echo '';?>> Not Available 
											 <input type="checkbox" name="horoscope[]" id="horoscope2" value='1' onClick="chkhoro(this.value);"<?php if(in_array('1',$horo_arr)) echo 'checked'; else echo '';?>> Scanned Copy
											 <input type="checkbox" name="horoscope[]" id="horoscope3" value='2,3' onClick="chkhoro(this.value);"<?php if(in_array('2',$horo_arr)) echo 'checked'; else echo '';?>> Computer Generated
											 <input type="checkbox" name="horoscope[]" onClick="chkhoro(this.value);" id="horoscope4" value='x' <?php if(in_array('x',$horo_arr)) echo 'checked'; else echo '';?>> All
										</td>
										</tr>

										<tr>
										<td class="title"> Physical Status  </td>
										<td class="smalltxt"> <input type="radio" name="phystatus" value='0' <?if($phystatus=="0") echo "checked";?>> Normal 
											 <input type="radio" name="phystatus" value='1' <?if($phystatus=="1") echo "checked";?>> Physically Challenged
											 <input type="radio" name="phystatus" value='x' <?if($phystatus=="x") echo "checked";?>> Both
										</td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title" > Caste NoBar </td>
										<td class="smalltxt"> <input type="checkbox"  name="cnobar" value='1' <?if($cnobar=="1") echo "selected";?>> caste no bar 
										</td>
										</tr></table></div>
										</td></tr>

								
										<td colspan=2 class="title" height='10px' bgcolor='#ADADAD'>
										<div id="part9"><a name='#dom'></a>
										<a onclick="partcall('part10');" class="title" href="#dom">+ Domain/Language </a>
										</div></td>
										</tr>

										<tr><td colspan='2'>
										<div id="part10" class="hidden">
										<table border=0 width='100%'><tr bgcolor='#EAEAEA'>
										<td class="title" width='40%'>Language/Domain</td>
										<td class="smalltxt" > <select  class="smalltxt" name="language[]"  size='15' multiple=20>
										<!--<option value="x">--Select One--</option>-->
										<?if($_GET['type']=='edit'){
												echo select_arrayhashedit('languagedomain',$language);			
											}else{?>
											<?=select_arrayhash('languagedomain','');}?>
											 </select> <br> [ Applicable for Partly Register Case 2 ]
										</td>
										</tr></table></div>
										</td></tr>

										<td colspan=2 class="title" height='10px' bgcolor='#ADADAD'>
										<div id="part11"><a name='#loc'></a>
										<a onclick="partcall('part12');" class="title" href="#loc">+ Location & MotherTongue</a>
										</div></td>
										</tr>

										<tr><td colspan='2'>
										<div id="part12" class="hidden">
										<table border=0 width='100%'>
										<tr>
										<td class="title">Country</td>
										<td class="smalltxt"> <select  class="smalltxt" name="country[]" multiple  size='20'>
												<!--<option value="x">--Select One--</option>-->
												<option value=98 >India</option>
												<option value=222 >United States of America</option>
												<option value=129 >Malaysia</option>
												<option value=189 >Singapore</option>
												<option value=39 >Canada</option>
												<option value=221 >United Kingdom</option>
												<option value="x" <?if($country=='x') echo "selected";?>>-----------------------</option>
												<?if($_GET['type']=='edit'){
													
													echo select_arrayhashedit('countryhash',$country);
												
												}else{?>
												<?=select_arrayhash('countryhash','');}?>
											 </select> <br> [ Applicable for Partly Register Case 2 ]
										</td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title">ResidingStates in India</td>
										<td class="smalltxt"> <select  class="smalltxt" name="residingindianames[]" multiple size='20'>
												<!--<option value="x">--Select One--</option>-->
												<?if($_GET['type']=='edit'){
													echo select_arrayhashedit('residingindianames',$indianstate);
												}else{?>
												<?=select_arrayhash('residingindianames','');}?>
											 </select> <br>
										</td>
										</tr>
										<tr>

										<td class="title">ResidingStates in US</td>
										<td class="smalltxt"> <select  class="smalltxt" name="residingusanames[]" multiple size='20'>
												<!--<option value="x">--Select One--</option>-->
												<?if($_GET['type']=='edit'){
													echo select_arrayhashedit('residingusanames',$usstate);
												}else{?>
												<?=select_arrayhash('residingusanames','');}?>
											 </select> <br>
										</td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title">ResidingDistrict</td>
										<td> <select  class="smalltxt" name="residingdistrict[]" multiple size='20'>
												<!--<option value="x">--Select One--</option>-->
												<?if($_GET['type']=='edit'){
													echo select_arrayhashedit('city',$district);
												}else{?>
												<?=select_arrayhash('city','');}?>
											 </select> <br>
										</td>
										</tr>

										<tr>
										<td class="title">MotherTongue</td>
										<td> <select  class="smalltxt" name="mothertongue[]" multiple size='10'>
												<!--<option value="x">--Select One--</option>-->
												<?if($_GET['type']=='edit'){
													echo select_arrayhashedit('mothertonguehash',$mothertongue);
												}else{?>
												<?=select_arrayhash('mothertonguehash','');}?>
											 </select> <br>
										</td>
										</tr></table></div>
										</td></tr>


										<td colspan=2 class="title" height='10px' bgcolor='#ADADAD'>
										<div id="part13"><a name='#reg'></a>
										<a onclick="partcall('part14');" class="title" href="#reg">+ Religion & Caste </a>
										</div></td>
										</tr>

										<tr><td colspan='2'>
										<div id="part14" class="hidden">
										<table border=0 width='100%'>
										<tr bgcolor='#EAEAEA'>
										<td class="title" width='40%'>Religion</td>
										<td> <select  class="smalltxt" name="religion[]" multiple size='10'>
												<!--<option value="x">--Select One--</option>-->
												<?if($_GET['type']=='edit'){
													echo select_arrayhashedit('religionhash',$religion);
												}else{?>
												<?=select_arrayhash('religionhash','');}?>
											 </select> <br>
										</td>
										</tr>

										<tr>
										<td class="title">Caste</td>
										<td> <select  class="smalltxt" name="caste[]" multiple size='20'>
												<!--<option value="x">--Select One--</option>-->
												<?if($_GET['type']=='edit'){
													echo select_arrayhashedit('castehash',$caste);
												}else{?>
												<?=select_arrayhash('castehash','');}?>
											 </select> <br>
										</td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title">Sub Caste</td>
										<td> <select  class="smalltxt" name="subcaste[]" multiple size='20'>
												<!--<option value="x">--Select One--</option>-->
												<?if($_GET['type']=='edit'){
													echo select_arrayhashedit('subcastehash',$subcaste);
												}else{?>
												<?=select_arrayhash('subcastehash','');}?>
											 </select> <br>
										</td>
										</tr></table></div>
										</td></tr>


										<td colspan=2 class="title" height='10px' bgcolor='#ADADAD'>
										<div id="part15"><a name='#edu'></a>
										<a onclick="partcall('part16');" class="title" href="#edu">+ Education & Occupation</a>
										</div></td>
										</tr>

										<tr><td colspan='2'>
										<div id="part16" class="hidden">
										<table border=0 width='100%'>
										<tr bgcolor='#EAEAEA'>
										<td class="title">Education</td>
										<td> <select  class="smalltxt" name="education[]" multiple size='10'>
												<!--<option value="x">--Select One--</option>-->
												<?if($_GET['type']=='edit'){
													echo select_arrayhashedit('educationhash',$education);
												}else{?>
												<?=select_arrayhash('educationhash','');}?>
											 </select> <br>
										</td>
										</tr>

										<!-- Added By Anish -->
										<tr >
										<td class="title">Occupation Selected</td>
										<td> <select  class="smalltxt" name="occupation[]" multiple size='15'>
												<!--<option value="x">--Select One--</option>-->
												<?if($_GET['type']=='edit'){
													echo select_arrayhashedit('occupationhash',$occupation);
												}else{?>
												<?=select_arrayhash('occupationhash','');}?>
											 </select> <br>
										</td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title">Familystatus</td>
										<td> <select  class="smalltxt" name="familystatus[]" multiple>
												<!--<option value="x">--Select One--</option>-->
												<?if($_GET['type']=='edit'){
													echo select_arrayhashedit('familystatushash',$familystatus);
												}else{?>
												<?=select_arrayhash('familystatushash','');}?>
											 </select> <br>
										</td>
										</tr>

										<tr>
										<td class="title">By Whom</td>
										<td> <select  class="smalltxt" name="bywhom[]" multiple>
										<?if($_GET['type']=='edit'){
													echo select_arrayhashedit('bywhomhash',$bywhom);
												}else{?>
											<?=select_arrayhash('bywhomhash','');}?>

											 </select> 
										</td>
										</tr>
										</table></div>
										</td></tr>

										<td colspan=2 class="title" height='10px' bgcolor='#ADADAD'>
										<div id="part17"><a name='#pay'></a>
										<a onclick="partcall('part18');" class="title" href="#pay">+ Payment Info</a>
										</div></td>
										</tr>

										<tr><td colspan='2'>
										<div id="part18" class="hidden">
										<table border=0 width='100%'>
										<tr bgcolor='#EAEAEA'>
										<td class="title"> Payment expiry  </td>
										<td> <input class="smalltxt" type="text" name="exdatef" value="<?if($expirydate_from!='') echo $expirydate_from;?>" maxlength=10 size=13 onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;">
											 <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.exdatef',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt=""></a>
										     <input class="smalltxt" type="text" name="exdatet" value="<?if($expirydate_to!='') echo $expirydate_to;?>" maxlength=10 size=13 onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;">
											 <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.exdatet',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt=""></a>
										</td>
										</tr>

										<tr >
										<td class="title">Payment Going to Expirey on </td>
										<td>  
												<select  class="smalltxt" name="expire" >
												<option value="">--Select One--</option>
												<? for ($i=1; $i<=31; $i++){ 
													if($_GET['type']=='edit'){?>
													<option value=<?=$i ?> <?if($i==$expiry) echo "selected"?>><?=$i?></option>
													<?}else{
													?><option value=<?=$i ?>><?=$i?></option>				
												<? }
												} ?>
												</select> 
											 </select> 
										</td>
										</tr>
										
										<tr bgcolor='#EAEAEA'>
										<td class="title"> Number of Payments  </td>
										<td> <SELECT NAME="paymentcnt[]" multiple size=5>

											<? if($_GET['type']=='edit'){
												$NoofPayment=explode(',',$NoofPayment);	
												$j=0;
												//foreach($NoofPayment as $key => $value){
												for($i=0;$i<=10;$i++){										
												if(($NoofPayment[$j]==$i) && (count($NoofPayment)>$j)){ 
													$selected='selected';
													$j++;					
												}
												else{
														$selected='';
												}?>
												<OPTION VALUE="<?=$i?>"<?echo $selected;
													?>><?=$i?></option><?
												}
											}
											else{
												for($i=0;$i<=10;$i++){
													echo "<OPTION VALUE='".$i."'>".$i."</option>";
													}
											}
												//echo "<OPTION VALUE='".$value."'>".$value."</option>";
												//}
												//echo "<OPTION VALUE='".$i."'>".$i."</option>";
											
										?>
										</SELECT>
										</td></tr>
										</table></div>
										</td></tr>

										<tr>
										<td colspan=2 class="title" height='10px' bgcolor='#ADADAD'>
										<div id="part21"><a name='#add'></a>
										<a onclick="partcall('part22');" class="title" href="#add">+  Additional Details</a>
										</div></td>
										</tr>

										<tr><td colspan='2'>
										<div id="part22" class="hidden">
										<table border=0 width='100%'>

										<tr bgcolor='#EAEAEA'>
										<td class="title">Gender</td>
										<td class="smalltxt"> <select  class="smalltxt" name="gender">
												<option value="x" <?if($gender=="x") echo "selected";?>>--Select One--</option>
												<option value="M" <?if($gender=="M") echo "selected";?>> Male </option>
												<option value="F" <?if($gender=="F") echo "selected";?>> Female </option>
											 </select> 
										</td>
										</tr>

										<tr >
										<td class="title">Age</td>
										<td class="smalltxt"> From <input type="text" name="agefrom" value="<?if($agefrom!='') echo $agefrom;?>" size=4 maxlength=2 > &nbsp;&nbsp; To <input type="text" name="ageto" value="<?if($ageto!='') echo $ageto;?>" size=4 maxlength=2 > </td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title">X- Priority</td>
										<td class="smalltxt">  
												<select  class="smalltxt" name="priority" >
												<!--<option value="x">--Select One--</option>-->
												<option value=3 <?if($xpriority=="3") echo "checked";?>>Normal</option>
												<option value=2 <?if($xpriority=="2") echo "checked";?>>Medium</option>
												<option value=1 <?if($xpriority=="1") echo "checked";?>>High</option>
												</select> 
											 </select> 
										</td>
										</tr>

										<tr >
										<td class="title">Login Count </td>
										<td class="smalltxt"> From <input type="text" name="logincountfrom" value="<?if($logincountfrom!='') echo $logincountfrom;?>" size=4 maxlength=4 > &nbsp;&nbsp; To <input type="text" name="logincountto" value="<?if($logincountto!='') echo $logincountto;?>" size=4 maxlength=4 > </td>
										</tr>

										<!-- Added By Anish on feb 19 2009 for selecting and or between last login and timecreated -->
										<tr bgcolor='#EAEAEA'>
										<td class="title"> TimeCreated  </td>
										<td class="smalltxt"> <input class="smalltxt" type="text" name="fromtimecreated" value="<?if($fromtimecreated!=''){echo $fromtimecreated; }?>" maxlength=10 size=13 onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;">
											 
											 <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.fromtimecreated',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt=""></a>
										     <input class="smalltxt" type="text" name="totimecreated" value="<?if($totimecreated!=''){echo $totimecreated; }?>" maxlength=10 size=13 onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;">
											 <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.totimecreated',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt=""></a> (for prcases)
										</td>
										</tr>

										<tr >
										<td class="title"> And/Or  </td>
										<td class="smalltxt"> <select  class="smalltxt" name="andor">
												<option value="0" <?if($option_andor=="0") echo "checked";?>>--Select One--</option>
												<option value="1" <?if($option_andor=="1") echo "checked";?>> AND </option>
												<option value="2" <?if($option_andor=="2") echo "checked";?>> OR </option>
											 </select> </td></tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title"> LastLogin  </td>
										<td class="smalltxt"> <input class="smalltxt" type="text" name="fromlastlogin" value="<?if($fromlastlogin!=''){echo $fromlastlogin; }?>" maxlength=10 size=13 onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;">
											 <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.fromlastlogin',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt=""></a>
										     <input class="smalltxt" type="text" name="tolastlogin" value="<?if($tolastlogin!=''){echo $tolastlogin; }?>" maxlength=10 size=13 onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;">
											 <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.tolastlogin',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt=""></a> (for members & deleted case)
										</td>
										</tr>

										<tr >
										<td class="title"> Mailer Type  </td>
										<td class="smalltxt"> <select  class="smalltxt" name="mailerunsubtype">
										<option value="x">--Select One--</option>
										<?if($_GET['type']=='edit'){
													echo select_arrayhashedit('mailertypehash',$mailerunsubtype);
											}else{?>
										<?=select_arrayhash('mailertypehash','');}?>
										 </select> </td></tr>
										</table></div>
										</td></tr>
										
										</table> <!-- Inner tbl ends -->
										</td> </tr>
										</table>
										</td>
										</tr>

										<tr><td colspan=2>&nbsp;<a name='#mis'></a></td></tr>

										<td colspan=2 class="title" height='10px' bgcolor='#ADADAD'>
										<div id="part19">
										<a onclick="partcall('part20');" class="title" href="#mis">+ Miscellaneous</a>
										</div></td>
										</tr>

									    <tr><td colspan=2> <div id="part20" class="hidden">
										<table border=0 width='100%'>	
										<tr bgcolor='#EAEAEA'>
										<td class="title">Restrict Domains </td>
										<td> <textarea name="testemails" cols=50 rows=2 ></textarea> </td>
										</tr>

										<tr>
										<td class="title">Allowed Domains </td>
										<td> <textarea name="allowemails" cols=50 rows=2 ></textarea> </td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title">Remarks</td>
										<td> <textarea name="remarks" cols=50 rows=2 ></textarea> </td>
										</tr>
										</table></div>
										</td></tr>

										<!--<tr>
										<td class="title"> Mail Type  </td>
										<td> <input type="radio" name="actionflag" value=1> Test 
											 <input type="radio" name="actionflag" value=2> Live
										</td>
										</tr>-->

										<tr>
									<td class="smalltxt" align="right"><input type="submit" class="smalltxt"  name="do_submit" value="Submit"></td>
									<td><input type="reset" class="smalltxt" name="reset" value="Reset"></td>
								</tr>
									
							   </table>
						</td>
					</tr>
					</table>
			</td>
		</tr>
		</table>
			</td>
		</tr>
		</table>
		</form>



<!--Middle Area End-->		
</td>

</tr>
</table>

<?
include "/home/mailmanager/config/footer.php";
?>