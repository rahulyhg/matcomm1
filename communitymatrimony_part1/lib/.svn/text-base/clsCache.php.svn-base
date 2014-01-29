<?php
/**
 * @file
 * File: cslCache.php
 * Version: 2.0.1.2
 *
 *  Creator: Ilayaraja M
 *  Created On: Oct 07, 2009
 *  Updated On: Oct 14, 2009
 *
 *  Purpose : To handle multiple hosts Memcached server using PHP extension
 *
 *  Object functions
 *  i. getInstance()
 *  ii. setData()
 *  iii. getData()
 *  iv. deleteData()
 *  v. addData()
 *  vi. replaceData()
 *  vii. logError()
 *  viii. getLogData()
 *  ix. clearLogData()
 *
 *  Notes:
 *  // Server settings
 *  Edit getInstance() method and define the list of memcached servers in an array in $arServers variable
 *
 * // Log settings
 * Edit log file constant @ LOGFILE 
 *
 *  //usage
 *  //store the variable
 *  Cache::setData('key','abc');
 *
 *  //fetch the value by it's key
 *  echo Cache::getData('key');
 *
 *  //delete the data
 *  echo Cache::deleteData('key');
 *
 *
**/

/* ============== Constant Variables =============== */
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath	= $varRootBasePath=='' ? '/home/product/community' : $varRootBasePath;
include_once $varRootBasePath ."/conf/memcache.cil14"; 


class Cache {

    //======== member variables =========
    private $objMem;
    static public $objInstance;
    const LOGFILE = _ID_LOGFILE;

	public function __tostring() {
		return "clsCache.php Version 2.0.1.2";
	}

    /// Class constructor.
    /**
     * Purpose: Class constructor
     *
     * Input Params:
     *   1. $arServers - array - array of server and ports.
     *
     * Output Params: none
     * Return Value:  none
     *
     */
     private function __construct($arServers) {
         if (!$arServers){
            trigger_error('No memcache servers to connect', E_USER_WARNING);
         }

         if (extension_loaded(memcache)) {
             $this->objMem = new Memcache;
             foreach($arServers as $host => $port) {
                     $this->objMem->addServer($host, $port, _ID_PERSISTENT_CONNECTION);
             }

             $arServersStats = $this->objMem->getExtendedStats();
             foreach($arServersStats as $host => $status) {
                  if(!$status) {
                       self::logError("Unable to connect to the host: ". $host ."\n\r");
                  }
             }
         }
         else {
			 self::logError('Memcache extension not available.');
             trigger_error('Memcache extension not available', E_USER_WARNING);
         }
     }

     /// To return an instance of class
      /**
     * Purpose: To return an instance of class
     *
     * Input Params:
     *   1. $argHostName - str - Point to the host where memcached is listening for connections.
     *   2. $argPort - int - Point to the port where memcached is listening for connections.
     *
     * Output Params: none
     * Return Value: Object of the Memcache.
     *
     */
     static public function getInstance() {
	global $arServers;

        self::$objInstance || self::$objInstance = new Cache($arServers);
        return self::$objInstance;
     }

    /// Store data at the memcached server
    /**
     * Purpose: Store data at the memcached server
     *
     * Input Params:
     * 1. argKey - string - The key that will be associated with the item.
     * 2. argValue - object - The variable to store. Strings and integers are stored as is, other types are stored serialized.
     * 3. argFlag - int - Use MEMCACHE_COMPRESSED to store the item compressed (uses zlib).
     * 4. argExpTime - int - Expiration time of the item. If its equal to zero, the item will never expire. You can also use Unix timestamp or a number of seconds starting from current time, but in the latter case the number of seconds may not exceed 2592000 (30 days).
     *
     * Output Params: none
     * Return Value:  "set" function returns TRUE on success or FALSE on failure.
     *
     * Note: First this method will try to replace the data if it fails then it will set the data to memcache to avoid duplication
     * @see: replaceMemcacheData
     *
     */
     static public function setData($argKey, $argValue, $argFlag = _ID_MEMCAHCE_COMPRESSED, $argExpTime = _ID_MEMCACHED_TIMEOUT) {
            return self::getInstance()->objMem->set($argKey, $argValue, $argFlag, $argExpTime);
     }

     /// Replace value of the existing item
    /**
     * Purpose: Replace value of the existing item
     *
     * Input Params:
     * 1. argKey - string - The key that will be associated with the item.
     * 2. argValue - object - The variable to store. Strings and integers are stored as is, other types are stored serialized.
     * 3. argFlag - int - Use MEMCACHE_COMPRESSED to store the item compressed (uses zlib).
     * 4. argExpTime - int - Expiration time of the item. If its equal to zero, the item will never expire. You can also use Unix timestamp or a number of seconds starting from current time, but in the latter case the number of seconds may not exceed 2592000 (30 days).
     *
     * Output Params: none
     *
     * Return Value:  "replace" function returns TRUE on success or FALSE on failure.
     *
     * Notes: This method will get called by setMemcacheData method
     * @see: setMemcacheData
     *
     */
     static public function replaceData($argKey, $argValue, $argFlag = _ID_MEMCAHCE_COMPRESSED, $argExpTime = _ID_MEMCACHED_TIMEOUT) {
         return self::getInstance()->objMem->replace($argKey, $argValue, $argFlag, $argExpTime);
     }

     /// Add an item to the server
    /**
     * Purpose: Add an item to the server
     *
     * Input Params:
     * 1. argKey - string - The key that will be associated with the item.
     * 2. argValue - object - The variable to store. Strings and integers are stored as is, other types are stored serialized.
     * 3. argFlag - int - Use MEMCACHE_COMPRESSED to store the item compressed (uses zlib).
     * 4. argExpTime - int - Expiration time of the item. If its equal to zero, the item will never expire. You can also use Unix timestamp or a number of seconds starting from current time, but in the latter case the number of seconds may not exceed 2592000 (30 days).
     *
     * Output Params: none
     * Return Value:  "add" function returns TRUE on success or FALSE on failure. Returns FALSE if such key already exist.
     *
     */
     static public function addData($argKey, $argValue, $argFlag = _ID_MEMCAHCE_COMPRESSED, $argExpTime = _ID_MEMCACHED_TIMEOUT) {
         return self::getInstance()->objMem->add($argKey, $argValue, $argFlag, $argExpTime);
     }

    /// Get data from the memcached server
    /**
     * Purpose: Get data from the memcached server
     *
     * Input Params:
     * 1. argKey - string -The key or array of keys to fetch.
     *
     * Output Params: none
     * Return Value:  "get" function returns the string associated with the key  or FALSE on failure or if such key  was not found.
     *
     */
     static public function getData($argKey) { 
         return self::getInstance()->objMem->get($argKey);
     }

    /// Delete item from the memcached server
    /**
     * Purpose: Delete item from the memcached server
     *
     * Input Params:
     * 1. argKey - string -The key associated with the item to delete.
     * 2. argTimeout - int - Execution time of the item. If it's equal to zero, the item will be deleted right away whereas if you set it to 30, the item will be deleted in 30 seconds.
     *
     * Output Params: none
     * Return Value:  "delete" function returns TRUE on success or FALSE on failure.
     *
     */
     static public function deleteData($argKey, $argTimeout = _ID_MEMCACHED_DELETE_TIME) {
         $rs = self::getInstance()->objMem->delete($argKey, $argTimeout);
		 return $rs;
		 self::logError($argKey ." deleted. Returned ". $rs ."\r\n");
     }

     /// Log error message to file
    /**
     * Purpose: Log error message to file
     *
     * Input Params: 
     * 1. $argMessage - string - Error message
     *
     * Output Params: none
     * Return Value:  none
     *
     */
     static public function logError($argMessage) {
         if (!$handle = fopen(self::LOGFILE, 'a')) {
             echo "Cannot open file ". self::LOGFILE;
             exit;
         }

         if (fwrite($handle, $argMessage) === FALSE) {
            echo "Cannot write to file ". self::LOGFILE;
            exit;
         }

         fclose($handle);
     }

	 /// Read Log error messages from file
    /**
     * Purpose: Read Log error messages from file
     *
     * Input Params: none
     * Output Params: none
     * Return Value:  File contentes as string
     *
     */
	 static public function getLogData() {
		$strLog = "";
		$arLog = file(self::LOGFILE, FILE_SKIP_EMPTY_LINES);

		foreach ($arLog as $lineNum => $line) {
			$strLog .=  "Line #<b>{". $lineNum ."}</b> : " . htmlspecialchars($line) . "<br />\n";
		}

		return $strLog;
	 }

	 /// Remove Log error messages from file
    /**
     * Purpose: Remove Log error messages from file
     *
     * Input Params: none
     * Output Params: none
     * Return Value:  none
     *
     */
	 static public function clearLogData() {
		 if (!$handle = fopen(self::LOGFILE, 'w')) {
             echo "Cannot open file ". self::LOGFILE;
             exit;
         }

         if (fwrite($handle, "\r\n") === FALSE) {
            echo "Cannot write to file ". self::LOGFILE;
            exit;
         }

         fclose($handle);
	 }



} // end class
