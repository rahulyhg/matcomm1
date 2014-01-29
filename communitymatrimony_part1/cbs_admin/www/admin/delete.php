<?php
//echo 'Delete PHP Page';exit;

//FILE INCLUDES
include_once('includes/clsPhotoManagement.php');
//OBJECT DECLARTION
$objPhotoManagement = new PhotoManagement;
//echo '<pre>'; print_r($_REQUEST); echo'</pre>';

//SESSION VARIABLES
$varMatriId	= $_REQUEST['MatriId'];
//echo $varMatriId;
//VARIABLE DECLARATION
$varChoice		= $_REQUEST['choice'];


if($_REQUEST['frmDeletePhoto'] == 'yes' && $varChoice>0 && $varChoice<4)
{
	$varFieldName1	= 'Normal_Photo'.$varChoice;
	$varFieldName2	= 'Thumb_Small_Photo'.$varChoice;
	$varFieldName3	= 'Thumb_Big_Photo'.$varChoice;
	$varFieldName4	= 'Description'.$varChoice;
	$varFieldName5	= 'Photo_Status'.$varChoice;
	
	$objPhotoManagement->clsPrimary			= array('MatriId');
	$objPhotoManagement->clsPrimaryValue 	= array($varMatriId);
	$objPhotoManagement->clsFields			= array('Normal_Photo1','Normal_Photo2','Normal_Photo3','Photo_Status1','Photo_Status2','Photo_Status3');
	$varNoOfRecords = $objPhotoManagement->numOfResults();

	if($varNoOfRecords == 1)
	{
		$varPhotoinfo = $objPhotoManagement->selectPhoto();
		$varPhotoStatus	= $varPhotoinfo[$varFieldName5];
		if($varPhotoinfo[$varFieldName1] != '')
		{
			$varPhotoName	= $varPhotoinfo[$varFieldName1];
			$objPhotoManagement->clsFields			= array($varFieldName1,$varFieldName2,$varFieldName3, 																					$varFieldName4,$varFieldName5);
			$objPhotoManagement->clsFieldsValues	= array('', '', '', '','');
			$objPhotoManagement->updatePhoto();

			if($varPhotoinfo['Photo_Status1']==0 && $varPhotoinfo['Photo_Status2']==0 && $varChoice==3)
			{
				//update Photo_Set_Status as 0 in memberinfo
				$objPhotoManagement->clsTable		 = 'memberinfo';
				$objPhotoManagement->clsFields		 = array('Photo_Set_Status');
				$objPhotoManagement->clsFieldsValues = array(0);
				$objPhotoManagement->updatePhoto();
			}
			
			if($varChoice == 2 && $varPhotoinfo['Normal_Photo3']!='')
			{
				//SELECT THIRD PHOTO VALUES
				$objPhotoManagement->clsFields		= array('Normal_Photo3', 'Thumb_Small_Photo3', 																	'Thumb_Big_Photo3','Description3','Photo_Status3');
				$varThirdPhotoInfo					= $objPhotoManagement->selectPhoto();

				//UPDATE THIRD PHOTO VALUES INTO SECOND PLACE
				$objPhotoManagement->clsFields		= array($varFieldName1,$varFieldName2,$varFieldName3, 		$varFieldName4,$varFieldName5,'Normal_Photo3','Thumb_Small_Photo3','Thumb_Big_Photo3','Description3','Photo_Status3');
				
				$objPhotoManagement->clsFieldsValues= array($varThirdPhotoInfo['Normal_Photo3'], 				$varThirdPhotoInfo['Thumb_Small_Photo3'], $varThirdPhotoInfo['Thumb_Big_Photo3'], 
				$varThirdPhotoInfo['Description3'],$varThirdPhotoInfo['Photo_Status3'],'', '', '', '','');
				
				$objPhotoManagement->updatePhoto();
				
				if($varPhotoinfo['Photo_Status1']==0 && $varPhotoinfo['Photo_Status3']==0)
				{
					//update Photo_Set_Status as 0 in memberinfo
					$objPhotoManagement->clsTable		 = 'memberinfo';
					$objPhotoManagement->clsFields		 = array('Photo_Set_Status');
					$objPhotoManagement->clsFieldsValues = array(0);
					$objPhotoManagement->updatePhoto();
				}

			}//if
			if($varChoice == 1 && $varPhotoinfo['Normal_Photo2']!='' && $varPhotoinfo['Normal_Photo3']!='')
			{
				//SELECT SECOND & THIRD PHOTO VALUES
				$objPhotoManagement->clsFields		= array('Normal_Photo2','Thumb_Small_Photo2','Description2', 'Thumb_Big_Photo2','Photo_Status2','Normal_Photo3','Thumb_Small_Photo3','Thumb_Big_Photo3','Description3','Photo_Status3');

				$varSecondPhotoInfo					= $objPhotoManagement->selectPhoto();

				//UPDATE SECOND & THIRD PHOTO VALUES INTO FIRST & SECOND PLACE
				$objPhotoManagement->clsFields		= array($varFieldName1, $varFieldName2, $varFieldName3, 	$varFieldName4,$varFieldName5,'Normal_Photo2', 'Thumb_Small_Photo2', 'Thumb_Big_Photo2', 'Description2','Photo_Status2', 'Normal_Photo3', 'Thumb_Small_Photo3', 'Thumb_Big_Photo3','Description3','Photo_Status3');

				$objPhotoManagement->clsFieldsValues= array($varSecondPhotoInfo['Normal_Photo2'], 				$varSecondPhotoInfo['Thumb_Small_Photo2'],$varSecondPhotoInfo['Thumb_Big_Photo2'], 
				$varSecondPhotoInfo['Description2'],$varSecondPhotoInfo['Photo_Status2'],$varSecondPhotoInfo['Normal_Photo3'], $varSecondPhotoInfo['Thumb_Small_Photo3'], $varSecondPhotoInfo['Thumb_Big_Photo3'], $varSecondPhotoInfo['Description3'],$varSecondPhotoInfo['Photo_Status3'],'', '', '', '', '');

				$objPhotoManagement->updatePhoto();
				
				if($varPhotoinfo['Photo_Status2']==0 && $varPhotoinfo['Photo_Status3']==0)
				{
					//update Photo_Set_Status as 0 in memberinfo
					$objPhotoManagement->clsTable		 = 'memberinfo';
					$objPhotoManagement->clsFields		 = array('Photo_Set_Status');
					$objPhotoManagement->clsFieldsValues = array(0);
					$objPhotoManagement->updatePhoto();
				}

			}//if
			if($varChoice == 1 && $varPhotoinfo['Normal_Photo2']!='' && $varPhotoinfo['Normal_Photo3']=='')
			{
				//SELECT SECOND PHOTO VALUES
				$objPhotoManagement->clsFields		= array('Normal_Photo2','Thumb_Small_Photo2','Description2', 																			'Thumb_Big_Photo2');
				$varSecondPhotoInfo					= $objPhotoManagement->selectPhoto();

				//UPDATE SECOND PHOTO VALUES INTO FIRST PLACE
				$objPhotoManagement->clsFields		= array($varFieldName1, $varFieldName2, $varFieldName3, 	$varFieldName4,$varFieldName5,'Normal_Photo2','Thumb_Small_Photo2','Description2','Thumb_Big_Photo2','Photo_Status2');
				$objPhotoManagement->clsFieldsValues= array($varSecondPhotoInfo['Normal_Photo2'],
					$varSecondPhotoInfo['Thumb_Small_Photo2'], $varSecondPhotoInfo['Thumb_Big_Photo2'],
					$varSecondPhotoInfo['Description2'],$varSecondPhotoInfo['Photo_Status2'],'','', '', '', '');
				
				$objPhotoManagement->updatePhoto();
				
				if($varPhotoinfo['Photo_Status2'] == 0)
				{
					//update Photo_Set_Status as 0 in memberinfo
					$objPhotoManagement->clsTable		 = 'memberinfo';
					$objPhotoManagement->clsFields		 = array('Photo_Set_Status');
					$objPhotoManagement->clsFieldsValues = array(0);
					$objPhotoManagement->updatePhoto();
				}

			}//if
			if($varChoice == 1 && $varPhotoinfo['Normal_Photo2']=='' && $varPhotoinfo['Normal_Photo3']=='')
			{
				//delete record from memberphotoinfo
				$objPhotoManagement->deletePhoto();

				//update Photo_Set_Status as 0 in memberinfo
				$objPhotoManagement->clsTable		 = 'memberinfo';
				$objPhotoManagement->clsFields		 = array('Photo_Set_Status');
				$objPhotoManagement->clsFieldsValues =array(0);
				$objPhotoManagement->updatePhoto();
			}

			//DELETE PHOTOS FROM DIRECTORY
			$varImageName = '../pending-photos/'.$varPhotoName;
			if(($varPhotoStatus==0) || ($varPhotoStatus==2))	
			{
				unlink($varImageName);
			}
			else
			{
				//DELETE THREE TYPE OF PHOTOS (NL, TS, TB)
				$varPhotourl		= '../membersphoto/'.$varMatriId{1}.'/'.$varMatriId{2}.'/';
				$varImageName		= $varPhotourl.$varPhotoName;
				$varPhotoDetails	= split('_',$varPhotoName);
				$varImageName2		= $varPhotourl.$varPhotoDetails[0].'_'.$varPhotoDetails[1].'_TS_'.$varPhotoDetails[3];
				$varImageName3		= $varPhotourl.$varPhotoDetails[0].'_'.$varPhotoDetails[1].'_TB_'.$varPhotoDetails[3];
				unlink($varImageName);
				unlink($varImageName2);
				unlink($varImageName3);
			}
		}//if
	}//if
	echo'<script language="javascript"> document.location.href = "index.php?act=view&MatriId='.$varMatriId.'";</script>';
}//if
if ($_POST["frmDeletePhoto"]==""){ ?>
<table border="0" width="100%" cellpadding="3" cellspacing="0">
	<tr>
		<td valign="middle" class="textsmallnormal"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="heading">Delete Photo</font></div><font class="smalltxt">Profiles with photo gets 10 times more responses than those without. We strongly recommend you to retain the photo.<br><Br>Concerned about Privacy? If you are a paid member you can use <a href="protect.php" class="formlink1">Protect Photo</a> option to restrict the photo access. If you are not a paid member, <a href="../payment/payment-options.php"class="formlink1">click here</a> to upgrade to paid category in order to utilize this feature.</font></td>
	</tr>
</table>
	
<form name="frmDeletePhoto" method="post">
<input type="hidden" name="frmDeletePhoto" value="yes">
<input type="hidden" name="choice" value="<?=$varChoice;?>">
<table width="100%" border="0" cellspacing="2" cellpadding="2" align="left">
<tr>
		<td class="smalltxt">Are you sure you want to delete the photo? <input type="submit" name="subDeletePhoto" value="Yes" class="button" align="absmiddle"> <input type="submit"  align="absmiddle" name="butDeletePhoto" value="No" class="button" onClick="javascript: history.back();return false;"></td>
		</tr>
</table>
</form>
<?php 
}//if
?><br>