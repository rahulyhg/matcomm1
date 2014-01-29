var objAjax1=null;var parameters="";var listdiv='';var listdivno='';var thrusearch='';

function lisatadd(purpose,oppmatid,divid,listcpno) {
	frmlist = document.listfrm;
	thrusearch = '';
	listdiv	= divid;
	listdivno = listcpno;
	if(purpose=='shortlist'){
			if($('blockdiv').className!='disnon'){
            $('bardiv1').className = "disblk fleft pad3 fleft";
			$(listdiv).className   = "disblk fleft pad3 fleft";
			}else{
            $('bardiv1').className = "disnon";
			$(listdiv).className   = "disnon";
			}
	}
	if(purpose=='block'){
		    if($('favdiv').className!='disnon'){
            $('bardiv1').className = "disblk fleft pad3 fleft";
			$(listdiv).className   = "disblk fleft pad3 fleft";
			}else{
            $('bardiv1').className = "disnon";
			$(listdiv).className   = "disnon";
			}
	}
	objAjax1 = AjaxCall();
	parameters = 'id='+oppmatid+'&purp='+purpose+'&divno='+listdivno;
	var argUrl = ser_url+'/list/listadd.php?ls='+Math.random();
	AjaxPostReq(argUrl,parameters,listresDiv,objAjax1); 
}

function checkBoxIds(chrt, frm, idname) { 
	var cval='';
	for(i=0;i<frm.length;i++) { 
		if(frm.elements[i].type=='checkbox' && frm.elements[i].name!=idname) { 
			if(frm.elements[i].checked) {
				cval+=frm.elements[i].value+chrt;
			} 
		} 
	} 
	if(cval.length>0) {
		cval=cval.substring(0,cval.length-1);
	} 
	return cval; 
}

function sendListId(purpose,idname) {
	var buttonForm = this.document.buttonfrm;
	oppmatid = checkBoxIds('~',buttonForm,idname);
	thrusearch = '';

	if(oppmatid != '') {
		thrusearch = 1;
		objAjax1 = AjaxCall();
		parameters = 'id='+oppmatid+'&purp='+purpose+'&thrusearch='+thrusearch;
		var argUrl = ser_url+'/list/listadd.php?ls='+Math.random();
		AjaxPostReq(argUrl,parameters,listresDiv,objAjax1); 
	} else {
		$('listalldiv').style.display="block";
		$('listalldiv').innerHTML = "<div class='fleft tlcenter' style='width:440px;'>Please select atleast one profile</div><div class='fright tlright'><img src='"+imgs_url+"/close.gif' class='pntr' onclick='hidediv(\"listalldiv\")'/></div>";
	}
}

function listresDiv() {
	var resultContent,totalStr,divdisplay='';
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200) {

		 arrResp = objAjax1.responseText.split('^');
		 totalStr = arrResp.length;

		 if(totalStr >= 3) {
			 resultContent = arrResp[0]+arrResp[2];
			 divdisplay	= arrResp[1];
		 } else {
			 resultContent = arrResp[0];
		 }
		 if(thrusearch == 1) {
			 $('listalldiv').innerHTML = '';
			 $('listalldiv').innerHTML = resultContent;
			 $('listalldiv').style.display="block";
		 } else {
			 msgact = 'msgactpart'+listdivno;
			 $(msgact).innerHTML = '';
			 $(msgact).innerHTML = resultContent;
			 if(divdisplay=='yes') {
				 $('bardiv').className = "disnon";
				 $(listdiv).className = "disnon";
			 }
		 }
	 } else 
		 alert('There was a problem with the request.');}
}

function funListDeleteConfirm() {
	var listForm = this.document.buttonfrm;
	$('errorDiv').style.display	= "block";
	oppmatid = checkBoxIds('~',listForm,'');
	if(oppmatid == '') {
		$('errorDiv').innerHTML = "<div class='fleft tlcenter' style='width:440px;'>Please select atleast one profile</div><div class='fright tlright'><img src='"+imgs_url+"/close.gif' class='pntr' onclick='hidediv(\"errorDiv\")'/></div>";
	} else {
		$('errorDiv').innerHTML = $('errorDivConfirm').innerHTML;
	}
}

function funListDelete() {
	var listForm = this.document.buttonfrm;
	$('errorDiv').style.display	= "block";
	oppmatid = checkBoxIds('~',listForm,'');
	objAjax1 = AjaxCall();
	parameters = 'id='+oppmatid+'&purp='+buttonfrm.purp.value;
	var argUrl = ser_url+'/list/listdelete.php?ls='+Math.random();
	AjaxPostReq(argUrl,parameters,listdelDiv,objAjax1); 
}

function listdelDiv() {
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200) {
		$('errorDiv').innerHTML = '';
		$('errorDiv').innerHTML = objAjax1.responseText;
		$('errorDiv').style.display="block";
	 } else 
		 alert('There was a problem with the request.');}
}

/*function lisatadd() {
	frmlist = document.listfrm;
	objAjax1 = AjaxCall();
	var domainNam = varConfArr['domainweb'];
	txt_area_val = frmlist.Comments.value;
	parameters = 'id='+frmlist.id.value+'&purp='+frmlist.purp.value+'&oppNam='+frmlist.oppNam.value+'&oppUser='+frmlist.oppUser.value+'&Comments='+txt_area_val+'&bksub=yes';
	var argUrl = domainNam+'/list/listres.php?ls='+genNumbers();
	AjaxPostReq(argUrl,parameters,listresDiv,objAjax1); 
}
function listedit() {
	frmlist = document.listeditfrm;
	objAjax1 = AjaxCall();
	var domainNam = varConfArr['domainweb'];
	parameters = 'id='+frmlist.id.value+'&purp='+frmlist.purp.value+'&oppNam='+frmlist.oppNam.value+'&oppUser='+frmlist.oppUser.value+'&Comments='+frmlist.Comments.value+'&bkedit=yes';
	var argUrl = domainNam+'/list/listres.php?ls='+genNumbers();
	AjaxPostReq(argUrl,parameters,listresDiv,objAjax1); 
}
function delConfirm(memid,purp,oppunam,oppnam) {
	objAjax1 = AjaxCall();
	var domainNam = varConfArr['domainweb'];
	var argUrl = domainNam+'/list/listres.php?id='+memid+'&purp='+purp+'&oppNam='+oppnam+'&oppUser='+oppunam+'&delc=1&ls='+genNumbers();
	AjaxGetReq(argUrl,listresDiv,objAjax1); 
}
function deleteList(memid,purp,oppnam,oppunam) {
	objAjax1 = AjaxCall();
	var domainNam = varConfArr['domainweb'];
	var argUrl = domainNam+'/list/listres.php?id='+memid+'&purp='+purp+'&oppNam='+oppnam+'&oppUser='+oppunam+'&but=del&ls='+genNumbers();
	AjaxGetReq(argUrl,listresDiv,objAjax1); 
}
function editList(memid,purp) {
	objAjax1 = AjaxCall();
	var domainNam = varConfArr['domainweb'];
	var argUrl = domainNam+'/list/listadd.php?id='+memid+'&purp='+purp+'&ed=ed&chg=1&ls='+genNumbers();
	AjaxGetReq(argUrl,listresDiv1,objAjax1); 
}
function delList() {
	frmlist = document.listfrm;
	objAjax1 = AjaxCall();
	var domainNam = varConfArr['domainweb'];
	var purp = frmlist.purp.value;
	var id= frmlist.id.value;
	if(purp=='shortlist') { var opppurp = 'ignore'; }
	else { var opppurp = 'shortlist'; }
	hideicon(id,opppurp);
	parameters = 'id='+frmlist.id.value+'&purp='+frmlist.purp.value+'&oppNam='+frmlist.oppNam.value+'&oppUser='+frmlist.oppUser.value+'&Comments='+txt_area_val+'&action=delete';
	var argUrl = domainNam+'/list/listres.php?ls='+genNumbers();
	AjaxPostReq(argUrl,parameters,listresDiv,objAjax1); 
}
function listresDiv1() {
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200) {
		 $('list1').innerHTML = "";
		 $('list').innerHTML = "";
		 $('list1').style.display = "block";
		 $('list').style.display = "none";
		 $('list1').innerHTML = objAjax1.responseText;
		window.parent.document.getElementById('icondiv').style.height = document.getElementById('list1').offsetHeight+42+'px' ;
		window.parent.document.getElementById('iframeicon').height = document.getElementById('list1').offsetHeight+40;
	 } else 
		 alert('There was a problem with the request.');}
}
function listresDiv() {
	if (objAjax1.readyState == 4) {
	 if (objAjax1.status == 200) {
		 $('list1').innerHTML = "";
		 $('list1').innerHTML = $('list').innerHTML;
		 $('list').innerHTML = "";
		 $('list').style.display = "block";
		 $('list1').style.display = "none";
		 $('list').innerHTML = objAjax1.responseText;
		window.parent.document.getElementById('icondiv').style.height = document.getElementById('list').offsetHeight+42+'px' ;
		window.parent.document.getElementById('iframeicon').height = document.getElementById('list').offsetHeight+40;
	 } else 
		 alert('There was a problem with the request.');}
}*/