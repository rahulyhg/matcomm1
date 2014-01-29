<?php

/**
 * @file
 * File: clsExceptions.php
 * Version: 1.0
 *
 *  Creator: Ilayaraja M
 *  Created On: Oct 29, 2009
 *  Updated On: 
 *
 *  Purpose : To declare user defined Exceptions
 *
 *  Defined Exceptions
 *  DBException
 *  NoTwitterAccountException
 *  QueryException
 *  ArgumentException
 *  UserAccountException
 *
 *
**/


/// To handle DB connection or query errors
class DBException extends Exception {

	public function __tostring() {
		return "DBException";
	}

	public function errorMessage() {
		$errorMessage = 'Error on line '. $this->getLine() .' in '. $this->getFile() .': <b>'. $this->getMessage() .'</b>';
		return $errorMessage;
	}
}

/// To handle empty twiter account related errors
class NoTwitterAccountException extends Exception {
	public function __tostring() {
		return "NoTwitterAccountException";
	}

	public function errorMessage() {
		$errorMessage = 'Error on line '. $this->getLine() .' in '. $this->getFile() .': <b>'. $this->getMessage() .'</b>';
		return $errorMessage;
	}
}

/// To handle wrong query related errors
class QueryException extends Exception {
	public function __tostring() {
		return "QueryException";
	}

	public function errorMessage() {
		$errorMessage = 'Error on line '. $this->getLine() .' in '. $this->getFile() .': <b>'. $this->getMessage() .'</b>';
		return $errorMessage;
	}
}

/// To handle empty or null arguments of methods
class ArgumentException extends Exception {
	 public function __tostring() {
		return "ArgumentException";
	}

	public function errorMessage() {
		$errorMessage = 'Error on line '. $this->getLine() .' in '. $this->getFile() .': <b>'. $this->getMessage() .'</b>';
		return $errorMessage;
	}
}

/// To handle Twitter user account exceptions eg: User not found or Protected
class UserAccountException extends Exception {
	 public function __tostring() {
		return "UserAccountException";
	}

	public function errorMessage() {
		$errorMessage = 'Error on line '. $this->getLine() .' in '. $this->getFile() .': <b>'. $this->getMessage() .'</b>';
		return $errorMessage;
	}
}
