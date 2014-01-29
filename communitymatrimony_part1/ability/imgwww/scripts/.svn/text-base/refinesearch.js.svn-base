var Jsg_coll=varConfArr['domainimgs']+"/hob-plus-icon.gif";
var Jsg_exp=varConfArr['domainimgs']+"/hob-minus-icon.gif";	
function refineSrch() {
	var sf=document.refineForm, stAge=0, endAge=0, minage='';
	stAge=sf.ageFrom.value; endAge=sf.ageTo.value; gender=sf.gender.value;
	(gender==2) ? minage=18 : minage=21;
	var FINALAGE=parseInt(endAge)-parseInt(stAge);
	if(!validateAge(sf,'refine_ageerr',sf.gender.value)) { return false; }
	if(!validateHeight(sf,'refine_heighterr')) { return false; }
	convert_chkboxes_values();
	$('prevnext').innerHTML=""; $('prevnext1').innerHTML="";
	$BN('div_C','n');$BN('div_O','n');$BN('div_E','n');
	$('C').src=Jsg_coll;$('O').src=Jsg_coll; $('E').src=Jsg_coll; 
	Jsg_c_pro=0;
	sf.submit();
	return true;
}
function validateAge(sf,did,gen) {
	var minage=0;
	stAge=sf.ageFrom.value;
	endAge=sf.ageTo.value;	
	if(gen!="" && gen!="undefined" && gen!=undefined) {
		var gender=gen;
	} else {
		for(var i=0;i<2;i++){
			if(sf.gender[i].checked==true) { var gender=sf.gender[i].value;  }
		}
	}
	(gender==2) ? minage=18 : minage=21;		
	var FINALAGE=parseInt(endAge)-parseInt(stAge);
	$BN(did,'b');
	if(IsEmpty(sf.ageFrom,"text")) {
		$(did).innerHTML="Please enter the age range.";
		sf.ageFrom.focus();
		return false;
	} else if(!(CompareValue(sf.ageFrom.value,"0123456789"))) {
		$(did).innerHTML="Sorry, Invalid Age "+stAge+".";
		sf.ageFrom.focus();
		return false;
	} else if(IsEmpty(sf.ageTo, "text")) {
		$(did).innerHTML="Please enter the age range.";
		sf.ageTo.focus();
		return false;
	}  else if(!(CompareValue(sf.ageTo.value,"0123456789"))) {
		$(did).innerHTML="Sorry, Invalid Age "+endAge+".";
		//sf.ageTo.focus();
		return false;
	} else if(stAge!=0 && endAge<stAge) {
		$(did).innerHTML="Sorry, Invalid age range. "+stAge+" to "+endAge+".";
		//sf.ageFrom.focus();
		return false;
	} else if(stAge < minage || stAge > 70) {
		$(did).innerHTML= "Sorry, invalid age "+stAge+" (Min. age is "+minage+". Max. age is 70)." ;
		//sf.ageFrom.focus();
		return false;
	} else if(parseInt(endAge)<18 || parseInt(endAge)>70) {
		$(did).innerHTML="Sorry, invalid age "+endAge+" (Min. age is "+minage+". Max. age is 70).";	
		//sf.ageFrom.focus();
		return false;
	} else if(parseInt(FINALAGE)>22) {
		$(did).innerHTML="The difference between a partner's \"From\" and \"To\" age should not exceed 22 years.";
		//sf.ageTo.focus();
		return false;	
	} else {
		$BN(did,'n');
		$(did).innerHTML="&nbsp;";
		return true;
	}	
}
function validateHeight(sf,did) {
	if (sf.heightTo.selectedIndex  < sf.heightFrom.selectedIndex) {	
		$BN(did,'b');
		$(did).innerHTML="Sorry, invalid height range.";
		sf.heightTo.focus();
		return false;
	} else { $BN(did,'n');return true; }
}
function refineblocking(tag,im) {
	var state=$(tag).style.display;
	if(state=="block") { $(im).src=Jsg_coll; $(tag).style.display="none"; } 
	else { $(im).src=Jsg_exp;$(tag).style.display="block";$(tag).style.zIndex="10"; }
}
function convert_chkboxes_values() {
	var sf=document.refineForm;
	//document.refineForm.horoscopeOpt.value=1;
	document.refineForm.photoOpt.value=1;
	sf.education.value=check_box_value(sf.EDUCATION_cb);
	sf.occupation.value=check_box_value(sf.OCCUPATION_cb);
	sf.country.value=check_box_value(sf.COUNTRY_cb);
}
function getCheckedValue(radioObj) {
	if(!radioObj) return "";
	var radioLength=radioObj.length;
	if(radioLength==undefined)
	if(radioObj.checked) return radioObj.value; else return "";
	for(var i=0;i<radioLength;i++) { if(radioObj[i].checked) { return radioObj[i].value; } } return "";
}
function check_box_value(fieldname) {
	var total="";
	if(fieldname!=undefined && fieldname!="undefined") {
		for(var i=0;i<fieldname.length;i++) { if(fieldname[i].checked) total +=fieldname[i].value + "~"; } 
		if(total=="undefined" || total==undefined) total="";
		return total;
	}
}
function showslide(s1,s2,s3,im1,im2,im3) {
	var state=$(s1).style.display;
	if(state=="none") { 
		$BN(s1,'b'); $BN(s2,'n'); $BN(s3,'n');
		$(im1).src=Jsg_exp;
		$(im2).src=Jsg_coll; $(im3).src=Jsg_coll;
	} else {
		$BN(s1,'n'); $BN(s2,'n'); $BN(s3,'n');
		$(im1).src=Jsg_coll;
		$(im2).src=Jsg_coll; $(im3).src=Jsg_coll;
	}
}
function showslideforkey(s1,s2,s3,s4,im1,im2,im3,im4) {
	var state=$(s1).style.display;
	if(state=="none") { 
		$BN(s1,'b'); $BN(s2,'n'); $BN(s3,'n');$BN(s4,'n');
		$(im1).src=Jsg_exp;
		$(im2).src=Jsg_coll; $(im3).src=Jsg_coll;$(im4).src=Jsg_coll;
	} else {
		$BN(s1,'n'); $BN(s2,'n'); $BN(s3,'n');$BN(s4,'n');
		$(im1).src=Jsg_coll;
		$(im2).src=Jsg_coll; $(im3).src=Jsg_coll;$(im4).src=Jsg_coll;
	}
}
function chkbox(name) { var chk_type=$(name); if(chk_type.checked==true) { chk_type.checked=false; } else { chk_type.checked=true; }}
