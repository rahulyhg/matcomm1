<?php

/**
 * @file
 * File: clsMemcacheDB.php
 * Version: 1.0.1.3
 *
 *  Creator: Ilayaraja M
 *  Created On: Oct 08, 2009
 *  Updated On: Oct 16, 2009
 *
 *  Purpose : To get data from Memory if  not availbel it will the DB and store it in to Memory
 *
 *  Object functions
 *  i. select()
 *  ii. update()
 *  iii. delete()
 *  iv. getEmail()
 *  v. getUsername()
 *  vi. getLogData()
 *  vii. clearLogData()
 *  viii. dbConnect()
 *  ix. selectAll()
 *  x. getPageQueries()
 *  xi. clearPageQueries()
 *
 *  Note: This class has extends the DB class from clsDB.php
 *
**/


/* 
 * File Include
 */
$_CBS_IncludeFolder	= '/var/home/bharatmatrimony/www/ivrspayment/cbs';
//$_CBS_IncludeFolder	= '/home/product/community/www/IVR_Cbs_Payment';
include_once ($_CBS_IncludeFolder."/conf/memcache.cil14");
include_once ($_CBS_IncludeFolder."/lib/clsCache.php"); 
include_once ($_CBS_IncludeFolder."/lib/clsDB.php"); 

 

$arQueries = null;

Class MemcacheDB extends DB{

	public function __tostring() {
		return "clsMemcacheDB version 1.0.1.3";
	}

    /// Class constructor.
    /**
     * Purpose: Class constructor
     *
     * Input Params:
     *   1. $argHostType - string - Database host type
     *   2. $argDBName - string - Database name
     *
     * Output Params: none
     * Return Value:  none
     *
     */
    public function __construct($argHostType, $argDBName) {
		global $arQueries;
		$arQueries = null;
        //parent::dbConnect($argHostType, $argDBName);
    }
    
    /// To return the requested query result set from memory or db
      /**
     * Purpose: To return the requested query result set from memory or db
     *
     * Input Params:
     *   1. $argTblName - string - Table name
     *   2. $argFields - array- array of field names
     *   3. $argCondition - string - DB condition
     *   4. $argResultSetArr - int - result set type
     *   5. $argKey - string - memcached key
     *
     * Output Params: none
     * Return Value: Array of Result set.
     *
     */
    public function select($argTblName, $argFields, $argCondition, $argResultSetArr, $argKey = null, $argTimeLimit = _ID_MEMCACHED_TIMEOUT) {
		global $arQueries;
		$startTime = microtime(true);
		$funArrResults = null;
		$qry = "SELECT ".join(',', $argFields). " FROM ".$argTblName.' '.$argCondition;	// generate the query for tmp 

		if($argKey && _ID_ENABLE_MEMCACHED) { // memory key available
            $funArrResults = Cache::getData($argKey);

            if ($funArrResults === false) { // data not available in memory
                $funArrResults = parent::select($argTblName, $argFields, $argCondition, $argResultSetArr);
				
				if($argResultSetArr === 0) {
					$funArrResults = mysql_fetch_assoc($funArrResults);
				}
                $rs = Cache::setData($argKey, $funArrResults, _ID_MEMCAHCE_COMPRESSED, $argTimeLimit);		
				
				$msg = "[". $argKey. ": From DB]<==>[Query: ". $qry ."]";
				
            }
			else { // log the key and query
				$msg = "[". $argKey. ": From Mem - ".date('Y-m-d H:i:s')."]<==>[Query: ". $qry ."]";
			}
        }
        else { // memory key not available
            $funArrResults = parent::select($argTblName, $argFields, $argCondition, $argResultSetArr);
			if($argResultSetArr === 0 && $argKey) {
				$funArrResults = mysql_fetch_assoc($funArrResults);
			}
			$msg = "[Req for DB Query: ". $qry ."]";
        }

		$msg .= "<==>[Time: ". (microtime(true) - $startTime) ."]\r\n";
		$arQueries[] = $msg;
		//Cache::logError($msg);		// log the key and query

		return $funArrResults;
    }

    /// To remove the key from memory and call the parent update method
      /**
     * Purpose: To remove the key from memory and call the parent update method
     *
     * Input Params:
     *   1. $argTblName - string - Table name
     *   2. $argFields - array- array of field names
     *   3. $argFieldsValue - array - Array of values
     *   4. $argCondition - string - DB condition
     *   5. $argKey - string - array of memcached keys
     *
     * Output Params: none
     * Return Value: value from parent update method
     *
     */
    public function update($argTblName, $argFields, $argFieldsValue, $argCondition, $argKey = null) {
        if($argKey && _ID_ENABLE_MEMCACHED) {
			if(is_array($argKey)) {
				for($i = 0, $j = count($argKey); $i < $j; $i++) {
					Cache::deleteData($argKey[$i], _ID_MEMCACHED_DELETE_TIME);
				}
			}
			else {
				Cache::deleteData($argKey, _ID_MEMCACHED_DELETE_TIME);
			}
        }
        
        return parent::update($argTblName, $argFields, $argFieldsValue, $argCondition);
    } // update

    /// To remove the key from memory and call the parent delete method
      /**
     * Purpose: To remove the key from memory and call the parent delete method
     *
     * Input Params:
     *   1. $argTblName - string - Table name
     *   2. $argCondition - string - DB condition
     *   3. $argKey - array - array of memcached keys
     *
     * Output Params: none
     * Return Value: value from parent update method
     *
     */
    public function delete($argTblName, $argCondition, $argKey = null) {
        if($argKey && _ID_ENABLE_MEMCACHED) {
			if(is_array($argKey)) {
				for($i = 0, $j = count($argKey); $i < $j; $i++) {
					Cache::deleteData($argKey[$i], _ID_MEMCACHED_DELETE_TIME);
				}
			}
			else {
				Cache::deleteData($argKey, _ID_MEMCACHED_DELETE_TIME);
			}
        }
        
        return parent::delete($argTblName, $argCondition);
    } // delete

    /// To return the Email of an ID from memory or db
      /**
     * Purpose: To return the Email of an ID from memory or db
     *
     * Input Params:
     *   1. $argMatid - string - Unique ID
     *   2. $argKey - string - memcached key
     *
     * Output Params: none
     * Return Value: Email ID
     *
     */
    public function getEmail($argMatid, $argKey = null) {
        if($argKey && _ID_ENABLE_MEMCACHED) {
            $email = Cache::getData($argKey);
        }
        else {
            $email = parent::getEmail($argMatid);
            Cache::setData($argKey, $email, _ID_MEMCAHCE_COMPRESSED, _ID_MEMCACHED_TIMEOUT);
        }
        return $email;
    } // getEmail

    /// To return the Username of an ID from memory or db
      /**
     * Purpose: To return the Username of an ID from memory or db
     *
     * Input Params:
     *   1. $argMatid - string - Unique ID
     *   2. $argKey - string - memcached key
     *
     * Output Params: none
     * Return Value: User ID
     *
     */
    public function getUsername($argMatid, $argKey = null) {
        if($argKey && _ID_ENABLE_MEMCACHED) {
            $user = Cache::getData($argKey);
        }
        else {
            $user = parent::getEmail($argMatid);
            Cache::setData($argKey, $user, _ID_MEMCAHCE_COMPRESSED, _ID_MEMCACHED_TIMEOUT);
        }
        return $user;
    } // getUsername
	
	/// Read Log error messages from file
    /**
     * Purpose: Read Log error messages from file
     *
     * Input Params: none
     * Output Params: none
     * Return Value:  File contentes as string
     *
     */
	public function getLogData() {
		//return Cache::getLogData();
		return $this->getPageQueries();
	}

	/// To remove error messages from file
    /**
     * Purpose: To remove Log error messages from file
     *
     * Input Params: none
     * Output Params: none
     * Return Value:  none
     *
     */
	public function clearLogData() {
		//Cache::clearLogData();
		$this->clearPageQueries();
	}

	/// To call parent class dbconnect method
    /**
     * Purpose: To call parent class dbconnect method
     *
     * Input Params:
	 *   1. $argHostType - string - host type
	 *   2. $argDBName - string - db name
     * Output Params: none
     * Return Value:  none
     *
     */
	public function dbConnect($argHostType, $argDBName) {
		parent::dbConnect($argHostType, $argDBName);
	}

	/// To return the requested query result set from memory or db
      /**
     * Purpose: To return the requested query result set from memory or db
     *
     * Input Params:
     *   1. $argTblName - string - Table name
     *   2. $argCondition - string - DB condition
     *   3. $argResultSetArr - int - result set type
     *   4. $argKey - string - memcached key
     *
     * Output Params: none
     * Return Value: Array of Result set.
     *
     */
    public function selectAll($argTblName, $argCondition, $argResultSetArr, $argKey = null) {
		global $arQueries;
		$startTime = microtime(true);
		$funArrResults = null;
		$qry = "SELECT * FROM ".$argTblName.' '.$argCondition;	 // generate the query for tmp 

		if($argKey && _ID_ENABLE_MEMCACHED) { // memory key available
            $funArrResults = Cache::getData($argKey);
            if ($funArrResults === false) { // data not available in memory
                $funArrResults = parent::selectAll($argTblName, $argFields, $argCondition, $argResultSetArr);
				if($argResultSetArr === 0) {
					$funArrResults = mysql_fetch_assoc($funArrResults);
				}
                $rs = Cache::setData($argKey, $funArrResults, _ID_MEMCAHCE_COMPRESSED, _ID_MEMCACHED_TIMEOUT);		
				
				$msg = "[". $argKey. ": From DB]<==>[Query: ". $qry ."]";
            }
			else { // log the key and query
				$msg = "[". $argKey. ": From Mem]<==>[Query: ". $qry ."]";
			}
        }
        else { // memory key not available
            $funArrResults = parent::selectAll($argTblName, $argFields, $argCondition, $argResultSetArr);
			
			$msg = "[Req for DB Query: ". $qry ."]";
        }

		$msg .= "<==>[Time: ". (microtime(true) - $startTime) ."]\r\n";
		$arQueries[] = $msg;
		//Cache::logError($msg);		// log the key and query

		return $funArrResults;
    } 


	/// To read the Query log stack
    /**
     * Purpose: To read the Query log stack
     *
     * Input Params: none
     * Output Params: none
     * Return Value:  Log stack contentes as string
     *
     */
	public function getPageQueries() {
		global $arQueries;
		$strQueries = "";

		for($i = 0, $j = count($arQueries); $i < $j; $i++) {
			$strQueries .= "#". ($i + 1) .": ". $arQueries[$i] ."<br><Br>";
		}

		return $strQueries;
	}

	/// To clear the Query log stack
    /**
     * Purpose: To clear the Query log stack
     *
     * Input Params: none
     * Output Params: none
     * Return Value:  none
     *
     */
	public function clearPageQueries() {
		global $arQueries;
		$arQueries = null;
	}


} // MemcacheDB class
