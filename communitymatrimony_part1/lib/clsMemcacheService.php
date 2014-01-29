<?php

$varRootBasePath = "/home/product/community";
include_once $varRootBasePath ."/lib/clsCache.php";

class MemcacheService {

	public function __construct() {
	}

	public function deleteKey($argMatriId, $argTable) {
		switch(strtolower($argTable)) {
			case 'memberinfo': 
				$key = 'ProfileInfo_'. $argMatriId;
				break;
			default:
				return;
				break;
		}
		//return true;
		return Cache::deleteData($key);
	}

}