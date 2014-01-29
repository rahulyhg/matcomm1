<?php


$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once $varRootBasePath ."/lib/clsCache.php";

$key = $_GET['key'];

$data = Cache::getData($key);

print_r($data);


