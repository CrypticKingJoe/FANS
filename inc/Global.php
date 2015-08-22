<?php
if (!isset($SETTINGS)) {
	die("Uninitialised.");
}

// attempt to connect to the database
try {
	$db = new PDO('mysql:host=' . $s_mysql_host . ';dbname=' . $s_mysql_dbname, $s_mysql_usname, $s_mysql_uspass);
} catch (PDOException $e) {
	die("Uninitialised.");
}

// user specific variables
$ip = $_SERVER['REMOTE_ADDR'];

// other variables
