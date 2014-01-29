<?php
//***************************************
// Filename		: paging.php
// Author		: Ashok kumar
//***************************************

$page = ($_GET['page']?$_GET['page']:1);

$record_count = 10;
if ( $page == 1) {
	$page = 1;
	$start_value = 0;
} else {
	$page = $_GET['page'];
	$start_value = $record_count*($page-1);
}
$no_of_pages = $total_count / $record_count;
if ( ($total_count % $record_count) != 0 ) {
	$no_of_pages = $no_of_pages + 1;
}
$no_of_pages = floor($no_of_pages);

?>