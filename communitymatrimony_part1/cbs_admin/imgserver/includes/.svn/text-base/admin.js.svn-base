function funViewPhoto(argUrl)
{
	window.open(argUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=660,height=500,status=no,scrollbars=no,titlebar=no;");
}//funViewPhoto

function funDeletePhotoConfirm(argPhotoId,argPhotoName)
{
	if (confirm("Are you sure you want to delete this photo?"))
	{
		var funFormName = document.frmAddedPhoto;
		funFormName.action.value="delete";
		funFormName.photoId.value=argPhotoId;
		funFormName.photoName.value=argPhotoName;
		funFormName.submit();
	}
}//funDeletePhotoConfirm
var ArrCasteDivisionList = new Array(

new Array(
new Array("--Select--", ""),
new Array("Sunni Hanafi", "1"),
new Array("Sunni Maliki", "2"),
new Array("Sunni Shafii", "3"),
new Array("Sunni Hanabali", "4")
),

new Array(
new Array("--Select--", ""),
new Array("Shia Ithna Asharis (Twelvers)", "5"),
new Array("Shia Isma'ilis (Seveners)", "6"),
new Array("Shia Zaidis (Fivers)", "7")
),

new Array(
new Array("--Select--", ""),
new Array("Others", "8")
),

null,
new Array(
new Array("", "")
)

);

function HaveChildnp()
{
	var frmEditInfo=document.frmEditProfile;
	var varChild = frmEditInfo.noOfChildren.options[frmEditInfo.noOfChildren.selectedIndex].value;

	if(frmEditInfo.maritalStatus[0].checked)
	{
		frmEditInfo.noOfChildren.value="";
		frmEditInfo.noOfChildren.disabled=true;	
		frmEditInfo.childrenLivingWithMe[0].disabled=true;		
		frmEditInfo.childrenLivingWithMe[1].disabled=true;									
	}
	else if ( frmEditInfo.maritalStatus[1].checked || frmEditInfo.maritalStatus[2].checked  || frmEditInfo.maritalStatus[3].checked || frmEditInfo.maritalStatus[4].checked)
	{
		frmEditInfo.noOfChildren.disabled=false;			
		frmEditInfo.childrenLivingWithMe[0].disabled=false;		
		frmEditInfo.childrenLivingWithMe[1].disabled=false;											
	}
		
	if(frmEditInfo.maritalStatus[0].checked && frmEditInfo.childrenLivingWithMe[0].checked || frmEditInfo.childrenLivingWithMe[1].checked)
	{
		frmEditInfo.childrenLivingWithMe[0].disabled=true;		
		frmEditInfo.childrenLivingWithMe[1].disabled=true;											
	}

	if(varChild > 0) {
		if ( frmEditInfo.maritalStatus[0].checked) {
			if ( (frmEditInfo.childrenLivingWithMe[0].checked || frmEditInfo.childrenLivingWithMe[1].checked) && (!frmEditInfo.childrenLivingWithMe[0].checked || !frmEditInfo.childrenLivingWithMe[1].checked) )
			{
				frmEditInfo.childrenLivingWithMe[0].checked=false;
				frmEditInfo.childrenLivingWithMe[1].checked=false;
				frmEditInfo.childrenLivingWithMe[0].disabled=true;		
				frmEditInfo.childrenLivingWithMe[1].disabled=true;	
			}//if
		}//if
	}//if

	if(varChild == 0) {
		frmEditInfo.childrenLivingWithMe[0].disabled=true;		
		frmEditInfo.childrenLivingWithMe[1].disabled=true;							
	}//if
	else if ( varChild > 1) {
		frmEditInfo.childrenLivingWithMe[0].disabled=false;		
		frmEditInfo.childrenLivingWithMe[1].disabled=false;							
	}//eles if
}//if

function agefocus() {
	var frmEditInfo=document.frmEditProfile;
	if(!(frmEditInfo.dobYear.value=="0") && !(frmEditInfo.dobMonth.value=="0") && !(frmEditInfo.dobDay.value=="0"))
	{	
		frmEditInfo.dobMonth.value="1";
		frmEditInfo.dobDay.value="1";		
		frmEditInfo.dobYear.value="0";
	}
}//agefocus

function agesel() {
	document.frmEditProfile.age.value=""
}//agesel

function funHeightCms()
{
	if (!(document.frmEditProfile.heightFeet.value=="0"))
	{
		document.frmEditProfile.heightFeet.value="0";
	}
}//funHeightCms
	
function funHeightFeet()
{
	if (!(document.frmEditProfile.heightCms.value=="0"))
	{
		document.frmEditProfile.heightCms.value="0";
	}		
}//funHeightFeet

function funWeightKgs()
{
	if (!(document.frmEditProfile.weightLbs.value=="0"))
	{
		document.frmEditProfile.weightLbs.value="0";
	}
}//funWeightKgs

function funWeightLbs()
{
	if (!(document.frmEditProfile.weightKgs.value=="0"))
	{
		document.frmEditProfile.weightKgs.value="0";
	}
}//funWeightLbs

function textCounter(field,maxChars,spanName)
{
	var txtArea = document.frmEditProfile.description.value;//getElementById('description');
	var Length=(txtArea.length);
	var TotalCharLength=(maxChars + Length);
	document.getElementById(spanName).innerHTML = TotalCharLength;//maxChars + txtArea.value.length;
}//textCounter

function hintspop()
{
	window.open("hints-pop.html","","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=442,height=400,status=no,scrollbars=yes");
}//hintspop


function Validate()
{
	var frmEditInfo=document.frmEditProfile;
	var strName=frmEditInfo.name.value;
	//strName = LTrim(strName);
	//strName = RTrim(strName);

	if(nullchk(strName) == true)
	{
		alert( "Please enter Name");
		frmEditInfo.name.focus( );
		return false;
	}//if
	if (IsEmpty(frmEditInfo.name,'text'))
	{
		alert( "Please enter Name");
		frmEditInfo.name.focus( );
		return false;
	}//if
	if(IsNumberPresent(strName)==true)
	{
		alert("Name must not have numbers");	
		frmEditInfo.name.focus();
		return false;
	}//
	if(HasSpace(strName) == true){
		alert("Name should not contain spaces");
		frmEditInfo.name.focus();
		return false
	}
	if(SplNameChar(strName) == true){
	    alert("Special charecters are not accepted in Name");	
	    frmEditInfo.name.focus();
	    return false;
	}

	/*if ( frmEditInfo.name.value == "" )
	{
		alert( "Please enter Name." );
		frmEditInfo.name.focus();
		return false;
	}*/

	if(frmEditInfo.age.value=="" && (frmEditInfo.dobMonth.options[frmEditInfo.dobMonth.selectedIndex].text=="-Month-" && frmEditInfo.dobDay.options[frmEditInfo.dobDay.selectedIndex].text=="-Date-" && frmEditInfo.dobYear.options[frmEditInfo.dobYear.selectedIndex].text=="-Year-")) 
	{
		alert("Enter Age or Select Date of Birth");
		frmEditInfo.age.focus();
		return false;
  	}

	if(frmEditInfo.age.value=="")
  	{ 
		if (frmEditInfo.dobMonth.options[frmEditInfo.dobMonth.selectedIndex].text=="-Month-")	
		{
			alert("Please select Month");
			frmEditInfo.dobMonth.focus();
			return false;
		}
		if (frmEditInfo.dobDay.options[frmEditInfo.dobDay.selectedIndex].text=="-DATE-")	
		{
			alert("Please select Date");
			frmEditInfo.dobDay.focus();
			return false;
		}
		if (frmEditInfo.dobYear.value=="0")		
		{
			alert("Please select Year");
			frmEditInfo.dobYear.focus();
			return false;
		}
	}	
	
	// Check Age
	if( !ValidateNo(frmEditInfo.age.value, "0123456789" ) )
	{
		alert("Please enter a valid Age");
		frmEditInfo.age.value="";
		frmEditInfo.age.focus();
		return false;
	}
	else
	{
		var age = parseInt( frmEditInfo.age.value );
		if ( age < 18 )
		{
			alert( "Sorry! You need to be at least 18 if you are a woman and 21 if you are a man to register. ");
			frmEditInfo.age.focus( );
			return false;
		}
		if ( age > 70 )
		{
			alert( "Sorry! You need to be at least 18 if you are a woman and 21 if you are a man to register. ");
			frmEditInfo.age.focus( );
			return false;
		}
	}

	var calyear = displayage(frmEditInfo.dobYear.value,frmEditInfo.dobMonth.value,frmEditInfo.dobDay.value, 'years', 0, 'rounddown')
			
	if (frmEditInfo.age.value<21 && frmEditInfo.gender[0].checked && !(frmEditInfo.age.value==""))
	{
		alert("You should be 21 years to register");
		frmEditInfo.age.focus();
		return false;
	}
			
	if (frmEditInfo.age.value=="" && calyear < 21 && frmEditInfo.gender[0].checked)
	{
		alert("You should be 21 years to register");
		frmEditInfo.age.focus();
		return false;
	}
							
	if (frmEditInfo.age.value < 18 && frmEditInfo.gender[1].checked && !(frmEditInfo.age.value==""))
	{
		alert("You should be 18 years to register");
		frmEditInfo.age.focus();
		return false;
	}
			
	if (frmEditInfo.age.value=="" && calyear < 18 && frmEditInfo.gender[1].checked)
	{
		alert("You should be 18 years to register");
		frmEditInfo.age.focus();
		return false;
	}	
	
	if ( frmEditInfo.maritalStatus.selectedIndex == 0 )
	{
		alert( "Please select Marital Status." );
		frmEditInfo.maritalStatus.focus() ;
		return false;
	}

	if ( frmEditInfo.maritalStatus.options[frmEditInfo.maritalStatus.selectedIndex].value > 1 && frmEditInfo.noOfChildren.selectedIndex == 0 )
	{
		alert( "Please select Number of Children" );
		frmEditInfo.noOfChildren.focus();
		return false;
	}			
		
	if ( frmEditInfo.maritalStatus.options[frmEditInfo.maritalStatus.selectedIndex].value > 1 && frmEditInfo.NOOFCHILDREN.options[frmEditInfo.NOOFCHILDREN.selectedIndex].value >= 1 && !frmEditInfo.childrenLivingWithMe[0].checked && !frmEditInfo.childrenLivingWithMe[1].checked)
	{
		alert("Please indicate whether the child /children is/are living with you.");
		frmEditInfo.childrenLivingWithMe[0].focus();
		return false;
	}
				
	if ( frmEditInfo.motherTongue.selectedIndex == 0 )
	{
		alert( "Please select Language" );
		frmEditInfo.motherTongue.focus();
		return false;
	}
		
	if ( frmEditInfo.religion.selectedIndex == 0 )
	{
		alert( "Please select Religion" );
		frmEditInfo.religion.focus( );
		return false;
	}
	
	if (!(frmEditInfo.subCaste.value==""))
	{
		if (frmEditInfo.casteDivision.value==0 || frmEditInfo.casteDivision.selectedIndex==0)
		{
			alert ("Please select your Caste");
			frmEditInfo.casteDivision.focus();
			return false;
		}
	}
	
	if (frmEditInfo.heightFeet.selectedIndex==0 && frmEditInfo.heightCms.selectedIndex==0)
	{
		alert ("Please select Height");
		frmEditInfo.heightFeet.focus();
		return false;
	}	
	
	
	if (IsEmpty(frmEditInfo.description,'textarea'))
	{
		alert ("Please enter About Myself");
		frmEditInfo.description.focus();
		return false;
	}
	
	if (!(IsEmpty(frmEditInfo.description,'textarea')))
	{
		var desc=frmEditInfo.description.value;
		if(desc.length<50)
		{
			alert ("Description must have at least 50 characters.");
			frmEditInfo.description.focus();
			return false;
		}
	}
	return true;				
}//Validate


var one_day=1000*60*60*24
var one_month=1000*60*60*24*30
var one_year=1000*60*60*24*30*12

function displayage(yr, mon, day, unit, decimal, round)
{
	today=new Date()
	var pastdate=new Date(yr, mon-1, day)
	var countunit=unit
	var decimals=decimal
	var rounding=round

	finalunit=(countunit=="days")? one_day : (countunit=="months")? one_month : one_year
	decimals=(decimals<=0)? 1 : decimals*10

	if (unit!="years")
	{
		if (rounding=="rounddown")
		alert (Math.floor((today.getTime()-pastdate.getTime())/(finalunit)*decimals)/decimals+' '+countunit)
		else
		alert (Math.ceil((today.getTime()-pastdate.getTime())/(finalunit)*decimals)/decimals+' '+countunit)
	}
	else
	{
		yearspast=today.getFullYear()-yr-1
		tail=(today.getMonth()>mon-1 || today.getMonth()==mon-1 && today.getDate()>=day)? 1 : 0
		pastdate.setFullYear(today.getFullYear())
		pastdate2=new Date(today.getFullYear()-1, mon-1, day)
		tail=(tail==1)? tail+Math.floor((today.getTime()-pastdate.getTime())/(finalunit)*decimals)/decimals : Math.floor((today.getTime()-pastdate2.getTime())/(finalunit)*decimals)/decimals
		var calyear=yearspast+tail;
	}
	return calyear;
}//displayage


//Date and Month Changes
function updateDay(change,formName,yearName,monthName,dayName)
{
	var form = document.forms[formName];
	var yearSelect = form[yearName];
	var monthSelect = form[monthName];
	var daySelect = form[dayName];
	var year = yearSelect[yearSelect.selectedIndex].value;
	var month = monthSelect[monthSelect.selectedIndex].value;
	var day = daySelect[daySelect.selectedIndex].value;

	if (change == 'month' || (change == 'year' && month == 2))
	{
		var i = 31;
		var flag = true;
		while(flag)
		{
			var date = new Date(year,month-1,i);
			if (date.getMonth() == month - 1)
			{ flag = false; }
			else
			{ i = i - 1; }
		}
		daySelect.length = 0;
		daySelect.length = i;
		var j = 0;
		while(j < i)
		{
			daySelect[j] = new Option(j+1,j+1);
			j = j + 1;
		}
		if (day <= i)
		{
			daySelect.selectedIndex = day - 1;
		}
		else
		{
			daySelect.selectedIndex = daySelect.length - 1;
		}
	}
}//updateDay


function IsEmpty(obj, obj_type)
{
	if (obj_type == "text" || obj_type == "password" || obj_type == "textarea" || obj_type == "file")
	{
		var objValue;
		objValue = obj.value.replace(/\s+$/,"");
		if (objValue.length == 0) {
			//obj.focus();
			return true;
		} else {
			return false;
		}
	} else if (obj_type == "select") {
		for (i=0; i < obj.length; i++) {
			if (obj.options[i].selected) {
				if(obj.options[i].value == "") {
					obj.focus();
					return true;
				} else {
					return false;
				}
			}
			
		}
		return true;	
	} else if (obj_type == "radio" || obj_type == "checkbox") {
		if (!obj[0] && obj) {
			if (obj.checked) {
				return false;
			} else {
				obj.focus();
				return true;	
			}
		} else {
			for (i=0; i < obj.length; i++) {
				if (obj[i].checked) {
					return false;
				}
			}
			obj[0].focus();
			return true;
		}
	} else {
		return false;
	}
}//IsEmpty


function ValidateEmail( Email )
{
	var atCharPresent = false;
	var dotPresent = false;

	for ( var Idx = 0; Idx < Email.length; Idx++ )
	{
		if ( Email.charAt ( Idx ) == '@' )
			atCharPresent = true;
		if ( Email.charAt ( Idx ) == '.' )
			dotPresent = true;
	}

	if ( !atCharPresent || !dotPresent )
		return false;

	return true;
}//ValidateEmail


function funShowAll()
{
	var funFrmName = document.frmEditProfile;
	funFrmName.maritalStatus[1].disabled=false;
	funFrmName.maritalStatus[2].disabled=false;
	funFrmName.maritalStatus[3].disabled=false;
	funFrmName.maritalStatus[4].disabled=false;
	
//No. of Children
	funFrmName.noOfChildren.disabled=false;

//Children Living Status
	funFrmName.childrenLivingWithMe[0].disabled=false;
	funFrmName.childrenLivingWithMe[1].disabled=false;
}//funHideUnMarried

function funShowUnMarried()
{
/*	var funFrmName = document.frmEditProfile;
	funFrmName.maritalStatus[1].checked=false;
	funFrmName.maritalStatus[1].disabled=true;

	funFrmName.maritalStatus[2].checked=false;
	funFrmName.maritalStatus[2].disabled=true;

	funFrmName.maritalStatus[3].checked=false;
	funFrmName.maritalStatus[3].disabled=true;

	funFrmName.maritalStatus[4].checked=false;
	funFrmName.maritalStatus[4].disabled=true;

	funFrmName.maritalStatus[5].checked=false;
	funFrmName.maritalStatus[5].disabled=true;

//No. of Children
	funFrmName.noOfChildren.value="";
	funFrmName.noOfChildren.disabled=true;

//Children Living Status
	funFrmName.childrenLivingWithMe[0].checked=false;
	funFrmName.childrenLivingWithMe[0].disabled=true;

	funFrmName.childrenLivingWithMe[1].checked=false;
	funFrmName.childrenLivingWithMe[1].disabled=true;
	*/
	var funFrmName = document.frmEditProfile;
	funFrmName.maritalStatus[1].disabled=false;
	funFrmName.maritalStatus[2].disabled=false;
	funFrmName.maritalStatus[3].disabled=false;
	funFrmName.maritalStatus[4].disabled=true;
	
//No. of Children
	funFrmName.noOfChildren.disabled=false;

//Children Living Status
	funFrmName.childrenLivingWithMe[0].disabled=false;
	funFrmName.childrenLivingWithMe[1].disabled=false;
}//funShowUnMarried

/*
function funShollAll()
{
	var funFrmName = document.frmEditProfile;
	funFrmName.maritalStatus[1].disabled=false;
	funFrmName.maritalStatus[2].disabled=false;
	funFrmName.maritalStatus[3].disabled=false;

//No. of Children
	funFrmName.noOfChildren.disabled=false;

//Children Living Status
	funFrmName.childrenLivingWithMe[0].disabled=false;
	funFrmName.childrenLivingWithMe[1].disabled=false;
}//funHideUnMarried

function funShowUnMarried()
{
	var funFrmName = document.frmEditProfile;
	funFrmName.maritalStatus[1].checked=false;
	funFrmName.maritalStatus[1].disabled=true;

	funFrmName.maritalStatus[2].checked=false;
	funFrmName.maritalStatus[2].disabled=true;

	funFrmName.maritalStatus[3].checked=false;
	funFrmName.maritalStatus[3].disabled=true;

//No. of Children
	funFrmName.noOfChildren.value="";
	funFrmName.noOfChildren.disabled=true;

//Children Living Status
	funFrmName.childrenLivingWithMe[0].checked=false;
	funFrmName.childrenLivingWithMe[0].disabled=true;

	funFrmName.childrenLivingWithMe[1].checked=false;
	funFrmName.childrenLivingWithMe[1].disabled=true;
}//funShowUnMarried*/

function fillSelectFromArray(selectCtrl, itemArray, goodPrompt, badPrompt, defaultItem)
{
	var divisionId = document.frmEditProfile.divisionId.value;
	var i, j;
	var prompt;
	// empty existing items
	for (i = selectCtrl.options.length; i >= 0; i--) {
	selectCtrl.options[i] = null; 
	}

	prompt = (itemArray != null) ? goodPrompt : badPrompt;
	if (prompt == null) {
	j = 0;
	}
	else {
		selectCtrl.options[0] = new Option(prompt);
		j = 1;
	}
	if (itemArray != null)
	{
		// add new items
		for (i = 0; i < itemArray.length; i++) {
			selectCtrl.options[j] = new Option(itemArray[i][0]);
			if (itemArray[i][1] != null)
			{
				if ((itemArray[i][1]==divisionId))
				{ selectCtrl.options[j].selected = true; }//if
				else { selectCtrl.options[j].value = itemArray[i][1]; }//else
			}
			j++;
		}//for
		// select first item (prompt) for sub list
	}
}//fillSelectFromArray


//******************************************** Check Username & Name Fields
function SplNameChar(txt){
	if(txt.length == 0)
		return false;
	for(var i = 0;i < txt.length;i++){
		if(txt.charAt(i) == '@' || txt.charAt(i) == '#' 
			|| txt.charAt(i) == '!' || txt.charAt(i) == '$' 
			|| txt.charAt(i) == '%' || txt.charAt(i) == '&' 
			|| txt.charAt(i) == '^' || txt.charAt(i) == '*' 
			|| txt.charAt(i) == '~' || txt.charAt(i) == '_' 
			|| txt.charAt(i) == '-' || txt.charAt(i) == '=' 
			|| txt.charAt(i) == '+' || txt.charAt(i) == '|' 
			|| txt.charAt(i) == '?' || txt.charAt(i) == '<' 
			|| txt.charAt(i) == '>' || txt.charAt(i) == '/' 
			|| txt.charAt(i) == '[' || txt.charAt(i) == ']' 
			|| txt.charAt(i) == '(' || txt.charAt(i) == ')' 
			|| txt.charAt(i) == '`' || txt.charAt(i) == "," 
			|| txt.charAt(i) == ":" || txt.charAt(i) == ";" 
			|| txt.charAt(i) == "{" 
			|| txt.charAt(i) == "}" || txt.charAt(i) == '"'
			|| txt.charAt(i) == '\\' )
			return true;
	}
	return false;
}//SplNameChar

function HasSpace(txt){		
	if(txt.length == 0)
		return false;
	for(var i = 0;i < txt.length;i++){
		if(txt.charAt(i) == " ")
			return true;
	}
	return false;
}//HasSpace

function nullchk(txt)
{
	if (txt == "" || txt == null)
	{ return true; }
		
	var i;
	for(i=0;i<txt.length;i++)
	{
		if (txt.charAt(i) != " ")
		return false
	}
	return true;
}//nullchk


function LTrim(value){
	var l,i,n,newvalue
	l = value.length //txt.charAt(i)
	for(i=0;i<l;i++){
		if(value.charAt(i) != " ")
			break;
	}
	newvalue="";
	for(n=i;n<l;n++)
		newvalue=newvalue+value.charAt(n)
	return newvalue;
}

function RTrim(value){
	var l,i,n,newvalue
	l = value.length //txt.charAt(i)
	for(i=l-1;i>=0;i--){
		if(value.charAt(i) != " ")
			break;
	}
	newvalue="";
	for(n=0;n<i;n++)
		newvalue=newvalue+value.charAt(n)
	return newvalue;
}

function IsNumberPresent(obj){
	if(obj.length == 0)
		return false;
	for(var i = 0;i < obj.length;i++){
		if(obj.charAt(i) >= '0' && obj.charAt(i) <= '9') 
			return true;
		else
			continue;
	}
	return false;
}//IsNumberPresent


residingcity = new Array(
new Array(
new Array("--Select Residing City--", ""),
new Array("Port Blair", "1"),
new Array("Andaman Nicobar", "2")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Hyderabad", "4"),
new Array("Adilabad", "5"),
new Array("Anantapur", "6"),
new Array("Chittoor", "7"),
new Array("Cuddapah", "8"),
new Array("Godavari", "9"),
new Array("Guntur", "10"),
new Array("Karimnagar", "11"),
new Array("Khammam", "12"),
new Array("Krishna", "13"),
new Array("Kurnool", "14"),
new Array("Mahbubnagar", "15"),
new Array("Medak", "16"),
new Array("Nalgonda", "17"),
new Array("Nellore", "18"),
new Array("Nizamabad", "19"),
new Array("Prakasam", "20"),
new Array("Rangareddi", "21"),
new Array("Srikakulam", "22"),
new Array("Visakhapatnam", "23"),
new Array("Vizianagaram", "24"),
new Array("Warangal", "25")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Itanagar", "27"),
new Array("Changlang", "28"),
new Array("Dibang Valley", "29"),
new Array("Kameng", "30"),
new Array("Kurung Kumey", "31"),
new Array("Lohit", "32"),
new Array("Subansiri", "33"),
new Array("Papum Pare", "34"),
new Array("Siang", "35"),
new Array("Tawang", "36"),
new Array("Tirap", "37")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Guwahati", "39"),
new Array("Barpeta", "40"),
new Array("Bongaigaon", "41"),
new Array("Cachar", "42"),
new Array("Darrang", "43"),
new Array("Dhemaji", "44"),
new Array("Dhubri", "45"),
new Array("Dibrugarh", "46"),
new Array("Goalpara", "47"),
new Array("Golaghat", "48"),
new Array("Hailakandi", "49"),
new Array("Jorhat", "50"),
new Array("Kamrup", "51"),
new Array("Karbi Anglong", "52"),
new Array("Karimganj", "53"),
new Array("Kokrajhar", "54"),
new Array("Lakhimpur", "55"),
new Array("Marigaon", "56"),
new Array("Nagaon", "57"),
new Array("Nalbari", "58"),
new Array("Sivasagar", "59"),
new Array("Sonitpur", "60"),
new Array("Tinsukia", "61")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Patna", "63"),
new Array("Araria", "64"),
new Array("Aurangabad", "65"),
new Array("Banka", "66"),
new Array("Begusarai", "67"),
new Array("Bhagalpur", "68"),
new Array("Bhojpur", "69"),
new Array("Buxar", "70"),
new Array("Champaran", "71"),
new Array("Darbhanga", "72"),
new Array("Gaya", "73"),
new Array("Gopalganj", "74"),
new Array("Jamui", "75"),
new Array("Jehanabad", "76"),
new Array("Kaimur (Bhabua)", "77"),
new Array("Katihar", "78"),
new Array("Khagaria", "79"),
new Array("Kishanganj", "80"),
new Array("Lakhisarai", "81"),
new Array("Madhepura", "82"),
new Array("Madhubani", "83"),
new Array("Munger", "84"),
new Array("Muzaffarpur", "85"),
new Array("Nalanda", "86"),
new Array("Nawada", "87"),
new Array("Purnia", "88"),
new Array("Rohtas", "89"),
new Array("Saharsa", "90"),
new Array("Samastipur", "91"),
new Array("Saran", "92"),
new Array("Sheikhpura", "93"),
new Array("Sheohar", "94"),
new Array("Sitamarhi", "95"),
new Array("Siwan", "96"),
new Array("Supaul", "97"),
new Array("Vaishali", "98")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Chandigarh", "100")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Raipur", "101"),
new Array("Bastar", "102"),
new Array("Bilaspur", "103"),
new Array("Dantewada", "104"),
new Array("Dhamtari", "105"),
new Array("Durg", "106"),
new Array("Janjgir-Champa", "107"),
new Array("Jashpur", "108"),
new Array("Kanker", "109"),
new Array("Kawardha", "110"),
new Array("Korba", "111"),
new Array("Koriya", "112"),
new Array("Mahasamund", "113"),
new Array("Raigarh", "114"),
new Array("Rajnandgaon", "115"),
new Array("Surguja", "116")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Silvassa", "118"),
new Array("Dadra and Nagar Haveli", "119")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Daman", "120"),
new Array("Daman and Diu", "121")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Delhi", "122")
),

new Array(
new Array("--Select Residing City--", "0"),
new Array("Panaji", "123"),
new Array("Goa", "124")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Gandhinagar", "125"),
new Array("Ahmedabad", "126"),
new Array("Amreli", "127"),
new Array("Anand", "128"),
new Array("Banas Kantha", "129"),
new Array("Bharuch", "130"),
new Array("Bhavnagar", "131"),
new Array("Dohad", "132"),
new Array("Jamnagar", "133"),
new Array("Junagadh", "134"),
new Array("Kachchh", "135"),
new Array("Kheda", "136"),
new Array("Mahesana", "137"),
new Array("Narmada", "138"),
new Array("Navsari", "139"),
new Array("Panch Mahals", "140"),
new Array("Patan", "141"),
new Array("Porbandar", "142"),
new Array("Rajkot", "143"),
new Array("Sabar Kantha", "144"),
new Array("Surat", "145"),
new Array("Surendranagar", "146"),
new Array("The Dangs", "147"),
new Array("Vadodara", "148"),
new Array("Valsad", "149")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Chandigarh", "100"),
new Array("Ambala", "151"),
new Array("Bhiwani", "152"),
new Array("Faridabad", "153"),
new Array("Fatehabad", "154"),
new Array("Gurgaon", "155"),
new Array("Hisar", "156"),
new Array("Jhajjar", "157"),
new Array("Jind", "158"),
new Array("Kaithal", "159"),
new Array("Karnal", "160"),
new Array("Kurukshetra", "161"),
new Array("Mahendragarh", "162"),
new Array("Panchkula", "163"),
new Array("Panipat", "164"),
new Array("Rewari", "165"),
new Array("Rohtak", "166"),
new Array("Sirsa", "167"),
new Array("Sonipat", "168"),
new Array("Yamunanagar", "169")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Shimla", "171"),
new Array("Bilaspur", "172"),
new Array("Chamba", "173"),
new Array("Hamirpur", "174"),
new Array("Kangra", "175"),
new Array("Kinnaur", "176"),
new Array("Kullu", "177"),
new Array("Lahaul & Spiti", "178"),
new Array("Mandi", "179"),
new Array("Sirmaur", "180"),
new Array("Solan", "181"),
new Array("Una", "182")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Jammu", "184"),
new Array("Srinagar", "185"),
new Array("Anantnag", "186"),
new Array("Baramulla", "187"),
new Array("Budgam", "188"),
new Array("Doda", "189"),
new Array("Kargil", "190"),
new Array("Kathua", "191"),
new Array("Kupwara", "192"),
new Array("Leh", "193"),
new Array("Poonch", "194"),
new Array("Pulwama", "195"),
new Array("Rajauri", "196"),
new Array("Udhampur", "197")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Ranchi", "199"),
new Array("Bokaro", "200"),
new Array("Chatra", "201"),
new Array("Deoghar", "202"),
new Array("Dhanbad", "203"),
new Array("Dumka", "204"),
new Array("Garhwa", "205"),
new Array("Giridih", "206"),
new Array("Godda", "207"),
new Array("Gumla", "208"),
new Array("Hazaribag", "209"),
new Array("Jamtara", "210"),
new Array("Koderma", "211"),
new Array("Latehar", "212"),
new Array("Lohardaga", "213"),
new Array("Pakur", "214"),
new Array("Palamu", "215"),
new Array("Sahibganj", "216"),
new Array("Seraikela", "217"),
new Array("Simdega", "218"),
new Array("Singhbhum", "219")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Bangalore", "221"),
new Array("Bagalkot", "222"),
new Array("Belgaum", "223"),
new Array("Bellary", "224"),
new Array("Bidar", "225"),
new Array("Bijapur", "226"),
new Array("Chamrajnagar", "227"),
new Array("Chickmagalur", "228"),
new Array("Chitradurga", "229"),
new Array("Davangere", "230"),
new Array("Dharwad", "231"),
new Array("Gadag", "232"),
new Array("Gulbarga", "233"),
new Array("Hassan", "234"),
new Array("Haveri", "235"),
new Array("Uttar Kannada", "236"),
new Array("Dakshin Kannada", "237"),
new Array("Kodagu", "238"),
new Array("Kolar", "239"),
new Array("Koppal", "240"),
new Array("Mandya", "241"),
new Array("Mysore", "242"),
new Array("Raichur", "243"),
new Array("Shimoga", "244"),
new Array("Tumkur", "245"),
new Array("Udupi", "246")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Thiruvananthapuram", "248"),
new Array("Alappuzha", "249"),
new Array("Ernakulam", "250"),
new Array("Idukki", "251"),
new Array("Kannur", "252"),
new Array("Kasargod", "253"),
new Array("Kollam", "254"),
new Array("Kottayam", "255"),
new Array("Kozhikode", "256"),
new Array("Malappuram", "257"),
new Array("Palakkad", "258"),
new Array("Pathanamthitta", "259"),
new Array("Thrissur", "260"),
new Array("Wayanad", "261")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Kavaratti", "263"),
new Array("Lakshadweep", "264")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Bhopal", "265"),
new Array("Anuppur", "266"),
new Array("Ashoknagar", "267"),
new Array("Balaghat", "268"),
new Array("Barwani", "269"),
new Array("Betul", "270"),
new Array("Bhind", "271"),
new Array("Burhanpur", "272"),
new Array("Chhatarpur", "273"),
new Array("Chhindwara", "274"),
new Array("Damoh", "275"),
new Array("Datia", "276"),
new Array("Dewas", "277"),
new Array("Dhar", "278"),
new Array("Dindori", "279"),
new Array("Guna", "280"),
new Array("Gwalior", "281"),
new Array("Harda", "282"),
new Array("Hoshangabad", "283"),
new Array("Indore", "284"),
new Array("Jabalpur", "285"),
new Array("Jhabua", "286"),
new Array("Katni", "287"),
new Array("Khandwa", "288"),
new Array("Khargone", "289"),
new Array("Mandla", "290"),
new Array("Mandsaur", "291"),
new Array("Morena", "292"),
new Array("Narsinghpur", "293"),
new Array("Neemuch", "294"),
new Array("Panna", "295"),
new Array("Raisen", "296"),
new Array("Rajgarh", "297"),
new Array("Ratlam", "298"),
new Array("Rewa", "299"),
new Array("Sagar", "300"),
new Array("Satna", "301"),
new Array("Sehore", "302"),
new Array("Seoni", "303"),
new Array("Shahdol", "304"),
new Array("Shajapur", "305"),
new Array("Sheopur", "306"),
new Array("Shivpuri", "307"),
new Array("Sidhi", "308"),
new Array("Tikamgarh", "309"),
new Array("Ujjain", "310"),
new Array("Umaria", "311"),
new Array("Vidisha", "312")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Mumbai", "314"),
new Array("Ahmednagar", "315"),
new Array("Akola", "316"),
new Array("Amravati", "317"),
new Array("Aurangabad", "318"),
new Array("Bandra Suburban", "319"),
new Array("Beed", "320"),
new Array("Bhandara", "321"),
new Array("Buldhana", "322"),
new Array("Chandrapur", "323"),
new Array("Dhule", "324"),
new Array("Gadchiroli", "325"),
new Array("Gondia", "326"),
new Array("Hingoli", "327"),
new Array("Jalgaon", "328"),
new Array("Jalna", "329"),
new Array("Kolhapur", "330"),
new Array("Latur", "331"),
new Array("Nagpur", "332"),
new Array("Nanded", "333"),
new Array("Nandurbar", "334"),
new Array("Nashik", "335"),
new Array("Osmanabad", "336"),
new Array("Parbhani", "337"),
new Array("Pune", "338"),
new Array("Raigarh", "339"),
new Array("Ratnagiri", "340"),
new Array("Sangli", "341"),
new Array("Satara", "342"),
new Array("Sindhudurg", "343"),
new Array("Solapur", "344"),
new Array("Thane", "345"),
new Array("Wardha", "346"),
new Array("Washim", "347"),
new Array("Yavatmal", "348")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Imphal", "350"),
new Array("Bishnupur", "351"),
new Array("Chandel", "352"),
new Array("Churachandpur", "353"),
new Array("Senapati", "354"),
new Array("Tamenglong", "355"),
new Array("Thoubal", "356"),
new Array("Ukhrul", "357")
),


new Array(
new Array("--Select Residing City--", ""),
new Array("Shillong", "359"),
new Array("Garo Hills", "360"),
new Array("Jaintia Hills", "361"),
new Array("Khasi Hills", "362"),
new Array("Ri Bhoi", "363")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Aizawl", "365"),
new Array("Champhai", "366"),
new Array("Kolasib", "367"),
new Array("Lawngtlai", "368"),
new Array("Lunglei", "369"),
new Array("Mamit", "370"),
new Array("Saiha", "371"),
new Array("Serchhip", "372")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Kohima", "374"),
new Array("Dimapur", "375"),
new Array("Mokokchung", "376"),
new Array("Mon", "377"),
new Array("Phek", "378"),
new Array("Tuensang", "379"),
new Array("Wokha", "380"),
new Array("Zunheboto", "381")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Bhubaneshwar", "383"),
new Array("Angul", "384"),
new Array("Balangir", "385"),
new Array("Baleswar", "386"),
new Array("Bargarh", "387"),
new Array("Bhadrak", "388"),
new Array("Boudh", "389"),
new Array("Cuttack", "390"),
new Array("Debagarh", "391"),
new Array("Dhenkanal", "392"),
new Array("Gajapati", "393"),
new Array("Ganjam", "394"),
new Array("Jagatsinghapur", "395"),
new Array("Jajapur", "396"),
new Array("Jharsuguda", "397"),
new Array("Kalahandi", "398"),
new Array("Kandhamal", "399"),
new Array("Kendrapara", "400"),
new Array("Kendujhar", "401"),
new Array("Khordha", "402"),
new Array("Koraput", "403"),
new Array("Malkangiri", "404"),
new Array("Mayurbhanj", "405"),
new Array("Nabarangapur", "406"),
new Array("Nayagarh", "407"),
new Array("Nuapada", "408"),
new Array("Puri", "409"),
new Array("Rayagada", "410"),
new Array("Sambalpur", "411"),
new Array("Sonapur", "412"),
new Array("Sundergarh", "413")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Pondicherry", "415"),
new Array("Karaikal", "416"),
new Array("Mahe", "417"),
new Array("Yanam", "418")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Chandigarh", "100"),
new Array("Amritsar", "419"),
new Array("Bathinda", "420"),
new Array("Faridkot", "421"),
new Array("Fatehgarh Sahib", "422"),
new Array("Firozpur", "423"),
new Array("Gurdaspur", "424"),
new Array("Hoshiarpur", "425"),
new Array("Jalandhar", "426"),
new Array("Kapurthala", "427"),
new Array("Ludhiana", "428"),
new Array("Mansa", "429"),
new Array("Moga", "430"),
new Array("Muktsar", "431"),
new Array("Nawanshahr", "432"),
new Array("Patiala", "433"),
new Array("Rupnagar", "434"),
new Array("Sangrur", "435")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Jaipur", "437"),
new Array("Ajmer", "438"),
new Array("Alwar", "439"),
new Array("Banswara", "440"),
new Array("Baran", "441"),
new Array("Barmer", "442"),
new Array("Bharatpur", "443"),
new Array("Bhilwara", "444"),
new Array("Bikaner", "445"),
new Array("Bundi", "446"),
new Array("Chittorgarh", "447"),
new Array("Churu", "448"),
new Array("Dausa", "449"),
new Array("Dholpur", "450"),
new Array("Dungarpur", "451"),
new Array("Ganganagar", "452"),
new Array("Hanumangarh", "453"),
new Array("Jaisalmer", "454"),
new Array("Jalor", "455"),
new Array("Jhalawar", "456"),
new Array("Jhunjhunu", "457"),
new Array("Jodhpur", "458"),
new Array("Karauli", "459"),
new Array("Kota", "460"),
new Array("Nagaur", "461"),
new Array("Pali", "462"),
new Array("Rajsamand", "463"),
new Array("Sawai Madhopur", "464"),
new Array("Sikar", "465"),
new Array("Sirohi", "466"),
new Array("Tonk", "467"),
new Array("Udaipur", "468")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Gangtok", "470"),
new Array("Sikkim", "471")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Chennai", "472"),
new Array("Coimbatore", "473"),
new Array("Cuddalore", "474"),
new Array("Dharmapuri", "475"),
new Array("Dindigul", "476"),
new Array("Erode", "477"),
new Array("Kanchipuram", "478"),
new Array("Kanyakumari", "479"),
new Array("Karur", "480"),
new Array("Krishnagiri", "481"),
new Array("Madurai", "482"),
new Array("Nagapattinam", "483"),
new Array("Namakkal", "484"),
new Array("Nilgiris", "485"),
new Array("Perambalur", "486"),
new Array("Pudukkottai", "487"),
new Array("Ramanathapuram", "488"),
new Array("Salem", "489"),
new Array("Sivaganga", "490"),
new Array("Thanjavur", "491"),
new Array("Theni", "492"),
new Array("Thoothukudi", "493"),
new Array("Tiruchirappalli", "494"),
new Array("Tirunelveli", "495"),
new Array("Tiruvallur", "496"),
new Array("Tiruvannamalai", "497"),
new Array("Tiruvarur", "498"),
new Array("Vellore", "499"),
new Array("Viluppuram", "500"),
new Array("Virudhunagar", "501")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Agartala", "503"),
new Array("Dhalai", "504"),
new Array("Tripura", "505")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Lucknow", "506"),
new Array("Agra", "507"),
new Array("Aligarh", "508"),
new Array("Allahabad", "509"),
new Array("Ambedkar Nagar", "510"),
new Array("Auraiya", "511"),
new Array("Azamgarh", "512"),
new Array("Bagpat", "513"),
new Array("Bahraich", "514"),
new Array("Ballia", "515"),
new Array("Balrampur", "516"),
new Array("Banda", "517"),
new Array("Barabanki", "518"),
new Array("Bareilly", "519"),
new Array("Basti", "520"),
new Array("Bijnor", "521"),
new Array("Budaun", "522"),
new Array("Bulandshahr", "523"),
new Array("Chandauli", "524"),
new Array("Chitrakoot", "525"),
new Array("Deoria", "526"),
new Array("Etah", "527"),
new Array("Etawah", "528"),
new Array("Faizabad", "529"),
new Array("Farrukhabad", "530"),
new Array("Fatehpur", "531"),
new Array("Firozabad", "532"),
new Array("Gautam Buddha Nagar", "533"),
new Array("Ghaziabad", "534"),
new Array("Ghazipur", "535"),
new Array("Gonda", "536"),
new Array("Gorakhpur", "537"),
new Array("Hamirpur", "538"),
new Array("Hardoi", "539"),
new Array("Hathras", "540"),
new Array("Jalaun", "541"),
new Array("Jaunpur", "542"),
new Array("Jhansi", "543"),
new Array("Jyotiba Phule Nagar", "544"),
new Array("Kannauj", "545"),
new Array("Kanpur Dehat", "546"),
new Array("Kanpur Nagar", "547"),
new Array("Kaushambi", "548"),
new Array("Kheri", "549"),
new Array("Kushinagar", "550"),
new Array("Lalitpur", "551"),
new Array("Maharajganj", "552"),
new Array("Mahoba", "553"),
new Array("Mainpuri", "554"),
new Array("Mathura", "555"),
new Array("Mau", "556"),
new Array("Meerut", "557"),
new Array("Mirzapur", "558"),
new Array("Moradabad", "559"),
new Array("Muzaffarnagar", "560"),
new Array("Pilibhit", "561"),
new Array("Pratapgarh", "562"),
new Array("RaeBareli", "563"),
new Array("Rampur", "564"),
new Array("Saharanpur", "565"),
new Array("Sant Kabir Nagar", "566"),
new Array("Sant Ravidas Nagar", "567"),
new Array("Sahanpur", "568"),
new Array("Shrawasti", "569"),
new Array("Siddharthnagar", "570"),
new Array("Sitapur", "571"),
new Array("Sonbhadra", "572"),
new Array("Sultanpur", "573"),
new Array("Unnao", "574"),
new Array("Varanasi", "575")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Dehradun", "577"),
new Array("Almora", "578"),
new Array("Bageshwar", "579"),
new Array("Chamoli", "580"),
new Array("Champawat", "581"),
new Array("Haridwar", "582"),
new Array("Nainital", "583"),
new Array("Pauri Garhwal", "584"),
new Array("Pithoragarh", "585"),
new Array("Rudraprayag", "586"),
new Array("Tehri Garhwal", "587"),
new Array("Udham Singh Nagar", "588"),
new Array("Uttarkashi", "589")
),

new Array(
new Array("--Select Residing City--", ""),
new Array("Kolkata", "591"),
new Array("24 Parganas", "592"),
new Array("Bankura", "593"),
new Array("Bardhaman", "594"),
new Array("Birbhum", "595"),
new Array("Cooch Behar", "596"),
new Array("Darjiling", "597"),
new Array("Dinajpur", "598"),
new Array("Hooghly", "599"),
new Array("Howrah", "600"),
new Array("Jalpaiguri", "601"),
new Array("Malda", "602"),
new Array("Midnapore", "602"),
new Array("Murshidabad", "603"),
new Array("Nadia", "604"),
new Array("Puruliya", "605")
),

null,
new Array(
new Array("", "")
)
);

function funResidingArea(itemArray,argCityID)
{
	var funCityName = '';
	for (i=0; i<itemArray.length; i++)
	{
		if (itemArray[i][1]==argCityID)
		{
			funCityName = itemArray[i][0];
			break;
		}//if
	}
	var funResidingId = document.getElementById("residingAreaId");
	funResidingId.innerHTML=funCityName;
}//funResidingArea

function fillSelectCityFromArray(selectCtrl, itemArray, goodPrompt, badPrompt, defaultItem)

{
	var i, j;
	var prompt;
	var selectedCity	= document.frmEditProfile.city.value;

	// empty existing items
	for (i = selectCtrl.options.length; i >= 0; i--) {
	selectCtrl.options[i] = null; 
	}

	prompt = (itemArray != null) ? goodPrompt : badPrompt;
	if (prompt == null) {
	j = 0;
	}
	else {
		selectCtrl.options[0] = new Option(prompt);
		j = 1;
	}
	if (itemArray != null)
	{
		// add new items
		for (i = 0; i < itemArray.length; i++) {
			selectCtrl.options[j] = new Option(itemArray[i][0]);
			if (itemArray[i][1] != null)
			{
				if ((itemArray[i][1]==selectedCity))
				{ selectCtrl.options[j].selected = true; }//if
				else { selectCtrl.options[j].value = itemArray[i][1]; }//else
			}//if
			j++;
		}
		// select first item (prompt) for sub list
	}
}//fillSelectFromArray

function Validate()
{
	var frmEditLocation = this.document.frmEditProfile;
	if ( parseInt( frmEditLocation.citizenship.options[frmEditLocation.citizenship.selectedIndex].value ) == 0 )
	{
		alert( "Please select Citizenship." );
		frmEditLocation.citizenship.focus( );
		return false;
	}

	if (IsEmpty(frmEditLocation.residentStatus,'radio'))
	{
		alert( "Please select Resident Status");
		frmEditLocation.residentStatus[0].focus( );
		return false;
	}
		
	if (frmEditLocation.residingState.selectedIndex==0 || IsEmpty(document.frmEditLocation.residingState,'text'))
	{
		alert ("Please select / enter Residing State");
		frmEditLocation.residingState.focus();
		return false;
	}


	if (frmEditLocation.residingCity.selectedIndex==0 || IsEmpty(document.frmEditLocation.residingCity,'text'))
	{
		alert ("Please select / enter Residing City");
		frmEditLocation.residingCity.focus();
		return false;
	}
}


function IsEmpty(obj, obj_type)
{
	if (obj_type == "text" || obj_type == "password" || obj_type == "textarea" || obj_type == "file")
	{
		var objValue;
		objValue = obj.value.replace(/\s+$/,"");
	
		if (objValue.length == 0) {
			//obj.focus();
			return true;
		} else {
			return false;
		}
	} else if (obj_type == "select") {
		for (i=0; i < obj.length; i++) {
			if (obj.options[i].selected) {
				if(obj.options[i].value == "") {
					obj.focus();
					return true;
				} else {
					return false;
				}
			}
			
		}
		return true;	
	} else if (obj_type == "radio" || obj_type == "checkbox") {
		if (!obj[0] && obj) {
			if (obj.checked) {
				return false;
			} else {
				obj.focus();
				return true;	
			}
		} else {
			for (i=0; i < obj.length; i++) {
				if (obj[i].checked) {
					return false;
				}
			}
			obj[0].focus();
			return true;
		}
	} else {
		return false;
	}
}


function funResidentStatus()
{
	var funFormName = document.frmEditProfile;
	var funCountryId = funFormName.country.value;
	var funCitizenId = funFormName.citizenship.value;
	if (funCountryId==funCitizenId)
	{
		funFormName.residentStatus[1].checked=true;
	}
	else
	{
		funFormName.residentStatus[1].checked=false;
	}
	if 	(funFormName.citizenship.value=='98')
		document.getElementById('caste').disabled=false;
	else
		document.getElementById('caste').disabled=true;

}//funResidentStatus

function funDoNextAdmin(argPgNum)
{
	document.frmAdmin.page.value = argPgNum;
	document.frmAdmin.submit();
}//funDoNextAdvanced

function funProfileValidate()
{
	var funFormName = document.frmEditProfile;
	if (funFormName.name.value=="")
	{
		alert("Please enter name");
		funFormName.name.focus();
		return false;
	}
	return true;
}//funProfileValidate

//Photo Gender Form submit
function funGenderSubmit()
{
	var funFormName = document.frmGender;
	funFormName.submit();
}//funGenderSubmit

//view-forum-question
function validateForumQuestion()
{
	var regExpVal;
	var frmName = window.document.frmViewQuestion;
	if(frmName.category.value == '0')
	{
		alert("Please select any Category.");
		frmName.category.focus();
		return false;
	}
	if(frmName.questionId.value == '')
	{
		alert("Please type Question Id.");
		frmName.questionId.focus();
		return false;
	}
	return true;
}

//Validate question
function validateQuestion()
{
	if(document.frmQuestionModify.question.value == '')
	{
		alert("Please type question.");
		document.frmQuestionModify.question.focus();
	}
	else
	{
		document.frmQuestionModify.submit();
	}
}
//Delete question
function deleteQuestion()
{
	val = confirm('Are you sure want to delete this question?');
	
	if(val == true)
	{
		document.frmQuestionModify.send.value = 'Delete';
		document.frmQuestionModify.submit();
	}
}
function validateAnswer(frmName)
{
	if(frmName.answer.value == '')
	{
		alert("Please type Answer.");
		frmName.answer.focus();
	}
	else
	{
		frmName.submit();
	}
}

function deleteAnswer(frmName)
{
	val = confirm('Are you sure want to delete this answer?');

	if(val == true)
	{
		frmName.send.value = 'Delete';
		frmName.submit();
	}
}