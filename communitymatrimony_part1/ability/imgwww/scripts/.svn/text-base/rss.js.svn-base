function replacetxtbox(sel) {
	var rssmode1		= document.form1.rssmode.value;
	var rssgender		= document.form1.rssgender.value;
	var feedurlval		= rssmode1+rssgender+".rss";

	if(rssgender!="0" && rssmode1!="0") {
		var txtboxval = '<div class="mediumtxt bld" style="padding-bottom:5px;">Your RSS Feed URL: </div><img src="'+imgs_url+'/trans.gif" width="1" height="5" border="0"><input type="text" name="feedurl" class="addtextfiled inputtext" style="width:460px;" value="'+feedurlval+'">';

		$("txtbox").innerHTML = txtboxval;
	}
	else {
		$("txtbox").innerHTML = "";
	}
}

function replaceimage(sel) {
	var rssgender		= document.form1.rssgender.value;
	var rssmode1		= document.form1.rssmode.value;
	var rssmodel_name	= document.form1.DisplayAlert.value;
	if(rssmode1=="0") {
		$("subrssimg").innerHTML = ""; 
		alert("Please select "+rssmodel_name+".");
		return false;
	}

	var img_href="";
	var img_sel="";
	var alttag="";

	switch (sel){
		case "1": 
			img_sel = "myyahoo.bmp";
			img_href = "e.my.yahoo.com/config/cstore?.opt=content&.url=";
			alttag = "Add to MyYahoo";
		break;
		case "2": 
			img_sel = "add-to-digg.jpg";
			img_href = "digg.com/submit?phase=2&url=";
			alttag = "Add to Digg";
		break;
		case "3": 
			img_sel = "addtogoogle.bmp";
			img_href = "www.google.com/ig/add?feedurl=";
			alttag = "Add to Google";
		break;
		case "4": 
			img_sel = "delicious.bmp";
			img_href = "del.icio.us/login?url=";
			alttag = "Add to del.icio.us";
		break;
		case "5": 
			img_sel = "add-to-spurl.jpg";
			img_href = "www.spurl.net/spurl.php?url=";
			alttag = "Add to Sprul";
		break;
		case "6": 
			img_sel = "furlit.bmp";
			img_href = "www.furl.net/storeIt.jsp?u=";
			alttag = "Furl It";
		break;
		case "7": 
			img_sel = "blogmarks.jpg";
			img_href = "blogmarks.net/my/new.php?mini=1&simple=1&url=";
			alttag = "blogmarks";
		break;
		case "8": 
			img_sel = "addnewsgator.gif";
			img_href = "www.newsgator.com/ngs/subscriber/subext.aspx?url=";
			alttag = "";
		break;
		case "9": 
			img_sel = "addbloglines.gif";
			img_href = "www.bloglines.com/sub/";
			alttag = "";
		break;
		case "10": 
			img_sel = "addmymsn.gif";
			img_href = "my.msn.com/addtomymsn.armx?id=rss&ut=";
			alttag = "";
		break;
		case "11": 
			img_sel = "addnewsisfree.gif";
			img_href = "www.newsisfree.com/user/sub/?url=";
			alttag = "";
		break;
	}

	if(sel!=0) {
		var final_subimg = "<a href='http://"+img_href+rssmode1+rssgender+".rss' target='_blank'><img src='"+imgs_url+'/rss/'+img_sel+"' name='rsssub' alt=\""+alttag+"\" border='0' onClick='track(\""+img_sel+"\")' align='absmiddle'></a>";
		$("subrssimg").innerHTML = final_subimg;
	}
	else {
		$("subrssimg").innerHTML = ""; 
		return false;
	}
}

function checkit(sel) {
	var rsssub1 = document.form1.rsssub.value;

	if(rsssub1!="0" && sel!="0") {
		replaceimage(rsssub1);
	}
}

function replacetxtbox_aff() {
	var rssmode1_aff	= document.form1.rssmode_aff.value;
	var rssgender_aff	= document.form1.rssgender_aff.value;
	var rssmodel_name	= document.form1.DisplayAlert.value;
	var aff_id_val_aff	= document.form1.id_aff.value;

	if(rssmode1_aff=="0") {
		alert("Please select "+rssmodel_name+".");
		document.form1.rssmode_aff.focus();
	}
	else if(aff_id_val_aff=="") {
		alert("Please enter Affiliate Id.");
		document.form1.id_aff.focus();
	}
	else {
		var feedurlval_aff = rssmode1_aff+rssgender_aff+".rss/"+aff_id_val_aff;

		if(rssgender_aff!="0" && rssmode1_aff!="0") {
			var txtboxval_aff = '<font style="font-size:11px;font-family:verdana,arial;">Your Affiliate RSS Feed URL: </font><br><img src="'+imgs_url+'/trans.gif" width="1" height="5" border="0"><br><input type="text" name="feedurl_aff" class="addtextfiled" style="width:565px;" value="'+feedurlval_aff+'">';

			$("txtbox_aff").innerHTML = txtboxval_aff;
		}
		else {
			$("txtbox_aff").innerHTML = "";
		}
	}
}