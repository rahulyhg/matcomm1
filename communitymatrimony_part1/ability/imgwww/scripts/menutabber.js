<!--
cookEnable = '';
function clickTab(tabNo,tabTotal,tabName)
{
	
	var cur_act = tabName+"link"+tabNo+"_active";
	var cur_inact = tabName+"link"+tabNo+"_inactive";
	var cur_tab	= tabName+tabNo;
	document.getElementById(cur_act).style.display='block';
	document.getElementById(cur_inact).style.display='none';
	
	for(i=1;i<=tabTotal;i++)
		{
		if(i != tabNo)
			{
			var oth_act = tabName+"link"+i+"_active";
			var oth_inact = tabName+"link"+i+"_inactive";
			var oth_tab	= tabName+i;
			document.getElementById(oth_act).style.display='none';
			document.getElementById(oth_inact).style.display='block';
			}
		}
	if(cookEnable == '')
	{
		showTab(tabNo,tabTotal,tabName);
	}
	var url=location.href;
	var findstr=url.indexOf('www.');
	if(findstr!=-1){equaldiv();}
}
function showTab(tabNo,tabTotal,tabName)
{
	var cur_tab_content = tabName+"_content_"+tabNo;
	document.getElementById(cur_tab_content).style.display="block";
	for(i=1;i<=tabTotal;i++)
		{
		if(i != tabNo)
			{
			var oth_tab_content = tabName+"_content_"+i;
			document.getElementById(oth_tab_content).style.display="none";
			}
		}
}

function findCookie(name) {
	var nameEQ=name+"=";
	var ca=document.cookie.split(";");
	for(var i=0;i < ca.length;i++) {
		var c=ca[i];
		while (c.charAt(0)==" ") c=c.substring(1,c.length);
		if(c.indexOf(nameEQ)==0) return c.substring(nameEQ.length,c.length);
	} return "err";
}

function cookieChecker(moduleName)
{
	cookResult = '';
	//cookResult = findCookie('LOGININFO');
	if(cookResult != "err")
	{
		if(moduleName == 'SL')
		{
			getshortlist();
		}
		else if(moduleName == 'IL')
		{
			getignoredlist()
		}
		else if(moduleName == 'BL')
		{
			getblocklist();
		}
		else if(moduleName == 'ALT')
		{
			MakeGetRequest('http://'+DOMAINARRAY['domainmodule']+'/modify/mailmanager.php',eiacceptshow);
		}
		else if(moduleName == 'PSWD')
		{
			val_field();
		}
		else if(moduleName == 'DEACT')
		{
			deactprof();hide_but();	
		}		
	}
	else
	{
		cookEnable = 'NO';
		document.getElementById('middleContent').innerHTML = '<div class="smalltxt" style="padding-left:8px;">You are either logged off or your session timed out. <a href="http://'+DOMAINARRAY['domainmodule']+'/login/login.php" class="clr1">Click here</a> to login.</div><br clear="all">';
	}
}
var rp_equaldiv=1;
function equaldiv() {
	if($("rightnavh")){
	//$("spacedivmid").style.height=spdivh;
	//rp_equaldiv=2;
	//makeequal1('middlediv','rightnavh');
	}
} 
//-->