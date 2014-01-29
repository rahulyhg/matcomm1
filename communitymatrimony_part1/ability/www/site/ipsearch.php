<?php
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');

$arrIPCityList = array(567=> "Delhi NCR (All)", 5036=> "Delhi North", 5037=> "Delhi South", 5039=> "Delhi East", 5040=> "Delhi West", 5041=> "Delhi Central", 925=> "Gurgaon", 918=> "Faridabad", 4121=> "Ghaziabad", 4386=> "Noida", 4138=> "Greater Noida", 5070=> "Dwarka Delhi", 2278=> "Mumbai (All)", 5032=> "Mumbai Central", 5031=> "Mumbai Harbour", 5034=> "Mumbai South", 5033=> "Mumbai Western Suburb", 2300=> "Navi Mumbai", 2402=> "Thane", 1294=> "Bangalore (All)", 5044=> "Bangalore North", 5043=> "Bangalore East", 5042=> "Bangalore Central", 5045=> "Bangalore South", 5046=> "Bangalore West", 3156=> "Chennai (All)", 5049=> "Chennai North", 5050=> "Chennai South", 5047=> "Chennai Central ", 5051=> "Chennai West", 63=> "Hyderabad (All)", 5095=> "Greater Hyderabad", 5030=> "Secunderabad", 1584=> "Kochi (All)", 1520=> "Alappuzha", 1532=> "Calicut", 5086=> "Ernakulam", 1563=> "Idukki", 1579=> "Kannur", 1588=> "Kollam", 1593=> "Kottayam", 1622=> "Palakkad", 1659=> "Thiruvananthapuram", 1664=> "Thrissur", 5087=> "Wayanad", 2337=> "Pune (All)", 4885=> "Kolkata (All)", 677=> "Ahmedabad (All)", others=> "Other Cities", 3877=> "Agartala", 3905=> "Agra", 2075=> "Ahmadnagar", 2832=> "Ajmer", 1520=> "Alappuzha", 2082=> "Alibag", 3913=> "Aligarh", 3914=> "Allahabad", 2834=> "Alwar", 896=> "Ambala", 897=> "Ambala Cantt.", 2085=> "Ambarnath", 2088=> "Amravati", 2681=> "Amritsar", 683=> "Anand", 13=> "Anantapur", 1523=> "Angamaly", 3099=> "Arakonam", 3109=> "Ariyalur", 4672=> "Asansol", 2092=> "Aurangabad", 1003=> "Baddi", 2095=> "Badlapur", 3954=> "Baghpat", 903=> "Bahadurgarh", 4689=> "Bally", 5075=> "Bandhavgarh", 4702=> "Barasat", 3978=> "Bareilly", 2694=> "Bathinda", 905=> "Bawal", 1302=> "Belgaum", 1304=> "Bellary", 698=> "Bharuch", 699=> "Bhavnagar", 489=> "Bhilai Charoda", 488=> "Bhilai Nagar", 2859=> "Bhilwara", 2862=> "Bhiwadi", 908=> "Bhiwani", 1749=> "Bhopal", 2558=> "Bhubaneswar", 701=> "Bhuj", 1313=> "Bidar", 378=> "Bihar", 1314=> "Bijapur", 2865=> "Bikaner", 1138=> "Bishunpur", 1139=> "Bokaro", 4733=> "Bolpur", 2562=> "Brahmapur", 4034=> "Bulandshahr", 587=> "Calangute", 1532=> "Calicut", 1533=> "Calicut Suburb", 2117=> "Chakan", 1535=> "Chalakudy", 476=> "Chandigarh", 1536=> "Changanassery", 3154=> "Chengalpattu", 1541=> "Chengannur", 3156=> "Chennai", 3165=> "Chidambaram", 2127=> "Chiplun", 3177=> "Coimbatore", 3178=> "Coimbatore Suburb", 40=> "Cudappah", 3181=> "Cuddalore", 2574=> "Cuttack", 1012=> "Dalhousie", 564=> "Daman &amp; Diu", 4597=> "Dehradun", 2715=> "Dera Bassi", 1160=> "Dhanbad", 1015=> "Dharamsala", 914=> "Dharuhera", 3196=> "Dindigul", 4786=> "Dumdum", 506=> "Durg", 3208=> "Erode", 4092=> "Faizabad", 918=> "Faridabad", 2726=> "Fiozpur", 742=> "Gandhinagar", 5082=> "Goa", 4135=> "Gorakhpur", 4121=> "Ghaziabad", 4138=> "Greater Noida", 925=> "Gurgaon", 1344=> "Gulbarga", 3228=> "Gummidipoondi", 60=> "Guntakal", 61=> "Guntur", 1561=> "Guruvayur", 284=> "Guwahati", 1814=> "Gwalior", 4611=> "Haldwani-cum-Kathgodam", 4817=> "Haora", 4151=> "Hapur", 4612=> "Hardwar", 3233=> "Hosur", 1370=> "Hubli-Dharwad", 1563=> "Idukki Township", 1829=> "Indore", 220=> "Itanagar", 1833=> "Jabalpur", 2904=> "Jaipur", 2905=> "Jaisalmer", 2746=> "Jalandhar", 2182=> "Jalgaon", 2185=> "Jalna", 1076=> "Jammu", 760=> "Jamnagar", 1191=> "Jamshedpur", 2911=> "Jodhpur", 75=> "Kakinada", 1571=> "Kalamassery", 1573=> "Kalpetta", 2199=> "Kalyan-Dombivali", 3275=> "Kancheepuram", 3288=> "Kanniyakumari", 1579=> "Kannur", 4221=> "Kanpur", 2670=> "Karaikal - Pondicherry", 84=> "Karimnagar", 2211=> "Karjat", 947=> "Karnal", 3302=> "Karur", 1582=> "Kasargod", 1023=> "Kasauli", 4619=> "Kashipur", 86=> "Khammam", 4875=> "Kharagpur - Medinipur", 4876=> "Kharagpur Rly. Settlement", 2758=> "Kharar - Rupnagar", 2225=> "Khopoli", 1584=> "Kochi", 3331=> "Kodaikanal", 2525=> "Kohima", 1392=> "Kolar", 3337=> "Kolathur", 2230=> "Kolhapur", 1588=> "Kollam", 4271=> "Kosi Kalan", 2932=> "Kota - Kota", 3348=> "Kotagiri", 1593=> "Kottayam", 3356=> "Kovilpatti", 91=> "Kovvur", 1027=> "Kulu Manali", 3366=> "Kumbakonam", 94=> "Kurnool", 2246=> "Lonavala", 4297=> "Lucknow", 2766=> "Ludhiana", 4899=> "Madhyamgram", 1418=> "Madikeri", 3384=> "Madippakkam", 3387=> "Madurai", 796=> "Mahesana", 102=> "Malkajgiri", 3394=> "Mamallapuram", 1424=> "Mangalore", 624=> "Mapusa", 3412=> "Maraimalainagar", 3413=> "Marakkanam", 627=> "Margao", 4326=> "Mathura", 1605=> "Mavelikkara", 3420=> "Mayiladuthurai", 109=> "Medak", 4333=> "Meerut", 3433=> "Mettupalayam Coimbatore", 3434=> "Mettupalayam Trichirappli", 3436=> "Minjur", 2270=> "Mira-Bhayandar", 2776=> "Moga", 5068=> "Mohali", 4350=> "Moradabad", 1612=> "Muvattupuzha", 5074=> "Munnar", 1441=> "Munnur", 1442=> "Mysore", 813=> "Nadiad", 3454=> "Nagapattinam", 3456=> "Nagercoil", 2289=> "Nagpur", 4638=> "Nainital", 2291=> "Nala Sopara", 115=> "Nalgonda", 3461=> "Namakkal", 2298=> "Nashik", 2300=> "Navi Mumbai", 125=> "Nellore", 2302=> "Neral", 3485=> "Nilgiris", 128=> "Nizamabad", 4386=> "Noida", 131=> "Ongole", 3789=> "Ooty", 3511=> "P. Mettupalayam", 1622=> "Palakkad", 1038=> "Palampur", 3521=> "Palani", 2312=> "Palghar", 2973=> "Pali", 825=> "Palitana", 3526=> "Palladam", 3533=> "Pallavaram", 3534=> "Pallikaranai", 963=> "Palwal", 635=> "Panaji", 2314=> "Panchgani", 964=> "Panchkula Urban Estate", 965=> "Panipat", 2319=> "Panvel", 1632=> "Paravur", 638=> "Parvarim", 1633=> "Pathanamthitta", 2789=> "Pathankot", 2790=> "Patiala", 449=> "Patna", 1643=> "Perumbavoor", 3584=> "Perungudi", 2794=> "Phagwara", 2334=> "Pimpri Chinchwad", 971=> "Pinjore", 3591=> "Pollachi", 642=> "Ponda", 2672=> "Pondicherry", 3596=> "Ponneri", 831=> "Porbandar", 3604=> "Pudukkottai", 2337=> "Pune", 2646=> "Puri", 547=> "Raipur", 148=> "Rajahmundry", 4967=> "Rajarhat Gopalpur", 834=> "Rajkot", 2800=> "Rajpura", 4643=> "Ramnagar - Nainital", 1252=> "Ranchi", 1997=> "Ratlam", 2350=> "Ratnagiri", 978=> "Rewari", 980=> "Rohtak", 4645=> "Roorkee", 4647=> "Rudrapur - Udham Singh Nagar", 5073=> "Rishikesh", 2807=> "S.A.S. Nagar", 163=> "Sadasivpet", 4467=> "Saharanpur", 3638=> "Salem", 2657=> "Sambalpur", 166=> "Sangareddy", 2357=> "Sangli Miraj Kupwad", 2362=> "Satara", 5030=> "Secunderabad", 3012=> "Shahpura - Bhilwara", 1047=> "Shimla", 1478=> "Shimoga", 657=> "Siolim", 2819=> "Sirhind -Fategarh", 4649=> "Sitarganj", 3683=> "Sivakasi", 1048=> "Solan", 2389=> "Solapur", 990=> "Sonipat", 175=> "Srikakulam", 1107=> "Srinagar", 3686=> "Sriperumbudur", 856=> "Surat", 2394=> "Talegaon Dabhade", 3700=> "Tambaram", 188=> "Tenali", 2402=> "Thane", 3709=> "Thanjavur", 5151=> "Thattappally", 1658=> "Thiruvalla", 3747=> "Thiruvallur", 1659=> "Thiruvananthapuram", 3759=> "Thoothukkudi", 1663=> "Thrippunithura", 1664=> "Thrissur", 3772=> "Tiruchirappalli", 3775=> "Tirunelveli", 191=> "Tirupati", 3778=> "Tiruppur", 3781=> "Tiruvannamalai", 193=> "Tuni", 3032=> "Udaipur", 3790=> "Udumalaipettai", 1507=> "Udupi", 2065=> "Ujjain", 2410=> "Ulhasnagar", 3797=> "Urapakkam", 875=> "Vadodara", 3823=> "Vandalur", 880=> "Vapi", 4577=> "Varanasi", 1672=> "Varappuzha", 2425=> "Vasai", 668=> "Vasco-da-Gama", 3848=> "Vellore", 203=> "Vijayawada", 3868=> "Viluppuram", 1510=> "Virajpet", 2429=> "Virar", 205=> "Visakhapatnam", 206=> "Vizianagaram", 4579=> "Vrindavan", 3873=> "Walajabad", 208=> "Warangal", 1001=> "Yamunanagar", 2830=> "Zirakpur", "others"=> "Others");

$arrMapCityList = array(122=>567, 155=>925, 153=>918, 534=>4121, 314=>2278, 345=>2402, 221=>1294, 472=>3156, 4=>63, 249=>1520, 250=>5086, 251=>1563, 252=>1579, 254=>1588, 255=>1593, 258=>1622, 248=>1659, 260=>1664, 261=>5087, 338=>2337, 591=>4885, 126=>677, 503=>3877, 507=>3905, 438=>2832, 249=>1520, 508=>3913, 509=>3914, 439=>2834, 151=>896, 317=>2088, 419=>2681, 128=>683, 6=>13, 607=>3109, 65=>2092, 519=>3978, 420=>2694, 223=>1302, 224=>1304, 130=>698, 131=>699, 444=>2859, 152=>908, 265=>1749, 225=>1313, 5=>378, 226=>1314, 445=>2865, 200=>1139, 523=>4034, 6=>476, 472=>3156, 473=>3177, 474=>3181, 390=>2574, 121=>564, 577=>4597, 203=>1160, 476=>3196, 106=>506, 477=>3208, 529=>4092, 153=>918, 125=>742, 124=>5082, 537=>4135, 534=>4121, 155=>925, 233=>1344, 10=>61, 39=>284, 281=>1814, 284=>1829, 27=>220, 285=>1833, 437=>2904, 454=>2905, 426=>2746, 328=>2182, 329=>2185, 15=>1076, 133=>760, 458=>2911, 252=>1579, 546=>4221, 416=>2670, 11=>84, 160=>947, 480=>3302, 253=>1582, 2=>86, 434=>2758, 374=>2525, 239=>1392, 330=>2230, 254=>1588, 255=>1593, 14=>94, 506=>4297, 428=>2766, 482=>3387, 137=>796, 555=>4326, 16=>109, 557=>4333, 430=>2776, 559=>4350, 242=>1442, 483=>3454, 332=>2289, 583=>4638, 17=>115, 484=>3461, 335=>2298, 18=>125, 485=>3485, 19=>128, 258=>1622, 462=>2973, 123=>635, 164=>965, 256=>1633, 433=>2790, 63=>449, 415=>2672, 142=>831, 487=>3604, 338=>2337, 409=>2646, 101=>547, 143=>834, 199=>1252, 298=>1997, 340=>2350, 165=>978, 166=>980, 565=>4467, 489=>3638, 411=>2657, 342=>2362, 171=>1047, 244=>1478, 181=>1048, 344=>2389, 168=>990, 22=>175, 185=>1107, 145=>856, 345=>2402, 491=>3709, 248=>1659, 260=>1664, 494=>3772, 495=>3775, 497=>3781, 468=>3032, 246=>1507, 310=>2065, 148=>875, 575=>4577, 499=>3848, 500=>3868, 23=>205, 24=>206, 25=>208, 169=>1001);
$varResCity = $arrMapCityList[$varResCity];
?>
<style type="text/css">
	.bluebox{color:#000000; background-color:#F6FBF1; padding:16px 5px 5px 5px; width:100%; font-family:Arial; font-size:12px; line-height:18px; width:540px !important;width:550px;border:1px solid #B8D4A2;height:37px !important;height:60px;}
	.bluebox label{font-size:12px; font-weight:bold; margin:0 10px 0 3px;}
	.bluebox a{font-size:12px; font-weight:bold; color:#fe7412; margin-top:3px;}
	.bluebox select{width:150px; height:22px; border-top:1px solid #c1c1c1;border-right:1px solid #ebebeb;border-bottom:1px solid #ebebeb;border-left:1px solid #c1c1c1; margin-top:2px; font-size:12px;}
	.selcontr{text-align:left; float:left; padding-right:10px;}
	.optionbg{background-color:#F6F6F6; font-size: 12px; font-weight:bold; color:#009C4F;}
	</style>
	<script language="javascript">
		var ArrText = new Array("Delhi / NCR (All)","Delhi NCR (All)","Mumbai (All)","Bangalore (All)","Chennai (All)","Hyderabad (All)","Ahmedabad (All)","International Cities","Any City","Other Cities","Kolkata (All)","Kochi (All)","Pune (All)");
		var ArrNew = new Array("Delhi","Delhi","Mumbai","Bangalore","Chennai","Hyderabad","Ahmedabad","AbuDhabi","Any","Others","Kolkata","Kochi","Pune");
	function checkquicksearchbox(frm){
		if(!frm) frm = document.ipsearch;
		if(frm.propertyType.options[frm.propertyType.selectedIndex].value=="0"){alert("Please select Property Type");return false;}
		if(frm.city.options[frm.city.selectedIndex].value=="0"){alert("Please select City");return false;}
		var trans;
		if(frm.transaction[0].checked){trans=frm.transaction[0].value;}else {trans=frm.transaction[1].value;}
		tempcity = frm.city.options[frm.city.selectedIndex].text;
		for(var i=0; i<ArrText.length; i++) {if(tempcity==ArrText[i]) tempcity=ArrNew[i];}
		tempcity=tempcity.replace(" ","+");
		var qry = "http://www.indiaproperty.com/search/" +  trans + "/" + frm.propertyType.options[frm.propertyType.selectedIndex].value + "-in/";
		qry=qry + tempcity + ".html";		
		window.open(qry);
		return false;
	}
	</script>

<div id="ipsrchdiv" class="rpanel fleft padb10" style="background-color:#E4EEDC;display:none;">
<img src="<?=$confValues['IMGSURL']?>/ipsrchimg1.gif" /><br>
<img src="<?=$confValues['IMGSURL']?>/ipsrchimg2.jpg" /><br>
<img src="<?=$confValues['IMGSURL']?>/ipsrchimg3.gif" /><br>
 <center><div class="bluebox">
	<div class="selcontr">
		<form action="" name="ipsearch" onsubmit="return checkquicksearchbox(this);" target="_blank" method="post">
		<div style="float:left;"><input type="radio" id="onSale" name="transaction" style="line-height:10px; padding-top:10px;" value="sell" checked/><label for="onSale">On Sale</label><input type="radio" id="onRent" value="rent" name="transaction" /><label for="onRent">On Rent</label></div>
		<div style="float:left;"><div id="divpropertyid"></div>
						<select name="propertyType">
							<option value="0">Property Type</option>
							<option class="optionbg" value="allresidential" selected>All Residential</option>
							<option value="apartment_individualapartment">Apartment</option>
							<option value="bungalow_individualhouse">Independent House/Villa</option>
							<option value="apartment_builderfloor">Builder Floor</option>
							<option value="bungalow_farmhouse">Farm House</option>
							<option class="optionbg" value="allcommercial">All Commercial</option>
							<option value="retail_retailshowroomshop">Retail Showroom/Shop</option>
							<option value="officespace_commercialbuilding">Commercial Building</option>
							<option value="officespace_officecomplex">Office Complex</option>
							<option value="officespace_itsoftwaretechnologypark">IT/Software Technology Park</option>
							<option value="retail_warehouse">Warehouse</option>
							<option class="optionbg" value="specialeconomiczone">All SEZ</option>
							<option value="sez_commercialbuilding">Commercial Building</option>
							<option value="sez_industrialestate">Industrial Estate</option>
							<option value="sez_itsoftwaretechnologypark">IT/Software Technology Park</option>
							<option class="optionbg" value="allland">All Land</option>
							<option value="land_residentialuse">Residential Land</option>
							<option value="land_commercialuse">Commercial Land</option>
							<option value="land_industrialuse">Industrial Land</option>
							<option value="land_agriculturaluse">Agricultural Land</option>
							<option value="land_farmhouseplots">Farm House Land</option>
						</select>
						<select class="greenfield" name="city">
							<option value="0">- City -</option>
							<?
							$varAnySelected = 'selected="selected"';
							foreach($arrIPCityList as $varKey=>$varVal){
								$varSelected	= '';
								if($varResCity != '' && $varKey==$varResCity){
									$varSelected	= 'selected="selected"';
									$varAnySelected = '';
								}
								if(substr($varVal, -5)=="(All)"){
									print '<option value="'.$varKey.'" class="optionbg" '.$varSelected.'>'.$varVal.'</option>';
								}else{
									print '<option value="'.$varKey.'" '.$varSelected.'>'.$varVal.'</option>';
								}
							}
							?>
							<option value="any" class="optionbg" <?=$varAnySelected;?>>Any City</option>
							</select>
			
		</div>
		<div style="float:left;padding:2px 0px 0px 10px;"><input type="submit" value="Search" class="button" /></div>
		</form>
	</div>
	<br clear="all" />
	</div>
</center>
</div>