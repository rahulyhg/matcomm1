var norecent_msg = 'Currently there are no profiles in your Recently viewed list.';
var osr_tot_recs, osr_tot_pg, osr_cur_pg, ocurr_file, ojson_arr, owhole_cont, orgt_ic, osr_vi_ty, opre_vi, onew_pg_no;
function show_top_tabs(d) {
		$('RecArea').innerHTML = '';
		if(d=='sr2') {
			$BN('sr1','b'); $BN('sr2','n');
			$BN('norecdiv','b');
			if(cook_id!="") {
				$BN('rv1','b'); $BN('rv2','n');
			}
			if($('disp_div').innerHTML!='') { $BN('disp_div','b');}
			show_test_div('b');
		} else if(d=='rv1' || d=='rv2') {
			$BN('sr1','n'); $BN('sr2','b');
			$BN('rv1','n'); $BN('rv2','b');
			$BN('norecdiv','n');
			if($('disp_div').style.display=='block') { $BN('disp_div','n');}
			if(d=='rv1'){show_test_div('n');}else if(d=='rv2'){show_test_div('n2');};
		}
}

function del_rec(){
	var a;a=findchk('~','buttonfrm');
	url	= 'search/delrecent.php?id='+a;
	funIframeURL(url,'450','100','iframeicon','icondiv');
}

function show_test_div(t) {	
	if(t=='n' || t=='n2') {			
		$BN('recent_div','b');
		$BN('search_div','n');
		$BN('viewprof_div','n');
		$('serResArea').innerHTML = '';
		getRecent(t);
	}
	if(t=='b') {
		sr_tot_recs = osr_tot_recs;
		sr_tot_pg   = osr_tot_pg;
		sr_cur_pg   = osr_cur_pg;
		curr_file   = ocurr_file;
		json_arr    = ojson_arr;
		whole_cont  = owhole_cont;
		rgt_ic	    = orgt_ic;
		sr_vi_ty    = osr_vi_ty;
		pre_vi      = opre_vi;
		new_pg_no   = onew_pg_no;
		if(sr_tot_pg > 0){
			sr_paging_cont();build_template('serResArea', 'Srh');
			if(document.buttonfrm.chk2[2].checked==true) { multi_chk();document.buttonfrm.chk2[3].checked=true;}
		}
		$BN('recent_div','n');
		$('RecArea').innerHTML = '';
		if($('disp_div').style.display=='none' && sr_tot_pg > 0) {
			$BN('search_div','b');$BN('viewprof_div','n');
		}
	}
}

function getRecent(rec_fl)
{
	url		= ser_url+'/basicview/bv_ctrl.php?rno='+Math.random();
	recCook = getCookie('lastViewProfile');
	
	if(rec_fl == 'n'){
	osr_tot_recs= sr_tot_recs;
	osr_tot_pg	= sr_tot_pg;
	osr_cur_pg	= sr_cur_pg;
	ocurr_file	= curr_file;
	ojson_arr	= json_arr;
	owhole_cont	= whole_cont;
	orgt_ic		= rgt_ic;
	osr_vi_ty	= sr_vi_ty;
	opre_vi		= pre_vi;
	onew_pg_no	= new_pg_no;
	}

	if(recCook != '')
	{
		recArr = recCook.split('~');
		recLen = recArr.length;
		recCond= 'WHERE MatriId IN(';
		for(i=0; i<recLen; i++){
		recCond += "'"+recArr[i]+"', ";
		}
		recStrlen = recCond.length;
		recCond = recCond.slice(0, recStrlen-2)+')';
		param	= 'WhereCond='+recCond+'&Cnt=S&RIC=Y&Page=&view=1';
		objAjax1 = AjaxCall();
		AjaxPostReq(url, param, RecDisp,objAjax1);
	}else{
	$('disp_expdiv0').style.display = 'none';$('disp_expdiv1').style.display = 'none';
	$('norecent').innerHTML = norecent_msg;
	}
}

function RecDisp()
{
	var restxt;
	if(objAjax1.readyState == 4)
	{
		restxt		= (objAjax1.responseText).split('#^~^#');
		sr_vi_ty	= restxt[0];
		rgt_ic		= restxt[1];
		sr_tot_recs	= restxt[2];
		sr_tot_pg	= restxt[3];
		sr_cur_pg	= restxt[4];
		curr_file	= restxt[5];
		
		if(sr_tot_recs > 0){
		for(k=0;k<2;k++){document.buttonfrm.chk2[k].checked = false;}
		$('RecArea').innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
		json_arr	= eval(restxt[6]);
		build_template('RecArea', 'Srh');
		sr_paging_cont();
		$('recent_div').style.display = 'block';
		$('norecent').innerHTML = 'Displayed below are the most recently viewed profiles.';
		$('disp_expdiv0').style.display = 'block';$('recbut').style.display = 'block';$('disp_expdiv1').style.display = 'block';$('recbut1').style.display = 'block';
		}else{
		$('recent_div').style.display = 'none';
		$('norecent').innerHTML = norecent_msg;
		}
	}
}