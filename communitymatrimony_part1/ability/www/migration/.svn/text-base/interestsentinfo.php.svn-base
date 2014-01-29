<?php
	//BASE DIRECTORY
	$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

	//FILE INCLUDES
	include_once($varRootBasePath."/conf/dbinfo.cil14");
	include_once($varRootBasePath."/lib/clsDB.php");

//POINTS & STEPS
		# - Date_Acted  - One more new colum is there in CBS INTERESTSENTINFO table.


	//OBJECT DECLARTION
	$objProductDB	= new DB;
	$objCommunityDB	= new DB;

	//DB CONNECTION
	$objProductDB->dbConnect('M',$varDbInfo['DATABASE']);
	$objCommunityDB->dbConnect('M',$varDbInfo['DATABASE']);
	//$objCommunityDB->dbConnect('M','mmatrimonytemp');

	#Product DB fields
	$varFields		= array('Interest_Id','MatriId','Opposite_MatriId','Interest_Option','Declined_Option','Status','Delete_Status','Date_Sent','Date_Accepted','Date_Deleted');
	$varCondition	= ' ORDER BY Interest_Id ASC LIMIT 10';
	$varExecute		= $objProductDB->select($varTable['INTERESTSENTINFO'], $varFields, $varCondition,0);

	while($varInterestSentInfo	= mysql_fetch_array($varExecute)) {

		$varProductInterestId		= $varInterestSentInfo['Interest_Id'];
		$varProductMatriId			= $varInterestSentInfo['MatriId'];
		$varProductOppositeMatriId	= $varInterestSentInfo['Opposite_MatriId'];
		$varProductInterestOption	= $varInterestSentInfo['Interest_Option'];
		$varProductDeclinedOption	= $varInterestSentInfo['Declined_Option'];
		$varProductStatus			= $varInterestSentInfo['Status'];
		$varProductDeleteStatus		= $varInterestSentInfo['Delete_Status'];
		$varProductDateSent			= $varInterestSentInfo['Date_Sent'];
		$varProductDateAccepted		= $varInterestSentInfo['Date_Accepted'];
		$varProductDateDeleted		= $varInterestSentInfo['Date_Deleted'];
		$varProductDateActed			= '0000-00-00 00:00:00';


		//MIGRATE RECORD FROM MMATRIMONY TO COMMUNITYMATRIMONY INTERESTSENTINFO TABLE

		#CommunityMatrimony DB fields
		$varFields		= array('Interest_Id','MatriId','Opposite_MatriId','Interest_Option','Declined_Option','Status','Delete_Status','Date_Sent','Date_Acted','Date_Accepted','Date_Deleted');

		#Check Decline status
		if ($varProductStatus==3) { 

			$varProductDateActed		= $varProductDateAccepted; 
			$varProductDateAccepted	= $varProductDateActed;

		}//if

		$varFieldsValues	= array("'".$varProductInterestId."'","'".$varProductMatriId."'","'".$varProductOppositeMatriId."'","'".$varProductInterestOption."'","'".$varProductDeclinedOption."'","'".$varProductStatus."'","'".$varProductDeleteStatus."'","'".$varProductDateSent."'","'".$varProductDateActed."'","'".$varProductDateAccepted."'","'".$varProductDateDeleted."'");

		$varCommunityInterestId	= $objCommunityDB->insert($varTable['INTERESTSENTINFO'], $varFields, $varFieldsValues);

		#Update new (Community db INTERESTSENTINFO ) Interest Id in interestsentinfo_migrationId temp table.

		$varCondition		= " Product_Interest_Id='".$varProductInterestId."'";
		$varFields			= array('Community_Interest_Id');
		$varFieldsValues	= array($varCommunityInterestId);
		$objCommunityDB->update($varTable['INTERESTSENTINFO'], $varFields, $varFieldsValues, $varCondition);

	}//while

	//DB CLOSE
	$objProductDB->dbClose();
	$objCommunityDB->dbClose();
?>