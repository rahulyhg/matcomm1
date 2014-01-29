<?php

/**
 * @file
 * File: clsTwitterServer.php
 * Version: 2.2
 *
 *  Creator: Ilayaraja M
 *  Created On: Oct 28, 2009
 *  Updated On: Dec 22, 2009
 *
 *  Purpose : To handle the http request, process and return the results, it will act like Twitter Server
 *
 *  Object functions
 *  processRequest()
 *  removeEmptyValues()
 *
 *
 *
**/

// Library Includes
include_once "clsTwitterExtention.php";
$docRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$docRoot = ($docRoot == "")?"/home/product/community/ability":$docRoot;

include_once $docRoot ."/conf/twitter/conf.php";


class TwitterServer {
	private $requestMethod;
	private $arQueryValues;
	private $objTwitterExt;

	public function __tostring() {
		return "TwitterServer Version 2.2";
	}

	/// Class constructor.
    /**
     * Purpose: Class constructor
     *
     * Input Params: none
     * Output Params: none
     * Return Value:  none
	 *
	 * Note: This constructor inilitize class members
     *
     */
	public function __construct() {
		$this->objTwitterExt = new TwitterExtention;
	}

	/// To process the request from the client
    /**
     * Purpose: To process the request from the client
     *
     * Input Params: none
     * Output Params: none
     * Return Value: result as JSON String
     *
     */
	public function processRequest() {
		// collect request variables
		$this->requestMethod = $_SERVER['REQUEST_METHOD'];
		$this->arQueryValues = $_REQUEST;
		$method = strtolower($this->arQueryValues[_ID_REQUEST_FIELD_ACTION]); 

		$matriId = $this->removeEmptyValues($this->arQueryValues[_ID_REQUEST_FIELD_MATRIID]);
		$twitterId = trim($this->arQueryValues[_ID_REQUEST_FIELD_TWITTERID]);
		$msgType = (isset($this->arQueryValues[_ID_REQUEST_FIELD_MESSAGETYPE]))?$this->arQueryValues[_ID_REQUEST_FIELD_MESSAGETYPE]:_ID_APPROVED_TWITTER_MSG;
		$msgLimit = (isset($this->arQueryValues[_ID_REQUEST_FIELD_MESSAGELIMIT]))?$this->arQueryValues[_ID_REQUEST_FIELD_MESSAGELIMIT]:_ID_MAX_TWITTER_MSG;
		$msgLimit = ($msgLimit > _ID_MAX_TWITTER_MSG)?_ID_MAX_TWITTER_MSG:$msgLimit;
		$msgStart = (isset($this->arQueryValues[_ID_REQUEST_FIELD_MESSAGESTART]))?$this->arQueryValues[_ID_REQUEST_FIELD_MESSAGESTART]:_ID_MSG_START;
		$msgEnd = (isset($this->arQueryValues[_ID_REQUEST_FIELD_MESSAGEEND]))?$this->arQueryValues[_ID_REQUEST_FIELD_MESSAGEEND]:_ID_MSG_END;
		$approveMsgs = $this->removeEmptyValues($this->arQueryValues[_ID_REQUEST_FIELD_APPROVEMESSAGESID]);
		$notApproveMsgs = $this->removeEmptyValues($this->arQueryValues[_ID_REQUEST_FIELD_UNAPPROVEMESSAGESID]);
		$msgId = $this->removeEmptyValues($this->arQueryValues[_ID_REQUEST_FIELD_MESSAGEID]);
		$verifiedBy = trim($this->arQueryValues[_ID_REQUEST_FIELD_VERIFIEDBY]);
		$portalId = $this->arQueryValues[_ID_REQUEST_FIELD_PORTALID];

		$arResult[_ID_RESPONSE_FIELD_ACTION] = $method;
		$strJsonResult = "";

		// based on the request action call the TwitterExtention method to process the request and create the result dataset array
		switch($method) {
			case _ID_REQUEST_METHOD_GETTWITTERACCOUNTID:
				if($this->requestMethod == _ID_REQUEST_METHOD_POST || $this->requestMethod == _ID_REQUEST_METHOD_GET) {
					try {
						$rs = $this->objTwitterExt->$method($matriId);
						$arResult[_ID_RESPONSE_FIELD_STATUS] = true;
						$arResult[_ID_RESPONSE_FIELD_MATRIID] = $matriId;
						$arResult[_ID_RESPONSE_FIELD_TWITTERID] = $rs;
					}
					catch(ArgumentException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(NoTwitterAccountException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(Exception $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
				}
				else {
					$arResult[_ID_RESPONSE_FIELD_ERROR] = _ID_MSG_ONLY_GETORPOST;
					$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
				}
				break;
			case _ID_REQUEST_METHOD_GETTWITTERMESSAGES: 
				if($this->requestMethod == _ID_REQUEST_METHOD_POST || $this->requestMethod == _ID_REQUEST_METHOD_GET) { 
					try {
						$rs = $this->objTwitterExt->$method($matriId, $msgType, $msgLimit);
						$arResult[_ID_RESPONSE_FIELD_STATUS] = true;
						$arResult[_ID_RESPONSE_FIELD_MATRIID] = $matriId;
						$arResult[_ID_RESPONSE_FIELD_MESSAGETYPE] = $msgType;
						$arResult[_ID_RESPONSE_FIELD_MESSAGELIMIT] = $msgLimit;
						$arResult[_ID_RESPONSE_FIELD_NUMBEROFMESSAGES] = count($rs['messages']);
						$arResult[_ID_RESPONSE_FIELD_TWITTERID] = $rs['twitterId'];
						$arResult[_ID_RESPONSE_FIELD_MESSAGES] = $rs['messages'];
					}
					catch(ArgumentException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(NoTwitterAccountException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(Exception $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
				}
				else { 
					$arResult[_ID_RESPONSE_FIELD_ERROR] = _ID_MSG_ONLY_GETORPOST;
					$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
				}
				break;
			case _ID_REQUEST_METHOD_GETALLMESSAGES:
				if($this->requestMethod == _ID_REQUEST_METHOD_POST || $this->requestMethod == _ID_REQUEST_METHOD_GET) { 
					try {
						$rs = $this->objTwitterExt->$method($msgType, $msgStart, $msgEnd);
						$arResult[_ID_RESPONSE_FIELD_STATUS] = true;
						$arResult[_ID_RESPONSE_FIELD_MESSAGETYPE] = $msgType;
						$arResult[_ID_RESPONSE_FIELD_MESSAGESTART] = $msgStart;
						$arResult[_ID_RESPONSE_FIELD_MESSAGEEND] = $msgEnd;
						//echo "<pre>"; print_r($rs);
						$arResult[_ID_RESPONSE_FIELD_NUMBEROFMESSAGES] = (count($rs) - 1);
						$arResult[_ID_RESPONSE_FIELD_MESSAGES] = $rs;
					}
					catch(ArgumentException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(Exception $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
				}
				else { 
					$arResult[_ID_RESPONSE_FIELD_ERROR] = _ID_MSG_ONLY_GETORPOST;
					$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
				}
				break;
			case _ID_REQUEST_METHOD_GETPORTALMESSAGES:
				if($this->requestMethod == _ID_REQUEST_METHOD_POST || $this->requestMethod == _ID_REQUEST_METHOD_GET) { 
					try {
						$rs = $this->objTwitterExt->$method($portalId, $msgType, $msgStart, $msgEnd);
						$arResult[_ID_RESPONSE_FIELD_STATUS] = true;
						$arResult[_ID_RESPONSE_FIELD_PORTALID] = $portalId;
						$arResult[_ID_RESPONSE_FIELD_MESSAGETYPE] = $msgType;
						$arResult[_ID_RESPONSE_FIELD_MESSAGESTART] = $msgStart;
						$arResult[_ID_RESPONSE_FIELD_MESSAGEEND] = $msgEnd;
						$arResult[_ID_RESPONSE_FIELD_NUMBEROFMESSAGES] = (count($rs) - 1);
						$arResult[_ID_RESPONSE_FIELD_MESSAGES] = $rs;
					}
					catch(ArgumentException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(NoTwitterAccountException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(Exception $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
				}
				else { 
					$arResult[_ID_RESPONSE_FIELD_ERROR] = _ID_MSG_ONLY_GETORPOST;
					$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
				}
				break;
			case _ID_REQUEST_METHOD_GETTWITTERMESSAGESBYTWITTERID:
				if($this->requestMethod == _ID_REQUEST_METHOD_POST || $this->requestMethod == _ID_REQUEST_METHOD_GET) { 
					try {
						$rs = $this->objTwitterExt->$method($twitterId, $portalId, $msgType, $msgLimit);
						$arResult[_ID_RESPONSE_FIELD_STATUS] = true;
						$arResult[_ID_RESPONSE_FIELD_TWITTERID] = $twitterId;
						$arResult[_ID_RESPONSE_FIELD_PORTALID] = $portalId;
						$arResult[_ID_RESPONSE_FIELD_MESSAGETYPE] = $msgType;
						$arResult[_ID_RESPONSE_FIELD_MESSAGELIMIT] = $msgLimit;
						$arResult[_ID_RESPONSE_FIELD_MATRIID] = $rs['matriid'];
						$arResult[_ID_RESPONSE_FIELD_MESSAGES] = $rs['messages'];
					}
					catch(ArgumentException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(NoTwitterAccountException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(Exception $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
				}
				else { 
					$arResult[_ID_RESPONSE_FIELD_ERROR] = _ID_MSG_ONLY_GETORPOST;
					$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
				}
				break;
			case _ID_REQUEST_METHOD_GETPORTALMATRIIDS:
				if($this->requestMethod == _ID_REQUEST_METHOD_POST || $this->requestMethod == _ID_REQUEST_METHOD_GET) { 
					try {
						$rs = $this->objTwitterExt->$method($portalId);
						$arResult[_ID_RESPONSE_FIELD_STATUS] = true;
						$arResult[_ID_RESPONSE_FIELD_PORTALID] = $portalId;
						$arResult[_ID_RESPONSE_FIELD_MATRIID] = $rs;
					}
					catch(ArgumentException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(Exception $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
				}
				else { 
					$arResult[_ID_RESPONSE_FIELD_ERROR] = _ID_MSG_ONLY_GETORPOST;
					$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
				}
				break;
			case _ID_REQUEST_METHOD_SETTWITTERACCOUNTID:
				if($this->requestMethod == _ID_REQUEST_METHOD_POST) {
					try {
						$rs = $this->objTwitterExt->$method($matriId, $twitterId, $portalId);
						$arResult[_ID_RESPONSE_FIELD_STATUS] = true;
						$arResult[_ID_RESPONSE_FIELD_MATRIID] = $matriId;
						$arResult[_ID_RESPONSE_FIELD_TWITTERID] = $twitterId;
						$arResult[_ID_RESPONSE_FIELD_PORTALID] = $portalId;
					}
					catch(ArgumentException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(UserAccountException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(Exception $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
				}
				else {
					$arResult[_ID_RESPONSE_FIELD_ERROR] = _ID_MSG_ONLY_POST;
					$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
				}
				break;
			case _ID_REQUEST_METHOD_UNSETTWITTERACCOUNTID:
			case _ID_REQUEST_METHOD_DELETETWITTERMESSAGESBYMATRIID:
				if($this->requestMethod == _ID_REQUEST_METHOD_POST) {
					try {
						$rs = $this->objTwitterExt->$method($matriId);
						$arResult[_ID_RESPONSE_FIELD_STATUS] = true;
						$arResult[_ID_RESPONSE_FIELD_MATRIID] = $matriId;
					}
					catch(ArgumentException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(Exception $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
				}
				else {
					$arResult[_ID_RESPONSE_FIELD_ERROR] = _ID_MSG_ONLY_POST;
					$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
				}
				break;
			case _ID_REQUEST_METHOD_SETMESSAGEAPPROVAL:
				if($this->requestMethod == _ID_REQUEST_METHOD_POST) { 
					try { 
						$rs = $this->objTwitterExt->$method($approveMsgs, $notApproveMsgs, $verifiedBy);
						$arResult[_ID_RESPONSE_FIELD_STATUS] = true;
						$arResult[_ID_RESPONSE_FIELD_APPROVEMESSAGESID] = $approveMsgs;
						$arResult[_ID_RESPONSE_FIELD_UNAPPROVEMESSAGESID] = $notApproveMsgs;
						$arResult[_ID_RESPONSE_FIELD_VERIFIEDBY] = $verifiedBy;
					}
					catch(ArgumentException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(Exception $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
				}
				else {
					$arResult[_ID_RESPONSE_FIELD_ERROR] = _ID_MSG_ONLY_POST;
					$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
				}
				break;
			case _ID_REQUEST_METHOD_DELETETWITTERMESSAGES:
				if($this->requestMethod == _ID_REQUEST_METHOD_POST) { 
					try {
						$rs = $this->objTwitterExt->$method($msgId);
						$arResult[_ID_RESPONSE_FIELD_STATUS] = true;
						$arResult[_ID_RESPONSE_FIELD_MESSAGEID] = $msgId;
					}
					catch(ArgumentException $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
					catch(Exception $e) {
						$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
						$arResult[_ID_RESPONSE_FIELD_ERROR] = $e->getMessage();
					}
				}
				else {
					$arResult[_ID_RESPONSE_FIELD_ERROR] = _ID_MSG_ONLY_POST;
					$arResult[_ID_RESPONSE_FIELD_STATUS] = false;
				}
				break;
		}

		// convert dataset array to JSON string
		$strJsonResult = json_encode($arResult);

		return $strJsonResult;
	}

	/// To remove the empty values from an Array
    /**
     * Purpose: To remove the empty values from an Array
     *
     * Input Params: 
	 *   1. $argArray - String - String of arguments
     * Output Params: none
     * Return Value: filtered Array
     *
     */
	private function removeEmptyValues($argArray) {
		$varArray = explode(",", $argArray);
		$varArray = array_filter($varArray);
		sort($varArray);
		return implode(",", $varArray);
	}

}
