<?php
#================================================================================================================
# Author 		: Senthilnathan
# Start Date	: 2009-02-18
# End Date		: 2009-02-19
# Project		: MatrimonyProduct
# Module		: Search - RSS Feed Search
#================================================================================================================
//INCLUDED FILES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsDomain.php');

//OBJECT DECLARATION
$objDB = new DB;
$objDomainInfo	= new domainInfo;

//Connect DB
$objDB->dbConnect('S2', $varDbInfo['DATABASE']);

//VARIABLE DECLERATION
$varCommunityCategory	= $_REQUEST['cat'];
unset($arrOccupationList[60]);
unset($arrEducationList[10]);

$varFind	= array(' ', '/',"'");
$varReplace	= array('^', '~', '_' );

//CONDITIONAL STATEMENTS
switch($varCommunityCategory)
{
	case 'Religion':
		$varPrimary		= 'Religion';
		$arrValue		= $objDomainInfo->getReligionOption();
		$varTitle		= $objDomainInfo->getReligionLabel();
		break;

	case 'Denomination':
		$varPrimary		= 'Denomination';
		$arrValue		= $objDomainInfo->getDenominationOption();
		$varTitle		= $objDomainInfo->getDenominationLabel();
		break;

	case 'Caste':
		$varPrimary		= 'CasteId';
		$arrValue		= $objDomainInfo->getCasteOption();
		$varTitle		= $objDomainInfo->getCasteLabel();
		break;

	case 'Subcaste':
		$varPrimary		= 'SubcasteId';
		$arrValue		= $objDomainInfo->getSubcasteOption();
		$varTitle		= $objDomainInfo->getSubcasteLabel();
		break;
	
	case 'MaritalStatus':
		$varPrimary		= 'Marital_Status';
		$arrValue		= $objDomainInfo->getMaritalStatusOption();
		$varTitle		= $objDomainInfo->getMaritalStatusLabel();
		break;

	case 'MotherTongue':
		$varPrimary		= 'Mother_TongueId';
		$arrValue		= $objDomainInfo->getMotherTongueOption();
		$varTitle		= $objDomainInfo->getMotherTongueLabel();
		break;

	case 'Country':
		$varPrimary		= 'Country';
		$arrValue		= $arrCountryList;
		$varTitle		= 'Country';
		break;
	
	case 'Occupation':
		$varPrimary		= 'Occupation';
		$arrValue		= $arrOccupationList;
		$varTitle		= 'Occupation';
		break;
	
	case 'Education':
		$varPrimary		= 'Education_Category';
		$arrValue		= $arrEducationList;
		$varTitle		= 'Education';
		break;

	case 'Star':
		$varPrimary		= 'Star';
		$arrValue		= $arrStarList;
		$varTitle		= 'Star';
		break;

	case 'Raasi':
		$varPrimary		= 'Raasi';
		$arrValue		= $arrRaasiList;
		$varTitle		= 'Raasi';
		break;

	case 'Habits':
		$varPrimary		= 'Eating_Habits';
		$arrValue		= $arrEatingHabitsList;
		$varTitle		= 'Eating Habits';
		break;
}//switch

$varResContent = '<div class="fleft" style="width:240px;padding:5px 0px 5px 0px;"></div>
<div class="fleft dotline bld" style="width:125px; padding:5px 0px 5px 0px; text-align:center;">Bride</div>
<div class="fleft dotline bld" style="width:120px; padding:5px 0px 5px 0px; text-align:center;">Groom</div>
<div style="clear:both;"></div><div class="vdotline1"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="1"></div><div class="fleft"  style="width:240px;padding: 0px 0px 0px 0px;"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5"></div><div class="fleft dotline bld" style="width:125px;padding: 0px 0px 0px 0px;text-align:center;"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5"></div>
<div class="fleft dotline bld" style="width:120px;padding: 0px 0px 0px 0px;text-align:center;"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5"></div>
<div style="clear:both;"></div><div style=""><div>';
$varContent		= 0;
$varValidArr	= array();

//CHECK RECORD...
$varWhereCond	= 'WHERE '.$varWhereClause.' AND Publish=1 AND Gender>0 GROUP BY '.$varPrimary.', Gender';
$varFields		= array('COUNT(MatriId) AS CNT', 'Gender', $varPrimary);
$varResSel		= $objDB->select($varTable['MEMBERINFO'], $varFields, $varWhereCond, 0);

$arrSelCntInfo	= array();
while($varRSSInfo	= mysql_fetch_assoc($varResSel)){
	$arrSelCntInfo[$varRSSInfo['Gender']][$varRSSInfo[$varPrimary]] = $varRSSInfo['CNT'];
}

foreach($arrValue as $varKey=>$varVal) 
{
	$varDisplayName		= $varVal;
	$varPrimaryValue	= $varKey;

	if($varDisplayName != ''){
		$varNumOfGroomRecords = $arrSelCntInfo[1][$varKey];
		$varNumOfBrideRecords = $arrSelCntInfo[2][$varKey];
		if ($varNumOfGroomRecords > 0 && $varNumOfBrideRecords > 0) {
		$varContent = 1;
		$varResContent .= '<div class=fleft style=width:240px;padding: 5px 0px 5px 0px;><li><a href="'.$confValues['SERVERURL'].'/feeds/'.$varCommunityCategory.'/'.str_replace($varFind,$varReplace,$varDisplayName).'.html" title="'.$varDisplayName.' Matrimony" class="smalltxt clr1" target="_blank">'.$varDisplayName.'</a></li></div>';

		$varResContent .= '<div class="fleft dotline" style="width:125px;padding: 5px 0px 5px 0px;text-align:center;">
				<a href="'.$confValues['SERVERURL']."/feeds/".$varCommunityCategory."/".str_replace($varFind,$varReplace,$varDisplayName).'/Bride.rss" target="_blank" title="'.$varDisplayName.' Bride RSS Feed"><img src="'.$confValues['IMGSURL'].'/rss/rss.gif" border="0"></a>&nbsp;&nbsp;<a href="'.$confValues['SERVERURL']."/feeds/".$varCommunityCategory."/".str_replace($varFind,$varReplace,$varDisplayName).'/Bride.xml" target="_blank" title="'.$varDisplayName.' Bride XML Feed"><img src="'.$confValues['IMGSURL'].'/rss/xml.gif" border="0"></a></div>';

		$varResContent .= '<div class="fleft dotline" style="width:120px;padding: 5px 0px 5px 0px;text-align:center;">
				<a href="'.$confValues['SERVERURL']."/feeds/".$varCommunityCategory."/".str_replace($varFind,$varReplace,$varDisplayName).'/Groom.rss" target="_blank" title="'.$varDisplayName.' Groom RSS Feed"><img src="'.$confValues['IMGSURL'].'/rss/rss.gif" border="0"></a>&nbsp;&nbsp;<a href="'.$confValues['SERVERURL']."/feeds/".$varCommunityCategory."/".str_replace($varFind,$varReplace,$varDisplayName).'/Groom.xml" target="_blank" title="'.$varDisplayName.' Groom XML Feed"><img src="'.$confValues['IMGSURL'].'/rss/xml.gif" border="0"></a></div>';
		$varValidArr[$varKey] = $varPrimaryValue;
		}
		elseif($varNumOfGroomRecords > 0 || $varNumOfBrideRecords > 0)
		{
			$varValidArr[$varKey] = $varPrimaryValue;
		}
	}
}
$varResContent = ($varContent==1) ? $varResContent.'</div></div>' : '';

if(count($arrValue) == 0){$varResContent = '';}
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/rss.js"></script>
<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5 padl"><font class="clr bld">RSS Search</font></div>
	<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<div>
		<div id="serResArea" class="fleft smalltxt padl">
			<div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><a href="<?=$confValues['SERVERURL']?>"  class="smalltxt clr1"><?=$confValues['PRODUCTNAME']?></a>&nbsp;&raquo;&nbsp;<a href="<?=$confValues['SERVERURL'].'/feeds/'?>"  class="smalltxt clr1"><?=$confValues['PRODUCTNAME']?> Feeds</a><font class="smalltxt"><?=($varPrimary!=''?('&nbsp;&raquo;&nbsp;Feeds by '.$varTitle.'(RSS/XML)'):'');?></font> </div>
			<div style="padding-top:10px;">
				To see a preview of how the feeds look in your website, click your desired <?=$varTitle;?> list below.
			</div><br clear="all">
			<div style="line-height:20px;">			
					<?php
					if($varResContent != ''){
						print $varResContent;
					?>
					<div class="fleft"  style="width:240px;padding: 0px 0px 0px 0px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5"></div>
					<div class="fleft dotline bld" style="width:125px;padding: 0px 0px 0px 0px;text-align:center;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5"></div>
					<div class="fleft dotline bld" style="width:130px;padding: 0px 0px 0px 0px;text-align:center;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5"></div><div style="clear:both;"></div>

					<div class="vdotline1"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1"></div>
					<div class="fright" style="padding: 5px; 0px; 20px; 0px;"></div>

					<div style="float:left; padding: 10px 0px 0px 8px;" class="formborder">
						<form name="form1" method="post" onSubmit="return false;">
						<input type="hidden" value="<?= $varTitle ?>" name="DisplayAlert">
						<div style="float:left; width:500px; padding-top:5px;">
							<div class="mediumtxt bld" style="padding-bottom:5px;">Syndicate / Social Bookmark:</div>
							<div style="float:left;">
								<select name="rssmode" style="width:190px;" class="smalltxt clr inputtext" onchange="replacetxtbox(this.value);checkit(this.value);">
								<option value='0'>Select <?=$varTitle;?></option>
								<?php 
								foreach($varValidArr as $sinVal) 
								{
									$varDisplayName		= str_replace($varFind,$varReplace,$arrValue[$sinVal]);
									echo '<option value="'.$confValues['SERVERURL'].'/feeds/'.$varCommunityCategory.'/'.$varDisplayName.'/">'.$arrValue[$sinVal].'</option>';
								}
								?>
								</select>
							</div>
							<div style="float:left; padding-left:8px;">
								<select name="rssgender" style="width:70px;" class="smalltxt clr inputtext" onchange="replacetxtbox(this.value);">
								<option value="Bride">Bride</option>
								<option value="Groom">Groom</option>
								</select>&nbsp;
							</div>
					
							<div style="float:left; padding-left:0px;">&nbsp;to&nbsp;
								<select name="rsssub" style="width:100px;" class="smalltxt clr inputtext" onchange="replaceimage(this.value);">
								<option value="0">-- Choose --</option>
								<option value="1">My Yahoo</option>

								<option value="3">Add to Google</option> 
								<option value="7">Blogmarks</option>
								<option value="8">newsgator</option>
								<option value="9">Bloglines</option>
								<option value="10">My MSN</option>
								<option value="11">NewsIsFree</option>

								<option value="5">Add to spurl</option> 
								<option value="2">Add to digg</option>
								<option value="4">del.icio.us</option> 
								<option value="6">Furl It</option>
								</select>
							</div>
							<span style="padding:1px 3px 3px 3px;"id="subrssimg"></span>
							<br clear="all">
							<div id="txtbox" style="padding-left: 0px;padding-top: 20px;padding-bottom:15px!important; padding-bottom:0px;"></div>
							<div style="position:absolute; visibility:hidden; height:1px; width:500px;">
								<img src="<?=$confValues['IMGSURL']?>/rss/myyahoo.bmp" border="0">
								<img src="<?=$confValues['IMGSURL']?>/rss/add-to-digg.jpg" border="0">
								<img src="<?=$confValues['IMGSURL']?>/rss/addtogoogle.bmp" border="0">
								<img src="<?=$confValues['IMGSURL']?>/rss/delicious.bmp" border="0">
								<img src="<?=$confValues['IMGSURL']?>/rss/add-to-spurl.jpg" border="0">
								<img src="<?=$confValues['IMGSURL']?>/rss/furlit.bmp" border="0">
								<img src="<?=$confValues['IMGSURL']?>/rss/blogmarks.jpg" border="0">
								<img src="<?=$confValues['IMGSURL']?>/rss/addnewsgator.gif" border="0">
								<img src="<?=$confValues['IMGSURL']?>/rss/addbloglines.gif" border="0">
								<img src="<?=$confValues['IMGSURL']?>/rss/addmymsn.gif" border="0">
								<img src="<?=$confValues['IMGSURL']?>/rss/addnewsisfree.gif" border="0">
							</div><br clear="all">
							<div align="center"><img src="<?=$confValues['IMGSURL']?>/rss/valid-rss.png" border="0" alt="Valid RSS Content"></div>
						</form><br>
						</div>
					</div>
					<br clear="all" />
					<? }//if ?>
			</div>
		</div><br clear="all">
	</div><br clear="all">
	<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
</div>
<?php
//UNSET OBJECT
$objDB->dbClose();
unset($objDB);
unset($objDomainInfo);
?>