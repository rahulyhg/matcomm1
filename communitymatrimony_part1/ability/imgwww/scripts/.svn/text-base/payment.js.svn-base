function funDoorStep() {
	var frm = this.document.doorStep;

	if (document.doorStep.category.options[document.doorStep.category.selectedIndex].value==0){
		$('categoryspan').innerHTML="Please select Category";
		frm.category.focus();
		return false;
	} else { $('categoryspan').innerHTML=""; }

	if(IsEmpty(frm.name,"text")) {
	$('namespan').innerHTML="Please enter bride / groom name";
	frm.name.value='';
	frm.name.focus();
	return false;
	} else { $('namespan').innerHTML=""; }

	if (document.doorStep.city.options[document.doorStep.city.selectedIndex].value==0){
	$('cityspan').innerHTML="Please select city";
	frm.city.focus();
	return false;
	} else { $('cityspan').innerHTML=""; }

	if(IsEmpty(frm.contactPerson,"text")) {
	$('conpersonspan').innerHTML="Please enter contact person name";
	frm.contactPerson.focus();
	return false;
	} else { $('conpersonspan').innerHTML=""; }

	if(IsEmpty(frm.contactNumber,"text")) {
	$('connumberspan').innerHTML="Please enter the contact phone number";
	frm.contactNumber.focus();
	return false;
	} else { $('connumberspan').innerHTML=""; }

	if(IsEmpty(frm.fromTime,"text") && IsEmpty(frm.toTime,"text") ) {
	$('fromspan').innerHTML="Please enter a convenient time";
	frm.fromTime.focus();
	return false;
	} else { $('fromspan').innerHTML=""; }

	if(IsEmpty(frm.fromTime,"text")) {
	$('fromspan').innerHTML="Please enter the From contact time";
	frm.fromTime.focus();
	return false;
	} else { $('fromspan').innerHTML=""; }

	if(IsEmpty(frm.toTime,"text")) {
	$('fromspan').innerHTML="Please enter the To contact time";
	frm.toTime.focus();
	return false;
	} else { $('fromspan').innerHTML=""; }

	if(IsEmpty(frm.email,"text")) {
	$('emailspan').innerHTML="Please enter the E-mail";
	frm.email.focus();
	return false;
	} else { $('emailspan').innerHTML=""; }


	return true;

}//funDoorStep

function funCategory(){

	var frm = this.document.doorStep;
	if (document.doorStep.category.options[document.doorStep.category.selectedIndex].value==0){
		$('categoryspan').innerHTML="Please select Category";
		frm.category.focus();
		return false;
	} else { $('categoryspan').innerHTML=""; }
}

function funName(){
	var frm = this.document.doorStep;
	if(IsEmpty(frm.name,"text")) {
	$('namespan').innerHTML="Please enter bride / groom name";
	frm.name.value='';
	frm	.name.focus();
	return false;
	} else { $('namespan').innerHTML=""; }
}

function funCity() {
	if (document.doorStep.city.options[document.doorStep.city.selectedIndex].value==0){
	$('cityspan').innerHTML="Please select city";
	return false;
	} else { $('cityspan').innerHTML=""; }
}

function funPerson() {
	var frm = this.document.doorStep;
	if(IsEmpty(frm.contactPerson,"text")) {
	$('conpersonspan').innerHTML="Please enter contact person name";
	return false;
	} else { $('conpersonspan').innerHTML=""; }
}

function funConNumber() {
	var frm = this.document.doorStep;
	if(IsEmpty(frm.contactNumber,"text")) {
	$('connumberspan').innerHTML="Please enter the contact phone number";
	return false;
	} else { $('connumberspan').innerHTML=""; }
}

function funConTime() {
	var frm = this.document.doorStep;
	if(IsEmpty(frm.fromTime,"text") && IsEmpty(frm.toTime,"text") ) {
	$('fromspan').innerHTML="Please enter a convenient time";
	return false;
	} else { $('fromspan').innerHTML=""; }


	if(IsEmpty(frm.fromTime,"text")) {
	$('fromspan').innerHTML="Please enter the From contact time";
	return false;
	} else { $('fromspan').innerHTML=""; }


	if(IsEmpty(frm.toTime,"text")) {
	$('fromspan').innerHTML="Please enter the To contact time";
	return false;
	} else { $('fromspan').innerHTML=""; }


}

function funEmail() {
	var frm = this.document.doorStep;
	if(IsEmpty(frm.email,"text")) {
	$('emailspan').innerHTML="Please enter the E-mail";
	return false;
	} else { $('emailspan').innerHTML=""; }
}


/*
Please select Category
Please enter Bride/Groom Name
Please select City
Please enter contact person name
Please enter the contact phone number

Please enter valid phone number

Please enter a convenient time

Please enter a convenient time
Please enter a convenient time


Please enter the E-mail*/