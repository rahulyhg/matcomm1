function cbsRegisterValidate() {

var frmRegister = this.document.frmRegister;

if (parseInt(document.frmRegister.religionfeature.value)==1 && parseInt(document.frmRegister.religionOption.value)>1 ) {
	if (parseInt(document.frmRegister.religion.options[document.frmRegister.religion.selectedIndex].value)== 0) {
		document.getElementById('religionspan').innerHTML="Select the religion of the prospect";
		document.frmRegister.religion.focus();return false;
	} else { document.getElementById('religionspan').innerHTML=''; }

}

if (parseInt(frmRegister.denominationfeature.value)==1 && parseInt(frmRegister.denominationOption.value)>1 ) {
	if (parseInt(frmRegister.denomination.options[frmRegister.denomination.selectedIndex].value)== 0) {
		document.getElementById('denominationspan').innerHTML="Select the "+frmRegister.denominationlabel.value+" of the prospect";
		document.frmRegister.denomination.focus();return false;
	} else {
		document.getElementById('denominationspan').innerHTML='';
	}
}

if (parseInt(document.frmRegister.castefeature.value)==1 && document.frmRegister.castemandatory.value==1) {

	if (parseInt(document.frmRegister.casteOption.value)==1) {} else {
		
		if (parseInt(document.frmRegister.casteOption.value)>1) {

			if (parseInt(document.frmRegister.caste.options[document.frmRegister.caste.selectedIndex].value)== 0) {
			document.getElementById('castespan').innerHTML="Select the "+document.frmRegister.castelabel.value+" of the prospect";
			document.frmRegister.caste.focus();
			return false;
			} else { document.getElementById('castespan').innerHTML=''; }

		} else {
			var validateSubCaste = 'yes';

			if (document.frmRegister.communityId.value=='2001') {
				var religionId	= document.frmRegister.religion.options[document.frmRegister.religion.selectedIndex].value;
				if ((religionId=='7') || (religionId=='8') || (religionId=='9')) { validateSubCaste = 'no'; }
			}

			if (validateSubCaste=='yes') {
				if (IsEmpty(document.frmRegister.casteText,'text')) {
					document.getElementById('castespan').innerHTML="Enter the "+document.frmRegister.castelabel.value+" of the prospect";
					document.frmRegister.casteText.focus();
					return false;
				} else { document.getElementById('castespan').innerHTML=''; }
			}
		}
	}
}

if (parseInt(document.frmRegister.subcastefeature.value)==1 && document.frmRegister.subcastemandatory.value==1) { 
	if (parseInt(document.frmRegister.subCasteOption.value)==1) { } else {
		if (parseInt(document.frmRegister.subCasteOption.value)>1) { 
			var subCasteId = parseInt(document.frmRegister.subCaste.options[document.frmRegister.subCaste.selectedIndex].value);
			document.getElementById("subCasteDivText").style.display="none";
			if (subCasteId== 0) {
				document.getElementById("subCasteDivText").style.display="none";
				document.getElementById('subcastespan').innerHTML="Select the "+document.frmRegister.subcastelabel.value+" of the prospect";
				document.frmRegister.subCaste.focus();return false;
			} else if (subCasteId==9997) {
				document.getElementById("subCasteDivText").style.display="block";
				if (document.frmRegister.subCasteOthers.value=="") {
					document.getElementById('subcastespan').innerHTML="Enter the "+document.frmRegister.subcastelabel.value+" of the prospect";
					document.frmRegister.subCasteOthers.focus();return false;
				} else { document.getElementById('subcastespan').innerHTML=''; }
			} else { document.getElementById('subcastespan').innerHTML=''; }

		} else {

			if (document.frmRegister.subCasteText.value=="") { 
				document.getElementById('subcastespan').innerHTML="Enter the "+document.frmRegister.subcastelabel.value+" of the prospect";
				document.frmRegister.subCasteText.focus();return false;
			} else { document.getElementById('subcastespan').innerHTML=''; }

		}
	}
}

if (parseInt(document.frmRegister.gothramfeature.value)==1) {
	if (parseInt(document.frmRegister.gothramOption.value)>1) {
		var gothramId = parseInt(document.frmRegister.gothram.options[document.frmRegister.gothram.selectedIndex].value);
		if (gothramId== 0) {
			document.getElementById("gothramDivText").style.display="none";
			document.getElementById('gothraspan').innerHTML="Select the gothram of the prospect";
			document.frmRegister.gothram.focus();return false;
		} else if (gothramId==9997) {
			document.getElementById("gothramDivText").style.display="block";
			if (document.frmRegister.gothramOthers.value=="") {
				document.getElementById('gothraspan').innerHTML="Enter the gothram of the prospect";
				document.frmRegister.gothramOthers.focus();return false;
			} else { document.getElementById('gothraspan').innerHTML=''; }
		} else { document.getElementById('gothraspan').innerHTML=''; }
	}
}
return true;
}