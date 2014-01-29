<?php
#================================================================================================================
# Author 		: S Anand & S.Rohini
# Start Date	: 2006-06-19
# End Date	: 2006-06-21
# Modified	: 20-Aug-2008
# Project		: MatrimonyProduct
# Module		: Registration - Info
# Modify		: Added Reference related functions
#================================================================================================================
//BASE PATH
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//File Includes
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath.'/conf/emailsconfig.inc');
class Common extends DB
{
	//[Class Public] MEMBER DECLARATION
	public $clsTable				= "memberpartlyinfo";
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
	public $clsOrder				= array('ASC'); 	//asc, desc
	public $clsDisplayTitle			= "yes"; //"yes" or "no"
	public $clsMemberYouContacted	= "MatriId";
	public $clsStart				= 0;
	public $clsLimit				= 10;
	public $clsRowColor				= "no"; 			//"yes" or "no"
	public $clsListTemplate			= ""; 				//to read 'templates/list.tpl' template file
	public $clsViewTemplate			= ""; 				//to read 'templates/view' template file
	//[Class Private] MEMBER DECLARATION
	public $clsNoOfImages			= 3;
	public $clsImageWidth			= 75;
	public $clsImageHeight			= 75;
	public $clsImagePath			= "images";
	public $clsNoPhotoImage			= "nophotofoundimg.gif";
	public $clsPhotoProtectedImage	= "nophotofoundimg.gf";
	public $clsIncludePath			= "includes";
	public $clsAllowNumOfRows		= 1;
	public $clsErrorDisplayMessage	= "";
	public $clsDisplayHeading		= "";
	public $clsCountField			= "";
	public $clsNumOfResults			= "";
	public $clsQueryAppend			= "";
	public $clsAllowedLimit			= "yes";
	public $clsAllowedPrimary		= "yes";
	#------------------------------------------------------------------------------------------------------------
	//ADD NEW
	function addInfo()
	{
		global $mod,$act,$errMessages;
		
		$funQuery 		= "";
		$funDisplay 	= "";
		$funQuery .= "INSERT INTO ".$this->clsTable." SET ";
		for($i=0;$i<count($this->clsFields);$i++)
		{
			if($i<(count($this->clsFields)-1))
			{ $funQuery .= $this->clsFields[$i]." = '".str_replace("'","''",stripslashes($this->clsFieldsValues[$i]))."', "; }//if
			else{ $funQuery .= $this->clsFields[$i]." = '".str_replace("'","''",stripslashes($this->clsFieldsValues[$i]))."' "; }//else
		}//for
		//echo $funQuery;
		mysql_query($funQuery) or die(mysql_error());
		$retDisplay = "yes";
		return $retDisplay;
	}//addInfo

	#------------------------------------------------------------------------------------------------------------
	//ADD NEW
	function addIgnoreInfo()
	{
		global $mod,$act,$errMessages;
		
		$funQuery 		= "";
		$funDisplay 	= "";
		$funQuery .= "INSERT IGNORE INTO ".$this->clsTable." SET ";
		for($i=0;$i<count($this->clsFields);$i++)
		{
			if($i<(count($this->clsFields)-1))
			{ $funQuery .= $this->clsFields[$i]." = '".str_replace("'","''",stripslashes($this->clsFieldsValues[$i]))."', "; }//if
			else{ $funQuery .= $this->clsFields[$i]." = '".str_replace("'","''",stripslashes($this->clsFieldsValues[$i]))."' "; }//else
		}//for
		//echo $funQuery;
		mysql_query($funQuery) or die(mysql_error());
		$retDisplay = "yes";
		return $retDisplay;
	}//addInfo
	#------------------------------------------------------------------------------------------------------------
	//UPDATE VALUES FOR THE SELECTED RECORD
	function updateInfo()
	{
		global $mod,$act,$errMessages;
		
		$funQuery 		= "";
		$funDisplay 	= "";
		
		$funNumOfFields	= count($this->clsFields);
		$funPrimary		= count($this->clsPrimary);
		
		$funQuery .= "UPDATE ".$this->clsTable." SET ";
		for($i=0;$i<count($this->clsFields);$i++)
		{
			if($i<(count($this->clsFields)-1))
			{ $funQuery .= $this->clsFields[$i]." = '".str_replace("'","''",stripslashes($this->clsFieldsValues[$i]))."', "; }//if
			else{ $funQuery .= $this->clsFields[$i]." = '".str_replace("'","''",stripslashes($this->clsFieldsValues[$i]))."' "; }//else

		}//for
		$funQuery 	.= "WHERE ";
		for($i=0;$i<$funPrimary;$i++)
		{
			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' "; }//else
		}//for
		
		//echo $funQuery;
		mysql_query($funQuery) or die(mysql_error());
		
		$retDisplay = "yes";
		
		return $retDisplay;
		
	}//updateInfo
	#------------------------------------------------------------------------------------------------------------
	//DELETE THE SELECTED RECORD
	function deleteInfo()
	{
		global $mod,$act,$errMessages;
		
		$funQuery 		= "";
		$funDisplay 	= "";

		$funPrimary		= count($this->clsPrimary);
		$funQuery.="DELETE FROM ".$this->clsTable." WHERE ";
		for($i=0;$i<$funPrimary;$i++)
		{
			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' "; }//else
		}//for
		mysql_query($funQuery) or die(mysql_error());
		//echo $funQuery;

		$funDisplay = 'yes';
		
		return $funDisplay;		
		
	}//deleteInfo
	#------------------------------------------------------------------------------------------------------------
	//LIST THE SELECTED RECORDS
	function listInfo()
	{
		global $mod,$act,$errMessages;
		
		$funQuery 			= "";
		$funDisplay 		= "";
		$funNumOfFields 	= count($this->clsFields);
		$funFieldsToDisplay = count($this->clsFieldsToDisplay);
		$funNumOfOrderBy	= count($this->clsOrderBy);
		$funPrimary			= count($this->clsPrimary);
		
		$funQuery .= "SELECT ";
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<($funNumOfFields-1)){ $funQuery .= $this->clsFields[$i].", "; }//if
			else{ $funQuery .= $this->clsFields[$i]." "; }//else
		}//for
		
			$funQuery .= "FROM ".$this->clsTable." WHERE ";
		
			for($i=0;$i<$funPrimary;$i++)
			{
				if($i<($funPrimary-1))
				{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' ".$this->clsPrimaryKey[$i]." "; }//if
				else{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' "; }//else
			}//for
			
			if($funNumOfOrderBy > 0)
			{
				$funQuery .= "ORDER BY ";
				for($i=0;$i<$funNumOfOrderBy;$i++)
				{
					if($i<($funNumOfOrderBy-1)){ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i].", "; }//if
					else{ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i]." "; }//else
				}//for
			}//if
			$funQuery .= "LIMIT ".$this->clsStart.",".$this->clsLimit;

		//echo $funQuery;
		$funResultQuery	= mysql_query($funQuery);
		$funNumOfRows	= mysql_num_rows($funResultQuery);
	
		while($row = mysql_fetch_array($funResultQuery))
		{
			for($i=0;$i<$funNumOfRows;$i++)
			{ $funArrResult[$this->clsFields[$i]] = str_replace("''","'",trim($row[$this->clsFields[$i]])); }//for
		}//while
		
		$retDisplay = $funArrResult;
		
		return $retDisplay;
	}//listInfo
	#------------------------------------------------------------------------------------------------------------	
	//DISPLAY DETAILS OF THE SELECTED RECORD
	function viewInfo()
	{
		global $mod,$act,$errMessages;
		
		$funQuery 				= "";
		$funDisplay 			= "";
		
		$funFieldsToDisplay 	= count($this->clsFieldsToDisplay);
		$funNumOfOrderBy		= count($this->clsOrderBy);
		$funPrimary				= count($this->clsPrimary);
		
		$funQuery .= "SELECT ";
		for($i=0;$i<$funFieldsToDisplay;$i++)
		{
			if($i<($funFieldsToDisplay-1)){ $funQuery .= $this->clsFieldsToDisplay[$i].", "; }//if
			else{ $funQuery .= $this->clsFieldsToDisplay[$i]." "; }//else
		}//for
		$funQuery .= "FROM ".$this->clsTable." WHERE ";
		
		
		for($i=0;$i<$funPrimary;$i++)
		{
			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' "; }//else
		}//for
		
		//echo $funQuery;
		$resQuery		= mysql_query($funQuery);
		$funNumOfRows	= mysql_num_rows($resQuery);
		$funProtected	= $this->joinViewInfo();
		
		if($funProtected == 1)
		{
			$funNormalPhoto 	= $this->clsImagePath.'/'.$this->clsPhotoProtectedImage;
			
			$funAddEditLink		= 'add';
			$funAddEditImage	= $this->clsImagePath.'/addphotouploadicon.gif';
			
			$funPhotoStatus	= '&nbsp;';
		}//if
		else
		{
			if($funNumOfRows > 0)
			{
				$row 			= mysql_fetch_object($resQuery);
				
				$funNormalPhoto 	= $this->clsImagePath.'/'.$row->Normal_Photo;
				
				$funAddEditLink		= 'edit';
				$funAddEditImage	= $this->clsImagePath.'/changephotoicon.gif';
				
				$funDeleteLink		= 'delete';
				$funDeleteImage		= $this->clsImagePath.'/deletephotoicon.gif';

				if($row->Photo_Status == 1)
				{
					if($row->Photo_Order != 1)
					{ $funPhotoStatus = '<a href="swap.php?choice='.$row->Photo_Order.'">Make This Main Photo</a>'; }//if
				}//if
				else
				{ $funPhotoStatus = 'Pending Validation'; }//else
			}//if
			else
			{
				$funNormalPhoto 	= $this->clsImagePath.'/'.$this->clsNoPhotoImage;
				
				$funAddEditLink		= 'add';
				$funAddEditImage	= $this->clsImagePath.'/addphotouploadicon.gif';
				
				$funPhotoStatus	= '&nbsp;';
			}//else
		}//else
		
		$retDisplay = array($funNormalPhoto, $funAddEditLink, $funAddEditImage, $funDeleteLink, $funDeleteImage, $funPhotoStatus);
		
		return $retDisplay;
		
	}//viewInfo
	#------------------------------------------------------------------------------------------------------------
	//SELECT VALUES OF THE SELECTED RECORD
	function selectInfo()
	{
		global $mod,$act,$errMessages;
		
		$funQuery 			= "";
		$funDisplay 		= "";
		
		$funNumOfFields 	= count($this->clsFields);
		$funPrimary			= count($this->clsPrimary);
		$funNumOfOrderBy	= count($this->clsOrderBy);
		
		$funQuery .= "SELECT ";
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<($funNumOfFields-1)){ $funQuery .= $this->clsFields[$i].", "; }//if
			else{ $funQuery .= $this->clsFields[$i]." "; }//else
		}//for
		$funQuery .= "FROM ".$this->clsTable." WHERE ";
		
		for($i=0;$i<$funPrimary;$i++)
		{
			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' "; }//else
		}//for
		
		if($funNumOfOrderBy > 0)
		{
			$funQuery .= "ORDER BY ";
			for($i=0;$i<$funNumOfOrderBy;$i++)
			{
				if($i<($funNumOfOrderBy-1)){ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i].", "; }//if
				else{ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i]." "; }//else
			}//for
		}//if
		//$funQuery .= "LIMIT ".$this->clsStart.",".$this->clsLimit;
		
		//echo "<br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		$funNumOfRows	= mysql_num_rows($resQuery);
		
		while($row = mysql_fetch_array($resQuery))
		{
			for($i=0;$i<count($this->clsFields);$i++)
			{ $funArrResult[$this->clsFields[$i]] = str_replace("''","'",trim($row[$this->clsFields[$i]])); }//for
		}//while
		
		$retDisplay = $funArrResult;
		
		return $retDisplay;
		
	}//selectInfo
	#------------------------------------------------------------------------------------------------------------
	//SELECT MULTIPLE VALUES OF THE SELECTED RECORD
	function multiSelectInfo()
	{
		global $mod,$act,$errMessages;
		
		$funQuery 			= "";
		$funDisplay 		= "";

		$funNumOfFields 	= count($this->clsFields);
		$funPrimary			= count($this->clsPrimary);
		$funNumOfOrderBy	= count($this->clsOrderBy);
		
		$funQuery .= "SELECT ";
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<($funNumOfFields-1)){ $funQuery .= $this->clsFields[$i].", "; }//if
			else{ $funQuery .= $this->clsFields[$i]." "; }//else
		}//for
		$funQuery .= "FROM ".$this->clsTable;

		if ($this->clsAllowedPrimary=="yes") {
			$funQuery .= " WHERE ";
		for($i=0;$i<$funPrimary;$i++)
		{
			if ($i==$this->clsPrimaryGroupStart){ $funQuery .= "( "; }//if
			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i]."".$this->clsPrimarySymbol[$i]."'".$this->clsPrimaryValue[$i]."' ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i]."".$this->clsPrimarySymbol[$i]."'".$this->clsPrimaryValue[$i]."' "; }//else
			if ($i==$this->clsPrimaryGroupEnd) $funQuery .= ") ";
		}//for
		}
		if($funNumOfOrderBy > 0)
		{
			$funQuery .= " ORDER BY ";
			for($i=0;$i<$funNumOfOrderBy;$i++)
			{
				if($i<($funNumOfOrderBy-1)){ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i].", "; }//if
				else{ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i]." "; }//else
			}//for
		}//if

		if ($this->clsAllowedLimit=="yes") { $funQuery .= " LIMIT ".$this->clsStart.",".$this->clsLimit; }//if
		
		//echo "<br>".$funQuery;
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
		
	}//selectInfo
	#------------------------------------------------------------------------------------------------------------
	//SELECT MULTIPLE VALUES OF THE SELECTED RECORD
	function multiSelectPhotoInfo($argPrimary='Gender',$argPrimaryValue='2')
	{
		global $mod,$act,$errMessages;
		
		$funQuery 			= "";
		$funDisplay 		= "";
		
		$funQuery .= "SELECT Photo_Id,p.MatriId,Normal_Photo1,Normal_Photo2,Normal_Photo3,Description1,Description2,Description3,Photo_Status1,Photo_Status2,Photo_Status3,Photo_Date_Updated,User_Name,Gender,Thumb_Small_photo1,Thumb_Big_photo1,Thumb_Small_photo2,Thumb_Big_photo2,Thumb_Small_photo3,Thumb_Big_photo3 From memberphotoinfo as p,memberinfo as mbi WHERE mbi.MatriId=p.MatriId AND (((Photo_Status1=0 OR Photo_Status1=2) AND Normal_Photo1<>'') OR ((Photo_Status2=0 OR Photo_Status2=2) AND Normal_Photo2<>'') OR ((Photo_Status3=0 OR Photo_Status3=2) AND Normal_Photo3<>'')) AND ". 'mbi.'.$argPrimary ."='". $argPrimaryValue."'"; //Gender=".$argGender;
		//$funQuery .= "SELECT Photo_Id,p.MatriId,Normal_Photo1,Normal_Photo2,Normal_Photo3,Description1,Description2,Description3,Photo_Status1,Photo_Status2,Photo_Status3,Photo_Date_Updated,User_Name,Gender,Thumb_Small_photo1,Thumb_Big_photo1,Thumb_Small_photo2,Thumb_Big_photo2,Thumb_Small_photo3,Thumb_Big_photo3 From memberphotoinfo as p,memberinfo as mbi WHERE mbi.MatriId=p.MatriId AND (((Photo_Status1=0) AND Normal_Photo1<>'') OR ((Photo_Status2=0) AND Normal_Photo2<>'') OR ((Photo_Status3=0) AND Normal_Photo3<>'')) AND Gender=".$argGender;

		$funQuery .= " ORDER BY Photo_Date_Updated ASC Limit 0,20";
		//echo "<br>".$funQuery;
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
		
	}//multiSelectPhotoInfo
	#------------------------------------------------------------------------------------------------------------
	//COUNT PHOTOS TO BE VALIDATED
	function countSelectPhotoInfo()
	{
		global $mod,$act,$errMessages;
		$funQuery 			= "";
		$funNumOfRows 		= 0;
		for($q=1;$q<=3;$q++) {
		$funQuery = "SELECT MatriId From memberphotoinfo WHERE (Photo_Status".$q."=0 OR Photo_Status".$q."=2) AND   Normal_Photo".$q." !=''";
		$resQuery		= mysql_query($funQuery);
		$funNumOfRow	= mysql_num_rows($resQuery);
		$funNumOfRows = $funNumOfRows + $funNumOfRow;
		}
		$retDisplay = $funNumOfRows;
		return $retDisplay;
	}//countSelectPhotoInfo
	#---------------------------------------------------------------------------------------------------------
	//TO GET NUMBER OF RESULTS
	function numOfResults()
	{
		global $mod,$act,$errMessages;
		
		$funQuery 			= "";
		$funPrimary			= count($this->clsPrimary);
		$this->clsStart =0;
		$funQuery .= "SELECT COUNT(".$this->clsCountField.") AS ".$this->clsCountField." FROM ".$this->clsTable;
		if($this->clsAllowedPrimary=="yes") {
			 $funQuery .= " WHERE ";
		for($i=0;$i<$funPrimary;$i++)
		{
			if ($i==$this->clsPrimaryGroupStart){ $funQuery .= "( "; }//if
			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' "; }//else
			if ($i==$this->clsPrimaryGroupEnd) $funQuery .= ") ";
		}//for
		}
		//$funQuery .= " LIMIT ".$this->clsStart.",".$this->clsLimit;
		//print "<br><br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		$row			= mysql_fetch_array($resQuery);
		$retDisplay	= $row[$this->clsCountField];

		return $retDisplay;
	}//getNumOfResults
	#---------------------------------------------------------------------------------------------------------	
	function numOfResultsM1()
	{
		global $mod,$act,$errMessages;
		
		$funQuery 			= "";
		$funPrimary			= count($this->clsPrimary);
		$funQuery .= "SELECT COUNT(".$this->clsCountField.") AS ".$this->clsCountField." FROM ".$this->clsTable;
		if($this->clsAllowedPrimary=="yes") {
			$funQuery .= " WHERE ";
			for($i=0;$i<$funPrimary;$i++)
			{
				if($i<($funPrimary-1)) { 
					$funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' ".$this->clsPrimaryKey[$i]." "; }//if
				else{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' "; }//else
			}//for
		}

		$funQuery .= " LIMIT ".$this->clsStart.",".$this->clsLimit;
		//print "<br><br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		$row			= mysql_fetch_array($resQuery);
		$retDisplay	= $row[$this->clsCountField];

		return $retDisplay;
	}//getNumOfResults
	#------------------------------------------------------------------------------------------------------------
	//GET CONTENT FROM THE GIVEN FILE
	function getContentFromFile($argFileName)
	{
		
		if(!$funFP = fopen($argFileName, "r"))
		{ echo 'Error: Please check file permission or file name.'; }//if
		
		if(filesize($argFileName) > 0)
		{
			if(!$funFileContent = fread($funFP, filesize($argFileName)))
			{ echo 'Error: Please check file permission or file name.'; }//if
		}
		else
		{ echo "File doesn't contain any text"; }
		
		fclose($funFP);
		$retFileContent = trim($funFileContent);
		
		return $retFileContent;
		
	}//getContentToFile
	#------------------------------------------------------------------------------------------------------------
		//GET HEIGHT FORMAT
	function getHeightUnit($argHeight)
	{
		global $varArrHeightFeetList;
		$retHeightCmsFeet='';
		$funHeightandUnit	= $argHeight;
		$funSplitValue		= explode("~",$funHeightandUnit);
		$funHeight			= $funSplitValue[0];
		$funHeightUnit		= $funSplitValue[1];
		
		if ($funHeightUnit=='cm')
		{
			$funConvertFeetInch	= round(($funHeight/2.54));
			$funConvertFeet		= floor(($funConvertFeetInch /12))."ft";
			$funConvertInchs	= ($funConvertFeetInch %12)."in";
			$retHeightCmsFeet	.= $funConvertFeet." ".$funConvertInchs;

			$funSplitCm			= explode(".",$funHeight);
			$retHeightCmsFeet	.= " / ".$funSplitCm[0]." Cms";

		}//if
		if ($funHeightUnit!='cm')
		{
			if((trim($funHeight)=='167.64') || (trim($funHeight)=='167.74'))
				$retHeightCmsFeet	.= '5ft 6in';
			else
				$retHeightCmsFeet	.= $varArrHeightFeetList[trim($funHeight)];
			$retHeightCmsFeet	.= " / ".floor($funHeight)."Cms";
		}
		return $retHeightCmsFeet;	
	}//getHeightUnit
	#------------------------------------------------------------------------------------------------------------
	//PUT CONTENT TO THE GIVEN FILE
	function putContentToFile($argFileName, $argFileContent, $argAction="")
	{
		
		if(is_writeable($argFileName))
		{
			$funFP = fopen($argFileName, "w");
			$funFileContent = fwrite($funFP, $argFileContent);
			fclose($funFP);
			
			if($argAction == "add"){ $retFileContent = "<br>Sucessfully Added.<br><br>"; }//if
			else{ $retFileContent = "Sucessfully updated."; }//else
		}
		else
		{
			$retFileContent = "Permission Denied. Please change the file permission & update.";
		}
		
		return $retFileContent;
		
	}//getContentToFile
	#------------------------------------------------------------------------------------------------------------
	//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
	function getValuesFromArray($argArrName, $argNullOptionName, $argNullOptionValue, $argSelectedValue)
	{
		$funOptions	="";	
		$funOptions .= '<option value="'.$argNullOptionValue.'">'.$argNullOptionName.'</option>';
		foreach($argArrName as $funIndex => $funValues)
		{
			$funSelectedItem = $argSelectedValue==$funIndex ? "selected" : "";
			$funOptions .= '<option value="'.$funIndex.'" '.$funSelectedItem.'>'.$funValues.'</option>';
		}//for
		
		echo $funOptions;
		
	}//getValuesFromArray
	#------------------------------------------------------------------------------------------------------------
	//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
	function sendEmail($argTo,$argMessage,$argFrom="")
	{
		$funValue		= "";
		$argSubject		= 'Your password on '.$confValues["PRODUCTNAME"]."com";
		$funheaders		= "MIME-Version: 1.0\n";
		$funheaders		.= "Content-type: text/html; charset=iso-8859-1\n";
		$funheaders		.= "From: ".$confValues["PRODUCTNAME"].".Com <".$arrEmailsList["WEMASTERMAIL"].">\n";
		$argheaders		= $funheaders;

		if (mail($argTo, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }

		$retValue = $funValue;

		return $retValue;	
	}
	#------------------------------------------------------------------------------------------------------------
	//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
	function sendNotifyEmail($argTo,$argMessage,$argSubject)
	{
		$funValue		= "";
		$varSubject		= $argSubject;
		$funheaders		= "MIME-Version: 1.0\n";
		$funheaders		.= "Content-type: text/html; charset=iso-8859-1\n";
		$funheaders		.= "From: ".$confValues["PRODUCTNAME"].".Com <".$arrEmailsList["HELPEMAIL"].">\n";
		$argheaders		= $funheaders;
		
		if (mail($argTo, $varSubject, $argMessage, $argheaders))
		{
			$funValue = 'yes';
		}
		//echo $argTo.'<br>'.$varSubject.'<br>'. $argMessage.'<br>'. $argheaders;
		$retValue = $funValue;

		return $retValue;	
	}
	#------------------------------------------------------------------------------------------------------------
	//CALCULATE FROM DOB
	function ageCalculate($argYear, $argMonth, $argDay)
	{
		$varConvertTimeStamp = mktime(0,0,0, $argMonth, $argDay, $argYear);
		$varGetToday = date("U");
		$varSubtract = $varGetToday - $varConvertTimeStamp;
		$varYearsRemainder = $varSubtract%31536000;
		$varRawYears = $varSubtract-$varYearsRemainder;
		$varYears = $varRawYears/31536000;
		$varMonthsRemainder=$varYearsRemainder%2628000;
		$varRawMonths =  $varYearsRemainder-$varMonthsRemainder;
		$varMonths = $varRawMonths/2628000;
		$varDaysRemainder=$varMonthsRemainder%86400;
		$varRawDays =  $varMonthsRemainder-$varDaysRemainder;
		$varDays = $varRawDays/86400;
		$retAge = $varYears;
		return $retAge;
	}//ageCalculate
	#------------------------------------------------------------------------------------------------------------
	//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
	function displaySelectedValuesFromArray($argArrName,$argSelectedValue)
	{
		$funArrSelectedValue = explode("~", $argSelectedValue);
		foreach($argArrName as $funIndex => $funValues)
		{
			if (in_array($funIndex, $funArrSelectedValue))
			{ $funOptions .= $funValues."<br>"; }//if
		}//foreach
		echo $funOptions;
	}//displaySelectedValuesFromArray	
	#------------------------------------------------------------------------------------------------------------
	function getMultipleValuesFromArray($argArrName, $argNullOptionName, $argNullOptionValue, $argSelectedValue, $argUpdate = "")
	{
		$funOptions	= "";		
		if($argUpdate == "update"){ $funArrSelectedValue = explode("~", $argSelectedValue); }//if
		if($funArrSelectedValue == "" || $argSelectedValue == ""){ $funSelect = 'selected'; }else{ $funSelect = ''; }//else
		
		if($argSelectedValue==$argNullOptionValue) { $funSelect = 'selected'; }
			
		$funOptions .= '<option value="'.$argNullOptionValue.'" '.$funSelect.'>'.$argNullOptionName.'</option>';
		
		foreach($argArrName as $funIndex => $funValues)
		{
			if($argUpdate == "update")
			{ $funCheckSelectedValue = in_array($funIndex, $funArrSelectedValue) ? "selected"  : ""; }//if
			else
			{ $funCheckSelectedValue = $argSelectedValue == $funIndex ? "selected" : ""; }//else
			
			$funOptions .= '<option value="'.$funIndex.'" '.$funCheckSelectedValue.'>'.$funValues.'</option>';
			
		}//for
		echo $funOptions;
	}//getValuesFromArray
	#------------------------------------------------------------------------------------------------------------
	//GET ARRAY VALUE FROM FORM
	function getArrayListFromForm($argList)
	{
		$varArrayValue="";
		for ($i=0;$i<count($argList);$i++)
		{
			$varArrayValue.="~".$argList[$i];
		}//for
		$retArrayList=substr($varArrayValue,1);
		return $retArrayList;
	}//getArrayListFromForm
	#------------------------------------------------------------------------------------------------------------
	//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
	function displaySelectedCountryValuesFromArray($argArrName,$argSelectedValue)
	{
		$funArrSelectedValue = explode("~", $argSelectedValue);
		if($argSelectedValue==0)
			$funOptions .= '<option value="0" selected>Any</option>';
		foreach($argArrName as $funIndex => $funValues)
		{
			if (in_array($funIndex, $funArrSelectedValue))
			{ $funOptions .= '<option value="'.$funIndex.'" '.$funCheckSelectedValue.' selected>'.$funValues.'</option>';}
		}//for
		echo $funOptions;

	}//displaySelectedValuesFromArray
	#------------------------------------------------------------------------------------------------------------
	//SELECT DELETED USERNAME
	function getDeleteUsername($argOppositeId)
	{
		$funQuery		= "SELECT User_Name FROM memberdeletedinfo WHERE MatriId='".$argOppositeId."'";
		$funArrQuery	= mysql_query($funQuery);
		$funResult		= mysql_fetch_array($funArrQuery);
		return $funResult["User_Name"];
	}//getDeleteUsername
	#------------------------------------------------------------------------------------------------------------
	//Page Navigation
	function pageNavigation($argNumOfResults, $argCurrentPage, $argNumOfPages)
	{
		#Previous
		if($argCurrentPage > 1)
		{ echo '<a href="javascript:funDoNextAdmin('.($argCurrentPage-1).');" title="Previous"><font color="#5F9EC9">Prev</font></a>&nbsp;'; }
		#Next
		if($argCurrentPage < $argNumOfPages)
		{ echo '<a href="javascript:funDoNextAdmin('.($argCurrentPage+1).');" title="Next"><font color="#5F9EC9">Next</font></a>&nbsp;'; }
		
	}//pageNavigation
	#------------------------------------------------------------------------------------------------------------
	//TO GET EXISTING PHOTO RECORDS FOR SELECTED MATRIID
	function toAddPhoto($argMatriId)
	{
		global $mod,$act,$errMessages;
		$funQuery 			= "";
		$funDisplay 		= array();
		$funNumOfFields 	= count($this->clsFields);
		$funFieldsToDisplay = count($this->clsFieldsToDisplay);
		$funNumOfOrderBy	= count($this->clsOrderBy);
		$funPrimary			= count($this->clsPrimary);
		$varPhototobe		= array($argMatriId.'_Normal_1',$argMatriId.'_Normal_2',$argMatriId.'_Normal_3');

		$funQuery .= "SELECT ";
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<($funNumOfFields-1)){ $funQuery .= $this->clsFields[$i].", "; }//if
			else{ $funQuery .= $this->clsFields[$i]." "; }//else
		}//for
		$funQuery .= "FROM ".$this->clsTable." WHERE ";
		
		
		for($i=0;$i<$funPrimary;$i++)
		{
			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i]."='".$this->clsPrimaryValue[$i]."' "; }//else
		}//for
		
		if($funNumOfOrderBy > 0)
		{
			$funQuery .= "ORDER BY ";
			for($i=0;$i<$funNumOfOrderBy;$i++)
			{
				if($i<($funNumOfOrderBy-1)){ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i].", "; }//if
				else{ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i]." "; }//else
			}//for
		}//if
		$funQuery .= "LIMIT ".$this->clsStart.",".$this->clsLimit;
		//print "<br><br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		$funNumOfRows	= mysql_num_rows($resQuery);
		
		
		if($funNumOfRows > 0)
		{
			$j = 1;
			while($row = mysql_fetch_array($resQuery))
			{
				$varImageName  = explode('.',$row['Normal_Photo']);
				$varImageNames .= $varImageName[0].',';
			}

		}//if

		$varPhotoExists = explode(',',$varImageNames);
		$funDisplay	= array_diff($varPhototobe,$varPhotoExists);

		
		$retDisplay = array_values($funDisplay);
		
		return $retDisplay;
	}//listPhoto
	#------------------------------------------------------------------------------------------------------------	
	//DISPLAY USERNAME
	function getUserId($argOppositeName)
	{
		$funQuery		= "SELECT MatriId FROM memberlogininfo WHERE User_Name='".$argOppositeName."'";
		$funArrQuery	= mysql_query($funQuery);
		$funResult		= mysql_fetch_array($funArrQuery);
		return $funResult["MatriId"];
	}//getUsername
	#------------------------------------------------------------------------------------------------------------	
	//DISPLAY Email
	function getUsername($argMatriId)
	{
		$funQuery		= "SELECT User_Name FROM memberlogininfo WHERE MatriId='".$argMatriId."'";
		//echo '<br>'.$funQuery;
		$funArrQuery	= mysql_query($funQuery);
		$funResult		= mysql_fetch_array($funArrQuery);
		return $funResult["User_Name"];
	}//getUsername
	#------------------------------------------------------------------------------------------------------------	
	//DISPLAY Email
	function getEmail($argMatriId)
	{
		$funQuery		= "SELECT Email FROM memberlogininfo WHERE MatriId='".$argMatriId."'";
		$funArrQuery	= mysql_query($funQuery);
		$funResult		= mysql_fetch_array($funArrQuery);
		return $funResult["Email"];
	}//getUsername
	#------------------------------------------------------------------------------------------------------------
	//TO Check Protected Photo
	function MatchWatchCount($argMatriId)
	{
		global $mod,$act,$errMessages;
		
		$funQuery 			= "";
		$funQuery .= "SELECT COUNT(MatriId) AS MatriIdCnt FROM mailmanagerinfo WHERE MatriId='".$argMatriId."' AND Matchwatch=1";

		//print "<br><br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		$row			= mysql_fetch_array($resQuery);
		$retDisplay	= $row['MatriIdCnt'];
		//echo $retDisplay;
		return $retDisplay;
	}//getNumOfResults
	#------------------------------------------------------------------------------------------------------------
	function getDateMothYear($argFormat,$argDateTime)
	{
		if (trim($argDateTime) !="0000-00-00 00:00:00")
		{ $retDateValue = date($argFormat,strtotime($argDateTime)); }//if
		else $retDateValue="";
		return $retDateValue;
	}//getDateMothYear
	#------------------------------------------------------------------------------------------------------------
	function dateDiff($argDateSeparator, $argCurrentDate, $argPaidDate)
	{
		$VarArrPaidDate		= explode($argDateSeparator, $argPaidDate);
		$VarArrCurrentDate	= explode($argDateSeparator, $argCurrentDate);
		$VarStartDate		= gregoriantojd($VarArrPaidDate[0], $VarArrPaidDate[1], $VarArrPaidDate[2]);
		$VarEndDate			= gregoriantojd($VarArrCurrentDate[0], $VarArrCurrentDate[1], $VarArrCurrentDate[2]);
		return $VarEndDate - $VarStartDate;
	}//dateDiff
	#------------------------------------------------------------------------------------------------------------	
	function emailValidation($argEmail) 
	{
		if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $argEmail)) { return FALSE; }//if
		list($Username, $Domain) = split("@",$argEmail);
		if(getmxrr($Domain, $MXHost)) { return TRUE; }
		else {
				//if(fsockopen($Domain, 25, $errno, $errstr, 30)) { return TRUE; }//else
				//else { return FALSE; }//else
		}//else
	}//emailValidation
	#------------------------------------------------------------------------------------------------------------
	//CHECK PROFILE VALIDATION USERNAME & PASSWORD FROM txt FILE(*ND 20060111)
	function checkProfileValidation($argUsername,$argPassword)
	{
		$funPasswordt="no";
		$funFileName = file('../admin/includes/password.txt'); 
		foreach ($funFileName as $funLineNo => $funValue) 
		{ 
			$funExplode			= explode("\t",$funValue);
			$funFileUsername	= trim($funExplode[0]);
			$funFilePassword	= trim($funExplode[1]);
			if (($funFileUsername==$argUsername) && ($funFilePassword===$argPassword)){$funPasswordt="yes"; break; }//if
		}//foreach
		$retValue	= $funPasswordt;
		return $retValue;

	}//checkProfileValidation
	#------------------------------------------------------------------------------------------------------------
	//SELECT MULTIPLE VALUES OF THE SELECTED RECORD
	function selectPaymentTotal($argStartDate,$argEndDate)
	{
		global $mod,$act,$errMessages;
		
		$funQuery 			= "SELECT Currency,SUM(Amount_Paid) AS Amount_Paid FROM paymenthistoryinfo WHERE date_format(Date_Paid,'%Y-%m-%d') >='".$argStartDate."' AND date_format(Date_Paid,'%Y-%m-%d') <='".$argEndDate."' GROUP BY Currency ORDER BY Currency";
		//echo "<br>".$funQuery;
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
	#----------------------------------------------------------------------------------------------------------
	function selectLastPaymentInfo($argPrimary,$argPrimaryValue)
	{
		global $mod,$act,$errMessages;
		$this->clsFields	= array('LstPaymentDate','Date_Paid');
		
		$funQuery 		= "SELECT (TO_DAYS(NOW()) - TO_DAYS(Date_Paid)) AS LstPaymentDate, Date_Paid FROM memberlogininfo WHERE ".$argPrimary."='".$argPrimaryValue."'";
		//echo "<br>".$funQuery;
		$resQuery	= mysql_query($funQuery);
		while($row = mysql_fetch_array($resQuery))
		{
			for($i=0;$i<count($this->clsFields);$i++)
			{ $funArrResult[$this->clsFields[$i]] = str_replace("''","'",trim($row[$this->clsFields[$i]])); }//for
		}//while
		
		$retDisplay = $funArrResult;
		
		return $retDisplay;

	}//selectLastPaymentInfo
	#----------------------------------------------------------------------------------------------------------
	function multiSelectSwapInfo($argSwapIds)
	{	
		global $mod,$act;
		$funQuery 		= '';
		$funDisplay 	= '';
		$funSwapIdsList = '';
		$funSwapValues	= array();

		foreach($argSwapIds as $funSingleSwapIds)
		{
			$funSwapIdsList .= "'".$funSingleSwapIds."', ";
		}
		
		$funSwapIdsList = chop($funSwapIdsList,", ");


		$funQuery		= 'SELECT MatriId,Normal_Photo1,Photo_Status1,Normal_Photo2,Description2, Photo_Status2,Normal_Photo3,Description3,Photo_Status3,Thumb_Small_photo1,Thumb_Big_photo1,Thumb_Small_photo2,Thumb_Big_photo2,Thumb_Small_photo3, Thumb_Big_photo3 FROM memberphotoinfo WHERE MatriId IN('.$funSwapIdsList.')';
		//print $funQuery;
		$funSwapPhotosInfo = mysql_query($funQuery);
		
		$i	= 0;
		while($row = mysql_fetch_object($funSwapPhotosInfo))
		{
			//FOR SWAP USES
			$funSwapValues[$i]['MatriId']		= $row->MatriId;
			$funSwapValues[$i]['Normal_Photo1']	= $row->Normal_Photo1;
			$funSwapValues[$i]['Photo_Status1']	= $row->Photo_Status1;
			$funSwapValues[$i]['Normal_Photo2']	= $row->Normal_Photo2;
			$funSwapValues[$i]['Photo_Status2']	= $row->Photo_Status2;
			$funSwapValues[$i]['Normal_Photo3']	= $row->Normal_Photo3;
			$funSwapValues[$i]['Photo_Status3']	= $row->Photo_Status3;
			$funSwapValues[$i]['Description2']	= $row->Description2;
			$funSwapValues[$i]['Description3']	= $row->Description3;
			$funSwapValues[$i]['Thumb_Small_photo2']= $row->Thumb_Small_photo2;
			$funSwapValues[$i]['Thumb_Small_photo3']= $row->Thumb_Small_photo3;
			$funSwapValues[$i]['Thumb_Big_photo2']	= $row->Thumb_Big_photo2;
			$funSwapValues[$i]['Thumb_Big_photo3']	= $row->Thumb_Big_photo3;
			$i++;
		}
		return $funSwapValues;		
	}//multiSelectSwapInfo
#-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
/* Reference Telated Functions */
	function getApprovalwaitingCount()
	{
		global $mod,$act,$errMessages;
		$funQuery 			= "";
		$funPrimary			= count($this->clsPrimary);
		$funQuery 			= "select Count(a.MatriId) as RefId from  addreference a,refereedetails b where a.RefId=b.RefId and Validate_Status=0;";
		$resQuery				= mysql_query($funQuery);
		$row						= mysql_fetch_array($resQuery);
		$retDisplay			= $row['RefId'];
		return $retDisplay;
	}//getApprovalwaitingCount
	#------------------------------------------------------------------------------------------------------------
	//SELECT MULTIPLE VALUES OF THE SELECTED RECORD
	function multiSelectReferencesInfo($StartLimit=0,$EndLimit=20,$argPurpose,$argStatus,$argMatriId='')
	{
		global $mod,$act,$errMessages;
		
		$funQuery 			= "";
		$funDisplay 		= "";

		if($argPurpose==1) {
			$funQuery .= "SELECT adr.RefId,adr.MatriId,rd.Referee_Name,rd.Familarity_Duration,rd.Referee_Email,rd.Referee_Phone,rd.Referee_Comments,rd.Referee_Date_Requested,adr.Member_Comments,adr.Reference_Type From addreference as adr,refereedetails as rd WHERE adr.RefId=rd.RefId AND Validate_Status=".($argStatus==0?0:3)." ORDER BY Referee_Date_Requested ASC Limit ".$StartLimit.",".$EndLimit;
		} else {
			$funQuery .= "SELECT adr.RefId,adr.MatriId,rd.Referee_Name,rd.Familarity_Duration,rd.Referee_Email,rd.Referee_Phone,rd.Referee_Comments,rd.Referee_Date_Requested,adr.Member_Comments,adr.Reference_Type From addreference as adr,refereedetails as rd WHERE adr.RefId=rd.RefId AND Validate_Status=".($argStatus==0?0:3)." AND adr.MatriId='".$argMatriId."'";		
		}
		//echo "<br>".$funQuery;
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
		
	}//multiSelectReferencesInfo
	#------------------------------------------------------------------------------------------------------------
}//Common
#================================================================================================================
?>