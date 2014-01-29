function checkBoxIds(frm, idname) { 
	var cval=0;
	
	for(i=0;i<frm.length;i++) { 
		if(frm.elements[i].type=='checkbox' && frm.elements[i].name==idname) { 
			if(frm.elements[i].checked) {
				cval++;
			} 
		} 
	} 

	return cval; 
}

function HobbiesValidate(){
	
	var frmProfile = document.frmProfile;

	if(checkBoxIds(frmProfile,'interest[]') > 3) {
		$('inttopspan').innerHTML="Please select only top 3 interests";
		window.location.href=window.location.href+"#errinter";
		return false;
	} else {
		$('inttopspan').innerHTML="";
	}

   if (frmProfile.intothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.interestDesc,'text')){
		$('interestDescspan').innerHTML="Please enter other interests";
		frmProfile.interestDesc.value = '';
		frmProfile.interestDesc.focus();return false;
	  }else{$('interestDescspan').innerHTML="";}
   }

   if(checkBoxIds(frmProfile,'hobbies[]') > 3) {
		$('hobintspan').innerHTML="Please select only top 3 hobbies";
		window.location.href=window.location.href+"#errhobby";
		return false;
	} else {
		$('hobintspan').innerHTML="";
	}
  
   if (frmProfile.hobothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.hobbiesDesc,'text')){
		$('hobbiesDescspan').innerHTML="Please enter other hobbies";
		frmProfile.hobbiesDesc.value = '';
		frmProfile.hobbiesDesc.focus();return false;
	  }else{$('hobbiesDescspan').innerHTML="";}
   }

    if(checkBoxIds(frmProfile,'music[]') > 3) {
		$('musintspan').innerHTML="Please select only top 3 musics";
		window.location.href=window.location.href+"#errmusic";
		return false;
	} else {
		$('musintspan').innerHTML="";
	}

   if (frmProfile.mscothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.musicDesc,'text')){
		$('musicDescspan').innerHTML="Please enter other favourite musics";
		frmProfile.musicDesc.value = '';
		frmProfile.musicDesc.focus();return false;
	  }else{$('musicDescspan').innerHTML="";}
   }
/*
   if (frmProfile.frdothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.readDesc,'text')){
		$('readDescspan').innerHTML="Please enter other favourite reads";
		frmProfile.readDesc.value = '';
		frmProfile.readDesc.focus();return false;
	  }else{$('readDescspan').innerHTML="";}
   }

   if (frmProfile.mvothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.movieDesc,'text')){
		$('movieDescspan').innerHTML="Please enter other preferred movies";
		frmProfile.movieDesc.value = '';
		frmProfile.movieDesc.focus();return false;
	  }else{$('movieDescspan').innerHTML="";}
   } */

	if(checkBoxIds(frmProfile,'sports[]') > 3) {
		$('sportstopspan').innerHTML="Please select only top 3 sports";
		window.location.href=window.location.href+"#errsports";
		return false;
	} else {
		$('sportstopspan').innerHTML="";
	}

   if (frmProfile.sftothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.sportsDesc,'text')){
		$('sportsDescspan').innerHTML="Please enter other sports/fitness activities";
		frmProfile.sportsDesc.value = '';
		frmProfile.sportsDesc.focus();return false;
	  }else{$('sportsDescspan').innerHTML="";}
   }

    if(checkBoxIds(frmProfile,'food[]') > 3) {
		$('foodtopspan').innerHTML="Please select only top 3 foods";
		window.location.href=window.location.href+"#errfood";
		return false;
	} else {
		$('foodtopspan').innerHTML="";
	}

   if (frmProfile.fcsnothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.foodDesc,'text')){
		$('foodDescspan').innerHTML="Please enter other favourite cuisine";
		frmProfile.foodDesc.value = '';
		frmProfile.foodDesc.focus();return false;
	  }else{$('foodDescspan').innerHTML="";}
   }

 /*  if (frmProfile.pdsothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.dressDesc,'text')){
		$('dressDescspan').innerHTML="Please enter other preferred dress style";
		frmProfile.dressDesc.value = '';
		frmProfile.dressDesc.focus();return false;
	  }else{$('dressDescspan').innerHTML="";}
   }

   if (frmProfile.slangothertxt.checked == true) {
	   if (IsEmpty(document.frmProfile.spokenLangDesc,'text')){
		$('spokenLangDescspan').innerHTML="Please enter other spoken languages";
		frmProfile.spokenLangDesc.value = '';
		frmProfile.spokenLangDesc.focus();return false;
	  }else{$('spokenLangDescspan').innerHTML="";}
   }*/
  return true;
}

function divswitch(c, a, b) {
	if(c.length < 1) { return; }
	if($(c).className == "disnon") {
		$(c).className = "disblk";
		$(a).className = "disnon";
		$(b).className = "disblk pad3";
	} else {
		$(c).className = "disnon";
		$(a).className = "disblk pad3";
		$(b).className = "disnon";
	}
}

function othrtxt(a, b) {

	if(eval("document.frmProfile."+a+".checked")==true)		
	{ eval("document.frmProfile."+b+".disabled = false");}
	else {eval("document.frmProfile."+b+".disabled = true");$(b+'span').innerHTML = '';}	
}