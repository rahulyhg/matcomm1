var tab="",objUpdateCookie='';

function funMyHome(url,tab1,all_view) {
	//for views clear
	sr_vi_ty	= '';
	if(myhome_pre_vi != 1 && all_view == ''){
		var pre_div  = 'view'+myhome_pre_vi+'n';
		var pre_fdiv = 'view'+myhome_pre_vi+'f';
				
		//view iniation for every tab
		myhome_pre_vi=1;
	}
	else if(all_view != '')
	{
		//view initation
		sr_vi_ty = all_view;
		myhome_pre_vi = all_view;
		all_view = '';
	}
	
	//for paging clear
	$("prevnext").innerHTML = '';
	$("prevnext").innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	
	myhome_tot_recs=0;
	myhome_tot_pg=0;
	myhome_cur_pg='';
	myhome_curr_file='';
	myhome_opt='';
	prev_divno = '';
	getMyhomeResult(url, tab1);
}

function funUpdateCookie()
{
	objUpdateCookie = AjaxCall();
	param = 'a=1';
	AjaxPostReq(ser_url+'/login/updatemessagescookie.php?'+Math.random(), param, funCookieResult, objUpdateCookie);
}

function funCookieResult(){}

function reLoadMyHome(argUrl,tabId,OpenTab,Sub) {
	closeIframe('iframeicon','icondiv');
	funMyHome(argUrl,tabId,OpenTab,Sub);
}