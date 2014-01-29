<?php

include_once('/home/product/community/www/payment/ip2location.php');

$varSpecialCountries = array('DZ','AO','BJ','BW','BF','BI','CM','CV','CF','TD','KM','CI','CG','DJ','EG','GQ','ER','ET','GA','GM','GH','GN','GW','KE','LS','LR','LY','MG','MW','ML','MR','MU','YT','MA','MZ','NA','NE','NG','CG','RW','SH','SN','SC','SL','SO','ZA','SD','SZ','TZ','TG','TN','UG','ZM','ZW');

function getCountry($argIP) {

$ip = IP2Location_open("/usr/local/ip2location/IP-COUNTRY-REGION-CITY.BIN", 20);
$record = IP2Location_get_all($ip, $argIP);
return $record;

}


?>