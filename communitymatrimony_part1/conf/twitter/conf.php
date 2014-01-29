<?php

/**
 * @file
 * File: conf.php
 * Version: 1.0
 *
 *  Creator: Ilayaraja M
 *  Created On: Oct 29, 2009
 *  Updated On:
 *
 *  Purpose : To declare the constant variables
 *
 *
**/

// Authentication
define("_ID_ENABLE_AUTHENTICATION", true);
define("_ID_HTTP_USER", "cbs_tweet");
define("_ID_HTTP_PASS", "t8e3e3w9t8_1s7b2c2");


// Twitter
define("_ID_TWITTER_USERNAME", "cbs_tweet");
define("_ID_TWITTER_PASSWORD", "t8e3e3w9t8_1s7b2c2");
define("_ID_TWITTER_DEBUG_MODE", false);
define("_ID_TWITTER_RESPONSE_FORMAT_JSON", "json");
define("_ID_TWITTER_RESPONSE_FORMAT_XML", "xml");
define("_ID_TWITTER_DEFAULT_RESPONSE_FORMAT", _ID_TWITTER_RESPONSE_FORMAT_JSON);
define("_ID_TWITTER_REQUEST_METHOD_POST", "POST");
define("_ID_TWITTER_REQUEST_METHOD_GET", "GET");

// OAuth conf
/*define('CONSUMER_KEY', 'KRg2KyKZNpuWwj3ErOeBdQ');
define('CONSUMER_SECRET', 'VoE74DyYQ4n73u4az1hQtYQcyuaqlmqt8QU4R2SF7o');
define('OAUTH_TOKEN', '84292060-isL1sPdzI1laM7Ny8vwW9Cxs3o1oN8UhZMzBotTsD');
define('OAUTH_TOKEN_SECRET', 'LSRJ3TSCjCp6wR9G4GrBLYjJIyWms7tIMyML9PZf4');
define('OAUTH_VERSION', '1.0');*/
define('CONSUMER_KEY', '9XjqVl0leR2RLpV4xR7tpA');
define('CONSUMER_SECRET', 'SuwQ61CuflE5YsviK8LcjDsQikeUHHfxjQktyBDwk');
define('OAUTH_TOKEN', '95373838-xnlxyTNId18tgDe6PYt45zfyxJyzohB1tlfp0LNvk');
define('OAUTH_TOKEN_SECRET', 'CD4A5ZQwnSd1hsTArx6fXcuxy0XhtIMBT0KduBs');
define('OAUTH_VERSION', '1.0');

// TwitterExtention
define("_ID_NON_APPROVED_TWITTER_MSG", 0);
define("_ID_ALL_TWITTER_MSG", -1);
define("_ID_APPROVED_TWITTER_MSG", 1);
define("_ID_REJECTED_TWITTER_MSG", -9);
define("_ID_MAX_TWITTER_MSG", 20);
define("_ID_MSG_START", 0);
define("_ID_MSG_END", 20);
define('_ID_TOTAL_API_REQUEST', 1000);
define("_ID_TWEETS_LIMIT", 20);
define("_ID_MSG_LASTHOUR", 0);

// DB
define("_ID_DB_HOST", "172.29.23.95");
define("_ID_DB_HOST_SLAVE", "172.29.23.96");
define("_ID_DB_USERNAME", "User4Cbs");
define("_ID_DB_PASSWORD", "3rmMWua4");
define("_ID_DB_DATABASE", "twittermessage");
define("_ID_TWITTERMSG_TABLE", "twittermessages");
define("_ID_TWITTERAC_TABLE", "twitteraccounts");
define("_ID_RETURN_DATASET", 1);
define("_ID_RETURN_RESULTSET", 0);

// log
define("_ID_CRON_LOG_FILE", "/tmp/twitter/twittercronlog.txt");
define("_ID_DB_LOG_FILE", "/tmp/twitter/twitterlog.txt");
define("_ID_DB_LASTUPDATE_LOG", "/tmp/twitter/tuid");

// Server
define("_ID_REQUEST_METHOD_POST", "POST");
define("_ID_REQUEST_METHOD_GET", "GET");


// Response fields
define("_ID_RESPONSE_FIELD_ACTION", "action");
define("_ID_RESPONSE_FIELD_STATUS", "status");
define("_ID_RESPONSE_FIELD_ERROR", "Error");
define("_ID_RESPONSE_FIELD_MATRIID", "matriId");
define("_ID_RESPONSE_FIELD_TWITTERID", "twitterId");
define("_ID_RESPONSE_FIELD_MESSAGETYPE", "msgType");
define("_ID_RESPONSE_FIELD_MESSAGELIMIT", "msgLimit");
define("_ID_RESPONSE_FIELD_NUMBEROFMESSAGES", "numberOfMessages");
define("_ID_RESPONSE_FIELD_MESSAGES", "messages");
define("_ID_RESPONSE_FIELD_MESSAGES_MESSAGEID", "id");
define("_ID_RESPONSE_FIELD_MESSAGES_TWITTERACCOUNT", "twitterid");
define("_ID_RESPONSE_FIELD_MESSAGES_TWITTERMESSAGEID", "msgid");
define("_ID_RESPONSE_FIELD_MESSAGES_MESSAGE", "msg");
define("_ID_RESPONSE_FIELD_MESSAGES_CREATEDAT", "created_at");
define("_ID_RESPONSE_FIELD_MESSAGES_STATUS", "status");
define("_ID_RESPONSE_FIELD_MESSAGEID", "msgIds");
define("_ID_RESPONSE_FIELD_APPROVEMESSAGESID", "approveMsgs");
define("_ID_RESPONSE_FIELD_UNAPPROVEMESSAGESID", "notApproveMsgs");
define("_ID_RESPONSE_FIELD_VERIFIEDBY", "verifiedBy");
define("_ID_RESPONSE_FIELD_MESSAGESTART", "msgStart");
define("_ID_RESPONSE_FIELD_MESSAGEEND", "msgEnd");
define("_ID_RESPONSE_FIELD_TOTALMESSAGES", "totalMessages");
define("_ID_RESPONSE_FIELD_PORTALID", "portalId");
define("_ID_RESPONSE_FIELD_MSGHOUR", "msgHour");

// Request fields
define("_ID_REQUEST_FIELD_ACTION", "action");
define("_ID_REQUEST_FIELD_MATRIID", "matriid");
define("_ID_REQUEST_FIELD_TWITTERID", "twitterid");
define("_ID_REQUEST_FIELD_MESSAGETYPE", "msgtype");
define("_ID_REQUEST_FIELD_MESSAGELIMIT", "msglimit");
define("_ID_REQUEST_FIELD_APPROVEMESSAGESID", "amsgid");
define("_ID_REQUEST_FIELD_UNAPPROVEMESSAGESID", "namsgid");
define("_ID_REQUEST_FIELD_MESSAGEID", "msgid");
define("_ID_REQUEST_FIELD_VERIFIEDBY", "verifiedby");
define("_ID_REQUEST_FIELD_MESSAGESTART", "msgstart");
define("_ID_REQUEST_FIELD_MESSAGEEND", "msgend");
define("_ID_REQUEST_FIELD_PORTALID", "portalid");
define("_ID_REQUEST_FIELD_MSGHOUR", "msghour");

// Request mthods
define("_ID_REQUEST_METHOD_GETTWITTERACCOUNTID", "gettwitteraccountid");
define("_ID_REQUEST_METHOD_GETTWITTERMESSAGES", "gettwittermessages");
define("_ID_REQUEST_METHOD_GETALLMESSAGES", "getallmessages");
define("_ID_REQUEST_METHOD_SETTWITTERACCOUNTID", "settwitteraccountid");
define("_ID_REQUEST_METHOD_UNSETTWITTERACCOUNTID", "unsettwitteraccountid");
define("_ID_REQUEST_METHOD_SETMESSAGEAPPROVAL", "setmessageapproval");
define("_ID_REQUEST_METHOD_DELETETWITTERMESSAGES", "deletetwittermessages");
define("_ID_REQUEST_METHOD_DELETETWITTERMESSAGESBYMATRIID", "deletetwittermessagesbymatriid");
define("_ID_REQUEST_METHOD_GETPORTALMATRIIDS", "getportalmatriids");
define("_ID_REQUEST_METHOD_GETTWITTERMESSAGESBYTWITTERID", "gettwittermessagesbytwitterid");
define("_ID_REQUEST_METHOD_GETPORTALMESSAGES", "getportalmessages");

// portal information
define('_ID_PORTAL_CBS', 1);
define('_ID_PORTAL_BM', 2);
define('_ID_PORTAL_CJ', 3);
define('_ID_PORTAL_IP', 4);

// Error Messages
define("_ID_MSG_SERVER_ERROR", "Problem with server, please conatct server admin");
define("_ID_MSG_SERVER_ISSUE", "Sorry, unable to update due to server issues. Please try again later.");

define("_ID_MSG_NO_TWITTER_ACCOUNT", "No Twitter Account Id for the Matri Id ");

define("_ID_MSG_QUERY_INSERT_FIELDSMISATCH", "Fields and Field values are mismatched");
define("_ID_MSG_QUERY_UPDATE_FIELDSMISATCH", "Fields and Field values are mismatched");
define("_ID_MSG_QUERY_UPDATE_CONDITIONMISSING", "Condition missing for update query");
define("_ID_MSG_QUERY_DELETE_CONDITIONMISSING", "Condition missing for delete query");

define("_ID_MSG_NO_MATRI_ID", "Matri Id was empty");
define("_ID_MSG_NO_TWITTER_ID", "Twitter Id was empty");
define("_ID_MSG_NO_MESSAGE_ID", "Message Id was empty");
define("_ID_MSG_NO_MESSAGES_ID", "Both Approve and Non approve Message Ids empty");
define("_ID_MSG_NO_VERIFIEDBY_ID", "Verified by Id was empty");
define("_ID_MSG_LIMIT_SHOUD_GREATER", "Message Limit (start and end) should be greater than 0");

define("_ID_MSG_ONLY_GETORPOST", "Request method must be GET or POST");
define("_ID_MSG_ONLY_GET", "Request method must be GET");
define("_ID_MSG_ONLY_POST", "Request method must be POST");

define("_ID_MSG_TWITTER_ID_INVALID", "Sorry! You have entered an invalid Twitter ID.");
define("_ID_MSG_TWITTER_ID_PROTECTED", "Twitter ID Protected");

define("_ID_MSG_PORTALID_ERROR", "Provide valid Portal ID");
define("_ID_MSG_PORTAL_NO_TWITTERS", "No Twitter Id added for this portal");