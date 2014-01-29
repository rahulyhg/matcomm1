<?php
//FILE INCLUDE
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath."/conf/cityarray.cil14");
include_once($varRootBasePath.'/lib/clsSearch.php');
include_once('srchcommonfuns.php');

//OBJECT DECLARTION
$objSearch		= new Search;

//DB Connection
$objSearch->dbConnect('S', $varDbInfo['DATABASE']);
//$varWhereCond	= "WHERE MatriId='".$sessMatriId."' ORDER BY Date_Updated DESC";
$varWhereCond	= "WHERE MatriId=".$objSearch->doEscapeString($sessMatriId,$objSearch)." ORDER BY Date_Updated DESC";
$varFields		= array('Search_Id','MatriId','Search_Name','Gender','Marital_Status','Children','Age_From','Age_To','Height_From','Height_To','Physical_Status','Mother_Tongue','Religion','Caste_Or_Division','Subcaste','Gothram','Eating_Habits','Drinking','Smoking','Education','Occupation_Category','Occupation','Citizenship','Country','Residing_District','Resident_Status','Posted_After','Search_By','Show_Photo_Horoscope','Show_Ignore_AlreadyContact','Display_Format','Search_Type','Days','Date_Updated','Residing_State','Chevvai_Dosham', 'Annual_Income','Star','Raasi','Denomination');
$arrResSavedSrchInfo = $objSearch->select($varTable['SEARCHSAVEDINFO'], $varFields, $varWhereCond, 0);
$varNoOfRecs		 = mysql_num_rows($arrResSavedSrchInfo);
$objSearch->dbClose();
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/search.js" ></script>
<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5"><font class="clr bld">Saved searches</font></div>
		<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
		<br clear="all">
		<?if($varNoOfRecs > 0){?>
		<font class="normtxt clr">Given below are a list of searches you have saved. You can edit and delete a search or even search further.</font><br><br>
		<center>
		<div style="display:none; background-color: rgb(238, 238, 238); width: 500px;" class="brdr tlleft pad10" id="delDiv"></div>

		<div class="rpanelinner">
			<?php while($row=mysql_fetch_assoc($arrResSavedSrchInfo)){
			echo savedSearchDetail($row);
			//echo'<div class="linesep"><img width="1" height="1" src="'.$confValues['IMGSURL'].'/trans.gif"/></div>';
			}?>	
		</div>
		</center>
		<?}else{?>
		<br><br><br>
		<center><div class="rpanelinner">Currently there are no saved searches.</div></center>
		<?}?>
	</div>
</div>