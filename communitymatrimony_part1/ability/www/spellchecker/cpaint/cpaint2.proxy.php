<?php

require_once("cpaint2.config.php");
	
  error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING); 
  set_time_limit(0);
  
  if ($_GET['cpaint_remote_url'] != "") {
    $cp_remote_url      = urldecode($_GET['cpaint_remote_url']);
    $cp_remote_method   = urldecode($_GET['cpaint_remote_method']);
    $cp_remote_query    = urldecode($_GET['cpaint_remote_query']);
    $cp_response_type   = strtoupper($_GET['cpaint_response_type']);
  }

  if ($_POST['cpaint_remote_url'] != "") {
    $cp_remote_url      = urldecode($_POST['cpaint_remote_url']);
    $cp_remote_method   = urldecode($_POST['cpaint_remote_method']);
    $cp_remote_query    = urldecode($_POST['cpaint_remote_query']);
    $cp_response_type   = strtoupper($_POST['cpaint_response_type']);
  }

  if ($cp_response_type == 'XML'
    || $cp_response_type == 'OBJECT') {
    header("Content-type:  text/xml");
  }

  if ($cp_remote_method == 'GET') {
    $cp_remote_url    .= '?' . $cp_remote_query;
    $cp_request_body  = '';

    $url_parts  = parse_url($cp_remote_url);
  
    $cp_request_header  = 'GET ' . $url_parts['path'] . '?' . str_replace(' ', '+', $url_parts['query']) . " HTTP/1.0\r\n"
                        . "Host: " . $url_parts['host'] . "\r\n";
  
  } elseif ($cp_remote_method == 'POST') {
    $cp_request_body  = '&' . $cp_remote_query;

    $url_parts  = parse_url($cp_remote_url);
		
		if ($cpaint2_config["proxy.security.use_whitelist"] == true) {
			$url_allowed = false;
			foreach($cpaint2_proxy_whitelist as $whitelistURL) {
				$whiteList_parts = parse_url("http://" . $whitelistURL);
				$url_parts_temp = parse_url("http://" . $cp_remote_url);
				if (array_key_exists("path", $whiteList_parts)) {
					if ((strtolower($whiteList_parts["path"]) == strtolower($url_parts_temp["path"])) && (strtolower($whiteList_parts["host"]) == strtolower($url_parts_temp["host"]))) $url_allowed = true;					
				} else {	// no path, check only host
					if (strtolower($whiteList_parts["host"]) == strtolower($url_parts_temp["host"]))	$url_allowed = true;
				}
			}
			if ($url_allowed == false) die("[CPAINT] The host or script cannot be accessed through this proxy.");
		}
    
    
    $cp_request_header  = 'POST ' . $url_parts['path']  . " HTTP/1.0\r\n"
                        . "Host: " . $url_parts['host'] . "\r\n"
                        . "Content-Type:  application/x-www-form-urlencoded\r\n";
  }

  
  if (!isset($url_parts['port'])) {
    $url_parts['port'] = 80;
  }

  
  $cp_request_header .= "Content-Length: " . strlen($cp_request_body) . "\r\n";

  
  if ($url_parts['user'] != '') {
    $cp_request_header .= 'Authorization: Basic ' . base64_encode($url_parts['user'] . ':' . $url_parts['pass']) . "\r\n";
  }

  
  $cp_socket = @fsockopen($url_parts['host'], $url_parts['port'], $error, $errstr, 10);
  
  if ($cp_socket !== false) {
    
    @fwrite($cp_socket, $cp_request_header . "\r\n\r\n");
    
   
    if ($cp_request_body != '') {
      @fwrite($cp_socket, $cp_request_body . "\r\n");
    }
    
    while (!feof($cp_socket)) {
      $http_data = $http_data . fgets($cp_socket);
    }

    list($http_headers, $http_body) = split("\r\n\r\n", $http_data, 2);
    echo($http_body);
    @fclose($cp_socket);
  }

?>