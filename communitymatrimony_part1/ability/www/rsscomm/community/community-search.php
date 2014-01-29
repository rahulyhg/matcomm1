<?php
#================================================================================================================
# Author 		: Senthilnathan
# Start Date	: 2009-02-19
# End Date		: 2009-02-19
# Project		: MatrimonyProduct
# Module		: Search - RSS Feed Search
#================================================================================================================

$varRootBasePath	= '/home/product/community/ability';

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/vars.cil14');
if ($confValues['DOMAINCONFFOLDER'] !="") {		
	
	include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");

}//if

//UNSET others
unset($arrOccupationList[60]);
unset($arrEducationList[10]);
unset($arrMotherTongueList[25]);
unset($arrCasteList[9997]);
unset($arrDenominationList[9997]);

unset($arrSubcasteList[9997]);
unset($arrSubcasteList[9998]);
unset($arrSubcasteList[9999]);

unset($arrOccupationList[9997]);
unset($arrMotherTongueList[9997]);


//VARIABLE DECLERATION
$varArrReligionCnt		= count($arrReligionList);
$varArrCasteCnt			= count($arrCasteList);
$varArrSubCasteCnt		= count($arrSubcasteList);
$varArrDenominationCnt	= count($arrDenominationList);
$varArrCountryCnt		= count($arrCountryList);
$varArrOccupCnt			= count($arrOccupationList);
$varArrLanguageCnt		= count($arrMotherTongueList);

$varFind	= array('+', '-', ' ', '/');
$varReplace = array('plus', 'minus', '-', '~');

?>
<style type="text/css">
.und {color:#000000;text-decoration:underline;}
a.und:hover{text-decoration:underline;}
</style>
<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5 padl"><font class="clr bld">Popular Matrimony Search</font><a name="top"></a></div>
	<div class="linesep fright" style="width:550px;"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
	<div class="smalltxt clr padt5 padl">View Matrimonial Profiles by :</div>
	<div class="smalltxt clr2 padt5 padl">
	<? 
		if ($_FeatureReligion=='1' && $varArrReligionCnt>1) { echo '<a href="#rel" class="clr1">Religion</a> &nbsp;|&nbsp;'; } 

		if ($_FeatureDenomination=='1' && $varArrDenominationCnt>1) { echo '<a href="" class="clr1">Denomination</a> &nbsp;|&nbsp;'; } 

		if ($_FeatureCaste=='1' && $varArrCasteCnt>1) { echo '<a href="" class="clr1">Caste</a> &nbsp;|&nbsp;'; } 

		if ($_FeatureSubcaste=='1' && $varArrSubCasteCnt>0) { echo '<a href="#subcas" class="clr1">Subcaste</a> &nbsp;|&nbsp;'; }
	?>

	<a href="#ctry" class="clr1">Country</a> &nbsp;|&nbsp; <a href="#indstat" class="clr1">India States</a> &nbsp;|&nbsp; <a href="#usastat" class="clr1">USA States</a> &nbsp;|&nbsp; <a href="#mtong" class="clr1">Mother tongue</a> &nbsp;|&nbsp; <a href="#mstat" class="clr1">Marital Status</a> &nbsp;|&nbsp; <a href="#educ" class="clr1">Education</a> &nbsp;|&nbsp; <a href="#occu" class="clr1">Occupation</a> &nbsp;|&nbsp; <a href="#btype" class="clr1">Body Type</a> &nbsp;|&nbsp; <a href="#bgroup" class="clr1">Blood Group</a></div><br clear="all">
	<center>
		<div class="rpanelinner">
			<? if ($_FeatureReligion=='1' && $varArrReligionCnt>1) { ?>
			<div class="normtxt clr2 padb5 padt10"><font class="clr bld"><?=$_LabelReligion?></font><a name="rel"></a></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">

			<? foreach($arrReligionList as $varKey=>$varValue) {
					echo '<a href="'.$confValues['SERVERURL'].'/matrimonials/religion/'.str_replace($varFind,$varReplace,$varValue).'-matrimonials/" class="smalltxt und" title="'.$varValue.' Matrimony">'.$varValue.'</a> &nbsp; ';
					
				} ?></div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">

			<? } ?>
			
			
			<? if ($_FeatureDenomination=='1' && $varArrDenominationCnt>1) { ?>
			<div class="normtxt clr2 padb5 padt10"><font class="clr bld"><?=$_LabelDenomination?></font></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">

			<? foreach($arrDenominationList as $varKey=>$varValue) {
					echo '<a href="'.$confValues['SERVERURL'].'/matrimonials/denomination/'.str_replace($varFind,$varReplace,$varValue).'-matrimonials/" class="smalltxt und" title="'.$varValue.' Matrimony">'.$varValue.'</a> &nbsp; ';
					
				} ?></div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">

			<? } ?>			
			
			<? if ($_FeatureCaste=='1' && $varArrCasteCnt>1) { ?>

			<div class="normtxt clr2 padb5 padt10"><font class="clr bld"><?=$_LabelCaste?></font></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">
				
			<? foreach($arrCasteList as $varKey=>$varValue) {
					echo '<a href="'.$confValues['SERVERURL'].'/matrimonials/caste/'.str_replace($varFind,$varReplace,$varValue).'-matrimonials/" class="smalltxt und" title="'.$varValue.' Matrimony">'.$varValue.'</a> &nbsp; ';
					
				} ?></div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">

			<? } if ($_FeatureSubcaste=='1' && $varArrSubCasteCnt>0) { ?>

			<div class="normtxt clr2 padb5 padt10"><font class="clr bld">SubCaste</font><a name="subcas"></a></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">
				
			<? foreach($arrSubcasteList as $varKey=>$varValue) {
					echo '<a href="'.$confValues['SERVERURL'].'/matrimonials/subcaste/'.str_replace($varFind,$varReplace,$varValue).'-matrimonials/" class="smalltxt und" title="'.$varValue.' Matrimony">'.$varValue.'</a> &nbsp; ';
					
				} ?></div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">
			<? } ?>

			<div class="normtxt clr2 padb5 padt10"><font class="clr bld">Country</font><a name="ctry"></a></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">

<a href="/matrimonials/country/India-matrimonials/" class="smalltxt und">India</a>&nbsp;&nbsp;
<a href="/matrimonials/country/United-States-of-America-matrimonials/" class="smalltxt und">United States of America</a>&nbsp;&nbsp;
<a href="/matrimonials/country/United-Arab-Emirates-matrimonials/" class="smalltxt und">United Arab Emirates</a>&nbsp;&nbsp;
<a href="/matrimonials/country/Malaysia-matrimonials/" class="smalltxt und">Malaysia</a>&nbsp;&nbsp;
<a href="/matrimonials/country/United-Kingdom-matrimonials/" class="smalltxt und">United Kingdom</a>&nbsp;&nbsp;
<a href="/matrimonials/country/Australia-matrimonials/" class="smalltxt und">Australia</a>&nbsp;&nbsp;
<a href="/matrimonials/country/Saudi-Arabia-matrimonials/" class="smalltxt und">Saudi Arabia</a>&nbsp;&nbsp;
<a href="/matrimonials/country/Canada-matrimonials/" class="smalltxt und">Canada</a>&nbsp;&nbsp;
<a href="/matrimonials/country/Singapore-matrimonials/" class="smalltxt und">Singapore</a>&nbsp;&nbsp;
<a href="/matrimonials/country/Kuwait-matrimonials/" class="smalltxt und">Kuwait</a> &nbsp;&nbsp; <a href="<?=$confValues['SERVERURL']?>/search/?act=advsearch" class="smalltxt clr1">More >></a>



			</div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">
			<div class="normtxt clr2 padb5 padt10"><font class="clr bld">India States</font><a name="indstat"></a></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">
				<? foreach($arrResidingStateList as $varKey=>$varValue) {
					echo '<a href="'.$confValues['SERVERURL'].'/matrimonials/state/'.str_replace($varFind,$varReplace,$varValue).'-matrimonials/" class="smalltxt und" title="'.$varValue.' Matrimony">'.$varValue.'</a> &nbsp; ';
					
				}?></div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">

			<div class="normtxt clr2 padb5 padt10"><font class="clr bld">USA States</font><a name="usastat"></a></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">
				<? foreach($arrUSAStateList as $varKey=>$varValue) {
					echo '<a href="'.$confValues['SERVERURL'].'/matrimonials/state/'.str_replace($varFind,$varReplace,$varValue).'-matrimonials/" class="smalltxt und" title="'.$varValue.' Matrimony">'.$varValue.'</a> &nbsp; ';
					
				}?></div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">

			<div class="normtxt clr2 padb5 padt10"><font class="clr bld">Mother Tongue</font><a name="mtong"></a></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">

				<? foreach($arrMotherTongueList as $varKey=>$varValue) {
					echo '<a href="'.$confValues['SERVERURL'].'/matrimonials/language/'.str_replace($varFind,$varReplace,$varValue).'-matrimonials/" class="smalltxt und" title="'.$varValue.' Matrimony">'.$varValue.'</a> &nbsp; ';
					
				}?></div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">
			<div class="normtxt clr2 padb5 padt10"><font class="clr bld">Marital Status</font><a name="mstat"></a></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">

				<? foreach($arrMaritalList as $varKey=>$varValue) {
					echo '<a href="'.$confValues['SERVERURL'].'/matrimonials/marital-status/'.str_replace($varFind,$varReplace,$varValue).'-matrimonials/" class="smalltxt und" title="'.$varValue.' Matrimony">'.$varValue.'</a> &nbsp; ';
					
				}?>
			</div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">
			<div class="normtxt clr2 padb5 padt10"><font class="clr bld">Education</font><a name="educ"></a></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">
				<? foreach($arrEducationList as $varKey=>$varValue) {
					echo '<a href="'.$confValues['SERVERURL'].'/matrimonials/education/'.str_replace($varFind,$varReplace,$varValue).'-matrimonials/" class="smalltxt und" title="'.$varValue.' Matrimony">'.$varValue.'</a> &nbsp; ';
					
				}?>
			</div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">
			<div class="normtxt clr2 padb5 padt10"><font class="clr bld">Occupation</font><a name="occu"></a></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">
				<? foreach($arrOccupationList as $varKey=>$varValue) {
					echo '<a href="'.$confValues['SERVERURL'].'/matrimonials/occupation/'.str_replace($varFind,$varReplace,$varValue).'-matrimonials/" class="smalltxt und" title="'.$varValue.' Matrimony">'.$varValue.'</a> &nbsp; ';
				}?>
			</div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">

			<div class="normtxt clr2 padb5 padt10"><font class="clr bld">Body Type</font><a name="btype"></a></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">
				<? foreach($arrBodyTypeList as $varKey=>$varValue) {
					echo '<a href="'.$confValues['SERVERURL'].'/matrimonials/bodytype/'.str_replace($varFind,$varReplace,$varValue).'-matrimonials/" class="smalltxt und" title="'.$varValue.' Matrimony">'.$varValue.'</a> &nbsp; ';
				}?>
			</div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">

			<div class="normtxt clr2 padb5 padt10"><font class="clr bld">Blood Group</font><a name="bgroup"></a></div>
			<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
			<div class="padt5 tljust">
				<? foreach($arrBloodGroupList as $varKey=>$varValue) {
					echo '<a href="'.$confValues['SERVERURL'].'/matrimonials/bloodgroup/'.str_replace($varFind,$varReplace,$varValue).'-matrimonials/" class="smalltxt und" title="'.$varValue.' Matrimony">'.$varValue.'</a> &nbsp; ';
				}?>
			</div><div class="fright"><a href="#top" class="smalltxt clr1">Top</a></div><br clear="all">
		</div>
	</center>
</div><br clear="all">