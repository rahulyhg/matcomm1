<?php
/* **************************************************************************************************
FILENAME        :supportgetsta.php
AUTHOR			:A.Kirubasankar
PROJECT			:ccinterface(Allsec)
DESCRIPTION     : this will give the matchingprofilecount
************************************************************************************************* */
//BASE PATH
$varRootBasePath = '/home/product/community';

include_once($varRootBasePath.'/www/admin/includes/config.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/paymentassistance.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');

global $adminUserName;
if($adminUserName == "")
	header("Location: ../index.php?act=login");

$varTable['CBSTMMATCHINGCOUNT'] = "cbstmmatchingcount";
//OBJECT DECLARTION


$objSlaveMatri = new DB;
$objMasterMatri = new DB;

//Connecting communitymatrimony db
$objSlaveMatri -> dbConnect('S',$varDbInfo['DATABASE']);
$objMasterMatri -> dbConnect('M',$varCbstminterfaceDbInfo['DATABASE']);


$memberid = mysql_real_escape_string($_REQUEST['mid']);

$matchingRes=0;

$fileContent=file_get_contents("http://www.communitymatrimony.com/tm/tm_count.php?id=".$memberid."");
$matchingRes = $fileContent;

if(strlen($fileContent) > 0)
{
	$xmlData = new SimpleXMLElement($fileContent);
	$matchingRes = $xmlData;
	if($matchingRes > 0)
	{

		$argTblName = $varCbstminterfaceDbInfo['DATABASE'].".".$varTable['CBSTMMATCHINGCOUNT'];
		$argFields = array("MatriId","MatchingCount","DateUpdatedOn");
		$argFieldsValue = array("'".$memberid."'",$matchingRes,"now()");
		$objMasterMatri -> insertOnDuplicate($argTblName, $argFields, $argFieldsValue, "MatriId");
		if($objMasterMatri -> clsErrorCode == "INSERT_ON_DUP_ERR")
		{
			mail("suresh.a@bharatmatrimony.com","PA - supportgetsta.php","Error ".$objMasterMatri -> clsErrorCode);
		}

		//$argCondition = " where MatriId='".$matriId."' and DateUpdatedOn >= (curdate()- Interval 3 day)";
		/*
		$threeDaysBack = date("Y-m-d",strtotime("-3 days"));
		$argCondition = " where MatriId='".$matriId."' and DateUpdatedOn >=  '$threeDaysBack'";
		$matchingCount	= $objSlaveMatri -> numOfRecords($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['CBSTMMATCHINGCOUNT'], 'MatchingCount', $argCondition);
		*/

		

		/*
		$argConditionID = " where MatriId='".$memberid."'";
		$idCount	= $objSlaveMatri -> numOfRecords($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['CBSTMMATCHINGCOUNT'], 'MatchingCount', $argConditionID);
		if($idCount > 0)
		{
			$argFields = array("MatchingCount","DateUpdatedOn");
			$argFieldsValue = array($matchingRes,"now()");
			$argCondition = " Matriid = '".$memberid."'";
			$objMasterMatri -> update($varCbstminterfaceDbInfo['DATABASE'].".".$varTable['CBSTMMATCHINGCOUNT'], $argFields, $argFieldsValue, $argCondition);
		}
		else
		{
			$argTblName = $varCbstminterfaceDbInfo['DATABASE'].".".$varTable['CBSTMMATCHINGCOUNT'];
			$argFields = array("MatriId","MatchingCount","DateUpdatedOn");
			$argFieldsValue = array("'".$memberid."'",$matchingRes,"'now()'");
			$objMasterMatri -> insert($argTblName, $argFields, $argFieldsValue);
		}
		*/
	}
}

echo $matchingRes;
exit;

if(strlen($fileContent)>0) {
//	$xmlData = new SimpleXMLElement($fileContent);
//	$matchingRes = $xmlData;
	/*
		if($matchingRes>0) {
			$objMaster= new db(); 
			$objMaster->connect($DBCONIP['IDBSER3'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['CBSTMINTERFACE']); 
			$matchIns ="Insert into ".$TABLE['CBSTMMATCHINGCOUNT']." (MatriId,MatchingCount,DateUpdatedOn) values('".$matriId."','".$matchingRes."',curdate()) on duplicate key update MatriId ='".$matriId."',MatchingCount='".$matchingRes."',DateUpdatedOn=curdate()";
			$objMaster->insert($matchIns);
	   }
	  */
}


/*
// Partner Preference gathered for Logged in Member //
$matchFields = array('MatriId','Height_From','Height_To','Age_From','Age_To','Mother_Tongue','Religion','Caste','Physical_Status','Chevvai_Dosham','Education','Eating_Habits','Country','Resident_India_State','Resident_USA_State','Denomination');
$argCondition = " WHERE MatriId = '".$memberid."'";
$num_selected_rows = $objSlaveMatri -> numOfRecords($varTable['MEMBERPARTNERINFO'], 'MatriId', $argCondition);
$matchQuery = $objSlaveMatri -> select($varTable['MEMBERPARTNERINFO'],$matchFields,$argCondition,0);
if($objSlaveMatri -> clsErrorCode == "SELECT_ERR")
{
	echo "Database Error";
	exit;
}

// Iamlookingfor Query Genration //
if($num_selected_rows >= 1 )
{
	$row_match = mysql_fetch_assoc($matchQuery);

	$argTotalCondition = " WHERE ";

	// Checking condition for Language
	if(trim($row_match['Mother_Tongue']) != "" && trim($row_match['Mother_Tongue'])!="0")
	{
		if(preg_match("/,/",$row_match['Mother_Tongue'])) {
			$match_lang_split = explode(",",$row_match['Mother_Tongue']);
			$argTotalCondition .= " ( ";
			$array_count = count($match_lang_split);
			for($i=0;$i<$array_count;$i++){
				$query_language .= " Mother_TongueId = ".$match_lang_split[$i]." or ";
			}
			$argTotalCondition .= substr($query_language,0,-4);
	}else{
		$argTotalCondition .= " ( Mother_TongueId = ".$row_match['Mother_Tongue'];
	}
	$argTotalCondition .= "  ) and ";
}


// Checking condition for Gender 
if($row_match['Gender']=='2')  $argTotalCondition .= " (Gender='2')"; else $argTotalCondition .= " (Gender='1')";



// Checking condition for Height and Age		
$argTotalCondition .= " AND (Height >= '".$row_match['Height_From']."' AND Height <= '".$row_match['Height_To']."') AND (Age >= '".$row_match['Age_From']."' AND Age <= '".$row_match['Age_To']."')"; 


// Checking condition for Match Religion	
if(trim($row_match['Religion']) != "" && trim($row_match['Religion']) != "0" )
{
	$argTotalCondition .= " AND ( ";
	if(preg_match("/,/",$row_match['Religion']))
	{
		$match_religion_split = explode(",",$row_match['Religion']);
		$array_count = count($match_religion_split);
		if($array_count >= 1)
		{
			for($i=0;$i<$array_count;$i++)
			{
				$query_religion .= " Religion = ".$match_religion_split[$i]." or ";
			}
		}
		$argTotalCondition .= substr($query_religion,0,-4);
	}
	else
	{
		$argTotalCondition .= " Religion = ".$row_match['Religion'];
	}
	$argTotalCondition .= " ) ";
} 


// Checking condition for Match Marital Status
if(trim($row_match['MatchMaritalStatus']) != "" && trim($row_match['MatchMaritalStatus']) != "0" )
{
	if(preg_match("/,/",$row_match['MatchMaritalStatus']))
	{
		$match_MaritalStatus_split = explode(",",$row_match['MatchMaritalStatus']);	
		$array_count = count($match_religion_split);
		for($i=0;$i<$array_count;$i++){
			$query_MaritalStatus.= " MaritalStatus = ".$match_MaritalStatus_split[$i]." or ";
		}
		$query .= " AND ( ";
		$query .= substr($query_MaritalStatus,0,-4);
		$query .= " ) ";
	}
	else
	{
		$query .= " AND ( ";
		$query .= " MaritalStatus = ".$row_match['MatchMaritalStatus'];
		$query .= " ) ";
    }
}

// Checking condition for Match Caste
if(trim($row_match['Caste']) != "" && $row_match['Caste'] != 0)
{
	if(preg_match("/,/",$row_match['Caste']))
	{
		$match_MatchCaste_split = explode(",",$row_match['Caste']);
		$array_count = count($match_MatchCaste_split);
		for($i=0;$i<$array_count;$i++)
		{
			if($match_MatchCaste_split[$i]>0)
				$query_MatchCaste.= " Caste = ".$match_MatchCaste_split[$i]." or ";
		}
		$argTotalCondition .= " AND ( ";
		$argTotalCondition .= substr($query_MatchCaste,0,-4);
		$argTotalCondition .= " )";		
	}
	else
	{ 
		if($row_match['Caste']>0)
		{
			$argTotalCondition .= " AND ( ";
			$argTotalCondition .= " Caste =  ".$row_match['Caste'];
			$argTotalCondition .= " )";
		}
   }
}


// Checking condition for Physical Status 
if(trim($row_match['Physical_Status']) != "" && $row_match['Physical_Status'] != 0 )
{
	$argTotalCondition .= " and ( Physical_Status = ".$row_match['Physical_Status']." ) ";
}


// Checking condition for Manglik
if(trim($row_match['Chevvai_Dosham']) != ""  && trim($row_match['Chevvai_Dosham']) != 0)
{
	$argTotalCondition .= "  AND ( Chevvai_Dosham = ".$row_match['Chevvai_Dosham']." or Chevvai_Dosham = 3 )";
}

// Checking condition for Match Education
if(trim($row_match['Education']) != "" && trim($row_match['Education']) != 0)
{
	$argTotalCondition .= " AND ( ";
	if(preg_match("/,/",$row_match['Education']))
	{
		$match_MatchEducation_split = explode(",",$row_match['Education']);
		$array_count = count($match_MatchEducation_split);
		for($i=0;$i<$array_count;$i++)
		{
			$query_MatchEducation.= " EducationSelected = ".$match_MatchEducation_split[$i]." or ";
		}
		$argTotalCondition .= substr($query_MatchEducation,0,-4);
	}
	else
	{
		$argTotalCondition .= " EducationSelected = ".$row_match['Education'];
    }
	$argTotalCondition .= " ) ";
}


// Checking condition for EatinghabitsPref	
if(trim($row_match['Eating_Habits']) != ""  && trim($row_match['Eating_Habits']) != 0)
{
	$argTotalCondition .= "  AND ( EatingHabits = ".$row_match['Eating_Habits']." or EatingHabits is null )";
}

// Checking condition for Match Country
if(trim($row_match['Country']) != "" && trim($row_match['Country']) != 0)
{
	$argTotalCondition .= " AND ( ";
	if(preg_match("/,/",$row_match['Country'])){
		$match_MatchCountry_split = explode(",",$row_match['Country']);
		$array_count = count($match_MatchCountry_split);
		for($i=0;$i<$array_count;$i++){
			if($match_MatchCountry_split[$i]>0)
				$query_MatchCountry.= " CountrySelected = ".$match_MatchCountry_split[$i]." or ";
		}
		$argTotalCondition .= substr($query_MatchCountry,0,-4);
	}else{
		$argTotalCondition .= " CountrySelected = ".$row_match['Country'];
    }
	$argTotalCondition .= " ) ";	
	if(strstr($row_match['Country'],"98")!="" && strstr($row_match['Resident_India_State'],'0')==""){	
		$argTotalCondition .= " AND ( ";
		if(preg_match("/,/",$row_match['Resident_India_State'])){
			$match_MatchIndianStates_split = explode(",",$row_match['Resident_India_State']);
			$array_count = count($match_MatchIndianStates_split);
			for($i=0;$i<$array_count;$i++){
				$query_Resident_India_State .= " ResidingState = ".$match_Resident_India_State_split[$i]." or ";
			}
			$argTotalCondition .= substr($query_Resident_India_State,0,-4);
		}else{
			$argTotalCondition .= " ResidingState = ".$row_match['MatchIndianStates'];
		}
		$argTotalCondition .= " ) ";
    }
	if(strstr($row_match['Country'],"222")!="" && strstr($row_match['Resident_USA_State'],'0')==""){
		$argTotalCondition .= " AND ( ";
		if(preg_match("/,/",$row_match['Resident_USA_State'])){
			$match_MatchUSStates_split = explode(",",$row_match['Resident_USA_State']);
			$array_count = count($match_MatchUSStates_split);
			for($i=0;$i<$array_count;$i++){
				$query_MatchUSStates .= " ResidingState = ".$match_MatchUSStates_split[$i]." or ";
			}
			$argTotalCondition .= substr($query_MatchUSStates,0,-4);
		}else{
			$argTotalCondition .= " ResidingState = ".$row_match['Resident_USA_State'];
		}
		$argTotalCondition .= " ) ";
	}
  }
}

$num_selected_rows = $objSlaveMatri -> numOfRecords($varTable['MEMBERINFO'], 'MatriId', $argTotalCondition);
if($num_selected_rows == '' || $num_selected_rows == '0')
	echo '0';
else
	echo $num_selected_rows;
*/

$objSlaveMatri->dbClose();
$objMasterMatri->dbClose();

?>