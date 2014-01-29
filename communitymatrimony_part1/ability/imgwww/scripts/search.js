var param="", objAjax1=null, USStateAvail=0, INDStateAvail=0, EatingCnt=5, DrinkingCnt=4, SmokingCnt=4, srchSavedCnt=0, savedId=''; 
var chkSelbox = new Array('denomination', 'caste', 'subcaste', 'motherTongue', 'country', 'residingState', 'residingCity', 'education','gothram','star','raasi','occupation');

function Decode_it(encoded) {
	try{ if(encoded!='' && encoded!=undefined) {
	var HEXCHARS="0123456789ABCDEFabcdef"; var plaintext=''; var i=0;
	while (i < encoded.length) {
		var ch=encoded.charAt(i);
		if(ch=="+") { plaintext+=" "; i++; } 
		else if(ch=="%") {
			if(i < (encoded.length-2) && HEXCHARS.indexOf(encoded.charAt(i+1)) !=-1 && HEXCHARS.indexOf(encoded.charAt(i+2)) !=-1) {
				plaintext+=unescape(encoded.substr(i,3)); i+=3;
			} else { plaintext+="%[ERROR]"; i++; }
		} else { plaintext+=ch; i++; }
	} return plaintext;
	} } catch(e) { }
}

function frmvalidate(formobj) {
	var MatriForm=eval("this.document."+formobj);
	if(!validateAge(MatriForm,'ageerr')) { return false; }
	if(!validateHeight(MatriForm,'heighterr')) {return false; }
	/*if(MatriForm.srchType.value=='2'){
		if(!annuIncome(formobj, 's')) { return false; }
	}*/
	if(MaritalCnt > 1 && !maritalValidate(MatriForm)) { return false; }
	return true;
}

function refineSearch(){
	var RegForm= document.RSearchForm;
	if(!validateAge(RegForm,'ageerr')) { return false; }
	if(!validateHeight(RegForm,'heighterr')) {return false; }
	document.RSearchForm.submit();
}

function validate(formobj) {
	if (frmvalidate(formobj)==true) {
		var SrchForm=eval("this.document."+formobj);
		var redir_path=document.getElementById('redirectjspath').value;
		SrchForm.action=redir_path+"?randid="+ Math.random();
		SrchForm.saveSrch.value = '';
		SrchForm.srchId.value	= '';
		for(w=0; w<chkSelbox.length; w++){
			selObj = eval('this.document.'+formobj+'.'+chkSelbox[w]);
			if(selObj != null){selValues(selObj);}
		}
		SrchForm.submit();
	}
}

function selValues(theSel){
	var selLength	= theSel.length;
	for(ww=0; ww<selLength; ww++)
	{theSel.options[ww].selected = true;}
	
}

function srchDel(srchId, srchName, delFl){
	$('delDiv').style.display = 'block';
	savedId = srchId;
	if(delFl == 'N'){
		document.body.scrollTop= 60;
		$('delDiv').innerHTML = '<center>Are you surely want to delete <b>'+srchName+'</b> saved search?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" onclick="srchDel('+srchId+",'"+srchName+"','S'"+');" value="Yes" class="button">&nbsp;<input type="button" onclick="$(\'delDiv\').innerHTML=\'\';$(\'delDiv\').style.display=\'none\'" value="No" class="button"></center>';
	}else if(delFl== 'S'){
		url		= ser_url+'/search/srchDelete.php?rno='+Math.random();
		param	= 'srchId='+srchId;
		objAjax1 = AjaxCall();
		AjaxPostReq(url,param,srchDelRes,objAjax1);
	}
}

function srchDelRes(){
	if(objAjax1.readyState == 4){
	$('delDiv').innerHTML = '<center>'+objAjax1.responseText+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="$(\'delDiv\').innerHTML=\'\';$(\'delDiv\').style.display=\'none\'" value="Close" class="button"></center>';
	if($(savedId) != ''){$(savedId).style.display='none';$(savedId).innerHTML='';}
	}else{
	$('delDiv').innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}

function annuIncome(formobj,flag){
	var sf=eval("this.document."+formobj);
	var ann1sel = parseInt(sf.annualIncome.selectedIndex);
	if(sf.annualIncome.options[ann1sel].value>=0.5 && sf.annualIncome.options[ann1sel].value<101){
		$('ann1').style.display = 'block';
		$('annerr').style.display = 'none';
		if(flag==''){sf.annualIncome1.options[ann1sel-1].selected = true;}
		return annuIncome1(formobj);
	}else{
		$('ann1').style.display = 'none';
		$('annerr').style.display = 'none';
		return true;
	}

}

function annuIncome1(formobj){
	var sf=eval("this.document."+formobj);
	if(parseInt(sf.annualIncome.options[sf.annualIncome.selectedIndex].value) > parseInt(sf.annualIncome1.options[sf.annualIncome1.selectedIndex].value)){
		$('annerr').style.display = 'block';
		$('annerr').innerHTML = 'Sorry, invalid annual income range.';
		return false;
	}else{
		$('annerr').innerHTML = '';
		$('annerr').style.display = 'none';
		return true;
	}
}

function srchnameexists(argSrchName) {
	var SaveSrchCook = Decode_it(getCookie('savedSearchInfo'));
	var SrchCook = new Array();
	if(SaveSrchCook != null && SaveSrchCook != ''){
		SrchCook = SaveSrchCook.split('~');
	}
	var CookLen		 = SrchCook.length;
	var SrchNameExist = 'no';
	for(var i=0;i<CookLen;i++) {
		var CookInfo	= SrchCook[i].split('|');
		if(CookInfo[2] == argSrchName) { SrchNameExist = 'yes' ; }
	}
	srchSavedCnt = i;
	return SrchNameExist;
}

function multiple_save(formobj){
	var frmSrch	= eval('document.'+formobj);
	var saveSrchName = frmSrch.searchName.value;
	var editSave	 = frmSrch.srchId.value;
	var srchname;
	srchname = srchnameexists(saveSrchName);
	var objRegExp	= new RegExp("^[a-zA-Z0-9\\s]+$");
	if(IsEmpty(frmSrch.searchName,'text') || saveSrchName =='Enter search name'){
		$("saveerr").innerHTML="Please enter a name for your search.";
		frmSrch.searchName.focus();
	}else if(srchname=='yes' && editSave==''){
		$("saveerr").innerHTML="Name already exists. Please enter another name.";
		frmSrch.searchName.focus();
	}else if(cook_id!='' && cook_paid=="0" && srchSavedCnt>=3 && srchname=='no'){
		$("saveerr").innerHTML="A free member can save up to 3 searches only.";
	}else if(!objRegExp.test(saveSrchName)){
		$("saveerr").innerHTML="The search name you have provided is invalid.";
	}else if(saveSrchName.length>14){
		$("saveerr").innerHTML="A maximum of 14 characters only is permitted.";
	}else{
		frmSrch.saveSrch.value = 'yes';
		$("saveerr").innerHTML="";
		if(frmvalidate(formobj)){
			var redir_path=document.getElementById('redirectjspath').value;
			frmSrch.action=redir_path+"?randid="+ Math.random();
			for(w=0; w<chkSelbox.length; w++){
				selObj = eval('this.document.'+formobj+'.'+chkSelbox[w]);
				if(selObj != null){selValues(selObj);}
			}
			frmSrch.submit();
		}else{$('search_savebox').style.display='none';}
	}
	
}

function checkGenderAge(sf) {
	if(sf.gender[0].checked) { sf.ageFrom.value = FMStAge; sf.ageTo.value = FMEdAge;}
	else { sf.ageFrom.value = MStAge; sf.ageTo.value = MEdAge;}
}

function checkHabits(formobj, habits) {
	if(habits == 'eating'){HabitsCnt = 5;}else{HabitsCnt = 4;}
	var frmSrch=eval("this.document."+formobj);
	var chkBoxVal=eval("this.document."+formobj+"."+habits);
	if (chkBoxVal[0].checked)
	{
		for(i=1; i<HabitsCnt; i++){	chkBoxVal[i].checked=false;	}
	}else{
		allChk = 1;
		for(i=1; i<HabitsCnt; i++){
			if(chkBoxVal[i].checked==false){allChk=0;}
		}
		if(allChk==1){
			chkBoxVal[0].checked=true;
			for(i=1; i<HabitsCnt; i++){	chkBoxVal[i].checked=false;	}
		}
	}
}

function validateAge(sf,did) {
	var minage=0;
	stAge=sf.ageFrom.value;
	endAge=sf.ageTo.value;	
	if(cook_id !=''){
		var gender = (cook_gender=='1') ? '2' : '1';
	} else {
		var gender = (sf.gender[0].checked==true) ? 2 : 1;
	}
	(gender==2) ? minage=FMStAge : minage=MStAge;			
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
		sf.ageTo.focus();
		return false;
	} else if(stAge!=0 && endAge<stAge) {
		$(did).innerHTML="Sorry, Invalid age range. "+stAge+" to "+endAge+".";
		sf.ageFrom.focus();
		return false;
	} else if(stAge < minage || stAge > 70) {
		$(did).innerHTML= "Sorry, invalid age "+stAge+" (Min. age is "+minage+". Max. age is 70)." ;
		sf.ageFrom.focus();
		return false;
	} else if(parseInt(endAge)<minage || parseInt(endAge)>70) {
		$(did).innerHTML="Sorry, invalid age "+endAge+" (Min. age is "+minage+". Max. age is 70).";	
		sf.ageTo.focus();
		return false;
	} else if(parseInt(FINALAGE)>22) {
		$(did).innerHTML="The difference between a partner's \"From\" and \"To\" age should not exceed 22 years.";
		sf.ageTo.focus();
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

function maritalValidate(formobj) {
	var chkFlag = 0;
	for(i=0; i<=MaritalCnt; i++){
		if(formobj.maritalStatus[i].checked){
			chkFlag = 1;break;
		}
	}

	if (chkFlag == 0) {
		$BN("maritalerr",'b');
		$("maritalerr").innerHTML="Please select the type of person you are looking for.";
		formobj.maritalStatus[0].focus();
		return false;
	}
	return true;
}

function funMaritalStatus(formobj)
{
	var frmSrch=eval("document."+formobj);
	var chkUMD = 0;chkWID = 0;chkDIV = 0;chkSEP = 0;chkMD = 0;

	allChk = 0;
	for(i=1; i<=MaritalCnt; i++){
		if(frmSrch.maritalStatus[i].checked){
			allChk = 1;
		}else{allChk = 0;break;}
	}

	if(allChk == 1){
		frmSrch.maritalStatus[0].checked=true; 
		
		for(i=1; i<=MaritalCnt; i++){
			frmSrch.maritalStatus[i].checked = false;
		}
	}

	for(i=1; i<=MaritalCnt; i++){
		if(frmSrch.maritalStatus[i].checked && frmSrch.maritalStatus[i].value==1){
			chkUMD = 1;
		}else if(frmSrch.maritalStatus[i].checked && frmSrch.maritalStatus[i].value==2){
			chkWID = 1;
		}else if(frmSrch.maritalStatus[i].checked && frmSrch.maritalStatus[i].value==3){
			chkDIV = 1;
		}else if(frmSrch.maritalStatus[i].checked && frmSrch.maritalStatus[i].value==4){
			chkSEP = 1;
		}else if(frmSrch.maritalStatus[i].checked && frmSrch.maritalStatus[i].value==5){
			chkMD = 1;
		}
	}

    if (chkUMD == 1) { 
		frmSrch.maritalStatus[0].checked=false; 
		if(chkWID == 0 && chkDIV == 0 && chkSEP == 0 && chkMD == 0){ $("childblock").style.display = 'none'; } 
		else { $("childblock").style.display = 'block'; }
	}
	else if (chkWID == 1) { frmSrch.maritalStatus[0].checked=false;$("childblock").style.display = 'block'; }
	else if (chkDIV == 1) { frmSrch.maritalStatus[0].checked=false;$("childblock").style.display = 'block';}
	else if (chkSEP == 1) { frmSrch.maritalStatus[0].checked=false;$("childblock").style.display = 'block';}
	else if (chkMD == 1) { frmSrch.maritalStatus[0].checked=false;$("childblock").style.display = 'block';}
	else if (frmSrch.maritalStatus[0].checked)
	{
		for(i=1; i<=MaritalCnt; i++){
		frmSrch.maritalStatus[i].checked=false;
		}
		$("childblock").style.display = 'block';
	} else if(chkUMD == 0 && chkWID == 0 && chkDIV == 0 && chkSEP == 0 && chkMD == 0){
		frmSrch.maritalStatus[0].checked=true;
		$("childblock").style.display   = 'block';
	}
}//funMaritalStatus
function funMaritalStatusAny(formobj)
{
	var frmSrch=eval("this.document."+formobj);
	if (frmSrch.maritalStatus[0].checked)
	{
		for(i=1; i<=MaritalCnt; i++){
		frmSrch.maritalStatus[i].checked=false;
		}
		$("childblock").style.display = 'block';
	} else {  $("childblock").style.display = 'none'; }
}//funMaritalStatusAny

function savesrch_overlay(curobj, srch_saveobj){
	if (document.getElementById){
		var srch_saveobj=document.getElementById(srch_saveobj)
		srch_saveobj.style.left=savesrch_getposOffset(curobj, "left")-183+"px"
		srch_saveobj.style.top=savesrch_getposOffset(curobj, "top")-130+"px"
		srch_saveobj.style.display="block"
		document.ss1.searchName.focus();
		return false
	}
	else
		return true
}

function savesrch_getposOffset(overlay, offsettype){
	var totaloffset=(offsettype=="left")? overlay.offsetLeft : overlay.offsetTop;
	var parentEl=overlay.offsetParent;
	while (parentEl!=null){
		totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
		parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}

function savesrch_overlayclose(srch_saveobj){
	document.getElementById(srch_saveobj).style.display="none"
}

function validateViewId() {
	var SrchIdForm = document.SrchIdForm;
	if(IsEmpty(SrchIdForm.matrimonyId,"text")) {
		$("viewproerr").innerHTML="Please enter username.";
		SrchIdForm.matrimonyId.value='';
		SrchIdForm.matrimonyId.focus();
		return false;
	}
	else{
		$("viewproerr").innerHTML="";	
		return true;
	}
}

function frmViewIdvalidate(){ 
	if(!validateViewId()) {
		return false;
	}
	var MatriId = document.SrchIdForm.matrimonyId.value;
	document.SrchIdForm.action="/profiledetail/index.php?act=viewprofile&id="+MatriId;
	return true;
}

function moveOptions(theSelFrom, theSelTo){
	var selLength = theSelFrom.length;
	var selectedText = new Array();
	var selectedValues = new Array();
	var selectedCount = 0;
	var selId = theSelFrom.id;
	var i;
	for(i=selLength-1; i>=0; i--)
	{
		if(theSelFrom.options[i].selected){
			selectedText[selectedCount] = theSelFrom.options[i].text;
			selectedValues[selectedCount] = theSelFrom.options[i].value;
			deleteOption(theSelFrom, i);
			selectedCount++;
		}
	}
	for(i=selectedCount-1; i>=0; i--){	addOption(theSelTo, selectedText[i], selectedValues[i]);}
		
	if(selId == 'countryTemp'){	coun_moveOptions(theSelFrom,theSelTo);}
	else if(selId == 'country'){ coun_moveOptions(theSelTo,theSelFrom);}
	else if(selId == 'residingStateTemp'){	coun_moveOptions(theSelFrom,theSelTo);}
	else if(selId == 'residingState'){ coun_moveOptions(theSelTo,theSelFrom);}
}//moveOptions

function getFirstOptVal(theSelFrom, optVal){
	firstOptVal = theSelFrom.options[0].value;
	if(optVal == 'country'){
		theSelTo = this.document.RSearchForm.countryTemp;
		selLen = theSelTo.length;
		theSelTo.options[0].selected =false;
		for(XX=0; XX<selLen; XX++){
			if(theSelTo.options[XX].value == firstOptVal){
				theSelTo.options[XX].selected =true;break;
			}
		}
		moveOptions(this.document.RSearchForm.countryTemp, this.document.RSearchForm.country);
	}else if(optVal == 'state'){
		coun_moveOptions(this.document.RSearchForm.residingStateTemp, this.document.RSearchForm.residingState)
	}
}
function deleteOption(theSel, theIndex){	
	var selLength = theSel.length;
	if(selLength>0){theSel.options[theIndex] = null;}
}//deleteOption

function coun_moveOptions(theSelFrom,theSelTo)
{
	var selLength	= theSelTo.length;
	var selId		= theSelTo.id;
	var selectedValues = new Array();
	var selectedCount = 0;
	var cityAvail	= 0;
	var stateAvail	= 0;
	var w;

	if(selLength==0 && selId=='country'){
		$('residingState').innerHTML='';$('residingStateTemp').innerHTML='';
		$('residingCity').innerHTML='';$('residingCityTemp').innerHTML='';
		$('statesblock').style.display = "none";$('cityblock').style.display = "none";
	}else if(selId=='residingState' && selLength==0){
		$('residingCity').innerHTML='';$('residingCityTemp').innerHTML='';
		$('cityblock').style.display = "none";
	}else{
		for(w=selLength-1; w>=0; w--)
		{
			if(selId == 'country'){
				selectedValues[selectedCount]=theSelTo.options[w].value;
				selectedCount++;
				USStateAvail = 0;
				INDStateAvail = 0;
			}
			else if(selId == 'residingState'){
				selectedValues[selectedCount]=theSelTo.options[w].value;
				selectedCount++;
			}
		}
		
		for(w=0; w<selectedCount; w++)
		{
			selVal = selectedValues[w];
			
			if(selId == 'country' && (selVal == 98 || selVal==222) && (INDStateAvail==0 || USStateAvail==0)) {
				$('statesblock').style.display = "block";
				if(stateAvail == 0){
				stateAvail = 1;
				$('residingState').innerHTML='';$('residingCity').innerHTML='';
				$('residingStateTemp').innerHTML='';$('residingCityTemp').innerHTML='';
				if($('cityblock')!=''){$('cityblock').style.display = "none";}
				coun_updatestate(selVal,'residingStateTemp','states',theSelFrom);
				}else{coun_updatestate(selVal,'residingStateTemp','states',theSelFrom);	}
				if(selVal == 98 && INDStateAvail==0){ INDStateAvail=1;}
				if(selVal == 222 && USStateAvail==0){ USStateAvail=1;}
			}
			else if(selId == 'country' && INDStateAvail==0 && USStateAvail==0) {
				$('residingState').innerHTML='';$('residingCity').innerHTML='';
				$('residingStateTemp').innerHTML='';$('residingCityTemp').innerHTML='';
				$('statesblock').style.display = "none";
				if($('cityblock')!=''){$('cityblock').style.display = "none";}
			}
			else if(selId == 'residingState' && INDStateAvail ==1 && selVal.substr(0,2)==98) {
				if(cityAvail==0){
					cityAvail=1;
					$('residingCity').innerHTML='';$('residingCityTemp').innerHTML='';
					coun_updatecity(selVal,'residingCityTemp','cities',theSelFrom);
				}else{coun_updatecity(selVal,'residingCityTemp','cities',theSelFrom);}
			}
			else if(selId == 'residingState' && cityAvail==0){
				$('cityblock').style.display = "none"; $('residingCity').innerHTML='';$('residingCityTemp').innerHTML='';
			}
		}
	}	
}//moveOptions

function coun_updatecity(j,obj,aryname,selOption)
{
	var aryname	=eval(aryname);
	var obj1	=$(obj);
	var selId	= selOption.id;
	var k = j;
	if(j.substr(0,2)==98)
	{
		for (var i=0; i<aryname[j].length; i++) {
			$('cityblock').style.display = "block";
			addOption(obj1,aryname[j][i].split("|")[0],aryname[j][i].split("|")[1]); 
		}
	}
}

function addOption(theSel, theText, theValue)
{
	var add_sel = 's';
	sellen	= theSel.length;
	for(i=0; i<sellen;i++){
		if(theSel.options[i].value == theValue){
		add_sel = 'n';
		}
	}

	if(add_sel=='s'){
	var newOpt = new Option(theText, theValue);
	var selLength = theSel.length;
	theSel.options[selLength] = newOpt;
	}

	sellen	= theSel.length;
	if(sellen > 0){
		for(i=0; i<(sellen-1);i++){
			theSel.options[i].selected=false;	
		}
		theSel.options[(sellen-1)].selected=true;
	}
}//addOption

function coun_updatestate(j,obj,aryname,selOption)
{	
	var aryname = eval(aryname);
	var selId	= selOption.id;
	var selLength = selOption.length;
	var obj1=$(obj);
	var optionexits = '';
	if(selId=='country'){
		for(i=selLength-1; i>=0; i--) { var optionexits = optionexits +  '~~' + selOption.options[i].value; }
		optionexits = optionexits+'~~';
		if(j == 98){
			for(var i=0; i<aryname[j].length; i++) { 
			addOption(obj1,aryname[j][i].split("|")[0],aryname[j][i].split("|")[1]); 
			}
		}else if(j == 222){
			for(var i=0; i<aryname[j].length; i++) {	
				addOption(obj1,aryname[j][i].split("|")[0],aryname[j][i].split("|")[1]);
			}
		}else {$('statesblock').style.display = "none";$(obj).innerHTML = '';}
	}else {
		for (var i=0; i<aryname[j].length; i++) { 
		addOption(obj1,aryname[j][i].split("|")[0],aryname[j][i].split("|")[1]); 
		}
	}
}  
function city_moveOptions(theSelFrom, theForm)
{
	var selLength=theSelFrom.length;
	var cselectedValues=new Array();
	var cselectedCount=0;
	var cou;
	var ii,z;
	
	for(ii=selLength-1; ii>=0; ii--) {
		if(theSelFrom.options[ii].selected) {
			cselectedValues[cselectedCount]=theSelFrom.options[ii].value;
			cselectedCount++;
		}
	}
	coun_moveOptions(theSelFrom);
	for(d=cselectedCount-1; d>=0; d--) {
		var stobj=cselectedValues[d];
		if(stobj.substr(0,2)==98) {
		for (t=0;t<cities[stobj].length;t++) {
			for (g=0;g<theForm.residingCity.length;g++) {
				if (theForm.residingCity.options[g].value==cities[stobj][t].split("|")[1])
				{theForm.residingCity.remove(g);}
			}
		}
		}
	}
	
	for(z=selLength-1; z>=0; z--) { if((theSelFrom.options[z] != null) && (theSelFrom.options[z].selected)) { 	state_based_enable_disable(theSelFrom);}}
}
function state_based_enable_disable(theSelFrom) {
	var selLength=theSelFrom.length;
	var cselectedText=new Array();
	var cselectedValues=new Array();
	var cselectedCount=0;
	var city_flag=true;
	for(i=selLength-1; i>=0; i--) { cselectedValues[cselectedCount]=theSelFrom.options[i].value;cselectedCount++; }
	for(d=cselectedCount-1; d>=0; d--)
	{
		var stobj=cselectedValues[d];
		if(stobj.substr(0,2)==98) { city_flag=false;break; }
	}
	if(city_flag==true) { $('cityblock').style.display = "none"; }
}

function chswap(dname,val){	
	if(val=="+"){$(dname).innerHTML='-';}
	else {$(dname).innerHTML='+';}

	if($('search_savebox')!='' && $('search_savebox').style.display=='block')
	{
		$('search_savebox').style.display='none';
	}
}
	
function save_search_box(divid,boxdiv){	
	divTag=$(boxdiv);
	divTag.style.position='absolute';
	divTag.style.display="block";
	divTag.style.left=findPosX($(divid))-150+'px';
	var poschk=findPosY($(divid))-divTag.offsetHeight;	
	if (document.documentElement.scrollTop >= poschk) 
	{	
		divTag.style.top=findPosY($(divid))+$(divid).offsetHeight-55+'px'; 
	} 
	else { divTag.style.top=poschk+135+'px'; }			
}

function chkAllTxt(){
	document.buttonfrm.chk_all.checked = true;
	selectall(document.buttonfrm, 'chk_all');
}

function chkNoneTxt(){
	document.buttonfrm.chk_all.checked = false;
	selectall(document.buttonfrm, 'chk_all');
}