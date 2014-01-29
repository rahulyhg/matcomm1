<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-08-27
# Project	  : MatrimonyProduct
# Filename	  : primaryinfodesc.php
#=====================================================================================================================================
# Description : display information of hobbies info. It has hobbies info form and update function hobbies information.
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/conf/tblfields.cil14');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];

//OBJECT DECLARTION
$objDBSlave	= new MemcacheDB;
$objCommon	= new clsCommon;

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['hobbiesinfosubmit'];

if($varUpdatePrimary == 'yes') {

	$objDBMaster = new MemcacheDB;
	$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	$varEditedEatHabits		= $_REQUEST["eatingHabits"];
	$varEditedSmokeHabits	= $_REQUEST["smoke"];
	$varEditedDrinkHabits	= $_REQUEST["drink"];
	$varEditedHobbies		= ($_REQUEST['hobbies']!='')?join('~',$_REQUEST['hobbies']):'';
	$varEditedHobbiesDesc	= trim($_REQUEST['hobbiesDesc']);
	$varEditedInterest		= ($_REQUEST['interest']!='')?join('~',$_REQUEST['interest']):'';
	$varEditedInterestDesc	= trim($_REQUEST['interestDesc']);
	$varEditedMusic  		= ($_REQUEST['music']!='')?join('~',$_REQUEST['music']):'';
	$varEditedMusicDesc		= trim($_REQUEST['musicDesc']);
	$varEditedRead			= ($_REQUEST['read']!='')?join('~',$_REQUEST['read']):'';
	$varEditedReadDesc		= trim($_REQUEST['readDesc']);
	$varEditedMovie			= ($_REQUEST['movie']!='')?join('~',$_REQUEST['movie']):'';
	$varEditedMovieDesc		= trim($_REQUEST['movieDesc']);
	$varEditedSports		= ($_REQUEST['sports']!='')?join('~',$_REQUEST['sports']):'';
	$varEditedSportsDesc	= trim($_REQUEST['sportsDesc']);
	$varEditedFood			= ($_REQUEST['food']!='')?join('~',$_REQUEST['food']):'';
	$varEditedFoodDesc		= trim($_REQUEST['foodDesc']);
	$varEditedDress			= ($_REQUEST['dress']!='')?join('~',$_REQUEST['dress']):'';
	$varEditedDressDesc		= trim($_REQUEST['dressDesc']);
	$varEditedSpokenLang	= ($_REQUEST['spokenLang']!='')?join('~',$_REQUEST['spokenLang']):'';
	$varEditedSpokenLangDesc= trim($_REQUEST['spokenLangDesc']);

	//INSERT INTO MEMBERINFO TABLE
	//Direct updatation for array field
	$argFields			= array('Eating_Habits','Smoke','Drink','Date_Updated');
	
	$argFieldsValues	= array($objDBMaster->doEscapeString($varEditedEatHabits,$objDBMaster),$objDBMaster->doEscapeString($varEditedSmokeHabits,$objDBMaster),$objDBMaster->doEscapeString($varEditedDrinkHabits,$objDBMaster),'NOW()');
	$argCondition		= "MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster)."";
	$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);

	if($varEditedHobbies == '' && $varEditedHobbiesDesc == '' && $varEditedInterest == '' && $varEditedInterestDesc == '' && $varEditedMusic == '' && $varEditedMusicDesc == '' && $varEditedRead == '' && $varEditedReadDesc == '' && $varEditedMovie == '' && $varEditedMovieDesc == '' && $varEditedSports == '' && $varEditedSportsDesc == '' && $varEditedFood == '' && $varEditedFoodDesc == '' && $varEditedDress == '' && $varEditedDressDesc == '' && $varEditedSpokenLang == '' && $varEditedSpokenLangDesc == '')
	{
		$argCondition		= "MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		//delete hobbies info
		$objDBMaster->delete($varTable['MEMBERHOBBIESINFO'],$argCondition);

		//set interest set status in memberinfo table
		$argFields 			= array('Interest_Set_Status');
		$argFieldsValues	= array(0);
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
	}
	else if($sessMatriId != '')
	{
		//find member has hobbies info or not
		$argFields				= array('MatriId');
		$argCondition			= "WHERE MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$varChkMemberResultSet	= $objDBSlave->select($varTable['MEMBERHOBBIESINFO'],$argFields,$argCondition,0);
		$varChkMemberInfo		= mysql_fetch_array($varChkMemberResultSet);

		if($varChkMemberInfo['MatriId'] == '')
		{
			$argFields 			= array('MatriId');
			$argFieldsValues	= array($objDBMaster->doEscapeString($sessMatriId,$objDBMaster));
			$varInsertedId		= $objDBMaster->insert($varTable['MEMBERHOBBIESINFO'],$argFields,$argFieldsValues);
		}

		//Direct updatation for array field
		$argFields 			= array('Hobbies_Selected','Interests_Selected','Music_Selected','Books_Selected','Movies_Selected','Sports_Selected','Food_Selected','Dress_Style_Selected','Languages_Selected','Date_Updated');
		$argFieldsValues	= array($objDBMaster->doEscapeString($varEditedHobbies,$objDBMaster),$objDBMaster->doEscapeString($varEditedInterest,$objDBMaster),$objDBMaster->doEscapeString($varEditedMusic,$objDBMaster),$objDBMaster->doEscapeString($varEditedRead,$objDBMaster),$objDBMaster->doEscapeString($varEditedMovie,$objDBMaster),$objDBMaster->doEscapeString($varEditedSports,$objDBMaster),$objDBMaster->doEscapeString($varEditedFood,$objDBMaster),$objDBMaster->doEscapeString($varEditedDress,$objDBMaster),$objDBMaster->doEscapeString($varEditedSpokenLang,$objDBMaster),'NOW()');
		$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERHOBBIESINFO'],$argFields,$argFieldsValues,$argCondition);

		$argFields 			= array('Interest_Set_Status');
		$argFieldsValues	= array(1);
		$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);

		// NOT VALIDATED MEMBER COMMIT OTHER DETAILS DIRECTLY
		if($sessPublish == 0 || $sessPublish == 4)
		{
			$argFields 			= array('Hobbies_Others','Interests_Others','Music_Others','Books_Others','Movies_Others','Sports_Others','Food_Others','Dress_Style_Others','Languages_Others');
			$argFieldsValues	= array($objDBMaster->doEscapeString($varEditedHobbiesDesc,$objDBMaster),$objDBMaster->doEscapeString($varEditedInterestDesc,$objDBMaster),$objDBMaster->doEscapeString($varEditedMusicDesc,$objDBMaster),$objDBMaster->doEscapeString($varEditedReadDesc,$objDBMaster),$objDBMaster->doEscapeString($varEditedMovieDesc,$objDBMaster),$objDBMaster->doEscapeString($varEditedSportsDesc,$objDBMaster),$objDBMaster->doEscapeString($varEditedFoodDesc,$objDBMaster),$objDBMaster->doEscapeString($varEditedDressDesc,$objDBMaster),$objDBMaster->doEscapeString($varEditedSpokenLangDesc,$objDBMaster));
			$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
			$varUpdateId		= $objDBMaster->update($varTable['MEMBERHOBBIESINFO'],$argFields,$argFieldsValues,$argCondition);

			if($sessPublish == 4) {
				$argFields		= array('Publish');
				$argFieldsValues= array('0');
				$varUpdateId	= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);
			}
		}
		else
		{
			if(((trim($_REQUEST['oldhobbie']) != $varEditedHobbiesDesc) && $varEditedHobbiesDesc!='') || ((trim($_REQUEST['oldinterest']) != $varEditedInterestDesc) && $varEditedInterestDesc!='') || ((trim($_REQUEST['oldmusic']) != $varEditedMusicDesc) && $varEditedMusicDesc!='') || ((trim($_REQUEST['oldbook']) != $varEditedReadDesc) && $varEditedReadDesc!='') || ((trim($_REQUEST['oldmovie']) != $varEditedMovieDesc) && $varEditedMovieDesc!='') || ((trim($_REQUEST['oldsports']) != $varEditedSportsDesc) && $varEditedSportsDesc!='') || ((trim($_REQUEST['oldfood']) != $varEditedFoodDesc) && $varEditedFoodDesc!='') || ((trim($_REQUEST['olddress']) != $varEditedDressDesc) && $varEditedDressDesc!='') || ((trim($_REQUEST['oldlanguage']) != $varEditedSpokenLangDesc) && $varEditedSpokenLangDesc!=''))
			{
				$argFields 			= array('MatriId');
				$argFieldsValues	= array($objDBMaster->doEscapeString($sessMatriId,$objDBMaster));
				$varInsertedId		= $objDBMaster->insertIgnore($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues);

				$argFields 			= array('Date_Updated');
				$argFieldsValues	= array('NOW()');

				if(trim($_REQUEST['oldhobbie']) != $varEditedHobbiesDesc) {
					$argFields[]		= 'Other_Hobbies';
					$argFieldsValues[]	= $objDBMaster->doEscapeString($varEditedHobbiesDesc,$objDBMaster);
				}

				if(trim($_REQUEST['oldinterest']) != $varEditedInterestDesc) {
					$argFields[]		= 'Other_Interest';
					$argFieldsValues[]	= $objDBMaster->doEscapeString($varEditedInterestDesc,$objDBMaster);
				}

				if(trim($_REQUEST['oldmusic']) != $varEditedMusicDesc) {
					$argFields[]		= 'Other_Music';
					$argFieldsValues[]	= $objDBMaster->doEscapeString($varEditedMusicDesc,$objDBMaster);
				}

				if(trim($_REQUEST['oldsports']) != $varEditedSportsDesc) {
					$argFields[]		= 'Other_Fitness';
					$argFieldsValues[]	= $objDBMaster->doEscapeString($varEditedSportsDesc,$objDBMaster);
				}

				if(trim($_REQUEST['oldfood']) != $varEditedFoodDesc) {
					$argFields[]		= 'Other_Cuisine';
					$argFieldsValues[]	= $objDBMaster->doEscapeString($varEditedFoodDesc,$objDBMaster);
				}

				$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
				$varUpdateId		= $objDBMaster->update($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues,$argCondition);

				$argFields 			= array('Pending_Modify_Validation','Interest_Set_Status');
				$argFieldsValues	= array(1,1);
				$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
				$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
			}
		}

		$argFields 			= array('Date_Updated','Time_Posted');
		$argFieldsValues	= array('NOW()','NOW()');
		$argCondition		= "MatriId = ".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
	}
	$objDBMaster->dbClose();
} else {

	

	//GETTING VALUE FROM MEMBERINFO
	$argFields			= $arrMEMBERINFOfields;
	$argCondition		= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave)." AND ".$varWhereClause;
	$varPrimaryInfo		= $objDBSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varOwnProfileMCKey);
	$varEatingHabits	= $varPrimaryInfo['Eating_Habits'];
	$varSmokingHabits	= $varPrimaryInfo['Smoke'];
	$varDrinkingHabits	= $varPrimaryInfo['Drink'];

	//GETTING VALUES FROM MEMBERHOBBIESINFO
	$argFields						= array('Hobbies_Selected','Hobbies_Others','Interests_Selected','Interests_Others','Music_Selected','Music_Others','Books_Selected','Books_Others','Movies_Selected','Movies_Others','Sports_Selected','Sports_Others','Food_Selected','Food_Others','Dress_Style_Selected','Dress_Style_Others','Languages_Selected','Languages_Others');
	$argCondition		= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
	$varMemberHobbiesInfoResultSet	= $objDBSlave->select($varTable['MEMBERHOBBIESINFO'],$argFields,$argCondition,0);
	$varMemberInfo					= mysql_fetch_array($varMemberHobbiesInfoResultSet);

	$arrHobbiesChecked	= explode("~",$varMemberInfo["Hobbies_Selected"]);
	$arrInterestChecked = explode("~",$varMemberInfo["Interests_Selected"]);
	$arrMusicChecked	= explode("~",$varMemberInfo["Music_Selected"]);
	$arrBooksChecked	= explode("~",$varMemberInfo["Books_Selected"]);
	$arrMoviesChecked	= explode("~",$varMemberInfo["Movies_Selected"]);
	$arrSportsChecked	= explode("~",$varMemberInfo["Sports_Selected"]);
	$arrFoodChecked		= explode("~",$varMemberInfo["Food_Selected"]);
	$arrDressChecked	= explode("~",$varMemberInfo["Dress_Style_Selected"]);
	$arrLanguageChecked = explode("~",$varMemberInfo["Languages_Selected"]);
}
$objDBSlave->dbClose();
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/hobbiesinfo.js" ></script>

		<? include_once('settingsheader.php');?>

		<center>
			<div class="padt10">
				<?if($varUpdatePrimary == 'yes') { ?>
				<center><div style='width:500px;' class="padt10">
					Your lifestyle information has been modified successfully.
					<br><br><div class='alerttxt pad10 brdr'><b>Any text changes will have to be validated before it is updated on your profile. It usually takes 24 hours.</b></div>
				</div></center>
				<? } else { ?>
				<form method='post' name='frmProfile' style='display:inline' onSubmit='return HobbiesValidate();' style="padding:0px;margin:0px;">
				<input type='hidden' name='act' value='hobbiesinfodesc'>
				<input type='hidden' name='hobbiesinfosubmit' value='yes'>
				<input type='hidden' name='oldhobbie' value='<?=stripslashes(htmlentities($varMemberInfo['Hobbies_Others'],ENT_QUOTES))?>'>
				<input type='hidden' name='oldinterest' value='<?=stripslashes(htmlentities($varMemberInfo['Interests_Others'],ENT_QUOTES))?>'>
				<input type='hidden' name='oldmusic' value='<?=stripslashes(htmlentities($varMemberInfo['Music_Others'],ENT_QUOTES))?>'>
				<input type='hidden' name='oldbook' value='<?=stripslashes(htmlentities($varMemberInfo['Books_Others'],ENT_QUOTES))?>'>
				<input type='hidden' name='oldmovie' value='<?=stripslashes(htmlentities($varMemberInfo['Movies_Others'],ENT_QUOTES))?>'>
				<input type='hidden' name='oldsports' value='<?=stripslashes(htmlentities($varMemberInfo['Sports_Others'],ENT_QUOTES))?>'>
				<input type='hidden' name='oldfood' value='<?=stripslashes(htmlentities($varMemberInfo['Food_Others'],ENT_QUOTES))?>'>
				<input type='hidden' name='olddress' value='<?=stripslashes(htmlentities($varMemberInfo['Dress_Style_Others'],ENT_QUOTES))?>'>
				<input type='hidden' name='oldlanguage' value='<?=stripslashes(htmlentities($varMemberInfo['Languages_Others'],ENT_QUOTES))?>'>

				<div class="smalltxt clr bld fleft">Habits <img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" />
				</div><br clear="all"/>
				<div class="smalltxt fleft tlright pfdivlt">Food</div>
				<div class="fleft pfdivrt tlleft" ><? foreach($arrEatingHabitsList as $key=>$value){
							$varChecked = ($key == $varEatingHabits)?'checked':'';
							echo '<input type="radio" name=eatingHabits value="'.$key.'"  id="eatingHabits'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right:10px;">'.$value.'</font>';
						}?>
				</div><br clear="all"/>

				<div class="smalltxt fleft tlright pfdivlt" >Smoking</div>
				<div class="fleft pfdivrt tlleft" >
						<? foreach($arrSmokeList as $key=>$value){
							$varChecked = ($key == $varSmokingHabits)?'checked':'';
							echo '<input type="radio" name=smoke value="'.$key.'"  id="smoke'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
						}?>
				</div><br clear="all"/>

				<div class="smalltxt fleft tlright pfdivlt" >Drinking</div>
				<div class="fleft pfdivrt tlleft" ><? foreach($arrDrinkList as $key=>$value){
							$varChecked = ($key == $varDrinkingHabits)?'checked':'';
							echo '<input type="radio" name=drink value="'.$key.'"  id="drink'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
						}?>
				</div><br clear="all"/><br>

				<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
				<a name="errinter"></a>
				<div class="smalltxt fleft"><a href='javascript:divswitch("ints", "intclps", "intexpd");' class="clr bld">Interests</a></div>
				<div id='intexpd' style='float:left;' class="disblk pad3"><a href='javascript:divswitch("ints", "intclps", "intexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" /></a></div>
				<div id='intclps' style='float:left;' class="disnon"><a href='javascript:divswitch("ints", "intclps", "intexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow1.gif" border="0" class="pntr" vspace="2" /></a></div>
				<div class='fleft smalltxt errortxt' style='padding-left:10px;'>
					<span id='inttopspan'></span>
				</div>
				<br clear="all"/>
				<div class="disblk padt10" id="ints">
					<div class="smalltxt fleft " style="width:80px;">Select top 3</div>
					<div class="fleft" style="width:460px;">
						<? $i=0;
						foreach ($arrInterestList as $interestval=>$interestname) {
							$ended=0;
							if ($interestval!=0) {
								$varChecked = in_array($interestval,$arrInterestChecked)?' checked':'';
								if($i%3==0) { ?>
									<div class='fleft' style='width:460px;'>
									<? } ?>
									<div class='fleft smalltxt'><input type=checkbox name='interest[]' value='<?=$interestval?>'
									<?=$varChecked?>></div>
									<div class='fleft smalltxt' style='width:130px; padding-top:2px;text-align:left;'><?=stripslashes($interestname)?></div>
								<? if ($i%3==2) { ?>
									</div>
									<? $ended = 1;
								}
								$i++;
							}
						}
						if($ended != 1) { ?>
							</div>
						<? } ?><br clear="all">
						<div class="fleft">
							<input type="checkbox" name="intothertxt"  onclick='javascript:othrtxt("intothertxt", "interestDesc");'><font class="smalltxt clr">Others
							<input type="text" class="inputtext" name="interestDesc" disabled size="30" value="<?=stripslashes(htmlentities($varMemberInfo['Interests_Others'],ENT_QUOTES))?>"></font>
						</div>
						<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='interestDescspan'></span></div>
					</div><br clear="all">
				</div><br clear="all">
				<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
				<a name="errhobby"></a>
				<div class="smalltxt clr bld fleft"><a href='javascript:divswitch("hobbies", "hclps", "hexpd");' class="clr bld">Hobbies</a></div>
				<div id='hexpd' style='float:left;' class="disnon"><a href='javascript:divswitch("hobbies", "hclps", "hexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" /></a></div>
				<div id='hclps' style='float:left;' class="disblk pad3"><a href='javascript:divswitch("hobbies", "hclps", "hexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow1.gif" border="0" class="pntr" vspace="2" /></a></div>
				<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='hobintspan'></span></div>
				<br clear="all"/>
				<div class="disnon padt10" id="hobbies">
					<div class="smalltxt  fleft  " style="width:80px;">Select top 3</div>
					<div class="fleft" style="width:460px;">
						<? $i=0;
						foreach ($arrHobbiesList as $hobbieval=>$hobbiename) {
							$ended=0;
							if($hobbieval!=0) {
								$varChecked = in_array($hobbieval,$arrHobbiesChecked)?' checked':'';
								if($i%3==0) {?>
									<div class='fleft' style='width:460px;'>
									<? } ?>
									<div class='fleft smalltxt'><input type=checkbox name='hobbies[]' value='<?=$hobbieval?>'
									<?=$varChecked?>></div>
									<div class='fleft smalltxt' style='width:130px;padding-top:2px;text-align:left;'><?=stripslashes($hobbiename)?></div>
								<? if ($i%3==2) { ?>
									</div>
									<? $ended = 1;
								}
								$i++;
							}
						}
						if($ended != 1) { ?>
							</div>
						<? } ?><br clear="all">
						<div class="fleft">
							<input type="checkbox" name="hobothertxt"  onclick='javascript:othrtxt("hobothertxt", "hobbiesDesc");'><font class="smalltxt clr">Others
							<input type="text" class="inputtext" name="hobbiesDesc" disabled size="30" value="<?=stripslashes(htmlentities($varMemberInfo['Hobbies_Others'],ENT_QUOTES))?>"></font>
						</div>
						<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='hobbiesDescspan'></span></div>
					</div><br clear="all">
				</div><br clear="all">
				<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all"/>

				<div class="smalltxt clr bld fleft padb10">Favourites</div><br clear="all"/>
				<div class="dotsep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all"/>
				<a name="errmusic"></a>
				<div class="smalltxt clr bld fleft"><a href='javascript:divswitch("fmc", "fmcclps", "fmcexpd");' class="clr bld">Music</a></div>
				<div id='fmcexpd' style='float:left;' class="disnon"><a href='javascript:divswitch("fmc", "fmcclps", "fmcexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" /></a></div>
				<div id='fmcclps' style='float:left;' class="disblk pad3"><a href='javascript:divswitch("fmc", "fmcclps", "fmcexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow1.gif" border="0" class="pntr" vspace="2" /></a></div>
				<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='musintspan'></span></div>
				<br clear="all"/>
				<div class="disnon" id="fmc">
					<div class="smalltxt fleft" style="width:80px;">Select top 3</div>
					<div class="fleft" style="width:460px;">
						<? $i=0;
						foreach ($arrMusicList as $musicval=>$musicname) {
							$ended=0;
							if ($musicval!=0) {
								$varChecked = in_array($musicval,$arrMusicChecked)?' checked':'';
								if($i%3==0) { ?>
									<div class='fleft' style='width:460px;'>
									<? } ?>
									<div class='fleft smalltxt'><input type=checkbox name='music[]' value='<?=$musicval?>'
									<?=$varChecked?>></div>
									<div class='fleft smalltxt' style='width:130px; padding-top:2px;text-align:left;'><?=stripslashes($musicname)?></div>
								<? if ($i%3==2) { ?>
									</div>
									<? $ended = 1;
								}
								$i++;
							}
						}
						if($ended != 1) { ?>
							</div>
						<? } ?>	<br clear="all">
						<div class="fleft">
							<input type="checkbox" name="mscothertxt"  onclick='javascript:othrtxt("mscothertxt", "musicDesc");'><font class="smalltxt clr">Others
							<input type="text" class="inputtext" name="musicDesc" disabled size="30" value="<?=stripslashes(htmlentities($varMemberInfo['Music_Others'],ENT_QUOTES))?>"></font>
						</div>
						<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='musicDescspan'></span></div>
					</div><br clear="all">
				</div><br clear="all">
				<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all"/>

				<a name="errsports"></a>
				<div class="smalltxt fleft"><a href='javascript:divswitch("sfa", "sfaclps", "sfaexpd");' class="clr bld">Sports</a></div>
				<div id='sfaexpd' style='float:left;' class="disnon"><a href='javascript:divswitch("sfa", "sfaclps", "sfaexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" /></a></div>
				<div id='sfaclps' style='float:left;' class="disblk pad3"><a href='javascript:divswitch("sfa", "sfaclps", "sfaexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow1.gif" border="0" class="pntr" vspace="2" /></a></div>
				<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='sportstopspan'></span></div>
				<br clear="all"/>
				<div class="disnon" id="sfa">
					<div class="smalltxt  fleft  " style="width:80px;">Select top 3</div>
					<div class="fleft" style="width:460px;">
						<? $i=0;
						foreach ($arrSportsList as $sportval=>$sportname) {
							$ended=0;
							if ($sportval!=0) {
								$varChecked = in_array($sportval,$arrSportsChecked)?' checked':'';
								if($i%3==0) { ?>
									<div class='fleft' style='width:460px;'>
									<? } ?>
									<div class='fleft smalltxt'><input type=checkbox name='sports[]' value='<?=$sportval?>'
									<?=$varChecked?>></div>
									<div class='fleft smalltxt' style='width:130px; padding-top:2px;text-align:left'><?=stripslashes($sportname)?></div>
								<? if ($i%3==2) { ?>
									</div>
									<? $ended = 1;
								}
								$i++;
							}
						}
						if($ended != 1) { ?>
							</div>
						<? } ?>		<br clear="all">
						<div class="fleft">
							<input type="checkbox" name="sftothertxt"  onclick='javascript:othrtxt("sftothertxt", "sportsDesc");'><font class="smalltxt clr">Others
							<input type="text" class="inputtext" name="sportsDesc" disabled size="30" value="<?=stripslashes(htmlentities($varMemberInfo['Sports_Others'],ENT_QUOTES))?>"></font>
						</div>
						<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='sportsDescspan'></span></div>
					</div><br clear="all"/>
				</div><br clear="all"/>
				<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all"/>
				<a name="errfood"></a>
				<div class="smalltxt fleft"><a href='javascript:divswitch("fc", "fcclps", "fcexpd");' class="clr bld">Food</a></div>
				<div id='fcexpd' style='float:left;' class="disnon"><a href='javascript:divswitch("fc", "fcclps", "fcexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" /></a></div>
				<div id='fcclps' style='float:left;' class="disblk pad3"><a href='javascript:divswitch("fc", "fcclps", "fcexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow1.gif" border="0" class="pntr" vspace="2" /></a></div>
				<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='foodtopspan'></span></div>
				<br clear="all"/>
				<div class="disnon" id="fc">
					<div class="smalltxt  fleft  " style="width:80px;">Select top 3</div>
					<div class="fleft" style="width:460px;">
						<? $i=0;
						foreach ($arrFoodList as $foodval=>$foodname) {
							$ended=0;
							if ($foodval!=0) {
								$varChecked = in_array($foodval,$arrFoodChecked)?' checked':'';
								if($i%3==0) { ?>
									<div class='fleft' style='width:460px;'>
									<? } ?>
									<div class='fleft smalltxt'><input type=checkbox name='food[]' value='<?=$foodval?>'
									<?=$varChecked?>></div>
									<div class='fleft smalltxt' style='width:130px; padding-top:2px;text-align:left'><?=stripslashes($foodname)?></div>
								<? if ($i%3==2) { ?>
									</div>
									<? $ended = 1;
								}
								$i++;
							}
						}
						if($ended != 1) { ?>
							</div>
						<? } ?>		<br clear="all">
						<div class="fleft">
							<input type="checkbox" name="fcsnothertxt"  onclick='javascript:othrtxt("fcsnothertxt", "foodDesc");'><font class="smalltxt clr">Others
							<input type="text" class="inputtext" name="foodDesc" disabled size="30" value="<?=stripslashes(htmlentities($varMemberInfo['Food_Others'],ENT_QUOTES))?>"></font>
						</div>
						<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='foodDescspan'></span></div>
					</div><br clear="all"/>
				</div><br clear="all"/>
				<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all"/>

<!--
				<div class="smalltxt fleft"><a href='javascript:divswitch("pds", "pdsclps", "pdsexpd");' class="clr bld">Dress style</a></div>
				<div id='pdsexpd' style='float:left;' class="disnon"><a href='javascript:divswitch("pds", "pdsclps", "pdsexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" /></a></div>
				<div id='pdsclps' style='float:left;' class="disblk pad3"><a href='javascript:divswitch("pds", "pdsclps", "pdsexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow1.gif" border="0" class="pntr" vspace="2" /></a></div>
				<br clear="all"/>
				<div class="disnon" id="pds">
					<div class="smalltxt fleft" style="width:80px;">Select top 3</div>
					<div class="fleft" style="width:460px;">
						<? $i=0;
						foreach ($arrDressList as $dressval=>$dressname) {
							$ended=0;
							if ($dressval!=0) {
								$varChecked = in_array($dressval,$arrDressChecked)?' checked':'';
								if($i%3==0) { ?>
									<div class='fleft' style='width:460px;'>
									<? } ?>
									<div class='fleft smalltxt'><input type=checkbox name='dress[]' value='<?=$dressval?>'
									<?=$varChecked?>></div>
									<div class='fleft smalltxt' style='width:130px; padding-top:2px;text-align:left'><?=stripslashes($dressname)?></div>
								<? if ($i%3==2) { ?>
									</div>
									<? $ended = 1;
								}
								$i++;
							}
						}
						if($ended != 1) { ?>
							</div>
						<? } ?>	<br clear="all">
						<div class="fleft">
							<input type="checkbox" name="pdsothertxt"  onclick='javascript:othrtxt("pdsothertxt", "dressDesc");'><font class="smalltxt clr">Others
							<input type="text" class="inputtext" name="dressDesc" disabled size="30" value=""></font>
						</div>
						<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='dressDescspan'></span></div>
					</div><br clear="all"/>
				</div><br clear="all"/>
				<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all"/>

				<div class="smalltxt fleft"><a href='javascript:divswitch("slang", "slangclps", "slangexpd");' class="clr bld">Spoken Languages</a></div>
				<div id='slangexpd' style='float:left;' class="disnon"><a href='javascript:divswitch("slang", "slangclps", "slangexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" /></a></div>
				<div id='slangclps' style='float:left;' class="disblk pad3"><a href='javascript:divswitch("slang", "slangclps", "slangexpd");'>
				<img src="<?=$confValues['IMGSURL']?>/arrow1.gif" border="0" class="pntr" vspace="2" /></a></div>
				<br clear="all"/>
				<div class="disnon" id="slang">
					<div class="smalltxt fleft" style="width:80px;">Select top 3</div>
					<div class="fleft" style="width:460px;">
						<? $i=0;
						foreach ($arrSpokenLangList as $spokenlangval=>$spokenlangname) {
							$ended=0;
							if ($spokenlangval!=0) {
								$varChecked = in_array($spokenlangval,$arrLanguageChecked)?' checked':'';
								if($i%3==0) { ?>
									<div class='fleft' style='width:460px;'>
									<? } ?>
									<div class='fleft smalltxt'><input type=checkbox name='spokenLang[]' value='<?=$spokenlangval?>'
									<?=$varChecked?>></div>
									<div class='fleft smalltxt' style='width:130px; padding-top:2px;text-align:left'><?=stripslashes($spokenlangname)?></div>
								<? if ($i%3==2) { ?>
									</div>
									<? $ended = 1;
								}
								$i++;
							}
						}
						if($ended != 1) { ?>
							</div>
						<? } ?>	<br clear="all">
						<div class="fleft">
							<input type="checkbox" name="slangothertxt"  onclick='javascript:othrtxt("slangothertxt", "spokenLangDesc");'><font class="smalltxt clr">Others
							<input type="text" class="inputtext" name="spokenLangDesc" disabled size="30" value=""></font>
						</div>
						<div class='fleft smalltxt errortxt' style='padding-left:10px;'><span id='spokenLangDescspan'></span></div>
					</div><br clear="all"/>
				</div><br clear="all"/>
				<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all"/>
-->

				<div class="tlright padr20" >
				<input type="submit" class="button" value="Save"> &nbsp; <input type="reset" class="button" value="Reset"></div>
				</form><br>
				<? } ?>
			</div>
		</center>