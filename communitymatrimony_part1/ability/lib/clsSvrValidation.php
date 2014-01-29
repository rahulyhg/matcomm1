<?php
#============================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 27 Oct 2009
# End Date		: 
# Project		: Server Side Validation
# Module		: validation Class
#============================================================================================================

class clsSvrValidation
{
	var $error;
	var $errorFlag;
//Function from dhanapal
	//FOR VALIDATION PURPOSE
	function validateInput($argValue, $argPatternType,$errorMessage)
	{
		if($argValue != '' && isset($argValue)){
			switch($argPatternType){
				case 'numeric':   $funRgExpPat = "/^[0-9]+$/"; break;
				case 'joinArray': $funRgExpPat = "/^[0-9\~]+$/"; break;
				case 'alphabet':  $funRgExpPat = "/^[a-z A-Z]+$/"; break;
				case 'alphanumeric':  $funRgExpPat = "/^[a-z A-Z 0-9]+$/"; break;
				case 'date':   $funRgExpPat = "/(0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])[-](19|20)[0-9]{2}/"; break;
				
				case 'float':   $funRgExpPat = "/^[0-9]+[\.]?[0-9]+$/"; break;
				case 'username':  $funRgExpPat = "/^[a-z A-Z][a-z A-Z 0-9 \_]+$/"; break;
				case 'email':   $funRgExpPat = "/^[a-z A-Z 0-9][a-z A-Z 0-9 \_ \. \-]+\@[a-z A-Z 0-9]+\.[a-z A-Z]+[\.]?[a-z A-Z]+$/"; break;
				case 'notzero': $funRgExpPat = "/[^0]/"; break;
			}
				if (is_array($argValue)){
					foreach($argValue as $argSingleValue){
						if($argSingleValue!='' && !preg_match($funRgExpPat , $argSingleValue)){ 
							return $this -> addError($errorMessage);
						}
					}
				}
				else
				{
					if(!preg_match($funRgExpPat , $argValue)){
						return $this -> addError($errorMessage);
					}
				}
		}		
		else {
			return $this -> addError($errorMessage);
		}
	}
//Function from dhanapal
	function IsValue($input,$checkValue,$errorMessage,$samenotsame="same"){
		if($samenotsame == "same"){
			if($input == $checkValue){
				$this -> addError($errorMessage);
			}
		}
		else{
			if($input != $checkValue){
				$this -> addError($errorMessage);
			}
		}
	}
	function IsValidNum($input,$min,$max,$invalidNumMessage){
		if($max == ""){
			if(strlen($input) < $min){
				return $this -> addError($invalidNumMessage);
			}
		}
		else{
			if($min == ""){
				$min = 0;
			}
			if(strlen($input) < $min || strlen($input) > $max){
				return $this -> addError($invalidNumMessage);
			}
		}
	}

	function addError($message){
		$this -> errorFlag = 1;
		//$this -> error .= $message."<br>";
	return $message;
	}
	/*
	function showError(){
		return $this -> error;
	}
	*/
}
?>