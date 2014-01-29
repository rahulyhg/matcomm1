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
	if (document.getElementById){
	var srch_saveobj=document.getElementById(srch_saveobj);
	srch_saveobj.style.left=srch_getposOffset(curobj, "left")-8+"px";	
	srch_saveobj.style.display="block";
	srch_saveobj.style.top=srch_getposOffset(curobj, "top")-srch_saveobj.offsetHeight+"px";
	//document.getElementById('BMID').focus();
	return false;
	}
	else
	return true;
}

function srch_overlayclose(srch_saveobj){
document.getElementById(srch_saveobj).style.display="none"
}

function validateViewId()
{
	var objValue = document.getElementById('BMID').value.replace(/\s+$/,"");
	if (objValue.length == 0){alert("Please enter matrimony ID");document.getElementById('BMID').focus();return false;}
	else {return true;}
}
function vbyid()
{
if(validateViewId()==true){document.vbyidfrm.action="http://telemarketing.matchintl.com/tmiface/tmviewbyidheader.php?mid="+document.getElementById('BMID').value;
document.vbyidfrm.submit();}else return false;
}