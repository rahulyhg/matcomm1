<?php
if(!isset($notCheckthecookievalue)) {
//require_once("/home/office/collectioninterface/www/inner_login_chk.php");
//require_once("/home/office/cc/www/easypay_arrays.php");
}
$pagerow=10;

$offval=array (5=>"Chennai Office",6=>"Hyderabad Office",7=>"Mumbai Office",8=>"Bangalore Office",9=>"Delhi Office",10=>"Cochin Office",11=>"Kolkata Office",13=>"Pune Office",14=>"Coimbatore Office",16=>"Chandigarh Office",17=>"Madurai Office",18=>"Ahmedabad Office",19=>"Vizag Office",20=>"Indore Office",21=>"Trivandrum Office",22=>"Trichy Office",24=>"Lucknow Office",36=>"Nagpur Office",26=>"Calicut Office",27=>"Guruvayur Office",29=>"Pondichery Office",37=>"Ludhiana Office",23=>"Tanjore Office",34=>"Jaipur Office");
$branches_array=array(0=>"All Offices",1=>"Online Payment",2=>"Chennai Office",3=>"Added by Associate",4=>"US Office",5=>"Chennai Office",6=>"Hyderabad Office",7=>"Mumbai Office",8=>"Bangalore Office",9=>"Delhi Office",10=>"Cochin Office",11=>"Kolkata Office",12=>"Mangalore Office",13=>"Pune Office",14=>"Coimbatore Office",15=>"Mysore Office",16=>"Chandigarh Office",17=>"Madurai Office",18=>"Ahmedabad Office",19=>"Vizag Office",20=>"Indore Office",21=>"Trivandrum Office",22=>"Trichy Office",23=>"Thanjavur Office",24=>"Lucknow Office",26=>"Calicut Office",27=>"Guruvayur Office",28=>"Dubai Office",29=>"Pondichery Office",25=>"SIFY",34=>"Jaipur Office",35=>"Post Office",36=>"Nagpur Office",37=>"Ludhiana Office",100=>"BMC",999=>"Franchisee",888=>"Branch Wise Total",30=>"Eseva",31=>"Sodexso",32=>"Rural Eseva",555=>"BMC Wise Total");
$profilecreatedhash = array(1=>"Self",2=>"Parents",3=>"Siblings",4=>"Relatives",5=>"Friends",7=>"Others");
$lang=array(1=>"TamilMatrimony",2=>"TeluguMatrimony",3=>"KeralaMatrimony",4=>"KannadaMatrimony",5=>"Gujar atiMatrimony",6=>"MarathiMatrimony",7=>"BengaliMatrimony",8=>"PunjabiMatrimony",9=>"SindhiMatrimony",10=>"HindiMatrimony",11=>"OriyaMatrimony",12=>"ParsiMatrimony",13=>"AssameseMatrimony",14=>"Marwadi Matrimony",15=>"UrduMatrimony");
//$paymentmode=array(2=>"Cheque",3=>"Demand Draft",4=>"Cash");
$profilecreatedhash = array(1=>"Self",2=>"Parents",3=>"Siblings",4=>"Relatives",5=>"Friends",7=>"Others");
$countryhash = array(1=>"Afghanistan",2=>"Albania",3=>"Algeria",4=>"American Samoa",5=>"Andorra",6=>"Angola",7=>"Anguilla",8=>"Antarctica",9=>"Antigua and Barbuda",10=>"Argentina",11=>"Armenia",12=>"Aruba",13=>"Australia",14=>"Austria",15=>"Azerbaijan",16=>"Bahamas",17=>"Bahrain",18=>"Bangladesh",19=>"Barbados",20=>"Belarus",21=>"Belgium",22=>"Belize",23=>"Benin",24=>"Bermuda",25=>"Bhutan",26=>"Bolivia",27=>"Bosnia and Herzegovina",28=>"Botswana",29=>"Bouvet Island",30=>"Brazil",31=>"British Indian Ocean Territory",32=>"British Virgin Islands",33=>"Brunei",34=>"Bulgaria",35=>"Burkina Faso",36=>"Burundi",37=>"Cambodia",38=>"Cameroon",39=>"Canada",40=>"Cape Verde",41=>"Cayman Islands",42=>"Central African Republic",43=>"Chad",44=>"Chile",45=>"China",46=>"Christmas Island",47=>"Cocos Islands",48=>"Colombia",49=>"Comoros",50=>"Congo",51=>"Cook Islands",52=>"Costa Rica",53=>"Croatia",54=>"Cuba",55=>"Cyprus",56=>"Czech Republic",57=>"Denmark",58=>"Djibouti",59=>"Dominica",60=>"Dominican Republic",61=>"East Timor",62=>"Ecuador",63=>"Egypt",64=>"El Salvador",65=>"Equatorial Guinea",66=>"Eritrea",67=>"Estonia",68=>"Ethiopia",69=>"Falkland Islands",70=>"Faroe Islands",71=>"Fiji",72=>"Finland",73=>"France",74=>"French Guiana",75=>"French Polynesia",76=>"French Southern Territories",77=>"Gabon",78=>"Gambia",79=>"Georgia",80=>"Germany",81=>"Ghana",82=>"Gibraltar",83=>"Greece",84=>"Greenland",85=>"Grenada",86=>"Guadeloupe",87=>"Guam",88=>"Guatemala",89=>"Guinea",90=>"Guinea-Bissau",91=>"Guyana",92=>"Haiti",93=>"Heard and McDonald Islands",94=>"Honduras",95=>"Hong Kong",96=>"Hungary",97=>"Iceland",98=>"India",99=>"Indonesia",100=>"Iran",101=>"Iraq",102=>"Ireland",103=>"Israel",104=>"Italy",105=>"Ivory Coast",106=>"Jamaica",107=>"Japan",108=>"Jordan",109=>"Kazakhstan",110=>"Kenya",111=>"Kiribati",112=>"Korea - North",113=>"Korea - South",114=>"Kuwait",115=>"Kyrgyzstan",116=>"Laos",117=>"Latvia",118=>"Lebanon",119=>"Lesotho",120=>"Liberia",121=>"Libya",122=>"Liechtenstein",123=>"Lithuania",124=>"Luxembourg",125=>"Macau",126=>"Macedonia, Former Yugoslav Republic of",127=>"Madagascar",128=>"Malawi",129=>"Malaysia",130=>"Maldives",131=>"Mali",132=>"Malta",133=>"Marshall Islands",134=>"Martinique",135=>"Mauritania",136=>"Mauritius",137=>"Mayotte",138=>"Mexico",139=>"Micronesia, Federated States of",140=>"Moldova",141=>"Monaco",142=>"Mongolia",143=>"Montserrat",144=>"Morocco",145=>"Mozambique",146=>"Myanmar",147=>"Namibia",148=>"Nauru",149=>"Nepal",150=>"Netherlands",151=>"Netherlands Antilles",152=>"New Caledonia",153=>"New Zealand",154=>"Nicaragua",155=>"Niger",156=>"Nigeria",157=>"Niue",158=>"Norfolk Island",159=>"Northern Mariana Islands",160=>"Norway",161=>"Oman",162=>"Pakistan",163=>"Palau",164=>"Panama",165=>"Papua New Guinea",166=>"Paraguay",167=>"Peru",168=>"Philippines",169=>"Pitcairn Island",170=>"Poland",171=>"Portugal",172=>"Puerto Rico",173=>"Qatar",174=>"Reunion",175=>"Romania",176=>"Russia",177=>"Rwanda",178=>"S. Georgia and S. Sandwich Isls.",179=>"Saint Kitts & Nevis",180=>"Saint Lucia",181=>"Saint Vincent and The Grenadines",182=>"Samoa",183=>"San Marino",184=>"Sao Tome and Principe",185=>"Saudi Arabia",186=>"Senegal",187=>"Seychelles",188=>"Sierra Leone",189=>"Singapore",190=>"Slovakia",191=>"Slovenia",192=>"Somalia",193=>"South Africa",194=>"Spain",195=>"Sri Lanka",196=>"St. Helena",197=>"St. Pierre and Miquelon",198=>"Sudan",199=>"Suriname",200=>"Svalbard and Jan Mayen Islands",201=>"Swaziland",202=>"Sweden",203=>"Switzerland",204=>"Syria",205=>"Taiwan",206=>"Tajikistan",207=>"Tanzania",208=>"Thailand",209=>"Togo",210=>"Tokelau",211=>"Tonga",212=>"Trinidad and Tobago",213=>"Tunisia",214=>"Turkey",215=>"Turkmenistan",216=>"Turks and Caicos Islands",217=>"Tuvalu",218=>"Uganda",219=>"Ukraine",220=>"United Arab Emirates",221=>"United Kingdom",222=>"United States of America",223=>"Uruguay",224=>"Uzbekistan",225=>"Vanuatu",226=>"Vatican City",227=>"Venezuela",228=>"Vietnam",229=>"Virgin Islands",230=>"Wallis and Futuna Islands",231=>"Western Sahara",232=>"Yemen",233=>"Yugoslavia (Former)",234=>"Zaire",235=>"Zambia",236=>"Zimbabwe");
$assinedstatus=array(5=>"Not Assigned",1=>"Progress",0=>"Pending");
$confirmstatus=array(3=>"Completed",4=>"Not Intrested",2=>"Postponed",6=>"Online Payment");
$collectstatus=  $assinedstatus + $confirmstatus; ///array(0=>"Not Assigned",1=>"Progress",2=>"Completed",3=>"Not Intrested",4=>"Postponded",5=>"Pending");
$RequestFrom=array(1=>"Tele Marketing",2=>"Front Office",3=>"Online",6=>"Doorsteps",7=>"Support",8=>"Payment Failure",9=>"Community-Online",10=>"Community-Offline",11=>"Community-Support"); //4=>"Allsec",5=>"HTMT",

$filterEntry=array(9,10,11);

//siva
$UserType=array(0=>"Select User Type",1=>"Super Admin",2=>"Branch Manager",3=>"Collection Manager",4=>"Collection Executive",5=>"Zone Manager");

$zone=array(5=>"SouthZone",9=>"NorthZone",7=>"WestZone",11=>"EastZone",28=>"OtherZone");


function getHost($memberid) {
	$custdomain=substr($memberid,0,1);
	switch($custdomain) {
		case "A":
			$host="assamesematrimony.com";
			break;
		case "B":
			$host="bengalimatrimony.com";
			break;
		case "G":
			$host="gujaratimatrimony.com";
			break;
		case "H":
			$host="hindimatrimony.com";
			break;
		case "K":
			$host="kannadamatrimony.com";
			break;
		case "E":
			$host="keralamatrimony.com";
			break;
		case "R":
			$host="marathimatrimony.com";
			break;
		case "D":
			$host="marwadimatrimony.com";
			break;
		case "Y":
			$host="oriyamatrimony.com";
			break;
		case "C":
			$host="parsimatrimony.com";
			break;
		case "P":
			$host="punjabimatrimony.com";
			break;
		case "S":
			$host="sindhimatrimony.com";
			break;
		case "M":
			$host="tamilmatrimony.com";
			break;
		case "T":
			$host="telugumatrimony.com";
			break;
		case "U":
			$host="urdumatrimony.com";
			break;
	}
	return $host;
}

function getPackageInfo($matriId){
	$Content = file_get_contents("http://www.communitymatrimony.com/cbstm/cbstmgetpackage.php?matriid=".$matriId."");
	$xml = simplexml_load_string($Content);
	$tcount=count($xml);
	for($i='1';$i<=$tcount;$i++){
		$result1 = $xml->xpath("P".$i."/PNAME");
		$result2 = $xml->xpath("P".$i."/COST");
		$comArray[$i][0]=$result1[0];
		$comArray[$i][1]=$result2[0];
	}
	foreach($comArray as $key=>$val){
		$packNames[$key]=$val[0];
		$packRates[$key]=$val[1];
	}
	$radiobutton='';
	foreach ($packNames as $packgkey=>$pacgkval){
		 $radiobutton[]=$packRates[$packgkey]." - ".$packNames[$packgkey];
		 $packname[$packgkey] =$pacgkval;
	}
	foreach ($packRates as $packgratekey=>$pacgratekval){
		 $rateres[$packgratekey] =$pacgratekval;
	}
	$resPackage[0]=$radiobutton;
	$resPackage[1]=$packname;
	$resPackage[2]=$rateres;

	return 	$resPackage;
}
?>
