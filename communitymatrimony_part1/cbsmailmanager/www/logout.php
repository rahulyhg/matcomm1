<?php

session_start();

session_destroy();
session_unset();
unset ($_SESSION['auth']);
unset ($_SESSION['user']);
$_SESSION['auth'] = 0;
//echo $_SESSION['auth'];
header ("Location: index.php");

?>