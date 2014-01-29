var objCasteAjax = '';
var packageval='';
function srch_getposOffset(overlay, offsettype){
	var totaloffset=(offsettype=="left")? overlay.offsetLeft : overlay.offsetTop;
	var parentEl=overlay.offsetParent;
	while (parentEl!=null){
		totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
		parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}

function srch_overlay(curobj, srch_saveobj){
	if(document.getElementById('country')){document.getElementById('country').style.visibility = "hidden"}
	if(document.getElementById('qsrecaste')){document.getElementById('qsrecaste').style.visibility = "hidden"}
	if (document.getElementById){
		var srch_saveobj=document.getElementById(srch_saveobj)
		srch_saveobj.style.left=srch_getposOffset(curobj, "left")-8+"px"
		srch_saveobj.style.top=srch_getposOffset(curobj, "top")-172+"px"
		srch_saveobj.style.display="block"
		document.getElementById('id').focus();
		return false;
	} else { return true; }
}

function srch_overlayclose(srch_saveobj){
	if(document.getElementById('country')){document.getElementById('country').style.visibility = "visible";}
	if(document.getElementById('qsrecaste')){document.getElementById('qsrecaste').style.visibility = "visible";}
	document.getElementById(srch_saveobj).style.display="none"
}

function vbyid() {
	var objValue = document.getElementById('id').value.replace(/\s+$/,"");
	if (objValue.length == 0){alert("Please enter username");document.getElementById('id').focus();return false;}
	return true;
}

function chkgender(g)	{ 
	if (g==2) { document.MatriForm.ageFrom.value="18"; document.MatriForm.ageTo.value="30"; }
	if (g==1) { document.MatriForm.ageFrom.value="21"; document.MatriForm.ageTo.value="33"; }
}

function chkage(ag)
{
	if(ag=='ageFrom')
		{ 
			if((document.MatriForm.gender[0].checked) && (document.MatriForm.ageFrom.value == ''))
			{
				document.MatriForm.ageFrom.value="18";
			}
			else if (((document.MatriForm.gender[1].checked) && (document.MatriForm.ageFrom.value == '')))
			{
				document.MatriForm.ageFrom.value="21";
			}
		}
	if(ag=='ageTo')
		{
			if((document.MatriForm.gender[0].checked) && (document.MatriForm.ageTo.value == ''))
			{
				document.MatriForm.ageTo.value="30";
			}
			else if (((document.MatriForm.gender[1].checked) && (document.MatriForm.ageTo.value == '')))
			{
				document.MatriForm.ageTo.value="33";
			}
		}
}

function payvalidate() {
	if (!document.frmPayment.package[0].checked && !document.frmPayment.package[1].checked && !document.frmPayment.package[2].checked)
	{
		alert('Please choose the package');
		document.frmPayment.package[0].focus();
		return false;
	}

	if(document.frmPayment.Paymonths.value == 000)
	{
		alert('Please select the period');
		document.frmPayment.Paymonths.focus();
		return false;
	}

	if((document.frmPayment.package[0].checked) && (document.frmPayment.Paymonths.value == 3))
	{
		document.frmPayment.category.value=1;
	}
	else if((document.frmPayment.package[0].checked) && (document.frmPayment.Paymonths.value == 6))
	{
		document.frmPayment.category.value=2;
	}
	else if((document.frmPayment.package[0].checked) && (document.frmPayment.Paymonths.value == 9))
	{
		document.frmPayment.category.value=3;
	}
	else if((document.frmPayment.package[1].checked) && (document.frmPayment.Paymonths.value == 3))
	{
		document.frmPayment.category.value=4;
	}
	else if((document.frmPayment.package[1].checked) && (document.frmPayment.Paymonths.value == 6))
	{
		document.frmPayment.category.value=5;
	}
	else if((document.frmPayment.package[1].checked) && (document.frmPayment.Paymonths.value == 9))
	{
		document.frmPayment.category.value=6;
	}
	else if((document.frmPayment.package[2].checked) && (document.frmPayment.Paymonths.value == 3))
	{
		document.frmPayment.category.value=7;
	}
	else if((document.frmPayment.package[2].checked) && (document.frmPayment.Paymonths.value == 6))
	{
		document.frmPayment.category.value=8;
	}
	else if((document.frmPayment.package[2].checked) && (document.frmPayment.Paymonths.value == 9))
	{
		document.frmPayment.category.value=9;
	}
	return true;
}