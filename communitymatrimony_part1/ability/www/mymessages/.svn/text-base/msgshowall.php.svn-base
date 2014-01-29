<?php
#====================================================================================================
# Author 		: Senthilnathan.M
# Project		: MatrimonyProduct
# Module		: Mymessages
//Received - Msg
//RMUNREAD - Unread, RMREAD - Read, RMREPLIED - Replied, RMDECLINED - declined

//Sent - Msg
//SMUNREAD - Unread, SMREAD - Read, SMREPLIED - Replied, SMDECLINED - declined

//Received - Interest
//RIPENDING - Pending, RIACCEPTED - Accept, RIDECLINED - declined

//Sent - Interest
//SIPENDING - Pending, SIACCEPTED - Accept, SIDECLINED - declined

//Received - Request
//RRPHOTO - Photo, RRPHONE - Phone, RRHOROSCOPE - Horoscope

//Sent - Request
//SRPHOTO - Photo, SRPHONE - Phone, SRHOROSCOPE - Horoscope
#====================================================================================================
$varRequestedPg		= $_REQUEST['part']!='' ? $_REQUEST['part'] : 'RMALL';
$varReqMainPg		= $varRequestedPg{0};
$varReqSubPg		= $varRequestedPg{1};

$arrMailRecStatus	= array('RMUNREAD'=>'Unread', 'RMREAD'=>'Read', 'RMREPLIED'=>'Replied', 'RMDECLINED'=>'Declined');
$arrMailSentStatus	= array('SMUNREAD'=>'Unread', 'SMREAD'=>'Read', 'SMREPLIED'=>'Replies', 'SMDECLINED'=>'Declined');
$arrIntRecStatus	= array('RIPENDING'=>'Pending', 'RIACCEPTED'=>'Accepted', 'RIDECLINED'=>'Declined');
$arrIntSentStatus	= array('SIPENDING'=>'Pending', 'SIACCEPTED'=>'Accepted', 'SIDECLINED'=>'Declined');
$arrReqRecStatus	= array('RRPHOTO'=>'Photo', 'RRPHONE'=>'Phone', 'RRHOROSCOPE'=>'Horoscope');
$arrReqSentStatus	= array('SRPHOTO'=>'Photo', 'SRPHONE'=>'Phone', 'SRHOROSCOPE'=>'Horoscope');

$arrSort = array();
if($varReqMainPg == 'S'){
	$varTabsValue	= 'Sent'; 
	$varOppLinkTxt	= 'Received Folder &raquo;'; 
	$varOppLinkVal	= 'RMALL';
	if($varReqSubPg == 'M'){
		$arrSort	= $arrMailSentStatus;
		$varAllLinkVal  = 'SMALL';
	}else if($varReqSubPg == 'I'){
		$arrSort	= $arrIntSentStatus;
		$varAllLinkVal  = 'SIALL';
	}else if($varReqSubPg == 'R'){
		$arrSort	= $arrReqSentStatus;
		$varAllLinkVal  = 'SRALL';
	}
	
}else{
	$varReqMainPg	= 'R';
	$varTabsValue	= 'Received'; 
	$varOppLinkTxt	= 'Sent Folder &raquo;'; 
	$varOppLinkVal	= 'SMALL'; 

	if($varReqSubPg == 'M'){
		$arrSort	= $arrMailRecStatus;
		$varAllLinkVal  = 'RMALL';
	}else if($varReqSubPg == 'I'){
		$arrSort	= $arrIntRecStatus;
		$varAllLinkVal  = 'RIALL';
	}else if($varReqSubPg == 'R'){
		$arrSort	= $arrReqRecStatus;
		$varAllLinkVal  = 'RRALL';
	}
	
}

$varPerMsgLink	= '<a href="'.$confValues['SERVERURL'].'/mymessages/?part='.$varReqMainPg.'MALL" class="clr1">Messages '.$varTabsValue.'</a>';
$varInterestLink= '<a href="'.$confValues['SERVERURL'].'/mymessages/?part='.$varReqMainPg.'IALL" class="clr1">Interests '.$varTabsValue.'</a>';
$varRequestLink = '<a href="'.$confValues['SERVERURL'].'/mymessages/?part='.$varReqMainPg.'RALL" class="clr1">Requests '.$varTabsValue.'</a>';

switch($varReqSubPg){
		case 'M' :
			$varPerMsgLink	= '<font class="clr bld">Messages '.$varTabsValue.'</font>';
			break;
		case 'I' :
			$varInterestLink= '<font class="clr bld">Interests '.$varTabsValue.'</font>';
			break;
		case 'R' :
			$varRequestLink	= '<font class="clr bld">Requests '.$varTabsValue.'</font>';
			break;
}
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhomeresult.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhome.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5">
	
	<div class="fleft">
	<?=$varPerMsgLink;?>&nbsp&nbsp;|&nbsp;&nbsp;<?=$varInterestLink;?>&nbsp&nbsp;|&nbsp;&nbsp;<?=$varRequestLink;?>
	<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="55" /></div>
	<div class="fright" style="background-color:#EFEFEF;padding:3px;"><a href="<?=$confValues['SERVERURL'].'/mymessages/index.php?part='.$varOppLinkVal;?>" class="clr1 bld"><?=$varOppLinkTxt;?></a></div>
	</div><br clear="all">
	<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<div class="smalltxt clr2 padt5"><div class="fleft"><font class="clr">Show : </font></div><div class="fleft rbrdr1">&nbsp;&nbsp;<a class="clr1" href="javascript:;" onclick="funMain('<?=$varAllLinkVal;?>');">All</a>&nbsp;&nbsp;</div><div style="width: 75px;" id="sortmsg" class="tlcenter fleft rbrdr1"><a onmouseout="document.getElementById('sortmsg').className='tlcenter fleft rbrdr1';" onmouseover="document.getElementById('sortmsg').className='tlcenter fleft mbrdr2';" onclick="showhidediv('sortdiv'); return true;" class="clr bld">Sort by <img border="0" vspace="2" hspace="4" class="pntr" src="<?=$confValues['IMGSURL']?>/arrow.gif"/></a>
	</div><div class="fleft">&nbsp;&nbsp;<a class="clr1" onclick="delMsg();">Delete</a></div><br clear="all">
	<!-- Sort menu content -->
	<div style="padding-left:61px !important;padding-left:61px;">
		<div id="sortdiv" class="layer" style="display:none;width:56px !important;width:75px;" onmouseout="document.getElementById('sortmsg').className='tlcenter fleft rbrdr1';hidediv('sortdiv'); return true;" onmouseover="showdiv('sortdiv');document.getElementById('sortmsg').className='tlcenter fleft mbrdr2';">
		<?php		
		foreach($arrSort as $varKey=>$varVal){
			echo '<a class="smalltxt clr1" href="javascript:;" onclick="funMain(\''.$varKey.'\');document.getElementById(\'sortmsg\').className=\'tlcenter fleft rbrdr1\';hidediv(\'sortdiv\');" onmouseover="showdiv(\'sortdiv\');">'.$varVal.'</a><br>';
		}
		?>
		</div>
	</div>
	<!-- Sort menu content -->
	</div><br clear="all">
	<center>
	<div id="deldiv" style="width:500px;"></div>
	</center><input type="hidden" name="msgtype" id="msgtype" value=""><br clear="all">
	<div class="normtxt1 bld padb5 fleft" id="msgtitle"></div>
	<div class="fright" style="padding-bottom:3px;">
		<div id="bubble_tooltip">
			<div class="bubble_img"><span id="bubble_tooltip_content"></span></div>
		</div>
		<div style="padding-left:210px;padding-top:3px;"><div class="fleft" style="padding-top:4px;"><a href="#" onmouseover="showToolTip(event,'Unread');return false" onmouseout="hideToolTip()"><img src="<?=$confValues['IMGSURL']?>/unread.gif" /></a></div><div class="fleft clr2" style="padding:0px 5px;">|</div><div class="fleft"><a href="#" onmouseover="showToolTip(event,'Read');return false" onmouseout="hideToolTip()"><img src="<?=$confValues['IMGSURL']?>/read.gif" /></a></div><div class="fleft clr2" style="padding:0px 5px;">|</div><div class="fleft"><a href="#" onmouseover="showToolTip(event,'Replied');return false" onmouseout="hideToolTip()"><img src="<?=$confValues['IMGSURL']?>/reply.gif" /></a></div><div class="fleft clr2" style="padding:0px 5px;">|</div><div class="fleft"><a href="#" onmouseover="showToolTip(event,'Declined');return false" onmouseout="hideToolTip()"><img src="<?=$confValues['IMGSURL']?>/decline.gif" /></a></div><div class="fleft clr2" style="padding:0px 5px;">|</div><div class="fleft"><a href="#" onmouseover="showToolTip(event,'Accepted');return false" onmouseout="hideToolTip()"><img src="<?=$confValues['IMGSURL']?>/accept.gif" /></a></div></div>
	</div><br clear="all">
	<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
	<center>
		<form name="buttonfrm">
		<div id="msgResults">
			<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" onload="funMain('<?=$varRequestedPg?>');"/>
		</div><br clear="all">
		<div id="prevnext" class="padtb10"></div>

		</form>
	</center>
<br clear="all" />
</div>
