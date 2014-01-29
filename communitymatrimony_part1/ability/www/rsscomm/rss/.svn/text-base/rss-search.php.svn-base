<?php
#================================================================================================================
# Author 		: Senthilnathan
# Start Date	: 2009-02-18
# End Date		: 2009-02-18
# Project		: MatrimonyProduct
# Module		: Search - RSS Feed Search
#================================================================================================================
//FILE INCLUDE
include_once($varRootBasePath.'/lib/clsDomain.php');

//OBJECT DECLERATION
$objDomainInfo	= new domainInfo;
?>
<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5 padl"><font class="clr bld">RSS Search</font></div>
	<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><div style="clear:both;"></div>
	<div>
		<div id="serResArea" class="fleft padl">
			<div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><a href="<?=$confValues['SERVERURL']?>"  class="smalltxt clr1"><?=$confValues['PRODUCTNAME']?></a>&nbsp;&raquo;&nbsp;<font class="smalltxt"><?=$confValues['PRODUCTNAME']?> Feeds</font></div>
			<div style="padding: 0px 0px 3px 1px ;" class="smalltxt bld"><?=$confValues['PRODUCTNAME']?> RSS feeds</div>
			<div style="padding-left: 1px; padding-top: 2px;" class="smalltxt">
			RSS feeds will allow you to access <?=$confValues['PRODUCTNAME']?>'s vast database of Profiles of prospective Bride's and Grooms and the latest profiles added every minute.</div><br clear="all">
			<div class="dotsep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
			<div style="line-height:20px;">
			<?php
			if($objDomainInfo->useReligion()){
				$arrRetVal = $objDomainInfo->getReligionOption();
				$varLabel  = $objDomainInfo->getReligionLabel();
				$varRetCnt = count($arrRetVal);
				if($varRetCnt>1){
					echo '<li><a href="'.$confValues['SERVERURL'].'/feeds/Religion/" title="'.$varLabel.' RSS Feeds" class="smalltxt clr1" target="_blank">RSS by - '.$varLabel.'</a></li>';
				}
			}

			if($objDomainInfo->useDenomination()){
				$arrRetVal = $objDomainInfo->getDenominationOption();
				$varLabel  = $objDomainInfo->getDenominationLabel();
				$varRetCnt = count($arrRetVal);
				if($varRetCnt>1){
					echo '<li><a href="'.$confValues['SERVERURL'].'/feeds/Denomination/" title="'.$varLabel.' RSS Feeds" class="smalltxt clr1" target="_blank">RSS by - '.$varLabel.'</a></li>';
				}
			}

			if($objDomainInfo->useCaste()){
				$arrRetVal = $objDomainInfo->getCasteOption();
				$varLabel  = $objDomainInfo->getCasteLabel();
				$varRetCnt = count($arrRetVal);
				if($varRetCnt>1){
					echo '<li><a href="'.$confValues['SERVERURL'].'/feeds/Caste/" title="'.$varLabel.' RSS Feeds" class="smalltxt clr1" target="_blank">RSS by - '.$varLabel.'</a></li>';
				}
			}
			
			if($objDomainInfo->useSubcaste()){
				$arrRetVal = $objDomainInfo->getSubcasteOption();
				$varLabel  = $objDomainInfo->getSubcasteLabel();
				$varRetCnt = count($arrRetVal);
				if($varRetCnt>1){
					echo '<li><a href="'.$confValues['SERVERURL'].'/feeds/Subcaste/" title="'.$varLabel.' RSS Feeds" class="smalltxt clr1" target="_blank">RSS by - '.$varLabel.'</a></li>';
				}
			}

			if($objDomainInfo->useMaritalStatus()){
				$arrRetVal = $objDomainInfo->getMaritalStatusOption();
				$varLabel  = $objDomainInfo->getMaritalStatusLabel();
				$varRetCnt = count($arrRetVal);
				if($varRetCnt>1){
					echo '<li><a href="'.$confValues['SERVERURL'].'/feeds/MaritalStatus/" title="'.$varLabel.' RSS Feeds" class="smalltxt clr1" target="_blank">RSS by - '.$varLabel.'</a></li>';
				}
			}

			if($objDomainInfo->useMotherTongue()){
				$arrRetVal = $objDomainInfo->getMotherTongueOption();
				$varLabel  = $objDomainInfo->getMotherTongueLabel();
				$varRetCnt = count($arrRetVal);
				if($varRetCnt>1){
					echo '<li><a href="'.$confValues['SERVERURL'].'/feeds/MotherTongue/" title="'.$varLabel.' RSS Feeds" class="smalltxt clr1" target="_blank">RSS by - '.$varLabel.'</a></li>';
				}
			}

			echo '<li><a href="'.$confValues['SERVERURL'].'/feeds/Country/" title="Country RSS Feeds" class="smalltxt clr1" target="_blank">RSS by - Country</a></li>';
			echo '<li><a href="'.$confValues['SERVERURL'].'/feeds/Education/" title="Education RSS Feeds" class="smalltxt clr1" target="_blank">RSS by - Education</a></li>';
			echo '<li><a href="'.$confValues['SERVERURL'].'/feeds/Occupation/" title="Occupation RSS Feeds" class="smalltxt clr1" target="_blank">RSS by - Occupation</a></li>';
			
			if($objDomainInfo->useStar()){
				$arrRetVal = $objDomainInfo->getStarOption();
				$varLabel  = $objDomainInfo->getStarLabel();
				$varRetCnt = count($arrRetVal);
				if($varRetCnt>1){
					echo '<li><a href="'.$confValues['SERVERURL'].'/feeds/Star/" title="'.$varLabel.' RSS Feeds" class="smalltxt clr1" target="_blank">RSS by - '.$varLabel.'</a></li>';
				}
			}

			if($objDomainInfo->useRaasi()){
				$arrRetVal = $objDomainInfo->getRaasiOption();
				$varLabel  = $objDomainInfo->getRaasiLabel();
				$varRetCnt = count($arrRetVal);
				if($varRetCnt>1){
					echo '<li><a href="'.$confValues['SERVERURL'].'/feeds/Raasi/" title="'.$varLabel.' RSS Feeds" class="smalltxt clr1" target="_blank">RSS by - '.$varLabel.'</a></li>';
				}
			}

			echo '<li><a href="'.$confValues['SERVERURL'].'/feeds/Habits/" title="Habits RSS Feeds" class="smalltxt clr1" target="_blank">RSS by - Habits</a></li>';
			?>
			</div>
		</div><br clear="all">
	</div><br clear="all">
	<div class="dotsep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
	<div class="smalltxt bld padl">What is RSS?</div>
	<div style="padding-top: 2px;" class="smalltxt padl">RSS stands for "Really Simple Syndication". It's an XML based format for content distribution. With RSS you can gather information from various sources on the web and make it readily available to you by a single click. RSS enables you to get the latest updates on information you seek. </div>
	<div style="padding-top: 14px;padding-bottom:3px;" class="smalltxt bld padl">How to use <?=$confValues['PRODUCTNAME']?> RSS feeds?</div>
	<div class="smalltxt bld padl">For Webmasters</div>
	<div style="padding-top: 2px;" class="smalltxt padl">
	Feel free to add our RSS feeds to your websites so that visitors to your website can see the latest brides and grooms according to your criteria.</div>
	<div style="padding-top:4px;" class="smalltxt bld padl">For Individuals</div>
	<div style="padding-top: 2px;" class="smalltxt padl">If you want to see the latest brides and grooms from your PC, please download a RSS Reader. 
	</div>
	<br>
	<div class="smalltxt bld padb5 padl">Use the links below to download free RSS Reader</div>
	<div class="padl"><a target="_blank" class="smalltxt clr1" href="http://www.newzcrawler.com">Newz Crawler</a><br>
	<a target="_blank" class="smalltxt clr1" href="http://www.feeddemon.com/feeddemon/index.asp">FeedDemon</a><br>
	<a target="_blank" class="smalltxt clr1" href="http://www.awasu.com/">Awasu</a><br>
	<a target="_blank" class="smalltxt clr1" href="http://www.newsfirerss.com/">Newsfire</a><br>
	<a target="_blank" class="smalltxt clr1" href="http://ranchero.com/netnewswire/">NetNewsWire</a><br>
	<a target="_blank" class="smalltxt clr1" href="http://www.bloglines.com/">Bloglines</a><br>
	<a target="_blank" class="smalltxt clr1" href="http://www.feedzilla.com/">FeedZilla</a><br>
	<a target="_blank" class="smalltxt clr1" href="http://www.mozilla.com/firefox/">Mozilla Firefox</a><br>
	<a target="_blank" class="smalltxt clr1" href="http://directory.google.com/Top/Reference/Libraries/Library_and_Information_Science/Technical_Services/Cataloguing/Metadata/RDF/Applications/RSS/News_Readers/">Other News Readers (GOOGLE)</a>
	</div><br>
	<div class="smalltxt padl">(<b><?=$confValues['PRODUCTNAME']?>.com</b> is not responsible for the content of external internet sites)</div>
	<div style="padding-top: 5px;" class="smalltxt padl">After downloading your RSS Reader, navigate to <?=$confValues['PRODUCTNAME']?> RSS Index Page and select your desired link. Add this link to your RSS Reader.</div>
	<br>
	<div class="smalltxt padl">You can also subscribe to our RSS feeds online through <img border="0" style="vertical-align: middle;" src="<?=$confValues['IMGSURL']?>/rss/myyahoo.bmp"/> , <img border="0" style="vertical-align: middle;" src="<?=$confValues['IMGSURL']?>/rss/addtogoogle.bmp"/><br>and other popular portals.
	</div>
	<div class="smalltxt clr1 padt10 padl"><a class="clr1" target="_blank" href="<?=$confValues['SERVERURL']?>/feeds/terms/">Terms and conditions</a></div>
</div>