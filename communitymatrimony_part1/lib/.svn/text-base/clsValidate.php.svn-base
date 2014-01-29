<?php
#============================================================================================================
# Author 		: M.Baranidharan
# Start Date	: 13 May 2010
# End Date		: 
# Project		: Server Side Validation
# Module		: validation Class
#============================================================================================================

class clsValidate {

  // check for valid email //
  function validateEmail($argValue) {
	global $errors;
    //$emailRgExpPat = "/^[a-z A-Z 0-9][a-z A-Z 0-9 \_ \. \-]+\@[a-z A-Z 0-9]+\.[a-z A-Z]+[\.]?[a-z A-Z]+$/";
	$emailRgExpPat = "/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-z A-Z]{2,4})$/";
	if(!preg_match($emailRgExpPat , $argValue)) {
	   $errors[] = "Enter a valid e-mail address";
	}
  }

  // check for null input //
  function isInputNull($argValue ='',$argField = '') {
	global $errors;
	if(empty($argValue) || !isset($argValue)) {
	   $errors[] = $argField;
	}
  } 
}