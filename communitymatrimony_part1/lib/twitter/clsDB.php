<?php

/**
 * @file
 * File: csDB.php
 * Version: 2.0
 *
 *  Creator: Ilayaraja M
 *  Created On: Oct 23, 2009
 *  Updated On: Oct 29, 2009
 *
 *  Purpose : To talk with Twitter API for various requests
 *
 *  Object functions
 *  connectDB()
 *  select()
 *  insert()
 *  update()
 *  delete()
 *  logError()
 *
 *  Notes:
 *  Edit the required constant variables to set the configuration.
 *
 *
**/

// Library includes
$docRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$docRoot = ($docRoot == "")?"/home/product/community":$docRoot;

include_once $docRoot ."/conf/twitter/conf.php";
include_once $docRoot ."/lib/twitter/clsExceptions.php";

class DB {
	private static $linkDB;
	private $query;

	/// Class constructor.
    /**
     * Purpose: Class constructor
     *
     * Input Params: none
     * Output Params: none
     * Return Value:  none
	 *
	 * Note: To inilitize the DB Connection
     *
     */
	private function __construct() {
		$conDB = mysql_connect(_ID_DB_HOST, _ID_DB_USERNAME, _ID_DB_PASSWORD);

		if(!is_resource($conDB)) {
			$this->logError(mysql_error());
		}
		else {
			self::$linkDB = $conDB;
			$rsDBSelect = mysql_select_db(_ID_DB_DATABASE, self::$linkDB);

			if(!$rsDBSelect) {
				$this->logError(mysql_error());
			}
		}
	}

	private function __clone() {
	}

	public function __tostring() {
		return "DB Version 2.0";
	}

	/// To set the DB connection
    /**
     * Purpose: To set the DB connection
     *
     * Input Params: none
     * Output Params: none
     * Return Value: none
     *
     */
	public static function connectDB() {
		if(!self::$linkDB) {
			new DB;
		}
	}

	/// To execute the select query
    /**
     * Purpose: To execute the select query
     *
     * Input Params:
     *   1. $argTblName - str - table name
     *   2. $argFields - str - fields list
	 *   3. $argCondition -  str - where condition
	 *   4. $argResultType - int - return result type
     *
     * Output Params: none
     * Return Value: Data set / Result set
     *
     */
	public function select($argTblName, $argFields, $argCondition, $argResultType = _ID_RETURN_DATASET) {
			$funArrResults = array();

			$query  = "SELECT ". join(',', $argFields) ." FROM ". $argTblName .' '. $argCondition;
			$this->query = " [Query: ". $query . "]";

			if (!$funExecute = mysql_query($query, self::$linkDB)) {
				$this->logError(mysql_error());
				throw new DBException(mysql_error() . $this->query);
				//return false;
			}
			else {
				if($argResultType == _ID_RETURN_DATASET) {
					$j = 0;
					$funFieldsCnt = count($argFields);

					while($funResults = mysql_fetch_assoc($funExecute)) {
						for($i=0; $i<$funFieldsCnt; $i++) {
							$funArrResults[$j][$argFields[$i]] = $funResults[$argFields[$i]];
						}
						$j++;
					}
					return $funArrResults;
					}
					else {
						return $funExecute;
					}
			}
	}

	public function selectWithCounter($argTblName, $argFields, $argCondition, $argResultType = _ID_RETURN_DATASET) {
			$funArrResults = array();
			$cntrMsgs = 0;

			$query  = "SELECT SQL_CALC_FOUND_ROWS ". join(',', $argFields) ." FROM ". $argTblName .' '. $argCondition;
			$this->query = " [Query: ". $query . "]";

			if (!$funExecute = mysql_query($query, self::$linkDB)) {
				$this->logError(mysql_error());
				throw new DBException(mysql_error() . $this->query);
				//return false;
			}
			else {
				$qryCounter = "SELECT FOUND_ROWS() AS totalmessages";
				if (!$rsCntMsgs = mysql_query($qryCounter, self::$linkDB)) {
					$this->logError(mysql_error());
					throw new DBException(mysql_error() . $this->query);
					//return false;
				}
				else {
					$dataCntMsgs = mysql_fetch_object($rsCntMsgs);
					$cntrMsgs = $dataCntMsgs->totalmessages;
				}
				if($argResultType == _ID_RETURN_DATASET) {
					$j = 0;
					$funFieldsCnt = count($argFields);

					while($funResults = mysql_fetch_assoc($funExecute)) {
						for($i=0; $i<$funFieldsCnt; $i++) {
							$funArrResults[$j][$argFields[$i]] = $funResults[$argFields[$i]];
						}
						$j++;
					}
					$funArrResults['totalMessages'] = $cntrMsgs;
					return $funArrResults;
					}
					else {
						return $funExecute;
					}
			}
	}

	public function selectDistinct($argTblName, $argFields, $argCondition, $argResultType = _ID_RETURN_DATASET) {
			$funArrResults = array();
			$cntrMsgs = 0;

			$query  = "SELECT DISTINCT ". join(',', $argFields) ." FROM ". $argTblName .' '. $argCondition;
			$this->query = " [Query: ". $query . "]";

			if (!$funExecute = mysql_query($query, self::$linkDB)) {
				$this->logError(mysql_error());
				throw new DBException(mysql_error() . $this->query);
				//return false;
			}
			else {
				$qryCounter = "SELECT FOUND_ROWS() AS totalmessages";
				if (!$rsCntMsgs = mysql_query($qryCounter, self::$linkDB)) {
					$this->logError(mysql_error());
					throw new DBException(mysql_error() . $this->query);
					//return false;
				}
				else {
					$dataCntMsgs = mysql_fetch_object($rsCntMsgs);
					$cntrMsgs = $dataCntMsgs->totalmessages;
				}
				if($argResultType == _ID_RETURN_DATASET) {
					$j = 0;
					$funFieldsCnt = count($argFields);

					while($funResults = mysql_fetch_assoc($funExecute)) {
						for($i=0; $i<$funFieldsCnt; $i++) {
							$funArrResults[$j][$argFields[$i]] = $funResults[$argFields[$i]];
						}
						$j++;
					}
					return $funArrResults;
					}
					else {
						return $funExecute;
					}
			}
	}

	/// To execute the insert query
    /**
     * Purpose: To execute the insert query
     *
     * Input Params:
     *   1. $argTblName - str - table name
     *   2. $argFields - array - fields list
	 *   3. $argFieldsValue -  array - values for the fields to insert
     *
     * Output Params: none
     * Return Value: boolean
     *
     */
	public function insert($argTblName, $argFields, $argFieldsValue) {
		if(count($argFields) == count($argFieldsValue)) {
			$funQuery  = 'INSERT INTO '. $argTblName .'('. join(',', $argFields) .') VALUES ('. join(',', $argFieldsValue) .')';
			$this->query = " [Query: ". $funQuery . "]";

			if (!mysql_query($funQuery, self::$linkDB)) {
				$this->logError(mysql_error() . $this->query);
				//return false;
				throw new DBException(mysql_error() . $this->query);
			}
			else {
				//return mysql_insert_id(self::$linkDB);
				return true;
			}
		}
		else {
			//return false;
			$this->logError(_ID_MSG_QUERY_INSERT_FIELDSMISATCH);
			throw new QueryException(_ID_MSG_QUERY_INSERT_FIELDSMISATCH);
		}
	}

	/// To execute the update query
    /**
     * Purpose: To execute the update query
     *
     * Input Params:
     *   1. $argTblName - str - table name
     *   2. $argFields - array - fields list
	 *   3. $argFieldsValue -  array - values for the fields to insert
	 *   4. $argCondition - string - where condition
     *
     * Output Params: none
     * Return Value: boolean
     *
     */
	public function update($argTblName, $argFields, $argFieldsValue, $argCondition) {
		$funQuery	= "";
		if(trim($argCondition) != "" && count($argFields) == count($argFieldsValue)) {
			$funQuery	= "UPDATE ". $argTblName ." SET ";

			foreach($argFields as $funKey => $funVal) {
				$funQuery  .= $funVal .'='. $argFieldsValue[$funKey] .', ';
			}

			$funQuery = rtrim($funQuery, ', '). $argCondition;
			$this->query = " [Query: ". $funQuery . "]";

			if (!mysql_query($funQuery, self::$linkDB)) {
				$this->logError(mysql_error() . $this->query);
				//return false;
				throw new DBException(mysql_error() . $this->query);
			}
			else {
				//return mysql_affected_rows(self::$linkDB);
				return true;
			}
		}
		else{
			//return false;
			$this->logError(_ID_MSG_QUERY_UPDATE_FIELDSMISATCH .' or '. _ID_MSG_QUERY_UPDATE_CONDITIONMISSING);
			throw new QueryException(_ID_MSG_QUERY_UPDATE_FIELDSMISATCH .' or '. _ID_MSG_QUERY_UPDATE_CONDITIONMISSING);
		}
	}

	/// To execute the delete query
    /**
     * Purpose: To execute the delete query
     *
     * Input Params:
     *   1. $argTblName - str - table name
	 *   2. $argCondition - string - where condition
     *
     * Output Params: none
     * Return Value: boolean
     *
     */
	public function delete($argTblName, $argCondition) {
		$funQuery	= "";
		if (trim($argCondition) != "") {
			$funQuery  = "DELETE FROM ". $argTblName . $argCondition;
			$this->query = " [Query: ". $funQuery . "]";
			//echo $funQuery; return;

			if (!mysql_query($funQuery, self::$linkDB)) {
				$this->logError(mysql_error() . $this->query);
				//return false;
				throw new DBException(mysql_error() . $this->query);
			}
			else{
				//return mysql_affected_rows(self::$linkDB);
				return true;
			}
		}
		else{
			//return false;
			$this->logError(_ID_MSG_QUERY_DELETE_CONDITIONMISSING);
			throw new QueryException(_ID_MSG_QUERY_DELETE_CONDITIONMISSING);
		}
	}

	/// To log the error messages to log file
    /**
     * Purpose: To log the error messages to log file
     *
     * Input Params:
     *   1. $argMsg - str - message to log
     *
     * Output Params: none
     * Return Value: none
     *
     */
	private function logError($argMsg) {
		//echo $argMsg;
		$varMsg = "[". date("Y-m-d h:i:s A", time()) ."]: ". $argMsg . $this->query ."\r\n" ;

		 if (!$handle = fopen(_ID_DB_LOG_FILE, 'a')) {
             echo "Cannot open file ". _ID_DB_LOG_FILE;
             exit;
         }

         if (fwrite($handle, $varMsg) === FALSE) {
            echo "Cannot write to file ". _ID_DB_LOG_FILE;
            exit;
         }

         fclose($handle);
	}

}
