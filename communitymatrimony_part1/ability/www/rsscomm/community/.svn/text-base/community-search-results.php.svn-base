<?php
#================================================================================================================
# Author 		: Senthilnathan
# Start Date	: 2009-02-19
# End Date		: 2009-02-19
# Project		: MatrimonyProduct
# Module		: Search - RSS Feed Search
#================================================================================================================
//ROOT DIR
$varRootBasePath = '/home/product/community/ability';

//INCLUDED FILES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsBasicviewHTML.php');
include_once($varRootBasePath.'/lib/clsBasicview.php');

if ($confValues['DOMAINCONFFOLDER'] !="") {		
	include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
}//if

//error_reporting(E_ALL);
//ini_set('display_errors','1');

//OBJECT DECLARATION
$objBasicView	= new BasicView;
$objBasicViewHTML	= new BasicViewHTML;

//Connect DB
$objBasicView->dbConnect('S', $varDbInfo['DATABASE']);

//SESSION OR COOKIE VALUES
$sessMatriId						= $varGetCookieInfo["MATRIID"];
$objBasicViewHTML->clsServerUrl		= $confValues["SERVERURL"];
$objBasicViewHTML->clsImgsUrl		= $confValues["IMGSURL"];
$objBasicViewHTML->clsSessMatriId	= $sessMatriId;

//GET VALUES
$varFind	= array('-matrimonials', 'plus',  '-', 'minus', '~');
$varReplace = array('','+', ' ', '-', '/');
$varCommunityCategory	= $_REQUEST['cat'];
$varSubCategory			= str_replace ($varFind, $varReplace, $_REQUEST['title']);

//REMOVE Others
unset($arrOccupationList[60]);
unset($arrEducationList[10]);
unset($arrMotherTongueList[25]);
unset($arrEthnicityList[13]);
//echo '<br>Category='.$varCommunityCategory.'SubCategory='.$varSubCategory;

switch($varCommunityCategory)
{
	case 'religion':
		$varPrimary				= 'Religion';
		$varFormName			= 'religion';
		//$varTitle				= 'Section';
		$varSelectedArrayName	= $arrReligionList;
		$varSelectedValue		= array_keys($varSelectedArrayName, $varSubCategory);
		break;

	case 'denomination':
		$varPrimary				= 'Denomination';
		$varFormName			= 'denomination';
		//$varTitle				= 'Denomination';
		$varSelectedArrayName	= $arrDenominationList;
		$varSelectedValue		= array_keys($varSelectedArrayName, $varSubCategory);
		break;

	case 'caste':
		$varPrimary				= 'CasteId';
		$varFormName			= 'caste';
		//$varTitle				= 'Caste';
		$varSelectedArrayName	= $arrCasteList;
		$varSelectedValue		= array_keys($varSelectedArrayName, $varSubCategory);
		break;

	case 'subcaste':
		$varPrimary				= 'SubcasteId';
		$varFormName			= 'subcaste';
		//$varTitle				= 'SubcasteId';
		$varSelectedArrayName	= $arrSubcasteList;
		$varSelectedValue		= array_keys($varSelectedArrayName, $varSubCategory);
		break;

	case 'language':
		$varPrimary				= 'Mother_TongueId';
		$varFormName			= 'motherTongue';
		//$varTitle				= 'Mother Tongue';
		$varSelectedArrayName	= $arrMotherTongueList;
		$varSelectedValue		= array_keys($varSelectedArrayName, $varSubCategory);
		break;
	
	case 'country':
		$varPrimary				= 'Country';
		$varFormName			= 'country';
		//$varTitle				= 'Country';
		$varSelectedArrayName	= $arrCountryList;
		$varSelectedValue		= array_keys($varSelectedArrayName, $varSubCategory);
		break;

	case 'state':
		$varPrimary				= 'Residing_State';
		$varFormName			= 'residingState';
		//$varTitle				= 'State';
		$varSelectedArrayName	= $arrResidingStateList;
		$varSelectedValue		= array_keys($varSelectedArrayName, $varSubCategory);
		break;
	
	case 'occupation':
		$varPrimary				= 'Occupation';
		$varFormName			= 'occupation';
		//$varTitle				= 'Occupation';
		$varSelectedArrayName	= $arrOccupationList;
		$varSelectedValue		= array_keys($varSelectedArrayName, $varSubCategory);
		break;
	
	case 'education':
		$varPrimary				= 'Education_Category';
		$varFormName			= 'education';
		//$varTitle				= 'Education';
		$varSelectedArrayName	= $arrEducationList;
		$varSelectedValue		= array_keys($varSelectedArrayName, $varSubCategory);
		break;
	
	case 'marital-status':
		$varPrimary				= 'Marital_Status';
		$varFormName			= 'maritalStatus';
		//$varTitle				= 'Marital Status';
		$varSelectedArrayName	= $arrMaritalList;
		$varSelectedValue		= array_keys($varSelectedArrayName, $varSubCategory);
		break;
	
	case 'bodytype':
		$varPrimary				= 'Body_Type';
		//$varTitle				= 'Body Type';
		$varSelectedArrayName	= $arrBodyTypeList;
		$varSelectedValue		= array_keys($varSelectedArrayName, $varSubCategory);
		break;
	
	case 'bloodgroup':
		$varPrimary				= 'Blood_Group';
		//$varTitle				= 'Blood Group';
		$varSelectedArrayName	= $arrBloodGroupList;
		$varSearchSign 			= substr($varSubCategory,-4);
		$varSubCategory			=  $varSearchSign=='plus'?str_replace('plus','+',$varSubCategory):str_replace('minus','-',$varSubCategory);
		$varSelectedValue = array_keys($varSelectedArrayName, $varSubCategory);
		break;
	

}

//$varHeading	= ($varSubCategory == '') ? $varTitle : $varSubCategory;


$varSelectedValue		= array_keys($varSelectedArrayName, $varSubCategory);
if($varSubCategory != '' && $varPrimary!='' && $varSelectedValue[0]!='')
{
	$varCont = '';
	$varWhereCondF	= 'WHERE '.$varWhereClause.' AND '.$varPrimary.'='.$varSelectedValue[0].' AND Gender=2 AND Publish=1';
	$varWhereCondM	= 'WHERE '.$varWhereClause.' AND '.$varPrimary.'='.$varSelectedValue[0].' AND Gender=1 AND Publish=1';
	if($sessMatriId!=''){
	$varWhereCondF  .= " AND MatriId<>".$objBasicView->doEscapeString($sessMatriId,$objBasicView);
	$varWhereCondM	.= " AND MatriId<>".$objBasicView->doEscapeString($sessMatriId,$objBasicView);
	}
	$varWhereCondF  .= ' ORDER BY Date_Updated DESC LIMIT 6';
	$varWhereCondM  .= ' ORDER BY Date_Updated DESC LIMIT 6';
	$argConditionMale['LIMIT'] = $varWhereCondM;
	$argConditionFeMale['LIMIT'] = $varWhereCondF;

	$varMaleProcess		= 'yes';
	$varFeMaleProcess	= 'yes';
	$varMaleCount		= '0';
	$varFeMaleCount		= '0';
	if ($sessGender !=""){

			if ($sessGender=='1') { $varMaleProcess ='no';  }
			elseif ($sessGender=='2') { $varFeMaleProcess ='no';  }
	}//if

	if ($varMaleProcess=='yes') {
		$varMaleRes = $objBasicView->selectDetails($argConditionMale,''); 
		$varMaleCount	= count($varMaleRes);
	}

	if ($varFeMaleProcess=='yes') { 
		$varFeMaleRes	= $objBasicView->selectDetails($argConditionFeMale,''); 
		$varFeMaleCount	= count($varFeMaleRes);
	}
}

?>
<div class="rpanel fleft">

	<div class="normtxt1 clr2 padb5 padl"><font class="clr bld"><?=$varSubCategory?> Matrimonial Site</font></div>
	<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<form style="margin: 0px; padding: 0px;" name="RSearchForm" action="/search/index.php" method="post">
	<input type="hidden" name="<?=$varFormName?>" value="<?=$varSelectedValue[0]?>">
	<input type="hidden" name="gender" value="1">
	<input type="hidden" name="randId" value="">
	<input type="hidden" name="srchType" value="2">
	<input type="hidden" name="saveSrch" value="">
	<input type="hidden" name="srchId" value="">
	<input type="hidden" name="act" value="srchresult">
	<input type="hidden" name="page" value="1">
	<input type="hidden" name="redirectjspath" id="redirectjspath" value="/search/index.php">
	<center>
		<div class="padt10 rpanelinner">
		<? if ($varFeMaleCount > '0' || $varMaleCount >'0') { ?>

			<? if ($varFeMaleCount > '0') { ?>
			<div class="normtxt clr2 padb5 padt10"><font class="clr bld"><?=$varSubCategory?> Brides</font></div>
			<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
			<?	$objBasicViewHTML->basicview($varFeMaleRes); ?>
		</div>
		<? if ($sessMatriId =="") { ?>
		<div class="rpanelinner padt10"><div class="fright"><input type="button" value="Register Free" class="button" onClick="document.location.href='/../register'" /> &nbsp; <input type="button" value="More Brides" class="button" onClick="funCommunity('2');" /></div>
		</div><br clear="all"><br>
		<div class="rpanelinner"><img src="<?=$confValues['SERVERURL']?>/mailer/images/dot-line.gif" height="1" width="500" /></div>
		<? } echo '<br clear="all">'; }  ?>

		
		<? if ($varMaleCount > '0') { ?>
		<div class="padt10 rpanelinner">
			<div class="normtxt clr2 padb5 padt10"><font class="clr bld"><?=$varSubCategory?> Grooms</font></div>
			<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
			<?	$objBasicViewHTML->basicview($varMaleRes); ?>
		</div>
		<? if ($sessMatriId =="") { ?>
		<div class="rpanelinner padt10"><div class="fright"><input type="button" value="Register Free" class="button" onClick="document.location.href='/../register'" /> &nbsp; <input type="button" value="More Grooms" class="button" onClick="funCommunity('1');" /></div>
		<? } ?>


		<? } ?>
	<? } else { echo 'Sorry, no matching profiles available. Refine your search to get matches'; } ?>
		</div><br clear="all"><br>
	</center>
	</form>
</div>
<?
//UNSET OBJECT
$objBasicView->dbClose();
unset($objBasicView);
unset($objBasicViewHTML);
?>
<SCRIPT LANGUAGE="JAVASCRIPT">
function funCommunity(argGen){
	document.RSearchForm.gender.value=argGen;
	document.RSearchForm.submit();
}//funCommunity
</SCRIPT>