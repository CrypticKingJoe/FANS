<?php
if (!isset($SETTINGS)) {
	die("Uninitialised.");
}

function encrypt($password, $salt) {
	$format = '$2y$10$';
	$fsalt = $format . $salt;
	$encrypted = crypt($password, $fsalt);
	return $encrypted;
}

function generateSalt() {
	$rstr = md5(uniqid(mt_rand(), true));
	$b64str = base64_encode($rstr);
	$mb64str = str_replace('+', '.', $b64str);
	$salt = substr($mb64str, 0, 22);
	
	return $salt;
}

if (!defined("CRYPT_BLOWFISH") || !CRYPT_BLOWFISH) {
	die("Blowfish is not enabled in this version of PHP.<br />Please consider upgrading to PHP 5.4 or later.");
}

// attempt to connect to the database
try {
	$db = new PDO('mysql:host=' . $s_mysql_host . ';dbname=' . $s_mysql_dbname, $s_mysql_usname, $s_mysql_uspass);
} catch (PDOException $e) {
	die("Could not connect to database: " . $e->getMessage());
}

// user specific variables
$ip = $_SERVER['REMOTE_ADDR'];

// other variables
if (!isset($PAGE))
	$PAGE = "";