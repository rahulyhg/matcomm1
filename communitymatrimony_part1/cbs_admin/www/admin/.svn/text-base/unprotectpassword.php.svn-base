<?php
############### It show past history of followup information ##################################3
#ini_set('display_errors','on');
#error_reporting(E_ALL ^ E_NOTICE);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
//OBJECT DECLARTION
$objSlave	= new DB;
$objMaster	= new DB;
//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);
$matrid = $_REQUEST['matrid'];
$varThroughViewProfile	= $_REQUEST['tvprofile'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE>TM-Searchby MatriId </TITLE>
  <SCRIPT LANGUAGE="JavaScript">
function  validation()
{
  if(document.searchbyid.matrid.value =='')
  {
	document.searchbyid.matrid.focus();
	alert ("Please Enter the MatriId");
	return false;
  }
  else
	  return true;
}

  </SCRIPT>
 </HEAD>
<FORM METHOD=POST Name="searchbyid" ACTION="" onsubmit="return validation();">
 <BODY>
 <title>Search By Matri-Id</title>
  <center>
  <br/>
  <table cellspacing="0" cellpadding="0" border="0" align="center" class="formborder" width='540'>
    <tr align=left><td class="adminformheader" colspan="3" style="padding-left:15px;_padding-left:15px;">
	<font><b>Unprotect Photo Password</font>
	</td></tr>
	<tr align=left><td height="7">&nbsp;
	</td></tr>
	<?php if(!isset($varThroughViewProfile)){?>
	<tr align=left><td>
	<font class='mediumtxt'>&nbsp;&nbsp;&nbsp;&nbsp;<b>Matrid :</b></font>
	<INPUT TYPE="text" NAME="matrid" size=35 value="<?=$matrid;?>">
	<INPUT TYPE="submit" name="submit" class="button" value="Submit">
	</SELECT>
	</td></tr>
	<?php }?>
	<tr align=left><td height="7">&nbsp;
	</td></tr>
	</table>

	 <table border=0 cellpadding=1 cellspacing=2 width='540'>
	<tr><td>

	<?if(isset($_REQUEST['submit']) || isset($_REQUEST['unprotect_submit']) ||($varThroughViewProfile=="yes")){

			 $matrid = $_REQUEST['matrid'];
			if(isset($_REQUEST['unprotect_submit']) && trim($_REQUEST['matrid'])!=''){
            $varUpdateFields	= array("protect_photo_set_status");
	        $varUpdateVal	    = array(0);
	        $varUpdateCondtn	= " MatriId=".$objMaster->doEscapeString($matrid,$objMaster);
	        $updateid           = $objMaster->update($varTable['MEMBERINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

			$varUpdateFields	= array("Photo_Protected","Photo_Protect_Password");
	        $varUpdateVal	    = array(0,"''");
	        $varUpdateCondtn	= " MatriId=".$objMaster->doEscapeString($matrid,$objMaster);
	        $updateid           = $objMaster->update($varTable['MEMBERPHOTOINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
            echo "<br><center>The password has been reset for given matriId - $matrid</center>";
			}

			$argCondition				=" WHERE matriid=".$objSlave->doEscapeString($matrid,$objSlave);
			$varUpdatedNoOfRecords		= $objSlave->numOfRecords($varTable['MEMBERINFO'],'MatriId',$argCondition);

				if($varUpdatedNoOfRecords==0){
					echo "<br><center>The given $matrid  matrid is not found</center>";
				}
				else{

					$varFields1		= array('Matriid','protect_photo_set_status');
					$varCondition1	= " where MatriId=".$objSlave->doEscapeString($matrid,$objSlave);
     				$varResults1	= $objSlave->select($varTable['MEMBERINFO'],$varFields1, $varCondition1,1);
					$photo_status   = $varResults1[0]['protect_photo_set_status'];

					$varFields2		= array('Matriid','Photo_Protected','Photo_Protect_Password');
					$varCondition2	= " where MatriId=".$objSlave->doEscapeString($matrid,$objSlave);
					$varResults2	= $objSlave->select($varTable['MEMBERPHOTOINFO'],$varFields2, $varCondition2,1);
					$Prote_Password = $varResults2[0]['Photo_Protect_Password'];
					$Photo_Protected= $varResults2[0]['Photo_Protected'];


					if(($varResults1[0]['protect_photo_set_status']==1 or $varResults2[0]['Photo_Protected']==1)){
                           $Photo_Protected_status = 'Yes';
					}else{ $Photo_Protected_status = 'No';}

					?>
				<BR><BR>
				<table border=0 cellpadding=0 cellspacing=1 width=70% bgcolor=#898D72 align=center>
				<tr><td height=18>&nbsp;&nbsp;<font color=white face=arial size=2><b>Photo Protect Information</td></tr>
				<tr><td>
				<table border=0 cellpadding=0 cellspacing=0 width=100% bgcolor=white>
				<tr><td colspan=2>
				<table border=1 cellpadding=0 cellspacing=0 width=100% align=center>
				<tr height=18><td class="adminformheader">MatriId</td><td class="adminformheader"><?=$matrid?></td></tr>
				<tr height=18><td class="adminformheader">Photo Protected</td>
				<td class="adminformheader"><?=$Photo_Protected_status;?></td></tr>
                <?php if($Photo_Protected_status == 'Yes'){ ?>
				<tr height=18><td class="adminformheader">Photo Password</td>
				<td class="adminformheader"><?=$Prote_Password;?>&nbsp;</td></tr>
				<tr height=18 ><td class="adminformheader" colspan="2" align="center">
				<INPUT TYPE="submit" name="unprotect_submit" class="button" value="Unprotect Password"></td></tr>
				<? } ?>
				</table>
				</td></tr></table>
				</td></tr></table>


				<?	 }

			//}//cbssupportiface closed

		//}//$val closed

	}
	 $objSlave->dbClose();
	?>
	</td></tr>
	</table>

  </center>
 </BODY>
 </FORM>
</HTML>
