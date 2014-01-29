<?php
/* *************************************************************************************************** */
/* Author : Ashok kumar
/* Filename : tmeasypayarrays.php [ Collection Interface ]
/* Description :
/* Date : 08-Oct-2007
/* *************************************************************************************************** */

// State Array //
$state = array(1=>"Andhra Pradesh",2=>"Assam",3=>"Bihar",4=>"Chhattisgarh",5=>"Delhi",6=>"Goa",7=>"Gujarat",     8=>" Haryana & Punjab", 9=>"Jharkhand",10=>"Karnataka",11=>"Kerala",12=>"MadhyaPradesh",13=>"Maharashtra", 14=>"Orissa",15=>"Rajasthan",16=>" Tamil Nadu",17=>"Uttar Pradesh",18=>"Uttarakhand",19=>"West Bengal");

//residing district array list updated on 8-Jan-08
$eprCity =array(1=>"Adoor",2=>"Agra",3=>"Ahmedabad",4=>"Alappuzha",5=>"Allahabad",6=>"Almora",7=>"Anand",8=>"Anantapur",9=>"Ariyalur",10=>"Asansol",11=>"Aurangabad",12=>"Bageshwar",13=>"Bangalore",14=>"Bardhaman",15=>"Bareilly",16=>"Bhopal",17=>"Bhubaneswar",18=>"Bilaspur",19=>"Bokaro",20=>"Calicut",21=>"Chamoli",22=>"Champawat",23=>"Chandigarh",24=>"Chennai",25=>"Cochin",26=>"Coimbatore",27=>"Dehradun",28=>"Dhanbad", 29=>"Dindugul",30=>"Erode",31=>"Faridabad",32=>"Ghaziabad",33=>"Goa",34=>"Gorakhpur",35=>"Gurgaon",36=>"Guruvayur",37=>"Guwahati",38=>"Gwalior",39=>"Haridwar",40=>"Hubli",41=>"Hyderabad",42=>"Idukki",43=>"Indore",44=>"Jabalpur",45=>"Jaipur",46=>"Jamshedpur",47=>"Kakinada",48=>"Kannur",49=>"Kanpur",50=>"Kanyakumari",51=>"Karaikudi",52=>"Karur",53=>"Kolkata",54=>"Kollam",55=>"Kottayam", 56=>"Kumbakonam",57=>"Lucknow",58=>"Ludhiana",59=>"Madurai",60=>"Malappuram",61=>"Mangalore",62=>"Mehasana",63=>"Mumbai",64=>"Musiri",65=>"Mysore",66=>"Nagercoil",67=>"Nagpur",68=>"Nainital",69=>"Namakal",70=>"New Delhi",71=>"Noida",72=>"Palakkad",73=>"Pathanamthitta",74=>"Patna", 75=>"Pauri Garhwal",76=>"Peramblur",77=>"Pithoragarh",78=>"Pondicherry",79=>"Pudukottai",80=>"Pune",81=>"Raipur",82=>"Rajapalyam",83=>"Rajkot",84=>"Ramanathapuram",85=>"Ranchi",86=>"Rourkela",87=>"Rudrapyag",88=>"Salem",89=>"Sangli",90=>"Siliguri", 91=>"Sivaganga",92=>"Surat",93=>"Tehri Garwal",94=>"Thanjavur",95=>"Theni",96=>"Thirunelveli",97=>"Thiruvalla", 98=>"Thiruvananthapuram",99=>"Thrissur",100=>"Tirupati",101=>"Trichy",102=>"Tuticorin",103=>"Udaipur",104=>"UddhamSingh Nagar",105=>"Uttarkashi",106=>"Vadodara(Baroda)",107=>"Valsad",108=>"Varanasi",109=>"Vellore",  110=>"Vijayawada",111=>"Virdhunagar",112=>"Vishakhapatnam",113=>"Waynadu",114=>"Hissar",115=>"Jind",116=>"Kaithal",117=>"Karnal",118=>"Kurukshtra",119=>"Mathura",120=>"Meerut",121=>"Panipat",122=>"Rohtak",123=>"Sonipat",124=>"YamunaNagar",128=>"Cudallore",129=>"Chidambaram",130=>"Vadalur",131=>"Panruti",132=>"Nellikuppam",133=>"Neyveli",134=>"Kattumannarkoil",135=>"Mantharakuppam",136=>"Villupuram",137=>"Tindivanam",138=>"Nagapattinam",139=>"Sirghazi",140=>"Karaikal",141=>"Ulundurpet",142=>"Kallakurichi",143=>"Thiruvannamalai",144=>"Palani",145=>"Mayiladuthurai",146=>"Tiruvarur",147=>"Dharmapuri",148=>"Krishnagiri",149=>"Nilgiris",150=>"Pollachi",151=>"Udumalaipet",152=>"Dharapuram",153=>"Tirupur",154=>"Avinashi",155=>"Thiruvallur",156=>"Arakkonam",157=>"Chengalpet",158=>"Kanchipuram",159=>"Gummudipoondy",160=>"Adilabad",161=>"Chittoor",162=>"Cuddapah",163=>"Godavari",164=>"Guntur",165=>"Karimnagar",166=>"Khammam",167=>"Krishna",168=>"Kurnool",169=>"Mahbubnagar",170=>"Medak",171=>"Nalgonda",172=>"Nellore",173=>"Nizamabad",174=>"Prakasam", 175=>"Rangareddi",176=>"Srikakulam",178=>"Vizianagaram",179=>"Warangal",180=>"Akola",181=>"Chandrapur",182=>"Yavatmal",183=>"Wardha",184=>"Bhandara",185=>"Durg/Bhillai",186=>"Korba",187=>"Amaravathi",188=>"Dhule",189=>"Jalgao",190=>"Nanded",191=>"Koria",192=>"Raigadh",193=>"Rajnandgao",194=>"Dastar",195=>"Dantewada",196=>"Dhantar
i",197=>"Janghir/Champa",198=>"Jashpur",199=>"Kanker",200=>"Kawardha",201=>"Mahasamundh",202=>"Surguja",203=>"Rewari",204=>"Bhadurgarh",205=>"Sirsa",206=>"Fatehabad",207=>"Bhivanai",208=>"Jhajhar",209=>"Haryana");//Added new city list 187 to 202 for mapping on may 29 2009-Anish.G

$otherCountyeprcity=array(125=>"UAE",126=>"USA",127=>"UK");

$StateWiseMapping=array(24=>array(31,1),41=>array(2),13=>array(17),25=>array(18,19),53=>array(5,16,35,4,26,3,22,23,24,25,30,32),78=>array(27),70=>array(15,14,13,28,33,34,6,10,29),63=>array(21,20,7,11,9,8),3=>array(12));

//citywisemapping
$cityWiseMapping=array(78=>array(128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143),59=>array(102,91,51,95,29,144,111,66,50,84),101=>array(94,56,145,146,76,9,79,147,148,69,52),26=>array(30,149,150,151,152,153,154),24=>array(109,154,155,156,157,158,159),112=>array(8,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179),67=>array(180,181,182,183,184,185,186,187,188,189,190,191,192,193,18,67,81),43=>array(16,38,43,44,193,194,195,196,197,198,199,200,201,202),209=>array(31,35,114,115,116,117,118,121,122,123,124,203,204,205,206,207,208,209));


// State & City Map Array //
$state_city_map = array(1=>array(8,41,112,47,100,110),2=>array(37), 3=>array(74,85),4=>array(18,81),5=>array(70),6=>array(33),7=>array(3,83,106,62,7,107,92),8=>array(23,58,31,35), 9=>array(46,28),10=>array(13,61,65,40),11=>array(1,4,20,25,36,42,48,55,54,60,72,73,98,97,99,113),12=>array(16,38,44,43), 13=>array(11,63,80,89),14=>array(17,86),15=>array(45,103),16=>array(9,24,29,30,26,50,51,52,56,59,88,91,64,66,69,94,95,96,101,102,76,79,89,84,78,109,111),17=>array(2,5,15,32,34,57,71,108,49),18=>array(27,39,6,12,21,22,68,75,77,87,93,104,105),19=>array(10,14,53,90,19));

$europackeges=array(2,5,14,20,21,27,34,53,56,57,67,72,73,72,73,80,83,96,97,102,104,117,122,123,124,126,132,140,141,150,160,170,171,175,176,186,190,191,194,202,203,214,219,226);
$uaepackeges=array(17,114,161,173,185,220);

// Package Array //
$package98 = array (1 => array("name"=>"Classic 3 Month package", "rate"=>"1990"),
				  2 => array("name"=>"Classic 6 Month package", "rate"=>"3390"),	
				  3 => array("name"=>"Classic 9 Month package", "rate"=>"4490"),	
				  4 => array("name"=>"Classic plus 3 Month package", "rate"=>"2590"),	
				  5 => array("name"=>"Classic plus 6 Month package", "rate"=>"4390"),	
				  6 => array("name"=>"Classic plus 9 Month package", "rate"=>"5790"),	
				  7 => array("name"=>"Classic super 3 Month package", "rate"=>"2890"),	
				  8 => array("name"=>"Classic super 6 Month package", "rate"=>"4890"),	
				  9 => array("name"=>"Classic super 9 Month package", "rate"=>"6490")
				  );
//10 => array("name"=>"Classic super 11 Month package", "rate"=>"7490");
// Privileage package for india
$PRIVILEGEPACKAGE = array (1 => array("name"=>"Classic 3 Month package", "rate"=>"1990"),
				  2 => array("name"=>"Classic 6 Month package", "rate"=>"3390"),	
				  3 => array("name"=>"Classic 9 Month package", "rate"=>"4490"),	
				  4 => array("name"=>"Classic plus 3 Month package", "rate"=>"2590"),	
				  5 => array("name"=>"Classic plus 6 Month package", "rate"=>"4390"),	
				  6 => array("name"=>"Classic plus 9 Month package", "rate"=>"5790"),	
				  7 => array("name"=>"Classic super 3 Month package", "rate"=>"2890"),	
				  8 => array("name"=>"Classic super 6 Month package", "rate"=>"4890"),	
				  9 => array("name"=>"Classic super 9 Month package", "rate"=>"6490"),	
				  48 => array("name"=>"BM Privilege - Personalised service", "rate"=>"14990"));


//us dollar
$package222= array (1 => array("name"=>"Classic 3 Month package", "rate"=>"67"),
				  2 => array("name"=>"Classic 6 Month package", "rate"=>"114"),	
				  3 => array("name"=>"Classic 9 Month package", "rate"=>"145"),	
				  4 => array("name"=>"Classic plus 3 Month package", "rate"=>"89"),	
				  5 => array("name"=>"Classic plus 6 Month package", "rate"=>"147"),	
				  6 => array("name"=>"Classic plus 9 Month package", "rate"=>"194"),	
				  7 => array("name"=>"Classic super 3 Month package", "rate"=>"99"),	
				  8 => array("name"=>"Classic super 6 Month package", "rate"=>"166"),	
				  9 => array("name"=>"Classic super 9 Month package", "rate"=>"277"),	
				  48 => array("name"=>"BM Privilege - Personalised service", "rate"=>"499"));  
		   
// Package Array for 221=>GBP rates
$package221 = array (1 => array("name"=>"Classic 3 Month package", "rate"=>"46"),
				  2 => array("name"=>"Classic 6 Month package", "rate"=>"77"),	
				  3 => array("name"=>"Classic 9 Month package", "rate"=>"102"),	
				  4 => array("name"=>"Classic plus 3 Month package", "rate"=>"62"),	
				  5 => array("name"=>"Classic plus 6 Month package", "rate"=>"101"),	
				  6 => array("name"=>"Classic plus 9 Month package", "rate"=>"132"),	
				  7 => array("name"=>"Classic super 3 Month package", "rate"=>"69"),	
				  8 => array("name"=>"Classic super 6 Month package", "rate"=>"118"),	
				  9 => array("name"=>"Classic super 9 Month package", "rate"=>"149"),	
				  48 => array("name"=>"BM Privilege - Personalised service", "rate"=>"338")); 

		   
// Package Array for 220=>AED rates
$package220= array (1 => array("name"=>"Classic 3 Month package", "rate"=>"205"),
				  2 => array("name"=>"Classic 6 Month package", "rate"=>"345"),	
				  3 => array("name"=>"Classic 9 Month package", "rate"=>"455"),	
				  4 => array("name"=>"Classic plus 3 Month package", "rate"=>"280"),	
				  5 => array("name"=>"Classic plus 6 Month package", "rate"=>"465"),	
				  6 => array("name"=>"Classic plus 9 Month package", "rate"=>"605"),	
				  7 => array("name"=>"Classic super 3 Month package", "rate"=>"320"),	
				  8 => array("name"=>"Classic super 6 Month package", "rate"=>"525"),	
				  9 => array("name"=>"Classic super 9 Month package", "rate"=>"685"),	
				  48 => array("name"=>"BM Privilege - Personalised service", "rate"=>"1590")); 
// Package Array for 21=>EURO rates
$package21 = array (1 => array("name"=>"Classic 3 Month package", "rate"=>"52"),
				  2 => array("name"=>"Classic 6 Month package", "rate"=>"88"),	
				  3 => array("name"=>"Classic 9 Month package", "rate"=>"116"),	
				  4 => array("name"=>"Classic plus 3 Month package", "rate"=>"71"),	
				  5 => array("name"=>"Classic plus 6 Month package", "rate"=>"115"),	
				  6 => array("name"=>"Classic plus 9 Month package", "rate"=>"151"),	
				  7 => array("name"=>"Classic super 3 Month package", "rate"=>"79"),	
				  8 => array("name"=>"Classic super 6 Month package", "rate"=>"135"),	
				  9 => array("name"=>"Classic super 9 Month package", "rate"=>"170"),	
				  48 => array("name"=>"BM Privilege - Personalised service", "rate"=>"393")); 

// Additional Package Array //
$addonpackage = array (1 => array("name"=>"Smart Pack - I","rate"=>"1200"),
					   2 => array("name"=>"Smart Pack - II","rate"=>"2000"));

// Handing Over //
$handingover=array(1=>"Photo",2=>"Horoscope",3=>"Photo and Horoscope");
// Mode of Payment //
$paymentmode=array(2=>"Cheque",3=>"Demand Draft",4=>"Cash");

$idstartletterhash=array(7=>"B",6=>"R",5=>"G",8=>"P",10=>"H",9=>"S",4=>"K",3=>"E",2=>"T",1=>"M",14=>"D",12=>"C",13=>"A",11=>"Y",15=>"U");

// other city array Easy pay
$autoSuggestArray=array("24 Parganas","Agartala","Aizawl","Angul","Araria","Balangir","Baleswar","Banka","Bankura","Bargarh","Barpeta","Begusarai","Bhadrak","Bhojpur","Bhubaneshwar","Birbhum","Bishnupur","Bongaigaon","Boudh","Buxar","Cachar","Champaran","Champhai","Chandel","Changlang","Chatra","Churachandpur","Cooch Behar","Cuttack","Darbhanga","Darjiling","Darrang","Debagarh","Deoghar","Dhalai","Dhemaji","Dhenkanal","Dhubri","Dibang Valley","Dibrugarh","Dimapur","Dinajpur","Dumka","Gajapati","Gangtok","Ganjam","Garhwa","Garo Hills","Gaya ","Giridih","Goalpara","Godda","Golaghat","Gopalganj","Gumla","Hailakandi","Hazaribag","Hooghly","Howrah","Imphal","Itanagar","Jagatsinghapur","Jaintia Hills","Jajapur","Jalpaiguri","Jamtara","Jamui","Jehanabad","Jharsuguda","Jorhat","Kaimur (Bhabua)","Kalahandi","Kameng","Kamrup","Kandhamal","Karbi Anglong","Karimganj","Katihar","Kendrapara","Kendujhar","Khagaria","Khasi Hills","Khordha","Kishanganj","Koderma","Kohima","Kokrajhar","Kolasib","Koraput","Kurung Kumey","Lakhimpur","Lakhisarai","Latehar","Lawngtlai","Lohardaga","Lohit","Lunglei","Madhepura","Madhubani","Malda","Malkangiri","Mamit","Marigaon","Mayurbhanj","Midnapore","Mokokchung","Mon","Munger","Murshidabad","Muzaffarpur","Nabarangapur","Nadia","Nagaon","Nalanda","Nalbari","Nawada","Nayagarh","Nuapada","Pakur","Palamu","Papum Pare","Parganas","Phek","Puri","Purnia","Puruliya","Rayagada","Ri Bhoi","Rohtas","Saharsa","Sahibganj","Saiha","Samastipur","Sambalpur","Saran","Senapati","Seraikela","Serchhip","Sheikhpura","Sheohar","Shillong","Siang","Sikkim","Simdega","Singhbhum","Sitamarhi","Sivasagar","Siwan","Sonapur","Sonitpur","Subansiri","Sundergarh","Supaul","Tamenglong","Tawang","Thoubal","Tinsukia","Tirap","Tripura","Tuensang","Ukhrul","Vaishali","Wokha","Zunheboto","Ambala","Amritsar","Anantnag","Baramulla","Budgam","Chamba","Doda","Hamirpur","Jammu","Kangra","Kargil","Kathua","Kinnaur","Kullu","Kupwara","Lahaul & Spiti","Leh","Mandi","Panchkula","Patiala","Poonch","Pulwama","Rajauri","Rupnagar","SAS Nagar","Shimla","Sirmaur","Solan","Srinagar","Udhampur","Una","Rudraprayag","Tehri Garhwal","Udham Singh Nagar","Bhiwani","Fatehabad","Gautam Buddha Nagar","Ghazipur","Hisar","Jhajjar","Kurukshetra","Mahendragarh","Rewari","Sirsa","Ajmer","Alwar","Banswara","Baran","Barmer","Bharatpur","Bhilwara","Bikaner","Bundi","Chittorgarh","Churu","Dausa","Dholpur","Dungarpur","Ganganagar","Hanumangarh","Jaisalmer","Jalor","Jhalawar","Jhunjhunu","Jodhpur","Karauli","Kota","Nagaur","Pali","Rajsamand","Sawai Madhopur","Sikar","Sirohi","Tonk","Aligarh","Ambedkar Nagar","Auraiya","Azamgarh","Bagpat","Bahraich","Ballia","Balrampur","Banda","Barabanki","Basti","Bijnor","Budaun","Bulandshahr","Chandauli","Chitrakoot","Deoria","Etah","Etawah","Faizabad","Farrukhabad","Fatehpur","Firozabad","Gonda","Hardoi","Hathras","Jalaun","Jaunpur","Jhansi","Jyotiba Phule Nagar","Kannauj","Kanpur Dehat","Kanpur Nagar","Kaushambi","Kheri","Kushinagar","Lalitpur","Maharajganj","Mahoba","Mainpuri","Mau","Mirzapur","Moradabad","Muzaffarnagar","Pilibhit","Pratapgarh","Raebareli","Rampur","Saharanpur","Sant Kabir Nagar","Sant Ravidas Nagar","Shahjahanpur","Shrawasti","Siddharthnagar","Sitapur","Sonbhadra","Sultanpur","Unnao","Bathinda","Faridkot","Fatehgarh Sahib","Firozpur","Gurdaspur","Hoshiarpur","Jalandhar","Kapurthala","Mansa","Moga","Muktsar","Nawanshahr","Sangrur","Bagalkot","Belgaum","Bellary","Bidar","Bijapur","Chickmagalur","Chitradurga","Dakshin Kannada","Davangere","Dharwad","Gadag","Gulbarga","Hassan","Haveri","Kolar","Koppal","Raichur","Shimoga","Tumkur","Udupi","Uttar Kannada","Kanchipuram","Tiruvannamalai","Andaman Nicobar","Kavaratti","Lakshadweep","Port Blair","Tiruvallur","Nagapattinam","Viluppuram","Kozhikode","Wayanad","Ernakulam","Kasargod","Thrissur","Nilgiris","Dindigul","Ramanathapuram","Thoothukudi","Tirunelveli","Virudhunagar","Chamrajnagar","Kodagu","Mandya","Cuddalore","Karaikal","Dharmapuri","Krishnagiri","Namakkal","Perambalur","Pudukkottai","Tiruchirappalli","Tiruvarur","Thiruvananthapuram","Amreli","Banas Kantha","Bharuch","Bhavnagar","Daman And Diu","Dohad","Gandhinagar","Jamnagar","Junagadh","Kachchh","Kheda","Mahesana","Narmada","Panch Mahals","Patan","Porbandar","Sabar Kantha","Surendranagar","Vadodara","Anuppur","Ashoknagar","Balaghat","Barwani","Bastar","Betul","Bhind","Burhanpur","Chhatarpur","Chhindwara","Damoh","Datia","Dewas","Dhamtari","Dhar","Dindori","Guna","Harda","Hoshangabad","Jhabua","Katni","Khandwa","Khargone","Mandla","Mandsaur","Morena","Narsinghpur","Neemuch","Panna","Raisen","Rajgarh","Ratlam","Rewa","Sagar","Satna","Sehore","Seoni","Shahdol","Shajapur","Sheopur","Shivpuri","Sidhi","Tikamgarh","Ujjain","Umaria","Vidisha","Ahmednagar","Bandra Suburban","Beed","Kolhapur","Latur","Nandurbar","Nashik","Osmanabad","Panaji","Raigarh","Raigarh","Ratnagiri","Satara","Sindhudurg","Solapur","Thane","Buldhana","Gadchiroli","Gondia","Hingoli","Jalna","Parbhani","Washim","Dadra And Nagar Haveli","Daman","Navsari","Silvassa","The Dangs");


?>
