<?php

#================================================================================================================
   # Author 		: K.Lakshmanan
   # Date			: 08-02-2010
   # Project		: classifiedmailer
#================================================================================================================
   # Description	: Class file for to send the classied mailto user
#================================================================================================================

class Classfiedmail{

   public function __construct($filename='',$table='')
	{
		$this->TableName=$table;
		$this->filename=$filename;
	}


	 function getContents($fileName='') {
            
        if($fileName==''){
			$this->text =trim(file_get_contents($this->filename));
		}
		else{
          $this->text =trim(file_get_contents($fileName));
        }

	}

/* To remove all the Junk,Dulicate and store only Valid mailid**/
    function getValidEmailId() {
		$matches=array();

		if (!empty($this->text)) {

		$pattern = "/([A-Za-z0-9\.\-\_\!\#\$\%\&\'\*\+\/\=\?\^\`\{\|\}]+)\@([A-Za-z0-9.-_]+)(\.[A-Za-z]{2,5})/";
		preg_match_all($pattern,$this->text,$email);
		$validEmail=$this->removeJunkCharachter($email[0]);
		return $validEmail;
		  /*$res = preg_match_all(
			"/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i",
			$this->text,
			$matches);*/
		}
    }

   /******** Remove JUnk CHarachter *********************/
      function removeJunkCharachter($email) {
           $pattern ="/([*!^%&`,#?`|])/";
		   foreach($email as $key=>$value)
			{
			   if (preg_match($pattern, $value)){
				  unset($email[$key]);
			   }
			}
           return array_unique($email);
	  }
   /*******************End**********************/

   /*Populate contents to Newfile*/
	function PopulateEmailIdToFile($contents,$newFileName){
		$ourFileHandle = fopen($newFileName, 'w') or die("can't open file");
		file_put_contents ($newFileName,$contents);
		fclose($ourFileHandle);
	}

     //To create the Name for new file using Extension ex:_old_,_final_
	function CreateNewFileName($extension) {
	   $date= date('d_m_Y');
	   $newExtension=$extension.$date.'.';
	   $newFileName = str_replace(".",$newExtension,$this->filename);
	   return $newFileName;

	}

   //To Dispaly the emailid n lineformat
	function emailInLineFormat($validEmailId) {
		$contents='';
		foreach($validEmailId as $key=>$value) {
		$contents.=$value."\n";
	  }
			return $contents;
	}

  //To create the new Record to store EmailId
	function createRecord($emaiid,$TableName) {

		$date=date('Y-m-d');
		
		$argFields=array('EmailId','Date');
		foreach($emaiid as $key=>$value){
			  $argFieldsValue=array("'".mysql_escape_string($value)."'","'".mysql_escape_string($date)."'");
			  $this->db->insert($TableName,$argFields,$argFieldsValue);
			 
		   }
		  
	}

    //Renaming the file after getting the valid Emailid from the original file
	function renamingFileName() {
		 $newFileName=$this->CreateNewFileName('_old_');
		rename($this->filename,$newFileName);
	}

    function triggerMail($mailsettings,$emailId,$fileName,$replaceText){
		$message = file_get_contents($fileName);
        $message=str_replace("<<EMAILID>>",$emailId,$message);
		$this->smtp=new smtp_class;
		$this->smtp->host_name=$mailsettings['host'];
		$this->smtp->host_port=$mailsettings['port'];
		$this->smtp->localhost=$mailsettings['localhost'];       /* Your computer address */
		$this->smtp->timeout=$mailsettings['timeout'];                  /* Set to the number of seconds wait for a successful connection to the SMTP server */
		$this->smtp->data_timeout=$mailsettings['data_timeout'];             /* Set to the number seconds wait for sending or retrieving data from the SMTP server.*/
		$this->smtp->ssl=0;
        $emailfrom=$mailsettings['emailfrom'];
		$replyto=$mailsettings['replyto'];
        $replyto="info@communitymatrimony.com";
		$templ=$message;
		$priority = 1;
		//$emailsubject = $mailsettings['subject'];
		$emailsubject = 'Exclusive Matrimony Portals For You!';
		$emailId = preg_replace("/\n/", "", $emailId);

		if($this->smtp->SendMessage("noreply@bounces.communitymatrimony.com", array($emailId), array("From: $emailfrom", "Reply-to: $replyto", "Sender: info@communitymatrimony.com", "MIME-Version: 1.0", "Content-type: text/html", "X-Priority: ".$priority, "X-Mailer: PHP mailer", "To: $emailId", "Subject: $emailsubject", "Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")), stripslashes($templ))) {
		}

	 }

   function deleteRecord($classified,$logininfo){
	  $argCondition= " EmailId in (select Email from ".$logininfo .")";
	  $this->db->delete($classified,$argCondition);
   }

   //To Connect the database
	function connectDB($database){
		$this->db=new DB();
		$this->db->dbConnect('M',$database);
		return $this->db->clsErrorCode;

    }
   function connectSlaveDB($database) {
        
		$this->db=new DB();
		$this->db->dbConnect('S',$database);

		return $this->db->clsErrorCode;
   }   

   function closeDB() {
		$this->db-> dbClose();
   }
   //To Select the particular Record
	function selectRecord($tableName,$input) {

		$argFields=array('EmailId','Id');
		$argCondition=' WHERE Unsubscribe=0 ';
		if($input['FROMDATE']!='') {
			 $fromdate=$input['FROMDATE'];
             $argCondition.= " AND date_format(Date,'%Y-%m-%d')>='$fromdate";
	    }
		if($input['TODATE']!='') {
			  $todate=$input['TODATE'];
             $argCondition.= " AND date_format(Date,'%Y-%m-%d')<='$todate'";
	    }
		$argCondition.=' ORDER BY ID ASC ';
		if($input['LIMIT']!='') {
             $argCondition.= " LIMIT $input[LIMIT]";
	    }

		$this->result=$this->db->select($tableName, $argFields, $argCondition, '1');
    }

    //Getting contents from the Table
	function getContentFromDB() {
		$contents='';
		foreach($this->result as $key=>$value) {
              $emaidId= $value['EmailId'];
			  $Id= $value['Id'];
			  $contents.=$Id.','.$emaidId."\n";
		}
		//$contents.="<<<".$this->mailSubject."<<<"."\n";
           return $contents;
	}

   //To get the last Id from the table
	public function getLastIdFromTable($tableName) {
         $argFields=array('Id');
		 $argCondition=' ORDER BY Id DESC LIMIT 1';
		 $this->result=$this->db->select($tableName, $argFields, $argCondition, '1');
		 return $this->result[0]['Id'];

	}

    //Parsing the Email from the file and sent to user
    public function sendEmailToUser($email,$fileName,$appendfile,$templateFile,$replaceText,$mailsettings){

		$this->totalMailSent=0;
        foreach($email as $key=>$value) {
		   if($value!='') {
			   $this->totalMailSent++;
				$contents=$this->totalMailSent.','.$key.','.$value;
				$this->triggerMail($mailsettings,$value,$templateFile,$replaceText);
				$this->PopulateEmailIdToFile($contents,$fileName);
				//$this->AppendEmailIdToFile($contents,$appendfile);
		   }
	   }

    }

   //To append the All EmailId
    public function AppendEmailIdToFile($contents,$fileName){
        $ourFileHandle = fopen($fileName, 'a') or die("can't open file");
		file_put_contents ($fileName,$contents,FILE_APPEND);
		fclose($ourFileHandle);

   }


   //Creating log in table after sent the mail
   public function createLog($table,$mailerType) {
	   $argFields=array('MailerType','Count','SentOn');
	   $argFieldsValue=array("'".$mailerType."'","'".$this->totalMailSent."'",'now()');
       $this->result=$this->db->insert($table,$argFields,$argFieldsValue);

   }

  //To get the Subject from the File
  function getSubjectFromFile() {
       $subject=explode('<<<',$this->text);
       $this->mailSubject=$subject[1];
	   return $this->mailSubject;

  }

  public function updateStatus($emailId,$argTblName) {
	  	$argFields=array('0'=>'Status');
		$argFieldsValue=array('0'=>'1');
	      foreach($emailId as $key=>$value) {
         $argCondition ="  EmailId='".$value."'";
		 $this->result=$this->db->update($argTblName, $argFields, $argFieldsValue, $argCondition);
      }
   }


  public function DBClose()
	{
         $this->db->dbClose();
    }
}

?>