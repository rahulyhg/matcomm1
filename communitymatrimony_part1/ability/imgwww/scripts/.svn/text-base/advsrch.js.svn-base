function coun_moveOptions(theSelFrom, theSelTo)
{
	var selLength = theSelFrom.length;
	var selId		= theSelFrom.id;
	var selectedText = new Array();
	var selectedValues = new Array();
	var selectedCount = 0;
	var w;
	for(w=selLength-1; w>=0; w--)
	{
		if(theSelFrom.options[w].selected)
		{
			selectedText[selectedCount] = theSelFrom.options[w].text;
			selectedValues[selectedCount] = theSelFrom.options[w].value;
			deleteOption(theSelFrom, w);
			if(selId == 'arrCountry' && (selectedValues[selectedCount] == 98 || selectedValues[selectedCount]==222)) {
				$('statesblock').style.display = "block";
				coun_updatestate(selectedValues[selectedCount],'arrResidingState','states',theSelFrom);
			} else if(selId == 'country' && selLength==1) {
				$('arrResidingState').innerHTML='';$('residingState').innerHTML='';$('arrResidingCity').innerHTML='';$('residingCity').innerHTML='';
				$('statesblock').style.display = "none";
				$('cityblock').style.display = "none";
			}  else if(selId == 'country' && selLength!=1 && (selectedValues[selectedCount]==222 || selectedValues[selectedCount]==98)) {
				coun_updatestate(selectedValues[selectedCount],'arrResidingState','states',theSelFrom);
				$('residingState').innerHTML = '';$('cityblock').style.display = "none"; $('arrResidingCity').innerHTML='';$('residingCity').innerHTML='';
			} else if(selId == 'arrResidingState' ) {
				coun_updatecity(selectedValues[selectedCount],'arrResidingCity','cities',theSelFrom);
			} else if(selId == 'residingState' && selLength==1){
				$('cityblock').style.display = "none";
			} else if(selId == 'residingState' && selLength!=1){
				//city_moveOptions(theSelFrom, theSelTo, document.advSearchForm);
			}
			selectedCount++;
		}
	}
	for(x=selectedCount-1; x>=0; x--) { addOption(theSelTo, selectedText[x], selectedValues[x]); }
	if(NS4) history.go(0);
}//moveOptions
function coun_clear(theSelFrom,theSelBlock) {
	var selLength = theSelFrom.length;
	if(selLength==0) { $(theSelBlock).style.display = "none"; }
	else { $(theSelBlock).style.display = "block"; }
}
function coun_updatecity(j,obj,aryname,selOption)
{
	var aryname=eval(aryname);
	var obj1=$(obj);
	var selId	= selOption.id;
	var k = j;
	if(j.substr(0,2)==98)
	{
		for (var i=0; i<aryname[j].length; i++) {
			if(j==k && selId=='residingState') {
			} else {
			$('cityblock').style.display = "block";
			addOption(obj1,aryname[j][i].split("|")[0],aryname[j][i].split("|")[1]); 
			}
		}
	}
}
function coun_updatestate(j,obj,aryname,selOption)
{	
	var aryname = eval(aryname);
	var selId	= selOption.id;
	var selLength = selOption.length;
	var obj1=$(obj);
	var optionexits = '';
	if(selId=='country') {
		for(i=selLength-1; i>=0; i--) { var optionexits = optionexits +  '~~' + selOption.options[i].value; }
		optionexits = optionexits+'~~';
		$(obj).innerHTML = '';
		var optindexists = optionexits.search(/~98~/);
		var optusexists  = optionexits.search(/~222~/);
		if(optindexists != -1 && optusexists== -1) { 
		j=98;
		for(var i=0; i<aryname[j].length; i++) { 
		addOption(obj1,aryname[j][i].split("|")[0],aryname[j][i].split("|")[1]); 
		}
		}
		else if(optindexists == -1 && optusexists!= -1) { j=222;for (var i=0; i<aryname[j].length; i++) {	addOption(obj1,aryname[j][i].split("|")[0],aryname[j][i].split("|")[1]); 
		}}
		else {$('statesblock').style.display = "none";$(obj).innerHTML = '';}
	} else {
		for (var i=0; i<aryname[j].length; i++) { 
		addOption(obj1,aryname[j][i].split("|")[0],aryname[j][i].split("|")[1]); 
		}
	}
}  
function city_moveOptions(theSelFrom, theSelTo, theForm)
{
	var selLength=theSelFrom.length;
	var cselectedText=new Array();
	var cselectedValues=new Array();
	var cselectedCount=0;
	var cou;
	var ii,z;
	
	for(ii=selLength-1; ii>=0; ii--) {
		if(theSelFrom.options[ii].selected) {
			cselectedText[cselectedCount]=theSelFrom.options[ii].text;
			cselectedValues[cselectedCount]=theSelFrom.options[ii].value;
			cselectedCount++;
		}
	}
	coun_moveOptions(theSelFrom, theSelTo);
	for(d=cselectedCount-1; d>=0; d--) {
		var stobj=cselectedValues[d];
		if(stobj.substr(0,2)==98) {
		for (t=0;t<cities[stobj].length;t++) {
			for (k=0;k<theForm.arrResidingCity.length;k++) {
				if (theForm.arrResidingCity.options[k].value==cities[stobj][t].split("|")[1])
				{theForm.arrResidingCity.remove(k);}
			}
			for (g=0;g<theForm.residingCity.length;g++) {
				if (theForm.residingCity.options[g].value==cities[stobj][t].split("|")[1])
				{theForm.residingCity.remove(g);}
			}
		}
		}
	}
	var selectedCount=0;
	for(z=selLength-1; z>=0; z--) { if((theSelFrom.options[z] != null) && (theSelFrom.options[z].selected)) { deleteOption(theSelFrom,z);selectedCount++; } }//for	
	state_based_enable_disable(theSelFrom);
	if(NS4) history.go(0);
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
function occupChg(occupVal) { if(occupVal==5) { $('occupblock').style.display = "none"; } else { $('occupblock').style.display = "block"; } }