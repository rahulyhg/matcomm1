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

function viewdet(phoneVal,voiceVal,matrirefVal,videoVal,HoroVal,matid,phlock,vidlock,holock){
var hrefurl="javascript:;";
var reg_lnk= ser_url+'/register/index.php?act=addbasic&';
var phcont   = '',vcont = '',mcont = '',vicont ='',hocont='';
var ph_txt='',vi_txt='',ho_txt='';

if(phoneVal =="1"){
	if(cook_id != ''){
	phref = "href='"+hrefurl+"' onClick=\"funIframeURL('phone/phoneview.php?id="+matid+"','500','285','iframeicon','icondiv')\"";
	}else{
	phref = "href='"+reg_lnk+'req=vph&oid='+matid+"'";
	}

	if(phlock == 1){
	ph_txt = '<img src="'+imgs_url+'/protect-icon.gif" title="phone protected" hspace="5">';
	}

	phcont = '<li><a '+phref+' class="smalltxt clr1 usricons phoneicon">Phone'+ph_txt+'</a></li>&nbsp;';
}
if(voiceVal=="1"){
	if(cook_id != ''){
	vhref = "href='"+hrefurl+"' onClick=\"funIframeTools('voice/voiceshow.php?ID="+matid+"','525','570','iframeicon','icondiv')\"";
	}else{
	vhref = "href='"+reg_lnk+'req=vvo&oid='+matid+"'";
	}
	vcont = '<li><a '+vhref+' class="smalltxt clr1 usricons voiceicon">Voice</a></li>&nbsp;';
}
if(videoVal=="1"){
	if(cook_id != ''){
	vihref = "href='"+hrefurl+"' onClick=\"funIframeURL('video/videoverifyview.php?ID="+matid+"','525','222','iframeicon','icondiv')\"";
	}else{
	vihref = "href='"+reg_lnk+'req=vve&oid='+matid+"'";
	}

	if(vidlock == 1){
	vi_txt = '<img src="'+imgs_url+'/protect-icon.gif" title="video protected" hspace="5">';
	}

	vicont = '<li><a '+vihref+' class="smalltxt clr1 usricons videoicon">Video'+vi_txt+'</a></li>&nbsp;';
}
if(HoroVal=="1"){
	hohref = "href='"+hrefurl+"' onClick=\"openWin('"+img_url+'/horoscope/viewhoroscope.php?ID='+matid+"','626','600')\"";
	if(holock == 1){
	ho_txt = '<img src="'+imgs_url+'/protect-icon.gif" title="horoscope protected" hspace="5">';
	}

	hocont = '<li><a '+hohref+' class="smalltxt clr1 usricons horoscopeicon">Horoscope'+ho_txt+'</a></li>&nbsp;';
}
if(matrirefVal=="1"){
	if(cook_id != ''){
	mhref = "href='"+hrefurl+"' onClick=\"funIframeTools('reference/referenceview.php?id="+matid+"','500','550','iframeicon','icondiv')\"";
	}else{
	mhref = "href='"+reg_lnk+'req=vref&oid='+matid+"'";
	}
	mcont = '<li><a '+mhref+' class="smalltxt clr1 usricons referenceicon">Reference</a></li>&nbsp;';
}

tot_vi_cont = phcont + vcont + mcont + vicont + hocont;
ret_view    = '<div class="fleft smalltxt boldtxt" style="padding:0px 0px 0px 10px;">View Details:</div><div class="fleft" style="padding:0px 0px 0px 10px;"><ul class="usractions">'+tot_vi_cont+'</ul></div><br clear="all">';
return ret_view;
}

function disp_tph(tph_name, tph_div, div_no, div_prefix)
{
	ph_div = div_prefix+'PH'+div_no;
	topval = findPosY($(ph_div));
	tph_path = pho_url+'/'+tph_name.substring(3,4)+'/'+tph_name.substring(4,5)+'/'+tph_name;
	$(tph_div).innerHTML	= '<img src="'+tph_path+'" height="150" width="150">';
	$(tph_div).style.top	= topval+'px'; 
	$(tph_div).style.display= 'block'; 
}

function hide_tph(tph_div)
{
	$(tph_div).style.display	= 'none'; 
}

function photoPaging(ph_det, tph_det, curr_ph, tot_ph, div_no, view, div_prefix)
{
	var	pagingCont='', prev, next, prev_pg, next_pg;

	if(curr_ph<1){curr_ph =1;}
	if(curr_ph>tot_ph){curr_ph =tot_ph;}

	var pre='<div style="padding:5px 0px 0px 15px;">';
	var inter='<div class="phnumpadd smalltxt fleft" style="padding-top:1px;">'+curr_ph+'&nbsp;of&nbsp;'+tot_ph+'</div>';

	if(curr_ph>1) {
		var prev_pg = parseInt(curr_ph)-1;	
		prev='<div class="fleft vc6pd-top"><a href="javascript:;" onClick="javascript:first_photo(\''+ph_det+"','"+tph_det+"','"+div_no+"', '"+prev_pg+"','"+view+"','N','"+div_prefix+"');\"><div class='useracticonsimgs phnavlfton'></div></a></div>";
	} else {
		prev='<div class="fleft vc6pd-top"><div class="useracticonsimgs phnavlftoff"></div></div>';
	}


	if(curr_ph<tot_ph) {
		var next_pg = parseInt(curr_ph)+1;	
		next='<div class="fleft vc6pd-top"><a href="javascript:;" onclick="javascript:first_photo(\''+ph_det+"','"+tph_det+"','"+div_no+"','"+next_pg+"','"+view+"','N','"+div_prefix+"');\"><div class='useracticonsimgs phnavrigon'></div></a></div>";
	} else { 
		next='<div class="fleft vc6pd-top"><div class="useracticonsimgs phnavrigoff"></div></div>';
	}

	pagingCont = pre+prev+inter+next+'</div>';
	return pagingCont;
}

function first_photo(ph_det, tph_det, div_no, ph_no, view, ret_flag, div_prefix)
{
	var arrPhotos	= ph_det.split('^');
	var arrTPhotos	= tph_det.split('^');
	var totPhotos	= arrPhotos.length;
	var on_mou_act	= '';
	var photo_no	= parseInt(ph_no)-1;
	var photoid    = arrPhotos[photo_no].split('_');

	on_mou_act = 'onclick="openWin(\''+img_url+'/photo/viewphoto.php?ID='+photoid[0]+'&PNO='+ph_no+'\',\'780\',\'600\');"';
	if(parseInt(view) == 1){
	on_mou_act += 'onmouseover="disp_tph(\''+arrTPhotos[photo_no]+'\',\''+div_prefix+'TP'+div_no+'\',\''+div_no+'\',\''+div_prefix+'\');" onmouseout="hide_tph(\''+div_prefix+'TP'+div_no+'\');"';
	}

	ph_folder= arrPhotos[photo_no].substring(3,4)+'/'+arrPhotos[photo_no].substring(4,5)+'/';
	ph_cont = '<a href="javascript:;"><img src="'+pho_url+'/'+ph_folder+arrPhotos[photo_no]+'" alt="" '+on_mou_act+' border="0" height="75" width="75"></a>';

	if(sr_vi_ty <= 2)
	{
		if(totPhotos > 1 ){
		//paging called here
		var pag_cont = photoPaging(ph_det, tph_det, ph_no, totPhotos, div_no, view, div_prefix);
		if(ret_flag == 'Y')
		{
			return ph_cont+'~'+pag_cont;
		}
		else
		{
			//replace display photo area
			repl_div = div_prefix+'PH'+div_no;
			$(repl_div).innerHTML = ph_cont;

			//replace photo paging area
			repl_div = div_prefix+'PP'+div_no;
			$(repl_div).innerHTML = pag_cont;	
		}
		}//if- total >1
		else{return ph_cont+'~';}
	}
	else
	{
		return ph_cont;
	}
}

function div_photo(gen_det, mem_id, mem_user)
{
	var lf="<a href='"+ser_url+"/register/index.php?act=addbasic&req=pho&oid="+mem_id+"'>";
	if(gen_det=='R1') {
		if(cook_id=='') {
			return lf+"<div class='useracticonsimgs photorequestm'></div></a>";
		} else {
			return "<a href='javascript:;' onclick=\"funIframeURL('request/request.php?id="+mem_id+"&rid=1','500','265','iframeicon','icondiv');\"><div class='useracticonsimgs photorequestm'></div></a>";
		}
	} else if(gen_det=='R2') {
		if(cook_id=='') {
			return lf+"<div class='useracticonsimgs photorequestf'></div></a>";
		} else {
			return "<a href='javascript:;' onclick=\"funIframeURL('request/request.php?id="+mem_id+"&rid=1','500','265','iframeicon','icondiv');\"><div class='useracticonsimgs photorequestf'></div></a>";
		}
	} else if(gen_det=='P') {
		return "<a href='javascript:;' onclick=\"openWin('/photo/photoviewpassword.php?ID="+mem_id+"&UNAME="+mem_user+"','550','220');\"><div class='useracticonsimgs photoprotected'></div></a>";		
	}
}

function build_template(resdiv, mod_name)
{	
	var new_mod_name = '';
	var div_prefix	 = 'S';
	if(mod_name.substring(0,2)=='IR' || mod_name.substring(0,2) == 'IS')
	{
		new_mod_name = 'INT';div_prefix	= 'I';
	}
	else if(mod_name.substring(0,2) =='MR' || mod_name.substring(0,2) == 'MS')
	{
		new_mod_name = 'MSG';div_prefix	= 'M';
	}
	else if(mod_name.substring(0,2) =='RR' || mod_name.substring(0,2) == 'RS')
	{
		new_mod_name = 'REQ';div_prefix	= 'R';
	}
	else if(mod_name.substring(0,2) =='LI')
	{
		new_mod_name = 'LIST';div_prefix	= 'L';
	}
	else if(mod_name=='PHV')
	{
		new_mod_name = 'VIEW';div_prefix	= 'V';
	}
	else if(mod_name.substring(0,2)=='PM')
	{
		new_mod_name = 'Srh';div_prefix	= 'P';
	}

	
	if(new_mod_name != ''){
		rgt_ic = 'Y';
		var msg_arr		= eval(myhome_json_msg_arr);
		var msg_len		= msg_arr.length;
		
		var formated_arr= new Array();
		var top_cont_arr= new Array();
		var bot_cont_arr= new Array();
		var prof_gen;
		for(j=0; j<msg_len; j++){
			formated_arr[j] = json_msg_bv_arr[msg_arr[j]['OID']];
			prof_gen = json_msg_bv_arr[msg_arr[j]['OID']]['G'];
			publ	 = json_msg_bv_arr[msg_arr[j]['OID']]['PU'];
			if(new_mod_name == 'INT'){
			bot_cont_arr[j]	= int_getBot(msg_arr[j], mod_name, publ);
			ID_det			= msg_arr[j]['IntID'];
			}
			else if(new_mod_name == 'MSG'){
			bot_cont_arr[j]	= msg_getBot(msg_arr[j], mod_name, publ);
			ID_det			= msg_arr[j]['MailID'];
			}
			else if(new_mod_name == 'REQ'){
			ID_det			= msg_arr[j]['RID'];
			bot_cont_arr[j] = '';
			}
			else if(new_mod_name == 'LIST'){
			ID_det			= msg_arr[j]['OID'];
			bot_cont_arr[j]	= list_getBot(msg_arr[j], mod_name);
			}
			else if(new_mod_name == 'VIEW'){
			bot_cont_arr[j] = view_getBot(msg_arr[j]['DV']);
			top_cont_arr[j] = '';
			}

			if(mod_name.substring(0,2) != 'PM' && mod_name != 'PHV'){
			top_cont_arr[j] = int_getTop(ID_det, msg_arr[j]['OID'], j, prof_gen, mod_name, publ);
			}
		}
		json_arr = formated_arr;
	}
	else
	{
		new_mod_name = mod_name;
	}

	var rows	= json_arr.length;
	var img_gap = '<br clear="all"><div style="height:4px;"><img src="'+imgs_url+'/trans.gif" height="4"></div>';
	var img_gap1= '<div style="width:4px;" class="fleft"><img src="'+imgs_url+'/trans.gif" width="4"></div>';
	whole_cont	= ''; 
	for(var i=0; i<rows; i++)
	{
		if(sr_vi_ty == '1'){
		if(json_arr[i]['PU'] == '1'){
		//comptability div
		var comp_div = '',top_cont='',bot_cont='';
		var pt_img	  = (json_arr[i]['PT']=='2')?'cstxt.gif':(json_arr[i]['PT']=='1')?'cptxt.gif':'';
		var div_colr  = (json_arr[i]['PT']=='2')?'vcs':(json_arr[i]['PT']=='1')?'vcp':'vc';

		var pt_cont	= '';
		if(pt_img != ''){
		pt_cont = '<img height="17" width="80" alt="" src="'+imgs_url+'/'+pt_img+'"/>';
		}

		if(json_arr[i]['PP'] != '0' && json_arr[i]['G'] != cook_gender)
		{
			comp_div = '<a href="javascript:;" onclick="funIframeURL(\'search/compatstatus.php?nam='+json_arr[i]['N']+'&user='+json_arr[i]['UN']+'&pp='+json_arr[i]['PP']+'\',\'500\',\'170\',\'iframeicon\',\'icondiv\');" class="smalltxt clr1" title="Indicates how compatible you are with this member">Compatibility status - <font class="mediumtxt boldtxt">'+json_arr[i]['PP']+'%</font></a>';
		}
		
		rightIc_arr = (json_arr[i]['RIC']).split('^');

		//View details
		view_cont = '';
		if(rightIc_arr[0] == '1' || rightIc_arr[1] == '1' || rightIc_arr[2] == '1' || rightIc_arr[3] == '1' || rightIc_arr[8] == '1'){
		view_cont = viewdet(rightIc_arr[0], rightIc_arr[1], rightIc_arr[2], rightIc_arr[3], rightIc_arr[8], json_arr[i]['ID'], rightIc_arr[4], rightIc_arr[5],rightIc_arr[9]);
		}

		//Contact Details
		if(rightIc_arr[6] == '0'){last_act = (cook_id!='')?'<br clear="all">':'';}
		else{
		cont_arr   = new Array();
		conmsg_arr = new Array();
		cont_arr['IR']='exprecd';cont_arr['IS']='expsent';cont_arr['ID']='expdec';cont_arr['MS']='msgsentmem'; cont_arr['MR']='msgrec';cont_arr['MP']='msgreply';cont_arr['MD']='msgdec';
		conmsg_arr['IR']='Interest Received';conmsg_arr['IS']='Interest Sent';conmsg_arr['ID']='Interest Declined'; conmsg_arr['MS']='Message Sent';conmsg_arr['MR']='Message Received';conmsg_arr['MP']='Message Accept';conmsg_arr['MD']='Message Declined';
		con_img=cont_arr[rightIc_arr[6]]; con_msg=conmsg_arr[rightIc_arr[6]]; 
		var last_act = '<div class="fright usractions smalltxt"><div class="fleft"><a href="javascript:;" onclick=\'javascript:funIframeURL("mymessages/contacthistory.php?ID='+json_arr[i]['ID']+'","525","350","iframeicon","icondiv")\' class="smalltxt clr1">Last Activity</a></div>';
		last_act +=	'<div class="fleft" style="padding-left:2px;"><a href="javascript:;" onclick=\'javascript:funIframeURL("mymessages/contacthistory.php?ID='+json_arr[i]['ID']+'","525","350","iframeicon","icondiv")\' class="usricons '+cont_arr[rightIc_arr[6]]+'"><img src="'+imgs_url+'/trans.gif" width="1" style="height:1px !important;height:16px;"></a></div><div class="fleft clr5">'+conmsg_arr[rightIc_arr[6]]+' : '+ Decode_it(rightIc_arr[7])+'</div></div><br clear="all">';
		}

		//start div
		start_div = '<div class="vc1 '+div_colr+'"><div class="vcpad"><div class="vc-dl"><div class="fleft smalltxt clr1">'+comp_div+'</div>'+last_act;

		//photo & profile close div
		close_div = '</div></div></div><br clear="all">';
		//end div
		end_div = '<br clear="all"></div></div>';

		//photo div
		photo_div = '<div class="vcpd-top"><div class="fleft"><div id="'+div_prefix+'PH'+i+'">';

		//photo part
		paging_cont	  = '<div style="padding:10px 0px 0px 0px;"></div>';
		Tphoto_div	  = '';
		if(json_arr[i]['PH'] == '')
		{
			gen_ph = 'R'+json_arr[i]['G'];
			photo_div += div_photo(gen_ph, json_arr[i]['ID'],json_arr[i]['UN']);
		}
		else if(json_arr[i]['PH'] == 'P')
		{
			photo_div += div_photo('P', json_arr[i]['ID'],json_arr[i]['UN']);
		}
		else 
		{
			//display photo & photo paging content for very first time
			ph_whole_cont = first_photo(json_arr[i]['PH'],json_arr[i]['TPH'],i,1,1,'Y', div_prefix);
			ph_whole_arr  = ph_whole_cont.split('~');
			pho_cnt       = ph_whole_arr[0];
			paging_cont	  = ph_whole_arr[1];
			if(paging_cont == ''){paging_cont = '<div style="padding: 10px 0px 0px;"></div>';}
			photo_div += pho_cnt;
			if(screen.width<1024){pxs='125px';}
			else if(screen.width==1024){pxs='236px';}
			else if(screen.width>1024){pxs='365px';}
			Tphoto_div = '<div style="position:absolute;left:'+pxs+';" id="'+div_prefix+'TP'+i+'"></div>';
		}

		photo_div += '</div>';
		photo_div += Tphoto_div; 

		paging_div = '<div id="'+div_prefix+'PP'+i+'">'+paging_cont+'</div>';
		photo_div += paging_div+'</div>'; 

		//profile detail div
		bmark_div = '';
		ignor_div =	'';
		block_div = '';
		onli_div  = '';
		onli_msg  = 'Within last ';

		//get online
		onli_res = Decode_it(json_arr[i]['ON']);
		if(onli_res == 'NOW')
		{
			onli_msg  = 'Online Right NOW!';
			if(cook_id=='') {
			onli_div  = '<a href="'+ser_url+'/register/index.php?act=addbasic&oid='+json_arr[i]['ID']+'&req=ch" target="_blank"><img src="'+imgs_url+'/online.gif" border="0" height="17" width="53"></a>';
			} else {
				if(cook_gender== json_arr[i]['G']) {
					onli_div  = '<img src="'+imgs_url+'/online.gif" border="0" height="17" width="53">';
				} else {
					if(cook_paid == 1){
					tar_txt='';
					on_txt = 'javascript:launchIC(\''+cook_un+'\',\''+json_arr[i]['UN']+'\')';
					}else{
						tar_txt= ' target="_blank" ';
						on_txt = ser_url+'/payment/';
					}

					onli_div  = '<a href="'+on_txt+'"'+tar_txt+'><img src="'+imgs_url+'/online.gif" border="0" height="17" width="53"></a>';			
				}
			}
		}
		else
		{
			onli_msg  += onli_res;
		}

		var icon_arr = new Array(); //dhanapal(20080905)
		//get icon detail
		if(json_arr[i]['IC'] != null)
		{
			icon_arr = (json_arr[i]['IC']).split('^');

			if(icon_arr[0] == '1')
			{
				bmark_div  = '<a href="javascript:void(0)" onClick="javascript:funIframeURL(\'list/listadd.php?id='+json_arr[i]['ID']+'&ed=ed&purp=shortlist\',\'420\',\'193\',\'iframeicon\',\'icondiv\');"><div class="useracticonsimgs shortlist pntr" style="float:left;padding: 0px 0px 0px 3px;" title="This member is currently in your Shortlist"></div></a>';
			}

			if(icon_arr[1] == '1')
			{
				ignor_div  = '<a href="javascript:void(0)" onClick="javascript:funIframeURL(\'list/listadd.php?id='+json_arr[i]['ID']+'&ed=ed&purp=ignore\',\'420\',\'193\',\'iframeicon\',\'icondiv\');"><div class="useracticonsimgs ignore" style="float:left;padding: 0px 0px 0px 3px;" title="This member is currently in your ignore list"></div></a>';
			}

			if(icon_arr[2] == '1')
			{
				block_div  = '<a href="javascript:void(0)" onClick="javascript:funIframeURL(\'list/listadd.php?id='+json_arr[i]['ID']+'&ed=ed&purp=block\',\'420\',\'193\',\'iframeicon\',\'icondiv\');"><div class="useracticonsimgs block fleft" style="float:left;padding: 0px 0px 0px 3px;" title="This member is currently in your block list"></div></a>';
			}
		}

		//top content added here
		if(new_mod_name == 'Srh'){
		top_cont = sr_getTop(json_arr[i]['ID'], i, icon_arr[0], json_arr[i]['G']);
		bot_cont = sr_getBot(json_arr[i]['ID'], i, json_arr[i]['G']);
		}else{
		bot_cont = bot_cont_arr[i];
		top_cont = top_cont_arr[i];
		}

		decoded_DE = Decode_it(json_arr[i]['DE']);
		pro_arr = (decoded_DE).split('^~^');
		
		ctry = pro_arr[10];

		cas_no_cont = (pro_arr[15] == '1')? '(CasteNoBar)' : '';
		subcas_no_cont = (pro_arr[17] == '1')? '(SubcasteNoBar)' : '';
			
		reli_cont  = (pro_arr[7] !='') ? pro_arr[7] : '';
		caste_cont = (pro_arr[8] !='') ? (reli_cont!='' ? reli_cont+', '+pro_arr[8]+cas_no_cont : pro_arr[8]+cas_no_cont) : reli_cont;
		subc_cont  = (pro_arr[9] !='') ? (caste_cont!='' ? caste_cont+', '+pro_arr[9]+subcas_no_cont : pro_arr[9]+subcas_no_cont) : caste_cont;

		ctry_stat = (ctry != '' && pro_arr[11] !='' && pro_arr[11] !='0') ? pro_arr[11]+', '+ctry : ctry;
		ctry_st_ci= (ctry != '' && pro_arr[12] !='' && pro_arr[12] !='0') ? pro_arr[12]+', '+ctry_stat : ctry_stat;
		edu_de	  = (pro_arr[3]!='Others' && pro_arr[3]!='') ? ' | '+pro_arr[3] : (pro_arr[4] !='')? ' | '+pro_arr[4] : '';
		occu_de	  = (pro_arr[5]!='Others' && pro_arr[5]!='') ? ' | '+pro_arr[5] : (pro_arr[6] !='')? ' | '+pro_arr[6] : '';
		
		pro_det_div = '<div class="fleft vc1-wt"><div class="vc-padl"><div class="smalltxt"><div class="fleft" style="padding-bottom:2px;"><a href="/profiledetail/index.php?act=viewprofile&id='+json_arr[i]['ID']+'" target="_blank" class="matriidlink bold">'+Decode_it(json_arr[i]['N'])+' ('+Decode_it(json_arr[i]['UN'])+')</a>&nbsp;</div><div id="useracticons"><div id="useracticonsimgs"><div class="fleft"><div class="fleft" style="padding-left:3px">'+pt_cont+'</div><div id="shortlist'+json_arr[i]['ID']+'" style="padding: 2px 0px 0px 3px; float: left;">'+bmark_div+'</div><div id="ignore'+json_arr[i]['ID']+'" style="float: left;">'+ignor_div+'</div><div id="block'+json_arr[i]['ID']+'" style="float: left;">'+block_div+'</div></div></div></div><br clear="all"><div class="fleft smalltxt1 clr2" style="padding-top:3px">Active: '+onli_msg+' </div><div class="fleft" style="padding-left:3px">'+onli_div+'</div><br clear="all"><span style="text-align:left;">'+pro_arr[0]+' yrs,  '+pro_arr[1]+' | '+subc_cont+' | '+ctry_st_ci+edu_de+occu_de+'&nbsp;&nbsp;<a href="/profiledetail/index.php?act=viewprofile&id='+json_arr[i]['ID']+'" target="_blank" class="smalltxt clr1 fright">Full&nbsp;Profile&nbsp;&gt;&gt;</a></span></div></div></div>';

		border_div	= '';
		if(showall_fl == 'Y'){
		border_div	= '<div class="borderline" style="width:508px"><img height="1" src="'+imgs_url+'/trans.gif"/></div><br clear="all"/>';
		}

		whole_cont += top_cont + start_div + photo_div + pro_det_div + close_div + view_cont + end_div + bot_cont + border_div;
		}//publish1
		else{
			start_div  = '<div style="border:1px solid #999999;float:left;"><div style="width:504px;height:120px;text-align:center;"><div style="padding-top:50px;" class="smalltxt"><b>';
			end_div	   = '</b></div></div></div><br clear="all"><br clear="all">';
			
			unavmsg_cont='';
			if(json_arr[i]['PU']=='2'){
			unavmsg_cont= 'Username '+json_arr[i]['UN']+' is hidden.';
			}else if(json_arr[i]['PU']=='3'){
			unavmsg_cont= 'Username '+json_arr[i]['UN']+' is suspended.';
			}else if(json_arr[i]['PU']=='4'){
			unavmsg_cont= 'Username '+json_arr[i]['UN']+' is rejected.';
			}else if(json_arr[i]['PU']=='D' || json_arr[i]['PU'] == 'TD'){
			unavmsg_cont= 'The profile '+json_arr[i]['UN']+' is deleted or currently unavailable.';
			}

			bot_cont = '';
			top_cont = '';

			if(new_mod_name != 'Srh'){
			bot_cont = bot_cont_arr[i];
			top_cont = top_cont_arr[i];
			}
			
			border_div	= '';
			if(showall_fl == 'Y'){
			border_div	= '<div class="borderline" style="width:508px"><img height="1" src="'+imgs_url+'/trans.gif"/></div><br clear="all"/><br clear="all"/>';
			}

			whole_cont += top_cont + start_div + unavmsg_cont + end_div + bot_cont + border_div ;
		}//publish 2,del
		}//view 1
	}
	$(resdiv).innerHTML = whole_cont;
}