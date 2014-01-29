function familyValidate(){
	var frmProfile = document.frmProfile;
  
	/*if(!frmProfile.familyValue[0].checked && !frmProfile.familyValue[1].checked && !frmProfile.familyValue[2].checked){
		$('familyvalue').innerHTML="Please select the family value of the prospect";frmProfile.familyValue[0].focus();return false;
	}else{$('familyvalue').innerHTML="&nbsp";}*/
	if(getRadioValue(document.forms['frmProfile'].elements['familyValue'])==''){
		$('familyvaluespan').innerHTML="Please select the family value of the prospect";frmProfile.familyValue[0].focus();return false;
	}else{$('familyvaluespan').innerHTML="&nbsp";}

	if(!frmProfile.familyType[0].checked && !frmProfile.familyType[1].checked && !frmProfile.familyType[2].checked){
		$('familytypespan').innerHTML="Please select the family type of the prospect";frmProfile.familyType[0].focus();return false;
	}else{$('familytypespan').innerHTML="&nbsp";}

	if (frmProfile.familyStatus.selectedIndex==0)
    {document.getElementById('familystatusspan').innerHTML="Select the family status of the prospect";frmProfile.familyStatus.focus();return false;}	
     else{document.getElementById('familystatusspan').innerHTML="";}

	if(!(frmProfile.brothers.value=="0") && !(frmProfile.marriedBrothers.value=="0")){
		if(frmProfile.marriedBrothers.value > frmProfile.brothers.value){
			$('marriedbrothersspan').innerHTML="Incorrect selection.";frmProfile.brothers.focus();return false;
		}else {$('marriedbrothersspan').innerHTML="&nbsp";}
	}

	if(!(frmProfile.marriedBrothers.value=="0") && frmProfile.brothers.value=="0"){
		$('brothersspan').innerHTML="Please select no of brother(s) of the prospect";frmProfile.brothers.focus();return false;
	}else{$('brothersspan').innerHTML="&nbsp";}

	if(!(frmProfile.sisters.value=="0") && !(frmProfile.marriedSisters.value=="0")){
		if(frmProfile.marriedSisters.value > frmProfile.sisters.value){
			$('marriedsistersspan').innerHTML="Incorrect selection.";frmProfile.sisters.focus();return false;
		}else{$('marriedsistersspan').innerHTML="&nbsp";}
	}

	if(!(frmProfile.marriedSisters.value=="0") && frmProfile.sisters.value=="0"){
		$('sistersspan').innerHTML="Please select no of Sister(s) of the prospect";frmProfile.sisters.focus();return false;
	}else{$('sistersspan').innerHTML="&nbsp";}

	return true;
}