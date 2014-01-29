 <?php
//*************************************
// File Name	: mailconfig.php
// Code By		: Pradeep, Ashok kumar
//*************************************
include "/home/cbsmailmanager/config/config.php";
include_once "lib/authenticate.php";
//include "/home/cbsmailmanager/bmconf/bmvarssearcharrincen.inc";
include "/home/cbsmailmanager/config/header.php";
include "/home/cbsmailmanager/config/styleheader.php";
//ini_set('DISPLAY_ERRORS',1);
//error_reporting(E_ALL);

if ( $_POST['do_submit'] == "Submit" ) {
	$category		= trim($_POST['category']);         // select Catagory name
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
	//$membertype		= trim($_POST['membertype']);
	$membertype		= 1;
	$selecttype		= trim($_POST['selecttype']); // for query formation
	$mothertongueselecttype		= trim($_POST['mothertongueselecttype']); // for query formation using mothertongue
	$trackid		= trim($_POST['trackid']);
	$NoofPayment    = trim($_POST['paymentcnt']);

	
	//$category = $categoryname;
	

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
	/*$NoofPayment = '';
	if (is_array($_POST['paymentcnt'])) {
	foreach($_POST['paymentcnt'] as $paymentkey => $paymentval) {
		$NoofPayment .= $paymentval.",";
	}
	$NoofPayment = substr ($NoofPayment, 0, strlen($NoofPayment)-1);
	}*/

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

	$writecontent = $category."::".$language."::".$country."::".$testemails."::".$validated."::".$authorise."::".$status."::".$paidmembers."::".$phone."::".$remarks."::".$memberstatus."::".date('Y-m-d H:i:s')."::".$fromlastlogin."::".$tolastlogin."::".$education."::".$fromtimecreated."::".$totimecreated."::".$gender."::".$agefrom."::".$ageto."::".$allowemails."::".$profile."::".$indianstate."::".$usstate."::".$district."::".$mothertongue."::".$religion."::".$caste."::".$xpriority."::".$bywhom."::".$expiry."::".$castenobar."::".$occupation."::".$option_andor."::".$expirydate_from."::".$expirydate_to."::".$familystatus."::".$oavailable."::".$phystatus."::".$horoscope."::".$PhotoAvl."::".$PhotoProtected."::".$VoiceAvl."::".$VideoAvl."::".$HealthProfAvl."::".$logincountfrom."::".$logincountto."::".$subcaste."::".$NoofPayment."::".$MaritalStatus."::".$mailerunsubtype."::".$offercategoryid."::".$sendtype."::".$membertype."::".$otherdistrict."::".$selecttype."::".$trackid."::".$mothertongueselecttype;

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

	if($membertype ==1) { // for cbs members
		$mailsql = cbsCreateQuery($category,$QueryType);
		$mailres = mysql_query ($mailsql);
		$mailnum = cbsrecordcount($QueryType,$mailres);
	} else {  // For BM members
		global $bmdblink;
		$mailsql = CreateQuery($category,$QueryType);
		$mailres = mysql_query ($mailsql,$bmdblink);
		$mailnum = recordcount($QueryType,$mailres);
	}

	$reportheader  = "MIME-Version: 1.0\n";
	$reportheader .= "From: MailManager<info@communitymatrimony.com\n";
	$reportheader .= "Content-type: text/html\n";
	$reportheader .= "Sender: communitymatrimony.com<info@communitymatrimony.com>\n";
	$reportheader .= "Reply-To: noreply@communitymatrimony.com\n";
	$reportheader .= "X-Mailer: PHP mailer\n";

	$reportsubject = " Query : ".$mailsql."<br>";
	
	mail($ReportEmailids,"Query Generated - $category",$reportsubject,$reportheader);

	echo "<table><tr><td class='smalltxt'><font color='red'>Query Configured</font></td></tr></table>";
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
	if (document.frm.trackid.value=="")  {
		alert("please select Enter TrackID No");
		document.frm.trackid.focus();
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
							<tr  bgcolor="FF6000">
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
												<?=select_category('')?>
											 </select> <a href="javascript: winpop('');" > <img border=0 src="images/rightfinger.jpg"> Choose and View Template</a>
										</td>
										</tr>

										<tr>
										<td class="title">Send Type</td>
										<td valign='bottom'>
											<input type="radio" name="sendtype" value='0' checked> mail method
											<input type="radio" name="sendtype" value='1'> smtp method

										</td>
										</tr>
										<tr><td colspan=4><b>&nbsp;</b></td></tr>
										<tr>
										<td class="title"> For What Kind of Members?  </td>
										<td>  <select  class="smalltxt" name="memberstatus" >
												<option value="x">--Select One--</option>
												<option value="1">Members</option>
											 </select>
										</td>
										</tr>
										<!-- For preselect members -->
										<tr >
										<td class="title"> Mailer Type  </td>
										<td class="smalltxt">

										 <select name="mailerunsubtype" class="smalltxt" id="mtype">
											 <option value="0">--Select One--</option>
											 <option value="5">F2P Mailer</option>
											 <option value="2">General promo Mailer</option>
											 <option value="3">News Letters</option>
											 <!-- <option value="4">Articals</option> -->
										 </select>
										 </td>
										 </tr>

										<tr>
											<td class="title">Track Id</td>
											<td><input class="smalltxt" type="text" name="trackid" maxlength="20" size="15"></td>
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
										<div id="part9"><a name='#dom'></a>
										<a onclick="partcall('part10');" class="title" href="#dom">+ Domain / Community </a>
										</div>
										</td></tr>
										<tr><td colspan='2'>
										<div id="part10" class="hidden">
										<table border=0 width='100%'><tr bgcolor='#EAEAEA'>
										<td class="title" width='40%'>Domain / Community </td>
										<td class="smalltxt" > <select  class="smalltxt" name="caste[]"  size='15' multiple=20>
												<!--<option value="x">--Select One--</option>-->
												<?=select_arrayhash('castehash','')?>
											 </select> <br>
										</td>
										</tr>
										<tr>
										<td class="title">Select Type</td>
										<td class="smalltxt">
											<input type="radio" name="selecttype" value='0' checked> Select All
											<input type="radio" name="selecttype" value='1'> Select Not In
										</td>
										</tr>

										</table></div>
										</td></tr>


										<tr><td colspan='2' height='10px' bgcolor='#ADADAD' >
										<div id="part1"><a name='#ver'></a>
										<a onclick="partcall('part2');" class="title" href="#ver">+ Verification </a>
										</div>
										</td></tr>
										<tr><td colspan=2> <div id="part2" class="hidden">
										<table border=0 width='100%'>

										<tr bgcolor='#EAEAEA'>
										<td class="title"> For What Profile Status?  </td>
										<td class="smalltxt">
										     <input type="checkbox" name="status[]" value='0'> New Profile
											 <input type="checkbox" name="status[]" value='1' checked> Open
											 <input type="checkbox" name="status[]" value='2' checked> Hidden
											 <input type="checkbox" name="status[]" value='3'> Suspend

										</td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title"> Is for Phone Verified?  </td>
										<td class="smalltxt"> <input type="radio" name="phone" value='1'> Verify Completed
											 <input type="radio" name="phone" value='2'> Verify Pending
											 <input type="radio" name="phone" value='0'> Non Phone Verified
											 <input type="radio" name="phone" value='x' checked> All
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
										<td class="smalltxt"> <input type="radio" name="paidmembers" value='P'> Paid Members
											 <input type="radio" name="paidmembers" value='F'> Free Members
											 <input type="radio" name="paidmembers" value='x' checked> Both
										</td>
										</tr>

										</table></div>
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
										<td class="smalltxt"> <input type="radio" name="photoavailable" value='1'> Yes
											 <input type="radio" name="photoavailable" value='0'> No
											 <input type="radio" name="photoavailable" value='x' checked> Both
										</td>
										<tr>
										<td class="title"> Is Photo Protected?  </td>
										<td class="smalltxt"> <input type="radio" name="photoprotected" value='Y'> Yes
											 <input type="radio" name="photoprotected" value='N'> No
											 <input type="radio" name="photoprotected" value='x' checked> Both
										</td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title" > Martial Status  </td>
										<td class="smalltxt">
											 <input type="checkbox" name="maritalval[]" value='0'checked> Any
											 <input type="checkbox" name="maritalval[]" value='1' > Unmarried
											 <input type="checkbox" name="maritalval[]" value='2' > Widow/Widower<br>
											 <input type="checkbox" name="maritalval[]" value='3' > Divorced
											 <input type="checkbox" name="maritalval[]" value='4' > Seperated
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
												<option value=98>India</option>
												<option value=222>United States of America</option>
												<option value=129>Malaysia</option>
												<option value=189>Singapore</option>
												<option value=39>Canada</option>
												<option value=221>United Kingdom</option>
												<option value="x">-----------------------</option>
												<?=select_arrayhash('countryhash','')?>
											 </select> <br>
										</td>
										</tr>
										<tr bgcolor='#EAEAEA'>
										<td class="title">ResidingStates in India</td>
										<td class="smalltxt"> <select  class="smalltxt" name="residingindianames[]" multiple size='20'>
												<!--<option value="x">--Select One--</option>-->
												<?=select_arrayhash('residingindianames','')?>
											 </select> <br>
										</td>
										</tr>
										<tr>
										<td class="title">ResidingStates in US</td>
										<td class="smalltxt"> <select  class="smalltxt" name="residingusanames[]" multiple size='20'>
												<!--<option value="x">--Select One--</option>-->
												<?=select_arrayhash('residingusanames','')?>
											 </select> <br>
										</td>
										</tr>
										<tr bgcolor='#EAEAEA'>
										<td class="title">ResidingDistrict</td>
										<td> <select  class="smalltxt" name="residingdistrict[]" multiple size='20'>
												<!--<option value="x">--Select One--</option>-->
												<?=select_arrayhash('city','')?>
											 </select> <br>
										</td>
										</tr>

										<tr>
										<td class="title">MotherTongue</td>
										<td> <select  class="smalltxt" name="mothertongue[]" multiple size='10'>
												<!--<option value="x">--Select One--</option>-->
												<?=select_arrayhash('mothertonguehash','')?>
											 </select> <br>
										</td>
										</tr>
										<tr>
										<td class="title">MotherTongue Type</td>
										<td class="smalltxt">
											<input type="radio" name="mothertongueselecttype" value='0' checked> Select All
											<input type="radio" name="mothertongueselecttype" value='1'> Select Not In
										</td>
										</tr>
										</table></div>
										</td></tr>

										<td colspan=2 class="title" height='10px' bgcolor='#ADADAD'>
										<div id="part13"><a name='#reg'></a>
										<a onclick="partcall('part14');" class="title" href="#reg">+ Religion </a>
										</div></td>
										</tr>

										<tr><td colspan='2'>
										<div id="part14" class="hidden">
										<table border=0 width='100%'>
										<tr bgcolor='#EAEAEA'>
										<td class="title" width='40%'>Religion</td>
										<td> <select  class="smalltxt" name="religion[]" multiple size='10'>
												<!--<option value="x">--Select One--</option>-->
												<?=select_arrayhash('religionhash','')?>
											 </select> <br>
										</td>
										</tr>

										</table></div>
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
												<?=select_arrayhash('educationhash','')?>
											 </select> <br>
										</td>
										</tr>
										<!-- Added By Anish -->
										<tr >
										<td class="title">Occupation Selected</td>
										<td> <select  class="smalltxt" name="occupation[]" multiple size='15'>
												<!--<option value="x">--Select One--</option>-->
												<?=select_arrayhash('occupationhash','')?>
											 </select> <br>
										</td>
										</tr>

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
										
										<tr>
										<td class="title"> Number of Payments  </td>
										<td class="smalltxt"> <select  class="smalltxt" name="paymentcnt">
												<option value="x">--Select One--</option>
												<option value="0"> No payment </option>
												<option value="1"> Above One payment </option>
											 </select>
										</td>
										
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title">Gender</td>
										<td class="smalltxt"> <select  class="smalltxt" name="gender">
												<option value="x">--Select One--</option>
												<option value="1"> Male </option>
												<option value="2"> Female </option>
											 </select>
										</td>
										</tr>

										<tr >
										<td class="title">Age</td>
										<td class="smalltxt"> From <input type="text" name="agefrom" value="" size=4 maxlength=2 > &nbsp;&nbsp; To <input type="text" name="ageto" value="" size=4 maxlength=2 > </td>
										</tr>

										<tr bgcolor='#EAEAEA'>
										<td class="title"> TimeCreated  </td>
										<td class="smalltxt"> <input class="smalltxt" type="text" name="fromtimecreated" value="" maxlength=10 size=13 onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;">
											 <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.fromtimecreated',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt=""></a>
										     <input class="smalltxt" type="text" name="totimecreated" value="" maxlength=10 size=13 onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;">
											 <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.totimecreated',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt=""></a> (for prcases)
										</td>
										</tr>
										<tr >
										<td class="title"> And/Or  </td>
										<td class="smalltxt"> <select  class="smalltxt" name="andor">
												<option value="0">--Select One--</option>
												<option value="1"> AND </option>
												<option value="2"> OR </option>
											 </select> </td></tr>
										<tr bgcolor='#EAEAEA'>
										<td class="title"> LastLogin  </td>
										<td class="smalltxt"> <input class="smalltxt" type="text" name="fromlastlogin" value="" maxlength=10 size=13 onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;">
											 <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.fromlastlogin',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt=""></a>
										     <input class="smalltxt" type="text" name="tolastlogin" value="" maxlength=10 size=13 onkeypress="javascript: if ((event.keyCode ==0 ) && (event.keyCode <=127))event.returnValue=true; else event.returnValue=false;">
											 <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'frm.tolastlogin',true,'yyyy-mm-dd'); return false;"><img src="images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt=""></a> (for members & deleted case)
										</td>
										</tr>

										</table></div>
										</td></tr>

										</table> <!-- Inner tbl ends -->
										</td> </tr>
										</table>
										</td>
										</tr>


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
include "/home/cbsmailmanager/config/footer.php";
?>