function chkgender(g)
{ 
if (g=="f")   { document.RSearchForm.ageFrom.value="18"; document.RSearchForm.ageTo.value="30"; }
if (g=="m") {  document.RSearchForm.ageFrom.value="21"; document.RSearchForm.ageTo.value="33"; }
}

function setagegroup()
{ if (document.RSearchForm.GENDER[0].checked==true)
{ document.RSearchForm.ageFrom.value="18"; document.RSearchForm.ageTo.value="30"; }
else
{ document.RSearchForm.ageFrom.value="21"; document.RSearchForm.ageTo.value="33"; }	
}

var t;
function expand(expdiv, sdheight, clkdiv, mdiv)
{		
	var obj=document.getElementById(clkdiv);
	obj.className="lognborder";	
	obj.style.borderBottom=0;
	var obj2=document.getElementById(mdiv);
	obj2.className="lognborder2";
	zin(expdiv, sdheight);	
	document.getElementById(expdiv).style.display="block";	
	obj2.style.display="block";	
}

 function zin(expdiv, sdheight){		
	if(document.getElementById(expdiv))	{	
	var ih=document.getElementById(expdiv).offsetHeight;
	if(ih!=sdheight){
	document.getElementById(expdiv).style.height=ih+1+"px";
	t=setTimeout("zin('"+expdiv+"', '"+sdheight+"')",1);
	}else{clearTimeout(t);} }
}


function collape(clsdiv, clkdiv, mdiv, count)
{	
	document.getElementById(clkdiv).className="lognbordercls";	
	document.getElementById(clsdiv).style.display="none";
	for (var i=1; i<=count; i++) {document.getElementById(mdiv+i).style.display="none";}
}


var TabNxtVar=0;

function sitetab(dname, hpscount) {

	for(var i=1; i<=21; i++)
		{
			var divid = "Ldiv"+i;
			var tdivid = "L"+i;
			
			document.getElementById(divid).className="disnon";
			document.getElementById(tdivid).className="clr1";
		}

		for(var i=1; i<=21; i++)
		{
			var divid1 = "Ldiv"+i;
			var tdivid = "L"+i;

			if(divid1==dname && TabNxtVar==0)
			{	
				document.getElementById(dname).className = "padtb10 tlleft disblk";
				document.getElementById(tdivid).className = "clr";
			}
		}
	}

	function siteselect(val)
	{
		if(val!=""){window.open("http://www."+val+".com/","_blank");}
	}

