<?php
	//BASE DIRECTORY
	$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

	//FILE INCLUDES
	include_once($varRootBasePath."/conf/dbinfo.cil14");
	include_once($varRootBasePath."/lib/clsDB.php");

//POINTS & STEPS
		# 1. Delete non match records in INTERESTRECEIVEDINFO.
			# 1.1- DELETE a FROM interestreceivedinfo a, interestsentinfo_migrationId b WHERE a.Interest_Id<>b.Product_Interest_Id

		# 2. Update from interestsentinfo_migrationId table to product interestreceivedinfo
			#2.1 UPDATE interestreceivedinfo a, interestsentinfo_migrationId b SET a.Interest_Id=b.Community_Interest_Id WHERE a.Interest_Id=b.Product_Interest_Id

	//OBJECT DECLARTION
	$objProductDB	= new DB;
	$objCommunityDB	= new DB;

	//DB CONNECTION
	$objProductDB->dbConnect('M',$varDbInfo['DATABASE']);
	$objCommunityDB->dbConnect('M',$varDbInfo['DATABASE']);
	//$objCommunityDB->dbConnect('M','mmatrimonytemp');

	#Product DB fields
	$varFields		= array('Interest_Id','MatriId','Opposite_MatriId','Interest_Option','Declined_Option','Status','Delete_Status','Date_Received','Date_Acted','Date_Deleted');
	$varCondition	= ' ORDER BY Interest_Id ASC LIMIT 10';
	$varExecute		= $objProductDB->select($varTable['INTERESTRECEIVEDINFO'], $varFields, $varCondition,0);

	while($varInterestSentInfo	= mysql_fetch_array($varExecute)) {

		$varProductInterestId		= $varInterestSentInfo['Interest_Id'];
		$varProductMatriId			= $varInterestSentInfo['MatriId'];
		$varProductOppositeMatriId	= $varInterestSentInfo['Opposite_MatriId'];
		$varProductInterestOption	= $varInterestSentInfo['Interest_Option'];
		$varProductDeclinedOption	= $varInterestSentInfo['Declined_Option'];
		$varProductStatus			= $varInterestSentInfo['Status'];
		$varProductDeleteStatus		= $varInterestSentInfo['Delete_Status'];
		$varProductDateReceived		= $varInterestSentInfo['Date_Received'];
		$varProductDateActed		= $varInterestSentInfo['Date_Acted'];
		$varProductDateDeleted		= $varInterestSentInfo['Date_Deleted'];

		
		//0 - Now, 1 - Accept, 3 - Decline

		//MIGRATE RECORD FROM MMATRIMONY TO COMMUNITYMATRIMONY INTERESTSENTINFO TABLE

		#CommunityMatrimony DB fields
		$varFields		= array('Interest_Id','MatriId','Opposite_MatriId','Interest_Option','Declined_Option','Status','Delete_Status','Date_Received','Date_Acted','Date_Deleted');

		$varFieldsValues	= array("'".$varProductInterestId."'","'".$varProductMatriId."'","'".$varProductOppositeMatriId."'","'".$varProductInterestOption."'","'".$varProductDeclinedOption."'","'".$varProductStatus."'","'".$varProductDeleteStatus."'","'".$varProductDateReceived."'","'".$varProductDateActed."'","'".$varProductDateDeleted."'");

		//New Interest
		$objCommunityDB->insert($varTable['INTERESTRECEIVEDINFO'], $varFields, $varFieldsValues);

		//ACCEPT MEMBERS
		if ($varProductStatus=='1' || $varProductStatus=='3') {

		$varProductStatus = ($varProductStatus=='1') ? '21' : '23';

		#Insert one record into insert accept member INTERESTSENTINFO table
		$varFields	= array('MatriId','Opposite_MatriId','Interest_Option','Declined_Option','Status','Delete_Status','Date_Sent','Date_Acted','Date_Accepted','Date_Deleted');

		$varFieldsValues	= array("'".$varProductMatriId."'","'".$varProductOppositeMatriId."'","'".$varProductInterestOption."'","'".$varProductDeclinedOption."'","'".$varProductStatus."'","'".$varProductDeleteStatus."'","'".$varProductDateSent."'","'".$varProductDateActed."'","'".$varProductDateDeleted."'");

		$varCommunityInterestSentId	= $objCommunityDB->insert($varTable['INTERESTSENTINFO'], $varFields, $varFieldsValues);

		#Insert one record into insert received member INTERESTRECEIVEDINFO table
		$varFields	= array('Interest_Id','MatriId','Opposite_MatriId','Interest_Option','Declined_Option','Status','Delete_Status','Date_Received','Date_Acted','Date_Deleted');

		$varFieldsValues	= array("'".$varCommunityInterestSentId."'","'".$varProductMatriId."'","'".$varProductOppositeMatriId."'","'".$varProductInterestOption."'","'".$varProductDeclinedOption."'","'".$varProductStatus."'","'".$varProductDeleteStatus."'","'".$varProductDateReceived."'","'".$varProductDateActed."'","'".$varProductDateDeleted."'");

		$objCommunityDB->insert($varTable['INTERESTRECEIVEDINFO'], $varFields, $varFieldsValues);


		}


	}

	//DB CLOSE
	$objProductDB->dbClose();
	$objCommunityDB->dbClose();
?>