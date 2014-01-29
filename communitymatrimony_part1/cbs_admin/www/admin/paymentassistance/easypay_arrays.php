<?php
/* *************************************************************************************************** */
/* Author : A.Kirubasankar
/* Filename : easypay_arrays.php
/* Description :  Useful Arrays 
/* Date : 15-Oct-2009
/* *************************************************************************************************** */

///State list
$state = array(1=>"Andhra Pradesh",2=>"Assam",3=>"Bihar",4=>"Chhattisgarh",5=>"Delhi",6=>"Goa",7=>"Gujarat",     8=>" Haryana & Punjab", 9=>"Jharkhand",10=>"Karnataka",11=>"Kerala",12=>"MadhyaPradesh",13=>"Maharashtra", 14=>"Orissa",15=>"Rajasthan",16=>" Tamil Nadu",17=>"Uttar Pradesh",18=>"Uttarakhand",19=>"West Bengal");

//residing district array list updated on 8-Jan-08
$city =array(1=>"Adoor",2=>"Agra",3=>"Ahmedabad",4=>"Alappuzha",5=>"Allahabad",6=>"Almora",7=>"Anand",8=>"Anantapur",9=>"Ariyalur",10=>"Asansol",11=>"Aurangabad",12=>"Bageshwar",13=>"Bangalore",14=>"Bardhaman",15=>"Bareilly",16=>"Bhopal",17=>"Bhubaneswar",18=>"Bilaspur",19=>"Bokaro",20=>"Calicut",21=>"Chamoli",22=>"Champawat",23=>"Chandigarh",24=>"Chennai",25=>"Cochin",26=>"Coimbatore",27=>"Dehradun",28=>"Dhanbad", 29=>"Dindugul",30=>"Erode",31=>"Faridabad",32=>"Ghaziabad",33=>"Goa",34=>"Gorakhpur",35=>"Gurgaon",36=>"Guruvayur",37=>"Guwahati",38=>"Gwalior",39=>"Haridwar",40=>"Hubli",41=>"Hyderabad",42=>"Idukki",43=>"Indore",44=>"Jabalpur",45=>"Jaipur",46=>"Jamshedpur",47=>"Kakinada",48=>"Kannur",49=>"Kanpur",50=>"Kanyakumari",51=>"Karaikudi",52=>"Karur",53=>"Kolkata",54=>"Kollam",55=>"Kottayam", 56=>"Kumbakonam",57=>"Lucknow",58=>"Ludhiana",59=>"Madurai",60=>"Malappuram",61=>"Mangalore",62=>"Mehasana",63=>"Mumbai",64=>"Musiri",65=>"Mysore",66=>"Nagercoil",67=>"Nagpur",68=>"Nainital",69=>"Namakal",70=>"New Delhi",71=>"Noida",72=>"Palakkad",73=>"Pathanamthitta",74=>"Patna", 75=>"Pauri Garhwal",76=>"Peramblur",77=>"Pithoragarh",78=>"Pondicherry",79=>"Pudukottai",80=>"Pune",81=>"Raipur",82=>"Rajapalyam",83=>"Rajkot",84=>"Ramanathapuram",85=>"Ranchi",86=>"Rourkela",87=>"Rudrapyag",88=>"Salem",89=>"Sangli",90=>"Siliguri", 91=>"Sivaganga",92=>"Surat",93=>"Tehri Garwal",94=>"Thanjavur",95=>"Theni",96=>"Thirunelveli",97=>"Thiruvalla", 98=>"Thiruvananthapuram",99=>"Thrissur",100=>"Tirupati",101=>"Trichy",102=>"Tuticorin",103=>"Udaipur",104=>"UddhamSingh Nagar",105=>"Uttarkashi",106=>"Vadodara(Baroda)",107=>"Valsad",108=>"Varanasi",109=>"Vellore",  110=>"Vijayawada",111=>"Virdhunagar",112=>"Vishakhapatnam",113=>"Waynadu",114=>"Hissar",115=>"Jind",116=>"Kaithal",117=>"Karnal",118=>"Kurukshtra",119=>"Mathura",120=>"Meerut",121=>"Panipat",122=>"Rohtak",123=>"Sonipat",124=>"YamunaNagar",128=>"Cudallore",129=>"Chidambaram",130=>"Vadalur",131=>"Panruti",132=>"Nellikuppam",133=>"Neyveli",134=>"Kattumannarkoil",135=>"Mantharakuppam",136=>"Villupuram",137=>"Tindivanam",138=>"Nagapattinam",139=>"Sirghazi",140=>"Karaikal",141=>"Ulundurpet",142=>"Kallakurichi",143=>"Thiruvannamalai",144=>"Palani",145=>"Mayiladuthurai",146=>"Tiruvarur",147=>"Dharmapuri",148=>"Krishnagiri",149=>"Nilgiris",150=>"Pollachi",151=>"Udumalaipet",152=>"Dharapuram",153=>"Tirupur",154=>"Avinashi",155=>"Thiruvallur",156=>"Arakkonam",157=>"Chengalpet",158=>"Kanchipuram",159=>"Gummudipoondy",160=>"Adilabad",161=>"Chittoor",162=>"Cuddapah",163=>"Godavari",164=>"Guntur",165=>"Karimnagar",166=>"Khammam",167=>"Krishna",168=>"Kurnool",169=>"Mahbubnagar",170=>"Medak",171=>"Nalgonda",172=>"Nellore",173=>"Nizamabad",174=>"Prakasam", 175=>"Rangareddi",176=>"Srikakulam",178=>"Vizianagaram",179=>"Warangal",180=>"Akola",181=>"Chandrapur",182=>"Yavatmal",183=>"Wardha",184=>"Bhandara",185=>"Durg/Bhillai",186=>"Korba",187=>"Amaravathi",188=>"Dhule",189=>"Jalgao",190=>"Nanded",191=>"Koria",192=>"Raigadh",193=>"Rajnandgao",194=>"Dastar",195=>"Dantewada",196=>"Dhantari",197=>"Janghir/Champa",198=>"Jashpur",199=>"Kanker",200=>"Kawardha",201=>"Mahasamundh",202=>"Surguja",203=>"Rewari",204=>"Bhadurgarh",205=>"Sirsa",206=>"Fatehabad",207=>"Bhivanai",208=>"Jhajhar",209=>"Haryana");//Added new city list 187 to 202 for mapping on may 29 2009-Anish.G


//updated nagpur and indore mapping cities
$cityarraycheck=array(78=>array(128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143),59=>array(102,91,51,95,96,29,144,111,66,50,84),101=>array(94,56,145,146,76,9,79,147,148,69,52),26=>array(30,88,149,150,151,152,153,154),24=>array(109,154,155,156,157,158,159),112=>array(8,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179),67=>array(180,181,182,183,184,185,186,187,188,189,190,191,192,193,18,67,81),43=>array(16,38,43,44,194,195,196,197,198,199,200,201,202),209=>array(31,35,114,115,116,117,118,121,122,123,124,203,204,205,206,207,208,209));


//$state_othercity_map=array(24=>array(31,1),41=>array(2),13=>array(17),25=>array(18,19,5,16,35,4,26,3,22,2324,25,30,32),78=>array(27), 70=>array(15,14,13,28,33,34,6,10,29),63=>array(21,12,20,7,11,9,8));
$state_othercity_map=array(24=>array(31,1),41=>array(2),13=>array(17),25=>array(18,19),53=>array(5,16,35,4,26,3,22,23,24,25,30,32),78=>array(27),70=>array(15,14,13,28,33,34,6,10,29),63=>array(21,20,7,11,9,8),3=>array(12));


// Handing Over //
$handingover=array(1=>"Photo",2=>"Horoscope",3=>"Photo and Horoscope");
// Mode of Payment //
$paymentmode=array(2=>"Cheque",3=>"Demand Draft",4=>"Cash");

$optionselected=array(

"98"=>array(1=>"Visa / MasterCard Credit Card",
2=>"Other Credit Cards / Netbanking Accounts",
49=>"Pay through ItzCash Cards",
5=>"Pay at your Doorstep",
3=>"BharatMatrimony.com offices",
4=>"BharatMatrimony Centres",
8=>"Payment Associates",
9=>"Pay at Banks"),

"220"=>array(1=>"Visa / MasterCard / Discover / AMEX",
3=>"BharatMatrimony.com offices",
4=>"Pay at your Doorstep",
5=>"Al-Ansari",
7=>"Al Fardan Exchange",
8=>"Al Ghurair Exchange",
6=>"Payment Associates"),

"21"=>array(1=>"Visa / MasterCard Credit Card"),

"221"=>array(1=>"Visa / MasterCard / Discover / AMEX",
3=>"Payment Associates"),

"222"=>array(1=>"Visa / MasterCard / Discover / AMEX",
3=>"BharatMatrimony.com offices",
4=>"Payment Associates")

);

//bmpaymnent country code array
$arrCountryDetails = array (IN=>'98',UK=>'221',GB=>'221',BH=>'220',CY=>'220',EG=>'220',IR=>'220',IQ=>'220',IL=>'220',JO=>'220',KW=>'220',LB=>'220',OM=>'220',QA=>'220',SA=>'220',SY=>'220',TR=>'220',AE=>'220',YE=>'220',AL=>'21',AD=>'21',AT=>'21',BY=>'21',BE=>'21',BA=>'21',BG=>'21',HR=>'21',CZ=>'21',DK=>'21',EE=>'21',FI=>'21',FR=>'21',DE=>'21',GR=>'21',HU=>'21',IS=>'21',IE=>'21',IT=>'21',LV=>'21',LI=>'21',LU=>'21',MO=>'21',MT=>'21',MD=>'21',MC=>'21',NL=>'21',PL=>'21',PT=>'21',RO=>'21',RU=>'21',SM=>'21',SK=>'21',SI=>'21',ES=>'21',SE=>'21',CH=>'21',TR=>'21',UA=>'21');


?>