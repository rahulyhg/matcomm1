var http = null;var con_http = null;var keep_http = null;var kill_http=null;var lout_http=null;var ping;var an_ping;var kill_ping;var ck_flag=false;

var log_info=GetCookie("loginInfo");
var mpg_ck=0;

if(log_info!=null){find_gen=log_info.split('^|');}


function msgn_getHTTPObject() {
	var http = false;
	//Use IE's ActiveX items to load the file.
	if(typeof ActiveXObject != 'undefined') {
		try {http = new ActiveXObject("Msxml2.XMLHTTP");}
		catch (e) {
			try {http = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (E) {http = false;}
		}
	//If ActiveX is not available, use the XMLHttpRequest of Firefox/Mozilla etc. to load the document.
	} else if (XMLHttpRequest) {
		try {
			http = new XMLHttpRequest();
		}
		catch (e) {http = false;}
	}
	return http;
}

function msgtimesetc(name,value){document.cookie=name+"="+escape(value)+";DOMAIN="+varConfArr['domainname']+";PATH=/"}
function getcurrent_time(){var today=new Date();return today.getTime();}

function anonConnection() {
	var time=getcurrent_time();
	if (GetCookie('first_time')==null)
	{
		msgtimesetc('first_time',time);msgtimesetc('rnd_time',time);mpg_ck=time;
	}
	else
	{
		var t_app=GetCookie('first_time')+"-"+time;
		msgtimesetc('first_time',t_app);
		msgtimesetc('rnd_time',time);mpg_ck=time;
	}
	keep_alive();
}

function keep_alive() 
{
	try
	{
		if(mpg_ck==GetCookie('rnd_time'))
		{
			clearTimeout(ping);
			var packet;
			keep_http =msgn_getHTTPObject();
			if(find_gen[1]==1){pgen="M";}else{pgen="F";}
			packet= "type=kpoll&domainname="+varConfArr['DOMAINCASTEID']+"&from="+msgn_myid+"&gender="+pgen+"&trand="+genNumbers();
			url   = varConfArr['domainweb']+"/http-bind/";
			keep_http.open("POST", url, true);
			keep_http.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
			keep_http.setRequestHeader("Content-length", packet.length);
			keep_http.setRequestHeader("Connection", "close");
			keep_http.onreadystatechange =keep_respon ;keep_http.send(packet);
		}
		else{ping=setTimeout('keep_alive();',30000);}
	} catch(e) {}
}

function keep_respon(){	try{if(keep_http.readyState == 4 && keep_http.status==200) {process();}} catch(e) {}	}

function process()
{
var wh_msg="";
	if(keep_http.responseText!=null && keep_http.responseText!="")
		{
			keep_txt=keep_http.responseText;keep_txt=keep_txt.replace(/\n/g, "");

			if(keep_txt.indexOf('|')!=-1)
			{
				var keep_pipe=keep_txt.split('|');

				for(i=0;i<keep_pipe.length;i++)
				{
					if(keep_pipe[i].indexOf('~')!=-1)
					{
						var keep_til=keep_pipe[i].split('~');
						for(j=1;j<keep_til.length;j++)
						{if(keep_til.length>2){wh_msg=wh_msg+keep_til[j]+'~';}else{wh_msg=keep_til[j];}}
						
						/*if(keep_til[0]=="INFO")
						{sh_fx(wh_msg);}
						else{launch_auto(msgn_myid,keep_til[0],wh_msg);}*/
						if(wh_msg!="#block#" && wh_msg!="#out#")
						{launch_auto(msgn_myid,keep_til[0],wh_msg);}
					}
				}
			}
			else
			{

				if(keep_txt.indexOf('~')!=-1)
					{
						var keep_til=keep_txt.split('~');
						for(j=1;j<keep_til.length;j++)
						{
							if(keep_til.length>2)
							{
								if(wh_msg=="")
								{wh_msg=keep_til[j];}else{wh_msg+='~'+keep_til[j]};

							}else{wh_msg=keep_til[j];}
						}

						/*if(keep_til[0]=="INFO"){sh_fx(wh_msg);}
						else{launch_auto(msgn_myid,keep_til[0],wh_msg);}*/
						if(wh_msg!="#block#" && wh_msg!="#out#")
						{launch_auto(msgn_myid,keep_til[0],wh_msg);}
						
					}
			}
		}
	ping=setTimeout('keep_alive();',30000);
}

function re_first()
{
	var fck_val=GetCookie('first_time');var new_fck=0;

	if(fck_val.indexOf('-')!=-1)
	{
		var fck_arr=fck_val.split("-");
		for(m=0;m<fck_arr.length;m++)
		{
			if(fck_arr[m]!=mpg_ck)
			{
				if(new_fck==0){new_fck=fck_arr[m]}else{new_fck="-"+fck_arr[m]}
			}
		}
		msgtimesetc('first_time',new_fck);
		if(new_fck.indexOf('-')!=-1)
		{
			var new_fck_val=new_fck.split("-");msgtimesetc('rnd_time',new_fck[new_fck.length-1]);
		}
		else
		{msgtimesetc('rnd_time',new_fck);}	
	}
	else
	{Delete_Cookie( 'first_time', '/' );Delete_Cookie( 'rnd_time', '/' );}
}

function Delete_Cookie( name, path ) 
{
	if (GetCookie(name)!=null) {document.cookie = name + "=" +( ( path ) ? ";path=" + path : "") +( ( findloc() ) ? ";domain=" + findloc() : "" );}
}


window.onunload=re_first;

var ie=document.all
var ieNOTopera=document.all&&navigator.userAgent.indexOf("Opera")==-1

var kill=0;
function kill_win(){
try{
		//alert(GetCookie("closewin"));
		if(GetCookie("closewin")!=null && GetCookie("closewin")!="null")
		{
		if(kill==0)
		{
		clearTimeout(kill_ping);
		kill=1;
		kill_http =msgn_getHTTPObject();
		if(find_gen[1]==1){pgen="M";}else{pgen="F";}
		packet="type=stopmpoll&domainname="+varConfArr['DOMAINCASTEID']+"&from="+msgn_myid+"&gender="+pgen+"&buddyid="+GetCookie("closewin");
		url   = varConfArr['domainweb']+"/http-bind/";
		kill_http.open("POST", url, true);
		kill_http.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
		kill_http.setRequestHeader("Content-length", packet.length);
		kill_http.setRequestHeader("Connection", "close");
		kill_http.onreadystatechange = kill_respon;
		kill_http.send(packet);
		}
		}
	else
	{kill_ping=setTimeout("kill_win();",10000);}
}catch (e){}
}




function kill_respon() {
	try{ 		
		if(kill_http.readyState == 4) 
		{msgtimesetc("closewin","null");kill=0;kill_ping=setTimeout("kill_win();",10000);}
	} 
	catch (e) {}
}

kill_ping=setTimeout("kill_win();",10000);