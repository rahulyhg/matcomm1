var moreLink='';
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

function first_photo(ph_det, tph_det, div_no, div_prefix)
{
	var arrPhotos	= ph_det.split('^');
	var arrTPhotos	= tph_det.split('^');
	var totPhotos	= arrPhotos.length;
	
	if(arrPhotos[0] !=''){
		photofolder = '/'+arrPhotos[0].substring(3,4)+'/'+arrPhotos[0].substring(4,5)+'/';
		photoTxt = '<img src="'+pho_url+photofolder+arrPhotos[0]+'" alt="" width="50" height="50">';
		moreLink = totPhotos>1 ? '<div style="padding-top:3px;" class="clr1 smalltxt">More Photos</div>' : '';
		return photoTxt;
	}

}

function div_photo(gen, mem_id)
{
	if (gen == 'P') {
		photoName = "img50_pro";
	} else {
		photoName= (gen == 1) ? 'noimg50_m' : 'noimg50_f';
	}
	photoTxt = '<img src="'+imgs_url+'/'+photoName+'.gif" alt="" width="50" height="50">';
	return photoTxt;
}
function gotoPay(){
	window.location.href = ser_url+'/payment/';
}
function build_template(resdiv, mod_name)
{	
	var div_prefix	 = 'S';
	
	var rows	= json_arr.length;
	var img_gap = '<br clear="all"><div style="height:4px;"><img src="'+imgs_url+'/trans.gif" height="4"></div>';
	var img_gap1= '<div style="width:4px;" class="fleft"><img src="'+imgs_url+'/trans.gif" width="4"></div>';
	whole_cont	= ''; 
	for(var i=0; i<rows; i++)
	{
		if(sr_vi_ty == '1'){
		if(json_arr[i]['PU'] == '1'){
		var pt_img	  = (json_arr[i]['PT']=='2')?'premium':(json_arr[i]['PT']=='1')?'premium':'';
		
		//get online
		onli_res = Decode_it(json_arr[i]['ON']);
		onli_div = '';onli_msg='Within last ';
		 if(onli_res == 'NOW')
		{
			onli_msg  = 'Online Right NOW!';
			onli_link = (cook_paid=='1')?'launchIC(\''+cook_id+'\',\''+json_arr[i]['ID']+'\')' : 'gotoPay()';
			onli_div  = '<div style="padding-top:3px;">&nbsp;<img src="'+imgs_url+'/chat_icon.gif" style="z-index:2002;" onclick="javascript:'+onli_link+';"/></div>';
		}
		else
		{
			onli_msg  += onli_res;
		} 

		decoded_DE = Decode_it(json_arr[i]['DE']);
		pro_arr = (decoded_DE).split('^~^');
		
		ctry = pro_arr[10];

		//caste related info
		cas_no_cont = (pro_arr[15] == '1')? '(CasteNoBar)' : '';
		subcas_no_cont = (pro_arr[17] == '1')? '(SubcasteNoBar)' : '';
			
		reli_cont  = (pro_arr[7] !='') ? pro_arr[7] : '';
		deno_cont  = (pro_arr[18] !='') ? (reli_cont!='' ? reli_cont+', '+pro_arr[18] : pro_arr[18]) : reli_cont;
		caste_cont = (pro_arr[8] !='') ? (deno_cont!='' ? deno_cont+', '+pro_arr[8]+cas_no_cont : pro_arr[8]+cas_no_cont) : deno_cont;
		subc_cont  = (pro_arr[9] !='') ? (caste_cont!='' ? caste_cont+', '+pro_arr[9]+subcas_no_cont : pro_arr[9]+subcas_no_cont) : caste_cont;
		subc_cont  = (subc_cont != '') ? '<font class="clr2"> | </font>'+subc_cont : '';
		ctry_stat = (ctry != '' && pro_arr[11] !='' && pro_arr[11] !='0') ? pro_arr[11]+', '+ctry : ctry;
		ctry_st_ci= (ctry != '' && pro_arr[12] !='' && pro_arr[12] !='0') ? pro_arr[12]+', '+ctry_stat : ctry_stat;
		edu_de	  = (pro_arr[3]!='Others' && pro_arr[3]!='') ? '<font class="clr2"> | </font>'+pro_arr[3] : (pro_arr[4] !='')? '<font class="clr2"> | </font>'+pro_arr[4] : '';
		occu_de	  = (pro_arr[5]!='Others' && pro_arr[5]!='') ? '<font class="clr2"> | </font>'+pro_arr[5] : (pro_arr[6] !='')? '<font class="clr2"> | </font>'+pro_arr[6] : '';
		
		starval='';
		//starval	  = pro_arr[16]==''?'':pro_arr[16]+', ';
		
		//Horoscope & compatability 
		horomatch = 'Average';
		comp_div = '<br clear="all">';
		/*if(json_arr[i]['PP'] != '0' && json_arr[i]['G'] != cook_gender)
		{
			comp_div = '<br clear="all"><div id="vpdiv4" class="smalltxt clr padtb5">Profile Match: <font class="clr1">'+json_arr[i]['PP']+'%</font>&nbsp; &nbsp; &nbsp; &nbsp;Horoscope Match: <font class="clr1">'+horomatch+'</font></div>';
		}*/

		//Photo div
		moreLink = '';
		if(json_arr[i]['PH'] == ''){	PhotoURL = div_photo(json_arr[i]['G'], json_arr[i]['ID']);}
		else if(json_arr[i]['PH'] == 'P') {	
			PhotoURL = div_photo('P', json_arr[i]['ID']);	
		}
		else {	PhotoURL = first_photo(json_arr[i]['PH'],json_arr[i]['TPH'],i,div_prefix);	}

		//Get Conatct & Features
		iconDet_arr = (json_arr[i]['RIC']).split('^')
		img_cont_det = '';
		img_phone_det= '';
		img_horo_det = '';
		if(iconDet_arr[0]=='1' || iconDet_arr[0]=='3'){img_phone_det='&nbsp;<img src="'+imgs_url+'/reqphone.gif" border="0"/>';}
		if(iconDet_arr[6]!='0' && iconDet_arr[8] !='0'){img_cont_det='<font class="smalltxt clr3">Last Activity: </font><img src="'+imgs_url+'/'+iconDet_arr[6]+'.gif"><font class="smalltxt clr"> '+Decode_it(iconDet_arr[7])+': '+iconDet_arr[8]+'</font>';}
		if(iconDet_arr[9]=='1'){img_horo_det='&nbsp;<img src="'+imgs_url+'/horoscope.gif" border="0"/>';}
		if(iconDet_arr[9]=='3'){img_horo_det='&nbsp;<img src="'+imgs_url+'/genhoros.gif" border="0"/>';}

		//Basicview divs integrating
		if(pt_img!=''){pt_img='<img src="'+imgs_url+'/'+pt_img+'.gif" height="15" width="99" />';}
		start_div = '<div class="normdiv"><div id="cont'+i+'" onmouseover="this.className=\'hoverdiv\';" onmouseout="this.className=\'\';"><div class="rpanelinner" style="border-top:1px solid #cbcbcb;"><div class="fleft" style="padding-top:2px;">'+img_cont_det+'</div><div class="fright">'+pt_img+'</div></div><div class="cleard"></div><div class="fleft padtb10" id="checkdiv" style="width:30px;">';

		if(cook_id !=''){
		start_div += '<input type="checkbox" name="chk_sr" value="'+json_arr[i]['ID']+'"/>';
		}
		start_div += '</div><div id="mesgdiv" class="fleft padtb10" style="z-index:2001;"';
		
		onclckopt = '';
		if(cook_paid!='' && cook_id !=''){
			onclckopt = 'onclick="javascript:getViewProfile(\''+json_arr[i]['ID']+"', \'"+i+'\', \'\', \'\',\'\')"';
		}else{
			onclckopt = 'onclick="javascript:getViewProfile(\'\', \''+i+'\', \'\', \'\',\'\')"';
		}
		
		start_div += onclckopt+'><div id="vpdiv1" class="fleft">';

		content_div = '<div class="normtxt clr fleft bld padb10">'+Decode_it(json_arr[i]['N'])+' ('+json_arr[i]['ID']+')'+img_phone_det+img_horo_det+'</div>'+comp_div+'<div id="vpdiv4" class="normtxt clr lh16">'+pro_arr[0]+' yrs, '+pro_arr[1]+subc_cont+' <font class="clr2">|</font> '+starval+ctry_st_ci+'  '+edu_de+' '+occu_de+'</div></div>';
		
		photo_div	= '<div id="vpdiv2" class="fleft"><div id="smphdiv1">'+PhotoURL+'</div><center>'+moreLink+onli_div+'</center></div>';

		end_div		= '</div><div class="cleard"></div></div><div id="viewpro'+i+'"></div></div><div class="cleard"></div>';
		
		whole_cont += start_div + content_div + photo_div + end_div;


		}//publish1
		else{
			start_div  = '<div class="normdiv"><div onmouseout="this.className=\'\';" onmouseover="this.className=\'hoverdiv\';" class=""><div id="mesgdiv" class="padtb10"><div style="padding-top:25px;text-align:center;height:50px;" class="smalltxt bld brdr">';
			
			unavmsg_cont='';
			if(json_arr[i]['PU']=='2'){
			unavmsg_cont= 'This profile '+json_arr[i]['ID']+' is hidden.';
			}else if(json_arr[i]['PU']=='3'){
			unavmsg_cont= 'This profile '+json_arr[i]['ID']+' is suspended.';
			}else if(json_arr[i]['PU']=='4'){
			unavmsg_cont= 'This profile '+json_arr[i]['ID']+' is rejected.';
			}else if(json_arr[i]['PU']=='D'){
			unavmsg_cont= 'This profile '+json_arr[i]['ID']+' has been deleted.';
			}else if(json_arr[i]['PU']=='TD'){
			unavmsg_cont= 'This profile '+json_arr[i]['ID']+' is currently unavailable.';
			}

			end_div = '</div></div></div></div><br clear="all">';
			whole_cont += start_div+unavmsg_cont+end_div;
		}

		}//view 1
		else if(sr_vi_ty == '2'){}//view 2
		else if(sr_vi_ty == '4'){}//view 4
		else if(sr_vi_ty == '6'){}//view 6
	}
	$(resdiv).innerHTML = whole_cont;
}
