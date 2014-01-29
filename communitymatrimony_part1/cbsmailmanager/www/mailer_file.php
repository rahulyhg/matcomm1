<?php

include "config/config.php";
include_once $MAILMANAGER_ROOTPATH."prcase/prcase.inc";

if($argv[1] != '') {
	$prcase = $argv[1];
}

if($prcase == 1) {
	$SelQry = "select Name,MatriId,Gender,Email,Password,Caste from ".$DBNAME['MAILSYSTEM'].'.'.$tbl['prcase1']." order by Id desc limit 10" ;
	$dblink->select($SelQry );
	$fullrs1 = $dblink->resource; 	
	$file = fopen($BasePath."prcase$prcase".'-'.date('dMy').".txt","w+");   
	while($row = $dblink->fetchArray('MYSQL_BOTH',$fullrs1)){		
		 if($row['Gender'] =='M')
			 $Gender='F';
		 else
			 $Gender='M';
		 $SelQry2 = "select CasteCount,Gender from ".$DBNAME['MAILSYSTEM'].'.'.$tbl['castecount']." where Caste=".$row['Caste']." and Gender='".$Gender."'";
		 $dblink->select($SelQry2);
		 $fullrs2 = $dblink->resource; 
		 while($row2 = $dblink->fetchArray('MYSQL_BOTH',$fullrs2) ){			
			$record = $row['Name'].'~'.$row['MatriId'].'~'.$row['Email'].'~'.$row['Password'].'~'.$row2['Gender'].'~'.$row['Caste'].'~'.$row2['CasteCount'];
			fwrite($file,$record."\r\n");
		 }
	}
	fclose($file);
} else if ($prcase == 2) {
	$SelQry = "select Name,MatriId,Gender,Email,Password,Caste from ".$DBNAME['MAILSYSTEM'].'.'.$tbl['prcase2']." order by Id desc limit 10" ;
	$dblink->select($SelQry );
	$fullrs1 = $dblink->resource; 	
	$file = fopen($BasePath."prcase$prcase".'-'.date('dMy').".txt","w+");   
	while($row = $dblink->fetchArray('MYSQL_BOTH',$fullrs1)){
		 if($row['Gender'] =='M')
			 $Gender='F';
		 else
			 $Gender='M';
		 $SelQry2 = "select CasteCount,Gender from ".$DBNAME['MAILSYSTEM'].'.'.$tbl['castecount']." where Caste=".$row['Caste']." and Gender='".$Gender."'";
		 $dblink->select($SelQry2);
		 $fullrs2 = $dblink->resource; 
		 while($row2 = $dblink->fetchArray('MYSQL_BOTH',$fullrs2) ){			
			$record = $row['Name'].'~'.$row['MatriId'].'~'.$row['Email'].'~'.$row['Password'].'~'.$row2['Gender'].'~'.$row['Caste'].'~'.$row2['CasteCount'];
			fwrite($file,$record."\r\n");			
		 }
	}
	fclose($file);
}
?>