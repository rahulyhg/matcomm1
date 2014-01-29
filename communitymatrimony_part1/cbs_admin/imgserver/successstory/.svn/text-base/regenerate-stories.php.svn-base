<?php
#=====================================================================================================================================
# Author 	  : Srinivasan C
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : success.php
#=====================================================================================================================================
# Description : getting success story information
#=====================================================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/lib/clsSuccessMailer.php");

//OBJECT CREATION
$objSuccess	= new SuccessMailer;
$objSlave	= new SuccessMailer;

$objSuccess->dbConnect('M', $varDbInfo['DATABASE']);
$objSlave->dbConnect('S', $varDbInfo['DATABASE']);
        
		$varMatriId		= $_REQUEST['MatriId'];
		$varActFields	= array("Success_Id","Photo");
		$varActCondtn	= " WHERE MatriId='".$varMatriId."'";
		$varActInf		= $objSuccess->select($varTable['SUCCESSSTORYINFO'],$varActFields,$varActCondtn,1);

		$varUpdateCondtn	    = " MatriId='".$_REQUEST['MatriId']."'";
		$varProfileUpdateFields	= array("Incomplete_Photo_Flag","Photo_Set_Status");
		$varProfileUpdateVal	= array("1","1");
		$objSuccess->update($varTable['SUCCESSSTORYINFO'], $varProfileUpdateFields, $varProfileUpdateVal, $varUpdateCondtn);

        //REGENERATE TEXT FILE
		
		$matriIdPrefix     = substr($_REQUEST['MatriId'],0,3);
		$folderName        = $arrFolderNames[$matriIdPrefix];
		$storiesFolderPath = $varRootBasePath."/www/success/$folderName/stories/";
                				
				$countFile = $storiesFolderPath."count.txt";
				if(is_file($countFile)){
					$countFileHandle = fopen($countFile,'r+');
				}else{
					$countFileHandle = fopen($countFile,'w');
					chmod($countFile,0777);  
					fwrite($countFileHandle,'0');
				}
				$countNumber = @fread($countFileHandle,filesize($countFile));
				$found = 0;
				for($j=1;$j<=$countNumber;$j++){
					$delFileName = $j.'_'.$_REQUEST['MatriId'].'.txt';
					$fulpath     = $storiesFolderPath.$delFileName;
					if(is_file($fulpath)){
                        $found = 1;
						unlink($fulpath);
						break;
					}
				}
                                
				$argFields = array('MatriId','Bride_Name','Groom_Name','Success_Message','Marriage_Date','Photo_Set_Status','CommunityId','Photo');
			    $argCondition			= "WHERE Success_Id=".addslashes(strip_tags(trim($varActInf[0]['Success_Id'])))."";
			    $varSelectSuccessForFileRow = $objSlave -> select($varTable['SUCCESSSTORYINFO'],$argFields,$argCondition,1);

				$CommunityId=$varSelectSuccessForFileRow[0]['CommunityId'];
			    $folderNameId=$arrMatriIdPre[$CommunityId];
			    $folderName=$arrFolderNames[$folderNameId];
			    $pendingPhotosDir = $varRootBasePath."/www/success/".$folderName."/pendingphotos";
                $bigPhotosDir = $varRootBasePath."/www/success/".$folderName."/bigphotos";
                $smallPhotosDir = $varRootBasePath."/www/success/".$folderName."/smallphotos";
                $homePhotosDir = $varRootBasePath."/www/success/".$folderName."/homephotos";

                $MarriageDate=explode(" ",$varSelectSuccessForFileRow[0]['Marriage_Date']);
								
				$varSelectSuccessForFileContent = $varSelectSuccessForFileRow[0]['MatriId']."|".$varSelectSuccessForFileRow[0]['Bride_Name']."|".$varSelectSuccessForFileRow[0]['Groom_Name']."|".$varSelectSuccessForFileRow[0]['Success_Message']."|".$MarriageDate[0]."|".$varSelectSuccessForFileRow[0]['Photo_Set_Status'];
				$newFileName = $fulpath;
				$newFileHandle = fopen($newFileName,'x+');
				fwrite($newFileHandle,"".$varSelectSuccessForFileContent);
				fclose($newFileHandle);

				//$path =' http://www.communitymatrimony.com/admin/index.php?act=manage-incomplete-photo&page='.$_REQUEST['page'].'&flag='.$_REQUEST['flag'];

                //echo "<script>location.href='".$path."'</script>";

				echo $_REQUEST['page'].'~'.$_REQUEST['MatriId'].'~'.$_REQUEST['flag'];
				
				//header('location : http://www.communitymatrimony.com/admin/index.php?act=manage-incomplete-photo&page='.$_REQUEST['page'].'&flag='.$_REQUEST['flag']);
		


?>
