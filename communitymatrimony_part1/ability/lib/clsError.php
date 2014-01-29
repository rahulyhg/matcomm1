<?php
#============================================================================================================
# Author 		: M.Baranidharan
# Start Date	: 13 May 2010
# End Date		: 
# Project		: Error Class
# Module		: validation Class
#============================================================================================================

class Error {
  /**
   *
   * Name: constructor
   * Note: constructor
   *
  **/
  public function __construct() {
  } 

  /**
   *
   * Name: showErrors
   * Note: To display errors on page
   *
  **/
  public static function showErrors() {
    global $errors;
    $out = '';
    if(is_array($errors)) {
      $out = '';
      //$out .= '<ul>';
      $cntErrors = count($errors);
      for($i = 0; $i < $cntErrors; $i++) {
        $out .= '<li>'. $errors[$i] .'</li>';
      }
      //$out .= '</ul>';
    }

    echo $out;
    $errors = null;
  }

}
