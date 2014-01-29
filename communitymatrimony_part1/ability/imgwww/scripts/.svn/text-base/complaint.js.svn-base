function complaintvalidate() {
	if(document.frmComplaint.abuseCat.value == "0"){
	$('abuseCatspan').innerHTML="Select your abuse category.";document.frmComplaint.abuseCat.focus();return false;
	}else{$('abuseCatspan').innerHTML="&nbsp";}
	if(IsEmpty(document.frmComplaint.abuseSubj,"text")){
	$('abuseSubjspan').innerHTML="Enter your subject.";document.frmComplaint.abuseSubj.focus();return false;
	}else{$('abuseSubjspan').innerHTML="&nbsp";}
	if (IsEmpty(document.frmComplaint.complaintDet,'textarea')){
	$('complaintDetspan').innerHTML="Enter your complaint details.";document.frmComplaint.complaintDet.focus();return false;
	}else{$('complaintDetspan').innerHTML="&nbsp";}
	return true;
}