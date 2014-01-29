<?php

/**
 * @file
 * File: clsTwitter.php
 * Version: 1.1
 *
 *  Creator: Ilayaraja M
 *  Created On: Oct 23, 2009
 *  Updated On: Oct 28, 2009
 *
 *  Purpose : To talk with Twitter API for various requests
 *
 *  Object functions
 *  init()
 *  sendDirectMessage()
 *  getUserTimeLine()
 *  showFriendship()
 *  isFriendshipExists()
 *  followUser()
 *  unfollowUser()
 *  processRequest()
 *
 *  Notes:
 *  Edit the constant variables to set the username / password and other configuration.
 *
 *
**/


// library includes
$docRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$docRoot = ($docRoot == "")?"/home/product/community/ability":$docRoot;

include_once $docRoot ."/conf/twitter/conf.php";

class Twitter {

	private $userName;
	private $password;
	private $arTwiterURLs;
	private $responseFormat;
	private $requestMethod;
	private $debug;
	private $headers;

	public function __tostring() {
		return "clsTwitter.php Version 1.1";
	}

	/// Class constructor.
    /**
     * Purpose: Class constructor
     *
     * Input Params: none
     * Output Params: none
     * Return Value:  none
	 *
	 * Note: To inilitize the member variables
     *
     */
	public function __construct() {
		$this->userName = _ID_TWITTER_USERNAME;
		$this->password = _ID_TWITTER_PASSWORD;
		$this->debug = _ID_TWITTER_DEBUG_MODE;

		#$this->responseFormat = _ID_TWITTER_DEFAULT_RESPONSE_FORMAT;
		#$this->requestMethod = _ID_TWITTER_REQUEST_METHOD_POST;
		$this->init(_ID_TWITTER_REQUEST_METHOD_POST, _ID_TWITTER_DEFAULT_RESPONSE_FORMAT);

		// headers needs to send to Twitter
		$this->headers = array('Expect:', 'X-Twitter-Client: ','X-Twitter-Client-Version: ','X-Twitter-Client-URL: ');

		// List of REST API calls
		$this->arTwiterURLs = array(
			'friendships_exists' => "http://twitter.com/friendships/exists.%s?user_a=%s&user_b=%s",
			'friendships_create' => "http://twitter.com/friendships/create/%s.%s?follow=true",
			'friendships_destroy' => "http://twitter.com/friendships/destroy/%s.%s",
			'friendships_show' => "http://twitter.com/friendships/show.%s?source_screen_name=%s&target_screen_name=%s",
			'statuses_user_timeline' => "http://twitter.com/statuses/user_timeline/%s.%s?since_id=%s",
			'direct_messages_new' => "http://twitter.com/direct_messages/new.%s",
			'account_rate_limit_status' => "http://twitter.com/account/rate_limit_status.%s",
			'users_show' => "http://www.twitter.com/users/show.%s?screen_name=%s",
		);

	}

	public function checkUserAccount($argTwitterId) {
		$this->requestMethod = _ID_TWITTER_REQUEST_METHOD_GET;
		$url = sprintf($this->arTwiterURLs['users_show'], _ID_TWITTER_RESPONSE_FORMAT_JSON, $argTwitterId);

		$rs = $this->processRequest($url);

		return $rs;

	}

	public function getHitBalance() {
		$this->requestMethod = _ID_TWITTER_REQUEST_METHOD_GET;
		$url = sprintf($this->arTwiterURLs['account_rate_limit_status'], _ID_TWITTER_RESPONSE_FORMAT_XML);

		$rs = $this->processRequest($url);

		return $rs;
	}

	/// To initiate some required members
    /**
     * Purpose: To send direct message to user
     *
     * Input Params:
     *   1. $argRequestMethod - str - request method
     *   2. $argResponseFormat - str - response format
     *
     * Output Params: none
     * Return Value: none
     *
     */
	private function init($argRequestMethod = _ID_TWITTER_REQUEST_METHOD_POST, $argResponseFormat = _ID_TWITTER_DEFAULT_RESPONSE_FORMAT) {
		$this->responseFormat = $argResponseFormat;
		$this->requestMethod = $argRequestMethod;
	}

	/// To send direct message to user
    /**
     * Purpose: To send direct message to user
     *
     * Input Params:
     *   1. $argMsg - str - the message what needs to send.
     *   2. $argUser - str - to whome the message has to send.
     *
     * Output Params: none
     * Return Value: Twitter API retururn value.
     *
     */
	public function sendDirectMessage($argMsg, $argUser) {
		$url = sprintf($this->arTwiterURLs['direct_messages_new'], _ID_TWITTER_RESPONSE_FORMAT_JSON);
		$arPost = array("user" => $argUser, "text" => $argMsg);
		return $this->processRequest($url, $arPost);
	}

	/// To get user updates
    /**
     * Purpose: To get user updates
     *
     * Input Params:
     *   1. $argUser - str - owner of the messages.
     *   2. $argSinceID - int - lattest id of the message.
     *
     * Output Params: none
     * Return Value: Twitter API retururn value.
     *
     */
	public function getUserTimeLine($argUser, $argSinceID = 1) {
		$this->init(_ID_TWITTER_REQUEST_METHOD_GET, _ID_TWITTER_RESPONSE_FORMAT_XML);
		//$this->requestMethod = _ID_TWITTER_REQUEST_METHOD_GET;
		//$this->responseFormat = _ID_TWITTER_RESPONSE_FORMAT_XML;

		$url = sprintf($this->arTwiterURLs['statuses_user_timeline'], $argUser, _ID_TWITTER_RESPONSE_FORMAT_XML, $argSinceID);
		//echo $url ."<br>";
		$rs = $this->processRequest($url);
		//var_dump($rs);
		return $rs;
	}

	/// To get relationship between two users
    /**
     * Purpose: To get relationship between two users
     *
     * Input Params:
     *   1. $argUser - str - with whome want to check the relationship.
     *
     * Output Params: none
     * Return Value: Twitter API retururn value.
     *
     */
	public function showFriendship($argUser) {
		$this->requestMethod = _ID_TWITTER_REQUEST_METHOD_GET;

		$url = sprintf($this->arTwiterURLs['friendships_show'], _ID_TWITTER_RESPONSE_FORMAT_JSON, $this->userName, $argUser);
		$relationship = json_decode($this->processRequest($url), true);

		if($relationship['relationship']['target']['following']) {
			return true;
		}
		else {
			return false;
		}
	}

	/// To check whether specified user is following you or not
    /**
     * Purpose: To check whether specified user is following you or not
     *
     * Input Params:
     *   1. $argUser - str - with whome want to check the status.
     *
     * Output Params: none
     * Return Value: Twitter API retururn value.
     *
     */
	public function isFriendshipExists($argUser) {
		$this->requestMethod = _ID_TWITTER_REQUEST_METHOD_GET;

		$url = sprintf($this->arTwiterURLs['friendships_exists'], _ID_TWITTER_RESPONSE_FORMAT_JSON, $this->userName, $argUser);
		return $this->processRequest($url);
	}

	/// To follow a specified user
    /**
     * Purpose: To follow a specified user
     *
     * Input Params:
     *   1. $argUser - str - the user that the system user wants to follow
     *
     * Output Params: none
     * Return Value: Twitter API retururn value.
     *
     */
	public function followUser($argUser) {
		if(!$this->processRequest) {
			$url = sprintf($this->arTwiterURLs['friendships_create'], $argUser, _ID_TWITTER_RESPONSE_FORMAT_JSON);
			//return $this->processRequest($url);
			if($this->processRequest($url) === false) {
				return false;
			}
			else {
				return true;
			}
		}
		else {
			return false;
		}
	}

	/// To unfollow a specified user
    /**
     * Purpose: To unfollow a specified user
     *
     * Input Params:
     *   1. $argUser - str - the user that the system user wants to unfollow
     *
     * Output Params: none
     * Return Value: Twitter API retururn value.
     *
     */
	public function unfollowUser($argUser) {
		$url = sprintf($this->arTwiterURLs['friendships_destroy'], $argUser, _ID_TWITTER_RESPONSE_FORMAT_JSON);
		//return $this->processRequest($url);
		if($this->processRequest($url) === false) {
			return false;
		}
		else {
			return true;
		}
	}

	/// To process the Twitter API request
    /**
     * Purpose: To process the Twitter API requestr
     *
     * Input Params:
     *   1. $argURL - str - REST URL
	 *   2. argPost - array - post values
     *
     * Output Params: none
     * Return Value: Twitter API retururn value.
	 *
	 * Note:
	 *    It uses CURL to process the Twitter API's REST calls.
	 *    In debug mode this method will outputs the header status
     *
     */
	private function processRequest($argURL, $argPost = false) {
		// create the connection with twiter using CURL
		$con = curl_init($argURL);

		// check the request method is post then add the post the fields
		if($this->requestMethod === _ID_TWITTER_REQUEST_METHOD_POST) {
			curl_setopt ($con, CURLOPT_POST, true);
			curl_setopt ($con, CURLOPT_POSTFIELDS, $argPost);
		}

		// set the user name and password
		curl_setopt($con, CURLOPT_USERPWD, $this->userName .':'. $this->password );

		// to validate success of the curl-channel
		curl_setopt($con, CURLOPT_RETURNTRANSFER, true);

		// show the ouputs
		curl_setopt($con, CURLOPT_VERBOSE, 0);

		// check the mode is for debug then set the header on
		if($this->debug) {
			curl_setopt($con, CURLOPT_HEADER, false);
		}

		// to follow the redirects
		curl_setopt($con, CURLOPT_FOLLOWLOCATION, 1);

		// set the header
		curl_setopt($con, CURLOPT_HTTPHEADER, $this->headers);

		// ececute the request
		$response = curl_exec($con);

		// collect the response information
		$responseInfo = curl_getinfo($con);

		// close the connection
		curl_close($con);
			//echo $responseInfo['http_code'];
		 // for debug mode display the headers and response
		 if( $this->debug) {
			$debug = preg_split("#\n\s*\n|\r\n\s*\r\n#m", $response);
			echo'<pre>' . $debug[0] . '</pre>'; 
			var_dump($response);
		 }

		 $result["status"] = $responseInfo['http_code'];
		 $result["response"] = $response;

		return $result;


	}

}