function checkBoxIds(frm, idname) { 
	var cval=0;
	var selectval = '';
	for(i=0;i<frm.length;i++) { 
		if(frm.elements[i].type=='checkbox' && frm.elements[i].name==idname) { 
			if(frm.elements[i].checked) {
				selectval = frm.elements[i].value+'~';
				cval++;
			} 
		} 
	} 

	return selectval; 
}

function abilityValidation(frmname) {
	var disabiltyTypeIds='',productTypeIds='',Len=0,signLang=0,severity=0;
	var disabiltyTypeArr = new Array();
	formname = eval('document.'+frmname);

	if(IsEmpty(formname.physicalStatus,'radio')){
		document.getElementById('physicalspan').innerHTML="Select physical status of the prospect";
		formname.physicalStatus[0].focus();
		return false;
	} else { document.getElementById('physicalspan').innerHTML=""; }

	if(formname.physicalStatus[1].checked==true) {
		/*if(formname.disabilitycause.selectedIndex==0) {
			document.getElementById('causespan').innerHTML="Select cause of disability of the prospect";
			formname.disabilitycause.focus();
			return false;
		} else { document.getElementById('causespan').innerHTML=""; }*/

		disabiltyTypeIds = checkBoxIds(formname,'disabilitytype[]');
		/*if(disabiltyTypeIds == '') {
			document.getElementById('distypespan').innerHTML="Select the disabilty type of the prospect";
			formname.disabilitytype[0].focus();
			return false;
		} else {
			document.getElementById('distypespan').innerHTML="";*/
			disabiltyTypeArr = disabiltyTypeIds.split('~');
			Len		 = disabiltyTypeArr.length;
			for(var i=0;i<Len;i++) {
				if(disabiltyTypeArr[i] == 2 || disabiltyTypeArr[i] == 3 || disabiltyTypeArr[i] == 4) {
					severity=1;
				}
				if(disabiltyTypeArr[i] == 4) {
					signLang=1;
				}
			}
		//}

		if(signLang==1 && IsEmpty(formname.signlanguage,'radio')) {
			document.getElementById('signlanguagespan').innerHTML="Select sign language of the prospect";
			formname.signlanguage[0].focus();
			return false;
		} else {
			document.getElementById('signlanguagespan').innerHTML="";
		}

		if(severity==1 && IsEmpty(formname.disseverity,'radio')) {
			document.getElementById('disseverityspan').innerHTML="Select disability severity of the prospect";
			formname.disseverity[0].focus();
			return false;
		} else {
			document.getElementById('disseverityspan').innerHTML="";
		}

		/*productTypeIds = checkBoxIds(formname,'disabilityproducts[]');
		if(productTypeIds == '') {
			document.getElementById('disproductspan').innerHTML="Select the disabilty products used of the prospect";
			formname.disabilityproducts[0].focus();
			return false;
		} else {
			document.getElementById('disproductspan').innerHTML="";
		}*/
	} else { document.getElementById('physicalspan').innerHTML=""; }

	return true;
}

function chkPhysicalStatus(formname) {
	if (IsEmpty(formname.physicalStatus,'radio')) {
		document.getElementById('physicalspan').innerHTML="Select physical status of the prospect";
		return;
	} else { document.getElementById('physicalspan').innerHTML=""; }
}

function showDisabilty(formname) {
	if(formname.physicalStatus[1].checked && formname.physicalStatus[1].value==1) {
		document.getElementById('disabilitydiv').style.display='block';
	} else {
		document.getElementById('disabilitydiv').style.display='none';
	}
}

/*function chkDisabilityCause(formname) {
	if(formname.disabilitycause.selectedIndex==0) {
		document.getElementById('causespan').innerHTML="Select cause of disability of the prospect";
		return;
	} else {
		document.getElementById('causespan').innerHTML="";
	}
}*/

function chkDisabilityType(formname) {
	var SelectedIds = '',Len=0,signLang=0,severity=0;
	var SelectedIdsArr = new Array();

	SelectedIds = checkBoxIds(formname,'disabilitytype[]');
	/*if(SelectedIds == '') {
		document.getElementById('distypespan').innerHTML="Select the disabilty type of the prospect";
		document.getElementById('signlangdiv').style.display='none';
		formname.signlanguage[0].checked=false;
		formname.signlanguage[1].checked=false;
		document.getElementById('severitydiv').style.display='none';
		formname.disseverity[0].checked=false;
		formname.disseverity[1].checked=false;
		return;
	} else {
		document.getElementById('distypespan').innerHTML="";
	*/
		SelectedIdsArr = SelectedIds.split('~');
		Len		 = SelectedIdsArr.length;
		for(var i=0;i<Len;i++) {
			if(SelectedIdsArr[i] == 2 || SelectedIdsArr[i] == 3 || SelectedIdsArr[i] == 4) {
				severity=1;
			}
			if(SelectedIdsArr[i] == 4) {
				signLang=1;
			}
		}

		if(signLang==1) {
			document.getElementById('signlangdiv').style.display='block';
		} else {
			document.getElementById('signlangdiv').style.display='none';
		}

		if(severity==1) {
			document.getElementById('severitydiv').style.display='block';
		} else {
			document.getElementById('severitydiv').style.display='none';
		}
	//}
}

function chkSignLanguage(formname) {
	if (IsEmpty(formname.signlanguage,'radio')) {
		document.getElementById('signlanguagespan').innerHTML="Select sign language of the prospect";
		return;
	} else { document.getElementById('signlanguagespan').innerHTML=""; }
}

function chkSeverity(formname) {
	if (IsEmpty(formname.disseverity,'radio')) {
		document.getElementById('disseverityspan').innerHTML="Select disability severity of the prospect";
		return;
	} else { document.getElementById('disseverityspan').innerHTML=""; }
}

/*function chkDisabilityProducts(formname) {
	if(checkBoxIds(formname,'disabilityproducts[]') == 0) {
		document.getElementById('disproductspan').innerHTML="Select the disabilty products used of the prospect";
		return;
	} else {
		document.getElementById('disproductspan').innerHTML="";
	}
}*/