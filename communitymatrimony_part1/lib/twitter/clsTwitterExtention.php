<?php

/**
 * @file
 * File: clsTwitterExtention.php
 * Version: 3.3
 *
 *  Creator: Ilayaraja M
 *  Created On: Oct 23, 2009
 *  Updated On: Dec 22, 2009
 *
 *  Purpose : To make communication between Twitter API library and DB library
 *
 *  Object methods
 *  getTwitterAccountId()
 *  checkTwitterAccountId()
 *  setTwitterAccountId()
 *  addTwitterAccount()
 *  updateTwitterAccount()
 *  unsetTwitterAccountId()
 *  getTwitterMessages()
 *  getTwitterMessagesByTwitterId()
 *  getPortalMessages()
 *  getAllMessages()
 *  getPortalMessages()
 *  getPortalMatriIds()
 *  setMessageApproval()
 *  deleteTwitterMessages()
 *  deleteTwitterMessagesByMatriId()
 *  getLattestTwitterMessageId()
 *  unsetTwitterAccount()
 *  updateTwitterPosts()
 *  setLastUpdatedId()
 *  getLastUpdatedID()
 *  getHitBalance()
 *  removeNonApprovedTweets()
 *  removeOldTweets()
 *  logError()
 *
 *  Notes:
 *  Class in this file extends DB class
 *
 *
**/

$docRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$docRoot = ($docRoot == "")?"/home/product/community":$docRoot;

include_once $docRoot ."/conf/twitter/conf.php";

// library includes
include_once "clsDB.php";
include_once "clsTwitter.php";



class TwitterExtention extends DB {

	private $twitter;

	public function __tostring() {
		return "TwitterExtention Version 3.3";
	}

	/// Class constructor.
    /**
     * Purpose: Class constructor
     *
     * Input Params: none
     * Output Params: none
     * Return Value:  none
	 *
	 * Note: This constructor inilitize Twitter Object
     *
     */
	public function __construct() {
		$this->twitter = new Twitter;
		DB::connectDB();
	}

	/// To get Twitter account name of an user
    /**
     * Purpose: To get Twitter account name of an user
     *
     * Input Params:
     *   1. $argMatriId - str - User id
     *
     * Output Params: none
     * Return Value: Twitter Id.
     *
     */
	public function getTwitterAccountId($argMatriId) {
		if(trim($argMatriId) == "") {
			throw new ArgumentException(_ID_MSG_NO_MATRI_ID);
		}

		$varTable = _ID_TWITTERAC_TABLE;
		$varFields = array("twitterid");
		$varCondition = " WHERE matriid = '". $argMatriId ."' LIMIT 1";

		try {
			$rs = $this->select($varTable, $varFields, $varCondition, _ID_RETURN_DATASET);
			if(!$rs) {
				//return false;
				throw new NoTwitterAccountException(_ID_MSG_NO_TWITTER_ACCOUNT . $argMatriId);
			}
			else {
				return $rs[0]['twitterid'];
			}
		}
		catch(DBException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}
	}

        /// To get matriids of twitterid
    /**
     * Purpose: To get matriids of twitterid
     *
     * Input Params:
     *   1. $argTwitterId - str - User id
     *
     * Output Params: none
     * Return Value: MatriId.
     *
     */
        public function getMatriIdByTwitterId($argTwitterId) {
                if(trim($argTwitterId) == "") { 
                        throw new ArgumentException(_ID_MSG_NO_MATRI_ID);
                }

                $varTable = _ID_TWITTERAC_TABLE;
                $varFields = array("matriid");
                $varCondition = " WHERE twitterid = '". $argTwitterId ."' ";

                try { 
                        $rs = $this->select($varTable, $varFields, $varCondition, _ID_RETURN_DATASET);
                        if(!$rs) {
                                //return false;
                                throw new NoTwitterAccountException(_ID_MSG_NO_TWITTER_ACCOUNT . $argTwitterId);
                        }
                        else {
                                return $rs;
                        }
                }
                catch(DBException $e) {
                        throw new Exception(_ID_MSG_SERVER_ERROR);
                }
        }

	private function checkTwitterAccountId($argTwitterId) {
		$this->twitter->checkUserAccount($argTwitterId);
	}

	/// To set Twitter account of an user (add / update)
    /**
     * Purpose: To set Twitter account of an user (add / update)
     *
     * Input Params:
     *   1. $argMatriId - str - Matri id
	 *   2. $argTwitteId - str - twitter id
     *
     * Output Params: none
     * Return Value: Twitter Id.
     *
     */
	public function setTwitterAccountId($argMatriId, $argTwitterId, $argPortalId) {
		if(trim($argMatriId) == "") {
			throw new ArgumentException(_ID_MSG_NO_MATRI_ID);
		}
		
		if(trim($argTwitterId) == "") {
			throw new ArgumentException(_ID_MSG_NO_TWITTER_ID);
		}

		if(!(is_numeric($argPortalId)) || $argPortalId < 1) {
			throw new ArgumentException(_ID_MSG_PORTALID_ERROR);
		}

		$rs = false;
		$userRs = $this->twitter->checkUserAccount($argTwitterId);
		if($userRs['status'] == 200) {
			$userRes = json_decode($userRs['response']);
			if(!$userRes->protected) {
				try {
					$this->getTwitterAccountId($argMatriId);
					$rs = $this->updateTwitterAccount($argMatriId, $argTwitterId, $argPortalId);
				}
				catch(NoTwitterAccountException $e) {
					$rs = $this->addTwitterAccount($argMatriId, $argTwitterId, $argPortalId);
				}
				catch(DBException $e) {
					throw new Exception(_ID_MSG_SERVER_ERROR);
				}

				return $rs;
			}
			else {
				throw new UserAccountException(_ID_MSG_TWITTER_ID_PROTECTED);
			}
		}
		else if($userRs['status'] == 400 || $userRs['status'] == 401 || $userRs['status'] == 420 || $userRs['status'] == 500 || $userRs['status'] == 502 || $userRs['status'] == 503) {
			throw new Exception(_ID_MSG_SERVER_ISSUE);
		}
		else {
			throw new UserAccountException(_ID_MSG_TWITTER_ID_INVALID);
		}
	}

	/// To add a Twitter account to our DB
    /**
     * Purpose: To add a Twitter account to our DB
     *
     * Input Params:
     *   1. $argMatriId - str - User id
	 *   2. $argTwitteId - str - Twitter id
     *
     * Output Params: none
     * Return Value: boolean
     *
     */
	private function addTwitterAccount($argMatriId, $argTwitterId, $argPortalId) {
		if(trim($argMatriId) == "") {
			throw new ArgumentException(_ID_MSG_NO_MATRI_ID);
		}
		
		if(trim($argTwitterId) == "") {
			throw new ArgumentException(_ID_MSG_NO_TWITTER_ID);
		}

		$rs = false;
		$varTable = _ID_TWITTERAC_TABLE;
		$varFields = array("matriid", "twitterid", "portalid");
		$varValues = array("'". $argMatriId ."'", "'". $argTwitterId ."'", $argPortalId);

		try {
			$rs = $this->insert($varTable, $varFields, $varValues);
		}
		catch(QueryException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}

		return $rs;
	}

	/// To update a Twitter account from our DB
    /**
     * Purpose: To update a Twitter account from our DB
     *
     * Input Params:
     *   1. $argMatriId - str - User id
	 *   2. $argTwitteId - str - Twitter id
     *
     * Output Params: none
     * Return Value: boolean
     *
     */
	private function updateTwitterAccount($argMatriId, $argTwitterId, $argPortalId) {
		if(trim($argMatriId) == "") {
			throw new ArgumentException(_ID_MSG_NO_MATRI_ID);
		}
		
		if(trim($argTwitterId) == "") {
			throw new ArgumentException(_ID_MSG_NO_TWITTER_ID);
		}

		$rs = false;
		$varTable = _ID_TWITTERAC_TABLE;
		$varFields = array("twitterid");
		$varValues = array("'". $argTwitterId ."'");
		$varCondition = " WHERE matriid = '". $argMatriId ."' AND portalid = ". $argPortalId;

		try {
			$rs = $this->update($varTable, $varFields, $varValues, $varCondition);
		}
		catch(QueryException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}

		return $rs;
	}

	/// To delete a Twitter account from our DB
    /**
     * Purpose: To delete a Twitter account from our DB
     *
     * Input Params:
     *   1. $argMatriId - str - list of matri ids
     *
     * Output Params: none
     * Return Value: boolean
     *
     */
	public function unsetTwitterAccountId($argMatriId) {
		if(trim($argMatriId) == "") { 
			throw new ArgumentException(_ID_MSG_NO_MATRI_ID);
		}

		$rs = $this->deleteTwitterMessagesByMatriId($argMatriId);
		
		$rs = false;
		$varTable = _ID_TWITTERAC_TABLE;
		$varMatriIds = "'";
		$varMatriIds .= str_replace(",", "','", $argMatriId);
		$varMatriIds .= "'";

		$varCondition = " WHERE matriid IN(". $varMatriIds .") ";

		try {
			$rs = $this->delete($varTable, $varCondition);
		}
		catch(DBException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}
		catch(QueryException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}

		return $rs;
	}

	/// To get Twitter messages for a matridi from DB
    /**
     * Purpose: To get Twitter messages for a matriid from DB
     *
     * Input Params:
     *   1. $argMatriId - str - matriid id of an user
	 *   2. $argMsgType - int - type of message (all, approved or non approved)
	 *   3. $argQryLimit - int - limit of of query result set
     *
     * Output Params: none
     * Return Value: array of messages.
     *
     */
	public function getTwitterMessages($argMatriId, $argMsgType = _ID_APPROVED_TWITTER_MSG, $argQryLimit = _ID_MAX_TWITTER_MSG) {
		if(trim($argMatriId) == "") {
			throw new ArgumentException(_ID_MSG_NO_MATRI_ID);
		}
		
		$rs = false;
		
		$varTwitterId = $this->getTwitterAccountId($argMatriId);

		$arFields = array("id", "twitterid", "msg", "created_at", "status");
		$varCondition = " WHERE twitterid = '". $varTwitterId ."' ";
		switch($argMsgType) {
			default:
				$varCondition .= " AND status = ". _ID_APPROVED_TWITTER_MSG;
				break;
			case _ID_NON_APPROVED_TWITTER_MSG:
				$varCondition .= " AND status = ". _ID_NON_APPROVED_TWITTER_MSG;
				break;
			case _ID_ALL_TWITTER_MSG:
				$varCondition .= "";
				break;
		}
		$varCondition .= " ORDER BY msgid DESC LIMIT ".$argQryLimit;

		try {
			$rs = $this->select(_ID_TWITTERMSG_TABLE, $arFields, $varCondition, _ID_RETURN_DATASET);
		}
		catch(DBException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}

		$result['twitterId'] = $varTwitterId;
		$result['messages'] = $rs;

		return $result;
	}

	/// To get Twitter messages for a twitterid from DB
    /**
     * Purpose: To get Twitter messages for a twitter id from DB
     *
     * Input Params:
     *   1. $argMatriId - str - twitter id of an user
	 *   2. $argMsgType - int - type of message (all, approved or non approved)
	 *   3. $argQryLimit - int - limit of of query result set
     *
     * Output Params: none
     * Return Value: array of messages.
     *
     */
	public function getTwitterMessagesByTwitterId($argTwitterId, $argPortalId, $argMsgType = _ID_APPROVED_TWITTER_MSG, $argQryLimit = _ID_MAX_TWITTER_MSG) {
		if(trim($argTwitterId) == "") {
			throw new ArgumentException(_ID_MSG_NO_TWITTER_ID);
		}
		if(!(is_numeric($argPortalId)) || $argPortalId < 1) {
			throw new ArgumentException(_ID_MSG_PORTALID_ERROR);
		}
		
		$rs = false;

		$arFields = array("matriid");
		$varCondition = " WHERE twitterid = '". $argTwitterId ."' AND portalid = ". $argPortalId;

		try {
			$rs['matriid'] = $this->select(_ID_TWITTERAC_TABLE, $arFields, $varCondition, _ID_RETURN_DATASET);
		}
		catch(DBException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}

		if(count($rs['matriid']) > 0) {
		
			$arFields = array("id", "twitterid", "msg", "created_at", "status");
			$varCondition = " WHERE twitterid = '". $argTwitterId ."' ";

			switch($argMsgType) {
				default:
					$varCondition .= " AND status = ". _ID_APPROVED_TWITTER_MSG;
					break;
				case _ID_NON_APPROVED_TWITTER_MSG:
					$varCondition .= " AND status = ". _ID_NON_APPROVED_TWITTER_MSG;
					break;
				case _ID_ALL_TWITTER_MSG:
					$varCondition .= "";
					break;
			}
			$varCondition .= " ORDER BY msgid DESC LIMIT ".$argQryLimit;

			try {
				$rs['messages'] = $this->select(_ID_TWITTERMSG_TABLE, $arFields, $varCondition, _ID_RETURN_DATASET);
			}
			catch(DBException $e) {
				throw new Exception(_ID_MSG_SERVER_ERROR);
			}
		}
		else {
			$rs['messages'] = 'No messages';
		}

		return $rs;
	}

	/// To get Twitter messages for a portal id from DB
    /**
     * Purpose: To get Twitter messages for a portal id from DB
     *
     * Input Params:
     *   1. $argPortalId - str - portal id of an user
	 *   2. $argMsgType - int - type of message (all, approved or non approved)
	 *   3. $argMsgStart - int - message start id
	 *   4. argMsgEnd - int - message end id
     *
     * Output Params: none
     * Return Value: array of messages.
     *
     */
	public function getPortalMessages($argPortalId, $argMsgType = _ID_APPROVED_TWITTER_MSG, $argMsgStart = _ID_MSG_START, $argMsgEnd = _ID_MSG_END, $argMsgHour = _ID_MSG_LASTHOUR ) {
		if(!(is_numeric($argPortalId)) || $argPortalId < 1) {
			throw new ArgumentException(_ID_MSG_PORTALID_ERROR);
		}

		$rs = false;
		$twitterIds = "";

		$matriIds = $this->getPortalMatriIds($argPortalId);
		$cntMatriIds = count($matriIds);
		if($cntMatriIds < 1) {
			throw new Exception(_ID_MSG_PORTAL_NO_TWITTERS);
		}
		//print_r($matriIds);
		for($i=0, $j = $cntMatriIds; $i < $j; $i++) {
			$twitterIds .= "'". $matriIds[$i]['twitterid'] ."', ";

		}
		$twitterIds = substr($twitterIds, 0, (strlen($twitterIds) - 2));
		//echo $twitterIds;
		$arFields = array("id", "twitterid", "msg", "created_at", "status");
		$varCondition = " WHERE twitterid IN (". $twitterIds .")";
		if($argMsgHour) {
			$varCondition .= " AND DateInserted >= (NOW() - INTERVAL ". $argMsgHour ." HOUR)";
		}
		else {
			switch($argMsgType) {
				default:
					$varCondition .= " AND status = ". _ID_APPROVED_TWITTER_MSG;
					break;
				case _ID_NON_APPROVED_TWITTER_MSG:
					$varCondition .= " AND status = ". _ID_NON_APPROVED_TWITTER_MSG;
					break;
				case _ID_ALL_TWITTER_MSG:
					$varCondition .= "";
					break;
			}
			$varConditionLimit .= " LIMIT ". $argMsgStart .", ". $argMsgEnd;
		}

		try {
			$rs = $this->selectWithCounter(_ID_TWITTERMSG_TABLE, $arFields, $varCondition . $varConditionLimit, _ID_RETURN_DATASET);
			foreach($rs as $key => $tweet) {
				if(is_numeric($key)) {
					$rs[$key]['matriid'] = $this->getMatriIdByTwitterId($tweet['twitterid']);
				}
			}
		}
		catch(DBException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}

		return $rs;
	}

	/// To get all twitter messages for debug / validate
    /**
     * Purpose: To get all twitter messages for debug / validate
     *
     * Input Params:
     *   1. $argMsgType - int - Message type
	 *   2. $argMsgStart - int - Message start number
	 *   3. $argMsgEnd - int - message end numebr
     *
     * Output Params: none
     * Return Value: array of messages.
     *
     */
	public function getAllMessages($argMsgType = _ID_APPROVED_TWITTER_MSG, $argMsgStart = _ID_MSG_START, $argMsgEnd = _ID_MSG_END) {
		if($argMsgStart < 0 || $argMsgEnd < 0) {
			throw new ArgumentException(_ID_MSG_LIMIT_SHOUD_GREATER);
		}

		$rs = false;
		
		$arFields = array("id", "twitterid", "msg", "created_at", "status");
		$varCondition = " WHERE  status = ". $argMsgType;

		$varCondition .= " LIMIT ". $argMsgStart .", ". $argMsgEnd;

		try {
			$rs = $this->selectWithCounter(_ID_TWITTERMSG_TABLE, $arFields, $varCondition, _ID_RETURN_DATASET);
		}
		catch(DBException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}

		return $rs;
	}

	/// To get all MatriIds for a portal
    /**
     * Purpose: To get all MatriIds for a portal
     *
     * Input Params:
     *   1. $argPortalId - int - Portal Id
     *
     * Output Params: none
     * Return Value: array of Matri Ids.
     *
     */
	public function getPortalMatriIds($argPortalId) {
		if(!(is_numeric($argPortalId)) || $argPortalId < 1) {
			throw new ArgumentException(_ID_MSG_PORTALID_ERROR);
		}

		$rs = false;
		
		$arFields = array("matriid", "twitterid");
		$varCondition = " WHERE status = 1 AND portalid = ". $argPortalId;

		try {
			$rs = $this->selectDistinct(_ID_TWITTERAC_TABLE, $arFields, $varCondition, _ID_RETURN_DATASET);
		}
		catch(DBException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}

		return $rs;
	}

	/// To change the status field (message approval) column of Twitter messages table
    /**
     * Purpose: To change the status field (message approval) column of Twitter messages table
     *
     * Input Params:
     *   1. $argApproveMsgs - str - list of messages to get approved
	 *   2. $argNotApproveMsgs - str - list of messages to un approved
     *
     * Output Params: none
     * Return Value: boolean
     *
     */
	public function setMessageApproval($argApproveMsgs = "", $argNotApproveMsgs = "",  $argVerifiedBy = "") {
		if(trim($argVerifiedBy) == "") {
			throw new ArgumentException(_ID_MSG_NO_VERIFIEDBY_ID);
		}

		if(trim($argApproveMsgs) == "" && trim($argNotApproveMsgs) == "") { 
			throw new ArgumentException(_ID_MSG_NO_MESSAGES_ID);
		}

		$rs = false;
		$varTable = _ID_TWITTERMSG_TABLE;
		$varFields = array("status", "verified_by");
		
		if($argApproveMsgs) {
			$varApproveMsgs = "'";
			$varApproveMsgs .= str_replace(",", "','", $argApproveMsgs);
			$varApproveMsgs .= "'";
			$varValues = array(_ID_APPROVED_TWITTER_MSG, "'". $argVerifiedBy ."'");
			$varCondition = " WHERE id IN(". $varApproveMsgs .")";

			try {
				$rs = $this->update($varTable, $varFields, $varValues, $varCondition);
			}
			catch(DBException $e) {
				throw new Exception(_ID_MSG_SERVER_ERROR);
			}
			catch(QueryException $e) {
				throw new Exception(_ID_MSG_SERVER_ERROR);
			}
		}

		if($argNotApproveMsgs) {
			$varNotApproveMsgs = "'";
			$varNotApproveMsgs .= str_replace(",", "','", $argNotApproveMsgs);
			$varNotApproveMsgs .= "'";
			$varValues = array(_ID_REJECTED_TWITTER_MSG, "'". $argVerifiedBy ."'");
			$varCondition = " WHERE id IN(". $varNotApproveMsgs .")";

			try {
				$rs = $this->update($varTable, $varFields, $varValues, $varCondition);
			}
			catch(DBException $e) {
				throw new Exception(_ID_MSG_SERVER_ERROR);
			}
			catch(QueryException $e) {
				throw new Exception(_ID_MSG_SERVER_ERROR);
			}
		}

		return $rs;
	}

	/// To delete Twitter messages based on Message ids from our DB
    /**
     * Purpose: To delete Twitter messages based on Message ids from our DB
     *
     * Input Params:
     *   1. $argMsgId - str - list of message id
     *
     * Output Params: none
     * Return Value: boolean
     *
     */
	public function deleteTwitterMessages($argMsgId) {
		 if(trim($argMsgId) == "") {
			throw new ArgumentException(_ID_MSG_NO_MESSAGE_ID);
		}

		$rs = false;
		$varTable = _ID_TWITTERMSG_TABLE;
		$varMsgIds = "'";
		$varMsgIds .= str_replace(",", "','", $argMsgId);
		$varMsgIds .= "'";

		$varCondition = " WHERE id IN(". $varMsgIds .") ";

		try {
			$rs = $this->delete($varTable, $varCondition);
		}
		catch(DBException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}
		catch(QueryException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}

		return $rs;
	}

	/// To delete Twitter messages based on Matri ids from our DB
    /**
     * Purpose: To delete Twitter messages based on Matri ids from our DB
     *
     * Input Params:
     *   1. $argTwitterId - str - list of matri ids
     *
     * Output Params: none
     * Return Value: boolean
     *
     */
	public function deleteTwitterMessagesByMatriId($argMatriId, $argFlag = false) {
		if(trim($argMatriId) == "") { 
			throw new ArgumentException(_ID_MSG_NO_MATRI_ID);
		}

		$rs = false;
		$varTable = _ID_TWITTERMSG_TABLE;

		$varMatriIds = explode(",", $argMatriId);

		$varTwitterIds = "";
		for($i = 0, $j = count($varMatriIds); $i < $j; $i++) {
			//echo "<br>".$varMatriIds[$i];
			if($argFlag && trim($varMatriIds[$i]) == "") {
				continue;
			}
			$varTwitterIds .= "'". $this->getTwitterAccountId($varMatriIds[$i]) ."',";
		}
		$varTwitterIds = substr($varTwitterIds, 0, (strlen($varTwitterIds) - 1));

		$varCondition = " WHERE twitterid IN(". $varTwitterIds .") ";

		try {
			$rs = $this->delete($varTable, $varCondition);
		}
		catch(DBException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}
		catch(QueryException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}

		return $rs;
	}

	/// To get lattest Twitter message id of a Twitter id from DB
    /**
     * Purpose: To get lattest Twitter message id of a Twitter id from DB
     *
     * Input Params:
     *   1. $argTwitterId - str - twitter id of an user
     *
     * Output Params: none
     * Return Value: Message Id.
     *
     */
	private function getLattestTwitterMessageId($argTwitterId) {	
		if(trim($argTwitterId) == "") {
			throw new ArgumentException(_ID_MSG_NO_TWITTER_ID);
		}

		$rs = false;
		$varTable = _ID_TWITTERMSG_TABLE;
		$varFields = array("msgid");
		$varCondition = " WHERE twitterid = '". $argTwitterId ."' ORDER BY msgid DESC LIMIT 1 ";

		try {
			$rs = $this->select($varTable, $varFields, $varCondition, _ID_RETURN_DATASET);
		}
		catch(DBException $e) {
			throw new DBException($e->getMessage);
		}

		return $rs[0]['msgid'];
	}

	/// To delete twitterid from DB
    /**
     * Purpose: To delete twitterid from DB
     *
     * Input Params: $argTwitterID
     * Output Params: none
     * Return Value: none.
     *
     */
	private function unsetTwitterAccount($argTwitterID) {
		$varTable = _ID_TWITTERAC_TABLE;
		$varFields = array("status");
		$varValues = array(0);
		$varCondition = " WHERE twitterid = '". $argTwitterID ."' ";

		try {
			$rs = $this->update($varTable, $varFields, $varValues, $varCondition);
		}
		catch(QueryException $e) {
			throw new Exception(_ID_MSG_SERVER_ERROR);
		}
	}

	/// To get messages from Twitter for each account and update the DB
    /**
     * Purpose: To get messages from Twitter for each account and update the DB
     *
     * Input Params: none
     *
     * Output Params: The messages and Id
     * Return Value: none.
     *
     */
	public function updateTwitterPosts() { 
		$lastId = $this->getLastUpdatedID();
		$lastId = ($lastId)?$lastId:0;
		$varTable = _ID_TWITTERAC_TABLE;
		$varFields = array("id", "twitterid");
		$varCondition = " WHERE twitterid != '' AND status = 1 ORDER BY id LIMIT ". $lastId .", ". _ID_TOTAL_API_REQUEST;
		$errorMsg = "";

		try { // try 1
			$arTwitterId = $this->selectDistinct($varTable, $varFields, $varCondition, _ID_RETURN_DATASET); 
			$cntTwitterId = count($arTwitterId);
			for($ti = 0; $ti < $cntTwitterId; $ti++) {
				$twitterId = trim($arTwitterId[$ti]['twitterid']);
				try { // try 2
					$sinceId = $this->getLattestTwitterMessageId($twitterId);
					$sinceId = ($sinceId)?$sinceId:1;

					$messages = $this->twitter->getUserTimeLine($twitterId, $sinceId);
					$messages['status'] ."\r\n<br>";
					$objMessages = new SimpleXMLElement($messages["response"]);
					if($messages['status'] == 400 || $messages['status'] == 500 || $messages['status'] == 502 || $messages['status'] == 503) {	 // api limit exceed or bad request
						$this->logError($objMessages->error);
						throw new Exception($objMessages->error);
						return;
					} // api limit exceed
					else if($messages['status'] == 401 || $messages['status'] == 403 || $messages['status'] == 404) {	 // other error like not found forbidden
						$this->unsetTwitterAccount($twitterId);
						$this->logError($twitterId ." ". $objMessages->error);
						continue;
					}
					else if($messages['status'] == 200) {	// success 
						for($mi = 0, $mj = count($objMessages->status); $mi < $mj; $mi++) {
							$msg = mysql_escape_string($objMessages->status[$mi]->text);
							$createdAt = $objMessages->status[$mi]->created_at;
							$msgId = $objMessages->status[$mi]->id;
							$fields = array("twitterid", "msgid", "msg", "created_at");
							$values = array("'". $twitterId ."'", $msgId, "'".$msg."'", "'". $createdAt ."'");

							try { // try 3
								$this->insert(_ID_TWITTERMSG_TABLE, $fields, $values);
							} // try 3
							catch(QueryException $e) { // try 3
								$errorMsg = "Error while insert the Twitter messages into table. ". $e->getMessage();
								$this->logError($errorMsg);
							} // try 3
							catch(DBException $e) { // try 3
								$errorMsg = "Error while insert the Twitter messages into table.  ". $e->getMessage();
								$this->logError($errorMsg);
							} // try 3
						} // objmessages status for loop end
					} // success
					else {
						$this->logError($twitterId ." ". $objMessages->error);
						continue;
					}
				} // try 2
				catch(DBException $e) { // try 2
					$errorMsg = "Error while select the lattest Twitter message id for a twitter id from table. ". $e->getMessage();
					$this->logError($errorMsg);
				} // try 2
				catch(Exception $e) { // try 2
					$errorMsg = "Error with Twitter id ". $twitterId ." : ". $e->getMessage();
					$this->logError($errorMsg);
				} // try 2
			} // twitter id for loop end

			$lastUpdatedId = ($cntTwitterId == _ID_TOTAL_API_REQUEST)?($lastId + _ID_TOTAL_API_REQUEST):0;
			$this->setLastUpdatedId($lastUpdatedId);
		} // try 1
		catch(DBException $e) { // try 1
			$errorMsg = "Error while select the twitter ids from table. ". $e->getMessage();
			$this->logError($errorMsg);
		} // try 1

	} // method end

	/// To set last updated twitter id number to file
    /**
     * Purpose: To set last updated twitter id numbr to file
     *
     * Input Params: $argId
     * Output Params: none
     * Return Value: none.
     *
     */
	private function setLastUpdatedId($argId) {
		if (!$handle = fopen(_ID_DB_LASTUPDATE_LOG, 'w')) {
             echo "Cannot open file ". _ID_DB_LASTUPDATE_LOG;
             exit;
         }

         if (fwrite($handle, $argId) === FALSE) {
            echo "Cannot write to file ". _ID_DB_LASTUPDATE_LOG;
            exit;
         }

         fclose($handle);
		
	}

	/// To get last updated twitter id numbr from file
    /**
     * Purpose: To get last updated twitter id numbr from file
     *
     * Input Params: none
     * Output Params: none
     * Return Value: $id.
     *
     */
	private function getLastUpdatedID() {
		if (!$handle = fopen(_ID_DB_LASTUPDATE_LOG, 'r')) {
             echo "Cannot open file ". _ID_DB_LASTUPDATE_LOG;
             exit;
         }
		$id = fgets($handle);
        fclose($handle);

		return $id;
	}

	/// To get number of hits balance for Twitter API 
    /**
     * Purpose: To get number of hits balance for Twitter API
     *
     * Input Params: none
     * Output Params: none
     * Return Value: none.
     *
     */
	public function getHitBalance() {
		$messages = $this->twitter->getHitBalance();
		echo $messages = json_decode($messages["response"]);
		//print_r($messages);
		if(isset($messages->error)) {
			throw new Exception($messages->error);
		}
		//return $messages;
	}

	/// To delete non approved tweets from db
    /**
     * Purpose: To delete non approved tweets from db
     *
     * Input Params: none
     * Output Params: none
     * Return Value: none.
     *
     */
	public function removeNonApprovedTweets() {
		$varTable = _ID_TWITTERMSG_TABLE;
		$varCondition = " WHERE status = -9";
		$errorMsg = "";

		try {
			$rs = $this->delete($varTable, $varCondition);
		}
		catch(DBException $e) { // try 1
			$errorMsg = "Error while delete the non approved messages. ". $e->getMessage();
			$this->logError($errorMsg);
		}
	}

	/// To delete old messages from DB for each account
    /**
     * Purpose: To delete old messages from DB for each account
     *
     * Input Params: 
	 *   1. $argLimit - int - how many messages should kept fo reach account
     *
     * Output Params: The messages and Id
     * Return Value: none.
     *
     */
	public function removeOldTweets($argLimit) {
		$varTable = _ID_TWITTERAC_TABLE;
		$varFields = array("twitterid");
		$varCondition = " WHERE twitterid != '' ";
		$errorMsg = "";

		try { // try 1
			// collect tiwtter ids
			$arTwitterId = $this->select($varTable, $varFields, $varCondition, _ID_RETURN_DATASET);
			$strIds = "";
			$varTable = _ID_TWITTERMSG_TABLE;
			$varFields = array("id");

			for($ti = 0, $tj = count($arTwitterId); $ti < $tj; $ti++) {	 // twitter id for loop start
				try { // try 2	
					// collect message ids for each twitter id
					$varCondition = " WHERE twitterid = '". $arTwitterId[$ti]['twitterid'] ."' ORDER BY id DESC LIMIT ". $argLimit;
					$rsId = $this->select($varTable, $varFields, $varCondition, _ID_RETURN_RESULTSET);
					
					while($data = mysql_fetch_object($rsId)) {
						$strIds .= $data->id .", ";
					}

				} // try 2
				catch(DBException $e) { // try 2
					$errorMsg = "Error while select the lattest Twitter message id for a twitter id from table for delete. ". $e->getMessage();
					$this->logError($errorMsg);
				} // try 2

			} // twitter id for loop end

			// combine all messages id seperated by comma
			$strIds = substr($strIds, 0, (strlen($strIds) - 2));

			if($strIds) {
				try {	// try 3
					$varTable = _ID_TWITTERMSG_TABLE;
					$varCondition = " WHERE id NOT IN (". $strIds .") ";
					$rsId = $this->delete($varTable, $varCondition);
				}	// try 3
				catch(DBException $e) {	// try 3
					$errorMsg = "Error while delete the old Twitter messagse from table. ". $e->getMessage();
					$this->logError($errorMsg);
				}	// try 3
			}

		} // try 1
		catch(DBException $e) { // try 1
			$errorMsg = "Error while select the twitter ids from table fro delete. ". $e->getMessage();
			$this->logError($errorMsg);
		} // try 1
	}

	/// To log the Errors to log file
    /**
     * Purpose: To log the Errors to log file
     *
     * Input Params: 
	 *   1. $argMsg - String - Log message
     *
     * Output Params: none
     * Return Value: none.
     *
     */
	private function logError($argMsg) {
		$varMsg = "[". date("Y-m-d h:i:s A", time()) ."]: ". $argMsg ."\r\n" ;

		 if (!$handle = fopen(_ID_CRON_LOG_FILE, 'a')) {
             echo "Cannot open file ". _ID_CRON_LOG_FILE;
             exit;
         }

         if (fwrite($handle, $varMsg) === FALSE) {
            echo "Cannot write to file ". _ID_CRON_LOG_FILE;
            exit;
         }

         fclose($handle);
	}

}

