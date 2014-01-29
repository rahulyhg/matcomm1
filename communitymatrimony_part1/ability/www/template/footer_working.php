<? if (trim($varGetCookieInfo['MATRIID']) !="") { ?>
	<script>var msgn_myid='<?=$varGetCookieInfo['MATRIID']?>';</script>
	<script src='<?=$confValues['JSPATH']?>/al.js'></script><script>anonConnection();</script>
<? } 

	//SEO ORGANIC TRACK CODE...	
	if(!empty($_SERVER['HTTP_REFERER'])) {
		
		$varOrgAct	= $_REQUEST['act'] ? '/'.$_REQUEST['act'].'.php' : ''; 

		?>

	<iframe src="http://www.communitymatrimony.com/googlecamp/seo/seoorganictrack.php?ref=<?=urlencode($_SERVER['HTTP_REFERER'])?>&ip=<?=urlencode($_SERVER['REMOTE_ADDR'])?>&page=<?=$_SERVER['PHP_SELF'].$varOrgAct?>&matriid=<?=trim($varGetCookieInfo['MATRIID'])?>" width="0" height="0" frameborder="0"></iframe>

<?	} ?>

<br clear="all" />
<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
<div class="footdiv">
	<div class="footdiv1"><font class="smalltxt clr">
		<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=aboutus" class="smalltxt clr1">About Us</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=contactus" class="smalltxt clr1">Contact Us</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=privacypolicy" class="smalltxt clr1">Privacy Policy</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=termsandconditions" class="smalltxt clr1">Terms and Conditions</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/payment/" class="smalltxt clr1">Pay Now</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['SERVERURL']?>/site/index.php?act=feedback" class="smalltxt clr1">Feedback</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$confValues['IMAGEURL']?>/successstory/index.php?act=success" class="smalltxt clr1">Post Success Story</a>
	</font></div>
	<center><div class="fleft footdiv2"><font class="smalltxt clr"><?=$confPageValues["COPYRIGHT"]?></font></div></center>
</div>



<?php if ($sessMatriId !="") { ?>

<!-- Static Footer start -->
<style>
#myfooter {
	position:fixed;
	left: 0;
	bottom: 0;
	width: 100%;
}
#myfootercontainer {
	background:#DDDDDD none repeat scroll 0 0;
	height: 25px;
	margin-left: 10px;
	margin-right: 10px;
}

.myfootercontent {
	padding: 0 5px;
	margin:0 5px;
	cursor: pointer;
	background:#AAAAAA none repeat scroll 0 0;
	border:1px solid #000000;
}
.myfootercontent a:hover {
	padding: 0 5px;
	cursor: pointer;
	background:#FFFFFF none repeat scroll 0 0;
}
.border1solidgray {
	border:1px solid #BBBBBB;
	border-bottom:0px;
}
.border2rightsolidgray {
	border-right:2px solid #BBBBBB;
}

#myfavouriteslist {
	left: 10px;
}

#myblockedslist {
	left: 135px;
}

#myfriendslist {
	left: 260px;
}

#mymailslist {
	left: 350px;
}


/*#myfavouriteslist, #myblockedslist, #mymailslist, #myfriendslist {
	background:#DDDDDD none repeat scroll 0 0;
	display:none;
	position:fixed;
	bottom: 25px;
	width: 100px;
	border: 1px solid #BBBBBB;
	border-bottom: 0px;
	padding: 2px;
}*/

.mybarbox {
	background:#DDDDDD none repeat scroll 0 0;
	display:none;
	position:fixed;
	bottom: 25px;
	width: 120px;
	border: 1px solid #BBBBBB;
	border-bottom: 0px;
	padding: 2px;
	opacity:0.9;
	filter:alpha(opacity=90);
}

#mailmultiple, #usermultiple {
	display:none;
}

.mybarlist {
	height: 20px;
	padding: 0 5px;
	margin: 2px 0;
	list-style: none;
}

.mybarlist a:hover {
	background: #AAAAAA;
}

/* lte IE6 */
* html #myfooter {
	position: absolute;
	bottom: 0px;
}
* html .mybarbox {
	position:absolute;
	bottom:22px;
}

</style>

<div id="myfooter">
	<div id="myfootercontainer" class="border1solidgray">
		<span class="myfootercontent" onClick="showLists('favourite', 'myfavouriteslist')"><img src='http://www.agarwalmatrimony.com/template/icon_user.png' alt='new mails' />My Favourites</span>
		<div id="myfavouriteslist" class="mybarbox">Loading...</div>
		<span class="myfootercontent" onClick="showLists('block', 'myblockedslist')"><img src='http://www.agarwalmatrimony.com/template/user_block.gif' alt='new mails' />Blocked users</span>
		<div id="myblockedslist" class="mybarbox">Loading...</div>
		<span class="myfootercontent" onClick="showOnlineUsers('myfriendslist');"><img id="usersmile" src='http://www.agarwalmatrimony.com/template/smile_white.gif' alt='new mails' /><span class="usernumber" id="usernumber">0</span> User<span id="usermultiple">s</span> Online</span>
		<div id="myfriendslist" class="mybarbox">Loading ...</div>
		<span class="myfootercontent"><img id="msgsmile" src='http://www.agarwalmatrimony.com/template/comment-ani.gif' alt='new mails' /><span class="mailnumber" id="mailnumber">0</span> <a href="/mymessages/">New Message<span id="mailmultiple">s</span></a></span>
		<div id="mymailslist" class="mybarbox">Loading ...</div>
	</div>
</div>
<!-- Static Footer end -->



<script>
var exePanel;
var totalHeight;
var newHeight;
var friendsOnline = 0;
var processFlag = false;
var httpRequest = null;
var USER_ROW_HEIGHT = 25;
var PANEL_DISPLAYCHANGE = 10;
var PANEL_DISPLAY_TIME = 50;
var REQUEST_TIMEOUT = 5;
var GET_ONLINEUSERS = 1;
var GET_FAVOURITES = 2;
var GET_BLOCKEDLIST = 3;
var GET_MESSAGES = 4;

getPanelDisplayStatus = function(id) {
	elt = document.getElementById(id);
	if(elt.style.display == 'block') {
		return true;
	}
	else {
		return false;
	}
}

setPanelDisplayStatus = function(id, dispStatus) {
	elt = document.getElementById(id);
	elt.style.display = dispStatus;
}

togglePanel = function(id) {
	if(processFlag == false) {
		elt = document.getElementById(id);
		if(elt.style.display == 'block') {
			hidePanel(id);
		}
		else {
			showPanel(id);
		}
	}
}

hidePanel = function(id) {
	//newHeight = totalHeight;
	processFlag = true;
	minimizePanel(id);
}

showPanel = function(id) {
	elt = document.getElementById(id);
	elt.style.display = 'block';
	processFlag = true;
	maximizePanel(id);
}

showMails = function(id) { 
	nfav = 5;
	totalHeight = USER_ROW_HEIGHT * nfav;
	newHeight = USER_ROW_HEIGHT; 
	togglePanel(id);
}

showUsers = function(id) { 
	nfav = 6;
	totalHeight = USER_ROW_HEIGHT * nfav;
	newHeight = USER_ROW_HEIGHT; 
	togglePanel(id);
}

maximizePanel = function(id) { 
	elt = document.getElementById(id);
	curHeight = elt.style.height;

	elt.style.height = newHeight;
	newHeight += PANEL_DISPLAYCHANGE;

	if(newHeight < totalHeight) { 
		processFlag = true;
		setTimeout("maximizePanel('"+id+"')", PANEL_DISPLAY_TIME);
	}
	else {
		processFlag = false;
	}
}

minimizePanel = function(id) {
	elt = document.getElementById(id);
	curHeight = elt.style.height;

	elt.style.height = newHeight;
	newHeight -= PANEL_DISPLAYCHANGE;

	if(newHeight > 0) {
		processFlag = true;
		setTimeout("minimizePanel('"+id+"')", PANEL_DISPLAY_TIME);
	}
	else {
		elt.style.display = 'none';
		processFlag = false;
	}
}

getHttpRequest = function() {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		httpRequest = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		// code for IE6, IE5
		httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else {
		alert("Your browser does not support XMLHTTP!");
	}
	return httpRequest;
}

showFavourites = function(id) { 
	elt = document.getElementById(id);
	if(!processFlag) {
		if(!getPanelDisplayStatus(id)) {
			elt.innerHTML = "Loading...";
			setPanelDisplayStatus(id, 'block');
			httpRequest = getHttpRequest();
			url = "/status/getstatus.php?flg=" + GET_FAVOURITES;
			method = "GET";
			httpRequest.open(method, url, true);
			httpRequest.onreadystatechange = function() {
				if(httpRequest.readyState == 4 && httpRequest.status == 200) {
					if(httpRequest.responseText != 'null') {
						//alert(httpRequest.responseText);
						eval("arFav=" + httpRequest.responseText);
						nfav = arFav.length;
						totalHeight = USER_ROW_HEIGHT * nfav;
						newHeight = USER_ROW_HEIGHT; 
						favList = "";
						for(i=0; i < nfav; i++) {
							favList += "<li class='mybarlist'><a href='/profiledetail/index.php?act=viewprofile&id="+ arFav[i]['MatriId'] +"'>"+ arFav[i]['Name'] +"</a></li>";
						}
						if(nfav > 9) {
							favList += "<li class='mybarlist'><a href='/list/index.php?act=listshowall&listtype=SL'>More...</a></li>";
						}
						elt.innerHTML = favList;
						showPanel(id);
					}
					else {
						elt.innerHTML = 'No Favourite user';
					}
				}
			};
			httpRequest.send(null);
		}
		else {
			//elt.innerHTML = "";
			hidePanel(id);
		}
	}
}

showBlockedList = function(id) {
	elt = document.getElementById(id);
	if(!processFlag) {
		if(!getPanelDisplayStatus(id)) {
			elt.innerHTML = "Loading...";
			setPanelDisplayStatus(id, 'block');
			httpRequest = getHttpRequest();
			url = "/status/getstatus.php?flg=" + GET_BLOCKEDLIST;
			method = "GET";
			httpRequest.open(method, url, true);
			httpRequest.onreadystatechange = function() {
				if(httpRequest.readyState == 4 && httpRequest.status == 200) {
					//alert(httpRequest.responseText);
					if(httpRequest.responseText != 'null') {
						eval("arBlock=" + httpRequest.responseText);
						nblk = arBlock.length;
						totalHeight = USER_ROW_HEIGHT * nblk;
						newHeight = USER_ROW_HEIGHT; 
						blkList = "";
						for(i=0; i < nblk; i++) {
							blkList += "<li class='mybarlist'><a href='/profiledetail/index.php?act=viewprofile&id="+ arBlock[i]['MatriId'] +"'>"+ arBlock[i]['Name'] +"</a></li>";
						}
						if(nblk > 9) {
							blkList += "<li class='mybarlist'><a href='/list/index.php?act=listshowall&listtype=BK'>More...</a></li>";
						}
						elt.innerHTML = blkList;
						showPanel(id);
					}
					else {
						elt.innerHTML = 'No Blocked user';
					}
				}
			};
			httpRequest.send(null);
		}
		else {
			//elt.innerHTML = "";
			hidePanel(id);
		}
	}
}

getMessages = function() {
	httpRequestMsg = getHttpRequest();
	url = "/status/getstatus.php?flg=" + GET_MESSAGES;
	method = "GET";
	args = null;
	//url = '/mymessages/new_msg_ctrl.php';
	//method = 'POST';
	//args = 'tabId=HOME&view=1';
	httpRequestMsg.open(method, url, true);
	httpRequestMsg.onreadystatechange = function() {
		if(httpRequestMsg.readyState == 4 && httpRequestMsg.status == 200) {
			//res = httpRequestMsg.responseText;
			//arRes = res.split('#^~^#');
			//noOfMessages = arRes[2];
			noOfMessages = httpRequestMsg.responseText;

			document.getElementById('mailnumber').innerHTML = noOfMessages;
			if(noOfMessages >= 1) {
				document.getElementById('msgsmile').src = 'http://www.agarwalmatrimony.com/template/Glitter_Mail.gif';
				if(noOfMessages > 1) {
					document.getElementById('mailmultiple').style.display = 'inline';
				}
				else {
					document.getElementById('mailmultiple').style.display = 'none';
				}
			}
			else {
				document.getElementById('msgsmile').src = 'http://www.agarwalmatrimony.com/template/comment-ani.gif';
				document.getElementById('mailmultiple').style.display = 'none';
			}
		}
	};
	httpRequestMsg.send(args);

	var procMessages = setTimeout("getMessages()", (1000 * 60 * REQUEST_TIMEOUT));
}

getUsers = function() {
	httpRequestUser = getHttpRequest();
	url = "/status/getstatus.php?flg=" + GET_ONLINEUSERS;
	method = "GET";
	args = null;
	httpRequestUser.open(method, url, true);
	httpRequestUser.onreadystatechange = function() {
		if(httpRequestUser.readyState == 4 && httpRequestUser.status == 200) {
			//alert(httpRequestUser.responseText);
			//res = httpRequestUser.responseText;
			//noOfFriends = res;
			if(httpRequestUser.responseText != 'null') {
				eval("arUsers="+ httpRequestUser.responseText);
				noOfFriends = 0;
				usrList = "";
				for(i=0, j=arUsers.length; i<j; i++) {
					if(arUsers[i]['online'] == 'Y') {
						usrList += "<li class='mybarlist'><a href='/profiledetail/index.php?act=viewprofile&id="+ arUsers[i]['MatriId'] +"'>"+ arUsers[i]['Name'] +"</a></li>";
						noOfFriends++;
					}
				}
				friendsOnline = noOfFriends;

				document.getElementById('usernumber').innerHTML = noOfFriends;
				document.getElementById('myfriendslist').innerHTML = usrList;
				if(noOfFriends >= 1) {
					document.getElementById('usersmile').src = 'http://www.agarwalmatrimony.com/template/smile_green.gif';
					if(noOfFriends > 1) {
						document.getElementById('usermultiple').style.display = 'inline';
					}
					else {
						document.getElementById('usermultiple').style.display = 'none';
					}
				}
				else {
					document.getElementById('usersmile').src = 'http://www.agarwalmatrimony.com/template/smile_white.gif';
					document.getElementById('usermultiple').style.display = 'none';
				}
			}
			else {
				document.getElementById('myfriendslist').innerHTML = "0 User Online";
			}
		}
	};
	httpRequestUser.send(args);

	var procUsers = setTimeout("getUsers()", (1000 * 60 * REQUEST_TIMEOUT));

}

showOnlineUsers = function(id) {
	elt = document.getElementById(id);
	if(!processFlag) {
		if(!getPanelDisplayStatus(id)) {
			setPanelDisplayStatus(id, 'block');
			totalHeight = USER_ROW_HEIGHT * friendsOnline;
			newHeight = USER_ROW_HEIGHT;
			showPanel(id);
		}
		else {
			hidePanel(id);
		}
	}
}

showLists = function(lists, id) {
	switch(lists) {
		case 'favourite':
			showFavourites(id);
			break;
		case 'block':
			showBlockedList(id);
			break;
		case 'mail':
			showMails(id);
			break;
		case 'users':
			showUsers(id);
			break;
	}
}

getUsers();
getMessages();

</script>

<?php } ?>