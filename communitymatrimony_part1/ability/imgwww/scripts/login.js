function funLogin(){

	var communityId = document.frmLogin.communityId.value;
	var errorlable	= 'matrimony ID / E-mail';
	if (communityId=='' || communityId==null) { errorlable	= 'matrimony ID'; }

	if(document.frmLogin.idEmail.value=="" || document.frmLogin.idEmail.value=="ID / E-mail"){
		document.getElementById('error').innerHTML="Please enter your "+errorlable;
		document.frmLogin.idEmail.focus();
		return false;
	}
	if(document.frmLogin.password.value==""){
		document.getElementById('error').innerHTML="Please enter password";
		document.frmLogin.password.focus();
		return false;
	}
	document.getElementById('error').innerHTML="";
	return true;
}

function forgotPasswordValidate(){
	var communityId = document.fp_idEmail.communityId.value;
	var errorlable	= 'matrimony ID / E-mail';
	if (communityId=='' || communityId==null) { errorlable	= 'matrimony ID'; }
	if(document.frmforgetpwrequest.fp_idEmail.value=="" || document.frmforgetpwrequest.fp_idEmail.value=="ID / E-mail"){
		document.frmforgetpwrequest.fp_idEmail.value = "Please enter your "+errorlable;
		return false;
	}
	return true;
}

// Banner rotation script

		var total = 4;
		var ban;
		var banarr = new Array();
		banarr[0] = '<a href="http://adserver.clickjobs.com/tracking.php?section=CJ_UploadRes_BM_300x250&referredby=3335555559" target="_blank"><img src="http://img.communitymatrimony.com/images/banners/CJ_UploadRes_BM_300x250.gif" width="300" height="250" border="0"></a>';
		banarr[1] = '<a href="http://adserver.clickjobs.com/tracking.php?section=CJ_GetPaidEvery_BM_300x250&referredby=3335555558" target="_blank"><img src="http://img.communitymatrimony.com/images/banners/CJ_GetPaidEvery_BM_300x250.gif" width="300" height="250" border="0"></a>';
		banarr[2] = '<a href="http://adserver.clickjobs.com/tracking.php?section=CJ_EarnWhen_BM_300x250&referredby=3335555557" target="_blank"><img src="http://img.communitymatrimony.com/images/banners/CJ_EarnWhen_BM_300x250.gif" width="300" height="250" border="0"></a>';
		banarr[3] = '<!-- begin ZEDO for channel: community_login_300x250 , publisher: Bharatmatrimony , Ad Dimension: Medium Rectangle - 300 x 250 --><iframe src="http://c2.zedo.com/jsc/c2/ff2.html?n=570;c=2494;s=64;d=9;w=300;h=250" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=300 height=250></iframe><!-- end ZEDO for channel: community_login_300x250 , publisher: Bharatmatrimony , Ad Dimension: Medium Rectangle - 300 x 250 -->';
		banarr[4] = '<a href="http://server.indiaproperty.com/IP_Campaign/tracking.php?section=300x250&referredby=6730000001" target="_blank"><img src="http://img.communitymatrimony.com/images/banners/ip_cm_advertise_300x250_sep09.gif" width="300" height="250" border="0"></a>';
		/*banarr[5] = '<object height="250" width="300" id="MyMovieName" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param value="http://img.communitymatrimony.com/images/banners/ip_cm_dreamhome_300x250_sep09.swf" name="movie"/><param value="high" name="quality"/><embed height="250" align="" width="300" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" name="MyMovieName" quality="high" src="http://img.communitymatrimony.com/images/banners/ip_cm_dreamhome_300x250_sep09.swf"/></object>';
		banarr[6] = '<object height="250" width="300" id="MyMovieName" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param value="http://img.communitymatrimony.com/images/banners/ip_cm_family_300x250_sep09.swf" name="movie"/><param value="high" name="quality"/><embed height="250" align="" width="300" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" name="MyMovieName" quality="high" src="http://img.communitymatrimony.com/images/banners/ip_cm_family_300x250_sep09.swf"/></object>';
		banarr[7] = '<object height="250" width="300" id="MyMovieName" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param value="http://img.communitymatrimony.com/images/banners/ip_cm_find_300x250_sep09.swf" name="movie"/><param value="high" name="quality"/><embed height="250" align="" width="300" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" name="MyMovieName" quality="high" src="http://img.communitymatrimony.com/images/banners/ip_cm_find_300x250_sep09.swf"/></object>'; */
