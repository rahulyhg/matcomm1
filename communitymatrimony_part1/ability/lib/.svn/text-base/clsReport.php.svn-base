<?php
#================================================================================================================
# Author 		: N Dhanapal
# Start Date	: 2007-01-29
# End Date		: 2007-01-29
# Project		: MatrimonialProduct
# Module		: Registration - Info
#================================================================================================================

class Report
{

	//[Class Public] MEMBER DECLARATION
	public $clsTable				= "memberlogininfo";
	public $clsSelectedField		= "MatriId";
	public $clsPrimary				= array('MatriId');
	public $clsPrimaryValue			= array();
	public $clsPrimaryKey			= array(); 	//add, or
	public $clsPrimaryGroupStart	= 0.1;
	public $clsPrimaryGroupEnd		= 0.1;
	public $clsPrimarySymbol		= array("=");
	public $clsFields				= array('*');
	public $clsFieldsToDisplay		= array();
	public $clsFieldsValues			= array();
	public $clsOrderBy				= array();
	public $clsOrder				= array('DESC'); 	//asc, desc
	public $clsDisplayTitle			= "yes"; //"yes" or "no"
	public $clsMemberYouContacted	= "MatriId";
	public $clsStart				= 0;
	public $clsLimit				= 10;
	public $clsCountField			= "";



	function getCountryListInfo($argStartDate,$argEndDate,$arrCountryList)
	{
		global $mod,$act,$errMessages,$arrCountryList;
		$funQuery 			= "";
		$funDisplay 		= "";
		$funArrResult		= "";

		$funNumOfFields 	= count($this->clsFields);
		$funPrimary			= count($this->clsPrimary);


		$funQuery .= "SELECT B.Country,COUNT(B.Country) AS COUNT FROM memberlogininfo A, memberinfo B WHERE A.MatriId=B.MatriId AND Date_Created >='".$argStartDate."' AND Date_Created <='".$argEndDate."' GROUP BY B.Country";

		//echo "<br><br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		$j=0;
		while($row = mysql_fetch_array($resQuery))
		{
			//echo '<tr><td class="smalltxt">'.$varArrCountryList[$row["Country"]].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - '.$row["COUNT"].'</td></tr>';


			//$funArrResult .= '<tr><td class="smalltxt">'.$varArrCountryList[$row["Country"]].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - '.$row["COUNT"].'</td></tr>';

			if ($row["COUNT"] > 0){
			$funArrResult .= '<tr style="font-family:Verdana,MS Sans serif,Arial,Helvetica,sans-serif;font-size:11px"><td >'.$arrCountryList[$row["Country"]].'</td><td>'.$row["COUNT"].'</td></tr>';
			}

			$j++;
		}//while
		//print "<br>".$funArrResult;
		$retDisplay = $funArrResult;

		return $retDisplay;

	}//getCountryListInfo
	#------------------------------------------------------------------------------------------------------------

	function getSubDomainCount($argStartDate,$argEndDate,$argSubDomainId)
	{
		global $mod,$act,$errMessages;

		$funQuery 			= "";
		$funDisplay 		= "";

		$funNumOfFields 	= count($this->clsFields);
		$funPrimary			= count($this->clsPrimary);


		$funQuery .= "SELECT COUNT(A.MatriId) AS COUNT FROM memberlogininfo A, memberinfo B WHERE A.MatriId=B.MatriId AND  Date_Created >='".$argStartDate."' AND Date_Created <='".$argEndDate."' AND Profile_Referred_By=".$argSubDomainId;

		//echo "<br><br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		while($row = mysql_fetch_array($resQuery)) { echo $row["COUNT"];}//while

		$retDisplay = $funArrResult;

		return $retDisplay;

	}//getCountryListInfo

	function getMessageSentCount($argStartDate,$argEndDate,$argPaidStatus)
	{
		global $mod,$act,$errMessages;

		$funQuery 			= "";
		$funDisplay 		= "";

		$funQuery .= "SELECT COUNT(A.Mail_Id) AS COUNT FROM mailsentinfo A, memberlogininfo B WHERE A.MatriId=B.MatriId AND B.Paid_Status=".$argPaidStatus." AND Date_Sent >='".$argStartDate."' AND Date_Sent <='".$argEndDate."'";

		//echo "<br><br>".$funQuery.'<br>';
		$resQuery		= mysql_query($funQuery);
		while($row = mysql_fetch_array($resQuery)) { $funTotalCount = $row["COUNT"];}//while

		$retDisplay = $funTotalCount;

		return $retDisplay;
	}//getMessageSentCount

	function offerContactedCount()
	{
		global $mod,$act,$errMessages;

		$funQuery 			= "";
		$funDisplay 		= "";

		$funQuery .= "SELECT Contact_Count AS 'FreeMemberContactedCount',Count(MatriId) AS 'TotalMembersContacted' FROM memberofferinfo WHERE Contact_Count >0 GROUP BY Contact_Count ORDER BY Contact_Count DESC";
		//echo "<br><br>".$funQuery.'<br>';

		$resQuery	= mysql_query($funQuery);
		while($row	= mysql_fetch_array($resQuery))
		{
			echo '<tr>';
			echo '<td class="smalltxt">'.$row["FreeMemberContactedCount"].'</td>';
			echo '<td class="smalltxt">'.$row["TotalMembersContacted"].'</td>';
			echo '</tr>';
		}//while

		$retDisplay = $funTotalCount;

		return $retDisplay;
	}

	//SELECT MULTIPLE VALUES OF THE SELECTED RECORD
	function selectPaymentTotal($argStartDate,$argEndDate)
	{
		global $mod,$act,$errMessages;

		$funQuery 			= "SELECT Currency,SUM(Amount_Paid) AS Amount_Paid FROM paymenthistoryinfo WHERE Date_Paid >='".$argStartDate."' AND Date_Paid <='".$argEndDate."' GROUP BY Currency ORDER BY Currency";
		$resQuery		= mysql_query($funQuery);
		$funNumOfRows	= mysql_num_rows($resQuery);
		$j=0;
		while($row = mysql_fetch_array($resQuery))
		{
			for($i=0;$i<count($this->clsFields);$i++)
			{ $funArrResult[$j][$this->clsFields[$i]] = str_replace("''","'",trim($row[$this->clsFields[$i]])); }//for
			$j++;
		}//while

		$retDisplay = $funArrResult;

		return $retDisplay;

	}//selectPaymentTotal

	function getDateMothYear($argFormat,$argDateTime)
	{
		if (trim($argDateTime) !="0000-00-00 00:00:00")
		{ $retDateValue = date($argFormat,strtotime($argDateTime)); }//if
		else $retDateValue="";
		return $retDateValue;
	}//getDateMothYear

	function urduProfileCopied($argStartDate,$argEndDate)
	{
		$funQuery 			= "SELECT COUNT(MatriId) AS COUNT FROM memberinfo WHERE User_Name like'MU-U%' AND Date_Created >='".$argStartDate."' AND Date_Created <='".$argEndDate."'";
		//print "<br>".$funQuery;
		$resQuery	= mysql_query($funQuery);
		$row		= mysql_fetch_array($resQuery);
		$retDisplay	= $row['COUNT'];

		return $retDisplay;
	}//urduProfileCopied
	#------------------------------------------------------------------------------------------------------------
	function getPaymentCountryListInfo($argStartDate,$argEndDate,$varArrCountryList)
	{
		global $mod,$act,$errMessages,$varArrCountryList;

		$funQuery 			= "";
		$funDisplay 		= "";

		$funNumOfFields 	= count($this->clsFields);
		$funPrimary			= count($this->clsPrimary);

		$funQuery .= "SELECT Country,Count(Paid_Status) as Paidmem from memberinfo A,memberlogininfo B where A.MatriId=B.MatriId AND Publish IN (1,2) AND A.User_Name NOT LIKE 'JN-%' AND Date_Created >='".$argStartDate."' AND Date_Created <='".$argEndDate."' GROUP BY Country,Paid_Status";

		//echo "<br><br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		$j=0;
		while($row = mysql_fetch_array($resQuery))
		{
			for($i=0;$i<count($this->clsFields);$i++)
			{ $funArrResult[$j][$this->clsFields[$i]] = str_replace("''","'",trim($row[$this->clsFields[$i]])); }//for
			$j++;
		}//while

		$retDisplay = $funArrResult;

		return $retDisplay;

	}//getCountryListInfo
	#------------------------------------------------------------------------------------------------------------
	function getProfileStat($varArrCountryList)
	{
		global $mod,$act,$errMessages,$varArrCountryList;

		$funQuery 			= "";
		$funDisplay 		= "";

		$funNumOfFields 	= count($this->clsFields);
		$funPrimary			= count($this->clsPrimary);

		$funQuery .= "SELECT Country,Count(Paid_Status) as Paidmem from memberinfo A,memberlogininfo B where A.MatriId=B.MatriId AND Publish IN (1,2) GROUP BY Country,Paid_Status";
		//echo "<br><br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		$j=0;
		while($row = mysql_fetch_array($resQuery)) 	{
			for($i=0;$i<count($this->clsFields);$i++)
			{ $funArrResult[$j][$this->clsFields[$i]] = str_replace("''","'",trim($row[$this->clsFields[$i]])); }//for
			$j++;
		}//while

		$retDisplay = $funArrResult;

		return $retDisplay;

	}//getCountryListInfo
	#------------------------------------------------------------------------------------------------------------
	function getProfileCreateStat($varArrCountryList)
	{
		global $mod,$act,$errMessages,$varArrCountryList;

		$funQuery 			= "";
		$funDisplay 		= "";

		$funNumOfFields 	= count($this->clsFields);
		$funPrimary			= count($this->clsPrimary);

		$funQuery .= "SELECT Country,Count(Profile_Created_By) as Created,Profile_Created_By from memberinfo A,memberlogininfo B where A.MatriId=B.MatriId AND Publish IN (1,2) GROUP BY Country,Profile_Created_By;";

		//echo "<br><br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		$j=0;
		while($row = mysql_fetch_array($resQuery))
		{
			 $funArrResult[$row['Country']][$row['Profile_Created_By']] = $row['Created'];
			$j++;
		}//while

		$retDisplay = $funArrResult;

		return $retDisplay;

	}//getCountryListInfo
	#------------------------------------------------------------------------------------------------------------
	function sendEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress)
	{
		$funValue				= "";
		$funheaders				= "";
		$argFrom				= preg_replace("/\n/", "", $argFrom);
		$argFromEmailAddress	= preg_replace("/\n/", "", $argFromEmailAddress);
		$argReplyToEmailAddress	= preg_replace("/\n/", "", $argReplyToEmailAddress);
		$funheaders				.= "MIME-Version: 1.0\n";
		$funheaders				.= "Content-type: text/html; charset=iso-8859-1\n";
		$funheaders				.= "From:".$argFrom."<".$argFromEmailAddress.">\n";
		$funheaders				.= "Reply-To: ".$argFrom."<".$argReplyToEmailAddress.">\n";
		$funheaders				.= "Return-Path:".$argFrom."<".$argReplyToEmailAddress.">\n";
		$argheaders				= $funheaders;
		$argToEmailAddress		= preg_replace("/\n/", "", $argToEmailAddress);
		//echo '<br>'.$argToEmailAddress;
		if ($_REQUEST['manual']!='yes') {
			if (mail($argToEmailAddress, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if
		}
		//echo $argSubject.'<br>'.$argMessage;
		$retValue = $funValue;

		return $retValue;
	}//sendEmail
	#------------------------------------------------------------------------------------------------------------
	function numOfPaidProfiles($argDate,$varBMMatriId='')	{
		global $mod,$act,$errMessages;
		$funQuery 			= "";
		$varList			= '';
		if ($varBMMatriId!='' && $varBMMatriId=='Y') {
			$whereBMMatriId = " AND BM_MatriId!='' ";
		} else if ($varBMMatriId!='' && $varBMMatriId=='N') {
			$whereBMMatriId = " AND BM_MatriId='' ";
		} else {
			$whereBMMatriId = "";
		}
		$funQuery  = "SELECT MatriId FROM memberinfo WHERE Publish != 3  AND Paid_Status = 1 AND Last_Payment >= '".$argDate." 00:00:00' AND Last_Payment <= '".$argDate." 23:59:59' $whereBMMatriId";
		//print "<br><br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		$j=0;
		while($row = mysql_fetch_array($resQuery))
		{
			 if ($j == 0)
				 $varList = " '".$row['MatriId']."' ";
			 else
				 $varList .= ", '".$row['MatriId']."' ";
			$j++;
		}//while
		$funQuery = "SELECT COUNT(MatriId) AS COUNT FROM  paymenthistoryinfo WHERE ";
		if ($j > 0)
			$funQuery .= " MatriId IN (".$varList .") AND ";
		$funQuery .= " Date_Paid >= '".$argDate." 00:00:00'  AND Date_Paid <= '".$argDate." 23:59:59' AND Amount_Paid > 0";
		//print "<br><br>".$funQuery;
		//print "<br><br>";
		$resQuery		= mysql_query($funQuery);
		$row			= mysql_fetch_array($resQuery);
		$retDisplay		= $row['COUNT'];
		return $retDisplay;
	}//numOfResults

	#------------------------------------------------------------------------------------------------------------
	function getPaidProfileDetails($argDate) {
		global $mod,$act,$errMessages;
		$funQuery 			= "";
		$varList			= '';
		$funQuery  = "SELECT A.MatriId AS MatriId FROM memberinfo A, memberlogininfo B WHERE A.MatriId=B.MatriId  AND A.Publish = 3  AND Paid_Status = 1 AND A.Last_Payment >= '".$argDate." 00:00:00' AND A.Last_Payment <= '".$argDate." 23:59:59'";

		//print "<br><br><b>".$funQuery."</b>";
		$resQuery		= mysql_query($funQuery);
		$j=0;
		while($row = mysql_fetch_array($resQuery))
		{
			 if ($j == 0)
				 $varList = " '".$row['MatriId']."' ";
			 else
				 $varList .= ", '".$row['MatriId']."' ";
			$j++;
		}//while
		$funQuery = "SELECT MatriId, Currency, Amount_Paid FROM  paymenthistoryinfo WHERE ";
		if ($j > 0)
			$funQuery .= " MatriId NOT IN (".$varList .") AND ";
		$funQuery .= " Date_Paid >= '".$argDate." 00:00:00'  AND Date_Paid <= '".$argDate." 23:59:59'  AND Amount_Paid > 0";
		//print "<br><br>".$funQuery;
		//print "<br><br>";
		$resQuery		= mysql_query($funQuery);
		$retDisplay		= $resQuery;
		return $retDisplay;
	}

	function getPaidTotalSum($argDate) {
		global $mod,$act,$errMessages;
		$funQuery 			= "";
		$varList			= '';
		$funQuery  = "SELECT A.MatriId AS MatriId FROM memberinfo A, memberlogininfo B WHERE A.MatriId=B.MatriId  AND A.Publish = 3  AND Paid_Status = 1 AND A.Last_Payment >= '".$argDate." 00:00:00' AND A.Last_Payment <= '".$argDate." 23:59:59'";

		$resQuery		= mysql_query($funQuery);
		$j=0;
		//print "<br>".$funQuery;
		while($row = mysql_fetch_array($resQuery))
		{
			 print_r($row);
			 if ($j == 0)
				 $varList = " '".$row['MatriId']."' ";
			 else
				 $varList .= ", '".$row['MatriId']."' ";
			$j++;
		}//while
		$funQuery = "SELECT Currency, SUM(Amount_Paid) as Amount_Paid FROM  paymenthistoryinfo WHERE ";
		if ($j > 0)
			$funQuery .= " MatriId NOT IN (".$varList .") AND ";
		$funQuery .= " Date_Paid >= '".$argDate." 00:00:00'  AND Date_Paid <= '".$argDate." 23:59:59'  AND Amount_Paid > 0 group by Currency Order by Currency";
		//print "<br><br><b>".$funQuery."</b>";
		$resQuery		= mysql_query($funQuery);
		$retDisplay		= $resQuery;
		return $retDisplay;
	}

}//Report



#================================================================================================================
?>