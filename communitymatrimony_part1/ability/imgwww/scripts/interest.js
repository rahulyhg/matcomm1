function optionRollOver(row,start,end) {
	$('eioptdiv'+row).className='rowcolor smalltxt middiv-pad divborderbot';
	start = parseInt(start);
	end = parseInt(end);
	for(i=start;i<=end;i++) { if(i!=row) { $('eioptdiv'+i).className='smalltxt middiv-pad divborderbot'; } }
}

function funInterestDecline() {

	var frmDecline = document.frmInterestDecline;
	if (!(frmDecline.declineMessage[0].checked || frmDecline.declineMessage[1].checked || frmDecline.declineMessage[2].checked))
	{
		$("declineerr").innerHTML ='Please select a message to send to member, which will suggest why you chose to decline the member\'s interest.';
		frmDecline.declineMessage[0].focus();
		return false;
	}
	return true;
}